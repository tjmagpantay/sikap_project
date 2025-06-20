<?php
// filepath: c:\xampp\htdocs\sikap\app\views\jobseekers\profile-components\jobseeker-documents.php
require_once __DIR__ . '/../../../models/Jobseeker.php';

$jobseekerModel = new Jobseeker();
$jobseeker = $jobseekerModel->findByUserId($_SESSION['user_id']);
$documents = $jobseekerModel->getDocuments($_SESSION['user_id']);
$workExperience = $jobseekerModel->getWorkExperience($_SESSION['user_id']);

if ($documents === false) $documents = [];
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
               class="pb-2 font-semibold text-green-600 border-b-2 border-green-500 transition-colors">
                Resume & Documents
            </a>
            <a href="?page=jobseeker-applications" 
               class="pb-2 text-gray-500 hover:text-green-600 transition-colors">
                Job Applications
            </a>
        </div>

        <!-- Documents Content -->
        <div class="mb-6">
            <div class="flex items-center justify-between mb-4">
                <h4 class="text-base font-semibold">Documents & Resume</h4>
                <a href="?page=complete-jobseeker-profile&step=1"
                   class="flex items-center text-sm text-green-600 hover:text-green-700">
                    <i class="mr-1 fas fa-upload"></i>
                    Upload New
                </a>
            </div>

            <?php if (!empty($documents) && is_array($documents)): ?>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <?php foreach ($documents as $doc): ?>
                        <div class="p-4 transition-colors border border-gray-200 rounded-lg hover:border-green-300">
                            <div class="flex items-center">
                                <i class="mr-3 text-2xl text-red-500 fas fa-file-pdf"></i>
                                <div class="flex-1">
                                    <h5 class="text-sm font-medium"><?php echo htmlspecialchars($doc['file_name'] ?? 'N/A'); ?></h5>
                                    <p class="text-xs text-gray-500 capitalize"><?php echo htmlspecialchars($doc['file_type'] ?? 'N/A'); ?></p>
                                    <p class="text-xs text-gray-400">
                                        Uploaded: <?php echo !empty($doc['uploaded_at']) ? date('M d, Y', strtotime($doc['uploaded_at'])) : 'N/A'; ?>
                                    </p>
                                </div>
                                <div class="flex flex-col space-y-1">
                                    <a href="?page=download-document&doc_id=<?php echo htmlspecialchars($doc['document_id'] ?? '#'); ?>" target="_blank"
                                       class="text-xs text-green-600 hover:text-green-700">
                                        <i class="mr-1 fas fa-eye"></i>View
                                    </a>
                                    <a href="?page=download-document&doc_id=<?php echo htmlspecialchars($doc['document_id'] ?? '#'); ?>&download=1" 
                                       class="text-xs text-blue-600 hover:text-blue-700">
                                        <i class="mr-1 fas fa-download"></i>Download
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="py-12 text-center">
                    <i class="mb-4 text-5xl text-gray-300 fas fa-file-upload"></i>
                    <h5 class="mb-2 text-lg font-medium text-gray-900">No Documents Uploaded</h5>
                    <p class="mb-6 text-sm text-gray-500">Upload your resume, CV, and other important documents to complete your profile.</p>
                    <a href="?page=complete-jobseeker-profile&step=1"
                       class="inline-flex items-center px-6 py-3 text-sm font-medium text-white bg-green-600 rounded-md hover:bg-green-700">
                        <i class="mr-2 fas fa-upload"></i>
                        Upload Resume/CV
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>