<?php
include_once __DIR__ . '/../components/navbar-top.php';
include_once __DIR__ . '../components/navbar-employer.php';
?>

<div class="py-6 ">
    <!-- Job Status Tabs -->
    <div class="px-4 py-4 sm:px-6 md:px-16 lg:px-24">
        <div class="flex flex-col items-start justify-between mb-4 sm:flex-row sm:items-center">
            <div class="flex w-full pb-2 space-x-8 border-b border-gray-200">
                <?php
                $activeTab = $_GET['job_status'] ?? 'open';
                $tabs = [
                    'open' => 'Open Jobs',
                    'draft' => 'Drafts',
                    'closed' => 'Expired'
                ];
                foreach ($tabs as $status => $label): ?>
                    <a href="?page=manage-jobs&job_status=<?php echo $status; ?>"
                        class="relative py-2 px-3 text-base font-medium border-b-2 transition-colors duration-200
                           <?php echo ($activeTab == $status)
                                ? 'border-blue-600 text-primary bg-blue-50 rounded-t'
                                : 'border-transparent text-gray-500 hover:text-blue-600'; ?>">
                        <?php echo $label; ?>
                        <?php if ($activeTab == $status): ?>
                            <span class="absolute left-0 right-0 bottom-0 h-0.5 bg-blue-600 rounded"></span>
                        <?php endif; ?>
                    </a>
                <?php endforeach; ?>
            </div>
            <span class="mt-4 text-sm text-gray-500 sm:mt-0">Recent Job Post <span class="font-semibold text-gray-700">(<?php echo count($jobs); ?>)</span></span>
        </div>
    </div>

    <!-- Jobs Cards -->
    <div class="px-4 sm:px-6 md:px-16 lg:px-24">
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            <?php
            // Filter jobs by status
            $filteredJobs = array_filter($jobs, function ($job) use ($activeTab) {
                if ($activeTab == 'closed') return $job['job_status'] == 'closed';
                return $job['job_status'] == $activeTab;
            });
            if (empty($filteredJobs)): ?>
                <div class="col-span-full">
                    <div class="flex flex-col items-center justify-center p-12 text-center bg-white border-2 border-gray-200 border-dashed rounded-lg">
                        <div class="flex items-center justify-center w-20 h-20 mx-auto mb-4 bg-gray-100 rounded-full">
                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 00-2 2H8a2 2 0 00-2-2V6m8 0H8m0 0v-.5A.5.5 0 018.5 5h7a.5.5 0 01.5.5V6m-8 0V6a2 2 0 012-2h4a2 2 0 012 2v0" />
                            </svg>
                        </div>
                        <h3 class="mb-2 text-xl font-semibold text-gray-900">No job posts yet</h3>
                        <p class="max-w-sm mb-6 text-gray-500">
                            Create your first job post to start attracting qualified candidates to your company.
                        </p>
                        <a href="?page=post-job"
                            class="inline-flex items-center px-6 py-3 text-sm font-medium text-white transition-colors duration-200 border border-transparent rounded-lg bg-primary hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Post Your First Job
                        </a>
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
                                    <?php elseif (!empty($job['employer_profile_photo'])): ?>
                                        <img src="<?php echo htmlspecialchars($job['employer_profile_photo']); ?>" alt="Employer Photo" class="object-cover w-12 h-12 border border-gray-200 rounded-lg">
                                    <?php else: ?>
                                        <div class="flex items-center justify-center w-12 h-12 bg-gray-100 rounded-lg">
                                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                            </svg>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="mb-2 text-lg font-normal text-gray-800 line-clamp-2">
                                        <?php echo htmlspecialchars($job['job_title']); ?>
                                    </h3>
                                    <!-- Tags Section -->
                                    <div class="flex flex-wrap gap-2">
                                        <!-- Employment Type Tag -->
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-sm text-xs font-medium bg-blue-100 text-primary">
                                            <?php echo strtoupper($job['job_type'] ?? 'FULL-TIME'); ?>
                                        </span>

                                        <!-- Status Tag -->
                                        <?php
                                        switch (trim($job['job_status'])) {
                                            case 'open':
                                                echo '<span class="inline-flex items-center px-2.5 py-0.5 rounded-sm text-xs font-medium bg-green-100 text-green-800">ACTIVE</span>';
                                                break;
                                            case 'closed':
                                                echo '<span class="inline-flex items-center px-2.5 py-0.5 rounded-sm text-xs font-medium bg-red-100 text-red-800">CLOSED</span>';
                                                break;
                                            case 'draft':
                                                echo '<span class="inline-flex items-center px-2.5 py-0.5 rounded-sm text-xs font-medium bg-yellow-100 text-yellow-800">DRAFT</span>';
                                                break;
                                            case 'paused':
                                                echo '<span class="inline-flex items-center px-2.5 py-0.5 rounded-sm text-xs font-medium bg-orange-100 text-orange-800">PAUSED</span>';
                                                break;
                                            default:
                                                echo '<span class="inline-flex items-center px-2.5 py-0.5 rounded-sm text-xs font-medium bg-gray-100 text-gray-800">' . strtoupper(trim($job['job_status'])) . '</span>';
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Salary Information -->
                            <div class="flex items-center mb-2 text-sm text-gray-600">
                                <svg width="24px" height="24px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#000000">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path d="M7 13C7 11.1144 7 10.1716 7.58579 9.58579C8.17157 9 9.11438 9 11 9H14H17C18.8856 9 19.8284 9 20.4142 9.58579C21 10.1716 21 11.1144 21 13V14V15C21 16.8856 21 17.8284 20.4142 18.4142C19.8284 19 18.8856 19 17 19H14H11C9.11438 19 8.17157 19 7.58579 18.4142C7 17.8284 7 16.8856 7 15V14V13Z" stroke="#323232" stroke-width="0.9600000000000002" stroke-linejoin="round"></path>
                                        <path d="M7 15V15C5.11438 15 4.17157 15 3.58579 14.4142C3.58579 14.4142 3.58579 14.4142 3.58579 14.4142C3 13.8284 3 12.8856 3 11L3 9C3 7.11438 3 6.17157 3.58579 5.58579C4.17157 5 5.11438 5 7 5L13 5C14.8856 5 15.8284 5 16.4142 5.58579C17 6.17157 17 7.11438 17 9V9" stroke="#323232" stroke-width="0.9600000000000002" stroke-linejoin="round"></path>
                                        <path d="M16 14C16 15.1046 15.1046 16 14 16C12.8954 16 12 15.1046 12 14C12 12.8954 12.8954 12 14 12C15.1046 12 16 12.8954 16 14Z" stroke="#323232" stroke-width="0.9600000000000002"></path>
                                    </g>
                                </svg>
                                </svg>
                                <span class="font-medium">
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
                                </span>
                            </div>

                            <!-- Days Remaining -->
                            <div class="flex items-center mb-4 text-sm text-gray-600">
                                <svg width="24px" height="24px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path d="M12 7V12H15M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="#000000" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </g>
                                </svg>
                                </svg>
                                <span>
                                    <?php
                                    if ($daysRemaining > 0) {
                                        echo $daysRemaining . ' days remaining';
                                    } else {
                                        echo 'Posted ' . date('M j, Y', strtotime($job['created_at']));
                                    }
                                    ?>
                                </span>
                            </div>

                            <!-- Applicant Progress Bar -->
                            <div class="mb-4">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-sm font-medium text-gray-700">
                                        <?php echo $job['application_count'] ?? 0; ?> applied
                                    </span>
                                    <span class="text-sm text-gray-500">of 50 capacity</span>
                                </div>
                                <div class="w-full h-2 overflow-hidden bg-gray-200 rounded-full">
                                    <?php
                                    $applicationCount = $job['application_count'] ?? 0;
                                    $maxCapacity = 50; // Placeholder capacity since no field exists yet
                                    $percentage = $maxCapacity > 0 ? min(($applicationCount / $maxCapacity) * 100, 100) : 0;
                                    $progressColor = $percentage >= 80 ? 'bg-red-500' : ($percentage >= 50 ? 'bg-yellow-500' : 'bg-green-500');
                                    ?>
                                    <div class="h-full rounded-full <?php echo $progressColor; ?> transition-all duration-300" style="width: <?php echo $percentage; ?>%"></div>
                                </div>
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