<?php
// Test script to verify JobPost model works correctly
session_start();
require_once __DIR__ . '/app/models/JobPost.php';
require_once __DIR__ . '/app/models/JobseekerDashboard.php';

try {
    echo "Testing JobPost model...\n";

    $jobPostModel = new JobPost();
    echo "JobPost model instantiated successfully.\n";

    // Test getting all active jobs without jobseeker_id
    $jobs = $jobPostModel->getAllActiveJobs();
    echo "Found " . count($jobs) . " active jobs total.\n";

    if (!empty($jobs)) {
        echo "First job details:\n";
        $firstJob = $jobs[0];
        foreach ($firstJob as $key => $value) {
            echo "  $key: " . (is_null($value) ? 'NULL' : $value) . "\n";
        }

        // Specifically check for pay_range and category_name
        echo "\n--- Checking specific fields ---\n";
        echo "pay_range: " . (isset($firstJob['pay_range']) ? ($firstJob['pay_range'] ?: 'EMPTY') : 'NOT_SET') . "\n";
        echo "category_name: " . (isset($firstJob['category_name']) ? ($firstJob['category_name'] ?: 'EMPTY') : 'NOT_SET') . "\n";
        echo "business_logo: " . (isset($firstJob['business_logo']) ? ($firstJob['business_logo'] ?: 'EMPTY') : 'NOT_SET') . "\n";
        echo "company_name: " . (isset($firstJob['company_name']) ? ($firstJob['company_name'] ?: 'EMPTY') : 'NOT_SET') . "\n";
        echo "salary: " . (isset($firstJob['salary']) ? ($firstJob['salary'] ?: 'EMPTY') : 'NOT_SET') . "\n";
        echo "show_pay: " . (isset($firstJob['show_pay']) ? ($firstJob['show_pay'] ? 'true' : 'false') : 'NOT_SET') . "\n";
    }

    // Test with a sample jobseeker_id (use 1 as example)
    echo "\n--- Testing with jobseeker_id = 1 ---\n";
    $jobsWithApplied = $jobPostModel->getAllActiveJobs(1);
    echo "Found " . count($jobsWithApplied) . " active jobs for jobseeker 1.\n";

    if (!empty($jobsWithApplied)) {
        echo "First job with application status:\n";
        $firstJobWithStatus = $jobsWithApplied[0];
        foreach ($firstJobWithStatus as $key => $value) {
            echo "  $key: " . (is_null($value) ? 'NULL' : (is_bool($value) ? ($value ? 'true' : 'false') : $value)) . "\n";
        }

        // Specifically test pay_range and category_name
        echo "\n--- Testing pay_range and category_name fields ---\n";
        echo "pay_range: " . (isset($firstJobWithStatus['pay_range']) ? ($firstJobWithStatus['pay_range'] ?: 'EMPTY') : 'NOT_SET') . "\n";
        echo "category_name: " . (isset($firstJobWithStatus['category_name']) ? ($firstJobWithStatus['category_name'] ?: 'EMPTY') : 'NOT_SET') . "\n";
        echo "business_logo: " . (isset($firstJobWithStatus['business_logo']) ? ($firstJobWithStatus['business_logo'] ?: 'EMPTY') : 'NOT_SET') . "\n";
        echo "company_name: " . (isset($firstJobWithStatus['company_name']) ? ($firstJobWithStatus['company_name'] ?: 'EMPTY') : 'NOT_SET') . "\n";
        echo "salary: " . (isset($firstJobWithStatus['salary']) ? ($firstJobWithStatus['salary'] ?: 'EMPTY') : 'NOT_SET') . "\n";
        echo "show_pay: " . (isset($firstJobWithStatus['show_pay']) ? ($firstJobWithStatus['show_pay'] ? 'true' : 'false') : 'NOT_SET') . "\n";

        // Test if we can use pay_range in the view logic
        if (isset($firstJobWithStatus['show_pay']) && $firstJobWithStatus['show_pay'] && !empty($firstJobWithStatus['pay_range'])) {
            echo "✓ Pay range can be displayed: " . $firstJobWithStatus['pay_range'] . "\n";
        } else {
            echo "✗ Pay range cannot be displayed (show_pay=" . ($firstJobWithStatus['show_pay'] ?? 'NULL') . ", pay_range=" . ($firstJobWithStatus['pay_range'] ?? 'NULL') . ")\n";
        }

        if (!empty($firstJobWithStatus['category_name'])) {
            echo "✓ Category can be displayed: " . $firstJobWithStatus['category_name'] . "\n";
        } else {
            echo "✗ Category cannot be displayed (category_name is empty or null)\n";
        }

        if (!empty($firstJobWithStatus['business_logo'])) {
            echo "✓ Business logo can be displayed: " . $firstJobWithStatus['business_logo'] . "\n";
        } else {
            echo "✗ Business logo cannot be displayed (business_logo is empty or null)\n";
        }
    }

    // Test JobseekerDashboard model for comparison
    echo "\n=== TESTING JOBSEEKER DASHBOARD MODEL ===\n";
    $dashboardModel = new JobseekerDashboard();
    echo "JobseekerDashboard model instantiated successfully.\n";

    $dashboardJobs = $dashboardModel->getRecommendedJobs(1, 5);
    echo "Found " . count($dashboardJobs) . " jobs from JobseekerDashboard model.\n";

    if (!empty($dashboardJobs)) {
        $firstDashboardJob = $dashboardJobs[0];
        echo "\nFirst job from Dashboard model:\n";
        echo "  job_id: " . ($firstDashboardJob['job_id'] ?? 'NULL') . "\n";
        echo "  job_title: " . ($firstDashboardJob['job_title'] ?? 'NULL') . "\n";
        echo "  pay_range: " . ($firstDashboardJob['pay_range'] ?? 'NULL') . "\n";
        echo "  category_name: " . ($firstDashboardJob['category_name'] ?? 'NULL') . "\n";
        echo "  business_logo: " . ($firstDashboardJob['business_logo'] ?? 'NULL') . "\n";
        echo "  company_name: " . ($firstDashboardJob['company_name'] ?? 'NULL') . "\n";
        echo "  show_pay: " . (isset($firstDashboardJob['show_pay']) ? ($firstDashboardJob['show_pay'] ? 'true' : 'false') : 'NULL') . "\n";

        // Test the display logic for dashboard
        echo "\n--- Dashboard Display Logic Test ---\n";
        if (isset($firstDashboardJob['show_pay']) && $firstDashboardJob['show_pay'] && !empty($firstDashboardJob['pay_range'])) {
            echo "✓ Dashboard can display pay range: " . $firstDashboardJob['pay_range'] . "\n";
        } else {
            echo "✗ Dashboard cannot display pay range\n";
        }

        if (!empty($firstDashboardJob['category_name'])) {
            echo "✓ Dashboard can display category: " . $firstDashboardJob['category_name'] . "\n";
        } else {
            echo "✗ Dashboard cannot display category\n";
        }

        if (!empty($firstDashboardJob['business_logo'])) {
            echo "✓ Dashboard can display business logo: " . $firstDashboardJob['business_logo'] . "\n";
        } else {
            echo "✗ Dashboard cannot display business logo\n";
        }
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}


              <div>
                <!-- Bookmark Icon -->
                <button class="absolute z-10 p-4 text-gray-400 transition-colors duration-300 top-4 right-4 hover:text-yellow-400" onclick="event.stopPropagation(); saveJob(<?php echo $company['employer_id']; ?>)">
                  <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                  </svg>
                </button>
              </div>