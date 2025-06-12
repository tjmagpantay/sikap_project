<?php include_once __DIR__ . '/../components/navbar-top.php'; ?>
<?php include_once __DIR__ . '/../components/navbar.php'; ?>

<div class="min-h-screen py-12 bg-gray-50 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <div class="text-center">
            <div class="flex justify-center mb-4">
                <div class="p-4 bg-green-100 rounded-full">
                    <i class="text-4xl text-green-600 fas fa-check-circle"></i>
                </div>
            </div>
            <h2 class="mt-6 text-3xl font-extrabold text-center text-gray-900">
                Profile Complete!
            </h2>
            <p class="mt-2 text-center text-gray-600">
                Congratulations! Your jobseeker profile has been successfully completed.
            </p>
        </div>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-lg">
        <div class="px-4 py-8 bg-white shadow sm:rounded-lg sm:px-10">
            <div class="space-y-6 text-center">
                <div class="p-4 border border-green-200 rounded-lg bg-green-50">
                    <h3 class="text-lg font-medium text-green-900">What's Next?</h3>
                    <p class="mt-2 text-sm text-green-700">
                        You can now browse and apply for jobs, build your resume, and track your applications.
                    </p>
                </div>

                <div class="space-y-4">
                    <a href="?page=jobseeker-dashboard" class="block w-full px-4 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md hover:bg-green-700">
                        Go to Dashboard
                    </a>
                    
                    <a href="?page=browse-jobs" class="block w-full px-4 py-2 text-sm font-medium text-green-600 bg-white border border-green-600 rounded-md hover:bg-green-50">
                        Browse Jobs
                    </a>
                    
                    <a href="?page=profile-jobseeker" class="block w-full px-4 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                        View Profile
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>