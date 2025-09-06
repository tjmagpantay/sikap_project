<?php
include_once __DIR__ . '/../navbar-top.php';
include_once __DIR__ . '/../navbar.php';
?>

<div class="min-h-screen px-4 py-16 bg-gray-50 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header Section -->
        <div class="mb-12 text-center">
            <h1 class="mb-5 text-3xl font-bold tracking-wide text-gray-900 sm:text-4xl">Help Center</h1>
            <div class="w-20 h-1.5 mx-auto bg-blue-600 rounded-full"></div>
            <p class="mt-6 text-lg text-gray-600">
                Get assistance with using Sikap's features and services
            </p>
        </div>

        <!-- Main Content -->
        <div class="p-8 bg-white rounded-lg shadow-lg">
            <!-- Quick Start Guides -->
            <section class="mb-12">
                <h2 class="mb-6 text-2xl font-bold text-gray-900">Quick Start Guides</h2>
                
                <!-- Job Seekers Guide -->
                <div class="p-6 mb-6 border rounded-lg">
                    <h3 class="mb-4 text-xl font-semibold text-blue-600">For Job Seekers</h3>
                    <div class="space-y-4">
                        <div class="p-4 rounded-lg bg-gray-50">
                            <h4 class="mb-2 font-medium text-gray-800">Creating Your Account</h4>
                            <ol class="pl-8 ml-4 space-y-2 text-gray-700 list-decimal">
                                <li>Click "Sign Up" on the landing page</li>
                                <li>Choose "Job Seeker" registration</li>
                                <li>Fill in your personal information</li>
                                <li>Verify your email address</li>
                                <li>Complete your profile with education and work experience</li>
                            </ol>
                        </div>

                        <div class="p-4 rounded-lg bg-gray-50">
                            <h4 class="mb-2 font-medium text-gray-800">Applying for Jobs</h4>
                            <ol class="pl-8 ml-4 space-y-2 text-gray-700 list-decimal">
                                <li>Browse job listings or check recommendations</li>
                                <li>Review job requirements and qualifications</li>
                                <li>Click "Apply Now" on suitable positions</li>
                                <li>Upload required documents</li>
                                <li>Track application status in your dashboard</li>
                            </ol>
                        </div>

                        <div class="p-4 rounded-lg bg-gray-50">
                            <h4 class="mb-2 font-medium text-gray-800">Managing Your Profile</h4>
                            <ul class="pl-8 ml-4 space-y-2 text-gray-700 list-disc">
                                <li>Keep your contact information updated</li>
                                <li>Add new skills and certifications</li>
                                <li>Upload recent documents</li>
                                <li>Set job preferences for better matches</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Employers Guide -->
                <div class="p-6 mb-6 border rounded-lg">
                    <h3 class="mb-4 text-xl font-semibold text-green-600">For Employers</h3>
                    <div class="space-y-4">
                        <div class="p-4 rounded-lg bg-gray-50">
                            <h4 class="mb-2 font-medium text-gray-800">Account Setup</h4>
                            <ol class="pl-8 ml-4 space-y-2 text-gray-700 list-decimal">
                                <li>Register as an employer</li>
                                <li>Submit required accreditation documents</li>
                                <li>Wait for PESO verification</li>
                                <li>Complete company profile</li>
                            </ol>
                        </div>

                        <div class="p-4 rounded-lg bg-gray-50">
                            <h4 class="mb-2 font-medium text-gray-800">Posting Jobs</h4>
                            <ol class="pl-8 ml-4 space-y-2 text-gray-700 list-decimal">
                                <li>Click "Post New Job" in your dashboard</li>
                                <li>Fill in job details and requirements</li>
                                <li>Set application deadline</li>
                                <li>Submit for PESO review</li>
                                <li>Track posting status</li>
                            </ol>
                        </div>

                        <div class="p-4 rounded-lg bg-gray-50">
                            <h4 class="mb-2 font-medium text-gray-800">Managing Applications</h4>
                            <ul class="pl-8 ml-4 space-y-2 text-gray-700 list-disc">
                                <li>Review applications within 7 days</li>
                                <li>Shortlist qualified candidates</li>
                                <li>Schedule interviews</li>
                                <li>Update application status</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Common Issues -->
            <section class="p-8 bg-white rounded-lg shadow">
                <h2 class="mb-6 text-2xl font-bold text-gray-900">Common Issues</h2>
                
                <div class="grid gap-6 md:grid-cols-2">
                    <div class="p-4 border rounded-lg">
                        <h3 class="mb-3 text-lg font-semibold text-gray-800">Account Access</h3>
                        <ul class="pl-8 ml-4 space-y-2 text-gray-700 list-disc">
                            <li>Reset password through "Forgot Password"</li>
                            <li>Update email verification</li>
                            <li>Check account status</li>
                            <li>Resolve login issues</li>
                        </ul>
                    </div>

                    <div class="p-4 border rounded-lg">
                        <h3 class="mb-3 text-lg font-semibold text-gray-800">Document Upload</h3>
                        <ul class="pl-8 ml-4 space-y-2 text-gray-700 list-disc">
                            <li>Check file size limits</li>
                            <li>Verify supported formats</li>
                            <li>Scan for clear copies</li>
                            <li>Ensure proper orientation</li>
                        </ul>
                    </div>

                    <div class="p-4 border rounded-lg">
                        <h3 class="mb-3 text-lg font-semibold text-gray-800">Application Process</h3>
                        <ul class="pl-8 ml-4 space-y-2 text-gray-700 list-disc">
                            <li>Track submission status</li>
                            <li>Check requirements completion</li>
                            <li>View employer responses</li>
                            <li>Manage multiple applications</li>
                        </ul>
                    </div>

                    <div class="p-4 border rounded-lg">
                        <h3 class="mb-3 text-lg font-semibold text-gray-800">Technical Issues</h3>
                        <ul class="pl-8 ml-4 space-y-2 text-gray-700 list-disc">
                            <li>Browser compatibility</li>
                            <li>Mobile responsiveness</li>
                            <li>Loading time optimization</li>
                            <li>Error message resolution</li>
                        </ul>
                    </div>
                </div>
            </section>

            <!-- System Features -->
            <section class="p-8 bg-white rounded-lg shadow">
                <h2 class="mb-6 text-2xl font-bold text-gray-900">Key Features</h2>
                
                <div class="space-y-6">
                    <div class="p-4 border rounded-lg">
                        <h3 class="mb-3 text-lg font-semibold text-gray-800">Job Matching</h3>
                        <p class="text-gray-700">
                            Sikap uses machine learning to match job seekers with relevant opportunities based on skills, experience, and preferences. Keep your profile updated for better matches.
                        </p>
                    </div>

                    <div class="p-4 border rounded-lg">
                        <h3 class="mb-3 text-lg font-semibold text-gray-800">Application Tracking</h3>
                        <p class="text-gray-700">
                            Monitor all your applications in real-time. Get notifications for views, shortlists, and interview invitations. Applications expire after 7 days if not reviewed.
                        </p>
                    </div>

                    <div class="p-4 border rounded-lg">
                        <h3 class="mb-3 text-lg font-semibold text-gray-800">Document Management</h3>
                        <p class="text-gray-700">
                            Securely store and manage your documents. Upload requirements once and use them for multiple applications. Update documents as needed.
                        </p>
                    </div>

                    <div class="p-4 border rounded-lg">
                        <h3 class="mb-3 text-lg font-semibold text-gray-800">Chat Support</h3>
                        <p class="text-gray-700">
                            Use our built-in chatbot for immediate assistance with common questions. Connect with PESO staff for more complex inquiries.
                        </p>
                    </div>
                </div>
            </section>

            <!-- Contact Support -->
            <section class="p-8 bg-white rounded-lg shadow">
                <h2 class="mb-6 text-2xl font-bold text-gray-900">Need More Help?</h2>
                
                <div class="grid gap-6 md:grid-cols-2">
                    <div class="p-6 text-center border rounded-lg">
                        <h3 class="mb-4 text-lg font-semibold text-gray-800">Email Support</h3>
                        <p class="mb-2 text-gray-700">Send us a detailed message</p>
                        <a href="mailto:pesorosariobats@gmail.com" class="text-blue-600 hover:underline">pesorosariobats@gmail.com</a>
                    </div>

                    <div class="p-6 text-center border rounded-lg">
                        <h3 class="mb-4 text-lg font-semibold text-gray-800">Phone Support</h3>
                        <p class="mb-2 text-gray-700">Call us during office hours</p>
                        <p class="font-medium text-gray-900">(319) 555-0115</p>
                    </div>

                    <div class="p-6 text-center border rounded-lg">
                        <h3 class="mb-4 text-lg font-semibold text-gray-800">Visit PESO Office</h3>
                        <p class="mb-2 text-gray-700">For in-person assistance</p>
                        <p class="text-gray-900">R6W4+7FH, Rosario - Ibaan Rd,<br>Rosario, Batangas</p>
                    </div>

                    <div class="p-6 text-center border rounded-lg">
                        <h3 class="mb-4 text-lg font-semibold text-gray-800">Office Hours</h3>
                        <p class="mb-2 text-gray-700">Monday to Friday</p>
                        <p class="text-gray-900">8:00 AM - 5:00 PM</p>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<?php include_once __DIR__ . '/../footer.php'; ?>
