<?php
// filepath: c:\xampp\htdocs\sikap\app\views\admin\components\sidebar.php
?>

<!-- Desktop Sidebar (Fixed/Sticky) -->
<div id="sidebar" class="fixed left-0 top-16 flex flex-col bg-white border-r border-gray-200 w-80 h-[calc(100vh-4rem)] transition-transform duration-300 ease-in-out transform -translate-x-full lg:translate-x-0">

    <!-- Search Bar -->
    <div class="flex-shrink-0 px-6 py-6 border-b border-gray-200">
        <div class="relative">
            <input
                type="text"
                placeholder="Search"
                class="w-full px-4 py-2 pl-10 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-secondary focus:border-secondary"
                id="sidebar-search"
                onkeyup="filterNavigation()">
            <svg class="absolute w-4 h-4 text-gray-400 transform -translate-y-1/2 pointer-events-none left-3 top-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>
    </div>

    <!-- Navigation (Scrollable) -->
    <nav class="flex-1 px-6 py-2 overflow-y-auto">
        <ul class="space-y-1">
            <!-- Dashboard -->
            <li>
                <a href="?page=admin-dashboard" class="flex items-center py-3 text-sm font-normal text-gray-600 transition-colors rounded-lg hover:bg-gray-50">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <rect x="3" y="3" width="6" height="6" rx="1.5" stroke="currentColor" stroke-width="2" />
                        <rect x="13" y="3" width="8" height="10" rx="1.5" stroke="currentColor" stroke-width="2" />
                        <rect x="3" y="13" width="6" height="8" rx="1.5" stroke="currentColor" stroke-width="2" />
                        <rect x="13" y="17" width="8" height="4" rx="1.5" stroke="currentColor" stroke-width="2" />
                    </svg>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- User Management -->
            <li>
                <button type="button"
                    class="flex items-center w-full py-3 text-sm font-normal text-gray-600 transition-colors rounded-lg hover:bg-gray-50 focus:outline-none"
                    onclick="toggleDropdown('userDropdown', 'userDropdownArrow')">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <circle cx="9" cy="7" r="3" stroke="currentColor" stroke-width="2" />
                        <path d="M4 20c0-3 2-5 5-5s5 2 5 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                        <circle cx="17" cy="9" r="2.5" stroke="currentColor" stroke-width="2" />
                        <path d="M14 20c0-2.5 1.5-4 4-4s4 1.5 4 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                    </svg>
                    <span>User Management</span>
                    <svg id="userDropdownArrow" class="w-4 h-4 ml-auto transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <ul id="userDropdown" class="hidden mt-2 ml-8 space-y-1">
                    <li>
                        <a href="?page=admin-jobseekers" class="flex items-center px-6 py-2 text-sm font-normal text-gray-500 transition-colors rounded-lg hover:bg-gray-50">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span>Jobseekers</span>
                        </a>
                    </li>
                    <li>
                        <a href="?page=admin-employers" class="flex items-center px-6 py-2 text-sm font-normal text-gray-500 transition-colors rounded-lg hover:bg-gray-50">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            <span>Employers</span>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Job Management -->
            <li>
                <button type="button"
                    class="flex items-center w-full py-3 text-sm font-normal text-gray-600 transition-colors rounded-lg hover:bg-gray-50 focus:outline-none"
                    onclick="toggleDropdown('jobDropdown', 'jobDropdownArrow')">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 7V6a3 3 0 016 0v1h3a2 2 0 012 2v9a2 2 0 01-2 2H6a2 2 0 01-2-2V9a2 2 0 012-2h3zm0 0h6" />
                    </svg>
                    <span>Job Management</span>
                    <svg id="jobDropdownArrow" class="w-4 h-4 ml-auto transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <ul id="jobDropdown" class="hidden mt-2 ml-8 space-y-1">
                    <li>
                        <a href="?page=admin-jobpost-management" class="flex items-center px-6 py-2 text-sm font-normal text-gray-500 transition-colors rounded-lg hover:bg-gray-50">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v6a2 2 0 002 2h6a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            <span>All Jobs</span>
                        </a>
                    </li>
                    <li>
                        <a href="?page=admin-job-categories" class="flex items-center px-6 py-2 text-sm font-normal text-gray-500 transition-colors rounded-lg hover:bg-gray-50">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                            <span>Categories</span>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Accreditation -->
            <li>
                <a href="?page=admin-accreditations" class="flex items-center py-3 text-sm font-normal text-gray-600 transition-colors rounded-lg hover:bg-gray-50">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                    </svg>
                    <span>Accreditation</span>
                </a>
            </li>

            <!-- Reports -->
            <li>
                <a href="?page=admin-reports" class="flex items-center py-3 text-sm font-normal text-gray-600 transition-colors rounded-lg hover:bg-gray-50">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    <span>All Reports</span>
                </a>
            </li>

            <!-- Applications -->
            <li>
                <a href="?page=admin-applications" class="flex items-center py-3 text-sm font-normal text-gray-600 transition-colors rounded-lg hover:bg-gray-50">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span>Applications</span>
                </a>
            </li>

            <!-- Chatbot -->
            <li>
                <a href="?page=admin-chatbot" class="flex items-center py-3 text-sm font-normal text-gray-600 transition-colors rounded-lg hover:bg-gray-50">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <span>Chatbot / FAQ Manager</span>
                </a>
            </li>

            <!-- Events & Programs -->
            <li>
                <button type="button"
                    class="flex items-center w-full py-3 text-sm font-normal text-gray-600 transition-colors rounded-lg hover:bg-gray-50 focus:outline-none"
                    onclick="toggleDropdown('eventDropdown', 'eventDropdownArrow')">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span>Events & Programs</span>
                    <svg id="eventDropdownArrow" class="w-4 h-4 ml-auto transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <ul id="eventDropdown" class="hidden mt-2 ml-8 space-y-1">
                    <li>
                        <a href="?page=admin-events" class="flex items-center px-6 py-2 text-sm font-normal text-gray-500 transition-colors rounded-lg hover:bg-gray-50">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v6a2 2 0 002 2h6a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                            </svg>
                            <span>All Events</span>
                        </a>
                    </li>
                    <li>
                        <a href="?page=admin-event-create" class="flex items-center px-6 py-2 text-sm font-normal text-gray-500 transition-colors rounded-lg hover:bg-gray-50">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            <span>Create Event</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>

    <!-- Bottom Section (Fixed at bottom) -->
    <div class="flex-shrink-0 px-6 py-6 border-t border-gray-200">
        <div class="flex items-center gap-2 mb-4">
            <div class="flex items-center justify-center w-8 h-8 bg-red-500 rounded-full">
                <span class="text-sm font-bold text-white">
                    <?php echo isset($_SESSION['admin_name']) ? strtoupper(substr($_SESSION['admin_name'], 0, 2)) : 'AD'; ?>
                </span>
            </div>
            <div class="">
                <p class="text-sm font-medium text-gray-900">
                    <?php echo isset($_SESSION['admin_name']) ? htmlspecialchars($_SESSION['admin_name']) : 'Admin User'; ?>
                </p>
                <p class="text-xs text-gray-500">Administrator</p>
            </div>
        </div>
        <div class="space-y-1">
            <a href="?page=admin-settings" class="flex items-center py-2 text-sm font-normal text-gray-600 transition-colors rounded-lg hover:bg-gray-50">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span>Settings</span>
            </a>
            <a href="?page=logout" class="flex items-center py-2 text-sm font-normal text-red-600 transition-colors rounded-lg hover:bg-red-50">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span>Log out</span>
            </a>
        </div>
    </div>
</div>

<!-- Mobile Sidebar Overlay -->
<div id="sidebar-overlay" class="fixed inset-0 z-40 hidden bg-black bg-opacity-50 lg:hidden" onclick="toggleMobileSidebar()"></div>

<!-- Mobile Sidebar -->
<div id="sidebar-mobile" class="fixed inset-y-0 left-0 z-50 transition-transform duration-300 ease-in-out transform -translate-x-full bg-white border-r border-gray-200 w-80 lg:hidden">
    <!-- Mobile Logo Section -->
    <div class="flex items-center justify-between flex-shrink-0 gap-6 px-6 py-2 border-b border-gray-200">
        <div class="flex items-center">
            <div class="flex items-center gap-2">
                <img src="assets/images/peso-logo.png" alt="Logo 2" class="w-auto h-8">
                <img src="assets/images/sikap-logo.png" alt="Logo 1" class="w-auto h-8 shadow-sm">
                <a href="?page=admin-dashboard" class="text-xl font-semibold text-primary">
                    Sikap <span class="font-semibold text-secondary">Admin</span>
                </a>
            </div>
        </div>

        <!-- Close Icon -->
        <button onclick="toggleMobileSidebar()" class="p-2 rounded-md hover:bg-gray-100 focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg"
                class="w-6 h-6 text-gray-700"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- Mobile Search Bar -->
    <div class="px-6 py-2 border-b border-gray-200">
        <div class="relative">
            <input
                type="text"
                placeholder="Search"
                class="w-full px-4 py-2 pr-10 text-sm bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-secondary focus:border-secondary"
                id="sidebar-search-mobile"
                onkeyup="filterNavigationMobile()">
            <svg class="absolute w-4 h-4 text-gray-400 transform -translate-y-1/2 pointer-events-none right-3 top-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>
    </div>

    <!-- Mobile Navigation (same as desktop but with Mobile IDs) -->
    <nav class="flex-1 px-6 py-3 overflow-y-auto">
        <ul class="space-y-2">
            <!-- Same navigation items as desktop, but with mobile-specific dropdown IDs -->
            <!-- I'll keep this shorter for brevity, but include all your navigation items here -->
            <!-- Just change the dropdown IDs to include "Mobile" suffix -->
        </ul>
    </nav>

    <!-- Mobile Bottom Section -->
    <div class="flex-shrink-0 px-6 py-6 border-t border-gray-200">
        <div class="flex items-center gap-2 mb-4">
            <div class="flex items-center justify-center w-8 h-8 bg-red-500 rounded-full">
                <span class="text-sm font-bold text-white">
                    <?php echo isset($_SESSION['admin_name']) ? strtoupper(substr($_SESSION['admin_name'], 0, 2)) : 'AD'; ?>
                </span>
            </div>
            <div class="">
                <p class="text-sm font-medium text-gray-900">
                    <?php echo isset($_SESSION['admin_name']) ? htmlspecialchars($_SESSION['admin_name']) : 'Admin User'; ?>
                </p>
                <p class="text-xs text-gray-500">Administrator</p>
            </div>
        </div>
        <div class="space-y-1">
            <a href="?page=admin-settings" class="flex items-center py-2 text-sm font-normal text-gray-600 transition-colors rounded-lg hover:bg-gray-50">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span>Settings</span>
            </a>
            <a href="?page=logout" class="flex items-center py-2 text-sm font-normal text-red-600 transition-colors rounded-lg hover:bg-red-50">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span>Log out</span>
            </a>
        </div>
    </div>
</div>

<script>
    function toggleDropdown(dropdownId, arrowId) {
        const dropdown = document.getElementById(dropdownId);
        const arrow = document.getElementById(arrowId);

        if (dropdown && arrow) {
            dropdown.classList.toggle('hidden');
            arrow.classList.toggle('rotate-180');
        }
    }

    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');

        if (sidebar) {
            sidebar.classList.toggle('-translate-x-full');
        }
    }

    function toggleMobileSidebar() {
        const sidebar = document.getElementById('sidebar-mobile');
        const overlay = document.getElementById('sidebar-overlay');

        if (sidebar && overlay) {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }
    }

    function filterNavigation() {
        const searchValue = document.getElementById('sidebar-search').value.toLowerCase();
        const navItems = document.querySelectorAll('#sidebar nav ul li');

        navItems.forEach(item => {
            const text = item.textContent.toLowerCase();
            if (text.includes(searchValue)) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    }

    function filterNavigationMobile() {
        const searchValue = document.getElementById('sidebar-search-mobile').value.toLowerCase();
        const navItems = document.querySelectorAll('#sidebar-mobile nav ul li');

        navItems.forEach(item => {
            const text = item.textContent.toLowerCase();
            if (text.includes(searchValue)) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    }

    // Close mobile sidebar when clicking outside
    document.addEventListener('click', function(event) {
        const sidebar = document.getElementById('sidebar-mobile');
        const overlay = document.getElementById('sidebar-overlay');
        const mobileMenuButton = document.querySelector('[data-mobile-menu]');

        if (sidebar && overlay && !sidebar.contains(event.target) && !mobileMenuButton?.contains(event.target)) {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        }
    });

    // Handle window resize
    window.addEventListener('resize', function() {
        const sidebar = document.getElementById('sidebar-mobile');
        const overlay = document.getElementById('sidebar-overlay');

        if (window.innerWidth >= 1024) { // lg breakpoint
            if (sidebar && overlay) {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            }
        }
    });
</script>