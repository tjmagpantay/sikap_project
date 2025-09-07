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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>SIKAP Admin - Review Accreditation</title>
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
    <!-- Topbar (Sticky) -->
    <?php include __DIR__ . '/components/topbar.php'; ?>

    <div class="flex h-screen">
        <!-- Sidebar (Fixed/Sticky) -->
        <?php include __DIR__ . '/components/sidebar.php'; ?>

        <!-- Main Content Area -->
        <div class="flex-1 lg:ml-80 overflow-auto">
            <div class="p-6">
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

                <!-- Main Layout - Two Column Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Left Section - Main Content (2/3 width) -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Header Card -->
                        <div class="bg-white border border-gray-200 rounded-lg shadow">
                            <div class="p-6">
                                <!-- Employer Name and Status Badges -->
                                <div class="flex items-start justify-between mb-6">
                                    <div>
                                        <h1 class="text-2xl font-bold text-gray-900">
                                            <?php echo htmlspecialchars($accreditation['first_name'] . ' ' . $accreditation['last_name']); ?>
                                        </h1>
                                        <p class="mt-1 text-gray-600 text-sm"><?php echo htmlspecialchars($accreditation['email']); ?></p>
                                        <div class="flex items-center gap-3 mt-3">
                                            <!-- Status Badge -->
                                            <span class="inline-flex items-center px-3 py-1 text-xs font-medium uppercase
                                            <?php
                                            if ($accreditation['status'] === 'approved') {
                                                echo 'bg-green-100 text-green-800';
                                            } elseif ($accreditation['status'] === 'rejected') {
                                                echo 'bg-red-100 text-red-800';
                                            } else {
                                                echo 'bg-yellow-100 text-yellow-800';
                                            }
                                            ?>">
                                                <?php
                                                // Display the actual status from database
                                                echo strtoupper(str_replace('_', ' ', $accreditation['status']));
                                                ?>
                                            </span>

                                            <!-- Document Status Badge -->
                                            <span class="inline-flex items-center px-3 py-1 text-xs font-medium bg-blue-100 text-primary">
                                                <?php echo $uploadedDocs; ?>/<?php echo count($documentTypes); ?> DOCUMENTS
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Personal Information -->
                                <div class="mb-8">
                                    <h2 class="mb-4 text-lg font-semibold text-gray-900">Personal Information</h2>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label class="block text-xs font-medium text-gray-400">Position</label>
                                            <p class="mt-1 text-gray-900 text-sm"><?php echo htmlspecialchars($accreditation['position'] ?? 'N/A'); ?></p>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-400">Contact Number</label>
                                            <p class="mt-1 text-gray-900 text-sm"><?php echo htmlspecialchars($accreditation['contact_no'] ?? 'N/A'); ?></p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Business Information -->
                                <div class="mb-8">
                                    <h2 class="mb-4 text-lg font-semibold text-gray-900">Business Information</h2>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500">Business Name</label>
                                            <p class="mt-1  text-gray-900 text-sm"><?php echo htmlspecialchars($accreditation['business_name'] ?? 'N/A'); ?></p>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500">Business Type</label>
                                            <p class="mt-1 text-gray-900 text-sm"><?php echo htmlspecialchars($accreditation['business_type'] ?? 'N/A'); ?></p>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500">Industry</label>
                                            <p class="mt-1 text-gray-900 text-sm"><?php echo htmlspecialchars($accreditation['business_industry'] ?? 'N/A'); ?></p>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500">Team Size</label>
                                            <p class="mt-1 text-gray-900 text-sm"><?php echo htmlspecialchars($accreditation['business_size'] ?? 'N/A'); ?></p>
                                        </div>
                                    </div>

                                    <?php if (!empty($accreditation['business_desc'])): ?>
                                        <div class="mt-6">
                                            <label class="block text-xs font-medium text-gray-500">Business Description</label>
                                            <p class="mt-1 text-gray-900 text-sm"><?php echo nl2br(htmlspecialchars($accreditation['business_desc'])); ?></p>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (!empty($accreditation['business_address'])): ?>
                                        <div class="mt-6">
                                            <label class="block text-xs font-medium text-gray-500">Business Address</label>
                                            <p class="mt-1 text-gray-900 text-sm"><?php echo nl2br(htmlspecialchars($accreditation['business_address'])); ?></p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Required Documents -->
                        <div class="bg-white border border-gray-200 rounded-lg shadow">
                            <div class="p-6">
                                <h2 class="mb-6 text-lg font-semibold text-gray-900">Required Documents</h2>
                                <div class="space-y-4">
                                    <?php foreach ($documentTypes as $type => $label): ?>
                                        <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                                            <div class="flex items-center">
                                                <!-- Document Icon -->
                                                <div class="flex items-center justify-center w-10 h-10 mr-4 rounded-lg <?php echo !empty($documents[$type]) ? 'bg-green-100' : 'bg-red-100'; ?>">
                                                    <?php if (!empty($documents[$type])): ?>
                                                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                    <?php else: ?>
                                                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                        </svg>
                                                    <?php endif; ?>
                                                </div>
                                                <div>
                                                    <p class="font-medium text-gray-900 text-sm"><?php echo $label; ?></p>
                                                    <p class="text-xs text-gray-400">
                                                        <?php echo !empty($documents[$type]) ? 'Document uploaded' : 'Not uploaded'; ?>
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="flex gap-2">
                                                <?php if (!empty($documents[$type])): ?>
                                                    <a href="<?php echo htmlspecialchars($documents[$type]); ?>" target="_blank"
                                                        class="px-4 py-2 text-xs font-medium text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                                                        View
                                                    </a>
                                                    <a href="<?php echo htmlspecialchars($documents[$type]); ?>" download
                                                        class="px-4 py-2 text-xs font-medium text-gray-600 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                                        Download
                                                    </a>
                                                <?php else: ?>
                                                    <span class="px-4 py-2 text-sm font-medium text-red-600 bg-red-50 rounded-lg">Missing</span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Section - Sidebar (1/3 width) -->
                    <div class="lg:col-span-1">
                        <div class="bg-white border border-gray-200 rounded-lg shadow sticky top-6">
                            <div class="p-6">
                                <!-- Accreditation Status -->
                                <div class="mb-6">
                                    <h3 class="mb-4 text-lg font-semibold text-gray-900">Accreditation Status</h3>

                                    <!-- Current Status Display -->
                                    <div class="mb-4 p-4 rounded-lg border-2 
    <?php echo $accreditation['status'] === 'approved' ? 'border-green-200 bg-green-50' : ($accreditation['status'] === 'rejected' ? 'border-red-200 bg-red-50' : 'border-yellow-200 bg-yellow-50'); ?>">
                                        <div class="flex items-center justify-center space-x-2">
                                            <div class="text-gray-400 text-sm">Current Status:</div>
                                            <div class="font-medium text-sm 
<?php echo $accreditation['status'] === 'approved' ? 'text-green-600' : ($accreditation['status'] === 'rejected' ? 'text-red-600' : 'text-yellow-600'); ?>">
                                                <?php
                                                // Display the actual status from database, formatted nicely
                                                echo ucfirst(str_replace('_', ' ', $accreditation['status']));
                                                ?>
                                            </div>
                                        </div>
                                    </div>


                                    <!-- Stats -->
                                    <div class="space-y-3">
                                        <div class="flex justify-between p-3 bg-gray-50 rounded-lg">
                                            <span class="text-sm font-medium text-gray-600">Documents:</span>
                                            <span class="text-sm font-bold text-gray-900"><?php echo $uploadedDocs; ?>/<?php echo count($documentTypes); ?></span>
                                        </div>
                                        <div class="flex justify-between p-3 bg-gray-50 rounded-lg">
                                            <span class="text-sm font-medium text-gray-600">Submitted:</span>
                                            <span class="text-sm font-bold text-gray-900"><?php echo date('M j, Y', strtotime($accreditation['created_at'])); ?></span>
                                        </div>
                                        <?php if ($accreditation['reviewed_at']): ?>
                                            <div class="flex justify-between p-3 bg-gray-50 rounded-lg">
                                                <span class="text-sm font-medium text-gray-600">Reviewed:</span>
                                                <span class="text-sm font-bold text-gray-900"><?php echo date('M j, Y', strtotime($accreditation['reviewed_at'])); ?></span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!-- Decision Actions -->
                                <?php if ($accreditation['status'] === 'pending'): ?>
                                    <div class="mb-6">
                                        <h3 class="mb-2 text-lg font-semibold text-gray-900">Change Status</h3>
                                        <form method="POST" action="?page=admin-process-accreditation" class="space-y-4">
                                            <input type="hidden" name="accreditation_id" value="<?php echo $accreditation['accreditation_id']; ?>">

                                            <div>
                                                <label for="notes" class="block mb-2 text-xs font-medium text-gray-400">Reason for status change...</label>
                                                <textarea id="notes" name="notes" rows="3"
                                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                    placeholder="Add any comments..."></textarea>
                                            </div>

                                            <div class="space-y-3">
                                                <!-- Approve Button -->
                                                <button type="submit" name="status" value="approved"
                                                    onclick="return confirm('Are you sure you want to APPROVE this employer?')"
                                                    class="w-full flex items-center justify-center px-4 py-3 text-white bg-green-100 rounded-lg border border-green-200 hover:bg-green-700 transition-colors">
                                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    Set to Approved
                                                </button>

                                                <!-- Reject Button -->
                                                <button type="submit" name="status" value="rejected"
                                                    onclick="return confirm('Are you sure you want to REJECT this application?')"
                                                    class="w-full flex items-center justify-center px-4 py-3 text-white bg-red-100 rounded-lg border border-red-200 hover:bg-red-700 transition-colors">
                                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                    Set to Rejected
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                <?php else: ?>
                                    <!-- Show review notes if available -->
                                    <?php if ($accreditation['notes']): ?>
                                        <div class="mb-6">
                                            <h3 class="mb-2 text-sm font-medium text-gray-700">Review Notes</h3>
                                            <p class="p-3 text-sm text-gray-900 bg-gray-50 rounded-lg"><?php echo nl2br(htmlspecialchars($accreditation['notes'])); ?></p>
                                        </div>
                                    <?php endif; ?>

                                    <!-- Change Status Form -->
                                    <div class="mb-6">
                                        <h3 class="mb-4 text-lg font-semibold text-gray-900">Change Status</h3>
                                        <form method="POST" action="?page=admin-process-accreditation" class="space-y-4">
                                            <input type="hidden" name="accreditation_id" value="<?php echo $accreditation['accreditation_id']; ?>">

                                            <textarea name="notes" placeholder="Reason for status change..."
                                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" rows="3"></textarea>

                                            <div class="space-y-2">
                                                <!-- Approved Button -->
                                                <button type="submit" name="status" value="approved"
                                                    onclick="return confirm('Set status to APPROVED?')"
                                                    class="w-full py-2 px-3 text-sm rounded-lg border transition-colors
                    <?php echo $accreditation['status'] === 'approved'
                                        ? 'bg-green-200 border-green-400 text-green-800 cursor-not-allowed'
                                        : 'bg-white border-green-400 text-green-800  bg-green-50 hover:bg-green-100'; ?>"
                                                    <?php echo $accreditation['status'] === 'approved' ? 'disabled' : ''; ?>>
                                                    <?php echo $accreditation['status'] === 'approved' ? 'Currently Approved' : 'Set to Approved'; ?>
                                                </button>

                                                <!-- Rejected Button -->
                                                <button type="submit" name="status" value="rejected"
                                                    onclick="return confirm('Set status to REJECTED?')"
                                                    class="w-full py-2 px-3 text-sm rounded-lg border transition-colors
                    <?php echo $accreditation['status'] === 'rejected'
                                        ? 'bg-red-200 border-red-400 text-red-800 cursor-not-allowed'
                                        : 'bg-white border-red-400 text-red-800  bg-red-50 hover:bg-red-100'; ?>"
                                                    <?php echo $accreditation['status'] === 'rejected' ? 'disabled' : ''; ?>>
                                                    <?php echo $accreditation['status'] === 'rejected' ? 'Currently Rejected' : 'Set to Rejected'; ?>
                                                </button>

                                                <!-- Pending Button -->
                                                <button type="submit" name="status" value="pending"
                                                    onclick="return confirm('Reset status to PENDING?')"
                                                    class="w-full py-2 px-3 text-sm rounded-lg border transition-colors
                    <?php echo $accreditation['status'] === 'pending'
                                        ? 'bg-yellow-200 border-yellow-400 text-yellow-800 cursor-not-allowed'
                                        : 'bg-white border-yellow-400 text-yellow-800 bg-yellow-50 hover:bg-yellow-100'; ?>"
                                                    <?php echo $accreditation['status'] === 'pending' ? 'disabled' : ''; ?>>
                                                    <?php echo $accreditation['status'] === 'pending' ? 'Currently Pending' : 'Reset to Pending'; ?>
                                                </button>
                                            </div>
                                        </form>
                                    </div>

                                <?php endif; ?>

                                <!-- Back to List Button -->
                                <button onclick="window.location.href='?page=admin-accreditations'"
                                    class="w-full flex items-center justify-center px-4 py-3 text-white bg-primary rounded-lg hover:bg-blue-700 transition-colors">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                    </svg>
                                    Back to Accreditations
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>