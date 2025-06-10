<section class="px-6 py-10 bg-white">
  <div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl sm:text-4xl font-bold text-primary mb-4">Popular Jobs</h2>
      <a href="#" class="btn-outline flex items-center gap-1">
        View All
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
      </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-4">
      <?php
        $jobs = [
          [
            "title" => "Technical Support Specialist",
            "type" => "PART-TIME",
            "salary" => "Php20,000 - Php25,000",
            "company" => "Google Inc.",
            "location" => "Dhaka, Bangladesh",
            "logo" => "google.png"
          ],
          [
            "title" => "Technical Support Specialist",
            "type" => "PART-TIME",
            "salary" => "Php30,000 - Php50,000",
            "company" => "Atlassian Inc.",
            "location" => "Manila, Philippines",
            "logo" => "atlassian.png"
          ],
          [
            "title" => "Factory Worker",
            "type" => "PART-TIME",
            "salary" => "Php20,000 - Php25,000",
            "company" => "Lipton Inc.",
            "location" => "Rosario, Batangas",
            "logo" => "lipton.png"
          ],
          [
            "title" => "Manager",
            "type" => "FULL-TIME",
            "salary" => "Php30,000 - Php35,000",
            "company" => "Mc Donalds",
            "location" => "Rosario, Batangas",
            "logo" => "mcdonalds.png"
          ],
          [
            "title" => "Service Crew",
            "type" => "PART-TIME",
            "salary" => "Php12,000 - Php15,000",
            "company" => "Greenwich",
            "location" => "Rosario, Batangas",
            "logo" => "greenwich.png"
          ],
          [
            "title" => "Security Guard",
            "type" => "PART-TIME",
            "salary" => "Php18,000 - Php20,000",
            "company" => "Watsons",
            "location" => "Rosario, Batangas",
            "logo" => "watsons.png"
          ]
        ];

        foreach ($jobs as $job): ?>
          <div class="job-card">
            <div class="flex justify-between items-start mb-2">
              <h3 class="text-sm font-semibold text-gray-900"><?php echo $job['title']; ?></h3>
              <button class="text-gray-400 hover:text-blue-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
              </button>
            </div>

            <span class="job-type <?php echo strtolower($job['type']) === 'full-time' ? 'bg-blue-100 text-blue-600' : 'bg-green-100 text-green-600'; ?>">
              <?php echo $job['type']; ?>
            </span>
            <span class="text-xs text-gray-600 block mt-1 mb-2">Salary: <?php echo $job['salary']; ?></span>

            <div class="flex items-center gap-2">
              <img src="assets/logos/<?php echo $job['logo']; ?>" alt="<?php echo $job['company']; ?>" class="w-6 h-6 rounded-md">
              <div>
                <p class="text-xs font-medium text-gray-800"><?php echo $job['company']; ?></p>
                <p class="text-xs text-gray-500"><?php echo $job['location']; ?></p>
              </div>
            </div>
          </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
