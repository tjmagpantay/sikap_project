<?php
include_once __DIR__ . '/components/employer_auth_check.php';
include_once __DIR__ . '/../components/navbar-top.php';
include_once __DIR__ . '/components/navbar-employer.php';

// Get employer info for greeting
$employerName = '';
if (isset($_SESSION['user_id'])) {
    $employerName = $employer['first_name'] ?? 'Employer';
}

$startDate = date('M j', strtotime('-7 days'));
$endDate = date('M j');

$statusFilter = $_GET['status'] ?? null;

?>

<div class="min-h-screen sm:px-6 md:px-16 lg:px-24">
    <!-- Main Content Container - Match navbar padding -->
    <div class="container px-0 py-8 mx-auto max-w-7xl sm:px-2 md:px-4 lg:px-12">

        <!-- Greeting Section -->
        <div class="px-4 mt-12 mb-12 sm:px-0">
            <div class="flex flex-col items-start justify-between lg:flex-row lg:items-center">
                <!-- Left side: Greeting -->
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">
                        Good morning, <?php echo htmlspecialchars($employer['first_name'] ?? $_SESSION['email']); ?>
                    </h2>
                    <p class="mt-1 text-sm text-gray-600">
                        Here is your job listings statistic report
                    </p>
                </div>

                <!-- Right side: Current Date (Philippine Time) -->
                <div class="relative flex items-center mt-4 lg:mt-0">
                    <div class="flex items-center px-4 py-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-sm shadow-sm">
                        <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span>
                            <?php
                            // Set timezone to Philippine Time
                            date_default_timezone_set('Asia/Manila');
                            echo date("M d, Y - l"); // Example: Sep 25, 2025 - Thursday
                            ?>
                        </span>
                    </div>
                </div>

            </div>
        </div>

        <!-- Statistics Cards Section -->
        <div class="px-4 mb-8 sm:px-0">
            <?php
            // FIXED: Use proper statistics from controller
            $totalJobs = $stats['total_jobs'] ?? 0; // Card 1: ALL jobs count
            $totalApplications = $stats['total_applications'] ?? 0; // Card 2: unchanged
            $openJobs = 0; // Card 3: Count only TRULY OPEN jobs (not expired)

            // FIXED: Calculate open jobs count considering expiry like manage-jobs.php
            if (isset($allJobs) && !empty($allJobs)) {
                foreach ($allJobs as $job) {
                    // Use the same logic as manage-jobs.php for determining actual status
                    $actualStatus = $job['actual_status'] ?? $job['job_status'];

                    // Only count jobs that are truly active (open and not expired)
                    if ($actualStatus == 'open') {
                        $openJobs++;
                    }
                }
            }
            ?>
            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">

                <!-- Card 1: FIXED - Total Jobs Count (ALL jobs regardless of status) -->
                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                    <div class="mb-6">
                        <h3 class="mb-6 text-gray-700 text-md font-xl">Total Job Posts</h3>
                        <div class="flex items-baseline">
                            <span class="text-3xl font-bold text-gray-900"><?php echo $totalJobs; ?></span>
                            <svg class="ml-2" width="24px" height="24px" viewBox="0 0 20.00 20.00" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <title>arrow_right_up [#291]</title>
                                    <desc>Created with Sketch.</desc>
                                    <defs></defs>
                                    <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <g id="Dribbble-Light-Preview" transform="translate(-100.000000, -6882.000000)" fill="#F3AF0E">
                                            <g id="icons" transform="translate(56.000000, 160.000000)">
                                                <polygon id="arrow_right_up-[#291]" points="56 6722 56 6724 60.653 6724 54.354 6730.298 51.821 6727.765 44 6735.586 45.414 6737 51.821 6730.593 52.94 6731.713 52.937 6731.716 54.351 6733.13 62 6725.481 62 6730 64 6730 64 6722"></polygon>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </svg>
                        </div>
                        <p class="mt-2 text-xs text-gray-500">
                            All job posts created (active, draft, closed, expired) as of <?php echo date('F j'); ?>
                        </p>
                    </div>

                    <div class="pt-4">
                        <a href="?page=manage-jobs" class="flex items-center text-sm text-primary font-sm">
                            View All Jobs
                            <svg class="ml-2" width="24px" height="24px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path d="M4 12H20M20 12L16 8M20 12L16 16" stroke="#092C4C" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"></path>
                                </g>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Card 2: Total Applications Received (unchanged - already good) -->
                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                    <div class="mb-6">
                        <h3 class="mb-6 text-gray-700 text-md font-xl">Total Applications Received</h3>
                        <div class="flex items-baseline">
                            <span class="text-3xl font-bold text-gray-900"><?php echo $totalApplications; ?></span>
                            <svg class="ml-2" width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path d="M17.5 18H18.7687C19.2035 18 19.4209 18 19.5817 17.9473C20.1489 17.7612 20.5308 17.1231 20.498 16.4163C20.4887 16.216 20.42 15.9676 20.2825 15.4708C20.168 15.0574 20.1108 14.8507 20.0324 14.6767C19.761 14.0746 19.2766 13.6542 18.7165 13.5346C18.5546 13.5 18.3737 13.5 18.0118 13.5L15.5 13.5346M14.6899 11.6996C15.0858 11.892 15.5303 12 16 12C17.6569 12 19 10.6569 19 9C19 7.34315 17.6569 6 16 6C15.7295 6 15.4674 6.0358 15.2181 6.10291M13.5 8C13.5 10.2091 11.7091 12 9.5 12C7.29086 12 5.5 10.2091 5.5 8C5.5 5.79086 7.29086 4 9.5 4C11.7091 4 13.5 5.79086 13.5 8ZM6.81765 14H12.1824C12.6649 14 12.9061 14 13.1219 14.0461C13.8688 14.2056 14.5147 14.7661 14.8765 15.569C14.9811 15.8009 15.0574 16.0765 15.21 16.6278C15.3933 17.2901 15.485 17.6213 15.4974 17.8884C15.5411 18.8308 15.0318 19.6817 14.2756 19.9297C14.0613 20 13.7714 20 13.1916 20H5.80844C5.22864 20 4.93875 20 4.72441 19.9297C3.96818 19.6817 3.45888 18.8308 3.50261 17.8884C3.51501 17.6213 3.60668 17.2901 3.79003 16.6278C3.94262 16.0765 4.01891 15.8009 4.12346 15.569C4.4853 14.7661 5.13116 14.2056 5.87806 14.0461C6.09387 14 6.33513 14 6.81765 14Z" stroke="#F3AF0E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                </g>
                            </svg>
                        </div>
                        <p class="mt-2 text-xs text-gray-500">
                            Candidates who applied to your job posts as of <?php echo date('F j'); ?>
                        </p>
                    </div>

                    <div class="pt-4">
                        <a href="?page=view-all-applicants" class="flex items-center text-sm text-primary font-sm">
                            View All Applicants
                            <svg class="ml-2" width="24px" height="24px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path d="M4 12H20M20 12L16 8M20 12L16 16" stroke="#092C4C" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"></path>
                                </g>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Card 3: FIXED - Active Jobs (Only truly active jobs - open and not expired) -->
                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                    <div class="mb-6">
                        <h3 class="mb-6 text-gray-700 text-md font-xl">Active Jobs</h3>

                        <!-- Circular Progress Chart -->
                        <div class="flex items-center justify-start mb-4">
                            <div class="relative w-16 h-16 mr-4">
                                <?php
                                // FIXED: Calculate percentage based on truly active jobs vs total jobs
                                $activePercentage = $totalJobs > 0 ? round(($openJobs / $totalJobs) * 100) : 0;
                                $circumference = 2 * 3.14159 * 24; // radius = 24 (smaller circle)
                                $strokeDashoffset = $circumference - ($activePercentage / 100) * $circumference;
                                ?>

                                <!-- Background circle -->
                                <svg class="w-16 h-16 transform -rotate-90" viewBox="0 0 52 52">
                                    <circle
                                        cx="26"
                                        cy="26"
                                        r="24"
                                        stroke="#f3f4f6"
                                        stroke-width="4"
                                        fill="none" />
                                    <!-- Progress circle -->
                                    <circle
                                        cx="26"
                                        cy="26"
                                        r="24"
                                        stroke="#F3AF0E"
                                        stroke-width="4"
                                        fill="none"
                                        stroke-linecap="round"
                                        stroke-dasharray="<?php echo $circumference; ?>"
                                        stroke-dashoffset="<?php echo $strokeDashoffset; ?>"
                                        class="transition-all duration-300 ease-in-out" />
                                </svg>

                                <!-- Percentage text in center -->
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <span class="text-sm font-bold text-gray-900"><?php echo $openJobs; ?></span>
                                </div>
                            </div>

                            <!-- Text beside circle -->
                            <div class="flex-1">
                                <div class="text-3xl font-bold text-gray-900"><?php echo $openJobs; ?></div>
                            </div>
                        </div>

                        <p class="mt-2 text-xs text-gray-500">
                            Job posts currently accepting applications (excluding expired)
                        </p>
                    </div>

                    <div class="pt-4">
                        <a href="?page=manage-jobs&job_status=open" class="flex items-center text-sm text-primary font-sm">
                            View Active Jobs
                            <svg class="ml-2" width="24px" height="24px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path d="M4 12H20M20 12L16 8M20 12L16 16" stroke="#092C4C" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"></path>
                                </g>
                            </svg>
                        </a>
                    </div>
                </div>

            </div>
        </div>

        <!-- Recent Job Posts Section -->
        <div class="mb-8 border border-gray-400 rounded-lg">
            <div class="bg-white rounded-lg shadow-sm sm:px-0">
                <div class="w-full ">
                    <div class="px-4 py-5 border-b border-gray-200">
                        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                            <!-- Left side: Title and Count -->
                            <div class="flex items-center mb-4 lg:mb-0">
                                <h3 class="text-xl font-semibold text-gray-900">Recent Job Post</h3>
                                <span class="ml-3 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    <?php echo $totalJobCount ?? '0'; ?>
                                </span>
                            </div>
                            <!-- Right side: Filters -->
                            <div class="flex flex-col gap-4 mx-auto space-x-2 lg:flex-row lg:items-center lg:w-auto lg:ml-4">
                            </div>
                            <!-- Job Status Filter -->
                            <div class="relative" x-data="{ open: false, selected: '<?php echo $statusFilter ? ucfirst($statusFilter) : 'Job status'; ?>' }">
                                <button @click="open = !open"
                                    @click.away="open = false"
                                    class="appearance-none bg-white border border-gray-200 rounded-sm px-4 py-3 pr-12 text-sm text-gray-700 shadow-sm hover:border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all duration-200 flex items-center justify-between w-full lg:min-w-[140px]">
                                    <span x-text="selected"></span>
                                    <svg class="w-4 h-4 ml-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
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
                                    class="absolute left-0 z-50 w-full mt-2 bg-white rounded-md shadow-lg lg:right-0 lg:left-auto lg:w-48 ring-1 ring-black ring-opacity-5"
                                    x-cloak>
                                    <div class="py-1">
                                        <a href="?page=dashboard"
                                            @click="selected = 'All Status'; open = false"
                                            class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 <?php echo !$statusFilter ? 'bg-gray-50' : ''; ?>">
                                    </div>
                                    All Status
                                    </a>
                                    <a href="?page=dashboard&status=open"
                                        @click="selected = 'Active Jobs'; open = false"
                                        class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 <?php echo $statusFilter === 'open' ? 'bg-gray-50' : ''; ?>">
                                        Active Jobs
                                    </a>
                                    <a href="?page=dashboard&status=draft"
                                        @click="selected = 'Drafts'; open = false"
                                        class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 <?php echo $statusFilter === 'draft' ? 'bg-gray-50' : ''; ?>">
                                        Drafts
                                    </a>
                                    <a href="?page=dashboard&status=expired"
                                        @click="selected = 'Expired'; open = false"
                                        class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 <?php echo $statusFilter === 'expired' ? 'bg-gray-50' : ''; ?>">
                                        Expired
                                    </a>
                                    <a href="?page=dashboard&status=closed"
                                        @click="selected = 'Closed'; open = false"
                                        class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 <?php echo $statusFilter === 'closed' ? 'bg-gray-50' : ''; ?>">
                                        Closed
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Desktop Table View (Hidden on Mobile) -->
            <div class="hidden w-fulloverflow-visible lg:block">
                <table class="w-full divide-y divide-gray-300 table-fixed">
                    <!-- Table Header -->
                    <thead class="bg-primary">
                        <tr>
                            <th scope="col" class="w-3/5 px-6 py-4 text-sm font-medium tracking-wider text-left text-white uppercase">
                                JOBS
                            </th>
                            <th scope="col" class="px-6 py-4 text-sm font-medium tracking-wider text-left text-white uppercase w-1/8">
                                STATUS
                            </th>
                            <th scope="col" class="px-6 py-4 text-sm font-medium tracking-wider text-left text-white uppercase w-1/8">
                                APPLICATIONS
                            </th>
                            <th scope="col" class="w-1/5 px-6 py-4 text-sm font-medium tracking-wider text-left text-white uppercase">
                                ACTIONS
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-300 ">
                        <?php if (empty($jobs)): ?>
                            <tr>
                                <td colspan="4" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="flex items-center justify-center w-16 h-16 mx-auto rounded-full">
                                            <i class="text-2xl text-gray-400 fas fa-briefcase"></i>
                                        </div>
                                        <h3 class="mt-4 text-lg font-medium text-gray-900">No job posts yet</h3>
                                        <p class="max-w-sm mt-2 text-sm text-gray-500">
                                            Create your first job post to start attracting qualified candidates to your company.
                                        </p>
                                        <div class="mt-6">
                                            <a href="?page=post-job"
                                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white border border-transparent rounded-md shadow-sm bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                                <i class="mr-2 fas fa-plus"></i>
                                                Post Your First Job
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($jobs as $job):
                                // FIXED: Add the same status calculation logic as manage-jobs.php
                                $actualStatus = $job['actual_status'] ?? $job['job_status'];
                                $displayStatus = $actualStatus;

                                // Calculate days remaining for deadline display
                                $daysRemaining = 0;
                                $isExpired = false;
                                if (!empty($job['application_deadline'])) {
                                    $deadline = new DateTime($job['application_deadline']);
                                    $now = new DateTime();
                                    if ($deadline > $now) {
                                        $daysRemaining = $now->diff($deadline)->days;
                                    } else {
                                        $isExpired = true;
                                    }
                                }
                            ?>
                                <tr class="hover:bg-gray-50">
                                    <!-- Job Info Column -->
                                    <td class="px-6 py-5">
                                        <div>
                                            <div class="mb-1 text-sm font-medium text-gray-900">
                                                <!-- Enhanced title with forced wrapping like view-job.php -->
                                                <div class="max-w-full overflow-hidden">
                                                    <div class="max-w-full break-words overflow-wrap-anywhere word-break-break-all"
                                                        title="<?php echo htmlspecialchars($job['job_title']); ?>">
                                                        <?php echo htmlspecialchars($job['job_title']); ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                <?php echo ucfirst(str_replace('_', ' ', $job['job_type'])); ?>
                                                • <?php echo $daysRemaining > 0 ? $daysRemaining . ' days remaining' : 'Posted ' . date('M j, Y', strtotime($job['created_at'])); ?>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Status Column - FIXED -->
                                    <td class="px-6 py-5">
                                        <div class="flex items-center">
                                            <?php
                                            // FIXED: Use the same status logic as manage-jobs.php
                                            switch ($displayStatus) {
                                                case 'open':
                                                    echo '<div class="flex items-center">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                  </div>';
                                                    echo '<span class="ml-2 text-sm font-medium text-gray-600">Active</span>';
                                                    break;
                                                case 'expired':
                                                    echo '<div class="flex items-center">
                                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                  </div>';
                                                    echo '<span class="ml-2 text-sm font-medium text-gray-600">Expired</span>';
                                                    break;
                                                case 'closed':
                                                    echo '<div class="flex items-center">
                                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                  </div>';
                                                    echo '<span class="ml-2 text-sm font-medium text-red-600">Closed</span>';
                                                    break;
                                                case 'draft':
                                                    echo '<div class="flex items-center">
                                    <svg class="w-4 h-4 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                  </div>';
                                                    echo '<span class="ml-2 text-sm font-medium text-gray-600">Draft</span>';
                                                    break;
                                                default:
                                                    echo '<span class="ml-2 text-sm font-medium text-gray-600">' . ucfirst($displayStatus) . '</span>';
                                            }
                                            ?>
                                        </div>
                                    </td>

                                    <!-- Applications Column -->
                                    <td class="px-6 py-5">
                                        <div class="flex items-center text-sm text-gray-900">
                                            <svg class="w-4 h-4 mr-2 text-gray-400" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M17.5 18H18.7687C19.2035 18 19.4209 18 19.5817 17.9473C20.1489 17.7612 20.5308 17.1231 20.498 16.4163C20.4887 16.216 20.42 15.9676 20.2825 15.4708C20.168 15.0574 20.1108 14.8507 20.0324 14.6767C19.761 14.0746 19.2766 13.6542 18.7165 13.5346C18.5546 13.5 18.3737 13.5 18.0118 13.5L15.5 13.5346M14.6899 11.6996C15.0858 11.892 15.5303 12 16 12C17.6569 12 19 10.6569 19 9C19 7.34315 17.6569 6 16 6C15.7295 6 15.4674 6.0358 15.2181 6.10291M13.5 8C13.5 10.2091 11.7091 12 9.5 12C7.29086 12 5.5 10.2091 5.5 8C5.5 5.79086 7.29086 4 9.5 4C11.7091 4 13.5 5.79086 13.5 8ZM6.81765 14H12.1824C12.6649 14 12.9061 14 13.1219 14.0461C13.8688 14.2056 14.5147 14.7661 14.8765 15.569C14.9811 15.8009 15.0574 16.0765 15.21 16.6278C15.3933 17.2901 15.485 17.6213 15.4974 17.8884C15.5411 18.8308 15.0318 19.6817 14.2756 19.9297C14.0613 20 13.7714 20 13.1916 20H5.80844C5.22864 20 4.93875 20 4.72441 19.9297C3.96818 19.6817 3.45888 18.8308 3.50261 17.8884C3.51501 17.6213 3.60668 17.2901 3.79003 16.6278C3.94262 16.0765 4.01891 15.8009 4.12346 15.569C4.4853 14.7661 5.13116 14.2056 5.87806 14.0461C6.09387 14 6.33513 14 6.81765 14Z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <span>
                                                <span class="font-medium"><?php echo $job['application_count']; ?></span>
                                                <span class="ml-1 text-gray-500">Applications</span>
                                            </span>
                                        </div>
                                    </td>

                                    <!-- Actions Column -->
                                    <td class="px-6 py-5">
                                        <div class="flex items-center space-x-3">
                                            <!-- View Applications Button -->
                                            <a href="?page=job-applications&job_id=<?php echo $job['job_id']; ?>"
                                                class="inline-flex items-center px-6 py-3 text-sm font-medium transition-colors duration-200 bg-gray-100 rounded-sm text-primary hover:bg-primary hover:text-white hover:background-primary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                                View Applications
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
                                                    x-cloak>
                                                    <div class="py-1">
                                                        <!-- Promote Job Option (for highlighted job - you can add logic for this later) -->
                                                        <?php if ($job['job_id'] == 5): ?>
                                                            <a href="?page=promote-job&id=<?php echo $job['job_id']; ?>"
                                                                class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                                <i class="mr-3 text-blue-400 fas fa-bullhorn"></i>
                                                                Promote Job
                                                            </a>
                                                        <?php endif; ?>

                                                        <a href="?page=view-employer-job&id=<?php echo $job['job_id']; ?>"
                                                            class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                            <i class="mr-3 text-blue-400 fas fa-eye"></i>
                                                            View Detail
                                                        </a>

                                                        <?php if ($job['job_status'] !== 'closed'): ?>
                                                            <a href="?page=edit-job&id=<?php echo $job['job_id']; ?>"
                                                                class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                                <i class="mr-3 text-yellow-400 fas fa-edit"></i>
                                                                Edit Job
                                                            </a>

                                                            <?php if ($job['job_status'] == 'open'): ?>
                                                                <a href="?page=toggle-job-status&id=<?php echo $job['job_id']; ?>&status=paused"
                                                                    class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                                    <i class="mr-3 text-orange-400 fas fa-pause"></i>
                                                                    Make it Expire
                                                                </a>
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                            <?php endforeach; ?>
                        <?php endif; ?>

                    </tbody>
                </table>
            </div>



            <!-- Mobile Card View (Visible on Mobile Only) -->
            <?php if (!empty($jobs)): ?>
                <div class="space-y-4 lg:hidden">
                    <?php foreach ($jobs as $job):
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
                        <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                            <!-- Card Header -->
                            <div class="flex items-start justify-between p-4 pb-2">
                                <div class="flex-1 min-w-0"> <!-- Added min-w-0 for proper flex truncation -->
                                    <h3 class="text-lg font-semibold leading-tight text-gray-900">
                                        <!-- Enhanced title with truncation -->
                                        <span class="block truncate" title="<?php echo htmlspecialchars($job['job_title']); ?>">
                                            <?php echo htmlspecialchars($job['job_title']); ?>
                                        </span>
                                    </h3>
                                    <p class="mt-1 text-sm text-gray-500">
                                        <?php echo ucfirst(str_replace('_', ' ', $job['job_type'])); ?>
                                        • <?php echo $daysRemaining > 0 ? $daysRemaining . ' days remaining' : 'Posted ' . date('M j, Y', strtotime($job['created_at'])); ?>
                                    </p>
                                </div>

                                <!-- Status Badge -->
                                <div class="flex-shrink-0 ml-4">
                                    <?php
                                    $statusStyles = [
                                        'open' => 'bg-green-100 text-green-800',
                                        'closed' => 'bg-red-100 text-red-800',
                                        'draft' => 'bg-yellow-100 text-yellow-800',
                                        'paused' => 'bg-orange-100 text-orange-800'
                                    ];

                                    $statusLabels = [
                                        'open' => 'Active',
                                        'closed' => 'Closed',
                                        'draft' => 'Draft',
                                        'paused' => 'Paused'
                                    ];

                                    $statusClass = $statusStyles[$job['job_status']] ?? 'bg-gray-100 text-gray-800';
                                    $statusLabel = $statusLabels[$job['job_status']] ?? ucfirst($job['job_status']);
                                    ?>
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium <?php echo $statusClass; ?>">
                                        <?php echo $statusLabel; ?>
                                    </span>
                                </div>

                                <!-- More Actions Menu -->
                                <div class="relative ml-2" x-data="{ open: false }">
                                    <button @click="open = !open"
                                        @click.away="open = false"
                                        class="flex items-center justify-center w-8 h-8 text-gray-400 transition-colors duration-200 rounded-sm hover:text-gray-600 hover:bg-gray-50">
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
                                            <a href="?page=view-employer-job&id=<?php echo $job['job_id']; ?>"
                                                class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                <i class="mr-3 text-blue-400 fas fa-eye"></i>
                                                View Detail
                                            </a>

                                            <?php if ($job['job_status'] !== 'closed'): ?>
                                                <a href="?page=edit-job&id=<?php echo $job['job_id']; ?>"
                                                    class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                    <i class="mr-3 text-yellow-400 fas fa-edit"></i>
                                                    Edit Job
                                                </a>

                                                <?php if ($job['job_status'] == 'open'): ?>
                                                    <a href="?page=toggle-job-status&id=<?php echo $job['job_id']; ?>&status=paused"
                                                        class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                        <i class="mr-3 text-orange-400 fas fa-pause"></i>
                                                        Make it Expire
                                                    </a>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Body -->
                            <div class="px-4 py-4">
                                <!-- Applications Count -->
                                <div class="flex items-center mb-4 text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M17.5 18H18.7687C19.2035 18 19.4209 18 19.5817 17.9473C20.1489 17.7612 20.5308 17.1231 20.498 16.4163C20.4887 16.216 20.42 15.9676 20.2825 15.4708C20.168 15.0574 20.1108 14.8507 20.0324 14.6767C19.761 14.0746 19.2766 13.6542 18.7165 13.5346C18.5546 13.5 18.3737 13.5 18.0118 13.5L15.5 13.5346M14.6899 11.6996C15.0858 11.892 15.5303 12 16 12C17.6569 12 19 10.6569 19 9C19 7.34315 17.6569 6 16 6C15.7295 6 15.4674 6.0358 15.2181 6.10291M13.5 8C13.5 10.2091 11.7091 12 9.5 12C7.29086 12 5.5 10.2091 5.5 8C5.5 5.79086 7.29086 4 9.5 4C11.7091 4 13.5 5.79086 13.5 8ZM6.81765 14H12.1824C12.6649 14 12.9061 14 13.1219 14.0461C13.8688 14.2056 14.5147 14.7661 14.8765 15.569C14.9811 15.8009 15.0574 16.0765 15.21 16.6278C15.3933 17.2901 15.485 17.6213 15.4974 17.8884C15.5411 18.8308 15.0318 19.6817 14.2756 19.9297C14.0613 20 13.7714 20 13.1916 20H5.80844C5.22864 20 4.93875 20 4.72441 19.9297C3.96818 19.6817 3.45888 18.8308 3.50261 17.8884C3.51501 17.6213 3.60668 17.2901 3.79003 16.6278C3.94262 16.0765 4.01891 15.8009 4.12346 15.569C4.4853 14.7661 5.13116 14.2056 5.87806 14.0461C6.09387 14 6.33513 14 6.81765 14Z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <span class="font-medium"><?php echo $job['application_count']; ?></span>
                                    <span class="ml-1">Applications</span>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex gap-2">
                                    <!-- View Applications Button -->
                                    <a href="?page=job-applications&job_id=<?php echo $job['job_id']; ?>"
                                        class="flex-1 px-4 py-2 text-sm font-medium text-center text-white transition-colors duration-200 rounded-sm bg-primary hover:bg-secondary">
                                        View Applications
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Empty State for Mobile -->
                    <?php if (empty($jobs)): ?>
                        <div class="px-6 py-16 text-center lg:hidden">
                            <div class="flex flex-col items-center">
                                <div class="flex items-center justify-center w-16 h-16 mx-auto rounded-full">
                                    <i class="text-2xl text-gray-400 fas fa-briefcase"></i>
                                </div>
                                <h3 class="mt-4 text-lg font-medium text-gray-900">No job posts yet</h3>
                                <p class="max-w-sm mt-2 text-sm text-gray-500">
                                    Create your first job post to start attracting qualified candidates to your company.
                                </p>
                                <div class="mt-6">
                                    <a href="?page=post-job"
                                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-white border border-transparent rounded-md shadow-sm bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                        <i class="mr-2 fas fa-plus"></i>
                                        Post Your First Job
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Pagination -->
                    <div class="px-6 py-4 border-t border-gray-200">
                        <?php if ($totalJobCount > 5): ?>
                            <div class="flex flex-col items-center justify-center sm:flex-row">
                                <!-- Pagination controls -->
                                <nav class="flex mb-4 space-x-1 sm:mb-0" aria-label="Pagination">
                                    <!-- Previous Page -->
                                    <?php if ($hasPrevPage): ?>
                                        <a href="?page=dashboard&p=<?php echo $currentPage - 1; ?><?php echo $statusFilter ? '&status=' . $statusFilter : ''; ?>"
                                            class="flex items-center justify-center w-8 h-8 text-gray-700 transition-colors duration-200 rounded hover:text-gray-900 hover:bg-gray-100">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                            </svg>
                                        </a>
                                    <?php else: ?>
                                        <span class="flex items-center justify-center w-8 h-8 text-gray-400 opacity-50">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                            </svg>
                                        </span>
                                    <?php endif; ?>

                                    <!-- Page Numbers -->
                                    <?php
                                    $startPage = max(1, $currentPage - 2);
                                    $endPage = min($totalPages, $currentPage + 2);

                                    // Preserve URL parameters
                                    $urlParams = $statusFilter ? '&status=' . urlencode($statusFilter) : '';

                                    for ($i = $startPage; $i <= $endPage; $i++):
                                    ?>
                                        <?php if ($i == $currentPage): ?>
                                            <span class="flex items-center justify-center w-8 h-8 text-sm font-medium text-white rounded bg-primary">
                                                <?php echo sprintf('%02d', $i); ?>
                                            </span>
                                        <?php else: ?>
                                            <a href="?page=dashboard&p=<?php echo $i; ?><?php echo $urlParams; ?>"
                                                class="flex items-center justify-center w-8 h-8 text-sm font-medium text-gray-700 transition-colors duration-200 rounded hover:bg-gray-100">
                                                <?php echo sprintf('%02d', $i); ?>
                                            </a>
                                        <?php endif; ?>
                                    <?php endfor; ?>

                                    <!-- Next Page -->
                                    <?php if ($hasNextPage): ?>
                                        <a href="?page=dashboard&p=<?php echo $currentPage + 1; ?><?php echo $urlParams; ?>"
                                            class="flex items-center justify-center w-8 h-8 text-gray-700 transition-colors duration-200 rounded hover:text-gray-900 hover:bg-gray-100">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </a>
                                    <?php else: ?>
                                        <span class="flex items-center justify-center w-8 h-8 text-gray-400 opacity-50">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </span>
                                    <?php endif; ?>
                                </nav>

                                <div class="text-sm text-center text-gray-700 sm:text-right sm:ml-4">
                                    Showing <?php echo (($currentPage - 1) * 5) + 1; ?> to <?php echo min($currentPage * 5, $totalJobCount); ?> of <?php echo $totalJobCount; ?> results
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="text-sm text-center text-gray-500">
                                Showing all <?php echo $totalJobCount; ?> job<?php echo $totalJobCount != 1 ? 's' : ''; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
        </div>
    </div>

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>


    <style>
        /* Force text wrapping for long strings without spaces - Same as view-job.php */
        .overflow-wrap-anywhere {
            overflow-wrap: anywhere;
            word-break: break-word;
            hyphens: auto;
        }

        /* Ensure container doesn't overflow */
        .rounded-lg {
            overflow: hidden;
        }

        /* Additional fallback for extremely long words */
        .break-words {
            word-wrap: break-word;
            word-break: break-word;
            overflow-wrap: break-word;
        }

        /* Prevent horizontal scrolling */
        .word-break-break-all {
            word-break: break-all;
        }

        /* Ensure max-width is respected */
        .max-w-full {
            max-width: 100%;
            min-width: 0;
        }

        /* Force table column width constraints */
        .table-fixed {
            table-layout: fixed;
        }

        /* Specific fix for table cells */
        .table-fixed td {
            word-wrap: break-word;
            overflow-wrap: break-word;
            word-break: break-word;
        }
    </style>