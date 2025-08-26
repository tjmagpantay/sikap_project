<div class="flex h-screen">
    <!-- Sidebar -->
    <?php include __DIR__ . '/components/sidebar.php'; ?>

    <!-- Main Content Area -->
    <div class="flex flex-col flex-1 overflow-hidden">
        <!-- Top Navigation -->
        <?php include __DIR__ . '/components/topbar.php'; ?>

        <!-- Main Content Area -->
        <main class="flex-1 px-6 overflow-y-auto bg-gray-50">
            <div class="py-8 mx-auto sm:px-2 md:px-4 lg:px-12 max-w-7xl">
                <!-- Header Section -->
                <div class="mb-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <a href="?page=admin-jobpost-management"
                                class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700">
                                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                </svg>
                                Back to Job Management
                            </a>
                        </div>
                        <div class="flex items-center space-x-3">
                            <!-- Job Status Badge -->
                            <?php
                            $statusClasses = [
                                'open' => 'bg-green-100 text-green-800',
                                'closed' => 'bg-red-100 text-red-800',
                                'paused' => 'bg-yellow-100 text-yellow-800',
                                'draft' => 'bg-gray-100 text-gray-800',
                            ];
                            $statusClass = $statusClasses[$job['job_status'] ?? 'draft'] ?? 'bg-gray-100 text-gray-800';
                            ?>
                            <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full <?php echo $statusClass; ?>">
                                <?php echo ucfirst($job['job_status'] ?? 'Draft'); ?>
                            </span>

                            <!-- Action Buttons -->
                            <div class="flex items-center space-x-2">
                                <div class="relative" x-data="{ open: false }">
                                    <button @click="open = !open"
                                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                        Change Status
                                        <svg class="w-4 h-4 ml-2 -mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>

                                    <div x-show="open" @click.away="open = false"
                                        x-transition:enter="transition ease-out duration-100"
                                        x-transition:enter-start="transform opacity-0 scale-95"
                                        x-transition:enter-end="transform opacity-100 scale-100"
                                        x-transition:leave="transition ease-in duration-75"
                                        x-transition:leave-start="transform opacity-100 scale-100"
                                        x-transition:leave-end="transform opacity-0 scale-95"
                                        class="absolute right-0 z-50 w-48 mt-2 origin-top-right bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5"
                                        x-cloak>
                                        <div class="py-1">
                                            <?php if ($job['job_status'] !== 'open'): ?>
                                                <button onclick="changeJobStatus(<?php echo $job['job_id']; ?>, 'open')"
                                                    class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                                    Set Open
                                                </button>
                                            <?php endif; ?>
                                            <?php if ($job['job_status'] !== 'paused'): ?>
                                                <button onclick="changeJobStatus(<?php echo $job['job_id']; ?>, 'paused')"
                                                    class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                                    Pause Job
                                                </button>
                                            <?php endif; ?>
                                            <?php if ($job['job_status'] !== 'closed'): ?>
                                                <button onclick="changeJobStatus(<?php echo $job['job_id']; ?>, 'closed')"
                                                    class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                                    Close Job
                                                </button>
                                            <?php endif; ?>
                                            <hr class="my-1">
                                            <button onclick="deleteJob(<?php echo $job['job_id']; ?>)"
                                                class="block w-full px-4 py-2 text-sm text-left text-red-600 hover:bg-red-50">
                                                Delete Job
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Content Grid -->
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <!-- Left Column - Job Details -->
                    <div class="space-y-6 lg:col-span-2">
                        <!-- Job Header Card -->
                        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex-1">
                                    <h1 class="mb-2 text-2xl font-bold text-gray-900">
                                        <?php echo htmlspecialchars($job['job_title'] ?? 'Untitled Job'); ?>
                                    </h1>
                                    <div class="flex items-center space-x-4 text-sm text-gray-600">
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            <?php echo htmlspecialchars($job['location'] ?? 'Not specified'); ?>
                                        </span>
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6.5"></path>
                                            </svg>
                                            <?php echo htmlspecialchars($job['job_type'] ?? 'Not specified'); ?>
                                        </span>
                                        <?php if (!empty($job['category_name'])): ?>
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold text-blue-800 bg-blue-100 rounded-full">
                                                <?php echo htmlspecialchars($job['category_name']); ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="text-sm text-right text-gray-500">
                                    <div>Job ID: <?php echo htmlspecialchars($job['job_id']); ?></div>
                                    <div>Posted: <?php echo date('M j, Y', strtotime($job['created_at'])); ?></div>
                                </div>
                            </div>

                            <!-- Employer Info -->
                            <div class="pt-4 border-t">
                                <h3 class="mb-2 text-sm font-medium text-gray-900">Posted by</h3>
                                <div class="flex items-center">
                                    <div class="flex items-center justify-center w-10 h-10 bg-gray-200 rounded-full">
                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-2m-2 0H7m5 0v-1a3 3 0 00-3-3H7a3 3 0 00-3 3v1m5-4v-4a1 1 0 011-1h4a1 1 0 011 1v4"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">
                                            <?php echo htmlspecialchars($job['company_name'] ?? 'Unknown Company'); ?>
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            <?php echo htmlspecialchars(($job['employer_first_name'] ?? '') . ' ' . ($job['employer_last_name'] ?? '')); ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Job Summary -->
                        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                            <h2 class="mb-4 text-lg font-semibold text-gray-900">Job Summary</h2>
                            <div class="prose-sm prose text-gray-700 max-w-none">
                                <?php echo nl2br(htmlspecialchars($job['job_summary'] ?? 'No job summary provided.')); ?>
                            </div>
                        </div>

                        <!-- Full Description -->
                        <?php if (!empty($job['full_description']) && $job['full_description'] !== $job['job_summary']): ?>
                            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                                <h2 class="mb-4 text-lg font-semibold text-gray-900">Full Description</h2>
                                <div class="prose-sm prose text-gray-700 max-w-none">
                                    <?php echo nl2br(htmlspecialchars($job['full_description'])); ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Requirements -->
                        <?php if (!empty($job['requirements'])): ?>
                            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                                <h2 class="mb-4 text-lg font-semibold text-gray-900">Requirements</h2>
                                <div class="prose-sm prose text-gray-700 max-w-none">
                                    <?php echo nl2br(htmlspecialchars($job['requirements'])); ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Responsibilities -->
                        <?php if (!empty($job['responsibilities'])): ?>
                            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                                <h2 class="mb-4 text-lg font-semibold text-gray-900">Responsibilities</h2>
                                <div class="prose-sm prose text-gray-700 max-w-none">
                                    <?php echo nl2br(htmlspecialchars($job['responsibilities'])); ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Skills Required -->
                        <?php if (!empty($job['skills']) && is_array($job['skills'])): ?>
                            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                                <h2 class="mb-4 text-lg font-semibold text-gray-900">Skills Required</h2>
                                <div class="flex flex-wrap gap-2">
                                    <?php foreach ($job['skills'] as $skill): ?>
                                        <span class="inline-flex px-3 py-1 text-sm font-medium text-gray-800 bg-gray-100 rounded-full">
                                            <?php echo htmlspecialchars($skill); ?>
                                        </span>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Screening Questions -->
                        <?php if (!empty($screeningQuestions)): ?>
                            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                                <h2 class="mb-4 text-lg font-semibold text-gray-900">Screening Questions</h2>
                                <div class="space-y-4">
                                    <?php foreach ($screeningQuestions as $index => $question): ?>
                                        <div class="pl-4 border-l-4 border-blue-500">
                                            <p class="text-sm font-medium text-gray-900">
                                                Question <?php echo $index + 1; ?>
                                            </p>
                                            <p class="mt-1 text-sm text-gray-700">
                                                <?php echo htmlspecialchars($question['question']); ?>
                                            </p>
                                            <?php if (!empty($question['required'])): ?>
                                                <span class="inline-flex px-2 py-1 mt-1 text-xs font-medium text-red-800 bg-red-100 rounded">
                                                    Required
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Job Attachments -->
                        <?php if (!empty($attachments)): ?>
                            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                                <h2 class="mb-4 text-lg font-semibold text-gray-900">Job Attachments</h2>
                                <div class="space-y-3">
                                    <?php foreach ($attachments as $attachment): ?>
                                        <div class="flex items-center justify-between p-3 rounded-lg bg-gray-50">
                                            <div class="flex items-center">
                                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                                <div class="ml-3">
                                                    <p class="text-sm font-medium text-gray-900">
                                                        <?php echo htmlspecialchars(basename($attachment['file_path'])); ?>
                                                    </p>
                                                    <p class="text-xs text-gray-500">
                                                        Uploaded <?php echo date('M j, Y', strtotime($attachment['uploaded_at'])); ?>
                                                    </p>
                                                </div>
                                            </div>
                                            <a href="<?php echo htmlspecialchars($attachment['file_path']); ?>" target="_blank"
                                                class="text-sm font-medium text-primary hover:text-primary-dark">
                                                View
                                            </a>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Right Column - Sidebar Info -->
                    <div class="space-y-6">
                        <!-- Job Information -->
                        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                            <h3 class="mb-4 text-lg font-semibold text-gray-900">Job Information</h3>
                            <div class="space-y-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Job Type</dt>
                                    <dd class="mt-1 text-sm text-gray-900"><?php echo htmlspecialchars($job['job_type'] ?? 'Not specified'); ?></dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Location</dt>
                                    <dd class="mt-1 text-sm text-gray-900"><?php echo htmlspecialchars($job['location'] ?? 'Not specified'); ?></dd>
                                </div>

                                <?php if (!empty($job['pay_range']) && $job['show_pay'] == 1): ?>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Salary Range</dt>
                                        <dd class="mt-1 text-sm text-gray-900">₱<?php echo htmlspecialchars($job['pay_range']); ?></dd>
                                    </div>
                                <?php endif; ?>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Application Start</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        <?php echo !empty($job['application_start']) ? date('M j, Y', strtotime($job['application_start'])) : 'Immediately'; ?>
                                    </dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Application Deadline</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        <?php if (!empty($job['application_deadline'])): ?>
                                            <?php
                                            $deadline = strtotime($job['application_deadline']);
                                            $isExpired = $deadline < time();
                                            ?>
                                            <span class="<?php echo $isExpired ? 'text-red-600' : 'text-gray-900'; ?>">
                                                <?php echo date('M j, Y', $deadline); ?>
                                            </span>
                                            <?php if ($isExpired): ?>
                                                <span class="block text-xs text-red-500">Expired</span>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            No deadline set
                                        <?php endif; ?>
                                    </dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Posted On</dt>
                                    <dd class="mt-1 text-sm text-gray-900"><?php echo date('M j, Y g:i A', strtotime($job['created_at'])); ?></dd>
                                </div>

                                <?php if (!empty($job['updated_at']) && $job['updated_at'] !== $job['created_at']): ?>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                                        <dd class="mt-1 text-sm text-gray-900"><?php echo date('M j, Y g:i A', strtotime($job['updated_at'])); ?></dd>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Application Statistics -->
                        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                            <h3 class="mb-4 text-lg font-semibold text-gray-900">Application Statistics</h3>
                            <div class="space-y-4">
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-500">Total Applications</span>
                                    <span class="text-sm font-semibold text-gray-900"><?php echo $applicationStats['total_applications'] ?? 0; ?></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-500">Pending Review</span>
                                    <span class="text-sm font-semibold text-yellow-600"><?php echo $applicationStats['pending'] ?? 0; ?></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-500">Reviewed</span>
                                    <span class="text-sm font-semibold text-blue-600"><?php echo $applicationStats['reviewed'] ?? 0; ?></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-500">Shortlisted</span>
                                    <span class="text-sm font-semibold text-purple-600"><?php echo $applicationStats['shortlisted'] ?? 0; ?></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-500">Hired</span>
                                    <span class="text-sm font-semibold text-green-600"><?php echo $applicationStats['hired'] ?? 0; ?></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-500">Rejected</span>
                                    <span class="text-sm font-semibold text-red-600"><?php echo $applicationStats['rejected'] ?? 0; ?></span>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                            <h3 class="mb-4 text-lg font-semibold text-gray-900">Quick Actions</h3>
                            <div class="space-y-3">
                                <button onclick="window.print()"
                                    class="inline-flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                    </svg>
                                    Print Job Details
                                </button>

                                <a href="?page=admin-jobpost-management"
                                    class="inline-flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                    </svg>
                                    Back to Job Management
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Hidden forms for actions -->
<form id="statusChangeForm" method="POST" action="?page=admin-toggle-job-status" style="display: none;">
    <input type="hidden" name="job_id" id="statusJobId">
    <input type="hidden" name="status" id="statusValue">
</form>

<form id="deleteJobForm" method="POST" action="?page=admin-delete-job" style="display: none;">
    <input type="hidden" name="job_id" id="deleteJobId">
</form>

<script>
    // Job status management
    function changeJobStatus(jobId, status) {
        let confirmMessage;
        switch (status) {
            case 'open':
                confirmMessage = 'Are you sure you want to open this job for applications?';
                break;
            case 'paused':
                confirmMessage = 'Are you sure you want to pause this job? New applications will be disabled.';
                break;
            case 'closed':
                confirmMessage = 'Are you sure you want to close this job? No new applications will be accepted.';
                break;
            default:
                confirmMessage = `Are you sure you want to change the status to ${status}?`;
        }

        if (confirm(confirmMessage)) {
            document.getElementById('statusJobId').value = jobId;
            document.getElementById('statusValue').value = status;
            document.getElementById('statusChangeForm').submit();
        }
    }

    function deleteJob(jobId) {
        if (confirm('Are you sure you want to delete this job? This action cannot be undone and will remove all associated applications.')) {
            document.getElementById('deleteJobId').value = jobId;
            document.getElementById('deleteJobForm').submit();
        }
    }
</script>