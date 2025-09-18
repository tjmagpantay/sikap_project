<?php
include_once __DIR__ . '/components/employer_auth_check.php';
include_once __DIR__ . '/../components/navbar-top.php';
include_once __DIR__ . '/components/navbar-employer.php';
?>

<div class="min-h-screen">
    <div class="px-6 py-8">
        <div class="mx-auto max-w-7xl">
            <div class="mb-8 text-center">
                <h2 class="mt-6 text-3xl font-extrabold text-center text-gray-900">
                    Complete Your Profile
                </h2>
                <p class="mt-2 text-sm text-center text-gray-600">
                    Choose what you'd like to set up next
                </p>
            </div>

            <!-- Success Message -->
            <?php if (!empty($_GET['success'])): ?>
                <div class="max-w-2xl mx-auto mb-6">
                    <div class="p-4 border border-green-200 rounded-md bg-green-50">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-green-800">Profile updated successfully!</p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Profile Setup Options with 1/3 and 2/3 Layout -->
            <div class="flex flex-col gap-6 lg:flex-row">

                <!-- Right Side - 2/3 Width -->
                <div class="w-full lg:min-w-0 lg:flex-1">
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                        <!-- Personal Profile Setup -->
                        <div class="overflow-hidden bg-white border border-gray-200 shadow rounded-xl">
                            <div class="p-6">
                                <div class="flex items-center mb-4">
                                    <div class="flex-shrink-0">
                                        <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-primary/10">
                                            <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-lg font-semibold text-gray-900">Personal Profile</h3>
                                        <p class="text-sm text-gray-500">Your personal information and role</p>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <p class="mb-3 text-sm text-gray-600">Includes:</p>
                                    <ul class="space-y-1 text-sm text-gray-500">
                                        <li class="flex items-center">
                                            <svg class="w-3 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                            Basic contact information
                                        </li>
                                        <li class="flex items-center">
                                            <svg class="w-3 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                            Position and role
                                        </li>
                                        <li class="flex items-center">
                                            <svg class="w-3 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                            Profile picture
                                        </li>
                                        <li class="flex items-center">
                                            <svg class="w-3 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                            Authentication details
                                        </li>
                                    </ul>
                                </div>

                                <div class="mt-6">
                                    <?php if ($personalCompleted ?? false): ?>
                                        <div class="flex items-center justify-between p-3 border border-green-200 rounded-lg bg-green-50">
                                            <div class="flex items-center">
                                                <svg class="w-5 h-5 mr-2 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                </svg>
                                                <span class="text-sm font-medium text-green-800">Completed</span>
                                            </div>
                                            <a href="?page=employer-personal-profile" class="text-sm text-green-700 hover:text-green-800">Edit</a>
                                        </div>
                                    <?php else: ?>
                                        <a href="?page=employer-personal-profile"
                                            class="flex items-center justify-center w-full px-4 py-3 text-sm font-medium transition-colors border-2 rounded-lg text-primary border-primary hover:bg-primary hover:text-white">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                            </svg>
                                            Set Up Personal Profile
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Business Setup -->
                        <div class="overflow-hidden bg-white border border-gray-200 shadow rounded-xl">
                            <div class="p-6">
                                <div class="flex items-center mb-4">
                                    <div class="flex-shrink-0">
                                        <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-secondary/10">
                                            <svg class="w-6 h-6 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-lg font-semibold text-gray-900">Business Profile</h3>
                                        <p class="text-sm text-gray-500">Company details and verification</p>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <p class="mb-3 text-sm text-gray-600">Includes:</p>
                                    <ul class="space-y-1 text-sm text-gray-500">
                                        <li class="flex items-center">
                                            <svg class="w-3 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                            Company information
                                        </li>
                                        <li class="flex items-center">
                                            <svg class="w-3 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                            Business documents
                                        </li>
                                        <li class="flex items-center">
                                            <svg class="w-3 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                            Verification process
                                        </li>
                                        <li class="flex items-center">
                                            <svg class="w-3 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                            Social media links
                                        </li>
                                    </ul>
                                </div>

                                <div class="mt-6">
                                    <a href="?page=complete-employer-business&step=1"
                                        class="flex items-center justify-center w-full px-4 py-3 text-sm font-medium transition-colors border-2 rounded-lg text-secondary border-secondary hover:bg-secondary hover:text-white">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                        Set Up Business Profile
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Information Section -->
                    <div class="p-6 mt-6 bg-white border border-gray-200 shadow rounded-xl">
                        <div class="text-center">
                            <h3 class="text-lg font-semibold text-gray-900">Why Complete Your Profile?</h3>
                            <p class="mt-2 text-sm text-gray-600">A complete profile helps you attract the best candidates and builds trust with job seekers.</p>
                        </div>

                        <div class="grid grid-cols-1 gap-4 mt-6 md:grid-cols-3">
                            <div class="text-center">
                                <div class="flex items-center justify-center w-12 h-12 mx-auto mb-3 bg-blue-100 rounded-full">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                </div>
                                <h4 class="text-sm font-semibold text-gray-900">Faster Hiring</h4>
                                <p class="mt-1 text-xs text-gray-500">Complete profiles get 3x more applications</p>
                            </div>

                            <div class="text-center">
                                <div class="flex items-center justify-center w-12 h-12 mx-auto mb-3 bg-green-100 rounded-full">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </div>
                                <h4 class="text-sm font-semibold text-gray-900">Build Trust</h4>
                                <p class="mt-1 text-xs text-gray-500">Verified employers are preferred by candidates</p>
                            </div>

                            <div class="text-center">
                                <div class="flex items-center justify-center w-12 h-12 mx-auto mb-3 bg-purple-100 rounded-full">
                                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                                </div>
                                <h4 class="text-sm font-semibold text-gray-900">Better Matches</h4>
                                <p class="mt-1 text-xs text-gray-500">Detailed profiles attract relevant candidates</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>