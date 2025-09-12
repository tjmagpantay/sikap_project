<?php
include_once __DIR__ . '/../components/jobseeker_auth_check.php';
include_once __DIR__ . '/../../components/navbar-top.php';
include_once __DIR__ . '/../navbar-jobseeker.php';

// Display success/error messages from session (like Step 4)
if (isset($_SESSION['success_message'])) {
    $success = $_SESSION['success_message'];
    unset($_SESSION['success_message']);
}
if (isset($_SESSION['error_message'])) {
    $error = $_SESSION['error_message'];
    unset($_SESSION['error_message']);
}

// Check if we have parsed data in session
$parsedSkills = [];
if (isset($_SESSION['parsed_resume_data']['skills']) && !empty($_SESSION['parsed_resume_data']['skills'])) {
    $parsedSkills = $_SESSION['parsed_resume_data']['skills'];
}
?>

<div class="min-h-screen py-6">
    <div class="sm:mx-auto sm:w-full sm:max-w-2xl">
        <div class="text-center">
            <div class="flex justify-center mb-4">
                <div class="flex items-center justify-center w-12 h-12 rounded-full bg-primary">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                    </svg>
                </div>
            </div>
            <h2 class="mt-6 text-3xl font-extrabold text-center text-gray-900">
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

            <!-- Success/Error Messages (like Step 4) -->
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

            <!-- Display existing skills if available -->
            <?php if (!empty($skills) && is_array($skills) && count($skills) > 0): ?>
                <div class="p-6 mb-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                    <h3 class="mb-4 text-lg font-medium text-gray-900">Your Current Skills</h3>
                    <div class="flex flex-wrap gap-2">
                        <?php foreach ($skills as $skill): ?>
                            <div class="inline-flex items-center px-3 py-1 text-sm font-medium text-blue-800 bg-blue-100 rounded-full">
                                <?php echo htmlspecialchars($skill['skill_name']); ?>
                                <span class="ml-2 text-xs text-blue-600">
                                    (<?php echo htmlspecialchars($skill['proficiency_level']); ?>)
                                </span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Display parsed skills if available -->
            <?php if (!empty($parsedSkills)): ?>
                <div class="p-4 mb-6 border border-green-200 rounded-lg bg-green-50">
                    <h3 class="mb-2 text-sm font-medium text-green-800">
                        <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Skills extracted from your resume:
                    </h3>
                    <div class="flex flex-wrap gap-2">
                        <?php foreach ($parsedSkills as $skill): ?>
                            <span class="inline-flex items-center px-2 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-md">
                                <?php echo htmlspecialchars($skill['skill_name']); ?>
                                <?php if (isset($skill['esco_uri']) && !empty($skill['esco_uri'])): ?>
                                    <span class="ml-1 text-xs text-green-600">(ESCO)</span>
                                <?php endif; ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                    <p class="mt-2 text-xs text-green-600">These skills have been automatically added below. You can edit or add more.</p>
                </div>
            <?php endif; ?>

            <form class="space-y-6" method="POST" action="?page=complete-jobseeker-profile&step=5" id="skillsForm">
                <div>
                    <label class="block mb-4 text-sm font-medium text-gray-700">Skills</label>
                    <div id="skills-container">
                        <?php
                        $allSkills = [];

                        // First add existing skills from database
                        if (!empty($skills) && $skills !== false) {
                            foreach ($skills as $skill) {
                                $allSkills[] = $skill;
                            }
                        } else {
                            // Only add parsed skills if no database skills exist
                            if (!empty($parsedSkills)) {
                                foreach ($parsedSkills as $skill) {
                                    $allSkills[] = $skill;
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

                                <div class="flex-1">
                                    <input type="text"
                                        name="skills[<?php echo $index; ?>][skill_name]"
                                        value="<?php echo htmlspecialchars($skill['skill_name'] ?? ''); ?>"
                                        placeholder="Enter skill name"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary">
                                </div>
                                <div class="w-32">
                                    <select name="skills[<?php echo $index; ?>][proficiency_level]"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary">
                                        <option value="Beginner" <?php echo (isset($skill['proficiency_level']) && $skill['proficiency_level'] === 'Beginner') ? 'selected' : ''; ?>>Beginner</option>
                                        <option value="Intermediate" <?php echo (!isset($skill['proficiency_level']) || $skill['proficiency_level'] === 'Intermediate') ? 'selected' : ''; ?>>Intermediate</option>
                                        <option value="Advanced" <?php echo (isset($skill['proficiency_level']) && $skill['proficiency_level'] === 'Advanced') ? 'selected' : ''; ?>>Advanced</option>
                                        <option value="Expert" <?php echo (isset($skill['proficiency_level']) && $skill['proficiency_level'] === 'Expert') ? 'selected' : ''; ?>>Expert</option>
                                    </select>
                                </div>

                                <!-- FIXED: Delete button for existing skills -->
                                <?php if (isset($skill['skill_id']) && !empty($skill['skill_id'])): ?>
                                    <button type="button" class="px-3 py-2 text-red-600 transition-colors border border-red-200 rounded-md hover:text-white hover:bg-red-600 hover:border-red-600"
                                        onclick="deleteExistingSkill(<?php echo $skill['skill_id']; ?>)">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                <?php else: ?>
                                    <!-- JavaScript remove for new skills -->
                                    <button type="button" class="px-3 py-2 text-red-600 remove-skill hover:text-red-800" onclick="removeNewSkill(this)">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <button type="button" id="add-skill" class="inline-flex items-center px-4 py-2 mt-4 text-sm font-medium border rounded-md text-primary border-primary hover:bg-primary hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Add Another Skill
                    </button>
                </div>

                <!-- FIXED: Updated buttons to match Step 4 pattern exactly -->
                <div class="flex justify-between">
                    <a href="?page=complete-jobseeker-profile&step=4"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Previous Step
                    </a>

                    <div class="flex space-x-3">


                        <!-- FIXED: Continue Button - matches Step 4 "Next Step" button exactly -->
                        <button type="submit" name="submit_step5"
                            class="inline-flex items-center px-6 py-2 text-sm font-medium text-white border border-transparent rounded-md shadow-sm bg-primary hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <span>
                                <?php if (!empty($skills)): ?>
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
            </form>
        </div>
    </div>
</div>

<!-- FIXED: Updated JavaScript -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let skillCount = <?php echo count($allSkills); ?>;
        const addSkillBtn = document.getElementById('add-skill');
        const skillsContainer = document.getElementById('skills-container');

        // FIXED: Add new skill row function
        function addEmptySkillRow() {
            const skillRow = document.createElement('div');
            skillRow.className = 'skill-row flex gap-4 mb-4';
            skillRow.setAttribute('data-index', skillCount);

            skillRow.innerHTML = `
        <div class="flex-1">
            <input type="text" 
                   name="skills[${skillCount}][skill_name]" 
                   placeholder="Enter skill name" 
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary">
        </div>
        <div class="w-32">
            <select name="skills[${skillCount}][proficiency_level]" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary">
                <option value="Beginner">Beginner</option>
                <option value="Intermediate" selected>Intermediate</option>
                <option value="Advanced">Advanced</option>
                <option value="Expert">Expert</option>
            </select>
        </div>
        <button type="button" class="px-3 py-2 text-red-600 remove-skill hover:text-red-800" onclick="removeNewSkill(this)">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
            </svg>
        </button>
    `;

            skillsContainer.appendChild(skillRow);
            skillCount++;
        }

        // FIXED: Event listener for add button
        if (addSkillBtn) {
            addSkillBtn.addEventListener('click', function(e) {
                e.preventDefault();
                addEmptySkillRow();
            });
        }

        // FIXED: Remove new skill function
        window.removeNewSkill = function(button) {
            const skillRows = document.querySelectorAll('.skill-row');
            if (skillRows.length > 1) {
                button.closest('.skill-row').remove();
            } else {
                // Don't allow removing the last skill row, just clear it
                const inputs = button.closest('.skill-row').querySelectorAll('input, select');
                inputs.forEach(input => {
                    if (input.tagName === 'INPUT') {
                        input.value = '';
                    } else if (input.tagName === 'SELECT') {
                        input.selectedIndex = 1; // Set to Intermediate
                    }
                });
            }
        };

        // FIXED: Delete existing skill function
        window.deleteExistingSkill = function(skillId) {
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
        };

        // FIXED: Form submission handling - remove all validation
        const form = document.getElementById('skillsForm');
        if (form) {
            form.addEventListener('submit', function(e) {
                // Let all form submissions go through without validation
                console.log('Form submitted');
                return true;
            });
        }
    });
</script>