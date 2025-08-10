<?php
require_once __DIR__ . '/../models/ReviewApplication.php';

class ReviewApplicationController
{
    public function view($application_id)
    {
        $model = new ReviewApplication();

        // Use getFullApplicationDetails instead of getApplication to get enhanced data
        $application = $model->getFullApplicationDetails($application_id);

        if (!$application) {
            // Handle error - application not found
            header('Location: ?page=browse-candidates&error=Application not found');
            exit;
        }

        $interview = $model->getInterview($application_id);

        include __DIR__ . '/../views/employers/review-application.php';
    }

    public function handlePost($application_id)
    {
        $model = new ReviewApplication();

        $action = $_GET['action'] ?? '';

        switch ($action) {
            case 'updateStatus':
                $status = $_POST['application_status'] ?? '';
                if ($model->updateStatus($application_id, $status)) {
                    header("Location: ?page=review-application&application_id=$application_id&success=Status updated");
                } else {
                    header("Location: ?page=review-application&application_id=$application_id&error=Failed to update status");
                }
                break;

            case 'scheduleInterview':
                $date = $_POST['interview_date'] ?? '';
                $location = $_POST['interview_location'] ?? '';
                $notes = $_POST['notes'] ?? '';
                $managed_by_user_id = $_SESSION['user_id'] ?? 0;

                if ($model->scheduleInterview($application_id, $date, $location, $notes, $managed_by_user_id)) {
                    header("Location: ?page=review-application&application_id=$application_id&success=Interview scheduled");
                } else {
                    header("Location: ?page=review-application&application_id=$application_id&error=Failed to schedule interview");
                }
                break;
        }

        exit;
    }
}
