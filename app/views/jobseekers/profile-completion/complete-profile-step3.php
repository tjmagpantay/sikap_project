<?php include_once __DIR__ . '/../../components/navbar-top.php';
include_once __DIR__ . '/../navbar-jobseeker.php'; ?>

<?php
// Get existing work experience
$jobseekerModel = new Jobseeker();
$workExperience = $jobseekerModel->getWorkExperience($_SESSION['user_id']);
$currentWork = !empty($workExperience) ? $workExperience[0] : null;
?>

<div class="min-h-screen py-6">
    <div class="sm:mx-auto sm:w-full sm:max-w-2xl">
        <div class="text-center">
            <div class="flex justify-center mb-4">
                <div class="flex items-center justify-center w-12 h-12 rounded-full bg-primary">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
            <h2 class="mt-6 text-3xl font-extrabold text-center text-gray-900">
                Employment Status
            </h2>
            <p class="mt-2 text-sm text-center text-gray-600">
                Step 3/5 - Current employment situation
            </p>
            <p class="mt-2 text-sm text-center text-gray-500">
                Help us tailor opportunities by sharing your current employment status
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
                        <a href="?page=complete-jobseeker-profile&step=1" class="flex items-center justify-center w-8 h-8 text-gray-500 transition-colors bg-gray-200 rounded-full hover:bg-gray-300 hover:text-gray-700">
                            <span class="text-sm font-semibold">1</span>
                        </a>
                        <span class="mt-1 text-xs text-gray-500">Documents</span>
                    </div>

                    <!-- Step 2 -->
                    <div class="flex flex-col items-center">
                        <a href="?page=complete-jobseeker-profile&step=2" class="flex items-center justify-center w-8 h-8 text-gray-500 transition-colors bg-gray-200 rounded-full hover:bg-gray-300 hover:text-gray-700">
                            <span class="text-sm font-semibold">2</span>
                        </a>
                        <span class="mt-1 text-xs text-gray-500">Basic Info</span>
                    </div>

                    <!-- Step 3 -->
                    <div class="flex flex-col items-center">
                        <div class="flex items-center justify-center w-8 h-8 text-white rounded-full bg-primary">
                            <span class="text-sm font-semibold">3</span>
                        </div>
                        <span class="mt-1 text-xs text-gray-600">Employment</span>
                    </div>

                    <!-- Step 4 -->
                    <div class="flex flex-col items-center">
                        <a href="?page=complete-jobseeker-profile&step=4" class="flex items-center justify-center w-8 h-8 text-gray-500 transition-colors bg-gray-200 rounded-full hover:bg-gray-300 hover:text-gray-700">
                            <span class="text-sm font-semibold">4</span>
                        </a>
                        <span class="mt-1 text-xs text-gray-500">Education</span>
                    </div>

                    <!-- Step 5 -->
                    <div class="flex flex-col items-center">
                        <a href="?page=complete-jobseeker-profile&step=5" class="flex items-center justify-center w-8 h-8 text-gray-500 transition-colors bg-gray-200 rounded-full hover:bg-gray-300 hover:text-gray-700">
                            <span class="text-sm font-semibold">5</span>
                        </a>
                        <span class="mt-1 text-xs text-gray-500">Experience</span>
                    </div>

                    <!-- Step 6 -->
                    <div class="flex flex-col items-center">
                        <a href="?page=complete-jobseeker-profile&step=6" class="flex items-center justify-center w-8 h-8 text-gray-500 transition-colors bg-gray-200 rounded-full hover:bg-gray-300 hover:text-gray-700">
                            <span class="text-sm font-semibold">6</span>
                        </a>
                        <span class="mt-1 text-xs text-gray-500">Skills</span>
                    </div>

                    <!-- Step 7 -->
                    <div class="flex flex-col items-center">
                        <a href="?page=complete-jobseeker-profile&step=7" class="flex items-center justify-center w-8 h-8 text-gray-500 transition-colors bg-gray-200 rounded-full hover:bg-gray-300 hover:text-gray-700">
                            <span class="text-sm font-semibold">7</span>
                        </a>
                        <span class="mt-1 text-xs text-gray-500">Portfolio</span>
                    </div>

                    <!-- Step 8 -->
                    <div class="flex flex-col items-center">
                        <a href="?page=complete-jobseeker-profile&step=8" class="flex items-center justify-center w-8 h-8 text-gray-500 transition-colors bg-gray-200 rounded-full hover:bg-gray-300 hover:text-gray-700">
                            <span class="text-sm font-semibold">8</span>
                        </a>
                        <span class="mt-1 text-xs text-gray-500">Review</span>
                    </div>
                </div>

                <!-- Progress bar -->
                <div class="w-full h-2 bg-gray-200 rounded">
                    <div class="h-2 rounded bg-primary" style="width: 37.5%"></div>
                </div>
            </div>

            <!-- Show existing data if available -->
            <?php if ($currentWork): ?>
                <div class="p-4 mb-6 border border-blue-200 rounded-md bg-blue-50">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h4 class="text-sm font-medium text-blue-800">Current Employment Information</h4>
                            <div class="grid grid-cols-1 gap-3 mt-2 text-sm md:grid-cols-2">
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
                    </div>
                </div>
            <?php endif; ?>

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

            <form class="space-y-6" method="POST" action="?page=complete-jobseeker-profile&step=3">
                <!-- Current Status -->
                <div>
                    <label for="current_status" class="block mb-1 text-xs font-medium text-gray-500">
                        Current Status
                    </label>
                    <div class="mt-1">
                        <select id="current_status" name="current_status"
                            class="block w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-400 transition-all bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary hover:border-gray-400">
                            <option value="">Select Status</option>
                            <option value="employed">Currently Employed</option>
                            <option value="unemployed">Unemployed</option>
                            <option value="student">Student</option>
                            <option value="freelancer">Freelancer</option>
                        </select>
                    </div>
                </div>

                <!-- Job Title -->
                <div>
                    <label for="job_title" class="block mb-1 text-xs font-medium text-gray-500">
                        Job Title
                    </label>
                    <div class="mt-1">
                        <input id="job_title" name="job_title" type="text"
                            value="<?php echo htmlspecialchars($currentWork['job_title'] ?? $_POST['job_title'] ?? ''); ?>"
                            placeholder="Job Title"
                            class="block w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-400 transition-all bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary hover:border-gray-400">
                    </div>
                </div>

                <!-- Company Name -->
                <div>
                    <label for="company_name" class="block mb-1 text-xs font-medium text-gray-500">
                        Company/Organization Name
                    </label>
                    <div class="mt-1">
                        <input id="company_name" name="company_name" type="text"
                            value="<?php echo htmlspecialchars($currentWork['company_name'] ?? $_POST['company_name'] ?? ''); ?>"
                            placeholder="Company/Organization Name"
                            class="block w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-400 transition-all bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary hover:border-gray-400">
                    </div>
                </div>

                <!-- Employment Type -->
                <div>
                    <label for="employment_type" class="block mb-1 text-xs font-medium text-gray-500">
                        Employment Type
                    </label>
                    <div class="mt-1">
                        <select id="employment_type" name="employment_type"
                            class="block w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-400 transition-all bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary hover:border-gray-400">
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

                <!-- Date Range -->
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="start_date" class="block mb-1 text-xs font-medium text-gray-500">
                            Start Date
                        </label>
                        <div class="mt-1">
                            <input id="start_date" name="start_date" type="date"
                                value="<?php echo htmlspecialchars($currentWork['start_date'] ?? $_POST['start_date'] ?? ''); ?>"
                                class="block w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-400 transition-all bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary hover:border-gray-400">
                        </div>
                    </div>

                    <div>
                        <label for="end_date" class="block mb-1 text-xs font-medium text-gray-500">
                            End Date
                        </label>
                        <div class="mt-1">
                            <input id="end_date" name="end_date" type="date"
                                value="<?php echo ($currentWork['currently_working'] ?? '') === 'Yes' ? '' : htmlspecialchars($currentWork['end_date'] ?? $_POST['end_date'] ?? ''); ?>"
                                class="block w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-400 transition-all bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary hover:border-gray-400">
                        </div>
                    </div>
                </div>

                <!-- Currently Working Checkbox -->
                <div class="flex items-center">
                    <input id="currently_working" name="currently_working" type="checkbox" value="Yes"
                        <?php echo ($currentWork['currently_working'] ?? $_POST['currently_working'] ?? '') === 'Yes' ? 'checked' : ''; ?>
                        class="w-4 h-4 border-gray-300 rounded text-primary focus:ring-primary">
                    <label for="currently_working" class="block ml-2 text-xs font-medium text-gray-500">
                        Currently Working Here?
                    </label>
                </div>

                <div class="flex justify-between">
                    <a href="?page=complete-jobseeker-profile&step=2" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Previous Step
                    </a>
                    <button type="submit" name="submit_step3"
                        class="inline-flex items-center px-6 py-2 text-sm font-medium text-white border border-transparent rounded-md shadow-sm bg-primary hover:bg-blue-700">
                        <?php echo $currentWork ? 'Update & Continue' : 'Next Step'; ?>
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>