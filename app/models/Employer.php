<?php
class Employer {
    private $pdo;

    public function __construct() {
        $config = include __DIR__ . '/../../config/sikap_db.php';
        $dsn = "mysql:host={$config['db_host']};dbname={$config['db_name']};charset=utf8mb4";
        $this->pdo = new PDO($dsn, $config['db_user'], $config['db_pass']);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function saveProfile($user_id, $first_name, $middle_name, $last_name, $position, $contact_no) {
        $stmt = $this->pdo->prepare('INSERT INTO employer (user_id, first_name, middle_name, last_name, position, contact_no) VALUES (?, ?, ?, ?, ?, ?)');
        $stmt->execute([$user_id, $first_name, $middle_name, $last_name, $position, $contact_no]);
        return $this->pdo->lastInsertId();
    }

    public function saveBusiness($employer_id, $business) {
        $stmt = $this->pdo->prepare('INSERT INTO employers_business (employer_id, business_name, business_logo, business_address, business_type, business_size, business_desc, business_email, business_contact, business_industry, business_socials) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([
            $employer_id,
            $business['business_name'],
            $business['business_logo'],
            $business['business_address'],
            $business['business_type'],
            $business['business_size'],
            $business['business_desc'],
            $business['business_email'],
            $business['business_contact'],
            $business['business_industry'],
            $business['business_socials']
        ]);
        return $this->pdo->lastInsertId();
    }

    public function isProfileComplete($user_id) {
        $stmt = $this->pdo->prepare('SELECT e.employer_id, b.business_id FROM employer e LEFT JOIN employers_business b ON e.employer_id = b.employer_id WHERE e.user_id = ?');
        $stmt->execute([$user_id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row && $row['employer_id'] && $row['business_id'];
    }
} 