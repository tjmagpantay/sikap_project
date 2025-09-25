<?php
include_once __DIR__ . '/components/employer_auth_check.php';

// Check if $settings is passed from controller
if (!isset($settings)) {
    // If not called from controller, redirect to proper route
    header('Location: ?page=setting-employer');
    exit;
}

// Check if $employer is passed from controller  
if (!isset($employer)) {
    require_once __DIR__ . '/../../models/Employer.php';
    $employerModel = new Employer();
    $employer = $employerModel->findByUserId($_SESSION['user_id']);

    if ($employer === false) {
        $employer = ['business_name' => '', 'contact_person' => ''];
    }
}
?>

<?php include_once __DIR__ . '/../components/navbar-top.php';
include_once __DIR__ . '/components/navbar-employer.php';
?>

<div class="min-h-screen px-4 sm:px-6 md:px-16 lg:px-24">
    <div class="py-8 mx-auto sm:px-2 md:px-4 lg:px-12 max-w-7xl">
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
                <h1 class="text-2xl font-bold text-mainGray sm:text-3xl">Account Settings</h1>
            </div>
            <p class="text-sm text-gray-600 sm:text-base">Manage your company account security and preferences</p>
        </div>

        <!-- Settings Content -->
        <div class="space-y-6">
            <!-- Change Password -->
            <div class="p-4 bg-white rounded-lg shadow sm:p-6">
                <div class="flex flex-col items-start justify-between space-y-4 sm:flex-row sm:items-center sm:space-y-0">
                    <div class="flex-1">
                        <h3 class="text-lg font-medium text-gray-900">Change Password</h3>
                        <p class="mt-1 text-sm text-gray-600">Update your password to keep your account secure</p>
                    </div>
                    <button onclick="togglePasswordForm()"
                        class="flex items-center w-full px-4 py-2 text-sm font-medium transition-colors border rounded-md sm:w-auto border-primary text-primary bg-blue-50 hover:bg-blue-100">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m0 0a2 2 0 01-2 2H9a2 2 0 01-2-2m2-2h.01M15 7h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Change Password
                    </button>
                </div>

                <!-- Password Change Form (Hidden by default) -->
                <div id="password-form" class="hidden pt-4 mt-4 border-t border-gray-200 sm:pt-6 sm:mt-6">
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
                        <div class="flex flex-col gap-3 sm:flex-row">
                            <button type="submit"
                                class="w-full px-4 py-2 text-sm font-medium text-white transition-colors rounded-md sm:w-auto bg-primary hover:bg-secondary">
                                Update Password
                            </button>
                            <button type="button" onclick="togglePasswordForm()"
                                class="w-full px-4 py-2 text-sm font-medium text-gray-700 transition-colors bg-gray-100 rounded-md sm:w-auto hover:bg-gray-200">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Email Preferences -->
            <div class="p-4 bg-white rounded-lg shadow sm:p-6" id="email-preferences">
                <div class="mb-6">
                    <h3 class="text-lg font-medium text-gray-900">Email Preferences</h3>
                    <p class="mt-1 text-sm text-gray-600">Choose what emails you want to receive</p>
                </div>

                <div class="space-y-4 sm:space-y-6">
                    <div class="flex flex-col items-start justify-between space-y-3 sm:flex-row sm:items-center sm:space-y-0">
                        <div class="flex-1">
                            <h4 class="text-sm font-medium text-gray-900">Application Notifications</h4>
                            <p class="text-xs text-gray-500">Get notified when candidates apply to your job posts</p>
                        </div>
                        <div class="toggle-switch">
                            <input
                                type="checkbox"
                                id="application_notifications"
                                name="application_notifications"
                                value="1"
                                <?php echo (isset($settings['application_notifications']) && $settings['application_notifications'] == 1) ? 'checked' : ''; ?>>
                            <label for="application_notifications" class="toggle-label">
                                <span class="toggle-slider"></span>
                            </label>
                        </div>
                    </div>

                    <div class="flex flex-col items-start justify-between space-y-3 sm:flex-row sm:items-center sm:space-y-0">
                        <div class="flex-1">
                            <h4 class="text-sm font-medium text-gray-900">Candidate Matches</h4>
                            <p class="text-xs text-gray-500">Receive recommendations for qualified candidates</p>
                        </div>
                        <div class="toggle-switch">
                            <input
                                type="checkbox"
                                id="candidate_matches"
                                name="candidate_matches"
                                value="1"
                                <?php echo (isset($settings['candidate_matches']) && $settings['candidate_matches'] == 1) ? 'checked' : ''; ?>>
                            <label for="candidate_matches" class="toggle-label">
                                <span class="toggle-slider"></span>
                            </label>
                        </div>
                    </div>

                    <div class="flex flex-col items-start justify-between space-y-3 sm:flex-row sm:items-center sm:space-y-0">
                        <div class="flex-1">
                            <h4 class="text-sm font-medium text-gray-900">Job Post Updates</h4>
                            <p class="text-xs text-gray-500">Get notified about job post performance and statistics</p>
                        </div>
                        <div class="toggle-switch">
                            <input
                                type="checkbox"
                                id="job_post_updates"
                                name="job_post_updates"
                                value="1"
                                <?php echo (isset($settings['job_post_updates']) && $settings['job_post_updates'] == 1) ? 'checked' : ''; ?>>
                            <label for="job_post_updates" class="toggle-label">
                                <span class="toggle-slider"></span>
                            </label>
                        </div>
                    </div>

                    <div class="flex flex-col items-start justify-between space-y-3 sm:flex-row sm:items-center sm:space-y-0">
                        <div class="flex-1">
                            <h4 class="text-sm font-medium text-gray-900">Platform Updates</h4>
                            <p class="text-xs text-gray-500">Receive updates about new features and hiring insights</p>
                        </div>
                        <div class="toggle-switch">
                            <input
                                type="checkbox"
                                id="platform_updates"
                                name="platform_updates"
                                value="1"
                                <?php echo (isset($settings['platform_updates']) && $settings['platform_updates'] == 1) ? 'checked' : ''; ?>>
                            <label for="platform_updates" class="toggle-label">
                                <span class="toggle-slider"></span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Save Button -->
                <div class="flex justify-end mt-6">
                    <button id="save-email-preferences"
                        class="w-full px-4 py-2 text-white rounded-md sm:w-auto bg-primary hover:bg-secondary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        Save Preferences
                    </button>
                </div>
            </div>


            <!-- Account Information -->
            <div class="p-4 transition-shadow bg-white border border-gray-100 rounded-lg shadow-sm sm:p-6 hover:shadow-md">
                <div class="mb-6">
                    <h3 class="text-lg font-medium text-gray-900">Company Account Information</h3>
                    <p class="mt-1 text-sm text-gray-600">Your company account details and registration information</p>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-6">
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


            <!-- Danger Zone -->
            <div class="p-4 bg-white border-l-4 border-red-400 rounded-lg shadow sm:p-6">
                <div class="mb-6">
                    <h3 class="text-lg font-medium text-red-900">Danger Zone</h3>
                    <p class="mt-1 text-sm text-red-700">These actions cannot be undone and will affect your company account</p>
                </div>

                <div class="space-y-4">
                    <div class="flex flex-col items-start justify-between p-4 space-y-3 rounded-lg sm:flex-row sm:items-center sm:space-y-0 bg-red-50">
                        <div class="flex-1">
                            <h4 class="text-sm font-medium text-red-900">Deactivate Company Account</h4>
                            <p class="text-xs text-red-600">Temporarily disable your account and hide all job posts (can be reactivated)</p>
                        </div>
                        <button onclick="confirmDeactivation()"
                            class="w-full px-4 py-2 text-sm font-medium text-red-700 transition-colors bg-white border border-red-300 rounded-md sm:w-auto hover:bg-red-50">
                            Deactivate
                        </button>
                    </div>

                    <div class="flex flex-col items-start justify-between p-4 space-y-3 rounded-lg sm:flex-row sm:items-center sm:space-y-0 bg-red-50">
                        <div class="flex-1">
                            <h4 class="text-sm font-medium text-red-900">Delete Company Account</h4>
                            <p class="text-xs text-red-600">Permanently delete your company account, job posts, and all associated data</p>
                        </div>
                        <button onclick="confirmDeletion()"
                            class="w-full px-4 py-2 text-sm font-medium text-white transition-colors bg-red-600 rounded-md sm:w-auto hover:bg-red-700">
                            Delete Account
                        </button>
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

    // Handle settings updates
    document.addEventListener('DOMContentLoaded', function() {
        // Email Preferences Save Button
        const emailSaveBtn = document.getElementById('save-email-preferences');
        if (emailSaveBtn) {
            emailSaveBtn.addEventListener('click', function() {
                updateEmailPreferences();
            });
        }

        // Visibility Settings Save Button
        const visibilitySaveBtn = document.getElementById('save-visibility-settings');
        if (visibilitySaveBtn) {
            visibilitySaveBtn.addEventListener('click', function() {
                updateVisibilitySettings();
            });
        }

        // Hiring Preferences Save Button
        const hiringSaveBtn = document.getElementById('save-hiring-preferences');
        if (hiringSaveBtn) {
            hiringSaveBtn.addEventListener('click', function() {
                updateHiringPreferences();
            });
        }

        // Auto-save on toggle change (optional)
        const allToggles = document.querySelectorAll('input[type="checkbox"]');
        allToggles.forEach(toggle => {
            toggle.addEventListener('change', function() {
                // Auto-save functionality - you can remove this if you only want manual save
                const section = this.closest('[id$="-preferences"], [id$="-settings"]');
                if (section) {
                    const sectionId = section.id;
                    if (sectionId === 'email-preferences') {
                        setTimeout(() => updateEmailPreferences(), 500);
                    } else if (sectionId === 'visibility-settings') {
                        setTimeout(() => updateVisibilitySettings(), 500);
                    } else if (sectionId === 'hiring-preferences') {
                        setTimeout(() => updateHiringPreferences(), 500);
                    }
                }
            });
        });

        // Password form
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

    function updateEmailPreferences() {
        const formData = new FormData();
        formData.append('action', 'update_email_preferences');

        const applicationNotifications = document.getElementById('application_notifications');
        const candidateMatches = document.getElementById('candidate_matches');
        const jobPostUpdates = document.getElementById('job_post_updates');
        const platformUpdates = document.getElementById('platform_updates');

        formData.append('application_notifications', applicationNotifications && applicationNotifications.checked ? '1' : '0');
        formData.append('candidate_matches', candidateMatches && candidateMatches.checked ? '1' : '0');
        formData.append('job_post_updates', jobPostUpdates && jobPostUpdates.checked ? '1' : '0');
        formData.append('platform_updates', platformUpdates && platformUpdates.checked ? '1' : '0');

        // Show loading state
        const saveBtn = document.getElementById('save-email-preferences');
        if (saveBtn) {
            saveBtn.textContent = 'Saving...';
            saveBtn.disabled = true;
        }

        fetch('?page=update-employer-settings', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    showSuccessMessage('Email preferences updated successfully!');
                } else {
                    showErrorMessage('Error: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showErrorMessage('An error occurred while updating preferences. Please try again.');
            })
            .finally(() => {
                // Reset button state
                if (saveBtn) {
                    saveBtn.textContent = 'Save Preferences';
                    saveBtn.disabled = false;
                }
            });
    }

    function updateVisibilitySettings() {
        const formData = new FormData();
        formData.append('action', 'update_visibility_settings');

        const companyProfileVisibility = document.getElementById('company_profile_visibility');
        const contactInformation = document.getElementById('contact_information');
        const jobPostAnalytics = document.getElementById('job_post_analytics');

        formData.append('company_profile_visibility', companyProfileVisibility && companyProfileVisibility.checked ? '1' : '0');
        formData.append('contact_information', contactInformation && contactInformation.checked ? '1' : '0');
        formData.append('job_post_analytics', jobPostAnalytics && jobPostAnalytics.checked ? '1' : '0');

        // Show loading state
        const saveBtn = document.getElementById('save-visibility-settings');
        if (saveBtn) {
            saveBtn.textContent = 'Saving...';
            saveBtn.disabled = true;
        }

        fetch('?page=update-employer-settings', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    showSuccessMessage('Visibility settings updated successfully!');
                } else {
                    showErrorMessage('Error: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showErrorMessage('An error occurred while updating settings. Please try again.');
            })
            .finally(() => {
                // Reset button state
                if (saveBtn) {
                    saveBtn.textContent = 'Save Visibility Settings';
                    saveBtn.disabled = false;
                }
            });
    }

    function updateHiringPreferences() {
        const formData = new FormData();
        formData.append('action', 'update_hiring_preferences');

        const autoScreenApplications = document.getElementById('auto_screen_applications');
        const sendAutoReplies = document.getElementById('send_auto_replies');
        const priorityCandidateAlerts = document.getElementById('priority_candidate_alerts');

        formData.append('auto_screen_applications', autoScreenApplications && autoScreenApplications.checked ? '1' : '0');
        formData.append('send_auto_replies', sendAutoReplies && sendAutoReplies.checked ? '1' : '0');
        formData.append('priority_candidate_alerts', priorityCandidateAlerts && priorityCandidateAlerts.checked ? '1' : '0');

        // Show loading state
        const saveBtn = document.getElementById('save-hiring-preferences');
        if (saveBtn) {
            saveBtn.textContent = 'Saving...';
            saveBtn.disabled = true;
        }

        fetch('?page=update-employer-settings', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    showSuccessMessage('Hiring preferences updated successfully!');
                } else {
                    showErrorMessage('Error: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showErrorMessage('An error occurred while updating preferences. Please try again.');
            })
            .finally(() => {
                // Reset button state
                if (saveBtn) {
                    saveBtn.textContent = 'Save Hiring Preferences';
                    saveBtn.disabled = false;
                }
            });
    }

    function showSuccessMessage(message) {
        // Remove any existing messages
        const existing = document.querySelector('.success-message, .error-message');
        if (existing) {
            existing.remove();
        }

        // Create a new success message
        const alertDiv = document.createElement('div');
        alertDiv.className = 'success-message fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
        alertDiv.textContent = message;
        document.body.appendChild(alertDiv);

        setTimeout(() => {
            if (document.body.contains(alertDiv)) {
                document.body.removeChild(alertDiv);
            }
        }, 3000);
    }

    function showErrorMessage(message) {
        // Remove any existing messages
        const existing = document.querySelector('.success-message, .error-message');
        if (existing) {
            existing.remove();
        }

        // Create a new error message
        const alertDiv = document.createElement('div');
        alertDiv.className = 'error-message fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
        alertDiv.textContent = message;
        document.body.appendChild(alertDiv);

        setTimeout(() => {
            if (document.body.contains(alertDiv)) {
                document.body.removeChild(alertDiv);
            }
        }, 3000);
    }
</script>