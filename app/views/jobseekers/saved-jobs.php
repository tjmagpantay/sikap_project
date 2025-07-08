<?php
// filepath: c:\xampp\htdocs\sikap\app\views\jobseekers\saved-jobs.php
include_once __DIR__ . '/../components/navbar-top.php';
include_once __DIR__ . '/navbar-jobseeker.php';
?>

<div class="py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="sm:flex sm:items-center sm:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Saved Jobs</h1>
                <p class="mt-2 text-sm text-gray-600">Jobs you've saved for later</p>
            </div>
            <div class="mt-4 sm:mt-0">
                <a href="?page=browse-jobs" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700">
                    <i class="mr-2 fas fa-search"></i>
                    Browse More Jobs
                </a>
            </div>
        </div>
    </div>

    <!-- Saved Jobs List -->
    <?php if (empty($savedJobs)): ?>
        <div class="py-12 text-center">
            <i class="mb-4 text-6xl text-gray-400 fas fa-bookmark"></i>
            <h3 class="mb-2 text-lg font-medium text-gray-900">No saved jobs yet</h3>
            <p class="mb-6 text-gray-500">Save jobs you're interested in to view them later</p>
            <a href="?page=browse-jobs" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700">
                <i class="mr-2 fas fa-search"></i>
                Browse Jobs
            </a>
        </div>
    <?php else: ?>
        <div class="space-y-6">
            <?php foreach ($savedJobs as $job): ?>
                <div class="p-6 bg-white rounded-lg shadow">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center space-x-2">
                                <h3 class="text-xl font-semibold text-gray-900">
                                    <a href="?page=view-job&job_id=<?php echo $job['job_id']; ?>" class="hover:text-blue-600">
                                        <?php echo htmlspecialchars($job['job_title']); ?>
                                    </a>
                                </h3>
                                <span class="text-xs text-gray-500">
                                    Saved <?php echo date('M j, Y', strtotime($job['saved_at'])); ?>
                                </span>
                            </div>
                            
                            <p class="mt-1 text-gray-600"><?php echo htmlspecialchars($job['company_name']); ?></p>
                            <p class="mt-2 text-gray-700"><?php echo substr(htmlspecialchars($job['job_summary']), 0, 200) . '...'; ?></p>
                            
                            <div class="flex flex-wrap gap-4 mt-4 text-sm text-gray-500">
                                <span><i class="mr-1 fas fa-map-marker-alt"></i><?php echo htmlspecialchars($job['location']); ?></span>
                                <span><i class="mr-1 fas fa-briefcase"></i><?php echo ucfirst(str_replace('-', ' ', $job['job_type'])); ?></span>
                                <?php if ($job['show_pay'] && $job['salary']): ?>
                                    <span><i class="mr-1 fas fa-money-bill"></i>₱<?php echo number_format($job['salary'], 2); ?></span>
                                <?php endif; ?>
                                <span><i class="mr-1 fas fa-calendar"></i>Posted <?php echo date('M j, Y', strtotime($job['created_at'])); ?></span>
                            </div>
                        </div>
                        
                        <div class="flex flex-col ml-6 space-y-2">
                            <!-- Unsave Button -->
                            <button onclick="unsaveJob(<?php echo $job['job_id']; ?>)" 
                                    class="px-4 py-2 text-sm font-medium text-red-600 bg-red-100 border border-red-300 rounded-md hover:bg-red-200"
                                    title="Remove from saved jobs">
                                <i class="mr-1 fas fa-bookmark"></i>
                                Unsave
                            </button>
                            
                            <a href="?page=view-job&job_id=<?php echo $job['job_id']; ?>" 
                               class="px-4 py-2 text-sm font-medium text-blue-600 bg-blue-100 border border-blue-300 rounded-md hover:bg-blue-200 text-center">
                                View Details
                            </a>
                            
                            <!-- Apply Button -->
                            <?php if (isset($job['has_applied']) && $job['has_applied']): ?>
                                <span class="px-4 py-2 text-sm font-medium text-gray-500 bg-gray-100 border border-gray-300 rounded-md text-center">
                                    <i class="mr-1 fas fa-check-circle"></i>
                                    Applied
                                </span>
                            <?php elseif ($job['job_status'] !== 'open'): ?>
                                <span class="px-4 py-2 text-sm font-medium text-gray-500 bg-gray-100 border border-gray-300 rounded-md text-center">
                                    Not accepting applications
                                </span>
                            <?php else: ?>
                                <a href="?page=apply-job&job_id=<?php echo $job['job_id']; ?>&step=1" 
                                   class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 text-center">
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
function unsaveJob(jobId) {
    if (!confirm('Remove this job from your saved jobs?')) {
        return;
    }

    const formData = new FormData();
    formData.append('job_id', jobId);

    fetch('?page=unsave-job', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload(); // Refresh to remove the job from the list
        } else {
            alert(data.message || 'Error removing job from saved jobs');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error removing job from saved jobs');
    });
}
</script>