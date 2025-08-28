<?php
include_once __DIR__ . '/../components/employer_auth_check.php';
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
                Founding Information
            </h2>
            <p class="mt-2 text-sm text-center text-gray-600">
                Step 2/5 - Organization details
            </p>
            <p class="mt-2 text-sm text-center text-gray-500">
                Provide your company's founding information
            </p>
        </div>
    </div>

    <div class="mt-4 sm:mx-auto sm:w-full sm:max-w-2xl">
        <div class="px-4 py-8 bg-white shadow sm:rounded-lg sm:px-10">
            <!-- Enhanced Progress bar with clickable steps -->
            <div class="mb-6">
                <!-- Step indicators -->
                <div class="flex items-center justify-between w-full mb-4">
                    <!-- Step 1 -->
                    <div class="flex flex-col items-center">
                        <a href="?page=complete-employer-business&step=1" class="flex items-center justify-center w-8 h-8 text-white transition-colors rounded-full bg-primary hover:bg-blue-700">
                            <span class="text-sm font-semibold">1</span>
                        </a>
                        <span class="mt-1 text-xs text-gray-600">Basic</span>
                    </div>

                    <!-- Step 2 -->
                    <div class="flex flex-col items-center">
                        <div class="flex items-center justify-center w-8 h-8 text-white rounded-full bg-primary">
                            <span class="text-sm font-semibold">2</span>
                        </div>
                        <span class="mt-1 text-xs text-gray-600">Founding</span>
                    </div>

                    <!-- Step 3 -->
                    <div class="flex flex-col items-center">
                        <a href="?page=complete-employer-business&step=3" class="flex items-center justify-center w-8 h-8 text-gray-500 transition-colors bg-gray-200 rounded-full hover:bg-gray-300 hover:text-gray-700">
                            <span class="text-sm font-semibold">3</span>
                        </a>
                        <span class="mt-1 text-xs text-gray-500">Social</span>
                    </div>

                    <!-- Step 4 -->
                    <div class="flex flex-col items-center">
                        <a href="?page=complete-employer-business&step=4" class="flex items-center justify-center w-8 h-8 text-gray-500 transition-colors bg-gray-200 rounded-full hover:bg-gray-300 hover:text-gray-700">
                            <span class="text-sm font-semibold">4</span>
                        </a>
                        <span class="mt-1 text-xs text-gray-500">Documents</span>
                    </div>

                    <!-- Step 5 -->
                    <div class="flex flex-col items-center">
                        <a href="?page=complete-employer-business&step=5" class="flex items-center justify-center w-8 h-8 text-gray-500 transition-colors bg-gray-200 rounded-full hover:bg-gray-300 hover:text-gray-700">
                            <span class="text-sm font-semibold">5</span>
                        </a>
                        <span class="mt-1 text-xs text-gray-500">Review</span>
                    </div>
                </div>

                <!-- Progress bar -->
                <div class="w-full h-2 bg-gray-200 rounded">
                    <div class="h-2 rounded bg-primary" style="width: 40%"></div>
                </div>
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

            <form class="space-y-6" method="POST" action="?page=complete-employer-business&step=2">
                <!-- Organization Type -->
                <div>
                    <label for="business_type" class="block mb-1 text-xs font-medium text-gray-500">
                        Organization Type <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-1">
                        <select id="business_type" name="business_type" required
                            class="block w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-400 transition-all bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary hover:border-gray-400">
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
                    <label for="business_industry" class="block mb-1 text-xs font-medium text-gray-500">
                        Industry Types <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-1">
                        <select id="business_industry" name="business_industry" required
                            class="block w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-400 transition-all bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary hover:border-gray-400">
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
                    <label for="business_address" class="block mb-1 text-xs font-medium text-gray-500">
                        Address <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-1">
                        <textarea id="business_address" name="business_address" rows="3" required
                            placeholder="Enter complete business address"
                            class="block w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-400 transition-all bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary hover:border-gray-400"><?php echo htmlspecialchars($business['business_address'] ?? $_POST['business_address'] ?? ''); ?></textarea>
                    </div>
                </div>

                <!-- Contact -->
                <div>
                    <label for="business_contact" class="block mb-1 text-xs font-medium text-gray-500">
                        Contact <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-1">
                        <input id="business_contact" name="business_contact" type="tel" required
                            value="<?php echo htmlspecialchars($business['business_contact'] ?? $_POST['business_contact'] ?? ''); ?>"
                            placeholder="Business contact number"
                            class="block w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-400 transition-all bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary hover:border-gray-400">
                    </div>
                </div>

                <!-- Team Size and Year of Establishment -->
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="business_size" class="block mb-1 text-xs font-medium text-gray-500">
                            Team Size <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1">
                            <select id="business_size" name="business_size" required
                                class="block w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-400 transition-all bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary hover:border-gray-400">
                                <option value="">Select...</option>
                                <option value="1-10" <?php echo ($business['business_size'] ?? $_POST['business_size'] ?? '') === '1-10' ? 'selected' : ''; ?>>1-10 employees</option>
                                <option value="11-50" <?php echo ($business['business_size'] ?? $_POST['business_size'] ?? '') === '11-50' ? 'selected' : ''; ?>>11-50 employees</option>
                                <option value="51-100" <?php echo ($business['business_size'] ?? $_POST['business_size'] ?? '') === '51-100' ? 'selected' : ''; ?>>51-100 employees</option>
                                <option value="100+" <?php echo ($business['business_size'] ?? $_POST['business_size'] ?? '') === '100+' ? 'selected' : ''; ?>>100+ employees</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label for="business_established_year" class="block mb-1 text-xs font-medium text-gray-500">
                            Year of Establishment <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1">
                            <input id="business_established_year" name="business_established_year" type="date" required
                                value="<?php echo htmlspecialchars($business['business_established_year'] ?? $_POST['business_established_year'] ?? ''); ?>"
                                class="block w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-400 transition-all bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary hover:border-gray-400">
                        </div>
                    </div>
                </div>

                <!-- Company Website -->
                <div>
                    <label for="business_website" class="block mb-1 text-xs font-medium text-gray-500">
                        Company Website
                    </label>
                    <div class="mt-1">
                        <input id="business_website" name="business_website" type="url"
                            value="<?php echo htmlspecialchars($business['business_website'] ?? $_POST['business_website'] ?? ''); ?>"
                            placeholder="https://yourcompany.com"
                            class="block w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-400 transition-all bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary hover:border-gray-400">
                    </div>
                </div>

                <!-- Company Email -->
                <div>
                    <label for="business_email" class="block mb-1 text-xs font-medium text-gray-500">
                        Company Email
                    </label>
                    <div class="mt-1">
                        <input id="business_email" name="business_email" type="email"
                            value="<?php echo htmlspecialchars($business['business_email'] ?? $_POST['business_email'] ?? ''); ?>"
                            placeholder="company@example.com"
                            class="block w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-400 transition-all bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary hover:border-gray-400">
                    </div>
                </div>

                <div class="flex justify-between">
                    <a href="?page=complete-employer-business&step=1" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back
                    </a>
                    <?php
                    // Check if business has existing data for step 2
                    $hasExistingData = !empty($business['business_type']) || !empty($business['business_industry']) || !empty($business['business_address']);
                    ?>
                    <?php if ($hasExistingData): ?>
                        <button type="submit" name="submit_step2"
                            class="inline-flex items-center px-6 py-2 text-sm font-medium text-white border border-transparent rounded-md shadow-sm bg-primary hover:bg-blue-700">
                            Next Step
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>
                    <?php else: ?>

                        <button type="submit" name="submit_step2"
                            class="inline-flex items-center px-6 py-2 text-sm font-medium text-white border border-transparent rounded-md shadow-sm bg-primary ">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Update
                        </button>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>
</div>