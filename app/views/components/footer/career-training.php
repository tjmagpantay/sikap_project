<?php
include_once __DIR__ . '/../navbar-top.php';
include_once __DIR__ . '/../navbar.php';
?>

<div class="min-h-screen px-4 py-16 bg-gray-50 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header Section -->
        <div class="mb-12 text-center">
            <h1 class="mb-5 text-3xl font-bold tracking-wide text-gray-900 sm:text-4xl">Career Training Resources</h1>
            <div class="w-20 h-1.5 mx-auto bg-blue-600 rounded-full"></div>
            <p class="mt-6 text-lg text-gray-600">
                Enhance your skills and advance your career with these training opportunities
            </p>
        </div>

        <!-- Main Content -->
        <div class="p-8 bg-white rounded-lg shadow-lg">
            <!-- Skills Development -->
            <section class="mb-12">
                <h2 class="mb-6 text-2xl font-bold text-gray-900">Skills Development Programs</h2>
                <div class="space-y-6">
                    <!-- Technical Skills -->
                    <div class="p-6 border rounded-lg">
                        <h3 class="mb-4 text-xl font-semibold text-blue-600">Technical Skills Training</h3>
                        <div class="space-y-4 text-gray-700">
                            <p>Develop practical skills through:</p>
                            <ul class="pl-6 space-y-2 list-disc">
                                <li>TESDA certification programs</li>
                                <li>Industry-specific workshops</li>
                                <li>Hands-on training sessions</li>
                                <li>Technical apprenticeships</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Soft Skills -->
                    <div class="p-6 border rounded-lg">
                        <h3 class="mb-4 text-xl font-semibold text-blue-600">Professional Development</h3>
                        <div class="space-y-4 text-gray-700">
                            <p>Enhance your workplace skills:</p>
                            <ul class="pl-6 space-y-2 list-disc">
                                <li>Communication workshops</li>
                                <li>Leadership training</li>
                                <li>Time management</li>
                                <li>Problem-solving techniques</li>
                                <li>Team collaboration</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Digital Skills -->
            <section class="mb-12">
                <h2 class="mb-6 text-2xl font-bold text-gray-900">Digital Skills Training</h2>
                <div class="grid gap-6 md:grid-cols-2">
                    <div class="p-6 bg-gray-50 rounded-lg">
                        <h3 class="mb-4 text-lg font-semibold text-gray-800">Basic Digital Skills</h3>
                        <ul class="pl-6 space-y-2 text-gray-700 list-disc">
                            <li>Microsoft Office Suite</li>
                            <li>Email and communication tools</li>
                            <li>Internet research</li>
                            <li>Basic data entry</li>
                            <li>File management</li>
                        </ul>
                    </div>
                    <div class="p-6 bg-gray-50 rounded-lg">
                        <h3 class="mb-4 text-lg font-semibold text-gray-800">Advanced Digital Skills</h3>
                        <ul class="pl-6 space-y-2 text-gray-700 list-disc">
                            <li>Digital marketing</li>
                            <li>Web development</li>
                            <li>Data analysis</li>
                            <li>Graphic design</li>
                            <li>Social media management</li>
                        </ul>
                    </div>
                </div>
            </section>

            <!-- Language Training -->
            <section class="mb-12">
                <h2 class="mb-6 text-2xl font-bold text-gray-900">Language Skills</h2>
                <div class="p-6 border rounded-lg">
                    <div class="space-y-4 text-gray-700">
                        <p>Improve your language proficiency:</p>
                        <ul class="pl-6 space-y-2 list-disc">
                            <li>Business English communication</li>
                            <li>Technical writing</li>
                            <li>Public speaking</li>
                            <li>Customer service communication</li>
                            <li>Professional email writing</li>
                        </ul>
                    </div>
                </div>
            </section>

            <!-- Training Schedule -->
            <section class="mb-12">
                <h2 class="mb-6 text-2xl font-bold text-gray-900">Upcoming Training Sessions</h2>
                <div class="overflow-hidden border rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Training</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Schedule</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Duration</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">MS Office Basics</td>
                                <td class="px-6 py-4 whitespace-nowrap">Every Monday</td>
                                <td class="px-6 py-4 whitespace-nowrap">2 weeks</td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">Communication Skills</td>
                                <td class="px-6 py-4 whitespace-nowrap">Every Wednesday</td>
                                <td class="px-6 py-4 whitespace-nowrap">3 weeks</td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">Digital Marketing</td>
                                <td class="px-6 py-4 whitespace-nowrap">Every Friday</td>
                                <td class="px-6 py-4 whitespace-nowrap">4 weeks</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Registration Process -->
            <section class="p-6 bg-blue-50 rounded-lg">
                <h2 class="mb-6 text-2xl font-bold text-gray-900">How to Register</h2>
                <div class="space-y-4">
                    <ol class="pl-6 space-y-3 text-gray-700 list-decimal">
                        <li>Visit PESO Rosario office or register online</li>
                        <li>Select your preferred training program</li>
                        <li>Submit required documents</li>
                        <li>Pay training fee (if applicable)</li>
                        <li>Receive confirmation and schedule</li>
                    </ol>
                    <div class="p-4 mt-4 bg-white rounded-lg">
                        <p class="font-medium text-blue-600">Note: Some programs are free of charge for qualified individuals.</p>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<?php include_once __DIR__ . '/../footer.php'; ?>
