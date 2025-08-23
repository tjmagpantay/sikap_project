<?php
// filepath: app/views/admin/jobseekers.php
$error = $_GET['error'] ?? '';
$success = $_GET['success'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jobseekers - SIKAP Admin</title>
    <link href="css/output.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="bg-gray-50">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <?php include __DIR__ . '/components/sidebar.php'; ?>

        <!-- Main Content -->
        <div class="flex flex-col flex-1 lg:ml-80 overflow-hidden">
            <!-- Top Navigation -->
            <?php include __DIR__ . '/components/topbar.php'; ?>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto bg-gray-50">
                <div class="p-6">
                    <!-- Page Header -->
                    <div class="mb-6">
                        <h1 class="text-2xl font-semibold text-gray-900">Jobseekers</h1>
                        <p class="mt-1 text-gray-600">Manage jobseeker accounts</p>
                    </div>

                    <!-- Messages -->
                    <?php if ($error): ?>
                        <div class="p-4 mb-6 text-red-700 bg-red-100 border border-red-200 rounded-lg">
                            <div class="flex items-center">
                                <i class="mr-2 fas fa-exclamation-circle"></i>
                                <?php echo htmlspecialchars($error); ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ($success): ?>
                        <div class="p-4 mb-6 text-green-700 bg-green-100 border border-green-200 rounded-lg">
                            <div class="flex items-center">
                                <i class="mr-2 fas fa-check-circle"></i>
                                <?php echo htmlspecialchars($success); ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Stats Cards -->
                    <div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-4">
                        <div class="p-6 bg-white border border-gray-200 rounded-lg">
                            <div class="flex items-center">
                                <div class="flex items-center justify-center w-12 h-12 bg-blue-100 rounded-lg">
                                    <i class="text-blue-600 fas fa-users"></i>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm text-gray-600">Total Jobseekers</p>
                                    <p class="text-2xl font-bold text-gray-900" id="totalCount"><?php echo count($users); ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="p-6 bg-white border border-gray-200 rounded-lg">
                            <div class="flex items-center">
                                <div class="flex items-center justify-center w-12 h-12 bg-green-100 rounded-lg">
                                    <i class="text-green-600 fas fa-user-check"></i>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm text-gray-600">Active</p>
                                    <p class="text-2xl font-bold text-gray-900" id="activeCount">
                                        <?php echo count(array_filter($users, function ($user) {
                                            return ($user['status'] ?? 'active') === 'active';
                                        })); ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="p-6 bg-white border border-gray-200 rounded-lg">
                            <div class="flex items-center">
                                <div class="flex items-center justify-center w-12 h-12 bg-orange-100 rounded-lg">
                                    <i class="text-orange-600 fas fa-map-marker-alt"></i>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm text-gray-600">From Rosario</p>
                                    <p class="text-2xl font-bold text-gray-900">
                                        <?php echo count(array_filter($users, function ($user) {
                                            return stripos($user['address'], 'rosario') !== false;
                                        })); ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="p-6 bg-white border border-gray-200 rounded-lg">
                            <div class="flex items-center">
                                <div class="flex items-center justify-center w-12 h-12 bg-gray-100 rounded-lg">
                                    <i class="text-gray-600 fas fa-map"></i>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm text-gray-600">Other Areas</p>
                                    <p class="text-2xl font-bold text-gray-900">
                                        <?php echo count(array_filter($users, function ($user) {
                                            return stripos($user['address'], 'rosario') === false;
                                        })); ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Stats Cards -->

                    <!-- Search and Filter Section -->
                    <div class="p-4 mb-6 bg-white border border-gray-200 rounded-lg">
                        <div class="flex flex-col space-y-4 lg:flex-row lg:space-y-0 lg:space-x-4 lg:items-end">
                            <!-- Search Input -->
                            <div class="flex-1">
                                <label for="searchInput" class="block mb-2 text-sm font-medium text-gray-700">Search Jobseekers</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <i class="text-gray-400 fas fa-search"></i>
                                    </div>
                                    <input type="text" id="searchInput"
                                        class="block w-full py-2 pl-10 pr-3 text-sm bg-white border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="Search by name, contact, or address...">
                                </div>
                            </div>

                            <!-- Address Filter -->
                            <div class="lg:w-48">
                                <label for="addressFilter" class="block mb-2 text-sm font-medium text-gray-700">Location</label>
                                <select id="addressFilter" class="block w-full py-2 pl-3 pr-10 text-sm bg-white border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">All Locations</option>
                                    <option value="rosario">Rosario</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>

                            <!-- Date Range Filter -->
                            <div class="lg:w-48">
                                <label for="dateFilter" class="block mb-2 text-sm font-medium text-gray-700">Registration Date</label>
                                <select id="dateFilter" class="block w-full py-2 pl-3 pr-10 text-sm bg-white border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">All Time</option>
                                    <option value="today">Today</option>
                                    <option value="week">This Week</option>
                                    <option value="month">This Month</option>
                                    <option value="year">This Year</option>
                                </select>
                            </div>
                        </div>

                        <!-- Search Results Summary -->
                        <div class="pt-4 mt-4 border-t border-gray-200">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600" id="resultsCount">Showing all <?php echo count($users); ?> jobseekers</span>

                            </div>
                        </div>
                    </div>

                    <!-- All Jobseekers -->
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-lg font-semibold text-gray-900">All Jobseekers</h2>
                            <div class="flex items-center space-x-2">
                                <span class="px-3 py-1 text-sm text-blue-800 bg-blue-100 rounded-full" id="visibleCount">
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
                                <table class="min-w-full divide-y divide-gray-200">
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
                                                        <i class="mr-2 text-gray-400 fas fa-phone"></i>
                                                        <?php echo htmlspecialchars($user['contact_no']); ?>
                                                    </div>
                                                </td>

                                                <!-- Sex column -->
                                                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo strtolower($user['sex']) === 'male' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800'; ?>">
                                                        <i class="mr-1 fas fa-<?php echo strtolower($user['sex']) === 'male' ? 'mars' : 'venus'; ?>"></i>
                                                        <?php echo htmlspecialchars($user['sex']); ?>
                                                    </span>
                                                </td>

                                                <!-- Address column -->
                                                <td class="max-w-xs px-6 py-4 text-sm text-gray-500 truncate whitespace-nowrap" title="<?php echo htmlspecialchars($user['address']); ?>">
                                                    <div class="flex items-center">
                                                        <i class="mr-2 text-gray-400 fas fa-map-marker-alt"></i>
                                                        <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full <?php echo stripos($user['address'], 'rosario') !== false ? 'bg-orange-100 text-orange-800' : 'bg-gray-100 text-gray-800'; ?>">
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
                                                        <i class="mr-2 text-gray-400 fas fa-calendar"></i>
                                                        <?php echo date('M j, Y', strtotime($user['created_at'])); ?>
                                                    </div>
                                                </td>

                                                <!-- Actions column -->
                                                <td class="px-6 py-4 text-sm font-medium whitespace-nowrap">
                                                    <button class="text-gray-600 hover:text-gray-900" disabled title="Block User">
                                                        <i class="mr-1 fas fa-ban"></i>Disable
                                                    </button>
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
        let allRows = [];
        let filteredRows = [];

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            allRows = Array.from(document.querySelectorAll('#jobseekersTableBody tr'));
            filteredRows = [...allRows];
            updateCounts();
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

        // Address filter
        document.getElementById('addressFilter').addEventListener('change', function() {
            applyFilters();
        });

        // Date filter
        document.getElementById('dateFilter').addEventListener('change', function() {
            applyFilters();
        });

        function applyFilters() {
            const searchValue = document.getElementById('searchInput').value.toLowerCase();
            const addressFilter = document.getElementById('addressFilter').value.toLowerCase();
            const dateFilter = document.getElementById('dateFilter').value;

            filteredRows = allRows.filter(row => {
                const text = row.textContent.toLowerCase();
                const address = row.getAttribute('data-address').toLowerCase();

                // Search filter
                const searchMatch = !searchValue || text.includes(searchValue);

                // Address filter
                let addressMatch = true;
                if (addressFilter === 'rosario') {
                    addressMatch = address.includes('rosario');
                } else if (addressFilter === 'other') {
                    addressMatch = !address.includes('rosario');
                }

                // Date filter
                const dateMatch = !dateFilter || matchesDateFilter(row.getAttribute('data-date'), dateFilter);

                return searchMatch && addressMatch && dateMatch;
            });

            // Show/hide rows
            allRows.forEach(row => {
                row.style.display = filteredRows.includes(row) ? '' : 'none';
            });

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
            document.getElementById('resultsCount').textContent =
                visibleCount === totalCount ?
                `Showing all ${totalCount} jobseekers` :
                `Showing ${visibleCount} of ${totalCount} jobseekers`;
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
            document.getElementById('searchInput').value = '';
            document.getElementById('addressFilter').value = '';
            document.getElementById('dateFilter').value = '';
            applyFilters();
        }

        // Sorting functionality
        let sortDirection = {};

        function sortTable(columnIndex) {
            const tbody = document.getElementById('jobseekersTableBody');
            const rows = Array.from(tbody.querySelectorAll('tr'));

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

            rows.sort(comparer).forEach(row => tbody.appendChild(row));

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
            const visibleData = filteredRows.map(row => {
                const cells = row.querySelectorAll('td');
                return {
                    name: cells[0].textContent.trim(),
                    contact: cells[1].textContent.trim(),
                    gender: cells[2].textContent.trim(),
                    address: cells[3].textContent.trim(),
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
</body>

</html>