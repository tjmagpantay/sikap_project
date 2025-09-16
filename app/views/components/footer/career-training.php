<?php
include_once __DIR__ . '/../navbar-top.php';
include_once __DIR__ . '/../navbar.php';
?>

<section class="px-4 py-16 bg-gradient-to-br from-gray-50 via-blue-50/30 to-white sm:px-6 md:px-16 lg:px-24">
    <div class="mx-auto max-w-7xl">
        <!-- Header Section -->
        <div class="mb-12 text-center" data-aos="fade-up">
            <h1 class="mb-4 text-3xl font-bold text-grayMain sm:text-2xl lg:text-3xl">
                Career Training Resources
            </h1>
            <p class="max-w-3xl mx-auto mb-6 text-sm leading-relaxed text-gray-600">
                Enhance your skills and advance your career with these training opportunities
            </p>
            <div class="w-20 h-1.5 mx-auto bg-primary rounded-full"></div>
        </div>

        <!-- Main Content -->
        <div class="p-6 bg-white rounded-lg shadow-lg sm:p-8" data-aos="fade-up" data-aos-delay="100">
            <!-- Skills Development -->
            <div class="relative mb-8 transition-all duration-300 bg-white border border-gray-200 rounded-lg group hover:border-primary hover:shadow-md">
                <div class="p-6">
                    <h2 class="mb-4 text-lg font-bold text-grayMain sm:text-xl">Skills Development Programs</h2>
                    
                    <!-- Technical Skills -->
                    <div class="mb-6 transition-all duration-300 border border-gray-200 rounded-lg group hover:border-primary">
                        <div class="p-6">
                            <h3 class="mb-3 font-semibold text-md text-grayMain">Technical Skills Training</h3>
                            <p class="mb-3 text-sm text-grayMain">Develop practical skills through:</p>
                            <ul class="ml-6 space-y-2 text-sm list-disc text-grayMain">
                                <li>TESDA certification programs</li>
                                <li>Industry-specific workshops</li>
                                <li>Hands-on training sessions</li>
                                <li>Technical apprenticeships</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Soft Skills -->
                    <div class="transition-all duration-300 border border-gray-200 rounded-lg group hover:border-primary">
                        <div class="p-6">
                            <h3 class="mb-3 font-semibold text-md text-grayMain">Professional Development</h3>
                            <p class="mb-3 text-sm text-grayMain">Enhance your workplace skills:</p>
                            <ul class="ml-6 space-y-2 text-sm list-disc text-grayMain">
                                <li>Communication workshops</li>
                                <li>Leadership training</li>
                                <li>Time management</li>
                                <li>Problem-solving techniques</li>
                                <li>Team collaboration</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Digital Skills -->
            <div class="relative mb-8 transition-all duration-300 bg-white border border-gray-200 rounded-lg group hover:border-primary hover:shadow-md">
                <div class="p-6">
                    <h2 class="mb-4 text-lg font-bold text-grayMain sm:text-xl">Digital Skills Training</h2>
                    
                    <div class="grid gap-6 md:grid-cols-2">
                        <!-- Basic Digital Skills -->
                        <div class="p-4 transition-all duration-300 border border-gray-200 rounded-lg group hover:border-primary">
                            <h3 class="mb-3 font-semibold text-md text-grayMain">Basic Digital Skills</h3>
                            <ul class="ml-6 space-y-2 text-sm list-disc text-grayMain">
                                <li>Microsoft Office Suite</li>
                                <li>Email and communication tools</li>
                                <li>Internet research</li>
                                <li>Basic data entry</li>
                                <li>File management</li>
                            </ul>
                        </div>

                        <!-- Advanced Digital Skills -->
                        <div class="p-4 transition-all duration-300 border border-gray-200 rounded-lg group hover:border-primary">
                            <h3 class="mb-3 font-semibold text-md text-grayMain">Advanced Digital Skills</h3>
                            <ul class="ml-6 space-y-2 text-sm list-disc text-grayMain">
                                <li>Digital marketing</li>
                                <li>Web development</li>
                                <li>Data analysis</li>
                                <li>Graphic design</li>
                                <li>Social media management</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Language Training -->
            <div class="relative mb-8 transition-all duration-300 bg-white border border-gray-200 rounded-lg group hover:border-primary hover:shadow-md">
                <div class="p-6">
                    <h2 class="mb-4 text-lg font-bold text-grayMain sm:text-xl">Language Skills</h2>
                    <p class="mb-3 text-sm text-grayMain">Improve your language proficiency:</p>
                    <ul class="ml-6 space-y-2 text-sm list-disc text-grayMain">
                        <li>Business English communication</li>
                        <li>Technical writing</li>
                        <li>Public speaking</li>
                        <li>Customer service communication</li>
                        <li>Professional email writing</li>
                    </ul>
                </div>
            </div>

            <!-- Training Schedule -->
            <div class="relative mb-8 transition-all duration-300 bg-white border border-gray-200 rounded-lg group hover:border-primary hover:shadow-md">
                <div class="p-6">
                    <h2 class="mb-4 text-lg font-bold text-grayMain sm:text-xl">Upcoming Training Sessions</h2>
                    
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
                                    <td class="px-6 py-4 text-sm whitespace-nowrap text-grayMain">MS Office Basics</td>
                                    <td class="px-6 py-4 text-sm whitespace-nowrap text-grayMain">Every Monday</td>
                                    <td class="px-6 py-4 text-sm whitespace-nowrap text-grayMain">2 weeks</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 text-sm whitespace-nowrap text-grayMain">Communication Skills</td>
                                    <td class="px-6 py-4 text-sm whitespace-nowrap text-grayMain">Every Wednesday</td>
                                    <td class="px-6 py-4 text-sm whitespace-nowrap text-grayMain">3 weeks</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 text-sm whitespace-nowrap text-grayMain">Digital Marketing</td>
                                    <td class="px-6 py-4 text-sm whitespace-nowrap text-grayMain">Every Friday</td>
                                    <td class="px-6 py-4 text-sm whitespace-nowrap text-grayMain">4 weeks</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Registration Process -->
            <div class="relative transition-all duration-300 bg-white border border-gray-200 rounded-lg group hover:border-primary hover:shadow-md">
                <div class="p-6">
                    <h2 class="mb-4 text-lg font-bold text-grayMain sm:text-xl">How to Register</h2>
                    
                    <ol class="ml-6 space-y-2 text-sm list-decimal text-grayMain">
                        <li>Visit PESO Rosario office or register online</li>
                        <li>Select your preferred training program</li>
                        <li>Submit required documents</li>
                        <li>Pay training fee (if applicable)</li>
                        <li>Receive confirmation and schedule</li>
                    </ol>
                    
                    <div class="p-4 mt-4 rounded-lg bg-gray-50">
                        <p class="text-sm font-medium text-primary">Note: Some programs are free of charge for qualified individuals.</p>
                    </div>
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