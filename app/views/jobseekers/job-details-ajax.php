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
        <div class="flex items-start justify-between min-w-0"> <!-- Added min-w-0 -->
            <div class="flex items-center flex-1 min-w-0 space-x-4"> <!-- Added flex-1 min-w-0 -->
                <!-- Business Logo -->
                <div class="flex items-center justify-center flex-shrink-0 w-16 h-16 overflow-hidden bg-white border-2 border-gray-200 rounded-lg"> <!-- Added flex-shrink-0 -->
                    <?php if (!empty($selectedJob['business_logo'])): ?>
                        <?php
                        $logoSrc = $selectedJob['business_logo'];
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
                <div class="flex-1 min-w-0"> <!-- Added min-w-0 for proper flex truncation -->
                    <!-- Enhanced Job Title with truncation -->
                    <h2 class="text-xl font-bold text-grayMain">
                        <div class="max-w-full truncate"
                            title="<?php echo htmlspecialchars($selectedJob['job_title']); ?>"
                            style="max-width: 100%; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            <?php echo htmlspecialchars($selectedJob['job_title']); ?>
                        </div>
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

                    <!-- Enhanced Company Name with truncation -->
                    <a href="?page=view-employer-profile&employer_id=<?php echo $selectedJob['employer_id']; ?>&job_id=<?php echo $selectedJob['job_id']; ?>&job_title=<?php echo urlencode($selectedJob['job_title']); ?>"
                        class="block font-normal text-gray-600 transition-colors hover:text-primary hover:underline">
                        <div class="max-w-full truncate"
                            title="<?php echo htmlspecialchars($companyName); ?>"
                            style="max-width: 100%; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            <?php echo htmlspecialchars($companyName); ?>
                        </div>
                    </a>

                    <!-- Enhanced Location with truncation -->
                    <div class="flex items-center min-w-0 transition-colors duration-300">
                        <span class="flex-1 min-w-0 text-sm text-gray-600 transition-colors duration-300">
                            <div class="max-w-full truncate"
                                title="<?php echo htmlspecialchars($selectedJob['location']); ?>"
                                style="max-width: 100%; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                <?php echo htmlspecialchars($selectedJob['location']); ?>
                            </div>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Action Buttons Box - with flex-shrink-0 -->
            <div class="flex items-center flex-shrink-0 gap-2 p-2"> <!-- Added flex-shrink-0 -->
                <!-- Verified Badge -->
                <button class="flex items-center justify-center w-8 h-8 transition-colors border rounded-lg text-primary border-primary bg-primary/10 hover:bg-primary/20" title="Verified">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="#10364B">
                        <path d="M14.01 21c-.49 0-.95-.23-1.33-.43-.24-.12-.53-.27-.68-.27s-.47.15-.7.27c-.48.25-1.08.55-1.72.38-.66-.17-1.02-.75-1.34-1.21-.13-.21-.31-.49-.43-.56-.12-.07-.44-.08-.71-.1-.54-.03-1.21-.06-1.7-.53-.48-.49-.51-1.16-.54-1.7-.01-.26-.03-.59-.07-.71-.06-.11-.35-.29-.55-.43-.46-.3-1.03-.67-1.21-1.31-.17-.64.13-1.24.38-1.72.12-.24.27-.53.27-.68s-.15-.47-.27-.7c-.25-.48-.55-1.08-.38-1.72.17-.66.75-1.02 1.21-1.34.2-.13.49-.31.56-.43.07-.12.08-.44.1-.71.03-.54.06-1.21.53-1.7.49-.48 1.16-.51 1.7-.54.26-.01.59-.03.71-.07.11-.06.29-.35.43-.55.3-.46.67-1.03 1.31-1.21.64-.17 1.24.13 1.72.38.24.12.53.27.68.27s.47-.15.7-.27c.48-.25 1.08-.55 1.72-.38.66.17 1.02.75 1.34 1.21.13.21.31.49.43.56.12.07.44.08.71.1.54.03 1.21.06 1.7.53.48.49.51 1.16.54 1.7.01.26.03.59.07.71.06.11.35.29.55.43.46.3 1.03.67 1.21 1.31.17.64-.13 1.24-.38 1.72-.12.24-.27.53-.27.68s.15.47.27.7c.25.48.55 1.08.38 1.72-.17.66-.75 1.02-1.21 1.34-.2.13-.49.31-.56.43-.07.12-.08.44-.1.71-.03.54-.06 1.21-.53 1.7-.49.48-1.16.51-1.7.54-.26.01-.59.03-.71.07-.11.06-.29.35-.43.55-.3.46-.67 1.03-1.31 1.21-.13.04-.26.05-.39.05Zm-4.02-16.5c-.1.04-.33.38-.44.57-.24.37-.51.79-.94 1.04-.44.25-.94.28-1.39.3-.22.01-.63.03-.72.1-.06.08-.08.48-.09.7-.02.45-.05.95-.3 1.39-.25.44-.67.72-1.04.95-.18.11-.52.33-.56.44-.01.11.16.46.26.66.2.4.44.83.44 1.34s-.24.94-.44 1.34c-.1.2-.27.55-.26.66.04.11.38.34.56.45.37.23.79.51 1.04.95.25.44.28.94.3 1.39.01.22.03.63.1.72.08.06.48.08.7.09.45.02.95.05 1.39.3.44.25.72.67.95 1.04.11.18.33.52.44.56.11.04.46-.16.66-.26.4-.2.83-.44 1.34-.44s.94.24 1.34.44c.2.1.55.27.66.26.11-.04.34-.38.45-.56.23-.37.51-.79.95-1.04.44-.25.94-.28 1.39-.3.22-.01.63-.03.72-.1.06-.08.08-.48.09-.7.02-.45.05-.95.3-1.39.25-.44.67-.72 1.04-.95.18-.11.52-.33.56-.44.01-.11-.16-.46-.26-.66-.2-.4-.44-.83-.44-1.34s.24-.94.44-1.34c.1-.2.27-.55.26-.66-.04-.11-.38-.34-.56-.45-.37-.23-.79-.51-1.04-.95-.25-.44-.28-.94-.3-1.39-.01-.22-.03-.63-.1-.72-.08-.06-.48-.08-.7-.09-.45-.02-.95-.05-1.39-.3-.44-.25-.72-.67-.95-1.04-.11-.18-.33-.52-.44-.56-.1-.03-.45.17-.66.27-.4.2-.83.44-1.34.44s-.94-.24-1.34-.44c-.2-.1-.55-.27-.66-.27Zm.5 11.01c-.2 0-.39-.08-.53-.22l-2.54-2.53c-.29-.29-.29-.77 0-1.06.29-.29.77-.29 1.06 0l1.98 1.98 4.99-4.99c.29-.29.77-.29 1.06 0s.29.77 0 1.06l-5.52 5.52c-.14.14-.33.22-.53.22Z" />
                    </svg>

                </button>
                <!-- Share Button -->
                <button
                    onclick="shareJob('<?php echo htmlspecialchars($selectedJob['job_title'], ENT_QUOTES); ?>', window.location.origin + window.location.pathname + '?page=view-job&job_id=<?php echo $selectedJob['job_id']; ?>')"
                    class="flex items-center justify-center w-8 h-8 text-gray-600 transition-colors border border-gray-400 rounded-lg bg-gray-50 hover:bg-gray-100"
                    title="Share">
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
            <!-- Enhanced job summary with proper text wrapping -->
            <div class="max-w-full text-sm leading-relaxed text-gray-600 break-words overflow-wrap-anywhere word-break-break-all"
                style="max-width: 100%; word-wrap: break-word; overflow-wrap: break-word;">
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
                <!-- Enhanced full description with proper text wrapping -->
                <div class="max-w-full text-sm leading-relaxed text-gray-600 break-words overflow-wrap-anywhere word-break-break-all"
                    style="max-width: 100%; word-wrap: break-word; overflow-wrap: break-word;">
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
            <?php if (!$hasProfile): ?>
                <!-- Profile Incomplete -->
                <a href="?page=complete-jobseeker-profile"
                    class="flex-1 px-4 py-3 text-sm font-medium text-center text-white transition-colors bg-gray-600 rounded-lg hover:bg-gray-700">
                    <i class="mr-1 fas fa-user-edit"></i>
                    Complete Profile to Apply
                </a>

            <?php elseif (isset($selectedJob['has_applied']) && $selectedJob['has_applied'] === true): ?>
                <?php if (isset($selectedJob['is_finalized']) && $selectedJob['is_finalized'] == 0): ?>
                    <div class="flex flex-col flex-1 gap-2">
                        <a href="?page=apply-job&job_id=<?php echo $selectedJob['job_id']; ?>&application_id=<?php echo $selectedJob['application_id']; ?>&step=<?php echo $selectedJob['current_step'] ?? 1; ?>"
                            class="flex items-center justify-center px-4 py-3 text-sm font-medium text-white transition-colors rounded-lg bg-primary hover:bg-primary/90">
                            <i class="mr-2 fas fa-play"></i>
                            Continue Application
                        </a>
                    </div>

                <?php else: ?>
                    <!-- Complete Application - Show Status Button -->
                    <div class="flex flex-col flex-1 gap-2">
                        <a href="?page=view-application&application_id=<?php echo $selectedJob['application_id']; ?>"
                            class="flex items-center justify-center px-4 py-3 text-sm font-medium text-white transition-colors rounded-lg bg-primary hover:bg-primary/90">

                            <!-- Status Icon -->
                            <div class="flex items-center justify-center w-5 h-5 mr-2">
                                <?php
                                switch ($selectedJob['application_status']) {
                                    case 'pending':
                                        echo '<svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                              </svg>';
                                        break;
                                    case 'reviewed':
                                        echo '<svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                              </svg>';
                                        break;
                                    case 'shortlisted':
                                        echo '<svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/>
                                              </svg>';
                                        break;
                                    case 'hired':
                                        echo '<svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                              </svg>';
                                        break;
                                    case 'rejected':
                                        echo '<svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                              </svg>';
                                        break;
                                    default:
                                        echo '<svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                              </svg>';
                                }
                                ?>
                            </div>

                            <!-- Status Text -->
                            <span class="text-sm font-medium text-white">
                                <?php
                                switch ($selectedJob['application_status']) {
                                    case 'pending':
                                        echo 'Pending Review';
                                        break;
                                    case 'reviewed':
                                        echo 'Under Review';
                                        break;
                                    case 'shortlisted':
                                        echo 'Shortlisted';
                                        break;
                                    case 'hired':
                                        echo 'Hired';
                                        break;
                                    case 'rejected':
                                        echo 'Not Selected';
                                        break;
                                    default:
                                        echo 'View Application';
                                }
                                ?>
                            </span>
                        </a>
                    </div>
                <?php endif; ?>

            <?php else: ?>
                <!-- No Application - Show Apply Button -->
                <a href="?page=apply-job&job_id=<?php echo $selectedJob['job_id']; ?>&step=1"
                    class="flex-1 px-4 py-3 text-sm font-medium text-center text-white transition-colors rounded-lg bg-primary hover:bg-primary/90">
                    <i class="mr-1 fas fa-paper-plane"></i>
                    Apply Now
                </a>
            <?php endif; ?>

            <!-- View Full Details Button - Keep as secondary style -->
            <a href="?page=view-job&job_id=<?php echo $selectedJob['job_id']; ?>"
                class="flex-1 px-4 py-3 text-sm font-medium text-center transition-colors bg-white border rounded-lg text-primary border-primary hover:bg-primary/5">
                <i class="mr-1 fas fa-external-link-alt"></i>
                View Full Details
            </a>
        </div>


    </div>
</div>

<style>
    /* CRITICAL: Scope all styles to the specific AJAX container only - EXCLUDE BUTTONS */
    #job-details-container .overflow-hidden.bg-white.border.border-gray-200.shadow-sm.rounded-xl {
        width: 100% !important;
        max-width: 100% !important;
        overflow: hidden !important;
        box-sizing: border-box !important;
    }

    /* Force strict width on the main container but EXCLUDE button containers */
    #job-details-container .overflow-hidden.bg-white.border.border-gray-200.shadow-sm.rounded-xl *:not(button):not(.flex.items-center.flex-shrink-0.gap-2.p-2):not(.flex.w-full.gap-3.mt-8):not(.flex-1.px-4.py-3):not(a.flex-1):not(a.flex.items-center) {
        max-width: 100% !important;
        box-sizing: border-box !important;
    }

    /* CRITICAL: Header section width control - AJAX only */
    #job-details-container .p-8.rounded-t-lg.bg-gray-50 {
        width: 100% !important;
        max-width: 100% !important;
        overflow: hidden !important;
        box-sizing: border-box !important;
    }

    /* CRITICAL: Main flex container - AJAX only but EXCLUDE button areas */
    #job-details-container .flex.items-start.justify-between.min-w-0:not(.flex.w-full.gap-3.mt-8) {
        width: 100% !important;
        max-width: 100% !important;
        min-width: 0 !important;
        overflow: hidden !important;
        box-sizing: border-box !important;
    }

    /* CRITICAL: Text container width enforcement - AJAX only - EXCLUDE buttons */
    #job-details-container .flex-1.min-w-0:not(.flex-1.px-4.py-3):not(a.flex-1) {
        min-width: 0 !important;
        flex: 1 !important;
        overflow: hidden !important;
        width: 0 !important;
        /* Force flex shrinking */
        max-width: 100% !important;
    }

    /* Enhanced truncation - AJAX only - EXCLUDE button text */
    #job-details-container .truncate:not(button .truncate):not(.flex-1.px-4.py-3 .truncate) {
        overflow: hidden !important;
        text-overflow: ellipsis !important;
        white-space: nowrap !important;
        display: block !important;
        max-width: 100% !important;
        width: 100% !important;
    }

    /* CRITICAL: Job title specific targeting */
    #job-details-container h2.text-xl.font-bold.text-grayMain {
        width: 100% !important;
        max-width: 100% !important;
        overflow: hidden !important;
    }

    #job-details-container h2.text-xl.font-bold.text-grayMain .truncate {
        max-width: 100% !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
        white-space: nowrap !important;
    }

    /* CRITICAL: Company name link specific targeting */
    #job-details-container a.block.font-normal.text-gray-600 {
        width: 100% !important;
        max-width: 100% !important;
        overflow: hidden !important;
    }

    #job-details-container a.block.font-normal.text-gray-600 .truncate {
        max-width: 100% !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
        white-space: nowrap !important;
    }

    /* CRITICAL: Location text specific targeting */
    #job-details-container .flex.items-center.min-w-0.transition-colors.duration-300 .truncate {
        max-width: 100% !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
        white-space: nowrap !important;
    }

    /* CRITICAL: Job summary and description - AJAX only - EXCLUDE button text */
    #job-details-container .break-words.overflow-wrap-anywhere.word-break-break-all:not(button *):not(.flex-1.px-4.py-3 *) {
        word-wrap: break-word !important;
        word-break: break-word !important;
        overflow-wrap: break-word !important;
        max-width: 100% !important;
        width: 100% !important;
        overflow: hidden !important;
        box-sizing: border-box !important;
        /* Emergency breaking for very long strings */
        hyphens: auto !important;
        -webkit-hyphens: auto !important;
        -ms-hyphens: auto !important;
        /* Force line breaking for URLs and long strings */
        word-break: break-all !important;
        overflow-wrap: anywhere !important;
        -webkit-line-break: anywhere !important;
        line-break: anywhere !important;
    }

    /* Section controls - AJAX only - EXCLUDE button sections */
    #job-details-container .mb-6:not(.flex.w-full.gap-3.mt-8) {
        width: 100% !important;
        max-width: 100% !important;
        overflow: hidden !important;
        box-sizing: border-box !important;
    }

    /* Card body - AJAX only */
    #job-details-container .p-8:not(button) {
        width: 100% !important;
        max-width: 100% !important;
        overflow: hidden !important;
        box-sizing: border-box !important;
    }

    /* All flex containers - AJAX only - EXCLUDE button containers */
    #job-details-container .flex.items-start.justify-between:not(.flex.w-full.gap-3.mt-8),
    #job-details-container .flex.items-center.flex-1.min-w-0.space-x-4:not(.flex.w-full.gap-3.mt-8),
    #job-details-container .flex.items-center:not(.flex.items-center.flex-shrink-0.gap-2.p-2):not(.flex.w-full.gap-3.mt-8):not(.flex.items-center.justify-center),
    #job-details-container .flex.items-center.justify-between.mt-4:not(.flex.w-full.gap-3.mt-8) {
        min-width: 0 !important;
        overflow: hidden !important;
        width: 100% !important;
        max-width: 100% !important;
    }

    /* Force all text elements - AJAX only - EXCLUDE button elements */
    #job-details-container h2:not(button h2):not(.flex-1.px-4.py-3 h2),
    #job-details-container h3:not(button h3):not(.flex-1.px-4.py-3 h3),
    #job-details-container p:not(button p):not(.flex-1.px-4.py-3 p),
    #job-details-container span:not(button span):not(.flex-1.px-4.py-3 span):not(.flex.w-full.gap-3.mt-8 span),
    #job-details-container div:not(button div):not(.flex-1.px-4.py-3 div):not(.flex.w-full.gap-3.mt-8 div):not(.flex.items-center.flex-shrink-0.gap-2.p-2 div) {
        word-wrap: break-word !important;
        overflow-wrap: break-word !important;
        max-width: 100% !important;
        overflow: hidden !important;
        box-sizing: border-box !important;
    }

    /* Logo container - AJAX only */
    #job-details-container .w-16.h-16.flex-shrink-0 {
        width: 4rem !important;
        height: 4rem !important;
        flex-shrink: 0 !important;
        min-width: 4rem !important;
        max-width: 4rem !important;
    }

    /* PRESERVE: Action buttons container - DO NOT MODIFY */
    #job-details-container .flex.items-center.flex-shrink-0.gap-2.p-2 {
        /* Keep original button container styles */
    }

    #job-details-container .flex.items-center.flex-shrink-0.gap-2.p-2 button {
        /* Keep original button styles */
    }

    /* PRESERVE: Action buttons section - DO NOT MODIFY */
    #job-details-container .flex.w-full.gap-3.mt-8 {
        /* Keep original action button section styles */
    }

    #job-details-container .flex.w-full.gap-3.mt-8 a {
        /* Keep original action button link styles */
    }

    #job-details-container .flex.w-full.gap-3.mt-8 .flex-1 {
        /* Keep original action button flex styles */
    }

    /* Tags section - AJAX only - but EXCLUDE if inside buttons */
    #job-details-container .flex.flex-wrap.items-center.gap-2:not(.flex.w-full.gap-3.mt-8 .flex.flex-wrap.items-center.gap-2) {
        overflow: hidden !important;
        max-width: 100% !important;
        flex-wrap: wrap !important;
    }

    #job-details-container .flex.flex-wrap.items-center.gap-2:not(.flex.w-full.gap-3.mt-8 .flex.flex-wrap.items-center.gap-2) span {
        flex-shrink: 0 !important;
        max-width: 120px !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
        white-space: nowrap !important;
    }

    /* Skills section - AJAX only - but EXCLUDE if inside buttons */
    #job-details-container .flex.flex-wrap.gap-2:not(.flex.w-full.gap-3.mt-8 .flex.flex-wrap.gap-2) {
        overflow: hidden !important;
        max-width: 100% !important;
        flex-wrap: wrap !important;
    }

    #job-details-container .flex.flex-wrap.gap-2:not(.flex.w-full.gap-3.mt-8 .flex.flex-wrap.gap-2) span {
        flex-shrink: 0 !important;
        max-width: 140px !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
        white-space: nowrap !important;
    }

    /* Timeline grid - AJAX only */
    #job-details-container .grid.grid-cols-1.gap-4.sm\:grid-cols-2 {
        width: 100% !important;
        max-width: 100% !important;
        overflow: hidden !important;
        grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)) !important;
    }

    #job-details-container .grid.grid-cols-1.gap-4.sm\:grid-cols-2>div {
        min-width: 0 !important;
        overflow: hidden !important;
    }

    /* Text content safety - AJAX only - EXCLUDE button text */
    #job-details-container .text-sm.leading-relaxed.text-gray-600:not(button .text-sm):not(.flex-1.px-4.py-3 .text-sm) {
        overflow-wrap: break-word !important;
        word-break: break-word !important;
        hyphens: auto !important;
        max-width: 100% !important;
        width: 100% !important;
        /* Emergency breaking */
        word-break: break-all !important;
        overflow-wrap: anywhere !important;
        -webkit-line-break: anywhere !important;
        line-break: anywhere !important;
    }

    /* Section headers - AJAX only */
    #job-details-container .text-lg.font-semibold.text-grayMain:not(button .text-lg) {
        max-width: 100% !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
        white-space: nowrap !important;
    }

    /* PRESERVE: Button text and icons - DO NOT MODIFY */
    #job-details-container button,
    #job-details-container button *,
    #job-details-container .flex-1.px-4.py-3,
    #job-details_container .flex-1.px-4.py-3 *,
    #job-details-container a.flex-1,
    #job-details-container a.flex-1 *,
    #job-details-container .flex.w-full.gap-3.mt-8 a,
    #job-details-container .flex.w-full.gap-3.mt-8 a * {
        /* Preserve all original button styles */
    }

    /* Responsive controls - AJAX only - EXCLUDE buttons */
    @media (max-width: 768px) {
        #job-details-container .truncate:not(button .truncate):not(.flex-1.px-4.py-3 .truncate) {
            max-width: 180px !important;
        }

        #job-details-container .text-sm.leading-relaxed.text-gray-600:not(button .text-sm):not(.flex-1.px-4.py-3 .text-sm) {
            font-size: 0.8125rem !important;
            line-height: 1.5 !important;
        }

        #job-details-container .flex.items-center.justify-between.mt-4:not(.flex.w-full.gap-3.mt-8) {
            flex-direction: column !important;
            align-items: flex-start !important;
            gap: 0.75rem !important;
        }

        #job-details-container .text-xl.font-bold.text-grayMain:not(button .text-xl) {
            font-size: 1.125rem !important;
        }
    }

    @media (max-width: 640px) {
        #job-details-container .truncate:not(button .truncate):not(.flex-1.px-4.py-3 .truncate) {
            max-width: 140px !important;
        }

        #job-details-container .p-8:not(button) {
            padding: 1.5rem !important;
        }

        /* PRESERVE: Keep button layout unchanged on mobile */
        #job-details-container .flex.w-full.gap-3.mt-8 {
            /* Keep original responsive behavior */
        }

        #job-details-container .flex.w-full.gap-3.mt-8 a {
            /* Keep original responsive behavior */
        }
    }

    @media (max-width: 480px) {
        #job-details-container .truncate:not(button .truncate):not(.flex-1.px-4.py-3 .truncate) {
            max-width: 100px !important;
        }

        #job-details-container .w-16.h-16.flex-shrink-0 {
            width: 3rem !important;
            height: 3rem !important;
            min-width: 3rem !important;
            max-width: 3rem !important;
        }

        #job-details-container .text-xl.font-bold.text-grayMain:not(button .text-xl) {
            font-size: 1rem !important;
        }
    }

    /* CRITICAL: Emergency container safety */
    #job-details-container {
        width: 100% !important;
        max-width: 100% !important;
        overflow: hidden !important;
        box-sizing: border-box !important;
    }
</style>