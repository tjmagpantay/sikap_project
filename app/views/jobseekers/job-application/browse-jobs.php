<?php
// filepath: app/views/jobseekers/job-application/browse-jobs.php
include_once __DIR__ . '/../../components/navbar-top.php';
include_once __DIR__ . '/../navbar-jobseeker.php';
?>

<div class="py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Browse Jobs</h1>
        <p class="mt-2 text-sm text-gray-600">Find your perfect job opportunity</p>
    </div>
    
    <!-- Job Listings -->
    <?php if (empty($jobs)): ?>
        <div class="text-center py-12">
            <i class="fas fa-briefcase text-6xl text-gray-400 mb-4"></i>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No jobs available</h3>
            <p class="text-gray-500">Check back later for new job postings</p>
        </div>
    <?php else: ?>
        <div class="space-y-6">
            <?php foreach ($jobs as $job): ?>
                <div class="bg-white shadow rounded-lg p-6">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <h3 class="text-xl font-semibold text-gray-900">
                                <a href="?page=view-job&job_id=<?php echo $job['job_id']; ?>" class="hover:text-blue-600">
                                    <?php echo htmlspecialchars($job['job_title']); ?>
                                </a>
                            </h3>
                            
                            <?php 
                            $companyName = '';
                            if (!empty($job['company_name'])) {
                                $companyName = $job['company_name'];
                            } elseif (!empty($job['business_name'])) {
                                $companyName = $job['business_name'];
                            } elseif (isset($job['employer_first_name']) && isset($job['employer_last_name'])) {
                                $companyName = trim($job['employer_first_name'] . ' ' . $job['employer_last_name']);
                            } else {
                                $companyName = 'Company';
                            }
                            ?>
                            <p class="text-gray-600 mt-1"><?php echo htmlspecialchars($companyName); ?></p>
                            <p class="text-gray-700 mt-2"><?php echo substr(htmlspecialchars($job['job_summary']), 0, 200) . '...'; ?></p>
                            
                            <div class="mt-4 flex flex-wrap gap-4 text-sm text-gray-500">
                                <span><i class="fas fa-map-marker-alt mr-1"></i><?php echo htmlspecialchars($job['location']); ?></span>
                                <span><i class="fas fa-briefcase mr-1"></i><?php echo ucfirst(str_replace('-', ' ', $job['job_type'])); ?></span>
                                <?php if ($job['show_pay'] && $job['salary']): ?>
                                    <span><i class="fas fa-money-bill mr-1"></i>₱<?php echo number_format($job['salary'], 2); ?></span>
                                <?php endif; ?>
                                <span><i class="fas fa-calendar mr-1"></i><?php echo date('M j, Y', strtotime($job['created_at'])); ?></span>
                            </div>
                        </div>
                        
                        <div class="ml-6 flex flex-col space-y-2">
                            <a href="?page=view-job&job_id=<?php echo $job['job_id']; ?>" 
                               class="px-4 py-2 text-sm font-medium text-blue-600 bg-blue-100 border border-blue-300 rounded-md hover:bg-blue-200">
                                View Details
                            </a>
                            
                            <!-- Apply Button - Use data from controller instead of checking in view -->
                            <?php if (!isset($_SESSION['user_id'])): ?>
                                <a href="?page=login-jobseeker" 
                                   class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                                    Sign in to Apply
                                </a>
                            <?php elseif ($_SESSION['role'] != User::ROLE_JOBSEEKER): ?>
                                <span class="px-4 py-2 text-sm font-medium text-gray-500 bg-gray-100 border border-gray-300 rounded-md">
                                    Employers cannot apply
                                </span>
                            <?php elseif (isset($job['has_applied']) && $job['has_applied']): ?>
                                <span class="px-4 py-2 text-sm font-medium text-gray-500 bg-gray-100 border border-gray-300 rounded-md">
                                    <i class="mr-1 fas fa-check-circle"></i>
                                    Applied
                                </span>
                            <?php elseif ($job['job_status'] !== 'open'): ?>
                                <span class="px-4 py-2 text-sm font-medium text-gray-500 bg-gray-100 border border-gray-300 rounded-md">
                                    Not accepting applications
                                </span>
                            <?php else: ?>
                                <a href="?page=apply-job&job_id=<?php echo $job['job_id']; ?>" 
                                   class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                                    <i class="mr-1 fas fa-paper-plane"></i>
                                    Apply Now
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>