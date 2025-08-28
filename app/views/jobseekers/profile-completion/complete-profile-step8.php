<?php
include_once __DIR__ . '/../components/jobseeker_auth_check.php';
include_once __DIR__ . '/../../components/navbar-top.php';
include_once __DIR__ . '/../navbar-jobseeker.php'; ?>

<div class="min-h-screen py-6">
    <div class="sm:mx-auto sm:w-full sm:max-w-2xl">
        <div class="text-center">
            <div class="flex justify-center mb-4">
                <div class="flex items-center justify-center w-12 h-12 rounded-full bg-primary">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <h2 class="mt-6 text-3xl font-extrabold text-center text-gray-900">
                Review & Complete Profile
            </h2>
            <p class="mt-2 text-sm text-center text-gray-500">
                Review all information before completing your profile setup
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
                        <a href="?page=complete-jobseeker-profile&step=6" class="flex items-center justify-center w-8 h-8 text-gray-500 transition-colors bg-gray-200 rounded-full hover:bg-gray-300 hover:text-gray-700">
                            <span class="text-sm font-semibold">6</span>
                        </a>
                        <span class="mt-1 text-xs text-gray-500">Skills</span>
                    </div>

                    <!-- Step 7 -->
                    <div class="flex flex-col items-center">
                        <a href="?page=complete-jobseeker-profile&step=7" class="flex items-center justify-center w-8 h-8 text-gray-500 transition-colors bg-gray-200 rounded-full hover:bg-gray-300 hover:text-gray-700">
                            <span class="text-sm font-semibold">7</span>
                        </a>
                        <span class="mt-1 text-xs text-gray-500">Certificates</span>
                    </div>

                    <!-- Step 8 -->
                    <div class="flex flex-col items-center">
                        <div class="flex items-center justify-center w-8 h-8 text-white rounded-full bg-primary">
                            <span class="text-sm font-semibold">8</span>
                        </div>
                        <span class="mt-1 text-xs text-gray-600">Review</span>
                    </div>
                </div>

                <!-- Progress bar -->
                <div class="w-full h-2 bg-gray-200 rounded">
                    <div class="h-2 rounded bg-primary" style="width: 100%"></div>
                </div>
            </div>

            <div class="space-y-6">
                <!-- Personal Information Summary -->
                <div class="p-4 border border-gray-200 rounded-lg">
                    <div class="flex items-center justify-between">
                        <h3 class="text-base font-medium text-gray-900">Personal Information</h3>
                        <a href="?page=complete-jobseeker-profile&step=2" class="text-sm font-medium text-primary hover:text-blue-700">
                            Edit
                        </a>
                    </div>
                    <div class="grid grid-cols-1 gap-3 mt-3 sm:grid-cols-2">
                        <div>
                            <span class="text-xs text-gray-500">Name:</span>
                            <p class="text-sm font-medium"><?php echo htmlspecialchars(($jobseeker['first_name'] ?? 'N/A') . ' ' . ($jobseeker['middle_name'] ?? '') . ' ' . ($jobseeker['last_name'] ?? 'N/A')); ?></p>
                        </div>
                        <div>
                            <span class="text-xs text-gray-500">Email:</span>
                            <p class="text-sm font-medium"><?php echo htmlspecialchars($_SESSION['email'] ?? 'N/A'); ?></p>
                        </div>
                        <div>
                            <span class="text-xs text-gray-500">Contact:</span>
                            <p class="text-sm font-medium"><?php echo htmlspecialchars($jobseeker['contact_no'] ?? 'N/A'); ?></p>
                        </div>
                        <div>
                            <span class="text-xs text-gray-500">Date of Birth:</span>
                            <p class="text-sm font-medium"><?php echo htmlspecialchars($jobseeker['date_of_birth'] ?? 'N/A'); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Employment Status Summary -->
                <div class="p-4 border border-gray-200 rounded-lg">
                    <div class="flex items-center justify-between">
                        <h3 class="text-base font-medium text-gray-900">Employment Status</h3>
                        <a href="?page=complete-jobseeker-profile&step=3" class="text-sm font-medium text-primary hover:text-blue-700">
                            Edit
                        </a>
                    </div>
                    <p class="mt-2 text-sm text-gray-600">Your employment information has been recorded and can be modified from your profile.</p>
                </div>

                <!-- Education Summary -->
                <div class="p-4 border border-gray-200 rounded-lg">
                    <div class="flex items-center justify-between">
                        <h3 class="text-base font-medium text-gray-900">Educational Background</h3>
                        <a href="?page=complete-jobseeker-profile&step=4" class="text-sm font-medium text-primary hover:text-blue-700">
                            Edit
                        </a>
                    </div>
                    <p class="mt-2 text-sm text-gray-600">Your educational details have been saved and can be updated later.</p>
                </div>

                <!-- Work Experience Summary -->
                <div class="p-4 border border-gray-200 rounded-lg">
                    <div class="flex items-center justify-between">
                        <h3 class="text-base font-medium text-gray-900">Work Experience</h3>
                        <a href="?page=complete-jobseeker-profile&step=5" class="text-sm font-medium text-primary hover:text-blue-700">
                            Edit
                        </a>
                    </div>
                    <p class="mt-2 text-sm text-gray-600">Your professional experience has been recorded and can be managed from your profile.</p>
                </div>

                <!-- Skills Summary -->
                <div class="p-4 border border-gray-200 rounded-lg">
                    <div class="flex items-center justify-between">
                        <h3 class="text-base font-medium text-gray-900">Skills & Expertise</h3>
                        <a href="?page=complete-jobseeker-profile&step=6" class="text-sm font-medium text-primary hover:text-blue-700">
                            Edit
                        </a>
                    </div>
                    <p class="mt-2 text-sm text-gray-600">Your skills have been saved and can be updated anytime.</p>
                </div>

                <!-- Certificates Summary -->
                <div class="p-4 border border-gray-200 rounded-lg">
                    <div class="flex items-center justify-between">
                        <h3 class="text-base font-medium text-gray-900">Certificates & Licenses</h3>
                        <a href="?page=complete-jobseeker-profile&step=7" class="text-sm font-medium text-primary hover:text-blue-700">
                            Edit
                        </a>
                    </div>
                    <p class="mt-2 text-sm text-gray-600">Your certifications have been recorded and can be modified as needed.</p>
                </div>
            </div>

            <form method="POST" action="?page=complete-jobseeker-profile&step=8" class="mt-6">
                <div class="flex justify-center">
                    <button type="submit"
                        class="inline-flex items-center px-8 py-3 text-base font-medium text-white transition-colors border border-transparent rounded-md shadow-sm bg-primary hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Complete Profile Setup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>