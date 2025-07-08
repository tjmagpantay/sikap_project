<?php
// filepath: c:\xampp\htdocs\sikap\app\views\employers\profile-employer.php
include_once __DIR__ . '/../components/navbar-top.php';
include_once __DIR__ . '/navbar-employer.php';

// Get employer data and calculate completion
$employer = $this->employerModel->findByUserId($_SESSION['user_id']);
$business = $employer ? $this->employerModel->getBusiness($employer['employer_id']) : null;
$documents = $employer ? $this->employerModel->getDocuments($employer['employer_id']) : null;
$completionPercentage = $this->employerModel->calculateProfileCompletion($_SESSION['user_id']);
$verificationStatus = $this->employerModel->getVerificationStatus($_SESSION['user_id']);
$isVerified = $verificationStatus['status'] === 'verified';
$canPostJobs = $this->employerModel->canPostJobs($_SESSION['user_id']);

// Decode social media data
$socials = [];
if (!empty($business['business_socials'])) {
    $socials = json_decode($business['business_socials'], true) ?? [];
}

// Document types for display
$documentTypes = [
    'letter_of_intent' => 'Letter of Intent',
    'company_profile' => 'Company Profile',
    'business_permit' => 'Business Permit',
    'cert_of_no_pending_case' => 'Certificate of No Pending Case',
    'dole_registration' => 'DOLE Registration'
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

// Calculate separate completion percentages
$personalCompletion = 0;
$businessCompletion = 0;

// Personal profile completion (out of 100%)
$personalFields = ['first_name', 'last_name', 'position', 'contact_no'];
$personalCompleted = 0;
foreach ($personalFields as $field) {
    if (!empty($employer[$field])) {
        $personalCompleted++;
    }
}
$personalCompletion = ($personalCompleted / count($personalFields)) * 100;

// Business completion (out of 100%)
$businessCompleted = 0;
$totalBusinessItems = 8; // Adjust based on your business requirements

if ($business) {
    $businessFields = ['business_name', 'business_type', 'business_industry', 'business_desc'];
    foreach ($businessFields as $field) {
        if (!empty($business[$field])) {
            $businessCompleted++;
        }
    }
    
    // Check for documents (count as 4 items)
    if ($uploadedDocs > 0) {
        $businessCompleted += min($uploadedDocs, 4);
    }
}

$businessCompletion = ($businessCompleted / $totalBusinessItems) * 100;
?>

<div class="flex flex-col min-h-screen gap-6 p-6 font-sans bg-gray-100 md:flex-row">
    <!-- Sidebar -->
    <div class="w-full p-4 bg-white shadow md:w-1/4 rounded-xl">
        <div class="flex flex-col items-center">
            <!-- Business Logo (instead of profile photo) -->
            <div class="relative group">
                <img src="<?php 
                    // Priority: Business logo > Default company logo
                    if (!empty($business['business_logo'])) {
                        echo htmlspecialchars($business['business_logo']);
                    } else {
                        // Default business logo with company name or fallback
                        $companyName = $business['business_name'] ?? $employer['company_name'] ?? 'Company';
                        echo 'https://ui-avatars.com/api/?name=' . urlencode($companyName) . '&background=2563eb&color=fff&size=96&format=svg&bold=true';
                    }
                ?>"
                    class="object-cover w-24 h-24 border-2 border-gray-200 rounded-full shadow-sm" alt="Business Logo">

                <!-- Edit button positioned at top-right of logo -->
                <button class="absolute flex items-center justify-center text-white transition-all duration-200 bg-blue-600 border-2 border-white rounded-full shadow-lg -top-1 -right-1 w-7 h-7 hover:bg-blue-700 hover:shadow-xl group-hover:scale-110"
                    onclick="document.getElementById('business-logo-input').click()"
                    title="Change business logo">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4 5a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V7a2 2 0 00-2-2h-1.586a1 1 0 01-.707-.293l-1.121-1.121A2 2 0 0011.172 3H8.828a2 2 0 00-1.414.586L6.293 4.707A1 1 0 015.586 5H4zm6 9a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path>
                    </svg>
                </button>

                <!-- Hidden file input for business logo upload -->
                <input type="file" id="business-logo-input" accept="image/*" class="hidden" onchange="handleBusinessLogoUpload(this)">
            </div>

            <!-- Company Name and Business Info -->
            <div class="mt-4 text-center">
                <h2 class="text-xl font-bold text-gray-800">
                    <?php echo htmlspecialchars($business['business_name'] ?? $employer['company_name'] ?? 'Company Name'); ?>
                </h2>
                <?php if (!empty($business['business_industry'])): ?>
                    <p class="text-sm text-gray-600"><?php echo htmlspecialchars($business['business_industry']); ?></p>
                <?php endif; ?>
                <?php if (!empty($business['business_type'])): ?>
                    <p class="text-sm font-medium text-blue-600"><?php echo htmlspecialchars($business['business_type']); ?></p>
                <?php endif; ?>
                <!-- Show employer name as subtitle -->
                <p class="mt-1 text-xs text-gray-500">
                    <?php echo htmlspecialchars(trim(($employer['first_name'] ?? '') . ' ' . ($employer['last_name'] ?? ''))); ?>
                    <?php if (!empty($employer['position'])): ?>
                        • <?php echo htmlspecialchars($employer['position']); ?>
                    <?php endif; ?>
                </p>
            </div>

            <!-- Verification Status -->
            <div class="w-full mt-4">
                <?php if ($isVerified): ?>
                    <div class="flex items-center justify-center px-3 py-2 bg-green-100 border border-green-200 rounded-lg">
                        <i class="mr-2 text-green-600 fas fa-check-circle"></i>
                        <span class="text-sm font-medium text-green-800">Verified Employer</span>
                    </div>
                    <?php if (!empty($verificationStatus['verified_at'])): ?>
                        <p class="mt-1 text-xs text-center text-green-600">
                            Verified on <?php echo date('M j, Y', strtotime($verificationStatus['verified_at'])); ?>
                        </p>
                    <?php endif; ?>
                <?php elseif ($verificationStatus['status'] === 'rejected'): ?>
                    <div class="flex items-center justify-center px-3 py-2 bg-red-100 border border-red-200 rounded-lg">
                        <i class="mr-2 text-red-600 fas fa-times-circle"></i>
                        <span class="text-sm font-medium text-red-800">Application Rejected</span>
                    </div>
                    <?php if (!empty($verificationStatus['reason'])): ?>
                        <p class="mt-1 text-xs text-center text-red-600">
                            Reason: <?php echo htmlspecialchars($verificationStatus['reason']); ?>
                        </p>
                    <?php endif; ?>
                <?php elseif ($verificationStatus['status'] === 'pending'): ?>
                    <div class="flex items-center justify-center px-3 py-2 bg-yellow-100 border border-yellow-200 rounded-lg">
                        <i class="mr-2 text-yellow-600 fas fa-clock"></i>
                        <span class="text-sm font-medium text-yellow-800">Pending Verification</span>
                    </div>
                    <p class="mt-1 text-xs text-center text-yellow-600">
                        Your application is being reviewed by our team
                    </p>
                <?php else: ?>
                    <div class="flex items-center justify-center px-3 py-2 bg-gray-100 border border-gray-200 rounded-lg">
                        <i class="mr-2 text-gray-600 fas fa-info-circle"></i>
                        <span class="text-sm font-medium text-gray-800">Complete Profile</span>
                    </div>
                    <p class="mt-1 text-xs text-center text-gray-600">
                        Complete your profile to submit for verification
                    </p>
                <?php endif; ?>
            </div>

            <!-- Profile Completion -->
            <div class="w-full mt-4 space-y-4">
                <!-- Personal Profile Completion -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-gray-700">Personal Profile</span>
                        <span class="text-sm font-medium text-blue-600"><?php echo round($personalCompletion); ?>%</span>
                    </div>
                    <div class="w-full h-2 bg-gray-200 rounded-full">
                        <div class="h-2 transition-all duration-300 bg-blue-600 rounded-full" style="width: <?php echo $personalCompletion; ?>%"></div>
                    </div>
                    <div class="flex items-center justify-between mt-1">
                        <p class="text-xs text-gray-500">
                            <?php echo $personalCompleted; ?>/<?php echo count($personalFields); ?> fields completed
                        </p>
                        <?php if ($personalCompletion < 100): ?>
                            <a href="?page=employer-personal-profile" class="text-xs text-blue-600 hover:text-blue-700">Complete</a>
                        <?php else: ?>
                            <span class="text-xs text-green-600">✓ Complete</span>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Business Setup Completion -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-gray-700">Business Setup</span>
                        <span class="text-sm font-medium text-orange-600"><?php echo round($businessCompletion); ?>%</span>
                    </div>
                    <div class="w-full h-2 bg-gray-200 rounded-full">
                        <div class="h-2 transition-all duration-300 bg-orange-600 rounded-full" style="width: <?php echo $businessCompletion; ?>%"></div>
                    </div>
                    <div class="flex items-center justify-between mt-1">
                        <p class="text-xs text-gray-500">
                            <?php echo $businessCompleted; ?>/<?php echo $totalBusinessItems; ?> items completed
                        </p>
                        <?php if ($businessCompletion < 100): ?>
                            <a href="?page=complete-employer-business&step=1" class="text-xs text-orange-600 hover:text-orange-700">Complete</a>
                        <?php else: ?>
                            <span class="text-xs text-green-600">✓ Complete</span>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Overall Progress -->
                <div class="pt-2 mt-3 border-t border-gray-200">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-semibold text-gray-800">Overall Progress</span>
                        <span class="text-sm font-semibold text-green-600"><?php echo round(($personalCompletion + $businessCompletion) / 2); ?>%</span>
                    </div>
                    <div class="w-full h-2 bg-gray-200 rounded-full">
                        <div class="h-2 transition-all duration-300 bg-green-600 rounded-full" style="width: <?php echo ($personalCompletion + $businessCompletion) / 2; ?>%"></div>
                    </div>
                    <?php if (($personalCompletion + $businessCompletion) / 2 < 100): ?>
                        <p class="mt-1 text-xs text-gray-500">Complete both sections to unlock all features</p>
                    <?php else: ?>
                        <p class="mt-1 text-xs text-green-600">🎉 Profile fully completed!</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Contact Information -->
            <?php if (!empty($employer['contact_no'])): ?>
                <div class="w-full p-3 mt-4 rounded-lg bg-gray-50">
                    <div class="flex items-center">
                        <i class="mr-2 text-gray-500 fas fa-phone"></i>
                        <span class="text-sm text-gray-700"><?php echo htmlspecialchars($employer['contact_no']); ?></span>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Quick Actions - Replace the existing section -->
            <div class="w-full mt-4 space-y-2">
                <?php if ($canPostJobs): ?>
                    <a href="?page=post-job" class="flex items-center justify-center w-full px-4 py-2 text-white transition-colors bg-blue-600 rounded-lg hover:bg-blue-700">
                        <i class="mr-2 fas fa-plus"></i>
                        Post New Job
                    </a>
                <?php else: ?>
                    <button disabled class="flex items-center justify-center w-full px-4 py-2 text-gray-500 bg-gray-300 rounded-lg cursor-not-allowed">
                        <i class="mr-2 fas fa-lock"></i>
                        Complete Profile to Post Jobs
                    </button>
                <?php endif; ?>

                <div class="grid grid-cols-2 gap-2">
                    <a href="?page=employer-personal-profile" class="flex items-center justify-center px-3 py-2 text-xs text-blue-700 transition-colors bg-blue-100 rounded-lg hover:bg-blue-200">
                        <i class="mr-1 fas fa-user"></i>
                        Personal
                    </a>
                    <a href="?page=complete-employer-business&step=1" class="flex items-center justify-center px-3 py-2 text-xs text-orange-700 transition-colors bg-orange-100 rounded-lg hover:bg-orange-200">
                        <i class="mr-1 fas fa-building"></i>
                        Business
                    </a>
                </div>

                <a href="?page=complete-employer-profile" class="flex items-center justify-center w-full px-4 py-2 text-gray-700 transition-colors bg-gray-100 rounded-lg hover:bg-gray-200">
                    <i class="mr-2 fas fa-cog"></i>
                    Profile Dashboard
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="w-full space-y-6 md:w-3/4">

        <!-- Banner Section -->
        <?php if (!empty($business['banner_image'])): ?>
            <div class="relative overflow-hidden bg-white shadow rounded-xl">
                <img src="<?php echo htmlspecialchars($business['banner_image']); ?>"
                    alt="Company Banner"
                    class="object-cover w-full h-48">
                <div class="absolute inset-0 flex items-end bg-black bg-opacity-40">
                    <div class="p-6 text-white">
                        <h1 class="text-2xl font-bold"><?php echo htmlspecialchars($business['business_name'] ?? $employer['company_name'] ?? 'Company Name'); ?></h1>
                        <?php if (!empty($business['business_industry'])): ?>
                            <p class="text-sm opacity-90"><?php echo htmlspecialchars($business['business_industry']); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- About Section -->
        <div class="p-6 bg-white shadow rounded-xl">
            <div class="flex items-center justify-between mb-4">
                <h3 class="flex items-center text-lg font-semibold text-gray-800">
                    <i class="mr-2 text-blue-600 fas fa-info-circle"></i>
                    About <?php echo !empty($business['business_name']) ? htmlspecialchars($business['business_name']) : 'Us'; ?>
                </h3>
                <a href="?page=complete-employer-business&step=1" class="text-blue-600 hover:text-blue-700">
                    <i class="fas fa-edit"></i>
                </a>
            </div>

            <?php if (!empty($business['business_desc']) || !empty($employer['about_us'])): ?>
                <p class="leading-relaxed text-gray-700">
                    <?php echo nl2br(htmlspecialchars($business['business_desc'] ?? $employer['about_us'] ?? '')); ?>
                </p>
            <?php else: ?>
                <div class="py-8 text-center text-gray-500">
                    <i class="mb-4 text-4xl fas fa-plus-circle"></i>
                    <p>Tell candidates about your company</p>
                    <a href="?page=complete-employer-business&step=1" class="font-medium text-blue-600 hover:text-blue-700">Add description</a>
                </div>
            <?php endif; ?>
        </div>

        <!-- Business Information -->
        <?php if ($business): ?>
            <div class="p-6 bg-white shadow rounded-xl">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="flex items-center text-lg font-semibold text-gray-800">
                        <i class="mr-2 text-blue-600 fas fa-building"></i>
                        Business Information
                    </h3>
                    <a href="?page=complete-employer-business&step=2" class="text-blue-600 hover:text-blue-700">
                        <i class="fas fa-edit"></i>
                    </a>
                </div>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                    <?php if (!empty($business['business_type'])): ?>
                        <div class="flex items-center p-3 rounded-lg bg-gray-50">
                            <i class="mr-3 text-gray-500 fas fa-building"></i>
                            <div>
                                <p class="text-xs text-gray-500">Organization Type</p>
                                <p class="font-medium text-gray-800"><?php echo htmlspecialchars($business['business_type']); ?></p>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($business['business_industry'])): ?>
                        <div class="flex items-center p-3 rounded-lg bg-gray-50">
                            <i class="mr-3 text-gray-500 fas fa-industry"></i>
                            <div>
                                <p class="text-xs text-gray-500">Industry</p>
                                <p class="font-medium text-gray-800"><?php echo htmlspecialchars($business['business_industry']); ?></p>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($business['business_team_size'])): ?>
                        <div class="flex items-center p-3 rounded-lg bg-gray-50">
                            <i class="mr-3 text-gray-500 fas fa-users"></i>
                            <div>
                                <p class="text-xs text-gray-500">Team Size</p>
                                <p class="font-medium text-gray-800"><?php echo htmlspecialchars($business['business_team_size']); ?> employees</p>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($business['business_established_year'])): ?>
                        <div class="flex items-center p-3 rounded-lg bg-gray-50">
                            <i class="mr-3 text-gray-500 fas fa-calendar"></i>
                            <div>
                                <p class="text-xs text-gray-500">Established</p>
                                <p class="font-medium text-gray-800"><?php echo date('Y', strtotime($business['business_established_year'])); ?></p>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($business['business_website'])): ?>
                        <div class="flex items-center p-3 rounded-lg bg-gray-50">
                            <i class="mr-3 text-gray-500 fas fa-globe"></i>
                            <div>
                                <p class="text-xs text-gray-500">Website</p>
                                <a href="<?php echo htmlspecialchars($business['business_website']); ?>" target="_blank"
                                    class="font-medium text-blue-600 break-all hover:text-blue-700">
                                    <?php echo htmlspecialchars($business['business_website']); ?>
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($business['business_contact'])): ?>
                        <div class="flex items-center p-3 rounded-lg bg-gray-50">
                            <i class="mr-3 text-gray-500 fas fa-phone"></i>
                            <div>
                                <p class="text-xs text-gray-500">Business Contact</p>
                                <p class="font-medium text-gray-800"><?php echo htmlspecialchars($business['business_contact']); ?></p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if (!empty($business['business_address'])): ?>
                    <div class="p-3 mt-4 rounded-lg bg-gray-50">
                        <div class="flex items-start">
                            <i class="mt-1 mr-3 text-gray-500 fas fa-map-marker-alt"></i>
                            <div>
                                <p class="text-xs text-gray-500">Address</p>
                                <p class="font-medium text-gray-800"><?php echo nl2br(htmlspecialchars($business['business_address'])); ?></p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <!-- Social Media -->
        <?php if (!empty($socials)): ?>
            <div class="p-6 bg-white shadow rounded-xl">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="flex items-center text-lg font-semibold text-gray-800">
                        <i class="mr-2 text-blue-600 fas fa-share-alt"></i>
                        Social Media
                    </h3>
                    <a href="?page=complete-employer-business&step=3" class="text-blue-600 hover:text-blue-700">
                        <i class="fas fa-edit"></i>
                    </a>
                </div>

                <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
                    <?php foreach ($socials as $platform => $url): ?>
                        <?php if (!empty($url)): ?>
                            <a href="<?php echo htmlspecialchars($url); ?>" target="_blank"
                                class="flex items-center justify-center p-4 transition-colors rounded-lg bg-gray-50 hover:bg-gray-100">
                                <i class="fab fa-<?php echo $platform; ?> text-2xl text-gray-600 mr-2"></i>
                                <span class="font-medium text-gray-800 capitalize"><?php echo $platform; ?></span>
                            </a>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Documents Status -->
        <div class="p-6 bg-white shadow rounded-xl">
            <div class="flex items-center justify-between mb-4">
                <h3 class="flex items-center text-lg font-semibold text-gray-800">
                    <i class="mr-2 text-blue-600 fas fa-file-alt"></i>
                    Required Documents
                    <span class="ml-2 text-sm text-gray-500">(<?php echo $uploadedDocs; ?>/<?php echo count($documentTypes); ?>)</span>
                </h3>
                <a href="?page=complete-employer-business&step=4" class="text-blue-600 hover:text-blue-700">
                    <i class="fas fa-upload"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                <?php foreach ($documentTypes as $type => $label): ?>
                    <div class="flex items-center justify-between p-3 border rounded-lg <?php echo !empty($documents[$type]) ? 'border-green-200 bg-green-50' : 'border-gray-200 bg-gray-50'; ?>">
                        <div class="flex items-center">
                            <i class="fas fa-file-pdf <?php echo !empty($documents[$type]) ? 'text-green-600' : 'text-gray-400'; ?> mr-3"></i>
                            <div>
                                <p class="text-sm font-medium <?php echo !empty($documents[$type]) ? 'text-green-800' : 'text-gray-600'; ?>">
                                    <?php echo $label; ?>
                                </p>
                                <?php if (!empty($documents[$type])): ?>
                                    <p class="text-xs text-green-600">Uploaded</p>
                                <?php else: ?>
                                    <p class="text-xs text-gray-500">Not uploaded</p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="flex items-center space-x-2">
                            <?php if (!empty($documents[$type])): ?>
                                <!-- NEW: Secure document links -->
                                <a href="?page=download-employer-document&type=<?php echo $type; ?>&employer_id=<?php echo $employer['employer_id']; ?>" target="_blank"
                                    class="text-green-600 hover:text-green-700" title="View Document">
                                    View
                                </a>
                                <a href="?page=download-employer-document&type=<?php echo $type; ?>&employer_id=<?php echo $employer['employer_id']; ?>&download=1"
                                    class="text-blue-600 hover:text-blue-700" title="Download Document">
                                    Download
                                </a>
                            <?php else: ?>
                                <i class="text-gray-400 fas fa-times-circle"></i>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <?php if ($uploadedDocs < count($documentTypes)): ?>
                <div class="p-4 mt-4 border border-yellow-200 rounded-lg bg-yellow-50">
                    <div class="flex">
                        <i class="fas fa-exclamation-triangle text-yellow-600 mr-2 mt-0.5"></i>
                        <div>
                            <p class="text-sm font-medium text-yellow-800">
                                Complete document upload to unlock job posting
                            </p>
                            <p class="mt-1 text-sm text-yellow-700">
                                Upload <?php echo count($documentTypes) - $uploadedDocs; ?> more document(s) to complete your profile.
                            </p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Recent Activity -->
        <div class="p-6 bg-white shadow rounded-xl">
            <h3 class="flex items-center mb-4 text-lg font-semibold text-gray-800">
                <i class="mr-2 text-blue-600 fas fa-clock"></i>
                Recent Activity
            </h3>

            <div class="space-y-3">
                <div class="flex items-center p-3 rounded-lg bg-gray-50">
                    <i class="mr-3 text-blue-600 fas fa-user-plus"></i>
                    <div>
                        <p class="text-sm font-medium text-gray-800">Profile created</p>
                        <p class="text-xs text-gray-500"><?php echo date('M j, Y', strtotime($employer['created_at'] ?? 'now')); ?></p>
                    </div>
                </div>

                <?php if ($isVerified): ?>
                    <div class="flex items-center p-3 rounded-lg bg-green-50">
                        <i class="mr-3 text-green-600 fas fa-check-circle"></i>
                        <div>
                            <p class="text-sm font-medium text-gray-800">Profile verified</p>
                            <p class="text-xs text-gray-500">You can now post jobs</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>

<script>
    function handleProfilePhotoUpload(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];

            // Validate file type
            if (!file.type.startsWith('image/')) {
                alert('Please select an image file.');
                return;
            }

            // Validate file size (max 2MB)
            if (file.size > 2 * 1024 * 1024) {
                alert('File size must be less than 2MB.');
                return;
            }

            // Create FormData for upload
            const formData = new FormData();
            formData.append('profile_photo', file);

            // Show loading state
            const button = document.querySelector('.bg-blue-600');
            const originalContent = button.innerHTML;
            button.innerHTML = '<svg class="w-3 h-3 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
            button.disabled = true;

            // Upload the file
            fetch('?page=upload-employer-profile-photo', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update the profile image
                        const profileImg = document.querySelector('img[alt="Profile"]');
                        profileImg.src = data.image_url + '?t=' + new Date().getTime(); // Add timestamp to force reload

                        // Show success message
                        showNotification('Profile photo updated successfully!', 'success');
                    } else {
                        showNotification(data.message || 'Failed to upload photo', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Failed to upload photo', 'error');
                })
                .finally(() => {
                    // Restore button state
                    button.innerHTML = originalContent;
                    button.disabled = false;
                    input.value = ''; // Clear the input
                });
        }
    }

    function handleBusinessLogoUpload(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];

            // Validate file type
            if (!file.type.startsWith('image/')) {
                alert('Please select an image file.');
                return;
            }

            // Validate file size (max 2MB)
            if (file.size > 2 * 1024 * 1024) {
                alert('File size must be less than 2MB.');
                return;
            }

            // Create FormData for upload
            const formData = new FormData();
            formData.append('business_logo', file);

            // Show loading state
            const button = document.querySelector('.bg-blue-600');
            const originalContent = button.innerHTML;
            button.innerHTML = '<svg class="w-3 h-3 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
            button.disabled = true;

            // Upload the file
            fetch('?page=upload-business-logo', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update the business logo
                        const logoImg = document.querySelector('img[alt="Business Logo"]');
                        logoImg.src = data.image_url + '?t=' + new Date().getTime(); // Add timestamp to force reload

                        // Show success message
                        showNotification('Business logo updated successfully!', 'success');
                    } else {
                        showNotification(data.message || 'Failed to upload logo', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Failed to upload logo', 'error');
                })
                .finally(() => {
                    // Restore button state
                    button.innerHTML = originalContent;
                    button.disabled = false;
                    input.value = ''; // Clear the input
                });
        }
    }

    function showNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 p-4 rounded-md shadow-lg z-50 ${
        type === 'success' ? 'bg-green-100 text-green-800 border border-green-200' : 'bg-red-100 text-red-800 border border-red-200'
    }`;
        notification.innerHTML = `
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                ${type === 'success' 
                    ? '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>'
                    : '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>'
                }
            </svg>
            <span class="text-sm">${message}</span>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-gray-400 hover:text-gray-600">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>
        </div>
    `;

        document.body.appendChild(notification);

        // Auto remove after 5 seconds
        setTimeout(() => {
            if (notification.parentElement) {
                notification.remove();
            }
        }, 5000);
    }
</script>