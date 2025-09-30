<?php
// filepath: c:\xampp\htdocs\sikap\app\api\NotificationApiController.php

require_once __DIR__ . '/../controllers/NotificationController.php';

class NotificationApiController extends NotificationController
{
    public function __construct()
    {
        parent::__construct();
        
        // Set JSON headers
        header('Content-Type: application/json');
        header('Cache-Control: no-cache, must-revalidate');
        
        // Handle CORS if needed
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
            header('Access-Control-Allow-Headers: Content-Type');
            exit(0);
        }
    }
    
    public function handleApiRequest()
    {
        try {
            $method = $_SERVER['REQUEST_METHOD'];
            
            switch ($method) {
                case 'GET':
                    $this->handleGetNotifications();
                    break;
                    
                case 'POST':
                    $this->handlePostActions();
                    break;
                    
                default:
                    http_response_code(405);
                    echo json_encode(['error' => 'Method not allowed']);
            }
        } catch (Exception $e) {
            error_log('❌ API Error: ' . $e->getMessage());
            http_response_code(500);
            echo json_encode(['error' => 'Internal server error']);
        }
    }

    private function handleGetNotifications()
    {
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
        $offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;
        
        // Use parent class method
        $this->apiEndpoint();
    }

    private function handlePostActions()
    {
        // Use parent class method
        $this->apiEndpoint();
    }
}

// Handle the API request
$apiController = new NotificationApiController();
$apiController->handleApiRequest();
?>