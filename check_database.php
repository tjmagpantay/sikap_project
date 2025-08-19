<?php
// Check database tables
$config = require 'config/sikap_db.php';

try {
    $db = new PDO(
        "mysql:host={$config['db_host']};dbname={$config['db_name']}",
        $config['db_user'],
        $config['db_pass']
    );
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check what tables exist
    $sql = "SHOW TABLES";
    $stmt = $db->query($sql);
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);

    echo "Tables in database:\n";
    foreach ($tables as $table) {
        echo "- $table\n";
    }

    // Check if job_post table exists and has data
    if (in_array('job_post', $tables)) {
        echo "\njob_post table exists. Checking record count...\n";
        $sql = "SELECT COUNT(*) FROM job_post";
        $stmt = $db->query($sql);
        $count = $stmt->fetchColumn();
        echo "job_post has $count records.\n";
    } else {
        echo "\njob_post table does NOT exist!\n";
    }

    // Check if employer table exists and has data
    if (in_array('employer', $tables)) {
        echo "\nemployer table exists. Checking record count...\n";
        $sql = "SELECT COUNT(*) FROM employer";
        $stmt = $db->query($sql);
        $count = $stmt->fetchColumn();
        echo "employer has $count records.\n";

        // Check if any employers are completed
        $sql = "SELECT COUNT(*) FROM employer WHERE profile_completed = 1";
        $stmt = $db->query($sql);
        $count = $stmt->fetchColumn();
        echo "employer with profile_completed=1: $count records.\n";
    } else {
        echo "\nemployer table does NOT exist!\n";
    }

    // Check if employers_business table exists and has data
    if (in_array('employers_business', $tables)) {
        echo "\nemployers_business table exists. Checking record count...\n";
        $sql = "SELECT COUNT(*) FROM employers_business";
        $stmt = $db->query($sql);
        $count = $stmt->fetchColumn();
        echo "employers_business has $count records.\n";

        // Check if any business profiles are completed
        $sql = "SELECT COUNT(*) FROM employers_business WHERE business_completed = 1";
        $stmt = $db->query($sql);
        $count = $stmt->fetchColumn();
        echo "employers_business with business_completed=1: $count records.\n";
    } else {
        echo "\nemployers_business table does NOT exist!\n";
    }
} catch (PDOException $e) {
    echo "Database connection failed: " . $e->getMessage() . "\n";
}
