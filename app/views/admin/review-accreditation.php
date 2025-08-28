<?php
include_once __DIR__ . '/components/admin_auth_check.php';

// Document types
$documentTypes = [
    'letter_of_intent' => 'Letter of Intent',
    'company_profile' => 'Company Profile',
    'business_permit' => 'Business Permit',
    'cert_of_no_pending_case' => 'Certificate of No Pending Case',
    'dole_registration' => 'DOLE Registration',
    'cert_no_objection' => 'Certificate of No Objection',
    'poea_reg' => 'POEA Registration',
    'job_vaccancies_qual' => 'Job Vacancies & Qualifications',
    'phil_jobnet_reg' => 'PhilJobNet Registration'
];

// Count uploaded documents
$uploadedDocs = 0;
if ($documents) {
    foreach ($documentTypes as $type => $label) {
        if (!empty($documents[$type])) {
            $uploadedDocs++;
        }
    }
}
?>

<div class="flex h-screen">
    <!-- Sidebar -->
    <?php include __DIR__ . '/components/sidebar.php'; ?>

    <!-- Main Content Area -->
    <div class="flex flex-col flex-1 overflow-hidden ">
        <!-- Top Navigation -->
        <?php include __DIR__ . '/components/topbar.php'; ?>

        <!-- Main Content Area -->
        <main class="flex-1 px-6 overflow-y-auto bg-gray-50">
            <div class="py-8 mx-auto sm:px-2 md:px-4 lg:px-12 max-w-7xl">
                <!-- Header with breadcrumbs --> 
                <div class="mb-8">
                    <!-- Breadcrumb Navigation -->
                    <nav class="flex mb-4" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 md:space-x-3">
                            <li class="inline-flex items-center">
                                <a href="?page=admin-dashboard" class="inline-flex items-center text-sm text-gray-400 hover:text-gray-600">
                                    Dashboard
                                </a>
                            </li>
                            <li>
                                <div class="flex items-center">
                                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                    </svg>
                                    <a href="?page=admin-accreditations" class="ml-1 text-sm text-gray-400 hover:text-gray-600 md:ml-2">
                                        Accreditations
                                    </a>
                                </div>
                            </li>
                            <li aria-current="page">
                                <div class="flex items-center">
                                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="ml-1 text-sm font-medium text-primary md:ml-2">Review Accreditation</span>
                                </div>
                            </li>
                        </ol>
                    </nav>
                   
                </div>

                <!-- Main Flex Layout -->
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

         
                        <!-- Left Section - Main Content (8/12 width) -->
                        <div class="w-full space-y-6 md:w-8/12">

                            <!-- Header Card -->
                            <div class="overflow-hidden bg-white border border-gray-200 rounded-lg shadow">
                                <div class="p-6">
                                    <!-- Employer Name and Status Badges -->
                                    <div class="flex items-start justify-between mb-6">
                                        <div>
                                            <h1 class="text-xl font-semibold text-gray-900">
                                                <?php echo htmlspecialchars($accreditation['first_name'] . ' ' . $accreditation['last_name']); ?>
                                            </h1>
                                            <p class="mt-1 text-sm text-gray-600"><?php echo htmlspecialchars($accreditation['email']); ?></p>
                                            <div class="flex items-center gap-3 mt-2">
                                                <!-- Status Badge -->
                                                <span class="inline-flex items-center px-3 py-1 rounded-sm text-xs font-medium
                                                <?php
                                                echo $accreditation['status'] === 'approved' ? 'bg-green-100 text-green-800' : ($accreditation['status'] === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800');
                                                ?>">
                                                    <?php echo strtoupper($accreditation['status']); ?>
                                                </span>

                                                <!-- Document Status Badge -->
                                                <span class="inline-flex items-center px-3 py-1 text-xs font-medium bg-blue-100 rounded-sm text-primary">
                                                    <?php echo $uploadedDocs; ?>/<?php echo count($documentTypes); ?> DOCUMENTS
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Employer Information Grid -->
                                    <div class="mb-8">
                                        <h2 class="mb-4 font-semibold text-primary text-md">Personal Information</h2>
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <div class="text-xs text-gray-400">Position</div>
                                                <div class="text-sm text-primary"><?php echo htmlspecialchars($accreditation['position'] ?? 'N/A'); ?></div>
                                            </div>
                                            <div>
                                                <div class="text-xs text-gray-400">Contact Number</div>
                                                <div class="text-sm text-primary"><?php echo htmlspecialchars($accreditation['contact_no'] ?? 'N/A'); ?></div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Business Information -->
                                    <div class="mb-8">
                                        <h2 class="mb-4 font-semibold text-primary text-md">Business Information</h2>
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <div class="text-xs text-gray-400">Business Name</div>
                                                <div class="text-sm text-primary"><?php echo htmlspecialchars($accreditation['business_name'] ?? 'N/A'); ?></div>
                                            </div>
                                            <div>
                                                <div class="text-xs text-gray-400">Business Type</div>
                                                <div class="text-sm text-primary"><?php echo htmlspecialchars($accreditation['business_type'] ?? 'N/A'); ?></div>
                                            </div>
                                            <div>
                                                <div class="text-xs text-gray-400">Industry</div>
                                                <div class="text-sm text-primary"><?php echo htmlspecialchars($accreditation['business_industry'] ?? 'N/A'); ?></div>
                                            </div>
                                            <div>
                                                <div class="text-xs text-gray-400">Team Size</div>
                                                <div class="text-sm text-primary"><?php echo htmlspecialchars($accreditation['business_size'] ?? 'N/A'); ?></div>
                                            </div>
                                        </div>

                                        <?php if (!empty($accreditation['business_desc'])): ?>
                                            <div class="mt-6">
                                                <h3 class="mb-2 font-semibold text-primary text-md">Business Description</h3>
                                                <p class="text-sm font-light text-gray-600"><?php echo nl2br(htmlspecialchars($accreditation['business_desc'])); ?></p>
                                            </div>
                                        <?php endif; ?>

                                        <?php if (!empty($accreditation['business_address'])): ?>
                                            <div class="mt-6">
                                                <h3 class="mb-2 font-semibold text-primary text-md">Business Address</h3>
                                                <p class="text-sm font-light text-gray-600"><?php echo nl2br(htmlspecialchars($accreditation['business_address'])); ?></p>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Required Documents -->
                                    <div>
                                        <h2 class="mb-4 font-semibold text-primary text-md">Required Documents</h2>
                                        <div class="space-y-3">
                                            <?php foreach ($documentTypes as $type => $label): ?>
                                                <div class="flex items-center justify-between p-4 rounded-lg bg-gray-50">
                                                    <div class="flex items-center">
                                                        <!-- Document Icon -->
                                                        <div class="flex items-center justify-center w-12 h-12 mr-4 overflow-hidden <?php echo !empty($documents[$type]) ? 'bg-green-100' : 'bg-red-100'; ?> rounded-lg">
                                                            <?php if (!empty($documents[$type])): ?>
                                                                <img src="../public/assets/icons/pdf-icon.png" alt="PDF" class="object-cover w-8 h-8" />
                                                            <?php else: ?>
                                                                <svg class="w-8 h-8 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                                </svg>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div>
                                                            <div class="text-sm <?php echo !empty($documents[$type]) ? 'text-primary' : 'text-red-600'; ?> font-medium">
                                                                <?php echo $label; ?>
                                                            </div>
                                                            <div class="text-xs text-gray-400">
                                                                <?php echo !empty($documents[$type]) ? 'Uploaded' : 'Not uploaded'; ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="flex gap-2">
                                                        <?php if (!empty($documents[$type])): ?>
                                                            <a href="<?php echo htmlspecialchars($documents[$type]); ?>" target="_blank"
                                                                class="px-3 py-1.5 text-sm font-medium transition-colors rounded-lg text-blue-600 bg-blue-50 hover:bg-blue-100">
                                                                View
                                                            </a>
                                                            <a href="<?php echo htmlspecialchars($documents[$type]); ?>" download
                                                                class="px-3 py-1.5 text-sm font-medium transition-colors rounded-lg text-primary bg-blue-50 hover:bg-blue-100">
                                                                Download ↓
                                                            </a>
                                                        <?php else: ?>
                                                            <span class="px-3 py-1.5 text-xs text-red-500 bg-red-50 rounded-lg">Missing</span>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Section - Sidebar (4/12 width) -->
                        <div class="w-full md:w-4/12">
                            <!-- Right Section - Sidebar (4/12 width) -->
                            <div class="w-full md:w-4/12">

                                <!-- Single Sidebar Card -->
                                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow">
                                    <!-- Accreditation Status -->
                                    <div class="mb-8">
                                        <h3 class="mb-4 text-xl font-semibold text-gray-900">Accreditation Status</h3>
                                        <div class="space-y-4">
                                            <div class="flex items-center justify-between p-4 rounded-md bg-gray-50">
                                                <span class="text-sm font-light text-gray-600">Current Status:</span>
                                                <span class="font-bold text-primary text-md"><?php echo ucfirst($accreditation['status']); ?></span>
                                            </div>
                                            <div class="flex items-center justify-between p-4 rounded-md bg-gray-50">
                                                <span class="text-sm font-light text-gray-600">Documents:</span>
                                                <span class="font-bold text-primary text-md"><?php echo $uploadedDocs; ?>/<?php echo count($documentTypes); ?></span>
                                            </div>
                                            <?php if ($accreditation['reviewed_by_name']): ?>
                                                <div class="flex items-center justify-between p-4 rounded-md bg-gray-50">
                                                    <span class="text-sm font-light text-gray-600">Reviewed By:</span>
                                                    <span class="font-bold text-primary text-md"><?php echo htmlspecialchars($accreditation['reviewed_by_name']); ?></span>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <!-- Submission Details -->
                                    <div class="flex justify-between mb-8">
                                        <!-- Submitted Date -->
                                        <div class="flex-1 text-center">
                                            <div class="mb-1 text-sm font-medium text-gray-500">Submitted</div>
                                            <div class="text-sm font-semibold text-primary">
                                                <?php echo date('M j, Y', strtotime($accreditation['created_at'])); ?>
                                            </div>
                                        </div>

                                        <!-- Vertical Separator -->
                                        <div class="self-center h-12 border-r border-gray-600"></div>

                                        <!-- Review Date -->
                                        <div class="flex-1 text-center">
                                            <div class="mb-1 text-sm text-gray-500">
                                                <?php echo $accreditation['reviewed_at'] ? 'Reviewed' : 'Review Date'; ?>
                                            </div>
                                            <div class="text-sm font-semibold text-primary">
                                                <?php echo $accreditation['reviewed_at'] ? date('M j, Y', strtotime($accreditation['reviewed_at'])) : 'Pending'; ?>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Decision Actions -->
                                    <?php if ($accreditation['status'] === 'pending'): ?>
                                        <div class="mb-6">
                                            <form method="POST" action="?page=admin-process-accreditation" class="space-y-4">
                                                <input type="hidden" name="accreditation_id" value="<?php echo $accreditation['accreditation_id']; ?>">

                                                <div>
                                                    <label for="notes" class="block mb-2 text-sm font-medium text-gray-700">Review Notes</label>
                                                    <textarea id="notes" name="notes" rows="3"
                                                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                                        placeholder="Add any comments..."></textarea>
                                                </div>

                                                <div class="space-y-3">
                                                    <!-- Approve Button -->
                                                    <button type="submit" name="status" value="approved"
                                                        onclick="return confirm('Are you sure you want to APPROVE this employer?')"
                                                        class="flex items-center justify-center w-full px-4 py-3 text-sm font-medium text-white transition-colors bg-green-600 rounded-lg hover:bg-green-700">
                                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                        APPROVE EMPLOYER
                                                    </button>

                                                    <!-- Reject Button -->
                                                    <button type="submit" name="status" value="rejected"
                                                        onclick="return confirm('Are you sure you want to REJECT this application?')"
                                                        class="flex items-center justify-center w-full px-4 py-3 text-sm font-medium text-white transition-colors bg-red-600 rounded-lg hover:bg-red-700">
                                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                        REJECT APPLICATION
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    <?php else: ?>
                                        <!-- Show current status prominently -->
                                        <div class="mb-6">
                                            <div class="p-4 rounded-lg border <?php echo $accreditation['status'] === 'approved' ? 'bg-green-100 border-green-300' : 'bg-red-100 border-red-300'; ?>">
                                                <div class="flex items-center">
                                                    <svg class="w-5 h-5 mr-2 <?php echo $accreditation['status'] === 'approved' ? 'text-green-600' : 'text-red-600'; ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <?php if ($accreditation['status'] === 'approved'): ?>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        <?php else: ?>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        <?php endif; ?>
                                                    </svg>
                                                    <span class="font-medium <?php echo $accreditation['status'] === 'approved' ? 'text-green-800' : 'text-red-800'; ?>">
                                                        <?php echo $accreditation['status'] === 'approved' ? 'EMPLOYER APPROVED' : 'APPLICATION REJECTED'; ?>
                                                    </span>
                                                </div>
                                            </div>

                                            <?php if ($accreditation['notes']): ?>
                                                <div class="mt-4">
                                                    <label class="text-sm font-medium text-gray-500">Review Notes</label>
                                                    <p class="p-3 mt-1 text-sm text-gray-900 rounded bg-gray-50"><?php echo nl2br(htmlspecialchars($accreditation['notes'])); ?></p>
                                                </div>
                                            <?php endif; ?>

                                            <!-- Option to change status -->
                                            <div class="pt-4 mt-4 border-t">
                                                <p class="mb-3 text-xs text-gray-500">Change Status</p>
                                                <form method="POST" action="?page=admin-process-accreditation" class="space-y-2">
                                                    <input type="hidden" name="accreditation_id" value="<?php echo $accreditation['accreditation_id']; ?>">
                                                    <textarea name="notes" placeholder="Reason for status change..."
                                                        class="w-full px-3 py-2 text-xs border border-gray-300 rounded-md" rows="2"></textarea>

                                                    <div class="space-y-2">
                                                        <!-- Status Buttons -->
                                                        <button type="submit" name="status" value="approved"
                                                            onclick="return confirm('Set status to APPROVED?')"
                                                            class="w-full py-2 px-3 text-xs rounded transition-colors <?php echo $accreditation['status'] === 'approved' ? 'bg-green-200 text-green-800 cursor-not-allowed' : 'bg-green-600 text-white hover:bg-green-700'; ?>"
                                                            <?php echo $accreditation['status'] === 'approved' ? 'disabled' : ''; ?>>
                                                            <?php echo $accreditation['status'] === 'approved' ? 'Currently Approved' : 'Set to Approved'; ?>
                                                        </button>

                                                        <button type="submit" name="status" value="rejected"
                                                            onclick="return confirm('Set status to REJECTED?')"
                                                            class="w-full py-2 px-3 text-xs rounded transition-colors <?php echo $accreditation['status'] === 'rejected' ? 'bg-red-200 text-red-800 cursor-not-allowed' : 'bg-red-600 text-white hover:bg-red-700'; ?>"
                                                            <?php echo $accreditation['status'] === 'rejected' ? 'disabled' : ''; ?>>
                                                            <?php echo $accreditation['status'] === 'rejected' ? 'Currently Rejected' : 'Set to Rejected'; ?>
                                                        </button>

                                                        <button type="submit" name="status" value="pending"
                                                            onclick="return confirm('Reset status to PENDING?')"
                                                            class="w-full py-2 px-3 text-xs rounded transition-colors <?php echo $accreditation['status'] === 'pending' ? 'bg-yellow-200 text-yellow-800 cursor-not-allowed' : 'bg-yellow-600 text-white hover:bg-yellow-700'; ?>"
                                                            <?php echo $accreditation['status'] === 'pending' ? 'disabled' : ''; ?>>
                                                            <?php echo $accreditation['status'] === 'pending' ? 'Currently Pending' : 'Reset to Pending'; ?>
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <!-- Back to List Button -->
                                    <div>
                                        <button onclick="window.location.href='?page=admin-accreditations'"
                                            class="flex items-center justify-center w-full px-4 py-3 text-sm font-medium text-white transition-colors rounded-md bg-primary hover:bg-secondary">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                            </svg>
                                            Back to Accreditations
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
        </main>
    </div>
</div>