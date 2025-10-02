<?php
include_once __DIR__ . '/../navbar-top.php';
include_once __DIR__ . '/../navbar.php';
?>

<!-- FAQ Section -->
<section id="faqs" class="px-4 py-20 bg-gradient-to-br from-gray-50 via-blue-50/30 to-white sm:px-6 md:px-16 lg:px-24">
    <div class="mx-auto max-w-7xl">
        <!-- Header Section -->
        <div class="mb-12 text-center">
            <h6 class="mb-2 font-semibold text-md text-secondary">Support Center</h6>
            <h1 class="mb-6 text-3xl font-bold leading-tight text-primary lg:text-4xl">
                Frequently Asked Questions (FAQs)
            </h1>
            <p class="max-w-4xl mx-auto mb-8 text-sm leading-relaxed text-gray-600">
                Common inquiries about the Sikap platform and PESO Rosario services
            </p>
            <div class="w-20 h-1.5 mx-auto bg-primary rounded-full"></div>
        </div>

        <!-- Quick Navigation -->
        <div class="p-6 mb-8 bg-white border border-gray-200 rounded-lg shadow-sm">
            <h3 class="mb-4 text-lg font-semibold text-center text-primary">Quick Navigation</h3>
            <nav class="flex flex-wrap justify-center gap-2">
                <a href="#section-1" class="px-4 py-2 text-sm text-gray-600 transition-colors bg-gray-100 rounded-lg hover:bg-primary hover:text-white">1. General Questions</a>
                <a href="#section-2" class="px-4 py-2 text-sm text-gray-600 transition-colors bg-gray-100 rounded-lg hover:bg-primary hover:text-white">2. For Job Seekers</a>
                <a href="#section-3" class="px-4 py-2 text-sm text-gray-600 transition-colors bg-gray-100 rounded-lg hover:bg-primary hover:text-white">3. For Employers</a>
                <a href="#section-4" class="px-4 py-2 text-sm text-gray-600 transition-colors bg-gray-100 rounded-lg hover:bg-primary hover:text-white">4. Government Programs</a>
                <a href="#section-5" class="px-4 py-2 text-sm text-gray-600 transition-colors bg-gray-100 rounded-lg hover:bg-primary hover:text-white">5. Platform & Security</a>
            </nav>
        </div>

        <!-- Main Content - Full Width -->
        <div class="space-y-6">
            <!-- General Questions -->
            <div id="section-1" class="p-6 transition-all duration-300 bg-white border border-gray-200 rounded-lg shadow-sm hover:border-primary hover:shadow-md">
                <h2 class="flex items-center mb-4 text-xl font-bold text-primary">
                    <span class="flex items-center justify-center w-8 h-8 mr-3 text-sm font-bold text-white rounded-full bg-primary">1</span>
                    General Questions
                </h2>

                <!-- What is Sikap -->
                <div class="p-4 mb-4 border border-gray-200 rounded-lg">
                    <h3 class="mb-3 text-base font-semibold text-gray-800">What is Sikap?</h3>
                    <p class="text-sm text-gray-700">
                        Sikap is a web-based employment facilitation platform developed for the Public Employment Service Office (PESO) of Rosario, Batangas. It leverages machine learning (ML) to recommend jobs that align with a user's skills, qualifications, and preferences. The system streamlines recruitment by connecting verified employers with job seekers while also supporting PESO's reporting and monitoring functions.
                    </p>
                </div>

                <!-- Who can use -->
                <div class="p-4 mb-4 border border-gray-200 rounded-lg">
                    <h3 class="mb-3 text-base font-semibold text-gray-800">Who can use Sikap?</h3>
                    <p class="mb-3 text-sm text-gray-700">The platform is designed for multiple stakeholders:</p>
                    <ul class="space-y-2 text-sm text-gray-700">
                        <li class="flex items-start"><span class="mr-2 text-primary">•</span><strong>Job Seekers</strong> – Residents of Rosario and nearby areas looking for verified employment opportunities</li>
                        <li class="flex items-start"><span class="mr-2 text-primary">•</span><strong>Employers</strong> – Registered businesses posting job vacancies and screening candidates</li>
                        <li class="flex items-start"><span class="mr-2 text-primary">•</span><strong>PESO Staff</strong> – Government personnel managing employment programs and labor market trends</li>
                        <li class="flex items-start"><span class="mr-2 text-primary">•</span><strong>Partner Organizations</strong> – Schools, training centers, and institutions collaborating with PESO Rosario</li>
                    </ul>
                </div>

                <!-- Free to use -->
                <div class="p-4 border border-gray-200 rounded-lg">
                    <h3 class="mb-3 text-base font-semibold text-gray-800">Is Sikap free to use?</h3>
                    <p class="text-sm text-gray-700">
                        Yes. As a public service initiative under the PESO Act of 1999 (RA 8759), Sikap is free for all users. No fees are charged to job seekers, employers, or PESO staff.
                    </p>
                </div>

                <div class="p-4 mt-4 border-l-4 rounded-lg bg-primary border-primary">
                    <p class="text-sm font-medium text-white">💡 Tip: A complete and well-prepared resume increases the accuracy of job matching and improves employer visibility.</p>
                </div>
            </div>

            <!-- For Job Seekers -->
            <div id="section-2" class="p-6 transition-all duration-300 bg-white border border-gray-200 rounded-lg shadow-sm hover:border-primary hover:shadow-md">
                <h2 class="flex items-center mb-4 text-xl font-bold text-primary">
                    <span class="flex items-center justify-center w-8 h-8 mr-3 text-sm font-bold text-white rounded-full bg-primary">2</span>
                    For Job Seekers
                </h2>

                <!-- Job Recommendation System -->
                <div class="p-4 mb-4 border border-gray-200 rounded-lg">
                    <h3 class="mb-3 text-base font-semibold text-gray-800">How does the job recommendation system work?</h3>
                    <p class="text-sm text-gray-700">
                        Sikap's recommendation engine applies ML-driven algorithms (content-based and collaborative filtering). It evaluates user profiles, listed skills, and job requirements to suggest positions that best match an applicant's background.
                    </p>
                </div>

                <!-- Track Applications -->
                <div class="p-4 mb-4 border border-gray-200 rounded-lg">
                    <h3 class="mb-3 text-base font-semibold text-gray-800">Can I track my job applications?</h3>
                    <p class="text-sm text-gray-700">
                        Yes. Sikap provides status updates, including when an application has been viewed, shortlisted, or scheduled for an interview. This ensures transparency in the hiring process.
                    </p>
                </div>

                <!-- Application Duration -->
                <div class="p-4 border border-gray-200 rounded-lg">
                    <h3 class="mb-3 text-base font-semibold text-gray-800">How long does my job application stay active?</h3>
                    <p class="text-sm text-gray-700">
                        Applications remain active for 7 days to maintain responsiveness from employers. If no action is taken, the application is archived to keep listings updated and relevant.
                    </p>
                </div>
            </div>

            <!-- For Employers -->
            <div id="section-3" class="p-6 transition-all duration-300 bg-white border border-gray-200 rounded-lg shadow-sm hover:border-primary hover:shadow-md">
                <h2 class="flex items-center mb-4 text-xl font-bold text-primary">
                    <span class="flex items-center justify-center w-8 h-8 mr-3 text-sm font-bold text-white rounded-full bg-primary">3</span>
                    For Employers
                </h2>

                <!-- Employer Services -->
                <div class="p-4 mb-4 border border-gray-200 rounded-lg">
                    <h3 class="mb-3 text-base font-semibold text-gray-800">What services does Sikap provide for employers?</h3>
                    <p class="mb-3 text-sm text-gray-700">Employers have access to tools that include:</p>
                    <ul class="space-y-2 text-sm text-gray-700">
                        <li class="flex items-start"><span class="mr-2 text-primary">•</span>Posting and managing job vacancies</li>
                        <li class="flex items-start"><span class="mr-2 text-primary">•</span>Screening and filtering applicants</li>
                        <li class="flex items-start"><span class="mr-2 text-primary">•</span>Recruitment performance analytics</li>
                        <li class="flex items-start"><span class="mr-2 text-primary">•</span>Compliance and reporting features for DOLE and PESO</li>
                    </ul>
                </div>

                <div class="p-4 mb-4 border-l-4 border-yellow-400 rounded-lg bg-yellow-50">
                    <p class="text-sm font-medium text-yellow-800">🔐 Security Note: Employers must complete verification and accreditation before posting jobs to safeguard against fraudulent recruitment.</p>
                </div>

                <!-- Required Documents -->
                <div class="border border-gray-200 rounded-lg">
                    <h3 class="p-4 text-base font-semibold text-gray-800 border-b border-gray-200">What documents are required for employer accreditation?</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="p-3 text-left border-b">Required Document</th>
                                    <th class="p-3 text-left border-b">Issuing Source</th>
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
                                    <td class="p-3">Updated Business Permit</td>
                                    <td class="p-3">City Hall (BPLIO)</td>
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
                                    <td class="p-3">Certificate of No Objection (Local Recruitment)</td>
                                    <td class="p-3">DOLE Region IV-A</td>
                                </tr>
                                <tr class="hover:bg-gray-50">
                                    <td class="p-3">POEA Registration (Overseas Recruitment)</td>
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

                <div class="p-4 mt-4 border-l-4 border-red-400 rounded-lg bg-red-50">
                    <p class="text-sm font-medium text-red-800">📋 Note: Only accredited employers can post jobs on Sikap. This ensures compliance with national labor regulations and protects job seekers.</p>
                </div>
            </div>

            <!-- Government Employment Programs -->
            <div id="section-4" class="p-6 transition-all duration-300 bg-white border border-gray-200 rounded-lg shadow-sm hover:border-primary hover:shadow-md">
                <h2 class="flex items-center mb-4 text-xl font-bold text-primary">
                    <span class="flex items-center justify-center w-8 h-8 mr-3 text-sm font-bold text-white rounded-full bg-primary">4</span>
                    Government Employment Programs
                </h2>

                <p class="mb-4 text-sm text-gray-700">Sikap integrates monitoring and reporting for government employment initiatives managed by PESO Rosario:</p>

                <div class="grid gap-4 md:grid-cols-3">
                    <div class="p-4 text-center bg-white border border-gray-200 rounded-lg shadow-sm">
                        <h3 class="mb-2 text-base font-semibold text-blue-800">SPES</h3>
                        <p class="text-sm text-blue-700">Special Program for the Employment of Students</p>
                    </div>
                    <div class="p-4 text-center bg-white border border-gray-200 rounded-lg shadow-sm">
                        <h3 class="mb-2 text-base font-semibold text-green-800">TUPAD</h3>
                        <p class="text-sm text-green-700">Tulong Panghanapbuhay sa Disadvantaged/Displaced Workers</p>
                    </div>
                    <div class="p-4 text-center bg-white border border-gray-200 rounded-lg shadow-sm">
                        <h3 class="mb-2 text-base font-semibold text-purple-800">GIP</h3>
                        <p class="text-sm text-purple-700">Government Internship Program</p>
                    </div>
                </div>

                <p class="mt-4 text-sm text-gray-700">
                    The system tracks participation, generates compliance-ready reports, and improves program delivery efficiency.
                </p>
            </div>

            <!-- Platform Features & Security -->
            <div id="section-5" class="p-6 transition-all duration-300 bg-white border border-gray-200 rounded-lg shadow-sm hover:border-primary hover:shadow-md">
                <h2 class="flex items-center mb-4 text-xl font-bold text-primary">
                    <span class="flex items-center justify-center w-8 h-8 mr-3 text-sm font-bold text-white rounded-full bg-primary">5</span>
                    Platform Features & Security
                </h2>

                <!-- Support Features -->
                <div class="p-4 mb-4 border border-gray-200 rounded-lg">
                    <h3 class="mb-3 text-base font-semibold text-gray-800">What support does Sikap provide?</h3>
                    <p class="mb-3 text-sm text-gray-700">The platform includes:</p>
                    <ul class="space-y-2 text-sm text-gray-700">
                        <li class="flex items-start"><span class="mr-2 text-primary">•</span>A chatbot that provides instant assistance inquiries</li>
                        <li class="flex items-start"><span class="mr-2 text-primary">•</span>System notifications for job updates, interview schedules, and application statuses</li>
                        <li class="flex items-start"><span class="mr-2 text-primary">•</span>Guidance for both employers and job seekers on platform usage</li>
                    </ul>
                </div>

                <!-- Data Security -->
                <div class="p-4 mb-4 border border-gray-200 rounded-lg">
                    <h3 class="mb-3 text-base font-semibold text-gray-800">How does Sikap ensure data security?</h3>
                    <p class="text-sm text-gray-700">
                        Sikap uses encryption, secure authentication (including Google login and optional 2FA), and strict access controls. Only verified users can view or modify data. The system follows international data protection standards to safeguard user privacy.
                    </p>
                </div>

                <!-- Benefits for PESO -->
                <div class="p-4 border border-gray-200 rounded-lg">
                    <h3 class="mb-3 text-base font-semibold text-gray-800">Benefits for PESO Rosario</h3>
                    <p class="mb-3 text-sm text-gray-700">Through Sikap, PESO Rosario gains:</p>
                    <ul class="space-y-2 text-sm text-gray-700">
                        <li class="flex items-start"><span class="mr-2 text-primary">•</span>Tools for job facilitation and placement</li>
                        <li class="flex items-start"><span class="mr-2 text-primary">•</span>Labor market insights through analytics dashboards</li>
                        <li class="flex items-start"><span class="mr-2 text-primary">•</span>Automated reporting functions for DOLE requirements</li>
                        <li class="flex items-start"><span class="mr-2 text-primary">•</span>Improved efficiency in program management and service delivery</li>
                    </ul>
                </div>
            </div>

            <!-- Footer Statement -->
            <div class="p-8 text-center border rounded-lg bg-gradient-to-r from-primary/10 via-secondary/10 to-primary/10 border-primary/20">
                <h2 class="mb-4 text-2xl font-bold text-primary">Your Success is Our Priority</h2>
                <p class="max-w-4xl mx-auto mb-6 text-sm leading-relaxed text-gray-700">
                    We're committed to providing exceptional support and ensuring your experience with Sikap is smooth and successful. Whether you're finding your next career opportunity or building your team, we're here to help every step of the way.
                </p>
                <div class="flex flex-wrap justify-center gap-3">
                    <span class="px-4 py-2 text-sm font-medium text-white rounded-full bg-primary">24/7 Support</span>
                    <span class="px-4 py-2 text-sm font-medium text-white rounded-full bg-primary">Expert Guidance</span>
                    <span class="px-4 py-2 text-sm font-medium text-white rounded-full bg-primary">User-Friendly</span>
                    <span class="px-4 py-2 text-sm font-medium text-white rounded-full bg-primary">Continuous Improvement</span>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include_once __DIR__ . '/../footer.php'; ?>