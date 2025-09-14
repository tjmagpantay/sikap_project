<?php
require_once __DIR__ . '/../../config/sikap_db.php';
require_once __DIR__ . '/../../vendor/autoload.php';

use Smalot\PdfParser\Parser;

class ResumeParser
{
    private $db;
    private $escoSkills;
    private $escoAliases;
    private $manualSkills;

    public function __construct()
    {
        $config = require __DIR__ . '/../../config/sikap_db.php';
        try {
            $this->db = new PDO(
                "mysql:host={$config['db_host']};dbname={$config['db_name']}",
                $config['db_user'],
                $config['db_pass']
            );
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            error_log("ResumeParser database connection failed: " . $e->getMessage());
            throw new Exception("Database connection failed");
        }

        // Load all skill data for matching (using same approach as your prototype)
        $this->loadAllSkillData();
    }

    private function loadAllSkillData()
    {
        try {
            // Load manual skills with ESCO mapping FIRST (Higher Priority)
            $stmt = $this->db->prepare("
            SELECT sd.skill_name, me.esco_skill_id, es.skill_name AS esco_name, es.concept_uri
            FROM skills_dictionary sd
            LEFT JOIN manual_to_esco me ON sd.id = me.manual_skill_id
            LEFT JOIN esco_skills es ON me.esco_skill_id = es.id
            ORDER BY sd.skill_name ASC
        ");
            $stmt->execute();
            $this->manualSkills = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $this->manualSkills[] = $row;
            }

            // Load ESCO skills (Lower Priority, Fallback only)
            $stmt = $this->db->prepare("SELECT id, skill_name, concept_uri FROM esco_skills ORDER BY skill_name ASC");
            $stmt->execute();
            $this->escoSkills = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $this->escoSkills[$row['id']] = [
                    'name' => $row['skill_name'],
                    'uri' => $row['concept_uri']
                ];
            }

            // Load ESCO aliases (Fallback only)
            $stmt = $this->db->prepare("SELECT alias, skill_id FROM esco_skill_aliases ORDER BY alias ASC");
            $stmt->execute();
            $this->escoAliases = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $this->escoAliases[strtolower($row['alias'])] = $row['skill_id'];
            }

            error_log("Loaded " . count($this->manualSkills) . " manual skills, " . count($this->escoSkills) . " ESCO skills");
        } catch (PDOException $e) {
            error_log("Error loading skill data: " . $e->getMessage());
            $this->escoSkills = [];
            $this->escoAliases = [];
            $this->manualSkills = [];
        }
    }

    public function parseResumeFile($filePath)
    {
        try {
            if (!file_exists($filePath)) {
                throw new Exception("File not found: " . $filePath);
            }

            $parser = new Parser();
            $pdf = $parser->parseFile($filePath);
            $text = $pdf->getText();

            if (empty(trim($text))) {
                throw new Exception("Could not extract text from PDF");
            }

            return $this->extractResumeData($text);
        } catch (Exception $e) {
            error_log("Resume parsing error: " . $e->getMessage());
            throw new Exception("Failed to parse resume: " . $e->getMessage());
        }
    }

    private function extractResumeData($text)
    {
        $data = [];
        $lines = explode("\n", trim($text));
        $cleanLines = array_filter(array_map('trim', $lines));

        // Extract Name
        $data['name_data'] = $this->extractName($text, $cleanLines);

        // Extract Contact Information
        $data['email'] = $this->extractEmail($text);
        $data['phone'] = $this->extractPhone($text);
        $data['address'] = $this->extractAddress($text);

        // Extract Personal Information
        $data['birthdate'] = $this->extractBirthdate($text);
        $data['gender'] = $this->extractGender($text);

        // Extract Professional Information using hybrid approach (like prototype)
        $data['skills'] = $this->extractSkillsHybrid($text);
        $data['experience'] = $this->extractWorkExperience($text);
        $data['education'] = $this->extractEducation($text);
        $data['certificates'] = $this->extractCertificates($text);

        return $data;
    }

    // Use the EXACT same hybrid skill extraction as your prototype
    private function extractSkillsHybrid($text)
    {
        $foundSkills = [];
        $foundUris = [];

        // STEP 1: Priority to Manual Skills Dictionary (More Accurate & Minimal)
        foreach ($this->manualSkills as $skill) {
            if (stripos($text, $skill['skill_name']) !== false) {
                if ($skill['esco_skill_id']) {
                    // Store mapped ESCO skill with URI
                    $foundSkills[] = $skill['esco_name'];
                    $foundUris[] = $skill['concept_uri'];
                } else {
                    // Store manual skill (no ESCO mapping yet)
                    $foundSkills[] = $skill['skill_name'];
                    $foundUris[] = null;
                }
            }
        }

        // STEP 2: Only use ESCO if we found fewer than 5 skills from manual dictionary
        if (count($foundSkills) < 5) {
            // Use stricter ESCO matching - only exact matches, no partial matches
            $escoMatches = $this->strictEscoSkillMatch($text, $this->escoSkills, $this->escoAliases);

            foreach ($escoMatches as $skillName => $uri) {
                // Avoid duplicates
                if (!in_array($skillName, $foundSkills)) {
                    $foundSkills[] = $skillName;
                    $foundUris[] = $uri;
                }
            }
        }

        // STEP 3: Deduplicate while keeping pairs aligned
        $uniqueSkills = [];
        $uniqueUris = [];
        foreach ($foundSkills as $i => $skill) {
            if (!in_array($skill, $uniqueSkills)) {
                $uniqueSkills[] = $skill;
                $uniqueUris[] = $foundUris[$i];
            }
        }

        // Limit to top 10 most relevant skills
        $uniqueSkills = array_slice($uniqueSkills, 0, 10);
        $uniqueUris = array_slice($uniqueUris, 0, 10);

        // Convert to format expected by the application
        $skills = [];
        foreach ($uniqueSkills as $i => $skillName) {
            $skills[] = [
                'skill_name' => $skillName,
                'proficiency_level' => 'Intermediate',
                'esco_uri' => $uniqueUris[$i]
            ];
        }

        return $skills;
    }

    // New stricter ESCO matching function
    private function strictEscoSkillMatch($text, $escoSkills, $escoAliases)
    {
        $matches = [];
        $text_lower = strtolower($text);

        // Define common technical skills that we want to prioritize
        $prioritySkills = [
            'javascript',
            'python',
            'java',
            'php',
            'html',
            'css',
            'react',
            'vue',
            'angular',
            'node.js',
            'express',
            'laravel',
            'django',
            'flask',
            'sql',
            'mysql',
            'postgresql',
            'mongodb',
            'git',
            'docker',
            'kubernetes',
            'aws',
            'azure',
            'linux',
            'windows',
            'agile',
            'scrum',
            'project management',
            'leadership',
            'communication',
            'problem solving',
            'teamwork',
            'critical thinking'
        ];

        // First, look for priority skills in ESCO
        foreach ($escoSkills as $id => $skill) {
            $skillName_lower = strtolower($skill['name']);

            // Check if it's a priority skill and exists in text
            foreach ($prioritySkills as $priority) {
                if (stripos($skillName_lower, $priority) !== false && stripos($text_lower, $priority) !== false) {
                    $matches[$skill['name']] = $skill['uri'];
                    break;
                }
            }
        }

        // Then look for exact word matches (not partial) for other skills
        foreach ($escoSkills as $id => $skill) {
            if (count($matches) >= 8) break; // Limit ESCO matches

            $skillName = $skill['name'];
            $skillName_lower = strtolower($skillName);

            // Skip if already found
            if (isset($matches[$skillName])) continue;

            // Use word boundary matching for exact matches only
            if (preg_match('/\b' . preg_quote($skillName_lower, '/') . '\b/', $text_lower)) {
                $matches[$skillName] = $skill['uri'];
            }
        }

        // Check aliases but be more selective
        foreach ($escoAliases as $alias => $skill_id) {
            if (count($matches) >= 8) break; // Limit total matches

            if (isset($escoSkills[$skill_id])) {
                $skillName = $escoSkills[$skill_id]['name'];

                // Skip if already found
                if (isset($matches[$skillName])) continue;

                // Only match if alias is in priority list or exact word match
                if (in_array($alias, $prioritySkills) || preg_match('/\b' . preg_quote($alias, '/') . '\b/', $text_lower)) {
                    $matches[$skillName] = $escoSkills[$skill_id]['uri'];
                }
            }
        }

        return $matches;
    }

    // EXACT same function as prototype
    private function normalizeEscoSkill($text, $escoSkills, $escoAliases)
    {
        $matches = [];

        // Match preferred labels
        foreach ($escoSkills as $id => $skill) {
            if (stripos($text, $skill['name']) !== false) {
                $matches[$skill['name']] = $skill['uri'];
            }
        }

        // Match aliases → map to preferred label
        foreach ($escoAliases as $alias => $skill_id) {
            if (stripos(strtolower($text), $alias) !== false && isset($escoSkills[$skill_id])) {
                $matches[$escoSkills[$skill_id]['name']] = $escoSkills[$skill_id]['uri'];
            }
        }

        return $matches;
    }

    private function extractName($text, $cleanLines)
    {
        $fullName = '';
        $firstName = '';
        $middleName = '';
        $lastName = '';
        $suffix = '';

        // Method 1: Look for "Full Name:" pattern
        if (preg_match('/(?:full\s*name|name)[\s:]+([A-Z][a-z]+(?:\s+[A-Z]\.?(?:\s+[A-Z][a-z]*)*|\s+[A-Z][a-z]*)*(?:\s+(?:Jr|Sr|III?|IV)\.?)?)/i', $text, $nameMatch)) {
            $fullName = trim($nameMatch[1]);
        }

        // Method 2: Look for name patterns in first few lines (improved pattern)
        if (!$fullName && !empty($cleanLines)) {
            foreach (array_slice($cleanLines, 0, 5) as $line) {
                // Skip common resume headers
                if (preg_match('/^(resume|curriculum|cv|contact|profile|objective|summary|email|phone|address|linkedin|github)/i', $line)) {
                    continue;
                }

                // Improved pattern to catch names with middle initials
                if (preg_match('/^([A-Z][a-z]+(?:\s+[A-Z]\.?(?:\s+[A-Z][a-z]*)*|\s+[A-Z][a-z]*)*(?:\s+(?:Jr|Sr|III?|IV)\.?)?)$/i', $line, $match)) {
                    $fullName = trim($match[1]);
                    break;
                }
            }
        }

        // Method 3: Extract from first line if it looks like a name
        if (!$fullName && !empty($cleanLines)) {
            $firstLine = $cleanLines[0];
            $cleanFirstLine = preg_replace('/^(full\s*name[\s:]*|name[\s:]*)/i', '', $firstLine);
            if (preg_match('/^([A-Z][a-z]+(?:\s+[A-Z]\.?(?:\s+[A-Z][a-z]*)*|\s+[A-Z][a-z]*)*(?:\s+(?:Jr|Sr|III?|IV)\.?)?)$/i', trim($cleanFirstLine), $match)) {
                $fullName = trim($match[1]);
            }
        }

        // Parse name components (IMPROVED LOGIC)
        if ($fullName) {
            $nameParts = explode(' ', $fullName);
            $nameParts = array_filter($nameParts); // Remove empty elements
            $nameParts = array_values($nameParts); // Reset array keys

            // Check for suffix first
            $suffixes = ['Jr', 'Sr', 'III', 'IV', 'Jr.', 'Sr.', 'III.', 'IV.'];
            $lastPart = end($nameParts);
            if (in_array($lastPart, $suffixes)) {
                $suffix = array_pop($nameParts);
            }

            $nameCount = count($nameParts);

            if ($nameCount >= 2) {
                $firstName = $nameParts[0];
                $lastName = $nameParts[$nameCount - 1]; // Last element

                // Handle middle name(s) - everything between first and last
                if ($nameCount > 2) {
                    $middleParts = array_slice($nameParts, 1, $nameCount - 2);

                    // Process middle names - handle initials properly
                    $processedMiddle = [];
                    foreach ($middleParts as $part) {
                        // If it's a single letter or letter with dot, keep as is
                        if (preg_match('/^[A-Z]\.?$/', $part)) {
                            $processedMiddle[] = $part;
                        }
                        // If it's a full middle name
                        else if (preg_match('/^[A-Z][a-z]+$/', $part)) {
                            $processedMiddle[] = $part;
                        }
                    }

                    $middleName = implode(' ', $processedMiddle);
                }
                // Special case: 3 parts could be "FirstName M. LastName"
                else if ($nameCount == 3) {
                    $middlePart = $nameParts[1];
                    // Check if middle part is an initial
                    if (preg_match('/^[A-Z]\.?$/', $middlePart)) {
                        $middleName = $middlePart;
                        $lastName = $nameParts[2];
                    } else {
                        // Treat middle part as part of last name or first name
                        $lastName = $nameParts[1] . ' ' . $nameParts[2];
                    }
                }
            } elseif ($nameCount == 1) {
                $firstName = $nameParts[0];
            }
        }

        return [
            'full_name' => $fullName,
            'first_name' => $firstName,
            'middle_name' => $middleName,
            'last_name' => $lastName,
            'suffix' => $suffix
        ];
    }

    private function extractEmail($text)
    {
        if (preg_match('/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[A-Z|a-z]{2,}/', $text, $match)) {
            return $match[0];
        }
        return '';
    }

    private function extractPhone($text)
    {
        if (preg_match('/(\+?63|0)?[\s-]?(\d{3}[\s-]?\d{3}[\s-]?\d{4}|\d{4}[\s-]?\d{3}[\s-]?\d{4}|\(\d{3}\)[\s-]?\d{3}[\s-]?\d{4})/', $text, $match)) {
            return $match[0];
        }
        return '';
    }

    private function extractAddress($text)
    {
        // Pattern 1: Look for explicit address labels
        if (preg_match('/(?:address|location|residence|home)[\s:]*([^\n]+(?:street|avenue|road|blvd|boulevard|drive|lane|way|city|state|province|country|philippines|usa|america)[^\n]*)/i', $text, $match)) {
            return trim($match[1]);
        }

        // Pattern 2: Look for City, State pattern
        if (preg_match('/([A-Z][a-z]+,\s*[A-Z]{2}(?:,?\s*[A-Z]{3})?)/i', $text, $match)) {
            return trim($match[1]);
        }

        return '';
    }

    private function extractBirthdate($text)
    {
        // Pattern 1: Look for explicit birthdate labels
        if (preg_match('/(?:born|birth|dob|date\s+of\s+birth|birthday)[\s:]*(\d{1,2}[\/\-\.]\d{1,2}[\/\-\.]\d{4}|\d{4}[\/\-\.]\d{1,2}[\/\-\.]\d{1,2}|(?:january|february|march|april|may|june|july|august|september|october|november|december)\s+\d{1,2},?\s+\d{4})/i', $text, $match)) {
            return $this->standardizeDateFormat($match[1]);
        }

        // Pattern 2: Look for age-based birthdate calculation
        if (preg_match('/age[\s:]*(\d{2})/i', $text, $match)) {
            $age = (int)$match[1];
            $birthYear = date('Y') - $age;
            return $birthYear . '-01-01'; // Approximate birthdate
        }

        return null;
    }

    private function extractGender($text)
    {
        if (preg_match('/(?:gender|sex)[\s:]*(?:male|female|m|f)\b/i', $text, $match)) {
            $gender = strtolower(trim(str_replace(['gender:', 'sex:'], '', $match[0])));
            if (in_array($gender, ['male', 'm'])) return 'Male';
            if (in_array($gender, ['female', 'f'])) return 'Female';
        }
        return '';
    }

    // Update the extractWorkExperience method

    private function extractWorkExperience($text)
    {
        $experiences = [];

        // Enhanced experience pattern with better section detection
        if (preg_match('/(?:experience|employment|work\s+history|professional\s+experience)[\s:]*([^\n]+(?:\n[^\n]*)*?)(?=\n\s*(?:education|skills|projects?|certificates?|languages?|references?|$))/is', $text, $match)) {
            $expText = $match[1];

            // Split by common separators for multiple experiences
            $expSections = preg_split('/\n\s*\n|\n(?=\S)/', $expText);

            foreach ($expSections as $section) {
                $section = trim($section);
                if (empty($section) || strlen($section) < 10) continue;

                $experience = $this->parseExperienceEntry($section);
                if (!empty($experience['job_title']) && strlen($experience['job_title']) > 2) {
                    $experiences[] = $experience;
                }
            }
        }

        return array_slice($experiences, 0, 5); // Limit to 5 experiences
    }

    private function parseExperienceEntry($text)
    {
        $experience = [
            'job_title' => '',
            'company_name' => '',
            'employment_type' => 'full-time',
            'start_date' => null,
            'end_date' => null,
            'currently_working' => 'No',
            'responsibilities' => ''
        ];

        $lines = explode("\n", trim($text));
        $lines = array_filter(array_map('trim', $lines));

        // Enhanced job title extraction with common patterns
        $jobTitlePatterns = [
            // Common job title patterns - more specific
            '/^(?:senior\s+|junior\s+|lead\s+|principal\s+)?(?:software\s+)?(?:engineer|developer|programmer|analyst|manager|coordinator|specialist|consultant|director|supervisor|associate|assistant)(?:\s+[IVX]+)?$/i',
            '/^(?:senior\s+|junior\s+|lead\s+)?(?:frontend|backend|full[\-\s]?stack|web|mobile|data|system|network|security|database|devops)\s+(?:engineer|developer|programmer|analyst)$/i',
            '/^(?:project\s+manager|product\s+manager|business\s+analyst|data\s+scientist|ui\/ux\s+designer|graphic\s+designer)$/i',
            '/^(?:marketing\s+specialist|sales\s+representative|customer\s+service|human\s+resources|financial\s+analyst)$/i',
            '/^(?:software|hardware|systems?|network|security|database|web|mobile|frontend|backend|fullstack|full[\-\s]stack)\s+(?:engineer|developer|programmer|analyst|architect)$/i'
        ];

        // Try to find job title in first few lines
        foreach (array_slice($lines, 0, 3) as $line) {
            $cleanLine = preg_replace('/^[•\-\*\+\d\.\s]+/', '', $line);
            $cleanLine = trim($cleanLine);

            // Skip if it's a date line or company name line
            if (preg_match('/\d{4}/', $cleanLine) || preg_match('/(?:inc|corp|ltd|llc|company)/i', $cleanLine)) {
                continue;
            }

            // Check against job title patterns
            foreach ($jobTitlePatterns as $pattern) {
                if (preg_match($pattern, $cleanLine)) {
                    $experience['job_title'] = $cleanLine;
                    break 2;
                }
            }

            // Fallback: if line contains common job keywords and is reasonable length
            if (
                empty($experience['job_title']) &&
                preg_match('/\b(?:engineer|developer|manager|analyst|specialist|coordinator|director|supervisor|associate|assistant|consultant|designer|architect)\b/i', $cleanLine) &&
                strlen($cleanLine) >= 5 && strlen($cleanLine) <= 50 &&
                !preg_match('/\b(?:years?|experience|expertise|responsible|developed|managed|worked)\b/i', $cleanLine)
            ) {

                $experience['job_title'] = $cleanLine;
                break;
            }
        }

        // Enhanced company name extraction
        $companyPatterns = [
            '/(?:at|@)\s+([A-Z][^\n,]+?)(?:\s*[-–]\s*|\s*,|\s*$)/i',
            '/([A-Z][^\n]*(?:Inc|Corp|Ltd|LLC|Company|Corporation|Technologies|Systems|Solutions|Group|Consulting)[^\n]*)/i',
            '/\b([A-Z][a-zA-Z\s&]+(?:Inc|Corp|Ltd|LLC|Company)\.?)\b/i'
        ];

        foreach ($companyPatterns as $pattern) {
            if (preg_match($pattern, $text, $match)) {
                $company = trim($match[1]);
                $company = preg_replace('/^[•\-\*\+\s]+/', '', $company);
                if (strlen($company) > 2 && strlen($company) < 100) {
                    $experience['company_name'] = $company;
                    break;
                }
            }
        }

        // Enhanced date extraction
        $datePatterns = [
            '/(\w+\s+\d{4})\s*[-–]\s*(\w+\s+\d{4}|present|current)/i', // "January 2020 - December 2022"
            '/(\d{1,2}\/\d{4})\s*[-–]\s*(\d{1,2}\/\d{4}|present|current)/i', // "01/2020 - 12/2022"
            '/(\d{4})\s*[-–]\s*(\d{4}|present|current)/i' // "2020 - 2022"
        ];

        foreach ($datePatterns as $pattern) {
            if (preg_match($pattern, $text, $match)) {
                $startDate = $match[1];
                $endDate = $match[2];

                // Convert dates to standard format
                $experience['start_date'] = $this->standardizeDateFormat($startDate);

                if (strtolower($endDate) === 'present' || strtolower($endDate) === 'current') {
                    $experience['currently_working'] = 'Yes';
                    $experience['end_date'] = null;
                } else {
                    $experience['end_date'] = $this->standardizeDateFormat($endDate);
                }
                break;
            }
        }

        // Extract responsibilities (clean up)
        $responsibility = trim($text);
        $responsibility = preg_replace('/^.*?(?:responsibilities|duties|achievements|accomplishments)[\s:]*\n?/is', '', $responsibility);
        $responsibility = preg_replace('/^\s*[•\-\*\+]\s*/m', '• ', $responsibility);
        $experience['responsibilities'] = strlen($responsibility) > 10 ? $responsibility : 'N/A';

        return $experience;
    }

    // Enhanced date standardization
    private function standardizeDateFormat($dateString)
    {
        $dateString = trim($dateString);

        // Handle different date formats
        $formats = [
            'Y-m-d',
            'm/d/Y',
            'd/m/Y',
            'Y',
            'm/Y',
            'M Y',
            'F Y',
            'M d, Y',
            'F d, Y'
        ];

        foreach ($formats as $format) {
            $date = DateTime::createFromFormat($format, $dateString);
            if ($date !== false) {
                // If only year is provided, assume January 1st
                if ($format === 'Y') {
                    return $date->format('Y') . '-01-01';
                }
                // If month/year, assume first day of month
                if (in_array($format, ['m/Y', 'M Y', 'F Y'])) {
                    return $date->format('Y-m') . '-01';
                }
                return $date->format('Y-m-d');
            }
        }

        // If no format matches, try to extract just the year
        if (preg_match('/(\d{4})/', $dateString, $match)) {
            return $match[1] . '-01-01';
        }

        return null;
    }

    // private function parseExperienceEntry($text)
    // {
    //     $experience = [
    //         'job_title' => '',
    //         'company_name' => '',
    //         'employment_type' => 'full-time',
    //         'start_date' => null,
    //         'end_date' => null,
    //         'currently_working' => 'No',
    //         'responsibilities' => ''
    //     ];

    //     // Extract job title (usually first line)
    //     $lines = explode("\n", trim($text));
    //     if (!empty($lines[0])) {
    //         $experience['job_title'] = trim($lines[0]);
    //     }

    //     // Extract company name
    //     if (preg_match('/(?:at|@)\s+([^\n,]+)/i', $text, $match)) {
    //         $experience['company_name'] = trim($match[1]);
    //     }

    //     // Extract dates
    //     if (preg_match('/(\d{4})\s*[-–]\s*(\d{4}|present|current)/i', $text, $match)) {
    //         $experience['start_date'] = $match[1] . '-01-01';
    //         if (strtolower($match[2]) === 'present' || strtolower($match[2]) === 'current') {
    //             $experience['currently_working'] = 'Yes';
    //         } else {
    //             $experience['end_date'] = $match[2] . '-12-31';
    //         }
    //     }

    //     $experience['responsibilities'] = trim($text);

    //     return $experience;
    // }

    private function extractEducation($text)
    {
        $education = [
            'school_name' => '',
            'education_level' => '',
            'field_of_study' => '',
            'start_date' => null,
            'end_date' => null
        ];

        // Enhanced education pattern - stops at other major sections
        if (preg_match('/(?:education|academic|qualification|educational\s+background)[\s:]*([^\n]+(?:\n[^\n]*)*?)(?=\n\s*(?:experience|work|employment|skills|projects?|certificates?|languages?|references?|objective|summary|$))/is', $text, $match)) {
            $eduText = $match[1];

            // Use advanced school name extraction
            $education['school_name'] = $this->extractSchoolNameAdvanced($eduText);

            // If advanced method didn't work, fall back to basic patterns
            if (empty($education['school_name'])) {
                $schoolPatterns = [
                    '/([^\n]*(?:university|college|institute|school|academy)[^\n]*)/i',
                    '/([A-Z][^\n]*(?:University|College|Institute|School|Academy)[^\n]*)/i',
                ];

                foreach ($schoolPatterns as $pattern) {
                    if (preg_match($pattern, $eduText, $schoolMatch)) {
                        $schoolName = $this->cleanSchoolName(trim($schoolMatch[1]));

                        if (strlen($schoolName) > 3 && $this->isValidSchoolName($schoolName)) {
                            $education['school_name'] = $schoolName;
                            break;
                        }
                    }
                }
            }

            // Rest of the extraction logic remains the same...
            // (degree level, field of study, dates)

            // Extract degree level
            $degreePatterns = [
                '/\b(bachelor(?:\'s)?(?:\s+(?:of\s+)?(?:science|arts|engineering|business|fine\s+arts))?)/i' => 'Bachelor',
                '/\b(master(?:\'s)?(?:\s+(?:of\s+)?(?:science|arts|engineering|business|fine\s+arts))?)/i' => 'Master',
                '/\b(phd|doctorate|doctoral)/i' => 'Doctorate',
                '/\b(associate(?:\s+degree)?)/i' => 'Associate',
                '/\b(diploma|certificate)/i' => 'Vocational',
                '/\b(high\s+school|secondary)/i' => 'High School'
            ];

            foreach ($degreePatterns as $pattern => $level) {
                if (preg_match($pattern, $eduText, $degreeMatch)) {
                    $education['education_level'] = $level;
                    break;
                }
            }

            // Extract field of study
            $fieldPatterns = [
                '/(?:bachelor(?:\'s)?|master(?:\'s)?|degree)\s+(?:of\s+)?(?:science\s+)?(?:in\s+)?([^,\n\d]+)/i',
                '/(?:major(?:ing)?|field|study(?:ing)?|specialization)(?:\s+in)?\s*:?\s*([^,\n\d]+)/i',
                '/\b(computer\s+science|information\s+technology|engineering|business\s+administration|marketing|psychology|education|nursing|medicine)\b/i'
            ];

            foreach ($fieldPatterns as $pattern) {
                if (preg_match($pattern, $eduText, $fieldMatch)) {
                    $field = trim($fieldMatch[1] ?? $fieldMatch[0]);
                    $field = preg_replace('/^[•\-\*\+\s]+/', '', $field);
                    $field = preg_replace('/\s*\d{4}.*$/', '', $field); // Remove years
                    if (strlen($field) > 2) {
                        $education['field_of_study'] = $field;
                        break;
                    }
                }
            }

            // Extract years with validation
            $yearPatterns = [
                '/(?:graduated|graduation|completed).*?(\d{4})/i',
                '/(\d{4})\s*[-–]\s*(\d{4})/i',
                '/(?:class\s+of|year).*?(\d{4})/i',
                '/\b(\d{4})\b(?=\s*$|\s*[,\n])/m'
            ];

            foreach ($yearPatterns as $pattern) {
                if (preg_match($pattern, $eduText, $yearMatch)) {
                    if (isset($yearMatch[2])) {
                        $startYear = (int)$yearMatch[1];
                        $endYear = (int)$yearMatch[2];

                        if ($this->isValidEducationYear($startYear) && $this->isValidEducationYear($endYear) && $startYear <= $endYear) {
                            $education['start_date'] = $startYear . '-01-01';
                            $education['end_date'] = $endYear . '-12-31';
                            break;
                        }
                    } else {
                        $gradYear = (int)$yearMatch[1];

                        if ($this->isValidEducationYear($gradYear)) {
                            $education['end_date'] = $gradYear . '-12-31';
                            $education['start_date'] = ($gradYear - 4) . '-01-01';
                            break;
                        }
                    }
                }
            }
        }

        return $education;
    }

    // Add helper method to validate education years
    private function isValidEducationYear($year)
    {
        $currentYear = (int)date('Y');
        return ($year >= 1900 && $year <= ($currentYear + 10)); // Allow future years for ongoing programs
    }

    private function extractCertificates($text)
    {
        $certificates = [];

        if (preg_match('/(?:certificate|certification|license)[\s:]*([^\n]+(?:\n[^\n]*)*?)(?=\n\s*(?:[A-Z][A-Z\s]+|$))/i', $text, $match)) {
            $certText = $match[1];
            $certLines = explode("\n", $certText);

            foreach ($certLines as $line) {
                $line = trim($line);
                if (!empty($line) && strlen($line) > 5) {
                    $certificates[] = [
                        'certificate_title' => $line,
                        'issuing_organization' => 'Unknown',
                        'date_issued' => date('Y-m-d')
                    ];
                }
            }
        }

        return array_slice($certificates, 0, 5);
    }

    // private function standardizeDateFormat($dateString)
    // {
    //     $dateString = trim($dateString);

    //     // Try different date formats
    //     $formats = ['Y-m-d', 'm/d/Y', 'd/m/Y', 'M d, Y', 'F d, Y'];

    //     foreach ($formats as $format) {
    //         $date = DateTime::createFromFormat($format, $dateString);
    //         if ($date !== false) {
    //             return $date->format('Y-m-d');
    //         }
    //     }

    //     return null;
    // }

    public function updateJobseekerProfileFromParsedData($userId, $parsedData)
    {
        try {
            require_once __DIR__ . '/Jobseeker.php';
            $jobseekerModel = new Jobseeker();

            // Get or create jobseeker record
            $jobseeker = $jobseekerModel->findByUserId($userId);
            if (!$jobseeker) {
                // Create basic jobseeker record
                $jobseekerModel->create(
                    $userId,
                    $parsedData['name_data']['first_name'] ?: 'N/A',
                    $parsedData['name_data']['last_name'] ?: 'N/A',
                    $parsedData['phone'] ?: 'N/A'
                );
                $jobseeker = $jobseekerModel->findByUserId($userId);
            }

            $jobseekerId = $jobseeker['jobseeker_id'];

            // Update basic profile information
            $profileData = [
                'first_name' => $parsedData['name_data']['first_name'] ?: $jobseeker['first_name'],
                'middle_name' => $parsedData['name_data']['middle_name'] ?: $jobseeker['middle_name'],
                'last_name' => $parsedData['name_data']['last_name'] ?: $jobseeker['last_name'],
                'suffix' => $parsedData['name_data']['suffix'] ?: $jobseeker['suffix'],
                'date_of_birth' => $parsedData['birthdate'] ?: $jobseeker['date_of_birth'],
                'sex' => $parsedData['gender'] ?: $jobseeker['sex'],
                'address' => $parsedData['address'] ?: $jobseeker['address'],
                'contact_no' => $parsedData['phone'] ?: $jobseeker['contact_no']
            ];

            $jobseekerModel->updateProfile($userId, $profileData);

            // Update skills (delete existing and add new ones)
            if (!empty($parsedData['skills'])) {
                $jobseekerModel->deleteSkills($jobseekerId);
                foreach ($parsedData['skills'] as $skill) {
                    $jobseekerModel->saveSkill($jobseekerId, $skill);
                }
            }

            // Update work experience (delete existing and add new ones to avoid duplicates)
            if (!empty($parsedData['experience'])) {
                // Delete existing work experience from parsing
                $existingExperience = $jobseekerModel->getWorkExperience($userId);
                if (!empty($existingExperience)) {
                    foreach ($existingExperience as $exp) {
                        $jobseekerModel->deleteWorkExperience($jobseekerId, $exp['experience_id']);
                    }
                }

                // Add new parsed work experience
                foreach ($parsedData['experience'] as $exp) {
                    $jobseekerModel->saveWorkExperience($jobseekerId, $exp);
                }
            }

            // Update education (replace existing with parsed data)
            if (!empty($parsedData['education']) && !empty($parsedData['education']['school_name'])) {
                // Delete existing education first
                $existingEducation = $jobseekerModel->getEducation($userId);
                if (!empty($existingEducation)) {
                    foreach ($existingEducation as $edu) {
                        $stmt = $jobseekerModel->getPdo()->prepare("DELETE FROM jobseeker_education WHERE education_id = ?");
                        $stmt->execute([$edu['education_id']]);
                    }
                }

                // Add new parsed education
                $jobseekerModel->saveEducation($jobseekerId, $parsedData['education']);
            }

            // Update certificates (delete existing and add new ones)
            if (!empty($parsedData['certificates'])) {
                $existingCertificates = $jobseekerModel->getCertificates($jobseekerId);
                if (!empty($existingCertificates)) {
                    foreach ($existingCertificates as $cert) {
                        $stmt = $jobseekerModel->getPdo()->prepare("DELETE FROM jobseeker_certificates WHERE certificate_id = ?");
                        $stmt->execute([$cert['certificate_id']]);
                    }
                }

                foreach ($parsedData['certificates'] as $cert) {
                    $jobseekerModel->saveCertificate($jobseekerId, $cert);
                }
            }

            return [
                'success' => true,
                'message' => 'Profile updated successfully from resume',
                'data' => $parsedData
            ];
        } catch (Exception $e) {
            error_log("Error updating jobseeker profile from parsed data: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to update profile: ' . $e->getMessage()
            ];
        }
    }

    // Add this method to better extract school names from common formats:

    private function extractSchoolNameAdvanced($eduText)
    {
        $schoolName = '';

        // Common patterns for school names
        $patterns = [
            // Pattern 1: "University of [Location]" or "[Name] University"
            '/\b([A-Z][a-zA-Z\s&\-\']+(?:University|College|Institute|School|Academy)(?:\s+of\s+[A-Z][a-zA-Z\s]+)?)\b/',
            // Pattern 2: "[State] [Type] University"
            '/\b([A-Z][a-zA-Z]+\s+(?:State\s+)?(?:University|College|Institute))\b/',
            // Pattern 3: Full institution names
            '/\b([A-Z][a-zA-Z\s&\-\']+(?:Community\s+College|Technical\s+Institute|Polytechnic|Seminary))\b/',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $eduText, $match)) {
                $candidate = trim($match[1]);

                // Clean the candidate
                $candidate = $this->cleanSchoolName($candidate);

                // Validate it's a real school name (not just keywords)
                if (strlen($candidate) > 5 && $this->isValidSchoolName($candidate)) {
                    $schoolName = $candidate;
                    break;
                }
            }
        }

        return $schoolName;
    }

    private function cleanSchoolName($name)
    {
        // Remove years and dates
        $name = preg_replace('/\s*[\|\-–]\s*\d{4}.*$/', '', $name);
        $name = preg_replace('/\s*\(\s*\d{4}.*?\)/', '', $name);
        $name = preg_replace('/\s*,?\s*\d{4}\s*[-–]\s*\d{4}/', '', $name);
        $name = preg_replace('/\s*,?\s*\d{4}\s*[-–]\s*(?:present|current)/i', '', $name);
        $name = preg_replace('/\s*\d{4}\s*$/', '', $name);

        // Remove degree abbreviations
        $name = preg_replace('/\s*[-–]\s*(BS|BA|MS|MA|PhD|Dr\.|BSc|MSc|Bachelor|Master).*$/i', '', $name);

        // Remove bullets and numbering
        $name = preg_replace('/^[•\-\*\+\s\d\.]+/', '', $name);

        // Final cleanup
        $name = trim($name);
        $name = rtrim($name, ',-|–');

        return $name;
    }

    private function isValidSchoolName($name)
    {
        // Check if it's not just common words or abbreviations
        $invalidNames = ['university', 'college', 'school', 'institute', 'academy', 'education', 'degree', 'bachelor', 'master'];

        $nameLower = strtolower($name);
        foreach ($invalidNames as $invalid) {
            if ($nameLower === $invalid) {
                return false;
            }
        }

        // Must contain at least one letter
        if (!preg_match('/[a-zA-Z]/', $name)) {
            return false;
        }

        // Should not be mostly numbers
        if (preg_match('/^\d+/', $name)) {
            return false;
        }

        return true;
    }
}
