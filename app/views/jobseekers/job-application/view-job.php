<?php
// filepath: app/views/jobseekers/job-application/view-job.php
include_once __DIR__ . '/../../components/navbar-top.php';
include_once __DIR__ . '/../navbar-jobseeker.php';
?>

<div class="min-h-screen bg-gray-50">
    <div class="py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="?page=browse-jobs" class="inline-flex items-center text-sm font-medium text-primary hover:text-secondary">
                <i class="mr-2 fas fa-arrow-left"></i> Back to Jobs
            </a>
        </div>

        <!-- Job Details Card -->
        <div class="overflow-hidden bg-white border border-gray-200 shadow-sm rounded-xl">
            <!-- Job Header -->
            <div class="p-6 border-b border-gray-200 bg-gray-50">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900"><?php echo htmlspecialchars($job['job_title']); ?></h1>
                        
                        <?php 
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
                        <p class="mt-1 text-lg text-gray-600"><?php echo htmlspecialchars($companyName); ?></p>
                    </div>
                    
                    <!-- Status Badge -->
                    <div class="mt-3 md:mt-0">
                        <span class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full 
                            <?php echo $job['job_status'] === 'open' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'; ?>">
                            <?php echo ucfirst($job['job_status']); ?>
                        </span>
                    </div>
                </div>

                <!-- Job Meta Info -->
                <div class="flex flex-wrap items-center gap-4 mt-4 text-sm">
                    <div class="flex items-center text-gray-600">
                        <i class="mr-1.5 text-gray-400 fas fa-map-marker-alt"></i>
                        <?php echo htmlspecialchars($job['location'] ?? 'Location not specified'); ?>
                    </div>
                    <div class="flex items-center text-gray-600">
                        <i class="mr-1.5 text-gray-400 fas fa-briefcase"></i>
                        <?php echo ucfirst(str_replace('-', ' ', $job['job_type'] ?? 'full-time')); ?>
                    </div>
                    <?php if (!empty($job['show_pay']) && !empty($job['salary'])): ?>
                        <div class="flex items-center text-gray-600">
                            <i class="mr-1.5 text-gray-400 fas fa-money-bill-wave"></i>
                            ₱<?php echo number_format($job['salary'], 2); ?>
                        </div>
                    <?php endif; ?>
                    <div class="flex items-center text-gray-600">
                        <i class="mr-1.5 text-gray-400 fas fa-clock"></i>
                        Posted <?php echo date('M j, Y', strtotime($job['created_at'])); ?>
                    </div>
                </div>
            </div>

            <!-- Job Content -->
            <div class="p-6">
                <!-- Job Description -->
                <div class="mb-8">
                    <h3 class="mb-3 text-lg font-semibold text-gray-900">
                        <i class="mr-2 text-primary fas fa-align-left"></i>Job Description
                    </h3>
                    <div class="pl-8 prose text-gray-700">
                        <?php echo nl2br(htmlspecialchars($job['job_summary'] ?? 'No job description available.')); ?>
                    </div>
                </div>

                <!-- Requirements -->
                <?php if (!empty($job['requirements'])): ?>
                <div class="mb-8">
                    <h3 class="mb-3 text-lg font-semibold text-gray-900">
                        <i class="mr-2 text-primary fas fa-clipboard-check"></i>Requirements
                    </h3>
                    <div class="pl-8 prose text-gray-700">
                        <?php echo nl2br(htmlspecialchars($job['requirements'])); ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Responsibilities -->
                <?php if (!empty($job['responsibilities'])): ?>
                <div class="mb-8">
                    <h3 class="mb-3 text-lg font-semibold text-gray-900">
                        <i class="mr-2 text-primary fas fa-tasks"></i>Responsibilities
                    </h3>
                    <div class="pl-8 prose text-gray-700">
                        <?php echo nl2br(htmlspecialchars($job['responsibilities'])); ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Job Details Section -->
                <div class="mb-8">
                    <h3 class="mb-4 text-lg font-semibold text-gray-900">
                        <i class="mr-2 text-primary fas fa-info-circle"></i>Job Details
                    </h3>
                    <div class="grid grid-cols-1 gap-4 pl-8 sm:grid-cols-2">
                        <div class="flex">
                            <div class="flex-shrink-0 mr-3 text-gray-400">
                                <i class="fas fa-briefcase"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Job Type</p>
                                <p class="text-sm text-gray-900"><?php echo ucfirst(str_replace('-', ' ', $job['job_type'] ?? 'Not specified')); ?></p>
                            </div>
                        </div>
                        <div class="flex">
                            <div class="flex-shrink-0 mr-3 text-gray-400">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Location</p>
                                <p class="text-sm text-gray-900"><?php echo htmlspecialchars($job['location'] ?? 'Not specified'); ?></p>
                            </div>
                        </div>
                        <?php if (!empty($job['category_name'])): ?>
                        <div class="flex">
                            <div class="flex-shrink-0 mr-3 text-gray-400">
                                <i class="fas fa-tag"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Category</p>
                                <p class="text-sm text-gray-900"><?php echo htmlspecialchars($job['category_name']); ?></p>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty($job['show_pay']) && !empty($job['salary'])): ?>
                        <div class="flex">
                            <div class="flex-shrink-0 mr-3 text-gray-400">
                                <i class="fas fa-money-bill-wave"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Salary</p>
                                <p class="text-sm text-gray-900">₱<?php echo number_format($job['salary'], 2); ?></p>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Apply Button Section -->
            <div class="p-6 border-t border-gray-200">
                <?php if (!isset($_SESSION['user_id'])): ?>
                    <a href="?page=login-jobseeker" 
                       class="w-full btn-primary">
                        <i class="mr-2 fas fa-sign-in-alt"></i> Sign in to Apply
                    </a>
                <?php elseif (!isset($_SESSION['role']) || $_SESSION['role'] != User::ROLE_JOBSEEKER): ?>
                    <div class="p-4 text-center rounded-lg bg-gray-50">
                        <p class="text-gray-600">Only job seekers can apply for jobs</p>
                    </div>
                <?php elseif (isset($hasApplied) && $hasApplied): ?>
                    <div class="flex flex-col items-center space-y-3">
                        <span class="w-full px-4 py-3 text-sm font-medium text-center text-gray-600 bg-gray-100 border border-gray-300 rounded-md">
                            <i class="mr-2 text-green-500 fas fa-check-circle"></i>
                            Application Submitted
                        </span>
                        <a href="?page=my-applications" 
                           class="text-sm font-medium text-primary hover:text-secondary">
                            View your applications
                        </a>
                    </div>
                <?php elseif (isset($job['job_status']) && $job['job_status'] !== 'open'): ?>
                    <div class="p-4 text-center rounded-lg bg-gray-50">
                        <p class="text-gray-600">This job is no longer accepting applications</p>
                    </div>
                <?php else: ?>
                    <a href="?page=apply-job&job_id=<?php echo $job['job_id']; ?>&step=1" 
                       class="w-full btn-primary">
                        <i class="mr-2 fas fa-paper-plane"></i> Apply for this Job
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>