<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Notifications - Sikap</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-gray-50">
    <!-- Include Jobseeker Navbar -->
    <?php
    // filepath: c:\xampp\htdocs\sikap\app\views\jobseekers\notifications.php

    // Include authentication and navigation components like saved-jobs.php
    include_once __DIR__ . '/components/jobseeker_auth_check.php';
    include_once __DIR__ . '/../components/navbar-top.php';
    include_once __DIR__ . '/navbar-jobseeker.php';
    ?>

    <div class="px-6 py-8">
        <div class="mx-auto max-w-7xl">

            <!-- Success/Error Messages -->
            <?php if (isset($_GET['success'])): ?>
                <div class="p-4 mb-6 text-green-800 bg-green-100 border border-green-300 rounded-lg">
                    <?php echo htmlspecialchars($_GET['success']); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['error'])): ?>
                <div class="p-4 mb-6 text-red-800 bg-red-100 border border-red-300 rounded-lg">
                    <?php echo htmlspecialchars($_GET['error']); ?>
                </div>
            <?php endif; ?>

            <!-- Page Header - Similar to saved-jobs.php -->
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">All Notifications</h1>
                    <p class="mt-1 text-sm text-gray-600">
                        You have <span class="font-semibold text-blue-600"><?php echo $data['unreadCount']; ?></span> unread notifications
                    </p>
                </div>

                <?php if ($data['unreadCount'] > 0): ?>
                    <button onclick="markAllAsRead()"
                        class="px-4 py-2 font-medium text-white transition-colors duration-200 bg-blue-600 rounded-lg hover:bg-blue-700">
                        Mark All as Read
                    </button>
                <?php endif; ?>
            </div>

            <!-- Notifications List -->
            <?php if (empty($data['notifications'])): ?>
                <!-- Empty State - Similar to saved-jobs.php -->
                <div class="py-12 text-center">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4 19h6v-2H4v2zM20 4H4c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h4v-2H4V6h16v10h-2v2h2c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2z" />
                    </svg>
                    <h3 class="mb-2 text-lg font-medium text-gray-900">No notifications yet</h3>
                    <p class="mb-6 text-gray-500">We'll notify you when there's something new!</p>
                    <a href="?page=jobseeker-dashboard" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Back to Dashboard
                    </a>
                </div>
            <?php else: ?>
                <!-- Notifications Grid - Similar card structure to saved-jobs.php -->
                <div class="grid grid-cols-1 gap-6">
                    <?php foreach ($data['notifications'] as $notification): ?>
                        <div class="block overflow-hidden transition-all duration-300 bg-white border border-gray-200 rounded-lg hover:shadow-lg hover:border-gray-300 <?php echo $notification['status'] === 'unread' ? 'border-l-4 border-l-blue-500 bg-blue-50' : ''; ?>">

                            <!-- Header: Icon and Title -->
                            <div class="flex items-start gap-4 p-6 pb-4 <?php echo $notification['status'] === 'unread' ? 'bg-blue-50' : 'bg-gray-50'; ?>">
                                <!-- Notification Icon -->
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center w-12 h-12 rounded-full <?php
                                                                                                        echo $notification['type'] === 'program' ? 'bg-green-100' : ($notification['type'] === 'job_post' ? 'bg-blue-100' : ($notification['type'] === 'application_update' ? 'bg-orange-100' : ($notification['type'] === 'interview' ? 'bg-purple-100' : 'bg-gray-100'))); ?>">

                                        <?php if ($notification['type'] === 'job_post'): ?>
                                            <!-- Job Post Icon -->
                                            <svg class="w-6 h-6 text-blue-600" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
                                                <path d="M28,8H21V6a2,2,0,0,0-2-2H13a2,2,0,0,0-2,2V8H4a2,2,0,0,0-2,2V26a2,2,0,0,0,2,2H28a2,2,0,0,0,2-2V10A2,2,0,0,0,28,8ZM13,6h6V8H13Zm15,4v9H4V10ZM4,26V21H28v5Z"></path>
                                                <path d="M15,18h2a1,1,0,0,0,0-2H15a1,1,0,0,0,0,2Z"></path>
                                            </svg>
                                        <?php elseif ($notification['type'] === 'program'): ?>
                                            <!-- Program/Event Icon -->
                                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        <?php elseif ($notification['type'] === 'application_update'): ?>
                                            <!-- Application Update Icon -->
                                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        <?php elseif ($notification['type'] === 'interview'): ?>
                                            <!-- FIXED: Add Interview Icon -->
                                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        <?php else: ?>
                                            <!-- Default Icon -->
                                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-gray-900 <?php echo $notification['status'] === 'unread' ? 'font-bold' : ''; ?>">
                                        <?php echo htmlspecialchars($notification['title']); ?>
                                    </h3>
                                    <p class="text-sm text-gray-600">
                                        <?php
                                        $date = new DateTime($notification['created_at']);
                                        echo $date->format('M j, Y g:i A');
                                        ?>
                                    </p>
                                </div>

                                <!-- Unread indicator -->
                                <?php if ($notification['status'] === 'unread'): ?>
                                    <span class="flex-shrink-0 w-3 h-3 bg-blue-500 rounded-full"></span>
                                <?php endif; ?>
                            </div>

                            <!-- Card Body Content -->
                            <div class="p-6 pt-4">
                                <!-- Notification Message -->
                                <p class="mb-4 text-sm text-gray-700">
                                    <?php echo htmlspecialchars($notification['message']); ?>
                                </p>

                                <!-- Notification Type Tag -->
                                <div class="flex flex-wrap gap-2 mb-4">
                                    <span class="px-3 py-1 text-xs text-gray-600 bg-gray-100 rounded-full">
                                        <?php echo htmlspecialchars(ucfirst(str_replace('_', ' ', $notification['type']))); ?>
                                    </span>
                                    <?php if ($notification['status'] === 'unread'): ?>
                                        <span class="px-3 py-1 text-xs text-blue-700 bg-blue-100 rounded-full">
                                            Unread
                                        </span>
                                    <?php endif; ?>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex flex-col gap-2 sm:flex-row">
                                    <?php if ($notification['status'] === 'unread'): ?>
                                        <button onclick="markAsRead(<?php echo $notification['notification_id']; ?>)"
                                            class="px-4 py-2 text-sm font-medium text-blue-600 transition-colors duration-200 border border-blue-600 rounded-md hover:bg-blue-50">
                                            Mark as Read
                                        </button>
                                    <?php endif; ?>

                                    <?php if (!empty($notification['link'])): ?>
                                        <a href="<?php echo htmlspecialchars($notification['link']); ?>"
                                            onclick="<?php if ($notification['status'] === 'unread'): ?>markAsRead(<?php echo $notification['notification_id']; ?>)<?php endif; ?>"
                                            class="px-4 py-2 text-sm font-medium text-center text-white transition-colors duration-200 bg-blue-600 rounded-md hover:bg-blue-700">
                                            View Details
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- Pagination -->
            <?php if ($data['hasNextPage'] || $data['currentPage'] > 1): ?>
                <div class="flex justify-center mt-8">
                    <div class="flex gap-2">
                        <?php if ($data['currentPage'] > 1): ?>
                            <a href="?page=notifications-jobseeker&p=<?php echo $data['currentPage'] - 1; ?>"
                                class="px-4 py-2 transition-colors duration-200 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                Previous
                            </a>
                        <?php endif; ?>

                        <span class="px-4 py-2 text-white bg-blue-600 rounded-md">
                            Page <?php echo $data['currentPage']; ?>
                        </span>

                        <?php if ($data['hasNextPage']): ?>
                            <a href="?page=notifications-jobseeker&p=<?php echo $data['currentPage'] + 1; ?>"
                                class="px-4 py-2 transition-colors duration-200 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                Next
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- JavaScript - Similar to saved-jobs.php -->
    <script>
        function markAsRead(notificationId) {
            // Find the notification card
            const button = event.target;
            button.disabled = true;
            button.textContent = 'Marking...';

            const formData = new FormData();
            formData.append('action', 'mark_as_read');
            formData.append('notification_id', notificationId);

            fetch('?page=notifications-jobseeker', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.text();
                })
                .then(data => {
                    // Reload the page to show updated state
                    window.location.reload();
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('Error marking notification as read', 'error');
                    button.disabled = false;
                    button.textContent = 'Mark as Read';
                });
        }

        function markAllAsRead() {
            if (!confirm('Mark all notifications as read?')) {
                return;
            }

            const formData = new FormData();
            formData.append('action', 'mark_all_as_read');

            fetch('?page=notifications-jobseeker', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.text();
                })
                .then(data => {
                    // Reload the page to show updated state
                    window.location.reload();
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('Error marking all notifications as read', 'error');
                });
        }

        function showToast(message, type) {
            // Remove any existing toasts first
            const existingToasts = document.querySelectorAll('.toast-notification');
            existingToasts.forEach(toast => toast.remove());

            const toast = document.createElement('div');
            toast.className = `toast-notification fixed top-4 right-4 px-4 py-2 rounded-md shadow-lg z-50 transition-all duration-300 transform translate-x-0 ${
                type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
            }`;
            toast.textContent = message;

            document.body.appendChild(toast);

            // Animate in
            setTimeout(() => {
                toast.style.opacity = '1';
            }, 10);

            // Animate out and remove
            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transform = 'translateX(100%)';
                setTimeout(() => {
                    if (toast.parentNode) {
                        toast.parentNode.removeChild(toast);
                    }
                }, 300);
            }, 3000);
        }
    </script>
</body>

</html>