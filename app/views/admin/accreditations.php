<?php
include_once __DIR__ . '/components/admin_auth_check.php';
$error = $_GET['error'] ?? '';
$success = $_GET['success'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>SIKAP Admin - Accreditations</title>
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

                <!-- Improved Stats Cards -->
                <div class="grid grid-cols-1 gap-4 mb-6 sm:gap-6 sm:mb-8 md:grid-cols-3">
                    <!-- Card 1: Pending Review -->
                    <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-6">
                        <div class="mb-4 sm:mb-6">
                            <h3 class="mb-3 text-sm font-medium text-gray-700 sm:mb-4">Pending Review</h3>
                            <div class="flex items-baseline">
                                <span class="text-2xl font-bold text-gray-900 sm:text-3xl"><?php echo count($pendingAccreditations); ?></span>
                                <svg class="ml-1 sm:ml-2" width="14px" height="14px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path d="M12 8V12L15 15M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="#F3AF0E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </g>
                                </svg>
                            </div>
                            <p class="mt-2 text-xs text-gray-500">
                                Accreditations awaiting your review
                            </p>
                        </div>
                    </div>

                    <!-- Card 2: Approved -->
                    <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-6">
                        <div class="mb-4 sm:mb-6">
                            <h3 class="mb-3 text-sm font-medium text-gray-700 sm:mb-4">Approved</h3>
                            <div class="flex items-baseline">
                                <span class="text-2xl font-bold text-gray-900 sm:text-3xl">
                                    <?php echo count(array_filter($allAccreditations, function ($acc) {
                                        return $acc['status'] === 'approved';
                                    })); ?>
                                </span>
                                <svg class="ml-1 sm:ml-2" width="14px" height="14px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path d="M9 12L11 14L15 10M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="#059669" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </g>
                                </svg>
                            </div>
                            <p class="mt-2 text-xs text-gray-500">
                                Successfully approved accreditations
                            </p>
                        </div>
                    </div>

                    <!-- Card 3: Rejected -->
                    <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-6">
                        <div class="mb-4 sm:mb-6">
                            <h3 class="mb-3 text-sm font-medium text-gray-700 sm:mb-4">Rejected</h3>
                            <div class="flex items-baseline">
                                <span class="text-2xl font-bold text-gray-900 sm:text-3xl">
                                    <?php echo count(array_filter($allAccreditations, function ($acc) {
                                        return $acc['status'] === 'rejected';
                                    })); ?>
                                </span>
                                <svg class="ml-1 sm:ml-2" width="14px" height="14px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path d="M10 14L12 12M12 12L14 10M12 12L10 10M12 12L14 14M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.2706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="#DC2626" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </g>
                                </svg>
                            </div>
                            <p class="mt-2 text-xs text-gray-500">
                                Accreditations that were declined
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Pending Accreditations -->
                <div class="mb-8">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-900">Pending Accreditations</h2>
                        <span class="px-3 py-1 text-sm text-orange-800 bg-orange-100 rounded-full">
                            <?php echo count($pendingAccreditations); ?> pending
                        </span>
                    </div>

                    <?php if (empty($pendingAccreditations)): ?>
                        <div class="p-8 text-center bg-white border border-gray-200 rounded-lg">
                            <svg class="mx-auto mb-4 text-gray-400" width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3 7V17C3 18.1046 3.89543 19 5 19H19C20.1046 19 21 18.1046 21 17V7M3 7L12 13L21 7M3 7L5 5H19L21 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <p class="text-gray-500">No pending accreditations</p>
                        </div>
                    <?php else: ?>
                        <div class="w-full overflow-hidden bg-white border border-gray-200 rounded-lg shadow-sm">
                            <!-- Desktop Table -->
                            <div class="hidden lg:block">
                                <div class="overflow-x-auto">
                                    <table class="w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-6 py-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Employer</th>
                                                <th class="px-6 py-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Company</th>
                                                <th class="px-6 py-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Industry</th>
                                                <th class="px-6 py-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Date</th>
                                                <th class="px-6 py-4 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            <?php foreach ($pendingAccreditations as $acc): ?>
                                                <tr class="hover:bg-gray-50">
                                                    <td class="px-6 py-4">
                                                        <div class="flex items-center">
                                                            <div class="flex items-center justify-center flex-shrink-0 w-10 h-10 mr-4 bg-blue-100 rounded-full">
                                                                <span class="text-sm font-medium text-primary">
                                                                    <?php echo strtoupper(substr($acc['first_name'], 0, 1) . substr($acc['last_name'], 0, 1)); ?>
                                                                </span>
                                                            </div>
                                                            <div class="min-w-0">
                                                                <div class="text-sm font-medium text-gray-900">
                                                                    <?php echo htmlspecialchars($acc['first_name'] . ' ' . $acc['last_name']); ?>
                                                                </div>
                                                                <div class="text-xs text-gray-500 truncate"><?php echo htmlspecialchars($acc['email']); ?></div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        <div class="text-sm text-gray-900">
                                                            <?php echo htmlspecialchars($acc['business_name'] ?: $acc['company_name'] ?: 'N/A'); ?>
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        <div class="text-sm text-gray-900">
                                                            <?php echo htmlspecialchars($acc['business_industry'] ?: 'N/A'); ?>
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 text-sm text-gray-500">
                                                        <?php echo date('M j, Y', strtotime($acc['created_at'])); ?>
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        <div class="flex items-center justify-center">
                                                            <div class="relative" x-data="{ open: false }">
                                                                <button @click="open = !open" @click.away="open = false"
                                                                    class="flex items-center justify-center w-8 h-8 text-gray-400 transition-colors duration-200 rounded-full hover:text-gray-600 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                                        <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                                                                    </svg>
                                                                </button>

                                                                <div x-show="open" x-transition:enter="transition ease-out duration-100"
                                                                    x-transition:enter-start="transform opacity-0 scale-95"
                                                                    x-transition:enter-end="transform opacity-100 scale-100"
                                                                    x-transition:leave="transition ease-in duration-75"
                                                                    x-transition:leave-start="transform opacity-100 scale-100"
                                                                    x-transition:leave-end="transform opacity-0 scale-95"
                                                                    class="absolute right-0 z-50 w-48 mt-2 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5"
                                                                    x-cloak>
                                                                    <div class="py-1">
                                                                        <a href="?page=admin-review-accreditation&id=<?php echo $acc['accreditation_id']; ?>"
                                                                            class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                                            <svg class="w-4 h-4 mr-3 text-blue-600" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                                <path d="M15 12C15 13.6569 13.6569 15 12 15C10.3431 15 9 13.6569 9 12C9 10.3431 10.3431 9 12 9C13.6569 9 15 10.3431 15 12Z" stroke="currentColor" stroke-width="2" />
                                                                                <path d="M2.45801 12C3.73228 7.94288 7.52257 5 12.0002 5C16.4778 5 20.2681 7.94291 21.5424 12C20.2681 16.0571 16.4778 19 12.0002 19C7.52256 19 3.73226 16.0571 2.45801 12Z" stroke="currentColor" stroke-width="2" />
                                                                            </svg>
                                                                            Review
                                                                        </a>
                                                                        <button onclick="quickVerify(<?php echo $acc['accreditation_id']; ?>, '<?php echo htmlspecialchars($acc['first_name'] . ' ' . $acc['last_name']); ?>')"
                                                                            class="flex items-center w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                                                            <svg class="w-4 h-4 mr-3 text-green-600" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                                <path d="M9 12L11 14L15 10M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                                            </svg>
                                                                            Verify
                                                                        </button>
                                                                        <button onclick="quickReject(<?php echo $acc['accreditation_id']; ?>, '<?php echo htmlspecialchars($acc['first_name'] . ' ' . $acc['last_name']); ?>')"
                                                                            class="flex items-center w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                                                            <svg class="w-4 h-4 mr-3 text-red-600" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                                <path d="M10 14L12 12M12 12L14 10M12 12L10 10M12 12L14 14M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.2706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                                            </svg>
                                                                            Reject
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Mobile/Tablet Card Layout -->
                            <div class="lg:hidden">
                                <div class="divide-y divide-gray-200">
                                    <?php foreach ($pendingAccreditations as $acc): ?>
                                        <div class="p-4 hover:bg-gray-50">
                                            <div class="flex items-start justify-between">
                                                <div class="flex items-center flex-1 min-w-0">
                                                    <div class="flex items-center justify-center flex-shrink-0 w-10 h-10 mr-3 bg-blue-100 rounded-full">
                                                        <span class="text-sm font-medium text-blue-600">
                                                            <?php echo strtoupper(substr($acc['first_name'], 0, 1) . substr($acc['last_name'], 0, 1)); ?>
                                                        </span>
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <div class="text-sm font-medium text-gray-900 truncate">
                                                            <?php echo htmlspecialchars($acc['first_name'] . ' ' . $acc['last_name']); ?>
                                                        </div>
                                                        <div class="text-xs text-gray-500 truncate"><?php echo htmlspecialchars($acc['email']); ?></div>
                                                        <div class="flex items-center mt-1 space-x-4 text-xs text-gray-500">
                                                            <span class="truncate"><?php echo htmlspecialchars($acc['business_name'] ?: $acc['company_name'] ?: 'N/A'); ?></span>
                                                            <span>•</span>
                                                            <span><?php echo date('M j, Y', strtotime($acc['created_at'])); ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex items-center flex-shrink-0 ml-4 space-x-2">
                                                    <a href="?page=admin-review-accreditation&id=<?php echo $acc['accreditation_id']; ?>"
                                                        class="p-2 text-blue-600 rounded hover:text-blue-700 hover:bg-blue-50" title="Review">
                                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M15 12C15 13.6569 13.6569 15 12 15C10.3431 15 9 13.6569 9 12C9 10.3431 10.3431 9 12 9C13.6569 9 15 10.3431 15 12Z" stroke="currentColor" stroke-width="2" />
                                                            <path d="M2.45801 12C3.73228 7.94288 7.52257 5 12.0002 5C16.4778 5 20.2681 7.94291 21.5424 12C20.2681 16.0571 16.4778 19 12.0002 19C7.52256 19 3.73226 16.0571 2.45801 12Z" stroke="currentColor" stroke-width="2" />
                                                        </svg>
                                                    </a>
                                                    <button onclick="quickVerify(<?php echo $acc['accreditation_id']; ?>, '<?php echo htmlspecialchars($acc['first_name'] . ' ' . $acc['last_name']); ?>')"
                                                        class="p-2 text-green-600 rounded hover:text-green-700 hover:bg-green-50" title="Verify">
                                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M9 12L11 14L15 10M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                        </svg>
                                                    </button>
                                                    <button onclick="quickReject(<?php echo $acc['accreditation_id']; ?>, '<?php echo htmlspecialchars($acc['first_name'] . ' ' . $acc['last_name']); ?>')"
                                                        class="p-2 text-red-600 rounded hover:text-red-700 hover:bg-red-50" title="Reject">
                                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M10 14L12 12M12 12L14 10M12 12L10 10M12 12L14 14M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.2706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- All Accreditations Section -->
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-900">All Accreditations</h2>
                        <div class="flex items-center space-x-4">
                            <!-- Status Filter -->
                            <select id="statusFilter" class="px-3 py-2 text-sm border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-primary">
                                <option value="all">All Status</option>
                                <option value="pending">Pending</option>
                                <option value="approved">Approved</option>
                                <option value="rejected">Rejected</option>
                            </select>
                            <!-- Search -->
                            <div class="relative">
                                <input type="text" id="searchInput" placeholder="Search employers..."
                                    class="py-2 pl-10 pr-4 text-sm border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-primary">
                                <svg class="absolute w-4 h-4 text-gray-400 transform -translate-y-1/2 left-3 top-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <?php if (empty($allAccreditations)): ?>
                        <div class="p-8 text-center bg-white border border-gray-200 rounded-lg">
                            <svg class="mx-auto mb-4 text-gray-400" width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3 7V17C3 18.1046 3.89543 19 5 19H19C20.1046 19 21 18.1046 21 17V7M3 7L12 13L21 7M3 7L5 5H19L21 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <p class="text-gray-500">No accreditations found</p>
                        </div>
                    <?php else: ?>
                        <div class="w-full overflow-hidden bg-white border border-gray-200 rounded-lg shadow-sm">
                            <!-- Desktop Table -->
                            <div class="hidden lg:block">
                                <div class="overflow-x-auto">
                                    <table class="w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-6 py-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Employer</th>
                                                <th class="px-6 py-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Company</th>
                                                <th class="px-6 py-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Status</th>
                                                <th class="px-6 py-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Reviewed By</th>
                                                <th class="px-6 py-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Date</th>
                                                <th class="px-6 py-4 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200" id="accreditationTableBody">
                                            <?php foreach ($allAccreditations as $acc): ?>
                                                <tr class="hover:bg-gray-50 accreditation-row"
                                                    data-status="<?php echo $acc['status']; ?>"
                                                    data-search="<?php echo strtolower($acc['first_name'] . ' ' . $acc['last_name'] . ' ' . ($acc['business_name'] ?: $acc['company_name'] ?: '')); ?>">
                                                    <td class="px-6 py-4">
                                                        <div class="flex items-center">
                                                            <div class="flex items-center justify-center flex-shrink-0 w-10 h-10 mr-4 bg-blue-100 rounded-full">
                                                                <span class="text-sm font-medium text-primary">
                                                                    <?php echo strtoupper(substr($acc['first_name'], 0, 1) . substr($acc['last_name'], 0, 1)); ?>
                                                                </span>
                                                            </div>
                                                            <div class="min-w-0">
                                                                <div class="text-sm font-medium text-gray-900">
                                                                    <?php echo htmlspecialchars($acc['first_name'] . ' ' . $acc['last_name']); ?>
                                                                </div>
                                                                <div class="text-xs text-gray-500">ID: <?php echo $acc['accreditation_id']; ?></div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        <div class="text-sm text-gray-900">
                                                            <?php echo htmlspecialchars($acc['business_name'] ?: $acc['company_name'] ?: 'N/A'); ?>
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        <?php
                                                        $statusClasses = [
                                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                                            'approved' => 'bg-green-100 text-green-800',
                                                            'rejected' => 'bg-red-100 text-red-800'
                                                        ];
                                                        $statusClass = $statusClasses[$acc['status']] ?? 'bg-gray-100 text-gray-800';
                                                        ?>
                                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full <?php echo $statusClass; ?>">
                                                            <?php echo ucfirst($acc['status']); ?>
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4 text-sm text-gray-500">
                                                        <?php echo $acc['reviewed_by_name'] ? htmlspecialchars($acc['reviewed_by_name']) : '-'; ?>
                                                    </td>
                                                    <td class="px-6 py-4 text-sm text-gray-500">
                                                        <?php echo date('M j, Y', strtotime($acc['created_at'])); ?>
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        <div class="flex items-center justify-center">
                                                            <div class="relative" x-data="{ open: false }">
                                                                <button @click="open = !open" @click.away="open = false"
                                                                    class="flex items-center justify-center w-8 h-8 text-gray-400 transition-colors duration-200 rounded-full hover:text-gray-600 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                                        <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                                                                    </svg>
                                                                </button>

                                                                <div x-show="open" x-transition:enter="transition ease-out duration-100"
                                                                    x-transition:enter-start="transform opacity-0 scale-95"
                                                                    x-transition:enter-end="transform opacity-100 scale-100"
                                                                    x-transition:leave="transition ease-in duration-75"
                                                                    x-transition:leave-start="transform opacity-100 scale-100"
                                                                    x-transition:leave-end="transform opacity-0 scale-95"
                                                                    class="absolute right-0 z-50 w-48 mt-2 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5"
                                                                    x-cloak>
                                                                    <div class="py-1">
                                                                        <a href="?page=admin-review-accreditation&id=<?php echo $acc['accreditation_id']; ?>"
                                                                            class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                                            <svg class="w-4 h-4 mr-3 text-blue-600" viewBox="0 0 24 24" fill="none">
                                                                                <path d="M15 12C15 13.6569 13.6569 15 12 15C10.3431 15 9 13.6569 9 12C9 10.3431 10.3431 9 12 9C13.6569 9 15 10.3431 15 12Z" stroke="currentColor" stroke-width="2" />
                                                                                <path d="M2.45801 12C3.73228 7.94288 7.52257 5 12.0002 5C16.4778 5 20.2681 7.94291 21.5424 12C20.2681 16.0571 16.4778 19 12.0002 19C7.52256 19 3.73226 16.0571 2.45801 12Z" stroke="currentColor" stroke-width="2" />
                                                                            </svg>
                                                                            Review Details
                                                                        </a>
                                                                        <?php if ($acc['status'] === 'pending'): ?>
                                                                            <button onclick="quickVerify(<?php echo $acc['accreditation_id']; ?>, '<?php echo htmlspecialchars($acc['first_name'] . ' ' . $acc['last_name']); ?>')"
                                                                                class="flex items-center w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                                                                <svg class="w-4 h-4 mr-3 text-green-600" viewBox="0 0 24 24" fill="none">
                                                                                    <path d="M9 12L11 14L15 10M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                                                </svg>
                                                                                Approve
                                                                            </button>
                                                                            <button onclick="quickReject(<?php echo $acc['accreditation_id']; ?>, '<?php echo htmlspecialchars($acc['first_name'] . ' ' . $acc['last_name']); ?>')"
                                                                                class="flex items-center w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                                                                <svg class="w-4 h-4 mr-3 text-red-600" viewBox="0 0 24 24" fill="none">
                                                                                    <path d="M10 14L12 12M12 12L14 10M12 12L10 10M12 12L14 14M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.2706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                                                </svg>
                                                                                Reject
                                                                            </button>
                                                                        <?php else: ?>
                                                                            <button onclick="resetToPending(<?php echo $acc['accreditation_id']; ?>, '<?php echo htmlspecialchars($acc['first_name'] . ' ' . $acc['last_name']); ?>')"
                                                                                class="flex items-center w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                                                                <svg class="w-4 h-4 mr-3 text-yellow-600" viewBox="0 0 24 24" fill="none">
                                                                                    <path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                                                </svg>
                                                                                Reset to Pending
                                                                            </button>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Mobile/Tablet Card Layout for All Accreditations -->
                            <div class="lg:hidden">
                                <div class="divide-y divide-gray-200" id="accreditationMobileList">
                                    <?php foreach ($allAccreditations as $acc): ?>
                                        <div class="p-4 hover:bg-gray-50 accreditation-mobile-card"
                                            data-status="<?php echo $acc['status']; ?>"
                                            data-search="<?php echo strtolower($acc['first_name'] . ' ' . $acc['last_name'] . ' ' . ($acc['business_name'] ?: $acc['company_name'] ?: '')); ?>">
                                            <div class="flex items-start justify-between">
                                                <div class="flex items-center flex-1 min-w-0">
                                                    <div class="flex items-center justify-center flex-shrink-0 w-10 h-10 mr-3 bg-blue-100 rounded-full">
                                                        <span class="text-sm font-medium text-blue-600">
                                                            <?php echo strtoupper(substr($acc['first_name'], 0, 1) . substr($acc['last_name'], 0, 1)); ?>
                                                        </span>
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <div class="text-sm font-medium text-gray-900 truncate">
                                                            <?php echo htmlspecialchars($acc['first_name'] . ' ' . $acc['last_name']); ?>
                                                        </div>
                                                        <div class="flex items-center mt-1 space-x-2">
                                                            <?php
                                                            $statusClasses = [
                                                                'pending' => 'bg-yellow-100 text-yellow-800',
                                                                'approved' => 'bg-green-100 text-green-800',
                                                                'rejected' => 'bg-red-100 text-red-800'
                                                            ];
                                                            $statusClass = $statusClasses[$acc['status']] ?? 'bg-gray-100 text-gray-800';
                                                            ?>
                                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full <?php echo $statusClass; ?>">
                                                                <?php echo ucfirst($acc['status']); ?>
                                                            </span>
                                                        </div>
                                                        <div class="flex items-center mt-1 space-x-4 text-xs text-gray-500">
                                                            <span class="truncate"><?php echo htmlspecialchars($acc['business_name'] ?: $acc['company_name'] ?: 'N/A'); ?></span>
                                                            <span>•</span>
                                                            <span><?php echo date('M j, Y', strtotime($acc['created_at'])); ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex items-center flex-shrink-0 ml-4 space-x-2">
                                                    <a href="?page=admin-review-accreditation&id=<?php echo $acc['accreditation_id']; ?>"
                                                        class="p-2 text-blue-600 rounded hover:text-blue-700 hover:bg-blue-50" title="Review">
                                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                                            <path d="M15 12C15 13.6569 13.6569 15 12 15C10.3431 15 9 13.6569 9 12C9 10.3431 10.3431 9 12 9C13.6569 9 15 10.3431 15 12Z" stroke="currentColor" stroke-width="2" />
                                                            <path d="M2.45801 12C3.73228 7.94288 7.52257 5 12.0002 5C16.4778 5 20.2681 7.94291 21.5424 12C20.2681 16.0571 16.4778 19 12.0002 19C7.52256 19 3.73226 16.0571 2.45801 12Z" stroke="currentColor" stroke-width="2" />
                                                        </svg>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Quick verify function
        function quickVerify(accreditationId, employerName) {
            Swal.fire({
                title: 'Verify Employer',
                text: `Are you sure you want to verify ${employerName}?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#059669',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, Verify',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('accreditationId').value = accreditationId;
                    document.getElementById('accreditationStatus').value = 'approved';
                    document.getElementById('accreditationNotes').value = 'Quick approval by admin';
                    document.getElementById('accreditationForm').submit();
                }
            });
        }

        // Quick reject function
        function quickReject(accreditationId, employerName) {
            Swal.fire({
                title: 'Reject Application',
                text: `Are you sure you want to reject ${employerName}'s application?`,
                icon: 'warning',
                input: 'textarea',
                inputPlaceholder: 'Enter reason for rejection (optional)',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, Reject',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('accreditationId').value = accreditationId;
                    document.getElementById('accreditationStatus').value = 'rejected';
                    document.getElementById('accreditationNotes').value = result.value || 'Rejected by admin';
                    document.getElementById('accreditationForm').submit();
                }
            });
        }

        // Reset to pending function
        function resetToPending(accreditationId, employerName) {
            Swal.fire({
                title: 'Reset to Pending',
                text: `Are you sure you want to reset ${employerName}'s accreditation to pending status?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#f59e0b',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, Reset',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('accreditationId').value = accreditationId;
                    document.getElementById('accreditationStatus').value = 'pending';
                    document.getElementById('accreditationNotes').value = 'Reset to pending by admin';
                    document.getElementById('accreditationForm').submit();
                }
            });
        }

        // Filter and search functionality
        document.addEventListener('DOMContentLoaded', function() {
            const statusFilter = document.getElementById('statusFilter');
            const searchInput = document.getElementById('searchInput');
            const tableRows = document.querySelectorAll('.accreditation-row');
            const mobileCards = document.querySelectorAll('.accreditation-mobile-card');

            function filterAccreditations() {
                const statusValue = statusFilter.value;
                const searchValue = searchInput.value.toLowerCase();

                // Filter table rows
                tableRows.forEach(row => {
                    const status = row.dataset.status;
                    const searchText = row.dataset.search;

                    const statusMatch = statusValue === 'all' || status === statusValue;
                    const searchMatch = searchText.includes(searchValue);

                    row.style.display = statusMatch && searchMatch ? '' : 'none';
                });

                // Filter mobile cards
                mobileCards.forEach(card => {
                    const status = card.dataset.status;
                    const searchText = card.dataset.search;

                    const statusMatch = statusValue === 'all' || status === statusValue;
                    const searchMatch = searchText.includes(searchValue);

                    card.style.display = statusMatch && searchMatch ? '' : 'none';
                });
            }

            statusFilter.addEventListener('change', filterAccreditations);
            searchInput.addEventListener('input', filterAccreditations);
        });
    </script>

</body>

</html>