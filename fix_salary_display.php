<?php
// Fix salary display issue by enabling show_pay for existing jobs
$config = require 'config/sikap_db.php';
$pdo = new PDO('mysql:host='.$config['db_host'].';dbname='.$config['db_name'], $config['db_user'], $config['db_pass']);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

echo "Current jobs with show_pay = 0:\n";
$stmt = $pdo->query('SELECT job_id, job_title, show_pay FROM job_post WHERE show_pay = 0');
$jobs_to_update = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "Job ID {$row['job_id']}: {$row['job_title']} - show_pay: {$row['show_pay']}\n";
    $jobs_to_update[] = $row['job_id'];
}

if (!empty($jobs_to_update)) {
    echo "\nUpdating " . count($jobs_to_update) . " jobs to show pay information...\n";
    $stmt = $pdo->prepare('UPDATE job_post SET show_pay = 1 WHERE job_id = ?');
    $updated_count = 0;
    
    foreach ($jobs_to_update as $job_id) {
        if ($stmt->execute([$job_id])) {
            $updated_count++;
        }
    }
    
    echo "Successfully updated $updated_count jobs.\n\n";
    
    echo "Verification - jobs now showing pay:\n";
    $stmt = $pdo->query('SELECT job_id, job_title, salary, pay_range, show_pay FROM job_post WHERE show_pay = 1');
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $pay_info = $row['salary'] ? '₱' . number_format($row['salary'], 2) : $row['pay_range'];
        echo "Job ID {$row['job_id']}: {$row['job_title']} - Pay: {$pay_info}\n";
    }
} else {
    echo "No jobs need updating.\n";
}
?>
