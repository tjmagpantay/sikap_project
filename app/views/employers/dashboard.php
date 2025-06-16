<?php
// filepath: c:\xampp\htdocs\sikap\app\views\employers\profile-employer.php
include_once __DIR__ . '/../components/navbar-top.php';
include_once __DIR__ . '/navbar-employer.php'; ?>

<div class="min-h-screen bg-gray-50">
    <nav class="bg-blue-800 shadow">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <h1 class="text-xl font-semibold text-white">Employer Dashboard</h1>
                </div>
                <div class="flex items-center">
                    <span class="mr-4 text-gray-300">Welcome, <?php echo htmlspecialchars($employer['first_name'] ?? $_SESSION['email']); ?></span>
                    <a href="?page=logout" class="text-red-400 hover:underline">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <!-- Quick Profile Status Alert -->
            <?php if (!$hasProfile): ?>
                <div class="p-4 mb-6 border border-blue-200 rounded-md bg-blue-50">
                    <div class="flex items-center justify-between">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="text-blue-400 fas fa-user-edit"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-blue-800">Complete Your Profile</h3>
                                <p class="mt-1 text-sm text-blue-700">Set up your employer profile to access all features.</p>
                            </div>
                        </div>
                        <a href="?page=complete-employer-profile" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                            Complete Now
                        </a>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Dashboard Cards -->
            <div class="grid grid-cols-1 gap-6 md:grid-cols-4">
                <!-- Profile Card -->
                <div class="overflow-hidden transition-shadow bg-white rounded-lg shadow hover:shadow-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-user-edit text-2xl <?php echo $hasProfile ? 'text-green-500' : 'text-blue-500'; ?>"></i>
                            </div>
                            <div class="flex-1 w-0 ml-5">
                                <h3 class="text-lg font-medium text-gray-900">
                                    <?php echo $hasProfile ? 'Edit Profile' : 'Complete Profile'; ?>
                                </h3>
                                <p class="mt-1 text-sm text-gray-500">
                                    <?php echo $hasProfile ? 'Update your information' : 'Set up your profile'; ?>
                                </p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="?page=complete-employer-profile" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white <?php echo $hasProfile ? 'bg-green-600 hover:bg-green-700' : 'bg-blue-600 hover:bg-blue-700'; ?>">
                                <?php echo $hasProfile ? 'Edit Profile' : 'Complete Profile'; ?>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Post Job Card -->
                <div class="overflow-hidden transition-shadow bg-white rounded-lg shadow hover:shadow-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="text-2xl <?php echo $canPostJobs ? 'text-blue-500' : 'text-gray-400'; ?> fas fa-plus-circle"></i>
                            </div>
                            <div class="flex-1 w-0 ml-5">
                                <h3 class="text-lg font-medium text-gray-900">Post a Job</h3>
                                <p class="mt-1 text-sm text-gray-500">
                                    <?php echo $canPostJobs ? 'Create new job listings' : 'Complete verification to post jobs'; ?>
                                </p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <?php if ($canPostJobs): ?>
                                <a href="?page=post-job" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                                    Post Job
                                </a>
                            <?php else: ?>
                                <button disabled class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-gray-300 border border-transparent rounded-md cursor-not-allowed">
                                    Complete Verification First
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Manage Jobs Card -->
                <div class="overflow-hidden transition-shadow bg-white rounded-lg shadow hover:shadow-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="text-2xl text-green-500 fas fa-list"></i>
                            </div>
                            <div class="flex-1 w-0 ml-5">
                                <h3 class="text-lg font-medium text-gray-900">Manage Jobs</h3>
                                <p class="mt-1 text-sm text-gray-500">View and edit your job postings</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="?page=manage-jobs" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md hover:bg-green-700">
                                Manage Jobs
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Applications Card -->
                <div class="overflow-hidden transition-shadow bg-white rounded-lg shadow hover:shadow-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="text-2xl text-purple-500 fas fa-users"></i>
                            </div>
                            <div class="flex-1 w-0 ml-5">
                                <h3 class="text-lg font-medium text-gray-900">Applications</h3>
                                <p class="mt-1 text-sm text-gray-500">Review applications</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="?page=view-applications" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-purple-600 border border-transparent rounded-md hover:bg-purple-700">
                                View Applications
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>