<?php
// filepath: c:\xampp\htdocs\sikap\app\views\employers\post-job\post-job-step1.php
?>

<?php include_once __DIR__ . '/../../components/navbar-top.php';
include_once __DIR__ . '/../navbar-employer.php';
?>

<div class="min-h-screen py-12 bg-gray-50 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-4xl">
        <div class="text-center">
            <div class="flex justify-center mb-4">
                <div class="p-3 bg-blue-600 rounded-full">
                    <i class="text-2xl text-white fas fa-briefcase"></i>
                </div>
            </div>
            <h2 class="mt-6 text-3xl font-extrabold text-center text-gray-900">
                <?php echo $isEditing ? 'Edit Job Post' : 'Post a New Job'; ?>
            </h2>
            <p class="mt-2 text-sm text-center text-gray-600">
                Step 1 of 5 - Job Details
            </p>
        </div>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-4xl">
        <div class="px-4 py-8 bg-white shadow sm:rounded-lg sm:px-10">
            <!-- Progress bar -->
            <div class="w-full h-2 mb-6 bg-gray-200 rounded">
                <div class="h-2 bg-blue-600 rounded" style="width: 20%"></div>
            </div>

            <!-- Step Navigation -->
            <div class="mb-6">
                <nav class="flex space-x-2 text-sm">
                    <span class="px-3 py-2 font-medium text-white bg-blue-600 rounded-md">1. Job Details</span>
                    <span class="px-3 py-2 text-gray-500 bg-gray-100 rounded-md">2. Attachments</span>
                    <span class="px-3 py-2 text-gray-500 bg-gray-100 rounded-md">3. Questions</span>
                    <span class="px-3 py-2 text-gray-500 bg-gray-100 rounded-md">4. Settings</span>
                    <span class="px-3 py-2 text-gray-500 bg-gray-100 rounded-md">5. Review</span>
                </nav>
            </div>

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

            <form class="space-y-6" method="POST" action="?page=post-job&step=1<?php echo $job_id ? '&job_id=' . $job_id : ''; ?>">
                <!-- Job Title and Category -->
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <label for="job_title" class="block text-sm font-medium text-gray-700">
                            Job Title <span class="text-red-500">*</span>
                        </label>
                        <input id="job_title" name="job_title" type="text" required maxlength="100"
                               value="<?php echo htmlspecialchars($jobData['job_title'] ?? $_POST['job_title'] ?? ''); ?>"
                               placeholder="e.g., Senior Web Developer"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label for="job_category_id" class="block text-sm font-medium text-gray-700">
                            Job Category <span class="text-red-500">*</span>
                        </label>
                        <select id="job_category_id" name="job_category_id" required
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Select Category</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?php echo $category['job_category_id']; ?>"
                                    <?php echo (($jobData['job_category_id'] ?? $_POST['job_category_id'] ?? '') == $category['job_category_id']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($category['category_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <!-- Job Type and Status -->
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <label for="job_type" class="block text-sm font-medium text-gray-700">
                            Job Type <span class="text-red-500">*</span>
                        </label>
                        <select id="job_type" name="job_type" required
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Select Job Type</option>
                            <option value="full-time" <?php echo (($jobData['job_type'] ?? $_POST['job_type'] ?? '') == 'full-time') ? 'selected' : ''; ?>>Full-time</option>
                            <option value="part-time" <?php echo (($jobData['job_type'] ?? $_POST['job_type'] ?? '') == 'part-time') ? 'selected' : ''; ?>>Part-time</option>
                            <option value="contract" <?php echo (($jobData['job_type'] ?? $_POST['job_type'] ?? '') == 'contract') ? 'selected' : ''; ?>>Contract</option>
                            <option value="internship" <?php echo (($jobData['job_type'] ?? $_POST['job_type'] ?? '') == 'internship') ? 'selected' : ''; ?>>Internship</option>
                            <option value="freelance" <?php echo (($jobData['job_type'] ?? $_POST['job_type'] ?? '') == 'freelance') ? 'selected' : ''; ?>>Freelance</option>
                        </select>
                    </div>

                    <div>
                        <label for="job_status" class="block text-sm font-medium text-gray-700">
                            Job Status
                        </label>
                        <select id="job_status" name="job_status"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="draft" <?php echo (($jobData['job_status'] ?? $_POST['job_status'] ?? 'draft') == 'draft') ? 'selected' : ''; ?>>Draft</option>
                            <option value="open" <?php echo (($jobData['job_status'] ?? $_POST['job_status'] ?? '') == 'open') ? 'selected' : ''; ?>>Open</option>
                            <option value="paused" <?php echo (($jobData['job_status'] ?? $_POST['job_status'] ?? '') == 'paused') ? 'selected' : ''; ?>>Paused</option>
                            <option value="closed" <?php echo (($jobData['job_status'] ?? $_POST['job_status'] ?? '') == 'closed') ? 'selected' : ''; ?>>Closed</option>
                        </select>
                    </div>
                </div>

                <!-- Location and Workplace Option -->
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700">
                            Location <span class="text-red-500">*</span>
                        </label>
                        <input id="location" name="location" type="text" required
                               value="<?php echo htmlspecialchars($jobData['location'] ?? $_POST['location'] ?? ''); ?>"
                               placeholder="e.g., Manila, Philippines"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Workplace Option
                        </label>
                        <div class="space-y-2">
                            <label class="inline-flex items-center">
                                <input type="radio" name="workplace_option" value="onsite" 
                                       <?php echo (($jobData['workplace_option'] ?? $_POST['workplace_option'] ?? 'onsite') == 'onsite') ? 'checked' : ''; ?>
                                       class="form-radio text-blue-600">
                                <span class="ml-2 text-sm text-gray-700">On-site</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="workplace_option" value="remote" 
                                       <?php echo (($jobData['workplace_option'] ?? $_POST['workplace_option'] ?? '') == 'remote') ? 'checked' : ''; ?>
                                       class="form-radio text-blue-600">
                                <span class="ml-2 text-sm text-gray-700">Remote</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="workplace_option" value="hybrid" 
                                       <?php echo (($jobData['workplace_option'] ?? $_POST['workplace_option'] ?? '') == 'hybrid') ? 'checked' : ''; ?>
                                       class="form-radio text-blue-600">
                                <span class="ml-2 text-sm text-gray-700">Hybrid</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Skills -->
                <div>
                    <label for="skills" class="block text-sm font-medium text-gray-700">
                        Required Skills
                    </label>
                    <input id="skills" name="skills" type="text"
                           value="<?php echo htmlspecialchars(implode(', ', $jobData['skills'] ?? []) ?: ($_POST['skills'] ?? '')); ?>"
                           placeholder="e.g., PHP, JavaScript, MySQL, Communication"
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <p class="mt-1 text-xs text-gray-500">Separate skills with commas</p>
                </div>

                <!-- Salary Information -->
                <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                    <div>
                        <label for="pay_type" class="block text-sm font-medium text-gray-700">
                            Pay Type
                        </label>
                        <select id="pay_type" name="pay_type"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Select Pay Type</option>
                            <option value="monthly" <?php echo (($jobData['pay_type'] ?? $_POST['pay_type'] ?? '') == 'monthly') ? 'selected' : ''; ?>>Monthly</option>
                            <option value="hourly" <?php echo (($jobData['pay_type'] ?? $_POST['pay_type'] ?? '') == 'hourly') ? 'selected' : ''; ?>>Hourly</option>
                            <option value="weekly" <?php echo (($jobData['pay_type'] ?? $_POST['pay_type'] ?? '') == 'weekly') ? 'selected' : ''; ?>>Weekly</option>
                            <option value="project-based" <?php echo (($jobData['pay_type'] ?? $_POST['pay_type'] ?? '') == 'project-based') ? 'selected' : ''; ?>>Project-based</option>
                        </select>
                    </div>

                    <div>
                        <label for="pay_range" class="block text-sm font-medium text-gray-700">
                            Pay Range
                        </label>
                        <input id="pay_range" name="pay_range" type="text"
                               value="<?php echo htmlspecialchars($jobData['pay_range'] ?? $_POST['pay_range'] ?? ''); ?>"
                               placeholder="e.g., ₱20,000 - ₱30,000"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label for="salary" class="block text-sm font-medium text-gray-700">
                            Exact Salary (Optional)
                        </label>
                        <input id="salary" name="salary" type="number" step="0.01"
                               value="<?php echo htmlspecialchars($jobData['salary'] ?? $_POST['salary'] ?? ''); ?>"
                               placeholder="25000.00"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <!-- Show Pay Checkbox -->
                <div>
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="show_pay" value="1" 
                               <?php echo (($jobData['show_pay'] ?? $_POST['show_pay'] ?? '1') == '1') ? 'checked' : ''; ?>
                               class="form-checkbox text-blue-600 rounded">
                        <span class="ml-2 text-sm text-gray-700">Show salary information to applicants</span>
                    </label>
                </div>

                <!-- Job Summary -->
                <div>
                    <label for="job_summary" class="block text-sm font-medium text-gray-700">
                        Job Summary <span class="text-red-500">*</span>
                    </label>
                    <textarea id="job_summary" name="job_summary" rows="3" required
                              placeholder="Brief description of the role (2-3 sentences)"
                              class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"><?php echo htmlspecialchars($jobData['job_summary'] ?? $_POST['job_summary'] ?? ''); ?></textarea>
                </div>

                <!-- Full Description -->
                <div>
                    <label for="full_description" class="block text-sm font-medium text-gray-700">
                        Full Job Description
                    </label>
                    <textarea id="full_description" name="full_description" rows="6"
                              placeholder="Detailed job responsibilities, requirements, and qualifications"
                              class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"><?php echo htmlspecialchars($jobData['full_description'] ?? $_POST['full_description'] ?? ''); ?></textarea>
                </div>

                <!-- Application Dates -->
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <label for="application_start" class="block text-sm font-medium text-gray-700">
                            Application Start Date
                        </label>
                        <input id="application_start" name="application_start" type="datetime-local"
                               value="<?php echo htmlspecialchars($jobData['application_start'] ?? $_POST['application_start'] ?? date('Y-m-d\TH:i')); ?>"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label for="application_deadline" class="block text-sm font-medium text-gray-700">
                            Application Deadline
                        </label>
                        <input id="application_deadline" name="application_deadline" type="datetime-local"
                               value="<?php echo htmlspecialchars($jobData['application_deadline'] ?? $_POST['application_deadline'] ?? ''); ?>"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-between pt-6">
                    <a href="?page=employer-dashboard" 
                       class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                        <i class="mr-2 fas fa-arrow-left"></i>
                        Back to Dashboard
                    </a>
                    
                    <div class="space-x-3">
                        <button type="submit" name="save_draft" value="1"
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                            <i class="mr-2 fas fa-save"></i>
                            Save as Draft
                        </button>
                        <button type="submit" 
                                class="inline-flex items-center px-6 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                            Continue to Attachments
                            <i class="ml-2 fas fa-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>