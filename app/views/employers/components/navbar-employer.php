<nav x-data="{ open: false }" class="block w-full px-4 py-4 mx-4 bg-white border-b-4 border-blue-600 shadow-md font-inter sm:px-6 md:px-16 lg:px-24">
  <div class="flex flex-wrap items-center justify-between mx-auto max-w-7xl">
    <div class="flex items-center gap-3">
      <img src="assets/images/peso-logo.png" alt="Logo 2" class="w-auto h-12">
      <img src="assets/images/sikap-logo.png" alt="Logo 1" class="w-auto shadow-sm h-11">
      <a href="?page=employer-dashboard" class="font-medium nav-brand">Sikap <span class="text-secondary">Employer</span></a>
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
        <li x-data="notificationDropdown()" class="relative flex items-center">
          <button
            @click="toggleNotifications()"
            class="relative transition-all duration-200 rounded-full hover:text-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
            <!-- Notification Badge - Improved positioning and size -->
            <span x-show="unreadCount > 0"
              x-text="unreadCount"
              class="absolute -top-0.5 -left-1 flex items-center justify-center p-2 min-w-[14px] h-[14px] text-xs text-primary bg-secondary rounded-full"
              :class="unreadCount > 99 ? 'text-[9px] px-2' : ''">
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
            style="display: none; top: calc(100% + 8px); width: 400px !important;">

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
                        <!-- Notification Icon -->
                        <div class="flex items-start">
                          <div class="flex-shrink-0">
                            <div class="flex items-center justify-center rounded-full w-7 h-7"
                              :class="getNotificationBadgeColor(notification.type)">

                              <!-- Job Application Icon -->
                              <template x-if="notification.type === 'job_application'">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 7V6a3 3 0 013-3h0a3 3 0 013 3v1m-6 0h6m-9 4h12m-12 0v7a2 2 0 002 2h8a2 2 0 002-2v-7m-12 0V7h12v4" />
                                </svg>
                              </template>

                              <!-- Application Update Icon -->
                              <template x-if="notification.type === 'application_update'">
                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                              </template>

                              <!-- Interview Notification Icon -->
                              <template x-if="notification.type === 'interview'">
                                <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                              </template>

                              <!-- Program/Event Icon -->
                              <template x-if="notification.type === 'program' || notification.type === 'event'">
                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                              </template>

                              <!-- Job Post Icon -->
                              <template x-if="notification.type === 'job_post'">
                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V9a2 2 0 11-4 0V6m0 0H8m0 0v2M7 7l10 10-5-5z" />
                                </svg>
                              </template>

                              <!-- System Icon -->
                              <template x-if="notification.type === 'system'">
                                <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                              </template>

                              <!-- Default Icon -->
                              <template x-if="notification.type !== 'job_application' && notification.type !== 'application_update' && notification.type !== 'interview' && notification.type !== 'program' && notification.type !== 'event' && notification.type !== 'job_post' && notification.type !== 'system'">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4 19h6v-2H4v2zM20 4H4c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h4v-2H4V6h16v10h-2v2h2c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2z" />
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
              <a href="?page=notifications-employer"
                class="block text-xs font-medium text-center text-blue-600 transition-colors duration-200 hover:text-blue-800">
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

    <div class="flex flex-col h-full">
      <!-- Employer Profile Header -->
      <div class="px-2 py-4 border-b border-gray-200">
        <div class="flex items-center mb-3">
          <div class="flex-1 min-w-0">
            <h3 class="text-base font-semibold text-gray-900 truncate text-md">
              <?php
              if (!empty($_SESSION['business_name'])) {
                echo htmlspecialchars($_SESSION['business_name']);
              } elseif (!empty($_SESSION['first_name']) || !empty($_SESSION['last_name'])) {
                echo htmlspecialchars(trim(($_SESSION['first_name'] ?? '') . ' ' . ($_SESSION['last_name'] ?? '')));
              } else {
                echo 'Employer Account';
              }
              ?>
            </h3>
            <?php if (!empty($_SESSION['email'])): ?>
              <p class="text-xs text-gray-500 truncate"><?php echo htmlspecialchars($_SESSION['email']); ?></p>
            <?php endif; ?>

            <?php if (!empty($_SESSION['business_type']) || !empty($_SESSION['company_size'])): ?>
              <p class="mt-1 text-xs text-gray-400 truncate">
                <?php
                $details = array_filter([
                  $_SESSION['business_type'] ?? null,
                  $_SESSION['company_size'] ?? null
                ]);
                echo htmlspecialchars(implode(' • ', $details));
                ?>
              </p>
            <?php endif; ?>
          </div>
        </div>

        <?php if (!empty($_SESSION['location'])): ?>
          <div class="flex items-center mt-2 text-xs text-gray-500">
            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <span class="truncate"><?php echo htmlspecialchars($_SESSION['location']); ?></span>
          </div>
        <?php endif; ?>
      </div>

      <hr>

      <!-- Main Navigation -->
      <ul class="flex flex-col space-y-1">
        <!-- Employer Profile -->
        <li>
          <a href="?page=profile-employer"
            @click="open = false"
            class="flex items-center w-full px-2 py-4 font-medium text-gray-700 transition-colors duration-200 rounded-md text-md hover:bg-gray-100 hover:text-primary">
            <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            Employer Profile
          </a>
        </li>

        <!-- Home -->
        <li>
          <a href="?page=employer-dashboard"
            @click="open = false"
            class="flex items-center w-full px-2 py-4 font-medium text-gray-700 transition-colors duration-200 rounded-md text-md hover:bg-gray-100 hover:text-primary">
            <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            Home
          </a>
        </li>

        <!-- Browse Candidates -->
        <li>
          <a href="?page=view-all-applicants"
            @click="open = false"
            class="flex items-center w-full px-2 py-4 font-medium text-gray-700 transition-colors duration-200 rounded-md text-md hover:bg-gray-100 hover:text-primary">
            <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            Browse Candidates
          </a>
        </li>

        <!-- Job Management -->
        <li>
          <a href="?page=manage-jobs"
            @click="open = false"
            class="flex items-center w-full px-2 py-4 font-medium text-gray-700 transition-colors duration-200 rounded-md text-md hover:bg-gray-100 hover:text-primary">
            <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 7V6a3 3 0 013-3h0a3 3 0 013 3v1m-6 0h6m-9 4h12m-12 0v7a2 2 0 002 2h8a2 2 0 002-2v-7m-12 0V7h12v4" />
            </svg>

            Job Management
          </a>
        </li>
      </ul>

      <!-- Bottom Section -->
      <div class="pt-6 mt-auto">
        <!-- Post A Job Button -->
        <div class="mb-4">
          <a href="?page=post-job"
            @click="open = false"
            class="flex items-center justify-center w-full px-4 py-3 text-sm font-medium text-white transition-colors duration-200 border border-transparent rounded-md shadow-sm bg-primary hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Post A Job
          </a>
        </div>

        <!-- Sign Out -->
        <div class="py-4 border-t border-gray-200">
          <a href="?page=logout"
            @click="open = false"
            class="flex items-center justify-center w-full px-4 py-3 text-sm font-medium text-red-700 transition-colors duration-200 border border-red-500 rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
            <svg class="w-5 h-5 mr-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
            </svg>
            Sign Out
          </a>
        </div>
      </div>
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

      // UPDATED: Enhanced notification icons with new color scheme
      getNotificationIcon(type) {
        switch (type) {
          case 'job_application':
            return `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
              d="M9 7V6a3 3 0 013-3h0a3 3 0 013 3v1m-6 0h6m-9 4h12m-12 0v7a2 2 0 002 2h8a2 2 0 002-2v-7m-12 0V7h12v4" />
          </svg>`;
          case 'application_update':
            return `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>`;
          case 'interview':
            return `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>`;
          case 'program':
          case 'event':
            return `<svg class="w-4 h-4" fill="none" stroke="green" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>`;
          case 'job_post':
            return `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V9a2 2 0 11-4 0V6m0 0H8m0 0v2M7 7l10 10-5-5z" />
            </svg>`;
          case 'system':
            return `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>`;
          default:
            return `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4 19h6v-2H4v2zM20 4H4c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h4v-2H4V6h16v10h-2v2h2c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2z" />
            </svg>`;
        }
      },

      // UPDATED: New color scheme using primary (blue), green, and secondary (yellow/orange) colors
      getNotificationBadgeColor(type) {
        switch (type) {
          case 'job_application':
            // Primary color - blue background
            return 'bg-blue-100 text-primary';

          case 'application_update':
            // Green for positive updates
            return 'bg-green-100 text-green-600';

          case 'interview':
            // Secondary color - yellow/amber background
            return 'bg-yellow-100 text-yellow-700';

          case 'program':
          case 'event':
            // Primary color for programs/events
            return 'bg-green-100 text-green-900';

          case 'job_post':
            // Green for job opportunities
            return 'bg-green-100 text-green-600';

          case 'system':
            // Secondary color for system notifications
            return 'bg-yellow-100 text-yellow-700';

          default:
            // Default to primary color
            return 'bg-blue-100 text-primary';
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