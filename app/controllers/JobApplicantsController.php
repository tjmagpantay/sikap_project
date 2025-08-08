<?php
// filepath: app/controllers/JobApplicationController.php
require_once __DIR__ . '/../models/JobApplicants.php';

class JobApplicantsController
{
    private $jobApplicantsModel;

    public function __construct()
    {
        $this->jobApplicantsModel = new JobApplicants();
    }

    public function viewApplicants($job_id)
    {
        $job_id = $_GET['job_id'] ?? null;
        $applicants = $this->jobApplicantsModel->getApplicantsByJob($job_id);
        include __DIR__ . '/../views/employers/manage-applications.php';
    }
    public function viewAllApplicants()
    {
        $jobGroups = $this->jobApplicantsModel->getAllApplicantsGroupedByJob();
        include __DIR__ . '/../views/employers/browse-candidates.php';
    }
}
