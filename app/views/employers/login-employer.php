<div class="flex flex-col justify-center min-h-screen py-12 bg-gray-50 sm:px-6 lg:px-8">
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
                <div class="px-4 py-3 mb-4 text-red-600 border border-red-200 rounded-md bg-red-50">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form class="space-y-6" method="POST" action="?page=login-employer">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
                    <div class="mt-1">
                        <input id="email" name="email" type="email" required 
                               class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-secondary focus:border-secondary">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <div class="mt-1">
                        <input id="password" name="password" type="password" required 
                               class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-secondary focus:border-secondary">
                    </div>
                </div>

                <div>
                    <button type="submit" class="flex justify-center w-full px-4 py-2 text-sm font-medium text-white border border-transparent rounded-md shadow-sm bg-secondary hover:bg-secondary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary">
                        Sign In
                    </button>
                </div>
            </form>

            <div class="mt-6">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 text-gray-500 bg-white">Or</span>
                    </div>
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