<?php
// Get full job data for review
$fullJobData = $jobData ?? [];
include_once __DIR__ . '/../components/employer_auth_check.php';
include_once __DIR__ . '/../../components/navbar-top.php';
include_once __DIR__ . '/../components/navbar-employer.php';
?>

<div class="min-h-screen py-6">
    <div class="sm:mx-auto sm:w-full sm:max-w-4xl">
        <div class="text-center">
            <h2 class="mt-2 text-3xl font-extrabold text-center text-grayMain">
                Review & Publish Job Post
            </h2>
            <p class="mt-2 text-sm text-center text-gray-500">
                Review all information before publishing your job posting
            </p>
        </div>
    </div>

    <div class="mt-4 sm:mx-auto sm:w-full sm:max-w-2xl">
        <div class="px-4 py-8 bg-white shadow sm:rounded-lg sm:px-10">
            <!-- Progress bar with steps -->
            <div class="mb-6">
                <!-- Step indicators -->
                <div class="flex items-center justify-between w-full mb-4">
                    <!-- Step 1 -->
                    <div class="flex flex-col items-center">
                        <a href="?page=post-job&step=1&job_id=<?php echo $job_id; ?>" class="flex items-center justify-center w-8 h-8 text-gray-500 transition-colors bg-gray-200 rounded-full hover:bg-gray-300 hover:text-gray-700">
                            <span class="text-sm font-semibold">1</span>
                        </a>
                        <span class="mt-1 text-xs text-gray-500">Job Details</span>
                    </div>

                    <!-- Step 2 -->
                    <div class="flex flex-col items-center">
                        <a href="?page=post-job&step=2&job_id=<?php echo $job_id; ?>" class="flex items-center justify-center w-8 h-8 text-gray-500 transition-colors bg-gray-200 rounded-full hover:bg-gray-300 hover:text-gray-700">
                            <span class="text-sm font-semibold">2</span>
                        </a>
                        <span class="mt-1 text-xs text-gray-500">Attachments</span>
                    </div>

                    <!-- Step 3 -->
                    <div class="flex flex-col items-center">
                        <a href="?page=post-job&step=3&job_id=<?php echo $job_id; ?>" class="flex items-center justify-center w-8 h-8 text-gray-500 transition-colors bg-gray-200 rounded-full hover:bg-gray-300 hover:text-gray-700">
                            <span class="text-sm font-semibold">3</span>
                        </a>
                        <span class="mt-1 text-xs text-gray-500">Questions</span>
                    </div>

                    <!-- Step 4 -->
                    <div class="flex flex-col items-center">
                        <a href="?page=post-job&step=4&job_id=<?php echo $job_id; ?>" class="flex items-center justify-center w-8 h-8 text-gray-500 transition-colors bg-gray-200 rounded-full hover:bg-gray-300 hover:text-gray-700">
                            <span class="text-sm font-semibold">4</span>
                        </a>
                        <span class="mt-1 text-xs text-gray-500">Settings</span>
                    </div>

                    <!-- Step 5 -->
                    <div class="flex flex-col items-center">
                        <div class="flex items-center justify-center w-8 h-8 text-white rounded-full bg-primary">
                            <span class="text-sm font-semibold">5</span>
                        </div>
                        <span class="mt-1 text-xs text-gray-600">Review</span>
                    </div>
                </div>

                <!-- Progress bar -->
                <div class="w-full h-2 bg-gray-200 rounded">
                    <div class="h-2 rounded bg-primary" style="width: 100%"></div>
                </div>
            </div>

            <!-- Error Messages -->
            <?php if (!empty($error)): ?>
                <div class="p-4 mb-4 border border-red-200 rounded-md bg-red-50">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-600"><?php echo htmlspecialchars($error); ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Success Messages -->
            <?php if (!empty($success)): ?>
                <div class="p-4 mb-4 border border-green-200 rounded-md bg-green-50">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-600"><?php echo htmlspecialchars($success); ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="space-y-6">
                <!-- Job Header Summary -->
                <div class="p-4 border border-gray-200 rounded-lg">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="flex items-center text-base font-semibold text-gray-900">
                            Job Information
                        </h3>
                        <a href="?page=post-job&step=1&job_id=<?php echo $job_id; ?>" class="text-sm font-medium text-primary hover:text-blue-700">
                            Edit
                        </a>
                    </div>
                    <div class="grid grid-cols-1 gap-2 md:grid-cols-2">
                        <div class="p-3 bg-white rounded-md">
                            <span class="text-xs font-medium tracking-wider text-gray-500 uppercase">Job Title</span>
                            <p class="mt-1 text-sm text-grayMain">
                                <?php echo htmlspecialchars($fullJobData['job_title'] ?? 'Job Title'); ?>
                                <?php if (($fullJobData['is_highlighted'] ?? '0') == '1'): ?>
                                    <span class="inline-flex items-center px-2 py-1 ml-2 text-xs font-medium text-yellow-800 bg-yellow-100 rounded">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        Highlighted
                                    </span>
                                <?php endif; ?>
                            </p>
                        </div>
                        <div class="p-3 bg-white rounded-md">
                            <span class="text-xs font-medium tracking-wider text-gray-500 uppercase">Company</span>
                            <p class="mt-1 text-sm text-grayMain"><?php echo htmlspecialchars($employer['company_name'] ?? 'Your Company'); ?></p>
                        </div>
                        <div class="p-3 bg-white rounded-md">
                            <span class="text-xs font-medium tracking-wider text-gray-500 uppercase">Location</span>
                            <p class="mt-1 text-sm text-grayMain"><?php echo htmlspecialchars($fullJobData['location'] ?? 'N/A'); ?></p>
                        </div>
                        <div class="p-3 bg-white rounded-md">
                            <span class="text-xs font-medium tracking-wider text-gray-500 uppercase">Job Type</span>
                            <p class="mt-1 text-sm text-grayMain"><?php echo ucwords(str_replace('-', ' ', $fullJobData['job_type'] ?? '')); ?></p>
                        </div>
                        <div class="p-3 bg-white rounded-md">
                            <span class="text-xs font-medium tracking-wider text-gray-500 uppercase">Work Option</span>
                            <p class="mt-1 text-sm text-grayMain"><?php echo ucfirst($fullJobData['workplace_option'] ?? 'onsite'); ?></p>
                        </div>
                        <div class="p-3 bg-white rounded-md">
                            <span class="text-xs font-medium tracking-wider text-gray-500 uppercase">Category</span>
                            <p class="mt-1 text-sm text-grayMain"><?php echo htmlspecialchars($fullJobData['category_name'] ?? 'Category'); ?></p>
                        </div>
                    </div>

                    <?php if (!empty($fullJobData['pay_range']) || !empty($fullJobData['pay_type'])): ?>
                        <div class="p-3 mb-3 rounded-md bg-blue-50">
                            <span class="text-xs font-medium tracking-wider text-gray-500 uppercase">Salary Information</span>
                            <?php if (($fullJobData['show_pay'] ?? '1') == '1'): ?>
                                <p class="mt-1 text-sm font-semibold text-primary">
                                    <?php echo htmlspecialchars($fullJobData['pay_range']); ?>
                                    <?php if (!empty($fullJobData['pay_type'])): ?>
                                        <span class="text-sm text-gray-600">/ <?php echo htmlspecialchars($fullJobData['pay_type']); ?></span>
                                    <?php endif; ?>
                                </p>
                                <p class="text-xs text-gray-500">Visible to applicants</p>
                            <?php else: ?>
                                <p class="mt-1 text-sm text-gray-600">
                                    Competitive Salary <span class="text-xs text-gray-400">(Hidden from applicants)</span>
                                </p>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($fullJobData['skills'])): ?>
                        <div class="py-3">
                            <span class="text-xs font-medium tracking-wider text-gray-500 uppercase">Required Skills</span>
                            <div class="flex flex-wrap gap-2 mt-2">
                                <?php foreach ($fullJobData['skills'] as $skill): ?>
                                    <span class="inline-flex items-center px-3 py-1 text-sm bg-gray-100">
                                        <span class="text-sm text-grayMain"><?php echo htmlspecialchars($skill); ?></span>
                                    </span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($fullJobData['min_age']) || !empty($fullJobData['max_age'])): ?>
                        <div class="py-3">
                            <span class="text-xs font-medium tracking-wider text-gray-500 uppercase">Age Requirement</span>
                            <div class="flex flex-wrap gap-2 mt-2">
                                <?php if (!empty($fullJobData['min_age']) && !empty($fullJobData['max_age'])): ?>
                                    <span class="inline-flex items-center px-3 py-1 text-sm bg-gray-100">
                                        <span class="text-sm text-grayMain">
                                            Between <?php echo $fullJobData['min_age']; ?> and <?php echo $fullJobData['max_age']; ?> years old
                                        </span>
                                    </span>
                                <?php elseif (!empty($fullJobData['min_age'])): ?>
                                    <span class="inline-flex items-center px-3 py-1 text-sm bg-gray-100">
                                        <span class="text-sm text-grayMain">
                                            Minimum <?php echo $fullJobData['min_age']; ?> years old
                                        </span>
                                    </span>
                                <?php elseif (!empty($fullJobData['max_age'])): ?>
                                    <span class="inline-flex items-center px-3 py-1 text-sm bg-gray-100">
                                        <span class="text-sm text-grayMain">
                                            Maximum <?php echo $fullJobData['max_age']; ?> years old
                                        </span>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>

                <!-- Job Description Summary -->
                <div class="p-4 border border-gray-200 rounded-lg">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="flex items-center text-base font-semibold text-gray-900">
                            Job Description
                        </h3>
                        <a href="?page=post-job&step=1&job_id=<?php echo $job_id; ?>" class="text-sm font-medium text-primary hover:text-blue-700">
                            Edit
                        </a>
                    </div>

                    <?php if (!empty($fullJobData['job_summary'])): ?>
                        <div class="p-3 bg-white rounded-md">
                            <span class="text-xs font-medium tracking-wider text-gray-500 uppercase">Summary</span>
                            <p class="mt-1 text-sm text-grayMain"><?php echo nl2br(htmlspecialchars($fullJobData['job_summary'])); ?></p>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($fullJobData['full_description'])): ?>
                        <div class="p-3 mt-3 bg-white rounded-md">
                            <span class="text-xs font-medium tracking-wider text-gray-500 uppercase">Full Description</span>
                            <div class="mt-1 text-sm whitespace-pre-line text-grayMain"><?php echo htmlspecialchars($fullJobData['full_description']); ?></div>
                        </div>
                    <?php else: ?>
                        <p class="p-3 text-sm text-gray-600 bg-white rounded-md">No detailed description provided.</p>
                    <?php endif; ?>
                </div>

                <!-- Application Settings Summary -->
                <div class="p-4 border border-gray-200 rounded-lg">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="flex items-center text-base font-semibold text-gray-900">
                            Application Settings
                        </h3>
                        <a href="?page=post-job&step=4&job_id=<?php echo $job_id; ?>" class="text-sm font-medium text-primary hover:text-blue-700">
                            Edit
                        </a>
                    </div>
                    <div class="grid grid-cols-1 gap-3 md:grid-cols-2">
                        <div class="py-3 bg-white rounded-md ">
                            <span class="text-xs font-medium tracking-wider text-gray-500 uppercase">Application Start</span>
                            <p class="mt-1 text-sm text-grayMain">
                                <?php echo date('M j, Y g:i A', strtotime($fullJobData['application_start'] ?? 'now')); ?>
                            </p>
                        </div>
                        <div class="py-3 bg-white rounded-md">
                            <span class="text-xs font-medium tracking-wider text-gray-500 uppercase">Application Deadline</span>
                            <p class="mt-1 text-sm text-grayMain">
                                <?php if (!empty($fullJobData['application_deadline'])): ?>
                                    <?php echo date('M j, Y g:i A', strtotime($fullJobData['application_deadline'])); ?>
                                <?php else: ?>
                                    No deadline set
                                <?php endif; ?>
                            </p>
                        </div>
                        <?php if (!empty($fullJobData['max_applicants'])): ?>
                            <div class="p-3 bg-white rounded-md">
                                <span class="text-xs font-medium tracking-wider text-gray-500 uppercase">Maximum Applicants</span>
                                <p class="mt-1 text-sm text-grayMain"><?php echo $fullJobData['max_applicants']; ?> applicants</p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="mt-3">
                        <span class="text-xs font-medium tracking-wider text-gray-500 uppercase">Requirements</span>
                        <div class="flex flex-wrap gap-2 mt-2">
                            <?php if (($fullJobData['resume_required'] ?? '1') == '1'): ?>
                                <span class="inline-flex items-center px-3 py-1 text-sm bg-blue-100 text-primary">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                    Resume Required
                                </span>
                            <?php endif; ?>
                            <?php if (($fullJobData['allow_cover_letter'] ?? '1') == '1'): ?>
                                <span class="inline-flex items-center px-3 py-1 text-sm text-blue-800 bg-blue-100">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                    Cover Letter Optional
                                </span>
                            <?php endif; ?>
                            <?php if (($fullJobData['screening_questions_enabled'] ?? '0') == '1'): ?>
                                <span class="inline-flex items-center px-3 py-1 text-sm text-purple-800 bg-purple-100">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                    Screening Questions
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Attachments Summary -->
                <?php if (!empty($fullJobData['attachments'])): ?>
                    <div class="p-4 border border-gray-200 rounded-lg">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="flex items-center text-base font-semibold text-gray-900">
                                Attachments
                                <span class="ml-2 text-xs font-light text-gray-400">(<?php echo count($fullJobData['attachments']); ?> files)</span>
                            </h3>
                            <a href="?page=post-job&step=2&job_id=<?php echo $job_id; ?>" class="text-sm font-medium text-primary hover:text-blue-700">
                                Edit
                            </a>
                        </div>
                        <div class="space-y-2">
                            <?php foreach ($fullJobData['attachments'] as $attachment): ?>
                                <div class="p-3 bg-white border rounded-md">
                                    <div class="flex items-center">
                                        <div class="flex items-center justify-center w-12 h-12 mr-3 bg-blue-100 rounded-md hover:bg-blue-200">
                                            <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars(basename($attachment['file_path'])); ?></p>
                                        </div>
                                        <a href="<?php echo htmlspecialchars($attachment['file_path']); ?>"
                                            target="_blank"
                                            class="text-primary hover:text-blue-700">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M11 3a1 1 0 100 2h2.586l-6.293 6.293a1 1 0 101.414 1.414L15 6.414V9a1 1 0 102 0V4a1 1 0 00-1-1h-5z" />
                                                <path d="M5 5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-3a1 1 0 10-2 0v3H5V7h3a1 1 0 000-2H5z" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Screening Questions Summary -->
                <?php if (!empty($fullJobData['screening_questions'])): ?>
                    <div class="p-4 border border-gray-200 rounded-lg">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="flex items-center text-base font-semibold text-gray-900">
                                Screening Questions
                                <span class="ml-2 text-xs font-light text-gray-400">(<?php echo count($fullJobData['screening_questions']); ?> questions)</span>
                            </h3>
                            <a href="?page=post-job&step=3&job_id=<?php echo $job_id; ?>" class="text-sm font-medium text-primary hover:text-blue-700">
                                Edit
                            </a>
                        </div>
                        <div class="space-y-3">
                            <?php foreach ($fullJobData['screening_questions'] as $index => $question): ?>
                                <div class="p-3 bg-white border-l-4 border-blue-500 rounded-md">
                                    <div class="grid grid-cols-1 gap-2">
                                        <div>
                                            <span class="text-xs font-medium tracking-wider text-gray-500 uppercase">Question <?php echo $index + 1; ?></span>
                                            <p class="mt-1 text-sm text-grayMain"><?php echo htmlspecialchars($question['question_text']); ?></p>
                                        </div>
                                        <div>
                                            <span class="text-xs font-medium tracking-wider text-gray-500 uppercase">Type</span>
                                            <p class="mt-1 text-sm text-grayMain">
                                                <?php echo ucfirst($question['question_type']); ?>
                                                <?php if (!empty($question['question_option'])): ?>
                                                    <span class="ml-2 text-xs text-gray-500">Options: <?php echo htmlspecialchars($question['question_option']); ?></span>
                                                <?php endif; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                // Show only first 3 questions to avoid cluttering
                                if ($index >= 2) {
                                    if (count($fullJobData['screening_questions']) > 3) {
                                        echo '<p class="p-2 text-xs text-center text-gray-500">... and ' . (count($fullJobData['screening_questions']) - 3) . ' more question(s)</p>';
                                    }
                                    break;
                                }
                                ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Final Actions -->
            <form method="POST" action="?page=post-job&step=5&job_id=<?php echo $job_id; ?>" class="mt-8">
                <!-- Ready to Publish Alert -->
                <div class="p-4 mb-6 border border-blue-200 rounded-md bg-blue-50">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-primary">
                                Ready to publish?
                            </h3>
                            <div class="mt-2 text-sm text-primary">
                                <p>Once published, your job will be visible to all job seekers. You can edit or pause it later if needed.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-end justify-between">
                    <a href="?page=post-job&step=4&job_id=<?php echo $job_id; ?>"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Previous Step
                    </a>

                    <div class="flex gap-3">
                        <button type="submit" name="save_draft"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">
                            Save as Draft
                        </button>
                        <button type="submit" name="publish_job"
                            class="inline-flex px-6 py-3 text-sm font-medium text-white transition-colors border border-transparent rounded-md shadow-sm bg-primary hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" />
                            </svg>
                            Publish Job Post
                        </button>
                    </div>
                </div>
            </form>
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