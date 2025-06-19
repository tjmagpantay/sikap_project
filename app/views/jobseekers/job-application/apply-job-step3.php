<?php
// filepath: app/views/jobseekers/job-application/apply-job-step3.php
include_once __DIR__ . '/../../components/navbar-top.php';
include_once __DIR__ . '/../navbar-jobseeker.php';
?>

<div class="py-6 mx-auto max-w-4xl sm:px-6 lg:px-8">
    <!-- Progress Bar -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl font-bold text-gray-900">Apply for Job</h1>
            <span class="text-sm text-gray-600">Step 3 of 4</span>
        </div>
        
        <!-- Progress indicators -->
        <div class="flex items-center">
            <div class="flex items-center text-green-600">
                <div class="flex items-center justify-center w-8 h-8 bg-green-600 rounded-full">
                    <i class="fas fa-check text-white text-sm"></i>
                </div>
                <span class="ml-2 text-sm font-medium">Personal Info & Documents</span>
            </div>
            <div class="flex-1 h-1 mx-4 bg-green-600 rounded"></div>
            
            <div class="flex items-center text-green-600">
                <div class="flex items-center justify-center w-8 h-8 bg-green-600 rounded-full">
                    <i class="fas fa-check text-white text-sm"></i>
                </div>
                <span class="ml-2 text-sm font-medium">Screening Questions</span>
            </div>
            <div class="flex-1 h-1 mx-4 bg-green-600 rounded"></div>
            
            <div class="flex items-center text-blue-600">
                <div class="flex items-center justify-center w-8 h-8 bg-blue-600 rounded-full">
                    <span class="text-sm font-medium text-white">3</span>
                </div>
                <span class="ml-2 text-sm font-medium">Eligibility</span>
            </div>
            <div class="flex-1 h-1 mx-4 bg-gray-200 rounded"></div>
            
            <div class="flex items-center text-gray-400">
                <div class="flex items-center justify-center w-8 h-8 bg-gray-200 rounded-full">
                    <span class="text-sm font-medium">4</span>
                </div>
                <span class="ml-2 text-sm font-medium">Review & Submit</span>
            </div>
        </div>
    </div>

    <!-- Job Info Card -->
    <div class="mb-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
        <h2 class="text-lg font-semibold text-blue-900"><?php echo htmlspecialchars($job['job_title']); ?></h2>
        <p class="text-blue-700">
            <?php 
            $companyName = $job['company_name'] ?? 
                          ($job['employer_first_name'] . ' ' . $job['employer_last_name']);
            echo htmlspecialchars($companyName); 
            ?>
        </p>
    </div>

    <!-- Messages -->
    <?php if (!empty($error)): ?>
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
            <p class="text-red-800"><?php echo htmlspecialchars($error); ?></p>
        </div>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
            <p class="text-green-800"><?php echo htmlspecialchars($success); ?></p>
        </div>
    <?php endif; ?>

    <form method="POST" class="space-y-6">
        <!-- Eligibility Information -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-6">Eligibility Information</h3>
            <p class="text-sm text-gray-600 mb-6">
                Please indicate if you're interested in any government programs or belong to priority sectors. 
                This information helps with program placement and priority consideration.
            </p>
            
            <div class="space-y-6">
                <!-- Interested Programs -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">
                        Are you interested in any of these government employment programs?
                    </label>
                    <div class="space-y-3">
                        <label class="flex items-start">
                            <input type="radio" 
                                   name="interested_program" 
                                   value="None" 
                                   <?php echo (($eligibilityData['interested_program'] ?? 'None') === 'None') ? 'checked' : ''; ?>
                                   class="mt-1 text-blue-600 focus:ring-blue-500">
                            <div class="ml-3">
                                <span class="text-sm font-medium text-gray-900">None</span>
                                <p class="text-xs text-gray-500">Not interested in any specific program</p>
                            </div>
                        </label>
                        
                        <label class="flex items-start">
                            <input type="radio" 
                                   name="interested_program" 
                                   value="SPES" 
                                   <?php echo (($eligibilityData['interested_program'] ?? '') === 'SPES') ? 'checked' : ''; ?>
                                   class="mt-1 text-blue-600 focus:ring-blue-500">
                            <div class="ml-3">
                                <span class="text-sm font-medium text-gray-900">SPES (Special Program for Employment of Students)</span>
                                <p class="text-xs text-gray-500">Summer employment program for students</p>
                            </div>
                        </label>
                        
                        <label class="flex items-start">
                            <input type="radio" 
                                   name="interested_program" 
                                   value="TUPAD" 
                                   <?php echo (($eligibilityData['interested_program'] ?? '') === 'TUPAD') ? 'checked' : ''; ?>
                                   class="mt-1 text-blue-600 focus:ring-blue-500">
                            <div class="ml-3">
                                <span class="text-sm font-medium text-gray-900">TUPAD (Tulong Panghanapbuhay sa Ating Disadvantaged/Displaced Workers)</span>
                                <p class="text-xs text-gray-500">Emergency employment for displaced workers</p>
                            </div>
                        </label>
                        
                        <label class="flex items-start">
                            <input type="radio" 
                                   name="interested_program" 
                                   value="GIP" 
                                   <?php echo (($eligibilityData['interested_program'] ?? '') === 'GIP') ? 'checked' : ''; ?>
                                   class="mt-1 text-blue-600 focus:ring-blue-500">
                            <div class="ml-3">
                                <span class="text-sm font-medium text-gray-900">GIP (Government Internship Program)</span>
                                <p class="text-xs text-gray-500">Internship opportunities in government offices</p>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Priority Sectors -->
                <div class="pt-6 border-t border-gray-200">
                    <label class="block text-sm font-medium text-gray-700 mb-3">
                        Do you belong to any priority sector?
                    </label>
                    <div class="space-y-3">
                        <label class="flex items-start">
                            <input type="radio" 
                                   name="priority_sector" 
                                   value="None" 
                                   <?php echo (($eligibilityData['priority_sector'] ?? 'None') === 'None') ? 'checked' : ''; ?>
                                   class="mt-1 text-blue-600 focus:ring-blue-500">
                            <div class="ml-3">
                                <span class="text-sm font-medium text-gray-900">None</span>
                                <p class="text-xs text-gray-500">Not applicable to any priority sector</p>
                            </div>
                        </label>
                        
                        <label class="flex items-start">
                            <input type="radio" 
                                   name="priority_sector" 
                                   value="PWD" 
                                   <?php echo (($eligibilityData['priority_sector'] ?? '') === 'PWD') ? 'checked' : ''; ?>
                                   class="mt-1 text-blue-600 focus:ring-blue-500">
                            <div class="ml-3">
                                <span class="text-sm font-medium text-gray-900">PWD (Person with Disability)</span>
                                <p class="text-xs text-gray-500">Qualified individuals with disabilities</p>
                            </div>
                        </label>
                        
                        <label class="flex items-start">
                            <input type="radio" 
                                   name="priority_sector" 
                                   value="4Ps" 
                                   <?php echo (($eligibilityData['priority_sector'] ?? '') === '4Ps') ? 'checked' : ''; ?>
                                   class="mt-1 text-blue-600 focus:ring-blue-500">
                            <div class="ml-3">
                                <span class="text-sm font-medium text-gray-900">4Ps Beneficiary</span>
                                <p class="text-xs text-gray-500">Pantawid Pamilyang Pilipino Program beneficiary</p>
                            </div>
                        </label>
                        
                        <label class="flex items-start">
                            <input type="radio" 
                                   name="priority_sector" 
                                   value="Solo Parent" 
                                   <?php echo (($eligibilityData['priority_sector'] ?? '') === 'Solo Parent') ? 'checked' : ''; ?>
                                   class="mt-1 text-blue-600 focus:ring-blue-500">
                            <div class="ml-3">
                                <span class="text-sm font-medium text-gray-900">Solo Parent</span>
                                <p class="text-xs text-gray-500">Single parent raising children alone</p>
                            </div>
                        </label>
                        
                        <label class="flex items-start">
                            <input type="radio" 
                                   name="priority_sector" 
                                   value="Senior Citizen" 
                                   <?php echo (($eligibilityData['priority_sector'] ?? '') === 'Senior Citizen') ? 'checked' : ''; ?>
                                   class="mt-1 text-blue-600 focus:ring-blue-500">
                            <div class="ml-3">
                                <span class="text-sm font-medium text-gray-900">Senior Citizen</span>
                                <p class="text-xs text-gray-500">60 years old and above</p>
                            </div>
                        </label>
                        
                        <label class="flex items-start">
                            <input type="radio" 
                                   name="priority_sector" 
                                   value="Youth" 
                                   <?php echo (($eligibilityData['priority_sector'] ?? '') === 'Youth') ? 'checked' : ''; ?>
                                   class="mt-1 text-blue-600 focus:ring-blue-500">
                            <div class="ml-3">
                                <span class="text-sm font-medium text-gray-900">Youth (15-30 years old)</span>
                                <p class="text-xs text-gray-500">Eligible for youth employment programs</p>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Information Box -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex">
                <i class="fas fa-info-circle text-blue-500 mt-1"></i>
                <div class="ml-3">
                    <h4 class="text-sm font-medium text-blue-900">Why we ask this information</h4>
                    <p class="text-sm text-blue-700 mt-1">
                        This information helps employers and government agencies provide appropriate support, 
                        priority consideration, and ensure inclusive hiring practices. All information is kept confidential.
                    </p>
                </div>
            </div>
        </div>

        <!-- Navigation Buttons -->
        <div class="flex justify-between pt-6">
            <a href="?page=apply-job&job_id=<?php echo $job['job_id']; ?>&step=2&application_id=<?php echo $application_id; ?>" 
               class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-md hover:bg-gray-200">
                <i class="fas fa-arrow-left mr-1"></i> Back to Step 2
            </a>
            
            <button type="submit" 
                    class="px-6 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                Continue to Step 4 <i class="fas fa-arrow-right ml-1"></i>
            </button>
        </div>
    </form>
</div>