<nav class="block w-full px-4 py-4 font-sans bg-white shadow-md sm:px-6 md:px-16 lg:px-24">
  <div class="flex flex-wrap items-center justify-between">
    <div class="flex items-center gap-3">
      <img src="./assets/images/peso-logo.png" alt="Logo 2" class="w-auto h-12">
      <img src="./assets/images/sikap-logo.png" alt="Logo 1" class="w-auto h-11">
      <a href="#" class="nav-brand">Sikap</a>
    </div>

    <div class="hidden lg:block">
      <ul class="flex flex-col gap-2 mt-2 mb-4 lg:mb-0 lg:mt-0 lg:flex-row lg:items-center lg:gap-10">
        <li>
          <a href="#" class="nav-link">Job Search</a>
        </li>
        <li>
          <a href="#" class="nav-link">Programs</a>
        </li>
        <li>
          <a href="#" class="nav-link">Explore Companies</a>
        </li>
        <li>
          <a href="#" class="nav-link">Community</a>
        </li>
      </ul>
    </div>

    <button
      class="relative ml-auto h-6 max-h-[40px] w-6 max-w-[40px] select-none rounded-lg text-center align-middle text-xs font-medium uppercase text-inherit transition-all hover:bg-transparent focus:bg-transparent active:bg-transparent disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none lg:hidden"
      type="button"
    >
      <span class="absolute transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </span>
    </button>

    <div class="items-center lg:flex">
      <button class="ml-4 btn-outline">
        Sign In
      </button>
      <button class="ml-2 btn-primary">
        Post A Job
      </button>
    </div>
  </div>
</nav>
