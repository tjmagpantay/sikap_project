<?php include_once __DIR__ . '/../../components/navbar-top.php';
include_once __DIR__ . '/../navbar-jobseeker.php'; ?>

<div class="min-h-screen bg-gray-50">
    <div class="px-4 py-8 sm:px-6 md:px-16 lg:px-24">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="?page=browse-jobs" class="inline-flex items-center text-sm font-medium text-primary hover:text-secondary">
                <i class="mr-2 fas fa-arrow-left"></i> Back to Jobs
            </a>
        </div>

        <!-- Main Flex Layout -->
        <div class="flex flex-col gap-8 md:flex-row">
            <!-- Left Section - Main Content (8/12 width) -->
            <div class="w-full space-y-6 md:w-8/12">
                <!-- Job Details Card -->
                <div class="overflow-hidden bg-white border border-gray-200 shadow-sm rounded-xl">
                    <!-- Job Header -->
                    <div class="p-6 border-b border-gray-200 bg-gray-50">
                        <div class="flex items-start justify-between mb-2">
                            <div class="flex items-start space-x-4">
                                <!-- Business Logo -->
                                <div class="flex items-center justify-center w-16 h-16 overflow-hidden border-2 border-gray-200 rounded-lg">
                                    <?php if (!empty($job['business_logo'])): ?>
                                        <img src="<?php echo htmlspecialchars($job['business_logo']); ?>" alt="Company Logo"
                                            class="object-cover w-full h-full">
                                    <?php else: ?>
                                        <i class="text-2xl text-gray-500 fas fa-building"></i>
                                    <?php endif; ?>
                                </div>

                                <div>
                                    <h1 class="text-xl font-semibold text-gray-900"><?php echo htmlspecialchars($job['job_title']); ?></h1>

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
                                    <a href="?page=view-employer-profile&employer_id=<?php echo $job['employer_id']; ?>"
                                        class="mt-1 text-sm transition-colors text-primary hover:text-secondary hover:underline">
                                        <?php echo htmlspecialchars($companyName); ?>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Application Timeline Bar -->
                        <?php if (!empty($job['application_start']) || !empty($job['application_deadline'])): ?>
                            <div class="flex justify-between p-4 mx-4 rounded-lg bg-gray-50">
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
                    <div class="p-6">
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
                            <div class="grid grid-cols-2 gap-4">
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
                                        <div class="flex items-center justify-between p-4 transition-colors border border-gray-200 rounded-lg bg-gray-50 hover:bg-gray-100">
                                            <div class="flex items-center">
                                    <div class="flex items-center justify-center w-12 h-12 mr-3 overflow-hidden bg-red-100 rounded-lg">
                                        <img
                                            src="../public/assets/icons/pdf-icon.png"
                                            alt="Icon"
                                            class="object-cover w-8 h-8" />
                                    </div>
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900">
                                                        <?php echo htmlspecialchars(basename($attachment['file_path'])); ?>
                                                    </div>
                                                    <div class="text-xs text-gray-500">PDF Document</div>
                                                </div>
                                            </div>
                                            <a href="<?php echo htmlspecialchars($attachment['file_path']); ?>"
                                                target="_blank"
                                                class="flex items-center px-3 py-2 text-sm font-medium transition-colors rounded-lg text-primary bg-blue-50 hover:bg-blue-100">
                                                <i class="mr-2 fas fa-download"></i>
                                                Download
                                            </a>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Right Section - Sidebar (4/12 width) -->
            <div class="w-full md:w-4/12">
                <!-- Single Sidebar Card -->
                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow">
                    <!-- Application Status -->
                    <div class="mb-8">
                        <h3 class="mb-4 text-xl font-semibold text-gray-900">Application Status</h3>

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
                        <?php elseif (isset($hasApplied) && $hasApplied): ?>
                            <div class="p-4 mb-4 border border-green-200 rounded-lg bg-green-50">
                                <div class="flex items-center">
                                    <i class="mr-3 text-2xl text-green-500 fas fa-check-circle"></i>
                                    <div>
                                        <p class="font-medium text-green-800">Application Submitted</p>
                                        <p class="text-sm text-green-600">Under review</p>
                                    </div>
                                </div>
                            </div>
                            <a href="?page=my-applications"
                                class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium transition-colors rounded-md text-primary hover:text-secondary bg-blue-50 hover:bg-blue-100">
                                <i class="mr-2 fas fa-file-alt"></i>
                                View Applications
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
                    <div class="mb-8">
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