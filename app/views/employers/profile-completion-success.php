<?php
// filepath: c:\xampp\htdocs\sikap\app\views\employers\profile-completion-success.php
include_once __DIR__ . '/../components/navbar-top.php';
include_once __DIR__ . '/navbar-employer.php';
?>

<div class="min-h-screen py-12 bg-gray-50 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-2xl">
        <div class="px-4 py-8 bg-white shadow sm:rounded-lg sm:px-10">
            <!-- Success Animation -->
            <div class="text-center">
                <div class="flex justify-center mb-6">
                    <div class="relative">
                        <!-- Animated checkmark circle -->
                        <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center animate-pulse">
                            <div class="w-16 h-16 bg-green-600 rounded-full flex items-center justify-center">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                        </div>
                        <!-- Animated rings -->
                        <div class="absolute inset-0 w-24 h-24 border-4 border-green-200 rounded-full animate-ping"></div>
                        <div class="absolute inset-2 w-20 h-20 border-2 border-green-300 rounded-full animate-ping" style="animation-delay: 0.5s;"></div>
                    </div>
                </div>

                <h1 class="text-3xl font-bold text-gray-900 mb-4">
                    🎉 Profile Setup Complete!
                </h1>
                
                <p class="text-lg text-gray-600 mb-8">
                    Your employer profile has been successfully submitted for review.
                </p>
            </div>

            <!-- Status Card -->
            <div class="mb-8 p-6 bg-blue-50 border border-blue-200 rounded-lg">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class="fas fa-clock text-blue-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-blue-900 mb-2">Under Review</h3>
                        <p class="text-blue-700 mb-4">
                            Your profile is currently being reviewed by our admin team. This process typically takes 24-48 hours.
                        </p>
                        <div class="flex items-center text-sm text-blue-600">
                            <i class="fas fa-info-circle mr-2"></i>
                            <span>You'll receive an email notification once your profile is verified.</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- What's Next Section -->
            <div class="mb-8">
                <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-list-check mr-2 text-green-600"></i>
                    What's Next?
                </h3>
                
                <div class="space-y-4">
                    <!-- Step 1 -->
                    <div class="flex items-start p-4 bg-gray-50 rounded-lg">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-medium">1</div>
                        </div>
                        <div class="ml-4">
                            <h4 class="font-medium text-gray-900">Wait for Verification</h4>
                            <p class="text-sm text-gray-600">Our team will review your documents and business information.</p>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="flex items-start p-4 bg-gray-50 rounded-lg">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-gray-400 text-white rounded-full flex items-center justify-center text-sm font-medium">2</div>
                        </div>
                        <div class="ml-4">
                            <h4 class="font-medium text-gray-900">Get Verified</h4>
                            <p class="text-sm text-gray-600">Once approved, you'll be able to post jobs and access all employer features.</p>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="flex items-start p-4 bg-gray-50 rounded-lg">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-gray-400 text-white rounded-full flex items-center justify-center text-sm font-medium">3</div>
                        </div>
                        <div class="ml-4">
                            <h4 class="font-medium text-gray-900">Start Hiring</h4>
                            <p class="text-sm text-gray-600">Post job openings, browse candidates, and find the perfect match for your team.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Current Limitations Notice -->
            <div class="mb-8 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-triangle text-yellow-600"></i>
                    </div>
                    <div class="ml-3">
                        <h4 class="text-sm font-medium text-yellow-800">Profile Not Yet Verified</h4>
                        <div class="mt-2 text-sm text-yellow-700">
                            <p>Until your profile is verified, you won't be able to:</p>
                            <ul class="list-disc list-inside mt-2 space-y-1">
                                <li>Post new job opportunities</li>
                                <li>Access premium employer features</li>
                                <li>View detailed candidate profiles</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="space-y-4">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <a href="?page=employer-dashboard" 
                       class="flex items-center justify-center px-4 py-3 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 transition-colors duration-200">
                        <i class="fas fa-home mr-2"></i>
                        Go to Dashboard
                    </a>
                    
                    <a href="?page=profile-employer" 
                       class="flex items-center justify-center px-4 py-3 text-sm font-medium text-blue-600 bg-white border border-blue-600 rounded-md hover:bg-blue-50 transition-colors duration-200">
                        <i class="fas fa-user-edit mr-2"></i>
                        View Profile
                    </a>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <a href="?page=browse-candidates" 
                       class="flex items-center justify-center px-4 py-3 text-sm font-medium text-gray-600 bg-white border border-gray-300 rounded-md hover:bg-gray-50 transition-colors duration-200">
                        <i class="fas fa-users mr-2"></i>
                        Browse Candidates
                    </a>
                    
                    <a href="?page=employer-help" 
                       class="flex items-center justify-center px-4 py-3 text-sm font-medium text-gray-600 bg-white border border-gray-300 rounded-md hover:bg-gray-50 transition-colors duration-200">
                        <i class="fas fa-question-circle mr-2"></i>
                        Help & Support
                    </a>
                </div>
            </div>

            <!-- Contact Support -->
            <div class="mt-8 pt-6 border-t border-gray-200">
                <div class="text-center">
                    <p class="text-sm text-gray-600 mb-4">
                        Have questions about the verification process?
                    </p>
                    <a href="?page=contact-support" 
                       class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-700">
                        <i class="fas fa-headset mr-2"></i>
                        Contact Support
                        <i class="fas fa-external-link-alt ml-2 text-xs"></i>
                    </a>
                </div>
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
// Add some interactive elements
document.addEventListener('DOMContentLoaded', function() {
    // Animate the success message
    setTimeout(() => {
        const checkmarkIcon = document.querySelector('.fa-check');
        if (checkmarkIcon) {
            checkmarkIcon.classList.add('animate-checkmark');
        }
    }, 300);

    // Auto-refresh verification status every 30 seconds (optional)
    // setInterval(checkVerificationStatus, 30000);
});

function checkVerificationStatus() {
    // You can implement this to check if the profile has been verified
    // and update the UI accordingly
    fetch('?page=check-verification-status')
        .then(response => response.json())
        .then(data => {
            if (data.verified) {
                location.reload();
            }
        })
        .catch(error => console.log('Verification check failed:', error));
}
</script>