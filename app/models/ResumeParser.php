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
            // Load ESCO skills (same as prototype)
            $stmt = $this->db->prepare("SELECT id, skill_name, concept_uri FROM esco_skills");
            $stmt->execute();
            $this->escoSkills = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $this->escoSkills[$row['id']] = [
                    'name' => $row['skill_name'],
                    'uri' => $row['concept_uri']
                ];
            }

            // Load ESCO aliases (same as prototype)
            $stmt = $this->db->prepare("SELECT alias, skill_id FROM esco_skill_aliases");
            $stmt->execute();
            $this->escoAliases = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $this->escoAliases[strtolower($row['alias'])] = $row['skill_id'];
            }

            // Load manual skills with ESCO mapping (same as prototype)
            $stmt = $this->db->prepare("
                SELECT sd.skill_name, me.esco_skill_id, es.skill_name AS esco_name, es.concept_uri
                FROM skills_dictionary sd
                LEFT JOIN manual_to_esco me ON sd.id = me.manual_skill_id
                LEFT JOIN esco_skills es ON me.esco_skill_id = es.id
            ");
            $stmt->execute();
            $this->manualSkills = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $this->manualSkills[] = $row;
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

    // Use the EXACT same hybrid skill extraction as your prototype
    private function extractSkillsHybrid($text)
    {
        $foundSkills = [];
        $foundUris = [];

        // Step 1: Manual skills → check if mapped to ESCO (EXACT same logic as prototype)
        foreach ($this->manualSkills as $skill) {
            if (stripos($text, $skill['skill_name']) !== false) {
                if ($skill['esco_skill_id']) {
                    // Store mapped ESCO skill instead of raw manual
                    $foundSkills[] = $skill['esco_name'];
                    $foundUris[] = $skill['concept_uri'];
                } else {
                    // No mapping yet → store manual only
                    $foundSkills[] = $skill['skill_name'];
                    $foundUris[] = null;
                }
            }
        }

        // Step 2: ESCO skills → name + URI (EXACT same logic as prototype)
        $escoMatches = $this->normalizeEscoSkill($text, $this->escoSkills, $this->escoAliases);
        foreach ($escoMatches as $skillName => $uri) {
            $foundSkills[] = $skillName;
            $foundUris[] = $uri;
        }

        // Step 3: Deduplicate while keeping pairs aligned (EXACT same logic as prototype)
        $uniqueSkills = [];
        $uniqueUris = [];
        foreach ($foundSkills as $i => $skill) {
            if (!in_array($skill, $uniqueSkills)) {
                $uniqueSkills[] = $skill;
                $uniqueUris[] = $foundUris[$i];
            }
        }

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
        if (preg_match('/(?:full\s*name|name)[\s:]+([A-Z][a-z]+(?:\s+[A-Z][a-z\.]*)*(?:\s+(?:Jr|Sr|III?|IV)\.?)?)/i', $text, $nameMatch)) {
            $fullName = trim($nameMatch[1]);
        }

        // Method 2: Look for name patterns in first few lines
        if (!$fullName && !empty($cleanLines)) {
            foreach (array_slice($cleanLines, 0, 3) as $line) {
                if (preg_match('/^([A-Z][a-z]+(?:\s+[A-Z][a-z\.]*)*(?:\s+(?:Jr|Sr|III?|IV)\.?)?)$/', $line, $match)) {
                    $fullName = trim($match[1]);
                    break;
                }
            }
        }

        // Parse name components
        if ($fullName) {
            $nameParts = explode(' ', $fullName);
            $suffixes = ['Jr', 'Sr', 'III', 'IV', 'Jr.', 'Sr.', 'III.', 'IV.'];

            // Check for suffix
            $lastPart = end($nameParts);
            if (in_array($lastPart, $suffixes)) {
                $suffix = array_pop($nameParts);
            }

            if (count($nameParts) >= 2) {
                $firstName = $nameParts[0];
                $lastName = array_pop($nameParts);
                $middleName = implode(' ', $nameParts);
            } elseif (count($nameParts) == 1) {
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

    private function extractWorkExperience($text)
    {
        $experiences = [];

        // Look for experience sections
        if (preg_match_all('/(?:experience|employment|work\s+history)[\s:]*([^\n]+(?:\n[^\n]*)*?)(?=\n\s*(?:[A-Z][A-Z\s]+|$))/i', $text, $matches)) {
            foreach ($matches[1] as $expText) {
                $experience = $this->parseExperienceEntry($expText);
                if (!empty($experience['job_title'])) {
                    $experiences[] = $experience;
                }
            }
        }

        return $experiences;
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

        // Extract job title (usually first line)
        $lines = explode("\n", trim($text));
        if (!empty($lines[0])) {
            $experience['job_title'] = trim($lines[0]);
        }

        // Extract company name
        if (preg_match('/(?:at|@)\s+([^\n,]+)/i', $text, $match)) {
            $experience['company_name'] = trim($match[1]);
        }

        // Extract dates
        if (preg_match('/(\d{4})\s*[-–]\s*(\d{4}|present|current)/i', $text, $match)) {
            $experience['start_date'] = $match[1] . '-01-01';
            if (strtolower($match[2]) === 'present' || strtolower($match[2]) === 'current') {
                $experience['currently_working'] = 'Yes';
            } else {
                $experience['end_date'] = $match[2] . '-12-31';
            }
        }

        $experience['responsibilities'] = trim($text);

        return $experience;
    }

    private function extractEducation($text)
    {
        $education = [];

        if (preg_match('/(?:education|academic|qualification)[\s:]*([^\n]+(?:\n[^\n]*)*?)(?=\n\s*(?:[A-Z][A-Z\s]+|$))/i', $text, $match)) {
            $eduText = $match[1];

            $education = [
                'school_name' => '',
                'education_level' => 'Bachelor',
                'field_of_study' => '',
                'start_date' => null,
                'end_date' => null
            ];

            // Extract school name
            if (preg_match('/(?:university|college|institute|school)\s+([^\n,]+)/i', $eduText, $match)) {
                $education['school_name'] = trim($match[0]);
            }

            // Extract degree level
            if (preg_match('/(bachelor|master|phd|doctorate|associate|diploma)/i', $eduText, $match)) {
                $level = strtolower($match[1]);
                switch ($level) {
                    case 'bachelor':
                        $education['education_level'] = 'Bachelor';
                        break;
                    case 'master':
                        $education['education_level'] = 'Master';
                        break;
                    case 'phd':
                    case 'doctorate':
                        $education['education_level'] = 'Doctorate';
                        break;
                    case 'associate':
                        $education['education_level'] = 'Associate';
                        break;
                    case 'diploma':
                        $education['education_level'] = 'Vocational';
                        break;
                }
            }

            // Extract field of study
            if (preg_match('/(?:in|of)\s+([^\n,]+)/i', $eduText, $match)) {
                $education['field_of_study'] = trim($match[1]);
            }

            // Extract graduation year
            if (preg_match('/(\d{4})/', $eduText, $match)) {
                $education['end_date'] = $match[1] . '-12-31';
                $education['start_date'] = ($match[1] - 4) . '-01-01';
            }
        }

        return $education;
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

    private function standardizeDateFormat($dateString)
    {
        $dateString = trim($dateString);

        // Try different date formats
        $formats = ['Y-m-d', 'm/d/Y', 'd/m/Y', 'M d, Y', 'F d, Y'];

        foreach ($formats as $format) {
            $date = DateTime::createFromFormat($format, $dateString);
            if ($date !== false) {
                return $date->format('Y-m-d');
            }
        }

        return null;
    }

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

            // Add skills
            if (!empty($parsedData['skills'])) {
                $jobseekerModel->deleteSkills($jobseekerId);
                foreach ($parsedData['skills'] as $skill) {
                    $jobseekerModel->saveSkill($jobseekerId, $skill);
                }
            }

            // Add work experience
            if (!empty($parsedData['experience'])) {
                foreach ($parsedData['experience'] as $exp) {
                    $jobseekerModel->saveWorkExperience($jobseekerId, $exp);
                }
            }

            // Add education
            if (!empty($parsedData['education']) && !empty($parsedData['education']['school_name'])) {
                $jobseekerModel->saveEducation($jobseekerId, $parsedData['education']);
            }

            // Add certificates
            if (!empty($parsedData['certificates'])) {
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
}
