<?php
// filepath: c:\xampp\htdocs\sikap\app\views\admin\settings-admin.php
include_once __DIR__ . '/components/admin_auth_check.php';

// Admin data is now passed from the controller
// $admin is available from the controller
?>

<!-- Settings Content for Admin Dashboard Layout -->
<div class="space-y-6">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <!-- Left side: Title -->
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Admin Settings</h2>
                <p class="mt-1 text-sm text-gray-600">
                    Manage your admin account security and preferences
                </p>
            </div>


        </div>
    </div>

    <!-- Settings Content Grid -->
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">

        <!-- Left Column: Change Password -->
        <div class="space-y-6">
            <!-- Change Password Card -->
            <div class="p-6 transition-shadow duration-200 bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex-1">
                        <h3 class="text-lg font-medium text-gray-900">Change Password</h3>
                        <p class="mt-1 text-sm text-gray-600">Update your password to keep your admin account secure</p>
                    </div>
                    <button onclick="togglePasswordForm()" id="password-toggle-btn"
                        class="flex items-center px-4 py-2 text-sm font-medium transition-colors border rounded-md border-primary text-primary bg-blue-50 hover:bg-blue-100">
                        <i class="mr-2 fas fa-edit"></i>
                        Change Password
                    </button>
                </div>

                <!-- Password Change Form (Hidden by default) -->
                <div id="password-form" class="hidden py-4 pt-4 mt-4 border-t border-gray-200">
                    <form id="change-password-form" class="space-y-4">
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

                        <div class="flex gap-3 pt-2">
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

            <!-- Security Guidelines Card -->
            <div class="p-6 transition-shadow duration-200 bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md">
                <div class="mb-4">
                    <h3 class="text-lg font-medium text-blue-900">Security Guidelines</h3>
                    <p class="mt-1 text-sm text-blue-700">Important security practices for admin accounts</p>
                </div>

                <div class="space-y-3">
                    <div class="flex items-start p-3 rounded-lg bg-blue-50">
                        <svg class="w-5 h-5 mr-3 text-blue-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        <div>
                            <h4 class="text-sm font-medium text-blue-900">Strong Password</h4>
                            <p class="mt-1 text-xs text-blue-600">Use at least 8 characters with uppercase, lowercase, and numbers.</p>
                        </div>
                    </div>

                    <div class="flex items-start p-3 rounded-lg bg-blue-50">
                        <svg class="w-5 h-5 mr-3 text-blue-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        <div>
                            <h4 class="text-sm font-medium text-blue-900">Secure Logout</h4>
                            <p class="mt-1 text-xs text-blue-600">Always log out when finished and never share credentials.</p>
                        </div>
                    </div>

                    <div class="flex items-start p-3 rounded-lg bg-blue-50">
                        <svg class="w-5 h-5 mr-3 text-blue-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h4 class="text-sm font-medium text-blue-900">Regular Updates</h4>
                            <p class="mt-1 text-xs text-blue-600">Change your password regularly to maintain security.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Account Information -->
        <div class="space-y-6">
            <!-- Account Information Card -->
            <div class="p-6 transition-shadow duration-200 bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md">
                <div class="flex items-start gap-3 mb-6">
                    <div class="flex items-center justify-center w-12 h-12 rounded-full bg-primary">
                        <span class="text-lg font-bold text-white">
                            <?php echo isset($_SESSION['admin_name']) ? strtoupper(substr($_SESSION['admin_name'], 0, 2)) : 'AD'; ?>
                        </span>
                    </div>
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Account Information</h3>
                        <p class="mt-1 text-sm text-gray-600">Your admin account details and information</p>
                    </div>
                </div>

                <!-- 2-Column Grid Layout -->
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <!-- Admin Name -->
                    <div class="p-3 border border-gray-100 rounded-lg ">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="text-xs font-medium tracking-wide text-gray-500 uppercase">Admin Name</p>
                                <p class="mt-1 text-sm font-medium text-gray-900">
                                    <?php echo htmlspecialchars($admin['admin_name'] ?? 'Admin User'); ?>
                                </p>
                            </div>
                            <span class="inline-flex items-center px-2 py-1 text-xs font-medium text-blue-800 bg-blue-100 rounded-md">
                                <i class="mr-1 fas fa-user"></i>
                                Admin
                            </span>
                        </div>
                    </div>

                    <!-- Email Address -->
                    <div class="p-3 border border-gray-100 rounded-lg ">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="text-xs font-medium tracking-wide text-gray-500 uppercase">Email Address</p>
                                <p class="mt-1 text-sm font-medium text-gray-900 break-all">
                                    <?php echo htmlspecialchars($admin['email'] ?? 'N/A'); ?>
                                </p>
                            </div>
                            <span class="inline-flex items-center px-2 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-md">
                                <i class="mr-1 fas fa-check-circle"></i>
                                Verified
                            </span>
                        </div>
                    </div>

                    <!-- Account Type -->
                    <div class="p-3 border border-gray-100 rounded-lg ">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="text-xs font-medium tracking-wide text-gray-500 uppercase">Account Type</p>
                                <p class="mt-1 text-sm font-medium text-gray-900">Administrator</p>
                            </div>
                            <span class="inline-flex items-center px-2 py-1 text-xs font-medium text-purple-800 bg-purple-100 rounded-md">
                                <i class="mr-1 fas fa-crown"></i>
                                Full Access
                            </span>
                        </div>
                    </div>

                    <!-- Account Status -->
                    <div class="p-3 border border-gray-100 rounded-lg 0">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="text-xs font-medium tracking-wide text-gray-500 uppercase">Account Status</p>
                                <p class="mt-1 text-sm font-medium text-gray-900">Active</p>
                            </div>
                            <span class="inline-flex items-center px-2 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-md">
                                <i class="mr-1 text-green-600 fas fa-circle"></i>
                                Online
                            </span>
                        </div>
                    </div>

                    <!-- Admin Since -->
                    <div class="p-3 border border-gray-100 rounded-lg ">
                        <div>
                            <p class="text-xs font-medium tracking-wide text-gray-500 uppercase">Admin Since</p>
                            <p class="mt-1 text-sm font-medium text-gray-900">
                                <?php
                                if (isset($admin['createdAt'])) {
                                    echo date('F j, Y', strtotime($admin['createdAt']));
                                } else {
                                    echo date('F j, Y');
                                }
                                ?>
                            </p>
                        </div>
                    </div>

                    <!-- Last Updated -->
                    <div class="p-3 border border-gray-100 rounded-lg ">
                        <div>
                            <p class="text-xs font-medium tracking-wide text-gray-500 uppercase">Last Updated</p>
                            <p class="mt-1 text-sm font-medium text-gray-900">
                                <?php
                                if (isset($admin['updatedAt'])) {
                                    echo date('M j, Y g:i A', strtotime($admin['updatedAt']));
                                } else {
                                    echo 'Never';
                                }
                                ?>
                            </p>
                        </div>
                    </div>
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
        const toggleBtn = document.getElementById('password-toggle-btn');

        form.classList.toggle('hidden');

        // Update button text and icon
        if (form.classList.contains('hidden')) {
            toggleBtn.innerHTML = '<i class="mr-2 fas fa-edit"></i>Change Password';
            document.getElementById('change-password-form').reset();
        } else {
            toggleBtn.innerHTML = '<i class="mr-2 fas fa-times"></i>Cancel';
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

                fetch('?page=admin-change-password', {
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

    // Notification system
    function showNotification(message, type = 'info') {
        // Remove existing notifications
        const existingNotifications = document.querySelectorAll('.notification');
        existingNotifications.forEach(notification => notification.remove());

        const notification = document.createElement('div');
        // Increased z-index to 99999 and positioned at top-4 to appear above topbar
        notification.className = `notification fixed top-4 right-4 z-[99999] max-w-sm p-4 rounded-lg shadow-xl transition-all duration-300 transform translate-x-0`;

        if (type === 'success') {
            notification.className += ' bg-primary text-white text-sm';
            notification.innerHTML = `<i class="mr-2 fas fa-check-circle"></i>${message}`;
        } else if (type === 'error') {
            notification.className += ' bg-primary text-white text-sm';
            notification.innerHTML = `<i class="mr-2 fas fa-exclamation-circle"></i>${message}`;
        } else {
            notification.className += ' bg-primary text-white text-sm';
            notification.innerHTML = `<i class="mr-2 fas fa-info-circle"></i>${message}`;
        }

        document.body.appendChild(notification);

        // Alternative approach with inline styles if the above doesn't work:
        notification.style.cssText = `
            position: fixed;
            top: 16px;
            right: 16px;
            z-index: 99999;
            max-width: 24rem;
            padding: 1rem;
            border-radius: 0.5rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            transition: all 0.3s ease;
            transform: translateX(0);
        `;

        // Auto-remove after 5 seconds
        setTimeout(() => {
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => notification.remove(), 300);
        }, 5000);
    }
</script>