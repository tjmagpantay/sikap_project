<?php
// Debug file to test event pin functionality
// You can run this file directly to test the database operations

require_once __DIR__ . '/../app/models/EventProgram.php';

session_start();

// Test the EventProgram model
try {
    $model = new EventProgram();

    echo "<h3>Testing Event Pin Functionality</h3>";

    // Test 1: Get all events with pin status
    echo "<h4>1. Getting all events with pin status:</h4>";
    $events = $model->getAllEvents();
    if ($events) {
        echo "<p>✅ Successfully retrieved " . count($events) . " events</p>";
        foreach ($events as $event) {
            $pinStatus = isset($event['pinned']) && $event['pinned'] == 1 ? 'PINNED' : 'NOT PINNED';
            echo "<p>- Event: {$event['title']} | Status: {$pinStatus}</p>";
        }
    } else {
        echo "<p>❌ No events found or error occurred</p>";
    }

    // Test 2: Try to pin an event (if events exist)
    if (!empty($events)) {
        $firstEvent = $events[0];
        $eventId = $firstEvent['event_id'];

        echo "<h4>2. Testing pin toggle for Event ID: {$eventId}</h4>";

        // Try to pin the event
        $currentPinStatus = isset($firstEvent['pinned']) && $firstEvent['pinned'] == 1;
        $newPinStatus = !$currentPinStatus;

        echo "<p>Current pin status: " . ($currentPinStatus ? 'PINNED' : 'NOT PINNED') . "</p>";
        echo "<p>Attempting to " . ($newPinStatus ? 'PIN' : 'UNPIN') . " the event...</p>";

        $result = $model->togglePin($eventId, $newPinStatus ? 1 : 0);

        if ($result) {
            echo "<p>✅ Pin toggle successful!</p>";

            // Verify the change
            $updatedEvent = $model->getEventById($eventId);
            $updatedPinStatus = isset($updatedEvent['pinned']) && $updatedEvent['pinned'] == 1;
            echo "<p>New pin status: " . ($updatedPinStatus ? 'PINNED' : 'NOT PINNED') . "</p>";
        } else {
            echo "<p>❌ Pin toggle failed</p>";
        }
    }

    // Test 3: Get only pinned events
    echo "<h4>3. Getting only pinned events:</h4>";
    $pinnedEvents = $model->getPinnedEvents();
    if ($pinnedEvents) {
        echo "<p>✅ Found " . count($pinnedEvents) . " pinned events</p>";
        foreach ($pinnedEvents as $event) {
            echo "<p>- Pinned Event: {$event['title']}</p>";
        }
    } else {
        echo "<p>ℹ️ No pinned events found</p>";
    }
} catch (Exception $e) {
    echo "<p>❌ Error: " . $e->getMessage() . "</p>";
    echo "<p>Make sure your database is running and the event_pins table exists.</p>";
}

echo "<h4>Database Requirements:</h4>";
echo "<p>Make sure you have run the SQL script to create the event_pins table:</p>";
echo "<pre>
CREATE TABLE IF NOT EXISTS event_pins (
    pin_id INT AUTO_INCREMENT PRIMARY KEY,
    event_id INT NOT NULL,
    pinned TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (event_id) REFERENCES events(event_id) ON DELETE CASCADE,
    UNIQUE KEY unique_event_pin (event_id)
);
</pre>";
