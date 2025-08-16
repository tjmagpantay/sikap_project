<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sikap Admin Sidebar</title>
    <!-- Add Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Add Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1f2937',
                        secondary: '#f97316'
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-100">
    <div id="sidebar" class="sticky top-0 bottom-0 flex flex-col h-screen transition-transform duration-300 ease-in-out transform -translate-x-full bg-white border-r border-gray-200 w-68 lg:translate-x-0 lg:static lg:transform-none">
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
                <input 
                    type="text" 
                    placeholder="Search"
                    class="w-full px-4 py-2 pl-10 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-secondary focus:border-secondary"
                    id="sidebar-search"
                    onkeyup="filterNavigation()">
            </div>
        </div>
        
        <!-- Navigation -->
        <nav class="flex-1 px-4 py-2 overflow-y-auto">
            <ul class="space-y-1">
                <li>
                    <a href="?page=admin-dashboard" class="flex items-center px-4 py-2 text-sm font-medium text-gray-600 transition-colors rounded-lg hover:bg-gray-50">
                        <i class="w-5 h-5 mr-3 fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                
                <li>
                    <button type="button" 
                        class="flex items-center w-full px-4 py-3 text-sm font-normal text-gray-600 transition-colors rounded-lg hover:bg-gray-50 focus:outline-none"
                        onclick="toggleDropdown('userDropdown', 'userDropdownArrow')">
                        <i class="w-5 h-5 mr-3 fas fa-users"></i>
                        <span>User Management</span>
                        <span id="userDropdownArrow" class="ml-auto text-xs transition-transform duration-200">&#9660;</span>
                    </button>
                    <ul id="userDropdown" class="hidden mt-2 ml-8 space-y-1">
                        <li>
                            <a href="?page=admin-jobseekers" class="flex items-center px-6 py-2 text-xs font-normal text-gray-500 transition-colors rounded-lg hover:bg-gray-50">
                                <i class="w-4 h-4 mr-2 fas fa-user"></i>
                                <span>Jobseekers</span>
                            </a>
                        </li>
                        <li>
                            <a href="?page=admin-employers" class="flex items-center px-6 py-2 text-xs font-normal text-gray-500 transition-colors rounded-lg hover:bg-gray-50">
                                <i class="w-4 h-4 mr-2 fas fa-building"></i>
                                <span>Employers</span>
                            </a>
                        </li>
                    </ul>
                </li>
                
                <li>
                    <a href="?page=admin-jobs" class="flex items-center px-4 py-3 text-sm font-normal text-gray-600 transition-colors rounded-lg hover:bg-gray-50">
                        <i class="w-5 h-5 mr-3 fas fa-briefcase"></i>
                        <span>Job Management</span>
                        <i class="ml-auto text-xs fas fa-chevron-down"></i>
                    </a>
                </li>
                
                <li>
                    <a href="?page=admin-accreditations" class="flex items-center px-4 py-3 text-sm font-normal text-gray-600 transition-colors rounded-lg hover:bg-gray-50">
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
                    <button type="button" 
                        class="flex items-center w-full px-4 py-3 text-sm font-normal text-gray-600 transition-colors rounded-lg hover:bg-gray-50 focus:outline-none"
                        onclick="toggleDropdown('eventDropdown', 'eventDropdownArrow')">
                        <i class="w-5 h-5 mr-3 fas fa-calendar-alt"></i>
                        <span>Events & Programs</span>
                        <span id="eventDropdownArrow" class="ml-auto text-xs transition-transform duration-200">&#9660;</span>
                    </button>
                    <ul id="eventDropdown" class="hidden mt-2 ml-8 space-y-1">
                        <li>
                            <a href="?page=admin-events" class="flex items-center px-6 py-2 text-xs font-normal text-gray-500 transition-colors rounded-lg hover:bg-gray-50">
                                <i class="w-4 h-4 mr-2 fas fa-list"></i>
                                <span>All Events</span>
                            </a>
                        </li>
                        <li>
                            <a href="?page=admin-event-create" class="flex items-center px-6 py-2 text-xs font-normal text-gray-500 transition-colors rounded-lg hover:bg-gray-50">
                                <i class="w-4 h-4 mr-2 fas fa-plus"></i>
                                <span>Create Event</span>
                            </a>
                        </li>
                    </ul>
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

    <!-- Mobile Sidebar -->
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
                        <a href="?page=admin-dashboard" class="flex items-center px-4 py-2 text-sm font-normal text-gray-600 transition-colors rounded-lg hover:bg-gray-50">
                            <i class="w-5 h-5 mr-3 fas fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    
                    <li>
                        <a href="?page=admin-users" class="flex items-center px-4 py-2 text-sm font-normal text-gray-600 transition-colors rounded-lg hover:bg-gray-50">
                            <i class="w-5 h-5 mr-3 fas fa-users"></i>
                            <span>User Management</span>
                            <i class="ml-auto text-xs fas fa-chevron-down"></i>
                        </a>
                    </li>
                    
                    <li>
                        <a href="?page=admin-jobs" class="flex items-center px-4 py-2 text-sm font-normal text-gray-600 transition-colors rounded-lg hover:bg-gray-50">
                            <i class="w-5 h-5 mr-3 fas fa-briefcase"></i>
                            <span>Job Management</span>
                            <i class="ml-auto text-xs fas fa-chevron-down"></i>
                        </a>
                    </li>
                    
                    <li>
                        <a href="?page=admin-accreditations" class="flex items-center px-4 py-2 text-sm font-normal text-gray-600 transition-colors rounded-lg hover:bg-gray-50">
                            <i class="w-5 h-5 mr-3 fas fa-certificate"></i>
                            <span>Accreditation</span>
                        </a>
                    </li>
                    
                    <li>
                        <a href="?page=admin-reports" class="flex items-center px-4 py-2 text-sm font-normal text-gray-600 transition-colors rounded-lg hover:bg-gray-50">
                            <i class="w-5 h-5 mr-3 fas fa-chart-bar"></i>
                            <span>All Reports</span>
                        </a>
                    </li>
                    
                    <li>
                        <a href="?page=admin-applications" class="flex items-center px-4 py-2 text-sm font-normal text-gray-600 transition-colors rounded-lg hover:bg-gray-50">
                            <i class="w-5 h-5 mr-3 fas fa-file-alt"></i>
                            <span>Applications</span>
                        </a>
                    </li>
                    
                    <li>
                        <a href="?page=admin-announcements" class="flex items-center px-4 py-2 text-sm font-normal text-gray-600 transition-colors rounded-lg hover:bg-gray-50">
                            <i class="w-5 h-5 mr-3 fas fa-bullhorn"></i>
                            <span>Announcements & Notices</span>
                        </a>
                    </li>
                    
                    <li>
                        <a href="?page=admin-chatbot" class="flex items-center px-4 py-2 text-sm font-normal text-gray-600 transition-colors rounded-lg hover:bg-gray-50">
                            <i class="w-5 h-5 mr-3 fas fa-robot"></i>
                            <span>Chatbot / FAQ Manager</span>
                        </a>
                    </li>
                    
                    <li>
                        <button type="button" 
                            class="flex items-center w-full px-4 py-2 text-sm font-normal text-gray-600 transition-colors rounded-lg hover:bg-gray-50 focus:outline-none"
                            onclick="toggleDropdown('eventDropdownMobile', 'eventDropdownArrowMobile')">
                            <i class="w-5 h-5 mr-3 fas fa-calendar-alt"></i>
                            <span>Events & Programs</span>
                            <span id="eventDropdownArrowMobile" class="ml-auto text-xs transition-transform duration-200">&#9660;</span>
                        </button>
                        <ul id="eventDropdownMobile" class="hidden mt-2 ml-8 space-y-1">
                            <li>
                                <a href="?page=admin-events" class="flex items-center px-6 py-2 text-xs font-normal text-gray-500 transition-colors rounded-lg hover:bg-gray-50">
                                    <i class="w-4 h-4 mr-2 fas fa-list"></i>
                                    <span>All Events</span>
                                </a>
                            </li>
                            <li>
                                <a href="?page=admin-event-create" class="flex items-center px-6 py-2 text-xs font-normal text-gray-500 transition-colors rounded-lg hover:bg-gray-50">
                                    <i class="w-4 h-4 mr-2 fas fa-plus"></i>
                                    <span>Create Event</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </div>

    <script>
        function toggleDropdown(dropdownId, arrowId) {
            const dropdown = document.getElementById(dropdownId);
            const arrow = document.getElementById(arrowId);
            dropdown.classList.toggle('hidden');
            arrow.classList.toggle('rotate-180');
        }

        function filterNavigation() {
            // Add your search filter logic here
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
</body>
</html>