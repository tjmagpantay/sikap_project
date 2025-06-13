<?php
// filepath: c:\xampp\htdocs\sikap\app\views\employers\post-job\post-job-step5.php

// Get full job data for review
$fullJobData = $jobData ?? [];
?>

<?php include_once __DIR__ . '/../../components/navbar-top.php';
include_once __DIR__ . '/../navbar-employer.php';
?>

<div class="min-h-screen py-12 bg-gray-50 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-4xl">
        <div class="text-center">
            <div class="flex justify-center mb-4">
                <div class="p-3 bg-green-600 rounded-full">
                    <i class="text-2xl text-white fas fa-eye"></i>
                </div>
            </div>
            <h2 class="mt-6 text-3xl font-extrabold text-center text-gray-900">
                Review Job Post
            </h2>
            <p class="mt-2 text-sm text-center text-gray-600">
                Step 5/5 - Review and Publish Your Job
            </p>
        </div>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-4xl">
        <div class="px-4 py-8 bg-white shadow sm:rounded-lg sm:px-10">
            <!-- Progress bar -->
            <div class="w-full h-2 mb-6 bg-gray-200 rounded">
                <div class="h-2 bg-green-600 rounded" style="width: 100%"></div>
            </div>

            <!-- Step Navigation -->
            <div class="mb-6">
                <nav class="flex space-x-2">
                    <a href="?page=post-job&step=1&job_id=<?php echo $job_id; ?>" class="flex-1 px-3 py-2 text-xs font-medium text-center text-green-600 bg-green-100 rounded-md hover:bg-green-200">
                        Job Details
                    </a>
                    <a href="?page=post-job&step=2&job_id=<?php echo $job_id; ?>" class="flex-1 px-3 py-2 text-xs font-medium text-center text-green-600 bg-green-100 rounded-md hover:bg-green-200">
                        Documentation
                    </a>
                    <a href="?page=post-job&step=3&job_id=<?php echo $job_id; ?>" class="flex-1 px-3 py-2 text-xs font-medium text-center text-green-600 bg-green-100 rounded-md hover:bg-green-200">
                        Screening
                    </a>
                    <a href="?page=post-job&step=4&job_id=<?php echo $job_id; ?>" class="flex-1 px-3 py-2 text-xs font-medium text-center text-green-600 bg-green-100 rounded-md hover:bg-green-200">
                        Settings
                    </a>
                    <span class="flex-1 px-3 py-2 text-xs font-medium text-center text-white bg-green-600 rounded-md">
                        Review
                    </span>
                </nav>
            </div>

            <!-- Success Messages -->
            <?php if (!empty($success)): ?>
                <div class="p-4 mb-4 border border-green-200 rounded-md bg-green-50">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="text-green-400 fas fa-check-circle"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-600"><?php echo htmlspecialchars($success); ?></p>
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
                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <h1 class="text-2xl font-bold text-gray-900 mb-2">
                                <?php echo htmlspecialchars($fullJobData['job_title'] ?? 'Job Title'); ?>
                                <?php if (($fullJobData['is_highlighted'] ?? '0') == '1'): ?>
                                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-yellow-100 text-yellow-800 ml-2">
                                        <i class="fas fa-star mr-1"></i>
                                        Highlighted
                                    </span>
                                <?php endif; ?>
                            </h1>
                            <div class="flex flex-wrap gap-4 text-sm text-gray-600 mb-4">
                                <span><i class="fas fa-building mr-1"></i><?php echo htmlspecialchars($employer['company_name'] ?? 'Your Company'); ?></span>
                                <span><i class="fas fa-map-marker-alt mr-1"></i><?php echo htmlspecialchars($fullJobData['location'] ?? ''); ?></span>
                                <span><i class="fas fa-clock mr-1"></i><?php echo ucwords(str_replace('-', ' ', $fullJobData['job_type'] ?? '')); ?></span>
                                <span><i class="fas fa-laptop mr-1"></i><?php echo ucfirst($fullJobData['workplace_option'] ?? 'onsite'); ?></span>
                            </div>
                            
                            <?php if (($fullJobData['show_pay'] ?? '1') == '1' && !empty($fullJobData['pay_range'])): ?>
                                <div class="text-lg font-semibold text-green-600 mb-2">
                                    <?php echo htmlspecialchars($fullJobData['pay_range']); ?>
                                    <?php if (!empty($fullJobData['pay_type'])): ?>
                                        <span class="text-sm text-gray-500">/ <?php echo htmlspecialchars($fullJobData['pay_type']); ?></span>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <div class="flex items-center space-x-4 text-sm">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    <?php echo htmlspecialchars($fullJobData['category_name'] ?? 'Category'); ?>
                                </span>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium 
                                    <?php 
                                    $status = $fullJobData['job_status'] ?? 'draft';
                                    switch($status) {
                                        case 'open': echo 'bg-green-100 text-green-800'; break;
                                        case 'draft': echo 'bg-gray-100 text-gray-800'; break;
                                        case 'paused': echo 'bg-yellow-100 text-yellow-800'; break;
                                        case 'closed': echo 'bg-red-100 text-red-800'; break;
                                        default: echo 'bg-gray-100 text-gray-800';
                                    }
                                    ?>">
                                    <?php echo ucfirst($status); ?>
                                </span>
                            </div>
                        </div>
                        <div class="text-right">
                            <a href="?page=post-job&step=1&job_id=<?php echo $job_id; ?>" 
                               class="text-green-600 hover:text-green-700 text-sm">
                                <i class="fas fa-edit mr-1"></i>
                                Edit Details
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Job Description -->
                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Job Description</h3>
                    
                    <?php if (!empty($fullJobData['job_summary'])): ?>
                        <div class="mb-4">
                            <h4 class="font-medium text-gray-800 mb-2">Summary</h4>
                            <p class="text-gray-600"><?php echo nl2br(htmlspecialchars($fullJobData['job_summary'])); ?></p>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($fullJobData['full_description'])): ?>
                        <div class="mb-4">
                            <h4 class="font-medium text-gray-800 mb-2">Full Description</h4>
                            <div class="text-gray-600 whitespace-pre-line"><?php echo htmlspecialchars($fullJobData['full_description']); ?></div>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($fullJobData['skills'])): ?>
                        <div>
                            <h4 class="font-medium text-gray-800 mb-2">Required Skills</h4>
                            <div class="flex flex-wrap gap-2">
                                <?php foreach ($fullJobData['skills'] as $skill): ?>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        <?php echo htmlspecialchars($skill); ?>
                                    </span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Application Information -->
                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Application Information</h3>
                    
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <h4 class="font-medium text-gray-800 mb-2">Application Period</h4>
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
                            <h4 class="font-medium text-gray-800 mb-2">Application Requirements</h4>
                            <ul class="text-sm text-gray-600 space-y-1">
                                <?php if (($fullJobData['resume_required'] ?? '1') == '1'): ?>
                                    <li><i class="fas fa-check text-green-500 mr-2"></i>Resume/CV required</li>
                                <?php endif; ?>
                                
                                <?php if (($fullJobData['allow_cover_letter'] ?? '1') == '1'): ?>
                                    <li><i class="fas fa-check text-green-500 mr-2"></i>Cover letter optional</li>
                                <?php endif; ?>
                                
                                <?php if (($fullJobData['screening_questions_enabled'] ?? '0') == '1'): ?>
                                    <li><i class="fas fa-check text-green-500 mr-2"></i>Screening questions included</li>
                                <?php endif; ?>
                                
                                <?php if (!empty($fullJobData['max_applicants'])): ?>
                                    <li><i class="fas fa-users text-blue-500 mr-2"></i>Limited to <?php echo $fullJobData['max_applicants']; ?> applicants</li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Attachments -->
                <?php if (!empty($fullJobData['attachments'])): ?>
                    <div class="bg-white border border-gray-200 rounded-lg p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Attachments</h3>
                            <a href="?page=post-job&step=2&job_id=<?php echo $job_id; ?>" 
                               class="text-green-600 hover:text-green-700 text-sm">
                                <i class="fas fa-edit mr-1"></i>
                                Edit
                            </a>
                        </div>
                        <div class="space-y-2">
                            <?php foreach ($fullJobData['attachments'] as $attachment): ?>
                                <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                    <i class="fas fa-file text-gray-400 mr-3"></i>
                                    <span class="text-sm text-gray-700 flex-1">
                                        <?php echo htmlspecialchars(basename($attachment['file_path'])); ?>
                                    </span>
                                    <a href="<?php echo htmlspecialchars($attachment['file_path']); ?>" 
                                       target="_blank"
                                       class="text-green-600 hover:text-green-700">
                                        <i class="fas fa-external-link-alt"></i>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Screening Questions -->
                <?php if (!empty($fullJobData['screening_questions'])): ?>
                    <div class="bg-white border border-gray-200 rounded-lg p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Screening Questions</h3>
                            <a href="?page=post-job&step=3&job_id=<?php echo $job_id; ?>" 
                               class="text-green-600 hover:text-green-700 text-sm">
                                <i class="fas fa-edit mr-1"></i>
                                Edit
                            </a>
                        </div>
                        <div class="space-y-4">
                            <?php foreach ($fullJobData['screening_questions'] as $index => $question): ?>
                                <div class="border-l-4 border-green-500 pl-4">
                                    <p class="font-medium text-gray-800">Q<?php echo $index + 1; ?>: <?php echo htmlspecialchars($question['question_text']); ?></p>
                                    <p class="text-sm text-gray-600 mt-1">
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
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-triangle text-yellow-400"></i>
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

                        <div class="flex space-x-3">
                            <button type="submit" name="save_draft" 
                                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                <i class="mr-2 fas fa-save"></i>
                                Save as Draft
                            </button>
                            <button type="submit" name="publish_job"
                                    class="inline-flex items-center px-6 py-3 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md hover:bg-green-700">
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