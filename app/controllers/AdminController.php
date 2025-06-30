<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Admin.php';
require_once __DIR__ . '/../models/Employer.php';

class AdminController {
    private $adminModel;
    private $employerModel;

    public function __construct() {
        $this->adminModel = new Admin();
        $this->employerModel = new Employer();
    }

    public function login() {
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            // Debug logging
            error_log("Login attempt - Email: " . $email);

            if (empty($email) || empty($password)) {
                $error = 'Please fill in all fields.';
            } else {
                $admin = $this->adminModel->authenticate($email, $password);
                
                // Debug logging
                error_log("Authentication result: " . print_r($admin, true));
                
                if ($admin) {
                    $_SESSION['user_id'] = $admin['user_id'];
                    $_SESSION['admin_id'] = $admin['admin_id'];
                    $_SESSION['role'] = 'admin'; // Hardcode this instead of using $admin['role_name']
                    $_SESSION['admin_name'] = $admin['admin_name'];
                    
                    // Debug logging
                    error_log("Session variables set: " . print_r($_SESSION, true));
                    
                    header('Location: ?page=admin-dashboard');
                    exit;
                } else {
                    $error = 'Invalid credentials.';
                }
            }
        }

        include __DIR__ . '/../views/admin/login-admin.php';
}

    public function dashboard() {
        // Debug logging
        error_log("Dashboard access - Session: " . print_r($_SESSION, true));

        // Changed from User::ROLE_ADMIN to 'admin'
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            error_log("Access denied - redirecting to login");
            header('Location: ?page=admin-login');
            exit;
        }

        include __DIR__ . '/../views/admin/dashboard.php';
    }

    public function accreditations() {
        // Change from User::ROLE_ADMIN to 'admin' to match your login method
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: ?page=admin-login');
            exit;
        }

        // Use adminModel instead of employerModel for accreditation methods
        $pendingAccreditations = $this->adminModel->getPendingAccreditations();
        $allAccreditations = $this->adminModel->getAllAccreditations();

        // Debug logging
        error_log('=== ACCREDITATIONS DEBUG ===');
        error_log('Pending accreditations count: ' . count($pendingAccreditations));
        error_log('All accreditations count: ' . count($allAccreditations));
        error_log('Pending data: ' . print_r($pendingAccreditations, true));
        error_log('All data: ' . print_r($allAccreditations, true));
        error_log('=== END DEBUG ===');

        include __DIR__ . '/../views/admin/accreditations.php';
    }

    public function reviewAccreditation() {
        // Change from User::ROLE_ADMIN to 'admin'
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: ?page=admin-login');
            exit;
        }

        $accreditationId = $_GET['id'] ?? null;
        if (!$accreditationId) {
            header('Location: ?page=admin-accreditations&error=' . urlencode('Invalid accreditation ID'));
            exit;
        }

        // Use adminModel for accreditation details
        $accreditation = $this->adminModel->getAccreditationDetails($accreditationId);
        if (!$accreditation) {
            header('Location: ?page=admin-accreditations&error=' . urlencode('Accreditation not found'));
            exit;
        }

        // Get employer's documents using employerModel
        $documents = $this->employerModel->getDocuments($accreditation['employer_id']);

        include __DIR__ . '/../views/admin/review-accreditation.php';
    }

    public function processAccreditation() {
        // Change from User::ROLE_ADMIN to 'admin'
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: ?page=admin-login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?page=admin-accreditations');
            exit;
        }

        $accreditationId = $_POST['accreditation_id'] ?? null;
        $status = $_POST['status'] ?? null;
        $notes = $_POST['notes'] ?? '';

        if (!$accreditationId || !in_array($status, ['approved', 'rejected', 'pending'])) {
            header('Location: ?page=admin-accreditations&error=' . urlencode('Invalid request'));
            exit;
        }

        // Use adminModel for updating accreditation status
        $result = $this->adminModel->updateAccreditationStatus(
            $accreditationId, 
            $status, 
            $_SESSION['admin_id'], // Use admin_id instead of user_id
            $notes
        );

        if ($result) {
            $message = $status === 'approved' ? 'Employer verified successfully!' : 
                      ($status === 'rejected' ? 'Application rejected.' : 'Status updated.');
            header('Location: ?page=admin-accreditations&success=' . urlencode($message));
        } else {
            header('Location: ?page=admin-accreditations&error=' . urlencode('Failed to update status'));
        }
        exit;
    }
}
