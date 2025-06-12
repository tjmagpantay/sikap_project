<?php include_once __DIR__ . '/../components/navbar-top.php'; ?>
<?php include_once __DIR__ . '/navbar-jobseeker.php'; ?>

<?php
// Get existing documents
$jobseekerModel = new Jobseeker();
$jobseeker = $jobseekerModel->findByUserId($_SESSION['user_id']);
$documents = [];
if ($jobseeker) {
    $documents = $jobseekerModel->getDocuments($_SESSION['user_id']);
}

// Separate documents by type
$resumeDoc = null;
$cvDoc = null;
foreach ($documents as $doc) {
    if ($doc['file_type'] === 'resume') {
        $resumeDoc = $doc;
    } elseif ($doc['file_type'] === 'cv') {
        $cvDoc = $doc;
    }
}
?>

<div class="min-h-screen bg-gray-50 py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-2xl">
        <div class="text-center">
            <div class="flex justify-center mb-4">
                <div class="p-3 bg-green-600 rounded-full">
                    <i class="fas fa-file-upload text-white text-2xl"></i>
                </div>
            </div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Upload Resume/CV
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Step 1/8
            </p>
            <p class="mt-2 text-center text-sm text-gray-500">
                Kickstart your profile setup with a resume upload to autofill details.
            </p>
        </div>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-2xl">
        <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
            <!-- Progress bar -->
            <div class="w-full bg-gray-200 h-1 rounded mb-6">
                <div class="bg-blue-600 h-1 rounded" style="width: 12.5%"></div>
            </div>

            <!-- Error Messages -->
            <?php if (!empty($error)): ?>
                <div class="mb-4 bg-red-50 border border-red-200 rounded-md p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-600"><?php echo htmlspecialchars($error); ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Success Messages -->
            <?php if (!empty($success)): ?>
                <div class="mb-4 bg-green-50 border border-green-200 rounded-md p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-600"><?php echo htmlspecialchars($success); ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <form class="space-y-6" method="POST" action="?page=complete-jobseeker-profile&step=1" enctype="multipart/form-data">
                <!-- Resume Section -->
                <div>
                    <label for="resume" class="block text-sm font-medium text-gray-700">
                        Resume
                    </label>
                    
                    <?php if ($resumeDoc): ?>
                        <!-- Show existing resume -->
                        <div class="mt-2 p-4 border border-green-200 bg-green-50 rounded-md">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <i class="fas fa-file-pdf text-red-500 text-xl mr-3"></i>
                                    <div>
                                        <p class="text-sm font-medium text-green-800"><?php echo htmlspecialchars($resumeDoc['file_name']); ?></p>
                                        <p class="text-xs text-green-600">Uploaded: <?php echo date('M d, Y', strtotime($resumeDoc['uploaded_at'])); ?></p>
                                    </div>
                                </div>
                                <div class="flex space-x-2">
                                    <a href="<?php echo htmlspecialchars($resumeDoc['file_path']); ?>" target="_blank" 
                                       class="text-xs text-blue-600 hover:text-blue-700">
                                        <i class="fas fa-eye mr-1"></i>View
                                    </a>
                                    <a href="<?php echo htmlspecialchars($resumeDoc['file_path']); ?>" download 
                                       class="text-xs text-green-600 hover:text-green-700">
                                        <i class="fas fa-download mr-1"></i>Download
                                    </a>
                                </div>
                            </div>
                        </div>
                        <p class="mt-1 text-sm text-gray-500">Upload a new file to replace the existing resume.</p>
                    <?php else: ?>
                        <p class="mt-1 text-sm text-gray-500">Please upload your resume in PDF format only.</p>
                    <?php endif; ?>
                    
                    <div class="mt-2">
                        <div class="flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-gray-400 transition-colors">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="resume" class="relative cursor-pointer bg-white rounded-md font-medium text-green-600 hover:text-green-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-green-500">
                                        <span><?php echo $resumeDoc ? 'Replace Resume' : 'Upload Resume'; ?></span>
                                        <input id="resume" name="resume" type="file" class="sr-only" accept=".pdf">
                                    </label>
                                </div>
                                <p class="text-xs text-gray-500">PDF (max. 5mb)</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CV Section -->
                <div>
                    <label for="cv" class="block text-sm font-medium text-gray-700">
                        Curriculum Vitae
                    </label>
                    
                    <?php if ($cvDoc): ?>
                        <!-- Show existing CV -->
                        <div class="mt-2 p-4 border border-green-200 bg-green-50 rounded-md">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <i class="fas fa-file-pdf text-red-500 text-xl mr-3"></i>
                                    <div>
                                        <p class="text-sm font-medium text-green-800"><?php echo htmlspecialchars($cvDoc['file_name']); ?></p>
                                        <p class="text-xs text-green-600">Uploaded: <?php echo date('M d, Y', strtotime($cvDoc['uploaded_at'])); ?></p>
                                    </div>
                                </div>
                                <div class="flex space-x-2">
                                    <a href="<?php echo htmlspecialchars($cvDoc['file_path']); ?>" target="_blank" 
                                       class="text-xs text-blue-600 hover:text-blue-700">
                                        <i class="fas fa-eye mr-1"></i>View
                                    </a>
                                    <a href="<?php echo htmlspecialchars($cvDoc['file_path']); ?>" download 
                                       class="text-xs text-green-600 hover:text-green-700">
                                        <i class="fas fa-download mr-1"></i>Download
                                    </a>
                                </div>
                            </div>
                        </div>
                        <p class="mt-1 text-sm text-gray-500">Upload a new file to replace the existing CV.</p>
                    <?php else: ?>
                        <p class="mt-1 text-sm text-gray-500">Please upload your CV in PDF format only.</p>
                    <?php endif; ?>
                    
                    <div class="mt-2">
                        <div class="flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-gray-400 transition-colors">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="cv" class="relative cursor-pointer bg-white rounded-md font-medium text-green-600 hover:text-green-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-green-500">
                                        <span><?php echo $cvDoc ? 'Replace CV' : 'Upload CV'; ?></span>
                                        <input id="cv" name="cv" type="file" class="sr-only" accept=".pdf">
                                    </label>
                                </div>
                                <p class="text-xs text-gray-500">PDF (max. 5mb)</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-between">
                    <a href="?page=complete-jobseeker-profile&step=2" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        Skip For Now
                    </a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                        <?php echo ($resumeDoc || $cvDoc) ? 'Update & Continue' : 'Next Step'; ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>