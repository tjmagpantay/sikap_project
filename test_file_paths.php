<?php
require_once './config/sikap_db.php';
$config = require './config/sikap_db.php';

try {
    $db = new PDO(
        'mysql:host=' . $config['db_host'] . ';dbname=' . $config['db_name'],
        $config['db_user'],
        $config['db_pass']
    );
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Document file paths:\n";
    $stmt = $db->prepare('SELECT * FROM jobseeker_documents WHERE jobseeker_id = 6 ORDER BY uploaded_at DESC');
    $stmt->execute();
    $documents = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($documents as $doc) {
        echo "Type: {$doc['file_type']}, Path: {$doc['file_path']}\n";

        // Check if file exists
        $fullPath = __DIR__ . '/' . $doc['file_path'];
        echo "Full path: {$fullPath}\n";
        echo "File exists: " . (file_exists($fullPath) ? 'YES' : 'NO') . "\n";
        echo "Web URL would be: http://localhost/sikap/{$doc['file_path']}\n\n";
    }
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
