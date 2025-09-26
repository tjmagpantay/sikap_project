<?php
include_once __DIR__ . '/../navbar-top.php';
include_once __DIR__ . '/../navbar.php';
?>

<section class="px-4 py-16 bg-gradient-to-br from-gray-50 via-blue-50/30 to-white sm:px-6 md:px-16 lg:px-24">
    <div class="mx-auto max-w-7xl">
        <!-- Header Section -->
        <div class="mb-12 text-center" data-aos="fade-up">
            <h1 class="mb-4 text-3xl font-bold text-grayMain sm:text-2xl lg:text-3xl">
                Frequently Asked Questions
            </h1>
            <p class="max-w-3xl mx-auto mb-6 text-sm leading-relaxed text-gray-600">
                Find answers to common questions about using Sikap platform and PESO Rosario services
            </p>
            <div class="w-20 h-1.5 mx-auto bg-primary rounded-full"></div>
        </div>

        <!-- Main Content -->
        <div class="p-6 bg-white rounded-lg shadow-lg sm:p-8" data-aos="fade-up" data-aos-delay="100">
            <!-- Introduction -->
            <div class="relative mb-8 transition-all duration-300 bg-white border border-gray-200 rounded-lg group hover:border-primary hover:shadow-md">
                <div class="p-6">
                    <h2 class="mb-4 text-lg font-bold text-grayMain sm:text-xl">Welcome to Sikap Support</h2>
                    <p class="text-sm text-grayMain">
                        Get quick answers to the most commonly asked questions about Sikap platform features, account management, job applications, and employer services. Can't find what you're looking for? Our support team is ready to help with personalized assistance.
                    </p>
                </div>
            </div>

            <!-- General Questions -->
            <div class="relative mb-8 transition-all duration-300 bg-white border border-gray-200 rounded-lg group hover:border-primary hover:shadow-md">
                <div class="p-6">
                    <h2 class="mb-4 text-lg font-bold text-grayMain sm:text-xl">General Platform Questions</h2>
                    
                    <!-- What is Sikap -->
                    <div class="mb-6">
                        <h3 class="mb-3 font-semibold text-blue-600 text-md">What is Sikap?</h3>
                        <p class="text-sm text-grayMain">
                            Sikap is a cutting-edge web-based employment platform developed specifically for PESO Rosario, Batangas. It leverages advanced machine learning algorithms to provide personalized job recommendations, streamlines the recruitment process, and connects job seekers with verified employers. The platform serves as a comprehensive solution for employment facilitation, supporting both local and regional job placement efforts.
                        </p>
                    </div>

                    <!-- Who can use -->
                    <div class="mb-6">
                        <h3 class="mb-3 font-semibold text-blue-600 text-md">Who can use Sikap?</h3>
                        <p class="mb-3 text-sm text-grayMain">Sikap is designed for multiple user types:</p>
                        <ul class="ml-6 space-y-2 text-sm list-disc text-grayMain">
                            <li><span class="font-semibold">Job Seekers:</span> Residents of Rosario and nearby areas seeking verified employment opportunities</li>
                            <li><span class="font-semibold">Employers:</span> Companies and organizations looking to post job openings and find qualified candidates</li>
                            <li><span class="font-semibold">PESO Staff:</span> Government personnel managing employment programs and tracking labor market trends</li>
                            <li><span class="font-semibold">Partner Organizations:</span> Institutions collaborating with PESO Rosario on employment initiatives</li>
                        </ul>
                    </div>

                    <!-- Free to use -->
                    <div class="mb-6">
                        <h3 class="mb-3 font-semibold text-blue-600 text-md">Is Sikap free to use?</h3>
                        <p class="text-sm text-grayMain">
                            Yes, Sikap is completely free for all users. As a public service platform developed under the PESO Act of 1999 (RA 8759), there are no charges for job seekers, employers, or PESO staff. This ensures equal access to employment opportunities regardless of economic status.
                        </p>
                    </div>
                    
                    <div class="p-4 mt-4 rounded-lg text-primary bg-gray-50">
                        <p class="text-sm font-medium">💡 Platform Tip: Create a complete profile to get better job matches and increased visibility to employers.</p>
                    </div>
                </div>
            </div>

            <!-- Job Seeker Features -->
            <div class="relative mb-8 transition-all duration-300 bg-white border border-gray-200 rounded-lg group hover:border-primary hover:shadow-md">
                <div class="p-6">
                    <h2 class="mb-4 text-lg font-bold text-grayMain sm:text-xl">Job Seeker Features</h2>
                    
                    <div class="grid gap-6 md:grid-cols-2">
                        <div class="p-4 rounded-lg bg-green-50">
                            <h3 class="mb-3 font-semibold text-green-800 text-md">Smart Job Matching</h3>
                            <p class="mb-3 text-sm text-green-700">How does the job recommendation system work?</p>
                            <p class="text-sm text-green-700">
                                Sikap uses advanced machine learning algorithms that analyze your profile, skills, experience, and preferences to match you with the most suitable job postings. The system employs content-based filtering and collaborative filtering techniques to ensure highly personalized and relevant job recommendations.
                            </p>
                        </div>
                        
                        <div class="p-4 rounded-lg bg-purple-50">
                            <h3 class="mb-3 font-semibold text-purple-800 text-md">Application Tracking</h3>
                            <p class="mb-3 text-sm text-purple-700">Can I track my job applications?</p>
                            <p class="text-sm text-purple-700">
                                Yes! Once registered, you can monitor all application statuses in real-time. Receive updates when your application is viewed, when you're shortlisted, or when employers schedule interviews. The system provides complete transparency throughout the hiring process.
                            </p>
                        </div>
                    </div>

                    <!-- Application Duration -->
                    <div class="mt-6">
                        <h3 class="mb-3 font-semibold text-blue-600 text-md">Application Management</h3>
                        <p class="mb-3 text-sm text-grayMain">How long does my job application stay active?</p>
                        <p class="text-sm text-grayMain">
                            Job applications remain active for 7 days to ensure timely employer responses and maintain platform efficiency. If employers don't respond within this timeframe, applications are automatically archived. This system keeps the platform current and ensures active job opportunities receive prompt attention.
                        </p>
                    </div>
                    
                    <div class="p-4 mt-4 text-yellow-700 rounded-lg bg-yellow-50">
                        <p class="text-sm font-medium">⏰ Time Management: Follow up with employers within the 7-day active period for better response rates.</p>
                    </div>
                </div>
            </div>

            <!-- Employer Services -->
            <div class="relative mb-8 transition-all duration-300 bg-white border border-gray-200 rounded-lg group hover:border-primary hover:shadow-md">
                <div class="p-6">
                    <h2 class="mb-4 text-lg font-bold text-grayMain sm:text-xl">Employer Services</h2>
                    
                    <!-- Employer Usage -->
                    <div class="mb-6">
                        <h3 class="mb-3 font-semibold text-blue-600 text-md">How can employers use Sikap?</h3>
                        <p class="mb-3 text-sm text-grayMain">Employers have access to comprehensive recruitment tools:</p>
                        <ul class="ml-6 space-y-2 text-sm list-disc text-grayMain">
                            <li>Post detailed job openings with specific requirements</li>
                            <li>Screen and filter applicants based on qualifications</li>
                            <li>Communicate directly with candidates through the platform</li>
                            <li>Manage entire recruitment workflows and timelines</li>
                            <li>Access analytics and reporting tools for hiring insights</li>
                        </ul>
                        <div class="p-4 mt-4 text-blue-700 rounded-lg bg-blue-50">
                            <p class="text-sm font-medium">🔐 Security Note: All employers must complete verification and submit required documents before posting jobs to ensure legitimate, safe opportunities.</p>
                        </div>
                    </div>

                    <!-- Required Documents Table -->
                    <div class="mb-6">
                        <h3 class="mb-3 font-semibold text-blue-600 text-md">Employer Accreditation Requirements</h3>
                        <p class="mb-4 text-sm text-grayMain">Required documents for employer verification:</p>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm border border-gray-200 rounded-lg">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="p-3 text-left border-b">Required Document</th>
                                        <th class="p-3 text-left border-b">Source/Where to Secure</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    <tr class="hover:bg-gray-50">
                                        <td class="p-3">Letter of Intent</td>
                                        <td class="p-3">Company</td>
                                    </tr>
                                    <tr class="hover:bg-gray-50">
                                        <td class="p-3">Company Profile</td>
                                        <td class="p-3">Company</td>
                                    </tr>
                                    <tr class="hover:bg-gray-50">
                                        <td class="p-3">Updated Business Permit (1 photocopy)</td>
                                        <td class="p-3">City Hall – BPLIO</td>
                                    </tr>
                                    <tr class="hover:bg-gray-50">
                                        <td class="p-3">Certificate of No Pending Case</td>
                                        <td class="p-3">SEC or DOLE</td>
                                    </tr>
                                    <tr class="hover:bg-gray-50">
                                        <td class="p-3">SEC or DOLE Registration</td>
                                        <td class="p-3">SEC or DOLE</td>
                                    </tr>
                                    <tr class="hover:bg-gray-50">
                                        <td class="p-3">Certificate of No Objection (local recruitment)</td>
                                        <td class="p-3">DOLE Region IV-A</td>
                                    </tr>
                                    <tr class="hover:bg-gray-50">
                                        <td class="p-3">POEA Registration (overseas recruitment)</td>
                                        <td class="p-3">POEA</td>
                                    </tr>
                                    <tr class="hover:bg-gray-50">
                                        <td class="p-3">Phil-JobNet Registration</td>
                                        <td class="p-3">www.phil-jobnet.gov.ph</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <div class="p-4 mt-4 text-red-700 rounded-lg bg-red-50">
                        <p class="text-sm font-medium">📋 Documentation: Complete verification ensures all job postings are legitimate and comply with labor laws.</p>
                    </div>
                </div>
            </div>

            <!-- Government Programs -->
            <div class="relative mb-8 transition-all duration-300 bg-white border border-gray-200 rounded-lg group hover:border-primary hover:shadow-md">
                <div class="p-6">
                    <h2 class="mb-4 text-lg font-bold text-grayMain sm:text-xl">Government Employment Programs</h2>
                    
                    <div class="grid gap-6 md:grid-cols-3">
                        <div class="p-4 text-center rounded-lg bg-blue-50">
                            <h3 class="mb-2 font-semibold text-blue-800 text-md">SPES</h3>
                            <p class="text-sm text-blue-700">Special Program for<br>Employment of Students</p>
                        </div>
                        
                        <div class="p-4 text-center rounded-lg bg-green-50">
                            <h3 class="mb-2 font-semibold text-green-800 text-md">TUPAD</h3>
                            <p class="text-sm text-green-700">Tulong Panghanapbuhay sa<br>Disadvantaged/Displaced Workers</p>
                        </div>
                        
                        <div class="p-4 text-center rounded-lg bg-purple-50">
                            <h3 class="mb-2 font-semibold text-purple-800 text-md">GIP</h3>
                            <p class="text-sm text-purple-700">Government<br>Internship Program</p>
                        </div>
                    </div>

                    <div class="mt-6">
                        <p class="text-sm text-grayMain">
                            These programs are fully integrated into Sikap for streamlined monitoring, reporting, and participant management. The platform automatically tracks program participation, generates required reports, and ensures compliance with government requirements.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Platform Features -->
            <div class="relative mb-8 transition-all duration-300 bg-white border border-gray-200 rounded-lg group hover:border-primary hover:shadow-md">
                <div class="p-6">
                    <h2 class="mb-4 text-lg font-bold text-grayMain sm:text-xl">Platform Features & Security</h2>
                    
                    <!-- Support Features -->
                    <div class="mb-6">
                        <h3 class="mb-3 font-semibold text-blue-600 text-md">Built-in Support System</h3>
                        <p class="mb-3 text-sm text-grayMain">What if I have questions while using Sikap?</p>
                        <p class="text-sm text-grayMain">
                            Sikap features an intelligent chatbot that provides instant assistance with platform navigation, job applications, and general inquiries. You'll also receive email and SMS notifications for important updates, job alerts, interview schedules, and application status changes.
                        </p>
                    </div>

                    <!-- Security -->
                    <div class="mb-6">
                        <h3 class="mb-3 font-semibold text-blue-600 text-md">Data Protection & Privacy</h3>
                        <p class="mb-3 text-sm text-grayMain">Is my personal information safe?</p>
                        <p class="text-sm text-grayMain">
                            Absolutely. Sikap employs enterprise-grade security measures including encrypted data transmission, secure authentication systems, and strict access controls. We follow international data protection standards and only verified users can access their personal information. Your privacy and data security are our top priorities.
                        </p>
                    </div>

                    <!-- PESO Benefits -->
                    <div class="mb-6">
                        <h3 class="mb-3 font-semibold text-blue-600 text-md">PESO Rosario Benefits</h3>
                        <p class="mb-3 text-sm text-grayMain">How does Sikap help PESO Rosario?</p>
                        <ul class="ml-6 space-y-2 text-sm list-disc text-grayMain">
                            <li>Advanced job facilitation and placement tools</li>
                            <li>Comprehensive labor market analytics and insights</li>
                            <li>Interactive dashboards for monitoring placements and performance</li>
                            <li>Automated reporting systems reducing manual workload</li>
                            <li>Enhanced program delivery and service efficiency</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Contact Support -->
            <div class="p-6 text-center rounded-lg bg-gray-50">
                <h2 class="mb-4 text-lg font-bold text-grayMain sm:text-xl">Need Additional Help?</h2>
                <p class="mb-4 text-sm text-grayMain">Can't find the answer you're looking for? Our support team is here to provide personalized assistance:</p>
                <div class="space-y-2 text-sm text-grayMain">
                    <p>Email Support: <a href="mailto:support@peso-rosario.gov.ph" class="text-blue-600 hover:underline">support@peso-rosario.gov.ph</a></p>
                    <p>Phone Support: (043) 555-0115</p>
                    <p>Walk-in Support: PESO Rosario Office, Municipal Hall</p>
                    <p>Support Hours: Monday-Friday, 8:00 AM - 5:00 PM</p>
                    <p>Emergency Hotline: Available 24/7 for urgent platform issues</p>
                </div>
                <div class="mt-6 space-x-4">
                    <a href="/support/ticket" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white rounded-md bg-primary hover:bg-primary-dark">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                        Submit Support Ticket
                    </a>
                    <a href="/help/live-chat" class="inline-flex items-center px-4 py-2 text-sm font-medium border rounded-md text-primary border-primary hover:bg-primary hover:text-white">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a2 2 0 01-2-2v-6a2 2 0 012-2h8z"></path>
                        </svg>
                        Start Live Chat
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

<?php include_once __DIR__ . '/../footer.php';