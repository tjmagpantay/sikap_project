<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in - handle multiple possible session variables
$isLoggedIn = false;
$isAdmin = false;

// Check for admin_id (regular login)
if (isset($_SESSION['admin_id']) && !empty($_SESSION['admin_id'])) {
    $isLoggedIn = true;
    $isAdmin = true;
}

// Check for user_id with role (might be set by alternative login methods)
if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
    $isLoggedIn = true;

    // Check if role indicates admin (role = 1)
    if (isset($_SESSION['role']) && $_SESSION['role'] == 1) {
        $isAdmin = true;
        // Set admin_id for consistency if not already set
        if (!isset($_SESSION['admin_id'])) {
            $_SESSION['admin_id'] = $_SESSION['user_id'];
        }
    }
}

// If not logged in at all, redirect to login
if (!$isLoggedIn) {
    // Store the current page URL for redirect after login
    $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];

    // Clear any existing session data
    session_destroy();

    // Redirect to admin login page
    header('Location: ?page=admin-login');
    exit();
}

// If logged in but not an admin (role should be 1), redirect to admin login
if (!$isAdmin) {
    // Clear session and redirect
    session_destroy();
    header('Location: ?page=admin-login');
    exit();
}

// Add cache control headers to prevent browser cache issues
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');
