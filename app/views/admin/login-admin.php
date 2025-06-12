<div class="flex flex-col justify-center min-h-screen py-12 bg-gray-900 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <div class="text-center">
            <div class="flex justify-center mb-4">
                <div class="p-3 bg-red-600 rounded-full">
                    <i class="text-2xl text-white fas fa-shield-alt"></i>
                </div>
            </div>
            <h2 class="text-3xl font-bold text-white">Admin Portal</h2>
            <p class="mt-2 text-sm text-gray-300">
                Administrative access only
            </p>
        </div>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="px-4 py-8 bg-white shadow sm:rounded-lg sm:px-10">
            <?php if (!empty($error)): ?>
                <div class="px-4 py-3 mb-4 text-red-600 border border-red-200 rounded-md bg-red-50">
                    <div class="flex items-center">
                        <i class="mr-2 fas fa-exclamation-triangle"></i>
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                </div>
            <?php endif; ?>

            <form class="space-y-6" method="POST" action="?page=admin-login">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">
                        <i class="mr-1 fas fa-envelope"></i>
                        Admin Email
                    </label>
                    <div class="mt-1">
                        <input id="email" name="email" type="email" required 
                               placeholder="Enter admin email"
                               class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-red-500 focus:border-red-500">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">
                        <i class="mr-1 fas fa-lock"></i>
                        Password
                    </label>
                    <div class="relative mt-1">
                        <input id="password" name="password" type="password" required 
                               placeholder="Enter admin password"
                               class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-red-500 focus:border-red-500">
                        <button type="button" onclick="togglePassword()" class="absolute right-3 top-2.5 text-gray-400 hover:text-gray-600">
                            <i class="fas fa-eye" id="toggleIcon"></i>
                        </button>
                    </div>
                </div>

                <div>
                    <button type="submit" class="flex justify-center w-full px-4 py-2 text-sm font-medium text-white transition-colors duration-200 bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        <i class="mr-2 fas fa-sign-in-alt"></i>
                        Access Admin Dashboard
                    </button>
                </div>
            </form>

            <!-- Admin Signup Link -->
            <div class="mt-6 text-center">
                <a href="?page=admin-signup" 
                   class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-green-600 transition-colors duration-200 border border-green-200 rounded-md bg-green-50 hover:bg-green-100">
                    <i class="fas fa-user-plus"></i>
                    Create New Admin Account
                </a>
            </div>

            <!-- Back to Home -->
            <div class="mt-4 text-center">
                <a href="?page=landing" class="text-sm text-gray-500 hover:text-gray-700">
                    <i class="mr-1 fas fa-arrow-left"></i>
                    Back to Home
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.getElementById('toggleIcon');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.className = 'fas fa-eye-slash';
    } else {
        passwordInput.type = 'password';
        toggleIcon.className = 'fas fa-eye';
    }
}
</script>

