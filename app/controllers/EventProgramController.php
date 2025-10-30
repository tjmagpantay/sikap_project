<?php

require_once __DIR__ . '/../models/EventProgram.php';

class EventProgramController
{
    private $eventModel;

    public function __construct()
    {
        try {
            $this->eventModel = new EventProgram();
        } catch (Exception $e) {
            error_log("EventProgramController initialization failed: " . $e->getMessage());
            throw new Exception("Failed to initialize EventProgram controller");
        }
    }

    /**
     * Handle program-events page
     */
    public function programEvents()
    {
        try {
            $events = $this->eventModel->getAllEvents('show');

            // Make events available to the view
            return [
                'events' => $events,
                'view' => 'pages/program-events'
            ];
        } catch (Exception $e) {
            error_log("Error in programEvents: " . $e->getMessage());
            return [
                'events' => [],
                'error' => 'Failed to load events',
                'view' => 'pages/program-events'
            ];
        }
    }

    /**
     * Handle event-info page
     */
    public function eventInfo()
    {
        try {
            $eventId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

            if ($eventId <= 0) {
                return [
                    'event' => null,
                    'error' => 'Invalid event ID',
                    'view' => 'pages/event-info'
                ];
            }

            $event = $this->eventModel->getEventById($eventId);

            return [
                'event' => $event,
                'view' => 'pages/event-info'
            ];
        } catch (Exception $e) {
            error_log("Error in eventInfo: " . $e->getMessage());
            return [
                'event' => null,
                'error' => 'Failed to load event details',
                'view' => 'pages/event-info'
            ];
        }
    }

    /**
     * Get events by type (for filtering)
     */
    public function getEventsByType($type)
    {
        try {
            return $this->eventModel->getEventsByType($type, 'show');
        } catch (Exception $e) {
            error_log("Error getting events by type: " . $e->getMessage());
            return [];
        }
    }
    public function getActiveEvents()
    {
        try {
            return $this->eventModel->getAllEvents('show');
        } catch (Exception $e) {
            error_log("Error getting active events: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Store/Create new event
     */
    public function store()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                header('Location: ?page=admin-events&error=Invalid request method');
                exit;
            }

            // Get form data
            $title = trim($_POST['title'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $type = trim($_POST['type'] ?? '');
            $timeStart = $_POST['time_start'] ?? '';
            $timeEnd = $_POST['time_end'] ?? '';
            $status = $_POST['status'] ?? 'show';

            // Validate required fields
            if (empty($title) || empty($type) || empty($timeStart) || empty($timeEnd)) {
                header('Location: ?page=admin-event-create&error=' . urlencode('All fields are required'));
                exit;
            }

            // Handle image upload
            $imagePath = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $imagePath = $this->handleImageUpload($_FILES['image']);
                if (!$imagePath) {
                    header('Location: ?page=admin-event-create&error=' . urlencode('Failed to upload image'));
                    exit;
                }
            }

            // Create event
            $eventId = $this->eventModel->createEvent($title, $description, $type, $imagePath, $timeStart, $timeEnd, $status);

            if ($eventId) {
                header('Location: ?page=admin-events&success=' . urlencode('Event created successfully'));
            } else {
                header('Location: ?page=admin-event-create&error=' . urlencode('Failed to create event'));
            }
            exit;
        } catch (Exception $e) {
            error_log("Error creating event: " . $e->getMessage());
            header('Location: ?page=admin-event-create&error=' . urlencode('Error creating event'));
            exit;
        }
    }

    /**
     * Update existing event
     */
    public function update($eventId)
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                header('Location: ?page=admin-events&error=Invalid request method');
                exit;
            }

            // Get form data
            $title = trim($_POST['title'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $type = trim($_POST['type'] ?? '');
            $timeStart = $_POST['time_start'] ?? '';
            $timeEnd = $_POST['time_end'] ?? '';
            $status = $_POST['status'] ?? 'show';

            // Validate required fields
            if (empty($title) || empty($type) || empty($timeStart) || empty($timeEnd)) {
                header('Location: ?page=admin-event-edit&id=' . $eventId . '&error=' . urlencode('All fields are required'));
                exit;
            }

            // Handle image upload (optional for update)
            $imagePath = $_POST['current_image'] ?? null; // Keep current image by default
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $newImagePath = $this->handleImageUpload($_FILES['image']);
                if ($newImagePath) {
                    // Delete old image if exists
                    if ($imagePath && file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                    $imagePath = $newImagePath;
                }
            }

            // Update event
            $success = $this->eventModel->updateEvent($eventId, $title, $description, $type, $imagePath, $timeStart, $timeEnd, $status);

            if ($success) {
                header('Location: ?page=admin-events&success=' . urlencode('Event updated successfully'));
            } else {
                header('Location: ?page=admin-event-edit&id=' . $eventId . '&error=' . urlencode('Failed to update event'));
            }
            exit;
        } catch (Exception $e) {
            error_log("Error updating event: " . $e->getMessage());
            header('Location: ?page=admin-event-edit&id=' . $eventId . '&error=' . urlencode('Error updating event'));
            exit;
        }
    }

    /**
     * Delete event
     */
    public function delete($eventId)
    {
        try {
            // Get event details before deletion to remove image file
            $event = $this->eventModel->getEventById($eventId);

            if (!$event) {
                header('Location: ?page=admin-events&error=' . urlencode('Event not found'));
                exit;
            }

            // Delete event from database
            $success = $this->eventModel->deleteEvent($eventId);

            if ($success) {
                // Delete image file if exists
                if ($event['image'] && file_exists($event['image'])) {
                    unlink($event['image']);
                }

                header('Location: ?page=admin-events&success=' . urlencode('Event deleted successfully'));
            } else {
                header('Location: ?page=admin-events&error=' . urlencode('Failed to delete event'));
            }
            exit;
        } catch (Exception $e) {
            error_log("Error deleting event: " . $e->getMessage());
            header('Location: ?page=admin-events&error=' . urlencode('Error deleting event'));
            exit;
        }
    }

    /**
     * Toggle event status (show/hide)
     */
    public function toggleEventStatus($eventId)
    {
        try {
            // Get current event
            $event = $this->eventModel->getEventById($eventId);

            if (!$event) {
                header('Location: ?page=admin-events&error=' . urlencode('Event not found'));
                exit;
            }

            // Toggle status
            $newStatus = ($event['status'] === 'show') ? 'hide' : 'show';
            $success = $this->eventModel->updateEventStatus($eventId, $newStatus);

            if ($success) {
                $statusText = ($newStatus === 'show') ? 'activated' : 'deactivated';
                header('Location: ?page=admin-events&success=' . urlencode("Event {$statusText} successfully"));
            } else {
                header('Location: ?page=admin-events&error=' . urlencode('Failed to update event status'));
            }
            exit;
        } catch (Exception $e) {
            error_log("Error toggling event status: " . $e->getMessage());
            header('Location: ?page=admin-events&error=' . urlencode('Error updating event status'));
            exit;
        }
    }

    /**
     * Toggle event pin status
     */
    public function togglePin()
    {
        try {
            $eventId = $_POST['event_id'] ?? $_GET['id'] ?? null;

            if (!$eventId) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'error' => 'Event ID required']);
                exit;
            }

            $success = $this->eventModel->togglePin($eventId);

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // AJAX request
                header('Content-Type: application/json');
                if ($success) {
                    $isPinned = $this->eventModel->isEventPinned($eventId);
                    echo json_encode([
                        'success' => true,
                        'pinned' => $isPinned,
                        'message' => $isPinned ? 'Event pinned successfully' : 'Event unpinned successfully'
                    ]);
                } else {
                    echo json_encode(['success' => false, 'error' => 'Failed to toggle pin status']);
                }
                exit;
            } else {
                // Regular request
                if ($success) {
                    header('Location: ?page=admin-events&success=' . urlencode('Pin status updated successfully'));
                } else {
                    header('Location: ?page=admin-events&error=' . urlencode('Failed to update pin status'));
                }
                exit;
            }
        } catch (Exception $e) {
            error_log("Error toggling pin status: " . $e->getMessage());

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'error' => 'Error updating pin status']);
            } else {
                header('Location: ?page=admin-events&error=' . urlencode('Error updating pin status'));
            }
            exit;
        }
    }

    /**
     * Public view for events (job fair page)
     */
    public function publicView()
    {
        try {
            // Get all active events
            $events = $this->eventModel->getAllEvents('show');

            // Filter by type if specified
            $type = $_GET['type'] ?? null;
            if ($type && in_array($type, ['program', 'jobfair', 'local recruitment'])) {
                $events = array_filter($events, function ($event) use ($type) {
                    return $event['type'] === $type;
                });
            }

            // Include the public view
            include __DIR__ . '/../views/pages/events-jobfair.php';
        } catch (Exception $e) {
            error_log("Error in public view: " . $e->getMessage());
            include __DIR__ . '/../views/pages/404.php';
        }
    }

    /**
     * Get event by ID (for external use)
     */
    public function getEventById($eventId)
    {
        try {
            return $this->eventModel->getEventById($eventId);
        } catch (Exception $e) {
            error_log("Error getting event by ID: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Handle image upload for events
     */
    private function handleImageUpload($file)
    {
        try {
            // Validate file
            $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
            if (!in_array($file['type'], $allowedTypes)) {
                return false;
            }

            // Check file size (max 5MB)
            if ($file['size'] > 5 * 1024 * 1024) {
                return false;
            }

            // Create upload directory if it doesn't exist
            $uploadDir = __DIR__ . '/../../public/uploads/events/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            // Generate unique filename
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $filename = uniqid('event_') . '.' . $extension;
            $destination = $uploadDir . $filename;

            // Move uploaded file
            if (move_uploaded_file($file['tmp_name'], $destination)) {
                return 'uploads/events/' . $filename; // Return relative path
            }

            return false;
        } catch (Exception $e) {
            error_log("Error uploading image: " . $e->getMessage());
            return false;
        }
    }
}
