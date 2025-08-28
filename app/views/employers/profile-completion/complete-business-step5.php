<?php
include_once __DIR__ . '/../components/employer_auth_check.php';
include_once __DIR__ . '../../../components/navbar-top.php';
include_once __DIR__ . '/../components/navbar-employer.php';

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

<div class="min-h-screen py-6">
    <div class="sm:mx-auto sm:w-full sm:max-w-2xl">
        <div class="text-center">
            <h2 class="mt-6 text-3xl font-extrabold text-center text-gray-900">
                Profile Review
            </h2>
            <p class="mt-2 text-sm text-center text-gray-600">
                Step 5/5 - Review your information
            </p>
            <p class="mt-2 text-sm text-center text-gray-500">
                Verify all details before submission
            </p>
        </div>
    </div>

    <div class="mt-4 sm:mx-auto sm:w-full sm:max-w-2xl">
        <div class="px-4 py-8 bg-white shadow sm:rounded-lg sm:px-10">
            <!-- Enhanced Progress bar with clickable steps -->
            <div class="mb-6">
                <!-- Step indicators -->
                <div class="flex items-center justify-between w-full mb-4">
                    <!-- Step 1 -->
                    <div class="flex flex-col items-center">
                        <a href="?page=complete-employer-business&step=1" class="flex items-center justify-center w-8 h-8 text-white transition-colors rounded-full bg-primary hover:bg-blue-700">
                            <span class="text-sm font-semibold">1</span>
                        </a>
                        <span class="mt-1 text-xs text-gray-600">Basic</span>
                    </div>

                    <!-- Step 2 -->
                    <div class="flex flex-col items-center">
                        <a href="?page=complete-employer-business&step=2" class="flex items-center justify-center w-8 h-8 text-white transition-colors rounded-full bg-primary hover:bg-blue-700">
                            <span class="text-sm font-semibold">2</span>
                        </a>
                        <span class="mt-1 text-xs text-gray-600">Founding</span>
                    </div>

                    <!-- Step 3 -->
                    <div class="flex flex-col items-center">
                        <a href="?page=complete-employer-business&step=3" class="flex items-center justify-center w-8 h-8 text-white transition-colors rounded-full bg-primary hover:bg-blue-700">
                            <span class="text-sm font-semibold">3</span>
                        </a>
                        <span class="mt-1 text-xs text-gray-600">Social</span>
                    </div>

                    <!-- Step 4 -->
                    <div class="flex flex-col items-center">
                        <a href="?page=complete-employer-business&step=4" class="flex items-center justify-center w-8 h-8 text-white transition-colors rounded-full bg-primary hover:bg-blue-700">
                            <span class="text-sm font-semibold">4</span>
                        </a>
                        <span class="mt-1 text-xs text-gray-600">Documents</span>
                    </div>

                    <!-- Step 5 -->
                    <div class="flex flex-col items-center">
                        <div class="flex items-center justify-center w-8 h-8 text-white rounded-full bg-secondary">
                            <span class="text-sm font-semibold">5</span>
                        </div>
                        <span class="mt-1 text-xs text-gray-600">Review</span>
                    </div>
                </div>

                <!-- Progress bar -->
                <div class="w-full h-2 bg-gray-200 rounded">
                    <div class="h-2 rounded bg-primary" style="width: 100%"></div>
                </div>
            </div>

            <!-- Error Messages -->
            <?php if (!empty($error)): ?>
                <div class="p-4 mb-4 border border-red-200 rounded-md bg-red-50">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-600"><?php echo htmlspecialchars($error); ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Success Messages -->
            <?php if (!empty($success)): ?>
                <div class="p-4 mb-4 border border-green-200 rounded-md bg-green-50">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-600"><?php echo htmlspecialchars($success); ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Profile Summary -->
            <div class="space-y-8">
                <!-- Personal Information -->
                <div class="mb-8 border-b border-gray-200">
                    <h3 class="flex items-center mb-2 font-medium text-gray-900 text-md">
                        <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Personal Information
                    </h3>
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                        <div>
                            <p class="text-xs font-medium text-gray-500">Name</p>
                            <p class="text-sm text-gray-700"><?php echo htmlspecialchars(trim(($employer['first_name'] ?? '') . ' ' . ($employer['middle_name'] ?? '') . ' ' . ($employer['last_name'] ?? ''))); ?></p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-500">Position</p>
                            <p class="text-sm text-gray-700"><?php echo htmlspecialchars($employer['position'] ?? 'Not specified'); ?></p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-500">Contact</p>
                            <p class="text-sm text-gray-700"><?php echo htmlspecialchars($employer['contact_no'] ?? 'Not specified'); ?></p>
                        </div>
                    </div>
                    <?php if (!empty($employer['about_us'])): ?>
                        <div class="mt-4">
                            <p class="text-xs font-medium text-gray-500">About</p>
                            <p class="text-sm text-gray-700"><?php echo htmlspecialchars($employer['about_us']); ?></p>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Business Information -->
                <div class="mb-8 border-b border-gray-200">
                    <h3 class="flex items-center mb-2 font-medium text-gray-900 text-md">
                        <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        Business Information
                    </h3>

                    <?php if (!empty($business['banner_image'])): ?>
                        <div class="mb-4">
                            <p class="mb-2 text-xs font-medium text-gray-500">Banner Image</p>
                            <img src="<?php echo htmlspecialchars($business['banner_image']); ?>"
                                alt="Banner"
                                class="object-cover w-full h-32 border border-gray-300 rounded-md">
                        </div>
                    <?php endif; ?>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                        <div>
                            <p class="text-xs font-medium text-gray-500">Company Name</p>
                            <p class="text-sm text-gray-700"><?php echo htmlspecialchars($business['business_name'] ?? 'Not specified'); ?></p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-500">Industry</p>
                            <p class="text-sm text-gray-700"><?php echo htmlspecialchars($business['business_industry'] ?? 'Not specified'); ?></p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-500">Organization Type</p>
                            <p class="text-sm text-gray-700"><?php echo htmlspecialchars($business['business_type'] ?? 'Not specified'); ?></p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-500">Team Size</p>
                            <p class="text-sm text-gray-700"><?php echo htmlspecialchars($business['business_team_size'] ?? 'Not specified'); ?></p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-500">Established</p>
                            <p class="text-sm text-gray-700"><?php echo !empty($business['business_established_year']) ? date('Y', strtotime($business['business_established_year'])) : 'Not specified'; ?></p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-500">Contact</p>
                            <p class="text-sm text-gray-700"><?php echo htmlspecialchars($business['business_contact'] ?? 'Not specified'); ?></p>
                        </div>
                    </div>

                    <?php if (!empty($business['business_address'])): ?>
                        <div class="mt-4">
                            <p class="text-xs font-medium text-gray-500">Address</p>
                            <p class="text-sm text-gray-700"><?php echo htmlspecialchars($business['business_address']); ?></p>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($business['business_website'])): ?>
                        <div class="mt-4">
                            <p class="text-xs font-medium text-gray-500">Website</p>
                            <a href="<?php echo htmlspecialchars($business['business_website']); ?>" target="_blank" class="font-medium text-primary hover:text-blue-700"><?php echo htmlspecialchars($business['business_website']); ?></a>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($business['business_desc'])): ?>
                        <div class="mt-4">
                            <p class="text-xs font-medium text-gray-500">Description</p>
                            <p class="text-sm text-gray-700"><?php echo nl2br(htmlspecialchars($business['business_desc'])); ?></p>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Social Media -->
                <?php if (!empty($socials)): ?>
                    <div class="mb-8 border-b border-gray-200">
                        <h3 class="flex items-center mb-2 font-medium text-gray-900 text-md">
                            <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                            </svg>
                            Social Media
                        </h3>
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            <?php foreach ($socials as $platform => $url): ?>
                                <?php if (!empty($url)): ?>
                                    <div>
                                        <p class="text-xs font-medium text-gray-500"><?php echo ucfirst($platform); ?></p>
                                        <a href="<?php echo htmlspecialchars($url); ?>" target="_blank" class="font-medium break-all text-primary hover:text-blue-700"><?php echo htmlspecialchars($url); ?></a>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Documents -->
                <div class="mb-8 border-b border-gray-200">
                    <h3 class="flex items-center mb-2 font-medium text-gray-900 text-md">
                        <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Documents <span class="text-sm font-normal text-gray-500">(<?php echo $uploadedDocs; ?> of <?php echo count($documentTypes); ?> uploaded)</span>
                    </h3>
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                        <?php foreach ($documentTypes as $type => $label): ?>
                            <div class="flex items-center justify-between p-3 border rounded-md <?php echo !empty($documents[$type]) ? 'border-secondary-200 bg-blue-50' : 'border-gray-200 bg-gray-50'; ?>">
                                <div class="flex items-center min-w-0">
                                    <svg class="flex-shrink-0 w-5 h-5 mr-3 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-xs text-gray-600 truncate"><?php echo $label; ?></span>
                                </div>
                                <?php if (!empty($documents[$type])): ?>
                                    <svg class="flex-shrink-0 w-5 h-5 text-secondary" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                <?php else: ?>
                                    <svg class="flex-shrink-0 w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Completion Status -->
                <div class="p-4 border border-blue-200 rounded-md bg-blue-50">
                    <h4 class="mb-2 font-medium text-md text-primary">What happens next?</h4>
                    <ul class="space-y-2 text-xs text-primary">
                        <li class="flex items-start">
                            <svg class="flex-shrink-0 w-4 h-4 mt-0.5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            Your profile will be reviewed by our admin team
                        </li>
                        <li class="flex items-start">
                            <svg class="flex-shrink-0 w-4 h-4 mt-0.5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            You'll receive an email notification once verified
                        </li>
                        <li class="flex items-start">
                            <svg class="flex-shrink-0 w-4 h-4 mt-0.5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            After verification, you can start posting job opportunities
                        </li>
                        <li class="flex items-start">
                            <svg class="flex-shrink-0 w-4 h-4 mt-0.5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            Make sure all required documents are uploaded for faster processing
                        </li>
                    </ul>
                </div>
            </div>

            <form method="POST" action="?page=complete-employer-business&step=5">
                <div class="flex justify-between mt-8">
                    <a href="?page=complete-employer-business&step=4" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back
                    </a>
                    <?php
                    // Check if business profile is already completed (based on existing data)
                    $businessCompleted = !empty($business['business_name']) &&
                        !empty($business['business_desc']) &&
                        !empty($business['business_type']) &&
                        !empty($business['business_industry']);
                    $isUpdating = $businessCompleted;
                    ?>
                    <?php if ($isUpdating): ?>
                        <button type="submit" name="submit_business_profile"
                            class="inline-flex items-center justify-center px-6 py-2 text-sm font-medium text-white transition-colors border border-transparent rounded-md shadow-sm bg-secondary ">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            Update Profile
                        </button>
                    <?php else: ?>
                        <button type="submit" name="submit_business_profile"
                            class="inline-flex items-center justify-center w-full px-6 py-2 text-sm font-medium text-white transition-colors border border-transparent rounded-md shadow-sm bg-primary hover:bg-blue-700">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Complete Profile
                        </button>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>
</div>