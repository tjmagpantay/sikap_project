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

    /**
     * Handle AJAX suspend/unsuspend requests
     */
    public function updateStatus() {
        // Clear any existing output buffers
        while (ob_get_level()) {
            ob_end_clean();
        }
        
        // Start fresh output buffer
        ob_start();
        
        // Set headers
        header('Content-Type: application/json');
        
        error_log("========= Status Update Request Started =========");
        error_log("Request Method: " . $_SERVER['REQUEST_METHOD']);
        error_log("POST Data: " . json_encode($_POST));
        error_log("Request URI: " . ($_SERVER['REQUEST_URI'] ?? 'unknown'));
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            error_log("Invalid request method: " . $_SERVER['REQUEST_METHOD']);
            ob_clean(); // Clear any output
            $this->sendJson(['success' => false, 'error' => 'Invalid request method']);
            return;
        }

        $user_id = $_POST['user_id'] ?? null;
        $action = $_POST['action'] ?? null;
        $user_type = $_POST['user_type'] ?? null;
        
        error_log("Parsed parameters:");
        error_log("user_id: " . ($user_id ?? 'null'));
        error_log("action: " . ($action ?? 'null'));
        error_log("user_type: " . ($user_type ?? 'null'));

        // Validate all required parameters
        if (!$user_id || !$action || !$user_type) {
            $this->sendJson([
                'success' => false, 
                'error' => 'Missing required parameters', 
                'received' => [
                    'user_id' => $user_id,
                    'action' => $action,
                    'user_type' => $user_type
                ]
            ]);
            return;
        }
        
        try {
            $new_status = $action === 'disable' ? 'disabled' : 'enabled';
            error_log("Attempting to update {$user_type} status: user_id={$user_id}, new_status={$new_status}");
            
            if ($user_type === 'jobseeker') {
                $success = $this->model->updateJobseekerStatus($user_id, $new_status);
            } else {
                $success = $this->model->updateEmployerStatus($user_id, $action);
            }
            
            if ($success) {
                $this->sendJson([
                    'success' => true,
                    'message' => ucfirst($action) . ' successful',
                    'new_status' => $new_status
                ]);
            } else {
                $this->sendJson([
                    'success' => false,
                    'error' => 'Failed to update status'
                ]);
            }
        } catch (Exception $e) {
            $this->sendJson([
                'success' => false,
                'error' => 'An error occurred: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Utility function to send JSON responses and exit
     */
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
        // This is just a response endpoint, actual export happens in JavaScript
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
