<section
  class="relative w-full px-4 py-8 sm:px-6 md:px-16 lg:px-24 min-h-[650px] flex items-center"
  style="
background: linear-gradient(90deg, rgba(255,255,255,0.3) 0%, #092C4C 67%), url('assets/images/hero-page-bg.png');
    background-blend-mode: overlay;
    background-size: cover;
    background-position: center;
  ">

  <div class="w-full mx-auto max-w-7xl">
    <div class="relative flex flex-col items-center justify-between w-full gap-8 md:flex-row">
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
              <img src="assets/icons/search-svgrepo-com.svg" class="w-5 h-5 text-gray-500" alt="Search Icon" />
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
        <h5 class="mb-6 text-xs text-primary">Search thousands of jobs and opportunities</h5>
      </div>

      <!-- Right Side (Image & Stat Cards) -->
      <div class="relative flex-col items-center justify-center hidden w-full mb-8 md:flex md:w-1/2 md:mb-0">
        <!-- Hero Image -->
        <img src="./assets/images/hero-page-img.png" alt="Job Seekers" class="w-full max-w-xs rounded-lg md:max-w-sm lg:max-w-md" />

        <!-- Stat Cards for md+ screens (absolute) -->
        <div class="hidden md:block">
          <div class="absolute flex items-center gap-2 p-3 text-sm text-black bg-white rounded-lg shadow-md top-4 right-4 w-[200px]">
            <div class="flex items-center justify-center w-12 h-12 bg-blue-100 rounded-lg">
              <svg class="w-8 h-8 p-2" viewBox="0 0 24 24">
                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
              </svg>
            </div>
            <div class="flex flex-col items-start leading-tight">
              <p class="font-bold text-md text-primary">21,078K</p>
              <p class="text-xs text-gray-600">Explore Open jobs</p>
            </div>
          </div>
        
          <div class="absolute flex items-center gap-2 px-4 py-2 text-sm text-black bg-white rounded-lg shadow-md bottom-4 right-4 w-[200px] opacity-30">
            <div class="flex flex-col items-start leading-tight">
              <p class="text-xs text-primary">Hi!</p>
              <p class="text-xs text-primary"> Lorem ipsum dolor sit amet.</p>
            </div>
          </div>


          <div class="absolute flex items-center gap-2  p-3 text-sm text-black bg-white rounded-lg shadow-md bottom-4 left-4 w-[200px]">
            <!-- Container for SVG -->
            <div class="flex items-center justify-center p-3 rounded-lg bg-primary">
              <!-- Example Job/Briefcase SVG -->
              <svg xmlns="http://www.w3.org/2000/svg"
                class="w-6 h-6"
                fill="none"
                viewBox="0 0 24 24"
                stroke="white"
                stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 7V6a2 2 0 012-2h8a2 2 0 012 2v1m-2 4h-8m10-4h.01M4 7h16a2 2 0 012 2v10a2 2 0 01-2 2H4a2 2 0 01-2-2V9a2 2 0 012-2z" />
              </svg>
            </div>

            <!-- Text content -->
            <div class="flex flex-col items-start leading-tight">
              <p class="text-sm font-bold text-primary">Congrats!</p>
              <p class="text-xs text-gray-600">You have got an Email</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>