<?php
require_once __DIR__ . '/../models/Job.php';
require_once __DIR__ . '/../services/NotificationService.php';

class JobController {
    private $pdo;
    public function __construct($pdo) { $this->pdo = $pdo; }

    public function postJob($employerId, $title) {
        $jobModel = new Job($this->pdo);
        $jobId = $jobModel->create($employerId, $title);

        $notifService = new NotificationService($this->pdo);
        $notifService->notifyAdmins("job_post", "New job posted: $title", "/jobs/$jobId");
        $notifService->notifyJobseekers("job_post", "New job posted: $title", "/jobs/$jobId");

        return $jobId;
    }
}
