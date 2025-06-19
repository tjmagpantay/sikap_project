<?php
// filepath: app/views/jobseekers/job-application/view-job.php
include_once __DIR__ . '/../../components/navbar-top.php';
include_once __DIR__ . '/../navbar-jobseeker.php';
?>

<div class="py-6 mx-auto max-w-4xl sm:px-6 lg:px-8">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="?page=browse-jobs" class="text-blue-600 hover:text-blue-800">
            <i class="mr-1 fas fa-arrow-left"></i> Back to Jobs
        </a>
    </div>

    <!-- Job Details -->
    <div class="bg-white shadow rounded-lg p-6">
        <!-- Job Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900"><?php echo htmlspecialchars($job['job_title']); ?></h1>
            
            <?php 
            // Safely get company name with fallback options
            $companyName = '';
            if (!empty($job['company_name'])) {
                $companyName = $job['company_name'];
            } elseif (!empty($job['business_name'])) {
                $companyName = $job['business_name'];
            } elseif (isset($job['employer_first_name']) && isset($job['employer_last_name'])) {
                $companyName = trim($job['employer_first_name'] . ' ' . $job['employer_last_name']);
            } else {
                $companyName = 'Company Name Not Available';
            }
            ?>
            <p class="text-xl text-gray-600 mt-2"><?php echo htmlspecialchars($companyName); ?></p>
            
            <!-- Job Meta Info -->
            <div class="mt-4 flex flex-wrap gap-4 text-sm text-gray-500">
                <span><i class="fas fa-map-marker-alt mr-1"></i><?php echo htmlspecialchars($job['location'] ?? 'Location not specified'); ?></span>
                <span><i class="fas fa-briefcase mr-1"></i><?php echo ucfirst(str_replace('-', ' ', $job['job_type'] ?? 'full-time')); ?></span>
                <?php if (!empty($job['show_pay']) && !empty($job['salary'])): ?>
                    <span><i class="fas fa-money-bill mr-1"></i>₱<?php echo number_format($job['salary'], 2); ?></span>
                <?php endif; ?>
                <span><i class="fas fa-calendar mr-1"></i>Posted <?php echo date('M j, Y', strtotime($job['created_at'])); ?></span>
            </div>
        </div>

        <!-- Job Description -->
        <div class="mb-6">
            <h3 class="text-lg font-medium text-gray-900 mb-3">Job Description</h3>
            <div class="prose text-gray-700">
                <?php echo nl2br(htmlspecialchars($job['job_summary'] ?? 'No job description available.')); ?>
            </div>
        </div>

        <!-- Requirements -->
        <?php if (!empty($job['requirements'])): ?>
        <div class="mb-6">
            <h3 class="text-lg font-medium text-gray-900 mb-3">Requirements</h3>
            <div class="prose text-gray-700">
                <?php echo nl2br(htmlspecialchars($job['requirements'])); ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Responsibilities -->
        <?php if (!empty($job['responsibilities'])): ?>
        <div class="mb-6">
            <h3 class="text-lg font-medium text-gray-900 mb-3">Responsibilities</h3>
            <div class="prose text-gray-700">
                <?php echo nl2br(htmlspecialchars($job['responsibilities'])); ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Job Details Section -->
        <div class="mb-6">
            <h3 class="text-lg font-medium text-gray-900 mb-3">Job Details</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <span class="text-sm font-medium text-gray-500">Job Type:</span>
                    <p class="text-sm text-gray-900"><?php echo ucfirst(str_replace('-', ' ', $job['job_type'] ?? 'Not specified')); ?></p>
                </div>
                <div>
                    <span class="text-sm font-medium text-gray-500">Location:</span>
                    <p class="text-sm text-gray-900"><?php echo htmlspecialchars($job['location'] ?? 'Not specified'); ?></p>
                </div>
                <?php if (!empty($job['category_name'])): ?>
                <div>
                    <span class="text-sm font-medium text-gray-500">Category:</span>
                    <p class="text-sm text-gray-900"><?php echo htmlspecialchars($job['category_name']); ?></p>
                </div>
                <?php endif; ?>
                <?php if (!empty($job['show_pay']) && !empty($job['salary'])): ?>
                <div>
                    <span class="text-sm font-medium text-gray-500">Salary:</span>
                    <p class="text-sm text-gray-900">₱<?php echo number_format($job['salary'], 2); ?></p>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Apply Button - Use data from controller -->
        <div class="mt-6">
            <?php if (!isset($_SESSION['user_id'])): ?>
                <a href="?page=login-jobseeker" 
                   class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                    Sign in to Apply
                </a>
            <?php elseif (!isset($_SESSION['role']) || $_SESSION['role'] != User::ROLE_JOBSEEKER): ?>
                <p class="text-center text-gray-500 py-3">Only job seekers can apply for jobs</p>
            <?php elseif (isset($hasApplied) && $hasApplied): ?>
                <div class="flex flex-col space-y-2">
                    <span class="w-full flex justify-center py-3 px-4 border border-gray-300 rounded-md text-sm font-medium text-gray-500 bg-gray-100">
                        <i class="mr-2 fas fa-check-circle"></i>
                        Application Submitted
                    </span>
                    <a href="?page=my-applications" 
                       class="text-center text-sm text-blue-600 hover:text-blue-800">
                        View your applications
                    </a>
                </div>
            <?php elseif (isset($job['job_status']) && $job['job_status'] !== 'open'): ?>
                <span class="w-full flex justify-center py-3 px-4 border border-gray-300 rounded-md text-sm font-medium text-gray-500 bg-gray-100">
                    This job is no longer accepting applications
                </span>
            <?php else: ?>
                <a href="?page=apply-job&job_id=<?php echo $job['job_id']; ?>&step=1" 
                   class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                    <i class="mr-2 fas fa-paper-plane"></i>
                    Apply for this Job
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>