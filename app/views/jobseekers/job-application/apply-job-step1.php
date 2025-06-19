<?php
// filepath: app/views/jobseekers/job-application/apply-job-step1.php
include_once __DIR__ . '/../../components/navbar-top.php';
include_once __DIR__ . '/../navbar-jobseeker.php';
?>

<div class="max-w-4xl py-6 mx-auto sm:px-6 lg:px-8">
    <!-- Progress Bar -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl font-bold text-gray-900">Apply for Job</h1>
            <span class="text-sm text-gray-600">Step 1 of 4</span>
        </div>
        
        <!-- Progress indicators -->
        <div class="flex items-center">
            <div class="flex items-center text-blue-600">
                <div class="flex items-center justify-center w-8 h-8 bg-blue-600 rounded-full">
                    <span class="text-sm font-medium text-white">1</span>
                </div>
                <span class="ml-2 text-sm font-medium">Personal Info & Documents</span>
            </div>
            <div class="flex-1 h-1 mx-4 bg-gray-200 rounded"></div>
            
            <div class="flex items-center text-gray-400">
                <div class="flex items-center justify-center w-8 h-8 bg-gray-200 rounded-full">
                    <span class="text-sm font-medium">2</span>
                </div>
                <span class="ml-2 text-sm font-medium">Screening Questions</span>
            </div>
            <div class="flex-1 h-1 mx-4 bg-gray-200 rounded"></div>
            
            <div class="flex items-center text-gray-400">
                <div class="flex items-center justify-center w-8 h-8 bg-gray-200 rounded-full">
                    <span class="text-sm font-medium">3</span>
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
    <div class="p-4 mb-6 border border-blue-200 rounded-lg bg-blue-50">
        <h2 class="text-lg font-semibold text-blue-900"><?php echo htmlspecialchars($job['job_title']); ?></h2>
        <p class="text-blue-700">
            <?php 
            $companyName = $job['company_name'] ?? 
                          ($job['employer_first_name'] . ' ' . $job['employer_last_name']);
            echo htmlspecialchars($companyName); 
            ?>
        </p>
        <div class="flex flex-wrap gap-4 mt-2 text-sm text-blue-600">
            <span><i class="mr-1 fas fa-map-marker-alt"></i><?php echo htmlspecialchars($job['location']); ?></span>
            <span><i class="mr-1 fas fa-briefcase"></i><?php echo ucfirst(str_replace('-', ' ', $job['job_type'])); ?></span>
        </div>
    </div>

    <!-- Messages -->
    <?php if (!empty($error)): ?>
        <div class="p-4 mb-6 border border-red-200 rounded-lg bg-red-50">
            <p class="text-red-800"><?php echo htmlspecialchars($error); ?></p>
        </div>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <div class="p-4 mb-6 border border-green-200 rounded-lg bg-green-50">
            <p class="text-green-800"><?php echo htmlspecialchars($success); ?></p>
        </div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data" class="space-y-6">
        <!-- Personal Information Card -->
        <div class="p-6 bg-white rounded-lg shadow">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Personal Information</h3>
                <a href="?page=complete-jobseeker-profile" 
                   class="text-sm text-blue-600 hover:text-blue-800">
                    <i class="mr-1 fas fa-edit"></i>Update Profile
                </a>
            </div>
            
            <div class="p-4 rounded-lg bg-gray-50">
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
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
        </div>

        <!-- Resume Upload -->
        <div class="p-6 bg-white rounded-lg shadow">
            <h3 class="mb-4 text-lg font-medium text-gray-900">Resume/CV <span class="text-red-500">*</span></h3>
            
            <!-- Existing Documents -->
            <?php if (!empty($documents)): ?>
                <div class="mb-4">
                    <h4 class="mb-2 text-sm font-medium text-gray-700">Select from your uploaded documents:</h4>
                    <div class="space-y-2">
                        <?php foreach ($documents as $doc): ?>
                            <?php if (in_array(strtolower($doc['file_type']), ['resume', 'cv'])): ?>
                                <label class="flex items-center p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50">
                                    <input type="checkbox" 
                                           name="selected_resumes[]" 
                                           value="<?php echo htmlspecialchars($doc['file_path']); ?>" 
                                           class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                           <?php echo (!empty($applicationData['selected_resumes']) && in_array($doc['file_path'], $applicationData['selected_resumes'])) ? 'checked' : ''; ?>>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($doc['file_name']); ?></p>
                                        <p class="text-xs text-gray-500">
                                            Type: <?php echo ucfirst($doc['file_type']); ?> • 
                                            Uploaded: <?php echo date('M j, Y', strtotime($doc['uploaded_at'])); ?>
                                        </p>
                                    </div>
                                </label>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php else: ?>
                <div class="p-4 mb-4 border border-yellow-200 rounded-lg bg-yellow-50">
                    <div class="flex">
                        <i class="mt-1 text-yellow-500 fas fa-info-circle"></i>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-800">
                                You don't have any resume/CV uploaded to your profile yet. 
                                <a href="?page=complete-jobseeker-profile" class="font-medium underline hover:no-underline">
                                    Upload one to your profile
                                </a> to reuse it for future applications.
                            </p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Upload New Resume -->
            <div class="p-4 border border-gray-300 border-dashed rounded-lg">
                <div class="text-center">
                    <i class="mb-2 text-4xl text-gray-400 fas fa-cloud-upload-alt"></i>
                    <label for="new_resume" class="cursor-pointer">
                        <span class="text-sm font-medium text-blue-600 hover:text-blue-500">Upload a new resume/CV</span>
                        <input id="new_resume" name="new_resume" type="file" class="sr-only" 
                               accept=".pdf,.doc,.docx" onchange="displayFileName(this, 'resume-filename')">
                    </label>
                    <p class="mt-1 text-xs text-gray-500">PDF, DOC, DOCX up to 5MB</p>
                    <p id="resume-filename" class="hidden mt-2 text-sm text-gray-700"></p>
                    
                    <!-- Save to Profile Option -->
                    <div class="mt-3" id="save-to-profile-option" style="display: none;">
                        <label class="flex items-center justify-center">
                            <input type="checkbox" name="save_to_profile" value="1" 
                                   class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">Save this resume to my profile for future applications</span>
                        </label>
                    </div>
                </div>
            </div>
            
            <!-- Resume Required Note -->
            <p class="mt-2 text-xs text-gray-500">
                <i class="mr-1 text-red-500 fas fa-exclamation-circle"></i>
                Please select at least one existing document or upload a new one to continue.
            </p>
        </div>

        <!-- Additional Documents -->
        <div class="p-6 bg-white rounded-lg shadow">
            <h3 class="mb-4 text-lg font-medium text-gray-900">Additional Documents</h3>
            <p class="mb-4 text-sm text-gray-600">Upload any additional documents that support your application (certificates, portfolios, etc.)</p>
            
            <div id="attachments-container">
                <div class="p-4 mb-4 border border-gray-300 border-dashed rounded-lg attachment-item">
                    <div class="flex items-center space-x-4">
                        <div class="flex-1">
                            <input type="file" name="attachments[]" 
                                   class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                   accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                        </div>
                        <div class="w-32">
                            <select name="attachment_types[]" class="w-full px-2 py-1 text-sm border border-gray-300 rounded-md">
                                <option value="Certificate">Certificate</option>
                                <option value="Portfolio">Portfolio</option>
                                <option value="Transcript">Transcript</option>
                                <option value="Others">Others</option>
                            </select>
                        </div>
                        <button type="button" onclick="removeAttachment(this)" 
                                class="text-red-600 hover:text-red-800">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            <button type="button" onclick="addAttachment()" 
                    class="text-sm text-blue-600 hover:text-blue-800">
                <i class="mr-1 fas fa-plus"></i>Add Another Document
            </button>
        </div>

        <!-- Navigation Buttons -->
        <div class="flex justify-between pt-6">
            <a href="?page=view-job&job_id=<?php echo $job['job_id']; ?>" 
               class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-md hover:bg-gray-200">
                Cancel
            </a>
            
            <button type="submit" 
                    class="px-6 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                Continue to Step 2 <i class="ml-1 fas fa-arrow-right"></i>
            </button>
        </div>
    </form>
</div>

<script>
function displayFileName(input, displayId) {
    const display = document.getElementById(displayId);
    const saveOption = document.getElementById('save-to-profile-option');
    
    if (input.files && input.files[0]) {
        display.textContent = 'Selected: ' + input.files[0].name;
        display.classList.remove('hidden');
        saveOption.style.display = 'block';
    } else {
        display.classList.add('hidden');
        saveOption.style.display = 'none';
    }
}

function addAttachment() {
    const container = document.getElementById('attachments-container');
    const newItem = document.createElement('div');
    newItem.className = 'attachment-item border border-gray-300 border-dashed rounded-lg p-4 mb-4';
    newItem.innerHTML = `
        <div class="flex items-center space-x-4">
            <div class="flex-1">
                <input type="file" name="attachments[]" 
                       class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                       accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
            </div>
            <div class="w-32">
                <select name="attachment_types[]" class="w-full px-2 py-1 text-sm border border-gray-300 rounded-md">
                    <option value="Certificate">Certificate</option>
                    <option value="Portfolio">Portfolio</option>
                    <option value="Transcript">Transcript</option>
                    <option value="Others">Others</option>
                </select>
            </div>
            <button type="button" onclick="removeAttachment(this)" 
                    class="text-red-600 hover:text-red-800">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    container.appendChild(newItem);
}

function removeAttachment(button) {
    const attachmentItems = document.querySelectorAll('.attachment-item');
    if (attachmentItems.length > 1) {
        button.closest('.attachment-item').remove();
    }
}

// Add form validation before submission
document.querySelector('form').addEventListener('submit', function(e) {
    const selectedResumes = document.querySelectorAll('input[name="selected_resumes[]"]:checked');
    const newResume = document.getElementById('new_resume').files.length;
    
    if (selectedResumes.length === 0 && newResume === 0) {
        e.preventDefault();
        alert('Please select at least one existing document or upload a new resume/CV to continue.');
        return false;
    }
});
</script>