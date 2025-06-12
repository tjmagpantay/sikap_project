<?php
// filepath: c:\xampp\htdocs\sikap\app\views\employers\complete-profile.php
include_once __DIR__ . '/../components/navbar-top.php';
include_once __DIR__ . '/navbar-employer.php';

// Split the full name from signup if it exists
$fullName = $user['name'] ?? '';
$nameParts = explode(' ', trim($fullName));
$autoFirstName = $nameParts[0] ?? '';
$autoLastName = count($nameParts) > 1 ? end($nameParts) : '';
$autoMiddleName = count($nameParts) > 2 ? implode(' ', array_slice($nameParts, 1, -1)) : '';
?>

<div class="min-h-screen py-12 bg-gray-50 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-2xl">
        <div class="text-center">
            <div class="flex justify-center mb-4">
                <div class="p-3 bg-blue-600 rounded-full">
                    <i class="text-2xl text-white fas fa-user-tie"></i>
                </div>
            </div>
            <h2 class="mt-6 text-3xl font-extrabold text-center text-gray-900">
                Complete Your Profile
            </h2>
            <p class="mt-2 text-sm text-center text-gray-600">
                Step 1/1 - Profile Information
            </p>
            <p class="mt-2 text-sm text-center text-gray-500">
                Set up your employer profile to start posting jobs
            </p>
        </div>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-2xl">
        <div class="px-4 py-8 bg-white shadow sm:rounded-lg sm:px-10">
            <!-- Progress bar -->
            <div class="w-full h-2 mb-6 bg-gray-200 rounded">
                <div class="h-2 bg-blue-600 rounded" style="width: 50%"></div>
            </div>

            <!-- Error Messages -->
            <?php if (!empty($error)): ?>
                <div class="p-4 mb-4 border border-red-200 rounded-md bg-red-50">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="text-red-400 fas fa-exclamation-circle"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-600"><?php echo htmlspecialchars($error); ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Success Messages -->
            <?php if (!empty($success)): ?>
                <div class="p-4 mb-4 border border-green-200 rounded-md bg-green-50">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="text-green-400 fas fa-check-circle"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-600"><?php echo htmlspecialchars($success); ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <form class="space-y-6" method="POST" action="?page=complete-employer-profile">
                <!-- Name Fields -->
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700">
                            First Name <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1">
                            <input id="first_name" name="first_name" type="text" required
                                   value="<?php echo htmlspecialchars($employer['first_name'] ?? $_POST['first_name'] ?? $autoFirstName); ?>"
                                   placeholder="First Name"
                                   class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>

                    <div>
                        <label for="middle_name" class="block text-sm font-medium text-gray-700">
                            Middle Name
                        </label>
                        <div class="mt-1">
                            <input id="middle_name" name="middle_name" type="text"
                                   value="<?php echo htmlspecialchars($employer['middle_name'] ?? $_POST['middle_name'] ?? $autoMiddleName); ?>"
                                   placeholder="Middle Name"
                                   class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>

                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700">
                            Last Name <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1">
                            <input id="last_name" name="last_name" type="text" required
                                   value="<?php echo htmlspecialchars($employer['last_name'] ?? $_POST['last_name'] ?? $autoLastName); ?>"
                                   placeholder="Last Name"
                                   class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                </div>

                <!-- Position -->
                <div>
                    <label for="position" class="block text-sm font-medium text-gray-700">
                        Position <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-1">
                        <input id="position" name="position" type="text" required
                               value="<?php echo htmlspecialchars($employer['position'] ?? $_POST['position'] ?? ''); ?>"
                               placeholder="e.g., HR Manager, CEO, Recruiter"
                               class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="contact_no" class="block text-sm font-medium text-gray-700">
                            Contact Number <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1">
                            <input id="contact_no" name="contact_no" type="tel" required
                                   value="<?php echo htmlspecialchars($employer['contact_no'] ?? $_POST['contact_no'] ?? ''); ?>"
                                   placeholder="e.g., +63 912 345 6789"
                                   class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>

                    <div>
                        <label for="company_name" class="block text-sm font-medium text-gray-700">
                            Company Name
                        </label>
                        <div class="mt-1">
                            <input id="company_name" name="company_name" type="text"
                                   value="<?php echo htmlspecialchars($employer['company_name'] ?? $_POST['company_name'] ?? ''); ?>"
                                   placeholder="Company Name"
                                   class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                </div>

                <!-- About Us -->
                <div>
                    <label for="about_us" class="block text-sm font-medium text-gray-700">
                        About Us
                    </label>
                    <div class="mt-1">
                        <textarea id="about_us" name="about_us" rows="4"
                                  placeholder="Describe your company and what you do..."
                                  class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-blue-500 focus:border-blue-500"><?php echo htmlspecialchars($employer['about_us'] ?? $_POST['about_us'] ?? ''); ?></textarea>
                    </div>
                </div>

                <!-- Information Notice -->
                <div class="p-4 border border-blue-200 rounded-md bg-blue-50">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="text-blue-400 fas fa-info-circle"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-blue-700">
                                <strong>Next Step:</strong> After completing your profile, you'll set up your business information including company details, social media links, and required documents.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="flex justify-between">
                    <a href="?page=employer-dashboard" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                        <i class="mr-2 fas fa-arrow-left"></i>
                        Back to Dashboard
                    </a>
                    <button type="submit" class="inline-flex items-center px-6 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                        Continue to Business Setup
                        <i class="ml-2 fas fa-arrow-right"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>