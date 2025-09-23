<!-- Mission & Vision Section -->
<section id="mission" class="relative w-full px-4 py-24 bg-white sm:px-6 md:px-16 lg:px-24">
    <div class="w-full mx-auto max-w-7xl">
        <div class="grid grid-cols-1 gap-12 lg:grid-cols-2 lg:gap-16">
            <!-- Mission Content -->
            <div class="flex justify-center flex-csol">
                <div class="mb-8">
                    <h6 class="mb-2 text-lg font-semibold text-secondary">Our Mission & Vision</h6>
                    <h2 class="mb-6 text-3xl font-bold text-primary lg:text-4xl">
                        Connecting Dreams with Opportunities
                    </h2>
                </div>

                <!-- Static Tab Navigation -->
                <div class="tabs">
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

                    <!-- Tab Content (only this part changes) -->
                    <div>
                        <div class="tabs-content" id="content-mission">
                            <p class="mb-4 leading-relaxed text-gray-600">
                                To provide continuous and sustainable employment to all, to strengthen the existing employment facilitation services both local and overseas through the establishment of concrete system and mechanism to effectively address the concern of their constituents information system.
                            </p>
                        </div>
                        <div class="hidden tabs-content" id="content-vision">
                            <p class="mb-4 leading-relaxed text-gray-600">
                                Identification and development of strong workforce led by pro-active and integrity driven leaders that provides suitable job opportunities and updated labor market information.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Image/Visual Content (unchanged) -->
            <div class="flex items-center justify-center">
                <div class="relative max-w-lg">
                    <img src="assets/images/abt-peso.png"
                        alt="PESO Rosario Team"
                        class="w-full shadow-lg rounded-xl">

                    <!-- Floating Stats Cards -->
                    <div class="absolute p-4 bg-white rounded-lg shadow-lg -top-4 -left-4">
                        <div class="flex items-center space-x-3">
                            <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-primary">
                                <i class="text-white fas fa-users"></i>
                            </div>
                            <div>
                                <p class="text-xl font-bold text-primary">500+</p>
                                <p class="text-xs text-gray-600">Job Seekers</p>
                            </div>
                        </div>
                    </div>

                    <div class="absolute p-4 bg-white rounded-lg shadow-lg -bottom-4 -right-4">
                        <div class="flex items-center space-x-3">
                            <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-secondary">
                                <i class="text-white fas fa-building"></i>
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