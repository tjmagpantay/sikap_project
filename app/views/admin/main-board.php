<div class="p-6">
    <!-- Welcome Section -->
    <div class="mb-8">
        <h2 class="text-2xl font-semibold text-gray-900 mb-1">Good morning, Benedict</h2>
        <p class="text-gray-600">Here is your job listings statistic report from July 19 - July 25.</p>
        
        <!-- Date Range -->
        <div class="flex items-center mt-4">
            <div class="flex items-center space-x-2 bg-white border border-gray-300 rounded-lg px-3 py-2">
                <span class="text-sm text-gray-600">Jul 19 - Jul 25</span>
                <i class="fas fa-calendar-alt text-gray-400 text-sm"></i>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <?php include __DIR__ . '/stats-cards.php'; ?>

    <!-- Charts and Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-8">
        <!-- Job Statistics Chart (2 columns) -->
        <div class="lg:col-span-2">
            <?php include __DIR__ . '/job-chart.php'; ?>
        </div>
        
        <!-- Top Job Posts -->
        <div>
            <?php include __DIR__ . '/top-jobs.php'; ?>
        </div>
    </div>
    
    <!-- Bottom Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
        <!-- Job Views and Applications -->
        <div>
            <?php include __DIR__ . '/job-stats.php'; ?>
        </div>
        
        <!-- Applicants Summary -->
        <div>
            <?php include __DIR__ . '/applicants-summary.php'; ?>
        </div>
        
        <!-- Chat -->
        <div>
            <?php include __DIR__ . '/chat-preview.php'; ?>
        </div>
    </div>
</div>