<?php
include_once __DIR__ . '/../components/jobseeker_auth_check.php';
include_once __DIR__ . '/../../components/navbar-top.php';
include_once __DIR__ . '/../navbar-jobseeker.php';
?>

<div class="px-6 py-8 ">
    <div class="mx-auto max-w-7xl">
        <!-- Breadcrumbs -->
        <nav class="mb-6">
            <div class="flex items-center space-x-2 text-sm">
                <a href="?page=jobseeker-dashboard" class="text-gray-500 transition-colors hover:text-primary">
                    Dashboard
                </a>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                <span class="font-medium text-primary">Browse Jobs</span>
            </div>
        </nav>

        <!-- <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Browse Jobs</h1>
        <?php if (isset($_GET['employer_id']) && !empty($employer)): ?>
            <div class="flex items-center p-3 mt-3 border-l-4 border-blue-400 rounded-r bg-blue-50">
                <i class="mr-2 text-blue-600 fas fa-filter"></i>
                <span class="text-sm text-blue-800">
                    Showing jobs from: <strong><?php echo htmlspecialchars($employer['business_name'] ?? 'Selected Employer'); ?></strong>
                </span>
                <a href="?page=browse-jobs" class="ml-3 text-xs text-blue-600 hover:underline">Clear filter</a>
            </div>
        <?php else: ?>
            <p class="mt-2 text-sm text-gray-600">Find your perfect job opportunity</p>
        <?php endif; ?>
    </div> -->

        <!-- Job Listings -->
        <?php if (empty($jobs)): ?>
            <div class="py-12 text-center">
                <i class="mb-4 text-6xl text-gray-400 fas fa-briefcase"></i>
                <h3 class="mb-2 text-lg font-medium text-gray-900">No jobs available</h3>
                <p class="text-gray-500">Check back later for new job postings</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <?php foreach ($jobs as $index => $currentJob): ?>
                    <!-- Simple, clean job card - fully clickable -->
                    <a href="?page=view-job&job_id=<?php echo $currentJob['job_id']; ?>"
                        class="block overflow-hidden transition-all duration-300 bg-white border border-gray-200 rounded-lg cursor-pointer hover:shadow-lg hover:border-gray-300 hover:-translate-y-1">

                        <!-- Header: Company Logo and Job Title with Gray Background -->
                        <div class="flex items-start gap-4 p-6 pb-4 bg-gray-50">
                            <img src="<?php echo !empty($currentJob['business_logo']) ? htmlspecialchars($currentJob['business_logo']) : 'assets/logos/default.png'; ?>"
                                alt="Company Logo"
                                class="flex-shrink-0 object-cover w-12 h-12 bg-gray-100 rounded-md">

                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-900 transition-colors group-hover:text-blue-600">
                                    <?php echo htmlspecialchars($currentJob['job_title']); ?>
                                </h3>
                                <p class="text-sm text-gray-600">
                                    <?php
                                    echo htmlspecialchars(
                                        !empty($currentJob['company_name']) ? $currentJob['company_name'] : (!empty($currentJob['business_name']) ? $currentJob['business_name'] : (isset($currentJob['employer_first_name']) ? $currentJob['employer_first_name'] . ' ' . $currentJob['employer_last_name'] : 'Company'))
                                    );
                                    ?>
                                </p>
                            </div>

                            <!-- Save Button -->
                            <?php if (isset($_SESSION['user_id']) && $_SESSION['role'] == 3): ?>
                                <button onclick="event.preventDefault(); event.stopPropagation(); toggleSaveJob(<?php echo $currentJob['job_id']; ?>, this)"
                                    class="relative z-10 p-2 rounded-md transition-colors <?php echo (isset($currentJob['is_saved']) && $currentJob['is_saved']) ? 'text-secondary hover:bg-yellow-50' : 'text-gray-500 hover:bg-gray-100 hover:text-yellow-600'; ?>"
                                    data-job-id="<?php echo $currentJob['job_id']; ?>"
                                    data-saved="<?php echo (isset($currentJob['is_saved']) && $currentJob['is_saved']) ? 'true' : 'false'; ?>"
                                    title="<?php echo (isset($currentJob['is_saved']) && $currentJob['is_saved']) ? 'Remove from saved jobs' : 'Save job for later'; ?>">

                                    <!-- Bookmark SVG Icon -->
                                    <svg class="w-5 h-5" fill="<?php echo (isset($currentJob['is_saved']) && $currentJob['is_saved']) ? 'currentColor' : 'none'; ?>"
                                        stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                                    </svg>
                                </button>
                            <?php endif; ?>
                        </div>

                        <!-- Card Body Content -->
                        <div class="p-6 pt-4">
                            <!-- Location -->
                            <div class="flex items-center gap-1 mb-3 text-sm text-gray-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span><?php echo htmlspecialchars($currentJob['location']); ?></span>
                            </div>

                            <!-- Job Type and Category Tags -->
                            <div class="flex flex-wrap gap-2 mb-4">
                                <span class="px-3 py-2 text-xs bg-gray-100 rounded-sm text-primary">
                                    <?php echo htmlspecialchars(ucfirst($currentJob['job_type'])); ?>
                                </span>
                                <?php if (!empty($currentJob['category_name'])): ?>
                                    <span class="px-3 py-2 text-xs bg-gray-100 rounded-sm text-primary">
                                        <?php echo htmlspecialchars($currentJob['category_name']); ?>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <!-- Job Summary -->
                            <p class="mb-4 text-sm text-gray-700 line-clamp-3">
                                <?php echo htmlspecialchars(substr($currentJob['job_summary'], 0, 150)) . (strlen($currentJob['job_summary']) > 150 ? '...' : ''); ?>
                            </p>

                            <!-- Footer: Posted Date and Match Percentage -->
                            <div class="flex items-center justify-between pt-4 mt-2">
                                <span class="text-xs text-gray-500">
                                    Posted <?php echo isset($currentJob['created_at']) ? date('M d, Y', strtotime($currentJob['created_at'])) : 'Recently'; ?>
                                </span>

                                <div class="flex items-center gap-2 py-2 text-xs text-gray-500">
                                    <span>Best Match:</span>
                                    <span class="text-sm font-semibold text-primary"><?php echo htmlspecialchars($currentJob['match_percentage'] ?? '95'); ?>%</span>
                                </div>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    function toggleSaveJob(jobId, button) {
        const isSaved = button.getAttribute('data-saved') === 'true';
        const action = isSaved ? 'unsave-job' : 'save-job';

        // Show loading state
        const svgIcon = button.querySelector('svg');
        const originalFill = svgIcon.getAttribute('fill');

        // Show spinner/loading state
        svgIcon.classList.add('animate-pulse');
        button.disabled = true;

        const formData = new FormData();
        formData.append('job_id', jobId);

        fetch(`?page=${action}`, {
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
                    if (isSaved) {
                        // Job was unsaved
                        button.setAttribute('data-saved', 'false');
                        svgIcon.setAttribute('fill', 'none');
                        button.title = 'Save job for later';
                        button.className = 'relative z-10 p-2 rounded-md text-gray-500 hover:bg-gray-100 hover:text-yellow-600';
                    } else {
                        // Job was saved
                        button.setAttribute('data-saved', 'true');
                        svgIcon.setAttribute('fill', 'currentColor');
                        button.title = 'Remove from saved jobs';
                        button.className = 'relative z-10 p-2 rounded-md text-yellow-600 hover:bg-yellow-50';
                    }

                    // Show success toast
                    showToast(data.message || 'Job ' + (isSaved ? 'unsaved' : 'saved') + ' successfully!', 'success');
                } else {
                    // Restore original state on error
                    svgIcon.setAttribute('fill', originalFill);
                    showToast(data.message || 'Error occurred', 'error');
                }
            })
            .catch(error => {
                // Restore original state on error
                svgIcon.setAttribute('fill', originalFill);
                console.error('Fetch error:', error);
                showToast('Error occurred while ' + (isSaved ? 'unsaving' : 'saving') + ' job', 'error');
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