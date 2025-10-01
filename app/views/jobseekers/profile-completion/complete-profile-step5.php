<?php
include_once __DIR__ . '/../components/jobseeker_auth_check.php';
include_once __DIR__ . '/../../components/navbar-top.php';
include_once __DIR__ . '/../components/navbar-jobseeker.php';

// Display success/error messages from session (like Step 4)
if (isset($_SESSION['success_message'])) {
    $success = $_SESSION['success_message'];
    unset($_SESSION['success_message']);
}
if (isset($_SESSION['error_message'])) {
    $error = $_SESSION['error_message'];
    unset($_SESSION['error_message']);
}

?>

<div class="min-h-screen py-6">
    <div class="sm:mx-auto sm:w-full sm:max-w-2xl">
        <div class="text-center">

            <h2 class="mt-2 text-3xl font-extrabold text-center text-grayMain">
                Skills & Expertise
            </h2>
            <p class="mt-2 text-sm text-center text-gray-500">
                Add your skills and proficiency levels
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
                        <a href="?page=complete-jobseeker-profile&step=4" class="flex items-center justify-center w-8 h-8 text-gray-500 transition-colors bg-gray-200 rounded-full hover:bg-gray-300 hover:text-gray-700">
                            <span class="text-sm font-semibold">4</span>
                        </a>
                        <span class="mt-1 text-xs text-gray-500">Experience</span>
                    </div>

                    <!-- Step 5 - Current -->
                    <div class="flex flex-col items-center">
                        <div class="flex items-center justify-center w-8 h-8 text-white rounded-full bg-primary">
                            <span class="text-sm font-semibold">5</span>
                        </div>
                        <span class="mt-1 text-xs text-gray-600">Skills</span>
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
                    <div class="h-2 rounded bg-primary" style="width: 71.43%"></div>
                </div>
            </div>

            <!-- Success/Error Messages -->
            <?php if (!empty($success)): ?>
                <div class="p-4 mb-4 border border-blue-400 rounded-md bg-blue-50">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-primary"><?php echo htmlspecialchars($success); ?></p>
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

            <!-- Display existing skills if available -->
            <?php if (!empty($skills) && is_array($skills) && count($skills) > 0): ?>
                <div class="p-6 mb-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                    <h3 class="mb-4 text-sm font-medium text-primary">Your Current Skills</h3>
                    <div class="flex flex-wrap gap-2">
                        <?php foreach ($skills as $skill): ?>
                            <div class="inline-flex items-center px-2 py-1 text-xs font-medium text-gray-600 border rounded-md">
                                <?php echo htmlspecialchars($skill['skill_name']); ?>
                                <span class="ml-2 text-xs text-gary-400">
                                    (<?php echo htmlspecialchars($skill['proficiency_level']); ?>)
                                </span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Display parsed skills if available -->
            <?php if (!empty($parsedSkills)): ?>
                <div class="p-4 mb-6 border border-gray-200 rounded-lg bg-gray-50">
                    <h3 class="mb-2 text-sm font-medium text-primary">
                      
                        Skills extracted from your resume:
                    </h3>
                    <div class="flex flex-wrap gap-2">
                        <?php foreach ($parsedSkills as $skill): ?>
                            <span class="inline-flex items-center px-2 py-1 text-xs font-medium text-gray-600 bg-gray-100 border border-gray-300 rounded-md">
                                <?php echo htmlspecialchars($skill['skill_name']); ?>
                                <?php if (isset($skill['esco_uri']) && !empty($skill['esco_uri'])): ?>
                                    <span class="ml-1 text-xs text-gray-600">(ESCO)</span>
                                <?php endif; ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                    <p class="mt-2 text-xs text-gray-400">These skills have been automatically added to the form below. You can edit or add more.</p>
                </div>
            <?php endif; ?>

            <form class="space-y-6" method="POST" action="?page=complete-jobseeker-profile&step=5" id="skillsForm">
                <div>
                    <label class="block mb-3 text-xs font-medium text-gray-500">Skills</label>
                    <div id="skills-container">
                        <?php
                        // Proper merging logic to avoid duplicates and include parsed skills
                        $allSkills = [];
                        $skillNames = []; // Track skill names to avoid duplicates

                        // First, add existing skills from database if available
                        if (!empty($skills) && is_array($skills)) {
                            foreach ($skills as $skill) {
                                $skillName = strtolower(trim($skill['skill_name']));
                                if (!empty($skillName) && !in_array($skillName, $skillNames)) {
                                    $allSkills[] = $skill;
                                    $skillNames[] = $skillName;
                                }
                            }
                        }

                        // Then, add parsed skills that aren't already in the database
                        if (!empty($parsedSkills)) {
                            foreach ($parsedSkills as $parsedSkill) {
                                $skillName = strtolower(trim($parsedSkill['skill_name']));
                                if (!empty($skillName) && !in_array($skillName, $skillNames)) {
                                    // Add parsed skill without skill_id (new skill)
                                    $skillToAdd = [
                                        'skill_name' => $parsedSkill['skill_name'],
                                        'proficiency_level' => $parsedSkill['proficiency_level'] ?? 'Intermediate',
                                        'esco_uri' => $parsedSkill['esco_uri'] ?? null
                                    ];
                                    $allSkills[] = $skillToAdd;
                                    $skillNames[] = $skillName;
                                }
                            }
                        }

                        // If no skills at all, add one empty row
                        if (empty($allSkills)) {
                            $allSkills[] = ['skill_name' => '', 'proficiency_level' => 'Intermediate'];
                        }

                        foreach ($allSkills as $index => $skill): ?>
                            <div class="flex gap-4 mb-4 skill-row" data-index="<?php echo $index; ?>">
                                <!-- Hidden field for skill ID if it exists -->
                                <?php if (isset($skill['skill_id'])): ?>
                                    <input type="hidden" name="skills[<?php echo $index; ?>][skill_id]" value="<?php echo $skill['skill_id']; ?>">
                                <?php endif; ?>

                                <!-- Hidden field for ESCO URI if it exists -->
                                <?php if (isset($skill['esco_uri']) && !empty($skill['esco_uri'])): ?>
                                    <input type="hidden" name="skills[<?php echo $index; ?>][esco_uri]" value="<?php echo htmlspecialchars($skill['esco_uri']); ?>">
                                <?php endif; ?>

                                <!-- Skill Name Input -->
                                <div class="flex-1 min-w-0">
                                    <input type="text"
                                        name="skills[<?php echo $index; ?>][skill_name]"
                                        value="<?php echo htmlspecialchars($skill['skill_name'] ?? ''); ?>"
                                        placeholder="Enter skill name"
                                        maxlength="50"
                                        class="w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-400 transition-all bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary hover:border-gray-400 <?php echo (!empty($skill['skill_name']) && !isset($skill['skill_id'])) ? 'bg-gray-100 border-gray-400' : ''; ?>"
                                        oninput="validateSkillName(this)"
                                        data-skill-index="<?php echo $index; ?>"
                                        <?php echo (!empty($skill['skill_name']) && !isset($skill['skill_id'])) ? 'title="This skill was extracted from your resume"' : ''; ?>>
                                    <div id="skill_name_error_<?php echo $index; ?>" class="hidden mt-1 text-xs text-red-600"></div>
                                </div>

                                <!-- Proficiency Level Dropdown -->
                                <div class="relative flex-shrink-0 w-28" x-data="{ open: false, selected: '<?php echo htmlspecialchars($skill['proficiency_level'] ?? 'Intermediate'); ?>' }">
                                    <button type="button" @click="open = !open"
                                        @click.away="open = false"
                                        class="flex items-center justify-between w-full px-2 py-2 text-xs text-gray-700 transition-all duration-200 bg-white border border-gray-300 rounded-md shadow-sm appearance-none hover:border-gray-400 focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary <?php echo (!empty($skill['skill_name']) && !isset($skill['skill_id'])) ? 'bg-gray-100 border-gray-300' : ''; ?>">
                                        <span x-text="selected" class="pr-1 truncate"></span>
                                        <svg class="flex-shrink-0 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>

                                    <!-- Hidden input for form submission -->
                                    <input type="hidden" name="skills[<?php echo $index; ?>][proficiency_level]" x-model="selected">

                                    <!-- Dropdown Menu -->
                                    <div x-show="open"
                                        x-transition:enter="transition ease-out duration-100"
                                        x-transition:enter-start="transform opacity-0 scale-95"
                                        x-transition:enter-end="transform opacity-100 scale-100"
                                        x-transition:leave="transition ease-in duration-75"
                                        x-transition:leave-start="transform opacity-100 scale-100"
                                        x-transition:leave-end="transform opacity-0 scale-95"
                                        class="absolute left-0 z-50 w-32 mt-1 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5"
                                        x-cloak>
                                        <div class="py-1">
                                            <button type="button"
                                                @click="selected = 'Beginner'; open = false"
                                                class="flex items-center w-full px-3 py-2 text-xs text-left text-gray-700 hover:bg-gray-100">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 w-2 h-2 mr-2 rounded-full bg-primary"></div>
                                                    <span class="truncate">Beginner</span>
                                                </div>
                                            </button>
                                            <button type="button"
                                                @click="selected = 'Intermediate'; open = false"
                                                class="flex items-center w-full px-3 py-2 text-xs text-left text-gray-700 hover:bg-gray-100">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 w-2 h-2 mr-2 bg-yellow-400 rounded-full"></div>
                                                    <span class="truncate">Intermediate</span>
                                                </div>
                                            </button>
                                            <button type="button"
                                                @click="selected = 'Advanced'; open = false"
                                                class="flex items-center w-full px-3 py-2 text-xs text-left text-gray-700 hover:bg-gray-100">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 w-2 h-2 mr-2 bg-green-600 rounded-full"></div>
                                                    <span class="truncate">Advanced</span>
                                                </div>
                                            </button>
                                            <button type="button"
                                                @click="selected = 'Expert'; open = false"
                                                class="flex items-center w-full px-3 py-2 text-xs text-left text-gray-700 hover:bg-gray-100">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 w-2 h-2 mr-2 bg-red-600 rounded-full"></div>
                                                    <span class="truncate">Expert</span>
                                                </div>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Delete Button -->
                                <?php if (isset($skill['skill_id']) && !empty($skill['skill_id'])): ?>
                                    <button type="button" class="flex-shrink-0 px-3 py-2 text-red-600 transition-colors border border-red-200 rounded-md hover:text-white hover:bg-red-600 hover:border-red-600"
                                        onclick="deleteExistingSkill(<?php echo $skill['skill_id']; ?>)">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                <?php else: ?>
                                    <button type="button" class="flex-shrink-0 px-3 py-2 text-red-600 transition-colors border border-red-200 rounded-md hover:text-white hover:bg-red-600 hover:border-red-600 remove-skill" onclick="removeNewSkill(this)">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <button type="button" id="add-skill" class="inline-flex items-center px-4 py-2 mt-4 text-sm font-medium transition-colors duration-200 border rounded-md text-primary border-primary hover:bg-primary hover:text-white focus:outline-none focus:ring-1 focus:ring-offset-2 focus:ring-primary">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Add Another Skill
                    </button>
                </div>

                <div class="flex justify-between">
                    <a href="?page=complete-jobseeker-profile&step=4"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Previous Step
                    </a>

                    <button type="submit" name="submit_step5"
                        class="inline-flex items-center px-6 py-2 text-sm font-medium text-white border border-transparent rounded-md shadow-sm bg-primary hover:bg-blue-700">
                        <span>
                            <?php if (!empty($allSkills) && count($allSkills) > 1 || !empty($allSkills[0]['skill_name'])): ?>
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
            </form>
        </div>
    </div>
</div>

<!-- Load Alpine.js -->
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

<script>
    let skillCount = <?php echo count($allSkills); ?>;

    // Skill name validation function
    function validateSkillName(input) {
        const value = input.value.trim();
        const skillIndex = input.getAttribute('data-skill-index') || input.closest('.skill-row').getAttribute('data-index');
        const errorDiv = document.getElementById('skill_name_error_' + skillIndex);
        const skillRegex = /^[a-zA-Z\s\+\#\.\-]+$/; // Allow +, #, ., - for tech skills like C#, .NET, etc.

        // Reset styles
        input.classList.remove('border-red-500', 'border-green-500');
        if (errorDiv) {
            errorDiv.classList.add('hidden');
        }

        if (value === '') {
            return true; // Optional field
        }

        if (value.length > 50) {
            showError(input, errorDiv, 'Must be less than 50 characters');
            return false;
        }

        if (!skillRegex.test(value)) {
            showError(input, errorDiv, 'Only letters, spaces, and common symbols (+, #, ., -) are allowed');
            return false;
        }

        // Valid - add green border only for non-empty fields
        if (value.length > 0) {
            input.classList.add('border-green-500');
        }
        return true;
    }

    function showError(input, errorDiv, message) {
        input.classList.add('border-red-500');
        if (errorDiv) {
            errorDiv.textContent = message;
            errorDiv.classList.remove('hidden');
        }
    }

    // Add new skill row function
    function addEmptySkillRow() {
        const skillsContainer = document.getElementById('skills-container');
        const skillRow = document.createElement('div');
        skillRow.className = 'skill-row flex gap-4 mb-4';
        skillRow.setAttribute('data-index', skillCount);

        skillRow.innerHTML = `
        <!-- Skill Name Input -->
        <div class="flex-1 min-w-0">
            <input type="text" 
                   name="skills[${skillCount}][skill_name]" 
                   placeholder="Enter skill name"
                   maxlength="50"
                   class="w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-400 transition-all bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary hover:border-gray-400"
                   oninput="validateSkillName(this)"
                   data-skill-index="${skillCount}">
            <div id="skill_name_error_${skillCount}" class="hidden mt-1 text-xs text-red-600"></div>
        </div>

        <!-- Proficiency Level Dropdown -->
        <div class="relative flex-shrink-0 w-28" x-data="{ open: false, selected: 'Intermediate' }">
            <button type="button" @click="open = !open"
                @click.away="open = false"
                class="flex items-center justify-between w-full px-2 py-2 text-xs text-gray-700 transition-all duration-200 bg-white border border-gray-300 rounded-md shadow-sm appearance-none hover:border-gray-400 focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary">
                <span x-text="selected" class="pr-1 truncate"></span>
                <svg class="flex-shrink-0 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <!-- Hidden input for form submission -->
            <input type="hidden" name="skills[${skillCount}][proficiency_level]" x-model="selected">

            <!-- Dropdown Menu -->
            <div x-show="open"
                x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="transform opacity-0 scale-95"
                x-transition:enter-end="transform opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="transform opacity-100 scale-100"
                x-transition:leave-end="transform opacity-0 scale-95"
                class="absolute left-0 z-50 w-32 mt-1 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5"
                x-cloak>
                <div class="py-1">
                    <button type="button"
                        @click="selected = 'Beginner'; open = false"
                        class="flex items-center w-full px-3 py-2 text-xs text-left text-gray-700 hover:bg-gray-100">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-2 h-2 mr-2 bg-blue-400 rounded-full"></div>
                            <span class="truncate">Beginner</span>
                        </div>
                    </button>
                    <button type="button"
                        @click="selected = 'Intermediate'; open = false"
                        class="flex items-center w-full px-3 py-2 text-xs text-left text-gray-700 hover:bg-gray-100">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-2 h-2 mr-2 bg-yellow-400 rounded-full"></div>
                            <span class="truncate">Intermediate</span>
                        </div>
                    </button>
                    <button type="button"
                        @click="selected = 'Advanced'; open = false"
                        class="flex items-center w-full px-3 py-2 text-xs text-left text-gray-700 hover:bg-gray-100">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-2 h-2 mr-2 bg-green-600 rounded-full"></div>
                            <span class="truncate">Advanced</span>
                        </div>
                    </button>
                    <button type="button"
                        @click="selected = 'Expert'; open = false"
                        class="flex items-center w-full px-3 py-2 text-xs text-left text-gray-700 hover:bg-gray-100">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-2 h-2 mr-2 bg-red-600 rounded-full"></div>
                            <span class="truncate">Expert</span>
                        </div>
                    </button>
                </div>
            </div>
        </div>

        <!-- Delete Button -->
        <button type="button" class="flex-shrink-0 px-3 py-2 text-red-600 transition-colors border border-red-200 rounded-md hover:text-white hover:bg-red-600 hover:border-red-600" onclick="removeNewSkill(this)">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
            </svg>
        </button>
    `;

        skillsContainer.appendChild(skillRow);
        skillCount++;
    }

    // Remove skill function
    function removeNewSkill(button) {
        const skillRows = document.querySelectorAll('.skill-row');
        if (skillRows.length > 1) {
            button.closest('.skill-row').remove();
        } else {
            // Don't allow removing the last skill row, just clear it
            const skillRow = button.closest('.skill-row');
            const input = skillRow.querySelector('input[name*="[skill_name]"]');

            if (input) {
                input.value = '';
                validateSkillName(input);
            }

            // Reset Alpine.js dropdown to Intermediate
            const dropdown = skillRow.querySelector('[x-data]');
            if (dropdown && dropdown._x_dataStack && dropdown._x_dataStack[0]) {
                dropdown._x_dataStack[0].selected = 'Intermediate';
            }
        }
    }

    // Delete existing skill function
    function deleteExistingSkill(skillId) {
        if (confirm('Are you sure you want to delete this skill?')) {
            // Create and submit a hidden form for deletion
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '?page=delete-skill-simple';
            form.style.display = 'none';

            const skillIdInput = document.createElement('input');
            skillIdInput.type = 'hidden';
            skillIdInput.name = 'skill_id';
            skillIdInput.value = skillId;

            form.appendChild(skillIdInput);
            document.body.appendChild(form);
            form.submit();
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const addSkillBtn = document.getElementById('add-skill');
        const form = document.getElementById('skillsForm');

        // Event listener for add button
        if (addSkillBtn) {
            addSkillBtn.addEventListener('click', function(e) {
                e.preventDefault();
                addEmptySkillRow();
            });
        }

        // Form submission handling with validation
        if (form) {
            form.addEventListener('submit', function(e) {
                let isValid = true;

                // Validate all skill name inputs
                document.querySelectorAll('input[name*="[skill_name]"]').forEach(function(input) {
                    if (!validateSkillName(input)) {
                        isValid = false;
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    alert('Please fix the skill validation errors before continuing.');
                }
            });
        }
    });
</script>