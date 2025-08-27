<div class="p-6">
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

            <!-- Right side: Date Range Selector -->
            <div class="flex items-center">
                <button class="flex items-center px-4 py-3 text-sm font-medium text-gray-700 transition-colors duration-200 bg-white border border-gray-300 rounded-sm shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary">
                    <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <?php echo date('M j', strtotime('-7 days')); ?> - <?php echo date('M j'); ?>
                    <svg class="w-4 h-4 ml-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Admin Statistics Cards -->
    <div class="mb-8">
        <div class="grid grid-cols-1 gap-6 md:grid-cols-4">

            <!-- Card 1: Total Users -->
            <div class="p-6 transition-shadow duration-200 bg-white border border-gray-200 rounded-lg shadow-sm cursor-pointer hover:shadow-md" onclick="window.location.href='?page=admin-users'">
                <div class="mb-4">
                    <h3 class="mb-2 text-sm font-medium text-gray-700">Total Users</h3>
                    <div class="flex items-baseline">
                        <span class="text-2xl font-bold text-gray-900"><?php echo number_format($dashboardStats['total_users']); ?></span>
                        <?php if ($dashboardStats['user_change'] >= 0): ?>
                            <span class="ml-2 text-sm text-green-600">+<?php echo $dashboardStats['user_change']; ?>%</span>
                        <?php else: ?>
                            <span class="ml-2 text-sm text-red-600"><?php echo $dashboardStats['user_change']; ?>%</span>
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
            <div class="p-6 transition-shadow duration-200 bg-white border border-gray-200 rounded-lg shadow-sm cursor-pointer hover:shadow-md" onclick="window.location.href='?page=admin-jobs'">
                <div class="mb-4">
                    <h3 class="mb-2 text-sm font-medium text-gray-700">Active Job Posts</h3>
                    <div class="flex items-baseline">
                        <span class="text-2xl font-bold text-gray-900"><?php echo number_format($dashboardStats['active_jobs']); ?></span>
                        <?php if ($dashboardStats['job_change'] >= 0): ?>
                            <span class="ml-2 text-sm text-blue-600">+<?php echo $dashboardStats['job_change']; ?>%</span>
                        <?php else: ?>
                            <span class="ml-2 text-sm text-red-600"><?php echo $dashboardStats['job_change']; ?>%</span>
                        <?php endif; ?>
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
                    <div class="flex items-baseline">
                        <span class="text-2xl font-bold text-gray-900"><?php echo number_format($dashboardStats['pending_accreditations']); ?></span>
                        <?php if ($dashboardStats['pending_accreditations'] > 0): ?>
                            <span class="ml-2 text-sm text-orange-600">Needs Review</span>
                        <?php else: ?>
                            <span class="ml-2 text-sm text-green-600">All Clear</span>
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
                        <span class="text-2xl font-bold text-gray-900"><?php echo number_format($dashboardStats['total_applications']); ?></span>
                        <?php if ($dashboardStats['application_change'] >= 0): ?>
                            <span class="ml-2 text-sm text-green-600">+<?php echo $dashboardStats['application_change']; ?>%</span>
                        <?php else: ?>
                            <span class="ml-2 text-sm text-red-600"><?php echo $dashboardStats['application_change']; ?>%</span>
                        <?php endif; ?>
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
                            <?php if ($jobStatsChart['trend'] > 0): ?>
                                Trending up by <?php echo abs($jobStatsChart['trend']); ?>% this month
                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                            <?php elseif ($jobStatsChart['trend'] < 0): ?>
                                Trending down by <?php echo abs($jobStatsChart['trend']); ?>% this month
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

        <!-- Top Job Posts (Right) -->
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

    <!-- Chart.js Integration -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Job Statistics Area Chart with Primary/Secondary Colors and Real Data
        const jobStatsCtx = document.getElementById('jobStatsChart').getContext('2d');

        // Define your primary and secondary colors
        const primaryColor = '#092C4C'; // Your primary color (dark blue)
        const primaryColorAlpha = 'rgba(9, 44, 76, 0.1)'; // Primary with transparency
        const secondaryColor = '#F3AF0E'; // Your secondary color (amber/yellow)
        const secondaryColorAlpha = 'rgba(243, 175, 14, 0.1)'; // Secondary with transparency

        // Get real data from PHP
        const jobStatsData = <?php echo json_encode($jobStatsChart); ?>;

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

        // Define your primary and secondary colors
        const primary = '#092C4C'; // Your primary color (dark blue)
        const primaryAlpha = 'rgba(9, 44, 76, 0.8)'; // Primary with transparency
        const secondary = '#F3AF0E'; // Your secondary color (amber/yellow)
        const secondaryAlpha = 'rgba(243, 175, 14, 0.8)'; // Secondary with transparency

        // Get real data from PHP
        const jobCategoryData = <?php echo json_encode($jobCategoryChart); ?>;

        new Chart(topJobsCtx, {
            type: 'bar',
            data: {
                labels: jobCategoryData.categories,
                datasets: [{
                    label: 'Job Posts',
                    data: jobCategoryData.job_posts,
                    backgroundColor: primaryAlpha,
                    borderRadius: 4,
                    borderSkipped: false,
                }, {
                    label: 'Applications',
                    data: jobCategoryData.applications,
                    backgroundColor: secondaryAlpha,
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
</div>