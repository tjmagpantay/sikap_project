<?php
include_once __DIR__ . '/components/jobseeker_auth_check.php';
include_once __DIR__ . '/../components/navbar-top.php';
include_once __DIR__ . '/components/navbar-jobseeker.php';
?>

<div class="min-h-screen px-4 sm:px-6 md:px-16 lg:px-24">
    <div class="py-8 mx-auto sm:px-2 md:px-4 lg:px-12 max-w-7xl">
        <!-- Breadcrumbs -->
        <nav class="mb-6">
            <div class="flex items-center space-x-2 text-sm">
                <a href="?page=dashboard" class="text-gray-500 transition-colors hover:text-primary">
                    Dashboard
                </a>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                <a href="?page=explore-companies" class="text-gray-500 transition-colors hover:text-primary">
                    Explore Companies
                </a>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                <?php if (isset($_GET['job_id']) && !empty($_GET['job_id'])): ?>
                    <a href="?page=view-job&job_id=<?php echo htmlspecialchars($_GET['job_id']); ?>" class="text-gray-500 transition-colors hover:text-primary">
                        <?php echo htmlspecialchars($_GET['job_title'] ?? 'Job Details'); ?>
                    </a>
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                <?php endif; ?>
                <span class="font-medium text-primary"><?php echo htmlspecialchars($employer['business_name'] ?? $employer['company_name'] ?? 'Company Profile'); ?></span>
            </div>
        </nav>

        <!-- Main Flex Layout -->
        <div class="flex flex-col gap-8 md:flex-row">
            <!-- Left Section - Main Content (8/12 width) -->
            <div class="w-full space-y-6 md:w-8/12">
                <!-- Employer Profile Card -->
                <div class="overflow-hidden bg-white border border-gray-200 rounded-lg shadow">
                    <!-- Profile Header -->
                    <div class="p-6 border-b border-gray-200 bg-gray-50">
                        <div class="flex items-start px-4 space-x-4">
                            <!-- Business Logo -->
                            <div class="flex items-center justify-center w-16 h-16 overflow-hidden border-2 border-gray-200 rounded-lg">
                                <?php if (!empty($employer['business_logo'])): ?>
                                    <img src="<?php echo htmlspecialchars($employer['business_logo']); ?>"
                                        alt="<?php echo htmlspecialchars($employer['business_name'] ?? 'Company'); ?> Logo"
                                        class="object-cover w-full h-full">
                                <?php else: ?>
                                    <i class="text-2xl text-gray-400 fas fa-building"></i>
                                <?php endif; ?>
                            </div>

                            <div class="flex-1">
                                <h1 class="text-xl font-bold text-gray-900">
                                    <?php echo htmlspecialchars($employer['business_name'] ?? $employer['company_name'] ?? 'Company Name'); ?>
                                </h1>

                                <?php if (!empty($employer['business_industry'])): ?>
                                    <p class="text-sm text-gray-600"><?php echo htmlspecialchars($employer['business_industry']); ?></p>
                                <?php endif; ?>

                                <!-- Company Stats -->
                                <div class="flex flex-wrap items-center gap-4 mt-3 text-sm">
                                    <?php if (!empty($employer['business_address'])): ?>
                                        <div class="flex items-center text-xs text-gray-600">
                                            <i class="mr-1 fas fa-map-marker-alt"></i>
                                            <?php echo htmlspecialchars($employer['business_address']); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Profile Content -->
                    <div class="p-6">
                        <!-- About Company -->
                        <?php if (!empty($employer['business_desc'])): ?>
                            <div class="mb-8">
                                <h2 class="mb-3 text-lg font-semibold text-primary">About the Company</h2>
                                <div class="text-sm font-light prose text-gray-600 max-w-none">
                                    <?php echo nl2br(htmlspecialchars($employer['business_desc'])); ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Company Details -->
                        <div class="mb-8">
                            <h2 class="mb-3 text-lg font-semibold text-primary">Company Details</h2>
                            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                <!-- Left Column -->
                                <div class="space-y-4">
                                    <?php if (!empty($employer['business_type'])): ?>
                                        <div>
                                            <div class="text-xs font-medium text-gray-500">Business Type</div>
                                            <div class="text-sm text-gray-900"><?php echo ucfirst(htmlspecialchars($employer['business_type'])); ?></div>
                                        </div>
                                    <?php else: ?>
                                        <div>
                                            <div class="text-xs font-medium text-gray-500">Business Type</div>
                                            <div class="text-sm text-gray-400">N/A</div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (!empty($employer['business_industry'])): ?>
                                        <div>
                                            <div class="text-xs font-medium text-gray-500">Industry</div>
                                            <div class="text-sm text-gray-900"><?php echo htmlspecialchars($employer['business_industry']); ?></div>
                                        </div>
                                    <?php else: ?>
                                        <div>
                                            <div class="text-xs font-medium text-gray-500">Industry</div>
                                            <div class="text-sm text-gray-400">N/A</div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (!empty($employer['business_established_year'])): ?>
                                        <div>
                                            <div class="text-xs font-medium text-gray-500">Year Established</div>
                                            <div class="text-sm text-gray-900"><?php echo htmlspecialchars($employer['business_established_year']); ?></div>
                                        </div>
                                    <?php else: ?>
                                        <div>
                                            <div class="text-xs font-medium text-gray-500">Year Established</div>
                                            <div class="text-sm text-gray-400">N/A</div>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <!-- Right Column -->
                                <div class="space-y-4">
                                    <?php if (!empty($employer['business_contact'])): ?>
                                        <div>
                                            <div class="text-xs font-medium text-gray-500">Contact Number</div>
                                            <div class="text-sm text-gray-900"><?php echo htmlspecialchars($employer['business_contact']); ?></div>
                                        </div>
                                    <?php else: ?>
                                        <div>
                                            <div class="text-xs font-medium text-gray-500">Contact Number</div>
                                            <div class="text-sm text-gray-400">N/A</div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (!empty($employer['business_website'])): ?>
                                        <div>
                                            <div class="text-xs font-medium text-gray-500">Website</div>
                                            <a href="<?php echo htmlspecialchars($employer['business_website']); ?>"
                                                target="_blank"
                                                class="text-sm text-primary hover:text-secondary hover:underline">
                                                <?php echo htmlspecialchars($employer['business_website']); ?>
                                            </a>
                                        </div>
                                    <?php else: ?>
                                        <div>
                                            <div class="text-xs font-medium text-gray-500">Website</div>
                                            <div class="text-sm text-gray-400">N/A</div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (!empty($employer['business_size'])): ?>
                                        <div>
                                            <div class="text-xs font-medium text-gray-500">Company Size</div>
                                            <div class="text-sm <?php echo !empty($employer['business_size']) ? 'text-gray-900' : 'text-gray-400'; ?>">
                                                <?php echo !empty($employer['business_size']) ? htmlspecialchars($employer['business_size']) : 'N/A'; ?>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <div>
                                            <div class="text-xs font-medium text-gray-500">Company Size</div>
                                            <div class="text-sm text-gray-400">N/A</div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Social Media Links -->
                        <?php if (!empty($employer['facebook_url']) || !empty($employer['twitter_url']) || !empty($employer['instagram_url']) || !empty($employer['youtube_url'])): ?>
                            <div class="mb-8">
                                <h2 class="mb-3 text-lg font-semibold text-primary">Follow Us</h2>
                                <div class="flex flex-wrap gap-3">

                                    <?php if (!empty($employer['facebook_url'])): ?>
                                        <a href="<?php echo htmlspecialchars($employer['facebook_url']); ?>"
                                            target="_blank"
                                            class="flex items-center justify-center gap-2 px-3 py-2 transition-colors duration-200 h-9 text-primary bg-blue-50 hover:bg-blue-600 hover:text-white">
                                            <!-- Facebook SVG -->
                                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                            </svg>
                                            <span class="text-xs">Facebook</span>
                                        </a>
                                    <?php endif; ?>

                                    <?php if (!empty($employer['twitter_url'])): ?>
                                        <a href="<?php echo htmlspecialchars($employer['twitter_url']); ?>"
                                            target="_blank"
                                            class="flex items-center justify-center gap-2 px-3 py-2 transition-colors duration-200 h-9 text-primary bg-blue-50 hover:bg-blue-600 hover:text-white">
                                            <!-- Twitter/X SVG -->
                                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                                            </svg>
                                            <span class="text-xs">Twitter</span>
                                        </a>
                                    <?php endif; ?>

                                    <?php if (!empty($employer['instagram_url'])): ?>
                                        <a href="<?php echo htmlspecialchars($employer['instagram_url']); ?>"
                                            target="_blank"
                                            class="flex items-center justify-center gap-2 px-3 py-2 transition-colors duration-200 h-9 text-primary bg-blue-50 hover:bg-blue-600 hover:text-white">
                                            <!-- Instagram SVG -->
                                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 6.62 5.367 11.987 11.988 11.987s11.987-5.367 11.987-11.987C24.014 5.367 18.647.001 12.017.001zM8.449 16.988c-1.297 0-2.448-.393-3.433-1.035-.985-.642-1.594-1.507-1.829-2.594-.235-1.088-.235-2.246 0-3.334.235-1.087.844-1.952 1.829-2.594.985-.642 2.136-1.035 3.433-1.035s2.448.393 3.433 1.035c.985.642 1.594 1.507 1.829 2.594.235 1.088.235 2.246 0 3.334-.235 1.087-.844 1.952-1.829 2.594-.985.642-2.136 1.035-3.433 1.035z" />
                                                <path d="M12 16c-2.209 0-4-1.791-4-4s1.791-4 4-4 4 1.791 4 4-1.791 4-4 4zm0-6c-1.105 0-2 .895-2 2s.895 2 2 2 2-.895 2-2-.895-2-2-2z" />
                                                <circle cx="16.5" cy="7.5" r="1.5" />
                                            </svg>
                                            <span class="text-xs">Instagram</span>
                                        </a>
                                    <?php endif; ?>

                                    <?php if (!empty($employer['youtube_url'])): ?>
                                        <a href="<?php echo htmlspecialchars($employer['youtube_url']); ?>"
                                            target="_blank"
                                            class="flex items-center justify-center gap-2 px-3 py-2 transition-colors duration-200 h-9 text-primary bg-blue-50 hover:bg-blue-600 hover:text-white">
                                            <!-- YouTube SVG -->
                                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                                            </svg>
                                            <span class="text-xs">YouTube</span>
                                        </a>
                                    <?php endif; ?>

                                </div>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
            </div>

            <!-- Right Section - Sidebar (4/12 width) -->
            <div class="w-full space-y-6 md:w-4/12">
                <div class="sticky top-8">
                    <!-- Current Job Openings -->
                    <!-- Current Job Openings -->
                    <?php if (!empty($activeJobs)): ?>
                        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold text-gray-900">Current Job Openings</h3>
                                <a href="?page=browse-jobs&employer_id=<?php echo $employer['employer_id']; ?>"
                                    class="px-3 py-2 text-xs font-medium transition-colors border text-primary border-primary hover:bg-primary hover:text-white">
                                    View All
                                </a>
                            </div>
                            <div class="space-y-3">
                                <?php foreach ($activeJobs as $activeJob): ?>
                                    <div class="p-3 px-4 transition-colors border border-gray-200 rounded-lg hover:bg-gray-50">
                                        <div class="flex items-center justify-between">
                                            <div class="flex-1">
                                                <h4 class="font-medium text-gray-900">
                                                    <a href="?page=view-job&job_id=<?php echo $activeJob['job_id']; ?>"
                                                        class="text-sm hover:text-primary">
                                                        <?php echo htmlspecialchars($activeJob['job_title']); ?>
                                                    </a>
                                                </h4>
                                                <div class="mt-1 text-xs text-gray-600">
                                                    <span class="flex items-center">

                                                        <?php echo htmlspecialchars($activeJob['location']); ?>
                                                    </span>
                                                    <?php if (!empty($activeJob['application_deadline'])): ?>
                                                        <span class="flex items-center mt-1">

                                                            Until <?php echo date('M j, Y', strtotime($activeJob['application_deadline'])); ?>
                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <a href="?page=view-job&job_id=<?php echo $activeJob['job_id']; ?>"
                                                class="px-3 py-2 ml-4 text-xs font-medium transition-colors bg-blue-50 text-primary hover:bg-blue-100">
                                                View
                                            </a>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
<!-- Quick Actions -->
<div class="p-6 bg-white border border-gray-200 rounded-lg shadow">
    <h3 class="mb-4 text-lg font-semibold text-gray-900">Quick Actions</h3>
    
    <div class="flex flex-wrap gap-3">
        <a href="?page=browse-jobs&employer_id=<?php echo $employer['employer_id']; ?>"
            class="flex items-center justify-center flex-1 px-4 py-2 text-sm font-medium text-white transition-colors rounded-md bg-primary hover:bg-secondary">
            <i class="mr-2 fas fa-search"></i>
            View All Jobs
        </a>

        <?php if (!empty($employer['business_website'])): ?>
            <a href="<?php echo htmlspecialchars($employer['business_website']); ?>" target="_blank"
                class="flex items-center justify-center flex-1 px-4 py-2 text-sm font-medium text-gray-700 transition-colors bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                <i class="mr-2 fas fa-external-link-alt"></i>
                Visit Website
            </a>
        <?php endif; ?>

        <button onclick="window.print()"
            class="flex items-center justify-center flex-1 px-4 py-2 text-sm font-medium text-gray-700 transition-colors bg-white border border-gray-300 rounded-md hover:bg-gray-50">
            <i class="mr-2 fas fa-print"></i>
            Print Profile
        </button>
    </div>
</div>

                </div>
            </div>
        </div>
    </div>
</div>