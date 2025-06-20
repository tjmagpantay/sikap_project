<?php
// filepath: app/controllers/DocumentController.php

class DocumentController 
{
    private $jobseekerModel;

    public function __construct() 
    {
        require_once __DIR__ . '/../models/User.php';
        require_once __DIR__ . '/../models/Jobseeker.php';
        $this->jobseekerModel = new Jobseeker();
    }

    public function downloadDocument() 
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            http_response_code(403);
            die('Access denied');
        }

        $documentId = $_GET['doc_id'] ?? null;
        $isDownload = isset($_GET['download']) && $_GET['download'] == '1';
        
        if (!$documentId) {
            http_response_code(400);
            die('Document ID required');
        }

        // Get document info from database
        $document = $this->jobseekerModel->getDocumentById($documentId);
        if (!$document) {
            http_response_code(404);
            die('Document not found');
        }

        // Security check: Only allow access to own documents or if user is employer/admin
        $canAccess = false;
        
        if ($_SESSION['role'] == User::ROLE_JOBSEEKER) {
            // Jobseekers can only access their own documents
            $jobseeker = $this->jobseekerModel->findByUserId($_SESSION['user_id']);
            $canAccess = ($jobseeker && $jobseeker['jobseeker_id'] == $document['jobseeker_id']);
        } elseif ($_SESSION['role'] == User::ROLE_EMPLOYER || $_SESSION['role'] == User::ROLE_ADMIN) {
            // Employers and admins can access documents (add more specific checks if needed)
            $canAccess = true;
        }

        if (!$canAccess) {
            http_response_code(403);
            die('Access denied');
        }

        // Build file path
        $filePath = __DIR__ . '/../../' . $document['file_path'];
        
        if (!file_exists($filePath)) {
            http_response_code(404);
            die('File not found');
        }

        // Serve the file
        header('Content-Type: application/pdf');
        
        if ($isDownload) {
            // Force download
            header('Content-Disposition: attachment; filename="' . basename($document['file_name']) . '"');
        } else {
            // View in browser
            header('Content-Disposition: inline; filename="' . basename($document['file_name']) . '"');
        }
        
        header('Content-Length: ' . filesize($filePath));
        header('Cache-Control: private, max-age=0, must-revalidate');
        header('Pragma: public');

        readfile($filePath);
        exit;
    }
}