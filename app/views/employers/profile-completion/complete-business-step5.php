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
            <h2 class="mt-6 text-3xl font-extrabold text-center text-grayMain">
                Review & Complete Business Profile
            </h2>
            <p class="mt-2 text-sm text-center text-gray-500">
                Review all information before completing your business profile setup
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
                        <a href="?page=complete-employer-business&step=1" class="flex items-center justify-center w-8 h-8 text-gray-500 transition-colors bg-gray-200 rounded-full hover:bg-gray-300 hover:text-gray-700">
                            <span class="text-sm font-semibold">1</span>
                        </a>
                        <span class="mt-1 text-xs text-gray-500">Basic</span>
                    </div>

                    <!-- Step 2 -->
                    <div class="flex flex-col items-center">
                        <a href="?page=complete-employer-business&step=2" class="flex items-center justify-center w-8 h-8 text-gray-500 transition-colors bg-gray-200 rounded-full hover:bg-gray-300 hover:text-gray-700">
                            <span class="text-sm font-semibold">2</span>
                        </a>
                        <span class="mt-1 text-xs text-gray-500">Founding</span>
                    </div>

                    <!-- Step 3 -->
                    <div class="flex flex-col items-center">
                        <a href="?page=complete-employer-business&step=3" class="flex items-center justify-center w-8 h-8 text-gray-500 transition-colors bg-gray-200 rounded-full hover:bg-gray-300 hover:text-gray-700">
                            <span class="text-sm font-semibold">3</span>
                        </a>
                        <span class="mt-1 text-xs text-gray-500">Social</span>
                    </div>

                    <!-- Step 4 -->
                    <div class="flex flex-col items-center">
                        <a href="?page=complete-employer-business&step=4" class="flex items-center justify-center w-8 h-8 text-gray-500 transition-colors bg-gray-200 rounded-full hover:bg-gray-300 hover:text-gray-700">
                            <span class="text-sm font-semibold">4</span>
                        </a>
                        <span class="mt-1 text-xs text-gray-500">Documents</span>
                    </div>

                    <!-- Step 5 -->
                    <div class="flex flex-col items-center">
                        <div class="flex items-center justify-center w-8 h-8 text-white rounded-full bg-primary">
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
            <div class="space-y-6">
                <!-- Personal Information Summary -->
                <div class="p-4 border border-gray-200 rounded-lg">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="flex items-center text-base font-semibold text-gray-900">
                            <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Personal Information
                        </h3>
                        <a href="?page=complete-employer-profile" class="text-sm font-medium text-primary hover:text-blue-700">
                            Edit
                        </a>
                    </div>
                    <div class="grid grid-cols-1 gap-3 md:grid-cols-2">
                        <div class="p-3 bg-white rounded-md">
                            <span class="text-xs font-medium tracking-wider text-gray-500 uppercase">Full Name</span>
                            <p class="mt-1 text-sm text-grayMain">
                                <?php
                                $fullName = trim(($employer['first_name'] ?? '') . ' ' . ($employer['middle_name'] ?? '') . ' ' . ($employer['last_name'] ?? ''));
                                echo htmlspecialchars($fullName ?: 'N/A');
                                ?>
                            </p>
                        </div>
                        <div class="p-3 bg-white rounded-md">
                            <span class="text-xs font-medium tracking-wider text-gray-500 uppercase">Position</span>
                            <p class="mt-1 text-sm text-grayMain"><?php echo htmlspecialchars($employer['position'] ?? 'N/A'); ?></p>
                        </div>
                        <div class="p-3 bg-white rounded-md">
                            <span class="text-xs font-medium tracking-wider text-gray-500 uppercase">Contact Number</span>
                            <p class="mt-1 text-sm text-grayMain"><?php echo htmlspecialchars($employer['contact_no'] ?? 'N/A'); ?></p>
                        </div>
                        <div class="p-3 bg-white rounded-md">
                            <span class="text-xs font-medium tracking-wider text-gray-500 uppercase">Email</span>
                            <p class="mt-1 text-sm text-grayMain"><?php echo htmlspecialchars($_SESSION['email'] ?? 'N/A'); ?></p>
                        </div>
                    </div>
                    <?php if (!empty($employer['about_us'])): ?>
                        <div class="p-3 mt-3 bg-white rounded-md">
                            <span class="text-xs font-medium tracking-wider text-gray-500 uppercase">About</span>
                            <p class="mt-1 text-sm text-grayMain"><?php echo nl2br(htmlspecialchars($employer['about_us'])); ?></p>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Business Information Summary -->
                <div class="p-4 border border-gray-200 rounded-lg">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="flex items-center text-base font-semibold text-gray-900">
                            <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            Business Information
                        </h3>
                        <a href="?page=complete-employer-business&step=1" class="text-sm font-medium text-primary hover:text-blue-700">
                            Edit
                        </a>
                    </div>

                    <?php if (!empty($business['banner_image'])): ?>
                        <div class="p-3 mb-3 bg-white rounded-md">
                            <span class="text-xs font-medium tracking-wider text-gray-500 uppercase">Banner Image</span>
                            <img src="<?php echo htmlspecialchars($business['banner_image']); ?>"
                                alt="Company Banner"
                                class="object-cover w-full h-32 mt-2 border border-gray-300 rounded-md">
                        </div>
                    <?php endif; ?>

                    <div class="grid grid-cols-1 gap-3 md:grid-cols-2">
                        <div class="p-3 bg-white rounded-md">
                            <span class="text-xs font-medium tracking-wider text-gray-500 uppercase">Company Name</span>
                            <p class="mt-1 text-sm text-grayMain"><?php echo htmlspecialchars($business['business_name'] ?? 'N/A'); ?></p>
                        </div>
                        <div class="p-3 bg-white rounded-md">
                            <span class="text-xs font-medium tracking-wider text-gray-500 uppercase">Industry</span>
                            <p class="mt-1 text-sm text-grayMain"><?php echo htmlspecialchars($business['business_industry'] ?? 'N/A'); ?></p>
                        </div>
                        <div class="p-3 bg-white rounded-md">
                            <span class="text-xs font-medium tracking-wider text-gray-500 uppercase">Organization Type</span>
                            <p class="mt-1 text-sm text-grayMain"><?php echo htmlspecialchars($business['business_type'] ?? 'N/A'); ?></p>
                        </div>
                        <div class="p-3 bg-white rounded-md">
                            <span class="text-xs font-medium tracking-wider text-gray-500 uppercase">Team Size</span>
                            <p class="mt-1 text-sm text-grayMain"><?php echo htmlspecialchars($business['business_team_size'] ?? 'N/A'); ?></p>
                        </div>
                        <div class="p-3 bg-white rounded-md">
                            <span class="text-xs font-medium tracking-wider text-gray-500 uppercase">Established</span>
                            <p class="mt-1 text-sm text-grayMain">
                                <?php echo !empty($business['business_established_year']) ? date('Y', strtotime($business['business_established_year'])) : 'N/A'; ?>
                            </p>
                        </div>
                        <div class="p-3 bg-white rounded-md">
                            <span class="text-xs font-medium tracking-wider text-gray-500 uppercase">Business Contact</span>
                            <p class="mt-1 text-sm text-grayMain"><?php echo htmlspecialchars($business['business_contact'] ?? 'N/A'); ?></p>
                        </div>
                    </div>

                    <?php if (!empty($business['business_address'])): ?>
                        <div class="p-3 mt-3 bg-white rounded-md">
                            <span class="text-xs font-medium tracking-wider text-gray-500 uppercase">Business Address</span>
                            <p class="mt-1 text-sm text-grayMain"><?php echo htmlspecialchars($business['business_address']); ?></p>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($business['business_website'])): ?>
                        <div class="p-3 mt-3 bg-white rounded-md">
                            <span class="text-xs font-medium tracking-wider text-gray-500 uppercase">Website</span>
                            <a href="<?php echo htmlspecialchars($business['business_website']); ?>" target="_blank"
                                class="block mt-1 text-sm font-medium break-all text-primary hover:text-blue-700">
                                <?php echo htmlspecialchars($business['business_website']); ?>
                            </a>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($business['business_desc'])): ?>
                        <div class="p-3 mt-3 bg-white rounded-md">
                            <span class="text-xs font-medium tracking-wider text-gray-500 uppercase">Company Description</span>
                            <p class="mt-1 text-sm text-grayMain"><?php echo nl2br(htmlspecialchars($business['business_desc'])); ?></p>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Social Media Summary -->
                <?php if (!empty($socials)): ?>
                    <div class="p-4 border border-gray-200 rounded-lg">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="flex items-center text-base font-semibold text-gray-900">
                                <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                </svg>
                                Social Media Links
                                <span class="ml-2 text-xs font-light text-gray-400">(<?php echo count(array_filter($socials)); ?> links)</span>
                            </h3>
                            <a href="?page=complete-employer-business&step=3" class="text-sm font-medium text-primary hover:text-blue-700">
                                Edit
                            </a>
                        </div>
                        <div class="grid grid-cols-1 gap-3 md:grid-cols-2">
                            <?php foreach ($socials as $platform => $url): ?>
                                <?php if (!empty($url)): ?>
                                    <div class="p-3 bg-white border-l-4 border-blue-500 rounded-md">
                                        <div class="flex items-center">
                                            <?php
                                            // Platform icons
                                            $iconColor = '';
                                            $platformName = '';
                                            switch ($platform) {
                                                case 'facebook':
                                                    $iconColor = 'text-blue-600';
                                                    $platformName = 'Facebook';
                                                    break;
                                                case 'twitter':
                                                    $iconColor = 'text-blue-400';
                                                    $platformName = 'Twitter/X';
                                                    break;
                                                case 'instagram':
                                                    $iconColor = 'text-pink-600';
                                                    $platformName = 'Instagram';
                                                    break;
                                                case 'youtube':
                                                    $iconColor = 'text-red-600';
                                                    $platformName = 'YouTube';
                                                    break;
                                                default:
                                                    $iconColor = 'text-gray-600';
                                                    $platformName = ucfirst($platform);
                                            }
                                            ?>
                                            <svg class="flex-shrink-0 w-4 h-4 mr-2 <?php echo $iconColor; ?>" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                            </svg>
                                            <div class="min-w-0">
                                                <span class="text-xs font-medium tracking-wider text-gray-500 uppercase"><?php echo $platformName; ?></span>
                                                <a href="<?php echo htmlspecialchars($url); ?>" target="_blank"
                                                    class="block mt-1 text-sm font-medium truncate text-primary hover:text-blue-700">
                                                    <?php echo htmlspecialchars($url); ?>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="mb-8 border-b border-gray-200">
                    <h3 class="flex items-center mb-2 font-medium text-gray-900 text-md">
                        <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Documents <span class="ml-2 text-xs font-light text-gray-400"> (<?php echo $uploadedDocs; ?> of <?php echo count($documentTypes); ?> uploaded)</span>
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
                    <ul class="space-y-2 text-sm text-primary">
                        <li class="flex items-start">
                            <svg class="flex-shrink-0 w-4 h-4 mt-0.5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            Your business profile will be reviewed by our admin team
                        </li>
                        <li class="flex items-start">
                            <svg class="flex-shrink-0 w-4 h-4 mt-0.5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            You'll receive an email notification once your profile is verified
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
                            Upload all required documents (*) for faster processing
                        </li>
                    </ul>
                </div>
            </div>

            <form method="POST" action="?page=complete-employer-business&step=5" class="mt-8">
                <div class="flex items-end justify-between">
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

                    <button type="submit" name="submit_business_profile"
                        class="inline-flex px-6 py-3 text-sm font-medium text-white transition-colors border border-transparent rounded-md shadow-sm bg-primary hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        <?php if ($isUpdating): ?>
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            Update Business Profile
                        <?php else: ?>
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Complete Business Profile Setup
                        <?php endif; ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>