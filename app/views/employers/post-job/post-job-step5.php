<?php
// Get full job data for review
$fullJobData = $jobData ?? [];
include_once __DIR__ . '/../components/employer_auth_check.php';
include_once __DIR__ . '/../../components/navbar-top.php';
include_once __DIR__ . '/../components/navbar-employer.php';
?>

<div class="flex flex-col items-center min-h-screen py-12 bg-gray-50">
    <div class="w-full max-w-2xl px-4 mx-auto sm:px-8 lg:px-32 xl:px-64">
        <!-- Header -->
        <div class="mb-8 text-center">
            <div class="flex justify-center mb-4">
                <div class="p-3 rounded-full bg-primary">
                    <i class="text-2xl text-white fas fa-eye"></i>
                </div>
            </div>
            <h2 class="text-3xl font-extrabold font-inter text-primary">Review Job Post</h2>
            <p class="mt-2 text-sm font-inter text-primary">Step 5 of 5 – Review and Publish Your Job</p>
        </div>

        <!-- Progress Bar -->
        <div class="flex items-center justify-between mb-10">
            <?php
            $steps = [
                'Job Details',
                'Attachments',
                'Questions',
                'Settings',
                'Review'
            ];
            $currentStep = 5;
            foreach ($steps as $i => $label): ?>
                <div class="flex flex-col items-center flex-1 min-w-[100px] shrink-0">
                    <div class="w-12 h-2 rounded <?php echo ($i + 1) === $currentStep ? 'bg-primary' : 'bg-gray-300'; ?>"></div>
                    <span class="font-inter text-xs mt-2 <?php echo ($i + 1) === $currentStep ? 'font-bold text-primary' : 'text-gray-400'; ?>">
                        <?php echo $label; ?>
                    </span>
                </div>
                <?php if ($i < count($steps) - 1): ?>
                    <div class="flex-1 h-3 bg-gray-200"></div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

        <!-- Success Messages -->
        <?php if (!empty($success)): ?>
            <div class="p-4 mt-6 mb-4 border border-blue-200 rounded-md bg-blue-50">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="text-blue-400 fas fa-check-circle"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-blue-600"><?php echo htmlspecialchars($success); ?></p>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Error Messages -->
        <?php if (!empty($error)): ?>
            <div class="p-4 mb-4 border border-red-200 rounded-md bg-red-50">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="text-red-400 fas fa-exclamation-circle"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-600"><?php echo htmlspecialchars($error); ?></p>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Job Preview -->
        <div class="space-y-6">
            <!-- Job Header -->
            <div class="p-6 bg-white border border-gray-200 rounded-lg">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <h1 class="mb-2 text-2xl font-bold text-gray-900">
                            <?php echo htmlspecialchars($fullJobData['job_title'] ?? 'Job Title'); ?>
                            <?php if (($fullJobData['is_highlighted'] ?? '0') == '1'): ?>
                                <span class="inline-flex items-center px-2 py-1 ml-2 text-xs font-medium text-yellow-800 bg-yellow-100 rounded">
                                    <i class="mr-1 fas fa-star"></i>
                                    Highlighted
                                </span>
                            <?php endif; ?>
                        </h1>
                        <div class="flex flex-wrap gap-4 mb-4 text-sm text-gray-600">
                            <span><i class="mr-1 fas fa-building"></i><?php echo htmlspecialchars($employer['company_name'] ?? 'Your Company'); ?></span>
                            <span><i class="mr-1 fas fa-map-marker-alt"></i><?php echo htmlspecialchars($fullJobData['location'] ?? ''); ?></span>
                            <span><i class="mr-1 fas fa-clock"></i><?php echo ucwords(str_replace('-', ' ', $fullJobData['job_type'] ?? '')); ?></span>
                            <span><i class="mr-1 fas fa-laptop"></i><?php echo ucfirst($fullJobData['workplace_option'] ?? 'onsite'); ?></span>
                        </div>
                        <?php if (!empty($fullJobData['pay_range']) || !empty($fullJobData['pay_type'])): ?>
                            <?php if (($fullJobData['show_pay'] ?? '1') == '1'): ?>
                                <div class="mb-2 text-lg font-semibold text-primary">
                                    <?php echo htmlspecialchars($fullJobData['pay_range']); ?>
                                    <?php if (!empty($fullJobData['pay_type'])): ?>
                                        <span class="text-sm text-gray-500">/ <?php echo htmlspecialchars($fullJobData['pay_type']); ?></span>
                                    <?php endif; ?>
                                </div>
                            <?php else: ?>
                                <div class="mb-2 text-lg font-semibold text-gray-500">
                                    Competitive Salary
                                    <span class="text-xs text-gray-400">(Pay details hidden)</span>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                        <div class="flex items-center space-x-4 text-sm">
                            <span class="inline-flex items-center px-3 py-1 text-xs font-medium text-blue-800 bg-blue-100 rounded-full">
                                <?php echo htmlspecialchars($fullJobData['category_name'] ?? 'Category'); ?>
                            </span>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium 
                                <?php
                                $status = $fullJobData['job_status'] ?? 'draft';
                                switch ($status) {
                                    case 'open':
                                        echo 'bg-blue-100 text-blue-800';
                                        break;
                                    case 'draft':
                                        echo 'bg-gray-100 text-gray-800';
                                        break;
                                    case 'paused':
                                        echo 'bg-yellow-100 text-yellow-800';
                                        break;
                                    case 'closed':
                                        echo 'bg-red-100 text-red-800';
                                        break;
                                    default:
                                        echo 'bg-gray-100 text-gray-800';
                                }
                                ?>">
                                <?php echo ucfirst($status); ?>
                            </span>
                        </div>
                    </div>
                    <div class="text-right">
                        <a href="?page=post-job&step=1&job_id=<?php echo $job_id; ?>"
                            class="text-sm text-primary hover:text-blue-700">
                            <i class="mr-1 fas fa-edit"></i>
                            Edit Details
                        </a>
                    </div>
                </div>
            </div>

            <!-- Job Description -->
            <div class="p-6 bg-white border border-gray-200 rounded-lg">
                <h3 class="mb-4 text-lg font-medium text-gray-900">Job Description</h3>
                <?php if (!empty($fullJobData['job_summary'])): ?>
                    <div class="mb-4">
                        <h4 class="mb-2 font-medium text-gray-800">Summary</h4>
                        <p class="text-gray-600"><?php echo nl2br(htmlspecialchars($fullJobData['job_summary'])); ?></p>
                    </div>
                <?php endif; ?>
                <?php if (!empty($fullJobData['full_description'])): ?>
                    <div class="mb-4">
                        <h4 class="mb-2 font-medium text-gray-800">Full Description</h4>
                        <div class="text-gray-600 whitespace-pre-line"><?php echo htmlspecialchars($fullJobData['full_description']); ?></div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($fullJobData['skills'])): ?>
                    <div>
                        <h4 class="mb-2 font-medium text-gray-800">Required Skills</h4>
                        <div class="flex flex-wrap gap-2">
                            <?php foreach ($fullJobData['skills'] as $skill): ?>
                                <span class="inline-flex items-center px-3 py-1 text-xs font-medium text-gray-800 bg-gray-100 rounded-full">
                                    <?php echo htmlspecialchars($skill); ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Application Information -->
            <div class="p-6 bg-white border border-gray-200 rounded-lg">
                <h3 class="mb-4 text-lg font-medium text-gray-900">Application Information</h3>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <h4 class="mb-2 font-medium text-gray-800">Application Period</h4>
                        <p class="text-sm text-gray-600">
                            <strong>Start:</strong> <?php echo date('M j, Y g:i A', strtotime($fullJobData['application_start'] ?? 'now')); ?>
                        </p>
                        <?php if (!empty($fullJobData['application_deadline'])): ?>
                            <p class="text-sm text-gray-600">
                                <strong>Deadline:</strong> <?php echo date('M j, Y g:i A', strtotime($fullJobData['application_deadline'])); ?>
                            </p>
                        <?php else: ?>
                            <p class="text-sm text-gray-600">
                                <strong>Deadline:</strong> No deadline set
                            </p>
                        <?php endif; ?>
                    </div>
                    <div>
                        <h4 class="mb-2 font-medium text-gray-800">Application Requirements</h4>
                        <ul class="space-y-1 text-sm text-gray-600">
                            <?php if (($fullJobData['resume_required'] ?? '1') == '1'): ?>
                                <li><i class="mr-2 text-blue-500 fas fa-check"></i>Resume/CV required</li>
                            <?php endif; ?>
                            <?php if (($fullJobData['allow_cover_letter'] ?? '1') == '1'): ?>
                                <li><i class="mr-2 text-blue-500 fas fa-check"></i>Cover letter optional</li>
                            <?php endif; ?>
                            <?php if (($fullJobData['screening_questions_enabled'] ?? '0') == '1'): ?>
                                <li><i class="mr-2 text-blue-500 fas fa-check"></i>Screening questions included</li>
                            <?php endif; ?>
                            <?php if (!empty($fullJobData['max_applicants'])): ?>
                                <li><i class="mr-2 text-blue-500 fas fa-users"></i>Limited to <?php echo $fullJobData['max_applicants']; ?> applicants</li>
                            <?php endif; ?>

                            <!-- Pay Visibility Status -->
                            <li>
                                <i class="mr-2 <?php echo (($fullJobData['show_pay'] ?? '1') == '1') ? 'text-green-500 fas fa-eye' : 'text-gray-400 fas fa-eye-slash'; ?>"></i>
                                Salary information: <?php echo (($fullJobData['show_pay'] ?? '1') == '1') ? 'Visible to applicants' : 'Hidden from applicants'; ?>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Attachments -->
            <?php if (!empty($fullJobData['attachments'])): ?>
                <div class="p-6 bg-white border border-gray-200 rounded-lg">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Attachments</h3>
                        <a href="?page=post-job&step=2&job_id=<?php echo $job_id; ?>"
                            class="text-sm text-primary hover:text-blue-700">
                            <i class="mr-1 fas fa-edit"></i>
                            Edit
                        </a>
                    </div>
                    <div class="space-y-2">
                        <?php foreach ($fullJobData['attachments'] as $attachment): ?>
                            <div class="flex items-center p-3 rounded-lg bg-gray-50">
                                <i class="mr-3 text-gray-400 fas fa-file"></i>
                                <span class="flex-1 text-sm text-gray-700">
                                    <?php echo htmlspecialchars(basename($attachment['file_path'])); ?>
                                </span>
                                <a href="<?php echo htmlspecialchars($attachment['file_path']); ?>"
                                    target="_blank"
                                    class="text-primary hover:text-blue-700">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Screening Questions -->
            <?php if (!empty($fullJobData['screening_questions'])): ?>
                <div class="p-6 bg-white border border-gray-200 rounded-lg">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Screening Questions</h3>
                        <a href="?page=post-job&step=3&job_id=<?php echo $job_id; ?>"
                            class="text-sm text-primary hover:text-blue-700">
                            <i class="mr-1 fas fa-edit"></i>
                            Edit
                        </a>
                    </div>
                    <div class="space-y-4">
                        <?php foreach ($fullJobData['screening_questions'] as $index => $question): ?>
                            <div class="pl-4 border-l-4 border-blue-500">
                                <p class="font-medium text-gray-800">Q<?php echo $index + 1; ?>: <?php echo htmlspecialchars($question['question_text']); ?></p>
                                <p class="mt-1 text-sm text-gray-600">
                                    Type: <?php echo ucfirst($question['question_type']); ?>
                                    <?php if (!empty($question['question_option'])): ?>
                                        | Options: <?php echo htmlspecialchars($question['question_option']); ?>
                                    <?php endif; ?>
                                </p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Final Actions -->
            <form method="POST" action="?page=post-job&step=5&job_id=<?php echo $job_id; ?>">
                <div class="p-4 mb-6 border border-yellow-200 rounded-lg bg-yellow-50">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="text-yellow-400 fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-yellow-800">
                                Ready to publish?
                            </h3>
                            <div class="mt-2 text-sm text-yellow-700">
                                <p>Once published, your job will be visible to all job seekers. You can edit or pause it later if needed.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-between pt-6">
                    <a href="?page=post-job&step=4&job_id=<?php echo $job_id; ?>"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                        <i class="mr-2 fas fa-arrow-left"></i>
                        Previous Step
                    </a>

                    <div class="flex gap-2 space-x-3">
                        <button type="submit" name="save_draft"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                            <i class="mr-2 fas fa-save"></i>
                            Save as Draft
                        </button>
                        <button type="submit" name="publish_job"
                            class="inline-flex items-center px-6 py-3 text-sm font-medium text-white border border-transparent rounded-md bg-primary hover:bg-blue-700">
                            <i class="mr-2 fas fa-rocket"></i>
                            Publish Job Post
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>

<script>
    // Confirmation for publishing
    document.querySelector('button[name="publish_job"]').addEventListener('click', function(e) {
        if (!confirm('Are you sure you want to publish this job? It will become visible to all job seekers.')) {
            e.preventDefault();
        }
    });
</script>