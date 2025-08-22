<?php
// filepath: app/controllers/JobApplicationController.php
require_once __DIR__ . '/../models/JobApplicants.php';
require_once __DIR__ . '/../models/Employer.php';
require_once __DIR__ . '/../models/User.php';

class JobApplicantsController
{
    private $jobApplicantsModel;
    private $employerModel;

    public function __construct()
    {
        $this->jobApplicantsModel = new JobApplicants();
        $this->employerModel = new Employer();
    }

    public function viewApplicants($job_id)
    {
        // Check if user is logged in as employer
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != User::ROLE_EMPLOYER) {
            header('Location: ?page=login-employer');
            exit();
        }

        // Get the employer record to get employer_id
        $employer = $this->employerModel->findByUserId($_SESSION['user_id']);
        if (!$employer || !$employer['employer_id']) {
            header('Location: ?page=login-employer');
            exit();
        }

        $job_id = $_GET['job_id'] ?? null;

        if (!$job_id) {
            // Redirect if no job ID provided
            header('Location: ?page=manage-jobs');
            exit();
        }

        // Get applicants only for this employer's job
        $applicants = $this->jobApplicantsModel->getApplicantsByJob($job_id, $employer['employer_id']);
        include __DIR__ . '/../views/employers/manage-applications.php';
    }

    public function viewAllApplicants()
    {
        // Check if user is logged in as employer
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != User::ROLE_EMPLOYER) {
            header('Location: ?page=login-employer');
            exit();
        }

        // Get the employer record to get employer_id
        $employer = $this->employerModel->findByUserId($_SESSION['user_id']);
        if (!$employer || !$employer['employer_id']) {
            header('Location: ?page=login-employer');
            exit();
        }

        // Get applicants only for this employer's job posts
        $jobGroups = $this->jobApplicantsModel->getAllApplicantsGroupedByJob($employer['employer_id']);
        include __DIR__ . '/../views/employers/browse-candidates.php';
    }
}
