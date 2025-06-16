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

        // FIXED: Use consistent path to public/uploads/documents/
        $uploadDir = __DIR__ . '/../../public/uploads/documents/';
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
        error_log("=== UPLOAD PROFILE PHOTO DEBUG START ===");
        error_log("POST: " . print_r($_POST, true));
        error_log("FILES: " . print_r($_FILES, true));
        error_log("SESSION: " . print_r($_SESSION, true));
        
        header('Content-Type: application/json');

        // Check session
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != User::ROLE_JOBSEEKER) {
            error_log("ERROR: Unauthorized - user_id: " . ($_SESSION['user_id'] ?? 'not set') . ", role: " . ($_SESSION['role'] ?? 'not set'));
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            exit;
        }
        error_log("✓ Session check passed");

        // Check file upload
        if (!isset($_FILES['profile_picture'])) {
            error_log("ERROR: No profile_picture in FILES array");
            echo json_encode(['success' => false, 'message' => 'No file uploaded - profile_picture field missing']);
            exit;
        }

        if ($_FILES['profile_picture']['error'] !== UPLOAD_ERR_OK) {
            $errorMessages = [
                UPLOAD_ERR_INI_SIZE => 'File too large (exceeds upload_max_filesize)',
                UPLOAD_ERR_FORM_SIZE => 'File too large (exceeds MAX_FILE_SIZE)',
                UPLOAD_ERR_PARTIAL => 'File only partially uploaded',
                UPLOAD_ERR_NO_FILE => 'No file uploaded',
                UPLOAD_ERR_NO_TMP_DIR => 'Missing temporary folder',
                UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk',
                UPLOAD_ERR_EXTENSION => 'File upload stopped by extension'
            ];
            $errorMsg = $errorMessages[$_FILES['profile_picture']['error']] ?? 'Unknown upload error';
            error_log("ERROR: Upload error - " . $_FILES['profile_picture']['error'] . ": " . $errorMsg);
            echo json_encode(['success' => false, 'message' => $errorMsg]);
            exit;
        }
        error_log("✓ File upload check passed");

        $file = $_FILES['profile_picture'];
        error_log("File details: name={$file['name']}, type={$file['type']}, size={$file['size']}, tmp_name={$file['tmp_name']}");

        // Validate file type
        $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        if (!in_array($file['type'], $allowedTypes)) {
            error_log("ERROR: Invalid file type: " . $file['type']);
            echo json_encode(['success' => false, 'message' => 'Invalid file type. Only JPEG, PNG, and GIF are allowed. Detected: ' . $file['type']]);
            exit;
        }
        error_log("✓ File type validation passed");

        // Validate file size (5MB max)
        $maxSize = 5 * 1024 * 1024; // 5MB
        if ($file['size'] > $maxSize) {
            error_log("ERROR: File too large: " . $file['size'] . " bytes");
            echo json_encode(['success' => false, 'message' => 'File too large. Maximum size is 5MB. Your file: ' . round($file['size']/1024/1024, 2) . 'MB']);
            exit;
        }
        error_log("✓ File size validation passed");

        // Check if uploaded file exists
        if (!file_exists($file['tmp_name'])) {
            error_log("ERROR: Temporary file doesn't exist: " . $file['tmp_name']);
            echo json_encode(['success' => false, 'message' => 'Temporary file not found']);
            exit;
        }
        error_log("✓ Temporary file exists");

        // Directory setup
        $uploadDir = __DIR__ . '/../../public/uploads/profile_pictures/';
        error_log("Upload directory: " . $uploadDir);
        error_log("Upload directory exists: " . (file_exists($uploadDir) ? 'YES' : 'NO'));
        
        if (!file_exists($uploadDir)) {
            error_log("Creating upload directory...");
            if (!mkdir($uploadDir, 0755, true)) {
                error_log("ERROR: Failed to create upload directory");
                echo json_encode(['success' => false, 'message' => 'Failed to create upload directory']);
                exit;
            }
            error_log("✓ Upload directory created");
        }

        // Check permissions
        if (!is_writable($uploadDir)) {
            error_log("ERROR: Upload directory not writable");
            echo json_encode(['success' => false, 'message' => 'Upload directory not writable']);
            exit;
        }
        error_log("✓ Upload directory is writable");

        // Try to get and delete old profile picture
        try {
            error_log("Checking for old profile picture...");
            $oldPicture = $this->jobseekerModel->getProfilePicture($_SESSION['user_id']);
            error_log("Old picture from DB: " . ($oldPicture ?? 'null'));
            
            if ($oldPicture) {
                $oldPath = __DIR__ . '/../../public/' . $oldPicture;
                error_log("Old picture path: " . $oldPath);
                if (file_exists($oldPath)) {
                    if (unlink($oldPath)) {
                        error_log("✓ Old picture deleted");
                    } else {
                        error_log("WARNING: Failed to delete old picture");
                    }
                } else {
                    error_log("Old picture file doesn't exist");
                }
            } else {
                error_log("No old picture to delete");
            }
        } catch (Exception $e) {
            error_log("ERROR handling old picture: " . $e->getMessage());
        }

        // Generate filename and paths
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $filename = 'profile_' . $_SESSION['user_id'] . '_' . time() . '.' . $extension;
        $uploadPath = $uploadDir . $filename;
        $dbPath = 'uploads/profile_pictures/' . $filename;

        error_log("Generated filename: " . $filename);
        error_log("Upload path: " . $uploadPath);
        error_log("DB path: " . $dbPath);

        // Move uploaded file
        error_log("Attempting to move file from {$file['tmp_name']} to {$uploadPath}");
        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            error_log("✓ File moved successfully");
            
            // Verify file was actually created
            if (!file_exists($uploadPath)) {
                error_log("ERROR: File was moved but doesn't exist at destination");
                echo json_encode(['success' => false, 'message' => 'File move reported success but file not found']);
                exit;
            }
            
            $fileSize = filesize($uploadPath);
            error_log("✓ File verified at destination, size: " . $fileSize . " bytes");
            
            // Update database
            error_log("Updating database with path: " . $dbPath);
            try {
                $success = $this->jobseekerModel->updateProfilePicture($_SESSION['user_id'], $dbPath);
                error_log("Database update result: " . ($success ? 'SUCCESS' : 'FAILED'));
                
                if ($success) {
                    error_log("✓ SUCCESS: Profile picture uploaded and database updated");
                    echo json_encode([
                        'success' => true, 
                        'message' => 'Profile picture uploaded successfully',
                        'image_url' => '/' . $dbPath,
                        'debug' => [
                            'filename' => $filename,
                            'file_size' => $fileSize,
                            'db_path' => $dbPath
                        ]
                    ]);
                } else {
                    error_log("ERROR: Database update failed - deleting uploaded file");
                    unlink($uploadPath);
                    echo json_encode(['success' => false, 'message' => 'Failed to update database']);
                }
            } catch (Exception $e) {
                error_log("ERROR: Database exception: " . $e->getMessage());
                unlink($uploadPath);
                echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
            }
        } else {
            error_log("ERROR: Failed to move uploaded file");
            $error = error_get_last();
            error_log("Last error: " . print_r($error, true));
            echo json_encode(['success' => false, 'message' => 'Failed to move uploaded file to destination']);
        }
        
        error_log("=== UPLOAD PROFILE PHOTO DEBUG END ===");
        exit;
    }
}
