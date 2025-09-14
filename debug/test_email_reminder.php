<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/controllers/ReviewApplicationController.php';

try {
    $controller = new ReviewApplicationController();
    $controller->sendStatusReminderEmails();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}