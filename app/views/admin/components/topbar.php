<header class="sticky top-0 z-30 flex-shrink-0 bg-white border-b border-gray-200 shadow-sm">
    <div class="flex items-center justify-between px-6 py-4">
        <!-- Left Section: Mobile menu button, logos, and title -->
        <div class="flex items-center gap-3">
            <!-- Mobile menu button -->
            <button onclick="toggleMobileSidebar()" class="p-2 text-gray-500 rounded-md hover:text-gray-900 hover:bg-gray-100 lg:hidden" data-mobile-menu>
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            <!-- Logo and Title Section -->
            <div class="flex items-center gap-2">
                <img src="/sikap/public/assets/images/peso-logo.png" alt="PESO Logo" class="w-auto h-8">
                <img src="/sikap/public/assets/images/sikap-logo.png" alt="SIKAP Logo" class="w-auto h-8 shadow-sm">
                <a href="?page=admin-dashboard" class="text-xl font-medium text-primary">
                    Sikap <span class="text-secondary">Admin</span>
                </a>
            </div>
        </div>

        <!-- Right Section: Notifications and Profile -->
        <div class="flex items-center space-x-4">
            <!-- Notifications -->
            <div x-data="adminNotificationDropdown()" class="relative">
                <button
                    @click="toggleNotifications()"
                    class="relative flex items-center justify-center p-2 text-gray-400 transition-colors rounded-md hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">

                    <!-- Notification Badge -->
                    <span x-show="unreadCount > 0"
                        x-text="unreadCount"
                        class="absolute -top-1 -right-1 flex items-center justify-center min-w-[16px] h-4 px-1 text-xs font-bold text-white bg-red-500 rounded-full"
                        :class="unreadCount > 99 ? 'text-[9px] px-1' : ''">
                    </span>

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                        class="w-6 h-6 text-gray-500 transition-colors duration-200">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 
                        8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 
                        8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 
                        5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 
                        0m5.714 0a3 3 0 1 1-5.714 0" />
                    </svg>
                </button>

                <!-- Notification Dropdown -->
                <div
                    x-show="isOpen"
                    x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="transform opacity-0 scale-95"
                    x-transition:enter-end="transform opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="transform opacity-100 scale-100"
                    x-transition:leave-end="transform opacity-0 scale-95"
                    @click.away="isOpen = false"
                    class="absolute right-0 z-50 mt-3 overflow-hidden bg-white border border-gray-200 rounded-lg shadow-xl w-[400px] max-h-[500px]"
                    style="display: none; top: calc(100% + 8px);">

                    <!-- Header -->
                    <div class="flex items-center justify-between px-4 py-3 border-b bg-gradient-to-r from-blue-50 to-indigo-50">
                        <h3 class="text-sm font-semibold text-gray-800">Notifications</h3>
                        <button @click="markAllAsRead()"
                            x-show="unreadCount > 0"
                            class="px-2 py-1 text-xs font-medium text-blue-600 transition-colors duration-200 rounded hover:text-blue-800 hover:bg-blue-100">
                            Mark all read
                        </button>
                    </div>

                    <!-- Loading State -->
                    <template x-if="loading">
                        <div class="flex items-center justify-center px-4 py-6 text-gray-500">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                </svg>
                                <span class="text-sm">Loading...</span>
                            </div>
                        </div>
                    </template>

                    <!-- Error State -->
                    <template x-if="error && !loading">
                        <div class="px-4 py-6 text-center text-red-500">
                            <p x-text="error" class="mb-2 text-sm"></p>
                            <button @click="fetchNotifications()"
                                class="px-3 py-1 text-xs font-medium text-blue-600 transition-colors duration-200 rounded hover:text-blue-800 hover:bg-blue-50">
                                Try again
                            </button>
                        </div>
                    </template>

                    <!-- Notifications List -->
                    <div class="overflow-y-auto max-h-80">
                        <!-- Empty State -->
                        <template x-if="notifications.length === 0 && !loading && !error">
                            <div class="px-4 py-8 text-center">
                                <svg class="w-10 h-10 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 17h5l-5 5v-5zM4 19h6v-2H4v2zM20 4H4c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h4v-2H4V6h16v10h-2v2h2c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2z" />
                                </svg>
                                <p class="text-sm font-medium text-gray-500">No notifications yet</p>
                                <p class="mt-1 text-xs text-gray-400">We'll notify you when there's something new!</p>
                            </div>
                        </template>

                        <!-- Notification Items -->
                        <template x-for="notification in notifications" :key="notification.notification_id">
                            <div class="transition-all duration-200 border-b border-gray-100 cursor-pointer hover:bg-gray-50"
                                :class="notification.status === 'unread' ? 'bg-blue-50 border-l-4 border-l-blue-500' : ''"
                                @click="handleNotificationClick(notification)">
                                <div class="px-4 py-3">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-start">
                                                <div class="flex-shrink-0">
                                                    <div class="flex items-center justify-center rounded-full w-7 h-7"
                                                        :class="notification.type === 'program' ? 'bg-green-100' : 
                                                               (notification.type === 'job_post' ? 'bg-blue-100' : 
                                                               (notification.type === 'accreditation' ? 'bg-orange-100' : 'bg-gray-100'))">

                                                        <!-- Job Post Icon -->
                                                        <template x-if="notification.type === 'job_post'">
                                                            <svg class="w-4 h-4 text-blue-600" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
                                                                <path d="M28,8H21V6a2,2,0,0,0-2-2H13a2,2,0,0,0-2,2V8H4a2,2,0,0,0-2,2V26a2,2,0,0,0,2,2H28a2,2,0,0,0,2-2V10A2,2,0,0,0,28,8ZM13,6h6V8H13Zm15,4v9H4V10ZM4,26V21H28v5Z"></path>
                                                                <path d="M15,18h2a1,1,0,0,0,0-2H15a1,1,0,0,0,0,2Z"></path>
                                                            </svg>
                                                        </template>

                                                        <!-- Accreditation Icon -->
                                                        <template x-if="notification.type === 'accreditation'">
                                                            <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                    d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                                            </svg>
                                                        </template>

                                                        <!-- Default Icon -->
                                                        <template x-if="notification.type !== 'job_post' && notification.type !== 'accreditation'">
                                                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg>
                                                        </template>
                                                    </div>
                                                </div>
                                                <div class="flex-1 ml-2">
                                                    <h4 class="text-sm font-medium leading-4 text-gray-900"
                                                        :class="notification.status === 'unread' ? 'font-semibold' : ''"
                                                        x-text="notification.title">
                                                    </h4>
                                                    <p class="mt-1 text-xs leading-4 text-gray-600 line-clamp-2" x-text="notification.message"></p>
                                                    <p class="mt-1 text-xs text-gray-400" x-text="formatDate(notification.created_at)"></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex items-center ml-2">
                                            <span x-show="notification.status === 'unread'"
                                                class="flex-shrink-0 w-2 h-2 bg-blue-500 rounded-full"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>

                    <!-- Footer -->
                    <div class="px-4 py-2 border-t bg-gray-50">
                        <a href="?page=notifications-admin"
                            class="block text-xs font-medium text-center text-blue-600 transition-colors duration-200 hover:text-blue-800">
                            View all notifications →
                        </a>
                    </div>
                </div>
            </div>

            <button type="submit" id="submit-btn"
                class="px-4 py-2 text-sm font-medium text-white rounded-md bg-primary hover:bg-primary/90 focus:outline-none focus:ring-1 focus:ring-offset-2 focus:ring-primary">
                Logs
            </button>
        </div>
    </div>
</header>

<script>
    function adminNotificationDropdown() {
        return {
            isOpen: false,
            notifications: [],
            unreadCount: 0,
            loading: false,
            error: null,

            async init() {
                await this.fetchNotifications();
                // Poll for new notifications every 30 seconds
                setInterval(() => {
                    this.fetchNotifications();
                }, 30000);
            },

            async toggleNotifications() {
                this.isOpen = !this.isOpen;
                if (this.isOpen) {
                    await this.fetchNotifications();
                }
            },

            async fetchNotifications() {
                try {
                    this.loading = true;
                    this.error = null;

                    console.log('🔔 Admin: Fetching notifications...');

                    const response = await fetch('?page=notifications-api&limit=5');

                    if (!response.ok) {
                        throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                    }

                    const data = await response.json();
                    console.log('✅ Admin notifications data:', data);

                    if (data.notifications) {
                        this.notifications = data.notifications;
                        this.unreadCount = data.unread_count || 0;
                        console.log(`📬 Admin loaded ${this.notifications.length} notifications, ${this.unreadCount} unread`);
                    } else if (data.error) {
                        console.error('❌ API Error:', data.error);
                        this.error = data.error;
                    }
                } catch (error) {
                    console.error('❌ Error fetching notifications:', error);
                    this.error = 'Failed to load notifications';
                } finally {
                    this.loading = false;
                }
            },

            async markAsRead(notificationId) {
                try {
                    console.log('📖 Marking notification as read:', notificationId);

                    const response = await fetch('?page=notifications-api', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            action: 'mark_as_read',
                            notification_id: notificationId
                        })
                    });

                    const data = await response.json();
                    console.log('Mark as read response:', data);

                    if (data.success) {
                        console.log('✅ Successfully marked as read');
                        await this.fetchNotifications();
                    } else {
                        console.error('❌ Failed to mark as read:', data);
                    }
                } catch (error) {
                    console.error('❌ Error marking notification as read:', error);
                }
            },

            async markAllAsRead() {
                try {
                    console.log('📖 Marking all notifications as read');

                    const response = await fetch('?page=notifications-api', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            action: 'mark_all_as_read'
                        })
                    });

                    const data = await response.json();
                    console.log('Mark all as read response:', data);

                    if (data.success) {
                        console.log('✅ Successfully marked all as read');
                        await this.fetchNotifications();
                    } else {
                        console.error('❌ Failed to mark all as read:', data);
                    }
                } catch (error) {
                    console.error('❌ Error marking all notifications as read:', error);
                }
            },

            async handleNotificationClick(notification) {
                console.log('🔗 Clicked notification:', notification);

                // Mark as read if unread
                if (notification.status === 'unread') {
                    await this.markAsRead(notification.notification_id);
                }

                // Navigate to link if exists
                if (notification.link) {
                    window.location.href = notification.link;
                }

                this.isOpen = false;
            },

            formatDate(dateString) {
                const date = new Date(dateString);
                const now = new Date();
                const diff = now - date;
                const minutes = Math.floor(diff / 60000);
                const hours = Math.floor(minutes / 60);
                const days = Math.floor(hours / 24);

                if (minutes < 1) return 'Just now';
                if (minutes < 60) return `${minutes}m ago`;
                if (hours < 24) return `${hours}h ago`;
                if (days < 7) return `${days}d ago`;
                return date.toLocaleDateString();
            }
        }
    }
</script>