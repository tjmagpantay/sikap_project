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
                                            alt="Profile Photo">


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
                                    <div class="text-lg font-bold text-secondary">
                                        <?php
                                        // Calculate real active jobs count (same logic as dashboard)
                                        $activeJobsCount = 0;

                                        // Get all jobs for this employer
                                        require_once __DIR__ . '/../../models/JobPost.php';
                                        $jobPostModel = new JobPost();
                                        $allEmployerJobs = $jobPostModel->getJobsByEmployer($employer['employer_id'] ?? 0);

                                        if (!empty($allEmployerJobs)) {
                                            foreach ($allEmployerJobs as $job) {
                                                // Check if job is truly active (open and not expired)
                                                $isExpired = false;
                                                if (!empty($job['application_deadline'])) {
                                                    $deadline = new DateTime($job['application_deadline']);
                                                    $now = new DateTime();
                                                    $isExpired = $deadline <= $now;
                                                }

                                                // Count only jobs that are open and not expired
                                                if ($job['job_status'] === 'open' && !$isExpired) {
                                                    $activeJobsCount++;
                                                }
                                            }
                                        }

                                        echo $activeJobsCount;
                                        ?>
                                    </div>
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
                                                <?php
                                                // Display appropriate icon based on platform
                                                switch ($platform) {
                                                    case 'facebook':
                                                        echo '<svg class="w-5 h-5 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                                                <path d="M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12v9.293h6.116c.73 0 1.323-.593 1.323-1.325v-21.35c0-.732-.593-1.325-1.325-1.325z" />
                                                              </svg>';
                                                        break;
                                                    case 'twitter':
                                                        echo '<svg class="w-5 h-5 mr-2 text-blue-400" fill="currentColor" viewBox="0 0 24 24">
                                                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                                                              </svg>';
                                                        break;
                                                    case 'instagram':
                                                        echo '<svg class="w-5 h-5 mr-2 text-pink-600" fill="currentColor" viewBox="0 0 24 24">
                                                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                                                              </svg>';
                                                        break;
                                                    case 'youtube':
                                                        echo '<svg class="w-5 h-5 mr-2 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                                                                <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                                                              </svg>';
                                                        break;
                                                    default:
                                                        // Generic social media icon for other platforms
                                                        echo '<svg class="w-5 h-5 mr-2 text-gray-600" fill="currentColor" viewBox="0 0 24 24">
                                                                <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                                                              </svg>';
                                                }
                                                ?>
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
                                                <a href="?page=view-employer-document&type=<?php echo $type; ?>&employer_id=<?php echo $employer['employer_id']; ?>"
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
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
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