<?php
// Test category stats fix
require_once __DIR__ . '/app/models/AdminDashboard.php';

try {
    $dashboard = new AdminDashboard();

    echo "=== TESTING CATEGORY STATS FIX ===\n\n";

    $categoryStats = $dashboard->getJobCategoryStatsForChart();

    echo "Category Chart Data:\n";
    echo "Categories: " . implode(', ', $categoryStats['categories']) . "\n";
    echo "Job Posts: " . implode(', ', $categoryStats['job_posts']) . "\n";
    echo "Applications: " . implode(', ', $categoryStats['applications']) . "\n\n";

    echo "=== DETAILED BREAKDOWN ===\n";
    for ($i = 0; $i < count($categoryStats['categories']); $i++) {
        echo sprintf(
            "%-15s: %d jobs, %d applications\n",
            $categoryStats['categories'][$i],
            $categoryStats['job_posts'][$i],
            $categoryStats['applications'][$i]
        );
    }

    echo "\n=== TESTING JOB STATS ===\n";
    $jobStats = $dashboard->getJobStatsForChart();
    echo "Months: " . implode(', ', $jobStats['months']) . "\n";
    echo "Job Posts: " . implode(', ', $jobStats['job_posts']) . "\n";
    echo "Applications: " . implode(', ', $jobStats['applications']) . "\n";
    echo "Trend: " . $jobStats['trend'] . "%\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
