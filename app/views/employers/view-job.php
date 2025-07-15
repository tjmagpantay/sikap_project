<?php
// Create file: app/views/employers/view-job.php
include_once __DIR__ . '/../components/navbar-top.php';
include_once __DIR__ . '../components/navbar-employer.php'; 
?>

<div class="py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <!-- <a href="?page=manage-jobs" class="text-blue-600 hover:text-blue-800">
                    <i class="mr-1 fas fa-arrow-left"></i> Back to Manage Jobs
                </a> -->
                <h1 class="mt-2 text-3xl font-bold text-gray-900"><?php echo htmlspecialchars($job['job_title']); ?></h1>
                <div class="flex items-center mt-2 space-x-4">
                    <span class="inline-flex items-center px-3 py-1 text-sm font-medium rounded-full
                        <?php 
                        switch($job['job_status']) {
                            case 'open': echo 'bg-green-100 text-green-800'; break;
                            case 'closed': echo 'bg-red-100 text-red-800'; break;
                            case 'paused': echo 'bg-yellow-100 text-yellow-800'; break;
                            case 'draft': echo 'bg-gray-100 text-gray-800'; break;
                            default: echo 'bg-gray-100 text-gray-800';
                        }
                        ?>">
                        <?php echo ucfirst($job['job_status']); ?>
                    </span>
                    <span class="text-sm text-gray-500">
                        Posted on <?php echo date('F j, Y', strtotime($job['created_at'])); ?>
                    </span>
                </div>
            </div>
            <div class="flex space-x-2">
                <a href="?page=edit-job&id=<?php echo $job['job_id']; ?>" 
                   class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                    <i class="mr-1 fas fa-edit"></i> Edit Job
                </a>
                
                <?php if ($job['job_status'] == 'open'): ?>
                    <a href="?page=toggle-job-status&id=<?php echo $job['job_id']; ?>&status=paused" 
                       class="px-4 py-2 text-sm font-medium text-yellow-700 bg-yellow-100 border border-yellow-300 rounded-md hover:bg-yellow-200">
                        <i class="mr-1 fas fa-pause"></i> Pause
                    </a>
                <?php elseif ($job['job_status'] == 'paused'): ?>
                    <a href="?page=toggle-job-status&id=<?php echo $job['job_id']; ?>&status=open" 
                       class="px-4 py-2 text-sm font-medium text-green-700 bg-green-100 border border-green-300 rounded-md hover:bg-green-200">
                        <i class="mr-1 fas fa-play"></i> Reopen
                    </a>
                <?php endif; ?>
                
                <a href="?page=delete-job&id=<?php echo $job['job_id']; ?>" 
                   onclick="return confirm('Are you sure you want to delete this job? This action cannot be undone.')"
                   class="px-4 py-2 text-sm font-medium text-red-700 bg-red-100 border border-red-300 rounded-md hover:bg-red-200">
                    <i class="mr-1 fas fa-trash"></i> Delete
                </a>
            </div>
        </div>
    </div>

    <!-- Job Details -->
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <!-- Main Content -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Job Details</h3>
                </div>
                <div class="px-6 py-4 space-y-6">
                    <!-- Basic Info -->
                    <div>
                        <h4 class="mb-2 text-sm font-medium text-gray-900">Basic Information</h4>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="font-medium text-gray-500">Category:</span>
                                <span class="ml-2"><?php echo htmlspecialchars($job['category_name'] ?? 'N/A'); ?></span>
                            </div>
                            <div>
                                <span class="font-medium text-gray-500">Type:</span>
                                <span class="ml-2"><?php echo ucfirst(str_replace('-', ' ', $job['job_type'])); ?></span>
                            </div>
                            <div>
                                <span class="font-medium text-gray-500">Location:</span>
                                <span class="ml-2"><?php echo htmlspecialchars($job['location']); ?></span>
                            </div>
                            <div>
                                <span class="font-medium text-gray-500">Workplace:</span>
                                <span class="ml-2"><?php echo ucfirst($job['workplace_option']); ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- Salary Info -->
                    <?php if ($job['show_pay'] && ($job['salary'] || $job['pay_range'])): ?>
                    <div>
                        <h4 class="mb-2 text-sm font-medium text-gray-900">Compensation</h4>
                        <div class="text-sm">
                            <?php if ($job['salary']): ?>
                                <div>
                                    <span class="font-medium text-gray-500">Salary:</span>
                                    <span class="ml-2">₱<?php echo number_format($job['salary'], 2); ?></span>
                                    <?php if ($job['pay_type']): ?>
                                        <span class="text-gray-500">/ <?php echo $job['pay_type']; ?></span>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                            <?php if ($job['pay_range']): ?>
                                <div>
                                    <span class="font-medium text-gray-500">Pay Range:</span>
                                    <span class="ml-2"><?php echo htmlspecialchars($job['pay_range']); ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Job Summary -->
                    <div>
                        <h4 class="mb-2 text-sm font-medium text-gray-900">Job Summary</h4>
                        <p class="text-sm text-gray-700"><?php echo nl2br(htmlspecialchars($job['job_summary'])); ?></p>
                    </div>

                    <!-- Full Description -->
                    <?php if ($job['full_description']): ?>
                    <div>
                        <h4 class="mb-2 text-sm font-medium text-gray-900">Full Description</h4>
                        <div class="text-sm prose text-gray-700 max-w-none">
                            <?php echo nl2br(htmlspecialchars($job['full_description'])); ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Skills -->
                    <?php if (!empty($job['skills'])): ?>
                    <div>
                        <h4 class="mb-2 text-sm font-medium text-gray-900">Required Skills</h4>
                        <div class="flex flex-wrap gap-2">
                            <?php foreach ($job['skills'] as $skill): ?>
                                <span class="px-2 py-1 text-xs font-medium text-blue-800 bg-blue-100 rounded-full">
                                    <?php echo htmlspecialchars($skill); ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Application Dates -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Application Period</h3>
                </div>
                <div class="px-6 py-4 space-y-3 text-sm">
                    <?php if ($job['application_start']): ?>
                    <div>
                        <span class="font-medium text-gray-500">Start Date:</span>
                        <div class="mt-1"><?php echo date('F j, Y', strtotime($job['application_start'])); ?></div>
                    </div>
                    <?php endif; ?>
                    
                    <?php if ($job['application_deadline']): ?>
                    <div>
                        <span class="font-medium text-gray-500">Deadline:</span>
                        <div class="mt-1"><?php echo date('F j, Y', strtotime($job['application_deadline'])); ?></div>
                    </div>
                    <?php endif; ?>
                    
                    <?php if (!$job['application_start'] && !$job['application_deadline']): ?>
                    <div class="text-gray-500">No specific application period set</div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Statistics -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Application Statistics</h3>
                </div>
                <div class="px-6 py-4 space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Total Applications:</span>
                        <span class="font-medium"><?php echo $job['total_applications']; ?></span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Pending Review:</span>
                        <span class="font-medium text-yellow-600"><?php echo $job['pending_count']; ?></span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Shortlisted:</span>
                        <span class="font-medium text-purple-600"><?php echo $job['shortlisted_count']; ?></span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Hired:</span>
                        <span class="font-medium text-green-600"><?php echo $job['hired_count']; ?></span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Posted:</span>
                        <span class="font-medium"><?php echo date('M j, Y', strtotime($job['created_at'])); ?></span>
                    </div>
                    <?php if ($job['updated_at'] != $job['created_at']): ?>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Last Updated:</span>
                        <span class="font-medium"><?php echo date('M j, Y', strtotime($job['updated_at'])); ?></span>
                    </div>
                    <?php endif; ?>
                </div>
                
                <!-- Quick Actions -->
                <?php if ($job['total_applications'] > 0): ?>
                <div class="px-6 py-4 border-t border-gray-200">
                    <a href="?page=manage-applications&job_id=<?php echo $job['job_id']; ?>" 
                       class="inline-flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                        <i class="mr-2 fas fa-users"></i>
                        View All Applications
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>