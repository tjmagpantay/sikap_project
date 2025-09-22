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
    <div class="flex items-stretch w-full gap-3 mb-6">
        <!-- Search Input (Expanded width with right-side icon) -->
        <div class="flex-1">
            <div class="relative">
                <input
                    type="text"
                    id="searchInput"
                    placeholder="Search"
                    class="w-full px-4 py-3 pr-10 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-primary/20 focus:border-primary"
                    value="<?php echo htmlspecialchars($searchQuery ?? ''); ?>">

                <svg class="absolute w-4 h-4 text-gray-400 transform -translate-y-1/2 pointer-events-none right-3 top-1/2"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m21 21-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
        </div>


        <!-- Status Filter (Expanded width) -->
        <div class="relative flex-1 min-w-32" x-data="{ open: false, selected: '<?php echo ucfirst($statusFilter ?? 'All Status'); ?>' }">
            <button @click="open = !open"
                class="flex items-center justify-between w-full px-4 py-3 text-sm border border-gray-300 rounded-lg bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-primary/20">
                <span x-text="selected || 'Filter by status'" class="text-gray-700 truncate"></span>
                <i class="flex-shrink-0 ml-2 text-gray-400 fas fa-chevron-down" :class="{ 'rotate-180': open }"></i>
            </button>
            <div x-show="open" @click.away="open = false"
                class="absolute right-0 z-50 w-full mt-1 bg-white rounded-md shadow-lg min-w-40 ring-1 ring-black ring-opacity-5">
                <div class="py-1">
                    <a href="#" @click.prevent="selected = 'All Status'; filterByStatus(''); open = false"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">All Status</a>
                    <a href="#" @click.prevent="selected = 'Open'; filterByStatus('open'); open = false"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Open</a>
                    <a href="#" @click.prevent="selected = 'Paused'; filterByStatus('paused'); open = false"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Paused</a>
                    <a href="#" @click.prevent="selected = 'Closed'; filterByStatus('closed'); open = false"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Closed</a>
                    <a href="#" @click.prevent="selected = 'Draft'; filterByStatus('draft'); open = false"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Draft</a>
                </div>
            </div>
        </div>

        <!-- Date Filter (Expanded width) -->
        <div class="relative flex-1 min-w-32" x-data="{ open: false, selected: 'All Dates' }">
            <button @click="open = !open"
                class="flex items-center justify-between w-full px-4 py-3 text-sm border border-gray-300 rounded-lg bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-primary/20">
                <span x-text="selected" class="truncate"></span>
                <i class="flex-shrink-0 ml-2 text-gray-400 fas fa-chevron-down" :class="{ 'rotate-180': open }"></i>
            </button>
            <div x-show="open" @click.away="open = false"
                class="absolute right-0 z-50 w-full mt-1 bg-white rounded-md shadow-lg min-w-48 ring-1 ring-black ring-opacity-5">
                <div class="py-1">
                    <a href="#" @click.prevent="selected = 'All Dates'; filterByDate(''); open = false"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">All Dates</a>
                    <a href="#" @click.prevent="selected = 'Today'; filterByDate('today'); open = false"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Today</a>
                    <a href="#" @click.prevent="selected = 'This Week'; filterByDate('week'); open = false"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">This Week</a>
                    <a href="#" @click.prevent="selected = 'This Month'; filterByDate('month'); open = false"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">This Month</a>
                    <a href="#" @click.prevent="selected = 'This Year'; filterByDate('year'); open = false"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">This Year</a>
                </div>
            </div>
        </div>

        <!-- Action Buttons (Fixed width) -->
        <div class="flex flex-shrink-0 gap-2">
            <button onclick="clearAllFilters()"
                class="px-4 py-3 text-sm text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 whitespace-nowrap">
                <i class="mr-1 fas fa-times"></i> Clear
            </button>
            <button onclick="exportResults('csv')"
                class="px-4 py-3 text-sm text-white rounded-lg bg-primary hover:bg-primary/90 whitespace-nowrap">
                <i class="mr-1 fas fa-file-download"></i> Export
            </button>
        </div>
    </div>

    <!-- All Jobs -->
    <div>
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
                <button onclick="clearAllFilters()" class="mt-2 text-blue-600 hover:text-blue-900">Clear filters</button>
            </div>

            <!-- Jobs Table -->
            <div class="overflow-hidden bg-white border border-gray-200 rounded-lg shadow-sm" id="jobsTable">
                <div class="overflow-x-auto">
                    <table class="w-full divide-y divide-gray-200">
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
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    Actions
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
                                            <span class="inline-flex px-2 py-1 text-xs font-medium bg-gray-100 rounded-md text-primary">
                                                <?php echo htmlspecialchars($job['category_name'] ?? 'Uncategorized'); ?>
                                            </span>
                                        </td>

                                        <!-- Location -->
                                        <td class="px-6 py-4 text-xs text-gray-900 whitespace-nowrap">
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
                                            <span class="inline-flex px-2 py-1 text-xs font-medium rounded-md <?php echo $statusClass; ?>">
                                                <?php echo ucfirst($job['job_status'] ?? 'Draft'); ?>
                                            </span>
                                        </td>

                                        <!-- Created Date -->
                                        <td class="px-6 py-4 text-xs text-gray-800 whitespace-nowrap">
                                            <?php if (!empty($job['created_at'])): ?>
                                                <div class="flex items-center">

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
                                        <td class="px-6 py-4 text-sm font-medium whitespace-nowrap">
                                            <div class="flex items-center justify-end">
                                                <!-- Actions Dropdown -->
                                                <div class="relative" x-data="{ open: false }" x-init="$refs.button" @click.away="open = false">

                                                    <!-- Dropdown Trigger Button -->
                                                    <button @click="open = !open"
                                                        x-ref="button"
                                                        class="inline-flex items-center px-3 py-2 text-xs font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary"
                                                        :class="{ 'bg-gray-100': open }"
                                                        type="button">
                                                        <span>Actions</span>
                                                        <svg class="w-4 h-4 ml-1 transition-transform duration-200 transform" :class="{ 'rotate-180': open }"
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
                                                        class="absolute right-0 z-50 w-48 mt-2 origin-top-right bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                                                        style="top: 100%; min-width: 180px;"
                                                        @keydown.escape.prevent.stop="open = false">

                                                        <div class="py-1" role="menu" aria-orientation="vertical">
                                                            <!-- View Job -->
                                                            <a href="?page=admin-view-job&id=<?php echo $job['job_id']; ?>"
                                                                class="flex items-center w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                                                                role="menuitem">
                                                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                                </svg>
                                                                View Details
                                                            </a>

                                                            <hr class="my-1">

                                                            <!-- Status Actions -->
    

                                                            <?php if ($job['job_status'] !== 'paused'): ?>
                                                                <button type="button"
                                                                    onclick="changeJobStatus(<?php echo $job['job_id']; ?>, 'paused'); this.closest('[x-data]').__x.$data.open = false;"
                                                                    class="flex items-center w-full px-4 py-2 text-sm text-left text-yellow-700 hover:bg-yellow-50"
                                                                    role="menuitem">
                                                                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                                    </svg>
                                                                    Pause
                                                                </button>
                                                            <?php endif; ?>

                                                            <?php if ($job['job_status'] !== 'closed'): ?>
                                                                <button type="button"
                                                                    onclick="changeJobStatus(<?php echo $job['job_id']; ?>, 'closed'); this.closest('[x-data]').__x.$data.open = false;"
                                                                    class="flex items-center w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-50"
                                                                    role="menuitem">
                                                                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                                    </svg>
                                                                    Close
                                                                </button>
                                                            <?php endif; ?>

                                                            <hr class="my-1">

                                                            <!-- Delete Action -->
                                                            <button type="button"
                                                                onclick="deleteJob(<?php echo $job['job_id']; ?>); this.closest('[x-data]').__x.$data.open = false;"
                                                                class="flex items-center w-full px-4 py-2 text-sm text-left text-red-600 hover:bg-red-50"
                                                                role="menuitem">
                                                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                                </svg>
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

                <!-- Pagination - Same as jobseeker management -->
                <div class="flex items-center justify-between px-6 py-3 border-t border-gray-200 bg-gray-50">
                    <div class="flex items-center gap-1 text-sm text-gray-70">
                        <span>Showing</span>
                        <span class="mx-1 font-medium" id="startItem">1</span>
                        <span>to</span>
                        <span class="mx-1 font-medium" id="endItem">10</span>
                        <span>of</span>
                        <span class="mx-1 font-medium" id="totalItems">0</span>
                        <span>results</span>
                    </div>
                    <div class="flex space-x-2">
                        <button id="prevBtn" onclick="previousPage()"
                            class="px-3 py-1 text-sm bg-white border border-gray-300 rounded hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
                            <i class="mr-1 fas fa-chevron-left"></i> Previous
                        </button>
                        <div id="pageNumbers" class="flex space-x-1"></div>
                        <button id="nextBtn" onclick="nextPage()"
                            class="px-3 py-1 text-sm text-white border border-gray-300 rounded bg-primary hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
                            Next <i class="ml-1 fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

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

        // Add search event listener
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                currentFilters.search = this.value;
                applyFilters();
            });
        }
    });

    // Pagination Functions
    function initializePagination() {
        updatePagination();
    }

    function updatePagination() {
        totalPages = Math.ceil(filteredRows.length / itemsPerPage);

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
        updatePaginationControls(totalPages);
    }

    function updatePaginationInfo() {
        const startIndex = (currentPage - 1) * itemsPerPage + 1;
        const endIndex = Math.min(currentPage * itemsPerPage, filteredRows.length);

        const totalItemsEl = document.getElementById('totalItems');
        const startItemEl = document.getElementById('startItem');
        const endItemEl = document.getElementById('endItem');

        if (totalItemsEl) totalItemsEl.textContent = filteredRows.length;
        if (startItemEl) startItemEl.textContent = startIndex;
        if (endItemEl) endItemEl.textContent = endIndex;
    }

    function updatePaginationControls(totalPages) {
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        const pageNumbers = document.getElementById('pageNumbers');

        if (!prevBtn || !nextBtn || !pageNumbers) return;

        // Update Previous/Next button states
        prevBtn.disabled = currentPage === 1;
        nextBtn.disabled = currentPage === totalPages || totalPages === 0;

        // Clear existing page numbers
        pageNumbers.innerHTML = '';

        if (totalPages <= 1) return;

        // Add page number buttons
        const maxVisiblePages = 5;
        let startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
        let endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);

        // Adjust startPage if we're near the end
        if (endPage - startPage + 1 < maxVisiblePages) {
            startPage = Math.max(1, endPage - maxVisiblePages + 1);
        }

        // Add visible page numbers
        for (let i = startPage; i <= endPage; i++) {
            const button = document.createElement('button');
            button.textContent = i;
            button.onclick = () => goToPage(i);

            if (i === currentPage) {
                button.className = 'px-3 py-1 text-sm text-white border rounded bg-primary border-primary';
            } else {
                button.className = 'px-3 py-1 text-sm bg-white border border-gray-300 rounded hover:bg-gray-50';
            }

            pageNumbers.appendChild(button);
        }
    }

    // Navigation functions
    function previousPage() {
        if (currentPage > 1) {
            currentPage--;
            updatePagination();
        }
    }

    function nextPage() {
        const totalPages = Math.ceil(filteredRows.length / itemsPerPage);
        if (currentPage < totalPages) {
            currentPage++;
            updatePagination();
        }
    }

    function goToPage(page) {
        currentPage = page;
        updatePagination();
    }

    // Filter functions - ADD THESE
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
            if (!row.dataset || !row.dataset.status) return false;

            const jobTitle = row.querySelector('td:nth-child(1)')?.textContent?.toLowerCase() || '';
            const companyName = row.querySelector('td:nth-child(2)')?.textContent?.toLowerCase() || '';
            const category = row.querySelector('td:nth-child(3)')?.textContent?.toLowerCase() || '';
            const location = row.querySelector('td:nth-child(4)')?.textContent?.toLowerCase() || '';

            // Search filter - check multiple fields
            const searchMatch = !searchValue || (
                jobTitle.includes(searchValue) ||
                companyName.includes(searchValue) ||
                category.includes(searchValue) ||
                location.includes(searchValue)
            );

            // Status filter
            const statusMatch = !statusValue || statusValue === 'all' ||
                row.dataset.status === statusValue;

            // Date filter
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

        if (!noResultsMessage || !jobsTable) return;

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

        const visibleCountEl = document.getElementById('visibleCount');
        if (visibleCountEl) visibleCountEl.textContent = `${visibleCount} visible`;

        const totalResultsEl = document.getElementById('totalResults') || document.getElementById('totalItems');
        if (totalResultsEl) totalResultsEl.textContent = visibleCount;
    }

    function clearAllFilters() {
        currentFilters = {
            status: '',
            search: '',
            date: ''
        };

        const searchInput = document.getElementById('searchInput');
        if (searchInput) searchInput.value = '';

        // Reset pagination
        currentPage = 1;

        // Reset Alpine.js dropdown selections
        setTimeout(() => {
            const dropdowns = document.querySelectorAll('[x-data]');
            dropdowns.forEach(dropdown => {
                if (dropdown._x_dataStack && dropdown._x_dataStack[0]) {
                    const data = dropdown._x_dataStack[0];
                    if (data.selected && data.selected.includes('Status')) {
                        data.selected = 'All Status';
                    }
                    if (data.selected && data.selected.includes('Date')) {
                        data.selected = 'All Dates';
                    }
                }
            });
        }, 100);

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

    // Job status management - FIXED for admin
    function changeJobStatus(jobId, status) {
        if (confirm(`Are you sure you want to ${status} this job?`)) {
            const formData = new FormData();
            formData.append('job_id', jobId);
            formData.append('status', status);

            const baseUrl = window.location.pathname.split('index.php')[0];
            const url = baseUrl + 'index.php?page=admin-toggle-job-status';

            fetch(url, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'Accept': 'application/json'
                    }
                })
                .then(async response => {
                    const text = await response.text();
                    try {
                        return JSON.parse(text);
                    } catch (e) {
                        throw new Error('Invalid JSON response: ' + text);
                    }
                })
                .then(data => {
                    if (data.success) {
                        // Reload page to show updated status
                        location.reload();
                    } else {
                        throw new Error(data.error || 'Failed to update status');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error: ' + error.message);
                });
        }
    }

    function deleteJob(jobId) {
        if (confirm('Are you sure you want to delete this job? This action cannot be undone.')) {
            const formData = new FormData();
            formData.append('job_id', jobId);

            const baseUrl = window.location.pathname.split('index.php')[0];
            const url = baseUrl + 'index.php?page=admin-delete-job';

            fetch(url, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'Accept': 'application/json'
                    }
                })
                .then(async response => {
                    const text = await response.text();
                    try {
                        return JSON.parse(text);
                    } catch (e) {
                        throw new Error('Invalid JSON response: ' + text);
                    }
                })
                .then(data => {
                    if (data.success) {
                        // Reload page to show updated list
                        location.reload();
                    } else {
                        throw new Error(data.error || 'Failed to delete job');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error: ' + error.message);
                });
        }
    }
</script>