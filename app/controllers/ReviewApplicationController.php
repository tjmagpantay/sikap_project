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

        // Get screening answers using JobApplication model
        require_once __DIR__ . '/../models/JobApplication.php';
        $jobApplicationModel = new JobApplication();
        $application['screening_answers'] = $jobApplicationModel->getApplicationAnswers($application_id);


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
                // FIXED: Send notification to jobseeker about status update
                try {
                    // Get application details for notification
                    $application = $model->getApplicationBasic($application_id);

                    if ($application) {
                        require_once __DIR__ . '/../services/NotificationService.php';
                        require_once __DIR__ . '/../../config/sikap_db.php';

                        $config = require __DIR__ . '/../../config/sikap_db.php';
                        $pdo = new PDO(
                            "mysql:host={$config['db_host']};port={$config['db_port']};dbname={$config['db_name']};charset=utf8mb4",
                            $config['db_user'],
                            $config['db_pass'],
                            [
                                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                                PDO::ATTR_TIMEOUT => 30
                            ]
                        );
                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                        $notificationService = new NotificationService($pdo);

                        // FIXED: Get company name using simplified approach
                        require_once __DIR__ . '/../models/Employer.php';
                        $employerModel = new Employer();
                        $companyName = $employerModel->getCompanyName($employer_id);

                        // Send notification
                        $notificationResult = $notificationService->notifyApplicationStatusUpdate(
                            $application_id,
                            $status,
                            $application['job_title'],
                            $companyName,
                            $remarks
                        );
                    }
                } catch (Exception $e) {
                    error_log("Error sending status update notification: " . $e->getMessage());
                    // Don't fail the status update if notification fails
                }

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
                // FIXED: Send interview notification regardless of status, then update status
                try {
                    require_once __DIR__ . '/../services/NotificationService.php';
                    require_once __DIR__ . '/../../config/sikap_db.php';

                    $config = require __DIR__ . '/../../config/sikap_db.php';
                    $pdo = new PDO(
                        "mysql:host={$config['db_host']};port={$config['db_port']};dbname={$config['db_name']};charset=utf8mb4",
                        $config['db_user'],
                        $config['db_pass'],
                        [
                            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                            PDO::ATTR_TIMEOUT => 30
                        ]
                    );
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    $notificationService = new NotificationService($pdo);

                    // Get company name using simplified approach
                    require_once __DIR__ . '/../models/Employer.php';
                    $employerModel = new Employer();
                    $companyName = $employerModel->getCompanyName($employer_id);

                    // FIXED: Send interview notification FIRST
                    $interviewNotificationResult = $notificationService->notifyInterviewScheduled(
                        $application_id,
                        $application['job_title'],
                        $companyName,
                        $dateTime->format('F j, Y \a\t g:i A'),
                        $interview_location,
                        $notes
                    );

                    // THEN update application status to 'shortlisted' if it's pending
                    if ($application && $application['application_status'] === 'pending') {
                        $statusUpdateResult = $model->updateStatus($application_id, 'shortlisted', 'employer', 'Interview scheduled');

                        if ($statusUpdateResult) {
                            // Send status update notification
                            $statusNotificationResult = $notificationService->notifyApplicationStatusUpdate(
                                $application_id,
                                'shortlisted',
                                $application['job_title'],
                                $companyName,
                                'Interview scheduled'
                            );
                        }
                    }
                } catch (Exception $e) {
                    error_log("Error sending interview notification: " . $e->getMessage());
                }

                header('Location: ?page=review-application&application_id=' . $application_id . '&success=' . urlencode('Interview scheduled successfully.'));
            } else {
                header('Location: ?page=review-application&application_id=' . $application_id . '&error=' . urlencode('Failed to schedule interview.'));
            }
        } catch (Exception $e) {
            error_log('Error scheduling interview: ' . $e->getMessage());
            error_log('Stack trace: ' . $e->getTraceAsString());
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

                    // ADDED: Send resignation approval notification
                    try {
                        require_once __DIR__ . '/../services/NotificationService.php';
                        require_once __DIR__ . '/../../config/sikap_db.php';

                        $config = require __DIR__ . '/../../config/sikap_db.php';
                        $notificationPdo = new PDO(
                            "mysql:host={$config['db_host']};port={$config['db_port']};dbname={$config['db_name']};charset=utf8mb4",
                            $config['db_user'],
                            $config['db_pass'],
                            [
                                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                                PDO::ATTR_TIMEOUT => 30
                            ]
                        );
                        $notificationPdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                        $notificationService = new NotificationService($notificationPdo);

                        $notificationResult = $notificationService->notifyResignationStatusUpdate(
                            $resignationRequest['resignation_id'],
                            'approved',
                            $employer_notes
                        );
                    } catch (Exception $e) {
                        error_log("Error sending resignation approval notification: " . $e->getMessage());
                        // Don't fail the approval if notification fails
                    }

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
                // ADDED: Send resignation rejection notification
                try {
                    require_once __DIR__ . '/../services/NotificationService.php';
                    require_once __DIR__ . '/../../config/sikap_db.php';

                    $config = require __DIR__ . '/../../config/sikap_db.php';
                    $notificationPdo = new PDO(
                        "mysql:host={$config['db_host']};port={$config['db_port']};dbname={$config['db_name']};charset=utf8mb4",
                        $config['db_user'],
                        $config['db_pass'],
                        [
                            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                            PDO::ATTR_TIMEOUT => 30
                        ]
                    );
                    $notificationPdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    $notificationService = new NotificationService($notificationPdo);

                    // Send notification
                    $notificationResult = $notificationService->notifyResignationStatusUpdate(
                        $resignationRequest['resignation_id'],
                        'rejected',
                        $employer_notes
                    );
                } catch (Exception $e) {
                    error_log("Error sending resignation rejection notification: " . $e->getMessage());
                    // Don't fail the rejection if notification fails
                }

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

    public function sendStatusReminderEmails()
    {
        try {
            // Load mailer configuration
            $mailerConfig = require __DIR__ . '/../../config/mailer.php';

            $model = new ReviewApplication();

            // Fetch all pending applications where interview passed 7+ days
            $applications = $model->getPendingApplicationsWithExpiredInterview();

            if (empty($applications)) {
                error_log('No shortlisted applications found requiring status update notifications.');
                return;
            }

            foreach ($applications as $app) {
                try {
                    $subject = "Reminder: Update Application Status for {$app['jobseeker_name']}";
                    $body = "
                        <p>Dear {$app['employer_name']},</p>
                        <p>The interview for <b>{$app['jobseeker_name']}</b> held on 
                        <b>{$app['interview_date']}</b> has not been updated.</p>
                        <p>Please <a href='http://localhost/sikap/index.php?page=review-application&application_id={$app['application_id']}'>
                        update the application status here</a>.</p>
                        <br>
                        <p>Thank you,<br>SIKAP Team</p>
                    ";

                    // Initialize PHPMailer
                    $mailer = new PHPMailer\PHPMailer\PHPMailer(true);

                    try {
                        $mailer->isSMTP();
                        $mailer->Host = $mailerConfig['host'];
                        $mailer->SMTPAuth = true;
                        $mailer->Username = $mailerConfig['username'];
                        $mailer->Password = $mailerConfig['password'];
                        $mailer->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
                        $mailer->Port = $mailerConfig['port'];

                        // Set sender
                        $mailer->setFrom($mailerConfig['from_email'], $mailerConfig['from_name']);
                        $mailer->addAddress($app['employer_email']);

                        // Content
                        $mailer->isHTML(true);
                        $mailer->Subject = $subject;
                        $mailer->Body = $body;

                        $mailer->send();
                        echo "Reminder email sent to {$app['employer_email']} for jobseeker {$app['jobseeker_name']}\n";
                    } catch (Exception $e) {
                        error_log("Mailer Error for {$app['employer_email']}: " . $e->getMessage());
                        echo "Failed to send email to {$app['employer_email']}: " . $e->getMessage() . "\n";
                    }
                } catch (Exception $e) {
                    error_log("Error processing application {$app['application_id']}: " . $e->getMessage());
                    echo "Error processing application {$app['application_id']}: " . $e->getMessage() . "\n";
                    continue;
                }
            }
        } catch (Exception $e) {
            error_log('Error in sendStatusReminderEmails: ' . $e->getMessage());
            throw $e;
        }
    }

    public function acceptApplication($application_id)
    {
        if (!$application_id) {
            header('Location: ?page=browse-candidates&error=' . urlencode('Application not found'));
            exit;
        }

        // Simulate POST request for accept action
        $_POST['action'] = 'updateStatus';
        $_POST['status'] = 'hired';
        $_SERVER['REQUEST_METHOD'] = 'POST';

        $this->handlePost($application_id);
    }

    public function rejectApplication($application_id)
    {
        if (!$application_id) {
            header('Location: ?page=browse-candidates&error=' . urlencode('Application not found'));
            exit;
        }

        // Simulate POST request for reject action
        $_POST['action'] = 'updateStatus';
        $_POST['status'] = 'rejected';
        $_SERVER['REQUEST_METHOD'] = 'POST';

        $this->handlePost($application_id);
    }
}
