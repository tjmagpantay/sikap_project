<?php
include_once __DIR__ . '/../components/navbar-top.php';
include_once __DIR__ . '../components/navbar-employer.php';
?>

<div class="py-6 ">
    <!-- Job Status Tabs -->
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="flex flex-col items-start justify-between mb-8 sm:flex-row sm:items-center">
            <div class="flex w-full pb-2 space-x-8 border-b border-gray-200">
                <?php
                $activeTab = $_GET['job_status'] ?? 'open';
                $tabs = [
                    'open' => 'Open Jobs',
                    'draft' => 'Drafts',
                    'closed' => 'Expired'
                ];
                foreach ($tabs as $status => $label): ?>
                    <a href="?page=manage-jobs&job_status=<?php echo $status; ?>"
                        class="relative py-2 px-3 text-base font-medium border-b-2 transition-colors duration-200
                           <?php echo ($activeTab == $status)
                                ? 'border-blue-600 text-blue-700 bg-blue-50 rounded-t'
                                : 'border-transparent text-gray-500 hover:text-blue-600'; ?>">
                        <?php echo $label; ?>
                        <?php if ($activeTab == $status): ?>
                            <span class="absolute left-0 right-0 bottom-0 h-0.5 bg-blue-600 rounded"></span>
                        <?php endif; ?>
                    </a>
                <?php endforeach; ?>
            </div>
            <span class="mt-4 text-sm text-gray-500 sm:mt-0">Recent Job Post <span class="font-semibold text-gray-700">(<?php echo count($jobs); ?>)</span></span>
        </div>
    </div>

    <!-- Jobs Table -->
    <div class="px-0 mx-auto max-w-7xl sm:px-0 lg:px-0">
        <div class="overflow-x-auto">
            <table class="w-full min-w-full border-separate" style="border-spacing:0;">
                <!-- Table Header -->
                <thead class="w-full bg-primary">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-xs font-semibold tracking-wider text-left text-white uppercase">JOBS</th>
                        <th scope="col" class="px-6 py-4 text-xs font-semibold tracking-wider text-left text-white uppercase">STATUS</th>
                        <th scope="col" class="px-6 py-4 text-xs font-semibold tracking-wider text-left text-white uppercase">APPLICATIONS</th>
                        <th scope="col" class="px-6 py-4 text-xs font-semibold tracking-wider text-left text-white uppercase">ACTIONS</th>
                    </tr>
                </thead>
                <tbody class="w-full bg-white">
                    <?php
                    // Filter jobs by status
                    $filteredJobs = array_filter($jobs, function ($job) use ($activeTab) {
                        if ($activeTab == 'closed') return $job['job_status'] == 'closed';
                        return $job['job_status'] == $activeTab;
                    });
                    if (empty($filteredJobs)): ?>
                        <tr>
                            <td colspan="4" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="flex items-center justify-center w-16 h-16 mx-auto bg-gray-100 rounded-full">
                                        <i class="text-2xl text-gray-400 fas fa-briefcase"></i>
                                    </div>
                                    <h3 class="mt-4 text-lg font-medium text-gray-900">No job posts yet</h3>
                                    <p class="max-w-sm mt-2 text-sm text-gray-500">
                                        Create your first job post to start attracting qualified candidates to your company.
                                    </p>
                                    <div class="mt-6">
                                        <a href="?page=post-job"
                                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            <i class="mr-2 fas fa-plus"></i>
                                            Post Your First Job
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php else:
                        foreach ($filteredJobs as $job): ?>
                            <tr class="transition-all duration-200 border-b border-gray-200 hover:bg-gray-50 hover:border-l-4 hover:border-l-blue-500">
                                <!-- Job Info Column -->
                                <td class="px-6 py-6">
                                    <div class="w-full">
                                        <div class="mb-2 text-base font-semibold text-gray-900 ">
                                            <?php echo htmlspecialchars($job['job_title']); ?>
                                        </div>
                                        <div class="flex items-center space-x-4 text-sm text-gray-600">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium <?php
                                                                                                                                echo $job['job_type'] == 'full-time' ? 'bg-blue-100 text-blue-800' : ($job['job_type'] == 'part-time' ? 'bg-purple-100 text-purple-800' :
                                                                                                                                    'bg-green-100 text-green-800'); ?>">
                                                <?php echo ucfirst(str_replace('-', ' ', $job['job_type'])); ?>
                                            </span>
                                            <?php if ($job['job_status'] == 'open' && isset($job['application_deadline'])): ?>
                                                <span class="flex items-center text-gray-500">
                                                    <i class="mr-1 fas fa-clock"></i>
                                                    <?php
                                                    $days = (strtotime($job['application_deadline']) - time()) / 86400;
                                                    echo round($days) . ' days remaining';
                                                    ?>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                                <!-- Status Column -->
                                <td class="px-6 py-6">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                <?php
                                switch ($job['job_status']) {
                                    case 'open':
                                        echo 'bg-green-100 text-green-800';
                                        $statusText = 'Active';
                                        break;
                                    case 'closed':
                                        echo 'bg-red-100 text-red-800';
                                        $statusText = 'Expired';
                                        break;
                                    case 'draft':
                                        echo 'bg-yellow-100 text-yellow-800';
                                        $statusText = 'Draft';
                                        break;
                                    case 'paused':
                                        echo 'bg-orange-100 text-orange-800';
                                        $statusText = 'Paused';
                                        break;
                                    default:
                                        echo 'bg-gray-100 text-gray-800';
                                        $statusText = ucfirst($job['job_status']);
                                }
                                ?>">
                                        <?php echo $statusText; ?>
                                    </span>
                                </td>
                                <!-- Applications Column -->
                                <td class="px-6 py-6">
                                    <div class="text-sm font-medium text-gray-900">
                                        <?php echo $job['application_count']; ?> Applications
                                    </div>
                                </td>
                                <!-- Actions Column -->
                                <td class="px-6 py-6">
                                    <div class="flex items-center space-x-3">
                                        <a href="?page=manage-applications&job_id=<?php echo $job['job_id']; ?>"
                                            class="inline-flex items-center px-4 py-2 text-sm font-medium transition-colors duration-200 border border-transparent rounded-sm shadow-sm text-primary bg-lightBlue hover:bg-primary focus:outline-none focus:ring-2 focus:ring-offset-2">
                                            <i class="mr-2 fas fa-eye"></i>
                                            View Applications
                                        </a>
                                        <!-- Three Dots Menu -->
                                        <div class="relative" x-data="{ open: false }">
                                            <button @click="open = !open"
                                                @click.away="open = false"
                                                class="flex items-center justify-center w-10 h-10 text-gray-400 transition-colors duration-200 rounded-full hover:text-gray-600 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                                                </svg>
                                            </button>
                                            <!-- Dropdown Menu -->
                                            <div x-show="open"
                                                x-transition:enter="transition ease-out duration-100"
                                                x-transition:enter-start="transform opacity-0 scale-95"
                                                x-transition:enter-end="transform opacity-100 scale-100"
                                                x-transition:leave="transition ease-in duration-75"
                                                x-transition:leave-start="transform opacity-100 scale-100"
                                                x-transition:leave-end="transform opacity-0 scale-95"
                                                class="absolute right-0 z-10 w-48 mt-2 origin-top-right bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                                                x-cloak>
                                                <div class="py-1">
                                                    <a href="?page=promote-job&id=<?php echo $job['job_id']; ?>"
                                                        class="flex items-center px-4 py-2 text-sm text-gray-700 transition-colors duration-200 hover:bg-gray-100">
                                                        <i class="mr-3 text-blue-500 fas fa-bullhorn"></i>
                                                        Promote Job
                                                    </a>
                                                    <a href="?page=view-employer-job&id=<?php echo $job['job_id']; ?>"
                                                        class="flex items-center px-4 py-2 text-sm text-gray-700 transition-colors duration-200 hover:bg-gray-100">
                                                        <i class="mr-3 text-blue-500 fas fa-eye"></i>
                                                        View Detail
                                                    </a>
                                                    <?php if ($job['job_status'] == 'open'): ?>
                                                        <a href="?page=toggle-job-status&id=<?php echo $job['job_id']; ?>&status=closed"
                                                            class="flex items-center px-4 py-2 text-sm text-gray-700 transition-colors duration-200 hover:bg-gray-100">
                                                            <i class="mr-3 text-red-500 fas fa-times"></i>
                                                            Make it Expire
                                                        </a>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                    <?php endforeach;
                    endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>