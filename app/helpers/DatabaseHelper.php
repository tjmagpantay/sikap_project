<?php
// filepath: c:\xampp\htdocs\sikap\app\helpers\DatabaseHelper.php
class DatabaseHelper
{
    public static function getConnection()
    {
        static $pdo = null;
        
        if ($pdo === null) {
            $config = require __DIR__ . '/../../config/sikap_db.php';
            
            $dsn = "mysql:host={$config['db_host']};port={$config['db_port']};dbname={$config['db_name']};charset=utf8mb4";
            
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_TIMEOUT => 30,
                PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false
            ];
            
            // Retry logic for Railway free tier
            $attempts = 3;
            while ($attempts > 0) {
                try {
                    $pdo = new PDO($dsn, $config['db_user'], $config['db_pass'], $options);
                    break;
                } catch (PDOException $e) {
                    $attempts--;
                    if ($attempts > 0) {
                        sleep(2);
                    } else {
                        throw $e;
                    }
                }
            }
        }
        
        return $pdo;
    }
}