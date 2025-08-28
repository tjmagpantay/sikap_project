<?php
include_once __DIR__ . '/../components/employer_auth_check.php';

$job_id = $_GET['job_id'] ?? null;
if (!$job_id) {
    header('Location: ?page=manage-jobs');
    exit;
}
?>

<?php
include_once __DIR__ . '/../../components/navbar-top.php';
include_once __DIR__ . '/../components/navbar-employer.php';
?>

<div class="min-h-screen py-8 bg-gradient-to-b from-green-50 to-white">
    <div class="w-full max-w-2xl px-4 mx-auto sm:px-8 lg:px-32 xl:px-64">
        <div class="max-w-3xl mx-auto">
            <div class="text-center">
                <!-- Success Icon with Animation -->
                <div class="flex justify-center mb-8">
                    <div class="relative">
                        <div class="absolute inset-0 bg-green-100 rounded-full opacity-75 animate-ping"></div>
                        <div class="relative flex items-center justify-center w-24 h-24 mx-auto rounded-full shadow-lg bg-secondary">
                            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Success Message -->
                <div class="mb-8">
                    <h1 class="font-bold tracking-tight text-primary text-sm:text-lg">
                        Job Posted Successfully!
                    </h1>
                    <p class="max-w-md mx-auto mt-2 text-sm text-gray-600">
                        Your job posting is now live and visible to qualified candidates.
                    </p>
                </div>

                <!-- What's Next Card -->
                <div class="p-8 mb-12 overflow-hidden bg-white border border-gray-200 shadow-sm rounded-xl">
                    <div class="relative">
                        <div class="absolute top-0 left-0 w-1 h-full bg-green-600"></div>
                        <div class="pl-6">
                            <h3 class="mb-6 font-semibold text-primary text-md">What happens next?</h3>
                            <ul class="space-y-4">
                                <li class="flex items-start">
                                    <div class="flex-shrink-0 mt-1">
                                        <div class="flex items-center justify-center w-6 h-6 bg-green-100 rounded-full text-primary">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-gray-700">Your job will appear in search results immediately</p>
                                    </div>
                                </li>
                                <li class="flex items-start">
                                    <div class="flex-shrink-0 mt-1">
                                        <div class="flex items-center justify-center w-6 h-6 bg-green-100 rounded-full text-primary">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-gray-700">Qualified candidates can start applying right away</p>
                                    </div>
                                </li>
                                <li class="flex items-start">
                                    <div class="flex-shrink-0 mt-1">
                                        <div class="flex items-center justify-center w-6 h-6 bg-green-100 rounded-full text-primary">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-gray-700">You'll receive email notifications for new applications</p>
                                    </div>
                                </li>
                                <li class="flex items-start">
                                    <div class="flex-shrink-0 mt-1">
                                        <div class="flex items-center justify-center w-6 h-6 bg-green-100 rounded-full text-primary">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-gray-700">Track applications and manage candidates from your dashboard</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                    <a href="?page=manage-jobs"
                        class="flex items-center justify-center px-6 py-3 text-sm font-medium text-white transition-all duration-200 border border-transparent rounded-lg shadow-sm bg-primary hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        View Jobs
                    </a>
                    <a href="?page=post-job"
                        class="flex items-center justify-center px-6 py-3 text-sm font-medium transition-all duration-200 bg-white border border-green-300 rounded-lg shadow-sm text-primary hover:bg-green-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Post Another
                    </a>
                    <a href="?page=employer-dashboard"
                        class="flex items-center justify-center px-6 py-3 text-sm font-medium text-gray-700 transition-all duration-200 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                        </svg>
                        Dashboard
                    </a>
                </div>

                <!-- Quick Tip -->
                <div class="max-w-md px-4 py-3 mx-auto mt-12 text-xs text-center text-gray-500 rounded-lg bg-gray-50">
                    <p>Tip: Share your job posting on social media to reach more candidates!</p>
                </div>
            </div>
        </div>
    </div>
</div>