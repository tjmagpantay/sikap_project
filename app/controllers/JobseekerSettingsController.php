<?php
// // filepath: c:\xampp\htdocs\sikap\app\api\jobseeker_settings.php

// session_start();
// header('Content-Type: application/json');

// // Check if user is logged in and is a jobseeker
// if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'jobseeker') {
//     http_response_code(401);
//     echo json_encode(['error' => 'Unauthorized']);
//     exit;
// }
include_once __DIR__ . '/../models/JobseekerSettings.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Jobseeker.php';
require_once __DIR__ . '/../models/JobseekerSettings.php';

class JobseekerSettingsController
{
    private $jobseekerModel;
    private $settingsModel;

    public function __construct()
    {
        $this->jobseekerModel = new Jobseeker();
        $this->settingsModel = new JobseekerSettings();
    }

    public function showSettings()
    {
        // Check authentication
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != User::ROLE_JOBSEEKER) {
            header('Location: ?page=login-jobseeker');
            exit;
        }

        // Get jobseeker data for navbar
        $jobseeker = $this->jobseekerModel->findByUserId($_SESSION['user_id']);
        if (!$jobseeker) {
            header('Location: ?page=complete-jobseeker-profile');
            exit;
        }

        // Get current settings
        $settings = $this->settingsModel->getSettingsByJobseekerId($jobseeker['jobseeker_id']);

        include __DIR__ . '/../views/jobseekers/settings-jobseeker.php';
    }

    public function updateSettings()
    {
        header('Content-Type: application/json');

        // Check authentication
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != User::ROLE_JOBSEEKER) {
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
            // Get jobseeker
            $jobseeker = $this->jobseekerModel->findByUserId($_SESSION['user_id']);
            if (!$jobseeker) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Jobseeker profile not found']);
                exit;
            }

            $action = $_POST['action'] ?? '';
            $jobseeker_id = $jobseeker['jobseeker_id'];

            switch ($action) {
                case 'update_email_preferences':
                    $preferences = [
                        'job_recommendations' => (int)($_POST['job_recommendations'] ?? 0),
                        'application_updates' => (int)($_POST['application_updates'] ?? 0),
                        'programs_news' => (int)($_POST['programs_news'] ?? 0)
                    ];

                    $result = $this->settingsModel->updateEmailPreferences($jobseeker_id, $preferences);

                    if ($result) {
                        echo json_encode(['success' => true, 'message' => 'Email preferences updated successfully']);
                    } else {
                        echo json_encode(['success' => false, 'message' => 'Failed to update email preferences']);
                    }
                    break;

                case 'update_privacy_settings':
                    $settings = [
                        'profile_visibility' => (int)($_POST['profile_visibility'] ?? 0),
                        'contact_information' => (int)($_POST['contact_information'] ?? 0),
                        'resume_download' => (int)($_POST['resume_download'] ?? 0)
                    ];

                    $result = $this->settingsModel->updatePrivacySettings($jobseeker_id, $settings);

                    if ($result) {
                        echo json_encode(['success' => true, 'message' => 'Privacy settings updated successfully']);
                    } else {
                        echo json_encode(['success' => false, 'message' => 'Failed to update privacy settings']);
                    }
                    break;

                case 'get_settings':
                    $settings = $this->settingsModel->getSettingsByJobseekerId($jobseeker_id);
                    echo json_encode(['success' => true, 'settings' => $settings]);
                    break;

                default:
                    http_response_code(400);
                    echo json_encode(['success' => false, 'message' => 'Invalid action']);
            }
        } catch (Exception $e) {
            error_log("Settings Error: " . $e->getMessage());
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Internal server error']);
        }
        exit;
    }
}
