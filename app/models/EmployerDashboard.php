<?php
// filepath: app/models/EmployerDashboard.php

require_once __DIR__ . '/../../config/sikap_db.php';

class EmployerDashboard
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

    public function getEmployerJobPosts($employer_id, $limit = 5, $offset = 0)
    {
        try {
            $sql = "SELECT 
                        jp.job_id,
                        jp.job_title,
                        jp.job_type,
                        jp.job_status,
                        jp.application_deadline,
                        jp.created_at,
                        COUNT(ja.application_id) as application_count
                    FROM job_post jp
                    LEFT JOIN job_application ja ON jp.job_id = ja.job_id AND ja.is_finalized = 1
                    WHERE jp.employer_id = ?
                    GROUP BY jp.job_id, jp.job_title, jp.job_type, jp.job_status, jp.application_deadline, jp.created_at
                    ORDER BY jp.created_at DESC
                    LIMIT " . intval($limit) . " OFFSET " . intval($offset);
            //bawal ang LIMIT = ?

            $stmt = $this->db->prepare($sql);
            $stmt->execute([$employer_id]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            error_log('EmployerDashboard Model - Job posts found: ' . count($result));
            return $result;
        } catch (PDOException $e) {
            error_log('Error fetching employer job posts: ' . $e->getMessage());
            return [];
        }
    }

    public function getTotalJobCount($employer_id)
    {
        try {
            $sql = "SELECT COUNT(*) as total FROM job_post WHERE employer_id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$employer_id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return $result['total'];
        } catch (PDOException $e) {
            error_log('Error getting total job count: ' . $e->getMessage());
            return 0;
        }
    }

    public function getEmployerStats($employer_id)
    {
        try {
            $stats = [];

            // Total jobs
            $sql = "SELECT COUNT(*) as count FROM job_post WHERE employer_id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$employer_id]);
            $stats['total_jobs'] = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

            // Active jobs
            $sql = "SELECT COUNT(*) as count FROM job_post WHERE employer_id = ? AND job_status = 'open'";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$employer_id]);
            $stats['active_jobs'] = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

            // Total applications
            $sql = "SELECT COUNT(*) as count 
                    FROM job_application ja 
                    JOIN job_post jp ON ja.job_id = jp.job_id 
                    WHERE jp.employer_id = ? AND ja.is_finalized = 1";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$employer_id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $stats['total_applications'] = $result['count'];

            // Pending reviews
            $sql = "SELECT COUNT(*) as count 
                    FROM job_application ja 
                    JOIN job_post jp ON ja.job_id = jp.job_id 
                    WHERE jp.employer_id = ? AND ja.application_status = 'pending' AND ja.is_finalized = 1";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$employer_id]);
            $stats['pending_reviews'] = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

            return $stats;
        } catch (PDOException $e) {
            error_log('Error calculating employer stats: ' . $e->getMessage());
            return [
                'total_jobs' => 0,
                'active_jobs' => 0,
                'total_applications' => 0,
                'pending_reviews' => 0
            ];
        }
    }

    public function calculateDaysRemaining($deadline)
    {
        if (!$deadline) {
            return 'No deadline';
        }

        try {
            $now = new DateTime();
            $deadlineDate = new DateTime($deadline);
            $diff = $now->diff($deadlineDate);

            if ($deadlineDate < $now) {
                return 'Expired';
            }

            return $diff->days;
        } catch (Exception $e) {
            error_log('Error calculating days remaining: ' . $e->getMessage());
            return 'Invalid date';
        }
    }

    public function getJobPostsWithFilters($employer_id, $filters = [])
    {
        try {
            $sql = "SELECT 
                        jp.job_id,
                        jp.job_title,
                        jp.job_type,
                        jp.job_status,
                        jp.application_deadline,
                        jp.created_at,
                        COUNT(ja.application_id) as application_count
                    FROM job_post jp
                    LEFT JOIN job_application ja ON jp.job_id = ja.job_id AND ja.is_finalized = 1
                    WHERE jp.employer_id = ?";

            $params = [$employer_id];

            // Add status filter if provided
            if (!empty($filters['status'])) {
                $sql .= " AND jp.job_status = ?";
                $params[] = $filters['status'];
            }

            // Add date range filter if provided
            if (!empty($filters['date_from'])) {
                $sql .= " AND jp.created_at >= ?";
                $params[] = $filters['date_from'];
            }

            if (!empty($filters['date_to'])) {
                $sql .= " AND jp.created_at <= ?";
                $params[] = $filters['date_to'];
            }

            $sql .= " GROUP BY jp.job_id, jp.job_title, jp.job_type, jp.job_status, jp.application_deadline, jp.created_at";

            // Add sorting
            $sortBy = $filters['sort'] ?? 'recent';
            switch ($sortBy) {
                case 'popular':
                    $sql .= " ORDER BY application_count DESC, jp.created_at DESC";
                    break;
                case 'expiring':
                    $sql .= " ORDER BY jp.application_deadline ASC";
                    break;
                default: // recent
                    $sql .= " ORDER BY jp.created_at DESC";
            }

            // Add pagination
            $limit = $filters['limit'] ?? 5;
            $offset = ($filters['page'] ?? 1 - 1) * $limit;
            $sql .= " LIMIT ? OFFSET ?";
            $params[] = $limit;
            $params[] = $offset;

            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error fetching filtered job posts: ' . $e->getMessage());
            return [];
        }
    }

    public function expireJob($job_id, $employer_id)
    {
        try {
            $sql = "UPDATE job_post 
                    SET job_status = 'expired', updated_at = NOW() 
                    WHERE job_id = ? AND employer_id = ?";

            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute([$job_id, $employer_id]);

            if ($result && $stmt->rowCount() > 0) {
                error_log("Job $job_id expired successfully by employer $employer_id");
                return true;
            } else {
                error_log("Failed to expire job $job_id for employer $employer_id");
                return false;
            }
        } catch (PDOException $e) {
            error_log('Error expiring job: ' . $e->getMessage());
            return false;
        }
    }

    public function checkProfileCompletion($employer_id)
    {
        try {
            $sql = "SELECT 
                    e.employer_id,
                    e.first_name,
                    e.last_name,
                    e.phone,
                    e.company_name,
                    e.company_description,
                    e.company_address,
                    e.company_website,
                    e.is_verified,
                    eb.business_id,
                    eb.business_name,
                    eb.business_address,
                    eb.business_logo
                FROM employer e
                LEFT JOIN employers_business eb ON e.employer_id = eb.employer_id
                WHERE e.employer_id = ?";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([$employer_id]);
            $employer = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$employer) {
                return ['has_profile' => false, 'can_post_jobs' => false, 'profile_data' => null];
            }

            // Check if basic profile is complete
            $hasBasicProfile = !empty($employer['first_name']) &&
                !empty($employer['last_name']) &&
                !empty($employer['phone']) &&
                !empty($employer['company_name']);

            // Check if business profile exists
            $hasBusinessProfile = !empty($employer['business_id']);

            // Employer can post jobs if they have basic profile (verification optional for now)
            $canPostJobs = $hasBasicProfile;

            return [
                'has_profile' => $hasBasicProfile,
                'has_business_profile' => $hasBusinessProfile,
                'can_post_jobs' => $canPostJobs,
                'is_verified' => (bool)$employer['is_verified'],
                'profile_data' => $employer
            ];
        } catch (PDOException $e) {
            error_log('Error checking profile completion: ' . $e->getMessage());
            return ['has_profile' => false, 'can_post_jobs' => false, 'profile_data' => null];
        }
    }

    public function getDashboardSummary($employer_id)
    {
        try {
            // Get basic stats
            $stats = $this->getEmployerStats($employer_id);

            // Get profile completion
            $profileStatus = $this->checkProfileCompletion($employer_id);

            // Get recent activities (optional)
            $recentApplications = $this->getRecentApplications($employer_id, 5);

            return [
                'stats' => $stats,
                'profile_status' => $profileStatus,
                'recent_applications' => $recentApplications
            ];
        } catch (Exception $e) {
            error_log('Error getting dashboard summary: ' . $e->getMessage());
            return [
                'stats' => ['total_jobs' => 0, 'active_jobs' => 0, 'total_applications' => 0, 'pending_reviews' => 0],
                'profile_status' => ['has_profile' => false, 'can_post_jobs' => false, 'profile_data' => null],
                'recent_applications' => []
            ];
        }
    }

    public function getRecentApplications($employer_id, $limit = 5)
    {
        try {
            $sql = "SELECT 
                    ja.application_id,
                    ja.application_status,
                    ja.created_at,
                    jp.job_title,
                    js.first_name,
                    js.last_name
                FROM job_application ja
                JOIN job_post jp ON ja.job_id = jp.job_id
                JOIN jobseeker js ON ja.jobseeker_id = js.jobseeker_id
                WHERE jp.employer_id = ? AND ja.is_finalized = 1
                ORDER BY ja.created_at DESC
                LIMIT ?";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([$employer_id, $limit]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error getting recent applications: ' . $e->getMessage());
            return [];
        }
    }
}
