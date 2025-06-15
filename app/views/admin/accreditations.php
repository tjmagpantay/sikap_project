<?php
// Create file: app/views/admin/accreditations.php

include_once __DIR__ . '/../components/navbar-top.php';

$error = $_GET['error'] ?? '';
$success = $_GET['success'] ?? '';
?>

<div class="min-h-screen bg-gray-50">
    <!-- Admin Navigation -->
    <nav class="bg-gray-800 shadow">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center space-x-8">
                    <h1 class="text-xl font-semibold text-white">Admin Dashboard</h1>
                    <div class="hidden space-x-4 md:flex">
                        <a href="?page=admin-dashboard" class="text-gray-300 hover:text-white">Dashboard</a>
                        <a href="?page=admin-accreditations" class="text-white border-b-2 border-blue-500">Accreditations</a>
                    </div>
                </div>
                <div class="flex items-center">
                    <span class="mr-4 text-gray-300">Admin Panel</span>
                    <a href="?page=logout" class="text-red-400 hover:underline">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            
            <!-- Messages -->
            <?php if ($error): ?>
                <div class="p-4 mb-6 text-red-700 bg-red-100 border border-red-200 rounded-md">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="p-4 mb-6 text-green-700 bg-green-100 border border-green-200 rounded-md">
                    <?php echo htmlspecialchars($success); ?>
                </div>
            <?php endif; ?>

            <!-- Pending Accreditations -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-medium text-gray-900">Pending Accreditations</h2>
                    <span class="px-2 py-1 text-sm text-orange-800 bg-orange-100 rounded-full">
                        <?php echo count($pendingAccreditations); ?> pending
                    </span>
                </div>

                <?php if (empty($pendingAccreditations)): ?>
                    <div class="p-6 text-center bg-white rounded-lg shadow">
                        <p class="text-gray-500">No pending accreditations</p>
                    </div>
                <?php else: ?>
                    <div class="overflow-hidden bg-white shadow rounded-lg">
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
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">
                                                    <?php echo htmlspecialchars($acc['first_name'] . ' ' . $acc['last_name']); ?>
                                                </div>
                                                <div class="text-sm text-gray-500"><?php echo htmlspecialchars($acc['email']); ?></div>
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
                                            <div class="flex space-x-2">
                                                <a href="?page=admin-review-accreditation&id=<?php echo $acc['accreditation_id']; ?>" 
                                                   class="text-blue-600 hover:text-blue-900">
                                                    <i class="fas fa-eye mr-1"></i>Review
                                                </a>
                                                
                                                <!-- Quick Verify Button -->
                                                <button onclick="quickVerify(<?php echo $acc['accreditation_id']; ?>, '<?php echo htmlspecialchars($acc['first_name'] . ' ' . $acc['last_name']); ?>')"
                                                        class="text-green-600 hover:text-green-900">
                                                    <i class="fas fa-check-circle mr-1"></i>Verify
                                                </button>
                                                
                                                <!-- Quick Reject Button -->
                                                <button onclick="quickReject(<?php echo $acc['accreditation_id']; ?>, '<?php echo htmlspecialchars($acc['first_name'] . ' ' . $acc['last_name']); ?>')"
                                                        class="text-red-600 hover:text-red-900">
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
                <h2 class="mb-4 text-lg font-medium text-gray-900">All Accreditations</h2>

                <div class="overflow-hidden bg-white shadow rounded-lg">
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
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            <?php echo htmlspecialchars($acc['first_name'] . ' ' . $acc['last_name']); ?>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            <?php echo htmlspecialchars($acc['business_name'] ?: $acc['company_name'] ?: 'N/A'); ?>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 text-xs font-semibold leading-5 rounded-full 
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
                                           class="text-blue-600 hover:text-blue-900">View</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Quick Action Modals -->
<div id="verifyModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
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

<div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
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

</div>