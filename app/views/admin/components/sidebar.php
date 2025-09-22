<?php
// filepath: c:\xampp\htdocs\sikap\app\views\admin\components\sidebar.php
?>

<!-- Desktop Sidebar - Remove conflicting styles, let CSS handle positioning -->
<div class="flex flex-col h-full bg-white">
    <!-- Search Bar -->
    <div class="flex-shrink-0 px-6 py-4">
        <div class="relative">
            <input
                type="text"
                placeholder="Search"
                class="w-full px-4 py-3 pr-10 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-secondary focus:border-secondary"
                id="sidebar-search"
                onkeyup="filterNavigation()">
            <svg class="absolute w-4 h-4 text-gray-400 transform -translate-y-1/2 pointer-events-none right-3 top-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>
    </div>


    <!-- Navigation (Scrollable) -->
    <nav class="flex-1 px-4 mb-2 overflow-y-auto">
        <ul class="space-y-1">
            <!-- Dashboard -->
            <li>
                <a href="?page=admin-dashboard" class="flex items-center px-4 py-3 text-sm font-normal text-gray-600 transition-colors rounded-lg hover:bg-primary hover:text-white">
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
                    class="flex items-center w-full px-4 py-3 text-sm font-normal text-gray-600 transition-colors rounded-lg hover:bg-primary hover:text-white focus:outline-none"
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
                <ul id="userDropdown" class="hidden mt-2 ml-4 space-y-1">
                    <li>
                        <a href="?page=admin-jobseekers" class="flex items-center px-4 py-2 text-sm font-normal text-gray-500 transition-colors rounded-lg hover:bg-gray-50">
                            <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="7" r="4" />
                                <path d="M4 20c0-4 4-7 8-7s8 3 8 7" />
                            </svg>
                            <span>Jobseekers</span>
                        </a>
                    </li>
                    <li>
                        <a href="?page=admin-employers" class="flex items-center px-4 py-2 text-sm font-normal text-gray-500 transition-colors rounded-lg hover:bg-gray-50">
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
                    class="flex items-center w-full px-4 py-3 text-sm font-normal text-gray-600 transition-colors rounded-lg hover:bg-primary hover:text-white focus:outline-none"
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
                <ul id="jobDropdown" class="hidden mt-2 ml-4 space-y-1">
                    <li>
                        <a href="?page=admin-jobpost-management" class="flex items-center px-4 py-2 text-sm font-normal text-gray-500 transition-colors rounded-lg hover:bg-gray-50">
                            <svg class="w-4 h-4 mr-2" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2 9C2 7.89543 2.89543 7 4 7H20C21.1046 7 22 7.89543 22 9V20C22 21.1046 21.1046 22 20 22H4C2.89543 22 2 21.1046 2 20V9Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M16 7V4C16 2.89543 15.1046 2 14 2H10C8.89543 2 8 2.89543 8 4V7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M22 12H2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M7 12V14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M17 12V14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <span>All Jobs</span>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Accreditation -->
            <li>
                <a href="?page=admin-accreditations" class="flex items-center px-4 py-3 text-sm font-normal text-gray-600 transition-colors rounded-lg hover:bg-primary hover:text-white">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                    </svg>
                    <span>Accreditation</span>
                </a>
            </li>

            <!-- Reports -->
            <li>
                <a href="?page=admin-reports" class="flex items-center px-4 py-3 text-sm font-normal text-gray-600 transition-colors rounded-lg hover:bg-primary hover:text-white">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    <span>All Reports</span>
                </a>
            </li>

            <!-- Applications -->
            <li>
                <a href="?page=admin-applications" class="flex items-center px-4 py-3 text-sm font-normal text-gray-600 transition-colors rounded-lg hover:bg-primary hover:text-white">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span>Applications</span>
                </a>
            </li>


            <!-- Events & Programs -->
            <li>
                <button type="button"
                    class="flex items-center w-full px-4 py-3 text-sm font-normal text-gray-600 transition-colors rounded-lg hover:bg-primary hover:text-white focus:outline-none"
                    onclick="toggleDropdown('eventDropdown', 'eventDropdownArrow')">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span>Events & Programs</span>
                    <svg id="eventDropdownArrow" class="w-4 h-4 ml-auto transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <ul id="eventDropdown" class="hidden mt-2 ml-4 space-y-1">
                    <li>
                        <a href="?page=admin-events" class="flex items-center px-4 py-2 text-sm font-normal text-gray-500 transition-colors rounded-lg hover:bg-gray-50">
                            <svg class="w-4 h-4 mr-2" viewBox="0 0 100 100" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <rect x="19" y="18.92" width="60" height="16" rx="4" ry="4"></rect>
                                <rect x="19" y="40.92" width="27" height="16" rx="4" ry="4"></rect>
                                <rect x="19" y="62.92" width="27" height="16" rx="4" ry="4"></rect>
                                <rect x="52" y="40.92" width="27" height="16" rx="4" ry="4"></rect>
                                <rect x="52" y="62.92" width="27" height="16" rx="4" ry="4"></rect>
                            </svg>
                            <span>All Events</span>
                        </a>
                    </li>
                    <li>
                        <a href="?page=admin-event-create" class="flex items-center px-4 py-2 text-sm font-normal text-gray-500 transition-colors rounded-lg hover:bg-gray-50">
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
    <div class="flex-shrink-0 px-4 py-4 border-t border-gray-200">
        <div class="flex items-center gap-3 mb-2">
            <div class="flex items-center justify-center w-10 h-10 p-3 bg-blue-100 rounded-full">
                <span class="text-sm font-bold text-white">
                    <?php echo isset($_SESSION['admin_name']) ? strtoupper(substr($_SESSION['admin_name'], 0, 2)) : 'AD'; ?>
                </span>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-900">
                    <?php echo isset($_SESSION['admin_name']) ? htmlspecialchars($_SESSION['admin_name']) : 'Admin User'; ?>
                </p>
                <p class="text-xs text-gray-500">Administrator</p>
            </div>
        </div>
        <div class="py-4 space-y-1">
            <a href="?page=admin-settings" class="flex items-center px-4 py-2 text-sm font-normal text-gray-600 transition-colors rounded-lg hover:bg-primary hover:text-white">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span>Settings</span>
            </a>
            <a href="?page=logout" class="flex items-center px-4 py-2 text-sm font-normal text-red-600 transition-colors rounded-lg hover:bg-red-50">
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

    function filterNavigation() {
        const searchValue = document.getElementById('sidebar-search').value.toLowerCase();
        const navItems = document.querySelectorAll('nav ul li');

        navItems.forEach(item => {
            const text = item.textContent.toLowerCase();
            if (text.includes(searchValue)) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    }
</script>