<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="/sikap/public/assets/css/output.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="./assets/images/sikap-logo.png">
    <title>Admin Registration - SIKAP</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="font-inter">

<div class="flex flex-col justify-center min-h-screen py-12 bg-gray-900 sm:px-6 lg:px-8">
    <!-- Developer Warning Banner -->
    <div class="mb-4 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="px-4 py-3 text-yellow-800 border border-yellow-300 rounded-md bg-yellow-50">
            <div class="flex items-center">
                <i class="mr-2 fas fa-exclamation-triangle"></i>
                <span class="text-sm font-medium">Developer Access Only</span>
            </div>
            <p class="mt-1 text-xs">This page is restricted to development environments only.</p>
        </div>
    </div>

    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <div class="text-center">
            <div class="flex justify-center mb-4">
                <div class="p-3 bg-green-600 rounded-full">
                    <i class="text-2xl text-white fas fa-user-shield"></i>
                </div>
            </div>
            <h2 class="text-3xl font-bold text-white">Create Admin Account</h2>
            <p class="mt-2 text-sm text-gray-300">
                Register new administrator
            </p>
        </div>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="px-4 py-8 bg-white shadow sm:rounded-lg sm:px-10">
            <form class="space-y-6" method="POST" action="?page=admin-signup">
                <div>
                    <label for="admin_name" class="block text-sm font-medium text-gray-700">
                        <i class="mr-1 fas fa-user"></i>
                        Admin Name
                    </label>
                    <div class="mt-1">
                        <input id="admin_name" name="admin_name" type="text" required
                            placeholder="Enter admin full name"
                            value="<?php echo htmlspecialchars($_POST['admin_name'] ?? ''); ?>"
                            class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-green-500 focus:border-green-500">
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">
                        <i class="mr-1 fas fa-envelope"></i>
                        Admin Email
                    </label>
                    <div class="mt-1">
                        <input id="email" name="email" type="email" required
                            placeholder="Enter admin email"
                            value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
                            class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-green-500 focus:border-green-500">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">
                        <i class="mr-1 fas fa-lock"></i>
                        Password
                    </label>
                    <div class="relative mt-1">
                        <input id="password" name="password" type="password" required
                            placeholder="Create admin password"
                            class="block w-full px-3 py-2 pr-10 placeholder-gray-400 border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-green-500 focus:border-green-500">
                        <button type="button" onclick="togglePassword('password')" class="absolute right-3 top-2.5 text-gray-400 hover:text-gray-600">
                            <i class="fas fa-eye" id="toggleIcon1"></i>
                        </button>
                    </div>
                    <div class="mt-1 text-xs text-gray-500">
                        Password must be at least 8 characters with uppercase, lowercase, and number
                    </div>
                </div>

                <div>
                    <label for="confirm_password" class="block text-sm font-medium text-gray-700">
                        <i class="mr-1 fas fa-lock"></i>
                        Confirm Password
                    </label>
                    <div class="relative mt-1">
                        <input id="confirm_password" name="confirm_password" type="password" required
                            placeholder="Confirm admin password"
                            class="block w-full px-3 py-2 pr-10 placeholder-gray-400 border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-green-500 focus:border-green-500">
                        <button type="button" onclick="togglePassword('confirm_password')" class="absolute right-3 top-2.5 text-gray-400 hover:text-gray-600">
                            <i class="fas fa-eye" id="toggleIcon2"></i>
                        </button>
                    </div>
                </div>

                <div>
                    <button type="submit" class="flex justify-center w-full px-4 py-2 text-sm font-medium text-white transition-colors duration-200 bg-green-600 border border-transparent rounded-md shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        <i class="mr-2 fas fa-user-plus"></i>
                        Create Admin Account
                    </button>
                </div>
            </form>

            <!-- Navigation Links -->
            <div class="mt-6 space-y-2 text-center">
                <div>
                    <a href="?page=admin-login" class="text-sm text-green-600 hover:text-green-700">
                        <i class="mr-1 fas fa-sign-in-alt"></i>
                        Already have admin account? Login
                    </a>
                </div>
                <div>
                    <a href="?page=landing" class="text-sm text-gray-500 hover:text-gray-700">
                        <i class="mr-1 fas fa-arrow-left"></i>
                        Back to Home
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePassword(fieldId) {
        const passwordInput = document.getElementById(fieldId);
        const toggleIcon = fieldId === 'password' ? document.getElementById('toggleIcon1') : document.getElementById('toggleIcon2');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.className = 'fas fa-eye-slash';
        } else {
            passwordInput.type = 'password';
            toggleIcon.className = 'fas fa-eye';
        }
    }

    // Password validation
    document.getElementById('confirm_password').addEventListener('input', function() {
        const password = document.getElementById('password').value;
        const confirmPassword = this.value;

        if (password !== confirmPassword) {
            this.setCustomValidity('Passwords do not match');
        } else {
            this.setCustomValidity('');
        }
    });

    // Show success/error messages
    <?php if (!empty($error)): ?>
        Swal.fire({
            title: 'Registration Failed',
            text: '<?php echo addslashes($error); ?>',
            icon: 'error',
            confirmButtonText: 'Try Again',
            confirmButtonColor: '#dc2626'
        });
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        Swal.fire({
            title: 'Success!',
            text: '<?php echo addslashes($success); ?>',
            icon: 'success',
            confirmButtonText: 'Go to Login',
            confirmButtonColor: '#16a34a'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '?page=admin-login';
            }
        });
    <?php endif; ?>
</script>

</body>
</html>