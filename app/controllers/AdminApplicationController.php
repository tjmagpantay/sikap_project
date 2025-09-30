<?php
require_once __DIR__ . '/../models/JobApplication.php';
require_once __DIR__ . '/../models/JobPost.php';

class AdminApplicationController
{
    private $jobApplicationModel;
    private $jobPostModel;

    public function __construct()
    {
        $this->jobApplicationModel = new JobApplication();
        $this->jobPostModel = new JobPost();
    }

    public function viewApplications()
    {
        // Check admin auth
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: ?page=admin-login');
            exit;
        }

        // Get filter parameters
        $statusFilter = $_GET['status'] ?? 'all';
        $searchQuery = $_GET['search'] ?? '';
        $jobFilter = $_GET['job'] ?? '';

        // Get applications data
        $applications = $this->jobApplicationModel->getAllApplicationsForAdmin($statusFilter, $searchQuery, $jobFilter);
        $stats = $this->jobApplicationModel->getApplicationStatsForAdmin();
        $jobs = $this->jobApplicationModel->getJobsForFilterDropdown();


        include __DIR__ . '/../views/admin/application.php';
    }

    public function viewApplicationSummary()
    {
        // Check admin auth
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: ?page=admin-login');
            exit;
        }

        $application_id = $_GET['application_id'] ?? null;
        if (!$application_id) {
            http_response_code(404);
            echo json_encode(['error' => 'Application not found']);
            exit;
        }

        $application = $this->jobApplicationModel->getDetailedApplicationForAdmin($application_id);
        if (!$application) {
            http_response_code(404);
            echo json_encode(['error' => 'Application not found']);
            exit;
        }

        // Return JSON for AJAX requests
        if (isset($_GET['ajax'])) {
            header('Content-Type: application/json');
            echo json_encode($application);
            exit;
        }

        include __DIR__ . '/../views/admin/view-application-summary.php';
    }
}
