<?php
include_once __DIR__ . '/../components/jobseeker_auth_check.php';
include_once __DIR__ . '/../../components/navbar-top.php';
include_once __DIR__ . '/../navbar-jobseeker.php';
?>

<div class="min-h-screen bg-gray-50">
    <div class="px-6 py-12">
        <div class="max-w-2xl mx-auto">
            <!-- Header -->
            <div class="mb-8 text-center">
                <div class="flex justify-center mb-4">
                    <div class="flex items-center justify-center w-16 h-16 bg-red-100 rounded-full">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.996-.833-2.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z" />
                        </svg>
                    </div>
                </div>
                <h1 class="text-2xl font-bold text-gray-900">Confirm Resignation</h1>
                <p class="mt-2 text-sm text-gray-600">
                    Are you sure you want to resign from this position?
                </p>
            </div>

            <!-- Add error/success messages at the top -->
            <?php if (!empty($_GET['error'])): ?>
                <div class="p-4 mb-6 text-red-700 bg-red-100 border border-red-400 rounded">
                    <?php echo htmlspecialchars($_GET['error']); ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($_GET['success'])): ?>
                <div class="p-4 mb-6 text-green-700 bg-green-100 border border-green-400 rounded">
                    <?php echo htmlspecialchars($_GET['success']); ?>
                </div>
            <?php endif; ?>

            <!-- Job Information Card -->
            <div class="overflow-hidden bg-white border border-gray-200 rounded-lg shadow-sm">
                <div class="p-6">
                    <div class="flex items-start gap-4">
                        <!-- Company Logo -->
                        <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 overflow-hidden border-2 border-gray-200 rounded-lg">
                            <?php if (!empty($application['business_logo'])): ?>
                                <img src="<?php echo htmlspecialchars($application['business_logo']); ?>" alt="Company Logo" class="object-cover w-full h-full">
                            <?php else: ?>
                                <i class="text-xl text-gray-500 fas fa-building"></i>
                            <?php endif; ?>
                        </div>

                        <div class="flex-1">
                            <h2 class="text-lg font-semibold text-gray-900">
                                <?php echo htmlspecialchars($application['job_title']); ?>
                            </h2>
                            <p class="text-sm text-gray-600">
                                <?php echo htmlspecialchars($application['company_name'] ?? $application['business_name'] ?? 'Company'); ?>
                            </p>
                            <div class="flex items-center mt-2 space-x-4 text-sm text-gray-500">
                                <span>
                                    <i class="mr-1 fas fa-calendar"></i>
                                    Hired on <?php echo date('M j, Y', strtotime($application['reviewed_at'] ?? $application['applied_at'])); ?>
                                </span>
                                <span>
                                    <i class="mr-1 fas fa-map-marker-alt"></i>
                                    <?php echo htmlspecialchars($application['location'] ?? 'Location not specified'); ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Warning Message -->
            <div class="p-4 mt-6 border border-yellow-200 rounded-lg bg-yellow-50">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-yellow-800">
                            Important Notice
                        </h3>
                        <div class="mt-2 text-sm text-yellow-700">
                            <ul class="pl-5 space-y-1 list-disc">
                                <li>This action cannot be undone</li>
                                <li>Your employment status will be updated to "Resigned"</li>
                                <li>The employer will be notified of your resignation</li>
                                <li>You may need to follow your company's resignation procedures separately</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Resignation Form -->
            <form method="POST" action="?page=resign-from-job&id=<?php echo $application['application_id']; ?>" class="mt-8">
                <div class="mb-6">
                    <label for="resignation_reason" class="block mb-2 text-sm font-medium text-gray-700">
                        Reason for Resignation (Optional)
                    </label>
                    <textarea
                        id="resignation_reason"
                        name="resignation_reason"
                        rows="4"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary"
                        placeholder="Please provide a brief reason for your resignation..."></textarea>
                </div>

                <div class="flex items-center justify-between">
                    <a href="?page=my-applications"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        <i class="mr-2 fas fa-arrow-left"></i>
                        Cancel
                    </a>

                    <button type="submit"
                        name="confirm_resignation"
                        value="1"
                        onclick="return confirm('Are you absolutely sure you want to resign from this position? This action will send a resignation request to your employer for approval.')"
                        class="inline-flex items-center px-6 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        <i class="mr-2 fas fa-sign-out-alt"></i>
                        Submit Resignation Request
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>