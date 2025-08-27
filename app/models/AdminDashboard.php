<?php

class AdminDashboard
{
    private $db;

    public function __construct()
    {
        $this->connectDatabase();
    }

    private function connectDatabase()
    {
        try {
            $config = require __DIR__ . '/../../config/sikap_db.php';
            $this->db = new PDO(
                "mysql:host={$config['db_host']};dbname={$config['db_name']}",
                $config['db_user'],
                $config['db_pass']
            );
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            error_log('Database connection failed: ' . $e->getMessage());
            throw new Exception('Database connection failed');
        }
    }

    /**
     * Get total number of jobseekers
     */
    public function getTotalJobseekers()
    {
        try {
            $sql = "SELECT COUNT(*) FROM jobseeker";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log('Error getting total jobseekers: ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Get total number of employers
     */
    public function getTotalEmployers()
    {
        try {
            $sql = "SELECT COUNT(*) FROM employer";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log('Error getting total employers: ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Get total number of users (jobseekers + employers)
     */
    public function getTotalUsers()
    {
        return $this->getTotalJobseekers() + $this->getTotalEmployers();
    }

    /**
     * Get active job posts
     */
    public function getActiveJobPosts()
    {
        try {
            $sql = "SELECT COUNT(*) FROM job_post WHERE job_status = 'open'";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log('Error getting active job posts: ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Get pending accreditations
     */
    public function getPendingAccreditations()
    {
        try {
            // Check if accreditation table exists
            $sql = "SHOW TABLES LIKE 'accreditation'";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $sql = "SELECT COUNT(*) FROM accreditation WHERE status = 'pending'";
                $stmt = $this->db->prepare($sql);
                $stmt->execute();
                return $stmt->fetchColumn();
            } else {
                // If no accreditation table, count employers with pending status
                $sql = "SELECT COUNT(*) FROM employer WHERE status = 'pending'";
                $stmt = $this->db->prepare($sql);
                $stmt->execute();
                return $stmt->fetchColumn();
            }
        } catch (PDOException $e) {
            error_log('Error getting pending accreditations: ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Get total applications
     */
    public function getTotalApplications()
    {
        try {
            $sql = "SELECT COUNT(*) FROM job_application WHERE is_finalized = 1";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log('Error getting total applications: ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Calculate user change percentage (30 days comparison)
     */
    public function calculateUserChange($currentUsers)
    {
        try {
            // Get users from 30 days ago
            $sql = "SELECT 
                        (SELECT COUNT(*) FROM jobseeker WHERE created_at <= DATE_SUB(NOW(), INTERVAL 30 DAY)) +
                        (SELECT COUNT(*) FROM employer WHERE created_at <= DATE_SUB(NOW(), INTERVAL 30 DAY)) as prev_users";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $prevUsers = $stmt->fetchColumn();

            if ($prevUsers > 0) {
                return round((($currentUsers - $prevUsers) / $prevUsers) * 100, 1);
            }
            return $currentUsers > 0 ? 100 : 0;
        } catch (PDOException $e) {
            error_log('Error calculating user change: ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Calculate job change percentage (30 days comparison)
     */
    public function calculateJobChange($currentJobs)
    {
        try {
            $sql = "SELECT COUNT(*) FROM job_post 
                    WHERE job_status = 'open' 
                    AND created_at <= DATE_SUB(NOW(), INTERVAL 30 DAY)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $prevJobs = $stmt->fetchColumn();

            if ($prevJobs > 0) {
                return round((($currentJobs - $prevJobs) / $prevJobs) * 100, 1);
            }
            return $currentJobs > 0 ? 100 : 0;
        } catch (PDOException $e) {
            error_log('Error calculating job change: ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Calculate application change percentage (30 days comparison)
     */
    public function calculateApplicationChange($currentApplications)
    {
        try {
            $sql = "SELECT COUNT(*) FROM job_application 
                    WHERE is_finalized = 1 
                    AND applied_at <= DATE_SUB(NOW(), INTERVAL 30 DAY)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $prevApplications = $stmt->fetchColumn();

            if ($prevApplications > 0) {
                return round((($currentApplications - $prevApplications) / $prevApplications) * 100, 1);
            }
            return $currentApplications > 0 ? 100 : 0;
        } catch (PDOException $e) {
            error_log('Error calculating application change: ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Get all dashboard statistics in one method
     */
    public function getDashboardStats()
    {
        try {
            // Get current counts
            $totalUsers = $this->getTotalUsers();
            $activeJobs = $this->getActiveJobPosts();
            $pendingAccreditations = $this->getPendingAccreditations();
            $totalApplications = $this->getTotalApplications();

            // Calculate percentage changes (30 days comparison)
            $userChange = $this->calculateUserChange($totalUsers);
            $jobChange = $this->calculateJobChange($activeJobs);
            $applicationChange = $this->calculateApplicationChange($totalApplications);

            return [
                'total_users' => $totalUsers,
                'active_jobs' => $activeJobs,
                'pending_accreditations' => $pendingAccreditations,
                'total_applications' => $totalApplications,
                'user_change' => $userChange,
                'job_change' => $jobChange,
                'application_change' => $applicationChange
            ];
        } catch (Exception $e) {
            error_log('Error getting dashboard stats: ' . $e->getMessage());
            return [
                'total_users' => 0,
                'active_jobs' => 0,
                'pending_accreditations' => 0,
                'total_applications' => 0,
                'user_change' => 0,
                'job_change' => 0,
                'application_change' => 0
            ];
        }
    }

    /**
     * Get recent activity for dashboard
     */
    public function getRecentActivity($limit = 10)
    {
        try {
            $sql = "
                (SELECT 'job_application' as type, 
                        CONCAT(j.first_name, ' ', j.last_name) as user_name,
                        jp.job_title as description,
                        ja.applied_at as created_at
                 FROM job_application ja
                 JOIN jobseeker j ON ja.jobseeker_id = j.jobseeker_id
                 JOIN job_post jp ON ja.job_post_id = jp.job_post_id
                 WHERE ja.is_finalized = 1
                 ORDER BY ja.applied_at DESC
                 LIMIT :limit1)
                UNION ALL
                (SELECT 'job_post' as type,
                        CONCAT(e.first_name, ' ', e.last_name) as user_name,
                        CONCAT('Posted: ', jp.job_title) as description,
                        jp.created_at
                 FROM job_post jp
                 JOIN employer e ON jp.employer_id = e.employer_id
                 ORDER BY jp.created_at DESC
                 LIMIT :limit2)
                ORDER BY created_at DESC
                LIMIT :final_limit";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':limit1', $limit, PDO::PARAM_INT);
            $stmt->bindParam(':limit2', $limit, PDO::PARAM_INT);
            $stmt->bindParam(':final_limit', $limit, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error getting recent activity: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Get top job categories with application counts
     */
    public function getTopJobCategories($limit = 5)
    {
        try {
            $sql = "SELECT jp.job_category, 
                           COUNT(DISTINCT jp.job_post_id) as job_count,
                           COUNT(ja.application_id) as application_count
                    FROM job_post jp
                    LEFT JOIN job_application ja ON jp.job_post_id = ja.job_post_id AND ja.is_finalized = 1
                    WHERE jp.job_status = 'open'
                    GROUP BY jp.job_category
                    ORDER BY application_count DESC, job_count DESC
                    LIMIT :limit";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error getting top job categories: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Get job statistics for the last 6 months (for charts)
     */
    public function getJobStatsForChart()
    {
        try {
            $sql = "SELECT 
                        DATE_FORMAT(created_at, '%Y-%m') as month,
                        MONTHNAME(created_at) as month_name,
                        COUNT(*) as job_count
                    FROM job_post 
                    WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
                    GROUP BY DATE_FORMAT(created_at, '%Y-%m'), MONTHNAME(created_at)
                    ORDER BY created_at ASC";

            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $jobData = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Get application statistics for the same period
            $sql = "SELECT 
                        DATE_FORMAT(applied_at, '%Y-%m') as month,
                        MONTHNAME(applied_at) as month_name,
                        COUNT(*) as application_count
                    FROM job_application 
                    WHERE applied_at >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
                    AND is_finalized = 1
                    GROUP BY DATE_FORMAT(applied_at, '%Y-%m'), MONTHNAME(applied_at)
                    ORDER BY applied_at ASC";

            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $applicationData = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Create arrays for the last 6 months
            $months = [];
            $jobCounts = [];
            $applicationCounts = [];

            // Generate last 6 months
            for ($i = 5; $i >= 0; $i--) {
                $monthKey = date('Y-m', strtotime("-$i months"));
                $monthName = date('M', strtotime("-$i months"));
                $months[] = $monthName;

                // Find job count for this month
                $jobCount = 0;
                foreach ($jobData as $job) {
                    if ($job['month'] === $monthKey) {
                        $jobCount = $job['job_count'];
                        break;
                    }
                }
                $jobCounts[] = $jobCount;

                // Find application count for this month
                $appCount = 0;
                foreach ($applicationData as $app) {
                    if ($app['month'] === $monthKey) {
                        $appCount = $app['application_count'];
                        break;
                    }
                }
                $applicationCounts[] = $appCount;
            }

            // Calculate trend (comparing last 2 months)
            $trend = 0;
            if (count($jobCounts) >= 2) {
                $currentMonth = end($jobCounts);
                $previousMonth = $jobCounts[count($jobCounts) - 2];
                if ($previousMonth > 0) {
                    $trend = round((($currentMonth - $previousMonth) / $previousMonth) * 100, 1);
                }
            }

            return [
                'months' => $months,
                'job_posts' => $jobCounts,
                'applications' => $applicationCounts,
                'trend' => $trend
            ];
        } catch (PDOException $e) {
            error_log('Error getting job stats for chart: ' . $e->getMessage());
            return [
                'months' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                'job_posts' => [0, 0, 0, 0, 0, 0],
                'applications' => [0, 0, 0, 0, 0, 0],
                'trend' => 0
            ];
        }
    }

    /**
     * Get job category statistics for chart
     */
    public function getJobCategoryStatsForChart($limit = 6)
    {
        try {
            $sql = "SELECT 
                        COALESCE(jc.category_name, 'Others') as category,
                        COUNT(DISTINCT jp.job_id) as job_count,
                        COUNT(ja.application_id) as application_count
                    FROM job_category jc
                    LEFT JOIN job_post jp ON jc.job_category_id = jp.job_category_id 
                        AND jp.created_at >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
                    LEFT JOIN job_application ja ON jp.job_id = ja.job_id AND ja.is_finalized = 1
                    GROUP BY jc.job_category_id, jc.category_name
                    ORDER BY job_count DESC, application_count DESC
                    LIMIT :limit";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $categories = [];
            $jobCounts = [];
            $applicationCounts = [];

            foreach ($data as $row) {
                $categories[] = $row['category'] ?: 'Others';
                $jobCounts[] = (int)$row['job_count'];
                $applicationCounts[] = (int)$row['application_count'];
            }

            // Fill with default data if no results
            if (empty($categories)) {
                $categories = ['IT', 'Healthcare', 'Education', 'Engineering', 'Finance', 'Marketing'];
                $jobCounts = [0, 0, 0, 0, 0, 0];
                $applicationCounts = [0, 0, 0, 0, 0, 0];
            }

            return [
                'categories' => $categories,
                'job_posts' => $jobCounts,
                'applications' => $applicationCounts
            ];
        } catch (PDOException $e) {
            error_log('Error getting job category stats for chart: ' . $e->getMessage());
            return [
                'categories' => ['IT', 'Healthcare', 'Education', 'Engineering', 'Finance', 'Marketing'],
                'job_posts' => [0, 0, 0, 0, 0, 0],
                'applications' => [0, 0, 0, 0, 0, 0]
            ];
        }
    }
}
