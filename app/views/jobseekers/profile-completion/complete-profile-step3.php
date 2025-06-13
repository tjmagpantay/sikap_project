<?php include_once __DIR__ . '/../../components/navbar-top.php';
include_once __DIR__ . '/../navbar-jobseeker.php';?>

<?php
// Get existing work experience
$jobseekerModel = new Jobseeker();
$workExperience = $jobseekerModel->getWorkExperience($_SESSION['user_id']);
$currentWork = !empty($workExperience) ? $workExperience[0] : null;
?>

<div class="min-h-screen py-12 bg-gray-50 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-2xl">
        <div class="text-center">
            <div class="flex justify-center mb-4">
                <div class="p-3 bg-green-600 rounded-full">
                    <i class="text-2xl text-white fas fa-briefcase"></i>
                </div>
            </div>
            <h2 class="mt-6 text-3xl font-extrabold text-center text-gray-900">
                Employment Status
            </h2>
            <p class="mt-2 text-sm text-center text-gray-600">
                Step 3/8
            </p>
            <p class="mt-2 text-sm text-center text-gray-500">
                Indicate your current employment situation to help us tailor opportunities and profile suggestions for you.
            </p>
        </div>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-2xl">
        <div class="px-4 py-8 bg-white shadow sm:rounded-lg sm:px-10">
            <!-- Progress bar -->
            <div class="w-full h-1 mb-6 bg-gray-200 rounded">
                <div class="h-1 bg-blue-600 rounded" style="width: 37.5%"></div>
            </div>

            <!-- Show existing data if available -->
            <?php if ($currentWork): ?>
                <div class="p-4 mb-6 border border-blue-200 rounded-md bg-blue-50">
                    <h4 class="mb-2 text-sm font-medium text-blue-800">Current Employment Information</h4>
                    <div class="grid grid-cols-1 gap-3 text-sm md:grid-cols-2">
                        <div>
                            <span class="text-blue-600">Job Title:</span>
                            <span class="font-medium"><?php echo htmlspecialchars($currentWork['job_title']); ?></span>
                        </div>
                        <div>
                            <span class="text-blue-600">Company:</span>
                            <span class="font-medium"><?php echo htmlspecialchars($currentWork['company_name']); ?></span>
                        </div>
                        <div>
                            <span class="text-blue-600">Type:</span>
                            <span class="font-medium"><?php echo htmlspecialchars(ucfirst($currentWork['employment_type'])); ?></span>
                        </div>
                        <div>
                            <span class="text-blue-600">Status:</span>
                            <span class="font-medium"><?php echo $currentWork['currently_working'] === 'Yes' ? 'Currently Working' : 'Previous Job'; ?></span>
                        </div>
                    </div>
                    <p class="mt-2 text-xs text-blue-600">You can update this information below.</p>
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

            <form class="space-y-6" method="POST" action="?page=complete-jobseeker-profile&step=3">
                <div>
                    <label for="current_status" class="block text-sm font-medium text-gray-700">
                        Current Status
                    </label>
                    <div class="mt-1">
                        <select id="current_status" name="current_status" class="block w-full px-3 py-2 border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-green-500 focus:border-green-500">
                            <option value="">Select Status</option>
                            <option value="employed">Currently Employed</option>
                            <option value="unemployed">Unemployed</option>
                            <option value="student">Student</option>
                            <option value="freelancer">Freelancer</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label for="job_title" class="block text-sm font-medium text-gray-700">
                        Job Title
                    </label>
                    <div class="mt-1">
                        <input id="job_title" name="job_title" type="text"
                               value="<?php echo htmlspecialchars($currentWork['job_title'] ?? $_POST['job_title'] ?? ''); ?>"
                               placeholder="Job Title"
                               class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-green-500 focus:border-green-500">
                    </div>
                </div>

                <div>
                    <label for="company_name" class="block text-sm font-medium text-gray-700">
                        Company/Organization Name
                    </label>
                    <div class="mt-1">
                        <input id="company_name" name="company_name" type="text"
                               value="<?php echo htmlspecialchars($currentWork['company_name'] ?? $_POST['company_name'] ?? ''); ?>"
                               placeholder="Company/Organization Name"
                               class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-green-500 focus:border-green-500">
                    </div>
                </div>

                <div>
                    <label for="employment_type" class="block text-sm font-medium text-gray-700">
                        Employment Type
                    </label>
                    <div class="mt-1">
                        <select id="employment_type" name="employment_type" class="block w-full px-3 py-2 border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-green-500 focus:border-green-500">
                            <option value="">Select Type</option>
                            <option value="full-time" <?php echo ($currentWork['employment_type'] ?? $_POST['employment_type'] ?? '') === 'full-time' ? 'selected' : ''; ?>>Full-time</option>
                            <option value="part-time" <?php echo ($currentWork['employment_type'] ?? $_POST['employment_type'] ?? '') === 'part-time' ? 'selected' : ''; ?>>Part-time</option>
                            <option value="contract" <?php echo ($currentWork['employment_type'] ?? $_POST['employment_type'] ?? '') === 'contract' ? 'selected' : ''; ?>>Contract</option>
                            <option value="freelance" <?php echo ($currentWork['employment_type'] ?? $_POST['employment_type'] ?? '') === 'freelance' ? 'selected' : ''; ?>>Freelance</option>
                            <option value="internship" <?php echo ($currentWork['employment_type'] ?? $_POST['employment_type'] ?? '') === 'internship' ? 'selected' : ''; ?>>Internship</option>
                            <option value="other" <?php echo ($currentWork['employment_type'] ?? $_POST['employment_type'] ?? '') === 'other' ? 'selected' : ''; ?>>Other</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700">
                            Start Date
                        </label>
                        <div class="mt-1">
                            <input id="start_date" name="start_date" type="date"
                                   value="<?php echo htmlspecialchars($currentWork['start_date'] ?? $_POST['start_date'] ?? ''); ?>"
                                   class="block w-full px-3 py-2 border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-green-500 focus:border-green-500">
                        </div>
                    </div>

                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700">
                            End Date
                        </label>
                        <div class="mt-1">
                            <input id="end_date" name="end_date" type="date"
                                   value="<?php echo ($currentWork['currently_working'] ?? '') === 'Yes' ? '' : htmlspecialchars($currentWork['end_date'] ?? $_POST['end_date'] ?? ''); ?>"
                                   class="block w-full px-3 py-2 border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-green-500 focus:border-green-500">
                        </div>
                    </div>
                </div>

                <div>
                    <div class="flex items-center">
                        <input id="currently_working" name="currently_working" type="checkbox" value="Yes"
                               <?php echo ($currentWork['currently_working'] ?? $_POST['currently_working'] ?? '') === 'Yes' ? 'checked' : ''; ?>
                               class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                        <label for="currently_working" class="ml-2 text-sm text-gray-700">
                            Currently Working Here?
                        </label>
                    </div>
                </div>

                <div class="flex justify-between">
                    <a href="?page=complete-jobseeker-profile&step=4" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                        Skip For Now
                    </a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md hover:bg-green-700">
                        <?php echo $currentWork ? 'Update & Continue' : 'Next Step'; ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>