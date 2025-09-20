<?php
include_once __DIR__ . '/components/jobseeker_auth_check.php';
include_once __DIR__ . '/../components/navbar-top.php';
include_once __DIR__ . '/navbar-jobseeker.php';
?>

<div class="min-h-screen px-4 sm:px-6 md:px-16 lg:px-24">
    <div class="py-8 mx-auto sm:px-2 md:px-4 lg:px-12 max-w-7xl">
        <!-- Breadcrumbs -->
        <nav class="mb-6">
            <div class="flex items-start space-x-2 text-sm">
                <a href="?page=jobseeker-dashboard" class="text-gray-500 transition-colors hover:text-primary">
                    Dashboard
                </a>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                <span class="font-medium text-primary">Programs & Events</span>
            </div>
        </nav>

        <!-- Main Dashboard Content -->
        <div class="flex flex-col gap-6 lg:flex-row">
            <!-- Left Side - Content (2/3) -->
            <div class="w-full lg:!w-2/3 lg:min-w-0 lg:flex-1">
                <!-- Page Header -->
                <div class="mb-8 text-start">
                    <h1 class="mb-4 text-3xl font-bold text-gray-800 sm:text-4xl">Programs and Events</h1>
                    <p class="mb-8 text-sm text-gray-600">
                        Join meaningful events and programs that can help you build skills, connect with others, and advance your career.
                    </p>
                </div>

                <!-- Filter Tabs -->
                <div class="flex flex-wrap gap-4 mb-8">
                    <button class="relative px-2 py-3 text-sm font-medium transition-all duration-200 text-primary filter-btn group active" onclick="filterEvents('all')" data-category="all">
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
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2" id="eventsGrid">
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
                                    <h3 class="mb-3 text-base font-medium leading-tight sm:text-lg">
                                        <?php echo htmlspecialchars($event['title']); ?>
                                    </h3>

                                    <div class="flex items-center justify-between">
                                        <span class="text-xs opacity-60">
                                            <?php echo date('g:i A', strtotime($event['time_start'])); ?>
                                        </span>
                                        <a href="?page=event-info-jobseeker&id=<?php echo $event['event_id']; ?>"
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

            <!-- Right Side - Sidebar (1/3) -->
            <div class="w-full lg:!w-1/3 lg:max-w-md">
                <div class="sticky top-8">

                    <!-- Upcoming Events Card -->
                    <div class="p-6 bg-white border border-gray-100 rounded-lg shadow-sm">
                        <h3 class="mb-4 text-lg font-semibold text-grayMain">Upcoming Events</h3>
                        <div class="space-y-4">
                            <?php
                            $upcomingEvents = array_filter($allEvents, function ($event) {
                                return strtotime($event['time_start']) > time();
                            });
                            $upcomingEvents = array_slice($upcomingEvents, 0, 3);
                            ?>
                            <?php if (!empty($upcomingEvents)): ?>
                                <?php foreach ($upcomingEvents as $event): ?>
                                    <div class="pb-3 border-b border-gray-100 last:border-b-0 last:pb-0">
                                        <!-- Title and Tag on Same Row -->
                                        <div class="flex items-start justify-between gap-3 mb-1">
                                            <h4 class="flex-1 text-sm font-medium leading-tight text-gray-600">
                                                <?php echo htmlspecialchars($event['title']); ?>
                                            </h4>
                                            <span class="inline-flex items-center flex-shrink-0 px-2 py-1 text-xs text-primary bg-blue-50">
                                                <?php echo ucwords($event['type']); ?>
                                            </span>
                                        </div>
                                        <!-- Date Below -->
                                        <p class="text-xs text-gray-500">
                                            <?php echo date('M j, Y - g:i A', strtotime($event['time_start'])); ?>
                                        </p>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p class="text-sm text-gray-500">No upcoming events scheduled.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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

        // Filter cards
        const cards = document.querySelectorAll('.event-card');
        let visibleCount = 0;

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

        // Initialize with all events shown
        filterEvents('all');
    });
</script>