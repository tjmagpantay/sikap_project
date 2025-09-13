<?php
// filepath: c:\xampp\htdocs\sikap\app\views\jobseekers\navbar-jobseeker.php

// Ensure we have jobseeker data - this should be passed from controller
if (!isset($jobseeker) || empty($jobseeker)) {
  // Fallback for pages that don't pass jobseeker data
  $jobseeker = [
    'profile_picture' => '',
    'first_name' => 'Guest',
    'last_name' => ''
  ];
}
?>

<nav x-data="{ open: false }" class="block w-full px-4 py-4 bg-white shadow-md font-inter sm:px-6 md:px-16 lg:px-24 ">
  <div class="flex flex-wrap items-center justify-between mx-auto max-w-7xl">
    <div class="flex items-center gap-3">
      <img src="assets/images/peso-logo.png" alt="Logo 2" class="w-auto h-12">
      <img src="assets/images/sikap-logo.png" alt="Logo 1" class="w-auto shadow-sm h-11">
      <a href="?page=jobseeker-dashboard" class="font-medium nav-brand">Sikap <span class="text-secondary">Jobseeker</span></a>
    </div>

    <!-- Desktop Menu -->
    <div class="hidden lg:block">
      <ul class="flex flex-col gap-2 mt-2 mb-4 lg:mb-0 lg:mt-0 lg:flex-row lg:items-center lg:gap-10">
        <li><a href="?page=jobseeker-dashboard" class="nav-link">Home</a></li>
        <li><a href="?page=browse-jobs" class="nav-link">Job Search</a></li>
        <li><a href="?page=programs-jobseeker" class="nav-link">Programs</a></li>
        <li><a href="?page=explore-companies" class="nav-link">Explore Companies</a></li>
      </ul>
    </div>

    <!-- Burger Button -->
    <button
      @click="open = !open"
      class="relative ml-auto h-6 max-h-[40px] w-6 max-w-[40px] select-none rounded-lg text-center align-middle text-xs font-medium uppercase text-inherit transition-all hover:bg-transparent focus:bg-transparent active:bg-transparent disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none lg:hidden"
      type="button">
      <span class="absolute transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </span>
    </button>

    <!-- Action Buttons (Desktop) -->
    <div class="items-center hidden lg:flex">
      <ul class="flex items-center gap-4">
        <!-- Notification Dropdown -->
        <li x-data="notificationDropdown()" class="relative">
          <button
            @click="toggleNotifications()"
            class="relative transition-all duration-200 rounded-full hover:text-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
            <!-- Notification Badge - Improved positioning and size -->
            <span x-show="unreadCount > 0"
              x-text="unreadCount"
              class="absolute -top-1 -left-1 flex items-center justify-center min-w-[16px] h-[16px] text-xs font-semibold text-red-500 "
              :class="unreadCount > 99 ? 'text-[10px] px-1' : ''">
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
            class="absolute right-0 z-50 mt-2 overflow-hidden bg-white border border-gray-200 rounded-lg shadow-xl w-[500px] max-h-[500px]"
            style="display: none; width: 500px !important;">

            <!-- Header -->
            <div class="flex items-center justify-between px-6 py-4 border-b bg-gradient-to-r from-blue-50 to-indigo-50">
              <h3 class="text-lg font-semibold text-gray-900">Notifications</h3>
              <button @click="markAllAsRead()"
                x-show="unreadCount > 0"
                class="px-3 py-1 text-sm font-medium text-blue-600 transition-colors duration-200 rounded-md hover:text-blue-800 hover:bg-blue-100">
                Mark all read
              </button>
            </div>

            <!-- Loading State -->
            <template x-if="loading">
              <div class="flex items-center justify-center px-6 py-8 text-gray-500">
                <div class="flex items-center">
                  <svg class="w-5 h-5 mr-3 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                  </svg>
                  Loading notifications...
                </div>
              </div>
            </template>

            <!-- Error State -->
            <template x-if="error && !loading">
              <div class="px-6 py-8 text-center text-red-500">
                <p x-text="error" class="mb-3"></p>
                <button @click="fetchNotifications()"
                  class="px-4 py-2 text-sm font-medium text-blue-600 transition-colors duration-200 rounded-md hover:text-blue-800 hover:bg-blue-50">
                  Try again
                </button>
              </div>
            </template>

            <!-- Notifications List -->
            <div class="overflow-y-auto max-h-80">
              <!-- Empty State -->
              <template x-if="notifications.length === 0 && !loading && !error">
                <div class="px-6 py-12 text-center">
                  <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 17h5l-5 5v-5zM4 19h6v-2H4v2zM20 4H4c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h4v-2H4V6h16v10h-2v2h2c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2z" />
                  </svg>
                  <p class="font-medium text-gray-500">No notifications yet</p>
                  <p class="mt-1 text-sm text-gray-400">We'll notify you when there's something new!</p>
                </div>
              </template>

              <!-- Notification Items -->
              <template x-for="notification in notifications" :key="notification.notification_id">
                <div class="transition-all duration-200 border-b border-gray-100 cursor-pointer hover:bg-gray-50"
                  :class="notification.status === 'unread' ? 'bg-blue-50 border-l-4 border-l-blue-500' : ''"
                  @click="handleNotificationClick(notification)">
                  <div class="px-6 py-4">
                    <div class="flex items-start justify-between">
                      <div class="flex-1 min-w-0">
                        <!-- Notification Icon -->
                        <div class="flex items-start">
                          <div class="flex-shrink-0">
                            <!-- FIXED: Different background colors for different notification types -->
                            <div class="flex items-center justify-center w-8 h-8 rounded-full"
                              :class="notification.type === 'program' ? 'bg-green-100' : 'bg-blue-100'">

                              <!-- Job Post Icon -->
                              <template x-if="notification.type === 'job_post'">
                                <svg class="w-5 h-5 text-blue-600" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
                                  <path d="M28,8H21V6a2,2,0,0,0-2-2H13a2,2,0,0,0-2,2V8H4a2,2,0,0,0-2,2V26a2,2,0,0,0,2,2H28a2,2,0,0,0,2-2V10A2,2,0,0,0,28,8ZM13,6h6V8H13Zm15,4v9H4V10ZM4,26V21H28v5Z"></path>
                                  <path d="M15,18h2a1,1,0,0,0,0-2H15a1,1,0,0,0,0,2Z"></path>
                                </svg>
                              </template>

                              <!-- Program/Event Icon -->
                              <template x-if="notification.type === 'program'">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                              </template>

                              <!-- Application Update Icon -->
                              <template x-if="notification.type === 'application_update'">
                                <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                              </template>

                              <!-- FIXED: Add Interview Notification Icon -->
                              <template x-if="notification.type === 'interview'">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                              </template>

                              <!-- Default Icon -->
                              <template x-if="notification.type !== 'job_post' && notification.type !== 'program' && notification.type !== 'application_update' && notification.type !== 'interview'">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                              </template>
                            </div>
                          </div>
                          <div class="flex-1 ml-3">
                            <h4 class="text-sm font-medium leading-5 text-gray-900"
                              :class="notification.status === 'unread' ? 'font-semibold' : ''"
                              x-text="notification.title">
                            </h4>
                            <p class="mt-1 text-sm leading-5 text-gray-600 line-clamp-2" x-text="notification.message"></p>
                            <p class="mt-2 text-xs text-gray-400" x-text="formatDate(notification.created_at)"></p>
                          </div>
                        </div>
                      </div>
                      <div class="flex items-center ml-4">
                        <span x-show="notification.status === 'unread'"
                          class="w-2.5 h-2.5 bg-blue-500 rounded-full flex-shrink-0"></span>
                      </div>
                    </div>
                  </div>
                </div>
              </template>
            </div>

            <!-- Footer -->
            <div class="px-6 py-3 border-t bg-gray-50">
              <a href="?page=notifications-jobseeker"
                class="block text-sm font-medium text-center text-blue-600 transition-colors duration-200 hover:text-blue-800">
                View all notifications →
              </a>
            </div>
          </div>
        </li>

        <!-- Saved Jobs -->
        <li>
          <a href="?page=saved-jobs" class="hover:text-blue-600">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
              viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
              class="w-5 h-5 text-gray-500 transition-colors duration-200">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M17.593 3.322c1.1.128 1.907 1.077 
                        1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 
                        1.907-2.185a48.507 48.507 0 0 1 11.186 0Z" />
            </svg>
          </a>
        </li>

        <!-- Profile Dropdown -->
        <li x-data="{ profileOpen: false }" class="relative">
          <button
            @click="profileOpen = !profileOpen"
            @click.away="profileOpen = false"
            class="flex items-center hover:text-blue-600 focus:outline-none">
            <img src="<?php
                      if (!empty($jobseeker['profile_picture'])) {
                        echo htmlspecialchars('/sikap/public/' . $jobseeker['profile_picture']);
                      } else {
                        echo '/sikap/public/assets/images/default-avatar.jpg';
                      }
                      ?>" alt="Profile"
              class="object-cover w-8 h-8 transition duration-200 border-2 border-gray-300 rounded-full hover:border-blue-600">
          </button>

          <!-- Dropdown Menu -->
          <div
            x-show="profileOpen"
            x-transition:enter="transition ease-out duration-100"
            x-transition:enter-start="transform opacity-0 scale-95"
            x-transition:enter-end="transform opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="transform opacity-100 scale-100"
            x-transition:leave-end="transform opacity-0 scale-95"
            class="absolute right-0 z-50 w-64 mt-2 bg-white border border-gray-200 rounded-md shadow-sm"
            style="display: none;">

            <div class="py-1">
              <a href="?page=profile-jobseeker"
                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                Profile
              </a>

              <a href="?page=saved-jobs"
                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                Saved Jobs
              </a>

              <a href="?page=my-applications"
                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                Applied Jobs
              </a>

              <a href="?page=settings-jobseeker"
                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                Settings
              </a>

              <hr class="my-1">

              <a href="?page=logout"
                class="block px-4 py-2 text-sm text-red-700 hover:bg-red-50 hover:text-red-900">
                Sign Out
              </a>
            </div>
          </div>
        </li>
      </ul
        </div>
      <!-- Mobile Slide-in Menu -->
      <div
        x-show="open"
        @click.away="open = false"
        x-transition:enter="transition transform duration-300"
        x-transition:enter-start="translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition transform duration-300"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="translate-x-full"
        class="fixed right-0 z-50 w-64 h-full p-6 mt-20 bg-white shadow-lg top-2 lg:hidden"
        style="display: none;">
        <ul class="flex flex-col gap-4 mt-8">
          <li><a href="?page=browse-jobs" class="nav-link">Job Search</a></li>
          <li><a href="?page=jobseeker-programs" class="nav-link">Programs</a></li>
          <li><a href="?page=explore-companies" class="nav-link">Explore Companies</a></li>
          <li><a href="#" class="nav-link">Community</a></li>
          <li><a href="?page=notifications" class="nav-link">Notifications</a></li>
          <li><a href="?page=saved-jobs" class="nav-link">Saved Jobs</a></li>
          <li><a href="?page=my-applications" class="nav-link">Applied Jobs</a></li>
          <li><a href="?page=settings-jobseeker" class="nav-link">Settings</a></li>
          <li class="flex flex-col gap-2 mt-4">
            <a href="?page=login-employer" class="w-full text-center btn-primary">Post A Job</a>
          </li>
        </ul>
      </div>
    </div>
</nav>

<script>
  function notificationDropdown() {
    return {
      isOpen: false,
      notifications: [],
      unreadCount: 0,
      loading: false,
      error: null,

      async init() {
        await this.fetchNotifications();
        // Poll for new notifications every 15 seconds
        setInterval(() => {
          this.fetchNotifications();
        }, 15000);
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

          console.log('🔔 Jobseeker: Fetching notifications...');

          // FIXED: Use MVC controller endpoint instead of API folder
          const response = await fetch('?page=notifications-api&limit=5');

          if (!response.ok) {
            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
          }

          const data = await response.json();
          console.log('✅ Jobseeker notifications data:', data);

          if (data.notifications) {
            this.notifications = data.notifications;
            this.unreadCount = data.unread_count || 0;
            console.log(`📬 Jobseeker loaded ${this.notifications.length} notifications, ${this.unreadCount} unread`);
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

          // FIXED: Use MVC controller endpoint
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

          // FIXED: Use MVC controller endpoint
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