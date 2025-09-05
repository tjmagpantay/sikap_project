<header class="sticky top-0 z-30 flex-shrink-0 bg-white border-b border-gray-200 shadow-sm">
    <div class="flex items-center justify-between px-6 py-4">
        <!-- Left Section: Mobile menu button and page title -->
        <div class="flex items-center gap-3">
            <!-- Mobile menu button -->
            <button onclick="toggleMobileSidebar()" class="p-2 text-gray-500 rounded-md hover:text-gray-900 hover:bg-gray-100 lg:hidden" data-mobile-menu>
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
            <span class="text-lg font-semibold text-gray-900">

                <!-- Logo Section -->
                <div class="flex items-center justify-between flex-shrink-0 gap-6 px-6 ">
                    <!-- Left: Logos -->
                    <div class="flex items-center">
                        <div class="flex items-center gap-2">
                            <img src="assets/images/peso-logo.png" alt="Logo 2" class="w-auto h-8">
                            <img src="assets/images/sikap-logo.png" alt="Logo 1" class="w-auto h-8 shadow-sm">
                            <a href="?page=admin-dashboard" class="text-xl font-bold text-primary">
                                Sikap <span class="text-secondary">Admin</span>
                            </a>
                        </div>
                    </div>

                    
                </div>
            </span>
        </div>

        <!-- Right Section: Notifications and Profile -->
        <div class="flex items-center space-x-4">
            <!-- Notifications -->
            <button class="relative p-2 text-gray-400 transition-colors hover:text-gray-600">
                <i class="w-5 h-5 fas fa-bell"></i>
                <span class="absolute top-0 right-0 inline-block w-2 h-2 bg-red-500 rounded-full"></span>
            </button>
            <!-- Profile dropdown (static for now) -->
            <div class="flex items-center gap-2">
                <div class="flex items-center justify-center w-8 h-8 bg-gray-300 rounded-full">
                    <i class="text-sm text-gray-600 fas fa-user"></i>
                </div>
                <span class="hidden text-sm font-medium text-gray-700 md:block">Admin</span>
            </div>
        </div>
    </div>
</header>