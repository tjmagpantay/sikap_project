<?php
include_once __DIR__ . '/../navbar-top.php';
include_once __DIR__ . '/../navbar.php';
?>

<div class="min-h-screen px-4 py-16 bg-gray-50 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header Section -->
        <div class="mb-12 text-center">
            <h1 class="mb-5 text-3xl font-bold tracking-wide text-gray-900 sm:text-4xl">Employer Reports Guide</h1>
            <div class="w-20 h-1.5 mx-auto bg-blue-600 rounded-full"></div>
            <p class="mt-4 text-gray-600">
                Understanding and utilizing Sikap's reporting features
            </p>
        </div>

        <!-- Main Content -->
        <div class="p-8 bg-white rounded-lg shadow">
            <!-- Introduction -->
            <section class="mb-8">
                <p class="text-gray-700">
                    Sikap provides comprehensive reporting tools to help employers track their recruitment activities, analyze hiring trends, and make data-driven decisions. Learn how to access and utilize these reports effectively.
                </p>
            </section>

            <!-- Available Reports -->
            <section class="mb-8">
                <h2 class="mb-6 text-2xl font-bold text-gray-900">Available Reports</h2>

                <!-- Job Posting Analytics -->
                <div class="p-6 mb-6 border rounded-lg bg-gray-50">
                    <h3 class="mb-3 text-xl font-semibold text-gray-800">1. Job Posting Analytics</h3>
                    <ul class="pl-8 ml-4 space-y-2 text-gray-700 list-disc">
                        <li>View counts and engagement</li>
                        <li>Application rates</li>
                        <li>Posting performance metrics</li>
                        <li>Job listing status tracking</li>
                    </ul>
                </div>

                <!-- Candidate Reports -->
                <div class="p-6 mb-6 border rounded-lg bg-gray-50">
                    <h3 class="mb-3 text-xl font-semibold text-gray-800">2. Candidate Reports</h3>
                    <ul class="pl-8 ml-4 space-y-2 text-gray-700 list-disc">
                        <li>Applicant demographics</li>
                        <li>Qualification summaries</li>
                        <li>Application status tracking</li>
                        <li>Candidate pipeline analytics</li>
                    </ul>
                </div>

                <!-- Hiring Analytics -->
                <div class="p-6 mb-6 border rounded-lg bg-gray-50">
                    <h3 class="mb-3 text-xl font-semibold text-gray-800">3. Hiring Analytics</h3>
                    <ul class="pl-8 ml-4 space-y-2 text-gray-700 list-disc">
                        <li>Time-to-hire metrics</li>
                        <li>Hiring success rates</li>
                        <li>Position fill rates</li>
                        <li>Recruitment channel effectiveness</li>
                    </ul>
                </div>

                <!-- Compliance Reports -->
                <div class="p-6 mb-6 border rounded-lg bg-gray-50">
                    <h3 class="mb-3 text-xl font-semibold text-gray-800">4. Compliance Reports</h3>
                    <ul class="pl-8 ml-4 space-y-2 text-gray-700 list-disc">
                        <li>DOLE reporting requirements</li>
                        <li>Local employment statistics</li>
                        <li>Diversity metrics</li>
                        <li>Legal compliance tracking</li>
                    </ul>
                </div>
            </section>

            <!-- Accessing Reports -->
            <section class="mb-8">
                <h2 class="mb-4 text-2xl font-bold text-gray-900">How to Access Reports</h2>
                <div class="p-6 rounded-lg bg-blue-50">
                    <ol class="pl-8 ml-4 space-y-2 text-gray-700 list-decimal">
                        <li>Log in to your employer dashboard</li>
                        <li>Navigate to the "Reports" section</li>
                        <li>Select report type</li>
                        <li>Set date range and filters</li>
                        <li>Generate and download reports</li>
                    </ol>
                </div>
            </section>

            <!-- Report Features -->
            <section class="mb-8">
                <h2 class="mb-4 text-2xl font-bold text-gray-900">Report Features</h2>
                <div class="p-6 border rounded-lg">
                    <ul class="pl-8 ml-4 space-y-2 text-gray-700 list-disc">
                        <li>Customizable date ranges</li>
                        <li>Multiple export formats (PDF, Excel, CSV)</li>
                        <li>Visual data representations</li>
                        <li>Automated scheduling</li>
                        <li>Data filtering options</li>
                    </ul>
                </div>
            </section>

            <!-- Best Practices -->
            <section class="mb-8">
                <h2 class="mb-4 text-2xl font-bold text-gray-900">Reporting Best Practices</h2>
                <div class="p-6 border rounded-lg">
                    <ul class="pl-8 ml-4 space-y-2 text-gray-700 list-disc">
                        <li>Regular report monitoring</li>
                        <li>Data-driven decision making</li>
                        <li>Trend analysis</li>
                        <li>Performance benchmarking</li>
                        <li>Regular compliance checks</li>
                    </ul>
                </div>
            </section>

            <!-- Support Information -->
            <section class="p-6 mt-8 text-center rounded-lg bg-gray-50">
                <h2 class="mb-4 text-xl font-bold text-gray-900">Report Support</h2>
                <p class="mb-4 text-gray-700">
                    Need help with reports? Contact our support team:
                </p>
                <p class="text-gray-700">
                    Email: <a href="mailto:reports@sikap.com" class="text-blue-600 hover:underline">reports@sikap.com</a><br>
                    Phone: (319) 555-0115<br>
                    Hours: Monday - Friday, 8:00 AM - 5:00 PM
                </p>
            </section>
        </div>
    </div>
</div>

<?php include_once __DIR__ . '/../footer.php'; ?>
