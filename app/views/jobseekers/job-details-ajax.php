<?php
include_once __DIR__ . '/components/jobseeker_auth_check.php';
if (!isset($selectedJob) || empty($selectedJob)) {
    echo '<div class="p-8 text-center text-red-500">Error: Job data not available</div>';
    return;
}
?>
<!-- Job Details Card (AJAX Template) -->
<div class="overflow-hidden bg-white border border-gray-200 shadow-sm rounded-xl">

    <!-- Card Header with Background -->
    <div class="p-8 rounded-t-lg bg-gray-50 ">
        <div class="flex items-start justify-between">
            <div class="flex items-center space-x-4">
                <!-- Business Logo -->
                <div class="flex items-center justify-center w-16 h-16 overflow-hidden bg-white border-2 border-gray-200 rounded-lg">
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
                            class="object-cover w-full h-full"
                            onerror="console.error('Failed to load image:', this.src); this.style.display='none'; this.nextElementSibling.style.display='block';">
                        <i class="text-2xl text-gray-400 fas fa-building" style="display: none;"></i>
                    <?php else: ?>
                        <i class="text-2xl text-gray-400 fas fa-building"></i>
                    <?php endif; ?>
                </div>

                <!-- Job Title and Company -->
                <div class="flex-1">
                    <h2 class="mb-1 text-xl font-bold text-grayMain">
                        <?php echo htmlspecialchars($selectedJob['job_title']); ?>
                    </h2>

                    <?php
                    $companyName = '';
                    if (!empty($selectedJob['company_name'])) {
                        $companyName = $selectedJob['company_name'];
                    } elseif (!empty($selectedJob['business_name'])) {
                        $companyName = $selectedJob['business_name'];
                    } elseif (isset($selectedJob['employer_first_name']) && isset($selectedJob['employer_last_name'])) {
                        $companyName = trim($selectedJob['employer_first_name'] . ' ' . $selectedJob['employer_last_name']);
                    } else {
                        $companyName = 'Company Name Not Available';
                    }
                    ?>
                    <a href="?page=view-employer-profile&employer_id=<?php echo $selectedJob['employer_id']; ?>&job_id=<?php echo $selectedJob['job_id']; ?>&job_title=<?php echo urlencode($selectedJob['job_title']); ?>"
                        class="font-normal text-gray-600 transition-colors hover:text-primary hover:underline">
                        <?php echo htmlspecialchars($companyName); ?>
                    </a>
                </div>

            </div>

            <!-- Action Buttons Box -->
            <div class="flex items-center gap-2 p-2">
                <!-- Verified Badge -->
                <button class="flex items-center justify-center w-8 h-8 transition-colors border rounded-lg text-primary border-primary bg-primary/10 hover:bg-primary/20" title="Verified">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="#10364B">
                        <path d="M14.01 21c-.49 0-.95-.23-1.33-.43-.24-.12-.53-.27-.68-.27s-.47.15-.7.27c-.48.25-1.08.55-1.72.38-.66-.17-1.02-.75-1.34-1.21-.13-.21-.31-.49-.43-.56-.12-.07-.44-.08-.71-.1-.54-.03-1.21-.06-1.7-.53-.48-.49-.51-1.16-.54-1.7-.01-.26-.03-.59-.07-.71-.06-.11-.35-.29-.55-.43-.46-.3-1.03-.67-1.21-1.31-.17-.64.13-1.24.38-1.72.12-.24.27-.53.27-.68s-.15-.47-.27-.7c-.25-.48-.55-1.08-.38-1.72.17-.66.75-1.02 1.21-1.34.2-.13.49-.31.56-.43.07-.12.08-.44.1-.71.03-.54.06-1.21.53-1.7.49-.48 1.16-.51 1.7-.54.26-.01.59-.03.71-.07.11-.06.29-.35.43-.55.3-.46.67-1.03 1.31-1.21.64-.17 1.24.13 1.72.38.24.12.53.27.68.27s.47-.15.7-.27c.48-.25 1.08-.55 1.72-.38.66.17 1.02.75 1.34 1.21.13.21.31.49.43.56.12.07.44.08.71.1.54.03 1.21.06 1.7.53.48.49.51 1.16.54 1.7.01.26.03.59.07.71.06.11.35.29.55.43.46.3 1.03.67 1.21 1.31.17.64-.13 1.24-.38 1.72-.12.24-.27.53-.27.68s.15.47.27.7c.25.48.55 1.08.38 1.72-.17.66-.75 1.02-1.21 1.34-.2.13-.49.31-.56.43-.07.12-.08.44-.1.71-.03.54-.06 1.21-.53 1.7-.49.48-1.16.51-1.7.54-.26.01-.59.03-.71.07-.11.06-.29.35-.43.55-.3.46-.67 1.03-1.31 1.21-.13.04-.26.05-.39.05Zm-4.02-16.5c-.1.04-.33.38-.44.57-.24.37-.51.79-.94 1.04-.44.25-.94.28-1.39.3-.22.01-.63.03-.72.1-.06.08-.08.48-.09.7-.02.45-.05.95-.3 1.39-.25.44-.67.72-1.04.95-.18.11-.52.33-.56.44-.01.11.16.46.26.66.2.4.44.83.44 1.34s-.24.94-.44 1.34c-.1.2-.27.55-.26.66.04.11.38.34.56.45.37.23.79.51 1.04.95.25.44.28.94.3 1.39.01.22.03.63.1.72.08.06.48.08.7.09.45.02.95.05 1.39.3.44.25.72.67.95 1.04.11.18.33.52.44.56.11.04.46-.16.66-.26.4-.2.83-.44 1.34-.44s.94.24 1.34.44c.2.1.55.27.66.26.11-.04.34-.38.45-.56.23-.37.51-.79.95-1.04.44-.25.94-.28 1.39-.3.22-.01.63-.03.72-.1.06-.08.08-.48.09-.7.02-.45.05-.95.3-1.39.25-.44.67-.72 1.04-.95.18-.11.52-.33.56-.44.01-.11-.16-.46-.26-.66-.2-.4-.44-.83-.44-1.34s.24-.94.44-1.34c.1-.2.27-.55.26-.66-.04-.11-.38-.34-.56-.45-.37-.23-.79-.51-1.04-.95-.25-.44-.28-.94-.3-1.39-.01-.22-.03-.63-.1-.72-.08-.06-.48-.08-.7-.09-.45-.02-.95-.05-1.39-.3-.44-.25-.72-.67-.95-1.04-.11-.18-.33-.52-.44-.56-.1-.03-.45.17-.66.27-.4.2-.83.44-1.34.44s-.94-.24-1.34-.44c-.2-.1-.55-.27-.66-.27Zm.5 11.01c-.2 0-.39-.08-.53-.22l-2.54-2.53c-.29-.29-.29-.77 0-1.06.29-.29.77-.29 1.06 0l1.98 1.98 4.99-4.99c.29-.29.77-.29 1.06 0s.29.77 0 1.06l-5.52 5.52c-.14.14-.33.22-.53.22Z" />
                    </svg>

                </button>

                <!-- Share Button -->
                <button class="flex items-center justify-center w-8 h-8 text-gray-600 transition-colors border border-gray-400 rounded-lg bg-gray-50 hover:bg-gray-100" title="Share">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 12C9 13.3807 7.88071 14.5 6.5 14.5C5.11929 14.5 4 13.3807 4 12C4 10.6193 5.11929 9.5 6.5 9.5C7.88071 9.5 9 10.6193 9 12Z" stroke="#828282" stroke-width="1.5" />
                        <path d="M14 6.5L9 10" stroke="#828282" stroke-width="1.5" stroke-linecap="round" />
                        <path d="M14 17.5L9 14" stroke="#828282" stroke-width="1.5" stroke-linecap="round" />
                        <path d="M19 18.5C19 19.8807 17.8807 21 16.5 21C15.1193 21 14 19.8807 14 18.5C14 17.1193 15.1193 16 16.5 16C17.8807 16 19 17.1193 19 18.5Z" stroke="#828282" stroke-width="1.5" />
                        <path d="M19 5.5C19 6.88071 17.8807 8 16.5 8C15.1193 8 14 6.88071 14 5.5C14 4.11929 15.1193 3 16.5 3C17.8807 3 19 4.11929 19 5.5Z" stroke="#828282" stroke-width="1.5" />
                    </svg>
                </button>

                <!-- Save Button -->
                <?php if ($hasProfile): ?>
                    <button onclick="toggleSaveJob(<?php echo $selectedJob['job_id']; ?>, this)"
                        class="flex items-center justify-center w-8 h-8 transition-colors border border-gray-400 rounded-lg <?php echo (isset($selectedJob['is_saved']) && $selectedJob['is_saved']) ? 'text-yellow-500 bg-yellow-50 border-yellow-300' : 'text-gray-500 bg-gray-50'; ?> hover:bg-gray-100"
                        title="<?php echo (isset($selectedJob['is_saved']) && $selectedJob['is_saved']) ? 'Remove from saved' : 'Save job'; ?>">
                        <i class="text-sm <?php echo (isset($selectedJob['is_saved']) && $selectedJob['is_saved']) ? 'fas' : 'far'; ?> fa-bookmark"></i>
                    </button>
                <?php else: ?>
                    <button class="flex items-center justify-center w-8 h-8 text-gray-500 transition-colors border border-gray-400 rounded-lg bg-gray-50 hover:bg-gray-100" title="Save" disabled>
                        <i class="text-sm far fa-bookmark"></i>
                    </button>
                <?php endif; ?>

            </div>
        </div>

        <!-- Tags and Stats Section -->
        <div class="flex items-center justify-between mt-4">
            <!-- Job Tags -->
            <div class="flex flex-wrap items-center gap-2">
                <span class="px-3 py-2 text-sm bg-gray-100 rounded-sm text-primary">
                    <?php echo htmlspecialchars(ucfirst($selectedJob['job_type'])); ?>
                </span>
                <?php if (!empty($selectedJob['category_name'])): ?>
                    <span class="px-3 py-2 text-sm bg-gray-100 rounded-sm text-primary">
                        <?php echo htmlspecialchars($selectedJob['category_name']); ?>
                    </span>
                <?php endif; ?>
                <span class="px-3 py-2 text-sm bg-gray-100 rounded-sm text-primary">
                    <?php echo ucfirst($selectedJob['workplace_option'] ?? 'Onsite'); ?>
                </span>
            </div>

            <!-- Stats Section -->
            <div class="flex items-center gap-2 text-sm font-medium text-gray-600">
                <?php
                // Calculate days left before Application Deadline (not expiration_date)
                $daysLeft = 'N/A';
                if (!empty($selectedJob['application_deadline'])) {
                    $deadline = new DateTime($selectedJob['application_deadline']);
                    $now = new DateTime();
                    $diff = $now->diff($deadline);

                    if ($deadline > $now) {
                        $daysLeft = $diff->days . ' days left';
                    } else {
                        $daysLeft = 'Expired';
                    }
                } elseif (!empty($selectedJob['created_at'])) {
                    // If no deadline, show how long ago it was posted
                    $posted = new DateTime($selectedJob['created_at']);
                    $now = new DateTime();
                    $diff = $now->diff($posted);
                    $daysLeft = $diff->days . ' days ago';
                }

                // Use the application count that was already calculated in the controller
                $applicationCount = $selectedJob['application_count'] ?? 0;
                ?>

                <span><?php echo htmlspecialchars($daysLeft); ?></span>
                <span>·</span>
                <span><?php echo $applicationCount; ?> applied</span>
            </div>
        </div>
    </div>

    <!-- Card Body -->
    <div class="p-8">
        <!-- Job Summary -->
        <div class="mb-6">
            <h3 class="mb-3 text-lg font-semibold text-grayMain">Job Summary</h3>
            <div class="text-sm leading-relaxed text-gray-600">
                <?php echo nl2br(htmlspecialchars($selectedJob['job_summary'] ?? 'No job description available.')); ?>
            </div>
        </div>

        <!-- Skills Required -->
        <?php if (!empty($selectedJob['skills']) && is_array($selectedJob['skills'])): ?>
            <div class="mb-6">
                <h3 class="mb-3 text-lg font-semibold text-grayMain">Skills Required</h3>
                <div class="flex flex-wrap gap-2">
                    <?php foreach (array_unique($selectedJob['skills']) as $skill): ?>
                        <span class="px-3 py-2 text-sm text-gray-700 bg-gray-100 rounded-lg">
                            <?php echo htmlspecialchars($skill); ?>
                        </span>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Full Description -->
        <?php if (!empty($selectedJob['full_description']) && $selectedJob['full_description'] !== $selectedJob['job_summary']): ?>
            <div class="mb-6">
                <h3 class="mb-3 text-lg font-semibold text-grayMain">Full Description</h3>
                <div class="text-sm leading-relaxed text-gray-600">
                    <?php echo nl2br(htmlspecialchars($selectedJob['full_description'])); ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Application Timeline -->
        <?php if (!empty($selectedJob['application_start']) || !empty($selectedJob['application_deadline'])): ?>
            <div class="mb-6">
                <h3 class="mb-3 text-lg font-semibold text-grayMain">Application Timeline</h3>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <?php if (!empty($selectedJob['application_start'])): ?>
                        <div>
                            <div class="text-xs text-gray-400">Application Start</div>
                            <div class="text-sm text-primary"><?php echo date('M j, Y', strtotime($selectedJob['application_start'])); ?></div>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($selectedJob['application_deadline'])): ?>
                        <div>
                            <div class="text-xs text-gray-400">Application Deadline</div>
                            <div class="text-sm <?php echo (strtotime($selectedJob['application_deadline']) < time()) ? 'text-red-600' : 'text-primary'; ?>">
                                <?php echo date('M j, Y', strtotime($selectedJob['application_deadline'])); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Action Buttons -->
        <div class="flex w-full gap-3 mt-8">
            <?php
            // Debug: Log the values to understand what's happening
            error_log("DEBUG - hasProfile: " . ($hasProfile ? 'true' : 'false'));
            error_log("DEBUG - has_applied: " . (isset($selectedJob['has_applied']) ? ($selectedJob['has_applied'] ? 'true' : 'false') : 'not set'));
            error_log("DEBUG - jobseeker_id: " . ($jobseekerId ?? 'null'));
            ?>

            <?php if (!$hasProfile): ?>
                <a href="?page=complete-jobseeker-profile"
                    class="flex-1 px-4 py-3 text-sm font-medium text-center text-white transition-colors bg-gray-600 rounded-lg hover:bg-gray-700">
                    Complete Profile to Apply
                </a>
            <?php elseif (isset($selectedJob['has_applied']) && $selectedJob['has_applied'] === true): ?>
                <span class="flex-1 px-4 py-3 text-sm font-medium text-center text-gray-500 bg-gray-100 border border-gray-300 rounded-lg">
                    <i class="mr-1 fas fa-check-circle"></i> Applied
                </span>
            <?php else: ?>
                <a href="?page=apply-job&job_id=<?php echo $selectedJob['job_id']; ?>&step=1"
                    class="flex-1 px-4 py-3 text-sm font-medium text-center text-white transition-colors rounded-lg bg-primary hover:bg-primary/90">
                    <i class="mr-1 fas fa-paper-plane"></i> Apply Now
                </a>
            <?php endif; ?>
            <a href="?page=view-job&job_id=<?php echo $selectedJob['job_id']; ?>"
                class="flex-1 px-4 py-3 text-sm font-medium text-center transition-colors bg-white border rounded-lg text-primary border-primary hover:bg-primary/5">
                View Full Details
            </a>
        </div>


    </div>
</div>