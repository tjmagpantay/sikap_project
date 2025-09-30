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
            $sql = "SELECT * FROM jobseeker_settings WHERE jobseeker_id = :jobseeker_id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['jobseeker_id' => $jobseeker_id]);

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            // If no settings exist, create default settings
            if (!$result) {
                $this->createDefaultSettings($jobseeker_id);
                return $this->getDefaultSettings();
            }

            return $result;
        } catch (PDOException $e) {
            error_log("Error getting jobseeker settings: " . $e->getMessage());
            return $this->getDefaultSettings();
        }
    }

    public function createDefaultSettings($jobseeker_id)
    {
        try {
            $sql = "INSERT INTO jobseeker_settings (
                jobseeker_id, job_recommendations, application_updates, 
                programs_news, profile_visibility, contact_information, resume_download
            ) VALUES (?, 1, 1, 0, 1, 1, 1)";

            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$jobseeker_id]);
        } catch (PDOException $e) {
            error_log("Error creating default settings: " . $e->getMessage());
            return false;
        }
    }

    public function updateEmailPreferences($jobseeker_id, $preferences)
    {
        try {
            // Ensure settings exist first
            $this->ensureSettingsExist($jobseeker_id);

            $sql = "UPDATE jobseeker_settings SET 
                job_recommendations = ?, application_updates = ?, programs_news = ?, updated_at = NOW()
                WHERE jobseeker_id = ?";

            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                $preferences['job_recommendations'],
                $preferences['application_updates'],
                $preferences['programs_news'],
                $jobseeker_id
            ]);
        } catch (PDOException $e) {
            error_log("Error updating email preferences: " . $e->getMessage());
            return false;
        }
    }

    public function updatePrivacySettings($jobseeker_id, $settings)
    {
        try {
            // Ensure settings exist first
            $this->ensureSettingsExist($jobseeker_id);

            $sql = "UPDATE jobseeker_settings SET 
                profile_visibility = ?, contact_information = ?, resume_download = ?, updated_at = NOW()
                WHERE jobseeker_id = ?";

            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                $settings['profile_visibility'],
                $settings['contact_information'],
                $settings['resume_download'],
                $jobseeker_id
            ]);
        } catch (PDOException $e) {
            error_log("Error updating privacy settings: " . $e->getMessage());
            return false;
        }
    }

    private function ensureSettingsExist($jobseeker_id)
    {
        $sql = "SELECT setting_id FROM jobseeker_settings WHERE jobseeker_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$jobseeker_id]);

        if (!$stmt->fetch()) {
            $this->createDefaultSettings($jobseeker_id);
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
}
