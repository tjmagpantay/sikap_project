<?php
include_once __DIR__ . '/../components/jobseeker_auth_check.php';
include_once __DIR__ . '/../../components/navbar-top.php';
include_once __DIR__ . '/../navbar-jobseeker.php';

// Check if we have parsed data in session
$parsedCertificates = [];
if (isset($_SESSION['parsed_resume_data']['certificates']) && !empty($_SESSION['parsed_resume_data']['certificates'])) {
    $parsedCertificates = $_SESSION['parsed_resume_data']['certificates'];
}
?>

<div class="min-h-screen py-6">
    <div class="sm:mx-auto sm:w-full sm:max-w-2xl">
        <div class="text-center">
            <div class="flex justify-center mb-4">
                <div class="flex items-center justify-center w-12 h-12 rounded-full bg-primary">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
            </div>
            <h2 class="mt-6 text-3xl font-extrabold text-center text-gray-900">
                Certificates & Licenses
            </h2>
            <p class="mt-2 text-sm text-center text-gray-500">
                Add your professional certifications and licenses (Optional)
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
                        <a href="?page=complete-jobseeker-profile&step=1" class="flex items-center justify-center w-8 h-8 text-gray-500 transition-colors bg-gray-200 rounded-full hover:bg-gray-300 hover:text-gray-700">
                            <span class="text-sm font-semibold">1</span>
                        </a>
                        <span class="mt-1 text-xs text-gray-500">Documents</span>
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

                    <!-- Step 6 - Current -->
                    <div class="flex flex-col items-center">
                        <div class="flex items-center justify-center w-8 h-8 text-white rounded-full bg-primary">
                            <span class="text-sm font-semibold">6</span>
                        </div>
                        <span class="mt-1 text-xs text-gray-600">Certificates</span>
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
                    <div class="h-2 rounded bg-primary" style="width: 85.71%"></div>
                </div>
            </div>

            <!-- Display parsed certificates if available -->
            <?php if (!empty($parsedCertificates)): ?>
                <div class="p-4 mb-6 border border-green-200 rounded-lg bg-green-50">
                    <h3 class="mb-2 text-sm font-medium text-green-800">
                        <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Certificates extracted from your resume:
                    </h3>
                    <ul class="space-y-1 list-disc list-inside">
                        <?php foreach ($parsedCertificates as $cert): ?>
                            <li class="text-sm text-green-800"><?php echo htmlspecialchars($cert['certificate_title']); ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <p class="mt-2 text-xs text-green-600">These certificates have been automatically added below. You can edit or add more.</p>
                </div>
            <?php endif; ?>

            <form class="space-y-6" method="POST" action="?page=complete-jobseeker-profile&step=6">
                <div>
                    <label class="block mb-4 text-sm font-medium text-gray-700">Certificates & Licenses</label>
                    <div id="certificates-container">
                        <?php
                        $allCertificates = [];

                        // FIXED: Prioritize existing database certificates over parsed ones to avoid duplication
                        if (!empty($certificates) && $certificates !== false) {
                            // Use existing database certificates (user has already been through this step)
                            foreach ($certificates as $cert) {
                                $allCertificates[] = $cert;
                            }
                        } else {
                            // Only use parsed certificates if no database certificates exist
                            if (!empty($parsedCertificates)) {
                                foreach ($parsedCertificates as $cert) {
                                    $allCertificates[] = $cert;
                                }
                            }
                        }

                        // If no certificates at all, add one empty row
                        if (empty($allCertificates)) {
                            $allCertificates[] = [
                                'certificate_title' => '',
                                'issuing_organization' => '',
                                'date_issued' => ''
                            ];
                        }

                        foreach ($allCertificates as $index => $cert): ?>
                            <div class="p-4 mb-4 space-y-4 border border-gray-200 rounded-lg certificate-row" data-index="<?php echo $index; ?>">

                                <!-- Add hidden field for existing certificate ID -->
                                <?php if (isset($cert['certificate_id'])): ?>
                                    <input type="hidden" name="certificates[<?php echo $index; ?>][certificate_id]" value="<?php echo $cert['certificate_id']; ?>">
                                <?php endif; ?>

                                <!-- Mark for deletion field (hidden) -->
                                <input type="hidden" name="certificates[<?php echo $index; ?>][delete]" value="0" class="delete-flag">

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Certificate/License Name</label>
                                    <input type="text"
                                        name="certificates[<?php echo $index; ?>][certificate_title]"
                                        value="<?php echo htmlspecialchars($cert['certificate_title'] ?? ''); ?>"
                                        placeholder="e.g., AWS Certified Solutions Architect"
                                        class="w-full px-3 py-2 mt-1 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Issuing Organization</label>
                                    <input type="text"
                                        name="certificates[<?php echo $index; ?>][issuing_organization]"
                                        value="<?php echo htmlspecialchars($cert['issuing_organization'] ?? ''); ?>"
                                        placeholder="e.g., Amazon Web Services"
                                        class="w-full px-3 py-2 mt-1 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary">
                                </div>

                                <div class="flex gap-4">
                                    <div class="flex-1">
                                        <label class="block text-sm font-medium text-gray-700">Date Issued</label>
                                        <input type="date"
                                            name="certificates[<?php echo $index; ?>][date_issued]"
                                            value="<?php echo htmlspecialchars($cert['date_issued'] ?? ''); ?>"
                                            class="w-full px-3 py-2 mt-1 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary">
                                    </div>

                                    <div class="flex items-end">
                                        <button type="button"
                                            class="flex items-center justify-center px-3 py-2 text-red-600 transition-colors border border-red-200 rounded-md remove-certificate hover:text-white hover:bg-red-600 hover:border-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
                                            onclick="removeCertificate(this)"
                                            title="Remove this certificate">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <button type="button" id="add-certificate" class="inline-flex items-center px-4 py-2 mt-4 text-sm font-medium border rounded-md text-primary border-primary hover:bg-primary hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Add Another Certificate
                    </button>
                </div>

                <div class="flex justify-between">
                    <a href="?page=complete-jobseeker-profile&step=5"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        Previous
                    </a>
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-white border border-transparent rounded-md shadow-sm bg-primary hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        Next
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let certificateCount = <?php echo count($allCertificates); ?>;
        const addCertificateBtn = document.getElementById('add-certificate');
        const certificatesContainer = document.getElementById('certificates-container');

        function updateIndices() {
            const certificateRows = document.querySelectorAll('.certificate-row:not(.deleted)');
            certificateRows.forEach((row, index) => {
                row.setAttribute('data-index', index);

                // Update all input names within this row
                const inputs = row.querySelectorAll('input');
                inputs.forEach(input => {
                    const name = input.name;
                    if (name) {
                        const newName = name.replace(/certificates\[\d+\]/, `certificates[${index}]`);
                        input.name = newName;
                    }
                });
            });
        }

        function addEmptyCertificateRow() {
            const certificateRow = document.createElement('div');
            certificateRow.className = 'certificate-row space-y-4 p-4 border border-gray-200 rounded-lg mb-4';
            certificateRow.setAttribute('data-index', certificateCount);

            certificateRow.innerHTML = `
            <input type="hidden" name="certificates[${certificateCount}][delete]" value="0" class="delete-flag">
            
            <div>
                <label class="block text-sm font-medium text-gray-700">Certificate/License Name</label>
                <input type="text" 
                       name="certificates[${certificateCount}][certificate_title]" 
                       placeholder="e.g., AWS Certified Solutions Architect" 
                       class="w-full px-3 py-2 mt-1 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700">Issuing Organization</label>
                <input type="text" 
                       name="certificates[${certificateCount}][issuing_organization]" 
                       placeholder="e.g., Amazon Web Services" 
                       class="w-full px-3 py-2 mt-1 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary">
            </div>
            
            <div class="flex gap-4">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700">Date Issued</label>
                    <input type="date" 
                           name="certificates[${certificateCount}][date_issued]" 
                           class="w-full px-3 py-2 mt-1 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary">
                </div>
                
                <div class="flex items-end">
                    <button type="button" 
                            class="flex items-center justify-center px-3 py-2 text-red-600 transition-colors border border-red-200 rounded-md remove-certificate hover:text-white hover:bg-red-600 hover:border-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2" 
                            onclick="removeCertificate(this)"
                            title="Remove this certificate">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        `;

            certificatesContainer.appendChild(certificateRow);
            certificateCount++;
        }

        addCertificateBtn.addEventListener('click', function() {
            addEmptyCertificateRow();
        });

        // Enhanced remove certificate function with better debugging
        window.removeCertificate = function(button) {
            const currentRow = button.closest('.certificate-row');
            const visibleRows = document.querySelectorAll('.certificate-row:not(.deleted)');

            // Check if the row has any data
            const textInputs = currentRow.querySelectorAll('input[type="text"], input[type="date"]');
            const hasData = Array.from(textInputs).some(input => input.value.trim() !== '');

            // Confirm deletion if there's data
            if (hasData && !confirm('Are you sure you want to remove this certificate?')) {
                return;
            }

            // Check if this is an existing certificate (has certificate_id)
            const certificateIdInput = currentRow.querySelector('input[name*="[certificate_id]"]');

            console.log('DEBUG: Certificate ID input:', certificateIdInput);
            console.log('DEBUG: Certificate ID value:', certificateIdInput ? certificateIdInput.value : 'none');

            if (certificateIdInput && certificateIdInput.value) {
                // This is an existing certificate - mark for deletion
                const deleteFlag = currentRow.querySelector('.delete-flag');
                console.log('DEBUG: Delete flag input:', deleteFlag);

                if (deleteFlag) {
                    deleteFlag.value = '1';
                    console.log('DEBUG: Set delete flag to 1 for certificate ID:', certificateIdInput.value);
                }

                // Hide the row visually but keep it in DOM for form submission
                currentRow.style.display = 'none';
                currentRow.classList.add('deleted');

                console.log('DEBUG: Hidden row for existing certificate');
            } else {
                // This is a new certificate - remove from DOM completely
                if (visibleRows.length > 1) {
                    currentRow.remove();
                    updateIndices();
                    console.log('DEBUG: Removed new certificate row from DOM');
                } else {
                    // If it's the last row, just clear the inputs
                    textInputs.forEach(input => input.value = '');
                    console.log('DEBUG: Cleared inputs of last remaining row');
                }
            }
        };

        // Debug form submission
        document.querySelector('form').addEventListener('submit', function(e) {
            console.log('DEBUG: Form submitting...');
            const formData = new FormData(this);
            for (let [key, value] of formData.entries()) {
                if (key.includes('certificates')) {
                    console.log('DEBUG Form data:', key, '=', value);
                }
            }
        });
    });
</script>