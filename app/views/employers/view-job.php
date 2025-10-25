<?php
include_once __DIR__ . '/components/employer_auth_check.php';
include_once __DIR__ . '/../components/navbar-top.php';
include_once __DIR__ . '../components/navbar-employer.php';
?>

<div class="min-h-screen ">
    <div class="px-6 py-8">
        <div class="mx-auto max-w-7xl">

            <!-- Breadcrumbs -->
            <nav class="mb-6">
                <div class="flex items-center space-x-2 text-sm">
                    <a href="?page=employer-dashboard" class="text-gray-500 transition-colors hover:text-primary">
                        Dashboard
                    </a>
                    <svg class="flex-shrink-0 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    <a href="?page=manage-jobs" class="text-gray-500 transition-colors hover:text-primary">
                        Job Management
                    </a>
                    <svg class="flex-shrink-0 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    <!-- Enhanced job title breadcrumb with truncation -->
                    <span class="flex-1 min-w-0 font-medium text-primary">
                        <span class="block max-w-full truncate"
                            style="max-width: 300px;"
                            title="<?php echo htmlspecialchars($job['job_title'] ?? 'Job Details'); ?>">
                            <?php echo htmlspecialchars($job['job_title'] ?? 'Job Details'); ?>
                        </span>
                    </span>
                </div>
            </nav>

            <!-- Main Flex Layout -->
            <div class="flex flex-col gap-6 lg:flex-row lg:gap-8">
                <!-- Left Section - Main Content -->
                <div class="w-full space-y-6 lg:w-8/12">
                    <!-- Job Details Card -->
                    <div class="overflow-hidden bg-white border border-gray-200 shadow-sm rounded-xl">
                        <!-- Job Header with Gray Background -->
                        <div class="p-4 border-b border-gray-200 sm:p-6 bg-gray-50">
                            <div class="flex items-start justify-between mb-6">
                                <div class="flex-1 min-w-0 pr-4"> <!-- Added flex-1 min-w-0 and padding-right -->
                                    <!-- Enhanced title with truncation -->
                                    <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl">
                                        <div class="max-w-full break-words truncate overflow-wrap-anywhere word-break-break-all"
                                            title="<?php echo htmlspecialchars($job['job_title']); ?>">
                                            <?php echo htmlspecialchars($job['job_title']); ?>
                                        </div>
                                    </h1>
                                    <div class="flex items-center gap-3 mt-2">
                                        <!-- Employment Type Badge -->
                                        <span class="inline-flex items-center px-3 py-1 text-xs font-medium bg-gray-100 rounded-sm text-primary">
                                            <?php echo strtoupper(str_replace('-', ' ', $job['job_type'])); ?>
                                        </span>

                                        <!-- Status Badge -->
                                        <span class="inline-flex items-center px-3 py-1 rounded-sm text-xs font-medium
                                            <?php
                                            switch ($job['job_status']) {
                                                case 'open':
                                                    echo 'bg-green-100 text-green-600';
                                                    break;
                                                case 'closed':
                                                    echo 'bg-red-100 text-red-800';
                                                    break;
                                                case 'draft':
                                                    echo 'bg-yellow-100 text-yellow-800';
                                                    break;
                                                default:
                                                    echo 'bg-gray-100 text-gray-800';
                                            }
                                            ?>">
                                            <?php
                                            switch ($job['job_status']) {
                                                case 'open':
                                                    echo 'ACTIVE';
                                                    break;
                                                case 'closed':
                                                    echo 'CLOSED';
                                                    break;
                                                case 'draft':
                                                    echo 'DRAFT';
                                                    break;
                                                default:
                                                    echo strtoupper($job['job_status']);
                                            }
                                            ?>
                                        </span>
                                    </div>
                                </div>

                                <!-- Action Buttons - now with flex-shrink-0 -->
                                <div class="flex items-center flex-shrink-0 gap-2">
                                    <?php if ($job['job_status'] == 'open'): ?>
                                        <button onclick="window.location.href='?page=toggle-job-status&id=<?php echo $job['job_id']; ?>&status=closed'"
                                            class="flex items-center px-4 py-2 text-sm font-medium text-red-800 transition-colors border border-red-200 rounded-lg bg-red-50 hover:bg-red-100">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Close Job
                                        </button>
                                    <?php elseif ($job['job_status'] == 'closed'): ?>
                                        <button onclick="window.location.href='?page=toggle-job-status&id=<?php echo $job['job_id']; ?>&status=open'"
                                            class="flex items-center px-4 py-2 text-sm font-medium transition-colors border border-yellow-200 rounded-lg text-secondary bg-yellow-50 hover:bg-yellow-200">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Reopen Job
                                        </button>
                                    <?php endif; ?>

                                    <button onclick="window.location.href='?page=edit-job&id=<?php echo $job['job_id']; ?>'"
                                        class="flex items-center px-4 py-2 text-sm font-medium text-white transition-colors bg-gray-800 rounded-lg hover:bg-gray-900">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        Edit
                                    </button>
                                </div>
                            </div>

                            <!-- Application Timeline Bar -->
                            <?php if (!empty($job['application_start']) || !empty($job['application_deadline'])): ?>
                                <div class="p-3 border border-gray-300 rounded-lg">
                                    <div class="flex justify-between text-center sm:text-left">
                                        <!-- Days remaining -->
                                        <div class="flex-1">
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

                                        <!-- Application Start -->
                                        <div class="flex-1 text-center">
                                            <div class="text-xs text-gray-400">Application Start</div>
                                            <div class="text-sm text-primary">
                                                <?php echo $job['application_start'] ? date('M j, Y', strtotime($job['application_start'])) : 'Immediately'; ?>
                                            </div>
                                        </div>

                                        <!-- Application End -->
                                        <div class="flex-1 text-center">
                                            <div class="text-xs text-gray-400">Application End</div>
                                            <div class="text-sm text-primary">
                                                <?php echo $job['application_deadline'] ? date('M j, Y', strtotime($job['application_deadline'])) : 'No deadline'; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>



                        </div>

                        <!-- Main Content -->
                        <div class="p-4 sm:p-6">
                            <!-- Job Summary -->
                            <div class="mb-8" style="max-width: 100%; overflow: hidden;">
                                <h2 class="mb-3 font-semibold text-gray-800 text-md sm:text-xl">Job Summary</h2>
                                <!-- Enhanced job summary with stricter width control -->
                                <div class="text-sm text-gray-600 break-words sm:text-base overflow-wrap-anywhere word-break-break-all"
                                    style="max-width: 100%; width: 100%; overflow: hidden; display: block; word-wrap: break-word;">
                                    <?php echo nl2br(htmlspecialchars($job['job_summary'])); ?>
                                </div>
                            </div>

                            <!-- Skills Required -->
                            <?php if (!empty($job['skills']) && is_array($job['skills'])): ?>
                                <div class="mb-8">
                                    <h2 class="mb-3 font-semibold text-gray-800 text-md sm:text-xl">Skills Required</h2>
                                    <div class="flex flex-wrap gap-2">
                                        <?php
                                        $uniqueSkills = array_unique($job['skills']);
                                        foreach ($uniqueSkills as $skill):
                                        ?>
                                            <span class="px-3 py-1 text-sm font-medium text-gray-700 bg-gray-100 rounded-md">
                                                <?php echo htmlspecialchars($skill); ?>
                                            </span>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Basic Information -->
                            <div class="mb-8">
                                <h2 class="mb-3 font-semibold text-gray-800 text-md sm:text-xl">Basic Information</h2>
                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                                    <div>
                                        <div class="text-xs font-medium tracking-wide text-gray-500 uppercase">Category</div>
                                        <div class="mt-1 text-sm text-gray-900"><?php echo htmlspecialchars($job['category_name'] ?? 'N/A'); ?></div>
                                    </div>
                                    <div>
                                        <div class="text-xs font-medium tracking-wide text-gray-500 uppercase">Type</div>
                                        <div class="mt-1 text-sm text-gray-900"><?php echo ucfirst(str_replace('-', ' ', $job['job_type'])); ?></div>
                                    </div>
                                    <div>
                                        <div class="text-xs font-medium tracking-wide text-gray-500 uppercase">Location</div>
                                        <div class="mt-1 text-sm text-gray-900"><?php echo htmlspecialchars($job['location']); ?></div>
                                    </div>
                                    <div>
                                        <div class="text-xs font-medium tracking-wide text-gray-500 uppercase">Workplace</div>
                                        <div class="mt-1 text-sm text-gray-900"><?php echo ucfirst($job['workplace_option']); ?></div>
                                    </div>

                                    <!-- Age Requirements -->
                                    <?php if (!empty($job['min_age']) || !empty($job['max_age'])): ?>
                                        <div>
                                            <div class="text-xs font-medium tracking-wide text-gray-500 uppercase">Age Requirement</div>
                                            <div class="mt-1 text-sm text-gray-900">
                                                <?php
                                                if (!empty($job['min_age']) && !empty($job['max_age'])) {
                                                    echo $job['min_age'] . ' - ' . $job['max_age'] . ' years old';
                                                } elseif (!empty($job['min_age'])) {
                                                    echo 'Minimum ' . $job['min_age'] . ' years old';
                                                } elseif (!empty($job['max_age'])) {
                                                    echo 'Maximum ' . $job['max_age'] . ' years old';
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($job['show_pay'] && ($job['salary'] || $job['pay_range'])): ?>
                                        <div>
                                            <div class="text-xs font-medium tracking-wide text-gray-500 uppercase">Salary Range</div>
                                            <div class="mt-1 text-sm text-gray-900">
                                                <?php
                                                if ($job['salary']) {
                                                    echo '₱' . number_format($job['salary'], 2);
                                                    if ($job['pay_type']) echo ' / ' . $job['pay_type'];
                                                } elseif ($job['pay_range']) {
                                                    echo htmlspecialchars($job['pay_range']);
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Full Description -->
                            <?php if (!empty($job['full_description']) && $job['full_description'] !== $job['job_summary']): ?>
                                <div class="mb-8" style="max-width: 100%; overflow: hidden;">
                                    <h2 class="mb-3 font-semibold text-gray-800 text-md sm:text-xl">Full Description</h2>
                                    <div class="text-sm text-gray-600 break-words sm:text-base overflow-wrap-anywhere word-break-break-all"
                                        style="max-width: 100%; width: 100%; overflow: hidden; display: block; word-wrap: break-word;">
                                        <?php echo nl2br(htmlspecialchars($job['full_description'])); ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Screening Questions Section -->
                            <?php if (!empty($job['screening_questions'])): ?>
                                <div class="mb-8 space-y-4">
                                    <h4 class="pb-2 font-semibold text-gray-800 border-b border-gray-200 text-md">Screening Questions</h4>
                                    <div class="space-y-4">
                                        <?php foreach ($job['screening_questions'] as $question): ?>
                                            <div class="p-4 border border-gray-200 rounded-lg">
                                                <div class="mb-3">
                                                    <h5 class="text-sm font-medium text-gray-900">
                                                        <?php echo htmlspecialchars($question['question_text']); ?>
                                                    </h5>
                                                    <span class="inline-block px-2 py-1 mt-1 text-xs font-medium bg-gray-100 rounded text-primary">
                                                        <?php echo htmlspecialchars(ucfirst($question['question_type'] ?? 'text')); ?>
                                                    </span>
                                                </div>
                                                <?php if (!empty($question['question_option'])): ?>
                                                    <div class="p-3 bg-white border border-gray-200 rounded-md">
                                                        <p class="text-xs font-medium text-gray-600">Options:</p>
                                                        <p class="text-sm text-gray-700">
                                                            <?php echo nl2br(htmlspecialchars($question['question_option'])); ?>
                                                        </p>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="space-y-4">
                                    <h4 class="pb-2 font-semibold border-b border-gray-200 text-md text-primary">Screening Questions</h4>
                                    <div class="py-8 text-center">
                                        <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <h3 class="mt-2 text-sm font-medium text-gray-900">No Screening Questions</h3>
                                        <p class="mt-1 text-sm text-gray-500">This job posting did not require screening questions.</p>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Job Attachments - Only show if there are attachments -->
                            <?php if (!empty($job['attachments']) && is_array($job['attachments'])): ?>
                                <div class="mb-8">
                                    <h2 class="mb-3 font-semibold text-gray-800 text-md sm:text-xl">Job Attachments</h2>
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
                                            $full_path = __DIR__ . '/../../../uploads/' . basename($attachment['file_path']);
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
                                                    <!-- View/Preview Button (for PDFs and images) using your existing controller -->
                                                    <?php if (in_array($file_extension, ['pdf', 'jpg', 'jpeg', 'png', 'gif'])): ?>
                                                        <a href="?page=view-job-attachment&file_path=<?php echo urlencode($attachment['file_path']); ?>"
                                                            target="_blank"
                                                            class="flex items-center px-3 py-2 text-sm font-medium transition-colors rounded-lg text-primary bg-blue-50 hover:bg-blue-100">

                                                            View
                                                        </a>
                                                    <?php endif; ?>

                                                    <!-- Download Button using your existing controller -->
                                                    <a href="?page=download-job-attachment&file_path=<?php echo urlencode($attachment['file_path']); ?>"
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
                        <!-- Application Statistics -->
                        <div class="mb-6 sm:mb-8">
                            <h3 class="mb-4 text-lg font-semibold text-gray-900 sm:text-xl">Application Statistics</h3>
                            <div class="space-y-3">
                                <div class="flex items-center justify-between p-3 rounded-lg bg-gray-50">
                                    <span class="text-sm font-medium text-gray-600">Total Applications:</span>
                                    <span class="text-lg font-bold text-primary"><?php echo $job['total_applications'] ?? $job['application_count'] ?? 0; ?></span>
                                </div>
                                <div class="flex items-center justify-between p-3 rounded-lg bg-gray-50">
                                    <span class="text-sm font-medium text-gray-600">Pending Review:</span>
                                    <span class="text-lg font-bold text-primary"><?php echo $job['pending_count'] ?? 0; ?></span>
                                </div>
                                <div class="flex items-center justify-between p-3 rounded-lg bg-gray-50">
                                    <span class="text-sm font-medium text-gray-600">Shortlisted:</span>
                                    <span class="text-lg font-bold text-primary"><?php echo $job['shortlisted_count'] ?? 0; ?></span>
                                </div>
                                <div class="flex items-center justify-between p-3 rounded-lg bg-gray-50">
                                    <span class="text-sm font-bold text-gray-600">Hired:</span>
                                    <span class="text-lg font-bold text-green-600"><?php echo $job['hired_count'] ?? 0; ?></span>
                                </div>
                            </div>
                        </div>

                        <!-- Job Information -->
                        <div class="mb-6 sm:mb-8">
                            <div class="flex justify-between text-center">
                                <!-- Posted Date -->
                                <div class="flex-1">
                                    <div class="text-xs font-medium tracking-wide text-gray-500 uppercase">Posted</div>
                                    <div class="mt-1 text-sm font-semibold text-gray-900">
                                        <?php echo date('M j, Y', strtotime($job['created_at'])); ?>
                                    </div>
                                </div>

                                <!-- Vertical Separator -->
                                <div class="w-px mx-4 bg-gray-200"></div>

                                <!-- Last Updated -->
                                <div class="flex-1">
                                    <div class="text-xs font-medium tracking-wide text-gray-500 uppercase">
                                        <?php echo ($job['updated_at'] != $job['created_at']) ? 'Updated' : 'Status'; ?>
                                    </div>
                                    <div class="mt-1 text-sm font-semibold text-gray-900">
                                        <?php
                                        if ($job['updated_at'] != $job['created_at']) {
                                            echo date('M j, Y', strtotime($job['updated_at']));
                                        } else {
                                            echo ucfirst($job['job_status']);
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="space-y-3">
                            <?php if (($job['total_applications'] ?? $job['application_count'] ?? 0) > 0): ?>
                                <button onclick="window.location.href='?page=view-all-applicants&job_id=<?php echo $job['job_id']; ?>'"
                                    class="flex items-center justify-center w-full px-4 py-3 text-sm font-medium text-white transition-colors rounded-lg bg-primary hover:bg-primary-600">
                                    View All Applications
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Force text wrapping for long strings without spaces - Enhanced */
    .overflow-wrap-anywhere {
        overflow-wrap: anywhere;
        word-break: break-word;
        hyphens: auto;
    }

    /* Ensure container doesn't overflow */
    .rounded-xl {
        overflow: hidden;
    }

    /* Additional fallback for extremely long words */
    .break-words {
        word-wrap: break-word;
        word-break: break-word;
        overflow-wrap: break-word;
    }

    /* Prevent horizontal scrolling */
    .word-break-break-all {
        word-break: break-all;
    }

    /* Enhanced max-width constraints - CRITICAL for layout */
    .max-w-full {
        max-width: 100% !important;
        min-width: 0 !important;
        overflow: hidden !important;
    }

    /* Enhanced truncation for job titles */
    .truncate {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    /* Ensure flex items don't overflow - ENHANCED */
    .min-w-0 {
        min-width: 0 !important;
        flex-shrink: 1 !important;
        overflow: hidden !important;
    }

    /* Prevent button container from shrinking */
    .flex-shrink-0 {
        flex-shrink: 0 !important;
    }

    /* CRITICAL: Force left section width constraints */
    .lg\:w-8\/12 {
        width: 66.666667% !important;
        max-width: 66.666667% !important;
        flex-shrink: 1 !important;
        overflow: hidden !important;
    }

    .lg\:w-4\/12 {
        width: 33.333333% !important;
        max-width: 33.333333% !important;
        flex-shrink: 0 !important;
    }

    /* Force content containers to respect boundaries */
    .space-y-6>* {
        max-width: 100% !important;
        overflow: hidden !important;
    }

    /* Enhanced text content safety */
    .text-gray-600,
    .text-gray-900 {
        word-wrap: break-word !important;
        overflow-wrap: break-word !important;
        max-width: 100% !important;
        display: block !important;
    }

    /* CRITICAL: Card content width control */
    .bg-white.border.border-gray-200.shadow-sm.rounded-xl {
        width: 100% !important;
        max-width: 100% !important;
        overflow: hidden !important;
    }

    /* Force main content sections to stay within bounds */
    .p-4.sm\:p-6 {
        width: 100% !important;
        max-width: 100% !important;
        overflow: hidden !important;
    }

    /* Text sections enhanced constraints */
    .mb-8 {
        width: 100% !important;
        max-width: 100% !important;
        overflow: hidden !important;
    }

    .mb-8>div {
        width: 100% !important;
        max-width: 100% !important;
        overflow: hidden !important;
    }

    /* Grid sections safety */
    .grid.grid-cols-1.gap-4.sm\:grid-cols-2.lg\:grid-cols-3 {
        width: 100% !important;
        max-width: 100% !important;
    }

    .grid.grid-cols-1.gap-4.sm\:grid-cols-2.lg\:grid-cols-3>div {
        min-width: 0 !important;
        overflow: hidden !important;
    }

    /* Responsive text handling - ENHANCED */
    @media (max-width: 1024px) {
        .lg\:w-8\/12 {
            width: 100% !important;
            max-width: 100% !important;
        }

        .lg\:w-4\/12 {
            width: 100% !important;
            max-width: 100% !important;
        }
    }

    @media (max-width: 640px) {
        .truncate {
            max-width: 200px !important;
        }

        /* Force mobile layout constraints */
        .space-y-6 {
            width: 100% !important;
            max-width: 100% !important;
        }

        .px-6.py-8 {
            padding-left: 1rem !important;
            padding-right: 1rem !important;
        }
    }

    @media (max-width: 480px) {
        .truncate {
            max-width: 150px !important;
        }
    }

    /* Additional safety for flex layouts */
    .flex.flex-col.gap-6.lg\:flex-row.lg\:gap-8 {
        width: 100% !important;
        max-width: 100% !important;
        overflow: hidden !important;
    }

    /* Force container boundaries */
    .mx-auto.max-w-7xl {
        width: 100% !important;
        max-width: 80rem !important;
        overflow: hidden !important;
    }

    /* Ensure no element can break out */
    * {
        box-sizing: border-box !important;
    }

    /* Additional text safety for descriptions */
    .mb-8 .max-w-full.text-sm.text-gray-600.break-words.sm\:text-base.overflow-wrap-anywhere.word-break-break-all {
        max-width: 100% !important;
        width: 100% !important;
        overflow-wrap: break-word !important;
        word-break: break-word !important;
        hyphens: auto !important;
    }

    /* Enhanced breadcrumb styling */
    nav .flex.items-center.space-x-2 {
        width: 100% !important;
        max-width: 100% !important;
        overflow: hidden !important;
    }

    /* Breadcrumb truncation styles */
    .text-primary.min-w-0.flex-1 {
        min-width: 0 !important;
        flex: 1 !important;
        overflow: hidden !important;
    }

    .text-primary.min-w-0.flex-1 .truncate {
        overflow: hidden !important;
        text-overflow: ellipsis !important;
        white-space: nowrap !important;
        display: block !important;
    }

    /* Responsive breadcrumb handling */
    @media (max-width: 1024px) {
        .text-primary.min-w-0.flex-1 .truncate {
            max-width: 250px !important;
        }
    }

    @media (max-width: 768px) {
        .text-primary.min-w-0.flex-1 .truncate {
            max-width: 200px !important;
        }
    }

    @media (max-width: 640px) {
        .text-primary.min-w-0.flex-1 .truncate {
            max-width: 150px !important;
        }
    }

    @media (max-width: 480px) {
        .text-primary.min-w-0.flex-1 .truncate {
            max-width: 100px !important;
        }
    }

    /* Ensure chevron icons don't shrink */
    .flex-shrink-0 {
        flex-shrink: 0 !important;
    }
</style>