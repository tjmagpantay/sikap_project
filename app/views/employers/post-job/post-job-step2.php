<?php
$existingAttachments = $attachments ?? [];
include_once __DIR__ . '/../components/employer_auth_check.php';
include_once __DIR__ . '/../../components/navbar-top.php';
include_once __DIR__ . '/../components/navbar-employer.php';
?>

<div class="flex flex-col items-center min-h-screen py-12 bg-gray-50">
    <div class="w-full max-w-2xl px-4 mx-auto sm:px-8 lg:px-32 xl:px-64">
        <!-- Header -->
        <div class="mb-8 text-center">
            <h1 class="text-3xl font-extrabold font-inter text-primary">Post a New Job</h1>
            <p class="mt-2 text-sm font-inter text-primary">Step 2 of 5 – Attachments</p>
        </div>

        <!-- Progress Bar -->
        <div class="flex items-center justify-between mb-14">
            <?php
            $steps = [
                'Job Details',
                'Attachments',
                'Questions',
                'Settings',
                'Review'
            ];
            $currentStep = 2;
            foreach ($steps as $i => $label): ?>
                <div class="flex flex-col items-center flex-1 min-w-[100px] shrink-0">
                    <div class="w-12 h-2 rounded <?php echo ($i + 1) === $currentStep ? 'bg-primary' : 'bg-gray-300'; ?>"></div>
                    <span class="font-inter text-xs mt-2 <?php echo ($i + 1) === $currentStep ? 'font-normal text-primary' : 'text-gray-400'; ?>">
                        <?php echo $label; ?>
                    </span>
                </div>
                <?php if ($i < count($steps) - 1): ?>
                    <div class="flex-1 h-3 bg-gray-200"></div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

        <!-- Step 2 Content -->
        <form class="space-y-6 font-inter" method="POST" action="?page=post-job&step=2&job_id=<?php echo $job_id; ?>" enctype="multipart/form-data">

            <!-- Success Messages -->
            <?php if (!empty($success)): ?>
                <div class="p-4 mt-6 mb-4 border border-blue-200 rounded-md bg-blue-50">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="text-primary fas fa-check-circle"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-primary"><?php echo htmlspecialchars($success); ?></p>
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

            <!-- File Upload Section -->
            <div>
                <label class="block mb-4 text-sm font-medium text-primary">
                    Upload Job-Related Documents
                </label>

                <div class="p-6 text-center transition-colors border-2 border-dashed rounded-lg border-primary hover:border-blue-400">
                    <div class="space-y-2">
                        <i class="text-4xl text-primary fas fa-cloud-upload-alt"></i>
                        <div>
                            <label for="attachments" class="cursor-pointer">
                                <span class="block mt-2 text-sm font-medium text-primary hover:text-blue-500">
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
                    <h4 class="mb-3 text-sm font-medium text-primary">Current Attachments</h4>
                    <div class="space-y-2">
                        <?php foreach ($existingAttachments as $attachment): ?>
                            <div class="flex items-center justify-between p-3 rounded-lg bg-blue-50">
                                <div class="flex items-center">
                                    <i class="mr-3 text-primary fas fa-file"></i>
                                    <span class="text-sm text-primary">
                                        <?php echo htmlspecialchars(basename($attachment['file_path'])); ?>
                                    </span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <a href="<?php echo htmlspecialchars($attachment['file_path']); ?>"
                                        target="_blank"
                                        class="text-primary hover:text-blue-700">
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
            <div class="p-4 border border-blue-200 rounded-lg bg-blue-50">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="text-primary fas fa-info-circle"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-primary">
                            What can you upload?
                        </h3>
                        <div class="mt-2 text-sm text-primary">
                            <ul class="space-y-1 list-disc list-inside">
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

                <div class="flex gap-2 space-x-3">
                    <button type="submit" name="skip_step"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 ">
                        Skip This Step
                    </button>
                    <button type="submit"
                        class="inline-flex items-center px-6 py-2 text-sm font-medium text-white border border-transparent rounded-md bg-primary hover:bg-blue-700">
                        Continue to Screening
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    // File upload preview
    document.getElementById('attachments').addEventListener('change', function(e) {
        const filePreview = document.getElementById('filePreview');
        filePreview.innerHTML = '';

        Array.from(e.target.files).forEach((file, index) => {
            const fileItem = document.createElement('div');
            fileItem.className = 'flex items-center justify-between p-3 bg-blue-50 border border-blue-200 rounded-lg';

            fileItem.innerHTML = `
            <div class="flex items-center">
                <i class="mr-3 text-primary fas fa-file"></i>
                <div>
                    <div class="text-sm font-medium text-primary">${file.name}</div>
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
        dropZone.classList.add('border-blue-400', 'bg-blue-50');
    });

    dropZone.addEventListener('dragleave', (e) => {
        e.preventDefault();
        dropZone.classList.remove('border-blue-400', 'bg-blue-50');
    });

    dropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropZone.classList.remove('border-blue-400', 'bg-blue-50');

        const files = e.dataTransfer.files;
        const dataTransfer = new DataTransfer();

        Array.from(files).forEach((file) => {
            dataTransfer.items.add(file);
        });

        document.getElementById('attachments').files = dataTransfer.files;
        document.getElementById('attachments').dispatchEvent(new Event('change'));
    });
</script>