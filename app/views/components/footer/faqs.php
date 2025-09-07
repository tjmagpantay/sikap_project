<?php
include_once __DIR__ . '/../navbar-top.php';
include_once __DIR__ . '/../navbar.php';
?>

<div class="min-h-screen px-4 py-16 bg-gray-50 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header Section -->
        <div class="mb-12 text-center">
            <h1 class="mb-5 text-3xl font-bold tracking-wide text-gray-900 sm:text-4xl">Frequently Asked Questions (FAQs)</h1>
            <div class="w-20 h-1.5 mx-auto bg-blue-600 rounded-full"></div>
            <p class="mt-6 text-lg text-gray-600">
                Find answers to common questions about using Sikap
            </p>
        </div>

        <!-- FAQs Content -->
        <div class="p-8 bg-white rounded-lg shadow-lg">
            <!-- General Questions -->
            <div class="space-y-6">
                <!-- What is Sikap -->
                <div class="p-6 transition-all duration-200 border rounded-lg hover:shadow-md">
                    <h3 class="mb-4 text-xl font-semibold text-gray-900">What is Sikap?</h3>
                    <p class="text-gray-700">
                        Sikap is a web-based employment platform developed for PESO Rosario, Batangas. It uses machine learning to provide personalized job recommendations and helps job seekers, employers, and PESO staff streamline the job application and recruitment process.
                    </p>
                </div>

                <!-- Who can use Sikap -->
                <div class="p-6 transition-all duration-200 border rounded-lg hover:shadow-md">
                    <h3 class="mb-4 text-xl font-semibold text-gray-900">Who can use Sikap?</h3>
                    <p class="mb-2 text-gray-700">Sikap is open to:</p>
                    <ul class="pl-8 ml-4 space-y-2 text-gray-700 list-disc">
                        <li>Job seekers from Rosario and nearby areas looking for verified job opportunities.</li>
                        <li>Employers who want to post job openings and find qualified applicants.</li>
                        <li>PESO Rosario staff for managing job programs, tracking employment trends, and supporting job placement efforts.</li>
                    </ul>
                </div>

                <!-- Job Recommendation System -->
                <div class="p-6 transition-all duration-200 border rounded-lg hover:shadow-md">
                    <h3 class="mb-4 text-xl font-semibold text-gray-900">How does the job recommendation system work?</h3>
                    <p class="text-gray-700">
                        Sikap uses machine learning algorithms that analyze your profile, skills, and preferences to match you with the most suitable job postings. It uses techniques like content-based filtering to ensure personalized results based on your qualifications.
                    </p>
                </div>

                <!-- Is Sikap free -->
                <div class="p-6 transition-all duration-200 border rounded-lg hover:shadow-md">
                    <h3 class="mb-4 text-xl font-semibold text-gray-900">Is Sikap free to use?</h3>
                    <p class="text-gray-700">
                        Yes. Sikap is completely free for job seekers, employers, and PESO Rosario staff. It is a public service platform developed under the goals of the PESO Act of 1999 (RA 8759).
                    </p>
                </div>

                <!-- Application Active Period -->
                <div class="p-6 transition-all duration-200 border rounded-lg hover:shadow-md">
                    <h3 class="mb-4 text-xl font-semibold text-gray-900">How long does my job application stay active?</h3>
                    <p class="text-gray-700">
                        Your job application remains active for 7 days. If the employer does not manage or respond to the application within that time, it will be automatically removed from the system to keep the platform clean and updated.
                    </p>
                </div>

                <!-- Track Applications -->
                <div class="p-6 transition-all duration-200 border rounded-lg hover:shadow-md">
                    <h3 class="mb-4 text-xl font-semibold text-gray-900">Can I track my job applications?</h3>
                    <p class="mb-2 text-gray-700">Yes. Once registered, job seekers can track their application status in real time. You'll receive updates when:</p>
                    <ul class="pl-8 ml-4 space-y-2 text-gray-700 list-disc">
                        <li>Your application is viewed</li>
                        <li>You are shortlisted</li>
                        <li>An employer responds or schedules an interview</li>
                    </ul>
                </div>

                <!-- Employer Usage -->
                <div class="p-6 transition-all duration-200 border rounded-lg hover:shadow-md">
                    <h3 class="mb-4 text-xl font-semibold text-gray-900">How can employers use Sikap?</h3>
                    <p class="mb-2 text-gray-700">Employers can:</p>
                    <ul class="pl-8 mb-4 ml-4 space-y-2 text-gray-700 list-disc">
                        <li>Post job openings</li>
                        <li>Screen applicants</li>
                        <li>Communicate with candidates</li>
                        <li>Manage recruitment activities</li>
                    </ul>
                    <p class="p-4 text-sm bg-gray-100 rounded-lg">
                        Note: Before an employer can post a job opening, they must complete all required verification documents. This ensures that all job postings on Sikap are legitimate, safe, and properly authorized by PESO Rosario.
                    </p>
                </div>

                <!-- Required Documents -->
                <div class="p-6 transition-all duration-200 border rounded-lg hover:shadow-md">
                    <h3 class="mb-4 text-xl font-semibold text-gray-900">What are the required documents for employer accreditation?</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full mb-4">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="p-4 text-left">Required Document</th>
                                    <th class="p-4 text-left">Where to Secure</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <tr>
                                    <td class="p-4">Letter of Intent</td>
                                    <td class="p-4">Company</td>
                                </tr>
                                <tr>
                                    <td class="p-4">Company Profile</td>
                                    <td class="p-4">Company</td>
                                </tr>
                                <tr>
                                    <td class="p-4">Updated Business Permit (1 photocopy)</td>
                                    <td class="p-4">City Hall – BPLIO</td>
                                </tr>
                                <tr>
                                    <td class="p-4">Certificate of No Pending Case (1 photocopy)</td>
                                    <td class="p-4">SEC or DOLE</td>
                                </tr>
                                <tr>
                                    <td class="p-4">SEC or DOLE Registration (1 photocopy)</td>
                                    <td class="p-4">SEC or DOLE</td>
                                </tr>
                                <tr>
                                    <td class="p-4">Certificate of No Objection (1 original, for local recruitment only)</td>
                                    <td class="p-4">DOLE Region IV-A</td>
                                </tr>
                                <tr>
                                    <td class="p-4">POEA Registration (1 photocopy, for overseas recruitment)</td>
                                    <td class="p-4">POEA</td>
                                </tr>
                                <tr>
                                    <td class="p-4">List of Job Vacancies with Qualifications (1 photocopy)</td>
                                    <td class="p-4">Company</td>
                                </tr>
                                <tr>
                                    <td class="p-4">Phil-JobNet Registration (1 photocopy)</td>
                                    <td class="p-4">www.phil-jobnet.gov.ph</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Job Programs -->
                <div class="p-6 transition-all duration-200 border rounded-lg hover:shadow-md">
                    <h3 class="mb-4 text-xl font-semibold text-gray-900">What kind of job programs are supported?</h3>
                    <p class="mb-2 text-gray-700">Sikap supports PESO Rosario's participation in government programs such as:</p>
                    <ul class="pl-8 ml-4 space-y-2 text-gray-700 list-disc">
                        <li>SPES (Special Program for Employment of Students)</li>
                        <li>TUPAD (Tulong Panghanapbuhay sa Ating Disadvantaged/Displaced Workers)</li>
                        <li>GIP (Government Internship Program)</li>
                    </ul>
                    <p class="mt-2 text-gray-700">These programs are integrated into the platform for easier monitoring and reporting.</p>
                </div>

                <!-- Questions While Using -->
                <div class="p-6 transition-all duration-200 border rounded-lg hover:shadow-md">
                    <h3 class="mb-4 text-xl font-semibold text-gray-900">What if I have questions while using Sikap?</h3>
                    <p class="text-gray-700">
                        Sikap features a built-in chatbot that helps answer job-related questions, guide users through the platform, and assist with application steps. You can also receive email and SMS notifications for updates, job alerts, and interview schedules.
                    </p>
                </div>

                <!-- Personal Information Safety -->
                <div class="p-6 transition-all duration-200 border rounded-lg hover:shadow-md">
                    <h3 class="mb-4 text-xl font-semibold text-gray-900">Is my personal information safe?</h3>
                    <p class="text-gray-700">
                        Yes. Sikap uses a secure authentication system and follows proper data protection practices to keep your information safe. Only verified users can access and manage their data.
                    </p>
                </div>

                <!-- PESO Rosario Benefits -->
                <div class="p-6 transition-all duration-200 border rounded-lg hover:shadow-md">
                    <h3 class="mb-4 text-xl font-semibold text-gray-900">How does Sikap help PESO Rosario?</h3>
                    <p class="mb-2 text-gray-700">Sikap gives PESO Rosario:</p>
                    <ul class="pl-8 ml-4 space-y-2 text-gray-700 list-disc">
                        <li>A powerful job facilitation tool</li>
                        <li>Access to labor market analytics</li>
                        <li>Visual dashboards to monitor placements and applicant performance</li>
                        <li>Automated systems to reduce manual workloads and improve program delivery</li>
                    </ul>
                </div>
            </div>

            <!-- Still Have Questions Section -->
            <div class="p-6 mt-8 text-center rounded-lg bg-gray-50">
                <h3 class="mb-4 text-xl font-semibold text-gray-900">Still Have Questions?</h3>
                <p class="text-gray-700">
                    Contact PESO Rosario support:<br>
                    Email: <a href="mailto:pesorosariobats@gmail.com" class="text-blue-600 hover:underline">pesorosariobats@gmail.com</a><br>
                    Phone: (319) 555-0115
                </p>
            </div>
        </div>
    </div>
</div>

<?php include_once __DIR__ . '/../footer.php'; ?>
