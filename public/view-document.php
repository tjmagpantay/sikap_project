<?php
session_start();
require_once __DIR__ . '/../config/sikap_db.php';
require_once __DIR__ . '/../app/models/Jobseeker.php';

// Check if user is logged in and is a jobseeker
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 2) {
    http_response_code(403);
    die('Access denied');
}

// Get document ID from URL
if (!isset($_GET['doc_id']) || !is_numeric($_GET['doc_id'])) {
    http_response_code(400);
    die('Invalid document ID');
}

$document_id = (int)$_GET['doc_id'];

try {
    // Get document details from database
    $jobseekerModel = new Jobseeker();
    $document = $jobseekerModel->getDocumentById($document_id);

    if (!$document) {
        http_response_code(404);
        die('Document not found');
    }

    // Verify the document belongs to the current user
    $jobseeker = $jobseekerModel->findByUserId($_SESSION['user_id']);
    if (!$jobseeker || $document['jobseeker_id'] != $jobseeker['jobseeker_id']) {
        http_response_code(403);
        die('Access denied - Document does not belong to you');
    }

    // Build the full file path
    $filePath = __DIR__ . '/../' . $document['file_path'];

    // Check if file exists
    if (!file_exists($filePath)) {
        http_response_code(404);
        die('File not found on server');
    }

    // Set appropriate headers for PDF viewing
    header('Content-Type: application/pdf');
    header('Content-Disposition: inline; filename="' . basename($document['file_name']) . '"');
    header('Content-Length: ' . filesize($filePath));
    header('Cache-Control: private, max-age=0, must-revalidate');
    header('Pragma: public');

    // Output the file
    readfile($filePath);
    exit;
} catch (Exception $e) {
    error_log('Document viewer error: ' . $e->getMessage());
    http_response_code(500);
    die('Internal server error');
}
