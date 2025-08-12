<?php
include_once __DIR__ . '/../components/navbar-top.php';
include_once __DIR__ . '/navbar-jobseeker.php';
?>

<div class="min-h-screen">
    <div class="px-4 py-8 sm:px-6 md:px-16 lg:px-24">
        <!-- Hero Search Section -->
        <div class="relative px-6 py-6 mb-8 overflow-hidden sm:px-8 sm:py-12 lg:px-12 lg:py-16 rounded-xl">
            <!-- Background Image and Gradient Overlay (below content) -->
            <div class="absolute inset-0 z-0">
                <img src="assets/images/hero-page-bg.png"
                    alt="Hero Background"
                    class="object-cover w-full h-full opacity-20"
                    onerror="this.style.display='none'">
                <div class="absolute inset-0"
                    style="background: linear-gradient(to right, var(--color-primary, #092C4C) 0%, transparent 100%); opacity: 0.85;">
                </div>
            </div>
            <!-- Content (above gradient) -->
            <div class="relative z-10 flex flex-col max-w-5xl gap-6 mx-auto md:flex-row md:items-center md:justify-between" style="min-height:70px;">
                <!-- Left: Headline -->
                <div class="flex flex-col items-start justify-start flex-1 h-full md:items-start md:justify-start">
                    <h1 class="w-full mb-1 text-2xl font-bold text-center text-white sm:text-3xl lg:text-4xl md:w-auto md:text-left">
                        Find Your Dream Job Today
                    </h1>
                    <p class="max-w-2xl mt-2 text-sm leading-relaxed text-center text-white md:text-left sm:mt-3 sm:text-sm">
                        Apply job that match you.
                    </p>
                </div>
                <!-- Right: Search Form -->
                <div class="flex-1">
                    <form class="w-full max-w-md ml-auto md:max-w-lg lg:max-w-xl">
                        <div class="flex flex-col gap-2 p-3 bg-white rounded-md shadow md:flex-row md:flex-nowrap">
                            <!-- Job Title Field -->
                            <div class="flex items-center flex-1 min-w-0 gap-2 px-2 py-1">
                                <img src="assets/icons/search-svgrepo-com.svg" class="w-5 h-5 text-gray-500" alt="Location Icon" />
                                <input
                                    type="text"
                                    placeholder="Job title"
                                    class="flex-1 min-w-0 text-sm bg-transparent border-none outline-none focus:ring-0" />
                            </div>
                            <!-- Separator -->
                            <div class="hidden w-px h-8 bg-gray-300 md:block"></div>
                            <!-- Location Field -->
                            <div class="flex items-center flex-1 min-w-0 px-2 py-1 mt-2 md:mt-0">
                                <div class="flex items-center flex-1 min-w-0 gap-2 px-2 py-1">
                                    <img src="assets/icons/location-information-svgrepo-com.svg" class="w-5 h-5 text-gray-500" alt="Location Icon" />
                                    <input
                                        type="text"
                                        placeholder="Location"
                                        class="flex-1 min-w-0 text-sm bg-transparent border-none outline-none focus:ring-0" />
                                </div>
                            </div>
                            <!-- Search Button -->
                            <button type="submit" class="w-full min-w-0 mt-2 btn-primary md:w-auto md:mt-0 md:ml-2">
                                Search
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Dashboard Content -->
        <div class="flex flex-col gap-6 lg:flex-row">
            <!-- Left Side - Job Cards (Scrollable) -->
            <div class="w-full lg:w-1/3 xl:w-1/4">
                <div class="">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-900">Available Jobs</h2>
                        <span class="text-sm text-gray-500"><?php echo count($jobs); ?> jobs</span>
                    </div>

                    <!-- Filter Buttons -->
                    <div class="flex gap-2 mb-4">
                        <button class="flex-1 px-3 py-4 text-sm font-medium text-white transition-colors rounded-md bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-primary/50"
                            data-filter="all" onclick="filterJobs('all', this)">
                            All Jobs
                        </button>
                        <button class="flex-1 px-3 py-4 text-sm font-medium text-gray-700 transition-colors bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary/50"
                            data-filter="recent" onclick="filterJobs('recent', this)">
                            Most Recent
                        </button>
                        <button class="flex-1 px-3 py-4 text-sm font-medium text-gray-700 transition-colors bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary/50"
                            data-filter="matches" onclick="filterJobs('matches', this)">
                            Best Matches
                        </button>
                    </div>

                    <div class="overflow-y-auto" style="max-height: 600px;">
                        <?php if (!empty($jobs)): ?>
                            <div class="space-y-3">
                                <?php foreach ($jobs as $job): ?>
                                    <div class="p-4 transition-all border border-gray-200 rounded-lg cursor-pointer hover:border-primary hover:shadow-md job-card <?php echo (isset($_GET['job_id']) && $_GET['job_id'] == $job['job_id'] ? 'border-primary bg-primary/5' : ''); ?>"
                                        onclick="window.location.href='?page=jobseeker-dashboard&job_id=<?php echo $job['job_id']; ?>'">
                                        <div class="flex items-start justify-between">
                                            <div>
                                                <h3 class="font-medium text-gray-900"><?php echo htmlspecialchars($job['job_title']); ?></h3>
                                                <p class="text-sm text-gray-600"><?php echo htmlspecialchars($job['company_name'] ?? $job['business_name'] ?? ''); ?></p>
                                            </div>
                                            <?php if ($hasProfile): ?>
                                                <button onclick="event.stopPropagation(); toggleSaveJob(<?php echo $job['job_id']; ?>, this)"
                                                    class="p-1 text-gray-400 save-btn hover:text-yellow-500"
                                                    data-job-id="<?php echo $job['job_id']; ?>"
                                                    data-saved="<?php echo (isset($job['is_saved']) && $job['is_saved']) ? 'true' : 'false'; ?>"
                                                    title="<?php echo (isset($job['is_saved']) && $job['is_saved']) ? 'Remove from saved jobs' : 'Save job for later'; ?>">
                                                    <i class="<?php echo (isset($job['is_saved']) && $job['is_saved']) ? 'fas fa-bookmark text-yellow-500' : 'far fa-bookmark'; ?>"></i>
                                                </button>
                                            <?php endif; ?>
                                        </div>

                                        <div class="flex items-center mt-2 space-x-2">
                                            <span class="px-2 py-1 text-xs rounded <?php echo strtolower($job['job_type']) === 'full-time' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800'; ?>">
                                                <?php echo strtoupper($job['job_type']); ?>
                                            </span>
                                            <span class="text-xs text-gray-500">
                                                <i class="mr-1 fas fa-map-marker-alt"></i>
                                                <?php echo htmlspecialchars($job['location']); ?>
                                            </span>
                                        </div>

                                        <?php if ($job['show_pay'] && $job['salary']): ?>
                                            <p class="mt-2 text-sm font-medium text-gray-900">
                                                ₱<?php echo number_format($job['salary'], 2); ?>
                                                <span class="text-xs text-gray-500">/ <?php echo $job['pay_type'] ?? 'month'; ?></span>
                                            </p>
                                        <?php endif; ?>

                                        <!-- Status if applied -->
                                        <?php if (isset($job['has_applied']) && $job['has_applied']): ?>
                                            <span class="inline-flex items-center px-2 py-1 mt-2 text-xs font-medium text-gray-500 bg-gray-100 border border-gray-300 rounded">
                                                <i class="mr-1 text-green-500 fas fa-check-circle"></i> Applied
                                            </span>
                                        <?php endif; ?>

                                        <!-- View Full Details Button -->
                                        <div class="flex mt-3">
                                            <a href="?page=view-job&job_id=<?php echo $job['job_id']; ?>"
                                                onclick="event.stopPropagation();"
                                                class="px-3 py-1 mt-2 text-xs font-medium text-blue-600 transition bg-blue-100 border border-blue-300 rounded hover:bg-blue-200">
                                                View Full Details
                                            </a>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="p-8 text-center">
                                <i class="mx-auto text-4xl text-gray-300 fas fa-briefcase"></i>
                                <p class="mt-2 text-gray-500">No jobs available</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Right Side - Job Details Preview -->
            <div class="w-full lg:w-2/3 xl:w-3/4">
                <?php if (isset($_GET['job_id']) && !empty($selectedJob)): ?>
                    <!-- Job Details Card -->
                    <div class="p-6 bg-white border border-gray-200 shadow-sm rounded-xl">
                        <div class="flex items-start justify-between">
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900"><?php echo htmlspecialchars($selectedJob['job_title']); ?></h2>
                                <div class="flex items-center mt-2 space-x-4">
                                    <p class="text-gray-600">
                                        <i class="mr-1 fas fa-building"></i>
                                        <?php echo htmlspecialchars($selectedJob['company_name'] ?? $selectedJob['business_name'] ?? 'Company'); ?>
                                    </p>
                                    <p class="text-gray-600">
                                        <i class="mr-1 fas fa-map-marker-alt"></i>
                                        <?php echo htmlspecialchars($selectedJob['location']); ?>
                                    </p>
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                <?php if ($hasProfile): ?>
                                    <button onclick="toggleSaveJob(<?php echo $selectedJob['job_id']; ?>, this)"
                                        class="p-2 text-gray-400 rounded-full hover:bg-gray-100 hover:text-yellow-500"
                                        title="<?php echo (isset($selectedJob['is_saved']) && $selectedJob['is_saved']) ? 'Remove from saved' : 'Save job'; ?>">
                                        <i class="<?php echo (isset($selectedJob['is_saved']) && $selectedJob['is_saved']) ? 'fas text-yellow-500' : 'far'; ?> fa-bookmark"></i>
                                    </button>
                                <?php endif; ?>
                                <a href="?page=view-job&job_id=<?php echo $selectedJob['job_id']; ?>"
                                    class="p-2 text-gray-400 rounded-full hover:bg-gray-100 hover:text-primary"
                                    title="View Full Details">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                            </div>
                        </div>

                        <div class="mt-6">
                            <div class="flex flex-wrap gap-2 mb-4">
                                <span class="px-3 py-1 text-sm rounded-full <?php echo strtolower($selectedJob['job_type']) === 'full-time' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800'; ?>">
                                    <?php echo strtoupper($selectedJob['job_type']); ?>
                                </span>
                                <?php if ($selectedJob['show_pay'] && $selectedJob['salary']): ?>
                                    <span class="px-3 py-1 text-sm font-medium text-gray-800 bg-gray-100 rounded-full">
                                        ₱<?php echo number_format($selectedJob['salary'], 2); ?>
                                        <span class="text-xs text-gray-500">/ <?php echo $selectedJob['pay_type'] ?? 'month'; ?></span>
                                    </span>
                                <?php endif; ?>
                                <span class="px-3 py-1 text-sm text-gray-800 bg-gray-100 rounded-full">
                                    <i class="mr-1 fas fa-clock"></i>
                                    Posted <?php echo date('M j', strtotime($selectedJob['created_at'])); ?>
                                </span>
                            </div>

                            <div class="mb-6">
                                <h3 class="mb-2 text-lg font-semibold text-gray-900">Job Description</h3>
                                <div class="prose-sm prose text-gray-700 max-w-none">
                                    <?php echo nl2br(htmlspecialchars($selectedJob['job_summary'])); ?>
                                </div>
                            </div>

                            <?php if (!empty($selectedJob['full_description'])): ?>
                                <div class="mb-6">
                                    <h3 class="mb-2 text-lg font-semibold text-gray-900">Full Description</h3>
                                    <div class="prose-sm prose text-gray-700 max-w-none">
                                        <?php echo nl2br(htmlspecialchars($selectedJob['full_description'])); ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="flex flex-col gap-3 mt-8 sm:flex-row">
                                <?php if (!$hasProfile): ?>
                                    <a href="?page=complete-jobseeker-profile"
                                        class="w-full px-4 py-2 text-sm font-medium text-center text-white bg-gray-600 rounded-lg hover:bg-gray-700">
                                        Complete Profile to Apply
                                    </a>
                                <?php elseif (isset($selectedJob['has_applied']) && $selectedJob['has_applied']): ?>
                                    <span class="w-full px-4 py-2 text-sm font-medium text-center text-gray-500 bg-gray-100 border border-gray-300 rounded-lg">
                                        <i class="mr-1 fas fa-check-circle"></i> Applied
                                    </span>
                                <?php else: ?>
                                    <a href="?page=apply-job&job_id=<?php echo $selectedJob['job_id']; ?>&step=1"
                                        class="w-full px-4 py-2 text-sm font-medium text-center text-white rounded-lg bg-primary hover:bg-primary/90">
                                        <i class="mr-1 fas fa-paper-plane"></i> Apply Now
                                    </a>
                                <?php endif; ?>
                                <a href="?page=view-job&job_id=<?php echo $selectedJob['job_id']; ?>"
                                    class="w-full px-4 py-2 text-sm font-medium text-center bg-white border rounded-lg text-primary border-primary hover:bg-primary/5">
                                    View Full Details
                                </a>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <!-- Empty State -->
                    <div class="flex flex-col items-center justify-center h-full p-8 text-center bg-white border border-gray-200 shadow-sm rounded-xl">
                        <i class="text-5xl text-gray-300 fas fa-briefcase"></i>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">Select a job to view details</h3>
                        <p class="mt-1 text-gray-500">Click on any job from the list to see its full details</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
    // Same JavaScript functions as before
    function toggleSaveJob(jobId, button) {
        const isSaved = button.querySelector('i').classList.contains('fas');
        const action = isSaved ? 'unsave-job' : 'save-job';

        fetch('ajax/job-actions.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    action: action,
                    job_id: jobId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const icon = button.querySelector('i');
                    if (isSaved) {
                        icon.classList.remove('fas', 'text-yellow-500');
                        icon.classList.add('far');
                    } else {
                        icon.classList.remove('far');
                        icon.classList.add('fas', 'text-yellow-500');
                    }
                    showToast(isSaved ? 'Job removed from saved' : 'Job saved successfully', 'success');

                    // Update the card in the list if it exists
                    const cardBtn = document.querySelector(`.job-card[onclick*="job_id=${jobId}"] button`);
                    if (cardBtn) {
                        const cardIcon = cardBtn.querySelector('i');
                        if (isSaved) {
                            cardIcon.classList.remove('fas', 'text-yellow-500');
                            cardIcon.classList.add('far');
                        } else {
                            cardIcon.classList.remove('far');
                            cardIcon.classList.add('fas', 'text-yellow-500');
                        }
                    }
                } else {
                    showToast('Action failed: ' + (data.message || 'Please try again'), 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('An error occurred. Please try again.', 'error');
            });
    }

    function showToast(message, type) {
        const toast = document.createElement('div');
        toast.className = `fixed bottom-5 right-5 px-4 py-2 rounded-md shadow-lg text-sm font-medium text-white transition-opacity duration-300 ease-in-out
                      ${type === 'success' ? 'bg-green-600' : 'bg-red-600'}`;
        toast.innerText = message;
        document.body.appendChild(toast);

        setTimeout(() => {
            toast.classList.add('opacity-0');
            setTimeout(() => {
                document.body.removeChild(toast);
            }, 300);
        }, 3000);
    }

    // Filter functionality
    function filterJobs(filterType, button) {
        // Update button states
        const filterButtons = document.querySelectorAll('[data-filter]');
        filterButtons.forEach(btn => {
            btn.classList.remove('bg-primary', 'text-white');
            btn.classList.add('bg-white', 'border-gray-300', 'text-gray-700');
        });

        // Set active button
        button.classList.remove('bg-white', 'border-gray-300', 'text-gray-700');
        button.classList.add('bg-primary', 'text-white');

        // Get all job cards
        const jobCards = document.querySelectorAll('.job-card');

        // Show all jobs first
        jobCards.forEach(card => {
            card.style.display = 'block';
        });

        // Apply filter logic
        if (filterType === 'recent') {
            // Sort by most recent (this is a simple example - you might want to implement server-side sorting)
            const jobContainer = document.querySelector('.space-y-3');
            const cards = Array.from(jobCards);

            // For demo purposes, we'll just reverse the order
            cards.reverse().forEach(card => {
                jobContainer.appendChild(card);
            });

        } else if (filterType === 'matches') {
            // Hide jobs that don't match (this is a placeholder - implement your matching logic)
            jobCards.forEach((card, index) => {
                // Example: show only every other job as "best match"
                if (index % 3 !== 0) {
                    card.style.display = 'none';
                }
            });
        }

        // Update job count
        const visibleJobs = document.querySelectorAll('.job-card[style="display: block"], .job-card:not([style*="display: none"])').length;
        const jobCountElement = document.querySelector('.text-gray-500');
        if (jobCountElement) {
            jobCountElement.textContent = `${visibleJobs} jobs`;
        }
    }
</script>