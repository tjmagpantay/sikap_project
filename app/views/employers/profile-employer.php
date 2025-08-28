<?php
include_once __DIR__ . '/components/employer_auth_check.php';
include_once __DIR__ . '/../components/navbar-top.php';
include_once __DIR__ . '../components/navbar-employer.php';

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

    // Check for documents (count all 9 documents)
    $businessCompleted += $uploadedDocs;
}

$businessCompletion = ($businessCompleted / $totalBusinessItems) * 100;
?>

<div class="min-h-screen">
    <div class="py-8 mx-auto sm:px-2 md:px-4 lg:px-12 max-w-7xl">
        <div class="flex flex-col gap-8 md:flex-row">
            <!-- Sidebar - Personal Profile -->
            <div class="w-full md:w-1/3">
                <div class="p-6 bg-white border border-gray-200 shadow rounded-xl">
                    <div class="flex flex-col items-center">
                        <!-- Profile Section with Photo and Info Side by Side -->
                        <div class="flex items-center w-full mb-6">
                            <!-- Personal Profile Photo -->
                            <div class="relative mr-4 group">
                                <img src="<?php
                                            // Display personal profile photo or generate avatar from name
                                            if (!empty($employer['profile_picture'])) {
                                                echo htmlspecialchars('/sikap/public/' . $employer['profile_picture']);
                                            } else {
                                                $fullName = trim(($employer['first_name'] ?? '') . ' ' . ($employer['last_name'] ?? ''));
                                                if (empty($fullName)) $fullName = 'User';
                                                echo 'https://ui-avatars.com/api/?name=' . urlencode($fullName) . '&background=1d4ed8&color=fff&size=80&format=svg&bold=true';
                                            }
                                            ?>"
                                    class="object-cover w-20 h-20 border-4 border-white rounded-full shadow-lg" alt="Profile Photo">

                                <!-- Edit button -->
                                <button class="absolute flex items-center justify-center text-white transition-all duration-200 border-2 border-white rounded-full shadow-lg w-7 h-7 bg-primary -top-1 -right-1 hover:bg-primary-dark hover:shadow-xl group-hover:scale-110"
                                    onclick="document.getElementById('profile-photo-input').click()"
                                    title="Change profile photo">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 5a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V7a2 2 0 00-2-2h-1.586a1 1 0 01-.707-.293l-1.121-1.121A2 2 0 0011.172 3H8.828a2 2 0 00-1.414.586L6.293 4.707A1 1 0 015.586 5H4zm6 9a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path>
                                    </svg>
                                </button>

                                <!-- Hidden file input for profile photo upload -->
                                <input type="file" id="profile-photo-input" accept="image/*" class="hidden" onchange="handleProfilePhotoUpload(this)">
                            </div>

                            <!-- Personal Info -->
                            <div class="flex-1">
                                <h2 class="text-xl font-bold text-gray-900">
                                    <?php echo htmlspecialchars(trim(($employer['first_name'] ?? '') . ' ' . ($employer['last_name'] ?? ''))); ?>
                                </h2>
                                <?php if (!empty($employer['position'])): ?>
                                    <p class="text-sm font-medium text-primary"><?php echo htmlspecialchars($employer['position']); ?></p>
                                <?php endif; ?>

                                <?php if (!empty($business['business_name'])): ?>
                                    <p class="text-xs text-gray-500">at <?php echo htmlspecialchars($business['business_name']); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Profile Completion Progress -->
                        <div class="w-full mb-6">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-gray-700">Profile Completion</span>
                                <span class="text-sm font-bold text-primary"><?php echo round($personalCompletion); ?>%</span>
                            </div>
                            <div class="w-full h-2 bg-gray-200 rounded-full">
                                <div class="h-2 transition-all duration-300 bg-primary" style="width: <?php echo $personalCompletion; ?>%"></div>
                            </div>
                            <div class="flex items-center justify-between mt-1">
                                <p class="text-xs text-gray-500">
                                    <?php echo $personalCompleted; ?>/<?php echo count($personalFields); ?> fields completed
                                </p>
                                <?php if ($personalCompletion < 100): ?>
                                    <a href="?page=employer-personal-profile" class="text-xs text-primary hover:text-blue-700">Complete</a>
                                <?php else: ?>
                                    <span class="text-xs text-green-600">✓ Complete</span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Business Profile Completion -->
                        <div class="w-full mt-6">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-gray-700">Business Profile Completion</span>
                                <span class="text-sm font-bold text-orange-600"><?php echo round($businessCompletion); ?>%</span>
                            </div>
                            <div class="w-full h-2 bg-gray-200 rounded-full">
                                <div class="h-2 transition-all duration-300 bg-secondary" style="width: <?php echo $businessCompletion; ?>%"></div>
                            </div>
                            <div class="flex items-center justify-between mt-1">
                                <p class="text-xs text-gray-500">
                                    <?php echo $businessCompleted; ?> of <?php echo $totalBusinessItems; ?> completed
                                </p>
                                <?php if ($businessCompletion < 100): ?>
                                    <a href="?page=complete-employer-business&step=1" class="text-xs text-orange-600 hover:text-orange-700">Complete</a>
                                <?php else: ?>
                                    <span class="text-xs text-green-600">✓ Complete</span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Contact Info -->
                        <?php if (!empty($employer['contact_no'])): ?>
                            <div class="w-full mt-6">
                                <h4 class="mb-3 text-sm font-semibold text-gray-800">Contact</h4>

                                <!-- Email -->
                                <div class="flex items-center space-x-3 text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M16.5 4.5h-9A2.5 2.5 0 005 7v10a2.5 2.5 0 002.5 2.5h9A2.5 2.5 0 0019 17V7a2.5 2.5 0 00-2.5-2.5z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M5.5 7l6.5 5 6.5-5" />
                                    </svg>
                                    <span><?php echo htmlspecialchars($_SESSION['email'] ?? 'N/A'); ?></span>
                                </div>

                                <!-- Phone -->
                                <div class="flex items-center mt-2 space-x-3 text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M2 5.5A2.5 2.5 0 014.5 3h2a1 1 0 011 1v3a1 1 0 01-.27.69l-1.29 1.29a14.5 14.5 0 006.58 6.58l1.29-1.29A1 1 0 0114 13.5h3a1 1 0 011 1v2A2.5 2.5 0 0115.5 19h-1A17.5 17.5 0 012 5.5v0z" />
                                    </svg>
                                    <span><?php echo htmlspecialchars($employer['contact_no']); ?></span>
                                </div>
                            </div>
                        <?php endif; ?>


                        <!-- Action Buttons -->
                        <div class="w-full mt-6 space-y-3">
                            <!-- Profile Setup -->
                            <a href="?page=complete-employer-profile" class="flex items-center justify-center w-full px-4 py-3 text-sm font-medium transition-colors bg-white border-2 border-gray-200 rounded-lg text-primary hover:bg-primary focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">

                                Profile and Busines Setup
                            </a>

                            <!-- Quick Actions -->
                            <?php if ($canPostJobs): ?>
                                <a href="?page=post-job" class="flex items-center justify-center w-full px-4 py-3 text-sm font-medium text-white transition-colors rounded-lg bg-primary hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">

                                    Post New Job
                                </a>
                            <?php else: ?>
                                <button disabled class="flex items-center justify-center w-full px-4 py-3 text-sm font-medium text-gray-500 bg-gray-300 rounded-lg cursor-not-allowed">

                                    Complete Profile to Post Jobs
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="w-full space-y-8 md:w-2/3">
                <!-- Banner Section -->
                <?php if (!empty($business['banner_image'])): ?>
                    <div class="relative mb-4 overflow-hidden bg-white shadow rounded-xl ">
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
                <!-- Business Profile Card -->
                <div class="relative p-6 mb-4 bg-white border border-gray-200 shadow rounded-xl">
                    <!-- Edit Icon (top-right) -->
                    <a href="?page=complete-employer-business&step=1"
                        class="absolute text-gray-400 top-4 right-4 hover:text-blue-700">
                        <i class="fas fa-edit"></i>
                    </a>

                    <div class="flex items-center w-full">
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

                            <!-- Verification Badge -->
                            <?php if ($isVerified): ?>
                                <div class="absolute flex items-center justify-center w-5 h-5 bg-green-500 border-2 border-white rounded-full shadow-sm -bottom-1 -right-1">
                                    <svg class="w-2.5 h-2.5 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Business Details -->
                        <div class="flex flex-col justify-center flex-1">


                            <?php if (!empty($business['business_industry'])): ?>
                                <p class="text-xs font-medium text-gray-500 mt-0.5">
                                    <?php echo htmlspecialchars($business['business_industry']); ?>
                                </p>
                            <?php endif; ?>

                            <?php if (!empty($business['business_type'])): ?>
                                <p class="text-xs text-gray-400 mt-0.5">
                                    <?php echo htmlspecialchars($business['business_type']); ?>
                                </p>
                            <?php endif; ?>

                            <!-- Status and Team Size -->
                            <div class="flex flex-wrap gap-2 mt-2">
                                <?php if ($isVerified): ?>
                                    <div class="flex items-center px-2 py-0.5 text-xs font-medium text-primary bg-blue-50 ">
                                        <svg class="w-2.5 h-2.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Verified
                                    </div>
                                <?php elseif ($verificationStatus['status'] === 'pending'): ?>
                                    <div class="flex items-center px-2 py-0.5 text-xs font-medium text-yellow-700 bg-yellow-50 rounded-full">
                                        <svg class="w-2.5 h-2.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3" />
                                        </svg>
                                        Pending
                                    </div>
                                <?php endif; ?>

                                <?php if (!empty($business['business_team_size'])): ?>
                                    <div class="flex items-center px-2 py-0.5 text-xs font-medium text-gray-500 bg-gray-50 rounded-full">
                                        <svg class="w-2.5 h-2.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5V9H2v11h5m10-9h5M2 11h5" />
                                        </svg>
                                        <?php echo htmlspecialchars($business['business_team_size']); ?> employees
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div> <!-- Business Stats -->
                    <div class="flex justify-between p-3 mt-4 rounded-lg bg-gray-50">
                        <div class="flex-1 text-center">
                            <div class="text-xl font-bold text-primary"><?php echo round($businessCompletion); ?>%</div>
                            <div class="text-xs text-gray-500">Profile Complete</div>
                        </div>
                        <div class="flex-1 text-center border-l border-gray-200">
                            <div class="text-xl font-bold text-green-600"><?php echo $uploadedDocs; ?>/<?php echo count($documentTypes); ?></div>
                            <div class="text-xs text-gray-500">Documents</div>
                        </div>
                        <div class="flex-1 text-center border-l border-gray-200">
                            <div class="text-xl font-bold text-secondary">0</div>
                            <div class="text-xs text-gray-500">Active Jobs</div>
                        </div>
                    </div>

                </div>

                <!-- About Section -->
                <div class="p-6 mb-4 bg-white border border-gray-200 shadow rounded-xl">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="flex items-center font-semibold text-primary text-md">
                            About <?php echo !empty($business['business_name']) ? htmlspecialchars($business['business_name']) : 'Us'; ?>
                        </h3>
                        <a href="?page=complete-employer-business&step=1" class="text-gray-400 hover:text-blue-700">
                            <i class="fas fa-edit"></i>
                        </a>
                    </div>
                    <p class="text-sm leading-relaxed text-gray-600 break-words">
                        <?php echo nl2br(htmlspecialchars($business['business_desc'] ?? $employer['about_us'] ?? '')); ?>
                    </p>
                </div>

                <!-- Business Information -->
                <?php if ($business): ?>
                    <div class="p-6 mb-4 bg-white border border-gray-200 shadow rounded-xl">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="flex items-center font-semibold text-primary text-md">
                                Business Information
                            </h3>
                            <a href="?page=complete-employer-business&step=2" class="text-gray-400 hover:text-blue-700">
                                <i class="fas fa-edit"></i>
                            </a>
                        </div>
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-2">
                            <?php if (!empty($business['business_type'])): ?>
                                <div class="flex items-center p-3 rounded-lg bg-gray-50">

                                    <div>
                                        <p class="text-xs text-gray-500">Organization Type</p>
                                        <p class="text-sm font-medium text-gray-800"><?php echo htmlspecialchars($business['business_type']); ?></p>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($business['business_industry'])): ?>
                                <div class="flex items-center p-3 rounded-lg bg-gray-50">

                                    <div>
                                        <p class="text-xs text-gray-500">Industry</p>
                                        <p class="text-sm font-medium text-gray-800"><?php echo htmlspecialchars($business['business_industry']); ?></p>
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

                                    <div>
                                        <p class="text-xs text-gray-500">Established</p>
                                        <p class="text-sm font-medium text-gray-800"><?php echo date('Y', strtotime($business['business_established_year'])); ?></p>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($business['business_website'])): ?>
                                <div class="flex items-center p-3 rounded-lg bg-gray-50">

                                    <div>
                                        <p class="text-xs text-gray-500">Website</p>
                                        <a href="<?php echo htmlspecialchars($business['business_website']); ?>" target="_blank"
                                            class="text-sm font-medium text-blue-600 break-all hover:text-blue-700">
                                            <?php echo htmlspecialchars($business['business_website']); ?>
                                        </a>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($business['business_contact'])): ?>
                                <div class="flex items-center p-3 rounded-lg bg-gray-50">

                                    <div>
                                        <p class="text-xs text-gray-500">Business Contact</p>
                                        <p class="text-sm font-medium text-gray-800"><?php echo htmlspecialchars($business['business_contact']); ?></p>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                        <?php if (!empty($business['business_address'])): ?>
                            <div class="p-3 mt-4 rounded-lg bg-gray-50">
                                <div class="flex items-start">

                                    <div>
                                        <p class="text-xs text-gray-500">Address</p>
                                        <p class="text-sm font-medium text-gray-800 break-words"><?php echo nl2br(htmlspecialchars($business['business_address'])); ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <!-- Social Media -->
                <?php if (!empty($socials)): ?>
                    <div class="p-6 mb-4 bg-white border border-gray-200 shadow rounded-xl">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="flex items-center font-semibold text-primary text-md">

                                Social Media
                            </h3>
                            <a href="?page=complete-employer-business&step=3" class="text-gray-400 hover:text-blue-700">
                                <i class="fas fa-edit"></i>
                            </a>
                        </div>
                        <div class="grid grid-cols-2 gap-6 md:grid-cols-4">
                            <?php foreach ($socials as $platform => $url): ?>
                                <?php if (!empty($url)): ?>
                                    <a href="<?php echo htmlspecialchars($url); ?>" target="_blank"
                                        class="flex items-center justify-center p-4 break-all transition-colors rounded-lg bg-gray-50 hover:bg-gray-100">
                                        <span class="text-sm font-medium text-gray-800 capitalize"><?php echo $platform; ?></span>
                                    </a>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Documents Status -->
                <div class="p-6 mb-4 bg-white border border-gray-200 shadow rounded-xl">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="flex items-center font-semibold text-primary text-md">
                           
                            Required Documents
                            <span class="ml-2 text-sm text-gray-500">(<?php echo $uploadedDocs; ?>/<?php echo count($documentTypes); ?>)</span>
                        </h3>
                        <a href="?page=complete-employer-business&step=4" class="text-gray-400 hover:text-blue-700">
                            <i class="fas fa-upload"></i>
                        </a>
                    </div>
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                        <?php foreach ($documentTypes as $type => $label): ?>
                            <div class="flex items-center justify-between p-3 border rounded-lg <?php echo !empty($documents[$type]) ? 'bg-blue-50' : 'border-gray-200 bg-gray-50'; ?>">
                                <div class="flex items-center">
                                    <i class="fas fa-file-pdf <?php echo !empty($documents[$type]) ? 'text-green-600' : 'text-gray-400'; ?> mr-3"></i>
                                    <div>
                                        <p class="text-sm font-medium <?php echo !empty($documents[$type]) ? 'text-primary' : 'text-gray-600'; ?>">
                                            <?php echo $label; ?>
                                        </p>
                                        <?php if (!empty($documents[$type])): ?>
                                            <p class="text-xs text-primary">Uploaded</p>
                                        <?php else: ?>
                                            <p class="text-xs text-gray-500">Not uploaded</p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2 space-x-2">
                                    <?php if (!empty($documents[$type])): ?>
                                        <!-- NEW: Secure document links -->
                                        <a href="?page=download-employer-document&type=<?php echo $type; ?>&employer_id=<?php echo $employer['employer_id']; ?>" target="_blank"
                                            class="text-xs text-primary  title=" View Document">
                                            View
                                        </a>
                                        <a href="?page=download-employer-document&type=<?php echo $type; ?>&employer_id=<?php echo $employer['employer_id']; ?>&download=1"
                                            class="text-xs text-secondary  title=" Download Document">
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
                <div class="p-6 mb-4 bg-white border border-gray-200 shadow rounded-xl">
                    <h3 class="flex items-center mb-4 text-lg font-semibold text-gray-800">
                     
                        Recent Activity
                    </h3>
                    <div class="space-y-3">
                        <div class="flex items-center p-3 rounded-lg bg-gray-50">
                           
                            <div>
                                <p class="text-sm font-medium text-gray-800">Profile created</p>
                                <p class="text-xs text-gray-500"><?php echo date('M j, Y', strtotime($employer['created_at'] ?? 'now')); ?></p>
                            </div>
                        </div>

                        <?php if ($isVerified): ?>
                            <div class="flex items-center p-3 rounded-lg bg-yellow-50">
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