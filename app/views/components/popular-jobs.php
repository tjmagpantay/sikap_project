<?php
// Get popular jobs data using the controller
require_once __DIR__ . '/../../controllers/LandingPageController.php';
$landingController = new LandingPageController();
$jobs = $landingController->getPopularJobs(6);
?>

<section id="popular-jobs" class="px-4 py-20 bg-white sm:px-6 md:px-16 lg:px-24">
  <div class="mx-auto max-w-7xl">
    <div class="flex items-start justify-between mb-8">
      <div class="flex flex-col">
        <h2 class="mb-4 text-4xl font-bold leading-tight text-grayMain sm:text-4xl lg:text-4xl">
          Top Jobs for You to Explore
        </h2>

        <p class="text-sm leading-relaxed text-gray-600">
          Check out the most popular and in-demand job opportunities that could be the perfect fit your career.
        </p>
      </div>

      <a href="?page=browse-jobs"
        class="items-center hidden gap-1 px-6 py-2 mt-6 text-sm font-medium bg-transparent border md:flex border-primary text-primary">
        View All
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
      </a>

    </div>

    <?php if (!empty($jobs)): ?>
      <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3">
        <?php foreach ($jobs as $job): ?>
          <div class="p-6 transition-all border border-gray-200 rounded-lg cursor-pointer hover:border-primary hover:shadow-md job-card"
            onclick="viewJobDetails(<?php echo $job['job_id']; ?>, '<?php echo htmlspecialchars($job['job_title']); ?>')">

            <!-- Row 1: Business Profile + Job Title + Business Name + New Tag -->
            <div class="flex items-start justify-between gap-2"> <!-- Added gap-2 -->
              <div class="flex items-start flex-1 min-w-0 gap-2"> <!-- Added flex-1 min-w-0 -->
                <!-- Business Profile Image -->
                <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 p-1 overflow-hidden bg-gray-200 rounded-md"> <!-- Added flex-shrink-0 -->
                  <?php if (!empty($job['business_logo'])): ?>
                    <img src="<?php echo htmlspecialchars($job['business_logo']); ?>"
                      alt="<?php echo htmlspecialchars($job['company_name'] ?? 'Company'); ?> Logo"
                      class="object-cover w-full h-full">
                  <?php else: ?>
                    <i class="text-gray-500 fas fa-building"></i>
                  <?php endif; ?>
                </div>

                <!-- Job Title and Business Name -->
                <div class="flex-1 min-w-0"> <!-- Added flex-1 min-w-0 for proper flex truncation -->
                  <!-- Enhanced Job Title with truncation -->
                  <h3 class="text-base font-medium leading-tight text-gray-900">
                    <div class="max-w-full truncate"
                      title="<?php echo htmlspecialchars($job['job_title']); ?>"
                      style="max-width: 100%; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                      <?php echo htmlspecialchars($job['job_title']); ?>
                    </div>
                  </h3>
                  <!-- Enhanced Company Name with truncation -->
                  <p class="max-w-full text-sm text-gray-400 truncate"
                    title="<?php echo htmlspecialchars($job['company_name'] ?? ''); ?>"
                    style="max-width: 100%; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                    <?php echo htmlspecialchars($job['company_name'] ?? ''); ?>
                  </p>
                </div>
              </div>

              <div class="flex items-center flex-shrink-0"> <!-- Added flex-shrink-0 -->
                <!-- New Badge (show for recent jobs) -->
                <?php
                $isRecent = (strtotime($job['created_at']) > strtotime('-3 days'));
                if ($isRecent): ?>
                  <span class="px-2 py-1 text-xs text-white rounded bg-primary">
                    New
                  </span>
                <?php endif; ?>
              </div>
            </div>

            <!-- Row 2: Location with Icon - Enhanced with truncation -->
            <div class="flex items-center min-w-0 py-2 transition-colors duration-300">
              <!-- Location Marker SVG Icon -->
              <svg class="flex-shrink-0 w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
              </svg>
              <!-- Enhanced Location with truncation -->
              <span class="flex-1 min-w-0 ml-1.5 text-sm text-gray-600">
                <div class="max-w-full truncate"
                  title="<?php echo htmlspecialchars($job['location']); ?>"
                  style="max-width: 100%; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                  <?php echo htmlspecialchars($job['location']); ?>
                </div>
              </span>
            </div>


            <!-- Row 4: Tags for Job Info -->
            <div class="flex items-center gap-2 mb-4">
              <!-- Job Type Tag -->
              <span class="px-3 py-2 text-xs bg-gray-100 rounded-sm text-primary">
                <?php echo htmlspecialchars(ucfirst($job['job_type'])); ?>
              </span>

              <!-- Job Category -->
              <?php if (!empty($job['category_name'])): ?>
                <span class="px-3 py-2 text-xs bg-gray-100 rounded-sm text-primary">
                  <?php echo htmlspecialchars($job['category_name']); ?>
                </span>
              <?php endif; ?>
            </div>

            <!-- Row 5: Posted Date -->
            <div class="flex items-center justify-between text-xs text-gray-400">
              <span>
                Posted <?php echo date('M j, Y', strtotime($job['created_at'])); ?>
              </span>

              <!-- Application deadline if exists -->
              <?php if (!empty($job['application_deadline'])): ?>
                <span class="text-primary">
                  Deadline: <?php echo date('M j', strtotime($job['application_deadline'])); ?>
                </span>
              <?php endif; ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <div class="py-16 text-center bg-white rounded-xl">
        <div class="flex items-center justify-center w-24 h-24 mx-auto mb-6 text-gray-400 bg-gray-100 rounded-full">
          <i class="text-4xl fas fa-briefcase"></i>
        </div>
        <h3 class="mb-2 text-xl font-medium text-gray-900">No Jobs Available</h3>
        <p class="max-w-md mx-auto text-gray-500">
          Jobs will appear here once companies post them. Check back soon!
        </p>
      </div>
    <?php endif; ?>
  </div>
</section>



<script>
  function viewJobDetails(jobId, jobTitle) {
    // Use the controller method for proper handling
    <?php if (isset($_SESSION['user_id'])): ?>
      // User is logged in, redirect appropriately
      <?php if ($_SESSION['role'] == 'jobseeker'): ?>
        window.location.href = '?page=view-job&job_id=' + jobId;
      <?php else: ?>
        window.location.href = '?page=browse-jobs';
      <?php endif; ?>
    <?php else: ?>
      // User not logged in, show registration prompt
      if (confirm('Please register or login to view job details for: ' + jobTitle + '\n\nWould you like to register now?')) {
        // Store the intended destination and redirect to signup
        window.location.href = '?page=signup-jobseeker&redirect_job=' + jobId;
      }
    <?php endif; ?>
  }

  function handleSaveJob(jobTitle) {
    // For landing page users, redirect to registration
    alert('Please register or login to save jobs: ' + jobTitle);
    window.location.href = '?page=signup-jobseeker';
  }
</script>