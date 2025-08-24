<?php
// filepath: app/views/admin/accreditations.php
$error = $_GET['error'] ?? '';
$success = $_GET['success'] ?? '';
?>

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
                                <span class="text-2xl font-bold text-orange-600 sm:text-3xl"><?php echo count($pendingAccreditations); ?></span>
                                <svg class="ml-1 sm:ml-2" width="14px" height="14px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path d="M12 8V12L15 15M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="#EA580C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
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
                                <span class="text-2xl font-bold text-green-600 sm:text-3xl">
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
                                <span class="text-2xl font-bold text-red-600 sm:text-3xl">
                                    <?php echo count(array_filter($allAccreditations, function ($acc) {
                                        return $acc['status'] === 'rejected';
                                    })); ?>
                                </span>
                                <svg class="ml-1 sm:ml-2" width="14px" height="14px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path d="M10 14L12 12M12 12L14 10M12 12L10 10M12 12L14 14M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="#DC2626" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
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
                                    <table class="w-full table-auto divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="w-1/4 px-6 py-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Employer</th>
                                                <th class="w-1/4 px-6 py-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Company</th>
                                                <th class="w-1/6 px-6 py-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Industry</th>
                                                <th class="w-1/6 px-6 py-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Date</th>
                                                <th class="w-1/6 px-6 py-4 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            <?php foreach ($pendingAccreditations as $acc): ?>
                                                <tr class="hover:bg-gray-50">
                                                    <td class="px-6 py-4">
                                                        <div class="flex items-center">
                                                            <div class="flex items-center justify-center w-10 h-10 mr-4 bg-blue-100 rounded-full flex-shrink-0">
                                                                <span class="text-sm font-medium text-blue-600">
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
                                                        <?php echo date('M j', strtotime($acc['created_at'])); ?>
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        <div class="flex items-center justify-center space-x-2">
                                                            <a href="?page=admin-review-accreditation&id=<?php echo $acc['accreditation_id']; ?>"
                                                                class="p-2 text-blue-600 hover:text-blue-700 hover:bg-blue-50 rounded-lg transition-colors"
                                                                title="Review">
                                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M15 12C15 13.6569 13.6569 15 12 15C10.3431 15 9 13.6569 9 12C9 10.3431 10.3431 9 12 9C13.6569 9 15 10.3431 15 12Z" stroke="currentColor" stroke-width="2" />
                                                                    <path d="M2.45801 12C3.73228 7.94288 7.52257 5 12.0002 5C16.4778 5 20.2681 7.94291 21.5424 12C20.2681 16.0571 16.4778 19 12.0002 19C7.52256 19 3.73226 16.0571 2.45801 12Z" stroke="currentColor" stroke-width="2" />
                                                                </svg>
                                                            </a>

                                                            <button onclick="quickVerify(<?php echo $acc['accreditation_id']; ?>, '<?php echo htmlspecialchars($acc['first_name'] . ' ' . $acc['last_name']); ?>')"
                                                                class="p-2 text-green-600 hover:text-green-700 hover:bg-green-50 rounded-lg transition-colors"
                                                                title="Verify">
                                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M9 12L11 14L15 10M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                                </svg>
                                                            </button>

                                                            <button onclick="quickReject(<?php echo $acc['accreditation_id']; ?>, '<?php echo htmlspecialchars($acc['first_name'] . ' ' . $acc['last_name']); ?>')"
                                                                class="p-2 text-red-600 hover:text-red-700 hover:bg-red-50 rounded-lg transition-colors"
                                                                title="Reject">
                                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M10 14L12 12M12 12L14 10M12 12L10 10M12 12L14 14M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                                </svg>
                                                            </button>
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
                                                    <div class="flex items-center justify-center w-10 h-10 mr-3 bg-blue-100 rounded-full flex-shrink-0">
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
                                                            <span><?php echo date('M j', strtotime($acc['created_at'])); ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex items-center ml-4 space-x-2 flex-shrink-0">
                                                    <a href="?page=admin-review-accreditation&id=<?php echo $acc['accreditation_id']; ?>"
                                                        class="p-2 text-blue-600 hover:text-blue-700 hover:bg-blue-50 rounded"
                                                        title="Review">
                                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M15 12C15 13.6569 13.6569 15 12 15C10.3431 15 9 13.6569 9 12C9 10.3431 10.3431 9 12 9C13.6569 9 15 10.3431 15 12Z" stroke="currentColor" stroke-width="2" />
                                                            <path d="M2.45801 12C3.73228 7.94288 7.52257 5 12.0002 5C16.4778 5 20.2681 7.94291 21.5424 12C20.2681 16.0571 16.4778 19 12.0002 19C7.52256 19 3.73226 16.0571 2.45801 12Z" stroke="currentColor" stroke-width="2" />
                                                        </svg>
                                                    </a>

                                                    <button onclick="quickVerify(<?php echo $acc['accreditation_id']; ?>, '<?php echo htmlspecialchars($acc['first_name'] . ' ' . $acc['last_name']); ?>')"
                                                        class="p-2 text-green-600 hover:text-green-700 hover:bg-green-50 rounded"
                                                        title="Verify">
                                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M9 12L11 14L15 10M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                        </svg>
                                                    </button>

                                                    <button onclick="quickReject(<?php echo $acc['accreditation_id']; ?>, '<?php echo htmlspecialchars($acc['first_name'] . ' ' . $acc['last_name']); ?>')"
                                                        class="p-2 text-red-600 hover:text-red-700 hover:bg-red-50 rounded"
                                                        title="Reject">
                                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M10 14L12 12M12 12L14 10M12 12L10 10M12 12L14 14M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
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

                <div>
                    <h2 class="mb-6 text-lg font-semibold text-gray-900">All Accreditations</h2>

                    <div class="w-full overflow-hidden bg-white border border-gray-200 rounded-lg shadow-sm">
                        <div class="overflow-x-auto">
                            <table class="w-full table-auto divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="w-1/5 px-6 py-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Employer</th>
                                        <th class="w-1/5 px-6 py-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Company</th>
                                        <th class="w-1/6 px-6 py-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Status</th>
                                        <th class="w-1/6 px-6 py-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Reviewed By</th>
                                        <th class="w-1/6 px-6 py-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Date</th>
                                        <th class="w-1/6 px-6 py-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <?php foreach ($allAccreditations as $acc): ?>
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4">
                                                <div class="flex items-center">
                                                    <div class="flex items-center justify-center w-10 h-10 mr-4 bg-gray-100 rounded-full flex-shrink-0">
                                                        <span class="text-sm font-medium text-gray-600">
                                                            <?php echo strtoupper(substr($acc['first_name'], 0, 1) . substr($acc['last_name'], 0, 1)); ?>
                                                        </span>
                                                    </div>
                                                    <div class="min-w-0">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            <?php echo htmlspecialchars($acc['first_name'] . ' ' . $acc['last_name']); ?>
                                                        </div>
                                                        <div class="text-xs text-gray-500 truncate"><?php echo htmlspecialchars($acc['email'] ?? 'N/A'); ?></div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-900">
                                                    <?php echo htmlspecialchars($acc['business_name'] ?: $acc['company_name'] ?: 'N/A'); ?>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full 
                                                        <?php
                                                        echo $acc['status'] === 'approved' ? 'text-green-800 bg-green-100' : ($acc['status'] === 'rejected' ? 'text-red-800 bg-red-100' : 'text-yellow-800 bg-yellow-100');
                                                        ?>">
                                                    <?php echo ucfirst($acc['status']); ?>
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500">
                                                <?php echo htmlspecialchars($acc['reviewed_by_name'] ?: 'N/A'); ?>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500">
                                                <?php echo date('M j, Y', strtotime($acc['created_at'])); ?>
                                            </td>
                                            <td class="px-6 py-4">
                                                <a href="?page=admin-review-accreditation&id=<?php echo $acc['accreditation_id']; ?>"
                                                    class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-blue-600 hover:text-blue-700 hover:bg-blue-50 rounded-lg transition-colors">
                                                    <svg class="w-4 h-4 mr-1" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M15 12C15 13.6569 13.6569 15 12 15C10.3431 15 9 13.6569 9 12C9 10.3431 10.3431 9 12 9C13.6569 9 15 10.3431 15 12Z" stroke="currentColor" stroke-width="2" />
                                                        <path d="M2.45801 12C3.73228 7.94288 7.52257 5 12.0002 5C16.4778 5 20.2681 7.94291 21.5424 12C20.2681 16.0571 16.4778 19 12.0002 19C7.52256 19 3.73226 16.0571 2.45801 12Z" stroke="currentColor" stroke-width="2" />
                                                    </svg>
                                                    View
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div> <!-- Mobile Menu Overlay -->
<div id="mobile-menu-overlay" class="fixed inset-0 z-40 hidden bg-black bg-opacity-50 lg:hidden"></div>

<!-- Quick Action Modals -->
<div id="verifyModal" class="fixed inset-0 z-50 hidden w-full h-full overflow-y-auto bg-gray-600 bg-opacity-50">
    <div class="relative p-5 mx-auto bg-white border rounded-md shadow-lg top-20 w-96">
        <div class="mt-3 text-center">
            <div class="flex items-center justify-center w-12 h-12 mx-auto bg-green-100 rounded-full">
                <i class="w-6 h-6 text-green-600 fas fa-check"></i>
            </div>
            <h3 class="mt-2 text-lg font-medium leading-6 text-gray-900">Verify Employer</h3>
            <div class="py-3 mt-2 px-7">
                <p class="text-sm text-gray-500" id="verifyEmployerName">
                    Are you sure you want to verify this employer?
                </p>
                <form id="verifyForm" method="POST" action="?page=admin-process-accreditation" class="mt-4">
                    <input type="hidden" name="accreditation_id" id="verifyAccreditationId">
                    <input type="hidden" name="status" value="approved">
                    <textarea name="notes" placeholder="Optional verification notes..."
                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md" rows="3"></textarea>
                </form>
            </div>
            <div class="items-center px-4 py-3">
                <button onclick="document.getElementById('verifyForm').submit()"
                    class="w-24 px-4 py-2 mr-2 text-base font-medium text-white bg-green-500 rounded-md hover:bg-green-600">
                    Verify
                </button>
                <button onclick="closeModal('verifyModal')"
                    class="w-24 px-4 py-2 text-base font-medium text-white bg-gray-500 rounded-md hover:bg-gray-600">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>

<div id="rejectModal" class="fixed inset-0 z-50 hidden w-full h-full overflow-y-auto bg-gray-600 bg-opacity-50">
    <div class="relative p-5 mx-auto bg-white border rounded-md shadow-lg top-20 w-96">
        <div class="mt-3 text-center">
            <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 rounded-full">
                <i class="w-6 h-6 text-red-600 fas fa-times"></i>
            </div>
            <h3 class="mt-2 text-lg font-medium leading-6 text-gray-900">Reject Application</h3>
            <div class="py-3 mt-2 px-7">
                <p class="text-sm text-gray-500" id="rejectEmployerName">
                    Are you sure you want to reject this application?
                </p>
                <form id="rejectForm" method="POST" action="?page=admin-process-accreditation" class="mt-4">
                    <input type="hidden" name="accreditation_id" id="rejectAccreditationId">
                    <input type="hidden" name="status" value="rejected">
                    <textarea name="notes" placeholder="Reason for rejection (required)..."
                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md" rows="3" required></textarea>
                </form>
            </div>
            <div class="items-center px-4 py-3">
                <button onclick="document.getElementById('rejectForm').submit()"
                    class="w-24 px-4 py-2 mr-2 text-base font-medium text-white bg-red-500 rounded-md hover:bg-red-600">
                    Reject
                </button>
                <button onclick="closeModal('rejectModal')"
                    class="w-24 px-4 py-2 text-base font-medium text-white bg-gray-500 rounded-md hover:bg-gray-600">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>

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

    function quickVerify(accreditationId, employerName) {
        document.getElementById('verifyAccreditationId').value = accreditationId;
        document.getElementById('verifyEmployerName').textContent = `Are you sure you want to verify ${employerName}?`;
        document.getElementById('verifyModal').classList.remove('hidden');
    }

    function quickReject(accreditationId, employerName) {
        document.getElementById('rejectAccreditationId').value = accreditationId;
        document.getElementById('rejectEmployerName').textContent = `Are you sure you want to reject ${employerName}'s application?`;
        document.getElementById('rejectModal').classList.remove('hidden');
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
        const verifyModal = document.getElementById('verifyModal');
        const rejectModal = document.getElementById('rejectModal');
        if (event.target == verifyModal) {
            verifyModal.classList.add('hidden');
        }
        if (event.target == rejectModal) {
            rejectModal.classList.add('hidden');
        }
    }
</script>