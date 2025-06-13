<?php include_once __DIR__ . '/../../components/navbar-top.php';
include_once __DIR__ . '/../navbar-jobseeker.php';?>

<div class="min-h-screen py-12 bg-gray-50 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-4xl">
        <div class="text-center">
            <div class="flex justify-center mb-4">
                <div class="p-3 bg-green-600 rounded-full">
                    <i class="text-2xl text-white fas fa-check-circle"></i>
                </div>
            </div>
            <h2 class="mt-6 text-3xl font-extrabold text-center text-gray-900">
                Review & Complete Profile
            </h2>
            <p class="mt-2 text-sm text-center text-gray-600">
                Step 8/8
            </p>
            <p class="mt-2 text-sm text-center text-gray-500">
                Carefully review all the information you've entered to ensure accuracy before completing your profile setup.
            </p>
        </div>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-4xl">
        <div class="px-4 py-8 bg-white shadow sm:rounded-lg sm:px-10">
            <!-- Progress bar -->
            <div class="w-full h-1 mb-6 bg-gray-200 rounded">
                <div class="h-1 bg-blue-600 rounded" style="width: 100%"></div>
            </div>

            <div class="space-y-8">
                <!-- Personal Information Summary -->
                <div class="p-6 border border-gray-200 rounded-lg">
                    <h3 class="mb-4 text-lg font-medium text-gray-900">Personal Information</h3>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <span class="text-sm text-gray-500">Name:</span>
                            <p class="text-sm font-medium"><?php echo htmlspecialchars(($jobseeker['first_name'] ?? 'N/A') . ' ' . ($jobseeker['middle_name'] ?? '') . ' ' . ($jobseeker['last_name'] ?? 'N/A')); ?></p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500">Email:</span>
                            <p class="text-sm font-medium"><?php echo htmlspecialchars($_SESSION['email'] ?? 'N/A'); ?></p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500">Contact:</span>
                            <p class="text-sm font-medium"><?php echo htmlspecialchars($jobseeker['contact_no'] ?? 'N/A'); ?></p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500">Date of Birth:</span>
                            <p class="text-sm font-medium"><?php echo htmlspecialchars($jobseeker['date_of_birth'] ?? 'N/A'); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Employment Status Summary -->
                <div class="p-6 border border-gray-200 rounded-lg">
                    <h3 class="mb-4 text-lg font-medium text-gray-900">Employment Status</h3>
                    <p class="text-sm text-gray-600">This information has been saved and can be updated later from your profile settings.</p>
                </div>

                <!-- Education Summary -->
                <div class="p-6 border border-gray-200 rounded-lg">
                    <h3 class="mb-4 text-lg font-medium text-gray-900">Educational Background</h3>
                    <p class="text-sm text-gray-600">Your educational information has been recorded and can be modified from your profile.</p>
                </div>

                <!-- Work Experience Summary -->
                <div class="p-6 border border-gray-200 rounded-lg">
                    <h3 class="mb-4 text-lg font-medium text-gray-900">Work Experience</h3>
                    <p class="text-sm text-gray-600">Your work experience has been saved and can be updated anytime.</p>
                </div>

                <!-- Skills Summary -->
                <div class="p-6 border border-gray-200 rounded-lg">
                    <h3 class="mb-4 text-lg font-medium text-gray-900">Skills & Expertise</h3>
                    <p class="text-sm text-gray-600">Your skills have been recorded and can be managed from your profile dashboard.</p>
                </div>

                <!-- Certificates Summary -->
                <div class="p-6 border border-gray-200 rounded-lg">
                    <h3 class="mb-4 text-lg font-medium text-gray-900">Certificates & Licenses</h3>
                    <p class="text-sm text-gray-600">Your certifications have been saved and can be updated as needed.</p>
                </div>
            </div>

            <form method="POST" action="?page=complete-jobseeker-profile&step=8" class="mt-8">
                <div class="flex justify-center">
                    <button type="submit" class="inline-flex items-center px-8 py-3 text-base font-medium text-white bg-green-600 border border-transparent rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        <i class="mr-2 fas fa-check"></i>
                        Complete Profile Setup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>