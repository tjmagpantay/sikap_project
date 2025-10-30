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
                "mysql:host={$config['db_host']};port={$config['db_port']};dbname={$config['db_name']};charset=utf8mb4",
                $config['db_user'],
                $config['db_pass'],
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_TIMEOUT => 30
                ]
            );
        } catch (PDOException $e) {
            error_log('Database connection failed: ' . $e->getMessage());
            throw new Exception('Database connection failed');
        }
    }

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

    public function getTotalUsers()
    {
        return $this->getTotalJobseekers() + $this->getTotalEmployers();
    }

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

    public function getJobStatsForChart()
    {
        try {
            // Build last 6 months keys and labels
            $months = [];
            $monthKeys = [];
            for ($i = 5; $i >= 0; $i--) {
                $dt = strtotime("-{$i} months");
                $monthKeys[] = date('Y-m', $dt);
                $months[] = date('M', $dt);
            }

            // Aggregate job posts by month (Y-m)
            $sql = "SELECT DATE_FORMAT(created_at, '%Y-%m') AS month, COUNT(*) AS job_count
                FROM job_post
                WHERE created_at >= DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 5 MONTH), '%Y-%m-01')
                GROUP BY DATE_FORMAT(created_at, '%Y-%m')";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $jobData = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Aggregate applications by month (Y-m) — try applied_at then fallback to created_at
            $appSql = "SELECT DATE_FORMAT(applied_at, '%Y-%m') AS month, COUNT(*) AS application_count
                   FROM job_application
                   WHERE applied_at >= DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 5 MONTH), '%Y-%m-01')
                   GROUP BY DATE_FORMAT(applied_at, '%Y-%m')";
            $appStmt = $this->db->prepare($appSql);
            $appOk = true;
            try {
                $appStmt->execute();
                $applicationData = $appStmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                // fallback column name / created_at if applied_at not present or error
                error_log("job stats: applied_at query failed: " . $e->getMessage());
                $appOk = false;
            }
            if (!$appOk) {
                $appSql2 = "SELECT DATE_FORMAT(created_at, '%Y-%m') AS month, COUNT(*) AS application_count
                        FROM job_application
                        WHERE created_at >= DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 5 MONTH), '%Y-%m-01')
                        GROUP BY DATE_FORMAT(created_at, '%Y-%m')";
                $appStmt2 = $this->db->prepare($appSql2);
                $appStmt2->execute();
                $applicationData = $appStmt2->fetchAll(PDO::FETCH_ASSOC);
            }

            // Convert results to associative maps for fast lookup
            $jobMap = [];
            foreach ($jobData as $r) {
                $jobMap[$r['month']] = (int)$r['job_count'];
            }
            $appMap = [];
            foreach ($applicationData as $r) {
                $appMap[$r['month']] = (int)$r['application_count'];
            }

            // Map counts into arrays aligned with $months
            $jobCounts = [];
            $applicationCounts = [];
            foreach ($monthKeys as $key) {
                $jobCounts[] = isset($jobMap[$key]) ? $jobMap[$key] : 0;
                $applicationCounts[] = isset($appMap[$key]) ? $appMap[$key] : 0;
            }

            // debug logs (remove in production)
            error_log("JobStats raw jobData: " . json_encode($jobData));
            error_log("JobStats raw applicationData: " . json_encode($applicationData));
            error_log("JobStats mapped months: " . json_encode($monthKeys));
            error_log("JobStats jobCounts: " . json_encode($jobCounts));
            error_log("JobStats applicationCounts: " . json_encode($applicationCounts));

            // trend calculation (compare last two months)
            $trend = 0;
            $len = count($jobCounts);
            if ($len >= 2) {
                $current = $jobCounts[$len - 1];
                $prev = $jobCounts[$len - 2];
                if ($prev > 0) {
                    $trend = round((($current - $prev) / $prev) * 100, 1);
                } elseif ($current > 0) {
                    $trend = 100;
                }
            }

            return [
                'months' => $months,
                'job_posts' => $jobCounts,
                'applications' => $applicationCounts,
                'trend' => $trend
            ];
        } catch (PDOException $e) {
            error_log("Error in getJobStatsForChart: " . $e->getMessage());
            // fallback
            $fallbackMonths = [];
            for ($i = 5; $i >= 0; $i--) {
                $fallbackMonths[] = date('M', strtotime("-{$i} months"));
            }
            return [
                'months' => $fallbackMonths,
                'job_posts' => array_fill(0, 6, 0),
                'applications' => array_fill(0, 6, 0),
                'trend' => 0
            ];
        }
    }

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
                $categories = ['Technology', 'Healthcare', 'Education', 'Engineering', 'Finance', 'Marketing'];
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
                'categories' => ['Technology', 'Healthcare', 'Education', 'Engineering', 'Finance', 'Marketing'],
                'job_posts' => [0, 0, 0, 0, 0, 0],
                'applications' => [0, 0, 0, 0, 0, 0]
            ];
        }
    }

    public function getReportStatistics()
    {
        try {
            // Get total users (jobseekers + employers)
            $totalJobseekers = $this->getTotalJobseekers();
            $totalEmployers = $this->getTotalEmployers();
            $totalUsers = $totalJobseekers + $totalEmployers;

            // Get active jobs
            $sql = "SELECT COUNT(*) FROM job_post WHERE job_status = 'open'";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $activeJobs = $stmt->fetchColumn();

            // Get total applications
            $sql = "SELECT COUNT(*) FROM job_application WHERE is_finalized = 1";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $totalApplications = $stmt->fetchColumn();

            // Get pending applications
            $sql = "SELECT COUNT(*) FROM job_application WHERE application_status = 'pending' AND is_finalized = 1";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $pendingApplications = $stmt->fetchColumn();

            // Get total events (if events table exists)
            $totalEvents = 0;
            try {
                $sql = "SHOW TABLES LIKE 'events'";
                $stmt = $this->db->prepare($sql);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    $sql = "SELECT COUNT(*) FROM events";
                    $stmt = $this->db->prepare($sql);
                    $stmt->execute();
                    $totalEvents = $stmt->fetchColumn();
                }
            } catch (PDOException $e) {
                // Events table doesn't exist, keep totalEvents as 0
                error_log('Events table not found: ' . $e->getMessage());
            }

            return [
                'total_users' => (int)$totalUsers,
                'total_employers' => (int)$totalEmployers,
                'total_jobseekers' => (int)$totalJobseekers,
                'active_jobs' => (int)$activeJobs,
                'total_applications' => (int)$totalApplications,
                'pending_applications' => (int)$pendingApplications,
                'total_events' => (int)$totalEvents
            ];
        } catch (PDOException $e) {
            error_log('Error getting report statistics: ' . $e->getMessage());
            // Return zeros if there's an error
            return [
                'total_users' => 0,
                'total_employers' => 0,
                'total_jobseekers' => 0,
                'active_jobs' => 0,
                'total_applications' => 0,
                'pending_applications' => 0,
                'total_events' => 0
            ];
        }
    }

    public function getMonthlyActivityTrends()
    {
        try {
            // Get the last 6 months data
            $months = [];
            $monthLabels = [];

            // Generate last 6 months
            for ($i = 5; $i >= 0; $i--) {
                $date = date('Y-m', strtotime("-$i months"));
                $months[] = $date;
                $monthLabels[] = date('M', strtotime("-$i months"));
            }

            // Initialize arrays for data
            $jobPostsData = array_fill(0, 6, 0);
            $applicationsData = array_fill(0, 6, 0);
            $registrationsData = array_fill(0, 6, 0);

            // Get Job Posts data
            $sql = "SELECT 
                    DATE_FORMAT(created_at, '%Y-%m') as month,
                    COUNT(*) as count
                FROM job_post 
                WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
                GROUP BY DATE_FORMAT(created_at, '%Y-%m')
                ORDER BY month ASC";

            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $jobPostResults = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Map job posts data to months
            foreach ($jobPostResults as $result) {
                $monthIndex = array_search($result['month'], $months);
                if ($monthIndex !== false) {
                    $jobPostsData[$monthIndex] = (int)$result['count'];
                }
            }

            // Get Applications data
            $sql = "SELECT 
                    DATE_FORMAT(applied_at, '%Y-%m') as month,
                    COUNT(*) as count
                FROM job_application 
                WHERE applied_at >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
                AND is_finalized = 1
                GROUP BY DATE_FORMAT(applied_at, '%Y-%m')
                ORDER BY month ASC";

            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $applicationResults = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Map applications data to months
            foreach ($applicationResults as $result) {
                $monthIndex = array_search($result['month'], $months);
                if ($monthIndex !== false) {
                    $applicationsData[$monthIndex] = (int)$result['count'];
                }
            }

            // Get User Registrations data (Jobseekers + Employers)
            $sql = "SELECT 
                    DATE_FORMAT(created_at, '%Y-%m') as month,
                    COUNT(*) as count
                FROM (
                    SELECT created_at FROM jobseeker WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
                    UNION ALL
                    SELECT created_at FROM employer WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
                ) as all_users
                GROUP BY DATE_FORMAT(created_at, '%Y-%m')
                ORDER BY month ASC";

            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $registrationResults = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Map registrations data to months
            foreach ($registrationResults as $result) {
                $monthIndex = array_search($result['month'], $months);
                if ($monthIndex !== false) {
                    $registrationsData[$monthIndex] = (int)$result['count'];
                }
            }

            return [
                'months' => $monthLabels,
                'job_posts' => $jobPostsData,
                'applications' => $applicationsData,
                'registrations' => $registrationsData
            ];
        } catch (PDOException $e) {
            error_log('Error getting monthly activity trends: ' . $e->getMessage());

            // Return fallback data with last 6 months
            $fallbackMonths = [];
            for ($i = 5; $i >= 0; $i--) {
                $fallbackMonths[] = date('M', strtotime("-$i months"));
            }

            return [
                'months' => $fallbackMonths,
                'job_posts' => [0, 0, 0, 0, 0, 0],
                'applications' => [0, 0, 0, 0, 0, 0],
                'registrations' => [0, 0, 0, 0, 0, 0]
            ];
        }
    }

    public function initializeJobCategories()
    {
        try {
            // Check if job_category table has data
            $sql = "SELECT COUNT(*) FROM job_category";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $count = $stmt->fetchColumn();

            if ($count == 0) {
                // Insert default categories based on your ENUM
                $categories = [
                    'Technology',
                    'Healthcare',
                    'Education',
                    'Engineering',
                    'Finance',
                    'Marketing',
                    'Construction',
                    'Others'
                ];

                $sql = "INSERT INTO job_category (category_name) VALUES (?)";
                $stmt = $this->db->prepare($sql);

                foreach ($categories as $category) {
                    $stmt->execute([$category]);
                }

                error_log('Job categories initialized successfully');
                return true;
            }

            return true;
        } catch (PDOException $e) {
            error_log('Error initializing job categories: ' . $e->getMessage());
            return false;
        }
    }

    public function getAllJobCategoriesDistribution()
    {
        try {
            $sql = "SELECT 
                    COALESCE(jc.category_name, 'Others') as category,
                    COUNT(DISTINCT jp.job_id) as job_count
                FROM job_category jc
                LEFT JOIN job_post jp ON jc.job_category_id = jp.job_category_id 
                    AND jp.created_at >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
                GROUP BY jc.job_category_id, jc.category_name
                ORDER BY job_count DESC";

            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $categories = [];
            $values = [];

            $colors = [
                '#092C4C', // primary - Dark Blue
                '#F3AF0E', // secondary - Orange  
                '#10B981', // success - Green
                '#EF4444', // danger - Red
                '#3B82F6', // info - Blue
                '#6B7280', // gray - Gray
                '#8B5CF6', // purple
                '#B0AEAE'  // amber
            ];

            foreach ($data as $row) {
                $categoryName = $row['category'] ?: 'Others';
                $categories[] = $categoryName;
                $values[] = (int)$row['job_count'];
            }

            if (empty($categories)) {
                // Get all categories from enum
                $categories = ['Technology', 'Healthcare', 'Education', 'Engineering', 'Finance', 'Marketing', 'Construction', 'Others'];
                $values = [0, 0, 0, 0, 0, 0, 0, 0];
            } else {
                // Fill missing categories with 0 values to ensure all 8 are present
                $allCategories = ['Technology', 'Healthcare', 'Education', 'Engineering', 'Finance', 'Marketing', 'Construction', 'Others'];
                $finalCategories = [];
                $finalValues = [];

                foreach ($allCategories as $cat) {
                    $index = array_search($cat, $categories);
                    if ($index !== false) {
                        $finalCategories[] = $cat;
                        $finalValues[] = $values[$index];
                    } else {
                        $finalCategories[] = $cat;
                        $finalValues[] = 0;
                    }
                }

                $categories = $finalCategories;
                $values = $finalValues;
            }

            error_log('All Job Categories Distribution Data: ' . json_encode([
                'categories' => $categories,
                'values' => $values,
                'total_categories' => count($categories)
            ]));

            return [
                'categories' => $categories,
                'values' => $values,
                'colors' => array_slice($colors, 0, count($categories))
            ];
        } catch (PDOException $e) {
            error_log('Error getting all job categories distribution: ' . $e->getMessage());

            // Return all 8 categories as fallback
            return [
                'categories' => ['Technology', 'Healthcare', 'Education', 'Engineering', 'Finance', 'Marketing', 'Construction', 'Others'],
                'values' => [0, 0, 0, 0, 0, 0, 0, 0],
                'colors' => ['#092C4C', '#F3AF0E', '#10B981', '#EF4444', '#3B82F6', '#6B7280', '#8B5CF6', '#B0AEAE']
            ];
        }
    }

    public function getUserGrowthTrends()
    {
        try {
            // Get the last 6 months data
            $months = [];
            $monthLabels = [];

            // Generate last 6 months
            for ($i = 5; $i >= 0; $i--) {
                $date = date('Y-m', strtotime("-$i months"));
                $months[] = $date;
                $monthLabels[] = date('M', strtotime("-$i months"));
            }

            // Initialize arrays for data
            $jobseekerData = array_fill(0, 6, 0);
            $employerData = array_fill(0, 6, 0);

            // Get Jobseeker registrations data
            $sql = "SELECT 
                    DATE_FORMAT(created_at, '%Y-%m') as month,
                    COUNT(*) as count
                FROM jobseeker 
                WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
                GROUP BY DATE_FORMAT(created_at, '%Y-%m')
                ORDER BY month ASC";

            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $jobseekerResults = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Map jobseeker data to months
            foreach ($jobseekerResults as $result) {
                $monthIndex = array_search($result['month'], $months);
                if ($monthIndex !== false) {
                    $jobseekerData[$monthIndex] = (int)$result['count'];
                }
            }

            // Get Employer registrations data
            $sql = "SELECT 
                    DATE_FORMAT(created_at, '%Y-%m') as month,
                    COUNT(*) as count
                FROM employer 
                WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
                GROUP BY DATE_FORMAT(created_at, '%Y-%m')
                ORDER BY month ASC";

            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $employerResults = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Map employer data to months
            foreach ($employerResults as $result) {
                $monthIndex = array_search($result['month'], $months);
                if ($monthIndex !== false) {
                    $employerData[$monthIndex] = (int)$result['count'];
                }
            }

            return [
                'months' => $monthLabels,
                'jobseekers' => $jobseekerData,
                'employers' => $employerData
            ];
        } catch (PDOException $e) {
            error_log('Error getting user growth trends: ' . $e->getMessage());

            // Return fallback data with last 6 months
            $fallbackMonths = [];
            for ($i = 5; $i >= 0; $i--) {
                $fallbackMonths[] = date('M', strtotime("-$i months"));
            }

            return [
                'months' => $fallbackMonths,
                'jobseekers' => [0, 0, 0, 0, 0, 0],
                'employers' => [0, 0, 0, 0, 0, 0]
            ];
        }
    }

    public function getApplicationStatusDistribution()
    {
        try {
            $sql = "SELECT 
                    application_status,
                    COUNT(*) as status_count
                FROM job_application 
                WHERE is_finalized = 1
                GROUP BY application_status
                ORDER BY 
                    CASE application_status 
                        WHEN 'pending' THEN 1
                        WHEN 'reviewed' THEN 2
                        WHEN 'shortlisted' THEN 3
                        WHEN 'rejected' THEN 4
                        WHEN 'hired' THEN 5
                        ELSE 6
                    END";

            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Initialize all possible statuses
            $allStatuses = [
                'pending' => 'Pending',
                'reviewed' => 'Under Review',
                'shortlisted' => 'Shortlisted',
                'rejected' => 'Rejected',
                'hired' => 'Hired'
            ];

            $labels = [];
            $values = [];
            $colors = [
                '#F59E0B', // pending - Yellow/Orange
                '#3B82F6', // reviewed - Blue
                '#10B981', // shortlisted - Green
                '#EF4444', // rejected - Red
                '#8B5CF6'  // hired - Purple
            ];

            // Process data to ensure all statuses are represented
            $statusCounts = [];
            foreach ($data as $row) {
                $statusCounts[$row['application_status']] = (int)$row['status_count'];
            }

            // Build final arrays with all statuses (even if count is 0)
            foreach ($allStatuses as $statusKey => $statusLabel) {
                $labels[] = $statusLabel;
                $values[] = $statusCounts[$statusKey] ?? 0;
            }

            error_log('Application Status Distribution Data: ' . json_encode([
                'labels' => $labels,
                'values' => $values,
                'total_applications' => array_sum($values)
            ]));

            return [
                'labels' => $labels,
                'values' => $values,
                'colors' => $colors,
                'total' => array_sum($values)
            ];
        } catch (PDOException $e) {
            error_log('Error getting application status distribution: ' . $e->getMessage());

            // Return fallback data
            return [
                'labels' => ['Pending', 'Under Review', 'Shortlisted', 'Rejected', 'Hired'],
                'values' => [0, 0, 0, 0, 0],
                'colors' => ['#F59E0B', '#3B82F6', '#10B981', '#EF4444', '#8B5CF6'],
                'total' => 0
            ];
        }
    }

    public function getApplicationStatistics()
    {
        try {
            // Get overall statistics
            $sql = "SELECT 
                    COUNT(*) as total_applications,
                    COUNT(CASE WHEN application_status = 'pending' THEN 1 END) as pending,
                    COUNT(CASE WHEN application_status = 'reviewed' THEN 1 END) as reviewed,
                    COUNT(CASE WHEN application_status = 'shortlisted' THEN 1 END) as shortlisted,
                    COUNT(CASE WHEN application_status = 'rejected' THEN 1 END) as rejected,
                    COUNT(CASE WHEN application_status = 'hired' THEN 1 END) as hired,
                    AVG(TIMESTAMPDIFF(DAY, applied_at, 
                        CASE 
                            WHEN application_status != 'pending' THEN updated_at 
                            ELSE NULL 
                        END
                    )) as avg_processing_days
                FROM job_application 
                WHERE is_finalized = 1";

            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $stats = $stmt->fetch(PDO::FETCH_ASSOC);

            // Get monthly application trends for the last 6 months
            $sql = "SELECT 
                    DATE_FORMAT(applied_at, '%Y-%m') as month,
                    DATE_FORMAT(applied_at, '%M %Y') as month_name,
                    COUNT(*) as applications_count
                FROM job_application 
                WHERE applied_at >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
                AND is_finalized = 1
                GROUP BY DATE_FORMAT(applied_at, '%Y-%m')
                ORDER BY applied_at ASC";

            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $monthlyTrends = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return [
                'overall' => [
                    'total_applications' => (int)($stats['total_applications'] ?? 0),
                    'pending' => (int)($stats['pending'] ?? 0),
                    'reviewed' => (int)($stats['reviewed'] ?? 0),
                    'shortlisted' => (int)($stats['shortlisted'] ?? 0),
                    'rejected' => (int)($stats['rejected'] ?? 0),
                    'hired' => (int)($stats['hired'] ?? 0),
                    'avg_processing_days' => round($stats['avg_processing_days'] ?? 0, 1)
                ],
                'monthly_trends' => $monthlyTrends
            ];
        } catch (PDOException $e) {
            error_log('Error getting application statistics: ' . $e->getMessage());

            return [
                'overall' => [
                    'total_applications' => 0,
                    'pending' => 0,
                    'reviewed' => 0,
                    'shortlisted' => 0,
                    'rejected' => 0,
                    'hired' => 0,
                    'avg_processing_days' => 0
                ],
                'monthly_trends' => []
            ];
        }
    }
}
