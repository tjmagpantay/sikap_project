<?php
// filepath: app/views/jobseekers/my-applications.php
include_once __DIR__ . '/../../components/navbar-top.php';
include_once __DIR__ . '/../navbar-jobseeker.php';
?>

<div class="py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="sm:flex sm:items-center sm:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">My Applications</h1>
                <p class="mt-2 text-sm text-gray-600">Track the status of your job applications</p>
            </div>
            <div class="mt-4 sm:mt-0">
                <a href="?page=browse-jobs" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700">
                    <i class="mr-2 fas fa-search"></i>
                    Browse Jobs
                </a>
            </div>
        </div>
    </div>

    <!-- Messages -->
    <?php if (!empty($error)): ?>
        <div class="px-4 py-3 mb-4 text-red-700 bg-red-100 border border-red-400 rounded">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <div class="px-4 py-3 mb-4 text-green-700 bg-green-100 border border-green-400 rounded">
            <?php echo htmlspecialchars($success); ?>
        </div>
    <?php endif; ?>

    <!-- Applications Statistics -->
    <?php
    $totalApplications = count($applications);
    $pendingCount = count(array_filter($applications, function ($app) {
        return $app['application_status'] === 'pending';
    }));
    $reviewedCount = count(array_filter($applications, function ($app) {
        return $app['application_status'] === 'reviewed';
    }));
    $shortlistedCount = count(array_filter($applications, function ($app) {
        return $app['application_status'] === 'shortlisted';
    }));
    $rejectedCount = count(array_filter($applications, function ($app) {
        return $app['application_status'] === 'rejected';
    }));
    $hiredCount = count(array_filter($applications, function ($app) {
        return $app['application_status'] === 'hired';
    }));
    ?>

    <div class="grid grid-cols-1 gap-5 mb-8 sm:grid-cols-2 lg:grid-cols-5">
        <div class="overflow-hidden bg-white rounded-lg shadow">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="text-2xl text-gray-400 fas fa-file-alt"></i>
                    </div>
                    <div class="flex-1 w-0 ml-5">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Applications</dt>
                            <dd class="text-lg font-medium text-gray-900"><?php echo $totalApplications; ?></dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="overflow-hidden bg-white rounded-lg shadow">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="text-2xl text-yellow-400 fas fa-clock"></i>
                    </div>
                    <div class="flex-1 w-0 ml-5">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Pending</dt>
                            <dd class="text-lg font-medium text-gray-900"><?php echo $pendingCount; ?></dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="overflow-hidden bg-white rounded-lg shadow">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="text-2xl text-blue-400 fas fa-star"></i>
                    </div>
                    <div class="flex-1 w-0 ml-5">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Shortlisted</dt>
                            <dd class="text-lg font-medium text-gray-900"><?php echo $shortlistedCount; ?></dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="overflow-hidden bg-white rounded-lg shadow">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="text-2xl text-green-400 fas fa-check-circle"></i>
                    </div>
                    <div class="flex-1 w-0 ml-5">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Hired</dt>
                            <dd class="text-lg font-medium text-gray-900"><?php echo $hiredCount; ?></dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="overflow-hidden bg-white rounded-lg shadow">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="text-2xl text-red-400 fas fa-times-circle"></i>
                    </div>
                    <div class="flex-1 w-0 ml-5">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Rejected</dt>
                            <dd class="text-lg font-medium text-gray-900"><?php echo $rejectedCount; ?></dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Applications List -->
    <div class="overflow-hidden bg-white shadow sm:rounded-md">
        <?php if (empty($applications)): ?>
            <div class="py-12 text-center">
                <i class="mb-4 text-6xl text-primary fas fa-file-alt"></i>
                <h3 class="mb-2 text-lg font-medium text-gray-900">No applications yet</h3>
                <p class="mb-6 text-gray-500">Start applying for jobs to see your applications here</p>
                <a href="?page=browse-jobs" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white border border-transparent rounded-md shadow-sm bg-primary hover:bg-secondary">
                    <i class="mr-2 fas fa-search"></i>
                    Browse Jobs
                </a>
            </div>
        <?php else: ?>
            <ul class="divide-y divide-gray-200">
                <?php foreach ($applications as $application): ?>
                    <li class="px-6 py-4 transition hover:bg-primary/10">
                        <div class="flex items-center justify-between">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center space-x-3">
                                    <h3 class="text-lg font-bold truncate text-primary">
                                        <?php echo htmlspecialchars($application['job_title']); ?>
                                    </h3>

                                    <!-- Save/Unsave Button -->
                                    <button onclick="toggleSaveJob(<?php echo $application['job_id']; ?>, this)"
                                        class="save-btn flex items-center px-2 py-1 text-xs font-medium rounded-md transition-colors
                                                   <?php echo (isset($application['is_saved']) && $application['is_saved']) ? 'text-yellow-700 bg-yellow-100 border border-yellow-300' : 'text-secondary bg-secondary/10 border border-secondary hover:bg-yellow-50 hover:text-yellow-600'; ?>"
                                        data-job-id="<?php echo $application['job_id']; ?>"
                                        data-saved="<?php echo (isset($application['is_saved']) && $application['is_saved']) ? 'true' : 'false'; ?>"
                                        title="<?php echo (isset($application['is_saved']) && $application['is_saved']) ? 'Remove from saved jobs' : 'Save job for later'; ?>">
                                        <i class="<?php echo (isset($application['is_saved']) && $application['is_saved']) ? 'fas fa-bookmark' : 'far fa-bookmark'; ?> mr-1"></i>
                                        <span class="save-text"><?php echo (isset($application['is_saved']) && $application['is_saved']) ? 'Saved' : 'Save'; ?></span>
                                    </button>

                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            <?php
                                            switch ($application['application_status']) {
                                                case 'pending':
                                                    echo 'bg-yellow-100 text-yellow-800';
                                                    break;
                                                case 'reviewed':
                                                    echo 'bg-secondary/10 text-secondary';
                                                    break;
                                                case 'shortlisted':
                                                    echo 'bg-primary/10 text-primary';
                                                    break;
                                                case 'rejected':
                                                    echo 'bg-red-100 text-red-800';
                                                    break;
                                                case 'hired':
                                                    echo 'bg-green-100 text-green-800';
                                                    break;
                                                default:
                                                    echo 'bg-gray-100 text-gray-800';
                                            }
                                            ?>">
                                        <?php echo ucfirst($application['application_status']); ?>
                                    </span>
                                </div>
                                <div class="flex items-center mt-1 space-x-4 text-sm text-gray-500">
                                    <span><i class="mr-1 fas fa-building text-secondary"></i><?php echo htmlspecialchars($application['company_name'] ?? 'Company'); ?></span>
                                    <span><i class="mr-1 fas fa-briefcase text-primary"></i><?php echo ucfirst(str_replace('-', ' ', $application['job_type'])); ?></span>
                                    <span><i class="mr-1 fas fa-map-marker-alt text-secondary"></i><?php echo htmlspecialchars($application['location']); ?></span>
                                    <span><i class="mr-1 fas fa-calendar text-primary"></i>Applied <?php echo date('M j, Y', strtotime($application['applied_at'])); ?></span>
                                    <?php if ($application['reviewed_at']): ?>
                                        <span><i class="mr-1 fas fa-eye text-secondary"></i>Reviewed <?php echo date('M j, Y', strtotime($application['reviewed_at'])); ?></span>
                                    <?php endif; ?>
                                    <?php if (!empty($application['interview_date'])): ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-secondary/10 text-secondary">
                                            <i class="mr-1 fas fa-calendar"></i>
                                            Interview: <?php echo date('M j, Y g:i A', strtotime($application['interview_date'])); ?>
                                            <?php if (!empty($application['interview_location'])): ?>
                                                @ <?php echo htmlspecialchars($application['interview_location']); ?>
                                            <?php endif; ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="flex items-center space-x-2">
                                <!-- View Application Button -->
                                <a href="?page=view-application&id=<?php echo $application['application_id']; ?>"
                                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-white transition rounded bg-primary hover:bg-secondary"
                                    title="View Application">
                                    <i class="mr-2 fas fa-eye"></i>
                                    View Details
                                </a>

                                <!-- View Job Button -->
                                <a href="?page=view-job&job_id=<?php echo $application['job_id']; ?>"
                                    class="inline-flex items-center px-3 py-2 text-sm font-medium transition rounded text-primary bg-secondary/10 hover:bg-secondary/20"
                                    title="View Job">
                                    <i class="mr-2 fas fa-external-link-alt"></i>
                                    View Job
                                </a>

                                <!-- Withdraw Application (only if pending) -->
                                <?php if ($application['application_status'] === 'pending'): ?>
                                    <a href="?page=withdraw-application&id=<?php echo $application['application_id']; ?>"
                                        onclick="return confirm('Are you sure you want to withdraw your application for &quot;<?php echo htmlspecialchars($application['job_title']); ?>&quot;?\n\nThis action cannot be undone.')"
                                        class="inline-flex items-center px-3 py-2 text-sm font-medium text-white transition bg-red-600 rounded hover:bg-red-700"
                                        title="Withdraw Application">
                                        <i class="mr-2 fas fa-times"></i>
                                        Withdraw
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
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
            .then(response => response.json())
            .then(data => {
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

                    // Show toast notification
                    showToast(data.message, 'success');
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
                console.error('Error:', error);
                showToast('Error occurred while saving job', 'error');
            })
            .finally(() => {
                button.disabled = false;
            });
    }

    function showToast(message, type) {
        const toast = document.createElement('div');
        toast.className = `fixed top-4 right-4 px-4 py-2 rounded-md shadow-lg z-50 transition-opacity duration-300 ${
            type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
        }`;
        toast.textContent = message;

        document.body.appendChild(toast);

        setTimeout(() => {
            toast.style.opacity = '0';
            setTimeout(() => {
                document.body.removeChild(toast);
            }, 300);
        }, 3000);
    }
</script>