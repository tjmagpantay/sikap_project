<?php
require_once __DIR__ . '/../models/Notification.php';
require_once __DIR__ . '/../models/User.php';

class NotificationService {
    private $pdo;
    private $mailService;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->mailService = new MailService();
    }

    private function notifyUser($userId, $type, $message, $link = null) {
        $notif = new Notification($this->pdo);
        $notif->create($userId, $type, $message, $link);

        // Send email too
        $userModel = new User($this->pdo);
        $user = $userModel->getById($userId);
        if ($user && !empty($user['email'])) {
            $subject = "[$type] " . $message;
            $body = "<p>{$message}</p><p><a href='{$link}'>View Details</a></p>";
            $this->mailService->send($user['email'], $subject, $body);
        }
    }

    public function notifyAdmins($type, $message, $link = null) {
        $userModel = new User($this->pdo);
        $admins = $userModel->getByRole("admin");
        foreach ($admins as $admin) {
            $this->notifyUser($admin['id'], $type, $message, $link);
        }
    }

    public function notifyJobseekers($type, $message, $link = null) {
        $userModel = new User($this->pdo);
        $seekers = $userModel->getByRole("jobseeker");
        foreach ($seekers as $js) {
            $this->notifyUser($js['id'], $type, $message, $link);
        }
    }

    public function notifySingle($userId, $type, $message, $link = null) {
        $this->notifyUser($userId, $type, $message, $link);
    }
}
