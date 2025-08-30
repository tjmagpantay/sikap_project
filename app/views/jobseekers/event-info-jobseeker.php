<?php
include_once __DIR__ . '/components/jobseeker_auth_check.php';
include_once __DIR__ . '/../components/navbar-top.php';
include_once __DIR__ . '/navbar-jobseeker.php';

// Get event data
require_once __DIR__ . '/../../controllers/EventProgramController.php';
$eventController = new EventProgramController();
$event = null;

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $event = $eventController->getEventById($_GET['id']);
}
?>

<?php if (!$event): ?>
    <div class="min-h-screen sm:px-6 md:px-16 lg:px-24">
        <div class="py-8 mx-auto sm:px-2 md:px-4 lg:px-12 max-w-7xl">
            <!-- Event Not Found -->
            <div class="flex items-center justify-center min-h-screen">
                <div class="max-w-md p-8 text-center bg-white rounded-lg shadow-lg">
                    <div class="flex items-center justify-center w-20 h-20 mx-auto mb-6 bg-gray-100 rounded-full">
                        <i class="text-3xl text-gray-400 fas fa-exclamation-triangle"></i>
                    </div>
                    <h1 class="mb-4 text-2xl font-bold text-gray-900">Event Not Found</h1>
                    <p class="mb-6 text-gray-600">The event you're looking for doesn't exist or may have been removed.</p>
                    <div class="flex gap-3">
                        <a href="?page=jobseeker-programs"
                            class="inline-flex items-center justify-center flex-1 px-4 py-2 text-sm font-medium transition-colors duration-200 border rounded-lg text-primary border-primary hover:bg-primary hover:text-white">
                            <i class="mr-2 text-xs fas fa-calendar"></i>
                            Back to Programs
                        </a>
                        <a href="?page=jobseeker-dashboard"
                            class="inline-flex items-center justify-center flex-1 px-4 py-2 text-sm font-medium transition-colors duration-200 border rounded-lg text-primary border-primary hover:bg-primary hover:text-white">
                            <i class="mr-2 text-xs fas fa-home"></i>
                            Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>

    <!-- Event Details -->
    <div class="min-h-screen sm:px-6 md:px-16 lg:px-24">
        <div class="py-8 mx-auto sm:px-2 md:px-4 lg:px-12 max-w-7xl">
            <!-- Breadcrumbs -->
            <nav class="mb-6">
                <div class="flex items-center space-x-2 text-sm">
                    <a href="?page=jobseeker-dashboard" class="text-gray-500 transition-colors hover:text-primary">
                        Dashboard
                    </a>
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    <a href="?page=jobseeker-programs" class="text-gray-500 transition-colors hover:text-primary">
                        Programs & Events
                    </a>
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    <span class="font-medium text-primary">Event Details</span>
                </div>
            </nav>

            <!-- Main Dashboard Content -->
            <div class="flex flex-col gap-8 lg:flex-row">
                <!-- Left Side - Content (2/3) -->
                <div class="w-full lg:!w-2/3 lg:min-w-0 lg:flex-1">
                    <!-- Event Image -->
                    <div class="mb-6 overflow-hidden bg-white rounded-2xl">
                        <?php if (!empty($event['image'])): ?>
                            <img src="<?php echo htmlspecialchars($event['image']); ?>"
                                alt="<?php echo htmlspecialchars($event['title']); ?>"
                                class="object-cover w-full h-48 rounded-lg sm:h-48 lg:h-48">
                        <?php else: ?>
                            <img src="./assets/images/programs-img.png"
                                alt="<?php echo htmlspecialchars($event['title']); ?>"
                                class="object-cover w-full h-64 sm:h-80 lg:h-96">
                        <?php endif; ?>
                    </div>

                    <!-- Event Content -->
                    <div class="">
                        <!-- Date -->
                        <p class="text-xs font-normal tracking-wide text-gray-500 uppercase">
                            <?php echo date('M jS Y', strtotime($event['time_start'])); ?>
                        </p>

                        <!-- Title -->
                        <h1 class="mt-2 mb-4 text-2xl font-bold leading-tight text-gray-900 sm:text-3xl lg:text-4xl">
                            <?php echo htmlspecialchars($event['title']); ?>
                        </h1>

                        <!-- Description -->
                        <div class="prose prose-gray max-w-none">
                            <?php if (!empty($event['description'])): ?>
                                <div class="space-y-4 text-sm leading-relaxed text-gray-600">
                                    <?php
                                    $paragraphs = explode("\n\n", $event['description']);
                                    foreach ($paragraphs as $paragraph):
                                        if (trim($paragraph)):
                                    ?>
                                            <p><?php echo nl2br(htmlspecialchars(trim($paragraph))); ?></p>
                                    <?php
                                        endif;
                                    endforeach;
                                    ?>
                                </div>
                            <?php else: ?>
                                <p class="italic text-gray-500">No description available for this event.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Right Side - Sidebar (1/3) -->
                <div class="w-full lg:!w-1/3 lg:max-w-md">
                    <div class="sticky top-8">
                        <!-- Event Information Card -->
                        <div class="px-6 ">
                            <h3 class="mb-6 text-lg font-semibold text-gray-900">Event Information</h3>

                            <div class="space-y-4">
                                <!-- Date -->
                                <div class="flex items-start gap-3">
                                    <div class="flex-shrink-0 w-5 h-5 mt-0.5">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">Date</p>
                                        <span class="text-sm text-gray-600"><?php echo date('F j, Y', strtotime($event['time_start'])); ?></span>
                                    </div>
                                </div>

                                <!-- Time -->
                                <div class="flex items-start gap-3">
                                    <div class="flex-shrink-0 w-5 h-5 mt-0.5">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">Time</p>
                                        <span class="text-sm text-gray-600">
                                            <?php
                                            echo date('g:i A', strtotime($event['time_start'])) . ' - ' .
                                                date('g:i A', strtotime($event['time_end']));
                                            ?>
                                        </span>
                                    </div>
                                </div>

                                <!-- Event Type -->
                                <div class="flex items-start gap-3">
                                    <div class="flex-shrink-0 w-5 h-5 mt-0.5">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">Event Type</p>
                                        <span class="text-sm text-gray-600"><?php echo ucwords(htmlspecialchars($event['type'])); ?></span>
                                    </div>
                                </div>

                                <!-- Status -->
                                <div class="flex items-start gap-3">
                                    <div class="flex-shrink-0 w-5 h-5 mt-0.5">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">Status</p>
                                        <?php
                                        $now = new DateTime();
                                        $start = new DateTime($event['time_start']);
                                        $end = new DateTime($event['time_end']);
                                        if ($now < $start) {
                                            $status = 'upcoming';
                                            $statusText = 'Upcoming';
                                            $statusColor = 'text-blue-600';
                                        } elseif ($now >= $start && $now <= $end) {
                                            $status = 'ongoing';
                                            $statusText = 'Ongoing';
                                            $statusColor = 'text-green-600';
                                        } else {
                                            $status = 'completed';
                                            $statusText = 'Completed';
                                            $statusColor = 'text-gray-600';
                                        }
                                        ?>
                                        <span class="text-sm <?php echo $statusColor; ?> font-medium"><?php echo $statusText; ?></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="grid grid-cols-2 gap-3 mt-8">
                                <button onclick="shareEvent()" class="px-4 py-3 text-sm font-medium text-gray-700 transition-colors duration-200 bg-gray-100 rounded-xl hover:bg-gray-200">
                                    Share Event
                                </button>
                                <button onclick="saveEvent()" class="px-4 py-3 text-sm font-medium text-white transition-colors duration-200 bg-primary rounded-xl hover:bg-primary/90">
                                    Save Event
                                </button>
                            </div>
                        </div>

                        <!-- Related Events Card -->
                        <div class="p-6 mt-6 bg-white border border-gray-100 shadow-sm rounded-2xl">
                            <h3 class="mb-4 text-lg font-semibold text-gray-900">Related Events</h3>
                            <div class="space-y-3">
                                <?php
                                // Get other events of the same type
                                $allEvents = $eventController->getActiveEvents();
                                $relatedEvents = array_filter($allEvents, function ($e) use ($event) {
                                    return $e['type'] === $event['type'] && $e['event_id'] !== $event['event_id'];
                                });
                                $relatedEvents = array_slice($relatedEvents, 0, 3);
                                ?>
                                <?php if (!empty($relatedEvents)): ?>
                                    <?php foreach ($relatedEvents as $relatedEvent): ?>
                                        <div class="pb-3 border-b border-gray-100 last:border-b-0 last:pb-0">
                                            <a href="?page=event-info-jobseeker&id=<?php echo $relatedEvent['event_id']; ?>"
                                                class="block transition-colors hover:text-primary">
                                                <h4 class="text-sm font-medium text-gray-900 line-clamp-1">
                                                    <?php echo htmlspecialchars($relatedEvent['title']); ?>
                                                </h4>
                                                <p class="text-xs text-gray-500">
                                                    <?php echo date('M j, Y - g:i A', strtotime($relatedEvent['time_start'])); ?>
                                                </p>
                                            </a>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p class="text-sm text-gray-500">No related events found.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php endif; ?>

<script>
    function shareEvent() {
        if (navigator.share) {
            navigator.share({
                title: '<?php echo htmlspecialchars($event['title'] ?? 'Event'); ?>',
                text: 'Check out this event on SIKAP',
                url: window.location.href
            }).catch(console.error);
        } else {
            // Fallback - copy to clipboard
            navigator.clipboard.writeText(window.location.href).then(function() {
                showToast('Link copied to clipboard!');
            });
        }
    }

    function saveEvent() {
        // Add your save event logic here for jobseekers
        showToast('Event saved successfully!');
    }

    function showToast(message) {
        const toast = document.createElement('div');
        toast.className = 'fixed bottom-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50 transition-all duration-300';
        toast.textContent = message;
        document.body.appendChild(toast);

        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateY(20px)';
            setTimeout(() => {
                toast.remove();
            }, 300);
        }, 3000);
    }
</script>