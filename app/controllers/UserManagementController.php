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
        header('Content-Type: application/json');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->sendJson(['success' => false, 'error' => 'Invalid request method']);
        }

        $user_id = $_POST['user_id'] ?? null;
        $action = $_POST['action'] ?? null;

        if (!$user_id || !$action) {
            $this->sendJson(['success' => false, 'error' => 'Missing required parameters']);
        }
        
        try {
            // Fix: Pass user_id first, then action
            $success = $this->model->updateEmployerStatus($user_id, $action);
            
            if ($success) {
                $this->sendJson([
                    'success' => true,
                    'message' => ucfirst($action) . ' successful',
                    'new_status' => $action === 'suspend' ? 'suspended' : 'verified'
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
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}
