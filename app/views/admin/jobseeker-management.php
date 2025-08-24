<div class="flex h-screen">
    <!-- Sidebar -->
    <?php include __DIR__ . '/components/sidebar.php'; ?>

    <!-- Main Content Area -->
    <div class="flex flex-col flex-1 overflow-hidden">
        <!-- Top Navigation -->
        <?php include __DIR__ . '/components/topbar.php'; ?>

        <!-- Main Content Area -->
        <main class="flex-1 overflow-y-auto bg-gray-50">
            <div class="p-6">
                <!-- Improved Stats Cards -->
                <div class="grid grid-cols-1 gap-4 mb-6 sm:gap-6 sm:mb-8 md:grid-cols-4">
                    <!-- Card 1: Total Jobseekers -->
                    <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-6">
                        <div class="mb-4 sm:mb-6">
                            <h3 class="mb-3 text-sm font-medium text-gray-700 sm:mb-4">Total Jobseekers</h3>
                            <div class="flex items-baseline">
                                <span class="text-2xl font-bold text-gray-900 sm:text-3xl" id="totalCount"><?php echo count($users); ?></span>
                                <svg class="ml-1 sm:ml-2" width="14px" height="14px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path d="M17.5 18H18.7687C19.2035 18 19.4209 18 19.5817 17.9473C20.1489 17.7612 20.5308 17.1231 20.498 16.4163C20.4887 16.216 20.42 15.9676 20.2825 15.4708C20.168 15.0574 20.1108 14.8507 20.0324 14.6767C19.761 14.0746 19.2766 13.6542 18.7165 13.5346C18.5546 13.5 18.3737 13.5 18.0118 13.5L15.5 13.5346M14.6899 11.6996C15.0858 11.892 15.5303 12 16 12C17.6569 12 19 10.6569 19 9C19 7.34315 17.6569 6 16 6C15.7295 6 15.4674 6.0358 15.2181 6.10291M13.5 8C13.5 10.2091 11.7091 12 9.5 12C7.29086 12 5.5 10.2091 5.5 8C5.5 5.79086 7.29086 4 9.5 4C11.7091 4 13.5 5.79086 13.5 8ZM6.81765 14H12.1824C12.6649 14 12.9061 14 13.1219 14.0461C13.8688 14.2056 14.5147 14.7661 14.8765 15.569C14.9811 15.8009 15.0574 16.0765 15.21 16.6278C15.3933 17.2901 15.485 17.6213 15.4974 17.8884C15.5411 18.8308 15.0318 19.6817 14.2756 19.9297C14.0613 20 13.7714 20 13.1916 20H5.80844C5.22864 20 4.93875 20 4.72441 19.9297C3.96818 19.6817 3.45888 18.8308 3.50261 17.8884C3.51501 17.6213 3.60668 17.2901 3.79003 16.6278C3.94262 16.0765 4.01891 15.8009 4.12346 15.569C4.4853 14.7661 5.13116 14.2056 5.87806 14.0461C6.09387 14 6.33513 14 6.81765 14Z" stroke="#2563EB" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </g>
                                </svg>
                            </div>
                            <p class="mt-2 text-xs text-gray-500">
                                All registered jobseekers in the system
                            </p>
                        </div>
                    </div>

                    <!-- Card 2: Active Jobseekers -->
                    <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-6">
                        <div class="mb-4 sm:mb-6">
                            <h3 class="mb-3 text-sm font-medium text-gray-700 sm:mb-4">Active</h3>
                            <div class="flex items-baseline">
                                <span class="text-2xl font-bold text-gray-900 sm:text-3xl" id="activeCount">
                                    <?php echo count(array_filter($users, function ($user) {
                                        return ($user['status'] ?? 'active') === 'active';
                                    })); ?>
                                </span>
                                <svg class="ml-1 sm:ml-2" width="14px" height="14px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path d="M16 7C16 9.20914 14.2091 11 12 11C9.79086 11 8 9.20914 8 7C8 4.79086 9.79086 3 12 3C14.2091 3 16 4.79086 16 7Z" stroke="#059669" stroke-width="1.5" />
                                        <path d="M12 14C8.13401 14 5 17.134 5 21H19C19 17.134 15.866 14 12 14Z" stroke="#059669" stroke-width="1.5" />
                                        <path d="M17 12L19 14L23 10" stroke="#059669" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </g>
                                </svg>
                            </div>
                            <p class="mt-2 text-xs text-gray-500">
                                Currently active jobseekers
                            </p>
                        </div>
                    </div>

                    <!-- Card 3: From Rosario -->
                    <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-6">
                        <div class="mb-4 sm:mb-6">
                            <h3 class="mb-3 text-sm font-medium text-gray-700 sm:mb-4">From Rosario</h3>
                            <div class="flex items-baseline">
                                <span class="text-2xl font-bold text-gray-900 sm:text-3xl">
                                    <?php echo count(array_filter($users, function ($user) {
                                        return stripos($user['address'], 'rosario') !== false;
                                    })); ?>
                                </span>
                                <svg class="ml-1 sm:ml-2" width="14px" height="14px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path d="M12 2C16.8706 2 21 6.03298 21 10.9258C21 15.8965 16.8033 19.3847 12.927 21.7567C12.6445 21.9162 12.325 22 12 22C11.675 22 11.3555 21.9162 11.073 21.7567C7.2039 19.3616 3 15.9137 3 10.9258C3 6.03298 7.12944 2 12 2Z" stroke="#EA580C" stroke-width="1.5" />
                                        <path d="M15 11C15 12.6569 13.6569 14 12 14C10.3431 14 9 12.6569 9 11C9 9.34315 10.3431 8 12 8C13.6569 8 15 9.34315 15 11Z" stroke="#EA580C" stroke-width="1.5" />
                                    </g>
                                </svg>
                            </div>
                            <p class="mt-2 text-xs text-gray-500">
                                Jobseekers from Rosario area
                            </p>
                        </div>
                    </div>

                    <!-- Card 4: Other Areas -->
                    <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-6">
                        <div class="mb-4 sm:mb-6">
                            <h3 class="mb-3 text-sm font-medium text-gray-700 sm:mb-4">Other Areas</h3>
                            <div class="flex items-baseline">
                                <span class="text-2xl font-bold text-gray-900 sm:text-3xl">
                                    <?php echo count(array_filter($users, function ($user) {
                                        return stripos($user['address'], 'rosario') === false;
                                    })); ?>
                                </span>
                                <svg class="ml-1 sm:ml-2" width="14px" height="14px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path d="M3 12C3 4.5885 4.5885 3 12 3C19.4115 3 21 4.5885 21 12C21 19.4115 19.4115 21 12 21C4.5885 21 3 19.4115 3 12Z" stroke="#6B7280" stroke-width="1.5" />
                                        <path d="M7.5 8C7.77614 7.67386 8.12386 7.32614 8.5 7.5M12 7V12H16.5M8.5 16.5C8.12386 16.6739 7.77614 16.3261 7.5 16M16.5 8C16.2239 7.67386 15.8761 7.32614 15.5 7.5M16.5 16C16.2239 16.3261 15.8761 16.6739 15.5 16.5" stroke="#6B7280" stroke-width="1.5" stroke-linecap="round" />
                                        <path d="M12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15Z" stroke="#6B7280" stroke-width="1.5" />
                                    </g>
                                </svg>
                            </div>
                            <p class="mt-2 text-xs text-gray-500">
                                Jobseekers from outside Rosario
                            </p>
                        </div>
                    </div>
                </div>
                <!-- End Stats Cards -->

                <!-- Search and Filter Section -->
                <div class="relative px-6 py-4 mb-6 bg-white shadow-sm sm:px-6 lg:px-6 rounded-xl">
                    <div class="flex flex-col gap-6 mx-auto">
                        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:gap-3">

                            <!-- Search Jobseekers (Much Wider) -->
                            <div class="w-full lg:w-80">
                                <div class="relative">
                                    <input type="text" id="searchInput"
                                        class="w-full px-4 py-3 pr-12 text-sm transition-all duration-200 bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary"
                                        placeholder="Search .">

                                </div>
                            </div>

                            <!-- Location Filter -->
                            <div class="w-full lg:w-40" x-data="{ open: false, selected: 'Location' }">
                                <button @click="open = !open"
                                    @click.away="open = false"
                                    class="flex items-center justify-between w-full px-4 py-3 pr-12 text-sm text-gray-700 transition-all duration-200 bg-white border border-gray-300 rounded-lg shadow-sm appearance-none hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
                                    <span x-text="selected"></span>
                                    <svg class="w-4 h-4 ml-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                                    class="absolute left-0 z-50 w-48 mt-2 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5"
                                    x-cloak>
                                    <div class="py-1">
                                        <button @click="selected = 'All Locations'; open = false; filterByLocation('')"
                                            class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            All Locations
                                        </button>
                                        <button @click="selected = 'Rosario'; open = false; filterByLocation('rosario')"
                                            class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            Rosario
                                        </button>
                                        <button @click="selected = 'Other Areas'; open = false; filterByLocation('other')"
                                            class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            Other Areas
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Status Filter -->
                            <div class="w-full lg:w-36" x-data="{ open: false, selected: 'Status' }">
                                <button @click="open = !open"
                                    @click.away="open = false"
                                    class="flex items-center justify-between w-full px-4 py-3 pr-12 text-sm text-gray-700 transition-all duration-200 bg-white border border-gray-300 rounded-lg shadow-sm appearance-none hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
                                    <span x-text="selected"></span>
                                    <svg class="w-4 h-4 ml-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                                    class="absolute left-0 z-50 w-48 mt-2 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5"
                                    x-cloak>
                                    <div class="py-1">
                                        <button @click="selected = 'All Status'; open = false; filterByStatus('')"
                                            class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            All Status
                                        </button>
                                        <button @click="selected = 'Active'; open = false; filterByStatus('active')"
                                            class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            Active
                                        </button>
                                        <button @click="selected = 'Inactive'; open = false; filterByStatus('inactive')"
                                            class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            Inactive
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Date Filter -->
                            <div class="w-full lg:w-40" x-data="{ open: false, selected: 'Date Range' }">
                                <button @click="open = !open"
                                    @click.away="open = false"
                                    class="flex items-center justify-between w-full px-4 py-3 pr-12 text-sm text-gray-700 transition-all duration-200 bg-white border border-gray-300 rounded-lg shadow-sm appearance-none hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
                                    <span x-text="selected"></span>
                                    <svg class="w-4 h-4 ml-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                                    class="absolute left-0 z-50 w-48 mt-2 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5"
                                    x-cloak>
                                    <div class="py-1">
                                        <button @click="selected = 'All Time'; open = false; filterByDate('')"
                                            class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            All Time
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
                            <div class="flex gap-2 lg:flex-shrink-0">
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

                <!-- All Jobseekers -->
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-900">All Jobseekers</h2>
                        <div class="flex items-center space-x-2">
                            <span class="px-3 py-1 text-sm bg-blue-100 rounded-sm text-primary" id="visibleCount">
                                <?php echo count($users); ?> visible
                            </span>
                        </div>
                    </div>

                    <?php if (empty($users)): ?>
                        <div class="p-8 text-center bg-white border border-gray-200 rounded-lg" id="noUsersMessage">
                            <i class="mb-4 text-4xl text-gray-400 fas fa-inbox"></i>
                            <p class="text-gray-500">No jobseekers found</p>
                        </div>
                    <?php else: ?>
                        <!-- No Results Message (Hidden by default) -->
                        <div class="hidden p-8 text-center bg-white border border-gray-200 rounded-lg" id="noResultsMessage">
                            <i class="mb-4 text-4xl text-gray-400 fas fa-search"></i>
                            <p class="text-gray-500">No jobseekers match your search criteria</p>
                        </div>

                        <div class="overflow-hidden bg-white border border-gray-200 rounded-lg shadow-sm" id="jobseekersTable">
                            <table class="w-full divide-y divide-gray-200 table-auto">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase cursor-pointer hover:bg-gray-100" onclick="sortTable(0)">
                                            Name <i class="ml-1 text-gray-400 fas fa-sort"></i>
                                        </th>
                                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Contact</th>
                                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Sex</th>
                                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Address</th>
                                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Applications</th>
                                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase cursor-pointer hover:bg-gray-100" onclick="sortTable(5)">
                                            Registered <i class="ml-1 text-gray-400 fas fa-sort"></i>
                                        </th>
                                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200" id="jobseekersTableBody">
                                    <?php foreach ($users as $user): ?>
                                        <tr class="hover:bg-gray-50"
                                            data-name="<?php echo htmlspecialchars(strtolower($user['first_name'] . ' ' . $user['middle_name'] . ' ' . $user['last_name'] . ' ' . $user['suffix'])); ?>"
                                            data-address="<?php echo htmlspecialchars(strtolower($user['address'])); ?>"
                                            data-date="<?php echo $user['created_at']; ?>">
                                            <!-- Name column -->
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex items-center justify-center w-8 h-8 mr-3 bg-gray-100 rounded-full">
                                                        <span class="text-xs font-medium text-gray-600">
                                                            <?php echo strtoupper(substr($user['first_name'], 0, 1) . substr($user['last_name'], 0, 1)); ?>
                                                        </span>
                                                    </div>
                                                    <div class="text-sm font-medium text-gray-900">
                                                        <?php echo htmlspecialchars($user['first_name'] . ' ' . $user['middle_name'] . ' ' . $user['last_name'] . ' ' . $user['suffix']); ?>
                                                    </div>
                                                </div>
                                            </td>

                                            <!-- Contact column -->
                                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                <div class="flex items-center">

                                                    <?php echo htmlspecialchars($user['contact_no']); ?>
                                                </div>
                                            </td>

                                            <!-- Sex column -->
                                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                <?php
                                                $sex = strtolower($user['sex'] ?? '');
                                                if ($sex === 'male'): ?>
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-sm text-xs font-medium bg-blue-100 text-blue-800">
                                                        <i class="mr-1 fas fa-mars"></i>
                                                        Male
                                                    </span>
                                                <?php elseif ($sex === 'female'): ?>
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-sm text-xs font-medium bg-red-100 text-red-800">
                                                        <i class="mr-1 fas fa-venus"></i>
                                                        Female
                                                    </span>
                                                <?php else: ?>
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-sm text-xs font-medium bg-gray-100 text-gray-600">
                                                        N/A
                                                    </span>
                                                <?php endif; ?>
                                            </td>

                                            <!-- Address column -->
                                            <td class="max-w-xs px-6 py-4 text-sm text-gray-500 truncate whitespace-nowrap" title="<?php echo htmlspecialchars($user['address']); ?>">
                                                <div class="flex items-center">

                                                    <span class="inline-flex items-center px-2 py-1 text-sm font-medium rounded-full <?php echo stripos($user['address'], 'rosario') !== false ? 'bg-orange-100 text-orange-800' : 'bg-gray-100 text-gray-800'; ?>">
                                                        <?php echo htmlspecialchars($user['address']); ?>
                                                    </span>
                                                </div>
                                            </td>

                                            <!-- Applications column -->
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <?php if (isset($user['job_applications'])): ?>
                                                    <div class="flex flex-wrap gap-1">
                                                        <?php foreach ($user['job_applications'] as $application): ?>
                                                            <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full 
                                                                    <?php
                                                                    $statusClass = match ($application['application_status']) {
                                                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                                                        'shortlisted' => 'bg-blue-100 text-blue-800',
                                                                        'interviewed' => 'bg-purple-100 text-purple-800',
                                                                        'hired' => 'bg-green-100 text-green-800',
                                                                        'rejected' => 'bg-red-100 text-red-800',
                                                                        default => 'bg-gray-100 text-gray-800'
                                                                    };
                                                                    echo $statusClass;
                                                                    ?>">
                                                                <?php echo ucfirst($application['application_status']); ?>
                                                            </span>
                                                        <?php endforeach; ?>
                                                    </div>
                                                <?php else: ?>
                                                    <span class="text-sm text-gray-500">No applications</span>
                                                <?php endif; ?>
                                            </td>

                                            <!-- Registered column -->
                                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                <div class="flex items-center">

                                                    <?php echo date('M j, Y', strtotime($user['created_at'])); ?>
                                                </div>
                                            </td>

                                            <!-- Actions column -->
                                            <td class="px-6 py-4 text-xs font-medium whitespace-nowrap">
                                                <button class="px-2 py-2 text-gray-600 bg-gray-100 hover:text-gray-900" disabled title="Block User">
                                                    <i class="mr-1 fas fa-ban"></i>Disable
                                                </button>
                        </div>
                        </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="py-4 border-t border-gray-200 " id="paginationContainer">
                    <div class="flex items-center justify-between">
                        <!-- Left side: Results info -->
                        <div class="text-sm text-gray-700" id="paginationInfo">
                            Showing <span id="showingStart">1</span> to <span id="showingEnd">10</span> of <span id="totalResults"><?php echo count($users); ?></span> jobseekers
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
            <?php endif; ?>
            </div>
        </main>
    </div>
</div>

<!-- Mobile Menu Overlay -->
<div id="mobile-menu-overlay" class="fixed inset-0 z-40 hidden bg-black bg-opacity-50 lg:hidden"></div>

<script>
    let allRows = [];
    let filteredRows = [];
    let currentFilters = {
        location: '',
        status: '',
        date: ''
    };

    // Pagination variables
    let currentPage = 1;
    const itemsPerPage = 10;
    let totalPages = 1;

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        allRows = Array.from(document.querySelectorAll('#jobseekersTableBody tr'));
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
        applyFilters();
    });

    // New Alpine.js dropdown filter functions
    function filterByLocation(location) {
        currentFilters.location = location;
        applyFilters();
    }

    function filterByStatus(status) {
        currentFilters.status = status;
        applyFilters();
    }

    function filterByDate(dateRange) {
        currentFilters.date = dateRange;
        applyFilters();
    }

    function applyFilters() {
        const searchValue = document.getElementById('searchInput').value.toLowerCase();

        filteredRows = allRows.filter(row => {
            const text = row.textContent.toLowerCase();
            const address = row.getAttribute('data-address').toLowerCase();

            // Search filter
            const searchMatch = !searchValue || text.includes(searchValue);

            // Location filter
            let locationMatch = true;
            if (currentFilters.location === 'rosario') {
                locationMatch = address.includes('rosario');
            } else if (currentFilters.location === 'other') {
                locationMatch = !address.includes('rosario');
            }

            // Status filter (placeholder - you may need to add data-status attributes)
            let statusMatch = true;
            if (currentFilters.status) {
                // Add your status filtering logic here
                // statusMatch = row.getAttribute('data-status') === currentFilters.status;
            }

            // Date filter
            const dateMatch = !currentFilters.date || matchesDateFilter(row.getAttribute('data-date'), currentFilters.date);

            return searchMatch && locationMatch && statusMatch && dateMatch;
        });

        // Reset to first page when filters change
        currentPage = 1;
        updatePagination();
        updateCounts();
        updateResultsMessage();
    }

    function matchesAddressFilter(address, filter) {
        switch (filter) {
            case 'rosario':
                return address.includes('rosario');
            case 'other':
                return !address.includes('rosario');
            default:
                return true;
        }
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
        const totalCount = allRows.length;

        document.getElementById('visibleCount').textContent = `${visibleCount} visible`;

        // Update total results for pagination
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
        const pageNumbers = document.getElementById('pageNumbers');

        // Update Previous/Next button states
        prevBtn.disabled = currentPage === 1;
        nextBtn.disabled = currentPage === totalPages || totalPages === 0;

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
            button.className = 'relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 hover:bg-gray-50';
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

    function updateResultsMessage() {
        const noResultsMessage = document.getElementById('noResultsMessage');
        const jobseekersTable = document.getElementById('jobseekersTable');

        if (filteredRows.length === 0) {
            noResultsMessage.classList.remove('hidden');
            jobseekersTable.classList.add('hidden');
        } else {
            noResultsMessage.classList.add('hidden');
            jobseekersTable.classList.remove('hidden');
        }
    }

    function clearAllFilters() {
        // Clear search input
        document.getElementById('searchInput').value = '';

        // Reset current filters
        currentFilters = {
            location: '',
            status: '',
            date: ''
        };

        // Reset pagination
        currentPage = 1;

        // Reset Alpine.js dropdown selections
        // You can trigger these by dispatching events or manually updating the dropdown states
        const locationDropdown = document.querySelector('[x-data*="Location"]');
        const statusDropdown = document.querySelector('[x-data*="Status"]');
        const dateDropdown = document.querySelector('[x-data*="Date Range"]');

        if (locationDropdown && locationDropdown._x_dataStack) {
            locationDropdown._x_dataStack[0].selected = 'Location';
        }
        if (statusDropdown && statusDropdown._x_dataStack) {
            statusDropdown._x_dataStack[0].selected = 'Status';
        }
        if (dateDropdown && dateDropdown._x_dataStack) {
            dateDropdown._x_dataStack[0].selected = 'Date Range';
        }

        applyFilters();
    }

    // Sorting functionality
    let sortDirection = {};

    function sortTable(columnIndex) {
        const tbody = document.getElementById('jobseekersTableBody');

        // Get current direction or default to ascending
        sortDirection[columnIndex] = sortDirection[columnIndex] === 'asc' ? 'desc' : 'asc';
        const direction = sortDirection[columnIndex];

        const comparer = (a, b) => {
            let aVal, bVal;

            if (columnIndex === 0) { // Name column
                aVal = a.getAttribute('data-name');
                bVal = b.getAttribute('data-name');
            } else if (columnIndex === 5) { // Registered date column
                aVal = new Date(a.getAttribute('data-date')).getTime();
                bVal = new Date(b.getAttribute('data-date')).getTime();
                return direction === 'asc' ? aVal - bVal : bVal - aVal;
            } else {
                // Default text comparison
                aVal = a.querySelector(`td:nth-child(${columnIndex + 1})`).textContent.trim();
                bVal = b.querySelector(`td:nth-child(${columnIndex + 1})`).textContent.trim();
            }

            // String comparison for text
            return direction === 'asc' ?
                String(aVal).localeCompare(String(bVal)) :
                String(bVal).localeCompare(String(aVal));
        };

        // Sort both allRows and filteredRows to maintain consistency
        allRows.sort(comparer);
        filteredRows.sort(comparer);

        // Reset to first page after sorting
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
                name: cells[0].textContent.trim(),
                contact: cells[1].textContent.trim(),
                gender: cells[2].textContent.trim(),
                address: cells[3].textContent.trim(),
                registered: cells[5].textContent.trim() // Updated index for registered column
            };
        });

        if (format === 'csv') {
            exportToCSV(visibleData);
        } else if (format === 'pdf') {
            // PDF export would require a library like jsPDF
            alert('PDF export functionality would require additional implementation');
        }
    }

    function exportToCSV(data) {
        const headers = ['Name', 'Contact', 'Gender', 'Address', 'Registered'];
        const csvContent = [
            headers.join(','),
            ...data.map(row => [
                `"${row.name}"`,
                `"${row.contact}"`,
                `"${row.gender}"`,
                `"${row.address}"`,
                `"${row.registered}"`
            ].join(','))
        ].join('\n');

        const blob = new Blob([csvContent], {
            type: 'text/csv'
        });
        const url = window.URL.createObjectURL(blob);
        const link = document.createElement('a');
        link.href = url;
        link.download = `jobseekers_${new Date().toISOString().split('T')[0]}.csv`;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        window.URL.revokeObjectURL(url);
    }

    // View profile button handlers
    document.querySelectorAll('.view-profile-btn').forEach(button => {
        button.addEventListener('click', function() {
            const userId = this.getAttribute('data-id');
            // Implement your view profile logic here
            console.log('View profile for user ID:', userId);
            // You could open a modal, navigate to a new page, etc.
            // window.location.href = `?action=view_profile&id=${userId}`;
        });
    });

    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Ctrl/Cmd + F to focus search
        if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
            e.preventDefault();
            document.getElementById('searchInput').focus();
        }

        // Escape to clear filters
        if (e.key === 'Escape') {
            clearAllFilters();
        }
    });
</script>