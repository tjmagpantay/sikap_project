<?php
// Remove the auth check since dashboard.php already handles it
// include_once __DIR__ . '/components/admin_auth_check.php';
?>

<!-- Remove ALL HTML structure - make it content-only like main-board.php -->
<div class="space-y-6">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Analytics & Reports</h1>
                <p class="mt-2 text-sm text-gray-600">
                    Comprehensive analytics and reporting dashboard for SIKAP platform insights
                </p>
            </div>
            <div class="flex items-center space-x-3">
                <button class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Export Report
                </button>
                <select class="px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                    <option>Last 30 Days</option>
                    <option>Last 3 Months</option>
                    <option>Last 6 Months</option>
                    <option>Last Year</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    <?php if (!empty($error)): ?>
        <div class="p-4 mb-6 text-red-700 bg-red-100 rounded-lg">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <div class="p-4 mb-6 text-green-700 bg-green-100 rounded-lg">
            <?php echo htmlspecialchars($success); ?>
        </div>
    <?php endif; ?>

    <!-- Overview Stats Cards -->
    <div class="grid grid-cols-1 gap-4 mb-8 sm:gap-6 md:grid-cols-3 lg:grid-cols-6">
        <!-- Total Users -->
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="flex items-center justify-center w-8 h-8 rounded-md bg-primary">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Users</p>
                    <p class="text-2xl font-semibold text-gray-900"><?php echo number_format($reportStats['total_users'] ?? 0); ?></p>
                </div>
            </div>
        </div>

        <!-- Total Employers -->
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="flex items-center justify-center w-8 h-8 rounded-md bg-secondary">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Employers</p>
                    <p class="text-2xl font-semibold text-gray-900"><?php echo number_format($reportStats['total_employers'] ?? 0); ?></p>
                </div>
            </div>
        </div>

        <!-- Total Jobseekers -->
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="flex items-center justify-center w-8 h-8 bg-green-600 rounded-md">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Jobseekers</p>
                    <p class="text-2xl font-semibold text-gray-900"><?php echo number_format($reportStats['total_jobseekers'] ?? 0); ?></p>
                </div>
            </div>
        </div>

        <!-- Active Jobs -->
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="flex items-center justify-center w-8 h-8 bg-blue-600 rounded-md">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m8 0H8m8 0v2m-8-2v2m0 0v6a2 2 0 002 2h4a2 2 0 002-2V8H8z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Active Jobs</p>
                    <p class="text-2xl font-semibold text-gray-900"><?php echo number_format($reportStats['active_jobs'] ?? 0); ?></p>
                </div>
            </div>
        </div>

        <!-- Total Applications -->
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="flex items-center justify-center w-8 h-8 bg-purple-600 rounded-md">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Applications</p>
                    <p class="text-2xl font-semibold text-gray-900"><?php echo number_format($reportStats['total_applications'] ?? 0); ?></p>
                </div>
            </div>
        </div>

        <!-- Pending Applications -->
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="flex items-center justify-center w-8 h-8 bg-yellow-600 rounded-md">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Pending</p>
                    <p class="text-2xl font-semibold text-gray-900"><?php echo number_format($reportStats['pending_applications'] ?? 0); ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
        <!-- Monthly Trends Bar Chart -->
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
            <div class="p-6 pb-4">
                <h3 class="text-lg font-semibold text-gray-900">Monthly Activity Trends</h3>
                <p class="mt-1 text-sm text-gray-600">Job posts, applications, and user registrations over time</p>
            </div>
            <div class="p-6 pt-0">
                <div class="w-full h-80">
                    <canvas id="monthlyTrendsChart" class="w-full h-full"></canvas>
                </div>
            </div>
        </div>

        <!-- Job Categories Pie Chart -->
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
            <div class="p-6 pb-4">
                <h3 class="text-lg font-semibold text-gray-900">Job Categories Distribution</h3>
                <p class="mt-1 text-sm text-gray-600">Breakdown of job posts by industry category</p>
            </div>
            <div class="p-6 pt-0">
                <div class="flex items-center justify-center w-full h-80">
                    <canvas id="categoriesChart" class="max-w-full max-h-full"></canvas>
                </div>
            </div>
        </div>

        <!-- Application Status Chart -->
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
            <div class="p-6 pb-4">
                <h3 class="text-lg font-semibold text-gray-900">Application Status Overview</h3>
                <p class="mt-1 text-sm text-gray-600">Current status distribution of all job applications</p>
            </div>
            <div class="p-6 pt-0">
                <div class="w-full h-80">
                    <canvas id="applicationStatusChart" class="w-full h-full"></canvas>
                </div>
            </div>
        </div>

        <!-- User Growth Chart -->
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
            <div class="p-6 pb-4">
                <h3 class="text-lg font-semibold text-gray-900">User Growth Analysis</h3>
                <p class="mt-1 text-sm text-gray-600">Jobseekers vs Employers registration trends</p>
            </div>
            <div class="p-6 pt-0">
                <div class="w-full h-80">
                    <canvas id="userGrowthChart" class="w-full h-full"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Integration -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Define color scheme
    const colors = {
        primary: '#092C4C',
        secondary: '#F3AF0E',
        success: '#10B981',
        danger: '#EF4444',
        warning: '#F59E0B',
        info: '#3B82F6',
        light: '#F8FAFC',
        dark: '#1F2937'
    };

    // Monthly Trends Bar Chart
    const monthlyTrendsCtx = document.getElementById('monthlyTrendsChart').getContext('2d');
    new Chart(monthlyTrendsCtx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($monthlyData['months'] ?? []); ?>,
            datasets: [{
                label: 'Job Posts',
                data: <?php echo json_encode($monthlyData['job_posts'] ?? []); ?>,
                backgroundColor: colors.primary,
                borderRadius: 4,
            }, {
                label: 'Applications',
                data: <?php echo json_encode($monthlyData['applications'] ?? []); ?>,
                backgroundColor: colors.secondary,
                borderRadius: 4,
            }, {
                label: 'Registrations',
                data: <?php echo json_encode($monthlyData['registrations'] ?? []); ?>,
                backgroundColor: colors.success,
                borderRadius: 4,
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
                    beginAtZero: true,
                    grid: {
                        color: '#F3F4F6'
                    }
                }
            }
        }
    });

    // Job Categories Pie Chart
    const categoriesCtx = document.getElementById('categoriesChart').getContext('2d');
    new Chart(categoriesCtx, {
        type: 'doughnut',
        data: {
            labels: <?php echo json_encode($categoryData['categories'] ?? []); ?>,
            datasets: [{
                data: <?php echo json_encode($categoryData['values'] ?? []); ?>,
                backgroundColor: <?php echo json_encode($categoryData['colors'] ?? []); ?>,
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right',
                    labels: {
                        usePointStyle: true,
                        padding: 20
                    }
                }
            }
        }
    });

    // Application Status Chart
    const applicationStatusCtx = document.getElementById('applicationStatusChart').getContext('2d');
    new Chart(applicationStatusCtx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($applicationStatusData['labels'] ?? []); ?>,
            datasets: [{
                label: 'Applications',
                data: <?php echo json_encode($applicationStatusData['values'] ?? []); ?>,
                backgroundColor: <?php echo json_encode($applicationStatusData['colors'] ?? []); ?>,
                borderRadius: 6,
                borderSkipped: false,
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                x: {
                    beginAtZero: true,
                    grid: {
                        color: '#F3F4F6'
                    }
                },
                y: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // User Growth Chart
    const userGrowthCtx = document.getElementById('userGrowthChart').getContext('2d');
    new Chart(userGrowthCtx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($monthlyData['months'] ?? []); ?>,
            datasets: [{
                label: 'Jobseekers',
                data: [18, 25, 15, 32, 21, 28],
                borderColor: colors.primary,
                backgroundColor: colors.primary + '20',
                fill: true,
                tension: 0.4
            }, {
                label: 'Employers',
                data: [5, 6, 4, 10, 7, 7],
                borderColor: colors.secondary,
                backgroundColor: colors.secondary + '20',
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
                    beginAtZero: true,
                    grid: {
                        color: '#F3F4F6'
                    }
                }
            }
        }
    });
</script>