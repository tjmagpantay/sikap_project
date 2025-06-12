<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Employer.php';

class EmployerController {
    private $userModel;
    private $employerModel;

    public function __construct() {
        $this->userModel = new User();
        $this->employerModel = new Employer();
    }

    public function signup() {
        $error = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';
            
            if (empty($email) || empty($password)) {
                $error = 'Please fill in all required fields.';
            } elseif ($password !== $confirm_password) {
                $error = 'Passwords do not match.';
            } elseif (strlen($password) < 6) {
                $error = 'Password must be at least 6 characters long.';
            } elseif ($this->userModel->findByEmail($email)) {
                $error = 'Email already exists.';
            } else {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                
                // Create user account with employer role (pending status for approval)
                $user_id = $this->userModel->create($email, $hashed_password, User::ROLE_EMPLOYER, 'pending');
                
                if ($user_id) {
                    $_SESSION['user_id'] = $user_id;
                    $_SESSION['role'] = User::ROLE_EMPLOYER;
                    $_SESSION['role_name'] = 'employer';
                    $_SESSION['email'] = $email;
                    
                    // Redirect directly to dashboard
                    header('Location: ?page=employer-dashboard');
                    exit;
                } else {
                    $error = 'Failed to create account. Please try again.';
                }
            }
        }
        
        include __DIR__ . '/../views/employers/signup-employer.php';
    }

    public function login() {
        $error = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            
            if (empty($email) || empty($password)) {
                $error = 'Please fill in all fields.';
            } else {
                $user = $this->userModel->findByEmail($email);
                
                if ($user && password_verify($password, $user['password']) && $user['role_id'] == User::ROLE_EMPLOYER) {
                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['role'] = $user['role_id'];
                    $_SESSION['role_name'] = $user['role_name'];
                    $_SESSION['email'] = $user['email'];
                    
                    // Always redirect to dashboard
                    header('Location: ?page=employer-dashboard');
                    exit;
                } else {
                    $error = 'Invalid email or password, or this is not an employer account.';
                }
            }
        }
        
        include __DIR__ . '/../views/employers/login-employer.php';
    }

    public function dashboard() {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != User::ROLE_EMPLOYER) {
            header('Location: ?page=login-employer');
            exit;
        }
        
        // Check if profile exists
        $employer = $this->employerModel->findByUserId($_SESSION['user_id']);
        $hasProfile = ($employer !== false);
        
        // Get user info for display
        $user = $this->userModel->findById($_SESSION['user_id']);
        
        include __DIR__ . '/../views/employers/dashboard.php';
    }

    public function completeProfile() {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != User::ROLE_EMPLOYER) {
            header('Location: ?page=login-employer');
            exit;
        }

        $error = '';
        $success = '';
        
        // Check if profile already exists
        if ($this->userModel->hasCompleteProfile($_SESSION['user_id'], User::ROLE_EMPLOYER)) {
            $success = 'Your profile is already complete!';
            // Still show the form for editing
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $first_name = trim($_POST['first_name'] ?? '');
            $last_name = trim($_POST['last_name'] ?? '');
            $contact_no = trim($_POST['contact_no'] ?? '');
            $middle_name = trim($_POST['middle_name'] ?? '');
            $position = trim($_POST['position'] ?? '');
            
            if (empty($first_name) || empty($last_name) || empty($contact_no)) {
                $error = 'Please fill in all required fields.';
            } else {
                // Check if profile exists for update vs create
                $existingProfile = $this->employerModel->findByUserId($_SESSION['user_id']);
                
                if ($existingProfile) {
                    // Update existing profile
                    $profile_updated = $this->employerModel->updateProfile($_SESSION['user_id'], [
                        'first_name' => $first_name,
                        'middle_name' => $middle_name,
                        'last_name' => $last_name,
                        'position' => $position,
                        'contact_no' => $contact_no
                    ]);
                    
                    if ($profile_updated) {
                        $success = 'Profile updated successfully!';
                    } else {
                        $error = 'Failed to update profile. Please try again.';
                    }
                } else {
                    // Create new profile
                    $profile_created = $this->employerModel->create($_SESSION['user_id'], $first_name, $last_name, $contact_no, $middle_name, $position);
                    
                    if ($profile_created) {
                        $success = 'Profile completed successfully!';
                    } else {
                        $error = 'Failed to create profile. Please try again.';
                    }
                }
            }
        }
        
        // Get existing profile data for form
        $employer = $this->employerModel->findByUserId($_SESSION['user_id']);
        
        include __DIR__ . '/../views/employers/complete-profile.php';
    }
}