<?php
// Include authentication and navigation components like other pages
include_once __DIR__ . '/components/jobseeker_auth_check.php';
include_once __DIR__ . '/../components/navbar-top.php';

// Get jobseeker data before including navbar (same pattern as your other pages)
$jobseeker = null;
if (isset($_SESSION['user_id'])) {
    require_once __DIR__ . '/../../models/Jobseeker.php';
    $jobseekerModel = new Jobseeker();
    $jobseeker = $jobseekerModel->findByUserId($_SESSION['user_id']);
}

// If no jobseeker data, provide fallback (same as in your other pages)
if (!isset($jobseeker) || empty($jobseeker)) {
    $jobseeker = [
        'first_name' => '',
        'last_name' => '',
        'middle_name' => '',
        'suffix' => '',
        'profile_picture' => ''
    ];
}

include_once __DIR__ . '/components/navbar-jobseeker.php';
?>

<div class="min-h-screen px-4 sm:px-6 md:px-16 lg:px-24">
    <div class="py-8 mx-auto sm:px-2 md:px-4 lg:px-12 max-w-7xl">

        <!-- Breadcrumbs -->
        <nav class="mb-6">
            <div class="flex items-center space-x-2 text-sm">
                <a href="?page=dashboard" class="text-gray-500 transition-colors hover:text-primary">
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

        <!-- Info Messages for fallback scenarios -->
        <?php if (isset($_GET['info'])): ?>
            <div class="p-4 mb-6 text-blue-800 bg-blue-100 border border-blue-300 rounded-lg">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <?php echo htmlspecialchars($_GET['info']); ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Page Header - Same style as settings page -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <div class="flex items-center mb-2 space-x-3">
                        <h1 class="text-3xl font-bold text-grayMain">All Notifications</h1>
                    </div>
                    <p class="mt-2 text-sm text-gray-600">
                        You have <span class="font-semibold text-blue-600"><?php echo $data['unreadCount']; ?></span> unread notifications
                    </p>
                </div>

                <?php if ($data['unreadCount'] > 0): ?>
                    <button onclick="markAllAsRead()"
                        class="px-4 py-2 text-sm font-medium text-white transition-colors duration-200 rounded-md bg-primary hover:bg-secondary">
                        Mark All as Read
                    </button>
                <?php endif; ?>
            </div>
        </div>

        <!-- Notifications Content -->
        <div class="space-y-4">
            <?php if (empty($data['notifications'])): ?>
                <!-- Empty State - Similar to settings page layout -->
                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                    <div class="py-12 text-center">
                        <svg class="w-6 h-6 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4 19h6v-2H4v2zM20 4H4c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h4v-2H4V6h16v10h-2v2h2c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2z" />
                        </svg>
                        <h3 class="mb-2 text-lg font-medium text-gray-900">No notifications yet</h3>
                        <p class="mb-6 text-gray-500">We'll notify you when there's something new!</p>
                        <a href="?page=dashboard" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white border border-transparent rounded-md shadow-sm bg-primary hover:bg-secondary">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            Back to Dashboard
                        </a>
                    </div>
                </div>
            <?php else: ?>
                <!-- Notifications List - Improved Card Structure -->
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
                                                                                                            echo $notification['type'] === 'program' ? 'bg-green-100' : ($notification['type'] === 'job_post' ? 'bg-blue-100' : ($notification['type'] === 'application_update' ? 'bg-orange-100' : ($notification['type'] === 'interview' ? 'bg-purple-100' : ($notification['type'] === 'resignation_update' ? 'bg-red-100' : 'bg-gray-100')))); ?>">

                                            <?php if ($notification['type'] === 'job_post'): ?>
                                                <!-- Job Post Icon -->
                                                <svg class="w-5 h-5 text-blue-600" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
                                                    <path d="M28,8H21V6a2,2,0,0,0-2-2H13a2,2,0,0,0-2,2V8H4a2,2,0,0,0-2,2V26a2,2,0,0,0,2,2H28a2,2,0,0,0,2-2V10A2,2,0,0,0,28,8ZM13,6h6V8H13Zm15,4v9H4V10ZM4,26V21H28v5Z"></path>
                                                    <path d="M15,18h2a1,1,0,0,0,0-2H15a1,1,0,0,0,0,2Z"></path>
                                                </svg>
                                            <?php elseif ($notification['type'] === 'program'): ?>
                                                <!-- Program/Event Icon -->
                                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            <?php elseif ($notification['type'] === 'application_update'): ?>
                                                <!-- Application Update Icon -->
                                                <svg class="w-5 h-5 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            <?php elseif ($notification['type'] === 'interview'): ?>
                                                <!-- Interview Icon -->
                                                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            <?php elseif ($notification['type'] === 'resignation_update'): ?>
                                                <!-- Resignation Update Icon -->
                                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
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
        <?php
                    echo ($notification['type'] === 'program') ? 'bg-green-100 text-green-700'
                        : (($notification['type'] === 'job_post') ? 'bg-blue-100 text-blue-700'
                            : (($notification['type'] === 'application_update') ? 'bg-orange-100 text-orange-700'
                                : (($notification['type'] === 'interview') ? 'bg-purple-100 text-purple-700'
                                    : (($notification['type'] === 'resignation_update') ? 'bg-red-100 text-red-700'
                                        : 'bg-gray-100 text-gray-700'))));
        ?>">
                                        <?php echo htmlspecialchars(ucfirst(str_replace('_', ' ', $notification['type']))); ?>
                                    </span>

                                    <!-- Status Badge -->
                                    <?php if ($notification['status'] === 'unread'): ?>
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-500 text-primary">
                                            <span class="w-1.5 h-1.5 bg-gray-100 rounded-full mr-1.5"></span>
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
                            <p class="mb-4 text-xs leading-relaxed text-gray-700">
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
                                    <button onclick="handleNotificationClick('<?php echo htmlspecialchars($notification['link']); ?>', <?php echo $notification['notification_id']; ?>, '<?php echo $notification['status']; ?>'); event.stopPropagation();"
                                        class="flex items-center justify-center flex-shrink-0 px-3 py-2 text-xs font-medium text-white transition-colors rounded-md bg-primary hover:bg-secondary">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                        </svg>
                                        View Details
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

                <!-- Pagination -->
                <?php if ($data['hasNextPage'] || $data['currentPage'] > 1): ?>
                    <div class="flex justify-center py-6 mt-8 border-t border-gray-200">
                        <div class="flex items-center gap-2">
                            <?php if ($data['currentPage'] > 1): ?>
                                <a href="?page=notifications-jobseeker&p=<?php echo $data['currentPage'] - 1; ?>"
                                    class="flex items-center px-4 py-2 text-sm font-medium transition-colors bg-white border border-gray-300 rounded-md hover:bg-gray-50 hover:border-gray-400">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                    </svg>
                                    Previous
                                </a>
                            <?php endif; ?>

                            <span class="flex items-center px-4 py-2 text-sm font-semibold text-white rounded-md bg-primary">
                                Page <?php echo $data['currentPage']; ?>
                            </span>

                            <?php if ($data['hasNextPage']): ?>
                                <a href="?page=notifications-jobseeker&p=<?php echo $data['currentPage'] + 1; ?>"
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
</div>

<!-- Alpine.js -->
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

<!-- JavaScript - Same as other pages -->
<script>
    function markAsRead(notificationId) {
        const button = event.target;
        const originalText = button.innerHTML;
        button.disabled = true;
        button.innerHTML = '<svg class="w-3 h-3 mr-1.5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>Processing...';

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
                button.innerHTML = originalText;
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
        toast.className = `toast-notification fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg z-50 transition-all duration-300 transform translate-x-0 ${
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
    // FIXED: Enhanced notification click handler with proper fallback
    async function handleNotificationClick(link, notificationId, status) {
        // Mark as read if unread
        if (status === 'unread') {
            await markAsRead(notificationId);
        }

        // Navigate with fallback handling - FIXED: Proper error handling
        if (link) {
            try {
                // For job-related and application links, validate they exist
                if (link.includes('view-job') ||
                    link.includes('my-applications') ||
                    link.includes('view-application') ||
                    link.includes('apply-job')) {

                    // FIXED: Use a simpler approach - just try to navigate and handle errors
                    const tempLink = document.createElement('a');
                    tempLink.href = link;
                    tempLink.style.display = 'none';
                    document.body.appendChild(tempLink);

                    // Add error handler to window
                    const originalOnError = window.onerror;
                    window.onerror = function(msg, url, lineNo, columnNo, error) {
                        // Restore original handler
                        window.onerror = originalOnError;

                        // Show error message and stay on notifications page
                        showToast('The content you\'re looking for is no longer available or has expired.', 'error');
                        return true; // Prevent default error handling
                    };

                    // Try to navigate
                    setTimeout(() => {
                        try {
                            window.location.href = link;
                        } catch (navError) {
                            console.error('Navigation error:', navError);
                            showToast('Unable to access the requested content.', 'error');
                            // Stay on current page instead of white screen
                        }
                    }, 100);

                    // Clean up
                    document.body.removeChild(tempLink);

                } else {
                    // For other links (programs, general pages), navigate directly
                    window.location.href = link;
                }
            } catch (error) {
                console.error('Error handling notification click:', error);
                showToast('Unable to access the requested content.', 'error');
                // Don't navigate anywhere - stay on notifications page
            }
        }
    }

    // Update the existing View Details button click handler
    document.addEventListener('DOMContentLoaded', function() {
        // Update all "View Details" buttons to use the new handler
        document.querySelectorAll('a[onclick*="markAsRead"]').forEach(button => {
            const originalOnclick = button.getAttribute('onclick');
            const notificationId = originalOnclick.match(/markAsRead\((\d+)\)/)?.[1];
            const link = button.getAttribute('href');

            if (notificationId) {
                button.setAttribute('onclick', `handleNotificationClick('${link}', ${notificationId}, 'unread'); return false;`);
            }
        });
    });
</script>