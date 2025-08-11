<?php
include_once __DIR__ . '/../components/navbar-top.php';
include_once __DIR__ . '../components/navbar-employer.php';
?>

<div class="min-h-screen ">
    <div class="px-4 py-8 sm:px-6 md:px-16 lg:px-24">
        <div class="mb-8 text-center">
            <h2 class="mt-6 text-3xl font-extrabold text-center text-gray-900">
                Complete Your Profile
            </h2>
            <p class="mt-2 text-sm text-center text-gray-600">
                Choose what you'd like to set up next
            </p>
        </div>

        <!-- Success Message -->
        <?php if (!empty($_GET['success'])): ?>
            <div class="max-w-2xl mx-auto mb-6">
                <div class="p-4 border border-green-200 rounded-md bg-green-50">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="text-green-400 fas fa-check-circle"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-600"><?php echo htmlspecialchars($_GET['success']); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Profile Setup Options -->
        <div class="grid max-w-4xl grid-cols-1 gap-6 mx-auto md:grid-cols-2">

            <!-- Personal Profile Setup -->
            <div class="overflow-hidden bg-white rounded-lg shadow">
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <div class="flex-shrink-0">
                            <?php if ($personalCompleted): ?>
                                <div class="flex items-center justify-center w-8 h-8 rounded-sm bg-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                            <?php else: ?>
                                <div class="flex items-center justify-center w-8 h-8 rounded-sm bg-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="ml-3">
                            <h3 class="font-medium text-gray-900 text-md">Personal Profile</h3>
                            <p class="text-xs text-gray-400">
                                <?php echo $personalCompleted ? 'Completed' : 'Set up your personal information'; ?>
                            </p>
                        </div>
                    </div>

                    <div class="mb-4">
                        <p class="mb-3 text-sm text-gray-600">Includes:</p>
                        <ul class="space-y-1 text-sm text-gray-500">
                            <li class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2 text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                </svg>
                                Personal information
                            </li>
                            <li class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2 text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                </svg>
                                Contact details
                            </li>
                            <li class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2 text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                </svg>
                                Position & company info
                            </li>
                        </ul>
                    </div>

                    <div class="mt-6">
                        <?php if ($personalCompleted): ?>
                            <a href="?page=employer-personal-profile"
                                class="inline-flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-gray-700 transition-colors border border-gray-300 bg-blue-50 hover:bg-gray-50">
                               
                                Edit Profile
                            </a>
                        <?php else: ?>
                            <a href="?page=employer-personal-profile"
                                class="inline-flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-gray-500 transition-colors border border-transparent bg-blue-50 hover:bg-blue-700">
                                <i class="mr-2 fas fa-plus"></i>
                                Set Up Profile
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Business Setup -->
            <div class="overflow-hidden bg-white rounded-lg shadow">
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <div class="flex-shrink-0">
                            <?php if ($businessCompleted): ?>
                                <div class="flex items-center justify-center w-8 h-8 rounded-sm bg-secondary">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                            <?php else: ?>
                                <div class="flex items-center justify-center w-8 h-8 rounded-sm bg-secondary">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                            <?php endif; ?>

                        </div>
                        <div class="ml-4">
                            <h3 class="font-medium text-gray-900 text-md">Business Setup</h5>
                                <p class="text-xs text-gray-400">
                                    <?php echo $businessCompleted ? 'Completed' : 'Set up your business information'; ?>
                                </p>
                        </div>
                    </div>

                    <div class="mb-4">
                        <p class="mb-3 text-sm text-gray-600">Includes:</p>
                        <ul class="space-y-1 text-sm text-gray-500">
                            <li class="flex items-center">
                                <?php if ($businessCompleted): ?>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2 text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                    </svg>
                                <?php else: ?>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 12m-10 0a10 10 0 1 0 20 0a10 10 0 1 0 -20 0" />
                                    </svg>
                                <?php endif; ?>
                                Company details
                            </li>
                            <li class="flex items-center">
                                <?php if ($businessCompleted): ?>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2 text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                    </svg>
                                <?php else: ?>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 12m-10 0a10 10 0 1 0 20 0a10 10 0 1 0 -20 0" />
                                    </svg>
                                <?php endif; ?>
                                Social media links
                            </li>
                            <li class="flex items-center">
                                <?php if ($businessCompleted): ?>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2 text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                    </svg>
                                <?php else: ?>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 12m-10 0a10 10 0 1 0 20 0a10 10 0 1 0 -20 0" />
                                    </svg>
                                <?php endif; ?>
                                Business documents
                            </li>
                        </ul>
                    </div>

                    <div class="mt-6">
                        <?php if ($businessCompleted): ?>
                            <a href="?page=complete-employer-business&step=1"
                                class="inline-flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-gray-700 transition-colors border border-gray-300 bg-blue-50 hover:bg-gray-50">
                                Edit Business Profile
                            </a>
                        <?php else: ?>
                            <a href="?page=complete-employer-business&step=1"
                                class="inline-flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-white transition-colors bg-orange-600 border border-transparent rounded-md hover:bg-orange-700">
                                <i class="mr-2 fas fa-plus"></i>
                                Set Up Business
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-center mt-8 space-x-4">
            <a href="?page=employer-dashboard"
                class="inline-flex items-center px-6 py-3 text-sm font-medium text-gray-700 transition-colors bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                <i class="mr-2 fas fa-arrow-left"></i>
                Back to Dashboard
            </a>
        </div>
    </div>
</div>