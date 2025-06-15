<?php
// Create file: app/views/admin/review-accreditation.php

include_once __DIR__ . '/../components/navbar-top.php';

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

<div class="min-h-screen bg-gray-50">
    <!-- Admin Navigation -->
    <nav class="bg-gray-800 shadow">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center space-x-8">
                    <h1 class="text-xl font-semibold text-white">Review Accreditation</h1>
                    <a href="?page=admin-accreditations" class="text-gray-300 hover:text-white">← Back to Accreditations</a>
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
            
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- Employer Information -->
                    <div class="p-6 bg-white shadow rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Employer Information</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm font-medium text-gray-500">Full Name</label>
                                <p class="text-gray-900"><?php echo htmlspecialchars($accreditation['first_name'] . ' ' . $accreditation['last_name']); ?></p>
                            </div>
                            
                            <div>
                                <label class="text-sm font-medium text-gray-500">Email</label>
                                <p class="text-gray-900"><?php echo htmlspecialchars($accreditation['email']); ?></p>
                            </div>
                            
                            <div>
                                <label class="text-sm font-medium text-gray-500">Position</label>
                                <p class="text-gray-900"><?php echo htmlspecialchars($accreditation['position'] ?? 'N/A'); ?></p>
                            </div>
                            
                            <div>
                                <label class="text-sm font-medium text-gray-500">Contact Number</label>
                                <p class="text-gray-900"><?php echo htmlspecialchars($accreditation['contact_no'] ?? 'N/A'); ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Business Information -->
                    <div class="p-6 bg-white shadow rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Business Information</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm font-medium text-gray-500">Business Name</label>
                                <p class="text-gray-900"><?php echo htmlspecialchars($accreditation['business_name'] ?? 'N/A'); ?></p>
                            </div>
                            
                            <div>
                                <label class="text-sm font-medium text-gray-500">Business Type</label>
                                <p class="text-gray-900"><?php echo htmlspecialchars($accreditation['business_type'] ?? 'N/A'); ?></p>
                            </div>
                            
                            <div>
                                <label class="text-sm font-medium text-gray-500">Industry</label>
                                <p class="text-gray-900"><?php echo htmlspecialchars($accreditation['business_industry'] ?? 'N/A'); ?></p>
                            </div>
                            
                            <div>
                                <label class="text-sm font-medium text-gray-500">Team Size</label>
                                <p class="text-gray-900"><?php echo htmlspecialchars($accreditation['business_size'] ?? 'N/A'); ?></p>
                            </div>
                        </div>

                        <?php if (!empty($accreditation['business_desc'])): ?>
                            <div class="mt-4">
                                <label class="text-sm font-medium text-gray-500">Business Description</label>
                                <p class="text-gray-900 mt-1"><?php echo nl2br(htmlspecialchars($accreditation['business_desc'])); ?></p>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($accreditation['business_address'])): ?>
                            <div class="mt-4">
                                <label class="text-sm font-medium text-gray-500">Business Address</label>
                                <p class="text-gray-900 mt-1"><?php echo nl2br(htmlspecialchars($accreditation['business_address'])); ?></p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Documents -->
                    <div class="p-6 bg-white shadow rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">
                            Required Documents 
                            <span class="text-sm text-gray-500">(<?php echo $uploadedDocs; ?>/<?php echo count($documentTypes); ?>)</span>
                        </h3>
                        
                        <div class="grid grid-cols-1 gap-3">
                            <?php foreach ($documentTypes as $type => $label): ?>
                                <div class="flex items-center justify-between p-3 border rounded-lg 
                                    <?php echo !empty($documents[$type]) ? 'border-green-200 bg-green-50' : 'border-red-200 bg-red-50'; ?>">
                                    <div class="flex items-center">
                                        <i class="fas fa-file-pdf <?php echo !empty($documents[$type]) ? 'text-green-600' : 'text-red-400'; ?> mr-3"></i>
                                        <span class="text-sm font-medium <?php echo !empty($documents[$type]) ? 'text-green-800' : 'text-red-600'; ?>">
                                            <?php echo $label; ?>
                                        </span>
                                    </div>
                                    
                                    <div>
                                        <?php if (!empty($documents[$type])): ?>
                                            <a href="<?php echo htmlspecialchars($documents[$type]); ?>" target="_blank"
                                               class="text-blue-600 hover:text-blue-800 mr-2">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                            <a href="<?php echo htmlspecialchars($documents[$type]); ?>" download
                                               class="text-green-600 hover:text-green-800">
                                                <i class="fas fa-download"></i> Download
                                            </a>
                                        <?php else: ?>
                                            <span class="text-red-500 text-sm">Not uploaded</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                </div>

                <!-- Decision Panel -->
                <div class="lg:col-span-1">
                    <div class="p-6 bg-white shadow rounded-lg sticky top-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Accreditation Decision</h3>
                        
                        <div class="mb-4">
                            <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full 
                                <?php 
                                echo $accreditation['status'] === 'approved' ? 'text-green-800 bg-green-100' : 
                                    ($accreditation['status'] === 'rejected' ? 'text-red-800 bg-red-100' : 'text-yellow-800 bg-yellow-100'); 
                                ?>">
                                Status: <?php echo ucfirst($accreditation['status']); ?>
                            </span>
                        </div>

                        <?php if ($accreditation['status'] === 'pending'): ?>
                            <form method="POST" action="?page=admin-process-accreditation" class="space-y-4">
                                <input type="hidden" name="accreditation_id" value="<?php echo $accreditation['accreditation_id']; ?>">
                                
                                <div>
                                    <label for="notes" class="block text-sm font-medium text-gray-700">Review Notes</label>
                                    <textarea id="notes" name="notes" rows="4" 
                                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                              placeholder="Add any comments or reasons for your decision..."></textarea>
                                </div>

                                <div class="space-y-2">
                                    <!-- Enhanced Verify Button -->
                                    <button type="submit" name="status" value="approved"
                                            onclick="return confirm('Are you sure you want to VERIFY this employer? They will be able to post jobs.')"
                                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transform transition hover:scale-105">
                                        <i class="fas fa-check-circle mr-2"></i>
                                        ✓ VERIFY & APPROVE EMPLOYER
                                    </button>
                                    
                                    <!-- Enhanced Reject Button -->
                                    <button type="submit" name="status" value="rejected"
                                            onclick="return confirm('Are you sure you want to REJECT this application? This action cannot be undone.')"
                                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transform transition hover:scale-105">
                                        <i class="fas fa-times-circle mr-2"></i>
                                        ✗ REJECT APPLICATION
                                    </button>
                                    
                                    <!-- Return to List Button -->
                                    <a href="?page=admin-accreditations" 
                                       class="w-full flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        <i class="fas fa-arrow-left mr-2"></i>
                                        Back to Accreditations
                                    </a>
                                </div>
                            </form>
                        <?php else: ?>
                            <div class="space-y-3">
                                <!-- Show current status prominently -->
                                <div class="p-4 rounded-lg <?php echo $accreditation['status'] === 'approved' ? 'bg-green-100 border border-green-300' : 'bg-red-100 border border-red-300'; ?>">
                                    <div class="flex items-center">
                                        <i class="fas <?php echo $accreditation['status'] === 'approved' ? 'fa-check-circle text-green-600' : 'fa-times-circle text-red-600'; ?> mr-2"></i>
                                        <span class="font-medium <?php echo $accreditation['status'] === 'approved' ? 'text-green-800' : 'text-red-800'; ?>">
                                            <?php echo $accreditation['status'] === 'approved' ? 'EMPLOYER VERIFIED' : 'APPLICATION REJECTED'; ?>
                                        </span>
                                    </div>
                                </div>
                                
                                <!-- Existing review details -->
                                <?php if ($accreditation['reviewed_by_name']): ?>
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">Reviewed By</label>
                                        <p class="text-gray-900"><?php echo htmlspecialchars($accreditation['reviewed_by_name']); ?></p>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if ($accreditation['reviewed_at']): ?>
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">Review Date</label>
                                        <p class="text-gray-900"><?php echo date('M j, Y g:i A', strtotime($accreditation['reviewed_at'])); ?></p>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if ($accreditation['notes']): ?>
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">Review Notes</label>
                                        <p class="text-gray-900 bg-gray-50 p-3 rounded"><?php echo nl2br(htmlspecialchars($accreditation['notes'])); ?></p>
                                    </div>
                                <?php endif; ?>
                                
                                <!-- Option to change status if needed -->
                                <div class="pt-3 border-t">
                                    <p class="text-xs text-gray-500 mb-2">Change Status</p>
                                    <form method="POST" action="?page=admin-process-accreditation" class="space-y-2">
                                        <input type="hidden" name="accreditation_id" value="<?php echo $accreditation['accreditation_id']; ?>">
                                        <textarea name="notes" placeholder="Reason for status change..." 
                                                  class="w-full px-3 py-2 border border-gray-300 rounded-md text-xs" rows="2"></textarea>
                                        
                                        <div class="space-y-1">
                                            <!-- Approve Button -->
                                            <button type="submit" name="status" value="approved"
                                                    onclick="return confirm('Set status to APPROVED?')"
                                                    class="w-full py-1 px-3 text-xs rounded transition-colors
                                                           <?php echo $accreditation['status'] === 'approved' ? 'bg-green-200 text-green-800 cursor-not-allowed' : 'bg-green-600 text-white hover:bg-green-700'; ?>"
                                                    <?php echo $accreditation['status'] === 'approved' ? 'disabled' : ''; ?>>
                                                <i class="fas fa-check mr-1"></i>
                                                <?php echo $accreditation['status'] === 'approved' ? 'Currently Approved' : 'Set to Approved'; ?>
                                            </button>
                                            
                                            <!-- Reject Button -->
                                            <button type="submit" name="status" value="rejected"
                                                    onclick="return confirm('Set status to REJECTED?')"
                                                    class="w-full py-1 px-3 text-xs rounded transition-colors
                                                           <?php echo $accreditation['status'] === 'rejected' ? 'bg-red-200 text-red-800 cursor-not-allowed' : 'bg-red-600 text-white hover:bg-red-700'; ?>"
                                                    <?php echo $accreditation['status'] === 'rejected' ? 'disabled' : ''; ?>>
                                                <i class="fas fa-times mr-1"></i>
                                                <?php echo $accreditation['status'] === 'rejected' ? 'Currently Rejected' : 'Set to Rejected'; ?>
                                            </button>
                                            
                                            <!-- Pending Button -->
                                            <button type="submit" name="status" value="pending"
                                                    onclick="return confirm('Reset status to PENDING?')"
                                                    class="w-full py-1 px-3 text-xs rounded transition-colors
                                                           <?php echo $accreditation['status'] === 'pending' ? 'bg-yellow-200 text-yellow-800 cursor-not-allowed' : 'bg-yellow-600 text-white hover:bg-yellow-700'; ?>"
                                                    <?php echo $accreditation['status'] === 'pending' ? 'disabled' : ''; ?>>
                                                <i class="fas fa-clock mr-1"></i>
                                                <?php echo $accreditation['status'] === 'pending' ? 'Currently Pending' : 'Reset to Pending'; ?>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Submission Details -->
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <h4 class="text-sm font-medium text-gray-900 mb-3">Submission Details</h4>
                            <div class="space-y-2 text-sm">
                                <div>
                                    <span class="text-gray-500">Submitted:</span>
                                    <span class="text-gray-900"><?php echo date('M j, Y g:i A', strtotime($accreditation['created_at'])); ?></span>
                                </div>
                                <div>
                                    <span class="text-gray-500">Documents:</span>
                                    <span class="text-gray-900"><?php echo $uploadedDocs; ?>/<?php echo count($documentTypes); ?> uploaded</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>