
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($title); ?> - SIKAP</title>
    <link rel="stylesheet" href="css/output.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .event-banner {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .prose {
            line-height: 1.75;
        }
        .prose p {
            margin-bottom: 1rem;
        }
    </style>
</head>
<body class="bg-gray-50">
    <?php 
    // Include navbar - try different paths
    $navbarPaths = [
        __DIR__ . '/components/navbar.php',
        __DIR__ . '/../components/navbar.php',
        __DIR__ . '/../../components/navbar.php'
    ];
    
    foreach ($navbarPaths as $navbarPath) {
        if (file_exists($navbarPath)) {
            include $navbarPath;
            break;
        }
    }
    ?>

    <?php if (!$event): ?>
        <!-- Event Not Found -->
        <div class="flex items-center justify-center min-h-screen">
            <div class="text-center">
                <div class="flex items-center justify-center w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-full">
                    <i class="text-4xl text-gray-400 fas fa-exclamation-triangle"></i>
                </div>
                <h1 class="mb-4 text-3xl font-bold text-gray-900">Event Not Found</h1>
                <p class="mb-6 text-gray-600">The event you're looking for doesn't exist or may have been removed.</p>
                <div class="space-x-4">
                    <a href="javascript:history.back()" class="inline-flex items-center px-6 py-3 text-white transition-colors duration-200 bg-blue-600 rounded-lg hover:bg-blue-700">
                        <i class="mr-2 fas fa-arrow-left"></i>
                        Go Back
                    </a>
                    <a href="index.php" class="inline-flex items-center px-6 py-3 text-blue-600 transition-colors duration-200 bg-white border border-blue-200 rounded-lg hover:bg-blue-50">
                        <i class="mr-2 fas fa-home"></i>
                        Go Home
                    </a>
                </div>
            </div>
        </div>
    <?php else: ?>
        <!-- Back Button -->
        <div class="fixed z-50 top-4 left-4">
            <a href="javascript:history.back()" 
               class="inline-flex items-center px-4 py-2 text-gray-700 transition-colors bg-white rounded-lg shadow-md hover:bg-gray-50">
                <i class="mr-2 fas fa-arrow-left"></i>
                Back
            </a>
        </div>

        <!-- Event Banner -->
        <div class="relative overflow-hidden event-banner">
            <div class="absolute inset-0">
                <?php if (!empty($event['image'])): ?>
                    <img src="<?php echo htmlspecialchars($event['image']); ?>" 
                         alt="Event Banner" 
                         class="object-cover w-full h-full opacity-30">
                <?php endif; ?>
            </div>
            <div class="relative z-10 px-6 py-20">
                <div class="max-w-4xl mx-auto">
                    <div class="p-8 glass-effect rounded-2xl">
                        <div class="flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
                            <div>
                                <!-- Event Type Badge -->
                                <div class="inline-flex items-center px-3 py-1 mb-4 text-xs font-semibold text-white bg-white rounded-full bg-opacity-20">
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
                                <h1 class="mb-3 text-4xl font-bold text-white">
                                    <?php echo htmlspecialchars($event['title']); ?>
                                </h1>
                                <div class="flex flex-wrap items-center gap-4 text-white">
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
                                        $statusIcon = 'fa-hourglass-half';
                                    } elseif ($now >= $start && $now <= $end) {
                                        $status = 'ongoing';
                                        $statusClass = 'bg-green-500 text-white';
                                        $statusText = 'Ongoing';
                                        $statusIcon = 'fa-play-circle';
                                    } else {
                                        $status = 'completed';
                                        $statusClass = 'bg-gray-500 text-white';
                                        $statusText = 'Completed';
                                        $statusIcon = 'fa-check-circle';
                                    }
                                ?>
                                <span class="inline-flex items-center px-4 py-2 rounded-lg font-semibold <?php echo $statusClass; ?>">
                                    <i class="fas <?php echo $statusIcon; ?> mr-2"></i>
                                    <?php echo $statusText; ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Event Details -->
        <div class="max-w-4xl px-6 py-12 mx-auto">
            <div class="grid gap-8 md:grid-cols-3">
                <!-- Main Content -->
                <div class="md:col-span-2">
                    <!-- Description -->
                    <div class="p-8 mb-8 bg-white shadow-sm rounded-xl">
                        <h2 class="mb-6 text-2xl font-bold text-gray-900">
                            <i class="mr-3 text-blue-600 fas fa-align-left"></i>
                            About This Event
                        </h2>
                        <div class="leading-relaxed prose text-gray-700 max-w-none">
                            <?php if (!empty($event['description'])): ?>
                                <?php echo nl2br(htmlspecialchars($event['description'])); ?>
                            <?php else: ?>
                                <p class="italic text-gray-500">No description available for this event.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Event Info Card -->
                    <div class="p-6 bg-white shadow-sm rounded-xl">
                        <h3 class="mb-4 text-lg font-bold text-gray-900">Event Information</h3>
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
            </div>
        </div>
    <?php endif; ?>

    <script>
        // Add some interactivity
        document.addEventListener('DOMContentLoaded', function() {
            // Smooth scroll for any anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    document.querySelector(this.getAttribute('href')).scrollIntoView({
                        behavior: 'smooth'
                    });
                });
            });

            // Add fade-in animation to cards
            const cards = document.querySelectorAll('.bg-white');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.6s ease-out';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>
</body>
</html>