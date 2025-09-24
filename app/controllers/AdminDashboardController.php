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
    public function viewJob()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: ?page=admin-login');
            exit;
        }

        $job_id = $_GET['id'] ?? null;
        if (!$job_id) {
            header('Location: ?page=admin-jobpost-management&error=' . urlencode('Job not found.'));
            exit;
        }

        // Load job data
        try {
            require_once __DIR__ . '/../models/JobPost.php';
            $jobPostModel = new JobPost();

            // Get job details
            $job = $jobPostModel->getJobById($job_id);
            if (!$job) {
                header('Location: ?page=admin-jobpost-management&error=' . urlencode('Job not found.'));
                exit;
            }

            // Get additional job data
            $job['skills'] = $jobPostModel->getJobSkills($job_id) ?? [];
            $job['attachments'] = $jobPostModel->getJobAttachments($job_id) ?? [];
            $job['screening_questions'] = $jobPostModel->getScreeningQuestions($job_id) ?? [];

            // Get employer/company info
            $sql = "SELECT 
                    COALESCE(eb.business_name, e.company_name, CONCAT(e.first_name, ' ', e.last_name)) as company_name,
                    eb.business_logo,
                    CONCAT(e.first_name, ' ', e.last_name) as employer_name
                FROM job_post jp
                JOIN employer e ON jp.employer_id = e.employer_id
                LEFT JOIN employers_business eb ON e.employer_id = eb.employer_id
                WHERE jp.job_id = ?";

            $stmt = $jobPostModel->getDatabase()->prepare($sql);
            $stmt->execute([$job_id]);
            $company = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($company) {
                $job['company_name'] = $company['company_name'];
                $job['business_logo'] = $company['business_logo'];
                $job['employer_name'] = $company['employer_name'];
            }

            // ✅ FIXED: Get application statistics with proper column names
            $statsQuery = "SELECT 
                        COUNT(*) as total_applications,
                        SUM(CASE WHEN application_status = 'pending' THEN 1 ELSE 0 END) as pending,
                        SUM(CASE WHEN application_status = 'reviewed' THEN 1 ELSE 0 END) as reviewed,
                        SUM(CASE WHEN application_status = 'shortlisted' THEN 1 ELSE 0 END) as shortlisted,
                        SUM(CASE WHEN application_status = 'hired' THEN 1 ELSE 0 END) as hired,
                        SUM(CASE WHEN application_status = 'rejected' THEN 1 ELSE 0 END) as rejected
                       FROM job_application 
                       WHERE job_id = ?";

            $stmt = $jobPostModel->getDatabase()->prepare($statsQuery);
            $stmt->execute([$job_id]);
            $applicationStats = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$applicationStats) {
                $applicationStats = [
                    'total_applications' => 0,
                    'pending' => 0,
                    'reviewed' => 0,
                    'shortlisted' => 0,
                    'hired' => 0,
                    'rejected' => 0
                ];
            }

            // Get job category name if not already included
            if (empty($job['category_name']) && !empty($job['job_category_id'])) {
                $catQuery = "SELECT name FROM job_categories WHERE category_id = ?";
                $stmt = $jobPostModel->getDatabase()->prepare($catQuery);
                $stmt->execute([$job['job_category_id']]);
                $category = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($category) {
                    $job['category_name'] = $category['name'];
                }
            }

            // ✅ Set error/success messages
            $error = $_GET['error'] ?? '';
            $success = $_GET['success'] ?? '';
        } catch (Exception $e) {
            error_log('Error loading job details: ' . $e->getMessage());
            header('Location: ?page=admin-jobpost-management&error=' . urlencode('Failed to load job details.'));
            exit;
        }

        // ✅ FIXED: Use dashboard.php layout (same as other admin pages)
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
        if (!$accreditationId || !is_numeric($accreditationId)) {
            header('Location: ?page=admin-accreditations&error=' . urlencode('Invalid accreditation ID'));
            exit;
        }

        try {
            // Use adminModel for accreditation details
            $accreditation = $this->adminModel->getAccreditationDetails($accreditationId);
            if (!$accreditation) {
                header('Location: ?page=admin-accreditations&error=' . urlencode('Accreditation not found'));
                exit;
            }

            // Get employer's documents using employerModel
            $documents = $this->employerModel->getDocuments($accreditation['employer_id']);
            if (!$documents) {
                $documents = []; // Ensure it's an array
            }

            // Set error/success messages
            $error = $_GET['error'] ?? '';
            $success = $_GET['success'] ?? '';

            // ✅ FIXED: Use dashboard layout instead of standalone page
            include __DIR__ . '/../views/admin/dashboard.php';
        } catch (Exception $e) {
            error_log('Error loading accreditation details: ' . $e->getMessage());
            header('Location: ?page=admin-accreditations&error=' . urlencode('Failed to load accreditation details'));
            exit;
        }
    }

    /**
     * Process accreditation approval/rejection
     */

    public function processAccreditation()
    {

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?page=admin-accreditations');
            exit;
        }

        $accreditation_id = $_POST['accreditation_id'] ?? '';
        $status = $_POST['status'] ?? '';
        $notes = $_POST['notes'] ?? '';
        $admin_id = $_SESSION['admin_id'] ?? null;

        if (empty($accreditation_id) || empty($status)) {
            $_SESSION['error'] = 'Missing required information';
            header("Location: ?page=admin-review-accreditation&id={$accreditation_id}");
            exit;
        }

        // Validate status
        $validStatuses = ['pending', 'approved', 'rejected'];
        if (!in_array($status, $validStatuses)) {
            $_SESSION['error'] = 'Invalid status';
            header("Location: ?page=admin-review-accreditation&id={$accreditation_id}");
            exit;
        }

        try {
            // ✅ FIXED: Update both accreditation and employer status
            $result = $this->adminModel->updateAccreditationStatus($accreditation_id, $status, $admin_id, $notes);

            if ($result) {
                // ✅ NEW: Also update the employer status to match
                $syncResult = $this->syncEmployerStatus($accreditation_id, $status);

                $statusText = ucfirst($status);

                if ($syncResult) {
                    $_SESSION['success'] = "Accreditation status successfully updated to {$statusText}. Employer status has been synchronized.";
                } else {
                    $_SESSION['success'] = "Accreditation status updated to {$statusText}, but employer status sync failed.";
                }
            } else {
                $_SESSION['error'] = 'Failed to update accreditation status. Please try again.';
            }
        } catch (Exception $e) {
            error_log("Error updating accreditation status: " . $e->getMessage());
            $_SESSION['error'] = 'An error occurred while updating the status. Please try again.';
        }

        // ✅ FIXED: Redirect back to the same review page instead of accreditations list
        header("Location: ?page=admin-review-accreditation&id={$accreditation_id}");
        exit;
    }

    // ✅ NEW METHOD: Sync employer status with accreditation status
    private function syncEmployerStatus($accreditation_id, $accreditation_status)
    {
        try {
            // Get the employer_id from accreditation
            $accreditation = $this->adminModel->getAccreditationDetails($accreditation_id);
            if (!$accreditation) {
                return false;
            }

            $employer_id = $accreditation['employer_id'];

            // Map accreditation status to employer status
            $employerStatus = $this->mapAccreditationToEmployerStatus($accreditation_status);

            // Update employer status
            return $this->employerModel->updateEmployerStatus($employer_id, $employerStatus);
        } catch (Exception $e) {
            error_log("Error syncing employer status: " . $e->getMessage());
            return false;
        }
    }

    // ✅ NEW METHOD: Map statuses between the two systems
    private function mapAccreditationToEmployerStatus($accreditation_status)
    {
        switch ($accreditation_status) {
            case 'approved':
                return 'verified';  // approved accreditation = verified employer
            case 'rejected':
                return 'rejected';  // same as accreditation
            case 'pending':
                return 'pending_verification'; // pending accreditation = pending verification
            default:
                return 'incomplete';
        }
    }

    // ...rest of existing code...
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
     * Get application status distribution data (using sample data for now)
     */


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

    private function getDefaultCategoryData()
    {
        return [
            'categories' => ['Information Technology', 'Healthcare', 'Education', 'Engineering', 'Finance', 'Others'],
            'values' => [275, 200, 187, 173, 156, 90],
            'colors' => ['#092C4C', '#F3AF0E', '#3B82F6', '#10B981', '#F59E0B', '#6B7280']
        ];
    }


    private function getReportStats()
    {
        try {
            // Get real statistics from the model
            return $this->adminDashboardModel->getReportStatistics();
        } catch (Exception $e) {
            error_log('Error getting report stats: ' . $e->getMessage());
            return [
                'total_users' => 0,
                'total_employers' => 0,
                'total_jobseekers' => 0,
                'active_jobs' => 0,
                'total_applications' => 0,
                'pending_applications' => 0,
                'total_events' => 0
            ];
        }
    }


    private function getCategoryData()
    {
        try {
            // Initialize job categories if table is empty
            $this->adminDashboardModel->initializeJobCategories();

            // ✅ FIXED: Use the new method that gets ALL categories (like main-board approach)
            $data = $this->adminDashboardModel->getAllJobCategoriesDistribution();

            // ✅ DEBUG: Log the data being returned
            error_log('=== CATEGORY DATA DEBUG IN CONTROLLER ===');
            error_log('Data returned from model: ' . json_encode($data));
            error_log('Categories count: ' . count($data['categories'] ?? []));
            error_log('Values count: ' . count($data['values'] ?? []));
            error_log('Colors count: ' . count($data['colors'] ?? []));
            error_log('=== END CATEGORY DEBUG ===');

            return $data;
        } catch (Exception $e) {
            error_log('Error getting category data: ' . $e->getMessage());
            return [
                'categories' => ['IT', 'Healthcare', 'Education', 'Engineering', 'Finance', 'Marketing', 'Construction', 'Others'],
                'values' => [0, 0, 0, 0, 0, 0, 0, 0],
                'colors' => ['#092C4C', '#F3AF0E', '#10B981', '#EF4444', '#3B82F6', '#6B7280', '#8B5CF6', '#F59E0B']
            ];
        }
    }

    private function getApplicationStatusData()
    {
        try {
            // ✅ Use the new model method to get real data
            $data = $this->adminDashboardModel->getApplicationStatusDistribution();

            error_log('=== APPLICATION STATUS DATA DEBUG ===');
            error_log('Application status data from model: ' . json_encode($data));
            error_log('Labels: ' . json_encode($data['labels'] ?? []));
            error_log('Values: ' . json_encode($data['values'] ?? []));
            error_log('Total applications: ' . ($data['total'] ?? 0));
            error_log('=== END APPLICATION STATUS DEBUG ===');

            return $data;
        } catch (Exception $e) {
            error_log('Error getting application status data: ' . $e->getMessage());
            return $this->getDefaultApplicationStatusData();
        }
    }

    /**
     * ✅ UPDATED: Enhanced default application status data
     */
    private function getDefaultApplicationStatusData()
    {
        return [
            'labels' => ['Pending', 'Under Review', 'Shortlisted', 'Rejected', 'Hired'],
            'values' => [0, 0, 0, 0, 0],
            'colors' => ['#F59E0B', '#3B82F6', '#10B981', '#EF4444', '#8B5CF6'],
            'total' => 0
        ];
    }


    private function getUserGrowthData()
    {
        error_log('=== getUserGrowthData METHOD CALLED ===');

        try {
            // ✅ Use the AdminDashboard model method (same approach as main-board)
            $realData = $this->adminDashboardModel->getUserGrowthTrends();

            error_log('=== REAL DATA FROM MODEL ===');
            error_log('Real user growth data: ' . json_encode($realData));

            // ✅ Check if we have valid data, otherwise use fallback
            if (!empty($realData['months']) && !empty($realData['jobseekers']) && !empty($realData['employers'])) {
                return $realData;
            }

            // ✅ Fallback data (same as main-board approach)
            $fallbackData = [
                'months' => ['Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'],
                'jobseekers' => [5, 8, 12, 15, 18, 22],
                'employers' => [2, 3, 4, 5, 6, 7]
            ];

            error_log('=== USING FALLBACK DATA ===');
            error_log('Fallback user growth data: ' . json_encode($fallbackData));

            return $fallbackData;
        } catch (Exception $e) {
            error_log('Error getting user growth data: ' . $e->getMessage());
            return [
                'months' => ['Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'],
                'jobseekers' => [0, 0, 0, 0, 0, 0],
                'employers' => [0, 0, 0, 0, 0, 0]
            ];
        }
    }

    private function getMonthlyData()
    {
        try {
            // Get real monthly activity trends from the model
            return $this->adminDashboardModel->getMonthlyActivityTrends();
        } catch (Exception $e) {
            error_log('Error getting monthly data: ' . $e->getMessage());

            // Return fallback data with current months
            $fallbackMonths = [];
            for ($i = 5; $i >= 0; $i--) {
                $fallbackMonths[] = date('M', strtotime("-$i months"));
            }

            return [
                'months' => $fallbackMonths,
                'job_posts' => [0, 0, 0, 0, 0, 0],
                'applications' => [0, 0, 0, 0, 0, 0],
                'registrations' => [0, 0, 0, 0, 0, 0]
            ];
        }
    }

    // Also update the getDefaultMonthlyData method to use current months:
    private function getDefaultMonthlyData()
    {
        $months = [];
        for ($i = 5; $i >= 0; $i--) {
            $months[] = date('M', strtotime("-$i months"));
        }

        return [
            'months' => $months,
            'job_posts' => [0, 0, 0, 0, 0, 0],
            'applications' => [0, 0, 0, 0, 0, 0],
            'registrations' => [0, 0, 0, 0, 0, 0]
        ];
    }


    /**
     * ✅ UPDATED: Simplified allReports method using same approach as main-board
     */
    public function allReports()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: ?page=admin-login');
            exit;
        }

        try {
            // ✅ Get report statistics using model methods
            $reportStats = $this->adminDashboardModel->getReportStatistics();

            // ✅ Get category data using the SAME approach as main-board
            $categoryData = $this->getCategoryData();

            // ✅ Get monthly data using model method
            $monthlyData = $this->adminDashboardModel->getMonthlyActivityTrends();

            // ✅ Get user growth data using model method
            $userGrowthData = $this->getUserGrowthData();

            // ✅ FIXED: Get real application status data
            $applicationStatusData = $this->getApplicationStatusData();

            // ✅ OPTIONAL: Get detailed application statistics for additional insights
            $applicationStats = $this->adminDashboardModel->getApplicationStatistics();

            // Set error/success messages
            $error = $_GET['error'] ?? '';
            $success = $_GET['success'] ?? '';

            // ✅ DEBUG: Log final data before view
            error_log('=== FINAL ALLREPORTS DATA ===');
            error_log('Report stats: ' . json_encode($reportStats));
            error_log('Category data: ' . json_encode($categoryData));
            error_log('Monthly data: ' . json_encode($monthlyData));
            error_log('User growth data: ' . json_encode($userGrowthData));
            error_log('Application status data: ' . json_encode($applicationStatusData));
            error_log('Application statistics: ' . json_encode($applicationStats));
            error_log('=== END FINAL DATA ===');
        } catch (Exception $e) {
            error_log('Error in allReports: ' . $e->getMessage());
            $error = 'Failed to load report data.';

            // Set fallback data
            $reportStats = $this->getDefaultReportStats();
            $categoryData = [
                'categories' => ['IT', 'Healthcare', 'Education', 'Engineering', 'Finance', 'Marketing', 'Construction', 'Others'],
                'values' => [0, 0, 0, 0, 0, 0, 0, 0],
                'colors' => ['#092C4C', '#F3AF0E', '#10B981', '#EF4444', '#3B82F6', '#6B7280', '#8B5CF6', '#B0AEAE']
            ];
            $monthlyData = $this->getDefaultMonthlyData();
            $userGrowthData = [
                'months' => ['Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'],
                'jobseekers' => [5, 8, 12, 15, 18, 22],
                'employers' => [2, 3, 4, 5, 6, 7]
            ];
            $applicationStatusData = $this->getDefaultApplicationStatusData();
            $applicationStats = ['overall' => ['total_applications' => 0], 'monthly_trends' => []];
            $success = '';
        }

        include __DIR__ . '/../views/admin/dashboard.php';
    }
    public function notifications()
    {
        try {
            // Initialize notification service
            require_once __DIR__ . '/../services/NotificationService.php';
            require_once __DIR__ . '/../../config/sikap_db.php';

            $config = require __DIR__ . '/../../config/sikap_db.php';
            $pdo = new PDO(
                "mysql:host={$config['db_host']};dbname={$config['db_name']}",
                $config['db_user'],
                $config['db_pass']
            );
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $notificationService = new NotificationService($pdo);

            // Handle POST requests (mark as read)
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $this->handleNotificationActions($notificationService);
                return;
            }

            // Get pagination parameters
            $currentPage = max(1, (int)($_GET['p'] ?? 1));
            $limit = 10;
            $offset = ($currentPage - 1) * $limit;

            // Get notifications
            $notifications = $notificationService->getUserNotifications($_SESSION['user_id'], $limit + 1, $offset);

            // Check if there are more pages
            $hasNextPage = count($notifications) > $limit;
            if ($hasNextPage) {
                array_pop($notifications); // Remove the extra item
            }

            // Get unread count
            $unreadCount = $notificationService->getUnreadCount($_SESSION['user_id']);

            // Prepare data for the view
            $data = [
                'notifications' => $notifications,
                'unreadCount' => $unreadCount,
                'currentPage' => $currentPage,
                'hasNextPage' => $hasNextPage
            ];

            error_log('🔍 Admin Notifications Debug:');
            error_log('   - User ID: ' . $_SESSION['user_id']);
            error_log('   - Notifications count: ' . count($notifications));
            error_log('   - Unread count: ' . $unreadCount);
            error_log('   - Current page: ' . $currentPage);

            // Load the dashboard with notifications content
            include __DIR__ . '/../views/admin/dashboard.php';
        } catch (Exception $e) {
            error_log('❌ Error in admin notifications: ' . $e->getMessage());

            // Fallback: Load with empty data
            $data = [
                'notifications' => [],
                'unreadCount' => 0,
                'currentPage' => 1,
                'hasNextPage' => false
            ];

            include __DIR__ . '/../views/admin/dashboard.php';
        }
    }

    private function handleNotificationActions($notificationService)
    {
        $action = $_POST['action'] ?? '';

        if ($action === 'mark_as_read' && isset($_POST['notification_id'])) {
            $notificationId = (int)$_POST['notification_id'];
            $result = $notificationService->markAsRead($notificationId, $_SESSION['user_id']);

            if ($result) {
                header('Location: ?page=notifications-admin&success=' . urlencode('Notification marked as read'));
            } else {
                header('Location: ?page=notifications-admin&error=' . urlencode('Failed to mark notification as read'));
            }
        } elseif ($action === 'mark_all_as_read') {
            $result = $notificationService->markAllAsRead($_SESSION['user_id']);

            if ($result) {
                header('Location: ?page=notifications-admin&success=' . urlencode('All notifications marked as read'));
            } else {
                header('Location: ?page=notifications-admin&error=' . urlencode('Failed to mark all notifications as read'));
            }
        } else {
            header('Location: ?page=notifications-admin&error=' . urlencode('Invalid action'));
        }

        exit;
    }
}
