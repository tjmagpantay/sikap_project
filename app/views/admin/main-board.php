<div class="p-6">
    <!-- Greeting Section -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <!-- Left side: Greeting -->
            <div>
                <h2 class="text-2xl font-bold text-gray-900">
                    Good morning, Benedict Admin
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
            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                <div class="mb-4">
                    <h3 class="mb-2 text-sm font-medium text-gray-700">Total Users</h3>
                    <div class="flex items-baseline">
                        <span class="text-2xl font-bold text-gray-900">1,247</span>
                        <span class="ml-2 text-sm text-green-600">+12%</span>
                    </div>
                    <p class="mt-1 text-xs text-gray-500">
                        Active users on the platform
                    </p>
                </div>
                <div class="pt-3">
                    <a href="?page=admin-users" class="flex items-center text-sm text-secondary font-medium">
                        Manage Users
                        <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Card 2: Job Posts -->
            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                <div class="mb-4">
                    <h3 class="mb-2 text-sm font-medium text-gray-700">Active Job Posts</h3>
                    <div class="flex items-baseline">
                        <span class="text-2xl font-bold text-gray-900">324</span>
                        <span class="ml-2 text-sm text-blue-600">+8%</span>
                    </div>
                    <p class="mt-1 text-xs text-gray-500">
                        Currently available positions
                    </p>
                </div>
                <div class="pt-3">
                    <a href="?page=admin-jobs" class="flex items-center text-sm text-secondary font-medium">
                        View Jobs
                        <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Card 3: Pending Accreditations -->
            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                <div class="mb-4">
                    <h3 class="mb-2 text-sm font-medium text-gray-700">Pending Accreditations</h3>
                    <div class="flex items-baseline">
                        <span class="text-2xl font-bold text-gray-900">15</span>
                        <span class="ml-2 text-sm text-orange-600">Needs Review</span>
                    </div>
                    <p class="mt-1 text-xs text-gray-500">
                        Employer applications awaiting approval
                    </p>
                </div>
                <div class="pt-3">
                    <a href="?page=admin-accreditations" class="flex items-center text-sm text-secondary font-medium">
                        Review Now
                        <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Card 4: Total Applications -->
            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                <div class="mb-4">
                    <h3 class="mb-2 text-sm font-medium text-gray-700">Total Applications</h3>
                    <div class="flex items-baseline">
                        <span class="text-2xl font-bold text-gray-900">2,891</span>
                        <span class="ml-2 text-sm text-green-600">+24%</span>
                    </div>
                    <p class="mt-1 text-xs text-gray-500">
                        Job applications submitted
                    </p>
                </div>
                <div class="pt-3">
                    <a href="?page=admin-applications" class="flex items-center text-sm text-secondary font-medium">
                        View All
                        <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>

        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Job Statistics Chart (Left) -->
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
            <!-- Card Header -->
            <div class="p-4 pb-2">
                <h3 class="text-lg font-semibold text-gray-900">Job Statistics</h3>
                <p class="text-sm text-gray-600 mt-1">Showing job posts and applications for the last 6 months</p>
            </div>

            <!-- Card Content -->
            <div class="p-4 pt-2">
                <!-- Chart Container -->
                <div class="w-full h-48">
                    <canvas id="jobStatsChart" class="w-full h-full"></canvas>
                </div>
            </div>

            <!-- Card Footer -->
            <div class="px-4 pb-4">
                <div class="flex items-start gap-2 text-sm">
                    <div class="grid gap-1">
                        <div class="flex items-center gap-2 leading-none font-medium text-gray-900">
                            Trending up by 5.2% this month
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                        <div class="text-gray-500 leading-none text-xs">
                            January - June 2024
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
                <p class="text-sm text-gray-600 mt-1">January - June 2024</p>
            </div>

            <!-- Card Content -->
            <div class="p-4 pt-2">
                <!-- Chart Container -->
                <div class="w-full h-48">
                    <canvas id="topJobsChart" class="w-full h-full"></canvas>
                </div>
            </div>

            <!-- Card Footer -->
            <div class="px-4 pb-4">
                <div class="flex flex-col items-start gap-1 text-sm">
                    <div class="flex gap-2 leading-none font-medium text-gray-900">
                        Trending up by 5.2% this month
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                    <div class="text-gray-500 leading-none text-xs">
                        Showing total job posts for the last 6 months
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js Integration -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Job Statistics Area Chart
        const jobStatsCtx = document.getElementById('jobStatsChart').getContext('2d');
        new Chart(jobStatsCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Job Posts',
                    data: [186, 305, 237, 73, 209, 214],
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    fill: true,
                    tension: 0.4
                }, {
                    label: 'Applications',
                    data: [80, 200, 120, 190, 130, 140],
                    borderColor: 'rgb(16, 185, 129)',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
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

        // Top Job Categories Bar Chart
        const topJobsCtx = document.getElementById('topJobsChart').getContext('2d');
        new Chart(topJobsCtx, {
            type: 'bar',
            data: {
                labels: ['IT', 'Healthcare', 'Education', 'Retail', 'Finance', 'Manufacturing'],
                datasets: [{
                    label: 'Job Posts',
                    data: [186, 305, 237, 73, 209, 214],
                    backgroundColor: 'rgba(59, 130, 246, 0.8)',
                    borderRadius: 4,
                    borderSkipped: false,
                }, {
                    label: 'Applications',
                    data: [80, 200, 120, 190, 130, 140],
                    backgroundColor: 'rgba(16, 185, 129, 0.8)',
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