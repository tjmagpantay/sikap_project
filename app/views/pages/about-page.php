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

    <!-- AOS Animation Library -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>

<body class="antialiased font-inter">
    <main class="relative">
        <!-- Hero Section (Component 1) -->
        <?php include_once __DIR__ . '/../components/about-page-1.php'; ?>

        <!-- Mission & Vision Section (Component 2) -->
        <?php include_once __DIR__ . '/../components/about-page-2.php'; ?>

        <!-- Services Section (Component 3) -->
        <?php include_once __DIR__ . '/../components/about-page-3.php'; ?>

        <!-- Contact Section (Component 4) -->
        <?php include_once __DIR__ . '/../components/about-page-4.php'; ?>
    </main>

    <!-- Include Footer -->
    <?php include_once __DIR__ . '/../components/footer.php'; ?>

    <!-- All JavaScript for About Page Components -->
    <script>
        // Initialize AOS animations
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true,
            offset: 100
        });

        // ===== COMPONENT 1: Hero Section JavaScript =====
        document.addEventListener('DOMContentLoaded', function() {
            // Find Jobs button handler
            const findJobsBtn = document.querySelector('button[onmouseover*="092C4C"]');
            if (findJobsBtn) {
                findJobsBtn.addEventListener('click', function() {
                    window.location.href = '?page=browse-jobs';
                });
            }

            // Our Services button handler
            const servicesBtn = document.querySelector('button[onmouseover*="BBDEFB"]');
            if (servicesBtn) {
                servicesBtn.addEventListener('click', function() {
                    // Smooth scroll to services section
                    const servicesSection = document.querySelector('.bg-gray-50') ||
                        document.querySelector('[class*="services"]');
                    if (servicesSection) {
                        servicesSection.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            }
        });

        // ===== COMPONENT 2: Mission & Vision Tab Functionality =====
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
            const selectedContent = document.getElementById('content-' + tabName);
            if (selectedContent) {
                selectedContent.classList.remove('hidden');
            }

            // Add active class to selected tab
            const activeTab = document.getElementById('tab-' + tabName);
            if (activeTab) {
                activeTab.classList.add('active');
                activeTab.classList.remove('bg-gray-100', 'text-gray-700', 'hover:bg-primary', 'hover:text-white');
                activeTab.classList.add('bg-primary', 'text-white');
            }
        }

        // ===== COMPONENT 3: Services Section Animation Observer =====
        document.addEventListener('DOMContentLoaded', function() {
            // Enhanced service card animations
            const serviceCards = document.querySelectorAll('.hover\\:transform');
            serviceCards.forEach((card, index) => {
                // Add staggered animation delay
                card.style.animationDelay = `${index * 100}ms`;

                // Enhanced hover effects
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-8px) scale(1.02)';
                    this.style.boxShadow = '0 20px 40px rgba(0, 0, 0, 0.15)';
                });

                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                    this.style.boxShadow = '';
                });
            });

            // Intersection observer for service cards
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const serviceObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);

            // Observe all service cards
            serviceCards.forEach(card => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
                serviceObserver.observe(card);
            });
        });

        // ===== COMPONENT 4: Contact Form Handler =====
        document.addEventListener('DOMContentLoaded', function() {
            const contactForm = document.querySelector('#contact form');
            if (contactForm) {
                contactForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    // Get form data
                    const firstName = this.querySelector('input[placeholder*="first name"]');
                    const lastName = this.querySelector('input[placeholder*="last name"]');
                    const email = this.querySelector('input[type="email"]');
                    const subject = this.querySelector('select');
                    const message = this.querySelector('textarea');

                    // Basic validation
                    if (!firstName.value.trim() || !lastName.value.trim() || !email.value.trim() || !message.value.trim()) {
                        alert('Please fill in all required fields.');
                        // Highlight empty fields
                        [firstName, lastName, email, message].forEach(field => {
                            if (!field.value.trim()) {
                                field.style.borderColor = '#ef4444';
                                field.style.animation = 'shake 0.5s ease-in-out';
                            }
                        });
                        return;
                    }

                    // Email validation
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(email.value)) {
                        alert('Please enter a valid email address.');
                        email.style.borderColor = '#ef4444';
                        return;
                    }

                    // Get submit button
                    const submitButton = this.querySelector('button[type="submit"]');
                    const originalText = submitButton.textContent;

                    // Show loading state
                    submitButton.textContent = 'Sending Message...';
                    submitButton.disabled = true;
                    submitButton.style.opacity = '0.7';
                    submitButton.style.cursor = 'not-allowed';

                    // Simulate form submission
                    setTimeout(() => {
                        // Success feedback
                        alert('Thank you for your message! We will get back to you within 24 hours.');

                        // Reset form
                        this.reset();

                        // Reset button
                        submitButton.textContent = originalText;
                        submitButton.disabled = false;
                        submitButton.style.opacity = '1';
                        submitButton.style.cursor = 'pointer';

                        // Reset field border colors
                        [firstName, lastName, email, message].forEach(field => {
                            field.style.borderColor = '';
                        });

                        // Show success animation
                        const successMessage = document.createElement('div');
                        successMessage.innerHTML = `
                            <div class="fixed z-50 px-6 py-3 text-white transition-transform duration-300 transform translate-x-full bg-green-500 rounded-lg shadow-lg top-4 right-4">
                                <div class="flex items-center">
                                    <i class="mr-2 fas fa-check-circle"></i>
                                    Message sent successfully!
                                </div>
                            </div>
                        `;
                        document.body.appendChild(successMessage);

                        // Animate success message
                        setTimeout(() => {
                            successMessage.firstElementChild.style.transform = 'translateX(0)';
                        }, 100);

                        // Remove success message after 3 seconds
                        setTimeout(() => {
                            successMessage.firstElementChild.style.transform = 'translateX(full)';
                            setTimeout(() => {
                                document.body.removeChild(successMessage);
                            }, 300);
                        }, 3000);

                    }, 2000); // Simulate 2 second API call
                });

                // Real-time form validation
                const formFields = contactForm.querySelectorAll('input, textarea, select');
                formFields.forEach(field => {
                    field.addEventListener('input', function() {
                        if (this.value.trim()) {
                            this.style.borderColor = '#10b981'; // Green border for filled fields
                            this.style.animation = '';
                        } else {
                            this.style.borderColor = '';
                        }
                    });

                    field.addEventListener('focus', function() {
                        this.style.borderColor = '#092C4C'; // Primary color on focus
                        this.style.boxShadow = '0 0 0 3px rgba(9, 44, 76, 0.1)';
                    });

                    field.addEventListener('blur', function() {
                        this.style.boxShadow = '';
                    });
                });
            }
        });

        // ===== GENERAL: Smooth scrolling for anchor links =====
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

        // ===== GENERAL: Floating statistics cards animation =====
        const statsObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    // Add floating animation to stat cards
                    const statCards = entry.target.querySelectorAll('.shadow-lg');
                    statCards.forEach((card, index) => {
                        setTimeout(() => {
                            card.style.animation = 'floatUp 0.8s ease-out forwards';
                            // Add continuous floating effect
                            setTimeout(() => {
                                card.classList.add('floating-card');
                            }, 800);
                        }, index * 200);
                    });
                }
            });
        }, {
            threshold: 0.3
        });

        // Observe the mission section for stats animation
        document.addEventListener('DOMContentLoaded', function() {
            const missionSection = document.querySelector('#mission');
            if (missionSection) {
                statsObserver.observe(missionSection);
            }
        });
    </script>

    <!-- Enhanced CSS Animations -->
    <style>
        /* Float up animation for statistics */
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

        /* Continuous floating animation */
        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .floating-card {
            animation: float 3s ease-in-out infinite;
        }

        .floating-card:nth-child(2) {
            animation-delay: 1.5s;
        }

        /* Shake animation for form validation */
        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-5px);
            }

            75% {
                transform: translateX(5px);
            }
        }

        /* Enhanced hover effects */
        .transition-all {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Service card hover effects */
        .hover\:transform:hover {
            transform: translateY(-8px) scale(1.02) !important;
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

        /* Form enhancements */
        input:focus,
        textarea:focus,
        select:focus {
            transform: translateY(-2px);
            transition: all 0.3s ease;
        }

        /* Button hover animations */
        button {
            transition: all 0.3s ease;
        }

        button:hover {
            transform: translateY(-2px);
        }

        button:disabled {
            transform: none !important;
        }

        /* Tab smooth transitions */
        .tabs-link {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Enhanced shadow effects */
        .shadow-lg {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        /* Loading state */
        .loading {
            position: relative;
            overflow: hidden;
        }

        .loading::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            animation: loading 1.5s infinite;
        }

        @keyframes loading {
            0% {
                left: -100%;
            }

            100% {
                left: 100%;
            }
        }
    </style>
</body>

</html>