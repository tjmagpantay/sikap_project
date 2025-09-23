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
                    <div class="flex items-center justify-center w-12 h-12 rounded-md bg-primary">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Users</p>
                    <p class="text-xl font-semibold text-gray-900"><?php echo number_format($reportStats['total_users'] ?? 0); ?></p>
                </div>
            </div>
        </div>

        <!-- Total Employers -->
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="flex items-center justify-center w-12 h-12 rounded-md bg-secondary">
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
                    <div class="flex items-center justify-center w-12 h-12 bg-green-600 rounded-md">
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
                    <div class="flex items-center justify-center w-12 h-12 bg-blue-600 rounded-md">
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
                    <div class="flex items-center justify-center w-12 h-12 bg-purple-600 rounded-md">
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

        <!-- Events Programs -->
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="flex items-center justify-center w-12 h-12 bg-yellow-600 rounded-md">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Events</p>
                    <p class="text-2xl font-semibold text-gray-900"><?php echo number_format($reportStats['total_events'] ?? 0); ?></p>
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



    </div>
</div>

<!-- Chart.js Integration -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Define color scheme - SIKAP Theme Colors
    const colors = {
        primary: '#092C4C', // Dark Blue
        secondary: '#F3AF0E', // Orange/Yellow
        success: '#10B981', // Green
        danger: '#EF4444', // Red
        info: '#3B82F6', // Blue
        gray: '#6B7280', // Gray
        warning: '#F59E0B', // Yellow
        light: '#F8FAFC',
        dark: '#1F2937'
    };

    // Job Category Color Palette (all 8 colors)
    const jobCategoryColors = [
        '#092C4C', // primary - Dark Blue
        '#F3AF0E', // secondary - Orange
        '#10B981', // success - Green
        '#EF4444', // danger - Red
        '#3B82F6', // info - Blue
        '#6B7280', // gray - Gray
        '#8B5CF6', // purple
        '#B0AEAE' //Others
    ];

    // Monthly Trends Bar Chart (working - unchanged)
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

    // ✅ FIXED: Job Categories Pie Chart using EXACT same approach as main-board
    const categoriesCtx = document.getElementById('categoriesChart').getContext('2d');

    // ✅ Use same mock/fallback data approach as main-board
    const mockCategoryData = {
        categories: ['IT', 'Healthcare', 'Education', 'Engineering', 'Finance', 'Marketing', 'Construction', 'Others'],
        values: [0, 0, 0, 0, 0, 0, 0, 0],
        colors: jobCategoryColors
    };

    // ✅ Use real data if available, otherwise use mock data (EXACT same as main-board)
    const categoryData = <?php echo isset($categoryData) ? json_encode($categoryData) : 'mockCategoryData'; ?>;


    new Chart(categoriesCtx, {
        type: 'doughnut',
        data: {
            labels: categoryData.categories,
            datasets: [{
                data: categoryData.values,
                backgroundColor: categoryData.colors,
                borderWidth: 2,
                borderColor: '#ffffff',
                hoverOffset: 4,
                hoverBorderWidth: 3
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
                        padding: 20,
                        font: {
                            size: 12
                        },
                        generateLabels: function(chart) {
                            const data = chart.data;
                            if (data.labels.length && data.datasets.length) {
                                return data.labels.map((label, i) => {
                                    const dataset = data.datasets[0];
                                    const value = dataset.data[i] || 0;
                                    const total = dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;

                                    return {
                                        text: `${label}: ${value} (${percentage}%)`,
                                        fillStyle: dataset.backgroundColor[i],
                                        strokeStyle: dataset.borderColor,
                                        lineWidth: dataset.borderWidth,
                                        hidden: isNaN(dataset.data[i]),
                                        index: i
                                    };
                                });
                            }
                            return [];
                        }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.parsed || 0;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                            return `${label}: ${value} jobs (${percentage}%)`;
                        }
                    }
                }
            },
            animation: {
                animateRotate: true,
                animateScale: true,
                duration: 1500
            }
        }
    });


    
</script>