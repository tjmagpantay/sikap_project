<?php
class Application
{
    private $pdo;
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function create($jobId, $jobseekerId)
    {
        $stmt = $this->pdo->prepare("INSERT INTO applications (job_id, jobseeker_id) VALUES (:job_id, :jobseeker_id)");
        $stmt->execute([":job_id" => $jobId, ":jobseeker_id" => $jobseekerId]);
        return $this->pdo->lastInsertId();
    }

    public function updateStatus($appId, $status)
    {
        $stmt = $this->pdo->prepare("UPDATE applications SET status = :status, updated_at = NOW() WHERE id = :id");
        $stmt->execute([":status" => $status, ":id" => $appId]);
    }

    public function getAll()
    {
        $stmt = $this->pdo->query("SELECT a.*, u.name AS jobseeker_name, j.title AS job_title 
                                   FROM applications a
                                   JOIN users u ON a.jobseeker_id = u.id
                                   JOIN jobs j ON a.job_id = j.id");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM applications WHERE id = :id");
        $stmt->execute([":id" => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByJobseeker($jobseekerId)
    {
        $stmt = $this->pdo->prepare("
            SELECT a.*, j.title as job_title
            FROM applications a
            JOIN jobs j ON a.job_id = j.id
            WHERE a.jobseeker_id = :jobseeker_id
            ORDER BY a.updated_at DESC
        ");
        $stmt->execute([":jobseeker_id" => $jobseekerId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
