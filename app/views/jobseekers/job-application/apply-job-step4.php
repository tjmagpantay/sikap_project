<?php
// filepath: app/views/jobseekers/job-application/apply-job-step4.php
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
                        <?php if (!empty($application_id)): ?>
                            <a href="?page=apply-job&job_id=<?php echo $job['job_id']; ?>&step=1&application_id=<?php echo $application_id; ?>"
                                class="flex items-center justify-center w-8 h-8 text-white transition-colors bg-green-600 rounded-full cursor-pointer hover:bg-green-700"
                                title="Click to go back to Personal Information step">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        <?php else: ?>
                            <div class="flex items-center justify-center w-8 h-8 text-white bg-green-600 rounded-full">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        <?php endif; ?>
                        <span class="mt-1 text-xs text-gray-600">Personal Info</span>
                    </div>

                    <!-- Step 2 -->
                    <div class="flex flex-col items-center">
                        <?php if (!empty($application_id)): ?>
                            <a href="?page=apply-job&job_id=<?php echo $job['job_id']; ?>&step=2&application_id=<?php echo $application_id; ?>"
                                class="flex items-center justify-center w-8 h-8 text-white transition-colors bg-green-600 rounded-full cursor-pointer hover:bg-green-700"
                                title="Click to go back to Screening Questions step">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        <?php else: ?>
                            <div class="flex items-center justify-center w-8 h-8 text-white bg-green-600 rounded-full">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        <?php endif; ?>
                        <span class="mt-1 text-xs text-gray-600">Screening</span>
                    </div>

                    <!-- Step 3 -->
                    <div class="flex flex-col items-center">
                        <?php if (!empty($application_id)): ?>
                            <a href="?page=apply-job&job_id=<?php echo $job['job_id']; ?>&step=3&application_id=<?php echo $application_id; ?>"
                                class="flex items-center justify-center w-8 h-8 text-white transition-colors bg-green-600 rounded-full cursor-pointer hover:bg-green-700"
                                title="Click to go back to Eligibility Information step">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        <?php else: ?>
                            <div class="flex items-center justify-center w-8 h-8 text-white bg-green-600 rounded-full">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        <?php endif; ?>
                        <span class="mt-1 text-xs text-gray-600">Eligibility</span>
                    </div>

                    <!-- Step 4 -->
                    <div class="flex flex-col items-center">
                        <div class="flex items-center justify-center w-8 h-8 text-white rounded-full bg-primary">
                            <span class="text-sm font-semibold">4</span>
                        </div>
                        <span class="mt-1 text-xs text-gray-600">Review</span>
                    </div>
                </div>

                <!-- Progress bar -->
                <div class="w-full h-2 bg-gray-200 rounded">
                    <div class="h-2 rounded bg-primary" style="width: 100%"></div>
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

            <!-- Review Application -->
            <div class="space-y-6">
                <!-- Personal Information Review -->
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <label class="font-medium text-md text-primary">Personal Information</label>
                        <a href="?page=apply-job&job_id=<?php echo $job['job_id']; ?>&step=1&application_id=<?php echo $application_id; ?>"
                            class="inline-flex items-center text-sm text-primary hover:text-blue-700">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit
                        </a>
                    </div>
                    <div class="p-4 border border-gray-200 rounded-lg bg-gray-50">
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            <div>
                                <span class="block mb-1 text-xs font-medium text-gray-500">Full Name:</span>
                                <p class="text-sm text-gray-700"><?php echo htmlspecialchars($jobseeker['first_name'] . ' ' . $jobseeker['last_name']); ?></p>
                            </div>
                            <div>
                                <span class="block mb-1 text-xs font-medium text-gray-500">Email:</span>
                                <p class="text-sm text-gray-700"><?php echo htmlspecialchars($jobseeker['email'] ?? 'Not provided'); ?></p>
                            </div>
                            <div>
                                <span class="block mb-1 text-xs font-medium text-gray-500">Phone:</span>
                                <p class="text-sm text-gray-700"><?php echo htmlspecialchars($jobseeker['contact_number'] ?? 'Not provided'); ?></p>
                            </div>
                            <div>
                                <span class="block mb-1 text-xs font-medium text-gray-500">Address:</span>
                                <p class="text-sm text-gray-700"><?php echo htmlspecialchars($jobseeker['address'] ?? 'Not provided'); ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Resume & Documents Review -->
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <label class="font-medium text-md text-primary">Resume & Documents</label>
                        <a href="?page=apply-job&job_id=<?php echo $job['job_id']; ?>&step=1&application_id=<?php echo $application_id; ?>"
                            class="inline-flex items-center text-sm text-primary hover:text-blue-700">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit
                        </a>
                    </div>
                    <div class="p-4 border border-gray-200 rounded-lg bg-gray-50">
                        <div class="space-y-4">
                            <!-- Resume/CV Documents -->
                            <?php
                            $resumeAttachments = array_filter($attachments, function ($attachment) {
                                return in_array($attachment['file_type'], ['Resume', 'CV', 'resume', 'cv']);
                            });
                            ?>

                            <?php if (!empty($resumeAttachments)): ?>
                                <div>
                                    <span class="block mb-2 text-xs font-medium text-gray-500">Resume/CV Documents:</span>
                                    <div class="space-y-2">
                                        <?php foreach ($resumeAttachments as $resume): ?>
                                            <div class="flex items-center p-2 bg-white border border-gray-100 rounded">
                                                <svg class="w-4 h-4 mr-2 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                                                </svg>
                                                <a href="<?php echo htmlspecialchars($resume['file_path']); ?>"
                                                    target="_blank"
                                                    class="text-sm font-medium text-primary hover:text-blue-700">
                                                    <?php echo htmlspecialchars($resume['file_type']); ?> Document
                                                </a>
                                                <span class="ml-auto text-xs text-gray-400">
                                                    <?php echo date('M j, Y', strtotime($resume['uploaded_at'])); ?>
                                                </span>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div>
                                    <span class="block mb-1 text-xs font-medium text-gray-500">Resume/CV:</span>
                                    <p class="text-sm text-gray-400">No resume/CV uploaded</p>
                                </div>
                            <?php endif; ?>

                            <!-- Additional Documents -->
                            <?php
                            $otherAttachments = array_filter($attachments, function ($attachment) {
                                return !in_array($attachment['file_type'], ['Resume', 'CV', 'resume', 'cv']);
                            });
                            ?>

                            <?php if (!empty($otherAttachments)): ?>
                                <div>
                                    <span class="block mb-2 text-xs font-medium text-gray-500">Additional Documents:</span>
                                    <div class="space-y-2">
                                        <?php foreach ($otherAttachments as $attachment): ?>
                                            <div class="flex items-center p-2 bg-white border border-gray-100 rounded">
                                                <svg class="w-4 h-4 mr-2 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z" clip-rule="evenodd" />
                                                </svg>
                                                <a href="<?php echo htmlspecialchars($attachment['file_path']); ?>"
                                                    target="_blank"
                                                    class="text-sm font-medium text-primary hover:text-blue-700">
                                                    <?php echo htmlspecialchars($attachment['file_type']); ?> Document
                                                </a>
                                                <span class="ml-auto text-xs text-gray-400">
                                                    <?php echo date('M j, Y', strtotime($attachment['uploaded_at'])); ?>
                                                </span>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div>
                                    <span class="block mb-1 text-xs font-medium text-gray-500">Additional Documents:</span>
                                    <p class="text-sm text-gray-400">No additional documents uploaded</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Screening Questions Review -->
                <?php if (!empty($answers)): ?>
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <label class="font-medium text-md text-primary">Screening Questions</label>
                            <a href="?page=apply-job&job_id=<?php echo $job['job_id']; ?>&step=2&application_id=<?php echo $application_id; ?>"
                                class="inline-flex items-center text-sm text-primary hover:text-blue-700">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Edit
                            </a>
                        </div>
                        <div class="p-4 border border-gray-200 rounded-lg bg-gray-50">
                            <div class="space-y-4">
                                <?php foreach ($answers as $index => $answer): ?>
                                    <div class="p-3 pl-4 bg-white border-l-4 rounded-r border-primary">
                                        <p class="mb-1 text-sm font-medium text-gray-900">
                                            <?php echo htmlspecialchars($answer['question_text']); ?>
                                        </p>
                                        <p class="text-sm text-gray-700">
                                            <?php echo nl2br(htmlspecialchars($answer['answer'])); ?>
                                        </p>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Eligibility Review -->
                <?php if (!empty($eligibility)): ?>
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <label class="font-medium text-md text-primary">Eligibility Information</label>
                            <a href="?page=apply-job&job_id=<?php echo $job['job_id']; ?>&step=3&application_id=<?php echo $application_id; ?>"
                                class="inline-flex items-center text-sm text-primary hover:text-blue-700">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Edit
                            </a>
                        </div>
                        <div class="p-4 border border-gray-200 rounded-lg bg-gray-50">
                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                <div>
                                    <span class="block mb-1 text-xs font-medium text-gray-500">Interested Program:</span>
                                    <p class="text-sm text-gray-700">
                                        <?php
                                        $program = $eligibility['interested_program'] ?? 'None';
                                        echo $program === 'None' ? 'Not interested in any program' : htmlspecialchars($program);
                                        ?>
                                    </p>
                                </div>
                                <div>
                                    <span class="block mb-1 text-xs font-medium text-gray-500">Priority Sector:</span>
                                    <p class="text-sm text-gray-700">
                                        <?php
                                        $sector = $eligibility['priority_sector'] ?? 'None';
                                        echo $sector === 'None' ? 'Not applicable' : htmlspecialchars($sector);
                                        ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Confirmation & Submit -->
                <div>
                    <label class="block mb-4 font-medium text-md text-primary">Confirmation</label>
                    <div class="p-4 border border-gray-200 rounded-lg bg-gray-50">
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <input type="checkbox" id="confirm_info" required
                                    class="w-4 h-4 mt-1 border-gray-300 rounded text-primary focus:ring-primary/50 focus:border-primary">
                                <label for="confirm_info" class="ml-3 text-sm text-gray-700">
                                    I confirm that all the information provided is accurate and complete to the best of my knowledge.
                                </label>
                            </div>

                            <div class="flex items-start">
                                <input type="checkbox" id="agree_terms" required
                                    class="w-4 h-4 mt-1 border-gray-300 rounded text-primary focus:ring-primary/50 focus:border-primary">
                                <label for="agree_terms" class="ml-3 text-sm text-gray-700">
                                    I agree to allow this employer to contact me regarding this application and future job opportunities.
                                </label>
                            </div>

                            <div class="flex items-start">
                                <input type="checkbox" id="understand_process" required
                                    class="w-4 h-4 mt-1 border-gray-300 rounded text-primary focus:ring-primary/50 focus:border-primary">
                                <label for="understand_process" class="ml-3 text-sm text-gray-700">
                                    I understand that submitting this application does not guarantee employment and that the employer will review applications according to their selection criteria.
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Warning Box -->
            <div class="p-4 mt-6 mb-6 border border-yellow-200 rounded-lg bg-yellow-50">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 text-secondary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3 ">
                        <h4 class="text-sm font-semibold text-yellow-800">Before you submit</h4>
                        <p class="mt-1 text-sm leading-relaxed text-yellow-700">
                            Once you submit your application, you cannot edit it. Please review all information carefully.
                            You will receive a confirmation email and can track your application status in your dashboard.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Navigation Buttons -->
            <div class="flex justify-between pt-6">
                <a href="?page=apply-job&job_id=<?php echo $job['job_id']; ?>&step=3&application_id=<?php echo $application_id; ?>"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Step 3
                </a>

                <form method="POST" id="submitForm" style="display: inline;">
                    <button type="submit" id="submitBtn" disabled
                        class="inline-flex items-center gap-2 px-6 py-2 text-sm font-medium text-white border border-transparent rounded-md shadow-sm bg-primary hover:bg-blue-700 disabled:bg-gray-400 disabled:cursor-not-allowed disabled:opacity-50">
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                        </svg>
                        Submit Application
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Enable submit button only when all checkboxes are checked
    function checkSubmitConditions() {
        const confirmInfo = document.getElementById('confirm_info').checked;
        const agreeTerms = document.getElementById('agree_terms').checked;
        const understandProcess = document.getElementById('understand_process').checked;
        const submitBtn = document.getElementById('submitBtn');

        if (confirmInfo && agreeTerms && understandProcess) {
            submitBtn.disabled = false;
            submitBtn.classList.remove('disabled:bg-gray-400', 'disabled:cursor-not-allowed');
            submitBtn.classList.add('bg-green-600', 'hover:bg-green-700');
        } else {
            submitBtn.disabled = true;
            submitBtn.classList.add('disabled:bg-gray-400', 'disabled:cursor-not-allowed');
            submitBtn.classList.remove('bg-green-600', 'hover:bg-green-700');
        }
    }

    // Add event listeners to checkboxes
    document.getElementById('confirm_info').addEventListener('change', checkSubmitConditions);
    document.getElementById('agree_terms').addEventListener('change', checkSubmitConditions);
    document.getElementById('understand_process').addEventListener('change', checkSubmitConditions);

    // Confirmation dialog before submission
    document.getElementById('submitForm').addEventListener('submit', function(e) {
        if (!confirm('Are you sure you want to submit your application? You cannot edit it after submission.')) {
            e.preventDefault();
        }
    });
</script>