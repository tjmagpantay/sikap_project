<?php
include_once __DIR__ . '/../components/navbar-top.php';
include_once __DIR__ . '/../components/navbar.php';
?>

<?php if (!$event): ?>
    <div class="min-h-screen py-8 bg-gray-50">
        <div class="sm:mx-auto sm:w-full sm:max-w-2xl">
            <!-- Event Not Found -->
            <div class="flex items-center justify-center min-h-screen bg-gray-50">
                <div class="max-w-md p-8 text-center bg-white rounded-lg shadow-custom">
                    <div class="flex items-center justify-center w-20 h-20 mx-auto mb-6 bg-gray-100 rounded-full">
                        <i class="text-3xl text-gray-400 fas fa-exclamation-triangle"></i>
                    </div>
                    <h1 class="mb-4 text-2xl font-bold text-gray-900">Event Not Found</h1>
                    <p class="mb-6 text-gray-600">The event you're looking for doesn't exist or may have been removed.</p>
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


    <!-- Event Banner -->


    <!-- Event Details -->
    <div class="min-h-screen py-8 bg-gray-50">
        <div class="sm:mx-auto sm:w-full sm:max-w-2xl">
                <div class="relative overflow-hidden event-banner">
        <div class="absolute inset-0">
            <?php if (!empty($event['image'])): ?>
                <img src="<?php echo htmlspecialchars($event['image']); ?>"
                    alt="Event Banner"
                    class="object-cover w-full h-full opacity-20">
            <?php endif; ?>
        </div>
        <div class="relative z-10 px-4 py-16 sm:px-6 md:px-16 lg:px-24">
            <div class="mx-auto sm:max-w-2xl">
                <div class="p-6 glass-effect rounded-xl sm:p-8">
                    <div class="flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
                        <div class="flex-1">
                            <!-- Event Type Badge -->
                            <div class="inline-flex items-center px-3 py-1 mb-4 text-xs font-medium text-white bg-white rounded-full bg-opacity-20">
                                <?php
                                $typeConfig = [
                                    'program' => ['icon' => 'fas fa-graduation-cap'],
                                    'jobfair' => ['icon' => 'fas fa-briefcase'],
                                    'local recruitment' => ['icon' => 'fas fa-users']
                                ];
                                $config = $typeConfig[$event['type']] ?? ['icon' => 'fas fa-calendar'];
                                ?>
                                <i class="<?php echo $config['icon']; ?> mr-2"></i>
                                <?php echo ucwords(htmlspecialchars($event['type'])); ?>
                            </div>

                            <h1 class="mb-4 text-2xl font-bold text-white sm:text-3xl lg:text-4xl">
                                <?php echo htmlspecialchars($event['title']); ?>
                            </h1>

                            <div class="flex flex-wrap items-center gap-4 text-sm text-white">
                                <div class="flex items-center">
                                    <i class="mr-2 fas fa-calendar-alt"></i>
                                    <?php echo date('F j, Y', strtotime($event['time_start'])); ?>
                                </div>
                                <div class="flex items-center">
                                    <i class="mr-2 fas fa-clock"></i>
                                    <?php
                                    echo date('g:i A', strtotime($event['time_start'])) . ' - ' .
                                        date('g:i A', strtotime($event['time_end']));
                                    ?>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col gap-3">
                            <?php
                            $now = new DateTime();
                            $start = new DateTime($event['time_start']);
                            $end = new DateTime($event['time_end']);
                            if ($now < $start) {
                                $status = 'upcoming';
                                $statusClass = 'bg-yellow-500 text-white';
                                $statusText = 'Upcoming';
                                $statusIcon = 'fa-clock';
                            } elseif ($now >= $start && $now <= $end) {
                                $status = 'ongoing';
                                $statusClass = 'bg-green-500 text-white';
                                $statusText = 'Ongoing';
                                $statusIcon = 'fa-play';
                            } else {
                                $status = 'completed';
                                $statusClass = 'bg-gray-500 text-white';
                                $statusText = 'Completed';
                                $statusIcon = 'fa-check';
                            }
                            ?>
                            <span class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg shadow-sm <?php echo $statusClass; ?>">
                                <i class="fas <?php echo $statusIcon; ?> mr-2"></i>
                                <?php echo $statusText; ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
            <div class="flex flex-col gap-8 lg:flex-row">
                <!-- Main Content -->
                <div class="w-full lg:w-2/3">
                    <!-- Description Card -->
                    <div class="overflow-hidden bg-white border border-gray-200 rounded-lg shadow-custom">
                        <div class="p-6 border-b border-gray-100 bg-gray-50">
                            <h2 class="flex items-center text-xl font-bold text-gray-900">
                                <div class="flex items-center justify-center w-10 h-10 mr-3 bg-blue-100 rounded-lg">
                                    <i class="text-blue-600 fas fa-align-left"></i>
                                </div>
                                About This Event
                            </h2>
                        </div>
                        <div class="p-6">
                            <div class="leading-relaxed text-gray-700">
                                <?php if (!empty($event['description'])): ?>
                                    <?php echo nl2br(htmlspecialchars($event['description'])); ?>
                                <?php else: ?>
                                    <p class="italic text-gray-500">No description available for this event.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="w-full lg:w-1/3">
                    <div class="sticky top-8">
                        <div class="space-y-6">
                            <!-- Event Info Card -->
                            <div class="overflow-hidden bg-white border border-gray-200 rounded-lg shadow-custom">
                                <div class="p-4 border-b border-gray-100 bg-gray-50">
                                    <h3 class="text-lg font-bold text-gray-900">Event Information</h3>
                                </div>
                                <div class="p-6">
                                    <div class="space-y-4">
                                        <div class="flex items-start">
                                            <div class="flex items-center justify-center flex-shrink-0 w-10 h-10 bg-blue-100 rounded-lg">
                                                <i class="text-blue-600 fas fa-calendar"></i>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-gray-900">Date</p>
                                                <p class="text-sm text-gray-600"><?php echo date('F j, Y', strtotime($event['time_start'])); ?></p>
                                            </div>
                                        </div>

                                        <div class="flex items-start">
                                            <div class="flex items-center justify-center flex-shrink-0 w-10 h-10 bg-green-100 rounded-lg">
                                                <i class="text-green-600 fas fa-clock"></i>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-gray-900">Time</p>
                                                <p class="text-sm text-gray-600">
                                                    <?php
                                                    echo date('g:i A', strtotime($event['time_start'])) . ' - ' .
                                                        date('g:i A', strtotime($event['time_end']));
                                                    ?>
                                                </p>
                                            </div>
                                        </div>

                                        <div class="flex items-start">
                                            <div class="flex items-center justify-center flex-shrink-0 w-10 h-10 bg-purple-100 rounded-lg">
                                                <i class="text-purple-600 fas fa-tag"></i>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-gray-900">Event Type</p>
                                                <p class="text-sm text-gray-600"><?php echo ucwords(htmlspecialchars($event['type'])); ?></p>
                                            </div>
                                        </div>

                                        <div class="flex items-start">
                                            <div class="flex items-center justify-center flex-shrink-0 w-10 h-10 bg-orange-100 rounded-lg">
                                                <i class="text-orange-600 fas fa-info-circle"></i>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-gray-900">Status</p>
                                                <p class="text-sm text-gray-600"><?php echo ucfirst($statusText); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Card -->
                            <div class="overflow-hidden bg-white border border-gray-200 rounded-lg shadow-custom">
                                <div class="p-4 border-b border-gray-100 bg-gray-50">
                                    <h3 class="text-lg font-bold text-gray-900">Actions</h3>
                                </div>
                                <div class="p-6">
                                    <div class="space-y-3">
                                        <button data-action="share" class="w-full px-4 py-2 text-sm font-medium text-white transition-colors duration-200 rounded-lg bg-primary hover:bg-secondary">
                                            <i class="mr-2 fas fa-share"></i>
                                            Share Event
                                        </button>

                                        <?php if ($status === 'upcoming'): ?>
                                            <button class="w-full px-4 py-2 text-sm font-medium transition-colors duration-200 border rounded-lg text-primary border-primary hover:bg-primary hover:text-white">
                                                <i class="mr-2 fas fa-bell"></i>
                                                Set Reminder
                                            </button>
                                        <?php endif; ?>

                                        <a href="?page=program-events"
                                            class="inline-flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-gray-700 transition-colors duration-200 bg-gray-100 rounded-lg hover:bg-gray-200">
                                            <i class="mr-2 fas fa-arrow-left"></i>
                                            All Events
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
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
        // Smooth scroll for any anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Add fade-in animation to cards
        const cards = document.querySelectorAll('.shadow-custom');
        cards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            setTimeout(() => {
                card.style.transition = 'all 0.6s ease-out';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 100);
        });

        // Share functionality
        const shareButton = document.querySelector('button[data-action="share"]');
        if (shareButton) {
            shareButton.addEventListener('click', function() {
                if (navigator.share) {
                    navigator.share({
                        title: '<?php echo htmlspecialchars($event['title'] ?? 'Event'); ?>',
                        text: 'Check out this event on SIKAP',
                        url: window.location.href
                    }).catch(console.error);
                } else {
                    // Fallback - copy to clipboard
                    navigator.clipboard.writeText(window.location.href).then(function() {
                        // Show toast or notification
                        const toast = document.createElement('div');
                        toast.className = 'fixed bottom-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50';
                        toast.textContent = 'Link copied to clipboard!';
                        document.body.appendChild(toast);
                        setTimeout(() => {
                            toast.remove();
                        }, 3000);
                    });
                }
            });
        }
    });
</script>