<?php
include_once __DIR__ . '/../components/employer_auth_check.php';
include_once __DIR__ . '../../../components/navbar-top.php';
include_once __DIR__ . '/../components/navbar-employer.php';

// Document types and their labels
$documentTypes = [
    'letter_of_intent' => 'Letter of Intent',
    'company_profile' => 'Company Profile',
    'business_permit' => 'Business Permit',
    'cert_of_no_pending_case' => 'Certificate of No Pending Case',
    'dole_registration' => 'DOLE Registration',
    'cert_no_objection' => 'Certificate of No Objection',
    'poea_reg' => 'POEA Registration',
    'job_vaccancies_qual' => 'Job Vacancies & Qualifications',
    'phil_jobnet_reg' => 'PhilJobNet Registration'
];

// Get employer data for secure links
$employer = $this->employerModel->findByUserId($_SESSION['user_id']);
if (!$employer) {
    header('Location: ?page=complete-employer-profile');
    exit;
}

// Get existing documents
$documents = $this->employerModel->getDocuments($employer['employer_id']) ?: [];

// Debug output
error_log("DEBUG: Documents retrieved: " . print_r($documents, true));
?>

<div class="min-h-screen py-6">
    <div class="sm:mx-auto sm:w-full sm:max-w-2xl">
        <div class="text-center">
            <!-- <div class="flex justify-center mb-4">
                <div class="flex items-center justify-center w-12 h-12 rounded-full bg-primary">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div> -->
            <h2 class="mt-6 text-3xl font-extrabold text-center text-gray-900">
                Upload Required Documents
            </h2>
            <p class="mt-2 text-sm text-center text-gray-500">
                Upload all required business documents (PDF format only, max 5MB each)
            </p>
        </div>
    </div>


    <div class="mt-4 sm:mx-auto sm:w-full sm:max-w-2xl">
        <div class="px-4 py-8 bg-white shadow sm:rounded-lg sm:px-10">
            <!-- Enhanced Progress bar with clickable steps -->
            <div class="mb-6">
                <!-- Step indicators -->
                <div class="flex items-center justify-between w-full mb-4">
                    <!-- Step 1 -->
                    <div class="flex flex-col items-center">
                        <a href="?page=complete-employer-business&step=1" class="flex items-center justify-center w-8 h-8 text-white transition-colors rounded-full bg-primary hover:bg-blue-700">
                            <span class="text-sm font-semibold">1</span>
                        </a>
                        <span class="mt-1 text-xs text-gray-600">Basic</span>
                    </div>

                    <!-- Step 2 -->
                    <div class="flex flex-col items-center">
                        <a href="?page=complete-employer-business&step=2" class="flex items-center justify-center w-8 h-8 text-white transition-colors rounded-full bg-primary hover:bg-blue-700">
                            <span class="text-sm font-semibold">2</span>
                        </a>
                        <span class="mt-1 text-xs text-gray-600">Founding</span>
                    </div>

                    <!-- Step 3 -->
                    <div class="flex flex-col items-center">
                        <a href="?page=complete-employer-business&step=3" class="flex items-center justify-center w-8 h-8 text-white transition-colors rounded-full bg-primary hover:bg-blue-700">
                            <span class="text-sm font-semibold">3</span>
                        </a>
                        <span class="mt-1 text-xs text-gray-600">Social</span>
                    </div>

                    <!-- Step 4 -->
                    <div class="flex flex-col items-center">
                        <div class="flex items-center justify-center w-8 h-8 text-white rounded-full bg-primary">
                            <span class="text-sm font-semibold">4</span>
                        </div>
                        <span class="mt-1 text-xs text-gray-600">Documents</span>
                    </div>

                    <!-- Step 5 -->
                    <div class="flex flex-col items-center">
                        <a href="?page=complete-employer-business&step=5" class="flex items-center justify-center w-8 h-8 text-gray-500 transition-colors bg-gray-200 rounded-full hover:bg-gray-300 hover:text-gray-700">
                            <span class="text-sm font-semibold">5</span>
                        </a>
                        <span class="mt-1 text-xs text-gray-500">Review</span>
                    </div>
                </div>

                <!-- Progress bar -->
                <div class="w-full h-2 bg-gray-200 rounded">
                    <div class="h-2 rounded bg-primary" style="width: 80%"></div>
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

            <form class="space-y-4" method="POST" action="?page=complete-employer-business&step=4" enctype="multipart/form-data">
                <!-- Document Upload Grid -->
                <div class="grid grid-cols-1 space-y-2 md:grid-cols-1">
                    <?php foreach ($documentTypes as $type => $label): ?>
                        <div class="p-4 transition-all border border-gray-200 rounded-lg hover:border-gray-300">
                            <label for="<?php echo $type; ?>" class="block mb-2 text-xs font-medium text-gray-500">
                                <?php echo $label; ?>
                                <?php if (in_array($type, ['letter_of_intent', 'company_profile', 'business_permit'])): ?>
                                    <span class="text-red-500">*</span>
                                <?php endif; ?>
                            </label>

                            <?php if (!empty($documents[$type])): ?>
                                <!-- Show existing document -->
                                <div class="p-3 mb-3 border rounded-md border-primary bg-blue-50">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 mr-2 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                                            </svg>
                                            <div>
                                                <p class="text-xs font-medium text-primary">Document uploaded</p>
                                                <p class="text-xs text-gray-400">Click to view or download</p>
                                            </div>
                                        </div>
                                        <div class="flex gap-2">
                                            <!-- ✅ FIXED: Correct links for viewing and downloading documents -->
                                            <a href="?page=view-employer-document&type=<?php echo $type; ?>&employer_id=<?php echo $employer['employer_id']; ?>" target="_blank"
                                                class="px-2 py-1 text-xs font-medium transition-colors bg-blue-100 rounded text-primary hover:bg-blue-200">
                                                View
                                            </a>
                                            <a href="?page=download-employer-document&type=<?php echo $type; ?>&employer_id=<?php echo $employer['employer_id']; ?>&download=1"
                                                class="px-2 py-1 text-xs font-medium text-white transition-colors rounded bg-primary hover:bg-blue-700">
                                                Download
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <p class="mb-2 text-xs text-gray-500">Upload a new file to replace the existing document.</p>
                            <?php endif; ?>

                            <div class="flex justify-center px-4 py-4 transition-colors border-2 border-gray-300 border-dashed rounded-md hover:border-gray-400">
                                <div class="space-y-1 text-center">
                                    <svg class="w-8 h-8 mx-auto text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="text-sm text-gray-600">
                                        <label for="<?php echo $type; ?>" class="relative justify-center font-medium bg-white rounded-md cursor-pointer text-primary hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-primary">
                                            <span><?php echo !empty($documents[$type]) ? 'Replace' : 'Upload'; ?></span>
                                            <input id="<?php echo $type; ?>" name="<?php echo $type; ?>" type="file" class="sr-only" accept=".pdf">
                                        </label>
                                    </div>
                                    <p class="text-xs text-gray-500">PDF up to 5MB</p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Important Notice -->
                <div class="p-4 rounded-md bg-yellow-50">
                    <h4 class="text-sm font-medium text-yellow-800">Important Notice</h4>
                    <div class="mt-2 text-xs text-yellow-700">
                        <ul class="space-y-2">
                            <li class="flex items-start">
                                <svg class="flex-shrink-0 w-4 h-4 mt-0.5 mr-2 text-secondary" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                All documents must be in PDF format
                            </li>
                            <li class="flex items-start">
                                <svg class="flex-shrink-0 w-4 h-4 mt-0.5 mr-2 text-secondary" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                Maximum file size: 5MB per document
                            </li>
                            <li class="flex items-start">
                                <svg class="flex-shrink-0 w-4 h-4 mt-0.5 mr-2 text-secondary" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                Documents marked with * are required
                            </li>
                            <li class="flex items-start">
                                <svg class="flex-shrink-0 w-4 h-4 mt-0.5 mr-2 text-secondary" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                Ensure all documents are clear and legible
                            </li>
                            <li class="flex items-start">
                                <svg class="flex-shrink-0 w-4 h-4 mt-0.5 mr-2 text-secondary" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                Documents will be reviewed by admin for verification
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="flex justify-between">
                    <a href="?page=complete-employer-business&step=3" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back
                    </a>
                    <?php
                    // Check if business has existing documents
                    $hasExistingDocs = false;
                    foreach ($documentTypes as $type => $label) {
                        if (!empty($documents[$type])) {
                            $hasExistingDocs = true;
                            break;
                        }
                    }
                    ?>
                    <?php if ($hasExistingDocs): ?>
                        <button type="submit" name="submit_step4"
                            class="inline-flex items-center px-6 py-2 text-sm font-medium text-white border border-transparent rounded-md shadow-sm bg-primary hover:bg-blue-700">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Update Documents
                        </button>
                    <?php else: ?>
                        <button type="submit" name="submit_step4"
                            class="inline-flex items-center px-6 py-2 text-sm font-medium text-white border border-transparent rounded-md shadow-sm bg-primary hover:bg-blue-700">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                            Upload & Continue
                        </button>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>
</div>