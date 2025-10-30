<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// FIXED: Check role correctly - jobseeker is 3, not 1
$isJobseeker = false;
if (isset($_SESSION['role'])) {
    // Handle both string and numeric role values
    if ($_SESSION['role'] === 'jobseeker' || $_SESSION['role'] == 3) {
        $isJobseeker = true;
    }
}

// Check if user is logged in and is a jobseeker
if (!isset($_SESSION['user_id']) || !$isJobseeker) {
    // Store the current page for redirect after login
    if (!isset($_SESSION['redirect_after_login'])) {
        $currentPage = $_GET['page'] ?? 'dashboard';
        $_SESSION['redirect_after_login'] = $currentPage;
    }

    header('Location: ?page=login-jobseeker&error=Please log in to access this page');
    exit();
}

// Session timeout check
$session_timeout = 24 * 60 * 60; // 24 hours
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $session_timeout) {
    session_destroy();
    header('Location: ?page=login-jobseeker&error=Session expired. Please log in again.');
    exit();
}

$_SESSION['last_activity'] = time();

// Add cache control headers to prevent browser cache issues
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');
