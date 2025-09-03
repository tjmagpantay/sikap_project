<?php
require_once __DIR__ . '/../../config/sikap_db.php';

class EmployerSettings
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
            error_log("EmployerSettings: Database connection successful");
        } catch (PDOException $e) {
            error_log("EmployerSettings database connection failed: " . $e->getMessage());
            die("Connection failed: " . $e->getMessage());
        }
    }

    // Get settings by employer_id
    public function getSettingsByEmployerId($employer_id)
    {
        try {
            error_log("EmployerSettings: Getting settings for employer_id: $employer_id");
            
            $sql = "SELECT * FROM employer_settings WHERE employer_id = :employer_id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['employer_id' => $employer_id]);

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            // If no settings exist, create default settings
            if (!$result) {
                error_log("EmployerSettings: No settings found, creating default settings");
                $this->createDefaultSettings($employer_id);
                return $this->getDefaultSettings();
            }

            error_log("EmployerSettings: Settings found: " . print_r($result, true));
            return $result;
        } catch (PDOException $e) {
            error_log("Error getting employer settings: " . $e->getMessage());
            return $this->getDefaultSettings();
        }
    }

    // Create default settings
    public function createDefaultSettings($employer_id)
    {
        try {
            error_log("EmployerSettings: Creating default settings for employer_id: $employer_id");
            
            $sql = "INSERT INTO employer_settings (
                employer_id, application_notifications, candidate_matches, 
                job_post_updates, platform_updates, company_profile_visibility, 
                contact_information, job_post_analytics, auto_screen_applications,
                send_auto_replies, priority_candidate_alerts
            ) VALUES (?, 1, 1, 1, 0, 1, 1, 1, 0, 1, 1)";

            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute([$employer_id]);
            
            error_log("EmployerSettings: Default settings created successfully: " . ($result ? 'true' : 'false'));
            return $result;
        } catch (PDOException $e) {
            error_log("Error creating default employer settings: " . $e->getMessage());
            return false;
        }
    }

    // Update email preferences
    public function updateEmailPreferences($employer_id, $preferences)
    {
        try {
            error_log("EmployerSettings: Updating email preferences for employer_id: $employer_id");
            error_log("EmployerSettings: Preferences data: " . print_r($preferences, true));
            
            // Ensure settings exist first
            $this->ensureSettingsExist($employer_id);

            $sql = "UPDATE employer_settings SET 
                application_notifications = ?, candidate_matches = ?, 
                job_post_updates = ?, platform_updates = ?, updated_at = NOW()
                WHERE employer_id = ?";

            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute([
                $preferences['application_notifications'],
                $preferences['candidate_matches'],
                $preferences['job_post_updates'],
                $preferences['platform_updates'],
                $employer_id
            ]);
            
            error_log("EmployerSettings: Email preferences update result: " . ($result ? 'success' : 'failed'));
            error_log("EmployerSettings: Affected rows: " . $stmt->rowCount());
            
            return $result;
        } catch (PDOException $e) {
            error_log("Error updating employer email preferences: " . $e->getMessage());
            return false;
        }
    }

    // Update visibility settings
    public function updateVisibilitySettings($employer_id, $settings)
    {
        try {
            error_log("EmployerSettings: Updating visibility settings for employer_id: $employer_id");
            error_log("EmployerSettings: Settings data: " . print_r($settings, true));
            
            // Ensure settings exist first
            $this->ensureSettingsExist($employer_id);

            $sql = "UPDATE employer_settings SET 
                company_profile_visibility = ?, contact_information = ?, 
                job_post_analytics = ?, updated_at = NOW()
                WHERE employer_id = ?";

            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute([
                $settings['company_profile_visibility'],
                $settings['contact_information'],
                $settings['job_post_analytics'],
                $employer_id
            ]);
            
            error_log("EmployerSettings: Visibility settings update result: " . ($result ? 'success' : 'failed'));
            return $result;
        } catch (PDOException $e) {
            error_log("Error updating employer visibility settings: " . $e->getMessage());
            return false;
        }
    }

    // Update hiring preferences
    public function updateHiringPreferences($employer_id, $settings)
    {
        try {
            error_log("EmployerSettings: Updating hiring preferences for employer_id: $employer_id");
            error_log("EmployerSettings: Settings data: " . print_r($settings, true));
            
            // Ensure settings exist first
            $this->ensureSettingsExist($employer_id);

            $sql = "UPDATE employer_settings SET 
                auto_screen_applications = ?, send_auto_replies = ?, 
                priority_candidate_alerts = ?, updated_at = NOW()
                WHERE employer_id = ?";

            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute([
                $settings['auto_screen_applications'],
                $settings['send_auto_replies'],
                $settings['priority_candidate_alerts'],
                $employer_id
            ]);
            
            error_log("EmployerSettings: Hiring preferences update result: " . ($result ? 'success' : 'failed'));
            return $result;
        } catch (PDOException $e) {
            error_log("Error updating employer hiring preferences: " . $e->getMessage());
            return false;
        }
    }

    private function ensureSettingsExist($employer_id)
    {
        try {
            error_log("EmployerSettings: Checking if settings exist for employer_id: $employer_id");
            
            $sql = "SELECT setting_id FROM employer_settings WHERE employer_id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$employer_id]);

            if (!$stmt->fetch()) {
                error_log("EmployerSettings: Settings don't exist, creating default settings");
                $this->createDefaultSettings($employer_id);
            } else {
                error_log("EmployerSettings: Settings already exist");
            }
        } catch (PDOException $e) {
            error_log("Error checking settings existence: " . $e->getMessage());
        }
    }

    private function getDefaultSettings()
    {
        return [
            'application_notifications' => 1,
            'candidate_matches' => 1,
            'job_post_updates' => 1,
            'platform_updates' => 0,
            'company_profile_visibility' => 1,
            'contact_information' => 1,
            'job_post_analytics' => 1,
            'auto_screen_applications' => 0,
            'send_auto_replies' => 1,
            'priority_candidate_alerts' => 1
        ];
    }
}
