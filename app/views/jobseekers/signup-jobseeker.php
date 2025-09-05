<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    include_once __DIR__ . '/../components/navbar-top.php';
    include_once __DIR__ . '/../components/navbar.php';
    include_once __DIR__ . '/../components/alert-modal.php';
?>
<script src="/sikap/app/views/components/register-validation.js"></script>
<script src="/sikap/app/views/components/terms-condi.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<body class="flex items-center justify-center min-h-screen bg-gray-100">
    
 
<div class="flex flex-col justify-center min-h-screen py-12 bg-gray-50 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <div class="text-center">
                <h2 class="text-3xl font-bold text-gray-900">Create Jobseeker Account</h2>
                <p class="mt-2 text-sm text-gray-600">
                    Join to find your dream job
                </p>
            </div> 
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="px-4 py-8 bg-white shadow sm:rounded-lg sm:px-10">
               
                <form class="space-y-6" method="POST" action="?page=signup-jobseeker">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                            <input id="first_name" name="first_name" type="text" required 
                                   value="<?php echo htmlspecialchars($formData['first_name'] ?? ''); ?>"
                                   class="block w-full px-3 py-2 mt-1 placeholder-gray-400 border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-primary focus:border-primary">
                        </div>
                        <div>
                            <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                            <input id="last_name" name="last_name" type="text" required 
                                   value="<?php echo htmlspecialchars($formData['last_name'] ?? ''); ?>"
                                   class="block w-full px-3 py-2 mt-1 placeholder-gray-400 border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-primary focus:border-primary">
                        </div>
                    </div>

                    <div>
                        <label for="contact_number" class="block text-sm font-medium text-gray-700">Contact Number</label>
                        <input id="contact_number" name="contact_number" type="tel" required 
                               value="<?php echo htmlspecialchars($formData['contact_number'] ?? ''); ?>"
                               class="block w-full px-3 py-2 mt-1 placeholder-gray-400 border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-primary focus:border-primary">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
                        <input id="email" name="email" type="email" required 
                               value="<?php echo htmlspecialchars($formData['email'] ?? ''); ?>"
                               class="block w-full px-3 py-2 mt-1 placeholder-gray-400 border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-primary focus:border-primary">
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input id="password" name="password" type="password" required 
                               value="<?php echo htmlspecialchars($formData['password'] ?? ''); ?>"
                               class="block w-full px-3 py-2 mt-1 placeholder-gray-400 border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-primary focus:border-primary">
                    </div>

                    <div>
                        <label for="confirm_password" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                        <input id="confirm_password" name="confirm_password" type="password" required 
                               value="<?php echo htmlspecialchars($formData['confirm_password'] ?? ''); ?>"
                               class="block w-full px-3 py-2 mt-1 placeholder-gray-400 border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-primary focus:border-primary">
                    </div> 

                    <!-- Add this before the submit button -->
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="terms" name="terms" type="checkbox" required
                                        class="w-4 h-4 border-gray-300 rounded text-primary focus:ring-primary">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="terms" class="font-medium text-gray-700">
                                        I understood the terms & policy.
                                    </label>
                                </div>
                            </div>
                            
                            <div class="text-sm text-gray-600">
                                By clicking Register, you agree to the 
                                <a href="" onclick="showTerms(event)" class="text-primary hover:underline">Terms and Conditions</a> & 
                                <a href="" onclick="showPrivacy(event)" class="text-primary hover:underline">Privacy Policy</a> 
                                of Sikap.com
                            </div>
                        </div>

                    <div>
                        <button type="submit" class="flex justify-center w-full px-4 py-2 text-sm font-medium text-white border border-transparent rounded-md shadow-sm bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                            Create Account
                        </button>
                    </div>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        Already have an account? 
                        <a href="?page=login-jobseeker" class="font-medium text-primary hover:underline">Sign in</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    <?php if (!empty($error) && $error === 'Email already exists.'): ?>
    <script>
        Swal.fire({
            title: 'Error!',
            text: 'Email already exists!',
            icon: 'error',
            confirmButtonText: 'Ok',
            confirmButtonColor: '#EF4444'
        });
    </script>
    <?php endif; ?>

    <?php if (isset($_SESSION['registration_success']) && $_SESSION['registration_success']): ?>
    <script>
        Swal.fire({
            title: 'Welcome!',
            text: 'Your account has been created successfully!',
            icon: 'success',
            confirmButtonText: 'Continue',
            confirmButtonColor: '#10B981'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '?page=jobseeker-dashboard';
            }
        });
    </script>
    <?php 
        unset($_SESSION['registration_success']);
    endif; 
    ?>
</body>
