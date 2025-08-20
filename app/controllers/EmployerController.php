<?php
require_once __DIR__ . '/../models/Employer.php';
require_once __DIR__ . '/../models/User.php';

class EmployerController
{
    private $userModel;
    private $employerModel;

    public function __construct()
    {
        $this->userModel = new User();
        $this->employerModel = new Employer();
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

                // Create user account with employer role (pending status for approval)
                $user_id = $this->userModel->create($email, $hashed_password, User::ROLE_EMPLOYER, 'pending');

                if ($user_id) {
                    // CREATE EMPLOYER RECORD HERE!
                    $employerCreated = $this->employerModel->create(
                        $user_id,
                        'User',        // first_name (default)
                        'Profile',     // last_name (default) 
                        'Employee',    // position (default)
                        null,          // contact_no
                        null,          // middle_name
                        null,          // company_name
                        null           // about_us
                    );

                    if ($employerCreated) {
                        $_SESSION['user_id'] = $user_id;
                        $_SESSION['role'] = User::ROLE_EMPLOYER;
                        $_SESSION['role_name'] = 'employer';
                        $_SESSION['email'] = $email;

                        // Redirect to dashboard
                        header('Location: ?page=employer-dashboard');
                        exit;
                    } else {
                        // If employer creation fails, delete the user record
                        $this->userModel->deleteUser($user_id);
                        $error = 'Failed to create employer profile. Please try again.';
                    }
                } else {
                    $error = 'Failed to create account. Please try again.';
                }
            }
        }

        include __DIR__ . '/../views/employers/signup-employer.php';
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

                if ($user && password_verify($password, $user['password']) && $user['role_id'] == User::ROLE_EMPLOYER) {
                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['role'] = $user['role_id'];
                    $_SESSION['role_name'] = $user['role_name'];
                    $_SESSION['email'] = $user['email'];

                    // Always redirect to dashboard
                    header('Location: ?page=employer-dashboard');
                    exit;
                } else {
                    $error = 'Invalid email or password, or this is not an employer account.';
                }
            }
        }

        include __DIR__ . '/../views/employers/login-employer.php';
    }

    public function dashboard()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != User::ROLE_EMPLOYER) {
            header('Location: ?page=login');
            exit;
        }

        $employer = $this->employerModel->findByUserId($_SESSION['user_id']);
        $hasProfile = $employer && !empty($employer['first_name']);
        $canPostJobs = $this->employerModel->canPostJobs($_SESSION['user_id']);

        include __DIR__ . '/../views/employers/dashboard.php';
    }

    public function completeProfile()
    {
        // Add authentication check
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != User::ROLE_EMPLOYER) {
            header('Location: ?page=login-employer');
            exit;
        }

        $step = isset($_GET['step']) ? (int)$_GET['step'] : 1;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Handle form submission based on step
            switch ($step) {
                case 1:
                    // Handle personal info submission
                    $this->savePersonalInfo();
                    break;
                case 2:
                    // Redirect to business steps since complete-business-profile.php is a choice page
                    header('Location: ?page=complete-employer-business&step=1');
                    exit;
                    break;
            }
            return;
        }

        // Get employer data and calculate completion status
        $employer = $this->employerModel->findByUserId($_SESSION['user_id']);
        if ($employer === false) {
            $employer = [];
        }

        // Initialize variables with default values
        $personalCompleted = false;
        $businessCompleted = false;

        // Calculate personal completion status
        if (!empty($employer)) {
            $personalCompleted = !empty($employer['first_name']) &&
                !empty($employer['last_name']) &&
                !empty($employer['position']) &&
                !empty($employer['contact_no']);
        }

        // Calculate business completion status
        if (!empty($employer) && isset($employer['employer_id'])) {
            $business = $this->employerModel->getBusiness($employer['employer_id']);

            // Check if business profile has essential fields completed
            if ($business) {
                $businessCompleted = !empty($business['business_name']) &&
                    !empty($business['business_desc']) &&
                    !empty($business['business_type']) &&
                    !empty($business['business_industry']) &&
                    !empty($business['business_address']);
            } else {
                $businessCompleted = false;
            }
        }

        $user = $_SESSION;
        $error = $_GET['error'] ?? '';
        $success = $_GET['success'] ?? '';

        // Include the main controller with variables in scope
        include __DIR__ . '/../views/employers/complete-profile.php';
    }

    public function completeBusiness()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != User::ROLE_EMPLOYER) {
            header('Location: ?page=login-employer');
            exit;
        }

        $error = '';
        $success = '';
        $step = isset($_GET['step']) ? (int)$_GET['step'] : 1;

        // Validate step range
        if ($step < 1 || $step > 5) {
            $step = 1;
        }

        // Get existing data
        $employer = $this->employerModel->findByUserId($_SESSION['user_id']);
        if (!$employer) {
            header('Location: ?page=complete-employer-profile');
            exit;
        }

        $business = $this->employerModel->getBusiness($employer['employer_id']);
        $documents = $this->employerModel->getDocuments($employer['employer_id']);

        // Add error/success from URL parameters
        $error = $_GET['error'] ?? $error;
        $success = $_GET['success'] ?? $success;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handleBusinessStepSubmission($step, $employer['employer_id'], $error, $success);
        }

        include __DIR__ . "/../views/employers/profile-completion/complete-business-step{$step}.php";
    }

    private function handleProfileSubmission(&$error, &$success)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'first_name' => trim($_POST['first_name'] ?? ''),
                'middle_name' => trim($_POST['middle_name'] ?? ''),
                'last_name' => trim($_POST['last_name'] ?? ''),
                'position' => trim($_POST['position'] ?? ''),
                'contact_no' => trim($_POST['contact_no'] ?? ''),
                'company_name' => trim($_POST['company_name'] ?? ''),
                'about_us' => trim($_POST['about_us'] ?? '')
            ];

            // Validate required fields
            if (
                empty($data['first_name']) || empty($data['last_name']) ||
                empty($data['position']) || empty($data['contact_no'])
            ) {
                $error = "Please fill in all required fields.";
                return;
            }

            try {
                // Update employer profile
                $result = $this->employerModel->createOrUpdateProfile($_SESSION['user_id'], $data);

                if ($result) {
                    $success = "Profile updated successfully!";
                    header("Location: ?page=complete-employer-business&step=1");
                    exit;
                } else {
                    $error = "Failed to update profile. Please try again.";
                }
            } catch (Exception $e) {
                $error = "An error occurred: " . $e->getMessage();
            }
        }
    }

    private function handleBusinessStepSubmission($step, $employer_id, &$error, &$success)
    {
        $data = $_POST;

        switch ($step) {
            case 1:
                $this->handleBusinessStep1($employer_id, $data, $error, $success);
                break;
            case 2:
                $this->handleBusinessStep2($employer_id, $data, $error, $success);
                break;
            case 3:
                $this->handleBusinessStep3($employer_id, $data, $error, $success);
                break;
            case 4:
                $this->handleBusinessStep4($employer_id, $data, $error, $success);
                break;
            case 5:
                $this->handleBusinessStep5($employer_id, $data, $error, $success);
                break;
            default:
                $error = 'Invalid step.';
        }
    }

    private function handleBusinessStep1($employer_id, $data, &$error, &$success)
    {
        // Check if the form was actually submitted
        if (!isset($data['submit_step1'])) {
            $error = 'Invalid form submission.';
            return;
        }

        $required = ['business_name', 'business_desc'];
        foreach ($required as $field) {
            if (empty($data[$field])) {
                $error = 'Please fill in all required fields.';
                return;
            }
        }

        $businessData = [
            'business_name' => $data['business_name'],
            'business_desc' => $data['business_desc']
        ];

        // Handle business logo upload
        if (isset($_FILES['business_logo']) && $_FILES['business_logo']['error'] === UPLOAD_ERR_OK) {
            $logoPath = $this->handleLogoUpload($_FILES['business_logo'], $error);
            if ($logoPath) {
                $businessData['business_logo'] = $logoPath;
            } else {
                // If there was an error uploading logo, return early
                return;
            }
        }

        // Handle banner image upload
        if (isset($_FILES['banner_image']) && $_FILES['banner_image']['error'] === UPLOAD_ERR_OK) {
            $bannerPath = $this->handleBannerUpload($_FILES['banner_image'], $error);
            if ($bannerPath) {
                $businessData['banner_image'] = $bannerPath;
            } else {
                // If there was an error uploading banner, return early
                return;
            }
        }

        $result = $this->employerModel->createOrUpdateBusiness($employer_id, $businessData);

        if ($result) {
            header('Location: ?page=complete-employer-business&step=2&success=' . urlencode('Business information saved successfully!'));
            exit;
        } else {
            $error = 'Failed to save business information. Please try again.';
        }
    }

    private function handleLogoUpload($file, &$error)
    {
        try {
            // Validate file
            $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            $maxSize = 2 * 1024 * 1024; // 2MB for logos

            $fileInfo = pathinfo($file['name']);
            $extension = strtolower($fileInfo['extension'] ?? '');

            if (!in_array($extension, $allowedTypes)) {
                $error = 'Invalid logo type. Allowed: ' . implode(', ', $allowedTypes);
                return false;
            }

            if ($file['size'] > $maxSize) {
                $error = 'Logo too large. Maximum size: 2MB';
                return false;
            }

            // Validate that it's actually an image
            $imageInfo = getimagesize($file['tmp_name']);
            if ($imageInfo === false) {
                $error = 'Invalid logo image file';
                return false;
            }

            // Get employer info to check for existing logo
            $employer = $this->employerModel->findByUserId($_SESSION['user_id']);
            if (!$employer) {
                $error = 'Employer not found';
                return false;
            }

            // Check for existing logo and delete old file
            $business = $this->employerModel->getBusiness($employer['employer_id']);
            if (!empty($business['business_logo'])) {
                $oldLogoPath = __DIR__ . '/../../public/' . $business['business_logo'];
                if (file_exists($oldLogoPath)) {
                    unlink($oldLogoPath);
                    error_log("DEBUG: Deleted old logo: $oldLogoPath");
                }
            }

            // Create upload directory if it doesn't exist (public/uploads/profile_pictures as requested)
            $uploadDir = __DIR__ . '/../../public/uploads/profile_pictures/';
            if (!is_dir($uploadDir)) {
                if (!mkdir($uploadDir, 0755, true)) {
                    $error = 'Failed to create upload directory';
                    return false;
                }
            }

            // Generate unique filename
            $filename = 'business_logo_' . $_SESSION['user_id'] . '_' . time() . '.' . $extension;
            $filePath = $uploadDir . $filename;

            error_log("DEBUG: Attempting to upload logo to: $filePath");

            // Move uploaded file
            if (move_uploaded_file($file['tmp_name'], $filePath)) {
                error_log("DEBUG: Logo uploaded successfully");
                // Return relative path for database storage
                return 'uploads/profile_pictures/' . $filename;
            } else {
                $error = 'Failed to move uploaded logo file';
                error_log("DEBUG: Failed to move logo file from " . $file['tmp_name'] . " to " . $filePath);
                return false;
            }
        } catch (Exception $e) {
            error_log('Error in handleLogoUpload: ' . $e->getMessage());
            $error = 'Logo upload processing error: ' . $e->getMessage();
            return false;
        }
    }

    private function handleBusinessStep2($employer_id, $data, &$error, &$success)
    {
        // Debug to see what data is being received
        error_log("DEBUG: Step 2 data received: " . print_r($data, true));

        // Check if form was submitted
        if (!isset($data['submit_step2'])) {
            $error = 'Invalid form submission.';
            return;
        }

        $required = ['business_type', 'business_industry', 'business_address', 'business_contact', 'business_size', 'business_established_year'];
        foreach ($required as $field) {
            if (empty($data[$field])) {
                $error = "Please fill in all required fields. Missing: $field";
                error_log("DEBUG: Missing field: $field");
                return;
            }
        }

        $businessData = [
            'business_type' => trim($data['business_type']),
            'business_industry' => trim($data['business_industry']),
            'business_address' => trim($data['business_address']),
            'business_contact' => trim($data['business_contact']),
            'business_size' => trim($data['business_size']), // Changed from business_team_size
            'business_established_year' => trim($data['business_established_year']),
            'business_website' => trim($data['business_website'] ?? ''),
            'business_email' => trim($data['business_email'] ?? '')
        ];

        error_log("DEBUG: Business data to save: " . print_r($businessData, true));

        $result = $this->employerModel->createOrUpdateBusiness($employer_id, $businessData);

        if ($result) {
            error_log("DEBUG: Step 2 data saved successfully");
            header('Location: ?page=complete-employer-business&step=3&success=' . urlencode('Founding information saved!'));
            exit;
        } else {
            error_log("DEBUG: Failed to save step 2 data");
            $error = 'Failed to save founding information. Please try again.';
            return;
        }
    }

    private function handleBusinessStep3($employer_id, $data, &$error, &$success)
    {
        // Debug to see what data is being received
        error_log("DEBUG: Step 3 data received: " . print_r($data, true));

        // Check if form was submitted
        if (!isset($data['submit_step3'])) {
            $error = 'Invalid form submission.';
            return;
        }

        // Collect social media links (all are optional)
        $socials = [];
        if (!empty($data['facebook'])) {
            $socials['facebook'] = trim($data['facebook']);
        }
        if (!empty($data['twitter'])) {
            $socials['twitter'] = trim($data['twitter']);
        }
        if (!empty($data['instagram'])) {
            $socials['instagram'] = trim($data['instagram']);
        }
        if (!empty($data['youtube'])) {
            $socials['youtube'] = trim($data['youtube']);
        }

        // Validate URLs if provided
        foreach ($socials as $platform => $url) {
            if (!filter_var($url, FILTER_VALIDATE_URL)) {
                $error = "Please enter a valid URL for $platform.";
                return;
            }
        }

        $businessData = [
            'business_socials' => json_encode($socials)
        ];

        error_log("DEBUG: Social media data to save: " . print_r($businessData, true));

        $result = $this->employerModel->createOrUpdateBusiness($employer_id, $businessData);

        if ($result) {
            error_log("DEBUG: Step 3 data saved successfully");
            header('Location: ?page=complete-employer-business&step=4&success=' . urlencode('Social media information saved!'));
            exit;
        } else {
            error_log("DEBUG: Failed to save step 3 data");
            $error = 'Failed to save social media information. Please try again.';
            return;
        }
    }

    private function handleBusinessStep4($employer_id, $data, &$error, &$success)
    {
        // Debug
        error_log("DEBUG: Step 4 called with employer_id: $employer_id");
        error_log("DEBUG: POST data: " . print_r($data, true));
        error_log("DEBUG: FILES data: " . print_r($_FILES, true));

        // Check if form was submitted
        if (!isset($data['submit_step4'])) {
            $error = 'Invalid form submission.';
            return;
        }

        // Define allowed document types (must match your database columns exactly)
        $documentTypes = [
            'letter_of_intent' => 'Letter of Intent',
            'company_profile' => 'Company Profile',
            'business_permit' => 'Business Permit',
            'cert_of_no_pending_case' => 'Certificate of No Pending Case',
            'dole_registration' => 'DOLE Registration',
            'cert_no_objection' => 'Certificate of No Objection',
            'poea_reg' => 'POEA Registration',
            'job_vaccancies_qual' => 'Job Vacancies & Qualifications',
            'phil_jobnet_reg' => 'PhilJobNet Registration'
        ];

        $uploadedFiles = [];
        $uploadErrors = [];

        // Process each document type
        foreach ($documentTypes as $type => $label) {
            if (isset($_FILES[$type]) && $_FILES[$type]['error'] === UPLOAD_ERR_OK) {
                error_log("DEBUG: Processing file for type: $type");

                $uploadError = '';
                $filePath = $this->handleDocumentUpload($_FILES[$type], $type, $uploadError);

                if ($filePath) {
                    error_log("DEBUG: File uploaded successfully, saving to database...");

                    // Save to database
                    $result = $this->employerModel->saveDocument($employer_id, $type, $filePath);

                    if ($result) {
                        $uploadedFiles[$type] = $filePath;
                        error_log("DEBUG: Successfully uploaded and saved $label");
                    } else {
                        $uploadErrors[] = "Failed to save $label to database";
                        error_log("DEBUG: Failed to save $label to database");
                    }
                } else {
                    $uploadErrors[] = "Failed to upload $label: $uploadError";
                    error_log("DEBUG: Failed to upload $label: $uploadError");
                }
            } elseif (isset($_FILES[$type]) && $_FILES[$type]['error'] !== UPLOAD_ERR_NO_FILE) {
                $uploadErrors[] = "Error uploading $label: " . $this->getUploadErrorMessage($_FILES[$type]['error']);
            }
        }

        // Check if there were any errors
        if (!empty($uploadErrors)) {
            $error = implode('; ', $uploadErrors);
            error_log("DEBUG: Upload errors: " . $error);
            return;
        }

        // Success - redirect to step 5
        $uploadCount = count($uploadedFiles);
        $successMessage = $uploadCount > 0 ? "Successfully uploaded $uploadCount document(s)!" : "No documents uploaded (this is optional)";

        error_log("DEBUG: Step 4 completed successfully with $uploadCount uploads");
        header('Location: ?page=complete-employer-business&step=5&success=' . urlencode($successMessage));
        exit;
    }

    private function getUploadErrorMessage($errorCode)
    {
        switch ($errorCode) {
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                return 'File too large';
            case UPLOAD_ERR_PARTIAL:
                return 'File upload incomplete';
            case UPLOAD_ERR_NO_TMP_DIR:
                return 'Temporary directory missing';
            case UPLOAD_ERR_CANT_WRITE:
                return 'Cannot write to disk';
            default:
                return 'Unknown upload error';
        }
    }

    private function handleDocumentUpload($file, $type, &$error)
    {
        try {
            error_log("DEBUG: handleDocumentUpload called for type: $type");

            // Validate file
            $allowedTypes = ['pdf'];  // Only PDF for documents
            $maxSize = 5 * 1024 * 1024; // 5MB

            $fileInfo = pathinfo($file['name']);
            $extension = strtolower($fileInfo['extension'] ?? '');

            if (!in_array($extension, $allowedTypes)) {
                $error = 'Invalid file type. Only PDF files are allowed for documents.';
                return false;
            }

            if ($file['size'] > $maxSize) {
                $error = 'File too large. Maximum size: 5MB';
                return false;
            }

            // Get employer info to check for existing file
            $employer = $this->employerModel->findByUserId($_SESSION['user_id']);
            if (!$employer) {
                $error = 'Employer not found';
                return false;
            }

            // Check for existing document and delete old file
            $existingDocuments = $this->employerModel->getDocuments($employer['employer_id']);
            if (!empty($existingDocuments[$type])) {
                $oldFilePath = __DIR__ . '/../../' . $existingDocuments[$type];
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                    error_log("DEBUG: Deleted old file: $oldFilePath");
                }
            }

            // Store documents outside public directory for security
            $uploadDir = __DIR__ . '/../../uploads/documents/';
            if (!is_dir($uploadDir)) {
                if (!mkdir($uploadDir, 0755, true)) {
                    $error = 'Failed to create upload directory';
                    return false;
                }
            }

            // Generate unique filename
            $filename = $type . '_' . $_SESSION['user_id'] . '_' . time() . '.' . $extension;
            $filePath = $uploadDir . $filename;

            error_log("DEBUG: Attempting to move file to: $filePath");

            // Move uploaded file
            if (move_uploaded_file($file['tmp_name'], $filePath)) {
                error_log("DEBUG: File moved successfully");
                // Return relative path for database storage
                return 'uploads/documents/' . $filename;
            } else {
                $error = 'Failed to move uploaded file';
                error_log("DEBUG: Failed to move file from " . $file['tmp_name'] . " to " . $filePath);
                return false;
            }
        } catch (Exception $e) {
            error_log('Error in handleDocumentUpload: ' . $e->getMessage());
            $error = 'Upload processing error';
            return false;
        }
    }

    private function handleBannerUpload($file, &$error)
    {
        try {
            // Validate file
            $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            $maxSize = 5 * 1024 * 1024; // 5MB for banners

            $fileInfo = pathinfo($file['name']);
            $extension = strtolower($fileInfo['extension'] ?? '');

            if (!in_array($extension, $allowedTypes)) {
                $error = 'Invalid banner image type. Allowed: ' . implode(', ', $allowedTypes);
                return false;
            }

            if ($file['size'] > $maxSize) {
                $error = 'Banner image too large. Maximum size: 5MB';
                return false;
            }

            // Validate that it's actually an image
            $imageInfo = getimagesize($file['tmp_name']);
            if ($imageInfo === false) {
                $error = 'Invalid banner image file';
                return false;
            }

            // Get employer info to check for existing banner
            $employer = $this->employerModel->findByUserId($_SESSION['user_id']);
            if (!$employer) {
                $error = 'Employer not found';
                return false;
            }

            // Check for existing banner and delete old file
            $business = $this->employerModel->getBusiness($employer['employer_id']);
            if (!empty($business['banner_image'])) {
                $oldBannerPath = __DIR__ . '/../../public/' . $business['banner_image'];
                if (file_exists($oldBannerPath)) {
                    unlink($oldBannerPath);
                    error_log("DEBUG: Deleted old banner: $oldBannerPath");
                }
            }

            // Create upload directory if it doesn't exist (use same directory as requested)
            $uploadDir = __DIR__ . '/../../public/uploads/profile_pictures/';
            if (!is_dir($uploadDir)) {
                if (!mkdir($uploadDir, 0755, true)) {
                    $error = 'Failed to create upload directory';
                    return false;
                }
            }

            // Generate unique filename
            $filename = 'business_banner_' . $_SESSION['user_id'] . '_' . time() . '.' . $extension;
            $filePath = $uploadDir . $filename;

            error_log("DEBUG: Attempting to upload banner to: $filePath");

            // Move uploaded file
            if (move_uploaded_file($file['tmp_name'], $filePath)) {
                error_log("DEBUG: Banner uploaded successfully");
                // Return relative path for database storage
                return 'uploads/profile_pictures/' . $filename;
            } else {
                $error = 'Failed to move uploaded banner file';
                error_log("DEBUG: Failed to move banner file from " . $file['tmp_name'] . " to " . $filePath);
                return false;
            }
        } catch (Exception $e) {
            error_log('Error in handleBannerUpload: ' . $e->getMessage());
            $error = 'Banner upload processing error: ' . $e->getMessage();
            return false;
        }
    }

    public function profileCompletionSuccess()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != User::ROLE_EMPLOYER) {
            header('Location: ?page=login-employer');
            exit;
        }

        include __DIR__ . '/../views/employers/profile-completion/profile-completion-success.php';
    }

    public function showProfile()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != User::ROLE_EMPLOYER) {
            header('Location: ?page=login-employer');
            exit;
        }

        include __DIR__ . '/../views/employers/profile-employer.php';
    }

    public function uploadProfilePhoto()
    {
        header('Content-Type: application/json');

        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != User::ROLE_EMPLOYER) {
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            exit;
        }

        if (!isset($_FILES['profile_photo']) || $_FILES['profile_photo']['error'] !== UPLOAD_ERR_OK) {
            echo json_encode(['success' => false, 'message' => 'No file uploaded or upload error']);
            exit;
        }

        $file = $_FILES['profile_photo'];

        // Validate file type
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($file['type'], $allowedTypes)) {
            echo json_encode(['success' => false, 'message' => 'Invalid file type. Only JPEG, PNG, and GIF are allowed.']);
            exit;
        }

        // Validate file size (2MB max)
        if ($file['size'] > 2 * 1024 * 1024) {
            echo json_encode(['success' => false, 'message' => 'File size must be less than 2MB.']);
            exit;
        }

        // Create upload directory if it doesn't exist
        $uploadDir = __DIR__ . '/../../uploads/profile_photos/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Generate unique filename
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = 'employer_' . $_SESSION['user_id'] . '_' . time() . '.' . $extension;
        $filepath = $uploadDir . $filename;

        // Move uploaded file
        if (move_uploaded_file($file['tmp_name'], $filepath)) {
            // Update database
            $relativePath = 'uploads/profile_photos/' . $filename;
            $result = $this->employerModel->updateProfilePhoto($_SESSION['user_id'], $relativePath);

            if ($result) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Profile photo updated successfully',
                    'image_url' => $relativePath
                ]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update database']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to upload file']);
        }
        exit;
    }

    public function personalProfile()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->savePersonalInfo();
            return;
        }

        // Get employer data
        $employer = $this->employerModel->findByUserId($_SESSION['user_id']);
        if ($employer === false) {
            $employer = [];
        }

        $user = $_SESSION;
        $error = $_GET['error'] ?? '';
        $success = $_GET['success'] ?? '';

        // Include the personal profile form
        include __DIR__ . '/../views/employers/profile-completion/complete-employer-profile.php';
    }

    public function savePersonalInfo()
    {
        try {
            // Validate required fields
            $requiredFields = ['first_name', 'last_name', 'position', 'contact_no'];
            foreach ($requiredFields as $field) {
                if (empty($_POST[$field])) {
                    header('Location: ?page=complete-employer-profile&step=1&error=' . urlencode('Please fill in all required fields.'));
                    exit;
                }
            }

            // Prepare data
            $data = [
                'user_id' => $_SESSION['user_id'],
                'first_name' => trim($_POST['first_name']),
                'middle_name' => trim($_POST['middle_name'] ?? ''),
                'last_name' => trim($_POST['last_name']),
                'position' => trim($_POST['position']),
                'contact_no' => trim($_POST['contact_no']),
                'company_name' => trim($_POST['company_name'] ?? ''),
                'about_us' => trim($_POST['about_us'] ?? '')
            ];

            // Check if employer profile exists
            $existingEmployer = $this->employerModel->findByUserId($_SESSION['user_id']);

            if ($existingEmployer) {
                // Update existing profile - use consistent parameter name
                $result = $this->employerModel->updateProfile($_SESSION['user_id'], $data);
            } else {
                // Create new profile
                $result = $this->employerModel->createProfile($data);
            }

            if ($result) {
                // Redirect back to choice page with success message
                header('Location: ?page=complete-employer-profile&success=' . urlencode('Personal information saved successfully!'));
            } else {
                header('Location: ?page=employer-personal-profile&error=' . urlencode('Failed to save information. Please try again.'));
            }
        } catch (Exception $e) {
            error_log('Error saving employer personal info: ' . $e->getMessage());
            header('Location: ?page=employer-personal-profile&error=' . urlencode('An error occurred. Please try again.'));
        }
        exit;
    }

    public function saveBusinessInfo()
    {
        // Handle business basic info (step 1)
        header('Location: ?page=complete-employer-business&step=2&success=' . urlencode('Business information saved!'));
        exit;
    }

    public function saveFoundingInfo()
    {
        // Handle founding info (step 2)
        header('Location: ?page=complete-employer-business&step=3&success=' . urlencode('Founding information saved!'));
        exit;
    }

    public function saveSocialMedia()
    {
        // Handle social media (step 3)
        header('Location: ?page=complete-employer-business&step=4&success=' . urlencode('Social media saved!'));
        exit;
    }

    public function saveDocuments()
    {
        // Handle documents (step 4)
        header('Location: ?page=complete-employer-business&step=5&success=' . urlencode('Documents uploaded!'));
        exit;
    }

    public function finalizeProfile()
    {
        // Handle final submission (step 5)
        header('Location: ?page=employer-dashboard&success=' . urlencode('Profile completed successfully!'));
        exit;
    }

    private function handleBusinessStep5($employer_id, $data, &$error, &$success)
    {
        try {
            // Check if the form was submitted with the correct button
            if (!isset($data['submit_business_profile'])) {
                $error = 'Invalid form submission.';
                return false;
            }

            // Mark the profile as completed
            $result = $this->employerModel->markProfileCompleted($employer_id);

            if ($result) {
                error_log("Business profile completed for employer ID: " . $employer_id);

                // Redirect to the CORRECT success page route
                header('Location: ?page=employer-profile-completion-success');
                exit;
            } else {
                $error = "Failed to complete profile. Please try again.";
                return false;
            }
        } catch (Exception $e) {
            error_log('Error in handleBusinessStep5: ' . $e->getMessage());
            $error = "An error occurred while completing your profile.";
            return false;
        }
    }

    public function uploadBusinessLogo()
    {
        header('Content-Type: application/json');

        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != User::ROLE_EMPLOYER) {
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            exit;
        }

        if (!isset($_FILES['business_logo']) || $_FILES['business_logo']['error'] !== UPLOAD_ERR_OK) {
            echo json_encode(['success' => false, 'message' => 'No file uploaded or upload error']);
            exit;
        }

        $file = $_FILES['business_logo'];

        // Validate file type
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!in_array($file['type'], $allowedTypes)) {
            echo json_encode(['success' => false, 'message' => 'Invalid file type. Only JPEG, PNG, GIF, and WEBP are allowed.']);
            exit;
        }

        // Validate file size (2MB max for logos)
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

        // Get employer info
        $employer = $this->employerModel->findByUserId($_SESSION['user_id']);
        if (!$employer) {
            echo json_encode(['success' => false, 'message' => 'Employer not found']);
            exit;
        }

        // Check for existing logo and delete old file
        $business = $this->employerModel->getBusiness($employer['employer_id']);
        if (!empty($business['business_logo'])) {
            $oldLogoPath = __DIR__ . '/../../public/' . $business['business_logo'];
            if (file_exists($oldLogoPath)) {
                unlink($oldLogoPath);
            }
        }

        // Create upload directory if it doesn't exist
        $uploadDir = __DIR__ . '/../../public/uploads/profile_pictures/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Generate unique filename
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = 'business_logo_' . $_SESSION['user_id'] . '_' . time() . '.' . $extension;
        $filepath = $uploadDir . $filename;

        // Move uploaded file
        if (move_uploaded_file($file['tmp_name'], $filepath)) {
            // Update database
            $relativePath = 'uploads/profile_pictures/' . $filename;
            $result = $this->employerModel->createOrUpdateBusiness($employer['employer_id'], [
                'business_logo' => $relativePath
            ]);

            if ($result) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Business logo updated successfully',
                    'image_url' => $relativePath
                ]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update database']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to upload file']);
        }
        exit;
    }
}
