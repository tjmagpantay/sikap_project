<?php
// filepath: app/views/jobseekers/job-application/view-application.php
include_once __DIR__ . '/../../components/navbar-top.php';
include_once __DIR__ . '/../navbar-jobseeker.php';
?>

<div class="py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <a href="?page=my-applications" class="text-primary hover:text-secondary">
                <i class="mr-1 fas fa-arrow-left"></i> Back to My Applications
            </a>
            <h1 class="mt-2 text-3xl font-bold text-primary">Application Details</h1>
            <p class="text-secondary">Application #<?php echo str_pad($application['application_id'], 6, '0', STR_PAD_LEFT); ?></p>
        </div>

        <div class="space-y-6">
            <!-- Application Status -->
            <div class="p-6 bg-white rounded-lg shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-semibold text-primary"><?php echo htmlspecialchars($application['job_title']); ?></h2>
                        <p class="text-secondary"><?php echo htmlspecialchars($application['company_name'] ?? 'Company'); ?></p>
                    </div>
                    <div class="text-right">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                <?php
                                switch ($application['application_status']) {
                                    case 'pending':
                                        echo 'bg-yellow-100 text-yellow-800';
                                        break;
                                    case 'reviewed':
                                        echo 'bg-secondary/10 text-secondary';
                                        break;
                                    case 'shortlisted':
                                        echo 'bg-primary/10 text-primary';
                                        break;
                                    case 'rejected':
                                        echo 'bg-red-100 text-red-800';
                                        break;
                                    case 'hired':
                                        echo 'bg-green-100 text-green-800';
                                        break;
                                    default:
                                        echo 'bg-gray-100 text-gray-800';
                                }
                                ?>">
                            <?php echo ucfirst($application['application_status']); ?>
                        </span>
                        <p class="mt-1 text-sm text-gray-500">
                            Applied on <?php echo date('F j, Y \a\t g:i A', strtotime($application['applied_at'])); ?>
                        </p>
                        <?php if ($application['reviewed_at']): ?>
                            <p class="text-sm text-gray-500">
                                Reviewed on <?php echo date('F j, Y \a\t g:i A', strtotime($application['reviewed_at'])); ?>
                            </p>
                    </div>
                </div>
            </div>

            <!-- Job Information -->
            <div class="p-6 bg-white rounded-lg shadow">
                <h3 class="mb-4 text-lg font-medium text-primary">Job Information</h3>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-secondary">Job Type</label>
                        <p class="mt-1 text-sm text-gray-900"><?php echo ucfirst(str_replace('-', ' ', $application['job_type'])); ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-secondary">Location</label>
                        <p class="mt-1 text-sm text-gray-900"><?php echo htmlspecialchars($application['location']); ?></p>
                    </div>
                    <?php if ($application['show_pay'] && $application['salary']): ?>
                        <div>
                            <label class="block text-sm font-medium text-secondary">Salary</label>
                            <p class="mt-1 text-sm text-gray-900">₱<?php echo number_format($application['salary'], 2); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
                <?php if ($application['job_summary']): ?>
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-secondary">Job Summary</label>
                        <p class="mt-1 text-sm text-gray-900"><?php echo nl2br(htmlspecialchars($application['job_summary'])); ?></p>
                    </div>
                <?php endif; ?>
                <div class="mt-4">
                    <a href="?page=view-job&job_id=<?php echo $application['job_id']; ?>"
                        class="inline-flex items-center text-sm text-primary hover:text-secondary">
                        <i class="mr-1 fas fa-external-link-alt"></i>
                        View full job posting
                    </a>
                </div>
            </div>

            <!-- Resume & Documents Submitted -->
            <?php $resumeAttachment = null;
                            foreach ($attachments as $attachment) {
                                if (strtolower($attachment['file_type']) === 'resume' || strtolower($attachment['file_type']) === 'cv') {
                                    $resumeAttachment = $attachment;
                                    break;
                                }
                            }
            ?>
            <div class="p-6 bg-white rounded-lg shadow">
                <h3 class="mb-4 text-lg font-medium text-primary">Resume Submitted</h3>
                <div class="flex items-center space-x-3">
                    <i class="text-red-500 fas fa-file-pdf"></i>
                    <a href="/<?php echo htmlspecialchars($resumeAttachment['file_path']); ?>" target="_blank"
                        class="text-primary hover:text-secondary">
                        View Resume
                    </a>
                    <span class="text-xs text-gray-500">
                        (Uploaded: <?php echo date('M j, Y', strtotime($resumeAttachment['uploaded_at'])); ?>)
                    </span>
                </div>
            </div>
        <?php endif; ?>

        <!-- Additional Attachments -->
        <?php if (!empty($otherAttachments)): ?>
            <div class="p-6 bg-white rounded-lg shadow">
                <h3 class="mb-4 text-lg font-medium text-primary">Additional Attachments</h3>
                <div class="space-y-3">
                    <?php foreach ($otherAttachments as $attachment): ?>
                        <div class="flex items-center justify-between p-3 rounded bg-gray-50">
                            <div class="flex items-center space-x-3">
                                <i class="text-secondary fas fa-paperclip"></i>
                                <div>
                                    <p class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($attachment['file_type']); ?></p>
                                    <p class="text-xs text-gray-500">Uploaded <?php echo date('M j, Y', strtotime($attachment['uploaded_at'])); ?></p>
                                </div>
                            </div>
                            <a href="/<?php echo htmlspecialchars($attachment['file_path']); ?>" target="_blank"
                                class="text-sm text-primary hover:text-secondary">
                                View File
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Actions -->
        <div class="p-6 bg-white rounded-lg shadow">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-medium text-primary">Application Actions</h3>
                    <p class="text-sm text-secondary">Manage your application</p>
                </div>
                <div class="flex space-x-3">
                    <?php if ($application['application_status'] === 'pending'): ?>
                        <a href="?page=withdraw-application&id=<?php echo $application['application_id']; ?>"
                            onclick="return confirm('Are you sure you want to withdraw this application?\n\nThis action cannot be undone.')"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md hover:bg-red-700">
                            <i class="mr-2 fas fa-times"></i>
                            Withdraw Application
                        </a>
                    <?php endif; ?>
                    <a href="?page=my-applications"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium border rounded-md text-primary bg-secondary/10 border-secondary hover:bg-secondary/20">
                        <i class="mr-2 fas fa-list"></i>
                        Back to All Applications
                    </a>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>