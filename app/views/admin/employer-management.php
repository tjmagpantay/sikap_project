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

                <!-- Search and Filter -->
                <div class="flex flex-col mb-4 space-y-4 sm:flex-row sm:space-y-0 sm:space-x-4 sm:items-center sm:justify-between">
                    <div class="relative w-full sm:w-64">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="text-gray-400 fas fa-search"></i>
                        </div>
                        <input type="text" id="searchInput" class="block w-full py-2 pl-10 pr-3 text-sm bg-white border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500" placeholder="Search employers...">
                    </div>
                    <div class="flex space-x-2">
                        <select id="statusFilter" class="block w-full py-2 pl-3 pr-10 text-sm bg-white border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:w-40">
                            <option value="">All Status</option>
                            <option value="incomplete">Incomplete</option>
                            <option value="pending verification">Pending</option>
                            <option value="verified">Verified</option>
                            <option value="rejected">Rejected</option>
                            <option value="suspended">Suspended</option>
                        </select>
                    </div>
                </div>

                <!-- All Employers -->
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-900">All Employers</h2>
                        <div class="flex items-center space-x-2">
                            <span class="px-3 py-1 text-sm text-blue-800 bg-blue-100 rounded-full">
                                <?php echo count($users); ?> total
                            </span>
                        </div>
                    </div>

                    <?php if (empty($users)): ?>
                        <div class="p-8 text-center bg-white border border-gray-200 rounded-lg">
                            <i class="mb-4 text-4xl text-gray-400 fas fa-inbox"></i>
                            <p class="text-gray-500">No employers found</p>
                        </div>
                    <?php else: ?>
                        <div class="overflow-hidden bg-white border border-gray-200 rounded-lg shadow-sm">
                            <table class="w-full table-auto divide-y divide-gray-200">
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
                                        <tr class="hover:bg-gray-50" data-status="<?php echo htmlspecialchars(strtolower($user['status'])); ?>">
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
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
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
                                                        <button class="text-red-600 hover:text-red-900 suspend-btn" data-id="<?php echo $user['user_id']; ?>">
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
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Mobile Menu Overlay -->
<div id="mobile-menu-overlay" class="fixed inset-0 z-40 hidden bg-black bg-opacity-50 lg:hidden"></div>

<script>
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
        const searchValue = this.value.toLowerCase();
        const rows = document.querySelectorAll('#employersTableBody tr');

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchValue) ? '' : 'none';
        });
    });

    // Filter functionality
    document.getElementById('statusFilter').addEventListener('change', function() {
        const statusFilter = this.value.toLowerCase();
        const rows = document.querySelectorAll('#employersTableBody tr');

        rows.forEach(row => {
            const rowStatus = row.getAttribute('data-status');
            row.style.display = !statusFilter || rowStatus === statusFilter ? '' : 'none';
        });
    });

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

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        attachButtonListeners();
    });
</script>