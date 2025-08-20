<section class="w-full py-20 ">
  <div class="px-4 mx-auto text-center max-w-7xl">
    <h2 class="mb-4 text-3xl font-bold text-gray-800 sm:text-4xl">Programs and Events</h2>
    <p class="max-w-3xl mx-auto mb-12 text-sm text-gray-600">
      Join meaningful events and programs that can help you build skills, connect with others, and advance your career.
    </p>

    <!-- Filter Tabs -->
    <div class="flex flex-wrap justify-center gap-4 mb-12">
      <button class="px-6 py-3 text-sm font-medium text-white transition-all duration-200 rounded-lg filter-btn bg-primary hover:bg-primary/90" onclick="filterEvents('all')" data-category="all">
        All Programs
      </button>
      <button class="px-6 py-3 text-sm font-medium text-gray-600 transition-all duration-200 bg-white rounded-lg filter-btn hover:bg-gray-50" onclick="filterEvents('events')" data-category="events">
        Events
      </button>
      <button class="px-6 py-3 text-sm font-medium text-gray-600 transition-all duration-200 bg-white rounded-lg filter-btn hover:bg-gray-50" onclick="filterEvents('seminar')" data-category="seminar">
        Seminars
      </button>
      <button class="px-6 py-3 text-sm font-medium text-gray-600 transition-all duration-200 bg-white rounded-lg filter-btn hover:bg-gray-50" onclick="filterEvents('webinar')" data-category="webinar">
        Webinars
      </button>
      <button class="px-6 py-3 text-sm font-medium text-gray-600 transition-all duration-200 bg-white rounded-lg filter-btn hover:bg-gray-50" onclick="filterEvents('training')" data-category="training">
        Training
      </button>
    </div>

    <!-- Programs Grid -->
    <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
      <!-- Program Card 1 -->
      <div class="overflow-hidden transition-all duration-300 bg-white shadow-lg rounded-xl hover:shadow-xl event-card" data-category="seminar">
        <div class="relative bg-gray-100 h-96">
          <!-- Background image -->
          <img src="./assets/images/programs-img.png" alt="Program background" class="object-cover w-full h-full">
          <!-- Custom gradient overlay (bottom to top) - blue at bottom -->
          <div class="absolute inset-0" style="background: linear-gradient(0deg, #092C4C 0%, rgba(255,255,255,0.3) 67%); background-blend-mode: overlay;"></div>
          <span class="absolute px-3 py-1 text-xs font-medium text-white border border-white rounded top-4 left-4">
            Program
          </span>
          <div class="absolute text-left text-white bottom-4 left-4 right-4">
            <p class="text-sm opacity-90">30 March 2024</p>
            <h3 class="py-3 font-medium leading-tight text-md">How To Avoid The Top Six Most Common Job Interview Mistakes</h3>
            <button class="px-4 py-2 mt-4 text-sm font-medium text-white transition-colors rounded-lg bg-primary hover:bg-primary/90">
              Read More
            </button>
          </div>
        </div>
      </div>

      <!-- Program Card 2 -->
      <div class="overflow-hidden transition-all duration-300 bg-white shadow-lg rounded-xl hover:shadow-xl event-card" data-category="training">
        <div class="relative bg-gray-100 h-96">
          <!-- Background image -->
          <img src="./assets/images/programs-img.png" alt="Program background" class="object-cover w-full h-full">
          <!-- Custom gradient overlay (bottom to top) - blue at bottom -->
          <div class="absolute inset-0" style="background: linear-gradient(0deg, #092C4C 0%, rgba(255,255,255,0.3) 67%); background-blend-mode: overlay;"></div>
          <span class="absolute px-3 py-1 text-xs font-medium text-white border border-white rounded top-4 left-4">
            Program
          </span>
          <div class="absolute text-left text-white bottom-4 left-4 right-4">
            <p class="mb-2 text-sm opacity-90">25 March 2024</p>
            <h3 class="text-lg font-medium leading-tight">Professional Resume Writing Workshop</h3>
            <button class="px-4 py-2 mt-3 text-sm font-medium text-white transition-colors rounded-lg bg-primary hover:bg-primary/90">
              Read More
            </button>
          </div>
        </div>
      </div>

      <!-- Program Card 3 -->
      <div class="overflow-hidden transition-all duration-300 bg-white shadow-lg rounded-xl hover:shadow-xl event-card" data-category="webinar">
        <div class="relative bg-gray-100 h-96">
          <!-- Background image -->
          <img src="./assets/images/programs-img.png" alt="Program background" class="object-cover w-full h-full">
          <!-- Custom gradient overlay (bottom to top) - blue at bottom -->
          <div class="absolute inset-0" style="background: linear-gradient(0deg, #092C4C 0%, rgba(255,255,255,0.3) 67%); background-blend-mode: overlay;"></div>
          <span class="absolute px-3 py-1 text-xs font-medium text-white border border-white rounded top-4 left-4">
            Program
          </span>
          <div class="absolute text-left text-white bottom-4 left-4 right-4">
            <p class="text-sm opacity-90">30 March 2024</p>
            <h3 class="py-3 font-medium leading-tight text-md">How To Avoid The Top Six Most Common Job Interview Mistakes</h3>
            <button class="px-4 py-2 mt-4 text-sm font-medium text-white transition-colors rounded-lg bg-primary hover:bg-primary/90">
              Read More
            </button>
          </div>
        </div>
      </div>


    </div>

  </div>
</section>

<script>
  function filterEvents(category) {
    // Update active button
    const buttons = document.querySelectorAll('.filter-btn');
    buttons.forEach(btn => {
      if (btn.dataset.category === category) {
        btn.classList.remove('text-gray-600', 'bg-white');
        btn.classList.add('text-white', 'bg-primary');
      } else {
        btn.classList.remove('text-white', 'bg-primary');
        btn.classList.add('text-gray-600', 'bg-white');
      }
    });

    // Filter cards
    const cards = document.querySelectorAll('.event-card');
    cards.forEach(card => {
      if (category === 'all' || card.dataset.category === category) {
        card.style.display = 'block';
        card.style.opacity = '1';
      } else {
        card.style.display = 'none';
        card.style.opacity = '0';
      }
    });
  }

  // Initialize with all programs visible
  document.addEventListener('DOMContentLoaded', function() {
    filterEvents('all');
  });
</script>