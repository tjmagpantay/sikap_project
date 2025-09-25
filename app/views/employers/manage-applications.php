<?php
include_once __DIR__ . '/components/employer_auth_check.php';
include_once __DIR__ . '/../components/navbar-top.php';
include_once __DIR__ . '/components/navbar-employer.php';
?>

<div class="min-h-screen px-4 py-8 sm:px-6 md:px-16 lg:px-24">
    <div class="mx-auto max-w-7xl">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Manage Applications</h1>
            <p class="mt-2 text-gray-600">Review and manage job applications from candidates</p>
        </div>

        <!-- Table Container -->
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
            <!-- Table Header -->
            <div class="px-6 py-5 border-b border-gray-200">
                <div class="flex flex-col items-start gap-4 lg:flex-row lg:items-center lg:justify-between lg:space-y-0">
                    <!-- Left side: Title and Count -->
                    <div class="flex items-center ">
                        <h3 class="text-xl font-semibold text-gray-900">
                            All Applications
                        </h3>
                        <span class="ml-3 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                            <?php echo count($applicants ?? []); ?>
                        </span>
                    </div>

                    <!-- Right side: Actions -->
                    <div class="flex items-center space-x-3">
                        <!-- Export Button -->
                        <button class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Export
                        </button>
                    </div>
                </div>
            </div>

            <!-- Desktop Table View (Hidden on Mobile) -->
            <div class="hidden w-full overflow-visible lg:px-0 lg:block">
                <table class="w-full divide-y divide-gray-300 table-fixed">
                    <thead class="bg-primary">
                        <tr>
                            <th class="w-2/5 px-6 py-4 text-sm tracking-wider text-left text-white uppercase">
                                Applicant
                            </th>
                            <th class="w-1/6 px-6 py-4 text-sm tracking-wider text-left text-white uppercase">
                                Applied Date
                            </th>
                            <th class="w-1/6 px-6 py-4 text-sm tracking-wider text-left text-white uppercase">
                                Status
                            </th>
                            <th class="w-1/4 px-6 py-4 text-sm tracking-wider text-left text-white uppercase">
                                Actionswhite
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php if (empty($applicants)): ?>
                            <tr>
                                <td colspan="4" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="flex items-center justify-center w-16 h-16 mx-auto bg-gray-100 rounded-full">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                        </div>
                                        <h3 class="mt-4 text-lg font-medium text-gray-900">No applications yet</h3>
                                        <p class="max-w-sm mt-2 text-sm text-gray-500">
                                            Applications will appear here once candidates apply to your job posts.
                                        </p>
                                        <a href="?page=post-job" class="inline-flex items-center px-4 py-2 mt-4 text-sm font-medium text-white rounded-sm bg-primary hover:bg-blue-700">
                                            Post New Job
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($applicants as $app): ?>
                                <tr class="transition-colors duration-200 hover:bg-gray-50">
                                    <!-- Applicant Info -->
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <?php if (!empty($app['profile_picture'])): ?>
                                                <img src="<?php echo htmlspecialchars($app['profile_picture']); ?>"
                                                    alt="Profile"
                                                    class="object-cover w-12 h-12 mr-4 border-2 border-gray-200 rounded-full shadow-sm">
                                            <?php else: ?>
                                                <div class="flex items-center justify-center w-12 h-12 mr-4 bg-gray-200 rounded-full">
                                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                    </svg>
                                                </div>
                                            <?php endif; ?>
                                            <div class="flex-1 min-w-0">
                                                <div class="text-sm font-semibold text-gray-900">
                                                    <?php echo htmlspecialchars($app['first_name'] . ' ' . $app['last_name']); ?>
                                                </div>
                                                <?php if (!empty($app['email'])): ?>
                                                    <div class="text-xs text-gray-500 truncate">
                                                        <?php echo htmlspecialchars($app['email']); ?>
                                                    </div>
                                                <?php endif; ?>
                                                <?php if (!empty($app['job_title'])): ?>
                                                    <div class="text-xs font-medium text-blue-600">
                                                        Applied for: <?php echo htmlspecialchars($app['job_title']); ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </td>
                                    <!-- Applied Date -->
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            <?php echo date('M j, Y', strtotime($app['applied_at'])); ?>
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            <?php echo date('g:i A', strtotime($app['applied_at'])); ?>
                                        </div>
                                    </td>
                                    <!-- Status -->
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full
                                        <?php
                                        switch ($app['application_status']) {
                                            case 'pending':
                                                echo 'text-amber-800 bg-amber-100 border border-amber-200';
                                                break;
                                            case 'accepted':
                                                echo 'text-green-800 bg-green-100 border border-green-200';
                                                break;
                                            case 'rejected':
                                                echo 'text-red-800 bg-red-100 border border-red-200';
                                                break;
                                            case 'reviewing':
                                                echo 'text-blue-800 bg-blue-100 border border-blue-200';
                                                break;
                                            default:
                                                echo 'text-gray-800 bg-gray-100 border border-gray-200';
                                        }
                                        ?>">
                                            <span class="w-1.5 h-1.5 mr-1.5 rounded-full
                                            <?php
                                            switch ($app['application_status']) {
                                                case 'pending':
                                                    echo 'bg-amber-400';
                                                    break;
                                                case 'accepted':
                                                    echo 'bg-green-400';
                                                    break;
                                                case 'rejected':
                                                    echo 'bg-red-400';
                                                    break;
                                                case 'reviewing':
                                                    echo 'bg-blue-400';
                                                    break;
                                                default:
                                                    echo 'bg-gray-400';
                                            }
                                            ?>"></span>
                                            <?php echo ucfirst($app['application_status']); ?>
                                        </span>
                                    </td>
                                    <!-- Actions -->
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <a href="?page=review-application&application_id=<?php echo $app['application_id']; ?>"
                                                class="inline-flex items-center px-4 py-2 text-xs font-medium text-white transition-colors duration-200 border border-transparent rounded-md bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                Review
                                            </a>

                                            <!-- Quick Action Buttons -->
                                            <?php if ($app['application_status'] === 'pending'): ?>
                                                <button class="inline-flex items-center px-4 py-2 text-xs font-medium text-white transition-colors duration-200 border border-transparent rounded-md bg-secondary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primar">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                    Accept
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Mobile Card View (Visible on Mobile Only) -->
            <div class="px-4 space-y-4 lg:px-0 lg:hidden">
                <?php if (empty($applicants)): ?>
                    <div class="px-6 py-16 text-center">
                        <div class="flex flex-col items-center">
                            <div class="flex items-center justify-center w-16 h-16 mx-auto bg-gray-100 rounded-full">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <h3 class="mt-4 text-lg font-medium text-gray-900">No applications yet</h3>
                            <p class="max-w-sm mt-2 text-sm text-center text-gray-500">
                                Applications will appear here once candidates apply to your job posts.
                            </p>
                            <a href="?page=post-job" class="inline-flex items-center px-4 py-2 mt-4 text-sm font-medium text-white rounded-sm bg-primary hover:bg-blue-700">
                                Post New Job
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                    <?php foreach ($applicants as $app): ?>
                        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm">
                            <!-- Applicant Header -->
                            <div class="flex items-center mb-4">
                                <?php if (!empty($app['profile_picture'])): ?>
                                    <img src="<?php echo htmlspecialchars($app['profile_picture']); ?>"
                                        alt="Profile"
                                        class="object-cover w-12 h-12 mr-3 border-2 border-gray-200 rounded-full shadow-sm">
                                <?php else: ?>
                                    <div class="flex items-center justify-center w-12 h-12 mr-3 bg-gray-200 rounded-full">
                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                <?php endif; ?>
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-sm font-semibold text-gray-900">
                                        <?php echo htmlspecialchars($app['first_name'] . ' ' . $app['last_name']); ?>
                                    </h4>
                                    <?php if (!empty($app['email'])): ?>
                                        <p class="text-xs text-gray-500 truncate"><?php echo htmlspecialchars($app['email']); ?></p>
                                    <?php endif; ?>
                                </div>
                                <!-- Status Badge -->
                                <span class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full
                                <?php
                                switch ($app['application_status']) {
                                    case 'pending':
                                        echo 'text-amber-800 bg-amber-100';
                                        break;
                                    case 'accepted':
                                        echo 'text-green-800 bg-green-100';
                                        break;
                                    case 'rejected':
                                        echo 'text-red-800 bg-red-100';
                                        break;
                                    case 'reviewing':
                                        echo 'text-blue-800 bg-blue-100';
                                        break;
                                    default:
                                        echo 'text-gray-800 bg-gray-100';
                                }
                                ?>">
                                    <?php echo ucfirst($app['application_status']); ?>
                                </span>
                            </div>

                            <!-- Application Details -->
                            <div class="grid grid-cols-2 gap-4 mb-4 text-sm">
                                <div>
                                    <dt class="font-medium text-gray-500">Applied Date</dt>
                                    <dd class="text-gray-900"><?php echo date('M j, Y', strtotime($app['applied_at'])); ?></dd>
                                </div>
                                <?php if (!empty($app['job_title'])): ?>
                                    <div>
                                        <dt class="font-medium text-gray-500">Position</dt>
                                        <dd class="text-gray-900 truncate"><?php echo htmlspecialchars($app['job_title']); ?></dd>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Actions -->
                            <div class="flex items-center space-x-2">
                                <a href="?page=review-application&application_id=<?php echo $app['application_id']; ?>"
                                    class="inline-flex items-center justify-center flex-1 px-3 py-2 text-sm font-medium text-white border border-transparent rounded-sm bg-primary hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Review Application
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Alpine.js -->
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>