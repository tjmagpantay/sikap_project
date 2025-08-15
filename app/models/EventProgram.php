<?php

class EventProgram {
    private $db;
    private $table = 'events';

    public function __construct() {
        $config = require __DIR__ . '/../../config/sikap_db.php';
        try {
            $this->db = new PDO(
                "mysql:host={$config['db_host']};dbname={$config['db_name']}",
                $config['db_user'],
                $config['db_pass']
            );
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    private function validateEventData($title, $description, $type, $timeStart, $timeEnd) {
        $errors = [];
        if (empty($title)) {
            $errors[] = "Title is required";
        }
        if (empty($description)) {
            $errors[] = "Description is required";
        }
        if (!in_array($type, ['program', 'jobfair', 'local recruitment'])) {
            $errors[] = "Invalid event type";
        }
        $start = strtotime($timeStart);
        $end = strtotime($timeEnd);
        if ($start === false || $end === false) {
            $errors[] = "Invalid date format";
        } elseif ($start >= $end) {
            $errors[] = "End time must be after start time";
        }
        return $errors;
    }

    public function getAllEvents() {
        $stmt = $this->db->query("SELECT * FROM {$this->table} ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getEventsByType($type) {
        $stmt = $this->db->prepare("
            SELECT * FROM {$this->table} 
            WHERE type = ? AND status = 'show' 
            ORDER BY time_start ASC
        ");
        $stmt->execute([$type]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getEventById($id) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE event_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createEvent($title, $description, $type, $image, $time_start, $time_end, $status) {
        $stmt = $this->db->prepare("
            INSERT INTO {$this->table} (title, description, type, image, time_start, time_end, status)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        return $stmt->execute([$title, $description, $type, $image, $time_start, $time_end, $status]);
    }

    public function updateEvent($id, $title, $description, $type, $image, $time_start, $time_end, $status) {
        $stmt = $this->db->prepare("
            UPDATE {$this->table}
            SET title = ?, description = ?, type = ?, image = ?, time_start = ?, time_end = ?, status = ?
            WHERE event_id = ?
        ");
        return $stmt->execute([$title, $description, $type, $image, $time_start, $time_end, $status, $id]);
    }

    public function deleteEvent($id) {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE event_id = ?");
        return $stmt->execute([$id]);
    }

    public function searchEvents($query) {
        $query = "%{$query}%";
        $stmt = $this->db->prepare("
            SELECT * FROM {$this->table} 
            WHERE title LIKE ? OR description LIKE ?
            ORDER BY time_start ASC
        ");
        $stmt->execute([$query, $query]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUpcomingEvents($limit = 5) {
        $stmt = $this->db->prepare("
            SELECT * FROM {$this->table}
            WHERE time_start >= CURRENT_TIMESTAMP
            ORDER BY time_start ASC
            LIMIT ?
        ");
        $stmt->execute([$limit]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateEventStatus($id, $status) {
        $stmt = $this->db->prepare("
            UPDATE {$this->table}
            SET status = ?
            WHERE event_id = ?
        ");
        return $stmt->execute([$status, $id]);
    }

    public function getActiveEvents() {
        $stmt = $this->db->prepare("
            SELECT * FROM {$this->table}
            WHERE status = 'show'
            ORDER BY time_start ASC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}