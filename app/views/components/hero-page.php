<section
  class="relative flex flex-col md:flex-row items-center justify-between w-full gap-8 px-4 py-12 sm:px-6 md:px-16 lg:px-24 min-h-[650px]"
  style="
background: linear-gradient(
    rgba(150, 155, 165, 0.55),
    rgba(150, 155, 165, 0.55)
  ),
  url('assets/images/hero-page-bg.png');
    background-blend-mode: overlay;
    background-size: cover;
    background-position: center;
  ">
  <!-- linear-gradient(90deg, rgba(255,255,255,0.3) 0%, #092C4C 67%), -->
  <!-- Left Side -->
  <div class="flex flex-col items-start justify-start w-full md:w-1/2">
    <h2 class="mb-4 text-3xl font-bold sm:text-4xl md:text-4xl lg:text-5xl" style="background: linear-gradient(to top right, #1567B2, #092C4C); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
      <span class="block mb-2">Find the Right Job,</span>
      <span class="block mb-2">the Smart Way at</span>
      <span class="block">PESO Rosario</span>
    </h2>
    <h5 class="w-full mb-6 text-sm md:text-md text-primary">
      Register now and discover job opportunities tailored to your skills with <br> Sikap's AI-powered job matching system.
    </h5>

    <!-- Search Component -->
    <form class="w-full max-w-md mb-4 md:max-w-lg lg:max-w-xl">
      <div class="flex flex-col gap-2 p-3 bg-white rounded-md shadow md:flex-row md:flex-nowrap">
        <!-- Job Title Field -->
        <div class="flex items-center flex-1 min-w-0 gap-2 px-2 py-1">
          <img src="assets/icons/search-svgrepo-com.svg" class="w-5 h-5 text-gray-500" alt="Location Icon" />
          <input
            type="text"
            placeholder="Job title"
            class="flex-1 min-w-0 text-sm bg-transparent border-none outline-none focus:ring-0" />
        </div>
        <!-- Separator -->
        <div class="hidden w-px h-8 bg-gray-300 md:block"></div>
        <!-- Location Field -->
        <div class="flex items-center flex-1 min-w-0 px-2 py-1 mt-2 md:mt-0">
          <div class="flex items-center flex-1 min-w-0 gap-2 px-2 py-1">
            <img src="assets/icons/location-information-svgrepo-com.svg" class="w-5 h-5 text-gray-500" alt="Location Icon" />
            <input
              type="text"
              placeholder="Location"
              class="flex-1 min-w-0 text-sm bg-transparent border-none outline-none focus:ring-0" />
          </div>
        </div>
        <!-- Search Button -->
        <button type="submit" class="w-full min-w-0 mt-2 rounded-sm btn-primary md:w-auto md:mt-0 md:ml-2">
          Find Job
        </button>
      </div>
    </form>
    <h5 class="mb-6 text-xs text-gray3">Search thousands of jobs and opportunities</h5>
  </div>

  <!-- Right Side (Image & Stat Cards) -->
  <div class="relative flex-col items-center justify-center hidden w-full mb-8 md:flex md:w-1/2 md:mb-0">
    <!-- Hero Image -->
    <img src="./assets/images/hero-page-img.png" alt="Job Seekers" class="w-full max-w-xs rounded-lg md:max-w-sm lg:max-w-md" />

    <!-- Stat Cards for md+ screens (repositioned) -->
    <div class="hidden md:block">
      <!-- Top Left Card - Open Jobs -->
      <div class="absolute flex items-center gap-3 px-4 py-3 text-sm text-black bg-white rounded-xl shadow-lg top-8 left-0 w-[200px] transform -translate-x-4">
        <div class="flex items-center justify-center w-12 h-12 bg-red-100 rounded-lg">
          <img src="assets/icons/red-search.png" class="w-8 h-8" />
        </div>
        <div class="flex flex-col items-start leading-tight">
          <p class="text-xl font-bold text-red-600">289</p>
          <p class="text-gray-600">Open Jobs</p>
        </div>
      </div>

      <!-- Top Right Card - Google Jobs (moved to top left) -->
      <div class="absolute flex items-center gap-3 px-4 py-3 text-sm text-black bg-white rounded-xl shadow-lg top-2 left-0 w-[220px] transform -translate-x-4">
        <div class="flex items-center justify-center w-12 h-12 bg-blue-100 rounded-lg">
          <svg class="w-8 h-8" viewBox="0 0 24 24">
            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
          </svg>
        </div>
        <div class="flex flex-col items-start leading-tight">
          <p class="text-lg font-bold text-primary">21,078K</p>
          <p class="text-xs text-gray-600">Open jobs for you to explore</p>
        </div>
      </div>

      <!-- Bottom Left Card - Candidates -->
      <div class="absolute flex items-center gap-3 px-4 py-3 text-sm text-black bg-white rounded-xl shadow-lg bottom-16 left-0 w-[200px] transform -translate-x-4">
        <div class="flex items-center justify-center w-12 h-12 bg-yellow-100 rounded-lg">
          <img src="assets/icons/yellow-peeps.png" class="w-8 h-8" />
        </div>
        <div class="flex flex-col items-start leading-tight">
          <p class="text-xl font-bold text-yellow-600">11,629</p>
          <p class="text-gray-600">Candidates</p>
        </div>
      </div>

      <!-- Bottom Right Card - Live Jobs -->
      <div class="absolute flex items-center gap-3 px-4 py-3 text-sm text-black bg-white rounded-xl shadow-lg bottom-8 right-0 w-[200px] transform translate-x-4">
        <div class="flex items-center justify-center w-12 h-12 bg-blue-100 rounded-lg">
          <img src="assets/icons/blue-job.png" class="w-8 h-8" />
        </div>
        <div class="flex flex-col items-start leading-tight">
          <p class="text-xl font-bold text-blue-700">1,843</p>
          <p class="text-gray-600">Live Jobs</p>
        </div>
      </div>

      <!-- Floating Profile Cards -->
      <div class="absolute flex items-center gap-2 px-3 py-2 text-sm text-black bg-white rounded-xl shadow-lg bottom-2 left-8 w-[180px]">
        <div class="flex -space-x-2">
          <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=32&h=32&fit=crop&crop=face" class="w-8 h-8 border-2 border-white rounded-full" />
          <img src="https://images.unsplash.com/photo-1494790108755-2616b0179e16?w=32&h=32&fit=crop&crop=face" class="w-8 h-8 border-2 border-white rounded-full" />
          <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=32&h=32&fit=crop&crop=face" class="w-8 h-8 border-2 border-white rounded-full" />
          <div class="flex items-center justify-center w-8 h-8 text-xs font-medium text-white bg-gray-500 border-2 border-white rounded-full">+</div>
        </div>
        <div class="flex flex-col items-start leading-tight">
          <p class="text-xs text-gray-600">Meet other jobseekers</p>
        </div>
      </div>

      <!-- Congrats Card -->
      <div class="absolute flex items-center gap-3 px-4 py-3 text-sm text-black bg-white rounded-xl shadow-lg top-32 left-0 w-[200px] transform -translate-x-8">
        <div class="flex items-center justify-center w-10 h-10 bg-blue-100 rounded-lg">
          <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
          </svg>
        </div>
        <div class="flex flex-col items-start leading-tight">
          <p class="font-semibold text-gray-800">Congrats!</p>
          <p class="text-xs text-gray-600">You have got an Email</p>
        </div>
      </div>
    </div>
  </div>
</section>