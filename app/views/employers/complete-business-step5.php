<?php
// filepath: c:\xampp\htdocs\sikap\app\views\employers\complete-business-step5.php
include_once __DIR__ . '/../components/navbar-top.php';
include_once __DIR__ . '/navbar-employer.php';

// Decode social media data
$socials = [];
if (!empty($business['business_socials'])) {
    $socials = json_decode($business['business_socials'], true) ?? [];
}

// Document types and their labels
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
foreach ($documentTypes as $type => $label) {
    if (!empty($documents[$type])) {
        $uploadedDocs++;
    }
}
?>

<div class="min-h-screen py-12 bg-gray-50 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-4xl">
        <div class="text-center">
            <div class="flex justify-center mb-4">
                <div class="p-3 bg-blue-600 rounded-full">
                    <i class="text-2xl text-white fas fa-check-circle"></i>
                </div>
            </div>
            <h2 class="mt-6 text-3xl font-extrabold text-center text-gray-900">
                Profile Review
            </h2>
            <p class="mt-2 text-sm text-center text-gray-600">
                Step 5/5
            </p>
            <p class="mt-2 text-sm text-center text-gray-500">
                Review your information before submitting
            </p>
        </div>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-4xl">
        <div class="px-4 py-8 bg-white shadow sm:rounded-lg sm:px-10">
            <!-- Progress bar -->
            <div class="w-full h-2 mb-6 bg-gray-200 rounded">
                <div class="h-2 bg-green-600 rounded" style="width: 100%"></div>
            </div>

            <!-- Profile Summary -->
            <div class="space-y-8">
                <!-- Personal Information -->
                <div class="border-b border-gray-200 pb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-user mr-2 text-blue-600"></i>
                        Personal Information
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Name</p>
                            <p class="font-medium"><?php echo htmlspecialchars(trim(($employer['first_name'] ?? '') . ' ' . ($employer['middle_name'] ?? '') . ' ' . ($employer['last_name'] ?? ''))); ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Position</p>
                            <p class="font-medium"><?php echo htmlspecialchars($employer['position'] ?? 'Not specified'); ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Contact</p>
                            <p class="font-medium"><?php echo htmlspecialchars($employer['contact_no'] ?? 'Not specified'); ?></p>
                        </div>
                    </div>
                    <?php if (!empty($employer['about_us'])): ?>
                        <div class="mt-4">
                            <p class="text-sm text-gray-600">About</p>
                            <p class="font-medium"><?php echo htmlspecialchars($employer['about_us']); ?></p>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Business Information -->
                <div class="border-b border-gray-200 pb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-building mr-2 text-blue-600"></i>
                        Business Information
                    </h3>
                    
                    <?php if (!empty($business['banner_image'])): ?>
                        <div class="mb-4">
                            <p class="text-sm text-gray-600 mb-2">Banner Image</p>
                            <img src="<?php echo htmlspecialchars($business['banner_image']); ?>" 
                                 alt="Banner" 
                                 class="w-full h-32 object-cover rounded-md border border-gray-300">
                        </div>
                    <?php endif; ?>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Company Name</p>
                            <p class="font-medium"><?php echo htmlspecialchars($business['business_name'] ?? 'Not specified'); ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Industry</p>
                            <p class="font-medium"><?php echo htmlspecialchars($business['business_industry'] ?? 'Not specified'); ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Organization Type</p>
                            <p class="font-medium"><?php echo htmlspecialchars($business['business_type'] ?? 'Not specified'); ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Team Size</p>
                            <p class="font-medium"><?php echo htmlspecialchars($business['business_team_size'] ?? 'Not specified'); ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Established</p>
                            <p class="font-medium"><?php echo !empty($business['business_established_year']) ? date('Y', strtotime($business['business_established_year'])) : 'Not specified'; ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Contact</p>
                            <p class="font-medium"><?php echo htmlspecialchars($business['business_contact'] ?? 'Not specified'); ?></p>
                        </div>
                    </div>
                    
                    <?php if (!empty($business['business_address'])): ?>
                        <div class="mt-4">
                            <p class="text-sm text-gray-600">Address</p>
                            <p class="font-medium"><?php echo htmlspecialchars($business['business_address']); ?></p>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($business['business_website'])): ?>
                        <div class="mt-4">
                            <p class="text-sm text-gray-600">Website</p>
                            <a href="<?php echo htmlspecialchars($business['business_website']); ?>" target="_blank" class="font-medium text-blue-600 hover:text-blue-700"><?php echo htmlspecialchars($business['business_website']); ?></a>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($business['business_desc'])): ?>
                        <div class="mt-4">
                            <p class="text-sm text-gray-600">Description</p>
                            <p class="font-medium"><?php echo nl2br(htmlspecialchars($business['business_desc'])); ?></p>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Social Media -->
                <?php if (!empty($socials)): ?>
                    <div class="border-b border-gray-200 pb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-share-alt mr-2 text-blue-600"></i>
                            Social Media
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <?php foreach ($socials as $platform => $url): ?>
                                <?php if (!empty($url)): ?>
                                    <div>
                                        <p class="text-sm text-gray-600"><?php echo ucfirst($platform); ?></p>
                                        <a href="<?php echo htmlspecialchars($url); ?>" target="_blank" class="font-medium text-blue-600 hover:text-blue-700 break-all"><?php echo htmlspecialchars($url); ?></a>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Documents -->
                <div class="border-b border-gray-200 pb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-file-alt mr-2 text-blue-600"></i>
                        Documents <span class="text-sm font-normal text-gray-500">(<?php echo $uploadedDocs; ?> of <?php echo count($documentTypes); ?> uploaded)</span>
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <?php foreach ($documentTypes as $type => $label): ?>
                            <div class="flex items-center justify-between p-3 border rounded-md <?php echo !empty($documents[$type]) ? 'border-green-200 bg-green-50' : 'border-gray-200 bg-gray-50'; ?>">
                                <div class="flex items-center">
                                    <i class="fas fa-file-pdf <?php echo !empty($documents[$type]) ? 'text-green-600' : 'text-gray-400'; ?> mr-2"></i>
                                    <span class="text-sm <?php echo !empty($documents[$type]) ? 'text-green-800' : 'text-gray-600'; ?>"><?php echo $label; ?></span>
                                </div>
                                <?php if (!empty($documents[$type])): ?>
                                    <i class="fas fa-check-circle text-green-600"></i>
                                <?php else: ?>
                                    <i class="fas fa-times-circle text-gray-400"></i>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Completion Status -->
                <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
                    <h4 class="text-lg font-medium text-blue-900 mb-2">What happens next?</h4>
                    <ul class="text-sm text-blue-700 space-y-1">
                        <li>• Your profile will be reviewed by our admin team</li>
                        <li>• You'll receive an email notification once verified</li>
                        <li>• After verification, you can start posting job opportunities</li>
                        <li>• Make sure all required documents are uploaded for faster processing</li>
                    </ul>
                </div>
            </div>

            <form method="POST" action="?page=complete-employer-business&step=5">
                <div class="flex justify-between mt-8">
                    <a href="?page=complete-employer-business&step=4" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                        <i class="mr-2 fas fa-arrow-left"></i>
                        Back
                    </a>
                    <button type="submit" class="inline-flex items-center px-6 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md hover:bg-green-700">
                        Complete Setup
                        <i class="ml-2 fas fa-check"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>