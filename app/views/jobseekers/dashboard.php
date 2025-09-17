<?php
include_once __DIR__ . '/components/jobseeker_auth_check.php';
include_once __DIR__ . '/../components/navbar-top.php';
include_once __DIR__ . '/navbar-jobseeker.php';
?>

<div class="min-h-screen px-4 sm:px-6 md:px-16 lg:px-24">
    <div class="py-8 mx-auto sm:px-2 md:px-4 lg:px-12 max-w-7xl">
        <!-- Hero Section with Background -->
        <div class="relative px-6 py-4 overflow-hidden rounded-lg sm:px-8 sm:py-12 lg:px-12 lg:py-16">
            <!-- Background Image and Gradient Overlay (below content) -->
            <div class="absolute inset-0 z-0 rounded-t-xl">
                <img src="assets/images/new-header.svg"
                    alt="Hero Background"
                    class="object-cover w-full h-full opacity-20 rounded-t-xl"
                    onerror="this.style.display='none'">
                <div class="absolute inset-0 rounded-t-xl"
                    style="background: color #F8F8FA; opacity: 0.85;">
                </div>
            </div>

            <!-- Hero Content Only -->
            <div class="relative z-10 flex flex-col max-w-5xl gap-6 mx-auto rounded-t-xl" style="min-height:80px;">
                <div class="flex flex-col items-start justify-center flex-1 h-full md:items-start md:justify-center">
                    <p class="max-w-2xl mt-2 text-xs leading-relaxed text-center text-white md:text-left sm:mt-3 sm:text-xs">
                        LEARN HOW TO GET STARTED
                    </p>
                    <h1 class="w-full mb-1 text-3xl font-bold text-white text-start sm:text-3xl lg:text-4xl md:w-auto md:text-left">
                        Find your dream jobs with us
                    </h1>

                </div>
            </div>
        </div>

        <!-- Job Filtering Section - Improved responsiveness -->
        <div class="relative py-4 mb-6 sm:px-8 lg:px-12">
            <div class="flex flex-col max-w-5xl gap-6 mx-auto">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:gap-4">

                    <!-- Search Jobs - Reduced width to match left section -->
                    <div class="w-full lg:w-1/3 lg:max-w-md lg:flex-shrink-0">
                        <div class="flex items-center gap-3 px-4 py-3 transition-all bg-white border border-gray-300 rounded-sm focus-within:ring-2 focus-within:ring-primary/20 focus-within:border-primary hover:border-primary/50">
                            <input type="text" id="jobSearch"
                                placeholder="Search Jobs"
                                class="flex-1 text-sm text-gray-800 placeholder-gray-500 bg-transparent border-none outline-none focus:ring-0">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Filter Dropdowns Container - Takes remaining 2/3 space -->
                    <div class="flex flex-col w-full gap-4 lg:flex-row lg:w-2/3 lg:min-w-0">

                        <!-- Location Filter - Hidden on screens below 640px (sm) -->
                        <div class="flex-1 hidden sm:block">
                            <div class="relative w-full" x-data="{ open: false, selected: 'Location' }">
                                <button @click="open = !open"
                                    @click.away="open = false"
                                    class="flex items-center justify-between w-full px-3 py-3 text-sm text-gray-700 transition-all duration-200 bg-white border border-gray-300 rounded-sm shadow-sm appearance-none hover:border-primary/50 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
                                    <span x-text="selected" class="text-gray-500 truncate"></span>
                                    <svg class="flex-shrink-0 w-4 h-4 ml-2 transition-transform duration-200 text-primary" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                                    class="absolute left-0 z-50 w-full mt-2 bg-white rounded-lg shadow-lg ring-1 ring-black ring-opacity-5">
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

                        <!-- Industry Filter - Hidden on screens below 640px (sm) -->
                        <div class="flex-1 hidden sm:block">
                            <div class="relative w-full" x-data="{ open: false, selected: 'Industry' }">
                                <button @click="open = !open"
                                    @click.away="open = false"
                                    class="flex items-center justify-between w-full px-3 py-3 text-sm text-gray-700 transition-all duration-200 bg-white border border-gray-300 rounded-sm shadow-sm appearance-none hover:border-primary/50 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
                                    <span x-text="selected" class="text-gray-500 truncate"></span>
                                    <svg class="flex-shrink-0 w-4 h-4 ml-2 transition-transform duration-200 text-primary" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                                    class="absolute left-0 z-50 w-full mt-2 bg-white rounded-lg shadow-lg ring-1 ring-black ring-opacity-5">
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

                        <!-- Workplace Filter - Hidden on screens below 640px (sm) -->
                        <div class="flex-1 hidden sm:block">
                            <div class="relative w-full" x-data="{ open: false, selected: 'Workplace' }">
                                <button @click="open = !open"
                                    @click.away="open = false"
                                    class="flex items-center justify-between w-full px-3 py-3 text-sm text-gray-700 transition-all duration-200 bg-white border border-gray-300 rounded-sm shadow-sm appearance-none hover:border-primary/50 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
                                    <span x-text="selected" class="text-gray-500 truncate"></span>
                                    <svg class="flex-shrink-0 w-4 h-4 ml-2 transition-transform duration-200 text-primary" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                                    class="absolute left-0 z-50 w-full mt-2 bg-white rounded-lg shadow-lg ring-1 ring-black ring-opacity-5">
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
                        <div class="hidden sm:block sm:w-auto lg:flex-shrink-0 lg:self-stretch">

                            <button type="button" id="clearFilters"
                                class="w-full h-full px-6 py-3 text-sm font-medium text-white transition-all rounded-md shadow-sm bg-primary hover:bg-primary/90 focus:ring-2 focus:ring-primary/50 hover:shadow-md whitespace-nowrap sm:w-auto">
                                Apply Filter
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Dashboard Content - Fixed height issues -->
        <div class="flex flex-col gap-6 lg:flex-row lg:items-start">
            <!-- Left Side - Job Cards - Fixed height overflow -->
            <div class="w-full lg:!w-1/3 lg:max-w-md lg:flex-shrink-0">
                <div class="h-full">
                    <div>
                        <p class="mb-2 text-lg font-semibold text-grayMain">Jobs you might like</p>
                    </div>
                    <!-- Filter Buttons -->
                    <div class="flex items-start w-full mb-2 border-b border-gray-200">
                        <div class="flex items-center w-full p-1 space-x-1 rounded-lg bg-gray-50">
                            <!-- Most Recent -->
                            <button class="relative flex-1 px-4 py-2 text-sm font-medium text-gray-600 transition-all duration-200 ease-in-out rounded-md hover:text-gray-900 hover:bg-white/50"
                                data-filter="recent" onclick="filterJobs('recent', this)">
                                <span>Most Recent</span>
                            </button>

                            <!-- Best Matches -->
                            <button class="relative flex-1 px-4 py-2 text-sm font-medium text-gray-600 transition-all duration-200 ease-in-out rounded-md hover:text-gray-900 hover:bg-white/50"
                                data-filter="matches" onclick="filterJobs('matches', this)">
                                <span>Best Matches</span>
                            </button>
                        </div>
                    </div>


                    <!-- Job Post Card Container - Fixed height with proper scrolling -->
                    <div class="overflow-y-auto" style="max-height: 70vh;">
                        <?php if (!empty($jobs)): ?>
                            <div class="space-y-4">
                                <?php
                                $displayedJobs = array_slice($jobs, 0, 5); // Limit to 5 jobs
                                $totalJobs = count($jobs);
                                ?>

                                <?php foreach ($displayedJobs as $job): ?>
                                    <!-- Job cards with mobile redirect functionality -->
                                    <div class="relative p-6 transition-all duration-300 ease-in-out transform border border-gray-200 rounded-lg cursor-pointer hover:border-primary hover:shadow-lg hover:-translate-y-1 hover:scale-[1.02] left-job-card <?php echo (isset($_GET['job_id']) && $_GET['job_id'] == $job['job_id'] ? 'border-primary bg-primary/5 shadow-md' : 'hover:bg-gray-50'); ?>"
                                        onclick="handleJobCardClick(<?php echo $job['job_id']; ?>, this)"
                                        data-job-id="<?php echo $job['job_id']; ?>"
                                        data-posted-date="<?php echo strtotime($job['created_at']); ?>"
                                        data-match-percentage="<?php echo $job['match_percentage'] ?? 0; ?>"
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
                                                Best Matches:

                                                <?php
                                                $matchPercentage = $job['match_percentage'] ?? 50;
                                                $hasRealRecommendation = $job['has_recommendation'] ?? false;
                                                $isLowMatch = $matchPercentage < 20;
                                                ?>

                                                <!-- UPDATED: Real Match Percentage with Color Coding -->
                                                <span class="text-sm font-medium transition-colors duration-300 hover:text-primary/80">
                                                    <?= number_format($matchPercentage, 1) ?>%
                                                </span>


                                                <!-- Low Match Warning Icon (Optional - only if you want it here too) -->
                                                <?php if ($isLowMatch): ?>
                                                    <div class="relative ml-1 group">
                                                        <svg class="w-3 h-3 text-gray-400 cursor-help" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>

                                                        <!-- Mini Tooltip for Dashboard -->
                                                        <div class="absolute right-0 z-50 px-2 py-1 mb-2 text-xs text-white transition-opacity duration-200 bg-gray-800 rounded shadow-lg opacity-0 pointer-events-none bottom-full group-hover:opacity-100 whitespace-nowrap">
                                                            <div class="text-center">
                                                                <div class="text-yellow-300">⚠️ Low Match</div>
                                                                <div class="text-gray-300">Improve profile</div>
                                                            </div>
                                                            <div class="absolute w-0 h-0 border-t-2 border-l-2 border-r-2 border-transparent top-full right-2 border-t-gray-800"></div>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>

                                                <!-- Smaller Circle with check (unchanged) -->
                                                <span class="flex items-center justify-center w-5 h-5 transition-all duration-300 rounded-full hover:scale-110">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="#10364B">
                                                        <path d="M14.01 21c-.49 0-.95-.23-1.33-.43-.24-.12-.53-.27-.68-.27s-.47.15-.7.27c-.48.25-1.08.55-1.72.38-.66-.17-1.02-.75-1.34-1.21-.13-.21-.31-.49-.43-.56-.12-.07-.44-.08-.71-.1-.54-.03-1.21-.06-1.7-.53-.48-.49-.51-1.16-.54-1.7-.01-.26-.03-.59-.07-.71-.06-.11-.35-.29-.55-.43-.46-.3-1.03-.67-1.21-1.31-.17-.64.13-1.24.38-1.72.12-.24.27-.53.27-.68s-.15-.47-.27-.7c-.25-.48-.55-1.08-.38-1.72.17-.66.75-1.02 1.21-1.34.2-.13.49-.31.56-.43.07-.12.08-.44.1-.71.03-.54.06-1.21.53-1.7.49-.48 1.16-.51 1.7-.54.26-.01.59-.03.71-.07.11-.06.29-.35.43-.55.3-.46.67-1.03 1.31-1.21.64-.17 1.24.13 1.72.38.24.12.53.27.68.27s.47-.15.7-.27c.48-.25 1.08-.55 1.72-.38.66.17 1.02.75 1.34 1.21.13.21.31.49.43.56.12.07.44.08.71.1.54.03 1.21.06 1.7.53.48.49.51 1.16.54 1.7.01.26.03.59.07.71.06.11.35.29.55.43.46.3 1.03.67 1.21 1.31.17.64-.13 1.24-.38 1.72-.12.24-.27.53-.27.68s.15.47.27.7c.25.48.55 1.08.38 1.72-.17.66-.75 1.02-1.21 1.34-.2.13-.49.31-.56.43-.07.12-.08.44-.1.71-.03.54-.06 1.21-.53 1.7-.49.48-1.16.51-1.7.54-.26.01-.59.03-.71.07-.11.06-.29.35-.43.55-.3.46-.67 1.03-1.31 1.21-.13.04-.26.05-.39.05Zm-4.02-16.5c-.1.04-.33.38-.44.57-.24.37-.51.79-.94 1.04-.44.25-.94.28-1.39.3-.22.01-.63.03-.72.1-.06.08-.08.48-.09.7-.02.45-.05.95-.3 1.39-.25.44-.67.72-1.04.95-.18.11-.52.33-.56.44-.01.11.16.46.26.66.2.4.44.83.44 1.34s-.24.94-.44 1.34c-.1.2-.27.55-.26.66.04.11.38.34.56.45.37.23.79.51 1.04.95.25.44.28.94.3 1.39.01.22.03.63.1.72.08.06.48.08.7.09.45.02.95.05 1.39.3.44.25.72.67.95 1.04.11.18.33.52.44.56.11.04.46-.16.66-.26.4-.2.83-.44 1.34-.44s.94.24 1.34.44c.2.1.55.27.66.26.11-.04.34-.38.45-.56.23-.37.51-.79.95-1.04.44-.25.94-.28 1.39-.3.22-.01.63-.03.72-.1.06-.08.08-.48.09-.7.02-.45.05-.95.3-1.39.25-.44.67-.72 1.04-.95.18-.11.52-.33.56-.44.01-.11-.16-.46-.26-.66-.2-.4-.44-.83-.44-1.34s.24-.94.44-1.34c.1-.2.27-.55.26-.66-.04-.11-.38-.34-.56-.45-.37-.23-.79-.51-1.04-.95-.25-.44-.28-.94-.3-1.39-.01-.22-.03-.63-.1-.72-.08-.06-.48-.08-.7-.09-.45-.02-.95-.05-1.39-.3-.44-.25-.72-.67-.95-1.04-.11-.18-.33-.52-.44-.56-.1-.03-.45.17-.66.27-.4.2-.83.44-1.34.44s-.94-.24-1.34-.44c-.2-.1-.55-.27-.66-.27Zm.5 11.01c-.2 0-.39-.08-.53-.22l-2.54-2.53c-.29-.29-.29-.77 0-1.06.29-.29.77-.29 1.06 0l1.98 1.98 4.99-4.99c.29-.29.77-.29 1.06 0s.29.77 0 1.06l-5.52 5.52c-.14.14-.33.22-.53.22Z" />
                                                    </svg>
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                <?php endforeach; ?>

                            </div>

                            <!-- View All Jobs Link - Added below cards -->
                            <div class="py-6 text-center">
                                <a href="?page=browse-jobs"
                                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium transition-all duration-300 rounded-md text-primary hover:bg-primary hover:text-white hover:shadow-lg hover:scale-105">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                    View All Jobs
                                    <svg class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                    </svg>
                                </a>
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

            <!-- Right Side - Job Details Preview - Hidden on md and below, visible on lg+ -->
            <div class="hidden w-full lg:block lg:!w-2/3 lg:min-w-0 lg:flex-1 lg:h-auto">
                <!-- AJAX Container for job details -->
                <div id="job-details-container" class="h-full min-h-[70vh]">
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
        // New function to handle job card clicks - mobile vs desktop behavior
        function handleJobCardClick(jobId, cardElement) {
            // Check if we're on mobile (screen width less than 1024px - lg breakpoint)
            if (window.innerWidth < 1024) {
                // Mobile: Redirect to full job details page
                window.location.href = `?page=view-job&job_id=${jobId}`;
            } else {
                // Desktop: Use AJAX to load details in right panel
                loadJobDetails(jobId, cardElement, false);
            }
        }

        // Updated job filtering function - Only Most Recent and Best Matches
        function filterJobs(filterType, buttonElement) {
            console.log('Filtering by:', filterType); // Debug log

            // Update active filter button - Remove active styles from all buttons
            document.querySelectorAll('[data-filter]').forEach(btn => {
                btn.classList.remove('bg-primary', 'text-white', 'shadow-sm', 'ring-1', 'ring-gray-200');
                btn.classList.add('text-gray-600', 'hover:text-gray-900', 'hover:bg-white/50');
            });

            // Set active button with primary background and white text
            buttonElement.classList.remove('text-gray-600', 'hover:text-gray-900', 'hover:bg-white/50');
            buttonElement.classList.add('bg-primary', 'text-white', 'shadow-sm', 'ring-1', 'ring-gray-200');

            // Get all job cards
            const jobCards = document.querySelectorAll('.left-job-card');
            let sortedCards = Array.from(jobCards);

            if (filterType === 'recent') {
                // Sort by most recent (posted date)
                sortedCards.sort((a, b) => {
                    const dateA = parseInt(a.dataset.postedDate || 0);
                    const dateB = parseInt(b.dataset.postedDate || 0);
                    return dateB - dateA; // Most recent first
                });
                console.log('Sorted by recent'); // Debug log
            } else if (filterType === 'matches') {
                // Sort by best matches (match percentage)
                sortedCards.sort((a, b) => {
                    const matchA = parseFloat(a.dataset.matchPercentage || 0);
                    const matchB = parseFloat(b.dataset.matchPercentage || 0);
                    return matchB - matchA; // Highest match first
                });
                console.log('Sorted by matches'); // Debug log
            }

            // Show only top 5 jobs
            const visibleCards = sortedCards.slice(0, 5);

            // Hide all cards first
            jobCards.forEach(card => {
                card.style.display = 'none';
                card.style.order = 'unset';
            });

            // Show and reorder filtered cards
            visibleCards.forEach((card, index) => {
                card.style.display = 'block';
                card.style.order = index;
                // Add slight animation
                setTimeout(() => {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(10px)';
                    setTimeout(() => {
                        card.style.transition = 'all 0.3s ease';
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, 50);
                }, index * 50);
            });

            // Update job count
            updateJobCount(visibleCards.length);

            // Auto-select first visible job (only on desktop)
            if (visibleCards.length > 0 && window.innerWidth >= 1024) {
                const firstJobId = visibleCards[0].getAttribute('data-job-id');
                loadJobDetails(firstJobId, visibleCards[0], true);
            }
        }

        // Initialize with "Most Recent" as default - Updated to match your working code
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded, initializing filters'); // Debug log

            // Set "Most Recent" as default active with proper styling
            const recentButton = document.querySelector('[data-filter="recent"]');
            if (recentButton) {
                console.log('Setting Most Recent as default active'); // Debug log
                
                // Set initial active state
                recentButton.classList.remove('text-gray-600', 'hover:text-gray-900', 'hover:bg-white/50');
                recentButton.classList.add('bg-primary', 'text-white', 'shadow-sm', 'ring-1', 'ring-gray-200');

                // Then run the filter
                filterJobs('recent', recentButton);
            }

            // Auto-load first job on desktop only
            if (window.innerWidth >= 1024) {
                setTimeout(() => {
                    const firstJobCard = document.querySelector('.left-job-card[data-job-id]');
                    if (firstJobCard) {
                        const latestJobId = firstJobCard.getAttribute('data-job-id');
                        loadJobDetails(latestJobId, firstJobCard, true);
                    }
                }, 200);
            }

            // Initialize other functionality
            initializeSearchAndFilters();

            // Update the job count on initial load
            const visibleJobs = document.querySelectorAll('.left-job-card[data-job-id]').length;
            updateJobCount(visibleJobs);
        });
        
        // Update window resize handler to handle orientation changes
        window.addEventListener('resize', function() {
            // Clear any existing timeouts to prevent multiple calls
            clearTimeout(window.resizeTimeout);

            window.resizeTimeout = setTimeout(function() {
                // If switching from mobile to desktop, auto-load first visible job
                if (window.innerWidth >= 1024) {
                    const firstVisibleCard = document.querySelector('.left-job-card[style*="block"], .left-job-card:not([style*="none"])');
                    if (firstVisibleCard && !document.querySelector('.left-job-card.border-primary')) {
                        const jobId = firstVisibleCard.getAttribute('data-job-id');
                        loadJobDetails(jobId, firstVisibleCard, true);
                    }
                }
            }, 250);
        });

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

            // Get selected values from dropdowns (only on desktop where dropdowns are visible)
            const selectedLocation = window.innerWidth >= 640 ? getDropdownValue('Location') : '';
            const selectedJobType = '';
            const selectedIndustry = window.innerWidth >= 640 ? getDropdownValue('Industry') : '';
            const selectedWorkplace = window.innerWidth >= 640 ? getDropdownValue('Workplace') : '';

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

                // Location filter (only on desktop)
                if (selectedLocation && selectedLocation !== 'Location' && shouldShow && window.innerWidth >= 640) {
                    const locationText = card.querySelector('.text-gray-600').textContent.toLowerCase();
                    if (!locationText.includes(selectedLocation.toLowerCase())) {
                        shouldShow = false;
                    }
                }

                // Industry filter (only on desktop)
                if (selectedIndustry && selectedIndustry !== 'Industry' && shouldShow && window.innerWidth >= 640) {
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

            // Auto-load first visible job after filtering (only on desktop)
            if (firstVisibleCard && window.innerWidth >= 1024) {
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
            const totalJobs = <?php echo count($jobs); ?>;
            const displayLimit = 5;
            const actualDisplayCount = Math.min(count, displayLimit);

            const countElements = document.querySelectorAll('.text-gray-400');
            countElements.forEach(element => {
                if (element.textContent.includes('jobs')) {
                    if (totalJobs <= displayLimit) {
                        element.textContent = `(${actualDisplayCount} jobs)`;
                    } else {
                        element.textContent = `(${actualDisplayCount} of ${totalJobs} jobs)`;
                    }
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

        // Add the missing loadJobDetails function
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

            // Make AJAX request - Using your working endpoint format
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

        // Add missing initializeSearchAndFilters function
        function initializeSearchAndFilters() {
            // Add search input event listener with debounce
            const searchInput = document.getElementById('jobSearch');
            if (searchInput) {
                searchInput.addEventListener('input', debounce(applyAllFilters, 300));
            }

            // Add apply filter button event listener
            const applyFilterBtn = document.getElementById('clearFilters');
            if (applyFilterBtn) {
                applyFilterBtn.addEventListener('click', applyAllFilters);
            }
        }
        function shareJob(jobTitle, jobUrl) {
    if (navigator.share) {
        navigator.share({
            title: jobTitle,
            text: `Check out this job opportunity: ${jobTitle}`,
            url: jobUrl
        }).then(() => {
            console.log('Job shared successfully');
        }).catch((error) => {
            console.error('Error sharing job:', error);
            // Fallback to alert if share fails
            alert('Share feature not supported');
        });
    } else {
        alert('Share feature not supported');
    }
}

        // ...rest of your existing JavaScript code...
    </script>

</div>

<div class="pb-20"></div> <!-- This creates space before the footer -->



<script src="/public/assets/js/firebase-config.js"></script>
<script type="module" src="/public/assets/js/firebase-init.js"></script>