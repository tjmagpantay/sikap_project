<?php
$existingAttachments = $attachments ?? [];
include_once __DIR__ . '/../components/employer_auth_check.php';
include_once __DIR__ . '/../../components/navbar-top.php';
include_once __DIR__ . '/../components/navbar-employer.php';
?>

<div class="min-h-screen py-6">
    <div class="sm:mx-auto sm:w-full sm:max-w-2xl">
        <div class="text-center">
            <h2 class="mt-2 text-3xl font-extrabold text-center text-grayMain">
                Post a New Job
            </h2>
            <p class="mt-2 text-sm text-center text-gray-500">
                Add attachments to enhance your job posting
            </p>
        </div>
    </div>

    <div class="mt-4 sm:mx-auto sm:w-full sm:max-w-2xl">
        <div class="px-4 py-8 bg-white shadow sm:rounded-lg sm:px-10">
            <!-- Progress bar with steps -->
            <div class="mb-6">
                <!-- Step indicators -->
                <div class="flex items-center justify-between w-full mb-4">
                    <!-- Step 1 -->
                    <div class="flex flex-col items-center">
                        <a href="?page=post-job&step=1&job_id=<?php echo $job_id; ?>" class="flex items-center justify-center w-8 h-8 text-white transition-colors rounded-full bg-primary hover:bg-blue-700">
                            <span class="text-sm font-semibold">1</span>
                        </a>
                        <span class="mt-1 text-xs text-gray-600">Job Details</span>
                    </div>

                    <!-- Step 2 -->
                    <div class="flex flex-col items-center">
                        <div class="flex items-center justify-center w-8 h-8 text-white rounded-full bg-primary">
                            <span class="text-sm font-semibold">2</span>
                        </div>
                        <span class="mt-1 text-xs text-gray-600">Attachments</span>
                    </div>

                    <!-- Step 3 -->
                    <div class="flex flex-col items-center">
                        <div class="flex items-center justify-center w-8 h-8 text-gray-500 bg-gray-200 rounded-full">
                            <span class="text-sm font-semibold">3</span>
                        </div>
                        <span class="mt-1 text-xs text-gray-500">Questions</span>
                    </div>

                    <!-- Step 4 -->
                    <div class="flex flex-col items-center">
                        <div class="flex items-center justify-center w-8 h-8 text-gray-500 bg-gray-200 rounded-full">
                            <span class="text-sm font-semibold">4</span>
                        </div>
                        <span class="mt-1 text-xs text-gray-500">Settings</span>
                    </div>

                    <!-- Step 5 -->
                    <div class="flex flex-col items-center">
                        <div class="flex items-center justify-center w-8 h-8 text-gray-500 bg-gray-200 rounded-full">
                            <span class="text-sm font-semibold">5</span>
                        </div>
                        <span class="mt-1 text-xs text-gray-500">Review</span>
                    </div>
                </div>

                <!-- Progress bar -->
                <div class="w-full h-2 bg-gray-200 rounded">
                    <div class="h-2 rounded bg-primary" style="width: 40%"></div>
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

            <!-- Success Messages -->
            <?php if (!empty($success)): ?>
                <div class="p-4 mb-4 border border-blue-200 rounded-md bg-blue-50">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-primary"><?php echo htmlspecialchars($success); ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Information Box -->
            <div class="p-4 mb-6 border border-blue-200 rounded-md bg-blue-50">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-primary">
                            Enhance your job posting with PDF attachments
                        </h3>
                        <div class="mt-2 text-xs text-primary">
                            <ul class="space-y-1 list-disc list-inside">
                                <li>Company brochures or presentations (PDF)</li>
                                <li>Job specification documents (PDF)</li>
                                <li>Benefits and perks information (PDF)</li>
                                <li>Company profile or organizational chart (PDF)</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form -->
            <form class="space-y-6 font-inter" method="POST" action="?page=post-job&step=2&job_id=<?php echo $job_id; ?>" enctype="multipart/form-data">

                <!-- File Upload Section -->
                <div>
                    <label class="block mb-3 text-sm font-medium text-primary">
                        Upload PDF Documents
                    </label>

                    <div class="p-6 text-center transition-colors border-2 border-dashed rounded-lg border-primary hover:border-blue-400" style="border-width:2px; border-style:dashed !important; border-color:currentColor !important;">
                        <div class="space-y-2">
                            <svg class="w-12 h-12 mx-auto text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                            <div>
                                <label for="attachments" class="cursor-pointer">
                                    <span class="block mt-2 text-sm font-medium text-primary hover:text-blue-500">
                                        Click to upload PDF files
                                    </span>
                                    <input id="attachments" name="attachments[]" type="file" multiple
                                        accept=".pdf"
                                        class="sr-only">
                                </label>
                                <p class="mt-1 text-xs text-gray-500">
                                    or drag and drop PDF files
                                </p>
                            </div>
                            <p class="text-xs text-gray-500">
                                <strong>PDF files only</strong> • Maximum 5MB each • Up to 5 files
                            </p>
                        </div>
                    </div>

                    <!-- Validation Error Display -->
                    <div id="validationError" class="hidden mt-2 text-xs text-red-600"></div>

                    <!-- File Preview Area -->
                    <div id="filePreview" class="mt-4 space-y-2">
                        <!-- Files will be displayed here via JavaScript -->
                    </div>
                </div>

                <!-- Existing Attachments -->
                <?php if (!empty($existingAttachments)): ?>
                    <div>
                        <h4 class="mb-3 text-sm font-medium text-primary">Current Attachments</h4>
                        <div class="space-y-2">
                            <?php foreach ($existingAttachments as $attachment): ?>
                                <div class="flex items-center justify-between p-3 border border-blue-200 rounded-lg bg-blue-50">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 mr-3 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                                        </svg>
                                        <span class="text-sm text-primary">
                                            <?php echo htmlspecialchars(basename($attachment['file_path'])); ?>
                                        </span>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <a href="<?php echo htmlspecialchars($attachment['file_path']); ?>"
                                            target="_blank"
                                            class="text-primary hover:text-blue-700">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                        <button type="button"
                                            onclick="removeAttachment(<?php echo $attachment['attachment_id']; ?>)"
                                            class="text-red-600 hover:text-red-700">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Action Buttons -->
                <div class="flex justify-between pt-6">
                    <a href="?page=post-job&step=1&job_id=<?php echo $job_id; ?>"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Previous Step
                    </a>

                    <div class="flex gap-3">
                        <button type="submit" name="skip_step"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">
                            Skip This Step
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>
                        <button type="submit" id="submitBtn"
                            class="inline-flex items-center px-6 py-2 text-sm font-medium text-white border border-transparent rounded-md shadow-sm bg-primary hover:bg-blue-700">
                            Continue to Questions
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // File validation function
    function validateFile(file) {
        const maxSize = 5 * 1024 * 1024; // 5MB
        const allowedType = 'application/pdf';

        if (file.type !== allowedType) {
            return `${file.name} is not a PDF file. Only PDF files are allowed.`;
        }

        if (file.size > maxSize) {
            return `${file.name} is too large. Maximum file size is 5MB.`;
        }

        return null;
    }

    // Show validation error
    function showValidationError(message) {
        const errorDiv = document.getElementById('validationError');
        errorDiv.textContent = message;
        errorDiv.classList.remove('hidden');
    }

    // Hide validation error
    function hideValidationError() {
        const errorDiv = document.getElementById('validationError');
        errorDiv.classList.add('hidden');
    }

    // File upload preview with validation
    document.getElementById('attachments').addEventListener('change', function(e) {
        const filePreview = document.getElementById('filePreview');
        const files = Array.from(e.target.files);
        const maxFiles = 5;

        hideValidationError();
        filePreview.innerHTML = '';

        // Check number of files
        if (files.length > maxFiles) {
            showValidationError(`Too many files selected. Maximum ${maxFiles} files allowed.`);
            this.value = '';
            return;
        }

        // Validate each file
        let hasErrors = false;
        for (let file of files) {
            const error = validateFile(file);
            if (error) {
                showValidationError(error);
                hasErrors = true;
                break;
            }
        }

        if (hasErrors) {
            this.value = '';
            return;
        }

        // Display valid files
        files.forEach((file, index) => {
            const fileItem = document.createElement('div');
            fileItem.className = 'flex items-center justify-between p-3 bg-blue-50 border border-blue-200 rounded-lg';

            fileItem.innerHTML = `
                <div class="flex items-center gap-2">
                    <img
                        src="../public/assets/icons/pdf-icon.png"
                        alt="Icon"
                    class="object-cover w-8 h-8" />
                    <div>
                        <div class="text-sm font-medium text-primary">${file.name}</div>
                        <div class="text-xs text-primary">${(file.size / 1024 / 1024).toFixed(2)} MB • PDF</div>
                    </div>
                </div>
                <button type="button" onclick="removeFileFromInput(${index})" 
                        class="text-red-600 hover:text-red-700">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            `;

            filePreview.appendChild(fileItem);
        });
    });

    // Remove file from input
    function removeFileFromInput(index) {
        const input = document.getElementById('attachments');
        const dt = new DataTransfer();

        Array.from(input.files).forEach((file, i) => {
            if (i !== index) {
                dt.items.add(file);
            }
        });

        input.files = dt.files;
        input.dispatchEvent(new Event('change'));
    }

    // Remove existing attachment
    function removeAttachment(attachmentId) {
        if (confirm('Are you sure you want to remove this attachment?')) {
            fetch(`?page=remove-attachment&id=${attachmentId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Failed to remove attachment');
                    }
                });
        }
    }

    // Enhanced drag and drop with validation
    const dropZone = document.querySelector('.border-dashed');

    dropZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropZone.classList.add('border-blue-400', 'bg-blue-50');
    });

    dropZone.addEventListener('dragleave', (e) => {
        e.preventDefault();
        dropZone.classList.remove('border-blue-400', 'bg-blue-50');
    });

    dropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropZone.classList.remove('border-blue-400', 'bg-blue-50');

        const files = Array.from(e.dataTransfer.files);
        const maxFiles = 5;

        hideValidationError();

        // Check number of files
        if (files.length > maxFiles) {
            showValidationError(`Too many files dropped. Maximum ${maxFiles} files allowed.`);
            return;
        }

        // Validate each file
        let hasErrors = false;
        for (let file of files) {
            const error = validateFile(file);
            if (error) {
                showValidationError(error);
                hasErrors = true;
                break;
            }
        }

        if (hasErrors) {
            return;
        }

        // Set valid files to input
        const dataTransfer = new DataTransfer();
        files.forEach((file) => {
            dataTransfer.items.add(file);
        });

        document.getElementById('attachments').files = dataTransfer.files;
        document.getElementById('attachments').dispatchEvent(new Event('change'));
    });

    // Prevent form submission if validation errors exist
    document.querySelector('form').addEventListener('submit', function(e) {
        const errorDiv = document.getElementById('validationError');
        if (!errorDiv.classList.contains('hidden')) {
            e.preventDefault();
            showValidationError('Please fix the file validation errors before proceeding.');
        }
    });
</script>