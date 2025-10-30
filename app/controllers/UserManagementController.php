<?php

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Jobseeker.php';
require_once __DIR__ . '/../models/Employer.php';

class UserManagementController
{
    private $userModel;
    private $jobseekerModel;
    private $employerModel;

    public function __construct()
    {
        $config = require __DIR__ . '/../../config/sikap_db.php';

        try {
            $dsn = "mysql:host={$config['db_host']};port={$config['db_port']};dbname={$config['db_name']};charset=utf8mb4";

            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_TIMEOUT => 30
            ];

            $pdo = new PDO($dsn, $config['db_user'], $config['db_pass'], $options);

            $this->userModel = new User($pdo);
            $this->jobseekerModel = new Jobseeker($pdo);
            $this->employerModel = new Employer($pdo);
        } catch (PDOException $e) {
            error_log("UserManagementController database connection failed: " . $e->getMessage());
            throw new Exception("Database connection failed");
        }
    }

    public function index($userType)
    {
        // Map user type to view file name
        $viewFile = match ($userType) {
            'jobseekers' => 'jobseeker-management.php',
            'employers'  => 'employer-management.php',
            default      => $userType . '.php',
        };

        $viewPath = __DIR__ . '/../views/admin/' . $viewFile;

        // FIXED: Use the correct model based on user type
        if ($userType === 'jobseekers') {
            // Get jobseekers with user info
            $users = $this->getJobseekers();
        } else {
            // Get employers with user info
            $users = $this->getEmployers();
        }

        // Check if view file exists before including
        if (file_exists($viewPath)) {
            include $viewPath;
        } else {
            die("Error: View file not found: {$viewPath}");
        }
    }

    public function updateStatus()
    {
        // Clear any existing output
        while (ob_get_level()) {
            ob_end_clean();
        }

        // Set content type to JSON
        header('Content-Type: application/json');

        try {
            // Validate request method
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception('Invalid request method');
            }

            // Get and validate parameters
            $user_id = $_POST['user_id'] ?? null;
            $action = $_POST['action'] ?? null;
            $user_type = $_POST['user_type'] ?? null;

            error_log("Status Update Request - Parameters: " . json_encode([
                'user_id' => $user_id,
                'action' => $action,
                'user_type' => $user_type
            ]));

            if (!$user_id || !$action || !$user_type) {
                throw new Exception('Missing required parameters');
            }

            // Update status based on user type
            $success = false;
            if ($user_type === 'jobseeker') {
                $new_status = $action === 'disable' ? 'disabled' : 'enabled';
                error_log("Updating jobseeker status - ID: $user_id, New Status: $new_status");
                $success = $this->jobseekerModel->updateAccountStatus($user_id, $new_status);
            } else {
                // FIXED: Use correct action mapping for employers
                if ($action === 'suspend') {
                    $new_status = 'suspended';
                } elseif ($action === 'unsuspend') {
                    $new_status = 'verified';
                } else {
                    throw new Exception("Invalid action: $action");
                }

                error_log("Updating employer status - ID: $user_id, Action: $action, New Status: $new_status");
                $success = $this->employerModel->updateAccountStatus($user_id, $new_status);
            }

            if (!$success) {
                throw new Exception('Failed to update status in database');
            }

            // Send success response
            echo json_encode([
                'success' => true,
                'message' => ucfirst($action) . 'ed successfully',
                'new_status' => $new_status
            ]);
        } catch (Exception $e) {
            error_log("Status Update Error: " . $e->getMessage());
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
        exit;
    }

    // FIXED: Add helper methods to get users
    private function getJobseekers()
    {
        try {
            $stmt = $this->jobseekerModel->getPdo()->prepare("
                SELECT 
                    j.jobseeker_id, 
                    j.user_id, 
                    j.first_name, 
                    j.middle_name, 
                    j.last_name, 
                    j.suffix, 
                    j.date_of_birth, 
                    j.sex, 
                    j.address, 
                    j.contact_no,
                    j.acc_status,
                    j.created_at,
                    u.email,
                    u.status as user_status
                FROM jobseeker j
                LEFT JOIN users u ON j.user_id = u.user_id
                ORDER BY j.created_at DESC
            ");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error getting jobseekers: " . $e->getMessage());
            return [];
        }
    }

    private function getEmployers()
    {
        try {
            $stmt = $this->employerModel->getPdo()->prepare("
                SELECT 
                    e.employer_id, 
                    e.user_id, 
                    e.first_name, 
                    e.middle_name, 
                    e.last_name, 
                    e.position, 
                    e.contact_no, 
                    e.company_name, 
                    e.about_us, 
                    e.created_at, 
                    e.updated_at, 
                    e.profile_completed, 
                    e.status,
                    u.email,
                    u.status as user_status,
                    eb.business_address
                FROM employer e
                LEFT JOIN users u ON e.user_id = u.user_id
                LEFT JOIN employers_business eb ON e.employer_id = eb.employer_id
                ORDER BY e.created_at DESC
            ");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error getting employers: " . $e->getMessage());
            return [];
        }
    }

    private function sendJson($data)
    {
        // Clear all previous output
        ob_end_clean();

        // Start fresh output buffer
        ob_start();

        // Set headers
        header('Content-Type: application/json');

        // Encode response
        $json = json_encode($data);
        if ($json === false) {
            $json = json_encode(['success' => false, 'error' => 'Internal server error']);
        }

        // Output json
        echo $json;

        // Send the response and end script
        ob_end_flush();
        exit;
    }

    public function exportEmployersPDF()
    {
        try {
            $employers = $this->getEmployers();
            $this->sendJson([
                'success' => true,
                'data' => $employers
            ]);
        } catch (Exception $e) {
            $this->sendJson([
                'success' => false,
                'error' => 'Error fetching employers: ' . $e->getMessage()
            ]);
        }
    }

    public function updateJobseekerStatus()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'error' => 'Method not allowed']);
            return;
        }

        $userId = $_POST['user_id'] ?? '';
        $action = $_POST['action'] ?? '';

        if (empty($userId) || !in_array($action, ['enable', 'disable'])) {
            echo json_encode(['success' => false, 'error' => 'Invalid parameters']);
            return;
        }

        try {
            $newStatus = ($action === 'enable') ? 'enabled' : 'disabled';

            // Update jobseeker status
            $result = $this->jobseekerModel->updateAccountStatus($userId, $newStatus);

            if ($result) {
                echo json_encode([
                    'success' => true,
                    'message' => "Jobseeker account $action" . "d successfully",
                    'new_status' => $newStatus
                ]);
            } else {
                echo json_encode(['success' => false, 'error' => 'Failed to update status']);
            }
        } catch (Exception $e) {
            error_log("Error updating jobseeker status: " . $e->getMessage());
            echo json_encode(['success' => false, 'error' => 'Database error occurred']);
        }
    }

    public function updateEmployerStatus()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'error' => 'Method not allowed']);
            return;
        }

        $userId = $_POST['user_id'] ?? '';
        $action = $_POST['action'] ?? '';

        if (empty($userId) || !in_array($action, ['suspend', 'unsuspend'])) {
            echo json_encode(['success' => false, 'error' => 'Invalid parameters']);
            return;
        }

        try {
            $newStatus = ($action === 'unsuspend') ? 'verified' : 'suspended';

            // Update employer status
            $result = $this->employerModel->updateAccountStatus($userId, $newStatus);

            if ($result) {
                echo json_encode([
                    'success' => true,
                    'message' => "Employer account $action" . "ed successfully",
                    'new_status' => $newStatus
                ]);
            } else {
                echo json_encode(['success' => false, 'error' => 'Failed to update status']);
            }
        } catch (Exception $e) {
            error_log("Error updating employer status: " . $e->getMessage());
            echo json_encode(['success' => false, 'error' => 'Database error occurred']);
        }
    }
}
