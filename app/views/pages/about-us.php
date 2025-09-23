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