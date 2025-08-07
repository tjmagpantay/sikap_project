<?php
include_once __DIR__ . '/../components/navbar-top.php';
include_once __DIR__ . '/components/navbar-employer.php';
// Get employer info for greeting
$employerName = '';
if (isset($_SESSION['user_id'])) {
    // You can get this from your controller
    $employerName = $employer['first_name'] ?? 'Employer';
}

// Current date range (you can make this dynamic later)
$startDate = date('M j', strtotime('-7 days'));
$endDate = date('M j');

?>

<div class="h-4"></div>

<div class="min-h-screen bg-white">
    <!-- Main Content Container - Match navbar padding -->
    <div class="px-4 py-8 sm:px-6 md:px-16 lg:px-24">

        <!-- Hero Card Section -->
        <div class="mb-8">
            <div class="relative overflow-hidden rounded-md shadow-xl" style="background: linear-gradient(135deg, #092C4C 0%, #F3AF0E 100%);">
                <!-- Background Image with Gradient Overlay -->
                <div class="absolute inset-0">
                    <img src="assets/images/hero-page-bg.png"
                        alt="Hero Background"
                        class="object-cover w-full h-full opacity-50"
                        onerror="this.style.display='none'">
                    <!-- Reduced gradient overlay opacity for better image visibility -->
                    <div class="absolute inset-0" style="background: linear-gradient(135deg, rgba(9, 44, 76, 0.4) 0%, rgba(243, 175, 14, 0.4) 100%);"></div>
                </div>

                <!-- Hero Content -->
                <div class="relative px-6 py-8 sm:px-8 sm:py-16 lg:px-12 lg:py-20">
                    <div class="max-w-3xl">
                        <h1 class="text-3xl font-bold tracking-tight text-white sm:text-3xl lg:text-3xl">
                            Post a Job That Stands Out
                        </h1>
                        <p class="max-w-2xl mt-2 text-sm leading-relaxed text-white sm:mt-3 sm:text-sm">
                            Create a compelling job post that highlights your needs and attracts the perfect match.
                        </p>
                    </div>

                    <!-- Decorative Pattern -->
                    <div class="absolute top-4 right-4 opacity-20">
                        <svg class="w-24 h-24 text-white" fill="currentColor" viewBox="0 0 100 100">
                            <pattern id="diagonals" patternUnits="userSpaceOnUse" width="40" height="40">
                                <path d="M0,40 L40,0 M-10,10 L10,-10 M30,50 L50,30" stroke="currentColor" stroke-width="2" />
                            </pattern>
                            <rect width="100" height="100" fill="url(#diagonals)" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Greeting Section -->
        <div class="mt-12 mb-12">
            <div class="flex items-center justify-between">
                <!-- Left side: Greeting -->
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">
                        Good morning, <?php echo htmlspecialchars($employer['first_name'] ?? $_SESSION['email']); ?>
                    </h2>
                    <p class="mt-1 text-sm text-gray-600">
                        Here is your job listings statistic report from <?php echo $startDate; ?> - <?php echo $endDate; ?>
                    </p>
                </div>

                <!-- Right side: Date Range Selector -->
                <div class="flex items-center">
                    <button class="flex items-center px-4 py-3 text-sm font-medium text-gray-700 transition-colors duration-200 bg-white border border-gray-300 rounded-sm shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <?php echo $startDate; ?> - <?php echo $endDate; ?>
                        <svg class="w-4 h-4 ml-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Statistics Cards Section -->
        <div class="mb-8">
            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">

                <!-- Card 1: New Job Post to review -->
                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                    <div class="mb-6">
                        <h3 class="mb-6 text-gray-700 text-md font-xl">New Job Post to review</h3>
                        <div class="flex items-baseline">
                            <span class="text-3xl font-bold text-gray-900"><?php echo $pendingReviews ?? '0'; ?></span>
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
                            Total of job post to review as of <?php echo date('F j'); ?>
                        </p>
                    </div>

                    <div class="pt-4">
                        <a href="?page=pending-job-reviews" class="flex items-center text-sm text-primary font-sm">
                            Job Post report
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

                <!-- Card 2: New Employer to review -->
                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                    <div class="mb-6">
                        <h3 class="mb-6 text-gray-700 text-md font-xl">New Employer to review</h3>
                        <div class="flex items-baseline">
                            <span class="text-3xl font-bold text-gray-900">
                                <?php
                                // Calculate pending employer applications
                                $pendingEmployers = 4; // You can fetch this from your database
                                echo $pendingEmployers;
                                ?>
                            </span>
                        </div>
                        <p class="mt-2 text-xs text-gray-500">
                            Total of employer to review as of <?php echo date('F j'); ?>
                        </p>
                    </div>

                    <div class="pt-4">
                        <a href="?page=pending-employer-reviews" class="flex items-center text-sm text-primary font-sm">
                            All Employer
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

                <!-- Card 3: Active Job Posts (with circular progress) -->
                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                    <div class="mb-6">
                        <h3 class="mb-6 text-gray-700 text-md font-xl">Active Job Posts</h3>

                        <!-- Circular Progress Chart -->
                        <div class="flex items-center justify-start mb-4">
                            <div class="relative w-16 h-16 mr-4">
                                <?php
                                $activePercentage = $totalJobs > 0 ? round(($activeJobs / $totalJobs) * 100) : 84;
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
                                        stroke="#fbbf24"
                                        stroke-width="4"
                                        fill="none"
                                        stroke-linecap="round"
                                        stroke-dasharray="<?php echo $circumference; ?>"
                                        stroke-dashoffset="<?php echo $strokeDashoffset; ?>"
                                        class="transition-all duration-300 ease-in-out" />
                                </svg>

                                <!-- Percentage text in center -->
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <span class="text-sm font-bold text-gray-900"><?php echo $activePercentage; ?>%</span>
                                </div>
                            </div>

                            <!-- Text beside circle -->
                            <div class="flex-1">
                                <div class="text-3xl font-bold text-gray-900"><?php echo $activePercentage; ?>%</div>
                            </div>
                        </div>

                        <p class="mt-2 text-xs text-gray-500">
                            <?php echo $activeJobs ?? '0'; ?> out of <?php echo $totalJobs ?? '0'; ?> jobs are active
                        </p>
                    </div>

                    <div class="pt-4">
                        <a href="?page=manage-jobs" class="flex items-center text-sm text-primary font-sm">
                            All Job Post
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
        <div class="mb-8">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 w-full">
                <div class="px-6 py-5 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <!-- Left side: Title and Count -->
                        <div class="flex items-center">
                            <h3 class="text-2xl font-semibold text-gray-900">
                                Recent Job Post
                            </h3>
                            <span class="ml-3 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                <?php echo $totalJobCount ?? '0'; ?>
                            </span>
                        </div>

                        <!-- Right side: Filters -->
                        <div class="flex items-center space-x-4">
                            <!-- Job Status Filter -->
                            <div class="relative">
                                <select class="appearance-none bg-white border border-gray-200 rounded-sm px-4 py-3 pr-12 text-sm text-gray-700 shadow-sm hover:border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all duration-200">
                                    <option value="">Job status</option>
                                    <option value="open">Active</option>
                                    <option value="closed">Closed</option>
                                    <option value="paused">Paused</option>
                                    <option value="draft">Draft</option>
                                </select>
                                <div class="absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>

                            <!-- All Jobs Filter -->
                            <div class="relative">
                                <select class="appearance-none bg-white border border-gray-200 rounded-sm px-4 py-3 pr-12 text-sm text-gray-700 shadow-sm hover:border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all duration-200">
                                    <option value="?page=manage-jobs">All Jobs</option>
                                    <option value="recent">Recent</option>
                                    <option value="popular">Most Popular</option>
                                    <option value="expiring">Expiring Soon</option>
                                </select>
                                <div class="absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Jobs List -->
                <div class="overflow-hidden w-full">
                    <table class="w-full table-fixed divide-y divide-gray-300">
                        <!-- Table Header -->
                        <thead class="bg-primary">
                            <tr>
                                <th scope="col" class="w-3/5 px-6 py-4 text-left text-sm font-medium text-white uppercase tracking-wider">
                                    JOBS
                                </th>
                                <th scope="col" class="w-1/8 px-6 py-4 text-left text-sm font-medium text-white uppercase tracking-wider">
                                    STATUS
                                </th>
                                <th scope="col" class="w-1/8 px-6 py-4 text-left text-sm font-medium text-white uppercase tracking-wider">
                                    APPLICATIONS
                                </th>
                                <th scope="col" class="w-1/5 px-6 py-4 text-left text-sm font-medium text-white uppercase tracking-wider">
                                    ACTIONS
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-300">
                            <?php if (empty($jobs)): ?>
                                <tr>
                                    <td colspan="4" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center">
                                            <div class="flex items-center justify-center w-16 h-16 mx-auto bg-gray-100 rounded-full">
                                                <i class="text-2xl text-gray-400 fas fa-briefcase"></i>
                                            </div>
                                            <h3 class="mt-4 text-lg font-medium text-gray-900">No job posts yet</h3>
                                            <p class="max-w-sm mt-2 text-sm text-gray-500">
                                                Create your first job post to start attracting qualified candidates to your company.
                                            </p>
                                            <div class="mt-6">
                                                <a href="?page=post-job"
                                                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-primary border border-transparent rounded-md shadow-sm hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                                    <i class="mr-2 fas fa-plus"></i>
                                                    Post Your First Job
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php
                                // Use real job data from database
                                foreach ($jobs as $job):
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
                                    <tr class="hover:bg-gray-50">
                                        <!-- Job Info Column -->
                                        <td class="px-6 py-5">
                                            <div>
                                                <div class="text-sm font-medium text-gray-900 mb-1">
                                                    <?php echo htmlspecialchars($job['job_title']); ?>
                                                </div>
                                                <div class="text-xs text-gray-500">
                                                    <?php echo ucfirst(str_replace('_', ' ', $job['job_type'])); ?>
                                                    • <?php echo $daysRemaining > 0 ? $daysRemaining . ' days remaining' : 'Posted ' . date('M j, Y', strtotime($job['created_at'])); ?>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Status Column -->
                                        <td class="px-6 py-5">
                                            <div class="flex items-center">
                                                <?php
                                                // Debug: show the actual job status
                                                // echo "<!-- Debug: job_status = '" . $job['job_status'] . "' -->";

                                                switch (trim($job['job_status'])) {
                                                    case 'open':
                                                        echo '<div class="flex items-center justify-center w-6 h-6 mr-3 border-2 border-green-600 rounded-full">
                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
              </div>';
                                                        echo '<span class="text-sm font-medium text-green-600">Active</span>';
                                                        break;
                                                    case 'closed':
                                                        echo '<div class="flex items-center justify-center w-6 h-6 mr-3 border-2 border-red-600 rounded-full">
                <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
              </div>';
                                                        echo '<span class="text-sm font-medium text-red-600">Closed</span>';
                                                        break;
                                                    case 'draft':
                                                        echo '<div class="flex items-center justify-center w-6 h-6 mr-3 border-2 border-yellow-500 rounded-full">
                <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                </svg>
              </div>';
                                                        echo '<span class="text-sm font-medium text-yellow-500">Draft</span>';
                                                        break;
                                                    default:
                                                        echo '<div class="flex items-center justify-center w-6 h-6 mr-3 border-2 border-gray-400 rounded-full">
                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>';
                                                        echo '<span class="text-sm font-medium text-gray-600">' . ucfirst(trim($job['job_status'])) . '</span>';
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
                                                    class="inline-flex items-center px-6 py-3 text-sm font-medium text-primary bg-gray-100 rounded-sm hover:bg-primary hover:text-white hover:background-primary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors duration-200">
                                                    View Applications
                                                </a>

                                                <!-- Three Dots Menu -->
                                                <div class="relative" x-data="{ open: false }">
                                                    <button @click="open = !open"
                                                        @click.away="open = false"
                                                        class="flex items-center justify-center w-8 h-8 text-gray-400 rounded-full hover:text-gray-600 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors duration-200">
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
                                                        class="absolute right-0 z-10 w-48 mt-2 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5"
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
                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200">
                    <?php if ($totalJobCount > 5): ?>
                        <div class="flex items-center justify-center">
                            <!-- Right side: Pagination controls -->
                            <nav class="flex space-x-1" aria-label="Pagination">
                                <!-- Previous Page -->
                                <?php if ($hasPrevPage): ?>
                                    <a href="?page=dashboard&p=<?php echo $currentPage - 1; ?>"
                                        class="flex items-center justify-center w-8 h-8 text-gray-700 hover:text-gray-900 hover:bg-gray-100 rounded transition-colors duration-200">
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

                                for ($i = $startPage; $i <= $endPage; $i++):
                                ?>
                                    <?php if ($i == $currentPage): ?>
                                        <span class="flex items-center justify-center w-8 h-8 text-sm font-medium text-white bg-primary rounded">
                                            <?php echo sprintf('%02d', $i); ?>
                                        </span>
                                    <?php else: ?>
                                        <a href="?page=dashboard&p=<?php echo $i; ?>"
                                            class="flex items-center justify-center w-8 h-8 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded transition-colors duration-200">
                                            <?php echo sprintf('%02d', $i); ?>
                                        </a>
                                    <?php endif; ?>
                                <?php endfor; ?>

                                <!-- Next Page -->
                                <?php if ($hasNextPage): ?>
                                    <a href="?page=dashboard&p=<?php echo $currentPage + 1; ?>"
                                        class="flex items-center justify-center w-8 h-8 text-gray-700 hover:text-gray-900 hover:bg-gray-100 rounded transition-colors duration-200">
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
                            <div class="text-sm text-gray-700 justify-end">
                                Showing <?php echo (($currentPage - 1) * 5) + 1; ?> to <?php echo min($currentPage * 5, $totalJobCount); ?> of <?php echo $totalJobCount; ?> results
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="text-center text-sm text-gray-500">
                            Showing all <?php echo $totalJobCount; ?> job<?php echo $totalJobCount != 1 ? 's' : ''; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- include_once __DIR__ . '/../components/footer.php'; -->