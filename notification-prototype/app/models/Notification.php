<?php
class Notification {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function create($userId, $type, $message, $link = null) {
        $stmt = $this->pdo->prepare("
            INSERT INTO notifications (user_id, type, message, link, status, created_at)
            VALUES (:user_id, :type, :message, :link, 'unread', NOW())
        ");
        $stmt->execute([
            ":user_id" => $userId,
            ":type"    => $type,
            ":message" => $message,
            ":link"    => $link
        ]);
        return $this->pdo->lastInsertId();
    }

    public function getByUser($userId, $since = null) {
        $sql = "SELECT * FROM notifications WHERE user_id = :user_id ORDER BY created_at DESC";
        $params = [":user_id" => $userId];

        if ($since) {
            $sql = "SELECT * FROM notifications 
                    WHERE user_id = :user_id AND created_at > :since
                    ORDER BY created_at DESC";
            $params[":since"] = $since;
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function markAsRead($notifId, $userId) {
        $stmt = $this->pdo->prepare("
            UPDATE notifications SET status = 'read'
            WHERE id = :id AND user_id = :user_id
        ");
        return $stmt->execute([":id" => $notifId, ":user_id" => $userId]);
    }
}
