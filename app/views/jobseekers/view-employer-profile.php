<?php
// filepath: app/views/jobseekers/view-employer-profile.php
include_once __DIR__ . '/../components/navbar-top.php';
include_once __DIR__ . '/navbar-jobseeker.php';
?>

<div class="min-h-screen bg-gray-50">
    <div class="px-4 py-8 sm:px-6 md:px-16 lg:px-24">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="javascript:history.back()" class="inline-flex items-center text-sm font-medium text-primary hover:text-secondary">
                <i class="mr-2 fas fa-arrow-left"></i> Back
            </a>
        </div>

        <!-- Main Flex Layout -->
        <div class="flex flex-col gap-8 md:flex-row">
            <!-- Left Section - Main Content (8/12 width) -->
            <div class="w-full space-y-6 md:w-8/12">
                <!-- Employer Profile Card -->
                <div class="overflow-hidden bg-white border border-gray-200 rounded-lg shadow">
                    <!-- Profile Header -->
                    <div class="p-6 border-b border-gray-200 bg-gray-50">
                        <div class="flex items-start space-x-6">
                            <!-- Business Logo -->
                            <div class="flex items-center justify-center w-24 h-24 overflow-hidden border-2 border-gray-200 rounded-lg">
                                <?php if (!empty($employer['business_logo'])): ?>
                                    <img src="<?php echo htmlspecialchars($employer['business_logo']); ?>" alt="Company Logo"
                                        class="object-cover w-full h-full">
                                <?php else: ?>
                                    <i class="text-4xl text-gray-500 fas fa-building"></i>
                                <?php endif; ?>
                            </div>

                            <div class="flex-1">
                                <h1 class="text-2xl font-bold text-gray-900">
                                    <?php echo htmlspecialchars($employer['business_name'] ?? ($employer['first_name'] . ' ' . $employer['last_name'])); ?>
                                </h1>

                                <?php if (!empty($employer['business_industry'])): ?>
                                    <p class="mt-1 text-lg text-gray-600"><?php echo htmlspecialchars($employer['business_industry']); ?></p>
                                <?php endif; ?>

                                <!-- Company Stats -->
                                <div class="flex flex-wrap items-center gap-4 mt-3 text-sm">
                                    <div class="flex items-center text-gray-600">
                                        <i class="mr-1.5 text-gray-400 fas fa-map-marker-alt"></i>
                                        <?php echo htmlspecialchars($employer['business_address'] ?? 'Location not specified'); ?>
                                    </div>
                                    <div class="flex items-center text-gray-600">
                                        <i class="mr-1.5 text-gray-400 fas fa-briefcase"></i>
                                        <?php echo $employer['active_jobs_count'] ?? 0; ?> Active Jobs
                                    </div>
                                    <?php if (!empty($employer['business_established_year'])): ?>
                                        <div class="flex items-center text-gray-600">
                                            <i class="mr-1.5 text-gray-400 fas fa-calendar"></i>
                                            Established <?php echo htmlspecialchars($employer['business_established_year']); ?>
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
                                    <?php endif; ?>

                                    <?php if (!empty($employer['business_industry'])): ?>
                                        <div>
                                            <div class="text-xs font-medium text-gray-500">Industry</div>
                                            <div class="text-sm text-gray-900"><?php echo htmlspecialchars($employer['business_industry']); ?></div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (!empty($employer['business_size'])): ?>
                                        <div>
                                            <div class="text-xs font-medium text-gray-500">Company Size</div>
                                            <div class="text-sm text-gray-900"><?php echo htmlspecialchars($employer['business_size']); ?></div>
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
                                    <?php endif; ?>

                                    <?php if (!empty($employer['business_established_year'])): ?>
                                        <div>
                                            <div class="text-xs font-medium text-gray-500">Year Established</div>
                                            <div class="text-sm text-gray-900"><?php echo htmlspecialchars($employer['business_established_year']); ?></div>
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
                                            class="flex items-center px-4 py-2 text-sm font-medium text-white transition-colors bg-blue-600 rounded-lg hover:bg-blue-700">
                                            <i class="mr-2 fab fa-facebook"></i>
                                            Facebook
                                        </a>
                                    <?php endif; ?>

                                    <?php if (!empty($employer['twitter_url'])): ?>
                                        <a href="<?php echo htmlspecialchars($employer['twitter_url']); ?>"
                                            target="_blank"
                                            class="flex items-center px-4 py-2 text-sm font-medium text-white transition-colors bg-blue-400 rounded-lg hover:bg-blue-500">
                                            <i class="mr-2 fab fa-twitter"></i>
                                            Twitter
                                        </a>
                                    <?php endif; ?>

                                    <?php if (!empty($employer['instagram_url'])): ?>
                                        <a href="<?php echo htmlspecialchars($employer['instagram_url']); ?>"
                                            target="_blank"
                                            class="flex items-center px-4 py-2 text-sm font-medium text-white transition-colors bg-pink-600 rounded-lg hover:bg-pink-700">
                                            <i class="mr-2 fab fa-instagram"></i>
                                            Instagram
                                        </a>
                                    <?php endif; ?>

                                    <?php if (!empty($employer['youtube_url'])): ?>
                                        <a href="<?php echo htmlspecialchars($employer['youtube_url']); ?>"
                                            target="_blank"
                                            class="flex items-center px-4 py-2 text-sm font-medium text-white transition-colors bg-red-600 rounded-lg hover:bg-red-700">
                                            <i class="mr-2 fab fa-youtube"></i>
                                            YouTube
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Current Job Openings -->
                        <?php if (!empty($activeJobs)): ?>
                            <div class="mb-8">
                                <div class="flex items-center justify-between mb-3">
                                    <h2 class="text-lg font-semibold text-primary">Current Job Openings</h2>
                                    <a href="?page=browse-jobs&employer_id=<?php echo $employer['employer_id']; ?>"
                                        class="px-4 py-2 text-sm font-medium transition-colors border rounded-lg text-primary border-primary hover:bg-primary hover:text-white">
                                        View All Jobs
                                    </a>
                                </div>
                                <div class="space-y-3">
                                    <?php foreach ($activeJobs as $activeJob): ?>
                                        <div class="p-4 transition-colors border border-gray-200 rounded-lg hover:bg-gray-50">
                                            <div class="flex items-start justify-between">
                                                <div class="flex-1">
                                                    <h3 class="font-medium text-gray-900">
                                                        <a href="?page=view-job&job_id=<?php echo $activeJob['job_id']; ?>"
                                                            class="hover:text-primary">
                                                            <?php echo htmlspecialchars($activeJob['job_title']); ?>
                                                        </a>
                                                    </h3>
                                                    <div class="flex flex-wrap items-center gap-3 mt-2 text-sm text-gray-600">
                                                        <span class="flex items-center">
                                                            <i class="mr-1 fas fa-briefcase"></i>
                                                            <?php echo ucfirst(str_replace('-', ' ', $activeJob['job_type'])); ?>
                                                        </span>
                                                        <span class="flex items-center">
                                                            <i class="mr-1 fas fa-map-marker-alt"></i>
                                                            <?php echo htmlspecialchars($activeJob['location']); ?>
                                                        </span>
                                                        <?php if (!empty($activeJob['category_name'])): ?>
                                                            <span class="flex items-center">
                                                                <i class="mr-1 fas fa-tag"></i>
                                                                <?php echo htmlspecialchars($activeJob['category_name']); ?>
                                                            </span>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="mt-2 text-xs text-gray-500">
                                                        Posted <?php echo date('M j, Y', strtotime($activeJob['created_at'])); ?>
                                                        <?php if (!empty($activeJob['application_deadline'])): ?>
                                                            • Deadline: <?php echo date('M j, Y', strtotime($activeJob['application_deadline'])); ?>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                <a href="?page=view-job&job_id=<?php echo $activeJob['job_id']; ?>"
                                                    class="px-4 py-2 text-sm font-medium text-white transition-colors rounded-lg bg-primary hover:bg-secondary">
                                                    View Job
                                                </a>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Right Section - Sidebar (4/12 width) -->
            <div class="w-full md:w-4/12">
                <!-- Company Stats Card -->
                <div class="p-6 mb-6 bg-white border border-gray-200 rounded-lg shadow">
                    <h3 class="mb-4 text-lg font-semibold text-gray-900">Company Statistics</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-3 rounded-md bg-gray-50">
                            <span class="text-sm font-light text-gray-600">Active Jobs:</span>
                            <span class="font-bold text-primary text-md"><?php echo $employer['active_jobs_count'] ?? 0; ?></span>
                        </div>
                        <div class="flex items-center justify-between p-3 rounded-md bg-gray-50">
                            <span class="text-sm font-light text-gray-600">Total Jobs Posted:</span>
                            <span class="font-bold text-primary text-md"><?php echo $employer['total_jobs_count'] ?? 0; ?></span>
                        </div>
                        <?php if (!empty($employer['business_established_year'])): ?>
                            <div class="flex items-center justify-between p-3 rounded-md bg-gray-50">
                                <span class="text-sm font-light text-gray-600">Years in Business:</span>
                                <span class="font-bold text-primary text-md"><?php echo date('Y') - intval($employer['business_established_year']); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow">
                    <h3 class="mb-4 text-lg font-semibold text-gray-900">Quick Actions</h3>
                    <div class="space-y-3">
                        <a href="?page=browse-jobs&employer_id=<?php echo $employer['employer_id']; ?>"
                            class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-white transition-colors rounded-md bg-primary hover:bg-secondary">
                            <i class="mr-2 fas fa-search"></i>
                            View All Jobs
                        </a>

                        <?php if (!empty($employer['business_website'])): ?>
                            <a href="<?php echo htmlspecialchars($employer['business_website']); ?>"
                                target="_blank"
                                class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-gray-700 transition-colors bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                <i class="mr-2 fas fa-external-link-alt"></i>
                                Visit Website
                            </a>
                        <?php endif; ?>

                        <button onclick="window.print()"
                            class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-gray-700 transition-colors bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                            <i class="mr-2 fas fa-print"></i>
                            Print Profile
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>