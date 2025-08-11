<?php

// Split the full name from signup if it exists
$fullName = $user['name'] ?? '';
$nameParts = explode(' ', trim($fullName));
$autoFirstName = $nameParts[0] ?? '';
$autoLastName = count($nameParts) > 1 ? end($nameParts) : '';
$autoMiddleName = count($nameParts) > 2 ? implode(' ', array_slice($nameParts, 1, -1)) : '';
?>

<?php
include_once __DIR__ . '../../../components/navbar-top.php';
include_once __DIR__ . '/../components/navbar-employer.php';
?>

<div class="min-h-screen py-6 ">
    <div class="sm:mx-auto sm:w-full sm:max-w-2xl">
        <div class="text-center">
            <h2 class="mt-6 text-3xl font-extrabold text-center text-gray-900">
                Complete Your Profile
            </h2>
            <p class="mt-2 text-sm text-center text-gray-600">
                Step 1/2 - Employer Profile
            </p>
            <p class="mt-2 text-sm text-center text-gray-500">
                Set up your personal details first
            </p>
        </div>
    </div>

    <div class="mt-4 sm:mx-auto sm:w-full sm:max-w-2xl">
        <div class="px-4 py-8 bg-white shadow sm:rounded-lg sm:px-10">
            <!-- Progress bar -->
            <div class="w-full h-2 mb-6 bg-gray-200 rounded">
                <div class="h-2 rounded bg-primary" style="width: <?php echo $step == 1 ? '50%' : '100%'; ?>"></div>
            </div>

            <!-- Step Navigation -->
            <div class="mb-6">
                <nav class="flex space-x-4">
                    <a href="?page=complete-employer-profile&step=1"
                        class="flex-1 px-4 py-2 text-sm font-medium text-center rounded-md transition-colors <?php echo $step == 1 ? 'bg-blue-600 text-white' : 'bg-gray-100 text-primary'; ?>">
                        Personal Info
                    </a>
                    <a href="?page=complete-employer-profile&step=2"
                        class="flex-1 px-4 py-2 text-sm font-medium rounded-md text-center transition-colors <?php echo $step == 2 ? 'bg-blue-600 text-white' : 'bg-gray-100 text-secondary'; ?>">
                        Business Setup
                    </a>
                </nav>
            </div>

            <!-- Error Messages -->
            <?php if (!empty($error)): ?>
                <div class="p-4 mb-4 border border-red-200 rounded-md bg-red-50">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
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
                            <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-600"><?php echo htmlspecialchars($success); ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <form class="space-y-6" method="POST" action="?page=employer-personal-profile">
                <!-- Name Fields -->
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
                    <div>
                        <label for="first_name" class="block mb-1 text-xs font-medium text-gray-500">
                            First Name <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1">
                            <input
                                id="first_name"
                                name="first_name"
                                type="text"
                                required
                                value="<?php echo htmlspecialchars($employer['first_name'] ?? $_POST['first_name'] ?? $autoFirstName); ?>"
                                placeholder="First Name"
                                class="block w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-400 transition-all bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary hover:border-gray-400">
                        </div>
                    </div>

                    <div>
                        <label for="middle_name" class="block mb-1 text-xs font-medium text-gray-500">
                            Middle Name
                        </label>
                        <div class="mt-1">
                            <input
                                id="middle_name"
                                name="middle_name"
                                type="text"
                                value="<?php echo htmlspecialchars($employer['middle_name'] ?? $_POST['middle_name'] ?? $autoMiddleName); ?>"
                                placeholder="Middle Name"
                                class="block w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-400 transition-all bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary hover:border-gray-400">
                        </div>
                    </div>

                    <div>
                        <label for="last_name" class="block mb-1 text-xs font-medium text-gray-500">
                            Last Name <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1">
                            <input
                                id="last_name"
                                name="last_name"
                                type="text"
                                required
                                value="<?php echo htmlspecialchars($employer['last_name'] ?? $_POST['last_name'] ?? $autoLastName); ?>"
                                placeholder="Last Name"
                                class="block w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-400 transition-all bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary hover:border-gray-400">
                        </div>
                    </div>
                </div>

                <!-- Position -->
                <div>
                    <label for="position" class="block mb-1 text-xs font-medium text-gray-500">
                        Position <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-1">
                        <input
                            id="position"
                            name="position"
                            type="text"
                            required
                            value="<?php echo htmlspecialchars($employer['position'] ?? $_POST['position'] ?? ''); ?>"
                            placeholder="e.g., HR Manager, CEO, Recruiter"
                            class="block w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-400 transition-all bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary hover:border-gray-400">
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="contact_no" class="block mb-1 text-xs font-medium text-gray-500">
                            Contact Number <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1">
                            <input
                                id="contact_no"
                                name="contact_no"
                                type="tel"
                                required
                                value="<?php echo htmlspecialchars($employer['contact_no'] ?? $_POST['contact_no'] ?? ''); ?>"
                                placeholder="e.g., +63 912 345 6789"
                                class="block w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-400 transition-all bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary hover:border-gray-400">
                        </div>
                    </div>

                    <div>
                        <label for="company_name" class="block mb-1 text-xs font-medium text-gray-500">
                            Company Name
                        </label>
                        <div class="mt-1">
                            <input
                                id="company_name"
                                name="company_name"
                                type="text"
                                value="<?php echo htmlspecialchars($employer['company_name'] ?? $_POST['company_name'] ?? ''); ?>"
                                placeholder="Company Name"
                                class="block w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-400 transition-all bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary hover:border-gray-400">
                        </div>
                    </div>
                </div>

                <!-- About Us -->
                <div>
                    <label for="about_us" class="block mb-1 text-xs font-medium text-gray-500">
                        About Us
                    </label>
                    <div class="mt-1">
                        <textarea
                            id="about_us"
                            name="about_us"
                            rows="4"
                            placeholder="Describe your company and what you do..."
                            class="block w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-400 transition-all bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary hover:border-gray-400"><?php echo htmlspecialchars($employer['about_us'] ?? $_POST['about_us'] ?? ''); ?></textarea>
                    </div>
                </div>

                <!-- Information Notice -->
                <div class="p-4 border border-blue-200 rounded-md bg-blue-50">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-primary">
                                <strong>Next Step:</strong> After saving your personal information, you'll set up your business details including company information, social media links, and required documents.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="flex justify-between">
                    <a href="?page=complete-employer-profile" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back to Setup
                    </a>
                    <?php
                    // Check if employer has existing data
                    $hasExistingData = !empty($employer['first_name']) || !empty($employer['last_name']) || !empty($employer['position']);
                    ?>
                    <?php if ($hasExistingData): ?>
                        <button type="submit" class="inline-flex items-center px-6 py-2 text-sm font-medium text-white border border-transparent rounded-md shadow-sm bg-primary hover:bg-blue-700">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Update Profile
                        </button>
                    <?php else: ?>
                        <button type="submit" class="inline-flex items-center px-6 py-2 text-sm font-medium text-white border border-transparent rounded-md shadow-sm bg-primary hover:bg-blue-700">
                            Save & Continue
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>
</div>