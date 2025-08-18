<?php
include_once __DIR__ . '/../components/navbar-top.php';
include_once __DIR__ . '/../components/navbar.php';
?>

<div class="min-h-screen">
    <div class="px-4 py-8 sm:px-6 md:px-16 lg:px-24">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Programs & Events</h1>
            <p class="mt-2 text-sm text-gray-600">Discover opportunities and stay updated with SIKAP activities</p>
        </div>

        <!-- Search and Filter Section -->
        <div class="mb-8 space-y-6">
            <!-- Search Bar -->
            <div class="relative max-w-md">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <i class="w-5 h-5 text-gray-400 fas fa-search"></i>
                </div>
                <input type="text" id="eventSearch"
                    class="w-full px-4 py-3 pr-12 text-gray-700 transition-all duration-200 bg-white border border-gray-200 rounded-lg shadow-sm pl-11 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary hover:border-gray-300"
                    placeholder="Search events...">
            </div>

            <!-- Filter Tabs -->
            <div class="border-b border-gray-200">
                <nav class="flex gap-8 overflow-x-auto">
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
        <!-- Events Container -->
        <?php if (isset($events) && !empty($events)): ?>
            <div id="eventsContainer" class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <?php foreach ($events as $event): ?>
                    <div class="overflow-hidden transition-shadow duration-200 bg-white border border-gray-200 rounded-lg shadow hover:shadow-lg event-card"
                        data-type="<?php echo htmlspecialchars($event['type']); ?>"
                        data-status="<?php echo htmlspecialchars($event['status']); ?>">

                        <!-- Event Header with Image -->
                        <?php if (!empty($event['image'])): ?>
                            <div class="relative w-full h-48 overflow-hidden">
                                <img src="<?php echo htmlspecialchars($event['image']); ?>"
                                    alt="<?php echo htmlspecialchars($event['title']); ?>"
                                    class="object-cover w-full h-full">
                                <!-- Status Overlay -->
                                <div class="absolute top-4 right-4">
                                    <?php
                                    $now = new DateTime();
                                    $start = new DateTime($event['time_start']);
                                    $end = new DateTime($event['time_end']);

                                    if ($now < $start) {
                                        echo '<span class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium text-yellow-800 bg-yellow-100/90 backdrop-blur-sm rounded-full shadow-sm">
                                                    <i class="mr-1.5 text-xs fas fa-clock"></i>Upcoming
                                                  </span>';
                                    } elseif ($now <= $end) {
                                        echo '<span class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium text-green-800 bg-green-100/90 backdrop-blur-sm rounded-full shadow-sm">
                                                    <i class="mr-1.5 text-xs fas fa-play"></i>Ongoing
                                                  </span>';
                                    } else {
                                        echo '<span class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium text-gray-600 bg-gray-100/90 backdrop-blur-sm rounded-full shadow-sm">
                                                    <i class="mr-1.5 text-xs fas fa-check"></i>Completed
                                                  </span>';
                                    }
                                    ?>
                                </div>
                            </div>
                        <?php else: ?>
                            <!-- Event Header without Image -->
                            <div class="p-6 border-b border-gray-100 bg-gray-50">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="flex items-center justify-center w-12 h-12 bg-white border-2 border-gray-200 rounded-lg">
                                            <?php
                                            $typeConfig = [
                                                'program' => ['color' => 'text-blue-600', 'icon' => 'fas fa-graduation-cap'],
                                                'jobfair' => ['color' => 'text-green-600', 'icon' => 'fas fa-briefcase'],
                                                'local recruitment' => ['color' => 'text-purple-600', 'icon' => 'fas fa-users']
                                            ];
                                            $config = $typeConfig[$event['type']] ?? ['color' => 'text-gray-600', 'icon' => 'fas fa-calendar'];
                                            ?>
                                            <i class="<?php echo $config['icon']; ?> text-xl <?php echo $config['color']; ?>"></i>
                                        </div>
                                    </div>
                                    <!-- Status Badge -->
                                    <?php
                                    $now = new DateTime();
                                    $start = new DateTime($event['time_start']);
                                    $end = new DateTime($event['time_end']);

                                    if ($now < $start) {
                                        echo '<span class="inline-flex items-center px-2.5 py-1 text-xs font-medium text-yellow-800 bg-yellow-100 rounded-full">
                                                    <i class="mr-1 text-xs fas fa-clock"></i>Upcoming
                                                  </span>';
                                    } elseif ($now <= $end) {
                                        echo '<span class="inline-flex items-center px-2.5 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-full">
                                                    <i class="mr-1 text-xs fas fa-play"></i>Ongoing
                                                  </span>';
                                    } else {
                                        echo '<span class="inline-flex items-center px-2.5 py-1 text-xs font-medium text-gray-600 bg-gray-100 rounded-full">
                                                    <i class="mr-1 text-xs fas fa-check"></i>Completed
                                                  </span>';
                                    }
                                    ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Event Content -->
                        <div class="p-6">
                            <!-- Event Type Badge -->
                            <div class="flex items-center gap-2 mb-3">
                                <?php
                                $typeConfig = [
                                    'program' => ['color' => 'bg-blue-100 text-blue-800', 'icon' => 'fas fa-graduation-cap'],
                                    'jobfair' => ['color' => 'bg-green-100 text-green-800', 'icon' => 'fas fa-briefcase'],
                                    'local recruitment' => ['color' => 'bg-purple-100 text-purple-800', 'icon' => 'fas fa-users']
                                ];
                                $config = $typeConfig[$event['type']] ?? ['color' => 'bg-gray-100 text-gray-800', 'icon' => 'fas fa-calendar'];
                                ?>
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium <?php echo $config['color']; ?>">
                                    <i class="<?php echo $config['icon']; ?> mr-1.5 text-xs"></i>
                                    <?php echo ucwords(htmlspecialchars($event['type'])); ?>
                                </span>
                            </div>

                            <!-- Event Title -->
                            <h3 class="mb-3 text-lg font-bold text-gray-900 line-clamp-2">
                                <?php echo htmlspecialchars($event['title']); ?>
                            </h3>

                            <!-- Event Description -->
                            <?php if (!empty($event['description'])): ?>
                                <p class="mb-4 text-sm text-gray-600 line-clamp-3">
                                    <?php echo htmlspecialchars(substr($event['description'], 0, 120)) . (strlen($event['description']) > 120 ? '...' : ''); ?>
                                </p>
                            <?php endif; ?>

                            <!-- Event Details -->
                            <div class="space-y-2 text-sm text-gray-500">
                                <div class="flex items-center">
                                    <i class="w-4 mr-2 text-xs fas fa-calendar"></i>
                                    <span><?php echo date('M j, Y', strtotime($event['time_start'])); ?></span>
                                </div>
                                <div class="flex items-center">
                                    <i class="w-4 mr-2 text-xs fas fa-clock"></i>
                                    <span>
                                        <?php
                                        echo date('g:i A', strtotime($event['time_start'])) . ' - ' .
                                            date('g:i A', strtotime($event['time_end']));
                                        ?>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Action Button -->
                        <div class="px-6 mb-6">
                            <a href="?page=event-info&id=<?php echo $event['event_id']; ?>"
                                class="inline-flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-white transition-colors rounded-lg bg-primary hover:bg-secondary">
                                Learn More
                                <i class="ml-2 text-xs fas fa-arrow-right"></i>
                            </a>
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
                    card.style.display = '';
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

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>