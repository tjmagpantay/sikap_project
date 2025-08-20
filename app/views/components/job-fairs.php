<section class="w-full py-16 bg-gray-50">
  <div class="max-w-7xl mx-auto px-4 text-center">
    <h2 class="text-3xl sm:text-4xl font-bold text-gray-800 mb-4">Programs and Events</h2>
    <p class="text-gray-600 mb-12 max-w-3xl mx-auto">
      Join meaningful events and programs that can help you build skills, connect with others, and advance your career.
    </p>

    <!-- Filter Tabs -->
    <div class="flex flex-wrap justify-center gap-4 mb-12">
      <button class="filter-btn px-6 py-3 text-sm font-medium text-white bg-primary rounded-lg hover:bg-primary/90 transition-all duration-200" onclick="filterEvents('all')" data-category="all">
        All Programs
      </button>
      <button class="filter-btn px-6 py-3 text-sm font-medium text-gray-600 bg-white rounded-lg hover:bg-gray-50 transition-all duration-200" onclick="filterEvents('events')" data-category="events">
        Events
      </button>
      <button class="filter-btn px-6 py-3 text-sm font-medium text-gray-600 bg-white rounded-lg hover:bg-gray-50 transition-all duration-200" onclick="filterEvents('seminar')" data-category="seminar">
        Seminars
      </button>
      <button class="filter-btn px-6 py-3 text-sm font-medium text-gray-600 bg-white rounded-lg hover:bg-gray-50 transition-all duration-200" onclick="filterEvents('webinar')" data-category="webinar">
        Webinars
      </button>
      <button class="filter-btn px-6 py-3 text-sm font-medium text-gray-600 bg-white rounded-lg hover:bg-gray-50 transition-all duration-200" onclick="filterEvents('training')" data-category="training">
        Training
      </button>
    </div>

    <!-- Programs Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
      <!-- Program Card 1 -->
      <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 event-card" data-category="seminar">
        <div class="relative h-48 bg-gradient-to-br from-blue-500 to-purple-600">
          <!-- Placeholder gradient background -->
          <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent"></div>
          <div class="absolute inset-0 flex items-center justify-center">
            <div class="text-center text-white">
              <svg class="w-12 h-12 mx-auto mb-2 opacity-80" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z" />
              </svg>
              <span class="text-xs font-semibold opacity-90">SEMINAR</span>
            </div>
          </div>
          <span class="absolute top-4 left-4 bg-white/20 backdrop-blur-sm text-white text-xs font-semibold px-3 py-1 rounded-full">
            March 30, 2024
          </span>
        </div>
        <div class="p-6">
          <h3 class="font-bold text-lg text-gray-800 mb-3 leading-tight">How To Avoid The Top Six Most Common Job Interview Mistakes</h3>
          <p class="text-gray-600 text-sm mb-4 line-clamp-2">Learn essential tips and strategies to ace your next job interview and avoid common pitfalls that candidates make.</p>
          <div class="flex items-center justify-between">
            <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-full">Free Event</span>
            <button class="text-sm font-semibold text-primary hover:text-primary/80 transition-colors">
              Learn More →
            </button>
          </div>
        </div>
      </div>

      <!-- Program Card 2 -->
      <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 event-card" data-category="training">
        <div class="relative h-48 bg-gradient-to-br from-green-500 to-teal-600">
          <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent"></div>
          <div class="absolute inset-0 flex items-center justify-center">
            <div class="text-center text-white">
              <svg class="w-12 h-12 mx-auto mb-2 opacity-80" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
              </svg>
              <span class="text-xs font-semibold opacity-90">TRAINING</span>
            </div>
          </div>
          <span class="absolute top-4 left-4 bg-white/20 backdrop-blur-sm text-white text-xs font-semibold px-3 py-1 rounded-full">
            March 25, 2024
          </span>
        </div>
        <div class="p-6">
          <h3 class="font-bold text-lg text-gray-800 mb-3 leading-tight">Professional Resume Writing Workshop</h3>
          <p class="text-gray-600 text-sm mb-4 line-clamp-2">Master the art of creating compelling resumes that get noticed by employers and ATS systems.</p>
          <div class="flex items-center justify-between">
            <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-full">₱500</span>
            <button class="text-sm font-semibold text-primary hover:text-primary/80 transition-colors">
              Learn More →
            </button>
          </div>
        </div>
      </div>

      <!-- Program Card 3 -->
      <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 event-card" data-category="webinar">
        <div class="relative h-48 bg-gradient-to-br from-purple-500 to-pink-600">
          <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent"></div>
          <div class="absolute inset-0 flex items-center justify-center">
            <div class="text-center text-white">
              <svg class="w-12 h-12 mx-auto mb-2 opacity-80" fill="currentColor" viewBox="0 0 20 20">
                <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z" />
              </svg>
              <span class="text-xs font-semibold opacity-90">WEBINAR</span>
            </div>
          </div>
          <span class="absolute top-4 left-4 bg-white/20 backdrop-blur-sm text-white text-xs font-semibold px-3 py-1 rounded-full">
            March 22, 2024
          </span>
        </div>
        <div class="p-6">
          <h3 class="font-bold text-lg text-gray-800 mb-3 leading-tight">Career Development in the Digital Age</h3>
          <p class="text-gray-600 text-sm mb-4 line-clamp-2">Explore modern career paths and digital skills needed to succeed in today's evolving job market.</p>
          <div class="flex items-center justify-between">
            <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-full">Online</span>
            <button class="text-sm font-semibold text-primary hover:text-primary/80 transition-colors">
              Learn More →
            </button>
          </div>
        </div>
      </div>

      
    </div>

    <!-- View All Button -->
    <div class="mt-12">
      <button class="px-8 py-4 bg-primary text-white font-semibold rounded-lg hover:bg-primary/90 transition-all duration-200 shadow-lg hover:shadow-xl">
        View All Programs & Events
      </button>
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