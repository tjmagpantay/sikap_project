<?php
// filepath: c:\xampp\htdocs\sikap\app\views\jobseekers\jobseeker-settings.php
require_once __DIR__ . '/../../models/Jobseeker.php';

$jobseekerModel = new Jobseeker();
$jobseeker = $jobseekerModel->findByUserId($_SESSION['user_id']);

if ($jobseeker === false) {
    $jobseeker = ['first_name' => '', 'last_name' => ''];
}
?>

<?php include_once __DIR__ . '/../components/navbar-top.php';
include_once __DIR__ . '/navbar-jobseeker.php';
?>

<div class="min-h-screen py-8 bg-gray-50 ">
    <div class="sm:mx-auto sm:w-full sm:max-w-2xl">
        <div class="flex flex-col gap-8 lg:flex-row">
            <!-- Left Sidebar -->
            <div class=" lg:w-1/3">
                <div class="sticky top-8">
                    <!-- Header -->
                    <div class="mb-6">
                        <h1 class="text-2xl font-bold text-gray-900">Account Settings</h1>
                        <p class="mt-1 text-xs text-gray-600">Manage your account preferences and settings</p>
                    </div>

                    <!-- Navigation Tabs -->
                    <div >
                        <nav class="space-y-2">
                            <button onclick="switchSettingsTab('general')"
                                id="tab-general"
                                class="flex items-center w-full px-3 py-3 text-sm font-medium text-left text-white transition-colors rounded-md settings-tab-button active bg-primary">
                                General Settings
                            </button>

                            <button onclick="switchSettingsTab('security')"
                                id="tab-security"
                                class="flex items-center w-full px-3 py-3 text-sm font-medium text-left text-gray-700 transition-colors rounded-md settings-tab-button hover:bg-gray-100"> 
                                Security & Privacy
                            </button>

                            <button onclick="switchSettingsTab('notifications')"
                                id="tab-notifications"
                                class="flex items-center w-full px-3 py-3 text-sm font-medium text-left text-gray-700 transition-colors rounded-md settings-tab-button hover:bg-gray-100">
                                Notifications
                            </button>
                        </nav>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="w-full lg:w-2/3">
                <div id="settings-content">
                    <!-- General Settings (Default) -->
                    <div id="general-content" class="settings-content-tab">
                        <div class="space-y-6">
                            <!-- Change Password -->
                            <div class="p-6 bg-white rounded-lg shadow">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <h3 class="text-lg font-medium text-gray-900">Change Password</h3>
                                        <p class="mt-1 text-sm text-gray-600">Update your password to keep your account secure</p>
                                    </div>
                                    <button onclick="togglePasswordForm()"
                                        class="flex items-center px-4 py-2 text-sm font-medium transition-colors border rounded-md border-primary text-primary hover:bg-primary hover:text-white">
                                        <i class="mr-2 fas fa-key"></i>
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
                                                class="px-4 py-2 text-sm font-medium text-white transition-colors rounded-md bg-primary hover:bg-primary-600">
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
                            <div class="p-6 bg-white rounded-lg shadow">
                                <div class="mb-6">
                                    <h3 class="text-lg font-medium text-gray-900">Account Information</h3>
                                    <p class="mt-1 text-sm text-gray-600">Your account details and registration information</p>
                                </div>

                                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                    <div>
                                        <p class="text-xs text-gray-500">Full Name</p>
                                        <p class="text-sm font-medium text-gray-900">
                                            <?php echo htmlspecialchars(trim(($jobseeker['first_name'] ?? '') . ' ' . ($jobseeker['last_name'] ?? ''))); ?>
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Email Address</p>
                                        <p class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($_SESSION['email'] ?? 'N/A'); ?></p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Account Type</p>
                                        <p class="text-sm font-medium text-gray-900">Job Seeker</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Member Since</p>
                                        <p class="text-sm font-medium text-gray-900">
                                            <?php echo date('F j, Y'); ?>
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Profile Status</p>
                                        <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-sm bg-blue-50 text-primary">
                                            Active
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Security & Privacy Tab -->
                    <div id="security-content" class="hidden settings-content-tab">
                        <div class="space-y-6">
                            <!-- Privacy Settings -->
                            <div class="p-6 bg-white rounded-lg shadow">
                                <div class="mb-6">
                                    <h3 class="text-lg font-medium text-gray-900">Privacy Settings</h3>
                                    <p class="mt-1 text-sm text-gray-600">Control who can see your profile and contact information</p>
                                </div>

                                <div class="space-y-6">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-900">Profile Visibility</h4>
                                            <p class="text-xs text-gray-500">Allow employers to find and view your profile</p>
                                        </div>
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" class="sr-only peer" checked>
                                            <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-primary/20 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                                        </label>
                                    </div>

                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-900">Contact Information</h4>
                                            <p class="text-xs text-gray-500">Show your contact details to potential employers</p>
                                        </div>
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" class="sr-only peer" checked>
                                            <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-primary/20 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                                        </label>
                                    </div>

                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-900">Resume Download</h4>
                                            <p class="text-xs text-gray-500">Allow employers to download your resume</p>
                                        </div>
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" class="sr-only peer" checked>
                                            <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-primary/20 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                                        </label>
                                    </div>
                                </div>

                                <div class="mt-6">
                                    <button class="px-4 py-2 text-sm font-medium text-white transition-colors rounded-md bg-primary hover:bg-primary-600">
                                        Save Privacy Settings
                                    </button>
                                </div>
                            </div>

                            <!-- Danger Zone -->
                            <div class="p-6 bg-white border-l-4 border-red-400 rounded-lg shadow">
                                <div class="mb-6">
                                    <h3 class="text-lg font-medium text-red-900">Danger Zone</h3>
                                    <p class="mt-1 text-sm text-red-700">These actions cannot be undone</p>
                                </div>

                                <div class="space-y-4">
                                    <div class="flex items-center justify-between p-4 rounded-lg bg-red-50">
                                        <div>
                                            <h4 class="text-sm font-medium text-red-900">Deactivate Account</h4>
                                            <p class="text-xs text-red-600">Temporarily disable your account (can be reactivated)</p>
                                        </div>
                                        <button onclick="confirmDeactivation()"
                                            class="px-4 py-2 text-sm font-medium text-red-700 transition-colors bg-white border border-red-300 rounded-md hover:bg-red-50">
                                            Deactivate
                                        </button>
                                    </div>

                                    <div class="flex items-center justify-between p-4 rounded-lg bg-red-50">
                                        <div>
                                            <h4 class="text-sm font-medium text-red-900">Delete Account</h4>
                                            <p class="text-xs text-red-600">Permanently delete your account and all associated data</p>
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

                    <!-- Notifications Tab -->
                    <div id="notifications-content" class="hidden settings-content-tab">
                        <div class="space-y-6">
                            <!-- Email Preferences -->
                            <div class="p-6 bg-white rounded-lg shadow">
                                <div class="mb-6">
                                    <h3 class="text-lg font-medium text-gray-900">Email Preferences</h3>
                                    <p class="mt-1 text-sm text-gray-600">Choose what emails you want to receive</p>
                                </div>

                                <div class="space-y-6">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-900">Job Recommendations</h4>
                                            <p class="text-xs text-gray-500">Receive personalized job recommendations based on your profile</p>
                                        </div>
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" class="sr-only peer" checked>
                                            <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-primary/20 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                                        </label>
                                    </div>

                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-900">Application Updates</h4>
                                            <p class="text-xs text-gray-500">Get notified when employers respond to your applications</p>
                                        </div>
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" class="sr-only peer" checked>
                                            <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-primary/20 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                                        </label>
                                    </div>

                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-900">Newsletter</h4>
                                            <p class="text-xs text-gray-500">Receive weekly updates about new features and job market insights</p>
                                        </div>
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" class="sr-only peer">
                                            <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-primary/20 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                                        </label>
                                    </div>
                                </div>

                                <div class="mt-6">
                                    <button class="px-4 py-2 text-sm font-medium text-white transition-colors rounded-md bg-primary hover:bg-primary-600">
                                        Save Preferences
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    
</div>
</div>
</div>

<script>
    let currentSettingsTab = 'general';

    function switchSettingsTab(tabName) {
        // Don't reload if already on this tab
        if (currentSettingsTab === tabName) return;

        // Hide all content tabs
        document.querySelectorAll('.settings-content-tab').forEach(tab => {
            tab.classList.add('hidden');
        });

        // Reset all tab buttons
        document.querySelectorAll('.settings-tab-button').forEach(button => {
            button.classList.remove('active', 'bg-primary', 'text-white');
            button.classList.add('text-gray-700', 'hover:bg-gray-100');
        });

        // Show active content
        const activeContent = document.getElementById(`${tabName}-content`);
        if (activeContent) {
            activeContent.classList.remove('hidden');
        }

        // Activate current tab button
        const activeButton = document.getElementById(`tab-${tabName}`);
        if (activeButton) {
            activeButton.classList.remove('text-gray-700', 'hover:bg-gray-100');
            activeButton.classList.add('active', 'bg-primary', 'text-white');
        }

        currentSettingsTab = tabName;
    }

    function togglePasswordForm() {
        const form = document.getElementById('password-form');
        form.classList.toggle('hidden');
    }

    function confirmDeactivation() {
        if (confirm('Are you sure you want to deactivate your account? You can reactivate it later by logging in.')) {
            console.log('Account deactivation requested');
            alert('Account deactivation functionality will be implemented.');
        }
    }

    function confirmDeletion() {
        if (confirm('Are you sure you want to permanently delete your account? This action cannot be undone and all your data will be lost.')) {
            if (confirm('This is your final warning. Are you absolutely sure you want to delete your account?')) {
                console.log('Account deletion requested');
                alert('Account deletion functionality will be implemented.');
            }
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Initialize the first tab
        switchSettingsTab('general');

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

<style>
    .settings-tab-button.active {
        background-color: var(--primary-color, #3B82F6);
        color: white;
    }

    .settings-content-tab {
        transition: opacity 0.3s ease;
    }
</style>