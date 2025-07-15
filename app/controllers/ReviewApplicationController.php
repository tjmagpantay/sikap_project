<?php
require_once __DIR__ . '/../models/ReviewApplication.php';

class ReviewApplicationController
{
    public function view($application_id)
    {
        $model = new ReviewApplication();
        $application = $model->getApplication($application_id);
        $interview = $model->getInterview($application_id);
        include __DIR__ . '/../views/employers/review-application.php';
    }

    public function handlePost($application_id)
    {
        $model = new ReviewApplication();

        // Update Status
        if (
            isset($_GET['action']) &&
            $_GET['action'] === 'updateStatus' &&
            $_SERVER['REQUEST_METHOD'] === 'POST'
        ) {
            $status = $_POST['application_status'] ?? null;
            if ($status) {
                $model->updateStatus($application_id, $status);
            }
            header("Location: ?page=review-application&application_id=$application_id");
            exit;
        }

        // Schedule Interview
        if (
            isset($_GET['action']) &&
            $_GET['action'] === 'scheduleInterview' &&
            $_SERVER['REQUEST_METHOD'] === 'POST'
        ) {
            $date = $_POST['interview_date'] ?? null;
            $location = $_POST['interview_location'] ?? null;
            $notes = $_POST['notes'] ?? null;
            $managed_by_user_id = $_SESSION['user_id'] ?? null;
            $model->scheduleInterview($application_id, $date, $location, $notes, $managed_by_user_id);

            // Update status to 'shortlisted' when interview is scheduled
            $model->updateStatus($application_id, 'shortlisted');

            header("Location: ?page=review-application&application_id=$application_id");
            exit;
        }
    }
}
