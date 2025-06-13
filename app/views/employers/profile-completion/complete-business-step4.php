<?php include_once __DIR__ . '/../../components/navbar-top.php';
include_once __DIR__ . '/../navbar-employer.php';
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
?>

<div class="min-h-screen py-12 bg-gray-50 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-3xl">
        <div class="text-center">
            <div class="flex justify-center mb-4">
                <div class="p-3 bg-blue-600 rounded-full">
                    <i class="text-2xl text-white fas fa-file-upload"></i>
                </div>
            </div>
            <h2 class="mt-6 text-3xl font-extrabold text-center text-gray-900">
                Upload Required Documents
            </h2>
            <p class="mt-2 text-sm text-center text-gray-600">
                Step 4/5
            </p>
            <p class="mt-2 text-sm text-center text-gray-500">
                Upload all required business documents (PDF format only, max 5MB each)
            </p>
        </div>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-3xl">
        <div class="px-4 py-8 bg-white shadow sm:rounded-lg sm:px-10">
            <!-- Progress bar -->
            <div class="w-full h-2 mb-6 bg-gray-200 rounded">
                <div class="h-2 bg-blue-600 rounded" style="width: 80%"></div>
            </div>

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

            <form class="space-y-6" method="POST" action="?page=complete-employer-business&step=4" enctype="multipart/form-data">
                <!-- Document Upload Grid -->
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <?php foreach ($documentTypes as $type => $label): ?>
                        <div class="p-4 border border-gray-200 rounded-lg">
                            <label for="<?php echo $type; ?>" class="block mb-2 text-sm font-medium text-gray-700">
                                <?php echo $label; ?>
                                <?php if (in_array($type, ['letter_of_intent', 'company_profile', 'business_permit'])): ?>
                                    <span class="text-red-500">*</span>
                                <?php endif; ?>
                            </label>
                            
                            <?php if (!empty($documents[$type])): ?>
                                <!-- Show existing document -->
                                <div class="p-3 mb-3 border border-green-200 rounded-md bg-green-50">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <i class="mr-2 text-lg text-red-500 fas fa-file-pdf"></i>
                                            <div>
                                                <p class="text-sm font-medium text-green-800">Document uploaded</p>
                                                <p class="text-xs text-green-600">Click to view or download</p>
                                            </div>
                                        </div>
                                        <div class="flex space-x-2">
                                            <a href="<?php echo htmlspecialchars($documents[$type]); ?>" target="_blank" 
                                               class="text-xs text-blue-600 hover:text-blue-700">
                                                <i class="mr-1 fas fa-eye"></i>View
                                            </a>
                                            <a href="<?php echo htmlspecialchars($documents[$type]); ?>" download 
                                               class="text-xs text-green-600 hover:text-green-700">
                                                <i class="mr-1 fas fa-download"></i>Download
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <p class="mb-2 text-xs text-gray-500">Upload a new file to replace the existing document.</p>
                            <?php endif; ?>
                            
                            <div class="flex justify-center px-4 pt-4 pb-4 transition-colors border-2 border-gray-300 border-dashed rounded-md hover:border-gray-400">
                                <div class="space-y-1 text-center">
                                    <svg class="w-8 h-8 mx-auto text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="<?php echo $type; ?>" class="relative font-medium text-blue-600 bg-white rounded-md cursor-pointer hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
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
                <div class="p-4 border border-yellow-200 rounded-md bg-yellow-50">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="text-yellow-400 fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="ml-3">
                            <h4 class="text-sm font-medium text-yellow-800">Important Notice</h4>
                            <div class="mt-2 text-sm text-yellow-700">
                                <ul class="space-y-1 list-disc list-inside">
                                    <li>All documents must be in PDF format</li>
                                    <li>Maximum file size: 5MB per document</li>
                                    <li>Documents marked with * are required</li>
                                    <li>Ensure all documents are clear and legible</li>
                                    <li>Documents will be reviewed by admin for verification</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-between">
                    <a href="?page=complete-employer-business&step=3" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                        <i class="mr-2 fas fa-arrow-left"></i>
                        Back
                    </a>
                    <a href="?page=complete-employer-business&step=5" 
                        class="inline-flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-white transition-colors bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                        <i class="mr-2 fas fa-plus"></i>
                        Next Step
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>