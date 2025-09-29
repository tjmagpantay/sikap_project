<?php
include_once __DIR__ . '/../components/navbar-top.php';
include_once __DIR__ . '/../components/navbar.php';
?>

<?php if (!$event): ?>
    <div class="min-h-screen py-8">
        <div class="mx-auto max-w-7xl">
            <!-- Event Not Found -->
            <div class="flex items-center justify-center ">
                <div class="max-w-md p-8 text-center rounded-lg shadow-lg">
                    <div class="flex items-center justify-center w-20 h-20 mx-auto mb-6 rounded-full">
                        <i class="text-3xl text-gray-400 fas fa-exclamation-triangle"></i>
                    </div>
                    <h1 class="mb-4 text-2xl font-bold text-gray-900">Event Not Found</h1>
                    <p class="mb-6 text-sm text-gray-600">The event you're looking for doesn't exist or may have been removed.</p>
                    <div class="flex gap-3">
                        <a href="index.php"
                            class="inline-flex items-center justify-center flex-1 px-4 py-2 text-sm font-medium transition-colors duration-200 border rounded-lg text-primary border-primary hover:bg-primary hover:text-white">
                            <i class="mr-2 text-xs fas fa-home"></i>
                            Home
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>

    <!-- Event Details -->
    <div class="min-h-screen py-8 ">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="flex flex-col gap-8 lg:flex-row">
                <!-- Main Content (Left Section) -->
                <div class="w-full lg:w-2/3">
                    <!-- Event Image -->
                    <div class="mb-6 overflow-hidden bg-white rounded-2xl">
                        <?php if (!empty($event['image'])): ?>
                            <img src="<?php echo htmlspecialchars($event['image']); ?>"
                                alt="<?php echo htmlspecialchars($event['title']); ?>"
                                class="object-cover w-full h-64 rounded-lg sm:h-80 lg:h-96">
                        <?php else: ?>
                            <img src="./assets/images/programs-img.png"
                                alt="<?php echo htmlspecialchars($event['title']); ?>"
                                class="object-cover w-full h-64 sm:h-80 lg:h-96">
                        <?php endif; ?>
                    </div>

                    <!-- Event Content -->
                    <div class="space-y-4">
                        <!-- Date -->
                        <p class="text-xs font-normal tracking-wide text-gray-500 uppercase">
                            <?php echo date('M jS Y', strtotime($event['time_start'])); ?>
                        </p>

                        <!-- Title -->
                        <h1 class="text-2xl font-bold leading-tight text-gray-900 sm:text-3xl lg:text-4xl">
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
                <!-- Sidebar (Right Section) -->
                <div class="w-full lg:w-1/3 ">
                    <div class="sticky top-8">
                        <!-- Event Information Card -->
                        <div class="p-6 bg-white border border-gray-100 shadow-sm rounded-xl">
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
                                        <p class="text-sm font-medium text-gray-900">Date:
                                            <span class="text-sm text-gray-600"><?php echo date('F j, Y', strtotime($event['time_start'])); ?></span>
                                        </p>
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
                                        <p class="text-sm font-medium text-gray-900">Time:
                                            <span class="text-sm text-gray-600">
                                                <?php
                                                echo date('g:i A', strtotime($event['time_start'])) . ' - ' .
                                                    date('g:i A', strtotime($event['time_end']));
                                                ?>
                                            </span>
                                        </p>
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
                                        <p class="text-sm font-medium text-gray-900">Event Type:
                                            <span class="text-sm text-gray-600"><?php echo ucwords(htmlspecialchars($event['type'])); ?></span>
                                        </p>
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
                                        <p class="text-sm font-medium text-gray-900">Status:
                                            <?php
                                            $now = new DateTime();
                                            $start = new DateTime($event['time_start']);
                                            $end = new DateTime($event['time_end']);
                                            if ($now < $start) {
                                                $status = 'upcoming';
                                                $statusText = 'Upcoming';
                                            } elseif ($now >= $start && $now <= $end) {
                                                $status = 'ongoing';
                                                $statusText = 'Ongoing';
                                            } else {
                                                $status = 'completed';
                                                $statusText = 'Completed';
                                            }
                                            ?>
                                            <span class="text-sm text-gray-600"><?php echo $statusText; ?></span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons - Full Width -->
                            <div class="mt-8">
                                <button onclick="shareEvent()"
                                    class="flex items-center justify-center w-full gap-2 px-4 py-3 text-sm font-medium text-white transition-colors duration-200 rounded-md bg-primary hover:bg-primary/90">
                                    Share Event
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php endif; ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add fade-in animation
        const elements = document.querySelectorAll('.lg\\:w-2\\/3 > *, .lg\\:w-1\\/3 > *');
        elements.forEach((element, index) => {
            element.style.opacity = '0';
            element.style.transform = 'translateY(20px)';
            setTimeout(() => {
                element.style.transition = 'all 0.6s ease-out';
                element.style.opacity = '1';
                element.style.transform = 'translateY(0)';
            }, index * 100);
        });
    });

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
        // Add your save event logic here
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