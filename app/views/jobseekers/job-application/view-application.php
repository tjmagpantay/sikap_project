<?php
include_once __DIR__ . '/../components/jobseeker_auth_check.php';
include_once __DIR__ . '/../../components/navbar-top.php';
include_once __DIR__ . '/../navbar-jobseeker.php';

// Fix: Define currentStatus variable
$currentStatus = $application['application_status'] ?? 'pending';
?>

<div class="min-h-screen">
    <div class="px-6 py-8">
        <div class="mx-auto max-w-7xl">

            <!-- Breadcrumbs -->
            <nav class="mb-6">
                <div class="flex items-center space-x-2 text-sm">
                    <a href="?page=jobseeker-dashboard" class="text-gray-500 transition-colors hover:text-primary">
                        Dashboard
                    </a>
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    <a href="?page=my-applications" class="text-gray-500 transition-colors hover:text-primary">
                        My Applications
                    </a>
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    <span class="font-medium text-primary">Application #<?php echo str_pad($application['application_id'], 6, '0', STR_PAD_LEFT); ?></span>
                </div>
            </nav>

            <!-- Main Flex Layout -->
            <div class="flex flex-col gap-6 lg:flex-row lg:gap-8">

                <!-- Left Section - Main Content -->
                <div class="w-full space-y-6 lg:w-8/12">

                    <!-- Job Details Card -->
                    <div class="overflow-hidden bg-white border border-gray-200 shadow-sm rounded-xl">

                        <!-- Job Header -->
                        <div class="p-4 border-b border-gray-200 sm:p-6 bg-gray-50">
                            <div class="flex items-start justify-between ">
                                <div class="flex items-start gap-3 sm:gap-4">
                                    <!-- Company Logo -->
                                    <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 overflow-hidden border-2 border-gray-200 rounded-lg sm:w-16 sm:h-16">
                                        <?php if (!empty($application['business_logo'])): ?>
                                            <img src="<?php echo htmlspecialchars($application['business_logo']); ?>" alt="Company Logo"
                                                class="object-cover w-full h-full">
                                        <?php else: ?>
                                            <i class="text-xl text-gray-500 sm:text-2xl fas fa-building"></i>
                                        <?php endif; ?>
                                    </div>

                                    <div>
                                        <h1 class="text-lg font-semibold text-gray-900 sm:text-xl"><?php echo htmlspecialchars($application['job_title']); ?></h1>
                                        <a href="?page=view-employer-profile&employer_id=<?php echo $application['employer_id'] ?? ''; ?>"
                                            class="mt-1 text-sm transition-colors text-primary hover:text-secondary hover:underline">
                                            <?php echo htmlspecialchars($application['company_name'] ?? 'Company'); ?>
                                        </a>


                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>

                    <!-- Submitted Documents -->
                    <?php if (!empty($attachments)): ?>
                        <div class="overflow-hidden bg-white border border-gray-200 shadow-sm rounded-xl">
                            <div class="p-4 border-b border-gray-200 sm:p-6 bg-gray-50">
                                <h2 class="flex items-center text-lg font-semibold text-primary">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    Submitted Documents
                                </h2>
                                <p class="mt-1 text-xs text-gray-600">Documents attached to your application</p>
                            </div>
                            <div class="p-4 sm:p-6">
                                <div class="space-y-3">
                                    <?php
                                    // Separate documents by type
                                    $resumeAttachments = [];
                                    $cvAttachments = [];
                                    $otherAttachments = [];

                                    foreach ($attachments as $attachment) {
                                        if (strtolower($attachment['file_type']) === 'resume') {
                                            $resumeAttachments[] = $attachment;
                                        } elseif (strtolower($attachment['file_type']) === 'cv') {
                                            $cvAttachments[] = $attachment;
                                        } else {
                                            $otherAttachments[] = $attachment;
                                        }
                                    }

                                    // Show CV documents
                                    foreach ($cvAttachments as $cvAttachment): ?>
                                        <div class="flex items-center justify-between p-4 transition-colors border border-gray-200 rounded-lg bg-gray-50 hover:bg-gray-100">
                                            <div class="flex items-center gap-3">
                                                <div class="flex items-center justify-center w-12 h-12 bg-blue-100 rounded-lg">
                                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                    </svg>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900">CV (Curriculum Vitae)</p>
                                                    <p class="text-xs text-gray-500">Uploaded <?php echo date('M j, Y', strtotime($cvAttachment['uploaded_at'])); ?></p>
                                                </div>
                                            </div>
                                            <a href="../<?php echo htmlspecialchars($cvAttachment['file_path']); ?>" target="_blank"
                                                class="flex items-center px-3 py-2 text-sm font-medium transition-colors rounded-lg text-primary bg-blue-50 hover:bg-blue-100">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                View
                                            </a>
                                        </div>
                                    <?php endforeach;

                                    // Show Resume documents
                                    foreach ($resumeAttachments as $resumeAttachment): ?>
                                        <div class="flex items-center justify-between p-4 transition-colors border border-gray-200 rounded-lg bg-gray-50 hover:bg-gray-100">
                                            <div class="flex items-center gap-3">
                                                <div class="flex items-center justify-center w-12 h-12 bg-green-100 rounded-lg">
                                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                    </svg>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900">Resume</p>
                                                    <p class="text-xs text-gray-500">Uploaded <?php echo date('M j, Y', strtotime($resumeAttachment['uploaded_at'])); ?></p>
                                                </div>
                                            </div>
                                            <a href="../<?php echo htmlspecialchars($resumeAttachment['file_path']); ?>" target="_blank"
                                                class="flex items-center px-3 py-2 text-sm font-medium transition-colors rounded-lg text-primary bg-blue-50 hover:bg-blue-100">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                View
                                            </a>
                                        </div>
                                    <?php endforeach;

                                    // Show other attachments
                                    foreach ($otherAttachments as $attachment): ?>
                                        <div class="flex items-center justify-between p-4 transition-colors border border-gray-200 rounded-lg bg-gray-50 hover:bg-gray-100">
                                            <div class="flex items-center space-x-3">
                                                <div class="flex items-center justify-center w-12 h-12 bg-purple-100 rounded-lg">
                                                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                                    </svg>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($attachment['file_type']); ?></p>
                                                    <p class="text-xs text-gray-500">Uploaded <?php echo date('M j, Y', strtotime($attachment['uploaded_at'])); ?></p>
                                                </div>
                                            </div>
                                            <a href="../<?php echo htmlspecialchars($attachment['file_path']); ?>" target="_blank"
                                                class="flex items-center px-3 py-2 text-sm font-medium transition-colors rounded-lg text-primary bg-blue-50 hover:bg-blue-100">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                View
                                            </a>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Screening Answers -->
                    <div class="overflow-hidden bg-white border border-gray-200 shadow-sm rounded-xl">
                        <div class="p-4 border-b border-gray-200 sm:p-6 bg-gray-50">
                            <h2 class="flex items-center text-lg font-semibold text-primary">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Screening Questions
                            </h2>
                            <p class="mt-1 text-xs text-gray-600">Your responses to employer's screening questions</p>
                        </div>
                        <div class="p-4 sm:p-6">
                            <?php if (!empty($answers)): ?>
                                <div class="space-y-6">
                                    <?php foreach ($answers as $answer): ?>
                                        <div class="p-4 border border-gray-200 rounded-lg bg-gray-50">
                                            <h3 class="mb-2 text-sm font-medium text-gray-900">
                                                <?php echo htmlspecialchars($answer['question_text']); ?>
                                            </h3>
                                            <div class="p-3 bg-white border border-gray-200 rounded-md">
                                                <p class="text-sm text-gray-700"><?php echo nl2br(htmlspecialchars($answer['answer'])); ?></p>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <div class="py-8 text-center">
                                    <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">No Screening Questions</h3>
                                    <p class="mt-1 text-xs text-gray-500">This job posting did not require screening questions.</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Eligibility Information -->
                    <div class="overflow-hidden bg-white border border-gray-200 shadow-sm rounded-xl">
                        <div class="p-4 border-b border-gray-200 sm:p-6 bg-gray-50">
                            <h2 class="flex items-center text-lg font-semibold text-primary">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                </svg>
                                Eligibility Information
                            </h2>
                            <p class="mt-1 text-sm text-gray-600">Your eligibility details and program interests</p>
                        </div>
                        <div class="p-4 sm:p-6">
                            <?php if (!empty($eligibility)): ?>
                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                    <div class="p-4 border border-gray-200 rounded-lg bg-gray-50">
                                        <h3 class="mb-2 text-sm font-medium text-gray-900">Interested Program</h3>
                                        <p class="text-sm text-gray-700">
                                            <?php echo htmlspecialchars($eligibility['interested_program'] ?? 'Not specified'); ?>
                                        </p>
                                    </div>
                                    <div class="p-4 border border-gray-200 rounded-lg bg-gray-50">
                                        <h3 class="mb-2 text-sm font-medium text-gray-900">Priority Sector</h3>
                                        <p class="text-sm text-gray-700">
                                            <?php echo htmlspecialchars($eligibility['priority_sector'] ?? 'Not specified'); ?>
                                        </p>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="py-8 text-center">
                                    <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">No Eligibility Information</h3>
                                    <p class="mt-1 text-sm text-gray-500">No eligibility information was provided for this application.</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Right Section - Sidebar -->
                <div class="w-full lg:w-4/12">
                    <!-- Single Sidebar Card -->
                    <div class="p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-6">

                        <!-- Application Status -->
                        <div class="mb-6 sm:mb-8">
                            <h3 class="mb-4 text-lg font-semibold text-gray-900 sm:text-xl">Application Status</h3>

                            <!-- Status Display -->
                            <?php if (!$application['is_finalized']): ?>
                                <!-- Incomplete Application Status -->
                                <div class="p-4 mb-4 border border-orange-200 rounded-lg bg-orange-50">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="flex items-center justify-center w-10 h-10 mr-3 bg-orange-500 rounded-full">
                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-orange-700">In Progress</p>
                                                <p class="text-xs text-orange-600">
                                                    Step <?php echo $application['current_step']; ?> of 4 completed
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php else: ?>
                                <!-- Complete Application Status -->
                                <div class="p-4 mb-4 border rounded-lg border-primary bg-blue-50">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="flex items-center justify-center w-10 h-10 mr-3 rounded-full bg-primary">
                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <?php if ($application['application_status'] === 'hired'): ?>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                                    <?php elseif ($application['application_status'] === 'rejected'): ?>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    <?php else: ?>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    <?php endif; ?>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-primary"><?php echo ucfirst($application['application_status']); ?></p>
                                                <p class="text-xs text-primary">
                                                    <?php
                                                    switch ($application['application_status']) {
                                                        case 'pending':
                                                            echo 'Under review';
                                                            break;
                                                        case 'reviewed':
                                                            echo 'Application reviewed';
                                                            break;
                                                        case 'shortlisted':
                                                            echo 'You\'re shortlisted!';
                                                            break;
                                                        case 'rejected':
                                                            echo 'Application not selected';
                                                            break;
                                                        case 'hired':
                                                            echo 'Congratulations!';
                                                            break;
                                                        case 'resigned':
                                                            echo 'Employee has resigned from the position';
                                                            break;
                                                        default:
                                                            echo 'Status unknown';
                                                    }
                                                    ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Action Buttons -->
                            <div class="flex flex-col gap-3">
                                <?php if (!$application['is_finalized']): ?>
                                    <a href="?page=apply-job&job_id=<?php echo $application['job_id']; ?>&application_id=<?php echo $application['application_id']; ?>&step=<?php echo $application['current_step']; ?>"
                                        class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white border border-transparent rounded-md shadow-sm bg-primary hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5-5 5M6 12h12" />
                                        </svg>
                                        Continue Application
                                    </a>
                                <?php endif; ?>

                                <?php if ($resignationRequest && $resignationRequest['request_status'] === 'pending'): ?>
                                    <!-- Pending Resignation Request -->
                                    <div class="p-4 border border-orange-200 rounded-lg bg-orange-50">
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <div>
                                                <p class="text-sm font-medium text-orange-800">Resignation Request Pending</p>
                                                <p class="text-xs text-orange-600">Waiting for employer approval</p>
                                                <p class="mt-1 text-xs text-orange-500">
                                                    Submitted: <?php echo date('M j, Y g:i A', strtotime($resignationRequest['requested_at'])); ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                <?php elseif ($resignationRequest && $resignationRequest['request_status'] === 'approved'): ?>
                                    <!-- Approved Resignation Request -->
                                    <div class="p-4 border border-green-200 rounded-lg bg-green-50">
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            <div>
                                                <p class="text-sm font-medium text-green-800">Resignation Approved</p>
                                                <p class="text-xs text-green-600">Your resignation has been approved by the employer</p>
                                                <p class="mt-1 text-xs text-green-500">
                                                    Approved: <?php echo date('M j, Y g:i A', strtotime($resignationRequest['reviewed_at'])); ?>
                                                </p>
                                                <?php if (!empty($resignationRequest['employer_notes'])): ?>
                                                    <p class="mt-1 text-xs text-green-600">
                                                        <strong>Notes:</strong> <?php echo htmlspecialchars($resignationRequest['employer_notes']); ?>
                                                    </p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php elseif ($resignationRequest && $resignationRequest['request_status'] === 'rejected'): ?>
                                    <!-- Rejected Resignation Request -->
                                    <div class="p-4 border border-red-200 rounded-lg bg-red-50">
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                            <div>
                                                <p class="text-sm font-medium text-red-800">Resignation Request Rejected</p>
                                                <p class="text-xs text-red-600">Your resignation request was not approved</p>
                                                <p class="mt-1 text-xs text-red-500">
                                                    Rejected: <?php echo date('M j, Y g:i A', strtotime($resignationRequest['reviewed_at'])); ?>
                                                </p>
                                                <?php if (!empty($resignationRequest['employer_notes'])): ?>
                                                    <p class="mt-1 text-xs text-red-600">
                                                        <strong>Reason:</strong> <?php echo htmlspecialchars($resignationRequest['employer_notes']); ?>
                                                    </p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Allow resubmission -->
                                    <a href="?page=resign-from-job&id=<?php echo $application['application_id']; ?>"
                                        class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-orange-600 border border-transparent rounded-md hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        Submit New Resignation Request
                                    </a>
                                <?php elseif ($application['application_status'] === 'hired' && !$resignationRequest): ?>
                                    <!-- Can submit resignation request -->
                                    <a href="?page=resign-from-job&id=<?php echo $application['application_id']; ?>"
                                        class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-orange-600 border border-transparent rounded-md hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        Request Resignation
                                    </a>
                                <?php elseif ($application['application_status'] === 'pending'): ?>
                                    <button onclick="withdrawApplication()"
                                        class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-red-600 transition-colors border border-red-200 rounded-lg bg-red-50 hover:bg-red-100">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Withdraw Application
                                    </button>
                                <?php endif; ?>

                                <?php if ($application['application_status'] === 'resigned'): ?>
                                    <div class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-orange-700 border border-orange-200 rounded-lg bg-orange-50">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        Employment Ended
                                    </div>
                                <?php endif; ?>
                            </div>

                        </div>

                        <!-- Enhanced Application Timeline -->
                        <div class="mb-6 sm:mb-8">
                            <h3 class="mb-4 text-lg font-semibold text-gray-900">Application Timeline</h3>

                            <!-- Timeline Container with Connecting Lines -->
                            <div class="relative">
                                <!-- Vertical connecting line -->
                                <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-gray-300"></div>

                                <!-- Timeline Events -->
                                <div class="relative space-y-6">

                                    <?php if (!$application['is_finalized']): ?>
                                        <!-- For Incomplete Applications - Show "Application in Progress" -->
                                        <div class="flex items-start">
                                            <div class="relative z-10 flex items-center justify-center w-8 h-8 bg-orange-500 border-4 border-white rounded-full shadow-sm">
                                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                            <div class="flex-1 min-w-0 ml-4">
                                                <div class="flex items-center justify-between gap-3">
                                                    <p class="text-sm font-semibold text-gray-900">Application in Progress</p>
                                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-700 border border-orange-200">
                                                        Step <?php echo $application['current_step']; ?> of 4
                                                    </span>
                                                </div>
                                                <p class="mt-1 text-xs text-gray-500">
                                                    Complete your application to submit it for review.
                                                    Started: <?php echo date('M j, Y g:i A', strtotime($application['applied_at'])); ?>
                                                </p>
                                                <div class="mt-2">
                                                    <a href="?page=apply-job&job_id=<?php echo $application['job_id']; ?>&application_id=<?php echo $application['application_id']; ?>&step=<?php echo $application['current_step']; ?>"
                                                        class="inline-flex items-center px-3 py-1 text-xs font-medium text-white bg-orange-500 rounded-md hover:bg-orange-600">
                                                        <i class="mr-1 fas fa-arrow-right"></i>
                                                        Continue Application
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Show next steps as pending for incomplete applications -->
                                        <div class="flex items-start">
                                            <div class="relative z-10 flex items-center justify-center w-8 h-8 bg-gray-300 border-4 border-white rounded-full shadow-sm">
                                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </div>
                                            <div class="flex-1 min-w-0 ml-4">
                                                <div class="flex items-center justify-between gap-3">
                                                    <p class="text-sm font-semibold text-gray-900">Application Review</p>
                                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                                        Pending Submission
                                                    </span>
                                                </div>
                                                <p class="mt-1 text-xs text-gray-500">
                                                    Application will be reviewed after submission is complete.
                                                </p>
                                            </div>
                                        </div>

                                        <div class="flex items-start">
                                            <div class="relative z-10 flex items-center justify-center w-8 h-8 bg-gray-300 border-4 border-white rounded-full shadow-sm">
                                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                                </svg>
                                            </div>
                                            <div class="flex-1 min-w-0 ml-4">
                                                <div class="flex items-center justify-between gap-3">
                                                    <p class="text-sm font-semibold text-gray-900">Interview</p>
                                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                                        Pending
                                                    </span>
                                                </div>
                                                <p class="mt-1 text-xs text-gray-500">
                                                    Interview will be scheduled after application review.
                                                </p>
                                            </div>
                                        </div>

                                        <div class="flex items-start">
                                            <div class="relative z-10 flex items-center justify-center w-8 h-8 bg-gray-300 border-4 border-white rounded-full shadow-sm">
                                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4" />
                                                </svg>
                                            </div>
                                            <div class="flex-1 min-w-0 ml-4">
                                                <div class="flex items-center justify-between gap-3">
                                                    <p class="text-sm font-semibold text-gray-900">Final Decision</p>
                                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                                        Pending
                                                    </span>
                                                </div>
                                                <p class="mt-1 text-xs text-gray-500">
                                                    Awaiting application completion and review process.
                                                </p>
                                            </div>
                                        </div>

                                    <?php else: ?>
                                        <!-- For Complete Applications - Show Normal Timeline -->

                                        <!-- Step 1: Application Submitted -->
                                        <div class="flex items-start">
                                            <div class="relative z-10 flex items-center justify-center w-8 h-8 border-4 border-white rounded-full shadow-sm bg-primary">
                                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </div>
                                            <div class="flex-1 min-w-0 ml-4">
                                                <div class="flex items-center justify-between gap-3">
                                                    <p class="text-sm font-semibold text-gray-900">Application Submitted</p>
                                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium text-gray-700">
                                                        <?php echo date('M j, Y g:i A', strtotime($application['applied_at'])); ?>
                                                    </span>
                                                </div>
                                                <p class="mt-1 text-xs text-gray-500">Your application has been successfully submitted.</p>
                                            </div>
                                        </div>

                                        <!-- Step 2: Application Review -->
                                        <?php
                                        $reviewedAt = !empty($application['reviewed_at']) ? date('M j, Y g:i A', strtotime($application['reviewed_at'])) : null;
                                        $reviewBadgeClass = $reviewedAt ? 'text-gray-700' : 'bg-yellow-50 text-yellow-700 border border-yellow-200';
                                        $reviewBadgeText  = $reviewedAt ? $reviewedAt : 'Pending';
                                        ?>
                                        <div class="flex items-start">
                                            <div class="relative z-10 flex items-center justify-center w-8 h-8 rounded-full <?php echo in_array($currentStatus, ['reviewed', 'shortlisted', 'hired', 'rejected']) ? 'bg-primary' : 'bg-gray-300'; ?> border-4 border-white shadow-sm">
                                                <svg class="w-4 h-4 <?php echo in_array($currentStatus, ['reviewed', 'shortlisted', 'hired', 'rejected']) ? 'text-white' : 'text-gray-500'; ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </div>
                                            <div class="flex-1 min-w-0 ml-4">
                                                <div class="flex items-center justify-between gap-3">
                                                    <p class="text-sm font-semibold text-gray-900">Application Reviewed</p>
                                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium <?php echo $reviewBadgeClass; ?>">
                                                        <?php echo $reviewBadgeText; ?>
                                                    </span>
                                                </div>
                                                <p class="mt-1 text-xs text-gray-500">
                                                    <?php echo $reviewedAt ? 'The employer has reviewed your application and qualifications.' : 'Waiting for employer to review your application.'; ?>
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Step 3: Interview -->
                                        <?php
                                        $hasInterview = !empty($application['interview_date']) && $application['interview_date'] !== '0000-00-00 00:00:00';
                                        $interviewDateText = $hasInterview ? date('M j, Y g:i A', strtotime($application['interview_date'])) : 'Pending';
                                        $interviewBadgeClass = $hasInterview ? 'text-gray-700' : 'bg-yellow-50 text-yellow-700 border border-yellow-200';
                                        ?>
                                        <div class="flex items-start">
                                            <div class="relative z-10 flex items-center justify-center w-8 h-8 rounded-full <?php echo $hasInterview ? 'bg-secondary' : (in_array($currentStatus, ['shortlisted']) ? 'bg-yellow-400' : 'bg-gray-300'); ?> border-4 border-white shadow-sm">
                                                <svg class="w-4 h-4 <?php echo $hasInterview ? 'text-white' : 'text-white'; ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                                </svg>
                                            </div>
                                            <div class="flex-1 min-w-0 ml-4">
                                                <div class="flex items-center justify-between gap-3">
                                                    <p class="text-sm font-semibold text-gray-900">
                                                        <?php echo $hasInterview ? 'Interview Scheduled' : 'Interview'; ?>
                                                    </p>
                                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium <?php echo $interviewBadgeClass; ?>">
                                                        <?php echo $interviewDateText; ?>
                                                    </span>
                                                </div>

                                                <?php if ($hasInterview): ?>
                                                    <!-- Date, Time, and Location all in one row -->
                                                    <div class="flex flex-wrap items-center gap-2 mt-1 text-xs text-gray-500">
                                                        <span><?php echo date('l, F j, Y', strtotime($application['interview_date'])); ?></span>
                                                        <span class="text-gray-400">|</span>
                                                        <span><?php echo date('g:i A', strtotime($application['interview_date'])); ?></span>
                                                        <?php if (!empty($application['interview_location'])): ?>
                                                            <span class="text-gray-400">|</span>
                                                            <span><?php echo htmlspecialchars($application['interview_location']); ?></span>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php else: ?>
                                                    <p class="mt-1 text-xs text-gray-500">
                                                        <?php echo in_array($currentStatus, ['shortlisted']) ? 'Interview date will be announced soon.' : 'Awaiting review completion.'; ?>
                                                    </p>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <!-- Step 4: Final Decision -->
                                        <?php
                                        $decisionAt = $application['decision_at'] ?? ($application['reviewed_at'] ?? ($application['applied_at'] ?? null));
                                        $decisionText = in_array($currentStatus, ['hired', 'rejected']) && $decisionAt ? date('M j, Y g:i A', strtotime($decisionAt)) : 'Pending';
                                        $decisionBadgeClass = in_array($currentStatus, ['hired', 'rejected']) ? 'text-gray-700' : 'bg-yellow-50 text-yellow-700 border border-yellow-200';
                                        $decisionDotClass = $currentStatus === 'hired' ? 'bg-primary' : ($currentStatus === 'rejected' ? 'bg-red-500' : 'bg-gray-300');
                                        ?>
                                        <div class="flex items-start">
                                            <div class="relative z-10 flex items-center justify-center w-8 h-8 rounded-full border-4 border-white shadow-sm <?php echo $currentStatus === 'hired' ? 'bg-primary' : ($currentStatus === 'rejected' ? 'bg-red-500' : 'bg-gray-300'); ?>">
                                                <?php if ($currentStatus === 'hired'): ?>
                                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4" />
                                                    </svg>
                                                <?php elseif ($currentStatus === 'rejected'): ?>
                                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                <?php else: ?>
                                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4" />
                                                    </svg>
                                                <?php endif; ?>
                                            </div>
                                            <div class="flex-1 min-w-0 ml-4">
                                                <div class="flex items-center justify-between gap-3">
                                                    <p class="text-sm font-semibold text-gray-900">
                                                        <?php echo $currentStatus === 'hired' ? 'Hired' : ($currentStatus === 'rejected' ? 'Not Selected' : 'Final Decision'); ?>
                                                    </p>
                                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium <?php echo $decisionBadgeClass; ?>">
                                                        <?php echo $decisionText; ?>
                                                    </span>
                                                </div>
                                                <p class="mt-1 text-xs text-gray-500">
                                                    <?php echo $currentStatus === 'hired' ? 'Welcome to the team! Further instructions will follow.' : ($currentStatus === 'rejected' ? 'Thank you for your interest. We encourage you to apply for other positions.' : 'Awaiting final decision from employer.'); ?>
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Step 5: Resignation Process (if applicable) -->
                                        <?php if (isset($resignationRequest) && $resignationRequest): ?>
                                            <div class="flex items-start">
                                                <div class="relative z-10 flex items-center justify-center w-8 h-8 rounded-full border-4 border-white shadow-sm 
                                                    <?php echo $resignationRequest['request_status'] === 'approved' ? 'bg-green-500' : ($resignationRequest['request_status'] === 'rejected' ? 'bg-red-500' : 'bg-orange-500'); ?>">
                                                    <?php if ($resignationRequest['request_status'] === 'approved'): ?>
                                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                        </svg>
                                                    <?php elseif ($resignationRequest['request_status'] === 'rejected'): ?>
                                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                    <?php else: ?>
                                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="flex-1 min-w-0 ml-4">
                                                    <div class="flex items-center justify-between gap-3">
                                                        <p class="text-sm font-medium text-gray-900">
                                                            Resignation Request
                                                            <?php echo ucfirst($resignationRequest['request_status']); ?>
                                                        </p>
                                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium 
                                                            <?php echo $resignationRequest['request_status'] === 'approved' ? 'bg-green-100 text-green-700' : ($resignationRequest['request_status'] === 'rejected' ? 'bg-red-100 text-red-700' : 'bg-orange-100 text-orange-700'); ?>">
                                                            <?php
                                                            if ($resignationRequest['request_status'] === 'pending') {
                                                                echo date('M j, Y g:i A', strtotime($resignationRequest['requested_at']));
                                                            } else {
                                                                echo date('M j, Y g:i A', strtotime($resignationRequest['reviewed_at']));
                                                            }
                                                            ?>
                                                        </span>
                                                    </div>
                                                    <p class="mt-1 text-xs text-gray-500">
                                                        <?php
                                                        if ($resignationRequest['request_status'] === 'pending') {
                                                            echo 'Resignation request submitted and awaiting employer approval.';
                                                        } elseif ($resignationRequest['request_status'] === 'approved') {
                                                            echo 'Resignation request approved. Employment status updated to resigned.';
                                                        } else {
                                                            echo 'Resignation request was rejected. You may submit a new request.';
                                                        }
                                                        ?>
                                                    </p>

                                                    <?php if (!empty($resignationRequest['resignation_reason'])): ?>
                                                        <div class="p-2 mt-2 text-xs text-gray-600 bg-gray-100 rounded">
                                                            <strong>Your reason:</strong> <?php echo nl2br(htmlspecialchars($resignationRequest['resignation_reason'])); ?>
                                                        </div>
                                                    <?php endif; ?>

                                                    <?php if (!empty($resignationRequest['employer_notes']) && $resignationRequest['request_status'] !== 'pending'): ?>
                                                        <div class="p-2 mt-2 text-xs text-gray-600 bg-gray-100 rounded">
                                                            <strong>Employer response:</strong> <?php echo nl2br(htmlspecialchars($resignationRequest['employer_notes'])); ?>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Application Information -->
                        <div class="mb-6 sm:mb-8">
                            <h3 class="mb-4 text-lg font-semibold text-gray-900">Application Information</h3>
                            <div class="space-y-4">
                                <div class="flex items-center justify-between p-3 rounded-md bg-gray-50">
                                    <span class="text-sm font-light text-gray-600">Application ID:</span>
                                    <span class="text-sm font-medium text-primary">#<?php echo str_pad($application['application_id'], 6, '0', STR_PAD_LEFT); ?></span>
                                </div>

                                <div class="flex items-center justify-between p-3 rounded-md bg-gray-50">
                                    <span class="text-sm font-light text-gray-600">Applied:</span>
                                    <span class="text-sm font-medium text-primary"><?php echo date('M j, Y', strtotime($application['applied_at'])); ?></span>
                                </div>

                                <?php if (!empty($application['reviewed_at'])): ?>
                                    <div class="flex items-center justify-between p-3 rounded-md bg-gray-50">
                                        <span class="text-sm font-light text-gray-600">Last Updated:</span>
                                        <span class="text-sm font-medium text-primary"><?php echo date('M j, Y', strtotime($application['reviewed_at'])); ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="flex w-full gap-3">
                            <a href="?page=view-job&job_id=<?php echo $application['job_id']; ?>"
                                class="flex items-center justify-center flex-1 px-4 py-2 text-sm font-medium text-gray-700 transition-colors bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                </svg>
                                View Job Posting
                            </a>

                            <button onclick="window.print()"
                                class="flex items-center justify-center flex-1 px-4 py-2 text-sm font-medium text-gray-700 transition-colors bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                </svg>
                                Print Application
                            </button>

                            <button
                                onclick="navigator.share ? navigator.share({title: 'My Job Application - <?php echo htmlspecialchars($application['job_title']); ?>', url: window.location.href}) : alert('Share feature not supported')"
                                class="flex items-center justify-center flex-1 px-4 py-2 text-sm font-medium text-gray-700 transition-colors bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z" />
                                </svg>
                                Share Application
                            </button>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function withdrawApplication() {
        if (confirm('Are you sure you want to withdraw this application?\n\nThis action cannot be undone.')) {
            // Add loading state
            event.target.innerHTML = `
                <svg class="w-4 h-4 mr-2 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="m4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Withdrawing...
            `;
            event.target.disabled = true;

            window.location.href = '?page=withdraw-application&id=<?php echo $application['application_id']; ?>';
        }
    }

    // Add smooth scroll behavior for better UX
    document.documentElement.style.scrollBehavior = 'smooth';

    // Print styles
    const printStyles = `
        <style media="print">
            .no-print { display: none !important; }
            body { font-size: 12px; }
            .bg-gray-50 { background: #f9f9f9 !important; }
            .border { border: 1px solid #e5e7eb !important; }
            .rounded-xl, .rounded-lg { border-radius: 8px !important; }
        </style>
    `;
    document.head.insertAdjacentHTML('beforeend', printStyles);
</script>