<div id="sidebar" class="flex flex-col transition-transform duration-300 ease-in-out transform -translate-x-full bg-white border-r border-gray-200 w-68 lg:translate-x-0 lg:static lg:transform-none">
    <!-- Logo Section -->
    <div class="flex items-center flex-shrink-0 px-6 py-6 border-b border-gray-200">
        <div class="flex items-center">
            <div>
                <div class="flex items-center gap-2">
                    <img src="assets/images/peso-logo.png" alt="Logo 2" class="w-auto h-8">
                    <img src="assets/images/sikap-logo.png" alt="Logo 1" class="w-auto h-8 shadow-sm">
                    <a href="?page=landing" class="text-xl font-bold text-primary">Sikap <span class="text-secondary">Admin</span></a>
                </div>
            </div>
        </div>
    </div>

<!-- Search Bar -->
<div class="px-6 py-3 border-b border-gray-200">
    <div class="relative">
        <i class="absolute text-base text-gray-400 -translate-y-1/2 pointer-events-none fas fa-search left-3 top-1/2"></i>
        <span class=""><input 
            type="text" 
            placeholder="Search"
            class="w-full py-2 pl-10 pr-3 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-secondary focus:border-secondary"
            id="sidebar-search"
            onkeyup="filterNavigation()"
        ></span>
        
    </div>
</div>
    
    <!-- Navigation -->
    <nav class="flex-1 px-4 py-2 overflow-y-auto">
        <ul class="space-y-1">
            <li>
                <a href="?page=admin-dashboard" class="flex items-center px-4 py-2 text-sm font-medium <?php echo (!isset($_GET['page']) || $_GET['page'] === 'admin-dashboard') ? 'text-secondary bg-orange-50' : 'text-gray-600 hover:bg-gray-50'; ?> rounded-lg transition-colors">
                    <i class="w-5 h-5 mr-3 fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            
            <li>
                <a href="?page=admin-users" class="flex items-center px-4 py-3 text-sm font-normal text-gray-600 transition-colors rounded-lg hover:bg-gray-50">
                    <i class="w-5 h-5 mr-3 fas fa-users"></i>
                    <span>User Management</span>
                    <i class="ml-auto text-xs fas fa-chevron-down"></i>
                </a>
            </li>
            
            <li>
                <a href="?page=admin-jobs" class="flex items-center px-4 py-3 text-sm font-normal text-gray-600 transition-colors rounded-lg hover:bg-gray-50">
                    <i class="w-5 h-5 mr-3 fas fa-briefcase"></i>
                    <span>Job Management</span>
                    <i class="ml-auto text-xs fas fa-chevron-down"></i>
                </a>
            </li>
            
            <li>
                <a href="?page=admin-accreditations" class="flex items-center px-4 py-3 text-sm font-normal <?php echo (isset($_GET['page']) && $_GET['page'] === 'admin-accreditations') ? 'text-secondary bg-orange-50' : 'text-gray-600 hover:bg-gray-50'; ?> rounded-lg transition-colors">
                    <i class="w-5 h-5 mr-3 fas fa-certificate"></i>
                    <span>Accreditation</span>
                </a>
            </li>
            
            <li>
                <a href="?page=admin-reports" class="flex items-center px-4 py-3 text-sm font-normal text-gray-600 transition-colors rounded-lg hover:bg-gray-50">
                    <i class="w-5 h-5 mr-3 fas fa-chart-bar"></i>
                    <span>All Reports</span>
                </a>
            </li>
            
            <li>
                <a href="?page=admin-applications" class="flex items-center px-4 py-3 text-sm font-normal text-gray-600 transition-colors rounded-lg hover:bg-gray-50">
                    <i class="w-5 h-5 mr-3 fas fa-file-alt"></i>
                    <span>Applications</span>
                </a>
            </li>
            
            <li>
                <a href="?page=admin-announcements" class="flex items-center px-4 py-3 text-sm font-normal text-gray-600 transition-colors rounded-lg hover:bg-gray-50">
                    <i class="w-5 h-5 mr-3 fas fa-bullhorn"></i>
                    <span>Announcements & Notices</span>
                </a>
            </li>
            
            <li>
                <a href="?page=admin-chatbot" class="flex items-center px-4 py-3 text-sm font-normal text-gray-600 transition-colors rounded-lg hover:bg-gray-50">
                    <i class="w-5 h-5 mr-3 fas fa-robot"></i>
                    <span>Chatbot / FAQ Manager</span>
                </a>
            </li>
            
            <li>
                <a href="?page=admin-events" class="flex items-center px-4 py-3 text-sm font-normal text-gray-600 transition-colors rounded-lg hover:bg-gray-50">
                    <i class="w-5 h-5 mr-3 fas fa-calendar-alt"></i>
                    <span>Job Fair / Event Management</span>
                </a>
            </li>
        </ul>
    </nav>
    
    <!-- Bottom Section -->
    <div class="flex-shrink-0 p-4 border-t border-gray-200">
        <div class="flex items-center mb-4">
            <img src="https://via.placeholder.com/32/4F46E5/FFFFFF?text=BA" alt="Benedict Admin" class="w-8 h-8 rounded-full">
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-900">Benedict Admin</p>
            </div>
        </div>
        <div class="space-y-1">
            <a href="#" class="flex items-center px-3 py-2 text-sm text-gray-600 transition-colors rounded-lg hover:bg-gray-50">
                <i class="w-4 h-4 mr-3 fas fa-cog"></i>
                <span>Settings</span>
            </a>
            <a href="?page=logout" class="flex items-center px-3 py-2 text-sm text-red-600 transition-colors rounded-lg hover:bg-red-50">
                <i class="w-4 h-4 mr-3 fas fa-sign-out-alt"></i>
                <span>Log out</span>
            </a>
        </div>
    </div>
</div>

<!-- Mobile Sidebar for Mobile -->
<div class="fixed inset-0 z-40 lg:hidden">
    <div id="sidebar-mobile" class="fixed inset-y-0 left-0 z-50 w-64 transition-transform duration-300 ease-in-out transform -translate-x-full bg-white border-r border-gray-200">
        <!-- Logo Section -->
        <div class="flex items-center px-6 py-4 border-b border-gray-200">
            <div class="flex items-center">
                <div class="flex items-center justify-center w-8 h-8 mr-3 rounded-lg bg-secondary">
                    <span class="text-sm font-bold text-white">S</span>
                </div>
                <div>
                    <h1 class="text-lg font-bold text-primary">Sikap</h1>
                    <span class="text-xs font-medium text-secondary">Admin</span>
                </div>
            </div>
        </div>
        
        <!-- Mobile Navigation -->
        <nav class="flex-1 px-4 py-6 overflow-y-auto">
            <ul class="space-y-1">
                <li>
                    <a href="?page=admin-dashboard" class="flex items-center px-4 py-2 text-sm font-medium <?php echo (!isset($_GET['page']) || $_GET['page'] === 'admin-dashboard') ? 'text-secondary bg-orange-50' : 'text-gray-600 hover:bg-gray-50'; ?> rounded-lg transition-colors">
                        <i class="w-5 h-5 mr-3 fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                
                <li>
                    <a href="?page=admin-users" class="flex items-center px-4 py-2 text-sm font-medium text-gray-600 transition-colors rounded-lg hover:bg-gray-50">
                        <i class="w-5 h-5 mr-3 fas fa-users"></i>
                        <span>User Management</span>
                        <i class="ml-auto text-xs fas fa-chevron-down"></i>
                    </a>
                </li>
                
                <li>
                    <a href="?page=admin-jobs" class="flex items-center px-4 py-2 text-sm font-medium text-gray-600 transition-colors rounded-lg hover:bg-gray-50">
                        <i class="w-5 h-5 mr-3 fas fa-briefcase"></i>
                        <span>Job Management</span>
                        <i class="ml-auto text-xs fas fa-chevron-down"></i>
                    </a>
                </li>
                
                <li>
                    <a href="?page=admin-accreditations" class="flex items-center px-4 py-2 text-sm font-medium <?php echo (isset($_GET['page']) && $_GET['page'] === 'admin-accreditations') ? 'text-secondary bg-orange-50' : 'text-gray-600 hover:bg-gray-50'; ?> rounded-lg transition-colors">
                        <i class="w-5 h-5 mr-3 fas fa-certificate"></i>
                        <span>Accreditation</span>
                    </a>
                </li>
                
                <li>
                    <a href="?page=admin-reports" class="flex items-center px-4 py-2 text-sm font-medium text-gray-600 transition-colors rounded-lg hover:bg-gray-50">
                        <i class="w-5 h-5 mr-3 fas fa-chart-bar"></i>
                        <span>All Reports</span>
                    </a>
                </li>
                
                <li>
                    <a href="?page=admin-applications" class="flex items-center px-4 py-2 text-sm font-medium text-gray-600 transition-colors rounded-lg hover:bg-gray-50">
                        <i class="w-5 h-5 mr-3 fas fa-file-alt"></i>
                        <span>Applications</span>
                    </a>
                </li>
                
                <li>
                    <a href="?page=admin-announcements" class="flex items-center px-4 py-2 text-sm font-medium text-gray-600 transition-colors rounded-lg hover:bg-gray-50">
                        <i class="w-5 h-5 mr-3 fas fa-bullhorn"></i>
                        <span>Announcements & Notices</span>
                    </a>
                </li>
                
                <li>
                    <a href="?page=admin-chatbot" class="flex items-center px-4 py-2 text-sm font-medium text-gray-600 transition-colors rounded-lg hover:bg-gray-50">
                        <i class="w-5 h-5 mr-3 fas fa-robot"></i>
                        <span>Chatbot / FAQ Manager</span>
                    </a>
                </li>
                
                <li>
                    <a href="?page=admin-events" class="flex items-center px-4 py-2 text-sm font-medium text-gray-600 transition-colors rounded-lg hover:bg-gray-50">
                        <i class="w-5 h-5 mr-3 fas fa-calendar-alt"></i>
                        <span>Job Fair / Event Management</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>

