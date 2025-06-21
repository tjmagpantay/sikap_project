<div class="bg-white rounded-lg border border-gray-200 p-6">
    <div class="mb-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-1">Job statistics</h3>
        <p class="text-sm text-gray-500">Show statistic Jul 19-25</p>
        
        <!-- Tab Navigation -->
        <div class="flex items-center mt-4 border-b border-gray-200">
            <button class="px-4 py-2 text-sm font-medium text-blue-600 border-b-2 border-blue-600">Overview</button>
            <button class="px-4 py-2 text-sm font-medium text-gray-500 hover:text-gray-700 ml-4">Jobs View</button>
            <button class="px-4 py-2 text-sm font-medium text-gray-500 hover:text-gray-700 ml-4">Jobs Applied</button>
        </div>
        
        <!-- Time Period Buttons -->
        <div class="flex items-center justify-between mt-4">
            <div class="flex items-center space-x-2">
                <button class="px-3 py-1 text-xs text-gray-600 bg-gray-100 rounded">Week</button>
                <button class="px-3 py-1 text-xs text-gray-600 hover:bg-gray-100 rounded">Month</button>
                <button class="px-3 py-1 text-xs text-gray-600 hover:bg-gray-100 rounded">Year</button>
            </div>
            <select class="text-xs text-gray-600 border border-gray-300 rounded px-2 py-1">
                <option>Yearly</option>
                <option>Monthly</option>
                <option>Weekly</option>
            </select>
        </div>
    </div>
    
    <!-- Chart Area -->
    <div class="h-64 mb-6">
        <canvas id="jobStatisticsChart"></canvas>
    </div>
    
    <!-- Bottom Stats -->
    <div class="grid grid-cols-3 gap-4 pt-4 border-t border-gray-200">
        <div>
            <p class="text-xs text-gray-500">Job Views</p>
            <p class="text-lg font-semibold text-gray-900">2,342</p>
            <p class="text-xs text-gray-500">This Week</p>
        </div>
        <div>
            <p class="text-xs text-gray-500">Job Applied</p>
            <p class="text-lg font-semibold text-gray-900">654</p>
            <p class="text-xs text-gray-500">This Week</p>
        </div>
        <div>
            <p class="text-xs text-gray-500">Top Jobs</p>
            <div class="flex items-center mt-1">
                <img src="https://via.placeholder.com/20/4F46E5/FFFFFF?text=S" alt="Service Crew" class="w-5 h-5 rounded-full">
                <div class="ml-2">
                    <p class="text-xs font-medium text-gray-900">Service Crew</p>
                    <p class="text-xs text-gray-500">McDonalds</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('jobStatisticsChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['2019', '2020', '2021', '2022', '2023'],
            datasets: [{
                label: 'Job Growth',
                data: [20, 35, 25, 40, 55],
                borderColor: '#6366F1',
                backgroundColor: 'rgba(99, 102, 241, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 60,
                    ticks: {
                        stepSize: 10,
                        callback: function(value) {
                            return value + 'k';
                        }
                    },
                    grid: {
                        color: '#F3F4F6'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
});
</script>