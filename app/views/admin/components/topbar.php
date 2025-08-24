<header class="flex-shrink-0 bg-white border-b border-gray-200">
    <div class="flex items-center justify-between px-6 py-4">
        <!-- Left Section -->
        <div class="flex items-center">
            <!-- Mobile menu button -->
            <button onclick="toggleMobileSidebar()" class="p-2 text-gray-500 rounded-md hover:text-gray-900 hover:bg-gray-100 lg:hidden" data-mobile-menu>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            <!-- Page Info -->
            <div class="lg:ml-0">
                <div class="flex items-center gap-2">
                    <h1 class="text-lg font-semibold text-gray-900">
                        <?php
                        $page = $_GET['page'] ?? 'admin-dashboard';
                        switch ($page) {
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
                    <i class="text-sm text-primary fas fa-chevron-down"></i>
                </div>
            </div>
        </div>

        <!-- Right Section -->
        <div class="flex items-center space-x-4 ">

            <!-- Notifications -->
            <button class="relative p-2 text-gray-400 transition-colors hover:text-gray-600">
                <i class="w-5 h-5 fas fa-bell"></i>

            </button>
            <button>
                <a href="?page=view-employer-profile&employer_id=<?php echo $employer['employer_id']; ?>"
                    class="flex-1 px-4 py-2 text-sm font-medium text-center text-white transition-colors rounded-sm bg-primary hover:bg-secondary">
                    Logs
                </a>
            </button>
        </div>
    </div>
</header>