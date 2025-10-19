<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="/sikap/public/assets/css/output.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="./assets/images/sikap-logo.png">
    <title>Page Not Found - SIKAP</title>
</head>
<body class="font-inter">
    <!-- 404 Error Section -->
    <section class="flex items-center justify-center min-h-screen px-4 py-16 bg-gradient-to-br from-gray-50 via-blue-50/30 to-white sm:px-6 md:px-16 lg:px-24">
        <div class="max-w-4xl mx-auto text-center">
            <!-- Error Image Container -->
            <div class="flex justify-center mb-8">
                <div class="flex items-center justify-center w-64 h-64 rounded-full bg-primary/10">
                    <!-- You can replace this with your custom image later -->
                    <div class="font-bold text-8xl text-primary">404</div>
                </div>
            </div>

            <!-- Error Content -->
            <div class="space-y-6">
                <h1 class="text-4xl font-bold text-primary lg:text-5xl">
                    Page Not Found
                </h1>
                
                <p class="max-w-2xl mx-auto text-lg text-gray-600">
                    Oops! The page you're looking for doesn't exist or has been moved. 
                    Don't worry, let's get you back on track.
                </p>

                
                <!-- Quick Links -->
                <div class="pt-8 mt-12 ">
                    <h3 class="mb-4 text-lg font-semibold text-primary">
                        Quick Links
                    </h3>
                    <div class="flex flex-wrap justify-center gap-6 text-sm">
                        <a href="?page=about-page" class="text-gray-600 transition-colors hover:text-primary">
                            About Us
                        </a>
                        <a href="?page=program-events" class="text-gray-600 transition-colors hover:text-primary">
                            Programs & Events
                        </a>
                        <a href="?page=login-jobseeker" class="text-gray-600 transition-colors hover:text-primary">
                            Job Seeker Login
                        </a>
                        <a href="?page=login-employer" class="text-gray-600 transition-colors hover:text-primary">
                            Employer Login
                        </a>
                        <a href="?page=contact-support" class="text-gray-600 transition-colors hover:text-primary">
                            Contact Support
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        /* Add subtle animation to the error container */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .max-w-4xl {
            animation: fadeInUp 0.6s ease-out;
        }

        /* Floating animation for the 404 number */
        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        .w-64.h-64 div {
            animation: float 3s ease-in-out infinite;
        }
    </style>
</body>
</html>