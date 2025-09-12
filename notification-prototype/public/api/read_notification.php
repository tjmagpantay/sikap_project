<?php
session_start();
require_once "../../config/db.php";

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
$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['notification_id'])) {
    http_response_code(400);
    echo json_encode(["error" => "Missing notification_id"]);
    exit;
}

$notif = new Notification($pdo);
$notif->markAsRead($data['notification_id'], $userId);

header("Content-Type: application/json");
echo json_encode(["success" => true]);
