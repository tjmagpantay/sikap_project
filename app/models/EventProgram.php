<?php

class EventProgram
{
    private $db;
    private $table = 'events';

    public function __construct()
    {
        $config = require __DIR__ . '/../../config/sikap_db.php';

        try {
            // CRITICAL: Add port for Railway connection
            $dsn = "mysql:host={$config['db_host']};port={$config['db_port']};dbname={$config['db_name']};charset=utf8mb4";

            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_TIMEOUT => 30 // Important for Railway free tier
            ];

            $this->db = new PDO($dsn, $config['db_user'], $config['db_pass'], $options);
        } catch (PDOException $e) {
            error_log("EventProgram database connection failed: " . $e->getMessage());
            throw new Exception("Database connection failed: " . $e->getMessage());
        }
    }

    private function validateEventData($title, $description, $type, $timeStart, $timeEnd)
    {
        $errors = [];
        if (empty($title)) {
            $errors[] = "Title is required";
        }
        // description optional; validate length if provided
        if (!is_null($description) && $description !== '') {
            if (strlen($description) > 1000) {
                $errors[] = "Description cannot exceed 1000 characters";
            }
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

    /**
     * Get all events with proper filtering
     */
    public function getAllEvents($status = 'show')
    {
        try {
            $sql = "SELECT * FROM events WHERE status = :status ORDER BY pinned DESC, time_start ASC";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':status', $status);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching events: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get event by ID
     */
    public function getEventById($eventId)
    {
        try {
            $sql = "SELECT * FROM events WHERE event_id = :event_id AND status = 'show'";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':event_id', $eventId, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching event by ID: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Get events by type
     */
    public function getEventsByType($type, $status = 'show')
    {
        try {
            $sql = "SELECT * FROM events WHERE type = :type AND status = :status ORDER BY pinned DESC, time_start ASC";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':type', $type);
            $stmt->bindParam(':status', $status);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching events by type: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get pinned events
     */
    public function getPinnedEvents($status = 'show')
    {
        try {
            $sql = "SELECT * FROM events WHERE pinned = 1 AND status = :status ORDER BY time_start ASC";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':status', $status);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching pinned events: " . $e->getMessage());
            return [];
        }
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
        try {
            $stmt = $this->db->prepare("
            UPDATE {$this->table}
            SET title = ?, description = ?, type = ?, image = ?, time_start = ?, time_end = ?, status = ?
            WHERE event_id = ?
        ");
            $result = $stmt->execute([$title, $description, $type, $image, $time_start, $time_end, $status, $id]);
            if (!$result) {
                $errorInfo = $stmt->errorInfo();
                error_log("❌ EventProgram::updateEvent failed for id=$id: " . json_encode($errorInfo));
            }
            return $result;
        } catch (Exception $e) {
            error_log("❌ EventProgram::updateEvent exception for id=$id: " . $e->getMessage());
            return false;
        }
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
