<?php include_once __DIR__ . '/../components/navbar-top.php'; 
      include_once __DIR__ . '/navbar-jobseeker.php';
?>

<div class="min-h-screen py-12 bg-gray-50 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-2xl">
        <div class="text-center">
            <div class="flex justify-center mb-4">
                <div class="p-3 bg-green-600 rounded-full">
                    <i class="text-2xl text-white fas fa-cogs"></i>
                </div>
            </div>
            <h2 class="mt-6 text-3xl font-extrabold text-center text-gray-900">
                Skills & Expertise
            </h2>
            <p class="mt-2 text-sm text-center text-gray-600">
                Step 6/8
            </p>
            <p class="mt-2 text-sm text-center text-gray-500">
                Highlight your core skills and proficiency.
            </p>
        </div>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-2xl">
        <div class="px-4 py-8 bg-white shadow sm:rounded-lg sm:px-10">
            <!-- Progress bar -->
            <div class="w-full h-1 mb-6 bg-gray-200 rounded">
                <div class="h-1 bg-blue-600 rounded" style="width: 75%"></div>
            </div>

            <form class="space-y-6" method="POST" action="?page=complete-jobseeker-profile&step=6">
                <div id="skills-container">
                    <div class="grid grid-cols-1 gap-4 mb-4 skill-row sm:grid-cols-2">
                        <div>
                            <label for="skills_0" class="block text-sm font-medium text-gray-700">
                                Skill Name
                            </label>
                            <div class="mt-1">
                                <input id="skills_0" name="skills[]" type="text"
                                       placeholder="e.g., JavaScript, Communication, Project Management"
                                       class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-green-500 focus:border-green-500">
                            </div>
                        </div>

                        <div>
                            <label for="proficiency_0" class="block text-sm font-medium text-gray-700">
                                Proficiency Level
                            </label>
                            <div class="mt-1">
                                <select id="proficiency_0" name="proficiency[]" class="block w-full px-3 py-2 border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-green-500 focus:border-green-500">
                                    <option value="Beginner">Beginner</option>
                                    <option value="Intermediate">Intermediate</option>
                                    <option value="Advanced">Advanced</option>
                                    <option value="Expert">Expert</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-center">
                    <button type="button" id="add-skill" class="inline-flex items-center px-3 py-2 text-sm font-medium text-green-600 bg-white border border-green-300 rounded-md hover:bg-green-50">
                        <i class="mr-2 fas fa-plus"></i>
                        Add Another Skill
                    </button>
                </div>

                <div class="flex justify-between">
                    <a href="?page=complete-jobseeker-profile&step=7" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                        Skip For Now
                    </a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md hover:bg-green-700">
                        Next Step
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
            skillRow.className = 'skill-row grid grid-cols-1 gap-4 sm:grid-cols-2 mb-4';
            skillRow.innerHTML = `
                <div>
                    <label for="skills_${skillCount}" class="block text-sm font-medium text-gray-700">
                        Skill Name
                    </label>
                    <div class="mt-1">
                        <input id="skills_${skillCount}" name="skills[]" type="text"
                               placeholder="e.g., JavaScript, Communication, Project Management"
                               class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-green-500 focus:border-green-500">
                    </div>
                </div>

                <div>
                    <label for="proficiency_${skillCount}" class="block text-sm font-medium text-gray-700">
                        Proficiency Level
                    </label>
                    <div class="flex mt-1">
                        <select id="proficiency_${skillCount}" name="proficiency[]" class="block w-full px-3 py-2 border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-green-500 focus:border-green-500">
                            <option value="Beginner">Beginner</option>
                            <option value="Intermediate">Intermediate</option>
                            <option value="Advanced">Advanced</option>
                            <option value="Expert">Expert</option>
                        </select>
                        <button type="button" onclick="this.closest('.skill-row').remove()" class="px-3 py-2 ml-2 text-red-600 border border-red-300 rounded-md hover:bg-red-50">
                            <i class="fas fa-trash"></i>
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