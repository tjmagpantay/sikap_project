<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in - handle multiple possible session variables
$isLoggedIn = false;
$isEmployer = false;

// Check for employer_id (regular login)
if (isset($_SESSION['employer_id']) && !empty($_SESSION['employer_id'])) {
    $isLoggedIn = true;
    $isEmployer = true;
}

// Check for user_id with role (might be set by Google login)
if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
    $isLoggedIn = true;
    
    // Check if role indicates employer (role = 2)
    if (isset($_SESSION['role']) && $_SESSION['role'] == 2) {
        $isEmployer = true;
        // Set employer_id for consistency if not already set
        if (!isset($_SESSION['employer_id'])) {
            $_SESSION['employer_id'] = $_SESSION['user_id'];
        }
    }
}

// If not logged in at all, redirect to login
if (!$isLoggedIn) {
    // Store the current page URL for redirect after login
    $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
    
    // Clear any existing session data
    session_destroy();
    
    // Redirect to login page
    header('Location: ?page=login-employer');
    exit();
}

// If logged in but not an employer (role should be 2), redirect to appropriate login
if (!$isEmployer) {
    // Clear session and redirect
    session_destroy();
    header('Location: ?page=login-employer');
    exit();
}

// Add cache control headers to prevent browser cache issues
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');
?>