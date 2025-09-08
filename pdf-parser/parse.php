<?php
require 'vendor/autoload.php';
require 'config.php'; // DB connection

use Smalot\PdfParser\Parser;

// Ensure uploads folder exists
if (!file_exists('uploads')) {
    mkdir('uploads', 0777, true);
}

// --- Helper: Normalize ESCO skill (return label + URI) ---
function normalizeEscoSkill($text, $escoSkills, $escoAliases)
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
        if (stripos(strtolower($text), $alias) !== false) {
            $matches[$escoSkills[$skill_id]['name']] = $escoSkills[$skill_id]['uri'];
        }
    }

    return $matches;
}

// --- Helper: Extract comprehensive resume data ---
function extractResumeData($text)
{
    $data = [];
    $lines = explode("\n", trim($text));
    $cleanLines = array_filter(array_map('trim', $lines));

    // --- Extract Name (improved) ---
    $fullName = '';
    $firstName = '';
    $middleName = '';
    $lastName = '';
    $suffix = '';

    // Method 1: Look for "Full Name:" pattern
    if (preg_match('/(?:full\s*name|name)[\s:]+([A-Z][a-z]+(?:\s+[A-Z][a-z\.]*)*(?:\s+(?:Jr|Sr|III?|IV)\.?)?)/i', $text, $nameMatch)) {
        $fullName = trim($nameMatch[1]);
    }

    // Method 2: Look for name patterns in first few lines (if Method 1 fails)
    if (!$fullName) {
        foreach (array_slice($cleanLines, 0, 5) as $line) {
            // Skip common resume headers
            if (preg_match('/^(resume|curriculum|cv|contact|profile|objective|summary|email|phone|address|linkedin|github)/i', $line)) {
                continue;
            }

            // Look for proper name pattern
            if (preg_match('/^([A-Z][a-z]+(?:\s+[A-Z][a-z\.]*)*(?:\s+(?:Jr|Sr|III?|IV)\.?)?)$/i', $line, $matches)) {
                $fullName = trim($matches[1]);
                break;
            }
        }
    }

    // Method 3: Extract from first line if it looks like a name
    if (!$fullName && !empty($cleanLines)) {
        $firstLine = $cleanLines[0];
        // Remove common prefixes and check if what remains is a name
        $cleanFirstLine = preg_replace('/^(full\s*name[\s:]*|name[\s:]*)/i', '', $firstLine);
        if (preg_match('/^([A-Z][a-z]+(?:\s+[A-Z][a-z\.]*)*(?:\s+(?:Jr|Sr|III?|IV)\.?)?)$/i', trim($cleanFirstLine), $matches)) {
            $fullName = trim($matches[1]);
        }
    }    // Parse name components
    if ($fullName) {
        $nameParts = explode(' ', $fullName);
        $nameParts = array_filter($nameParts); // Remove empty elements

        if (count($nameParts) >= 2) {
            $firstName = $nameParts[0];
            $lastName = end($nameParts);

            // Check for suffix
            $suffixPattern = '/\b(Jr\.?|Sr\.?|III?|IV|V)\b/i';
            if (preg_match($suffixPattern, $lastName, $suffixMatch)) {
                $suffix = $suffixMatch[0];
                $lastName = trim(preg_replace($suffixPattern, '', $lastName));
            }

            // Middle name(s)
            if (count($nameParts) > 2) {
                $middleNames = array_slice($nameParts, 1, -1);
                // Remove suffix from middle names if present
                $middleNames = array_filter($middleNames, function ($name) use ($suffixPattern) {
                    return !preg_match($suffixPattern, $name);
                });
                $middleName = implode(' ', $middleNames);
            }
        }
    }

    // --- Extract Email ---
    preg_match('/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[A-Z|a-z]{2,}/', $text, $emailMatch);
    $email = $emailMatch[0] ?? '';

    // --- Extract Phone ---
    preg_match('/(\+?63|0)?[\s-]?(\d{3}[\s-]?\d{3}[\s-]?\d{4}|\d{4}[\s-]?\d{3}[\s-]?\d{4}|\(\d{3}\)[\s-]?\d{3}[\s-]?\d{4})/', $text, $phoneMatch);
    $phone = $phoneMatch[0] ?? '';

    // --- Extract Birthdate ---
    $birthdate = '';
    // Pattern 1: Look for explicit birthdate labels
    if (preg_match('/(?:born|birth|dob|date\s+of\s+birth|birthday)[\s:]*(\d{1,2}[\/\-\.]\d{1,2}[\/\-\.]\d{4}|\d{4}[\/\-\.]\d{1,2}[\/\-\.]\d{1,2}|(?:january|february|march|april|may|june|july|august|september|october|november|december)\s+\d{1,2},?\s+\d{4})/i', $text, $bdMatch)) {
        $birthdate = trim($bdMatch[1]);
    }
    // Pattern 2: Look for age-based birthdate calculation
    elseif (preg_match('/age[\s:]*(\d{2})/i', $text, $ageMatch)) {
        $age = intval($ageMatch[1]);
        $currentYear = date('Y');
        $birthYear = $currentYear - $age;
        $birthdate = $birthYear; // Just the year if we only have age
    }

    // --- Extract Gender/Sex ---
    $gender = '';
    if (preg_match('/(?:gender|sex)[\s:]*(?:male|female|m|f)\b/i', $text, $genderMatch)) {
        $genderText = strtolower(trim(preg_replace('/(?:gender|sex)[\s:]*/i', '', $genderMatch[0])));
        if (in_array($genderText, ['male', 'm'])) $gender = 'male';
        if (in_array($genderText, ['female', 'f'])) $gender = 'female';
    }

    // --- Extract Address (improved) ---
    $address = '';

    // Pattern 1: Look for explicit address labels
    if (preg_match('/(?:address|location|residence|home)[\s:]*([^\n]+(?:street|avenue|road|blvd|boulevard|drive|lane|way|city|state|province|country|philippines|usa|america)[^\n]*)/i', $text, $addressMatch)) {
        $address = trim(preg_replace('/(?:address|location|residence|home)[\s:]*/i', '', $addressMatch[0]));
    }
    // Pattern 2: Look for location after contact info
    elseif (preg_match('/(?:location|address)[\s:]*([^\n]+)/i', $text, $locationMatch)) {
        $potential_address = trim(preg_replace('/(?:location|address)[\s:]*/i', '', $locationMatch[0]));
        // Validate it looks like an address (has city/state pattern or common address words)
        if (preg_match('/(?:street|avenue|road|blvd|city|state|province|country|philippines|usa|america|\d{4,5}|,\s*[A-Z]{2})/i', $potential_address)) {
            $address = $potential_address;
        }
    }
    // Pattern 3: Look for City, State pattern
    elseif (preg_match('/([A-Z][a-z]+,\s*[A-Z]{2}(?:,?\s*[A-Z]{3})?)/i', $text, $cityStateMatch)) {
        $address = trim($cityStateMatch[1]);
    }
    // Pattern 4: Look for common address patterns in contact section
    elseif (preg_match('/(?:phone|email).*?\n.*?([^\n]*(?:street|avenue|road|blvd|city|state|province)[^\n]*)/is', $text, $contactAddressMatch)) {
        $address = trim($contactAddressMatch[1]);
    }    // --- Extract Education ---
    $education = [];
    $educationPattern = '/(?:education|academic|qualifications?)\s*:?\s*(.*?)(?=(?:experience|work|employment|skills|projects?|certificates?|languages?|references?|$))/is';
    if (preg_match($educationPattern, $text, $eduMatch)) {
        $eduText = trim($eduMatch[1]);

        // Look for university/institution patterns
        preg_match_all('/([^\n]*(?:university|college|institute|school|academy)[^\n]*)/i', $eduText, $institutions);
        preg_match_all('/(\d{4})\s*[-–]\s*(\d{4}|\w+)/i', $eduText, $yearRanges);
        preg_match_all('/(?:bachelor|master|phd|degree|diploma|certificate)\s+(?:of\s+)?([^\n,]+)/i', $eduText, $degrees);

        for ($i = 0; $i < count($institutions[1]); $i++) {
            $institution = trim($institutions[1][$i] ?? '');
            if (!empty($institution) && strlen($institution) > 5) {
                $education[] = [
                    'institution' => $institution,
                    'degree' => trim($degrees[1][$i] ?? ''),
                    'field' => '', // Will be extracted from degree text
                    'start_year' => $yearRanges[1][$i] ?? '',
                    'end_year' => $yearRanges[2][$i] ?? ''
                ];
            }
        }

        // Limit to reasonable number of education entries
        $education = array_slice($education, 0, 5);
    }

    // --- Extract Work Experience ---
    $experience = [];
    $expPattern = '/(?:experience|employment|work history|professional)\s*:?\s*(.*?)(?=(?:education|skills|projects?|certificates?|languages?|references?|$))/is';
    if (preg_match($expPattern, $text, $expMatch)) {
        $expText = trim($expMatch[1]);

        // Look for job titles and companies
        preg_match_all('/([^\n]*(?:manager|developer|analyst|assistant|coordinator|specialist|officer|engineer|director|supervisor|lead|senior|junior)[^\n]*)/i', $expText, $jobTitles);
        preg_match_all('/(\d{4})\s*[-–]\s*(\d{4}|\w+)/i', $expText, $expYearRanges);

        foreach ($jobTitles[1] as $i => $jobTitle) {
            $cleanJobTitle = trim($jobTitle);
            // Skip if it's too short or looks like a section header
            if (strlen($cleanJobTitle) > 5 && !preg_match('/^(experience|employment|work|skills|education)$/i', $cleanJobTitle)) {
                $experience[] = [
                    'job_title' => $cleanJobTitle,
                    'company' => '', // Extract from context
                    'start_year' => $expYearRanges[1][$i] ?? '',
                    'end_year' => $expYearRanges[2][$i] ?? '',
                    'description' => ''
                ];
            }
        }

        // Limit to reasonable number of experience entries
        $experience = array_slice($experience, 0, 10);
    }

    // --- Extract Certificates ---
    $certificates = [];
    // Improved pattern to stop at other sections
    $certPattern = '/(?:certificates?|certifications?|licenses?|awards?)\s*:?\s*(.*?)(?=(?:projects?|skills?|languages?|references?|hobbies|interests|additional|$))/is';
    if (preg_match($certPattern, $text, $certMatch)) {
        $certText = trim($certMatch[1]);
        $certLines = explode("\n", $certText);

        foreach ($certLines as $line) {
            $line = trim($line);

            // Skip empty lines and section headers
            if (
                empty($line) ||
                preg_match('/^(certificates?|certifications?|licenses?|awards?)[\s:]*$/i', $line) ||
                preg_match('/^(projects?|skills?|languages?|references?|hobbies|interests)[\s:]*$/i', $line)
            ) {
                continue;
            }

            // Skip lines that look like bullet points without content
            if (preg_match('/^[•●▪▫◦‣⁃]\s*$/', $line)) {
                continue;
            }

            // Skip lines that are too short to be meaningful certificates
            if (strlen($line) < 5) {
                continue;
            }

            // Clean up bullet points and numbering
            $cleanLine = preg_replace('/^[•●▪▫◦‣⁃\-\*]\s*/', '', $line);
            $cleanLine = preg_replace('/^\d+\.\s*/', '', $cleanLine);
            $cleanLine = preg_replace('/[^\x00-\x7F]/', '', $cleanLine); // Remove non-ASCII characters
            $cleanLine = trim($cleanLine);

            // Only add if it looks like a meaningful certificate name
            if (!empty($cleanLine) && strlen($cleanLine) >= 5) {
                $certificates[] = $cleanLine;
            }
        }

        // Limit to reasonable number of certificates
        $certificates = array_slice($certificates, 0, 10);
    }

    return [
        'full_name' => $fullName,
        'first_name' => $firstName,
        'middle_name' => $middleName,
        'last_name' => $lastName,
        'suffix' => $suffix,
        'email' => $email,
        'phone' => $phone,
        'birthdate' => $birthdate,
        'gender' => $gender,
        'address' => $address,
        'education' => $education,
        'experience' => $experience,
        'certificates' => $certificates
    ];
}

if (isset($_FILES['resume'])) {
    $fileName = basename($_FILES["resume"]["name"]);
    $targetPath = "uploads/" . $fileName;

    if (move_uploaded_file($_FILES["resume"]["tmp_name"], $targetPath)) {
        try {
            // --- Parse PDF ---
            $parser = new Parser();
            $pdf = $parser->parseFile($targetPath);
            $text = $pdf->getText();

            // --- Extract comprehensive resume data ---
            $resumeData = extractResumeData($text);

            // --- Fetch Manual Skills ---
            $manualSkills = [];
            $result = $conn->query("SELECT skill_name FROM skills_dictionary");
            while ($row = $result->fetch_assoc()) {
                $manualSkills[] = $row['skill_name'];
            }

            // --- Fetch ESCO Preferred Labels ---
            $escoSkills = [];
            $result = $conn->query("SELECT id, skill_name, concept_uri FROM esco_skills");
            while ($row = $result->fetch_assoc()) {
                $escoSkills[$row['id']] = [
                    'name' => $row['skill_name'],
                    'uri'  => $row['concept_uri']
                ];
            }

            // --- Fetch ESCO Aliases ---
            $escoAliases = [];
            $result = $conn->query("SELECT alias, skill_id FROM esco_skill_aliases");
            while ($row = $result->fetch_assoc()) {
                $escoAliases[strtolower($row['alias'])] = $row['skill_id'];
            }

            // --- Find Skills (Manual + ESCO unified) ---
            $foundSkills = [];
            $foundUris = [];

            // Manual skills → check if mapped to ESCO
            $result = $conn->query("
    SELECT sd.skill_name, me.esco_skill_id, es.skill_name AS esco_name, es.concept_uri
    FROM skills_dictionary sd
    LEFT JOIN manual_to_esco me ON sd.id = me.manual_skill_id
    LEFT JOIN esco_skills es ON me.esco_skill_id = es.id
");
            $manualSkills = [];
            while ($row = $result->fetch_assoc()) {
                $manualSkills[] = $row;
            }

            foreach ($manualSkills as $skill) {
                if (stripos($text, $skill['skill_name']) !== false) {
                    if ($skill['esco_skill_id']) {
                        // Store mapped ESCO skill instead of raw manual
                        $foundSkills[] = $skill['esco_name'];
                        $foundUris[]   = $skill['concept_uri'];
                    } else {
                        // No mapping yet → store manual only
                        $foundSkills[] = $skill['skill_name'];
                        $foundUris[]   = null;
                    }
                }
            }



            // ESCO skills → name + URI
            $escoMatches = normalizeEscoSkill($text, $escoSkills, $escoAliases);
            foreach ($escoMatches as $skillName => $uri) {
                $foundSkills[] = $skillName;
                $foundUris[]   = $uri;
            }

            // Deduplicate while keeping pairs aligned
            $uniqueSkills = [];
            $uniqueUris   = [];
            foreach ($foundSkills as $i => $skill) {
                if (!in_array($skill, $uniqueSkills)) {
                    $uniqueSkills[] = $skill;
                    $uniqueUris[]   = $foundUris[$i];
                }
            }

            // --- Save parsed resume to DB ---
            $stmt = $conn->prepare("
                INSERT INTO resumes_parsed_data (full_name, email, phone, skills, skills_uris) 
                VALUES (?, ?, ?, ?, ?)
            ");
            $skillsStr = implode(", ", $uniqueSkills);
            $urisStr   = implode(", ", array_filter($uniqueUris)); // skip nulls
            $stmt->bind_param("sssss", $resumeData['full_name'], $resumeData['email'], $resumeData['phone'], $skillsStr, $urisStr);
            $stmt->execute();
            $stmt->close();

            // --- Display Results ---
?>
            <!DOCTYPE html>
            <html>

            <head>
                <title>Parsed Resume Data</title>
                <meta charset="UTF-8">
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        margin: 20px;
                        background-color: #f5f5f5;
                    }

                    .container {
                        max-width: 800px;
                        margin: 0 auto;
                        background-color: white;
                        padding: 30px;
                        border-radius: 8px;
                        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                    }

                    h2 {
                        color: #333;
                        text-align: center;
                        margin-bottom: 30px;
                    }

                    h3 {
                        color: #2c5aa0;
                        border-bottom: 2px solid #2c5aa0;
                        padding-bottom: 5px;
                        margin-top: 30px;
                    }

                    label {
                        font-weight: bold;
                        color: #555;
                        display: inline-block;
                        margin-bottom: 5px;
                    }

                    input,
                    textarea,
                    select {
                        padding: 8px;
                        border: 1px solid #ddd;
                        border-radius: 4px;
                        font-size: 14px;
                    }

                    fieldset {
                        border: 1px solid #ddd;
                        border-radius: 5px;
                        padding: 15px;
                        margin-bottom: 15px;
                    }

                    legend {
                        font-weight: bold;
                        color: #2c5aa0;
                        padding: 0 10px;
                    }

                    button {
                        background-color: #4CAF50;
                        color: white;
                        padding: 12px 24px;
                        border: none;
                        border-radius: 4px;
                        cursor: pointer;
                        font-size: 16px;
                        margin-top: 20px;
                    }

                    button:hover {
                        background-color: #45a049;
                    }

                    .form-row {
                        display: flex;
                        gap: 20px;
                        align-items: center;
                    }

                    .form-row label {
                        margin-right: 10px;
                    }
                </style>
            </head>

            <body>
                <div class="container">
                    <h2>Parsed Resume Data</h2>
                    <form method="post" action="">
                        <h3>Personal Information</h3>

                        <label>Full Name:</label><br>
                        <input type="text" name="full_name" value="<?= htmlspecialchars($resumeData['full_name']) ?>" style="width: 300px;"><br><br>

                        <label>First Name:</label><br>
                        <input type="text" name="first_name" value="<?= htmlspecialchars($resumeData['first_name']) ?>" style="width: 200px;"><br><br>

                        <label>Middle Name:</label><br>
                        <input type="text" name="middle_name" value="<?= htmlspecialchars($resumeData['middle_name']) ?>" style="width: 200px;"><br><br>

                        <label>Last Name:</label><br>
                        <input type="text" name="last_name" value="<?= htmlspecialchars($resumeData['last_name']) ?>" style="width: 200px;"><br><br>

                        <label>Suffix:</label><br>
                        <input type="text" name="suffix" value="<?= htmlspecialchars($resumeData['suffix']) ?>" style="width: 100px;"><br><br>

                        <label>Email:</label><br>
                        <input type="email" name="email" value="<?= htmlspecialchars($resumeData['email']) ?>" style="width: 300px;"><br><br>

                        <label>Phone Number:</label><br>
                        <input type="text" name="phone" value="<?= htmlspecialchars($resumeData['phone']) ?>" style="width: 200px;"><br><br>

                        <label>Birthdate:</label><br>
                        <input type="text" name="birthdate" value="<?= htmlspecialchars($resumeData['birthdate']) ?>" style="width: 200px;"><br><br>

                        <label>Gender/Sex:</label><br>
                        <select name="gender" style="width: 150px;">
                            <option value="">Select Gender</option>
                            <option value="male" <?= $resumeData['gender'] === 'male' ? 'selected' : '' ?>>Male</option>
                            <option value="female" <?= $resumeData['gender'] === 'female' ? 'selected' : '' ?>>Female</option>
                            <option value="other" <?= $resumeData['gender'] === 'other' ? 'selected' : '' ?>>Other</option>
                        </select><br><br>

                        <label>Address:</label><br>
                        <textarea name="address" rows="3" cols="50"><?= htmlspecialchars($resumeData['address']) ?></textarea><br><br>

                        <h3>Education</h3>
                        <?php if (!empty($resumeData['education'])): ?>
                            <?php foreach ($resumeData['education'] as $i => $edu): ?>
                                <fieldset style="margin-bottom: 15px;">
                                    <legend>Education <?= $i + 1 ?></legend>
                                    <label>Institution/University Name:</label><br>
                                    <input type="text" name="education[<?= $i ?>][institution]" value="<?= htmlspecialchars($edu['institution']) ?>" style="width: 400px;"><br><br>

                                    <label>Degree/Program:</label><br>
                                    <input type="text" name="education[<?= $i ?>][degree]" value="<?= htmlspecialchars($edu['degree']) ?>" style="width: 300px;"><br><br>

                                    <label>Field of Study:</label><br>
                                    <input type="text" name="education[<?= $i ?>][field]" value="<?= htmlspecialchars($edu['field']) ?>" style="width: 300px;"><br><br>

                                    <label>Start Year:</label>
                                    <input type="text" name="education[<?= $i ?>][start_year]" value="<?= htmlspecialchars($edu['start_year']) ?>" style="width: 80px;">

                                    <label>End Year:</label>
                                    <input type="text" name="education[<?= $i ?>][end_year]" value="<?= htmlspecialchars($edu['end_year']) ?>" style="width: 80px;"><br><br>
                                </fieldset>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <fieldset>
                                <legend>Education 1</legend>
                                <label>Institution/University Name:</label><br>
                                <input type="text" name="education[0][institution]" style="width: 400px;"><br><br>

                                <label>Degree/Program:</label><br>
                                <input type="text" name="education[0][degree]" style="width: 300px;"><br><br>

                                <label>Field of Study:</label><br>
                                <input type="text" name="education[0][field]" style="width: 300px;"><br><br>

                                <label>Start Year:</label>
                                <input type="text" name="education[0][start_year]" style="width: 80px;">

                                <label>End Year:</label>
                                <input type="text" name="education[0][end_year]" style="width: 80px;"><br><br>
                            </fieldset>
                        <?php endif; ?>

                        <h3>Work Experience</h3>
                        <?php if (!empty($resumeData['experience'])): ?>
                            <?php foreach ($resumeData['experience'] as $i => $exp): ?>
                                <fieldset style="margin-bottom: 15px;">
                                    <legend>Experience <?= $i + 1 ?></legend>
                                    <label>Job Title:</label><br>
                                    <input type="text" name="experience[<?= $i ?>][job_title]" value="<?= htmlspecialchars($exp['job_title']) ?>" style="width: 300px;"><br><br>

                                    <label>Company Name:</label><br>
                                    <input type="text" name="experience[<?= $i ?>][company]" value="<?= htmlspecialchars($exp['company']) ?>" style="width: 300px;"><br><br>

                                    <label>Start Year:</label>
                                    <input type="text" name="experience[<?= $i ?>][start_year]" value="<?= htmlspecialchars($exp['start_year']) ?>" style="width: 80px;">

                                    <label>End Year:</label>
                                    <input type="text" name="experience[<?= $i ?>][end_year]" value="<?= htmlspecialchars($exp['end_year']) ?>" style="width: 80px;"><br><br>

                                    <label>Job Description:</label><br>
                                    <textarea name="experience[<?= $i ?>][description]" rows="3" cols="50"><?= htmlspecialchars($exp['description']) ?></textarea><br><br>
                                </fieldset>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <fieldset>
                                <legend>Experience 1</legend>
                                <label>Job Title:</label><br>
                                <input type="text" name="experience[0][job_title]" style="width: 300px;"><br><br>

                                <label>Company Name:</label><br>
                                <input type="text" name="experience[0][company]" style="width: 300px;"><br><br>

                                <label>Start Year:</label>
                                <input type="text" name="experience[0][start_year]" style="width: 80px;">

                                <label>End Year:</label>
                                <input type="text" name="experience[0][end_year]" style="width: 80px;"><br><br>

                                <label>Job Description:</label><br>
                                <textarea name="experience[0][description]" rows="3" cols="50"></textarea><br><br>
                            </fieldset>
                        <?php endif; ?>

                        <h3>Skills</h3>
                        <label>Skills:</label><br>
                        <textarea name="skills" rows="4" cols="50"><?= htmlspecialchars($skillsStr) ?></textarea><br><br>

                        <h3>Certificates (Optional)</h3>
                        <?php if (!empty($resumeData['certificates'])): ?>
                            <?php foreach ($resumeData['certificates'] as $i => $cert): ?>
                                <label>Certificate <?= $i + 1 ?>:</label><br>
                                <input type="text" name="certificates[<?= $i ?>]" value="<?= htmlspecialchars($cert) ?>" style="width: 400px;"><br><br>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <label>Certificate 1:</label><br>
                            <input type="text" name="certificates[0]" style="width: 400px;"><br><br>
                        <?php endif; ?>

                        <button type="submit" style="background-color: #4CAF50; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer;">Save Data</button>
                    </form>
                </div>
            </body>

            </html>
<?php

        } catch (Exception $e) {
            echo "Error parsing PDF: " . $e->getMessage();
        }
    } else {
        echo "Error uploading file.";
    }
}
?>