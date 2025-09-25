<?php
include_once __DIR__ . '/components/jobseeker_auth_check.php';
include_once __DIR__ . '/../components/navbar-top.php';
include_once __DIR__ . '/components/navbar-jobseeker.php';
?>

<div class="min-h-screen px-4 sm:px-6 md:px-16 lg:px-24 ">
    <div class="py-8 mx-auto sm:px-2 md:px-4 lg:px-12 max-w-7xl">
        <!-- Breadcrumbs -->
        <nav class="mb-6">
            <div class="flex items-center space-x-2 text-sm">
                <a href="?page=jobseeker-dashboard" class="text-gray-500 transition-colors hover:text-primary">
                    Dashboard
                </a>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                <span class="font-medium text-primary">Account Settings</span>
            </div>
        </nav>

        <!-- Page Header -->
        <div class="mb-8">
            <div class="flex items-center mb-2 space-x-3">
                <h1 class="text-3xl font-bold text-mainGray">Account Settings</h1>
            </div>
            <p class="mt-2 text-sm text-gray-600">Manage your account security and preferences</p>
        </div>

        <!-- Settings Content -->
        <div class="space-y-6">
            <!-- Change Password -->
            <div class="p-6 bg-white rounded-lg shadow">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <h3 class="text-lg font-medium text-gray-900">Change Password</h3>
                        <p class="mt-1 text-sm text-gray-600">Update your password to keep your account secure</p>
                    </div>
                    <button onclick="togglePasswordForm()"
                        class="flex items-center px-4 py-2 text-sm font-medium transition-colors border rounded-md border-primary text-primary bg-blue-50 hover:bg-blue-100">
                        <i class="mr-2 fas fa-edit"></i>
                        Change Password
                    </button>
                </div>

                <!-- Password Change Form (Hidden by default) -->
                <div id="password-form" class="hidden pt-6 mt-4 border-t border-gray-200">
                    <form id="change-password-form" class="max-w-md mt-2 space-y-4">
                        <div>
                            <label for="current-password" class="block text-sm font-medium text-gray-700">Current Password</label>
                            <div class="relative mt-1">
                                <input type="password" id="current-password" name="current_password" required
                                    class="block w-full px-3 py-3 pr-12 text-sm border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary">
                                <button type="button" onclick="togglePasswordVisibility('current-password')"
                                    class="absolute text-gray-400 transition-colors transform -translate-y-1/2 right-3 top-1/2 hover:text-gray-600 focus:outline-none">
                                    <i class="fas fa-eye" id="current-password-icon"></i>
                                </button>
                            </div>
                        </div>
                        <!-- New Password -->
                        <div>
                            <label for="new-password" class="block text-sm font-medium text-gray-700">New Password</label>
                            <div class="relative mt-1">
                                <input type="password" id="new-password" name="new_password" required
                                    class="block w-full px-3 py-3 pr-12 text-sm border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary">
                                <button type="button" onclick="togglePasswordVisibility('new-password')"
                                    class="absolute text-gray-400 transition-colors transform -translate-y-1/2 right-3 top-1/2 hover:text-gray-600 focus:outline-none">
                                    <i class="fas fa-eye" id="new-password-icon"></i>
                                </button>
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Must be at least 8 characters with uppercase, lowercase, and number</p>
                        </div>

                        <!-- Confirm New Password -->
                        <div>
                            <label for="confirm-password" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                            <div class="relative mt-1">
                                <input type="password" id="confirm-password" name="confirm_password" required
                                    class="block w-full px-3 py-3 pr-12 text-sm border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary">
                                <button type="button" onclick="togglePasswordVisibility('confirm-password')"
                                    class="absolute text-gray-400 transition-colors transform -translate-y-1/2 right-3 top-1/2 hover:text-gray-600 focus:outline-none">
                                    <i class="fas fa-eye" id="confirm-password-icon"></i>
                                </button>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <button type="submit" id="password-submit-btn"
                                class="px-4 py-2 text-sm font-medium text-white transition-colors rounded-md bg-primary hover:bg-secondary disabled:opacity-50 disabled:cursor-not-allowed">
                                Update Password
                            </button>
                            <button type="button" onclick="togglePasswordForm()"
                                class="px-4 py-2 text-sm font-medium text-gray-700 transition-colors bg-gray-100 rounded-md hover:bg-gray-200">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Account Information -->
            <div class="p-4 transition-shadow bg-white border border-gray-100 rounded-lg shadow-sm sm:p-6 hover:shadow-md">
                <div class="flex items-start gap-3 mb-6">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Account Information</h3>
                        <p class="mt-1 text-sm text-gray-600">Your account details and registration information</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-6">
                    <div>
                        <p class="text-sm text-gray-500">Full Name</p>
                        <p class="text-sm font-medium text-gray-900">
                            <?php echo htmlspecialchars(trim(($jobseeker['first_name'] ?? '') . ' ' . ($jobseeker['last_name'] ?? ''))); ?>
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Email Address</p>
                        <p class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($_SESSION['email'] ?? 'N/A'); ?></p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Account Type</p>
                        <p class="text-sm font-medium text-gray-900">Job Seeker</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Member Since</p>
                        <p class="text-sm font-medium text-gray-900">
                            <?php
                            if (isset($jobseeker['created_at'])) {
                                echo date('F j, Y', strtotime($jobseeker['created_at']));
                            } else {
                                echo date('F j, Y');
                            }
                            ?>
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Profile Status</p>
                        <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-blue-100 border rounded-md text-primary">
                            <i class="mr-1 fas fa-check-circle"></i>
                            Active
                        </span>
                    </div>
                </div>
            </div>

            <!-- Danger Zone -->
            <div class="p-6 bg-white border-l-4 border-red-400 rounded-lg shadow">
                <div class="mb-6">
                    <h3 class="text-lg font-medium text-red-900">Danger Zone</h3>
                    <p class="mt-1 text-sm text-red-700">These actions cannot be undone and will affect your jobseeker account</p>
                </div>

                <div class="space-y-4">
                    <div class="flex items-center justify-between p-4 rounded-lg bg-red-50">
                        <div>
                            <h4 class="text-sm font-medium text-red-900">Deactivate Account</h4>
                            <p class="text-xs text-red-600">Temporarily disable your account (can be reactivated)</p>
                        </div>
                        <button onclick="showDeactivationModal()"
                            class="px-4 py-2 text-sm font-medium text-red-700 transition-colors bg-white border border-red-300 rounded-md hover:bg-red-100">
                            Deactivate
                        </button>
                    </div>

                    <div class="flex items-center justify-between p-4 rounded-lg bg-red-50">
                        <div>
                            <h4 class="text-sm font-medium text-red-900">Delete Account</h4>
                            <p class="text-xs text-red-600">Permanently delete your account and all associated data</p>
                        </div>
                        <button onclick="showDeletionModal()"
                            class="px-4 py-2 text-sm font-medium text-white transition-colors bg-red-600 rounded-md hover:bg-red-700">
                            Delete Account
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Deactivation Modal -->
<div id="deactivation-modal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black bg-opacity-50">
    <div class="flex items-center justify-center min-h-screen px-4 py-12">
        <div class="w-full max-w-md overflow-hidden bg-white shadow-xl rounded-xl" style="box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);">
            <div class="px-6 py-8 lg:px-8">


                <!-- Modal Content -->
                <div class="text-center">
                    <h3 class="mb-2 text-2xl font-bold text-gray-900">Deactivate Account</h3>
                    <p class="mb-6 text-sm text-gray-600">
                        Are you sure you want to deactivate your account? You can reactivate it later by logging in.
                    </p>
                </div>

                <!-- Password Input -->
                <div class="mb-6">
                    <label for="deactivate-password" class="block mb-2 text-sm font-medium text-gray-700">
                        Enter your password to confirm
                    </label>
                    <div class="relative">
                        <input type="password" id="deactivate-password" required
                            class="block w-full px-3 py-3 pr-12 text-sm border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary"
                            placeholder="Enter your password">
                        <button type="button" onclick="togglePasswordVisibility('deactivate-password')"
                            class="absolute text-gray-400 transition-colors transform -translate-y-1/2 right-3 top-1/2 hover:text-gray-600 focus:outline-none">
                            <i class="fas fa-eye" id="deactivate-password-icon"></i>
                        </button>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="space-y-3">
                    <button type="button" onclick="confirmDeactivation()" id="deactivate-confirm-btn"
                        class="w-full px-4 py-3 text-sm font-semibold text-white transition-all duration-200 bg-red-600 rounded-lg shadow-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed">
                        Deactivate Account
                    </button>
                    <button type="button" onclick="hideDeactivationModal()"
                        class="w-full px-4 py-3 text-sm font-medium text-gray-700 transition-all duration-200 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Deletion Modal -->
<div id="deletion-modal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black bg-opacity-50">
    <div class="flex items-center justify-center min-h-screen px-4 py-12">
        <div class="w-full max-w-md overflow-hidden bg-white shadow-xl rounded-xl" style="box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);">
            <div class="px-6 py-8 lg:px-8">

                <!-- Modal Content -->
                <div class="mb-6 text-center">
                    <h3 class="mb-2 text-2xl font-bold text-gray-900">Delete Account</h3>
                    <p class="mb-2 text-sm font-medium text-red-600">
                        This action cannot be undone. All your data will be permanently deleted.
                    </p>
                    <p class="text-sm text-gray-600">
                        Please enter your password and type "DELETE MY ACCOUNT" to confirm.
                    </p>
                </div>

                <!-- Form Inputs -->
                <div class="space-y-4">
                    <!-- Password Input -->
                    <div>
                        <label for="delete-password" class="block mb-2 text-sm font-medium text-gray-700">Password</label>
                        <div class="relative">
                            <input type="password" id="delete-password" required
                                class="block w-full px-3 py-3 pr-12 text-sm border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary"
                                placeholder="Enter your password">
                            <button type="button" onclick="togglePasswordVisibility('delete-password')"
                                class="absolute text-gray-400 transition-colors transform -translate-y-1/2 right-3 top-1/2 hover:text-gray-600 focus:outline-none">
                                <i class="fas fa-eye" id="delete-password-icon"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Confirmation Text Input -->
                    <div>
                        <label for="delete-confirm" class="block mb-2 text-sm font-medium text-gray-700">
                            Type "DELETE MY ACCOUNT"
                        </label>
                        <input type="text" id="delete-confirm" required
                            class="block w-full px-3 py-3 text-sm border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary"
                            placeholder="DELETE MY ACCOUNT">
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-6 space-y-3">
                    <button type="button" onclick="confirmDeletion()" id="delete-confirm-btn"
                        class="w-full px-4 py-3 text-sm font-semibold text-white transition-all duration-200 bg-red-600 rounded-lg shadow-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed">
                        Delete Account Permanently
                    </button>
                    <button type="button" onclick="hideDeletionModal()"
                        class="w-full px-4 py-3 text-sm font-medium text-gray-700 transition-all duration-200 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"></script>
<script>
    // Password visibility toggle
    function togglePasswordVisibility(inputId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(inputId + '-icon');

        if (input.type === 'password') {
            input.type = 'text';
            icon.className = 'fas fa-eye-slash';
        } else {
            input.type = 'password';
            icon.className = 'fas fa-eye';
        }
    }

    // Password form toggle
    function togglePasswordForm() {
        const form = document.getElementById('password-form');
        form.classList.toggle('hidden');

        // Clear form when hiding
        if (form.classList.contains('hidden')) {
            document.getElementById('change-password-form').reset();
        }
    }

    // Initialize when DOM is loaded
    document.addEventListener('DOMContentLoaded', function() {
        // Change password form submission
        const changePasswordForm = document.getElementById('change-password-form');
        if (changePasswordForm) {
            changePasswordForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const currentPassword = document.getElementById('current-password').value;
                const newPassword = document.getElementById('new-password').value;
                const confirmPassword = document.getElementById('confirm-password').value;
                const submitBtn = document.getElementById('password-submit-btn');

                // Client-side validation
                if (newPassword.length < 8) {
                    showNotification('New password must be at least 8 characters long', 'error');
                    return;
                }

                if (!/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)/.test(newPassword)) {
                    showNotification('Password must contain at least one uppercase letter, one lowercase letter, and one number', 'error');
                    return;
                }

                if (newPassword !== confirmPassword) {
                    showNotification('New passwords do not match', 'error');
                    return;
                }

                if (currentPassword === newPassword) {
                    showNotification('New password must be different from current password', 'error');
                    return;
                }

                // Show loading state
                submitBtn.disabled = true;
                submitBtn.textContent = 'Updating...';

                const formData = new FormData();
                formData.append('current_password', currentPassword);
                formData.append('new_password', newPassword);
                formData.append('confirm_password', confirmPassword);

                fetch('?page=change-password', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showNotification(data.message, 'success');
                            document.getElementById('change-password-form').reset();
                            togglePasswordForm();
                        } else {
                            showNotification(data.message, 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showNotification('An error occurred while updating password', 'error');
                    })
                    .finally(() => {
                        submitBtn.disabled = false;
                        submitBtn.textContent = 'Update Password';
                    });
            });
        }
    });

    // Modal functions
    function showDeactivationModal() {
        document.getElementById('deactivation-modal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function hideDeactivationModal() {
        document.getElementById('deactivation-modal').classList.add('hidden');
        document.body.style.overflow = 'auto';
        document.getElementById('deactivate-password').value = '';
    }

    function showDeletionModal() {
        document.getElementById('deletion-modal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function hideDeletionModal() {
        document.getElementById('deletion-modal').classList.add('hidden');
        document.body.style.overflow = 'auto';
        document.getElementById('delete-password').value = '';
        document.getElementById('delete-confirm').value = '';
    }

    // Account deactivation
    function confirmDeactivation() {
        const password = document.getElementById('deactivate-password').value;
        const confirmBtn = document.getElementById('deactivate-confirm-btn');

        if (!password) {
            showNotification('Please enter your password', 'error');
            return;
        }

        confirmBtn.disabled = true;
        confirmBtn.textContent = 'Deactivating...';

        const formData = new FormData();
        formData.append('password', password);

        fetch('?page=deactivate-account', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(data.message, 'success');
                    setTimeout(() => {
                        window.location.href = data.redirect;
                    }, 2000);
                } else {
                    showNotification(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('An error occurred while deactivating account', 'error');
            })
            .finally(() => {
                confirmBtn.disabled = false;
                confirmBtn.textContent = 'Deactivate Account';
            });
    }

    // Account deletion
    function confirmDeletion() {
        const password = document.getElementById('delete-password').value;
        const confirmText = document.getElementById('delete-confirm').value;
        const confirmBtn = document.getElementById('delete-confirm-btn');

        if (!password) {
            showNotification('Please enter your password', 'error');
            return;
        }

        if (confirmText.toUpperCase() !== 'DELETE MY ACCOUNT') {
            showNotification('Please type "DELETE MY ACCOUNT" exactly as shown', 'error');
            return;
        }

        confirmBtn.disabled = true;
        confirmBtn.textContent = 'Deleting...';

        const formData = new FormData();
        formData.append('password', password);
        formData.append('confirm_text', confirmText);

        fetch('?page=delete-account', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(data.message, 'success');
                    setTimeout(() => {
                        window.location.href = data.redirect;
                    }, 2000);
                } else {
                    showNotification(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('An error occurred while deleting account', 'error');
            })
            .finally(() => {
                confirmBtn.disabled = false;
                confirmBtn.textContent = 'Delete Account Permanently';
            });
    }

    // Notification system
    function showNotification(message, type = 'info') {
        // Remove existing notifications
        const existingNotifications = document.querySelectorAll('.notification');
        existingNotifications.forEach(notification => notification.remove());

        const notification = document.createElement('div');
        notification.className = `notification fixed top-4 right-4 z-[9999] max-w-sm p-4 rounded-lg shadow-lg transition-all duration-300 transform translate-x-0`;

        if (type === 'success') {
            notification.className += ' bg-green-500 text-white text-sm';
            notification.innerHTML = `<i class="mr-2 fas fa-check-circle"></i>${message}`;
        } else if (type === 'error') {
            notification.className += ' bg-red-500 text-white text-sm';
            notification.innerHTML = `<i class="mr-2 fas fa-exclamation-circle"></i>${message}`;
        } else {
            notification.className += ' bg-blue-500 text-white text-sm';
            notification.innerHTML = `<i class="mr-2 fas fa-info-circle"></i>${message}`;
        }

        document.body.appendChild(notification);

        // Auto-remove after 5 seconds
        setTimeout(() => {
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => notification.remove(), 300);
        }, 5000);
    }

    // Close modals with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            hideDeactivationModal();
            hideDeletionModal();
        }
    });
</script>