<?php
// Update default value for show_pay column
$config = require 'config/sikap_db.php';
$pdo = new PDO('mysql:host='.$config['db_host'].';dbname='.$config['db_name'], $config['db_user'], $config['db_pass']);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

echo "Updating show_pay column default value...\n";
$pdo->exec('ALTER TABLE job_post MODIFY COLUMN show_pay TINYINT(1) DEFAULT 1');
echo "Updated show_pay column default to 1 (show pay by default)\n";

echo "Checking updated structure:\n";
$stmt = $pdo->query('SHOW COLUMNS FROM job_post LIKE "show_pay"');
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "Field: {$row['Field']}, Type: {$row['Type']}, Default: {$row['Default']}\n";
}
?>
