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
                <h3 class="mb-2 text-lg font-medium text-gray-900">No verified companies found</h3>
                <p class="text-gray-500">Companies must complete their profiles and verification process before appearing here. Check back later for new companies joining our platform.</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <?php foreach ($employers as $employer): ?>
                    <div class="overflow-hidden transition-shadow duration-200 bg-white border border-gray-200 rounded-lg shadow hover:shadow-lg">
                        <!-- Company Header -->
                        <div class="p-6 border-b border-gray-100 bg-gray-50">
                            <div class="flex items-start space-x-4">
                                <!-- Company Logo -->
                                <div class="flex items-center justify-center flex-shrink-0 w-16 h-16 overflow-hidden bg-white border-2 border-gray-200 rounded-lg">
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
                                <p class="mb-4 text-sm text-gray-600 line-clamp-3">
                                    <?php echo htmlspecialchars(substr($employer['business_desc'], 0, 150)) . (strlen($employer['business_desc']) > 150 ? '...' : ''); ?>
                                </p>
                            <?php endif; ?>
<?php if (!empty($employer['business_address'])): ?>
                                <div class="flex items-center mb-3 text-sm text-gray-500">
                                    <!-- Location/Map Marker SVG -->
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <span class="truncate"><?php echo htmlspecialchars($employer['business_address']); ?></span>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($employer['business_website'])): ?>
                                <div class="flex items-center mb-3 text-sm">
                                    <!-- Globe/Website SVG -->
                                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                                    </svg>
                                    <a href="<?php echo htmlspecialchars($employer['business_website']); ?>"
                                        target="_blank"
                                        class="truncate text-primary hover:text-secondary hover:underline">
                                        <?php echo htmlspecialchars($employer['business_website']); ?>
                                    </a>
                                </div>
                            <?php endif; ?>

                           <!-- Social Media Links (if available) -->
                            <?php if (!empty($employer['facebook_url']) || !empty($employer['twitter_url']) || !empty($employer['instagram_url']) || !empty($employer['youtube_url'])): ?>
                                <div class="flex gap-2">
                                    <?php if (!empty($employer['facebook_url'])): ?>
                                        <a href="<?php echo htmlspecialchars($employer['facebook_url']); ?>"
                                            target="_blank"
                                            class="flex items-center justify-center h-8 gap-2 px-2 transition-colors duration-200 rounded-sm text-primary bg-blue-50 w-28 hover:bg-blue-700">
                                            <!-- Facebook SVG -->
                                            <svg class="flex-shrink-0" width="16" height="16" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                            </svg>
                                            <p class="text-xs text-primary">Facebook</p>
                                        </a>
                                    <?php endif; ?>

                                    <?php if (!empty($employer['twitter_url'])): ?>
                                        <a href="<?php echo htmlspecialchars($employer['twitter_url']); ?>"
                                            target="_blank"
                                            class="flex items-center justify-center h-8 gap-2 px-2 transition-colors duration-200 rounded-sm text-primary bg-blue-50 w-28 hover:bg-blue-700">
                                            <!-- Twitter/X SVG -->
                                            <svg class="flex-shrink-0" width="16" height="16" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                                            </svg>
                                            <p class="text-xs text-primary">Twitter</p>
                                        </a>
                                    <?php endif; ?>

                                    <?php if (!empty($employer['instagram_url'])): ?>
                                        <a href="<?php echo htmlspecialchars($employer['instagram_url']); ?>"
                                            target="_blank"
                                            class="flex items-center justify-center h-8 gap-2 px-2 transition-colors duration-200 rounded-sm text-primary bg-blue-50 w-28 hover:bg-blue-700">
                                            <!-- Instagram SVG -->
                                            <svg class="flex-shrink-0" width="16" height="16" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 6.62 5.367 11.987 11.988 11.987s11.987-5.367 11.987-11.987C24.014 5.367 18.647.001 12.017.001zM8.449 16.988c-1.297 0-2.448-.393-3.433-1.035-.985-.642-1.594-1.507-1.829-2.594-.235-1.088-.235-2.246 0-3.334.235-1.087.844-1.952 1.829-2.594.985-.642 2.136-1.035 3.433-1.035s2.448.393 3.433 1.035c.985.642 1.594 1.507 1.829 2.594.235 1.088.235 2.246 0 3.334-.235 1.087-.844 1.952-1.829 2.594-.985.642-2.136 1.035-3.433 1.035z"/>
                                                <path d="M12 16c-2.209 0-4-1.791-4-4s1.791-4 4-4 4 1.791 4 4-1.791 4-4 4zm0-6c-1.105 0-2 .895-2 2s.895 2 2 2 2-.895 2-2-.895-2-2-2z"/>
                                                <circle cx="16.5" cy="7.5" r="1.5"/>
                                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073z"/>
                                            </svg>
                                            <p class="text-xs text-primary">Instagram</p>
                                        </a>
                                    <?php endif; ?>

                                    <?php if (!empty($employer['youtube_url'])): ?>
                                        <a href="<?php echo htmlspecialchars($employer['youtube_url']); ?>"
                                            target="_blank"
                                            class="flex items-center justify-center h-8 gap-2 px-2 transition-colors duration-200 rounded-sm text-primary bg-blue-50 w-28 hover:bg-blue-700">
                                            <!-- YouTube SVG -->
                                            <svg class="flex-shrink-0" width="16" height="16" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                            </svg>
                                            <p class="text-xs text-primary">YouTube</p>
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