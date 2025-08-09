<?php
$config = require 'config/sikap_db.php';
$pdo = new PDO('mysql:host='.$config['db_host'].';dbname='.$config['db_name'], $config['db_user'], $config['db_pass']);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

echo "Jobs with show_pay = 1:\n";
$stmt = $pdo->query('SELECT job_id, job_title, salary, pay_type, pay_range, show_pay FROM job_post WHERE show_pay = 1');
$count = 0;
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    print_r($row);
    $count++;
}
echo "Total jobs with show_pay = 1: " . $count . "\n\n";

echo "All jobs show_pay status:\n";
$stmt = $pdo->query('SELECT job_id, job_title, show_pay FROM job_post ORDER BY job_id DESC LIMIT 10');
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "Job ID {$row['job_id']}: {$row['job_title']} - show_pay: {$row['show_pay']}\n";
}
?>
