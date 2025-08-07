<?php
include_once __DIR__ . '/../components/navbar-top.php';
include_once __DIR__ . '/../components/navbar.php';
?>
<div class="flex items-center justify-center px-2 py-8 bg-gray-50">
    <div class="flex flex-col-reverse max-w-2xl overflow-hidden bg-white shadow-lg md:flex-row rounded-xl">
        <!-- Left: Login Card -->
        <div class="flex flex-col justify-center w-full px-6 py-8 md:w-full">
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
                    <div class="relative">
                        <input id="password" name="password" type="password" required
                            class="block w-full px-3 py-2 pr-10 mt-1 placeholder-gray-400 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-secondary focus:border-secondary">
                        <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600">
                            <i id="password-icon" class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                <div class="flex justify-end mt-2">
                    <a href="?page=forgot-password" class="text-sm text-secondary hover:underline">Forgot Password?</a>
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
                    <a href="?page=signup-employer" class="font-medium text-secondary hover:underline">Sign Up as Employer</a>
                </p>
                <p class="text-sm text-gray-600">
                    Looking for a job?
                    <a href="?page=login-jobseeker" class="font-medium text-primary hover:underline">Jobseeker Sign In</a>
                </p>
            </div>
        </div>

        <!-- Right: Image Carousel -->
        <div class="items-center justify-center hidden bg-gray-100 md:flex md:w-2/5">
            <div class="relative w-full h-full">
                <!-- Carousel container -->
                <div class="relative w-full h-full carousel-container">
                    <!-- Images with gradient overlay -->
                    <div class="absolute inset-0 transition-opacity duration-1000 ease-in-out opacity-100 carousel-slide">
                        <div class="absolute inset-0 bg-gradient-to-t from-secondary/60 to-transparent"></div>
                        <img src="./assets/images/hero-page-img.png" alt="Employer 1" class="object-cover w-full h-full">
                    </div>
                    <div class="absolute inset-0 transition-opacity duration-1000 ease-in-out opacity-0 carousel-slide">
                        <div class="absolute inset-0 bg-gradient-to-t from-secondary/60 to-transparent"></div>
                        <img src="./assets/images/hero-page-img.png" alt="Employer 2" class="object-cover w-full h-full">
                    </div>
                    <div class="absolute inset-0 transition-opacity duration-1000 ease-in-out opacity-0 carousel-slide">
                        <div class="absolute inset-0 bg-gradient-to-t from-secondary/60 to-transparent"></div>
                        <img src="./assets/images/hero-page-img.png" alt="Employer 3" class="object-cover w-full h-full">
                    </div>
                </div>

                <!-- Carousel indicators -->
                <div class="absolute left-0 right-0 flex justify-center space-x-2 bottom-4">
                    <button class="w-2 h-2 bg-white rounded-full opacity-100 carousel-indicator"></button>
                    <button class="w-2 h-2 bg-white rounded-full opacity-50 carousel-indicator"></button>
                    <button class="w-2 h-2 bg-white rounded-full opacity-50 carousel-indicator"></button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Password toggle functionality
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const passwordIcon = document.getElementById('password-icon');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            passwordIcon.classList.remove('fa-eye');
            passwordIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            passwordIcon.classList.remove('fa-eye-slash');
            passwordIcon.classList.add('fa-eye');
        }
    }

    // Carousel functionality
    document.addEventListener('DOMContentLoaded', function() {
        const slides = document.querySelectorAll('.carousel-slide');
        const indicators = document.querySelectorAll('.carousel-indicator');
        const carouselContainer = document.querySelector('.carousel-container');
        let currentSlide = 0;
        let slideInterval = setInterval(nextSlide, 4000);

        // Initialize first slide
        showSlide(0);

        // Show a specific slide
        function showSlide(index) {
            slides.forEach((slide, i) => {
                slide.classList.toggle('opacity-0', i !== index);
                slide.classList.toggle('opacity-100', i === index);
                indicators[i].classList.toggle('opacity-50', i !== index);
                indicators[i].classList.toggle('opacity-100', i === index);
            });
            currentSlide = index;
        }

        // Go to next slide
        function nextSlide() {
            const newIndex = (currentSlide + 1) % slides.length;
            showSlide(newIndex);
        }

        // Handle indicator clicks
        indicators.forEach((indicator, index) => {
            indicator.addEventListener('click', () => {
                clearInterval(slideInterval);
                showSlide(index);
                slideInterval = setInterval(nextSlide, 4000);
            });
        });

        // Pause carousel on hover
        carouselContainer.addEventListener('mouseenter', () => {
            clearInterval(slideInterval);
        });

        // Resume carousel when mouse leaves
        carouselContainer.addEventListener('mouseleave', () => {
            slideInterval = setInterval(nextSlide, 4000);
        });
    });
</script>