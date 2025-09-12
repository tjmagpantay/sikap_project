<?php
session_start();

require_once "../../config/db.php";

// autoload (reuse from index)
spl_autoload_register(function ($class) {
    $paths = [
        __DIR__ . '/../../app/models/' . $class . '.php',
        __DIR__ . '/../../app/controllers/' . $class . '.php',
        __DIR__ . '/../../app/services/' . $class . '.php',
    ];
    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(["error" => "Unauthorized"]);
    exit;
}

$userId = $_SESSION['user_id'];
$lastCheck = $_GET['since'] ?? null;

$notifController = new NotificationController($pdo);
$notifications = $notifController->index($userId, $lastCheck);

header("Content-Type: application/json");
echo json_encode($notifications);
