<?php
// filepath: c:\xampp\htdocs\sikap\app\views\jobseekers\profile-components\jobseeker-applications.php
require_once __DIR__ . '/../../../models/Jobseeker.php';

$jobseekerModel = new Jobseeker();
$jobseeker = $jobseekerModel->findByUserId($_SESSION['user_id']);
$workExperience = $jobseekerModel->getWorkExperience($_SESSION['user_id']);

if ($workExperience === false) $workExperience = [];
if ($jobseeker === false) {
    $jobseeker = ['first_name' => '', 'last_name' => '', 'contact_no' => ''];
}

$completionPercentage = $jobseekerModel->calculateProfileCompletion($_SESSION['user_id']);
if ($completionPercentage === false) $completionPercentage = 0;
?>

<?php include_once __DIR__ . '/../../components/navbar-top.php';
include_once __DIR__ . '/../navbar-jobseeker.php';
?>

<div class="flex flex-col min-h-screen gap-6 p-6 font-sans bg-gray-100 md:flex-row">
    <!-- Sidebar -->
    <?php include_once __DIR__ . '/profile-sidebar.php'; ?>

    <!-- Main Content -->
    <div class="w-full p-6 bg-white shadow md:w-3/4 rounded-xl">
        <!-- Page Navigation -->
        <div class="flex mb-4 space-x-8 border-b">
            <a href="?page=profile-jobseeker" 
               class="pb-2 text-gray-500 hover:text-green-600 transition-colors">
                Applicant Profile
            </a>
            <a href="?page=jobseeker-documents" 
               class="pb-2 text-gray-500 hover:text-green-600 transition-colors">
                Resume & Documents
            </a>
            <a href="?page=jobseeker-applications" 
               class="pb-2 font-semibold text-green-600 border-b-2 border-green-500 transition-colors">
                Job Applications
            </a>
        </div>

        <!-- Applications Content -->
        <div class="mb-6">
            <h4 class="mb-4 text-base font-semibold">My Job Applications</h4>
            
            <!-- Temporary placeholder until job application system is built -->
            <div class="py-12 text-center">
                <i class="mb-4 text-5xl text-gray-300 fas fa-briefcase"></i>
                <h5 class="mb-2 text-lg font-medium text-gray-900">Job Application System</h5>
                <p class="mb-6 text-sm text-gray-500">This feature will be available once the job posting and application system is completed.</p>
                <div class="inline-flex items-center px-6 py-3 text-sm font-medium text-gray-600 bg-gray-100 rounded-md">
                    <i class="mr-2 fas fa-tools"></i>
                    Coming Soon
                </div>
            </div>
        </div>
    </div>
</div>