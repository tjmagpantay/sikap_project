<?php include_once __DIR__ . '/../../components/navbar-top.php';
include_once __DIR__ . '/../navbar-jobseeker.php'; ?>

<div class="min-h-screen py-6">
    <div class="sm:mx-auto sm:w-full sm:max-w-2xl">
        <div class="text-center">
            <div class="flex justify-center mb-4">
                <div class="flex items-center justify-center w-12 h-12 rounded-full bg-primary">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>
            <h2 class="mt-6 text-3xl font-extrabold text-center text-gray-900">
                Upload Your Documents
            </h2>
            <p class="mt-2 text-sm text-center text-gray-600">
                Step 1/5 - Resume and CV
            </p>
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
                        <span class="mt-1 text-xs text-gray-500">Employment</span>
                    </div>

                    <!-- Step 4 -->
                    <div class="flex flex-col items-center">
                        <a href="?page=complete-jobseeker-profile&step=4" class="flex items-center justify-center w-8 h-8 text-gray-500 transition-colors bg-gray-200 rounded-full hover:bg-gray-300 hover:text-gray-700">
                            <span class="text-sm font-semibold">4</span>
                        </a>
                        <span class="mt-1 text-xs text-gray-500">Education</span>
                    </div>

                    <!-- Step 5 -->
                    <div class="flex flex-col items-center">
                        <a href="?page=complete-jobseeker-profile&step=5" class="flex items-center justify-center w-8 h-8 text-gray-500 transition-colors bg-gray-200 rounded-full hover:bg-gray-300 hover:text-gray-700">
                            <span class="text-sm font-semibold">5</span>
                        </a>
                        <span class="mt-1 text-xs text-gray-500">Experience</span>
                    </div>

                    <!-- Step 6 -->
                    <div class="flex flex-col items-center">
                        <a href="?page=complete-jobseeker-profile&step=6" class="flex items-center justify-center w-8 h-8 text-gray-500 transition-colors bg-gray-200 rounded-full hover:bg-gray-300 hover:text-gray-700">
                            <span class="text-sm font-semibold">6</span>
                        </a>
                        <span class="mt-1 text-xs text-gray-500">Skills</span>
                    </div>

                    <!-- Step 7 -->
                    <div class="flex flex-col items-center">
                        <a href="?page=complete-jobseeker-profile&step=7" class="flex items-center justify-center w-8 h-8 text-gray-500 transition-colors bg-gray-200 rounded-full hover:bg-gray-300 hover:text-gray-700">
                            <span class="text-sm font-semibold">7</span>
                        </a>
                        <span class="mt-1 text-xs text-gray-500">Portfolio</span>
                    </div>

                    <!-- Step 8 -->
                    <div class="flex flex-col items-center">
                        <a href="?page=complete-jobseeker-profile&step=8" class="flex items-center justify-center w-8 h-8 text-gray-500 transition-colors bg-gray-200 rounded-full hover:bg-gray-300 hover:text-gray-700">
                            <span class="text-sm font-semibold">8</span>
                        </a>
                        <span class="mt-1 text-xs text-gray-500">Review</span>
                    </div>
                </div>

                <!-- Progress bar -->
                <div class="w-full h-2 bg-gray-200 rounded">
                    <div class="h-2 rounded bg-primary" style="width: 12.5%"></div>
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

                    <div class="grid grid-cols-2 gap-4 mt-2 mb-6 bg-gray-100 rounded-md">
                        <!-- Left Column - Current Resume Display -->
                        <div class="flex items-center justify-center">
                            <?php if (!empty($resumeDoc)): ?>
                                <div class="text-center">
                                    <div class="flex items-center justify-center w-16 h-16 mx-auto bg-red-100 rounded-md">
                                        <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">Current resume</p>
                                </div>
                            <?php else: ?>
                                <div class="flex items-center justify-center w-16 h-16 border-2 border-gray-300 border-dashed rounded-md">
                                    <svg class="w-6 h-6 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                        <path d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                    </svg>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Right Column - Upload/Edit Function -->
                        <div class="flex flex-col justify-center">
                            <div class="flex justify-center px-4 py-3 transition-colors border-2 border-gray-300 border-dashed rounded-md hover:border-gray-400">
                                <div class="text-center">
                                    <svg class="w-6 h-6 mx-auto mb-2 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                        <path d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="resume" class="relative font-medium bg-white rounded-md cursor-pointer text-primary hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-primary">
                                            <span><?php echo !empty($resumeDoc) ? 'Replace resume' : 'Upload resume'; ?></span>
                                            <input id="resume" name="resume" type="file" class="sr-only" accept=".pdf">
                                        </label>
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">PDF up to 5MB</p>
                                </div>
                            </div>
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

                    <div class="grid grid-cols-2 gap-4 mt-2 mb-6 bg-gray-100 rounded-md">
                        <!-- Left Column - Current CV Display -->
                        <div class="flex items-center justify-center">
                            <?php if (!empty($cvDoc)): ?>
                                <div class="text-center">
                                    <div class="flex items-center justify-center w-16 h-16 mx-auto bg-red-100 rounded-md">
                                        <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">Current CV</p>
                                </div>
                            <?php else: ?>
                                <div class="flex items-center justify-center w-16 h-16 border-2 border-gray-300 border-dashed rounded-md">
                                    <svg class="w-6 h-6 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                        <path d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                    </svg>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Right Column - Upload/Edit Function -->
                        <div class="flex flex-col justify-center">
                            <div class="flex justify-center px-4 py-3 transition-colors border-2 border-gray-300 border-dashed rounded-md hover:border-gray-400">
                                <div class="text-center">
                                    <svg class="w-6 h-6 mx-auto mb-2 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                        <path d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="cv" class="relative font-medium bg-white rounded-md cursor-pointer text-primary hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-primary">
                                            <span><?php echo !empty($cvDoc) ? 'Replace CV' : 'Upload CV'; ?></span>
                                            <input id="cv" name="cv" type="file" class="sr-only" accept=".pdf">
                                        </label>
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">PDF up to 5MB</p>
                                </div>
                            </div>
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