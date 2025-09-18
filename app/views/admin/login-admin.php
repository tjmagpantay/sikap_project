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

            <form class="space-y-5" method="POST" action="?page=admin-login">
                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input id="email" name="email" type="email" required
                        placeholder="Enter admin email"
                        class="block w-full px-3 py-3 mt-1 text-sm border rounded-md shadow-sm"
                        <?php echo $isLocked ? 'disabled' : ''; ?>>
                </div>

                <!-- Password -->
                <div class="mt-2">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input id="password" name="password" type="password" required
                        placeholder="Enter admin password"
                        class="block w-full px-3 py-3 mt-1 text-sm border rounded-md shadow-sm"
                        <?php echo $isLocked ? 'disabled' : ''; ?>>
                </div>

                <!-- Submit -->
                <button type="submit"
                    class="w-full px-4 py-3 mt-4 text-sm font-semibold text-white rounded-md shadow bg-primary hover:bg-primary/90"
                    <?php echo $isLocked ? 'disabled style="cursor:not-allowed;opacity:0.6;"' : ''; ?>>
                    Access Admin Dashboard
                </button>
            </form>




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
        <!-- Employer sign in link placed below the card -->
        <div class="text-center ">
            <p class="text-xs text-gray-600">
                This login is for administrators only. 
            </p>
        </div>

<script>
    document.querySelector("form").addEventListener("submit", function(e) {
        const email = document.getElementById("email").value.trim();
        const password = document.getElementById("password").value.trim();

        // Basic email format check
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (!email || !password) {
            e.preventDefault(); // stop form from submitting
            Swal.fire({
                icon: "warning",
                title: "Missing Fields",
                text: "Please enter both email and password.",
                confirmButtonColor: "#2563eb"
            });
            return;
        }

        if (!emailPattern.test(email)) {
            e.preventDefault();
            Swal.fire({
                icon: "error",
                title: "Invalid Email",
                text: "Please enter a valid email address.",
                confirmButtonColor: "#2563eb"
            });
            return;
        }

        if (password.length < 6) {
            e.preventDefault();
            Swal.fire({
                icon: "error",
                title: "Wrong Password",
                text: "Try again.",
                confirmButtonColor: "#2563eb"
            });
            return;
        }
    });

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
</script>