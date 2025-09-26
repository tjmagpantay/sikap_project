<section id="steps-guide" class="px-4 py-20 bg-gradient-to-br from-gray-50 via-blue-50/30 to-white sm:px-6 md:px-16 lg:px-24">
    <div class="mx-auto max-w-7xl">
        <div class="grid items-center gap-12 md:grid-cols-2">
            <!-- Left Content Section -->
            <div class="flex flex-col">
                <!-- Title -->
                <h2 class="mb-4 text-4xl font-bold leading-tight text-grayMain sm:text-4xl lg:text-4xl">
                    Discover How to Apply for
                    <span class="block mt-2 text-grayMain">
                        Your Next Job
                    </span>
                </h2>

                <!-- Description -->
                <p class="mb-8 text-sm leading-relaxed text-gray-600 sm:mb-12">
                    Follow these simple steps to explore verified opportunities powered by PESO Rosario and start your career journey today.
                </p>

                <!-- Steps -->
                <div class="w-full mb-8 space-y-4 sm:space-y-6 sm:mb-12">
                    <!-- Step 1: Create Account -->
                    <div class="relative flex items-start gap-4 px-4 py-4 transition-all duration-300 bg-white border border-gray-200 rounded-lg sm:px-6 group hover:border-primary hover:shadow-md">
                        <!-- Connecting line -->
                        <div class="absolute hidden top-20 left-8 w-0.5 h-12 bg-primary opacity-20 sm:block"></div>

                        <!-- Circle container -->
                        <div class="relative flex items-center justify-center flex-shrink-0 w-12 h-12">
                            <div class="flex items-center justify-center w-12 h-12 border-2 border-white rounded-full shadow-lg bg-primary">
                                <span class="text-lg font-bold text-white">1</span>
                            </div>
                        </div>

                        <div class="flex-1">
                            <h3 class="mb-2 text-lg font-bold sm:text-xl text-grayMain">Create Account</h3>
                            <p class="text-sm leading-relaxed text-gray-600">
                                Set up your account as the first step toward your career journey and open the door to endless opportunities.
                            </p>
                        </div>
                    </div>

                    <!-- Step 2: Browse Job Offers -->
                    <div class="relative flex items-start gap-4 px-4 py-4 transition-all duration-300 bg-white border border-gray-200 rounded-lg sm:px-6 group hover:border-primary hover:shadow-md">
                        <!-- Connecting line -->
                        <div class="absolute hidden top-20 left-8 w-0.5 h-12 bg-primary opacity-20 sm:block"></div>

                        <!-- Circle container -->
                        <div class="relative flex items-center justify-center flex-shrink-0 w-12 h-12">
                            <div class="flex items-center justify-center w-12 h-12 transition-all duration-300 border-2 border-white rounded-full shadow-lg bg-secondary group-hover:bg-primary">
                                <span class="text-lg font-bold text-white">2</span>
                            </div>
                        </div>

                        <div class="flex-1">
                            <h3 class="mb-2 text-lg font-bold sm:text-xl text-grayMain">Browse Job Offers</h3>
                            <p class="text-sm leading-relaxed text-gray-600">
                                Explore thousands of job opportunities, discover different roles, and find positions that perfectly match your skills and aspirations.
                            </p>
                        </div>
                    </div>

                    <!-- Step 3: Apply Job -->
                    <div class="relative flex items-start gap-4 px-4 py-4 transition-all duration-300 bg-white border border-gray-200 rounded-lg sm:px-6 group hover:border-primary hover:shadow-md">
                        <!-- Circle container -->
                        <div class="relative flex items-center justify-center flex-shrink-0 w-12 h-12">
                            <div class="flex items-center justify-center w-12 h-12 transition-all duration-300 border-2 border-white rounded-full shadow-lg bg-primary group-hover:bg-secondary">
                                <span class="text-lg font-bold text-white">3</span>
                            </div>
                        </div>

                        <div class="flex-1">
                            <h3 class="mb-2 text-lg font-bold sm:text-xl text-grayMain">Apply for Jobs</h3>
                            <p class="text-sm leading-relaxed text-gray-600">
                                Submit your application with confidence and take the decisive step toward securing your dream career opportunity.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Image Section - Hidden below 640px -->
            <div id="job-guide-image" class="relative items-center justify-center hidden p-4 sm:block">
                <!-- Background gradient overlay -->
                <div class="absolute inset-0 transition-transform duration-300 transform rounded-xl bg-gradient-to-br from-primary/20 via-secondary/20 to-primary/20 hover:scale-105"></div>

                <!-- Main image container -->
                <div class="relative flex items-center justify-center overflow-hidden shadow-xl rounded-xl bg-gradient-to-br from-white to-gray-50 min-h-[300px]">
                    <img src="./assets/images/help-desk.png"
                        alt="Professional job seeker success story"
                        class="object-cover transition-opacity duration-300 w-90% h-90% hover:opacity-90">
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    /* Initial state - hidden (image only) */
    #job-guide-image {
        opacity: 0;
        transform: translateX(100px);
        transition: all 0.8s ease-out;
    }

    /* Animated state - visible (image only) */
    #job-guide-image.animate-in {
        opacity: 1;
        transform: translateX(0);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Create intersection observer
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    // Animate only the image
                    const image = document.getElementById('job-guide-image');
                    if (image) {
                        image.classList.add('animate-in');
                    }

                    // Stop observing once animated
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.2, // Trigger when 20% of the section is visible
            rootMargin: '0px 0px -100px 0px' // Start animation 100px before the section is fully visible
        });

        // Start observing the steps guide section
        const stepsSection = document.getElementById('steps-guide');
        if (stepsSection) {
            observer.observe(stepsSection);
        }
    });
</script>