<?php
// Remove direct model access - data should come from controller
// All jobseeker data is now passed from the controller
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
        <li><a href="?page=recommended-jobs" class="nav-link">Recommended Jobs</a></li>
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
            class="relative hover:text-blue-600">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
              viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
              class="w-5 h-5 text-gray-500 transition-colors duration-200">
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
              class="absolute flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-500 rounded-full -top-1 -right-1">
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
            class="absolute right-0 z-50 mt-2 overflow-hidden bg-white border border-gray-200 rounded-md shadow-lg w-80 max-h-96"
            style="display: none;">

            <!-- Header -->
            <div class="flex items-center justify-between px-4 py-3 border-b">
              <h3 class="font-semibold text-gray-900">Notifications</h3>
              <button @click="markAllAsRead()"
                x-show="unreadCount > 0"
                class="text-sm text-blue-600 hover:text-blue-800">
                Mark all read
              </button>
            </div>

            <!-- Notifications List -->
            <div class="overflow-y-auto max-h-64">
              <template x-if="notifications.length === 0">
                <div class="px-4 py-8 text-center text-gray-500">
                  No notifications yet
                </div>
              </template>

              <template x-for="notification in notifications" :key="notification.notification_id">
                <div class="border-b border-gray-100 cursor-pointer hover:bg-gray-50"
                  :class="notification.status === 'unread' ? 'bg-blue-50' : ''"
                  @click="handleNotificationClick(notification)">
                  <div class="px-4 py-3">
                    <div class="flex items-start justify-between">
                      <div class="flex-1">
                        <h4 class="text-sm font-medium text-gray-900"
                          :class="notification.status === 'unread' ? 'font-bold' : ''"
                          x-text="notification.title">
                        </h4>
                        <p class="mt-1 text-sm text-gray-600" x-text="notification.message"></p>
                        <p class="mt-1 text-xs text-gray-400" x-text="formatDate(notification.created_at)"></p>
                      </div>
                      <div class="flex items-center ml-2">
                        <span x-show="notification.status === 'unread'"
                          class="w-2 h-2 bg-blue-500 rounded-full"></span>
                      </div>
                    </div>
                  </div>
                </div>
              </template>
            </div>

            <!-- Footer -->
            <div class="px-4 py-3 border-t bg-gray-50">
              <a href="?page=notifications"
                class="text-sm font-medium text-blue-600 hover:text-blue-800">
                View all notifications
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
      </ul>
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
          const response = await fetch('/sikap/app/api/notifications.php');
          const data = await response.json();

          if (data.notifications) {
            this.notifications = data.notifications;
            this.unreadCount = data.unread_count;
          }
        } catch (error) {
          console.error('Error fetching notifications:', error);
        }
      },

      async markAsRead(notificationId) {
        try {
          const response = await fetch('/sikap/app/api/notifications.php', {
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
          if (data.success) {
            await this.fetchNotifications();
          }
        } catch (error) {
          console.error('Error marking notification as read:', error);
        }
      },

      async markAllAsRead() {
        try {
          const response = await fetch('/sikap/app/api/notifications.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
            },
            body: JSON.stringify({
              action: 'mark_all_as_read'
            })
          });

          const data = await response.json();
          if (data.success) {
            await this.fetchNotifications();
          }
        } catch (error) {
          console.error('Error marking all notifications as read:', error);
        }
      },

      async handleNotificationClick(notification) {
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