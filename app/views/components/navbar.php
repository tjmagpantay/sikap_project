<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Your Website Title</title>
  <link rel="stylesheet" href="path/to/your/styles.css">
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <style>
    /* Add smooth scrolling behavior */
    html {
      scroll-behavior: smooth;
    }

    /* Optional: Adjust scroll offset to account for fixed navbar */
    #popular-jobs,
    #top-companies {
      scroll-margin-top: 80px;
      /* Adjust based on your navbar height */
    }
  </style>
</head>

<body class="antialiased">
  <!-- Your existing HTML content -->

  <nav x-data="{ open: false }" class="relative block w-full px-4 py-4 bg-white shadow-md font-inter sm:px-6 md:px-16 lg:px-24">
    <div class="flex flex-wrap items-center justify-between mx-auto max-w-7xl">
      <div class="flex items-center gap-3">
        <img src="assets/images/peso-logo.png" alt="Logo 2" class="w-auto h-12">
        <img src="assets/images/sikap-logo.png" alt="Logo 1" class="w-auto shadow-sm h-11">
        <a href="?page=landing" class="text-lg font-medium nav-brand">Sikap</a>
      </div>

      <!-- Desktop Menu -->
      <div class="hidden lg:block">
        <ul class="flex flex-col gap-2 mt-2 mb-4 lg:mb-0 lg:mt-0 lg:flex-row lg:items-center lg:gap-10">
          <li><a href="#popular-jobs" class="nav-link">Job Search</a></li>
          <li><a href="?page=program-events" class="nav-link">Programs</a></li>
          <li><a href="#top-companies" class="nav-link">Explore Companies</a></li>
          <li><a href="?page=about-page" class="nav-link">About Us</a></li>
        </ul>
      </div>

      <!-- Burger Button -->
      <button
        @click="open = !open"
        class="relative ml-auto h-6 max-h-[40px] w-6 max-w-[40px] select-none rounded-lg text-center align-middle text-xs font-medium uppercase text-inherit transition-all hover:bg-transparent focus:bg-transparent active:bg-transparent disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none lg:hidden"
        type="button">
        <span class="absolute transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">
          <!-- Hamburger Icon -->
          <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
          <!-- Close Icon -->
          <svg x-show="open" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </span>
      </button>

      <!-- Action Buttons (Desktop) -->
      <div class="items-center hidden lg:flex lg:block">
        <a href="?page=login-jobseeker" class="ml-4 btn-outline">
          Sign In
        </a>
        <a href="?page=login-employer" class="ml-2 btn-primary">
          Post A Job
        </a>
      </div>
    </div>

    <!-- Mobile Dropdown Menu - Updated with better styling -->
    <div
      x-show="open"
      @click.away="open = false"
      x-transition:enter="transition ease-out duration-200"
      x-transition:enter-start="opacity-0 scale-95"
      x-transition:enter-end="opacity-100 scale-100"
      x-transition:leave="transition ease-in duration-150"
      x-transition:leave-start="opacity-100 scale-100"
      x-transition:leave-end="opacity-0 scale-95"
      class="absolute left-0 right-0 z-50 mt-4 bg-white border border-gray-200 rounded-lg shadow-lg lg:hidden"
      style="display: none;">
      <div class="p-4">
        <ul class="flex flex-col gap-3">
          <li><a href="#popular-jobs" class="block px-3 py-2 text-base text-gray-700 rounded-md hover:bg-gray-100 hover:text-primary nav-link" @click="open = false">Job Search</a></li>
          <li><a href="?page=program-events" class="block px-3 py-2 text-base text-gray-700 rounded-md m hover:bg-gray-100 hover:text-primary nav-link" @click="open = false">Programs</a></li>
          <li><a href="#top-companies" class="block px-3 py-2 text-base text-gray-700 rounded-md hover:bg-gray-100 hover:text-primary nav-link" @click="open = false">Explore Companies</a></li>
          <li><a href="?page=about-us" class="block px-3 py-2 text-base text-gray-700 rounded-md hover:bg-gray-100 hover:text-primary nav-link" @click="open = false">About Us</a></li>

          <!-- Mobile Action Buttons -->
          <li class="pt-3 mt-2 border-t border-gray-200 mborder-t">
            <div class="flex flex-col gap-2 mt-4">
              <button
                type="button" 
                class="w-full px-4 py-2 text-sm font-semibold text-center border border-gray-300 rounded-md hover:bg-gray-100"
                onclick="window.location.href='?page=login-jobseeker';"
                @click="open = false">
                Sign In
              </button>
              <button
                type="button"
                class="w-full px-4 py-2 text-sm text-center text-white rounded-md bg-primary hover:bg-primary/90font-semibold"
                onclick="window.location.href='?page=login-employer';"
                @click="open = false">
                Post A Job
              </button>
            </div>
          </li>

        </ul>
      </div>
    </div>
  </nav>

  <!-- Your existing HTML content -->

  <script>
    // Smooth scrolling for anchor links
    document.addEventListener('DOMContentLoaded', function() {
      // Get all anchor links that start with #
      const anchorLinks = document.querySelectorAll('a[href^="#"]');

      anchorLinks.forEach(link => {
        link.addEventListener('click', function(e) {
          e.preventDefault();

          const targetId = this.getAttribute('href');
          const targetSection = document.querySelector(targetId);

          if (targetSection) {
            // Calculate offset (adjust for navbar height)
            const navbarHeight = 80; // Adjust this value based on your navbar height
            const targetPosition = targetSection.offsetTop - navbarHeight;

            // Smooth scroll to target
            window.scrollTo({
              top: targetPosition,
              behavior: 'smooth'
            });
          }
        });
      });
    });
  </script>
</body>

</html>