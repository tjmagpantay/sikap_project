<?php
require 'config.php'; // DB connection

$file = __DIR__ . "/esco_csv/skills_en.csv"; // ✅ fixed path

if (!file_exists($file)) {
    die("CSV file not found: $file");
}

if (($handle = fopen($file, "r")) !== false) {
    $header = fgetcsv($handle, 10000, ","); // ✅ fixed delimiter
    $count = 0;

    while (($data = fgetcsv($handle, 10000, ",")) !== false) {
        $row = array_combine($header, $data);

        $conceptUri   = trim($row['conceptUri']);
        $skillName    = trim($row['preferredLabel']);
        $description  = trim($row['definition'] ?? '');

        if (!$conceptUri || !$skillName) {
            continue; // skip invalid rows
        }

        // Insert or update skill
        $stmt = $conn->prepare("
            INSERT INTO esco_skills (concept_uri, skill_name, description)
            VALUES (?, ?, ?)
            ON DUPLICATE KEY UPDATE skill_name=VALUES(skill_name), description=VALUES(description)
        ");
        $stmt->bind_param("sss", $conceptUri, $skillName, $description);
        $stmt->execute();

        $skillId = $conn->insert_id ?: $conn->query("SELECT id FROM esco_skills WHERE concept_uri='".$conn->real_escape_string($conceptUri)."'")->fetch_assoc()['id'];

        // Insert aliases (altLabels + hiddenLabels)
        $aliases = [];
        if (!empty($row['altLabels'])) {
            $aliases = array_merge($aliases, explode("\n", $row['altLabels']));
        }
        if (!empty($row['hiddenLabels'])) {
            $aliases = array_merge($aliases, explode("\n", $row['hiddenLabels']));
        }

        foreach ($aliases as $alias) {
            $alias = trim($alias);
            if ($alias !== '') {
                $stmtAlias = $conn->prepare("
                    INSERT IGNORE INTO esco_skill_aliases (skill_id, alias)
                    VALUES (?, ?)
                ");
                $stmtAlias->bind_param("is", $skillId, $alias);
                $stmtAlias->execute();
            }
        }

        $count++;
    }
    fclose($handle);

    echo "✅ Imported/Updated $count skills into ESCO tables.";
}
?>
