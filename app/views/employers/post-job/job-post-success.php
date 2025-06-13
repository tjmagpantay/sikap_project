<?php
// filepath: c:\xampp\htdocs\sikap\app\views\employers\post-job\job-post-success.php

$job_id = $_GET['job_id'] ?? null;
if (!$job_id) {
    header('Location: ?page=manage-jobs');
    exit;
}
?>

<?php include_once __DIR__ . '/../../components/navbar-top.php';
include_once __DIR__ . '/../navbar-employer.php';
?>

<div class="min-h-screen py-12 bg-gray-50 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-2xl">
        <div class="text-center">
            <div class="flex justify-center mb-6">
                <div class="p-4 bg-green-600 rounded-full">
                    <i class="text-3xl text-white fas fa-check"></i>
                </div>
            </div>
            <h2 class="text-3xl font-extrabold text-gray-900 mb-4">
                Job Posted Successfully!
            </h2>
            <p class="text-lg text-gray-600 mb-8">
                Your job posting is now live and visible to job seekers.
            </p>

            <div class="bg-white shadow rounded-lg p-6 mb-8">
                <h3 class="text-lg font-medium text-gray-900 mb-4">What's Next?</h3>
                <div class="space-y-3 text-left">
                    <div class="flex items-center">
                        <i class="fas fa-users text-green-500 mr-3"></i>
                        <span class="text-gray-700">Monitor applications in your dashboard</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-bell text-green-500 mr-3"></i>
                        <span class="text-gray-700">Receive email notifications for new applications</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-edit text-green-500 mr-3"></i>
                        <span class="text-gray-700">Edit or pause your job posting anytime</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-chart-line text-green-500 mr-3"></i>
                        <span class="text-gray-700">Track views and application rates</span>
                    </div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="?page=manage-jobs" 
                   class="inline-flex items-center px-6 py-3 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md hover:bg-green-700">
                    <i class="mr-2 fas fa-list"></i>
                    View All Jobs
                </a>
                <a href="?page=post-job" 
                   class="inline-flex items-center px-6 py-3 text-sm font-medium text-green-600 bg-white border border-green-600 rounded-md hover:bg-green-50">
                    <i class="mr-2 fas fa-plus"></i>
                    Post Another Job
                </a>
                <a href="?page=employer-dashboard" 
                   class="inline-flex items-center px-6 py-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                    <i class="mr-2 fas fa-tachometer-alt"></i>
                    Dashboard
                </a>
            </div>
        </div>
    </div>
</div>