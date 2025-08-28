<?php
include_once __DIR__ . '/components/jobseeker_auth_check.php';
if (!isset($selectedJob) || empty($selectedJob)) {
    echo '<div class="p-8 text-center text-red-500">Error: Job data not available</div>';
    return;
}
?>
<!-- Job Details Card (AJAX Template) -->
<div class="p-6 bg-white border border-gray-200 shadow-sm rounded-xl">
    <div class="flex items-start justify-between">
        <div class="flex items-start space-x-4">
            <!-- Business Logo/Profile -->
            <div class="flex items-center justify-center w-16 h-16 overflow-hidden border-gray-200 rounded-md">
                <?php if (!empty($selectedJob['business_logo'])): ?>
                    <?php
                    // Handle different logo path formats
                    $logoSrc = $selectedJob['business_logo'];
                    // If the path doesn't start with http or /, assume it's relative to public
                    if (strpos($logoSrc, 'http') !== 0 && strpos($logoSrc, '/') !== 0 && strpos($logoSrc, './') !== 0) {
                        $logoSrc = './' . $logoSrc;
                    }
                    ?>
                    <img src="<?php echo htmlspecialchars($logoSrc); ?>" alt="Company Logo"
                        class="object-cover w-full h-full min-w-full min-h-full border-2 border-gray-200 rounded-md"
                        onerror="console.error('Failed to load image:', this.src); this.style.display='none'; this.nextElementSibling.style.display='block';">
                    <i class="text-2xl text-gray-500 fas fa-building" style="display: none;"></i>
                <?php else: ?>
                    <i class="text-2xl text-gray-500 fas fa-building"></i>
                <?php endif; ?>
            </div>

            <div>
                <h2 class="text-lg font-bold text-gray-900"><?php echo htmlspecialchars($selectedJob['job_title']); ?></h2>
                <div class="flex flex-col sm:flex-row sm:space-y-0 sm:space-x-4">
                    <p class="flex items-center text-gray-500">
                        <span class="text-sm text-gray-500"><?php echo htmlspecialchars($selectedJob['company_name'] ?? $selectedJob['business_name'] ?? 'Company'); ?></span>
                    </p>
                    <p class="flex items-center text-gray-500">
                        <span class="text-sm text-gray-500"><?php echo htmlspecialchars($selectedJob['location']); ?></span>
                    </p>
                </div>
            </div>
        </div>
        <div class="flex gap-2 space-x-2">
            <?php if (isset($hasProfile) && $hasProfile): ?>
                <button onclick="toggleSaveJob(<?php echo $selectedJob['job_id']; ?>, this)"
                    class="p-2 rounded-full text-secondary hover:bg-gray-100 hover:text-yellow-500"
                    title="<?php echo (isset($selectedJob['is_saved']) && $selectedJob['is_saved']) ? 'Remove from saved' : 'Save job'; ?>">
                    <!-- Bookmark SVG Icon -->
                    <svg class="w-6 h-6" fill="<?php echo (isset($selectedJob['is_saved']) && $selectedJob['is_saved']) ? 'currentColor' : 'none'; ?>"
                        stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                    </svg>
                </button>
            <?php endif; ?>
            <a href="?page=view-job&job_id=<?php echo $selectedJob['job_id']; ?>"
                class="p-2 rounded-full text-primary hover:bg-gray-100 hover:text-primary"
                title="View Full Details">
                <!-- External Link SVG Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                </svg>
            </a>
        </div>
    </div>

    <div class="mt-4">
        <div class="flex flex-wrap items-center gap-2 mb-4">
            <span class="px-3 py-2 text-xs <?php echo strtolower($selectedJob['job_type']) === 'full-time' ? 'bg-blue-100 text-primary' : 'bg-blue-100 text-primary'; ?>">
                <?php echo strtoupper($selectedJob['job_type']); ?>
            </span>

            <?php if (!empty($selectedJob['category_name'])): ?>
                <span class="px-3 py-2 text-xs text-secondary bg-yellow-50">
                    <?php echo htmlspecialchars($selectedJob['category_name']); ?>
                </span>
            <?php endif; ?>

            <?php if (!empty($selectedJob['pay_range'])): ?>
                <span class="flex items-center px-3 py-2 text-xs text-gray-600 bg-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <?php echo htmlspecialchars($selectedJob['pay_range']); ?>
                </span>
            <?php endif; ?>

            <span class="flex items-center px-3 py-2 text-xs text-gray-600 bg-gray-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Posted <?php echo date('M j, Y', strtotime($selectedJob['created_at'])); ?>
            </span>
        </div>

        <!-- Application Timeline -->
        <?php if (!empty($selectedJob['application_start']) || !empty($selectedJob['application_deadline'])): ?>
            <div class="p-4 mb-6 border border-gray-200 rounded-lg bg-gray-50">
                <div class="space-y-2">
                    <?php if (!empty($selectedJob['application_start'])): ?>
                        <div class="flex items-center text-sm text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="font-medium">Applications Open:</span>
                            <span class="ml-2"><?php echo date('M j, Y g:i A', strtotime($selectedJob['application_start'])); ?></span>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($selectedJob['application_deadline'])): ?>
                        <div class="flex items-center text-sm text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2 text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="font-medium">Application Deadline:</span>
                            <span class="ml-2 <?php echo (strtotime($selectedJob['application_deadline']) < time()) ? 'text-red-600 font-semibold' : ''; ?>">
                                <?php echo date('M j, Y g:i A', strtotime($selectedJob['application_deadline'])); ?>
                            </span>
                            <?php if (strtotime($selectedJob['application_deadline']) < time()): ?>
                                <span class="px-2 py-1 ml-2 text-xs font-medium text-red-700 bg-red-100 rounded">EXPIRED</span>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="mb-6">
            <h3 class="mb-3 text-lg font-semibold text-gray-900">Job Description</h3>
            <div class="text-sm font-normal prose-sm prose text-gray-600 max-w-none">
                <?php echo nl2br(htmlspecialchars($selectedJob['job_summary'])); ?>
            </div>
        </div>

        <div class="flex flex-col gap-3 mt-8 sm:flex-row">
            <?php if (!isset($hasProfile) || !$hasProfile): ?>
                <a href="?page=complete-jobseeker-profile"
                    class="w-full px-4 py-3 text-sm font-medium text-center text-white transition-colors bg-gray-600 rounded-lg hover:bg-gray-700">
                    Complete Profile to Apply
                </a>
            <?php elseif (isset($selectedJob['has_applied']) && $selectedJob['has_applied']): ?>
                <span class="w-full px-4 py-3 text-sm font-medium text-center text-gray-500 bg-gray-100 border border-gray-300 rounded-lg">
                    <i class="mr-1 fas fa-check-circle"></i> Applied
                </span>
            <?php else: ?>
                <a href="?page=apply-job&job_id=<?php echo $selectedJob['job_id']; ?>&step=1"
                    class="w-full px-4 py-3 text-sm font-medium text-center text-white transition-colors rounded-lg bg-primary hover:bg-primary/90">
                    <i class="mr-1 fas fa-paper-plane"></i> Apply Now
                </a>
            <?php endif; ?>
            <a href="?page=view-job&job_id=<?php echo $selectedJob['job_id']; ?>"
                class="w-full px-4 py-3 text-sm font-medium text-center transition-colors bg-white border rounded-lg text-primary border-primary hover:bg-primary/5">
                View Full Details
            </a>
        </div>
    </div>
</div>