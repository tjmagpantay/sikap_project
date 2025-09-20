<?php
include_once __DIR__ . '/../components/jobseeker_auth_check.php';
include_once __DIR__ . '/../../components/navbar-top.php';
include_once __DIR__ . '/../navbar-jobseeker.php';
?>

<div class="min-h-screen px-4 sm:px-6 md:px-16 lg:px-24">
    <div class="py-8 mx-auto sm:px-2 md:px-4 lg:px-12 max-w-7xl">
        <!-- Breadcrumbs -->
        <nav class="mb-6">
            <div class="flex items-center space-x-2 text-sm">
                <a href="?page=dashboard" class="text-gray-500 transition-colors hover:text-primary">
                    Dashboard
                </a>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                <span class="font-medium text-primary">My Applications</span>
            </div>
        </nav>

        <!-- Page Header with Filter -->
        <div class="mb-8">
            <div class="sm:flex sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900">My Applications</h1>
                    <p class="mt-1 text-sm text-gray-600">Track the status of your job applications</p>
                </div>
            </div>
        </div>

        <!-- Application Filtering Section -->
        <div class="relative py-2 mb-6 sm:px-8 lg:px-12">
            <div class="flex flex-col gap-6 mx-auto max-w-7xl">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:gap-4">

                    <!-- Status Filter -->
                    <div class="flex-1 lg:flex-none lg:w-48">
                        <div class="relative" x-data="{ open: false, selected: 'All Status' }">
                            <button @click="open = !open" @click.away="open = false"
                                class="flex items-center justify-between w-full px-4 py-3 text-sm text-gray-700 transition-all duration-200 bg-white border border-gray-300 rounded-sm shadow-sm appearance-none hover:border-primary/50 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
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
                                class="absolute left-0 z-50 w-full mt-2 bg-white rounded-lg shadow-lg ring-1 ring-black ring-opacity-5"
                                x-cloak>
                                <div class="py-1">
                                    <button @click="selected = 'All Status'; open = false; filterByStatus('')"
                                        class="block w-full px-4 py-2 text-sm text-left text-gray-700 transition-colors hover:bg-gray-100">
                                        All Status
                                    </button>
                                    <button @click="selected = 'Pending'; open = false; filterByStatus('pending')"
                                        class="block w-full px-4 py-2 text-sm text-left text-gray-700 transition-colors hover:bg-gray-100">
                                        Pending
                                    </button>
                                    <button @click="selected = 'Under Review'; open = false; filterByStatus('reviewed')"
                                        class="block w-full px-4 py-2 text-sm text-left text-gray-700 transition-colors hover:bg-gray-100">
                                        Under Review
                                    </button>
                                    <button @click="selected = 'Shortlisted'; open = false; filterByStatus('shortlisted')"
                                        class="block w-full px-4 py-2 text-sm text-left text-gray-700 transition-colors hover:bg-gray-100">
                                        Shortlisted
                                    </button>
                                    <button @click="selected = 'Hired'; open = false; filterByStatus('hired')"
                                        class="block w-full px-4 py-2 text-sm text-left text-gray-700 transition-colors hover:bg-gray-100">
                                        Hired
                                    </button>
                                    <button @click="selected = 'Rejected'; open = false; filterByStatus('rejected')"
                                        class="block w-full px-4 py-2 text-sm text-left text-gray-700 transition-colors hover:bg-gray-100">
                                        Rejected
                                    </button>
                                    <button @click="selected = 'Resigned'; open = false; filterByStatus('resigned')"
                                        class="block w-full px-4 py-2 text-sm text-left text-gray-700 transition-colors hover:bg-gray-100">
                                        Resigned
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Interview Filter -->
                    <div class="flex-1 lg:flex-none lg:w-48">
                        <div class="relative" x-data="{ open: false, selected: 'All Applications' }">
                            <button @click="open = !open" @click.away="open = false"
                                class="flex items-center justify-between w-full px-4 py-3 text-sm text-gray-700 transition-all duration-200 bg-white border border-gray-300 rounded-sm shadow-sm appearance-none hover:border-primary/50 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
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
                                class="absolute left-0 z-50 w-full mt-2 bg-white rounded-lg shadow-lg ring-1 ring-black ring-opacity-5"
                                x-cloak>
                                <div class="py-1">
                                    <button @click="selected = 'All Applications'; open = false; filterByInterview('')"
                                        class="block w-full px-4 py-2 text-sm text-left text-gray-700 transition-colors hover:bg-gray-100">
                                        All Applications
                                    </button>
                                    <button @click="selected = 'With Interview'; open = false; filterByInterview('with_interview')"
                                        class="block w-full px-4 py-2 text-sm text-left text-gray-700 transition-colors hover:bg-gray-100">
                                        With Interview
                                    </button>
                                    <button @click="selected = 'No Interview'; open = false; filterByInterview('no_interview')"
                                        class="block w-full px-4 py-2 text-sm text-left text-gray-700 transition-colors hover:bg-gray-100">
                                        No Interview
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Clear Filter Button -->
                    <div class="flex gap-2 lg:flex-shrink-0">
                        <button type="button" id="clearFilters" onclick="clearAllFilters()"
                            class="px-6 py-3 text-sm font-medium text-white transition-all rounded-md shadow-sm bg-primary hover:bg-primary/90 focus:ring-2 focus:ring-primary/50 hover:shadow-md whitespace-nowrap">
                            Clear Filters
                        </button>
                    </div>
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

        <!-- Applications Header -->
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center">
                <h3 class="text-xl font-semibold text-gray-900">
                    All Applications
                </h3>
                <span class="ml-3 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                    <span id="applicationsCount"><?php echo count($applications ?? []); ?></span>
                </span>
            </div>
        </div>

        <?php if (empty($applications)): ?>
            <!-- Empty State -->
            <div class="py-12 text-center bg-white border border-gray-200 rounded-lg shadow-sm">
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

            <!-- Desktop Table View (Hidden on Mobile) -->
            <div class="hidden w-full bg-white border border-gray-200 rounded-lg shadow-sm lg:block">
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
                                            <?php
                                            $statusConfig = [
                                                'pending' => ['color' => 'yellow', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', 'text' => 'Pending'],
                                                'reviewed' => ['color' => 'blue', 'icon' => 'M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2', 'text' => 'Under Review'],
                                                'shortlisted' => ['color' => 'purple', 'icon' => 'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z', 'text' => 'Shortlisted'],
                                                'hired' => ['color' => 'green', 'icon' => 'M5 13l4 4L19 7', 'text' => 'Hired'],
                                                'rejected' => ['color' => 'red', 'icon' => 'M6 18L18 6M6 6l12 12', 'text' => 'Rejected'],
                                                'resigned' => ['color' => 'orange', 'icon' => 'M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1', 'text' => 'Resigned']
                                            ];

                                            $status = $statusConfig[$application['application_status']] ?? ['color' => 'gray', 'icon' => 'M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'text' => ucfirst($application['application_status'])];
                                            ?>
                                            <div class="flex items-center">
                                                <div class="flex items-center justify-center w-6 h-6 mr-3 border-2 border-<?php echo $status['color']; ?>-500 rounded-full">
                                                    <svg class="w-4 h-4 text-<?php echo $status['color']; ?>-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?php echo $status['icon']; ?>" />
                                                    </svg>
                                                </div>
                                                <span class="text-sm font-medium text-<?php echo $status['color']; ?>-600"><?php echo $status['text']; ?></span>
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
            </div>

            <!-- Mobile Card View (Visible on Mobile Only) -->
            <div class="space-y-4 lg:hidden">
                <?php foreach ($applications as $index => $application): ?>
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm application-card" data-application-id="<?php echo $application['application_id']; ?>">
                        <!-- Card Header with Status Badge -->
                        <div class="flex items-start justify-between p-4 pb-2">
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold leading-tight text-gray-900">
                                    <?php echo htmlspecialchars($application['job_title']); ?>
                                </h3>
                                <p class="mt-1 text-sm text-gray-600">
                                    <?php echo htmlspecialchars($application['company_name'] ?? 'Company'); ?>
                                </p>
                            </div>

                            <!-- Status Badge -->
                            <div class="flex-shrink-0 ml-4">
                                <?php if (!$application['is_finalized']): ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                        <div class="w-2 h-2 bg-orange-400 rounded-full"></div>
                                        In Progress
                                    </span>
                                <?php else: ?>
                                    <?php
                                    $statusStyles = [
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'reviewed' => 'bg-blue-100 text-blue-800',
                                        'shortlisted' => 'bg-purple-100 text-purple-800',
                                        'hired' => 'bg-green-100 text-green-800',
                                        'rejected' => 'bg-red-100 text-red-800',
                                        'resigned' => 'bg-gray-100 text-gray-700'
                                    ];

                                    $statusLabels = [
                                        'reviewed' => 'Under Review',
                                        'shortlisted' => 'Shortlisted',
                                        'hired' => 'Hired',
                                        'rejected' => 'Rejected',
                                        'resigned' => 'Resigned',
                                        'pending' => 'Pending'
                                    ];

                                    $statusClass = $statusStyles[$application['application_status']] ?? 'bg-gray-100 text-gray-800';
                                    $statusLabel = $statusLabels[$application['application_status']] ?? ucfirst($application['application_status']);
                                    ?>
                                    <span class="inline-flex items-center px-2.5 py-1  text-xs font-medium <?php echo $statusClass; ?>">

                                        <?php echo $statusLabel; ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                            <!-- More Actions Menu -->
                            <div class="relative mt-1" x-data="{ open: false }">
                                <button @click="open = !open"
                                    @click.away="open = false"
                                    class="flex items-center justify-center w-10 h-10 text-gray-400 transition-colors duration-200 rounded-sm hover:text-gray-600 hover:bg-gray-50">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                                    </svg>
                                </button>

                                <!-- Mobile Dropdown Menu -->
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

                        <!-- Card Body -->
                        <div class="px-4 py-4">
                            <!-- Job Details -->
                            <div class="flex flex-wrap items-center gap-2 mb-3 text-sm text-gray-500">
                                <span><?php echo ucfirst(str_replace('-', ' ', $application['job_type'])); ?></span>
                                <span>•</span>
                                <span><?php echo htmlspecialchars($application['location']); ?></span>
                            </div>

                            <!-- Interview Status -->
                            <div class="mb-3">
                                <?php if (!empty($application['interview_date']) && $application['interview_date'] !== '0000-00-00 00:00:00'): ?>
                                    <div class="flex items-center text-sm">

                                        <span class="font-medium text-green-600">Interview Scheduled:</span>
                                        <span class="ml-1 text-gray-600"><?php echo date('M j, Y g:i A', strtotime($application['interview_date'])); ?></span>
                                    </div>
                                <?php else: ?>
                                    <div class="flex items-center text-sm text-gray-500">

                                        <span>Interview: Pending</span>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Applied Date -->
                            <div class="mb-4 text-sm text-gray-500">
                                <?php if (!empty($application['applied_at'])): ?>
                                    Applied: <?php echo date('M j, Y - g:i A', strtotime($application['applied_at'])); ?>
                                <?php else: ?>
                                    Status: Not submitted
                                <?php endif; ?>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex gap-2">
                                <!-- View Button -->
                                <a href="?page=view-application&id=<?php echo $application['application_id']; ?>"
                                    class="flex-1 px-4 py-2 text-sm font-medium text-center text-white transition-colors duration-200 rounded-sm bg-primary hover:bg-secondary">
                                    View Application
                                </a>
                            </div>

                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        <?php endif; ?>
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
        // Get both desktop table rows and mobile cards
        const desktopRows = Array.from(document.querySelectorAll('tr[data-application-id]'));
        const mobileCards = Array.from(document.querySelectorAll('.application-card[data-application-id]'));

        allApplications = [...desktopRows, ...mobileCards];
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
        filteredApplications = allApplications.filter(element => {
            let shouldShow = true;

            if (newFilter.status && newFilter.status !== '') {
                const statusElement = element.querySelector('.text-yellow-600, .text-blue-600, .text-purple-600, .text-green-600, .text-red-600, .text-orange-600, .bg-yellow-100, .bg-blue-100, .bg-purple-100, .bg-green-100, .bg-red-100, .bg-orange-100');
                const statusText = statusElement ? statusElement.textContent.toLowerCase().trim() : '';

                if (newFilter.status === 'reviewed' && !statusText.includes('review')) shouldShow = false;
                else if (newFilter.status !== 'reviewed' && !statusText.includes(newFilter.status)) shouldShow = false;
            }

            if (newFilter.interview && newFilter.interview !== '') {
                const hasInterview = element.textContent.includes('Scheduled');
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
        allApplications.forEach(element => {
            if (filteredApplications.includes(element)) {
                element.style.display = '';
            } else {
                element.style.display = 'none';
            }
        });

        // Update count - count only visible desktop rows OR mobile cards (not both)
        const visibleDesktopRows = document.querySelectorAll('tr[data-application-id]:not([style*="display: none"])');
        const visibleMobileCards = document.querySelectorAll('.application-card[data-application-id]:not([style*="display: none"])');

        const count = Math.max(visibleDesktopRows.length, visibleMobileCards.length);

        const countElement = document.getElementById('applicationsCount');
        if (countElement) {
            countElement.textContent = count;
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