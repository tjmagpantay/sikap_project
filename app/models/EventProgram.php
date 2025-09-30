<?php

class EventProgram
{
    private $db;
    private $table = 'events';

    public function __construct()
    {
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

    private function validateEventData($title, $description, $type, $timeStart, $timeEnd)
    {
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

    public function getAllEvents()
    {
        $stmt = $this->db->query("SELECT * FROM {$this->table} ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getEventsByType($type)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM {$this->table} 
            WHERE type = ? AND status = 'show' 
            ORDER BY time_start ASC
        ");
        $stmt->execute([$type]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getEventById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE event_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createEvent($title, $description, $type, $image, $time_start, $time_end, $status)
    {
        try {
            $stmt = $this->db->prepare("
                INSERT INTO {$this->table} (title, description, type, image, time_start, time_end, status)
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ");
            $result = $stmt->execute([$title, $description, $type, $image, $time_start, $time_end, $status]);

            if ($result) {
                $eventId = $this->db->lastInsertId();
                error_log("✅ Event created with ID: $eventId");

                // FIXED: Automatically send notifications if status is 'show'
                if ($status === 'show') {
                    error_log("🔔 Auto-sending notifications for new event ID: $eventId");

                    // Send notifications to jobseekers
                    $this->notifyJobseekersAboutNewProgram($eventId);

                    // Send notifications to employers
                    $this->notifyEmployersAboutNewProgram($eventId);
                }

                return $eventId; // Return the event ID instead of just true
            }

            return false;
        } catch (Exception $e) {
            error_log("❌ Error creating event: " . $e->getMessage());
            return false;
        }
    }

    public function updateEvent($id, $title, $description, $type, $image, $time_start, $time_end, $status)
    {
        $stmt = $this->db->prepare("
            UPDATE {$this->table}
            SET title = ?, description = ?, type = ?, image = ?, time_start = ?, time_end = ?, status = ?
            WHERE event_id = ?
        ");
        return $stmt->execute([$title, $description, $type, $image, $time_start, $time_end, $status, $id]);
    }

    public function deleteEvent($id)
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE event_id = ?");
        return $stmt->execute([$id]);
    }

    public function searchEvents($query)
    {
        $query = "%{$query}%";
        $stmt = $this->db->prepare("
            SELECT * FROM {$this->table} 
            WHERE title LIKE ? OR description LIKE ?
            ORDER BY time_start ASC
        ");
        $stmt->execute([$query, $query]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUpcomingEvents($limit = 5)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM {$this->table}
            WHERE time_start >= CURRENT_TIMESTAMP
            ORDER BY time_start ASC
            LIMIT ?
        ");
        $stmt->execute([$limit]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateEventStatus($id, $status)
    {
        $stmt = $this->db->prepare("
            UPDATE {$this->table}
            SET status = ?
            WHERE event_id = ?
        ");
        return $stmt->execute([$status, $id]);
    }

    public function getActiveEvents()
    {
        $stmt = $this->db->prepare("
            SELECT * FROM {$this->table}
            WHERE status = 'show'
            ORDER BY time_start ASC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function togglePin($eventId)
    {
        try {
            // Get current pin status
            $stmt = $this->db->prepare("SELECT pinned FROM {$this->table} WHERE event_id = ?");
            $stmt->execute([$eventId]);
            $currentStatus = $stmt->fetchColumn();

            if ($currentStatus === false) {
                return false; // Event not found
            }

            // Toggle the pin status
            $newStatus = $currentStatus ? 0 : 1;
            $stmt = $this->db->prepare("UPDATE {$this->table} SET pinned = ? WHERE event_id = ?");
            return $stmt->execute([$newStatus, $eventId]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getPinnedEvents()
    {
        $stmt = $this->db->prepare("
            SELECT * FROM {$this->table}
            WHERE pinned = 1
            ORDER BY created_at DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function isEventPinned($eventId)
    {
        $stmt = $this->db->prepare("SELECT pinned FROM {$this->table} WHERE event_id = ?");
        $stmt->execute([$eventId]);
        return (bool) $stmt->fetchColumn();
    }

    public function notifyJobseekersAboutNewProgram($eventId)
    {
        try {
            require_once __DIR__ . '/../services/EventEmailNotifService.php';

            // Use the same database connection from this model
            $notificationService = new EventEmailNotifService($this->db);
            $result = $notificationService->notifyJobseekersAboutNewProgram($eventId);

            if ($result) {
                error_log("✅ Email notifications sent successfully for event ID: " . $eventId);
            } else {
                error_log("⚠️ Failed to send email notifications for event ID: " . $eventId);
            }

            return $result;
        } catch (Exception $e) {
            error_log("❌ Error in EventProgram::notifyJobseekersAboutNewProgram: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            return false;
        }
    }

    public function notifyEmployersAboutNewProgram($eventId)
    {
        try {
            require_once __DIR__ . '/../services/NotificationService.php';

            // Use the same database connection from this model
            $notificationService = new NotificationService($this->db);
            return $notificationService->notifyEmployersAboutNewProgram($eventId);
        } catch (Exception $e) {
            error_log("❌ Error in EventProgram::notifyEmployersAboutNewProgram: " . $e->getMessage());
            return false;
        }
    }

    public function getDatabase()
    {
        return $this->db;
    }

    public function isActiveById($eventId)
    {
        try {
            $stmt = $this->db->prepare("
                SELECT event_id 
                FROM events 
                WHERE event_id = ? AND status = 'show'
            ");
            $stmt->execute([$eventId]);

            return $stmt->fetchColumn() !== false;
        } catch (Exception $e) {
            error_log("Error checking if event is active: " . $e->getMessage());
            return false;
        }
    }

    public function exists($eventId)
    {
        try {
            $stmt = $this->db->prepare("
                SELECT event_id 
                FROM events 
                WHERE event_id = ?
            ");
            $stmt->execute([$eventId]);

            return $stmt->fetchColumn() !== false;
        } catch (Exception $e) {
            error_log("Error checking if event exists: " . $e->getMessage());
            return false;
        }
    }
}
