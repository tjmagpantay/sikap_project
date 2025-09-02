<section id="popular-jobs" class="px-4 py-20 bg-white sm:px-6 md:px-16 lg:px-24">
  <div class="mx-auto max-w-7xl">
    <div class="flex items-start justify-between mb-8">
      <div class="flex flex-col">
        <h2 class="mb-4 text-4xl font-bold leading-tight text-grayMain sm:text-4xl lg:text-4xl">
          Top Jobs for You to Explore
        </h2>

        <p class="text-sm leading-relaxed text-gray-600">
          Check out the most popular and in-demand job opportunities that <br> could be the perfect fit your career.
        </p>
      </div>

      <a href="?page=view-all-companies"
        class="flex items-center gap-1 px-6 py-2 font-medium bg-transparent border *:border-primary text-primary text-sm mt-6">
        View All
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
      </a>

    </div>

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3">
      <?php
      $jobs = [
        [
          "title" => "Technical Support Specialist",
          "type" => "part-time",
          "salary" => "Php20,000 - Php25,000",
          "company" => "Google Inc.",
          "location" => "Dhaka, Bangladesh",
          "urgent" => false,
          "category" => "IT Support",
          "posted_date" => "2024-08-15"
        ],
        [
          "title" => "Technical Support Specialist",
          "type" => "full-time",
          "salary" => "Php30,000 - Php50,000",
          "company" => "Atlassian Inc.",
          "location" => "Manila, Philippines",
          "urgent" => true,
          "category" => "Software",
          "posted_date" => "2024-08-18"
        ],
        [
          "title" => "Factory Worker",
          "type" => "part-time",
          "salary" => "Php20,000 - Php25,000",
          "company" => "Lipton Inc.",
          "location" => "Rosario, Batangas",

          "urgent" => false,
          "category" => "Manufacturing",
          "posted_date" => "2024-08-10"
        ],
        [
          "title" => "Manager",
          "type" => "full-time",
          "salary" => "Php30,000 - Php35,000",
          "company" => "Mc Donalds",
          "location" => "Rosario, Batangas",
          "logo" => "logo",
          "urgent" => true,
          "category" => "Management",
          "posted_date" => "2024-08-19"
        ],
        [
          "title" => "Service Crew",
          "type" => "part-time",
          "salary" => "Php12,000 - Php15,000",
          "company" => "Greenwich",
          "location" => "Rosario, Batangas",
          "logo" => "logo",
          "urgent" => false,
          "category" => "Food Service",
          "posted_date" => "2024-08-12"
        ],
        [
          "title" => "Security Guard",
          "type" => "part-time",
          "salary" => "Php18,000 - Php20,000",
          "company" => "Watsons",
          "location" => "Rosario, Batangas",
          "logo" => "logo",
          "urgent" => false,
          "category" => "Security",
          "posted_date" => "2024-08-14"
        ]
      ];

      foreach ($jobs as $job): ?>
        <div class="p-6 transition-all border border-gray-200 rounded-lg cursor-pointer hover:border-primary hover:shadow-md job-card"
          onclick="viewJobDetails('<?php echo $job['title']; ?>')">

          <!-- Row 1: Business Profile + Job Title + Business Name + Urgent + Saved Icon -->
          <div class="flex items-start justify-between">
            <div class="flex items-start gap-2">
              <!-- Business Profile Image -->
              <div class="flex items-center justify-center p-1 overflow-hidden rounded-md w-9 h-9 ">
                <img src="./assets/images/google-hero-img.png"
                  alt="<?php echo $job['company']; ?> Logo"
                  class="object-cover w-full h-full">
              </div>

              <!-- Job Title and Business Name -->
              <div>
                <h3 class="text-base font-medium leading-tight text-gray-900"><?php echo htmlspecialchars($job['title']); ?></h3>
                <p class="text-sm text-gray-600"><?php echo htmlspecialchars($job['company']); ?></p>
              </div>
            </div>

            <div class="flex items-center ">
              <!-- Urgent Badge (if applicable) -->
              <?php if ($job['urgent']): ?>
                <span class="px-2 py-1 text-xs text-white rounded bg-primary">
                  Urgent
                </span>
              <?php endif; ?>

            </div>
          </div>

          <!-- Row 2: Location with Icon -->
          <div class="flex items-center py-2">
            <!-- Location Marker SVG Icon -->
            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
            <span class="ml-1.5 text-sm text-gray-600"><?php echo htmlspecialchars($job['location']); ?></span>
          </div>

          <!-- Row 4: Tags for Job Info -->
          <div class="flex items-center gap-2 mb-4">
            <!-- Job Type Tag -->
            <span class="px-3 py-2 text-xs bg-gray-100 rounded-sm text-primary">
              <?php echo htmlspecialchars(ucfirst($job['type'])); ?>
            </span>

            <!-- Job Category -->
            <span class="px-3 py-2 text-xs bg-gray-100 rounded-sm text-primary">
              <?php echo htmlspecialchars($job['category']); ?>
            </span>
          </div>

          <!-- Row 5: Posted Date + Best Matches Info -->
          <div class="flex items-center justify-between text-xs text-gray-400">
            <span>
              Posted <?php echo date('M j, Y', strtotime($job['posted_date'])); ?>
            </span>

            <span class="flex items-center gap-1 text-primary">
              Best Match:

              <!-- Smaller Circle with check -->
              <span class="flex items-center justify-center w-4 h-4 rounded-full bg-primary">
                <svg xmlns="http://www.w3.org/2000/svg"
                  class="w-2.5 h-2.5"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="white"
                  stroke-width="">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
              </span>

              <span class="text-sm font-medium text-primary">95%</span>
            </span>


          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<script>
  function viewJobDetails(jobTitle) {
    // For landing page users, redirect to login if not authenticated
    // You can customize this behavior based on your requirements
    alert('Please register or login to view job details for: ' + jobTitle);
    // window.location.href = '?page=login';
  }

  function handleSaveJob(jobTitle) {
    // For landing page users, redirect to registration
    alert('Please register or login to save jobs: ' + jobTitle);
    // window.location.href = '?page=register';
  }
</script>