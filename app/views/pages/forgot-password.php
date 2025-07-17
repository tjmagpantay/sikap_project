<?php
include_once __DIR__ . '/../components/navbar-top.php';
include_once __DIR__ . '/../components/navbar.php';
?>

<div class="flex flex-col min-h-screen bg-gray-50 px-4 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md mt-20 md:mt-32">
        <h2 class="text-3xl font-extrabold text-center text-gray-900">
            Forgot Password
        </h2>
    </div>

    <div class="mt-6 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="px-4 py-8 bg-white shadow rounded-lg sm:px-6">
            <?php if (isset($_SESSION['flash'])): ?>
                <div class="p-4 mb-4 text-sm rounded-lg <?= strpos($_SESSION['flash'], 'error') !== false ? 'text-red-800 bg-red-50' : 'text-green-800 bg-green-50' ?>">
                    <?= $_SESSION['flash']; ?>
                    <?php unset($_SESSION['flash']); ?>
                </div>
            <?php endif; ?>

            <form class="space-y-6" action="?page=forgot-password-request" method="POST">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">
                        Email address
                    </label>
                    <div class="mt-1">
                        <input id="email" name="email" type="email" required
                            class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md shadow-sm appearance-none focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
                    </div>
                </div>

                <div>
                    <button type="submit"
                        class="flex justify-center w-full px-4 py-2 text-sm font-medium text-white border border-transparent rounded-md shadow-sm bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        Send Reset Code
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>