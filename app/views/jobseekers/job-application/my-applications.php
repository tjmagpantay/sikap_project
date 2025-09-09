<?php
include_once __DIR__ . '/../components/jobseeker_auth_check.php';
include_once __DIR__ . '/../../components/navbar-top.php';
include_once __DIR__ . '/../navbar-jobseeker.php';
?>

<div class="min-h-screen">
    <div class="px-6 py-8 ">
        <div class="mx-auto max-w-7xl">
            <!-- Page Header with Filter -->
            <div class="mb-8">
                <div class="sm:flex sm:items-center sm:justify-between">
                    <div>
                        <h1 class="text-2xl font-semibold text-gray-900">My Applications</h1>
                        <p class="mt-1 text-sm text-gray-600">Track the status of your job applications</p>
                    </div>

                    <!-- Filter Section (Similar to Browse Jobs) -->
                    <div class="flex items-center gap-4 mt-4 sm:mt-0">
                        <!-- Status Filter -->
                        <div class="relative" x-data="{ open: false, selected: 'All Status' }">
                            <button @click="open = !open" @click.away="open = false"
                                class="flex items-center gap-2 px-4 py-3 text-sm font-medium text-gray-700 transition-all bg-white border border-gray-300 rounded-sm shadow-sm hover:bg-gray-50 focus:ring-2 focus:ring-primary/50 hover:shadow-md">
                                <span x-text="selected" class="text-gray-700 truncate"></span>
                                <svg class="w-4 h-4 ml-2 transition-transform duration-200 text-primary" :class="{ 'rotate-180': open }"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <!-- Dropdown Menu -->
                            <div x-show="open"
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                class="absolute right-0 z-50 w-48 mt-2 bg-white rounded-lg shadow-lg ring-1 ring-black ring-opacity-5"
                                x-cloak>
                                <div class="py-1">
                                    <button @click="selected = 'All Status'; open = false; filterByStatus('')"
                                        class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                        All Status
                                    </button>
                                    <button @click="selected = 'Pending'; open = false; filterByStatus('pending')"
                                        class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                        Pending
                                    </button>
                                    <button @click="selected = 'Under Review'; open = false; filterByStatus('reviewed')"
                                        class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                        Under Review
                                    </button>
                                    <button @click="selected = 'Shortlisted'; open = false; filterByStatus('shortlisted')"
                                        class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                        Shortlisted
                                    </button>
                                    <button @click="selected = 'Hired'; open = false; filterByStatus('hired')"
                                        class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                        Hired
                                    </button>
                                    <button @click="selected = 'Rejected'; open = false; filterByStatus('rejected')"
                                        class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                        Rejected
                                    </button>
                                    <button @click="selected = 'Resigned'; open = false; filterByStatus('resigned')"
                                        class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                        Resigned
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Interview Filter -->
                        <div class="relative" x-data="{ open: false, selected: 'All Applications' }">
                            <button @click="open = !open" @click.away="open = false"
                                class="flex items-center gap-2 px-4 py-3 text-sm font-medium text-gray-700 transition-all bg-white border border-gray-300 rounded-sm shadow-sm hover:bg-gray-50 focus:ring-2 focus:ring-primary/50 hover:shadow-md">
                                <span x-text="selected" class="text-gray-700 truncate"></span>
                                <svg class="w-4 h-4 ml-2 transition-transform duration-200 text-primary" :class="{ 'rotate-180': open }"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <!-- Dropdown Menu -->
                            <div x-show="open"
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                class="absolute right-0 z-50 w-48 mt-2 bg-white rounded-lg shadow-lg ring-1 ring-black ring-opacity-5"
                                x-cloak>
                                <div class="py-1">
                                    <button @click="selected = 'All Applications'; open = false; filterByInterview('')"
                                        class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                        All Applications
                                    </button>
                                    <button @click="selected = 'With Interview'; open = false; filterByInterview('with_interview')"
                                        class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                        With Interview
                                    </button>
                                    <button @click="selected = 'No Interview'; open = false; filterByInterview('no_interview')"
                                        class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                        No Interview
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Clear Filter Button -->
                        <button type="button" id="clearFilters" onclick="clearAllFilters()"
                            class="px-4 py-3 text-sm font-medium text-white transition-all rounded-sm shadow-sm bg-primary hover:bg-primary/90 focus:ring-2 focus:ring-primary/50 hover:shadow-md whitespace-nowrap">
                            Clear Filters
                        </button>
                    </div>
                </div>
            </div>

            <!-- Messages -->
            <?php if (!empty($error)): ?>
                <div class="px-4 py-3 mb-4 text-red-700 bg-red-100 border border-red-400 rounded">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($success)): ?>
                <div class="px-4 py-3 mb-4 text-green-700 bg-green-100 border border-green-400 rounded">
                    <?php echo htmlspecialchars($success); ?>
                </div>
            <?php endif; ?>

            <!-- Applications Table -->
            <div class="w-full bg-white border border-gray-200 rounded-lg shadow-sm">
                <!-- Table Header -->
                <div class="px-6 py-5 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <h3 class="text-xl font-semibold text-gray-900">
                                All Applications
                            </h3>
                            <span class="ml-3 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                <span id="applicationsCount"><?php echo count($applications ?? []); ?></span>
                            </span>
                        </div>
                    </div>
                </div>

                <?php if (empty($applications)): ?>
                    <div class="px-6 py-16 text-center">
                        <div class="flex flex-col items-center">
                            <div class="flex items-center justify-center w-16 h-16 mx-auto bg-gray-100 rounded-full">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <h3 class="mt-4 text-lg font-medium text-gray-900">No applications yet</h3>
                            <p class="max-w-sm mt-2 text-sm text-gray-500">
                                Start applying for jobs to see your applications here.
                            </p>
                            <a href="?page=browse-jobs" class="inline-flex items-center px-4 py-2 mt-4 text-sm font-medium text-white border border-transparent rounded-md shadow-sm bg-primary hover:bg-secondary">
                                <i class="mr-2 fas fa-search"></i>
                                Browse Jobs
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                    <!-- Keep existing table structure -->
                    <div class="w-full overflow-visible">
                        <table class="w-full divide-y divide-gray-300 table-fixed">
                            <!-- Table Header -->
                            <thead class="bg-primary">
                                <tr>
                                    <th scope="col" class="w-2/5 px-6 py-4 text-sm font-medium tracking-wider text-left text-white uppercase">
                                        JOB POSITION
                                    </th>
                                    <th scope="col" class="w-1/5 px-6 py-4 text-sm font-medium tracking-wider text-left text-white uppercase">
                                        COMPANY
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-sm font-medium tracking-wider text-left text-white uppercase w-1/8">
                                        STATUS
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-sm font-medium tracking-wider text-left text-white uppercase w-1/8">
                                        INTERVIEW
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-sm font-medium tracking-wider text-left text-white uppercase w-1/8">
                                        APPLIED DATE
                                    </th>
                                    <th scope="col" class="w-1/5 px-6 py-4 text-sm font-medium tracking-wider text-left text-white uppercase">
                                        ACTIONS
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-300">
                                <?php foreach ($applications as $index => $application): ?>
                                    <tr class="hover:bg-gray-50" data-application-id="<?php echo $application['application_id']; ?>">


                                        <!-- Job Position Column -->
                                        <td class="px-6 py-5">
                                            <div class="flex items-center">
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900">
                                                        <?php echo htmlspecialchars($application['job_title']); ?>
                                                    </div>
                                                    <div class="text-xs text-gray-500">
                                                        <?php echo ucfirst(str_replace('-', ' ', $application['job_type'])); ?> • <?php echo htmlspecialchars($application['location']); ?>
                                                    </div>

                                                </div>
                                            </div>
                                        </td>

                                        <!-- Company Column -->
                                        <td class="px-6 py-5">
                                            <div class="text-sm font-medium text-gray-900">
                                                <?php echo htmlspecialchars($application['company_name'] ?? 'Company'); ?>
                                            </div>
                                        </td>

                                        <!-- Status Column -->
                                        <td class="px-6 py-5">
                                            <?php if (!$application['is_finalized']): ?>
                                                <div class="flex items-center">
                                                    <div class="flex items-center justify-center w-6 h-6 mr-3 border-2 border-orange-500 rounded-full">
                                                        <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                    </div>
                                                    <span class="text-sm font-medium text-orange-600">In Progress</span>
                                                </div>
                                            <?php else: ?>
                                                <div class="flex items-center">
                                                    <?php
                                                    switch ($application['application_status']) {
                                                        case 'pending':
                                                            echo '<div class="flex items-center justify-center w-6 h-6 mr-3 border-2 border-yellow-500 rounded-full">
                                                                <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                </svg>
                                                            </div>';
                                                            echo '<span class="text-sm font-medium text-yellow-600">Pending</span>';
                                                            break;
                                                        case 'reviewed':
                                                            echo '<div class="flex items-center justify-center w-6 h-6 mr-3 border-2 border-blue-500 rounded-full">
                                                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                                                </svg>
                                                            </div>';
                                                            echo '<span class="text-sm font-medium text-blue-600">Under Review</span>';
                                                            break;
                                                        case 'shortlisted':
                                                            echo '<div class="flex items-center justify-center w-6 h-6 mr-3 border-2 border-purple-600 rounded-full">
                                                                <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/>
                                                                </svg>
                                                            </div>';
                                                            echo '<span class="text-sm font-medium text-purple-600">Shortlisted</span>';
                                                            break;
                                                        case 'hired':
                                                            echo '<div class="flex items-center justify-center w-6 h-6 mr-3 border-2 border-green-600 rounded-full">
                                                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                                </svg>
                                                            </div>';
                                                            echo '<span class="text-sm font-medium text-green-600">Hired</span>';
                                                            break;
                                                        case 'rejected':
                                                            echo '<div class="flex items-center justify-center w-6 h-6 mr-3 border-2 border-red-600 rounded-full">
                                                                <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                                </svg>
                                                            </div>';
                                                            echo '<span class="text-sm font-medium text-red-600">Rejected</span>';
                                                            break;
                                                        case 'resigned':
                                                            echo '<div class="flex items-center justify-center w-6 h-6 mr-3 border-2 border-orange-600 rounded-full">
                                                                <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                                                </svg>
                                                            </div>';
                                                            echo '<span class="text-sm font-medium text-orange-600">Resigned</span>';
                                                            break;
                                                        default:
                                                            echo '<div class="flex items-center justify-center w-6 h-6 mr-3 border-2 border-gray-400 rounded-full">
                                                                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                </svg>
                                                            </div>';
                                                            echo '<span class="text-sm font-medium text-gray-600">' . ucfirst($application['application_status']) . '</span>';
                                                    }
                                                    ?>
                                                </div>
                                            <?php endif; ?>
                                        </td>

                                        <!-- Interview Status Column -->
                                        <td class="px-6 py-5">
                                            <?php if (!empty($application['interview_date']) && $application['interview_date'] !== '0000-00-00 00:00:00'): ?>
                                                <div class="flex items-center">
                                                    <div class="flex items-center justify-center w-6 h-6 mr-3 border-2 border-green-600 rounded-full">
                                                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <div class="text-sm font-medium text-green-600">Scheduled</div>
                                                        <div class="text-xs text-gray-500"><?php echo date('M j, Y g:i A', strtotime($application['interview_date'])); ?></div>
                                                        <?php if (!empty($application['interview_location'])): ?>
                                                            <div class="text-xs text-gray-500">📍 <?php echo htmlspecialchars($application['interview_location']); ?></div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            <?php else: ?>
                                                <div class="flex items-center">
                                                    <div class="flex items-center justify-center w-6 h-6 mr-3 border-2 border-gray-300 rounded-full">
                                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                    </div>
                                                    <span class="text-sm text-gray-500">Pending</span>
                                                </div>
                                            <?php endif; ?>
                                        </td>

                                        <!-- Applied Date Column -->
                                        <td class="px-6 py-5">
                                            <?php if (!empty($application['applied_at'])): ?>
                                                <div class="text-sm text-gray-900"><?php echo date('M j, Y', strtotime($application['applied_at'])); ?></div>
                                                <div class="text-xs text-gray-500"><?php echo date('g:i A', strtotime($application['applied_at'])); ?></div>
                                            <?php else: ?>
                                                <div class="text-sm text-gray-500">Not submitted</div>
                                            <?php endif; ?>
                                        </td>

                                        <!-- Actions Column -->
                                        <td class="px-6 py-5">
                                            <div class="flex items-center space-x-3">
                                                <!-- View Application Button -->
                                                <a href="?page=view-application&id=<?php echo $application['application_id']; ?>"
                                                    class="inline-flex items-center px-4 py-2 text-sm font-medium transition-colors duration-200 bg-gray-100 rounded-sm text-primary hover:bg-primary hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                                    View
                                                </a>

                                                <!-- Three Dots Menu -->
                                                <div class="relative" x-data="{ open: false }">
                                                    <button @click="open = !open"
                                                        @click.away="open = false"
                                                        class="flex items-center justify-center w-8 h-8 text-gray-400 transition-colors duration-200 rounded-full hover:text-gray-600 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                                                        </svg>
                                                    </button>

                                                    <!-- Dropdown Menu -->
                                                    <div x-show="open"
                                                        x-transition:enter="transition ease-out duration-100"
                                                        x-transition:enter-start="transform opacity-0 scale-95"
                                                        x-transition:enter-end="transform opacity-100 scale-100"
                                                        x-transition:leave="transition ease-in duration-75"
                                                        x-transition:leave-start="transform opacity-100 scale-100"
                                                        x-transition:leave-end="transform opacity-0 scale-95"
                                                        class="absolute right-0 z-40 w-48 mt-2 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5"
                                                        style="display: none;">
                                                        <div class="py-1">
                                                            <a href="?page=view-job&job_id=<?php echo $application['job_id']; ?>"
                                                                class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                                <i class="mr-3 text-blue-400 fas fa-external-link-alt"></i>
                                                                View Job Details
                                                            </a>

                                                            <button onclick="toggleSaveJob(<?php echo $application['job_id']; ?>, this)"
                                                                class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                                                data-job-id="<?php echo $application['job_id']; ?>"
                                                                data-saved="<?php echo (isset($application['is_saved']) && $application['is_saved']) ? 'true' : 'false'; ?>">
                                                                <i class="mr-3 text-yellow-400 <?php echo (isset($application['is_saved']) && $application['is_saved']) ? 'fas fa-bookmark' : 'far fa-bookmark'; ?>"></i>
                                                                <span class="save-text"><?php echo (isset($application['is_saved']) && $application['is_saved']) ? 'Remove from Saved' : 'Save Job'; ?></span>
                                                            </button>

                                                            <?php if ($application['application_status'] === 'hired'): ?>
                                                                <a href="?page=resign-from-job&id=<?php echo $application['application_id']; ?>"
                                                                    class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                                    <i class="mr-3 text-orange-400 fas fa-sign-out-alt"></i>
                                                                    Resign from Job
                                                                </a>
                                                            <?php elseif ($application['application_status'] === 'pending'): ?>
                                                                <a href="?page=withdraw-application&id=<?php echo $application['application_id']; ?>"
                                                                    onclick="return confirm('Are you sure you want to withdraw your application for &quot;<?php echo htmlspecialchars($application['job_title']); ?>&quot;?\n\nThis action cannot be undone.')"
                                                                    class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                                    <i class="mr-3 text-red-400 fas fa-times"></i>
                                                                    Withdraw Application
                                                                </a>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        // Add filtering functionality
        let allApplications = [];
        let filteredApplications = [];

        document.addEventListener('DOMContentLoaded', function() {
            initializeFiltering();
        });

        function initializeFiltering() {
            allApplications = Array.from(document.querySelectorAll('tr[data-application-id]'));
            filteredApplications = [...allApplications];
        }

        function filterByStatus(status) {
            applyFilters({
                status: status
            });
        }

        function filterByInterview(interview) {
            applyFilters({
                interview: interview
            });
        }

        function applyFilters(newFilter) {
            filteredApplications = allApplications.filter(row => {
                let shouldShow = true;

                if (newFilter.status && newFilter.status !== '') {
                    const statusElement = row.querySelector('.text-yellow-600, .text-blue-600, .text-purple-600, .text-green-600, .text-red-600');
                    const statusText = statusElement ? statusElement.textContent.toLowerCase().trim() : '';

                    if (newFilter.status === 'reviewed' && !statusText.includes('review')) shouldShow = false;
                    else if (newFilter.status !== 'reviewed' && !statusText.includes(newFilter.status)) shouldShow = false;
                }

                if (newFilter.interview && newFilter.interview !== '') {
                    const hasInterview = row.textContent.includes('Scheduled');
                    if (newFilter.interview === 'with_interview' && !hasInterview) shouldShow = false;
                    if (newFilter.interview === 'no_interview' && hasInterview) shouldShow = false;
                }

                return shouldShow;
            });

            updateDisplay();
        }

        function clearAllFilters() {
            filteredApplications = [...allApplications];
            updateDisplay();

            // Reset dropdown selections
            document.querySelectorAll('[x-data]').forEach(dropdown => {
                if (dropdown._x_dataStack) {
                    const data = dropdown._x_dataStack[0];
                    if (data.selected && data.selected.includes('Status')) {
                        data.selected = 'All Status';
                    } else if (data.selected && data.selected.includes('Applications')) {
                        data.selected = 'All Applications';
                    }
                }
            });
        }

        function updateDisplay() {
            allApplications.forEach(row => {
                if (filteredApplications.includes(row)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });

            // Update count
            const countElement = document.getElementById('applicationsCount');
            if (countElement) {
                countElement.textContent = filteredApplications.length;
            }
        }

        function toggleSaveJob(jobId, button) {
            const isSaved = button.getAttribute('data-saved') === 'true';
            const action = isSaved ? 'unsave-job' : 'save-job';

            // Show loading state
            const icon = button.querySelector('i');
            const text = button.querySelector('.save-text');
            const originalIcon = icon.className;
            const originalText = text.textContent;

            icon.className = 'fas fa-spinner fa-spin mr-3';
            text.textContent = 'Loading...';
            button.disabled = true;

            const formData = new FormData();
            formData.append('job_id', jobId);

            fetch(`?page=${action}`, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        if (isSaved) {
                            // Job was unsaved
                            button.setAttribute('data-saved', 'false');
                            icon.className = 'far fa-bookmark mr-3 text-yellow-400';
                            text.textContent = 'Save Job';
                        } else {
                            // Job was saved
                            button.setAttribute('data-saved', 'true');
                            icon.className = 'fas fa-bookmark mr-3 text-yellow-400';
                            text.textContent = 'Remove from Saved';
                        }

                        // Show toast notification
                        showToast(data.message, 'success');
                    } else {
                        // Restore original state on error
                        icon.className = originalIcon;
                        text.textContent = originalText;
                        showToast(data.message || 'Error occurred', 'error');
                    }
                })
                .catch(error => {
                    // Restore original state on error
                    icon.className = originalIcon;
                    text.textContent = originalText;
                    console.error('Error:', error);
                    showToast('Error occurred while saving job', 'error');
                })
                .finally(() => {
                    button.disabled = false;
                });
        }

        function showToast(message, type) {
            const toast = document.createElement('div');
            toast.className = `fixed top-4 right-4 px-4 py-2 rounded-md shadow-lg z-50 transition-opacity duration-300 ${
            type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
        }`;
            toast.textContent = message;

            document.body.appendChild(toast);

            setTimeout(() => {
                toast.style.opacity = '0';
                setTimeout(() => {
                    document.body.removeChild(toast);
                }, 300);
            }, 3000);
        }

        // Scroll to specific application if hash is provided
        document.addEventListener('DOMContentLoaded', function() {
            if (window.location.hash) {
                const targetElement = document.querySelector(window.location.hash);
                if (targetElement) {
                    setTimeout(() => {
                        targetElement.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                        targetElement.classList.add('ring-2', 'ring-orange-300', 'ring-opacity-50');

                        // Remove highlighting after 3 seconds
                        setTimeout(() => {
                            targetElement.classList.remove('ring-2', 'ring-orange-300', 'ring-opacity-50');
                        }, 3000);
                    }, 500);
                }
            }
        });
    </script>
    </dl>
</div>
</div>
</div>

</div>
</div>