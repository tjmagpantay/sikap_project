<?php
require_once __DIR__ . '/../../config/sikap_db.php';

class ResignationRequest
{
    private $db;

    public function __construct()
    {
        $config = require __DIR__ . '/../../config/sikap_db.php';

        try {
            $this->db = new PDO(
                "mysql:host={$config['db_host']};dbname={$config['db_name']};charset=utf8mb4",
                $config['db_user'],
                $config['db_pass'],
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]
            );

            // Test the connection
            $testQuery = $this->db->query("SELECT 1");
            if (!$testQuery) {
                throw new Exception('Database connection test failed');
            }

            error_log('ResignationRequest model: Database connection successful');
        } catch (PDOException $e) {
            error_log('Database connection failed: ' . $e->getMessage());
            throw new Exception('Database connection failed');
        }
    }

    public function getPdo()
    {
        return $this->db;
    }

    public function createResignationRequest($data)
    {
        try {
            $sql = "INSERT INTO resignation_requests (application_id, jobseeker_id, employer_id, resignation_reason) 
                    VALUES (:application_id, :jobseeker_id, :employer_id, :resignation_reason)";
            $stmt = $this->db->prepare($sql);

            $result = $stmt->execute([
                ':application_id' => $data['application_id'],
                ':jobseeker_id' => $data['jobseeker_id'],
                ':employer_id' => $data['employer_id'],
                ':resignation_reason' => $data['resignation_reason']
            ]);

            if ($result) {
                error_log('Resignation request created successfully for application: ' . $data['application_id']);
                return true;
            } else {
                error_log('Failed to create resignation request - SQL execution failed');
                return false;
            }
        } catch (PDOException $e) {
            error_log('Error creating resignation request: ' . $e->getMessage());
            error_log('SQL State: ' . $e->errorInfo[0]);
            error_log('Error Code: ' . $e->errorInfo[1]);
            error_log('Error Message: ' . $e->errorInfo[2]);
            return false;
        }
    }

    public function getResignationRequestByApplication($application_id)
    {
        try {
            $sql = "SELECT rr.*, ja.job_id, jp.job_title, 
                           js.first_name, js.last_name,
                           e.company_name, eb.business_name
                    FROM resignation_requests rr
                    JOIN job_application ja ON rr.application_id = ja.application_id
                    JOIN job_post jp ON ja.job_id = jp.job_id
                    JOIN jobseeker js ON rr.jobseeker_id = js.jobseeker_id
                    JOIN employer e ON rr.employer_id = e.employer_id
                    LEFT JOIN employers_business eb ON e.employer_id = eb.employer_id
                    WHERE rr.application_id = ?
                    ORDER BY rr.requested_at DESC
                    LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$application_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error getting resignation request: ' . $e->getMessage());
            return null;
        }
    }

    public function getResignationRequestsByEmployer($employer_id, $status = null)
    {
        try {
            $sql = "SELECT rr.*, ja.job_id, jp.job_title, jp.location,
                           js.first_name, js.last_name, js.contact_no,
                           u.email
                    FROM resignation_requests rr
                    JOIN job_application ja ON rr.application_id = ja.application_id
                    JOIN job_post jp ON ja.job_id = jp.job_id
                    JOIN jobseeker js ON rr.jobseeker_id = js.jobseeker_id
                    JOIN user u ON js.user_id = u.user_id
                    WHERE rr.employer_id = ?";

            $params = [$employer_id];

            if ($status) {
                $sql .= " AND rr.request_status = ?";
                $params[] = $status;
            }

            $sql .= " ORDER BY rr.requested_at DESC";

            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error getting resignation requests: ' . $e->getMessage());
            return [];
        }
    }

    public function updateResignationStatus($resignation_id, $status, $employer_notes = null, $reviewed_by = null)
    {
        try {
            $sql = "UPDATE resignation_requests 
                    SET request_status = ?, employer_notes = ?, reviewed_by = ?, reviewed_at = NOW()
                    WHERE resignation_id = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$status, $employer_notes, $reviewed_by, $resignation_id]);
        } catch (PDOException $e) {
            error_log('Error updating resignation status: ' . $e->getMessage());
            return false;
        }
    }

    public function hasActivePendingRequest($application_id)
    {
        try {
            $sql = "SELECT COUNT(*) FROM resignation_requests 
                    WHERE application_id = ? AND request_status = 'pending'";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$application_id]);
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            error_log('Error checking pending resignation: ' . $e->getMessage());
            return false;
        }
    }
}
