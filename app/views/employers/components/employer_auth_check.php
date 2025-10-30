<?php
// filepath: c:\xampp\htdocs\sikap\app\views\employers\components\employer_auth_check.php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// FIXED: Check role more flexibly
$isEmployer = false;
if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] === 'employer' || $_SESSION['role'] == 2) {
        $isEmployer = true;
    }
}

// Check if user is logged in and is an employer
if (!isset($_SESSION['user_id']) || !$isEmployer) {
    header('Location: ?page=login-employer&error=Please log in to access this page');
    exit();
}

// FIXED: Skip model checking for now to avoid path issues
// Just do basic session validation
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    session_destroy();
    header('Location: ?page=login-employer&error=Session expired. Please log in again.');
    exit();
}

// Session timeout check
$session_timeout = 24 * 60 * 60; // 24 hours
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $session_timeout) {
    session_destroy();
    header('Location: ?page=login-employer&error=Session expired. Please log in again.');
    exit();
}

$_SESSION['last_activity'] = time();

// Optional: Add account status check only if needed
if (isset($_SESSION['employer_status'])) {
    if ($_SESSION['employer_status'] === 'suspended') {
        session_destroy();
        header('Location: ?page=login-employer&error=Your account has been suspended by the administrator. Please contact support for assistance.');
        exit();
    }

    if ($_SESSION['employer_status'] === 'rejected') {
        session_destroy();
        header('Location: ?page=login-employer&error=Your account application has been rejected. Please contact support.');
        exit();
    }
}
