<?php
// filepath: c:\xampp\htdocs\sikap\app\views\jobseekers\my-recommendations-debug.php
include_once __DIR__ . '/../components/navbar-top.php';
include_once __DIR__ . '/navbar-jobseeker.php';
?>

<div class="min-h-screen bg-gray-50">
    <div class="px-4 py-8 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">
                <i class="mr-3 text-blue-600 fas fa-cogs"></i>
                Job Recommendation Analysis
            </h1>
            <p class="mt-2 text-gray-600">
                Detailed performance metrics and debugging information
            </p>
        </div>

        <!-- Success/Error Messages -->
        <?php if (isset($error) && $error): ?>
            <div class="p-4 mb-6 border border-red-200 rounded-lg bg-red-50">
                <div class="flex">
                    <i class="mr-3 text-red-400 fas fa-exclamation-circle"></i>
                    <div>
                        <h3 class="text-lg font-medium text-red-800">Recommendation Service Error</h3>
                        <p class="mt-1 text-red-700"><?= htmlspecialchars($error) ?></p>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if (isset($success) && $success): ?>
            <div class="p-4 mb-6 border border-green-200 rounded-lg bg-green-50">
                <div class="flex">
                    <i class="mr-3 text-green-400 fas fa-check-circle"></i>
                    <div>
                        <h3 class="text-lg font-medium text-green-800">Analysis Complete</h3>
                        <p class="mt-1 text-green-700"><?= htmlspecialchars($success) ?></p>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Jobseeker Profile Summary -->
        <?php if (isset($recommendations) && $recommendations && $recommendations['success']): ?>
            <div class="p-6 mb-8 bg-white border border-gray-200 rounded-lg shadow-sm">
                <h2 class="mb-4 text-lg font-semibold text-gray-900">Jobseeker Profile</h2>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div>
                        <strong>Name:</strong> <?= htmlspecialchars($recommendations['jobseeker']['name'] ?? 'N/A') ?>
                    </div>
                    <div>
                        <strong>Skills:</strong>
                        <span class="<?= empty($recommendations['jobseeker']['skills_text']) ? 'text-red-600' : 'text-green-600' ?>">
                            <?= htmlspecialchars($recommendations['jobseeker']['skills_text'] ?? 'No skills listed') ?>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Performance Summary -->
            <div class="p-6 mb-8 bg-white border border-gray-200 rounded-lg shadow-sm">
                <h2 class="mb-4 text-lg font-semibold text-gray-900">Recommendation Performance</h2>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
                    <div class="p-4 text-center rounded-lg bg-blue-50">
                        <div class="text-2xl font-bold text-blue-600"><?= $recommendations['total_jobs_analyzed'] ?? 0 ?></div>
                        <div class="text-sm text-gray-600">Jobs Analyzed</div>
                    </div>
                    <div class="p-4 text-center rounded-lg bg-green-50">
                        <div class="text-2xl font-bold text-green-600"><?= count($recommendations['recommendations'] ?? []) ?></div>
                        <div class="text-sm text-gray-600">Recommendations</div>
                    </div>
                    <div class="p-4 text-center rounded-lg bg-yellow-50">
                        <?php
                        $avgScore = 0;
                        if (!empty($recommendations['recommendations'])) {
                            $avgScore = array_sum(array_column($recommendations['recommendations'], 'final_score')) / count($recommendations['recommendations']);
                        }
                        ?>
                        <div class="text-2xl font-bold text-yellow-600"><?= number_format($avgScore * 100, 1) ?>%</div>
                        <div class="text-sm text-gray-600">Avg Match Score</div>
                    </div>
                    <div class="p-4 text-center rounded-lg bg-purple-50">
                        <?php
                        $topScore = 0;
                        if (!empty($recommendations['recommendations'])) {
                            $topScore = max(array_column($recommendations['recommendations'], 'final_score'));
                        }
                        ?>
                        <div class="text-2xl font-bold text-purple-600"><?= number_format($topScore * 100, 1) ?>%</div>
                        <div class="text-sm text-gray-600">Best Match</div>
                    </div>
                </div>
            </div>

            <!-- Debug Info -->
            <?php if (isset($recommendations['debug_info'])): ?>
                <div class="p-6 mb-8 border border-blue-200 rounded-lg bg-blue-50">
                    <h2 class="mb-4 text-lg font-semibold text-blue-900">Debug Information</h2>
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                        <div>
                            <strong>Jobseeker Skills Count:</strong> <?= $recommendations['debug_info']['jobseeker_skills_count'] ?? 'N/A' ?>
                        </div>
                        <div>
                            <strong>Average TF-IDF Score:</strong> <?= number_format(($recommendations['debug_info']['avg_tfidf'] ?? 0) * 100, 2) ?>%
                        </div>
                        <div>
                            <strong>Best Skill Match:</strong> <?= number_format(($recommendations['debug_info']['best_skill_match'] ?? 0) * 100, 2) ?>%
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Detailed Results Table -->
            <?php if (!empty($recommendations['recommendations'])): ?>
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Detailed Recommendation Results</h2>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 font-medium text-left text-gray-700">Rank</th>
                                    <th class="px-4 py-3 font-medium text-left text-gray-700">Job ID</th>
                                    <th class="px-4 py-3 font-medium text-left text-gray-700">Title</th>
                                    <th class="px-4 py-3 font-medium text-left text-gray-700">Location</th>
                                    <th class="px-4 py-3 font-medium text-center text-gray-700">Final Score</th>
                                    <th class="px-4 py-3 font-medium text-center text-gray-700">Match %</th>
                                    <th class="px-4 py-3 font-medium text-center text-gray-700">TF-IDF</th>
                                    <th class="px-4 py-3 font-medium text-center text-gray-700">Skill Overlap</th>
                                    <th class="px-4 py-3 font-medium text-center text-gray-700">ESCO Overlap</th>
                                    <th class="px-4 py-3 font-medium text-center text-gray-700">Role Match</th>
                                    <th class="px-4 py-3 font-medium text-left text-gray-700">Matched Skills</th>
                                    <th class="px-4 py-3 font-medium text-left text-gray-700">ESCO Skills</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <?php foreach ($recommendations['recommendations'] as $index => $rec): ?>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3">
                                            <span class="inline-flex items-center justify-center w-6 h-6 rounded-full <?= $index < 3 ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-600' ?> text-xs font-medium">
                                                <?= $index + 1 ?>
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 font-mono text-xs"><?= $rec['job_id'] ?? 'N/A' ?></td>
                                        <td class="px-4 py-3">
                                            <div class="font-medium text-gray-900"><?= htmlspecialchars($rec['title'] ?? 'N/A') ?></div>
                                            <div class="text-xs text-gray-500 truncate" style="max-width: 200px;">
                                                <?= htmlspecialchars(substr($rec['description'] ?? '', 0, 100)) ?>...
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 text-gray-700"><?= htmlspecialchars($rec['location'] ?? 'N/A') ?></td>

                                        <!-- Final Score -->
                                        <td class="px-4 py-3 text-center">
                                            <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full <?=
                                                                                                                                ($rec['final_score'] ?? 0) >= 0.7 ? 'bg-green-100 text-green-800' : (($rec['final_score'] ?? 0) >= 0.4 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') ?>">
                                                <?= number_format($rec['final_score'] ?? 0, 4) ?>
                                            </span>
                                        </td>

                                        <!-- Match Percentage -->
                                        <td class="px-4 py-3 text-center">
                                            <div class="font-semibold <?=
                                                                        ($rec['match_percentage'] ?? 0) >= 70 ? 'text-green-600' : (($rec['match_percentage'] ?? 0) >= 40 ? 'text-yellow-600' : 'text-red-600') ?>">
                                                <?= number_format($rec['match_percentage'] ?? 0, 2) ?>%
                                            </div>
                                        </td>

                                        <!-- Individual Metrics -->
                                        <td class="px-4 py-3 text-xs text-center">
                                            <div class="font-mono"><?= number_format($rec['tfidf_sim'] ?? 0, 3) ?></div>
                                            <div class="text-gray-500">40% weight</div>
                                        </td>
                                        <td class="px-4 py-3 text-xs text-center">
                                            <div class="font-mono"><?= number_format($rec['skill_overlap_ratio'] ?? 0, 3) ?></div>
                                            <div class="text-gray-500">30% weight</div>
                                        </td>
                                        <td class="px-4 py-3 text-xs text-center">
                                            <div class="font-mono"><?= number_format($rec['esco_overlap_ratio'] ?? 0, 3) ?></div>
                                            <div class="text-gray-500">20% weight</div>
                                        </td>
                                        <td class="px-4 py-3 text-xs text-center">
                                            <div class="<?= ($rec['role_match'] ?? false) ? 'text-green-600' : 'text-red-600' ?>">
                                                <?= ($rec['role_match'] ?? false) ? '✓' : '✗' ?>
                                            </div>
                                            <div class="text-gray-500">10% weight</div>
                                        </td>

                                        <!-- Matched Skills -->
                                        <td class="px-4 py-3">
                                            <?php if (!empty($rec['matched_skills'])): ?>
                                                <div class="flex flex-wrap gap-1">
                                                    <?php foreach (array_slice($rec['matched_skills'], 0, 3) as $skill): ?>
                                                        <span class="inline-flex items-center px-2 py-1 text-xs text-blue-800 bg-blue-100 rounded-full">
                                                            <?= htmlspecialchars($skill) ?>
                                                        </span>
                                                    <?php endforeach; ?>
                                                    <?php if (count($rec['matched_skills']) > 3): ?>
                                                        <span class="text-xs text-gray-500">+<?= count($rec['matched_skills']) - 3 ?></span>
                                                    <?php endif; ?>
                                                </div>
                                            <?php else: ?>
                                                <span class="text-xs text-gray-400">No matches</span>
                                            <?php endif; ?>
                                        </td>

                                        <!-- ESCO Skills -->
                                        <td class="px-4 py-3">
                                            <?php if (!empty($rec['matched_esco'])): ?>
                                                <div class="flex flex-wrap gap-1">
                                                    <?php foreach (array_slice($rec['matched_esco'], 0, 2) as $skill): ?>
                                                        <span class="inline-flex items-center px-2 py-1 text-xs text-purple-800 bg-purple-100 rounded-full">
                                                            <?= htmlspecialchars($skill) ?>
                                                        </span>
                                                    <?php endforeach; ?>
                                                    <?php if (count($rec['matched_esco']) > 2): ?>
                                                        <span class="text-xs text-gray-500">+<?= count($rec['matched_esco']) - 2 ?></span>
                                                    <?php endif; ?>
                                                </div>
                                            <?php else: ?>
                                                <span class="text-xs text-gray-400">No ESCO matches</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php else: ?>
                <!-- No Recommendations Found -->
                <div class="p-6 text-center border border-gray-200 rounded-lg bg-gray-50">
                    <i class="mb-4 text-4xl text-gray-400 fas fa-search"></i>
                    <h3 class="text-lg font-medium text-gray-900">No Recommendations Found</h3>
                    <p class="mt-2 text-gray-600">
                        The system analyzed <?= $recommendations['total_jobs_analyzed'] ?? 0 ?> jobs but found no suitable matches.
                    </p>
                    <div class="mt-4 text-sm text-gray-500">
                        <p>This could be due to:</p>
                        <ul class="mt-2 space-y-1">
                            <li>• Limited job postings in the database</li>
                            <li>• Skills mismatch between profile and available jobs</li>
                            <li>• Need for more detailed job requirements</li>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Performance Analysis & Recommendations -->
            <div class="p-6 mt-8 border border-yellow-200 rounded-lg bg-yellow-50">
                <h3 class="mb-4 text-lg font-semibold text-yellow-800">Performance Analysis & Recommendations</h3>
                <div class="space-y-3 text-sm text-yellow-700">
                    <?php if ($avgScore < 0.3): ?>
                        <div class="flex items-start">
                            <i class="fas fa-exclamation-triangle mt-0.5 mr-2"></i>
                            <div>
                                <strong>Low Overall Match Scores:</strong> Average match score is <?= number_format($avgScore * 100, 1) ?>%. Consider improving job skill data or jobseeker profile completeness.
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($recommendations['recommendations'])): ?>
                        <?php
                        $lowSkillOverlap = 0;
                        foreach ($recommendations['recommendations'] as $rec) {
                            if (($rec['skill_overlap_ratio'] ?? 0) < 0.2) $lowSkillOverlap++;
                        }
                        if ($lowSkillOverlap > count($recommendations['recommendations']) * 0.7):
                        ?>
                            <div class="flex items-start">
                                <i class="fas fa-tools mt-0.5 mr-2"></i>
                                <div>
                                    <strong>Poor Skill Matching:</strong> <?= $lowSkillOverlap ?> out of <?= count($recommendations['recommendations']) ?> jobs have low skill overlap. Add more comprehensive skill requirements to job posts.
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>

                    <!-- Current Performance Status -->
                    <div class="flex items-start">
                        <i class="fas fa-chart-line mt-0.5 mr-2"></i>
                        <div>
                            <strong>Current Status:</strong>
                            <?php if ($topScore >= 0.5): ?>
                                <span class="text-green-700">Good - Top match score is <?= number_format($topScore * 100, 1) ?>%</span>
                            <?php elseif ($topScore >= 0.3): ?>
                                <span class="text-yellow-700">Fair - Top match score is <?= number_format($topScore * 100, 1) ?>%</span>
                            <?php else: ?>
                                <span class="text-red-700">Needs Improvement - Top match score is only <?= number_format($topScore * 100, 1) ?>%</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <i class="fas fa-lightbulb mt-0.5 mr-2"></i>
                        <div>
                            <strong>Improvement Tips:</strong>
                            <ul class="mt-1 ml-4 list-disc">
                                <li>Ensure job posts have detailed skill requirements (currently seeing generic skills like "Technical Skills")</li>
                                <li>Use standardized skill names (e.g., "Python Programming" vs "Python")</li>
                                <li>Add more job descriptions with relevant keywords matching jobseeker skills</li>
                                <li>Consider adding jobs for: <?= htmlspecialchars($recommendations['jobseeker']['skills_text'] ?? '') ?></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        <?php else: ?>
            <!-- Error State -->
            <div class="p-6 text-center border border-red-200 rounded-lg bg-red-50">
                <i class="mb-4 text-4xl text-red-400 fas fa-exclamation-triangle"></i>
                <h3 class="text-lg font-medium text-red-900">Recommendation Service Not Available</h3>
                <p class="mt-2 text-red-700">
                    Unable to generate recommendations. Please check if:
                </p>
                <ul class="mt-4 text-sm text-red-600 list-disc list-inside">
                    <li>Python service is running properly</li>
                    <li>Database connection is working</li>
                    <li>Job posts and skills data are available</li>
                    <li>Jobseeker profile is complete</li>
                </ul>
            </div>
        <?php endif; ?>
    </div>
</div>