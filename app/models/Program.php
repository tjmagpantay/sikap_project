<?php

require_once __DIR__ . '/../../config/sikap_db.php';

class Program
{
    private $db;

    public function __construct()
    {
        $config = require __DIR__ . '/../../config/sikap_db.php';
        try {
            $this->db = new PDO(
                "mysql:host={$config['db_host']};dbname={$config['db_name']}",
                $config['db_user'],
                $config['db_pass']
            );
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            error_log("DEBUG: Program database connection established successfully");
        } catch (PDOException $e) {
            error_log("Program database connection failed: " . $e->getMessage());
            die("Connection failed: " . $e->getMessage());
        }
    }

}