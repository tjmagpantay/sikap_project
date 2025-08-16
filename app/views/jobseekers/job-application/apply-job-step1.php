<?php
// filepath: app/views/jobseekers/job-application/apply-job-step1.php
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
                        <div class="flex items-center justify-center w-8 h-8 text-white rounded-full bg-primary">
                            <span class="text-sm font-semibold">1</span>
                        </div>
                        <span class="mt-1 text-xs text-gray-600">Personal Info</span>
                    </div>

                    <!-- Step 2 -->
                    <div class="flex flex-col items-center">
                        <?php if (!empty($application_id)): ?>
                            <a href="?page=apply-job&job_id=<?php echo $job['job_id']; ?>&step=2&application_id=<?php echo $application_id; ?>"
                                class="flex items-center justify-center w-8 h-8 text-gray-500 transition-colors bg-gray-200 rounded-full hover:bg-gray-300 hover:text-gray-700">
                                <span class="text-sm font-semibold">2</span>
                            </a>
                        <?php else: ?>
                            <div class="flex items-center justify-center w-8 h-8 text-gray-500 bg-gray-200 rounded-full">
                                <span class="text-sm font-semibold">2</span>
                            </div>
                        <?php endif; ?>
                        <span class="mt-1 text-xs text-gray-500">Screening</span>
                    </div>

                    <!-- Step 3 -->
                    <div class="flex flex-col items-center">
                        <?php if (!empty($application_id)): ?>
                            <a href="?page=apply-job&job_id=<?php echo $job['job_id']; ?>&step=3&application_id=<?php echo $application_id; ?>"
                                class="flex items-center justify-center w-8 h-8 text-gray-500 transition-colors bg-gray-200 rounded-full hover:bg-gray-300 hover:text-gray-700">
                                <span class="text-sm font-semibold">3</span>
                            </a>
                        <?php else: ?>
                            <div class="flex items-center justify-center w-8 h-8 text-gray-500 bg-gray-200 rounded-full">
                                <span class="text-sm font-semibold">3</span>
                            </div>
                        <?php endif; ?>
                        <span class="mt-1 text-xs text-gray-500">Eligibility</span>
                    </div>

                    <!-- Step 4 -->
                    <div class="flex flex-col items-center">
                        <?php if (!empty($application_id)): ?>
                            <a href="?page=apply-job&job_id=<?php echo $job['job_id']; ?>&step=4&application_id=<?php echo $application_id; ?>"
                                class="flex items-center justify-center w-8 h-8 text-gray-500 transition-colors bg-gray-200 rounded-full hover:bg-gray-300 hover:text-gray-700">
                                <span class="text-sm font-semibold">4</span>
                            </a>
                        <?php else: ?>
                            <div class="flex items-center justify-center w-8 h-8 text-gray-500 bg-gray-200 rounded-full">
                                <span class="text-sm font-semibold">4</span>
                            </div>
                        <?php endif; ?>
                        <span class="mt-1 text-xs text-gray-500">Review</span>
                    </div>
                </div>

                <!-- Progress bar -->
                <div class="w-full h-2 bg-gray-200 rounded">
                    <div class="h-2 rounded bg-primary" style="width: 25%"></div>
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

            <form class="space-y-6" method="POST" enctype="multipart/form-data">
                <!-- Personal Information Card -->
                <div>
                    <label class="block mb-1 font-medium text-md text-primary">
                        Personal Information
                    </label>
                    <div class="relative p-4 rounded-md bg-gray-50">
                        <!-- Edit Icon in Top Right Corner -->
                        <a href="?page=complete-jobseeker-profile"
                            class="absolute top-3 right-3 p-1.5 text-gray-400 hover:text-primary transition-colors rounded-full hover:bg-gray-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </a>

                        <!-- Personal Information Grid -->
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

                <!-- Resume Upload -->
                <div>
                    <label class="block font-medium text-md text-primary">
                        Resume <span class="text-red-500">*</span>
                    </label>
                    <!-- Resume Required Note -->
                    <p class="mb-2 text-xs text-gray-500 ">
                        <span class="text-red-500">*</span> Please select at least one existing resume or upload a new one to continue.
                    </p>
                    <!-- Existing Resume Documents -->
                    <?php
                    $resumeDocuments = [];
                    if (!empty($documents)) {
                        foreach ($documents as $doc) {
                            if (strtolower($doc['file_type']) === 'resume') {
                                $resumeDocuments[] = $doc;
                            }
                        }
                    }
                    ?>

                    <?php if (!empty($resumeDocuments)): ?>
                        <div class="mb-6">
                            <div class="space-y-2">
                                <?php foreach ($resumeDocuments as $doc): ?>
                                    <?php
                                    // Check if this resume was previously selected
                                    $isSelected = false;
                                    if (!empty($existingAttachments)) {
                                        foreach ($existingAttachments as $attachment) {
                                            if (
                                                $attachment['file_type'] === 'resume' &&
                                                ($attachment['file_path'] === $doc['file_path'] ||
                                                    (!empty($attachment['profile_document_id']) &&
                                                        $attachment['profile_document_id'] == $doc['document_id']))
                                            ) {
                                                $isSelected = true;
                                                break;
                                            }
                                        }
                                    }
                                    ?>
                                    <label class="flex items-center p-3 transition-colors border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50">
                                        <input type="checkbox"
                                            name="selected_resumes[]"
                                            value="<?php echo htmlspecialchars($doc['file_path']); ?>"
                                            class="w-4 h-4 border-gray-300 rounded text-primary focus:ring-primary/50 focus:border-primary"
                                            <?php echo $isSelected ? 'checked' : ''; ?>>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($doc['file_name']); ?></p>
                                            <p class="text-xs text-gray-500">
                                                Type: Resume • Uploaded: <?php echo date('M j, Y', strtotime($doc['uploaded_at'])); ?>
                                            </p>
                                        </div>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="p-4 mb-3 border border-yellow-200 rounded-lg bg-yellow-50">
                            <div class="flex">
                                <svg class="w-5 h-5 text-yellow-400 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                <div class="ml-3">
                                    <p class="text-xs text-yellow-800">
                                        You don't have any resume uploaded to your profile yet.
                                        <a href="?page=complete-jobseeker-profile" class="font-medium underline text-primary hover:text-blue-500">
                                            Upload one to your profile
                                        </a> to reuse it for future applications.
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Upload New Resume -->
                    <div>
                        <!-- File Upload Area -->
                        <div class="relative p-6 transition-all border-2 border-gray-300 border-dashed rounded-lg hover:border-primary/50 group">
                            <div class="text-center">
                                <!-- Upload Icon -->
                                <svg class="w-8 h-8 mx-auto text-gray-400 group-hover:text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>

                                <!-- Upload Text -->
                                <div>
                                    <label for="new_resume" class="cursor-pointer">
                                        <p class="text-sm font-medium text-gray-600 group-hover:text-primary">
                                            <span class="underline text-primary">Click to upload</span> or drag and drop
                                        </p>
                                        <p class="mt-1 text-xs text-gray-500">PDF (max. 5MB)</p>
                                        <!-- Selected File Name -->
                                        <p id="resume-filename" class="hidden mt-2 text-sm font-medium text-green-600"></p>
                                    </label>
                                </div>

                                <!-- Hidden File Input -->
                                <input id="new_resume" name="new_resume" type="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                    accept=".pdf,.doc,.docx" onchange="displayFileName(this, 'resume-filename')">
                            </div>
                        </div>
                    </div>

                    <!-- Save Resume to Profile Option -->
                    <div class="mt-3" id="save-resume-to-profile-option" style="display: none;">
                        <label class="flex items-center">
                            <input type="checkbox" name="save_resume_to_profile" value="1"
                                class="w-4 h-4 border-gray-300 rounded text-primary focus:ring-primary/50 focus:border-primary">
                            <span class="ml-2 text-sm text-gray-700">Save this resume to my profile for future applications</span>
                        </label>
                    </div>
                </div>

                <!-- CV Upload -->
                <div>
                    <label class="block mb-1 font-medium text-md text-primary">
                        CV (Curriculum Vitae)
                    </label>

                    <!-- Existing CV Documents -->
                    <?php
                    $cvDocuments = [];
                    if (!empty($documents)) {
                        foreach ($documents as $doc) {
                            if (strtolower($doc['file_type']) === 'cv') {
                                $cvDocuments[] = $doc;
                            }
                        }
                    }
                    ?>

                    <div class="mt-4">
                        <!-- File Upload Area -->
                        <div class="relative p-6 mb-6 transition-all border-2 border-gray-300 border-dashed rounded-lg hover:border-primary/50 group">
                            <div class="text-center">
                                <!-- Upload Icon -->
                                <svg class="w-8 h-8 mx-auto text-gray-400 group-hover:text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>

                                <!-- Upload Text -->
                                <div class="mt-3">
                                    <label for="new_cv" class="cursor-pointer">
                                        <p class="text-sm font-medium text-gray-600 group-hover:text-primary">
                                            <span class="underline text-primary">Click to upload</span> or drag and drop
                                        </p>
                                        <p class="mt-1 text-xs text-gray-500">PDF (max. 5MB)</p>
                                        <!-- Selected File Name -->
                                        <p id="cv-filename" class="hidden mt-2 text-sm font-medium text-green-600"></p>
                                    </label>
                                </div>

                                <!-- Hidden File Input -->
                                <input id="new_cv" name="new_cv" type="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                    accept=".pdf,.doc,.docx" onchange="displayFileName(this, 'cv-filename')">
                            </div>
                        </div>

                        <!-- Existing CV Documents -->
                        <?php if (!empty($cvDocuments)): ?>
                            <div class="mb-6">
                                <h3 class="mb-3 text-sm font-medium text-gray-700">Your existing CVs</h3>
                                <div class="space-y-3">
                                    <?php foreach ($cvDocuments as $doc): ?>
                                        <?php
                                        // Check if this CV was previously selected
                                        $isSelected = false;
                                        if (!empty($existingAttachments)) {
                                            foreach ($existingAttachments as $attachment) {
                                                if (
                                                    $attachment['file_type'] === 'cv' &&
                                                    ($attachment['file_path'] === $doc['file_path'] ||
                                                        (!empty($attachment['profile_document_id']) &&
                                                            $attachment['profile_document_id'] == $doc['document_id']))
                                                ) {
                                                    $isSelected = true;
                                                    break;
                                                }
                                            }
                                        }
                                        ?>
                                        <label class="flex items-start p-4 transition-colors border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50">
                                            <input type="checkbox"
                                                name="selected_cvs[]"
                                                value="<?php echo htmlspecialchars($doc['file_path']); ?>"
                                                class="w-4 h-4 mt-1 border-gray-300 rounded text-primary focus:ring-primary/50 focus:border-primary"
                                                <?php echo $isSelected ? 'checked' : ''; ?>>
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($doc['file_name']); ?></p>
                                                <p class="mt-1 text-xs text-gray-500">
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">CV</span>
                                                    • Uploaded <?php echo date('M j, Y', strtotime($doc['uploaded_at'])); ?>
                                                </p>
                                            </div>
                                        </label>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Save CV to Profile Option -->
                    <div class="mt-3" id="save-cv-to-profile-option" style="display: none;">
                        <label class="flex items-center">
                            <input type="checkbox" name="save_cv_to_profile" value="1"
                                class="w-4 h-4 border-gray-300 rounded text-primary focus:ring-primary/50 focus:border-primary">
                            <span class="ml-2 text-sm text-gray-700">Save this CV to my profile for future applications</span>
                        </label>
                    </div>
                </div>

                <!-- Additional Documents -->
                <div>
                    <label class="block mb-1 font-medium text-md text-primary">
                        Additional Documents
                    </label>
                    <p class="mt-1 mb-4 text-xs text-gray-500">
                        Upload any additional documents that support your application (certificates, portfolios, etc.)
                    </p>

                    <!-- Show existing additional attachments -->
                    <?php
                    $existingAdditionalAttachments = [];
                    if (!empty($existingAttachments)) {
                        foreach ($existingAttachments as $attachment) {
                            if (!in_array($attachment['file_type'], ['resume', 'cv'])) {
                                $existingAdditionalAttachments[] = $attachment;
                            }
                        }
                    }
                    ?>

                    <?php if (!empty($existingAdditionalAttachments)): ?>
                        <div class="mb-4">
                            <h4 class="mb-3 text-sm font-medium text-gray-700">Previously uploaded documents:</h4>
                            <div class="space-y-2">
                                <?php foreach ($existingAdditionalAttachments as $attachment): ?>
                                    <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg bg-gray-50">
                                        <div class="flex items-center space-x-3">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            <div>
                                                <p class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars(basename($attachment['file_path'])); ?></p>
                                                <p class="text-xs text-gray-500">
                                                    Type: <?php echo htmlspecialchars($attachment['file_type']); ?>
                                                    • Uploaded: <?php echo date('M j, Y', strtotime($attachment['uploaded_at'])); ?>
                                                </p>
                                            </div>
                                        </div>
                                        <input type="hidden" name="existing_attachments[]" value="<?php echo htmlspecialchars($attachment['attachment_id']); ?>">
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div id="attachments-container">
                        <div class="p-4 mb-4 border border-gray-300 border-dashed rounded-lg attachment-item">
                            <div class="flex items-center space-x-4">
                                <div class="flex-1">
                                    <input type="file" name="attachments[]"
                                        class="block w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-400 transition-all bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary hover:border-gray-400"
                                        accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                </div>
                                <div class="w-32">
                                    <select name="attachment_types[]" class="block w-full px-3 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary hover:border-gray-400">
                                        <option value="Certificate">Certificate</option>
                                        <option value="Portfolio">Portfolio</option>
                                        <option value="Transcript">Transcript</option>
                                        <option value="Others">Others</option>
                                    </select>
                                </div>
                                <button type="button" onclick="removeAttachment(this)"
                                    class="text-red-600 transition-colors hover:text-red-800">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <button type="button" onclick="addAttachment()"
                        class="flex items-center text-sm transition-colors text-primary hover:text-blue-500">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Add Another Document
                    </button>
                </div>

                <div class="flex justify-between">
                    <a href="?page=view-job&job_id=<?php echo $job['job_id']; ?>"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back to Job Details
                    </a>

                    <button type="submit"
                        class="inline-flex items-center px-6 py-2 text-sm font-medium text-white border border-transparent rounded-md shadow-sm bg-primary hover:bg-blue-700">
                        <?php echo ($application_id && !empty($existingAttachments)) ? 'Update & Continue' : 'Continue to Step 2'; ?>
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function displayFileName(input, displayId) {
        const display = document.getElementById(displayId);
        let saveOption;

        // Determine which save option to show based on input name
        if (input.name === 'new_resume') {
            saveOption = document.getElementById('save-resume-to-profile-option');
        } else if (input.name === 'new_cv') {
            saveOption = document.getElementById('save-cv-to-profile-option');
        }

        if (input.files && input.files[0]) {
            display.textContent = 'Selected: ' + input.files[0].name;
            display.classList.remove('hidden');
            if (saveOption) saveOption.style.display = 'block';
        } else {
            display.classList.add('hidden');
            if (saveOption) saveOption.style.display = 'none';
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
                       class="block w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-400 transition-all bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary hover:border-gray-400"
                       accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
            </div>
            <div class="w-32">
                <select name="attachment_types[]" class="block w-full px-3 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary hover:border-gray-400">
                    <option value="Certificate">Certificate</option>
                    <option value="Portfolio">Portfolio</option>
                    <option value="Transcript">Transcript</option>
                    <option value="Others">Others</option>
                </select>
            </div>
            <button type="button" onclick="removeAttachment(this)" 
                    class="text-red-600 transition-colors hover:text-red-800">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
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
        const selectedCVs = document.querySelectorAll('input[name="selected_cvs[]"]:checked');
        const newCV = document.getElementById('new_cv').files.length;

        // Check if user has selected any resume or CV (existing or new)
        const hasAnyDocument = selectedResumes.length > 0 || newResume > 0 || selectedCVs.length > 0 || newCV > 0;

        // Check if user has existing attachments (for users navigating back)
        const hasExistingAttachments = <?php echo !empty($existingAttachments) ? 'true' : 'false'; ?>;

        if (!hasAnyDocument && !hasExistingAttachments) {
            e.preventDefault();
            alert('Please select at least one existing document or upload a new resume/CV to continue.');
            return false;
        }
    });
</script>