<?php
// Get top companies data
require_once __DIR__ . '/../../controllers/LandingPageController.php';
$landingController = new LandingPageController();
$companies = $landingController->getTopCompanies(4);
?>

<section id="top-companies" class="px-6 py-20 bg-gray-50 sm:px-6 md:px-16 lg:px-24">
  <div class="mx-auto max-w-7xl">
    <div class="flex items-start justify-between mb-8">
      <div class="flex flex-col">
        <h2 class="mb-4 text-4xl font-bold leading-tight text-grayMain sm:text-4xl lg:text-4xl">
          Top Employers and Businesses
        </h2>

        <p class="text-sm leading-relaxed text-gray-600">
          Discover the top employers and businesses that are making waves in their industries.
        </p>
      </div>

      <a href="?page=view-all-companies"
        class="hidden md:flex items-center gap-1 px-6 py-2 font-medium bg-transparent border *:border-primary text-primary text-sm mt-6">
        View All
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
      </a>

    </div>
    <?php if (!empty($companies)): ?>
      <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3">
        <?php
        $displayCount = 0;
        foreach ($companies as $company):
          $displayCount++;
          $hideClass = $displayCount > 3 ? 'hidden' : '';
        ?>
          <div class="overflow-hidden transition-all duration-200 bg-white border border-gray-200 rounded-xl cursor-pointer hover:border-primary hover:shadow-lg hover:scale-[1.02] h-[480px] flex flex-col transform <?php echo $hideClass; ?>"
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

            </div>

            <!-- Job Content -->
            <div class="flex flex-col flex-1 px-6">
              <!-- Company Content -->
              <div class="flex flex-col flex-1">
                <?php if (!empty($company['business_address'])): ?>
                  <div class="flex items-center gap-2 mb-4 text-sm text-gray-600">
                    <p class="text-sm text-primary "> Location:
                      <span class="text-sm font-normal text-gray-600"><?php echo htmlspecialchars($company['business_address']); ?></span>
                    </p>

                  </div>
                <?php endif; ?>

                <p class="mb-4 text-sm text-gray-600 line-clamp-3">
                  <?php if (!empty($company['business_desc'])): ?>
                    <?php echo htmlspecialchars($company['business_desc']); ?>
                  <?php else: ?>
                    Professional services company in <?php echo htmlspecialchars($company['business_industry'] ?? 'various industries'); ?>
                  <?php endif; ?>
                </p>

                <!-- Social Media Links (if available) -->
                <?php if (!empty($company['facebook_url']) || !empty($company['twitter_url']) || !empty($company['instagram_url']) || !empty($company['youtube_url'])): ?>
                  <div class="flex flex-wrap gap-2 mb-4">
                    <?php if (!empty($company['facebook_url'])): ?>
                      <a href="<?php echo htmlspecialchars($company['facebook_url']); ?>"
                        target="_blank"
                        class="flex items-center justify-center gap-1 px-2 py-2 transition-all duration-200 transform h-7 text-primary bg-blue-50 hover:bg-blue-100 hover:scale-105"
                        onclick="event.stopPropagation();">
                        <!-- Facebook SVG -->
                        <svg class="flex-shrink-0" width="14" height="14" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                          <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                        </svg>
                        <p class="text-xs text-primary">Facebook</p>
                      </a>
                    <?php endif; ?>

                    <?php if (!empty($company['twitter_url'])): ?>
                      <a href="<?php echo htmlspecialchars($company['twitter_url']); ?>"
                        target="_blank"
                        class="flex items-center justify-center gap-1 px-2 py-2 transition-all duration-200 transform h-7 text-primary bg-blue-50 hover:bg-blue-100 hover:scale-105"
                        onclick="event.stopPropagation();">
                        <!-- Twitter/X SVG -->
                        <svg class="flex-shrink-0" width="14" height="14" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                          <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                        </svg>
                        <p class="text-xs text-primary">Twitter</p>
                      </a>
                    <?php endif; ?>

                    <?php if (!empty($company['instagram_url'])): ?>
                      <a href="<?php echo htmlspecialchars($company['instagram_url']); ?>"
                        target="_blank"
                        class="flex items-center justify-center gap-1 px-2 py-2 transition-all duration-200 transform h-7 text-primary bg-blue-50 hover:bg-blue-100 hover:scale-105"
                        onclick="event.stopPropagation();">
                        <!-- Instagram SVG -->
                        <svg class="flex-shrink-0" width="14" height="14" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                          <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 6.62 5.367 11.987 11.988 11.987s11.987-5.367 11.987-11.987C24.014 5.367 18.647.001 12.017.001zM8.449 16.988c-1.297 0-2.448-.393-3.433-1.035-.985-.642-1.594-1.507-1.829-2.594-.235-1.088-.235-2.246 0-3.334.235-1.087.844-1.952 1.829-2.594.985-.642 2.136-1.035 3.433-1.035s2.448.393 3.433 1.035c.985.642 1.594 1.507 1.829 2.594.235 1.088.235 2.246 0 3.334-.235 1.087-.844 1.952-1.829 2.594-.985.642-2.136 1.035-3.433 1.035z" />
                          <path d="M12 16c-2.209 0-4-1.791-4-4s1.791-4 4-4 4 1.791 4 4-1.791 4-4 4zm0-6c-1.105 0-2 .895-2 2s.895 2 2 2 2-.895 2-2-.895-2-2-2z" />
                          <circle cx="16.5" cy="7.5" r="1.5" />
                          <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073z" />
                        </svg>
                        <p class="text-xs text-primary">Instagram</p>
                      </a>
                    <?php endif; ?>

                    <?php if (!empty($company['youtube_url'])): ?>
                      <a href="<?php echo htmlspecialchars($company['youtube_url']); ?>"
                        target="_blank"
                        class="flex items-center justify-center gap-1 px-2 py-2 transition-all duration-200 transform h-7 text-primary bg-blue-50 hover:bg-blue-100 hover:scale-105"
                        onclick="event.stopPropagation();">
                        <!-- YouTube SVG -->
                        <svg class="flex-shrink-0" width="14" height="14" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                          <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                        </svg>
                        <p class="text-xs text-primary">YouTube</p>
                      </a>
                    <?php endif; ?>
                  </div>
                <?php endif; ?>
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
    line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }
</style>

<script>
  function viewCompany(employerId) {
      window.location.href = '?page=login-jobseeker';
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