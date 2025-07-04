<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Jobseeker.php';
require_once __DIR__ . '/../models/JobPost.php';

class JobseekerController
{
    private $userModel;
    private $jobseekerModel;
    private $jobPostModel;

    public function __construct()
    {
        $this->userModel = new User();
        $this->jobseekerModel = new Jobseeker();
        $this->jobPostModel = new JobPost();
    }

    public function signup()
    {
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';

            if (empty($email) || empty($password)) {
                $error = 'Please fill in all required fields.';
            } elseif ($password !== $confirm_password) {
                $error = 'Passwords do not match.';
            } elseif (strlen($password) < 6) {
                $error = 'Password must be at least 6 characters long.';
            } elseif ($this->userModel->findByEmail($email)) {
                $error = 'Email already exists.';
            } else {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // Create user account with jobseeker role
                $user_id = $this->userModel->create($email, $hashed_password, User::ROLE_JOBSEEKER);

                if ($user_id) {
                    $_SESSION['user_id'] = $user_id;
                    $_SESSION['role'] = 'jobseeker';
                    $_SESSION['role_name'] = 'jobseeker';
                    $_SESSION['email'] = $email;

                    // Redirect directly to dashboard
                    header('Location: ?page=jobseeker-dashboard');
                    exit;
                } else {
                    $error = 'Failed to create account. Please try again.';
                }
            }
        }

        include __DIR__ . '/../views/jobseekers/signup-jobseeker.php';
    }

    public function login()
    {
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if (empty($email) || empty($password)) {
                $error = 'Please fill in all fields.';
            } else {
                $user = $this->userModel->findByEmail($email);

                if ($user && password_verify($password, $user['password']) && $user['role_id'] == User::ROLE_JOBSEEKER) {
                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['role'] = User::ROLE_JOBSEEKER; // Use numeric constant, not string
                    $_SESSION['role_name'] = 'jobseeker';
                    $_SESSION['email'] = $user['email'];

                    // Always redirect to dashboard
                    header('Location: ?page=jobseeker-dashboard');
                    exit;
                } else {
                    $error = 'Invalid email or password, or this is not a jobseeker account.';
                }
            }
        }

        include __DIR__ . '/../views/jobseekers/login-jobseeker.php';
    }

    public function dashboard()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != User::ROLE_JOBSEEKER) {
            header('Location: ?page=login-jobseeker');
            exit;
        }

        // Get jobseeker profile
        $jobseeker = $this->jobseekerModel->findByUserId($_SESSION['user_id']);
        $hasProfile = $jobseeker !== null;

        // Get recent job listings for the dashboard
        try {
            // Use getAllActiveJobs instead of getOpenJobs for consistency
            $jobseeker_id = $hasProfile ? $jobseeker['jobseeker_id'] : null;
            $jobs = $this->jobPostModel->getAllActiveJobs($jobseeker_id);
            
            error_log('=== DASHBOARD DEBUG ===');
            error_log('Jobs from getAllActiveJobs: ' . count($jobs));
            foreach ($jobs as $job) {
                error_log("Job ID: {$job['job_id']}, Title: {$job['job_title']}");
            }
            error_log('=== END DASHBOARD DEBUG ===');
            
            // Limit to recent 6 jobs for dashboard
            $jobs = array_slice($jobs, 0, 6);
            
            // The has_applied field is already set by getAllActiveJobs method
            // No need to check again if jobseeker_id was provided
            
        } catch (Exception $e) {
            error_log('Error fetching jobs for dashboard: ' . $e->getMessage());
            $jobs = [];
        }

        // Get application statistics if profile exists
        $applicationStats = [];
        if ($hasProfile) {
            try {
                if (!class_exists('JobApplication')) {
                    require_once __DIR__ . '/../models/JobApplication.php';
                }
                
                $jobApplicationModel = new JobApplication();
                $applications = $jobApplicationModel->getApplicationsByJobseeker($jobseeker['jobseeker_id']);
                
                $applicationStats = [
                    'total' => count($applications),
                    'pending' => count(array_filter($applications, function($app) { 
                        return isset($app['application_status']) && $app['application_status'] === 'pending'; 
                    })),
                    'shortlisted' => count(array_filter($applications, function($app) { 
                        return isset($app['application_status']) && $app['application_status'] === 'shortlisted'; 
                    })),
                    'hired' => count(array_filter($applications, function($app) { 
                        return isset($app['application_status']) && $app['application_status'] === 'hired'; 
                    }))
                ];
            } catch (Exception $e) {
                error_log('Error fetching application stats: ' . $e->getMessage());
                $applicationStats = ['total' => 0, 'pending' => 0, 'shortlisted' => 0, 'hired' => 0];
            }
        }

        include __DIR__ . '/../views/jobseekers/dashboard.php';
    }

    public function completeProfile()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != User::ROLE_JOBSEEKER) {
            header('Location: ?page=login-jobseeker');
            exit;
        }

        $error = '';
        $success = '';
        $step = isset($_GET['step']) ? (int)$_GET['step'] : 1;

        // Validate step range
        if ($step < 1 || $step > 8) {
            $step = 1;
        }

        // Get existing profile data
        $jobseeker = $this->jobseekerModel->findByUserId($_SESSION['user_id']);

        // Get user data for autofill (name from signup)
        $user = $this->userModel->findById($_SESSION['user_id']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handleStepSubmission($step, $error, $success);
        }

        // Include the appropriate step view
        include __DIR__ . '/../views/jobseekers/complete-jobseeker-profile.php';
    }

    private function handleStepSubmission($step, &$error, &$success)
    {
        $data = $_POST;

        switch ($step) {
            case 1:
                $this->handleStep1($data, $error, $success);
                break;
            case 2:
                $this->handleStep2($data, $error, $success);
                break;
            case 3:
                $this->handleStep3($data, $error, $success);
                break;
            case 4:
                $this->handleStep4($data, $error, $success);
                break;
            case 5:
                $this->handleStep5($data, $error, $success);
                break;
            case 6:
                $this->handleStep6($data, $error, $success);
                break;
            case 7:
                $this->handleStep7($data, $error, $success);
                break;
            case 8:
                $this->handleStep8($data, $error, $success);
                break;
            default:
                $error = 'Invalid step.';
        }
    }

    private function handleStep1($data, &$error, &$success)
    {
        // Get the actual jobseeker record first
        $jobseeker = $this->jobseekerModel->findByUserId($_SESSION['user_id']);

        if (!$jobseeker) {
            // Create a basic jobseeker record if it doesn't exist
            $result = $this->jobseekerModel->create(
                $_SESSION['user_id'],
                'N/A',
                'N/A',
                'N/A',
                '',
                '',
                null,
                'Male',
                ''
            );

            if (!$result) {
                $error = 'Failed to create profile. Please try again.';
                return;
            }

            $jobseeker = $this->jobseekerModel->findByUserId($_SESSION['user_id']);
        }

        $jobseeker_id = $jobseeker['jobseeker_id'];

        // Handle resume/CV upload
        if (isset($_FILES['resume']) && $_FILES['resume']['error'] === UPLOAD_ERR_OK) {
            // Delete existing resume first
            $this->jobseekerModel->deleteDocumentByType($jobseeker_id, 'resume');
            $this->handleFileUpload($_FILES['resume'], 'resume', $jobseeker_id, $error, $success);
        }
        if (isset($_FILES['cv']) && $_FILES['cv']['error'] === UPLOAD_ERR_OK) {
            // Delete existing CV first
            $this->jobseekerModel->deleteDocumentByType($jobseeker_id, 'cv');
            $this->handleFileUpload($_FILES['cv'], 'cv', $jobseeker_id, $error, $success);
        }

        if (empty($error)) {
            header('Location: ?page=complete-jobseeker-profile&step=2');
            exit;
        }
    }

    private function handleStep2($data, &$error, &$success)
    {
        // Personal Information
        $required = ['first_name', 'last_name', 'date_of_birth', 'sex', 'contact_no'];
        foreach ($required as $field) {
            if (empty($data[$field])) {
                $error = 'Please fill in all required fields.';
                return;
            }
        }

        // Create or update jobseeker profile
        $result = $this->jobseekerModel->createOrUpdateProfile($_SESSION['user_id'], [
            'first_name' => $data['first_name'],
            'middle_name' => $data['middle_name'] ?? '',
            'last_name' => $data['last_name'],
            'suffix' => $data['suffix'] ?? '',
            'date_of_birth' => $data['date_of_birth'],
            'sex' => $data['sex'],
            'address' => ($data['municipal'] ?? '') . ' ' . ($data['barangay'] ?? ''),
            'contact_no' => $data['contact_no']
        ]);

        if ($result) {
            header('Location: ?page=complete-jobseeker-profile&step=3');
            exit;
        } else {
            $error = 'Failed to save profile information.';
        }
    }

    private function handleStep3($data, &$error, &$success)
    {
        // Get jobseeker_id
        $jobseeker = $this->jobseekerModel->findByUserId($_SESSION['user_id']);
        $jobseeker_id = $jobseeker['jobseeker_id'];

        // Employment Status
        $workData = [
            'job_title' => $data['job_title'] ?? 'N/A',
            'company_name' => $data['company_name'] ?? 'N/A',
            'employment_type' => $data['employment_type'] ?? 'N/A',
            'start_date' => $data['start_date'] ?? null,
            'end_date' => isset($data['currently_working']) && $data['currently_working'] === 'Yes' ? null : ($data['end_date'] ?? null),
            'currently_working' => $data['currently_working'] ?? 'No',
            'responsibilities' => 'N/A'
        ];

        $this->jobseekerModel->saveWorkExperience($jobseeker_id, $workData);
        header('Location: ?page=complete-jobseeker-profile&step=4');
        exit;
    }

    private function handleStep4($data, &$error, &$success)
    {
        // Get jobseeker_id
        $jobseeker = $this->jobseekerModel->findByUserId($_SESSION['user_id']);
        $jobseeker_id = $jobseeker['jobseeker_id'];

        // Educational Background
        $eduData = [
            'school_name' => $data['school_name'] ?? 'N/A',
            'education_level' => $data['education_level'] ?? 'N/A',
            'field_of_study' => $data['field_of_study'] ?? 'N/A',
            'start_date' => $data['start_year'] ? $data['start_year'] . '-01-01' : null,
            'end_date' => $data['end_year'] ? $data['end_year'] . '-12-31' : null
        ];

        $this->jobseekerModel->saveEducation($jobseeker_id, $eduData);
        header('Location: ?page=complete-jobseeker-profile&step=5');
        exit;
    }

    private function handleStep5($data, &$error, &$success)
    {
        // Get jobseeker_id
        $jobseeker = $this->jobseekerModel->findByUserId($_SESSION['user_id']);
        $jobseeker_id = $jobseeker['jobseeker_id'];

        // Work Experience (Additional)
        $workData = [
            'job_title' => $data['job_title'] ?? 'N/A',
            'company_name' => $data['company_name'] ?? 'N/A',
            'start_date' => $data['start_year'] ? $data['start_year'] . '-01-01' : null,
            'end_date' => $data['end_year'] ? $data['end_year'] . '-12-31' : null,
            'responsibilities' => $data['responsibilities'] ?? 'N/A',
            'employment_type' => 'N/A',
            'currently_working' => 'No'
        ];

        $this->jobseekerModel->saveWorkExperience($jobseeker_id, $workData);
        header('Location: ?page=complete-jobseeker-profile&step=6');
        exit;
    }

    private function handleStep6($data, &$error, &$success)
    {
        // Get jobseeker_id
        $jobseeker = $this->jobseekerModel->findByUserId($_SESSION['user_id']);
        $jobseeker_id = $jobseeker['jobseeker_id'];

        // Skills & Expertise
        if (isset($data['skills']) && is_array($data['skills'])) {
            foreach ($data['skills'] as $index => $skill) {
                if (!empty($skill)) {
                    $skillData = [
                        'skill_name' => $skill,
                        'proficiency_level' => $data['proficiency'][$index] ?? 'Beginner'
                    ];
                    $this->jobseekerModel->saveSkill($jobseeker_id, $skillData);
                }
            }
        } else {
            // Save N/A skill
            $this->jobseekerModel->saveSkill($jobseeker_id, [
                'skill_name' => 'N/A',
                'proficiency_level' => 'Beginner'
            ]);
        }

        header('Location: ?page=complete-jobseeker-profile&step=7');
        exit;
    }

    private function handleStep7($data, &$error, &$success)
    {
        // Get jobseeker_id
        $jobseeker = $this->jobseekerModel->findByUserId($_SESSION['user_id']);
        $jobseeker_id = $jobseeker['jobseeker_id'];

        // Certificates & Licenses
        $certData = [
            'certificate_title' => $data['certificate_title'] ?? 'N/A',
            'issuing_organization' => $data['issuing_organization'] ?? 'N/A',
            'date_issued' => $data['date_issued'] ?? null
        ];

        $this->jobseekerModel->saveCertificate($jobseeker_id, $certData);
        header('Location: ?page=complete-jobseeker-profile&step=8');
        exit;
    }

    private function handleFileUpload($file, $type, $jobseeker_id, &$error, &$success)
    {
        $allowedTypes = ['application/pdf'];
        $maxSize = 5 * 1024 * 1024; // 5MB

        if (!in_array($file['type'], $allowedTypes)) {
            $error = 'Only PDF files are allowed.';
            return false;
        }

        if ($file['size'] > $maxSize) {
            $error = 'File size must be less than 5MB.';
            return false;
        }
        // NEW: Store documents outside public directory for security
        $uploadDir = __DIR__ . '/../../uploads/documents/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $fileName = $jobseeker_id . '_' . $type . '_' . time() . '.pdf';
        $filePath = $uploadDir . $fileName;

        if (move_uploaded_file($file['tmp_name'], $filePath)) {
            $this->jobseekerModel->saveDocument(
                $jobseeker_id,
                $file['name'],
                'uploads/documents/' . $fileName,
                $type
            );
            $success = ucfirst($type) . ' uploaded successfully!';
            return true;
        } else {
            $error = 'Failed to upload file.';
            return false;
        }
    }

    private function handleStep8($data, &$error, &$success)
    {
        // Mark profile as completed and redirect to success page
        $this->jobseekerModel->markProfileComplete($_SESSION['user_id']);
        header('Location: ?page=profile-completion-success');
        exit;
    }

    public function profileCompletionSuccess()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != User::ROLE_JOBSEEKER) {
            header('Location: ?page=login-jobseeker');
            exit;
        }

        // Get jobseeker data for display
        $jobseeker = $this->jobseekerModel->findByUserId($_SESSION['user_id']);
        $user = $this->userModel->findById($_SESSION['user_id']);

        include __DIR__ . '/../views/jobseekers/profile-completion/profile-completion-success.php';
    }

    public function showProfile()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != User::ROLE_JOBSEEKER) {
            header('Location: ?page=login-jobseeker');
            exit;
        }

        include __DIR__ . '/../views/jobseekers/profile-jobseeker.php';
    }

    public function uploadProfilePhoto()
    {
        header('Content-Type: application/json');

        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != User::ROLE_JOBSEEKER) {
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            exit;
        }

        if (!isset($_FILES['profile_photo']) || $_FILES['profile_photo']['error'] !== UPLOAD_ERR_OK) {
            echo json_encode(['success' => false, 'message' => 'No file uploaded or upload error']);
            exit;
        }

        $file = $_FILES['profile_photo'];

        // Validate file type
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!in_array($file['type'], $allowedTypes)) {
            echo json_encode(['success' => false, 'message' => 'Invalid file type. Only JPEG, PNG, GIF, and WEBP are allowed.']);
            exit;
        }

        // Validate file size (2MB max for profile photos)
        if ($file['size'] > 2 * 1024 * 1024) {
            echo json_encode(['success' => false, 'message' => 'File size must be less than 2MB.']);
            exit;
        }

        // Validate that it's actually an image
        $imageInfo = getimagesize($file['tmp_name']);
        if ($imageInfo === false) {
            echo json_encode(['success' => false, 'message' => 'Invalid image file']);
            exit;
        }

        // Get jobseeker info
        $jobseeker = $this->jobseekerModel->findByUserId($_SESSION['user_id']);
        if (!$jobseeker) {
            echo json_encode(['success' => false, 'message' => 'Jobseeker profile not found']);
            exit;
        }

        // Check for existing profile picture and delete old file
        if (!empty($jobseeker['profile_picture'])) {
            $oldPhotoPath = __DIR__ . '/../../public/' . $jobseeker['profile_picture'];
            if (file_exists($oldPhotoPath)) {
                unlink($oldPhotoPath);
                error_log("DEBUG: Deleted old profile photo: $oldPhotoPath");
            }
        }

        // Create upload directory if it doesn't exist
        $uploadDir = __DIR__ . '/../../public/uploads/profile_pictures/';
        if (!is_dir($uploadDir)) {
            if (!mkdir($uploadDir, 0755, true)) {
                echo json_encode(['success' => false, 'message' => 'Failed to create upload directory']);
                exit;
            }
        }

        // Generate unique filename
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = 'profile_' . $_SESSION['user_id'] . '_' . time() . '.' . $extension;
        $filepath = $uploadDir . $filename;

        error_log("DEBUG: Attempting to upload profile photo to: $filepath");

        // Move uploaded file
        if (move_uploaded_file($file['tmp_name'], $filepath)) {
            // Update database with new profile picture path
            $relativePath = 'uploads/profile_pictures/' . $filename;
            $result = $this->jobseekerModel->updateProfilePicture($_SESSION['user_id'], $relativePath);

            if ($result) {
                error_log("DEBUG: Profile photo uploaded and database updated successfully");
                echo json_encode([
                    'success' => true,
                    'message' => 'Profile photo updated successfully',
                    'image_url' => $relativePath
                ]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update database']);
            }
        } else {
            error_log("DEBUG: Failed to move profile photo file from " . $file['tmp_name'] . " to " . $filepath);
            echo json_encode(['success' => false, 'message' => 'Failed to upload file']);
        }
        exit;
    }

    public function savedJobs()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != User::ROLE_JOBSEEKER) {
            header('Location: ?page=login-jobseeker');
            exit;
        }

        // Get jobseeker info
        $jobseeker = $this->jobseekerModel->findByUserId($_SESSION['user_id']);
        if (!$jobseeker) {
            header('Location: ?page=jobseeker-dashboard&error=' . urlencode('Please complete your profile first.'));
            exit;
        }

        require_once __DIR__ . '/../models/SavedJobs.php';
        $savedJobsModel = new SavedJobs();
        
        $savedJobs = $savedJobsModel->getSavedJobs($jobseeker['jobseeker_id']);
        
        // Check application status for each saved job
        require_once __DIR__ . '/../models/JobApplication.php';
        $jobApplicationModel = new JobApplication();
        
        foreach ($savedJobs as &$job) {
            $job['has_applied'] = $jobApplicationModel->hasApplied($jobseeker['jobseeker_id'], $job['job_id']);
        }

        include __DIR__ . '/../views/jobseekers/saved-jobs.php';
    }

    public function saveJob()
    {
        // Ensure clean output
        ob_clean();
        header('Content-Type: application/json');
        
        try {
            if (!isset($_SESSION['user_id']) || $_SESSION['role'] != User::ROLE_JOBSEEKER) {
                echo json_encode(['success' => false, 'message' => 'Please log in as a jobseeker to save jobs']);
                exit;
            }
            
            $job_id = $_POST['job_id'] ?? null;
            if (!$job_id) {
                echo json_encode(['success' => false, 'message' => 'Job ID is required']);
                exit;
            }

            // Get jobseeker info
            $jobseeker = $this->jobseekerModel->findByUserId($_SESSION['user_id']);
            if (!$jobseeker) {
                echo json_encode(['success' => false, 'message' => 'Please complete your profile first']);
                exit;
            }

            require_once __DIR__ . '/../models/SavedJobs.php';
            $savedJobsModel = new SavedJobs();
            
            // Check if already saved before attempting to save
            if ($savedJobsModel->isSaved($jobseeker['jobseeker_id'], $job_id)) {
                echo json_encode(['success' => false, 'message' => 'Job is already saved']);
                exit;
            }
            
            $result = $savedJobsModel->saveJob($jobseeker['jobseeker_id'], $job_id);
            
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Job saved successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to save job']);
            }
        } catch (Exception $e) {
            error_log('Error in saveJob: ' . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'An error occurred while saving the job']);
        }
        exit;
    }

    public function unsaveJob()
    {
        // Ensure clean output
        ob_clean();
        header('Content-Type: application/json');
        
        try {
            if (!isset($_SESSION['user_id']) || $_SESSION['role'] != User::ROLE_JOBSEEKER) {
                echo json_encode(['success' => false, 'message' => 'Please log in as a jobseeker']);
                exit;
            }

            $job_id = $_POST['job_id'] ?? null;
            if (!$job_id) {
                echo json_encode(['success' => false, 'message' => 'Job ID is required']);
                exit;
            }

            // Get jobseeker info
            $jobseeker = $this->jobseekerModel->findByUserId($_SESSION['user_id']);
            if (!$jobseeker) {
                echo json_encode(['success' => false, 'message' => 'Jobseeker profile not found']);
                exit;
            }

            require_once __DIR__ . '/../models/SavedJobs.php';
            $savedJobsModel = new SavedJobs();
            
            $result = $savedJobsModel->unsaveJob($jobseeker['jobseeker_id'], $job_id);
            
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Job removed from saved jobs']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error removing job from saved jobs']);
            }
        } catch (Exception $e) {
            error_log('Error in unsaveJob: ' . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'An error occurred while removing the job']);
        }
        exit;
    }
}
