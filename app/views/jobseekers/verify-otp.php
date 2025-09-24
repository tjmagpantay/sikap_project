<?php
    include_once __DIR__ . '/../components/navbar-top.php';
    include_once __DIR__ . '/../components/navbar.php';
    $cooldown = isset($_GET['cooldown']) && $_GET['cooldown'] == 1;
    $resent = isset($_GET['resent']) && $_GET['resent'] == 1;
    $lastSent = isset($_SESSION['otp']['last_sent']) ? $_SESSION['otp']['last_sent'] : (time() - 300);
    $remaining = max(0, 300 - (time() - $lastSent));
?>


<div class="flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <div class="text-center">
            <h2 class="text-2xl font-bold text-gray-900">2-Factor Authentication</h2>
            <p class="mt-2 text-sm text-gray-600">
                For your security, please enter the 6-digit code sent to your email to complete your sign in.
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
            <?php if ($resent): ?>
                <div class="px-4 py-3 mb-4 text-green-700 border border-green-200 rounded-md bg-green-50">
                    A new OTP has been sent to your email.
                </div>
            <?php endif; ?>
            <?php if ($cooldown): ?>
                <div class="px-4 py-3 mb-4 text-yellow-700 border border-yellow-200 rounded-md bg-yellow-50">
                    You can resend OTP every 5 minutes. Please wait for the timer to finish.
                </div>
            <?php endif; ?>
            <form class="space-y-6" method="POST" action="?page=verify-otp">
                <div>
                    <label for="otp" class="block text-sm font-medium text-gray-700">Authentication Code</label>
                    <input id="otp" name="otp" type="text" maxlength="6" required
                        class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary" placeholder="Enter 6-digit code">
                </div>
                <div>
                    <button type="submit" class="w-full px-4 py-2 text-sm font-medium text-white rounded-md bg-primary hover:bg-primary/90">
                        Verify & Sign In
                    </button>
                </div>
            </form>
            <form method="POST" action="?page=resend-otp" class="mt-4 text-center">
                <button id="resendBtn" type="submit" class="text-sm text-primary hover:underline" <?php if ($remaining > 0) echo 'disabled style="opacity:0.5;cursor:not-allowed;"'; ?>>
                    <?php if ($remaining > 0): ?>
                        Resend OTP (<span id="timer"></span>)
                    <?php else: ?>
                        Didn't get a code? Resend
                    <?php endif; ?>
                </button>
            </form>
            <script>
                var remaining = <?php echo $remaining; ?>;
                var resendBtn = document.getElementById('resendBtn');
                var timerSpan = document.getElementById('timer');
                if (remaining > 0 && timerSpan) {
                    function updateTimer() {
                        var min = Math.floor(remaining / 60);
                        var sec = remaining % 60;
                        timerSpan.textContent = (min < 10 ? '0' : '') + min + ':' + (sec < 10 ? '0' : '') + sec;
                        if (remaining > 0) {
                            remaining--;
                            setTimeout(updateTimer, 1000);
                        } else {
                            resendBtn.disabled = false;
                            resendBtn.style.opacity = 1;
                            resendBtn.style.cursor = 'pointer';
                            timerSpan.textContent = '';
                            resendBtn.textContent = "Didn't get a code? Resend";
                        }
                    }
                    updateTimer();
                }
            </script>
        </div>
    </div>
</div>
