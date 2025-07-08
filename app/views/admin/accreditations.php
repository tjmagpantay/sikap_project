<?php
// filepath: app/views/admin/accreditations.php
$error = $_GET['error'] ?? '';
$success = $_GET['success'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accreditations - SIKAP Admin</title>
    <link href="css/output.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <?php include __DIR__ . '/components/sidebar.php'; ?>
        
        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Navigation -->
            <?php include __DIR__ . '/components/topbar.php'; ?>
            
            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto bg-gray-50">
                <div class="p-6">
                    <!-- Page Header -->
                    <div class="mb-6">
                        <h1 class="text-2xl font-semibold text-gray-900">Accreditations</h1>
                        <p class="text-gray-600 mt-1">Manage employer accreditation requests</p>
                    </div>

                    <!-- Messages -->
                    <?php if ($error): ?>
                        <div class="p-4 mb-6 text-red-700 bg-red-100 border border-red-200 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                <?php echo htmlspecialchars($error); ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ($success): ?>
                        <div class="p-4 mb-6 text-green-700 bg-green-100 border border-green-200 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-check-circle mr-2"></i>
                                <?php echo htmlspecialchars($success); ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Stats Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div class="bg-white rounded-lg border border-gray-200 p-6">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-clock text-orange-600"></i>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm text-gray-600">Pending Review</p>
                                    <p class="text-2xl font-bold text-gray-900"><?php echo count($pendingAccreditations); ?></p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-white rounded-lg border border-gray-200 p-6">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-check-circle text-green-600"></i>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm text-gray-600">Approved</p>
                                    <p class="text-2xl font-bold text-gray-900">
                                        <?php echo count(array_filter($allAccreditations, function($acc) { return $acc['status'] === 'approved'; })); ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-white rounded-lg border border-gray-200 p-6">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-times-circle text-red-600"></i>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm text-gray-600">Rejected</p>
                                    <p class="text-2xl font-bold text-gray-900">
                                        <?php echo count(array_filter($allAccreditations, function($acc) { return $acc['status'] === 'rejected'; })); ?>
                                    </p>
                                </div>
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
                            <div class="bg-white rounded-lg border border-gray-200 p-8 text-center">
                                <i class="fas fa-inbox text-gray-400 text-4xl mb-4"></i>
                                <p class="text-gray-500">No pending accreditations</p>
                            </div>
                        <?php else: ?>
                            <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Employer</th>
                                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Company</th>
                                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Industry</th>
                                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Submitted</th>
                                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <?php foreach ($pendingAccreditations as $acc): ?>
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                                            <span class="text-blue-600 font-medium text-sm">
                                                                <?php echo strtoupper(substr($acc['first_name'], 0, 1) . substr($acc['last_name'], 0, 1)); ?>
                                                            </span>
                                                        </div>
                                                        <div>
                                                            <div class="text-sm font-medium text-gray-900">
                                                                <?php echo htmlspecialchars($acc['first_name'] . ' ' . $acc['last_name']); ?>
                                                            </div>
                                                            <div class="text-sm text-gray-500"><?php echo htmlspecialchars($acc['email']); ?></div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900">
                                                        <?php echo htmlspecialchars($acc['business_name'] ?: $acc['company_name'] ?: 'N/A'); ?>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900">
                                                        <?php echo htmlspecialchars($acc['business_industry'] ?: 'N/A'); ?>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    <?php echo date('M j, Y', strtotime($acc['created_at'])); ?>
                                                </td>
                                                <td class="px-6 py-4 text-sm font-medium whitespace-nowrap">
                                                    <div class="flex space-x-3">
                                                        <a href="?page=admin-review-accreditation&id=<?php echo $acc['accreditation_id']; ?>" 
                                                           class="text-blue-600 hover:text-blue-700">
                                                            <i class="fas fa-eye mr-1"></i>Review
                                                        </a>
                                                        
                                                        <button onclick="quickVerify(<?php echo $acc['accreditation_id']; ?>, '<?php echo htmlspecialchars($acc['first_name'] . ' ' . $acc['last_name']); ?>')"
                                                                class="text-green-600 hover:text-green-700">
                                                            <i class="fas fa-check-circle mr-1"></i>Verify
                                                        </button>
                                                        
                                                        <button onclick="quickReject(<?php echo $acc['accreditation_id']; ?>, '<?php echo htmlspecialchars($acc['first_name'] . ' ' . $acc['last_name']); ?>')"
                                                                class="text-red-600 hover:text-red-700">
                                                            <i class="fas fa-times-circle mr-1"></i>Reject
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

                    <!-- All Accreditations -->
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">All Accreditations</h2>

                        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Employer</th>
                                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Company</th>
                                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Status</th>
                                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Reviewed By</th>
                                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Date</th>
                                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <?php foreach ($allAccreditations as $acc): ?>
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center mr-3">
                                                        <span class="text-gray-600 font-medium text-xs">
                                                            <?php echo strtoupper(substr($acc['first_name'], 0, 1) . substr($acc['last_name'], 0, 1)); ?>
                                                        </span>
                                                    </div>
                                                    <div class="text-sm font-medium text-gray-900">
                                                        <?php echo htmlspecialchars($acc['first_name'] . ' ' . $acc['last_name']); ?>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    <?php echo htmlspecialchars($acc['business_name'] ?: $acc['company_name'] ?: 'N/A'); ?>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                                    <?php 
                                                    echo $acc['status'] === 'approved' ? 'text-green-800 bg-green-100' : 
                                                        ($acc['status'] === 'rejected' ? 'text-red-800 bg-red-100' : 'text-yellow-800 bg-yellow-100'); 
                                                    ?>">
                                                    <?php echo ucfirst($acc['status']); ?>
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                <?php echo htmlspecialchars($acc['reviewed_by_name'] ?: 'N/A'); ?>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                <?php echo date('M j, Y', strtotime($acc['created_at'])); ?>
                                            </td>
                                            <td class="px-6 py-4 text-sm font-medium whitespace-nowrap">
                                                <a href="?page=admin-review-accreditation&id=<?php echo $acc['accreditation_id']; ?>" 
                                                   class="text-blue-600 hover:text-blue-700">
                                                    <i class="fas fa-eye mr-1"></i>View
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Mobile Menu Overlay -->
    <div id="mobile-menu-overlay" class="fixed inset-0 z-40 bg-black bg-opacity-50 lg:hidden hidden"></div>

    <!-- Quick Action Modals -->
    <div id="verifyModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100">
                    <i class="fas fa-check h-6 w-6 text-green-600"></i>
                </div>
                <h3 class="text-lg leading-6 font-medium text-gray-900 mt-2">Verify Employer</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500" id="verifyEmployerName">
                        Are you sure you want to verify this employer?
                    </p>
                    <form id="verifyForm" method="POST" action="?page=admin-process-accreditation" class="mt-4">
                        <input type="hidden" name="accreditation_id" id="verifyAccreditationId">
                        <input type="hidden" name="status" value="approved">
                        <textarea name="notes" placeholder="Optional verification notes..." 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm" rows="3"></textarea>
                    </form>
                </div>
                <div class="items-center px-4 py-3">
                    <button onclick="document.getElementById('verifyForm').submit()"
                            class="px-4 py-2 bg-green-500 text-white text-base font-medium rounded-md w-24 mr-2 hover:bg-green-600">
                        Verify
                    </button>
                    <button onclick="closeModal('verifyModal')"
                            class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-24 hover:bg-gray-600">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                    <i class="fas fa-times h-6 w-6 text-red-600"></i>
                </div>
                <h3 class="text-lg leading-6 font-medium text-gray-900 mt-2">Reject Application</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500" id="rejectEmployerName">
                        Are you sure you want to reject this application?
                    </p>
                    <form id="rejectForm" method="POST" action="?page=admin-process-accreditation" class="mt-4">
                        <input type="hidden" name="accreditation_id" id="rejectAccreditationId">
                        <input type="hidden" name="status" value="rejected">
                        <textarea name="notes" placeholder="Reason for rejection (required)..." 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm" rows="3" required></textarea>
                    </form>
                </div>
                <div class="items-center px-4 py-3">
                    <button onclick="document.getElementById('rejectForm').submit()"
                            class="px-4 py-2 bg-red-500 text-white text-base font-medium rounded-md w-24 mr-2 hover:bg-red-600">
                        Reject
                    </button>
                    <button onclick="closeModal('rejectModal')"
                            class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-24 hover:bg-gray-600">
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
</body>
</html>