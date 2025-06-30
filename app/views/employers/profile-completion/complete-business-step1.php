<?php include_once __DIR__ . '/../../components/navbar-top.php';
include_once __DIR__ . '/../navbar-employer.php';?>

<div class="min-h-screen py-12 bg-gray-50 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-2xl">
        <div class="text-center">
            <div class="flex justify-center mb-4">
                <div class="p-3 bg-blue-600 rounded-full">
                    <i class="text-2xl text-white fas fa-building"></i>
                </div>
            </div>
            <h2 class="mt-6 text-3xl font-extrabold text-center text-gray-900">
                Business Information
            </h2>
            <p class="mt-2 text-sm text-center text-gray-600">
                Step 1/5
            </p>
            <p class="mt-2 text-sm text-center text-gray-500">
                Basic business information, banner and logo
            </p>
        </div>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-2xl">
        <div class="px-4 py-8 bg-white shadow sm:rounded-lg sm:px-10">
            <!-- Progress bar -->
            <div class="w-full h-2 mb-6 bg-gray-200 rounded">
                <div class="h-2 bg-blue-600 rounded" style="width: 20%"></div>
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

            <form class="space-y-6" method="POST" action="?page=complete-employer-business&step=1" enctype="multipart/form-data">
                
                <!-- Business Logo Upload -->
                <div>
                    <label for="business_logo" class="block text-sm font-medium text-gray-700">
                        Business Logo
                    </label>
                    <p class="mt-1 text-sm text-gray-500">
                        Square logo works best. Recommended size: 200x200 pixels. Max file size 2 MB.
                    </p>
                    
                    <?php if (!empty($business['business_logo'])): ?>
                        <div class="mt-2 mb-4">
                            <img src="<?php echo htmlspecialchars($business['business_logo']); ?>" 
                                 alt="Current Logo" 
                                 class="object-contain w-24 h-24 border border-gray-300 rounded-md">
                            <p class="mt-1 text-xs text-gray-500">Current logo. Upload a new one to replace it.</p>
                        </div>
                    <?php endif; ?>
                    
                    <div class="mt-2">
                        <div class="flex justify-center px-6 pt-5 pb-6 transition-colors border-2 border-gray-300 border-dashed rounded-md hover:border-gray-400">
                            <div class="space-y-1 text-center">
                                <svg class="w-8 h-8 mx-auto text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M8 14s0-2 2-2h28s2 0 2 2v28s0 2-2 2H10s-2 0-2-2V14z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M15 30l10-10 10 10" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    <circle cx="30" cy="20" r="3" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="business_logo" class="relative font-medium text-blue-600 bg-white rounded-md cursor-pointer hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                        <span><?php echo !empty($business['business_logo']) ? 'Replace logo' : 'Upload logo'; ?></span>
                                        <input id="business_logo" name="business_logo" type="file" class="sr-only" accept="image/jpeg,image/png,image/gif">
                                    </label>
                                </div>
                                <p class="text-xs text-gray-500">JPEG, PNG, GIF up to 2MB</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Banner Image Upload -->
                <div>
                    <label for="banner_image" class="block text-sm font-medium text-gray-700">
                        Banner Image
                    </label>
                    <p class="mt-1 text-sm text-gray-500">
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
                                    <label for="banner_image" class="relative font-medium text-blue-600 bg-white rounded-md cursor-pointer hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
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
                    <label for="business_name" class="block text-sm font-medium text-gray-700">
                        Company Name <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-1">
                        <input id="business_name" name="business_name" type="text" required
                               value="<?php echo htmlspecialchars($business['business_name'] ?? $_POST['business_name'] ?? ''); ?>"
                               placeholder="Enter your company name"
                               class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <!-- About Us -->
                <div>
                    <label for="business_desc" class="block text-sm font-medium text-gray-700">
                        About Us <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-1">
                        <textarea id="business_desc" name="business_desc" rows="6" required
                                  placeholder="Write down about your company here. Let the candidate know who we are..."
                                  class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-blue-500 focus:border-blue-500"><?php echo htmlspecialchars($business['business_desc'] ?? $_POST['business_desc'] ?? ''); ?></textarea>
                    </div>
                    <p class="mt-1 text-sm text-gray-500">Describe your company, mission, values, and what makes you unique.</p>
                </div>

                <div class="flex justify-between">
                    <a href="?page=employer-dashboard" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                        <i class="mr-2 fas fa-arrow-left"></i>
                        Back to Dashboard
                    </a>
                    <button type="submit" name="submit_step1"
                        class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white transition-colors bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                        <i class="mr-2 fas fa-arrow-right"></i>
                        Next Step
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>