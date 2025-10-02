<?php
include_once __DIR__ . '/../navbar-top.php';
include_once __DIR__ . '/../navbar.php';
?>

<!-- Help Center Section -->
<section id="help-center" class="px-4 py-20 bg-gradient-to-br from-gray-50 via-blue-50/30 to-white sm:px-6 md:px-16 lg:px-24">
    <div class="mx-auto max-w-7xl">
        <!-- Header Section -->
        <div class="mb-12 text-center">
            <h6 class="mb-2 font-semibold text-md text-secondary">Support Center</h6>
            <h1 class="mb-6 text-3xl font-bold leading-tight text-primary lg:text-4xl">
                Help Center
            </h1>
            <p class="max-w-4xl mx-auto mb-8 text-sm leading-relaxed text-gray-600">
                Guides and support to help you use the Sikap platform
            </p>
            <div class="w-20 h-1.5 mx-auto bg-primary rounded-full"></div>
        </div>

        <!-- Quick Navigation -->
        <div class="p-6 mb-8 bg-white border border-gray-200 rounded-lg shadow-sm">
            <h3 class="mb-4 text-lg font-semibold text-center text-primary">Quick Navigation</h3>
            <nav class="flex flex-wrap justify-center gap-2">
                <a href="#section-1" class="px-4 py-2 text-sm text-gray-600 transition-colors bg-gray-100 rounded-lg hover:bg-primary hover:text-white">1. For Job Seekers</a>
                <a href="#section-2" class="px-4 py-2 text-sm text-gray-600 transition-colors bg-gray-100 rounded-lg hover:bg-primary hover:text-white">2. For Employers</a>
                <a href="#section-3" class="px-4 py-2 text-sm text-gray-600 transition-colors bg-gray-100 rounded-lg hover:bg-primary hover:text-white">3. Common Questions</a>
                <a href="#section-4" class="px-4 py-2 text-sm text-gray-600 transition-colors bg-gray-100 rounded-lg hover:bg-primary hover:text-white">4. Support</a>
            </nav>
        </div>

        <!-- Main Content - Full Width -->
        <div class="space-y-6">
            <!-- For Job Seekers -->
            <div id="section-1" class="p-6 transition-all duration-300 bg-white border border-gray-200 rounded-lg shadow-sm hover:border-primary hover:shadow-md">
                <h2 class="flex items-center mb-4 text-xl font-bold text-primary">
                    <span class="flex items-center justify-center w-8 h-8 mr-3 text-sm font-bold text-white rounded-full bg-primary">1</span>
                    For Job Seekers
                </h2>

                <!-- How to Sign In and Apply -->
                <div class="p-4 border border-gray-200 rounded-lg">
                    <h3 class="mb-3 text-base font-semibold text-gray-800">How to Sign In and Apply for Jobs</h3>

                    <div class="mb-4">
                        <h4 class="mb-2 text-sm font-semibold text-primary">Getting Started</h4>
                        <ol class="ml-6 space-y-2 text-sm text-gray-700 list-decimal">
                            <li>Click <strong>Sign In</strong> on the navigation bar</li>
                            <li>If you don't have an account, choose <strong>Sign Up</strong> or <strong>Sign in with Google</strong></li>
                            <li>Complete your profile details</li>
                            <li>Upload your resume or CV – the system will automatically parse and fill in details like name, contact info, education, and experience</li>
                            <li>Review and complete your profile</li>
                        </ol>
                    </div>

                    <div class="mb-4">
                        <h4 class="mb-2 text-sm font-semibold text-primary">Once your profile is set up, you can:</h4>
                        <ul class="ml-6 space-y-2 text-sm text-gray-700 list-disc">
                            <li>Browse job listings</li>
                            <li>Get personalized job recommendations</li>
                            <li>Apply directly to jobs that match your qualifications</li>
                        </ul>
                    </div>
                </div>

                <div class="p-4 mt-4 border-l-4 rounded-lg bg-primary border-primary">
                    <p class="text-sm font-medium text-white">💡 Tip: A complete profile increases your chances of being matched with the right opportunities.</p>
                </div>
            </div>

            <!-- For Employers -->
            <div id="section-2" class="p-6 transition-all duration-300 bg-white border border-gray-200 rounded-lg shadow-sm hover:border-primary hover:shadow-md">
                <h2 class="flex items-center mb-4 text-xl font-bold text-primary">
                    <span class="flex items-center justify-center w-8 h-8 mr-3 text-sm font-bold text-white rounded-full bg-primary">2</span>
                    For Employers
                </h2>

                <!-- How to Sign In and Post Jobs -->
                <div class="p-4 border border-gray-200 rounded-lg">
                    <h3 class="mb-3 text-base font-semibold text-gray-800">How to Sign In and Post Jobs</h3>

                    <div class="mb-4">
                        <h4 class="mb-2 text-sm font-semibold text-secondary">Getting Started</h4>
                        <ol class="ml-6 space-y-2 text-sm text-gray-700 list-decimal">
                            <li>Click <strong>Post a Job</strong> on the navigation bar</li>
                            <li>If you don't have an account, select <strong>Sign Up</strong> or <strong>Continue with Google</strong></li>
                            <li>Complete your profile and company details</li>
                            <li>Upload all required accreditation documents</li>
                            <li>Wait for PESO Rosario admin verification and accreditation</li>
                        </ol>
                    </div>

                    <div class="mb-4">
                        <h4 class="mb-2 text-sm font-semibold text-secondary">Once accredited, you can:</h4>
                        <ul class="ml-6 space-y-2 text-sm text-gray-700 list-disc">
                            <li>Post job vacancies</li>
                            <li>Manage applications</li>
                            <li>Connect with qualified candidates</li>
                        </ul>
                    </div>
                </div>

                <div class="p-4 mt-4 border-l-4 border-yellow-400 rounded-lg bg-yellow-50">
                    <p class="text-sm font-medium text-yellow-800">🔒 Note: Only accredited employers can post jobs to ensure authenticity and protect job seekers.</p>
                </div>
            </div>

            <!-- Common Questions -->
            <div id="section-3" class="p-6 transition-all duration-300 bg-white border border-gray-200 rounded-lg shadow-sm hover:border-primary hover:shadow-md">
                <h2 class="flex items-center mb-4 text-xl font-bold text-primary">
                    <span class="flex items-center justify-center w-8 h-8 mr-3 text-sm font-bold text-white rounded-full bg-primary">3</span>
                    Common Questions
                </h2>

                <div class="grid gap-4 md:grid-cols-2">
                    <!-- Account Issues -->
                    <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm">
                        <h3 class="mb-3 text-base font-semibold text-purple-800">Account Issues</h3>
                        <ul class="space-y-2 text-sm text-gray-700">
                            <li class="flex items-start"><span class="mr-2 text-purple-600">•</span>Use "Forgot Password" for password reset</li>
                            <li class="flex items-start"><span class="mr-2 text-purple-600">•</span>Check spam folder for verification emails</li>
                            <li class="flex items-start"><span class="mr-2 text-purple-600">•</span>Clear browser cache and cookies</li>
                            <li class="flex items-start"><span class="mr-2 text-purple-600">•</span>Try different browsers or devices</li>
                        </ul>
                    </div>

                    <!-- Document Upload -->
                    <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm">
                        <h3 class="mb-3 text-base font-semibold text-orange-800">Document Upload</h3>
                        <ul class="space-y-2 text-sm text-gray-700">
                            <li class="flex items-start"><span class="mr-2 text-orange-600">•</span>Files must be under 5MB</li>
                            <li class="flex items-start"><span class="mr-2 text-orange-600">•</span>Use PDF, JPG, PNG, or DOC formats</li>
                            <li class="flex items-start"><span class="mr-2 text-orange-600">•</span>Ensure clear image quality</li>
                            <li class="flex items-start"><span class="mr-2 text-orange-600">•</span>Compress large files if needed</li>
                        </ul>
                    </div>

                    <!-- Application Process -->
                    <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm">
                        <h3 class="mb-3 text-base font-semibold text-blue-800">Application Process</h3>
                        <ul class="space-y-2 text-sm text-gray-700">
                            <li class="flex items-start"><span class="mr-2 text-blue-600">•</span>Complete all required fields</li>
                            <li class="flex items-start"><span class="mr-2 text-blue-600">•</span>Check submission confirmation</li>
                            <li class="flex items-start"><span class="mr-2 text-blue-600">•</span>Monitor 7-day application window</li>
                            <li class="flex items-start"><span class="mr-2 text-blue-600">•</span>Track status in dashboard</li>
                        </ul>
                    </div>

                    <!-- Technical Issues -->
                    <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm">
                        <h3 class="mb-3 text-base font-semibold text-red-800">Technical Issues</h3>
                        <ul class="space-y-2 text-sm text-gray-700">
                            <li class="flex items-start"><span class="mr-2 text-red-600">•</span>Check internet connection</li>
                            <li class="flex items-start"><span class="mr-2 text-red-600">•</span>Update browser to latest version</li>
                            <li class="flex items-start"><span class="mr-2 text-red-600">•</span>Disable browser extensions</li>
                            <li class="flex items-start"><span class="mr-2 text-red-600">•</span>Contact support if issues persist</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Support Options -->
            <div id="section-4" class="p-6 transition-all duration-300 bg-white border border-gray-200 rounded-lg shadow-sm hover:border-primary hover:shadow-md">
                <h2 class="flex items-center mb-4 text-xl font-bold text-primary">
                    <span class="flex items-center justify-center w-8 h-8 mr-3 text-sm font-bold text-white rounded-full bg-primary">4</span>
                    Get Support
                </h2>

                <div class="grid gap-4 md:grid-cols-3">
                    <div class="p-4 text-center bg-white border border-gray-200 rounded-lg shadow-sm">
                        <h3 class="mb-2 text-base font-semibold text-blue-800">Email Support</h3>
                        <p class="mb-2 text-sm text-blue-700">Detailed assistance for complex issues</p>
                        <a href="mailto:pesorosariobats@gmail.com" class="text-sm text-blue-600 hover:underline">pesorosariobats@gmail.com</a>
                    </div>

                    <div class="p-4 text-center bg-white border border-gray-200 rounded-lg shadow-sm">
                        <h3 class="mb-2 text-base font-semibold text-green-800">Phone Support</h3>
                        <p class="mb-2 text-sm text-green-700">Immediate assistance</p>
                        <p class="text-sm font-medium text-green-900">(319) 555-0115</p>
                    </div>

                    <div class="p-4 text-center bg-white border border-gray-200 rounded-lg shadow-sm">
                        <h3 class="mb-2 text-base font-semibold text-purple-800">Office Visit</h3>
                        <p class="mb-2 text-sm text-purple-700">Face-to-face support</p>
                        <p class="text-sm text-purple-900">PESO Rosario Office<br>Municipal Hall</p>
                    </div>
                </div>

                <div class="p-4 mt-4 text-center bg-white border border-gray-200 rounded-lg">
                    <h3 class="mb-2 text-base font-semibold text-gray-800">Office Hours</h3>
                    <p class="text-sm text-gray-700">Monday - Friday: 8:00 AM - 5:00 PM</p>
                    <p class="text-sm text-gray-600">Closed on weekends and holidays</p>
                </div>
            </div>

            <!-- Footer Statement -->
            <div class="p-8 text-center border rounded-lg bg-gradient-to-r from-primary/10 via-secondary/10 to-primary/10 border-primary/20">
                <h2 class="mb-4 text-2xl font-bold text-primary">We're Here to Help You Succeed</h2>
                <p class="max-w-4xl mx-auto mb-6 text-sm leading-relaxed text-gray-700">
                    Whether you're searching for your dream job or looking to hire the perfect candidate, our comprehensive help center and dedicated support team are here to guide you every step of the way.
                </p>
                <div class="flex flex-wrap justify-center gap-3">
                    <span class="px-4 py-2 text-sm font-medium text-white rounded-full bg-primary">Step-by-Step Guides</span>
                    <span class="px-4 py-2 text-sm font-medium text-white rounded-full bg-primary">Expert Support</span>
                    <span class="px-4 py-2 text-sm font-medium text-white rounded-full bg-primary">Quick Solutions</span>
                    <span class="px-4 py-2 text-sm font-medium text-white rounded-full bg-primary">Always Available</span>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include_once __DIR__ . '/../footer.php'; ?>