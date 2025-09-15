<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once __DIR__ . '/../components/navbar-top.php';
include_once __DIR__ . '/../components/navbar.php';
include_once __DIR__ . '/../components/alert-modal.php';
?>

<!-- SweetAlert2 CDN for modals -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="/sikap/app/views/components/register-validation.js"></script>
<script src="/sikap/app/views/components/terms-condi-employer.js"></script>

<div class="flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-2xl">
        <div class="w-full max-w-2xl overflow-hidden bg-white rounded-xl" style="box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);">
            <!-- Single Card Layout -->
            <div class="flex flex-col justify-center w-full px-6 py-8 lg:px-12 xl:px-16">
                <div class="w-full max-w-lg mx-auto">
                    <!-- Header -->
                    <div class="mb-8 text-center">
                        <h2 class="mb-2 text-3xl font-bold text-grayMain">Create Employer Account</h2>
                        <p class="text-sm text-gray-600">Join to post jobs and hire talent</p>
                    </div>

                    <!-- Error Message -->
                    <?php if (!empty($error)): ?>
                        <div class="px-4 py-3 mb-6 text-red-600 border border-red-200 rounded-lg bg-red-50">
                            <?php echo htmlspecialchars($error); ?>
                        </div>
                    <?php endif; ?>

                    <!-- Form -->
                    <form class="space-y-6" method="POST" action="?page=signup-employer">
                        <!-- Email -->
                        <div class="space-y-2">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                            <input id="email" name="email" type="email" required
                                class="block w-full px-3 py-3 text-sm placeholder-gray-400 transition-colors border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-secondary focus:border-secondary"
                                placeholder="your.email@example.com">
                        </div>

                        <!-- Password -->
                        <div class="space-y-2">
                            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                            <div class="relative">
                                <input id="password" name="password" type="password" required
                                    class="w-full px-3 py-3 pr-12 text-sm placeholder-gray-400 transition-colors border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-secondary focus:border-secondary"
                                    placeholder="Create a strong password">
                                <button type="button" onclick="togglePassword('password')" class="absolute text-gray-400 transition-colors transform -translate-y-1/2 right-3 top-1/2 hover:text-gray-600 focus:outline-none">
                                    <svg id="password-icon-show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    <svg id="password-icon-hide" class="hidden w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div class="space-y-2">
                            <label for="confirm_password" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                            <div class="relative">
                                <input id="confirm_password" name="confirm_password" type="password" required
                                    class="w-full px-3 py-3 pr-12 text-sm placeholder-gray-400 transition-colors border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-secondary focus:border-secondary"
                                    placeholder="Confirm your password">
                                <button type="button" onclick="togglePassword('confirm_password')" class="absolute text-gray-400 transition-colors transform -translate-y-1/2 right-3 top-1/2 hover:text-gray-600 focus:outline-none">
                                    <svg id="confirm-password-icon-show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    <svg id="confirm-password-icon-hide" class="hidden w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Terms and Conditions -->
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="terms" name="terms" type="checkbox" required
                                        class="w-4 h-4 border-gray-300 rounded text-secondary focus:ring-secondary focus:ring-2">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="terms" class="font-medium text-gray-700">
                                        I understand and agree to the terms & policy.
                                    </label>
                                </div>
                            </div>

                            <div class="text-sm text-gray-600">
                                By clicking "Create Account", you agree to our
                                <a href="" onclick="showTerms(event)" class="font-medium transition-colors text-secondary hover:text-secondary/80 hover:underline">Terms and Conditions</a> and
                                <a href="" onclick="showPrivacy(event)" class="font-medium transition-colors text-secondary hover:text-secondary/80 hover:underline">Privacy Policy</a>.
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit"
                            class="w-full px-4 py-3 text-sm font-semibold text-white transition-all duration-200 rounded-lg shadow-md bg-secondary hover:bg-secondary/90 focus:outline-none focus:ring-2 focus:ring-secondary focus:ring-offset-2">
                            Create Account
                        </button>
                    </form>

                    <!-- Or Separator -->
                    <div class="relative py-6 text-sm text-center after:absolute after:inset-0 after:top-1/2 after:z-0 after:flex after:items-center after:border-t after:border-gray-300">
                        <span class="relative z-10 px-3 text-gray-600 bg-white">
                            or continue with
                        </span>
                    </div>

                    <!-- Google Sign Up -->
                    <a href="?page=google-signup&type=employer"
                        class="flex items-center justify-center w-full px-4 py-3 mb-6 text-sm font-medium text-gray-700 transition-all duration-200 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-secondary focus:ring-offset-2">
                        <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" alt="Google logo" class="w-5 h-5 mr-3">
                        Sign up with Google
                    </a>

                    <!-- Sign In Link -->
                    <div class="space-y-3 text-center">
                        <p class="text-sm text-gray-600">
                            Already have an account?
                            <a href="?page=login-employer" class="font-medium transition-colors text-secondary hover:text-secondary/80">Sign In</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Jobseeker sign up link placed below the card -->
        <div class="mt-6 text-center">
            <p class="text-xs text-gray-600">
                Are you looking for a job?
                <a href="?page=signup-jobseeker" class="font-medium underline transition-colors text-primary hover:text-primary/80 underline-offset-2">
                    Jobseeker Sign Up
                </a>
            </p>
        </div>
    </div>
</div>

<script>
    function togglePassword(fieldId) {
        const passwordInput = document.getElementById(fieldId);
        const showIcon = document.getElementById(fieldId === 'password' ? 'password-icon-show' : 'confirm-password-icon-show');
        const hideIcon = document.getElementById(fieldId === 'password' ? 'password-icon-hide' : 'confirm-password-icon-hide');

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