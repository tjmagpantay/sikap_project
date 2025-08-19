<?php
// Handle view all companies for non-logged-in users
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Store the intended destination
    $_SESSION['redirect_after_login'] = "?page=explore-companies";

    // Redirect to login with message
    $_SESSION['login_message'] = "Please log in to explore all companies.";
    header('Location: ?page=login-jobseeker');
    exit();
}

// If logged in, redirect to explore companies
header("Location: ?page=explore-companies");
exit();
