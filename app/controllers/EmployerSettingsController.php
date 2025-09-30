<?php
include_once __DIR__ . '/../models/EmployerSettings.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Employer.php';

class EmployerSettingsController
{
    private $employerModel;
    private $settingsModel;

    public function __construct()
    {
        $this->employerModel = new Employer();
        $this->settingsModel = new EmployerSettings();
    }

    public function showSettings()
    {
        // Check authentication
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != User::ROLE_EMPLOYER) {
            header('Location: ?page=login-employer');
            exit;
        }

        // Get employer data for navbar
        $employer = $this->employerModel->findByUserId($_SESSION['user_id']);
        if (!$employer) {
            header('Location: ?page=complete-employer-profile');
            exit;
        }

        // Get current settings - THIS IS CRUCIAL!
        $settings = $this->settingsModel->getSettingsByEmployerId($employer['employer_id']);

        // Both $employer and $settings variables are now available in the view
        include __DIR__ . '/../views/employers/setting-employer.php';
    }

    public function updateSettings()
    {
        header('Content-Type: application/json');


        // Check authentication
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != User::ROLE_EMPLOYER) {
            error_log("EmployerSettings: Authentication failed");
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);
            exit;
        }

        try {
            // Get employer
            $employer = $this->employerModel->findByUserId($_SESSION['user_id']);
            if (!$employer) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Employer profile not found']);
                exit;
            }

            $action = $_POST['action'] ?? '';
            $employer_id = $employer['employer_id'];

            switch ($action) {
                case 'update_email_preferences':
                    $preferences = [
                        'application_notifications' => (int)($_POST['application_notifications'] ?? 0),
                        'candidate_matches' => (int)($_POST['candidate_matches'] ?? 0),
                        'job_post_updates' => (int)($_POST['job_post_updates'] ?? 0),
                        'platform_updates' => (int)($_POST['platform_updates'] ?? 0)
                    ];

                    $result = $this->settingsModel->updateEmailPreferences($employer_id, $preferences);

                    if ($result) {
                        echo json_encode(['success' => true, 'message' => 'Email preferences updated successfully']);
                    } else {
                        echo json_encode(['success' => false, 'message' => 'Failed to update email preferences']);
                    }
                    break;

                case 'update_visibility_settings':
                    $settings = [
                        'company_profile_visibility' => (int)($_POST['company_profile_visibility'] ?? 0),
                        'contact_information' => (int)($_POST['contact_information'] ?? 0),
                        'job_post_analytics' => (int)($_POST['job_post_analytics'] ?? 0)
                    ];

                    $result = $this->settingsModel->updateVisibilitySettings($employer_id, $settings);

                    if ($result) {
                        echo json_encode(['success' => true, 'message' => 'Visibility settings updated successfully']);
                    } else {
                        echo json_encode(['success' => false, 'message' => 'Failed to update visibility settings']);
                    }
                    break;

                case 'update_hiring_preferences':
                    $settings = [
                        'auto_screen_applications' => (int)($_POST['auto_screen_applications'] ?? 0),
                        'send_auto_replies' => (int)($_POST['send_auto_replies'] ?? 0),
                        'priority_candidate_alerts' => (int)($_POST['priority_candidate_alerts'] ?? 0)
                    ];

                    $result = $this->settingsModel->updateHiringPreferences($employer_id, $settings);

                    if ($result) {
                        echo json_encode(['success' => true, 'message' => 'Hiring preferences updated successfully']);
                    } else {
                        echo json_encode(['success' => false, 'message' => 'Failed to update hiring preferences']);
                    }
                    break;

                case 'get_settings':
                    $settings = $this->settingsModel->getSettingsByEmployerId($employer_id);
                    echo json_encode(['success' => true, 'settings' => $settings]);
                    break;

                default:
                    http_response_code(400);
                    echo json_encode(['success' => false, 'message' => 'Invalid action']);
            }
        } catch (Exception $e) {
            error_log("Employer Settings Error: " . $e->getMessage());
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Internal server error']);
        }
        exit;
    }
}
