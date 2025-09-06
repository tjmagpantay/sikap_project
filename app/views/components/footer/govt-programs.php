<?php
include_once __DIR__ . '/../navbar-top.php';
include_once __DIR__ . '/../navbar.php';
?>

<div class="min-h-screen px-4 py-16 bg-gray-50 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header Section -->
        <div class="mb-12 text-center">
            <h1 class="mb-5 text-3xl font-bold tracking-wide text-gray-900 sm:text-4xl">Government Employment Programs</h1>
            <div class="w-20 h-1.5 mx-auto bg-blue-600 rounded-full"></div>
            <p class="mt-6 text-lg text-gray-600">
                Explore government initiatives and programs to support your employment journey
            </p>
        </div>

        <!-- Main Content -->
        <div class="p-8 bg-white rounded-lg shadow-lg">
            <!-- DOLE Programs -->
            <section class="mb-12">
                <h2 class="mb-6 text-2xl font-bold text-gray-900">DOLE Programs</h2>
                <div class="space-y-6">
                    <div class="p-6 border rounded-lg">
                        <h3 class="mb-3 text-xl font-semibold text-blue-600">TUPAD (Tulong Panghanapbuhay sa Ating Disadvantaged Workers)</h3>
                        <div class="space-y-4 text-gray-700">
                            <p>Emergency employment program for displaced, seasonal, or underemployed workers.</p>
                            <ul class="pl-6 space-y-2 list-disc">
                                <li>Short-term work opportunities</li>
                                <li>Minimum wage compensation</li>
                                <li>Work insurance coverage</li>
                                <li>Skills training opportunities</li>
                            </ul>
                        </div>
                    </div>

                    <div class="p-6 border rounded-lg">
                        <h3 class="mb-3 text-xl font-semibold text-blue-600">SPES (Special Program for Employment of Students)</h3>
                        <div class="space-y-4 text-gray-700">
                            <p>Employment assistance program for students and out-of-school youth.</p>
                            <ul class="pl-6 space-y-2 list-disc">
                                <li>Summer or Christmas break employment</li>
                                <li>40% salary from DOLE, 60% from employer</li>
                                <li>Work experience certificate</li>
                                <li>Career guidance and counseling</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>

            <!-- TESDA Programs -->
            <section class="mb-12">
                <h2 class="mb-6 text-2xl font-bold text-gray-900">TESDA Training Programs</h2>
                <div class="space-y-6">
                    <div class="p-6 border rounded-lg">
                        <h3 class="mb-3 text-xl font-semibold text-blue-600">Free Technical-Vocational Education and Training</h3>
                        <div class="space-y-4 text-gray-700">
                            <p>Skills development programs in various sectors:</p>
                            <ul class="pl-6 space-y-2 list-disc">
                                <li>Information Technology</li>
                                <li>Tourism and Hospitality</li>
                                <li>Construction</li>
                                <li>Healthcare</li>
                                <li>Agriculture</li>
                            </ul>
                        </div>
                    </div>

                    <div class="p-6 border rounded-lg">
                        <h3 class="mb-3 text-xl font-semibold text-blue-600">Online Programs</h3>
                        <div class="space-y-4 text-gray-700">
                            <p>Digital learning opportunities:</p>
                            <ul class="pl-6 space-y-2 list-disc">
                                <li>TESDA Online Program (TOP)</li>
                                <li>Virtual training sessions</li>
                                <li>Digital skills courses</li>
                                <li>Industry-specific certifications</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Local Government Programs -->
            <section class="mb-12">
                <h2 class="mb-6 text-2xl font-bold text-gray-900">Local Government Initiatives</h2>
                <div class="p-6 space-y-6 bg-gray-50 rounded-lg">
                    <div class="space-y-4">
                        <h3 class="text-xl font-semibold text-gray-900">PESO Rosario Programs</h3>
                        <ul class="pl-6 space-y-3 text-gray-700 list-disc">
                            <li>Regular job fairs and career events</li>
                            <li>Skills matching and career counseling</li>
                            <li>Local employment facilitation</li>
                            <li>Livelihood program referrals</li>
                            <li>Employment coaching sessions</li>
                        </ul>
                    </div>
                </div>
            </section>

            <!-- How to Apply -->
            <section class="mb-12">
                <h2 class="mb-6 text-2xl font-bold text-gray-900">How to Apply</h2>
                <div class="grid gap-6 md:grid-cols-2">
                    <div class="p-6 bg-blue-50 rounded-lg">
                        <h3 class="mb-4 text-lg font-semibold text-blue-800">Required Documents</h3>
                        <ul class="pl-6 space-y-2 text-blue-700 list-disc">
                            <li>Valid government ID</li>
                            <li>Proof of residence</li>
                            <li>Birth certificate</li>
                            <li>Latest resume/CV</li>
                            <li>School records (if applicable)</li>
                        </ul>
                    </div>
                    <div class="p-6 bg-green-50 rounded-lg">
                        <h3 class="mb-4 text-lg font-semibold text-green-800">Application Steps</h3>
                        <ol class="pl-6 space-y-2 text-green-700 list-decimal">
                            <li>Visit PESO Rosario office</li>
                            <li>Complete registration form</li>
                            <li>Submit required documents</li>
                            <li>Attend orientation</li>
                            <li>Wait for program placement</li>
                        </ol>
                    </div>
                </div>
            </section>

            <!-- Contact Information -->
            <section class="p-6 text-center bg-gray-50 rounded-lg">
                <h2 class="mb-4 text-xl font-bold text-gray-900">Need More Information?</h2>
                <p class="mb-4 text-gray-700">Contact PESO Rosario for guidance on government programs:</p>
                <div class="space-y-2 text-gray-700">
                    <p>Email: <a href="mailto:pesorosariobats@gmail.com" class="text-blue-600 hover:underline">pesorosariobats@gmail.com</a></p>
                    <p>Phone: (319) 555-0115</p>
                    <p>Visit: R6W4+7FH, Rosario - Ibaan Rd, Rosario, Batangas</p>
                </div>
            </section>
        </div>
    </div>
</div>

<?php include_once __DIR__ . '/../footer.php'; ?>
