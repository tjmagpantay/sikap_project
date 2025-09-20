<?php
include_once __DIR__ . '/../components/jobseeker_auth_check.php';
include_once __DIR__ . '/../../components/navbar-top.php';
include_once __DIR__ . '/../components/navbar-jobseeker.php';
?>

<div class="min-h-screen py-6">
    <div class="sm:mx-auto sm:w-full sm:max-w-4xl">
        <div class="text-center">
            <div class="flex justify-center mb-4">
                <div class="flex items-center justify-center w-12 h-12 bg-green-100 rounded-full">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <h2 class="mt-6 text-3xl font-extrabold text-center text-gray-900">
                Resume Parsed Successfully!
            </h2>
            <p class="mt-2 text-sm text-center text-gray-500">
                We've extracted the following information from your resume. Please review and confirm.
            </p>
        </div>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-4xl">
        <div class="px-4 py-8 bg-white shadow sm:rounded-lg sm:px-10">
            
            <form method="POST" action="?page=review-parsed-data">
                <!-- Personal Information -->
                <div class="mb-8">
                    <h3 class="mb-4 text-lg font-medium text-gray-900">Personal Information</h3>
                    <div class="p-4 rounded-lg bg-gray-50">
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            <?php if (!empty($parsedData['name_data']['first_name'])): ?>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">First Name</label>
                                <p class="mt-1 text-sm text-gray-900"><?php echo htmlspecialchars($parsedData['name_data']['first_name']); ?></p>
                            </div>
                            <?php endif; ?>
                            
                            <?php if (!empty($parsedData['name_data']['last_name'])): ?>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Last Name</label>
                                <p class="mt-1 text-sm text-gray-900"><?php echo htmlspecialchars($parsedData['name_data']['last_name']); ?></p>
                            </div>
                            <?php endif; ?>
                            
                            <?php if (!empty($parsedData['email'])): ?>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Email</label>
                                <p class="mt-1 text-sm text-gray-900"><?php echo htmlspecialchars($parsedData['email']); ?></p>
                            </div>
                            <?php endif; ?>
                            
                            <?php if (!empty($parsedData['phone'])): ?>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Phone</label>
                                <p class="mt-1 text-sm text-gray-900"><?php echo htmlspecialchars($parsedData['phone']); ?></p>
                            </div>
                            <?php endif; ?>
                            
                            <?php if (!empty($parsedData['address'])): ?>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Address</label>
                                <p class="mt-1 text-sm text-gray-900"><?php echo htmlspecialchars($parsedData['address']); ?></p>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Skills -->
                <?php if (!empty($parsedData['skills'])): ?>
                <div class="mb-8">
                    <h3 class="mb-4 text-lg font-medium text-gray-900">Skills Detected</h3>
                    <div class="p-4 rounded-lg bg-gray-50">
                        <div class="flex flex-wrap gap-2">
                            <?php foreach ($parsedData['skills'] as $skill): ?>
                                <span class="inline-flex items-center px-3 py-1 text-sm font-medium text-blue-800 bg-blue-100 rounded-full">
                                    <?php echo htmlspecialchars($skill['skill_name']); ?>
                                    <?php if (isset($skill['esco_uri'])): ?>
                                        <span class="ml-1 text-xs text-blue-600">(ESCO Matched)</span>
                                    <?php endif; ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Work Experience -->
                <?php if (!empty($parsedData['experience'])): ?>
                <div class="mb-8">
                    <h3 class="mb-4 text-lg font-medium text-gray-900">Work Experience</h3>
                    <div class="p-4 space-y-4 rounded-lg bg-gray-50">
                        <?php foreach ($parsedData['experience'] as $exp): ?>
                            <div class="pl-4 border-l-4 border-blue-500">
                                <h4 class="font-medium text-gray-900"><?php echo htmlspecialchars($exp['job_title']); ?></h4>
                                <p class="text-sm text-gray-600"><?php echo htmlspecialchars($exp['company_name']); ?></p>
                                <p class="text-xs text-gray-500">
                                    <?php echo htmlspecialchars($exp['start_date'] ?? 'N/A'); ?> - 
                                    <?php echo $exp['currently_working'] === 'Yes' ? 'Present' : htmlspecialchars($exp['end_date'] ?? 'N/A'); ?>
                                </p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Education -->
                <?php if (!empty($parsedData['education']) && !empty($parsedData['education']['school_name'])): ?>
                <div class="mb-8">
                    <h3 class="mb-4 text-lg font-medium text-gray-900">Education</h3>
                    <div class="p-4 rounded-lg bg-gray-50">
                        <h4 class="font-medium text-gray-900"><?php echo htmlspecialchars($parsedData['education']['education_level']); ?></h4>
                        <p class="text-sm text-gray-600"><?php echo htmlspecialchars($parsedData['education']['school_name']); ?></p>
                        <?php if (!empty($parsedData['education']['field_of_study'])): ?>
                            <p class="text-sm text-gray-600">Field: <?php echo htmlspecialchars($parsedData['education']['field_of_study']); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Certificates -->
                <?php if (!empty($parsedData['certificates'])): ?>
                <div class="mb-8">
                    <h3 class="mb-4 text-lg font-medium text-gray-900">Certificates</h3>
                    <div class="p-4 space-y-2 rounded-lg bg-gray-50">
                        <?php foreach ($parsedData['certificates'] as $cert): ?>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-sm text-gray-900"><?php echo htmlspecialchars($cert['certificate_title']); ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Action Buttons -->
                <div class="flex flex-col justify-center gap-4 sm:flex-row">
                    <button type="submit" name="accept_parsed_data" value="1"
                        class="inline-flex items-center px-6 py-3 text-sm font-medium text-white border border-transparent rounded-md shadow-sm bg-primary hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Accept & Continue
                    </button>
                    
                    <button type="submit" name="modify_data" value="1"
                        class="inline-flex items-center px-6 py-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Review & Modify
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>