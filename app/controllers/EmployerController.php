<?php
require_once __DIR__ . '/../models/Employer.php';
require_once __DIR__ . '/../models/User.php';

class EmployerController
{
    private $employerModel;
    private $userModel;

    public function __construct()
    {
        $this->employerModel = new Employer();
        $this->userModel = new User();
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
                    $_SESSION['user_id'] = $user_id;
                    $_SESSION['role'] = User::ROLE_EMPLOYER;
                    $_SESSION['role_name'] = 'employer';
                    $_SESSION['email'] = $email;

                    // Redirect directly to dashboard
                    header('Location: ?page=employer-dashboard');
                    exit;
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
            header('Location: ?page=login-employer');
            exit;
        }

        // Check if profile exists
        $employer = $this->employerModel->findByUserId($_SESSION['user_id']);
        $hasProfile = ($employer !== false);

        // Get user info for display
        $user = $this->userModel->findById($_SESSION['user_id']);

        include __DIR__ . '/../views/employers/dashboard.php';
    }

    public function completeProfile()
    {
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

        // Get employer data
        $employer = $this->employerModel->findByUserId($_SESSION['user_id']);
        if ($employer === false) {
            $employer = [];
        }

        $user = $_SESSION;
        $error = $_GET['error'] ?? '';
        $success = $_GET['success'] ?? '';

        // Include the main controller
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

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handleBusinessStepSubmission($step, $employer['employer_id'], $error, $success);
        }

        include __DIR__ . "/../views/employers/complete-business-step{$step}.php";
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
        }
    }

    private function handleBusinessStep1($employer_id, $data, &$error, &$success)
    {
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

        // Handle banner image upload
        if (isset($_FILES['banner_image']) && $_FILES['banner_image']['error'] === UPLOAD_ERR_OK) {
            $bannerPath = $this->handleBannerUpload($_FILES['banner_image'], $error);
            if ($bannerPath) {
                $businessData['banner_image'] = $bannerPath;
            }
        }

        $this->employerModel->createOrUpdateBusiness($employer_id, $businessData);
        header('Location: ?page=complete-employer-business&step=2');
        exit;
    }

    private function handleBusinessStep2($employer_id, $data, &$error, &$success)
    {
        $required = ['business_type', 'business_industry', 'business_address', 'business_contact', 'business_size', 'business_established_year'];
        foreach ($required as $field) {
            if (empty($data[$field])) {
                $error = 'Please fill in all required fields.';
                return;
            }
        }

        $businessData = [
            'business_type' => $data['business_type'],
            'business_industry' => $data['business_industry'],
            'business_address' => $data['business_address'],
            'business_contact' => $data['business_contact'],
            'business_size' => $data['business_size'], // Changed from business_team_size
            'business_established_year' => $data['business_established_year'],
            'business_website' => $data['business_website'] ?? '',
            'business_email' => $data['business_email'] ?? ''
        ];

        $this->employerModel->createOrUpdateBusiness($employer_id, $businessData);
        header('Location: ?page=complete-employer-business&step=3');
        exit;
    }

    private function handleBusinessStep3($employer_id, $data, &$error, &$success)
    {
        // Social Media Links
        $socials = [];
        if (!empty($data['facebook'])) $socials['facebook'] = $data['facebook'];
        if (!empty($data['twitter'])) $socials['twitter'] = $data['twitter'];
        if (!empty($data['instagram'])) $socials['instagram'] = $data['instagram'];
        if (!empty($data['youtube'])) $socials['youtube'] = $data['youtube'];

        $businessData = [
            'business_socials' => json_encode($socials)
        ];

        $this->employerModel->createOrUpdateBusiness($employer_id, $businessData);
        header('Location: ?page=complete-employer-business&step=4');
        exit;
    }

    private function handleBusinessStep4($employer_id, $data, &$error, &$success)
    {
        // Handle document uploads
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

        foreach ($documentTypes as $type => $label) {
            if (isset($_FILES[$type]) && $_FILES[$type]['error'] === UPLOAD_ERR_OK) {
                $filePath = $this->handleDocumentUpload($_FILES[$type], $type, $error);
                if ($filePath) {
                    $this->employerModel->saveDocument($employer_id, $type, $filePath);
                } elseif ($error) {
                    return;
                }
            }
        }

        header('Location: ?page=complete-employer-business&step=5');
        exit;
    }

    private function handleBusinessStep5($employer_id, $data, &$error, &$success)
    {
        // Final review and completion
        header('Location: ?page=employer-profile-completion-success');
        exit;
    }

    private function handleBannerUpload($file, &$error)
    {
        $allowedTypes = ['image/jpeg', 'image/png'];
        $maxSize = 5 * 1024 * 1024; // 5MB

        if (!in_array($file['type'], $allowedTypes)) {
            $error = 'Only JPEG and PNG files are allowed for banner images.';
            return false;
        }

        if ($file['size'] > $maxSize) {
            $error = 'Banner image must be less than 5MB.';
            return false;
        }

        $uploadDir = __DIR__ . '/../../uploads/banners/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $fileName = $_SESSION['user_id'] . '_banner_' . time() . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
        $filePath = $uploadDir . $fileName;

        if (move_uploaded_file($file['tmp_name'], $filePath)) {
            return 'uploads/banners/' . $fileName;
        } else {
            $error = 'Failed to upload banner image.';
            return false;
        }
    }

    private function handleDocumentUpload($file, $type, &$error)
    {
        $allowedTypes = ['application/pdf'];
        $maxSize = 5 * 1024 * 1024; // 5MB

        if (!in_array($file['type'], $allowedTypes)) {
            $error = 'Only PDF files are allowed for documents.';
            return false;
        }

        if ($file['size'] > $maxSize) {
            $error = 'Document must be less than 5MB.';
            return false;
        }

        $uploadDir = __DIR__ . '/../../uploads/documents/employers/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $fileName = $_SESSION['user_id'] . '_' . $type . '_' . time() . '.pdf';
        $filePath = $uploadDir . $fileName;

        if (move_uploaded_file($file['tmp_name'], $filePath)) {
            return 'uploads/documents/employers/' . $fileName;
        } else {
            $error = 'Failed to upload ' . $type . '.';
            return false;
        }
    }

    public function profileCompletionSuccess()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != User::ROLE_EMPLOYER) {
            header('Location: ?page=login-employer');
            exit;
        }

        include __DIR__ . '/../views/employers/profile-completion-success.php';
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
}
