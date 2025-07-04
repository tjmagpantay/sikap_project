<section
  class="relative flex flex-col md:flex-row items-center justify-between w-full gap-8 px-4 py-12 sm:px-6 md:px-16 lg:px-24 min-h-[650px]"
  style="
    background: linear-gradient(90deg, rgba(255,255,255,0.3) 0%, #092C4C 67%), url('assets/images/hero-page-bg.png');
    background-blend-mode: overlay;
    background-size: cover;
    background-position: center;
  ">
  <!-- Left Side -->
  <div class="flex flex-col items-start justify-start w-full md:w-1/2">
    <h2 class="mb-4 text-3xl font-bold sm:text-4xl md:text-4xl lg:text-5xl text-primary">
      <span class="block mb-2">Find the Right Job,</span>
      <span class="block mb-2">the Smart Way at</span>
      <span class="block">PESO Rosario</span>
    </h2>
    <h5 class="mb-6 text-md md:text-lg text-primary">
      Register now and discover job opportunities tailored to <br> your skills with Sikap's AI-powered job matching system.
    </h5>

    <!-- Search Component -->
    <form class="w-full max-w-md mb-4 md:max-w-lg lg:max-w-xl">
      <div class="flex flex-col gap-2 p-3 bg-white rounded-sm shadow md:flex-row md:flex-nowrap">
        <!-- Job Title Field -->
        <div class="flex items-center flex-1 min-w-0 gap-2 px-2 py-1">
          <img src="assets/icons/search-svgrepo-com.svg" class="w-5 h-5 text-gray-500" alt="Location Icon" />
          <input
            type="text"
            placeholder="Job title"
            class="flex-1 min-w-0 text-sm bg-transparent border-none outline-none focus:ring-0"
          />
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
              class="flex-1 min-w-0 text-sm bg-transparent border-none outline-none focus:ring-0"
            />
          </div>
        </div>
        <!-- Search Button -->
        <button type="submit" class="w-full min-w-0 mt-2 btn-primary md:w-auto md:mt-0 md:ml-2">
          Search
        </button>
      </div>
    </form>
    <h5 class="mb-6 text-xs text-gray3">Search thousands of jobs and opportunities</h5>
  </div>

  <!-- Right Side (Image & Stat Cards) -->
  <div class="relative flex-col items-center justify-center hidden w-full mb-8 md:flex md:w-1/2 md:mb-0">
    <!-- Hero Image -->
    <img src="./assets/images/hero-page-img.png" alt="Job Seekers" class="w-full max-w-xs rounded-lg md:max-w-sm lg:max-w-md" />

    <!-- Stat Cards for md+ screens (absolute) -->
    <div class="hidden md:block">
      <div class="absolute flex items-center gap-2 px-4 py-2 text-sm text-black bg-white rounded-lg shadow-md top-4 right-4 w-[180px]">
        <img src="assets/icons/red-search.png" class="rounded-md w-11 h-11" />
        <div class="flex flex-col items-start leading-tight">
          <p class="font-bold text-rose-600">289</p>
          <p>Open Jobs</p>
        </div>
      </div>
      <div class="absolute flex items-center gap-2 px-4 py-2 text-sm text-black bg-white rounded-lg shadow-md bottom-4 right-4 w-[180px]">
        <img src="assets/icons/yellow-peeps.png" class="rounded-md w-11 h-11" />
        <div class="flex flex-col items-start leading-tight">
          <p class="font-bold text-yellow-500">11,629</p>
          <p>Candidates</p>
        </div>
      </div>
      <div class="absolute flex items-center gap-2 px-4 py-2 text-sm text-black bg-white rounded-lg shadow-md bottom-4 left-4 w-[180px]">
        <img src="assets/icons/blue-job.png" class="rounded-md w-11 h-11" />
        <div class="flex flex-col items-start leading-tight">
          <p class="font-bold text-blue-700">1,843</p>
          <p>Live Jobs</p>
        </div>
      </div>
    </div>
  </div>
</section>