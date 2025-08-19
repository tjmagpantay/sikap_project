<?php
// Get top companies data
require_once __DIR__ . '/../../controllers/LandingPageController.php';
$landingController = new LandingPageController();
$companies = $landingController->getTopCompanies(4);
?>

<section class="bg-[#F1F8FF] px-6 py-20">
  <div class="mx-auto max-w-7xl">
    <div class="flex items-center justify-between mb-6">
      <h2 class="mb-4 text-3xl font-bold sm:text-4xl text-primary">Popular Jobs</h2>
      <a href="#" class="flex items-center gap-1 btn-outline">
        View All
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
      </a>
    </div>

    <?php if (!empty($companies)): ?>
      <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 md:grid-cols-4">
        <?php foreach ($companies as $company): ?>
          <div class="overflow-hidden transition-all duration-300 bg-white rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-2 h-[480px] flex flex-col"
            onclick="viewCompany(<?php echo $company['employer_id']; ?>)">

            <!-- Company Header -->
            <div class="relative flex items-start gap-4 p-6">
              <?php if (!empty($company['business_logo'])): ?>
                <div class="flex items-center justify-center flex-shrink-0 p-2 bg-white rounded-lg">
                  <img class="w-12 h-12 rounded-lg" src="<?php echo htmlspecialchars($company['business_logo']); ?>"
                    alt="<?php echo htmlspecialchars($company['business_name']); ?>"
                    class="object-contain w-full h-full">
                </div>
              <?php else: ?>
                <div class="flex items-center justify-center flex-shrink-0 w-16 h-16 bg-gray-200 rounded-lg">
                  <i class="text-2xl text-gray-400 fas fa-building"></i>
                </div>
              <?php endif; ?>

              <div class="flex-1 min-w-0">
                <h3 class="text-sm font-bold text-gray-900 "><?php echo htmlspecialchars($company['business_name']); ?></h3>
                <?php if (!empty($company['business_industry'])): ?>
                  <p class="text-xs text-gray-500 truncate ">
                    <?php echo htmlspecialchars($company['business_industry']); ?>
                  </p>
                <?php endif; ?>
              </div>

              <div>
                <!-- Bookmark Icon -->
                <button class="absolute z-10 p-4 text-gray-400 transition-colors duration-300 top-4 right-4 hover:text-yellow-400" onclick="event.stopPropagation(); saveJob(<?php echo $company['employer_id']; ?>)">
                  <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                  </svg>
                </button>
              </div>

            </div>

            <!-- Job Content -->
            <div class="flex flex-col flex-1 px-6">
              <!-- Company Content -->
              <div class="flex flex-col flex-1">
                <?php if (!empty($company['business_address'])): ?>
                  <div class="flex items-center mb-4 text-sm text-gray-500">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span class=""><?php echo htmlspecialchars($company['business_address']); ?></span>
                  </div>
                <?php endif; ?>

                <p class="mb-6 text-sm text-gray-600 line-clamp-3">
                  <?php if (!empty($company['business_desc'])): ?>
                    <?php echo htmlspecialchars($company['business_desc']); ?>
                  <?php else: ?>
                    Professional services company in <?php echo htmlspecialchars($company['business_industry'] ?? 'various industries'); ?>
                  <?php endif; ?>
                </p>
              </div>
            </div>

            <!-- Footer with separator and job count + verified status -->
            <div class="mt-auto border-t border-gray-200">
              <div class="flex items-center justify-between px-6 py-4">
                <div class="flex items-center text-sm font-medium text-primary">
                  <span><?php echo $company['active_jobs_count']; ?> Open Positions</span>
                </div>
                <?php if ($company['profile_completed'] && $company['business_completed']): ?>
                  <div class="flex items-center text-sm text-gray-500">
                    <svg class="w-5 h-5 mr-1 text-primary" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                      <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span class="font-medium text-primary">Verified</span>
                  </div>
                <?php endif; ?>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <div class="py-16 text-center bg-white rounded-xl">
        <div class="flex items-center justify-center w-24 h-24 mx-auto mb-6 text-gray-400 bg-gray-100 rounded-full">
          <i class="text-4xl fas fa-building"></i>
        </div>
        <h3 class="mb-2 text-xl font-medium text-gray-900">No Jobs Available</h3>
        <p class="max-w-md mx-auto text-gray-500">
          Jobs will appear here once companies post them. Check back soon!
        </p>
      </div>
    <?php endif; ?>
  </div>
</section>

<style>
  .line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }
</style>

<script>
  function viewCompany(employerId) {
    window.location.href = '?page=view-company&employer_id=' + employerId;
  }

  function saveJob(employerId) {
    // Add your save job functionality here
    console.log('Saving job for employer:', employerId);
    // You might want to implement AJAX call to save the job for the user
  }

  function viewAllCompanies() {
    window.location.href = '?page=view-all-companies';
  }
</script>