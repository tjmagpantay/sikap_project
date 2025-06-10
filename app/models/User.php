<?php
class User {
    private $pdo;

    public function __construct() {
        $config = include __DIR__ . '/../../config/sikap_db.php';
        $dsn = "mysql:host={$config['db_host']};dbname={$config['db_name']};charset=utf8mb4";
        $this->pdo = new PDO($dsn, $config['db_user'], $config['db_pass']);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function findByEmail($email) {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($email, $password, $status = 'active') {
        $stmt = $this->pdo->prepare('INSERT INTO users (email, password, status) VALUES (?, ?, ?)');
        $stmt->execute([$email, $password, $status]);
        return $this->pdo->lastInsertId();
    }

    public function assignRole($user_id, $role_name = 'employer') {
        $stmt = $this->pdo->prepare('SELECT role_id FROM roles WHERE role_name = ?');
        $stmt->execute([$role_name]);
        $role = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$role) return false;
        $stmt = $this->pdo->prepare('INSERT INTO user_roles (user_id, role_id) VALUES (?, ?)');
        return $stmt->execute([$user_id, $role['role_id']]);
    }

    public function getUserRole($user_id) {
        $stmt = $this->pdo->prepare('SELECT r.role_name FROM user_roles ur JOIN roles r ON ur.role_id = r.role_id WHERE ur.user_id = ? LIMIT 1');
        $stmt->execute([$user_id]);
        $role = $stmt->fetch(PDO::FETCH_ASSOC);
        return $role ? $role['role_name'] : null;
    }
} 