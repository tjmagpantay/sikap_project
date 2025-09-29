<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once __DIR__ . '/../components/navbar-top.php';
include_once __DIR__ . '/../components/navbar.php';
?>

<div class="flex flex-col min-h-screen px-4 bg-gray-50 sm:px-6 lg:px-8">
    <div class="mt-20 sm:mx-auto sm:w-full sm:max-w-md md:mt-32">
        <h2 class="text-3xl font-extrabold text-center text-gray-900">
            Forgot Password
        </h2>
        <p class="mt-2 text-sm text-center text-gray-600">
            Enter your email address below and we’ll send you a reset code. <br>
            <span class="text-xs text-gray-500">(Please enter your valid email address)</span>
        </p>
    </div>

    <div class="mt-6 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="px-4 py-8 bg-white rounded-lg shadow sm:px-6">
            <?php if (isset($_SESSION['flash'])): ?>
                <div class="p-4 mb-4 text-sm rounded-lg <?= strpos($_SESSION['flash'], 'error') !== false ? 'text-red-800 bg-red-50' : 'text-primary bg-gray-10' ?>">
                    <?= $_SESSION['flash']; ?>
                    <?php unset($_SESSION['flash']); ?>
                </div>
            <?php endif; ?>

            <form class="space-y-6" action="?page=forgot-password-request" method="POST" id="forgotPasswordForm">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">
                        Email address
                    </label>
                    <div class="mt-1">
                        <input id="email" name="email" type="email" required maxlength="50"
                            class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md shadow-sm appearance-none focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
                        <div class="flex justify-between mt-1 text-xs">
                            <span id="email-error" class="hidden text-red-500"></span>
                        </div>
                    </div>
                </div>

                <div>
                    <button type="submit" id="submitBtn"
                        class="flex justify-center w-full px-4 py-2 text-sm font-medium text-white border border-transparent rounded-md shadow-sm bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary disabled:opacity-50 disabled:cursor-not-allowed">
                        Send Reset Code
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const emailInput = document.getElementById('email');
        const errorSpan = document.getElementById('email-error');
        const countSpan = document.getElementById('email-count');
        const submitBtn = document.getElementById('submitBtn');
        const form = document.getElementById('forgotPasswordForm');
        const maxLimit = 50;

        function validateEmail() {
            const length = emailInput.value.length;
            countSpan.textContent = `${length}/${maxLimit}`;

            if (length > maxLimit) {
                errorSpan.textContent = `Email cannot exceed ${maxLimit} characters`;
                errorSpan.classList.remove('hidden');
                emailInput.classList.add('border-red-500');
                submitBtn.disabled = true;
            } else {
                errorSpan.classList.add('hidden');
                emailInput.classList.remove('border-red-500');
                submitBtn.disabled = false;
            }
        }

        emailInput.addEventListener('input', validateEmail);
        validateEmail(); // Initial run

        form.addEventListener('submit', function(e) {
            if (emailInput.value.length > maxLimit) {
                e.preventDefault();
                errorSpan.textContent = `Email cannot exceed ${maxLimit} characters`;
                errorSpan.classList.remove('hidden');
                emailInput.classList.add('border-red-500');
            }
        });
    });
</script>