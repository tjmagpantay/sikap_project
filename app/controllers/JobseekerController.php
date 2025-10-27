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
        $config = require __DIR__ . '/../../config/sikap_db.php';
        
        try {
            // FIXED: Add Railway port to DSN
            $dsn = "mysql:host={$config['db_host']};port={$config['db_port']};dbname={$config['db_name']};charset=utf8mb4";
            
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_TIMEOUT => 30
            ];
            
            $pdo = new PDO($dsn, $config['db_user'], $config['db_pass'], $options);
            
            $this->userModel = new User($pdo);
            $this->jobseekerModel = new Jobseeker($pdo);
            $this->jobPostModel = new JobPost($pdo);
            
        } catch (PDOException $e) {
            error_log("JobseekerController database connection failed: " . $e->getMessage());
            throw new Exception("Database connection failed");
        }
    }

    public function signup()
    {
        $error = '';
        $formData = []; // Add form data for repopulation

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';
            $first_name = trim($_POST['first_name'] ?? '');
            $last_name = trim($_POST['last_name'] ?? '');
            $contact_number = trim($_POST['contact_number'] ?? '');

            // Store form data for repopulation on error
            $formData = [
                'email' => $email,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'contact_number' => $contact_number,
                'password' => $password,
                'confirm_password' => $confirm_password
            ];

            // Enhanced validation with character limits
            $validationErrors = $this->validateSignupInput($formData);

            if (!empty($validationErrors)) {
                $error = implode(' ', $validationErrors);
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

    private function validateSignupInput($data)
    {
        $errors = [];

        // First Name validation
        if (empty($data['first_name'])) {
            $errors[] = 'First name is required.';
        } elseif (strlen($data['first_name']) > 50) {
            $errors[] = 'First name cannot exceed 50 characters.';
        }

        // Last Name validation
        if (empty($data['last_name'])) {
            $errors[] = 'Last name is required.';
        } elseif (strlen($data['last_name']) > 50) {
            $errors[] = 'Last name cannot exceed 50 characters.';
        }

        // Contact Number validation
        if (empty($data['contact_number'])) {
            $errors[] = 'Contact number is required.';
        } elseif (strlen($data['contact_number']) > 20) {
            $errors[] = 'Contact number cannot exceed 20 characters.';
        }

        // Email validation
        if (empty($data['email'])) {
            $errors[] = 'Email is required.';
        } elseif (strlen($data['email']) > 255) {
            $errors[] = 'Email cannot exceed 255 characters.';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Please enter a valid email address.';
        }

        // Password validation
        if (empty($data['password'])) {
            $errors[] = 'Password is required.';
        } elseif (strlen($data['password']) < 6) {
            $errors[] = 'Password must be at least 6 characters long.';
        } elseif (strlen($data['password']) > 50) {
            $errors[] = 'Password cannot exceed 50 characters.';
        }

        // Confirm Password validation
        if (empty($data['confirm_password'])) {
            $errors[] = 'Please confirm your password.';
        } elseif (strlen($data['confirm_password']) > 50) {
            $errors[] = 'Confirm password cannot exceed 50 characters.';
        } elseif ($data['password'] !== $data['confirm_password']) {
            $errors[] = 'Passwords do not match.';
        }

        return $errors;
    }

    public function login()
    {
        $error = '';
        $formData = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $formData = $_POST;
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            // Add character limit validation for login
            $validationErrors = $this->validateLoginInput($email, $password);

            if (!empty($validationErrors)) {
                $error = implode(' ', $validationErrors);
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

    private function validateLoginInput($email, $password)
    {
        $errors = [];

        // Email validation
        if (empty($email)) {
            $errors[] = 'Email is required.';
        } elseif (strlen($email) > 255) {
            $errors[] = 'Email cannot exceed 255 characters.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Please enter a valid email address.';
        }

        // Password validation
        if (empty($password)) {
            $errors[] = 'Password is required.';
        } elseif (strlen($password) > 50) {
            $errors[] = 'Password cannot exceed 50 characters.';
        }

        return $errors;
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

    public function dashboard()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != User::ROLE_JOBSEEKER) {
            header('Location: ?page=login-jobseeker');
            exit;
        }

        // Get jobseeker profile for navbar AND dashboard
        $jobseeker = $this->getJobseekerData();
        $hasProfile = $jobseeker !== null && !empty($jobseeker['first_name']);

        // Get recent job listings for the dashboard
        try {
            $jobseeker_id = $hasProfile ? $jobseeker['jobseeker_id'] : null;

            // FIXED: Use standard method instead of non-existent skill matching method
            $jobs = $this->jobPostModel->getAllActiveJobs();

            // Optional: Add basic skill-based sorting if jobseeker has skills
            if ($jobseeker_id && $hasProfile) {
                // Get jobseeker skills for basic matching
                $jobseekerSkills = $this->jobseekerModel->getSkills($_SESSION['user_id']);

                if (!empty($jobseekerSkills)) {
                    // Add a simple skill relevance score to jobs
                    foreach ($jobs as &$job) {
                        $job['skill_match_count'] = 0;

                        // Get job skills (if the method exists)
                        if (method_exists($this->jobPostModel, 'getJobSkills')) {
                            $jobSkills = $this->jobPostModel->getJobSkills($job['job_id']);

                            // Count skill matches
                            foreach ($jobseekerSkills as $userSkill) {
                                foreach ($jobSkills as $jobSkill) {
                                    if (
                                        stripos($jobSkill['skill_name'], $userSkill['skill_name']) !== false ||
                                        stripos($userSkill['skill_name'], $jobSkill['skill_name']) !== false
                                    ) {
                                        $job['skill_match_count']++;
                                    }
                                }
                            }
                        }
                    }

                    // Sort by skill matches (jobs with more matches first)
                    usort($jobs, function ($a, $b) {
                        return $b['skill_match_count'] - $a['skill_match_count'];
                    });
                }
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

        // Load all existing data for the profile steps - MAKE SURE ALL DATA IS LOADED FOR ALL STEPS
        $documents = $this->jobseekerModel->getDocuments($_SESSION['user_id']);
        $education = $this->jobseekerModel->getEducation($_SESSION['user_id']);
        $workExperience = $this->jobseekerModel->getWorkExperience($_SESSION['user_id']);
        $skills = $this->jobseekerModel->getSkills($_SESSION['user_id']); // FIXED: This was missing proper user ID handling
        $certificates = $this->jobseekerModel->getCertificates($_SESSION['user_id']); // FIXED: This was missing proper user ID handling

        // Convert false results to empty arrays to prevent errors in views
        if ($documents === false) $documents = [];
        if ($education === false) $education = [];
        if ($workExperience === false) $workExperience = [];
        if ($skills === false) $skills = [];
        if ($certificates === false) $certificates = [];

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
        $resumeUploaded = false;

        // Handle resume/CV upload with parsing
        if (isset($_FILES['resume']) && $_FILES['resume']['error'] === UPLOAD_ERR_OK) {
            // Delete existing resume first
            $this->jobseekerModel->deleteDocumentByType($jobseeker_id, 'resume');
            $uploadResult = $this->handleFileUploadWithParsing($_FILES['resume'], 'resume', $jobseeker_id, $error, $success);
            if ($uploadResult) {
                $resumeUploaded = true;
            }
        }
        if (isset($_FILES['cv']) && $_FILES['cv']['error'] === UPLOAD_ERR_OK) {
            // Delete existing CV first
            $this->jobseekerModel->deleteDocumentByType($jobseeker_id, 'cv');
            $this->handleFileUploadWithParsing($_FILES['cv'], 'cv', $jobseeker_id, $error, $success);
        }

        if (empty($error)) {
            // FIXED: Set fresh upload flag every time resume is uploaded
            if ($resumeUploaded) {
                $_SESSION['fresh_resume_upload'] = true; // New flag for fresh uploads
                $_SESSION['show_parsing_results'] = true;
                // Add URL parameter to trigger modal
                header('Location: ?page=complete-jobseeker-profile&step=2&fresh_upload=1');
            } else {
                // Even if no new upload, but user clicked "Update & Continue", check if they have a resume
                $existingResume = false;
                $documents = $this->jobseekerModel->getDocuments($_SESSION['user_id']);
                if ($documents) {
                    foreach ($documents as $doc) {
                        if ($doc['file_type'] === 'resume') {
                            $existingResume = true;
                            break;
                        }
                    }
                }

                // If they have an existing resume and clicked continue, show modal
                if ($existingResume) {
                    $_SESSION['fresh_resume_upload'] = true;
                    header('Location: ?page=complete-jobseeker-profile&step=2&fresh_upload=1');
                } else {
                    header('Location: ?page=complete-jobseeker-profile&step=2');
                }
            }
            exit;
        }
    }

    private function handleStep2($data, &$error, &$success)
    {
        $required = ['first_name', 'last_name', 'date_of_birth', 'sex', 'contact_no'];
        foreach ($required as $field) {
            if (empty($data[$field])) {
                $error = 'Please fill in all required fields.';
                return;
            }
        }

        $address = isset($data['address']) ? trim($data['address']) : '';

        // FIXED: Convert MM/DD/YYYY to YYYY-MM-DD for database
        $dateOfBirth = $data['date_of_birth'] ?? '';
        if (!empty($dateOfBirth)) {
            // Check if it's in MM/DD/YYYY format
            if (preg_match('/(\d{1,2})\/(\d{1,2})\/(\d{4})/', $dateOfBirth, $match)) {
                $month = str_pad($match[1], 2, '0', STR_PAD_LEFT);
                $day = str_pad($match[2], 2, '0', STR_PAD_LEFT);
                $year = $match[3];
                $dateOfBirth = $year . '-' . $month . '-' . $day;
            }
        }

        // Create or update jobseeker profile - saving all fields including sex, address
        $result = $this->jobseekerModel->createOrUpdateProfile($_SESSION['user_id'], [
            'first_name' => $data['first_name'],
            'middle_name' => $data['middle_name'] ?? '',
            'last_name' => $data['last_name'],
            'suffix' => $data['suffix'] ?? '',
            'date_of_birth' => $data['date_of_birth'],
            'sex' => $data['sex'],
            'address' => $address, // FIXED: Use the actual address field
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

        // Check if we are on the current job experience
        $isCurrentJob = isset($data['currently_working']) && $data['currently_working'] === 'Yes';

        // Override based on experience_type radio selection
        if (isset($data['experience_type']) && $data['experience_type'] === 'current') {
            $isCurrentJob = true;
            $data['currently_working'] = 'Yes';
        } elseif (isset($data['experience_type']) && $data['experience_type'] === 'previous') {
            $isCurrentJob = false;
            $data['currently_working'] = 'No';
        }

        // Handle delete action
        if (isset($data['delete_experience'])) {
            $experience_id = $data['experience_id'];
            if ($this->jobseekerModel->deleteWorkExperience($jobseeker_id, $experience_id)) {
                $_SESSION['success_message'] = 'Work experience deleted successfully!';
            } else {
                $_SESSION['error_message'] = 'Failed to delete work experience.';
            }
            header('Location: ?page=complete-jobseeker-profile&step=4');
            exit;
        }

        // Handle update action
        if (isset($data['update_experience'])) {
            $experience_id = $data['experience_id'];

            // Validate required fields for update
            if (empty($data['job_title']) || empty($data['company_name'])) {
                $_SESSION['error_message'] = 'Please fill in Job Title and Company Name.';
                header('Location: ?page=complete-jobseeker-profile&step=4');
                exit;
            }

            $workData = [
                'job_title' => trim($data['job_title']),
                'company_name' => trim($data['company_name']),
                'employment_type' => $data['employment_type'] ?? 'full-time',
                'start_date' => !empty($data['start_date']) ? $data['start_date'] : null,
                'end_date' => $isCurrentJob ? null : (!empty($data['end_date']) ? $data['end_date'] : null),
                'currently_working' => $isCurrentJob ? 'Yes' : 'No',
                'experience_type' => $isCurrentJob ? 'current' : 'previous',
                'responsibilities' => trim($data['responsibilities'] ?? '')
            ];

            // Validate current job limit
            if ($isCurrentJob && $this->jobseekerModel->hasCurrentJob($jobseeker_id)) {
                // Check if we're updating a different experience to current
                $currentJob = $this->jobseekerModel->getCurrentJob($jobseeker_id);
                if ($currentJob && $currentJob['experience_id'] != $experience_id) {
                    $_SESSION['error_message'] = 'You can only have one current job. Please update your existing current job instead.';
                    header('Location: ?page=complete-jobseeker-profile&step=4');
                    exit;
                }
            }

            if ($this->jobseekerModel->updateWorkExperience($jobseeker_id, $workData, $experience_id)) {
                $_SESSION['success_message'] = 'Work experience updated successfully!';
            } else {
                $_SESSION['error_message'] = 'Failed to update work experience.';
            }

            header('Location: ?page=complete-jobseeker-profile&step=4');
            exit;
        }

        // Handle "Next Step" button - allow continuing without experience
        if (isset($data['submit_step4'])) {
            // Check if user is trying to continue without adding any experience data
            $hasExistingExperience = !empty($this->jobseekerModel->getWorkExperience($_SESSION['user_id']));
            $isAddingNewExperience = !empty($data['job_title']) && !empty($data['company_name']);

            // If no existing experience and no new experience being added, just continue
            if (!$hasExistingExperience && !$isAddingNewExperience) {
                header('Location: ?page=complete-jobseeker-profile&step=5');
                exit;
            }

            // If adding new experience, validate and save it first
            if ($isAddingNewExperience) {
                // Validate current job limit for new entries
                if ($isCurrentJob && $this->jobseekerModel->hasCurrentJob($jobseeker_id)) {
                    $_SESSION['error_message'] = 'You already have a current job. You can only have one current job at a time.';
                    header('Location: ?page=complete-jobseeker-profile&step=4');
                    exit;
                }

                $workData = [
                    'job_title' => trim($data['job_title']),
                    'company_name' => trim($data['company_name']),
                    'employment_type' => $data['employment_type'] ?? 'full-time',
                    'start_date' => !empty($data['start_date']) ? $data['start_date'] : null,
                    'end_date' => $isCurrentJob ? null : (!empty($data['end_date']) ? $data['end_date'] : null),
                    'currently_working' => $isCurrentJob ? 'Yes' : 'No',
                    'experience_type' => $isCurrentJob ? 'current' : 'previous',
                    'responsibilities' => trim($data['responsibilities'] ?? '')
                ];

                if (!$this->jobseekerModel->saveWorkExperience($jobseeker_id, $workData)) {
                    $_SESSION['error_message'] = 'Failed to save work experience.';
                    header('Location: ?page=complete-jobseeker-profile&step=4');
                    exit;
                }

                $_SESSION['success_message'] = 'Work experience saved successfully!';
            }

            // Continue to next step
            header('Location: ?page=complete-jobseeker-profile&step=5');
            exit;
        }

        // Handle "Add Another" button
        if (isset($data['add_another'])) {

            // Validate required fields
            if (empty($data['job_title']) || empty($data['company_name'])) {
                $_SESSION['error_message'] = 'Please fill in Job Title and Company Name to add experience.';
                header('Location: ?page=complete-jobseeker-profile&step=4');
                exit;
            }

            // Validate current job limit for new entries
            if ($isCurrentJob && $this->jobseekerModel->hasCurrentJob($jobseeker_id)) {
                $_SESSION['error_message'] = 'You already have a current job. You can only have one current job at a time.';
                header('Location: ?page=complete-jobseeker-profile&step=4');
                exit;
            }

            $workData = [
                'job_title' => trim($data['job_title']),
                'company_name' => trim($data['company_name']),
                'employment_type' => $data['employment_type'] ?? 'full-time',
                'start_date' => !empty($data['start_date']) ? $data['start_date'] : null,
                'end_date' => $isCurrentJob ? null : (!empty($data['end_date']) ? $data['end_date'] : null),
                'currently_working' => $isCurrentJob ? 'Yes' : 'No',
                'experience_type' => $isCurrentJob ? 'current' : 'previous',
                'responsibilities' => trim($data['responsibilities'] ?? '')
            ];

            if ($this->jobseekerModel->saveWorkExperience($jobseeker_id, $workData)) {
                $_SESSION['success_message'] = 'Work experience added successfully!';
            } else {
                $_SESSION['error_message'] = 'Failed to save work experience.';
            }

            header('Location: ?page=complete-jobseeker-profile&step=4');
            exit;
        }
    }

    private function handleStep5($data, &$error, &$success)
    {
        // Skills - Step 5
        $jobseeker = $this->jobseekerModel->findByUserId($_SESSION['user_id']);
        $jobseeker_id = $jobseeker['jobseeker_id'];

        // Handle "Next Step" button - allow continuing without skills
        if (isset($data['submit_step5'])) {

            // Check if user is trying to continue without adding any skills
            $hasExistingSkills = !empty($this->jobseekerModel->getSkills($_SESSION['user_id']));
            $isAddingNewSkills = !empty($data['skills']);


            // Process new skills if provided
            if ($isAddingNewSkills) {
                $processedCount = 0;

                // Delete existing skills before adding new ones
                $this->jobseekerModel->deleteSkills($jobseeker_id);

                foreach ($data['skills'] as $index => $skillData) {

                    // Only save if skill name is provided
                    if (!empty($skillData['skill_name'])) {
                        $skill = [
                            'skill_name' => trim($skillData['skill_name']),
                            'proficiency_level' => $skillData['proficiency_level'] ?? 'Intermediate',
                            'esco_uri' => $skillData['esco_uri'] ?? null
                        ];

                        $result = $this->jobseekerModel->saveSkill($jobseeker_id, $skill);
                        if ($result) {
                            $processedCount++;
                        }
                    }
                }

                if ($processedCount > 0) {
                    $_SESSION['success_message'] = "Successfully saved $processedCount skill(s)!";
                }
            }

            // Clear parsed data from session since we've processed it
            unset($_SESSION['parsed_resume_data']);
            unset($_SESSION['show_parsing_results']);

            // Continue to next step
            header('Location: ?page=complete-jobseeker-profile&step=6');
            exit;
        }

        // Handle "Save Skills" button
        if (isset($data['save_skills'])) {

            if (empty($data['skills'])) {
                $error = 'Please add at least one skill to save.';
                return;
            }

            $processedCount = 0;

            // Delete existing skills before adding new ones
            $this->jobseekerModel->deleteSkills($jobseeker_id);

            foreach ($data['skills'] as $skillData) {
                // Only save if skill name is provided
                if (!empty($skillData['skill_name'])) {
                    $skill = [
                        'skill_name' => trim($skillData['skill_name']),
                        'proficiency_level' => $skillData['proficiency_level'] ?? 'Intermediate',
                        'esco_uri' => $skillData['esco_uri'] ?? null
                    ];

                    $result = $this->jobseekerModel->saveSkill($jobseeker_id, $skill);
                    if ($result) {
                        $processedCount++;
                    }
                }
            }

            if ($processedCount > 0) {
                $success = "Successfully saved $processedCount skill(s)!";
            } else {
                $error = 'No skills were saved. Please check your input.';
            }

            return; // Stay on the same step to show success/error message
        }
    }

    private function processSkills($skillsData, $jobseeker_id)
    {
        $processedCount = 0;

        // Delete existing skills
        $this->jobseekerModel->deleteSkills($jobseeker_id);

        foreach ($skillsData as $skillData) {
            if (!empty($skillData['skill_name'])) {
                $skill = [
                    'skill_name' => trim($skillData['skill_name']),
                    'proficiency_level' => $skillData['proficiency_level'] ?? 'Intermediate',
                    'esco_uri' => $skillData['esco_uri'] ?? null
                ];

                if ($this->jobseekerModel->saveSkill($jobseeker_id, $skill)) {
                    $processedCount++;
                }
            }
        }

        return $processedCount;
    }

    private function handleStep6($data, &$error, &$success)
    {
        // Certificates - Step 6
        $jobseeker = $this->jobseekerModel->findByUserId($_SESSION['user_id']);
        $jobseeker_id = $jobseeker['jobseeker_id'];

        if (isset($data['certificates']) && is_array($data['certificates'])) {
            $processedCount = 0;
            $deletedCount = 0;
            $updatedCount = 0;
            $addedCount = 0;

            foreach ($data['certificates'] as $index => $certData) {

                // Skip completely empty certificates
                if (empty($certData['certificate_title']) && empty($certData['certificate_id'])) {
                    continue;
                }

                // Handle deletion of existing certificates
                if (isset($certData['certificate_id']) && isset($certData['delete']) && $certData['delete'] == '1') {

                    $result = $this->jobseekerModel->deleteCertificate($jobseeker_id, $certData['certificate_id']);

                    if ($result) {
                        $deletedCount++;
                    } else {
                        error_log("ERROR: Failed to delete certificate ID: " . $certData['certificate_id']);
                    }
                    continue;
                }

                // Handle updating existing certificates
                if (isset($certData['certificate_id']) && !empty($certData['certificate_title'])) {

                    $updateData = [
                        'certificate_title' => trim($certData['certificate_title']),
                        'issuing_organization' => !empty($certData['issuing_organization']) ? trim($certData['issuing_organization']) : 'Unknown',
                        'date_issued' => !empty($certData['date_issued']) ? $certData['date_issued'] : date('Y-m-d')
                    ];

                    $result = $this->jobseekerModel->updateCertificateById($certData['certificate_id'], $jobseeker_id, $updateData);

                    if ($result) {
                        $updatedCount++;
                    } else {
                        error_log("ERROR: Failed to update certificate ID: " . $certData['certificate_id']);
                    }
                    continue;
                }

                // Handle adding new certificates (no certificate_id)
                if (!isset($certData['certificate_id']) && !empty($certData['certificate_title'])) {

                    $certificate = [
                        'certificate_title' => trim($certData['certificate_title']),
                        'issuing_organization' => !empty($certData['issuing_organization']) ? trim($certData['issuing_organization']) : 'Unknown',
                        'date_issued' => !empty($certData['date_issued']) ? $certData['date_issued'] : date('Y-m-d')
                    ];

                    $result = $this->jobseekerModel->saveCertificate($jobseeker_id, $certificate);

                    if ($result) {
                        $addedCount++;
                    } else {
                        error_log("ERROR: Failed to add new certificate: " . $certificate['certificate_title']);
                    }
                }

                $processedCount++;
            }

            // Set success message based on operations performed
            $messages = [];
            if ($addedCount > 0) $messages[] = "$addedCount certificate(s) added";
            if ($updatedCount > 0) $messages[] = "$updatedCount certificate(s) updated";
            if ($deletedCount > 0) $messages[] = "$deletedCount certificate(s) deleted";

            if (!empty($messages)) {
                $_SESSION['success_message'] = 'Certificates updated successfully! ' . implode(', ', $messages) . '.';
            } else {
                $_SESSION['success_message'] = 'Certificates updated successfully!';
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


    public function profile()
    {
        // Check authentication
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'jobseeker') {
            header('Location: ?page=login');
            exit;
        }

        try {
            // Get jobseeker data
            $jobseeker = $this->jobseekerModel->findByUserId($_SESSION['user_id']);

            // Get all profile data
            $education = $this->jobseekerModel->getEducation($_SESSION['user_id']) ?: [];
            $workExperience = $this->jobseekerModel->getWorkExperience($_SESSION['user_id']) ?: [];
            $skills = $this->jobseekerModel->getSkills($_SESSION['user_id']) ?: [];
            $certificates = $this->jobseekerModel->getCertificates($_SESSION['user_id']) ?: [];
            $documents = $this->jobseekerModel->getDocuments($_SESSION['user_id']) ?: [];

            // Calculate completion percentage (ensure it's never above 100%)
            $completionPercentage = $this->jobseekerModel->calculateProfileCompletion($_SESSION['user_id']);
            $completionPercentage = min(100, max(0, $completionPercentage)); // Force between 0-100%

            // Update the profile_completion field in database
            if ($jobseeker) {
                $this->jobseekerModel->updateProfileCompletion($_SESSION['user_id'], $completionPercentage);
            }

            // Load the view with data
            include __DIR__ . '/../views/jobseekers/profile-jobseeker.php';
        } catch (Exception $e) {
            error_log('Error loading profile: ' . $e->getMessage());
            $_SESSION['error_message'] = 'Error loading profile data.';
            header('Location: ?page=dashboard-jobseeker');
            exit;
        }
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
        // Clear any output buffers and set headers first
        while (ob_get_level()) {
            ob_end_clean();
        }

        header('Content-Type: application/json');
        header('Cache-Control: no-cache, must-revalidate');

        try {
            if (!isset($_SESSION['user_id']) || $_SESSION['role'] != User::ROLE_JOBSEEKER) {
                http_response_code(401);
                echo json_encode(['success' => false, 'message' => 'Unauthorized']);
                exit;
            }

            if (!isset($_FILES['profile_picture']) || $_FILES['profile_picture']['error'] !== UPLOAD_ERR_OK) {
                $errorMsg = 'No file uploaded or upload error';
                if (isset($_FILES['profile_picture']['error'])) {
                    switch ($_FILES['profile_picture']['error']) {
                        case UPLOAD_ERR_INI_SIZE:
                        case UPLOAD_ERR_FORM_SIZE:
                            $errorMsg = 'File is too large';
                            break;
                        case UPLOAD_ERR_NO_FILE:
                            $errorMsg = 'No file was uploaded';
                            break;
                        default:
                            $errorMsg = 'Upload error occurred';
                    }
                }
                echo json_encode(['success' => false, 'message' => $errorMsg]);
                exit;
            }

            $file = $_FILES['profile_picture'];

            // Validate file type
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            if (!in_array($file['type'], $allowedTypes)) {
                echo json_encode(['success' => false, 'message' => 'Invalid file type. Only JPEG, PNG, GIF, and WEBP are allowed.']);
                exit;
            }

            // UPDATED: Validate file size (5MB max for profile photos)
            if ($file['size'] > 5 * 1024 * 1024) {
                echo json_encode(['success' => false, 'message' => 'File size must be less than 5MB.']);
                exit;
            }

            // Rest of your existing code remains the same...
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

            // Create upload directory if it doesn't exist
            $uploadDir = __DIR__ . '/../../public/uploads/profile_pictures/';
            if (!is_dir($uploadDir)) {
                if (!mkdir($uploadDir, 0755, true)) {
                    error_log("ERROR: Failed to create upload directory: $uploadDir");
                    echo json_encode(['success' => false, 'message' => 'Failed to create upload directory']);
                    exit;
                }
            }

            // Generate unique filename
            $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $filename = 'profile_' . $_SESSION['user_id'] . '_' . time() . '.' . $extension;
            $filepath = $uploadDir . $filename;

            // Move uploaded file
            if (!move_uploaded_file($file['tmp_name'], $filepath)) {
                error_log("ERROR: Failed to move profile photo file from " . $file['tmp_name'] . " to " . $filepath);
                echo json_encode(['success' => false, 'message' => 'Failed to upload file. Please check permissions.']);
                exit;
            }

            // Set proper file permissions
            chmod($filepath, 0644);

            // Update database with new profile picture path
            $relativePath = 'uploads/profile_pictures/' . $filename;
            $result = $this->jobseekerModel->updateProfilePicture($_SESSION['user_id'], $relativePath);

            if (!$result) {
                // If database update fails, clean up the uploaded file
                if (file_exists($filepath)) {
                    unlink($filepath);
                }
                error_log("ERROR: Failed to update profile picture in database for user_id: " . $_SESSION['user_id']);
                echo json_encode(['success' => false, 'message' => 'Failed to update database']);
                exit;
            }

            // Delete old profile picture after successful database update
            if (!empty($jobseeker['profile_picture'])) {
                $oldPhotoPath = __DIR__ . '/../../public/' . $jobseeker['profile_picture'];
                if (file_exists($oldPhotoPath) && is_file($oldPhotoPath)) {
                    unlink($oldPhotoPath);
                }
            }

            // Send success response
            echo json_encode([
                'success' => true,
                'message' => 'Profile photo updated successfully',
                'image_url' => $relativePath
            ]);
        } catch (Exception $e) {
            error_log("ERROR: Exception in uploadProfilePhoto: " . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'An unexpected error occurred']);
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

        // Get events data - FIXED METHOD CALL
        try {
            require_once __DIR__ . '/EventProgramController.php';
            $eventController = new EventProgramController();
            
            // FIXED: Use correct method name
            $allEvents = $eventController->programEvents();
            $events = $allEvents['events'] ?? [];
            
            // OR use the model directly for simpler approach:
            // $eventModel = new EventProgram();
            // $events = $eventModel->getAllEvents('show');
            
        } catch (Exception $e) {
            error_log('Error fetching events for jobseeker programs: ' . $e->getMessage());
            $events = []; // Fallback to empty array
        }

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
        // FIXED: Load ALL profile data for AJAX requests
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
            $jobseeker = [
                'first_name' => '',
                'last_name' => '',
                'middle_name' => '',
                'suffix' => '',
                'date_of_birth' => null,
                'sex' => '',
                'address' => '',
                'contact_no' => '',
                'profile_picture' => ''
            ];
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
        // FIXED: Load applications data properly
        $hiredApplications = [];

        if ($jobseeker && $jobseeker['jobseeker_id']) {
            require_once __DIR__ . '/../models/JobApplication.php';
            $jobApplicationModel = new JobApplication();
            $hiredApplications = $jobApplicationModel->getApplicationsByJobseekerAndStatus($jobseeker['jobseeker_id'], 'hired');
        }

        // Make sure $GLOBALS is set for the view
        $GLOBALS['hiredApplications'] = $hiredApplications;

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
            // FIXED: Use original filename as file_name for display
            $result = $this->jobseekerModel->saveDocument(
                $jobseeker_id,
                $relativePath,
                $type,
                $file['name'] // This becomes file_name in database (original filename)
            );

            if ($result) {
                $success = ucfirst($type) . ' uploaded successfully!';

                // Parse PDFs only
                if (strtolower($extension) === 'pdf') {
                    $this->attemptResumeParsing($filepath, $_SESSION['user_id'], $success);
                }

                return true;
            } else {
                $error = 'Failed to save file information.';
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

    public function getWorkExperienceById()
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

    public function handleDeleteWorkExperience()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != User::ROLE_JOBSEEKER) {
            header('Location: ?page=login-jobseeker');
            exit;
        }

        if (!isset($_POST['experience_id'])) {
            $_SESSION['error_message'] = 'Experience ID is required.';
            header('Location: ?page=complete-jobseeker-profile&step=4');
            exit;
        }

        $experience_id = $_POST['experience_id'];

        $jobseeker = $this->jobseekerModel->findByUserId($_SESSION['user_id']);
        if (!$jobseeker) {
            $_SESSION['error_message'] = 'Jobseeker profile not found.';
            header('Location: ?page=complete-jobseeker-profile&step=4');
            exit;
        }

        if ($this->jobseekerModel->deleteWorkExperience($jobseeker['jobseeker_id'], $experience_id)) {
            $_SESSION['success_message'] = 'Work experience deleted successfully!';
        } else {
            $_SESSION['error_message'] = 'Failed to delete work experience.';
        }

        header('Location: ?page=complete-jobseeker-profile&step=4');
        exit;
    }

    public function deleteSkillSimple()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != User::ROLE_JOBSEEKER) {
            header('Location: ?page=login-jobseeker');
            exit;
        }

        if ($_POST && isset($_POST['skill_id'])) {
            $skill_id = $_POST['skill_id'];
            $jobseeker = $this->jobseekerModel->findByUserId($_SESSION['user_id']);

            if ($jobseeker) {
                $result = $this->jobseekerModel->deleteSkillById($jobseeker['jobseeker_id'], $skill_id);

                if ($result) {
                    $_SESSION['success_message'] = 'Skill deleted successfully!';
                } else {
                    $_SESSION['error_message'] = 'Failed to delete skill.';
                }
            }
        }

        header('Location: ?page=complete-jobseeker-profile&step=5');
        exit;
    }

    public function deleteCertificateSimple()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != User::ROLE_JOBSEEKER) {
            header('Location: ?page=login-jobseeker');
            exit;
        }

        if ($_POST && isset($_POST['certificate_id'])) {
            $certificate_id = $_POST['certificate_id'];
            $jobseeker = $this->jobseekerModel->findByUserId($_SESSION['user_id']);

            if ($jobseeker) {
                $result = $this->jobseekerModel->deleteCertificate($jobseeker['jobseeker_id'], $certificate_id);

                if ($result) {
                    $_SESSION['success_message'] = 'Certificate deleted successfully!';
                } else {
                    $_SESSION['error_message'] = 'Failed to delete certificate.';
                }
            }
        }

        header('Location: ?page=complete-jobseeker-profile&step=6');
        exit;
    }

    public function getProfileTabContent()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != User::ROLE_JOBSEEKER) {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }

        $tab = $_GET['tab'] ?? 'profile';

        // Get jobseeker info
        $jobseeker = $this->jobseekerModel->findByUserId($_SESSION['user_id']);
        if (!$jobseeker) {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Profile not found']);
            exit;
        }

        // For applications tab, get hired applications
        if ($tab === 'applications') {
            // Get hired applications using the existing method
            require_once __DIR__ . '/../models/JobApplication.php';
            $jobApplicationModel = new JobApplication();

            $hiredApplications = $jobApplicationModel->getApplicationsByJobseekerAndStatus(
                $jobseeker['jobseeker_id'],
                'hired'
            );

            // Make sure it's available in the included file
            $GLOBALS['hiredApplications'] = $hiredApplications;
        }

        // Include the appropriate tab content
        switch ($tab) {
            case 'profile':
                include __DIR__ . '/../views/jobseekers/profile-components/profile-content.php';
                break;
            case 'documents':
                include __DIR__ . '/../views/jobseekers/profile-components/documents-content.php';
                break;
            case 'applications':
                include __DIR__ . '/../views/jobseekers/profile-components/applications-contents.php';
                break;
            default:
                echo '<div class="py-8 text-center"><p class="text-gray-500">Tab not found</p></div>';
        }
        exit;
    }

    public function settings()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != User::ROLE_JOBSEEKER) {
            header('Location: ?page=login-jobseeker');
            exit;
        }

        // Get jobseeker profile for navbar
        $jobseeker = $this->getJobseekerData();

        include __DIR__ . '/../views/jobseekers/settings-jobseeker.php';
    }

    public function changePassword()
    {
        header('Content-Type: application/json');

        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != User::ROLE_JOBSEEKER) {
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
            exit;
        }

        $currentPassword = $_POST['current_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        // Validation
        $validationErrors = $this->validatePasswordChange($currentPassword, $newPassword, $confirmPassword);

        if (!empty($validationErrors)) {
            echo json_encode(['success' => false, 'message' => implode(' ', $validationErrors)]);
            exit;
        }

        // Verify current password
        $user = $this->userModel->findById($_SESSION['user_id']);
        if (!$user || !password_verify($currentPassword, $user['password'])) {
            echo json_encode(['success' => false, 'message' => 'Current password is incorrect']);
            exit;
        }

        // Update password
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $result = $this->userModel->updatePassword($_SESSION['user_id'], $hashedPassword);

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Password updated successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update password']);
        }
        exit;
    }

    private function validatePasswordChange($currentPassword, $newPassword, $confirmPassword)
    {
        $errors = [];

        // Current password validation
        if (empty($currentPassword)) {
            $errors[] = 'Current password is required.';
        }

        // New password validation
        if (empty($newPassword)) {
            $errors[] = 'New password is required.';
        } elseif (strlen($newPassword) < 8) {
            $errors[] = 'New password must be at least 8 characters long.';
        } elseif (strlen($newPassword) > 50) {
            $errors[] = 'New password cannot exceed 50 characters.';
        } elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)/', $newPassword)) {
            $errors[] = 'New password must contain at least one uppercase letter, one lowercase letter, and one number.';
        }

        // Confirm password validation
        if (empty($confirmPassword)) {
            $errors[] = 'Please confirm your new password.';
        } elseif ($newPassword !== $confirmPassword) {
            $errors[] = 'New passwords do not match.';
        }

        // Check if new password is different from current
        if (!empty($currentPassword) && !empty($newPassword) && $currentPassword === $newPassword) {
            $errors[] = 'New password must be different from current password.';
        }

        return $errors;
    }

    public function deactivateAccount()
    {
        header('Content-Type: application/json');

        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != User::ROLE_JOBSEEKER) {
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
            exit;
        }

        $password = $_POST['password'] ?? '';

        if (empty($password)) {
            echo json_encode(['success' => false, 'message' => 'Password is required to deactivate account']);
            exit;
        }

        // Verify password
        $user = $this->userModel->findById($_SESSION['user_id']);
        if (!$user || !password_verify($password, $user['password'])) {
            echo json_encode(['success' => false, 'message' => 'Incorrect password']);
            exit;
        }

        // Deactivate account (set status to inactive)
        $result = $this->userModel->updateUserStatus($_SESSION['user_id'], 'inactive');

        if ($result) {
            // Log the user out
            session_destroy();
            echo json_encode([
                'success' => true,
                'message' => 'Account deactivated successfully',
                'redirect' => '?page=landing'
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to deactivate account']);
        }
        exit;
    }

    public function deleteAccount()
    {
        header('Content-Type: application/json');

        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != User::ROLE_JOBSEEKER) {
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
            exit;
        }

        $password = $_POST['password'] ?? '';
        $confirmText = $_POST['confirm_text'] ?? '';

        if (empty($password)) {
            echo json_encode(['success' => false, 'message' => 'Password is required to delete account']);
            exit;
        }

        if (strtolower($confirmText) !== 'delete my account') {
            echo json_encode(['success' => false, 'message' => 'Please type "DELETE MY ACCOUNT" to confirm']);
            exit;
        }

        // Verify password
        $user = $this->userModel->findById($_SESSION['user_id']);
        if (!$user || !password_verify($password, $user['password'])) {
            echo json_encode(['success' => false, 'message' => 'Incorrect password']);
            exit;
        }

        try {
            $jobseeker = $this->getJobseekerData();
            $jobseekerName = trim(($jobseeker['first_name'] ?? '') . ' ' . ($jobseeker['last_name'] ?? ''));
            error_log("Jobseeker account deleted: {$jobseekerName} (Email: {$user['email']}) - User ID: {$_SESSION['user_id']}");
        } catch (Exception $e) {
            error_log('Failed to log account deletion: ' . $e->getMessage());
        }

        // Delete the entire user account (cascade will handle related records)
        $result = $this->userModel->deleteUser($_SESSION['user_id']);

        if ($result) {
            // Log the user out
            session_destroy();
            echo json_encode([
                'success' => true,
                'message' => 'Account deleted successfully',
                'redirect' => '?page=landing'
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete account']);
        }
        exit;
    }

    public function clearUploadFlag()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != User::ROLE_JOBSEEKER) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            exit;
        }

        // Clear the fresh upload flag
        unset($_SESSION['fresh_resume_upload']);

        header('Content-Type: application/json');
        echo json_encode(['success' => true]);
        exit;
    }
}
