<?php
session_start();
require_once __DIR__ . '/../../config/database.php'; // Fixed path
require_once __DIR__ . '/../services/NotificationService.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$notificationService = new NotificationService($pdo);
$userId = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 15;
    $offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;

    $notifications = $notificationService->getUserNotifications($userId, $limit, $offset);
    $unreadCount = $notificationService->getUnreadCount($userId);

    echo json_encode([
        'notifications' => $notifications,
        'unread_count' => $unreadCount
    ]);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    if (isset($input['action'])) {
        switch ($input['action']) {
            case 'mark_as_read':
                if (isset($input['notification_id'])) {
                    $success = $notificationService->markAsRead($input['notification_id'], $userId);
                    echo json_encode(['success' => $success]);
                } else {
                    echo json_encode(['error' => 'notification_id required']);
                }
                break;

            case 'mark_all_as_read':
                $success = $notificationService->markAllAsRead($userId);
                echo json_encode(['success' => $success]);
                break;

            default:
                echo json_encode(['error' => 'Invalid action']);
        }
    } else {
        echo json_encode(['error' => 'Action required']);
    }
}
