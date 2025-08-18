<?php include_once __DIR__ . '/../../components/navbar-top.php';
include_once __DIR__ . '/../navbar-jobseeker.php'; ?>

<div class="min-h-screen py-6">
    <div class="sm:mx-auto sm:w-full sm:max-w-2xl">
        <div class="text-center">
            <div class="flex justify-center mb-4">
                <div class="flex items-center justify-center w-12 h-12 rounded-full bg-primary">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                    </svg>
                </div>
            </div>
            <h2 class="mt-6 text-3xl font-extrabold text-center text-gray-900">
                Skills & Expertise
            </h2>
            <p class="mt-2 text-sm text-center text-gray-500">
                Showcase your core skills and proficiency levels
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
                        <span class="mt-1 text-xs text-gray-500">Employment</span>
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
                        <div class="flex items-center justify-center w-8 h-8 text-white rounded-full bg-primary">
                            <span class="text-sm font-semibold">6</span>
                        </div>
                        <span class="mt-1 text-xs text-gray-600">Skills</span>
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
                    <div class="h-2 rounded bg-primary" style="width: 75%"></div>
                </div>
            </div>

            <form class="space-y-6" method="POST" action="?page=complete-jobseeker-profile&step=6">
                <div id="skills-container">
                    <div class="grid grid-cols-1 gap-6 mb-6 skill-row sm:grid-cols-2">
                        <div>
                            <label for="skills_0" class="block mb-1 text-xs font-medium text-gray-500">
                                Skill Name
                            </label>
                            <div class="mt-1">
                                <input id="skills_0" name="skills[]" type="text"
                                    placeholder="e.g., JavaScript, Communication, Project Management"
                                    class="block w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-400 transition-all bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary hover:border-gray-400">
                            </div>
                        </div>

                        <div>
                            <label for="proficiency_0" class="block mb-1 text-xs font-medium text-gray-500">
                                Proficiency Level
                            </label>
                            <div class="flex mt-1">
                                <select id="proficiency_0" name="proficiency[]"
                                    class="block w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-400 transition-all bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary hover:border-gray-400">
                                    <option value="Beginner">Beginner</option>
                                    <option value="Intermediate">Intermediate</option>
                                    <option value="Advanced">Advanced</option>
                                    <option value="Expert">Expert</option>
                                </select>
                                <button type="button" onclick="this.closest('.skill-row').remove()"
                                    class="flex items-center justify-center px-3 py-2 ml-2 text-red-600 transition-colors bg-white border border-red-300 rounded-md shadow-sm hover:bg-red-50">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-center">
                    <button type="button" id="add-skill"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-white transition-colors border border-transparent rounded-md shadow-sm bg-primary hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Add Another Skill
                    </button>
                </div>

                <div class="flex justify-between">
                    <a href="?page=complete-jobseeker-profile&step=5" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Previous Step
                    </a>
                    <button type="submit" name="submit_step6"
                        class="inline-flex items-center px-6 py-2 text-sm font-medium text-white border border-transparent rounded-md shadow-sm bg-primary hover:bg-blue-700">
                        <?php echo (!empty($skills) ? 'Update & Continue' : 'Next Step'); ?>
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
        let skillCount = 1;
        const addSkillBtn = document.getElementById('add-skill');
        const skillsContainer = document.getElementById('skills-container');

        addSkillBtn.addEventListener('click', function() {
            if (skillCount < 10) { // Limit to 10 skills
                const skillRow = document.createElement('div');
                skillRow.className = 'skill-row grid grid-cols-1 gap-6 sm:grid-cols-2 mb-6';
                skillRow.innerHTML = `
                <div>
                    <label for="skills_${skillCount}" class="block mb-1 text-xs font-medium text-gray-500">
                        Skill Name
                    </label>
                    <div class="mt-1">
                        <input id="skills_${skillCount}" name="skills[]" type="text"
                               placeholder="e.g., JavaScript, Communication, Project Management"
                               class="block w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-400 transition-all bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary hover:border-gray-400">
                    </div>
                </div>

                <div>
                    <label for="proficiency_${skillCount}" class="block mb-1 text-xs font-medium text-gray-500">
                        Proficiency Level
                    </label>
                    <div class="flex mt-1">
                        <select id="proficiency_${skillCount}" name="proficiency[]" 
                                class="block w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-400 transition-all bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary hover:border-gray-400">
                            <option value="Beginner">Beginner</option>
                            <option value="Intermediate">Intermediate</option>
                            <option value="Advanced">Advanced</option>
                            <option value="Expert">Expert</option>
                        </select>
                        <button type="button" onclick="this.closest('.skill-row').remove()" 
                                class="flex items-center justify-center px-3 py-2 ml-2 text-red-600 transition-colors bg-white border border-red-300 rounded-md shadow-sm hover:bg-red-50">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            `;
                skillsContainer.appendChild(skillRow);
                skillCount++;
            }
        });
    });
</script>