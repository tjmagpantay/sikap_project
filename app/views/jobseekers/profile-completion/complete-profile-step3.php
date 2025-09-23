<?php
include_once __DIR__ . '/../components/jobseeker_auth_check.php';
include_once __DIR__ . '/../../components/navbar-top.php';
include_once __DIR__ . '/../components/navbar-jobseeker.php';

// Debug - let's see what data we have
error_log("Parsed education data: " . json_encode($_SESSION['parsed_resume_data']['education'] ?? []));
error_log("Existing education data: " . json_encode($education ?? []));
?>

<div class="min-h-screen py-6">
    <div class="sm:mx-auto sm:w-full sm:max-w-2xl">
        <div class="text-center">

            <h2 class="mt-2 text-3xl font-extrabold text-center text-grayMain">
                Educational Background
            </h2>
            <p class="mt-2 text-sm text-center text-gray-500">
                Provide details about your educational background (optional)
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
                        <span class="mt-1 text-xs text-gray-600">Education</span>
                    </div>

                    <!-- Step 4 -->
                    <div class="flex flex-col items-center">
                        <a href="?page=complete-jobseeker-profile&step=4" class="flex items-center justify-center w-8 h-8 text-gray-500 transition-colors bg-gray-200 rounded-full hover:bg-gray-300 hover:text-gray-700">
                            <span class="text-sm font-semibold">4</span>
                        </a>
                        <span class="mt-1 text-xs text-gray-500">Experience</span>
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
                    <div class="h-2 rounded bg-primary" style="width: 42.86%"></div>
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

            <!-- Display parsed education if available -->
            <?php if (isset($_SESSION['parsed_resume_data']['education']) && !empty($_SESSION['parsed_resume_data']['education']['school_name'])): ?>
                <?php $parsedEdu = $_SESSION['parsed_resume_data']['education']; ?>
                <div class="p-4 mb-6 border border-gray-200 rounded-lg bg-gray-50">
                    <h3 class="mb-2 text-sm font-medium text-primary">
                        Education extracted from your resume:
                    </h3>
                    <div class="space-y-2 text-sm text-gray-600">
                        <?php if (!empty($parsedEdu['school_name'])): ?>
                            <p><strong>Institution:</strong> <?php echo htmlspecialchars($parsedEdu['school_name']); ?></p>
                        <?php endif; ?>
                        <?php if (!empty($parsedEdu['education_level'])): ?>
                            <p><strong>Level:</strong> <?php echo htmlspecialchars($parsedEdu['education_level']); ?></p>
                        <?php endif; ?>
                        <?php if (!empty($parsedEdu['field_of_study'])): ?>
                            <p><strong>Field:</strong> <?php echo htmlspecialchars($parsedEdu['field_of_study']); ?></p>
                        <?php endif; ?>
                        <?php if (!empty($parsedEdu['start_date']) && !empty($parsedEdu['end_date'])): ?>
                            <p><strong>Duration:</strong> <?php echo date('Y', strtotime($parsedEdu['start_date'])); ?> - <?php echo date('Y', strtotime($parsedEdu['end_date'])); ?></p>
                        <?php endif; ?>
                    </div>
                    <p class="mt-2 text-xs text-gray-400">This education data has been automatically filled below. You can edit if needed.</p>
                </div>
            <?php endif; ?>

            <?php
            // Set up the values to use for form fields - FIXED LOGIC
            $currentSchoolName = '';
            $currentEducationLevel = '';
            $currentFieldOfStudy = '';
            $currentStartYear = '';
            $currentEndYear = '';

            // Priority: POST data > Parsed data > Existing DB data
            if (!empty($_POST['school_name'])) {
                $currentSchoolName = $_POST['school_name'];
            } elseif (!empty($_SESSION['parsed_resume_data']['education']['school_name'])) {
                $currentSchoolName = $_SESSION['parsed_resume_data']['education']['school_name'];
            } elseif (!empty($education) && !empty($education[0]['school_name'])) {
                $currentSchoolName = $education[0]['school_name'];
            }

            if (!empty($_POST['education_level'])) {
                $currentEducationLevel = $_POST['education_level'];
            } elseif (!empty($_SESSION['parsed_resume_data']['education']['education_level'])) {
                // FIXED: Map the parsed education level to our dropdown values with better matching
                $parsedLevel = strtolower($_SESSION['parsed_resume_data']['education']['education_level']);
                
                // More comprehensive mapping
                if (strpos($parsedLevel, 'bachelor') !== false || strpos($parsedLevel, "bachelor's") !== false || strpos($parsedLevel, 'undergraduate') !== false) {
                    $currentEducationLevel = 'Bachelor';
                } elseif (strpos($parsedLevel, 'master') !== false || strpos($parsedLevel, "master's") !== false || strpos($parsedLevel, 'graduate') !== false) {
                    $currentEducationLevel = 'Master';
                } elseif (strpos($parsedLevel, 'doctoral') !== false || strpos($parsedLevel, 'doctorate') !== false || strpos($parsedLevel, 'phd') !== false || strpos($parsedLevel, 'ph.d') !== false) {
                    $currentEducationLevel = 'Doctorate';
                } elseif (strpos($parsedLevel, 'associate') !== false) {
                    $currentEducationLevel = 'Associate';
                } elseif (strpos($parsedLevel, 'high school') !== false || strpos($parsedLevel, 'secondary') !== false || strpos($parsedLevel, 'senior high') !== false) {
                    $currentEducationLevel = 'High School';
                } elseif (strpos($parsedLevel, 'vocational') !== false || strpos($parsedLevel, 'technical') !== false || strpos($parsedLevel, 'tesda') !== false) {
                    $currentEducationLevel = 'Vocational';
                } else {
                    $currentEducationLevel = 'Bachelor'; // Default fallback
                }
            } elseif (!empty($education) && !empty($education[0]['education_level'])) {
                $currentEducationLevel = $education[0]['education_level'];
            }

            if (!empty($_POST['field_of_study'])) {
                $currentFieldOfStudy = $_POST['field_of_study'];
            } elseif (!empty($_SESSION['parsed_resume_data']['education']['field_of_study'])) {
                $currentFieldOfStudy = $_SESSION['parsed_resume_data']['education']['field_of_study'];
            } elseif (!empty($education) && !empty($education[0]['field_of_study'])) {
                $currentFieldOfStudy = $education[0]['field_of_study'];
            }

            if (!empty($_POST['start_year'])) {
                $currentStartYear = $_POST['start_year'];
            } elseif (!empty($_SESSION['parsed_resume_data']['education']['start_date'])) {
                $currentStartYear = date('Y', strtotime($_SESSION['parsed_resume_data']['education']['start_date']));
            } elseif (!empty($education) && !empty($education[0]['start_date'])) {
                $currentStartYear = date('Y', strtotime($education[0]['start_date']));
            }

            if (!empty($_POST['end_year'])) {
                $currentEndYear = $_POST['end_year'];
            } elseif (!empty($_SESSION['parsed_resume_data']['education']['end_date'])) {
                $currentEndYear = date('Y', strtotime($_SESSION['parsed_resume_data']['education']['end_date']));
            } elseif (!empty($education) && !empty($education[0]['end_date'])) {
                $currentEndYear = date('Y', strtotime($education[0]['end_date']));
            }

            // Debug output
            error_log("STEP 3 DEBUG: Current education level = '$currentEducationLevel'");
            error_log("STEP 3 DEBUG: Current school name = '$currentSchoolName'");
            ?>

            <form class="space-y-6" method="POST" action="?page=complete-jobseeker-profile&step=3" id="educationForm">
                <!-- Institution Name -->
                <div>
                    <label for="school_name" class="block mb-1 text-xs font-medium text-gray-500">
                        Institution Name <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-1">
                        <input id="school_name" name="school_name" type="text" required
                            value="<?php echo htmlspecialchars($currentSchoolName); ?>"
                            placeholder="e.g., University of the Philippines"
                            maxlength="100"
                            class="block w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-400 transition-all bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary hover:border-gray-400"
                            oninput="validateInstitutionName(this)">
                        <div id="school_name_error" class="hidden mt-1 text-xs text-red-600"></div>
                    </div>
                </div>

                <!-- Degree/Program - FIXED DROPDOWN WITH PROPER ALPINE INITIALIZATION -->
                <div>
                    <label for="education_level" class="block mb-1 text-xs font-medium text-gray-500">
                        Degree / Program
                    </label>
                    <div class="relative mt-1"
                        x-data="educationLevelDropdown()"
                        x-init="initializeSelected('<?php echo htmlspecialchars($currentEducationLevel); ?>')">

                        <button type="button"
                            @click="toggleDropdown()"
                            @click.away="closeDropdown()"
                            class="flex items-center justify-between w-full px-3 py-2 pr-10 text-sm text-gray-700 transition-all duration-200 bg-white border border-gray-300 rounded-md shadow-sm appearance-none hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary"
                            :class="{'border-red-500': hasError, 'border-green-500': isValid}">
                            <span x-text="getDisplayText()"
                                :class="selected === '' ? 'text-gray-400' : 'text-gray-700'"></span>
                            <svg class="w-4 h-4 text-gray-400 transition-transform duration-200"
                                :class="{'rotate-180': isOpen}"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <!-- Hidden input for form submission -->
                        <input type="hidden" name="education_level" :value="selected" x-ref="hiddenInput">

                        <!-- Dropdown Menu -->
                        <div x-show="isOpen"
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute left-0 z-50 w-full mt-2 overflow-y-auto bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 max-h-60"
                            style="display: none;">
                            <div class="py-1">
                                <template x-for="option in options" :key="option.value">
                                    <button type="button"
                                        @click="selectOption(option.value)"
                                        class="flex items-center w-full px-4 py-2 text-sm text-left text-gray-700 transition-colors duration-150 hover:bg-gray-100"
                                        :class="{'bg-blue-50 text-blue-700': selected === option.value}"
                                        x-text="option.label">
                                    </button>
                                </template>
                            </div>
                        </div>
                        <div id="education_level_error" class="hidden mt-1 text-xs text-red-600"></div>
                    </div>
                </div>

                <!-- Field of Study -->
                <div>
                    <label for="field_of_study" class="block mb-1 text-xs font-medium text-gray-500">
                        Field of Study
                    </label>
                    <div class="mt-1">
                        <input id="field_of_study" name="field_of_study" type="text"
                            value="<?php echo htmlspecialchars($currentFieldOfStudy); ?>"
                            placeholder="e.g., Computer Science, Business Administration"
                            maxlength="100"
                            class="block w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-400 transition-all bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary hover:border-gray-400"
                            oninput="validateFieldOfStudy(this)">
                        <div id="field_of_study_error" class="hidden mt-1 text-xs text-red-600"></div>
                    </div>
                </div>

                <!-- Year Range -->
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <!-- Start Year - FIXED DROPDOWN -->
                    <div>
                        <label for="start_year" class="block mb-1 text-xs font-medium text-gray-500">
                            Start Year <span class="text-red-500">*</span>
                        </label>
                        <div class="relative mt-1"
                            x-data="yearDropdown('start')"
                            x-init="initializeSelected('<?php echo htmlspecialchars($currentStartYear); ?>')">

                            <button type="button"
                                @click="toggleDropdown()"
                                @click.away="closeDropdown()"
                                class="flex items-center justify-between w-full px-3 py-2 pr-10 text-sm text-gray-700 transition-all duration-200 bg-white border border-gray-300 rounded-md shadow-sm appearance-none hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary"
                                :class="{'border-red-500': hasError, 'border-green-500': isValid}">
                                <span x-text="getDisplayText()"
                                    :class="selected === '' ? 'text-gray-400' : 'text-gray-700'"></span>
                                <svg class="w-4 h-4 text-gray-400 transition-transform duration-200"
                                    :class="{'rotate-180': isOpen}"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <!-- Hidden input for form submission -->
                            <input type="hidden" name="start_year" :value="selected" required>

                            <!-- Dropdown Menu -->
                            <div x-show="isOpen"
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                class="absolute left-0 z-50 w-full mt-2 overflow-y-auto bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 max-h-60"
                                style="display: none;">
                                <div class="py-1">
                                    <template x-for="year in years" :key="year">
                                        <button type="button"
                                            @click="selectOption(year)"
                                            class="flex items-center w-full px-4 py-2 text-sm text-left text-gray-700 transition-colors duration-150 hover:bg-gray-100"
                                            :class="{'bg-blue-50 text-blue-700': selected === year.toString()}"
                                            x-text="year">
                                        </button>
                                    </template>
                                </div>
                            </div>
                            <div id="start_year_error" class="hidden mt-1 text-xs text-red-600"></div>
                        </div>
                    </div>

                    <!-- End Year - FIXED DROPDOWN -->
                    <div>
                        <label for="end_year" class="block mb-1 text-xs font-medium text-gray-500">
                            End Year <span class="text-red-500">*</span>
                        </label>
                        <div class="relative mt-1"
                            x-data="yearDropdown('end')"
                            x-init="initializeSelected('<?php echo htmlspecialchars($currentEndYear); ?>')">

                            <button type="button"
                                @click="toggleDropdown()"
                                @click.away="closeDropdown()"
                                class="flex items-center justify-between w-full px-3 py-2 pr-10 text-sm text-gray-700 transition-all duration-200 bg-white border border-gray-300 rounded-md shadow-sm appearance-none hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary"
                                :class="{'border-red-500': hasError, 'border-green-500': isValid}">
                                <span x-text="getDisplayText()"
                                    :class="selected === '' ? 'text-gray-400' : 'text-gray-700'"></span>
                                <svg class="w-4 h-4 text-gray-400 transition-transform duration-200"
                                    :class="{'rotate-180': isOpen}"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <!-- Hidden input for form submission -->
                            <input type="hidden" name="end_year" :value="selected" required>

                            <!-- Dropdown Menu -->
                            <div x-show="isOpen"
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                class="absolute left-0 z-50 w-full mt-2 overflow-y-auto bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 max-h-60"
                                style="display: none;">
                                <div class="py-1">
                                    <button type="button"
                                        @click="selectOption('Present')"
                                        class="flex items-center w-full px-4 py-2 text-sm font-medium text-left transition-colors duration-150 text-primary hover:bg-blue-50"
                                        :class="{'bg-blue-50 text-blue-700': selected === 'Present'}">
                                        Present (Currently Studying)
                                    </button>
                                    <template x-for="year in years" :key="year">
                                        <button type="button"
                                            @click="selectOption(year)"
                                            class="flex items-center w-full px-4 py-2 text-sm text-left text-gray-700 transition-colors duration-150 hover:bg-gray-100"
                                            :class="{'bg-blue-50 text-blue-700': selected === year.toString()}"
                                            x-text="year">
                                        </button>
                                    </template>
                                </div>
                            </div>
                            <div id="end_year_error" class="hidden mt-1 text-xs text-red-600"></div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-between">
                    <a href="?page=complete-jobseeker-profile&step=2" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Previous Step
                    </a>
                    <button type="submit" name="submit_step3"
                        class="inline-flex items-center px-6 py-2 text-sm font-medium text-white border border-transparent rounded-md shadow-sm bg-primary hover:bg-blue-700"
                        id="submitBtn">
                        <?php echo (!empty($education) ? 'Update & Continue' : 'Next Step'); ?>
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Load Alpine.js first -->
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

<script>
    // Alpine.js functions must be defined before Alpine loads
    window.educationLevelDropdown = function() {
        return {
            isOpen: false,
            selected: '',
            hasError: false,
            isValid: false,
            options: [{
                    value: '',
                    label: 'Select Degree/Program'
                },
                {
                    value: 'High School',
                    label: 'High School'
                },
                {
                    value: 'Vocational',
                    label: 'Vocational/Technical'
                },
                {
                    value: 'Associate',
                    label: 'Associate Degree'
                },
                {
                    value: 'Bachelor',
                    label: "Bachelor's Degree"
                },
                {
                    value: 'Master',
                    label: "Master's Degree"
                },
                {
                    value: 'Doctorate',
                    label: 'Doctorate/PhD'
                },
                {
                    value: 'Other',
                    label: 'Other'
                }
            ],

            initializeSelected(value) {
                console.log('Initializing education level with:', value);
                if (value && value !== '') {
                    this.selected = value;
                    this.isValid = true;
                }
            },

            toggleDropdown() {
                this.isOpen = !this.isOpen;
                console.log('Education dropdown toggled:', this.isOpen);
            },

            closeDropdown() {
                this.isOpen = false;
            },

            selectOption(value) {
                console.log('Education level selected:', value);
                this.selected = value;
                this.isOpen = false;
                this.hasError = false;
                this.isValid = value !== '';

                // Update the hidden input
                this.$refs.hiddenInput.value = value;

                // Clear any existing error
                document.getElementById('education_level_error').classList.add('hidden');
            },

            getDisplayText() {
                if (this.selected === '') {
                    return 'Select Degree/Program';
                }
                const option = this.options.find(opt => opt.value === this.selected);
                return option ? option.label : this.selected;
            }
        }
    };

    window.yearDropdown = function(type) {
        return {
            isOpen: false,
            selected: '',
            hasError: false,
            isValid: false,
            type: type,

            get years() {
                const currentYear = new Date().getFullYear();
                const years = [];

                if (this.type === 'end') {
                    // For end year, allow up to 10 years in the future
                    for (let year = currentYear + 10; year >= 1950; year--) {
                        years.push(year);
                    }
                } else {
                    // For start year, only up to current year
                    for (let year = currentYear; year >= 1950; year--) {
                        years.push(year);
                    }
                }

                return years;
            },

            initializeSelected(value) {
                console.log(`Initializing ${this.type} year with:`, value);
                if (value && value !== '') {
                    this.selected = value;
                    this.isValid = true;
                }
            },

            toggleDropdown() {
                this.isOpen = !this.isOpen;
                console.log(`${this.type} year dropdown toggled:`, this.isOpen);
            },

            closeDropdown() {
                this.isOpen = false;
            },

            selectOption(value) {
                console.log(`${this.type} year selected:`, value);
                this.selected = value.toString();
                this.isOpen = false;
                this.hasError = false;
                this.isValid = true;

                // Clear any existing error
                document.getElementById(`${this.type}_year_error`).classList.add('hidden');
            },

            getDisplayText() {
                if (this.selected === '') {
                    return 'Select Year';
                }
                return this.selected;
            }
        }
    };

    // Regular validation functions
    function validateInstitutionName(input) {
        const value = input.value.trim();
        const errorDiv = document.getElementById('school_name_error');
        const institutionRegex = /^[a-zA-Z\s.,&'-]+$/;

        // Reset styles
        input.classList.remove('border-red-500', 'border-green-500');
        errorDiv.classList.add('hidden');

        if (value === '') {
            showError(input, errorDiv, 'Institution name is required');
            return false;
        }

        if (value.length < 2) {
            showError(input, errorDiv, 'Must be at least 2 characters');
            return false;
        }

        if (value.length > 100) {
            showError(input, errorDiv, 'Must be less than 100 characters');
            return false;
        }

        if (!institutionRegex.test(value)) {
            showError(input, errorDiv, 'Only letters, spaces, periods, commas, apostrophes, hyphens, and "&" are allowed');
            return false;
        }

        // Capitalize each word
        const capitalizedValue = value.split(' ')
            .map(word => word.charAt(0).toUpperCase() + word.slice(1).toLowerCase())
            .join(' ');

        input.value = capitalizedValue;

        // Valid
        input.classList.add('border-green-500');
        return true;
    }

    function validateFieldOfStudy(input) {
        const value = input.value.trim();
        const errorDiv = document.getElementById('field_of_study_error');
        const fieldRegex = /^[a-zA-Z\s&.-]*$/;

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

        if (!fieldRegex.test(value)) {
            showError(input, errorDiv, 'Only letters, spaces, periods, hyphens, and "&" are allowed');
            return false;
        }

        // Capitalize each word if value is not empty
        if (value.length > 0) {
            const capitalizedValue = value.split(' ')
                .map(word => word.charAt(0).toUpperCase() + word.slice(1).toLowerCase())
                .join(' ');

            input.value = capitalizedValue;
        }

        // Valid
        input.classList.add('border-green-500');
        return true;
    }

    function validateYears() {
        const startYearInput = document.querySelector('input[name="start_year"]');
        const endYearInput = document.querySelector('input[name="end_year"]');
        const startYearError = document.getElementById('start_year_error');
        const endYearError = document.getElementById('end_year_error');

        let isValid = true;

        // Reset error states
        startYearError.classList.add('hidden');
        endYearError.classList.add('hidden');

        // Validate start year
        if (!startYearInput.value || startYearInput.value === '') {
            showError(null, startYearError, 'Start year is required');
            isValid = false;
        } else {
            const startYear = parseInt(startYearInput.value);
            const currentYear = new Date().getFullYear();

            if (startYear < 1950) {
                showError(null, startYearError, 'Start year must be 1950 or later');
                isValid = false;
            } else if (startYear > currentYear) {
                showError(null, startYearError, 'Start year cannot be in the future');
                isValid = false;
            }
        }

        // Validate end year
        if (!endYearInput.value || endYearInput.value === '') {
            showError(null, endYearError, 'End year is required');
            isValid = false;
        } else if (endYearInput.value !== 'Present') {
            const endYear = parseInt(endYearInput.value);
            const startYear = parseInt(startYearInput.value);
            const currentYear = new Date().getFullYear();

            if (endYear > currentYear + 10) {
                showError(null, endYearError, 'End year is too far in the future');
                isValid = false;
            } else if (startYear && endYear < startYear) {
                showError(null, endYearError, 'End year must be greater than or equal to start year');
                isValid = false;
            }
        }

        return isValid;
    }

    function showError(input, errorDiv, message) {
        if (input) {
            input.classList.add('border-red-500');
            // Add shake animation
            input.style.animation = 'none';
            input.offsetHeight; // Trigger reflow
            input.style.animation = 'shake 0.5s';
        }

        errorDiv.textContent = message;
        errorDiv.classList.remove('hidden');
        errorDiv.classList.add('text-red-600', 'font-medium');

        // Add animation keyframes if they don't exist
        if (!document.getElementById('shakeAnimation')) {
            const style = document.createElement('style');
            style.id = 'shakeAnimation';
            style.textContent = `
            @keyframes shake {
                0%, 100% { transform: translateX(0); }
                25% { transform: translateX(-5px); }
                75% { transform: translateX(5px); }
            }
        `;
            document.head.appendChild(style);
        }
    }

    // Form submission validation
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM Content Loaded - Step 3');

        // Wait a bit for Alpine.js to initialize
        setTimeout(() => {
            console.log('Alpine.js should be initialized now');

            // Test if dropdowns are working
            const dropdowns = document.querySelectorAll('[x-data]');
            console.log('Found', dropdowns.length, 'Alpine components');

            dropdowns.forEach((dropdown, index) => {
                console.log(`Dropdown ${index}:`, dropdown.__x);
            });
        }, 100);

        const form = document.getElementById('educationForm');
        if (form) {
            form.addEventListener('submit', function(e) {
                let isValid = true;

                // Validate all fields
                const institutionName = document.getElementById('school_name');
                const fieldOfStudy = document.getElementById('field_of_study');

                if (!validateInstitutionName(institutionName)) isValid = false;
                if (!validateFieldOfStudy(fieldOfStudy)) isValid = false;
                if (!validateYears()) isValid = false;

                // Check dropdowns
                const educationLevelInput = document.querySelector('input[name="education_level"]');
                if (!educationLevelInput.value || educationLevelInput.value === '') {
                    document.getElementById('education_level_error').textContent = 'Please select an education level';
                    document.getElementById('education_level_error').classList.remove('hidden');
                    isValid = false;
                }

                if (!isValid) {
                    e.preventDefault();
                    alert('Please fix the errors before continuing.');
                }
            });
        }
    });
</script>