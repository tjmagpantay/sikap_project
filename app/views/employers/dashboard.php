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
        <div class="mb-8 border rounded-lg border-gray-30">
            <div class="bg-white rounded-lg shadow">
                <div class="flex flex-col px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <!-- Left side: Title and Count -->
                        <div class="flex items-center">
                            <h3 class="text-lg font-medium text-gray-900">
                                Recent Job Post
                            </h3>
                            <span class="ml-2 px-2.5 py-0.5 rounded-sm text-xs font-medium bg-gray-100 text-gray-800">
                                <?php echo $totalJobPosts; ?>
                            </span>
                        </div>

                        <!-- Right side: Filters -->
                        <div class="flex items-center gap-3 space-x-3">
                            <!-- Job Status Filter -->
                            <div class="relative">
                                <div class="flex items-center px-4 py-3 text-sm text-gray-700 bg-white border border-gray-300 rounded-sm shadow-sm focus-within:ring-2 focus-within:ring-blue-500 focus-within:border-blue-500">
                                    <!-- Left icon -->
                                    <svg class="w-5 h-5 mr-2 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>

                                    <!-- Select element covering entire area -->
                                    <select class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                        <option value="">Job status</option>
                                        <option value="open">Active</option>
                                        <option value="closed">Closed</option>
                                        <option value="paused">Paused</option>
                                        <option value="draft">Draft</option>
                                    </select>

                                    <!-- Visible text -->
                                    <span class="flex-1 pointer-events-none">Job status</span>

                                    <!-- Right dropdown icon -->
                                    <svg class="w-4 h-4 ml-2 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>

                            <!-- All Jobs Filter -->
                            <div class="relative">
                                <div class="flex items-center px-4 py-3 text-sm text-gray-700 bg-white border border-gray-300 rounded-sm shadow-sm focus-within:ring-2 focus-within:ring-blue-500 focus-within:border-blue-500">
                                    <!-- Select element covering entire area -->
                                    <select class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                        <option value="?page=manage-jobs">All Jobs</option>
                                        <option value="recent">Recent</option>
                                        <option value="popular">Most Popular</option>
                                        <option value="expiring">Expiring Soon</option>
                                    </select>

                                    <!-- Visible text -->
                                    <span class="flex-1 pointer-events-none">All Jobs</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Jobs List -->
                <div class="w-full overflow-hidden">
                    <div class="w-full overflow-x-auto">
                        <table class="w-full divide-y divide-gray-200 table-fixed">
                            <!-- Table Header -->
                            <thead class="bg-primary">
                                <tr>
                                    <th scope="col" class="w-2/5 px-6 py-4 text-xs font-semibold tracking-wider text-left text-white uppercase">
                                        JOBS
                                    </th>
                                    <th scope="col" class="w-1/6 px-6 py-4 text-xs font-semibold tracking-wider text-left text-white uppercase">
                                        STATUS
                                    </th>
                                    <th scope="col" class="w-1/6 px-6 py-4 text-xs font-semibold tracking-wider text-left text-white uppercase">
                                        APPLICATIONS
                                    </th>
                                    <th scope="col" class="w-1/4 px-6 py-4 text-xs font-semibold tracking-wider text-left text-white uppercase">
                                        ACTIONS
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
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
                                                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                        <i class="mr-2 fas fa-plus"></i>
                                                        Post Your First Job
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php
                                    // Show only the first 5 recent jobs
                                    $jobPosts = array_slice($jobs, 0, 5);
                                    foreach ($jobPosts as $job):
                                    ?>
                                        <tr class="hover:bg-gray-50">
                                            <!-- Job Info Column -->
                                            <td class="px-6 py-4 align-top">
                                                <div>
                                                    <div class="text-sm font-semibold text-gray-900">
                                                        <?php echo htmlspecialchars($job['job_title']); ?>
                                                    </div>
                                                    <div class="text-xs text-gray-500">
                                                        <?php echo ucfirst(str_replace('-', ' ', $job['job_type'])); ?>
                                                        • Posted <?php echo date('M j, Y', strtotime($job['created_at'])); ?>
                                                    </div>
                                                </div>
                                            </td>

                                            <!-- Status Column -->
                                            <td class="px-6 py-4 align-top">
                                                <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full
                                                    <?php
                                                    switch ($job['job_status']) {
                                                        case 'open':
                                                            echo 'text-green-800 bg-green-100';
                                                            $statusText = 'Active';
                                                            break;
                                                        case 'closed':
                                                            echo 'text-red-800 bg-red-100';
                                                            $statusText = 'Expire';
                                                            break;
                                                        case 'draft':
                                                            echo 'text-yellow-800 bg-yellow-100';
                                                            $statusText = 'Draft';
                                                            break;
                                                        case 'paused':
                                                            echo 'text-orange-800 bg-orange-100';
                                                            $statusText = 'Paused';
                                                            break;
                                                        default:
                                                            echo 'text-gray-800 bg-gray-100';
                                                            $statusText = ucfirst($job['job_status']);
                                                    }
                                                    ?>">
                                                    <svg class="w-2 h-2 mr-1 fill-current" viewBox="0 0 8 8">
                                                        <circle cx="4" cy="4" r="3" />
                                                    </svg>
                                                    <?php echo $statusText; ?>
                                                </span>
                                            </td>

                                            <!-- Applications Column -->
                                            <td class="px-6 py-4 align-top">
                                                <div class="flex items-center text-sm text-gray-900">
                                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                                    </svg>
                                                    <?php echo $job['application_count']; ?> Applications
                                                </div>
                                            </td>

                                            <!-- Actions Column -->
                                            <td class="px-6 py-4 align-top">
                                                <div class="flex items-center space-x-2">
                                                    <!-- View Applications Button -->
                                                    <a href="?page=job-applications&job_id=<?php echo $job['job_id']; ?>"
                                                        class="inline-flex items-center px-3 py-2 text-xs font-medium text-white bg-blue-900 border border-transparent rounded-md hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                        View Applications
                                                    </a>

                                                    <!-- Three Dots Menu -->
                                                    <div class="relative" x-data="{ open: false }">
                                                        <button @click="open = !open"
                                                            @click.away="open = false"
                                                            class="flex items-center justify-center w-8 h-8 text-gray-400 rounded-full hover:text-gray-600 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
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
                                                                <a href="?page=view-employer-job&id=<?php echo $job['job_id']; ?>"
                                                                    class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                                    <i class="mr-3 text-blue-400 fas fa-eye"></i>
                                                                    View Job
                                                                </a>
                                                                <a href="?page=edit-job&id=<?php echo $job['job_id']; ?>"
                                                                    class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                                    <i class="mr-3 text-yellow-400 fas fa-edit"></i>
                                                                    Edit Job
                                                                </a>
                                                                <?php if ($job['job_status'] == 'open'): ?>
                                                                    <a href="?page=toggle-job-status&id=<?php echo $job['job_id']; ?>&status=paused"
                                                                        class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                                        <i class="mr-3 text-orange-400 fas fa-pause"></i>
                                                                        Pause Job
                                                                    </a>
                                                                <?php elseif ($job['job_status'] == 'paused'): ?>
                                                                    <a href="?page=toggle-job-status&id=<?php echo $job['job_id']; ?>&status=open"
                                                                        class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                                        <i class="mr-3 text-green-400 fas fa-play"></i>
                                                                        Resume Job
                                                                    </a>
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
                </div>
            </div>
        </div>
    </div>
</div>


<!-- include_once __DIR__ . '/../components/footer.php'; -->