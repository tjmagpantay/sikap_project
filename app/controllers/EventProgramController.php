<?php

require_once __DIR__ . '/../models/EventProgram.php';

class EventProgramController
{
    private $model;
    private $uploadDir;

    public function __construct()
    {
        $this->model = new EventProgram();
        $this->uploadDir = __DIR__ . '/../../public/uploads/events/';

        if (!file_exists($this->uploadDir)) {
            mkdir($this->uploadDir, 0777, true);
        }
    }

    public function index()
    {
        if (!isset($_SESSION['admin_id'])) {
            header('Location: index.php?page=admin-login');
            exit;
        }
        $events = $this->model->getAllEvents();
        include __DIR__ . '/../views/admin/events/event.php';
    }

    public function create()
    {
        if (!isset($_SESSION['admin_id'])) {
            header('Location: index.php?page=admin-login');
            exit;
        }
        include __DIR__ . '/../views/admin/events/create.php';
    }

    public function store()
    {
        // Validate inputs
        if (
            empty($_POST['title']) || empty($_POST['description']) ||
            empty($_POST['type']) || empty($_POST['time_start']) ||
            empty($_POST['time_end']) || empty($_POST['status'])
        ) {
            header('Location: index.php?page=admin-event-create&error=All fields are required');
            exit;
        }

        // Handle image upload
        $image_path = '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES['image'];

            // Validate file type
            $allowed_types = ['image/jpeg', 'image/png'];
            if (!in_array($file['type'], $allowed_types)) {
                header('Location: index.php?page=admin-event-create&error=Only JPG and PNG files are allowed');
                exit;
            }

            // Validate file size (5MB max)
            if ($file['size'] > 5 * 1024 * 1024) {
                header('Location: index.php?page=admin-event-create&error=File size must be less than 5MB');
                exit;
            }

            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $filename = uniqid() . '.' . $ext;
            $image_path = 'uploads/events/' . $filename;

            move_uploaded_file($file['tmp_name'], $this->uploadDir . $filename);
        }

        // Only allow valid types
        $valid_types = ['program', 'jobfair', 'local recruitment'];
        $type = in_array($_POST['type'], $valid_types) ? $_POST['type'] : 'program';
        $success = $this->model->createEvent(
            $_POST['title'],
            $_POST['description'],
            $type,
            $image_path,
            $_POST['time_start'],
            $_POST['time_end'],
            $_POST['status']
        );

        if ($success) {
            header('Location: index.php?page=admin-events&success=Event created successfully');
        } else {
            header('Location: index.php?page=admin-event-create&error=Failed to create event');
        }
        exit;
    }

    public function edit($id)
    {
        $event = $this->model->getEventById($id);
        if (!$event) {
            header('Location: index.php?page=admin-events&error=Event not found');
            exit;
        }
        include __DIR__ . '/../views/admin/events/edit.php';
    }

    public function update($id)
    {
        // Validate inputs
        if (
            empty($_POST['title']) || empty($_POST['description']) ||
            empty($_POST['type']) || empty($_POST['time_start']) ||
            empty($_POST['time_end']) || empty($_POST['status'])
        ) {
            header('Location: index.php?page=admin-event-edit&id=' . $id . '&error=All fields are required');
            exit;
        }

        $event = $this->model->getEventById($id);
        if (!$event) {
            header('Location: index.php?page=admin-events&error=Event not found');
            exit;
        }

        // Always use the new image if uploaded, otherwise keep the current image
        $image_path = $event['image'];
        if (isset($_FILES['image']) && is_uploaded_file($_FILES['image']['tmp_name']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES['image'];
            // Validate file type
            $allowed_types = ['image/jpeg', 'image/png'];
            if (!in_array($file['type'], $allowed_types)) {
                header('Location: index.php?page=admin-event-edit&id=' . $id . '&error=Only JPG and PNG files are allowed');
                exit;
            }
            // Validate file size (5MB max)
            if ($file['size'] > 5 * 1024 * 1024) {
                header('Location: index.php?page=admin-event-edit&id=' . $id . '&error=File size must be less than 5MB');
                exit;
            }
            // Delete old image if exists and is not empty
            if (!empty($event['image']) && file_exists($this->uploadDir . basename($event['image']))) {
                unlink($this->uploadDir . basename($event['image']));
            }
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $filename = uniqid() . '.' . $ext;
            $image_path = 'uploads/events/' . $filename;
            if (!move_uploaded_file($file['tmp_name'], $this->uploadDir . $filename)) {
                header('Location: index.php?page=admin-event-edit&id=' . $id . '&error=Failed to upload image');
                exit;
            }
        } else if (isset($_POST['current_image'])) {
            $image_path = $_POST['current_image'];
        }

        // Only allow valid types
        $valid_types = ['program', 'jobfair', 'local recruitment'];
        $type = in_array($_POST['type'], $valid_types) ? $_POST['type'] : 'program';
        $success = $this->model->updateEvent(
            $id,
            $_POST['title'],
            $_POST['description'],
            $type,
            $image_path,
            $_POST['time_start'],
            $_POST['time_end'],
            $_POST['status']
        );

        if ($success) {
            header('Location: index.php?page=admin-events&success=Event updated successfully');
        } else {
            header('Location: index.php?page=admin-event-edit&id=' . $id . '&error=Failed to update event');
        }
        exit;
    }

    public function delete($id)
    {
        $event = $this->model->getEventById($id);
        if ($event && $event['image']) {
            $image_path = $this->uploadDir . basename($event['image']);
            if (file_exists($image_path)) {
                unlink($image_path);
            }
        }

        $success = $this->model->deleteEvent($id);

        if ($success) {
            header('Location: index.php?page=admin-events&success=Event deleted successfully');
        } else {
            header('Location: index.php?page=admin-events&error=Failed to delete event');
        }
        exit;
    }

    public function publicView()
    {
        // Fix: Use correct type names as stored in database
        $programs = $this->model->getEventsByType('program');
        $jobFairs = $this->model->getEventsByType('jobfair');
        $localRecruitment = $this->model->getEventsByType('local recruitment'); // Add this if needed
        include __DIR__ . '/../views/pages/event-jobfair.php';
    }

    public function getActiveEvents()
    {
        return $this->model->getActiveEvents();
    }

    public function searchEvents($query = '')
    {
        if (empty($query)) {
            return $this->model->getAllEvents();
        }
        return $this->model->searchEvents($query);
    }

    public function getUpcomingEvents($limit = 5)
    {
        return $this->model->getUpcomingEvents($limit);
    }

    public function getEventById($id)
    {
        return $this->model->getEventById($id);
    }

    public function toggleEventStatus($id)
    {
        if (!isset($_SESSION['admin_id'])) {
            header('Location: index.php?page=admin-login');
            exit;
        }

        $event = $this->model->getEventById($id);
        if (!$event) {
            header('Location: index.php?page=admin-events&error=Event not found');
            exit;
        }

        // Fix: Use correct status values from your database enum
        $newStatus = $event['status'] === 'show' ? 'hide' : 'show';
        $success = $this->model->updateEventStatus($id, $newStatus);

        if ($success) {
            header('Location: index.php?page=admin-events&success=Event status updated successfully');
        } else {
            header('Location: index.php?page=admin-events&error=Failed to update event status');
        }
        exit;
    }

    public function togglePin()
    {
        if (!isset($_SESSION['admin_id'])) {
            header('Location: index.php?page=admin-login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?page=admin-events&error=Invalid request method');
            exit;
        }

        if (!isset($_POST['event_id']) || !is_numeric($_POST['event_id'])) {
            header('Location: index.php?page=admin-events&error=Invalid event ID');
            exit;
        }

        $eventId = (int) $_POST['event_id'];
        $event = $this->model->getEventById($eventId);

        if (!$event) {
            header('Location: index.php?page=admin-events&error=Event not found');
            exit;
        }

        $success = $this->model->togglePin($eventId);

        if ($success) {
            $action = $event['pinned'] ? 'unpinned' : 'pinned';
            header('Location: index.php?page=admin-events&success=Event ' . $action . ' successfully');
        } else {
            header('Location: index.php?page=admin-events&error=Failed to update pin status');
        }
        exit;
    }

    private function validateImage($file)
    {
        $errors = [];
        $maxSize = 5 * 1024 * 1024; // 5MB
        $allowedTypes = ['image/jpeg', 'image/png'];

        if ($file['size'] > $maxSize) {
            $errors[] = 'File size must be less than 5MB';
        }

        if (!in_array($file['type'], $allowedTypes)) {
            $errors[] = 'Only JPG and PNG files are allowed';
        }

        return $errors;
    }

    private function handleImageUpload($file, $oldImage = null)
    {
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . '.' . $ext;
        $image_path = 'uploads/events/' . $filename;

        if ($oldImage && file_exists($this->uploadDir . basename($oldImage))) {
            unlink($this->uploadDir . basename($oldImage));
        }

        if (!move_uploaded_file($file['tmp_name'], $this->uploadDir . $filename)) {
            throw new Exception('Failed to upload image');
        }

        return $image_path;
    }
}
