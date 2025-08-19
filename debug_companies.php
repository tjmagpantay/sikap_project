<?php
// Debug script to test top companies functionality
require_once 'app/controllers/LandingPageController.php';

echo "Testing LandingPageController...\n";

try {
    $landingController = new LandingPageController();
    echo "Controller created successfully.\n";

    $companies = $landingController->getTopCompanies(4);
    echo "Found " . count($companies) . " companies.\n";

    if (!empty($companies)) {
        echo "First company data:\n";
        print_r($companies[0]);
    } else {
        echo "No companies found.\n";

        // Let's test the JobPost model directly
        require_once 'app/models/JobPost.php';
        $jobPost = new JobPost();
        echo "Testing JobPost model directly...\n";
        $allEmployers = $jobPost->getAllEmployers();
        echo "Direct JobPost query found " . count($allEmployers) . " employers.\n";

        if (!empty($allEmployers)) {
            echo "First employer from direct query:\n";
            print_r($allEmployers[0]);
        }
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n";
    echo $e->getTraceAsString() . "\n";
}
