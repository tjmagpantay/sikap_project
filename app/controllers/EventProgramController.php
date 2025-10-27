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
}
