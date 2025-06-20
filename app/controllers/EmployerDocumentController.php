<?php
// filepath: app/controllers/EmployerDocumentController.php

class EmployerDocumentController 
{
    private $employerModel;

    public function __construct() 
    {
        require_once __DIR__ . '/../models/User.php';
        require_once __DIR__ . '/../models/Employer.php';
        $this->employerModel = new Employer();
    }

    public function downloadDocument() 
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            http_response_code(403);
            die('Access denied');
        }

        $documentType = $_GET['type'] ?? null;
        $employerId = $_GET['employer_id'] ?? null;
        $isDownload = isset($_GET['download']) && $_GET['download'] == '1';
        
        if (!$documentType || !$employerId) {
            http_response_code(400);
            die('Document type and employer ID required');
        }

        // Security check: Only allow access to own documents or if user is admin
        $canAccess = false;
        
        if ($_SESSION['role'] == User::ROLE_EMPLOYER) {
            // Employers can only access their own documents
            $employer = $this->employerModel->findByUserId($_SESSION['user_id']);
            $canAccess = ($employer && $employer['employer_id'] == $employerId);
        } elseif ($_SESSION['role'] == User::ROLE_ADMIN) {
            // Admins can access all documents
            $canAccess = true;
        }

        if (!$canAccess) {
            http_response_code(403);
            die('Access denied');
        }

        // Get document path from database
        $documents = $this->employerModel->getDocuments($employerId);
        
        if (!isset($documents[$documentType])) {
            http_response_code(404);
            die('Document not found');
        }

        $documentPath = $documents[$documentType];
        
        // Build full file path
        $filePath = __DIR__ . '/../../' . $documentPath;
        
        if (!file_exists($filePath)) {
            http_response_code(404);
            die('File not found');
        }

        // Get document type label for filename
        $documentLabels = [
            'letter_of_intent' => 'Letter_of_Intent',
            'company_profile' => 'Company_Profile',
            'business_permit' => 'Business_Permit',
            'cert_of_no_pending_case' => 'Certificate_of_No_Pending_Case',
            'dole_registration' => 'DOLE_Registration',
            'cert_no_objection' => 'Certificate_of_No_Objection',
            'poea_reg' => 'POEA_Registration',
            'job_vaccancies_qual' => 'Job_Vacancies_Qualifications',
            'phil_jobnet_reg' => 'PhilJobNet_Registration'
        ];

        $filename = ($documentLabels[$documentType] ?? $documentType) . '.pdf';

        // Serve the file
        header('Content-Type: application/pdf');
        
        if ($isDownload) {
            // Force download
            header('Content-Disposition: attachment; filename="' . $filename . '"');
        } else {
            // View in browser
            header('Content-Disposition: inline; filename="' . $filename . '"');
        }
        
        header('Content-Length: ' . filesize($filePath));
        header('Cache-Control: private, max-age=0, must-revalidate');
        header('Pragma: public');

        readfile($filePath);
        exit;
    }
}