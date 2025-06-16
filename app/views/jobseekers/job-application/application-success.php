<?php
// filepath: app/views/jobseekers/application-success.php
include_once __DIR__ . '/../../components/navbar-top.php';
include_once __DIR__ . '/../navbar-jobseeker.php';
?>

<div class="max-w-4xl py-6 mx-auto sm:px-6 lg:px-8">
    <div class="text-center">
        <!-- Success Icon -->
        <div class="flex items-center justify-center w-20 h-20 mx-auto mb-6 bg-green-100 rounded-full">
            <i class="text-3xl text-green-600 fas fa-check-circle"></i>
        </div>

        <!-- Success Message -->
        <h1 class="mb-4 text-3xl font-bold text-gray-900">Application Submitted Successfully!</h1>
        <p class="mb-8 text-lg text-gray-600">
            Your application for <strong><?php echo htmlspecialchars($application['job_title']); ?></strong> 
            has been submitted to <?php echo htmlspecialchars($application['company_name'] ?? 'the employer'); ?>.
        </p>

        <!-- Application Details Card -->
        <div class="max-w-2xl p-6 mx-auto mb-8 text-left bg-white rounded-lg shadow">
            <h3 class="mb-4 text-lg font-medium text-gray-900">Application Details</h3>
            
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-sm font-medium text-gray-500">Application ID:</span>
                    <span class="text-sm text-gray-900">#<?php echo str_pad($application['application_id'], 6, '0', STR_PAD_LEFT); ?></span>
                </div>
                
                <div class="flex justify-between">
                    <span class="text-sm font-medium text-gray-500">Job Title:</span>
                    <span class="text-sm text-gray-900"><?php echo htmlspecialchars($application['job_title']); ?></span>
                </div>
                
                <div class="flex justify-between">
                    <span class="text-sm font-medium text-gray-500">Company:</span>
                    <span class="text-sm text-gray-900"><?php echo htmlspecialchars($application['company_name'] ?? 'N/A'); ?></span>
                </div>
                
                <div class="flex justify-between">
                    <span class="text-sm font-medium text-gray-500">Applied On:</span>
                    <span class="text-sm text-gray-900"><?php echo date('F j, Y \a\t g:i A', strtotime($application['applied_at'])); ?></span>
                </div>
                
                <div class="flex justify-between">
                    <span class="text-sm font-medium text-gray-500">Status:</span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                        Pending Review
                    </span>
                </div>
            </div>
        </div>

        <!-- What's Next Section -->
        <div class="max-w-2xl p-6 mx-auto mb-8 border border-blue-200 rounded-lg bg-blue-50">
            <h3 class="mb-3 text-lg font-medium text-blue-900">What happens next?</h3>
            <ul class="space-y-2 text-sm text-left text-blue-800">
                <li class="flex items-start">
                    <i class="fas fa-check-circle mr-2 mt-0.5 text-blue-600"></i>
                    Your application is now in the employer's queue for review
                </li>
                <li class="flex items-start">
                    <i class="fas fa-eye mr-2 mt-0.5 text-blue-600"></i>
                    The employer will review your application and qualifications
                </li>
                <li class="flex items-start">
                    <i class="fas fa-envelope mr-2 mt-0.5 text-blue-600"></i>
                    You'll receive updates about your application status via email
                </li>
                <li class="flex items-start">
                    <i class="fas fa-phone mr-2 mt-0.5 text-blue-600"></i>
                    If shortlisted, the employer may contact you for an interview
                </li>
            </ul>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col justify-center gap-4 sm:flex-row">
            <a href="?page=view-application&id=<?php echo $application['application_id']; ?>" 
               class="inline-flex items-center px-6 py-3 text-sm font-medium text-blue-600 bg-blue-100 border border-blue-300 rounded-md hover:bg-blue-200">
                <i class="mr-2 fas fa-eye"></i>
                View Application Details
            </a>
            
            <a href="?page=my-applications" 
               class="inline-flex items-center px-6 py-3 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                <i class="mr-2 fas fa-list"></i>
                View All Applications
            </a>
            
            <a href="?page=browse-jobs" 
               class="inline-flex items-center px-6 py-3 text-sm font-medium text-gray-700 bg-gray-200 border border-gray-300 rounded-md hover:bg-gray-300">
                <i class="mr-2 fas fa-search"></i>
                Browse More Jobs
            </a>
        </div>

        <!-- Tips Section -->
        <div class="max-w-2xl mx-auto mt-12">
            <h3 class="mb-4 text-lg font-medium text-gray-900">Tips while you wait</h3>
            <div class="grid grid-cols-1 gap-4 text-sm md:grid-cols-2">
                <div class="p-4 rounded-lg bg-gray-50">
                    <i class="mb-2 text-blue-600 fas fa-user-edit"></i>
                    <h4 class="mb-1 font-medium text-gray-900">Keep your profile updated</h4>
                    <p class="text-gray-600">Ensure your profile and resume are always current</p>
                </div>
                
                <div class="p-4 rounded-lg bg-gray-50">
                    <i class="mb-2 text-blue-600 fas fa-search"></i>
                    <h4 class="mb-1 font-medium text-gray-900">Continue job searching</h4>
                    <p class="text-gray-600">Apply to multiple positions to increase your chances</p>
                </div>
                
                <div class="p-4 rounded-lg bg-gray-50">
                    <i class="mb-2 text-blue-600 fas fa-network-wired"></i>
                    <h4 class="mb-1 font-medium text-gray-900">Network actively</h4>
                    <p class="text-gray-600">Connect with professionals in your field</p>
                </div>
                
                <div class="p-4 rounded-lg bg-gray-50">
                    <i class="mb-2 text-blue-600 fas fa-graduation-cap"></i>
                    <h4 class="mb-1 font-medium text-gray-900">Improve your skills</h4>
                    <p class="text-gray-600">Take courses or certifications relevant to your field</p>
                </div>
            </div>
        </div>
    </div>
</div>