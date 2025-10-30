<?php

require_once __DIR__ . '/../models/Jobseeker.php';

class JobRecommendationService
{
    // UPDATED: Use your Render microservice URL
    private $pythonApiUrl = 'https://sikap-ml.onrender.com';
    private $timeout = 30; // seconds
    private $apiKey;
    private $jobseekerModel;
    private $db; // ADDED: Store database connection

    /**
     * JobRecommendationService constructor.
     * FIXED: Accept database connection parameter
     */
    public function __construct($database = null)
    {
        // FIXED: Use DatabaseHelper if no database connection provided
        if ($database) {
            $this->db = $database;
        } else {
            require_once __DIR__ . '/../helpers/DatabaseHelper.php';
            $this->db = DatabaseHelper::getConnection();
        }

        // Optional: Add API key for security
        $this->apiKey = $_ENV['PYTHON_API_KEY'] ?? 'your-secret-key';

        // FIXED: Pass database connection to Jobseeker model
        $this->jobseekerModel = new Jobseeker($this->db);
    }

    /**
     * Get job recommendations from Python microservice
     */
    public function getRecommendations($jobseeker_id, $top_k = 10)
    {
        try {
            // ADDED: Validate jobseeker exists before calling API
            if (!$this->jobseekerExists($jobseeker_id)) {
                return [
                    'success' => false,
                    'error' => 'Jobseeker not found'
                ];
            }

            // Prepare data for Python API
            $requestData = [
                'jobseeker_id' => (int)$jobseeker_id,
                'top_k' => (int)$top_k
            ];

            // Call Python microservice
            $response = $this->callPythonAPI('/recommend', $requestData);

            if ($response === false) {
                return [
                    'success' => false,
                    'error' => 'Failed to connect to recommendation service'
                ];
            }

            // Parse response
            $data = json_decode($response, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                return [
                    'success' => false,
                    'error' => 'Invalid response from recommendation service'
                ];
            }

            return $data;
        } catch (Exception $e) {
            error_log('JobRecommendationService Error: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => 'Recommendation service unavailable: ' . $e->getMessage()
            ];
        }
    }

    /**
     * ADDED: Validate jobseeker exists
     */
    private function jobseekerExists($jobseeker_id)
    {
        try {
            $stmt = $this->db->prepare("SELECT jobseeker_id FROM jobseeker WHERE jobseeker_id = ? LIMIT 1");
            $stmt->execute([$jobseeker_id]);
            return $stmt->fetch() !== false;
        } catch (Exception $e) {
            error_log('Error checking jobseeker existence: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Test connection to Python microservice
     */
    public function testConnection()
    {
        try {
            $response = $this->callPythonAPI('/health', [], 'GET');

            if ($response === false) {
                return [
                    'success' => false,
                    'message' => 'Cannot connect to Python microservice at ' . $this->pythonApiUrl
                ];
            }

            $data = json_decode($response, true);

            return [
                'success' => true,
                'message' => 'Successfully connected to Python microservice',
                'python_response' => $data
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Connection test failed: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Call Python API endpoint
     */
    private function callPythonAPI($endpoint, $data = [], $method = 'POST')
    {
        $url = $this->pythonApiUrl . $endpoint;

        // Initialize cURL
        $ch = curl_init();

        // Set cURL options
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => $this->timeout,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYPEER => false, // For development only
            CURLOPT_USERAGENT => 'SIKAP-PHP-Client/1.0',
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Accept: application/json',
                'X-API-Key: ' . $this->apiKey
            ]
        ]);

        // Set method-specific options
        if (strtoupper($method) === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            if (!empty($data)) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            }
        } elseif (strtoupper($method) === 'GET' && !empty($data)) {
            $url .= '?' . http_build_query($data);
            curl_setopt($ch, CURLOPT_URL, $url);
        }

        // Execute request
        $response = curl_exec($ch);

        // Check for cURL errors
        if (curl_error($ch)) {
            $error = curl_error($ch);
            curl_close($ch);
            error_log("cURL Error: $error");
            return false;
        }

        // Check HTTP status code
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode >= 400) {
            error_log("HTTP Error: $httpCode - Response: $response");
            return false;
        }

        return $response;
    }

    /**
     * ADDED: Get jobseeker profile data for ML features
     */
    public function getJobseekerFeatures($jobseeker_id)
    {
        try {
            // FIXED: Use existing method from Jobseeker model
            return $this->jobseekerModel->getRecommendationData($jobseeker_id);
        } catch (Exception $e) {
            error_log('Error getting jobseeker features: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * ADDED: Get comprehensive jobseeker data for recommendations
     */
    public function getJobseekerProfile($jobseeker_id)
    {
        try {
            // Get basic jobseeker info
            $jobseeker = $this->jobseekerModel->findById($jobseeker_id);
            if (!$jobseeker) {
                return null;
            }

            // Get all related data
            $skills = $this->jobseekerModel->getJobseekerSkills($jobseeker_id);
            $workExperience = $this->jobseekerModel->getJobseekerWorkExperience($jobseeker_id);
            $education = $this->jobseekerModel->getJobseekerEducation($jobseeker_id);

            return [
                'jobseeker_id' => $jobseeker_id,
                'basic_info' => $jobseeker,
                'skills' => $skills,
                'work_experience' => $workExperience,
                'education' => $education,
                'full_name' => trim($jobseeker['first_name'] . ' ' . $jobseeker['last_name'])
            ];
        } catch (Exception $e) {
            error_log('Error getting comprehensive jobseeker profile: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * ADDED: Prepare data for Python ML service
     */
    public function prepareMLData($jobseeker_id)
    {
        try {
            $profile = $this->getJobseekerProfile($jobseeker_id);
            if (!$profile) {
                return null;
            }

            // Format data for ML service
            $mlData = [
                'jobseeker_id' => $jobseeker_id,
                'skills' => array_column($profile['skills'], 'skill_name'),
                'experience_titles' => array_column($profile['work_experience'], 'job_title'),
                'education_levels' => array_column($profile['education'], 'education_level'),
                'education_fields' => array_column($profile['education'], 'field_of_study')
            ];

            return $mlData;
        } catch (Exception $e) {
            error_log('Error preparing ML data: ' . $e->getMessage());
            return null;
        }
    }
}
