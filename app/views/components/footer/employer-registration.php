<?php
include_once __DIR__ . '/../navbar-top.php';
include_once __DIR__ . '/../navbar.php';
?>

<div class="min-h-screen px-4 py-16 bg-gray-50 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header Section -->
        <div class="mb-12 text-center">
            <h1 class="mb-5 text-3xl font-bold tracking-wide text-gray-900 sm:text-4xl">Employer Registration Guide</h1>
            <div class="w-20 h-1.5 mx-auto bg-blue-600 rounded-full"></div>
            <p class="mt-4 text-gray-600">
                Complete guide to registering as an employer on Sikap
            </p>
        </div>

        <!-- Main Content -->
        <div class="p-8 bg-white rounded-lg shadow">
            <!-- Introduction -->
            <section class="mb-8">
                <p class="text-gray-700">
                    Welcome to Sikap's employer registration process. This guide will walk you through the steps needed to create and verify your employer account, allowing you to post jobs and connect with qualified candidates.
                </p>
            </section>

            <!-- Registration Steps -->
            <section class="mb-8">
                <h2 class="mb-6 text-2xl font-bold text-gray-900">Registration Process</h2>

                <!-- Step 1: Basic Registration -->
                <div class="p-6 mb-6 border rounded-lg bg-gray-50">
                    <h3 class="mb-3 text-xl font-semibold text-gray-800">Step 1: Create Account</h3>
                    <ul class="pl-8 ml-4 space-y-2 text-gray-700 list-disc">
                        <li>Visit the Sikap homepage</li>
                        <li>Click "Sign Up as Employer"</li>
                        <li>Provide basic information:
                            <ul class="pl-6 mt-2 ml-4 space-y-1 list-disc">
                                <li>Company name</li>
                                <li>Business email</li>
                                <li>Contact number</li>
                                <li>Create password</li>
                            </ul>
                        </li>
                        <li>Verify email address</li>
                    </ul>
                </div>

                <!-- Step 2: Company Profile -->
                <div class="p-6 mb-6 border rounded-lg bg-gray-50">
                    <h3 class="mb-3 text-xl font-semibold text-gray-800">Step 2: Complete Company Profile</h3>
                    <ul class="pl-8 ml-4 space-y-2 text-gray-700 list-disc">
                        <li>Company details:
                            <ul class="pl-6 mt-2 ml-4 space-y-1 list-disc">
                                <li>Business address</li>
                                <li>Industry type</li>
                                <li>Company size</li>
                                <li>Year established</li>
                            </ul>
                        </li>
                        <li>Upload company logo</li>
                        <li>Add company description</li>
                        <li>Include business registration number</li>
                    </ul>
                </div>

                <!-- Step 3: Document Submission -->
                <div class="p-6 mb-6 border rounded-lg bg-gray-50">
                    <h3 class="mb-3 text-xl font-semibold text-gray-800">Step 3: Submit Required Documents</h3>
                    <ul class="pl-8 ml-4 space-y-2 text-gray-700 list-disc">
                        <li>Business registration certificate</li>
                        <li>Tax identification documents</li>
                        <li>Mayor's permit</li>
                        <li>DOLE registration (if applicable)</li>
                        <li>Company ID of authorized representative</li>
                    </ul>
                </div>

                <!-- Step 4: Verification -->
                <div class="p-6 mb-6 border rounded-lg bg-gray-50">
                    <h3 class="mb-3 text-xl font-semibold text-gray-800">Step 4: Account Verification</h3>
                    <ul class="pl-8 ml-4 space-y-2 text-gray-700 list-disc">
                        <li>Document review by PESO staff</li>
                        <li>Background check completion</li>
                        <li>Verification confirmation</li>
                        <li>Account activation</li>
                    </ul>
                </div>
            </section>

            <!-- Account Types -->
            <section class="mb-8">
                <h2 class="mb-4 text-2xl font-bold text-gray-900">Account Types</h2>
                <div class="p-6 rounded-lg bg-blue-50">
                    <h3 class="mb-3 text-xl font-semibold text-gray-800">Available Options</h3>
                    <div class="space-y-4">
                        <div class="p-4 bg-white rounded-lg">
                            <h4 class="mb-2 font-semibold text-gray-800">Standard Account</h4>
                            <ul class="pl-8 ml-4 space-y-1 text-gray-700 list-disc">
                                <li>Basic job posting features</li>
                                <li>Candidate search access</li>
                                <li>Standard support</li>
                            </ul>
                        </div>
                        <div class="p-4 bg-white rounded-lg">
                            <h4 class="mb-2 font-semibold text-gray-800">Premium Account</h4>
                            <ul class="pl-8 ml-4 space-y-1 text-gray-700 list-disc">
                                <li>Featured job postings</li>
                                <li>Priority support</li>
                                <li>Advanced analytics</li>
                                <li>Bulk posting options</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Important Notes -->
            <section class="mb-8">
                <h2 class="mb-4 text-2xl font-bold text-gray-900">Important Notes</h2>
                <div class="p-6 border rounded-lg">
                    <ul class="pl-8 ml-4 space-y-2 text-gray-700 list-disc">
                        <li>Verification process takes 2-3 business days</li>
                        <li>All documents must be clear and valid</li>
                        <li>Keep contact information updated</li>
                        <li>Password must meet security requirements</li>
                    </ul>
                </div>
            </section>

            <!-- Contact Support -->
            <section class="p-6 mt-8 text-center rounded-lg bg-gray-50">
                <h2 class="mb-4 text-xl font-bold text-gray-900">Registration Support</h2>
                <p class="mb-4 text-gray-700">
                    Need help with registration? Contact our support team:
                </p>
                <p class="text-gray-700">
                    Email: <a href="mailto:support@sikap.com" class="text-blue-600 hover:underline">support@sikap.com</a><br>
                    Phone: (319) 555-0115<br>
                    Hours: Monday - Friday, 8:00 AM - 5:00 PM
                </p>
            </section>
        </div>
    </div>
</div>

<?php include_once __DIR__ . '/../footer.php'; ?>
