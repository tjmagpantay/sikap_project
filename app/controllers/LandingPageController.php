<?php
class LandingPageController
{
    private $jobPostModel;

    public function __construct()
    {
        require_once __DIR__ . '/../models/JobPost.php';
        $this->jobPostModel = new JobPost();
    }

    public function getTopCompanies($limit = 4)
    {
        try {
            // Get top companies based on active jobs count and verification status
            $companies = $this->jobPostModel->getAllEmployers($limit);

            // Debug: Log the result
            error_log("LandingPageController: Found " . count($companies) . " companies");
            if (!empty($companies)) {
                error_log("First company data: " . json_encode($companies[0]));
            }

            return $companies;
        } catch (Exception $e) {
            error_log("Error fetching top companies: " . $e->getMessage());
            return [];
        }
    }

    public function viewCompanyPublic($employerId)
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            // Store the intended destination in session
            $_SESSION['redirect_after_login'] = "?page=view-employer-profile&employer_id=" . $employerId;

            // Redirect to login with message
            $_SESSION['login_message'] = "Please log in to view company details.";
            header('Location: ?page=login');
            exit();
        }

        // If logged in, redirect to the actual company profile
        header("Location: ?page=view-employer-profile&employer_id=" . $employerId);
        exit();
    }
}
