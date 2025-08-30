<?php
include_once __DIR__ . '/components/jobseeker_auth_check.php';
include_once __DIR__ . '/../components/navbar-top.php';
include_once __DIR__ . '/navbar-jobseeker.php';
?>

<div class="min-h-screen sm:px-6 md:px-16 lg:px-24 ">
    <div class="py-8 mx-auto sm:px-2 md:px-4 lg:px-12 max-w-7xl">
        <!-- Hero Section with Background -->
        <div class="relative px-6 py-4 overflow-hidden rounded-lg sm:px-8 sm:py-12 lg:px-12 lg:py-16">
            <!-- Background Image and Gradient Overlay (below content) -->
            <div class="absolute inset-0 z-0 rounded-t-xl">
                <img src="assets/images/header-bg.png"
                    alt="Hero Background"
                    class="object-cover w-full h-full opacity-20 rounded-t-xl"
                    onerror="this.style.display='none'">
                <div class="absolute inset-0 rounded-t-xl"
                    style="background: color #F8F8FA; opacity: 0.85;">
                </div>
            </div>

            <!-- Hero Content Only -->
            <div class="relative z-10 flex flex-col max-w-5xl gap-6 mx-auto rounded-t-xl" style="min-height:70px;">
                <div class="flex flex-col items-start justify-start flex-1 h-full md:items-start md:justify-start">
                    <p class="max-w-2xl mt-2 text-xs leading-relaxed text-center text-white md:text-left sm:mt-3 sm:text-xs">
                        LEARN HOW TO GET STARTED
                    </p>
                    <h1 class="w-full mb-1 text-xl font-bold text-white text-start sm:text-3xl lg:text-4xl md:w-auto md:text-left">
                        Sikap 101 will guide you through the <br> basics of the platform
                    </h1>

                </div>
            </div>
        </div>

        <!-- Job Filtering Section - Same Width as Hero, White Background -->
        <div class="relative py-4 mb-6 sm:px-8 lg:px-12 ">
            <div class="flex flex-col max-w-5xl gap-6 mx-auto">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:gap-4">

                    <!-- Search Jobs (Much Wider) -->
                    <div class="flex-1 lg:!flex-[5] lg:!max-w-none lg:!min-w-0">
                        <div class="flex items-center gap-3 px-4 py-3 transition-all bg-white border border-gray-300 rounded-sm focus-within:ring-2 focus-within:ring-primary/20 focus-within:border-primary hover:border-primary/50">
                            <input type="text" id="jobSearch"
                                placeholder="Search Jobs"
                                class="flex-1 text-sm text-gray-800 placeholder-gray-500 bg-transparent border-none outline-none focus:ring-0">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Location Filter -->
                    <div class="flex-1 lg:flex-none lg:w-32">
                        <div class="relative" x-data="{ open: false, selected: 'Location' }">
                            <button @click="open = !open"
                                @click.away="open = false"
                                class="flex items-center justify-between w-full px-3 py-3 text-sm text-gray-700 transition-all duration-200 bg-white border border-gray-300 rounded-sm appearance-none shadow-smm hover:border-primary/50 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
                                <span x-text="selected" class="text-gray-500 truncate"></span>
                                <svg class="w-4 h-4 ml-2 transition-transform duration-200 text-primary" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <!-- Dropdown Menu -->
                            <div x-show="open"
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                class="absolute left-0 z-50 w-full mt-2 bg-white rounded-lg shadow-lg ring-1 ring-black ring-opacity-5"
                                x-cloak>
                                <div class="py-1">
                                    <button @click="selected = 'Location'; open = false; filterByLocation('')"
                                        class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                        All Locations
                                    </button>
                                    <button @click="selected = 'Manila'; open = false; filterByLocation('manila')"
                                        class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                        Manila
                                    </button>
                                    <button @click="selected = 'Quezon City'; open = false; filterByLocation('quezon-city')"
                                        class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                        Quezon City
                                    </button>
                                    <button @click="selected = 'Makati'; open = false; filterByLocation('makati')"
                                        class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                        Makati
                                    </button>
                                    <button @click="selected = 'Taguig'; open = false; filterByLocation('taguig')"
                                        class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                        Taguig
                                    </button>
                                    <button @click="selected = 'Pasig'; open = false; filterByLocation('pasig')"
                                        class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                        Pasig
                                    </button>
                                    <button @click="selected = 'Cebu'; open = false; filterByLocation('cebu')"
                                        class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                        Cebu
                                    </button>
                                    <button @click="selected = 'Davao'; open = false; filterByLocation('davao')"
                                        class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                        Davao
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Industry Filter -->
                    <div class="flex-1 lg:flex-none lg:w-32">
                        <div class="relative" x-data="{ open: false, selected: 'Industry' }">
                            <button @click="open = !open"
                                @click.away="open = false"
                                class="flex items-center justify-between w-full px-3 py-3 text-sm text-gray-700 transition-all duration-200 bg-white border border-gray-300 rounded-sm shadow-sm appearance-none hover:border-primary/50 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
                                <span x-text="selected" class="text-gray-500 truncate"></span>
                                <svg class="w-4 h-4 ml-2 transition-transform duration-200 text-primary" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <!-- Dropdown Menu -->
                            <div x-show="open"
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                class="absolute left-0 z-50 w-full mt-2 bg-white rounded-lg shadow-lg ring-1 ring-black ring-opacity-5"
                                x-cloak>
                                <div class="py-1">
                                    <button @click="selected = 'Industry'; open = false; filterByIndustry('')"
                                        class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                        All Industries
                                    </button>
                                    <button @click="selected = 'Technology'; open = false; filterByIndustry('technology')"
                                        class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                        Technology
                                    </button>
                                    <button @click="selected = 'Healthcare'; open = false; filterByIndustry('healthcare')"
                                        class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                        Healthcare
                                    </button>
                                    <button @click="selected = 'Education'; open = false; filterByIndustry('education')"
                                        class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                        Education
                                    </button>
                                    <button @click="selected = 'Finance'; open = false; filterByIndustry('finance')"
                                        class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                        Finance
                                    </button>
                                    <button @click="selected = 'Retail'; open = false; filterByIndustry('retail')"
                                        class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                        Retail
                                    </button>
                                    <button @click="selected = 'Manufacturing'; open = false; filterByIndustry('manufacturing')"
                                        class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                        Manufacturing
                                    </button>
                                    <button @click="selected = 'Hospitality'; open = false; filterByIndustry('hospitality')"
                                        class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                        Hospitality
                                    </button>
                                    <button @click="selected = 'Construction'; open = false; filterByIndustry('construction')"
                                        class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                        Construction
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Workplace Filter -->
                    <div class="flex-1 lg:flex-none lg:w-32">
                        <div class="relative" x-data="{ open: false, selected: 'Workplace' }">
                            <button @click="open = !open"
                                @click.away="open = false"
                                class="flex items-center justify-between w-full px-3 py-3 text-sm text-gray-700 transition-all duration-200 bg-white border border-gray-300 rounded-sm shadow-sm appearance-none hover:border-primary/50 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
                                <span x-text="selected" class="text-gray-500 truncate"></span>
                                <svg class="w-4 h-4 ml-2 transition-transform duration-200 text-primary" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <!-- Dropdown Menu -->
                            <div x-show="open"
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                class="absolute left-0 z-50 w-full mt-2 bg-white rounded-lg shadow-lg ring-1 ring-black ring-opacity-5"
                                x-cloak>
                                <div class="py-1">
                                    <button @click="selected = 'Workplace'; open = false; filterByWorkplace('')"
                                        class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                        All Types
                                    </button>
                                    <button @click="selected = 'On-site'; open = false; filterByWorkplace('on-site')"
                                        class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                        On-site
                                    </button>
                                    <button @click="selected = 'Remote'; open = false; filterByWorkplace('remote')"
                                        class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                        Remote
                                    </button>
                                    <button @click="selected = 'Hybrid'; open = false; filterByWorkplace('hybrid')"
                                        class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                        Hybrid
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Apply Filter Button -->
                    <div class="flex gap-2 lg:flex-shrink-0">
                        <button type="button" id="clearFilters"
                            class="px-6 py-3 text-sm font-medium text-white transition-all rounded-md shadow-sm bg-primary hover:bg-primary/90 focus:ring-2 focus:ring-primary/50 hover:shadow-md whitespace-nowrap">
                            Apply Filter
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Dashboard Content -->
        <div class="flex flex-col gap-6 lg:flex-row">
            <!-- Left Side - Job Cards -->
            <div class="w-full lg:!w-1/3 lg:max-w-md">
                <div class="">
                    <div>
                        <p class="text-lg font-semibold text-grayMain">Jobs you might like</p>
                    </div>
                    <!-- Filter Buttons -->
                    <div class="flex items-start w-full mb-2 border-b border-gray-200">
                        <button class="flex-1 py-4 text-sm font-medium transition-colors border-b-2 text-grayMain border-primary active-filter"
                            data-filter="all" onclick="filterJobs('all', this)">
                            <div class="flex flex-col items-start">
                                <span>All Jobs
                                    <span class="text-xs font-normal text-gray-400 whitespace-nowrap">(2 jobs)</span> </span>
                            </div>
                        </button>

                        <button class="flex-1 py-4 text-sm font-medium text-gray-400 transition-colors border-b-2 border-transparent hover:text-grayMain hover:border-primary"
                            data-filter="recent" onclick="filterJobs('recent', this)">
                            <div class="flex flex-col items-center">
                                <span>Most Recent</span>
                            </div>
                        </button>

                        <button class="flex-1 py-4 text-sm font-medium text-gray-400 transition-colors border-b-2 border-transparent hover:text-grayMain hover:border-primary"
                            data-filter="matches" onclick="filterJobs('matches', this)">
                            <div class="flex flex-col items-end w-full text-right">
                                <span>Best Matches</span>
                            </div>
                        </button>

                    </div>
                    <!-- Job Post Card -->
                    <div class="overflow-y-auto " style="max-height: 600px; ">
                        <?php if (!empty($jobs)): ?>
                            <div class="space-y-6">
                                <?php foreach ($jobs as $job): ?>
                                    <div class="relative p-6 transition-all duration-300 ease-in-out transform border border-gray-200 rounded-lg cursor-pointer hover:border-primary hover:shadow-lg hover:-translate-y-1 hover:scale-[1.02] left-job-card <?php echo (isset($_GET['job_id']) && $_GET['job_id'] == $job['job_id'] ? 'border-primary bg-primary/5 shadow-md' : 'hover:bg-gray-50'); ?>"
                                        onclick="loadJobDetails(<?php echo $job['job_id']; ?>, this)"
                                        data-job-id="<?php echo $job['job_id']; ?>"
                                        style="transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);">

                                        <!-- Row 1: Business Profile + Job Title + Business Name + Urgent Tag -->
                                        <div class="flex items-start justify-between gap-2">
                                            <div class="flex items-center flex-1 gap-2">
                                                <!-- Business Profile Image -->
                                                <div class="flex items-center justify-center w-12 h-12 p-1 overflow-hidden transition-transform duration-300 border border-gray-200 rounded-md hover:scale-105">
                                                    <?php if (!empty($job['business_logo'])): ?>
                                                        <img src="<?php echo htmlspecialchars($job['business_logo']); ?>"
                                                            alt="<?php echo htmlspecialchars($job['company_name'] ?? 'Company'); ?> Logo"
                                                            class="object-cover w-full h-full">
                                                    <?php else: ?>
                                                        <i class="text-white fas fa-building"></i>
                                                    <?php endif; ?>
                                                </div>

                                                <!-- Job Title and Business Name -->
                                                <div class="flex-1">
                                                    <h3 class="text-base font-semibold leading-tight text-gray-900 transition-colors duration-300 hover:text-primary"><?php echo htmlspecialchars($job['job_title']); ?></h3>
                                                    <p class="text-sm text-gray-500 transition-colors duration-300"><?php echo htmlspecialchars($job['company_name'] ?? $job['business_name'] ?? ''); ?></p>
                                                </div>
                                            </div>

                                            <!-- Right side: Save button + Urgent Tag -->
                                            <div class="flex items-center flex-shrink-0 gap-2 mt-2">
                                                <span class="px-2 py-1 text-xs font-medium text-white transition-all duration-300 rounded-sm bg-primary hover:bg-primary/90 hover:shadow-sm">
                                                    Urgent
                                                </span>
                                            </div>
                                        </div>

                                        <!-- Row 2: Location with Icon -->
                                        <div class="flex items-center py-2 transition-colors duration-300">
                                            <!-- Location Marker SVG Icon -->
                                            <svg class="w-5 h-5 text-gray-500 transition-colors duration-300 hover:text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            <span class="ml-2 text-sm text-gray-600 transition-colors duration-300"><?php echo htmlspecialchars($job['location']); ?></span>
                                        </div>

                                        <!-- Row 4: Tags for Job Info -->
                                        <div class="flex items-center gap-2 mb-4">
                                            <!-- Job Type Tag -->
                                            <span class="px-3 py-2 text-xs transition-all duration-300 bg-gray-100 rounded-sm text-primary hover:bg-primary hover:text-white hover:shadow-sm">
                                                <?php echo htmlspecialchars(ucfirst($job['job_type'])); ?>
                                            </span>

                                            <!-- Job Category -->
                                            <?php if (!empty($job['category_name'])): ?>
                                                <span class="px-3 py-2 text-xs transition-all duration-300 bg-gray-100 rounded-sm text-primary hover:bg-primary hover:text-white hover:shadow-sm">
                                                    <?php echo htmlspecialchars($job['category_name']); ?>
                                                </span>
                                            <?php endif; ?>

                                            <!-- Applied Status -->
                                            <?php if (isset($job['has_applied']) && $job['has_applied']): ?>
                                                <span class="flex items-center px-3 py-2 text-xs transition-all duration-300 bg-gray-100 rounded-sm text-primary hover:bg-green-100 hover:text-green-700">
                                                    <!-- Checkmark SVG -->
                                                    <svg class="w-3 h-3 mr-1 transition-colors duration-300 text-primary" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    Applied
                                                </span>
                                            <?php endif; ?>
                                        </div>

                                        <!-- Row 5: Posted Date + Best Matches Info -->
                                        <div class="flex items-center justify-between text-xs text-gray-400 transition-colors duration-300">
                                            <span class="transition-colors duration-300 hover:text-gray-600">
                                                Posted <?php echo date('M j, Y', strtotime($job['created_at'])); ?>
                                            </span>

                                            <span class="flex items-center gap-1 transition-all duration-300 text-primary hover:text-primary/80">
                                                Best Matches: <span class="text-gray-500 transition-colors duration-300">1 to 10</span>

                                                <!-- Smaller Circle with check -->
                                                <span class="flex items-center justify-center w-4 h-4 transition-all duration-300 rounded-full bg-primary hover:bg-primary/90 hover:scale-110">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="w-2.5 h-2.5 transition-transform duration-300"
                                                        fill="none"
                                                        viewBox="0 0 24 24"
                                                        stroke="white"
                                                        stroke-width="">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                </span>

                                                <span class="text-sm font-medium transition-colors duration-300 text-primary hover:text-primary/80">95%</span>
                                            </span>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="p-8 text-center">
                                <i class="mx-auto text-4xl text-gray-300 fas fa-briefcase"></i>
                                <p class="mt-2 text-gray-500">No jobs available</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Right Side - Job Details Preview -->
            <div class="w-full lg:!w-2/3 lg:min-w-0 lg:flex-1">
                <!-- AJAX Container for job details -->
                <div id="job-details-container">
                    <!-- Default State - Will be replaced by auto-loaded latest job -->
                    <div class="flex flex-col items-center justify-center h-full p-8 text-center bg-white border border-gray-200 shadow-sm rounded-xl">
                        <div class="w-12 h-12 mb-4 border-b-2 rounded-full animate-spin border-primary"></div>
                        <p class="text-gray-500">Loading latest job...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        // Auto-load latest job when page loads
        document.addEventListener('DOMContentLoaded', function() {
            // Check if there are any jobs available
            const firstJobCard = document.querySelector('.left-job-card[data-job-id]');

            if (firstJobCard) {
                // Get the first job ID (latest job)
                const latestJobId = firstJobCard.getAttribute('data-job-id');

                // Auto-load the latest job details
                loadJobDetails(latestJobId, firstJobCard, true);
            } else {
                // No jobs available - show empty state
                const container = document.getElementById('job-details-container');
                container.innerHTML = `
                    <div class="flex flex-col items-center justify-center h-full p-8 text-center bg-white border border-gray-200 shadow-sm rounded-xl">
                        <i class="text-5xl text-gray-300 fas fa-briefcase"></i>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">No jobs available</h3>
                        <p class="mt-1 text-xs text-gray-500">Check back later for new job opportunities</p>
                    </div>
                `;
            }

            // Initialize other functionality
            initializeSearchAndFilters();
        });

        // AJAX function to load job details (updated with auto-load support)
        function loadJobDetails(jobId, cardElement, isAutoLoad = false) {
            console.log('Loading job details for ID:', jobId, 'Auto-load:', isAutoLoad);

            // Show loading state
            const container = document.getElementById('job-details-container');
            container.innerHTML = `
                <div class="flex flex-col items-center justify-center h-full p-8 text-center bg-white border border-gray-200 shadow-sm rounded-xl">
                    <div class="w-12 h-12 mb-4 border-b-2 rounded-full animate-spin border-primary"></div>
                    <p class="text-gray-500">${isAutoLoad ? 'Loading latest job...' : 'Loading job details...'}</p>
                </div>
            `;

            // Only update card styling if not auto-loading
            if (!isAutoLoad) {
                // Update active card styling
                document.querySelectorAll('.left-job-card').forEach(card => {
                    card.classList.remove('border-primary', 'bg-primary/5');
                    card.classList.add('border-gray-200');
                });
            }

            // Set active card (whether auto-load or manual click)
            if (cardElement) {
                cardElement.classList.remove('border-gray-200');
                cardElement.classList.add('border-primary', 'bg-primary/5');
            }

            // Make AJAX request
            const url = `?page=get-job-details-ajax&job_id=${jobId}`;
            console.log('Making AJAX request to:', url);

            fetch(url, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    console.log('Response status:', response.status);
                    console.log('Response headers:', response.headers);

                    // Handle different HTTP status codes
                    if (response.status === 404) {
                        throw new Error('Job not found');
                    } else if (response.status === 500) {
                        throw new Error('Server error occurred');
                    } else if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }

                    // Check content type
                    const contentType = response.headers.get('content-type');
                    if (!contentType || !contentType.includes('application/json')) {
                        return response.text().then(text => {
                            console.error('Expected JSON but got:', text);
                            throw new Error('Server returned non-JSON response');
                        });
                    }

                    return response.json();
                })
                .then(data => {
                    console.log('Parsed response data:', data);

                    if (data.success) {
                        container.innerHTML = data.html;

                        // Force refresh of any event listeners on the new content
                        setTimeout(() => {
                            // Re-attach any event listeners if needed
                            const saveButtons = container.querySelectorAll('button[onclick*="toggleSaveJob"]');
                            saveButtons.forEach(btn => {
                                // Ensure the button has the correct state
                                const icon = btn.querySelector('i');
                                if (icon) {
                                    // Force a visual refresh
                                    btn.style.opacity = '0.9';
                                    setTimeout(() => {
                                        btn.style.opacity = '1';
                                    }, 10);
                                }
                            });
                        }, 100);

                        // Show success message only for manual clicks, not auto-loads
                        if (!isAutoLoad) {
                            console.log('Job details loaded successfully');
                        }
                    } else {
                        container.innerHTML = `
                        <div class="flex flex-col items-center justify-center h-full p-8 text-center bg-white border border-gray-200 shadow-sm rounded-xl">
                            <i class="text-5xl text-red-300 fas fa-exclamation-triangle"></i>
                            <h3 class="mt-4 text-lg font-medium text-gray-900">Error loading job details</h3>
                            <p class="mt-1 text-xs text-gray-500">${data.message || 'Please try again'}</p>
                        </div>
                    `;
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error);

                    // For auto-load errors, show a more user-friendly message
                    const errorMessage = isAutoLoad ? 'Welcome! Select a job to view details' : 'Connection Error';
                    const errorIcon = isAutoLoad ? 'fas fa-briefcase' : 'fas fa-exclamation-triangle';
                    const errorDescription = isAutoLoad ? 'Click on any job from the list to see its full details' : 'Please check your connection and try again';

                    container.innerHTML = `
                    <div class="flex flex-col items-center justify-center h-full p-8 text-center bg-white border border-gray-200 shadow-sm rounded-xl">
                        <i class="text-5xl ${isAutoLoad ? 'text-gray-300' : 'text-red-300'} ${errorIcon}"></i>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">${errorMessage}</h3>
                        <p class="mt-1 text-xs text-gray-500">${errorDescription}</p>
                        ${!isAutoLoad ? `
                            <p class="mt-2 text-xs text-red-500">Error: ${error.message}</p>
                            <button onclick="loadJobDetails(${jobId}, this.closest('.left-job-card') || cardElement)" 
                                    class="px-4 py-2 mt-3 text-xs text-white rounded bg-primary hover:bg-primary/90">
                                Retry
                            </button>
                        ` : ''}
                    </div>
                `;
                });
        }

        // Initialize search and filters functionality
        function initializeSearchAndFilters() {
            // Real-time search with debounce
            const searchInput = document.getElementById('jobSearch');
            if (searchInput) {
                searchInput.addEventListener('input', debounce(applyAllFilters, 300));
            }

            // Clear filters button
            const clearButton = document.getElementById('clearFilters');
            if (clearButton) {
                clearButton.addEventListener('click', clearAllFilters);
            }
        }

        // Updated toggleSaveJob function with better error handling and real-time updates
        function toggleSaveJob(jobId, button) {
            console.log('Toggling save for job:', jobId);

            // Get current state from button
            const icon = button.querySelector('i');
            const currentlySaved = icon.classList.contains('fas');

            // Show loading state
            const originalIcon = icon.className;
            const originalTitle = button.title;
            const originalClasses = button.className;

            icon.className = 'text-sm fas fa-spinner fa-spin';
            button.disabled = true;

            // Prepare form data
            const formData = new FormData();
            formData.append('job_id', jobId);

            // Choose endpoint based on current state
            const endpoint = currentlySaved ? '?page=unsave-job' : '?page=save-job';

            fetch(endpoint, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    console.log('Response status:', response.status);
                    console.log('Response headers:', response.headers.get('content-type'));

                    // Check if response is ok
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }

                    // Check if response is JSON
                    const contentType = response.headers.get('content-type');
                    if (!contentType || !contentType.includes('application/json')) {
                        return response.text().then(text => {
                            console.error('Expected JSON but got:', text);
                            throw new Error('Server returned non-JSON response');
                        });
                    }

                    return response.json();
                })
                .then(data => {
                    console.log('Save/unsave response:', data);

                    if (data.success) {
                        // Update button state immediately
                        if (currentlySaved) {
                            // Was saved, now unsaved
                            icon.className = 'text-sm far fa-bookmark';
                            button.title = 'Save job';
                            button.className = 'flex items-center justify-center w-8 h-8 transition-colors border border-gray-400 rounded-lg text-primary bg-gray-50 hover:bg-gray-100';
                            showToast('Job removed from saved jobs', 'success');
                        } else {
                            // Was not saved, now saved
                            icon.className = 'text-sm fas fa-bookmark';
                            button.title = 'Remove from saved';
                            button.className = 'flex items-center justify-center w-8 h-8 transition-colors border border-gray-400 rounded-lg text-yellow-500 bg-yellow-50 border-yellow-300 hover:bg-gray-100 text-primary';
                            showToast('Job saved successfully', 'success');
                        }

                        // Force the UI to refresh immediately
                        button.style.display = 'none';
                        button.offsetHeight; // Trigger reflow
                        button.style.display = 'flex';

                    } else {
                        // Restore original state on error
                        icon.className = originalIcon;
                        button.title = originalTitle;
                        button.className = originalClasses;
                        showToast(data.message || 'Failed to save/unsave job', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Restore original state on error
                    icon.className = originalIcon;
                    button.title = originalTitle;
                    button.className = originalClasses;
                    showToast('Network error occurred', 'error');
                })
                .finally(() => {
                    button.disabled = false;
                });
        }

        // Enhanced showToast function
        function showToast(message, type) {
            // Remove any existing toasts first
            const existingToasts = document.querySelectorAll('.toast-notification');
            existingToasts.forEach(toast => toast.remove());

            const toast = document.createElement('div');
            toast.className = `toast-notification fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg transform transition-all duration-300 ${
                type === 'success' ? 'bg-green-500 text-primary' : 'bg-red-500 text-primary'
            }`;
            toast.textContent = message;

            // Add to DOM
            document.body.appendChild(toast);

            // Animate in
            setTimeout(() => {
                toast.style.transform = 'translateX(0)';
                toast.style.opacity = '1';
            }, 10);

            // Auto remove after 3 seconds
            setTimeout(() => {
                toast.style.transform = 'translateX(100%)';
                toast.style.opacity = '0';
                setTimeout(() => {
                    if (toast.parentNode) {
                        toast.parentNode.removeChild(toast);
                    }
                }, 300);
            }, 3000);
        }

        // Filter functionality
        function filterJobs(filterType, button) {
            // Update button states
            const filterButtons = document.querySelectorAll('[data-filter]');
            filterButtons.forEach(btn => {
                btn.classList.remove('active-filter');
                btn.classList.add('text-gray-400');
            });

            // Set active button
            button.classList.remove('text-gray-400');
            button.classList.add('active-filter');

            // Get all job cards
            const jobCards = document.querySelectorAll('.left-job-card');

            // Show all jobs first
            jobCards.forEach(card => {
                card.style.display = 'block';
            });

            // Apply filter logic
            if (filterType === 'recent') {
                // Sort by most recent (this is a simple example - you might want to implement server-side sorting)
                const jobContainer = document.querySelector('.space-y-6');
                const cards = Array.from(jobCards);

                // For demo purposes, we'll just reverse the order
                cards.reverse().forEach(card => {
                    jobContainer.appendChild(card);
                });

            } else if (filterType === 'matches') {
                // Hide jobs that don't match (this is a placeholder - implement your matching logic)
                jobCards.forEach((card, index) => {
                    // Example: show only every other job as "best match"
                    if (index % 3 !== 0) {
                        card.style.display = 'none';
                    }
                });
            }

            // Update job count
            const visibleJobs = document.querySelectorAll('.left-job-card[style="display: block"], .left-job-card:not([style*="display: none"])').length;
            const jobCountElement = document.querySelector('.text-gray-400');
            if (jobCountElement && filterType === 'all') {
                jobCountElement.textContent = `(${visibleJobs} jobs)`;
            }

            // Auto-load first visible job after filtering
            const firstVisibleJob = document.querySelector('.job-card[style="display: block"], .left-job-card:not([style*="display: none"])');
            if (firstVisibleJob) {
                const jobId = firstVisibleJob.getAttribute('data-job-id');
                loadJobDetails(jobId, firstVisibleJob, true);
            }
        }

        // Filter functions for the new dropdown system
        function filterByLocation(location) {
            applyAllFilters();
        }

        function filterByJobType(jobType) {
            applyAllFilters();
        }

        function filterByIndustry(industry) {
            applyAllFilters();
        }

        function filterByWorkplace(workplace) {
            applyAllFilters();
        }

        // Apply all filters function
        function applyAllFilters() {
            const searchTerm = document.getElementById('jobSearch').value.toLowerCase().trim();

            // Get selected values from dropdowns
            const selectedLocation = getDropdownValue('Location');
            const selectedJobType = getDropdownValue('Job Type');
            const selectedIndustry = getDropdownValue('Industry');
            const selectedWorkplace = getDropdownValue('Workplace');

            const jobCards = document.querySelectorAll('.left-job-card');
            let visibleCount = 0;
            let firstVisibleCard = null;

            jobCards.forEach(card => {
                let shouldShow = true;

                // Search filter (job title, company name)
                if (searchTerm) {
                    const jobTitle = card.querySelector('h3').textContent.toLowerCase();
                    const companyName = card.querySelector('p').textContent.toLowerCase();
                    if (!jobTitle.includes(searchTerm) && !companyName.includes(searchTerm)) {
                        shouldShow = false;
                    }
                }

                // Location filter
                if (selectedLocation && selectedLocation !== 'Location' && shouldShow) {
                    const locationText = card.querySelector('.text-gray-600').textContent.toLowerCase();
                    if (!locationText.includes(selectedLocation.toLowerCase())) {
                        shouldShow = false;
                    }
                }

                // Job type filter
                if (selectedJobType && selectedJobType !== 'Job Type' && shouldShow) {
                    const jobTypeElement = card.querySelector('.text-primary');
                    if (jobTypeElement && !jobTypeElement.textContent.toLowerCase().includes(selectedJobType.toLowerCase())) {
                        shouldShow = false;
                    }
                }

                // Industry filter
                if (selectedIndustry && selectedIndustry !== 'Industry' && shouldShow) {
                    const categoryElements = card.querySelectorAll('.text-primary');
                    let hasMatchingCategory = false;
                    categoryElements.forEach(element => {
                        if (element.textContent.toLowerCase().includes(selectedIndustry.toLowerCase())) {
                            hasMatchingCategory = true;
                        }
                    });
                    if (!hasMatchingCategory) {
                        shouldShow = false;
                    }
                }

                // Show/hide card
                if (shouldShow) {
                    card.style.display = 'block';
                    visibleCount++;
                    if (!firstVisibleCard) {
                        firstVisibleCard = card;
                    }
                } else {
                    card.style.display = 'none';
                }
            });

            // Update job count
            updateJobCount(visibleCount);

            // Show message if no results
            showNoResultsMessage(visibleCount === 0);

            // Auto-load first visible job after filtering
            if (firstVisibleCard) {
                const jobId = firstVisibleCard.getAttribute('data-job-id');
                loadJobDetails(jobId, firstVisibleCard, true);
            }
        }

        // Helper function to get selected value from dropdown
        function getDropdownValue(defaultValue) {
            const dropdowns = document.querySelectorAll(`[x-data*="'${defaultValue}'"]`);
            for (let dropdown of dropdowns) {
                const button = dropdown.querySelector('button span');
                if (button && button.textContent.trim() !== defaultValue) {
                    return button.textContent.trim();
                }
            }
            return '';
        }

        // Clear all filters
        function clearAllFilters() {
            // Reset search input
            document.getElementById('jobSearch').value = '';

            // Reset all dropdown texts to default
            const locationBtn = document.querySelector('[x-data*="Location"] button span');
            const jobTypeBtn = document.querySelector('[x-data*="Job Type"] button span');
            const industryBtn = document.querySelector('[x-data*="Industry"] button span');
            const workplaceBtn = document.querySelector('[x-data*="Workplace"] button span');

            if (locationBtn) locationBtn.textContent = 'Location';
            if (jobTypeBtn) jobTypeBtn.textContent = 'Job Type';
            if (industryBtn) industryBtn.textContent = 'Industry';
            if (workplaceBtn) workplaceBtn.textContent = 'Workplace';

            // Show all job cards
            const jobCards = document.querySelectorAll('.left-job-card');
            jobCards.forEach(card => {
                card.style.display = 'block';
            });

            updateJobCount(jobCards.length);
            showNoResultsMessage(false);

            // Auto-load first job after clearing filters
            const firstJob = document.querySelector('.left-job-card[data-job-id]');
            if (firstJob) {
                const jobId = firstJob.getAttribute('data-job-id');
                loadJobDetails(jobId, firstJob, true);
            }
        }

        // Update job count display
        function updateJobCount(count) {
            const countElements = document.querySelectorAll('.text-gray-400');
            countElements.forEach(element => {
                if (element.textContent.includes('jobs')) {
                    element.textContent = `(${count} jobs)`;
                }
            });
        }

        // Show/hide no results message
        function showNoResultsMessage(show) {
            let noResultsMessage = document.getElementById('noResultsMessage');
            const container = document.getElementById('job-details-container');

            if (show && !noResultsMessage) {
                // Show no results message in the job details container
                container.innerHTML = `
                    <div class="flex flex-col items-center justify-center h-full p-8 text-center bg-white border border-gray-200 shadow-sm rounded-xl">
                        <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 005.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0012 15c-2.137 0-4.146-.832-5.657-2.343"></path>
                        </svg>
                        <h3 class="mb-2 text-lg font-medium text-gray-900">No jobs found</h3>
                        <p class="text-sm text-gray-500">Try adjusting your filters or search terms</p>
                        <button onclick="clearAllFilters()" 
                                class="px-4 py-2 mt-4 text-sm text-white rounded bg-primary hover:bg-primary/90">
                            Clear Filters
                        </button>
                    </div>
                `;
            }
        }

        // Debounce function for search input
        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }
    </script>
</div>