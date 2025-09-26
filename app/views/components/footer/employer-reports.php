<?php
include_once __DIR__ . '/../navbar-top.php';
include_once __DIR__ . '/../navbar.php';
?>

<section class="px-4 py-16 bg-gradient-to-br from-gray-50 via-blue-50/30 to-white sm:px-6 md:px-16 lg:px-24">
    <div class="mx-auto max-w-7xl">
        <!-- Header Section -->
        <div class="mb-12 text-center" data-aos="fade-up">
            <h1 class="mb-4 text-3xl font-bold text-grayMain sm:text-2xl lg:text-3xl">
                Employer Reports Guide
            </h1>
            <p class="max-w-3xl mx-auto mb-6 text-sm leading-relaxed text-gray-600">
                Comprehensive reporting tools to track recruitment activities, analyze hiring trends, and make data-driven decisions
            </p>
            <div class="w-20 h-1.5 mx-auto bg-primary rounded-full"></div>
        </div>

        <!-- Main Content -->
        <div class="p-6 bg-white rounded-lg shadow-lg sm:p-8" data-aos="fade-up" data-aos-delay="100">
            <!-- Introduction -->
            <div class="relative mb-8 transition-all duration-300 bg-white border border-gray-200 rounded-lg group hover:border-primary hover:shadow-md">
                <div class="p-6">
                    <h2 class="mb-4 text-lg font-bold text-grayMain sm:text-xl">Sikap Reporting Dashboard</h2>
                    <p class="text-sm text-grayMain">
                        Sikap's advanced reporting system provides employers with powerful analytics and insights to optimize their recruitment strategies. Access real-time data, generate comprehensive reports, and track your hiring performance with our user-friendly dashboard. Make informed decisions that drive successful recruitment outcomes and improve your talent acquisition process.
                    </p>
                </div>
            </div>

            <!-- Available Reports -->
            <div class="relative mb-8 transition-all duration-300 bg-white border border-gray-200 rounded-lg group hover:border-primary hover:shadow-md">
                <div class="p-6">
                    <h2 class="mb-4 text-lg font-bold text-grayMain sm:text-xl">Available Report Types</h2>
                    
                    <!-- Job Posting Analytics -->
                    <div class="mb-6">
                        <h3 class="mb-3 font-semibold text-blue-600 text-md">1. Job Posting Analytics</h3>
                        <p class="mb-3 text-sm text-grayMain">Comprehensive insights into your job posting performance:</p>
                        <ul class="ml-6 space-y-2 text-sm list-disc text-grayMain">
                            <li>View counts and user engagement metrics</li>
                            <li>Application conversion rates and statistics</li>
                            <li>Job posting performance comparisons</li>
                            <li>Real-time job listing status tracking</li>
                            <li>Search ranking and visibility analytics</li>
                        </ul>
                    </div>

                    <!-- Candidate Reports -->
                    <div class="mb-6">
                        <h3 class="mb-3 font-semibold text-blue-600 text-md">2. Candidate Analytics</h3>
                        <p class="mb-3 text-sm text-grayMain">Detailed applicant data and demographic insights:</p>
                        <ul class="ml-6 space-y-2 text-sm list-disc text-grayMain">
                            <li>Comprehensive applicant demographics and profiles</li>
                            <li>Skills and qualification assessment summaries</li>
                            <li>Application status and pipeline tracking</li>
                            <li>Candidate source and channel analysis</li>
                            <li>Resume quality and completeness metrics</li>
                        </ul>
                    </div>

                    <!-- Hiring Analytics -->
                    <div class="mb-6">
                        <h3 class="mb-3 font-semibold text-blue-600 text-md">3. Recruitment Performance</h3>
                        <p class="mb-3 text-sm text-grayMain">Key performance indicators for hiring success:</p>
                        <ul class="ml-6 space-y-2 text-sm list-disc text-grayMain">
                            <li>Time-to-hire metrics and benchmarking</li>
                            <li>Hiring success rates and conversion funnels</li>
                            <li>Position fill rates and completion statistics</li>
                            <li>Recruitment channel effectiveness analysis</li>
                            <li>Cost-per-hire and ROI calculations</li>
                        </ul>
                    </div>

                    <!-- Compliance Reports -->
                    <div class="mb-6">
                        <h3 class="mb-3 font-semibold text-blue-600 text-md">4. Compliance and Legal Reports</h3>
                        <p class="mb-3 text-sm text-grayMain">Regulatory compliance and legal requirement tracking:</p>
                        <ul class="ml-6 space-y-2 text-sm list-disc text-grayMain">
                            <li>DOLE reporting requirements and submissions</li>
                            <li>Local employment statistics and trends</li>
                            <li>Diversity and inclusion metrics</li>
                            <li>Equal opportunity compliance tracking</li>
                            <li>Government mandate adherence reports</li>
                        </ul>
                    </div>
                    
                    <div class="p-4 mt-4 rounded-lg text-primary bg-gray-50">
                        <p class="text-sm font-medium">📊 Analytics Tip: Regular report review helps identify recruitment bottlenecks and optimization opportunities.</p>
                    </div>
                </div>
            </div>

            <!-- Report Features -->
            <div class="relative mb-8 transition-all duration-300 bg-white border border-gray-200 rounded-lg group hover:border-primary hover:shadow-md">
                <div class="p-6">
                    <h2 class="mb-4 text-lg font-bold text-grayMain sm:text-xl">Advanced Report Features</h2>
                    
                    <div class="grid gap-6 md:grid-cols-2">
                        <div class="p-4 rounded-lg bg-green-50">
                            <h3 class="mb-3 font-semibold text-green-800 text-md">Customization Options</h3>
                            <ul class="ml-6 space-y-2 text-sm text-green-700 list-disc">
                                <li>Flexible date range selection</li>
                                <li>Custom filter and parameter settings</li>
                                <li>Personalized dashboard layouts</li>
                                <li>Saved report templates</li>
                                <li>Department and team-specific views</li>
                            </ul>
                        </div>
                        
                        <div class="p-4 rounded-lg bg-purple-50">
                            <h3 class="mb-3 font-semibold text-purple-800 text-md">Export and Sharing</h3>
                            <ul class="ml-6 space-y-2 text-sm text-purple-700 list-disc">
                                <li>Multiple export formats (PDF, Excel, CSV)</li>
                                <li>Automated report scheduling</li>
                                <li>Team sharing and collaboration</li>
                                <li>Email distribution lists</li>
                                <li>Visual data representations and charts</li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="p-4 mt-4 text-yellow-700 rounded-lg bg-yellow-50">
                        <p class="text-sm font-medium">🔄 Automation: Set up scheduled reports to receive regular updates without manual generation.</p>
                    </div>
                </div>
            </div>

            <!-- How to Access Reports -->
            <div class="relative mb-8 transition-all duration-300 bg-white border border-gray-200 rounded-lg group hover:border-primary hover:shadow-md">
                <div class="p-6">
                    <h2 class="mb-4 text-lg font-bold text-grayMain sm:text-xl">Accessing Your Reports</h2>
                    
                    <div class="mb-6">
                        <h3 class="mb-3 font-semibold text-gray-800 text-md">Step-by-Step Process</h3>
                        <ol class="ml-6 space-y-3 text-sm list-decimal text-grayMain">
                            <li>
                                <span class="font-semibold">Dashboard Login</span>
                                <p class="mt-1 text-gray-600">Access your employer dashboard using your credentials</p>
                            </li>
                            <li>
                                <span class="font-semibold">Navigate to Reports</span>
                                <p class="mt-1 text-gray-600">Click on the "Reports & Analytics" section in the main menu</p>
                            </li>
                            <li>
                                <span class="font-semibold">Select Report Type</span>
                                <p class="mt-1 text-gray-600">Choose from available report categories and templates</p>
                            </li>
                            <li>
                                <span class="font-semibold">Configure Parameters</span>
                                <p class="mt-1 text-gray-600">Set date ranges, filters, and customization options</p>
                            </li>
                            <li>
                                <span class="font-semibold">Generate and Export</span>
                                <p class="mt-1 text-gray-600">Create report and download in your preferred format</p>
                            </li>
                        </ol>
                    </div>
                    
                    <div class="p-4 mt-4 text-red-700 rounded-lg bg-red-50">
                        <p class="text-sm font-medium">🔐 Access Note: Report availability depends on your subscription plan and user permissions.</p>
                    </div>
                </div>
            </div>

            <!-- Report Categories -->
            <div class="relative mb-8 transition-all duration-300 bg-white border border-gray-200 rounded-lg group hover:border-primary hover:shadow-md">
                <div class="p-6">
                    <h2 class="mb-4 text-lg font-bold text-grayMain sm:text-xl">Report Categories</h2>
                    
                    <div class="grid gap-6 md:grid-cols-3">
                        <div class="p-4 text-center rounded-lg bg-blue-50">
                            <h3 class="mb-2 font-semibold text-blue-800 text-md">Performance Reports</h3>
                            <p class="text-sm text-blue-700">Hiring metrics<br>Success rates<br>Time-to-fill data</p>
                        </div>
                        
                        <div class="p-4 text-center rounded-lg bg-green-50">
                            <h3 class="mb-2 font-semibold text-green-800 text-md">Operational Reports</h3>
                            <p class="text-sm text-green-700">Daily activities<br>Application tracking<br>Pipeline status</p>
                        </div>
                        
                        <div class="p-4 text-center rounded-lg bg-purple-50">
                            <h3 class="mb-2 font-semibold text-purple-800 text-md">Compliance Reports</h3>
                            <p class="text-sm text-purple-700">Legal requirements<br>Government submissions<br>Audit trails</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Best Practices -->
            <div class="relative mb-8 transition-all duration-300 bg-white border border-gray-200 rounded-lg group hover:border-primary hover:shadow-md">
                <div class="p-6">
                    <h2 class="mb-4 text-lg font-bold text-grayMain sm:text-xl">Reporting Best Practices</h2>
                    
                    <!-- Data Analysis -->
                    <div class="mb-6">
                        <h3 class="mb-3 font-semibold text-blue-600 text-md">1. Strategic Data Analysis</h3>
                        <ul class="ml-6 space-y-2 text-sm list-disc text-grayMain">
                            <li>Establish regular reporting schedules and reviews</li>
                            <li>Focus on key performance indicators (KPIs)</li>
                            <li>Compare current metrics with historical data</li>
                            <li>Identify trends and patterns in hiring data</li>
                        </ul>
                    </div>

                    <!-- Decision Making -->
                    <div class="mb-6">
                        <h3 class="mb-3 font-semibold text-blue-600 text-md">2. Data-Driven Decision Making</h3>
                        <ul class="ml-6 space-y-2 text-sm list-disc text-grayMain">
                            <li>Use insights to optimize recruitment strategies</li>
                            <li>Adjust job posting approaches based on performance</li>
                            <li>Improve candidate sourcing and screening processes</li>
                            <li>Set realistic hiring goals and benchmarks</li>
                        </ul>
                    </div>

                    <!-- Continuous Improvement -->
                    <div class="mb-6">
                        <h3 class="mb-3 font-semibold text-blue-600 text-md">3. Continuous Improvement</h3>
                        <ul class="ml-6 space-y-2 text-sm list-disc text-grayMain">
                            <li>Regular performance benchmarking against industry standards</li>
                            <li>Monthly compliance checks and legal requirement reviews</li>
                            <li>Team training on report interpretation and usage</li>
                            <li>Feedback collection from hiring managers and recruiters</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Support and Resources -->
            <div class="p-6 text-center rounded-lg bg-gray-50">
                <h2 class="mb-4 text-lg font-bold text-grayMain sm:text-xl">Report Support & Training</h2>
                <p class="mb-4 text-sm text-grayMain">Get help with reports, learn advanced features, and maximize your reporting capabilities:</p>
                <div class="space-y-2 text-sm text-grayMain">
                    <p>Support Email: <a href="mailto:reports@peso-rosario.gov.ph" class="text-blue-600 hover:underline">reports@peso-rosario.gov.ph</a></p>
                    <p>Technical Support: (043) 555-0115</p>
                    <p>Training Sessions: Available by appointment</p>
                    <p>PESO Rosario Office: Municipal Hall, Rosario, Batangas</p>
                    <p>Support Hours: Monday-Friday, 8:00 AM - 5:00 PM</p>
                </div>
                <div class="mt-6 space-x-4">
                    <a href="/reports/tutorial" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white rounded-md bg-primary hover:bg-primary-dark">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                        Watch Tutorial
                    </a>
                    <a href="/support/reports" class="inline-flex items-center px-4 py-2 text-sm font-medium border rounded-md text-primary border-primary hover:bg-primary hover:text-white">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M12 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Get Support
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- AOS Animation Library CSS -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

<!-- AOS Animation Library JS -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    // Initialize AOS when DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
        AOS.init({
            duration: 1000,
            easing: 'ease-out-cubic',
            once: true,
            offset: 50,
            delay: 100,
            disable: 'mobile',
            startEvent: 'DOMContentLoaded',
            useClassNames: false,
            disableMutationObserver: false,
            debounceDelay: 50,
            throttleDelay: 99,
        });
    });

    // Refresh AOS on window resize
    window.addEventListener('resize', function() {
        AOS.refresh();
    });
</script>

<?php include_once __DIR__ . '/../footer.php'; ?>