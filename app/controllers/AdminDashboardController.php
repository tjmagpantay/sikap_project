<?php
require_once __DIR__ . '/../models/AdminDashboard.php';

class AdminDashboardController
{
    private $adminDashboardModel;

    public function __construct()
    {
        $this->adminDashboardModel = new AdminDashboard();
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

    // Add methods for other admin functionalities
    public function jobseekerManagement()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: ?page=admin-login');
            exit;
        }
        // Load jobseekers data (you'll need to add this method to AdminDashboard model)
        // try {
        //     $users = $this->adminDashboardModel->getJobseekers(); // ✅ Load data here
        // } catch (Exception $e) {
        //     $users = [];
        //     error_log("Error fetching jobseekers: " . $e->getMessage());
        // }
        include __DIR__ . '/../views/admin/dashboard.php';
    }

    public function employerManagement()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: ?page=admin-login');
            exit;
        }

        // try {
        //     $users = $this->adminDashboardModel->getEmployers(); // ✅ Load data here
        // } catch (Exception $e) {
        //     $users = [];
        //     error_log("Error fetching employers: " . $e->getMessage());
        // }

        include __DIR__ . '/../views/admin/dashboard.php';
    }

    public function jobpostManagement()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: ?page=admin-login');
            exit;
        }

        // // Load jobs data
        // try {
        //     $jobs = $this->adminDashboardModel->getJobPosts(); // Add this method to AdminDashboard model
        //     $stats = $this->adminDashboardModel->getJobPostStats(); // Add this method to AdminDashboard model
        //     $searchQuery = $_GET['search'] ?? '';
        //     $statusFilter = $_GET['status'] ?? 'all';
        // } catch (Exception $e) {
        //     $jobs = [];
        //     $stats = ['total' => 0, 'open' => 0, 'paused' => 0, 'draft' => 0, 'closed' => 0, 'employers' => 0];
        //     $searchQuery = '';
        //     $statusFilter = 'all';
        //     error_log("Error fetching job posts: " . $e->getMessage());
        // }

        include __DIR__ . '/../views/admin/dashboard.php';
    }

    public function accreditations()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: ?page=admin-login');
            exit;
        }

        // // Load accreditations data
        // try {
        //     $accreditations = $this->adminDashboardModel->getAccreditations(); // Add this method to AdminDashboard model
        // } catch (Exception $e) {
        //     $accreditations = [];
        //     error_log("Error fetching accreditations: " . $e->getMessage());
        // }

        include __DIR__ . '/../views/admin/dashboard.php';
    }

    public function reports()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: ?page=admin-login');
            exit;
        }

        // Load reports data if needed
        // $reportData = $this->adminDashboardModel->getReportData();

        include __DIR__ . '/../views/admin/dashboard.php';
    }

    public function applications()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: ?page=admin-login');
            exit;
        }

        // // Load applications data
        // try {
        //     $applications = $this->adminDashboardModel->getApplications(); // Add this method to AdminDashboard model
        //     $stats = $this->adminDashboardModel->getApplicationStats(); // Add this method too
        //     $jobs = $this->adminDashboardModel->getJobsForFilter(); // For job filter dropdown

        //     $searchQuery = $_GET['search'] ?? '';
        //     $statusFilter = $_GET['status'] ?? 'all';
        //     $jobFilter = $_GET['job'] ?? 'all';

        // } catch (Exception $e) {
        //     $applications = [];
        //     $stats = ['total' => 0, 'pending' => 0, 'reviewed' => 0, 'shortlisted' => 0, 'hired' => 0, 'rejected' => 0];
        //     $jobs = [];
        //     $searchQuery = '';
        //     $statusFilter = 'all';
        //     $jobFilter = 'all';
        //     error_log("Error fetching applications: " . $e->getMessage());
        // }

        include __DIR__ . '/../views/admin/dashboard.php';
    }

    // Jobseeker Management


}
