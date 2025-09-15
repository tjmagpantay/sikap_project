<?php
include_once __DIR__ . '/components/admin_auth_check.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>SIKAP Admin - Jobseeker Management</title>
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
</head>

<body class="bg-gray-50">
    <!-- Topbar -->
    <?php include __DIR__ . '/components/topbar.php'; ?>

    <div class="flex h-screen">
        <!-- Sidebar -->
        <?php include __DIR__ . '/components/sidebar.php'; ?>

        <!-- Main Content -->
        <div class="flex-1 overflow-auto lg:ml-80">
            <div class="p-6">
                <!-- Stats Cards -->
                <div class="grid grid-cols-1 gap-4 mb-6 sm:gap-6 sm:mb-8 md:grid-cols-4">
                    <!-- Card 1: Total Jobseekers -->
                    <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-6">
                        <div>
                            <h3 class="mb-3 text-sm font-medium text-gray-700 sm:mb-4">Total Jobseekers</h3>
                            <div class="flex items-baseline">
                                <span class="text-2xl font-bold text-gray-900 sm:text-3xl" id="totalCount"><?php echo count($users); ?></span>
                            </div>
                            <p class="mt-2 text-xs text-gray-500">All registered jobseekers in the system</p>
                        </div>
                    </div>

                    <!-- Card 2: Active Jobseekers -->
                    <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-6">
                        <div>
                            <h3 class="mb-3 text-sm font-medium text-gray-700 sm:mb-4">Active</h3>
                            <div class="flex items-baseline">
                                <span class="text-2xl font-bold text-gray-900 sm:text-3xl" id="activeCount">
                                    <?php echo count(array_filter($users, function ($user) {
                                        return ($user['acc_status'] ?? 'enabled') === 'enabled';
                                    })); ?>
                                </span>
                            </div>
                            <p class="mt-2 text-xs text-gray-500">Currently active jobseekers</p>
                        </div>
                    </div>

                    <!-- Card 3: From Rosario -->
                    <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-6">
                        <div>
                            <h3 class="mb-3 text-sm font-medium text-gray-700 sm:mb-4">From Rosario</h3>
                            <div class="flex items-baseline">
                                <span class="text-2xl font-bold text-gray-900 sm:text-3xl" id="rosarioCount">
                                    <?php echo count(array_filter($users, function ($user) {
                                        return stripos($user['address'] ?? '', 'rosario') !== false;
                                    })); ?>
                                </span>
                            </div>
                            <p class="mt-2 text-xs text-gray-500">Jobseekers from Rosario area</p>
                        </div>
                    </div>

                    <!-- Card 4: Other Areas -->
                    <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-6">
                        <div>
                            <h3 class="mb-3 text-sm font-medium text-gray-700 sm:mb-4">Other Areas</h3>
                            <div class="flex items-baseline">
                                <span class="text-2xl font-bold text-gray-900 sm:text-3xl" id="otherAreasCount">
                                    <?php echo count(array_filter($users, function ($user) {
                                        return stripos($user['address'] ?? '', 'rosario') === false;
                                    })); ?>
                                </span>
                            </div>
                            <p class="mt-2 text-xs text-gray-500">Jobseekers from outside Rosario</p>
                        </div>
                    </div>
                </div>

                <!-- Search and Filter Controls -->
                <div class="relative py-4 mb-6 rounded-xl">
                    <div class="flex flex-col w-full gap-6 mx-auto">
                        <div class="flex flex-wrap items-center w-full gap-x-4 gap-y-2">
                            <!-- Search Input -->
                            <div class="flex-1 min-w-[200px] max-w-xl">
                                <div class="relative">
                                    <input type="text" id="searchInput" 
                                           class="w-full px-4 py-2 pl-10 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary" 
                                           placeholder="Search jobseekers...">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                                        <i class="text-gray-400 fas fa-search"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- Location Filter -->
                            <div class="relative" x-data="{ open: false, selected: 'All Locations' }">
                                <button @click="open = !open" class="px-4 py-2 text-sm bg-white border rounded-md shadow-sm">
                                    <span x-text="selected"></span>
                                    <i class="ml-2 fas fa-chevron-down"></i>
                                </button>
                                <div x-show="open" @click.away="open = false" 
                                     class="absolute z-50 w-48 mt-1 bg-white rounded-md shadow-lg">
                                    <div class="py-1">
                                        <a href="#" @click.prevent="selected = 'All Locations'; filterByLocation('all'); open = false" 
                                           class="block px-4 py-2 hover:bg-gray-100">All Locations</a>
                                        <a href="#" @click.prevent="selected = 'Rosario'; filterByLocation('rosario'); open = false" 
                                           class="block px-4 py-2 hover:bg-gray-100">Rosario</a>
                                        <a href="#" @click.prevent="selected = 'Others'; filterByLocation('others'); open = false" 
                                           class="block px-4 py-2 hover:bg-gray-100">Others</a>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex space-x-2">
                                <button onclick="clearAllFilters()" 
                                        class="px-4 py-2 text-sm text-white rounded-lg bg-primary hover:bg-primary/90">
                                    Clear Filters
                                </button>
                                <button onclick="exportToPDF()" 
                                        class="px-4 py-2 text-sm text-white rounded-lg bg-primary hover:bg-primary/90">
                                    <i class="mr-1 fas fa-file-pdf"></i> Export PDF
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status Filters -->
                <div class="mb-6">
                    <div class="flex items-center justify-between space-x-4">
                        <div class="flex items-center space-x-4">
                            <div class="relative" x-data="{ open: false, selected: 'All' }">
                                <button @click="open = !open" class="w-32 px-4 py-2 bg-white border rounded-md shadow-sm">
                                    <span x-text="selected"></span>
                                    <i class="ml-2 fas fa-chevron-down"></i>
                                </button>
                            <div x-show="open" @click.away="open = false" 
                                 class="absolute z-50 w-32 mt-1 bg-white rounded-md shadow-lg">
                                <div class="py-1">
                                    <a href="#" @click.prevent="selected = 'All'; filterByStatus(''); open = false" 
                                       class="block px-4 py-2 hover:bg-gray-100">All</a>
                                    <a href="#" @click.prevent="selected = 'Enabled'; filterByStatus('enabled'); open = false" 
                                       class="block px-4 py-2 hover:bg-gray-100">Enabled</a>
                                    <a href="#" @click.prevent="selected = 'Disabled'; filterByStatus('disabled'); open = false" 
                                       class="block px-4 py-2 hover:bg-gray-100">Disabled</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Jobseekers Table -->
                <div class="overflow-hidden bg-white rounded-lg shadow">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    Name
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    Birth Date
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    Sex
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    Address
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    Contact
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200" id="jobseekersTableBody">
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
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
                                        <div class="text-sm text-gray-900">
                                            <?php echo htmlspecialchars($user['address'] ?? '-'); ?>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            <?php echo htmlspecialchars($user['contact_no'] ?? '-'); ?>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 text-xs font-semibold leading-5 rounded-full <?php 
                                            echo $user['acc_status'] === 'enabled' ? 
                                                'text-green-800 bg-green-100' : 
                                                'text-red-800 bg-red-100'; 
                                            ?>">
                                            <?php echo ucfirst($user['acc_status'] ?? 'enabled'); ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium whitespace-nowrap">
                                        <?php if ($user['acc_status'] !== 'disabled'): ?>
                                            <button onclick="updateJobseekerStatus('<?php echo $user['user_id']; ?>', 'disable')" 
                                                    class="text-red-600 hover:text-red-900">
                                                <i class="mr-1 fas fa-ban"></i> Disable
                                            </button>
                                        <?php else: ?>
                                            <button onclick="updateJobseekerStatus('<?php echo $user['user_id']; ?>', 'enable')" 
                                                    class="text-green-600 hover:text-green-900">
                                                <i class="mr-1 fas fa-check"></i> Enable
                                            </button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Apply all filters
        function applyFilters() {
            console.log('Running search...');
            const rows = document.querySelectorAll('#jobseekersTableBody tr');
            const searchInput = document.getElementById('searchInput');
            const searchTerm = searchInput?.value.toLowerCase() || '';
            
            console.log('Search term:', searchTerm);
            console.log('Number of rows:', rows.length);
            
            let visibleCount = 0;
            
            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                const rowText = Array.from(cells)
                    .slice(0, -1) // Exclude the last cell (actions)
                    .map(cell => cell.textContent.toLowerCase())
                    .join(' ');
                
                const showRow = searchTerm === '' || rowText.includes(searchTerm);
                row.style.display = showRow ? '' : 'none';
                
                if (showRow) visibleCount++;
                
                console.log('Row text:', rowText);
                console.log('Show row:', showRow);
            });
            
            console.log('Visible count:', visibleCount);
            
            // Update counts
            updateCounts(visibleCount);
        }
        
        // Update all count displays
        function updateCounts(visibleCount) {
            const totalCount = document.getElementById('totalCount');
            const activeCount = document.getElementById('activeCount');
            const rosarioCount = document.getElementById('rosarioCount');
            const otherAreasCount = document.getElementById('otherAreasCount');
            
            if (totalCount) totalCount.textContent = visibleCount;
            
            if (!activeCount || !rosarioCount || !otherAreasCount) return;
            
            const visibleRows = Array.from(document.querySelectorAll('#jobseekersTableBody tr'))
                .filter(row => row.style.display !== 'none');
            
            const activeRows = visibleRows.filter(row => {
                const statusCell = row.querySelector('td:nth-child(6)');
                return statusCell && statusCell.textContent.trim().toLowerCase() === 'enabled';
            });
            
            const rosarioRows = visibleRows.filter(row => {
                const addressCell = row.querySelector('td:nth-child(4)');
                return addressCell && addressCell.textContent.toLowerCase().includes('rosario');
            });
            
            activeCount.textContent = activeRows.length;
            rosarioCount.textContent = rosarioRows.length;
            otherAreasCount.textContent = visibleRows.length - rosarioRows.length;
        }

        // Export table to PDF
        function exportToPDF() {
            // Create a window object for printing
            const printWindow = window.open('', '', 'height=600,width=800');
            
            // Build the HTML content for the print window
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
            
            // Add header
            printWindow.document.write(`
                <div class="header">
                    <h1>SIKAP - Jobseekers Report</h1>
                    <p class="date">Generated on: ${new Date().toLocaleString()}</p>
                </div>
            `);
            
            // Get visible rows from the table
            const visibleRows = Array.from(document.querySelectorAll('#jobseekersTableBody tr'))
                                   .filter(row => row.style.display !== 'none');
            
            // Create table
            printWindow.document.write('<table>');
            
            // Add headers
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
            
            // Add rows
            printWindow.document.write('<tbody>');
            visibleRows.forEach(row => {
                const cells = row.querySelectorAll('td');
                printWindow.document.write('<tr>');
                // Only include the first 6 cells (excluding the actions column)
                for (let i = 0; i < 6; i++) {
                    const cell = cells[i];
                    if (i === 5) { // Status column
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
            
            // Wait for the content to load then print
            printWindow.onload = function() {
                printWindow.focus();
                printWindow.print();
            };
        }

        // Filter by status
        function filterByStatus(status) {
            const rows = document.querySelectorAll('#jobseekersTableBody tr');
            let visibleCount = 0;
            
            rows.forEach(row => {
                const statusCell = row.querySelector('td:nth-child(6)');
                const currentStatus = statusCell.textContent.trim().toLowerCase();
                
                if (!status || currentStatus.includes(status.toLowerCase())) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });
            
            document.getElementById('visibleCount').textContent = `${visibleCount} visible`;
        }

        // Filter by location
        function filterByLocation(location) {
            const rows = document.querySelectorAll('#jobseekersTableBody tr');
            let visibleCount = 0;
            
            rows.forEach(row => {
                const addressCell = row.querySelector('td:nth-child(4)');
                const address = addressCell.textContent.toLowerCase();
                let show = false;
                
                if (location === 'all') {
                    show = true;
                } else if (location === 'rosario') {
                    show = address.includes('rosario');
                } else if (location === 'others') {
                    show = !address.includes('rosario');
                }
                
                row.style.display = show ? '' : 'none';
                if (show) visibleCount++;
            });
            
            document.getElementById('visibleCount').textContent = `${visibleCount} visible`;
        }

        // Update jobseeker status
        function updateJobseekerStatus(userId, action) {
            console.log('updateJobseekerStatus called with:', { userId, action });
            
            if (!confirm('Are you sure you want to ' + action + ' this jobseeker\'s account?')) {
                console.log('User cancelled the operation');
                return;
            }

            // Create the form data
            const formData = new FormData();
            formData.append('user_id', userId);
            formData.append('action', action);
            formData.append('user_type', 'jobseeker');
            
            console.log('Sending request with data:', {
                user_id: userId,
                action: action,
                user_type: 'jobseeker'
            });

            // Build the full URL using the current location
            const baseUrl = window.location.pathname.split('index.php')[0];
            const url = baseUrl + 'index.php?page=admin-jobseeker-update-status';
            console.log('Sending request to:', url);

            fetch(url, {
                method: 'POST',
                body: formData,
                headers: {
                    'Accept': 'application/json'
                }
            })
            .then(async response => {
                console.log('Response status:', response.status);
                console.log('Response headers:', Object.fromEntries(response.headers.entries()));
                
                const text = await response.text();
                console.log('Raw response:', text);
                
                try {
                    return JSON.parse(text);
                } catch (e) {
                    console.error('JSON parse error:', e);
                    throw new Error('Invalid JSON response: ' + text);
                }
            })
            .then(data => {
                console.log('Response data:', data);
                if (data.success) {
                    // Show success message
                    const successMessage = document.createElement('div');
                    successMessage.className = 'fixed top-4 right-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded z-50';
                    successMessage.innerHTML = `Successfully ${action}d jobseeker account`;
                    document.body.appendChild(successMessage);

                    // Find all buttons with onclick containing the userId
                    const buttons = document.querySelectorAll('button[onclick*="' + userId + '"]');
                    // Find the button's parent row
                    const row = buttons[0]?.closest('tr');
                    
                    if (row) {
                        // Update status cell
                        const statusCell = row.querySelector('td:nth-child(6) span');
                        const newStatus = action === 'disable' ? 'disabled' : 'enabled';
                        if (statusCell) {
                            statusCell.textContent = newStatus.charAt(0).toUpperCase() + newStatus.slice(1);
                            statusCell.className = `inline-flex px-2 text-xs font-semibold leading-5 rounded-full ${
                                newStatus === 'enabled' ? 'text-green-800 bg-green-100' : 'text-red-800 bg-red-100'
                            }`;
                        }

                        // Update action button
                        const actionButton = buttons[0];
                        if (actionButton) {
                            if (newStatus === 'disabled') {
                                actionButton.innerHTML = '<i class="mr-1 fas fa-check"></i> Enable';
                                actionButton.className = 'text-green-600 hover:text-green-900';
                                actionButton.setAttribute('onclick', `updateJobseekerStatus('${userId}', 'enable')`);
                            } else {
                                actionButton.innerHTML = '<i class="mr-1 fas fa-ban"></i> Disable';
                                actionButton.className = 'text-red-600 hover:text-red-900';
                                actionButton.setAttribute('onclick', `updateJobseekerStatus('${userId}', 'disable')`);
                            }
                        }
                    }

                    // Remove success message after 3 seconds
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
            // Reset search
            document.getElementById('searchInput').value = '';
            
            // Reset location dropdown
            const locationDropdown = document.querySelector('[x-data]').__x.$data;
            if (locationDropdown) {
                locationDropdown.selected = 'All Locations';
            }
            
            // Show all rows
            const rows = document.querySelectorAll('#jobseekersTableBody tr');
            rows.forEach(row => row.style.display = '');
            
            // Update count
            document.getElementById('visibleCount').textContent = `${rows.length} visible`;
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', () => {
            console.log('DOM Content Loaded');
            
            // Set up search input
            const searchInput = document.getElementById('searchInput');
            console.log('Search input found:', !!searchInput);
            
            if (searchInput) {
                searchInput.addEventListener('input', () => {
                    console.log('Search input changed:', searchInput.value);
                    applyFilters();
                });
                
                // Trigger search on Enter key
                searchInput.addEventListener('keypress', (e) => {
                    if (e.key === 'Enter') {
                        console.log('Enter key pressed');
                        applyFilters();
                    }
                });
            }
            
            // Initial count update
            updateCounts(document.querySelectorAll('#jobseekersTableBody tr').length);
        });
    </script>

</body>
</html>