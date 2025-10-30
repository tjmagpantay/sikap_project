<?php

require_once __DIR__ . '/../models/Jobseeker.php';

class JobRecommendationService
{
    // UPDATED: Use your Render microservice URL
    private $pythonApiUrl = 'https://sikap-ml.onrender.com';
    private $timeout = 30; // seconds
    private $apiKey;
    private $jobseekerModel;

    /**
     * JobRecommendationService constructor.
     * CURRENT ISSUE: Creates Jobseeker model without database connection
     */
    public function __construct()
    {
        // Optional: Add API key for security
        $this->apiKey = $_ENV['PYTHON_API_KEY'] ?? 'your-secret-key';
        $this->jobseekerModel = new Jobseeker(); // No database connection passed!
    }

    /**
     * Get job recommendations from Python microservice
     */
    public function getRecommendations($jobseeker_id, $top_k = 10)
    {
        try {
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
}
