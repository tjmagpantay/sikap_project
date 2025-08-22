<?php
// filepath: c:\xampp\htdocs\sikap\app\views\employers\setting-employer.php
require_once __DIR__ . '/../../models/Employer.php';

$employerModel = new Employer();
$employer = $employerModel->findByUserId($_SESSION['user_id']);

if ($employer === false) {
    $employer = ['business_name' => '', 'contact_person' => ''];
}
?>

<?php include_once __DIR__ . '/../components/navbar-top.php';
include_once __DIR__ . '/components/navbar-employer.php';
?>

<div class="min-h-screen">
    <div class="mx-auto sm:px-2 md:px-4 lg:px-12 max-w-7xl py-8">
        <!-- Header with breadcrumbs -->
        <div class="mb-8">
            <!-- Breadcrumb Navigation -->
            <nav class="flex mb-4" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="?page=employer-dashboard" class="inline-flex items-center text-sm text-gray-400 hover:text-gray-600">
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                            <a href="?page=profile-employer" class="ml-1 text-sm text-gray-400 hover:text-gray-600 md:ml-2">
                                Profile
                            </a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                            <span class="ml-1 text-sm text-primary md:ml-2">Account Settings</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="flex items-center mb-2 space-x-3">
                <h1 class="text-2xl font-bold text-gray-900">Account Settings</h1>
            </div>
            <p class="text-gray-600">Manage your company account security and preferences</p>
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
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m0 0a2 2 0 01-2 2H9a2 2 0 01-2-2m2-2h.01M15 7h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Change Password
                    </button>
                </div>

                <!-- Password Change Form (Hidden by default) -->
                <div id="password-form" class="hidden pt-6 mt-6 border-t border-gray-200">
                    <form class="max-w-md space-y-4">
                        <div>
                            <label for="current-password" class="block text-sm font-medium text-gray-700">Current Password</label>
                            <input type="password" id="current-password" name="current_password"
                                class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                        </div>
                        <div>
                            <label for="new-password" class="block text-sm font-medium text-gray-700">New Password</label>
                            <input type="password" id="new-password" name="new_password"
                                class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                        </div>
                        <div>
                            <label for="confirm-password" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                            <input type="password" id="confirm-password" name="confirm_password"
                                class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                        </div>
                        <div class="flex space-x-3">
                            <button type="submit"
                                class="px-4 py-2 text-sm font-medium text-white transition-colors rounded-md bg-primary hover:bg-secondary">
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

            <!-- Email Preferences -->
            <div class="p-6 bg-white rounded-lg shadow">
                <div class="mb-6">
                    <h3 class="text-lg font-medium text-gray-900">Email Preferences</h3>
                    <p class="mt-1 text-sm text-gray-600">Choose what emails you want to receive</p>
                </div>

                <div class="space-y-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-sm font-medium text-gray-900">Application Notifications</h4>
                            <p class="text-xs text-gray-500">Get notified when candidates apply to your job posts</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer" checked>
                            <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                        </label>
                    </div>

                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-sm font-medium text-gray-900">Candidate Matches</h4>
                            <p class="text-xs text-gray-500">Receive recommendations for qualified candidates</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer" checked>
                            <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                        </label>
                    </div>

                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-sm font-medium text-gray-900">Job Post Updates</h4>
                            <p class="text-xs text-gray-500">Get notified about job post performance and statistics</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer" checked>
                            <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                        </label>
                    </div>

                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-sm font-medium text-gray-900">Platform Updates</h4>
                            <p class="text-xs text-gray-500">Receive updates about new features and hiring insights</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                        </label>
                    </div>
                </div>

                <div class="mt-6">
                    <button class="px-4 py-2 text-sm font-medium text-white transition-colors rounded-md bg-primary hover:bg-secondary">
                        Save Preferences
                    </button>
                </div>
            </div>

            <!-- Company Visibility Settings -->
            <div class="p-6 bg-white rounded-lg shadow">
                <div class="mb-6">
                    <h3 class="text-lg font-medium text-gray-900">Company Visibility Settings</h3>
                    <p class="mt-1 text-sm text-gray-600">Control how your company appears to job seekers</p>
                </div>

                <div class="space-y-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-sm font-medium text-gray-900">Company Profile Visibility</h4>
                            <p class="text-xs text-gray-500">Allow job seekers to view your company profile and information</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer" checked>
                            <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                        </label>
                    </div>

                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-sm font-medium text-gray-900">Contact Information</h4>
                            <p class="text-xs text-gray-500">Display contact details on job posts and company profile</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer" checked>
                            <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                        </label>
                    </div>

                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-sm font-medium text-gray-900">Job Post Analytics</h4>
                            <p class="text-xs text-gray-500">Show application statistics and job performance metrics</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer" checked>
                            <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                        </label>
                    </div>
                </div>

                <div class="mt-6">
                    <button class="px-4 py-2 text-sm font-medium text-white transition-colors rounded-md bg-primary hover:bg-secondary">
                        Save Visibility Settings
                    </button>
                </div>
            </div>

            <!-- Account Information -->
            <div class="p-6 bg-white rounded-lg shadow">
                <div class="mb-6">
                    <h3 class="text-lg font-medium text-gray-900">Company Account Information</h3>
                    <p class="mt-1 text-sm text-gray-600">Your company account details and registration information</p>
                </div>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <p class="text-sm text-gray-500">Company Name</p>
                        <p class="text-sm font-medium text-gray-900">
                            <?php echo htmlspecialchars($employer['business_name'] ?? 'Not provided'); ?>
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Contact Person</p>
                        <p class="text-sm font-medium text-gray-900">
                            <?php echo htmlspecialchars($employer['contact_person'] ?? 'Not provided'); ?>
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Email Address</p>
                        <p class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($_SESSION['email'] ?? 'N/A'); ?></p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Account Type</p>
                        <p class="text-sm font-medium text-gray-900">Employer</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Member Since</p>
                        <p class="text-sm font-medium text-gray-900">
                            <?php echo isset($employer['created_at']) ? date('F j, Y', strtotime($employer['created_at'])) : date('F j, Y'); ?>
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Company Status</p>
                        <span class="inline-flex items-center px-2 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-full">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            Active
                        </span>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Active Job Posts</p>
                        <p class="text-sm font-medium text-gray-900">
                            <?php echo isset($employer['active_jobs_count']) ? $employer['active_jobs_count'] : '0'; ?> active
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total Applications Received</p>
                        <p class="text-sm font-medium text-gray-900">
                            <?php echo isset($employer['total_applications']) ? $employer['total_applications'] : '0'; ?> applications
                        </p>
                    </div>
                </div>
            </div>

            <!-- Hiring Preferences -->
            <div class="p-6 bg-white rounded-lg shadow">
                <div class="mb-6">
                    <h3 class="text-lg font-medium text-gray-900">Hiring Preferences</h3>
                    <p class="mt-1 text-sm text-gray-600">Set your default preferences for hiring and recruitment</p>
                </div>

                <div class="space-y-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-sm font-medium text-gray-900">Auto-screen Applications</h4>
                            <p class="text-xs text-gray-500">Automatically filter applications based on job requirements</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                        </label>
                    </div>

                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-sm font-medium text-gray-900">Send Auto-replies</h4>
                            <p class="text-xs text-gray-500">Automatically acknowledge receipt of applications</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer" checked>
                            <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                        </label>
                    </div>

                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-sm font-medium text-gray-900">Priority Candidate Alerts</h4>
                            <p class="text-xs text-gray-500">Get immediate alerts for high-priority candidate applications</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer" checked>
                            <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                        </label>
                    </div>
                </div>

                <div class="mt-6">
                    <button class="px-4 py-2 text-sm font-medium text-white transition-colors rounded-md bg-primary hover:bg-secondary">
                        Save Hiring Preferences
                    </button>
                </div>
            </div>

            <!-- Danger Zone -->
            <div class="p-6 bg-white border-l-4 border-red-400 rounded-lg shadow">
                <div class="mb-6">
                    <h3 class="text-lg font-medium text-red-900">Danger Zone</h3>
                    <p class="mt-1 text-sm text-red-700">These actions cannot be undone and will affect your company account</p>
                </div>

                <div class="space-y-4">
                    <div class="flex items-center justify-between p-4 rounded-lg bg-red-50">
                        <div>
                            <h4 class="text-sm font-medium text-red-900">Deactivate Company Account</h4>
                            <p class="text-xs text-red-600">Temporarily disable your account and hide all job posts (can be reactivated)</p>
                        </div>
                        <button onclick="confirmDeactivation()"
                            class="px-4 py-2 text-sm font-medium text-red-700 transition-colors bg-white border border-red-300 rounded-md hover:bg-red-50">
                            Deactivate
                        </button>
                    </div>

                    <div class="flex items-center justify-between p-4 rounded-lg bg-red-50">
                        <div>
                            <h4 class="text-sm font-medium text-red-900">Delete Company Account</h4>
                            <p class="text-xs text-red-600">Permanently delete your company account, job posts, and all associated data</p>
                        </div>
                        <button onclick="confirmDeletion()"
                            class="px-4 py-2 text-sm font-medium text-white transition-colors bg-red-600 rounded-md hover:bg-red-700">
                            Delete Account
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePasswordForm() {
        const form = document.getElementById('password-form');
        form.classList.toggle('hidden');
    }

    function confirmDeactivation() {
        if (confirm('Are you sure you want to deactivate your company account? This will hide all your job posts and prevent new applications. You can reactivate it later by logging in.')) {
            console.log('Company account deactivation requested');
            alert('Account deactivation functionality will be implemented.');
        }
    }

    function confirmDeletion() {
        if (confirm('Are you sure you want to permanently delete your company account? This will permanently remove all job posts, applications, and company data.')) {
            if (confirm('This is your final warning. Are you absolutely sure you want to delete your company account? This action cannot be undone and all hiring data will be lost.')) {
                console.log('Company account deletion requested');
                alert('Account deletion functionality will be implemented.');
            }
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const passwordForm = document.querySelector('#password-form form');
        if (passwordForm) {
            passwordForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const currentPassword = document.getElementById('current-password').value;
                const newPassword = document.getElementById('new-password').value;
                const confirmPassword = document.getElementById('confirm-password').value;

                if (!currentPassword || !newPassword || !confirmPassword) {
                    alert('Please fill in all password fields.');
                    return;
                }

                if (newPassword !== confirmPassword) {
                    alert('New passwords do not match.');
                    return;
                }

                if (newPassword.length < 6) {
                    alert('New password must be at least 6 characters long.');
                    return;
                }

                console.log('Password change requested');
                alert('Password change functionality will be implemented.');
            });
        }
    });
</script>