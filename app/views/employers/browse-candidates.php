<?php
include_once __DIR__ . '/components/employer_auth_check.php';
include_once __DIR__ . '/../components/navbar-top.php';
include_once __DIR__ . '/components/navbar-employer.php';
?>

<div class="px-6 py-8 sm:px-6 md:px-16 lg:px-24">
    <div class="mx-auto max-w-7xl">

        <!-- Page Header
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-mainGray">Browse Candidates</h1>
            <p class="mt-2 text-sm text-gray-600">Review applicants organized by job posts</p>
        </div> -->

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 gap-4 mb-6 sm:gap-6 sm:mb-8 sm:grid-cols-2 md:grid-cols-4">


            <!-- Card 1: Active Job Posts -->
            <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-6">
                <div class="mb-4 sm:mb-6">
                    <h3 class="mb-3 text-sm font-medium text-gray-700 sm:mb-4">Active Job Posts</h3>
                    <div class="flex items-baseline">
                        <span class="text-2xl font-bold text-gray-900 sm:text-3xl"><?php echo count($jobGroups ?? []); ?></span>
                        <svg class="ml-1 sm:ml-2" width="14px" height="14px" viewBox="0 0 20.00 20.00" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000">
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
                        Jobs with applications as of <?php echo date('F j'); ?>
                    </p>
                </div>
            </div>

            <!-- Card 2: Total Applications -->
            <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-6">
                <div class="mb-4 sm:mb-6">
                    <h3 class="mb-3 text-sm font-medium text-gray-700 sm:mb-4">Total Applications</h3>
                    <div class="flex items-baseline">
                        <span class="text-2xl font-bold text-gray-900 sm:text-3xl"><?php echo array_sum(array_map('count', $jobGroups ?? [])); ?></span>
                        <svg class="ml-1 sm:ml-2" width="14px" height="14px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path d="M17.5 18H18.7687C19.2035 18 19.4209 18 19.5817 17.9473C20.1489 17.7612 20.5308 17.1231 20.498 16.4163C20.4887 16.216 20.42 15.9676 20.2825 15.4708C20.168 15.0574 20.1108 14.8507 20.0324 14.6767C19.761 14.0746 19.2766 13.6542 18.7165 13.5346C18.5546 13.5 18.3737 13.5 18.0118 13.5L15.5 13.5346M14.6899 11.6996C15.0858 11.892 15.5303 12 16 12C17.6569 12 19 10.6569 19 9C19 7.34315 17.6569 6 16 6C15.7295 6 15.4674 6.0358 15.2181 6.10291M13.5 8C13.5 10.2091 11.7091 12 9.5 12C7.29086 12 5.5 10.2091 5.5 8C5.5 5.79086 7.29086 4 9.5 4C11.7091 4 13.5 5.79086 13.5 8ZM6.81765 14H12.1824C12.6649 14 12.9061 14 13.1219 14.0461C13.8688 14.2056 14.5147 14.7661 14.8765 15.569C14.9811 15.8009 15.0574 16.0765 15.21 16.6278C15.3933 17.2901 15.485 17.6213 15.4974 17.8884C15.5411 18.8308 15.0318 19.6817 14.2756 19.9297C14.0613 20 13.7714 20 13.1916 20H5.80844C5.22864 20 4.93875 20 4.72441 19.9297C3.96818 19.6817 3.45888 18.8308 3.50261 17.8884C3.51501 17.6213 3.60668 17.2901 3.79003 16.6278C3.94262 16.0765 4.01891 15.8009 4.12346 15.569C4.4853 14.7661 5.13116 14.2056 5.87806 14.0461C6.09387 14 6.33513 14 6.81765 14Z" stroke="#F3AF0E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </g>
                        </svg>
                    </div>
                    <p class="mt-2 text-xs text-gray-500">
                        All candidate applications received
                    </p>
                </div>
            </div>

            <!-- Card 3: Pending Reviews -->
            <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-6">
                <div class="mb-4 sm:mb-6">
                    <h3 class="mb-3 text-sm font-medium text-gray-700 sm:mb-4">Pending Reviews</h3>
                    <div class="flex items-baseline">
                        <span class="text-2xl font-bold text-yellow-600 sm:text-3xl">
                            <?php
                            $pendingCount = 0;
                            foreach ($jobGroups ?? [] as $applicants) {
                                $pendingCount += count(array_filter($applicants, function ($app) {
                                    return $app['application_status'] == 'pending';
                                }));
                            }
                            echo $pendingCount;
                            ?>
                        </span>
                        <svg class="ml-1 sm:ml-2" width="14px" height="14px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path d="M12 8V12L15 15M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="#F59E0B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </g>
                        </svg>
                    </div>
                    <p class="mt-2 text-xs text-gray-500">
                        Applications awaiting your review
                    </p>
                </div>
            </div>

            <!-- Card 4: Accepted Applications -->
            <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-6">
                <div class="mb-4 sm:mb-6">
                    <h3 class="mb-3 text-sm font-medium text-gray-700 sm:mb-4">Accepted Applications</h3>
                    <div class="flex items-baseline">
                        <span class="text-2xl font-bold text-green-600 sm:text-3xl">
                            <?php
                            $acceptedCount = 0;
                            foreach ($jobGroups ?? [] as $applicants) {
                                $acceptedCount += count(array_filter($applicants, function ($app) {
                                    return $app['application_status'] == 'accepted';
                                }));
                            }
                            echo $acceptedCount;
                            ?>
                        </span>
                        <svg class="ml-1 sm:ml-2" width="14px" height="14px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path d="M9 12L11 14L15 10M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="#10B981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </g>
                        </svg>
                    </div>
                    <p class="mt-2 text-xs text-gray-500">
                        Candidates you've accepted
                    </p>
                </div>
            </div>
        </div>

        <!-- Candidates Table -->
        <div class="mb-8 border border-gray-200 rounded-lg">
            <div class="rounded-lg shadow-sm ">
                <div class="w-full">
                    <!-- Table Header with Filters -->
                    <div class="px-4 py-5 sm:px-6">
                        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                            <!-- Left side: Title and Count -->
                            <div class="flex items-center mb-4 lg:mb-0">
                                <h3 class="text-xl font-semibold text-gray-900">All Candidates</h3>
                                <span class="ml-3 mr-3 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    <?php
                                    // Get current filter values
                                    $selectedJob = $_GET['job'] ?? '';
                                    $selectedStatus = $_GET['status'] ?? '';
                                    $selectedDate = $_GET['date'] ?? '';

                                    // Filter applicants based on selections
                                    $filteredCount = 0;
                                    foreach ($jobGroups ?? [] as $jobTitle => $applicants) {
                                        foreach ($applicants as $app) {
                                            $showRow = true;

                                            // Filter by job
                                            if (!empty($selectedJob) && $jobTitle !== $selectedJob) {
                                                $showRow = false;
                                            }

                                            // Filter by status
                                            if (!empty($selectedStatus) && $app['application_status'] !== $selectedStatus) {
                                                $showRow = false;
                                            }

                                            // Filter by date
                                            if (!empty($selectedDate)) {
                                                $appDate = date('Y-m-d', strtotime($app['applied_at']));
                                                if ($appDate !== $selectedDate) {
                                                    $showRow = false;
                                                }
                                            }

                                            if ($showRow) {
                                                $filteredCount++;
                                            }
                                        }
                                    }
                                    echo $filteredCount;
                                    ?>
                                </span>
                            </div>

                            <!-- Right side: Filters -->
                            <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:space-x-4 lg:gap-0"
                                x-data="{ jobOpen: false, statusOpen: false, dateOpen: false }">

                                <!-- Applied For Filter -->
                                <div class="relative">
                                    <button @click="jobOpen = !jobOpen" @click.away="jobOpen = false"
                                        class="appearance-none bg-white border border-gray-200 rounded-sm px-4 py-3 pr-12 text-sm text-gray-700 shadow-sm hover:border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all duration-200 flex items-center justify-between w-full lg:min-w-[240px]">
                                        <span class="flex items-center">
                                            <?php echo !empty($selectedJob) ? htmlspecialchars($selectedJob) : 'Applied For'; ?>
                                        </span>
                                        <svg class="w-4 h-4 ml-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>

                                    <div x-show="jobOpen"
                                        x-transition:enter="transition ease-out duration-100"
                                        x-transition:enter-start="transform opacity-0 scale-95"
                                        x-transition:enter-end="transform opacity-100 scale-100"
                                        x-transition:leave="transition ease-in duration-75"
                                        x-transition:leave-start="transform opacity-100 scale-100"
                                        x-transition:leave-end="transform opacity-0 scale-95"
                                        class="absolute left-0 z-50 w-full mt-1 bg-white border border-gray-200 rounded-lg shadow-lg lg:w-64 lg:right-0 lg:left-auto ring-1 ring-black ring-opacity-5"
                                        x-cloak>
                                        <div class="p-2">
                                            <a href="?<?php echo http_build_query(array_merge($_GET, ['job' => ''])); ?>"
                                                class="block w-full px-3 py-2 text-sm text-left text-gray-700 rounded-md hover:bg-gray-100 <?php echo empty($selectedJob) ? 'bg-primary text-white' : ''; ?>">
                                                All Jobs
                                                <span class="float-right text-xs text-gray-500">
                                                    <?php echo array_sum(array_map('count', $jobGroups ?? [])); ?>
                                                </span>
                                            </a>
                                            <?php foreach ($jobGroups ?? [] as $jobTitle => $applicants): ?>
                                                <a href="?<?php echo http_build_query(array_merge($_GET, ['job' => $jobTitle])); ?>"
                                                    class="block w-full px-3 py-2 text-sm text-left text-gray-700 rounded-md hover:bg-gray-100 <?php echo $selectedJob === $jobTitle ? 'bg-primary text-white' : ''; ?>">
                                                    <?php echo htmlspecialchars($jobTitle); ?>
                                                    <span class="float-right text-xs text-gray-500">
                                                        <?php echo count($applicants); ?>
                                                    </span>
                                                </a>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- Status Filter -->
                                <div class="relative">
                                    <button @click="statusOpen = !statusOpen" @click.away="statusOpen = false"
                                        class="appearance-none bg-white border border-gray-200 rounded-sm px-4 py-3 pr-12 text-sm text-gray-700 shadow-sm hover:border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all duration-200 flex items-center justify-between w-full lg:min-w-[140px]">
                                        <span class="flex items-center">
                                            <?php
                                            switch ($selectedStatus) {
                                                case 'pending':
                                                    echo '<svg class="w-4 h-4 mr-2 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="m12 6 0 6 4 2"/></svg>';
                                                    echo 'Pending';
                                                    break;
                                                case 'accepted':
                                                    echo '<svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>';
                                                    echo 'Accepted';
                                                    break;
                                                case 'rejected':
                                                    echo '<svg class="w-4 h-4 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/></svg>';
                                                    echo 'Rejected';
                                                    break;
                                                case 'shortlisted':
                                                    echo '<svg class="w-4 h-4 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/></svg>';
                                                    echo 'Shortlisted';
                                                    break;
                                                default:
                                                    echo 'All Status';
                                            }
                                            ?>
                                        </span>
                                        <svg class="w-4 h-4 ml-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>

                                    <div x-show="statusOpen"
                                        x-transition:enter="transition ease-out duration-100"
                                        x-transition:enter-start="transform opacity-0 scale-95"
                                        x-transition:enter-end="transform opacity-100 scale-100"
                                        x-transition:leave="transition ease-in duration-75"
                                        x-transition:leave-start="transform opacity-100 scale-100"
                                        x-transition:leave-end="transform opacity-0 scale-95"
                                        class="absolute left-0 z-50 w-full mt-1 bg-white border border-gray-200 rounded-lg shadow-lg lg:w-48 lg:right-0 lg:left-auto ring-1 ring-black ring-opacity-5"
                                        x-cloak>
                                        <div class="p-2">
                                            <a href="?<?php echo http_build_query(array_merge($_GET, ['status' => ''])); ?>"
                                                class="flex items-center w-full px-3 py-2 text-sm text-gray-700 rounded-md hover:bg-gray-100 <?php echo empty($selectedStatus) ? 'bg-primary text-white' : ''; ?>">
                                                All Status
                                            </a>
                                            <a href="?<?php echo http_build_query(array_merge($_GET, ['status' => 'pending'])); ?>"
                                                class="flex items-center w-full px-3 py-2 text-sm text-gray-700 rounded-md hover:bg-gray-100 <?php echo $selectedStatus === 'pending' ? 'bg-primary text-white' : ''; ?>">
                                                <svg class="w-4 h-4 mr-2 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <circle cx="12" cy="12" r="10" />
                                                    <path d="m12 6 0 6 4 2" />
                                                </svg>
                                                Pending
                                            </a>
                                            <a href="?<?php echo http_build_query(array_merge($_GET, ['status' => 'accepted'])); ?>"
                                                class="flex items-center w-full px-3 py-2 text-sm text-gray-700 rounded-md hover:bg-gray-100 <?php echo $selectedStatus === 'accepted' ? 'bg-primary text-white' : ''; ?>">
                                                <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <circle cx="12" cy="12" r="10" />
                                                    <path d="m9 12 2 2 4-4" />
                                                </svg>
                                                Accepted
                                            </a>
                                            <a href="?<?php echo http_build_query(array_merge($_GET, ['status' => 'rejected'])); ?>"
                                                class="flex items-center w-full px-3 py-2 text-sm text-gray-700 rounded-md hover:bg-gray-100 <?php echo $selectedStatus === 'rejected' ? 'bg-primary text-white' : ''; ?>">
                                                <svg class="w-4 h-4 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <circle cx="12" cy="12" r="10" />
                                                    <path d="m15 9-6 6" />
                                                    <path d="m9 9 6 6" />
                                                </svg>
                                                Rejected
                                            </a>
                                            <a href="?<?php echo http_build_query(array_merge($_GET, ['status' => 'shortlisted'])); ?>"
                                                class="flex items-center w-full px-3 py-2 text-sm text-gray-700 rounded-md hover:bg-gray-100 <?php echo $selectedStatus === 'shortlisted' ? 'bg-primary text-white' : ''; ?>">
                                                <svg class="w-4 h-4 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26" />
                                                </svg>
                                                Shortlisted
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Applied Date Filter -->
                                <div class="relative">
                                    <input type="date"
                                        value="<?php echo htmlspecialchars($selectedDate); ?>"
                                        onchange="window.location.href = '?' + new URLSearchParams({...Object.fromEntries(new URLSearchParams(window.location.search)), date: this.value}).toString()"
                                        class="w-full px-4 py-3 text-sm transition-all duration-200 border border-gray-200 rounded-sm lg:w-auto focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
                                </div>
                                <!-- Clear Filters Button -->
                                <?php if (!empty($_GET['job']) || !empty($_GET['status']) || !empty($_GET['date'])): ?>
                                    <button onclick="clearFilters()"
                                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-600 transition-all duration-200 bg-gray-100 rounded-sm hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Clear Filters
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <?php if (empty($jobGroups)): ?>
                        <div class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center">
                                <div class="flex items-center justify-center w-16 h-16 mx-auto bg-gray-100 rounded-full">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <h3 class="mt-4 text-lg font-medium text-gray-900">No Applications Yet</h3>
                                <p class="max-w-sm mt-2 text-sm text-gray-500">
                                    Applications will appear here once candidates apply to your job posts.
                                </p>
                            </div>
                        </div>
                    <?php else: ?>
                        <!-- Desktop Table View (Hidden on Mobile) -->
                        <div class="hidden w-full overflow-visible lg:block">
                            <table class="w-full divide-y divide-gray-300 table-fixed ">
                                <!-- Table Header -->
                                <thead class="bg-primary">
                                    <tr>
                                        <th scope="col" class="w-2/5 px-6 py-4 text-sm font-medium tracking-wider text-left text-white uppercase">
                                            CANDIDATE
                                        </th>
                                        <th scope="col" class="w-1/5 px-6 py-4 text-sm font-medium tracking-wider text-left text-white uppercase">
                                            APPLIED FOR
                                        </th>
                                        <th scope="col" class="px-6 py-4 text-sm font-medium tracking-wider text-left text-white uppercase w-1/8">
                                            STATUS
                                        </th>
                                        <th scope="col" class="px-6 py-4 text-sm font-medium tracking-wider text-left text-white uppercase w-1/8">
                                            APPLIED DATE
                                        </th>
                                        <th scope="col" class="w-1/5 px-6 py-4 text-sm font-medium tracking-wider text-left text-white uppercase">
                                            ACTIONS
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-300 ">
                                    <?php
                                    // Get current filter values and process applicants
                                    $allApplicants = [];
                                    foreach ($jobGroups as $jobTitle => $applicants) {
                                        foreach ($applicants as $app) {
                                            $app['job_title'] = $jobTitle;

                                            // Apply filtering logic
                                            $showRow = true;

                                            // Filter by job
                                            if (!empty($selectedJob) && $jobTitle !== $selectedJob) {
                                                $showRow = false;
                                            }

                                            // Filter by status
                                            if (!empty($selectedStatus) && $app['application_status'] !== $selectedStatus) {
                                                $showRow = false;
                                            }

                                            // Filter by date
                                            if (!empty($selectedDate)) {
                                                $appDate = date('Y-m-d', strtotime($app['applied_at']));
                                                if ($appDate !== $selectedDate) {
                                                    $showRow = false;
                                                }
                                            }

                                            if ($showRow) {
                                                $allApplicants[] = $app;
                                            }
                                        }
                                    }

                                    // Sort by applied date (newest first)
                                    usort($allApplicants, function ($a, $b) {
                                        return strtotime($b['applied_at']) - strtotime($a['applied_at']);
                                    });

                                    if (empty($allApplicants)):
                                    ?>
                                        <tr>
                                            <td colspan="5" class="px-6 py-16 text-center">
                                                <div class="flex flex-col items-center">
                                                    <div class="flex items-center justify-center w-16 h-16 mx-auto bg-gray-100 rounded-full">
                                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                                        </svg>
                                                    </div>
                                                    <h3 class="mt-4 text-lg font-medium text-gray-900">No candidates found</h3>
                                                    <p class="max-w-sm mt-2 text-sm text-gray-500">
                                                        Try adjusting your filters to see more results.
                                                    </p>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($allApplicants as $app): ?>
                                            <tr class="border-t border-gray-200 hover:bg-gray-100">
                                                <!-- Candidate Info Column -->
                                                <td class="px-6 py-5">
                                                    <div class="flex items-center">
                                                        <?php if (!empty($app['profile_picture'])): ?>
                                                            <img src="<?php echo htmlspecialchars($app['profile_picture']); ?>" alt="Profile" class="object-cover w-12 h-12 mr-4 border border-gray-200 rounded-md">
                                                        <?php else: ?>
                                                            <div class="flex items-center justify-center w-10 h-10 mr-4 bg-gray-100 rounded-full">
                                                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                                </svg>
                                                            </div>
                                                        <?php endif; ?>
                                                        <div>
                                                            <div class="text-sm font-medium text-gray-900">
                                                                <?php echo htmlspecialchars($app['first_name'] . ' ' . $app['last_name']); ?>
                                                            </div>
                                                            <div class="text-xs text-gray-500">
                                                                <?php echo htmlspecialchars($app['email'] ?? ''); ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>

                                                <!-- Job Applied For Column -->
                                                <td class="px-6 py-5">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        <?php echo htmlspecialchars($app['job_title']); ?>
                                                    </div>
                                                </td>

                                                <!-- Status Column -->
                                                <td class="px-6 py-5">
                                                    <div class="flex items-center">
                                                        <?php
                                                        switch ($app['application_status']) {
                                                            case 'pending':
                                                                echo '<div class="flex items-center justify-center w-6 h-6 mr-3 border-2 border-yellow-500 rounded-full">
                                                                        <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                        </svg>
                                                                    </div>';
                                                                echo '<span class="text-sm font-medium text-yellow-600">Pending</span>';
                                                                break;
                                                            case 'accepted':
                                                                echo '<div class="flex items-center justify-center w-6 h-6 mr-3 border-2 border-green-600 rounded-full">
                                                                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                                        </svg>
                                                                    </div>';
                                                                echo '<span class="text-sm font-medium text-green-600">Accepted</span>';
                                                                break;
                                                            case 'rejected':
                                                                echo '<div class="flex items-center justify-center w-6 h-6 mr-3 border-2 border-red-600 rounded-full">
                                                                        <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                                        </svg>
                                                                    </div>';
                                                                echo '<span class="text-sm font-medium text-red-600">Rejected</span>';
                                                                break;
                                                            default:
                                                                echo '<div class="flex items-center justify-center w-6 h-6 mr-3 border-2 border-gray-400 rounded-full">
                                                                        <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                        </svg>
                                                                    </div>';
                                                                echo '<span class="text-sm font-medium text-gray-600">' . ucfirst($app['application_status']) . '</span>';
                                                        }
                                                        ?>
                                                    </div>
                                                </td>

                                                <!-- Applied Date Column -->
                                                <td class="px-6 py-5">
                                                    <div class="text-sm text-gray-900"><?php echo date('M j, Y', strtotime($app['applied_at'])); ?></div>
                                                    <div class="text-xs text-gray-500"><?php echo date('g:i A', strtotime($app['applied_at'])); ?></div>
                                                </td>

                                                <!-- Actions Column -->
                                                <td class="px-6 py-5">
                                                    <div class="flex items-center space-x-3">
                                                        <!-- Review Application Button -->
                                                        <a href="?page=review-application&application_id=<?php echo $app['application_id']; ?>"
                                                            class="inline-flex items-center px-4 py-2 text-sm font-medium transition-colors duration-200 bg-gray-100 rounded-sm text-primary hover:bg-primary hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                            </svg>
                                                            Review
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
                                                                    <?php if ($app['application_status'] == 'pending'): ?>
                                                                        <a href="?page=accept-application&application_id=<?php echo $app['application_id']; ?>"
                                                                            class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                                            <i class="mr-3 text-green-400 fas fa-check"></i>
                                                                            Accept Application
                                                                        </a>
                                                                        <a href="?page=reject-application&application_id=<?php echo $app['application_id']; ?>"
                                                                            class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                                            <i class="mr-3 text-red-400 fas fa-times"></i>
                                                                            Reject Application
                                                                        </a>
                                                                    <?php endif; ?>
                                                                    <a href="?page=view-candidate&candidate_id=<?php echo $app['jobseeker_id']; ?>"
                                                                        class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                                        <i class="mr-3 text-blue-400 fas fa-user"></i>
                                                                        View Profile
                                                                    </a>
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
                        <div class="space-y-4 lg:hidden">
                            <?php
                            if (empty($allApplicants)):
                            ?>
                                <div class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="flex items-center justify-center mx-auto">
                                            <svg class="w-8 h-8 py-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                            </svg>
                                        </div>
                                        <h3 class="mt-4 text-lg font-medium text-gray-900">No candidates found</h3>
                                        <p class="max-w-sm mt-2 text-sm text-gray-500">
                                            Try adjusting your filters to see more results.
                                        </p>
                                    </div>
                                </div>
                            <?php else: ?>
                                <?php foreach ($allApplicants as $app): ?>
                                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                                        <!-- Card Header -->
                                        <div class="flex items-start justify-between p-4 pb-2">
                                            <div class="flex items-center flex-1">
                                                <!-- Profile Picture -->
                                                <?php if (!empty($app['profile_picture'])): ?>
                                                    <img src="<?php echo htmlspecialchars($app['profile_picture']); ?>" alt="Profile" class="object-cover w-12 h-12 mr-3 border border-gray-200 rounded-md">
                                                <?php else: ?>
                                                    <div class="flex items-center justify-center w-12 h-12 mr-3 bg-gray-100 rounded-full">
                                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                        </svg>
                                                    </div>
                                                <?php endif; ?>

                                                <div class="flex-1">
                                                    <h3 class="text-lg font-semibold leading-tight text-gray-900">
                                                        <?php echo htmlspecialchars($app['first_name'] . ' ' . $app['last_name']); ?>
                                                    </h3>
                                                    <p class="mt-1 text-sm text-gray-600">
                                                        <?php echo htmlspecialchars($app['email'] ?? ''); ?>
                                                    </p>
                                                </div>
                                            </div>

                                            <!-- Status Badge -->
                                            <div class="flex-shrink-0 ml-4">
                                                <?php
                                                $statusStyles = [
                                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                                    'accepted' => 'bg-green-100 text-green-800',
                                                    'rejected' => 'bg-red-100 text-red-800',
                                                    'shortlisted' => 'bg-purple-100 text-purple-800'
                                                ];

                                                $statusLabels = [
                                                    'pending' => 'Pending',
                                                    'accepted' => 'Accepted',
                                                    'rejected' => 'Rejected',
                                                    'shortlisted' => 'Shortlisted'
                                                ];

                                                $statusClass = $statusStyles[$app['application_status']] ?? 'bg-gray-100 text-gray-800';
                                                $statusLabel = $statusLabels[$app['application_status']] ?? ucfirst($app['application_status']);
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
                                                    x-cloak>
                                                    <div class="py-1">
                                                        <?php if ($app['application_status'] == 'pending'): ?>
                                                            <a href="?page=accept-application&application_id=<?php echo $app['application_id']; ?>"
                                                                class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                                <i class="mr-3 text-green-400 fas fa-check"></i>
                                                                Accept Application
                                                            </a>
                                                            <a href="?page=reject-application&application_id=<?php echo $app['application_id']; ?>"
                                                                class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                                <i class="mr-3 text-red-400 fas fa-times"></i>
                                                                Reject Application
                                                            </a>
                                                        <?php endif; ?>
                                                        <a href="?page=view-candidate&candidate_id=<?php echo $app['jobseeker_id']; ?>"
                                                            class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                            <i class="mr-3 text-blue-400 fas fa-user"></i>
                                                            View Profile
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Card Body -->
                                        <div class="px-4 py-4">
                                            <!-- Job Applied For -->
                                            <div class="mb-3">
                                                <span class="text-sm font-medium text-gray-700">Applied for:</span>
                                                <span class="ml-1 text-sm text-gray-900"><?php echo htmlspecialchars($app['job_title']); ?></span>
                                            </div>

                                            <!-- Applied Date -->
                                            <div class="mb-4 text-sm text-gray-500">
                                                Applied: <?php echo date('M j, Y - g:i A', strtotime($app['applied_at'])); ?>
                                            </div>

                                            <!-- Action Buttons -->
                                            <div class="flex gap-2">
                                                <!-- Review Application Button -->
                                                <a href="?page=review-application&application_id=<?php echo $app['application_id']; ?>"
                                                    class="flex-1 px-4 py-2 text-sm font-medium text-center text-white transition-colors duration-200 rounded-sm bg-primary hover:bg-secondary">
                                                    Review Application
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Alpine.js -->
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

<div x-show="jobOpen"
    x-transition:enter="transition ease-out duration-100"
    x-transition:enter-start="transform opacity-0 scale-95"
    x-transition:enter-end="transform opacity-100 scale-100"
    x-transition:leave="transition ease-in duration-75"
    x-transition:leave-start="transform opacity-100 scale-100"
    x-transition:leave-end="transform opacity-0 scale-95"
    class="absolute left-0 z-50 w-64 mt-1 bg-white border border-gray-200 rounded-lg shadow-lg"
    style="display: none;">
    <div class="p-2">
        <a href="?<?php echo http_build_query(array_merge($_GET, ['job' => ''])); ?>"
            class="block w-full px-3 py-2 text-sm text-left text-gray-700 rounded-md hover:bg-gray-100 <?php echo empty($selectedJob) ? 'bg-primary text-white' : ''; ?>">
            All Jobs
            <span class="float-right text-xs text-gray-500">
                <?php echo array_sum(array_map('count', $jobGroups ?? [])); ?>
            </span>
        </a>
        <?php foreach ($jobGroups ?? [] as $jobTitle => $applicants): ?>
            <a href="?<?php echo http_build_query(array_merge($_GET, ['job' => $jobTitle])); ?>"
                class="block w-full px-3 py-2 text-sm text-left text-gray-700 rounded-md hover:bg-gray-100 <?php echo $selectedJob === $jobTitle ? 'bg-primary text-white' : ''; ?>">
                <?php echo htmlspecialchars($jobTitle); ?>
                <span class="float-right text-xs text-gray-500">
                    <?php echo count($applicants); ?>
                </span>
            </a>
        <?php endforeach; ?>
    </div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>

<script>
    function clearFilters() {
        // Construct URL with only the page parameter, removing all filters
        const baseUrl = window.location.pathname + '?page=browse-candidates';
        window.location.href = baseUrl;
    }
</script>

<!-- Alpine.js -->
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>