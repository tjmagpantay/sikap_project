<?php
// filepath: c:\xampp\htdocs\sikap\app\views\employers\post-job\post-job-step2.php

// Get existing attachments if editing
$existingAttachments = $attachments ?? [];
?>

<?php include_once __DIR__ . '/../../components/navbar-top.php';
include_once __DIR__ . '/../navbar-employer.php';
?>

<div class="min-h-screen py-12 bg-gray-50 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-4xl">
        <div class="text-center">
            <div class="flex justify-center mb-4">
                <div class="p-3 bg-green-600 rounded-full">
                    <i class="text-2xl text-white fas fa-file-upload"></i>
                </div>
            </div>
            <h2 class="mt-6 text-3xl font-extrabold text-center text-gray-900">
                Job Documentation
            </h2>
            <p class="mt-2 text-sm text-center text-gray-600">
                Step 2/5 - Upload Supporting Documents (Optional)
            </p>
        </div>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-4xl">
        <div class="px-4 py-8 bg-white shadow sm:rounded-lg sm:px-10">
            <!-- Progress bar -->
            <div class="w-full h-2 mb-6 bg-gray-200 rounded">
                <div class="h-2 bg-green-600 rounded" style="width: 40%"></div>
            </div>

            <!-- Step Navigation -->
            <div class="mb-6">
                <nav class="flex space-x-2">
                    <a href="?page=post-job&step=1&job_id=<?php echo $job_id; ?>" class="flex-1 px-3 py-2 text-xs font-medium text-center text-green-600 bg-green-100 rounded-md hover:bg-green-200">
                        Job Details
                    </a>
                    <span class="flex-1 px-3 py-2 text-xs font-medium text-center text-white bg-green-600 rounded-md">
                        Documentation
                    </span>
                    <span class="flex-1 px-3 py-2 text-xs font-medium text-center text-gray-500 bg-gray-100 rounded-md">
                        Screening
                    </span>
                    <span class="flex-1 px-3 py-2 text-xs font-medium text-center text-gray-500 bg-gray-100 rounded-md">
                        Settings
                    </span>
                    <span class="flex-1 px-3 py-2 text-xs font-medium text-center text-gray-500 bg-gray-100 rounded-md">
                        Review
                    </span>
                </nav>
            </div>

            <!-- Success Messages -->
            <?php if (!empty($success)): ?>
                <div class="p-4 mb-4 border border-green-200 rounded-md bg-green-50">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="text-green-400 fas fa-check-circle"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-600"><?php echo htmlspecialchars($success); ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Error Messages -->
            <?php if (!empty($error)): ?>
                <div class="p-4 mb-4 border border-red-200 rounded-md bg-red-50">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="text-red-400 fas fa-exclamation-circle"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-600"><?php echo htmlspecialchars($error); ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <form class="space-y-6" method="POST" action="?page=post-job&step=2&job_id=<?php echo $job_id; ?>" enctype="multipart/form-data">
                
                <!-- File Upload Section -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-4">
                        Upload Job-Related Documents
                    </label>
                    
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-green-400 transition-colors">
                        <div class="space-y-2">
                            <i class="fas fa-cloud-upload-alt text-4xl text-gray-400"></i>
                            <div>
                                <label for="attachments" class="cursor-pointer">
                                    <span class="mt-2 block text-sm font-medium text-green-600 hover:text-green-500">
                                        Click to upload files
                                    </span>
                                    <input id="attachments" name="attachments[]" type="file" multiple 
                                           accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                                           class="sr-only">
                                </label>
                                <p class="mt-1 text-xs text-gray-500">
                                    or drag and drop
                                </p>
                            </div>
                            <p class="text-xs text-gray-500">
                                PDF, DOC, DOCX, JPG, PNG up to 5MB each
                            </p>
                        </div>
                    </div>

                    <!-- File Preview Area -->
                    <div id="filePreview" class="mt-4 space-y-2">
                        <!-- Files will be displayed here via JavaScript -->
                    </div>
                </div>

                <!-- Existing Attachments -->
                <?php if (!empty($existingAttachments)): ?>
                    <div>
                        <h4 class="text-sm font-medium text-gray-700 mb-3">Current Attachments</h4>
                        <div class="space-y-2">
                            <?php foreach ($existingAttachments as $attachment): ?>
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <div class="flex items-center">
                                        <i class="fas fa-file text-gray-400 mr-3"></i>
                                        <span class="text-sm text-gray-700">
                                            <?php echo htmlspecialchars(basename($attachment['file_path'])); ?>
                                        </span>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <a href="<?php echo htmlspecialchars($attachment['file_path']); ?>" 
                                           target="_blank"
                                           class="text-green-600 hover:text-green-700">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button type="button" 
                                                onclick="removeAttachment(<?php echo $attachment['attachment_id']; ?>)"
                                                class="text-red-600 hover:text-red-700">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Information Box -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-info-circle text-blue-400"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">
                                What can you upload?
                            </h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <ul class="list-disc list-inside space-y-1">
                                    <li>Company brochures or presentations</li>
                                    <li>Job specification documents</li>
                                    <li>Employee handbook excerpts</li>
                                    <li>Benefits and perks information</li>
                                    <li>Office photos or virtual tour materials</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-between pt-6">
                    <a href="?page=post-job&step=1&job_id=<?php echo $job_id; ?>" 
                       class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                        <i class="mr-2 fas fa-arrow-left"></i>
                        Previous Step
                    </a>

                    <div class="flex space-x-3">
                        <button type="submit" name="skip_step" 
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                            Skip This Step
                            <i class="ml-2 fas fa-arrow-right"></i>
                        </button>
                        <button type="submit" 
                                class="inline-flex items-center px-6 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md hover:bg-green-700">
                            Continue to Screening
                            <i class="ml-2 fas fa-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// File upload preview
document.getElementById('attachments').addEventListener('change', function(e) {
    const filePreview = document.getElementById('filePreview');
    filePreview.innerHTML = '';
    
    Array.from(e.target.files).forEach((file, index) => {
        const fileItem = document.createElement('div');
        fileItem.className = 'flex items-center justify-between p-3 bg-green-50 border border-green-200 rounded-lg';
        
        fileItem.innerHTML = `
            <div class="flex items-center">
                <i class="fas fa-file text-green-600 mr-3"></i>
                <div>
                    <div class="text-sm font-medium text-gray-900">${file.name}</div>
                    <div class="text-xs text-gray-500">${(file.size / 1024 / 1024).toFixed(2)} MB</div>
                </div>
            </div>
            <button type="button" onclick="removeFileFromInput(${index})" 
                    class="text-red-600 hover:text-red-700">
                <i class="fas fa-times"></i>
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
        // AJAX call to remove attachment
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

// Drag and drop functionality
const dropZone = document.querySelector('.border-dashed');

dropZone.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropZone.classList.add('border-green-400', 'bg-green-50');
});

dropZone.addEventListener('dragleave', (e) => {
    e.preventDefault();
    dropZone.classList.remove('border-green-400', 'bg-green-50');
});

dropZone.addEventListener('drop', (e) => {
    e.preventDefault();
    dropZone.classList.remove('border-green-400', 'bg-green-50');
    
    const files = e.dataTransfer.files;
    const dataTransfer = new DataTransfer();
    
    Array.from(files).forEach((file) => {
        dataTransfer.items.add(file);
    });
    
    document.getElementById('attachments').files = dataTransfer.files;
    document.getElementById('attachments').dispatchEvent(new Event('change'));
});
</script>