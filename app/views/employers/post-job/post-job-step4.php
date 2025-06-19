<?php
// filepath: c:\xampp\htdocs\sikap\app\views\employers\post-job\post-job-step4.php

// Get existing settings if editing
$existingSettings = $jobData ?? [];
?>

<?php include_once __DIR__ . '/../../components/navbar-top.php';
include_once __DIR__ . '/../navbar-employer.php';
?>

<div class="min-h-screen py-12 bg-gray-50 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-4xl">
        <div class="text-center">
            <div class="flex justify-center mb-4">
                <div class="p-3 bg-green-600 rounded-full">
                    <i class="text-2xl text-white fas fa-cogs"></i>
                </div>
            </div>
            <h2 class="mt-6 text-3xl font-extrabold text-center text-gray-900">
                Application Settings
            </h2>
            <p class="mt-2 text-sm text-center text-gray-600">
                Step 4/5 - Configure How Applicants Apply
            </p>
        </div>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-4xl">
        <div class="px-4 py-8 bg-white shadow sm:rounded-lg sm:px-10">
            <!-- Progress bar -->
            <div class="w-full h-2 mb-6 bg-gray-200 rounded">
                <div class="h-2 bg-green-600 rounded" style="width: 80%"></div>
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
                    <span class="flex-1 px-3 py-2 text-xs font-medium text-center text-white bg-green-600 rounded-md">
                        Settings
                    </span>
                    <span class="flex-1 px-3 py-2 text-xs font-medium text-center text-gray-500 bg-gray-100 rounded-md">
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

            <form class="space-y-6" method="POST" action="?page=post-job&step=4&job_id=<?php echo $job_id; ?>">
                
                <!-- Application Requirements -->
                <div class="p-6 bg-white border border-gray-200 rounded-lg">
                    <h3 class="mb-4 text-lg font-medium text-gray-900">Application Requirements</h3>
                    
                    <div class="space-y-4">
                        <!-- Resume Required -->
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="resume_required" name="resume_required" type="checkbox" value="1"
                                       <?php echo (($existingSettings['resume_required'] ?? '1') == '1') ? 'checked' : ''; ?>
                                       class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="resume_required" class="font-medium text-gray-700">
                                    Require Resume/CV Upload
                                </label>
                                <p class="text-gray-500">Applicants must upload their resume to apply</p>
                            </div>
                        </div>

                        <!-- Cover Letter -->
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="allow_cover_letter" name="allow_cover_letter" type="checkbox" value="1"
                                       <?php echo (($existingSettings['allow_cover_letter'] ?? '1') == '1') ? 'checked' : ''; ?>
                                       class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="allow_cover_letter" class="font-medium text-gray-700">
                                    Allow Cover Letter (Optional)
                                </label>
                                <p class="text-gray-500">Give applicants the option to include a cover letter</p>
                            </div>
                        </div>

                        <!-- Screening Questions -->
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="screening_questions_enabled" name="screening_questions_enabled" type="checkbox" value="1"
                                       <?php 
                                       // Check if there are screening questions
                                       $hasQuestions = !empty($screeningQuestions);
                                       echo (($existingSettings['screening_questions_enabled'] ?? '0') == '1' && $hasQuestions) ? 'checked' : ''; 
                                       echo !$hasQuestions ? 'disabled' : '';
                                       ?>
                                       class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="screening_questions_enabled" class="font-medium text-gray-700">
                                    Enable Screening Questions
                                </label>
                                <p class="text-gray-500">
                                    <?php if ($hasQuestions): ?>
                                        Include the screening questions you created in step 3 (<?php echo count($screeningQuestions); ?> questions)
                                    <?php else: ?>
                                        <span class="text-orange-600">No screening questions added in step 3</span>
                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Application Limits -->
                <div class="p-6 bg-white border border-gray-200 rounded-lg">
                    <h3 class="mb-4 text-lg font-medium text-gray-900">Application Limits</h3>
                    
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <!-- Max Applicants -->
                        <div>
                            <label for="max_applicants" class="block text-sm font-medium text-gray-700">
                                Maximum Number of Applicants
                            </label>
                            <input id="max_applicants" name="max_applicants" type="number" min="1" max="1000"
                                   value="<?php echo htmlspecialchars($existingSettings['max_applicants'] ?? ''); ?>"
                                   placeholder="Leave blank for no limit"
                                   class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500">
                            <p class="mt-1 text-xs text-gray-500">Automatically close applications when this number is reached</p>
                        </div>

                        <!-- Application Deadline (copied from step 1 for reference) -->
                        <div>
                            <label for="application_deadline_display" class="block text-sm font-medium text-gray-700">
                                Application Deadline
                            </label>
                            <input id="application_deadline_display" type="text" readonly
                                   value="<?php echo !empty($existingSettings['application_deadline']) ? date('M j, Y g:i A', strtotime($existingSettings['application_deadline'])) : 'No deadline set'; ?>"
                                   class="block w-full px-3 py-2 mt-1 text-gray-600 border border-gray-300 rounded-md bg-gray-50">
                            <p class="mt-1 text-xs text-gray-500">
                                <a href="?page=post-job&step=1&job_id=<?php echo $job_id; ?>" class="text-green-600 hover:text-green-700">
                                    Edit in Step 1
                                </a>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Notifications -->
                <div class="p-6 bg-white border border-gray-200 rounded-lg">
                    <h3 class="mb-4 text-lg font-medium text-gray-900">Notification Settings</h3>
                    
                    <div class="space-y-4">
                        <!-- Email Notifications -->
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="notify_on_new_application" name="notify_on_new_application" type="checkbox" value="1"
                                       <?php echo (($existingSettings['notify_on_new_application'] ?? '1') == '1') ? 'checked' : ''; ?>
                                       class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="notify_on_new_application" class="font-medium text-gray-700">
                                    Email Notifications for New Applications
                                </label>
                                <p class="text-gray-500">Receive email alerts when someone applies to this job</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Job Visibility -->
                <div class="p-6 bg-white border border-gray-200 rounded-lg">
                    <h3 class="mb-4 text-lg font-medium text-gray-900">Job Visibility</h3>
                    
                    <div class="space-y-4">
                        <!-- Highlighted Job -->
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="is_highlighted" name="is_highlighted" type="checkbox" value="1"
                                       <?php echo (($existingSettings['is_highlighted'] ?? '0') == '1') ? 'checked' : ''; ?>
                                       class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="is_highlighted" class="font-medium text-gray-700">
                                    Highlight This Job Post
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800 ml-2">
                                        Premium
                                    </span>
                                </label>
                                <p class="text-gray-500">Make this job stand out with a highlight badge and priority placement</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Settings Summary -->
                <div class="p-4 border border-blue-200 rounded-lg bg-blue-50">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="text-blue-400 fas fa-info-circle"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">
                                Settings Summary
                            </h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <p>These settings control how applicants can apply to your job and what information they need to provide. You can change these settings later if needed.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-between pt-6">
                    <a href="?page=post-job&step=3&job_id=<?php echo $job_id; ?>" 
                       class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                        <i class="mr-2 fas fa-arrow-left"></i>
                        Previous Step
                    </a>

                    <div class="flex space-x-3">
                        <button type="submit" name="save_settings" 
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                            <i class="mr-2 fas fa-save"></i>
                            Save Settings
                        </button>
                        <button type="submit" 
                                class="inline-flex items-center px-6 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md hover:bg-green-700">
                            Continue to Review
                            <i class="ml-2 fas fa-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Show/hide max applicants based on checkbox
document.addEventListener('DOMContentLoaded', function() {
    // Add any JavaScript for dynamic form behavior here
    
    // Example: Show premium feature info
    const highlightCheckbox = document.getElementById('is_highlighted');
    highlightCheckbox.addEventListener('change', function() {
        if (this.checked) {
            // Show premium feature info
            console.log('Premium feature selected');
        }
    });
});
</script>