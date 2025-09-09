<?php
include_once __DIR__ . '/../components/jobseeker_auth_check.php';
include_once __DIR__ . '/../../components/navbar-top.php';
include_once __DIR__ . '/../navbar-jobseeker.php';

// Debug - let's see what data we have
error_log("Parsed education data: " . json_encode($_SESSION['parsed_resume_data']['education'] ?? []));
error_log("Existing education data: " . json_encode($education ?? []));
?>

<div class="min-h-screen py-6">
    <div class="sm:mx-auto sm:w-full sm:max-w-2xl">
        <div class="text-center">
            <div class="flex justify-center mb-4">
                <div class="flex items-center justify-center w-12 h-12 rounded-full bg-primary">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M12 14l9-5-9-5-9 5 9 5z" />
                        <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                    </svg>
                </div>
            </div>
            <h2 class="mt-6 text-3xl font-extrabold text-center text-gray-900">
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

            <!-- Display parsed education if available -->
            <?php if (isset($_SESSION['parsed_resume_data']['education']) && !empty($_SESSION['parsed_resume_data']['education']['school_name'])): ?>
                <?php $parsedEdu = $_SESSION['parsed_resume_data']['education']; ?>
                <div class="p-4 mb-6 border border-green-200 rounded-lg bg-green-50">
                    <h3 class="mb-2 text-sm font-medium text-green-800">
                        <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Education extracted from your resume:
                    </h3>
                    <div class="space-y-2 text-sm text-green-800">
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
                    <p class="mt-2 text-xs text-green-600">This education data has been automatically filled below. You can edit if needed.</p>
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
                $currentEducationLevel = $_SESSION['parsed_resume_data']['education']['education_level'];
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
            ?>

            <!-- Update the form inputs to use parsed data -->
            <form class="space-y-6" method="POST" action="?page=complete-jobseeker-profile&step=3">
                <!-- Institution Name -->
                <div>
                    <label for="school_name" class="block mb-1 text-xs font-medium text-gray-500">
                        Institution Name
                    </label>
                    <div class="mt-1">
                        <input id="school_name" name="school_name" type="text"
                            value="<?php echo htmlspecialchars($currentSchoolName); ?>"
                            placeholder="Institution Name"
                            class="block w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-400 transition-all bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary hover:border-gray-400">
                    </div>
                </div>

                <!-- Degree/Program -->
                <div>
                    <label for="education_level" class="block mb-1 text-xs font-medium text-gray-500">
                        Degree / Program
                    </label>
                    <div class="mt-1">
                        <select id="education_level" name="education_level"
                            class="block w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-400 transition-all bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary hover:border-gray-400">
                            <option value="">Select Degree/Program</option>
                            <?php
                            $educationLevels = ['High School', 'Associate', 'Bachelor', 'Master', 'Doctorate', 'Vocational', 'Other'];
                            foreach ($educationLevels as $level):
                            ?>
                                <option value="<?php echo $level; ?>" <?php echo $currentEducationLevel === $level ? 'selected' : ''; ?>>
                                    <?php echo $level === 'Associate' ? 'Associate Degree' : ($level === 'Bachelor' ? "Bachelor's Degree" : ($level === 'Master' ? "Master's Degree" : $level)); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
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
                            class="block w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-400 transition-all bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary hover:border-gray-400">
                    </div>
                </div>

                <!-- Year Range -->
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="start_year" class="block mb-1 text-xs font-medium text-gray-500">
                            Start Year
                        </label>
                        <div class="mt-1">
                            <select id="start_year" name="start_year"
                                class="block w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-400 transition-all bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary hover:border-gray-400">
                                <option value="">Start Year</option>
                                <?php
                                for ($year = date('Y'); $year >= 1950; $year--):
                                ?>
                                    <option value="<?php echo $year; ?>" <?php echo $currentStartYear == $year ? 'selected' : ''; ?>>
                                        <?php echo $year; ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label for="end_year" class="block mb-1 text-xs font-medium text-gray-500">
                            End Year
                        </label>
                        <div class="mt-1">
                            <select id="end_year" name="end_year"
                                class="block w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-400 transition-all bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary hover:border-gray-400">
                                <option value="">End Year</option>
                                <?php
                                for ($year = date('Y') + 10; $year >= 1950; $year--):
                                ?>
                                    <option value="<?php echo $year; ?>" <?php echo $currentEndYear == $year ? 'selected' : ''; ?>>
                                        <?php echo $year; ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Rest of the form remains the same -->
                <div class="flex justify-between">
                    <a href="?page=complete-jobseeker-profile&step=2" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Previous Step
                    </a>
                    <button type="submit" name="submit_step3"
                        class="inline-flex items-center px-6 py-2 text-sm font-medium text-white border border-transparent rounded-md shadow-sm bg-primary hover:bg-blue-700">
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