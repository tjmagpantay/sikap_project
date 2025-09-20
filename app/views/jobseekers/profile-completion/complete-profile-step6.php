<?php
include_once __DIR__ . '/../components/jobseeker_auth_check.php';
include_once __DIR__ . '/../../components/navbar-top.php';
include_once __DIR__ . '/../components/navbar-jobseeker.php';

// Display success/error messages from session
if (isset($_SESSION['success_message'])) {
    $success = $_SESSION['success_message'];
    unset($_SESSION['success_message']);
}
if (isset($_SESSION['error_message'])) {
    $error = $_SESSION['error_message'];
    unset($_SESSION['error_message']);
}

// Check if we have parsed data in session
$parsedCertificates = [];
if (isset($_SESSION['parsed_resume_data']['certificates']) && !empty($_SESSION['parsed_resume_data']['certificates'])) {
    $parsedCertificates = $_SESSION['parsed_resume_data']['certificates'];
}
?>

<div class="min-h-screen py-6">
    <div class="sm:mx-auto sm:w-full sm:max-w-2xl">
        <div class="text-center">
            <h2 class="mt-2 text-3xl font-extrabold text-center text-grayMain">
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

            <!-- Success/Error Messages -->
            <?php if (!empty($success)): ?>
                <div class="p-4 mb-4 border border-blue-400 rounded-md bg-blue-50">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-primary"><?php echo htmlspecialchars($success); ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (!empty($error)): ?>
                <div class="p-4 mb-4 border border-red-200 rounded-md bg-red-50">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-600"><?php echo htmlspecialchars($error); ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Display existing certificates if available -->
            <?php if (!empty($certificates) && is_array($certificates) && count($certificates) > 0): ?>
                <div class="p-6 mb-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                    <h3 class="mb-4 font-medium text-grayMain text-md">Your Current Certificates</h3>
                    <div class="space-y-2">
                        <?php foreach ($certificates as $cert): ?>
                            <div class="flex items-center justify-between p-3 rounded-lg bg-gray-50">
                                <div>
                                    <h4 class="text-sm font-medium text-primary"><?php echo htmlspecialchars($cert['certificate_title']); ?></h4>
                                    <p class="text-sm text-gray-600"><?php echo htmlspecialchars($cert['issuing_organization']); ?></p>
                                    <p class="text-xs text-gray-500"><?php echo date('M Y', strtotime($cert['date_issued'])); ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

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
                            <li class="text-sm text-green-800">
                                <?php
                                // Handle different possible key structures
                                $certTitle = '';
                                if (isset($cert['certificate_title'])) {
                                    $certTitle = $cert['certificate_title'];
                                } elseif (isset($cert['certificate_name'])) {
                                    $certTitle = $cert['certificate_name'];
                                } elseif (isset($cert['name'])) {
                                    $certTitle = $cert['name'];
                                } elseif (is_string($cert)) {
                                    $certTitle = $cert;
                                } else {
                                    $certTitle = 'Certificate'; // Fallback
                                }
                                echo htmlspecialchars($certTitle);
                                ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <p class="mt-2 text-xs text-green-600">These certificates have been automatically added below. You can edit or add more.</p>
                </div>
            <?php endif; ?>

            <form class="space-y-6" method="POST" action="?page=complete-jobseeker-profile&step=6" id="certificatesForm">
                <div>

                    <div id="certificates-container">
                        <?php
                        $allCertificates = [];

                        // Prioritize existing database certificates over parsed ones to avoid duplication
                        if (!empty($certificates) && $certificates !== false) {
                            // Use existing database certificates (user has already been through this step)
                            foreach ($certificates as $cert) {
                                $allCertificates[] = $cert;
                            }
                        } else {
                            // Only use parsed certificates if no database certificates exist
                            if (!empty($parsedCertificates)) {
                                foreach ($parsedCertificates as $cert) {
                                    // Normalize the certificate data structure
                                    $normalizedCert = [
                                        'certificate_title' => '',
                                        'issuing_organization' => '',
                                        'date_issued' => ''
                                    ];

                                    // Handle different possible structures
                                    if (is_array($cert)) {
                                        if (isset($cert['certificate_title'])) {
                                            $normalizedCert['certificate_title'] = $cert['certificate_title'];
                                        } elseif (isset($cert['certificate_name'])) {
                                            $normalizedCert['certificate_title'] = $cert['certificate_name'];
                                        } elseif (isset($cert['name'])) {
                                            $normalizedCert['certificate_title'] = $cert['name'];
                                        }

                                        if (isset($cert['issuing_organization'])) {
                                            $normalizedCert['issuing_organization'] = $cert['issuing_organization'];
                                        } elseif (isset($cert['organization'])) {
                                            $normalizedCert['issuing_organization'] = $cert['organization'];
                                        } elseif (isset($cert['issuer'])) {
                                            $normalizedCert['issuing_organization'] = $cert['issuer'];
                                        }

                                        if (isset($cert['date_issued'])) {
                                            $normalizedCert['date_issued'] = $cert['date_issued'];
                                        } elseif (isset($cert['issue_date'])) {
                                            $normalizedCert['date_issued'] = $cert['issue_date'];
                                        } elseif (isset($cert['date'])) {
                                            $normalizedCert['date_issued'] = $cert['date'];
                                        }
                                    } elseif (is_string($cert)) {
                                        // If it's just a string, use it as the certificate title
                                        $normalizedCert['certificate_title'] = $cert;
                                    }

                                    $allCertificates[] = $normalizedCert;
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
                            <div class="mb-4 space-y-4 certificate-row" data-index="<?php echo $index; ?>">

                                <!-- Add hidden field for existing certificate ID -->
                                <?php if (isset($cert['certificate_id'])): ?>
                                    <input type="hidden" name="certificates[<?php echo $index; ?>][certificate_id]" value="<?php echo $cert['certificate_id']; ?>">
                                <?php endif; ?>

                                <!-- Mark for deletion field (hidden) -->
                                <input type="hidden" name="certificates[<?php echo $index; ?>][delete]" value="0" class="delete-flag">

                                <div>
                                    <label class="block text-xs font-medium text-gray-500">Certificate/License Name</label>
                                    <input type="text"
                                        name="certificates[<?php echo $index; ?>][certificate_title]"
                                        value="<?php echo htmlspecialchars($cert['certificate_title'] ?? ''); ?>"
                                        placeholder="e.g., AWS Certified Solutions Architect"
                                        class="w-full px-3 py-2 mt-1 text-sm text-gray-600 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary">
                                </div>

                                <div>
                                    <label class="block text-xs font-medium text-gray-500">Issuing Organization</label>
                                    <input type="text"
                                        name="certificates[<?php echo $index; ?>][issuing_organization]"
                                        value="<?php echo htmlspecialchars($cert['issuing_organization'] ?? ''); ?>"
                                        placeholder="e.g., Amazon Web Services"
                                        class="w-full px-3 py-2 mt-1 text-sm text-gray-600 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary">
                                </div>

                                <div class="flex gap-4">
                                    <div class="flex-1">
                                        <label class="block text-xs font-medium text-gray-500">Date Issued</label>
                                        <input type="date"
                                            name="certificates[<?php echo $index; ?>][date_issued]"
                                            value="<?php echo htmlspecialchars($cert['date_issued'] ?? ''); ?>"
                                            class="w-full px-3 py-2 mt-1 text-sm text-gray-600 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary">
                                    </div>

                                    <div class="flex items-end">
                                        <!-- Fixed Delete Button for ALL certificates -->
                                        <button type="button"
                                            class="flex items-center justify-center px-3 py-2 text-red-600 transition-colors border border-red-200 rounded-md hover:text-white hover:bg-red-600 hover:border-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
                                            onclick="deleteCertificate(this, <?php echo isset($cert['certificate_id']) ? $cert['certificate_id'] : 'null'; ?>)"
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

                <!-- Multiple Button Layout - Fixed to 1 Row -->
                <div class="flex items-center justify-between">
                    <!-- Left Side - Previous Button -->
                    <div>
                        <a href="?page=complete-jobseeker-profile&step=5"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Previous Step
                        </a>
                    </div>

                    <!-- Right Side - Action Buttons -->
                    <div class="flex gap-2">
                        <!-- Save Certificates Button -->
                        <button type="submit" name="save_certificates"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                            Save Certificates
                        </button>

                        <!-- Skip & Continue Button -->
                        <button type="submit" name="submit_step6"
                            class="inline-flex items-center px-6 py-2 text-sm font-medium text-white border border-transparent rounded-md shadow-sm bg-primary hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                            <span>Skip & Continue</span>
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
                       class="w-full px-3 py-2 mt-1 text-sm text-gray-600 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700">Issuing Organization</label>
                <input type="text" 
                       name="certificates[${certificateCount}][issuing_organization]" 
                       placeholder="e.g., Amazon Web Services" 
                       class="w-full px-3 py-2 mt-1 text-sm text-gray-600 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary">
            </div>
            
            <div class="flex gap-4">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700">Date Issued</label>
                    <input type="date" 
                           name="certificates[${certificateCount}][date_issued]" 
                           class="w-full px-3 py-2 mt-1 text-sm text-gray-600 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary">
                </div>
                
                <div class="flex items-end">
                    <button type="button" 
                            class="flex items-center justify-center px-3 py-2 text-red-600 transition-colors border border-red-200 rounded-md hover:text-white hover:bg-red-600 hover:border-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2" 
                            onclick="deleteCertificate(this, null)"
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

        // Add certificate button event listener
        if (addCertificateBtn) {
            addCertificateBtn.addEventListener('click', function(e) {
                e.preventDefault();
                addEmptyCertificateRow();
            });
        }

        // Global delete certificate function
        window.deleteCertificate = function(button, certificateId) {
            const currentRow = button.closest('.certificate-row');
            const visibleRows = document.querySelectorAll('.certificate-row:not(.deleted)');

            // Check if the row has any data
            const textInputs = currentRow.querySelectorAll('input[type="text"], input[type="date"]');
            const hasData = Array.from(textInputs).some(input => input.value.trim() !== '');

            // Confirm deletion if there's data
            if (hasData && !confirm('Are you sure you want to remove this certificate?')) {
                return;
            }

            if (certificateId && certificateId !== 'null') {
                // This is an existing certificate - use simple delete form approach
                if (confirm('Are you sure you want to delete this certificate permanently?')) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '?page=delete-certificate-simple';
                    form.style.display = 'none';

                    const certificateIdInput = document.createElement('input');
                    certificateIdInput.type = 'hidden';
                    certificateIdInput.name = 'certificate_id';
                    certificateIdInput.value = certificateId;

                    form.appendChild(certificateIdInput);
                    document.body.appendChild(form);
                    form.submit();
                }
            } else {
                // This is a new certificate - remove from DOM completely
                if (visibleRows.length > 1) {
                    currentRow.remove();
                    updateIndices();
                } else {
                    // If it's the last row, just clear the inputs
                    textInputs.forEach(input => input.value = '');
                }
            }
        };

        // Form validation before submission
        const form = document.getElementById('certificatesForm');
        if (form) {
            form.addEventListener('submit', function(e) {
                if (e.submitter && e.submitter.name === 'save_certificates') {
                    // Check if at least one certificate has a title
                    const certificateTitles = form.querySelectorAll('input[name*="[certificate_title]"]');
                    const hasValidCertificate = Array.from(certificateTitles).some(input => input.value.trim() !== '');

                    if (!hasValidCertificate) {
                        e.preventDefault();
                        alert('Please fill in at least one certificate title to save.');
                        return false;
                    }
                }
            });
        }
    });
</script>