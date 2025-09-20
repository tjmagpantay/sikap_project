<?php
include_once __DIR__ . '/../components/jobseeker_auth_check.php';
include_once __DIR__ . '/../../components/navbar-top.php';
include_once __DIR__ . '/../components/navbar-jobseeker.php'; ?>

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

                                <!-- Action Buttons Box -->
                                <div class="flex items-center gap-2 p-2">
                                    <!-- Verified Badge -->
                                    <button class="flex items-center justify-center w-8 h-8 transition-colors border rounded-lg text-primary border-primary bg-primary/10 hover:bg-primary/20" title="Verified">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="#10364B">
                                            <path d="M14.01 21c-.49 0-.95-.23-1.33-.43-.24-.12-.53-.27-.68-.27s-.47.15-.7.27c-.48.25-1.08.55-1.72.38-.66-.17-1.02-.75-1.34-1.21-.13-.21-.31-.49-.43-.56-.12-.07-.44-.08-.71-.1-.54-.03-1.21-.06-1.7-.53-.48-.49-.51-1.16-.54-1.7-.01-.26-.03-.59-.07-.71-.06-.11-.35-.29-.55-.43-.46-.3-1.03-.67-1.21-1.31-.17-.64.13-1.24.38-1.72.12-.24.27-.53.27-.68s-.15-.47-.27-.7c-.25-.48-.55-1.08-.38-1.72.17-.66.75-1.02 1.21-1.34.2-.13.49-.31.56-.43.07-.12.08-.44.1-.71.03-.54.06-1.21.53-1.7.49-.48 1.16-.51 1.7-.54.26-.01.59-.03.71-.07.11-.06.29-.35.43-.55.3-.46.67-1.03 1.31-1.21.64-.17 1.24.13 1.72.38.24.12.53.27.68.27s.47-.15.7-.27c.48-.25 1.08-.55 1.72-.38.66.17 1.02.75 1.34 1.21.13.21.31.49.43.56.12.07.44.08.71.1.54.03 1.21.06 1.7.53.48.49.51 1.16.54 1.7.01.26.03.59.07.71.06.11.35.29.55.43.46.3 1.03.67 1.21 1.31.17.64-.13 1.24-.38 1.72-.12.24-.27.53-.27.68s.15.47.27.7c.25.48.55 1.08.38 1.72-.17.66-.75 1.02-1.21 1.34-.2.13-.49.31-.56.43-.07.12-.08.44-.1.71-.03.54-.06 1.21-.53 1.7-.49.48-1.16.51-1.7.54-.26.01-.59.03-.71.07-.11.06-.29.35-.43.55-.3.46-.67 1.03-1.31 1.21-.13.04-.26.05-.39.05Zm-4.02-16.5c-.1.04-.33.38-.44.57-.24.37-.51.79-.94 1.04-.44.25-.94.28-1.39.3-.22.01-.63.03-.72.1-.06.08-.08.48-.09.7-.02.45-.05.95-.3 1.39-.25.44-.67.72-1.04.95-.18.11-.52.33-.56.44-.01.11.16.46.26.66.2.4.44.83.44 1.34s-.24.94-.44 1.34c-.1.2-.27.55-.26.66.04.11.38.34.56.45.37.23.79.51 1.04.95.25.44.28.94.3 1.39.01.22.03.63.1.72.08.06.48.08.7.09.45.02.95.05 1.39.3.44.25.72.67.95 1.04.11.18.33.52.44.56.11.04.46-.16.66-.26.4-.2.83-.44 1.34-.44s.94.24 1.34.44c.2.1.55.27.66.26.11-.04.34-.38.45-.56.23-.37.51-.79.95-1.04.44-.25.94-.28 1.39-.3.22-.01.63-.03.72-.1.06-.08.08-.48.09-.7.02-.45.05-.95.3-1.39.25-.44.67-.72 1.04-.95.18-.11.52-.33.56-.44.01-.11-.16-.46-.26-.66-.2-.4-.44-.83-.44-1.34s.24-.94.44-1.34c.1-.2.27-.55.26-.66-.04-.11-.38-.34-.56-.45-.37-.23-.79-.51-1.04-.95-.25-.44-.28-.94-.3-1.39-.01-.22-.03-.63-.1-.72-.08-.06-.48-.08-.7-.09-.45-.02-.95-.05-1.39-.3-.44-.25-.72-.67-.95-1.04-.11-.18-.33-.52-.44-.56-.1-.03-.45.17-.66.27-.4.2-.83.44-1.34.44s-.94-.24-1.34-.44c-.2-.1-.55-.27-.66-.27Zm.5 11.01c-.2 0-.39-.08-.53-.22l-2.54-2.53c-.29-.29-.29-.77 0-1.06.29-.29.77-.29 1.06 0l1.98 1.98 4.99-4.99c.29-.29.77-.29 1.06 0s.29.77 0 1.06l-5.52 5.52c-.14.14-.33.22-.53.22Z" />
                                        </svg>
                                    </button>

                                    <!-- Share Button -->
                                    <button 
                                        onclick="shareJob('<?php echo htmlspecialchars($job['job_title'], ENT_QUOTES); ?>', window.location.href)"
                                        class="flex items-center justify-center w-8 h-8 text-gray-600 transition-colors border border-gray-400 rounded-lg bg-gray-50 hover:bg-gray-100" 
                                        title="Share">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9 12C9 13.3807 7.88071 14.5 6.5 14.5C5.11929 14.5 4 13.3807 4 12C4 10.6193 5.11929 9.5 6.5 9.5C7.88071 9.5 9 10.6193 9 12Z" stroke="#828282" stroke-width="1.5" />
                                            <path d="M14 6.5L9 10" stroke="#828282" stroke-width="1.5" stroke-linecap="round" />
                                            <path d="M14 17.5L9 14" stroke="#828282" stroke-width="1.5" stroke-linecap="round" />
                                            <path d="M19 18.5C19 19.8807 17.8807 21 16.5 21C15.1193 21 14 19.8807 14 18.5C14 17.1193 15.1193 16 16.5 16C17.8807 16 19 17.1193 19 18.5Z" stroke="#828282" stroke-width="1.5" />
                                            <path d="M19 5.5C19 6.88071 17.8807 8 16.5 8C15.1193 8 14 6.88071 14 5.5C14 4.11929 15.1193 3 16.5 3C17.8807 3 19 4.11929 19 5.5Z" stroke="#828282" stroke-width="1.5" />
                                        </svg>
                                    </button>

                                    <!-- Save Button -->
                                    <?php if (isset($profileCompleted) && $profileCompleted): ?>
                                        <button onclick="toggleSaveJob(<?php echo $job['job_id']; ?>, this)"
                                            class="flex items-center justify-center w-8 h-8 transition-colors border border-gray-400 rounded-lg <?php echo (isset($job['is_saved']) && $job['is_saved']) ? 'text-yellow-500 bg-yellow-50 border-yellow-300' : 'text-gray-500 bg-gray-50'; ?> hover:bg-gray-100"
                                            title="<?php echo (isset($job['is_saved']) && $job['is_saved']) ? 'Remove from saved' : 'Save job'; ?>">
                                            <i class="text-sm <?php echo (isset($job['is_saved']) && $job['is_saved']) ? 'fas' : 'far'; ?> fa-bookmark"></i>
                                        </button>
                                    <?php else: ?>
                                        <button class="flex items-center justify-center w-8 h-8 text-gray-500 transition-colors border border-gray-400 rounded-lg bg-gray-50 hover:bg-gray-100" title="Complete profile to save jobs" disabled>
                                            <i class="text-sm far fa-bookmark"></i>
                                        </button>
                                    <?php endif; ?>
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

                                    <!-- Age Requirements -->
                                    <?php if (!empty($job['min_age']) || !empty($job['max_age'])): ?>
                                        <div>
                                            <div class="text-xs text-gray-400">Age Requirement</div>
                                            <div class="text-sm text-primary">
                                                <?php
                                                if (!empty($job['min_age']) && !empty($job['max_age'])) {
                                                    echo $job['min_age'] . ' - ' . $job['max_age'] . ' years old';
                                                } elseif (!empty($job['min_age'])) {
                                                    echo 'Minimum ' . $job['min_age'] . ' years old';
                                                } elseif (!empty($job['max_age'])) {
                                                    echo 'Maximum ' . $job['max_age'] . ' years old';
                                                } else {
                                                    echo 'No age restriction';
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>

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

                            <!-- Job Attachments - Only show if there are attachments -->
                            <?php if (!empty($job['attachments']) && is_array($job['attachments'])): ?>
                                <div class="mb-8">
                                    <h2 class="mb-3 text-lg font-semibold text-gray-900 sm:text-xl">Job Attachments</h2>
                                    <div class="space-y-3">
                                        <?php foreach ($job['attachments'] as $attachment): ?>
                                            <?php
                                            // Extract file extension and name
                                            $file_extension = strtolower(pathinfo($attachment['file_path'], PATHINFO_EXTENSION));
                                            $file_name = basename($attachment['file_path']);

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

                                            // Get file size
                                            $file_size = '';
                                            $full_path = __DIR__ . '/../../../../uploads/job_attachments/' . basename($attachment['file_path']);
                                            if (file_exists($full_path)) {
                                                $size_bytes = filesize($full_path);
                                                if ($size_bytes < 1024) {
                                                    $file_size = $size_bytes . ' B';
                                                } elseif ($size_bytes < 1048576) {
                                                    $file_size = round($size_bytes / 1024, 1) . ' KB';
                                                } else {
                                                    $file_size = round($size_bytes / 1048576, 1) . ' MB';
                                                }
                                            }
                                            ?>
                                            <div class="flex items-center justify-between p-4 transition-colors border border-gray-200 rounded-lg bg-gray-50 hover:bg-gray-100">
                                                <div class="flex items-center">
                                                    <div class="flex items-center justify-center w-12 h-12 mr-3 rounded-lg bg-red-50">
                                                        <img src="<?php echo $icon_path; ?>"
                                                            alt="<?php echo strtoupper($file_extension); ?> Icon"
                                                            class="w-6 h-6"
                                                            onerror="this.src='/sikap/public/assets/icons/file-icon.png'" />
                                                    </div>
                                                    <div>
                                                        <div class="text-sm font-medium text-gray-900">
                                                            <?php echo htmlspecialchars($file_name); ?>
                                                        </div>
                                                        <div class="text-xs text-gray-500">
                                                            <?php echo $file_size; ?>
                                                            <?php if ($file_size): ?> • <?php endif; ?>
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
                                
                                                            View
                                                        </a>
                                                    <?php endif; ?>

                                                    <!-- Download Button -->
                                                    <a href="?page=download-job-attachment&file_path=<?php echo urlencode($attachment['file_path']); ?><?php echo isset($attachment['attachment_id']) ? '&attachment_id=' . $attachment['attachment_id'] : ''; ?>"
                                                        class="flex items-center px-3 py-2 text-sm font-medium transition-colors rounded-lg text-primary bg-blue-50 hover:bg-blue-100">
                                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                        </svg>
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

                            <?php
                            // Debug output to see what variables we have
                            error_log("VIEW DEBUG: hasApplied = " . (isset($hasApplied) ? ($hasApplied ? 'true' : 'false') : 'not set'));
                            error_log("VIEW DEBUG: incompleteApplication = " . (isset($incompleteApplication) && $incompleteApplication ? 'exists' : 'null'));
                            error_log("VIEW DEBUG: applicationStatus = " . (isset($applicationStatus) ? $applicationStatus : 'not set'));
                            error_log("VIEW DEBUG: profileCompleted = " . (isset($profileCompleted) ? ($profileCompleted ? 'true' : 'false') : 'not set'));
                            ?> <?php if (!isset($_SESSION['user_id'])): ?>
                                <!-- Not Logged In -->
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
                                <!-- Wrong User Type -->
                                <div class="p-4 border border-gray-200 rounded-lg bg-gray-50">
                                    <div class="flex items-center justify-center">
                                        <i class="mr-2 text-gray-400 fas fa-user-times"></i>
                                        <p class="text-sm text-gray-600">Only job seekers can apply</p>
                                    </div>
                                </div>

                            <?php elseif (isset($hasApplied) && $hasApplied === true): ?>
                                <?php if (isset($incompleteApplication) && !empty($incompleteApplication)): ?>
                                    <!-- INCOMPLETE APPLICATION - Show Detailed Progress -->
                                    <div class="p-4 mb-4 border border-blue-200 rounded-lg bg-blue-50">
                                        <div class="flex items-center justify-between mb-3">
                                            <div class="flex items-center">
                                                <i class="mr-3 text-2xl text-primary fas fa-clock"></i>
                                                <div>
                                                    <p class="text-sm font-medium text-primary">Application in Progress</p>
                                                    <p class="text-xs text-blue-700">
                                                        Step <?php echo $incompleteApplication['current_step']; ?> of 4 completed
                                                    </p>
                                                </div>
                                            </div>
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700 border border-blue-200">
                                                <?php echo round(($incompleteApplication['current_step'] / 4) * 100); ?>% Complete
                                            </span>
                                        </div>



                                        <!-- Current Step Info -->
                                        <div class="p-3 mb-3 bg-blue-100 border border-blue-300 rounded-md">
                                            <div class="flex items-start">

                                                <div class="flex-1">
                                                    <?php
                                                    switch ($incompleteApplication['current_step']) {
                                                        case 1:
                                                            echo '<p class="text-xs font-medium text-primary">Step 1: Documents & Personal Info</p>';
                                                            echo '<p class="mt-1 text-xs text-primary">Upload your resume/CV and complete personal information.</p>';
                                                            break;
                                                        case 2:
                                                            echo '<p class="text-xs font-medium text-primary">Step 2: Screening Questions</p>';
                                                            echo '<p class="mt-1 text-xs text-primary">Answer employer screening questions for this position.</p>';
                                                            break;
                                                        case 3:
                                                            echo '<p class="text-xs font-medium text-primary">Step 3: Eligibility Information</p>';
                                                            echo '<p class="mt-1 text-xs text-primary ">Provide eligibility details and program interests.</p>';
                                                            break;
                                                        case 4:
                                                            echo '<p class="text-xs font-medium text-primary">Step 4: Review & Submit</p>';
                                                            echo '<p class="mt-1 text-xs text-primary">Review your application and submit to employer.</p>';
                                                            break;
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Action Buttons -->
                                        <div class="flex gap-2">
                                            <a href="?page=apply-job&job_id=<?php echo $job['job_id']; ?>&application_id=<?php echo $incompleteApplication['application_id']; ?>&step=<?php echo $incompleteApplication['current_step']; ?>"
                                                class="flex items-center justify-center flex-1 px-4 py-3 text-sm font-medium text-white transition-colors border rounded-md bg-primary hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                Continue Application
                                            </a>
                                            <a href="?page=view-application&application_id=<?php echo $incompleteApplication['application_id']; ?>"
                                                class="flex items-center justify-center px-4 py-3 text-sm font-medium transition-colors bg-orange-100 border border-gray-200 rounded-md text-primary hover:bg-orange-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">

                                                View Details
                                            </a>
                                        </div>
                                    </div>

                                <?php else: ?>
                                    <!-- COMPLETE APPLICATION - Show Status with Enhanced Display -->
                                    <?php if (isset($applicationStatus) && !empty($applicationStatus)): ?>
                                        <div class="p-4 mb-4 border rounded-lg
                                            <?php
                                            switch ($applicationStatus) {
                                                case 'pending':
                                                    echo 'border-blue-200 bg-blue-50';
                                                    break;
                                                case 'reviewed':
                                                    echo 'border-blue-200 bg-blue-50';
                                                    break;
                                                case 'shortlisted':
                                                    echo 'border-blue-200 bg-blue-50';
                                                    break;
                                                case 'hired':
                                                    echo 'border-blue-200 bg-blue-50';
                                                    break;
                                                case 'rejected':
                                                    echo 'border-red-200 bg-red-50';
                                                    break;
                                                default:
                                                    echo 'border-gray-200 bg-gray-50';
                                            }
                                            ?>">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center">
                                                    <div class="flex items-center justify-center w-8 h-8 mr-3 rounded-full border-2
                                                        <?php
                                                        switch ($applicationStatus) {
                                                            case 'pending':
                                                                echo 'border-blue-500 bg-blue-100';
                                                                break;
                                                            case 'reviewed':
                                                                echo 'border-blue-500 bg-blue-100';
                                                                break;
                                                            case 'shortlisted':
                                                                echo 'border-blue-500 bg-blue-100';
                                                                break;
                                                            case 'hired':
                                                                echo 'border-blue-500 bg-blue-100';
                                                                break;
                                                            case 'rejected':
                                                                echo 'border-red-600 bg-red-100';
                                                                break;
                                                            default:
                                                                echo 'border-gray-400 bg-gray-100';
                                                        }
                                                        ?>">

                                                        <?php
                                                        switch ($applicationStatus) {
                                                            case 'pending':
                                                                echo '<svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                      </svg>';
                                                                break;
                                                            case 'reviewed':
                                                                echo '<svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                                                      </svg>';
                                                                break;
                                                            case 'shortlisted':
                                                                echo '<svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/>
                                                                      </svg>';
                                                                break;
                                                            case 'hired':
                                                                echo '<svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                                      </svg>';
                                                                break;
                                                            case 'rejected':
                                                                echo '<svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                                      </svg>';
                                                                break;
                                                            default:
                                                                echo '<svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                      </svg>';
                                                        }
                                                        ?>
                                                    </div>
                                                    <div>
                                                        <p class="text-sm font-medium 
                                                            <?php
                                                            switch ($applicationStatus) {
                                                                case 'pending':
                                                                    echo 'text-primary';
                                                                    break;
                                                                case 'reviewed':
                                                                    echo 'text-primary';
                                                                    break;
                                                                case 'shortlisted':
                                                                    echo 'text-primary';
                                                                    break;
                                                                case 'hired':
                                                                    echo 'text-primary';
                                                                    break;
                                                                case 'rejected':
                                                                    echo 'text-red-700';
                                                                    break;
                                                                default:
                                                                    echo 'text-gray-700';
                                                            }
                                                            ?>">
                                                            <?php
                                                            switch ($applicationStatus) {
                                                                case 'pending':
                                                                    echo 'Application Submitted';
                                                                    break;
                                                                case 'reviewed':
                                                                    echo 'Under Review';
                                                                    break;
                                                                case 'shortlisted':
                                                                    echo 'Shortlisted';
                                                                    break;
                                                                case 'hired':
                                                                    echo 'Hired';
                                                                    break;
                                                                case 'rejected':
                                                                    echo 'Not Selected';
                                                                    break;
                                                                default:
                                                                    echo ucfirst($applicationStatus);
                                                            }
                                                            ?>
                                                        </p>
                                                        <p class="text-xs 
                                                            <?php
                                                            switch ($applicationStatus) {
                                                                case 'pending':
                                                                    echo 'text-primary';
                                                                    break;
                                                                case 'reviewed':
                                                                    echo 'text-primary';
                                                                    break;
                                                                case 'shortlisted':
                                                                    echo 'text-primary';
                                                                    break;
                                                                case 'hired':
                                                                    echo 'text-primary';
                                                                    break;
                                                                case 'rejected':
                                                                    echo 'text-red-700';
                                                                    break;
                                                                default:
                                                                    echo 'text-gray-600';
                                                            }
                                                            ?>">
                                                            <?php
                                                            switch ($applicationStatus) {
                                                                case 'pending':
                                                                    echo 'Waiting for employer review';
                                                                    break;
                                                                case 'reviewed':
                                                                    echo 'Your application is being evaluated';
                                                                    break;
                                                                case 'shortlisted':
                                                                    echo 'You\'re in the final selection!';
                                                                    break;
                                                                case 'hired':
                                                                    echo 'Congratulations! You got the job!';
                                                                    break;
                                                                case 'rejected':
                                                                    echo 'Thank you for your interest';
                                                                    break;
                                                                default:
                                                                    echo 'Application status: ' . $applicationStatus;
                                                            }
                                                            ?>
                                                        </p>
                                                    </div>
                                                </div>

                                                <!-- Application Date -->
                                                <?php if (!empty($applicationData['applied_at'])): ?>
                                                    <div class="text-right">
                                                        <p class="text-xs font-medium 
                                                            <?php
                                                            switch ($applicationStatus) {
                                                                case 'pending':
                                                                    echo 'text-primary';
                                                                    break;
                                                                case 'reviewed':
                                                                    echo 'text-primary';
                                                                    break;
                                                                case 'shortlisted':
                                                                    echo 'text-primary';
                                                                    break;
                                                                case 'hired':
                                                                    echo 'text-primary';
                                                                    break;
                                                                case 'rejected':
                                                                    echo 'text-red-700';
                                                                    break;
                                                                default:
                                                                    echo 'text-gray-700';
                                                            }
                                                            ?>">Applied</p>
                                                        <p class="text-xs 
                                                            <?php
                                                            switch ($applicationStatus) {
                                                                case 'pending':
                                                                    echo 'text-primary';
                                                                    break;
                                                                case 'reviewed':
                                                                    echo 'text-primary';
                                                                    break;
                                                                case 'shortlisted':
                                                                    echo 'text-primary';
                                                                    break;
                                                                case 'hired':
                                                                    echo 'text-primary';
                                                                    break;
                                                                case 'rejected':
                                                                    echo 'text-red-600';
                                                                    break;
                                                                default:
                                                                    echo 'text-gray-600';
                                                            }
                                                            ?>">
                                                            <?php echo date('M j, Y', strtotime($applicationData['applied_at'])); ?>
                                                        </p>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <!-- Status-specific detailed message -->
                                        <?php if ($applicationStatus === 'pending'): ?>
                                            <div class="p-3 mb-4 border border-yellow-200 rounded-lg bg-yellow-50">
                                                <p class="text-xs text-yellow-800">
                                                   
                                                    Your application is being reviewed by the employer. You'll be notified when there's an update.
                                                </p>
                                            </div>
                                        <?php elseif ($applicationStatus === 'reviewed'): ?>
                                            <div class="p-3 mb-4 border border-blue-200 rounded-lg bg-blue-50">
                                                <p class="text-xs text-blue-800">
                                                  
                                                    Your application is currently under detailed review. The employer is evaluating your qualifications.
                                                </p>
                                            </div>
                                        <?php elseif ($applicationStatus === 'shortlisted'): ?>
                                            <div class="p-3 mb-4 border border-purple-200 rounded-lg bg-purple-50">
                                                <p class="text-xs text-blue-800">
                                                   
                                                    Congratulations! You've been shortlisted for this position. The employer may contact you soon for the next steps.
                                                </p>
                                            </div>
                                        <?php elseif ($applicationStatus === 'hired'): ?>
                                            <div class="p-3 mb-4 border border-green-200 rounded-lg bg-green-50">
                                                <p class="text-xs text-green-800">
                                                   
                                                    Congratulations! You've been hired for this position. The employer will contact you with further details.
                                                </p>
                                            </div>
                                        <?php elseif ($applicationStatus === 'rejected'): ?>
                                            <div class="p-3 mb-4 border border-red-200 rounded-lg bg-red-50">
                                                <p class="text-xs text-red-800">
                                                    
                                                    Thank you for your interest. Unfortunately, you were not selected for this position. Keep applying to other opportunities!
                                                </p>
                                            </div>
                                        <?php endif; ?>

                                        <!-- Action Buttons for Complete Application -->
                                        <div class="flex gap-2">
                                            <a href="?page=view-application&application_id=<?php echo $applicationData['application_id']; ?>"
                                                class="flex items-center justify-center flex-1 px-4 py-2 text-sm font-medium transition-colors rounded-md 
                                                <?php
                                                switch ($applicationStatus) {
                                                    case 'pending':
                                                        echo 'text-white bg-primary ';
                                                        break;
                                                    case 'reviewed':
                                                        echo 'text-white bg-primary';
                                                        break;
                                                    case 'shortlisted':
                                                        echo 'text-white bg-primary';
                                                        break;
                                                    case 'hired':
                                                        echo 'text-white bg-primary';
                                                        break;
                                                    case 'rejected':
                                                        echo 'text-red-600 bg-red-100 hover:bg-red-200';
                                                        break;
                                                    default:
                                                        echo 'text-gray-600 bg-gray-100 hover:bg-gray-200';
                                                }
                                                ?>">

                                                View Application
                                            </a>
                                            <a href="?page=my-applications"
                                                class="flex items-center justify-center flex-1 px-4 py-2 text-sm font-medium text-gray-600 transition-colors bg-gray-100 rounded-md hover:bg-gray-200">
                                                <i class="mr-2 fas fa-list"></i>
                                                All Applications
                                            </a>
                                        </div>

                                    <?php else: ?>
                                        <!-- Fallback: Application exists but status is missing -->
                                        <div class="p-4 mb-4 border border-gray-200 rounded-lg bg-gray-50">
                                            <div class="flex items-center">
                                                <i class="mr-3 text-gray-500 fas fa-file-alt"></i>
                                                <div>
                                                    <p class="text-sm font-medium text-gray-700">Application Found</p>
                                                    <p class="text-xs text-gray-600">Status information is being updated</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="flex gap-2">
                                            <?php if (isset($applicationData['application_id'])): ?>
                                                <a href="?page=view-application&application_id=<?php echo $applicationData['application_id']; ?>"
                                                    class="flex items-center justify-center flex-1 px-4 py-2 text-sm font-medium text-gray-600 transition-colors bg-gray-100 rounded-md hover:bg-gray-200">
                                                    <i class="mr-2 fas fa-eye"></i>
                                                    View Application
                                                </a>
                                            <?php endif; ?>
                                            <a href="?page=my-applications"
                                                class="flex items-center justify-center flex-1 px-4 py-2 text-sm font-medium text-gray-600 transition-colors bg-gray-100 rounded-md hover:bg-gray-200">
                                                <i class="mr-2 fas fa-list"></i>
                                                All Applications
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>

                            <?php else: ?>
                                <!-- NO APPLICATION - Show Apply Button -->
                                <?php if (!isset($profileCompleted) || !$profileCompleted): ?>
                                    <!-- Profile Incomplete -->
                                    <div class="p-4 mb-4 border border-orange-200 rounded-lg bg-orange-50">
                                        <div class="flex items-center">
                                            <i class="mr-3 text-primary fas fa-user-edit"></i>
                                            <div>
                                                <p class="text-sm font-medium text-orange-700">Complete Profile Required</p>
                                                <p class="text-xs text-orange-600">Finish setting up your profile to apply for jobs</p>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="?page=complete-jobseeker-profile"
                                        class="flex items-center justify-center w-full px-4 py-3 text-sm font-medium text-white transition-colors bg-orange-500 rounded-md hover:bg-orange-600">
                                        <i class="mr-2 fas fa-user-edit"></i>
                                        Complete Profile to Apply
                                    </a>

                                <?php else: ?>
                                    <!-- Profile Complete - Show Apply Button -->
                                    <div class="p-4 mb-4 border border-blue-200 rounded-lg bg-blue-50">
                                        <div class="flex items-center">
                                            <i class="mr-3 text-primary fas fa-paper-plane"></i>
                                            <div>
                                                <p class="text-sm font-medium text-primary">Ready to Apply</p>
                                                <p class="text-xs text-blue-600">Start your application for this position</p>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="?page=apply-job&job_id=<?php echo $job['job_id']; ?>&step=1"
                                        class="flex items-center justify-center w-full px-4 py-3 text-sm font-medium text-white transition-colors rounded-md bg-primary hover:bg-primary/90">
                                        <i class="mr-2 fas fa-paper-plane"></i>
                                        Apply Now
                                    </a>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>

                        <!-- Job Information -->
                        <div class="mb-6 sm:mb-8">
                            <h3 class="mb-4 text-lg font-semibold text-gray-900">Job Information</h3>
                            <div class="space-y-4">
                                <div class="flex items-center justify-between p-3 rounded-md bg-gray-50">
                                    <span class="text-sm font-medium text-gray-600">Posted:</span>
                                    <span class="text-sm font-medium text-primary"><?php echo date('M j, Y', strtotime($job['created_at'])); ?></span>
                                </div>

                                <?php if (!empty($job['application_deadline'])): ?>
                                    <div class="flex items-center justify-between p-3 rounded-md bg-gray-50">
                                        <span class="text-sm font-medium text-gray-600">Deadline:</span>
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

<script>
// Add the shareJob function that's referenced in the share button
function shareJob(jobTitle, url) {
    if (navigator.share) {
        navigator.share({
            title: jobTitle,
            url: url
        }).catch(console.error);
    } else {
        // Fallback for browsers that don't support Web Share API
        if (navigator.clipboard) {
            navigator.clipboard.writeText(url).then(() => {
                alert('Job link copied to clipboard!');
            }).catch(err => {
                console.error('Could not copy text: ', err);
                alert('Failed to copy job link. Please try manually sharing the link.');
            });
        } else {
            // If clipboard API is not available, just show the URL in an alert
            alert('Job URL: ' + url);
        }
    }
}
</script>