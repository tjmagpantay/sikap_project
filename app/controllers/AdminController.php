<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Admin.php';

class AdminController
{
    private $userModel;
    private $adminModel;

    public function __construct()
    {
        $this->userModel = new User();
        $this->adminModel = new Admin();
    }

    public function signup()
    {
        $error = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $admin_name = trim($_POST['admin_name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';

            if (empty($admin_name) || empty($email) || empty($password)) {
                $error = 'Please fill in all fields.';
            } elseif ($password !== $confirm_password) {
                $error = 'Passwords do not match.';
            } elseif (strlen($password) < 6) {
                $error = 'Password must be at least 6 characters long.';
            } elseif ($this->userModel->findByEmail($email)) {
                $error = 'Email already exists.';
            } else {
                // Hash password properly
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // Create user account with admin role
                $user_id = $this->userModel->create($email, $hashed_password, User::ROLE_ADMIN);

                if ($user_id) {
                    // Create admin profile
                    $this->adminModel->create($user_id, $admin_name);

                    $success = "Admin account created successfully! You can now login with your credentials.";

                    // Optionally auto-login the admin
                    $_SESSION['user_id'] = $user_id;
                    $_SESSION['role'] = User::ROLE_ADMIN;
                    $_SESSION['role_name'] = 'admin';
                    $_SESSION['email'] = $email;

                    // Redirect to dashboard after 2 seconds
                    echo "<script>
                        setTimeout(function() {
                            window.location.href = '?page=admin-dashboard';
                        }, 2000);
                    </script>";
                } else {
                    $error = 'Failed to create admin account. Please try again.';
                }
            }
        }

        include __DIR__ . '/../views/admin/signup-admin.php';
    }

    public function login()
    {
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if (empty($email) || empty($password)) {
                $error = 'Please fill in all fields.';
            } else {
                $user = $this->userModel->findByEmail($email);

                if ($user && password_verify($password, $user['password']) && $user['role_id'] == User::ROLE_ADMIN) {
                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['role'] = $user['role_id'];
                    $_SESSION['role_name'] = $user['role_name'];
                    $_SESSION['email'] = $user['email'];

                    header('Location: ?page=admin-dashboard');
                    exit;
                } else {
                    $error = 'Invalid admin credentials.';
                }
            }
        }

        include __DIR__ . '/../views/admin/login-admin.php';
    }

    public function dashboard()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != User::ROLE_ADMIN) {
            header('Location: ?page=admin-login');
            exit;
        }

        $admin = $this->adminModel->findByUserId($_SESSION['user_id']);
        include __DIR__ . '/../views/admin/dashboard.php';
    }
}
