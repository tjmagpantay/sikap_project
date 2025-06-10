<section class="bg-[#F1F8FF] px-6 py-20">
  <div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl sm:text-4xl font-bold text-primary mb-4">Top Companies</h2>
      <a href="#" class="btn-outline flex items-center gap-1">
        View All
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
      </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
      <?php
        $companies = [
          [
            "logo" => "watsons.png",
            "name" => "Watsons",
            "location" => "Rosario, Batangas",
            "positions" => 1
          ],
          [
            "logo" => "mcdonalds.png",
            "name" => "Mc Donalds",
            "location" => "Rosario, Batangas",
            "positions" => 4
          ],
          [
            "logo" => "atlassian.png",
            "name" => "Atlassian",
            "location" => "Rosario, Batangas",
            "positions" => 2
          ],
          [
            "logo" => "lipton.png",
            "name" => "Lipton Inc.",
            "location" => "Rosario, Batangas",
            "positions" => 3
          ]
        ];

        foreach ($companies as $company): ?>
          <div class="company-card p-6 min-h-[400px] flex flex-col justify-between">
            <div>
              <div class="company-header">
                <img src="assets/logos/<?php echo $company['logo']; ?>" alt="<?php echo $company['name']; ?>" class="w-8 h-8 rounded-md">
                <span class="company-badge">Featured</span>
              </div>
              <h2 class="company-name"><?php echo $company['name']; ?></h2>
              <p class="company-location">📍 <?php echo $company['location']; ?></p>
              <p class="company-description">
                Description: Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod.
              </p>
              <a href="#" class="company-link">View details...</a>
            </div>
            <button class="company-button mt-2">Open Position (<?php echo $company['positions']; ?>)</button>
          </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
