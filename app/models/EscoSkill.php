<?php
require_once __DIR__ . '/../../config/sikap_db.php';

class EscoSkill
{
    private $db;

    public function __construct()
    {
        $config = require __DIR__ . '/../../config/sikap_db.php';
        try {
            // FIXED: Add Railway port
            $this->db = new PDO(
                "mysql:host={$config['db_host']};port={$config['db_port']};dbname={$config['db_name']};charset=utf8mb4",
                $config['db_user'],
                $config['db_pass'],
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_TIMEOUT => 30
                ]
            );
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            error_log("EscoSkill database connection failed: " . $e->getMessage());
            throw new Exception("Database connection failed");
        }
    }

    public function getAllSkills($limit = 1000)
    {
        try {
            $stmt = $this->db->prepare("SELECT id, skill_name FROM esco_skills LIMIT ?");
            $stmt->execute([$limit]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching ESCO skills: " . $e->getMessage());
            return [];
        }
    }

    public function getAllAliases($limit = 1000)
    {
        try {
            $stmt = $this->db->prepare("SELECT alias, skill_id FROM esco_skill_aliases LIMIT ?");
            $stmt->execute([$limit]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching ESCO aliases: " . $e->getMessage());
            return [];
        }
    }

    public function searchSkills($query, $limit = 10)
    {
        try {
            $searchTerm = "%$query%";
            $stmt = $this->db->prepare("
                SELECT id, skill_name 
                FROM esco_skills 
                WHERE skill_name LIKE ? 
                ORDER BY skill_name 
                LIMIT ?
            ");
            $stmt->execute([$searchTerm, $limit]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error searching ESCO skills: " . $e->getMessage());
            return [];
        }
    }

    public function getSkillById($id)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM esco_skills WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching ESCO skill by ID: " . $e->getMessage());
            return false;
        }
    }
}
