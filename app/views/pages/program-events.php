<!-- APPLY HERE -->

<?php
include_once __DIR__ . '/../components/navbar-top.php';
include_once __DIR__ . '/../components/navbar.php';
?>

<div class="min-h-screen">
    <div class="px-6 py-8">
        <div class="mx-auto max-w-7xl">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Programs & Events</h1>
            <p class="mt-2 text-sm text-gray-600">Discover opportunities and stay updated with SIKAP activities</p>
        </div>

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

                <!-- Search Bar - Right side on desktop -->
                <div class="relative w-full max-w-md">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i class="w-5 h-5 text-gray-400 fas fa-search"></i>
                    </div>
                    <input type="text" id="eventSearch"
                        class="w-full px-4 py-3 pr-12 text-gray-700 transition-all duration-200 bg-white border border-gray-200 rounded-lg shadow-sm pl-11 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary hover:border-gray-300"
                        placeholder="Search events...">
                </div>
            </div>
        </div>

        <!-- Events Container -->
        <?php if (isset($events) && !empty($events)): ?>
            <div id="eventsContainer" class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:gap-8 2xl:grid-cols-4 7xl:grid-cols-5">
                <?php foreach ($events as $event): ?>
                    <div class="overflow-hidden transition-all duration-300 bg-white shadow-lg rounded-xl hover:shadow-xl event-card h-80"
                        data-type="<?php echo htmlspecialchars($event['type']); ?>"
                        data-status="<?php echo htmlspecialchars($event['status']); ?>">

                        <!-- Fixed height container for consistent card heights -->
                        <div class="relative w-full h-full">
                            <!-- Image container with fixed height covering full card -->
                            <div class="relative bg-gray-100 w-full h-full">
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

                                <!-- Custom gradient overlay (bottom to top) - blue at bottom -->
                                <div class="absolute inset-0" style="background: linear-gradient(0deg, #092C4C 0%, rgba(255,255,255,0.3) 67%); background-blend-mode: overlay;"></div>

                                <!-- Event Type Badge -->
                                <span class="absolute px-3 py-1 text-xs font-medium text-white border border-white rounded top-4 left-4">
                                    <?php echo ucwords(htmlspecialchars($event['type'])); ?>
                                </span>

                                <!-- Event Content -->
                                <div class="absolute text-left text-white bottom-4 left-4 right-4">
                                    <p class="text-sm opacity-90">
                                        <?php echo date('j F Y', strtotime($event['time_start'])); ?>
                                    </p>
                                    <h3 class="py-2 font-medium leading-tight text-base sm:text-lg line-clamp-2">
                                        <?php echo htmlspecialchars($event['title']); ?>
                                    </h3>
                                    <?php if (!empty($event['description'])): ?>
                                        <p class="mb-3 text-xs opacity-80 line-clamp-2 sm:text-sm">
                                            <?php echo htmlspecialchars(substr($event['description'], 0, 80)) . (strlen($event['description']) > 80 ? '...' : ''); ?>
                                        </p>
                                    <?php endif; ?>
                                    <a href="?page=event-info&id=<?php echo $event['event_id']; ?>"
                                        class="inline-block px-4 py-2 mt-2 text-sm font-medium text-white transition-colors rounded-lg bg-primary hover:bg-primary/90">
                                        Learn More
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

        // Helper function to normalize event types
        function normalizeEventType(type) {
            return type.toLowerCase().trim().replace(/\s+/g, ' ');
        }

        let activeType = 'all';

        // Filter events function
        function filterEvents() {
            const searchTerm = searchInput.value.toLowerCase().trim();
            let visibleCount = 0;

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
                    card.style.height = '20rem'; // Force consistent height (h-80)
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            // Toggle no results state
            if (visibleCount === 0) {
                eventsContainer.classList.add('hidden');
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
        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(filterEvents, 300);
        });

        // Initialize
        filterEvents();
    });
</script>