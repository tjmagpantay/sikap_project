<?php
// Remove the auth check since dashboard.php already handles it
// include_once __DIR__ . '/components/admin_auth_check.php'; 
?>

<!-- Remove ALL HTML structure - make it content-only like main-board.php -->
<div class="space-y-6">
    <!-- Messages -->
    <?php if ($error ?? false): ?>
        <div class="p-4 mb-6 text-red-700 bg-red-100 border border-red-200 rounded-lg">
            <div class="flex items-center">
                <i class="mr-2 fas fa-exclamation-circle"></i>
                <?php echo htmlspecialchars($error); ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($success ?? false): ?>
        <div class="p-4 mb-6 text-green-700 bg-green-100 border border-green-200 rounded-lg">
            <div class="flex items-center">
                <i class="mr-2 fas fa-check-circle"></i>
                <?php echo htmlspecialchars($success); ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">Accreditation Management</h1>
        <p class="mt-1 text-sm text-gray-600">Review and manage employer accreditations</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 gap-4 mb-6 sm:gap-6 sm:mb-8 md:grid-cols-3">
        <!-- Card 1: Total Accreditations -->
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-6">
            <div class="mb-4">
                <h3 class="mb-2 text-sm font-medium text-gray-700">Total Accreditations</h3>
                <div class="flex items-baseline">
                    <span class="text-2xl font-bold text-blue-600"><?php echo count($accreditations ?? []); ?></span>
                    <svg class="ml-1" width="16px" height="16px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" stroke="#2563EB" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <p class="mt-1 text-xs text-gray-500">All accreditation requests</p>
            </div>
        </div>

        <!-- Card 2: Pending Accreditations -->
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-6">
            <div class="mb-4">
                <h3 class="mb-2 text-sm font-medium text-gray-700">Pending Review</h3>
                <div class="flex items-baseline">
                    <span class="text-2xl font-bold text-yellow-600">
                        <?php echo count(array_filter($accreditations ?? [], function ($a) {
                            return $a['status'] === 'pending';
                        })); ?>
                    </span>
                    <svg class="ml-1" width="16px" height="16px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke="#D97706" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <p class="mt-1 text-xs text-gray-500">Awaiting admin review</p>
            </div>
        </div>

        <!-- Card 3: Approved Accreditations -->
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-6">
            <div class="mb-4">
                <h3 class="mb-2 text-sm font-medium text-gray-700">Approved</h3>
                <div class="flex items-baseline">
                    <span class="text-2xl font-bold text-green-600">
                        <?php echo count(array_filter($accreditations ?? [], function ($a) {
                            return $a['status'] === 'approved';
                        })); ?>
                    </span>
                    <svg class="ml-1" width="16px" height="16px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" stroke="#059669" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <p class="mt-1 text-xs text-gray-500">Verified employers</p>
            </div>
        </div>
    </div>

    <!-- Pending Accreditations Table -->
    <?php
    $pendingAccreditations = array_filter($accreditations ?? [], function ($a) {
        return $a['status'] === 'pending';
    });
    ?>

    <div class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold text-gray-900">Pending Accreditations</h2>
            <span class="px-3 py-1 text-sm text-yellow-800 bg-yellow-100 rounded-full">
                <?php echo count($pendingAccreditations); ?> pending
            </span>
        </div>

        <?php if (!empty($pendingAccreditations)): ?>
            <div class="overflow-hidden bg-white border border-yellow-200 rounded-lg shadow-sm">
                <div class="px-6 py-3 bg-yellow-50">
                    <h3 class="text-sm font-medium text-yellow-800">
                        <i class="mr-2 fas fa-clock"></i>
                        Requires Immediate Review
                    </h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Business Name</th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Owner</th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Contact</th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Submitted</th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($pendingAccreditations as $accreditation): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            <?php echo htmlspecialchars($accreditation['business_name'] ?? $accreditation['company_name'] ?? 'N/A'); ?>
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            <?php echo htmlspecialchars($accreditation['business_type'] ?? 'N/A'); ?>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            <?php echo htmlspecialchars(($accreditation['first_name'] ?? '') . ' ' . ($accreditation['last_name'] ?? '')); ?>
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            <?php echo htmlspecialchars($accreditation['position'] ?? 'N/A'); ?>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            <?php echo htmlspecialchars($accreditation['email'] ?? 'N/A'); ?>
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            <?php echo htmlspecialchars($accreditation['contact_no'] ?? 'N/A'); ?>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            <?php echo $accreditation['created_at'] ? date('M d, Y', strtotime($accreditation['created_at'])) : 'N/A'; ?>
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            <?php echo $accreditation['created_at'] ? date('g:i A', strtotime($accreditation['created_at'])) : ''; ?>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium whitespace-nowrap">
                                        <div class="flex items-center gap-2">
                                            <a href="?page=admin-review-accreditation&id=<?php echo $accreditation['accreditation_id']; ?>"
                                                class="inline-flex items-center px-3 py-2 text-xs font-medium bg-gray-100 rounded-md text-primary hover:bg-blue-200">
                                                <i class="mr-1 fas fa-eye"></i> Review
                                            </a>
                                            <button onclick="quickApprove(<?php echo $accreditation['accreditation_id']; ?>)"
                                                class="inline-flex items-center px-3 py-2 text-xs font-medium text-blue-700 bg-blue-100 rounded-md hover:bg-blue-200">
                                                <i class="mr-1 fas fa-check"></i> Approve
                                            </button>
                                            <button onclick="quickReject(<?php echo $accreditation['accreditation_id']; ?>)"
                                                class="inline-flex items-center px-3 py-2 text-xs font-medium text-red-700 bg-red-100 rounded-md hover:bg-red-200">
                                                <i class="mr-1 fas fa-times"></i> Reject
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php else: ?>
            <div class="p-8 text-center bg-white border border-gray-200 rounded-lg shadow-sm">
                <i class="mx-auto mb-4 text-4xl text-gray-400 fas fa-check-circle"></i>
                <p class="text-gray-500">No pending accreditations at the moment.</p>
                <p class="text-sm text-gray-400">All employers are up to date!</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- All Accreditations Table -->
    <div>
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold text-gray-900">All Accreditations</h2>
            <div class="flex items-center gap-2">
                <!-- Search -->
                <div class="relative">
                    <input type="text" id="searchInput" placeholder="Search accreditations..."
                        class="px-4 py-3 pl-10 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">

                </div>
                <!-- Status Filter -->
                <div class="relative" x-data="{ open: false, selected: 'All Status' }">
                    <button @click="open = !open"
                        class="flex items-center justify-between px-4 py-3 text-sm border border-gray-300 rounded-lg bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-primary/20 min-w-32">
                        <span x-text="selected" class="truncate"></span>
                        <i class="flex-shrink-0 ml-2 text-gray-400 fas fa-chevron-down" :class="{ 'rotate-180': open }"></i>
                    </button>
                    <div x-show="open" @click.away="open = false" x-transition
                        class="absolute right-0 z-50 w-40 mt-1 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5" x-cloak>
                        <div class="py-1">
                            <button @click="selected = 'All Status'; open = false; filterByStatus('')" class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">All Status</button>
                            <button @click="selected = 'Pending'; open = false; filterByStatus('pending')" class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">Pending</button>
                            <button @click="selected = 'Approved'; open = false; filterByStatus('approved')" class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">Approved</button>
                            <button @click="selected = 'Rejected'; open = false; filterByStatus('rejected')" class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">Rejected</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Accreditations Table -->
        <div class="overflow-hidden bg-white border border-gray-200 rounded-lg shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Business Name</th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Owner</th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Contact</th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Status</th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Submitted</th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="accreditationsTableBody">
                        <?php if (!empty($accreditations)): ?>
                            <?php foreach ($accreditations as $accreditation): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            <?php echo htmlspecialchars($accreditation['business_name'] ?? $accreditation['company_name'] ?? 'N/A'); ?>
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            <?php echo htmlspecialchars($accreditation['business_type'] ?? 'N/A'); ?>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            <?php echo htmlspecialchars(($accreditation['first_name'] ?? '') . ' ' . ($accreditation['last_name'] ?? '')); ?>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            <?php echo htmlspecialchars($accreditation['email'] ?? 'N/A'); ?>
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            <?php echo htmlspecialchars($accreditation['contact_no'] ?? 'N/A'); ?>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <?php
                                        $statusClasses = [
                                            'pending' => 'bg-gray-100 text-primary',
                                            'approved' => 'bg-gray-100 text-primary',
                                            'rejected' => 'bg-gray-100 text-primary'
                                        ];
                                        $statusClass = $statusClasses[$accreditation['status'] ?? 'pending'] ?? 'bg-gray-100 text-primary';
                                        ?>
                                        <span class="inline-flex px-2 py-1 text-xs font-medium rounded-md <?php echo $statusClass; ?>">
                                            <?php echo ucfirst($accreditation['status'] ?? 'Pending'); ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            <?php echo $accreditation['created_at'] ? date('M d, Y', strtotime($accreditation['created_at'])) : 'N/A'; ?>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium whitespace-nowrap">
                                        <div class="flex items-center justify-end">
                                            <!-- Actions Dropdown -->
                                            <div class="relative" x-data="{ open: false }">
                                                <button @click="open = !open"
                                                    class="text-gray-400 hover:text-gray-600"
                                                    title="Actions">
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
                                                    class="absolute right-0 z-50 w-40 mt-2 origin-top-right bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5"
                                                    x-cloak>
                                                    <div class="py-1">
                                                        <a href="?page=admin-review-accreditation&id=<?php echo $accreditation['accreditation_id']; ?>"
                                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                            Review Details
                                                        </a>
                                                        <?php if ($accreditation['status'] === 'pending'): ?>
                                                            <button onclick="quickApprove(<?php echo $accreditation['accreditation_id']; ?>)"
                                                                class="block w-full px-4 py-2 text-sm text-left text-green-700 hover:bg-green-50">
                                                                Quick Approve
                                                            </button>
                                                            <button onclick="quickReject(<?php echo $accreditation['accreditation_id']; ?>)"
                                                                class="block w-full px-4 py-2 text-sm text-left text-red-700 hover:bg-red-50">
                                                                Quick Reject
                                                            </button>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                    No accreditations found
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="flex items-center justify-between px-6 py-3 border-t border-gray-200 bg-gray-50">
                <div class="flex items-center text-sm text-gray-700">
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
                        class="px-3 py-1 text-sm bg-white border border-gray-300 rounded hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
                        Next <i class="ml-1 fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Hidden form for processing accreditations -->
<form id="accreditationForm" method="POST" action="?page=admin-process-accreditation" style="display: none;">
    <input type="hidden" name="accreditation_id" id="accreditationId">
    <input type="hidden" name="status" id="accreditationStatus">
    <input type="hidden" name="notes" id="accreditationNotes">
</form>

<script>
    // Pagination variables
    let currentPage = 1;
    const itemsPerPage = 10;
    let allRows = [];
    let filteredRows = [];
    let totalPages = 1;

    // Initialize pagination on page load
    document.addEventListener('DOMContentLoaded', function() {
        allRows = Array.from(document.querySelectorAll('#accreditationsTableBody tr')).filter(row => {
            return !row.querySelector('td[colspan]') && row.querySelector('td:nth-child(1)');
        });
        filteredRows = [...allRows];
        updateCounts();
        initializePagination();
    });

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
        const totalItemsEl = document.getElementById('totalItems');
        const startItemEl = document.getElementById('startItem');
        const endItemEl = document.getElementById('endItem');

        if (filteredRows.length === 0) {
            if (totalItemsEl) totalItemsEl.textContent = '0';
            if (startItemEl) startItemEl.textContent = '0';
            if (endItemEl) endItemEl.textContent = '0';
            return;
        }

        const startIndex = (currentPage - 1) * itemsPerPage + 1;
        const endIndex = Math.min(currentPage * itemsPerPage, filteredRows.length);

        if (totalItemsEl) totalItemsEl.textContent = filteredRows.length;
        if (startItemEl) startItemEl.textContent = filteredRows.length > 0 ? startIndex : 0;
        if (endItemEl) endItemEl.textContent = endIndex;
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

    function updateCounts() {
        const totalItemsEl = document.getElementById('totalItems');
        if (totalItemsEl) {
            totalItemsEl.textContent = filteredRows.length;
        }
    }

    // Updated filter and search functions
    function filterByStatus(status) {
        filteredRows = allRows.filter(row => {
            if (!row.querySelector('td:nth-child(1)')) return false;
            return status === '' || row.textContent.toLowerCase().includes(status);
        });
        currentPage = 1;
        updatePagination();
        updateCounts();
    }

    // Updated search functionality
    document.getElementById('searchInput')?.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();

        filteredRows = allRows.filter(row => {
            if (!row.querySelector('td:nth-child(1)')) return false;
            const text = row.textContent.toLowerCase();
            return text.includes(searchTerm);
        });

        currentPage = 1;
        updatePagination();
        updateCounts();
    });

    // Quick approve function with native JavaScript confirm
    function quickApprove(accreditationId) {
        if (confirm('Are you sure you want to approve this accreditation?')) {
            document.getElementById('accreditationId').value = accreditationId;
            document.getElementById('accreditationStatus').value = 'approved';
            document.getElementById('accreditationNotes').value = 'Quick approval by admin';
            document.getElementById('accreditationForm').submit();
        }
    }

    // Quick reject function with native JavaScript prompt
    function quickReject(accreditationId) {
        const reason = prompt('Please provide a reason for rejection:');
        if (reason !== null && reason.trim() !== '') {
            document.getElementById('accreditationId').value = accreditationId;
            document.getElementById('accreditationStatus').value = 'rejected';
            document.getElementById('accreditationNotes').value = reason.trim();
            document.getElementById('accreditationForm').submit();
        } else if (reason !== null) {
            alert('You need to provide a reason for rejection!');
        }
    }
</script>