<?php
include_once __DIR__ . '/../components/navbar-top.php';
include_once __DIR__ . '/components/navbar-admin.php';
?>

<div class="flex items-center justify-center px-4 py-16 ">
    <div class="flex flex-col-reverse w-full max-w-2xl overflow-hidden bg-white shadow-lg md:flex-row rounded-xl">
        <!-- Left: Login Card -->
        <div class="flex flex-col justify-center w-full px-6 py-8 md:w-1/2 lg:px-12">
            <div class="mb-6 text-center">
                <div class="flex justify-center mb-4">
                    <div class="p-3 bg-blue-100 rounded-full">
                        <i class="text-2xl text-white fas fa-shield-alt"></i>
                    </div>
                </div>
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

            <form class="space-y-5" method="POST" action="?page=admin-login">
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input id="email" name="email" type="email" required
                        placeholder="Enter admin email"
                        class="block w-full px-3 py-2 mt-1 text-sm placeholder-gray-400 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="mt-2">
                     <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <div class="relative mt-1">
                        <input id="password" name="password" type="password" required
                            placeholder="Enter admin password"
                            class="block w-full px-3 py-2 pr-12 text-sm placeholder-gray-400 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
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

                <button type="submit"
                    class="justify-end w-full px-4 py-3 mt-4 text-sm font-semibold text-white rounded-md shadow bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
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
</script>