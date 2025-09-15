<?php
require_once __DIR__ . '/../config/sikap_db.php';

try {
    $config = require __DIR__ . '/../config/sikap_db.php';
    $pdo = new PDO(
        "mysql:host={$config['db_host']};dbname={$config['db_name']};charset=utf8mb4",
        $config['db_user'],
        $config['db_pass']
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Update the interview date to 8 days ago
    $stmt = $pdo->prepare("
        UPDATE job_application_management 
        SET interview_date = DATE_SUB(NOW(), INTERVAL 8 DAY)
        WHERE application_id = ?
    ");

    $applicationId = 27; // The ID from your test case
    $stmt->execute([$applicationId]);

    if ($stmt->rowCount() > 0) {
        echo "Successfully updated interview date for application ID: $applicationId\n";
        echo "Interview date set to 8 days ago\n";
        
        // Verify the update
        $stmt = $pdo->prepare("
            SELECT 
                ja.application_id,
                ja.application_status,
                jam.interview_date,
                e.company_name,
                CONCAT(js.first_name, ' ', js.last_name) as jobseeker_name
            FROM job_application ja
            INNER JOIN job_application_management jam ON ja.application_id = jam.application_id
            INNER JOIN job_post jp ON ja.job_id = jp.job_id
            INNER JOIN employer e ON jp.employer_id = e.employer_id
            INNER JOIN jobseeker js ON ja.jobseeker_id = js.jobseeker_id
            WHERE ja.application_id = ?
        ");
        
        $stmt->execute([$applicationId]);
        $app = $stmt->fetch(PDO::FETCH_ASSOC);
        
        echo "\nUpdated application details:\n";
        echo "Application ID: {$app['application_id']}\n";
        echo "Status: {$app['application_status']}\n";
        echo "Interview Date: {$app['interview_date']}\n";
        echo "Company: {$app['company_name']}\n";
        echo "Jobseeker: {$app['jobseeker_name']}\n";
        
        // Calculate days since interview
        $interviewDate = new DateTime($app['interview_date']);
        $now = new DateTime();
        $daysSince = $now->diff($interviewDate)->days;
        
        echo "Days since interview: {$daysSince} days\n";
        echo "Eligible for reminder: " . ($daysSince >= 7 ? "Yes" : "No") . "\n";
    } else {
        echo "No application found with ID: $applicationId\n";
    }

} catch (PDOException $e) {
    die("Database error: " . $e->getMessage() . "\n");
}