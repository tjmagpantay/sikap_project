<?php
// filepath: app/views/jobseekers/job-application/application-success.php
include_once __DIR__ . '/../../components/navbar-top.php';
include_once __DIR__ . '/../navbar-jobseeker.php';
?>

<div class="max-w-3xl py-12 mx-auto sm:px-6 lg:px-8">
    <div class="overflow-hidden bg-white rounded-lg shadow-lg">
        <!-- Success Header -->
        <div class="px-6 py-8 text-center bg-green-50">
            <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 bg-green-100 rounded-full">
                <i class="text-2xl text-green-600 fas fa-check"></i>
            </div>
            <h1 class="mb-2 text-2xl font-bold text-green-900">Application Submitted Successfully!</h1>
            <p class="text-green-700">Your job application has been sent to the employer for review.</p>
        </div>

        <!-- Application Details -->
        <div class="px-6 py-6">
            <?php if (isset($applicationData)): ?>
                <div class="mb-6">
                    <h2 class="mb-4 text-lg font-semibold text-gray-900">Application Details</h2>
                    
                    <div class="p-4 space-y-3 rounded-lg bg-gray-50">
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-gray-600">Application ID:</span>
                            <span class="text-sm text-gray-900">#<?php echo str_pad($applicationData['application_id'], 6, '0', STR_PAD_LEFT); ?></span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-gray-600">Job Title:</span>
                            <span class="text-sm text-gray-900"><?php echo htmlspecialchars($job['job_title']); ?></span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-gray-600">Company:</span>
                            <span class="text-sm text-gray-900">
                                <?php 
                                $companyName = $job['company_name'] ?? 
                                              ($job['employer_first_name'] . ' ' . $job['employer_last_name']);
                                echo htmlspecialchars($companyName); 
                                ?>
                            </span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-gray-600">Submitted:</span>
                            <span class="text-sm text-gray-900"><?php echo date('F j, Y \a\t g:i A', strtotime($applicationData['applied_at'])); ?></span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-gray-600">Status:</span>
                            <span class="inline-flex px-2 py-1 text-xs font-medium text-yellow-800 bg-yellow-100 rounded-full">
                                Pending Review
                            </span>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- What Happens Next -->
            <div class="mb-6">
                <h3 class="mb-4 text-lg font-semibold text-gray-900">What happens next?</h3>
                
                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center w-8 h-8 bg-blue-100 rounded-full">
                                <span class="text-sm font-medium text-blue-600">1</span>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-sm font-medium text-gray-900">Application Review</h4>
                            <p class="text-sm text-gray-600">The employer will review your application and supporting documents.</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center w-8 h-8 bg-blue-100 rounded-full">
                                <span class="text-sm font-medium text-blue-600">2</span>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-sm font-medium text-gray-900">Initial Screening</h4>
                            <p class="text-sm text-gray-600">If you meet the requirements, you may be shortlisted for the next stage.</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center w-8 h-8 bg-blue-100 rounded-full">
                                <span class="text-sm font-medium text-blue-600">3</span>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-sm font-medium text-gray-900">Interview Process</h4>
                            <p class="text-sm text-gray-600">Shortlisted candidates will be contacted for interviews or additional assessments.</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center w-8 h-8 bg-blue-100 rounded-full">
                                <span class="text-sm font-medium text-blue-600">4</span>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-sm font-medium text-gray-900">Final Decision</h4>
                            <p class="text-sm text-gray-600">You'll be notified of the employer's decision via email and system notification.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Important Notes -->
            <div class="p-4 mb-6 border border-blue-200 rounded-lg bg-blue-50">
                <div class="flex">
                    <i class="mt-1 text-blue-500 fas fa-info-circle"></i>
                    <div class="ml-3">
                        <h4 class="text-sm font-medium text-blue-900">Important Notes</h4>
                        <ul class="mt-2 space-y-1 text-sm text-blue-700 list-disc list-inside">
                            <li>You will receive email notifications for status updates</li>
                            <li>You can track your application status in your dashboard</li>
                            <li>Keep your contact information updated</li>
                            <li>Response times vary by employer</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col gap-4 sm:flex-row">
                <a href="?page=my-applications" 
                   class="flex-1 px-4 py-2 text-sm font-medium text-center text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                    <i class="mr-2 fas fa-list"></i>View My Applications
                </a>
                
                <a href="?page=browse-jobs" 
                   class="flex-1 px-4 py-2 text-sm font-medium text-center text-blue-600 bg-blue-100 border border-blue-300 rounded-md hover:bg-blue-200">
                    <i class="mr-2 fas fa-search"></i>Browse More Jobs
                </a>
                
                <a href="?page=dashboard" 
                   class="flex-1 px-4 py-2 text-sm font-medium text-center text-gray-700 bg-gray-100 border border-gray-300 rounded-md hover:bg-gray-200">
                    <i class="mr-2 fas fa-home"></i>Go to Dashboard
                </a>
            </div>
        </div>
    </div>
</div>