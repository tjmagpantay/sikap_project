<?php
require_once __DIR__ . '/../models/User.php';

class UserController {
    private $userModel;
    public function __construct() {
        $this->userModel = new User();
    }

    public function login() {
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $user = $this->userModel->findByEmail($email);
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['user_id'];
                $role = $this->userModel->getUserRole($user['user_id']);
                $_SESSION['role'] = $role;
                if ($role === 'employer') {
                    header('Location: /index.php?page=employer-dashboard');
                    exit;
                } else {
                    header('Location: /index.php');
                    exit;
                }
            } else {
                $error = 'Invalid email or password.';
            }
        }
        include __DIR__ . '/../views/pages/login.php';
    }

    public function signup() {
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $first_name = trim($_POST['first_name'] ?? '');
            $last_name = trim($_POST['last_name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $phone_number = trim($_POST['phone_number'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';
            if ($password !== $confirm_password) {
                $error = 'Passwords do not match.';
            } elseif ($this->userModel->findByEmail($email)) {
                $error = 'Email already exists.';
            } else {
                $hashed = password_hash($password, PASSWORD_DEFAULT);
                $user_id = $this->userModel->create($email, $hashed);
                $this->userModel->assignRole($user_id, 'employer');
                // Optionally store phone_number, first_name, last_name elsewhere
                header('Location: /index.php?page=login');
                exit;
            }
        }
        include __DIR__ . '/../views/pages/signup.php';
    }

    public function signupJobseeker() {
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $first_name = trim($_POST['first_name'] ?? '');
            $last_name = trim($_POST['last_name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $phone_number = trim($_POST['phone_number'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';
            if ($password !== $confirm_password) {
                $error = 'Passwords do not match.';
            } elseif ($this->userModel->findByEmail($email)) {
                $error = 'Email already exists.';
            } else {
                $hashed = password_hash($password, PASSWORD_DEFAULT);
                $user_id = $this->userModel->create($email, $hashed);
                $this->userModel->assignRole($user_id, 'employer');
                header('Location: /index.php?page=login');
                exit;
            }
        }
        include __DIR__ . '/../views/jobseekers/signup-jobseeker.php';
    }
}