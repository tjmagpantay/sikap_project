<?php
require_once __DIR__ . '/../models/Notification.php';

class NotificationController {
    private $pdo;
    public function __construct($pdo) { $this->pdo = $pdo; }

    public function index($userId, $lastCheck = null) {
        $notifModel = new Notification($this->pdo);
        return $notifModel->getByUser($userId, $lastCheck);
    }
}
