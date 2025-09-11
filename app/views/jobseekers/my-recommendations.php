<?php
// filepath: c:\xampp\htdocs\sikap\app\views\jobseekers\my-recommendations.php
require_once __DIR__ . '/navbar-jobseeker.php';
?>

<div class="min-h-screen bg-gray-50">
    <div class="px-4 py-8 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">
                <i class="mr-3 text-blue-600 fas fa-robot"></i>
                Your Job Recommendations
            </h1>
            <p class="mt-2 text-gray-600">
                AI-powered job matches tailored specifically for you
            </p>
        </div>

        <!-- Alert Messages -->
        <?php if ($error): ?>
            <div class="p-4 mb-6 border border-red-200 rounded-lg bg-red-50">
                <div class="flex">
                    <i class="fas fa-exclamation-circle text-red-400 mt-0.5 mr-3"></i>
                    <div>
                        <h3 class="text-sm font-medium text-red-800">Error</h3>
                        <p class="mt-1 text-sm text-red-700"><?= htmlspecialchars($error) ?></p>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="p-4 mb-6 border border-green-200 rounded-lg bg-green-50">
                <div class="flex">
                    <i class="fas fa-check-circle text-green-400 mt-0.5 mr-3"></i>
                    <div>
                        <h3 class="text-sm font-medium text-green-800">Success</h3>
                        <p class="mt-1 text-sm text-green-700"><?= htmlspecialchars($success) ?></p>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Filter Options -->
        <div class="p-6 mb-8 bg-white border border-gray-200 rounded-lg shadow-sm">
            <form method="get" action="" class="flex items-center gap-4">
                <input type="hidden" name="page" value="recommended-jobs">
                
                <div>
                    <label for="top_k" class="block text-sm font-medium text-gray-700">
                        Number of Recommendations
                    </label>
                    <select name="top_k" id="top_k" 
                            class="block px-3 py-2 mt-1 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="5" <?= $topK == 5 ? 'selected' : '' ?>>Top 5</option>
                        <option value="10" <?= $topK == 10 ? 'selected' : '' ?>>Top 10</option>
                        <option value="15" <?= $topK == 15 ? 'selected' : '' ?>>Top 15</option>
                        <option value="20" <?= $topK == 20 ? 'selected' : '' ?>>Top 20</option>
                    </select>
                </div>
                
                <div class="flex items-end">
                    <button type="submit" 
                            class="px-4 py-2 font-medium text-white transition-colors bg-blue-600 rounded-lg hover:bg-blue-700">
                        <i class="mr-2 fas fa-refresh"></i>
                        Refresh
                    </button>
                </div>
            </form>
        </div>

        <!-- Recommendations Results -->
        <?php if ($recommendations && $recommendations['success']): ?>
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                <!-- Results Header -->
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">
                                Job Recommendations for You
                            </h2>
                            <p class="mt-1 text-sm text-gray-600">
                                Found <?= $recommendations['total_found'] ?> matching jobs
                            </p>
                        </div>
                        <div class="text-sm text-gray-500">
                            <i class="mr-1 fas fa-clock"></i>
                            Generated at <?= date('Y-m-d H:i:s') ?>
                        </div>
                    </div>
                </div>

                <!-- Job Cards Layout (More user-friendly for jobseekers) -->
                <div class="p-6">
                    <div class="grid gap-6">
                        <?php foreach ($recommendations['recommendations'] as $index => $rec): ?>
                            <div class="p-6 transition-shadow border border-gray-200 rounded-lg hover:shadow-md">
                                <div class="flex items-start justify-between mb-4">
                                    <!-- Job Info -->
                                    <div class="flex-1">
                                        <div class="flex items-center mb-2">
                                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full <?= $index < 3 ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-600' ?> text-sm font-medium mr-3">
                                                #<?= $index + 1 ?>
                                            </span>
                                            <h3 class="text-xl font-semibold text-gray-900">
                                                <?= htmlspecialchars($rec['title'] ?? 'N/A') ?>
                                            </h3>
                                        </div>
                                        <p class="mb-2 text-gray-600">
                                            <i class="mr-1 fas fa-map-marker-alt"></i>
                                            <?= htmlspecialchars($rec['location'] ?? 'N/A') ?>
                                        </p>
                                        <?php if (!empty($rec['description'])): ?>
                                            <p class="text-sm text-gray-700">
                                                <?= htmlspecialchars(substr($rec['description'], 0, 200)) ?>...
                                            </p>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Match Score -->
                                    <div class="ml-6 text-center">
                                        <div class="text-3xl font-bold <?= $rec['match_percentage'] >= 70 ? 'text-green-600' : ($rec['match_percentage'] >= 50 ? 'text-yellow-600' : 'text-red-600') ?>">
                                            <?= $rec['match_percentage'] ?>%
                                        </div>
                                        <div class="text-sm text-gray-600">Match</div>
                                        <div class="w-16 h-2 mt-2 bg-gray-200 rounded-full">
                                            <div class="<?= $rec['match_percentage'] >= 70 ? 'bg-green-500' : ($rec['match_percentage'] >= 50 ? 'bg-yellow-500' : 'bg-red-500') ?> h-2 rounded-full transition-all duration-300" 
                                                 style="width: <?= $rec['match_percentage'] ?>%"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Skills and Tags -->
                                <div class="mb-4">
                                    <?php if (!empty($rec['matched_skills'])): ?>
                                        <div class="mb-2">
                                            <span class="text-sm font-medium text-gray-700">Matched Skills:</span>
                                            <div class="flex flex-wrap gap-1 mt-1">
                                                <?php foreach (array_slice($rec['matched_skills'], 0, 5) as $skill): ?>
                                                    <span class="inline-flex items-center px-2 py-1 text-xs text-blue-800 bg-blue-100 rounded-full">
                                                        <?= htmlspecialchars($skill) ?>
                                                    </span>
                                                <?php endforeach; ?>
                                                <?php if (count($rec['matched_skills']) > 5): ?>
                                                    <span class="text-xs text-gray-500">+<?= count($rec['matched_skills']) - 5 ?> more</span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex gap-3">
                                    <a href="?page=view-job&job_id=<?= $rec['job_id'] ?? '' ?>" 
                                       class="px-4 py-2 text-sm font-medium text-white transition-colors bg-blue-600 rounded-lg hover:bg-blue-700">
                                        <i class="mr-1 fas fa-eye"></i>
                                        View Details
                                    </a>
                                    <a href="?page=apply-job&job_id=<?= $rec['job_id'] ?? '' ?>" 
                                       class="px-4 py-2 text-sm font-medium text-blue-600 transition-colors bg-blue-100 rounded-lg hover:bg-blue-200">
                                        <i class="mr-1 fas fa-paper-plane"></i>
                                        Apply Now
                                    </a>
                                    <button class="px-4 py-2 text-sm font-medium text-gray-600 transition-colors bg-gray-100 rounded-lg hover:bg-gray-200">
                                        <i class="mr-1 fas fa-heart"></i>
                                        Save
                                    </button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <!-- No recommendations state -->
            <div class="p-12 text-center bg-white border border-gray-200 rounded-lg shadow-sm">
                <i class="mb-4 text-4xl text-gray-400 fas fa-search"></i>
                <h3 class="mb-2 text-lg font-medium text-gray-900">No Recommendations Yet</h3>
                <p class="mb-4 text-gray-600">
                    Complete your profile to get better job recommendations.
                </p>
                <a href="?page=profile-jobseeker" 
                   class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                    <i class="mr-2 fas fa-user-edit"></i>
                    Complete Profile
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    // Auto-refresh when top_k changes
    document.getElementById('top_k').addEventListener('change', function() {
        this.form.submit();
    });
</script>