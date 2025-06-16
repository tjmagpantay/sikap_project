<?php
        include_once __DIR__ . '/../components/navbar-top.php';
        include_once __DIR__ . '/navbar-jobseeker.php';
?>
<div class="min-h-screen bg-gray-50">
    
    <nav class="bg-green-800 shadow">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <h1 class="text-xl font-semibold text-white">Jobseeker Dashboard</h1>
                </div>
                <div class="flex items-center">
                    <span class="mr-4 text-gray-300">Welcome, <?php echo htmlspecialchars($jobseeker['first_name'] ?? $_SESSION['email']); ?></span>
                    <a href="?page=logout" class="text-red-400 hover:underline">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <!-- Quick Profile Status Alert -->
            <?php if (!$hasProfile): ?>
                <div class="p-4 mb-6 border border-green-200 rounded-md bg-green-50">
                    <div class="flex items-center justify-between">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="text-green-400 fas fa-user-edit"></i>
                            </div>
                            
                            <div class="ml-3">
                                <h1 class="text-lg font-medium text-green-800">Find the Right Job</h1>
                                <form class="w-full max-w-md mb-4 md:max-w-lg lg:max-w-xl">
                                    <div class="flex flex-col gap-2 p-3 bg-white rounded-sm shadow md:flex-row md:flex-nowrap">
                                        <!-- Job Title Field -->
                                        <div class="flex items-center flex-1 min-w-0 px-2 py-1">
                                            <i class="mr-2 fa-solid fa-magnifying-glass text-primary"></i>
                                            <input
                                                type="text"
                                                placeholder="Job title"
                                                class="flex-1 min-w-0 text-sm bg-transparent border-none outline-none focus:ring-0"
                                            />
                                        </div>
                                        <!-- Separator -->
                                        <div class="hidden w-px h-8 bg-gray-300 md:block"></div>
                                        <!-- Location Field -->
                                        <div class="flex items-center flex-1 min-w-0 px-2 py-1 mt-2 md:mt-0">
                                            <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 11c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 11v10" />
                                            </svg>
                                            <input
                                                type="text"
                                                placeholder="Location"
                                                class="flex-1 min-w-0 text-sm bg-transparent border-none outline-none focus:ring-0"
                                            />
                                        </div>
                                        <!-- Search Button -->
                                        <button type="submit" class="w-full min-w-0 mt-2 btn-primary md:w-auto md:mt-0 md:ml-2">
                                            Search
                                        </button>
                                    </div>
                                </form>
                                <h5 class="mb-6 text-xs text-gray3">Search thousands of jobs and opportunities</h5>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Application Statistics (if profile exists) -->
            <?php if ($hasProfile && !empty($applicationStats)): ?>
                <div class="grid grid-cols-1 gap-5 mb-8 sm:grid-cols-2 lg:grid-cols-4">
                    <div class="overflow-hidden bg-white rounded-lg shadow">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <i class="text-2xl text-blue-500 fas fa-file-alt"></i>
                                </div>
                                <div class="flex-1 w-0 ml-5">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">Total Applications</dt>
                                        <dd class="text-lg font-medium text-gray-900"><?php echo $applicationStats['total']; ?></dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="overflow-hidden bg-white rounded-lg shadow">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <i class="text-2xl text-yellow-500 fas fa-clock"></i>
                                </div>
                                <div class="flex-1 w-0 ml-5">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">Pending</dt>
                                        <dd class="text-lg font-medium text-gray-900"><?php echo $applicationStats['pending']; ?></dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="overflow-hidden bg-white rounded-lg shadow">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <i class="text-2xl text-purple-500 fas fa-star"></i>
                                </div>
                                <div class="flex-1 w-0 ml-5">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">Shortlisted</dt>
                                        <dd class="text-lg font-medium text-gray-900"><?php echo $applicationStats['shortlisted']; ?></dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="overflow-hidden bg-white rounded-lg shadow">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <i class="text-2xl text-green-500 fas fa-check-circle"></i>
                                </div>
                                <div class="flex-1 w-0 ml-5">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">Hired</dt>
                                        <dd class="text-lg font-medium text-gray-900"><?php echo $applicationStats['hired']; ?></dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Dashboard Cards -->
            <div class="grid grid-cols-1 gap-6 md:grid-cols-4">
                <!-- Profile Card -->
                <div class="overflow-hidden transition-shadow bg-white rounded-lg shadow hover:shadow-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-user-edit text-2xl <?php echo $hasProfile ? 'text-green-500' : 'text-blue-500'; ?>"></i>
                            </div>
                            <div class="flex-1 w-0 ml-5">
                                <h3 class="text-lg font-medium text-gray-900">
                                    <?php echo $hasProfile ? 'Edit Profile' : 'Complete Profile'; ?>
                                </h3>
                                <p class="mt-1 text-sm text-gray-500">
                                    <?php echo $hasProfile ? 'Update your information' : 'Set up your profile'; ?>
                                </p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="?page=complete-jobseeker-profile" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white <?php echo $hasProfile ? 'bg-green-600 hover:bg-green-700' : 'bg-blue-600 hover:bg-blue-700'; ?>">
                                <?php echo $hasProfile ? 'Edit Profile' : 'Complete Profile'; ?>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Browse Jobs Card -->
                <div class="overflow-hidden transition-shadow bg-white rounded-lg shadow hover:shadow-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="text-2xl text-blue-500 fas fa-search"></i>
                            </div>
                            <div class="flex-1 w-0 ml-5">
                                <h3 class="text-lg font-medium text-gray-900">Browse Jobs</h3>
                                <p class="mt-1 text-sm text-gray-500">Find opportunities</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="?page=browse-jobs" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                                Browse Jobs
                            </a>
                        </div>
                    </div>
                </div>

                <!-- My Applications Card -->
                <div class="overflow-hidden transition-shadow bg-white rounded-lg shadow hover:shadow-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="text-2xl text-green-500 fas fa-file-alt"></i>
                            </div>
                            <div class="flex-1 w-0 ml-5">
                                <h3 class="text-lg font-medium text-gray-900">My Applications</h3>
                                <p class="mt-1 text-sm text-gray-500">Track applications</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="?page=my-applications" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md hover:bg-green-700">
                                View Applications
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Resume Builder Card -->
                <div class="overflow-hidden transition-shadow bg-white rounded-lg shadow hover:shadow-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="text-2xl text-purple-500 fas fa-file-pdf"></i>
                            </div>
                            <div class="flex-1 w-0 ml-5">
                                <h3 class="text-lg font-medium text-gray-900">Resume Builder</h3>
                                <p class="mt-1 text-sm text-gray-500">Create resume</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="?page=resume-builder" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-purple-600 border border-transparent rounded-md hover:bg-purple-700">
                                Build Resume
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Job Listings Section -->
            <div class="mt-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-semibold text-gray-900">Recent Job Opportunities</h2>
                    <a href="?page=browse-jobs" class="text-blue-600 hover:text-blue-800">
                        View All Jobs <i class="ml-1 fas fa-arrow-right"></i>
                    </a>
                </div>
                
                <!-- Check if jobs array exists and is not empty -->
                <?php if (!empty($jobs)): ?>
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                        <?php foreach ($jobs as $job): ?>
                            <!-- Job Card -->
                            <div class="overflow-hidden transition-shadow bg-white rounded-lg shadow hover:shadow-lg">
                                <div class="p-5">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <i class="text-2xl text-blue-500 fas fa-briefcase"></i>
                                        </div>
                                        <div class="flex-1 w-0 ml-4">
                                            <h3 class="text-lg font-medium text-gray-900"><?php echo htmlspecialchars($job['job_title']); ?></h3>
                                            <p class="mt-1 text-sm text-gray-500"><?php echo htmlspecialchars($job['company_name'] ?? ($job['employer_first_name'] . ' ' . $job['employer_last_name'])); ?></p>
                                            <p class="mt-2 text-sm text-gray-700"><?php echo substr(htmlspecialchars($job['job_summary']), 0, 100) . '...'; ?></p>
                                            
                                            <div class="mt-3 flex flex-wrap gap-2 text-xs text-gray-500">
                                                <span><i class="fas fa-map-marker-alt mr-1"></i><?php echo htmlspecialchars($job['location']); ?></span>
                                                <span><i class="fas fa-briefcase mr-1"></i><?php echo ucfirst(str_replace('-', ' ', $job['job_type'])); ?></span>
                                                <?php if ($job['show_pay'] && $job['salary']): ?>
                                                    <span><i class="fas fa-money-bill mr-1"></i>₱<?php echo number_format($job['salary'], 2); ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-4 flex space-x-2">
                                        <a href="?page=view-job&job_id=<?php echo $job['job_id']; ?>" 
                                           class="flex-1 px-3 py-2 text-sm font-medium text-blue-600 bg-blue-100 border border-blue-300 rounded-md hover:bg-blue-200 text-center">
                                            View Details
                                        </a>
                                        
                                        <?php if (!$hasProfile): ?>
                                            <a href="?page=complete-jobseeker-profile" 
                                               class="flex-1 px-3 py-2 text-sm font-medium text-white bg-gray-600 border border-transparent rounded-md hover:bg-gray-700 text-center">
                                                Complete Profile to Apply
                                            </a>
                                        <?php elseif ($job['has_applied']): ?>
                                            <span class="flex-1 px-3 py-2 text-sm font-medium text-gray-500 bg-gray-100 border border-gray-300 rounded-md text-center">
                                                <i class="mr-1 fas fa-check-circle"></i>
                                                Applied
                                            </span>
                                        <?php else: ?>
                                            <a href="?page=apply-job&job_id=<?php echo $job['job_id']; ?>" 
                                               class="flex-1 px-3 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 text-center">
                                                <i class="mr-1 fas fa-paper-plane"></i>
                                                Apply
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <!-- No jobs available -->
                    <div class="py-12 text-center bg-white rounded-lg shadow">
                        <i class="mb-4 text-6xl text-gray-400 fas fa-briefcase"></i>
                        <h3 class="mb-2 text-lg font-medium text-gray-900">No jobs available</h3>
                        <p class="mb-4 text-gray-500">Check back later for new job postings</p>
                        <a href="?page=browse-jobs" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                            Browse All Jobs
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
</div>