<div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <div class="text-center">
            <div class="flex justify-center mb-4">
                <div class="p-3 bg-blue-600 rounded-full">
                    <i class="fas fa-user-tie text-white text-2xl"></i>
                </div>
            </div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                <?php echo isset($employer) && $employer ? 'Edit Your Profile' : 'Complete Your Employer Profile'; ?>
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                <?php echo isset($employer) && $employer ? 'Update your employer information' : 'Please provide your details to complete registration'; ?>
            </p>
        </div>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
            <!-- Profile Status Banner -->
            <?php if (!isset($employer) || !$employer): ?>
                <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-md">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-info-circle text-blue-400"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">
                                Profile Required
                            </h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <p>Complete your profile to access all employer features including job posting and application management.</p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-md">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-400"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-green-800">
                                Profile Complete
                            </h3>
                            <div class="mt-2 text-sm text-green-700">
                                <p>Your employer profile is set up. You can update your information below.</p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Error Messages -->
            <?php if (!empty($error)): ?>
                <div class="mb-4 bg-red-50 border border-red-200 rounded-md p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-600"><?php echo htmlspecialchars($error); ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Success Messages -->
            <?php if (!empty($success)): ?>
                <div class="mb-4 bg-green-50 border border-green-200 rounded-md p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-600"><?php echo htmlspecialchars($success); ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <form class="space-y-6" method="POST" action="?page=complete-employer-profile">
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700">
                            First Name <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1">
                            <input id="first_name" name="first_name" type="text" required
                                   value="<?php echo htmlspecialchars($employer['first_name'] ?? $_POST['first_name'] ?? ''); ?>"
                                   class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>

                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700">
                            Last Name <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1">
                            <input id="last_name" name="last_name" type="text" required
                                   value="<?php echo htmlspecialchars($employer['last_name'] ?? $_POST['last_name'] ?? ''); ?>"
                                   class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                </div>

                <div>
                    <label for="middle_name" class="block text-sm font-medium text-gray-700">
                        Middle Name
                    </label>
                    <div class="mt-1">
                        <input id="middle_name" name="middle_name" type="text"
                               value="<?php echo htmlspecialchars($employer['middle_name'] ?? $_POST['middle_name'] ?? ''); ?>"
                               class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <div>
                    <label for="position" class="block text-sm font-medium text-gray-700">
                        Position/Title
                    </label>
                    <div class="mt-1">
                        <input id="position" name="position" type="text"
                               value="<?php echo htmlspecialchars($employer['position'] ?? $_POST['position'] ?? ''); ?>"
                               placeholder="e.g., HR Manager, Recruiter"
                               class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <div>
                    <label for="contact_no" class="block text-sm font-medium text-gray-700">
                        Contact Number <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-1">
                        <input id="contact_no" name="contact_no" type="tel" required
                               value="<?php echo htmlspecialchars($employer['contact_no'] ?? $_POST['contact_no'] ?? ''); ?>"
                               placeholder="e.g., +63 912 345 6789"
                               class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <div>
                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fas <?php echo isset($employer) && $employer ? 'fa-save' : 'fa-user-check'; ?> mr-2"></i>
                        <?php echo isset($employer) && $employer ? 'Update Profile' : 'Complete Profile'; ?>
                    </button>
                </div>
            </form>

            <div class="mt-6 space-y-3">
                <div class="text-center">
                    <a href="?page=employer-dashboard" class="inline-flex items-center text-sm text-blue-600 hover:text-blue-500">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back to Dashboard
                    </a>
                </div>
                <div class="text-center">
                    <a href="?page=logout" class="text-sm text-gray-500 hover:text-gray-700">
                        <i class="fas fa-sign-out-alt mr-1"></i>
                        Sign out
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>