<nav class="block w-full px-4 py-4 mx-4 bg-white border-b-4 border-blue-600 shadow-md font-inter sm:px-6 md:px-16 lg:px-24">
  <div class="flex flex-wrap items-center justify-between">
    <div class="flex items-center gap-3">
      <img src="assets/images/peso-logo.png" alt="Logo 2" class="w-auto h-12">
      <img src="assets/images/sikap-logo.png" alt="Logo 1" class="w-auto shadow-sm h-11">
      <a href="?page=landing" class="nav-brand">Sikap <span class="text-secondary">Employer</span></a>
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
        <!-- Notification -->
        <li>
          <a href="?page=employer-notifications" class="hover:text-blue-600">
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

        

        <!-- Business Dropdown -->
        <li x-data="{ businessOpen: false }" class="relative">
          <button 
            @click="businessOpen = !businessOpen"
            @click.away="businessOpen = false"
            class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 transition-colors duration-200 bg-gray-100 rounded-sm hover:bg-gray-200 hover:text-blue-600 focus:outline-none">
            <i class="mr-2 fas fa-building"></i>
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
                <i class="mr-3 text-gray-400 fas fa-user-tie"></i>
                Employer Profile
              </a>

              <a href="?page=manage-jobs"  
                 class="flex items-center px-4 py-2 text-sm text-gray-700 transition-colors duration-200 hover:bg-gray-100 hover:text-gray-900">
                <i class="mr-3 text-gray-400 fas fa-user-tie"></i>
                Manage Jobs
              </a>

              <a href="?page=profile-employer" 
                 class="flex items-center px-4 py-2 text-sm text-gray-700 transition-colors duration-200 hover:bg-gray-100 hover:text-gray-900">
                <i class="mr-3 text-gray-400 fas fa-user-tie"></i>
                View Applications
              </a>              
              <a href="?page=employer-settings" 
                 class="flex items-center px-4 py-2 text-sm text-gray-700 transition-colors duration-200 hover:bg-gray-100 hover:text-gray-900">
                <i class="mr-3 text-gray-400 fas fa-cog"></i>
                Settings
              </a>
              
              <a href="?page=contact-us" 
                 class="flex items-center px-4 py-2 text-sm text-gray-700 transition-colors duration-200 hover:bg-gray-100 hover:text-gray-900">
                <i class="mr-3 text-gray-400 fas fa-envelope"></i>
                Contact Us
              </a>
              
              <hr class="my-1">
              
              <a href="?page=logout" 
                 class="flex items-center px-4 py-2 text-sm text-red-700 transition-colors duration-200 hover:bg-red-50 hover:text-red-900">
                <i class="mr-3 text-red-400 fas fa-sign-out-alt"></i>
                Sign Out
              </a>
            </div>
          </div>
        </li>

        <!-- Post A Job Button -->
        <li>
          <a href="?page=post-job" 
             class="inline-flex items-center px-4 py-2 text-sm font-medium text-white transition-colors duration-200 border border-transparent rounded-sm bg-primary hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            <i class="mr-2 fas fa-plus"></i>
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
    style="display: none;"
  >
    <ul class="flex flex-col gap-4 mt-8">
      <li><a href="?page=employer-dashboard" class="nav-link">Home</a></li>
      <li><a href="?page=browse-candidates" class="nav-link">Browse Candidates</a></li>
      <li><a href="?page=job-management" class="nav-link">Job Management</a></li>
      <li><a href="?page=employer-programs" class="nav-link">Programs</a></li>
      <li><a href="?page=employer-community" class="nav-link">Community</a></li>
      <li><a href="?page=employer-notifications" class="nav-link">Notifications</a></li>
      <li><a href="?page=job-applications" class="nav-link">Applications</a></li>
      <li><a href="?page=employer-messages" class="nav-link">Messages</a></li>
      
      <!-- Business Section -->
      <li class="mt-4">
        <p class="mb-2 text-xs font-semibold tracking-wide text-gray-500 uppercase">Business</p>
        <div class="pl-4 space-y-2">
          <a href="?page=profile-employer" class="text-sm nav-link">Employer Profile</a>
          <a href="?page=employer-settings" class="text-sm nav-link">Settings</a>
          <a href="?page=contact-us" class="text-sm nav-link">Contact Us</a>
        </div>
      </li>
      
      <li class="flex flex-col gap-2 mt-6">
        <a href="?page=post-job" class="w-full text-center btn-primary">Post A Job</a>
        <a href="?page=logout" class="w-full py-2 text-center text-red-600 border border-red-300 rounded-md hover:bg-red-50">Sign Out</a>
      </li>
    </ul>
  </div>
</nav>
