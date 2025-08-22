<?php
include_once __DIR__ . '/../components/navbar-top.php';
include_once __DIR__ . '../components/navbar-employer.php';
?>

<div class="py-6">
    <div class="mx-auto sm:px-2 md:px-4 lg:px-12 max-w-7xl">
        <!-- Job Status Header -->
        <div class="py-6">
            <div class="flex items-center justify-between">
                <!-- Left: Status Tabs -->
                <div class="flex items-center p-1 space-x-1 rounded-lg bg-gray-50">
                    <?php
                    $activeTab = $_GET['job_status'] ?? 'open';
                    $tabs = [
                        'open' => 'Open Jobs',
                        'draft' => 'Drafts',
                        'closed' => 'Expired'
                    ];
                    foreach ($tabs as $status => $label): ?>
                        <a href="?page=manage-jobs&job_status=<?php echo $status; ?>"
                            class="relative px-4 py-2 text-sm font-medium rounded-md transition-all duration-200 ease-in-out
                   <?php echo ($activeTab == $status)
                            ? 'bg-primary text-white shadow-sm ring-1 ring-gray-200'
                            : 'text-gray-600 hover:text-gray-900 hover:bg-white/50'; ?>">
                            <?php echo $label; ?>
                        </a>
                    <?php endforeach; ?>
                </div>

                <!-- Right: Job Count -->
                <div class="flex items-center text-sm text-gray-500">
                    <span class="mr-2">Total Jobs:</span>
                    <span class="px-2 py-1 font-semibold text-gray-700 bg-gray-100 rounded-md">
                        <?php echo count($jobs); ?>
                    </span>
                </div>
            </div>
        </div>

        <!-- Jobs Cards -->
        <div class="py-4">
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                <?php
                // Filter jobs by status
                $filteredJobs = array_filter($jobs, function ($job) use ($activeTab) {
                    if ($activeTab == 'closed') return $job['job_status'] == 'closed';
                    return $job['job_status'] == $activeTab;
                });
                if (empty($filteredJobs)): ?>
                    <div class="col-span-full">
                        <div class="flex flex-col items-center justify-center w-screen p-16 text-center bg-white border-2 border-gray-200 border-dashed rounded-lg min-h-[300px]">

                            <div class="flex items-center justify-center w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-full">
                                <?php if ($activeTab == 'draft'): ?>
                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                <?php elseif ($activeTab == 'closed'): ?>
                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                <?php else: ?>
                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 00-2 2H8a2 2 0 00-2-2V6m8 0H8m0 0v-.5A.5.5 0 018.5 5h7a.5.5 0 01.5.5V6m-8 0V6a2 2 0 012-2h4a2 2 0 012 2v0" />
                                    </svg>
                                <?php endif; ?>
                            </div>

                            <?php if ($activeTab == 'draft'): ?>
                                <h3 class="mb-3 text-lg font-semibold text-primary">No Draft Jobs</h3>
                                <p class="max-w-md mb-8 text-sm text-gray-500">
                                    You don't have any draft jobs. Start creating a job post and save it as a draft to continue later.
                                </p>
                            <?php elseif ($activeTab == 'closed'): ?>
                                <h3 class="mb-3 text-lg font-semibold text-primary">No Expired Jobs</h3>
                                <p class="max-w-md mb-8 text-sm text-gray-500">
                                    You don't have any expired or closed jobs yet. Jobs will appear here when they reach their deadline or are manually closed.
                                </p>
                            <?php else: ?>
                                <h3 class="mb-3 text-2xl font-semibold text-gray-900">No Active Jobs</h3>
                                <p class="max-w-md mb-8 text-gray-500">
                                    You don't have any active job posts. Create your first job post to start attracting qualified candidates.
                                </p>
                            <?php endif; ?>

                            <?php if ($activeTab != 'closed'): ?>
                                <div class="flex flex-col gap-3 sm:flex-row">
                                    <a href="?page=post-job"
                                        class="inline-flex items-center px-6 py-3 text-sm font-medium text-white transition-colors duration-200 border border-transparent rounded-lg bg-primary hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                        </svg>
                                        Create New Job
                                    </a>
                                    <?php if ($activeTab == 'open' && count(array_filter($jobs, function ($job) {
                                        return $job['job_status'] == 'draft';
                                    })) > 0): ?>
                                        <a href="?page=manage-jobs&job_status=draft"
                                            class="inline-flex items-center px-6 py-3 text-sm font-medium text-blue-600 transition-colors duration-200 border border-blue-200 rounded-lg bg-blue-50 hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            View Drafts
                                        </a>
                                    <?php endif; ?>
                                </div>
                            <?php else: ?>
                                <a href="?page=manage-jobs&job_status=open"
                                    class="inline-flex items-center px-6 py-3 text-sm font-medium text-blue-600 transition-colors duration-200 border border-blue-200 rounded-lg bg-blue-50 hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    View Active Jobs
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php else:
                    foreach ($filteredJobs as $job):
                        // Calculate days remaining
                        $daysRemaining = 0;
                        if (!empty($job['application_deadline'])) {
                            $deadline = new DateTime($job['application_deadline']);
                            $now = new DateTime();
                            if ($deadline > $now) {
                                $daysRemaining = $now->diff($deadline)->days;
                            }
                        }
                    ?>
                        <div class="p-6 transition-all duration-300 bg-white border border-gray-200 rounded-lg shadow-md hover:shadow-lg">
                            <div class="flex flex-col h-full">
                                <!-- Header with Logo and Job Title -->
                                <div class="flex items-start mb-4">
                                    <div class="flex-shrink-0 mr-3">
                                        <?php if (!empty($job['business_logo'])): ?>
                                            <img src="<?php echo htmlspecialchars($job['business_logo']); ?>" alt="Company Logo" class="object-cover w-12 h-12 border border-gray-200 rounded-lg">
                                        <?php else: ?>
                                            <div class="flex items-center justify-center w-12 h-12 border border-gray-200 rounded-lg bg-blue-50">
                                                <?php if (!empty($job['business_name'])): ?>
                                                    <span class="text-xs font-semibold text-blue-600">
                                                        <?php echo strtoupper(substr($job['business_name'], 0, 2)); ?>
                                                    </span>
                                                <?php else: ?>
                                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                                    </svg>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="font-normal text-gray-800 text-md line-clamp-2">
                                            <?php echo htmlspecialchars($job['job_title']); ?>
                                        </h3>
                                        <!-- Tags Section -->
                                        <div class="flex flex-wrap gap-2">
                                            <!-- Employment Type Tag -->
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-sm font-medium bg-blue-100 text-primary" style="font-size: 0.65rem;">
                                                <?php echo strtoupper($job['job_type'] ?? 'FULL-TIME'); ?>
                                            </span>

                                            <!-- Status Tag -->
                                            <?php
                                            switch (trim($job['job_status'])) {
                                                case 'open':
                                                    echo '<span class="inline-flex items-center px-2.5 py-0.5 rounded-sm font-medium bg-green-100 text-green-800" style="font-size: 0.65rem;">ACTIVE</span>';
                                                    break;
                                                case 'closed':
                                                    echo '<span class="inline-flex items-center px-2.5 py-0.5 rounded-sm  font-medium bg-red-100 text-red-800" style="font-size: 0.65rem;">CLOSED</span>';
                                                    break;
                                                case 'draft':
                                                    echo '<span class="inline-flex items-center px-2.5 py-0.5 rounded-sm  font-medium bg-yellow-100 text-yellow-800" style="font-size: 0.65rem;">DRAFT</span>';
                                                    break;
                                                case 'paused':
                                                    echo '<span class="inline-flex items-center px-2.5 py-0.5 rounded-sm  font-medium bg-orange-100 text-orange-800" style="font-size: 0.65rem;">PAUSED</span>';
                                                    break;
                                                default:
                                                    echo '<span class="inline-flex items-center px-2.5 py-0.5 rounded-sm  font-medium bg-gray-100 text-gray-600" style="font-size: 0.65rem;">' . strtoupper(trim($job['job_status'])) . '</span>';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- Salary Information -->
                                <div class="flex items-center mb-2 text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-1 text-gray-600" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path d="M7 13C7 11.1144 7 10.1716 7.58579 9.58579C8.17157 9 9.11438 9 11 9H14H17C18.8856 9 19.8284 9 20.4142 9.58579C21 10.1716 21 11.1144 21 13V14V15C21 16.8856 21 17.8284 20.4142 18.4142C19.8284 19 18.8856 19 17 19H14H11C9.11438 19 8.17157 19 7.58579 18.4142C7 17.8284 7 16.8856 7 15V14V13Z" stroke-linejoin="round"></path>
                                        <path d="M7 15V15C5.11438 15 4.17157 15 3.58579 14.4142C3.58579 14.4142 3.58579 14.4142 3.58579 14.4142C3 13.8284 3 12.8856 3 11L3 9C3 7.11438 3 6.17157 3.58579 5.58579C4.17157 5 5.11438 5 7 5L13 5C14.8856 5 15.8284 5 16.4142 5.58579C17 6.17157 17 7.11438 17 9V9" stroke-linejoin="round"></path>
                                        <path d="M16 14C16 15.1046 15.1046 16 14 16C12.8954 16 12 15.1046 12 14C12 12.8954 12.8954 12 14 12C15.1046 12 16 12.8954 16 14Z"></path>
                                    </svg>
                                    <span class="text-xs text-gray-500">
                                        <?php
                                        // Use salary data from JobPost model
                                        if (!empty($job['salary']) && $job['show_pay']) {
                                            echo 'Php' . number_format($job['salary']);
                                            if (!empty($job['pay_type'])) {
                                                echo ' / ' . htmlspecialchars($job['pay_type']);
                                            }
                                        } elseif (!empty($job['pay_range']) && $job['show_pay']) {
                                            echo htmlspecialchars($job['pay_range']);
                                        } else {
                                            echo 'Salary: Negotiable';
                                        }
                                        ?>
                                </div>
                                <!-- Days Remaining -->
                                <div class="flex items-center mb-4 text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-1 text-gray-600" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path d="M12 7V12H15M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                    <span class="text-xs text-gray-500">
                                        <?php
                                        if ($daysRemaining > 0) {
                                            echo $daysRemaining . ' days remaining';
                                        } else {
                                            echo 'Posted ' . date('M j, Y', strtotime($job['created_at']));
                                        }
                                        ?>
                                    </span>
                                </div>

                                <!-- Applicant Capacity Bar -->
                                <div class="mb-4">
                                    <?php
                                    // Get values with defaults
                                    $applicationCount = (int)($job['application_count'] ?? 0);
                                    $maxCapacity = (int)($job['max_applicants'] ?? 50);

                                    // Calculate percentage (ensure no division by zero)
                                    $percentage = 0;
                                    if ($maxCapacity > 0) {
                                        $percentage = min(($applicationCount / $maxCapacity) * 100, 100);
                                    }

                                    // Define progress color (add this missing part)
                                    $progressColor = 'bg-primary'; // Default color
                                    if ($percentage >= 80) {
                                        $progressColor = 'bg-red-500';
                                    } elseif ($percentage >= 50) {
                                        $progressColor = 'bg-yellow-500';
                                    }

                                    // Only show if job is open and has capacity
                                    if (($job['job_status'] ?? '') === 'open' && $maxCapacity > 0):
                                    ?>
                                        <div class="w-full h-2 mb-2 overflow-hidden bg-gray-200 rounded-full">
                                            <div class="h-full transition-all duration-300 <?= $progressColor ?>"
                                                style="width: <?= $percentage ?>%"></div>
                                        </div>
                                        <div class="flex justify-between text-xs text-gray-500">
                                            <span><?= $applicationCount ?> applied</span>
                                            <span>Capacity: <?= $maxCapacity ?></span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <!-- Action Buttons -->
                                <div class="grid grid-cols-2 gap-3 mt-auto">
                                    <a href="?page=view-employer-job&id=<?php echo $job['job_id']; ?>"
                                        class="inline-flex items-center justify-center px-4 py-3 text-sm font-medium text-white transition-colors duration-200 rounded-md bg-primary hover:bg-primary">
                                        View Details
                                    </a>
                                    <a href="?page=view-all-applicants&job_id=<?php echo $job['job_id']; ?>"
                                        class="inline-flex items-center justify-center px-4 py-2.5 text-sm font-medium text-white bg-secondary rounded-lg hover:secondary transition-colors duration-200">
                                        Candidates
                                    </a>
                                </div>
                            </div>
                        </div>
                <?php endforeach;
                endif; ?>
            </div>
        </div>
    </div>
</div>