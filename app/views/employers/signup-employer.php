<div class="flex flex-col justify-center min-h-screen py-12 bg-gray-50 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <div class="text-center">
            <h2 class="text-3xl font-bold text-gray-900">Create Employer Account</h2>
            <p class="mt-2 text-sm text-gray-600">
                Join to post jobs and hire talent
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

            <form class="space-y-6" method="POST" action="?page=signup-employer">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                        <input id="first_name" name="first_name" type="text" required 
                               class="block w-full px-3 py-2 mt-1 placeholder-gray-400 border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-secondary focus:border-secondary">
                    </div>
                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                        <input id="last_name" name="last_name" type="text" required 
                               class="block w-full px-3 py-2 mt-1 placeholder-gray-400 border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-secondary focus:border-secondary">
                    </div>
                </div>

                <div>
                    <label for="contact_number" class="block text-sm font-medium text-gray-700">Contact Number</label>
                    <input id="contact_number" name="contact_number" type="tel" required 
                           class="block w-full px-3 py-2 mt-1 placeholder-gray-400 border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-secondary focus:border-secondary">
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
                    <input id="email" name="email" type="email" required 
                           class="block w-full px-3 py-2 mt-1 placeholder-gray-400 border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-secondary focus:border-secondary">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input id="password" name="password" type="password" required 
                           class="block w-full px-3 py-2 mt-1 placeholder-gray-400 border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-secondary focus:border-secondary">
                </div>

                <div>
                    <label for="confirm_password" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                    <input id="confirm_password" name="confirm_password" type="password" required 
                           class="block w-full px-3 py-2 mt-1 placeholder-gray-400 border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-secondary focus:border-secondary">
                </div>

                <div>
                    <button type="submit" class="flex justify-center w-full px-4 py-2 text-sm font-medium text-white border border-transparent rounded-md shadow-sm bg-secondary hover:bg-secondary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary">
                        Create Account
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    Already have an account? 
                    <a href="?page=login-employer" class="font-medium text-secondary hover:underline">Sign in</a>
                </p>
            </div>
        </div>
    </div>
</div>