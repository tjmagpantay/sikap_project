<?php
$config = require __DIR__ . '/config/sikap_db.php';
try {
    $pdo = new PDO(
        "mysql:host={$config['db_host']};dbname={$config['db_name']}",
        $config['db_user'],
        $config['db_pass']
    );

    echo "Employer table structure:\n";
    $stmt = $pdo->query('DESCRIBE employer');
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo $row['Field'] . ' - ' . $row['Type'] . "\n";
    }

    echo "\nEmployers_business table structure:\n";
    $stmt = $pdo->query('DESCRIBE employers_business');
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo $row['Field'] . ' - ' . $row['Type'] . "\n";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
