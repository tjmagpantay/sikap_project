<?php include_once __DIR__ . '/../components/navbar-top.php'; 
      include_once __DIR__ . '/navbar-jobseeker.php';
?>

<div class="min-h-screen py-12 bg-gray-50 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-2xl">
        <div class="text-center">
            <div class="flex justify-center mb-4">
                <div class="p-3 bg-green-600 rounded-full">
                    <i class="text-2xl text-white fas fa-certificate"></i>
                </div>
            </div>
            <h2 class="mt-6 text-3xl font-extrabold text-center text-gray-900">
                Certificates & Licenses <span class="text-sm font-normal text-gray-500">(OPTIONAL)</span>
            </h2>
            <p class="mt-2 text-sm text-center text-gray-600">
                Step 7/8
            </p>
            <p class="mt-2 text-sm text-center text-gray-500">
                Share any certifications or licenses you've earned.
            </p>
        </div>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-2xl">
        <div class="px-4 py-8 bg-white shadow sm:rounded-lg sm:px-10">
            <!-- Progress bar -->
            <div class="w-full h-1 mb-6 bg-gray-200 rounded">
                <div class="h-1 bg-blue-600 rounded" style="width: 87.5%"></div>
            </div>

            <form class="space-y-6" method="POST" action="?page=complete-jobseeker-profile&step=7">
                <div>
                    <label for="certificate_title" class="block text-sm font-medium text-gray-700">
                        Certificate/License Title
                    </label>
                    <div class="mt-1">
                        <input id="certificate_title" name="certificate_title" type="text"
                               placeholder="Certificate/License Title"
                               class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-green-500 focus:border-green-500">
                    </div>
                </div>

                <div>
                    <label for="issuing_organization" class="block text-sm font-medium text-gray-700">
                        Issuing Organization
                    </label>
                    <div class="mt-1">
                        <input id="issuing_organization" name="issuing_organization" type="text"
                               placeholder="Issuing Organization"
                               class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-green-500 focus:border-green-500">
                    </div>
                </div>

                <div>
                    <label for="date_issued" class="block text-sm font-medium text-gray-700">
                        Date Issued
                    </label>
                    <div class="mt-1">
                        <input id="date_issued" name="date_issued" type="date"
                               class="block w-full px-3 py-2 border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-green-500 focus:border-green-500">
                    </div>
                </div>

                <div class="flex justify-between">
                    <a href="?page=complete-jobseeker-profile&step=8" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                        Skip For Now
                    </a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md hover:bg-green-700">
                        Next Step
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>