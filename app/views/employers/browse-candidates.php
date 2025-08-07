<?php
include_once __DIR__ . '/../components/navbar-top.php';
include_once __DIR__ . '../components/navbar-employer.php';
?>

<div class="min-h-screen bg-white">
    <div class="px-4 py-8 sm:px-6 md:px-16 lg:px-24">
        <div class="mx-auto max-w-7xl">
            <!-- Header Section -->
            <div class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-900">Browse Candidates</h2>
                <p class="mt-1 text-sm text-gray-600">Review applicants organized by job posts</p>
            </div>

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 gap-6 mb-8 sm:grid-cols-2 lg:grid-cols-4">
                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                    <div class="text-2xl font-bold text-gray-900"><?php echo count($jobGroups ?? []); ?></div>
                    <div class="text-sm text-gray-500">Active Job Posts</div>
                </div>
                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                    <div class="text-2xl font-bold text-gray-900"><?php echo array_sum(array_map('count', $jobGroups ?? [])); ?></div>
                    <div class="text-sm text-gray-500">Total Applications</div>
                </div>
                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                    <div class="text-2xl font-bold text-yellow-600">
                        <?php
                        $pendingCount = 0;
                        foreach ($jobGroups ?? [] as $applicants) {
                            $pendingCount += count(array_filter($applicants, function ($app) {
                                return $app['application_status'] == 'pending';
                            }));
                        }
                        echo $pendingCount;
                        ?>
                    </div>
                    <div class="text-sm text-gray-500">Pending Reviews</div>
                </div>
                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                    <div class="text-2xl font-bold text-green-600">
                        <?php
                        $acceptedCount = 0;
                        foreach ($jobGroups ?? [] as $applicants) {
                            $acceptedCount += count(array_filter($applicants, function ($app) {
                                return $app['application_status'] == 'accepted';
                            }));
                        }
                        echo $acceptedCount;
                        ?>
                    </div>
                    <div class="text-sm text-gray-500">Accepted</div>
                </div>
            </div>

            <!-- Job Posts with Applicants -->
            <?php if (empty($jobGroups)): ?>
                <div class="p-12 text-center bg-white border border-gray-200 rounded-lg shadow-sm">
                    <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 bg-gray-100 rounded-full">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h3 class="mb-2 text-lg font-medium text-gray-900">No Applications Yet</h3>
                    <p class="text-gray-500">Applications will appear here once candidates apply to your job posts.</p>
                </div>
            <?php else: ?>
                <?php foreach ($jobGroups as $jobTitle => $applicants): ?>
                    <div class="mb-8 bg-white border border-gray-200 rounded-lg shadow-sm">
                        <!-- Job Post Header -->
                        <div class="px-6 py-4 border-b border-gray-200">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="flex items-center justify-center w-10 h-10 mr-4 rounded-lg bg-primary">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 00-2 2H8a2 2 0 00-2-2V6m8 0H8m0 0v-.5A.5.5 0 018.5 5h7a.5.5 0 01.5.5V6m-8 0V6a2 2 0 012-2h4a2 2 0 012 2v0" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900"><?php echo htmlspecialchars($jobTitle); ?></h3>
                                        <p class="text-sm text-gray-500"><?php echo count($applicants); ?> applicant<?php echo count($applicants) != 1 ? 's' : ''; ?></p>
                                    </div>
                                </div>

                                <!-- Status Summary -->
                                <div class="flex items-center space-x-4">
                                    <?php
                                    $pending = count(array_filter($applicants, function ($app) {
                                        return $app['application_status'] == 'pending';
                                    }));
                                    $accepted = count(array_filter($applicants, function ($app) {
                                        return $app['application_status'] == 'accepted';
                                    }));
                                    $rejected = count(array_filter($applicants, function ($app) {
                                        return $app['application_status'] == 'rejected';
                                    }));
                                    ?>
                                    <?php if ($pending > 0): ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <?php echo $pending; ?> Pending
                                        </span>
                                    <?php endif; ?>
                                    <?php if ($accepted > 0): ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <?php echo $accepted; ?> Accepted
                                        </span>
                                    <?php endif; ?>
                                    <?php if ($rejected > 0): ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <?php echo $rejected; ?> Rejected
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Applicants List -->
                        <div class="overflow-hidden">
                            <div class="divide-y divide-gray-200">
                                <?php foreach ($applicants as $app): ?>
                                    <div class="p-6 transition-colors duration-200 hover:bg-gray-50">
                                        <div class="flex items-center justify-between">
                                            <!-- Applicant Info -->
                                            <div class="flex items-center flex-1">
                                                <?php if (!empty($app['profile_picture'])): ?>
                                                    <img src="<?php echo htmlspecialchars($app['profile_picture']); ?>" alt="Profile" class="object-cover w-12 h-12 mr-4 border border-gray-200 rounded-full">
                                                <?php else: ?>
                                                    <div class="flex items-center justify-center w-12 h-12 mr-4 bg-gray-100 rounded-full">
                                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                        </svg>
                                                    </div>
                                                <?php endif; ?>

                                                <div class="flex-1 min-w-0">
                                                    <div class="flex items-center justify-between">
                                                        <div>
                                                            <p class="text-sm font-medium text-gray-900">
                                                                <?php echo htmlspecialchars($app['first_name'] . ' ' . $app['last_name']); ?>
                                                            </p>
                                                            <?php if (!empty($app['email'])): ?>
                                                                <p class="text-sm text-gray-500"><?php echo htmlspecialchars($app['email']); ?></p>
                                                            <?php endif; ?>
                                                        </div>

                                                        <!-- Applied Date -->
                                                        <div class="text-right">
                                                            <p class="text-sm text-gray-900"><?php echo date('M j, Y', strtotime($app['applied_at'])); ?></p>
                                                            <p class="text-xs text-gray-500"><?php echo date('g:i A', strtotime($app['applied_at'])); ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Status and Actions -->
                                            <div class="flex items-center ml-4 space-x-4">
                                                <!-- Status Badge -->
                                                <div class="flex items-center">
                                                    <?php
                                                    switch ($app['application_status']) {
                                                        case 'pending':
                                                            echo '<div class="flex items-center justify-center w-6 h-6 mr-2 border-2 border-yellow-500 rounded-full">
                                                                    <svg class="w-3 h-3 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                    </svg>
                                                                </div>';
                                                            echo '<span class="text-sm font-medium text-yellow-600">Pending</span>';
                                                            break;
                                                        case 'accepted':
                                                            echo '<div class="flex items-center justify-center w-6 h-6 mr-2 border-2 border-green-600 rounded-full">
                                                                    <svg class="w-3 h-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                                    </svg>
                                                                </div>';
                                                            echo '<span class="text-sm font-medium text-green-600">Accepted</span>';
                                                            break;
                                                        case 'rejected':
                                                            echo '<div class="flex items-center justify-center w-6 h-6 mr-2 border-2 border-red-600 rounded-full">
                                                                    <svg class="w-3 h-3 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                                    </svg>
                                                                </div>';
                                                            echo '<span class="text-sm font-medium text-red-600">Rejected</span>';
                                                            break;
                                                        default:
                                                            echo '<div class="flex items-center justify-center w-6 h-6 mr-2 border-2 border-gray-400 rounded-full">
                                                                    <svg class="w-3 h-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                    </svg>
                                                                </div>';
                                                            echo '<span class="text-sm font-medium text-gray-600">' . ucfirst($app['application_status']) . '</span>';
                                                    }
                                                    ?>
                                                </div>

                                                <!-- Action Buttons -->
                                                <div class="flex items-center space-x-2">
                                                    <a href="?page=review-application&application_id=<?php echo $app['application_id']; ?>"
                                                        class="inline-flex items-center px-3 py-2 text-sm font-medium transition-colors duration-200 bg-gray-100 rounded-md text-primary hover:bg-primary hover:text-white">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                        </svg>
                                                        Review
                                                    </a>

                                                    <!-- Quick Actions Dropdown -->
                                                    <div class="relative" x-data="{ open: false }">
                                                        <button @click="open = !open" @click.away="open = false"
                                                            class="flex items-center justify-center w-8 h-8 text-gray-400 transition-colors duration-200 rounded-md hover:text-gray-600 hover:bg-gray-100">
                                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                                <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                                                            </svg>
                                                        </button>

                                                        <div x-show="open" x-transition:enter="transition ease-out duration-100"
                                                            x-transition:enter-start="transform opacity-0 scale-95"
                                                            x-transition:enter-end="transform opacity-100 scale-100"
                                                            x-transition:leave="transition ease-in duration-75"
                                                            x-transition:leave-start="transform opacity-100 scale-100"
                                                            x-transition:leave-end="transform opacity-0 scale-95"
                                                            class="absolute right-0 z-10 w-48 mt-1 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5" x-cloak>
                                                            <div class="py-1">
                                                                <?php if ($app['application_status'] == 'pending'): ?>
                                                                    <a href="?page=accept-application&application_id=<?php echo $app['application_id']; ?>"
                                                                        class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                                        <svg class="w-4 h-4 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                                        </svg>
                                                                        Accept
                                                                    </a>
                                                                    <a href="?page=reject-application&application_id=<?php echo $app['application_id']; ?>"
                                                                        class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                                        <svg class="w-4 h-4 mr-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                                        </svg>
                                                                        Reject
                                                                    </a>
                                                                <?php endif; ?>
                                                                <a href="?page=view-candidate&candidate_id=<?php echo $app['jobseeker_id']; ?>"
                                                                    class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                                    <svg class="w-4 h-4 mr-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                                    </svg>
                                                                    View Profile
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>