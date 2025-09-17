<?php
include_once __DIR__ . '/../components/employer_auth_check.php';
include_once __DIR__ . '/../../components/navbar-top.php';
include_once __DIR__ . '/../components/navbar-employer.php';

// Get existing settings if editing
$settings = [];
if ($job_id) {
    $settings = $this->jobPostModel->getApplicationSettings($job_id);
}

// Check if there are screening questions
$hasQuestions = !empty($screeningQuestions);
?>

<div class="min-h-screen py-6">
    <div class="sm:mx-auto sm:w-full sm:max-w-2xl">
        <div class="text-center">
            <h2 class="mt-2 text-3xl font-extrabold text-center text-grayMain">
                Post a New Job
            </h2>
            <p class="mt-2 text-sm text-center text-gray-500">
                Configure application requirements and settings
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
                        <a href="?page=post-job&step=1&job_id=<?php echo $job_id; ?>" class="flex items-center justify-center w-8 h-8 text-white transition-colors rounded-full bg-primary hover:bg-blue-700">
                            <span class="text-sm font-semibold">1</span>
                        </a>
                        <span class="mt-1 text-xs text-gray-600">Job Details</span>
                    </div>

                    <!-- Step 2 -->
                    <div class="flex flex-col items-center">
                        <a href="?page=post-job&step=2&job_id=<?php echo $job_id; ?>" class="flex items-center justify-center w-8 h-8 text-white transition-colors rounded-full bg-primary hover:bg-blue-700">
                            <span class="text-sm font-semibold">2</span>
                        </a>
                        <span class="mt-1 text-xs text-gray-600">Attachments</span>
                    </div>

                    <!-- Step 3 -->
                    <div class="flex flex-col items-center">
                        <a href="?page=post-job&step=3&job_id=<?php echo $job_id; ?>" class="flex items-center justify-center w-8 h-8 text-white transition-colors rounded-full bg-primary hover:bg-blue-700">
                            <span class="text-sm font-semibold">3</span>
                        </a>
                        <span class="mt-1 text-xs text-gray-600">Questions</span>
                    </div>

                    <!-- Step 4 -->
                    <div class="flex flex-col items-center">
                        <div class="flex items-center justify-center w-8 h-8 text-white rounded-full bg-primary">
                            <span class="text-sm font-semibold">4</span>
                        </div>
                        <span class="mt-1 text-xs text-gray-600">Settings</span>
                    </div>

                    <!-- Step 5 -->
                    <div class="flex flex-col items-center">
                        <div class="flex items-center justify-center w-8 h-8 text-gray-500 bg-gray-200 rounded-full">
                            <span class="text-sm font-semibold">5</span>
                        </div>
                        <span class="mt-1 text-xs text-gray-500">Review</span>
                    </div>
                </div>

                <!-- Progress bar -->
                <div class="w-full h-2 bg-gray-200 rounded">
                    <div class="h-2 rounded bg-primary" style="width: 80%"></div>
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
                <div class="p-4 mb-4 border border-blue-200 rounded-md bg-blue-50">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-primary"><?php echo htmlspecialchars($success); ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Settings Form -->
            <form class="space-y-6 font-inter" method="POST" action="?page=post-job&step=4&job_id=<?php echo $job_id; ?>">

                <!-- Pay Visibility Section -->
                <div>
                    <h3 class="mb-2 font-medium text-md text-primary">Salary Information Display</h3>

                    <?php if (!empty($jobData['pay_range']) || !empty($jobData['pay_type'])): ?>
                        <div class="p-4 mb-4 border border-blue-200 rounded-lg bg-blue-50">
                            <h4 class="mb-2 text-sm font-medium text-primary">Current Pay Information:</h4>
                            <div class="text-sm text-blue-700">
                                <?php if (!empty($jobData['pay_range'])): ?>
                                    <p><span class="text-primary">Pay Range: </span><?php echo htmlspecialchars($jobData['pay_range']); ?></p>
                                <?php endif; ?>
                                <?php if (!empty($jobData['pay_type'])): ?>
                                    <p><span class="text-primary">Pay Type: </span><?php echo ucfirst($jobData['pay_type']); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50">
                                <input id="show_pay" name="show_pay" type="checkbox"
                                    <?php echo (($settings['show_pay'] ?? $jobData['show_pay'] ?? '1') == '1') ? 'checked' : ''; ?>
                                    class="w-4 h-4 border-gray-300 rounded text-primary focus:ring-primary">
                                <label for="show_pay" class="ml-3 text-sm text-gray-600">
                                    Display salary information to job seekers
                                </label>
                            </div>
                            <p class="text-xs text-gray-500 ml-7">
                                When enabled, job seekers will see the pay range and pay type. When disabled, salary information will be hidden and marked as "Competitive" or "Negotiable".
                            </p>
                        </div>
                    <?php else: ?>
                        <div class="p-4 border border-yellow-200 rounded-lg bg-yellow-50">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-xs text-yellow-700">
                                        No salary information was provided in the job details. You can go back to Step 1 to add pay range and type.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <!-- Hidden field to maintain current show_pay value -->
                        <input type="hidden" name="show_pay" value="<?php echo ($jobData['show_pay'] ?? '0'); ?>">
                    <?php endif; ?>
                </div>

                <!-- Application Requirements -->
                <div>
                    <h3 class="mb-2 font-medium text-md text-primary">Application Requirements</h3>

                    <div class="space-y-3">
                        <div class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50">
                            <input id="resume_required" name="resume_required" type="checkbox"
                                <?php echo (($settings['resume_required'] ?? '1') == '1') ? 'checked' : ''; ?>
                                class="w-4 h-4 border-gray-300 rounded text-primary focus:ring-primary">
                            <label for="resume_required" class="ml-3 text-sm font-medium text-gray-700">
                                Require resume/CV upload
                            </label>
                        </div>

                        <div class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50">
                            <input id="allow_cover_letter" name="allow_cover_letter" type="checkbox"
                                <?php echo (($settings['allow_cover_letter'] ?? '1') == '1') ? 'checked' : ''; ?>
                                class="w-4 h-4 border-gray-300 rounded text-primary focus:ring-primary">
                            <label for="allow_cover_letter" class="ml-3 text-sm font-medium text-gray-700">
                                Allow cover letter upload
                            </label>
                        </div>

                        <?php if ($hasQuestions): ?>
                            <div class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50">
                                <input id="screening_questions_enabled" name="screening_questions_enabled" type="checkbox"
                                    <?php echo (($settings['screening_questions_enabled'] ?? '1') == '1') ? 'checked' : ''; ?>
                                    class="w-4 h-4 border-gray-300 rounded text-primary focus:ring-primary">
                                <label for="screening_questions_enabled" class="ml-3 text-sm font-medium text-gray-700">
                                    Enable screening questions
                                    <span class="ml-2 text-xs text-gray-500">(<?php echo count($screeningQuestions); ?> questions configured)</span>
                                </label>
                            </div>
                        <?php else: ?>
                            <div class="p-4 border border-gray-200 rounded-lg bg-gray-50">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-gray-600">
                                            No screening questions configured. You can add them in Step 3.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="screening_questions_enabled" value="0">
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Application Limits -->
                <div>
                    <h3 class="mb-2 font-medium text-md text-primary">Application Limits</h3>

                    <div>
                        <label for="max_applicants" class="block mb-1 text-sm font-medium text-primary">
                            Maximum number of applicants (optional)
                        </label>
                        <input id="max_applicants" name="max_applicants" type="number" min="1" max="1000"
                            value="<?php echo htmlspecialchars($settings['max_applicants'] ?? ''); ?>"
                            placeholder="No limit"
                            class="w-full h-12 px-3 py-2 text-sm border border-gray-300 rounded-md focus:ring-primary focus:border-primary">
                        <p class="mt-1 text-xs text-gray-500">
                            Leave empty for no limit. The job will automatically close when this limit is reached.
                        </p>
                    </div>
                </div>

                <!-- Notifications -->
                <div>
                    <h3 class="mb-2 font-medium text-md text-primary">Notifications</h3>

                    <div class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50">
                        <input id="notify_on_new_application" name="notify_on_new_application" type="checkbox"
                            <?php echo (($settings['notify_on_new_application'] ?? '1') == '1') ? 'checked' : ''; ?>
                            class="w-4 h-4 border-gray-300 rounded text-primary focus:ring-primary">
                        <label for="notify_on_new_application" class="ml-3 text-sm font-medium text-gray-700">
                            Notify me when someone applies
                        </label>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-between pt-6">
                    <a href="?page=post-job&step=3&job_id=<?php echo $job_id; ?>"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Previous Step
                    </a>

                    <div class="flex gap-3">
                        <button type="button" onclick="skipStep()"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">
                            Skip & Continue
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>
                        <button type="submit"
                            class="inline-flex items-center px-6 py-2 text-sm font-medium text-white border border-transparent rounded-md shadow-sm bg-primary hover:bg-blue-700">
                            Continue to Review
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function skipStep() {
        // Redirect to next step without saving settings
        window.location.href = '?page=post-job&step=5&job_id=<?php echo $job_id; ?>';
    }

    // Preview salary display toggle
    document.getElementById('show_pay')?.addEventListener('change', function() {
        const isChecked = this.checked;
        const payInfo = document.querySelector('.pay-preview');

        if (payInfo) {
            if (isChecked) {
                payInfo.style.opacity = '1';
                payInfo.innerHTML = '<strong>Will show:</strong> Pay range and type to job seekers';
            } else {
                payInfo.style.opacity = '0.6';
                payInfo.innerHTML = '<strong>Will show:</strong> "Competitive salary" or "Negotiable"';
            }
        }
    });
</script>