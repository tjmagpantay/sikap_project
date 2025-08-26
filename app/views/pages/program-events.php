<?php
include_once __DIR__ . '/../components/navbar-top.php';
include_once __DIR__ . '/../components/navbar.php';
?>

<div class="min-h-screen">
    <div class="px-6 py-8">
        <div class="mx-auto max-w-7xl">

            <!-- Search and Filter Section -->
            <div class="mb-8 space-y-6">
                <!-- Combined Filter and Search Row -->
                <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                    <!-- Filter Tabs - Left side on desktop -->
                    <div class="border-b border-gray-200 lg:border-b-0">
                        <nav class="flex gap-4 overflow-x-auto sm:gap-6 lg:gap-8">
                            <button class="px-1 py-4 text-sm font-medium border-b-2 text-primary border-primary whitespace-nowrap filter-tab active-tab" data-type="all">
                                All Events
                            </button>
                            <button class="px-1 py-4 text-sm font-medium text-gray-500 transition-colors duration-200 border-b-2 border-transparent whitespace-nowrap filter-tab hover:text-gray-700 hover:border-gray-300" data-type="program">
                                Programs
                            </button>
                            <button class="px-1 py-4 text-sm font-medium text-gray-500 transition-colors duration-200 border-b-2 border-transparent whitespace-nowrap filter-tab hover:text-gray-700 hover:border-gray-300" data-type="jobfair">
                                Job Fairs
                            </button>
                            <button class="px-1 py-4 text-sm font-medium text-gray-500 transition-colors duration-200 border-b-2 border-transparent whitespace-nowrap filter-tab hover:text-gray-700 hover:border-gray-300" data-type="local recruitment">
                                Local Recruitment
                            </button>
                        </nav>
                    </div>
                </div>
            </div>

            <!-- Events Container -->
            <?php if (isset($events) && !empty($events)): ?>
                <?php
                // Separate pinned and regular events
                $pinnedEvents = array_filter($events, function ($event) {
                    return isset($event['pinned']) && $event['pinned'] == 1;
                });
                $regularEvents = array_filter($events, function ($event) {
                    return !isset($event['pinned']) || $event['pinned'] == 0;
                });

                // Get the first pinned event for header if available
                $headerEvent = !empty($pinnedEvents) ? array_shift($pinnedEvents) : null;
                ?>

                <!-- Header Event (Featured Pinned Post) - Horizontal Layout -->
                <?php if ($headerEvent): ?>
                    <div class="mb-8">
                        <div class="flex overflow-hidden transition-all duration-300 bg-white shadow-lg rounded-xl hover:shadow-xl h-60"
                            data-type="<?php echo htmlspecialchars($headerEvent['type']); ?>"
                            data-status="<?php echo htmlspecialchars($headerEvent['status']); ?>">

                            <!-- Left Side - Content -->
                            <div class="flex flex-col justify-between flex-1 p-6">
                                <!-- Top Section -->
                                <div>
                                    <!-- Tags Container -->
                                    <div class="flex gap-2 mb-3">
                                        <!-- Pinned Badge - No background, just border -->
                                        <span class="px-3 py-1 text-xs font-medium text-gray-700 border border-gray-400 rounded-full">
                                            PINNED
                                        </span>
                                        <!-- Event Type Badge -->
                                        <span class="px-3 py-1 text-xs font-medium text-gray-700 border border-gray-400 rounded-full">
                                            <?php echo ucwords(htmlspecialchars($headerEvent['type'])); ?>
                                        </span>
                                    </div>

                                    <!-- Featured Label -->
                                    <div class="mb-3">
                                        <span class="px-3 py-1 text-xs font-medium text-yellow-600 bg-yellow-100 rounded-full">
                                            FEATURED EVENT
                                        </span>
                                    </div>

                                    <!-- Title -->
                                    <h2 class="mb-3 text-xl font-bold leading-tight text-gray-900 sm:text-2xl">
                                        <?php echo htmlspecialchars($headerEvent['title']); ?>
                                    </h2>

                                    <!-- Description -->
                                    <?php if (!empty($headerEvent['description'])): ?>
                                        <p class="text-sm text-gray-600 line-clamp-3">
                                            <?php echo htmlspecialchars(substr($headerEvent['description'], 0, 200)) . (strlen($headerEvent['description']) > 200 ? '...' : ''); ?>
                                        </p>
                                    <?php endif; ?>
                                </div>

                                <!-- Bottom Section -->
                                <div class="flex items-center justify-between mt-4">
                                    <!-- Date -->
                                    <p class="text-sm text-gray-500">
                                        <?php echo date('j F Y', strtotime($headerEvent['time_start'])); ?>
                                    </p>

                                    <!-- Learn More Button -->
                                    <a href="?page=event-info&id=<?php echo $headerEvent['event_id']; ?>"
                                        class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white transition-all duration-200 bg-blue-600 rounded-lg hover:bg-blue-700">
                                        Learn More
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </div>
                            </div>

                            <!-- Right Side - Image Container with Fixed Height -->
                            <div class="w-1/3 overflow-hidden bg-gray-100 h-60">
                                <?php if (!empty($headerEvent['image'])): ?>
                                    <img src="<?php echo htmlspecialchars($headerEvent['image']); ?>"
                                        alt="<?php echo htmlspecialchars($headerEvent['title']); ?>"
                                        class="object-cover w-full h-full">
                                <?php else: ?>
                                    <img src="./assets/images/programs-img.png"
                                        alt="<?php echo htmlspecialchars($headerEvent['title']); ?>"
                                        class="object-cover w-full h-full">
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Regular Events Grid -->
                <div id="eventsContainer" class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:gap-8 2xl:grid-cols-4 7xl:grid-cols-5">
                    <!-- Remaining Pinned Events -->
                    <?php foreach ($pinnedEvents as $event): ?>
                        <div class="overflow-hidden transition-all duration-300 bg-white shadow-lg rounded-xl hover:shadow-xl event-card h-80"
                            data-type="<?php echo htmlspecialchars($event['type']); ?>"
                            data-status="<?php echo htmlspecialchars($event['status']); ?>">

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

                                <!-- Tags Container -->
                                <div class="absolute flex gap-2 top-4 left-4">
                                    <!-- Pinned Badge - No background, just border -->
                                    <span class="px-3 py-1 text-xs font-medium text-white border border-white rounded-full">
                                        PINNED
                                    </span>
                                    <!-- Event Type Badge -->
                                    <span class="px-3 py-1 text-xs font-medium text-white border border-white rounded-full">
                                        <?php echo ucwords(htmlspecialchars($event['type'])); ?>
                                    </span>
                                </div>

                                <!-- Event Content -->
                                <div class="absolute text-left text-white bottom-4 left-4 right-4">
                                    <h3 class="mb-2 text-base font-medium leading-tight sm:text-lg">
                                        <?php echo htmlspecialchars($event['title']); ?>
                                    </h3>
                                    <?php if (!empty($event['description'])): ?>
                                        <p class="mb-3 text-xs opacity-80 sm:text-sm line-clamp-2">
                                            <?php echo htmlspecialchars(substr($event['description'], 0, 80)) . (strlen($event['description']) > 80 ? '...' : ''); ?>
                                        </p>
                                    <?php endif; ?>
                                    <div class="flex items-center justify-between">
                                        <!-- Date -->
                                        <p class="text-xs opacity-70">
                                            <?php echo date('j F Y', strtotime($event['time_start'])); ?>
                                        </p>

                                        <!-- Learn More Button -->
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

                    <!-- Regular Events -->
                    <?php foreach ($regularEvents as $event): ?>
                        <div class="overflow-hidden transition-all duration-300 bg-white shadow-lg rounded-xl hover:shadow-xl event-card h-80"
                            data-type="<?php echo htmlspecialchars($event['type']); ?>"
                            data-status="<?php echo htmlspecialchars($event['status']); ?>">

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

                                <!-- Event Type Badge -->
                                <span class="absolute px-3 py-1 text-xs font-medium text-white border border-white rounded-full top-4 left-4">
                                    <?php echo ucwords(htmlspecialchars($event['type'])); ?>
                                </span>

                                <!-- Event Content -->
                                <div class="absolute text-left text-white bottom-4 left-4 right-4">
                                    <h3 class="mb-2 text-base font-medium leading-tight sm:text-lg">
                                        <?php echo htmlspecialchars($event['title']); ?>
                                    </h3>
                                    <?php if (!empty($event['description'])): ?>
                                        <p class="mb-3 text-xs opacity-80 sm:text-sm line-clamp-2">
                                            <?php echo htmlspecialchars(substr($event['description'], 0, 80)) . (strlen($event['description']) > 80 ? '...' : ''); ?>
                                        </p>
                                    <?php endif; ?>
                                    <div class="flex items-center justify-between">
                                        <!-- Date -->
                                        <p class="text-xs opacity-70">
                                            <?php echo date('j F Y', strtotime($event['time_start'])); ?>
                                        </p>

                                        <!-- Learn More Button -->
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
            <?php else: ?>
                <!-- Empty State -->
                <div class="py-16 text-center">
                    <div class="flex flex-col items-center">
                        <div class="flex items-center justify-center w-16 h-16 mb-4 bg-gray-100 rounded-full">
                            <i class="text-2xl text-gray-400 fas fa-calendar-times"></i>
                        </div>
                        <h3 class="mb-2 text-lg font-medium text-gray-900">No events found</h3>
                        <p class="max-w-sm text-gray-500">There are no events available at this time. Check back later for updates.</p>
                    </div>
                </div>
            <?php endif; ?>

            <!-- No Results State (Hidden by default) -->
            <div id="noResults" class="hidden py-16 text-center">
                <div class="flex flex-col items-center">
                    <div class="flex items-center justify-center w-16 h-16 mb-4 bg-gray-100 rounded-full">
                        <i class="text-2xl text-gray-400 fas fa-search"></i>
                    </div>
                    <h3 class="mb-2 text-lg font-medium text-gray-900">No events found</h3>
                    <p class="max-w-sm text-gray-500">Try adjusting your search criteria or browse different event types.</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterTabs = document.querySelectorAll('.filter-tab');
            const eventCards = document.querySelectorAll('.event-card');
            const searchInput = document.getElementById('eventSearch');
            const eventsContainer = document.getElementById('eventsContainer');
            const noResults = document.getElementById('noResults');
            const headerEvent = document.querySelector('.mb-8 > div[data-type]'); // Header event

            // Helper function to normalize event types
            function normalizeEventType(type) {
                return type.toLowerCase().trim().replace(/\s+/g, ' ');
            }

            let activeType = 'all';

            // Filter events function
            function filterEvents() {
                const searchTerm = searchInput ? searchInput.value.toLowerCase().trim() : '';
                let visibleCount = 0;

                // Handle header event filtering
                if (headerEvent) {
                    const headerType = normalizeEventType(headerEvent.dataset.type);
                    const headerTitle = headerEvent.querySelector('h2').textContent.toLowerCase();
                    const headerDescriptionElement = headerEvent.querySelector('p');
                    const headerDescription = headerDescriptionElement ? headerDescriptionElement.textContent.toLowerCase() : '';
                    const headerStatus = headerEvent.dataset.status;

                    const headerMatchesType = activeType === 'all' || headerType === activeType.toLowerCase();
                    const headerMatchesSearch = searchTerm === '' ||
                        headerTitle.includes(searchTerm) ||
                        headerDescription.includes(searchTerm) ||
                        headerType.includes(searchTerm);

                    if (headerStatus === 'show' && headerMatchesType && headerMatchesSearch) {
                        headerEvent.parentElement.style.display = 'block';
                        visibleCount++;
                    } else {
                        headerEvent.parentElement.style.display = 'none';
                    }
                }

                // Handle regular event cards
                eventCards.forEach(card => {
                    const cardType = normalizeEventType(card.dataset.type);
                    const title = card.querySelector('h3').textContent.toLowerCase();
                    const descriptionElement = card.querySelector('p');
                    const description = descriptionElement ? descriptionElement.textContent.toLowerCase() : '';
                    const adminStatus = card.dataset.status;

                    // Only show events with status 'show'
                    if (adminStatus !== 'show') {
                        card.style.display = 'none';
                        return;
                    }

                    const matchesType = activeType === 'all' || cardType === activeType.toLowerCase();
                    const matchesSearch = searchTerm === '' ||
                        title.includes(searchTerm) ||
                        description.includes(searchTerm) ||
                        cardType.includes(searchTerm);

                    if (matchesType && matchesSearch) {
                        card.style.display = 'block';
                        visibleCount++;
                    } else {
                        card.style.display = 'none';
                    }
                });

                // Toggle no results state
                if (visibleCount === 0) {
                    eventsContainer.classList.add('hidden');
                    if (headerEvent) headerEvent.parentElement.classList.add('hidden');
                    noResults.classList.remove('hidden');
                } else {
                    eventsContainer.classList.remove('hidden');
                    noResults.classList.add('hidden');
                }
            }

            // Add click events to filter tabs
            filterTabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    // Remove active state from all tabs
                    filterTabs.forEach(t => {
                        t.classList.remove('text-primary', 'border-primary', 'active-tab');
                        t.classList.add('text-gray-500', 'border-transparent');
                    });

                    // Add active state to clicked tab
                    this.classList.remove('text-gray-500', 'border-transparent');
                    this.classList.add('text-primary', 'border-primary', 'active-tab');

                    // Update active type and filter
                    activeType = this.dataset.type;
                    filterEvents();
                });
            });

            // Search functionality with debounce
            if (searchInput) {
                let searchTimeout;
                searchInput.addEventListener('input', function() {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(filterEvents, 300);
                });
            }

            // Initialize
            filterEvents();
        });
    </script>