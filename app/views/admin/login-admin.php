<?php
include_once __DIR__ . '/../components/navbar-top.php';
include_once __DIR__ . '/components/navbar-admin.php';
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="flex items-center justify-center px-4 py-12">
    <div class="flex flex-col-reverse w-full max-w-2xl overflow-hidden bg-white shadow-lg md:flex-row rounded-xl">
        <!-- Left: Login Card -->
        <div class="flex flex-col justify-center w-full px-6 py-8 md:w-1/2 lg:px-12">
            <div class="mb-6 text-center">

                <h2 class="text-3xl font-bold text-gray-900">Admin Portal</h2>
                <p class="mt-2 text-sm text-gray-600">Administrative access only</p>
            </div>

            <?php if (!empty($error)): ?>
                <div class="px-4 py-3 mb-6 text-red-600 border border-red-200 rounded-md bg-red-50">
                    <div class="flex items-center">
                        <i class="mr-2 fas fa-exclamation-triangle"></i>
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php
            $isLocked = isset($_SESSION['login_attempts']) && $_SESSION['login_attempts'] >= 5 &&
                (time() - $_SESSION['last_attempt_time']) < 300;
            ?>

            <form class="space-y-5" method="POST" action="?page=admin-login" id="adminLoginForm">
                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input id="email" name="email" type="email" required
                        placeholder="Enter admin email"
                        maxlength="255"
                        pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}"
                        class="block w-full px-3 py-3 mt-1 text-sm transition-colors border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary"
                        <?php echo $isLocked ? 'disabled' : ''; ?>>
                    <div class="hidden mt-1 text-xs text-red-600" id="email-error"></div>
                </div>

                <!-- Password -->
                <div class="mt-2">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <div class="relative">
                        <input id="password" name="password" type="password" required
                            placeholder="Enter admin password"
                            minlength="6"
                            maxlength="100"
                            class="block w-full px-3 py-3 pr-12 mt-1 text-sm transition-colors border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary"
                            <?php echo $isLocked ? 'disabled' : ''; ?>>
                        <button type="button" onclick="togglePassword()"
                            class="absolute text-gray-400 transition-colors transform -translate-y-1/2 right-3 top-1/2 hover:text-gray-600 focus:outline-none"
                            <?php echo $isLocked ? 'disabled' : ''; ?>>
                            <svg id="password-icon-show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            <svg id="password-icon-hide" class="hidden w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="hidden mt-1 text-xs text-red-600" id="password-error"></div>
                </div>

                <!-- Submit -->
                <button type="submit"
                    class="w-full px-4 py-3 mt-4 text-sm font-semibold text-white transition-all duration-200 rounded-md shadow bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2"
                    <?php echo $isLocked ? 'disabled style="cursor:not-allowed;opacity:0.6;"' : ''; ?>>
                    Access Admin Dashboard
                </button>
            </form>

            <?php if ($isLocked): ?>
                <div class="p-3 mt-4 border border-yellow-200 rounded-md bg-yellow-50">
                    <div class="flex items-center">
                        <i class="mr-2 text-yellow-600 fas fa-lock"></i>
                        <p class="text-sm text-yellow-700">
                            Account temporarily locked due to multiple failed attempts. Try again in 5 minutes.
                        </p>
                    </div>
                </div>
            <?php endif; ?>

        </div>

        <!-- Right: Image Carousel -->
        <div class="items-center justify-center hidden bg-gray-100 md:flex md:w-1/2">
            <div class="relative w-full h-full min-h-[500px] overflow-hidden rounded-r-xl">

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
                <div class="absolute z-20 flex gap-2 transform -translate-x-1/2 bottom-4 left-1/2">
                    <div class="w-3 h-3 transition-all duration-500 ease-in-out rounded-full cursor-pointer carousel-dot bg-white/80 hover:bg-white"></div>
                    <div class="w-3 h-3 transition-all duration-500 ease-in-out rounded-full cursor-pointer carousel-dot bg-white/80 hover:bg-white"></div>
                    <div class="w-3 h-3 transition-all duration-500 ease-in-out rounded-full cursor-pointer carousel-dot bg-white/80 hover:bg-white"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Admin notice placed below the card -->
<div class="text-center">
    <p class="text-xs text-gray-600">
        This login is for administrators only.
    </p>
</div>

<script>
    // Enhanced form validation
    document.getElementById("adminLoginForm").addEventListener("submit", function(e) {
        const email = document.getElementById("email").value.trim();
        const password = document.getElementById("password").value.trim();
        const emailError = document.getElementById("email-error");
        const passwordError = document.getElementById("password-error");

        // Clear previous errors
        emailError.classList.add('hidden');
        passwordError.classList.add('hidden');
        emailError.textContent = '';
        passwordError.textContent = '';

        let hasErrors = false;

        // Email validation
        if (!email) {
            showFieldError("email-error", "Email is required");
            hasErrors = true;
        } else if (email.length > 255) {
            showFieldError("email-error", "Email must not exceed 255 characters");
            hasErrors = true;
        } else {
            const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            if (!emailPattern.test(email)) {
                showFieldError("email-error", "Please enter a valid email address");
                hasErrors = true;
            }
        }

        // Password validation
        if (!password) {
            showFieldError("password-error", "Password is required");
            hasErrors = true;
        } else if (password.length < 6) {
            showFieldError("password-error", "Password must be at least 6 characters long");
            hasErrors = true;
        } else if (password.length > 100) {
            showFieldError("password-error", "Password must not exceed 100 characters");
            hasErrors = true;
        }

        if (hasErrors) {
            e.preventDefault();
            Swal.fire({
                icon: "error",
                title: "Validation Error",
                text: "Please correct the errors in the form before submitting.",
                confirmButtonColor: "#2563eb"
            });
            return;
        }

        // Additional client-side security checks
        if (password.includes('<') || password.includes('>') || password.includes('&')) {
            e.preventDefault();
            showFieldError("password-error", "Password contains invalid characters");
            Swal.fire({
                icon: "error",
                title: "Invalid Characters",
                text: "Password contains characters that are not allowed.",
                confirmButtonColor: "#2563eb"
            });
            return;
        }
    });

    // Real-time validation
    document.getElementById("email").addEventListener("blur", function() {
        const email = this.value.trim();
        const emailError = document.getElementById("email-error");

        if (email && email.length > 255) {
            showFieldError("email-error", "Email must not exceed 255 characters");
        } else if (email) {
            const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            if (!emailPattern.test(email)) {
                showFieldError("email-error", "Please enter a valid email address");
            } else {
                emailError.classList.add('hidden');
            }
        }
    });

    document.getElementById("password").addEventListener("blur", function() {
        const password = this.value;
        const passwordError = document.getElementById("password-error");

        if (password && password.length < 6) {
            showFieldError("password-error", "Password must be at least 6 characters long");
        } else if (password && password.length > 100) {
            showFieldError("password-error", "Password must not exceed 100 characters");
        } else if (password) {
            passwordError.classList.add('hidden');
        }
    });

    function showFieldError(elementId, message) {
        const errorElement = document.getElementById(elementId);
        errorElement.textContent = message;
        errorElement.classList.remove('hidden');
    }

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
        if (images.length > 0 && dots.length > 0) {
            showImage(0);

            // Auto-change images every 4 seconds
            setInterval(nextImage, 4000);

            // Click dots to change image
            dots.forEach((dot, index) => {
                dot.addEventListener('click', () => {
                    if (currentIndex !== index) {
                        currentIndex = index;
                        showImage(currentIndex);
                    }
                });
            });
        }
    });
</script>