<nav x-data="{ open: false }" class="block w-full px-4 py-4 mx-4 bg-white border-b-4 border-blue-600 shadow-md font-inter sm:px-6 md:px-16 lg:px-24">
  <div class="flex flex-wrap items-center justify-between mx-auto max-w-7xl">
    <div class="flex items-center gap-3">
      <img src="assets/images/peso-logo.png" alt="Logo 2" class="w-auto h-12">
      <img src="assets/images/sikap-logo.png" alt="Logo 1" class="w-auto shadow-sm h-11">
      <a href="?page=landing" class="font-medium nav-brand">Sikap <span class="text-secondary">Employer</span></a>
    </div>

    <!-- Desktop Menu -->
    <div class="hidden lg:block">
      <ul class="flex flex-col gap-2 mt-2 mb-4 lg:mb-0 lg:mt-0 lg:flex-row lg:items-center lg:gap-10">
        <li><a href="?page=employer-dashboard" class="nav-link">Home</a></li>
        <li><a href="?page=view-all-applicants" class="nav-link">Browse Candidates</a></li>
        <li><a href="?page=manage-jobs" class="nav-link">Job Management</a></li>
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
        <!-- Notification Dropdown (NEW) -->
        <li x-data="notificationDropdown()" class="relative">
          <button
            @click="toggleNotifications()"
            class="relative p-2 transition-all duration-200 rounded-full hover:text-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
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
            <!-- Notification Badge -->
            <span x-show="unreadCount > 0"
              x-text="unreadCount"
              class="absolute -top-1 -right-1 flex items-center justify-center min-w-[18px] h-[18px] text-xs font-bold text-white bg-red-500 rounded-full border-2 border-white shadow-lg"
              :class="unreadCount > 99 ? 'text-[10px] px-1' : ''"
              style="z-index: 10;">
            </span>
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
                <div class="relative">
                  <button @click="handleNotificationClick(notification)"
                    class="flex items-start w-full px-4 py-3 text-left transition-colors hover:bg-gray-50 focus:outline-none focus:bg-gray-50"
                    :class="notification.status === 'unread' ? 'bg-blue-50' : ''">

                    <!-- Notification Icon -->
                    <div class="flex-shrink-0 mr-3">
                      <div class="flex items-center justify-center w-8 h-8 rounded-full"
                        :class="getNotificationBadgeColor(notification.type)">
                        <span x-html="getNotificationIcon(notification.type)"></span>
                      </div>
                    </div>

                    <!-- Notification Content -->
                    <div class="flex-1 min-w-0">
                      <div class="flex items-start justify-between">
                        <div class="flex-1">
                          <h4 class="text-sm font-medium text-gray-900 line-clamp-1"
                            :class="notification.status === 'unread' ? 'font-semibold' : ''"
                            x-text="notification.title">
                          </h4>
                          <p class="text-sm text-gray-600 line-clamp-2"
                            x-text="notification.message">
                          </p>
                          <p class="text-xs text-gray-400"
                            x-text="formatDate(notification.created_at)">
                          </p>
                        </div>

                        <!-- Unread indicator -->
                        <div x-show="notification.status === 'unread'"
                          class="flex-shrink-0 ml-2">
                          <span class="inline-block w-2 h-2 bg-blue-500 rounded-full"></span>
                        </div>
                      </div>
                    </div>
                  </button>
                </div>
              </template>
            </div>

            <!-- Footer -->
            <div class="px-6 py-3 border-t bg-gray-50">
              <a href="?page=notifications-employer"
                class="block text-sm font-medium text-center text-blue-600 transition-colors duration-200 hover:text-blue-800">
                View all notifications →
              </a>
            </div>
          </div>
        </li>

        <!-- Business Dropdown -->
        <li x-data="{ businessOpen: false }" class="relative">
          <button
            @click="businessOpen = !businessOpen"
            @click.away="businessOpen = false"
            class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 transition-colors duration-200 bg-gray-100 rounded-sm hover:bg-gray-200 hover:text-blue-600 focus:outline-none">

            Business
            <svg class="w-4 h-4 ml-2 transition-transform duration-200"
              :class="{ 'rotate-180': businessOpen }"
              fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
          </button>

          <!-- Business Dropdown Menu -->
          <div
            x-show="businessOpen"
            x-transition:enter="transition ease-out duration-100"
            x-transition:enter-start="transform opacity-0 scale-95"
            x-transition:enter-end="transform opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="transform opacity-100 scale-100"
            x-transition:leave-end="transform opacity-0 scale-95"
            class="absolute right-0 z-50 w-56 mt-2 bg-white border border-gray-200 rounded-md shadow-lg"
            style="display: none;">

            <div class="py-1">
              <a href="?page=profile-employer"
                class="flex items-center px-4 py-2 text-sm text-gray-700 transition-colors duration-200 hover:bg-gray-100 hover:text-gray-900">
                Employer Profile
              </a>

              <a href="?page=manage-jobs"
                class="flex items-center px-4 py-2 text-sm text-gray-700 transition-colors duration-200 hover:bg-gray-100 hover:text-gray-900">
                Manage Jobs
              </a>

              <a href="?page=view-all-applicants"
                class="flex items-center px-4 py-2 text-sm text-gray-700 transition-colors duration-200 hover:bg-gray-100 hover:text-gray-900">
                View Applications
              </a>

              <a href="?page=setting-employer"
                class="flex items-center px-4 py-2 text-sm text-gray-700 transition-colors duration-200 hover:bg-gray-100 hover:text-gray-900">
                Settings
              </a>

              <hr class="my-1">

              <a href="?page=logout"
                class="flex items-center px-4 py-2 text-sm text-red-700 transition-colors duration-200 hover:bg-red-50 hover:text-red-900">
                Sign Out
              </a>
            </div>
          </div>
        </li>

        <!-- Post A Job Button -->
        <li>
          <a href="?page=post-job"
            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white transition-colors duration-200 border border-transparent rounded-sm bg-primary hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            Post A Job
          </a>
        </li>
      </ul>
    </div>
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
      <li><a href="?page=employer-dashboard" class="nav-link">Home</a></li>
      <li><a href="?page=browse-candidates" class="nav-link">Browse Candidates</a></li>
      <li><a href="?page=job-management" class="nav-link">Job Management</a></li>
      <li><a href="?page=employer-programs" class="nav-link">Programs</a></li>
      <li><a href="?page=employer-community" class="nav-link">Community</a></li>
      <li><a href="?page=notifications-employer" class="nav-link">Notifications</a></li>
      <li><a href="?page=job-applications" class="nav-link">Applications</a></li>
      <li><a href="?page=employer-messages" class="nav-link">Messages</a></li>

      <!-- Business Section -->
      <li class="mt-4">
        <p class="mb-2 text-xs font-semibold tracking-wide text-gray-500 uppercase">Business</p>
        <div class="pl-4 space-y-2">
          <a href="?page=profile-employer" class="text-sm nav-link">Employer Profile</a>
          <a href="?page=setting-employer" class="text-sm nav-link">Settings</a>
          <a href="?page=contact-us" class="text-sm nav-link">Contact Us</a>
        </div>
      </li>

      <li class="flex flex-col gap-2 mt-6">
        <a href="?page=post-job" class="w-full text-center btn-primary">Post A Job</a>
        <a href="?page=logout" class="w-full py-2 text-center text-red-600 border border-red-300 rounded-md hover:bg-red-50">Sign Out</a>
      </li>
    </ul>
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

          console.log('🔔 Employer: Fetching notifications...');

          const response = await fetch('?page=notifications-api&limit=5');

          if (!response.ok) {
            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
          }

          const data = await response.json();
          console.log('✅ Employer notifications data:', data);

          if (data.success && data.notifications) {
            this.notifications = data.notifications;
            this.unreadCount = data.unread_count || 0;
            console.log(`📬 Employer loaded ${this.notifications.length} notifications, ${this.unreadCount} unread`);
          } else if (data.error) {
            console.error('❌ Employer API Error:', data.error);
            this.error = data.error;
          }
        } catch (error) {
          console.error('❌ Employer error fetching notifications:', error);
          this.error = 'Failed to load notifications';
        } finally {
          this.loading = false;
        }
      },

      async markAsRead(notificationId) {
        try {
          console.log('📖 Employer marking notification as read:', notificationId);

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
          console.log('Employer mark as read response:', data);

          if (data.success) {
            console.log('✅ Employer successfully marked as read');
            await this.fetchNotifications();
          } else {
            console.error('❌ Employer failed to mark as read:', data);
          }
        } catch (error) {
          console.error('❌ Employer error marking notification as read:', error);
        }
      },

      async markAllAsRead() {
        try {
          console.log('📖 Employer marking all notifications as read');

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
          console.log('Employer mark all as read response:', data);

          if (data.success) {
            console.log('✅ Employer successfully marked all as read');
            await this.fetchNotifications();
          } else {
            console.error('❌ Employer failed to mark all as read:', data);
          }
        } catch (error) {
          console.error('❌ Employer error marking all notifications as read:', error);
        }
      },

      async handleNotificationClick(notification) {
        console.log('🔗 Employer clicked notification:', notification);

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

      // ENHANCED: Better notification display for job applications
      getNotificationIcon(type) {
        switch (type) {
          case 'job_application':
            return `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>`;
          case 'program':
            return `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>`;
          default:
            return `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>`;
        }
      },

      getNotificationBadgeColor(type) {
        switch (type) {
          case 'job_application':
            return 'bg-purple-100 text-purple-600';
          case 'program':
            return 'bg-green-100 text-green-600';
          default:
            return 'bg-blue-100 text-blue-600';
        }
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