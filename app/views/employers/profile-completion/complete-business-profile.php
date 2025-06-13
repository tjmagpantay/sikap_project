<?php include_once __DIR__ . '/../../components/navbar-top.php';
include_once __DIR__ . '/../navbar-employer.php';?>

<div class="min-h-screen py-12 bg-gray-50 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-2xl">
        <div class="text-center">
            <div class="flex justify-center mb-4">
                <div class="p-3 bg-blue-600 rounded-full">
                    <i class="text-2xl text-white fas fa-building"></i>
                </div>
            </div>
            <h2 class="mt-6 text-3xl font-extrabold text-center text-gray-900">
                Business Setup
            </h2>
            <p class="mt-2 text-sm text-center text-gray-600">
                Step 2/2 - Company Information
            </p>
            <p class="mt-2 text-sm text-center text-gray-500">
                Set up your business details and documents
            </p>
        </div>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-2xl">
        <div class="px-4 py-8 bg-white shadow sm:rounded-lg sm:px-10">
            <!-- Progress bar -->
            <div class="w-full h-2 mb-6 bg-gray-200 rounded">
                <div class="h-2 bg-blue-600 rounded" style="width: 100%"></div>
            </div>

            <!-- Step Navigation -->
            <div class="mb-6">
                <nav class="flex space-x-4">
                    <a href="?page=complete-employer-profile&step=1" 
                       class="flex-1 px-4 py-2 text-sm font-medium text-center text-green-700 transition-colors bg-green-100 rounded-md">
                        <i class="mr-1 fas fa-check"></i>
                        Personal Info
                    </a>
                    <a href="?page=complete-employer-profile&step=2" 
                       class="flex-1 px-4 py-2 text-sm font-medium text-center text-white transition-colors bg-blue-600 rounded-md">
                        Business Setup
                    </a>
                </nav>
            </div>

            <!-- Content -->
            <div class="py-12 text-center">
                <i class="mb-4 text-5xl text-gray-300 fas fa-tools"></i>
                <h3 class="mb-2 text-xl font-medium text-gray-900">Business Setup Coming Soon</h3>
                <p class="mb-6 text-gray-600">This section will include company details, social media links, and document uploads.</p>
                
                <div class="flex justify-center space-x-4">
                    <a href="?page=complete-employer-profile&step=1" 
                       class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                        <i class="mr-2 fas fa-arrow-left"></i>
                        Back to Personal Info
                    </a>
                    <a href="?page=employer-dashboard" 
                       class="inline-flex items-center px-6 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                        Go to Dashboard
                        <i class="ml-2 fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>