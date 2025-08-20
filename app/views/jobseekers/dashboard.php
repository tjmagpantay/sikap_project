<?php
include_once __DIR__ . '/../components/navbar-top.php';
include_once __DIR__ . '/navbar-jobseeker.php';
?>

<div class="min-h-screen">
    <div class="px-4 py-8 sm:px-6 md:px-16 lg:px-24">
        <!-- Hero Search Section -->
        <div class="relative px-6 py-6 mb-2 overflow-hidden sm:px-8 sm:py-12 lg:px-12 lg:py-16 rounded-xl">
            <!-- Background Image and Gradient Overlay (below content) -->
            <div class="absolute inset-0 z-0">
                <img src="assets/images/hero-page-bg.png"
                    alt="Hero Background"
                    class="object-cover w-full h-full opacity-20"
                    onerror="this.style.display='none'">
                <div class="absolute inset-0"
                    style="background: linear-gradient(to right, var(--color-primary, #092C4C) 0%, transparent 100%); opacity: 0.85;">
                </div>
            </div>

            <!-- Content (above gradient) -->
            <div class="relative z-10 flex flex-col max-w-5xl gap-6 mx-auto md:flex-row md:items-center md:justify-between" style="min-height:70px;">
                <!-- Left: Headline -->
                <div class="flex flex-col items-start justify-start flex-1 h-full md:items-start md:justify-start">
                    <h1 class="w-full mb-1 text-2xl font-bold text-white text-start sm:text-3xl lg:text-4xl md:w-auto md:text-left">
                        Find Your Dream Job Today
                    </h1>
                    <p class="max-w-2xl mt-2 text-sm leading-relaxed text-center text-white md:text-left sm:mt-3 sm:text-sm">
                        Apply job that match you.
                    </p>
                </div>
                <!-- Right: Search Form -->
                <div class="flex-1">
                    <form class="w-full max-w-md ml-auto md:max-w-lg lg:max-w-xl">
                        <div class="flex flex-col gap-2 p-3 bg-white rounded-md shadow md:flex-row md:flex-nowrap">
                            <!-- Job Title Field -->
                            <div class="flex items-center flex-1 min-w-0 gap-2 px-2 py-1">
                                <img src="assets/icons/search-svgrepo-com.svg" class="w-5 h-5 text-gray-500" alt="Location Icon" />
                                <input
                                    type="text"
                                    placeholder="Job title"
                                    class="flex-1 min-w-0 text-sm bg-transparent border-none outline-none focus:ring-0" />
                            </div>
                            <!-- Separator -->
                            <div class="hidden w-px h-8 bg-gray-300 md:block"></div>
                            <!-- Location Field -->
                            <div class="flex items-center flex-1 min-w-0 px-2 py-1 mt-2 md:mt-0">
                                <div class="flex items-center flex-1 min-w-0 gap-2 px-2 py-1">
                                    <img src="assets/icons/location-information-svgrepo-com.svg" class="w-5 h-5 text-gray-500" alt="Location Icon" />
                                    <input
                                        type="text"
                                        placeholder="Location"
                                        class="flex-1 min-w-0 text-sm bg-transparent border-none outline-none focus:ring-0" />
                                </div>
                            </div>
                            <!-- Search Button -->
                            <button type="submit" class="w-full min-w-0 mt-2 btn-primary md:w-auto md:mt-0 md:ml-2">
                                Search
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Job Filtering Section -->
        <div class="relative z-10 w-full mx-auto mt-4 mb-6">
            <div class="p-5 bg-white border border-gray-200 rounded-sm shadow-sm">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:gap-3">

                    <!-- Search Jobs (Much Wider) -->
                    <div class="w-full lg:w-56">
                        <div class="relative">
                            <input type="text" id="jobSearch"
                                placeholder="Search for jobs..."
                                class="w-full py-3 pl-3 pr-12 text-xs text-gray-400 transition-all border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary hover:border-primary/50">

                            <!-- Search Icon (Right Side) -->
                            <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>


                    <!-- Location -->
                    <div class="w-full lg:w-34">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                            <select id="locationFilter"
                                class="w-full py-3 pr-10 text-sm transition-all bg-white border border-gray-300 rounded-lg appearance-none cursor-pointer pl-9 focus:ring-2 focus:ring-primary/20 focus:border-primary hover:border-primary/50">
                                <option value="">Location</option>
                                <option value="manila">Manila</option>
                                <option value="quezon-city">Quezon City</option>
                                <option value="makati">Makati</option>
                                <option value="taguig">Taguig</option>
                                <option value="pasig">Pasig</option>
                                <option value="cebu">Cebu</option>
                                <option value="davao">Davao</option>
                            </select>
                        </div>
                    </div>

                    <!-- Job Type -->
                    <div class="w-full lg:w-36">
                        <div class="relative">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                            <select id="jobTypeFilter"
                                class="w-full px-4 py-3 pr-10 text-sm transition-all bg-white border border-gray-300 rounded-lg appearance-none cursor-pointer focus:ring-2 focus:ring-primary/20 focus:border-primary hover:border-primary/50">
                                <option value="">Job Type</option>
                                <option value="full-time">Full-time</option>
                                <option value="part-time">Part-time</option>
                                <option value="contract">Contract</option>
                                <option value="temporary">Temporary</option>
                                <option value="internship">Internship</option>
                            </select>
                        </div>
                    </div>

                    <!-- Industry -->
                    <div class="w-full lg:w-40">
                        <div class="relative">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                            <select id="industryFilter"
                                class="w-full px-4 py-3 pr-10 text-sm transition-all bg-white border border-gray-300 rounded-lg appearance-none cursor-pointer focus:ring-2 focus:ring-primary/20 focus:border-primary hover:border-primary/50">
                                <option value="">Industry</option>
                                <option value="technology">Technology</option>
                                <option value="healthcare">Healthcare</option>
                                <option value="education">Education</option>
                                <option value="finance">Finance</option>
                                <option value="retail">Retail</option>
                                <option value="manufacturing">Manufacturing</option>
                                <option value="hospitality">Hospitality</option>
                                <option value="construction">Construction</option>
                            </select>
                        </div>
                    </div>

                    <!-- Workplace -->
                    <div class="w-full lg:w-36">
                        <div class="relative">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                            <select id="workplaceFilter"
                                class="w-full px-4 py-3 pr-10 text-sm transition-all bg-white border border-gray-300 rounded-lg appearance-none cursor-pointer focus:ring-2 focus:ring-primary/20 focus:border-primary hover:border-primary/50">
                                <option value="">Workplace</option>
                                <option value="on-site">On-site</option>
                                <option value="remote">Remote</option>
                                <option value="hybrid">Hybrid</option>
                            </select>
                        </div>
                    </div>

                    <!-- Filter/Clear Buttons -->
                    <div class="flex gap-2 lg:flex-shrink-0">
                        <button type="button" id="applyFilters"
                            class="px-5 py-3 text-sm font-medium text-white transition-all rounded-lg shadow-sm bg-primary hover:bg-primary/90 focus:ring-2 focus:ring-primary/20 hover:shadow-md">
                            Apply
                        </button>
                        <button type="button" id="clearFilters"
                            class="px-5 py-3 text-sm font-medium text-gray-600 transition-all bg-gray-100 rounded-lg shadow-sm hover:bg-gray-200 focus:ring-2 focus:ring-gray-300 hover:shadow-md">
                            Clear
                        </button>
                    </div>
                </div>
            </div>
        </div>


        <!-- Main Dashboard Content -->
        <div class="flex flex-col gap-6 lg:flex-row">
            <!-- Left Side - Job Cards (Scrollable) -->
            <div class="w-full lg:w-[25%] xl:w-[25%]">
                <div class="">

                    <!-- Filter Buttons -->
                    <div class="flex gap-2 mb-4">
                        <button class="flex-1 px-3 py-4 text-sm font-medium text-white transition-colors rounded-md bg-primary focus:outline-none focus:ring-2 focus:ring-primary/50"
                            data-filter="all" onclick="filterJobs('all', this)">
                            All Jobs
                            <span class="text-sm font-normal text-gray-400 whitespace-nowrap">(<?php echo count($jobs); ?> jobs)</span>
                        </button>
                        <button class="flex-1 px-3 py-4 text-sm font-medium text-gray-700 transition-colors bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary/50"
                            data-filter="recent" onclick="filterJobs('recent', this)">
                            Most Recent
                        </button>
                        <button class="flex-1 px-3 py-4 text-sm font-medium text-gray-700 transition-colors bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary/50"
                            data-filter="matches" onclick="filterJobs('matches', this)">
                            Best Matches
                        </button>
                    </div>

                    <!-- Job Post Card -->
                    <div class="overflow-y-auto " style="max-height: 600px; ">
                        <?php if (!empty($jobs)): ?>
                            <div class="space-y-3">
                                <?php foreach ($jobs as $job): ?>
                                    <div class="p-6 transition-all border border-gray-200 rounded-lg cursor-pointer hover:border-primary hover:shadow-md job-card <?php echo (isset($_GET['job_id']) && $_GET['job_id'] == $job['job_id'] ? 'border-primary bg-primary/5' : ''); ?>"
                                        onclick="window.location.href='?page=jobseeker-dashboard&job_id=<?php echo $job['job_id']; ?>'">

                                        <!-- Row 1: Business Profile + Job Title + Business Name + Urgent + Saved Icon -->
                                        <div class="flex items-center justify-between mb-2">
                                            <div class="flex items-center gap-2">
                                                <!-- Business Profile Image -->
                                                <div class="flex items-center justify-center w-12 h-12 p-1 overflow-hidden rounded-md bg-primary">
                                                    <?php if (!empty($job['business_logo'])): ?>
                                                        <img src="<?php echo htmlspecialchars($job['business_logo']); ?>"
                                                            alt="<?php echo htmlspecialchars($job['company_name'] ?? 'Company'); ?> Logo"
                                                            class="object-cover w-full h-full">
                                                    <?php else: ?>
                                                        <i class="text-gray-500 fas fa-building"></i>
                                                    <?php endif; ?>
                                                </div>

                                                <!-- Job Title and Business Name -->
                                                <div>
                                                    <h3 class="text-base font-semibold leading-tight text-gray-900"><?php echo htmlspecialchars($job['job_title']); ?></h3>
                                                    <p class="text-sm text-gray-600"><?php echo htmlspecialchars($job['company_name'] ?? $job['business_name'] ?? ''); ?></p>
                                                </div>
                                            </div>

                                            <div class="flex items-center space-x-2">
                                                <!-- Urgent Badge (if applicable) -->
                                                <?php if (isset($job['is_urgent']) && $job['is_urgent']): ?>
                                                    <span class="px-2 py-1 text-xs font-medium text-red-600 bg-red-100 rounded">
                                                        Urgent
                                                    </span>
                                                <?php endif; ?>

                                                <!-- Saved Icon -->
                                                <?php if ($hasProfile): ?>
                                                    <button onclick="event.stopPropagation(); toggleSaveJob(<?php echo $job['job_id']; ?>, this)"
                                                        class=" text-secondary save-btn hover:text-yellow-500"
                                                        data-job-id="<?php echo $job['job_id']; ?>"
                                                        data-saved="<?php echo (isset($job['is_saved']) && $job['is_saved']) ? 'true' : 'false'; ?>"
                                                        title="<?php echo (isset($job['is_saved']) && $job['is_saved']) ? 'Remove from saved jobs' : 'Save job for later'; ?>">
                                                        <!-- Bookmark SVG Icon -->
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20"
                                                            fill="<?php echo (isset($job['is_saved']) && $job['is_saved']) ? 'currentColor' : 'none'; ?>"
                                                            stroke="currentColor"
                                                            stroke-width="<?php echo (isset($job['is_saved']) && $job['is_saved']) ? '0' : '1.5'; ?>">
                                                            <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z" />
                                                        </svg>
                                                    </button>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <!-- Row 2: Location with Icon -->
                                        <div class="flex items-center mb-1">
                                            <!-- Location Marker SVG Icon -->
                                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            <span class="ml-2 text-sm text-gray-600"><?php echo htmlspecialchars($job['location']); ?></span>
                                        </div>

                                        <!-- Row 3: Pay Range with Icon -->
                                        <?php if (!empty($job['pay_range'])): ?>
                                            <div class="flex items-center mb-2">
                                                <!-- Dollar Sign SVG Icon -->
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 13C7 11.1144 7 10.1716 7.58579 9.58579C8.17157 9 9.11438 9 11 9H14H17C18.8856 9 19.8284 9 20.4142 9.58579C21 10.1716 21 11.1144 21 13V14V15C21 16.8856 21 17.8284 20.4142 18.4142C19.8284 19 18.8856 19 17 19H14H11C9.11438 19 8.17157 19 7.58579 18.4142C7 17.8284 7 16.8856 7 15V14V13Z" stroke-linejoin="round"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 15V15C5.11438 15 4.17157 15 3.58579 14.4142C3.58579 14.4142 3.58579 14.4142 3.58579 14.4142C3 13.8284 3 12.8856 3 11L3 9C3 7.11438 3 6.17157 3.58579 5.58579C4.17157 5 5.11438 5 7 5L13 5C14.8856 5 15.8284 5 16.4142 5.58579C17 6.17157 17 7.11438 17 9V9" stroke-linejoin="round"></path>
                                                    <path d="M16 14C16 15.1046 15.1046 16 14 16C12.8954 16 12 15.1046 12 14C12 12.8954 12.8954 12 14 12C15.1046 12 16 12.8954 16 14Z"></path>
                                                </svg>
                                                <span class="text-sm text-gray-600"><?php echo htmlspecialchars($job['pay_range']); ?></span>
                                            </div>
                                        <?php endif; ?>

                                        <!-- Row 4: Tags for Job Info -->
                                        <div class="flex items-center gap-2 mb-2">
                                            <!-- Job Type Tag -->
                                            <span class="px-3 py-2 text-xs bg-gray-100 rounded-sm text-primary">
                                                <?php echo htmlspecialchars(ucfirst($job['job_type'])); ?>
                                            </span>

                                            <!-- Job Category -->
                                            <?php if (!empty($job['category_name'])): ?>
                                                <span class="px-3 py-2 text-xs bg-gray-100 rounded-sm text-primary">
                                                    <?php echo htmlspecialchars($job['category_name']); ?>
                                                </span>
                                            <?php endif; ?>

                                            <!-- Applied Status -->
                                            <?php if (isset($job['has_applied']) && $job['has_applied']): ?>
                                                <span class="flex items-center px-3 py-2 text-xs bg-gray-100 rounded-sm text-primary">
                                                    <!-- Checkmark SVG -->
                                                    <svg class="w-3 h-3 mr-1 text-primary" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    Applied
                                                </span>
                                            <?php endif; ?>
                                        </div>

                                        <!-- Row 5: Posted Date + Best Matches Info -->
                                        <div class="flex items-center justify-between text-xs text-gray-500">
                                            <span>
                                                Posted <?php echo date('M j, Y', strtotime($job['created_at'])); ?>
                                            </span>

                                            <span>Best Match:
                                                <!-- Checkmark in Circle -->
                                                <span class="text-sm font-semibold text-primary"><?php echo htmlspecialchars($currentJob['match_percentage'] ?? '95'); ?>%</span> </span>

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
            <div class="w-full lg:w-[75%] xl:w-[75%]">
                <?php if (isset($_GET['job_id']) && !empty($selectedJob)): ?>
                    <!-- Job Details Card -->
                    <div class="p-6 bg-white border border-gray-200 shadow-sm rounded-xl">
                        <div class="flex items-start justify-between">
                            <div class="flex items-start space-x-4">
                                <!-- Business Logo/Profile -->
                                <div class="flex items-center justify-center w-16 h-16 overflow-hidden border-gray-200 rounded-md">
                                    <?php if (!empty($selectedJob['business_logo'])): ?>
                                        <img src="<?php echo htmlspecialchars($selectedJob['business_logo']); ?>" alt="Company Logo"
                                            class="object-cover w-full h-full min-w-full min-h-full border-2 border-gray-200 rounded-md">
                                    <?php else: ?>
                                        <i class="text-2xl text-gray-500 fas fa-building"></i>
                                    <?php endif; ?>
                                </div>

                                <div>
                                    <h2 class="text-lg font-bold text-gray-900"><?php echo htmlspecialchars($selectedJob['job_title']); ?></h2>
                                    <div class="flex flex-col sm:flex-row sm:space-y-0 sm:space-x-4">
                                        <p class="flex items-center text-gray-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                            </svg>
                                            <span class="text-sm"><?php echo htmlspecialchars($selectedJob['company_name'] ?? $selectedJob['business_name'] ?? 'Company'); ?></span>
                                        </p>
                                        <p class="flex items-center text-gray-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            <span class="text-sm"><?php echo htmlspecialchars($selectedJob['location']); ?></span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="flex gap-2 space-x-2">
                                <?php if ($hasProfile): ?>
                                    <button onclick="toggleSaveJob(<?php echo $selectedJob['job_id']; ?>, this)"
                                        class="p-2 rounded-full text-secondary hover:bg-gray-100 hover:text-yellow-500"
                                        title="<?php echo (isset($selectedJob['is_saved']) && $selectedJob['is_saved']) ? 'Remove from saved' : 'Save job'; ?>">
                                        <!-- Bookmark SVG Icon -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 20 20" fill="<?php echo (isset($selectedJob['is_saved']) && $selectedJob['is_saved']) ? 'currentColor' : 'none'; ?>" stroke="currentColor" stroke-width="2">
                                            <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z" />
                                        </svg>
                                    </button>
                                <?php endif; ?>
                                <a href="?page=view-job&job_id=<?php echo $selectedJob['job_id']; ?>"
                                    class="p-2 rounded-full text-primary hover:bg-gray-100 hover:text-primary"
                                    title="View Full Details">
                                    <!-- External Link SVG Icon -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                    </svg>
                                </a>
                            </div>
                        </div>

                        <div class="mt-4">
                            <div class="flex flex-wrap items-center gap-2 mb-4">
                                <span class="px-3 py-2 text-xs   <?php echo strtolower($selectedJob['job_type']) === 'full-time' ? 'bg-blue-100 text-primary' : 'bg-green-100 text-green-800'; ?>">
                                    <?php echo strtoupper($selectedJob['job_type']); ?>
                                </span>

                                <?php if (!empty($selectedJob['category_name'])): ?>
                                    <span class="px-3 py-2 text-xs text-secondary bg-yellow-50">
                                        <?php echo htmlspecialchars($selectedJob['category_name']); ?>
                                    </span>
                                <?php endif; ?>

                                <?php if (!empty($selectedJob['pay_range'])): ?>
                                    <span class="flex items-center px-3 py-2 text-xs text-gray-600 bg-gray-100 ">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <?php echo htmlspecialchars($selectedJob['pay_range']); ?>
                                    </span>
                                <?php endif; ?>

                                <span class="flex items-center px-3 py-2 text-xs text-gray-600 bg-gray-100 ">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Posted <?php echo date('M j, Y', strtotime($selectedJob['created_at'])); ?>
                                </span>
                            </div>

                            <!-- Application Timeline -->
                            <?php if (!empty($selectedJob['application_start']) || !empty($selectedJob['application_deadline'])): ?>
                                <div class="p-4 mb-6 border border-gray-200 rounded-lg bg-gray-50">
                                    <h4 class="mb-3 text-sm font-semibold text-gray-900">Application Timeline</h4>
                                    <div class="space-y-2">
                                        <?php if (!empty($selectedJob['application_start'])): ?>
                                            <div class="flex items-center text-sm text-gray-600">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                <span class="font-medium">Applications Open:</span>
                                                <span class="ml-2"><?php echo date('M j, Y g:i A', strtotime($selectedJob['application_start'])); ?></span>
                                            </div>
                                        <?php endif; ?>

                                        <?php if (!empty($selectedJob['application_deadline'])): ?>
                                            <div class="flex items-center text-sm text-gray-600">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <span class="font-medium">Application Deadline:</span>
                                                <span class="ml-2 <?php echo (strtotime($selectedJob['application_deadline']) < time()) ? 'text-red-600 font-semibold' : ''; ?>">
                                                    <?php echo date('M j, Y g:i A', strtotime($selectedJob['application_deadline'])); ?>
                                                </span>
                                                <?php if (strtotime($selectedJob['application_deadline']) < time()): ?>
                                                    <span class="px-2 py-1 ml-2 text-xs font-medium text-red-700 bg-red-100 rounded">EXPIRED</span>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="mb-6">
                                <h3 class="mb-3 text-lg font-semibold text-gray-900">Job Description</h3>
                                <div class="text-sm prose-sm prose text-gray-700 max-w-none">
                                    <?php echo nl2br(htmlspecialchars($selectedJob['job_summary'])); ?>
                                </div>
                            </div>

                            <div class="flex flex-col gap-3 mt-8 sm:flex-row">
                                <?php if (!$hasProfile): ?>
                                    <a href="?page=complete-jobseeker-profile"
                                        class="w-full px-4 py-3 text-sm font-medium text-center text-white transition-colors bg-gray-600 rounded-lg hover:bg-gray-700">
                                        Complete Profile to Apply
                                    </a>
                                <?php elseif (isset($selectedJob['has_applied']) && $selectedJob['has_applied']): ?>
                                    <span class="w-full px-4 py-3 text-sm font-medium text-center text-gray-500 bg-gray-100 border border-gray-300 rounded-lg">
                                        <i class="mr-1 fas fa-check-circle"></i> Applied
                                    </span>
                                <?php else: ?>
                                    <a href="?page=apply-job&job_id=<?php echo $selectedJob['job_id']; ?>&step=1"
                                        class="w-full px-4 py-3 text-sm font-medium text-center text-white transition-colors rounded-lg bg-primary hover:bg-primary/90">
                                        <i class="mr-1 fas fa-paper-plane"></i> Apply Now
                                    </a>
                                <?php endif; ?>
                                <a href="?page=view-job&job_id=<?php echo $selectedJob['job_id']; ?>"
                                    class="w-full px-4 py-3 text-sm font-medium text-center transition-colors bg-white border rounded-lg text-primary border-primary hover:bg-primary/5">
                                    View Full Details
                                </a>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <!-- Empty State -->
                    <div class="flex flex-col items-center justify-center h-full p-8 text-center bg-white border border-gray-200 shadow-sm rounded-xl">
                        <i class="text-5xl text-gray-300 fas fa-briefcase"></i>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">Select a job to view details</h3>
                        <p class="mt-1 text-xs text-gray-500">Click on any job from the list to see its full details</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
    // Same JavaScript functions as before
    function toggleSaveJob(jobId, button) {
        const isSaved = button.querySelector('i').classList.contains('fas');
        const action = isSaved ? 'unsave-job' : 'save-job';

        fetch('ajax/job-actions.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    action: action,
                    job_id: jobId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const icon = button.querySelector('i');
                    if (isSaved) {
                        icon.classList.remove('fas', 'text-yellow-500');
                        icon.classList.add('far');
                    } else {
                        icon.classList.remove('far');
                        icon.classList.add('fas', 'text-yellow-500');
                    }
                    showToast(isSaved ? 'Job removed from saved' : 'Job saved successfully', 'success');

                    // Update the card in the list if it exists
                    const cardBtn = document.querySelector(`.job-card[onclick*="job_id=${jobId}"] button`);
                    if (cardBtn) {
                        const cardIcon = cardBtn.querySelector('i');
                        if (isSaved) {
                            cardIcon.classList.remove('fas', 'text-yellow-500');
                            cardIcon.classList.add('far');
                        } else {
                            cardIcon.classList.remove('far');
                            cardIcon.classList.add('fas', 'text-yellow-500');
                        }
                    }
                } else {
                    showToast('Action failed: ' + (data.message || 'Please try again'), 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('An error occurred. Please try again.', 'error');
            });
    }

    function showToast(message, type) {
        const toast = document.createElement('div');
        toast.className = `fixed bottom-5 right-5 px-4 py-2 rounded-md shadow-lg text-sm font-medium text-white transition-opacity duration-300 ease-in-out
                      ${type === 'success' ? 'bg-green-600' : 'bg-red-600'}`;
        toast.innerText = message;
        document.body.appendChild(toast);

        setTimeout(() => {
            toast.classList.add('opacity-0');
            setTimeout(() => {
                document.body.removeChild(toast);
            }, 300);
        }, 3000);
    }

    // Filter functionality
    function filterJobs(filterType, button) {
        // Update button states
        const filterButtons = document.querySelectorAll('[data-filter]');
        filterButtons.forEach(btn => {
            btn.classList.remove('bg-primary', 'text-white');
            btn.classList.add('bg-white', 'border-gray-300', 'text-gray-700');
        });

        // Set active button
        button.classList.remove('bg-white', 'border-gray-300', 'text-gray-700');
        button.classList.add('bg-primary', 'text-white');

        // Get all job cards
        const jobCards = document.querySelectorAll('.job-card');

        // Show all jobs first
        jobCards.forEach(card => {
            card.style.display = 'block';
        });

        // Apply filter logic
        if (filterType === 'recent') {
            // Sort by most recent (this is a simple example - you might want to implement server-side sorting)
            const jobContainer = document.querySelector('.space-y-3');
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
        const visibleJobs = document.querySelectorAll('.job-card[style="display: block"], .job-card:not([style*="display: none"])').length;
        const jobCountElement = document.querySelector('.text-gray-500');
        if (jobCountElement) {
            jobCountElement.textContent = `${visibleJobs} jobs`;
        }
    }

    // Advanced Filtering System
    function initializeFilters() {
        const searchInput = document.getElementById('jobSearch');
        const locationFilter = document.getElementById('locationFilter');
        const jobTypeFilter = document.getElementById('jobTypeFilter');
        const industryFilter = document.getElementById('industryFilter');
        const workplaceFilter = document.getElementById('workplaceFilter');
        const applyButton = document.getElementById('applyFilters');
        const clearButton = document.getElementById('clearFilters');

        // Apply filters function
        function applyFilters() {
            const searchTerm = searchInput.value.toLowerCase().trim();
            const selectedLocation = locationFilter.value.toLowerCase();
            const selectedJobType = jobTypeFilter.value.toLowerCase();
            const selectedIndustry = industryFilter.value.toLowerCase();
            const selectedWorkplace = workplaceFilter.value.toLowerCase();

            const jobCards = document.querySelectorAll('.job-card');
            let visibleCount = 0;

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
                if (selectedLocation && shouldShow) {
                    const locationText = card.querySelector('.text-gray-600').textContent.toLowerCase();
                    if (!locationText.includes(selectedLocation)) {
                        shouldShow = false;
                    }
                }

                // Job type filter
                if (selectedJobType && shouldShow) {
                    const jobTypeElement = card.querySelector('.text-primary');
                    if (jobTypeElement && !jobTypeElement.textContent.toLowerCase().includes(selectedJobType)) {
                        shouldShow = false;
                    }
                }

                // Industry filter (based on category)
                if (selectedIndustry && shouldShow) {
                    const categoryElements = card.querySelectorAll('.text-primary');
                    let hasMatchingCategory = false;
                    categoryElements.forEach(element => {
                        if (element.textContent.toLowerCase().includes(selectedIndustry)) {
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
                } else {
                    card.style.display = 'none';
                }
            });

            // Update job count
            updateJobCount(visibleCount);

            // Show message if no results
            showNoResultsMessage(visibleCount === 0);
        }

        // Clear all filters
        function clearFilters() {
            searchInput.value = '';
            locationFilter.value = '';
            jobTypeFilter.value = '';
            industryFilter.value = '';
            workplaceFilter.value = '';

            // Show all job cards
            const jobCards = document.querySelectorAll('.job-card');
            jobCards.forEach(card => {
                card.style.display = 'block';
            });

            updateJobCount(jobCards.length);
            showNoResultsMessage(false);
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

            if (show && !noResultsMessage) {
                const jobContainer = document.querySelector('.space-y-3');
                noResultsMessage = document.createElement('div');
                noResultsMessage.id = 'noResultsMessage';
                noResultsMessage.className = 'p-8 text-center text-gray-500';
                noResultsMessage.innerHTML = `
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0012 15c-2.137 0-4.146-.832-5.657-2.343"></path>
                    </svg>
                    <h3 class="mb-2 text-lg font-medium text-gray-900">No jobs found</h3>
                    <p class="text-sm">Try adjusting your filters or search terms</p>
                `;
                jobContainer.appendChild(noResultsMessage);
            } else if (!show && noResultsMessage) {
                noResultsMessage.remove();
            }
        }

        // Event listeners
        applyButton.addEventListener('click', applyFilters);
        clearButton.addEventListener('click', clearFilters);

        // Real-time search
        searchInput.addEventListener('input', debounce(applyFilters, 300));

        // Auto-apply on filter change
        [locationFilter, jobTypeFilter, industryFilter, workplaceFilter].forEach(filter => {
            filter.addEventListener('change', applyFilters);
        });
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

    // Initialize filters when page loads
    document.addEventListener('DOMContentLoaded', function() {
        initializeFilters();
    });
</script>