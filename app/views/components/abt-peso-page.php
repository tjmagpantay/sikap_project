<!-- Mission & Vision Section -->
<section id="mission" class="px-4 py-20 bg-gradient-to-br from-gray-50 via-blue-50/30 to-white sm:px-6 md:px-16 lg:px-24">
    <div class="mx-auto max-w-7xl">
        <div class="grid items-center gap-12 md:grid-cols-2">
            <!-- Left Content Section -->
            <div class="flex flex-col">
                <!-- Title -->
                <h6 class="mb-2 text-lg font-semibold text-secondary">Our Mission & Vision</h6>
                <h2 class="mb-6 text-3xl font-bold leading-tight text-primary lg:text-4xl">
                    Connecting Dreams with Opportunities
                </h2>

                <!-- Description -->
                <p class="mb-8 text-sm leading-relaxed text-gray-600">
                    Learn about our commitment to providing sustainable employment and strengthening employment facilitation services for our community.
                </p>

                <!-- Tab Navigation -->
                <div class="w-full mb-8">
                    <nav class="flex flex-wrap gap-2 mb-6" role="tablist">
                        <button type="button"
                            class="px-4 py-2 text-sm font-medium text-white rounded-lg bg-primary tabs-link active"
                            onclick="showTab('mission')" id="tab-mission">
                            Our Mission
                        </button>
                        <button type="button"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-primary hover:text-white tabs-link"
                            onclick="showTab('vision')" id="tab-vision">
                            Our Vision
                        </button>
                    </nav>

                    <!-- Tab Content -->
                    <div class="space-y-6">
                        <div class="tabs-content" id="content-mission">
                            <div class="relative px-4 py-4 text-sm transition-all duration-300 bg-white border border-gray-200 rounded-lg sm:px-6 group hover:border-primary hover:shadow-md">
                                <p class="leading-relaxed text-gray-600">
                                    To provide continuous and sustainable employment to all, to strengthen the existing employment facilitation services both local and overseas through the establishment of concrete system and mechanism to effectively address the concern of their constituents information system.
                                </p>
                            </div>
                        </div>
                        <div class="hidden tabs-content" id="content-vision">
                            <div class="relative px-4 py-4 text-sm transition-all duration-300 bg-white border border-gray-200 rounded-lg sm:px-6 group hover:border-primary hover:shadow-md">
                                <p class="leading-relaxed text-gray-600">
                                    Identification and development of strong workforce led by pro-active and integrity driven leaders that provides suitable job opportunities and updated labor market information.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Image Section - Hidden below 640px -->
            <div id="mission-image" class="relative items-center justify-center hidden p-4 sm:block">
                <!-- Background gradient overlay -->
                <div class="absolute inset-0 transition-transform duration-300 transform rounded-xl bg-gradient-to-br from-primary/20 via-secondary/20 to-primary/20 hover:scale-105"></div>

                <!-- Main image container -->
                <div class="relative flex items-center justify-center overflow-hidden shadow-xl rounded-xl bg-gradient-to-br from-white to-gray-50 min-h-[300px]">
                    <img src="assets/images/abt-peso1.png"
                        alt="PESO Rosario Team"
                        class="object-cover transition-opacity duration-300 w-90% h-90% hover:opacity-90">


                    <div class="absolute p-4 bg-white rounded-lg shadow-lg -bottom-4 -right-4">
                        <div class="flex items-center space-x-3">
                            <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-secondary">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h11-2zm2 4h-2v2h2V9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xl font-bold text-primary">100+</p>
                                <p class="text-xs text-gray-600">Companies</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    /* Initial state - hidden (image only) */
    #mission-image {
        opacity: 0;
        transform: translateX(100px);
        transition: all 0.8s ease-out;
    }

    /* Animated state - visible (image only) */
    #mission-image.animate-in {
        opacity: 1;
        transform: translateX(0);
    }

    /* Tab content animation */
    .tabs-content {
        transition: opacity 0.3s ease;
    }
</style>

<script>
    // Tab switching function
    function showTab(tabName) {
        // Hide all tab contents
        document.querySelectorAll('.tabs-content').forEach(content => {
            content.classList.add('hidden');
        });

        // Remove active class from all tabs
        document.querySelectorAll('.tabs-link').forEach(tab => {
            tab.classList.remove('active', 'bg-primary', 'text-white');
            tab.classList.add('bg-gray-100', 'text-gray-700');
        });

        // Show selected tab content
        document.getElementById('content-' + tabName).classList.remove('hidden');

        // Activate selected tab
        document.getElementById('tab-' + tabName).classList.add('active', 'bg-primary', 'text-white');
        document.getElementById('tab-' + tabName).classList.remove('bg-gray-100', 'text-gray-700');
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Create intersection observer for image animation
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    // Animate only the image
                    const image = document.getElementById('mission-image');
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

        // Start observing the mission section
        const missionSection = document.getElementById('mission');
        if (missionSection) {
            observer.observe(missionSection);
        }
    });
</script>