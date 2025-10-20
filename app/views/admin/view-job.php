<?php

// ✅ Add check for job data
if (!isset($job) || empty($job)) {
    echo '<div class="p-8 text-center bg-white border border-gray-200 rounded-lg">';
    echo '<i class="mb-4 text-4xl text-gray-400 fas fa-exclamation-triangle"></i>';
    echo '<p class="text-gray-500">Job details could not be loaded.</p>';
    echo '<a href="?page=admin-jobpost-management" class="inline-flex items-center mt-4 text-sm text-blue-600 hover:text-blue-900">';
    echo '<svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">';
    echo '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>';
    echo '</svg>';
    echo 'Back to Job Management';
    echo '</a>';
    echo '</div>';
    return;
}
?>

<!-- Remove ALL HTML structure - make it content-only like main-board.php -->
<div class="space-y-6">
    <!-- Header Section -->
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="?page=admin-jobpost-management"
                    class="inline-flex items-center text-sm text-gray-500 transition-colors hover:text-gray-700">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Back to Job Management
                </a>
            </div>
            <div class="flex items-center gap-3">
                <!-- Job Status Badge -->
                <?php
                $statusClasses = [
                    'open' => 'bg-green-100 text-green-800',
                    'closed' => 'bg-red-100 text-red-800',
                    'draft' => 'bg-gray-100 text-gray-800',
                ];
                $statusClass = $statusClasses[$job['job_status'] ?? 'draft'] ?? 'bg-gray-100 text-gray-800';
                ?>
                <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full <?php echo $statusClass; ?>">
                    <?php echo ucfirst($job['job_status'] ?? 'Draft'); ?>
                </span>

                <!-- Action Buttons -->
                <div class="flex items-center space-x-2">
                    <div class="relative" x-data="{ open: false }" @click.away="open = false">
                        <button @click="open = !open"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 transition-colors bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                            Change Status
                            <svg class="w-4 h-4 ml-2 -mr-1 transition-transform duration-200 transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <div x-show="open"
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute right-0 z-50 w-48 mt-2 origin-top-right bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                            <div class="py-1">
                                
                                <?php if ($job['job_status'] !== 'closed'): ?>
                                    <button onclick="changeJobStatus(<?php echo $job['job_id']; ?>, 'closed'); this.closest('[x-data]').__x.$data.open = false;"
                                        class="flex items-center w-full px-4 py-2 text-sm text-left text-gray-700 transition-colors hover:bg-gray-50">
                                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        Close Job
                                    </button>
                                <?php endif; ?>
                                <hr class="my-1">
                                <button onclick="deleteJob(<?php echo $job['job_id']; ?>); this.closest('[x-data]').__x.$data.open = false;"
                                    class="flex items-center w-full px-4 py-2 text-sm text-left text-red-600 transition-colors hover:bg-red-50">
                                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Delete Job
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ✅ Messages Section -->
    <?php if (!empty($error)): ?>
        <div class="p-4 mb-4 text-red-700 border border-red-200 rounded-lg bg-red-50">
            <div class="flex items-center">
                <i class="mr-2 fas fa-exclamation-circle"></i>
                <?php echo htmlspecialchars($error); ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <div class="p-4 mb-4 text-green-700 border border-green-200 rounded-lg bg-green-50">
            <div class="flex items-center">
                <i class="mr-2 fas fa-check-circle"></i>
                <?php echo htmlspecialchars($success); ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Main Content Layout -->
    <div class="flex flex-col gap-6 lg:flex-row lg:gap-8">
        <!-- Left Section - Main Content (8/12) -->
        <div class="w-full space-y-6 lg:w-8/12">
            <!-- Job Details Card -->
            <div class="overflow-hidden bg-white border border-gray-200 shadow-sm rounded-xl">
                <!-- Job Header -->
                <div class="p-4 border-b border-gray-200 sm:p-6 bg-gray-50">
                    <div class="flex items-end justify-between mb-4">
                        <div class="flex items-center gap-3 sm:gap-4">
                            <!-- Company Logo -->
                            <div class="flex items-center justify-center flex-shrink-0 w-16 h-16 overflow-hidden border-2 border-gray-200 rounded-lg sm:w-12 sm:h-12">
                                <?php if (!empty($job['business_logo'])): ?>
                                    <img src="<?php echo htmlspecialchars($job['business_logo']); ?>" alt="Company Logo"
                                        class="object-cover w-full h-full">
                                <?php else: ?>
                                    <svg class="w-6 h-6 text-gray-400 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-2m-2 0H7m5 0v-1a3 3 0 00-3-3H7a3 3 0 00-3 3v1m5-4v-4a1 1 0 011-1h4a1 1 0 011 1v4"></path>
                                    </svg>
                                <?php endif; ?>
                            </div>

                            <!-- Text Section -->
                            <div class="flex flex-col justify-center flex-1">
                                <h1 class="text-lg font-semibold text-gray-900 sm:text-xl">
                                    <?php echo htmlspecialchars($job['job_title'] ?? 'Untitled Job'); ?>
                                </h1>

                                <!-- Company Name -->
                                <div class="text-sm transition-colors text-primary hover:text-secondary">
                                    <?php echo htmlspecialchars($job['company_name'] ?? 'Unknown Company'); ?>
                                </div>
                            </div>
                        </div>


                        <!-- Job Info -->
                        <div class="text-xs text-right text-gray-500">
                            <div>Posted: <?php echo date('M j, Y', strtotime($job['created_at'])); ?></div>
                        </div>
                    </div>

                    <!-- Application Timeline Bar -->
                    <?php if (!empty($job['application_start']) || !empty($job['application_deadline'])): ?>
                        <div class="flex flex-row justify-between gap-6 p-3 mx-2 bg-white border border-gray-100 rounded-lg sm:p-4 sm:mx-4">
                            <div class="text-start">
                                <div class="text-xs text-gray-400">Days remaining</div>
                                <div class="text-sm font-medium text-primary">
                                    <?php
                                    if (!empty($job['application_deadline'])) {
                                        $deadline = new DateTime($job['application_deadline']);
                                        $now = new DateTime();
                                        if ($deadline > $now) {
                                            echo $now->diff($deadline)->days;
                                        } else {
                                            echo '0 (Expired)';
                                        }
                                    } else {
                                        echo '∞';
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="text-start">
                                <div class="text-xs text-gray-400">Application Start</div>
                                <div class="text-sm font-medium text-primary">
                                    <?php echo $job['application_start'] ? date('M j, Y', strtotime($job['application_start'])) : 'Immediately'; ?>
                                </div>
                            </div>
                            <div class="text-start">
                                <div class="text-xs text-gray-400">Application End</div>
                                <div class="text-sm font-medium text-primary">
                                    <?php echo $job['application_deadline'] ? date('M j, Y', strtotime($job['application_deadline'])) : 'No deadline'; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Main Content -->
                <div class="p-4 sm:p-6">
                    <!-- Job Summary -->
                    <div class="mb-8">
                        <h2 class="mb-3 font-semibold text-primary text-md">Job Summary</h2>
                        <div class="text-sm font-light leading-relaxed text-gray-600">
                            <?php echo nl2br(htmlspecialchars($job['job_summary'] ?? 'No job summary provided.')); ?>
                        </div>
                    </div>

                    <!-- Skills Required -->
                    <?php if (!empty($job['skills']) && is_array($job['skills'])): ?>
                        <div class="mb-8">
                            <h2 class="mb-3 font-semibold text-primary text-md">Skills Required</h2>
                            <div class="flex flex-wrap gap-2">
                                <?php foreach (array_unique($job['skills']) as $skill): ?>
                                    <span class="px-3 py-1 text-sm font-light text-gray-600 bg-gray-100 rounded-sm">
                                        <?php echo htmlspecialchars($skill); ?>
                                    </span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Basic Information -->
                    <div class="mb-8">
                        <h2 class="mb-3 font-semibold text-primary text-md">Basic Information</h2>
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <div class="text-xs text-gray-400">Category</div>
                                <div class="text-sm text-primary"><?php echo htmlspecialchars($job['category_name'] ?? 'N/A'); ?></div>
                            </div>
                            <div>
                                <div class="text-xs text-gray-400">Employment Type</div>
                                <div class="text-sm text-primary"><?php echo ucfirst(str_replace('-', ' ', $job['job_type'] ?? 'Not specified')); ?></div>
                            </div>
                            <div>
                                <div class="text-xs text-gray-400">Location</div>
                                <div class="text-sm text-primary"><?php echo htmlspecialchars($job['location'] ?? 'Not specified'); ?></div>
                            </div>
                            <div>
                                <div class="text-xs text-gray-400">Workplace</div>
                                <div class="text-sm text-primary"><?php echo ucfirst($job['workplace_option'] ?? 'Onsite'); ?></div>
                            </div>

                            <?php if (!empty($job['min_age']) || !empty($job['max_age'])): ?>
                                <div>
                                    <div class="text-xs text-gray-400">Age Requirement</div>
                                    <div class="text-sm text-primary">
                                        <?php
                                        if (!empty($job['min_age']) && !empty($job['max_age'])) {
                                            echo $job['min_age'] . ' - ' . $job['max_age'] . ' years old';
                                        } elseif (!empty($job['min_age'])) {
                                            echo 'Minimum ' . $job['min_age'] . ' years old';
                                        } elseif (!empty($job['max_age'])) {
                                            echo 'Maximum ' . $job['max_age'] . ' years old';
                                        } else {
                                            echo 'No age restriction';
                                        }
                                        ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if ($job['show_pay'] && (!empty($job['salary']) || !empty($job['pay_range']))): ?>
                                <div>
                                    <div class="text-xs text-gray-400">Salary Range</div>
                                    <div class="text-sm text-primary">
                                        <?php
                                        if (!empty($job['pay_range'])) {
                                            echo htmlspecialchars($job['pay_range']);
                                        } elseif (!empty($job['salary'])) {
                                            echo '₱' . number_format($job['salary'], 2);
                                            if ($job['pay_type']) echo ' / ' . $job['pay_type'];
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-400">Pay Type</div>
                                    <div class="text-sm text-primary"><?php echo ucfirst($job['pay_type'] ?? 'Monthly'); ?></div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Full Description -->
                    <?php if (!empty($job['full_description']) && $job['full_description'] !== $job['job_summary']): ?>
                        <div class="mb-8">
                            <h2 class="mb-3 font-semibold text-primary text-md">Full Description</h2>
                            <div class="text-sm font-light leading-relaxed text-gray-600">
                                <?php echo nl2br(htmlspecialchars($job['full_description'])); ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Requirements -->
                    <?php if (!empty($job['requirements'])): ?>
                        <div class="mb-8">
                            <h2 class="mb-3 font-semibold text-primary text-md">Requirements</h2>
                            <div class="text-sm font-light leading-relaxed text-gray-600">
                                <?php echo nl2br(htmlspecialchars($job['requirements'])); ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Responsibilities -->
                    <?php if (!empty($job['responsibilities'])): ?>
                        <div class="mb-8">
                            <h2 class="mb-3 font-semibold text-primary text-md">Responsibilities</h2>
                            <div class="text-sm font-light leading-relaxed text-gray-600">
                                <?php echo nl2br(htmlspecialchars($job['responsibilities'])); ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Screening Questions -->
                    <?php if (!empty($job['screening_questions']) && is_array($job['screening_questions'])): ?>
                        <div class="mb-8">
                            <h2 class="mb-3 font-semibold text-primary text-md">Screening Questions</h2>
                            <div class="space-y-4">
                                <?php foreach ($job['screening_questions'] as $index => $question): ?>
                                    <div class="p-4 border-l-4 border-blue-500 bg-blue-50">
                                        <p class="mb-2 text-sm font-medium text-gray-900">
                                            Question <?php echo $index + 1; ?>
                                        </p>
                                        <p class="text-sm text-gray-700">
                                            <?php echo htmlspecialchars($question['question']); ?>
                                        </p>
                                        <?php if (!empty($question['required'])): ?>
                                            <span class="inline-flex px-2 py-1 mt-2 text-xs font-medium text-red-800 bg-red-100 rounded">
                                                Required
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Job Attachments -->
                    <?php if (!empty($job['attachments']) && is_array($job['attachments'])): ?>
                        <div class="mb-8">
                            <h2 class="mb-3 font-semibold text-primary text-md">Job Attachments</h2>
                            <div class="space-y-3">
                                <?php foreach ($job['attachments'] as $attachment): ?>
                                    <div class="flex items-center justify-between p-4 transition-colors border border-gray-200 rounded-lg bg-gray-50 hover:bg-gray-100">
                                        <div class="flex items-center">
                                            <div class="flex items-center justify-center w-12 h-12 mr-3 rounded-lg bg-blue-50">
                                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">
                                                    <?php echo htmlspecialchars(basename($attachment['file_path'])); ?>
                                                </div>
                                                <div class="text-xs text-gray-500">
                                                    Uploaded <?php echo date('M j, Y', strtotime($attachment['uploaded_at'])); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="<?php echo htmlspecialchars($attachment['file_path']); ?>" target="_blank"
                                            class="flex items-center px-3 py-2 text-sm font-medium transition-colors rounded-lg text-primary bg-blue-50 hover:bg-blue-100">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            View
                                        </a>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Right Section - Sidebar (4/12) -->
        <div class="w-full lg:w-4/12">
            <!-- Sidebar Card -->
            <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-6">
                <!-- Application Statistics -->
                <div class="mb-6 sm:mb-8">
                    <h3 class="mb-4 text-lg font-semibold text-gray-900">Application Statistics</h3>
                    <div class="p-4 border divide-y divide-gray-200 rounded-lg">
                        <div class="flex items-center justify-between p-3">
                            <span class="text-sm font-medium text-gray-600">Total Applications</span>
                            <span class="text-sm font-bold text-gray-900">
                                <?php echo $applicationStats['total_applications'] ?? 0; ?>
                            </span>
                        </div>
                        <div class="flex items-center justify-between p-3">
                            <span class="text-sm font-medium text-gray-600">Pending Review</span>
                            <span class="text-sm font-bold text-gray-900">
                                <?php echo $applicationStats['pending'] ?? 0; ?>
                            </span>
                        </div>
                        <div class="flex items-center justify-between p-3">
                            <span class="text-sm font-medium text-gray-600">Reviewed</span>
                            <span class="text-sm font-bold text-gray-900">
                                <?php echo $applicationStats['reviewed'] ?? 0; ?>
                            </span>
                        </div>
                        <div class="flex items-center justify-between p-3">
                            <span class="text-sm font-medium text-gray-600">Shortlisted</span>
                            <span class="text-sm font-bold text-gray-900">
                                <?php echo $applicationStats['shortlisted'] ?? 0; ?>
                            </span>
                        </div>
                        <div class="flex items-center justify-between p-3">
                            <span class="text-sm font-medium text-gray-600">Hired</span>
                            <span class="text-sm font-bold text-gray-900">
                                <?php echo $applicationStats['hired'] ?? 0; ?>
                            </span>
                        </div>
                        <div class="flex items-center justify-between p-3">
                            <span class="text-sm font-medium text-gray-600">Rejected</span>
                            <span class="text-sm font-bold text-gray-900">
                                <?php echo $applicationStats['rejected'] ?? 0; ?>
                            </span>
                        </div>
                    </div>
                </div>


                <!-- Job Information -->
                <div class="mb-6 sm:mb-8">
                    <h3 class="mb-4 text-lg font-semibold text-gray-900">Job Information</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-3 rounded-md bg-gray-50">
                            <span class="text-sm font-medium text-gray-600">Posted:</span>
                            <span class="text-sm font-medium text-primary"><?php echo date('M j, Y', strtotime($job['created_at'])); ?></span>
                        </div>

                        <?php if (!empty($job['application_deadline'])): ?>
                            <div class="flex items-center justify-between p-3 rounded-md bg-gray-50">
                                <span class="text-sm font-medium text-gray-600">Deadline:</span>
                                <span class="text-sm font-medium <?php echo (strtotime($job['application_deadline']) < time()) ? 'text-red-600' : 'text-primary'; ?>">
                                    <?php echo date('M j, Y', strtotime($job['application_deadline'])); ?>
                                    <?php if (strtotime($job['application_deadline']) < time()): ?>
                                        <span class="block text-xs text-red-500">(Expired)</span>
                                    <?php endif; ?>
                                </span>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($job['updated_at']) && $job['updated_at'] !== $job['created_at']): ?>
                            <div class="flex items-center justify-between p-3 rounded-md bg-gray-50">
                                <span class="text-sm font-medium text-gray-600">Last Updated:</span>
                                <span class="text-sm font-medium text-primary"><?php echo date('M j, Y g:i A', strtotime($job['updated_at'])); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

            <!-- Quick Actions -->
            <div class="flex gap-3">
                <button onclick="window.print()"
                    class="flex items-center justify-center px-4 py-2 text-sm font-medium text-white transition-colors rounded-md bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Print Job Details
                </button>

                <button onclick="shareJob('<?php echo htmlspecialchars($job['job_title'], ENT_QUOTES); ?>', window.location.href)"
                    class="flex items-center justify-center px-4 py-2 text-sm font-medium text-white transition-colors rounded-md bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z" />
                    </svg>
                    Share Job
                </button>
            </div>

            </div>
        </div>
    </div>
</div>

<!-- JavaScript for Enhanced Functionality -->
<script>
    // Enhanced job status management with better error handling
    function changeJobStatus(jobId, status) {
        let confirmMessage;
        switch (status) {
            case 'open':
                confirmMessage = 'Are you sure you want to open this job for applications?';
                break;
            case 'closed':
                confirmMessage = 'Are you sure you want to close this job? No new applications will be accepted.';
                break;
            default:
                confirmMessage = `Are you sure you want to change the status to ${status}?`;
        }

        if (confirm(confirmMessage)) {
            showLoadingMessage('Updating job status...');

            const formData = new FormData();
            formData.append('job_id', jobId);
            formData.append('status', status);

            const baseUrl = window.location.pathname.split('index.php')[0];
            const url = baseUrl + 'index.php?page=admin-toggle-job-status';

            fetch(url, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(async response => {
                    const text = await response.text();g

                    try {
                        return JSON.parse(text);
                    } catch (e) {
                        console.error('JSON parse error:', e);

                        // Check if response contains success indicators
                        if (text.includes('success') || text.includes('updated') || text.includes(status + 'd')) {
                            return {
                                success: true,
                                message: `Job ${status}d successfully`
                            };
                        } else {
                            throw new Error('Invalid server response format');
                        }
                    }
                })
                .then(data => {
                    hideLoadingMessage();

                    if (data.success === true || data.success === 'true' || data.status === 'success') {
                        showSuccessMessage(`Job ${status}d successfully!`);

                        // Reload page to reflect changes
                        setTimeout(() => {
                            location.reload();
                        }, 1500);
                    } else {
                        throw new Error(data.error || data.message || `Failed to ${status} job`);
                    }
                })
                .catch(error => {
                    hideLoadingMessage();
                    console.error('Error:', error);
                    showErrorMessage('Error: ' + error.message);
                });
        }
    }

    function deleteJob(jobId) {
        if (confirm('Are you sure you want to delete this job? This action cannot be undone and will remove all associated applications.')) {
            showLoadingMessage('Deleting job...');

            const formData = new FormData();
            formData.append('job_id', jobId);

            const baseUrl = window.location.pathname.split('index.php')[0];
            const url = baseUrl + 'index.php?page=admin-delete-job';

            fetch(url, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(async response => {
                    const text = await response.text();
                    
                    try {
                        return JSON.parse(text);
                    } catch (e) {
                        if (text.includes('success') || text.includes('deleted')) {
                            return {
                                success: true,
                                message: 'Job deleted successfully'
                            };
                        } else {
                            throw new Error('Invalid server response format');
                        }
                    }
                })
                .then(data => {
                    hideLoadingMessage();

                    if (data.success === true || data.success === 'true' || data.status === 'success') {
                        showSuccessMessage('Job deleted successfully!');

                        // Redirect back to job management
                        setTimeout(() => {
                            window.location.href = '?page=admin-jobpost-management';
                        }, 1500);
                    } else {
                        throw new Error(data.error || data.message || 'Failed to delete job');
                    }
                })
                .catch(error => {
                    hideLoadingMessage();
                    console.error('Error:', error);
                    showErrorMessage('Error: ' + error.message);
                });
        }
    }

    // Share job function
    function shareJob(jobTitle, url) {
        if (navigator.share) {
            navigator.share({
                title: jobTitle,
                url: url
            }).catch(console.error);
        } else {
            // Fallback for browsers that don't support Web Share API
            if (navigator.clipboard) {
                navigator.clipboard.writeText(url).then(() => {
                    showSuccessMessage('Job link copied to clipboard!');
                }).catch(err => {
                    console.error('Could not copy text: ', err);
                    showErrorMessage('Failed to copy job link. Please try manually sharing the link.');
                });
            } else {
                // If clipboard API is not available, just show the URL in an alert
                alert('Job URL: ' + url);
            }
        }
    }

    // Utility functions for user feedback
    function showLoadingMessage(message) {
        const existingMessages = document.querySelectorAll('.loading-message');
        existingMessages.forEach(msg => msg.remove());

        const messageDiv = document.createElement('div');
        messageDiv.className = 'loading-message fixed top-4 right-4 bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded z-50 shadow-lg';
        messageDiv.innerHTML = `
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
            </svg>
            ${message}
        </div>
    `;

        document.body.appendChild(messageDiv);
    }

    function hideLoadingMessage() {
        const loadingMessages = document.querySelectorAll('.loading-message');
        loadingMessages.forEach(msg => {
            msg.style.opacity = '0';
            setTimeout(() => msg.remove(), 300);
        });
    }

    function showSuccessMessage(message) {
        const existingMessages = document.querySelectorAll('.success-message, .error-message');
        existingMessages.forEach(msg => msg.remove());

        const messageDiv = document.createElement('div');
        messageDiv.className = 'success-message fixed top-4 right-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded z-50 shadow-lg';
        messageDiv.innerHTML = `
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            ${message}
        </div>
    `;

        document.body.appendChild(messageDiv);

        setTimeout(() => {
            messageDiv.style.opacity = '0';
            messageDiv.style.transform = 'translateX(100%)';
            setTimeout(() => {
                if (messageDiv.parentNode) {
                    messageDiv.remove();
                }
            }, 300);
        }, 4000);
    }

    function showErrorMessage(message) {
        const existingMessages = document.querySelectorAll('.error-message, .success-message');
        existingMessages.forEach(msg => msg.remove());

        const messageDiv = document.createElement('div');
        messageDiv.className = 'error-message fixed top-4 right-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded z-50 shadow-lg';
        messageDiv.innerHTML = `
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            ${message}
        </div>
    `;

        document.body.appendChild(messageDiv);

        setTimeout(() => {
            messageDiv.style.opacity = '0';
            messageDiv.style.transform = 'translateX(100%)';
            setTimeout(() => {
                if (messageDiv.parentNode) {
                    messageDiv.remove();
                }
            }, 300);
        }, 5000);
    }
</script>