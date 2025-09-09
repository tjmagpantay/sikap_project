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

<div class="flex flex-col items-center min-h-screen py-12 bg-gray-50">
    <div class="w-full max-w-2xl px-4 mx-auto sm:px-8 lg:px-32 xl:px-64">
        <!-- Header -->
        <div class="mb-8 text-center">
            <div class="flex justify-center mb-4">
                <div class="p-3 rounded-full bg-primary">
                    <i class="text-2xl text-white fas fa-cog"></i>
                </div>
            </div>
            <h2 class="text-3xl font-extrabold font-inter text-primary">Application Settings</h2>
            <p class="mt-2 text-sm font-inter text-primary">Step 4 of 5 – Configure Application Requirements</p>
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
            $currentStep = 4;
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

        <!-- Success/Error Messages -->
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

        <!-- Settings Form -->
        <form class="space-y-6 font-inter" method="POST" action="?page=post-job&step=4&job_id=<?php echo $job_id; ?>">

            <!-- Pay Visibility Section -->
            <div class="p-6 bg-white border border-gray-200 rounded-lg">
                <h3 class="mb-4 text-lg font-medium text-gray-900">Salary Information Display</h3>

                <?php if (!empty($jobData['pay_range']) || !empty($jobData['pay_type'])): ?>
                    <div class="p-3 mb-4 border border-blue-200 rounded-lg bg-blue-50">
                        <h4 class="mb-2 text-sm font-medium text-blue-800">Current Pay Information:</h4>
                        <div class="text-sm text-blue-700">
                            <?php if (!empty($jobData['pay_range'])): ?>
                                <p><strong>Pay Range:</strong> <?php echo htmlspecialchars($jobData['pay_range']); ?></p>
                            <?php endif; ?>
                            <?php if (!empty($jobData['pay_type'])): ?>
                                <p><strong>Pay Type:</strong> <?php echo ucfirst($jobData['pay_type']); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-center">
                            <input id="show_pay" name="show_pay" type="checkbox"
                                <?php echo (($settings['show_pay'] ?? $jobData['show_pay'] ?? '1') == '1') ? 'checked' : ''; ?>
                                class="w-4 h-4 border-gray-300 rounded text-primary focus:ring-primary">
                            <label for="show_pay" class="ml-2 text-sm font-medium text-gray-700">
                                Display salary information to job seekers
                            </label>
                        </div>
                        <p class="text-xs text-gray-500">
                            When enabled, job seekers will see the pay range and pay type. When disabled, salary information will be hidden and marked as "Competitive" or "Negotiable".
                        </p>
                    </div>
                <?php else: ?>
                    <div class="p-3 border border-yellow-200 rounded-lg bg-yellow-50">
                        <p class="text-sm text-yellow-700">
                            <i class="mr-1 fas fa-info-circle"></i>
                            No salary information was provided in the job details. You can go back to Step 1 to add pay range and type.
                        </p>
                    </div>
                    <!-- Hidden field to maintain current show_pay value -->
                    <input type="hidden" name="show_pay" value="<?php echo ($jobData['show_pay'] ?? '0'); ?>">
                <?php endif; ?>
            </div>

            <!-- Application Requirements -->
            <div class="p-6 bg-white border border-gray-200 rounded-lg">
                <h3 class="mb-4 text-lg font-medium text-gray-900">Application Requirements</h3>

                <div class="space-y-4">
                    <div class="flex items-center">
                        <input id="resume_required" name="resume_required" type="checkbox"
                            <?php echo (($settings['resume_required'] ?? '1') == '1') ? 'checked' : ''; ?>
                            class="w-4 h-4 border-gray-300 rounded text-primary focus:ring-primary">
                        <label for="resume_required" class="ml-2 text-sm font-medium text-gray-700">
                            Require resume/CV upload
                        </label>
                    </div>

                    <div class="flex items-center">
                        <input id="allow_cover_letter" name="allow_cover_letter" type="checkbox"
                            <?php echo (($settings['allow_cover_letter'] ?? '1') == '1') ? 'checked' : ''; ?>
                            class="w-4 h-4 border-gray-300 rounded text-primary focus:ring-primary">
                        <label for="allow_cover_letter" class="ml-2 text-sm font-medium text-gray-700">
                            Allow cover letter upload
                        </label>
                    </div>

                    <?php if ($hasQuestions): ?>
                        <div class="flex items-center">
                            <input id="screening_questions_enabled" name="screening_questions_enabled" type="checkbox"
                                <?php echo (($settings['screening_questions_enabled'] ?? '1') == '1') ? 'checked' : ''; ?>
                                class="w-4 h-4 border-gray-300 rounded text-primary focus:ring-primary">
                            <label for="screening_questions_enabled" class="ml-2 text-sm font-medium text-gray-700">
                                Enable screening questions
                            </label>
                        </div>
                        <p class="ml-6 text-xs text-gray-500">
                            You have <?php echo count($screeningQuestions); ?> screening question(s) configured.
                        </p>
                    <?php else: ?>
                        <div class="p-3 border border-gray-200 rounded-lg bg-gray-50">
                            <p class="text-sm text-gray-600">
                                <i class="mr-1 fas fa-info-circle"></i>
                                No screening questions configured. You can add them in Step 3.
                            </p>
                        </div>
                        <input type="hidden" name="screening_questions_enabled" value="0">
                    <?php endif; ?>
                </div>
            </div>

            <!-- Application Limits -->
            <div class="p-6 bg-white border border-gray-200 rounded-lg">
                <h3 class="mb-4 text-lg font-medium text-gray-900">Application Limits</h3>

                <div>
                    <label for="max_applicants" class="block mb-1 text-sm font-medium text-gray-700">
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
            <div class="p-6 bg-white border border-gray-200 rounded-lg">
                <h3 class="mb-4 text-lg font-medium text-gray-900">Notifications</h3>

                <div class="space-y-4">
                    <div class="flex items-center">
                        <input id="notify_on_new_application" name="notify_on_new_application" type="checkbox"
                            <?php echo (($settings['notify_on_new_application'] ?? '1') == '1') ? 'checked' : ''; ?>
                            class="w-4 h-4 border-gray-300 rounded text-primary focus:ring-primary">
                        <label for="notify_on_new_application" class="ml-2 text-sm font-medium text-gray-700">
                            Notify me when someone applies
                        </label>
                    </div>
                </div>
            </div>

            <!-- Premium Features -->
            <div class="p-6 bg-white border border-gray-200 rounded-lg">
                <h3 class="mb-4 text-lg font-medium text-gray-900">Premium Features</h3>

                <div class="space-y-4">
                    <div class="flex items-center">
                        <input id="is_highlighted" name="is_highlighted" type="checkbox"
                            <?php echo (($settings['is_highlighted'] ?? '0') == '1') ? 'checked' : ''; ?>
                            class="w-4 h-4 border-gray-300 rounded text-primary focus:ring-primary">
                        <label for="is_highlighted" class="ml-2 text-sm font-medium text-gray-700">
                            Highlight this job post
                            <span class="inline-flex items-center px-2 py-1 ml-2 text-xs font-medium text-yellow-800 bg-yellow-100 rounded">
                                <i class="mr-1 fas fa-star"></i>
                                Premium
                            </span>
                        </label>
                    </div>
                    <p class="ml-6 text-xs text-gray-500">
                        Highlighted jobs appear more prominently in search results and get more visibility.
                    </p>
                </div>
            </div>

            <!-- Navigation -->
            <div class="flex justify-between pt-6">
                <a href="?page=post-job&step=3&job_id=<?php echo $job_id; ?>"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                    <i class="mr-2 fas fa-arrow-left"></i>
                    Previous Step
                </a>

                <div class="flex space-x-3">
                    <button type="button" onclick="skipStep()"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                        Skip & Continue
                    </button>
                    <button type="submit"
                        class="inline-flex items-center px-6 py-3 text-sm font-medium text-white border border-transparent rounded-md bg-primary hover:bg-blue-700">
                        Save Settings
                        <i class="ml-2 fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>
        </form>
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