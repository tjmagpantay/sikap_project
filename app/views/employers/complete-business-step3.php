<?php
// filepath: c:\xampp\htdocs\sikap\app\views\employers\complete-business-step3.php
include_once __DIR__ . '/../components/navbar-top.php';
include_once __DIR__ . '/navbar-employer.php';

// Decode existing social media data
$socials = [];
if (!empty($business['business_socials'])) {
    $socials = json_decode($business['business_socials'], true) ?? [];
}
?>

<div class="min-h-screen py-12 bg-gray-50 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-2xl">
        <div class="text-center">
            <div class="flex justify-center mb-4">
                <div class="p-3 bg-blue-600 rounded-full">
                    <i class="text-2xl text-white fas fa-share-alt"></i>
                </div>
            </div>
            <h2 class="mt-6 text-3xl font-extrabold text-center text-gray-900">
                Social Media Profile
            </h2>
            <p class="mt-2 text-sm text-center text-gray-600">
                Step 3/5
            </p>
            <p class="mt-2 text-sm text-center text-gray-500">
                Connect your social media profiles
            </p>
        </div>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-2xl">
        <div class="px-4 py-8 bg-white shadow sm:rounded-lg sm:px-10">
            <!-- Progress bar -->
            <div class="w-full h-2 mb-6 bg-gray-200 rounded">
                <div class="h-2 bg-blue-600 rounded" style="width: 60%"></div>
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

            <form class="space-y-6" method="POST" action="?page=complete-employer-business&step=3">
                <!-- Social Link 1 - Facebook -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Social Link 1
                    </label>
                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
                        <div>
                            <select class="block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500" disabled>
                                <option>Facebook</option>
                            </select>
                        </div>
                        <div class="sm:col-span-2">
                            <input name="facebook" type="url"
                                   value="<?php echo htmlspecialchars($socials['facebook'] ?? $_POST['facebook'] ?? ''); ?>"
                                   placeholder="Profile link/url..."
                                   class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                </div>

                <!-- Social Link 2 - Twitter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Social Link 2
                    </label>
                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
                        <div>
                            <select class="block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500" disabled>
                                <option>Twitter</option>
                            </select>
                        </div>
                        <div class="sm:col-span-2">
                            <input name="twitter" type="url"
                                   value="<?php echo htmlspecialchars($socials['twitter'] ?? $_POST['twitter'] ?? ''); ?>"
                                   placeholder="Profile link/url..."
                                   class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                </div>

                <!-- Social Link 3 - Instagram -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Social Link 3
                    </label>
                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
                        <div>
                            <select class="block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500" disabled>
                                <option>Instagram</option>
                            </select>
                        </div>
                        <div class="sm:col-span-2">
                            <input name="instagram" type="url"
                                   value="<?php echo htmlspecialchars($socials['instagram'] ?? $_POST['instagram'] ?? ''); ?>"
                                   placeholder="Profile link/url..."
                                   class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                </div>

                <!-- Social Link 4 - YouTube -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Social Link 4
                    </label>
                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
                        <div>
                            <select class="block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500" disabled>
                                <option>Youtube</option>
                            </select>
                        </div>
                        <div class="sm:col-span-2">
                            <input name="youtube" type="url"
                                   value="<?php echo htmlspecialchars($socials['youtube'] ?? $_POST['youtube'] ?? ''); ?>"
                                   placeholder="Profile link/url..."
                                   class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                </div>

                <!-- Information Note -->
                <div class="p-4 border border-blue-200 rounded-md bg-blue-50">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="text-blue-400 fas fa-info-circle"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-blue-700">
                                <strong>Note:</strong> Social media links are optional but help candidates learn more about your company culture and values.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="flex justify-between">
                    <a href="?page=complete-employer-business&step=2" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                        <i class="mr-2 fas fa-arrow-left"></i>
                        Back
                    </a>
                    <button type="submit" class="inline-flex items-center px-6 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                        Next Step
                        <i class="ml-2 fas fa-arrow-right"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>