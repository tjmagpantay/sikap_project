<div class="grid w-full gap-4 py-4 mb-8 border-t border-gray-200 ">
    <div class="mb-8 ">
        <div class="flex items-center justify-between mb-4">
            <h4 class="text-base font-semibold text-primary">Documents & Resume</h4>
            <a href="?page=complete-jobseeker-profile&step=1"
                class="flex items-center text-sm text-primary hover:text-primary-600">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                </svg>
                Upload New
            </a>
        </div>

        <?php if (!empty($documents) && is_array($documents)): ?>
            <div class="space-y-3">
                <?php foreach ($documents as $doc): ?>
                    <div class="flex items-center justify-between p-4 transition-colors border border-gray-200 rounded-lg bg-gray-50 hover:bg-gray-100">
                        <div class="flex items-center">
                            <div class="flex items-center justify-center w-12 h-12 mr-3 overflow-hidden bg-red-100 rounded-lg">
                                <?php if (strpos($doc['file_type'] ?? '', 'pdf') !== false): ?>
                                    <img
                                        src="../public/assets/icons/pdf-icon.png"
                                        alt="Icon"
                                        class="object-cover w-8 h-8" />
                                <?php elseif (strpos($doc['file_type'] ?? '', 'word') !== false): ?>
                                    <img
                                        src="../public/assets/icons/pdf-icon.png"
                                        alt="Icon"
                                        class="object-cover w-8 h-8" />
                                <?php else: ?>
                                    <img
                                        src="../public/assets/icons/pdf-icon.png"
                                        alt="Icon"
                                        class="object-cover w-8 h-8" />
                                <?php endif; ?>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-900">
                                    <?php echo htmlspecialchars($doc['file_name'] ?? 'N/A'); ?>
                                </div>
                                <div class="text-xs text-gray-500 capitalize">
                                    <?php echo htmlspecialchars($doc['file_type'] ?? 'N/A'); ?>
                                    • Uploaded: <?php echo !empty($doc['uploaded_at']) ? date('M d, Y', strtotime($doc['uploaded_at'])) : 'N/A'; ?>
                                </div>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <a href="?page=download-document&doc_id=<?php echo htmlspecialchars($doc['document_id'] ?? '#'); ?>" target="_blank"
                                class="flex items-center px-3 py-2 text-sm font-medium transition-colors rounded-lg text-primary bg-blue-50 hover:bg-blue-100">
                                <i class="mr-2 fas fa-eye"></i>
                                View
                            </a>
                            <a href="?page=download-document&doc_id=<?php echo htmlspecialchars($doc['document_id'] ?? '#'); ?>&download=1"
                                class="flex items-center px-3 py-2 text-sm font-medium transition-colors rounded-lg text-primary bg-blue-50 hover:bg-blue-100">
                                <i class="mr-2 fas fa-download"></i>
                                Download
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="py-12 text-center border border-gray-200 rounded-lg bg-gray-50">
                <svg class="w-16 h-16 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path>
                </svg>
                <h5 class="mb-2 text-lg font-medium text-gray-900">No Documents Uploaded</h5>
                <p class="mb-6 text-sm text-gray-500">Upload your resume, CV, and other important documents to complete your profile.</p>
                <a href="?page=complete-jobseeker-profile&step=1"
                    class="inline-flex items-center px-6 py-3 text-sm font-medium text-white rounded-md bg-primary hover:bg-primary-600">
                    <i class="mr-2 fas fa-upload"></i>
                    Upload Resume/CV
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>