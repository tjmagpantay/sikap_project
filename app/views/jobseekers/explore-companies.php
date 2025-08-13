<?php
// filepath: app/views/jobseekers/explore-companies.php
include_once __DIR__ . '/../components/navbar-top.php';
include_once __DIR__ . '/navbar-jobseeker.php';
?>

<div class="min-h-screen bg-gray-50">
    <div class="px-4 py-8 sm:px-6 md:px-16 lg:px-24">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Explore Companies</h1>
            <p class="mt-2 text-sm text-gray-600">Discover amazing companies and explore their job opportunities</p>
        </div>

        <!-- Companies Grid -->
        <?php if (empty($employers)): ?>
            <div class="py-12 text-center">
                <i class="mb-4 text-6xl text-gray-400 fas fa-building"></i>
                <h3 class="mb-2 text-lg font-medium text-gray-900">No companies found</h3>
                <p class="text-gray-500">Check back later for new companies joining our platform</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <?php foreach ($employers as $employer): ?>
                    <div class="overflow-hidden bg-white border border-gray-200 rounded-lg shadow hover:shadow-lg transition-shadow duration-200">
                        <!-- Company Header -->
                        <div class="p-6 border-b border-gray-100 bg-gray-50">
                            <div class="flex items-start space-x-4">
                                <!-- Company Logo -->
                                <div class="flex items-center justify-center w-16 h-16 overflow-hidden bg-white border-2 border-gray-200 rounded-lg flex-shrink-0">
                                    <?php if (!empty($employer['business_logo'])): ?>
                                        <img src="<?php echo htmlspecialchars($employer['business_logo']); ?>"
                                            alt="<?php echo htmlspecialchars($employer['business_name']); ?> Logo"
                                            class="object-cover w-full h-full">
                                    <?php else: ?>
                                        <i class="text-2xl text-gray-400 fas fa-building"></i>
                                    <?php endif; ?>
                                </div>

                                <div class="flex-1 min-w-0">
                                    <h3 class="text-lg font-bold text-gray-900 truncate">
                                        <?php echo htmlspecialchars($employer['business_name']); ?>
                                    </h3>

                                    <?php if (!empty($employer['business_industry'])): ?>
                                        <p class="text-sm text-gray-600 truncate">
                                            <?php echo htmlspecialchars($employer['business_industry']); ?>
                                        </p>
                                    <?php endif; ?>

                                    <div class="flex items-center gap-4 mt-2 text-xs text-gray-500">
                                        <span class="flex items-center">
                                            <i class="mr-1 fas fa-briefcase"></i>
                                            <?php echo $employer['active_jobs_count']; ?> Active Jobs
                                        </span>
                                        <?php if (!empty($employer['business_type'])): ?>
                                            <span class="flex items-center">
                                                <i class="mr-1 fas fa-tag"></i>
                                                <?php echo ucfirst(htmlspecialchars($employer['business_type'])); ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Company Info -->
                        <div class="p-6">
                            <?php if (!empty($employer['business_desc'])): ?>
                                <p class="text-sm text-gray-600 line-clamp-3 mb-4">
                                    <?php echo htmlspecialchars(substr($employer['business_desc'], 0, 150)) . (strlen($employer['business_desc']) > 150 ? '...' : ''); ?>
                                </p>
                            <?php endif; ?>

                            <?php if (!empty($employer['business_address'])): ?>
                                <div class="flex items-center mb-3 text-sm text-gray-500">
                                    <i class="mr-2 fas fa-map-marker-alt"></i>
                                    <span class="truncate"><?php echo htmlspecialchars($employer['business_address']); ?></span>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($employer['business_website'])): ?>
                                <div class="flex items-center mb-3 text-sm">
                                    <i class="mr-2 text-gray-500 fas fa-globe"></i>
                                    <a href="<?php echo htmlspecialchars($employer['business_website']); ?>"
                                        target="_blank"
                                        class="text-primary hover:text-secondary hover:underline truncate">
                                        <?php echo htmlspecialchars($employer['business_website']); ?>
                                    </a>
                                </div>
                            <?php endif; ?>

                            <!-- Social Media Links (if available) -->
                            <?php if (!empty($employer['facebook_url']) || !empty($employer['twitter_url']) || !empty($employer['instagram_url']) || !empty($employer['youtube_url'])): ?>
                                <div class="flex gap-2 mb-4">
                                    <?php if (!empty($employer['facebook_url'])): ?>
                                        <a href="<?php echo htmlspecialchars($employer['facebook_url']); ?>"
                                            target="_blank"
                                            class="flex items-center justify-center w-8 h-8 text-white bg-blue-600 rounded-full hover:bg-blue-700">
                                            <i class="text-xs fab fa-facebook"></i>
                                        </a>
                                    <?php endif; ?>

                                    <?php if (!empty($employer['twitter_url'])): ?>
                                        <a href="<?php echo htmlspecialchars($employer['twitter_url']); ?>"
                                            target="_blank"
                                            class="flex items-center justify-center w-8 h-8 text-white bg-blue-400 rounded-full hover:bg-blue-500">
                                            <i class="text-xs fab fa-twitter"></i>
                                        </a>
                                    <?php endif; ?>

                                    <?php if (!empty($employer['instagram_url'])): ?>
                                        <a href="<?php echo htmlspecialchars($employer['instagram_url']); ?>"
                                            target="_blank"
                                            class="flex items-center justify-center w-8 h-8 text-white bg-pink-600 rounded-full hover:bg-pink-700">
                                            <i class="text-xs fab fa-instagram"></i>
                                        </a>
                                    <?php endif; ?>

                                    <?php if (!empty($employer['youtube_url'])): ?>
                                        <a href="<?php echo htmlspecialchars($employer['youtube_url']); ?>"
                                            target="_blank"
                                            class="flex items-center justify-center w-8 h-8 text-white bg-red-600 rounded-full hover:bg-red-700">
                                            <i class="text-xs fab fa-youtube"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Action Buttons -->
                        <div class="p-6 pt-0">
                            <div class="flex gap-2">
                                <a href="?page=view-employer-profile&employer_id=<?php echo $employer['employer_id']; ?>"
                                    class="flex-1 px-4 py-2 text-sm font-medium text-center text-white transition-colors rounded-lg bg-primary hover:bg-secondary">
                                    View Profile
                                </a>

                                <?php if ($employer['active_jobs_count'] > 0): ?>
                                    <a href="?page=browse-jobs&employer_id=<?php echo $employer['employer_id']; ?>"
                                        class="flex-1 px-4 py-2 text-sm font-medium text-center transition-colors border rounded-lg text-primary border-primary hover:bg-primary hover:text-white">
                                        View Jobs (<?php echo $employer['active_jobs_count']; ?>)
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Load More Button (if needed in the future) -->
            <div class="mt-12 text-center">
                <p class="text-sm text-gray-500">
                    Showing <?php echo count($employers); ?> companies
                </p>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>