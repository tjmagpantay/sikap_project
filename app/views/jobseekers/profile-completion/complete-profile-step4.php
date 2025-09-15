<?php
include_once __DIR__ . '/../components/jobseeker_auth_check.php';
include_once __DIR__ . '/../../components/navbar-top.php';
include_once __DIR__ . '/../navbar-jobseeker.php';

// Display success/error messages from session
if (isset($_SESSION['success_message'])) {
    $success = $_SESSION['success_message'];
    unset($_SESSION['success_message']);
}
if (isset($_SESSION['error_message'])) {
    $error = $_SESSION['error_message'];
    unset($_SESSION['error_message']);
}

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
?>

<div class="min-h-screen py-6">
    <div class="sm:mx-auto sm:w-full sm:max-w-2xl">
        <div class="text-center">
            <h2 class="mt-6 text-3xl font-extrabold text-center text-grayMain">
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
                            <!-- Updated delete button to use form submission -->
                            <form method="POST" action="?page=delete-work-experience" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this work experience?')">
                                <input type="hidden" name="delete_experience_id" value="<?php echo $currentWork['experience_id']; ?>">
                                <button type="submit" class="text-red-600 hover:text-red-800">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
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
                                    <!-- Updated delete button to use form submission -->
                                    <form method="POST" action="?page=delete-work-experience" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this work experience?')">
                                        <input type="hidden" name="delete_experience_id" value="<?php echo $work['experience_id']; ?>">
                                        <button type="submit" class="text-red-600 hover:text-red-800">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
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
                        What type of work experience would you like to add? (Optional)
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
                        Job Title
                    </label>
                    <div class="mt-1">
                        <input id="job_title" name="job_title" type="text"
                            value="<?php echo htmlspecialchars($_POST['job_title'] ?? ''); ?>"
                            placeholder="e.g., Software Developer, Marketing Manager"
                            maxlength="100"
                            class="block w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-400 transition-all bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary hover:border-gray-400"
                            oninput="validateJobTitle(this)">
                        <div id="job_title_error" class="hidden mt-1 text-xs text-red-600"></div>
                        <div class="mt-1 text-xs text-gray-500">
                            <span id="job_title_count">0</span>/100 characters
                        </div>
                    </div>
                </div>

                <!-- Company Name -->
                <div>
                    <label for="company_name" class="block mb-1 text-xs font-medium text-gray-500">
                        Company/Organization Name
                    </label>
                    <div class="mt-1">
                        <input id="company_name" name="company_name" type="text"
                            value="<?php echo htmlspecialchars($_POST['company_name'] ?? ''); ?>"
                            placeholder="Company/Organization Name"
                            maxlength="100"
                            class="block w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-400 transition-all bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary hover:border-gray-400"
                            oninput="validateCompanyName(this)">
                        <div id="company_name_error" class="hidden mt-1 text-xs text-red-600"></div>
                        <div class="mt-1 text-xs text-gray-500">
                            <span id="company_name_count">0</span>/100 characters
                        </div>
                    </div>
                </div>

                <!-- Employment Type - IMPROVED DROPDOWN -->
                <div>
                    <label for="employment_type" class="block mb-1 text-xs font-medium text-gray-500">
                        Employment Type <span class="text-red-500" id="employment_type_required" style="display: none;">*</span>
                    </label>
                    <div class="relative mt-1" x-data="{ open: false, selected: '<?php echo htmlspecialchars($_POST['employment_type'] ?? ''); ?>' || 'Select Employment Type' }">
                        <button type="button" @click="open = !open"
                            @click.away="open = false"
                            class="flex items-center justify-between w-full px-3 py-2 pr-10 text-sm text-gray-700 transition-all duration-200 bg-white border border-gray-300 rounded-md shadow-sm appearance-none hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary">
                            <span x-text="selected === 'Select Employment Type' ? 'Select Employment Type' : selected"
                                :class="selected === 'Select Employment Type' ? 'text-gray-400' : 'text-gray-700'"></span>
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <!-- Hidden input for form submission -->
                        <input type="hidden" name="employment_type" x-model="selected === 'Select Employment Type' ? '' : selected">

                        <!-- Dropdown Menu -->
                        <div x-show="open"
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute left-0 z-50 w-full mt-2 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5"
                            x-cloak>
                            <div class="py-1">
                                <button type="button"
                                    @click="selected = 'Full-time'; open = false"
                                    class="flex items-center w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                    Full-time
                                </button>
                                <button type="button"
                                    @click="selected = 'Part-time'; open = false"
                                    class="flex items-center w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                    Part-time
                                </button>
                                <button type="button"
                                    @click="selected = 'Contract'; open = false"
                                    class="flex items-center w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                    Contract
                                </button>
                                <button type="button"
                                    @click="selected = 'Freelance'; open = false"
                                    class="flex items-center w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                    Freelance
                                </button>
                                <button type="button"
                                    @click="selected = 'Internship'; open = false"
                                    class="flex items-center w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                    Internship
                                </button>
                                <button type="button"
                                    @click="selected = 'Temporary'; open = false"
                                    class="flex items-center w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                    Temporary
                                </button>
                                <button type="button"
                                    @click="selected = 'Volunteer'; open = false"
                                    class="flex items-center w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                    Volunteer
                                </button>
                                <button type="button"
                                    @click="selected = 'Other'; open = false"
                                    class="flex items-center w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                    Other
                                </button>
                            </div>
                        </div>
                        <div id="employment_type_error" class="hidden mt-1 text-xs text-red-600"></div>
                    </div>
                </div>

                <!-- Date Range -->
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="start_date" class="block mb-1 text-xs font-medium text-gray-500">
                            Start Date <span class="text-red-500" id="start_date_required" style="display: none;">*</span>
                        </label>
                        <div class="mt-1">
                            <input id="start_date" name="start_date" type="date"
                                value="<?php echo htmlspecialchars($_POST['start_date'] ?? ''); ?>"
                                max="<?php echo date('Y-m-d'); ?>"
                                class="block w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-400 transition-all bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary hover:border-gray-400"
                                onchange="validateStartDate(this)">
                            <div id="start_date_error" class="hidden mt-1 text-xs text-red-600"></div>
                        </div>
                    </div>

                    <div id="end-date-container">
                        <label for="end_date" class="block mb-1 text-xs font-medium text-gray-500">
                            End Date
                        </label>
                        <div class="mt-1">
                            <input id="end_date" name="end_date" type="date"
                                value="<?php echo htmlspecialchars($_POST['end_date'] ?? ''); ?>"
                                max="<?php echo date('Y-m-d'); ?>"
                                class="block w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-400 transition-all bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary hover:border-gray-400"
                                onchange="validateEndDate(this)">
                            <div id="end_date_error" class="hidden mt-1 text-xs text-red-600"></div>
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
                            maxlength="500"
                            class="block w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-400 transition-all bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary hover:border-gray-400"
                            oninput="validateResponsibilities(this)"><?php echo htmlspecialchars($_POST['responsibilities'] ?? ''); ?></textarea>
                        <div id="responsibilities_error" class="hidden mt-1 text-xs text-red-600"></div>
                        <div class="mt-1 text-xs text-gray-500">
                            <span id="responsibilities_count">0</span>/500 characters
                        </div>
                    </div>
                </div>

                <div class="flex justify-between">
                    <a href="?page=complete-jobseeker-profile&step=3" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Previous Step
                    </a>

                    <div class="flex gap-2">
                        <button type="submit" name="add_another" id="addAnotherBtn"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">
                            <span id="addAnotherText">Add Experience</span>
                        </button>

                        <button type="submit" name="submit_step4" id="submitBtn"
                            class="inline-flex items-center px-6 py-2 text-sm font-medium text-white border border-transparent rounded-md shadow-sm bg-primary hover:bg-blue-700">
                            <span id="submitBtnText">
                                <?php if (!empty($workExperience)): ?>
                                    Continue
                                <?php else: ?>
                                    Skip & Continue
                                <?php endif; ?>
                            </span>
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
    // Global validation state
    let hasJobTitle = false;

    // Validation functions
    function validateJobTitle(input) {
        const value = input.value.trim();
        const errorDiv = document.getElementById('job_title_error');
        const countSpan = document.getElementById('job_title_count');
        const jobTitleRegex = /^[a-zA-Z0-9\s\-,./&]*$/;

        // Update character count
        countSpan.textContent = value.length;

        // Reset styles
        input.classList.remove('border-red-500', 'border-green-500');
        errorDiv.classList.add('hidden');

        // Update global state
        hasJobTitle = value.length > 0;
        updateRequiredFields();

        if (value === '') {
            return true; // Optional field
        }

        if (value.length > 100) {
            showError(input, errorDiv, 'Must be less than 100 characters');
            return false;
        }

        if (!jobTitleRegex.test(value)) {
            showError(input, errorDiv, 'Only letters, numbers, spaces, and basic symbols (- , . / &) are allowed');
            return false;
        }

        // Valid
        input.classList.add('border-green-500');
        return true;
    }

    function validateCompanyName(input) {
        const value = input.value.trim();
        const errorDiv = document.getElementById('company_name_error');
        const countSpan = document.getElementById('company_name_count');
        const companyRegex = /^[a-zA-Z0-9\s\-,.&']*$/;

        // Update character count
        countSpan.textContent = value.length;

        // Reset styles
        input.classList.remove('border-red-500', 'border-green-500');
        errorDiv.classList.add('hidden');

        if (value === '') {
            return true; // Optional field
        }

        if (value.length > 100) {
            showError(input, errorDiv, 'Must be less than 100 characters');
            return false;
        }

        if (!companyRegex.test(value)) {
            showError(input, errorDiv, 'Only letters, numbers, spaces, and symbols (- , . & \') are allowed');
            return false;
        }

        // Valid
        input.classList.add('border-green-500');
        return true;
    }

    function validateStartDate(input) {
        const value = input.value;
        const errorDiv = document.getElementById('start_date_error');

        // Reset styles
        input.classList.remove('border-red-500', 'border-green-500');
        errorDiv.classList.add('hidden');

        if (!value) {
            if (hasJobTitle) {
                showError(input, errorDiv, 'Start date is required when job title is provided');
                return false;
            }
            return true;
        }

        const startDate = new Date(value);
        const today = new Date();

        if (startDate > today) {
            showError(input, errorDiv, 'Start date cannot be in the future');
            return false;
        }

        // Validate end date if it exists
        const endDateInput = document.getElementById('end_date');
        if (endDateInput.value) {
            validateEndDate(endDateInput);
        }

        // Valid
        input.classList.add('border-green-500');
        return true;
    }

    function validateEndDate(input) {
        const value = input.value;
        const errorDiv = document.getElementById('end_date_error');
        const startDateValue = document.getElementById('start_date').value;
        const currentlyWorking = document.getElementById('currently_working').checked;

        // Reset styles
        input.classList.remove('border-red-500', 'border-green-500');
        errorDiv.classList.add('hidden');

        if (!value || currentlyWorking) {
            return true; // Optional if not currently working
        }

        const endDate = new Date(value);
        const today = new Date();

        if (endDate > today) {
            showError(input, errorDiv, 'End date cannot be in the future');
            return false;
        }

        if (startDateValue) {
            const startDate = new Date(startDateValue);
            if (endDate < startDate) {
                showError(input, errorDiv, 'End date must be greater than or equal to start date');
                return false;
            }
        }

        // Valid
        input.classList.add('border-green-500');
        return true;
    }

    function validateResponsibilities(input) {
        const value = input.value;
        const errorDiv = document.getElementById('responsibilities_error');
        const countSpan = document.getElementById('responsibilities_count');

        // Update character count
        countSpan.textContent = value.length;

        // Reset styles
        input.classList.remove('border-red-500', 'border-green-500');
        errorDiv.classList.add('hidden');

        if (value.length > 500) {
            showError(input, errorDiv, 'Must be less than 500 characters');
            return false;
        }

        // Valid
        if (value.length > 0) {
            input.classList.add('border-green-500');
        }
        return true;
    }

    function updateRequiredFields() {
        const employmentTypeRequired = document.getElementById('employment_type_required');
        const startDateRequired = document.getElementById('start_date_required');

        if (hasJobTitle) {
            employmentTypeRequired.style.display = 'inline';
            startDateRequired.style.display = 'inline';
        } else {
            employmentTypeRequired.style.display = 'none';
            startDateRequired.style.display = 'none';
        }
    }

    function validateEmploymentType() {
        const employmentTypeInput = document.querySelector('input[name="employment_type"]');
        const errorDiv = document.getElementById('employment_type_error');

        errorDiv.classList.add('hidden');

        if (hasJobTitle && (!employmentTypeInput.value || employmentTypeInput.value === 'Select Employment Type')) {
            showError(null, errorDiv, 'Employment type is required when job title is provided');
            return false;
        }

        return true;
    }

    function showError(input, errorDiv, message) {
        if (input) {
            input.classList.add('border-red-500');
        }
        errorDiv.textContent = message;
        errorDiv.classList.remove('hidden');
    }

    document.addEventListener('DOMContentLoaded', function() {
        const experienceTypeRadios = document.querySelectorAll('input[name="experience_type"]');
        const currentlyWorkingContainer = document.getElementById('currently-working-container');
        const currentlyWorkingCheckbox = document.getElementById('currently_working');
        const endDateContainer = document.getElementById('end-date-container');
        const endDateInput = document.getElementById('end_date');

        // Initialize character counts
        const jobTitleField = document.getElementById('job_title');
        const companyField = document.getElementById('company_name');
        const responsibilitiesField = document.getElementById('responsibilities');

        if (jobTitleField) {
            document.getElementById('job_title_count').textContent = jobTitleField.value.length;
            hasJobTitle = jobTitleField.value.trim().length > 0;
        }
        if (companyField) {
            document.getElementById('company_name_count').textContent = companyField.value.length;
        }
        if (responsibilitiesField) {
            document.getElementById('responsibilities_count').textContent = responsibilitiesField.value.length;
        }

        updateRequiredFields();

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

        // Form submission validation
        document.getElementById('experienceForm').addEventListener('submit', function(e) {
            const submitBtn = e.submitter;
            const jobTitle = document.getElementById('job_title').value.trim();
            const companyName = document.getElementById('company_name').value.trim();

            // If "Add Experience" button and fields are filled, validate
            if (submitBtn && submitBtn.name === 'add_another') {
                if (!jobTitle && !companyName) {
                    // No experience to add, prevent submission
                    e.preventDefault();
                    alert('Please fill in at least Job Title to add experience.');
                    return;
                }

                // Validate all fields if job title is provided
                let isValid = true;

                if (!validateJobTitle(document.getElementById('job_title'))) isValid = false;
                if (!validateCompanyName(document.getElementById('company_name'))) isValid = false;
                if (!validateEmploymentType()) isValid = false;
                if (!validateStartDate(document.getElementById('start_date'))) isValid = false;
                if (!validateEndDate(document.getElementById('end_date'))) isValid = false;
                if (!validateResponsibilities(document.getElementById('responsibilities'))) isValid = false;

                if (!isValid) {
                    e.preventDefault();
                    alert('Please fix the errors before adding experience.');
                    return;
                }
            }

            // For "Skip & Continue" button, always allow submission
            if (submitBtn && submitBtn.name === 'submit_step4') {
                // Allow to continue even without experience
                return true;
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

                    // Update Alpine.js dropdown for employment type
                    const employmentTypeContainer = document.querySelector('[x-data*="employment_type"]');
                    if (employmentTypeContainer) {
                        employmentTypeContainer._x_dataStack[0].selected = exp.employment_type;
                    }

                    document.getElementById('start_date').value = exp.start_date;
                    document.getElementById('end_date').value = exp.end_date || '';
                    document.getElementById('responsibilities').value = exp.responsibilities || '';

                    // Update character counts
                    document.getElementById('job_title_count').textContent = exp.job_title.length;
                    document.getElementById('company_name_count').textContent = exp.company_name.length;
                    document.getElementById('responsibilities_count').textContent = (exp.responsibilities || '').length;

                    // Update global state
                    hasJobTitle = exp.job_title.trim().length > 0;
                    updateRequiredFields();

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

    function resetForm() {
        document.getElementById('experienceForm').reset();
        document.getElementById('form_mode').value = 'add';
        document.getElementById('experience_id').value = '';

        // Reset character counts
        document.getElementById('job_title_count').textContent = '0';
        document.getElementById('company_name_count').textContent = '0';
        document.getElementById('responsibilities_count').textContent = '0';

        // Reset global state
        hasJobTitle = false;
        updateRequiredFields();

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

        // Reset Alpine.js dropdown
        const employmentTypeContainer = document.querySelector('[x-data*="employment_type"]');
        if (employmentTypeContainer) {
            employmentTypeContainer._x_dataStack[0].selected = 'Select Employment Type';
        }
    }
</script>