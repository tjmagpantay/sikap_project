<?php
require_once __DIR__ . '/../services/NotificationService.php';
require_once __DIR__ . '/../../config/sikap_db.php';

class NotificationController
{
    private $notificationService;
    private $pdo;

    public function __construct()
    {
        // Ensure session is started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Initialize database connection
        $config = require __DIR__ . '/../../config/sikap_db.php';
        try {
            $this->pdo = new PDO(
                "mysql:host={$config['db_host']};dbname={$config['db_name']}",
                $config['db_user'],
                $config['db_pass']
            );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }

        $this->notificationService = new NotificationService($this->pdo);
    }

    /**
     * API endpoint for AJAX requests (replaces the api/notifications.php)
     */
    public function apiEndpoint()
    {
        // FIXED: Clear all output buffers to ensure clean JSON
        while (ob_get_level()) {
            ob_end_clean();
        }

        // Turn off error display to prevent HTML in JSON response
        ini_set('display_errors', 0);
        error_reporting(E_ALL);

        // FIXED: Set headers early and ensure no other output
        header('Content-Type: application/json');
        header('Cache-Control: no-cache, no-store, must-revalidate');
        header('Pragma: no-cache');
        header('Expires: 0');

        try {
            // UPDATED: Handle both user_id and employer_id session variables
            $userId = null;
            if (isset($_SESSION['user_id'])) {
                $userId = (int)$_SESSION['user_id'];
            } elseif (isset($_SESSION['employer_id'])) {
                $userId = (int)$_SESSION['employer_id'];
            }

            if (!$userId) {
                http_response_code(401);
                echo json_encode([
                    'success' => false,
                    'error' => 'Unauthorized - Please log in'
                ]);
                exit;
            }

            error_log("🔍 API: Fetching notifications for user ID: $userId");

            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                // Handle GET requests (fetch notifications)
                $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 5;
                $offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;

                $notifications = $this->notificationService->getUserNotifications($userId, $limit, $offset);
                $unreadCount = $this->notificationService->getUnreadCount($userId);

                error_log("✅ API: Found " . count($notifications) . " notifications, $unreadCount unread");

                // FIXED: Ensure clean JSON response
                echo json_encode([
                    'success' => true,
                    'notifications' => $notifications,
                    'unread_count' => $unreadCount
                ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Handle POST requests (mark as read, mark all as read)
                $input = json_decode(file_get_contents('php://input'), true);

                if (!isset($input['action'])) {
                    echo json_encode([
                        'success' => false,
                        'error' => 'Action required'
                    ]);
                    exit;
                }

                switch ($input['action']) {
                    case 'mark_as_read':
                        if (isset($input['notification_id'])) {
                            $success = $this->notificationService->markAsRead($input['notification_id'], $userId);
                            echo json_encode([
                                'success' => $success
                            ]);
                        } else {
                            echo json_encode([
                                'success' => false,
                                'error' => 'Notification ID required'
                            ]);
                        }
                        break;

                    case 'mark_all_as_read':
                        $success = $this->notificationService->markAllAsRead($userId);
                        echo json_encode([
                            'success' => $success
                        ]);
                        break;

                    default:
                        echo json_encode([
                            'success' => false,
                            'error' => 'Invalid action'
                        ]);
                }
            } else {
                http_response_code(405);
                echo json_encode([
                    'success' => false,
                    'error' => 'Method not allowed'
                ]);
            }
        } catch (Exception $e) {
            error_log("❌ API Error: " . $e->getMessage());
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'error' => 'Server error: ' . $e->getMessage()
            ]);
        }

        // FIXED: Ensure script stops here
        exit;
    }

    /**
     * Display all notifications for jobseekers
     */
    public function viewAllJobseekerNotifications()
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: ?page=login-jobseeker');
            exit;
        }

        $userId = $_SESSION['user_id'];

        // Handle POST requests for marking as read (from the view page forms)
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
            $this->handleNotificationActions($userId, 'jobseeker');
            return;
        }

        // Handle pagination
        $currentPage = isset($_GET['p']) ? max(1, (int)$_GET['p']) : 1;
        $limit = 15;
        $offset = ($currentPage - 1) * $limit;

        // Get notifications data
        $notifications = $this->notificationService->getUserNotifications($userId, $limit, $offset);
        $unreadCount = $this->notificationService->getUnreadCount($userId);

        // Check if there are more pages
        $hasNextPage = count($notifications) === $limit;

        // Pass data to the view
        $data = [
            'notifications' => $notifications,
            'unreadCount' => $unreadCount,
            'currentPage' => $currentPage,
            'hasNextPage' => $hasNextPage,
            'limit' => $limit
        ];

        // Include the view
        include __DIR__ . '/../views/jobseekers/notifications.php';
    }

    /**
     * Display all notifications for employers
     */
    public function viewAllEmployerNotifications()
    {
        // UPDATED: Handle both session variable types
        $userId = null;
        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];
        } elseif (isset($_SESSION['employer_id'])) {
            $userId = $_SESSION['employer_id'];
        }

        // Check if user is logged in
        if (!$userId) {
            header('Location: ?page=login-employer');
            exit;
        }

        // Handle POST requests for marking as read
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
            $this->handleNotificationActions($userId, 'employer');
            return;
        }

        // Handle pagination
        $currentPage = isset($_GET['p']) ? max(1, (int)$_GET['p']) : 1;
        $limit = 15;
        $offset = ($currentPage - 1) * $limit;

        // Get notifications data
        $notifications = $this->notificationService->getUserNotifications($userId, $limit, $offset);
        $unreadCount = $this->notificationService->getUnreadCount($userId);

        // Check if there are more pages
        $hasNextPage = count($notifications) === $limit;

        // Pass data to the view
        $data = [
            'notifications' => $notifications,
            'unreadCount' => $unreadCount,
            'currentPage' => $currentPage,
            'hasNextPage' => $hasNextPage,
            'limit' => $limit
        ];

        // FIXED: Include the correct employer notification view (plural)
        include __DIR__ . '/../views/employers/notifications.php';
    }

    /**
     * Handle notification actions from web forms (mark as read, mark all as read)
     */
    private function handleNotificationActions($userId, $userType = null)
    {
        if ($_POST['action'] === 'mark_as_read' && isset($_POST['notification_id'])) {
            $notificationId = (int)$_POST['notification_id'];
            $success = $this->notificationService->markAsRead($notificationId, $userId);

            // UPDATED: Dynamic redirect based on user type
            $redirectPage = 'notifications-jobseeker'; // default
            if ($userType === 'employer' || (isset($_SESSION['role']) && $_SESSION['role'] == 2)) {
                $redirectPage = 'notifications-employer';
            }

            if ($success) {
                header("Location: ?page=$redirectPage&success=Notification marked as read");
            } else {
                header("Location: ?page=$redirectPage&error=Failed to mark notification as read");
            }
        } elseif ($_POST['action'] === 'mark_all_as_read') {
            $success = $this->notificationService->markAllAsRead($userId);

            // UPDATED: Dynamic redirect based on user type
            $redirectPage = 'notifications-jobseeker'; // default
            if ($userType === 'employer' || (isset($_SESSION['role']) && $_SESSION['role'] == 2)) {
                $redirectPage = 'notifications-employer';
            }

            if ($success) {
                header("Location: ?page=$redirectPage&success=All notifications marked as read");
            } else {
                header("Location: ?page=$redirectPage&error=Failed to mark all notifications as read");
            }
        }
        exit;
    }
}
