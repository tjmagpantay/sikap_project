<?php
require_once __DIR__ . '/../models/Application.php';
require_once __DIR__ . '/../services/NotificationService.php';

class ApplicationController
{
    private $pdo;
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function listApplications()
    {
        $appModel = new Application($this->pdo);
        return $appModel->getAll();
    }

    public function updateStatus($appId, $status)
    {
        $appModel = new Application($this->pdo);
        $notifService = new NotificationService($this->pdo);

        $app = $appModel->getById($appId);
        if (!$app || !isset($app['jobseeker_id'])) return false;

        $appModel->updateStatus($appId, $status);

        // notify the jobseeker only if jobseeker_id exists
        $notifService->notifySingle(
            $app['jobseeker_id'],
            "application_update",
            "Your application for job #{$app['job_id']} was updated to '$status'",
            "/applications/$appId"
        );

        return true;
    }
}
