<?php
require_once __DIR__ . '/../vendor/autoload.php';
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-2vWTFzTx5TkQ0CKg5sG3rMd8W2jcJGkX+9L5wz1tCwLmfIu5FgDf0uB/hgsWmPB0wDCaY6FUVuLuqm+ne+0hMA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="./assets/css/output.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="./assets/images/sikap-logo.png">
    <title>Sikap - PESO Rosario Emplyment Platform</title>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>

<body class="font-inter">
    <?php
    session_start();
    $page = $_GET['page'] ?? 'landing';

    switch ($page) {
        case 'landing':
            include __DIR__ . '/../app/views/pages/landing-page.php';
            break;


        // Google login Jobseeker & Employer

         case 'google-login':
            require_once __DIR__ . '/../app/controllers/GoogleAuthController.php';
            $controller = new GoogleAuthController();
            $controller->initiateLogin();
            break;
        case 'google-callback':
            require_once __DIR__ . '/../app/controllers/GoogleAuthController.php';
            $controller = new GoogleAuthController();
            $controller->handleCallback();
            break;
            
        // Jobseeker Routes
        case 'login-jobseeker':
            require_once __DIR__ . '/../app/controllers/JobseekerController.php';
            $controller = new JobseekerController();
            $controller->login();
            break;
        case 'signup-jobseeker':
            require_once __DIR__ . '/../app/controllers/JobseekerController.php';
            $controller = new JobseekerController();
            $controller->signup();
            break;
        case 'jobseeker-dashboard':
            require_once __DIR__ . '/../app/controllers/JobSeekerDashboardController.php';
            $controller = new JobSeekerDashboardController();
            $controller->dashboard();
            break;
        case 'profile-jobseeker':
            require_once __DIR__ . '/../app/controllers/JobseekerController.php';
            $controller = new JobseekerController();
            $controller->showProfile();
            break;
        case 'upload-profile-photo':
            require_once __DIR__ . '/../app/controllers/JobseekerController.php';
            $controller = new JobseekerController();
            $controller->uploadProfilePhoto();
            break;
        case 'jobseeker-documents':
            include __DIR__ . '/../app/views/jobseekers/profile-components/jobseeker-documents.php';
            break;
        case 'download-document':
            require_once __DIR__ . '/../app/controllers/DocumentController.php';
            $controller = new DocumentController();
            $controller->downloadDocument();
            break;
        case 'jobseeker-applications':
            include __DIR__ . '/../app/views/jobseekers/profile-components/jobseeker-applications.php';
            break;
        case 'settings-jobseeker':
            include __DIR__ . '/../app/views/jobseekers/settings-jobseeker.php';
            break;
        case 'saved-jobs':
            require_once __DIR__ . '/../app/controllers/JobseekerController.php';
            $controller = new JobseekerController();
            $controller->savedJobs();
            break;         

 // Jobseeker 2FA OTP Routes NEWWWWWWWWWW
        case 'verify-otp':
            require_once __DIR__ . '/../app/controllers/JobseekerController.php';
            $controller = new JobseekerController();
            $controller->verifyLoginOtp();
            break;
        case 'resend-otp':
            require_once __DIR__ . '/../app/controllers/JobseekerController.php';
            $controller = new JobseekerController();
            $controller->resendOtp();
            break;


        // Employer Routes
        case 'login-employer':
            require_once __DIR__ . '/../app/controllers/EmployerController.php';
            $controller = new EmployerController();
            $controller->login();
            break;
        case 'signup-employer':
            require_once __DIR__ . '/../app/controllers/EmployerController.php';
            $controller = new EmployerController();
            $controller->signup();
            break;
        case 'employer-dashboard':
            require_once __DIR__ . '/../app/controllers/EmployerDashboardController.php';
            $controller = new EmployerDashboardController();
            $controller->dashboard();
            break;
        
        case 'view-all-applicants':
            require_once __DIR__ . '/../app/controllers/JobApplicantsController.php';
            $controller = new JobApplicantsController();
            $controller->viewAllApplicants();
            break;
        case 'view-applicants':
            require_once __DIR__ . '/../app/controllers/JobApplicantsController.php';
            $controller = new JobApplicantsController();
            $controller->viewApplicants($_GET['job_id'] ?? null);
            break;
        case 'manage-applications':
            require_once __DIR__ . '/../app/controllers/JobApplicantsController.php';
            $controller = new JobApplicantsController();
            $controller->viewApplicants($_GET['job_id'] ?? null);
            break;
        case 'review-application':
            require_once __DIR__ . '/../app/controllers/ReviewApplicationController.php';
            $controller = new ReviewApplicationController();
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controller->handlePost($_GET['application_id'] ?? null);
            }
            $controller->view($_GET['application_id'] ?? null);
            break;
        case 'test-application-data':
            require_once __DIR__ . '/../app/models/ReviewApplication.php';
            $reviewApp = new ReviewApplication();
            $app_id = $_GET['app_id'] ?? 7;
            $type = $_GET['type'] ?? 'full'; // 'basic' or 'full'
            
            header('Content-Type: application/json');
            
            if ($type === 'basic') {
                $result = $reviewApp->getApplication($app_id);
            } else {
                $result = $reviewApp->getFullApplicationDetails($app_id);
            }
            
            echo json_encode([
                'success' => true,
                'application_id' => $app_id,
                'type' => $type,
                'data' => $result
            ], JSON_PRETTY_PRINT);
            exit;
            break;
        
        // Admin Routes
        case 'admin-login':
            require_once __DIR__ . '/../app/controllers/AdminController.php';
            $controller = new AdminController();
            $controller->login();
            break;
        case 'admin-dashboard':
            require_once __DIR__ . '/../app/controllers/AdminController.php';
            $controller = new AdminController();
            $controller->dashboard();
            break;

        // case 'admin-users':
        //     require_once __DIR__ . '/../app/controllers/AdminController.php';
        //     $controller = new AdminController();
        //     $controller->manageUsers();
        //     break;

        // case 'admin-jobs':
        //     require_once __DIR__ . '/../app/controllers/AdminController.php';
        //     $controller = new AdminController();
        //     $controller->manageJobs();
        //     break;

        // case 'admin-reports':
        //     require_once __DIR__ . '/../app/controllers/AdminController.php';
        //     $controller = new AdminController();
        //     $controller->reports();
        //     break;

        // case 'admin-applications':
        //     require_once __DIR__ . '/../app/controllers/AdminController.php';
        //     $controller = new AdminController();
        //     $controller->manageApplications();
        //     break;

        // case 'admin-announcements':
        //     require_once __DIR__ . '/../app/controllers/AdminController.php';
        //     $controller = new AdminController();
        //     $controller->manageAnnouncements();
        //     break;

        // case 'admin-chatbot':
        //     require_once __DIR__ . '/../app/controllers/AdminController.php';
        //     $controller = new AdminController();
        //     $controller->manageChatbot();
        //     break;

        // case 'admin-events':
        //     require_once __DIR__ . '/../app/controllers/AdminController.php';
        //     $controller = new AdminController();
        //     $controller->manageEvents();
        //     break;

        // Complete Profile Routes
        case 'complete-employer-profile':
            // This is now the choice page
            include __DIR__ . '/../app/views/employers/complete-profile.php';
            break;

        case 'employer-personal-profile':
            require_once __DIR__ . '/../app/controllers/EmployerController.php';
            $controller = new EmployerController();
            $controller->personalProfile();
            break;

        case 'complete-employer-business':
            require_once __DIR__ . '/../app/controllers/EmployerController.php';
            $controller = new EmployerController();
            $controller->completeBusiness(); // This method should handle both GET and POST
            break;

        case 'profile-employer':
            require_once __DIR__ . '/../app/controllers/EmployerController.php';
            $controller = new EmployerController();
            $controller->showProfile();
            break;
        case 'download-employer-document':
            require_once __DIR__ . '/../app/controllers/EmployerDocumentController.php';
            $controller = new EmployerDocumentController();
            $controller->downloadDocument();
            break;

        case 'complete-jobseeker-profile':
            require_once __DIR__ . '/../app/controllers/JobseekerController.php';
            $controller = new JobseekerController();
            $controller->completeProfile();
            break;

        case 'profile-completion-success':
            require_once __DIR__ . '/../app/controllers/JobseekerController.php';
            $controller = new JobseekerController();
            $controller->profileCompletionSuccess();
            break;
        case 'employer-profile-completion-success':
            require_once __DIR__ . '/../app/controllers/EmployerController.php';
            $controller = new EmployerController();
            $controller->profileCompletionSuccess();
            break;

        // Logout
        case 'logout':
            session_destroy();
            header('Location: ?page=landing');
            exit;
            break;

        // New Employer Routes
        case 'post-job':
            require_once __DIR__ . '/../app/controllers/JobPostController.php';
            $controller = new JobPostController();
            $controller->postJob();
            break;

        case 'job-post-success':
            include __DIR__ . '/../app/views/employers/post-job/job-post-success.php';
            break;

        case 'manage-jobs':
            require_once __DIR__ . '/../app/controllers/JobPostController.php';
            $controller = new JobPostController();
            $controller->manageJobs();
            break;

        case 'view-job':
            require_once __DIR__ . '/../app/controllers/JobPostController.php';
            $controller = new JobPostController();
            $controller->viewJobForJobseeker(); // Use the new method name
            break;

        case 'view-employer-job':
            require_once __DIR__ . '/../app/controllers/JobPostController.php';
            $controller = new JobPostController();
            $controller->viewEmployerJob(); // For employers viewing their own jobs
            break;

        case 'browse-jobs':
            require_once __DIR__ . '/../app/controllers/JobPostController.php';
            $controller = new JobPostController();
            $controller->browseJobs();
            break;

        case 'edit-job':
            require_once __DIR__ . '/../app/controllers/JobPostController.php';
            $controller = new JobPostController();
            $controller->editJob();
            break;

        case 'delete-job':
            require_once __DIR__ . '/../app/controllers/JobPostController.php';
            $controller = new JobPostController();
            $controller->deleteJob();
            break;

        case 'toggle-job-status':
            require_once __DIR__ . '/../app/controllers/JobPostController.php';
            $controller = new JobPostController();
            $controller->toggleJobStatus();
            break;

        // Job Application Routes
        case 'apply-job':
            require_once __DIR__ . '/../app/controllers/JobApplicationController.php';
            $controller = new JobApplicationController();
            $controller->applyForJob();
            break;

        case 'application-success':
            require_once __DIR__ . '/../app/controllers/JobApplicationController.php';
            $controller = new JobApplicationController();
            $controller->applicationSuccess();
            break;

        case 'my-applications':
            require_once __DIR__ . '/../app/controllers/JobApplicationController.php';
            $controller = new JobApplicationController();
            $controller->myApplications();
            break;

        case 'view-application':
            require_once __DIR__ . '/../app/controllers/JobApplicationController.php';
            $controller = new JobApplicationController();
            $controller->viewApplication();
            break;

        case 'withdraw-application':
            require_once __DIR__ . '/../app/controllers/JobApplicationController.php';
            $controller = new JobApplicationController();
            $controller->withdrawApplication();
            break;

        // Admin Accreditation Routes
        case 'admin-accreditations':
            require_once __DIR__ . '/../app/controllers/AdminController.php';
            $controller = new AdminController();
            $controller->accreditations();
            break;

        case 'admin-review-accreditation':
            require_once __DIR__ . '/../app/controllers/AdminController.php';
            $controller = new AdminController();
            $controller->reviewAccreditation();
            break;

        case 'admin-process-accreditation':
            require_once __DIR__ . '/../app/controllers/AdminController.php';
            $controller = new AdminController();
            $controller->processAccreditation();
            break;
        case 'upload-business-logo':
            require_once __DIR__ . '/../app/controllers/EmployerController.php';
            $controller = new EmployerController();
            $controller->uploadBusinessLogo();
            break;
        case 'save-job':
            require_once __DIR__ . '/../app/controllers/JobseekerController.php';
            $controller = new JobseekerController();
            $controller->saveJob();
            break;

        case 'unsave-job':
            require_once __DIR__ . '/../app/controllers/JobseekerController.php';
            $controller = new JobseekerController();
            $controller->unsaveJob();
            break;

        default:
            include __DIR__ . '/../app/views/pages/landing-page.php';
            break;

             // Forgot Password Routes NEWWWWWWWWWWWWWW
       
             case 'forgot-password':
                require_once __DIR__ . '/../app/controllers/UserController.php';
                $controller = new UserController();
                $controller->forgotPassword();
                break;

            case 'forgot-password-request':
                require_once __DIR__ . '/../app/controllers/UserController.php';
                $controller = new UserController();
                $controller->forgotPasswordRequest();
                break;

            case 'verify-forgotpassword':
                require_once __DIR__ . '/../app/controllers/UserController.php';
                $controller = new UserController();
                $controller->verifyForgotPasswordOtp();
                break;

            case 'resend-forgotpassword':
                require_once __DIR__ . '/../app/controllers/UserController.php';
                $controller = new UserController();
                $controller->resendOtp();
                break;

            case 'reset-password':
                require_once __DIR__ . '/../app/controllers/UserController.php';
                $controller = new UserController();
                $controller->resetPassword();
                break;
    }
    ?>
</body>

</html>