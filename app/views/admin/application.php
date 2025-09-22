<div class="space-y-6">
    <!-- Header Section -->
    <div class="mb-6">
        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Application Management</h1>
                <p class="mt-1 text-sm text-gray-600">Monitor and view all job applications in the system</p>
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
    <div class="grid grid-cols-1 gap-4 mb-6 sm:gap-6 sm:mb-8 md:grid-cols-6">
        <!-- Card 1: Total Applications -->
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-6">
            <div class="">
                <h3 class="mb-3 text-sm font-medium text-gray-700 sm:mb-4">Total Applications</h3>
                <div class="flex items-baseline">
                    <span class="text-2xl font-bold text-gray-900 sm:text-3xl" data-stat="total"><?php echo $stats['total'] ?? 0; ?></span>
                    <svg class="ml-1 sm:ml-2" width="14px" height="14px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" stroke="#16a34a" />
                    </svg>
                </div>
                <p class="mt-2 text-xs text-gray-500">
                    All submitted applications
                </p>
            </div>
        </div>

        <!-- Card 2: Pending Applications -->
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-6">
            <div class="">
                <h3 class="mb-3 text-sm font-medium text-gray-700 sm:mb-4">Pending</h3>
                <div class="flex items-baseline">
                    <span class="text-2xl font-bold text-gray-900 sm:text-3xl" data-stat="pending"><?php echo $stats['pending'] ?? 0; ?></span>
                    <svg class="ml-1 sm:ml-2" width="14px" height="14px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke="#f59e0b" />
                    </svg>
                </div>
                <p class="mt-2 text-xs text-gray-500">
                    Awaiting employer review
                </p>
            </div>
        </div>

        <!-- Card 3: Reviewed Applications -->
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-6">
            <div class="">
                <h3 class="mb-3 text-sm font-medium text-gray-700 sm:mb-4">Reviewed</h3>
                <div class="flex items-baseline">
                    <span class="text-2xl font-bold text-gray-900 sm:text-3xl" data-stat="reviewed"><?php echo $stats['reviewed'] ?? 0; ?></span>
                    <svg class="ml-1 sm:ml-2" width="14px" height="14px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke="#3b82f6" />
                    </svg>
                </div>
                <p class="mt-2 text-xs text-gray-500">
                    Under employer review
                </p>
            </div>
        </div>

        <!-- Card 4: Shortlisted Applications -->
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-6">
            <div class="">
                <h3 class="mb-3 text-sm font-medium text-gray-700 sm:mb-4">Shortlisted</h3>
                <div class="flex items-baseline">
                    <span class="text-2xl font-bold text-gray-900 sm:text-3xl" data-stat="shortlisted"><?php echo $stats['shortlisted'] ?? 0; ?></span>
                    <svg class="ml-1 sm:ml-2" width="14px" height="14px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" stroke="#10b981" />
                    </svg>
                </div>
                <p class="mt-2 text-xs text-gray-500">
                    Selected for interview
                </p>
            </div>
        </div>

        <!-- Card 5: Hired Applications -->
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-6">
            <div class="">
                <h3 class="mb-3 text-sm font-medium text-gray-700 sm:mb-4">Hired</h3>
                <div class="flex items-baseline">
                    <span class="text-2xl font-bold text-gray-900 sm:text-3xl" data-stat="hired"><?php echo $stats['hired'] ?? 0; ?></span>
                    <svg class="ml-1 sm:ml-2" width="14px" height="14px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke="#059669" />
                    </svg>
                </div>
                <p class="mt-2 text-xs text-gray-500">
                    Successfully hired
                </p>
            </div>
        </div>

        <!-- Card 6: Rejected Applications -->
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-6">
            <div class="">
                <h3 class="mb-3 text-sm font-medium text-gray-700 sm:mb-4">Rejected</h3>
                <div class="flex items-baseline">
                    <span class="text-2xl font-bold text-gray-900 sm:text-3xl" data-stat="rejected"><?php echo $stats['rejected'] ?? 0; ?></span>
                    <svg class="ml-1 sm:ml-2" width="14px" height="14px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" stroke="#dc2626" />
                    </svg>
                </div>
                <p class="mt-2 text-xs text-gray-500">
                    Application declined
                </p>
            </div>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="relative w-full py-4 rounded-xl">
        <div class="flex flex-col w-full gap-6 mx-auto">
            <div class="flex flex-wrap items-stretch w-full gap-3">

                <!-- Search Applications (Much Wider) -->
                <div class="flex-1 min-w-[200px] max-w-xs">
                    <div class="relative">
                        <input type="text" id="searchInput"
                            class="w-full px-4 py-3 pl-10 text-sm transition-all duration-200 bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary"
                            placeholder="Search by applicant, job title, company..."
                            value="<?php echo htmlspecialchars($searchQuery ?? ''); ?>">

                    </div>
                </div>

                <!-- Status Filter -->
                <div class="relative flex-1 min-w-[120px] max-w-xs" x-data="{ open: false, selected: '<?php echo ucfirst($statusFilter === 'all' ? 'All Status' : $statusFilter); ?>' }">
                    <button @click="open = !open"
                        @click.away="open = false"
                        class="flex items-center justify-between w-full px-4 py-3 text-sm text-gray-700 transition-all duration-200 bg-white border border-gray-300 rounded-lg shadow-sm hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
                        <span x-text="selected" class="truncate"></span>
                        <svg class="flex-shrink-0 w-4 h-4 ml-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                        class="absolute left-0 z-50 w-full mt-2 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5"
                        x-cloak>
                        <div class="py-1">
                            <button @click="selected = 'All Status'; open = false; filterByStatus('')"
                                class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                All Status
                            </button>
                            <button @click="selected = 'Pending'; open = false; filterByStatus('pending')"
                                class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Pending
                            </button>
                            <button @click="selected = 'Reviewed'; open = false; filterByStatus('reviewed')"
                                class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Reviewed
                            </button>
                            <button @click="selected = 'Shortlisted'; open = false; filterByStatus('shortlisted')"
                                class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Shortlisted
                            </button>
                            <button @click="selected = 'Hired'; open = false; filterByStatus('hired')"
                                class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Hired
                            </button>
                            <button @click="selected = 'Rejected'; open = false; filterByStatus('rejected')"
                                class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Rejected
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Job Filter -->
                <div class="relative flex-1 min-w-[140px] max-w-xs" x-data="{ open: false, selected: 'All Jobs' }">
                    <button @click="open = !open"
                        @click.away="open = false"
                        class="flex items-center justify-between w-full px-4 py-3 text-sm text-gray-700 transition-all duration-200 bg-white border border-gray-300 rounded-lg shadow-sm hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
                        <span x-text="selected" class="truncate"></span>
                        <svg class="flex-shrink-0 w-4 h-4 ml-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                        class="absolute left-0 z-50 w-full mt-2 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5"
                        x-cloak>
                        <div class="py-1">
                            <button @click="selected = 'All Jobs'; open = false; filterByJob('')"
                                class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                All Jobs
                            </button>
                            <?php if (!empty($jobs)): ?>
                                <?php foreach ($jobs as $job): ?>
                                    <button @click="selected = '<?php echo htmlspecialchars($job['job_title']); ?>'; open = false; filterByJob('<?php echo $job['job_id']; ?>')"
                                        class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <?php echo htmlspecialchars($job['job_title']); ?> - <?php echo htmlspecialchars($job['company_name']); ?>
                                    </button>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Date Filter -->
                <div class="relative flex-1 min-w-[140px] max-w-xs" x-data="{ open: false, selected: 'All Dates' }">
                    <button @click="open = !open"
                        @click.away="open = false"
                        class="flex items-center justify-between w-full px-4 py-3 text-sm text-gray-700 transition-all duration-200 bg-white border border-gray-300 rounded-lg shadow-sm hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
                        <span x-text="selected" class="truncate"></span>
                        <svg class="flex-shrink-0 w-4 h-4 ml-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                        class="absolute left-0 z-50 w-full mt-2 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5"
                        x-cloak>
                        <div class="py-1">
                            <button @click="selected = 'All Dates'; open = false; filterByDate('')"
                                class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                All Dates
                            </button>
                            <button @click="selected = 'Today'; open = false; filterByDate('today')"
                                class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Today
                            </button>
                            <button @click="selected = 'This Week'; open = false; filterByDate('week')"
                                class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                This Week
                            </button>
                            <button @click="selected = 'This Month'; open = false; filterByDate('month')"
                                class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                This Month
                            </button>
                            <button @click="selected = 'This Year'; open = false; filterByDate('year')"
                                class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                This Year
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Filter/Clear Buttons -->
                <div class="flex flex-shrink-0 gap-2">
                    <button onclick="clearAllFilters()"
                        class="px-4 py-3 text-sm font-medium text-gray-600 transition-colors duration-200 bg-gray-100 border border-gray-300 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        Clear
                    </button>
                    <button onclick="exportResults('csv')"
                        class="px-4 py-3 text-sm font-medium text-white transition-colors duration-200 border rounded-md bg-primary border-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        Export
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- All Applications -->
    <div>


        <?php if (empty($applications)): ?>
            <div class="p-8 text-center bg-white border border-gray-200 rounded-lg" id="noApplicationsMessage">
                <i class="mb-4 text-4xl text-gray-400 fas fa-file-alt"></i>
                <p class="text-gray-500">No applications found</p>
            </div>
        <?php else: ?>
            <!-- No Results Message (Hidden by default) -->
            <div class="hidden p-8 text-center bg-white border border-gray-200 rounded-lg" id="noResultsMessage">
                <i class="mb-4 text-4xl text-gray-400 fas fa-search"></i>
                <p class="text-gray-500">No applications match your search criteria</p>
            </div>

            <!-- Applications Table -->
            <div class="overflow-hidden bg-white border border-gray-200 rounded-lg shadow-sm" id="applicationsTable">
                <table class="w-full divide-y divide-gray-200 table-auto">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase cursor-pointer hover:bg-gray-100" onclick="sortTable(0)">
                                Applicant <i class="ml-1 text-gray-400 fas fa-sort"></i>
                            </th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase cursor-pointer hover:bg-gray-100" onclick="sortTable(1)">
                                Job Title <i class="ml-1 text-gray-400 fas fa-sort"></i>
                            </th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Company
                            </th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Status
                            </th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase cursor-pointer hover:bg-gray-100" onclick="sortTable(4)">
                                Applied Date <i class="ml-1 text-gray-400 fas fa-sort"></i>
                            </th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody id="applicationsTableBody" class="bg-white divide-y divide-gray-200">
                        <?php foreach ($applications as $application): ?>
                            <tr class="hover:bg-gray-50"
                                data-status="<?php echo htmlspecialchars($application['application_status']); ?>"
                                data-job="<?php echo htmlspecialchars($application['job_id']); ?>"
                                data-applied="<?php echo htmlspecialchars($application['applied_at']); ?>"
                                data-name="<?php echo htmlspecialchars($application['first_name'] . ' ' . $application['last_name']); ?>"
                                data-company="<?php echo htmlspecialchars($application['company_name']); ?>"
                                data-job-title="<?php echo htmlspecialchars($application['job_title']); ?>">

                                <!-- Applicant -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex items-center justify-center w-8 h-8 mr-3 rounded-full bg-primary">
                                            <span class="text-xs font-medium text-white">
                                                <?php echo strtoupper(substr($application['first_name'], 0, 1) . substr($application['last_name'], 0, 1)); ?>
                                            </span>
                                        </div>
                                        <div class="text-sm font-medium text-gray-900">
                                            <?php echo htmlspecialchars($application['first_name'] . ' ' . $application['last_name']); ?>
                                        </div>
                                    </div>
                                </td>

                                <!-- Job Title -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($application['job_title']); ?></div>
                                    <div class="text-xs text-gray-500"><?php echo htmlspecialchars($application['employment_type'] ?? 'N/A'); ?></div>
                                </td>

                                <!-- Company -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900"><?php echo htmlspecialchars($application['company_name']); ?></div>
                                    <div class="text-xs text-gray-500">
                                        <?php echo htmlspecialchars(($application['employer_first_name'] ?? '') . ' ' . ($application['employer_last_name'] ?? '')); ?>
                                    </div>
                                </td>

                                <!-- Status -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php
                                    $statusClasses = [
                                        'pending' => 'bg-gray-100 text-primary',
                                        'reviewed' => 'bg-gray-100 text-primary',
                                        'shortlisted' => 'bg-gray-100 text-primary',
                                        'rejected' => 'bg-red-100 text-red-800',
                                        'hired' => 'bg-gray-100 text-primary'
                                    ];
                                    $statusClass = $statusClasses[$application['application_status']] ?? 'bg-gray-100 text-gray-800';
                                    ?>
                                    <span class="inline-flex px-2 py-1 text-xs font-medium rounded-md <?php echo $statusClass; ?>">
                                        <?php echo ucfirst($application['application_status']); ?>
                                    </span>
                                </td>

                                <!-- Applied Date -->
                                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                    <?php if (!empty($application['applied_at'])): ?>
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            <?php echo date('M j, Y', strtotime($application['applied_at'])); ?>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-gray-400">-</span>
                                    <?php endif; ?>
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                    <div class="flex items-center space-x-2">
                                        <!-- View Application Summary -->
                                        <button onclick="viewApplicationSummary(<?php echo $application['application_id']; ?>)"
                                            class="text-primary hover:text-primary-dark" title="View Summary">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="flex items-center justify-between px-6 py-3 border-t border-gray-200 bg-gray-50" id="paginationContainer">
                    <div class="flex items-center gap-1 text-sm text-gray-700">
                        <span>Showing</span>
                        <span class="mx-1 font-medium" id="showingStart">1</span>
                        <span>to</span>
                        <span class="mx-1 font-medium" id="showingEnd">10</span>
                        <span>of</span>
                        <span class="mx-1 font-medium" id="totalResults">0</span>
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

<!-- Application Summary Modal -->
<div id="applicationModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" onclick="closeModal()"></div>

        <!-- Modal content -->
        <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="w-full">
                        <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">
                            Application Summary
                        </h3>
                        <div class="mt-4" id="modal-content">
                            <!-- Content will be loaded here -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="px-4 py-3 bg-gray-50 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" onclick="closeModal()"
                    class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    let allRows = [];
    let filteredRows = [];
    let currentFilters = {
        status: '<?php echo $statusFilter ?? ''; ?>',
        search: '<?php echo $searchQuery ?? ''; ?>',
        job: '<?php echo $jobFilter ?? ''; ?>',
        date: ''
    };

    // Pagination variables
    let currentPage = 1;
    const itemsPerPage = 10;
    let totalPages = 1;

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        allRows = Array.from(document.querySelectorAll('#applicationsTableBody tr'));
        filteredRows = [...allRows];
        updateCounts();
        initializePagination();
    });

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

    function filterByJob(jobId) {
        currentFilters.job = jobId;
        applyFilters();
    }

    function filterByDate(dateRange) {
        currentFilters.date = dateRange;
        applyFilters();
    }

    function applyFilters() {
        const searchValue = currentFilters.search.toLowerCase();
        const statusValue = currentFilters.status;
        const jobValue = currentFilters.job;
        const dateValue = currentFilters.date;

        filteredRows = allRows.filter(row => {
            const searchMatch = !searchValue || (
                row.dataset.name.toLowerCase().includes(searchValue) ||
                row.dataset.company.toLowerCase().includes(searchValue) ||
                row.dataset.jobTitle.toLowerCase().includes(searchValue)
            );

            const statusMatch = !statusValue || statusValue === 'all' ||
                row.dataset.status === statusValue;

            const jobMatch = !jobValue || jobValue === 'all' ||
                row.dataset.job === jobValue;

            const dateMatch = !dateValue || matchesDateFilter(row.dataset.applied, dateValue);

            return searchMatch && statusMatch && jobMatch && dateMatch;
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

    function updateCounts() {
        const visibleCount = filteredRows.length;
        document.getElementById('totalResults').textContent = visibleCount;
    }

    function updateResultsMessage() {
        const noResultsMessage = document.getElementById('noResultsMessage');
        const applicationsTable = document.getElementById('applicationsTable');

        if (filteredRows.length === 0) {
            noResultsMessage.classList.remove('hidden');
            applicationsTable.classList.add('hidden');
        } else {
            noResultsMessage.classList.add('hidden');
            applicationsTable.classList.remove('hidden');
        }
    }

    // Pagination Functions
    function initializePagination() {
        updatePagination();
    }

    function updatePagination() {
        totalPages = Math.ceil(filteredRows.length / itemsPerPage);

        // Hide all rows first
        allRows.forEach(row => {
            row.style.display = 'none';
        });

        // If no filtered results, don't show any rows
        if (filteredRows.length === 0) {
            updatePaginationInfo();
            updatePaginationControls(0);
            return;
        }

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

        document.getElementById('showingStart').textContent = filteredRows.length > 0 ? startIndex : 0;
        document.getElementById('showingEnd').textContent = endIndex;
        document.getElementById('totalResults').textContent = filteredRows.length;
    }

    function updatePaginationControls(totalPages) {
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        const pageNumbers = document.getElementById('pageNumbers');

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
        if (currentPage < totalPages) {
            currentPage++;
            updatePagination();
        }
    }

    function goToPage(page) {
        currentPage = page;
        updatePagination();
    }

    function clearAllFilters() {
        currentFilters = {
            status: '',
            search: '',
            job: '',
            date: ''
        };

        document.getElementById('searchInput').value = '';

        // Reset Alpine.js dropdown selections
        setTimeout(() => {
            const dropdowns = document.querySelectorAll('[x-data]');
            dropdowns.forEach(dropdown => {
                if (dropdown._x_dataStack && dropdown._x_dataStack[0]) {
                    const data = dropdown._x_dataStack[0];
                    if (data.selected) {
                        if (data.selected.includes('Status') || data.selected === 'Pending' || data.selected === 'Reviewed' || data.selected === 'Shortlisted' || data.selected === 'Hired' || data.selected === 'Rejected') {
                            data.selected = 'All Status';
                        } else if (data.selected.includes('Job') || data.selected !== 'All Jobs') {
                            data.selected = 'All Jobs';
                        } else if (data.selected.includes('Date') || data.selected === 'Today' || data.selected === 'This Week' || data.selected === 'This Month' || data.selected === 'This Year') {
                            data.selected = 'All Dates';
                        }
                    }
                }
            });
        }, 100);

        applyFilters();
    }

    // Sorting functionality
    let sortDirection = {};

    function sortTable(columnIndex) {
        const direction = sortDirection[columnIndex] === 'asc' ? 'desc' : 'asc';
        sortDirection[columnIndex] = direction;

        filteredRows.sort((a, b) => {
            let aValue, bValue;

            if (columnIndex === 0) { // Applicant name column
                aValue = a.dataset.name;
                bValue = b.dataset.name;
            } else if (columnIndex === 4) { // Applied date column
                aValue = new Date(a.dataset.applied).getTime();
                bValue = new Date(b.dataset.applied).getTime();
                return direction === 'asc' ? aValue - bValue : bValue - aValue;
            } else if (columnIndex === 1) { // Job title column
                aValue = a.dataset.jobTitle;
                bValue = b.dataset.jobTitle;
            } else {
                // Default text comparison
                aValue = a.querySelector(`td:nth-child(${columnIndex + 1})`).textContent.trim();
                bValue = b.querySelector(`td:nth-child(${columnIndex + 1})`).textContent.trim();
            }

            return direction === 'asc' ?
                String(aValue).localeCompare(String(bValue)) :
                String(bValue).localeCompare(String(aValue));
        });

        currentPage = 1;
        updatePagination();

        // Update sort icons
        document.querySelectorAll('th i.fas').forEach(icon => {
            icon.className = 'ml-1 fas fa-sort text-gray-400';
        });

        const currentIcon = document.querySelector(`th:nth-child(${columnIndex + 1}) i`);
        if (currentIcon) {
            currentIcon.className = `ml-1 fas fa-sort-${direction} text-gray-600`;
        }
    }

    // Export functionality
    function exportResults(format) {
        // Export all filtered results, not just current page
        const visibleData = filteredRows.map(row => {
            const cells = row.querySelectorAll('td');
            return {
                applicant: cells[0].textContent.trim(),
                job_title: cells[1].textContent.trim(),
                company: cells[2].textContent.trim(),
                status: cells[3].textContent.trim(),
                applied: cells[4].textContent.trim()
            };
        });

        if (format === 'csv') {
            exportToCSV(visibleData);
        }
    }

    function exportToCSV(data) {
        const headers = ['Applicant', 'Job Title', 'Company', 'Status', 'Applied'];
        const csvContent = [
            headers.join(','),
            ...data.map(row => [
                `"${row.applicant}"`,
                `"${row.job_title}"`,
                `"${row.company}"`,
                `"${row.status}"`,
                `"${row.applied}"`
            ].join(','))
        ].join('\n');

        const blob = new Blob([csvContent], {
            type: 'text/csv'
        });
        const url = window.URL.createObjectURL(blob);
        const link = document.createElement('a');
        link.href = url;
        link.download = `applications_${new Date().toISOString().split('T')[0]}.csv`;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        window.URL.revokeObjectURL(url);
    }

    // Application summary modal - FIXED MESSAGE
    function viewApplicationSummary(applicationId) {
        document.getElementById('modal-content').innerHTML = '<div class="py-4 text-center"><i class="text-gray-400 fas fa-spinner fa-spin"></i> Loading...</div>';
        document.getElementById('applicationModal').classList.remove('hidden');

        // Show concise message
        setTimeout(() => {
            document.getElementById('modal-content').innerHTML = `
                <div class="space-y-3">
                    <p><strong>Application ID:</strong> ${applicationId}</p>
                    <div class="p-3 rounded-lg bg-blue-50">
                        <p class="text-sm text-blue-800">
                            <i class="mr-2 fas fa-info-circle"></i>
                            Application details are private and only viewable by the employer and applicant.
                        </p>
                    </div>
                </div>
            `;
        }, 500);
    }

    function closeModal() {
        document.getElementById('applicationModal').classList.add('hidden');
    }
</script>