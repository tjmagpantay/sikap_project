
    <div class="flex h-screen">
        <?php include __DIR__ . '/../components/sidebar.php'; ?>
        
        <div class="flex flex-col flex-1 overflow-hidden">
            <?php include __DIR__ . '/../components/topbar.php'; ?>
            
            <main class="flex-1 overflow-y-auto bg-gray-50">
                <div class="container px-6 py-8 mx-auto">
                    <div class="flex justify-between mb-6">
                        <div>
                            <h1 class="text-2xl font-semibold text-gray-900">Events & Programs</h1>
                            <p class="mt-2 text-sm text-gray-700">Manage all events and programs <span id="eventCount" class="font-medium">(<?php echo count($events); ?>)</span></p>
                        </div>
                        <div>
                            <a href="index.php?page=admin-event-create" 
                               class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">
                                <i class="mr-2 fas fa-plus"></i>
                                Create New Event
                            </a>
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

                    <!-- Tabbed Type Navigation and Search -->
                    <div class="p-6 mb-6 bg-white rounded-lg shadow">
                        <div class="flex flex-col gap-4 md:flex-row">
                            <div class="flex items-center mb-4 space-x-2 md:mb-0">
                                <button type="button" class="px-4 py-2 font-medium rounded-md event-tab focus:outline-none focus:ring-2 focus:ring-blue-500" data-type="program">Program</button>
                                <button type="button" class="px-4 py-2 font-medium rounded-md event-tab focus:outline-none focus:ring-2 focus:ring-blue-500" data-type="jobfair">Job Fair</button>
                                <button type="button" class="px-4 py-2 font-medium rounded-md event-tab focus:outline-none focus:ring-2 focus:ring-blue-500" data-type="local recruitment">Local Recruitment</button>
                            </div>
                            <div class="flex flex-1 gap-4">
                                <div class="flex-1">
                                    <label for="searchInput" class="block mb-2 text-sm font-medium text-gray-700">Search Events</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                            <i class="text-gray-400 fas fa-search"></i>
                                        </div>
                                        <input type="text" 
                                               id="searchInput" 
                                               class="block w-full py-2 pl-10 pr-3 leading-5 placeholder-gray-500 bg-white border border-gray-300 rounded-md focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                                               placeholder="Search by event title...">
                                    </div>
                                </div>
                                <div class="w-48">
                                    <label for="adminStatusFilter" class="block mb-2 text-sm font-medium text-gray-700">Admin Status</label>
                                    <select id="adminStatusFilter" class="block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="all">All</option>
                                        <option value="show">Visible</option>
                                        <option value="hide">Hidden</option>
                                        <option value="draft">Draft</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="overflow-hidden bg-white rounded-lg shadow">
                        <table class="w-full table-auto divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Event
                                    </th>
                                    <!-- Date & Time sortable column -->
                                    <th id="sortDateHeader" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase cursor-pointer">
                                        Date & Time
                                        <i id="sortIcon" class="ml-1 fas fa-sort"></i>
                                    </th>
                                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Event Status
                                    </th>
                                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Admin Status
                                    </th>
                                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200" id="eventsTableBody">
                                <?php foreach ($events as $event): ?>
                                    <tr class="event-row">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 w-12 h-12">
                                                    <?php if (!empty($event['image'])): ?>
                                                        <img class="object-cover w-12 h-12 rounded-full" 
                                                             src="<?php echo htmlspecialchars($event['image']); ?>" 
                                                             alt="">
                                                    <?php else: ?>
                                                        <div class="flex items-center justify-center w-10 h-10 bg-gray-300 rounded-full">
                                                            <i class="text-gray-500 fas fa-calendar-alt"></i>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900 event-title">
                                                        <?php echo htmlspecialchars($event['title']); ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <span class="event-type" data-type="<?php echo strtolower(trim($event['type'])); ?>" style="display:none"></span>
                                        </td>
                                        <td class="px-6 py-4 event-date" data-date="<?php echo date('Y-m-d H:i:s', strtotime($event['time_start'])); ?>">
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
                                            <span class="inline-flex px-2 text-xs font-semibold leading-5 <?php echo $statusClass; ?> rounded-full event-status" data-status="<?php echo $status; ?>">
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
                                            <span class="inline-flex px-2 text-xs font-semibold leading-5 <?php echo $adminStatusClass; ?> rounded-full admin-status" data-status="<?php echo $adminStatus; ?>">
                                                <?php echo $adminStatusText; ?>
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <a href="index.php?page=admin-event-edit&id=<?php echo $event['event_id']; ?>" 
                                               class="text-indigo-600 hover:text-indigo-900" title="Edit Event">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button onclick="confirmDelete(<?php echo $event['event_id']; ?>)" 
                                                    class="ml-3 text-red-600 hover:text-red-900" title="Delete Event">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        
                        <!-- No Results Message -->
                        <div id="noResultsMessage" class="hidden p-8 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <i class="mb-4 text-4xl text-gray-300 fas fa-search"></i>
                                <h3 class="mb-2 text-lg font-medium text-gray-900">No events found</h3>
                                <p class="text-sm text-gray-500">Try adjusting your search criteria or filters.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        function confirmDelete(eventId) {
            if (confirm('Are you sure you want to delete this event?')) {
                window.location.href = `index.php?page=admin-event-delete&id=${eventId}`;
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const eventRows = document.querySelectorAll('.event-row');
            const eventCount = document.getElementById('eventCount');
            const noResultsMessage = document.getElementById('noResultsMessage');
            const tableBody = document.getElementById('eventsTableBody');
            const adminStatusFilter = document.getElementById('adminStatusFilter');

            let activeTab = 'program'; 
            let sortAscending = true;

            function filterEvents() {
                const searchTerm = searchInput.value.toLowerCase().trim();
                const selectedAdminStatus = adminStatusFilter.value;
                let visibleCount = 0;

                eventRows.forEach(row => {
                    const title = row.querySelector('.event-title').textContent.toLowerCase();
                    const category = row.querySelector('.event-type').dataset.type;
                    const adminStatus = row.querySelector('.admin-status').dataset.status;
                    
                    const matchesSearch = searchTerm === '' || title.includes(searchTerm);
                    const matchesTab = category === activeTab;
                    const matchesAdminStatus = selectedAdminStatus === 'all' || adminStatus === selectedAdminStatus;

                    if (matchesSearch && matchesTab && matchesAdminStatus) {
                        row.style.display = '';
                        visibleCount++;
                    } else {
                        row.style.display = 'none';
                    }
                });

                eventCount.textContent = `(${visibleCount})`;

                if (visibleCount === 0) {
                    noResultsMessage.classList.remove('hidden');
                    tableBody.style.display = 'none';
                } else {
                    noResultsMessage.classList.add('hidden');
                    tableBody.style.display = '';
                }
            }

            // Sorting function
            document.getElementById('sortDateHeader').addEventListener('click', function() {
                const rowsArray = Array.from(document.querySelectorAll('#eventsTableBody .event-row'))
                    .filter(row => row.style.display !== 'none');

                rowsArray.sort((a, b) => {
                    const dateA = new Date(a.querySelector('.event-date').dataset.date);
                    const dateB = new Date(b.querySelector('.event-date').dataset.date);
                    return sortAscending ? dateA - dateB : dateB - dateA;
                });

                rowsArray.forEach(row => tableBody.appendChild(row));
                sortAscending = !sortAscending;

                const sortIcon = document.getElementById('sortIcon');
                sortIcon.className = sortAscending ? 'ml-1 fas fa-sort-up' : 'ml-1 fas fa-sort-down';
            });

            searchInput.addEventListener('input', filterEvents);
            adminStatusFilter.addEventListener('change', filterEvents);

            document.querySelectorAll('.event-tab').forEach(tab => {
                tab.addEventListener('click', function() {
                    document.querySelectorAll('.event-tab').forEach(t => {
                        t.classList.remove('bg-blue-600', 'text-white');
                        t.classList.add('text-gray-600', 'bg-gray-100');
                    });
                    this.classList.remove('text-gray-600', 'bg-gray-100');
                    this.classList.add('bg-blue-600', 'text-white');
                    activeTab = this.dataset.type;
                    filterEvents();
                });
            });

            document.querySelector('.event-tab[data-type="program"]').classList.add('bg-blue-600', 'text-white');

            document.addEventListener('keydown', function(e) {
                if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                    e.preventDefault();
                    searchInput.focus();
                }
            });

            filterEvents();
        });
    </script>

