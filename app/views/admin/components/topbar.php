<header class="flex-shrink-0 bg-white border-b border-gray-200">
    <div class="flex items-center justify-between px-6 py-4">
        <!-- Left Section -->
        <div class="flex items-center">
            <!-- Mobile menu button -->
            <button onclick="toggleSidebar()" class="p-2 text-gray-500 rounded-md hover:text-gray-900 hover:bg-gray-100 lg:hidden">
                <i class="w-5 h-5 fas fa-bars"></i>
            </button>

            <!-- Page Info -->
            <div class="ml-4 lg:ml-0">
                <div class="flex items-center space-x-2">
                    <h1 class="text-lg font-semibold text-gray-900">
                        <?php 
                        $page = $_GET['page'] ?? 'admin-dashboard';
                        switch($page) {
                            case 'admin-accreditations':
                                echo 'Accreditations';
                                break;
                            case 'admin-review-accreditation':
                                echo 'Review Accreditation';
                                break;
                            default:
                                echo 'Dashboard';
                        }
                        ?>
                    </h1>
                    <i class="text-sm text-gray-400 fas fa-chevron-down"></i>
                </div>
            </div>
        </div>

        <!-- Right Section -->
        <div class="flex items-center space-x-4">
            <!-- Search -->
            <div class="relative hidden md:block">
                <input type="text" placeholder="Search" class="w-64 py-2 pl-10 pr-4 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                <i class="absolute text-gray-400 transform -translate-y-1/2 fas fa-search left-3 top-1/2"></i>
            </div>

            <!-- Notifications -->
            <button class="relative p-2 text-gray-400 transition-colors hover:text-gray-600">
                <i class="w-5 h-5 fas fa-bell"></i>
                <span class="absolute w-2 h-2 bg-red-500 rounded-full -top-1 -right-1"></span>
            </button>

            <!-- Post Job Button -->
            <button class="px-4 py-2 text-sm font-medium text-white transition-colors bg-blue-600 rounded-lg hover:bg-blue-700">
                Post A Job
            </button>
        </div>
    </div>
</header>