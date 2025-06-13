<?php include_once __DIR__ . '/../../components/navbar-top.php';
include_once __DIR__ . '/../navbar-jobseeker.php';?>

<div class="min-h-screen py-12 bg-gray-50 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-2xl">
        <div class="text-center">
            <div class="flex justify-center mb-4">
                <div class="p-3 bg-green-600 rounded-full">
                    <i class="text-2xl text-white fas fa-graduation-cap"></i>
                </div>
            </div>
            <h2 class="mt-6 text-3xl font-extrabold text-center text-gray-900">
                Educational Background <span class="text-sm font-normal text-gray-500">(OPTIONAL)</span>
            </h2>
            <p class="mt-2 text-sm text-center text-gray-600">
                Step 4/8
            </p>
            <p class="mt-2 text-sm text-center text-gray-500">
                Provide details about your educational background, including institutions attended, degrees earned, and graduation dates
            </p>
        </div>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-2xl">
        <div class="px-4 py-8 bg-white shadow sm:rounded-lg sm:px-10">
            <!-- Progress bar -->
            <div class="w-full h-1 mb-6 bg-gray-200 rounded">
                <div class="h-1 bg-blue-600 rounded" style="width: 50%"></div>
            </div>

            <form class="space-y-6" method="POST" action="?page=complete-jobseeker-profile&step=4">
                <div>
                    <label for="school_name" class="block text-sm font-medium text-gray-700">
                        Institution Name
                    </label>
                    <div class="mt-1">
                        <input id="school_name" name="school_name" type="text"
                               placeholder="Institution Name"
                               class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-green-500 focus:border-green-500">
                    </div>
                </div>

                <div>
                    <label for="education_level" class="block text-sm font-medium text-gray-700">
                        Degree / Program
                    </label>
                    <div class="mt-1">
                        <select id="education_level" name="education_level" class="block w-full px-3 py-2 border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-green-500 focus:border-green-500">
                            <option value="">Select Degree/Program</option>
                            <option value="High School">High School</option>
                            <option value="Associate">Associate Degree</option>
                            <option value="Bachelor">Bachelor's Degree</option>
                            <option value="Master">Master's Degree</option>
                            <option value="Doctorate">Doctorate</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label for="field_of_study" class="block text-sm font-medium text-gray-700">
                        Field of Study
                    </label>
                    <div class="mt-1">
                        <select id="field_of_study" name="field_of_study" class="block w-full px-3 py-2 border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-green-500 focus:border-green-500">
                            <option value="">Select Field of Study</option>
                            <option value="Information Technology">Information Technology</option>
                            <option value="Computer Science">Computer Science</option>
                            <option value="Engineering">Engineering</option>
                            <option value="Business Administration">Business Administration</option>
                            <option value="Education">Education</option>
                            <option value="Health Sciences">Health Sciences</option>
                            <option value="Hospitality">Hospitality</option>
                            <option value="Social Sciences">Social Sciences</option>
                            <option value="Arts and Design">Arts and Design</option>
                            <option value="Law">Law</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="start_year" class="block text-sm font-medium text-gray-700">
                            Start Year
                        </label>
                        <div class="mt-1">
                            <select id="start_year" name="start_year" class="block w-full px-3 py-2 border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-green-500 focus:border-green-500">
                                <option value="">Start Year</option>
                                <?php for($year = date('Y'); $year >= 1950; $year--): ?>
                                    <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label for="end_year" class="block text-sm font-medium text-gray-700">
                            End Year
                        </label>
                        <div class="mt-1">
                            <select id="end_year" name="end_year" class="block w-full px-3 py-2 border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-green-500 focus:border-green-500">
                                <option value="">End Year</option>
                                <?php for($year = date('Y') + 10; $year >= 1950; $year--): ?>
                                    <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="flex justify-between">
                    <a href="?page=complete-jobseeker-profile&step=5" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
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