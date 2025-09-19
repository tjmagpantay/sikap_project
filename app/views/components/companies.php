<section id="companies-section" class="px-4 py-20 bg-white sm:px-6 md:px-16 lg:px-24">
  <div class="mx-auto max-w-7xl">
    <div class="grid grid-cols-2 gap-8 md:grid-cols-3 lg:grid-cols-4">

      <!-- Statistic 1: Active Jobs -->
      <div class="text-center company-stat text-grayMain">
        <div class="mb-2">
          <span class="text-3xl font-bold lg:text-4xl">1,847</span>
        </div>
        <h3 class="mb-3 text-lg font-semibold">Active Jobs</h3>
        <p class="text-sm leading-relaxed text-gray-600">
          Current job openings available across various <br> industries and skill levels in our platform.
        </p>
      </div>

      <!-- Statistic 2: Verified Companies -->
      <div class="text-center company-stat text-grayMain">
        <div class="mb-2">
          <span class="text-3xl font-bold lg:text-4xl">150+</span>
        </div>
        <h3 class="mb-3 text-lg font-semibold">Verified Companies</h3>
        <p class="text-sm leading-relaxed text-gray-600">
          Trusted employers who have completed our verification process and are actively hiring.
        </p>
      </div>

      <!-- Statistic 3: Businesses Listed -->
      <div class="text-center company-stat text-grayMain">
        <div class="mb-2">
          <span class="text-3xl font-bold lg:text-4xl">500+</span>
        </div>
        <h3 class="mb-3 text-lg font-semibold">Businesses Listed</h3>
        <p class="text-sm leading-relaxed text-gray-600">
          Explore local and global businesses across diverse industries.
        </p>
      </div>

    </div>
  </div>
</section>

<style>
/* Initial state - hidden below */
.company-stat {
  opacity: 0;
  transform: translateY(50px);
  transition: all 0.8s ease-out;
}

/* Animated state - slide up */
.company-stat.animate-up {
  opacity: 1;
  transform: translateY(0);
}

/* Staggered animation delays */
.company-stat.animate-up:nth-child(1) {
  transition-delay: 0ms;
}

.company-stat.animate-up:nth-child(2) {
  transition-delay: 200ms;
}

.company-stat.animate-up:nth-child(3) {
  transition-delay: 400ms;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Create intersection observer for companies section
    const companiesObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                // Animate all company stats with staggered delays
                const companyStats = document.querySelectorAll('.company-stat');
                companyStats.forEach((stat, index) => {
                    setTimeout(() => {
                        stat.classList.add('animate-up');
                    }, index * 200); // 200ms delay between each stat
                });

                // Stop observing once animated
                companiesObserver.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.3, // Trigger when 30% of the section is visible
        rootMargin: '0px 0px -50px 0px' // Start animation 50px before the section is fully visible
    });

    // Start observing the companies section
    const companiesSection = document.getElementById('companies-section');
    if (companiesSection) {
        companiesObserver.observe(companiesSection);
    }
});
</script>
