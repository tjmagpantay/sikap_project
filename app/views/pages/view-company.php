<?php
// Handle company view for non-logged-in users
require_once __DIR__ . '/../controllers/LandingPageController.php';

$controller = new LandingPageController();

// Get employer ID from URL
$employer_id = isset($_GET['employer_id']) ? (int)$_GET['employer_id'] : 0;

if ($employer_id <= 0) {
    // Invalid employer ID, redirect to home
    header('Location: index.php');
    exit();
}

// This will handle the login redirect logic
$controller->viewCompanyPublic($employer_id);
