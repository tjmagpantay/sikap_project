<?php
include_once __DIR__ . '/../navbar-top.php';
include_once __DIR__ . '/../navbar.php';
?>

<!-- Accessibility Section -->
<section id="accessibility" class="px-4 py-20 bg-gradient-to-br from-gray-50 via-blue-50/30 to-white sm:px-6 md:px-16 lg:px-24">
    <div class="mx-auto max-w-7xl">
        <!-- Header Section -->
        <div class="mb-12 text-center">
            <h6 class="mb-2 font-semibold text-md text-secondary">Digital Inclusion</h6>
            <h1 class="mb-6 text-3xl font-bold leading-tight text-primary lg:text-4xl">
                Accessibility
            </h1>
            <p class="max-w-4xl mx-auto mb-8 text-sm leading-relaxed text-gray-600">
                PESO Rosario is committed to ensuring that Sikap, its official digital employment platform, is accessible and inclusive for all job seekers, employers, and stakeholders, including persons with disabilities. This reflects our mission to promote equal access to employment opportunities through technology that serves the entire community.
            </p>
            <div class="w-20 h-1.5 mx-auto bg-primary rounded-full"></div>
        </div>

        <!-- Quick Navigation -->
        <div class="p-6 mb-8 bg-white border border-gray-200 rounded-lg shadow-sm">
            <h3 class="mb-4 text-lg font-semibold text-center text-primary">Quick Navigation</h3>
            <nav class="flex flex-wrap justify-center gap-2">
                <a href="#section-1" class="px-4 py-2 text-sm text-gray-600 transition-colors bg-gray-100 rounded-lg hover:bg-primary hover:text-white">1. Accessibility Features</a>
                <a href="#section-2" class="px-4 py-2 text-sm text-gray-600 transition-colors bg-gray-100 rounded-lg hover:bg-primary hover:text-white">2. Compatibility</a>
                <a href="#section-3" class="px-4 py-2 text-sm text-gray-600 transition-colors bg-gray-100 rounded-lg hover:bg-primary hover:text-white">3. Known Limitations</a>
                <a href="#section-4" class="px-4 py-2 text-sm text-gray-600 transition-colors bg-gray-100 rounded-lg hover:bg-primary hover:text-white">4. Equal Access</a>
            </nav>
        </div>

        <!-- Main Content - Full Width -->
        <div class="space-y-6">
            <!-- Current Accessibility Features -->
            <div id="section-1" class="p-6 transition-all duration-300 bg-white border border-gray-200 rounded-lg shadow-sm hover:border-primary hover:shadow-md">
                <h2 class="flex items-center mb-4 text-xl font-bold text-primary">
                    <span class="flex items-center justify-center w-8 h-8 mr-3 text-sm font-bold text-white rounded-full bg-primary">1</span>
                    Current Accessibility Features
                </h2>

                <!-- Sub-sections in grid -->
                <div class="grid gap-6 md:grid-cols-3">
                    <!-- Navigation -->
                    <div class="p-4 border border-gray-200 rounded-lg bg-gray-50">
                        <h3 class="mb-3 text-base font-semibold text-gray-800">Navigation</h3>
                        <ul class="space-y-2 text-sm text-gray-600">
                            <li class="flex items-start"><span class="mr-2 text-primary">•</span>Consistent navigation across the platform</li>
                            <li class="flex items-start"><span class="mr-2 text-primary">•</span>Clear headings and logical page structure</li>
                            <li class="flex items-start"><span class="mr-2 text-primary">•</span>Visible focus indicators for keyboard navigation</li>
                            <li class="flex items-start"><span class="mr-2 text-primary">•</span>Skip navigation links for screen reader users</li>
                        </ul>
                    </div>

                    <!-- Visual Design -->
                    <div class="p-4 border border-yellow-200 rounded-lg bg-yellow-50">
                        <h3 class="mb-3 text-base font-semibold text-gray-800">Visual Design</h3>
                        <ul class="space-y-2 text-sm text-gray-600">
                            <li class="flex items-start"><span class="mr-2 text-secondary">•</span>High-contrast color schemes</li>
                            <li class="flex items-start"><span class="mr-2 text-secondary">•</span>Text that can be resized without loss of content or functionality</li>
                            <li class="flex items-start"><span class="mr-2 text-secondary">•</span>Alternative text for meaningful images</li>
                            <li class="flex items-start"><span class="mr-2 text-secondary">•</span>Clear and consistent button labels</li>
                        </ul>
                    </div>

                    <!-- Forms and Interactions -->
                    <div class="p-4 border border-blue-200 rounded-lg bg-blue-50">
                        <h3 class="mb-3 text-base font-semibold text-gray-800">Forms and Interactions</h3>
                        <ul class="space-y-2 text-sm text-gray-600">
                            <li class="flex items-start"><span class="mr-2 text-blue-600">•</span>Properly labeled form fields and descriptive error messages</li>
                            <li class="flex items-start"><span class="mr-2 text-blue-600">•</span>Extended session timeouts for users who need more time</li>
                            <li class="flex items-start"><span class="mr-2 text-blue-600">•</span>No auto-refreshing or time-sensitive content</li>
                            <li class="flex items-start"><span class="mr-2 text-blue-600">•</span>Error prevention measures on important forms and submissions</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Compatibility -->
            <div id="section-2" class="p-6 transition-all duration-300 bg-white border border-gray-200 rounded-lg shadow-sm hover:border-primary hover:shadow-md">
                <h2 class="flex items-center mb-4 text-xl font-bold text-primary">
                    <span class="flex items-center justify-center w-8 h-8 mr-3 text-sm font-bold text-white rounded-full bg-primary">2</span>
                    Compatibility
                </h2>
                <p class="mb-4 text-sm text-gray-600">Sikap is designed to be compatible with:</p>

                <div class="grid gap-4 md:grid-cols-3">
                    <div class="flex items-start p-4 border border-gray-200 rounded-lg bg-gray-50">
                        <span class="mr-3 text-gray-600">•</span>
                        <span class="text-sm text-gray-700">Current versions of major screen readers</span>
                    </div>
                    <div class="flex items-start p-4 border border-gray-200 rounded-lg bg-gray-50">
                        <span class="mr-3 text-gray-600">•</span>
                        <span class="text-sm text-gray-700">Keyboard-only navigation</span>
                    </div>
                    <div class="flex items-start p-4 border border-gray-200 rounded-lg bg-gray-50">
                        <span class="mr-3 text-gray-600">•</span>
                        <span class="text-sm text-gray-700">Mobile screen readers and accessibility tools</span>
                    </div>
                </div>
            </div>

            <!-- Known Limitations -->
            <div id="section-3" class="p-6 transition-all duration-300 bg-white border border-gray-200 rounded-lg shadow-sm hover:border-primary hover:shadow-md">
                <h2 class="flex items-center mb-4 text-xl font-bold text-primary">
                    <span class="flex items-center justify-center w-8 h-8 mr-3 text-sm font-bold text-white rounded-full bg-primary">3</span>
                    Known Limitations
                </h2>
                <p class="mb-4 text-sm text-gray-600">While Sikap strives for comprehensive accessibility, certain limitations remain:</p>

                <div class="grid gap-4 md:grid-cols-3">
                    <div class="flex items-start p-4 border border-gray-200 rounded-lg ">
                        <span class="mr-3 text-gray-600">•</span>
                        <span class="text-sm text-gray-700">Some older PDF documents may not be fully accessible</span>
                    </div>
                    <div class="flex items-start p-4 border border-gray-200 rounded-lg ">
                        <span class="mr-3 text-gray-600">•</span>
                        <span class="text-sm text-gray-700">Third-party content (e.g., employer-uploaded files) may not always follow accessibility standards</span>
                    </div>
                    <div class="flex items-start p-4 border border-gray-200 rounded-lg ">
                        <span class="mr-3 text-gray-600">•</span>
                        <span class="text-sm text-gray-700">Complex visual data in reports may have limited accessibility for screen readers</span>
                    </div>
                </div>
            </div>

            <!-- Equal Access to Employment -->
            <div id="section-4" class="p-6 transition-all duration-300 bg-white border border-gray-200 rounded-lg shadow-sm hover:border-primary hover:shadow-md">
                <h2 class="flex items-center mb-4 text-xl font-bold text-primary">
                    <span class="flex items-center justify-center w-8 h-8 mr-3 text-sm font-bold text-white rounded-full bg-primary">4</span>
                    Equal Access to Employment
                </h2>
                <div class="p-4 border border-gray-200 rounded-lg bg-gray-50">
                    <p class="text-sm text-gray-600">
                        Accessibility is central to Sikap's mission of inclusive digital employment services. By reducing digital barriers, Sikap ensures that all members of the community can participate fully in the labor market.
                    </p>
                </div>
            </div>

            <!-- Support Information -->
            <div class="grid gap-6 md:grid-cols-2">
                <!-- Contact Support -->
                <div class="p-6 transition-all duration-300 bg-white border border-gray-200 rounded-lg shadow-sm hover:border-primary hover:shadow-md">
                    <h3 class="mb-3 text-lg font-semibold text-primary">Need Accessibility Support?</h3>
                    <p class="mb-4 text-sm text-gray-600">If you encounter any accessibility barriers while using Sikap:</p>
                    <div class="space-y-2">
                        <div class="flex items-start p-3 border border-gray-200 rounded-lg bg-gray-50">
                            <span class="mr-3 text-primary">•</span>
                            <span class="text-sm text-gray-700">Contact PESO Rosario for immediate assistance</span>
                        </div>
                        <div class="flex items-start p-3 border border-gray-200 rounded-lg bg-gray-50">
                            <span class="mr-3 text-primary">•</span>
                            <span class="text-sm text-gray-700">Request alternative formats for information</span>
                        </div>
                        <div class="flex items-start p-3 border border-gray-200 rounded-lg bg-gray-50">
                            <span class="mr-3 text-primary">•</span>
                            <span class="text-sm text-gray-700">Schedule in-person assistance at our office</span>
                        </div>
                    </div>
                </div>

                <!-- Standards Compliance -->
                <div class="p-6 transition-all duration-300 bg-white border border-gray-200 rounded-lg shadow-sm hover:border-primary hover:shadow-md">
                    <h3 class="mb-3 text-lg font-semibold text-primary">Accessibility Standards</h3>
                    <div class="p-4 border border-gray-200 rounded-lg bg-gray-50">
                        <p class="mb-3 text-sm text-gray-600">
                            Sikap aims to comply with <span class="font-medium">WCAG 2.1 Level AA standards</span> and follows accessibility requirements outlined in Philippine disability laws.
                        </p>
                        <p class="text-sm text-gray-600">
                            We continuously review our platform and welcome feedback to improve accessibility for all users.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="p-6 border rounded-lg bg-gradient-to-r from-primary/10 to-secondary/10 border-primary/20">
                <h3 class="mb-3 text-lg font-semibold text-center text-primary">Contact for Accessibility Support</h3>
                <p class="mb-4 text-sm text-center text-gray-700">
                    For accessibility-related assistance or to report accessibility issues, please contact PESO Rosario.
                </p>
                <div class="text-center">
                    <a href="mailto:pesorosariobats@gmail.com" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white transition-colors rounded-lg bg-primary hover:bg-primary/90">
                        Contact PESO Rosario
                    </a>
                </div>
            </div>

            <!-- Commitment Statement -->
            <div class="p-8 text-center border rounded-lg bg-gradient-to-r from-primary/10 via-secondary/10 to-primary/10 border-primary/20">
                <h2 class="mb-4 text-2xl font-bold text-primary">Commitment to Digital Inclusion</h2>
                <p class="max-w-4xl mx-auto mb-6 text-sm leading-relaxed text-gray-700">
                    Sikap is dedicated to creating an inclusive digital environment where all community members, regardless of ability, can access employment opportunities and participate fully in the digital economy.
                </p>
                <div class="flex flex-wrap justify-center gap-3">
                    <span class="px-4 py-2 text-sm font-medium text-white rounded-full bg-primary">Inclusive Design</span>
                    <span class="px-4 py-2 text-sm font-medium text-white rounded-full bg-primary">WCAG Compliant</span>
                    <span class="px-4 py-2 text-sm font-medium text-white rounded-full bg-primary">Equal Access</span>
                    <span class="px-4 py-2 text-sm font-medium text-white rounded-full bg-primary">Community-Focused</span>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include_once __DIR__ . '/../footer.php'; ?>