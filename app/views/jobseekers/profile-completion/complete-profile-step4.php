<?php
include_once __DIR__ . '/../components/jobseeker_auth_check.php';
include_once __DIR__ . '/../../components/navbar-top.php';
include_once __DIR__ . '/../navbar-jobseeker.php'; ?>

<?php
// Use data from controller instead of direct model calls
$currentWork = null;
$additionalWorkExp = [];

if (!empty($workExperience)) {
    // Find current job - make sure we're checking for string 'Yes'
    foreach ($workExperience as $work) {
        if (isset($work['currently_working']) && $work['currently_working'] === 'Yes') {
            $currentWork = $work;
            break;
        }
    }

    // Get additional work experience (not current job)
    $additionalWorkExp = array_filter($workExperience, function ($exp) {
        return !isset($exp['currently_working']) || $exp['currently_working'] !== 'Yes';
    });
}

// Debug output (remove this after testing)
error_log("Current work: " . json_encode($currentWork));
error_log("Additional work exp: " . json_encode($additionalWorkExp));
error_log("All work experience: " . json_encode($workExperience));
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
                Work Experience
            </h2>
            <p class="mt-2 text-sm text-center text-gray-500">
                Share your current employment status and work experience
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
                        <a href="?page=complete-jobseeker-profile&step=3" class="flex items-center justify-center w-8 h-8 text-gray-500 transition-colors bg-gray-200 rounded-full hover:bg-gray-300 hover:text-gray-700">
                            <span class="text-sm font-semibold">3</span>
                        </a>
                        <span class="mt-1 text-xs text-gray-500">Education</span>
                    </div>

                    <!-- Step 4 -->
                    <div class="flex flex-col items-center">
                        <div class="flex items-center justify-center w-8 h-8 text-white rounded-full bg-primary">
                            <span class="text-sm font-semibold">4</span>
                        </div>
                        <span class="mt-1 text-xs text-gray-600">Experience</span>
                    </div>

                    <!-- Step 5 -->
                    <div class="flex flex-col items-center">
                        <a href="?page=complete-jobseeker-profile&step=5" class="flex items-center justify-center w-8 h-8 text-gray-500 transition-colors bg-gray-200 rounded-full hover:bg-gray-300 hover:text-gray-700">
                            <span class="text-sm font-semibold">5</span>
                        </a>
                        <span class="mt-1 text-xs text-gray-500">Skills</span>
                    </div>

                    <!-- Step 6 -->
                    <div class="flex flex-col items-center">
                        <a href="?page=complete-jobseeker-profile&step=6" class="flex items-center justify-center w-8 h-8 text-gray-500 transition-colors bg-gray-200 rounded-full hover:bg-gray-300 hover:text-gray-700">
                            <span class="text-sm font-semibold">6</span>
                        </a>
                        <span class="mt-1 text-xs text-gray-500">Certificates</span>
                    </div>

                    <!-- Step 7 -->
                    <div class="flex flex-col items-center">
                        <a href="?page=complete-jobseeker-profile&step=7" class="flex items-center justify-center w-8 h-8 text-gray-500 transition-colors bg-gray-200 rounded-full hover:bg-gray-300 hover:text-gray-700">
                            <span class="text-sm font-semibold">7</span>
                        </a>
                        <span class="mt-1 text-xs text-gray-500">Review</span>
                    </div>
                </div>

                <!-- Progress bar -->
                <div class="w-full h-2 bg-gray-200 rounded">
                    <div class="h-2 rounded bg-primary" style="width: 57.14%"></div>
                </div>
            </div>

            <!-- Current Employment Display -->
            <?php if ($currentWork): ?>
                <div class="p-6 mb-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium text-gray-900">Current Employment</h3>
                        <div class="flex items-center space-x-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Currently Working
                            </span>
                            <button onclick="editExperience(<?php echo $currentWork['experience_id']; ?>)" class="text-blue-600 hover:text-blue-800">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </button>
                            <button onclick="deleteExperience(<?php echo $currentWork['experience_id']; ?>)" class="text-red-600 hover:text-red-800">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-4 mt-4 sm:grid-cols-2">
                        <div class="p-3 rounded-md bg-gray-50">
                            <p class="text-xs font-medium text-gray-500">Job Title</p>
                            <p class="mt-1 text-sm font-medium text-gray-900"><?php echo htmlspecialchars($currentWork['job_title']); ?></p>
                        </div>

                        <div class="p-3 rounded-md bg-gray-50">
                            <p class="text-xs font-medium text-gray-500">Company</p>
                            <p class="mt-1 text-sm font-medium text-gray-900"><?php echo htmlspecialchars($currentWork['company_name']); ?></p>
                        </div>

                        <div class="p-3 rounded-md bg-gray-50">
                            <p class="text-xs font-medium text-gray-500">Employment Type</p>
                            <p class="mt-1 text-sm font-medium text-gray-900"><?php echo htmlspecialchars(ucfirst($currentWork['employment_type'])); ?></p>
                        </div>

                        <div class="p-3 rounded-md bg-gray-50">
                            <p class="text-xs font-medium text-gray-500">Start Date</p>
                            <p class="mt-1 text-sm font-medium text-gray-900">
                                <?php echo $currentWork['start_date'] ? date('F Y', strtotime($currentWork['start_date'])) : 'N/A'; ?>
                            </p>
                        </div>
                    </div>

                    <?php if (!empty($currentWork['responsibilities']) && $currentWork['responsibilities'] !== 'N/A'): ?>
                        <div class="mt-4">
                            <p class="text-xs font-medium text-gray-500">Responsibilities</p>
                            <p class="mt-1 text-sm text-gray-700"><?php echo htmlspecialchars($currentWork['responsibilities']); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <!-- Previous Work Experience Display -->
            <?php if (!empty($additionalWorkExp)): ?>
                <div class="p-6 mb-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                    <h3 class="mb-4 text-lg font-medium text-gray-900">Previous Work Experience</h3>

                    <?php foreach ($additionalWorkExp as $work): ?>
                        <div class="pl-4 mb-4 border-l-4 border-blue-200 last:mb-0">
                            <div class="flex items-start justify-between mb-2">
                                <h4 class="text-sm font-semibold text-gray-900"><?php echo htmlspecialchars($work['job_title']); ?></h4>
                                <div class="flex items-center space-x-2">
                                    <button onclick="editExperience(<?php echo $work['experience_id']; ?>)" class="text-blue-600 hover:text-blue-800">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>
                                    <button onclick="deleteExperience(<?php echo $work['experience_id']; ?>)" class="text-red-600 hover:text-red-800">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Company</p>
                                    <p class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($work['company_name']); ?></p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Duration</p>
                                    <p class="text-sm text-gray-700">
                                        <?php
                                        $startDate = $work['start_date'] ? date('M Y', strtotime($work['start_date'])) : 'N/A';
                                        $endDate = $work['end_date'] ? date('M Y', strtotime($work['end_date'])) : 'N/A';
                                        echo "$startDate - $endDate";
                                        ?>
                                    </p>
                                </div>
                            </div>
                            <?php if (!empty($work['responsibilities']) && $work['responsibilities'] !== 'N/A'): ?>
                                <div class="mt-2">
                                    <p class="text-xs font-medium text-gray-500">Responsibilities</p>
                                    <p class="text-sm text-gray-700"><?php echo htmlspecialchars(substr($work['responsibilities'], 0, 100)) . (strlen($work['responsibilities']) > 100 ? '...' : ''); ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- Success/Error Messages -->
            <?php if (!empty($success)): ?>
                <div class="p-4 mb-4 border border-green-200 rounded-md bg-green-50">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
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
                            <svg class="w-5 h-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-600"><?php echo htmlspecialchars($error); ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Work Experience Form -->
            <form class="space-y-6" method="POST" action="?page=complete-jobseeker-profile&step=4" id="experienceForm">
                <input type="hidden" name="experience_id" id="experience_id" value="">
                <input type="hidden" name="form_mode" id="form_mode" value="add">

                <!-- Experience Type Selector -->
                <div>
                    <label class="block mb-3 text-sm font-medium text-gray-700">
                        What type of work experience would you like to add?
                    </label>
                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                        <label class="relative flex p-4 bg-white border rounded-lg shadow-sm cursor-pointer focus:outline-none">
                            <input type="radio" name="experience_type" value="current" class="sr-only"
                                <?php echo !$currentWork ? 'checked' : ''; ?>>
                            <span class="flex flex-1">
                                <span class="flex flex-col">
                                    <span class="block text-sm font-medium text-gray-900">Current Job</span>
                                    <span class="flex items-center mt-1 text-xs text-gray-500">
                                        Job you're currently working at
                                        <?php if ($currentWork): ?>
                                            <span class="ml-2 text-orange-600">(You already have one)</span>
                                        <?php endif; ?>
                                    </span>
                                </span>
                            </span>
                            <svg class="hidden w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </label>

                        <label class="relative flex p-4 bg-white border rounded-lg shadow-sm cursor-pointer focus:outline-none">
                            <input type="radio" name="experience_type" value="previous" class="sr-only"
                                <?php echo $currentWork ? 'checked' : ''; ?>>
                            <span class="flex flex-1">
                                <span class="flex flex-col">
                                    <span class="block text-sm font-medium text-gray-900">Previous Job</span>
                                    <span class="flex items-center mt-1 text-xs text-gray-500">
                                        Job you worked at previously
                                    </span>
                                </span>
                            </span>
                            <svg class="hidden w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </label>
                    </div>
                </div>

                <!-- Job Title -->
                <div>
                    <label for="job_title" class="block mb-1 text-xs font-medium text-gray-500">
                        Job Title <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-1">
                        <input id="job_title" name="job_title" type="text" required
                            value="<?php echo htmlspecialchars($_POST['job_title'] ?? ''); ?>"
                            placeholder="e.g., Software Developer, Marketing Manager"
                            class="block w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-400 transition-all bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary hover:border-gray-400">
                    </div>
                </div>

                <!-- Company Name -->
                <div>
                    <label for="company_name" class="block mb-1 text-xs font-medium text-gray-500">
                        Company/Organization Name <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-1">
                        <input id="company_name" name="company_name" type="text" required
                            value="<?php echo htmlspecialchars($_POST['company_name'] ?? ''); ?>"
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
                            <option value="">Select Employment Type</option>
                            <option value="full-time" <?php echo ($_POST['employment_type'] ?? '') === 'full-time' ? 'selected' : ''; ?>>Full-time</option>
                            <option value="part-time" <?php echo ($_POST['employment_type'] ?? '') === 'part-time' ? 'selected' : ''; ?>>Part-time</option>
                            <option value="contract" <?php echo ($_POST['employment_type'] ?? '') === 'contract' ? 'selected' : ''; ?>>Contract</option>
                            <option value="freelance" <?php echo ($_POST['employment_type'] ?? '') === 'freelance' ? 'selected' : ''; ?>>Freelance</option>
                            <option value="internship" <?php echo ($_POST['employment_type'] ?? '') === 'internship' ? 'selected' : ''; ?>>Internship</option>
                            <option value="other" <?php echo ($_POST['employment_type'] ?? '') === 'other' ? 'selected' : ''; ?>>Other</option>
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
                                value="<?php echo htmlspecialchars($_POST['start_date'] ?? ''); ?>"
                                class="block w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-400 transition-all bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary hover:border-gray-400">
                        </div>
                    </div>

                    <div id="end-date-container">
                        <label for="end_date" class="block mb-1 text-xs font-medium text-gray-500">
                            End Date
                        </label>
                        <div class="mt-1">
                            <input id="end_date" name="end_date" type="date"
                                value="<?php echo htmlspecialchars($_POST['end_date'] ?? ''); ?>"
                                class="block w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-400 transition-all bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary hover:border-gray-400">
                        </div>
                    </div>
                </div>

                <!-- Currently Working Checkbox -->
                <div class="flex items-center" id="currently-working-container">
                    <input id="currently_working" name="currently_working" type="checkbox" value="Yes"
                        <?php echo ($_POST['currently_working'] ?? '') === 'Yes' ? 'checked' : ''; ?>
                        class="w-4 h-4 border-gray-300 rounded text-primary focus:ring-primary">
                    <label for="currently_working" class="block ml-2 text-xs font-medium text-gray-500">
                        I currently work here
                    </label>
                </div>

                <!-- Responsibilities -->
                <div>
                    <label for="responsibilities" class="block mb-1 text-xs font-medium text-gray-500">
                        Brief Description of Responsibilities (Optional)
                    </label>
                    <div class="mt-1">
                        <textarea id="responsibilities" name="responsibilities" rows="4"
                            placeholder="Describe your key responsibilities and achievements..."
                            class="block w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-400 transition-all bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary hover:border-gray-400"><?php echo htmlspecialchars($_POST['responsibilities'] ?? ''); ?></textarea>
                    </div>
                </div>

                <div class="flex justify-between">
                    <a href="?page=complete-jobseeker-profile&step=3" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Previous Step
                    </a>

                    <div class="flex space-x-3">
                        <button type="submit" name="add_another" id="addAnotherBtn"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">
                            <span id="addAnotherText">Add Another</span>
                        </button>

                        <button type="submit" name="submit_step4" id="submitBtn"
                            class="inline-flex items-center px-6 py-2 text-sm font-medium text-white border border-transparent rounded-md shadow-sm bg-primary hover:bg-blue-700">
                            <span id="submitBtnText"><?php echo (!empty($workExperience) ? 'Update & Continue' : 'Next Step'); ?></span>
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Hidden button for update action -->
                <div id="updateButtonContainer" style="display: none;" class="flex justify-end mt-4">
                    <button type="button" onclick="resetForm()" id="cancelBtn"
                        class="inline-flex items-center px-4 py-2 mr-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit" name="update_experience" id="updateBtn"
                        class="inline-flex items-center px-6 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md shadow-sm hover:bg-green-700">
                        Update Experience
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const experienceTypeRadios = document.querySelectorAll('input[name="experience_type"]');
        const currentlyWorkingContainer = document.getElementById('currently-working-container');
        const currentlyWorkingCheckbox = document.getElementById('currently_working');
        const endDateContainer = document.getElementById('end-date-container');
        const endDateInput = document.getElementById('end_date');
        const formModeInput = document.getElementById('form_mode');
        const experienceIdInput = document.getElementById('experience_id');
        const addAnotherBtn = document.getElementById('addAnotherBtn');
        const submitBtn = document.getElementById('submitBtn');
        const updateBtn = document.getElementById('updateBtn');

        // Handle radio button selection visual feedback
        experienceTypeRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                // Remove selected styling from all options
                experienceTypeRadios.forEach(r => {
                    const label = r.closest('label');
                    const checkIcon = label.querySelector('svg');
                    label.classList.remove('ring-2', 'ring-primary', 'border-primary');
                    checkIcon.classList.add('hidden');
                });

                // Add selected styling to chosen option
                if (this.checked) {
                    const label = this.closest('label');
                    const checkIcon = label.querySelector('svg');
                    label.classList.add('ring-2', 'ring-primary', 'border-primary');
                    checkIcon.classList.remove('hidden');

                    // Show/hide currently working checkbox based on selection
                    if (this.value === 'current') {
                        currentlyWorkingContainer.style.display = 'flex';
                        currentlyWorkingCheckbox.checked = true;
                        endDateContainer.style.display = 'none';
                        endDateInput.value = '';
                    } else {
                        currentlyWorkingContainer.style.display = 'none';
                        currentlyWorkingCheckbox.checked = false;
                        endDateContainer.style.display = 'block';
                    }
                }
            });

            // Initialize on page load
            if (radio.checked) {
                radio.dispatchEvent(new Event('change'));
            }
        });

        // Handle currently working checkbox
        currentlyWorkingCheckbox.addEventListener('change', function() {
            if (this.checked) {
                endDateContainer.style.display = 'none';
                endDateInput.value = '';
            } else {
                endDateContainer.style.display = 'block';
            }
        });
    });

    function editExperience(experienceId) {
        // Fetch experience data
        fetch(`?page=get-work-experience&experience_id=${experienceId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const exp = data.data;

                    // Populate form with experience data
                    document.getElementById('experience_id').value = exp.experience_id;
                    document.getElementById('form_mode').value = 'update';
                    document.getElementById('job_title').value = exp.job_title;
                    document.getElementById('company_name').value = exp.company_name;
                    document.getElementById('employment_type').value = exp.employment_type;
                    document.getElementById('start_date').value = exp.start_date;
                    document.getElementById('end_date').value = exp.end_date || '';
                    document.getElementById('responsibilities').value = exp.responsibilities || '';

                    // Set experience type radio
                    const experienceType = exp.currently_working === 'Yes' ? 'current' : 'previous';
                    const radioButton = document.querySelector(`input[name="experience_type"][value="${experienceType}"]`);
                    if (radioButton) {
                        radioButton.checked = true;
                        radioButton.dispatchEvent(new Event('change'));
                    }

                    // Set currently working checkbox
                    document.getElementById('currently_working').checked = exp.currently_working === 'Yes';

                    // Show update container, hide normal buttons
                    document.querySelector('.flex.justify-between').style.display = 'none';
                    document.getElementById('updateButtonContainer').style.display = 'flex';

                    // Scroll to form
                    document.getElementById('experienceForm').scrollIntoView({
                        behavior: 'smooth'
                    });
                } else {
                    alert('Error loading experience data: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error loading experience data');
            });
    }

    function deleteExperience(experienceId) {
        if (!confirm('Are you sure you want to delete this work experience?')) {
            return;
        }

        const formData = new FormData();
        formData.append('experience_id', experienceId);

        fetch('?page=delete-work-experience', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error deleting experience');
            });
    }

    function resetForm() {
        document.getElementById('experienceForm').reset();
        document.getElementById('form_mode').value = 'add';
        document.getElementById('experience_id').value = '';

        // Show normal buttons, hide update container
        document.querySelector('.flex.justify-between').style.display = 'flex';
        document.getElementById('updateButtonContainer').style.display = 'none';

        // Reset radio buttons to default
        const defaultRadio = <?php echo $currentWork ? '"previous"' : '"current"'; ?>;
        const defaultRadioElement = document.querySelector(`input[name="experience_type"][value="${defaultRadio}"]`);
        if (defaultRadioElement) {
            defaultRadioElement.checked = true;
            defaultRadioElement.dispatchEvent(new Event('change'));
        }
    }

    // Add cancel button for edit mode
    document.getElementById('updateBtn').insertAdjacentHTML('afterend', `
    <button type="button" onclick="resetForm()" id="cancelBtn" style="display: none;"
        class="inline-flex items-center px-4 py-2 ml-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">
        Cancel
    </button>
    `);

    const updateBtnObserver = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.type === 'attributes' && mutation.attributeName === 'style') {
                const cancelBtn = document.getElementById('cancelBtn');
                if (document.getElementById('updateBtn').style.display === 'none') {
                    cancelBtn.style.display = 'none';
                } else {
                    cancelBtn.style.display = 'inline-flex';
                }
            }
        });
    });

    updateBtnObserver.observe(document.getElementById('updateBtn'), {
        attributes: true
    });
</script>