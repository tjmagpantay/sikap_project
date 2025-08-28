<?php
include_once __DIR__ . '/../components/employer_auth_check.php';
include_once __DIR__ . '../../../components/navbar-top.php';
include_once __DIR__ . '/../components/navbar-employer.php';
?>

<div class="min-h-screen py-8 bg-gradient-to-b from-green-50 to-white">
    <div class="w-full max-w-2xl px-4 mx-auto sm:px-8 lg:px-32 xl:px-64">
        <div class="max-w-3xl mx-auto">
            <!-- Success Animation -->
            <div class="text-center">
                <div class="flex justify-center mb-8">
                    <div class="relative">
                        <div class="absolute inset-0 bg-green-100 rounded-full opacity-75 animate-ping"></div>
                        <div class="relative flex items-center justify-center w-24 h-24 mx-auto rounded-full shadow-lg bg-secondary">
                            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <h1 class="mb-2 text-2xl font-bold tracking-tight text-primary">
                    🎉 Profile Setup Complete!
                </h1>
                
                <p class="max-w-md mx-auto mb-8 text-gray-600">
                    Your employer profile has been successfully submitted for review.
                </p>
            </div>

            <!-- Status Card -->
            <div class="p-6 mb-8 overflow-hidden bg-white border border-blue-200 shadow-sm rounded-xl">
                <div class="relative">
                    <div class="absolute top-0 left-0 w-1 h-full bg-blue-600"></div>
                    <div class="pl-6">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <i class="text-xl text-blue-600 fas fa-clock"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="mb-2 text-lg font-medium text-blue-900">Under Review</h3>
                                <p class="mb-4 text-blue-700">
                                    Your profile is currently being reviewed by our admin team. This process typically takes 24-48 hours.
                                </p>
                                <div class="flex items-center text-sm text-blue-600">
                                    <i class="mr-2 fas fa-info-circle"></i>
                                    <span>You'll receive an email notification once your profile is verified.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- What's Next Section -->
            <div class="p-6 mb-8 overflow-hidden bg-white border border-gray-200 shadow-sm rounded-xl">
                <div class="relative">
                    <div class="absolute top-0 left-0 w-1 h-full bg-green-600"></div>
                    <div class="pl-6">
                        <h3 class="flex items-center mb-6 text-lg font-semibold text-primary">
                            <i class="mr-2 text-green-600 fas fa-list-check"></i>
                            What's Next?
                        </h3>
                        
                        <ul class="space-y-4">
                            <!-- Step 1 -->
                            <li class="flex items-start">
                                <div class="flex-shrink-0 mt-1">
                                    <div class="flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full text-primary">
                                        <span class="text-sm font-medium">1</span>
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <h4 class="font-medium text-gray-900">Wait for Verification</h4>
                                    <p class="text-sm text-gray-600">Our team will review your documents and business information.</p>
                                </div>
                            </li>

                            <!-- Step 2 -->
                            <li class="flex items-start">
                                <div class="flex-shrink-0 mt-1">
                                    <div class="flex items-center justify-center w-6 h-6 text-gray-600 bg-gray-100 rounded-full">
                                        <span class="text-sm font-medium">2</span>
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <h4 class="font-medium text-gray-900">Get Verified</h4>
                                    <p class="text-sm text-gray-600">Once approved, you'll be able to post jobs and access all employer features.</p>
                                </div>
                            </li>

                            <!-- Step 3 -->
                            <li class="flex items-start">
                                <div class="flex-shrink-0 mt-1">
                                    <div class="flex items-center justify-center w-6 h-6 text-gray-600 bg-gray-100 rounded-full">
                                        <span class="text-sm font-medium">3</span>
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <h4 class="font-medium text-gray-900">Start Hiring</h4>
                                    <p class="text-sm text-gray-600">Post job openings, browse candidates, and find the perfect match for your team.</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Current Limitations Notice -->
            <div class="p-6 mb-8 overflow-hidden bg-white border border-yellow-200 shadow-sm rounded-xl">
                <div class="relative">
                    <div class="absolute top-0 left-0 w-1 h-full bg-yellow-400"></div>
                    <div class="pl-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="text-yellow-600 fas fa-exclamation-triangle"></i>
                            </div>
                            <div class="ml-3">
                                <h4 class="text-sm font-medium text-yellow-800">Profile Not Yet Verified</h4>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>Until your profile is verified, you won't be able to:</p>
                                    <ul class="mt-2 space-y-1 list-disc list-inside">
                                        <li>Post new job opportunities</li>
                                        <li>Access premium employer features</li>
                                        <li>View detailed candidate profiles</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="grid grid-cols-1 gap-4 mb-8 sm:grid-cols-2">
                <a href="?page=employer-dashboard" 
                   class="flex items-center justify-center px-6 py-3 text-sm font-medium text-white transition-all duration-200 border border-transparent rounded-lg shadow-sm bg-primary hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    <i class="mr-2 fas fa-home"></i>
                    Go to Dashboard
                </a>
                
                <a href="?page=profile-employer" 
                   class="flex items-center justify-center px-6 py-3 text-sm font-medium transition-all duration-200 bg-white border border-green-300 rounded-lg shadow-sm text-primary hover:bg-green-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    <i class="mr-2 fas fa-user-edit"></i>
                    View Profile
                </a>
                
                <a href="?page=browse-candidates" 
                   class="flex items-center justify-center px-6 py-3 text-sm font-medium text-gray-700 transition-all duration-200 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    <i class="mr-2 fas fa-users"></i>
                    Browse Candidates
                </a>
                
                <a href="?page=employer-help" 
                   class="flex items-center justify-center px-6 py-3 text-sm font-medium text-gray-700 transition-all duration-200 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    <i class="mr-2 fas fa-question-circle"></i>
                    Help & Support
                </a>
            </div>

            <!-- Contact Support -->
            <div class="pt-6 mt-8 text-center border-t border-gray-200">
                <p class="mb-4 text-sm text-gray-600">
                    Have questions about the verification process?
                </p>
                <a href="?page=contact-support" 
                   class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-700">
                    <i class="mr-2 fas fa-headset"></i>
                    Contact Support
                    <i class="ml-2 text-xs fas fa-external-link-alt"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes checkmark {
    0% {
        transform: scale(0);
        opacity: 0;
    }
    50% {
        transform: scale(1.2);
    }
    100% {
        transform: scale(1);
        opacity: 1;
    }
}

.animate-checkmark {
    animation: checkmark 0.6s ease-in-out;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animate the success message
    setTimeout(() => {
        const checkmarkIcon = document.querySelector('.fa-check');
        if (checkmarkIcon) {
            checkmarkIcon.classList.add('animate-checkmark');
        }
    }, 300);
});
</script>