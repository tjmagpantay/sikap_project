<?php
// Turn off error display to prevent HTML in JSON response
ini_set('display_errors', 0);
error_reporting(E_ALL);

session_start();
// FIXED: Correct path to database config
require_once __DIR__ . '/../../config/sikap_db.php';
require_once __DIR__ . '/../services/NotificationService.php';

header('Content-Type: application/json');

try {
    if (!isset($_SESSION['user_id'])) {
        http_response_code(401);
        echo json_encode(['error' => 'Unauthorized - Please log in']);
        exit;
    }

    $userId = (int)$_SESSION['user_id'];
    error_log("🔍 API: Fetching notifications for user ID: $userId");

    // Create PDO connection using config
    $config = require __DIR__ . '/../../config/sikap_db.php';
    $pdo = new PDO(
        "mysql:host={$config['db_host']};dbname={$config['db_name']}",
        $config['db_user'],
        $config['db_pass']
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $notificationService = new NotificationService($pdo);

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 15;
        $offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;

        $notifications = $notificationService->getUserNotifications($userId, $limit, $offset);
        $unreadCount = $notificationService->getUnreadCount($userId);

        error_log("✅ API: Found " . count($notifications) . " notifications, $unreadCount unread");

        echo json_encode([
            'success' => true,
            'notifications' => $notifications,
            'unread_count' => $unreadCount
        ]);
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $input = json_decode(file_get_contents('php://input'), true);

        if (!isset($input['action'])) {
            echo json_encode(['error' => 'Action required']);
            exit;
        }

        switch ($input['action']) {
            case 'mark_as_read':
                if (isset($input['notification_id'])) {
                    $success = $notificationService->markAsRead($input['notification_id'], $userId);
                    echo json_encode(['success' => $success]);
                } else {
                    echo json_encode(['error' => 'Notification ID required']);
                }
                break;

            case 'mark_all_as_read':
                $success = $notificationService->markAllAsRead($userId);
                echo json_encode(['success' => $success]);
                break;

            default:
                echo json_encode(['error' => 'Invalid action']);
        }
    }
} catch (Exception $e) {
    error_log("❌ API Error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'error' => 'Server error: ' . $e->getMessage()
    ]);
}
