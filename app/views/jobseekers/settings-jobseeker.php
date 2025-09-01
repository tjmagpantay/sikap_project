<?php
include_once __DIR__ . '/components/jobseeker_auth_check.php';
include_once __DIR__ . '/../components/navbar-top.php';
include_once __DIR__ . '/navbar-jobseeker.php';
?>

<div class="min-h-screen bg-gray-50">
    <div class="px-6 py-8">
        <div class="mx-auto max-w-7xl">
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
                        <form class="max-w-md mt-2 space-y-4">
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
                            <div class="flex gap-3">
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

                    <form id="email-preferences-form">
                        <div class="space-y-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">Job Recommendations</h4>
                                    <p class="text-xs text-gray-500">
                                        Receive personalized job recommendations based on your profile
                                    </p>
                                </div>
                                <div class="toggle-switch">
                                    <input
                                        type="checkbox"
                                        id="job_recommendations"
                                        name="job_recommendations"
                                        value="1"
                                        <?php echo (isset($settings['job_recommendations']) && $settings['job_recommendations'] == 1) ? 'checked' : ''; ?>>
                                    <label for="job_recommendations" class="toggle-label">
                                        <span class="toggle-slider"></span>
                                    </label>
                                </div>
                            </div>

                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">Application Updates</h4>
                                    <p class="text-xs text-gray-500">Get notified when employers respond to your applications</p>
                                </div>
                                <div class="toggle-switch">
                                    <input
                                        type="checkbox"
                                        id="application_updates"
                                        name="application_updates"
                                        value="1"
                                        <?php echo (isset($settings['application_updates']) && $settings['application_updates'] == 1) ? 'checked' : ''; ?>>
                                    <label for="application_updates" class="toggle-label">
                                        <span class="toggle-slider"></span>
                                    </label>
                                </div>
                            </div>

                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">Programs and News</h4>
                                    <p class="text-xs text-gray-500">Receive weekly updates about new features and job market insights</p>
                                </div>
                                <div class="toggle-switch">
                                    <input
                                        type="checkbox"
                                        id="programs_news"
                                        name="programs_news"
                                        value="1"
                                        <?php echo (isset($settings['programs_news']) && $settings['programs_news'] == 1) ? 'checked' : ''; ?>>
                                    <label for="programs_news" class="toggle-label">
                                        <span class="toggle-slider"></span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="px-4 py-2 text-sm font-medium text-white transition-colors rounded-md bg-primary hover:bg-secondary">
                                Save Preferences
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Privacy Settings -->
                <div class="p-6 bg-white rounded-lg shadow">
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Privacy Settings</h3>
                        <p class="mt-1 text-sm text-gray-600">Control who can see your profile and contact information</p>
                    </div>

                    <form id="privacy-settings-form">
                        <div class="space-y-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">Profile Visibility</h4>
                                    <p class="text-xs text-gray-500">Allow employers to find and view your profile</p>
                                </div>
                                <div class="toggle-switch">
                                    <input
                                        type="checkbox"
                                        id="profile_visibility"
                                        name="profile_visibility"
                                        value="1"
                                        <?php echo (isset($settings['profile_visibility']) && $settings['profile_visibility'] == 1) ? 'checked' : ''; ?>>
                                    <label for="profile_visibility" class="toggle-label">
                                        <span class="toggle-slider"></span>
                                    </label>
                                </div>
                            </div>

                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">Contact Information</h4>
                                    <p class="text-xs text-gray-500">Show your contact details to potential employers</p>
                                </div>
                                <div class="toggle-switch">
                                    <input
                                        type="checkbox"
                                        id="contact_information"
                                        name="contact_information"
                                        value="1"
                                        <?php echo (isset($settings['contact_information']) && $settings['contact_information'] == 1) ? 'checked' : ''; ?>>
                                    <label for="contact_information" class="toggle-label">
                                        <span class="toggle-slider"></span>
                                    </label>
                                </div>
                            </div>

                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">Resume Download</h4>
                                    <p class="text-xs text-gray-500">Allow employers to download your resume</p>
                                </div>
                                <div class="toggle-switch">
                                    <input
                                        type="checkbox"
                                        id="resume_download"
                                        name="resume_download"
                                        value="1"
                                        <?php echo (isset($settings['resume_download']) && $settings['resume_download'] == 1) ? 'checked' : ''; ?>>
                                    <label for="resume_download" class="toggle-label">
                                        <span class="toggle-slider"></span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="px-4 py-2 text-sm font-medium text-white transition-colors rounded-md bg-primary hover:bg-secondary">
                                Save Privacy Settings
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Account Information -->
                <div class="p-4 transition-shadow bg-white border border-gray-100 rounded-lg shadow-sm sm:p-6 hover:shadow-md">
                    <div class="flex items-start gap-3 mb-6">
                        <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-indigo-50">
                            <i class="text-lg text-indigo-600 fas fa-user-circle"></i>
                        </div>
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
                                <?php echo date('F j, Y'); ?>
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Profile Status</p>
                            <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-blue-100 text-primary">
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
                            <button onclick="confirmDeactivation()"
                                class="px-4 py-2 text-sm font-medium text-red-700 transition-colors bg-white border border-red-300 rounded-md hover:bg-red-100">
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
    </div>
</div>

<style>
    /* Custom Toggle Switch Styles */
    .toggle-switch {
        position: relative;
        display: inline-block;
    }

    .toggle-switch input[type="checkbox"] {
        display: none;
    }

    .toggle-label {
        position: relative;
        display: block;
        width: 44px;
        height: 24px;
        cursor: pointer;
        border-radius: 12px;
        background-color: #e5e7eb;
        transition: background-color 0.3s ease;
    }

    .toggle-slider {
        position: absolute;
        top: 2px;
        left: 2px;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background-color: white;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s ease;
    }

    /* Changed from green to primary color */
    .toggle-switch input[type="checkbox"]:checked+.toggle-label {
        background-color: var(--primary-color, #3b82f6);
    }

    .toggle-switch input[type="checkbox"]:checked+.toggle-label .toggle-slider {
        transform: translateX(20px);
    }

    .toggle-switch input[type="checkbox"]:focus+.toggle-label {
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
    }

    /* Fallback if CSS variables not available */
    .toggle-switch input[type="checkbox"]:checked+.toggle-label {
        background-color: #3b82f6;
    }
</style>

<script>
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

    // Handle email preferences form
    document.getElementById('email-preferences-form').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData();
        formData.append('action', 'update_email_preferences');

        // Get checkbox values - send 1 if checked, 0 if not checked
        const jobRecommendations = document.getElementById('job_recommendations');
        const applicationUpdates = document.getElementById('application_updates');
        const programsNews = document.getElementById('programs_news');

        // Always send values (1 for checked, 0 for unchecked)
        formData.append('job_recommendations', jobRecommendations.checked ? '1' : '0');
        formData.append('application_updates', applicationUpdates.checked ? '1' : '0');
        formData.append('programs_news', programsNews.checked ? '1' : '0');

        // Show loading state
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.textContent;
        submitBtn.textContent = 'Saving...';
        submitBtn.disabled = true;

        fetch('?page=update-jobseeker-settings', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Email preferences updated successfully!');
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while updating preferences.');
            })
            .finally(() => {
                // Reset button state
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            });
    });

    // Handle privacy settings form
    document.getElementById('privacy-settings-form').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData();
        formData.append('action', 'update_privacy_settings');

        // Get checkbox values - send 1 if checked, 0 if not checked
        const profileVisibility = document.getElementById('profile_visibility');
        const contactInformation = document.getElementById('contact_information');
        const resumeDownload = document.getElementById('resume_download');

        // Always send values (1 for checked, 0 for unchecked)
        formData.append('profile_visibility', profileVisibility.checked ? '1' : '0');
        formData.append('contact_information', contactInformation.checked ? '1' : '0');
        formData.append('resume_download', resumeDownload.checked ? '1' : '0');

        // Show loading state
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.textContent;
        submitBtn.textContent = 'Saving...';
        submitBtn.disabled = true;

        fetch('?page=update-jobseeker-settings', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Privacy settings updated successfully!');
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while updating settings.');
            })
            .finally(() => {
                // Reset button state
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            });
    });

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