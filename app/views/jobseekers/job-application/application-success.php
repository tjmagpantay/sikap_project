<?php
include_once __DIR__ . '/../components/jobseeker_auth_check.php';
include_once __DIR__ . '/../../components/navbar-top.php';
include_once __DIR__ . '/../navbar-jobseeker.php';
?>

<div class="min-h-screen py-6">
    <div class="sm:mx-auto sm:w-full sm:max-w-2xl">
        <!-- Job Info Card -->
        <?php if (isset($job)): ?>
            <div class="p-6 mb-4 border rounded-lg bg-blue-50">
                <div class="flex items-start space-x-4">
                    <!-- Business Logo -->
                    <div class="flex items-center justify-center w-12 h-12 overflow-hidden border-2 rounded-lg border-primary">
                        <?php if (!empty($job['business_logo'])): ?>
                            <img src="<?php echo htmlspecialchars($job['business_logo']); ?>" alt="Company Logo"
                                class="object-cover w-full h-full">
                        <?php else: ?>
                            <i class="text-xl text-blue-500 fas fa-building"></i>
                        <?php endif; ?>
                    </div>

                    <div class="flex-1">
                        <h2 class="text-xl font-semibold text-primary"><?php echo htmlspecialchars($job['job_title']); ?></h2>
                        <p class="text-sm text-gray-500">
                            <?php
                            $companyName = $job['company_name'] ??
                                ($job['employer_first_name'] . ' ' . $job['employer_last_name']);
                            echo htmlspecialchars($companyName);
                            ?>
                        </p>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <div class="mt-4 sm:mx-auto sm:w-full sm:max-w-2xl">
        <div class="px-4 py-8 bg-white shadow sm:rounded-lg sm:px-10">
            <!-- Success Header -->
            <div class="mb-8 text-center">
                
                <h1 class="mb-2 text-2xl font-bold text-primary">Application Submitted Successfully!</h1>
                <p class="text-sm text-gray-600">Your job application has been sent to the employer for review.</p>
            </div>

            <!-- Application Details -->
            <?php if (isset($applicationData)): ?>
                <div class="mb-8">
                    <h2 class="mb-4 text-lg font-semibold text-primary">Application Details</h2>

                    <div class="p-4 space-y-3 border border-gray-200 rounded-lg bg-gray-50">
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-gray-600">Application ID:</span>
                            <span class="text-sm font-semibold text-primary">#<?php echo str_pad($applicationData['application_id'], 6, '0', STR_PAD_LEFT); ?></span>
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
            <div class="mb-8">
                <h3 class="mb-6 text-lg font-semibold text-primary">What happens next?</h3>

                <div class="space-y-6">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center w-8 h-8 bg-blue-100 rounded-full">
                                <span class="text-sm font-medium text-blue-600">1</span>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-sm font-medium text-gray-900">Application Review</h4>
                            <p class="mt-1 text-sm text-gray-600">The employer will review your application and supporting documents.</p>
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
                            <p class="mt-1 text-sm text-gray-600">If you meet the requirements, you may be shortlisted for the next stage.</p>
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
                            <p class="mt-1 text-sm text-gray-600">Shortlisted candidates will be contacted for interviews or additional assessments.</p>
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
                            <p class="mt-1 text-sm text-gray-600">You'll be notified of the employer's decision via email and system notification.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Important Notes -->
            <div class="p-4 mb-8 border border-blue-200 rounded-lg bg-blue-50">
                <div class="flex">
                    <svg class="w-5 h-5 mt-1 text-primary" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                    </svg>
                    <div class="ml-3">
                        <h4 class="text-sm font-medium text-primary ">Important Notes</h4>
                        <ul class="mt-2 space-y-1 text-sm list-disc li t-inside text-primary">
                            <li>You will receive email notifications for status updates</li>
                            <li>You can track your application status in your dashboard</li>
                            <li>Keep your contact information updated</li>
                            <li>Response times vary by employer</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col gap-3 sm:flex-row">
                <a href="?page=my-applications"
                    class="inline-flex items-center justify-center flex-1 px-4 py-2 text-sm font-medium text-white border border-transparent rounded-md shadow-sm bg-primary hover:bg-blue-700">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    View My Applications
                </a>

                
            </div>
        </div>
    </div>
</div>