<?php
// filepath: app/views/jobseekers/job-application/browse-jobs.php
include_once __DIR__ . '/../../components/navbar-top.php';
include_once __DIR__ . '/../navbar-jobseeker.php';
?>

<div class="py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Browse Jobs</h1>
        <p class="mt-2 text-sm text-gray-600">Find your perfect job opportunity</p>
    </div>

    <!-- Job Listings -->
    <?php if (empty($jobs)): ?>
        <div class="py-12 text-center">
            <i class="mb-4 text-6xl text-gray-400 fas fa-briefcase"></i>
            <h3 class="mb-2 text-lg font-medium text-gray-900">No jobs available</h3>
            <p class="text-gray-500">Check back later for new job postings</p>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3">
            <?php foreach ($jobs as $job): ?>
                <div class="flex flex-col justify-between h-full p-5 transition-all bg-white border border-gray-100 shadow job-card rounded-xl hover:shadow-lg">
                    <div>
                        <div class="flex items-start justify-between mb-2">
                            <h3 class="text-base font-semibold text-gray-900">
                                <a href="?page=view-job&job_id=<?php echo $job['job_id']; ?>" class="hover:text-blue-600">
                                    <?php echo htmlspecialchars($job['job_title']); ?>
                                </a>
                            </h3>
                            <!-- Save/Unsave Button -->
                            <?php if (isset($_SESSION['user_id']) && $_SESSION['role'] == 3): ?>
                                <button onclick="toggleSaveJob(<?php echo $job['job_id']; ?>, this)"
                                    class="save-btn flex items-center px-2 py-1 text-xs font-medium rounded-md transition-colors <?php echo (isset($job['is_saved']) && $job['is_saved']) ? 'text-yellow-700 bg-yellow-100 border border-yellow-300' : 'text-gray-600 bg-gray-100 border border-gray-300 hover:bg-yellow-50 hover:text-yellow-600'; ?>"
                                    data-job-id="<?php echo $job['job_id']; ?>"
                                    data-saved="<?php echo (isset($job['is_saved']) && $job['is_saved']) ? 'true' : 'false'; ?>"
                                    title="<?php echo (isset($job['is_saved']) && $job['is_saved']) ? 'Remove from saved jobs' : 'Save job for later'; ?>">
                                    <i class="<?php echo (isset($job['is_saved']) && $job['is_saved']) ? 'fas fa-bookmark mr-1' : 'far fa-bookmark mr-1'; ?>"></i>
                                    <span class="save-text"><?php echo (isset($job['is_saved']) && $job['is_saved']) ? 'Saved' : 'Save'; ?></span>
                                </button>
                            <?php endif; ?>
                        </div>

                        <span class="inline-block px-2 py-1 text-xs font-semibold rounded <?php echo strtolower($job['job_type']) === 'full-time' ? 'bg-blue-100 text-blue-600' : 'bg-green-100 text-green-600'; ?>">
                            <?php echo strtoupper($job['job_type']); ?>
                        </span>
                        <?php if ($job['show_pay'] && $job['salary']): ?>
                            <span class="block mt-1 mb-2 text-xs text-gray-600">Salary: ₱<?php echo number_format($job['salary'], 2); ?></span>
                        <?php endif; ?>

                        <?php
                        // Determine company name
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

                        // Determine company/employer logo or profile photo
                        $logo = '';
                        if (!empty($job['business_logo'])) {
                            $logo = $job['business_logo'];
                        } elseif (!empty($job['employer_profile_photo'])) {
                            $logo = $job['employer_profile_photo'];
                        } else {
                            $logo = 'assets/logos/default.png'; // fallback
                        }

                        // If the logo path is not absolute, prepend your base URL or public path if needed
                        if (strpos($logo, 'http') !== 0 && strpos($logo, '/') !== 0) {
                            $logo = '/app/' . ltrim($logo, '/');
                        }
                        ?>
                        <div class="flex items-center gap-2 mt-2">
                            <img src="<?php echo htmlspecialchars($logo); ?>"
                                alt="<?php echo htmlspecialchars($companyName); ?>"
                                class="object-cover bg-gray-100 rounded-md"
                                style="width:48px; height:48px; min-width:48px; min-height:48px; max-width:48px; max-height:48px;">
                            <div>
                                <p class="text-xs font-medium text-gray-800"><?php echo htmlspecialchars($companyName); ?></p>
                                <p class="text-xs text-gray-500"><?php echo htmlspecialchars($job['location']); ?></p>
                            </div>
                        </div>
                        <p class="mt-3 text-sm text-gray-700"><?php echo substr(htmlspecialchars($job['job_summary']), 0, 120) . '...'; ?></p>
                    </div>
                    <div class="flex flex-col gap-2 mt-4">
                        <a href="?page=view-job&job_id=<?php echo $job['job_id']; ?>"
                            class="px-4 py-2 text-sm font-medium text-center text-blue-600 transition bg-blue-100 border border-blue-300 rounded-md hover:bg-blue-200">
                            View Details
                        </a>
                        <!-- Apply Button -->
                        <?php if (!isset($_SESSION['user_id'])): ?>
                            <a href="?page=login-jobseeker"
                                class="px-4 py-2 text-sm font-medium text-center text-white transition bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                                Sign in to Apply
                            </a>
                        <?php elseif ($_SESSION['role'] != 3): ?>
                            <span class="px-4 py-2 text-sm font-medium text-center text-gray-500 bg-gray-100 border border-gray-300 rounded-md">
                                Employers cannot apply
                            </span>
                        <?php elseif (isset($job['has_applied']) && $job['has_applied']): ?>
                            <span class="px-4 py-2 text-sm font-medium text-center text-gray-500 bg-gray-100 border border-gray-300 rounded-md">
                                <i class="mr-1 fas fa-check-circle"></i>
                                Applied
                            </span>
                        <?php elseif ($job['job_status'] !== 'open'): ?>
                            <span class="px-4 py-2 text-sm font-medium text-center text-gray-500 bg-gray-100 border border-gray-300 rounded-md">
                                Not accepting applications
                            </span>
                        <?php else: ?>
                            <a href="?page=apply-job&job_id=<?php echo $job['job_id']; ?>&step=1"
                                class="px-4 py-2 text-sm font-medium text-center text-white transition border border-transparent rounded-md bg-primary hover:bg-primary">
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