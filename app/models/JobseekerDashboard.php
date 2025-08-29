<?php
// filepath: c:\xampp\htdocs\sikap\app\models\JobseekerDashboard.php
require_once __DIR__ . '/../../config/sikap_db.php';
require_once __DIR__ . '/JobPost.php';
require_once __DIR__ . '/SavedJobs.php';
require_once __DIR__ . '/JobApplication.php';

class JobseekerDashboard
{
    private $db;

    public function __construct()
    {
        $config = require __DIR__ . '/../../config/sikap_db.php';
        try {
            $this->db = new PDO(
                "mysql:host={$config['db_host']};dbname={$config['db_name']}",
                $config['db_user'],
                $config['db_pass']
            );
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    /**
     * Get comprehensive dashboard data for a jobseeker
     */
    public function getDashboardData($jobseeker_id = null)
    {
        try {
            $data = [
                'jobseeker' => null,
                'stats' => $this->getJobseekerStats($jobseeker_id),
                'jobs' => $this->getRecommendedJobs($jobseeker_id),
                'recent_applications' => $this->getRecentApplications($jobseeker_id),
                'profile_completion' => $this->getProfileCompletion($jobseeker_id)
            ];

            // Get jobseeker profile if ID provided
            if ($jobseeker_id) {
                $data['jobseeker'] = $this->getJobseekerProfile($jobseeker_id);
            }

            return $data;
        } catch (Exception $e) {
            error_log('Error getting jobseeker dashboard data: ' . $e->getMessage());
            return $this->getEmptyDashboardData();
        }
    }

    /**
     * Get jobseeker statistics
     */
    public function getJobseekerStats($jobseeker_id = null)
    {
        $stats = [
            'total_applications' => 0,
            'pending_applications' => 0,
            'shortlisted_applications' => 0,
            'hired_applications' => 0,
            'total_jobs_available' => 0,
            'profile_views' => 0
        ];

        try {
            if ($jobseeker_id) {
                // Total applications
                $sql = "SELECT COUNT(*) as count FROM job_application WHERE jobseeker_id = ? AND is_finalized = 1";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([$jobseeker_id]);
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $stats['total_applications'] = $result['count'];

                // Pending applications
                $sql = "SELECT COUNT(*) as count FROM job_application WHERE jobseeker_id = ? AND application_status = 'pending' AND is_finalized = 1";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([$jobseeker_id]);
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $stats['pending_applications'] = $result['count'];

                // Shortlisted applications
                $sql = "SELECT COUNT(*) as count FROM job_application WHERE jobseeker_id = ? AND application_status = 'shortlisted' AND is_finalized = 1";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([$jobseeker_id]);
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $stats['shortlisted_applications'] = $result['count'];

                // Hired applications
                $sql = "SELECT COUNT(*) as count FROM job_application WHERE jobseeker_id = ? AND application_status = 'hired' AND is_finalized = 1";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([$jobseeker_id]);
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $stats['hired_applications'] = $result['count'];
            }

            // Total available jobs - using correct column names
            $sql = "SELECT COUNT(*) as count FROM job_post WHERE job_status = 'open' AND application_deadline >= NOW()";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $stats['total_jobs_available'] = $result['count'];
        } catch (PDOException $e) {
            error_log('Error calculating jobseeker stats: ' . $e->getMessage());
        }

        return $stats;
    }

    /**
     * Get all active jobs using the same pattern as JobPost->getAllActiveJobs()
     */
    public function getRecommendedJobs($jobseeker_id = null, $limit = 20)
    {
        try {
            // Use the exact same logic as JobPost->getAllActiveJobs() which works correctly
            $sql = "SELECT 
                    jp.job_id,
                    jp.job_title,
                    jp.job_summary,
                    jp.location,
                    jp.job_type,
                    jp.pay_range,
                    jp.show_pay,
                    jp.job_status,
                    jp.created_at,
                    jp.application_deadline,
                    jc.category_name,
                    e.first_name as employer_first_name,
                    e.last_name as employer_last_name,
                    COALESCE(eb.business_name, CONCAT(e.first_name, ' ', e.last_name)) as company_name,
                    eb.business_logo
                ";

            // Add application status check if jobseeker_id is provided
            if ($jobseeker_id) {
                $sql .= ", EXISTS(SELECT 1 FROM job_application ja 
                               WHERE ja.job_id = jp.job_id 
                               AND ja.jobseeker_id = ?
                               AND ja.is_finalized = 1) as has_applied";
            }

            $sql .= " FROM job_post jp
                  LEFT JOIN job_category jc ON jp.job_category_id = jc.job_category_id
                  LEFT JOIN employer e ON jp.employer_id = e.employer_id
                  LEFT JOIN employers_business eb ON e.employer_id = eb.employer_id
                  WHERE jp.job_status = 'open'
                  AND (jp.application_deadline IS NULL OR jp.application_deadline >= NOW())
                  GROUP BY jp.job_id, jp.job_title, jp.job_summary, jp.location, jp.job_type, 
                           jp.pay_range, jp.show_pay, jp.job_status, jp.created_at, jp.application_deadline,
                           jc.category_name, e.first_name, e.last_name";

            $sql .= " ORDER BY jp.created_at DESC";

            if ($limit) {
                $sql .= " LIMIT " . intval($limit);
            }

            $stmt = $this->db->prepare($sql);

            if ($jobseeker_id) {
                $stmt->execute([$jobseeker_id]);
            } else {
                $stmt->execute();
            }

            $jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Convert has_applied to boolean for consistency (like JobPost model does)
            if ($jobseeker_id) {
                foreach ($jobs as &$job) {
                    $job['has_applied'] = (bool)$job['has_applied'];
                }
            }

            error_log('=== JOBSEEKER DASHBOARD MODEL DEBUG ===');
            error_log('Jobseeker ID: ' . ($jobseeker_id ?? 'not provided'));
            error_log('Jobs found: ' . count($jobs));
            if (!empty($jobs)) {
                error_log('Job IDs: ' . implode(', ', array_column($jobs, 'job_id')));
                error_log('Job Titles: ' . implode(', ', array_column($jobs, 'job_title')));
            }
            error_log('=== END JOBSEEKER DASHBOARD MODEL DEBUG ===');

            return $jobs;
        } catch (PDOException $e) {
            error_log('Error fetching recommended jobs: ' . $e->getMessage());
            error_log('SQL: ' . $sql);
            return [];
        }
    }

    /**
     * Get recent applications for jobseeker
     */
    public function getRecentApplications($jobseeker_id, $limit = 10)
    {
        if (!$jobseeker_id) return [];

        try {
            $sql = "SELECT 
                        ja.application_id,
                        ja.application_status,
                        ja.applied_date,
                        ja.created_at,
                        jp.job_title,
                        jp.job_type,
                        jp.location,
                        e.business_name as company_name,
                        e.business_logo_path
                    FROM job_application ja
                    JOIN job_post jp ON ja.job_id = jp.job_id
                    JOIN employer e ON jp.employer_id = e.employer_id
                    WHERE ja.jobseeker_id = ? AND ja.is_finalized = 1
                    ORDER BY ja.created_at DESC";

            if ($limit) {
                $sql .= " LIMIT " . intval($limit);
            }

            $stmt = $this->db->prepare($sql);
            $stmt->execute([$jobseeker_id]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error fetching recent applications: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Get jobseeker profile information
     */
    public function getJobseekerProfile($jobseeker_id)
    {
        try {
            $sql = "SELECT j.*, u.email, u.is_verified
                    FROM jobseeker j
                    JOIN user u ON j.user_id = u.user_id
                    WHERE j.jobseeker_id = ?";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([$jobseeker_id]);

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error fetching jobseeker profile: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Calculate profile completion percentage
     */
    public function getProfileCompletion($jobseeker_id)
    {
        if (!$jobseeker_id) {
            return ['percentage' => 0, 'completed_items' => 0, 'total_items' => 0, 'missing_items' => []];
        }

        try {
            $jobseeker = $this->getJobseekerProfile($jobseeker_id);
            if (!$jobseeker) {
                return ['percentage' => 0, 'completed_items' => 0, 'total_items' => 0, 'missing_items' => []];
            }

            $requiredFields = [
                'first_name' => 'First Name',
                'last_name' => 'Last Name',
                'date_of_birth' => 'Date of Birth',
                'sex' => 'Gender',
                'address' => 'Address',
                'contact_no' => 'Contact Number',
                'profile_picture' => 'Profile Picture'
            ];

            $completed = 0;
            $missingItems = [];

            foreach ($requiredFields as $field => $label) {
                if (!empty($jobseeker[$field])) {
                    $completed++;
                } else {
                    $missingItems[] = $label;
                }
            }

            // Check for education records
            $sql = "SELECT COUNT(*) as count FROM jobseeker_education WHERE jobseeker_id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$jobseeker_id]);
            $educationCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

            if ($educationCount > 0) {
                $completed++;
            } else {
                $missingItems[] = 'Education';
            }

            // Check for skills
            $sql = "SELECT COUNT(*) as count FROM jobseeker_skills WHERE jobseeker_id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$jobseeker_id]);
            $skillsCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

            if ($skillsCount > 0) {
                $completed++;
            } else {
                $missingItems[] = 'Skills';
            }

            $totalItems = count($requiredFields) + 2; // +2 for education and skills
            $percentage = round(($completed / $totalItems) * 100);

            return [
                'percentage' => $percentage,
                'completed_items' => $completed,
                'total_items' => $totalItems,
                'missing_items' => $missingItems
            ];
        } catch (PDOException $e) {
            error_log('Error calculating profile completion: ' . $e->getMessage());
            return ['percentage' => 0, 'completed_items' => 0, 'total_items' => 0, 'missing_items' => []];
        }
    }

    /**
     * Find jobseeker by user_id
     */
    public function findJobseekerByUserId($user_id)
    {
        try {
            $sql = "SELECT * FROM jobseeker WHERE user_id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$user_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error finding jobseeker by user ID: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Get dashboard summary similar to employer
     */
    public function getDashboardSummary($jobseeker_id)
    {
        try {
            // Get basic stats
            $stats = $this->getJobseekerStats($jobseeker_id);

            // Get profile completion
            $profileCompletion = $this->getProfileCompletion($jobseeker_id);

            // Get recent activities
            $recentApplications = $this->getRecentApplications($jobseeker_id, 5);

            // Get recommended jobs
            $recommendedJobs = $this->getRecommendedJobs($jobseeker_id, 10);

            return [
                'stats' => $stats,
                'profile_completion' => $profileCompletion,
                'recent_applications' => $recentApplications,
                'recommended_jobs' => $recommendedJobs
            ];
        } catch (Exception $e) {
            error_log('Error getting dashboard summary: ' . $e->getMessage());
            return [
                'stats' => [
                    'total_applications' => 0,
                    'pending_applications' => 0,
                    'shortlisted_applications' => 0,
                    'hired_applications' => 0,
                    'total_jobs_available' => 0,
                    'profile_views' => 0
                ],
                'profile_completion' => ['percentage' => 0, 'completed_items' => 0, 'total_items' => 0, 'missing_items' => []],
                'recent_applications' => [],
                'recommended_jobs' => []
            ];
        }
    }

    /**
     * Get jobs with filters (similar to employer functionality)
     */
    public function getJobsWithFilters($jobseeker_id = null, $filters = [])
    {
        try {
            $sql = "SELECT 
                        jp.job_id,
                        jp.job_title,
                        jp.job_summary,
                        jp.job_type,
                        jp.location,
                        jp.workplace_option,
                        jp.salary,
                        jp.pay_range,
                        jp.pay_type,
                        jp.show_pay,
                        jp.application_deadline,
                        jp.created_at as posted_date,
                        jp.full_description,
                        e.business_name as company_name,
                        e.business_logo_path,
                        e.business_address";

            if ($jobseeker_id) {
                $sql .= ", 
                        CASE 
                            WHEN ja.application_id IS NOT NULL THEN 1 
                            ELSE 0 
                        END as has_applied,
                        ja.application_status";
            }

            $sql .= " FROM job_post jp
                     JOIN employer e ON jp.employer_id = e.employer_id";

            if ($jobseeker_id) {
                $sql .= " LEFT JOIN job_application ja ON jp.job_id = ja.job_id AND ja.jobseeker_id = ?";
            }

            $sql .= " WHERE jp.job_status = 'open' AND jp.application_deadline >= NOW()";

            $params = $jobseeker_id ? [$jobseeker_id] : [];

            // Add filters
            if (!empty($filters['job_type'])) {
                $sql .= " AND jp.job_type = ?";
                $params[] = $filters['job_type'];
            }

            if (!empty($filters['location'])) {
                $sql .= " AND jp.location LIKE ?";
                $params[] = '%' . $filters['location'] . '%';
            }

            // Add sorting
            $sortBy = $filters['sort'] ?? 'recent';
            switch ($sortBy) {
                case 'salary_high':
                    $sql .= " ORDER BY jp.salary DESC, jp.created_at DESC";
                    break;
                case 'salary_low':
                    $sql .= " ORDER BY jp.salary ASC, jp.created_at DESC";
                    break;
                case 'deadline':
                    $sql .= " ORDER BY jp.application_deadline ASC";
                    break;
                default: // recent
                    $sql .= " ORDER BY jp.created_at DESC";
            }

            // Add pagination
            $limit = $filters['limit'] ?? 20;
            $offset = (($filters['page'] ?? 1) - 1) * $limit;
            $sql .= " LIMIT ? OFFSET ?";
            $params[] = $limit;
            $params[] = $offset;

            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error fetching filtered jobs: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Get application count for a specific job
     */
    public function getJobApplicationCount($job_id)
    {
        try {
            $stmt = $this->db->prepare("
                SELECT COUNT(*) as count 
                FROM job_application 
                WHERE job_id = ? AND is_finalized = 1
            ");
            $stmt->execute([$job_id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'] ?? 0;
        } catch (PDOException $e) {
            error_log("Error getting application count for job {$job_id}: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Get full job details with additional jobseeker-specific data
     */
    public function getJobDetailsForJobseeker($job_id, $jobseeker_id = null)
    {
        try {
            // Get basic job data
            $jobPost = new JobPost();
            $job = $jobPost->getFullJobData($job_id);

            if (!$job) {
                return null;
            }

            // Add application count
            $job['application_count'] = $this->getJobApplicationCount($job_id);

            // Add jobseeker-specific data if jobseeker_id provided
            if ($jobseeker_id) {
                // Check if job is saved
                $savedJobs = new SavedJobs();
                $job['is_saved'] = $savedJobs->isSaved($jobseeker_id, $job_id);

                // Check if user has applied - let's debug this
                $jobApplication = new JobApplication();
                $hasApplied = $jobApplication->hasApplied($jobseeker_id, $job_id);

                // Debug logging
                error_log("DEBUG - JobseekerDashboard: jobseeker_id={$jobseeker_id}, job_id={$job_id}, hasApplied=" . ($hasApplied ? 'true' : 'false'));

                $job['has_applied'] = $hasApplied;
            } else {
                $job['is_saved'] = false;
                $job['has_applied'] = false;
            }

            return $job;
        } catch (Exception $e) {
            error_log("Error getting job details for jobseeker: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Get empty dashboard data structure
     */
    private function getEmptyDashboardData()
    {
        return [
            'jobseeker' => null,
            'stats' => [
                'total_applications' => 0,
                'pending_applications' => 0,
                'shortlisted_applications' => 0,
                'hired_applications' => 0,
                'total_jobs_available' => 0,
                'profile_views' => 0
            ],
            'jobs' => [],
            'recent_applications' => [],
            'profile_completion' => [
                'percentage' => 0,
                'completed_items' => 0,
                'total_items' => 0,
                'missing_items' => []
            ]
        ];
    }
}
