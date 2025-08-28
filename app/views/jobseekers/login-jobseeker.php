<?php
include_once __DIR__ . '/../components/navbar-top.php';
include_once __DIR__ . '/../components/navbar.php';
?>

<div class="flex items-center justify-center px-4 py-12 ">
    <div class="w-full max-w-2xl">
        <div class="flex flex-col-reverse w-full max-w-2xl overflow-hidden bg-white md:flex-row rounded-xl" style="box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);">
            <!-- Left: Login Card -->
            <div class="flex flex-col justify-center w-full px-6 py-8 md:w-1/2 lg:px-12 xl:px-16">
                <div class="w-full max-w-sm mx-auto">
                    <h2 class="mb-2 text-3xl font-bold text-grayMain">Login</h2>
                    <p class="mb-6 text-sm text-gray-600">Sign in to your jobseeker account</p>
                    <?php if (!empty($error)): ?>
                        <div class="px-4 py-3 mb-6 text-red-600 border border-red-200 rounded-lg bg-red-50">
                            <?php echo htmlspecialchars($error); ?>
                        </div>
                    <?php endif; ?>

                    <form class="space-y-6" method="POST" action="?page=login-jobseeker">
                        <div class="space-y-2">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input id="email" name="email" type="email" required
                                value="<?php echo htmlspecialchars($formData['email'] ?? ''); ?>"
                                class="block w-full px-3 py-3 text-sm placeholder-gray-400 transition-colors border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
                        </div>
                        <div class="space-y-2">
                            <div class="flex items-center justify-between">
                                <label for="password" class="text-sm font-medium text-gray-700">Password</label>
                                <a href="?page=forgot-password" class="text-sm transition-colors text-primary hover:text-primary/80">
                                    Forgot password?
                                </a>
                            </div>
                            <div class="relative">
                                <input id="password" name="password" type="password" required
                                    class="w-full px-3 py-3 pr-12 text-sm placeholder-gray-400 transition-colors border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
                                <button type="button" onclick="togglePassword()" class="absolute text-gray-400 transition-colors transform -translate-y-1/2 right-3 top-1/2 hover:text-gray-600 focus:outline-none">
                                    <svg id="password-icon-show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    <svg id="password-icon-hide" class="hidden w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <button type="submit"
                            class="w-full px-4 py-3 text-sm font-semibold text-white transition-all duration-200 rounded-lg shadow-md bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
                            Sign In
                        </button>
                    </form>

                    <!-- Or Separator with shadcn style -->
                    <div class="relative py-3 text-sm text-center after:absolute after:inset-0 after:top-1/2 after:z-0 after:flex after:items-center after:border-t after:border-gray-300">
                        <span class="relative z-10 px-3 text-gray-600 bg-white">
                            or continue with
                        </span>
                    </div>

                    <!-- Google Sign In -->
                    <a href="?page=google-login&type=jobseeker"
                        class="flex items-center justify-center w-full px-4 py-3 mb-6 text-sm font-medium text-gray-700 transition-all duration-200 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
                        <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" alt="Google logo" class="w-5 h-5 mr-3">
                        Sign in with Google
                    </a>

                    <!-- Sign Up Link -->
                    <div class="space-y-3 text-center">
                        <p class="text-sm text-gray-600">
                            Don't have an account?
                            <a href="?page=signup-jobseeker" class="font-medium transition-colors text-primary hover:text-primary/80">Sign Up</a>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Right: Image Carousel -->
            <div class="items-center justify-center hidden bg-gray-100 md:flex md:w-1/2">
                <div class="relative w-full h-full min-h-[500px] overflow-hidden rounded-r-lg">

                    <!-- Carousel Images -->
                    <div id="carousel" class="relative w-full h-full">
                        <img src="../public/assets/images/login-img-1.webp"
                            alt="Jobseekers 1"
                            class="absolute inset-0 object-cover w-full h-full transition-all ease-in-out transform scale-100 opacity-100 carousel-img duration-1500" />
                        <img src="../public/assets/images/login-img-2.png"
                            alt="Jobseekers 2"
                            class="absolute inset-0 object-cover w-full h-full transition-all ease-in-out transform scale-105 opacity-0 carousel-img duration-1500" />
                        <img src="../public/assets/images/login-img-3.png"
                            alt="Jobseekers 3"
                            class="absolute inset-0 object-cover w-full h-full transition-all ease-in-out transform scale-105 opacity-0 carousel-img duration-1500" />
                    </div>

                    <!-- Gradient Overlay -->
                    <div class="absolute inset-0 z-10"
                        style="background: linear-gradient(to top, #092C4C -20%, rgba(255,255,255,0.2) 100%);">
                    </div>

                    <!-- Optional: Carousel Indicators -->
                    <div class="absolute z-20 flex gap-2 transform -translate-x-1/2 bottom-6 left-1/2">
                        <div class="w-3 h-3 transition-all duration-500 ease-in-out rounded-full cursor-pointer carousel-dot bg-white/80 hover:bg-white"></div>
                        <div class="w-3 h-3 transition-all duration-500 ease-in-out rounded-full cursor-pointer carousel-dot bg-white/80 hover:bg-white"></div>
                        <div class="w-3 h-3 transition-all duration-500 ease-in-out rounded-full cursor-pointer carousel-dot bg-white/80 hover:bg-white"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Employer sign in link placed below the card -->
        <div class="mt-6 text-center">
            <p class="text-xs text-gray-600">
                Are you an employer?
                <a href="?page=login-employer" class="font-medium underline transition-colors text-primary hover:text-secondary/80 underline-offset-2">
                    Employer Sign In
                </a>
            </p>
        </div>
    </div>
</div>

<script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const showIcon = document.getElementById('password-icon-show');
        const hideIcon = document.getElementById('password-icon-hide');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            showIcon.classList.add('hidden');
            hideIcon.classList.remove('hidden');
        } else {
            passwordInput.type = 'password';
            hideIcon.classList.add('hidden');
            showIcon.classList.remove('hidden');
        }
    }

    // Image Carousel
    document.addEventListener('DOMContentLoaded', function() {
        const images = document.querySelectorAll('.carousel-img');
        const dots = document.querySelectorAll('.carousel-dot');
        let currentIndex = 0;

        function showImage(index) {
            // Hide all images with smooth transition
            images.forEach((img, i) => {
                img.classList.remove('opacity-100', 'scale-100');
                img.classList.add('opacity-0', 'scale-105');
            });

            // Reset all dots with smooth animation
            dots.forEach((dot, i) => {
                dot.classList.remove('bg-white', 'scale-110', 'shadow-lg');
                dot.classList.add('bg-white/80', 'scale-100');
            });

            // Show current image with smooth transition
            setTimeout(() => {
                images[index].classList.remove('opacity-0', 'scale-105');
                images[index].classList.add('opacity-100', 'scale-100');
            }, 50);

            // Animate current dot
            dots[index].classList.remove('bg-white/80', 'scale-100');
            dots[index].classList.add('bg-white', 'scale-110', 'shadow-lg');
        }

        function nextImage() {
            currentIndex = (currentIndex + 1) % images.length;
            showImage(currentIndex);
        }

        // Initialize first dot
        showImage(0);

        // Auto-change images every 3 seconds (increased for smoother experience)
        setInterval(nextImage, 3000);

        // Click dots to change image with smooth transition
        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                if (currentIndex !== index) {
                    currentIndex = index;
                    showImage(currentIndex);
                }
            });
        });
    });
</script>