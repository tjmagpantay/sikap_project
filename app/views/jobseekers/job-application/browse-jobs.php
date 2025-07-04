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
        <div class="space-y-6">
            <?php foreach ($jobs as $job): ?>
                <div class="p-6 bg-white rounded-lg shadow">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center space-x-2">
                                <h3 class="text-xl font-semibold text-gray-900">
                                    <a href="?page=view-job&job_id=<?php echo $job['job_id']; ?>" class="hover:text-blue-600">
                                        <?php echo htmlspecialchars($job['job_title']); ?>
                                    </a>
                                </h3>
                                
                                <!-- Save/Unsave Button - Use numeric role check -->
                                <?php if (isset($_SESSION['user_id']) && $_SESSION['role'] == 3): ?>
                                    <button onclick="toggleSaveJob(<?php echo $job['job_id']; ?>, this)" 
                                            class="save-btn flex items-center px-2 py-1 text-xs font-medium rounded-md transition-colors
                                                   <?php echo (isset($job['is_saved']) && $job['is_saved']) ? 'text-yellow-700 bg-yellow-100 border border-yellow-300' : 'text-gray-600 bg-gray-100 border border-gray-300 hover:bg-yellow-50 hover:text-yellow-600'; ?>"
                                            data-job-id="<?php echo $job['job_id']; ?>"
                                            data-saved="<?php echo (isset($job['is_saved']) && $job['is_saved']) ? 'true' : 'false'; ?>"
                                            title="<?php echo (isset($job['is_saved']) && $job['is_saved']) ? 'Remove from saved jobs' : 'Save job for later'; ?>">
                                        <i class="<?php echo (isset($job['is_saved']) && $job['is_saved']) ? 'fas fa-bookmark' : 'far fa-bookmark'; ?> mr-1"></i>
                                        <span class="save-text"><?php echo (isset($job['is_saved']) && $job['is_saved']) ? 'Saved' : 'Save'; ?></span>
                                    </button>
                                <?php endif; ?>
                            </div>
                            
                            <?php 
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
                            ?>
                            <p class="mt-1 text-gray-600"><?php echo htmlspecialchars($companyName); ?></p>
                            <p class="mt-2 text-gray-700"><?php echo substr(htmlspecialchars($job['job_summary']), 0, 200) . '...'; ?></p>
                            
                            <div class="flex flex-wrap gap-4 mt-4 text-sm text-gray-500">
                                <span><i class="mr-1 fas fa-map-marker-alt"></i><?php echo htmlspecialchars($job['location']); ?></span>
                                <span><i class="mr-1 fas fa-briefcase"></i><?php echo ucfirst(str_replace('-', ' ', $job['job_type'])); ?></span>
                                <?php if ($job['show_pay'] && $job['salary']): ?>
                                    <span><i class="mr-1 fas fa-money-bill"></i>₱<?php echo number_format($job['salary'], 2); ?></span>
                                <?php endif; ?>
                                <span><i class="mr-1 fas fa-calendar"></i><?php echo date('M j, Y', strtotime($job['created_at'])); ?></span>
                            </div>
                        </div>
                        
                        <div class="flex flex-col ml-6 space-y-2">
                            <a href="?page=view-job&job_id=<?php echo $job['job_id']; ?>" 
                               class="px-4 py-2 text-sm font-medium text-center text-blue-600 bg-blue-100 border border-blue-300 rounded-md hover:bg-blue-200">
                                View Details
                            </a>
                            
                            <!-- Apply Button - Use numeric role check -->
                            <?php if (!isset($_SESSION['user_id'])): ?>
                                <a href="?page=login-jobseeker" 
                                   class="px-4 py-2 text-sm font-medium text-center text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
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
                                   class="px-4 py-2 text-sm font-medium text-center text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                                    <i class="mr-1 fas fa-paper-plane"></i>
                                    Apply Now
                                </a>
                            <?php endif; ?>
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