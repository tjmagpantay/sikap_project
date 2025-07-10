<?php
include_once __DIR__ . '/../../components/navbar-top.php';
include_once __DIR__ . '/../components/navbar-employer.php';
?>

<div class="flex flex-col items-center min-h-screen py-12 ">
    <div class="w-full max-w-2xl px-4 mx-auto sm:px-8 lg:px-32 xl:px-64">
        <!-- Header -->
        <div class="mb-8 text-center">
            <h1 class="text-3xl font-extrabold font-inter text-primary">Post a New Job</h1>
            <p class="mt-2 text-sm font-inter text-primary">Step 1 of 5 – Job Details</p>
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
            $currentStep = 1;
            foreach ($steps as $i => $label): ?>
                <div class="flex flex-col items-center flex-1 min-w-[100px] shrink-0">
                    <div class="w-12 h-2 rounded <?php echo ($i + 1) === $currentStep ? 'bg-primary' : 'bg-gray-300'; ?>"></div>
                    <span class="font-inter text-xs mt-2 <?php echo ($i + 1) === $currentStep ? 'font-normal text-primary' : 'text-gray-400'; ?>">
                        <?php echo $label; ?>
                    </span>
                </div>
                <?php if ($i < count($steps) - 1): ?>
                    <div class="flex-1 h-3 bg-gray-200"></div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

        <!-- Form -->
        <form class="mt-10 space-y-6 font-inter" method="POST" action="?page=post-job&step=1<?php echo $job_id ? '&job_id=' . $job_id : ''; ?>">
            <div>
                <label for="job_title" class="block mb-1 text-sm font-medium text-primary">Job Title</label>
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
            <div>
                <label for="job_category_id" class="block mb-1 text-sm font-medium text-primary">Job Category </label>
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
            <div>
                <label for="job_type" class="block mb-1 text-sm font-medium text-primary">Job Type </span></label>
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
            <div>
                <label for="location" class="block mb-1 text-sm font-medium text-primary">Location </label>
                <input id="location" name="location" type="text" required
                    value="<?php echo htmlspecialchars($jobData['location'] ?? $_POST['location'] ?? ''); ?>"
                    placeholder="e.g., Manila, Philippines"
                    class="w-full h-12 px-3 py-2 text-sm border border-gray-300 rounded-md focus:ring-primary focus:border-primary">
            </div>
            <div>
                <label class="block mb-1 text-sm font-medium text-primary">Workplace Option</label>
                <div class="flex mt-1 space-x-4">
                    <label class="inline-flex items-center">
                        <input type="radio" name="workplace_option" value="onsite"
                            <?php echo (($jobData['workplace_option'] ?? $_POST['workplace_option'] ?? 'onsite') == 'onsite') ? 'checked' : ''; ?>
                            class="form-radio text-primary">
                        <span class="ml-2 text-sm">On-site</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="workplace_option" value="remote"
                            <?php echo (($jobData['workplace_option'] ?? $_POST['workplace_option'] ?? '') == 'remote') ? 'checked' : ''; ?>
                            class="form-radio text-primary">
                        <span class="ml-2 text-sm">Remote</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="workplace_option" value="hybrid"
                            <?php echo (($jobData['workplace_option'] ?? $_POST['workplace_option'] ?? '') == 'hybrid') ? 'checked' : ''; ?>
                            class="form-radio text-primary">
                        <span class="ml-2 text-sm">Hybrid</span>
                    </label>
                </div>
            </div>
            <div>
                <label for="skills" class="block mb-1 text-sm font-medium text-primary">Required Skills</label>
                <input id="skills" name="skills" type="text"
                    value="<?php echo htmlspecialchars(implode(', ', $jobData['skills'] ?? []) ?: ($_POST['skills'] ?? '')); ?>"
                    placeholder="e.g., PHP, JavaScript, MySQL, Communication"
                    class="w-full h-12 px-3 py-2 text-sm border border-gray-300 rounded-md focus:ring-primary focus:border-primary">
                <p class="mt-1 text-xs text-gray-400">Separate skills with commas</p>
            </div>
            <div>
                <label for="job_summary" class="block mb-1 text-sm font-medium text-primary">Job Summary </span></label>
                <textarea id="job_summary" name="job_summary" rows="3" required
                    placeholder="Brief description of the role (2-3 sentences)"
                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:ring-primary focus:border-primary"><?php echo htmlspecialchars($jobData['job_summary'] ?? $_POST['job_summary'] ?? ''); ?></textarea>
            </div>

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

            <!-- Full Description -->
            <div>
                <label for="full_description" class="block mb-1 text-sm font-medium text-primary">Full Description</label>
                <textarea id="full_description" name="full_description" rows="5" required
                    placeholder="Detailed description of the job, responsibilities, and requirements"
                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:ring-primary focus:border-primary"><?php echo htmlspecialchars($jobData['full_description'] ?? $_POST['full_description'] ?? ''); ?></textarea>
            </div>

            <!-- Application Start -->
            <div>
                <label for="application_start" class="block mb-1 text-sm font-medium text-primary">Application Start</label>
                <input id="application_start" name="application_start" type="datetime-local"
                    value="<?php echo htmlspecialchars($jobData['application_start'] ?? $_POST['application_start'] ?? ''); ?>"
                    class="w-full h-12 px-3 py-2 text-sm border border-gray-300 rounded-md focus:ring-primary focus:border-primary">
            </div>

            <!-- Application Deadline -->
            <div>
                <label for="application_deadline" class="block mb-1 text-sm font-medium text-primary">Application Deadline</label>
                <input id="application_deadline" name="application_deadline" type="datetime-local"
                    value="<?php echo htmlspecialchars($jobData['application_deadline'] ?? $_POST['application_deadline'] ?? ''); ?>"
                    class="w-full h-12 px-3 py-2 text-sm border border-gray-300 rounded-md focus:ring-primary focus:border-primary">
            </div>

            <div class="flex justify-between pt-6">
                <a href="?page=employer-dashboard"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                    <i class="mr-2 fas fa-arrow-left"></i>
                    Back to Dashboard
                </a>
                <button type="submit"
                    class="flex items-center px-6 py-2 text-sm font-medium text-white border border-transparent rounded-md bg-primary hover:bg-primary">
                    Continue to Attachments
                    <i class="ml-2 fas fa-arrow-right"></i>
                </button>
            </div>
        </form>
    </div>
</div>