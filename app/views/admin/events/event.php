<?php
include_once __DIR__ . '/../components/admin_auth_check.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>SIKAP Admin - Events & Programs</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#092C4C',
                        secondary: '#F3AF0E'
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        html,
        body {
            height: 100%;
            overflow: hidden;
        }

        .main-content {
            height: calc(100vh - 4rem);
            overflow-y: auto;
        }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Topbar (Sticky) -->
    <?php include __DIR__ . '/../components/topbar.php'; ?>

    <div class="flex h-screen">
        <!-- Sidebar (Fixed/Sticky) -->
        <?php include __DIR__ . '/../components/sidebar.php'; ?>

        <!-- Main Content Area (Scrollable) -->
        <div class="flex-1 lg:ml-80 main-content">
            <div class="p-6">
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
                                <span class="text-2xl font-bold text-gray-900 sm:text-3xl" id="totalCount"><?php echo count($events); ?></span>
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
                                    echo count(array_filter($events, function ($event) use ($now) {
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
                                    echo count(array_filter($events, function ($event) use ($now) {
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
                                    echo count(array_filter($events, function ($event) use ($now) {
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
                <div class="relative  mb-6">
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
                                <button @click="open = !open"
                                    @click.away="open = false"
                                    class="flex items-center justify-between w-full px-4 py-3 pr-12 text-sm text-gray-700 transition-all duration-200 bg-white border border-gray-300 rounded-lg shadow-sm appearance-none hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
                                    <span x-text="selected"></span>
                                    <svg class="w-4 h-4 ml-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                                    class="absolute left-0 z-50 w-full mt-2 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5"
                                    x-cloak>
                                    <div class="py-1">
                                        <button @click="selected = 'Event Type'; open = false; filterByEventType('')"
                                            class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            All Events
                                        </button>
                                        <button @click="selected = 'Program'; open = false; filterByEventType('program')"
                                            class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            Program
                                        </button>
                                        <button @click="selected = 'Job Fair'; open = false; filterByEventType('jobfair')"
                                            class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            Job Fair
                                        </button>
                                        <button @click="selected = 'Local Recruitment'; open = false; filterByEventType('local recruitment')"
                                            class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            Local Recruitment
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Event Status Filter -->
                            <div class="relative flex-1 min-w-[120px] max-w-xs" x-data="{ open: false, selected: 'Event Status' }">
                                <button @click="open = !open"
                                    @click.away="open = false"
                                    class="flex items-center justify-between w-full px-4 py-3 pr-12 text-sm text-gray-700 transition-all duration-200 bg-white border border-gray-300 rounded-lg shadow-sm appearance-none hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
                                    <span x-text="selected"></span>
                                    <svg class="w-4 h-4 ml-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                                    class="absolute left-0 z-50 w-full mt-2 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5"
                                    x-cloak>
                                    <div class="py-1">
                                        <button @click="selected = 'Event Status'; open = false; filterByEventStatus('')"
                                            class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            All Events
                                        </button>
                                        <button @click="selected = 'Upcoming'; open = false; filterByEventStatus('upcoming')"
                                            class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            Upcoming
                                        </button>
                                        <button @click="selected = 'Ongoing'; open = false; filterByEventStatus('ongoing')"
                                            class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            Ongoing
                                        </button>
                                        <button @click="selected = 'Completed'; open = false; filterByEventStatus('completed')"
                                            class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            Completed
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Pin Status Filter -->
                            <div class="relative flex-1 min-w-[120px] max-w-xs" x-data="{ open: false, selected: 'Pin Status' }">
                                <button @click="open = !open"
                                    @click.away="open = false"
                                    class="flex items-center justify-between w-full px-4 py-3 pr-12 text-sm text-gray-700 transition-all duration-200 bg-white border border-gray-300 rounded-lg shadow-sm appearance-none hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
                                    <span x-text="selected"></span>
                                    <svg class="w-4 h-4 ml-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                                    class="absolute left-0 z-50 w-full mt-2 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5"
                                    x-cloak>
                                    <div class="py-1">
                                        <button @click="selected = 'Pin Status'; open = false; filterByPinStatus('')"
                                            class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            All Events
                                        </button>
                                        <button @click="selected = 'Pinned'; open = false; filterByPinStatus('1')"
                                            class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            Pinned Only
                                        </button>
                                        <button @click="selected = 'Not Pinned'; open = false; filterByPinStatus('0')"
                                            class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            Not Pinned
                                        </button>
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

                <!-- All Events -->
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-900">All Events</h2>
                        <div class="flex items-center space-x-2">
                            <span class="px-3 py-1 text-sm bg-blue-100 rounded-sm text-primary" id="visibleCount">
                                <?php echo count($events); ?> visible
                            </span>
                        </div>
                    </div>

                    <?php if (empty($events)): ?>
                        <div class="p-8 text-center bg-white border border-gray-200 rounded-lg" id="noEventsMessage">
                            <i class="mb-4 text-4xl text-gray-400 fas fa-calendar-alt"></i>
                            <p class="text-gray-500">No events found</p>
                        </div>
                    <?php else: ?>
                        <!-- No Results Message (Hidden by default) -->
                        <div class="hidden p-8 text-center bg-white border border-gray-200 rounded-lg" id="noResultsMessage">
                            <i class="mb-4 text-4xl text-gray-400 fas fa-search"></i>
                            <p class="text-gray-500">No events match your search criteria</p>
                        </div>

                        <div class="overflow-hidden bg-white border border-gray-200 rounded-lg shadow-sm" id="eventsTable">
                            <table class="w-full divide-y divide-gray-200 table-auto">
                                <!-- Table Head -->
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                            Event
                                        </th>
                                        <th id="sortDateHeader" class="px-3 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase cursor-pointer">
                                            Date & Time
                                            <i id="sortIcon" class="ml-1 fas fa-sort"></i>
                                        </th>
                                        <th class="px-3 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                            Event Status
                                        </th>
                                        <th class="px-3 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                            Admin Status
                                        </th>
                                        <th class="px-3 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
                                            Pin Status
                                        </th>
                                        <th class="px-3 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200" id="eventsTableBody">
                                    <?php foreach ($events as $event): ?>
                                        <?php
                                        $now = new DateTime();
                                        $start = new DateTime($event['time_start']);
                                        $end = new DateTime($event['time_end']);
                                        if ($now < $start) {
                                            $eventStatus = 'upcoming';
                                        } elseif ($now >= $start && $now <= $end) {
                                            $eventStatus = 'ongoing';
                                        } else {
                                            $eventStatus = 'completed';
                                        }
                                        ?>
                                        <tr class="event-row hover:bg-gray-50"
                                            data-type="<?php echo strtolower(trim($event['type'])); ?>"
                                            data-title="<?php echo htmlspecialchars(strtolower($event['title'])); ?>"
                                            data-admin-status="<?php echo htmlspecialchars($event['status']); ?>"
                                            data-event-status="<?php echo $eventStatus; ?>"
                                            data-pin-status="<?php echo isset($event['pinned']) && $event['pinned'] == 1 ? '1' : '0'; ?>"
                                            data-date="<?php echo date('Y-m-d H:i:s', strtotime($event['time_start'])); ?>">

                                            <!-- Event Column - Adapted from jobseeker management -->
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 w-10 h-10">
                                                        <?php if (!empty($event['image'])): ?>
                                                            <img class="object-cover w-10 h-10 rounded-full"
                                                                src="<?php echo htmlspecialchars($event['image']); ?>"
                                                                alt="">
                                                        <?php else: ?>
                                                            <div class="flex items-center justify-center w-10 h-10 bg-gray-300 rounded-full">
                                                                <i class="text-gray-500 fas fa-calendar-alt"></i>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900 event-title" title="<?php echo htmlspecialchars($event['title']); ?>">
                                                            <?php
                                                            $title = htmlspecialchars($event['title']);
                                                            // Truncate title if longer than 40 characters
                                                            if (strlen($title) > 40) {
                                                                echo substr($title, 0, 40) . '...';
                                                            } else {
                                                                echo $title;
                                                            }
                                                            ?>
                                                        </div>
                                                        <div class="text-sm text-gray-500">
                                                            <?php echo ucfirst(htmlspecialchars($event['type'] ?? 'Event')); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="px-6 py-4 event-date">
                                                <div class="text-sm text-gray-900">
                                                    <?php echo date('F j, Y', strtotime($event['time_start'])); ?>
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    <?php
                                                    echo date('g:i A', strtotime($event['time_start'])) . ' - ' .
                                                        date('g:i A', strtotime($event['time_end']));
                                                    ?>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <?php
                                                $now = new DateTime();
                                                $start = new DateTime($event['time_start']);
                                                $end = new DateTime($event['time_end']);
                                                if ($now < $start) {
                                                    $status = 'upcoming';
                                                    $statusClass = 'text-yellow-800 bg-yellow-100';
                                                    $statusText = 'Upcoming';
                                                } elseif ($now >= $start && $now <= $end) {
                                                    $status = 'ongoing';
                                                    $statusClass = 'text-green-800 bg-green-100';
                                                    $statusText = 'Ongoing';
                                                } else {
                                                    $status = 'completed';
                                                    $statusClass = 'text-gray-800 bg-gray-100';
                                                    $statusText = 'Completed';
                                                }
                                                ?>
                                                <span class="inline-flex px-2 text-xs font-semibold leading-5 <?php echo $statusClass; ?> event-status">
                                                    <?php echo $statusText; ?>
                                                </span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <?php
                                                $adminStatus = $event['status'];
                                                if ($adminStatus === 'show') {
                                                    $adminStatusClass = 'text-green-800 bg-green-100';
                                                    $adminStatusText = 'Visible';
                                                } elseif ($adminStatus === 'hide') {
                                                    $adminStatusClass = 'text-red-800 bg-red-100';
                                                    $adminStatusText = 'Hidden';
                                                } else { // draft
                                                    $adminStatusClass = 'text-orange-800 bg-orange-100';
                                                    $adminStatusText = 'Draft';
                                                }
                                                ?>
                                                <span class="inline-flex px-2 text-xs font-semibold leading-5 <?php echo $adminStatusClass; ?>  admin-status">
                                                    <?php echo $adminStatusText; ?>
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <?php
                                                // Check if event is pinned (you'll need to modify your controller to include this data)
                                                $isPinned = isset($event['pinned']) && $event['pinned'] == 1;
                                                ?>
                                                <?php if ($isPinned): ?>
                                                    <span class="inline-flex px-2 text-xs font-semibold leading-5 text-yellow-800 bg-yellow-100 ">
                                                        Pinned
                                                    </span>
                                                <?php else: ?>
                                                    <span class="inline-flex px-2 text-xs font-semibold leading-5 text-gray-600 bg-gray-100 ">
                                                        Not Pinned
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <?php
                                                $isPinned = isset($event['pinned']) && $event['pinned'] == 1;
                                                ?>
                                                <button onclick="togglePin(<?php echo $event['event_id']; ?>, <?php echo $isPinned ? 'false' : 'true'; ?>)"
                                                    class="mr-2 <?php echo $isPinned ? 'text-yellow-600 hover:text-yellow-900' : 'text-gray-400 hover:text-yellow-600'; ?>"
                                                    title="<?php echo $isPinned ? 'Unpin Event' : 'Pin Event'; ?>">
                                                    <i class="fas fa-thumbtack"></i>
                                                </button>
                                                <a href="index.php?page=admin-event-edit&id=<?php echo $event['event_id']; ?>"
                                                    class="mr-2 text-indigo-600 hover:text-indigo-900" title="Edit Event">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button onclick="confirmDelete(<?php echo $event['event_id']; ?>)"
                                                    class="text-red-600 hover:text-red-900" title="Delete Event">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="px-6 py-4 border-t border-gray-200" id="paginationContainer">
                            <div class="flex items-center justify-between">
                                <!-- Left side: Results info -->
                                <div class="text-sm text-gray-700" id="paginationInfo">
                                    Showing <span id="showingStart">1</span> to <span id="showingEnd">10</span> of <span id="totalResults"><?php echo count($events); ?></span> events
                                </div>

                                <!-- Right side: Pagination controls -->
                                <nav class="flex space-x-1" aria-label="Pagination" id="paginationControls">
                                    <!-- Previous button -->
                                    <button id="prevBtn" onclick="changePage('prev')"
                                        class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-l-md hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
                                        Previous
                                    </button>

                                    <!-- Page numbers will be inserted here by JavaScript -->
                                    <div id="pageNumbers" class="flex space-x-1"></div>

                                    <!-- Next button -->
                                    <button id="nextBtn" onclick="changePage('next')"
                                        class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-md hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
                                        Next
                                    </button>
                                </nav>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Keep all your existing JavaScript -->
    <script>
        let allRows = [];
        let filteredRows = [];
        let currentFilters = {
            type: '',
            adminStatus: '',
            eventStatus: '',
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
                // Create a form to submit the pin action
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = 'index.php?page=admin-event-pin';

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
            const searchInput = document.getElementById('searchInput');
            const eventRows = document.querySelectorAll('.event-row');
            const visibleCount = document.getElementById('visibleCount');
            const noResultsMessage = document.getElementById('noResultsMessage');
            const eventsTable = document.getElementById('eventsTable');

            allRows = Array.from(eventRows);
            filteredRows = [...allRows];

            // Initialize pagination
            initializePagination();

            // Apply initial filter
            filterEvents();
        });

        // New Alpine.js dropdown filter functions
        function filterByEventType(type) {
            currentFilters.type = type;
            applyFilters();
        }

        function filterByAdminStatus(status) {
            currentFilters.adminStatus = status;
            applyFilters();
        }

        function filterByEventStatus(status) {
            currentFilters.eventStatus = status;
            applyFilters();
        }

        function filterByPinStatus(status) {
            currentFilters.pinStatus = status;
            applyFilters();
        }

        function applyFilters() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase().trim();

            filteredRows = allRows.filter(row => {
                const title = row.getAttribute('data-title');
                const type = row.getAttribute('data-type');
                const adminStatus = row.getAttribute('data-admin-status');
                const eventStatus = row.getAttribute('data-event-status');
                const pinStatus = row.getAttribute('data-pin-status');

                const matchesSearch = searchTerm === '' || title.includes(searchTerm);
                const matchesType = currentFilters.type === '' || type === currentFilters.type;
                const matchesAdminStatus = currentFilters.adminStatus === '' || adminStatus === currentFilters.adminStatus;
                const matchesEventStatus = currentFilters.eventStatus === '' || eventStatus === currentFilters.eventStatus;
                const matchesPinStatus = currentFilters.pinStatus === '' || pinStatus === currentFilters.pinStatus;

                return matchesSearch && matchesType && matchesAdminStatus && matchesEventStatus && matchesPinStatus;
            });

            // Reset to first page when filters change
            currentPage = 1;
            updatePagination();
            updateCounts();
            updateResultsMessage();
        }

        function filterEvents() {
            applyFilters();
        }

        function updateCounts() {
            const visibleCount = filteredRows.length;
            document.getElementById('visibleCount').textContent = `${visibleCount} visible`;
            document.getElementById('totalResults').textContent = visibleCount;
        }

        // Pagination Functions
        function initializePagination() {
            updatePagination();
        }

        function updatePagination() {
            totalPages = Math.ceil(filteredRows.length / itemsPerPage);

            // Hide/show pagination container based on whether pagination is needed
            const paginationContainer = document.getElementById('paginationContainer');
            if (filteredRows.length <= itemsPerPage) {
                paginationContainer.style.display = 'none';
            } else {
                paginationContainer.style.display = 'block';
            }

            // Show/hide rows based on current page
            allRows.forEach(row => {
                row.style.display = 'none';
            });

            const startIndex = (currentPage - 1) * itemsPerPage;
            const endIndex = Math.min(startIndex + itemsPerPage, filteredRows.length);

            for (let i = startIndex; i < endIndex; i++) {
                if (filteredRows[i]) {
                    filteredRows[i].style.display = '';
                }
            }

            updatePaginationInfo();
            updatePaginationControls();
        }

        function updatePaginationInfo() {
            const startIndex = (currentPage - 1) * itemsPerPage + 1;
            const endIndex = Math.min(currentPage * itemsPerPage, filteredRows.length);

            document.getElementById('showingStart').textContent = filteredRows.length > 0 ? startIndex : 0;
            document.getElementById('showingEnd').textContent = endIndex;
        }

        function updatePaginationControls() {
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
            const pageNumbers = document.getElementById('pageNumbers');

            // Update Previous/Next button states
            prevBtn.disabled = currentPage === 1;
            nextBtn.disabled = currentPage === totalPages || totalPages === 0;

            // Clear existing page numbers
            pageNumbers.innerHTML = '';

            // Add page number buttons
            const maxVisiblePages = 5;
            let startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
            let endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);

            // Adjust startPage if we're near the end
            if (endPage - startPage + 1 < maxVisiblePages) {
                startPage = Math.max(1, endPage - maxVisiblePages + 1);
            }

            // Add first page and ellipsis if needed
            if (startPage > 1) {
                pageNumbers.appendChild(createPageButton(1));
                if (startPage > 2) {
                    pageNumbers.appendChild(createEllipsis());
                }
            }

            // Add visible page numbers
            for (let i = startPage; i <= endPage; i++) {
                pageNumbers.appendChild(createPageButton(i));
            }

            // Add ellipsis and last page if needed
            if (endPage < totalPages) {
                if (endPage < totalPages - 1) {
                    pageNumbers.appendChild(createEllipsis());
                }
                pageNumbers.appendChild(createPageButton(totalPages));
            }
        }

        function createPageButton(pageNum) {
            const button = document.createElement('button');
            button.textContent = pageNum;
            button.onclick = () => changePage(pageNum);

            if (pageNum === currentPage) {
                button.className = 'relative inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-primary border border-primary';
            } else {
                button.className = 'relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 hover:bg-gray-50';
            }

            return button;
        }

        function createEllipsis() {
            const span = document.createElement('span');
            span.textContent = '...';
            span.className = 'relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300';
            return span;
        }

        function changePage(direction) {
            if (typeof direction === 'number') {
                currentPage = direction;
            } else if (direction === 'prev' && currentPage > 1) {
                currentPage--;
            } else if (direction === 'next' && currentPage < totalPages) {
                currentPage++;
            }

            updatePagination();
        }

        function updateResultsMessage() {
            const noResultsMessage = document.getElementById('noResultsMessage');
            const eventsTable = document.getElementById('eventsTable');

            if (filteredRows.length === 0) {
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
            currentFilters.adminStatus = '';
            currentFilters.eventStatus = '';
            currentFilters.pinStatus = '';

            // Reset pagination
            currentPage = 1;

            // Reset Alpine.js dropdown selections
            const eventTypeDropdown = document.querySelector('[x-data*="Event Type"]');
            const adminStatusDropdown = document.querySelector('[x-data*="Admin Status"]');
            const eventStatusDropdown = document.querySelector('[x-data*="Event Status"]');
            const pinStatusDropdown = document.querySelector('[x-data*="Pin Status"]');

            if (eventTypeDropdown && eventTypeDropdown._x_dataStack) {
                eventTypeDropdown._x_dataStack[0].selected = 'Event Type';
            }
            if (adminStatusDropdown && adminStatusDropdown._x_dataStack) {
                adminStatusDropdown._x_dataStack[0].selected = 'Admin Status';
            }
            if (eventStatusDropdown && eventStatusDropdown._x_dataStack) {
                eventStatusDropdown._x_dataStack[0].selected = 'Event Status';
            }
            if (pinStatusDropdown && pinStatusDropdown._x_dataStack) {
                pinStatusDropdown._x_dataStack[0].selected = 'Pin Status';
            }

            applyFilters();
        }

        // Export functionality
        function exportResults(format) {
            // Export all filtered results, not just current page
            const visibleData = filteredRows.map(row => {
                const cells = row.querySelectorAll('td');
                return {
                    title: row.getAttribute('data-title'),
                    type: row.getAttribute('data-type'),
                    date: cells[1].textContent.trim(),
                    eventStatus: cells[2].textContent.trim(),
                    adminStatus: cells[3].textContent.trim()
                };
            });

            if (format === 'csv') {
                exportToCSV(visibleData);
            } else if (format === 'pdf') {
                // PDF export would require a library like jsPDF
                alert('PDF export functionality would require additional implementation');
            }
        }

        function exportToCSV(data) {
            const headers = ['Title', 'Type', 'Date', 'Event Status', 'Admin Status'];
            const csvContent = [
                headers.join(','),
                ...data.map(row => [
                    `"${row.title}"`,
                    `"${row.type}"`,
                    `"${row.date}"`,
                    `"${row.eventStatus}"`,
                    `"${row.adminStatus}"`
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
            // Ctrl/Cmd + F to focus search
            if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
                e.preventDefault();
                document.getElementById('searchInput').focus();
            }

            // Escape to clear filters
            if (e.key === 'Escape') {
                clearAllFilters();
            }
        });
    </script>

</body>

</html>