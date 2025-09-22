<?php
// Remove the auth check since dashboard.php already handles it
// Content-only page - no HTML structure, no auth check

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

<!-- Content-only review accreditation page with proper full width -->
<div class="space-y-6">

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

    <!-- Messages -->
    <!-- ✅ FIXED: Enhanced Messages Section -->
    <?php if (isset($_SESSION['error'])): ?>
        <div class="p-4 mb-6 text-sm text-red-700 bg-red-100 border border-red-200 rounded-lg">
            <div class="flex items-center">
                <i class="mr-2 fas fa-exclamation-circle"></i>
                <span><?php echo htmlspecialchars($_SESSION['error']); ?></span>
            </div>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="p-4 mb-6 text-sm border border-blue-100 rounded-lg text-primary bg-blue-50">
            <div class="flex items-center">
                <i class="mr-2 fas fa-check-circle"></i>
                <span><?php echo htmlspecialchars($_SESSION['success']); ?></span>
            </div>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <!-- ✅ FIXED: Better grid layout - 70% left, 30% right -->
    <div class="grid grid-cols-2 gap-4 xl:grid-cols-10">
        <!-- ✅ FIXED: Left Section - Main Content (70% width on large screens) -->
        <div class="space-y-6 xl:col-span-7">
            <!-- Header Card -->
            <div class="bg-white border border-gray-200 rounded-lg shadow">
                <div class="p-8">
                    <!-- Employer Name and Status Badges -->
                    <div class="flex flex-col mb-8 lg:flex-row lg:items-start lg:justify-between">
                        <div class="flex-1">
                            <h1 class="mb-1 text-lg font-bold text-gray-900">
                                <?php echo htmlspecialchars($accreditation['first_name'] . ' ' . $accreditation['last_name']); ?>
                            </h1>
                            <p class="mb-4 text-xs text-gray-600"><?php echo htmlspecialchars($accreditation['email']); ?></p>
                            <div class="flex flex-wrap items-center gap-3">
                                <!-- Status Badge -->
                                <span class="inline-flex items-center px-4 py-2 text-xs rounded-sm
                                <?php
                                if ($accreditation['status'] === 'approved') {
                                    echo 'bg-gray-100 primary';
                                } elseif ($accreditation['status'] === 'rejected') {
                                    echo 'bg-gray-100 primary';
                                } else {
                                    echo 'bg-gray-100 primary';
                                }
                                ?>">
                                    <i class="mr-2 fas gray-200fa-<?php echo $accreditation['status'] === 'approved' ? 'check-circle' : ($accreditation['status'] === 'rejected' ? 'times-circle' : 'clock'); ?>"></i>
                                    <?php echo strtoupper(str_replace('_', ' ', $accreditation['status'])); ?>
                                </span>

                                <!-- Document Status Badge -->
                                <span class="inline-flex items-center px-4 py-2 text-xs bg-gray-100 rounded-sm text-primary">
                                    <i class="mr-2 fas fa-file-alt"></i>
                                    <?php echo $uploadedDocs; ?>/<?php echo count($documentTypes); ?> Documents
                                </span>

                                <!-- Submission Date Badge -->
                                <span class="inline-flex items-center px-4 py-2 text-xs bg-gray-100 rounded-sm text-primary">
                                    <i class="mr-2 fas fa-calendar"></i>
                                    <?php echo date('M j, Y', strtotime($accreditation['created_at'])); ?>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                        <!-- Personal Information -->
                        <div class="p-6 border border-gray-100 rounded-lg">
                            <h2 class="flex items-center mb-6 font-semibold text-gray-900 text-md">
                                Personal Information
                            </h2>
                            <div class="space-y-4">
                                <div>
                                    <label class="block mb-1 text-xs text-gray-400">Full Name</label>
                                    <p class="text-sm font-medium text-gray-800"><?php echo htmlspecialchars($accreditation['first_name'] . ' ' . $accreditation['last_name']); ?></p>
                                </div>
                                <div>
                                    <label class="block mb-1 text-xs text-gray-400">Email Address</label>
                                    <p class="text-sm font-medium text-gray-800"><?php echo htmlspecialchars($accreditation['email']); ?></p>
                                </div>
                                <div>
                                    <label class="block mb-1 text-xs text-gray-400">Position</label>
                                    <p class="text-sm font-medium text-gray-800"><?php echo htmlspecialchars($accreditation['position'] ?? 'N/A'); ?></p>
                                </div>
                                <div>
                                    <label class="block mb-1 text-xs text-gray-400">Contact Number</label>
                                    <p class="text-sm font-medium text-gray-800"><?php echo htmlspecialchars($accreditation['contact_no'] ?? 'N/A'); ?></p>
                                </div>
                            </div>
                        </div>

                        <!-- Business Information -->
                        <div class="p-6 border border-gray-100 rounded-lg">
                            <h2 class="flex items-center mb-6 font-semibold text-gray-900 text-md">
                                Business Information
                            </h2>
                            <div class="space-y-4">
                                <div>
                                    <label class="block mb-1 text-xs text-gray-400">Business Name</label>
                                    <p class="text-sm font-medium text-gray-800"><?php echo htmlspecialchars($accreditation['business_name'] ?? 'N/A'); ?></p>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-400 mtext-sm text-gray-800b-1">Business Type</label>
                                    <p class="text-sm font-medium text-gray-800"><?php echo htmlspecialchars($accreditation['business_type'] ?? 'N/A'); ?></p>
                                </div>
                                <div>
                                    <label class="block mb-1 text-xs text-gray-400">Industry</label>
                                    <p class="text-sm font-medium text-gray-800"><?php echo htmlspecialchars($accreditation['business_industry'] ?? 'N/A'); ?></p>
                                </div>
                                <div>
                                    <label class="block mb-1 text-xs text-gray-400">Team Size</label>
                                    <p class="text-sm font-medium text-gray-800"><?php echo htmlspecialchars($accreditation['business_size'] ?? $accreditation['business_team_size'] ?? 'N/A'); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Business Details -->
                    <?php if (!empty($accreditation['business_desc']) || !empty($accreditation['business_address'])): ?>
                        <div class="p-6 mt-4 border border-gray-100 rounded-lg">
                            <h3 class="flex items-center mb-6 font-semibold text-gray-900 text-md">Additional Details</h3>
                            <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                                <?php if (!empty($accreditation['business_desc'])): ?>
                                    <div>
                                        <label class="block mb-1 text-xs text-gray-400">Business Description</label>
                                        <div class="p-4 overflow-y-auto text-sm text-gray-800 bg-white border rounded max-h-32">
                                            <?php echo nl2br(htmlspecialchars($accreditation['business_desc'])); ?>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?php if (!empty($accreditation['business_address'])): ?>
                                    <div>
                                        <label class="block mb-1 text-xs text-gray-400">Business Address</label>
                                        <div class="p-4 overflow-y-auto text-sm text-gray-800 bg-white border rounded max-h-32">
                                            <?php echo nl2br(htmlspecialchars($accreditation['business_address'])); ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- ✅ FIXED: Full Width Required Documents Section -->
            <div class="bg-white border border-gray-200 rounded-lg shadow">
                <div class="p-8">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="flex items-center font-semibold text-gray-900 text-md">
                            Required Documents
                        </h2>
                        <div class="flex items-center text-sm font-medium text-gray-600">
                            <?php echo $uploadedDocs; ?> of <?php echo count($documentTypes); ?> uploaded
                        </div>
                    </div>

                    <!-- ✅ FIXED: Responsive Documents Grid -->
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-3">
                        <?php foreach ($documentTypes as $type => $label): ?>
                            <div class="p-6 transition-shadow border border-gray-200 rounded-lg hover:shadow-md ">
                                <div class="flex items-start mb-4">
                                    <!-- Document Icon -->
                                    <div class="flex items-center justify-center w-12 h-12 mr-4 rounded-lg flex-shrink-0 <?php echo !empty($documents[$type]) ? 'bg-gray-100' : 'bg-red-100'; ?>">
                                        <?php if (!empty($documents[$type])): ?>
                                            <img
                                                src="../public/assets/icons/pdf-icon.png"
                                                alt="Icon"
                                                class="object-cover w-8 h-8" />
                                        <?php else: ?>
                                            <img
                                                src="../public/assets/icons/pdf-icon.png"
                                                alt="Icon"
                                                class="object-cover w-8 h-8" />
                                        <?php endif; ?>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="mb-1 text-sm font-semibold leading-tight text-gray-900"><?php echo $label; ?></h3>
                                        <p class="text-xs text-gray-500">
                                            <?php echo !empty($documents[$type]) ? 'Document uploaded' : 'Not uploaded'; ?>
                                        </p>
                                    </div>
                                </div>

                                <!-- ✅ FIXED: Document Action Buttons with Proper Working Links -->
                                <div class="flex gap-2">
                                    <?php if (!empty($documents[$type])): ?>
                                        <!-- ✅ FIXED: View Document Button with correct route -->
                                        <a href="?page=view-employer-document&type=<?php echo urlencode($type); ?>&employer_id=<?php echo $accreditation['employer_id']; ?>"
                                            target="_blank"
                                            class="flex-1 px-3 py-2 text-xs font-medium text-center text-blue-600 transition-colors rounded-lg bg-blue-50 hover:bg-blue-100">

                                            View
                                        </a>

                                        <!-- ✅ FIXED: Download Document Button with correct route -->
                                        <a href="?page=download-employer-document&type=<?php echo urlencode($type); ?>&employer_id=<?php echo $accreditation['employer_id']; ?>"
                                            class="flex-1 px-3 py-2 text-xs font-medium text-center text-gray-600 transition-colors rounded-lg bg-gray-50 hover:bg-gray-100">

                                            Download
                                        </a>
                                    <?php else: ?>
                                        <div class="w-full px-3 py-2 text-xs font-medium text-center text-red-600 rounded-lg bg-red-50">

                                            Missing Document
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- ✅ FIXED: Right Section - Sidebar (30% width on large screens) -->
        <div class="xl:col-span-3">
            <div class="sticky bg-white border border-gray-200 rounded-lg shadow top-6">
                <div class="p-6">
                    <!-- Accreditation Status -->
                    <div class="mb-6">
                        <h3 class="flex items-center mb-4 text-xl font-semibold text-gray-900">

                            Status
                        </h3>

                        <!-- Current Status Display -->
                        <div class="p-4 mb-6 bg-gray-100 border-2 border-gray-200 rounded-lg">
                            <div class="flex items-center justify-center gap-2">
                                <span class="text-sm text-gray-500">Current Status:</span>
                                <div class="flex items-center text-lg font-semibold text-primary">
                                    <?php if ($accreditation['status'] === 'approved'): ?>
                                        <i class="mr-1 fas fa-check-circle"></i>
                                    <?php elseif ($accreditation['status'] === 'rejected'): ?>
                                        <i class="mr-1 fas fa-times-circle"></i>
                                    <?php else: ?>
                                        <i class="mr-1 fas fa-clock"></i>
                                    <?php endif; ?>
                                    <span><?php echo ucfirst(str_replace('_', ' ', $accreditation['status'])); ?></span>
                                </div>
                            </div>
                        </div>


                        <!-- Stats -->
                        <div class="mb-6 space-y-3">
                            <div class="flex justify-between p-3 rounded-lg bg-gray-50">
                                <span class="text-sm font-medium text-gray-600">Documents:</span>
                                <span class="text-sm font-bold text-gray-900"><?php echo $uploadedDocs; ?>/<?php echo count($documentTypes); ?></span>
                            </div>
                            <div class="flex justify-between p-3 rounded-lg bg-gray-50">
                                <span class="text-sm font-medium text-gray-600">Submitted:</span>
                                <span class="text-sm font-bold text-gray-900"><?php echo date('M j, Y', strtotime($accreditation['created_at'])); ?></span>
                            </div>
                            <?php if ($accreditation['reviewed_at']): ?>
                                <div class="flex justify-between p-3 rounded-lg bg-gray-50">
                                    <span class="text-sm font-medium text-gray-600">Reviewed:</span>
                                    <span class="text-sm font-bold text-gray-900"><?php echo date('M j, Y', strtotime($accreditation['reviewed_at'])); ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Decision Actions -->
                    <?php if ($accreditation['status'] === 'pending'): ?>
                        <div class="mb-6">
                            <h3 class="mb-4 text-lg font-semibold text-gray-900">Change Status</h3>
                            <form method="POST" action="?page=admin-process-accreditation" class="space-y-4">
                                <input type="hidden" name="accreditation_id" value="<?php echo $accreditation['accreditation_id']; ?>">

                                <div>
                                    <label for="notes" class="block mb-2 text-sm font-medium text-gray-700">Review Notes</label>
                                    <textarea id="notes" name="notes" rows="3"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="Add your review comments..."></textarea>
                                </div>

                                <div class="space-y-3">
                                    <!-- Approve Button -->
                                    <button type="submit" name="status" value="approved"
                                        onclick="return confirm('Are you sure you want to APPROVE this employer?')"
                                        class="flex items-center justify-center w-full px-4 py-3 text-white transition-colors bg-green-600 rounded-lg hover:bg-green-700">
                                        <i class="mr-2 fas fa-check"></i>
                                        Approve Application
                                    </button>

                                    <!-- Reject Button -->
                                    <button type="submit" name="status" value="rejected"
                                        onclick="return confirm('Are you sure you want to REJECT this application?')"
                                        class="flex items-center justify-center w-full px-4 py-3 text-white transition-colors bg-red-600 rounded-lg hover:bg-red-700">
                                        <i class="mr-2 fas fa-times"></i>
                                        Reject Application
                                    </button>
                                </div>
                            </form>
                        </div>
                    <?php else: ?>
                        <!-- Show review notes if available -->
                        <?php if ($accreditation['notes']): ?>
                            <div class="mb-6">
                                <h3 class="mb-2 text-sm font-medium text-gray-700">Review Notes</h3>
                                <div class="p-3 text-sm text-gray-900 border rounded-lg bg-gray-50">
                                    <?php echo nl2br(htmlspecialchars($accreditation['notes'])); ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Change Status Form -->
                        <div class="mb-6">
                            <h3 class="mb-4 text-lg font-semibold text-gray-900">Change Status</h3>
                            <form method="POST" action="?page=admin-process-accreditation" class="space-y-4">
                                <input type="hidden" name="accreditation_id" value="<?php echo $accreditation['accreditation_id']; ?>">

                                <textarea name="notes" placeholder="Reason for status change..."
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    rows="3"></textarea>

                                <div class="flex gap-2">
                                    <!-- Approved -->
                                    <button type="submit" name="status" value="approved"
                                        onclick="return confirm('Set status to APPROVED?')"
                                        class="flex-1 py-3 px-4 text-sm font-medium rounded-lg transition-colors
                <?php echo $accreditation['status'] === 'approved'
                            ? 'bg-primary text-white opacity-70 cursor-not-allowed'
                            : 'bg-primary text-white hover:bg-primary/90'; ?>"
                                        <?php echo $accreditation['status'] === 'approved' ? 'disabled' : ''; ?>>
                                        <i class="mr-2 fas fa-check"></i>
                                        <?php echo $accreditation['status'] === 'approved' ? 'Currently Approved' : 'Set to Approved'; ?>
                                    </button>

                                    <!-- Rejected -->
                                    <button type="submit" name="status" value="rejected"
                                        onclick="return confirm('Set status to REJECTED?')"
                                        class="flex-1 py-3 px-4 text-sm font-medium rounded-lg transition-colors
                <?php echo $accreditation['status'] === 'rejected'
                            ? 'bg-primary text-white opacity-70 cursor-not-allowed'
                            : 'bg-primary text-white hover:bg-primary/90'; ?>"
                                        <?php echo $accreditation['status'] === 'rejected' ? 'disabled' : ''; ?>>
                                        <i class="mr-2 fas fa-times"></i>
                                        <?php echo $accreditation['status'] === 'rejected' ? 'Currently Rejected' : 'Set to Rejected'; ?>
                                    </button>

                                    <!-- Pending -->
                                    <button type="submit" name="status" value="pending"
                                        onclick="return confirm('Reset status to PENDING?')"
                                        class="flex-1 py-3 px-4 text-sm font-medium rounded-lg transition-colors
                <?php echo $accreditation['status'] === 'pending'
                            ? 'bg-primary text-white opacity-70 cursor-not-allowed'
                            : 'bg-primary text-white hover:bg-primary/90'; ?>"
                                        <?php echo $accreditation['status'] === 'pending' ? 'disabled' : ''; ?>>
                                        <i class="mr-2 fas fa-clock"></i>
                                        <?php echo $accreditation['status'] === 'pending' ? 'Currently Pending' : 'Reset to Pending'; ?>
                                    </button>
                                </div>
                            </form>
                        </div>


                    <?php endif; ?>


                </div>
            </div>
        </div>
    </div>
</div>