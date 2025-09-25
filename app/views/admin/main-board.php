<?php
// Remove this line completely - dashboard.php already handles auth
// include_once __DIR__ . '/components/admin_auth_check.php';
?>

<!-- Content-only dashboard - no HTML structure, no auth check -->
<div class="space-y-6">
    <!-- Greeting Section -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <!-- Left side: Greeting -->
            <div>
                <h2 class="text-2xl font-bold text-gray-900">
                    Good morning, <?php echo isset($_SESSION['admin_name']) ? htmlspecialchars($_SESSION['admin_name']) : 'Admin'; ?>
                </h2>
                <p class="mt-1 text-sm text-gray-600">
                    Here is your SIKAP platform overview and statistics from <?php echo date('M j', strtotime('-7 days')); ?> - <?php echo date('M j'); ?>
                </p>
            </div>

            <!-- Right side: Current Date (Philippine Time) -->
            <div class="flex items-center">
                <button class="flex items-center px-4 py-3 text-sm font-medium text-gray-700 transition-colors duration-200 bg-white border border-gray-300 rounded-sm shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary">
                    <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <?php
                    date_default_timezone_set('Asia/Manila');
                    echo date('M j, Y'); // Example: Sep 22, 2025
                    ?>
                </button>
            </div>

        </div>
    </div>

    <!-- Admin Statistics Cards -->
    <div class="mb-8">
        <div class="grid grid-cols-1 gap-6 md:grid-cols-4">

            <!-- Card 1: Total Users -->
            <div class="p-6 transition-shadow duration-200 bg-white border border-gray-200 rounded-lg shadow-sm cursor-pointer hover:shadow-md" onclick="window.location.href='?page=admin-jobseekers'">
                <div class="mb-4">
                    <h3 class="mb-2 text-sm font-medium text-gray-700">Total Users</h3>
                    <div class="flex items-baseline">
                        <span class="text-2xl font-bold text-gray-900">
                            <?php echo number_format($dashboardStats['total_users'] ?? 1247); ?>
                        </span>
                        <?php $user_change = $dashboardStats['user_change'] ?? 12; ?>
                        <?php if ($user_change >= 0): ?>
                            <span class="flex items-center ml-2 text-green-600">
                                <!-- Green Upward Check Icon -->
                                <svg viewBox="0 0 24 24" class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none">
                                    <polyline points="1.5 18.68 9.14 11.04 12.96 14.86 22.5 5.32"
                                        stroke="currentColor" stroke-width="2" fill="none"></polyline>
                                    <polyline points="17.73 5.32 22.5 5.32 22.5 10.09"
                                        stroke="currentColor" stroke-width="2" fill="none"></polyline>
                                </svg>
                            </span>
                        <?php else: ?>
                            <span class="flex items-center ml-2 text-red-600">
                                <!-- Red Downward Arrow (same SVG rotated) -->
                                <svg viewBox="0 0 24 24" class="w-4 h-4 transform rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none">
                                    <polyline points="1.5 18.68 9.14 11.04 12.96 14.86 22.5 5.32"
                                        stroke="currentColor" stroke-width="2" fill="none"></polyline>
                                    <polyline points="17.73 5.32 22.5 5.32 22.5 10.09"
                                        stroke="currentColor" stroke-width="2" fill="none"></polyline>
                                </svg>
                            </span>
                        <?php endif; ?>
                    </div>

                    <p class="mt-1 text-xs text-gray-500">
                        Active users on the platform
                    </p>
                </div>
                <div class="pt-3">
                    <span class="flex items-center text-sm font-medium text-secondary">
                        Manage Users
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </span>
                </div>
            </div>

            <!-- Card 2: Job Posts -->
            <div class="p-6 transition-shadow duration-200 bg-white border border-gray-200 rounded-lg shadow-sm cursor-pointer hover:shadow-md" onclick="window.location.href='?page=admin-jobpost-management'">
                <div class="mb-4">
                    <h3 class="mb-2 text-sm font-medium text-gray-700">Active Job Posts</h3>
                    <div class="flex items-baseline">
                        <span class="text-2xl font-bold text-gray-900">
                            <?php echo number_format($dashboardStats['active_jobs'] ?? 156); ?>
                        </span>
                        <span class="flex items-center ml-2 text-green-600">
                            <!-- Blue Check Icon -->
                            <svg viewBox="0 0 24 24" class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
                                <path d="M8.6,20.1l-7.8-8l1.4-1.4l6.4,6.5L21.8,3.9l1.4,1.4L8.6,20.1z"></path>
                            </svg>
                        </span>
                    </div>

                    <p class="mt-1 text-xs text-gray-500">
                        Currently available positions
                    </p>
                </div>
                <div class="pt-3">
                    <span class="flex items-center text-sm font-medium text-secondary">
                        View Jobs
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </span>
                </div>
            </div>

            <!-- Card 3: Pending Accreditations -->
            <div class="p-6 transition-shadow duration-200 bg-white border border-gray-200 rounded-lg shadow-sm cursor-pointer hover:shadow-md" onclick="window.location.href='?page=admin-accreditations'">
                <div class="mb-4">
                    <h3 class="mb-2 text-sm font-medium text-gray-700">Pending Accreditations</h3>
                    <div class="flex items-center">
                        <span class="text-2xl font-bold text-gray-900">
                            <?php echo number_format($dashboardStats['pending_accreditations'] ?? 23); ?>
                        </span>
                        <?php $pending_accreditations = $dashboardStats['pending_accreditations'] ?? 23; ?>
                        <?php if ($pending_accreditations > 0): ?>
                            <span class="flex items-center ml-2 text-xs font-medium text-red-600">
                                Needs Review
                            </span>
                        <?php else: ?>
                            <span class="flex items-center ml-2 text-xs font-medium text-green-600">
                                All Clear
                            </span>
                        <?php endif; ?>
                    </div>
                    <p class="mt-1 text-xs text-gray-500">
                        Employer applications awaiting approval
                    </p>
                </div>
                <div class="pt-3">
                    <span class="flex items-center text-sm font-medium text-secondary">
                        Review Now
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </span>
                </div>
            </div>


            <!-- Card 4: Total Applications -->
            <div class="p-6 transition-shadow duration-200 bg-white border border-gray-200 rounded-lg shadow-sm cursor-pointer hover:shadow-md" onclick="window.location.href='?page=admin-applications'">
                <div class="mb-4">
                    <h3 class="mb-2 text-sm font-medium text-gray-700">Total Applications</h3>
                    <div class="flex items-baseline">
                        <span class="text-2xl font-bold text-gray-900">
                            <?php echo number_format($dashboardStats['total_applications'] ?? 2891); ?>
                        </span>
                        <span class="flex items-center ml-2 text-green-600">
                            <!-- Plus Icon -->
                            <svg viewBox="0 0 24 24" class="w-4 h-4" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 6L12 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"></path>
                                <path d="M18 12L6 12" stroke="currentColor" stroke-width="2" stroke-linecap="round"></path>
                            </svg>
                        </span>

                    </div>
                    <p class="mt-1 text-xs text-gray-500">
                        Job applications submitted
                    </p>
                </div>
                <div class="pt-3">
                    <span class="flex items-center text-sm font-medium text-secondary">
                        View All
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </span>
                </div>
            </div>

        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
        <!-- Job Statistics Chart (Left) -->
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
            <!-- Card Header -->
            <div class="p-4 pb-2">
                <h3 class="text-lg font-semibold text-gray-900">Job Statistics</h3>
                <p class="mt-1 text-sm text-gray-600">Showing job posts and applications for the last 6 months</p>
            </div>

            <!-- Card Content -->
            <div class="p-4 pt-2">
                <!-- Chart Container -->
                <div class="w-full h-48">
                    <canvas id="jobStatsChart" class="w-full h-full"></canvas>
                </div>
            </div>

            <!-- Card Footer -->
            <div class="px-4 py-4">
                <div class="flex items-start gap-2 text-sm">
                    <div class="grid gap-1">
                        <div class="flex items-center gap-2 font-medium leading-none text-gray-900">
                            <?php $trend = $jobStatsChart['trend'] ?? 12; ?>
                            <?php if ($trend > 0): ?>
                                Trending up by <?php echo abs($trend); ?>% this month
                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                            <?php elseif ($trend < 0): ?>
                                Trending down by <?php echo abs($trend); ?>% this month
                                <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                                </svg>
                            <?php else: ?>
                                No change from last month
                                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14"></path>
                                </svg>
                            <?php endif; ?>
                        </div>
                        <div class="text-xs leading-none text-gray-500">
                            <?php
                            $startMonth = date('F', strtotime('-5 months'));
                            $endMonth = date('F Y');
                            echo "$startMonth - $endMonth";
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Job Categories (Right) -->
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
            <!-- Card Header -->
            <div class="p-4 pb-2">
                <h3 class="text-lg font-semibold text-gray-900">Top Job Categories</h3>
                <p class="mt-1 text-sm text-gray-600">Job posts and applications by category (last 6 months)</p>
            </div>

            <!-- Card Content -->
            <div class="p-4 pt-2">
                <!-- Chart Container -->
                <div class="w-full h-48">
                    <canvas id="topJobsChart" class="w-full h-full"></canvas>
                </div>
            </div>

            <!-- Card Footer -->
            <div class="px-4 py-4">
                <div class="flex flex-col items-start gap-1 text-sm">
                    <div class="flex gap-2 font-medium leading-none text-gray-900">
                        Top performing categories
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <div class="text-xs leading-none text-gray-500">
                        Showing job posts and applications for the last 6 months
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Integration -->
<script>
    // Job Statistics Area Chart with Primary/Secondary Colors and Real Data
    const jobStatsCtx = document.getElementById('jobStatsChart').getContext('2d');

    // Define your primary and secondary colors
    const primaryColor = '#092C4C'; // Your primary color (dark blue)
    const primaryColorAlpha = 'rgba(9, 44, 76, 0.1)'; // Primary with transparency
    const secondaryColor = '#F3AF0E'; // Your secondary color (amber/yellow)
    const secondaryColorAlpha = 'rgba(243, 175, 14, 0.1)'; // Secondary with transparency

    // Mock data for now - replace with real data from PHP
    const mockJobStatsData = {
        months: ['Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        job_posts: [45, 52, 38, 67, 49, 58],
        applications: [186, 305, 237, 173, 209, 214]
    };

    // Use real data if available, otherwise use mock data
    const jobStatsData = <?php echo isset($jobStatsChart) ? json_encode($jobStatsChart) : 'mockJobStatsData'; ?>;

    new Chart(jobStatsCtx, {
        type: 'line',
        data: {
            labels: jobStatsData.months,
            datasets: [{
                label: 'Job Posts',
                data: jobStatsData.job_posts,
                borderColor: primaryColor,
                backgroundColor: primaryColorAlpha,
                fill: true,
                tension: 0.4
            }, {
                label: 'Applications',
                data: jobStatsData.applications,
                borderColor: secondaryColor,
                backgroundColor: secondaryColorAlpha,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    }
                },
                y: {
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    }
                }
            }
        }
    });

    // Top Job Categories Bar Chart with Real Data
    const topJobsCtx = document.getElementById('topJobsChart').getContext('2d');

    // Use real data if available, otherwise use mock data
    const jobCategoryData = <?php echo isset($jobCategoryChart) ? json_encode($jobCategoryChart) : 'mockCategoryData'; ?>;

    new Chart(topJobsCtx, {
        type: 'bar',
        data: {
            labels: jobCategoryData.categories,
            datasets: [{
                label: 'Job Posts',
                data: jobCategoryData.job_posts,
                backgroundColor: 'rgba(9, 44, 76, 0.8)',
                borderRadius: 4,
                borderSkipped: false,
            }, {
                label: 'Applications',
                data: jobCategoryData.applications,
                backgroundColor: 'rgba(243, 175, 14, 0.8)',
                borderRadius: 4,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    }
                },
                y: {
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    }
                }
            }
        }
    });
</script>