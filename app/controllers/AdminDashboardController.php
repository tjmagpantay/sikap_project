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

        // Get chart data
        $jobStatsChart = $this->adminDashboardModel->getJobStatsForChart();
        $jobCategoryChart = $this->adminDashboardModel->getJobCategoryStatsForChart();

        // Get admin name from session
        $adminName = $_SESSION['admin_name'] ?? 'Admin';

        // Include the dashboard view
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

    /**
     * Get recent activity for dashboard
     */
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

    /**
     * Get top job categories
     */
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
}
