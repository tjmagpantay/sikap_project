<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Jobseeker.php';
require_once __DIR__ . '/../models/Employer.php';

class UserController
{
    private $userModel;
    private $jobseekerModel;
    private $employerModel;

    public function __construct()
    {
        $this->userModel = new User();
        $this->jobseekerModel = new Jobseeker();
        $this->employerModel = new Employer();
    }

    public function login()
    {
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $user = $this->userModel->findByEmail($email);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['role'] = $user['role_id']; // Use role_id
                $_SESSION['role_name'] = $user['role_name'] ?? 'unknown'; // Use role_name from JOIN
                $_SESSION['email'] = $user['email'];

                // Redirect based on role ID
                if ($user['role_id'] == User::ROLE_ADMIN) {
                    header('Location: ?page=admin-dashboard');
                } elseif ($user['role_id'] == User::ROLE_EMPLOYER) {
                    // Check if profile is complete
                    if ($this->userModel->hasCompleteProfile($user['user_id'], User::ROLE_EMPLOYER)) {
                        header('Location: ?page=employer-dashboard');
                    } else {
                        header('Location: ?page=complete-employer-profile');
                    }
                } elseif ($user['role_id'] == User::ROLE_JOBSEEKER) {
                    // Check if profile is complete
                    if ($this->userModel->hasCompleteProfile($user['user_id'], User::ROLE_JOBSEEKER)) {
                        header('Location: ?page=jobseeker-dashboard');
                    } else {
                        header('Location: ?page=complete-jobseeker-profile');
                    }
                } else {
                    header('Location: ?page=landing');
                }
                exit;
            } else {
                $error = 'Invalid email or password.';
            }
        }
        include __DIR__ . '/../views/pages/login.php';
    }

    public function signup()
    {
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';
            $role = $_POST['role'] ?? '';

            if (empty($email) || empty($password) || empty($role)) {
                $error = 'Please fill in all fields.';
            } elseif ($password !== $confirm_password) {
                $error = 'Passwords do not match.';
            } elseif (strlen($password) < 6) {
                $error = 'Password must be at least 6 characters long.';
            } elseif ($this->userModel->findByEmail($email)) {
                $error = 'Email already exists.';
            } else {
                $hashed = password_hash($password, PASSWORD_DEFAULT);

                // Create user with selected role
                $role_id = ($role === 'employer') ? User::ROLE_EMPLOYER : User::ROLE_JOBSEEKER;
                $status = ($role === 'employer') ? 'pending' : 'active'; // Employers need approval
                
                $user_id = $this->userModel->create($email, $hashed, $role_id, $status);

                if ($user_id) {
                    $_SESSION['user_id'] = $user_id;
                    $_SESSION['role'] = $role_id;
                    $_SESSION['role_name'] = $role;
                    $_SESSION['email'] = $email;

                    // Redirect to complete profile
                    if ($role === 'employer') {
                        header('Location: ?page=complete-employer-profile');
                    } else {
                        header('Location: ?page=complete-jobseeker-profile');
                    }
                    exit;
                } else {
                    $error = 'Failed to create account. Please try again.';
                }
            }
        }
        include __DIR__ . '/../views/pages/signup.php';
    }

    public function logout()
    {
        session_destroy();
        header('Location: ?page=landing');
        exit;
    }
}

