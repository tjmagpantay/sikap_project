<?php
// filepath: c:\xampp\htdocs\sikap\app\helpers\DatabaseHelper.php
class DatabaseHelper
{
    private static $pdo = null;
    
    public static function getConnection()
    {
        if (self::$pdo === null) {
            $config = require __DIR__ . '/../../config/sikap_db.php';
            
            $dsn = "mysql:host={$config['db_host']};port={$config['db_port']};dbname={$config['db_name']};charset=utf8mb4";
            
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_TIMEOUT => 30,
                PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,
                PDO::ATTR_PERSISTENT => false // Disable persistent connections for Railway
            ];
            
            // Retry logic for Railway free tier
            $attempts = 3;
            while ($attempts > 0) {
                try {
                    self::$pdo = new PDO($dsn, $config['db_user'], $config['db_pass'], $options);
                    break;
                } catch (PDOException $e) {
                    $attempts--;
                    if ($attempts === 0) {
                        error_log("Database connection failed after retries: " . $e->getMessage());
                        throw new Exception("Database connection failed: " . $e->getMessage());
                    }
                    // Wait 1 second before retry
                    sleep(1);
                }
            }
        }
        
        return self::$pdo;
    }
    
    public static function testConnection()
    {
        try {
            $pdo = self::getConnection();
            $pdo->query("SELECT 1");
            return true;
        } catch (Exception $e) {
            error_log("Database test failed: " . $e->getMessage());
            return false;
        }
    }
}