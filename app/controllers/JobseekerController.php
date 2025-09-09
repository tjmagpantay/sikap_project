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
            $first_name = trim($_POST['first_name'] ?? '');
            $last_name = trim($_POST['last_name'] ?? '');
            $contact_number = trim($_POST['contact_number'] ?? '');

            if (empty($email) || empty($password) || empty($first_name) || empty($last_name) || empty($contact_number)) {
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
                    // CREATE JOBSEEKER RECORD
                    $jobseeker_created = $this->jobseekerModel->create(
                        $user_id,
                        $first_name,
                        $last_name,
                        $contact_number,
                        null, // middle_name
                        null, // suffix
                        null, // date_of_birth
                        null, // sex
                        null  // address
                    );

                    if ($jobseeker_created) {
                        $_SESSION['user_id'] = $user_id;
                        $_SESSION['role'] = User::ROLE_JOBSEEKER;
                        $_SESSION['role_name'] = 'jobseeker';
                        $_SESSION['email'] = $email;

                        // Set success message
                        $_SESSION['registration_success'] = true;

                        // Redirect to dashboard
                        header('Location: ?page=jobseeker-dashboard');
                        exit;
                    } else {
                        // If jobseeker creation fails, delete the user record
                        $this->userModel->deleteUser($user_id);
                        $error = 'Failed to create jobseeker profile. Please try again.';
                    }
                } else {
                    $error = 'Failed to create account. Please try again.';
                }
            }
        }

        include __DIR__ . '/../views/jobseekers/signup-jobseeker.php';
    }

    //NEWWWWWWWWWWWWW -----------------------------------------------

    public function login()
    {
        $error = '';
        $formData = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $formData = $_POST;
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            if (empty($email) || empty($password)) {
                $error = 'Please fill in all fields.';
            } else {
                $user = $this->userModel->findByEmail($email);
                if ($user && password_verify($password, $user['password']) && $user['role_id'] == User::ROLE_JOBSEEKER) {
                    // 2FA: Generate OTP
                    $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
                    $_SESSION['login_otp'] = [
                        'user_id' => $user['user_id'],
                        'otp' => $otp,
                        'expires_at' => time() + 300 // 5 minutes
                    ];
                    $_SESSION['pending_user'] = $user;
                    $this->sendOtpEmail($user['email'], $otp);
                    header('Location: ?page=verify-otp');
                    exit;
                } else {
                    $error = 'Invalid email or password, or this is not a jobseeker account.';
                }
            }
        }
        include __DIR__ . '/../views/jobseekers/login-jobseeker.php';
    }

    public function sendOtpEmail($to, $otp)
    {
        $mailConfig = require __DIR__ . '/../../config/mailer.php';
        $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = $mailConfig['host'];
            $mail->SMTPAuth = true;
            $mail->Username = $mailConfig['username'];
            $mail->Password = $mailConfig['password'];
            $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = $mailConfig['port'];
            $mail->setFrom($mailConfig['from_email'], $mailConfig['from_name']);
            $mail->addAddress($to);
            $mail->isHTML(false);
            $mail->Subject = 'Your SIKAP Login OTP';
            $mail->Body = "Your One-Time Password (OTP) is: $otp\nThis code will expire in 5 minutes.";
            $mail->send();
        } catch (\Exception $e) {
            // Optionally log error
        }
    }

    public function verifyLoginOtp()
    {
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $inputOtp = $_POST['otp'] ?? '';
            $otpData = $_SESSION['login_otp'] ?? null;
            if (!$otpData || !is_array($otpData)) {
                $_SESSION['flash'] = 'No OTP session found. Please login again.';
                header('Location: ?page=login-jobseeker');
                exit;
            } elseif (time() > $otpData['expires_at']) {
                $error = 'OTP expired. Please request a new one.';
            } elseif ($inputOtp == $otpData['otp']) {
                // OTP correct, log in user
                $user = $_SESSION['pending_user'];
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['role'] = $user['role_id'];
                $_SESSION['role_name'] = $user['role_name'];
                $_SESSION['email'] = $user['email'];
                unset($_SESSION['login_otp'], $_SESSION['pending_user']);
                header('Location: ?page=jobseeker-dashboard');
                exit;
            } else {
                $error = 'Invalid OTP. Please try again.';
            }
        } else {
            // If not POST, check if OTP session exists
            $otpData = $_SESSION['login_otp'] ?? null;
            if (!$otpData || !is_array($otpData)) {
                $_SESSION['flash'] = 'No OTP session found. Please login again.';
                header('Location: ?page=login-jobseeker');
                exit;
            }
        }
        include __DIR__ . '/../views/jobseekers/verify-otp.php';
    }

    public function resendOtp()
    {
        if (isset($_SESSION['pending_user'])) {
            $user = $_SESSION['pending_user'];
            // Check if resend is allowed (5 min cooldown)
            $lastSent = $_SESSION['login_otp']['last_sent'] ?? 0;
            if (time() - $lastSent < 300) { // 5 minutes
                header('Location: ?page=verify-otp&resent=0&cooldown=1');
                exit;
            }
            $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            $_SESSION['login_otp'] = [
                'user_id' => $user['user_id'],
                'otp' => $otp,
                'expires_at' => time() + 300,
                'last_sent' => time()
            ];
            $this->sendOtpEmail($user['email'], $otp);
            header('Location: ?page=verify-otp&resent=1');
            exit;
        }
        header('Location: ?page=verify-otp&resent=0');
        exit;
    }
    //-----------------------------------------


    public function dashboard()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != User::ROLE_JOBSEEKER) {
            header('Location: ?page=login-jobseeker');
            exit;
        }

        // Get jobseeker profile for navbar AND dashboard
        $jobseeker = $this->getJobseekerData();
        $hasProfile = $jobseeker !== null && !empty($jobseeker['first_name']);

        // Get recent job listings for the dashboard with skill matching
        try {
            $jobseeker_id = $hasProfile ? $jobseeker['jobseeker_id'] : null;

            // UPDATED: Use skill matching version
            if ($jobseeker_id) {
                $jobs = $this->jobPostModel->getAllActiveJobsWithSkillMatch($jobseeker_id);
            } else {
                $jobs = $this->jobPostModel->getAllActiveJobs();
            }

            $jobs = array_slice($jobs, 0, 6);
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
                    'pending' => count(array_filter($applications, function ($app) {
                        return isset($app['application_status']) && $app['application_status'] === 'pending';
                    })),
                    'shortlisted' => count(array_filter($applications, function ($app) {
                        return isset($app['application_status']) && $app['application_status'] === 'shortlisted';
                    })),
                    'hired' => count(array_filter($applications, function ($app) {
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

        // Validate step range - NOW 7 STEPS TOTAL
        if ($step < 1 || $step > 7) {
            $step = 1;
        }

        // Get existing profile data - Controller loads all data
        $jobseeker = $this->getJobseekerData(); // This provides data for navbar
        $user = $this->userModel->findById($_SESSION['user_id']);

        // Load all existing data for the profile steps
        $documents = $this->jobseekerModel->getDocuments($_SESSION['user_id']);
        $education = $this->jobseekerModel->getEducation($_SESSION['user_id']);
        $workExperience = $this->jobseekerModel->getWorkExperience($_SESSION['user_id']);
        $skills = $this->jobseekerModel->getSkills($_SESSION['user_id']);
        $certificates = $this->jobseekerModel->getCertificates($_SESSION['user_id']);

        // Process documents by type for easy access in views
        $resumeDoc = null;
        $cvDoc = null;
        if ($documents !== false) {
            foreach ($documents as $doc) {
                if ($doc['file_type'] === 'resume') {
                    $resumeDoc = $doc;
                } elseif ($doc['file_type'] === 'cv') {
                    $cvDoc = $doc;
                }
            }
        }

        // Process address field for municipal and barangay display (Step 2)
        if ($jobseeker && !empty($jobseeker['address'])) {
            $addressParts = explode(' ', $jobseeker['address'], 2);
            $jobseeker['municipal'] = $addressParts[0] ?? '';
            $jobseeker['barangay'] = $addressParts[1] ?? '';
        }

        // Calculate completion percentage
        $completionPercentage = $this->jobseekerModel->calculateProfileCompletion($_SESSION['user_id']);
        if ($completionPercentage === false) $completionPercentage = 0;

        // Handle form submission
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
            default:
                $error = 'Invalid step.';
        }
    }

// Update the existing handleStep1 method to use the new parsing function
private function handleStep1($data, &$error, &$success)
{
    // Documents - Step 1
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

    // Handle resume/CV upload with parsing
    if (isset($_FILES['resume']) && $_FILES['resume']['error'] === UPLOAD_ERR_OK) {
        // Delete existing resume first
        $this->jobseekerModel->deleteDocumentByType($jobseeker_id, 'resume');
        $this->handleFileUploadWithParsing($_FILES['resume'], 'resume', $jobseeker_id, $error, $success);
    }
    if (isset($_FILES['cv']) && $_FILES['cv']['error'] === UPLOAD_ERR_OK) {
        // Delete existing CV first
        $this->jobseekerModel->deleteDocumentByType($jobseeker_id, 'cv');
        $this->handleFileUploadWithParsing($_FILES['cv'], 'cv', $jobseeker_id, $error, $success);
    }

    if (empty($error)) {
        // Check if we have parsing results to show
        if (isset($_SESSION['show_parsing_results']) && $_SESSION['show_parsing_results']) {
            // Redirect to a special review page or step 2 with parsing results
            header('Location: ?page=complete-jobseeker-profile&step=2&parsed=1');
        } else {
            header('Location: ?page=complete-jobseeker-profile&step=2');
        }
        exit;
    }
}

    private function handleStep2($data, &$error, &$success)
    {
        // Basic Information - Step 2
        // Personal Information - including sex (gender) as required
        $required = ['first_name', 'last_name', 'date_of_birth', 'sex', 'contact_no'];
        foreach ($required as $field) {
            if (empty($data[$field])) {
                $error = 'Please fill in all required fields.';
                return;
            }
        }

        // Create or update jobseeker profile - saving all fields including sex, municipal, barangay
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
    // Education - Step 3
    $jobseeker = $this->jobseekerModel->findByUserId($_SESSION['user_id']);
    $jobseeker_id = $jobseeker['jobseeker_id'];

    // Check if education data already exists
    $existingEducation = $this->jobseekerModel->getEducation($_SESSION['user_id']);

    // Prepare education data with parsed data if available
    $eduData = [
        'school_name' => $data['school_name'] ?? '',
        'education_level' => $data['education_level'] ?? '',
        'field_of_study' => $data['field_of_study'] ?? '',
        'start_date' => null,
        'end_date' => null
    ];

    // Handle date conversion
    if (!empty($data['start_year'])) {
        $eduData['start_date'] = $data['start_year'] . '-01-01';
    }
    if (!empty($data['end_year'])) {
        $eduData['end_date'] = $data['end_year'] . '-12-31';
    }

    // If no form data but we have parsed data in session, use it
    if (empty($eduData['school_name']) && isset($_SESSION['parsed_resume_data']['education'])) {
        $parsedEdu = $_SESSION['parsed_resume_data']['education'];
        $eduData = [
            'school_name' => $parsedEdu['school_name'] ?? '',
            'education_level' => $parsedEdu['education_level'] ?? '',
            'field_of_study' => $parsedEdu['field_of_study'] ?? '',
            'start_date' => $parsedEdu['start_date'] ?? null,
            'end_date' => $parsedEdu['end_date'] ?? null
        ];
    }

    // Save or update education
    if (!empty($existingEducation)) {
        $this->jobseekerModel->updateEducation($jobseeker_id, $eduData, $existingEducation[0]['education_id']);
    } else {
        $this->jobseekerModel->saveEducation($jobseeker_id, $eduData);
    }

    header('Location: ?page=complete-jobseeker-profile&step=4');
    exit;
}

    private function handleStep4($data, &$error, &$success)
    {
        // Work Experience (Combined Current + Previous) - Step 4
        $jobseeker = $this->jobseekerModel->findByUserId($_SESSION['user_id']);
        $jobseeker_id = $jobseeker['jobseeker_id'];

        // Handle delete action
        if (isset($data['delete_experience'])) {
            $experience_id = $data['experience_id'];
            if ($this->jobseekerModel->deleteWorkExperience($jobseeker_id, $experience_id)) {
                $success = 'Work experience deleted successfully!';
            } else {
                $error = 'Failed to delete work experience.';
            }
            return;
        }

        // Handle update action
        if (isset($data['update_experience'])) {
            $experience_id = $data['experience_id'];
            $experienceType = $data['experience_type'] ?? 'previous';

            $workData = [
                'job_title' => $data['job_title'] ?? 'N/A',
                'company_name' => $data['company_name'] ?? 'N/A',
                'employment_type' => $data['employment_type'] ?? 'N/A',
                'start_date' => $data['start_date'] ?? null,
                'end_date' => $experienceType === 'current' ? null : ($data['end_date'] ?? null),
                'currently_working' => $experienceType === 'current' ? 'Yes' : 'No',
                'experience_type' => $experienceType,
                'responsibilities' => $data['responsibilities'] ?? 'N/A'
            ];

            // Validate current job limit
            if ($experienceType === 'current' && $this->jobseekerModel->hasCurrentJob($jobseeker_id)) {
                // Check if we're updating a different experience to current
                $currentJob = $this->jobseekerModel->getCurrentJob($jobseeker_id);
                if ($currentJob['experience_id'] != $experience_id) {
                    $error = 'You can only have one current job. Please update your existing current job instead.';
                    return;
                }
            }

            if ($this->jobseekerModel->updateWorkExperience($jobseeker_id, $workData, $experience_id)) {
                $success = 'Work experience updated successfully!';
            } else {
                $error = 'Failed to update work experience.';
            }
            return;
        }

        // Handle add new experience
        $experienceType = $data['experience_type'] ?? 'previous';

        // Validate current job limit for new entries
        if ($experienceType === 'current' && $this->jobseekerModel->hasCurrentJob($jobseeker_id)) {
            $error = 'You already have a current job. You can only have one current job at a time.';
            return;
        }

        $workData = [
            'job_title' => $data['job_title'] ?? 'N/A',
            'company_name' => $data['company_name'] ?? 'N/A',
            'employment_type' => $data['employment_type'] ?? 'N/A',
            'start_date' => $data['start_date'] ?? null,
            'end_date' => $experienceType === 'current' ? null : ($data['end_date'] ?? null),
            'currently_working' => $experienceType === 'current' ? 'Yes' : 'No',
            'experience_type' => $experienceType,
            'responsibilities' => $data['responsibilities'] ?? 'N/A'
        ];

        if ($this->jobseekerModel->saveWorkExperience($jobseeker_id, $workData)) {
            $success = 'Work experience added successfully!';
            if (!isset($data['add_another'])) {
                header('Location: ?page=complete-jobseeker-profile&step=5');
                exit;
            }
        } else {
            $error = 'Failed to save work experience.';
        }
    }

// Fix the handleStep5 method

private function handleStep5($data, &$error, &$success)
{
    // Skills - Step 5
    $jobseeker = $this->jobseekerModel->findByUserId($_SESSION['user_id']);
    $jobseeker_id = $jobseeker['jobseeker_id'];

    // Delete existing skills before adding new ones
    $this->jobseekerModel->deleteSkills($jobseeker_id);

    // Handle multiple skills (updated to match new format)
    if (isset($data['skills']) && is_array($data['skills'])) {
        foreach ($data['skills'] as $skillData) {
            // Only save if skill name is provided
            if (!empty($skillData['skill_name'])) {
                $skill = [
                    'skill_name' => $skillData['skill_name'],
                    'proficiency_level' => $skillData['proficiency_level'] ?? 'Intermediate',
                    'esco_uri' => $skillData['esco_uri'] ?? null
                ];
                $this->jobseekerModel->saveSkill($jobseeker_id, $skill);
            }
        }
    }

    // Clear parsed data from session since we've processed it
    unset($_SESSION['parsed_resume_data']);
    unset($_SESSION['show_parsing_results']);

    header('Location: ?page=complete-jobseeker-profile&step=6');
    exit;
}

private function handleStep6($data, &$error, &$success)
{
    // Certificates - Step 6
    // Get jobseeker_id
    $jobseeker = $this->jobseekerModel->findByUserId($_SESSION['user_id']);
    $jobseeker_id = $jobseeker['jobseeker_id'];

    // Delete existing certificates before adding new ones
    $existingCertificates = $this->jobseekerModel->getCertificates($jobseeker_id);
    if (!empty($existingCertificates)) {
        foreach ($existingCertificates as $cert) {
            $stmt = $this->jobseekerModel->getPdo()->prepare("DELETE FROM jobseeker_certificates WHERE certificate_id = ?");
            $stmt->execute([$cert['certificate_id']]);
        }
    }

    // Handle multiple certificates
    if (isset($data['certificates']) && is_array($data['certificates'])) {
        foreach ($data['certificates'] as $certData) {
            // Only save if certificate title is provided
            if (!empty($certData['certificate_title'])) {
                $certificate = [
                    'certificate_title' => $certData['certificate_title'],
                    'issuing_organization' => $certData['issuing_organization'] ?? 'Unknown',
                    'date_issued' => $certData['date_issued'] ?? date('Y-m-d')
                ];
                $this->jobseekerModel->saveCertificate($jobseeker_id, $certificate);
            }
        }
    }

    // Clear parsed data from session since we've processed it
    unset($_SESSION['parsed_resume_data']);
    unset($_SESSION['show_parsing_results']);

    header('Location: ?page=complete-jobseeker-profile&step=7');
    exit;
}


    private function handleStep7($data, &$error, &$success)
    {
        // Review & Complete - Step 7
        // Mark profile as completed and redirect to success page
        $this->jobseekerModel->markProfileComplete($_SESSION['user_id']);
        header('Location: ?page=profile-completion-success');
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
                'uploads/documents/' . $fileName,
                $type,
                $file['name']
            );
            $success = ucfirst($type) . ' uploaded successfully!';
            return true;
        } else {
            $error = 'Failed to upload file.';
            return false;
        }
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

        // Get jobseeker profile data - ALL data for the view
        $jobseeker = $this->getJobseekerData();
        $user = $this->userModel->findById($_SESSION['user_id']);

        // Get all profile data for display
        $education = $this->jobseekerModel->getEducation($_SESSION['user_id']);
        $workExperience = $this->jobseekerModel->getWorkExperience($_SESSION['user_id']);
        $skills = $this->jobseekerModel->getSkills($_SESSION['user_id']);
        $certificates = $this->jobseekerModel->getCertificates($_SESSION['user_id']);

        // Convert false results to empty arrays to prevent errors
        if ($education === false) $education = [];
        if ($workExperience === false) $workExperience = [];
        if ($skills === false) $skills = [];
        if ($certificates === false) $certificates = [];

        // Calculate profile completion percentage
        $completionPercentage = $this->jobseekerModel->calculateProfileCompletion($_SESSION['user_id']);
        if ($completionPercentage === false) $completionPercentage = 0;

        // Get hired applications for the applications tab
        require_once __DIR__ . '/../models/JobApplication.php';
        $jobApplicationModel = new JobApplication();
        $hiredApplications = [];

        if ($jobseeker && $jobseeker['jobseeker_id']) {
            $hiredApplications = $jobApplicationModel->getApplicationsByJobseekerAndStatus($jobseeker['jobseeker_id'], 'hired');
        }

        // Include the profile view with all data
        include __DIR__ . '/../views/jobseekers/profile-jobseeker.php';
    }

    public function uploadProfilePhoto()
    {
        header('Content-Type: application/json');

        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != User::ROLE_JOBSEEKER) {
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            exit;
        }

        if (!isset($_FILES['profile_picture']) || $_FILES['profile_picture']['error'] !== UPLOAD_ERR_OK) {
            echo json_encode(['success' => false, 'message' => 'No file uploaded or upload error']);
            exit;
        }

        $file = $_FILES['profile_picture'];

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

        // Get jobseeker info for navbar AND functionality
        $jobseeker = $this->getJobseekerData();
        if (!$jobseeker || empty($jobseeker['first_name'])) {
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

    // Add this method to load jobseeker data for all views
    private function getJobseekerData()
    {
        $jobseeker = $this->jobseekerModel->findByUserId($_SESSION['user_id']);

        // Ensure jobseeker data is available for navbar
        if ($jobseeker === false) {
            $jobseeker = [
                'first_name' => '',
                'last_name' => '',
                'profile_picture' => ''
            ];
        }

        return $jobseeker;
    }

    // Add these new methods for AJAX operations
    public function deleteWorkExperience()
    {
        header('Content-Type: application/json');

        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != User::ROLE_JOBSEEKER) {
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            exit;
        }

        $experience_id = $_POST['experience_id'] ?? null;
        if (!$experience_id) {
            echo json_encode(['success' => false, 'message' => 'Experience ID is required']);
            exit;
        }

        $jobseeker = $this->jobseekerModel->findByUserId($_SESSION['user_id']);
        if (!$jobseeker) {
            echo json_encode(['success' => false, 'message' => 'Jobseeker profile not found']);
            exit;
        }

        $result = $this->jobseekerModel->deleteWorkExperience($jobseeker['jobseeker_id'], $experience_id);

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Work experience deleted successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete work experience']);
        }
        exit;
    }

    public function getWorkExperience()
    {
        header('Content-Type: application/json');

        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != User::ROLE_JOBSEEKER) {
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            exit;
        }

        $experience_id = $_GET['experience_id'] ?? null;
        if (!$experience_id) {
            echo json_encode(['success' => false, 'message' => 'Experience ID is required']);
            exit;
        }

        $jobseeker = $this->jobseekerModel->findByUserId($_SESSION['user_id']);
        if (!$jobseeker) {
            echo json_encode(['success' => false, 'message' => 'Jobseeker profile not found']);
            exit;
        }

        $experience = $this->jobseekerModel->getWorkExperienceById($jobseeker['jobseeker_id'], $experience_id);

        if ($experience) {
            echo json_encode(['success' => true, 'data' => $experience]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Work experience not found']);
        }
        exit;
    }

    public function exploreCompanies()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != User::ROLE_JOBSEEKER) {
            header('Location: ?page=login-jobseeker');
            exit;
        }

        // Get jobseeker profile for navbar
        $jobseeker = $this->getJobseekerData();

        // Get companies/employers data
        require_once __DIR__ . '/../models/Employer.php';
        $employerModel = new Employer();
        $employers = $employerModel->getAllVerifiedEmployersWithJobCount();

        include __DIR__ . '/../views/jobseekers/explore-companies.php';
    }

    public function programsJobseeker()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != User::ROLE_JOBSEEKER) {
            header('Location: ?page=login-jobseeker');
            exit;
        }

        // Get jobseeker profile for navbar
        $jobseeker = $this->getJobseekerData();

        // Get events data
        require_once __DIR__ . '/EventProgramController.php';
        $eventController = new EventProgramController();
        $allEvents = $eventController->getActiveEvents();

        include __DIR__ . '/../views/jobseekers/programs-jobseeker.php';
    }

    public function viewEmployerProfile()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != User::ROLE_JOBSEEKER) {
            header('Location: ?page=login-jobseeker');
            exit;
        }

        // Get jobseeker profile for navbar
        $jobseeker = $this->getJobseekerData();

        // Get employer data
        $employer_id = $_GET['employer_id'] ?? null;
        if (!$employer_id) {
            header('Location: ?page=explore-companies');
            exit;
        }

        require_once __DIR__ . '/../models/Employer.php';
        $employerModel = new Employer();
        $employer = $employerModel->getDetailedEmployerProfile($employer_id);

        if (!$employer) {
            header('Location: ?page=explore-companies');
            exit;
        }

        // Get active jobs for this employer
        require_once __DIR__ . '/../models/JobPost.php';
        $jobModel = new JobPost();
        $activeJobs = $jobModel->getActiveJobsByEmployer($employer_id);

        include __DIR__ . '/../views/jobseekers/view-employer-profile.php';
    }

    public function profileJobseeker()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != User::ROLE_JOBSEEKER) {
            header('Location: ?page=login-jobseeker');
            exit;
        }

        // Get jobseeker profile for navbar
        $jobseeker = $this->getJobseekerData();

        // Get other profile data (education, work experience, etc.)
        // ... your existing profile data code ...

        // Get hired applications for the applications tab
        require_once __DIR__ . '/../models/JobApplication.php';
        $jobApplicationModel = new JobApplication();
        $hiredApplications = $jobApplicationModel->getApplicationsByJobseekerAndStatus($_SESSION['jobseeker_id'], 'hired');

        include __DIR__ . '/../views/jobseekers/profile-jobseeker.php';
    }

    public function profileTabContent()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != User::ROLE_JOBSEEKER) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }

        $tab = $_GET['tab'] ?? 'profile';

        // Get jobseeker data
        $jobseeker = $this->getJobseekerData();

        // Route to appropriate tab content based on the tab parameter
        switch ($tab) {
            case 'profile':
                $this->loadProfileTab($jobseeker);
                break;
            case 'documents':
                $this->loadDocumentsTab($jobseeker);
                break;
            case 'applications':
                $this->loadApplicationsTab($jobseeker);
                break;
            default:
                $this->loadProfileTab($jobseeker);
                break;
        }
        exit;
    }

    private function loadProfileTab($jobseeker)
    {
        // Load all profile data
        $education = $this->jobseekerModel->getEducation($_SESSION['user_id']);
        $workExperience = $this->jobseekerModel->getWorkExperience($_SESSION['user_id']);
        $skills = $this->jobseekerModel->getSkills($_SESSION['user_id']);
        $certificates = $this->jobseekerModel->getCertificates($_SESSION['user_id']);

        // Convert false results to empty arrays
        if ($education === false) $education = [];
        if ($workExperience === false) $workExperience = [];
        if ($skills === false) $skills = [];
        if ($certificates === false) $certificates = [];
        if ($jobseeker === false) {
            $jobseeker = ['first_name' => '', 'last_name' => '', 'middle_name' => '', 'suffix' => '', 'date_of_birth' => null, 'sex' => '', 'address' => '', 'contact_no' => ''];
        }

        include __DIR__ . '/../views/jobseekers/profile-components/profile-content.php';
    }

    private function loadDocumentsTab($jobseeker)
    {
        $documents = $this->jobseekerModel->getDocuments($_SESSION['user_id']);
        if ($documents === false) $documents = [];

        include __DIR__ . '/../views/jobseekers/profile-components/documents-content.php';
    }

    private function loadApplicationsTab($jobseeker)
    {
        // Get hired applications through the controller (proper MVC)
        $hiredApplications = [];

        if ($jobseeker && $jobseeker['jobseeker_id']) {
            require_once __DIR__ . '/../models/JobApplication.php';
            $jobApplicationModel = new JobApplication();
            $hiredApplications = $jobApplicationModel->getApplicationsByJobseekerAndStatus($jobseeker['jobseeker_id'], 'hired');
        }

        include __DIR__ . '/../views/jobseekers/profile-components/applications-contents.php';
    }

    private function handleFileUploadWithParsing($file, $type, $jobseeker_id, &$error, &$success)
{
    $allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
    $maxSize = 5 * 1024 * 1024; // 5MB

    if (!in_array($file['type'], $allowedTypes)) {
        $error = 'Invalid file type. Only PDF, DOC, and DOCX files are allowed.';
        return false;
    }

    if ($file['size'] > $maxSize) {
        $error = 'File size exceeds 5MB limit.';
        return false;
    }

    // Generate unique filename
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = uniqid() . '_' . time() . '.' . $extension;
    $uploadPath = __DIR__ . '/../../uploads/documents/';
    
    // Ensure directory exists
    if (!file_exists($uploadPath)) {
        mkdir($uploadPath, 0755, true);
    }
    
    $filepath = $uploadPath . $filename;
    $relativePath = 'uploads/documents/' . $filename;

    if (move_uploaded_file($file['tmp_name'], $filepath)) {
        // Save to database
        $result = $this->jobseekerModel->saveDocument($jobseeker_id, $relativePath, $type, $file['name']);
        
        if ($result) {
            $success = ucfirst($type) . ' uploaded successfully!';
            
            // Attempt to parse resume if it's a PDF and type is 'resume'
            if ($type === 'resume' && strtolower($extension) === 'pdf') {
                $this->attemptResumeParsing($filepath, $_SESSION['user_id'], $success);
            }
            
            return true;
        } else {
            unlink($filepath); // Delete file if database save failed
            $error = 'Database error occurred while saving file.';
            return false;
        }
    } else {
        $error = 'Failed to upload file.';
        return false;
    }
}

private function attemptResumeParsing($filePath, $userId, &$success)
{
    try {
        require_once __DIR__ . '/../models/ResumeParser.php';
        $parser = new ResumeParser();
        
        // Parse the resume
        $parsedData = $parser->parseResumeFile($filePath);
        
        // Update jobseeker profile with parsed data
        $result = $parser->updateJobseekerProfileFromParsedData($userId, $parsedData);
        
        if ($result['success']) {
            $success .= ' Resume data has been automatically extracted and used to pre-fill your profile!';
            
            // Store parsed data in session for user review
            $_SESSION['parsed_resume_data'] = $parsedData;
            $_SESSION['show_parsing_results'] = true;
        } else {
            error_log("Resume parsing failed: " . $result['message']);
            $success .= ' (Note: Automatic data extraction was not available for this file)';
        }
        
    } catch (Exception $e) {
        error_log("Resume parsing error: " . $e->getMessage());
        $success .= ' (Note: Automatic data extraction was not available for this file)';
    }
}

// Add a new method to handle parsed data review
public function reviewParsedData()
{
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] != User::ROLE_JOBSEEKER) {
        header('Location: ?page=login-jobseeker');
        exit;
    }

    if (!isset($_SESSION['parsed_resume_data'])) {
        header('Location: ?page=complete-jobseeker-profile&step=1');
        exit;
    }

    $parsedData = $_SESSION['parsed_resume_data'];
    $jobseeker = $this->getJobseekerData();

    // Handle form submission to accept or modify parsed data
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['accept_parsed_data'])) {
            // User accepts the parsed data, clear session and continue
            unset($_SESSION['parsed_resume_data']);
            unset($_SESSION['show_parsing_results']);
            header('Location: ?page=complete-jobseeker-profile&step=2');
            exit;
        } elseif (isset($_POST['modify_data'])) {
            // User wants to modify, keep data in session for pre-filling
            header('Location: ?page=complete-jobseeker-profile&step=2&modify=1');
            exit;
        }
    }

    include __DIR__ . '/../views/jobseekers/profile-completion/review-parsed-data.php';
}

}
