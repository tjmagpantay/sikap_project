<?php
// filepath: app/views/jobseekers/job-application/browse-jobs.php
include_once __DIR__ . '/../../components/navbar-top.php';
include_once __DIR__ . '/../navbar-jobseeker.php';
?>

<div class="px-4 py-8 sm:px-6 md:px-16 lg:px-24">
    <div class="mb-8">
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
    </div>

    <!-- Job Listings -->
    <?php if (empty($jobs)): ?>
        <div class="py-12 text-center">
            <i class="mb-4 text-6xl text-gray-400 fas fa-briefcase"></i>
            <h3 class="mb-2 text-lg font-medium text-gray-900">No jobs available</h3>
            <p class="text-gray-500">Check back later for new job postings</p>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <?php foreach ($jobs as $index => $job): ?>
                <?php
                // Prepare data for the card
                $companyName = '';
                if (!empty($job['company_name'])) {
                    $companyName = $job['company_name'];
                } elseif (!empty($job['business_name'])) {
                    $companyName = $job['business_name'];
                } elseif (isset($job['employer_first_name']) && isset($job['employer_last_name'])) {
                    $companyName = trim($job['employer_first_name'] . ' ' . $job['employer_last_name']);
                } else {
                    $companyName = 'Company';
                }

                $logo = '';
                if (!empty($job['business_logo'])) {
                    $logo = $job['business_logo'];
                } elseif (!empty($job['employer_profile_photo'])) {
                    $logo = $job['employer_profile_photo'];
                } else {
                    $logo = 'assets/logos/default.png';
                }

                if (strpos($logo, 'http') !== 0 && strpos($logo, '/') !== 0) {
                    $logo = '/' . ltrim($logo, '/');
                }

                // Calculate match percentage (placeholder logic)
                $matchPercentage = rand(75, 95);

                // Check if urgent (placeholder logic)
                $isUrgent = rand(0, 3) === 0; // 25% chance of being urgent

                // Format posted date
                $postedDate = isset($job['created_at']) ? date('M d, Y', strtotime($job['created_at'])) : 'Recently';
                ?>

                <div class="transition-shadow bg-white border border-gray-200 rounded-lg shadow-sm cursor-pointer hover:shadow-md" onclick="window.location.href='?page=view-job&job_id=<?php echo $job['job_id']; ?>'">

                    <!-- Row 1: Logo, Job Title, Business Name, Urgent Tag, Save Icon -->
                    <div class="p-4 pb-3">
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex items-start flex-1 gap-3">
                                <!-- Business Logo -->
                                <img src="<?php echo htmlspecialchars($logo); ?>"
                                    alt="<?php echo htmlspecialchars($companyName); ?>"
                                    class="flex-shrink-0 object-cover w-12 h-12 bg-gray-100 rounded-md">

                                <div class="flex-1 min-w-0">
                                    <!-- Job Title -->
                                    <h3 class="mb-1 text-base font-semibold text-gray-900 line-clamp-2">
                                        <?php echo htmlspecialchars($job['job_title']); ?>
                                    </h3>

                                    <!-- Business Name and Urgent Tag -->
                                    <div class="flex flex-wrap items-center gap-2">
                                        <span class="text-sm text-gray-600"><?php echo htmlspecialchars($companyName); ?></span>
                                        <?php if ($isUrgent): ?>
                                            <span class="px-2 py-1 text-xs font-medium text-red-600 bg-red-100 rounded">
                                                URGENT
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Save Icon -->
                            <?php if (isset($_SESSION['user_id']) && $_SESSION['role'] == 3): ?>
                                <button onclick="event.stopPropagation(); toggleSaveJob(<?php echo $job['job_id']; ?>, this)"
                                    class="save-btn p-2 rounded-md transition-colors <?php echo (isset($job['is_saved']) && $job['is_saved']) ? 'text-yellow-600 hover:bg-yellow-50' : 'text-gray-400 hover:bg-gray-50 hover:text-gray-600'; ?>"
                                    data-job-id="<?php echo $job['job_id']; ?>"
                                    data-saved="<?php echo (isset($job['is_saved']) && $job['is_saved']) ? 'true' : 'false'; ?>"
                                    title="<?php echo (isset($job['is_saved']) && $job['is_saved']) ? 'Remove from saved jobs' : 'Save job for later'; ?>">
                                    <i class="<?php echo (isset($job['is_saved']) && $job['is_saved']) ? 'fas fa-bookmark' : 'far fa-bookmark'; ?> text-lg"></i>
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Row 2: Location -->
                    <div class="px-4 pb-3">
                        <div class="flex items-center gap-2 text-sm text-gray-600">
                            <i class="text-gray-400 fas fa-map-marker-alt"></i>
                            <span><?php echo htmlspecialchars($job['location']); ?></span>
                        </div>
                    </div>

                    <!-- Row 3: Tags (Category, Employment Type, Workplace) -->
                    <div class="px-4 pb-3">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="px-2 py-1 text-xs font-medium rounded" style="background-color: #EDEEF1; color: #374151;">
                                <?php echo htmlspecialchars($job['category_name'] ?? 'General'); ?>
                            </span>
                            <span class="px-2 py-1 text-xs font-medium rounded" style="background-color: #EDEEF1; color: #374151;">
                                <?php echo htmlspecialchars(ucfirst($job['job_type'])); ?>
                            </span>
                            <span class="px-2 py-1 text-xs font-medium rounded" style="background-color: #EDEEF1; color: #374151;">
                                <?php echo htmlspecialchars($job['work_arrangement'] ?? 'On-site'); ?>
                            </span>
                        </div>
                    </div>

                    <!-- Row 4: Job Summary -->
                    <div class="px-4 pb-3">
                        <p class="text-sm text-gray-700 line-clamp-2">
                            <?php echo htmlspecialchars(substr($job['job_summary'], 0, 150)) . (strlen($job['job_summary']) > 150 ? '...' : ''); ?>
                        </p>
                    </div>

                    <!-- Row 5: Posted Date and Best Matches -->
                    <div class="px-4 py-3 border-t border-gray-100">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-500">Posted <?php echo $postedDate; ?></span>
                            <div class="flex items-center gap-1 text-green-600">
                                <div class="flex items-center justify-center w-4 h-4 border-2 border-green-600 rounded-full">
                                    <i class="text-xs fas fa-check"></i>
                                </div>
                                <span class="font-medium"><?php echo $matchPercentage; ?>% best matches</span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<script>
    function toggleSaveJob(jobId, button) {
        const isSaved = button.getAttribute('data-saved') === 'true';
        const action = isSaved ? 'unsave-job' : 'save-job';

        // Show loading state
        const icon = button.querySelector('i');
        const text = button.querySelector('.save-text');
        const originalIcon = icon.className;
        const originalText = text.textContent;

        icon.className = 'fas fa-spinner fa-spin mr-1';
        text.textContent = 'Loading...';
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
                        button.className = 'save-btn flex items-center px-2 py-1 text-xs font-medium rounded-md transition-colors text-gray-600 bg-gray-100 border border-gray-300 hover:bg-yellow-50 hover:text-yellow-600';
                        icon.className = 'far fa-bookmark mr-1';
                        text.textContent = 'Save';
                        button.title = 'Save job for later';
                    } else {
                        // Job was saved
                        button.setAttribute('data-saved', 'true');
                        button.className = 'save-btn flex items-center px-2 py-1 text-xs font-medium rounded-md transition-colors text-yellow-700 bg-yellow-100 border border-yellow-300';
                        icon.className = 'fas fa-bookmark mr-1';
                        text.textContent = 'Saved';
                        button.title = 'Remove from saved jobs';
                    }

                    // Show success toast
                    showToast(data.message || 'Job ' + (isSaved ? 'unsaved' : 'saved') + ' successfully!', 'success');
                } else {
                    // Restore original state on error
                    icon.className = originalIcon;
                    text.textContent = originalText;
                    showToast(data.message || 'Error occurred', 'error');
                }
            })
            .catch(error => {
                // Restore original state on error
                icon.className = originalIcon;
                text.textContent = originalText;
                console.error('Fetch error:', error);
                showToast('Error occurred while ' + (isSaved ? 'unsaving' : 'saving') + ' job', 'error');
            })
            .finally(() => {
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