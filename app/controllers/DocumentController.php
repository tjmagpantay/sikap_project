<?php
// filepath: c:\xampp\htdocs\sikap\app\controllers\DocumentController.php

class DocumentController
{
    private $jobseekerModel;
    private $jobPostModel;
    private $employerModel;

    public function __construct()
    {
        require_once __DIR__ . '/../models/User.php';
        require_once __DIR__ . '/../models/Jobseeker.php';
        require_once __DIR__ . '/../models/JobPost.php';
        require_once __DIR__ . '/../models/Employer.php';
        $this->jobseekerModel = new Jobseeker();
        $this->jobPostModel = new JobPost();
    }

    public function viewDocument()
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            http_response_code(403);
            die('Access denied - Please login');
        }

        $documentId = $_GET['doc_id'] ?? null;

        if (!$documentId) {
            http_response_code(400);
            die('Document ID required');
        }

        try {
            // Get document info from database
            $document = $this->getDocumentById($documentId);

            // Debug output
            error_log("DEBUG: Document ID: " . $documentId);
            error_log("DEBUG: Document data: " . json_encode($document));

            if (!$document) {
                http_response_code(404);
                die('Document not found in database');
            }

            // Security check: Only allow access to own documents or if user is employer/admin
            $canAccess = false;

            if ($_SESSION['role'] == User::ROLE_JOBSEEKER) {
                // Jobseekers can only access their own documents
                $jobseeker = $this->jobseekerModel->findByUserId($_SESSION['user_id']);
                error_log("DEBUG: Current jobseeker: " . json_encode($jobseeker));
                error_log("DEBUG: Document jobseeker_id: " . $document['jobseeker_id']);

                $canAccess = ($jobseeker && $jobseeker['jobseeker_id'] == $document['jobseeker_id']);
            } elseif ($_SESSION['role'] == User::ROLE_EMPLOYER || $_SESSION['role'] == User::ROLE_ADMIN) {
                // Employers and admins can access documents
                $canAccess = true;
            }

            if (!$canAccess) {
                http_response_code(403);
                die('Access denied - You can only view your own documents');
            }

            // Build file path - try multiple possible locations
            $filePath = $this->findDocumentPath($document['file_path']);

            // Debug file path search
            error_log("DEBUG: Original file_path: " . $document['file_path']);
            error_log("DEBUG: Found file_path: " . ($filePath ?: 'NOT FOUND'));

            if (!$filePath || !file_exists($filePath)) {
                http_response_code(404);
                die('File not found on server: ' . htmlspecialchars($document['file_path']));
            }

            // Get file extension for content type
            $fileExtension = strtolower(pathinfo($document['file_name'], PATHINFO_EXTENSION));
            $contentType = $this->getContentType($fileExtension);

            // Only allow viewing of certain file types
            $viewableTypes = ['pdf', 'jpg', 'jpeg', 'png', 'gif', 'txt'];
            if (!in_array($fileExtension, $viewableTypes)) {
                // Force download for non-viewable files
                header('Location: ?page=download-document&doc_id=' . urlencode($documentId) . '&download=1');
                exit;
            }

            // Clear any previous output
            if (ob_get_level()) {
                ob_end_clean();
            }

            // Serve the file for viewing
            header('Content-Type: ' . $contentType);
            header('Content-Disposition: inline; filename="' . basename($document['file_name']) . '"');
            header('Content-Length: ' . filesize($filePath));
            header('Cache-Control: private, max-age=3600');
            header('Pragma: public');

            readfile($filePath);
            exit;
        } catch (Exception $e) {
            error_log('Document view error: ' . $e->getMessage());
            http_response_code(500);
            die('Error viewing document: ' . htmlspecialchars($e->getMessage()));
        }
    }

    public function downloadDocument()
    {
        // Same logic as viewDocument but with download headers
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

        try {
            // Get document info from database
            $document = $this->getDocumentById($documentId);
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
                // Employers and admins can access documents
                $canAccess = true;
            }

            if (!$canAccess) {
                http_response_code(403);
                die('Access denied');
            }

            // Build file path
            $filePath = $this->findDocumentPath($document['file_path']);

            if (!$filePath || !file_exists($filePath)) {
                http_response_code(404);
                die('File not found');
            }

            // Get file extension for content type
            $fileExtension = strtolower(pathinfo($document['file_name'], PATHINFO_EXTENSION));
            $contentType = $this->getContentType($fileExtension);

            // Clear any previous output
            if (ob_get_level()) {
                ob_end_clean();
            }

            // Serve the file
            header('Content-Type: ' . $contentType);

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
        } catch (Exception $e) {
            error_log('Document download error: ' . $e->getMessage());
            http_response_code(500);
            die('Error downloading document');
        }
    }

    private function getDocumentById($documentId)
    {
        try {
            $config = require __DIR__ . '/../../config/sikap_db.php';
            $db = new PDO(
                "mysql:host={$config['db_host']};dbname={$config['db_name']}",
                $config['db_user'],
                $config['db_pass']
            );
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // FIXED: Use correct table name 'jobseeker' instead of 'jobseekers'
            $sql = "SELECT d.*, j.user_id 
                    FROM jobseeker_documents d 
                    JOIN jobseeker j ON d.jobseeker_id = j.jobseeker_id 
                    WHERE d.document_id = ?";

            $stmt = $db->prepare($sql);
            $stmt->execute([$documentId]);

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            error_log("DEBUG: SQL Query result: " . json_encode($result));

            return $result;
        } catch (Exception $e) {
            error_log('Database error in getDocumentById: ' . $e->getMessage());
            return false;
        }
    }

    private function findDocumentPath($filePath)
    {
        // Clean the file path
        $filePath = ltrim($filePath, '/\\');

        // Debug the original file path
        error_log("DEBUG: Searching for file: " . $filePath);

        // Try multiple possible paths based on your upload structure
        $possiblePaths = [
            // Direct path from root
            __DIR__ . '/../../' . $filePath,
            // From uploads folder (your actual structure)
            __DIR__ . '/../../uploads/documents/' . basename($filePath),
            // Public folder paths
            __DIR__ . '/../../public/' . $filePath,
            __DIR__ . '/../../public/uploads/' . basename($filePath),
            __DIR__ . '/../../public/uploads/documents/' . basename($filePath),
            __DIR__ . '/../../public/uploads/jobseeker_documents/' . basename($filePath),
            // Other possible locations
            __DIR__ . '/../../uploads/' . basename($filePath),
            __DIR__ . '/../../uploads/jobseeker_documents/' . basename($filePath)
        ];

        foreach ($possiblePaths as $path) {
            error_log("DEBUG: Checking path: " . $path);
            if (file_exists($path)) {
                error_log("DEBUG: Found file at: " . $path);
                return $path;
            }
        }

        error_log("DEBUG: File not found in any of the expected locations");
        return false;
    }

    public function downloadJobAttachment()
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: ?page=login-jobseeker&error=' . urlencode('Please login to download attachments'));
            exit;
        }

        $attachment_id = $_GET['attachment_id'] ?? null;
        $file_path = $_GET['file_path'] ?? null;

        if (!$attachment_id && !$file_path) {
            header('Location: ?page=browse-jobs&error=' . urlencode('Invalid download request'));
            exit;
        }

        try {
            // If we have attachment_id, get the file path from database
            if ($attachment_id) {
                $config = require __DIR__ . '/../../config/sikap_db.php';
                $db = new PDO(
                    "mysql:host={$config['db_host']};dbname={$config['db_name']}",
                    $config['db_user'],
                    $config['db_pass']
                );
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $sql = "SELECT file_path FROM job_post_attachments WHERE attachment_id = ?";
                $stmt = $db->prepare($sql);
                $stmt->execute([$attachment_id]);
                $attachment = $stmt->fetch(PDO::FETCH_ASSOC);

                if (!$attachment) {
                    header('Location: ?page=browse-jobs&error=' . urlencode('Attachment not found'));
                    exit;
                }
                $file_path = $attachment['file_path'];
            }

            // Clean the file path and construct full path
            $file_path = ltrim($file_path, '/');
            $full_path = $this->findFilePath($file_path);

            if (!$full_path) {
                header('Location: ?page=browse-jobs&error=' . urlencode('File not found on server'));
                exit;
            }

            // Get file info
            $file_name = basename($full_path);
            $file_extension = strtolower(pathinfo($full_path, PATHINFO_EXTENSION));
            $file_size = filesize($full_path);
            $content_type = $this->getContentType($file_extension);

            // Set headers for download
            header('Content-Type: ' . $content_type);
            header('Content-Disposition: attachment; filename="' . $file_name . '"');
            header('Content-Length: ' . $file_size);
            header('Cache-Control: private, max-age=0, must-revalidate');
            header('Pragma: public');

            // Clear any previous output
            if (ob_get_level()) {
                ob_end_clean();
            }

            // Read and output the file
            readfile($full_path);
            exit;
        } catch (Exception $e) {
            error_log('Download error: ' . $e->getMessage());
            header('Location: ?page=browse-jobs&error=' . urlencode('Download failed'));
            exit;
        }
    }

    public function viewJobAttachment()
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: ?page=login-jobseeker&error=' . urlencode('Please login to view attachments'));
            exit;
        }

        $attachment_id = $_GET['attachment_id'] ?? null;
        $file_path = $_GET['file_path'] ?? null;

        if (!$attachment_id && !$file_path) {
            http_response_code(400);
            die('Invalid view request');
        }

        try {
            // If we have attachment_id, get the file path from database
            if ($attachment_id) {
                $config = require __DIR__ . '/../../config/sikap_db.php';
                $db = new PDO(
                    "mysql:host={$config['db_host']};dbname={$config['db_name']}",
                    $config['db_user'],
                    $config['db_pass']
                );
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $sql = "SELECT file_path FROM job_post_attachments WHERE attachment_id = ?";
                $stmt = $db->prepare($sql);
                $stmt->execute([$attachment_id]);
                $attachment = $stmt->fetch(PDO::FETCH_ASSOC);

                if (!$attachment) {
                    http_response_code(404);
                    die('Attachment not found');
                }
                $file_path = $attachment['file_path'];
            }

            // Clean the file path and construct full path
            $file_path = ltrim($file_path, '/');
            $full_path = $this->findFilePath($file_path);

            if (!$full_path) {
                http_response_code(404);
                die('File not found on server');
            }

            // Get file info
            $file_name = basename($full_path);
            $file_extension = strtolower(pathinfo($full_path, PATHINFO_EXTENSION));
            $file_size = filesize($full_path);
            $content_type = $this->getContentType($file_extension);

            // Only allow viewing of certain file types
            $viewable_types = ['pdf', 'jpg', 'jpeg', 'png', 'gif', 'txt'];
            if (!in_array($file_extension, $viewable_types)) {
                header('Location: ?page=download-job-attachment&file_path=' . urlencode($_GET['file_path'] ?? '') . '&attachment_id=' . urlencode($_GET['attachment_id'] ?? ''));
                exit;
            }

            // Set headers for viewing
            header('Content-Type: ' . $content_type);
            header('Content-Disposition: inline; filename="' . $file_name . '"');
            header('Content-Length: ' . $file_size);
            header('Cache-Control: private, max-age=3600');

            // Clear any previous output
            if (ob_get_level()) {
                ob_end_clean();
            }

            // Read and output the file
            readfile($full_path);
            exit;
        } catch (Exception $e) {
            error_log('View error: ' . $e->getMessage());
            http_response_code(500);
            die('View failed');
        }
    }

    private function findFilePath($file_path)
    {
        // Try multiple possible paths
        $possible_paths = [
            __DIR__ . '/../../public/' . $file_path,
            __DIR__ . '/../../' . $file_path,
            __DIR__ . '/../../uploads/' . basename($file_path),
            __DIR__ . '/../../public/uploads/' . basename($file_path),
            __DIR__ . '/../../public/uploads/job_attachments/' . basename($file_path)
        ];

        foreach ($possible_paths as $path) {
            if (file_exists($path)) {
                return $path;
            }
        }

        return false;
    }

    private function getContentType($file_extension)
    {
        $content_types = [
            'pdf' => 'application/pdf',
            'doc' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'txt' => 'text/plain',
            'zip' => 'application/zip',
            'rar' => 'application/x-rar-compressed'
        ];

        return $content_types[$file_extension] ?? 'application/octet-stream';
    }

    
}
