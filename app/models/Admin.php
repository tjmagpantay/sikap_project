<?php
require_once __DIR__ . '/../../config/sikap_db.php';

class Admin
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
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function create($user_id, $admin_name)
    {
        $stmt = $this->db->prepare("INSERT INTO admin (user_id, admin_name, createdAt, updatedAt) VALUES (?, ?, NOW(), NOW())");
        return $stmt->execute([$user_id, $admin_name]);
    }

    public function findByUserId($user_id)
    {
        $stmt = $this->db->prepare("SELECT * FROM admin WHERE user_id = ?");
        $stmt->execute([$user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
