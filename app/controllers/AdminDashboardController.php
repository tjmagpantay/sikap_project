<?php
require_once __DIR__ . '/../models/AdminDashboard.php';
require_once __DIR__ . '/../models/UserManagement.php';
require_once __DIR__ . '/../models/JobPost.php';
require_once __DIR__ . '/../models/Admin.php'; 
require_once __DIR__ . '/../models/Employer.php'; 

class AdminDashboardController
{
    private $adminDashboardModel;
    private $userManagementModel;
    private $jobPostModel;
    private $adminModel; 
    private $employerModel; 

    public function __construct()
    {
        $this->adminDashboardModel = new AdminDashboard();
        $this->userManagementModel = new UserManagement();
        $this->jobPostModel = new JobPost();
        $this->adminModel = new Admin(); 
        $this->employerModel = new Employer(); 
    }

    public function dashboard()
    {
        // Check if user is logged in and is admin
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: ?page=admin-login');
            exit;
        }

        // Get dashboard statistics from model
        $dashboardStats = $this->adminDashboardModel->getDashboardStats();
        $jobStatsChart = $this->adminDashboardModel->getJobStatsForChart();
        $jobCategoryChart = $this->adminDashboardModel->getJobCategoryStatsForChart();

        include __DIR__ . '/../views/admin/dashboard.php';
    }

    // Event Management Methods using your existing EventProgramController
    public function events()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: ?page=admin-login');
            exit;
        }

        // Use your existing EventProgram model directly
        require_once __DIR__ . '/../models/EventProgram.php';
        $eventModel = new EventProgram();
        $events = $eventModel->getAllEvents();

        include __DIR__ . '/../views/admin/dashboard.php';
    }

    public function eventCreate()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: ?page=admin-login');
            exit;
        }

        include __DIR__ . '/../views/admin/dashboard.php';
    }

    public function eventEdit()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: ?page=admin-login');
            exit;
        }

        // Load specific event data
        $eventId = $_GET['id'] ?? null;
        if (!$eventId) {
            header('Location: ?page=admin-events&error=Event not found');
            exit;
        }

        require_once __DIR__ . '/../models/EventProgram.php';
        $eventModel = new EventProgram();
        $event = $eventModel->getEventById($eventId);

        if (!$event) {
            header('Location: ?page=admin-events&error=Event not found');
            exit;
        }

        include __DIR__ . '/../views/admin/dashboard.php';
    }

    /**
     * Get dashboard data for AJAX requests
     */
    public function getDashboardData()
    {
        // Check if user is logged in and is admin
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }

        header('Content-Type: application/json');

        try {
            $dashboardStats = $this->adminDashboardModel->getDashboardStats();
            echo json_encode($dashboardStats);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to fetch dashboard data']);
        }
    }

    public function getRecentActivity()
    {
        // Check if user is logged in and is admin
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }

        header('Content-Type: application/json');

        try {
            $limit = $_GET['limit'] ?? 10;
            $recentActivity = $this->adminDashboardModel->getRecentActivity($limit);
            echo json_encode($recentActivity);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to fetch recent activity']);
        }
    }

    public function getTopJobCategories()
    {
        // Check if user is logged in and is admin
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }

        header('Content-Type: application/json');

        try {
            $limit = $_GET['limit'] ?? 5;
            $topCategories = $this->adminDashboardModel->getTopJobCategories($limit);
            echo json_encode($topCategories);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to fetch top job categories']);
        }
    }

    // FIXED: Add methods for user management with proper data loading
    public function jobseekerManagement()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: ?page=admin-login');
            exit;
        }

        // ✅ Load jobseekers data using UserManagement model
        try {
            $users = $this->userManagementModel->getUsersByType('jobseeker');
        } catch (Exception $e) {
            $users = [];
            error_log("Error fetching jobseekers: " . $e->getMessage());
        }

        include __DIR__ . '/../views/admin/dashboard.php';
    }

    public function employerManagement()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: ?page=admin-login');
            exit;
        }

        // ✅ Load employers data using UserManagement model
        try {
            $users = $this->userManagementModel->getUsersByType('employer');
        } catch (Exception $e) {
            $users = [];
            error_log("Error fetching employers: " . $e->getMessage());
        }

        include __DIR__ . '/../views/admin/dashboard.php';
    }

    public function jobpostManagement()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: ?page=admin-login');
            exit;
        }

        // ✅ Load jobs data using JobPost model
        try {
            // Get all jobs with employer and category information
            $jobs = $this->jobPostModel->getAllJobsForAdmin();

            // Calculate statistics
            $stats = $this->calculateJobStats($jobs);

            // Get filter parameters
            $searchQuery = $_GET['search'] ?? '';
            $statusFilter = $_GET['status'] ?? '';

            // Apply filters if provided
            if (!empty($searchQuery) || !empty($statusFilter)) {
                $jobs = $this->filterJobs($jobs, $searchQuery, $statusFilter);
            }
        } catch (Exception $e) {
            $jobs = [];
            $stats = [
                'total' => 0,
                'open' => 0,
                'paused' => 0,
                'draft' => 0,
                'closed' => 0,
                'employers' => 0
            ];
            $searchQuery = '';
            $statusFilter = '';
            error_log("Error fetching job posts: " . $e->getMessage());
        }

        include __DIR__ . '/../views/admin/dashboard.php';
    }

    /**
     * Calculate job statistics from the jobs array
     */
    private function calculateJobStats($jobs)
    {
        $stats = [
            'total' => count($jobs),
            'open' => 0,
            'paused' => 0,
            'draft' => 0,
            'closed' => 0,
            'employers' => 0
        ];

        $employers = [];

        foreach ($jobs as $job) {
            $status = $job['job_status'] ?? 'draft';

            switch ($status) {
                case 'open':
                    $stats['open']++;
                    break;
                case 'paused':
                    $stats['paused']++;
                    break;
                case 'closed':
                    $stats['closed']++;
                    break;
                case 'draft':
                    $stats['draft']++;
                    break;
            }

            // Count unique employers
            if (!empty($job['employer_id'])) {
                $employers[$job['employer_id']] = true;
            }
        }

        $stats['employers'] = count($employers);
        return $stats;
    }

    /**
     * Filter jobs based on search query and status
     */
    private function filterJobs($jobs, $searchQuery, $statusFilter)
    {
        return array_filter($jobs, function ($job) use ($searchQuery, $statusFilter) {
            // Status filter
            if (!empty($statusFilter) && $job['job_status'] !== $statusFilter) {
                return false;
            }

            // Search filter
            if (!empty($searchQuery)) {
                $searchLower = strtolower($searchQuery);
                $searchFields = [
                    $job['job_title'] ?? '',
                    $job['company_name'] ?? '',
                    $job['category_name'] ?? '',
                    $job['location'] ?? ''
                ];

                $found = false;
                foreach ($searchFields as $field) {
                    if (stripos($field, $searchQuery) !== false) {
                        $found = true;
                        break;
                    }
                }

                if (!$found) {
                    return false;
                }
            }

            return true;
        });
    }

    /**
     * Handle job status updates for admin
     */
    public function updateJobStatus()
    {
        // Clear any existing output
        while (ob_get_level()) {
            ob_end_clean();
        }

        // Set content type to JSON
        header('Content-Type: application/json');

        try {
            // Validate request method
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception('Invalid request method');
            }

            // Check admin authentication
            if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
                throw new Exception('Unauthorized access');
            }

            // Get and validate parameters
            $job_id = $_POST['job_id'] ?? null;
            $status = $_POST['status'] ?? null;

            if (!$job_id || !$status) {
                throw new Exception('Missing required parameters');
            }

            // Validate status
            $allowed_statuses = ['open', 'paused', 'closed', 'draft'];
            if (!in_array($status, $allowed_statuses)) {
                throw new Exception('Invalid status');
            }

            // Update job status
            $success = $this->jobPostModel->updateJobPost($job_id, ['job_status' => $status]);

            if (!$success) {
                throw new Exception('Failed to update job status');
            }

            // Send success response
            echo json_encode([
                'success' => true,
                'message' => 'Job status updated successfully',
                'new_status' => $status
            ]);
        } catch (Exception $e) {
            error_log("Job Status Update Error: " . $e->getMessage());
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
        exit;
    }

    /**
     * Handle job deletion for admin
     */
    public function deleteJob()
    {
        // Clear any existing output
        while (ob_get_level()) {
            ob_end_clean();
        }

        // Set content type to JSON
        header('Content-Type: application/json');

        try {
            // Validate request method
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception('Invalid request method');
            }

            // Check admin authentication
            if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
                throw new Exception('Unauthorized access');
            }

            // Get and validate parameters
            $job_id = $_POST['job_id'] ?? null;

            if (!$job_id) {
                throw new Exception('Missing job ID');
            }

            // Check if job has applications
            require_once __DIR__ . '/../models/JobApplication.php';
            $jobApplicationModel = new JobApplication();
            $hasApplications = $jobApplicationModel->jobHasApplications($job_id);

            if ($hasApplications) {
                throw new Exception('Cannot delete job with existing applications');
            }

            // Delete the job
            $success = $this->jobPostModel->deleteJob($job_id);

            if (!$success) {
                throw new Exception('Failed to delete job');
            }

            // Send success response
            echo json_encode([
                'success' => true,
                'message' => 'Job deleted successfully'
            ]);
        } catch (Exception $e) {
            error_log("Job Delete Error: " . $e->getMessage());
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
        exit;
    }

    /**
     * Handle status updates for users (moved from UserManagementController)
     * This method handles AJAX requests for updating user status
     */
    public function updateUserStatus()
    {
        // Clear any existing output
        while (ob_get_level()) {
            ob_end_clean();
        }

        // Set content type to JSON
        header('Content-Type: application/json');

        try {
            // Validate request method
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception('Invalid request method');
            }

            // Check admin authentication
            if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
                throw new Exception('Unauthorized access');
            }

            // Get and validate parameters
            $user_id = $_POST['user_id'] ?? null;
            $action = $_POST['action'] ?? null;
            $user_type = $_POST['user_type'] ?? null;

            error_log("Status Update Request - Parameters: " . json_encode([
                'user_id' => $user_id,
                'action' => $action,
                'user_type' => $user_type
            ]));

            if (!$user_id || !$action || !$user_type) {
                throw new Exception('Missing required parameters');
            }

            // Determine new status
            $new_status = $action === 'disable' ? 'disabled' : 'enabled';

            // Update status based on user type
            $success = false;
            if ($user_type === 'jobseeker') {
                error_log("Updating jobseeker status - ID: $user_id, New Status: $new_status");
                $success = $this->userManagementModel->updateJobseekerStatus($user_id, $new_status);
            } else {
                error_log("Updating employer status - ID: $user_id, Action: $action");
                $success = $this->userManagementModel->updateEmployerStatus($user_id, $action);
            }

            if (!$success) {
                throw new Exception('Failed to update status');
            }

            // Send success response
            echo json_encode([
                'success' => true,
                'message' => ucfirst($action) . ' successful',
                'new_status' => $new_status
            ]);
        } catch (Exception $e) {
            error_log("Status Update Error: " . $e->getMessage());
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
        exit;
    }

    /**
     * Handle accreditations management
     */
    public function accreditations()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: ?page=admin-login');
            exit;
        }

        // ✅ Load accreditations data using Admin model
        try {
            $pendingAccreditations = $this->adminModel->getPendingAccreditations();
            $allAccreditations = $this->adminModel->getAllAccreditations();

            // ✅ Set $accreditations for the view (this is what the view expects)
            $accreditations = $allAccreditations;

            // ✅ Set error/success messages
            $error = $_GET['error'] ?? '';
            $success = $_GET['success'] ?? '';

            // Debug logging
            error_log('=== ACCREDITATIONS DEBUG ===');
            error_log('Pending accreditations count: ' . count($pendingAccreditations));
            error_log('All accreditations count: ' . count($allAccreditations));
            error_log('First accreditation data: ' . json_encode($allAccreditations[0] ?? null));
            error_log('=== END DEBUG ===');

            // ✅ Calculate stats for the view
            $stats = [
                'total' => count($allAccreditations),
                'pending' => count(array_filter($allAccreditations, fn($a) => $a['status'] === 'pending')),
                'approved' => count(array_filter($allAccreditations, fn($a) => $a['status'] === 'approved')),
                'rejected' => count(array_filter($allAccreditations, fn($a) => $a['status'] === 'rejected')),
            ];
        } catch (Exception $e) {
            $pendingAccreditations = [];
            $allAccreditations = [];
            $accreditations = [];
            $stats = ['total' => 0, 'pending' => 0, 'approved' => 0, 'rejected' => 0];
            $error = 'Failed to load accreditations: ' . $e->getMessage();
            $success = '';
            error_log("Error fetching accreditations: " . $e->getMessage());
        }

        include __DIR__ . '/../views/admin/dashboard.php';
    }

    /**
     * Review specific accreditation
     */
    public function reviewAccreditation()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: ?page=admin-login');
            exit;
        }

        $accreditationId = $_GET['id'] ?? null;
        if (!$accreditationId) {
            header('Location: ?page=admin-accreditations&error=' . urlencode('Invalid accreditation ID'));
            exit;
        }

        // Use adminModel for accreditation details
        $accreditation = $this->adminModel->getAccreditationDetails($accreditationId);
        if (!$accreditation) {
            header('Location: ?page=admin-accreditations&error=' . urlencode('Accreditation not found'));
            exit;
        }

        // Get employer's documents using employerModel
        $documents = $this->employerModel->getDocuments($accreditation['employer_id']);

        include __DIR__ . '/../views/admin/dashboard.php';
    }

    /**
     * Process accreditation approval/rejection
     */
    public function processAccreditation()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: ?page=admin-login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?page=admin-accreditations');
            exit;
        }

        $accreditationId = $_POST['accreditation_id'] ?? null;
        $status = $_POST['status'] ?? null;
        $notes = $_POST['notes'] ?? '';

        if (!$accreditationId || !in_array($status, ['approved', 'rejected', 'pending'])) {
            header('Location: ?page=admin-accreditations&error=' . urlencode('Invalid request'));
            exit;
        }

        // Use adminModel for updating accreditation status
        $result = $this->adminModel->updateAccreditationStatus(
            $accreditationId,
            $status,
            $_SESSION['admin_id'], // Use admin_id from session
            $notes
        );

        if ($result) {
            $message = $status === 'approved' ? 'Employer verified successfully!' : ($status === 'rejected' ? 'Application rejected.' : 'Status updated.');
            header('Location: ?page=admin-accreditations&success=' . urlencode($message));
        } else {
            header('Location: ?page=admin-accreditations&error=' . urlencode('Failed to update status'));
        }
        exit;
    }

    /**
     * Applications management
     */
    public function applications()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: ?page=admin-login');
            exit;
        }

        try {
            require_once __DIR__ . '/../models/JobApplication.php';
            $jobApplicationModel = new JobApplication();

            // Get filters
            $statusFilter = $_GET['status'] ?? 'all';
            $searchQuery = $_GET['search'] ?? '';
            $jobFilter = $_GET['job'] ?? '';

            // Get applications using model method
            $applications = $jobApplicationModel->getAllApplicationsForAdmin($statusFilter, $searchQuery, $jobFilter);

            // Get application statistics using model method
            $stats = $jobApplicationModel->getApplicationStatsForAdmin();

            // Get all jobs for filter dropdown using model method
            $jobs = $jobApplicationModel->getJobsForFilterDropdown();

            // Set error/success messages
            $error = $_GET['error'] ?? '';
            $success = $_GET['success'] ?? '';
        } catch (Exception $e) {
            error_log('Error in application management: ' . $e->getMessage());
            $applications = [];
            $stats = ['total' => 0, 'pending' => 0, 'reviewed' => 0, 'shortlisted' => 0, 'rejected' => 0, 'hired' => 0];
            $jobs = [];
            $error = 'Failed to load applications: ' . $e->getMessage();
            $success = '';
        }

        include __DIR__ . '/../views/admin/dashboard.php';
    }

    /**
     * Reports management - displays analytics and reports dashboard
     */
    public function reports()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: ?page=admin-login');
            exit;
        }

        try {
            // Get comprehensive report data (using fallback data for now)
            $reportStats = $this->getReportStats();
            $monthlyData = $this->getMonthlyData();
            $categoryData = $this->getCategoryData();
            $applicationStatusData = $this->getApplicationStatusData();
            
            // Set error/success messages
            $error = $_GET['error'] ?? '';
            $success = $_GET['success'] ?? '';
        } catch (Exception $e) {
            error_log('Error in reports management: ' . $e->getMessage());
            
            // Set default empty data if there's an error
            $reportStats = $this->getDefaultReportStats();
            $monthlyData = $this->getDefaultMonthlyData();
            $categoryData = $this->getDefaultCategoryData();
            $applicationStatusData = $this->getDefaultApplicationStatusData();
            
            $error = 'Using sample data for demonstration purposes.';
            $success = '';
        }

        // Load the reports view instead of dashboard
        include __DIR__ . '/../views/admin/dashboard.php';
    }

    /**
     * Get comprehensive report statistics (using fallback data for now)
     */
    private function getReportStats()
    {
        try {
            // For now, we'll use sample data since some model methods don't exist yet
            // TODO: Implement actual data retrieval when models are updated
            
            /*
            // Future implementation when models have the required methods:
            $totalJobseekers = $this->userManagementModel->getUserCount('jobseeker');
            $totalEmployers = $this->userManagementModel->getUserCount('employer');
            $jobStats = $this->jobPostModel->getJobStatistics();
            
            require_once __DIR__ . '/../models/JobApplication.php';
            $jobApplicationModel = new JobApplication();
            $applicationStats = $jobApplicationModel->getApplicationStatsForAdmin();
            */
            
            return $this->getDefaultReportStats();
            
        } catch (Exception $e) {
            error_log('Error getting report stats: ' . $e->getMessage());
            return $this->getDefaultReportStats();
        }
    }

    /**
     * Get monthly activity data for charts (using sample data for now)
     */
    private function getMonthlyData()
    {
        try {
            // TODO: Implement actual data retrieval when models are updated
            return $this->getDefaultMonthlyData();
        } catch (Exception $e) {
            error_log('Error getting monthly data: ' . $e->getMessage());
            return $this->getDefaultMonthlyData();
        }
    }

    /**
     * Get job category distribution data (using sample data for now)
     */
    private function getCategoryData()
    {
        try {
            // TODO: Implement actual data retrieval when models are updated
            /*
            // Future implementation:
            $categoryData = $this->jobPostModel->getJobsByCategory();
            */
            
            return $this->getDefaultCategoryData();
        } catch (Exception $e) {
            error_log('Error getting category data: ' . $e->getMessage());
            return $this->getDefaultCategoryData();
        }
    }

    /**
     * Get application status distribution data (using sample data for now)
     */
    private function getApplicationStatusData()
    {
        try {
            // TODO: Implement actual data retrieval when models are updated
            /*
            // Future implementation:
            require_once __DIR__ . '/../models/JobApplication.php';
            $jobApplicationModel = new JobApplication();
            $statusData = $jobApplicationModel->getApplicationStatusDistribution();
            */
            
            return $this->getDefaultApplicationStatusData();
        } catch (Exception $e) {
            error_log('Error getting application status data: ' . $e->getMessage());
            return $this->getDefaultApplicationStatusData();
        }
    }

    // Default/Sample data methods
    private function getDefaultReportStats()
    {
        return [
            'total_users' => 1247,
            'total_employers' => 324,
            'total_jobseekers' => 923,
            'active_jobs' => 156,
            'closed_jobs' => 89,
            'total_applications' => 2891,
            'pending_applications' => 145,
            'approved_applications' => 2456,
            'rejected_applications' => 290
        ];
    }

    private function getDefaultMonthlyData()
    {
        return [
            'months' => ['Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'],
            'job_posts' => [45, 52, 38, 67, 49, 58],
            'applications' => [186, 305, 237, 173, 209, 214],
            'registrations' => [23, 31, 19, 42, 28, 35]
        ];
    }

    private function getDefaultCategoryData()
    {
        return [
            'categories' => ['Information Technology', 'Healthcare', 'Education', 'Engineering', 'Finance', 'Others'],
            'values' => [275, 200, 187, 173, 156, 90],
            'colors' => ['#092C4C', '#F3AF0E', '#3B82F6', '#10B981', '#F59E0B', '#6B7280']
        ];
    }

    private function getDefaultApplicationStatusData()
    {
        return [
            'labels' => ['Pending', 'Under Review', 'Shortlisted', 'Rejected', 'Hired'],
            'values' => [145, 89, 234, 290, 187],
            'colors' => ['#F59E0B', '#3B82F6', '#10B981', '#EF4444', '#8B5CF6']
        ];
    }

    // Remove the unused helper methods that were causing errors
    // These can be implemented later when the actual data methods are needed

    // ... rest of your existing methods ...
}
