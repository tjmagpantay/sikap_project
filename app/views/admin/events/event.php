<?php
// Remove the auth check since dashboard.php already handles it
// include_once __DIR__ . '/../components/admin_auth_check.php';
?>

<!-- Remove ALL HTML structure - make it content-only like main-board.php -->
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">Events & Programs</h1>
            <p class="mt-1 text-gray-600">Manage all events and programs</p>
        </div>
        <div>
            <a href="index.php?page=admin-event-create"
                class="inline-flex items-center px-4 py-3 text-sm font-medium text-white transition-colors duration-200 border rounded-sm bg-primary border-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                <i class="mr-2 fas fa-plus"></i>
                Create New Event
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 gap-4 mb-6 sm:gap-6 sm:mb-8 md:grid-cols-4">
        <!-- Card 1: Total Events -->
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-6">
            <div class="mb-4 sm:mb-6">
                <h3 class="mb-3 text-sm font-medium text-gray-700 sm:mb-4">Total Events</h3>
                <div class="flex items-baseline">
                    <span class="text-2xl font-bold text-gray-900 sm:text-3xl" id="totalCount"><?php echo count($events ?? []); ?></span>
                    <svg class="ml-1 sm:ml-2" width="14px" height="14px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" stroke="#2563EB" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </g>
                    </svg>
                </div>
                <p class="mt-2 text-xs text-gray-500">
                    All events and programs
                </p>
            </div>
        </div>

        <!-- Card 2: Upcoming Events -->
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-6">
            <div class="mb-4 sm:mb-6">
                <h3 class="mb-3 text-sm font-medium text-gray-700 sm:mb-4">Upcoming</h3>
                <div class="flex items-baseline">
                    <span class="text-2xl font-bold text-gray-900 sm:text-3xl" id="upcomingCount">
                        <?php
                        $now = new DateTime();
                        echo count(array_filter($events ?? [], function ($event) use ($now) {
                            $start = new DateTime($event['time_start']);
                            return $now < $start;
                        }));
                        ?>
                    </span>
                    <svg class="ml-1 sm:ml-2" width="14px" height="14px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path d="M12 8V12L15 15M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="#F59E0B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </g>
                    </svg>
                </div>
                <p class="mt-2 text-xs text-gray-500">
                    Events scheduled for future
                </p>
            </div>
        </div>

        <!-- Card 3: Ongoing Events -->
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-6">
            <div class="mb-4 sm:mb-6">
                <h3 class="mb-3 text-sm font-medium text-gray-700 sm:mb-4">Ongoing</h3>
                <div class="flex items-baseline">
                    <span class="text-2xl font-bold text-gray-900 sm:text-3xl" id="ongoingCount">
                        <?php
                        $now = new DateTime();
                        echo count(array_filter($events ?? [], function ($event) use ($now) {
                            $start = new DateTime($event['time_start']);
                            $end = new DateTime($event['time_end']);
                            return $now >= $start && $now <= $end;
                        }));
                        ?>
                    </span>
                    <svg class="ml-1 sm:ml-2" width="14px" height="14px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path d="M9 12L11 14L15 10M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="#10B981" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </g>
                    </svg>
                </div>
                <p class="mt-2 text-xs text-gray-500">
                    Currently active events
                </p>
            </div>
        </div>

        <!-- Card 4: Completed Events -->
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-6">
            <div class="mb-4 sm:mb-6">
                <h3 class="mb-3 text-sm font-medium text-gray-700 sm:mb-4">Completed</h3>
                <div class="flex items-baseline">
                    <span class="text-2xl font-bold text-gray-900 sm:text-3xl" id="completedCount">
                        <?php
                        $now = new DateTime();
                        echo count(array_filter($events ?? [], function ($event) use ($now) {
                            $end = new DateTime($event['time_end']);
                            return $now > $end;
                        }));
                        ?>
                    </span>
                    <svg class="ml-1 sm:ml-2" width="14px" height="14px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path d="M9 12L11 14L15 10M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="#6B7280" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </g>
                    </svg>
                </div>
                <p class="mt-2 text-xs text-gray-500">
                    Events that have ended
                </p>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    <?php if (isset($_GET['success'])): ?>
        <div class="p-4 mb-6 text-green-700 bg-green-100 rounded-lg">
            <?php echo htmlspecialchars($_GET['success']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
        <div class="p-4 mb-6 text-red-700 bg-red-100 rounded-lg">
            <?php echo htmlspecialchars($_GET['error']); ?>
        </div>
    <?php endif; ?>

    <!-- Search and Filter Section -->
    <div class="relative mb-6">
        <div class="flex flex-col w-full gap-6 mx-auto">
            <div class="flex flex-wrap items-center w-full gap-x-4 gap-y-2">
                <!-- Search Events (Wider) -->
                <div class="flex-1 min-w-[200px] max-w-xs">
                    <div class="relative">
                        <input type="text" id="searchInput"
                            class="w-full px-4 py-3 pr-12 text-sm transition-all duration-200 bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary"
                            placeholder="Search by event title...">
                    </div>
                </div>

                <!-- Event Type Filter -->
                <div class="relative flex-1 min-w-[140px] max-w-xs" x-data="{ open: false, selected: 'Event Type' }">
                    <button @click="open = !open" @click.away="open = false"
                        class="flex items-center justify-between w-full px-4 py-3 pr-12 text-sm text-gray-700 transition-all duration-200 bg-white border border-gray-300 rounded-lg shadow-sm appearance-none hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
                        <span x-text="selected"></span>
                        <svg class="w-4 h-4 ml-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="open" x-transition class="absolute left-0 z-50 w-full mt-2 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5" x-cloak>
                        <div class="py-1">
                            <button @click="selected = 'Event Type'; open = false; filterByEventType('')" class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">All Events</button>
                            <button @click="selected = 'Program'; open = false; filterByEventType('program')" class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Program</button>
                            <button @click="selected = 'Job Fair'; open = false; filterByEventType('jobfair')" class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Job Fair</button>
                            <button @click="selected = 'Local Recruitment'; open = false; filterByEventType('local recruitment')" class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Local Recruitment</button>
                        </div>
                    </div>
                </div>

                <!-- Status Filter (Show/Hide) -->
                <div class="relative flex-1 min-w-[120px] max-w-xs" x-data="{ open: false, selected: 'Status' }">
                    <button @click="open = !open" @click.away="open = false"
                        class="flex items-center justify-between w-full px-4 py-3 pr-12 text-sm text-gray-700 transition-all duration-200 bg-white border border-gray-300 rounded-lg shadow-sm appearance-none hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
                        <span x-text="selected"></span>
                        <svg class="w-4 h-4 ml-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="open" x-transition class="absolute left-0 z-50 w-full mt-2 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5" x-cloak>
                        <div class="py-1">
                            <button @click="selected = 'Status'; open = false; filterByStatus('')" class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">All Status</button>
                            <button @click="selected = 'Visible'; open = false; filterByStatus('show')" class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Visible (Show)</button>
                            <button @click="selected = 'Hidden'; open = false; filterByStatus('hide')" class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Hidden (Hide)</button>
                        </div>
                    </div>
                </div>

                <!-- Pin Status Filter -->
                <div class="relative flex-1 min-w-[120px] max-w-xs" x-data="{ open: false, selected: 'Pin Status' }">
                    <button @click="open = !open" @click.away="open = false"
                        class="flex items-center justify-between w-full px-4 py-3 pr-12 text-sm text-gray-700 transition-all duration-200 bg-white border border-gray-300 rounded-lg shadow-sm appearance-none hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
                        <span x-text="selected"></span>
                        <svg class="w-4 h-4 ml-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="open" x-transition class="absolute left-0 z-50 w-full mt-2 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5" x-cloak>
                        <div class="py-1">
                            <button @click="selected = 'Pin Status'; open = false; filterByPinStatus('')" class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">All Events</button>
                            <button @click="selected = 'Pinned'; open = false; filterByPinStatus('1')" class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Pinned Only</button>
                            <button @click="selected = 'Not Pinned'; open = false; filterByPinStatus('0')" class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Not Pinned</button>
                        </div>
                    </div>
                </div>

                <!-- Filter/Clear Buttons -->
                <div class="flex flex-shrink-0 gap-2 mt-2 lg:mt-0">
                    <button onclick="clearAllFilters()"
                        class="px-4 py-3 text-sm font-medium text-gray-600 transition-colors duration-200 bg-gray-100 border border-gray-300 rounded-sm hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        Clear
                    </button>
                    <button onclick="exportResults('csv')"
                        class="px-4 py-3 text-sm font-medium text-white transition-colors duration-200 border rounded-sm bg-primary border-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        Export
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Events Table Section -->
    <div>
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold text-gray-900">All Events</h2>
            <div class="flex items-center space-x-2">
                <span class="px-3 py-1 text-sm bg-blue-100 rounded-sm text-primary" id="visibleCount">
                    <?php echo count($events ?? []); ?> visible
                </span>
            </div>
        </div>

        <?php if (empty($events ?? [])): ?>
            <div class="p-8 text-center bg-white border border-gray-200 rounded-lg" id="noEventsMessage">
                <i class="mb-4 text-4xl text-gray-400 fas fa-calendar-alt"></i>
                <p class="text-gray-500">No events found</p>
            </div>
        <?php else: ?>
            <!-- Events Table -->
            <div class="overflow-hidden bg-white border border-gray-200 rounded-lg shadow-sm" id="eventsTable">
                <div class="overflow-x-auto">
                    <table class="w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Event</th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Type</th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Schedule</th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Status</th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Pin</th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200" id="eventsTableBody">
                            <?php foreach ($events as $event): ?>
                                <?php
                                // Calculate event time status
                                $now = new DateTime();
                                $start = new DateTime($event['time_start']);
                                $end = new DateTime($event['time_end']);

                                $timeStatus = 'upcoming';
                                if ($now >= $start && $now <= $end) {
                                    $timeStatus = 'ongoing';
                                } elseif ($now > $end) {
                                    $timeStatus = 'completed';
                                }
                                ?>
                                <tr class="event-row hover:bg-gray-50"
                                    data-title="<?php echo htmlspecialchars(strtolower($event['title'])); ?>"
                                    data-type="<?php echo htmlspecialchars($event['type']); ?>"
                                    data-status="<?php echo htmlspecialchars($event['status']); ?>"
                                    data-time-status="<?php echo htmlspecialchars($timeStatus); ?>"
                                    data-pin-status="<?php echo htmlspecialchars($event['pinned'] ?? '0'); ?>">

                                    <!-- Event Info -->
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <?php if (!empty($event['image'])): ?>
                                                <div class="flex-shrink-0 w-10 h-10">
                                                    <img class="object-cover w-10 h-10 rounded-full"
                                                        src="<?php echo htmlspecialchars($event['image']); ?>"
                                                        alt="Event image">
                                                </div>
                                                <div class="ml-4">
                                                <?php else: ?>
                                                    <div>
                                                    <?php endif; ?>
                                                    <div class="text-sm font-medium text-gray-900">
                                                        <?php echo htmlspecialchars($event['title']); ?>
                                                    </div>
                                                    <div class="text-sm text-gray-500 line-clamp-2">
                                                        <?php echo htmlspecialchars(substr($event['description'], 0, 100)) . (strlen($event['description']) > 100 ? '...' : ''); ?>
                                                    </div>
                                                    </div>
                                                </div>
                                    </td>

                                    <!-- Type -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                            <?php
                                            echo $event['type'] === 'program' ? 'bg-blue-100 text-blue-800' : ($event['type'] === 'jobfair' ? 'bg-green-100 text-green-800' : 'bg-purple-100 text-purple-800');
                                            ?>">
                                            <?php echo htmlspecialchars(ucwords(str_replace('_', ' ', $event['type']))); ?>
                                        </span>
                                    </td>

                                    <!-- Schedule -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            <?php echo date('M d, Y', strtotime($event['time_start'])); ?>
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            <?php echo date('g:i A', strtotime($event['time_start'])) . ' - ' . date('g:i A', strtotime($event['time_end'])); ?>
                                        </div>
                                        <div class="text-xs text-gray-400">
                                            <span class="inline-flex px-2 py-1 rounded-full 
                                                <?php
                                                echo $timeStatus === 'upcoming' ? 'bg-yellow-100 text-yellow-800' : ($timeStatus === 'ongoing' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800');
                                                ?>">
                                                <?php echo ucfirst($timeStatus); ?>
                                            </span>
                                        </div>
                                    </td>

                                    <!-- Status -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                            <?php echo $event['status'] === 'show' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
                                            <?php echo $event['status'] === 'show' ? 'Visible' : 'Hidden'; ?>
                                        </span>
                                    </td>

                                    <!-- Pin Status -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <?php if (($event['pinned'] ?? 0) == 1): ?>
                                            <span class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full text-amber-800 bg-amber-100">
                                                <i class="mr-1 fas fa-thumbtack"></i>
                                                Pinned
                                            </span>
                                        <?php else: ?>
                                            <span class="inline-flex px-2 py-1 text-xs text-gray-500 bg-gray-100 rounded-full">
                                                Not Pinned
                                            </span>
                                        <?php endif; ?>
                                    </td>

                                    <!-- Actions -->
                                    <td class="px-6 py-4 text-sm font-medium whitespace-nowrap">
                                        <div class="flex items-center space-x-2">
                                            <!-- Edit Button -->
                                            <a href="index.php?page=admin-event-edit&id=<?php echo $event['event_id']; ?>"
                                                class="text-blue-600 hover:text-blue-900" title="Edit Event">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <!-- Toggle Visibility -->
                                            <a href="index.php?page=admin-event-toggle-status&id=<?php echo $event['event_id']; ?>"
                                                class="text-yellow-600 hover:text-yellow-900"
                                                title="<?php echo $event['status'] === 'show' ? 'Hide Event' : 'Show Event'; ?>">
                                                <i class="fas fa-eye<?php echo $event['status'] === 'show' ? '-slash' : ''; ?>"></i>
                                            </a>

                                            <!-- Toggle Pin -->
                                            <button onclick="togglePin(<?php echo $event['event_id']; ?>, <?php echo ($event['pinned'] ?? 0) ? 'false' : 'true'; ?>)"
                                                class="text-amber-600 hover:text-amber-900"
                                                title="<?php echo ($event['pinned'] ?? 0) ? 'Unpin Event' : 'Pin Event'; ?>">
                                                <i class="fas fa-thumbtack<?php echo ($event['pinned'] ?? 0) ? '' : ' opacity-50'; ?>"></i>
                                            </button>

                                            <!-- Delete Button -->
                                            <button onclick="confirmDelete(<?php echo $event['event_id']; ?>)"
                                                class="text-red-600 hover:text-red-900" title="Delete Event">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- No Results Message (hidden by default) -->
            <div class="hidden p-8 text-center bg-white border border-gray-200 rounded-lg" id="noResultsMessage">
                <i class="mb-4 text-4xl text-gray-400 fas fa-search"></i>
                <p class="text-gray-500">No events match your current filters</p>
                <button onclick="clearAllFilters()" class="mt-2 text-blue-600 hover:text-blue-900">Clear filters</button>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    // Fixed JavaScript with proper data attributes
    let allRows = [];
    let filteredRows = [];
    let currentFilters = {
        type: '',
        status: '',
        timeStatus: '',
        pinStatus: ''
    };

    function confirmDelete(eventId) {
        if (confirm('Are you sure you want to delete this event?')) {
            window.location.href = `index.php?page=admin-event-delete&id=${eventId}`;
        }
    }

    function togglePin(eventId, pinStatus) {
        if (confirm(`Are you sure you want to ${pinStatus ? 'pin' : 'unpin'} this event?`)) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = 'index.php?page=admin-event-toggle-pin';

            const eventIdInput = document.createElement('input');
            eventIdInput.type = 'hidden';
            eventIdInput.name = 'event_id';
            eventIdInput.value = eventId;

            const pinStatusInput = document.createElement('input');
            pinStatusInput.type = 'hidden';
            pinStatusInput.name = 'pinned';
            pinStatusInput.value = pinStatus ? '1' : '0';

            form.appendChild(eventIdInput);
            form.appendChild(pinStatusInput);
            document.body.appendChild(form);
            form.submit();
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const eventRows = document.querySelectorAll('.event-row');
        allRows = Array.from(eventRows);
        filteredRows = [...allRows];
        updateCounts();
    });

    // Filter functions matching the corrected data attributes
    function filterByEventType(type) {
        currentFilters.type = type;
        applyFilters();
    }

    function filterByStatus(status) {
        currentFilters.status = status;
        applyFilters();
    }

    function filterByTimeStatus(timeStatus) {
        currentFilters.timeStatus = timeStatus;
        applyFilters();
    }

    function filterByPinStatus(pinStatus) {
        currentFilters.pinStatus = pinStatus;
        applyFilters();
    }

    function applyFilters() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase().trim();

        filteredRows = allRows.filter(row => {
            const title = row.getAttribute('data-title') || '';
            const type = row.getAttribute('data-type') || '';
            const status = row.getAttribute('data-status') || '';
            const timeStatus = row.getAttribute('data-time-status') || '';
            const pinStatus = row.getAttribute('data-pin-status') || '';

            const matchesSearch = searchTerm === '' || title.includes(searchTerm);
            const matchesType = currentFilters.type === '' || type === currentFilters.type;
            const matchesStatus = currentFilters.status === '' || status === currentFilters.status;
            const matchesTimeStatus = currentFilters.timeStatus === '' || timeStatus === currentFilters.timeStatus;
            const matchesPinStatus = currentFilters.pinStatus === '' || pinStatus === currentFilters.pinStatus;

            return matchesSearch && matchesType && matchesStatus && matchesTimeStatus && matchesPinStatus;
        });

        updateDisplay();
        updateCounts();
        updateResultsMessage();
    }

    function updateDisplay() {
        // Hide all rows first
        allRows.forEach(row => {
            row.style.display = 'none';
        });

        // Show filtered rows
        filteredRows.forEach(row => {
            row.style.display = '';
        });
    }

    function updateCounts() {
        const visibleCount = filteredRows.length;
        document.getElementById('visibleCount').textContent = `${visibleCount} visible`;
    }

    function updateResultsMessage() {
        const noResultsMessage = document.getElementById('noResultsMessage');
        const eventsTable = document.getElementById('eventsTable');

        if (filteredRows.length === 0 && allRows.length > 0) {
            noResultsMessage.classList.remove('hidden');
            eventsTable.classList.add('hidden');
        } else {
            noResultsMessage.classList.add('hidden');
            eventsTable.classList.remove('hidden');
        }
    }

    function clearAllFilters() {
        // Clear search input
        document.getElementById('searchInput').value = '';

        // Reset current filters
        currentFilters.type = '';
        currentFilters.status = '';
        currentFilters.timeStatus = '';
        currentFilters.pinStatus = '';

        applyFilters();

        // Reset Alpine.js dropdowns (if available)
        setTimeout(() => {
            const dropdowns = document.querySelectorAll('[x-data]');
            dropdowns.forEach(dropdown => {
                if (dropdown._x_dataStack && dropdown._x_dataStack[0].selected) {
                    const originalSelected = dropdown._x_dataStack[0].selected;
                    if (originalSelected.includes('Type')) dropdown._x_dataStack[0].selected = 'Event Type';
                    if (originalSelected.includes('Status') && !originalSelected.includes('Pin')) dropdown._x_dataStack[0].selected = 'Status';
                    if (originalSelected.includes('Pin')) dropdown._x_dataStack[0].selected = 'Pin Status';
                }
            });
        }, 100);
    }

    // Export functionality
    function exportResults(format) {
        const visibleData = filteredRows.map(row => {
            const cells = row.querySelectorAll('td');
            return {
                title: row.getAttribute('data-title'),
                type: row.getAttribute('data-type'),
                status: row.getAttribute('data-status'),
                timeStatus: row.getAttribute('data-time-status'),
                pinStatus: row.getAttribute('data-pin-status') === '1' ? 'Pinned' : 'Not Pinned'
            };
        });

        if (format === 'csv') {
            exportToCSV(visibleData);
        }
    }

    function exportToCSV(data) {
        const headers = ['Title', 'Type', 'Status', 'Time Status', 'Pin Status'];
        const csvContent = [
            headers.join(','),
            ...data.map(row => [
                `"${row.title}"`,
                `"${row.type}"`,
                `"${row.status}"`,
                `"${row.timeStatus}"`,
                `"${row.pinStatus}"`
            ].join(','))
        ].join('\n');

        const blob = new Blob([csvContent], {
            type: 'text/csv'
        });
        const url = window.URL.createObjectURL(blob);
        const link = document.createElement('a');
        link.href = url;
        link.download = `events_${new Date().toISOString().split('T')[0]}.csv`;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        window.URL.revokeObjectURL(url);
    }

    // Event listeners
    document.getElementById('searchInput').addEventListener('input', applyFilters);

    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
            e.preventDefault();
            document.getElementById('searchInput').focus();
        }

        if (e.key === 'Escape') {
            clearAllFilters();
        }
    });
</script>