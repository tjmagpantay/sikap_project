<?php
include_once __DIR__ . '/../components/employer_auth_check.php';
include_once __DIR__ . '../../../components/navbar-top.php';
include_once __DIR__ . '/../components/navbar-employer.php';

// Check if this is a first-time setup or an update
$isFirstTime = isset($_GET['first_time']) && $_GET['first_time'] === 'true';
$updateType = $_GET['type'] ?? 'profile'; // profile, business, or complete

// Determine the message based on context
if ($isFirstTime) {
    $title = "🎉 Profile Setup Complete!";
    $subtitle = "Your employer profile has been successfully submitted for review.";
    $details = "Thank you for completing your employer profile setup. Your information has been securely saved and submitted to our verification team for review.";
    $showReviewProcess = true;
} else {
    switch ($updateType) {
        case 'business':
            $title = "Business Profile Updated";
            $subtitle = "Your business information has been updated successfully.";
            $details = "All changes to your business profile have been saved. Your updated information is now visible to potential candidates.";
            break;
        case 'complete':
            $title = "Profile Updated Successfully";
            $subtitle = "All changes have been saved to your employer profile.";
            $details = "Your complete employer profile has been updated with the latest information. Changes are now live and visible to job seekers.";
            break;
        default:
            $title = "Profile Updated Successfully";
            $subtitle = "Your employer profile has been updated successfully.";
            $details = "Your personal information has been updated and saved. Changes to your profile are now active and visible to potential candidates.";
    }
    $showReviewProcess = false;
}
?>

<div class="min-h-screen py-12 bg-gray-50">
    <div class="w-full max-w-2xl px-4 mx-auto">
        <div class="max-w-xl mx-auto">
            <!-- Success Animation -->
            <div class="text-center">
                

                <h1 class="mb-2 text-2xl font-bold text-primary">
                    <?php echo $title; ?>
                </h1>

                <p class="max-w-md mx-auto mb-4 text-gray-600">
                    <?php echo $subtitle; ?>
                </p>

                <!-- Additional details -->
                <p class="max-w-lg mx-auto mb-8 text-sm text-gray-500">
                    <?php echo $details; ?>
                </p>
            </div>

            <?php if ($showReviewProcess): ?>
                <!-- Review Status Card (Only for first-time setup) -->
                <div class="p-6 mb-8 bg-white border shadow-sm rounded-xl border-primary/20">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center w-8 h-8 rounded-full bg-primary/10">
                                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h3 class="mb-2 text-lg font-semibold text-primary">Under Review</h3>
                            <p class="mb-3 text-gray-600">
                                Your profile is being reviewed by our admin team. This typically takes 24-48 hours.
                            </p>
                            <div class="flex items-center text-sm text-gray-500">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                <span>You'll receive an email notification once verified.</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- What's Next (Only for first-time setup) -->
                <div class="p-6 mb-8 bg-white border shadow-sm rounded-xl border-secondary/20">
                    <h3 class="flex items-center mb-4 text-lg font-semibold text-primary">
                        <svg class="w-5 h-5 mr-2 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                        </svg>
                        What's Next?
                    </h3>

                    <div class="space-y-3">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mt-1">
                                <div class="flex items-center justify-center w-5 h-5 text-xs font-medium text-white rounded-full bg-primary">1</div>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">Wait for verification</p>
                                <p class="text-xs text-gray-500">Our team reviews your documents and information for authenticity</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex-shrink-0 mt-1">
                                <div class="flex items-center justify-center w-5 h-5 text-xs font-medium text-gray-600 bg-gray-200 rounded-full">2</div>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-700">Get verified & start hiring</p>
                                <p class="text-xs text-gray-500">Post unlimited jobs and access premium employer features</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Limitations Notice (Only for first-time setup) -->
                <div class="p-4 mb-8 border border-yellow-200 rounded-lg bg-yellow-50">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h4 class="text-sm font-medium text-yellow-800">Profile Pending Verification</h4>
                            <p class="mt-1 text-xs text-yellow-700">You can browse candidates and explore the platform, but job posting is restricted until profile verification is complete.</p>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <!-- Update Success Info (Only for updates) -->
                <div class="p-6 mb-8 bg-white border shadow-sm rounded-xl border-primary/20">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center w-8 h-8 rounded-full bg-secondary/10">
                                <svg class="w-5 h-5 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h3 class="mb-2 text-lg font-semibold text-primary">Profile Updated</h3>
                            <div class="space-y-2 text-sm text-gray-600">
                                <p>• Your changes are now live and visible to job seekers</p>
                                <p>• Profile information has been automatically saved</p>
                                <p>• No additional verification required for updates</p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Action Buttons -->
            <div class="space-y-3">
                <a href="?page=employer-dashboard"
                    class="flex items-center justify-center w-full px-6 py-3 text-sm font-semibold text-white transition-all duration-200 rounded-lg shadow-sm bg-primary hover:bg-blue-700">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h2a2 2 0 012 2v0M8 5a2 2 0 012-2h2a2 2 0 012 2v0"></path>
                    </svg>
                    Go to Dashboard
                </a>

                <div class="grid grid-cols-2 gap-3">
                    <a href="?page=profile-employer"
                        class="flex items-center justify-center px-4 py-2 text-sm font-medium transition-all duration-200 bg-white border rounded-lg shadow-sm text-primary border-primary/30 hover:bg-primary/5">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        View Profile
                    </a>

                    <a href="?page=browse-candidates"
                        class="flex items-center justify-center px-4 py-2 text-sm font-medium text-gray-700 transition-all duration-200 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                        Browse Candidates
                    </a>
                </div>
            </div>

            <!-- Support Link -->
            <?php if ($showReviewProcess): ?>
                <div class="pt-6 mt-8 text-center border-t border-gray-200">
                    <p class="mb-2 text-sm text-gray-600">Questions about verification?</p>
                    <a href="?page=contact-support"
                        class="inline-flex items-center text-sm font-medium text-secondary hover:text-green-700">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Contact Support
                    </a>
                </div>
            <?php else: ?>
                <div class="py-6 mt-8 text-center border-t border-gray-200">
                    <p class="text-sm text-gray-600">
                        Last updated: <span class="font-medium"><?php echo date('M d, Y \a\t g:i A'); ?></span>
                    </p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
    @keyframes fadeInUp {
        0% {
            opacity: 0;
            transform: translateY(10px);
        }

        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fadeInUp {
        animation: fadeInUp 0.5s ease-out;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add fade-in animation to the main content
        const mainContent = document.querySelector('.max-w-xl');
        if (mainContent) {
            mainContent.classList.add('animate-fadeInUp');
        }
    });
</script>