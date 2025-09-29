<?php

include_once __DIR__ . '/../components/navbar-top.php';
include_once __DIR__ . '/../components/navbar.php';
include_once __DIR__ . '/../components/alert-modal.php';

$email = $_SESSION['reset_email'] ?? '';
$cooldown = isset($_SESSION['otp_cooldown']) && $_SESSION['otp_cooldown'] > time();
$remainingTime = $cooldown ? $_SESSION['otp_cooldown'] - time() : 0;
?>

<div class="flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <h2 class="mt-6 text-3xl font-extrabold text-center text-gray-900">
            Verify OTP
        </h2>
        <p class="mt-2 text-sm text-center text-gray-500">
            Enter the code sent to <?= htmlspecialchars($email) ?>
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="px-4 py-8 bg-white shadow sm:rounded-lg sm:px-10">
            <form class="space-y-6" action="?page=verify-forgotpassword" method="POST">
                <div>
                    <label for="otp" class="block text-sm font-medium text-gray-700">
                        Enter OTP Code
                    </label>
                    <div class="mt-1">
                        <input id="otp" name="otp" type="text" required maxlength="6"
                            class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md shadow-sm appearance-none focus:outline-none focus:ring-primary focus:border-primary sm:text-sm"
                            pattern="[0-9]{6}" title="Please enter 6 digits">
                    </div>
                </div>

                <div>
                    <button type="submit"
                        class="flex justify-center w-full px-4 py-2 text-sm font-medium text-white border border-transparent rounded-md shadow-sm bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        Verify Code
                    </button>
                </div>
            </form>

            <div class="mt-4">
                <button id="resendBtn"
                    onclick="window.location.href='?page=resend-otp'"
                    class="w-full px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-transparent rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500"
                    <?= $cooldown ? 'disabled' : '' ?>>
                    <?= $cooldown ? 'Resend OTP in <span id="timer"></span>' : 'Resend OTP' ?>
                </button>
            </div>
        </div>
    </div>
</div>

<?php if ($cooldown): ?>
    <script>
        let remainingTime = <?= $remainingTime ?>;
        const timerElement = document.getElementById('timer');
        const resendBtn = document.getElementById('resendBtn');

        function updateTimer() {
            const minutes = Math.floor(remainingTime / 60);
            const seconds = remainingTime % 60;
            timerElement.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;

            if (remainingTime <= 0) {
                resendBtn.disabled = false;
                resendBtn.textContent = 'Resend OTP';
                clearInterval(timerInterval);
            }
            remainingTime--;
        }

        const timerInterval = setInterval(updateTimer, 1000);
        updateTimer();
    </script>
<?php endif; ?>