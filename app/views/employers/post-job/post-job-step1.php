<?php
include_once __DIR__ . '/../components/employer_auth_check.php';
include_once __DIR__ . '/../../components/navbar-top.php';
include_once __DIR__ . '/../components/navbar-employer.php';
?>

<div class="min-h-screen py-6">
    <div class="sm:mx-auto sm:w-full sm:max-w-2xl">
        <div class="text-center">
            <h2 class="mt-2 text-3xl font-extrabold text-center text-grayMain">
                Post a New Job
            </h2>
            <p class="mt-2 text-sm text-center text-gray-500">
                Create a job posting to find the perfect candidate
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
                        <div class="flex items-center justify-center w-8 h-8 text-white rounded-full bg-primary">
                            <span class="text-sm font-semibold">1</span>
                        </div>
                        <span class="mt-1 text-xs text-gray-600">Job Details</span>
                    </div>

                    <!-- Step 2 -->
                    <div class="flex flex-col items-center">
                        <div class="flex items-center justify-center w-8 h-8 text-gray-500 bg-gray-200 rounded-full">
                            <span class="text-sm font-semibold">2</span>
                        </div>
                        <span class="mt-1 text-xs text-gray-500">Attachments</span>
                    </div>

                    <!-- Step 3 -->
                    <div class="flex flex-col items-center">
                        <div class="flex items-center justify-center w-8 h-8 text-gray-500 bg-gray-200 rounded-full">
                            <span class="text-sm font-semibold">3</span>
                        </div>
                        <span class="mt-1 text-xs text-gray-500">Questions</span>
                    </div>

                    <!-- Step 4 -->
                    <div class="flex flex-col items-center">
                        <div class="flex items-center justify-center w-8 h-8 text-gray-500 bg-gray-200 rounded-full">
                            <span class="text-sm font-semibold">4</span>
                        </div>
                        <span class="mt-1 text-xs text-gray-500">Settings</span>
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
                    <div class="h-2 rounded bg-primary" style="width: 20%"></div>
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

            <!-- Form -->
            <form class="space-y-6 font-inter" method="POST" action="?page=post-job&step=1<?php echo $job_id ? '&job_id=' . $job_id : ''; ?>">
                <!-- Hidden field to ensure step progression -->
                <input type="hidden" name="continue_to_step2" value="1">

                <!-- Job Title -->
                <div>
                    <label for="job_title" class="block mb-1 text-sm font-medium text-primary">Job Title <span class="text-red-500">*</span></label>
                    <input
                        id="job_title"
                        name="job_title"
                        type="text"
                        required
                        maxlength="100"
                        value="<?php echo htmlspecialchars($jobData['job_title'] ?? $_POST['job_title'] ?? ''); ?>"
                        placeholder="e.g., Senior Web Developer"
                        class="w-full h-12 px-3 py-2 text-sm border border-gray-300 rounded-md focus:ring-primary focus:border-primary placeholder:text-xs">
                </div>

                <!-- Job Category -->
                <div>
                    <label for="job_category_id" class="block mb-1 text-sm font-medium text-primary">Job Category <span class="text-red-500">*</span></label>
                    <select id="job_category_id" name="job_category_id" required
                        class="w-full h-12 px-3 py-2 text-sm border border-gray-300 rounded-md focus:ring-primary focus:border-primary">
                        <option value="">Select Category</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo $category['job_category_id']; ?>"
                                <?php echo (($jobData['job_category_id'] ?? $_POST['job_category_id'] ?? '') == $category['job_category_id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($category['category_name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Job Type -->
                <div>
                    <label for="job_type" class="block mb-1 text-sm font-medium text-primary">Job Type <span class="text-red-500">*</span></label>
                    <select id="job_type" name="job_type" required
                        class="w-full h-12 px-3 py-2 text-sm border border-gray-300 rounded-md focus:ring-primary focus:border-primary">
                        <option value="">Select Job Type</option>
                        <option value="full-time" <?php echo (($jobData['job_type'] ?? $_POST['job_type'] ?? '') == 'full-time') ? 'selected' : ''; ?>>Full-time</option>
                        <option value="part-time" <?php echo (($jobData['job_type'] ?? $_POST['job_type'] ?? '') == 'part-time') ? 'selected' : ''; ?>>Part-time</option>
                        <option value="contract" <?php echo (($jobData['job_type'] ?? $_POST['job_type'] ?? '') == 'contract') ? 'selected' : ''; ?>>Contract</option>
                        <option value="internship" <?php echo (($jobData['job_type'] ?? $_POST['job_type'] ?? '') == 'internship') ? 'selected' : ''; ?>>Internship</option>
                        <option value="freelance" <?php echo (($jobData['job_type'] ?? $_POST['job_type'] ?? '') == 'freelance') ? 'selected' : ''; ?>>Freelance</option>
                    </select>
                </div>

                <!-- Location -->
                <div>
                    <label for="location" class="block mb-1 text-sm font-medium text-primary">Location <span class="text-red-500">*</span></label>
                    <input id="location" name="location" type="text" required
                        value="<?php echo htmlspecialchars($jobData['location'] ?? $_POST['location'] ?? ''); ?>"
                        placeholder="e.g., Manila, Philippines"
                        class="w-full h-12 px-3 py-2 text-sm border border-gray-300 rounded-md focus:ring-primary focus:border-primary">
                </div>

                <!-- Workplace Option -->
                <div>
                    <label class="block mb-3 text-sm font-medium text-primary">Workplace Option</label>
                    <div class="grid grid-cols-3 gap-4">
                        <label class="flex items-center p-3 border border-gray-300 rounded-md cursor-pointer hover:bg-gray-50">
                            <input type="radio" name="workplace_option" value="onsite"
                                <?php echo (($jobData['workplace_option'] ?? $_POST['workplace_option'] ?? 'onsite') == 'onsite') ? 'checked' : ''; ?>
                                class="text-primary focus:ring-primary">
                            <span class="ml-2 text-sm">On-site</span>
                        </label>
                        <label class="flex items-center p-3 border border-gray-300 rounded-md cursor-pointer hover:bg-gray-50">
                            <input type="radio" name="workplace_option" value="remote"
                                <?php echo (($jobData['workplace_option'] ?? $_POST['workplace_option'] ?? '') == 'remote') ? 'checked' : ''; ?>
                                class="text-primary focus:ring-primary">
                            <span class="ml-2 text-sm">Remote</span>
                        </label>
                        <label class="flex items-center p-3 border border-gray-300 rounded-md cursor-pointer hover:bg-gray-50">
                            <input type="radio" name="workplace_option" value="hybrid"
                                <?php echo (($jobData['workplace_option'] ?? $_POST['workplace_option'] ?? '') == 'hybrid') ? 'checked' : ''; ?>
                                class="text-primary focus:ring-primary">
                            <span class="ml-2 text-sm">Hybrid</span>
                        </label>
                    </div>
                </div>

                <!-- Age Requirements -->
                <div>
                    <label class="block mb-3 text-sm font-medium text-primary">Age Requirements</label>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label for="min_age" class="block mb-1 text-xs font-medium text-gray-600">Minimum Age</label>
                            <input id="min_age" name="min_age" type="number" min="16" max="65"
                                value="<?php echo htmlspecialchars($jobData['min_age'] ?? $_POST['min_age'] ?? ''); ?>"
                                placeholder="18"
                                class="w-full h-12 px-3 py-2 text-sm border border-gray-300 rounded-md focus:ring-primary focus:border-primary">
                        </div>
                        <div>
                            <label for="max_age" class="block mb-1 text-xs font-medium text-gray-600">Maximum Age</label>
                            <input id="max_age" name="max_age" type="number" min="16" max="65"
                                value="<?php echo htmlspecialchars($jobData['max_age'] ?? $_POST['max_age'] ?? ''); ?>"
                                placeholder="60"
                                class="w-full h-12 px-3 py-2 text-sm border border-gray-300 rounded-md focus:ring-primary focus:border-primary">
                        </div>
                    </div>
                    <p class="mt-1 text-xs text-gray-400">Leave empty if no age restrictions apply. Age range should be between 16-65 years.</p>
                    <div id="age-error" class="hidden mt-1 text-xs text-red-600"></div>
                </div>

                <!-- Required Skills -->
                <div>
                    <label for="skills" class="block mb-1 text-sm font-medium text-primary">Required Skills</label>
                    <input id="skills" name="skills" type="text"
                        value="<?php echo htmlspecialchars(implode(', ', $jobData['skills'] ?? []) ?: ($_POST['skills'] ?? '')); ?>"
                        placeholder="e.g., PHP, JavaScript, MySQL, Communication"
                        class="w-full h-12 px-3 py-2 text-sm border border-gray-300 rounded-md focus:ring-primary focus:border-primary">
                    <p class="mt-1 text-xs text-gray-400">Separate skills with commas</p>
                </div>

                <!-- Job Summary -->
                <div>
                    <label for="job_summary" class="block mb-1 text-sm font-medium text-primary">Job Summary <span class="text-red-500">*</span></label>
                    <textarea id="job_summary" name="job_summary" rows="3" required
                        placeholder="Brief description of the role (2-3 sentences)"
                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md resize-none focus:ring-primary focus:border-primary"><?php echo htmlspecialchars($jobData['job_summary'] ?? $_POST['job_summary'] ?? ''); ?></textarea>
                </div>

                <!-- Pay Information -->
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <!-- Pay Type -->
                    <div>
                        <label for="pay_type" class="block mb-1 text-sm font-medium text-primary">Pay Type</label>
                        <select id="pay_type" name="pay_type"
                            class="w-full h-12 px-3 py-2 text-sm border border-gray-300 rounded-md focus:ring-primary focus:border-primary">
                            <option value="">Select Pay Type</option>
                            <option value="monthly" <?php echo (($jobData['pay_type'] ?? $_POST['pay_type'] ?? '') == 'monthly') ? 'selected' : ''; ?>>Monthly</option>
                            <option value="hourly" <?php echo (($jobData['pay_type'] ?? $_POST['pay_type'] ?? '') == 'hourly') ? 'selected' : ''; ?>>Hourly</option>
                            <option value="weekly" <?php echo (($jobData['pay_type'] ?? $_POST['pay_type'] ?? '') == 'weekly') ? 'selected' : ''; ?>>Weekly</option>
                            <option value="project-based" <?php echo (($jobData['pay_type'] ?? $_POST['pay_type'] ?? '') == 'project-based') ? 'selected' : ''; ?>>Project-based</option>
                        </select>
                    </div>

                    <!-- Pay Range -->
                    <div>
                        <label for="pay_range" class="block mb-1 text-sm font-medium text-primary">Pay Range</label>
                        <input id="pay_range" name="pay_range" type="text"
                            value="<?php echo htmlspecialchars($jobData['pay_range'] ?? $_POST['pay_range'] ?? ''); ?>"
                            placeholder="e.g., 20,000 - 40,000"
                            class="w-full h-12 px-3 py-2 text-sm border border-gray-300 rounded-md focus:ring-primary focus:border-primary">
                    </div>
                </div>
                <p class="text-xs text-gray-400">You can choose to show or hide pay information in the application settings later</p>

                <!-- Full Description -->
                <div>
                    <label for="full_description" class="block mb-1 text-sm font-medium text-primary">Full Description <span class="text-red-500">*</span></label>
                    <textarea id="full_description" name="full_description" rows="5" required
                        placeholder="Detailed description of the job, responsibilities, and requirements"
                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md resize-none focus:ring-primary focus:border-primary"><?php echo htmlspecialchars($jobData['full_description'] ?? $_POST['full_description'] ?? ''); ?></textarea>
                </div>

                <!-- Application Timeline -->
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <!-- Application Start -->
                    <div>
                        <label for="application_start" class="block mb-1 text-sm font-medium text-primary">Application Start</label>
                        <input id="application_start" name="application_start" type="datetime-local"
                            value="<?php echo htmlspecialchars($jobData['application_start'] ?? $_POST['application_start'] ?? ''); ?>"
                            class="w-full h-12 px-3 py-2 text-sm border border-gray-300 rounded-md focus:ring-primary focus:border-primary">
                        <p class="mt-1 text-xs text-gray-400">Leave empty to start accepting applications immediately</p>
                    </div>

                    <!-- Application Deadline -->
                    <div>
                        <label for="application_deadline" class="block mb-1 text-sm font-medium text-primary">Application Deadline</label>
                        <input id="application_deadline" name="application_deadline" type="datetime-local"
                            value="<?php echo htmlspecialchars($jobData['application_deadline'] ?? $_POST['application_deadline'] ?? ''); ?>"
                            class="w-full h-12 px-3 py-2 text-sm border border-gray-300 rounded-md focus:ring-primary focus:border-primary">
                        <p class="mt-1 text-xs text-gray-400">Set when applications should stop being accepted</p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-between pt-6">
                    <a href="?page=employer-dashboard"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back to Dashboard
                    </a>
                    <button type="submit" id="submit-btn"
                        class="inline-flex items-center px-6 py-2 text-sm font-medium text-white border border-transparent rounded-md shadow-sm bg-primary hover:bg-blue-700">
                        Continue to Attachments
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const minAgeInput = document.getElementById('min_age');
        const maxAgeInput = document.getElementById('max_age');
        const ageError = document.getElementById('age-error');
        const submitBtn = document.getElementById('submit-btn');

        function validateAgeRange() {
            const minAge = parseInt(minAgeInput.value);
            const maxAge = parseInt(maxAgeInput.value);

            // Clear previous errors
            ageError.classList.add('hidden');
            ageError.textContent = '';

            // Reset input styles
            minAgeInput.classList.remove('border-red-500');
            maxAgeInput.classList.remove('border-red-500');

            let isValid = true;
            let errorMessage = '';

            // Validate individual ages
            if (minAgeInput.value && (minAge < 16 || minAge > 65)) {
                errorMessage = 'Minimum age must be between 16 and 65 years.';
                minAgeInput.classList.add('border-red-500');
                isValid = false;
            }

            if (maxAgeInput.value && (maxAge < 16 || maxAge > 65)) {
                errorMessage = 'Maximum age must be between 16 and 65 years.';
                maxAgeInput.classList.add('border-red-500');
                isValid = false;
            }

            // Validate age range
            if (minAgeInput.value && maxAgeInput.value && minAge >= maxAge) {
                errorMessage = 'Maximum age must be greater than minimum age.';
                minAgeInput.classList.add('border-red-500');
                maxAgeInput.classList.add('border-red-500');
                isValid = false;
            }

            // Show error if validation failed
            if (!isValid) {
                ageError.textContent = errorMessage;
                ageError.classList.remove('hidden');
            }

            return isValid;
        }

        // Add event listeners for real-time validation
        minAgeInput.addEventListener('input', validateAgeRange);
        maxAgeInput.addEventListener('input', validateAgeRange);
        minAgeInput.addEventListener('blur', validateAgeRange);
        maxAgeInput.addEventListener('blur', validateAgeRange);

        // Validate on form submission
        document.querySelector('form').addEventListener('submit', function(e) {
            if (!validateAgeRange()) {
                e.preventDefault();
                return false;
            }
        });
    });
</script>