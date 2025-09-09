<?php
require_once __DIR__ . '/../models/ReviewApplication.php';
require_once __DIR__ . '/../models/User.php';

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

        // Get resignation request data
        $resignationRequest = null;
        try {
            require_once __DIR__ . '/../models/ResignationRequest.php';
            $resignationModel = new ResignationRequest();
            $resignationRequest = $resignationModel->getResignationRequestByApplication($application_id);
        } catch (Exception $e) {
            error_log('Error loading resignation request: ' . $e->getMessage());
        }

        include __DIR__ . '/../views/employers/review-application.php';
    }

    public function handlePost($application_id)
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != User::ROLE_EMPLOYER) {
            header('Location: ?page=login-employer');
            exit;
        }

        // Get employer info
        require_once __DIR__ . '/../models/Employer.php';
        $employerModel = new Employer();
        $employer = $employerModel->findByUserId($_SESSION['user_id']);

        if (!$employer) {
            header('Location: ?page=employer-dashboard&error=' . urlencode('Employer profile not found.'));
            exit;
        }

        $action = $_GET['action'] ?? '';

        switch ($action) {
            case 'updateStatus':
                $this->updateApplicationStatus($application_id, $employer['employer_id']);
                break;
            case 'scheduleInterview':
                $this->scheduleInterview($application_id, $employer['employer_id']);
                break;
            case 'approveResignation':
                $this->approveResignation($application_id, $employer['employer_id']);
                break;
            case 'rejectResignation':
                $this->rejectResignation($application_id, $employer['employer_id']);
                break;
            case 'setResigned':
                $this->setResignedStatus($application_id, $employer['employer_id']);
                break;
            default:
                header('Location: ?page=review-application&application_id=' . $application_id . '&error=' . urlencode('Invalid action.'));
                exit;
        }
    }

    private function updateApplicationStatus($application_id, $employer_id)
    {
        try {
            $status = $_POST['status'] ?? '';
            $remarks = $_POST['remarks'] ?? null;

            if (empty($status)) {
                header('Location: ?page=review-application&application_id=' . $application_id . '&error=' . urlencode('Status is required.'));
                exit;
            }

            // Validate status
            $validStatuses = ['pending', 'reviewed', 'shortlisted', 'rejected', 'hired', 'resigned'];
            if (!in_array($status, $validStatuses)) {
                header('Location: ?page=review-application&application_id=' . $application_id . '&error=' . urlencode('Invalid status.'));
                exit;
            }

            $model = new ReviewApplication();
            $result = $model->updateStatus($application_id, $status, 'employer', $remarks);

            if ($result) {
                $statusMessages = [
                    'pending' => 'Application status updated to pending.',
                    'reviewed' => 'Application marked as reviewed.',
                    'shortlisted' => 'Applicant has been shortlisted.',
                    'rejected' => 'Application has been rejected.',
                    'hired' => 'Applicant has been hired!',
                    'resigned' => 'Employee status updated to resigned.'
                ];

                $message = $statusMessages[$status] ?? 'Application status updated successfully.';
                header('Location: ?page=review-application&application_id=' . $application_id . '&success=' . urlencode($message));
            } else {
                header('Location: ?page=review-application&application_id=' . $application_id . '&error=' . urlencode('Failed to update application status.'));
            }
        } catch (Exception $e) {
            error_log('Error updating application status: ' . $e->getMessage());
            header('Location: ?page=review-application&application_id=' . $application_id . '&error=' . urlencode('An error occurred while updating status.'));
        }
        exit;
    }

    private function scheduleInterview($application_id, $employer_id)
    {
        try {
            $interview_date = $_POST['interview_date'] ?? '';
            $interview_location = $_POST['interview_location'] ?? '';
            $notes = $_POST['notes'] ?? '';

            if (empty($interview_date)) {
                header('Location: ?page=review-application&application_id=' . $application_id . '&error=' . urlencode('Interview date is required.'));
                exit;
            }

            if (empty($interview_location)) {
                header('Location: ?page=review-application&application_id=' . $application_id . '&error=' . urlencode('Interview location is required.'));
                exit;
            }

            // Validate date format and ensure it's in the future
            $dateTime = DateTime::createFromFormat('Y-m-d\TH:i', $interview_date);
            if (!$dateTime || $dateTime <= new DateTime()) {
                header('Location: ?page=review-application&application_id=' . $application_id . '&error=' . urlencode('Please provide a valid future date and time.'));
                exit;
            }

            $model = new ReviewApplication();
            $result = $model->scheduleInterview($application_id, $interview_date, $interview_location, $notes, $_SESSION['user_id']);

            if ($result) {
                // Also update application status to 'shortlisted' if it's still pending
                $application = $model->getApplication($application_id);
                if ($application && $application['application_status'] === 'pending') {
                    $model->updateStatus($application_id, 'shortlisted', 'employer', 'Interview scheduled');
                }

                header('Location: ?page=review-application&application_id=' . $application_id . '&success=' . urlencode('Interview scheduled successfully.'));
            } else {
                header('Location: ?page=review-application&application_id=' . $application_id . '&error=' . urlencode('Failed to schedule interview.'));
            }
        } catch (Exception $e) {
            error_log('Error scheduling interview: ' . $e->getMessage());
            header('Location: ?page=review-application&application_id=' . $application_id . '&error=' . urlencode('An error occurred while scheduling the interview.'));
        }
        exit;
    }

    private function approveResignation($application_id, $employer_id)
    {
        try {
            require_once __DIR__ . '/../models/ResignationRequest.php';
            require_once __DIR__ . '/../models/JobApplication.php';

            $resignationModel = new ResignationRequest();
            $jobApplicationModel = new JobApplication();

            // Get resignation request
            $resignationRequest = $resignationModel->getResignationRequestByApplication($application_id);
            if (!$resignationRequest || $resignationRequest['request_status'] !== 'pending') {
                header('Location: ?page=review-application&application_id=' . $application_id . '&error=' . urlencode('No pending resignation request found.'));
                exit;
            }

            $employer_notes = trim($_POST['employer_notes']) ?: null;

            // Start transaction
            $pdo = $resignationModel->getPdo();
            $pdo->beginTransaction();

            try {
                // Update resignation status to approved
                $result1 = $resignationModel->updateResignationStatus(
                    $resignationRequest['resignation_id'],
                    'approved',
                    $employer_notes,
                    $_SESSION['user_id']
                );

                // Update application status to resigned
                $result2 = $jobApplicationModel->resignFromJob($application_id, null, $employer_id);

                if ($result1 && $result2) {
                    $pdo->commit();
                    header('Location: ?page=review-application&application_id=' . $application_id . '&success=' . urlencode('Resignation request approved successfully. Employee status updated to resigned.'));
                } else {
                    $pdo->rollback();
                    header('Location: ?page=review-application&application_id=' . $application_id . '&error=' . urlencode('Failed to approve resignation request.'));
                }
            } catch (Exception $e) {
                $pdo->rollback();
                throw $e;
            }
        } catch (Exception $e) {
            error_log('Error approving resignation: ' . $e->getMessage());
            header('Location: ?page=review-application&application_id=' . $application_id . '&error=' . urlencode('An error occurred while approving resignation.'));
        }
        exit;
    }

    private function rejectResignation($application_id, $employer_id)
    {
        try {
            require_once __DIR__ . '/../models/ResignationRequest.php';
            $resignationModel = new ResignationRequest();

            // Get resignation request
            $resignationRequest = $resignationModel->getResignationRequestByApplication($application_id);
            if (!$resignationRequest || $resignationRequest['request_status'] !== 'pending') {
                header('Location: ?page=review-application&application_id=' . $application_id . '&error=' . urlencode('No pending resignation request found.'));
                exit;
            }

            $employer_notes = trim($_POST['employer_notes']) ?: null;

            $result = $resignationModel->updateResignationStatus(
                $resignationRequest['resignation_id'],
                'rejected',
                $employer_notes,
                $_SESSION['user_id']
            );

            if ($result) {
                header('Location: ?page=review-application&application_id=' . $application_id . '&success=' . urlencode('Resignation request rejected.'));
            } else {
                header('Location: ?page=review-application&application_id=' . $application_id . '&error=' . urlencode('Failed to reject resignation request.'));
            }
        } catch (Exception $e) {
            error_log('Error rejecting resignation: ' . $e->getMessage());
            header('Location: ?page=review-application&application_id=' . $application_id . '&error=' . urlencode('An error occurred while rejecting resignation.'));
        }
        exit;
    }

    private function setResignedStatus($application_id, $employer_id)
    {
        try {
            require_once __DIR__ . '/../models/JobApplication.php';
            $jobApplicationModel = new JobApplication();

            // Check if application is hired first
            $application = $jobApplicationModel->getApplicationById($application_id);
            if (!$application || $application['application_status'] !== 'hired') {
                header('Location: ?page=review-application&application_id=' . $application_id . '&error=' . urlencode('Can only resign hired employees.'));
                exit;
            }

            // Update application status to resigned
            $result = $jobApplicationModel->resignFromJob($application_id, null, $employer_id);

            if ($result) {
                header('Location: ?page=review-application&application_id=' . $application_id . '&success=' . urlencode('Employee status updated to resigned.'));
            } else {
                header('Location: ?page=review-application&application_id=' . $application_id . '&error=' . urlencode('Failed to update employee status.'));
            }
        } catch (Exception $e) {
            error_log('Error setting resigned status: ' . $e->getMessage());
            header('Location: ?page=review-application&application_id=' . $application_id . '&error=' . urlencode('An error occurred while updating status.'));
        }
        exit;
    }
}
