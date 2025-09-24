<?php
// filepath: c:\xampp\htdocs\sikap\app\views\jobseekers\profile-components\applications-contents.php

// Get hired applications from global scope if set by controller
$hiredApplications = $GLOBALS['hiredApplications'] ?? [];

?>

<div class="grid w-full gap-4 py-4 mb-8 border-t border-gray-200">
  <div class="mb-8">
    <h4 class="mb-4 text-base font-semibold text-primary">My Successful Applications</h4>

    <?php if (empty($hiredApplications)): ?>
      <div class="py-12 text-center">
        <svg class="w-16 h-16 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <h5 class="mb-2 font-medium text-gray-900 text-md">No Successful Applications Yet</h5>
        <p class="mb-6 text-xs text-gray-500">Keep applying! Your hired applications will appear here once employers confirm your hiring.</p>
        <a href="?page=browse-jobs" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white rounded-md bg-primary hover:bg-secondary">
          <i class="mr-2 fas fa-search"></i>
          Browse Jobs
        </a>
      </div>
    <?php else: ?>
      <div class="space-y-4">
        <?php foreach ($hiredApplications as $application): ?>
          <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm">
            <div class="flex items-start justify-between">
              <div class="flex-1">
                <h5 class="text-sm font-semibold text-gray-900">
                  <?php echo htmlspecialchars($application['job_title']); ?>
                </h5>
                <p class="mt-1 text-xs text-gray-600">
                  <?php echo htmlspecialchars($application['company_name'] ?? 'Company'); ?>
                </p>
                <div class="flex items-center mt-2 text-xs text-gray-500">
                  <i class="mr-1 fas fa-calendar-alt"></i>
                  Hired on <?php echo date('M j, Y', strtotime($application['reviewed_at'] ?? $application['applied_at'])); ?>
                </div>
              </div>
              <div class="flex items-center">
                <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-gray-100 rounded-md text-primary">
                  <i class="mr-1 fas fa-check-circle"></i>
                  Hired
                </span>
              </div>
            </div>
            <div class="mt-3">
              <a href="?page=view-application&id=<?php echo $application['application_id']; ?>"
                class="text-xs text-primary hover:text-secondary hover:underline">
                View Application Details
              </a>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</div>
