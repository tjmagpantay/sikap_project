<?php
include_once __DIR__ . '/../components/navbar-top.php';
include_once __DIR__ . '../components/navbar-employer.php';
?>

<div class="py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="sm:flex sm:items-center sm:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Manage Jobs</h1>
                <p class="mt-2 text-sm text-gray-600">View and manage your job postings</p>
            </div>
            <div class="mt-4 sm:mt-0">
                <a href="?page=post-job" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700">
                    <i class="mr-2 fas fa-plus"></i>
                    Post New Job
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

    <!-- Jobs Table -->
    <div class="overflow-hidden bg-white shadow sm:rounded-md">
        <?php if (empty($jobs)): ?>
            <div class="py-12 text-center">
                <i class="mb-4 text-6xl text-gray-400 fas fa-briefcase"></i>
                <h3 class="mb-2 text-lg font-medium text-gray-900">No jobs posted yet</h3>
                <p class="mb-6 text-gray-500">Start by posting your first job to attract candidates</p>
                <a href="?page=post-job" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700">
                    <i class="mr-2 fas fa-plus"></i>
                    Post Your First Job
                </a>
            </div>
        <?php else: ?>
            <ul class="divide-y divide-gray-200">
                <?php foreach ($jobs as $job): ?>
                    <li class="px-6 py-4 hover:bg-gray-50">
                        <div class="flex items-center justify-between">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center space-x-3">
                                    <h3 class="text-lg font-medium text-gray-900 truncate">
                                        <?php echo htmlspecialchars($job['job_title']); ?>
                                    </h3>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            <?php
                                            switch ($job['job_status']) {
                                                case 'open':
                                                    echo 'bg-green-100 text-green-800';
                                                    break;
                                                case 'closed':
                                                    echo 'bg-red-100 text-red-800';
                                                    break;
                                                case 'paused':
                                                    echo 'bg-yellow-100 text-yellow-800';
                                                    break;
                                                case 'draft':
                                                    echo 'bg-gray-100 text-gray-800';
                                                    break;
                                                default:
                                                    echo 'bg-gray-100 text-gray-800';
                                            }
                                            ?>">
                                        <?php echo ucfirst($job['job_status']); ?>
                                    </span>
                                </div>
                                <div class="flex items-center mt-1 space-x-4 text-sm text-gray-500">
                                    <span><i class="mr-1 fas fa-tag"></i><?php echo htmlspecialchars($job['category_name'] ?? 'N/A'); ?></span>
                                    <span><i class="mr-1 fas fa-briefcase"></i><?php echo ucfirst(str_replace('-', ' ', $job['job_type'])); ?></span>
                                    <span><i class="mr-1 fas fa-map-marker-alt"></i><?php echo htmlspecialchars($job['location']); ?></span>
                                    <span>
                                        <i class="mr-1 fas fa-users"></i>
                                        <?php echo $job['application_count']; ?> applications
                                        <?php if ($job['pending_count'] > 0): ?>
                                            <span class="ml-1 px-1.5 py-0.5 text-xs bg-yellow-100 text-yellow-800 rounded-full">
                                                <?php echo $job['pending_count']; ?> pending
                                            </span>
                                        <?php endif; ?>
                                    </span>
                                    <span><i class="mr-1 fas fa-calendar"></i>Posted <?php echo date('M j, Y', strtotime($job['created_at'])); ?></span>
                                </div>
                            </div>

                            <div class="flex items-center space-x-2">
                                <!-- View Button -->
                                <a href="?page=view-employer-job&id=<?php echo $job['job_id']; ?>"
                                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-blue-600 rounded hover:bg-blue-700"
                                    title="View Job">
                                    <i class="mr-2 fas fa-eye"></i>
                                    View Job
                                </a>

                                <!-- Edit Button -->
                                <a href="?page=edit-job&id=<?php echo $job['job_id']; ?>"
                                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-yellow-600 rounded hover:bg-yellow-700"
                                    title="Edit Job">
                                    <i class="mr-2 fas fa-edit"></i>
                                    Edit
                                </a>

                                <!-- Status Toggle -->
                                <?php if ($job['job_status'] == 'open'): ?>
                                    <a href="?page=toggle-job-status&id=<?php echo $job['job_id']; ?>&status=paused"
                                        class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-orange-600 rounded hover:bg-orange-700"
                                        title="Pause Job">
                                        <i class="mr-2 fas fa-pause"></i>
                                        Pause
                                    </a>
                                <?php elseif ($job['job_status'] == 'paused'): ?>
                                    <a href="?page=toggle-job-status&id=<?php echo $job['job_id']; ?>&status=open"
                                        class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-green-600 rounded hover:bg-green-700"
                                        title="Reopen Job">
                                        <i class="mr-2 fas fa-play"></i>
                                        Open
                                    </a>
                                <?php elseif ($job['job_status'] == 'draft'): ?>
                                    <a href="?page=edit-job&id=<?php echo $job['job_id']; ?>"
                                        class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-blue-600 rounded hover:bg-blue-700"
                                        title="Complete & Publish">
                                        <i class="mr-2 fas fa-paper-plane"></i>
                                        Publish
                                    </a>
                                <?php endif; ?>

                                <!-- Delete Button -->
                                <a href="?page=delete-job&id=<?php echo $job['job_id']; ?>"
                                    onclick="return confirm('Are you sure you want to delete \"<?php echo addslashes($job['job_title']); ?>\"?\n\nThis action cannot be undone and will remove:\n- Job posting\n- All job skills\n- Application settings\n- Screening questions\n- Job attachments')"
                                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-red-600 rounded hover:bg-red-700"
                                    title="Delete Job">
                                    <i class="mr-2 fas fa-trash"></i>
                                    Delete Job
                                </a>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</div>