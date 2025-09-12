<?php
class Job {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function create($employerId, $title) {
        $stmt = $this->pdo->prepare("
            INSERT INTO jobs (employer_id, title) 
            VALUES (:employer_id, :title)
        ");
        $stmt->execute([
            ":employer_id" => $employerId,
            ":title" => $title
        ]);
        return $this->pdo->lastInsertId();
    }
}
