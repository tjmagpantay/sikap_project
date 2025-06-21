<div id="sidebar" class="w-64 bg-white border-r border-gray-200 flex flex-col transform -translate-x-full transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:transform-none">
    <!-- Logo Section -->
    <div class="flex items-center px-6 py-4 border-b border-gray-200 flex-shrink-0">
        <div class="flex items-center">
            <div class="w-8 h-8 bg-orange-500 rounded-lg flex items-center justify-center mr-3">
                <span class="text-white font-bold text-sm">S</span>
            </div>
            <div>
                <h1 class="text-lg font-bold text-gray-900">Sikap</h1>
                <span class="text-xs text-orange-500 font-medium">Admin</span>
            </div>
        </div>
    </div>
    
    <!-- Navigation -->
    <nav class="flex-1 px-4 py-6 overflow-y-auto">
        <ul class="space-y-1">
            <li>
                <a href="?page=admin-dashboard" class="flex items-center px-3 py-2 text-sm font-medium text-orange-600 bg-orange-50 rounded-lg">
                    <i class="fas fa-tachometer-alt w-5 h-5 mr-3"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            
            <li>
                <a href="?page=admin-users" class="flex items-center px-3 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">
                    <i class="fas fa-users w-5 h-5 mr-3"></i>
                    <span>User Management</span>
                    <i class="fas fa-chevron-down ml-auto text-xs"></i>
                </a>
            </li>
            
            <li>
                <a href="?page=admin-jobs" class="flex items-center px-3 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">
                    <i class="fas fa-briefcase w-5 h-5 mr-3"></i>
                    <span>Job Management</span>
                    <i class="fas fa-chevron-down ml-auto text-xs"></i>
                </a>
            </li>
            
            <li>
                <a href="?page=admin-accreditations" class="flex items-center px-3 py-2 text-sm font-medium <?php echo (isset($_GET['page']) && $_GET['page'] === 'admin-accreditations') ? 'text-orange-600 bg-orange-50' : 'text-gray-600 hover:bg-gray-50'; ?> rounded-lg transition-colors">
                    <i class="fas fa-certificate w-5 h-5 mr-3"></i>
                    <span>Accreditation</span>
                </a>
            </li>
            
            <li>
                <a href="?page=admin-reports" class="flex items-center px-3 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">
                    <i class="fas fa-chart-bar w-5 h-5 mr-3"></i>
                    <span>All reports</span>
                </a>
            </li>
            
            <li>
                <a href="?page=admin-applications" class="flex items-center px-3 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">
                    <i class="fas fa-file-alt w-5 h-5 mr-3"></i>
                    <span>Applications</span>
                </a>
            </li>
            
            <li>
                <a href="?page=admin-announcements" class="flex items-center px-3 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">
                    <i class="fas fa-bullhorn w-5 h-5 mr-3"></i>
                    <span>Announcements & Notices</span>
                </a>
            </li>
            
            <li>
                <a href="?page=admin-chatbot" class="flex items-center px-3 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">
                    <i class="fas fa-robot w-5 h-5 mr-3"></i>
                    <span>Chatbot / FAQ Manager</span>
                </a>
            </li>
            
            <li>
                <a href="?page=admin-events" class="flex items-center px-3 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">
                    <i class="fas fa-calendar-alt w-5 h-5 mr-3"></i>
                    <span>Job Fair / Event Management</span>
                </a>
            </li>
        </ul>
    </nav>
    
    <!-- Bottom Section -->
    <div class="border-t border-gray-200 p-4 flex-shrink-0">
        <div class="flex items-center">
            <img src="https://via.placeholder.com/32/4F46E5/FFFFFF?text=BA" alt="Benedict Admin" class="w-8 h-8 rounded-full">
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-900">Benedict Admin</p>
            </div>
        </div>
        <div class="mt-3 space-y-1">
            <a href="#" class="flex items-center px-3 py-2 text-sm text-gray-600 hover:bg-gray-50 rounded-lg">
                <i class="fas fa-cog w-4 h-4 mr-3"></i>
                <span>Settings</span>
            </a>
            <a href="?page=logout" class="flex items-center px-3 py-2 text-sm text-red-600 hover:bg-red-50 rounded-lg">
                <i class="fas fa-sign-out-alt w-4 h-4 mr-3"></i>
                <span>Log out</span>
            </a>
        </div>
    </div>
</div>

<!-- Mobile Sidebar Overlay for Mobile -->
<div class="fixed inset-0 z-40 lg:hidden">
    <div id="sidebar-mobile" class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-200 transform -translate-x-full transition-transform duration-300 ease-in-out">
        <!-- Same content as above but for mobile -->
        <div class="flex items-center px-6 py-4 border-b border-gray-200">
            <div class="flex items-center">
                <div class="w-8 h-8 bg-orange-500 rounded-lg flex items-center justify-center mr-3">
                    <span class="text-white font-bold text-sm">S</span>
                </div>
                <div>
                    <h1 class="text-lg font-bold text-gray-900">Sikap</h1>
                    <span class="text-xs text-orange-500 font-medium">Admin</span>
                </div>
            </div>
        </div>
        
        <nav class="flex-1 px-4 py-6 overflow-y-auto">
            <!-- Same navigation items as above -->
            <ul class="space-y-1">
                <li>
                    <a href="?page=admin-dashboard" class="flex items-center px-3 py-2 text-sm font-medium text-orange-600 bg-orange-50 rounded-lg">
                        <i class="fas fa-tachometer-alt w-5 h-5 mr-3"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="?page=admin-users" class="flex items-center px-3 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">
                        <i class="fas fa-users w-5 h-5 mr-3"></i>
                        <span>User Management</span>
                        <i class="fas fa-chevron-down ml-auto text-xs"></i>
                    </a>
                </li>
                
                <li>
                    <a href="?page=admin-jobs" class="flex items-center px-3 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">
                        <i class="fas fa-briefcase w-5 h-5 mr-3"></i>
                        <span>Job Management</span>
                        <i class="fas fa-chevron-down ml-auto text-xs"></i>
                    </a>
                </li>
                
                <li>
                    <a href="?page=admin-accreditations" class="flex items-center px-3 py-2 text-sm font-medium <?php echo (isset($_GET['page']) && $_GET['page'] === 'admin-accreditations') ? 'text-orange-600 bg-orange-50' : 'text-gray-600 hover:bg-gray-50'; ?> rounded-lg transition-colors">
                        <i class="fas fa-certificate w-5 h-5 mr-3"></i>
                        <span>Accreditation</span>
                    </a>
                </li>
                
                <li>
                    <a href="?page=admin-reports" class="flex items-center px-3 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">
                        <i class="fas fa-chart-bar w-5 h-5 mr-3"></i>
                        <span>All reports</span>
                    </a>
                </li>
                
                <li>
                    <a href="?page=admin-applications" class="flex items-center px-3 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">
                        <i class="fas fa-file-alt w-5 h-5 mr-3"></i>
                        <span>Applications</span>
                    </a>
                </li>
                
                <li>
                    <a href="?page=admin-announcements" class="flex items-center px-3 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">
                        <i class="fas fa-bullhorn w-5 h-5 mr-3"></i>
                        <span>Announcements & Notices</span>
                    </a>
                </li>
                
                <li>
                    <a href="?page=admin-chatbot" class="flex items-center px-3 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">
                        <i class="fas fa-robot w-5 h-5 mr-3"></i>
                        <span>Chatbot / FAQ Manager</span>
                    </a>
                </li>
                
                <li>
                    <a href="?page=admin-events" class="flex items-center px-3 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">
                        <i class="fas fa-calendar-alt w-5 h-5 mr-3"></i>
                        <span>Job Fair / Event Management</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>