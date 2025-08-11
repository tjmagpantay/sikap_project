<?php
include_once __DIR__ . '../../../components/navbar-top.php';
include_once __DIR__ . '/../components/navbar-employer.php';
?>

<div class="min-h-screen py-6">
    <div class="sm:mx-auto sm:w-full sm:max-w-2xl">
        <div class="text-center">
            <!-- <div class="flex justify-center mb-4">
                <div class="flex items-center justify-center w-12 h-12 rounded-full bg-primary">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
            </div> -->
            <h2 class="mt-6 text-3xl font-extrabold text-center text-gray-900">
                Business Information
            </h2>
            <p class="mt-2 text-sm text-center text-gray-600">
                Step 1/5 - Basic business information
            </p>
            <p class="mt-2 text-sm text-center text-gray-500">
                Upload your logo, banner and company details
            </p>
        </div>
    </div>

    <div class="mt-4 sm:mx-auto sm:w-full sm:max-w-2xl">
        <div class="px-4 py-8 bg-white shadow sm:rounded-lg sm:px-10">
            <!-- Progress bar -->
            <div class="w-full h-2 mb-6 bg-gray-200 rounded">
                <div class="h-2 rounded bg-primary" style="width: 20%"></div>
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

            <form class="space-y-6" method="POST" action="?page=complete-employer-business&step=1" enctype="multipart/form-data">

                <!-- Business Logo Upload - 2 Column Layout -->
                <div>
                    <label for="business_logo" class="block mb-1 text-xs font-medium text-gray-500">
                        Business Logo
                    </label>
                    <p class="mt-1 text-xs text-gray-500">
                        Square logo works best. Recommended size: 200x200 pixels. Max file size 2 MB.
                    </p>

                    <div class="grid grid-cols-2 gap-4 mt-2 mb-6 bg-gray-100 rounded-md">
                        <!-- Left Column - Current Logo Display -->
                        <div class="flex items-center justify-center">
                            <?php if (!empty($business['business_logo'])): ?>
                                <div class="text-center">
                                    <img src="<?php echo htmlspecialchars($business['business_logo']); ?>"
                                        alt="Current Logo"
                                        class="object-contain w-16 h-16 mx-auto border border-gray-300 rounded-md">
                                    <p class="mt-1 text-xs text-gray-500">Current logo</p>
                                </div>
                            <?php else: ?>
                                <div class="flex items-center justify-center w-16 h-16 border-2 border-gray-300 border-dashed rounded-md">
                                    <svg class="w-6 h-6 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M8 14s0-2 2-2h28s2 0 2 2v28s0 2-2 2H10s-2 0-2-2V14z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M15 30l10-10 10 10" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        <circle cx="30" cy="20" r="3" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Right Column - Upload/Edit Function -->
                        <div class="flex flex-col justify-center">
                            <div class="flex justify-center px-4 py-3 transition-colors border-2 border-gray-300 border-dashed rounded-md hover:border-gray-400">
                                <div class="text-center">
                                    <svg class="w-6 h-6 mx-auto mb-2 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M8 14s0-2 2-2h28s2 0 2 2v28s0 2-2 2H10s-2 0-2-2V14z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M15 30l10-10 10 10" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        <circle cx="30" cy="20" r="3" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="business_logo" class="relative font-medium bg-white rounded-md cursor-pointer text-primary hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-primary">
                                            <span><?php echo !empty($business['business_logo']) ? 'Replace logo' : 'Upload logo'; ?></span>
                                            <input id="business_logo" name="business_logo" type="file" class="sr-only" accept="image/jpeg,image/png,image/gif">
                                        </label>
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">JPEG, PNG, GIF up to 2MB</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Banner Image Upload -->
                <div>
                    <label for="banner_image" class="block mb-1 text-xs font-medium text-gray-500">
                        Banner Image
                    </label>
                    <p class="mt-1 text-xs text-gray-500">
                        A photo larger than 400 pixels work best. Banner images optical dimension 1520x400. Max photo size 5 MB.
                    </p>

                    <?php if (!empty($business['banner_image'])): ?>
                        <div class="mt-2 mb-4">
                            <img src="<?php echo htmlspecialchars($business['banner_image']); ?>"
                                alt="Current Banner"
                                class="object-cover w-full h-32 border border-gray-300 rounded-md">
                            <p class="mt-1 text-xs text-gray-500">Current banner image. Upload a new one to replace it.</p>
                        </div>
                    <?php endif; ?>

                    <div class="mt-2">
                        <div class="flex justify-center px-6 pt-5 pb-6 transition-colors border-2 border-gray-300 border-dashed rounded-md hover:border-gray-400">
                            <div class="space-y-1 text-center">
                                <svg class="w-12 h-12 mx-auto text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="banner_image" class="relative font-medium bg-white rounded-md cursor-pointer text-primary hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-primary">
                                        <span><?php echo !empty($business['banner_image']) ? 'Replace banner' : 'Upload banner'; ?></span>
                                        <input id="banner_image" name="banner_image" type="file" class="sr-only" accept="image/jpeg,image/png">
                                    </label>
                                </div>
                                <p class="text-xs text-gray-500">JPEG, PNG up to 5MB</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Company Name -->
                <div>
                    <label for="business_name" class="block mb-1 text-xs font-medium text-gray-500">
                        Company Name <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-1">
                        <input id="business_name" name="business_name" type="text" required
                            value="<?php echo htmlspecialchars($business['business_name'] ?? $_POST['business_name'] ?? ''); ?>"
                            placeholder="Enter your company name"
                            class="block w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-400 transition-all bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary hover:border-gray-400">
                    </div>
                </div>

                <!-- About Us -->
                <div>
                    <label for="business_desc" class="block mb-1 text-xs font-medium text-gray-500">
                        About Us <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-1">
                        <textarea id="business_desc" name="business_desc" rows="6" required
                            placeholder="Write down about your company here. Let the candidate know who we are..."
                            class="block w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-400 transition-all bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary hover:border-gray-400"><?php echo htmlspecialchars($business['business_desc'] ?? $_POST['business_desc'] ?? ''); ?></textarea>
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Describe your company, mission, values, and what makes you unique.</p>
                </div>

                <div class="flex justify-between">
                    <a href="?page=employer-dashboard" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back to Dashboard
                    </a>
                    <button type="submit" name="submit_step1"
                        class="inline-flex items-center px-6 py-2 text-sm font-medium text-white border border-transparent rounded-md shadow-sm bg-primary hover:bg-blue-700">
                        Next Step
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>