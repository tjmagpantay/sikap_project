<?php

require_once __DIR__ . '/../models/UserManagement.php';

class UserManagementController {
    private $model; 

    public function __construct() {
        $this->model = new UserManagement();
    }

    public function index($userType) { 
        // Map user type to view file name
        $viewFile = match ($userType) {
            'jobseekers' => 'jobseeker-management.php',
            'employers'  => 'employer-management.php', // Adjust if your file is actually employers.php
            default      => $userType . '.php',
        };

        $viewPath = __DIR__ . '/../views/admin/' . $viewFile;

        // Get users by type
        $users = $this->model->getUsersByType(
            $userType === 'jobseekers' ? 'jobseeker' : 'employer'
        );

        // Check if view file exists before including
        if (file_exists($viewPath)) {
            include $viewPath;
        } else {
            die("Error: View file not found: {$viewPath}");
        }
    }

    public function updateStatus() {
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

            // Determine new status
            $new_status = $action === 'disable' ? 'disabled' : 'enabled';
            
            // Update status based on user type
            $success = false;
            if ($user_type === 'jobseeker') {
                error_log("Updating jobseeker status - ID: $user_id, New Status: $new_status");
                $success = $this->model->updateJobseekerStatus($user_id, $new_status);
            } else {
                error_log("Updating employer status - ID: $user_id, Action: $action");
                $success = $this->model->updateEmployerStatus($user_id, $action);
            }
            
            if (!$success) {
                throw new Exception('Failed to update status');
            }

            // Send success response
            echo json_encode([
                'success' => true,
                'message' => ucfirst($action) . ' successful',
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

    private function sendJson($data) {
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

    public function exportEmployersPDF() {
        try {
            $employers = $this->model->getUsersByType('employer');
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
}