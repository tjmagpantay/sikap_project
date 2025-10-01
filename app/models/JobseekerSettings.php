<?php
require_once __DIR__ . '/../../config/sikap_db.php';

class JobseekerSettings
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
            error_log("JobseekerSettings database connection failed: " . $e->getMessage());
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function getSettingsByJobseekerId($jobseeker_id)
    {
        try {
            // Return default settings since we're not actively using them
            return [
                'job_recommendations' => 1,
                'application_updates' => 1,
                'programs_news' => 0,
                'profile_visibility' => 1,
                'contact_information' => 1,
                'resume_download' => 1
            ];
        } catch (PDOException $e) {
            error_log("Error getting jobseeker settings: " . $e->getMessage());
            return $this->getDefaultSettings();
        }
    }

    private function getDefaultSettings()
    {
        return [
            'job_recommendations' => 1,
            'application_updates' => 1,
            'programs_news' => 0,
            'profile_visibility' => 1,
            'contact_information' => 1,
            'resume_download' => 1
        ];
    }

    public function createDefaultSettings($jobseeker_id)
    {
        // Implementation for future use
        return true;
    }

    public function updateEmailPreferences($jobseeker_id, $preferences)
    {
        // Implementation for future use
        return true;
    }

    public function updatePrivacySettings($jobseeker_id, $settings)
    {
        // Implementation for future use
        return true;
    }
    
}
