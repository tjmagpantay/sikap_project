<?php
  include_once __DIR__ . '/../components/navbar-top.php';
    include_once __DIR__ . '/../components/navbar.php';
?>
<div class="flex flex-col justify-center py-12 min-h-screen bg-gray-50 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <div class="text-center">
            <h2 class="text-3xl font-bold text-gray-900">Employer Sign In</h2>
            <p class="mt-2 text-sm text-gray-600">
                Sign in to your employer account
            </p>
        </div>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="px-4 py-8 bg-white shadow sm:rounded-lg sm:px-10">
            <?php if (!empty($error)): ?>
                <div class="px-4 py-3 mb-4 text-red-600 bg-red-50 rounded-md border border-red-200">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form class="space-y-6" method="POST" action="?page=login-employer">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
                    <div class="mt-1">
                        <input id="email" name="email" type="email" required 
                               class="block px-3 py-2 w-full placeholder-gray-400 rounded-md border border-gray-300 appearance-none focus:outline-none focus:ring-secondary focus:border-secondary">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <div class="mt-1">
                        <input id="password" name="password" type="password" required 
                               class="block px-3 py-2 w-full placeholder-gray-400 rounded-md border border-gray-300 appearance-none focus:outline-none focus:ring-secondary focus:border-secondary">
                    </div>
                </div>

            <div class="flex justify-end">
                <a href="?page=forgot-password" class="text-sm text-gray-700 hover:underline">Forgot Password?</a>
            </div>


                <div>
                    <button type="submit" class="flex justify-center px-4 py-2 w-full text-sm font-medium text-white rounded-md border border-transparent shadow-sm bg-secondary hover:bg-secondary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary">
                        Sign In
                    </button>
                </div>
            </form>

            <div class="mt-6">
                <div class="relative">
                    <div class="flex absolute inset-0 items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="flex relative justify-center text-sm">
                        <span class="px-2 text-gray-500 bg-white">Or</span>
                    </div>
                </div>

                <div class="mt-6">
                <a href="?page=google-login&type=employer"
                   class="flex justify-center items-center px-4 py-2 w-full text-sm font-medium text-gray-700 bg-white rounded-md border border-gray-300 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary">
                    <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" alt="Google logo" class="mr-2 w-5 h-5">
                    Continue with Google
                </a>
            </div>

                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        Don't have an account? 
                        <a href="?page=signup-employer" class="font-medium text-secondary hover:underline">Sign up as Employer</a>
                    </p>
                    <p class="mt-2 text-sm text-gray-600">
                        Looking for a job? 
                        <a href="?page=login-jobseeker" class="font-medium text-primary hover:underline">Jobseeker Sign In</a>
                    </p>
                </div>
            </div>

            
        </div>
    </div>
</div>