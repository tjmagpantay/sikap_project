<?php
session_start();

// 1. Autoloader
spl_autoload_register(function ($class) {
    $paths = [
        __DIR__ . '/../app/models/' . $class . '.php',
        __DIR__ . '/../app/controllers/' . $class . '.php',
        __DIR__ . '/../app/services/' . $class . '.php',
    ];
    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});

// 2. Load DB
require_once "../config/db.php";

// 3. Simulate logged-in user
if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = 2; // Employer for demo
}

// 4. Route handling
$path = $_GET['route'] ?? 'dashboard';

switch ($path) {
    case 'jobs':
        include "jobs.php";
        break;
    case 'applications':
        include "applications.php";
        break;
    case 'dashboard':
    default:
        include "dashboard.php";
        break;
}
