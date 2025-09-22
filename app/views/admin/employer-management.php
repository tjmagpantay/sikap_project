<div class="space-y-6">
    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">Employer Management</h1>
        <p class="mt-1 text-sm text-gray-600">Manage employer accounts and view statistics</p>
    </div>

    <!-- Employer Stats Cards - 6 cards in one row -->
    <div class="grid grid-cols-1 gap-4 mb-6 sm:gap-6 sm:mb-8 md:grid-cols-6">
        <!-- Card 1: Total Employers -->
        <div class="p-5 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-4">
            <div class="mb-3">
                <h3 class="mb-2 text-sm font-medium text-gray-700">Total Employers</h3>
                <div class="flex items-baseline">
                    <span class="text-xl font-bold text-blue-600 sm:text-2xl" data-stat="total"><?php echo count($users); ?></span>
                    <svg class="ml-1" width="12px" height="12px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke="#2563EB" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <p class="mt-1 text-xs text-gray-500">
                    All registered employers
                </p>
            </div>
        </div>

        <!-- Card 2: Incomplete -->
        <div class="p-5 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-4">
            <div class="mb-3">
                <h3 class="mb-2 text-sm font-medium text-gray-700">Incomplete</h3>
                <div class="flex items-baseline">
                    <span class="text-xl font-bold text-gray-600 sm:text-2xl" data-stat="incomplete">
                        <?php echo count(array_filter($users, function ($user) {
                            return $user['status'] === 'incomplete';
                        })); ?>
                    </span>
                    <svg class="ml-1" width="12px" height="12px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke="#6B7280" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <p class="mt-1 text-xs text-gray-500">
                    Profile setup incomplete
                </p>
            </div>
        </div>

        <!-- Card 3: Pending -->
        <div class="p-5 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-4">
            <div class="mb-3">
                <h3 class="mb-2 text-sm font-medium text-gray-700">Pending</h3>
                <div class="flex items-baseline">
                    <span class="text-xl font-bold text-orange-600 sm:text-2xl" data-stat="pending">
                        <?php echo count(array_filter($users, function ($user) {
                            return $user['status'] === 'pending_verification';
                        })); ?>
                    </span>
                    <svg class="ml-1" width="12px" height="12px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke="#EA580C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <p class="mt-1 text-xs text-gray-500">
                    Awaiting verification
                </p>
            </div>
        </div>

        <!-- Card 4: Verified -->
        <div class="p-5 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-4">
            <div class="mb-3">
                <h3 class="mb-2 text-sm font-medium text-gray-700">Verified</h3>
                <div class="flex items-baseline">
                    <span class="text-xl font-bold text-green-600 sm:text-2xl" data-stat="verified">
                        <?php echo count(array_filter($users, function ($user) {
                            return $user['status'] === 'verified';
                        })); ?>
                    </span>
                    <svg class="ml-1" width="12px" height="12px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 12L11 14L15 10M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="#059669" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <p class="mt-1 text-xs text-gray-500">
                    Successfully verified
                </p>
            </div>
        </div>

        <!-- Card 5: Rejected -->
        <div class="p-5 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-4">
            <div class="mb-3">
                <h3 class="mb-2 text-sm font-medium text-gray-700">Rejected</h3>
                <div class="flex items-baseline">
                    <span class="text-xl font-bold text-red-600 sm:text-2xl" data-stat="rejected">
                        <?php echo count(array_filter($users, function ($user) {
                            return $user['status'] === 'rejected';
                        })); ?>
                    </span>
                    <svg class="ml-1" width="12px" height="12px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10 14L12 12M12 12L14 10M12 12L10 10M12 12L14 14M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="#DC2626" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <p class="mt-1 text-xs text-gray-500">
                    Verification rejected
                </p>
            </div>
        </div>

        <!-- Card 6: Suspended -->
        <div class="p-5 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-4">
            <div class="mb-3">
                <h3 class="mb-2 text-sm font-medium text-gray-700">Suspended</h3>
                <div class="flex items-baseline">
                    <span class="text-xl font-bold text-yellow-600 sm:text-2xl" data-stat="suspended">
                        <?php echo count(array_filter($users, function ($user) {
                            return $user['status'] === 'suspended';
                        })); ?>
                    </span>
                    <svg class="ml-1" width="12px" height="12px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18.364 5.636L5.636 18.364M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="#D97706" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <p class="mt-1 text-xs text-gray-500">
                    Account suspended
                </p>
            </div>
        </div>
    </div>

    <!-- Search and Filter Controls - Same as jobseeker -->
    <div class="flex items-stretch w-full gap-3 mb-6">
        <!-- Search Input (Expanded width with right-side icon) -->
        <div class="flex-1">
            <div class="relative">
                <input
                    type="text"
                    id="searchInput"
                    placeholder="Search"
                    class="w-full px-4 py-3 pr-10 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary"
                    onkeyup="filterNavigation()">
                <svg class="absolute w-4 h-4 text-gray-400 transform -translate-y-1/2 pointer-events-none right-3 top-1/2"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m21 21-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
        </div>


        <!-- Status Filter (Expanded width) -->
        <div class="relative flex-1 min-w-32" x-data="{ open: false, selected: 'All Status' }">
            <button @click="open = !open"
                class="flex items-center justify-between w-full px-4 py-3 text-sm border border-gray-300 rounded-lg bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-primary/20">
                <span x-text="selected" class="truncate"></span>
                <i class="flex-shrink-0 ml-2 text-gray-400 fas fa-chevron-down" :class="{ 'rotate-180': open }"></i>
            </button>
            <div x-show="open" @click.away="open = false"
                class="absolute right-0 z-50 w-full mt-1 bg-white rounded-md shadow-lg min-w-40 ring-1 ring-black ring-opacity-5">
                <div class="py-1">
                    <a href="#" @click.prevent="selected = 'All Status'; filterByStatus(''); open = false"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">All Status</a>
                    <a href="#" @click.prevent="selected = 'Incomplete'; filterByStatus('incomplete'); open = false"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Incomplete</a>
                    <a href="#" @click.prevent="selected = 'Pending'; filterByStatus('pending_verification'); open = false"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Pending</a>
                    <a href="#" @click.prevent="selected = 'Verified'; filterByStatus('verified'); open = false"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Verified</a>
                    <a href="#" @click.prevent="selected = 'Rejected'; filterByStatus('rejected'); open = false"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Rejected</a>
                    <a href="#" @click.prevent="selected = 'Suspended'; filterByStatus('suspended'); open = false"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Suspended</a>
                </div>
            </div>
        </div>

        <!-- Location Filter (Expanded width) -->
        <div class="relative flex-1 min-w-32" x-data="{ open: false, selected: 'All Locations' }">
            <button @click="open = !open"
                class="flex items-center justify-between w-full px-4 py-3 text-sm border border-gray-300 rounded-lg bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-primary/20">
                <span x-text="selected" class="truncate"></span>
                <i class="flex-shrink-0 ml-2 text-gray-400 fas fa-chevron-down" :class="{ 'rotate-180': open }"></i>
            </button>
            <div x-show="open" @click.away="open = false"
                class="absolute right-0 z-50 w-full mt-1 bg-white rounded-md shadow-lg min-w-48 ring-1 ring-black ring-opacity-5">
                <div class="py-1">
                    <a href="#" @click.prevent="selected = 'All Locations'; filterByLocation(''); open = false"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">All Locations</a>
                    <a href="#" @click.prevent="selected = 'Rosario'; filterByLocation('rosario'); open = false"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Rosario</a>
                    <a href="#" @click.prevent="selected = 'Other Areas'; filterByLocation('other'); open = false"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Other Areas</a>
                </div>
            </div>
        </div>

        <!-- Action Buttons (Fixed width) -->
        <div class="flex flex-shrink-0 gap-2">
            <button onclick="clearAllFilters()"
                class="px-4 py-3 text-sm text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 whitespace-nowrap">
                <i class="mr-1 fas fa-times"></i> Clear
            </button>
            <button onclick="exportToPDF()"
                class="px-4 py-3 text-sm text-white rounded-lg bg-primary hover:bg-primary/90 whitespace-nowrap">
                <i class="mr-1 fas fa-file-pdf"></i> Export
            </button>
        </div>
    </div>

    <!-- All Employers -->
    <div>


        <?php if (empty($users)): ?>
            <div class="p-8 text-center bg-white border border-gray-200 rounded-lg" id="noUsersMessage">
                <i class="mb-4 text-4xl text-gray-400 fas fa-inbox"></i>
                <p class="text-gray-500">No employers found</p>
            </div>
        <?php else: ?>
            <!-- No Results Message (Hidden by default) -->
            <div class="hidden p-8 text-center bg-white border border-gray-200 rounded-lg" id="noResultsMessage">
                <i class="mb-4 text-4xl text-gray-400 fas fa-search"></i>
                <p class="text-gray-500">No employers match your search criteria</p>
                <button onclick="clearAllFilters()" class="mt-2 text-blue-600 hover:text-blue-900">Clear filters</button>
            </div>

            <div class="overflow-hidden bg-white border border-gray-200 rounded-lg shadow-sm" id="employersTable">
                <div class="overflow-x-auto">
                    <table class="w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Company</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Business Address</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Contact</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Representative</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Registered</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200" id="employersTableBody">
                            <?php foreach ($users as $user): ?>
                                <tr class="hover:bg-gray-50"
                                    data-status="<?php echo htmlspecialchars(strtolower($user['status'])); ?>"
                                    data-company="<?php echo htmlspecialchars(strtolower($user['company_name'] ?? '')); ?>"
                                    data-representative="<?php echo htmlspecialchars(strtolower(($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? ''))); ?>"
                                    data-location="<?php echo stripos($user['business_address'] ?? '', 'rosario') !== false ? 'rosario' : 'other'; ?>"
                                    data-date="<?php echo $user['created_at']; ?>">

                                    <!-- Company Name Column -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-xs text-gray-900">
                                            <?php
                                            $companyName = trim($user['company_name'] ?? '');
                                            if (empty($companyName)) {
                                                echo '<span class="italic text-gray-400">Not stated yet</span>';
                                            } else {
                                                echo htmlspecialchars($companyName);
                                            }
                                            ?>
                                        </div>
                                    </td>

                                    <!-- Business Address Column -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-xs text-gray-800">
                                            <?php
                                            $businessAddress = trim($user['business_address'] ?? '');
                                            if (empty($businessAddress)) {
                                                echo '<span class="italic text-gray-400">Not stated yet</span>';
                                            } else {
                                                echo htmlspecialchars($businessAddress);
                                            }
                                            ?>
                                        </div>
                                    </td>

                                    <!-- Contact Column -->
                                    <td class="px-6 py-4 text-xs text-gray-800 whitespace-nowrap">
                                        <?php
                                        $contactNo = trim($user['contact_no'] ?? '');
                                        if (empty($contactNo)) {
                                            echo '<span class="italic text-gray-400">Not stated yet</span>';
                                        } else {
                                            echo htmlspecialchars($contactNo);
                                        }
                                        ?>
                                    </td>

                                    <!-- Representative Column -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <?php
                                            $firstName = trim($user['first_name'] ?? '');
                                            $lastName = trim($user['last_name'] ?? '');
                                            $fullName = trim($firstName . ' ' . $lastName);

                                            if (empty($fullName) || $fullName === ' ') {
                                            ?>
                                                <div class="flex items-center justify-center w-8 h-8 mr-3 bg-gray-100 rounded-full">
                                                    <span class="text-xs font-medium text-gray-400">?</span>
                                                </div>
                                                <div class="text-xs italic text-gray-400">
                                                    Representative not assigned
                                                </div>
                                            <?php
                                            } else {
                                            ?>
                                                <div class="flex items-center justify-center w-8 h-8 mr-3 bg-gray-100 rounded-full">
                                                    <span class="text-xs font-medium text-gray-800">
                                                        <?php echo strtoupper(substr($firstName, 0, 1) . substr($lastName, 0, 1)); ?>
                                                    </span>
                                                </div>
                                                <div class="text-xs text-gray-800">
                                                    <?php echo htmlspecialchars($fullName); ?>
                                                </div>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </td>

                                    <!-- Status Column -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <?php
                                        $status = $user['status'] ?? 'unknown';
                                        $displayStatus = ucfirst(str_replace('_', ' ', $status));

                                        if (empty($status) || $status === 'unknown') {
                                        ?>
                                            <span class="inline-flex px-2 py-1 text-xs font-medium text-gray-500 bg-gray-100 rounded-md">
                                                Status pending
                                            </span>
                                        <?php
                                        } else {
                                            $statusClass = [
                                                'incomplete' => 'bg-gray-100 text-gray-500',
                                                'pending_verification' => 'bg-yellow-100 text-secondary',
                                                'verified' => 'bg-blue-100 text-primary',
                                                'rejected' => 'bg-red-100 text-red-800',
                                                'suspended' => 'bg-red-100 text-red-800'
                                            ];
                                            $cssClass = $statusClass[strtolower($status)] ?? 'bg-gray-100 text-gray-800';
                                        ?>
                                            <span class="inline-flex px-2 py-1 text-xs font-medium rounded-md <?php echo $cssClass; ?>">
                                                <?php echo $displayStatus; ?>
                                            </span>
                                        <?php
                                        }
                                        ?>
                                    </td>

                                    <!-- Registration Date Column -->
                                    <td class="px-6 py-4 text-xs text-gray-800 whitespace-nowrap">
                                        <?php
                                        $createdAt = $user['created_at'] ?? '';
                                        if (empty($createdAt) || $createdAt === '0000-00-00 00:00:00') {
                                            echo '<span class="italic text-gray-400">Date not recorded</span>';
                                        } else {
                                            try {
                                                echo date('M j, Y', strtotime($createdAt));
                                            } catch (Exception $e) {
                                                echo '<span class="italic text-gray-400">Invalid date</span>';
                                            }
                                        }
                                        ?>
                                    </td>

                                    <!-- Actions Column -->
                                    <td class="px-6 py-4 text-sm font-medium whitespace-nowrap">
                                        <div class="flex space-x-2">
                                            <?php
                                            // Only show action buttons if user has a valid ID and status
                                            if (isset($user['user_id']) && !empty($user['user_id']) && isset($user['status'])) {
                                                if (strtolower($user['status']) === 'suspended') {
                                            ?>
                                                    <button
                                                        class="flex items-center px-3 py-2 text-xs text-white border rounded-md bg-primary hover:bg-primary/90 unsuspend-btn"
                                                        data-id="<?php echo $user['user_id']; ?>">
                                                        <i class="mr-1 fas fa-ban"></i>
                                                        <span>Unsuspend</span>
                                                    </button>
                                                <?php
                                                } else {
                                                ?>
                                                    <button
                                                        class="flex items-center px-3 py-2 text-xs text-white border rounded-md bg-primary suspend-btn hover:bg-primary/90"
                                                        data-id="<?php echo $user['user_id']; ?>">
                                                        <i class="mr-1 fas fa-ban"></i>
                                                        <span>Suspend</span>
                                                    </button>
                                                <?php
                                                }
                                            } else {
                                                ?>
                                                <span class="text-xs italic text-gray-400">No actions available</span>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </td>

                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination - Same as jobseeker -->
                <div class="flex items-center justify-between px-6 py-3 border-t border-gray-200 bg-gray-50">
                    <div class="flex items-center gap-1 text-sm text-gray-700">
                        <span>
                            Showing <span class="font-semibold" id="startItem">1</span>
                            to <span class="font-semibold" id="endItem">10</span>
                            of <span class="font-medium" id="totalItems">0</span> results
                        </span>
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

<!-- Updated JavaScript with pagination -->
<script>
    // Pagination variables
    let currentPage = 1;
    const itemsPerPage = 10;
    let allRows = [];
    let filteredRows = [];
    let currentFilters = {
        status: '',
        location: '',
        date: ''
    };

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        allRows = Array.from(document.querySelectorAll('#employersTableBody tr'));
        filteredRows = [...allRows];
        updateCounts();
        initializePagination();
        attachButtonListeners();

        // Add search event listener with debouncing
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            let searchTimeout;
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    applyFilters();
                }, 300); // 300ms debounce
            });

            // Also search on Enter key
            searchInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    clearTimeout(searchTimeout);
                    applyFilters();
                }
            });
        }
    });

    // Enhanced apply filters function
    function applyFilters() {
        const searchValue = document.getElementById('searchInput').value.toLowerCase().trim();

        filteredRows = allRows.filter(row => {
            // Get all searchable data
            const company = row.getAttribute('data-company') || '';
            const representative = row.getAttribute('data-representative') || '';
            const status = row.getAttribute('data-status') || '';
            const location = row.getAttribute('data-location') || '';

            // Get cell text content for additional searching
            const cells = row.querySelectorAll('td');
            const companyText = cells[0]?.textContent.toLowerCase() || '';
            const addressText = cells[1]?.textContent.toLowerCase() || '';
            const contactText = cells[2]?.textContent.toLowerCase() || '';
            const representativeText = cells[3]?.textContent.toLowerCase() || '';
            const statusText = cells[4]?.textContent.toLowerCase() || '';
            const dateText = cells[5]?.textContent.toLowerCase() || '';

            // Enhanced search matching
            const searchMatch = !searchValue ||
                company.includes(searchValue) ||
                representative.includes(searchValue) ||
                companyText.includes(searchValue) ||
                addressText.includes(searchValue) ||
                contactText.includes(searchValue) ||
                representativeText.includes(searchValue) ||
                statusText.includes(searchValue) ||
                dateText.includes(searchValue);

            // Status filter
            const statusMatch = !currentFilters.status || status === currentFilters.status.toLowerCase();

            // Location filter
            const locationMatch = !currentFilters.location || location === currentFilters.location.toLowerCase();

            // Date filter
            const dateMatch = !currentFilters.date || matchesDateFilter(row.getAttribute('data-date'), currentFilters.date);

            return searchMatch && statusMatch && locationMatch && dateMatch;
        });

        // Reset to first page when filters change
        currentPage = 1;
        updatePagination();
        updateCounts();
        updateResultsMessage();
        updateStatusCounts();

        // Highlight search terms
        highlightSearchTerms(searchValue);
    }

    // Function to highlight search terms in results
    function highlightSearchTerms(searchValue) {
        // Remove existing highlights first
        document.querySelectorAll('.search-highlight').forEach(el => {
            const parent = el.parentNode;
            parent.replaceChild(document.createTextNode(el.textContent), el);
            parent.normalize();
        });

        if (!searchValue) return;

        filteredRows.forEach(row => {
            if (row.style.display !== 'none') {
                const cells = row.querySelectorAll('td');
                cells.forEach(cell => {
                    highlightTextInElement(cell, searchValue);
                });
            }
        });
    }

    function highlightTextInElement(element, searchValue) {
        const walker = document.createTreeWalker(
            element,
            NodeFilter.SHOW_TEXT,
            null,
            false
        );

        const textNodes = [];
        let node;
        while (node = walker.nextNode()) {
            textNodes.push(node);
        }

        textNodes.forEach(textNode => {
            const text = textNode.textContent;
            const regex = new RegExp(`(${escapeRegExp(searchValue)})`, 'gi');

            if (regex.test(text)) {
                const highlightedText = text.replace(regex, '<span class="search-highlight" style="background-color: #fef08a; font-weight: 600;">$1</span>');
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = highlightedText;

                while (tempDiv.firstChild) {
                    textNode.parentNode.insertBefore(tempDiv.firstChild, textNode);
                }
                textNode.parentNode.removeChild(textNode);
            }
        });
    }

    function escapeRegExp(string) {
        return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
    }

    // Enhanced updateCounts function
    function updateCounts() {
        const totalCount = allRows.length;
        const visibleCount = filteredRows.length;

        // Update total items in pagination info
        const totalItemsElement = document.getElementById('totalItems');
        if (totalItemsElement) {
            totalItemsElement.textContent = visibleCount;
        }

        // Show search results info
        const searchInput = document.getElementById('searchInput');
        if (searchInput && searchInput.value.trim()) {
            console.log(`Search "${searchInput.value.trim()}" found ${visibleCount} of ${totalCount} employers`);
        }
    }

    // Enhanced updateResultsMessage function
    function updateResultsMessage() {
        const noResultsMessage = document.getElementById('noResultsMessage');
        const employersTable = document.getElementById('employersTable');
        const searchInput = document.getElementById('searchInput');

        if (filteredRows.length === 0 && allRows.length > 0) {
            noResultsMessage.classList.remove('hidden');
            employersTable.classList.add('hidden');

            // Update no results message based on search or filters
            const noResultsText = noResultsMessage.querySelector('p');
            if (searchInput && searchInput.value.trim()) {
                noResultsText.textContent = `No employers found for "${searchInput.value.trim()}"`;
            } else {
                noResultsText.textContent = "No employers match your search criteria";
            }
        } else {
            noResultsMessage.classList.add('hidden');
            employersTable.classList.remove('hidden');
        }
    }

    // Enhanced clearAllFilters function
    function clearAllFilters() {
        // Clear search input
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.value = '';
        }

        // Reset current filters
        currentFilters = {
            status: '',
            location: '',
            date: ''
        };

        // Reset pagination
        currentPage = 1;

        // Reset Alpine.js dropdown selections
        setTimeout(() => {
            const dropdowns = document.querySelectorAll('[x-data]');
            dropdowns.forEach(dropdown => {
                if (dropdown._x_dataStack && dropdown._x_dataStack[0].selected) {
                    const originalSelected = dropdown._x_dataStack[0].selected;
                    if (originalSelected.includes('Status')) dropdown._x_dataStack[0].selected = 'All Status';
                    if (originalSelected.includes('Location')) dropdown._x_dataStack[0].selected = 'All Locations';
                }
            });
        }, 100);

        applyFilters();
    }

    // Add keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Focus search input when Ctrl+F is pressed
        if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
            e.preventDefault();
            const searchInput = document.getElementById('searchInput');
            if (searchInput) {
                searchInput.focus();
                searchInput.select();
            }
        }

        // Clear filters when Escape is pressed
        if (e.key === 'Escape') {
            const searchInput = document.getElementById('searchInput');
            if (searchInput && document.activeElement === searchInput) {
                clearAllFilters();
                searchInput.blur();
            }
        }
    });

    // Rest of your existing functions remain the same...
    // (matchesDateFilter, initializePagination, updatePagination, etc.)

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

    // Pagination Functions
    function initializePagination() {
        updatePagination();
    }

    function updatePagination() {
        const totalPages = Math.ceil(filteredRows.length / itemsPerPage);

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

        document.getElementById('totalItems').textContent = filteredRows.length;
        document.getElementById('startItem').textContent = filteredRows.length > 0 ? startIndex : 0;
        document.getElementById('endItem').textContent = endIndex;
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

    // Filter functions
    function filterByStatus(status) {
        currentFilters.status = status;
        applyFilters();
    }

    function filterByLocation(location) {
        currentFilters.location = location;
        applyFilters();
    }

    function filterByDate(dateRange) {
        currentFilters.date = dateRange;
        applyFilters();
    }

    function updateStatusCounts() {
        const counts = {
            total: filteredRows.length,
            incomplete: 0,
            pending: 0,
            verified: 0,
            rejected: 0,
            suspended: 0
        };

        filteredRows.forEach(row => {
            const status = row.getAttribute('data-status');
            if (status === 'incomplete') counts.incomplete++;
            if (status === 'pending_verification') counts.pending++;
            if (status === 'verified') counts.verified++;
            if (status === 'rejected') counts.rejected++;
            if (status === 'suspended') counts.suspended++;
        });

        // Update the stats cards
        document.querySelector('[data-stat="total"]').textContent = counts.total;
        document.querySelector('[data-stat="incomplete"]').textContent = counts.incomplete;
        document.querySelector('[data-stat="pending"]').textContent = counts.pending;
        document.querySelector('[data-stat="verified"]').textContent = counts.verified;
        document.querySelector('[data-stat="rejected"]').textContent = counts.rejected;
        document.querySelector('[data-stat="suspended"]').textContent = counts.suspended;
    }

    // Export functionality
    function exportToPDF() {
        const printWindow = window.open('', '', 'height=600,width=800');

        printWindow.document.write('<html><head><title>Employers Report</title>');
        printWindow.document.write('<style>');
        printWindow.document.write(`
            table { border-collapse: collapse; width: 100%; margin-bottom: 1rem; }
            th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
            th { background-color: #f8f9fa; }
            .header { margin-bottom: 20px; text-align: center; }
            .header h1 { margin: 0; color: #092C4C; }
            .status-verified { color: #059669; }
            .status-suspended { color: #DC2626; }
            .date { color: #666; font-size: 12px; }
        `);
        printWindow.document.write('</style></head><body>');

        printWindow.document.write(`
            <div class="header">
                <h1>SIKAP - Employers Report</h1>
                <p class="date">Generated on: ${new Date().toLocaleString()}</p>
                <p class="date">Total Results: ${filteredRows.length} employers</p>
            </div>
        `);

        printWindow.document.write('<table><thead><tr>');
        const headers = ['Company Name', 'Business Address', 'Contact', 'Representative', 'Status', 'Registration Date'];
        headers.forEach(header => {
            printWindow.document.write(`<th>${header}</th>`);
        });
        printWindow.document.write('</tr></thead><tbody>');

        filteredRows.forEach(row => {
            const cells = row.querySelectorAll('td');
            printWindow.document.write('<tr>');
            for (let i = 0; i < 6; i++) {
                if (i === 4) {
                    const status = cells[i].textContent.trim();
                    printWindow.document.write(`
                        <td class="status-${status.toLowerCase()}">
                            ${status}
                        </td>
                    `);
                } else {
                    printWindow.document.write(`<td>${cells[i].textContent.trim()}</td>`);
                }
            }
            printWindow.document.write('</tr>');
        });

        printWindow.document.write('</tbody></table>');
        printWindow.document.write('</body></html>');
        printWindow.document.close();

        printWindow.onload = function() {
            printWindow.focus();
            printWindow.print();
        };
    }

    // Enhanced suspend/unsuspend functionality
    function handleStatusChange(action, userId, button) {
        button.disabled = true;
        const originalText = button.innerHTML;
        button.innerHTML = '<i class="mr-1 fas fa-spinner fa-spin"></i>Processing...';

        const formData = new FormData();
        formData.append('user_id', userId);
        formData.append('action', action);
        formData.append('user_type', 'employer');

        fetch('index.php?page=update-employer-status', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                // Check if response is ok
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                // Get response text first
                return response.text();
            })
            .then(responseText => {
                console.log('Server response:', responseText); // Debug log

                // Try to parse as JSON
                let data;
                try {
                    data = JSON.parse(responseText);
                } catch (e) {
                    console.error('JSON parse error:', e);
                    console.error('Response text:', responseText);

                    // Check if the response contains success indicators (even if not JSON)
                    if (responseText.includes('success') || responseText.includes('updated') || responseText.includes('suspended') || responseText.includes('unsuspended')) {
                        // If response suggests success but isn't JSON, treat as success
                        data = {
                            success: true,
                            message: `Employer ${action}ed successfully`
                        };
                    } else {
                        throw new Error('Invalid server response format');
                    }
                }

                if (data.success === true || data.success === 'true' || data.status === 'success') {
                    const row = button.closest('tr');
                    const statusCell = row.querySelector('td:nth-child(5) span');
                    const actionCell = row.querySelector('td:last-child div');

                    // Update data-status attribute
                    row.setAttribute('data-status', action === 'suspend' ? 'suspended' : 'verified');

                    // Update status badge
                    statusCell.className = `inline-flex px-2 py-1 text-xs font-medium rounded-md ${
                        action === 'suspend' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-primary'
                    }`;
                    statusCell.textContent = action === 'suspend' ? 'Suspended' : 'Verified';

                    // Update action button
                    if (action === 'suspend') {
                        actionCell.innerHTML = `
                            <button class="flex items-center px-3 py-2 text-xs text-white border rounded-md bg-primary unsuspend-btn" data-id="${userId}">
                                <i class="mr-1 fas fa-ban"></i>
                                <span>Unsuspend</span>
                            </button>
                        `;
                    } else {
                        actionCell.innerHTML = `
                            <button class="flex items-center px-3 py-2 text-xs text-white border rounded-md bg-primary suspend-btn" data-id="${userId}">
                                <i class="mr-1 fas fa-ban"></i>
                                <span>Suspend</span>
                            </button>
                        `;
                    }

                    updateStatusCounts();
                    attachButtonListeners();

                    // Show success message
                    showSuccessMessage(`Employer ${action}ed successfully!`);

                } else {
                    throw new Error(data.error || data.message || `Failed to ${action} employer`);
                }
            })
            .catch(error => {
                console.error('Error details:', error);

                // More user-friendly error handling
                let errorMessage = 'An error occurred while updating status. Please try again.';

                if (error.message.includes('HTTP error')) {
                    errorMessage = 'Server error occurred. Please check your connection and try again.';
                } else if (error.message.includes('JSON parse')) {
                    errorMessage = 'Server response format error. The action may have succeeded - please refresh the page to verify.';
                } else if (error.message) {
                    errorMessage = error.message;
                }

                alert(errorMessage);

                // Reset button state
                button.disabled = false;
                button.innerHTML = originalText;
            });
    }

    // Add this function for success messages
    function showSuccessMessage(message) {
        // Remove existing success messages
        const existingMessages = document.querySelectorAll('.success-message');
        existingMessages.forEach(msg => msg.remove());

        // Create new success message
        const messageDiv = document.createElement('div');
        messageDiv.className = 'success-message fixed top-20 right-4 z-50 px-4 py-3 bg-green-100 border border-green-200 text-green-800 rounded-lg shadow-lg transition-all duration-300';
        messageDiv.innerHTML = `
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                ${message}
            </div>
        `;

        document.body.appendChild(messageDiv);

        // Auto remove after 3 seconds
        setTimeout(() => {
            messageDiv.style.opacity = '0';
            messageDiv.style.transform = 'translateX(100%)';
            setTimeout(() => messageDiv.remove(), 300);
        }, 3000);
    }

    // Enhanced button listeners with better error handling
    function attachButtonListeners() {
        // Remove existing listeners first
        document.querySelectorAll('.suspend-btn').forEach(button => {
            button.replaceWith(button.cloneNode(true));
        });
        document.querySelectorAll('.unsuspend-btn').forEach(button => {
            button.replaceWith(button.cloneNode(true));
        });

        // Add new listeners
        document.querySelectorAll('.suspend-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                if (confirm('Are you sure you want to suspend this employer?')) {
                    const userId = this.getAttribute('data-id');
                    if (userId) {
                        handleStatusChange('suspend', userId, this);
                    } else {
                        alert('Error: User ID not found');
                    }
                }
            });
        });

        document.querySelectorAll('.unsuspend-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                if (confirm('Are you sure you want to unsuspend this employer?')) {
                    const userId = this.getAttribute('data-id');
                    if (userId) {
                        handleStatusChange('unsuspend', userId, this);
                    } else {
                        alert('Error: User ID not found');
                    }
                }
            });
        });
    }
</script>