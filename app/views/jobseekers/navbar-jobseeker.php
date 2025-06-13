<nav x-data="{ open: false }" class="block w-full px-4 py-4 bg-white shadow-md font-inter sm:px-6 md:px-16 lg:px-24">
  <div class="flex flex-wrap items-center justify-between">
    <div class="flex items-center gap-3">
      <img src="assets/images/peso-logo.png" alt="Logo 2" class="w-auto h-12">
      <img src="assets/images/sikap-logo.png" alt="Logo 1" class="w-auto shadow-sm h-11">
      <a href="?page=landing" class="nav-brand">Sikap</a>
    </div>

    <!-- Desktop Menu -->
    <div class="hidden lg:block">
      <ul class="flex flex-col gap-2 mt-2 mb-4 lg:mb-0 lg:mt-0 lg:flex-row lg:items-center lg:gap-10">
        <li><a href="?page=jobseeker-dashboard" class="nav-link">Home</a></li>
        <li><a href="#" class="nav-link">Job Search</a></li>
        <li><a href="#" class="nav-link">Programs</a></li>
        <li><a href="#" class="nav-link">Explore Companies</a></li>
        <li><a href="#" class="nav-link">Community</a></li>
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
        <!-- Notification -->
        <li>
          <a href="/jobseeker/notifications" class="hover:text-blue-600">
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
          </a>
        </li>

        <!-- Saved Jobs -->
        <li>
          <a href="/jobseeker/saved-jobs" class="hover:text-blue-600">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                class="w-6 h-6 text-gray-500 transition-colors duration-200">
              <path stroke-linecap="round" stroke-linejoin="round"
                    d="M17.593 3.322c1.1.128 1.907 1.077 
                      1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 
                      1.907-2.185a48.507 48.507 0 0 1 11.186 0Z" />
            </svg>
          </a>
        </li>

        <!-- Messages -->
        <li>
          <a href="/jobseeker/messages" class="hover:text-blue-600">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                class="w-6 h-6 text-gray-500 transition-colors duration-200">
              <path stroke-linecap="round" stroke-linejoin="round"
                    d="M21.75 6.75v10.5a2.25 2.25 0 0 
                      1-2.25 2.25h-15a2.25 2.25 0 0 
                      1-2.25-2.25V6.75m19.5 0A2.25 
                      2.25 0 0 0 19.5 4.5h-15a2.25 
                      2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 
                      2.25 0 0 1-1.07 1.916l-7.5 
                      4.615a2.25 2.25 0 0 1-2.36 
                      0L3.32 8.91a2.25 2.25 0 0 
                      1-1.07-1.916V6.75" />
            </svg>
          </a>
        </li>

        <!-- Profile Dropdown -->
        <li x-data="{ profileOpen: false }" class="relative">
          <button 
            @click="profileOpen = !profileOpen"
            @click.away="profileOpen = false"
            class="flex items-center hover:text-blue-600 focus:outline-none">
            <img src="/path/to/profile.jpg" alt="Profile"
                class="w-8 h-8 transition duration-200 border-2 border-gray-300 rounded-full hover:border-blue-600">
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
              
              <a href="?page=jobseeker-documents" 
                 class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                Documents
              </a>
              
              <a href="?page=jobseeker-applications" 
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
    style="display: none;"
  >
    <ul class="flex flex-col gap-4 mt-8">
      <li><a href="#" class="nav-link">Job Search</a></li>
      <li><a href="#" class="nav-link">Programs</a></li>
      <li><a href="#" class="nav-link">Explore Companies</a></li>
      <li><a href="#" class="nav-link">Community</a></li>
      <li><a href="#" class="nav-link">Notifications</a></li>
      <li><a href="#" class="nav-link">Saved Jobs</a></li>
      <li><a href="#" class="nav-link">Messages</a></li>
      <li class="flex flex-col gap-2 mt-4">
        <a href="?page=login-employer" class="w-full text-center btn-primary">Post A Job</a>
      </li>
    </ul>
  </div>



</nav>
