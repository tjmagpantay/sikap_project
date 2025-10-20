<?php
include_once __DIR__ . '/../components/navbar-top.php';
include_once __DIR__ . '/../components/navbar.php';
include_once __DIR__ . '/../components/alert-modal.php';
?>

<div class="flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <h2 class="mt-6 text-3xl font-extrabold text-center text-gray-900">
            Reset Password
        </h2>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="px-4 py-8 bg-white shadow sm:rounded-lg sm:px-10">
            <form class="space-y-6" action="?page=reset-password" method="POST" id="resetPasswordForm">
                <!-- New Password Field with Toggle -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">
                        New Password
                    </label>
                    <div class="relative mt-1">
                        <input id="password" name="password" type="password" required minlength="8"
                            class="block w-full px-3 py-2 pr-12 placeholder-gray-400 border border-gray-300 rounded-md shadow-sm appearance-none focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
                        <button type="button" onclick="togglePassword('password')" 
                            class="absolute text-gray-400 transition-colors transform -translate-y-1/2 right-3 top-1/2 hover:text-gray-600 focus:outline-none">
                            <svg id="password-icon-show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            <svg id="password-icon-hide" class="hidden w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="mt-1 text-xs text-gray-500">
                        Password must be at least 8 characters long
                    </div>
                </div>

                <!-- Confirm Password Field with Toggle -->
                <div>
                    <label for="confirm_password" class="block text-sm font-medium text-gray-700">
                        Confirm Password
                    </label>
                    <div class="relative mt-1">
                        <input id="confirm_password" name="confirm_password" type="password" required minlength="8"
                            class="block w-full px-3 py-2 pr-12 placeholder-gray-400 border border-gray-300 rounded-md shadow-sm appearance-none focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
                        <button type="button" onclick="togglePassword('confirm_password')" 
                            class="absolute text-gray-400 transition-colors transform -translate-y-1/2 right-3 top-1/2 hover:text-gray-600 focus:outline-none">
                            <svg id="confirm_password-icon-show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            <svg id="confirm_password-icon-hide" class="hidden w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="flex justify-between text-xs">
                        <span id="password-match-error" class="hidden text-red-500">Passwords do not match</span>
                        <span id="password-match-success" class="hidden text-green-500">Passwords match</span>
                    </div>
                </div>

                <!-- Password Strength Indicator -->
                <div id="password-strength" class="hidden">
                    <div class="text-xs font-medium text-gray-700">Password Strength:</div>
                    <div class="flex mt-1 space-x-1">
                        <div id="strength-bar-1" class="flex-1 h-2 bg-gray-200 rounded"></div>
                        <div id="strength-bar-2" class="flex-1 h-2 bg-gray-200 rounded"></div>
                        <div id="strength-bar-3" class="flex-1 h-2 bg-gray-200 rounded"></div>
                        <div id="strength-bar-4" class="flex-1 h-2 bg-gray-200 rounded"></div>
                    </div>
                    <div id="strength-text" class="mt-1 text-xs text-gray-500"></div>
                </div>

                <div>
                    <button type="submit" id="submitBtn"
                        class="flex justify-center w-full px-4 py-2 text-sm font-medium text-white border border-transparent rounded-md shadow-sm bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary disabled:opacity-50 disabled:cursor-not-allowed">
                        Reset Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Enhanced password visibility toggle function
    function togglePassword(fieldId) {
        const passwordInput = document.getElementById(fieldId);
        const showIcon = document.getElementById(fieldId + '-icon-show');
        const hideIcon = document.getElementById(fieldId + '-icon-hide');

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

    // Enhanced form validation and password strength
    document.addEventListener('DOMContentLoaded', function() {
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('confirm_password');
        const passwordMatchError = document.getElementById('password-match-error');
        const passwordMatchSuccess = document.getElementById('password-match-success');
        const passwordStrength = document.getElementById('password-strength');
        const submitBtn = document.getElementById('submitBtn');
        const form = document.getElementById('resetPasswordForm');

        // Password strength checker
        function checkPasswordStrength(password) {
            let strength = 0;
            const strengthBars = [
                document.getElementById('strength-bar-1'),
                document.getElementById('strength-bar-2'),
                document.getElementById('strength-bar-3'),
                document.getElementById('strength-bar-4')
            ];
            const strengthText = document.getElementById('strength-text');

            // Reset bars
            strengthBars.forEach(bar => {
                bar.className = 'h-2 bg-gray-200 rounded flex-1';
            });

            if (password.length >= 8) strength++;
            if (password.match(/[a-z]/)) strength++;
            if (password.match(/[A-Z]/)) strength++;
            if (password.match(/[0-9]/) || password.match(/[^a-zA-Z0-9]/)) strength++;

            const colors = ['bg-red-400', 'bg-yellow-400', 'bg-blue-400', 'bg-green-400'];
            const texts = ['Very Weak', 'Weak', 'Good', 'Strong'];

            for (let i = 0; i < strength; i++) {
                strengthBars[i].className = `h-2 ${colors[strength - 1]} rounded flex-1`;
            }

            if (password.length > 0) {
                strengthText.textContent = texts[strength - 1] || 'Very Weak';
                passwordStrength.classList.remove('hidden');
            } else {
                passwordStrength.classList.add('hidden');
            }

            return strength;
        }

        // Password matching checker
        function checkPasswordMatch() {
            const password = passwordInput.value;
            const confirmPassword = confirmPasswordInput.value;

            if (confirmPassword.length > 0) {
                if (password === confirmPassword) {
                    passwordMatchError.classList.add('hidden');
                    passwordMatchSuccess.classList.remove('hidden');
                    confirmPasswordInput.classList.remove('border-red-300');
                    confirmPasswordInput.classList.add('border-green-300');
                    return true;
                } else {
                    passwordMatchError.classList.remove('hidden');
                    passwordMatchSuccess.classList.add('hidden');
                    confirmPasswordInput.classList.add('border-red-300');
                    confirmPasswordInput.classList.remove('border-green-300');
                    return false;
                }
            } else {
                passwordMatchError.classList.add('hidden');
                passwordMatchSuccess.classList.add('hidden');
                confirmPasswordInput.classList.remove('border-red-300', 'border-green-300');
                return false;
            }
        }

        // Validate form and enable/disable submit button
        function validateForm() {
            const passwordStrength = checkPasswordStrength(passwordInput.value);
            const passwordsMatch = checkPasswordMatch();
            const passwordValid = passwordInput.value.length >= 8;

            if (passwordValid && passwordsMatch && passwordStrength >= 2) {
                submitBtn.disabled = false;
            } else {
                submitBtn.disabled = true;
            }
        }

        // Event listeners
        passwordInput.addEventListener('input', function() {
            validateForm();
        });

        confirmPasswordInput.addEventListener('input', function() {
            validateForm();
        });

        // Form submission validation
        form.addEventListener('submit', function(e) {
            const password = passwordInput.value;
            const confirm = confirmPasswordInput.value;

            if (password !== confirm) {
                e.preventDefault();
                passwordMatchError.classList.remove('hidden');
                passwordMatchSuccess.classList.add('hidden');
                return false;
            }

            if (password.length < 8) {
                e.preventDefault();
                alert('Password must be at least 8 characters long.');
                return false;
            }

            const strength = checkPasswordStrength(password);
            if (strength < 2) {
                e.preventDefault();
                alert('Please choose a stronger password.');
                return false;
            }
        });

        // Initialize validation
        validateForm();
    });
</script>