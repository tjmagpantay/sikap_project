<?php
// Remove the auth check since dashboard.php already handles it
// Content-only page - no HTML structure, no auth check
?>

<!-- Remove ALL HTML structure - make it content-only like main-board.php -->
<div class="space-y-6">
    <!-- Breadcrumbs -->
    <nav class="mb-6">
        <div class="flex items-center space-x-2 text-sm">
            <a href="?page=admin-dashboard" class="text-gray-500 transition-colors hover:text-primary">
                Dashboard
            </a>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            <span class="font-medium text-primary">Notifications</span>
        </div>
    </nav>

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

    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center mb-2 space-x-3">
                    <h1 class="text-3xl font-bold text-gray-900">All Notifications</h1>
                </div>
                <p class="mt-2 text-sm text-gray-600">
                    You have <span class="font-semibold text-blue-600"><?php echo $data['unreadCount'] ?? 0; ?></span> unread notifications
                </p>
            </div>

            <?php if (($data['unreadCount'] ?? 0) > 0): ?>
                <button onclick="markAllAsRead()"
                    class="px-4 py-2 text-sm font-medium text-white transition-colors duration-200 rounded-md bg-primary hover:bg-secondary">
                    Mark All as Read
                </button>
            <?php endif; ?>
        </div>
    </div>

    <!-- Notifications Content -->
    <div class="space-y-4">
        <?php if (empty($data['notifications']) || !isset($data['notifications'])): ?>
            <!-- Empty State -->
            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                <div class="py-12 text-center">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4 19h6v-2H4v2zM20 4H4c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h4v-2H4V6h16v10h-2v2h2c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2z" />
                    </svg>
                    <h3 class="mb-2 text-lg font-medium text-gray-900">No notifications yet</h3>
                    <p class="mb-6 text-gray-500">System notifications will appear here when employers submit accreditation requests or other admin actions are needed.</p>
                    <a href="?page=admin-dashboard" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white border border-transparent rounded-md shadow-sm bg-primary hover:bg-secondary">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Back to Dashboard
                    </a>
                </div>
            </div>
        <?php else: ?>
            <!-- Notifications List -->
            <?php foreach ($data['notifications'] as $notification): ?>
                <div class="overflow-hidden bg-white border border-gray-200 rounded-lg shadow-sm transition-all duration-300 hover:shadow-md hover:border-gray-300 <?php echo $notification['status'] === 'unread' ? 'border-l-4 border-l-blue-500' : ''; ?>">

                    <!-- Card Header -->
                    <div class="relative p-4 border-b border-gray-100 <?php echo $notification['status'] === 'unread' ? 'bg-blue-50' : 'bg-gray-50'; ?>">
                        <div class="flex items-start justify-between">
                            <!-- Left side: Icon and Title -->
                            <div class="flex items-start gap-3">
                                <!-- Notification Icon -->
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center w-10 h-10 rounded-full <?php
                                        echo $notification['type'] === 'accreditation' ? 'bg-orange-100' : 
                                            ($notification['type'] === 'job_post' ? 'bg-blue-100' : 
                                            ($notification['type'] === 'resignation_update' ? 'bg-red-100' : 'bg-gray-100')); ?>">

                                        <?php if ($notification['type'] === 'accreditation'): ?>
                                            <!-- Accreditation Icon -->
                                            <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                            </svg>
                                        <?php elseif ($notification['type'] === 'resignation_update'): ?>
                                            <!-- Resignation Icon -->
                                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                            </svg>
                                        <?php elseif ($notification['type'] === 'job_post'): ?>
                                            <!-- Job Post Icon -->
                                            <svg class="w-5 h-5 text-blue-600" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
                                                <path d="M28,8H21V6a2,2,0,0,0-2-2H13a2,2,0,0,0-2,2V8H4a2,2,0,0,0-2,2V26a2,2,0,0,0,2,2H28a2,2,0,0,0,2-2V10A2,2,0,0,0,28,8ZM13,6h6V8H13Zm15,4v9H4V10ZM4,26V21H28v5Z"></path>
                                                <path d="M15,18h2a1,1,0,0,0,0-2H15a1,1,0,0,0,0,2Z"></path>
                                            </svg>
                                        <?php else: ?>
                                            <!-- Default Icon -->
                                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!-- Title and Time -->
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-gray-900 <?php echo $notification['status'] === 'unread' ? 'font-bold' : ''; ?>">
                                        <?php echo htmlspecialchars($notification['title']); ?>
                                    </h3>
                                    <p class="mt-1 text-xs text-gray-500">
                                        <?php
                                        $date = new DateTime($notification['created_at']);
                                        echo $date->format('M j, Y g:i A');
                                        ?>
                                    </p>
                                </div>
                            </div>

                            <!-- Right side: Badges -->
                            <div class="flex flex-row items-center gap-2 ml-4">
                                <!-- Type Badge -->
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium 
                                    <?php echo $notification['type'] === 'accreditation' ? 'bg-orange-100 text-orange-700' : 
                                        ($notification['type'] === 'job_post' ? 'bg-blue-100 text-blue-700' : 
                                        ($notification['type'] === 'resignation_update' ? 'bg-red-100 text-red-700' : 'bg-gray-100 text-gray-700')); ?>">
                                    <?php echo htmlspecialchars(ucfirst(str_replace('_', ' ', $notification['type']))); ?>
                                </span>

                                <!-- Status Badge -->
                                <?php if ($notification['status'] === 'unread'): ?>
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-500 text-white">
                                        <span class="w-1.5 h-1.5 bg-white rounded-full mr-1.5"></span>
                                        New
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                        Read
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="p-4">
                        <!-- Notification Message -->
                        <p class="mb-4 text-sm leading-relaxed text-gray-700">
                            <?php echo htmlspecialchars($notification['message']); ?>
                        </p>

                        <!-- Action Buttons -->
                        <div class="flex flex-row items-end gap-2 py-2 border-t border-gray-100">
                            <?php if ($notification['status'] === 'unread'): ?>
                                <button onclick="markAsRead(<?php echo $notification['notification_id']; ?>)"
                                    class="flex items-center justify-center flex-shrink-0 px-3 py-2 text-xs font-medium text-gray-700 transition-colors bg-white border border-gray-300 rounded-md hover:bg-gray-50 hover:border-gray-400">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Mark as Read
                                </button>
                            <?php endif; ?>

                            <?php if (!empty($notification['link'])): ?>
                                <a href="<?php echo htmlspecialchars($notification['link']); ?>"
                                    onclick="<?php if ($notification['status'] === 'unread'): ?>markAsRead(<?php echo $notification['notification_id']; ?>)<?php endif; ?>"
                                    class="flex items-center justify-center flex-shrink-0 px-3 py-2 text-xs font-medium text-white transition-colors rounded-md bg-primary hover:bg-secondary">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                    </svg>
                                    Review Request
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

            <!-- Pagination -->
            <?php if (($data['hasNextPage'] ?? false) || ($data['currentPage'] ?? 1) > 1): ?>
                <div class="flex justify-center py-6 mt-8 border-t border-gray-200">
                    <div class="flex items-center gap-2">
                        <?php if (($data['currentPage'] ?? 1) > 1): ?>
                            <a href="?page=notifications-admin&p=<?php echo ($data['currentPage'] ?? 1) - 1; ?>"
                                class="flex items-center px-4 py-2 text-sm font-medium transition-colors bg-white border border-gray-300 rounded-md hover:bg-gray-50 hover:border-gray-400">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                </svg>
                                Previous
                            </a>
                        <?php endif; ?>

                        <span class="flex items-center px-4 py-2 text-sm font-semibold text-white rounded-md bg-primary">
                            Page <?php echo $data['currentPage'] ?? 1; ?>
                        </span>

                        <?php if ($data['hasNextPage'] ?? false): ?>
                            <a href="?page=notifications-admin&p=<?php echo ($data['currentPage'] ?? 1) + 1; ?>"
                                class="flex items-center px-4 py-2 text-sm font-medium transition-colors bg-white border border-gray-300 rounded-md hover:bg-gray-50 hover:border-gray-400">
                                Next
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

<!-- JavaScript -->
<script>
    function markAsRead(notificationId) {
        const button = event.target.closest('button');
        const originalText = button.innerHTML;
        button.disabled = true;
        button.innerHTML = '<svg class="w-3 h-3 mr-1.5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>Processing...';

        const formData = new FormData();
        formData.append('action', 'mark_as_read');
        formData.append('notification_id', notificationId);

        fetch('?page=notifications-admin', {
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
                button.innerHTML = originalText;
            });
    }

    function markAllAsRead() {
        if (!confirm('Mark all notifications as read?')) {
            return;
        }

        const formData = new FormData();
        formData.append('action', 'mark_all_as_read');

        fetch('?page=notifications-admin', {
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
        // Toast notification functionality
        const toast = document.createElement('div');
        toast.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg z-50 transition-all duration-300 transform translate-x-0 ${
            type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
        }`;
        toast.innerHTML = `
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    ${type === 'success' ? 
                        '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>' :
                        '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>'
                    }
                </svg>
                ${message}
            </div>
        `;

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