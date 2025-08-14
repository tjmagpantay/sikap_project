<?php
// filepath: app/views/jobseekers/job-application/browse-jobs-clean.php
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
            <?php foreach ($jobs as $job): ?>
                <div class="p-6 bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center space-x-2">
                                <h3 class="text-xl font-semibold text-gray-900">
                                    <a href="?page=view-job&job_id=<?php echo $job['job_id']; ?>" class="hover:text-blue-600">
                                        <?php echo htmlspecialchars($job['job_title']); ?>
                                    </a>
                                </h3>
                            </div>

                            <!-- Job Type -->
                            <span class="inline-block px-3 py-1 mt-2 text-xs font-semibold rounded-full <?php echo strtolower($job['job_type']) === 'full-time' ? 'bg-blue-100 text-blue-600' : 'bg-green-100 text-green-600'; ?>">
                                <?php echo strtoupper($job['job_type']); ?>
                            </span>

                            <!-- Company Name -->
                            <div class="mt-3">
                                <?php
                                $companyName = $job['company_name'] ?? 'Company';
                                ?>
                                <p class="text-sm text-gray-600">
                                    <i class="fas fa-building mr-1"></i>
                                    <?php echo htmlspecialchars($companyName); ?>
                                </p>
                            </div>

                            <!-- Location -->
                            <?php if (!empty($job['location'])): ?>
                                <p class="text-sm text-gray-600 mt-1">
                                    <i class="fas fa-map-marker-alt mr-1"></i>
                                    <?php echo htmlspecialchars($job['location']); ?>
                                </p>
                            <?php endif; ?>

                            <!-- Salary -->
                            <?php if (isset($job['show_pay']) && $job['show_pay'] && !empty($job['salary'])): ?>
                                <p class="text-sm text-gray-600 mt-1">
                                    <i class="fas fa-dollar-sign mr-1"></i>
                                    ₱<?php echo number_format($job['salary'], 2); ?>
                                </p>
                            <?php endif; ?>

                            <!-- Job Summary -->
                            <p class="mt-3 text-sm text-gray-700 line-clamp-3">
                                <?php echo substr(htmlspecialchars($job['job_summary'] ?? ''), 0, 150) . '...'; ?>
                            </p>
                        </div>

                        <!-- Save Button -->
                        <?php if (isset($_SESSION['user_id']) && $_SESSION['role'] == 3): ?>
                            <button onclick="toggleSaveJob(<?php echo $job['job_id']; ?>, this)"
                                class="save-btn ml-2 p-2 text-gray-400 hover:text-yellow-500 transition-colors"
                                data-job-id="<?php echo $job['job_id']; ?>"
                                data-saved="<?php echo (isset($job['is_saved']) && $job['is_saved']) ? 'true' : 'false'; ?>"
                                title="<?php echo (isset($job['is_saved']) && $job['is_saved']) ? 'Remove from saved jobs' : 'Save job for later'; ?>">
                                <i class="<?php echo (isset($job['is_saved']) && $job['is_saved']) ? 'fas fa-bookmark' : 'far fa-bookmark'; ?>"></i>
                            </button>
                        <?php endif; ?>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-3 mt-4">
                        <a href="?page=view-job&job_id=<?php echo $job['job_id']; ?>"
                            class="flex-1 px-4 py-2 text-sm font-medium text-center text-blue-600 transition bg-blue-50 border border-blue-200 rounded-md hover:bg-blue-100">
                            View Details
                        </a>

                        <!-- Apply Button -->
                        <?php if (!isset($_SESSION['user_id'])): ?>
                            <a href="?page=login-jobseeker"
                                class="flex-1 px-4 py-2 text-sm font-medium text-center text-white transition bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                                Sign in to Apply
                            </a>
                        <?php elseif ($_SESSION['role'] != 3): ?>
                            <span class="flex-1 px-4 py-2 text-sm font-medium text-center text-gray-500 bg-gray-100 border border-gray-300 rounded-md">
                                Employers cannot apply
                            </span>
                        <?php elseif (isset($job['has_applied']) && $job['has_applied']): ?>
                            <span class="flex-1 px-4 py-2 text-sm font-medium text-center text-gray-500 bg-gray-100 border border-gray-300 rounded-md">
                                <i class="mr-1 fas fa-check-circle"></i>
                                Applied
                            </span>
                        <?php elseif ($job['job_status'] !== 'open'): ?>
                            <span class="flex-1 px-4 py-2 text-sm font-medium text-center text-gray-500 bg-gray-100 border border-gray-300 rounded-md">
                                Not accepting applications
                            </span>
                        <?php else: ?>
                            <a href="?page=apply-job&job_id=<?php echo $job['job_id']; ?>&step=1"
                                class="flex-1 px-4 py-2 text-sm font-medium text-center text-white transition border border-transparent rounded-md bg-green-600 hover:bg-green-700">
                                <i class="mr-1 fas fa-paper-plane"></i>
                                Apply Now
                            </a>
                        <?php endif; ?>
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
        const originalIcon = icon.className;

        icon.className = 'fas fa-spinner fa-spin';
        button.disabled = true;

        const formData = new FormData();
        formData.append('job_id', jobId);

        fetch(`?page=${action}`, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (isSaved) {
                        // Job was unsaved
                        button.setAttribute('data-saved', 'false');
                        button.className = 'save-btn ml-2 p-2 text-gray-400 hover:text-yellow-500 transition-colors';
                        icon.className = 'far fa-bookmark';
                        button.title = 'Save job for later';
                    } else {
                        // Job was saved
                        button.setAttribute('data-saved', 'true');
                        button.className = 'save-btn ml-2 p-2 text-yellow-500 hover:text-yellow-600 transition-colors';
                        icon.className = 'fas fa-bookmark';
                        button.title = 'Remove from saved jobs';
                    }
                    showToast(data.message || 'Job ' + (isSaved ? 'unsaved' : 'saved') + ' successfully!', 'success');
                } else {
                    // Restore original state on error
                    icon.className = originalIcon;
                    showToast(data.message || 'Error occurred', 'error');
                }
            })
            .catch(error => {
                // Restore original state on error
                icon.className = originalIcon;
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