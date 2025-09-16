<?php
include_once __DIR__ . '/components/jobseeker_auth_check.php';
include_once __DIR__ . '/../components/navbar-top.php';
include_once __DIR__ . '/navbar-jobseeker.php';
?>

<div class="min-h-screen px-4 sm:px-6 md:px-16 lg:px-24">
    <div class="py-8 mx-auto sm:px-2 md:px-4 lg:px-12 max-w-7xl">
        <!-- Breadcrumbs -->
        <nav class="mb-6">
            <div class="flex items-center space-x-2 text-sm">
                <a href="?page=dashboard" class="text-gray-500 transition-colors hover:text-primary">
                    Dashboard
                </a>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                <span class="font-medium text-primary">Saved Jobs</span>
            </div>
        </nav>

        <!-- Page Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Saved Jobs</h1>
                <p class="mt-1 text-sm text-gray-600">Jobs you've bookmarked for later</p>
            </div>
        </div>

        <!-- Saved Jobs List -->
        <?php if (empty($savedJobs)): ?>
            <div class="py-12 text-center">
                <i class="mb-4 text-6xl text-gray-400 fas fa-bookmark"></i>
                <h3 class="mb-2 text-lg font-medium text-gray-900">No saved jobs yet</h3>
                <p class="mb-6 text-gray-500">Save jobs you're interested in to view them later</p>
                <a href="?page=browse-jobs" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white border border-transparent rounded-md shadow-sm bg-primary hover:bg-secondary">
                    <i class="mr-2 fas fa-search"></i>
                    Browse Jobs
                </a>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <?php foreach ($savedJobs as $job): ?>
                    <!-- Modern card design matching browse-jobs.php -->
                    <div class="block overflow-hidden transition-all duration-300 bg-white border border-gray-200 rounded-lg hover:shadow-lg hover:border-gray-300 hover:-translate-y-1">

                        <!-- Header: Company Logo and Job Title with Gray Background -->
                        <div class="flex items-start gap-4 p-6 pb-4 bg-gray-50">
                            <img src="<?php echo !empty($job['business_logo']) ? htmlspecialchars($job['business_logo']) : 'assets/logos/default.png'; ?>"
                                alt="Company Logo"
                                class="flex-shrink-0 object-cover w-12 h-12 bg-gray-100 rounded-md">

                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-900 transition-colors hover:text-blue-600">
                                    <a href="?page=view-job&job_id=<?php echo $job['job_id']; ?>" class="hover:text-blue-600">
                                        <?php echo htmlspecialchars($job['job_title']); ?>
                                    </a>
                                </h3>
                                <p class="text-sm text-gray-600">
                                    <?php echo htmlspecialchars($job['company_name']); ?>
                                </p>
                            </div>

                            <!-- Unsave Button -->
                            <button onclick="event.preventDefault(); event.stopPropagation(); unsaveJob(<?php echo $job['job_id']; ?>)"
                                class="relative z-10 p-2 transition-colors rounded-md text-secondary hover:bg-red-50 hover:text-red-600"
                                title="Remove from saved jobs">
                                <!-- Bookmark SVG Icon (filled for saved) -->
                                <svg class="w-5 h-5" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                                </svg>
                            </button>
                        </div>

                        <!-- Card Body Content -->
                        <div class="p-6 pt-4">
                            <!-- Location -->
                            <div class="flex items-center gap-1 mb-3 text-sm text-gray-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span><?php echo htmlspecialchars($job['location']); ?></span>
                            </div>

                            <!-- Job Type and Saved Date Tags -->
                            <div class="flex flex-wrap gap-2 mb-4">
                                <span class="px-3 py-2 text-xs bg-gray-100 rounded-sm text-primary">
                                    <?php echo htmlspecialchars(ucfirst(str_replace('-', ' ', $job['job_type']))); ?>
                                </span>
                                <span class="px-3 py-2 text-xs text-yellow-700 bg-yellow-100 rounded-sm">
                                    Saved <?php echo date('M j, Y', strtotime($job['saved_at'])); ?>
                                </span>
                            </div>

                            <!-- Job Summary -->
                            <p class="mb-4 text-sm text-gray-700 line-clamp-3">
                                <?php echo htmlspecialchars(substr($job['job_summary'], 0, 150)) . (strlen($job['job_summary']) > 150 ? '...' : ''); ?>
                            </p>

                            <!-- Action Buttons -->
                            <div class="flex flex-col gap-2 mb-4">
                                <!-- Apply Button -->
                                <?php if (isset($job['has_applied']) && $job['has_applied']): ?>
                                    <span class="px-4 py-2 text-sm font-medium text-center text-white border rounded-md bg-primary">
                                        Applied
                                    </span>
                                <?php elseif ($job['job_status'] !== 'open'): ?>
                                    <span class="px-4 py-2 text-sm font-medium text-center text-gray-500 bg-gray-100 border border-gray-300 rounded-md">
                                        Not accepting applications
                                    </span>
                                <?php else: ?>
                                    <a href="?page=apply-job&job_id=<?php echo $job['job_id']; ?>&step=1"
                                        class="px-4 py-2 text-sm font-medium text-center text-white border rounded-md bg-primary hover:bg-secondary">
                                        Apply Now
                                    </a>
                                <?php endif; ?>
                            </div>

                            <!-- Footer: Posted Date -->
                            <div class="flex items-center justify-between pt-4 mt-2">
                                <span class="text-xs text-gray-500">
                                    Posted <?php echo date('M d, Y', strtotime($job['created_at'])); ?>
                                </span>

                                <?php if ($job['show_pay'] && $job['salary']): ?>
                                    <span class="text-sm font-semibold text-green-600">
                                        ₱<?php echo number_format($job['salary'], 2); ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    function unsaveJob(jobId) {
        if (!confirm('Remove this job from your saved jobs?')) {
            return;
        }

        // Find the button element
        const button = event.target.closest('button');
        const svgIcon = button.querySelector('svg');

        // Show loading state
        svgIcon.classList.add('animate-pulse');
        button.disabled = true;

        const formData = new FormData();
        formData.append('job_id', jobId);

        fetch('?page=unsave-job', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                // Check if response is ok first
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                // Check content type
                const contentType = response.headers.get('content-type');
                if (!contentType || !contentType.includes('application/json')) {
                    return response.text().then(text => {
                        console.error('Expected JSON but got:', text);
                        throw new Error('Server returned non-JSON response');
                    });
                }

                return response.json();
            })
            .then(data => {
                console.log('Server response:', data); // Debug log

                if (data.success) {
                    // Show success toast
                    showToast(data.message || 'Job removed from saved jobs successfully!', 'success');

                    // Remove the card from the DOM with fade animation
                    const card = button.closest('.grid > div');
                    if (card) {
                        card.style.transition = 'opacity 0.3s ease-out, transform 0.3s ease-out';
                        card.style.opacity = '0';
                        card.style.transform = 'scale(0.95)';

                        setTimeout(() => {
                            card.remove();

                            // Check if no saved jobs remain
                            const remainingCards = document.querySelectorAll('.grid > div');
                            if (remainingCards.length === 0) {
                                location.reload(); // Refresh to show the "no saved jobs" message
                            }
                        }, 300);
                    }
                } else {
                    showToast(data.message || 'Error removing job from saved jobs', 'error');
                }
            })
            .catch(error => {
                console.error('Fetch error:', error);
                showToast('Error occurred while removing job from saved jobs', 'error');
            })
            .finally(() => {
                svgIcon.classList.remove('animate-pulse');
                button.disabled = false;
            });
    }

    function showToast(message, type) {
        // Remove any existing toasts first
        const existingToasts = document.querySelectorAll('.toast-notification');
        existingToasts.forEach(toast => toast.remove());

        const toast = document.createElement('div');
        toast.className = `toast-notification fixed top-4 right-4 px-4 py-2 rounded-md shadow-lg z-50 transition-all duration-300 transform translate-x-0 ${
        type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
    }`;
        toast.textContent = message;

        document.body.appendChild(toast);

        // Animate in
        setTimeout(() => {
            toast.style.opacity = '1';
        }, 10);

        // Animate out and remove
        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateX(100%)';
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.parentNode.removeChild(toast);
                }
            }, 300);
        }, 3000);
    }
</script>