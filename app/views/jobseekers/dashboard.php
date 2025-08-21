<?php
include_once __DIR__ . '/../components/navbar-top.php';
include_once __DIR__ . '/navbar-jobseeker.php';
?>

<div class="min-h-screen sm:px-6 md:px-16 lg:px-24 ">
    <div class="py-8 mx-auto sm:px-2 md:px-4 lg:px-12 max-w-7xl">
        <!-- Hero Section with Background -->
        <div class="relative px-6 py-6 mb-2 overflow-hidden rounded-xl sm:px-8 sm:py-12 lg:px-12 lg:py-16">
            <!-- Background Image and Gradient Overlay (below content) -->
            <div class="absolute inset-0 z-0 rounded-t-xl">
                <img src="assets/images/hero-page-bg.png"
                    alt="Hero Background"
                    class="object-cover w-full h-full opacity-20 rounded-t-xl"
                    onerror="this.style.display='none'">
                <div class="absolute inset-0 rounded-t-xl"
                    style="background: linear-gradient(to right, var(--color-primary, #092C4C) 0%, transparent 100%); opacity: 0.85;">
                </div>
            </div>

            <!-- Hero Content Only -->
            <div class="relative z-10 flex flex-col max-w-5xl gap-6 mx-auto rounded-t-xl" style="min-height:70px;">
                <div class="flex flex-col items-start justify-start flex-1 h-full md:items-start md:justify-start">
                    <h1 class="w-full mb-1 text-2xl font-bold text-white text-start sm:text-3xl lg:text-4xl md:w-auto md:text-left">
                        Find Your Dream Job Today
                    </h1>
                    <p class="max-w-2xl mt-2 text-sm leading-relaxed text-center text-white md:text-left sm:mt-3 sm:text-sm">
                        Apply job that match you.
                    </p>
                </div>
            </div>
        </div>


        <!-- Job Filtering Section - Same Width as Hero, White Background -->
        <div class="relative px-6 py-6 mb-6 bg-white shadow-sm sm:px-8 lg:px-12 rounded-xl">
            <div class="flex flex-col max-w-5xl gap-6 mx-auto">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:gap-3">

                    <!-- Search Jobs (Much Wider) -->
                    <div class="w-full lg:w-80">
                        <div class="flex items-center gap-2 px-3 py-3 transition-all bg-white border border-gray-300 rounded-lg focus-within:ring-2 focus-within:ring-primary/20 focus-within:border-primary hover:border-primary/50">
                            <img src="assets/icons/search-svgrepo-com.svg" class="w-5 h-5 text-gray-500" alt="Search Icon" />
                            <input type="text" id="jobSearch"
                                placeholder="Search for jobs..."
                                class="flex-1 text-sm text-gray-700 bg-transparent border-none outline-none focus:ring-0">
                        </div>
                    </div>

                    <!-- Location -->
                    <div class="w-full lg:w-40">
                        <div class="flex items-center gap-2 px-3 py-3 transition-all bg-white border border-gray-300 rounded-lg focus-within:ring-2 focus-within:ring-primary/20 focus-within:border-primary hover:border-primary/50">
                            <img src="assets/icons/location-information-svgrepo-com.svg" class="w-4 h-4 text-gray-500" alt="Location Icon" />
                            <select id="locationFilter"
                                class="flex-1 text-sm text-gray-700 bg-transparent border-none outline-none appearance-none cursor-pointer focus:ring-0">
                                <option value="">Location</option>
                                <option value="manila">Manila</option>
                                <option value="quezon-city">Quezon City</option>
                                <option value="makati">Makati</option>
                                <option value="taguig">Taguig</option>
                                <option value="pasig">Pasig</option>
                                <option value="cebu">Cebu</option>
                                <option value="davao">Davao</option>
                            </select>
                            <svg class="w-4 h-4 pointer-events-none text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Job Type -->
                    <div class="w-full lg:w-36">
                        <div class="flex items-center gap-2 px-3 py-3 transition-all bg-white border border-gray-300 rounded-lg focus-within:ring-2 focus-within:ring-primary/20 focus-within:border-primary hover:border-primary/50">
                            <select id="jobTypeFilter"
                                class="flex-1 text-sm text-gray-700 bg-transparent border-none outline-none appearance-none cursor-pointer focus:ring-0">
                                <option value="">Job Type</option>
                                <option value="full-time">Full-time</option>
                                <option value="part-time">Part-time</option>
                                <option value="contract">Contract</option>
                                <option value="temporary">Temporary</option>
                                <option value="internship">Internship</option>
                            </select>
                            <svg class="w-4 h-4 pointer-events-none text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Industry -->
                    <div class="w-full lg:w-40">
                        <div class="flex items-center gap-2 px-3 py-3 transition-all bg-white border border-gray-300 rounded-lg focus-within:ring-2 focus-within:ring-primary/20 focus-within:border-primary hover:border-primary/50">
                            <select id="industryFilter"
                                class="flex-1 text-sm text-gray-700 bg-transparent border-none outline-none appearance-none cursor-pointer focus:ring-0">
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
                            <svg class="w-4 h-4 pointer-events-none text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Workplace -->
                    <div class="w-full lg:w-36">
                        <div class="flex items-center gap-2 px-3 py-3 transition-all bg-white border border-gray-300 rounded-lg focus-within:ring-2 focus-within:ring-primary/20 focus-within:border-primary hover:border-primary/50">
                            <select id="workplaceFilter"
                                class="flex-1 text-sm text-gray-700 bg-transparent border-none outline-none appearance-none cursor-pointer focus:ring-0">
                                <option value="">Workplace</option>
                                <option value="on-site">On-site</option>
                                <option value="remote">Remote</option>
                                <option value="hybrid">Hybrid</option>
                            </select>
                            <svg class="w-4 h-4 pointer-events-none text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Filter/Clear Buttons -->
                    <div class="flex gap-2 lg:flex-shrink-0">
                        <button type="button" id="clearFilters"
                            class="px-4 py-3 text-sm font-medium text-gray-600 transition-all bg-gray-100 rounded-lg shadow-sm hover:bg-gray-200 focus:ring-2 focus:ring-gray-300 hover:shadow-md">
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
                                    <div class="relative p-6 transition-all border border-gray-200 rounded-lg cursor-pointer hover:border-primary hover:shadow-md job-card <?php echo (isset($_GET['job_id']) && $_GET['job_id'] == $job['job_id'] ? 'border-primary bg-primary/5' : ''); ?>"
                                        onclick="loadJobDetails(<?php echo $job['job_id']; ?>, this)"
                                        data-job-id="<?php echo $job['job_id']; ?>">



                                        <!-- Row 1: Business Profile + Job Title + Business Name + Urgent Tag -->
                                        <div class="flex items-center justify-between gap-2">
                                            <div class="flex items-center flex-1 gap-2">
                                                <!-- Business Profile Image -->
                                                <div class="flex items-center justify-center w-12 h-12 p-1 overflow-hidden rounded-md bg-primary">
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
                                                    <h3 class="text-base font-semibold leading-tight text-gray-900"><?php echo htmlspecialchars($job['job_title']); ?></h3>
                                                    <p class="text-sm text-gray-500"><?php echo htmlspecialchars($job['company_name'] ?? $job['business_name'] ?? ''); ?></p>
                                                </div>
                                            </div>

                                            <!-- Right side: Save button + Urgent Tag -->
                                            <div class="flex items-center flex-shrink-0 gap-2">
                                           

                                                <span class="px-2 py-1 text-xs font-medium text-white rounded-sm bg-primary">
                                                    Urgent
                                                </span>
                                            </div>
                                        </div>

                                        <!-- Row 2: Location with Icon -->
                                        <div class="flex items-center py-2">
                                            <!-- Location Marker SVG Icon -->
                                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            <span class="ml-2 text-sm text-gray-600"><?php echo htmlspecialchars($job['location']); ?></span>
                                        </div>



                                        <!-- Row 4: Tags for Job Info -->
                                        <div class="flex items-center gap-2 mb-4">
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
                                        <div class="flex items-center justify-between text-xs text-gray-400">
                                            <span>
                                                Posted <?php echo date('M j, Y', strtotime($job['created_at'])); ?>
                                            </span>

                                            <span class="flex items-center gap-1 text-primary">
                                                Best Matches: <span class="text-gray-">1 to 10</span>

                                                <!-- Smaller Circle with check -->
                                                <span class="flex items-center justify-center w-4 h-4 rounded-full bg-primary">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="w-2.5 h-2.5"
                                                        fill="none"
                                                        viewBox="0 0 24 24"
                                                        stroke="white"
                                                        stroke-width="">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                </span>

                                                <span class="text-sm font-medium text-primary">95%</span>
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
            <div class="w-full lg:w-[75%] xl:w-[75%]">
                <!-- AJAX Container for job details -->
                <div id="job-details-container">
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
                                            <p class="flex items-center text-gray-500">

                                                <span class="text-sm text-gray-500"><?php echo htmlspecialchars($selectedJob['company_name'] ?? $selectedJob['business_name'] ?? 'Company'); ?></span>
                                            </p>
                                            <p class="flex items-center text-gray-500">

                                                <span class="text-sm text-gray-500"><?php echo htmlspecialchars($selectedJob['location']); ?></span>
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
                                            <svg class="w-6 h-6" fill="<?php echo (isset($currentJob['is_saved']) && $currentJob['is_saved']) ? 'currentColor' : 'none'; ?>"
                                                stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
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
                                    <div class="text-sm font-normal prose-sm prose text-gray-600 max-w-none">
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
    </div>

    <script>
        // AJAX function to load job details
        function loadJobDetails(jobId, cardElement) {
            console.log('Loading job details for ID:', jobId);

            // Show loading state
            const container = document.getElementById('job-details-container');
            container.innerHTML = `
                <div class="flex flex-col items-center justify-center h-full p-8 text-center bg-white border border-gray-200 shadow-sm rounded-xl">
                    <div class="w-12 h-12 mb-4 border-b-2 rounded-full animate-spin border-primary"></div>
                    <p class="text-gray-500">Loading job details...</p>
                </div>
            `;

            // Update active card styling
            document.querySelectorAll('.job-card').forEach(card => {
                card.classList.remove('border-primary', 'bg-primary/5');
                card.classList.add('border-gray-200');
            });

            // Set active card
            cardElement.classList.remove('border-gray-200');
            cardElement.classList.add('border-primary', 'bg-primary/5');

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

                    return response.text();
                })
                .then(text => {
                    console.log('Raw response length:', text.length);
                    console.log('Raw response (first 500 chars):', text.substring(0, 500));

                    try {
                        const data = JSON.parse(text);
                        console.log('Parsed response data:', data);

                        if (data.success) {
                            container.innerHTML = data.html;
                        } else {
                            container.innerHTML = `
                            <div class="flex flex-col items-center justify-center h-full p-8 text-center bg-white border border-gray-200 shadow-sm rounded-xl">
                                <i class="text-5xl text-red-300 fas fa-exclamation-triangle"></i>
                                <h3 class="mt-4 text-lg font-medium text-gray-900">Error loading job details</h3>
                                <p class="mt-1 text-xs text-gray-500">${data.message || 'Please try again'}</p>
                            </div>
                        `;
                        }
                    } catch (e) {
                        console.error('JSON parse error:', e);
                        console.error('Raw text that failed to parse:', text);

                        // Show the raw response in case it's helpful for debugging
                        container.innerHTML = `
                        <div class="flex flex-col items-center justify-center h-full p-8 text-center bg-white border border-gray-200 shadow-sm rounded-xl">
                            <i class="text-5xl text-red-300 fas fa-exclamation-triangle"></i>
                            <h3 class="mt-4 text-lg font-medium text-gray-900">Invalid Response</h3>
                            <p class="mt-1 text-xs text-gray-500">Server returned invalid JSON</p>
                            <details class="mt-2 text-left">
                                <summary class="text-xs text-red-500 cursor-pointer">Show raw response</summary>
                                <pre class="max-w-md p-2 mt-2 overflow-auto text-xs bg-gray-100 rounded">${text.substring(0, 1000)}</pre>
                            </details>
                        </div>
                    `;
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                    container.innerHTML = `
                    <div class="flex flex-col items-center justify-center h-full p-8 text-center bg-white border border-gray-200 shadow-sm rounded-xl">
                        <i class="text-5xl text-red-300 fas fa-exclamation-triangle"></i>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">Connection Error</h3>
                        <p class="mt-1 text-xs text-gray-500">Please check your connection and try again</p>
                        <p class="mt-2 text-xs text-red-500">Error: ${error.message}</p>
                        <button onclick="loadJobDetails(${jobId}, this.closest('.job-card') || cardElement)" 
                                class="px-4 py-2 mt-3 text-xs text-white rounded bg-primary hover:bg-primary/90">
                            Retry
                        </button>
                    </div>
                `;
                });
        }

        // Same JavaScript functions as before
        function toggleSaveJob(jobId, button) {
            const isSaved = button.querySelector('svg').getAttribute('fill') === 'currentColor';
            const action = isSaved ? 'unsave' : 'save';

            // Show loading state
            button.disabled = true;
            const svg = button.querySelector('svg');
            svg.classList.add('animate-pulse');

            // Prepare form data
            const formData = new FormData();
            formData.append('job_id', jobId);

            const endpoint = isSaved ? '?page=unsave-job' : '?page=save-job';

            fetch(endpoint, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
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
                        // Update the button state
                        if (isSaved) {
                            svg.setAttribute('fill', 'none');
                            button.title = 'Save job';
                        } else {
                            svg.setAttribute('fill', 'currentColor');
                            button.title = 'Remove from saved';
                        }

                        showToast(data.message || (isSaved ? 'Job removed from saved' : 'Job saved successfully'), 'success');
                    } else {
                        showToast('Action failed: ' + (data.message || 'Please try again'), 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('An error occurred. Please try again.', 'error');
                })
                .finally(() => {
                    button.disabled = false;
                    svg.classList.remove('animate-pulse');
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
            clearButton.addEventListener('click', clearFilters);

            // Real-time search with debounce
            searchInput.addEventListener('input', debounce(applyFilters, 300));

            // Auto-apply filters immediately when dropdowns change
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