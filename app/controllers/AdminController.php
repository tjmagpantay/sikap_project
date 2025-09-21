<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Admin.php';
require_once __DIR__ . '/../models/Employer.php';
require_once __DIR__ . '/../models/JobPost.php';

class AdminController
{
    private $adminModel;
    private $employerModel;
    private $jobPostModel;

    public function __construct()
    {
        $this->adminModel = new Admin();
        $this->employerModel = new Employer();
        $this->jobPostModel = new JobPost();
    }

    public function login()
    {
        if (!isset($_SESSION['login_attempts'])) {
            $_SESSION['login_attempts'] = 0;
            $_SESSION['last_attempt_time'] = null;
        }

        $popupMessage = '';
        $popupType = 'error'; // default modal type

        // Check if locked
        if ($_SESSION['login_attempts'] >= 5) {
            $timeSinceLast = time() - $_SESSION['last_attempt_time'];
            if ($timeSinceLast < 300) { // 5 minutes
                $remaining = ceil((300 - $timeSinceLast) / 60);
                $popupMessage = "Too many failed attempts. Please try again in {$remaining} minute(s).";
                include __DIR__ . '/../views/admin/login-admin.php';
                echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Access Blocked',
                    text: '" . addslashes($popupMessage) . "'
                });
            </script>";
                return;
            } else {
                $_SESSION['login_attempts'] = 0; // reset after cooldown
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            if (empty($email) || empty($password)) {
                $popupMessage = 'Please fill in all fields.';
            } else {
                $admin = $this->adminModel->authenticate($email, $password);

                if ($admin) {
                    $_SESSION['login_attempts'] = 0;
                    $_SESSION['user_id'] = $admin['user_id'];
                    $_SESSION['admin_id'] = $admin['admin_id'];
                    $_SESSION['role'] = 'admin';
                    $_SESSION['admin_name'] = $admin['admin_name'];

                    header('Location: ?page=admin-dashboard');
                    exit;
                } else {
                    $_SESSION['login_attempts']++;
                    $_SESSION['last_attempt_time'] = time();

                    $remainingAttempts = 5 - $_SESSION['login_attempts'];
                    if ($remainingAttempts <= 0) {
                        $popupMessage = 'Too many failed attempts. Please wait 5 minutes before trying again.';
                    } else {
                        $popupMessage = "Invalid credentials. You have {$remainingAttempts} attempt(s) left.";
                    }
                }
            }
        }

        include __DIR__ . '/../views/admin/login-admin.php';

        if (!empty($popupMessage)) {
            echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Login Failed',
                text: '" . addslashes($popupMessage) . "',
                confirmButtonColor: '#2563eb'
            });
        </script>";
        }
    }



    public function dashboard()
    {
        // Debug logging
        error_log("Dashboard access - Session: " . print_r($_SESSION, true));

        // Changed from User::ROLE_ADMIN to 'admin'
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            error_log("Access denied - redirecting to login");
            header('Location: ?page=admin-login');
            exit;
        }

        include __DIR__ . '/../views/admin/dashboard.php';
    }
    
    public function accreditations()
    {
        // Change from User::ROLE_ADMIN to 'admin' to match your login method
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: ?page=admin-login');
            exit;
        }

        // Use adminModel instead of employerModel for accreditation methods
        $pendingAccreditations = $this->adminModel->getPendingAccreditations();
        $allAccreditations = $this->adminModel->getAllAccreditations();

        // Fix: Set $accreditations for the view (this is what the view expects)
        $accreditations = $allAccreditations;

        // Set error/success messages
        $error = $_GET['error'] ?? '';
        $success = $_GET['success'] ?? '';

        // Debug logging
        error_log('=== ACCREDITATIONS DEBUG ===');
        error_log('Pending accreditations count: ' . count($pendingAccreditations));
        error_log('All accreditations count: ' . count($allAccreditations));
        error_log('Pending data: ' . print_r($pendingAccreditations, true));
        error_log('All data: ' . print_r($allAccreditations, true));
        error_log('=== END DEBUG ===');

        include __DIR__ . '/../views/admin/accreditations.php';
    }

    public function reviewAccreditation()
    {
        // Change from User::ROLE_ADMIN to 'admin'
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

        include __DIR__ . '/../views/admin/review-accreditation.php';
    }

    public function processAccreditation()
    {
        // Change from User::ROLE_ADMIN to 'admin'
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
            $_SESSION['admin_id'], // Use admin_id instead of user_id
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

    public function jobPostManagement()
    {
        // Check admin authentication
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: ?page=admin-login');
            exit;
        }

        // Get all jobs with employer information
        $allJobs = $this->jobPostModel->getAllJobs();

        // Get filter parameters
        $statusFilter = $_GET['status'] ?? 'all';
        $searchQuery = $_GET['search'] ?? '';

        // Filter jobs based on parameters
        $jobs = $allJobs;
        if ($statusFilter !== 'all') {
            $jobs = array_filter($jobs, function ($job) use ($statusFilter) {
                return $job['job_status'] === $statusFilter;
            });
        }

        if (!empty($searchQuery)) {
            $jobs = array_filter($jobs, function ($job) use ($searchQuery) {
                $searchFields = [
                    $job['job_title'] ?? '',
                    $job['company_name'] ?? '',
                    $job['category_name'] ?? '',
                    $job['location'] ?? ''
                ];
                $searchText = implode(' ', $searchFields);
                return stripos($searchText, $searchQuery) !== false;
            });
        }

        // Calculate statistics
        $stats = [
            'total' => count($allJobs),
            'open' => count(array_filter($allJobs, fn($j) => $j['job_status'] === 'open')),
            'closed' => count(array_filter($allJobs, fn($j) => $j['job_status'] === 'closed')),
            'draft' => count(array_filter($allJobs, fn($j) => $j['job_status'] === 'draft')),
            'paused' => count(array_filter($allJobs, fn($j) => $j['job_status'] === 'paused')),
        ];

        // Get messages
        $error = $_GET['error'] ?? '';
        $success = $_GET['success'] ?? '';

        include __DIR__ . '/../views/admin/jobpost-management.php';
    }

    public function viewJob()
    {
        // Check admin authentication
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: ?page=admin-login');
            exit;
        }

        $job_id = $_GET['id'] ?? null;
        if (!$job_id) {
            header('Location: ?page=admin-jobpost-management&error=' . urlencode('Invalid job ID'));
            exit;
        }

        // Get job details with full information
        $job = $this->jobPostModel->getFullJobData($job_id);
        if (!$job) {
            header('Location: ?page=admin-jobpost-management&error=' . urlencode('Job not found'));
            exit;
        }

        // Get job attachments
        $attachments = $this->jobPostModel->getJobAttachments($job_id);

        // Get screening questions
        $screeningQuestions = $this->jobPostModel->getScreeningQuestions($job_id);

        // Get application statistics
        $applicationStats = $this->getJobApplicationStats($job_id);

        include __DIR__ . '/../views/admin/view-job.php';
    }

    public function toggleJobStatus()
    {
        // Check admin authentication
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: ?page=admin-login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?page=admin-jobpost-management');
            exit;
        }

        $job_id = $_POST['job_id'] ?? null;
        $new_status = $_POST['status'] ?? null;

        if (!$job_id || !$new_status) {
            header('Location: ?page=admin-jobpost-management&error=' . urlencode('Invalid request'));
            exit;
        }

        // Validate status
        $allowed_statuses = ['open', 'closed', 'paused', 'draft'];
        if (!in_array($new_status, $allowed_statuses)) {
            header('Location: ?page=admin-jobpost-management&error=' . urlencode('Invalid status'));
            exit;
        }

        // Update job status
        $result = $this->jobPostModel->updateJobPost($job_id, ['job_status' => $new_status]);

        if ($result) {
            $message = "Job status updated to " . ucfirst($new_status) . " successfully!";
            header('Location: ?page=admin-jobpost-management&success=' . urlencode($message));
        } else {
            header('Location: ?page=admin-jobpost-management&error=' . urlencode('Failed to update job status'));
        }
        exit;
    }

    public function deleteJob()
    {
        // Check admin authentication
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: ?page=admin-login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?page=admin-jobpost-management');
            exit;
        }

        $job_id = $_POST['job_id'] ?? null;
        if (!$job_id) {
            header('Location: ?page=admin-jobpost-management&error=' . urlencode('Invalid job ID'));
            exit;
        }

        // Delete the job
        $result = $this->jobPostModel->deleteJob($job_id);

        if ($result) {
            header('Location: ?page=admin-jobpost-management&success=' . urlencode('Job deleted successfully!'));
        } else {
            header('Location: ?page=admin-jobpost-management&error=' . urlencode('Failed to delete job'));
        }
        exit;
    }

    private function getJobApplicationStats($job_id)
    {
        try {
            require_once __DIR__ . '/../models/JobApplication.php';
            $jobApplicationModel = new JobApplication();
            return $jobApplicationModel->getApplicationStatsForAdmin($job_id);
        } catch (Exception $e) {
            error_log('Error getting job application stats: ' . $e->getMessage());
            return [
                'total_applications' => 0,
                'pending' => 0,
                'reviewed' => 0,
                'shortlisted' => 0,
                'rejected' => 0,
                'hired' => 0
            ];
        }
    }

    public function applicationManagement()
    {
        // Check admin authentication
        if (!$this->isAdminLoggedIn()) {
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

            // DEBUG: Log the filters
            error_log("DEBUG ApplicationManagement - Filters: status=$statusFilter, search=$searchQuery, job=$jobFilter");

            // Get applications using model method
            $applications = $jobApplicationModel->getAllApplicationsForAdmin($statusFilter, $searchQuery, $jobFilter);

            // DEBUG: Log the applications data
            error_log("DEBUG ApplicationManagement - Found " . count($applications) . " applications");
            error_log("DEBUG ApplicationManagement - Applications data: " . json_encode($applications));

            // Get application statistics using model method
            $stats = $jobApplicationModel->getApplicationStatsForAdmin();

            // DEBUG: Log the stats
            error_log("DEBUG ApplicationManagement - Stats: " . json_encode($stats));

            // Get all jobs for filter dropdown using model method
            $jobs = $jobApplicationModel->getJobsForFilterDropdown();

            // DEBUG: Log the jobs
            error_log("DEBUG ApplicationManagement - Jobs for filter: " . count($jobs) . " jobs");

            // Set error/success messages
            $error = $_GET['error'] ?? '';
            $success = $_GET['success'] ?? '';

            // DEBUG: Final check before loading view
            error_log("DEBUG ApplicationManagement - About to load view with " . count($applications) . " applications");

            require __DIR__ . '/../views/admin/application.php';
        } catch (Exception $e) {
            error_log('Error in application management: ' . $e->getMessage());
            $error = 'Failed to load applications: ' . $e->getMessage();
            $applications = [];
            $stats = ['total' => 0, 'pending' => 0, 'reviewed' => 0, 'shortlisted' => 0, 'rejected' => 0, 'hired' => 0];
            $jobs = [];
            require __DIR__ . '/../views/admin/application.php';
        }
    }

    public function viewApplication()
    {
        // Check admin authentication
        if (!$this->isAdminLoggedIn()) {
            header('Location: ?page=admin-login');
            exit;
        }

        $application_id = $_GET['id'] ?? null;
        if (!$application_id) {
            header('Location: ?page=admin-applications&error=' . urlencode('Invalid application ID'));
            exit;
        }

        try {
            require_once __DIR__ . '/../models/JobApplication.php';
            $jobApplicationModel = new JobApplication();

            // Get detailed application information using model method
            $application = $jobApplicationModel->getDetailedApplicationForAdmin($application_id);

            if (!$application) {
                header('Location: ?page=admin-applications&error=' . urlencode('Application not found'));
                exit;
            }

            require __DIR__ . '/../views/admin/view-application.php';
        } catch (Exception $e) {
            error_log('Error viewing application: ' . $e->getMessage());
            header('Location: ?page=admin-applications&error=' . urlencode('Failed to load application details'));
            exit;
        }
    }

    private function getApplicationStats()
    {
        try {
            require_once __DIR__ . '/../models/JobApplication.php';
            $jobApplicationModel = new JobApplication();
            return $jobApplicationModel->getApplicationStatsForAdmin();
        } catch (Exception $e) {
            error_log('Error getting application stats: ' . $e->getMessage());
            return [
                'total' => 0,
                'pending' => 0,
                'reviewed' => 0,
                'shortlisted' => 0,
                'rejected' => 0,
                'hired' => 0
            ];
        }
    }

    private function isAdminLoggedIn()
    {
        return isset($_SESSION['user_id']) && $_SESSION['role'] === 'admin';
    }
}
