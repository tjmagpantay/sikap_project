<?php
include_once __DIR__ . '/../components/navbar-top.php';
include_once __DIR__ . '/../components/navbar.php';
?>
<div class="flex items-center justify-center px-4 py-8 ">
    <div class="flex flex-col-reverse w-full max-w-2xl overflow-hidden bg-white shadow-lg md:flex-row rounded-xl">
        <!-- Left: Login Card -->
        <div class="flex flex-col justify-center w-full px-6 py-8 md:w-1/2 lg:px-12">
            <h2 class="mb-4 text-3xl font-bold text-gray-900">Employer Login</h2>
            <p class="mb-6 text-sm text-gray-600">Sign in to your employer account</p>
            <?php if (!empty($error)): ?>
                <div class="px-4 py-3 mb-6 text-red-600 border border-red-200 rounded-md bg-red-50">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form class="space-y-5" method="POST" action="?page=login-employer">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input id="email" name="email" type="email" required
                        value="<?php echo htmlspecialchars($formData['email'] ?? ''); ?>"
                        class="block w-full px-3 py-2 mt-1 placeholder-gray-400 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-secondary focus:border-secondary">
                </div>
                <div class="mt-2">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <div class="relative mt-1">
                        <input id="password" name="password" type="password" required
                            class="block w-full px-3 py-2 pr-12 text-sm placeholder-gray-400 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-secondary focus:border-secondary">
                        <button type="button" onclick="togglePassword()" class="absolute text-gray-400 transform -translate-y-1/2 top-1/2 right-3 hover:text-gray-600 focus:outline-none">
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
                <div class="flex justify-end mt-2">
                    <a href="?page=forgot-password" class="text-sm text-primaryhover:underline">Forgot Password?</a>
                </div>
                <button type="submit"
                    class="justify-end w-full px-4 py-3 mt-4 text-sm font-semibold text-white rounded-md shadow bg-secondary hover:bg-secondary/90 focus:outline-none focus:ring-2 focus:ring-secondary focus:ring-offset-2">
                    Sign In
                </button>
            </form>

            <!-- Or Separator -->
            <div class="flex items-center justify-center py-2 my-6">
                <div class="flex-grow border-t border-gray-400"></div>
                <span class="px-2 mx-4 text-sm font-medium text-gray-600 bg-white">or</span>
                <div class="flex-grow border-t border-gray-400"></div>
            </div>

            <!-- Google Sign In -->
            <a href="?page=google-login&type=employer"
                class="flex items-center justify-center w-full px-4 py-3 mb-4 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-secondary focus:ring-offset-2">
                <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" alt="Google logo" class="w-5 h-5 mr-2">
                Sign in with Google
            </a>

            <!-- Sign Up Link -->
            <div class="mt-4 text-center">
                <p class="mb-2 text-sm text-gray-600">
                    Don't have an account?
                    <a href="?page=signup-employer" class="font-medium text-secondary hover:underline">Sign Up </a>
                </p>
                <p class="text-sm text-gray-600">
                    Looking for a job?
                    <a href="?page=login-jobseeker" class="font-medium text-primary hover:underline">Jobseeker Sign In</a>
                </p>
            </div>
        </div>

        <!-- Right: Image Carousel -->
        <div class="items-center justify-center hidden bg-gray-100 md:flex md:w-1/2">
            <div class="relative w-full h-full min-h-[500px] overflow-hidden rounded-r-xl">

                <!-- Carousel Images -->
                <div id="carousel" class="relative w-full h-full">
                    <img src="../public/assets/images/login-img-1.webp"
                        alt="Employer 1"
                        class="absolute inset-0 object-cover w-full h-full transition-all ease-in-out transform scale-100 opacity-100 carousel-img duration-1500" />
                    <img src="../public/assets/images/login-img-2.png"
                        alt="Employer 2"
                        class="absolute inset-0 object-cover w-full h-full transition-all ease-in-out transform scale-105 opacity-0 carousel-img duration-1500" />
                    <img src="../public/assets/images/login-img-3.png"
                        alt="Employer 3"
                        class="absolute inset-0 object-cover w-full h-full transition-all ease-in-out transform scale-105 opacity-0 carousel-img duration-1500" />
                </div>

                <!-- Gradient Overlay -->
                <div class="absolute inset-0 z-10"
                    style="background: linear-gradient(to top, #F3AF0E -100%, rgba(255,255,255,0.3) 100%);">
                </div>

                <!-- Optional: Carousel Indicators -->
                <div class="absolute z-20 flex gap-2 transform -translate-x-1/2 bottom-4 left-1/2">
                    <div class="w-3 h-3 transition-all duration-500 ease-in-out rounded-full cursor-pointer carousel-dot bg-white/80 hover:bg-white"></div>
                    <div class="w-3 h-3 transition-all duration-500 ease-in-out rounded-full cursor-pointer carousel-dot bg-white/80 hover:bg-white"></div>
                    <div class="w-3 h-3 transition-all duration-500 ease-in-out rounded-full cursor-pointer carousel-dot bg-white/80 hover:bg-white"></div>
                </div>
            </div>
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

        // Auto-change images every 4 seconds (increased for smoother experience)
        setInterval(nextImage, 4000);

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