<?php
// Prevent caching issues
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

// Session configuration
ini_set('session.cookie_lifetime', 0); // Session cookies expire when browser closes
ini_set('session.gc_maxlifetime', 3600); // Sessions expire after 1 hour of inactivity
ini_set('session.cookie_httponly', 1); // Prevent JavaScript access to session cookies
ini_set('session.use_strict_mode', 1); // Use strict session mode

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Regenerate session ID periodically for security
if (!isset($_SESSION['regenerated'])) {
    session_regenerate_id(true);
    $_SESSION['regenerated'] = time();
} elseif (time() - $_SESSION['regenerated'] > 300) { // Regenerate every 5 minutes
    session_regenerate_id(true);
    $_SESSION['regenerated'] = time();
}

require_once __DIR__ . '/../vendor/autoload.php';
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="/sikap/public/assets/css/output.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="./assets/images/sikap-logo.png">
    <title>Sikap - PESO Rosario Emplyment Platform</title>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>

<body class="font-inter">
    <?php
    $page = $_GET['page'] ?? 'landing';

    switch ($page) {
        case 'landing':
            include __DIR__ . '/../app/views/pages/landing-page.php';
            break;

        case 'about-page':
            include __DIR__ . '/../app/views/pages/about-page.php';
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

        // NOTIFICATION ROUTES (MVC pattern)
        case 'notifications-api':
            require_once __DIR__ . '/../app/controllers/NotificationController.php';
            $controller = new NotificationController();
            $controller->apiEndpoint(); // This replaces app/api/notifications.php
            break;

        case 'notifications-jobseeker':
            require_once __DIR__ . '/../app/controllers/NotificationController.php';
            $controller = new NotificationController();
            $controller->viewAllJobseekerNotifications();
            break;
        case 'validate-link':
            require_once __DIR__ . '/../app/controllers/NotificationController.php';
            $controller = new NotificationController();
            $controller->validateAndRedirect();
            break;

        case 'notifications-employer':
            require_once __DIR__ . '/../app/controllers/NotificationController.php';
            $controller = new NotificationController();
            $controller->viewAllEmployerNotifications();
            break;

        case 'update-employer-status':
            require_once __DIR__ . '/../app/controllers/AdminDashboardController.php';
            $controller = new AdminDashboardController();
            $controller->updateUserStatus();
            break;

        case 'admin-jobseeker-update-status':
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
                    // FIXED: Method name typo
                    require_once __DIR__ . '/../app/controllers/JobseekerController.php';
                    $controller = new JobseekerController();
                    $controller->profileTabContent(); // Fixed: was getprofileTabContent()
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
            require_once __DIR__ . '/../app/controllers/JobseekerSettingsController.php';
            $controller = new JobseekerSettingsController();
            $controller->showSettings();
            break;
        case 'update-jobseeker-settings':
            require_once __DIR__ . '/../app/controllers/JobseekerSettingsController.php';
            $controller = new JobseekerSettingsController();
            $controller->updateSettings();
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

        // Jobseeker Programs Routes
        case 'programs-jobseeker':
            require_once __DIR__ . '/../app/controllers/JobseekerController.php';
            $controller = new JobseekerController();
            $controller->programsJobseeker();
            break;

        case 'event-info-jobseeker':
            require_once __DIR__ . '/../app/controllers/EventProgramController.php';
            $eventController = new EventProgramController();
            $event = null;
            if (isset($_GET['id']) && is_numeric($_GET['id'])) {
                $event = $eventController->getEventById($_GET['id']);
            }
            include __DIR__ . '/../app/views/jobseekers/event-info-jobseeker.php';
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
        case 'dashboard': // ADD this alias to handle the filtering URLs
            require_once __DIR__ . '/../app/controllers/EmployerDashboardController.php';
            $controller = new EmployerDashboardController();
            $controller->dashboard();
            break;
        case 'setting-employer':
        case 'settings-employer':
            require_once __DIR__ . '/../app/controllers/EmployerController.php';
            $controller = new EmployerController();
            $controller->settings();
            break;

        case 'employer-change-password':
            require_once __DIR__ . '/../app/controllers/EmployerController.php';
            $controller = new EmployerController();
            $controller->changePassword();
            break;

        case 'employer-deactivate-account':
            require_once __DIR__ . '/../app/controllers/EmployerController.php';
            $controller = new EmployerController();
            $controller->deactivateAccount();
            break;

        case 'employer-delete-account':
            require_once __DIR__ . '/../app/controllers/EmployerController.php';
            $controller = new EmployerController();
            $controller->deleteAccount();
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
        case 'job-applications':
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

        case 'notifications-admin':
            require_once __DIR__ . '/../app/controllers/AdminDashboardController.php';
            $controller = new AdminDashboardController();
            $controller->notifications(); // Use the controller method
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
            require_once __DIR__ . '/../app/controllers/AdminDashboardController.php';
            $controller = new AdminDashboardController();
            $controller->events(); // Use dashboard layout
            break;

        case 'admin-event-create':
            require_once __DIR__ . '/../app/controllers/AdminDashboardController.php';
            $controller = new AdminDashboardController();
            $controller->eventCreate(); // Use dashboard layout
            break;

        case 'admin-event-edit':
            require_once __DIR__ . '/../app/controllers/AdminDashboardController.php';
            $controller = new AdminDashboardController();
            $controller->eventEdit(); // Use dashboard layout
            break;

        // Event Operations Routes - Use existing EventProgramController
        case 'admin-event-store':
            require_once __DIR__ . '/../app/controllers/EventProgramController.php';
            $controller = new EventProgramController();
            $controller->store(); // Create event
            break;

        case 'admin-event-update':
            if (isset($_GET['id'])) {
                require_once __DIR__ . '/../app/controllers/EventProgramController.php';
                $controller = new EventProgramController();
                $controller->update($_GET['id']); // Update event
            } else {
                header('Location: ?page=admin-events&error=Invalid request');
            }
            break;

        case 'admin-event-delete':
            if (isset($_GET['id'])) {
                require_once __DIR__ . '/../app/controllers/EventProgramController.php';
                $controller = new EventProgramController();
                $controller->delete($_GET['id']); // Delete event
            } else {
                header('Location: ?page=admin-events&error=Invalid request');
            }
            break;

        case 'admin-event-toggle-status':
            if (isset($_GET['id'])) {
                require_once __DIR__ . '/../app/controllers/EventProgramController.php';
                $controller = new EventProgramController();
                $controller->toggleEventStatus($_GET['id']); // Toggle status
            } else {
                header('Location: ?page=admin-events&error=Invalid request');
            }
            break;

        case 'admin-event-toggle-pin':
            require_once __DIR__ . '/../app/controllers/EventProgramController.php';
            $controller = new EventProgramController();
            $controller->togglePin(); // Toggle pin status
            break;



        // Replace the User Management Routes section in index.php
        case 'admin-jobseekers':
            require_once __DIR__ . '/../app/controllers/AdminDashboardController.php';
            $controller = new AdminDashboardController();
            $controller->jobseekerManagement(); // ✅ This will use dashboard.php layout
            break;

        case 'admin-employers':
            require_once __DIR__ . '/../app/controllers/AdminDashboardController.php';
            $controller = new AdminDashboardController();
            $controller->employerManagement(); // ✅ This will use dashboard.php layout
            break;

        case 'admin-jobpost-management':
            require_once __DIR__ . '/../app/controllers/AdminDashboardController.php';
            $controller = new AdminDashboardController();
            $controller->jobpostManagement();
            break;

        case 'admin-accreditations':
            require_once __DIR__ . '/../app/controllers/AdminDashboardController.php';
            $controller = new AdminDashboardController();
            $controller->accreditations();
            break;

        case 'admin-review-accreditation':
            require_once __DIR__ . '/../app/controllers/AdminDashboardController.php';
            $controller = new AdminDashboardController();
            $controller->reviewAccreditation();
            break;

        case 'admin-process-accreditation':
            require_once __DIR__ . '/../app/controllers/AdminDashboardController.php';
            $controller = new AdminDashboardController();
            $controller->processAccreditation();
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

        case 'admin-toggle-job-status':
            require_once __DIR__ . '/../app/controllers/AdminDashboardController.php';
            $controller = new AdminDashboardController();
            $controller->updateJobStatus();
            break;

        case 'admin-delete-job':
            require_once __DIR__ . '/../app/controllers/AdminController.php';
            $controller = new AdminController();
            $controller->deleteJob();
            break;

        case 'admin-view-application':
            require_once __DIR__ . '/../app/controllers/AdminController.php';
            $controller = new AdminController();
            $controller->viewApplication();
            break;

        case 'admin-view-job':
            require_once __DIR__ . '/../app/controllers/AdminDashboardController.php';
            $controller = new AdminDashboardController();
            $controller->viewJob();
            break;

        case 'admin-reports':
            require_once __DIR__ . '/../app/controllers/AdminDashboardController.php';
            $controller = new AdminDashboardController();
            $controller->reports();
            break;

        case 'admin-applications':
            require_once __DIR__ . '/../app/controllers/AdminDashboardController.php';
            $controller = new AdminDashboardController();
            $controller->applications();
            break;

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

        case 'view-employer-document':
            require_once __DIR__ . '/../app/controllers/EmployerController.php';
            $controller = new EmployerController();
            $controller->viewDocument();
            break;

        case 'download-employer-document':
            require_once __DIR__ . '/../app/controllers/EmployerController.php';
            $controller = new EmployerController();
            if ($_GET['page'] === 'view-employer-document') {
                $controller->viewDocument();
            } else {
                $controller->downloadDocument();
            }
            break;

        case 'download-employer-document':
            require_once __DIR__ . '/../app/controllers/EmployerController.php';
            $controller = new EmployerController();
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
            // Start session if not started
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            // Clear all session data
            $_SESSION = array();

            // Delete the session cookie
            if (isset($_COOKIE[session_name()])) {
                setcookie(session_name(), '', time() - 3600, '/');
            }

            // Destroy the session
            session_destroy();

            // Redirect to login
            header('Location: ?page=login-jobseeker');
            exit();
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

        case 'recommended-jobs':
            require_once __DIR__ . '/../app/controllers/JobRecommendationController.php';
            $controller = new JobRecommendationController();
            $controller->recommendedJobs();
            break;

        case 'view-employer-profile':
            require_once __DIR__ . '/../app/controllers/JobseekerController.php';
            $controller = new JobseekerController();
            $controller->viewEmployerProfile();
            break;

        case 'explore-companies':
            require_once __DIR__ . '/../app/controllers/JobseekerController.php';
            $controller = new JobseekerController();
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

        case 'resign-from-job':
            require_once __DIR__ . '/../app/controllers/JobApplicationController.php';
            $controller = new JobApplicationController();
            $controller->resignFromJob();
            break;

        // Admin Accreditation Routes

        case 'upload-business-logo':
            require_once __DIR__ . '/../app/controllers/EmployerController.php';
            $controller = new EmployerController();
            $controller->uploadBusinessLogo();
            break;
        case 'saved-jobs':
            require_once __DIR__ . '/../app/controllers/SaveJobController.php';
            $controller = new SaveJobController();
            $controller->showSavedJobs();
            break;

        case 'save-job':
            require_once __DIR__ . '/../app/controllers/SaveJobController.php';
            $controller = new SaveJobController();
            $controller->saveJob();
            // No exit needed here since controller handles it
            break;

        case 'unsave-job':
            require_once __DIR__ . '/../app/controllers/SaveJobController.php';
            $controller = new SaveJobController();
            $controller->unsaveJob();
            // No exit needed here since controller handles it
            break;

        case 'setting-employer':
            require_once __DIR__ . '/../app/controllers/EmployerSettingsController.php';
            $controller = new EmployerSettingsController();
            $controller->showSettings();
            break;

        case 'update-employer-settings':
            require_once __DIR__ . '/../app/controllers/EmployerSettingsController.php';
            $controller = new EmployerSettingsController();
            $controller->updateSettings();
            break;

        case 'nlp-test':
            require_once __DIR__ . '/../app/controllers/NLPController.php';
            $controller = new NLPController();
            $controller->collectTrainingData();
            break;

        // Add any new cases here

        case 'download-job-attachment':
            require_once __DIR__ . '/../app/controllers/DocumentController.php';
            $controller = new DocumentController();
            $controller->downloadJobAttachment();
            break;

        case 'view-job-attachment':
            require_once __DIR__ . '/../app/controllers/DocumentController.php';
            $controller = new DocumentController();
            $controller->viewJobAttachment();
            break;

        case 'download-document':
            require_once __DIR__ . '/../app/controllers/DocumentController.php';
            $controller = new DocumentController();
            $controller->downloadDocument();
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

        case 'get-work-experience':
            require_once __DIR__ . '/../app/controllers/JobseekerController.php';
            $jobseekerController = new JobseekerController();
            $jobseekerController->getWorkExperienceById();
            break;

        case 'delete-work-experience':
            require_once __DIR__ . '/../app/controllers/JobseekerController.php';
            $jobseekerController = new JobseekerController();
            $jobseekerController->handleDeleteWorkExperience();
            break;


        case 'delete-skill-simple':
            require_once __DIR__ . '/../app/controllers/JobseekerController.php';
            $controller = new JobseekerController();
            $controller->deleteSkillSimple();
            break;

        case 'delete-certificate-simple':
            require_once __DIR__ . '/../app/controllers/JobseekerController.php';
            $controller = new JobseekerController();
            $controller->deleteCertificateSimple();
            break;


        case 'abt-sikap':
            include __DIR__ . '/../app/views/pages/abt-sikap.php';
            break;

        case 'customer-support':
            include __DIR__ . '/../app/views/pages/customer-support.php';
            break;

        case 'review-parsed-data':
            require_once __DIR__ . '/../app/controllers/JobseekerController.php';
            $controller = new JobseekerController();
            $controller->reviewParsedData();
            break;
        case 'settings-jobseeker':
            require_once __DIR__ . '/../app/controllers/JobseekerController.php';
            $controller = new JobseekerController();
            $controller->settings();
            break;

        case 'change-password':
            require_once __DIR__ . '/../app/controllers/JobseekerController.php';
            $controller = new JobseekerController();
            $controller->changePassword();
            break;

        case 'deactivate-account':
            require_once __DIR__ . '/../app/controllers/JobseekerController.php';
            $controller = new JobseekerController();
            $controller->deactivateAccount();
            break;

        case 'delete-account':
            require_once __DIR__ . '/../app/controllers/JobseekerController.php';
            $controller = new JobseekerController();
            $controller->deleteAccount();
            break;


        case 'job-details':
            require_once __DIR__ . '/../app/controllers/JobValidationController.php';
            $controller = new JobValidationController();
            $controller->validateJobDetails();
            break;

        case 'applications':
            require_once __DIR__ . '/../app/controllers/JobValidationController.php';
            $controller = new JobValidationController();
            $controller->validateApplicationsAccess();
            break;

        case 'job-posts':
            require_once __DIR__ . '/../app/controllers/JobValidationController.php';
            $controller = new JobValidationController();
            $controller->validateJobPostsAccess();
            break;

        case 'employer-programs':
            require_once __DIR__ . '/../app/controllers/JobValidationController.php';
            $controller = new JobValidationController();
            $controller->validateEmployerProgramsAccess();
            break;


        // FOOTER ROUTES
        case 'privacy-policy':
            include __DIR__ . '/../app/views/components/footer/privacy-policy.php';
            break;

        case 'terms-use':
            include __DIR__ . '/../app/views/components/footer/terms-use.php';
            break;

        case 'accessibility':
            include __DIR__ . '/../app/views/components/footer/accessibility.php';
            break;

        case 'accreditation':
            include __DIR__ . '/../app/views/components/footer/accreditation.php';
            break;

        case 'faqs':
            include __DIR__ . '/../app/views/components/footer/faqs.php';
            break;

        case 'help-center':
            include __DIR__ . '/../app/views/components/footer/help-center.php';
            break;

        case 'contact-support':
            include __DIR__ . '/../app/views/components/footer/contact-support.php';
            break;

        case 'feedback':
            include __DIR__ . '/../app/views/components/footer/feedback.php';
            break;

        case 'how-to-apply':
            include __DIR__ . '/../app/views/components/footer/how-to-apply.php';
            break;

        case 'resume-tips':
            include __DIR__ . '/../app/views/components/footer/resume-tips.php';
            break;

        case 'govt-programs':
            include __DIR__ . '/../app/views/components/footer/govt-programs.php';
            break;

        case 'career-training':
            include __DIR__ . '/../app/views/components/footer/career-training.php';
            break;

        // Employer Footer Routes
        case 'post-guide':
            include __DIR__ . '/../app/views/components/footer/post-guide.php';
            break;

        case 'employer-registration':
            include __DIR__ . '/../app/views/components/footer/employer-registration.php';
            break;

        case 'employer-partnerships':
            include __DIR__ . '/../app/views/components/footer/employer-partnerships.php';
            break;

        case 'hiring-laws':
            include __DIR__ . '/../app/views/components/footer/hiring-laws.php';
            break;

        case 'employer-reports':
            include __DIR__ . '/../app/views/components/footer/employer-reports.php';
            break;
    }


    $chatbotAllowedPages = [
        'landing',

        // Jobseeker routes
        'login-jobseeker',
        'signup-jobseeker',
        'jobseeker-dashboard',
        'profile-jobseeker',
        'profile-tab-content',
        'upload-profile-photo',
        'jobseeker-documents',
        'download-document',
        'jobseeker-applications',
        'settings-jobseeker',
        'update-jobseeker-settings',
        'verify-otp',
        'resend-otp',
        'programs-jobseeker',
        'event-info-jobseeker',
        'complete-jobseeker-profile',
        'profile-completion-success',
        'my-applications',
        'apply-job',
        'application-success',
        'view-application',
        'withdraw-application',
        'saved-jobs',
        'save-job',
        'unsave-job',

        // Employer routes
        'login-employer',
        'signup-employer',
        'employer-dashboard',
        'view-all-applicants',
        'view-applicants',
        'manage-applications',
        'review-application',
        'complete-employer-profile',
        'employer-personal-profile',
        'complete-employer-business',
        'profile-employer',
        'employer-profile-completion-success',
        'post-job',
        'job-post-success',
        'manage-jobs',
        'view-job',
        'view-employer-profile',
        'explore-companies',
        'view-employer-job',
        'browse-jobs',
        'edit-job',
        'delete-job',
        'toggle-job-status',
        'setting-employer',
        'update-employer-settings'
    ];

    // If current page is allowed, show chatbot
    if (in_array($page, $chatbotAllowedPages)) {
        include __DIR__ . '/../app/views/components/chatbot/chatbot.php';
    }
    ?>
</body>

</html>