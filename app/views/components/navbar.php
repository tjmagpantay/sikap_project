<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Website Title</title>
    <link rel="stylesheet" href="path/to/your/styles.css">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="antialiased">
    <!-- Your existing HTML content -->

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
        <div class="items-center hidden lg:flex lg:block">
          <a href="?page=login-jobseeker" class="ml-4 btn-outline">
            Sign In
          </a>
          <a href="?page=login-employer" class="ml-2 btn-primary">
            Post A Job
          </a>
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
          <li><a href="#" class="nav-link">Job Search</a></li>
          <li><a href="#" class="nav-link">Programs</a></li>
          <li><a href="#" class="nav-link">Explore Companies</a></li>
          <li><a href="#" class="nav-link">Community</a></li>
          <li class="flex flex-col gap-2 mt-4">
            <a href="?page=login-jobseeker" class="w-full text-center btn-outline">Sign In</a>
            <a href="?page=login-employer" class="w-full text-center btn-primary">Post A Job</a>
          </li>
        </ul>
      </div>
    </nav>

    <!-- Your existing HTML content -->
</body>
</html>

