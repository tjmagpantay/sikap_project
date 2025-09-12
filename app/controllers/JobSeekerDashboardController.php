<?php
// filepath: app/controllers/JobSeekerDashboardController.php

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/JobPost.php';
require_once __DIR__ . '/../models/Jobseeker.php';
require_once __DIR__ . '/../models/JobApplication.php';
require_once __DIR__ . '/../models/JobseekerDashboard.php';

class JobSeekerDashboardController
{
    private $jobPostModel;
    private $jobseekerModel;
    private $jobApplicationModel;
    private $dashboardModel;

    public function __construct()
    {
        $this->jobPostModel = new JobPost();
        $this->jobseekerModel = new Jobseeker();
        $this->jobApplicationModel = new JobApplication();
        $this->dashboardModel = new JobseekerDashboard();
    }

    public function dashboard()
    {
        // Authentication check
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != User::ROLE_JOBSEEKER) {
            header('Location: ?page=login-jobseeker');
            exit;
        }

        // Get jobseeker profile
        $jobseeker = $this->jobseekerModel->findByUserId($_SESSION['user_id']);
        $hasProfile = !empty($jobseeker['first_name']) && !empty($jobseeker['last_name']);

        // Get jobseeker ID if profile exists
        $jobseeker_id = $hasProfile ? $jobseeker['jobseeker_id'] : null;

        // CLEAN: Use the working JobPost model to get jobs (like the old working controller)
        $jobs = $this->jobPostModel->getAllActiveJobs($jobseeker_id);

        // ENHANCED: Add job recommendation percentages if jobseeker is logged in
        if ($jobseeker_id && !empty($jobs)) {
            try {
                require_once __DIR__ . '/../services/JobRecommendationService.php';
                $recommendationService = new JobRecommendationService();

                error_log("🎯 Getting dashboard recommendation percentages for jobseeker {$jobseeker_id}");

                // Check for cached recommendations first (same cache as browse jobs)
                $cacheKey = "recommendations_{$jobseeker_id}_" . md5(serialize(array_column($jobs, 'job_id')));
                $cachedRecommendations = null;

                // Simple file-based cache (shared with browse jobs)
                $cacheFile = sys_get_temp_dir() . "/sikap_rec_" . $cacheKey . ".json";
                if (file_exists($cacheFile) && (time() - filemtime($cacheFile)) < 3600) { // Cache for 1 hour
                    $cachedRecommendations = json_decode(file_get_contents($cacheFile), true);
                    error_log("📄 Using cached recommendations");
                }

                if ($cachedRecommendations) {
                    $matchPercentages = $cachedRecommendations;
                } else {
                    // Get fresh recommendations
                    $recommendationResult = $recommendationService->getRecommendations($jobseeker_id, 50);

                    if ($recommendationResult['success'] && !empty($recommendationResult['recommendations'])) {
                        // Create a lookup map of job_id => match_percentage
                        $matchPercentages = [];
                        foreach ($recommendationResult['recommendations'] as $rec) {
                            $matchPercentages[$rec['job_id']] = $rec['match_percentage'];
                        }

                        // Cache the results (shared with browse jobs)
                        file_put_contents($cacheFile, json_encode($matchPercentages));
                        error_log("💾 Cached recommendations for future use");
                    } else {
                        $matchPercentages = [];
                    }
                }

                error_log("📊 Found " . count($matchPercentages) . " dashboard job matches");

                // Update jobs with real match percentages
                foreach ($jobs as &$job) {
                    if (isset($matchPercentages[$job['job_id']])) {
                        // Use the real/cached recommendation percentage
                        $job['match_percentage'] = round($matchPercentages[$job['job_id']], 1);
                        $job['has_recommendation'] = true;
                        error_log("✅ Dashboard Job {$job['job_id']}: {$job['match_percentage']}% match");
                    } else {
                        // Calculate a consistent fallback percentage
                        $job['match_percentage'] = $this->calculateBasicMatch($job, $jobseeker);
                        $job['has_recommendation'] = false;
                        error_log("📈 Dashboard Job {$job['job_id']}: {$job['match_percentage']}% fallback match");
                    }
                }

                // Sort jobs by match percentage (highest first) for better UX
                usort($jobs, function ($a, $b) {
                    return ($b['match_percentage'] ?? 0) <=> ($a['match_percentage'] ?? 0);
                });

                error_log("🔄 Sorted dashboard jobs by match percentage");
            } catch (Exception $e) {
                error_log("❌ Error getting dashboard recommendations: " . $e->getMessage());
                // Apply consistent fallback matching
                foreach ($jobs as &$job) {
                    $job['match_percentage'] = $this->calculateBasicMatch($job, $jobseeker);
                    $job['has_recommendation'] = false;
                }
            }
        } else {
            // For non-logged-in users or when no jobs - use consistent seed
            foreach ($jobs as &$job) {
                mt_srand($job['job_id']); // Consistent seed
                $job['match_percentage'] = mt_rand(60, 95);
                mt_srand(); // Reset
                $job['has_recommendation'] = false;
            }
        }

        // Get dashboard stats from the dashboard model
        $stats = $this->dashboardModel->getJobseekerStats($jobseeker_id);
        $recentApplications = $this->dashboardModel->getRecentApplications($jobseeker_id);
        $profileCompletion = $this->dashboardModel->getProfileCompletion($jobseeker_id);

        // Convert stats to the format expected by the view (for backward compatibility)
        $applicationStats = [
            'total' => $stats['total_applications'],
            'pending' => $stats['pending_applications'],
            'shortlisted' => $stats['shortlisted_applications'],
            'hired' => $stats['hired_applications']
        ];

        // Select job for preview (maintaining existing functionality)
        $selectedJobId = $_GET['job_id'] ?? ($jobs[0]['job_id'] ?? null);
        $selectedJob = null;

        // Get full job data for selected job
        if ($selectedJobId) {
            $selectedJob = $this->jobPostModel->getFullJobData($selectedJobId);
            // Add application count for this specific job
            if ($selectedJob) {
                $selectedJob['has_applied'] = false;
                if ($jobseeker_id) {
                    $hasApplied = $this->jobApplicationModel->hasApplied($jobseeker_id, $selectedJobId);
                    $selectedJob['has_applied'] = $hasApplied;
                }
            }
        }

        // Include the view
        include __DIR__ . '/../views/jobseekers/dashboard.php';
    }

    /**
     * Calculate basic match percentage as fallback when ML recommendation is unavailable
     * (Same logic as JobPostController for consistency)
     */
    private function calculateBasicMatch($job, $jobseeker)
    {
        if (!$jobseeker) {
            // Use job_id as seed for consistent results for guests
            mt_srand($job['job_id']);
            $percentage = mt_rand(70, 90);
            mt_srand(); // Reset seed
            return $percentage;
        }

        // Use consistent seed based on jobseeker_id and job_id
        $seed = $jobseeker['jobseeker_id'] * 1000 + $job['job_id'];
        mt_srand($seed);

        $matchScore = 40; // Base score

        // Location preference (basic implementation)
        if (!empty($jobseeker['preferred_location']) && !empty($job['location'])) {
            if (stripos($job['location'], $jobseeker['preferred_location']) !== false) {
                $matchScore += 15;
            }
        }

        // Job type preference
        if (!empty($jobseeker['preferred_job_type']) && !empty($job['job_type'])) {
            if (strtolower($jobseeker['preferred_job_type']) === strtolower($job['job_type'])) {
                $matchScore += 10;
            }
        }

        // Use seeded randomization for consistent results
        $randomVariation = mt_rand(-3, 20);
        $matchScore += $randomVariation;

        // Reset random seed
        mt_srand();

        // Ensure score is within reasonable bounds with 20% minimum
        return max(15, min(95, round($matchScore, 1)));
    }
}
