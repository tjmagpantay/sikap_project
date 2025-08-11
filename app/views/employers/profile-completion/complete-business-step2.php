<?php
include_once __DIR__ . '../../../components/navbar-top.php';
include_once __DIR__ . '/../components/navbar-employer.php';
?>
<div class="min-h-screen py-12 bg-gray-50 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-2xl">
        <div class="text-center">
            <div class="flex justify-center mb-4">
                <div class="p-3 bg-blue-600 rounded-full">
                    <i class="text-2xl text-white fas fa-info-circle"></i>
                </div>
            </div>
            <h2 class="mt-6 text-3xl font-extrabold text-center text-gray-900">
                Founding Information
            </h2>
            <p class="mt-2 text-sm text-center text-gray-600">
                Step 2/5
            </p>
            <p class="mt-2 text-sm text-center text-gray-500">
                Organization details and founding information
            </p>
        </div>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-2xl">
        <div class="px-4 py-8 bg-white shadow sm:rounded-lg sm:px-10">
            <!-- Progress bar -->
            <div class="w-full h-2 mb-6 bg-gray-200 rounded">
                <div class="h-2 bg-blue-600 rounded" style="width: 40%"></div>
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

            <form class="space-y-6" method="POST" action="?page=complete-employer-business&step=2">
                <!-- Organization Type -->
                <div>
                    <label for="business_type" class="block text-sm font-medium text-gray-700">
                        Organization Type <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-1">
                        <select id="business_type" name="business_type" required
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Select organization type</option>
                            <option value="Corporation" <?php echo ($business['business_type'] ?? $_POST['business_type'] ?? '') === 'Corporation' ? 'selected' : ''; ?>>Corporation</option>
                            <option value="Partnership" <?php echo ($business['business_type'] ?? $_POST['business_type'] ?? '') === 'Partnership' ? 'selected' : ''; ?>>Partnership</option>
                            <option value="Sole Proprietorship" <?php echo ($business['business_type'] ?? $_POST['business_type'] ?? '') === 'Sole Proprietorship' ? 'selected' : ''; ?>>Sole Proprietorship</option>
                            <option value="Non-Profit" <?php echo ($business['business_type'] ?? $_POST['business_type'] ?? '') === 'Non-Profit' ? 'selected' : ''; ?>>Non-Profit</option>
                        </select>
                    </div>
                </div>

                <!-- Industry Type -->
                <div>
                    <label for="business_industry" class="block text-sm font-medium text-gray-700">
                        Industry Types <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-1">
                        <select id="business_industry" name="business_industry" required
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Select...</option>
                            <option value="Technology" <?php echo ($business['business_industry'] ?? $_POST['business_industry'] ?? '') === 'Technology' ? 'selected' : ''; ?>>Technology</option>
                            <option value="Healthcare" <?php echo ($business['business_industry'] ?? $_POST['business_industry'] ?? '') === 'Healthcare' ? 'selected' : ''; ?>>Healthcare</option>
                            <option value="Finance" <?php echo ($business['business_industry'] ?? $_POST['business_industry'] ?? '') === 'Finance' ? 'selected' : ''; ?>>Finance</option>
                            <option value="Education" <?php echo ($business['business_industry'] ?? $_POST['business_industry'] ?? '') === 'Education' ? 'selected' : ''; ?>>Education</option>
                            <option value="Manufacturing" <?php echo ($business['business_industry'] ?? $_POST['business_industry'] ?? '') === 'Manufacturing' ? 'selected' : ''; ?>>Manufacturing</option>
                            <option value="Retail" <?php echo ($business['business_industry'] ?? $_POST['business_industry'] ?? '') === 'Retail' ? 'selected' : ''; ?>>Retail</option>
                            <option value="Construction" <?php echo ($business['business_industry'] ?? $_POST['business_industry'] ?? '') === 'Construction' ? 'selected' : ''; ?>>Construction</option>
                            <option value="Transportation" <?php echo ($business['business_industry'] ?? $_POST['business_industry'] ?? '') === 'Transportation' ? 'selected' : ''; ?>>Transportation</option>
                            <option value="Food & Beverage" <?php echo ($business['business_industry'] ?? $_POST['business_industry'] ?? '') === 'Food & Beverage' ? 'selected' : ''; ?>>Food & Beverage</option>
                            <option value="Other" <?php echo ($business['business_industry'] ?? $_POST['business_industry'] ?? '') === 'Other' ? 'selected' : ''; ?>>Other</option>
                        </select>
                    </div>
                </div>

                <!-- Address -->
                <div>
                    <label for="business_address" class="block text-sm font-medium text-gray-700">
                        Address <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-1">
                        <textarea id="business_address" name="business_address" rows="3" required
                                  placeholder="Enter complete business address"
                                  class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-blue-500 focus:border-blue-500"><?php echo htmlspecialchars($business['business_address'] ?? $_POST['business_address'] ?? ''); ?></textarea>
                    </div>
                </div>

                <!-- Contact -->
                <div>
                    <label for="business_contact" class="block text-sm font-medium text-gray-700">
                        Contact <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-1">
                        <input id="business_contact" name="business_contact" type="tel" required
                               value="<?php echo htmlspecialchars($business['business_contact'] ?? $_POST['business_contact'] ?? ''); ?>"
                               placeholder="Business contact number"
                               class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <!-- Team Size and Year of Establishment -->
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="business_size" class="block text-sm font-medium text-gray-700">
                            Team Size <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1">
                            <select id="business_size" name="business_size" required
                                    class="block w-full px-3 py-2 border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Select...</option>
                                <option value="1-10" <?php echo ($business['business_size'] ?? $_POST['business_size'] ?? '') === '1-10' ? 'selected' : ''; ?>>1-10 employees</option>
                                <option value="11-50" <?php echo ($business['business_size'] ?? $_POST['business_size'] ?? '') === '11-50' ? 'selected' : ''; ?>>11-50 employees</option>
                                <option value="51-100" <?php echo ($business['business_size'] ?? $_POST['business_size'] ?? '') === '51-100' ? 'selected' : ''; ?>>51-100 employees</option>
                                <option value="100+" <?php echo ($business['business_size'] ?? $_POST['business_size'] ?? '') === '100+' ? 'selected' : ''; ?>>100+ employees</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label for="business_established_year" class="block text-sm font-medium text-gray-700">
                            Year of Establishment <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1">
                            <input id="business_established_year" name="business_established_year" type="date" required
                                   value="<?php echo htmlspecialchars($business['business_established_year'] ?? $_POST['business_established_year'] ?? ''); ?>"
                                   class="block w-full px-3 py-2 border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                </div>

                <!-- Company Website -->
                <div>
                    <label for="business_website" class="block text-sm font-medium text-gray-700">
                        Company Website
                    </label>
                    <div class="mt-1">
                        <input id="business_website" name="business_website" type="url"
                               value="<?php echo htmlspecialchars($business['business_website'] ?? $_POST['business_website'] ?? ''); ?>"
                               placeholder="https://yourcompany.com"
                               class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <!-- Company Email -->
                <div>
                    <label for="business_email" class="block text-sm font-medium text-gray-700">
                        Company Email
                    </label>
                    <div class="mt-1">
                        <input id="business_email" name="business_email" type="email"
                               value="<?php echo htmlspecialchars($business['business_email'] ?? $_POST['business_email'] ?? ''); ?>"
                               placeholder="company@example.com"
                               class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <div class="flex justify-between">
                    <a href="?page=complete-employer-business&step=1" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                        <i class="mr-2 fas fa-arrow-left"></i>
                        Back
                    </a>
                <button type="submit" name="submit_step2"
                    class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white transition-colors bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                    <i class="mr-2 fas fa-arrow-right"></i>
                    Next Step
                </button>
                </div>
            </form>
        </div>
    </div>
</div>