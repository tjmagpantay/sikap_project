<?php
include_once __DIR__ . '/../components/jobseeker_auth_check.php';
include_once __DIR__ . '/../../components/navbar-top.php';
include_once __DIR__ . '/../navbar-jobseeker.php';
?>

<div class="px-6 py-8">
    <div class="mx-auto max-w-7xl">
        <!-- Breadcrumbs -->
        <nav class="mb-6">
            <div class="flex items-center space-x-2 text-sm">
                <a href="?page=jobseeker-dashboard" class="text-gray-500 transition-colors hover:text-primary">
                    Dashboard
                </a>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                <span class="font-medium text-primary">Browse Jobs</span>
            </div>
        </nav>

        <!-- Job Filtering Section -->
        <div class="relative py-2 mb-2 sm:px-8 lg:px-12">
            <div class="flex flex-col gap-6 mx-auto max-w-7xl">
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
                                class="flex items-center justify-between w-full px-3 py-3 text-sm text-gray-700 transition-all duration-200 bg-white border border-gray-300 shadow-ssmappearance-none rounded-SM hover:border-primary/50 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
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
                                class="flex items-center justify-between w-full px-3 py-3 text-sm text-gray-700 transition-all duration-200 bg-white border border-gray-300 shadow-ssmappearance-none rounded-SM hover:border-primary/50 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
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
                                class="flex items-center justify-between w-full px-3 py-3 text-sm text-gray-700 transition-all duration-200 bg-white border border-gray-300 shadow-ssmappearance-none rounded-SM hover:border-primary/50 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
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
                                    <button @click="selsmected = 'Hybrid'; open = false; filterByWorkplace('hybrid')"
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
                            Clear Filters
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Results Summary and Best Matches Button -->
        <div class="flex items-start justify-between mb-8">
            <!-- Filter Buttons -->
            <div class="flex gap-2">
                <!-- Best Matches Button -->
                <button id="bestMatchesBtn"
                    onclick="sortByBestMatches()"
                    class="flex items-center gap-2 px-4 py-3 text-sm font-medium text-gray-700 transition-all bg-white border border-gray-300 rounded-sm shadow-sm hover:bg-gray-50 focus:ring-2 focus:ring-primary/50 hover:shadow-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                    </svg>
                    Best Matches
                </button>

                <!-- A-Z / Z-A Sort Button -->
                <button id="sortAlphaBtn"
                    onclick="toggleAlphabetSort()"
                    class="flex items-center gap-2 px-4 py-3 text-sm font-medium text-gray-700 transition-all bg-white border border-gray-300 rounded-sm shadow-sm hover:bg-gray-50 focus:ring-2 focus:ring-primary/50 hover:shadow-md"
                    data-sort-order="asc">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4"></path>
                    </svg>
                    <span id="sortAlphaText">A-Z</span>
                </button>
            </div>

            <!-- Results Text - Hidden on mobile/tablet (md and below), visible on lg+ -->
            <div class="flex-col hidden md:flex">
                <div class="flex gap-2">
                    <h2 class="text-lg font-semibold text-gray-900">
                        Results: <span id="resultsCount"><?php echo isset($jobs) ? count($jobs) : 0; ?></span> jobs found
                    </h2>
                </div>
                <!-- Active Filters Display -->
                <div id="activeFilters" class="flex flex-wrap gap-2 mt-2">
                    <!-- Default "All Jobs" display (shown when no filters are active) -->
                    <span id="allJobsTag" class="inline-flex items-end text-xs font-medium text-gray-400">
                        All Jobs
                    </span>
                    <!-- Filters will be dynamically added here -->
                </div>
            </div>
        </div>

        <!-- Job Listings -->
        <?php if (empty($jobs)): ?>
            <div class="py-12 text-center">
                <i class="mb-4 text-6xl text-gray-400 fas fa-briefcase"></i>
                <h3 class="mb-2 text-lg font-medium text-gray-900">No jobs available</h3>
                <p class="text-gray-500">Check back later for new job postings</p>
            </div>
        <?php else: ?>
            <div id="jobListingsContainer" class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <?php foreach ($jobs as $index => $currentJob): ?>
                    <!-- Simple, clean job card - fully clickable -->
                    <a href="?page=view-job&job_id=<?php echo $currentJob['job_id']; ?>"
                        class="overflow-hidden transition-shadow duration-200 bg-white border rounded-lg job-cards group hover:shadow-lg"
                        data-job-title="<?php echo strtolower(htmlspecialchars($currentJob['job_title'])); ?>"
                        data-company-name="<?php echo strtolower(htmlspecialchars(!empty($currentJob['company_name']) ? $currentJob['company_name'] : (!empty($currentJob['business_name']) ? $currentJob['business_name'] : ''))); ?>"
                        data-location="<?php echo strtolower(htmlspecialchars($currentJob['location'])); ?>"
                        data-job-type="<?php echo strtolower(htmlspecialchars($currentJob['job_type'])); ?>"
                        data-category="<?php echo strtolower(htmlspecialchars($currentJob['category_name'] ?? '')); ?>"
                        data-match-percentage="<?php echo number_format($currentJob['match_percentage'] ?? 50, 1); ?>">

                        <!-- Header: Company Logo and Job Title with Gray Background and Rounded Top Corners -->
                        <div class="flex items-start gap-4 p-6 pb-4 rounded-t-lg bg-gray-50">
                            <img src="<?php echo !empty($currentJob['business_logo']) ? htmlspecialchars($currentJob['business_logo']) : 'assets/logos/default.png'; ?>"
                                alt="Company Logo"
                                class="flex-shrink-0 object-cover w-12 h-12 bg-gray-100 rounded-md">

                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-900 transition-colors group-hover:text-blue-600">
                                    <?php echo htmlspecialchars($currentJob['job_title']); ?>
                                </h3>
                                <p class="text-sm text-gray-600">
                                    <?php
                                    echo htmlspecialchars(
                                        !empty($currentJob['company_name']) ? $currentJob['company_name'] : (!empty($currentJob['business_name']) ? $currentJob['business_name'] : (isset($currentJob['employer_first_name']) ? $currentJob['employer_first_name'] . ' ' . $currentJob['employer_last_name'] : 'Company'))
                                    );
                                    ?>
                                </p>
                            </div>

                            <!-- Save Button -->
                            <?php if (isset($_SESSION['user_id']) && $_SESSION['role'] == 3): ?>
                                <button onclick="event.preventDefault(); event.stopPropagation(); toggleSaveJob(<?php echo $currentJob['job_id']; ?>, this)"
                                    class="relative z-10 p-2 rounded-md transition-colors <?php echo (isset($currentJob['is_saved']) && $currentJob['is_saved']) ? 'text-secondary hover:bg-yellow-50' : 'text-gray-500 hover:bg-gray-100 hover:text-yellow-600'; ?>"
                                    data-job-id="<?php echo $currentJob['job_id']; ?>"
                                    data-saved="<?php echo (isset($currentJob['is_saved']) && $currentJob['is_saved']) ? 'true' : 'false'; ?>"
                                    title="<?php echo (isset($currentJob['is_saved']) && $currentJob['is_saved']) ? 'Remove from saved jobs' : 'Save job for later'; ?>">

                                    <!-- Bookmark SVG Icon -->
                                    <svg class="w-5 h-5" fill="<?php echo (isset($currentJob['is_saved']) && $currentJob['is_saved']) ? 'currentColor' : 'none'; ?>"
                                        stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                                    </svg>
                                </button>
                            <?php endif; ?>
                        </div>

                        <!-- Card Body Content -->
                        <div class="p-6 pt-4">
                            <!-- Location -->
                            <div class="flex items-center gap-1 mb-3 text-sm text-gray-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span><?php echo htmlspecialchars($currentJob['location']); ?></span>
                            </div>

                            <!-- Job Type and Category Tags -->
                            <div class="flex flex-wrap gap-2 mb-4">
                                <span class="px-3 py-2 text-xs bg-gray-100 rounded-sm text-primary">
                                    <?php echo htmlspecialchars(ucfirst($currentJob['job_type'])); ?>
                                </span>
                                <?php if (!empty($currentJob['category_name'])): ?>
                                    <span class="px-3 py-2 text-xs bg-gray-100 rounded-sm text-primary">
                                        <?php echo htmlspecialchars($currentJob['category_name']); ?>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <!-- Job Summary -->
                            <p class="mb-4 text-sm text-gray-700 line-clamp-3">
                                <?php echo htmlspecialchars(substr($currentJob['job_summary'], 0, 150)) . (strlen($currentJob['job_summary']) > 150 ? '...' : ''); ?>
                            </p>

                            <!-- Age Requirements (if any) -->
                            <?php if (!empty($currentJob['min_age']) || !empty($currentJob['max_age'])): ?>
                                <div class="flex items-center text-xs text-gray-500">
                                    <i class="mr-1 fas fa-users"></i>
                                    <span>
                                        <?php
                                        if (!empty($currentJob['min_age']) && !empty($currentJob['max_age'])) {
                                            echo 'Ages ' . $currentJob['min_age'] . '-' . $currentJob['max_age'];
                                        } elseif (!empty($currentJob['min_age'])) {
                                            echo 'Min age ' . $currentJob['min_age'];
                                        } elseif (!empty($currentJob['max_age'])) {
                                            echo 'Max age ' . $currentJob['max_age'];
                                        }
                                        ?>
                                    </span>
                                </div>
                            <?php endif; ?>

                            <!-- Footer: Posted Date and Match Percentage -->
                            <div class="flex items-center justify-between pt-4 mt-2">
                                <span class="text-xs text-gray-500">
                                    Posted <?php echo isset($currentJob['created_at']) ? date('M d, Y', strtotime($currentJob['created_at'])) : 'Recently'; ?>
                                </span>

                                <!-- ENHANCED: Real Match Percentage with Color Coding and Low Match Warning -->
                                <div class="flex flex-col items-end">
                                    <?php
                                    $matchPercentage = $currentJob['match_percentage'] ?? 50;
                                    $hasRealRecommendation = $currentJob['has_recommendation'] ?? false;
                                    $isLowMatch = $matchPercentage < 20;
                                    ?>

                                    <div class="flex items-center gap-2 text-right">
                                        <!-- Show Percentage Only If >= 20 -->
                                        <?php if (!$isLowMatch): ?>
                                            <div class="text-sm font-bold <?= $matchPercentage >= 70 ? 'text-green-600' : ($matchPercentage >= 50 ? 'text-yellow-600' : 'text-red-600') ?>">
                                                <?= number_format($matchPercentage, 1) ?>%
                                            </div>
                                        <?php endif; ?>

                                        <!-- Match Text -->
                                        <div class="text-xs text-gray-400">
                                            <?= $isLowMatch ? 'Poor Match' : ($hasRealRecommendation ? 'AI Match' : 'Est. Match') ?>
                                        </div>

                                        <!-- FIXED: Low Match Warning Icon with Better Positioned Tooltip -->
                                        <?php if ($isLowMatch): ?>
                                            <div class="relative tooltip-container">
                                                <svg class="w-4 h-4 text-gray-400 transition-colors cursor-help hover:text-yellow-500"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>

                                                <!-- FIXED: Better Positioned Tooltip -->
                                                <div class="absolute right-0 z-50 px-3 py-2 mb-3 text-xs text-white transition-all duration-200 transform -translate-y-1 bg-gray-900 rounded-lg shadow-xl opacity-0 pointer-events-none tooltip-content bottom-full whitespace-nowrap">
                                                    <div class="text-center min-w-max">
                                                        <div class="flex items-center gap-1 font-medium text-yellow-300">
                                                            ⚠️ <span>Low Match</span>
                                                        </div>
                                                        <div class="mt-1">No strong matches found.</div>
                                                        <div class="text-gray-300 mt-0.5">Consider improving your profile</div>
                                                    </div>
                                                    <!-- Tooltip Arrow -->
                                                    <div class="absolute w-0 h-0 border-t-4 border-l-4 border-r-4 border-transparent top-full right-4 border-t-gray-900"></div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>

            <!-- No Results Message (Hidden by default) -->
            <div id="noResultsMessage" class="hidden py-12 text-center">
                <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 005.656 0M9 12h6m-9-4h6m2 5.291A7.962 7.962 0 0012 15c-2.137 0-4.146-.832-5.657-2.343"></path>
                </svg>
                <h3 class="mb-2 text-lg font-medium text-gray-900">No jobs found</h3>
                <p class="text-sm text-gray-500">Try adjusting your filters or search terms</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
    /* FIXED: Enhanced Tooltip Styling with Proper Z-index and Positioning */
    .tooltip-container:hover .tooltip-content {
        opacity: 1 !important;
        transform: translateY(0) !important;
        pointer-events: auto;
    }

    /* Ensure tooltip appears above all other elements */
    .tooltip-content {
        z-index: 9999 !important;
    }

    /* Prevent tooltip from being clipped by parent containers */
    .job-cards {
        overflow: visible !important;
    }

    /* Fix for grid container not clipping tooltips */
    #jobListingsContainer {
        overflow: visible !important;
    }

    /* Smooth hover transitions */
    .tooltip-container svg {
        transition: color 0.2s ease-in-out;
    }

    /* Better tooltip arrow */
    .tooltip-content::after {
        content: '';
        position: absolute;
        top: 100%;
        right: 16px;
        width: 0;
        height: 0;
        border-left: 6px solid transparent;
        border-right: 6px solid transparent;
        border-top: 6px solid #1f2937;
    }

    /* Make sure cards don't clip overflowing elements */
    .job-cards {
        position: relative;
        overflow: visible;
    }

    .job-cards .relative {
        overflow: visible;
    }

    /* Ensure grid container allows overflow */
    #jobListingsContainer {
        overflow: visible;
    }

    /* Fix any potential clipping from parent containers */
    .max-w-7xl {
        overflow: visible;
    }

    /* Additional fix for mobile responsiveness */
    @media (max-width: 640px) {
        .tooltip-content {
            right: -20px;
            left: auto;
            transform: translateX(0);
            min-width: 200px;
        }

        .tooltip-content::after {
            right: 30px;
        }
    }
</style>
<!-- Alpine.js -->
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

<script>
    // Global variables for filtering
    let allJobs = [];
    let filteredJobs = [];
    let activeFilters = {};

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        // FIXED: Ensure containers don't clip tooltips
        const containers = [
            document.getElementById('jobListingsContainer'),
            document.querySelector('.max-w-7xl'),
            document.querySelector('.px-6.py-8')
        ];

        containers.forEach(container => {
            if (container) {
                container.style.overflow = 'visible';
            }
        });

        initializeFiltering();
    });

    function initializeFiltering() {
        // Store all job cards for filtering - FIXED: Now looks for .job-card class
        allJobs = Array.from(document.querySelectorAll('.job-cards'));
        filteredJobs = [...allJobs];

        console.log('Found', allJobs.length, 'job cards'); // Debug log

        // Add search input listener
        const searchInput = document.getElementById('jobSearch');
        if (searchInput) {
            searchInput.addEventListener('input', debounce(applyAllFilters, 300));
        }

        // Add clear filters button listener
        const clearButton = document.getElementById('clearFilters');
        if (clearButton) {
            clearButton.addEventListener('click', clearAllFilters);
        }

        updateResultsCount();
    }

    // Filter functions for dropdowns
    function filterByLocation(location) {
        console.log('Filtering by location:', location); // Debug log
        if (location) {
            activeFilters.location = location;
        } else {
            delete activeFilters.location;
        }
        applyAllFilters();
    }

    function filterByIndustry(industry) {
        console.log('Filtering by industry:', industry); // Debug log
        if (industry) {
            activeFilters.industry = industry;
        } else {
            delete activeFilters.industry;
        }
        applyAllFilters();
    }

    function filterByWorkplace(workplace) {
        console.log('Filtering by workplace:', workplace); // Debug log
        if (workplace) {
            activeFilters.workplace = workplace;
        } else {
            delete activeFilters.workplace;
        }
        applyAllFilters();
    }

    // Main filter function
    function applyAllFilters() {
        const searchTerm = document.getElementById('jobSearch').value.toLowerCase().trim();

        // Add search to active filters
        if (searchTerm) {
            activeFilters.search = searchTerm;
        } else {
            delete activeFilters.search;
        }

        console.log('Active filters:', activeFilters); // Debug log

        filteredJobs = allJobs.filter(job => {
            let shouldShow = true;

            // Search filter
            if (searchTerm) {
                const jobTitle = job.getAttribute('data-job-title') || '';
                const companyName = job.getAttribute('data-company-name') || '';
                if (!jobTitle.includes(searchTerm) && !companyName.includes(searchTerm)) {
                    shouldShow = false;
                }
            }

            // Location filter
            if (activeFilters.location && shouldShow) {
                const location = job.getAttribute('data-location') || '';
                if (!location.includes(activeFilters.location.toLowerCase())) {
                    shouldShow = false;
                }
            }

            // Industry filter
            if (activeFilters.industry && shouldShow) {
                const category = job.getAttribute('data-category') || '';
                if (!category.includes(activeFilters.industry.toLowerCase())) {
                    shouldShow = false;
                }
            }

            // Workplace filter
            if (activeFilters.workplace && shouldShow) {
                const jobType = job.getAttribute('data-job-type') || '';
                if (!jobType.includes(activeFilters.workplace.toLowerCase())) {
                    shouldShow = false;
                }
            }

            return shouldShow;
        });

        console.log('Filtered jobs:', filteredJobs.length); // Debug log

        // Show/hide jobs
        allJobs.forEach(job => {
            if (filteredJobs.includes(job)) {
                job.style.display = 'block';
            } else {
                job.style.display = 'none';
            }
        });

        updateResultsCount();
        updateActiveFiltersDisplay();
        showNoResultsMessage(filteredJobs.length === 0);
    }

    // Sort by best matches
    function sortByBestMatches() {
        const container = document.getElementById('jobListingsContainer');
        const visibleJobs = filteredJobs.filter(job => job.style.display !== 'none');

        // Sort by match percentage (descending)
        visibleJobs.sort((a, b) => {
            const matchA = parseInt(a.getAttribute('data-match-percentage')) || 0;
            const matchB = parseInt(b.getAttribute('data-match-percentage')) || 0;
            return matchB - matchA;
        });

        // Reorder in DOM
        visibleJobs.forEach(job => {
            container.appendChild(job);
        });

        // Show visual feedback
        showToast('Jobs sorted by best matches', 'success');
    }

    // Clear all filters
    function clearAllFilters() {
        // Reset search input
        document.getElementById('jobSearch').value = '';

        // Reset dropdown selections using Alpine.js
        resetDropdowns();

        // Clear active filters
        activeFilters = {};

        // Show all jobs
        allJobs.forEach(job => {
            job.style.display = 'block';
        });

        filteredJobs = [...allJobs];
        updateResultsCount();
        updateActiveFiltersDisplay();
        showNoResultsMessage(false);

        showToast('All filters cleared', 'success');
    }

    // Reset dropdown selections
    function resetDropdowns() {
        // Reset Alpine.js dropdowns by dispatching custom events
        const locationDropdown = document.querySelector('[x-data*="Location"]');
        const industryDropdown = document.querySelector('[x-data*="Industry"]');
        const workplaceDropdown = document.querySelector('[x-data*="Workplace"]');

        if (locationDropdown && locationDropdown._x_dataStack) {
            locationDropdown._x_dataStack[0].selected = 'Location';
        }
        if (industryDropdown && industryDropdown._x_dataStack) {
            industryDropdown._x_dataStack[0].selected = 'Industry';
        }
        if (workplaceDropdown && workplaceDropdown._x_dataStack) {
            workplaceDropdown._x_dataStack[0].selected = 'Workplace';
        }
    }

    // Update results count - FIXED
    function updateResultsCount() {
        const visibleJobs = filteredJobs.filter(job => job.style.display !== 'none');
        const count = visibleJobs.length;
        const resultsElement = document.getElementById('resultsCount');
        if (resultsElement) {
            resultsElement.textContent = count;
        }
        console.log('Updated count to:', count); // Debug log
    }

    // Update active filters display
    function updateActiveFiltersDisplay() {
        const container = document.getElementById('activeFilters');
        container.innerHTML = '';

        Object.entries(activeFilters).forEach(([key, value]) => {
            const filterTag = document.createElement('span');
            filterTag.className = 'inline-flex  gap-1 text-xs bg-primary/10 text-gray-400 rounded-full';

            let displayValue = value;
            if (key === 'search') {
                displayValue = `"${value}"`;
            }

            filterTag.innerHTML = `
                ${key}: ${displayValue}
                <button onclick="removeFilter('${key}')" class="ml-1 hover:text-primary/70">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            `;

            container.appendChild(filterTag);
        });
    }

    // Remove individual filter
    function removeFilter(filterKey) {
        delete activeFilters[filterKey];

        if (filterKey === 'search') {
            document.getElementById('jobSearch').value = '';
        } else {
            // Reset the corresponding dropdown
            resetSpecificDropdown(filterKey);
        }

        applyAllFilters();
    }

    // Reset specific dropdown
    function resetSpecificDropdown(filterKey) {
        const dropdownMap = {
            'location': 'Location',
            'industry': 'Industry',
            'workplace': 'Workplace'
        };

        const defaultValue = dropdownMap[filterKey];
        if (defaultValue) {
            const selector = `[x-data*="${defaultValue}"]`;
            const element = document.querySelector(selector);
            if (element && element._x_dataStack) {
                element._x_dataStack[0].selected = defaultValue;
            }
        }
    }

    // Show/hide no results message
    function showNoResultsMessage(show) {
        const container = document.getElementById('jobListingsContainer');
        const noResultsMessage = document.getElementById('noResultsMessage');

        if (show) {
            container.style.display = 'none';
            noResultsMessage.classList.remove('hidden');
        } else {
            container.style.display = 'grid';
            noResultsMessage.classList.add('hidden');
        }
    }

    // Debounce function
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

    // Toast notification function
    function showToast(message, type) {
        const existingToasts = document.querySelectorAll('.toast-notification');
        existingToasts.forEach(toast => toast.remove());

        const toast = document.createElement('div');
        toast.className = `toast-notification fixed top-4 right-4 px-4 py-2 rounded-md shadow-lg z-50 transition-all duration-300 transform translate-x-0 ${
            type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
        }`;
        toast.textContent = message;

        document.body.appendChild(toast);

        setTimeout(() => {
            toast.style.opacity = '1';
        }, 10);

        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateX(100%)';
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.parentNode.removeChild(toast);
                }
            }, 300);
        }, 3000);
    }

    // Save job functionality (existing)
    function toggleSaveJob(jobId, button) {
        const isSaved = button.getAttribute('data-saved') === 'true';
        const action = isSaved ? 'unsave-job' : 'save-job';

        const svgIcon = button.querySelector('svg');
        const originalFill = svgIcon.getAttribute('fill');

        svgIcon.classList.add('animate-pulse');
        button.disabled = true;

        const formData = new FormData();
        formData.append('job_id', jobId);

        fetch(`?page=${action}`, {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

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
                if (data.success) {
                    if (isSaved) {
                        button.setAttribute('data-saved', 'false');
                        svgIcon.setAttribute('fill', 'none');
                        button.title = 'Save job for later';
                        button.className = 'relative z-10 p-2 rounded-md text-gray-500 hover:bg-gray-100 hover:text-yellow-600';
                    } else {
                        button.setAttribute('data-saved', 'true');
                        svgIcon.setAttribute('fill', 'currentColor');
                        button.title = 'Remove from saved jobs';
                        button.className = 'relative z-10 p-2 rounded-md text-yellow-600 hover:bg-yellow-50';
                    }

                    showToast(data.message || 'Job ' + (isSaved ? 'unsaved' : 'saved') + ' successfully!', 'success');
                } else {
                    svgIcon.setAttribute('fill', originalFill);
                    showToast(data.message || 'Error occurred', 'error');
                }
            })
            .catch(error => {
                svgIcon.setAttribute('fill', originalFill);
                console.error('Fetch error:', error);
                showToast('Error occurred while ' + (isSaved ? 'unsaving' : 'saving') + ' job', 'error');
            })
            .finally(() => {
                svgIcon.classList.remove('animate-pulse');
                button.disabled = false;
            });
    }

    // Toggle alphabetic sort
    function toggleAlphabetSort() {
        const button = document.getElementById('sortAlphaBtn');
        const currentOrder = button.getAttribute('data-sort-order');
        const newOrder = currentOrder === 'asc' ? 'desc' : 'asc';

        button.setAttribute('data-sort-order', newOrder);

        const sortedJobs = Array.from(filteredJobs).sort((a, b) => {
            const titleA = a.getAttribute('data-job-title')?.toLowerCase() || '';
            const titleB = b.getAttribute('data-job-title')?.toLowerCase() || '';

            if (newOrder === 'asc') {
                return titleA.localeCompare(titleB);
            } else {
                return titleB.localeCompare(titleA);
            }
        });

        const container = document.getElementById('jobListingsContainer');
        sortedJobs.forEach(job => container.appendChild(job));

        // Update button text
        document.getElementById('sortAlphaText').textContent = newOrder === 'asc' ? 'Z-A' : 'A-Z';

        // Show visual feedback
        showToast('Jobs sorted ' + (newOrder === 'asc' ? 'A-Z' : 'Z-A'), 'success');
    }
</script>