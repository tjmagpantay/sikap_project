<?php
include_once __DIR__ . '/../components/navbar-top.php';
include_once __DIR__ . '/../components/navbar.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta Tags -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="author" content="PESO Rosario" />
    <meta name="description" content="About PESO Rosario - Learn more about our mission to connect job seekers with opportunities" />
    <meta name="keywords" content="about, PESO, Rosario, job placement, employment" />

    <!-- Page title -->
    <title>About Us | PESO Rosario - SIKAP</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#092C4C',
                        secondary: '#F3AF0E'
                    },
                    fontFamily: {
                        'inter': ['Inter', 'sans-serif']
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/main.css">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>

<body class="antialiased font-inter">
    <main class="relative">
<!-- Hero Section - Similar to landing page hero -->
<section class="relative w-full px-4 py-8 sm:px-6 md:px-16 lg:px-24 min-h-[700px] flex items-center"
    style="background: linear-gradient(0deg, rgba(122,140,160,0.4), rgba(122,140,160,0.4)), 
           url('assets/images/abt-hero-bg.jpg');
           background-blend-mode: overlay;
           background-size: cover;
           background-position: center;">

    <div class="w-full mx-auto max-w-7xl">
        <div class="relative flex flex-col items-center justify-center w-full text-center">
                      <h1 class="mb-6 text-lg font-bold leading-tight sm:text-2xl md:text-3xl lg:text-4xl xl:text-5xl sm:leading-tight md:leading-tight lg:leading-tight xl:leading-tight"
                style="background: linear-gradient(to top right, #1567B2, #092C4C); 
                       -webkit-background-clip: text; 
                       -webkit-text-fill-color: transparent; 
                       background-clip: text;
                       word-wrap: break-word;
                       hyphens: auto;"
                data-aos="fade-up"
                data-aos-duration="1000"
                data-aos-delay="200">
                Public Employment Service Office (PESO) <br>
                Rosario Batangas
            </h1>

            <p class="mx-auto mb-12 max-w-[600px] text-md text-gray-700 leading-relaxed"
                data-aos="fade-up"
                data-aos-duration="1000"
                data-aos-delay="300">
                The Public Employment Service Office (PESO) in Rosario, Batangas provides free employment services, career guidance, and job matching to connect jobseekers with opportunities both locally and abroad.
            </p>

            <!-- Buttons Section -->
            <div class="flex flex-col items-center justify-center gap-4 sm:flex-row"
                data-aos="fade-up"
                data-aos-duration="1000"
                data-aos-delay="400">
                
                <!-- Dark Blue Button -->
                <button class="px-8 py-4 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 min-w-[200px]"
                    style="background-color: #092C4C;"
                    onmouseover="this.style.backgroundColor='#0a3558'"
                    onmouseout="this.style.backgroundColor='#092C4C'">
                    Find Jobs
                </button>
                
                <!-- Light Blue Button -->
                <button class="px-8 py-4 font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 min-w-[200px] border-2"
                    style="background-color: #E3F2FD; color: #092C4C; border-color: #092C4C;"
                    onmouseover="this.style.backgroundColor='#BBDEFB'; this.style.borderColor='#0a3558'"
                    onmouseout="this.style.backgroundColor='#E3F2FD'; this.style.borderColor='#092C4C'">
                    Our Services
                </button>
            </div>
        </div>
    </div>
</section>

        <!-- Mission & Vision Section -->
        <section id="mission" class="relative w-full px-4 py-24 bg-white sm:px-6 md:px-16 lg:px-24">
            <div class="w-full mx-auto max-w-7xl">
                <div class="grid grid-cols-1 gap-12 lg:grid-cols-2 lg:gap-16">
                    <!-- Mission Content -->
                    <div class="flex flex-col justify-center">
                        <div class="mb-8">
                            <h6 class="mb-2 text-lg font-semibold text-secondary">Our Mission & Vision</h6>
                            <h2 class="mb-6 text-3xl font-bold text-primary lg:text-4xl">
                                Connecting Dreams with Opportunities
                            </h2>
                        </div>

                        <!-- Static Tab Navigation -->
                        <div class="tabs">
                            <nav class="flex flex-wrap gap-2 mb-6" role="tablist">
                                <button type="button"
                                    class="px-4 py-2 text-sm font-medium text-white rounded-lg bg-primary tabs-link active"
                                    onclick="showTab('mission')" id="tab-mission">
                                    Our Mission
                                </button>
                                <button type="button"
                                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-primary hover:text-white tabs-link"
                                    onclick="showTab('vision')" id="tab-vision">
                                    Our Vision
                                </button>
                                <button type="button"
                                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-primary hover:text-white tabs-link"
                                    onclick="showTab('values')" id="tab-values">
                                    Our Values
                                </button>
                            </nav>

                            <!-- Tab Content (only this part changes) -->
                            <div>
                                <div class="tabs-content" id="content-mission">
                                    <p class="mb-4 leading-relaxed text-gray-600">
                                        To provide continuous and sustainable employment to all, to strengthen the existing employment facilitation services both local and overseas through the establishment of concrete system and mechanism to effectively address the concern of their constituents information system.
                                    </p>
                                </div>
                                <div class="hidden tabs-content" id="content-vision">
                                    <p class="mb-4 leading-relaxed text-gray-600">
                                        Identification and development of strong workforce led by pro-active and integrity driven leaders that provides suitable job opportunities and updated labor market information.
                                    </p>
                                </div>
                                <div class="hidden tabs-content" id="content-values">
                                    <div class="space-y-4">
                                        <div class="flex items-start space-x-3">
                                            <div class="flex-shrink-0 w-6 h-6 mt-1 rounded-full bg-secondary"></div>
                                            <div>
                                                <h4 class="font-semibold text-primary">Excellence</h4>
                                                <p class="text-sm text-gray-600">We strive for exceptional quality in every service we provide</p>
                                            </div>
                                        </div>
                                        <div class="flex items-start space-x-3">
                                            <div class="flex-shrink-0 w-6 h-6 mt-1 rounded-full bg-secondary"></div>
                                            <div>
                                                <h4 class="font-semibold text-primary">Innovation</h4>
                                                <p class="text-sm text-gray-600">Continuously improving through technology and creative solutions</p>
                                            </div>
                                        </div>
                                        <div class="flex items-start space-x-3">
                                            <div class="flex-shrink-0 w-6 h-6 mt-1 rounded-full bg-secondary"></div>
                                            <div>
                                                <h4 class="font-semibold text-primary">Integrity</h4>
                                                <p class="text-sm text-gray-600">Building trust through transparency and ethical practices</p>
                                            </div>
                                        </div>
                                        <div class="flex items-start space-x-3">
                                            <div class="flex-shrink-0 w-6 h-6 mt-1 rounded-full bg-secondary"></div>
                                            <div>
                                                <h4 class="font-semibold text-primary">Community</h4>
                                                <p class="text-sm text-gray-600">Supporting local economic growth and development</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Tab Content -->
                        </div>
                    </div>

                    <!-- Image/Visual Content (unchanged) -->
                    <div class="flex items-center justify-center">
                        <div class="relative max-w-lg">
                            <img src="assets/images/abt-peso.png"
                                alt="PESO Rosario Team"
                                class="w-full shadow-lg rounded-xl">

                            <!-- Floating Stats Cards -->
                            <div class="absolute p-4 bg-white rounded-lg shadow-lg -top-4 -left-4">
                                <div class="flex items-center space-x-3">
                                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-primary">
                                        <i class="text-white fas fa-users"></i>
                                    </div>
                                    <div>
                                        <p class="text-xl font-bold text-primary">500+</p>
                                        <p class="text-xs text-gray-600">Job Seekers</p>
                                    </div>
                                </div>
                            </div>

                            <div class="absolute p-4 bg-white rounded-lg shadow-lg -bottom-4 -right-4">
                                <div class="flex items-center space-x-3">
                                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-secondary">
                                        <i class="text-white fas fa-building"></i>
                                    </div>
                                    <div>
                                        <p class="text-xl font-bold text-primary">100+</p>
                                        <p class="text-xs text-gray-600">Companies</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Services Section -->
        <section class="relative w-full px-4 py-24 sm:px-6 md:px-16 lg:px-24 bg-gray-50">
            <div class="w-full mx-auto max-w-7xl">
                <div class="mb-12 text-center">
                    <h6 class="mb-2 text-lg font-semibold text-secondary"
                        data-aos="fade-up"
                        data-aos-duration="800">
                        Our Services
                    </h6>
                    <h2 class="mb-6 text-3xl font-bold text-primary lg:text-4xl"
                        data-aos="fade-up"
                        data-aos-duration="800"
                        data-aos-delay="100">
                        How We Help You Succeed
                    </h2>
                    <p class="max-w-2xl mx-auto leading-relaxed text-gray-600"
                        data-aos="fade-up"
                        data-aos-duration="800"
                        data-aos-delay="200">
                        We provide comprehensive employment solutions designed to meet the needs of both job seekers and employers in today's dynamic market.
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                    <!-- Service 1 -->
                    <div class="p-6 transition-all duration-300 bg-white shadow-sm rounded-xl hover:shadow-md hover:transform hover:-translate-y-2"
                        data-aos="fade-up"
                        data-aos-duration="600"
                        data-aos-delay="100">
                        <div class="flex items-center justify-center w-12 h-12 mb-4 rounded-lg bg-primary/10">
                            <i class="text-xl fas fa-search text-primary"></i>
                        </div>
                        <h3 class="mb-3 text-xl font-semibold text-primary">ML-Powered Job Matching</h3>
                        <p class="leading-relaxed text-gray-600">
                            Our intelligent system matches job seekers with opportunities based on skills, experience, and career preferences.
                        </p>
                    </div>

                    <!-- Service 2 -->
                    <div class="p-6 transition-all duration-300 bg-white shadow-sm rounded-xl hover:shadow-md hover:transform hover:-translate-y-2"
                        data-aos="fade-up"
                        data-aos-duration="600"
                        data-aos-delay="200">
                        <div class="flex items-center justify-center w-12 h-12 mb-4 rounded-lg bg-secondary/10">
                            <i class="text-xl fas fa-graduation-cap text-secondary"></i>
                        </div>
                        <h3 class="mb-3 text-xl font-semibold text-primary">Skills Development</h3>
                        <p class="leading-relaxed text-gray-600">
                            Access training programs and workshops to enhance your skills and improve your employability.
                        </p>
                    </div>

                    <!-- Service 3 -->
                    <div class="p-6 transition-all duration-300 bg-white shadow-sm rounded-xl hover:shadow-md hover:transform hover:-translate-y-2"
                        data-aos="fade-up"
                        data-aos-duration="600"
                        data-aos-delay="300">
                        <div class="flex items-center justify-center w-12 h-12 mb-4 rounded-lg bg-primary/10">
                            <i class="text-xl fas fa-handshake text-primary"></i>
                        </div>
                        <h3 class="mb-3 text-xl font-semibold text-primary">Career Counseling</h3>
                        <p class="leading-relaxed text-gray-600">
                            Get personalized guidance from our career experts to help you make informed career decisions.
                        </p>
                    </div>

                    <!-- Service 4 -->
                    <div class="p-6 transition-all duration-300 bg-white shadow-sm rounded-xl hover:shadow-md hover:transform hover:-translate-y-2"
                        data-aos="fade-up"
                        data-aos-duration="600"
                        data-aos-delay="400">
                        <div class="flex items-center justify-center w-12 h-12 mb-4 rounded-lg bg-secondary/10">
                            <i class="text-xl fas fa-calendar-alt text-secondary"></i>
                        </div>
                        <h3 class="mb-3 text-xl font-semibold text-primary">Job Fairs & Events</h3>
                        <p class="leading-relaxed text-gray-600">
                            Participate in our regular job fairs and networking events to connect directly with employers.
                        </p>
                    </div>

                    <!-- Service 5 -->
                    <div class="p-6 transition-all duration-300 bg-white shadow-sm rounded-xl hover:shadow-md hover:transform hover:-translate-y-2"
                        data-aos="fade-up"
                        data-aos-duration="600"
                        data-aos-delay="500">
                        <div class="flex items-center justify-center w-12 h-12 mb-4 rounded-lg bg-primary/10">
                            <i class="text-xl fas fa-chart-line text-primary"></i>
                        </div>
                        <h3 class="mb-3 text-xl font-semibold text-primary">Employer Solutions</h3>
                        <p class="leading-relaxed text-gray-600">
                            Comprehensive recruitment solutions to help businesses find and hire the right talent efficiently.
                        </p>
                    </div>

                    <!-- Service 6 -->
                    <div class="p-6 transition-all duration-300 bg-white shadow-sm rounded-xl hover:shadow-md hover:transform hover:-translate-y-2"
                        data-aos="fade-up"
                        data-aos-duration="600"
                        data-aos-delay="600">
                        <div class="flex items-center justify-center w-12 h-12 mb-4 rounded-lg bg-secondary/10">
                            <i class="text-xl fas fa-headset text-secondary"></i>
                        </div>
                        <h3 class="mb-3 text-xl font-semibold text-primary">24/7 Support</h3>
                        <p class="leading-relaxed text-gray-600">
                            Round-the-clock support to assist you throughout your job search or recruitment process.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Statistics Section -->
        <section class="relative w-full px-4 py-16 text-white sm:px-6 md:px-16 lg:px-24 bg-primary">
            <div class="w-full mx-auto max-w-7xl">
                <div class="grid grid-cols-2 gap-8 text-center md:grid-cols-4">
                    <div>
                        <h3 class="mb-2 text-4xl font-bold">1,000+</h3>
                        <p class="text-white/90">Successful Placements</p>
                    </div>
                    <div>
                        <h3 class="mb-2 text-4xl font-bold">150+</h3>
                        <p class="text-white/90">Partner Companies</p>
                    </div>
                    <div>
                        <h3 class="mb-2 text-4xl font-bold">98%</h3>
                        <p class="text-white/90">Satisfaction Rate</p>
                    </div>
                    <div>
                        <h3 class="mb-2 text-4xl font-bold">5+</h3>
                        <p class="text-white/90">Years of Excellence</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section id="contact" class="relative w-full px-4 py-16 sm:px-6 md:px-16 lg:px-24 ">
            <div class="w-full mx-auto max-w-7xl">
                <div class="mb-12 text-center">
                    <h6 class="mb-2 text-lg font-semibold text-secondary">Get In Touch</h6>
                    <h2 class="mb-6 text-3xl font-bold text-primary lg:text-4xl">
                        Ready to Start Your Journey?
                    </h2>
                    <p class="max-w-2xl mx-auto leading-relaxed text-gray-600">
                        Whether you're looking for your next career opportunity or seeking top talent for your business, we're here to help.
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-12 lg:grid-cols-2">
                    <!-- Contact Information -->
                    <div class="space-y-6">
                        <div class="flex items-start space-x-4">
                            <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 rounded-lg bg-primary">
                                <i class="text-white fas fa-map-marker-alt"></i>
                            </div>
                            <div>
                                <h4 class="mb-1 text-lg font-semibold text-primary">Visit Our Office</h4>
                                <p class="text-gray-600">PESO Rosario, Municipal Hall<br>Rosario, Batangas, Philippines</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 rounded-lg bg-secondary">
                                <i class="text-white fas fa-phone"></i>
                            </div>
                            <div>
                                <h4 class="mb-1 text-lg font-semibold text-primary">Call Us</h4>
                                <p class="text-gray-600">+63 (43) 123-4567<br>+63 (43) 765-4321</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 rounded-lg bg-primary">
                                <i class="text-white fas fa-envelope"></i>
                            </div>
                            <div>
                                <h4 class="mb-1 text-lg font-semibold text-primary">Email Us</h4>
                                <p class="text-gray-600">info@peso-rosario.gov.ph<br>support@sikap-peso.com</p>
                            </div>
                        </div>

                        <!-- Office Hours -->
                        <div class="mt-8 bg-white rounded-xl">
                            <h4 class="mb-4 text-lg font-semibold text-primary">Office Hours</h4>
                            <div class="space-y-2 text-sm text-gray-600">
                                <div class="flex justify-between">
                                    <span>Monday - Friday:</span>
                                    <span>8:00 AM - 5:00 PM</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Saturday:</span>
                                    <span>8:00 AM - 12:00 PM</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Sunday:</span>
                                    <span>Closed</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Form -->
                    <div class="p-8 bg-white shadow-sm rounded-xl">
                        <h3 class="mb-6 text-xl font-semibold text-primary">Send us a Message</h3>
                        <form class="space-y-6">
                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-700">First Name</label>
                                    <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Your first name">
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-700">Last Name</label>
                                    <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Your last name">
                                </div>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-700">Email</label>
                                <input type="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="your@email.com">
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-700">Subject</label>
                                <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                                    <option>General Inquiry</option>
                                    <option>Job Seeker Support</option>
                                    <option>Employer Services</option>
                                    <option>Technical Support</option>
                                </select>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-700">Message</label>
                                <textarea rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Tell us how we can help you..."></textarea>
                            </div>
                            <button type="submit" class="w-full py-4 rounded-lg btn-primary">
                                Send Message
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Include Footer -->
    <?php include_once __DIR__ . '/../components/footer.php'; ?>

    <!-- Scripts -->
    <script>
        // Initialize AOS animations
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true,
            offset: 100
        });

        // Tab functionality
        function showTab(tabName) {
            // Hide all content
            document.querySelectorAll('.tabs-content').forEach(content => {
                content.classList.add('hidden');
            });

            // Remove active class from all tabs
            document.querySelectorAll('.tabs-link').forEach(tab => {
                tab.classList.remove('active');
                tab.classList.add('bg-gray-100', 'text-gray-700', 'hover:bg-primary', 'hover:text-white');
                tab.classList.remove('bg-primary', 'text-white');
            });

            // Show selected content
            document.getElementById('content-' + tabName).classList.remove('hidden');

            // Add active class to selected tab
            const activeTab = document.getElementById('tab-' + tabName);
            activeTab.classList.add('active');
            activeTab.classList.remove('bg-gray-100', 'text-gray-700', 'hover:bg-primary', 'hover:text-white');
            activeTab.classList.add('bg-primary', 'text-white');
        }

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Add floating animation to statistics cards
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.animation = 'floatUp 0.8s ease-out';
                }
            });
        });

        // Observe statistics section
        const statsSection = document.querySelector('.bg-primary');
        if (statsSection) {
            observer.observe(statsSection);
        }
    </script>

    <!-- Add custom CSS for additional animations -->
    <style>
        @keyframes floatUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Enhanced hover effects for service cards */
        .transition-all {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Smooth icon animation on hover */
        .service-card:hover .service-icon {
            transform: scale(1.1);
            transition: transform 0.3s ease;
        }

        /* Text gradient animation */
        @keyframes gradientShift {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .hero-text-animated {
            background-size: 200% 200%;
            animation: gradientShift 3s ease infinite;
        }
    </style>
</body>

</html>