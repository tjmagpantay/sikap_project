<?php
// Get events data from EventProgramController
require_once __DIR__ . '/../../controllers/EventProgramController.php';
$eventController = new EventProgramController();
$allEvents = $eventController->getActiveEvents();

// Separate events by type for filtering
$programs = array_filter($allEvents, function ($event) {
  return $event['type'] === 'program';
});
$jobFairs = array_filter($allEvents, function ($event) {
  return $event['type'] === 'jobfair';
});
$localRecruitment = array_filter($allEvents, function ($event) {
  return $event['type'] === 'local recruitment';
});
?>

<section class="w-full py-20 sm:px-6 md:px-16 lg:px-24">
  <div class="px-4 mx-auto text-center max-w-7xl">
    <h2 class="mb-4 text-3xl font-bold text-gray-800 sm:text-4xl">Programs and Events</h2>
    <p class="max-w-3xl mx-auto mb-12 text-sm text-gray-600">
      Join meaningful events and programs that can help you build skills, connect <br> with others, and advance your career.
    </p>

    <!-- Filter Tabs -->
    <div class="flex flex-wrap justify-center gap-8 mb-12">
      <button class="relative px-2 py-3 text-sm font-medium text-blue-600 transition-all duration-200 filter-btn group active" onclick="filterEvents('all')" data-category="all">
        All Events
        <span class="absolute bottom-0 left-0 w-full h-1 transition-transform duration-200 transform scale-x-100 bg-blue-600"></span>
      </button>
      <button class="relative px-2 py-3 text-sm font-medium text-gray-600 transition-all duration-200 filter-btn group hover:text-blue-600" onclick="filterEvents('program')" data-category="program">
        Programs
        <span class="absolute bottom-0 left-0 w-full h-1 transition-transform duration-200 transform scale-x-0 bg-blue-600 group-hover:scale-x-100"></span>
      </button>
      <button class="relative px-2 py-3 text-sm font-medium text-gray-600 transition-all duration-200 filter-btn group hover:text-blue-600" onclick="filterEvents('jobfair')" data-category="jobfair">
        Job Fairs
        <span class="absolute bottom-0 left-0 w-full h-1 transition-transform duration-200 transform scale-x-0 bg-blue-600 group-hover:scale-x-100"></span>
      </button>
      <button class="relative px-2 py-3 text-sm font-medium text-gray-600 transition-all duration-200 filter-btn group hover:text-blue-600" onclick="filterEvents('local recruitment')" data-category="local recruitment">
        Local Recruitment
        <span class="absolute bottom-0 left-0 w-full h-1 transition-transform duration-200 transform scale-x-0 bg-blue-600 group-hover:scale-x-100"></span>
      </button>
    </div>

    <!-- Events Grid -->
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4" id="eventsGrid">
      <?php foreach ($allEvents as $event): ?>
        <div class="overflow-hidden transition-all duration-300 bg-white shadow-lg rounded-xl hover:shadow-xl event-card h-80"
          data-category="<?php echo htmlspecialchars($event['type']); ?>">

          <div class="relative w-full h-full">
            <!-- Background image -->
            <?php if (!empty($event['image'])): ?>
              <img src="<?php echo htmlspecialchars($event['image']); ?>"
                alt="<?php echo htmlspecialchars($event['title']); ?>"
                class="object-cover w-full h-full">
            <?php else: ?>
              <img src="./assets/images/programs-img.png"
                alt="<?php echo htmlspecialchars($event['title']); ?>"
                class="object-cover w-full h-full">
            <?php endif; ?>

            <!-- Gradient overlay -->
            <div class="absolute inset-0" style="background: linear-gradient(0deg, #092C4C 0%, rgba(255,255,255,0.3) 67%); background-blend-mode: overlay;"></div>

            <!-- Event Type Badge with improved styling -->
            <div class="absolute flex gap-2 top-4 left-4">
              <?php if (isset($event['pinned']) && $event['pinned'] == 1): ?>
                <span class="px-3 py-1 text-xs font-medium text-white border border-white rounded-full">
                  PINNED
                </span>
              <?php endif; ?>
              <span class="px-3 py-1 text-xs font-medium text-white border border-white rounded-full">
                <?php echo ucwords(htmlspecialchars($event['type'])); ?>
              </span>
            </div>

            <!-- Event Content -->
            <div class="absolute text-left text-white bottom-4 left-4 right-4">
              <p class="mb-2 text-xs opacity-70">
                <?php echo date('j F Y', strtotime($event['time_start'])); ?>
              </p>
              <h3 class="mb-3 text-base font-medium leading-tight line-clamp-2 sm:text-lg" title="<?php echo htmlspecialchars($event['title']); ?>">
                <?php echo htmlspecialchars($event['title']); ?>
              </h3>
              
              <div class="flex items-center justify-between">
                <span class="text-xs opacity-60">
                  <?php echo date('g:i A', strtotime($event['time_start'])); ?>
                </span>
                <a href="?page=event-info&id=<?php echo $event['event_id']; ?>"
                  class="inline-flex items-center gap-1 py-2 text-xs font-medium text-white transition-colors rounded-lg hover:opacity-80">
                  Learn More
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                  </svg>
                </a>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- Empty State -->
    <?php if (empty($allEvents)): ?>
      <div class="py-16 text-center">
        <div class="flex flex-col items-center">
          <div class="flex items-center justify-center w-16 h-16 mb-4 bg-gray-100 rounded-full">
            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
          </div>
          <h3 class="mb-2 text-lg font-medium text-gray-900">No events available</h3>
          <p class="max-w-sm text-gray-500">Check back later for upcoming programs and events.</p>
        </div>
      </div>
    <?php endif; ?>



  </div>
</section>

<script>
  function filterEvents(category) {
    // Update active button with line indicator
    const buttons = document.querySelectorAll('.filter-btn');
    buttons.forEach(btn => {
      const underline = btn.querySelector('span');
      if (btn.dataset.category === category) {
        // Active state
        btn.classList.remove('text-gray-600');
        btn.classList.add('text-blue-600');
        underline.classList.remove('scale-x-0');
        underline.classList.add('scale-x-100');
      } else {
        // Inactive state
        btn.classList.remove('text-blue-600');
        btn.classList.add('text-gray-600');
        underline.classList.remove('scale-x-100');
        underline.classList.add('scale-x-0');
      }
    });

    // Filter cards and featured event
    const cards = document.querySelectorAll('.event-card');
    const featuredEvent = document.querySelector('.featured-event');
    let visibleCount = 0;

    // Handle featured event
    if (featuredEvent) {
      const featuredCategory = featuredEvent.dataset.category;
      if (category === 'all' || featuredCategory === category) {
        featuredEvent.parentElement.style.display = 'block';
        featuredEvent.style.opacity = '1';
        visibleCount++;
      } else {
        featuredEvent.parentElement.style.display = 'none';
        featuredEvent.style.opacity = '0';
      }
    }

    // Handle regular cards
    cards.forEach(card => {
      if (category === 'all' || card.dataset.category === category) {
        card.style.display = 'block';
        card.style.opacity = '1';
        card.style.transform = 'scale(1)';
        visibleCount++;
      } else {
        card.style.display = 'none';
        card.style.opacity = '0';
        card.style.transform = 'scale(0.95)';
      }
    });

    // Handle empty state
    const eventsGrid = document.getElementById('eventsGrid');
    if (visibleCount === 0) {
      // Show empty state message
      if (!document.getElementById('emptyState')) {
        const emptyState = document.createElement('div');
        emptyState.id = 'emptyState';
        emptyState.className = 'col-span-full py-16 text-center';
        emptyState.innerHTML = `
          <div class="flex flex-col items-center">
            <div class="flex items-center justify-center w-16 h-16 mb-4 bg-gray-100 rounded-full">
              <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
              </svg>
            </div>
            <h3 class="mb-2 text-lg font-medium text-gray-900">No ${category === 'all' ? 'events' : category} found</h3>
            <p class="max-w-sm text-gray-500">Try selecting a different category or check back later.</p>
          </div>
        `;
        eventsGrid.appendChild(emptyState);
      }
      document.getElementById('emptyState').style.display = 'block';
    } else {
      const emptyState = document.getElementById('emptyState');
      if (emptyState) {
        emptyState.style.display = 'none';
      }
    }
  }

  // Initialize with all programs visible and add smooth transitions
  document.addEventListener('DOMContentLoaded', function() {
    // Add transition styles to cards
    const cards = document.querySelectorAll('.event-card');
    cards.forEach(card => {
      card.style.transition = 'all 0.3s ease-in-out';
    });

    const featuredEvent = document.querySelector('.featured-event');
    if (featuredEvent) {
      featuredEvent.style.transition = 'all 0.3s ease-in-out';
    }

    // Initialize with all events shown
    filterEvents('all');
  });
</script>