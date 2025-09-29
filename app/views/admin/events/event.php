<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">Events & Programs</h1>
            <p class="mt-1 text-sm text-gray-600">Manage all events and programs</p>
        </div>
        <div>
            <a href="index.php?page=admin-event-create"
                class="inline-flex items-center px-4 py-3 text-sm font-medium text-white transition-colors duration-200 border rounded-lg bg-primary border-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
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
        <div class="p-4 mb-6 text-sm bg-gray-100 rounded-lg text-primary">
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
            <div class="flex flex-wrap items-stretch w-full gap-3">
                <!-- Search Events (Wider) -->
                <div class="flex-1 min-w-[200px] max-w-xs">
                    <div class="relative">
                        <input type="text" id="searchInput"
                            class="w-full px-4 py-3 pr-10 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-secondary focus:border-secondary"
                            placeholder="Search by event title...">

                        <svg class="absolute w-4 h-4 text-gray-400 transform -translate-y-1/2 pointer-events-none right-3 top-1/2"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m21 21-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>
                <!-- Event Type Filter -->
                <div class="relative flex-1 min-w-[140px] max-w-xs" x-data="{ open: false, selected: 'Event Type' }">
                    <button @click="open = !open" @click.away="open = false"
                        class="flex items-center justify-between w-full px-4 py-3 text-sm text-gray-700 transition-all duration-200 bg-white border border-gray-300 rounded-lg shadow-sm hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
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
                        class="flex items-center justify-between w-full px-4 py-3 text-sm text-gray-700 transition-all duration-200 bg-white border border-gray-300 rounded-lg shadow-sm hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
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
                        class="flex items-center justify-between w-full px-4 py-3 text-sm text-gray-700 transition-all duration-200 bg-white border border-gray-300 rounded-lg shadow-sm hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
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
                <div class="flex flex-shrink-0 gap-2">
                    <button onclick="clearAllFilters()"
                        class="px-4 py-3 text-sm font-medium text-gray-600 transition-colors duration-200 bg-gray-100 border border-gray-300 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        Clear
                    </button>
                    <button onclick="exportResults('csv')"
                        class="px-4 py-3 text-sm font-medium text-white transition-colors duration-200 border rounded-md bg-primary border-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        Export
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Events Table Section -->
    <div>

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
                                                    <img class="object-cover w-12 h-12 rounded-full"
                                                        src="<?php echo htmlspecialchars($event['image']); ?>"
                                                        alt="Event image">
                                                </div>
                                                <div class="ml-4">
                                                <?php else: ?>
                                                    <div>
                                                    <?php endif; ?>
                                                    <div class="text-sm font-medium text-gray-900 line-clamp-2">
                                                        <?php echo htmlspecialchars($event['title']); ?>
                                                    </div>
                                                    <div class="text-xs text-gray-500 line-clamp-2">
                                                        <?php echo htmlspecialchars(substr($event['description'], 0, 100)) . (strlen($event['description']) > 100 ? '...' : ''); ?>
                                                    </div>
                                                    </div>
                                                </div>
                                    </td>

                                    <!-- Type -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 py-1 text-xs font-medium rounded-md 
                                            <?php
                                            echo $event['type'] === 'program' ? 'bg-gray-100 text-primary' : ($event['type'] === 'jobfair' ? 'bg-gray-100 text-primary' : 'bg-gray-100 text-primary');
                                            ?>">
                                            <?php echo htmlspecialchars(ucwords(str_replace('_', ' ', $event['type']))); ?>
                                        </span>
                                    </td>

                                    <!-- Schedule -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            <?php echo date('M d, Y', strtotime($event['time_start'])); ?>
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            <?php echo date('g:i A', strtotime($event['time_start'])) . ' - ' . date('g:i A', strtotime($event['time_end'])); ?>
                                        </div>

                                    </td>

                                    <!-- Status -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 py-1 text-xs font-medium rounded-md 
                                            <?php echo $event['status'] === 'show' ? 'bg-gray-100 text-primary' : 'bg-red-100 text-red-800'; ?>">
                                            <?php echo $event['status'] === 'show' ? 'Visible' : 'Hidden'; ?>
                                        </span>
                                    </td>

                                    <!-- Pin Status -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <?php if (($event['pinned'] ?? 0) == 1): ?>
                                            <span class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-md text-primary bg-amber-100">
                                                </i>
                                                Pinned
                                            </span>
                                        <?php else: ?>
                                            <span class="inline-flex px-2 py-1 text-xs text-gray-500 bg-gray-100 rounded-md">
                                                Not Pinned
                                            </span>
                                        <?php endif; ?>
                                    </td>

                                    <!-- Actions -->
                                    <td class="px-6 py-4 text-sm font-medium whitespace-nowrap">
                                        <div class="flex items-center justify-end">
                                            <!-- Actions Dropdown -->
                                            <div class="relative" x-data="{ open: false }" x-init="$refs.button" @click.away="open = false">

                                                <!-- Dropdown Trigger Button -->
                                                <button @click="open = !open"
                                                    x-ref="button"
                                                    class="inline-flex items-center px-3 py-2 text-xs font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary"
                                                    :class="{ 'bg-gray-100': open }"
                                                    type="button">
                                                    <span>Actions</span>
                                                    <svg class="w-4 h-4 ml-1 transition-transform duration-200 transform" :class="{ 'rotate-180': open }"
                                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                    </svg>
                                                </button>

                                                <!-- Dropdown Menu -->
                                                <div x-show="open"
                                                    x-transition:enter="transition ease-out duration-100"
                                                    x-transition:enter-start="transform opacity-0 scale-95"
                                                    x-transition:enter-end="transform opacity-100 scale-100"
                                                    x-transition:leave="transition ease-in duration-75"
                                                    x-transition:leave-start="transform opacity-100 scale-100"
                                                    x-transition:leave-end="transform opacity-0 scale-95"
                                                    class="absolute right-0 z-50 w-48 mt-2 origin-top-right bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                                                    style="top: 100%; min-width: 180px;"
                                                    @keydown.escape.prevent.stop="open = false">

                                                    <div class="py-1" role="menu" aria-orientation="vertical">
                                                        <!-- Edit Event -->
                                                        <a href="index.php?page=admin-event-edit&id=<?php echo $event['event_id']; ?>"
                                                            class="flex items-center w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                                                            role="menuitem">
                                                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                            </svg>
                                                            Edit Event
                                                        </a>

                                                        <hr class="my-1">

                                                        <!-- Toggle Visibility -->
                                                        <a href="index.php?page=admin-event-toggle-status&id=<?php echo $event['event_id']; ?>"
                                                            class="flex items-center w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100"
                                                            role="menuitem">
                                                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <?php if ($event['status'] === 'show'): ?>
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                                                                <?php else: ?>
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                                <?php endif; ?>
                                                            </svg>
                                                            <?php echo $event['status'] === 'show' ? 'Hide Event' : 'Show Event'; ?>
                                                        </a>

                                                        <!-- Toggle Pin -->
                                                        <button type="button"
                                                            onclick="togglePin(<?php echo $event['event_id']; ?>, <?php echo ($event['pinned'] ?? 0) ? 'false' : 'true'; ?>); this.closest('[x-data]').__x.$data.open = false;"
                                                            class="flex items-center w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100"
                                                            role="menuitem">
                                                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                                                            </svg>
                                                            <?php echo ($event['pinned'] ?? 0) ? 'Unpin Event' : 'Pin Event'; ?>
                                                        </button>

                                                        <hr class="my-1">

                                                        <!-- Delete Event -->
                                                        <button type="button"
                                                            onclick="confirmDelete(<?php echo $event['event_id']; ?>); this.closest('[x-data]').__x.$data.open = false;"
                                                            class="flex items-center w-full px-4 py-2 text-sm text-left text-red-600 hover:bg-red-50"
                                                            role="menuitem">
                                                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                            </svg>
                                                            Delete Event
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="flex items-center justify-between px-6 py-3 border-t border-gray-200 bg-gray-50">
                    <div class="flex items-center gap-1 text-sm text-gray-700">
                        <span>Showing</span>
                        <span class="mx-1 font-medium" id="startItem">1</span>
                        <span>to</span>
                        <span class="mx-1 font-medium" id="endItem">10</span>
                        <span>of</span>
                        <span class="mx-1 font-medium" id="totalItems">0</span>
                        <span>results</span>
                    </div>
                    <div class="flex space-x-2">
                        <button id="prevBtn" onclick="previousPage()"
                            class="px-3 py-1 text-sm bg-white border border-gray-300 rounded hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
                            <i class="mr-1 fas fa-chevron-left"></i> Previous
                        </button>
                        <div id="pageNumbers" class="flex space-x-1"></div>
                        <button id="nextBtn" onclick="nextPage()"
                            class="px-3 py-1 text-sm text-white border border-gray-300 rounded bg-primary hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
                            Next <i class="ml-1 fas fa-chevron-right"></i>
                        </button>
                    </div>
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
    // Fixed JavaScript with proper data attributes and pagination
    let allRows = [];
    let filteredRows = [];
    let currentFilters = {
        type: '',
        status: '',
        timeStatus: '',
        pinStatus: ''
    };

    // Pagination variables
    let currentPage = 1;
    const itemsPerPage = 10;
    let totalPages = 1;

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
        initializePagination();
    });

    // Pagination Functions
    function initializePagination() {
        updatePagination();
    }

    function updatePagination() {
        totalPages = Math.ceil(filteredRows.length / itemsPerPage);

        // Hide all rows first
        allRows.forEach(row => {
            row.style.display = 'none';
        });

        // If no filtered results, don't show any rows
        if (filteredRows.length === 0) {
            updatePaginationInfo();
            updatePaginationControls(0);
            return;
        }

        const startIndex = (currentPage - 1) * itemsPerPage;
        const endIndex = Math.min(startIndex + itemsPerPage, filteredRows.length);

        for (let i = startIndex; i < endIndex; i++) {
            if (filteredRows[i]) {
                filteredRows[i].style.display = '';
            }
        }

        updatePaginationInfo();
        updatePaginationControls(totalPages);
    }

    function updatePaginationInfo() {
        const totalItemsEl = document.getElementById('totalItems');
        const startItemEl = document.getElementById('startItem');
        const endItemEl = document.getElementById('endItem');

        if (filteredRows.length === 0) {
            if (totalItemsEl) totalItemsEl.textContent = '0';
            if (startItemEl) startItemEl.textContent = '0';
            if (endItemEl) endItemEl.textContent = '0';
            return;
        }

        const startIndex = (currentPage - 1) * itemsPerPage + 1;
        const endIndex = Math.min(currentPage * itemsPerPage, filteredRows.length);

        if (totalItemsEl) totalItemsEl.textContent = filteredRows.length;
        if (startItemEl) startItemEl.textContent = filteredRows.length > 0 ? startIndex : 0;
        if (endItemEl) endItemEl.textContent = endIndex;
    }

    function updatePaginationControls(totalPages) {
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        const pageNumbers = document.getElementById('pageNumbers');

        // Update Previous/Next button states
        if (prevBtn) prevBtn.disabled = currentPage === 1;
        if (nextBtn) nextBtn.disabled = currentPage === totalPages || totalPages === 0;

        // Clear existing page numbers
        if (pageNumbers) pageNumbers.innerHTML = '';

        if (totalPages <= 1) return;

        // Add page number buttons
        const maxVisiblePages = 5;
        let startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
        let endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);

        // Adjust startPage if we're near the end
        if (endPage - startPage + 1 < maxVisiblePages) {
            startPage = Math.max(1, endPage - maxVisiblePages + 1);
        }

        // Add visible page numbers
        for (let i = startPage; i <= endPage; i++) {
            const button = document.createElement('button');
            button.textContent = i;
            button.onclick = () => goToPage(i);

            if (i === currentPage) {
                button.className = 'px-3 py-1 text-sm text-white border rounded bg-primary border-primary';
            } else {
                button.className = 'px-3 py-1 text-sm bg-white border border-gray-300 rounded hover:bg-gray-50';
            }

            pageNumbers.appendChild(button);
        }
    }

    // Navigation functions
    function previousPage() {
        if (currentPage > 1) {
            currentPage--;
            updatePagination();
        }
    }

    function nextPage() {
        if (currentPage < totalPages) {
            currentPage++;
            updatePagination();
        }
    }

    function goToPage(page) {
        currentPage = page;
        updatePagination();
    }

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

        // Reset to first page when filters change
        currentPage = 1;
        updatePagination();
        updateCounts();
        updateResultsMessage();
    }

    function updateCounts() {
        const totalItemsEl = document.getElementById('totalItems');
        if (totalItemsEl) {
            totalItemsEl.textContent = filteredRows.length;
        }
    }

    function updateResultsMessage() {
        const noResultsMessage = document.getElementById('noResultsMessage');
        const eventsTable = document.getElementById('eventsTable');

        if (filteredRows.length === 0 && allRows.length > 0) {
            if (noResultsMessage) noResultsMessage.classList.remove('hidden');
            if (eventsTable) eventsTable.classList.add('hidden');
        } else {
            if (noResultsMessage) noResultsMessage.classList.add('hidden');
            if (eventsTable) eventsTable.classList.remove('hidden');
        }
    }

    function clearAllFilters() {
        // Clear search input
        const searchInput = document.getElementById('searchInput');
        if (searchInput) searchInput.value = '';

        // Reset current filters
        currentFilters.type = '';
        currentFilters.status = '';
        currentFilters.timeStatus = '';
        currentFilters.pinStatus = '';

        // Reset to first page
        currentPage = 1;

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
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', applyFilters);
    }

    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
            e.preventDefault();
            const searchInput = document.getElementById('searchInput');
            if (searchInput) searchInput.focus();
        }

        if (e.key === 'Escape') {
            clearAllFilters();
        }
    });
</script>