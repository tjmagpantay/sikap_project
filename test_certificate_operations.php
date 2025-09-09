<?php
session_start();
require_once 'app/models/Jobseeker.php';

if (!isset($_SESSION['user_id'])) {
    die('Please log in first');
}

$jobseekerModel = new Jobseeker();
$jobseeker = $jobseekerModel->findByUserId($_SESSION['user_id']);

if (!$jobseeker) {
    die('Jobseeker not found');
}

$jobseeker_id = $jobseeker['jobseeker_id'];

echo "<h3>Testing Certificate Operations</h3>";

// Test 1: Get existing certificates
$certificates = $jobseekerModel->getCertificates($_SESSION['user_id']);
echo "<p>Existing certificates: " . count($certificates) . "</p>";

if (!empty($certificates)) {
    foreach ($certificates as $cert) {
        echo "<p>Certificate ID: " . $cert['certificate_id'] . " - " . $cert['certificate_title'] . "</p>";
    }

    // Test 2: Try to delete first certificate
    $firstCert = $certificates[0];
    echo "<p>Attempting to delete certificate ID: " . $firstCert['certificate_id'] . "</p>";

    $deleteResult = $jobseekerModel->deleteCertificate($jobseeker_id, $firstCert['certificate_id']);
    echo "<p>Delete result: " . ($deleteResult ? 'SUCCESS' : 'FAILED') . "</p>";

    // Test 3: Check certificates again
    $certificatesAfter = $jobseekerModel->getCertificates($_SESSION['user_id']);
    echo "<p>Certificates after deletion: " . count($certificatesAfter) . "</p>";
} else {
    // Test 4: Add a test certificate
    echo "<p>No certificates found. Adding test certificate...</p>";

    $testCert = [
        'certificate_title' => 'Test Certificate',
        'issuing_organization' => 'Test Organization',
        'date_issued' => date('Y-m-d')
    ];

    $addResult = $jobseekerModel->saveCertificate($jobseeker_id, $testCert);
    echo "<p>Add result: " . ($addResult ? 'SUCCESS' : 'FAILED') . "</p>";

    if ($addResult) {
        $certificatesAfter = $jobseekerModel->getCertificates($_SESSION['user_id']);
        echo "<p>Certificates after adding: " . count($certificatesAfter) . "</p>";
    }
}
