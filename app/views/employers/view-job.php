<?php
include_once __DIR__ . '/../components/navbar-top.php';
include_once __DIR__ . '../components/navbar-employer.php';
?>

<div class="min-h-screen bg-gray-50">
    <div class="mx-auto sm:px-2 md:px-4 lg:px-12 max-w-7xl py-8">
        <!-- Header with breadcrumbs -->
        <div class="mb-8">
            <!-- Breadcrumb Navigation -->
            <nav class="flex mb-4" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="?page=employer-dashboard" class="inline-flex items-center text-sm text-gray-400 hover:text-gray-600">

                            Dashboard
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                            <a href="?page=manage-jobs" class="ml-1 text-sm text-gray-400 hover:text-gray-600 md:ml-2">
                                Job Management
                            </a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                            <span class="ml-1 text-sm font-medium text-primary md:ml-2">View Job</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <h1 class="text-2xl font-bold text-gray-900">Job Details</h1>
        </div>

        <!-- Main Flex Layout -->
        <div class="flex flex-col gap-8 md:flex-row">

            <!-- Left Section - Main Content (8/12 width) -->
            <div class="w-full space-y-6 md:w-8/12">

                <!-- Header Card -->
                <div class="overflow-hidden bg-white border border-gray-200 rounded-lg shadow">
                    <div class="p-6">
                        <!-- Job Title and Badges -->
                        <div class="flex items-start justify-between mb-6">
                            <div>
                                <h1 class="text-xl font-semibold text-gray-900"><?php echo htmlspecialchars($job['job_title']); ?></h1>
                                <div class="flex items-center gap-3">
                                    <!-- Employment Type Badge -->
                                    <span class="inline-flex items-center px-3 py-1 text-xs font-medium bg-blue-100 rounded-sm text-primary">
                                        <?php echo strtoupper(str_replace('-', ' ', $job['job_type'])); ?>
                                    </span>

                                    <!-- Status Badge -->
                                    <span class="inline-flex items-center px-3 py-1 rounded-sm text-xs font-medium
                                        <?php
                                        switch ($job['job_status']) {
                                            case 'open':
                                                echo 'bg-green-100 text-green-800';
                                                break;
                                            case 'closed':
                                                echo 'bg-red-100 text-red-800';
                                                break;
                                            case 'paused':
                                                echo 'bg-yellow-100 text-yellow-800';
                                                break;
                                            case 'draft':
                                                echo 'bg-gray-100 text-gray-800';
                                                break;
                                            default:
                                                echo 'bg-gray-100 text-gray-800';
                                        }
                                        ?>">
                                        <?php echo strtoupper($job['job_status']); ?>
                                    </span>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex items-center gap-2">
                                <?php if ($job['job_status'] == 'open'): ?>
                                    <button onclick="window.location.href='?page=toggle-job-status&id=<?php echo $job['job_id']; ?>&status=paused'"
                                        class="flex items-center px-4 py-2 text-sm font-medium text-yellow-800 transition-colors border border-yellow-200 rounded-lg bg-yellow-50 hover:bg-yellow-100">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Pause
                                    </button>
                                <?php elseif ($job['job_status'] == 'paused'): ?>
                                    <button onclick="window.location.href='?page=toggle-job-status&id=<?php echo $job['job_id']; ?>&status=open'"
                                        class="flex items-center px-4 py-2 text-sm font-medium text-green-800 transition-colors border border-green-200 rounded-lg bg-green-50 hover:bg-green-100">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Resume
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

                        <!-- Application Info Bar -->
                        <div class="flex justify-between p-4 mx-4 mb-6 rounded-lg bg-gray-50">
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

                        <!-- Job Summary -->
                        <div class="mb-8">
                            <h2 class="mb-1 font-semibold text-primary text-md">Job Summary</h2>
                            <p class="text-sm font-light text-gray-600"><?php echo nl2br(htmlspecialchars($job['job_summary'])); ?></p>
                        </div>

                        <!-- Skills -->
                        <?php if (!empty($job['skills'])): ?>
                            <div class="mb-8">
                                <h2 class="mb-1 font-semibold text-primary text-md">Skills</h2>
                                <div class="flex flex-wrap gap-2">
                                    <?php
                                    $uniqueSkills = array_unique($job['skills']);
                                    foreach ($uniqueSkills as $skill):
                                    ?>
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
                                    <div class="text-xs text-gray-400">Type</div>
                                    <div class="text-sm text-primary"><?php echo ucfirst(str_replace('-', ' ', $job['job_type'])); ?></div>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-400">Location</div>
                                    <div class="text-sm text-primary"><?php echo htmlspecialchars($job['location']); ?></div>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-400">Workplace</div>
                                    <div class="text-sm text-primary"><?php echo ucfirst($job['workplace_option']); ?></div>
                                </div>
                                <?php if ($job['show_pay'] && ($job['salary'] || $job['pay_range'])): ?>
                                    <div>
                                        <div class="text-xs text-gray-400">Salary Range</div>
                                        <div class="text-sm text-primary">
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
                                    <div>
                                        <div class="text-xs text-gray-400">Pay Type</div>
                                        <div class="text-sm text-primary"><?php echo ucfirst($job['pay_type'] ?? 'Monthly'); ?></div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Full Description -->
                        <?php if ($job['full_description'] && $job['full_description'] != $job['job_summary']): ?>
                            <div class="mb-8">
                                <h2 class="mb-1 font-semibold text-primary text-md">Full Description</h2>
                                <div class="text-sm font-light text-gray-600">
                                    <?php echo nl2br(htmlspecialchars($job['full_description'])); ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Attachments -->
                        <div>
                            <h2 class="mb-1 font-semibold text-primary text-md">Attachments</h2>
                            <div class="flex items-center justify-between p-4 rounded-lg bg-gray-50">
                                <div class="flex items-center">
                                    <!-- Larger container with bigger image -->
                                    <div class="flex items-center justify-center w-12 h-12 mr-3 overflow-hidden bg-red-100 rounded-lg">
                                        <img
                                            src="../public/assets/icons/pdf-icon.png"
                                            alt="Icon"
                                            class="object-cover w-8 h-8" />
                                    </div>
                                    <div>
                                        <div class="text-sm text-primary">Attachment.pdf</div>
                                        <div class="text-xs text-gray-400">280kB</div>
                                    </div>
                                </div>
                                <button class="px-4 py-2 text-sm font-medium transition-colors rounded-lg text-primary bg-blue-50 hover:bg-blue-100">
                                    Download ↓
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Section - Sidebar (4/12 width) -->
            <div class="w-full md:w-4/12">

                <!-- Single Sidebar Card -->
                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow">
                    <!-- Application Statistics -->
                    <div class="mb-8">
                        <h3 class="mb-4 text-xl font-semibold text-gray-900">Application Statistics</h3>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-4 rounded-md bg-gray-50">
                                <span class="text-sm font-light text-gray-600">Total Applications:</span>
                                <span class="font-bold text-primary text-md"><?php echo $job['total_applications'] ?? $job['application_count'] ?? 0; ?></span>
                            </div>
                            <div class="flex items-center justify-between p-4 rounded-md bg-gray-50">
                                <span class="text-sm font-light text-gray-600">Pending Review:</span>
                                <span class="font-bold text-primary text-md"><?php echo $job['pending_count'] ?? 0; ?></span>
                            </div>
                            <div class="flex items-center justify-between p-4 rounded-md bg-gray-50">
                                <span class="text-sm font-light text-gray-600">Shortlisted:</span>
                                <span class="font-bold text-primary text-md"><?php echo $job['shortlisted_count'] ?? 0; ?></span>
                            </div>
                            <div class="flex items-center justify-between p-4 rounded-md bg-gray-50">
                                <span class="text-sm font-light text-gray-600">Hired:</span>
                                <span class="font-bold text-primary text-md"><?php echo $job['hired_count'] ?? 0; ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- Posted Date -->
                    <div class="flex justify-between mb-8">
                        <!-- Posted Date -->
                        <div class="flex-1 text-center">
                            <div class="mb-1 text-sm font-medium text-gray-500">Posted</div>
                            <div class="text-sm font-semibold text-primary">
                                <?php echo date('M j, Y', strtotime($job['created_at'])); ?>
                            </div>
                        </div>

                        <!-- Vertical Separator -->
                        <div class="self-center h-12 border-r border-gray-600"></div>

                        <!-- Last Updated -->
                        <?php if ($job['updated_at'] != $job['created_at']): ?>
                            <div class="flex-1 text-center">
                                <div class="mb-1 text-sm text-gray-500">Last Updated</div>
                                <div class="text-sm font-semibold text-primary">
                                    <?php echo date('M j, Y', strtotime($job['updated_at'])); ?>
                                </div>
                            </div>
                        <?php else: ?>
                            <!-- Empty column to maintain layout -->
                            <div class="flex-1 text-center">
                                <div class="mb-1 text-sm text-gray-500">&nbsp;</div>
                                <div class="text-sm font-semibold text-primary">&nbsp;</div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Quick Actions -->
                    <?php if (($job['total_applications'] ?? $job['application_count'] ?? 0) > 0): ?>
                        <div>
                            <button onclick="window.location.href='?page=view-all-applicants&job_id=<?php echo $job['job_id']; ?>'"
                                class="flex items-center justify-center w-full px-4 py-3 text-sm font-medium text-white transition-colors rounded-md bg-primary hover:bg-secondary">
                                View All Applications
                            </button>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>