<?php
include_once __DIR__ . '/components/employer_auth_check.php';
include_once __DIR__ . '/../components/navbar-top.php';
include_once __DIR__ . '/components/navbar-employer.php';

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
$totalBusinessItems = 13; // 4 business fields + 9 documents

if ($business) {
    $businessFields = ['business_name', 'business_type', 'business_industry', 'business_desc'];
    foreach ($businessFields as $field) {
        if (!empty($business[$field])) {
            $businessCompleted++;
        }
    }
    $businessCompleted += $uploadedDocs;
}

$businessCompletion = ($businessCompleted / $totalBusinessItems) * 100;
?>

<div class="min-h-screen">
    <div class="px-6 py-8">
        <div class="mx-auto max-w-7xl">
            <!-- Main Content with 1/3 and 2/3 Layout -->
            <div class="flex flex-col gap-6 lg:flex-row">

                <!-- Left Side - 1/3 Width -->
                <div class="w-full mx-auto lg:w-1/3 lg:max-w-md">
                    <div class="sticky top-8">
                        <div class="overflow-hidden bg-white border border-gray-200 shadow-lg rounded-xl">
                            <!-- Profile Header with Background -->
                            <div class="p-6 border-b border-gray-200" style="background-image: url('assets/images/profile-header-bg.svg'); background-size: cover; background-position: center; background-repeat: no-repeat;">
                                <div class="flex items-center space-x-4">
                                    <!-- Profile Photo -->
                                    <div class="relative group">
                                        <img src="<?php
                                                    if (!empty($employer['profile_picture'])) {
                                                        echo htmlspecialchars('/sikap/public/' . $employer['profile_picture']);
                                                    } else {
                                                        $fullName = trim(($employer['first_name'] ?? '') . ' ' . ($employer['last_name'] ?? ''));
                                                        if (empty($fullName)) $fullName = 'User';
                                                        echo 'https://ui-avatars.com/api/?name=' . urlencode($fullName) . '&background=1d4ed8&color=fff&size=80&format=svg&bold=true';
                                                    }
                                                    ?>"
                                            class="object-cover w-16 h-16 transition-all duration-200 border-4 border-white rounded-md shadow-lg cursor-pointer group-hover:brightness-75"
                                            alt="Profile Photo"
                                            onclick="document.getElementById('profile-photo-input').click()">

                                        <!-- Hover overlay with camera icon -->
                                        <div class="absolute inset-0 flex items-center justify-center transition-all duration-200 bg-black bg-opacity-0 rounded-md cursor-pointer group-hover:bg-opacity-40"
                                            onclick="document.getElementById('profile-photo-input').click()">
                                            <svg class="w-6 h-6 text-white transition-all duration-200 opacity-0 group-hover:opacity-100"
                                                fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4 5a2 2 0 00-2 2v8a2 2 0 002 
            2h12a2 2 0 002-2V7a2 2 0 00-2-2h-1.586a1 1 
            0 01-.707-.293l-1.121-1.121A2 2 
            0 0011.172 3H8.828a2 2 0 00-1.414.586L6.293 
            4.707A1 1 0 015.586 5H4zm6 9a3 3 0 
            100-6 3 3 0 000 6z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>

                                        <!-- Hover text -->
                                        <div class="absolute px-2 py-1 text-xs text-white transition-all duration-200 transform -translate-x-1/2 bg-black bg-opacity-75 rounded opacity-0 -bottom-8 left-1/2 group-hover:opacity-100">
                                            Change Photo
                                        </div>

                                        <!-- Hidden file input -->
                                        <input type="file" id="profile-photo-input" accept="image/*" class="hidden" onchange="handleProfilePhotoUpload(this)">
                                    </div>

                                    <!-- Personal Info -->
                                    <div class="flex-1">
                                        <h1 class="text-lg font-bold text-white">
                                            <?php echo htmlspecialchars(trim(($employer['first_name'] ?? '') . ' ' . ($employer['last_name'] ?? ''))); ?>
                                        </h1>
                                        <?php if (!empty($employer['position'])): ?>
                                            <p class="text-xs text-gray-800"><?php echo htmlspecialchars($employer['position']); ?> <span class="text-xs text-blue-200"> <?php if (!empty($business['business_name'])): ?>
                                                        at <?php echo htmlspecialchars($business['business_name']); ?>
                                                    <?php endif; ?> </span></p>
                                        <?php endif; ?>



                                        <!-- Verification Badge -->
                                        <?php if ($isVerified): ?>
                                            <div class="flex items-center mt-2">
                                                <svg class="w-4 h-4 mr-1 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                </svg>
                                                <span class="text-xs text-gray-800">Verified Employer</span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Profile Content -->
                            <div class="p-6">
                                <!-- Profile Completion Progress -->
                                <div class="mb-6">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-sm font-semibold text-gray-700">Profile Completion</span>
                                        <span class="text-sm font-bold text-primary"><?php echo round($personalCompletion); ?>%</span>
                                    </div>
                                    <div class="w-full h-2 mb-2 overflow-hidden bg-gray-200 rounded-full">
                                        <div class="h-full transition-all duration-300 bg-primary" style="width: <?php echo $personalCompletion; ?>%"></div>
                                    </div>
                                    <div class="flex justify-between text-xs text-gray-500">
                                        <span><?php echo $personalCompleted; ?>/<?php echo count($personalFields); ?> fields completed</span>
                                        <span><?php echo round($personalCompletion); ?>% Done</span>
                                    </div>
                                </div>

                                <!-- Business Profile Completion -->
                                <div class="mb-6">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-sm font-semibold text-gray-700">Business Profile</span>
                                        <span class="text-sm font-bold text-secondary"><?php echo round($businessCompletion); ?>%</span>
                                    </div>
                                    <div class="w-full h-2 mb-2 overflow-hidden bg-gray-200 rounded-full">
                                        <div class="h-full transition-all duration-300 bg-secondary" style="width: <?php echo $businessCompletion; ?>%"></div>
                                    </div>
                                    <div class="flex justify-between text-xs text-gray-500">
                                        <span><?php echo $businessCompleted; ?> of <?php echo $totalBusinessItems; ?> completed</span>
                                        <span><?php echo round($businessCompletion); ?>% Done</span>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="mb-6 space-y-3">
                                    <a href="?page=complete-employer-profile"
                                        class="flex items-center justify-center w-full px-4 py-3 text-sm font-medium transition-all duration-200 border-2 rounded-lg text-primary border-primary hover:bg-primary hover:text-white">
                                        
                                        Complete Profile
                                    </a>

                                    <?php if ($canPostJobs): ?>
                                        <a href="?page=post-job"
                                            class="flex items-center justify-center w-full px-4 py-3 text-sm font-medium text-white transition-all duration-200 rounded-lg bg-primary hover:bg-blue-700">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                            </svg>
                                            Post New Job
                                        </a>
                                    <?php else: ?>
                                        <button disabled class="flex items-center justify-center w-full px-4 py-3 text-sm font-medium text-gray-500 bg-gray-300 rounded-lg cursor-not-allowed">
                                            Complete Profile to Post Jobs
                                        </button>
                                    <?php endif; ?>
                                </div>

                                <!-- Profile Details -->
                                <div class="mb-6">
                                    <h2 class="mb-3 text-lg font-semibold text-primary">Contact Details</h2>
                                    <div class="space-y-4">
                                        <!-- Email -->
                                        <div>
                                            <div class="mb-1 text-xs font-medium text-gray-500">Email</div>
                                            <div class="text-sm text-gray-900"><?php echo htmlspecialchars($_SESSION['email'] ?? 'N/A'); ?></div>
                                        </div>

                                        <!-- Phone -->
                                        <?php if (!empty($employer['contact_no'])): ?>
                                            <div>
                                                <div class="mb-1 text-xs font-medium text-gray-500">Phone</div>
                                                <div class="text-sm text-gray-900"><?php echo htmlspecialchars($employer['contact_no']); ?></div>
                                            </div>
                                        <?php endif; ?>

                                        <!-- Business Industry -->
                                        <?php if (!empty($business['business_industry'])): ?>
                                            <div>
                                                <div class="mb-1 text-xs font-medium text-gray-500">Industry</div>
                                                <div class="text-sm text-gray-900"><?php echo htmlspecialchars($business['business_industry']); ?></div>
                                            </div>
                                        <?php endif; ?>

                                        <!-- Member Since -->
                                        <?php if (!empty($employer['created_at'])): ?>
                                            <div>
                                                <div class="mb-1 text-xs font-medium text-gray-500">Member Since</div>
                                                <div class="text-sm text-gray-900"><?php echo date('M Y', strtotime($employer['created_at'])); ?></div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Side - 2/3 Width -->
                <div class="w-full lg:w-2/3 lg:min-w-0 lg:flex-1">
                    <div class="space-y-6">

                        <!-- Business Profile Card -->
                        <div class="p-6 bg-white border border-gray-200 shadow rounded-xl">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold text-primary">Business Profile</h3>
                                <a href="?page=complete-employer-business&step=1" class="text-gray-400 hover:text-blue-700">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                    </svg>
                                </a>
                            </div>

                            <div class="flex items-center mb-6">
                                <!-- Business Logo -->
                                <div class="relative flex-shrink-0 mr-4">
                                    <img src="<?php
                                                if (!empty($business['business_logo'])) {
                                                    echo htmlspecialchars($business['business_logo']);
                                                } else {
                                                    $companyName = $business['business_name'] ?? $employer['company_name'] ?? 'Company';
                                                    echo 'https://ui-avatars.com/api/?name=' . urlencode($companyName) . '&background=1d4ed8&color=fff&size=80&format=svg&bold=true';
                                                }
                                                ?>"
                                        class="object-cover w-16 h-16 border-2 border-gray-100 rounded-lg shadow-sm" alt="Business Logo">


                                </div>

                                <!-- Business Info -->
                                <div class="flex-1">
                                    <h2 class="text-lg font-bold text-grayMain">
                                        <?php echo htmlspecialchars($business['business_name'] ?? 'Company Name'); ?>
                                    </h2>
                                    <?php if (!empty($business['business_industry'])): ?>
                                        <p class="text-xs text-gray-600"><?php echo htmlspecialchars($business['business_industry']); ?></p>
                                    <?php endif; ?>

                                    <!-- Status Badges -->
                                    <div class="flex flex-wrap gap-2 mt-2">
                                        <?php if ($isVerified): ?>
                                            <span class="inline-flex items-center px-2 py-1 text-xs bg-gray-100 text-primary">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                </svg>
                                                Verified
                                            </span>
                                        <?php endif; ?>

                                        <?php if (!empty($business['business_type'])): ?>
                                            <span class="inline-flex items-center px-2 py-1 text-xs bg-gray-100 text-primary">
                                                <?php echo htmlspecialchars($business['business_type']); ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Business Stats -->
                            <div class="flex items-center justify-between p-4 rounded-lg bg-gray-50">
                                <div class="flex-1 text-center">
                                    <div class="text-lg font-bold text-primary"><?php echo round($businessCompletion); ?>%</div>
                                    <div class="text-xs text-gray-500">Profile Complete</div>
                                </div>
                                <div class="flex-1 text-center">
                                    <div class="text-lg font-bold text-green-600"><?php echo $uploadedDocs; ?>/<?php echo count($documentTypes); ?></div>
                                    <div class="text-xs text-gray-500">Documents</div>
                                </div>
                                <div class="flex-1 text-center">
                                    <div class="text-lg font-bold text-secondary">0</div>
                                    <div class="text-xs text-gray-500">Active Jobs</div>
                                </div>
                            </div>

                        </div>

                        <!-- About Section -->
                        <div class="p-6 bg-white border border-gray-200 shadow rounded-xl">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold text-primary">
                                    About <?php echo !empty($business['business_name']) ? htmlspecialchars($business['business_name']) : 'Us'; ?>
                                </h3>
                                <a href="?page=complete-employer-business&step=1" class="text-gray-400 hover:text-blue-700">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                    </svg>
                                </a>
                            </div>
                            <p class="text-sm leading-relaxed text-gray-600">
                                <?php echo nl2br(htmlspecialchars($business['business_desc'] ?? 'Tell potential employees about your company, culture, and what makes you a great place to work.')); ?>
                            </p>
                        </div>

                        <!-- Business Information -->
                        <?php if ($business): ?>
                            <div class="p-6 bg-white border border-gray-200 shadow rounded-xl">
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="text-lg font-semibold text-primary">Business Information</h3>
                                    <a href="?page=complete-employer-business&step=2" class="text-gray-400 hover:text-blue-700">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                    </a>
                                </div>

                                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                    <?php if (!empty($business['business_type'])): ?>
                                        <div class="p-4 rounded-lg bg-gray-50">
                                            <div class="mb-1 text-xs text-gray-500">Organization Type</div>
                                            <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($business['business_type']); ?></div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (!empty($business['business_industry'])): ?>
                                        <div class="p-4 rounded-lg bg-gray-50">
                                            <div class="mb-1 text-xs text-gray-500">Industry</div>
                                            <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($business['business_industry']); ?></div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (!empty($business['business_team_size'])): ?>
                                        <div class="p-4 rounded-lg bg-gray-50">
                                            <div class="mb-1 text-xs text-gray-500">Team Size</div>
                                            <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($business['business_team_size']); ?> employees</div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (!empty($business['business_website'])): ?>
                                        <div class="p-4 rounded-lg bg-gray-50">
                                            <div class="mb-1 text-xs text-gray-500">Website</div>
                                            <a href="<?php echo htmlspecialchars($business['business_website']); ?>" target="_blank"
                                                class="text-sm font-medium text-blue-600 break-all hover:text-blue-800">
                                                <?php echo htmlspecialchars($business['business_website']); ?>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <?php if (!empty($business['business_address'])): ?>
                                    <div class="p-4 mt-4 rounded-lg bg-gray-50">
                                        <div class="mb-1 text-xs text-gray-500">Address</div>
                                        <div class="text-sm font-medium text-gray-900"><?php echo nl2br(htmlspecialchars($business['business_address'])); ?></div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <!-- Social Media -->
                        <?php if (!empty($socials)): ?>
                            <div class="p-6 bg-white border border-gray-200 shadow rounded-xl">
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="text-lg font-semibold text-primary">Social Media</h3>
                                    <a href="?page=complete-employer-business&step=3" class="text-gray-400 hover:text-blue-700">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                    </a>
                                </div>
                                <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
                                    <?php foreach ($socials as $platform => $url): ?>
                                        <?php if (!empty($url)): ?>
                                            <a href="<?php echo htmlspecialchars($url); ?>" target="_blank"
                                                class="flex items-center justify-center p-3 text-sm font-medium text-gray-700 transition-colors rounded-lg bg-gray-50 hover:bg-gray-100">
                                                <?php echo ucfirst($platform); ?>
                                            </a>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Documents Status -->
                        <div class="p-6 bg-white border border-gray-200 shadow rounded-xl">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold text-primary">
                                    Required Documents
                                    <span class="ml-2 text-sm text-gray-500">(<?php echo $uploadedDocs; ?>/<?php echo count($documentTypes); ?>)</span>
                                </h3>
                                <a href="?page=complete-employer-business&step=4" class="text-gray-400 hover:text-blue-700">

                                </a>
                            </div>

                            <div class="grid grid-cols-1 gap-3 md:grid-cols-2 lg:grid-cols-3">
                                <?php foreach ($documentTypes as $type => $label): ?>
                                    <div class="flex items-center justify-between p-3 rounded-lg <?php echo !empty($documents[$type]) ? 'bg-gray-50 border border-gray-200' : 'bg-gray-100 border-gray-400'; ?>">
                                        <div class="flex items-center">

                                            <div>
                                                <p class="text-sm font-medium text-primary">
                                                    <?php echo $label; ?>
                                                </p>
                                                <p class="text-xs <?php echo !empty($documents[$type]) ? 'text-gray-600' : 'text-gray-200'; ?>">
                                                    <?php echo !empty($documents[$type]) ? 'Uploaded' : 'Not uploaded'; ?>
                                                </p>
                                            </div>
                                        </div>

                                        <?php if (!empty($documents[$type])): ?>
                                            <div class="flex flex-col space-y-1 text-right">
                                                <a href="?page=download-employer-document&type=<?php echo $type; ?>&employer_id=<?php echo $employer['employer_id']; ?>"
                                                    target="_blank" class="text-xs text-secondary hover:text-secondary/80">View</a>
                                                <a href="?page=download-employer-document&type=<?php echo $type; ?>&employer_id=<?php echo $employer['employer_id']; ?>&download=1"
                                                    class="text-xs text-primary hover:text-primary/80">Download</a>
                                            </div>
                                        <?php else: ?>
                                            <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                            </svg>
                                        <?php endif; ?>

                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div>

                            <?php if ($uploadedDocs < count($documentTypes)): ?>
                                <div class="p-4 mt-4 border border-yellow-200 rounded-lg bg-yellow-50">
                                    <div class="flex">
                                        <svg class="w-5 h-5 text-yellow-600 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                        <div>
                                            <p class="text-sm font-medium text-yellow-800">Complete document upload to unlock job posting</p>
                                            <p class="mt-1 text-sm text-yellow-700">Upload <?php echo count($documentTypes) - $uploadedDocs; ?> more document(s) to complete your profile.</p>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Recent Activity -->
                        <div class="p-6 bg-white border border-gray-200 shadow rounded-xl">
                            <h3 class="mb-4 text-lg font-semibold text-primary">Recent Activity</h3>
                            <div class="space-y-3">
                                <div class="flex items-center p-3 rounded-lg bg-gray-50">
                                    <svg class="w-5 h-5 mr-3 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <div>
                                        <p class="text-sm font-medium text-gray-800">Profile created</p>
                                        <p class="text-xs text-gray-500"><?php echo date('M j, Y', strtotime($employer['created_at'] ?? 'now')); ?></p>
                                    </div>
                                </div>

                                <?php if ($isVerified): ?>
                                    <div class="flex items-center p-3 rounded-lg bg-yellow-50">
                                        <svg class="w-5 h-5 mr-3 text-secondary" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                        <div>
                                            <p class="text-sm font-medium text-gray-800">Profile verified</p>
                                            <p class="text-xs text-gray-500">You can now post jobs</p>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?php if ($businessCompletion >= 50): ?>
                                    <div class="flex items-center p-3 rounded-lg bg-blue-50">
                                        <svg class="w-5 h-5 mr-3 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <div>
                                            <p class="text-sm font-medium text-gray-800">Business profile updated</p>
                                            <p class="text-xs text-gray-500"><?php echo round($businessCompletion); ?>% completed</p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Profile photo upload function
    function handleProfilePhotoUpload(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];

            if (!file.type.startsWith('image/')) {
                showNotification('Please select an image file.', 'error');
                return;
            }

            if (file.size > 2 * 1024 * 1024) {
                showNotification('File size must be less than 2MB.', 'error');
                return;
            }

            const formData = new FormData();
            formData.append('profile_photo', file);

            const button = document.querySelector('button[title="Change profile photo"]');
            const originalContent = button.innerHTML;
            button.innerHTML = '<svg class="w-3 h-3 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
            button.disabled = true;

            fetch('?page=upload-employer-profile-photo', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const profileImg = document.querySelector('img[alt="Profile Photo"]');
                        profileImg.src = data.image_url + '?t=' + new Date().getTime();
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
                    button.innerHTML = originalContent;
                    button.disabled = false;
                    input.value = '';
                });
        }
    }

    function showNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 p-4 rounded-md shadow-lg z-50 transition-all duration-300 ${
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

        setTimeout(() => {
            if (notification.parentElement) {
                notification.remove();
            }
        }, 5000);
    }
</script>