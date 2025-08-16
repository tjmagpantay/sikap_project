<?php
$title = "Programs & Events";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?> - SIKAP</title>
    <link rel="css/output.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-white">
    <?php include __DIR__ . '/../components/navbar.php'; ?>

    <main class="max-w-4xl mx-auto">
        <!-- Header Section -->
        <div class="px-6 py-8 border-b border-gray-100">
            <h1 class="mb-2 text-4xl font-bold text-gray-900">Programs & Events</h1>
            <p class="text-lg text-gray-600">Discover opportunities and stay updated with SIKAP activities</p>
        </div>

        <!-- Search Bar -->
        <div class="px-6 py-6 border-b border-gray-100">
            <div class="relative max-w-md">
                <input type="text" id="eventSearch" 
                    class="w-full px-4 py-3 pl-12 text-gray-700 transition-all duration-200 border border-gray-200 rounded-full bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-200 focus:border-transparent" 
                    placeholder="Search events...">
                <div class="absolute inset-y-0 left-0 flex items-center pl-4">
                    <i class="text-sm text-gray-400 fas fa-search"></i>
                </div>
            </div>
        </div>

        <!-- Filter Tabs -->
        <div class="px-6 border-b border-gray-100">
            <div class="relative">
                <nav class="flex py-2 space-x-12 overflow-x-auto">
                    <button class="px-3 py-4 text-sm font-medium text-gray-900 whitespace-nowrap filter-tab active-tab" data-type="all">
                        All Events
                    </button>
                    <button class="px-3 py-4 text-sm font-medium text-gray-500 transition-colors duration-200 rounded-lg whitespace-nowrap filter-tab hover:text-gray-700 hover:bg-gray-50" data-type="program">
                        Programs
                    </button>
                    <button class="px-3 py-4 text-sm font-medium text-gray-500 transition-colors duration-200 rounded-lg whitespace-nowrap filter-tab hover:text-gray-700 hover:bg-gray-50" data-type="jobfair">
                        Job Fairs
                    </button>
                    <button class="px-3 py-4 text-sm font-medium text-gray-500 transition-colors duration-200 rounded-lg whitespace-nowrap filter-tab hover:text-gray-700 hover:bg-gray-50" data-type="local recruitment">
                        Local Recruitment
                    </button>
                </nav>
                <div class="tab-underline" style="width: 71px;"></div>
            </div>
        </div>

        <!-- Events Container -->
        <div class="px-4 py-8 sm:px-6">
            <!-- Events List -->
            <div id="eventsContainer" class="grid grid-cols-1 gap-8 mx-auto md:grid-cols-2 lg:grid-cols-3 max-w-7xl">
                <?php if (isset($events) && !empty($events)): ?>
                    <?php foreach ($events as $event): ?>
                        <article class="overflow-hidden transition-shadow duration-200 bg-white border border-gray-100 rounded-lg shadow-sm event-card hover:shadow-md" 
                            data-type="<?php echo htmlspecialchars($event['type']); ?>"
                            data-status="<?php echo htmlspecialchars($event['status']); ?>">
                            <div class="flex flex-col h-full">
                                <?php if (!empty($event['image'])): ?>
                                    <div class="w-full h-48">
                                        <img src="<?php echo htmlspecialchars($event['image']); ?>" 
                                             alt="<?php echo htmlspecialchars($event['title']); ?>" 
                                             class="object-cover w-full h-full rounded-t-lg">
                                    </div>
                                <?php endif; ?>
                                
                                <div class="flex-1 p-6">
                                    <!-- Event Meta Info -->
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
                                        <span class="text-xs text-gray-400">•</span>
                                        <span class="text-xs text-gray-500">
                                            <?php echo date('M j, Y', strtotime($event['time_start'])); ?>
                                        </span>
                                    </div>

                                    <!-- Event Title -->
                                    <h2 class="mb-3 text-xl font-bold text-gray-900 transition-colors duration-200 hover:text-gray-700">
                                        <a href="?page=event-info&id=<?php echo $event['event_id']; ?>" class="hover:text-gray-600">
                                            <?php echo htmlspecialchars($event['title']); ?>
                                        </a>
                                    </h2>

                                    <!-- Event Description -->
                                    <p class="mb-4 leading-relaxed text-gray-600">
                                        <?php 
                                            $description = htmlspecialchars($event['description']);
                                            if (strlen($description) > 100) {
                                                echo substr($description, 0, 100) . '... ';
                                                echo '<a href="event-info.php?id=' . $event['event_id'] . '" class="text-sm font-medium text-blue-600 hover:text-blue-800 hover:underline">read more</a>';
                                            } else {
                                                echo $description;
                                            }
                                        ?>
                                    </p>

                                    <!-- Event Details -->
                                    <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500">
                                        <div class="flex items-center gap-1.5">
                                            <i class="text-xs fas fa-clock"></i>
                                            <span>
                                                <?php 
                                                    echo date('g:i A', strtotime($event['time_start'])) . ' - ' . 
                                                         date('g:i A', strtotime($event['time_end']));
                                                ?>
                                            </span>
                                        </div>
                                        
                                        <?php
                                            $now = new DateTime();
                                            $start = new DateTime($event['time_start']);
                                            $end = new DateTime($event['time_end']);
                                            
                                            if ($now < $start) {
                                                echo '<span class="inline-flex items-center px-2 py-1 text-xs font-medium text-yellow-800 bg-yellow-100 rounded-full">
                                                        <i class="mr-1 text-xs fas fa-clock"></i>Upcoming
                                                      </span>';
                                            } elseif ($now <= $end) {
                                                echo '<span class="inline-flex items-center px-2 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-full">
                                                        <i class="mr-1 text-xs fas fa-play"></i>Ongoing
                                                      </span>';
                                            } else {
                                                echo '<span class="inline-flex items-center px-2 py-1 text-xs font-medium text-gray-600 bg-gray-100 rounded-full">
                                                        <i class="mr-1 text-xs fas fa-check"></i>Completed
                                                      </span>';
                                            }
                                        ?>
                                    </div>

                                    <!-- Read More Link -->
                                    <div class="mt-4">
                                        <a href="?page=event-info&id=<?php echo $event['event_id']; ?>" 
                                           class="inline-flex items-center text-sm font-medium text-blue-600 transition-colors duration-200 hover:text-blue-800">
                                            Learn more
                                            <i class="ml-1 text-xs fas fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                <?php else: ?>
                    <!-- Empty State -->
                    <div class="py-16 text-center">
                        <div class="flex flex-col items-center">
                            <div class="flex items-center justify-center w-16 h-16 mb-4 bg-gray-100 rounded-full">
                                <i class="text-2xl text-gray-400 fas fa-calendar-times"></i>
                            </div>
                            <h3 class="mb-2 text-lg font-medium text-gray-900">No events found</h3>
                            <p class="max-w-sm text-gray-500">There are no events matching your criteria at this time. Check back later for updates.</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

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
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterTabs = document.querySelectorAll('.filter-tab');
            const eventCards = document.querySelectorAll('.event-card');
            const searchInput = document.getElementById('eventSearch');
            const tabUnderline = document.querySelector('.tab-underline');
            const eventsContainer = document.getElementById('eventsContainer');
            const noResults = document.getElementById('noResults');

            // Helper function to normalize event types
            function normalizeEventType(type) {
                return type.toLowerCase().trim().replace(/\s+/g, ' ');
            }
            
            let activeType = 'all';

            // Initialize tab underline position
            function updateTabUnderline(activeTab) {
                const rect = activeTab.getBoundingClientRect();
                const container = activeTab.parentElement.getBoundingClientRect();
                tabUnderline.style.width = rect.width + 'px';
                tabUnderline.style.left = (rect.left - container.left) + 'px';
            }

            // Filter events function
            function filterEvents() {
                const searchTerm = searchInput.value.toLowerCase().trim();
                let visibleCount = 0;

                eventCards.forEach(card => {
                    const cardType = normalizeEventType(card.dataset.type);
                    const title = card.querySelector('h2').textContent.toLowerCase();
                    const description = card.querySelector('p').textContent.toLowerCase();
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
                        t.classList.remove('text-gray-900', 'active-tab');
                        t.classList.add('text-gray-500');
                    });

                    // Add active state to clicked tab
                    this.classList.remove('text-gray-500');
                    this.classList.add('text-gray-900', 'active-tab');

                    // Update underline position
                    updateTabUnderline(this);

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
            const activeTab = document.querySelector('.filter-tab.active-tab');
            if (activeTab) {
                updateTabUnderline(activeTab);
            }
            
            // Show all events by default
            filterEvents();

            // Handle window resize for tab underline
            window.addEventListener('resize', function() {
                const activeTab = document.querySelector('.filter-tab.active-tab');
                if (activeTab) {
                    updateTabUnderline(activeTab);
                }
            });
        });
    </script>
</body>
</html>