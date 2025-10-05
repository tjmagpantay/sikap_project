<!-- Section 1: Smart Job Matching - Image on Right -->
<section id="smart-matching" class="px-4 py-16 sm:px-6 md:px-16 lg:px-24">
    <div class="mx-auto max-w-7xl">
        <div class="grid items-center gap-16 md:grid-cols-2 lg:gap-20">
            <!-- Left Content Section -->
            <div class="space-y-6">
                <div class="space-y-3">
                    <h6 class="text-lg font-medium text-secondary">Innovation in Hiring</h6>
                    <h2 class="text-3xl font-bold text-primary lg:text-4xl">
                        Smart Job Matching Made Simple
                    </h2>
                </div>

                <p class="text-sm text-gray-600">
                    SIKAP makes finding and hiring talent easier than ever. Using advanced machine learning, it connects job seekers with opportunities that fit their skills, qualifications, and goals. Employers can seamlessly post openings, manage applications, and track candidates all in one efficient platform designed to simplify the entire hiring process.
                </p>

                <!-- Feature highlights -->
                <div class="flex flex-wrap gap-4 pt-4">
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full bg-primary"></div>
                        <span class="text-sm text-gray-700">AI-Powered Matching</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full bg-secondary"></div>
                        <span class="text-sm text-gray-700">Real-time Tracking</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full bg-primary"></div>
                        <span class="text-sm text-gray-700">Seamless Integration</span>
                    </div>
                </div>
            </div>

            <!-- Right Image Section -->
            <div class="flex items-center justify-center">
                <div class="w-3/5 max-w-md">
                    <img src="assets/images/abt-img-1-new.png"
                        alt="Smart Job Matching Technology"
                        class="object-cover w-full h-auto rounded-lg">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Section 2: Accessibility - Image on Left -->
<section id="accessibility" class="px-4 py-16 sm:px-6 md:px-16 lg:px-24">
    <div class="mx-auto max-w-7xl">
        <div class="grid items-center gap-16 md:grid-cols-2 lg:gap-20">
            <!-- Left Image Section -->
            <div class="flex items-start justify-start">
                <div class="w-4/5 max-w-md">
                    <img src="assets/images/abt-img-2.png"
                        alt="User-Friendly Interface"
                        class="object-cover w-full h-auto rounded-lg">
                </div>
            </div>

            <!-- Right Content Section -->
            <div class="space-y-6">
                <div class="space-y-3">
                    <h6 class="text-lg font-medium text-secondary">User Experience</h6>
                    <h2 class="text-3xl font-bold text-primary lg:text-4xl">
                        Accessible and Easy to Use
                    </h2>
                </div>

                <p class="text-sm text-gray-600">
                    SIKAP is designed to be simple, mobile-responsive, and intuitive. Job seekers, employers, and PESO staff can all navigate the platform with ease. Ensuring a smooth user experience for everyone, regardless of their technical expertise or device preferences.
                </p>

                <!-- Feature highlights -->
                <div class="flex flex-wrap gap-4 pt-4">
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full bg-secondary"></div>
                        <span class="text-sm text-gray-700">Mobile Responsive</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full bg-primary"></div>
                        <span class="text-sm text-gray-700">Intuitive Design</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full bg-secondary"></div>
                        <span class="text-sm text-gray-700">Universal Access</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

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
</script>