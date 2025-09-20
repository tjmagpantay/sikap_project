<?php
include_once __DIR__ . '/../components/jobseeker_auth_check.php';
include_once __DIR__ . '/../../components/navbar-top.php';
include_once __DIR__ . '/../components/navbar-jobseeker.php'; ?>

<div class="min-h-screen py-6">
    <div class="sm:mx-auto sm:w-full sm:max-w-2xl">
        <div class="text-center">

            <h2 class="mt-2 text-3xl font-extrabold text-center text-grayMain">
                Upload Your Documents
            </h2>
            <p class="mt-2 text-sm text-center text-gray-500">
                Upload your resume and CV to help employers discover you
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
                        <div class="flex items-center justify-center w-8 h-8 text-white rounded-full bg-primary">
                            <span class="text-sm font-semibold">1</span>
                        </div>
                        <span class="mt-1 text-xs text-gray-600">Documents</span>
                    </div>

                    <!-- Step 2 -->
                    <div class="flex flex-col items-center">
                        <a href="?page=complete-jobseeker-profile&step=2" class="flex items-center justify-center w-8 h-8 text-gray-500 transition-colors bg-gray-200 rounded-full hover:bg-gray-300 hover:text-gray-700">
                            <span class="text-sm font-semibold">2</span>
                        </a>
                        <span class="mt-1 text-xs text-gray-500">Basic Info</span>
                    </div>

                    <!-- Step 3 -->
                    <div class="flex flex-col items-center">
                        <a href="?page=complete-jobseeker-profile&step=3" class="flex items-center justify-center w-8 h-8 text-gray-500 transition-colors bg-gray-200 rounded-full hover:bg-gray-300 hover:text-gray-700">
                            <span class="text-sm font-semibold">3</span>
                        </a>
                        <span class="mt-1 text-xs text-gray-500">Education</span>
                    </div>

                    <!-- Step 4 -->
                    <div class="flex flex-col items-center">
                        <a href="?page=complete-jobseeker-profile&step=4" class="flex items-center justify-center w-8 h-8 text-gray-500 transition-colors bg-gray-200 rounded-full hover:bg-gray-300 hover:text-gray-700">
                            <span class="text-sm font-semibold">4</span>
                        </a>
                        <span class="mt-1 text-xs text-gray-500">Experience</span>
                    </div>

                    <!-- Step 5 -->
                    <div class="flex flex-col items-center">
                        <a href="?page=complete-jobseeker-profile&step=5" class="flex items-center justify-center w-8 h-8 text-gray-500 transition-colors bg-gray-200 rounded-full hover:bg-gray-300 hover:text-gray-700">
                            <span class="text-sm font-semibold">5</span>
                        </a>
                        <span class="mt-1 text-xs text-gray-500">Skills</span>
                    </div>

                    <!-- Step 6 -->
                    <div class="flex flex-col items-center">
                        <a href="?page=complete-jobseeker-profile&step=6" class="flex items-center justify-center w-8 h-8 text-gray-500 transition-colors bg-gray-200 rounded-full hover:bg-gray-300 hover:text-gray-700">
                            <span class="text-sm font-semibold">6</span>
                        </a>
                        <span class="mt-1 text-xs text-gray-500">Certificates</span>
                    </div>

                    <!-- Step 7 -->
                    <div class="flex flex-col items-center">
                        <a href="?page=complete-jobseeker-profile&step=7" class="flex items-center justify-center w-8 h-8 text-gray-500 transition-colors bg-gray-200 rounded-full hover:bg-gray-300 hover:text-gray-700">
                            <span class="text-sm font-semibold">7</span>
                        </a>
                        <span class="mt-1 text-xs text-gray-500">Review</span>
                    </div>
                </div>

                <!-- Progress bar -->
                <div class="w-full h-2 bg-gray-200 rounded">
                    <div class="h-2 rounded bg-primary" style="width: 14.29%"></div>
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

            <form class="space-y-6" method="POST" action="?page=complete-jobseeker-profile&step=1" enctype="multipart/form-data">
                <!-- Resume Upload Section -->
                <div>
                    <label for="resume" class="block mb-1 text-xs font-medium text-gray-500">
                        Resume <span class="text-red-500">*</span>
                    </label>
                    <p class="mt-1 text-xs text-gray-500">
                        Upload your professional resume in PDF format. Max file size 5 MB.
                    </p>

                    <div class="grid grid-cols-2 gap-6 p-4 py-6 mt-2 mb-6 rounded-md bg-gray-50 text-primary"
                        style="border-width:2px; border-style:dashed !important; border-color:currentColor !important;">

                        <!-- Right Column - Current Resume Display -->
                        <div class="flex flex-col items-center justify-center text-center">
                            <?php if (!empty($resumeDoc)): ?>
                                <!-- FIXED: Use the correct document viewing URL -->
                                <a href="?page=view-document&doc_id=<?php echo htmlspecialchars($resumeDoc['document_id']); ?>" target="_blank" class="transition-transform hover:scale-105">
                                    <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 rounded-md hover:bg-red-200">
                                        <img
                                    src="../public/assets/icons/pdf-icon.png"
                                    alt="Icon"
                                    class="object-cover w-8 h-8" />
                                    </div>
                                    <p class="mt-2 text-xs font-medium text-red-400">
                                        <?php echo htmlspecialchars($resumeDoc['original_filename'] ?? $resumeDoc['file_name'] ?? 'Resume.pdf'); ?>
                                    </p>
                                </a>
                            <?php else: ?>
                                <p class="text-sm text-gray-500">No resume uploaded yet.</p>
                            <?php endif; ?>

                            <p class="mt-3 text-xs text-gray-500">
                                Ensure your resume is updated and professional.
                            </p>
                        </div>

                        <!-- Left Column - Upload/Edit Function -->
                        <div class="flex flex-col justify-center text-center">
                            <svg viewBox="0 0 1024 1024" class="w-12 h-12 mx-auto mb-3" xmlns="http://www.w3.org/2000/svg">
                                <path d="M736.68 435.86a173.773 173.773 0 0 1 172.042 172.038c0.578 44.907-18.093 87.822-48.461 119.698-32.761 34.387-76.991 51.744-123.581 52.343-68.202 0.876-68.284 106.718 0 105.841 152.654-1.964 275.918-125.229 277.883-277.883 1.964-152.664-128.188-275.956-277.883-277.879-68.284-0.878-68.202 104.965 0 105.842zM285.262 779.307A173.773 173.773 0 0 1 113.22 607.266c-0.577-44.909 18.09-87.823 48.461-119.705 32.759-34.386 76.988-51.737 123.58-52.337 68.2-0.877 68.284-106.721 0-105.842C132.605 331.344 9.341 454.607 7.379 607.266 5.417 759.929 135.565 883.225 285.262 885.148c68.284 0.876 68.2-104.965 0-105.841z" fill="#092c4c"></path>
                                <path d="M339.68 384.204a173.762 173.762 0 0 1 172.037-172.038c44.908-0.577 87.822 18.092 119.698 48.462 34.388 32.759 51.743 76.985 52.343 123.576 0.877 68.199 106.72 68.284 105.843 0-1.964-152.653-125.231-275.917-277.884-277.879-152.664-1.962-275.954 128.182-277.878 277.879-0.88 68.284 104.964 68.199 105.841 0z" fill="#092c4c"></path>
                                <path d="M545.039 473.078c16.542 16.542 16.542 43.356 0 59.896l-122.89 122.895c-16.542 16.538-43.357 16.538-59.896 0-16.542-16.546-16.542-43.362 0-59.899l122.892-122.892c16.537-16.542 43.355-16.542 59.894 0z" fill="#F39A2B"></path>
                                <path d="M485.17 473.078c16.537-16.539 43.354-16.539 59.892 0l122.896 122.896c16.538 16.533 16.538 43.354 0 59.896-16.541 16.538-43.361 16.538-59.898 0L485.17 532.979c-16.547-16.543-16.547-43.359 0-59.901z" fill="#F39A2B"></path>
                                <path d="M514.045 634.097c23.972 0 43.402 19.433 43.402 43.399v178.086c0 23.968-19.432 43.398-43.402 43.398-23.964 0-43.396-19.432-43.396-43.398V677.496c0.001-23.968 19.433-43.399 43.396-43.399z" fill="#F39A2B"></path>
                            </svg>

                            <label for="resume" class="inline-block px-4 py-2 text-sm font-medium text-white rounded-md cursor-pointer bg-primary hover:bg-primary/80">
                                <?php echo !empty($resumeDoc) ? 'Replace Resume' : 'Upload Resume'; ?>
                                <input id="resume" name="resume" type="file" class="sr-only" accept=".pdf">
                            </label>
                            <p class="mt-2 text-xs text-gray-500">PDF format only, max 5MB</p>
                        </div>

                    </div>
                </div>

                <!-- CV Upload Section -->
                <div>
                    <label for="cv" class="block mb-1 text-xs font-medium text-gray-500">
                        Curriculum Vitae
                    </label>
                    <p class="mt-1 text-xs text-gray-500">
                        Upload your CV in PDF format if different from your resume. Max file size 5 MB.
                    </p>

                    <div class="grid grid-cols-2 gap-6 p-4 py-6 mt-2 mb-6 rounded-md bg-gray-50 text-primary"
                        style="border-width:2px; border-style:dashed !important; border-color:currentColor !important;">

                        <!-- Left Column - Current CV Display -->
                        <div class="flex flex-col items-center justify-center text-center">
                            <?php if (!empty($cvDoc)): ?>
                                <!-- FIXED: Use the correct document viewing URL -->
                                <a href="?page=view-document&doc_id=<?php echo htmlspecialchars($cvDoc['document_id']); ?>" target="_blank" class="transition-transform hover:scale-105">
                                    <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 rounded-md hover:bg-red-200">
                                        <img
                                    src="../public/assets/icons/pdf-icon.png"
                                    alt="Icon"
                                    class="object-cover w-8 h-8" />
                                    </div>
                                    <p class="mt-2 text-xs font-medium text-red-400">
                                        <?php echo htmlspecialchars($cvDoc['original_filename'] ?? $cvDoc['file_name'] ?? 'CV.pdf'); ?>
                                    </p>
                                </a>
                            <?php else: ?>
                                <p class="text-sm text-gray-500">No CV uploaded yet.</p>
                            <?php endif; ?>

                            <p class="mt-3 text-xs text-gray-500">
                                Ensure your CV is updated and professional.
                            </p>
                        </div>

                        <!-- Right Column - Upload/Edit Function -->
                        <div class="flex flex-col justify-center text-center">
                            <svg viewBox="0 0 1024 1024" class="w-12 h-12 mx-auto mb-3" xmlns="http://www.w3.org/2000/svg">
                                <path d="M736.68 435.86a173.773 173.773 0 0 1 172.042 172.038c0.578 44.907-18.093 87.822-48.461 119.698-32.761 34.387-76.991 51.744-123.581 52.343-68.202 0.876-68.284 106.718 0 105.841 152.654-1.964 275.918-125.229 277.883-277.883 1.964-152.664-128.188-275.956-277.883-277.879-68.284-0.878-68.202 104.965 0 105.842zM285.262 779.307A173.773 173.773 0 0 1 113.22 607.266c-0.577-44.909 18.09-87.823 48.461-119.705 32.759-34.386 76.988-51.737 123.58-52.337 68.2-0.877 68.284-106.721 0-105.842C132.605 331.344 9.341 454.607 7.379 607.266 5.417 759.929 135.565 883.225 285.262 885.148c68.284 0.876 68.2-104.965 0-105.841z" fill="#092c4c"></path>
                                <path d="M339.68 384.204a173.762 173.762 0 0 1 172.037-172.038c44.908-0.577 87.822 18.092 119.698 48.462 34.388 32.759 51.743 76.985 52.343 123.576 0.877 68.199 106.72 68.284 105.843 0-1.964-152.653-125.231-275.917-277.884-277.879-152.664-1.962-275.954 128.182-277.878 277.879-0.88 68.284 104.964 68.199 105.841 0z" fill="#092c4c"></path>
                                <path d="M545.039 473.078c16.542 16.542 16.542 43.356 0 59.896l-122.89 122.895c-16.542 16.538-43.357 16.538-59.896 0-16.542-16.546-16.542-43.362 0-59.899l122.892-122.892c16.537-16.542 43.355-16.542 59.894 0z" fill="#F39A2B"></path>
                                <path d="M485.17 473.078c16.537-16.539 43.354-16.539 59.892 0l122.896 122.896c16.538 16.533 16.538 43.354 0 59.896-16.541 16.538-43.361 16.538-59.898 0L485.17 532.979c-16.547-16.543-16.547-43.359 0-59.901z" fill="#F39A2B"></path>
                                <path d="M514.045 634.097c23.972 0 43.402 19.433 43.402 43.399v178.086c0 23.968-19.432 43.398-43.402 43.398-23.964 0-43.396-19.432-43.396-43.398V677.496c0.001-23.968 19.433-43.399 43.396-43.399z" fill="#F39A2B"></path>
                            </svg>

                            <label for="cv" class="inline-block px-4 py-2 text-sm font-medium text-white rounded-md cursor-pointer bg-primary hover:bg-primary/80">
                                <?php echo !empty($cvDoc) ? 'Replace CV' : 'Upload CV'; ?>
                                <input id="cv" name="cv" type="file" class="sr-only" accept=".pdf">
                            </label>
                            <p class="mt-2 text-xs text-gray-500">PDF format only, max 5MB</p>
                        </div>
                    </div>
                </div>


                <div class="flex justify-between">
                    <a href="?page=dashboard" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back to Dashboard
                    </a>
                    <button type="submit" name="submit_step1"
                        class="inline-flex items-center px-6 py-2 text-sm font-medium text-white border border-transparent rounded-md shadow-sm bg-primary hover:bg-blue-700">
                        <?php echo (!empty($resumeDoc) ? 'Update & Continue' : 'Next Step'); ?>
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>