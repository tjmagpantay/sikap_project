<?php

/**
 * Script to update completion statuses for existing employers
 * Run this after applying the database migration
 */

require_once __DIR__ . '/config/sikap_db.php';
require_once __DIR__ . '/app/models/Employer.php';

try {
    $employerModel = new Employer();

    // Get all employers
    $config = require __DIR__ . '/config/sikap_db.php';
    $db = new PDO(
        "mysql:host={$config['db_host']};dbname={$config['db_name']}",
        $config['db_user'],
        $config['db_pass']
    );
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT employer_id FROM employer";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $employers = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "Found " . count($employers) . " employers to update...\n";

    $updated = 0;
    foreach ($employers as $employer) {
        $employer_id = $employer['employer_id'];

        // Update employer completion status
        $employerModel->updateEmployerCompletionStatus($employer_id);

        // Update business completion status
        $employerModel->updateBusinessCompletionStatus($employer_id);

        $updated++;
        echo "Updated completion status for employer ID: $employer_id\n";
    }

    echo "\nCompleted updating $updated employer(s) completion statuses.\n";
} catch (Exception $e) {
    echo "Error updating completion statuses: " . $e->getMessage() . "\n";
}
