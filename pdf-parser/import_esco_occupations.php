<?php
require 'config.php'; // DB connection

/**
 * Helper: open CSV safely
 */
function readCsv($filePath, $hasHeader = true)
{
    $rows = [];
    if (!file_exists($filePath)) {
        echo "❌ File not found: $filePath\n";
        return $rows;
    }

    $handle = fopen($filePath, "r");
    if ($handle === false) return $rows;

    // Detect delimiter from first line
    $firstLine = fgets($handle);
    rewind($handle);

    $delimiter = ",";
    if (substr_count($firstLine, ";") > substr_count($firstLine, ",")) {
        $delimiter = ";";
    } elseif (substr_count($firstLine, "\t") > 0) {
        $delimiter = "\t";
    }

    // Skip header if exists
    if ($hasHeader) {
        $header = fgetcsv($handle, 10000, $delimiter);
        echo "✔ Header: " . implode(", ", $header) . "\n";
    }

    while (($data = fgetcsv($handle, 10000, $delimiter)) !== false) {
        $rows[] = $data;
    }
    fclose($handle);

    echo "✔ Detected delimiter '$delimiter' in $filePath, loaded " . count($rows) . " rows\n";
    return $rows;
}


/**
 * Import Occupations
 */
function importOccupations($conn, $csvFile)
{
    $rows = readCsv($csvFile, true);
    $stmt = $conn->prepare("
        INSERT IGNORE INTO esco_occupations (concept_uri, occupation_name, description) 
        VALUES (?, ?, ?)
    ");

    $count = 0;
    foreach ($rows as $row) {
        $uri  = trim($row[1] ?? '');   // conceptUri (column 1)
        $label = trim($row[3] ?? '');  // preferredLabel (column 3)
        $desc = trim($row[12] ?? '');  // description (column 12)

        if (!$uri || !$label) continue; // skip bad rows

        $stmt->bind_param("sss", $uri, $label, $desc);
        $stmt->execute();
        $count++;
    }

    $stmt->close();
    echo "✔ Imported $count occupations\n";
}

/**
 * Import Occupation-Skill Relations
 */
function importOccupationSkillRelations($conn, $csvFile)
{
    $rows = readCsv($csvFile, true);

    // Prepare queries
    $occStmt = $conn->prepare("SELECT id FROM esco_occupations WHERE concept_uri = ?");
    $skillStmt = $conn->prepare("SELECT id FROM esco_skills WHERE concept_uri = ?");
    $insertStmt = $conn->prepare("
        INSERT IGNORE INTO esco_occupation_skills (occupation_id, skill_id, relation_type) 
        VALUES (?, ?, ?)
    ");

    $count = 0;
    $skipped = 0;
    foreach ($rows as $row) {
        $occUri  = trim($row[0] ?? '');       // occupationUri
        $relType = strtolower(trim($row[1] ?? 'essential')); // relationType  
        $skillType = trim($row[2] ?? '');     // skillType (not used but for clarity)
        $skillUri = trim($row[3] ?? '');      // skillUri

        if (!$occUri || !$skillUri) continue;

        // Find occupation ID
        $occId = null;
        $occStmt->bind_param("s", $occUri);
        $occStmt->execute();
        $occStmt->bind_result($occId);
        $occStmt->fetch();
        $occStmt->free_result();

        if (!$occId) {
            $skipped++;
            if ($skipped <= 5) { // Only show first 5 warnings
                echo "⚠️ Skipped occupationUri not found: $occUri\n";
            }
            continue;
        }

        // Find skill ID
        $skillId = null;
        $skillStmt->bind_param("s", $skillUri);
        $skillStmt->execute();
        $skillStmt->bind_result($skillId);
        $skillStmt->fetch();
        $skillStmt->free_result();

        if (!$skillId) {
            $skipped++;
            if ($skipped <= 5) { // Only show first 5 warnings
                echo "⚠️ Skipped skillUri not found: $skillUri\n";
            }
            continue;
        }

        // Insert relation
        $insertStmt->bind_param("iis", $occId, $skillId, $relType);
        $insertStmt->execute();
        $count++;

        // Progress indicator for large datasets
        if ($count % 1000 == 0) {
            echo "✔ Processed $count relations...\n";
        }
    }

    $occStmt->close();
    $skillStmt->close();
    $insertStmt->close();

    echo "✔ Imported $count occupation-skill relations\n";
    if ($skipped > 0) {
        echo "⚠️ Skipped $skipped relations due to missing occupations/skills\n";
    }
}


// Run imports
importOccupations($conn, "esco_csv/occupations_en.csv");
importOccupationSkillRelations($conn, "esco_csv/occupationSkillRelations_en.csv");

echo "✅ ESCO Occupations + Relations import completed!\n";
