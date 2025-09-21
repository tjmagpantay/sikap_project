<?php
// Remove the auth check since dashboard.php already handles it
// include_once __DIR__ . '/components/admin_auth_check.php'; 
?>

<!-- Remove ALL HTML structure - make it content-only like main-board.php -->
<div class="space-y-6">
    <!-- Header Section -->
    <div class="mb-6">
        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Job Post Management</h1>
                <p class="mt-1 text-sm text-gray-600">Monitor and manage all job postings in the system</p>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    <?php if (!empty($error)): ?>
        <div class="p-4 mb-4 text-red-700 border border-red-200 rounded-lg bg-red-50">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <div class="p-4 mb-4 text-green-700 border border-green-200 rounded-lg bg-green-50">
            <?php echo htmlspecialchars($success); ?>
        </div>
    <?php endif; ?>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 gap-4 mb-6 sm:gap-4 sm:mb-8 md:grid-cols-6">
        <!-- Card 1: Total Jobs -->
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-6">
            <div>
                <h3 class="mb-3 text-sm font-medium text-gray-700 sm:mb-4">Total Jobs</h3>
                <div class="flex items-baseline">
                    <span class="text-2xl font-bold text-gray-900 sm:text-3xl" data-stat="total"><?php echo $stats['total'] ?? 0; ?></span>
                    <svg class="ml-1 sm:ml-2" width="14px" height="14px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" stroke="#16a34a" />
                    </svg>
                </div>
                <p class="mt-2 text-xs text-gray-500">
                    All job postings in the system
                </p>
            </div>
        </div>

        <!-- Card 2: Open Jobs -->
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-6">
            <div>
                <h3 class="mb-3 text-sm font-medium text-gray-700 sm:mb-4">Open Jobs</h3>
                <div class="flex items-baseline">
                    <span class="text-2xl font-bold text-gray-900 sm:text-3xl" data-stat="open"><?php echo $stats['open'] ?? 0; ?></span>
                    <svg class="ml-1 sm:ml-2" width="14px" height="14px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" stroke="#16a34a" />
                    </svg>
                </div>
                <p class="mt-2 text-xs text-gray-500">
                    Currently accepting applications
                </p>
            </div>
        </div>

        <!-- Card 3: Paused Jobs -->
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-6">
            <div>
                <h3 class="mb-3 text-sm font-medium text-gray-700 sm:mb-4">Paused</h3>
                <div class="flex items-baseline">
                    <span class="text-2xl font-bold text-gray-900 sm:text-3xl" data-stat="paused"><?php echo $stats['paused'] ?? 0; ?></span>
                    <svg class="ml-1 sm:ml-2" width="14px" height="14px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.864-.833-2.634 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" stroke="#f59e0b" />
                    </svg>
                </div>
                <p class="mt-2 text-xs text-gray-500">
                    Temporarily suspended jobs
                </p>
            </div>
        </div>

        <!-- Card 4: Draft Jobs -->
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-6">
            <div>
                <h3 class="mb-3 text-sm font-medium text-gray-700 sm:mb-4">Drafts</h3>
                <div class="flex items-baseline">
                    <span class="text-2xl font-bold text-gray-900 sm:text-3xl" data-stat="draft"><?php echo $stats['draft'] ?? 0; ?></span>
                    <svg class="ml-1 sm:ml-2" width="14px" height="14px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" stroke="#6b7280" />
                    </svg>
                </div>
                <p class="mt-2 text-xs text-gray-500">
                    Unpublished job drafts
                </p>
            </div>
        </div>

        <!-- Card 5: Closed Jobs -->
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-6">
            <div>
                <h3 class="mb-3 text-sm font-medium text-gray-700 sm:mb-4">Closed</h3>
                <div class="flex items-baseline">
                    <span class="text-2xl font-bold text-gray-900 sm:text-3xl" data-stat="closed"><?php echo $stats['closed'] ?? 0; ?></span>
                    <svg class="ml-1 sm:ml-2" width="14px" height="14px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" stroke="#dc2626" />
                    </svg>
                </div>
                <p class="mt-2 text-xs text-gray-500">
                    Expired or closed jobs
                </p>
            </div>
        </div>

        <!-- Card 6: Employers -->
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-6">
            <div>
                <h3 class="mb-3 text-sm font-medium text-gray-700 sm:mb-4">Employers</h3>
                <div class="flex items-baseline">
                    <span class="text-2xl font-bold text-gray-900 sm:text-3xl" data-stat="employers"><?php echo $stats['employers'] ?? 0; ?></span>
                    <svg class="ml-1 sm:ml-2" width="14px" height="14px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" stroke="#dc2626" />
                    </svg>
                </div>
                <p class="mt-2 text-xs text-gray-500">
                    Employers with job postings
                </p>
            </div>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="relative w-full py-4 rounded-xl">
        <div class="flex flex-col w-full gap-6 mx-auto">
            <div class="flex flex-wrap items-center w-full gap-x-4 gap-y-2">
                <!-- Search Jobs -->
                <div class="flex-1 min-w-[200px] max-w-xs">
                    <div class="relative">
                        <input type="text" id="searchInput" placeholder="Search by title, company, category..."
                            class="w-full px-4 py-3 pr-12 text-sm transition-all duration-200 bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary"
                            value="<?php echo htmlspecialchars($searchQuery ?? ''); ?>">
                        <svg class="absolute w-5 h-5 text-gray-400 transform -translate-y-1/2 pointer-events-none right-4 top-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Status Filter -->
                <div class="flex-1 min-w-[120px] max-w-xs" x-data="{ open: false, selected: '<?php echo ucfirst($statusFilter ?? 'Status'); ?>' }">
                    <button @click="open = !open" @click.away="open = false"
                        class="flex items-center justify-between w-full px-4 py-3 pr-6 text-sm text-gray-700 transition-all duration-200 bg-white border border-gray-300 rounded-lg shadow-sm appearance-none hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
                        <span x-text="selected"></span>
                        <svg class="w-4 h-4 ml-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <!-- Dropdown Menu -->
                    <div x-show="open" x-transition class="absolute left-0 z-50 w-full mt-2 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5" x-cloak>
                        <div class="py-1">
                            <button @click="selected = 'Status'; open = false; filterByStatus('')" class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">All Status</button>
                            <button @click="selected = 'Open'; open = false; filterByStatus('open')" class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Open</button>
                            <button @click="selected = 'Paused'; open = false; filterByStatus('paused')" class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Paused</button>
                            <button @click="selected = 'Closed'; open = false; filterByStatus('closed')" class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Closed</button>
                            <button @click="selected = 'Draft'; open = false; filterByStatus('draft')" class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Draft</button>
                        </div>
                    </div>
                </div>

                <!-- Date Filter -->
                <div class="flex-1 min-w-[140px] max-w-xs" x-data="{ open: false, selected: 'Date Range' }">
                    <button @click="open = !open" @click.away="open = false"
                        class="flex items-center justify-between w-full px-4 py-3 pr-12 text-sm text-gray-700 transition-all duration-200 bg-white border border-gray-300 rounded-lg shadow-sm appearance-none hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
                        <span x-text="selected"></span>
                        <svg class="w-4 h-4 ml-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="open" x-transition class="absolute left-0 z-50 w-full mt-2 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5" x-cloak>
                        <div class="py-1">
                            <button @click="selected = 'Date Range'; open = false; filterByDate('')" class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">All Dates</button>
                            <button @click="selected = 'Today'; open = false; filterByDate('today')" class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Today</button>
                            <button @click="selected = 'This Week'; open = false; filterByDate('week')" class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">This Week</button>
                            <button @click="selected = 'This Month'; open = false; filterByDate('month')" class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">This Month</button>
                            <button @click="selected = 'This Year'; open = false; filterByDate('year')" class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">This Year</button>
                        </div>
                    </div>
                </div>

                <!-- Filter/Clear Buttons -->
                <div class="flex flex-shrink-0 gap-2 mt-2 lg:mt-0">
                    <button onclick="clearAllFilters()"
                        class="px-4 py-3 text-sm font-medium text-gray-600 transition-colors duration-200 bg-gray-100 border border-gray-300 rounded-sm hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        Clear
                    </button>
                    <button onclick="exportResults('csv')"
                        class="px-4 py-3 text-sm font-medium text-white transition-colors duration-200 border rounded-sm bg-primary border-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        Export
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- All Jobs -->
    <div>
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold text-gray-900">All Jobs</h2>
            <div class="flex items-center space-x-2">
                <span class="px-3 py-1 text-sm bg-blue-100 rounded-sm text-primary" id="visibleCount">
                    <?php echo count($jobs ?? []); ?> visible
                </span>
            </div>
        </div>

        <?php if (empty($jobs ?? [])): ?>
            <div class="p-8 text-center bg-white border border-gray-200 rounded-lg" id="noJobsMessage">
                <i class="mb-4 text-4xl text-gray-400 fas fa-briefcase"></i>
                <p class="text-gray-500">No jobs found</p>
            </div>
        <?php else: ?>
            <!-- No Results Message (Hidden by default) -->
            <div class="hidden p-8 text-center bg-white border border-gray-200 rounded-lg" id="noResultsMessage">
                <i class="mb-4 text-4xl text-gray-400 fas fa-search"></i>
                <p class="text-gray-500">No jobs match your search criteria</p>
            </div>

            <!-- Jobs Table -->
            <div class="overflow-hidden bg-white border border-gray-200 rounded-lg shadow-sm" id="jobsTable">
                <div class="overflow-x-auto">
                    <table class="w-full divide-y divide-gray-200 table-auto">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase cursor-pointer hover:bg-gray-100" onclick="sortTable(0)">
                                    Job Title
                                    <i class="ml-1 text-gray-400 fas fa-sort"></i>
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase cursor-pointer hover:bg-gray-100" onclick="sortTable(1)">
                                    Company
                                    <i class="ml-1 text-gray-400 fas fa-sort"></i>
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    Category
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    Location
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase cursor-pointer hover:bg-gray-100" onclick="sortTable(5)">
                                    Created
                                    <i class="ml-1 text-gray-400 fas fa-sort"></i>
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    Deadline
                                </th>
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">Actions</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="jobsTableBody" class="bg-white divide-y divide-gray-200">
                            <?php if (empty($jobs)): ?>
                                <tr>
                                    <td colspan="8" class="px-6 py-12 text-center text-gray-500">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-12 h-12 mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            <p class="text-lg font-medium">No jobs found</p>
                                            <p class="text-sm">Try adjusting your search criteria</p>
                                        </div>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($jobs as $job): ?>
                                    <tr class="hover:bg-gray-50"
                                        data-status="<?php echo htmlspecialchars($job['job_status'] ?? ''); ?>"
                                        data-company="<?php echo htmlspecialchars($job['company_name'] ?? ''); ?>"
                                        data-created="<?php echo htmlspecialchars($job['created_at'] ?? ''); ?>">

                                        <!-- Job Title -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900">
                                                        <?php echo htmlspecialchars($job['job_title'] ?? 'Untitled Job'); ?>
                                                    </div>
                                                    <div class="text-xs text-gray-500">
                                                        ID: <?php echo htmlspecialchars($job['job_id'] ?? 'N/A'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Company -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-xs text-gray-900">
                                                <?php echo htmlspecialchars($job['company_name'] ?? 'Unknown Company'); ?>
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                <?php echo htmlspecialchars(($job['employer_first_name'] ?? '') . ' ' . ($job['employer_last_name'] ?? '')); ?>
                                            </div>
                                        </td>

                                        <!-- Category -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex px-2 py-2 text-xs font-semibold bg-blue-100 text-primary">
                                                <?php echo htmlspecialchars($job['category_name'] ?? 'Uncategorized'); ?>
                                            </span>
                                        </td>

                                        <!-- Location -->
                                        <td class="px-6 py-4 text-xs text-gray-500 whitespace-nowrap">
                                            <?php echo htmlspecialchars($job['location'] ?? 'Not specified'); ?>
                                        </td>

                                        <!-- Status -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <?php
                                            $statusClasses = [
                                                'open' => 'bg-green-100 text-green-800',
                                                'closed' => 'bg-red-100 text-red-800',
                                                'paused' => 'bg-yellow-100 text-yellow-800',
                                                'draft' => 'bg-gray-100 text-gray-800',
                                            ];
                                            $statusClass = $statusClasses[$job['job_status'] ?? 'draft'] ?? 'bg-gray-100 text-gray-800';
                                            ?>
                                            <span class="inline-flex px-2 py-2 text-xs font-semibold  <?php echo $statusClass; ?>">
                                                <?php echo ucfirst($job['job_status'] ?? 'Draft'); ?>
                                            </span>
                                        </td>

                                        <!-- Created Date -->
                                        <td class="px-6 py-4 text-xs text-gray-500 whitespace-nowrap">
                                            <?php if (!empty($job['created_at'])): ?>
                                                <div class="flex items-center">
                                                    <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                    <?php echo date('M j, Y', strtotime($job['created_at'])); ?>
                                                </div>
                                            <?php else: ?>
                                                <span class="text-gray-400">-</span>
                                            <?php endif; ?>
                                        </td>

                                        <!-- Deadline -->
                                        <td class="px-6 py-4 text-xs text-gray-500 whitespace-nowrap">
                                            <?php if (!empty($job['application_deadline'])): ?>
                                                <div class="flex items-center">
                                                    <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    <?php
                                                    $deadline = strtotime($job['application_deadline']);
                                                    $isExpired = $deadline < time();
                                                    $textClass = $isExpired ? 'text-red-500' : 'text-gray-500';
                                                    ?>
                                                    <span class="<?php echo $textClass; ?>">
                                                        <?php echo date('M j, Y', $deadline); ?>
                                                    </span>
                                                </div>
                                            <?php else: ?>
                                                <span class="text-gray-400">No deadline</span>
                                            <?php endif; ?>
                                        </td>

                                        <!-- Actions -->
                                        <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                            <div class="flex items-center space-x-2">
                                                <!-- View Job -->
                                                <a href="?page=admin-view-job&id=<?php echo $job['job_id']; ?>"
                                                    class="text-primary hover:text-primary-dark" title="View Details">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    </svg>
                                                </a>

                                                <!-- Status Toggle -->
                                                <div class="relative" x-data="{ open: false }">
                                                    <button @click="open = !open" class="text-gray-400 hover:text-gray-600" title="Change Status">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                                                        </svg>
                                                    </button>

                                                    <div x-show="open" @click.away="open = false"
                                                        x-transition:enter="transition ease-out duration-100"
                                                        x-transition:enter-start="transform opacity-0 scale-95"
                                                        x-transition:enter-end="transform opacity-100 scale-100"
                                                        x-transition:leave="transition ease-in duration-75"
                                                        x-transition:leave-start="transform opacity-100 scale-100"
                                                        x-transition:leave-end="transform opacity-0 scale-95"
                                                        class="absolute right-0 z-50 w-32 mt-2 origin-top-right bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5"
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
                                                                    Pause
                                                                </button>
                                                            <?php endif; ?>
                                                            <?php if ($job['job_status'] !== 'closed'): ?>
                                                                <button onclick="changeJobStatus(<?php echo $job['job_id']; ?>, 'closed')"
                                                                    class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                                                    Close
                                                                </button>
                                                            <?php endif; ?>
                                                            <hr class="my-1">
                                                            <button onclick="deleteJob(<?php echo $job['job_id']; ?>)"
                                                                class="block w-full px-4 py-2 text-sm text-left text-red-600 hover:bg-red-50">
                                                                Delete
                                                            </button>
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
                <div class="py-4 border-t border-gray-200" id="paginationContainer">
                    <div class="flex items-center justify-between">
                        <!-- Left side: Results info -->
                        <div class="text-sm text-gray-700" id="paginationInfo">
                            Showing <span id="showingStart">1</span> to <span id="showingEnd">10</span> of <span id="totalResults"><?php echo count($jobs); ?></span> jobs
                        </div>

                        <!-- Right side: Pagination controls -->
                        <nav class="flex space-x-1" aria-label="Pagination" id="paginationControls">
                            <!-- Previous button -->
                            <button id="prevBtn" onclick="changePage('prev')"
                                class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-l-md hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
                                Previous
                            </button>

                            <!-- Page numbers will be inserted here by JavaScript -->
                            <div id="pageNumbers" class="flex space-x-1"></div>

                            <!-- Next button -->
                            <button id="nextBtn" onclick="changePage('next')"
                                class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-md hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
                                Next
                            </button>
                        </nav>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Hidden forms for status changes -->
<form id="statusChangeForm" method="POST" action="?page=admin-toggle-job-status" style="display: none;">
    <input type="hidden" name="job_id" id="statusJobId">
    <input type="hidden" name="status" id="statusValue">
</form>

<form id="deleteJobForm" method="POST" action="?page=admin-delete-job" style="display: none;">
    <input type="hidden" name="job_id" id="deleteJobId">
</form>

<!-- Keep all your existing JavaScript -->
<script>
    let allRows = [];
    let filteredRows = [];
    let currentFilters = {
        status: '<?php echo $statusFilter ?? ''; ?>',
        search: '<?php echo $searchQuery ?? ''; ?>',
        date: ''
    };

    // Pagination variables
    let currentPage = 1;
    const itemsPerPage = 10;
    let totalPages = 1;

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        allRows = Array.from(document.querySelectorAll('#jobsTableBody tr'));
        filteredRows = [...allRows];
        updateCounts();
        initializePagination();
    });

    // Mobile menu toggle
    function toggleSidebar() {
        const sidebarMobile = document.getElementById('sidebar-mobile');
        const overlay = document.getElementById('mobile-menu-overlay');

        if (sidebarMobile) {
            sidebarMobile.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }
    }

    // Close sidebar when clicking overlay
    document.getElementById('mobile-menu-overlay').addEventListener('click', toggleSidebar);

    // Search functionality
    document.getElementById('searchInput').addEventListener('input', function() {
        currentFilters.search = this.value;
        applyFilters();
    });

    // Filter functions
    function filterByStatus(status) {
        currentFilters.status = status;
        applyFilters();
    }

    function filterByDate(dateRange) {
        currentFilters.date = dateRange;
        applyFilters();
    }

    function applyFilters() {
        const searchValue = currentFilters.search.toLowerCase();
        const statusValue = currentFilters.status;
        const dateValue = currentFilters.date;

        filteredRows = allRows.filter(row => {
            // Skip empty rows (like "no data" message)
            if (!row.dataset.status) return false;

            const searchMatch = !searchValue || (
                row.textContent.toLowerCase().includes(searchValue)
            );

            const statusMatch = !statusValue || statusValue === 'all' ||
                row.dataset.status === statusValue;

            const dateMatch = !dateValue || matchesDateFilter(row.dataset.created, dateValue);

            return searchMatch && statusMatch && dateMatch;
        });

        // Reset to first page when filters change
        currentPage = 1;
        updatePagination();
        updateCounts();
        updateResultsMessage();
    }

    function matchesDateFilter(dateString, filter) {
        const rowDate = new Date(dateString);
        const now = new Date();
        const today = new Date(now.getFullYear(), now.getMonth(), now.getDate());

        switch (filter) {
            case 'today':
                const rowToday = new Date(rowDate.getFullYear(), rowDate.getMonth(), rowDate.getDate());
                return rowToday.getTime() === today.getTime();

            case 'week':
                const weekAgo = new Date(today.getTime() - 7 * 24 * 60 * 60 * 1000);
                return rowDate >= weekAgo;

            case 'month':
                const monthAgo = new Date(today.getFullYear(), today.getMonth() - 1, today.getDate());
                return rowDate >= monthAgo;

            case 'year':
                const yearAgo = new Date(today.getFullYear() - 1, today.getMonth(), today.getDate());
                return rowDate >= yearAgo;

            default:
                return true;
        }
    }

    function updateResultsMessage() {
        const noResultsMessage = document.getElementById('noResultsMessage');
        const jobsTable = document.getElementById('jobsTable');

        if (filteredRows.length === 0) {
            noResultsMessage.classList.remove('hidden');
            jobsTable.classList.add('hidden');
        } else {
            noResultsMessage.classList.add('hidden');
            jobsTable.classList.remove('hidden');
        }
    }

    function updateCounts() {
        const visibleCount = filteredRows.length;
        const totalCount = allRows.filter(row => row.dataset.status).length; // Exclude empty rows

        document.getElementById('visibleCount').textContent = `${visibleCount} visible`;
        document.getElementById('totalResults').textContent = visibleCount;
    }

    // Pagination Functions
    function initializePagination() {
        updatePagination();
    }

    function updatePagination() {
        totalPages = Math.ceil(filteredRows.length / itemsPerPage);

        // Hide/show pagination container based on whether pagination is needed
        const paginationContainer = document.getElementById('paginationContainer');
        if (filteredRows.length <= itemsPerPage) {
            paginationContainer.style.display = 'none';
        } else {
            paginationContainer.style.display = 'block';
        }

        // Show/hide rows based on current page
        allRows.forEach(row => {
            row.style.display = 'none';
        });

        const startIndex = (currentPage - 1) * itemsPerPage;
        const endIndex = Math.min(startIndex + itemsPerPage, filteredRows.length);

        for (let i = startIndex; i < endIndex; i++) {
            if (filteredRows[i]) {
                filteredRows[i].style.display = '';
            }
        }

        updatePaginationInfo();
        updatePaginationControls();
    }

    function updatePaginationInfo() {
        const startIndex = (currentPage - 1) * itemsPerPage + 1;
        const endIndex = Math.min(currentPage * itemsPerPage, filteredRows.length);

        document.getElementById('showingStart').textContent = filteredRows.length > 0 ? startIndex : 0;
        document.getElementById('showingEnd').textContent = endIndex;
    }

    function updatePaginationControls() {
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        const prevBtnMobile = document.getElementById('prevBtnMobile');
        const nextBtnMobile = document.getElementById('nextBtnMobile');
        const pageNumbers = document.getElementById('pageNumbers');

        // Update Previous/Next button states
        prevBtn.disabled = currentPage === 1;
        nextBtn.disabled = currentPage === totalPages || totalPages === 0;
        if (prevBtnMobile) prevBtnMobile.disabled = currentPage === 1;
        if (nextBtnMobile) nextBtnMobile.disabled = currentPage === totalPages || totalPages === 0;

        // Clear existing page numbers
        pageNumbers.innerHTML = '';

        // Add page number buttons
        const maxVisiblePages = 5;
        let startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
        let endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);

        // Adjust startPage if we're near the end
        if (endPage - startPage + 1 < maxVisiblePages) {
            startPage = Math.max(1, endPage - maxVisiblePages + 1);
        }

        // Add first page and ellipsis if needed
        if (startPage > 1) {
            pageNumbers.appendChild(createPageButton(1));
            if (startPage > 2) {
                pageNumbers.appendChild(createEllipsis());
            }
        }

        // Add visible page numbers
        for (let i = startPage; i <= endPage; i++) {
            pageNumbers.appendChild(createPageButton(i));
        }

        // Add ellipsis and last page if needed
        if (endPage < totalPages) {
            if (endPage < totalPages - 1) {
                pageNumbers.appendChild(createEllipsis());
            }
            pageNumbers.appendChild(createPageButton(totalPages));
        }
    }

    function createPageButton(pageNum) {
        const button = document.createElement('button');
        button.textContent = pageNum;
        button.onclick = () => changePage(pageNum);

        if (pageNum === currentPage) {
            button.className = 'relative inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-primary border border-primary';
        } else {
            button.className = 'relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 hover:bg-gray-50';
        }

        return button;
    }

    function createEllipsis() {
        const span = document.createElement('span');
        span.textContent = '...';
        span.className = 'relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300';
        return span;
    }

    function changePage(direction) {
        if (typeof direction === 'number') {
            currentPage = direction;
        } else if (direction === 'prev' && currentPage > 1) {
            currentPage--;
        } else if (direction === 'next' && currentPage < totalPages) {
            currentPage++;
        }

        updatePagination();
    }

    function clearAllFilters() {
        currentFilters = {
            status: '',
            search: '',
            date: ''
        };

        document.getElementById('searchInput').value = '';

        // Reset Alpine.js dropdown selections
        const statusDropdown = document.querySelector('[x-data*="Status"]');
        const dateDropdown = document.querySelector('[x-data*="Date Range"]');

        if (statusDropdown && statusDropdown._x_dataStack) {
            statusDropdown._x_dataStack[0].selected = 'Status';
        }
        if (dateDropdown && dateDropdown._x_dataStack) {
            dateDropdown._x_dataStack[0].selected = 'Date Range';
        }

        applyFilters();
    }

    // Export functionality
    function exportResults(format) {
        // Export all filtered results, not just current page
        const visibleData = filteredRows.map(row => {
            const cells = row.querySelectorAll('td');
            return {
                title: cells[0].textContent.trim(),
                company: cells[1].textContent.trim(),
                category: cells[2].textContent.trim(),
                location: cells[3].textContent.trim(),
                status: cells[4].textContent.trim(),
                created: cells[5].textContent.trim(),
                deadline: cells[6].textContent.trim()
            };
        });

        if (format === 'csv') {
            exportToCSV(visibleData);
        }
    }

    function exportToCSV(data) {
        const headers = ['Job Title', 'Company', 'Category', 'Location', 'Status', 'Created', 'Deadline'];
        const csvContent = [
            headers.join(','),
            ...data.map(row => [
                `"${row.title}"`,
                `"${row.company}"`,
                `"${row.category}"`,
                `"${row.location}"`,
                `"${row.status}"`,
                `"${row.created}"`,
                `"${row.deadline}"`
            ].join(','))
        ].join('\n');

        const blob = new Blob([csvContent], {
            type: 'text/csv'
        });
        const url = window.URL.createObjectURL(blob);
        const link = document.createElement('a');
        link.href = url;
        link.download = `jobs_${new Date().toISOString().split('T')[0]}.csv`;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        window.URL.revokeObjectURL(url);
    }

    // Sorting functionality
    let sortDirection = {};

    function sortTable(columnIndex) {
        const direction = sortDirection[columnIndex] === 'asc' ? 'desc' : 'asc';
        sortDirection[columnIndex] = direction;

        filteredRows.sort((a, b) => {
            const aValue = a.cells[columnIndex].textContent.trim().toLowerCase();
            const bValue = b.cells[columnIndex].textContent.trim().toLowerCase();

            if (columnIndex === 5) { // Date column
                const aDate = new Date(aValue);
                const bDate = new Date(bValue);
                return direction === 'asc' ? aDate - bDate : bDate - aDate;
            }

            return direction === 'asc' ?
                aValue.localeCompare(bValue) :
                bValue.localeCompare(aValue);
        });

        currentPage = 1;
        updatePagination();
    }

    // Job status management
    function changeJobStatus(jobId, status) {
        if (confirm(`Are you sure you want to ${status} this job?`)) {
            document.getElementById('statusJobId').value = jobId;
            document.getElementById('statusValue').value = status;
            document.getElementById('statusChangeForm').submit();
        }
    }

    function deleteJob(jobId) {
        if (confirm('Are you sure you want to delete this job? This action cannot be undone.')) {
            document.getElementById('deleteJobId').value = jobId;
            document.getElementById('deleteJobForm').submit();
        }
    }
</script>