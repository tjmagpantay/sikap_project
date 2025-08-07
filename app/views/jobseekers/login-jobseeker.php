<?php
include_once __DIR__ . '/../components/navbar-top.php';
include_once __DIR__ . '/../components/navbar.php';
?>

<div class="flex items-center justify-center px-2 py-8 bg-gray-50">
    <div class="flex flex-col-reverse max-w-2xl overflow-hidden bg-white shadow-lg md:flex-row rounded-xl">
        <!-- Left: Login Card -->
        <div class="flex flex-col justify-center w-full px-6 py-8 md:w-1/2">
            <h2 class="mb-4 text-3xl font-bold text-gray-900">Login</h2>
            <p class="mb-6 text-sm text-gray-600">Sign in to your jobseeker account</p>
            <?php if (!empty($error)): ?>
                <div class="px-4 py-3 mb-6 text-red-600 border border-red-200 rounded-md bg-red-50">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form class="space-y-5" method="POST" action="?page=login-jobseeker">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input id="email" name="email" type="email" required
                        value="<?php echo htmlspecialchars($formData['email'] ?? ''); ?>"
                        class="block w-full px-3 py-2 mt-1 placeholder-gray-400 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                </div>
                <div class="mt-2">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <div class="relative">
                        <input id="password" name="password" type="password" required
                            class="block w-full px-3 py-2 pr-10 mt-1 placeholder-gray-400 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                        <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600">
                            <i id="password-icon" class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                <div class="flex justify-end mt-2">
                    <a href="?page=forgot-password" class="text-sm text-primary hover:underline">Forgot Password?</a>
                </div>
                <button type="submit"
                    class="justify-end w-full px-4 py-3 mt-4 text-sm font-semibold text-white rounded-md shadow bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
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
            <a href="?page=google-login&type=jobseeker"
                class="flex items-center justify-center w-full px-4 py-3 mb-4 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
                <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" alt="Google logo" class="w-5 h-5 mr-2">
                Sign in with Google
            </a>

            <!-- Sign Up Link -->
            <div class="mt-4 text-center">
                <p class="mb-2 text-sm text-gray-600">
                    Don't have an account?
                    <a href="?page=signup-jobseeker" class="font-medium text-primary hover:underline">Sign Up</a>
                </p>
                <p class="text-sm text-gray-600">
                    Are you an employer?
                    <a href="?page=login-employer" class="font-medium text-secondary hover:underline">Employer Sign In</a>
                </p>
            </div>
        </div>

        <!-- Right: Image Carousel -->
        <div class="items-center justify-center hidden bg-gray-100 md:flex md:w-1/2">
            <div class="flex items-center justify-center w-full h-full">
                <!-- Simple carousel (static for demo, replace with JS carousel if needed) -->
                <div class="flex items-center justify-center w-full h-full">
                    <img src="../public/assets/images/hero-page-img.png" alt="Jobseekers" class="object-cover w-full h-full rounded-r-xl" />
                </div>
            </div>
        </div>
    </div>
</div>