<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Jobseeker.php';

class JobseekerController
{
    private $userModel;
    private $jobseekerModel;

    public function __construct()
    {
        $this->userModel = new User();
        $this->jobseekerModel = new Jobseeker();
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
                    $_SESSION['role'] = User::ROLE_JOBSEEKER;
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
                    $_SESSION['role'] = $user['role_id'];
                    $_SESSION['role_name'] = $user['role_name'];
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

        // Check if profile exists
        $jobseeker = $this->jobseekerModel->findByUserId($_SESSION['user_id']);
        $hasProfile = ($jobseeker !== false);

        // Get user info for display
        $user = $this->userModel->findById($_SESSION['user_id']);

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
        include __DIR__ . "/../views/jobseekers/complete-profile-step{$step}.php";
    }

    private function handleStepSubmission($step, &$error, &$success) {
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

        $uploadDir = __DIR__ . '/../../uploads/documents/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $fileName = $jobseeker_id . '_' . $type . '_' . time() . '.pdf';
        $filePath = $uploadDir . $fileName;

        if (move_uploaded_file($file['tmp_name'], $filePath)) {
            $this->jobseekerModel->saveDocument($jobseeker_id, [
                'file_name' => $file['name'],
                'file_path' => 'uploads/documents/' . $fileName,
                'file_type' => $type
            ]);
            $success = ucfirst($type) . ' uploaded successfully!';
            return true;
        } else {
            $error = 'Failed to upload file.';
            return false;
        }
    }

    private function handleStep8($data, &$error, &$success) {
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

        include __DIR__ . '/../views/jobseekers/profile-completion-success.php';
    }

    public function showProfile()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != User::ROLE_JOBSEEKER) {
            header('Location: ?page=login-jobseeker');
            exit;
        }

        include __DIR__ . '/../views/jobseekers/profile-jobseeker.php';
    }

    public function uploadProfilePhoto() {
        header('Content-Type: application/json');
        
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != User::ROLE_JOBSEEKER) {
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            exit;
        }
        
        if (!isset($_FILES['profile_photo']) || $_FILES['profile_photo']['error'] !== UPLOAD_ERR_OK) {
            echo json_encode(['success' => false, 'message' => 'No file uploaded']);
            exit;
        }
        
        $file = $_FILES['profile_photo'];
        
        // Validate file type
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!in_array($file['type'], $allowedTypes)) {
            echo json_encode(['success' => false, 'message' => 'Invalid file type. Only JPEG, PNG, GIF and WebP are allowed.']);
            exit;
        }
        
        // Validate file size (2MB max)
        if ($file['size'] > 2 * 1024 * 1024) {
            echo json_encode(['success' => false, 'message' => 'File size too large. Maximum 2MB allowed.']);
            exit;
        }
        
        // Create upload directory
        $uploadDir = __DIR__ . '/../../uploads/profile_photos/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        // Generate unique filename
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $fileName = $_SESSION['user_id'] . '_' . time() . '.' . $extension;
        $filePath = $uploadDir . $fileName;
        
        // Move uploaded file
        if (move_uploaded_file($file['tmp_name'], $filePath)) {
            // Save to database (optional - you can add a profile_photo field to jobseeker table)
            $relativePath = 'uploads/profile_photos/' . $fileName;
            
            // Update jobseeker record with profile photo path
            $jobseeker = $this->jobseekerModel->findByUserId($_SESSION['user_id']);
            if ($jobseeker) {
                $this->jobseekerModel->updateProfilePhoto($_SESSION['user_id'], $relativePath);
            }
            
            echo json_encode([
                'success' => true, 
                'message' => 'Profile photo updated successfully',
                'image_url' => $relativePath
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to save file']);
        }
        exit;
    }
}
