<?php
// filepath: c:\xampp\htdocs\sikap\app\views\employers\profile-completion\complete-business-profile.php
require_once __DIR__ . '/../../../models/Employer.php';

$employerModel = new Employer();
$employer = $employerModel->findByUserId($_SESSION['user_id']);

// Check completion status
$personalCompleted = !empty($employer['first_name']) && !empty($employer['last_name']) && !empty($employer['position']);
$businessCompleted = false; // You can check business completion here when you implement it
?>

<?php include_once __DIR__ . '/../../components/navbar-top.php';
include_once __DIR__ . '/../navbar-employer.php';
?>

<div class="min-h-screen py-12 bg-gray-50 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-4xl">
        <div class="text-center mb-8">
            <div class="flex justify-center mb-4">
                <div class="p-3 bg-blue-600 rounded-full">
                    <i class="text-2xl text-white fas fa-user-cog"></i>
                </div>
            </div>
            <h2 class="mt-6 text-3xl font-extrabold text-center text-gray-900">
                Complete Your Profile
            </h2>
            <p class="mt-2 text-sm text-center text-gray-600">
                Choose what you'd like to set up next
            </p>
        </div>

        <!-- Success Message -->
        <?php if (!empty($_GET['success'])): ?>
            <div class="mb-6 max-w-2xl mx-auto">
                <div class="p-4 border border-green-200 rounded-md bg-green-50">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="text-green-400 fas fa-check-circle"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-600"><?php echo htmlspecialchars($_GET['success']); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Profile Setup Options -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl mx-auto">
            
            <!-- Personal Profile Setup -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <div class="flex-shrink-0">
                            <?php if ($personalCompleted): ?>
                                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-check text-green-600"></i>
                                </div>
                            <?php else: ?>
                                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-blue-600"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">Personal Profile</h3>
                            <p class="text-sm text-gray-500">
                                <?php echo $personalCompleted ? 'Completed' : 'Set up your personal information'; ?>
                            </p>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <p class="text-sm text-gray-600 mb-3">Includes:</p>
                        <ul class="text-sm text-gray-500 space-y-1">
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-2 text-xs"></i>
                                Personal information
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-2 text-xs"></i>
                                Contact details
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-2 text-xs"></i>
                                Position & company info
                            </li>
                        </ul>
                    </div>

                    <div class="mt-6">
                        <?php if ($personalCompleted): ?>
                            <a href="?page=complete-employer-profile&step=1" 
                               class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                                <i class="mr-2 fas fa-edit"></i>
                                Edit Profile
                            </a>
                        <?php else: ?>
                            <a href="?page=complete-employer-profile&step=1" 
                               class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 transition-colors">
                                <i class="mr-2 fas fa-plus"></i>
                                Set Up Profile
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Business Setup -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-orange-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-building text-orange-600"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">Business Setup</h3>
                            <p class="text-sm text-gray-500">Set up your business information</p>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <p class="text-sm text-gray-600 mb-3">Includes:</p>
                        <ul class="text-sm text-gray-500 space-y-1">
                            <li class="flex items-center">
                                <i class="fas fa-circle text-gray-300 mr-2 text-xs"></i>
                                Company details
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-circle text-gray-300 mr-2 text-xs"></i>
                                Social media links
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-circle text-gray-300 mr-2 text-xs"></i>
                                Business documents
                            </li>
                        </ul>
                    </div>

                    <div class="mt-6">
                        <?php if (!$personalCompleted): ?>
                            <button disabled 
                                    class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-400 bg-gray-100 cursor-not-allowed">
                                <i class="mr-2 fas fa-lock"></i>
                                Complete Personal Profile First
                            </button>
                        <?php else: ?>
                            <a href="?page=complete-employer-business&step=1" 
                               class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-orange-600 hover:bg-orange-700 transition-colors">
                                <i class="mr-2 fas fa-plus"></i>
                                Set Up Business
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-8 flex justify-center space-x-4">
            <a href="?page=employer-dashboard" 
               class="inline-flex items-center px-6 py-3 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                <i class="mr-2 fas fa-arrow-left"></i>
                Back to Dashboard
            </a>
        </div>
    </div>
</div>