<?php
// filepath: app/views/jobseekers/job-application/apply-job-step3.php
include_once __DIR__ . '/../../components/navbar-top.php';
include_once __DIR__ . '/../navbar-jobseeker.php';
?>

<div class="min-h-screen py-6">
    <div class="sm:mx-auto sm:w-full sm:max-w-2xl">

        <!-- Job Info Card -->
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
    </div>

    <div class="mt-4 sm:mx-auto sm:w-full sm:max-w-2xl">
        <div class="px-4 py-8 bg-white shadow sm:rounded-lg sm:px-10">
            <!-- Enhanced Progress bar -->
            <div class="mb-6">
                <!-- Step indicators -->
                <div class="flex items-center justify-between w-full mb-4">
                    <!-- Step 1 -->
                    <div class="flex flex-col items-center">
                        <a href="?page=apply-job&job_id=<?php echo $job['job_id']; ?>&step=1&application_id=<?php echo $application_id; ?>"
                            class="flex items-center justify-center w-8 h-8 text-white transition-colors bg-green-600 rounded-full hover:bg-green-700">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        <span class="mt-1 text-xs text-gray-600">Personal Info</span>
                    </div>

                    <!-- Step 2 -->
                    <div class="flex flex-col items-center">
                        <a href="?page=apply-job&job_id=<?php echo $job['job_id']; ?>&step=2&application_id=<?php echo $application_id; ?>"
                            class="flex items-center justify-center w-8 h-8 text-white transition-colors bg-green-600 rounded-full hover:bg-green-700">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        <span class="mt-1 text-xs text-gray-600">Screening</span>
                    </div>

                    <!-- Step 3 -->
                    <div class="flex flex-col items-center">
                        <div class="flex items-center justify-center w-8 h-8 text-white rounded-full bg-primary">
                            <span class="text-sm font-semibold">3</span>
                        </div>
                        <span class="mt-1 text-xs text-gray-600">Eligibility</span>
                    </div>

                    <!-- Step 4 -->
                    <div class="flex flex-col items-center">
                        <a href="?page=apply-job&job_id=<?php echo $job['job_id']; ?>&step=4&application_id=<?php echo $application_id; ?>"
                            class="flex items-center justify-center w-8 h-8 text-gray-500 transition-colors bg-gray-200 rounded-full hover:bg-gray-300 hover:text-gray-700">
                            <span class="text-sm font-semibold">4</span>
                        </a>
                        <span class="mt-1 text-xs text-gray-500">Review</span>
                    </div>
                </div>

                <!-- Progress bar -->
                <div class="w-full h-2 bg-gray-200 rounded">
                    <div class="h-2 rounded bg-primary" style="width: 75%"></div>
                </div>
            </div>

            <!-- Error Messages -->
            <?php if (!empty($error)): ?>
                <div class="p-4 mb-4 border border-red-200 rounded-md bg-red-50">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-600"><?php echo htmlspecialchars($error); ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (!empty($success)): ?>
                <div class="p-4 mb-4 border border-green-200 rounded-md bg-green-50">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-600"><?php echo htmlspecialchars($success); ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <form class="space-y-6" method="POST">
                <!-- Eligibility Information -->
                <div>
                    <label class="block mb-4 font-medium text-md text-primary">
                        Eligibility Information
                    </label>
                    <p class="mb-6 text-sm text-gray-600">
                        Please indicate if you're interested in any government programs or belong to priority sectors.
                        This information helps with program placement and priority consideration.
                    </p>

                    <div class="space-y-6">
                        <!-- Interested Programs -->
                        <div class="p-4 border border-gray-200 rounded-lg bg-gray-50">
                            <label class="block mb-3 text-sm font-medium text-gray-900">
                                Are you interested in any of these government employment programs?
                            </label>
                            <div class="space-y-3">
                                <label class="flex items-start p-2 transition-colors rounded-md hover:bg-gray-100">
                                    <input type="radio"
                                        name="interested_program"
                                        value="None"
                                        <?php echo (($eligibilityData['interested_program'] ?? 'None') === 'None') ? 'checked' : ''; ?>
                                        class="w-4 h-4 mt-1 border-gray-300 rounded text-primary focus:ring-primary/50 focus:border-primary">
                                    <div class="ml-3">
                                        <span class="text-sm font-medium text-gray-900">None</span>
                                        <p class="text-xs text-gray-500">Not interested in any specific program</p>
                                    </div>
                                </label>

                                <label class="flex items-start p-2 transition-colors rounded-md hover:bg-gray-100">
                                    <input type="radio"
                                        name="interested_program"
                                        value="SPES"
                                        <?php echo (($eligibilityData['interested_program'] ?? '') === 'SPES') ? 'checked' : ''; ?>
                                        class="w-4 h-4 mt-1 border-gray-300 rounded text-primary focus:ring-primary/50 focus:border-primary">
                                    <div class="ml-3">
                                        <span class="text-sm font-medium text-gray-900">SPES (Special Program for Employment of Students)</span>
                                        <p class="text-xs text-gray-500">Summer employment program for students</p>
                                    </div>
                                </label>

                                <label class="flex items-start p-2 transition-colors rounded-md hover:bg-gray-100">
                                    <input type="radio"
                                        name="interested_program"
                                        value="TUPAD"
                                        <?php echo (($eligibilityData['interested_program'] ?? '') === 'TUPAD') ? 'checked' : ''; ?>
                                        class="w-4 h-4 mt-1 border-gray-300 rounded text-primary focus:ring-primary/50 focus:border-primary">
                                    <div class="ml-3">
                                        <span class="text-sm font-medium text-gray-900">TUPAD (Tulong Panghanapbuhay sa Ating Disadvantaged/Displaced Workers)</span>
                                        <p class="text-xs text-gray-500">Emergency employment for displaced workers</p>
                                    </div>
                                </label>

                                <label class="flex items-start p-2 transition-colors rounded-md hover:bg-gray-100">
                                    <input type="radio"
                                        name="interested_program"
                                        value="GIP"
                                        <?php echo (($eligibilityData['interested_program'] ?? '') === 'GIP') ? 'checked' : ''; ?>
                                        class="w-4 h-4 mt-1 border-gray-300 rounded text-primary focus:ring-primary/50 focus:border-primary">
                                    <div class="ml-3">
                                        <span class="text-sm font-medium text-gray-900">GIP (Government Internship Program)</span>
                                        <p class="text-xs text-gray-500">Internship opportunities in government offices</p>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Priority Sectors -->
                        <div class="p-4 border border-gray-200 rounded-lg bg-gray-50">
                            <label class="block mb-3 text-sm font-medium text-gray-900">
                                Do you belong to any priority sector?
                            </label>
                            <div class="space-y-3">
                                <label class="flex items-start p-2 transition-colors rounded-md hover:bg-gray-100">
                                    <input type="radio"
                                        name="priority_sector"
                                        value="None"
                                        <?php echo (($eligibilityData['priority_sector'] ?? 'None') === 'None') ? 'checked' : ''; ?>
                                        class="w-4 h-4 mt-1 border-gray-300 rounded text-primary focus:ring-primary/50 focus:border-primary">
                                    <div class="ml-3">
                                        <span class="text-sm font-medium text-gray-900">None</span>
                                        <p class="text-xs text-gray-500">Not applicable to any priority sector</p>
                                    </div>
                                </label>

                                <label class="flex items-start p-2 transition-colors rounded-md hover:bg-gray-100">
                                    <input type="radio"
                                        name="priority_sector"
                                        value="PWD"
                                        <?php echo (($eligibilityData['priority_sector'] ?? '') === 'PWD') ? 'checked' : ''; ?>
                                        class="w-4 h-4 mt-1 border-gray-300 rounded text-primary focus:ring-primary/50 focus:border-primary">
                                    <div class="ml-3">
                                        <span class="text-sm font-medium text-gray-900">PWD (Person with Disability)</span>
                                        <p class="text-xs text-gray-500">Qualified individuals with disabilities</p>
                                    </div>
                                </label>

                                <label class="flex items-start p-2 transition-colors rounded-md hover:bg-gray-100">
                                    <input type="radio"
                                        name="priority_sector"
                                        value="4Ps"
                                        <?php echo (($eligibilityData['priority_sector'] ?? '') === '4Ps') ? 'checked' : ''; ?>
                                        class="w-4 h-4 mt-1 border-gray-300 rounded text-primary focus:ring-primary/50 focus:border-primary">
                                    <div class="ml-3">
                                        <span class="text-sm font-medium text-gray-900">4Ps Beneficiary</span>
                                        <p class="text-xs text-gray-500">Pantawid Pamilyang Pilipino Program beneficiary</p>
                                    </div>
                                </label>

                                <label class="flex items-start p-2 transition-colors rounded-md hover:bg-gray-100">
                                    <input type="radio"
                                        name="priority_sector"
                                        value="Solo Parent"
                                        <?php echo (($eligibilityData['priority_sector'] ?? '') === 'Solo Parent') ? 'checked' : ''; ?>
                                        class="w-4 h-4 mt-1 border-gray-300 rounded text-primary focus:ring-primary/50 focus:border-primary">
                                    <div class="ml-3">
                                        <span class="text-sm font-medium text-gray-900">Solo Parent</span>
                                        <p class="text-xs text-gray-500">Single parent raising children alone</p>
                                    </div>
                                </label>

                                <label class="flex items-start p-2 transition-colors rounded-md hover:bg-gray-100">
                                    <input type="radio"
                                        name="priority_sector"
                                        value="Senior Citizen"
                                        <?php echo (($eligibilityData['priority_sector'] ?? '') === 'Senior Citizen') ? 'checked' : ''; ?>
                                        class="w-4 h-4 mt-1 border-gray-300 rounded text-primary focus:ring-primary/50 focus:border-primary">
                                    <div class="ml-3">
                                        <span class="text-sm font-medium text-gray-900">Senior Citizen</span>
                                        <p class="text-xs text-gray-500">60 years old and above</p>
                                    </div>
                                </label>

                                <label class="flex items-start p-2 transition-colors rounded-md hover:bg-gray-100">
                                    <input type="radio"
                                        name="priority_sector"
                                        value="Youth"
                                        <?php echo (($eligibilityData['priority_sector'] ?? '') === 'Youth') ? 'checked' : ''; ?>
                                        class="w-4 h-4 mt-1 border-gray-300 rounded text-primary focus:ring-primary/50 focus:border-primary">
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
                <div class="p-4 border border-blue-200 rounded-lg bg-blue-50">
                    <div class="flex">
                        <svg class="w-5 h-5 mt-0.5 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                        <div class="ml-3">
                            <h4 class="text-sm font-medium text-blue-900">Why we ask this information</h4>
                            <p class="mt-1 text-sm text-blue-700">
                                This information helps employers and government agencies provide appropriate support,
                                priority consideration, and ensure inclusive hiring practices. All information is kept confidential.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="flex justify-between">
                    <a href="?page=apply-job&job_id=<?php echo $job['job_id']; ?>&step=2&application_id=<?php echo $application_id; ?>"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back to Step 2
                    </a>

                    <button type="submit"
                        class="inline-flex items-center px-6 py-2 text-sm font-medium text-white border border-transparent rounded-md shadow-sm bg-primary hover:bg-blue-700">
                        Continue to Step 4
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>