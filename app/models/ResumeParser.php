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

    private function strictEscoSkillMatch($text, $escoSkills, $escoAliases)
    {
        $matches = [];
        $text_lower = strtolower($text);

        // Define common technical skills that we want to prioritize
        $prioritySkills = [
            "data analysis",
            "research",
            "technical writing",
            "report preparation",
            "accounting",
            "bookkeeping",
            "financial analysis",
            "marketing",
            "sales",
            "customer service",
            "business strategy",
            "operations management",
            "supply chain management",
            "quality assurance",
            "project planning",
            "scheduling",
            "event planning",
            "presentation skills",
            "negotiation",
            "documentation",
            "communication",
            "teamwork",
            "leadership",
            "problem solving",
            "critical thinking",
            "adaptability",
            "creativity",
            "time management",
            "decision making",
            "conflict resolution",
            "collaboration",
            "work ethic",
            "emotional intelligence",
            "attention to detail",
            "interpersonal skills",
            "resilience",
            "active listening"
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

        // Method 1: Look for "Full Name:" pattern with better filtering
        if (preg_match('/(?:full\s*name|name)[\s:]+([A-Z][a-z]+(?:\s+[A-Z]\.?(?:\s+[A-Z][a-z]*)*|\s+[A-Z][a-z]*)*(?:\s+(?:Jr|Sr|III?|IV)\.?)?)/i', $text, $nameMatch)) {
            $candidateName = trim($nameMatch[1]);
            // Validate it's actually a name, not job title or other text
            if ($this->isValidPersonName($candidateName)) {
                $fullName = $candidateName;
            }
        }

        // Method 2: Look for name patterns in first few lines with better validation
        if (!$fullName && !empty($cleanLines)) {
            foreach (array_slice($cleanLines, 0, 5) as $line) {
                // Skip common resume headers and non-name content
                if (preg_match('/^(resume|curriculum|cv|contact|profile|objective|summary|email|phone|address|linkedin|github|experience|education|skills|work|employment|position|title|developer|engineer|manager|analyst|specialist|coordinator|director|supervisor|assistant|consultant)/i', $line)) {
                    continue;
                }

                // Skip lines with numbers, email patterns, or URLs
                if (preg_match('/\d{3}|\@|\.com|\.net|\.org|http|www/i', $line)) {
                    continue;
                }

                // Enhanced pattern to catch names with better validation
                if (preg_match('/^([A-Z][a-z]+(?:\s+[A-Z]\.?(?:\s+[A-Z][a-z]*)*|\s+[A-Z][a-z]*)*(?:\s+(?:Jr|Sr|III?|IV)\.?)?)$/i', $line, $match)) {
                    $candidateName = trim($match[1]);
                    if ($this->isValidPersonName($candidateName) && strlen($candidateName) >= 4 && strlen($candidateName) <= 50) {
                        $fullName = $candidateName;
                        break;
                    }
                }
            }
        }

        // Method 3: Extract from first line with enhanced validation
        if (!$fullName && !empty($cleanLines)) {
            $firstLine = $cleanLines[0];
            $cleanFirstLine = preg_replace('/^(full\s*name[\s:]*|name[\s:]*)/i', '', $firstLine);
            $cleanFirstLine = trim($cleanFirstLine);

            if (preg_match('/^([A-Z][a-z]+(?:\s+[A-Z]\.?(?:\s+[A-Z][a-z]*)*|\s+[A-Z][a-z]*)*(?:\s+(?:Jr|Sr|III?|IV)\.?)?)$/i', $cleanFirstLine, $match)) {
                $candidateName = trim($match[1]);
                if ($this->isValidPersonName($candidateName) && strlen($candidateName) >= 4 && strlen($candidateName) <= 50) {
                    $fullName = $candidateName;
                }
            }
        }

        // Parse name components if we found a valid name
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

    private function isValidPersonName($name)
    {
        // List of common non-name words that might appear at the beginning of resumes
        $invalidNames = [
            'resume',
            'curriculum',
            'cv',
            'vitae',
            'profile',
            'contact',
            'information',
            'personal',
            'objective',
            'summary',
            'experience',
            'education',
            'skills',
            'work',
            'employment',
            'position',
            'title',
            'developer',
            'engineer',
            'manager',
            'analyst',
            'specialist',
            'coordinator',
            'director',
            'supervisor',
            'assistant',
            'consultant',
            'senior',
            'junior',
            'lead',
            'principal',
            'software',
            'web',
            'mobile',
            'frontend',
            'backend',
            'fullstack',
            'full stack',
            'data',
            'system',
            'network',
            'security',
            'database',
            'project',
            'product',
            'business',
            'marketing',
            'sales',
            'customer',
            'human',
            'resources',
            'financial',
            'email',
            'phone',
            'address',
            'linkedin',
            'github',
            'portfolio',
            'website',
            'location',
            'residence'
        ];

        $nameLower = strtolower(trim($name));

        // Check if it exactly matches any invalid name
        if (in_array($nameLower, $invalidNames)) {
            return false;
        }

        // Check if it starts with common job titles or resume keywords
        foreach ($invalidNames as $invalid) {
            if (strpos($nameLower, $invalid) === 0) {
                return false;
            }
        }

        // Must contain only letters, spaces, dots, and common name characters
        if (!preg_match('/^[A-Za-z.\s\']+$/', $name)) {
            return false;
        }

        // Should not contain too many consecutive uppercase letters (like "HTML", "CSS", etc.)
        if (preg_match('/[A-Z]{3,}/', $name)) {
            return false;
        }

        // Should not be too short or too long
        if (strlen($name) < 2 || strlen($name) > 50) {
            return false;
        }

        // Must have at least one vowel (basic name validation)
        if (!preg_match('/[aeiouAEIOU]/', $name)) {
            return false;
        }

        return true;
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
        // List of Rosario, Batangas barangays for better matching
        $rosarioBarangays = [
            'Alupay',
            'Antipolo',
            'Bagong Pook',
            'Balibago',
            'Barangay A',
            'Barangay B',
            'Barangay C',
            'Barangay D',
            'Barangay E',
            'Bayawang',
            'Baybayin',
            'Bulihan',
            'Cahigam',
            'Calantas',
            'Colongan',
            'Itlugan',
            'Leviste',
            'Lumbangan',
            'Maalas-as',
            'Mabato',
            'Mabunga',
            'Macalamcam A',
            'Macalamcam B',
            'Malaya',
            'Maligaya',
            'Marilag',
            'Masaya',
            'Matamis',
            'Mavalor',
            'Mayuro',
            'Namuco',
            'Namunga',
            'Nasi',
            'Natu',
            'Palakpak',
            'Pinagsibaan',
            'Putingkahoy',
            'Quilib',
            'Salao',
            'San Carlos',
            'San Ignacio',
            'San Isidro',
            'San Jose',
            'San Roque',
            'Santa Cruz',
            'Timbugan',
            'Tiquiwan',
            'Tulos'
        ];

        // Pattern 1: Look for Rosario, Batangas barangays specifically
        foreach ($rosarioBarangays as $barangay) {
            $pattern = '/\b' . preg_quote($barangay, '/') . '\b[,\s]*(?:Rosario)?[,\s]*(?:Batangas)?/i';
            if (preg_match($pattern, $text, $match)) {
                $fullAddress = $barangay . ', Rosario, Batangas';
                return $fullAddress;
            }
        }

        // Pattern 2: Look for "Rosario" with any barangay
        if (preg_match('/([A-Z][a-zA-Z\s]+),?\s*Rosario[,\s]*Batangas/i', $text, $match)) {
            return trim($match[0]);
        }

        // Pattern 3: Look for explicit address labels
        if (preg_match('/(?:address|location|residence|home)[\s:]*([^\n]+(?:street|avenue|road|blvd|boulevard|drive|lane|way|city|state|province|barangay|rosario|batangas|philippines)[^\n]*)/i', $text, $match)) {
            $address = trim($match[1]);
            // Clean up the address
            $address = preg_replace('/^[•\-\*\+\s]+/', '', $address);
            return $address;
        }

        // Pattern 4: Look for City, State pattern (general)
        if (preg_match('/\b([A-Z][a-zA-Z\s,]+(?:City|Municipality|Province|Batangas|Philippines))\b/i', $text, $match)) {
            return trim($match[1]);
        }

        // Pattern 5: Look for any location with Batangas
        if (preg_match('/([A-Z][a-zA-Z\s,]+Batangas[^.\n]*)/i', $text, $match)) {
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

    private function extractWorkExperience($text)
    {
        $experiences = [];

        // Enhanced patterns to find work experience sections
        $sectionPatterns = [
            '/(?:work\s+experience|professional\s+experience|employment\s+history|career\s+history|employment|experience)[\s:]*\n?(.*?)(?=\n\s*(?:education|academic|skills|projects?|certificates?|certifications?|languages?|references?|hobbies|interests|awards?|$))/is',
            '/(?:career\s+summary|professional\s+summary)[\s:]*\n?(.*?)(?=\n\s*(?:education|academic|skills|projects?|certificates?|certifications?|languages?|references?|hobbies|interests|awards?|$))/is'
        ];

        $experienceText = '';
        foreach ($sectionPatterns as $pattern) {
            if (preg_match($pattern, $text, $match)) {
                $experienceText = trim($match[1]);
                break;
            }
        }

        if (empty($experienceText)) {
            // Try to find individual job entries without a section header
            $experienceText = $this->extractJobEntriesWithoutHeader($text);
            if (empty($experienceText)) {
                return [];
            }
        }

        // Split by common separators for multiple experiences
        $experienceSections = $this->splitExperienceEntries($experienceText);

        foreach ($experienceSections as $index => $section) {
            $section = trim($section);
            if (empty($section) || strlen($section) < 15) {
                continue;
            }

            $experience = $this->parseExperienceEntry($section);

            // Only add if we have both job title and company
            if (
                !empty($experience['job_title']) && !empty($experience['company_name']) &&
                strlen($experience['job_title']) > 2 && strlen($experience['company_name']) > 2
            ) {
                $experiences[] = $experience;
            }
        }

        return array_slice($experiences, 0, 5); // Limit to 5 experiences
    }

    private function extractJobEntriesWithoutHeader($text)
    {
        $lines = explode("\n", $text);
        $jobEntries = '';
        $foundJobPattern = false;

        foreach ($lines as $line) {
            $line = trim($line);

            // Look for lines that might be job titles
            if (preg_match('/\b(?:software|web|mobile|frontend|backend|full[\-\s]?stack|data|system|network|security|database|devops|project|product|business|marketing|sales|customer|human|financial)?\s*(?:engineer|developer|programmer|analyst|manager|coordinator|specialist|consultant|director|supervisor|designer|architect|representative|associate|assistant|intern|trainee)\b/i', $line)) {
                $foundJobPattern = true;
                $jobEntries .= $line . "\n";
            } elseif ($foundJobPattern) {
                // Continue collecting lines after we found a job pattern
                $jobEntries .= $line . "\n";

                // Stop if we hit an education or skills section
                if (preg_match('/^(?:education|academic|skills|projects?|certificates?)/i', $line)) {
                    break;
                }
            }
        }

        return $foundJobPattern ? $jobEntries : '';
    }

    private function splitExperienceEntries($text)
    {
        $entries = [];

        // Method 1: Split by job title patterns (most reliable)
        $jobTitlePattern = '/(?=(?:^|\n)\s*(?:(?:senior|junior|lead|principal|assistant|associate)\s+)?(?:software|web|mobile|frontend|backend|full[\-\s]?stack|devops|project|product|business|marketing|sales|customer|human|financial)?\s*(?:engineer|developer|programmer)(?:\s+[IVX]+)?(?:\s|$))/im';

        $parts = preg_split($jobTitlePattern, $text, -1, PREG_SPLIT_NO_EMPTY);

        if (count($parts) > 1) {
            return $parts;
        }

        // Method 2: Split by company patterns
        $companyPattern = '/(?=(?:^|\n)\s*(?:at\s+)?[A-Z][a-zA-Z\s&\-\']+(?:Inc|Corp|Ltd|LLC|Company|Corporation|Technologies|Systems|Solutions|Group|Consulting)\b)/im';
        $parts = preg_split($companyPattern, $text, -1, PREG_SPLIT_NO_EMPTY);

        if (count($parts) > 1) {
            return $parts;
        }

        // Method 3: Split by date ranges
        $datePattern = '/(?=(?:^|\n)\s*(?:\d{1,2}\/\d{4}|\w+\s+\d{4}|\d{4})\s*[-–]\s*(?:\d{1,2}\/\d{4}|\w+\s+\d{4}|\d{4}|present|current))/im';
        $parts = preg_split($datePattern, $text, -1, PREG_SPLIT_NO_EMPTY);

        if (count($parts) > 1) {
            return $parts;
        }

        // Method 4: Split by double line breaks
        $parts = preg_split('/\n\s*\n/', $text);
        $filteredParts = array_filter($parts, function ($part) {
            return strlen(trim($part)) > 20;
        });

        if (count($filteredParts) > 1) {
            return array_values($filteredParts);
        }

        // Fallback: return the whole text as one entry
        return [$text];
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
            'experience_type' => 'previous',
            'responsibilities' => '',
            'achievements' => ''
        ];

        $lines = explode("\n", trim($text));
        $lines = array_filter(array_map('trim', $lines));

        // Enhanced job title extraction
        $jobTitle = $this->extractJobTitle($lines, $text);
        if ($jobTitle) {
            $experience['job_title'] = $jobTitle;
        }

        // Enhanced company extraction
        $companyName = $this->extractCompanyName($lines, $text);
        if ($companyName) {
            $experience['company_name'] = $companyName;
        }

        // Enhanced date extraction
        $dateInfo = $this->extractWorkDates($text);
        if ($dateInfo) {
            $experience = array_merge($experience, $dateInfo);
        }

        // Extract employment type
        $employmentType = $this->extractEmploymentType($text);
        if ($employmentType) {
            $experience['employment_type'] = $employmentType;
        }

        // Extract responsibilities
        $responsibilities = $this->extractResponsibilities($text);
        if ($responsibilities) {
            $experience['responsibilities'] = $responsibilities;
        }

        return $experience;
    }

    private function extractJobTitle($lines, $fullText)
    {
        // Common job title patterns - ordered by specificity
        $jobTitlePatterns = [
            // Specific technical roles
            '/^(?:senior\s+|junior\s+|lead\s+|principal\s+|staff\s+)?(?:software\s+|web\s+|mobile\s+|frontend\s+|backend\s+|full[\-\s]?stack\s+|devops\s+)?(?:engineer|developer|programmer)(?:\s+[IVX]+)?$/i',
            '/^(?:senior\s+|junior\s+|lead\s+)?(?:data\s+scientist|data\s+analyst|business\s+analyst|system\s+analyst|security\s+analyst)$/i',
            '/^(?:project\s+manager|product\s+manager|program\s+manager|technical\s+manager|engineering\s+manager)$/i',
            '/^(?:ui\/ux\s+designer|graphic\s+designer|web\s+designer|product\s+designer)$/i',

            // Business roles
            '/^(?:marketing\s+specialist|marketing\s+manager|digital\s+marketing\s+specialist)$/i',
            '/^(?:sales\s+representative|sales\s+manager|account\s+manager|business\s+development)$/i',
            '/^(?:customer\s+service\s+representative|customer\s+success\s+manager|support\s+specialist)$/i',
            '/^(?:human\s+resources\s+specialist|hr\s+manager|recruiter|talent\s+acquisition)$/i',
            '/^(?:financial\s+analyst|accountant|finance\s+manager|controller)$/i',

            // General patterns
            '/^(?:senior\s+|junior\s+|assistant\s+|associate\s+)?[\w\s]+(?:manager|director|supervisor|coordinator|specialist|analyst|consultant|officer|executive|associate|assistant)$/i',
            '/^(?:intern|trainee|apprentice)\s+[\w\s]*$/i'
        ];

        // Try first few lines for job title
        foreach (array_slice($lines, 0, 4) as $line) {
            $cleanLine = preg_replace('/^[•\-\*\+\d\.\s]+/', '', $line);
            $cleanLine = trim($cleanLine);

            // Skip obvious non-titles
            if (
                empty($cleanLine) || strlen($cleanLine) > 60 ||
                preg_match('/\d{4}|@|\.com|phone|email|address/i', $cleanLine) ||
                preg_match('/^(?:summary|objective|profile|experience|education|skills)/i', $cleanLine)
            ) {
                continue;
            }

            // Check against patterns
            foreach ($jobTitlePatterns as $pattern) {
                if (preg_match($pattern, $cleanLine)) {
                    return $cleanLine;
                }
            }

            // Fallback: if contains job keywords and reasonable length
            if (
                preg_match('/\b(?:engineer|developer|manager|analyst|specialist|coordinator|director|supervisor|associate|assistant|consultant|designer|architect|representative|intern|trainee)\b/i', $cleanLine) &&
                strlen($cleanLine) >= 5 && strlen($cleanLine) <= 50 &&
                !preg_match('/\b(?:years?|experience|responsible|developed|managed|worked|company|inc|corp|ltd)\b/i', $cleanLine)
            ) {
                return $cleanLine;
            }
        }

        return '';
    }

    private function extractCompanyName($lines, $fullText)
    {
        $companyPatterns = [
            // "at Company Name" pattern
            '/(?:at|@)\s+([A-Z][^\n,]+?)(?:\s*[-–]\s*|\s*,|\s*\(|\s*$)/i',

            // Company with legal entity
            '/\b([A-Z][a-zA-Z\s&\-\'\.]+(?:Inc|Corp|Ltd|LLC|Company|Corporation|Technologies|Systems|Solutions|Group|Consulting)\.?)\b/i',

            // University or school
            '/\b([A-Z][a-zA-Z\s&\-\']+(?:University|College|Institute|School|Academy|Hospital|Medical\s+Center|Clinic))\b/i',

            // Government or organization
            '/\b([A-Z][a-zA-Z\s&\-\']+(?:Department|Ministry|Agency|Commission|Bureau|Office|Government|Municipality|City|County))\b/i'
        ];

        foreach ($companyPatterns as $pattern) {
            if (preg_match($pattern, $fullText, $match)) {
                $company = trim($match[1]);
                $company = preg_replace('/^[•\-\*\+\s]+/', '', $company);
                $company = preg_replace('/\s*[-–]\s*\d{4}.*$/', '', $company); // Remove dates

                if (
                    strlen($company) > 2 && strlen($company) < 100 &&
                    !preg_match('/^(?:january|february|march|april|may|june|july|august|september|october|november|december|\d)/i', $company)
                ) {
                    return $company;
                }
            }
        }

        // Fallback: look in lines for company-like strings
        foreach ($lines as $line) {
            $cleanLine = trim($line);

            // Skip if it looks like a job title or date
            if (
                preg_match('/(?:engineer|developer|manager|analyst|specialist)\b/i', $cleanLine) ||
                preg_match('/\d{4}/', $cleanLine) ||
                strlen($cleanLine) < 3 || strlen($cleanLine) > 80
            ) {
                continue;
            }

            // Look for capitalized words that could be company names
            if (
                preg_match('/^[A-Z][a-zA-Z\s&\-\']+$/', $cleanLine) &&
                str_word_count($cleanLine) >= 1 && str_word_count($cleanLine) <= 5
            ) {
                return $cleanLine;
            }
        }

        return '';
    }

    private function extractWorkDates($text)
    {
        $dateInfo = [
            'start_date' => null,
            'end_date' => null,
            'currently_working' => 'No',
            'experience_type' => 'previous'
        ];

        // Enhanced date patterns
        $datePatterns = [
            // "January 2020 - December 2022" or "Jan 2020 - Dec 2022"
            '/(\w+\s+\d{4})\s*[-–]\s*(\w+\s+\d{4}|present|current)/i',

            // "01/2020 - 12/2022" or "1/2020 - 12/2022"
            '/(\d{1,2}\/\d{4})\s*[-–]\s*(\d{1,2}\/\d{4}|present|current)/i',

            // "2020 - 2022" or "2020 - present"
            '/(\d{4})\s*[-–]\s*(\d{4}|present|current)/i',

            // "March 2020 to December 2022"
            '/(\w+\s+\d{4})\s+to\s+(\w+\s+\d{4}|present|current)/i',

            // Single date patterns for ongoing jobs
            '/(?:since|from)\s+(\w+\s+\d{4}|\d{1,2}\/\d{4}|\d{4})(?:\s+[-–]\s+(?:present|current))?/i'
        ];

        foreach ($datePatterns as $pattern) {
            if (preg_match($pattern, $text, $match)) {
                $startDate = $match[1];
                $endDate = $match[2] ?? null;

                // Convert start date
                $dateInfo['start_date'] = $this->standardizeDateFormat($startDate);

                // Handle end date
                if ($endDate && (strtolower($endDate) === 'present' || strtolower($endDate) === 'current')) {
                    $dateInfo['currently_working'] = 'Yes';
                    $dateInfo['experience_type'] = 'current';
                    $dateInfo['end_date'] = null;
                } elseif ($endDate) {
                    $dateInfo['end_date'] = $this->standardizeDateFormat($endDate);
                } else {
                    // If only start date found with "since/from", assume current
                    $dateInfo['currently_working'] = 'Yes';
                    $dateInfo['experience_type'] = 'current';
                    $dateInfo['end_date'] = null;
                }

                return $dateInfo;
            }
        }

        // Look for "current" or "present" keywords alone
        if (preg_match('/\b(?:current|present|ongoing|active)\b/i', $text)) {
            $dateInfo['currently_working'] = 'Yes';
            $dateInfo['experience_type'] = 'current';
        }

        return $dateInfo;
    }

    private function extractEmploymentType($text)
    {
        $employmentPatterns = [
            '/\b(full[\-\s]time)\b/i' => 'full-time',
            '/\b(part[\-\s]time)\b/i' => 'part-time',
            '/\b(contract|contractor)\b/i' => 'contract',
            '/\b(freelance|freelancer)\b/i' => 'freelance',
            '/\b(intern|internship)\b/i' => 'internship',
            '/\b(temporary|temp)\b/i' => 'contract',
            '/\b(consultant|consulting)\b/i' => 'contract'
        ];

        foreach ($employmentPatterns as $pattern => $type) {
            if (preg_match($pattern, $text)) {
                return $type;
            }
        }

        return 'full-time'; // Default
    }

    private function extractResponsibilities($text)
    {
        // Look for responsibility sections
        $responsibilityPatterns = [
            '/(?:responsibilities|duties|role|tasks|job\s+description)[\s:]*\n?(.*?)(?=\n\s*(?:[A-Z][A-Z\s]+:|$))/is',
            '/(?:achievements|accomplishments|key\s+achievements)[\s:]*\n?(.*?)(?=\n\s*(?:[A-Z][A-Z\s]+:|$))/is'
        ];

        foreach ($responsibilityPatterns as $pattern) {
            if (preg_match($pattern, $text, $match)) {
                $responsibilities = trim($match[1]);
                $responsibilities = preg_replace('/^\s*[•\-\*\+]\s*/m', '• ', $responsibilities);

                if (strlen($responsibilities) > 20) {
                    return $responsibilities;
                }
            }
        }

        // Fallback: clean up the entire text as responsibilities
        $cleaned = trim($text);
        $cleaned = preg_replace('/^.*?(?:responsibilities|duties|role|tasks)[\s:]*\n?/is', '', $cleaned);
        $cleaned = preg_replace('/^\s*[•\-\*\+]\s*/m', '• ', $cleaned);

        return strlen($cleaned) > 20 && strlen($cleaned) < 1000 ? $cleaned : '';
    }

    public function updateJobseekerProfileFromParsedData($userId, $parsedData)
    {
        try {
            require_once __DIR__ . '/Jobseeker.php';
            $jobseekerModel = new Jobseeker();

            // Get or create jobseeker record
            $jobseeker = $jobseekerModel->findByUserId($userId);
            if (!$jobseeker) {
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

            $updateResult = $jobseekerModel->updateProfile($userId, $profileData);
            if (!$updateResult) {
            }

            // ENHANCED: Better work experience handling
            if (!empty($parsedData['experience']) && is_array($parsedData['experience'])) {

                foreach ($parsedData['experience'] as $index => $exp) {
                    if (empty($exp['job_title']) || empty($exp['company_name'])) {

                        continue;
                    }

                    // Check if this experience already exists to avoid duplicates
                    $existingExp = $this->checkDuplicateExperience($jobseekerId, $exp, $jobseekerModel);
                    if ($existingExp) {
                        continue;
                    }

                    $result = $jobseekerModel->saveWorkExperience($jobseekerId, $exp);
                }
            }

            // Update skills (existing logic)
            if (!empty($parsedData['skills'])) {
                // Only delete skills if we have new ones to replace them
                $existingSkills = $jobseekerModel->getSkills($userId);
                if (empty($existingSkills) || count($parsedData['skills']) > count($existingSkills)) {
                    $jobseekerModel->deleteSkills($jobseekerId);
                    foreach ($parsedData['skills'] as $skill) {
                        $jobseekerModel->saveSkill($jobseekerId, $skill);
                    }
                }
            }

            // Update education (existing logic)
            if (!empty($parsedData['education']) && !empty($parsedData['education']['school_name'])) {
                $existingEducation = $jobseekerModel->getEducation($userId);
                if (empty($existingEducation) || empty($existingEducation[0]['school_name'])) {
                    if (!empty($existingEducation)) {
                        foreach ($existingEducation as $edu) {
                            $stmt = $jobseekerModel->getPdo()->prepare("DELETE FROM jobseeker_education WHERE education_id = ?");
                            $stmt->execute([$edu['education_id']]);
                        }
                    }
                    $jobseekerModel->saveEducation($jobseekerId, $parsedData['education']);
                }
            }

            // Update certificates (existing logic)
            if (!empty($parsedData['certificates'])) {
                foreach ($parsedData['certificates'] as $index => $cert) {
                    if (empty($cert['certificate_title'])) {
                        continue;
                    }

                    // Check if certificate already exists
                    $existingCert = $this->checkDuplicateCertificate($jobseekerId, $cert, $jobseekerModel);
                    if ($existingCert) {
                        continue;
                    }

                    $result = $jobseekerModel->saveCertificate($jobseekerId, $cert);
                }
            }

            return [
                'success' => true,
                'message' => 'Profile updated successfully from resume',
                'data' => $parsedData
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Failed to update profile: ' . $e->getMessage()
            ];
        }
    }

    private function checkDuplicateExperience($jobseekerId, $newExp, $jobseekerModel)
    {
        try {
            // Get existing work experience
            $stmt = $jobseekerModel->getPdo()->prepare("
                SELECT * FROM jobseeker_work_experience 
                WHERE jobseeker_id = ? 
                AND LOWER(job_title) = LOWER(?) 
                AND LOWER(company_name) = LOWER(?)
            ");
            $stmt->execute([$jobseekerId, $newExp['job_title'], $newExp['company_name']]);

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error checking duplicate experience: " . $e->getMessage());
            return false;
        }
    }

    private function checkDuplicateCertificate($jobseekerId, $newCert, $jobseekerModel)
    {
        try {
            $stmt = $jobseekerModel->getPdo()->prepare("
                SELECT * FROM jobseeker_certificates 
                WHERE jobseeker_id = ? 
                AND LOWER(certificate_title) = LOWER(?)
            ");
            $stmt->execute([$jobseekerId, $newCert['certificate_title']]);

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error checking duplicate certificate: " . $e->getMessage());
            return false;
        }
    }

    private function standardizeDateFormat($dateString)
    {
        // Try parsing various date formats
        $formats = [
            'Y-m-d', // 2023-01-31
            'Y/m/d', // 2023/01/31
            'Y.m.d', // 2023.01.31
            'd-m-Y', // 31-01-2023
            'd/m/Y', // 31/01/2023
            'd.m.Y', // 31.01.2023
            'M j, Y', // Jan 31, 2023
            'F j, Y', // January 31, 2023
            'Y' // Just the year, e.g., 2023
        ];

        foreach ($formats as $format) {
            $dateTime = DateTime::createFromFormat($format, $dateString);
            if ($dateTime) {
                return $dateTime->format('Y-m-d');
            }
        }

        // If no formats matched, return the original string or handle as needed
        return $dateString;
    }

    private function extractEducation($text)
    {
        $education = [
            'school_name' => '',
            'education_level' => '',
            'field_of_study' => '',
            'start_year' => null,
            'end_year' => null,
            'graduation_status' => 'Graduated'
        ];

        // Enhanced patterns to find education sections
        $sectionPatterns = [
            '/(?:education|academic\s+background|educational\s+background)[\s:]*\n?(.*?)(?=\n\s*(?:experience|work|employment|skills|projects?|certificates?|certifications?|languages?|references?|hobbies|interests|$))/is',
            '/(?:academic|educational)[\s:]*\n?(.*?)(?=\n\s*(?:experience|work|employment|skills|projects?|certificates?|certifications?|languages?|references?|hobbies|interests|$))/is'
        ];

        $educationText = '';
        foreach ($sectionPatterns as $pattern) {
            if (preg_match($pattern, $text, $match)) {
                $educationText = trim($match[1]);
                break;
            }
        }

        if (empty($educationText)) {
            return $education;
        }

        // Extract school name using advanced method
        $schoolName = $this->extractSchoolNameAdvanced($educationText);
        if ($schoolName) {
            $education['school_name'] = $schoolName;
        }

        // Extract education level
        $educationLevel = $this->extractEducationLevel($educationText);
        if ($educationLevel) {
            $education['education_level'] = $educationLevel;
        }

        // Extract field of study
        $fieldOfStudy = $this->extractFieldOfStudy($educationText);
        if ($fieldOfStudy) {
            $education['field_of_study'] = $fieldOfStudy;
        }

        // Extract years
        $years = $this->extractEducationYears($educationText);
        if ($years) {
            $education = array_merge($education, $years);
        }

        return $education;
    }

    private function extractEducationLevel($text)
    {
        $levelPatterns = [
            // PhD patterns
            '/\b(?:phd|ph\.d\.|doctor\s+of\s+philosophy|doctoral|doctorate)\b/i' => 'Doctoral Degree',

            // Master's patterns
            '/\b(?:master|masters|ms|ma|mba|m\.s\.|m\.a\.|m\.b\.a\.|master\s+of\s+science|master\s+of\s+arts|master\s+of\s+business)\b/i' => 'Master\'s Degree',

            // Bachelor's patterns
            '/\b(?:bachelor|bachelors|bs|ba|bsc|b\.s\.|b\.a\.|b\.sc\.|bachelor\s+of\s+science|bachelor\s+of\s+arts)\b/i' => 'Bachelor\'s Degree',

            // Associate patterns
            '/\b(?:associate|associates|aa|as|a\.a\.|a\.s\.|associate\s+degree)\b/i' => 'Associate Degree',

            // High school patterns
            '/\b(?:high\s+school|secondary|senior\s+high|grade\s+12|k-12|k12)\b/i' => 'High School',

            // Certificate patterns
            '/\b(?:certificate|certification|diploma|cert\.)\b/i' => 'Certificate',

            // College patterns (generic)
            '/\b(?:college|university|undergraduate)\b/i' => 'Bachelor\'s Degree'
        ];

        foreach ($levelPatterns as $pattern => $level) {
            if (preg_match($pattern, $text)) {
                return $level;
            }
        }

        return 'Bachelor\'s Degree'; // Default
    }

    private function extractFieldOfStudy($text)
    {
        // Common field of study patterns
        $fieldPatterns = [
            // Computer Science & IT
            '/\b(?:computer\s+science|information\s+technology|software\s+engineering|information\s+systems|cybersecurity|data\s+science)\b/i',

            // Engineering
            '/\b(?:electrical\s+engineering|mechanical\s+engineering|civil\s+engineering|chemical\s+engineering|industrial\s+engineering)\b/i',

            // Business
            '/\b(?:business\s+administration|management|marketing|finance|accounting|economics|human\s+resources)\b/i',

            // Healthcare
            '/\b(?:nursing|medicine|pharmacy|psychology|biology|chemistry|physics)\b/i',

            // Liberal Arts
            '/\b(?:english|history|political\s+science|sociology|anthropology|philosophy|communications)\b/i',

            // Education
            '/\b(?:education|teaching|elementary\s+education|secondary\s+education)\b/i'
        ];

        foreach ($fieldPatterns as $pattern) {
            if (preg_match($pattern, $text, $match)) {
                return ucwords(strtolower(trim($match[0])));
            }
        }

        // Try to find "in [field]" or "of [field]" patterns
        if (preg_match('/\b(?:in|of|major)\s+([a-zA-Z\s]+?)(?:\s|$|,|\.|;)/i', $text, $match)) {
            $field = trim($match[1]);
            if (strlen($field) > 3 && strlen($field) < 50) {
                return ucwords(strtolower($field));
            }
        }

        return '';
    }

    private function extractSchoolNameAdvanced($text)
    {
        // List of Rosario, Batangas schools for specific matching
        $rosarioSchools = [
            'Rosario Institute',
            'St. John Institute',
            'Holy Child Institute',
            'Dagatan National High School',
            'Rosario National High School',
            'Rosario State College',
            'St. John Colleges',
            'St. John Academy',
            'Holy Child Academy'
        ];

        // Try specific school matches first
        foreach ($rosarioSchools as $school) {
            if (stripos($text, $school) !== false) {
                return $school;
            }
        }

        // Common school keywords and patterns
        $patterns = [
            // University patterns
            '/([A-Z][A-Za-z\s&\.\',]+(?:University|College|Institute|Academy))/i',

            // School patterns
            '/([A-Z][A-Za-z\s&\.\',]+(?:School|Seminary|Polytechnic))/i',

            // Education center patterns
            '/([A-Z][A-Za-z\s&\.\',]+(?:Education\s+Center|Training\s+Center|Technical\s+Institute))/i'
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $text, $match)) {
                $schoolName = trim($match[1]);

                // Validate the school name
                if ($this->isValidSchoolName($schoolName)) {
                    return $schoolName;
                }
            }
        }

        // Look for lines that might be school names
        $lines = explode("\n", $text);
        foreach ($lines as $line) {
            $line = trim($line);

            // Skip obvious non-school lines
            if (empty($line) || strlen($line) < 5 || strlen($line) > 100) {
                continue;
            }

            // Skip lines that look like degrees or dates
            if (preg_match('/^(?:bachelor|master|phd|doctor|associate|certificate|diploma|degree|\d{4})/i', $line)) {
                continue;
            }

            // Look for capitalized words that could be company names
            if (
                preg_match('/^[A-Z][a-zA-Z\s&\.\',]+$/', $line) &&
                !preg_match('/\b(?:experience|work|skills|projects|certificates|languages|references)\b/i', $line)
            ) {

                if ($this->isValidSchoolName($line)) {
                    return $line;
                }
            }
        }

        return '';
    }

    private function isValidSchoolName($name)
    {
        // Common words that indicate it's not a school name
        $invalidWords = [
            'resume',
            'curriculum',
            'vitae',
            'profile',
            'objective',
            'summary',
            'experience',
            'employment',
            'skills',
            'projects',
            'certificates',
            'languages',
            'references',
            'hobbies',
            'interests',
            'work',
            'job',
            'position',
            'career'
        ];

        // Check length
        if (strlen($name) < 5 || strlen($name) > 100) {
            return false;
        }

        // Check for invalid words
        foreach ($invalidWords as $word) {
            if (stripos($name, $word) !== false) {
                return false;
            }
        }

        // Should have some educational keywords or proper capitalization
        $hasEducationalTerms = preg_match('/\b(?:University|College|Institute|Academy|School|Seminary|Polytechnic)\b/i', $name);
        $hasProperCapitalization = preg_match('/^[A-Z][a-zA-Z\s&\.\',]+$/', $name);

        return $hasEducationalTerms || $hasProperCapitalization;
    }

    private function extractEducationYears($text)
    {
        $years = [
            'start_year' => null,
            'end_year' => null,
            'graduation_status' => 'Graduated'
        ];

        // Enhanced year patterns for education
        $yearPatterns = [
            // "2018 - 2022" or "2018 - present"
            '/(\d{4})\s*[-–]\s*(\d{4}|present|current)/i',

            // "September 2018 - May 2022"
            '/(?:january|february|march|april|may|june|july|august|september|october|november|december)\s+(\d{4})\s*[-–]\s*(?:january|february|march|april|may|june|july|august|september|october|november|december)?\s*(\d{4}|present|current)/i',

            // "Class of 2022"
            '/class\s+of\s+(\d{4})/i',

            // "Graduated 2022"
            '/graduated?\s+(\d{4})/i',

            // Single year patterns
            '/\b(\d{4})\b/'
        ];

        foreach ($yearPatterns as $pattern) {
            if (preg_match($pattern, $text, $match)) {
                if (isset($match[2])) {
                    // Range pattern
                    $years['start_year'] = (int)$match[1];
                    if (strtolower($match[2]) === 'present' || strtolower($match[2]) === 'current') {
                        $years['graduation_status'] = 'Currently Enrolled';
                    } else {
                        $years['end_year'] = (int)$match[2];
                    }
                } else {
                    // Single year - assume it's graduation year
                    $years['end_year'] = (int)$match[1];
                    $years['start_year'] = $years['end_year'] - 4; // Assume 4-year program
                }
                break;
            }
        }

        // Validate years
        $currentYear = (int)date('Y');
        if ($years['start_year'] && ($years['start_year'] < 1950 || $years['start_year'] > $currentYear)) {
            $years['start_year'] = null;
        }
        if ($years['end_year'] && ($years['end_year'] < 1950 || $years['end_year'] > ($currentYear + 6))) {
            $years['end_year'] = null;
        }

        return $years;
    }

    private function extractCertificates($text)
    {
        $certificates = [];

        // Enhanced patterns to find certificate sections
        $sectionPatterns = [
            '/(?:certificates?|certifications?|professional\s+certifications?|licenses?)[\s:]*\n?(.*?)(?=\n\s*(?:education|experience|work|employment|skills|projects?|languages?|references?|hobbies|interests|$))/is',
            '/(?:awards?|achievements?|honors?)[\s:]*\n?(.*?)(?=\n\s*(?:education|experience|work|employment|skills|projects?|languages?|references?|hobbies|interests|$))/is'
        ];

        $certificateText = '';
        foreach ($sectionPatterns as $pattern) {
            if (preg_match($pattern, $text, $match)) {
                $certificateText = trim($match[1]);
                break;
            }
        }

        if (empty($certificateText)) {
            return [];
        }

        // Split certificates by common separators
        $certificateEntries = $this->splitCertificateEntries($certificateText);

        foreach ($certificateEntries as $index => $entry) {
            $entry = trim($entry);
            if (empty($entry) || strlen($entry) < 5) {
                continue;
            }

            $certificate = $this->parseCertificateEntry($entry);
            if (!empty($certificate['certificate_name'])) {
                $certificates[] = $certificate;
            }
        }

        return array_slice($certificates, 0, 10); // Limit to 10 certificates
    }

    private function splitCertificateEntries($text)
    {
        // Split by bullet points, line breaks, or numbering
        $entries = preg_split('/(?:\n\s*[•\-\*\+\d\.]\s*|\n\s*\n)/', $text);

        // Filter out empty entries
        $entries = array_filter(array_map('trim', $entries), function ($entry) {
            return strlen($entry) > 5;
        });

        return array_values($entries);
    }

    private function parseCertificateEntry($text)
    {
        $certificate = [
            'certificate_title' => '', // Make sure this key is always used
            'issuing_organization' => '',
            'issue_date' => null,
            'expiration_date' => null,
            'credential_id' => ''
        ];

        // Clean the text
        $cleanText = preg_replace('/^[•\-\*\+\d\.\s]+/', '', $text);
        $cleanText = trim($cleanText);

        // Extract certificate name (usually the first line or before " - ")
        if (preg_match('/^([^-\n]+?)(?:\s*-\s*|\s*\|\s*|\s*by\s+|\s*from\s+|$)/i', $cleanText, $match)) {
            $certificate['certificate_title'] = trim($match[1]);
        }

        // If no title extracted, use the cleaned text as title
        if (empty($certificate['certificate_title']) && !empty($cleanText)) {
            $lines = explode("\n", $cleanText);
            $certificate['certificate_title'] = trim($lines[0]);
        }

        // Extract issuing organization
        if (preg_match('/(?:from|by|issued\s+by)\s+([^-\n,]+?)(?:\s*[-,]|\s*$)/i', $text, $match)) {
            $certificate['issuing_organization'] = trim($match[1]);
        } elseif (preg_match('/\b([A-Z][a-zA-Z\s&]+(?:Inc|Corp|Ltd|LLC|Company|Corporation|Institute|Academy|University|College|Organization|Association|Society))\b/i', $text, $match)) {
            $certificate['issuing_organization'] = trim($match[1]);
        }

        // Extract dates
        if (preg_match('/(\d{4}|\w+\s+\d{4})/i', $text, $match)) {
            $certificate['issue_date'] = $this->standardizeDateFormat($match[1]);
        }

        // Extract credential ID if present
        if (preg_match('/(?:id|credential|certificate)[\s#:]*([A-Z0-9\-]+)/i', $text, $match)) {
            $certificate['credential_id'] = trim($match[1]);
        }

        return $certificate;
    }
}
