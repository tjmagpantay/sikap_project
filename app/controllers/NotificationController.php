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

    // FIXED: Use consistent database connection pattern
    $config = require __DIR__ . '/../../config/sikap_db.php';
    try {
        $dsn = "mysql:host={$config['db_host']};port={$config['db_port']};dbname={$config['db_name']};charset=utf8mb4";
        
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_TIMEOUT => 30,
            PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false
        ];

        $this->pdo = new PDO($dsn, $config['db_user'], $config['db_pass'], $options);
    } catch (PDOException $e) {
        error_log("NotificationController database connection failed: " . $e->getMessage());
        throw new Exception("Database connection failed: " . $e->getMessage());
    }

    $this->notificationService = new NotificationService($this->pdo);
}

    public function apiEndpoint()
    {
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
            // UPDATED: Handle user_id, employer_id, and admin_id session variables
            $userId = null;
            if (isset($_SESSION['user_id'])) {
                $userId = (int)$_SESSION['user_id'];
            } elseif (isset($_SESSION['employer_id'])) {
                $userId = (int)$_SESSION['employer_id'];
            } elseif (isset($_SESSION['admin_id'])) {
                $userId = (int)$_SESSION['admin_id'];
            }

            if (!$userId) {
                http_response_code(401);
                echo json_encode([
                    'success' => false,
                    'error' => 'Unauthorized - Please log in'
                ]);
                exit;
            }



            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                // Handle GET requests (fetch notifications)
                $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 5;
                $offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;

                $notifications = $this->notificationService->getUserNotifications($userId, $limit, $offset);
                $unreadCount = $this->notificationService->getUnreadCount($userId);

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
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'error' => 'Server error: ' . $e->getMessage()
            ]);
        }

        // FIXED: Ensure script stops here
        exit;
    }

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

    public function viewAllAdminNotifications()
    {
        // UPDATED: Handle admin session variable
        $userId = null;
        if (isset($_SESSION['admin_id'])) {
            $userId = $_SESSION['admin_id'];
        } elseif (isset($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role'] == 1) {
            $userId = $_SESSION['user_id'];
        }

        // Check if admin is logged in
        if (!$userId) {
            header('Location: ?page=admin-login');
            exit;
        }

        // Handle POST requests for marking as read
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
            $this->handleNotificationActions($userId, 'admin');
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
        include __DIR__ . '/../views/admin/notifications.php';
    }

    private function handleNotificationActions($userId, $userType = null)
    {
        if ($_POST['action'] === 'mark_as_read' && isset($_POST['notification_id'])) {
            $notificationId = (int)$_POST['notification_id'];
            $success = $this->notificationService->markAsRead($notificationId, $userId);

            // UPDATED: Dynamic redirect based on user type
            $redirectPage = 'notifications-jobseeker'; // default
            if ($userType === 'employer' || (isset($_SESSION['role']) && $_SESSION['role'] == 2)) {
                $redirectPage = 'notifications-employer';
            } elseif ($userType === 'admin' || (isset($_SESSION['role']) && $_SESSION['role'] == 1)) {
                $redirectPage = 'notifications-admin';
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
            } elseif ($userType === 'admin' || (isset($_SESSION['role']) && $_SESSION['role'] == 1)) {
                $redirectPage = 'notifications-admin';
            }

            if ($success) {
                header("Location: ?page=$redirectPage&success=All notifications marked as read");
            } else {
                header("Location: ?page=$redirectPage&error=Failed to mark all notifications as read");
            }
        }
        exit;
    }

    public function validateAndRedirect()
    {
        // Get the target link from GET parameter
        $targetLink = $_GET['link'] ?? '';
        $fallbackPage = $_GET['fallback'] ?? 'notifications-jobseeker';

        if (!$targetLink) {
            header("Location: ?page=$fallbackPage");
            exit;
        }

        // Try to validate the link by checking if the target exists
        try {
            // Parse the target link to extract page and parameters
            $parsedUrl = parse_url($targetLink);
            parse_str($parsedUrl['query'] ?? '', $queryParams);

            $targetPage = $queryParams['page'] ?? '';

            // Check if target content exists based on page type
            $contentExists = $this->validateTargetContent($targetPage, $queryParams);

            if ($contentExists) {
                // Content exists, redirect to original link
                header("Location: $targetLink");
            } else {
                // Content doesn't exist, redirect to fallback
                header("Location: ?page=$fallbackPage");
            }
        } catch (Exception $e) {
            // Any error, redirect to fallback
            header("Location: ?page=$fallbackPage");
        }

        exit;
    }

    private function validateTargetContent($page, $params)
    {
        try {
            switch ($page) {
                case 'job-details':
                case 'view-job':
                case 'apply-job':
                    if (isset($params['job_id']) || isset($params['id'])) {
                        $jobId = $params['job_id'] ?? $params['id'];

                        // Check if JobPost model exists
                        if (file_exists(__DIR__ . '/../models/JobPost.php')) {
                            require_once __DIR__ . '/../models/JobPost.php';
                            $jobPostModel = new JobPost($this->pdo);

                            // Check if method exists
                            if (method_exists($jobPostModel, 'isJobActiveById')) {
                                return $jobPostModel->isJobActiveById($jobId);
                            }
                        }

                        // Fallback: Direct database query
                        $stmt = $this->pdo->prepare("SELECT job_id FROM job_post WHERE job_id = ? AND job_status = 'open'");
                        $stmt->execute([$jobId]);
                        return $stmt->fetchColumn() !== false;
                    }
                    break;

                case 'view-application':
                case 'my-applications':
                    if (isset($params['application_id'])) {
                        // Check if JobApplication model exists
                        if (file_exists(__DIR__ . '/../models/JobApplication.php')) {
                            require_once __DIR__ . '/../models/JobApplication.php';
                            $jobApplicationModel = new JobApplication($this->pdo);

                            // Check if method exists
                            if (method_exists($jobApplicationModel, 'exists')) {
                                return $jobApplicationModel->exists($params['application_id']);
                            }
                        }

                        // Fallback: Direct database query
                        $stmt = $this->pdo->prepare("SELECT application_id FROM job_application WHERE application_id = ?");
                        $stmt->execute([$params['application_id']]);
                        return $stmt->fetchColumn() !== false;
                    }
                    // If no specific application_id, allow access to general applications page
                    return true;
                    break;

                case 'event-details':
                case 'event-info':
                case 'event-info-jobseeker':
                case 'program-details':
                case 'programs-jobseeker':
                    if (isset($params['id']) || isset($params['event_id'])) {
                        $eventId = $params['id'] ?? $params['event_id'];

                        // Direct database query for events (since Event model might not exist)
                        $stmt = $this->pdo->prepare("SELECT event_id FROM events WHERE event_id = ? AND status = 'show'");
                        $stmt->execute([$eventId]);
                        return $stmt->fetchColumn() !== false;
                    }
                    return true;
                    break;

                case 'review-application':
                    if (isset($params['application_id'])) {
                        // Direct database query fallback
                        $stmt = $this->pdo->prepare("SELECT application_id FROM job_application WHERE application_id = ?");
                        $stmt->execute([$params['application_id']]);
                        return $stmt->fetchColumn() !== false;
                    }
                    break;

                // General pages that don't need validation
                case 'applications':
                case 'job-posts':
                case 'employer-programs':
                case 'manage-jobs':
                case 'browse-jobs':
                case 'program-events':
                    return true;
                    break;
            }

            // For unknown pages, assume they don't exist
            return false;
        } catch (Exception $e) {
            error_log("Error validating target content: " . $e->getMessage());
            return false;
        }
    }
}
