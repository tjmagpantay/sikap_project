<?php
include_once __DIR__ . '/components/admin_auth_check.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>SIKAP Admin - Employer Management</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#092C4C',
                        secondary: '#F3AF0E'
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        /* Ensure proper height and overflow for layout */
        html,
        body {
            height: 100%;
            overflow: hidden;
        }

        .main-content {
            height: calc(100vh - 4rem);
            /* Subtract topbar height */
            overflow-y: auto;
        }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Topbar (Sticky) -->
    <?php include __DIR__ . '/components/topbar.php'; ?>

    <div class="flex h-screen">
        <!-- Sidebar (Fixed/Sticky) -->
        <?php include __DIR__ . '/components/sidebar.php'; ?>

        <!-- Main Content Area (Scrollable) -->
        <div class="flex-1 lg:ml-80 main-content">
            <div class="p-6">
                <!-- Page Header -->
                <div class="mb-6">
                    <h1 class="text-2xl font-semibold text-gray-900">Employers</h1>
                    <p class="mt-1 text-gray-600">Manage employer accounts</p>
                </div>

                <!-- Improved Employer Stats Cards -->
                <div class="mb-6">
                    <div class="grid grid-cols-2 gap-4 md:grid-cols-6 ">
                        <!-- Card 1: Total Employers -->
                        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-5">
                            <div class="mb-3 sm:mb-4">
                                <h3 class="mb-2 text-xs font-medium text-gray-700 sm:mb-3">Total Employers</h3>
                                <div class="flex items-baseline">
                                    <span class="text-lg font-bold text-blue-600 sm:text-xl" data-stat="total"><?php echo count($users); ?></span>
                                    <svg class="ml-1" width="12px" height="12px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <path d="M12 21V9M12 9L15 12M12 9L9 12M6 21H18C18.5304 21 19.0391 20.7893 19.4142 20.4142C19.7893 20.0391 20 19.5304 20 19V7C20 6.46957 19.7893 5.96086 19.4142 5.58579C19.0391 5.21071 18.5304 5 18 5H14L12 3H6C5.46957 3 4.96086 3.21071 4.58579 3.58579C4.21071 3.96086 4 4.46957 4 5V19C4 19.5304 4.21071 20.0391 4.58579 20.4142C4.96086 20.7893 5.46957 21 6 21Z" stroke="#2563EB" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        </g>
                                    </svg>
                                </div>
                                <p class="mt-1 text-xs text-gray-500">
                                    All registered employers
                                </p>
                            </div>
                        </div>

                        <!-- Card 2: Incomplete -->
                        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-5">
                            <div class="mb-3 sm:mb-4">
                                <h3 class="mb-2 text-xs font-medium text-gray-700 sm:mb-3">Incomplete</h3>
                                <div class="flex items-baseline">
                                    <span class="text-lg font-bold text-gray-600 sm:text-xl" data-stat="incomplete">
                                        <?php echo count(array_filter($users, function ($user) {
                                            return $user['status'] === 'incomplete';
                                        })); ?>
                                    </span>
                                    <svg class="ml-1" width="12px" height="12px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <path d="M11 2H13C13.5523 2 14 2.44772 14 3V10H21C21.5523 10 22 10.4477 22 11V13C22 13.5523 21.5523 14 21 14H14V21C14 21.5523 13.5523 22 13 22H11C10.4477 22 10 21.5523 10 21V14H3C2.44772 14 2 13.5523 2 13V11C2 10.4477 2.44772 10 3 10H10V3C10 2.44772 10.4477 2 11 2Z" stroke="#6B7280" stroke-width="1.5" />
                                        </g>
                                    </svg>
                                </div>
                                <p class="mt-1 text-xs text-gray-500">
                                    Profile setup incomplete
                                </p>
                            </div>
                        </div>

                        <!-- Card 3: Pending -->
                        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-5">
                            <div class="mb-3 sm:mb-4">
                                <h3 class="mb-2 text-xs font-medium text-gray-700 sm:mb-3">Pending</h3>
                                <div class="flex items-baseline">
                                    <span class="text-lg font-bold text-orange-600 sm:text-xl" data-stat="pending">
                                        <?php echo count(array_filter($users, function ($user) {
                                            return $user['status'] === 'pending verification';
                                        })); ?>
                                    </span>
                                    <svg class="ml-1" width="12px" height="12px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <path d="M12 8V12L15 15M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="#EA580C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        </g>
                                    </svg>
                                </div>
                                <p class="mt-1 text-xs text-gray-500">
                                    Awaiting verification
                                </p>
                            </div>
                        </div>

                        <!-- Card 4: Verified -->
                        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-5">
                            <div class="mb-3 sm:mb-4">
                                <h3 class="mb-2 text-xs font-medium text-gray-700 sm:mb-3">Verified</h3>
                                <div class="flex items-baseline">
                                    <span class="text-lg font-bold text-green-600 sm:text-xl" data-stat="verified">
                                        <?php echo count(array_filter($users, function ($user) {
                                            return $user['status'] === 'verified';
                                        })); ?>
                                    </span>
                                    <svg class="ml-1" width="12px" height="12px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <path d="M9 12L11 14L15 10M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="#059669" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        </g>
                                    </svg>
                                </div>
                                <p class="mt-1 text-xs text-gray-500">
                                    Successfully verified
                                </p>
                            </div>
                        </div>

                        <!-- Card 5: Rejected -->
                        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-5">
                            <div class="mb-3 sm:mb-4">
                                <h3 class="mb-2 text-xs font-medium text-gray-700 sm:mb-3">Rejected</h3>
                                <div class="flex items-baseline">
                                    <span class="text-lg font-bold text-red-600 sm:text-xl" data-stat="rejected">
                                        <?php echo count(array_filter($users, function ($user) {
                                            return $user['status'] === 'rejected';
                                        })); ?>
                                    </span>
                                    <svg class="ml-1" width="12px" height="12px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <path d="M10 14L12 12M12 12L14 10M12 12L10 10M12 12L14 14M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="#DC2626" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        </g>
                                    </svg>
                                </div>
                                <p class="mt-1 text-xs text-gray-500">
                                    Verification rejected
                                </p>
                            </div>
                        </div>

                        <!-- Card 6: Suspended -->
                        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-5">
                            <div class="mb-3 sm:mb-4">
                                <h3 class="mb-2 text-xs font-medium text-gray-700 sm:mb-3">Suspended</h3>
                                <div class="flex items-baseline">
                                    <span class="text-lg font-bold text-yellow-600 sm:text-xl" data-stat="suspended">
                                        <?php echo count(array_filter($users, function ($user) {
                                            return $user['status'] === 'suspended';
                                        })); ?>
                                    </span>
                                    <svg class="ml-1" width="12px" height="12px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <path d="M18.364 5.636L5.636 18.364M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="#D97706" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        </g>
                                    </svg>
                                </div>
                                <p class="mt-1 text-xs text-gray-500">
                                    Account suspended
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Search and Filter Section -->
                <div class="relative px-6 py-4 mb-6 bg-white shadow-sm sm:px-6 lg:px-6 rounded-xl">
                    <div class="flex flex-col gap-6 mx-auto">
                        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:gap-3">

                            <!-- Search Employers (Much Wider) -->
                            <div class="w-full lg:w-80">
                                <div class="relative">
                                    <input type="text" id="searchInput"
                                        class="w-full px-4 py-3 pl-12 text-sm text-gray-700 placeholder-gray-400 transition-all duration-200 bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary"
                                        placeholder="Search employers by name, company, or representative...">
                                    <svg class="absolute w-5 h-5 text-gray-400 transform -translate-y-1/2 left-4 top-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                            </div>

                            <!-- Status Filter -->
                            <div class="w-full lg:w-40" x-data="{ open: false, selected: 'Status' }">
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
                                        <button @click="selected = 'Status'; open = false; filterByStatus('')"
                                            class="w-full px-4 py-2 text-sm font-normal text-left text-gray-700 hover:bg-gray-100">All Status</button>
                                        <button @click="selected = 'Incomplete'; open = false; filterByStatus('incomplete')"
                                            class="w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">Incomplete</button>
                                        <button @click="selected = 'Pending'; open = false; filterByStatus('pending verification')"
                                            class="w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">Pending</button>
                                        <button @click="selected = 'Verified'; open = false; filterByStatus('verified')"
                                            class="w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">Verified</button>
                                        <button @click="selected = 'Rejected'; open = false; filterByStatus('rejected')"
                                            class="w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">Rejected</button>
                                        <button @click="selected = 'Suspended'; open = false; filterByStatus('suspended')"
                                            class="w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">Suspended</button>
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
                                        <button @click="selected = 'Date Range'; open = false; filterByDate('')"
                                            class="w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">All Time</button>
                                        <button @click="selected = 'Today'; open = false; filterByDate('today')"
                                            class="w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">Today</button>
                                        <button @click="selected = 'This Week'; open = false; filterByDate('week')"
                                            class="w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">This Week</button>
                                        <button @click="selected = 'This Month'; open = false; filterByDate('month')"
                                            class="w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">This Month</button>
                                        <button @click="selected = 'This Year'; open = false; filterByDate('year')"
                                            class="w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">This Year</button>
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

                <!-- All Employers -->
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-900">All Employers</h2>
                        <div class="flex items-center space-x-2">
                            <span class="px-3 py-1 text-sm bg-blue-100 rounded-sm text-primary" id="visibleCount">
                                <?php echo count($users); ?> visible
                            </span>
                        </div>
                    </div>

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
                        </div>

                        <div class="overflow-hidden bg-white border border-gray-200 rounded-lg shadow-sm" id="employersTable">
                            <table class="w-full divide-y divide-gray-200 table-auto">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Company</th>
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
                                            data-company="<?php echo htmlspecialchars(strtolower($user['company_name'])); ?>"
                                            data-representative="<?php echo htmlspecialchars(strtolower($user['first_name'] . ' ' . $user['last_name'])); ?>"
                                            data-date="<?php echo $user['created_at']; ?>">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">
                                                    <?php echo htmlspecialchars($user['company_name']); ?>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                <?php echo htmlspecialchars($user['contact_no']); ?>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex items-center justify-center w-8 h-8 mr-3 bg-gray-100 rounded-full">
                                                        <span class="text-xs font-medium text-gray-600">
                                                            <?php echo strtoupper(substr($user['first_name'], 0, 1) . substr($user['last_name'], 0, 1)); ?>
                                                        </span>
                                                    </div>
                                                    <div class="text-sm font-medium text-gray-900">
                                                        <?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex px-2 py-1 text-xs font-normal rounded-sm 
                                                        <?php
                                                        $statusClass = [
                                                            'incomplete' => 'bg-gray-100 text-gray-800',
                                                            'pending verification' => 'bg-yellow-100 text-yellow-800',
                                                            'verified' => 'bg-green-100 text-green-800',
                                                            'rejected' => 'bg-red-100 text-red-800',
                                                            'suspended' => 'bg-red-100 text-red-800'
                                                        ];
                                                        echo $statusClass[strtolower($user['status'])] ?? 'bg-gray-100 text-gray-800';
                                                        ?>">
                                                    <?php echo ucfirst($user['status']); ?>
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                <?php echo date('M j, Y', strtotime($user['created_at'])); ?>
                                            </td>
                                            <td class="px-6 py-4 text-sm font-medium whitespace-nowrap">
                                                <div class="flex space-x-2">
                                                    <?php if (strtolower($user['status']) === 'suspended'): ?>
                                                        <button class="text-green-600 hover:text-green-900 unsuspend-btn" data-id="<?php echo $user['user_id']; ?>">
                                                            <i class="mr-1 fas fa-unlock"></i>Unsuspend
                                                        </button>
                                                    <?php else: ?>
                                                        <button class="px-2 py-1 text-xs text-gray-600 bg-gray-100 hover:text-red-900 suspend-btn" data-id="<?php echo $user['user_id']; ?>">
                                                            <i class="mr-1 fas fa-ban"></i>Suspend
                                                        </button>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="px-6 py-4 border-t border-gray-200" id="paginationContainer">
                            <div class="flex items-center justify-between">
                                <!-- Left side: Results info -->
                                <div class="text-sm text-gray-700" id="paginationInfo">
                                    Showing <span id="showingStart">1</span> to <span id="showingEnd">10</span> of <span id="totalResults"><?php echo count($users); ?></span> employers
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
            </div>
        </div>
    </div>

    <!-- Mobile Menu Overlay -->
    <div id="mobile-menu-overlay" class="fixed inset-0 z-40 hidden bg-black bg-opacity-50 lg:hidden"></div>

    <script>
        let allRows = [];
        let filteredRows = [];
        let currentFilters = {
            status: '',
            date: ''
        };

        // Pagination variables
        let currentPage = 1;
        const itemsPerPage = 10;
        let totalPages = 1;

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            allRows = Array.from(document.querySelectorAll('#employersTableBody tr'));
            filteredRows = [...allRows];
            updateCounts();
            initializePagination();
            attachButtonListeners();
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
                const status = row.getAttribute('data-status').toLowerCase();

                // Search filter
                const searchMatch = !searchValue || text.includes(searchValue);

                // Status filter
                const statusMatch = !currentFilters.status || status === currentFilters.status.toLowerCase();

                // Date filter
                const dateMatch = !currentFilters.date || matchesDateFilter(row.getAttribute('data-date'), currentFilters.date);

                return searchMatch && statusMatch && dateMatch;
            });

            // Reset to first page when filters change
            currentPage = 1;
            updatePagination();
            updateCounts();
            updateResultsMessage();
            updateStatusCounts();
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
            const employersTable = document.getElementById('employersTable');

            if (filteredRows.length === 0) {
                noResultsMessage.classList.remove('hidden');
                employersTable.classList.add('hidden');
            } else {
                noResultsMessage.classList.add('hidden');
                employersTable.classList.remove('hidden');
            }
        }

        function clearAllFilters() {
            // Clear search input
            document.getElementById('searchInput').value = '';

            // Reset current filters
            currentFilters = {
                status: '',
                date: ''
            };

            // Reset pagination
            currentPage = 1;

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
                    company: cells[0].textContent.trim(),
                    contact: cells[1].textContent.trim(),
                    representative: cells[2].textContent.trim(),
                    status: cells[3].textContent.trim(),
                    registered: cells[4].textContent.trim()
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
            const headers = ['Company', 'Contact', 'Representative', 'Status', 'Registered'];
            const csvContent = [
                headers.join(','),
                ...data.map(row => [
                    `"${row.company}"`,
                    `"${row.contact}"`,
                    `"${row.representative}"`,
                    `"${row.status}"`,
                    `"${row.registered}"`
                ].join(','))
            ].join('\n');

            const blob = new Blob([csvContent], {
                type: 'text/csv'
            });
            const url = window.URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.href = url;
            link.download = `employers_${new Date().toISOString().split('T')[0]}.csv`;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            window.URL.revokeObjectURL(url);
        }

        // Enhanced suspend/unsuspend functionality with proper API endpoint
        function handleStatusChange(action, userId, button) {
            // Disable button and show loading state
            button.disabled = true;
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="mr-1 fas fa-spinner fa-spin"></i>Processing...';

            // Create form data
            const formData = new FormData();
            formData.append('action', action);
            formData.append('user_id', userId);

            fetch('index.php?page=update-employer-status', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        // Update the row status without reloading
                        const row = button.closest('tr');
                        const statusCell = row.querySelector('td:nth-child(4) span');
                        const actionCell = row.querySelector('td:last-child div');

                        // Update data-status attribute
                        row.setAttribute('data-status', action === 'suspend' ? 'suspended' : 'verified');

                        // Update status badge
                        statusCell.className = `inline-flex px-2 py-1 text-xs font-semibold rounded-full ${
                            action === 'suspend' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800'
                        }`;
                        statusCell.textContent = action === 'suspend' ? 'Suspended' : 'Verified';

                        // Update action button
                        if (action === 'suspend') {
                            actionCell.innerHTML = `
                                <button class="text-green-600 hover:text-green-900 unsuspend-btn" data-id="${userId}">
                                    <i class="mr-1 fas fa-unlock"></i>Unsuspend
                            </button>
                        `;
                        } else {
                            actionCell.innerHTML = `
                                <button class="text-red-600 hover:text-red-900 suspend-btn" data-id="${userId}">
                                    <i class="mr-1 fas fa-ban"></i>Suspend
                            </button>
                        `;
                        }

                        // Update status filter counts
                        updateStatusCounts();

                        // Reattach event listeners
                        attachButtonListeners();
                    } else {
                        throw new Error(data.error || `Failed to ${action} employer`);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert(`An error occurred while updating status. Please try again.`);
                    button.disabled = false;
                    button.innerHTML = originalText;
                });
        }

        // Add this function to update status counts
        function updateStatusCounts() {
            const rows = document.querySelectorAll('#employersTableBody tr');
            const counts = {
                total: rows.length,
                incomplete: 0,
                pending: 0,
                verified: 0,
                rejected: 0,
                suspended: 0
            };

            rows.forEach(row => {
                const status = row.getAttribute('data-status');
                if (status === 'incomplete') counts.incomplete++;
                if (status === 'pending verification') counts.pending++;
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

        // Add this function to reattach event listeners
        function attachButtonListeners() {
            document.querySelectorAll('.suspend-btn').forEach(button => {
                button.addEventListener('click', function() {
                    if (confirm('Are you sure you want to suspend this employer?')) {
                        const userId = this.getAttribute('data-id');
                        handleStatusChange('suspend', userId, this);
                    }
                });
            });

            document.querySelectorAll('.unsuspend-btn').forEach(button => {
                button.addEventListener('click', function() {
                    if (confirm('Are you sure you want to unsuspend this employer?')) {
                        const userId = this.getAttribute('data-id');
                        handleStatusChange('unsuspend', userId, this);
                    }
                });
            });
        }

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
</body>

</html>