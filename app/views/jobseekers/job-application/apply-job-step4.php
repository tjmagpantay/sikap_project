<?php
// filepath: app/views/jobseekers/job-application/apply-job-step4.php
include_once __DIR__ . '/../../components/navbar-top.php';
include_once __DIR__ . '/../navbar-jobseeker.php';
?>

<div class="py-6 mx-auto max-w-4xl sm:px-6 lg:px-8">
    <!-- Progress Bar -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl font-bold text-gray-900">Apply for Job</h1>
            <span class="text-sm text-gray-600">Step 4 of 4</span>
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
            
            <div class="flex items-center text-green-600">
                <div class="flex items-center justify-center w-8 h-8 bg-green-600 rounded-full">
                    <i class="fas fa-check text-white text-sm"></i>
                </div>
                <span class="ml-2 text-sm font-medium">Eligibility</span>
            </div>
            <div class="flex-1 h-1 mx-4 bg-green-600 rounded"></div>
            
            <div class="flex items-center text-blue-600">
                <div class="flex items-center justify-center w-8 h-8 bg-blue-600 rounded-full">
                    <span class="text-sm font-medium text-white">4</span>
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
        <div class="mt-2 flex flex-wrap gap-4 text-sm text-blue-600">
            <span><i class="fas fa-map-marker-alt mr-1"></i><?php echo htmlspecialchars($job['location']); ?></span>
            <span><i class="fas fa-briefcase mr-1"></i><?php echo ucfirst(str_replace('-', ' ', $job['job_type'])); ?></span>
        </div>
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

    <!-- Review Application -->
    <div class="space-y-6">
        <!-- Personal Information Review -->
        <div class="bg-white shadow rounded-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Personal Information</h3>
                <a href="?page=apply-job&job_id=<?php echo $job['job_id']; ?>&step=1&application_id=<?php echo $application_id; ?>" 
                   class="text-sm text-blue-600 hover:text-blue-800">
                    <i class="fas fa-edit mr-1"></i>Edit
                </a>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <span class="text-sm font-medium text-gray-600">Full Name:</span>
                    <p class="text-gray-900"><?php echo htmlspecialchars($jobseeker['first_name'] . ' ' . $jobseeker['last_name']); ?></p>
                </div>
                <div>
                    <span class="text-sm font-medium text-gray-600">Email:</span>
                    <p class="text-gray-900"><?php echo htmlspecialchars($jobseeker['email'] ?? 'Not provided'); ?></p>
                </div>
                <div>
                    <span class="text-sm font-medium text-gray-600">Phone:</span>
                    <p class="text-gray-900"><?php echo htmlspecialchars($jobseeker['contact_number'] ?? 'Not provided'); ?></p>
                </div>
                <div>
                    <span class="text-sm font-medium text-gray-600">Address:</span>
                    <p class="text-gray-900"><?php echo htmlspecialchars($jobseeker['address'] ?? 'Not provided'); ?></p>
                </div>
            </div>
        </div>

        <!-- Resume & Documents Review -->
        <div class="bg-white shadow rounded-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Resume & Documents</h3>
                <a href="?page=apply-job&job_id=<?php echo $job['job_id']; ?>&step=1&application_id=<?php echo $application_id; ?>" 
                   class="text-sm text-blue-600 hover:text-blue-800">
                    <i class="fas fa-edit mr-1"></i>Edit
                </a>
            </div>
            
            <div class="space-y-4">
                <!-- Resume/CV Documents -->
                <?php 
                $resumeAttachments = array_filter($attachments, function($attachment) {
                    return in_array($attachment['file_type'], ['Resume', 'CV', 'resume', 'cv']);
                });
                ?>
                
                <?php if (!empty($resumeAttachments)): ?>
                    <div>
                        <span class="text-sm font-medium text-gray-600">Resume/CV Documents:</span>
                        <div class="mt-2 space-y-2">
                            <?php foreach ($resumeAttachments as $resume): ?>
                                <div class="flex items-center">
                                    <i class="fas fa-file-alt text-blue-500 mr-2"></i>
                                    <a href="<?php echo htmlspecialchars($resume['file_path']); ?>" 
                                       target="_blank" 
                                       class="text-blue-600 hover:text-blue-800 text-sm">
                                        <?php echo htmlspecialchars($resume['file_type']); ?> Document
                                    </a>
                                    <span class="ml-2 text-xs text-gray-500">
                                        (Uploaded: <?php echo date('M j, Y', strtotime($resume['uploaded_at'])); ?>)
                                    </span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php else: ?>
                    <div>
                        <span class="text-sm font-medium text-gray-600">Resume/CV:</span>
                        <p class="text-gray-500 mt-1">No resume/CV uploaded</p>
                    </div>
                <?php endif; ?>

                <!-- Additional Documents -->
                <?php 
                $otherAttachments = array_filter($attachments, function($attachment) {
                    return !in_array($attachment['file_type'], ['Resume', 'CV', 'resume', 'cv']);
                });
                ?>
                
                <?php if (!empty($otherAttachments)): ?>
                    <div>
                        <span class="text-sm font-medium text-gray-600">Additional Documents:</span>
                        <div class="mt-2 space-y-2">
                            <?php foreach ($otherAttachments as $attachment): ?>
                                <div class="flex items-center">
                                    <i class="fas fa-paperclip text-gray-500 mr-2"></i>
                                    <a href="<?php echo htmlspecialchars($attachment['file_path']); ?>" 
                                       target="_blank" 
                                       class="text-blue-600 hover:text-blue-800 text-sm">
                                        <?php echo htmlspecialchars($attachment['file_type']); ?> Document
                                    </a>
                                    <span class="ml-2 text-xs text-gray-500">
                                        (Uploaded: <?php echo date('M j, Y', strtotime($attachment['uploaded_at'])); ?>)
                                    </span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php else: ?>
                    <div>
                        <span class="text-sm font-medium text-gray-600">Additional Documents:</span>
                        <p class="text-gray-500 mt-1">No additional documents uploaded</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Screening Questions Review -->
        <?php if (!empty($answers)): ?>
        <div class="bg-white shadow rounded-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Screening Questions</h3>
                <a href="?page=apply-job&job_id=<?php echo $job['job_id']; ?>&step=2&application_id=<?php echo $application_id; ?>" 
                   class="text-sm text-blue-600 hover:text-blue-800">
                    <i class="fas fa-edit mr-1"></i>Edit
                </a>
            </div>
            
            <div class="space-y-4">
                <?php foreach ($answers as $index => $answer): ?>
                    <div class="border-l-4 border-blue-500 pl-4">
                        <p class="text-sm font-medium text-gray-900 mb-1">
                            <?php echo htmlspecialchars($answer['question_text']); ?>
                        </p>
                        <p class="text-sm text-gray-700">
                            <?php echo nl2br(htmlspecialchars($answer['answer'])); ?>
                        </p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Eligibility Review -->
        <?php if (!empty($eligibility)): ?>
        <div class="bg-white shadow rounded-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Eligibility Information</h3>
                <a href="?page=apply-job&job_id=<?php echo $job['job_id']; ?>&step=3&application_id=<?php echo $application_id; ?>" 
                   class="text-sm text-blue-600 hover:text-blue-800">
                    <i class="fas fa-edit mr-1"></i>Edit
                </a>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <span class="text-sm font-medium text-gray-600">Interested Program:</span>
                    <p class="text-gray-900">
                        <?php 
                        $program = $eligibility['interested_program'] ?? 'None';
                        echo $program === 'None' ? 'Not interested in any program' : htmlspecialchars($program);
                        ?>
                    </p>
                </div>
                <div>
                    <span class="text-sm font-medium text-gray-600">Priority Sector:</span>
                    <p class="text-gray-900">
                        <?php 
                        $sector = $eligibility['priority_sector'] ?? 'None';
                        echo $sector === 'None' ? 'Not applicable' : htmlspecialchars($sector);
                        ?>
                    </p>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Confirmation & Submit -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Confirmation</h3>
            
            <div class="space-y-4">
                <div class="flex items-start">
                    <input type="checkbox" id="confirm_info" required 
                           class="mt-1 h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="confirm_info" class="ml-3 text-sm text-gray-700">
                        I confirm that all the information provided is accurate and complete to the best of my knowledge.
                    </label>
                </div>
                
                <div class="flex items-start">
                    <input type="checkbox" id="agree_terms" required 
                           class="mt-1 h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="agree_terms" class="ml-3 text-sm text-gray-700">
                        I agree to allow this employer to contact me regarding this application and future job opportunities.
                    </label>
                </div>
                
                <div class="flex items-start">
                    <input type="checkbox" id="understand_process" required 
                           class="mt-1 h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="understand_process" class="ml-3 text-sm text-gray-700">
                        I understand that submitting this application does not guarantee employment and that the employer will review applications according to their selection criteria.
                    </label>
                </div>
            </div>

            <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                <div class="flex">
                    <i class="fas fa-exclamation-triangle text-yellow-600 mt-1"></i>
                    <div class="ml-3">
                        <h4 class="text-sm font-medium text-yellow-800">Before you submit</h4>
                        <p class="text-sm text-yellow-700 mt-1">
                            Once you submit your application, you cannot edit it. Please review all information carefully. 
                            You will receive a confirmation email and can track your application status in your dashboard.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation Buttons -->
        <form method="POST" id="submitForm">
            <div class="flex justify-between pt-6">
                <a href="?page=apply-job&job_id=<?php echo $job['job_id']; ?>&step=3&application_id=<?php echo $application_id; ?>" 
                   class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-md hover:bg-gray-200">
                    <i class="fas fa-arrow-left mr-1"></i> Back to Step 3
                </a>
                
                <button type="submit" id="submitBtn" disabled
                        class="px-8 py-3 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md hover:bg-green-700 disabled:bg-gray-400 disabled:cursor-not-allowed">
                    <i class="fas fa-paper-plane mr-2"></i>Submit Application
                </button>
            </div>
        </form>
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