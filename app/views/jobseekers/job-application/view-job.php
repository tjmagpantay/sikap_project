<?php
include_once __DIR__ . '/../components/jobseeker_auth_check.php';
include_once __DIR__ . '/../../components/navbar-top.php';
include_once __DIR__ . '/../navbar-jobseeker.php'; ?>

<div class="min-h-screen ">
    <div class="px-6 py-8">
        <div class="mx-auto max-w-7xl">

            <!-- Breadcrumbs -->
            <nav class="mb-6">
                <div class="flex items-center space-x-2 text-sm">
                    <a href="?page=jobseeker-dashboard" class="text-gray-500 transition-colors hover:text-primary">
                        Dashboard
                    </a>
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    <a href="?page=browse-jobs" class="text-gray-500 transition-colors hover:text-primary">
                        Browse Jobs
                    </a>
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    <span class="font-medium text-primary"><?php echo htmlspecialchars($job['job_title'] ?? 'Job Details'); ?></span>
                </div>
            </nav>

            <!-- Main Flex Layout -->
            <div class="flex flex-col gap-6 lg:flex-row lg:gap-8">
                <!-- Left Section - Main Content -->
                <div class="w-full space-y-6 lg:w-8/12">
                    <!-- Job Details Card -->
                    <div class="overflow-hidden bg-white border border-gray-200 shadow-sm rounded-xl">
                        <!-- Job Header -->
                        <div class="p-4 border-b border-gray-200 sm:p-6 bg-gray-50">
                            <div class="flex items-start justify-between mb-2">
                                <div class="flex items-start gap-3 sm:gap-3">
                                    <!-- Business Logo -->
                                    <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 overflow-hidden border-2 border-gray-200 rounded-lg sm:w-16 sm:h-16">
                                        <?php if (!empty($job['business_logo'])): ?>
                                            <img src="<?php echo htmlspecialchars($job['business_logo']); ?>" alt="Company Logo"
                                                class="object-cover w-full h-full">
                                        <?php else: ?>
                                            <i class="text-xl text-gray-500 sm:text-2xl fas fa-building"></i>
                                        <?php endif; ?>
                                    </div>

                                    <div>
                                        <h1 class="text-lg font-semibold text-gray-900 sm:text-xl"><?php echo htmlspecialchars($job['job_title']); ?></h1>

                                        <?php
                                        $companyName = '';
                                        if (!empty($job['company_name'])) {
                                            $companyName = $job['company_name'];
                                        } elseif (!empty($job['business_name'])) {
                                            $companyName = $job['business_name'];
                                        } elseif (isset($job['employer_first_name']) && isset($job['employer_last_name'])) {
                                            $companyName = trim($job['employer_first_name'] . ' ' . $job['employer_last_name']);
                                        } else {
                                            $companyName = 'Company Name Not Available';
                                        }
                                        ?>
                                        <a href="?page=view-employer-profile&employer_id=<?php echo $job['employer_id']; ?>&job_id=<?php echo $job['job_id']; ?>&job_title=<?php echo urlencode($job['job_title']); ?>"
                                            class="mt-1 text-sm transition-colors text-primary hover:text-secondary hover:underline">
                                            <?php echo htmlspecialchars($companyName); ?>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Application Timeline Bar -->
                            <?php if (!empty($job['application_start']) || !empty($job['application_deadline'])): ?>
                                <div class="flex flex-row justify-between gap-6 p-3 mx-2 rounded-lg sm:p-4 sm:mx-4 bg-gray-50">
                                    <div class="text-start">
                                        <div class="text-xs text-gray-400">Days remaining</div>
                                        <div class="text-sm text-primary">
                                            <?php
                                            if (!empty($job['application_deadline'])) {
                                                $deadline = new DateTime($job['application_deadline']);
                                                $now = new DateTime();
                                                if ($deadline > $now) {
                                                    echo $now->diff($deadline)->days;
                                                } else {
                                                    echo '0';
                                                }
                                            } else {
                                                echo '∞';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="text-start">
                                        <div class="text-xs text-gray-400">Application Start</div>
                                        <div class="text-sm text-primary">
                                            <?php echo $job['application_start'] ? date('M j, Y', strtotime($job['application_start'])) : 'Immediately'; ?>
                                        </div>
                                    </div>
                                    <div class="text-start">
                                        <div class="text-xs text-gray-400">Application End</div>
                                        <div class="text-sm text-primary">
                                            <?php echo $job['application_deadline'] ? date('M j, Y', strtotime($job['application_deadline'])) : 'No deadline'; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>

                        </div>

                        <!-- Main Content -->
                        <div class="p-4 sm:p-6">
                            <!-- Job Summary -->
                            <div class="mb-8">
                                <h2 class="mb-1 font-semibold text-primary text-md">Job Summary</h2>
                                <p class="text-sm font-light text-gray-600"><?php echo nl2br(htmlspecialchars($job['job_summary'] ?? 'No job description available.')); ?></p>
                            </div>

                            <!-- Skills Required -->
                            <?php if (!empty($job['skills']) && is_array($job['skills'])): ?>
                                <div class="mb-8">
                                    <h2 class="mb-1 font-semibold text-primary text-md">Skills Required</h2>
                                    <div class="flex flex-wrap gap-2">
                                        <?php foreach (array_unique($job['skills']) as $skill): ?>
                                            <span class="px-3 py-1 text-sm font-light text-gray-600 bg-gray-100 rounded-sm">
                                                <?php echo htmlspecialchars($skill); ?>
                                            </span>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Basic Information -->
                            <div class="mb-8">
                                <h2 class="mb-1 font-semibold text-primary text-md">Basic Information</h2>
                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                    <div>
                                        <div class="text-xs text-gray-400">Category</div>
                                        <div class="text-sm text-primary"><?php echo htmlspecialchars($job['category_name'] ?? 'N/A'); ?></div>
                                    </div>
                                    <div>
                                        <div class="text-xs text-gray-400">Employment Type</div>
                                        <div class="text-sm text-primary"><?php echo ucfirst(str_replace('-', ' ', $job['job_type'] ?? 'Not specified')); ?></div>
                                    </div>
                                    <div>
                                        <div class="text-xs text-gray-400">Location</div>
                                        <div class="text-sm text-primary"><?php echo htmlspecialchars($job['location'] ?? 'Not specified'); ?></div>
                                    </div>
                                    <div>
                                        <div class="text-xs text-gray-400">Workplace</div>
                                        <div class="text-sm text-primary"><?php echo ucfirst($job['workplace_option'] ?? 'Onsite'); ?></div>
                                    </div>
                                    <?php if ($job['show_pay'] && (!empty($job['salary']) || !empty($job['pay_range']))): ?>
                                        <div>
                                            <div class="text-xs text-gray-400">Salary Range</div>
                                            <div class="text-sm text-primary">
                                                <?php
                                                if (!empty($job['pay_range'])) {
                                                    echo htmlspecialchars($job['pay_range']);
                                                } elseif (!empty($job['salary'])) {
                                                    echo '₱' . number_format($job['salary'], 2);
                                                    if ($job['pay_type']) echo ' / ' . $job['pay_type'];
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="text-xs text-gray-400">Pay Type</div>
                                            <div class="text-sm text-primary"><?php echo ucfirst($job['pay_type'] ?? 'Monthly'); ?></div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Full Description -->
                            <?php if (!empty($job['full_description']) && $job['full_description'] !== $job['job_summary']): ?>
                                <div class="mb-8">
                                    <h2 class="mb-1 font-semibold text-primary text-md">Full Description</h2>
                                    <div class="text-sm font-light text-gray-600">
                                        <?php echo nl2br(htmlspecialchars($job['full_description'])); ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Requirements -->
                            <?php if (!empty($job['requirements'])): ?>
                                <div class="mb-8">
                                    <h2 class="mb-1 font-semibold text-primary text-md">Requirements</h2>
                                    <div class="text-sm font-light text-gray-600">
                                        <?php echo nl2br(htmlspecialchars($job['requirements'])); ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Responsibilities -->
                            <?php if (!empty($job['responsibilities'])): ?>
                                <div class="mb-8">
                                    <h2 class="mb-1 font-semibold text-primary text-md">Responsibilities</h2>
                                    <div class="text-sm font-light text-gray-600">
                                        <?php echo nl2br(htmlspecialchars($job['responsibilities'])); ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Company Information (if available) -->
                            <?php if (!empty($job['business_address']) || !empty($job['business_description'])): ?>
                                <div class="mb-8">
                                    <h2 class="mb-1 font-semibold text-primary text-md">Company Information</h2>
                                    <div class="space-y-3">
                                        <?php if (!empty($job['business_address'])): ?>
                                            <div>
                                                <div class="text-xs text-gray-400">Company Address</div>
                                                <div class="text-sm text-primary"><?php echo htmlspecialchars($job['business_address']); ?></div>
                                            </div>
                                        <?php endif; ?>

                                        <?php if (!empty($job['business_description'])): ?>
                                            <div>
                                                <div class="text-xs text-gray-400">About the Company</div>
                                                <div class="text-sm font-light text-gray-600">
                                                    <?php echo nl2br(htmlspecialchars($job['business_description'])); ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Job Attachments -->
                            <?php if (!empty($job['attachments'])): ?>
                                <div class="mb-8">
                                    <h2 class="mb-1 font-semibold text-primary text-md">Job Attachments</h2>
                                    <div class="space-y-3">
                                        <?php foreach ($job['attachments'] as $attachment): ?>
                                            <?php
                                            // Extract file extension for each attachment
                                            $file_extension = strtolower(pathinfo($attachment['file_path'], PATHINFO_EXTENSION));

                                            // Define icon path based on file extension
                                            $icon_path = match ($file_extension) {
                                                'pdf' => '/sikap/public/assets/icons/pdf-icon.png',
                                                'doc', 'docx' => '/sikap/public/assets/icons/word-icon.png',
                                                'jpg', 'jpeg', 'png', 'gif' => '/sikap/public/assets/icons/image-icon.png',
                                                'zip', 'rar' => '/sikap/public/assets/icons/archive-icon.png',
                                                'txt' => '/sikap/public/assets/icons/text-icon.png',
                                                'xls', 'xlsx' => '/sikap/public/assets/icons/excel-icon.png',
                                                'ppt', 'pptx' => '/sikap/public/assets/icons/powerpoint-icon.png',
                                                default => '/sikap/public/assets/icons/file-icon.png'
                                            };
                                            ?>
                                            <div class="flex items-center justify-between p-4 transition-colors border border-gray-200 rounded-lg bg-gray-50 hover:bg-gray-100">
                                                <div class="flex items-center">
                                                    <div class="flex items-center justify-center w-12 h-12 mr-3 overflow-hidden bg-red-100 rounded-lg">
                                                        <img src="<?php echo $icon_path; ?>"
                                                            alt="<?php echo strtoupper($file_extension); ?> Icon"
                                                            class="object-cover w-8 h-8"
                                                            onerror="this.src='/sikap/public/assets/icons/file-icon.png'" />
                                                    </div>
                                                    <div>
                                                        <div class="text-sm font-medium text-gray-900">
                                                            <?php echo htmlspecialchars(basename($attachment['file_path'])); ?>
                                                        </div>
                                                        <div class="text-xs text-gray-500">
                                                            <?php
                                                            echo match ($file_extension) {
                                                                'pdf' => 'PDF Document',
                                                                'doc' => 'Word Document',
                                                                'docx' => 'Word Document',
                                                                'xls' => 'Excel Spreadsheet',
                                                                'xlsx' => 'Excel Spreadsheet',
                                                                'ppt' => 'PowerPoint Presentation',
                                                                'pptx' => 'PowerPoint Presentation',
                                                                'txt' => 'Text Document',
                                                                'jpg', 'jpeg', 'png', 'gif' => 'Image File',
                                                                'zip', 'rar' => 'Archive File',
                                                                default => strtoupper($file_extension) . ' File'
                                                            };
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="flex gap-2">
                                                    <!-- View/Preview Button (for PDFs and images) -->
                                                    <?php if (in_array($file_extension, ['pdf', 'jpg', 'jpeg', 'png', 'gif'])): ?>
                                                        <a href="?page=view-job-attachment&file_path=<?php echo urlencode($attachment['file_path']); ?><?php echo isset($attachment['attachment_id']) ? '&attachment_id=' . $attachment['attachment_id'] : ''; ?>"
                                                            target="_blank"
                                                            class="flex items-center px-3 py-2 text-sm font-medium transition-colors rounded-lg text-primary bg-blue-50 hover:bg-blue-100">
                                                            <i class="mr-2 fas fa-eye"></i>
                                                            View
                                                        </a>
                                                    <?php endif; ?>

                                                    <!-- Download Button -->
                                                    <a href="?page=download-job-attachment&file_path=<?php echo urlencode($attachment['file_path']); ?><?php echo isset($attachment['attachment_id']) ? '&attachment_id=' . $attachment['attachment_id'] : ''; ?>"
                                                        class="flex items-center px-3 py-2 text-sm font-medium transition-colors rounded-lg text-primary bg-blue-50 hover:bg-blue-100">
                                                        <i class="mr-2 fas fa-download"></i>
                                                        Download
                                                    </a>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>

                <!-- Right Section - Sidebar -->
                <div class="w-full lg:w-4/12">
                    <!-- Single Sidebar Card -->
                    <div class="p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-6">
                        <!-- Application Status -->
                        <div class="mb-6 sm:mb-8">
                            <h3 class="mb-4 text-lg font-semibold text-gray-900 sm:text-xl">Application Status</h3>

                            <?php if (!isset($_SESSION['user_id'])): ?>
                                <div class="p-4 mb-4 border border-blue-200 rounded-lg bg-blue-50">
                                    <div class="flex items-center">
                                        <i class="mr-3 text-blue-500 fas fa-info-circle"></i>
                                        <div>
                                            <p class="text-sm font-medium text-blue-800">Sign in required</p>
                                            <p class="text-xs text-blue-600">Create an account or sign in to apply</p>
                                        </div>
                                    </div>
                                </div>
                                <a href="?page=login-jobseeker"
                                    class="flex items-center justify-center w-full px-4 py-3 text-sm font-medium text-white transition-colors rounded-md bg-primary hover:bg-secondary">
                                    <i class="mr-2 fas fa-sign-in-alt"></i> Sign in to Apply
                                </a>

                            <?php elseif (!isset($_SESSION['role']) || $_SESSION['role'] != User::ROLE_JOBSEEKER): ?>
                                <div class="p-4 border border-gray-200 rounded-lg bg-gray-50">
                                    <div class="flex items-center justify-center">
                                        <i class="mr-2 text-gray-400 fas fa-user-times"></i>
                                        <p class="text-sm text-gray-600">Only job seekers can apply</p>
                                    </div>
                                </div>

                            <?php elseif (!empty($incompleteApplication)): ?>
                                <!-- Incomplete Application - Show Detailed Progress -->
                                <div class="p-4 mb-4 border border-orange-200 rounded-lg bg-orange-50">
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="flex items-center">
                                            <i class="mr-3 text-2xl text-orange-500 fas fa-clock"></i>
                                            <div>
                                                <p class="text-sm font-medium text-orange-700">Application in Progress</p>
                                                <p class="text-xs text-orange-600">
                                                    Step <?php echo $incompleteApplication['current_step']; ?> of 4 completed
                                                </p>
                                            </div>
                                        </div>
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-700 border border-orange-200">
                                            <?php echo round(($incompleteApplication['current_step'] / 4) * 100); ?>% Complete
                                        </span>
                                    </div>

                                    <!-- Progress Steps -->
                                    <div class="mb-4">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="text-xs font-medium text-orange-700">Application Progress</span>
                                            <span class="text-xs text-orange-600">Step <?php echo $incompleteApplication['current_step']; ?> of 4</span>
                                        </div>

                                        <!-- Progress Bar -->
                                        <div class="w-full h-2 bg-orange-200 rounded-full">
                                            <div class="h-2 transition-all duration-300 bg-orange-500 rounded-full"
                                                style="width: <?php echo ($incompleteApplication['current_step'] / 4) * 100; ?>%"></div>
                                        </div>

                                        <!-- Step Labels -->
                                        <div class="flex justify-between mt-2 text-xs">
                                            <span class="<?php echo $incompleteApplication['current_step'] >= 1 ? 'text-orange-700 font-medium' : 'text-orange-400'; ?>">
                                                Documents
                                            </span>
                                            <span class="<?php echo $incompleteApplication['current_step'] >= 2 ? 'text-orange-700 font-medium' : 'text-orange-400'; ?>">
                                                Questions
                                            </span>
                                            <span class="<?php echo $incompleteApplication['current_step'] >= 3 ? 'text-orange-700 font-medium' : 'text-orange-400'; ?>">
                                                Eligibility
                                            </span>
                                            <span class="<?php echo $incompleteApplication['current_step'] >= 4 ? 'text-orange-700 font-medium' : 'text-orange-400'; ?>">
                                                Review
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Current Step Info -->
                                    <div class="p-3 mb-3 bg-orange-100 border border-orange-300 rounded-md">
                                        <div class="flex items-start">
                                            <div class="flex items-center justify-center w-6 h-6 mr-3 bg-orange-500 rounded-full">
                                                <span class="text-xs font-bold text-white"><?php echo $incompleteApplication['current_step']; ?></span>
                                            </div>
                                            <div class="flex-1">
                                                <?php
                                                switch ($incompleteApplication['current_step']) {
                                                    case 1:
                                                        echo '<p class="text-sm font-medium text-orange-800">Step 1: Documents & Personal Info</p>';
                                                        echo '<p class="mt-1 text-xs text-orange-700">Upload your resume/CV and complete personal information.</p>';
                                                        break;
                                                    case 2:
                                                        echo '<p class="text-sm font-medium text-orange-800">Step 2: Screening Questions</p>';
                                                        echo '<p class="mt-1 text-xs text-orange-700">Answer employer screening questions for this position.</p>';
                                                        break;
                                                    case 3:
                                                        echo '<p class="text-sm font-medium text-orange-800">Step 3: Eligibility Information</p>';
                                                        echo '<p class="mt-1 text-xs text-orange-700">Provide eligibility details and program interests.</p>';
                                                        break;
                                                    case 4:
                                                        echo '<p class="text-sm font-medium text-orange-800">Step 4: Review & Submit</p>';
                                                        echo '<p class="mt-1 text-xs text-orange-700">Review your application and submit to employer.</p>';
                                                        break;
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Started Date -->
                                    <?php if (!empty($incompleteApplication['applied_at'])): ?>
                                        <p class="mb-3 text-xs text-orange-500">
                                            <i class="mr-1 fas fa-calendar-alt"></i>
                                            Started: <?php echo date('M j, Y g:i A', strtotime($incompleteApplication['applied_at'])); ?>
                                        </p>
                                    <?php endif; ?>

                                    <!-- Action Buttons -->
                                    <div class="flex gap-2">
                                        <a href="?page=apply-job&job_id=<?php echo $job['job_id']; ?>&application_id=<?php echo $incompleteApplication['application_id']; ?>&step=<?php echo $incompleteApplication['current_step']; ?>"
                                            class="flex items-center justify-center flex-1 px-4 py-3 text-sm font-medium text-white transition-colors bg-orange-500 rounded-md hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                                            <i class="mr-2 fas fa-play"></i>
                                            Continue Application
                                        </a>
                                        <a href="?page=my-applications#application-<?php echo $incompleteApplication['application_id']; ?>"
                                            class="flex items-center justify-center px-4 py-3 text-sm font-medium text-orange-600 transition-colors bg-orange-100 border border-orange-300 rounded-md hover:bg-orange-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                                            <i class="mr-2 fas fa-list"></i>
                                            View Details
                                        </a>
                                    </div>
                                </div>

                            <?php elseif ($hasApplied === true && !empty($applicationStatus)): ?>
                                <!-- Complete Application - Check this SECOND -->
                                <div class="p-4 mb-4 border border-green-200 rounded-lg bg-green-50">
                                    <div class="flex items-center">
                                        <i class="mr-3 text-2xl text-green-600 fas fa-check-circle"></i>
                                        <div>
                                            <p class="text-sm font-medium text-green-700">Application Submitted</p>
                                            <p class="text-xs text-green-600">
                                                Status:
                                                <?php
                                                // Display the actual application status
                                                switch ($applicationStatus) {
                                                    case 'pending':
                                                        echo '<span class="inline-flex items-center px-2 py-1 ml-2 text-xs font-medium text-yellow-700 bg-yellow-100 rounded-full">
                                                                <div class="w-2 h-2 mr-1 bg-yellow-500 rounded-full"></div>
                                                                Pending Review
                                                              </span>';
                                                        break;
                                                    case 'reviewed':
                                                        echo '<span class="inline-flex items-center px-2 py-1 ml-2 text-xs font-medium text-blue-700 bg-blue-100 rounded-full">
                                                                <div class="w-2 h-2 mr-1 bg-blue-500 rounded-full"></div>
                                                                Under Review
                                                              </span>';
                                                        break;
                                                    case 'shortlisted':
                                                        echo '<span class="inline-flex items-center px-2 py-1 ml-2 text-xs font-medium text-purple-700 bg-purple-100 rounded-full">
                                                                <div class="w-2 h-2 mr-1 bg-purple-500 rounded-full"></div>
                                                                Shortlisted
                                                              </span>';
                                                        break;
                                                    case 'hired':
                                                        echo '<span class="inline-flex items-center px-2 py-1 ml-2 text-xs font-medium text-green-700 bg-green-100 rounded-full">
                                                                <div class="w-2 h-2 mr-1 bg-green-500 rounded-full"></div>
                                                                Hired
                                                              </span>';
                                                        break;
                                                    case 'rejected':
                                                        echo '<span class="inline-flex items-center px-2 py-1 ml-2 text-xs font-medium text-red-700 bg-red-100 rounded-full">
                                                                <div class="w-2 h-2 mr-1 bg-red-500 rounded-full"></div>
                                                                Not Selected
                                                              </span>';
                                                        break;
                                                    default:
                                                        echo '<span class="inline-flex items-center px-2 py-1 ml-2 text-xs font-medium text-gray-700 bg-gray-100 rounded-full">
                                                                <div class="w-2 h-2 mr-1 bg-gray-500 rounded-full"></div>
                                                                ' . ucfirst($applicationStatus) . '
                                                              </span>';
                                                }
                                                ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Status-specific message -->
                                <?php if ($applicationStatus === 'pending'): ?>
                                    <div class="p-3 mb-4 border border-yellow-200 rounded-lg bg-yellow-50">
                                        <p class="text-sm text-yellow-800">
                                            <i class="mr-2 fas fa-hourglass-half"></i>
                                            Your application is being reviewed by the employer.
                                        </p>
                                    </div>
                                <?php elseif ($applicationStatus === 'reviewed'): ?>
                                    <div class="p-3 mb-4 border border-blue-200 rounded-lg bg-blue-50">
                                        <p class="text-sm text-blue-800">
                                            <i class="mr-2 fas fa-search"></i>
                                            Your application is currently under detailed review.
                                        </p>
                                    </div>
                                <?php elseif ($applicationStatus === 'shortlisted'): ?>
                                    <div class="p-3 mb-4 border border-purple-200 rounded-lg bg-purple-50">
                                        <p class="text-sm text-purple-800">
                                            <i class="mr-2 fas fa-star"></i>
                                            Congratulations! You've been shortlisted for this position.
                                        </p>
                                    </div>
                                <?php elseif ($applicationStatus === 'hired'): ?>
                                    <div class="p-3 mb-4 border border-green-200 rounded-lg bg-green-50">
                                        <p class="text-sm text-green-800">
                                            <i class="mr-2 fas fa-check-circle"></i>
                                            Congratulations! You've been hired for this position.
                                        </p>
                                    </div>
                                <?php elseif ($applicationStatus === 'rejected'): ?>
                                    <div class="p-3 mb-4 border border-red-200 rounded-lg bg-red-50">
                                        <p class="text-sm text-red-800">
                                            <i class="mr-2 fas fa-times-circle"></i>
                                            Thank you for your interest. Unfortunately, you were not selected for this position.
                                        </p>
                                    </div>
                                <?php endif; ?>

                                <a href="?page=my-applications"
                                    class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-green-600 transition-colors rounded-md hover:text-green-700 bg-green-50 hover:bg-green-100">
                                    <i class="mr-2 fas fa-list"></i>
                                    View My Applications
                                </a>

                            <?php elseif (isset($job['job_status']) && $job['job_status'] !== 'open'): ?>
                                <div class="p-4 border border-gray-200 rounded-lg bg-gray-50">
                                    <div class="flex items-center justify-center">
                                        <i class="mr-2 text-gray-400 fas fa-lock"></i>
                                        <div class="text-center">
                                            <p class="text-sm font-medium text-gray-600">Not Accepting Applications</p>
                                            <p class="text-xs text-gray-500">This position is currently <?php echo $job['job_status']; ?></p>
                                        </div>
                                    </div>
                                </div>

                            <?php elseif (!empty($job['application_deadline']) && strtotime($job['application_deadline']) < time()): ?>
                                <div class="p-4 border border-red-200 rounded-lg bg-red-50">
                                    <div class="flex items-center justify-center">
                                        <i class="mr-2 text-red-400 fas fa-hourglass-end"></i>
                                        <div class="text-center">
                                            <p class="text-sm font-medium text-red-700">Deadline Passed</p>
                                            <p class="text-xs text-red-600">Applications are no longer accepted</p>
                                        </div>
                                    </div>
                                </div>

                            <?php else: ?>
                                <!-- Ready to Apply -->
                                <div class="p-4 mb-4 border border-yellow-200 rounded-lg bg-yellow-50">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div>
                                                <p class="text-sm font-medium text-secondary">Ready to Apply</p>
                                                <p class="text-xs text-primary">Quick & secure process</p>
                                            </div>
                                        </div>
                                        <?php if (!empty($job['application_deadline'])): ?>
                                            <div class="text-right">
                                                <p class="text-xs font-medium text-secondary">Deadline</p>
                                                <p class="text-xs text-primary"><?php echo date('M j', strtotime($job['application_deadline'])); ?></p>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <a href="?page=apply-job&job_id=<?php echo $job['job_id']; ?>&step=1"
                                    class="flex items-center justify-center w-full px-4 py-3 text-sm font-medium text-white transition-colors rounded-md bg-primary hover:bg-secondary">
                                    <i class="mr-2 fas fa-paper-plane"></i>
                                    Apply for this Job
                                </a>
                            <?php endif; ?>
                        </div>

                        <!-- Job Information -->
                        <div class="mb-6 sm:mb-8">
                            <h3 class="mb-4 text-lg font-semibold text-gray-900">Job Information</h3>
                            <div class="space-y-4">
                                <div class="flex items-center justify-between p-3 rounded-md bg-gray-50">
                                    <span class="text-sm font-light text-gray-600">Posted:</span>
                                    <span class="text-sm font-medium text-primary"><?php echo date('M j, Y', strtotime($job['created_at'])); ?></span>
                                </div>

                                <?php if (!empty($job['application_deadline'])): ?>
                                    <div class="flex items-center justify-between p-3 rounded-md bg-gray-50">
                                        <span class="text-sm font-light text-gray-600">Deadline:</span>
                                        <span class="text-sm font-medium <?php echo (strtotime($job['application_deadline']) < time()) ? 'text-red-600' : 'text-primary'; ?>">
                                            <?php echo date('M j, Y', strtotime($job['application_deadline'])); ?>
                                        </span>
                                    </div>
                                <?php endif; ?>

                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="space-y-3">
                            <button onclick="window.print()"
                                class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-gray-700 transition-colors bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                <i class="mr-2 fas fa-print"></i>
                                Print Job Details
                            </button>

                            <button onclick="navigator.share ? navigator.share({title: '<?php echo htmlspecialchars($job['job_title']); ?>', url: window.location.href}) : alert('Share feature not supported')"
                                class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-gray-700 transition-colors bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                <i class="mr-2 fas fa-share"></i>
                                Share Job
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>