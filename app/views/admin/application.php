<?php
include_once __DIR__ . '/components/admin_auth_check.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>SIKAP Admin - Application Management</title>
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
                        <div class="mb-4 sm:mb-6">
                            <h3 class="mb-3 text-sm font-medium text-gray-700 sm:mb-4">Total Applications</h3>
                            <div class="flex items-baseline">
                                <span class="text-2xl font-bold text-gray-900 sm:text-3xl" data-stat="total"><?php echo $stats['total']; ?></span>
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
                        <div class="mb-4 sm:mb-6">
                            <h3 class="mb-3 text-sm font-medium text-gray-700 sm:mb-4">Pending</h3>
                            <div class="flex items-baseline">
                                <span class="text-2xl font-bold text-gray-900 sm:text-3xl" data-stat="pending"><?php echo $stats['pending']; ?></span>
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
                        <div class="mb-4 sm:mb-6">
                            <h3 class="mb-3 text-sm font-medium text-gray-700 sm:mb-4">Reviewed</h3>
                            <div class="flex items-baseline">
                                <span class="text-2xl font-bold text-gray-900 sm:text-3xl" data-stat="reviewed"><?php echo $stats['reviewed']; ?></span>
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
                        <div class="mb-4 sm:mb-6">
                            <h3 class="mb-3 text-sm font-medium text-gray-700 sm:mb-4">Shortlisted</h3>
                            <div class="flex items-baseline">
                                <span class="text-2xl font-bold text-gray-900 sm:text-3xl" data-stat="shortlisted"><?php echo $stats['shortlisted']; ?></span>
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
                        <div class="mb-4 sm:mb-6">
                            <h3 class="mb-3 text-sm font-medium text-gray-700 sm:mb-4">Hired</h3>
                            <div class="flex items-baseline">
                                <span class="text-2xl font-bold text-gray-900 sm:text-3xl" data-stat="hired"><?php echo $stats['hired']; ?></span>
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
                        <div class="mb-4 sm:mb-6">
                            <h3 class="mb-3 text-sm font-medium text-gray-700 sm:mb-4">Rejected</h3>
                            <div class="flex items-baseline">
                                <span class="text-2xl font-bold text-gray-900 sm:text-3xl" data-stat="rejected"><?php echo $stats['rejected']; ?></span>
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
                <div class="relative px-6 py-4 mb-6 bg-white shadow-sm sm:px-6 lg:px-6 rounded-xl">
                    <div class="flex flex-col gap-6 mx-auto">
                        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:gap-3">

                            <!-- Search Applications (Much Wider) -->
                            <div class="w-full lg:w-80">
                                <div class="relative">
                                    <input type="text" id="searchInput" placeholder="Search by applicant name, job title, company..."
                                        class="w-full px-4 py-2 pl-10 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                                        value="<?php echo htmlspecialchars($searchQuery ?? ''); ?>">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Status Filter -->
                            <div class="w-full lg:w-40" x-data="{ open: false, selected: '<?php echo ucfirst($statusFilter === 'all' ? 'Status' : $statusFilter); ?>' }">
                                <button @click="open = !open"
                                    @click.away="open = false"
                                    class="relative w-full px-4 py-2 text-sm text-left text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm cursor-default focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
                                    <span class="block truncate" x-text="selected"></span>
                                    <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </span>
                                </button>

                                <!-- Dropdown Menu -->
                                <div x-show="open"
                                    x-transition:enter="transition ease-out duration-100"
                                    x-transition:enter-start="transform opacity-0 scale-95"
                                    x-transition:enter-end="transform opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-75"
                                    x-transition:leave-start="transform opacity-100 scale-100"
                                    x-transition:leave-end="transform opacity-0 scale-95"
                                    class="absolute z-50 w-full mt-1 overflow-auto bg-white border border-gray-300 rounded-lg shadow-lg max-h-60"
                                    x-cloak>
                                    <button @click="selected = 'Status'; open = false; filterByStatus('')"
                                        class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                                        All Status
                                    </button>
                                    <button @click="selected = 'Pending'; open = false; filterByStatus('pending')"
                                        class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                                        Pending
                                    </button>
                                    <button @click="selected = 'Reviewed'; open = false; filterByStatus('reviewed')"
                                        class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                                        Reviewed
                                    </button>
                                    <button @click="selected = 'Shortlisted'; open = false; filterByStatus('shortlisted')"
                                        class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                                        Shortlisted
                                    </button>
                                    <button @click="selected = 'Hired'; open = false; filterByStatus('hired')"
                                        class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                                        Hired
                                    </button>
                                    <button @click="selected = 'Rejected'; open = false; filterByStatus('rejected')"
                                        class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                                        Rejected
                                    </button>
                                </div>
                            </div>

                            <!-- Job Filter -->
                            <div class="w-full lg:w-48" x-data="{ open: false, selected: 'Job Filter' }">
                                <button @click="open = !open"
                                    @click.away="open = false"
                                    class="relative w-full px-4 py-2 text-sm text-left text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm cursor-default focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
                                    <span class="block truncate" x-text="selected"></span>
                                    <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </span>
                                </button>

                                <!-- Dropdown Menu -->
                                <div x-show="open"
                                    x-transition:enter="transition ease-out duration-100"
                                    x-transition:enter-start="transform opacity-0 scale-95"
                                    x-transition:enter-end="transform opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-75"
                                    x-transition:leave-start="transform opacity-100 scale-100"
                                    x-transition:leave-end="transform opacity-0 scale-95"
                                    class="absolute z-50 w-full mt-1 overflow-auto bg-white border border-gray-300 rounded-lg shadow-lg max-h-60"
                                    x-cloak>
                                    <button @click="selected = 'Job Filter'; open = false; filterByJob('')"
                                        class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                                        All Jobs
                                    </button>
                                    <?php foreach ($jobs as $job): ?>
                                        <button @click="selected = '<?php echo htmlspecialchars($job['job_title']); ?>'; open = false; filterByJob('<?php echo $job['job_id']; ?>')"
                                            class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                                            <?php echo htmlspecialchars($job['job_title']); ?> - <?php echo htmlspecialchars($job['company_name']); ?>
                                        </button>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <!-- Date Filter -->
                            <div class="w-full lg:w-40" x-data="{ open: false, selected: 'Date Range' }">
                                <button @click="open = !open"
                                    @click.away="open = false"
                                    class="relative w-full px-4 py-2 text-sm text-left text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm cursor-default focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
                                    <span class="block truncate" x-text="selected"></span>
                                    <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </span>
                                </button>

                                <!-- Dropdown Menu -->
                                <div x-show="open"
                                    x-transition:enter="transition ease-out duration-100"
                                    x-transition:enter-start="transform opacity-0 scale-95"
                                    x-transition:enter-end="transform opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-75"
                                    x-transition:leave-start="transform opacity-100 scale-100"
                                    x-transition:leave-end="transform opacity-0 scale-95"
                                    class="absolute z-50 w-full mt-1 overflow-auto bg-white border border-gray-300 rounded-lg shadow-lg max-h-60"
                                    x-cloak>
                                    <button @click="selected = 'Date Range'; open = false; filterByDate('')"
                                        class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                                        All Dates
                                    </button>
                                    <button @click="selected = 'Today'; open = false; filterByDate('today')"
                                        class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                                        Today
                                    </button>
                                    <button @click="selected = 'This Week'; open = false; filterByDate('week')"
                                        class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                                        This Week
                                    </button>
                                    <button @click="selected = 'This Month'; open = false; filterByDate('month')"
                                        class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                                        This Month
                                    </button>
                                    <button @click="selected = 'This Year'; open = false; filterByDate('year')"
                                        class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                                        This Year
                                    </button>
                                </div>
                            </div>

                            <!-- Filter/Clear Buttons -->
                            <div class="flex gap-2 lg:flex-shrink-0">
                                <button onclick="clearAllFilters()"
                                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                    Clear Filters
                                </button>
                                <button onclick="exportResults('csv')"
                                    class="px-4 py-2 text-sm font-medium text-white border border-transparent rounded-lg bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                    Export CSV
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- All Applications -->
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-900">All Applications</h2>
                        <div class="flex items-center space-x-2">
                            <span class="px-3 py-1 text-sm bg-blue-100 rounded-sm text-primary" id="visibleCount">
                                <?php echo count($applications); ?> visible
                            </span>
                        </div>
                    </div>

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
                            <div class="overflow-x-auto">
                                <table class="w-full divide-y divide-gray-200 table-auto">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase cursor-pointer hover:bg-gray-100" onclick="sortTable(0)">
                                                Applicant
                                                <i class="ml-1 text-gray-400 fas fa-sort"></i>
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase cursor-pointer hover:bg-gray-100" onclick="sortTable(1)">
                                                Job Title
                                                <i class="ml-1 text-gray-400 fas fa-sort"></i>
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                                Company
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                                Location
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                                Status
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase cursor-pointer hover:bg-gray-100" onclick="sortTable(5)">
                                                Applied
                                                <i class="ml-1 text-gray-400 fas fa-sort"></i>
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                                Contact
                                            </th>
                                            <th scope="col" class="relative px-6 py-3">
                                                <span class="sr-only">Actions</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="applicationsTableBody" class="bg-white divide-y divide-gray-200">
                                        <?php foreach ($applications as $application): ?>
                                            <tr class="hover:bg-gray-50"
                                                data-status="<?php echo htmlspecialchars($application['application_status']); ?>"
                                                data-job="<?php echo htmlspecialchars($application['job_id']); ?>"
                                                data-applied="<?php echo htmlspecialchars($application['applied_at']); ?>"
                                                data-name="<?php echo htmlspecialchars($application['first_name'] . ' ' . $application['last_name']); ?>">

                                                <!-- Applicant -->
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <div class="flex-shrink-0 w-10 h-10">
                                                            <div class="flex items-center justify-center w-10 h-10 rounded-full bg-primary">
                                                                <span class="text-sm font-medium text-white">
                                                                    <?php echo strtoupper(substr($application['first_name'], 0, 1) . substr($application['last_name'], 0, 1)); ?>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="ml-4">
                                                            <div class="text-sm font-medium text-gray-900">
                                                                <?php echo htmlspecialchars($application['first_name'] . ' ' . $application['last_name']); ?>
                                                            </div>
                                                            <div class="text-sm text-gray-500">
                                                                <?php echo htmlspecialchars($application['age']); ?> years, <?php echo htmlspecialchars($application['gender']); ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>

                                                <!-- Job Title -->
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($application['job_title']); ?></div>
                                                    <div class="text-sm text-gray-500"><?php echo htmlspecialchars($application['employment_type']); ?></div>
                                                </td>

                                                <!-- Company -->
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900"><?php echo htmlspecialchars($application['company_name']); ?></div>
                                                    <div class="text-sm text-gray-500">
                                                        <?php echo htmlspecialchars($application['employer_first_name'] . ' ' . $application['employer_last_name']); ?>
                                                    </div>
                                                </td>

                                                <!-- Location -->
                                                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                    <?php echo htmlspecialchars($application['job_location']); ?>
                                                </td>

                                                <!-- Status -->
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <?php
                                                    $statusClasses = [
                                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                                        'reviewed' => 'bg-blue-100 text-blue-800',
                                                        'shortlisted' => 'bg-green-100 text-green-800',
                                                        'rejected' => 'bg-red-100 text-red-800',
                                                        'hired' => 'bg-emerald-100 text-emerald-800'
                                                    ];
                                                    $statusClass = $statusClasses[$application['application_status']] ?? 'bg-gray-100 text-gray-800';
                                                    ?>
                                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full <?php echo $statusClass; ?>">
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

                                                <!-- Contact -->
                                                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                    <div><?php echo htmlspecialchars($application['email']); ?></div>
                                                    <div><?php echo htmlspecialchars($application['phone'] ?? 'N/A'); ?></div>
                                                </td>

                                                <!-- Actions -->
                                                <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                                    <div class="flex items-center space-x-2">
                                                        <!-- View Application -->
                                                        <a href="?page=admin-view-application&id=<?php echo $application['application_id']; ?>"
                                                            class="text-primary hover:text-primary-dark" title="View Details">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                            </svg>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="py-4 border-t border-gray-200" id="paginationContainer">
                                <div class="flex items-center justify-between">
                                    <!-- Left side: Results info -->
                                    <div class="text-sm text-gray-700" id="paginationInfo">
                                        Showing <span id="showingStart">1</span> to <span id="showingEnd">10</span> of <span id="totalResults"><?php echo count($applications); ?></span> applications
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
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Keep all your existing JavaScript -->
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
                    row.textContent.toLowerCase().includes(searchValue)
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
            const totalCount = allRows.length;

            document.getElementById('visibleCount').textContent = `${visibleCount} visible`;
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

        function clearAllFilters() {
            currentFilters = {
                status: '',
                search: '',
                job: '',
                date: ''
            };

            document.getElementById('searchInput').value = '';

            // Reset Alpine.js dropdown selections
            const statusDropdown = document.querySelector('[x-data*="Status"]');
            const jobDropdown = document.querySelector('[x-data*="Job Filter"]');
            const dateDropdown = document.querySelector('[x-data*="Date Range"]');

            if (statusDropdown && statusDropdown._x_dataStack) {
                statusDropdown._x_dataStack[0].selected = 'Status';
            }
            if (jobDropdown && jobDropdown._x_dataStack) {
                jobDropdown._x_dataStack[0].selected = 'Job Filter';
            }
            if (dateDropdown && dateDropdown._x_dataStack) {
                dateDropdown._x_dataStack[0].selected = 'Date Range';
            }

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
                } else if (columnIndex === 5) { // Applied date column
                    aValue = new Date(a.dataset.applied).getTime();
                    bValue = new Date(b.dataset.applied).getTime();
                    return direction === 'asc' ? aValue - bValue : bValue - aValue;
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
                    location: cells[3].textContent.trim(),
                    status: cells[4].textContent.trim(),
                    applied: cells[5].textContent.trim(),
                    contact: cells[6].textContent.trim()
                };
            });

            if (format === 'csv') {
                exportToCSV(visibleData);
            }
        }

        function exportToCSV(data) {
            const headers = ['Applicant', 'Job Title', 'Company', 'Location', 'Status', 'Applied', 'Contact'];
            const csvContent = [
                headers.join(','),
                ...data.map(row => [
                    `"${row.applicant}"`,
                    `"${row.job_title}"`,
                    `"${row.company}"`,
                    `"${row.location}"`,
                    `"${row.status}"`,
                    `"${row.applied}"`,
                    `"${row.contact}"`
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
    </script>

</body>

</html>