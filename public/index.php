<?php
require_once __DIR__ . '/../vendor/autoload.php';
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
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

        case 'program-events':
            require_once __DIR__ . '/../app/controllers/EventProgramController.php';
            $controller = new EventProgramController();
            $events = $controller->getActiveEvents();
            include __DIR__ . '/../app/views/pages/program-events.php';
            break;

        case 'event-info':
            require_once __DIR__ . '/../app/controllers/EventProgramController.php';
            $controller = new EventProgramController();
            $event = $controller->getEventById($_GET['id'] ?? null);
            include __DIR__ . '/../app/views/pages/event-info.php';
            break;

        case 'view-company':
            include __DIR__ . '/../app/views/pages/view-company.php';
            break;

        case 'view-all-companies':
            include __DIR__ . '/../app/views/pages/view-all-companies.php';
            break;

        // case 'updateStatus':
        //     require_once __DIR__ . '/../app/controllers/UserManagementController.php';
        //     $controller = new UserManagementController();
        //     $controller->updateStatus();
        //     break;

        case 'update-employer-status':
            require_once __DIR__ . '/../app/controllers/UserManagementController.php';
            $controller = new UserManagementController();
            $controller->updateStatus();
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
        case 'profile-tab-content':
            if (isset($_GET['tab']) && in_array($_GET['tab'], ['profile', 'documents', 'applications'])) {
                // Check if it's an AJAX request
                if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                    // Don't include navigation bars for AJAX content
                    $tab = $_GET['tab'];

                    switch ($tab) {
                        case 'profile':
                            // Load jobseeker data for profile tab
                            require_once __DIR__ . '/../app/models/Jobseeker.php';
                            $jobseekerModel = new Jobseeker();
                            $jobseeker = $jobseekerModel->findByUserId($_SESSION['user_id']);
                            $education = $jobseekerModel->getEducation($_SESSION['user_id']);
                            $workExperience = $jobseekerModel->getWorkExperience($_SESSION['user_id']);
                            $skills = $jobseekerModel->getSkills($_SESSION['user_id']);
                            $certificates = $jobseekerModel->getCertificates($_SESSION['user_id']);

                            // Convert false results to empty arrays
                            if ($education === false) $education = [];
                            if ($workExperience === false) $workExperience = [];
                            if ($skills === false) $skills = [];
                            if ($certificates === false) $certificates = [];
                            if ($jobseeker === false) {
                                $jobseeker = ['first_name' => '', 'last_name' => '', 'middle_name' => '', 'suffix' => '', 'date_of_birth' => null, 'sex' => '', 'address' => '', 'contact_no' => ''];
                            }

                            include __DIR__ . '/../app/views/jobseekers/profile-components/profile-content.php';
                            break;

                        case 'documents':
                            require_once __DIR__ . '/../app/models/Jobseeker.php';
                            $jobseekerModel = new Jobseeker();
                            $documents = $jobseekerModel->getDocuments($_SESSION['user_id']);
                            if ($documents === false) $documents = [];

                            include __DIR__ . '/../app/views/jobseekers/profile-components/documents-content.php';
                            break;

                        case 'applications':
                            // For now, just include the applications content
                            include __DIR__ . '/../app/views/jobseekers/profile-components/applications-contents.php';
                            break;
                    }
                    exit; // Important: Exit after AJAX response
                }
            }
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

        // Admin Routes
        case 'admin-login':
            require_once __DIR__ . '/../app/controllers/AdminController.php';
            $controller = new AdminController();
            $controller->login();
            break;
        case 'admin-dashboard':
            require_once __DIR__ . '/../app/controllers/AdminDashboardController.php';
            $controller = new AdminDashboardController();
            $controller->dashboard();
            break;

        case 'admin-reports':
            if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
                header('Location: ?page=admin-login');
                exit;
            }
            include __DIR__ . '/../app/views/admin/reports-dashboard.php';
            break;

        case 'all-reports':
            if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
                header('Location: ?page=admin-login');
                exit;
            }
            include __DIR__ . '/../app/views/admin/reports-dashboard.php';
            break;

        // Event Management Routes
        case 'admin-events':
            require_once __DIR__ . '/../app/controllers/EventProgramController.php';
            $controller = new EventProgramController();
            $controller->index();
            break;

        case 'admin-event-create':
            require_once __DIR__ . '/../app/controllers/EventProgramController.php';
            $controller = new EventProgramController();
            $controller->create();
            break;

        case 'admin-event-store':
            require_once __DIR__ . '/../app/controllers/EventProgramController.php';
            $controller = new EventProgramController();
            $controller->store();
            break;

        case 'admin-event-edit':
            require_once __DIR__ . '/../app/controllers/EventProgramController.php';
            $controller = new EventProgramController();
            if (isset($_GET['id'])) {
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    // Fix: ensure $_FILES is available and not empty
                    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK && !empty($_FILES['image']['name'])) {
                        $controller->update($_GET['id']);
                    } else {
                        $controller->update($_GET['id']);
                    }
                } else {
                    $controller->edit($_GET['id']);
                }
            } else {
                header('Location: index.php?page=admin-events&error=No event specified');
                exit;
            }
            break;

        case 'admin-event-delete':
            require_once __DIR__ . '/../app/controllers/EventProgramController.php';
            $controller = new EventProgramController();
            if (isset($_GET['id'])) {
                $controller->delete($_GET['id']);
            } else {
                header('Location: index.php?page=admin-events&error=No event specified');
            }
            break;


        //NEWWWWWWWWWWWWWWW

        // User Management Routes
        case 'admin-jobseekers':
            require_once __DIR__ . '/../app/controllers/UserManagementController.php';
            $controller = new UserManagementController();
            $controller->index('jobseekers');
            break;

        case 'admin-employers':
            require_once __DIR__ . '/../app/controllers/UserManagementController.php';
            $controller = new UserManagementController();
            $controller->index('employers');
            break;


        // case 'admin-users':
        //     require_once __DIR__ . '/../app/controllers/AdminController.php';
        //     $controller = new AdminController();
        //     $controller->manageUsers();
        //     break;

        case 'admin-jobpost-management':
            require_once __DIR__ . '/../app/controllers/AdminController.php';
            $controller = new AdminController();
            $controller->jobPostManagement();
            break;

        case 'admin-view-job':
            require_once __DIR__ . '/../app/controllers/AdminController.php';
            $controller = new AdminController();
            $controller->viewJob();
            break;

        case 'admin-toggle-job-status':
            require_once __DIR__ . '/../app/controllers/AdminController.php';
            $controller = new AdminController();
            $controller->toggleJobStatus();
            break;

        case 'admin-delete-job':
            require_once __DIR__ . '/../app/controllers/AdminController.php';
            $controller = new AdminController();
            $controller->deleteJob();
            break;

        // case 'admin-reports':
        //     require_once __DIR__ . '/../app/controllers/AdminController.php';
        //     $controller = new AdminController();
        //     $controller->reports();
        //     break;

        case 'admin-applications':
            require_once __DIR__ . '/../app/controllers/AdminController.php';
            $controller = new AdminController();
            $controller->applicationManagement();
            break;

        case 'admin-view-application':
            require_once __DIR__ . '/../app/controllers/AdminController.php';
            $controller = new AdminController();
            $controller->viewApplication();
            break;

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

        case 'admin-event-status':
            require_once __DIR__ . '/../app/controllers/EventProgramController.php';
            $controller = new EventProgramController();
            $controller->toggleEventStatus($_GET['id']);
            break;

        case 'admin-event-pin':
            require_once __DIR__ . '/../app/controllers/EventProgramController.php';
            $controller = new EventProgramController();
            $controller->togglePin();
            break;

        case 'events-jobfair':
            require_once __DIR__ . '/../app/controllers/EventProgramController.php';
            $controller = new EventProgramController();
            $controller->publicView();
            break;

        // Complete Profile Routes
        case 'complete-employer-profile':
            // Call the controller method to properly set variables
            require_once __DIR__ . '/../app/controllers/EmployerController.php';
            $controller = new EmployerController();
            $controller->completeProfile();
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

        case 'view-employer-profile':
            require_once __DIR__ . '/../app/controllers/JobPostController.php';
            $controller = new JobPostController();
            $controller->viewEmployerProfileForJobseeker();
            break;

        case 'explore-companies':
            require_once __DIR__ . '/../app/controllers/JobPostController.php';
            $controller = new JobPostController();
            $controller->exploreCompanies();
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

        case 'setting-employer':
            include __DIR__ . '/../app/views/employers/setting-employer.php';
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

        case 'get-job-details-ajax':
            // Clear any output buffers before AJAX response
            while (ob_get_level()) {
                ob_end_clean();
            }
            require_once __DIR__ . '/../app/controllers/JobDetailsAjaxController.php';
            $controller = new JobDetailsAjaxController();
            $controller->getJobDetails();
            exit; // Prevent any further output
            break;
    }
    ?>
</body>

</html>