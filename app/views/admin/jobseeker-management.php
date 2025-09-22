<?php
// Remove the auth check since dashboard.php already handles it
// include_once __DIR__ . '/components/admin_auth_check.php'; 
?>

<!-- Remove ALL HTML structure - make it content-only like main-board.php -->
<div class="space-y-6">
    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">Jobseeker Management</h1>
        <p class="mt-1 text-sm text-gray-600">Manage jobseeker accounts and view statistics</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 gap-4 mb-6 sm:gap-6 sm:mb-8 md:grid-cols-4">
        <!-- Card 1: Total Jobseekers -->
        <div class="p-5 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-4 md:p-5">
            <div class="mb-3 sm:mb-4">
                <h3 class="mb-2 text-sm font-medium text-gray-700 sm:mb-3">Total Jobseekers</h3>
                <div class="flex items-baseline">
                    <span class="text-2xl font-bold text-blue-600 sm:text-2xl" id="totalCount">
                        <?php echo count($users ?? []); ?>
                    </span>
                    <svg class="ml-1" width="12px" height="12px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke="#2563EB" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <p class="mt-1 text-xs text-gray-500">
                    All registered jobseekers
                </p>
            </div>
        </div>

        <!-- Card 2: Active Jobseekers -->
        <div class="p-5 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-4 md:p-5">
            <div class="mb-3 sm:mb-4">
                <h3 class="mb-2 text-sm font-medium text-gray-700 sm:mb-3">Active</h3>
                <div class="flex items-baseline">
                    <span class="text-2xl font-bold text-green-600 sm:text-2xl" id="activeCount">
                        <?php echo count(array_filter($users ?? [], function ($user) {
                            return ($user['acc_status'] ?? 'enabled') === 'enabled';
                        })); ?>
                    </span>
                    <svg class="ml-1" width="12px" height="12px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke="#059669" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M9 12l2 2 4-4" stroke="#059669" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <p class="mt-1 text-xs text-gray-500">
                    Currently active users
                </p>
            </div>
        </div>

        <!-- Card 3: From Rosario -->
        <div class="p-5 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-4 md:p-5">
            <div class="mb-3 sm:mb-4">
                <h3 class="mb-2 text-sm font-medium text-gray-700 sm:mb-3">From Rosario</h3>
                <div class="flex items-baseline">
                    <span class="text-2xl font-bold text-secondary sm:text-2xl" id="rosarioCount">
                        <?php echo count(array_filter($users ?? [], function ($user) {
                            return stripos($user['address'] ?? '', 'rosario') !== false;
                        })); ?>
                    </span>
                    <svg class="ml-1" width="12px" height="12px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" stroke="#F3AF0E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <circle cx="12" cy="10" r="3" stroke="#F3AF0E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <p class="mt-1 text-xs text-gray-500">
                    Jobseekers from Rosario
                </p>
            </div>
        </div>

        <!-- Card 4: Other Areas -->
        <div class="p-5 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-4 md:p-5">
            <div class="mb-3 sm:mb-4">
                <h3 class="mb-2 text-sm font-medium text-gray-700 sm:mb-3">Other Areas</h3>
                <div class="flex items-baseline">
                    <span class="text-2xl font-bold text-blue-600 sm:text-2xl" id="otherAreasCount">
                        <?php echo count(array_filter($users ?? [], function ($user) {
                            return stripos($user['address'] ?? '', 'rosario') === false;
                        })); ?>
                    </span>
                    <svg class="ml-1" width="12px" height="12px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="12" r="10" stroke="#2563EB" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="m4.93 4.93 4.24 4.24" stroke="#2563EB" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="m14.83 9.17 4.24-4.24" stroke="#2563EB" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="m14.83 14.83 4.24 4.24" stroke="#2563EB" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="m9.17 14.83-4.24 4.24" stroke="#2563EB" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <p class="mt-1 text-xs text-gray-500">
                    Outside Rosario area
                </p>
            </div>
        </div>
    </div>

    <!-- Search and Filter Controls -->
    <div class="flex items-stretch w-full gap-3 mb-6">
        <!-- Search Input (Expanded width with icon inside) -->
        <div class="flex-1">
            <div class="relative">
                <input
                    type="text"
                    id="searchInput"
                    placeholder="Search"
                    class="w-full px-4 py-3 pr-10 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-secondary focus:border-secondary"
                    onkeyup="filterNavigation()">
                <svg class="absolute w-4 h-4 text-gray-400 transform -translate-y-1/2 pointer-events-none right-3 top-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
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
                    <a href="#" @click.prevent="selected = 'Enabled'; filterByStatus('enabled'); open = false"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Enabled</a>
                    <a href="#" @click.prevent="selected = 'Disabled'; filterByStatus('disabled'); open = false"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Disabled</a>
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
                    <a href="#" @click.prevent="selected = 'All Locations'; filterByLocation('all'); open = false"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">All Locations</a>
                    <a href="#" @click.prevent="selected = 'Rosario'; filterByLocation('rosario'); open = false"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Rosario</a>
                    <a href="#" @click.prevent="selected = 'Others'; filterByLocation('others'); open = false"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Others</a>
                </div>
            </div>
        </div>

        <!-- Action Buttons (Fixed width) -->
        <div class="flex flex-shrink-0 gap-2">
            <button onclick="clearAllFilters()"
                class="px-4 py-3 text-sm text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-400 whitespace-nowrap">
                <i class="mr-1 fas fa-times"></i> Clear
            </button>
            <button onclick="exportToPDF()"
                class="px-4 py-3 text-sm text-white rounded-lg bg-primary hover:bg-primary/90 whitespace-nowrap">
                <i class="mr-1 fas fa-file-pdf"></i> Export
            </button>
        </div>
    </div>

    <!-- Jobseekers Table -->
    <div class="overflow-hidden bg-white border border-gray-200 rounded-lg shadow">
        <div class="overflow-x-auto">
            <table class="w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="w-1/4 px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                            Name
                        </th>
                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase w-1/8">
                            Birth Date
                        </th>
                        <th scope="col" class="w-1/12 px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                            Sex
                        </th>
                        <th scope="col" class="w-1/4 px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                            Address
                        </th>
                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase w-1/8">
                            Contact
                        </th>
                        <th scope="col" class="w-1/12 px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase w-1/8">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="jobseekersTableBody">
                    <?php if (isset($users) && is_array($users)): ?>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900 break-words">
                                        <?php
                                        echo htmlspecialchars(
                                            $user['first_name'] . ' ' .
                                                ($user['middle_name'] ? $user['middle_name'] . ' ' : '') .
                                                $user['last_name'] .
                                                ($user['suffix'] ? ' ' . $user['suffix'] : '')
                                        );
                                        ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        <?php echo $user['date_of_birth'] ? date('M d, Y', strtotime($user['date_of_birth'])) : '-'; ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        <?php echo htmlspecialchars($user['sex'] ?? '-'); ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900 break-words">
                                        <?php echo htmlspecialchars($user['address'] ?? '-'); ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        <?php echo htmlspecialchars($user['contact_no'] ?? '-'); ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-medium leading-5 rounded-md <?php
                                                                                                                echo $user['acc_status'] === 'enabled' ?
                                                                                                                    'text-primary bg-gray-100' :
                                                                                                                    'text-red-800 bg-red-100'; ?>">
                                        <?php echo ucfirst($user['acc_status'] ?? 'enabled'); ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium whitespace-nowrap">
                                    <?php if ($user['acc_status'] !== 'disabled'): ?>
                                        <button onclick="updateJobseekerStatus('<?php echo $user['user_id']; ?>', 'disable')"
                                            class="px-3 py-1 text-xs text-red-600 bg-red-100 rounded-md hover:bg-red-200">
                                            <i class="mr-1 fas fa-ban"></i> Disable
                                        </button>
                                    <?php else: ?>
                                        <button onclick="updateJobseekerStatus('<?php echo $user['user_id']; ?>', 'enable')"
                                            class="px-3 py-1 text-xs bg-gray-100 rounded-md text-primary hover:bg-gray-200">
                                            <i class="mr-1 fas fa-check"></i> Enable
                                        </button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                No jobseekers found
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
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
</div>

<!-- Keep your existing JavaScript -->
<script>
    // Pagination variables
    let currentPage = 1;
    const itemsPerPage = 10;
    let filteredRows = [];

    // Apply all filters
    function applyFilters() {
        console.log('Running search...');
        const rows = document.querySelectorAll('#jobseekersTableBody tr');
        const searchInput = document.getElementById('searchInput');
        const searchTerm = searchInput?.value.toLowerCase() || '';

        filteredRows = [];

        rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            const rowText = Array.from(cells)
                .slice(0, -1) // Exclude the last cell (actions)
                .map(cell => cell.textContent.toLowerCase())
                .join(' ');

            const showRow = searchTerm === '' || rowText.includes(searchTerm);

            if (showRow) {
                filteredRows.push(row);
            }
        });

        // Reset to page 1 when filtering
        currentPage = 1;
        updatePagination();
        updateCounts();
    }

    // Update pagination display
    function updatePagination() {
        const totalItems = filteredRows.length;
        const totalPages = Math.ceil(totalItems / itemsPerPage);
        const startItem = (currentPage - 1) * itemsPerPage + 1;
        const endItem = Math.min(currentPage * itemsPerPage, totalItems);

        // Update info text
        document.getElementById('totalItems').textContent = totalItems;
        document.getElementById('startItem').textContent = totalItems > 0 ? startItem : 0;
        document.getElementById('endItem').textContent = endItem;

        // Show/hide all rows first
        const allRows = document.querySelectorAll('#jobseekersTableBody tr');
        allRows.forEach(row => row.style.display = 'none');

        // Show only current page rows
        const start = (currentPage - 1) * itemsPerPage;
        const end = start + itemsPerPage;
        filteredRows.slice(start, end).forEach(row => {
            row.style.display = '';
        });

        // Update navigation buttons
        document.getElementById('prevBtn').disabled = currentPage <= 1;
        document.getElementById('nextBtn').disabled = currentPage >= totalPages;

        // Update page numbers
        updatePageNumbers(totalPages);
    }

    // Update page numbers display
    function updatePageNumbers(totalPages) {
        const pageNumbers = document.getElementById('pageNumbers');
        pageNumbers.innerHTML = '';

        if (totalPages <= 1) return;

        const maxVisible = 5;
        let start = Math.max(1, currentPage - Math.floor(maxVisible / 2));
        let end = Math.min(totalPages, start + maxVisible - 1);

        if (end - start + 1 < maxVisible) {
            start = Math.max(1, end - maxVisible + 1);
        }

        for (let i = start; i <= end; i++) {
            const button = document.createElement('button');
            button.textContent = i;
            button.className = `px-3 py-1 text-sm border rounded ${
                i === currentPage 
                    ? 'bg-primary text-white border-primary' 
                    : 'bg-white border-gray-300 hover:bg-gray-50'
            }`;
            button.onclick = () => goToPage(i);
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

    // Update all count displays
    function updateCounts() {
        const totalCount = document.getElementById('totalCount');
        const activeCount = document.getElementById('activeCount');
        const rosarioCount = document.getElementById('rosarioCount');
        const otherAreasCount = document.getElementById('otherAreasCount');

        const visibleCount = filteredRows.length;
        if (totalCount) totalCount.textContent = visibleCount;

        if (!activeCount || !rosarioCount || !otherAreasCount) return;

        const activeRows = filteredRows.filter(row => {
            const statusCell = row.querySelector('td:nth-child(6)');
            return statusCell && statusCell.textContent.trim().toLowerCase() === 'enabled';
        });

        const rosarioRows = filteredRows.filter(row => {
            const addressCell = row.querySelector('td:nth-child(4)');
            return addressCell && addressCell.textContent.toLowerCase().includes('rosario');
        });

        activeCount.textContent = activeRows.length;
        rosarioCount.textContent = rosarioRows.length;
        otherAreasCount.textContent = filteredRows.length - rosarioRows.length;
    }

    // Export table to PDF
    function exportToPDF() {
        const printWindow = window.open('', '', 'height=600,width=800');

        printWindow.document.write('<html><head><title>Jobseekers Report</title>');
        printWindow.document.write('<style>');
        printWindow.document.write(`
            table { border-collapse: collapse; width: 100%; margin-bottom: 1rem; }
            th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
            th { background-color: #f8f9fa; }
            .header { margin-bottom: 20px; text-align: center; }
            .header h1 { margin: 0; color: #092C4C; }
            .status-enabled { color: #059669; }
            .status-disabled { color: #DC2626; }
            .date { color: #666; font-size: 12px; }
        `);
        printWindow.document.write('</style></head><body>');

        printWindow.document.write(`
            <div class="header">
                <h1>SIKAP - Jobseekers Report</h1>
                <p class="date">Generated on: ${new Date().toLocaleString()}</p>
            </div>
        `);

        printWindow.document.write('<table>');
        printWindow.document.write(`
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Birth Date</th>
                    <th>Sex</th>
                    <th>Address</th>
                    <th>Contact</th>
                    <th>Status</th>
                </tr>
            </thead>
        `);

        printWindow.document.write('<tbody>');
        filteredRows.forEach(row => {
            const cells = row.querySelectorAll('td');
            printWindow.document.write('<tr>');
            for (let i = 0; i < 6; i++) {
                const cell = cells[i];
                if (i === 5) {
                    const status = cell.textContent.trim().toLowerCase();
                    printWindow.document.write(`
                        <td class="status-${status}">
                            ${cell.textContent}
                        </td>
                    `);
                } else {
                    printWindow.document.write(`<td>${cell.textContent}</td>`);
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

    // Filter by status
    function filterByStatus(status) {
        const rows = Array.from(document.querySelectorAll('#jobseekersTableBody tr'));

        filteredRows = rows.filter(row => {
            const statusCell = row.querySelector('td:nth-child(6)');
            const currentStatus = statusCell.textContent.trim().toLowerCase();

            return !status || currentStatus.includes(status.toLowerCase());
        });

        currentPage = 1;
        updatePagination();
        updateCounts();
    }

    // Filter by location
    function filterByLocation(location) {
        const rows = Array.from(document.querySelectorAll('#jobseekersTableBody tr'));

        filteredRows = rows.filter(row => {
            const addressCell = row.querySelector('td:nth-child(4)');
            const address = addressCell.textContent.toLowerCase();

            if (location === 'all') return true;
            if (location === 'rosario') return address.includes('rosario');
            if (location === 'others') return !address.includes('rosario');
            return true;
        });

        currentPage = 1;
        updatePagination();
        updateCounts();
    }

    // Update jobseeker status
    function updateJobseekerStatus(userId, action) {
        if (!confirm('Are you sure you want to ' + action + ' this jobseeker\'s account?')) {
            return;
        }

        const formData = new FormData();
        formData.append('user_id', userId);
        formData.append('action', action);
        formData.append('user_type', 'jobseeker');

        const baseUrl = window.location.pathname.split('index.php')[0];
        const url = baseUrl + 'index.php?page=admin-jobseeker-update-status';

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
                    const successMessage = document.createElement('div');
                    successMessage.className = 'fixed top-4 right-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded z-50';
                    successMessage.innerHTML = `Successfully ${action}d jobseeker account`;
                    document.body.appendChild(successMessage);

                    const buttons = document.querySelectorAll('button[onclick*="' + userId + '"]');
                    const row = buttons[0]?.closest('tr');

                    if (row) {
                        const statusCell = row.querySelector('td:nth-child(6) span');
                        const newStatus = action === 'disable' ? 'disabled' : 'enabled';
                        if (statusCell) {
                            statusCell.textContent = newStatus.charAt(0).toUpperCase() + newStatus.slice(1);
                            statusCell.className = `inline-flex px-2 py-1 text-xs font-medium leading-5 rounded-md ${
                            newStatus === 'enabled' ? 'text-green-800 bg-green-100' : 'text-red-800 bg-red-100'
                        }`;
                        }

                        const actionButton = buttons[0];
                        if (actionButton) {
                            if (newStatus === 'disabled') {
                                actionButton.innerHTML = '<i class="mr-1 fas fa-check"></i> Enable';
                                actionButton.className = 'px-3 py-1 text-xs bg-gray-100 rounded-md text-primary hover:bg-gray-200';
                                actionButton.setAttribute('onclick', `updateJobseekerStatus('${userId}', 'enable')`);
                            } else {
                                actionButton.innerHTML = '<i class="mr-1 fas fa-ban"></i> Disable';
                                actionButton.className = 'px-3 py-1 text-xs text-red-600 bg-red-100 rounded-md hover:bg-red-200';
                                actionButton.setAttribute('onclick', `updateJobseekerStatus('${userId}', 'disable')`);
                            }
                        }
                    }

                    setTimeout(() => {
                        successMessage.remove();
                    }, 3000);
                } else {
                    throw new Error(data.error || 'Failed to update status');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                const errorMessage = document.createElement('div');
                errorMessage.className = 'fixed top-4 right-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded z-50';
                errorMessage.innerHTML = error.message;
                document.body.appendChild(errorMessage);

                setTimeout(() => {
                    errorMessage.remove();
                }, 3000);
            });
    }

    // Clear all filters
    function clearAllFilters() {
        document.getElementById('searchInput').value = '';

        // Reset Alpine.js dropdowns
        const statusDropdown = document.querySelector('[x-data*="All Status"]');
        const locationDropdown = document.querySelector('[x-data*="All Locations"]');

        if (statusDropdown && statusDropdown.__x) {
            statusDropdown.__x.$data.selected = 'All Status';
        }
        if (locationDropdown && locationDropdown.__x) {
            locationDropdown.__x.$data.selected = 'All Locations';
        }

        // Reset filtered rows to all rows
        filteredRows = Array.from(document.querySelectorAll('#jobseekersTableBody tr'));
        currentPage = 1;
        updatePagination();
        updateCounts();
    }

    // Initialize
    document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.getElementById('searchInput');

        if (searchInput) {
            searchInput.addEventListener('input', applyFilters);
            searchInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') {
                    applyFilters();
                }
            });
        }

        // Initialize with all rows
        filteredRows = Array.from(document.querySelectorAll('#jobseekersTableBody tr'));
        updatePagination();
        updateCounts();
    });
</script>