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

    public function signup()
    {
        // Developer access control - only allow on localhost or specific IPs
        $allowedIPs = ['127.0.0.1', '::1', 'localhost'];
        $clientIP = $_SERVER['REMOTE_ADDR'] ?? '';

        // Check if accessing from allowed environment
        if (!in_array($clientIP, $allowedIPs) && !$this->isDevelopmentEnvironment()) {
            http_response_code(403);
            echo "<h1>403 Forbidden</h1><p>Admin registration is restricted to developers only.</p>";
            exit;
        }

        $error = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $adminName = trim($_POST['admin_name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            // Validation
            if (empty($adminName) || empty($email) || empty($password) || empty($confirmPassword)) {
                $error = 'Please fill in all fields.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = 'Please enter a valid email address.';
            } elseif (strlen($password) < 8) {
                $error = 'Password must be at least 8 characters long.';
            } elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)/', $password)) {
                $error = 'Password must contain at least one uppercase letter, one lowercase letter, and one number.';
            } elseif ($password !== $confirmPassword) {
                $error = 'Passwords do not match.';
            } else {
                // Check if email already exists - FIXED: Use correct method name
                require_once __DIR__ . '/../models/User.php';
                $userModel = new User();
                $existingUser = $userModel->findByEmail($email); // Fixed: was findByEmail

                if ($existingUser) {
                    $error = 'Email already exists in the system.';
                } else {
                    // Create the admin account
                    $result = $this->adminModel->createAdmin($adminName, $email, $password);

                    if ($result['success']) {
                        $success = 'Admin account created successfully! You can now login.';
                        // Clear form data
                        $_POST = [];
                    } else {
                        $error = $result['message'] ?? 'Failed to create admin account.';
                    }
                }
            }
        }

        include __DIR__ . '/../views/admin/signup-admin.php';
    }

    private function isDevelopmentEnvironment()
    {
        // Check for development environment indicators
        $devIndicators = [
            $_SERVER['SERVER_NAME'] === 'localhost',
            $_SERVER['HTTP_HOST'] === 'localhost',
            strpos($_SERVER['HTTP_HOST'], 'localhost:') === 0,
            $_SERVER['SERVER_NAME'] === '127.0.0.1',
            isset($_SERVER['XAMPP_ROOT']), // XAMPP indicator
            isset($_ENV['APP_ENV']) && $_ENV['APP_ENV'] === 'development'
        ];

        return in_array(true, $devIndicators);
    }

    // ...existing code...

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
                    title: 'Access Blocked',
                    text: '" . addslashes($popupMessage) . "',
                    confirmButtonText: 'Understood',
                    confirmButtonColor: '#092C4C',
                    customClass: {
                        title: 'text-lg font-semibold',
                        confirmButton: 'bg-primary hover:bg-primary/90 text-white px-4 py-2 rounded-lg text-sm',
                        popup: 'admin-login-popup rounded-xl shadow-lg',
                        htmlContainer: 'text-sm leading-relaxed'
                    }
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

        // Replace the existing SweetAlert code with this version (no icon):

        if (!empty($popupMessage)) {
            echo "<script>
            Swal.fire({
                title: 'Login Failed',
                text: '" . addslashes($popupMessage) . "',
                confirmButtonText: 'Try Again',
                confirmButtonColor: '#092C4C',
                customClass: {
                    title: 'text-lg font-semibold',
                    confirmButton: 'bg-primary hover:bg-primary/90 text-white px-4 py-2 rounded-lg text-sm',
                    popup: 'admin-login-popup rounded-xl shadow-lg',
                    htmlContainer: 'text-sm leading-relaxed'
                }
            });
            </script>";
        }
    }

    public function dashboard()
    {
        // Changed from User::ROLE_ADMIN to 'admin'
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
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
        if (!$this->isAdminLoggedIn()) {
            header('Location: ?page=admin-login');
            exit;
        }

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
            // Get the current accreditation details before updating (for notification comparison)
            $currentAccreditation = $this->adminModel->getAccreditationDetails($accreditation_id);
            $previousStatus = $currentAccreditation['status'] ?? 'pending';

            // Update accreditation status
            $result = $this->adminModel->updateAccreditationStatus($accreditation_id, $status, $admin_id, $notes);

            if ($result) {
                // Sync employer status
                $syncResult = $this->syncEmployerStatus($accreditation_id, $status);

                $statusText = ucfirst($status);

                // ADDED: Send notification to employer about status update (only if status actually changed)
                if ($previousStatus !== $status) {
                    try {
                        require_once __DIR__ . '/../services/NotificationService.php';
                        require_once __DIR__ . '/../../config/sikap_db.php';

                        $config = require __DIR__ . '/../../config/sikap_db.php';
                        $notificationPdo = new PDO(
                            "mysql:host={$config['db_host']};dbname={$config['db_name']}",
                            $config['db_user'],
                            $config['db_pass']
                        );
                        $notificationPdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                        $notificationService = new NotificationService($notificationPdo);

                        // Send notification to employer
                        $notificationResult = $notificationService->notifyEmployerAboutAccreditationUpdate(
                            $accreditation_id,
                            $status,
                            $notes
                        );
                    } catch (Exception $e) {
                        error_log("Error sending accreditation status notification: " . $e->getMessage());
                        // Don't fail the status update if notification fails
                    }
                }

                if ($syncResult) {
                    $_SESSION['success'] = "Accreditation status successfully updated to {$statusText}. Employer status has been synchronized and notification sent.";
                } else {
                    $_SESSION['success'] = "Accreditation status updated to {$statusText}, but employer status sync failed. Notification sent.";
                }
            } else {
                $_SESSION['error'] = 'Failed to update accreditation status. Please try again.';
            }
        } catch (Exception $e) {
            error_log("Error updating accreditation status: " . $e->getMessage());
            $_SESSION['error'] = 'An error occurred while updating the status. Please try again.';
        }

        // Redirect back to the same review page
        header("Location: ?page=admin-review-accreditation&id={$accreditation_id}");
        exit;
    }

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

            // Get applications using model method
            $applications = $jobApplicationModel->getAllApplicationsForAdmin($statusFilter, $searchQuery, $jobFilter);

            // Get application statistics using model method
            $stats = $jobApplicationModel->getApplicationStatsForAdmin();

            // Get all jobs for filter dropdown using model method
            $jobs = $jobApplicationModel->getJobsForFilterDropdown();

            // Set error/success messages
            $error = $_GET['error'] ?? '';
            $success = $_GET['success'] ?? '';

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

    // Add these methods to your existing AdminController class

    public function settings()
    {
        // Check admin authentication
        if (!$this->isAdminLoggedIn()) {
            header('Location: ?page=admin-login');
            exit;
        }

        // Get admin data using the model
        $admin = $this->adminModel->getAdminProfile($_SESSION['user_id']);

        include __DIR__ . '/../views/admin/settings-admin.php';
    }

    public function changePassword()
    {
        // This method handles the AJAX password change request
        header('Content-Type: application/json');

        // Check if user is logged in and is admin
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $currentPassword = $_POST['current_password'] ?? '';
                $newPassword = $_POST['new_password'] ?? '';
                $confirmPassword = $_POST['confirm_password'] ?? '';

                // Validation
                if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
                    echo json_encode(['success' => false, 'message' => 'All fields are required']);
                    exit;
                }

                if ($newPassword !== $confirmPassword) {
                    echo json_encode(['success' => false, 'message' => 'New passwords do not match']);
                    exit;
                }

                if (strlen($newPassword) < 8) {
                    echo json_encode(['success' => false, 'message' => 'Password must be at least 8 characters long']);
                    exit;
                }

                if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)/', $newPassword)) {
                    echo json_encode(['success' => false, 'message' => 'Password must contain at least one uppercase letter, one lowercase letter, and one number']);
                    exit;
                }

                // Use the admin model to handle password change
                $result = $this->adminModel->changePassword($_SESSION['user_id'], $currentPassword, $newPassword);

                if ($result['success']) {
                    echo json_encode(['success' => true, 'message' => $result['message']]);
                } else {
                    echo json_encode(['success' => false, 'message' => $result['message']]);
                }
            } catch (Exception $e) {
                error_log("Admin Change Password Error: " . $e->getMessage());
                echo json_encode(['success' => false, 'message' => 'An error occurred while updating password']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
        }
        exit;
    }
    private function isAdminLoggedIn()
    {
        return isset($_SESSION['user_id']) && $_SESSION['role'] === 'admin';
    }
}