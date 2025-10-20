<?php

require_once __DIR__ . '/../models/Jobseeker.php';

class JobRecommendationService
{
    private $jobseekerModel;
    private $pythonScriptPath = __DIR__ . '/../../python/job-recommendation-system/app.py';

    public function __construct()
    {
        $this->jobseekerModel = new Jobseeker();
    }

    /**
     * Get job recommendations for a jobseeker using direct Python execution
     */
    public function getRecommendations($jobseeker_id, $top_k = 10)
    {
        try {
            $command = sprintf(
                'cd "%s" && python app.py recommendations %d %d 2>&1',
                dirname($this->pythonScriptPath),
                intval($jobseeker_id),
                intval($top_k)
            );

            $output = shell_exec($command);

            if ($output === null) {
                return [
                    'success' => false,
                    'error' => 'Failed to execute Python script'
                ];
            }

            // Clean output to get only JSON
            $lines = explode("\n", trim($output));
            $jsonLine = end($lines);

            $result = json_decode($jsonLine, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                return [
                    'success' => false,
                    'error' => 'Invalid JSON response from recommendation engine'
                ];
            }

            if (isset($result['error'])) {
                return [
                    'success' => false,
                    'error' => $result['error']
                ];
            }

            // Format response for PHP consumption
            return [
                'success' => true,
                'jobseeker' => $result['jobseeker'] ?? [],
                'recommendations' => $result['recommendations'] ?? [],
                'total_found' => count($result['recommendations'] ?? []),
                'total_jobs_analyzed' => $result['total_jobs_analyzed'] ?? 0,
                'jobs_after_filter' => $result['jobs_after_category_filter'] ?? 0,
                'algorithm_version' => $result['algorithm_version'] ?? 'unknown',
                'debug_info' => $result['debug_info'] ?? [],
                'quality_metrics' => [
                    'avg_skill_overlap' => $result['debug_info']['avg_skill_overlap'] ?? 0,
                    'avg_skill_value' => $result['debug_info']['avg_specificity_score'] ?? 0,
                    'best_match' => $result['debug_info']['best_overall_match'] ?? 0,
                    'filtering_applied' => $result['debug_info']['quality_threshold_applied'] ?? false
                ]
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => 'System error: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Test Flask API connection
     */
    public function testFlaskConnection()
    {
        try {
            $url = 'http://127.0.0.1:5001/health';

            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 10,
                CURLOPT_CONNECTTIMEOUT => 5
            ]);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($response === false || $httpCode !== 200) {
                return [
                    'success' => false,
                    'message' => 'Flask API not accessible'
                ];
            }

            $data = json_decode($response, true);
            if (isset($data['ok']) && $data['ok'] === true) {
                return [
                    'success' => true,
                    'message' => 'Flask API is running'
                ];
            }

            return [
                'success' => false,
                'message' => 'Flask API returned unexpected response'
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Error testing Flask connection: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Get all jobseekers for dropdown
     */
    public function getAllJobseekers()
    {
        try {
            return $this->jobseekerModel->getAllJobseekers();
        } catch (Exception $e) {
            error_log('Get All Jobseekers Error: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Test Python script directly
     */
    public function testPythonScript()
    {
        try {
            $command = "python \"{$this->pythonScriptPath}\" test 2>&1";
            $output = shell_exec($command);

            if ($output === null) {
                return [
                    'success' => false,
                    'error' => 'Python script not executable'
                ];
            }

            $result = json_decode(trim($output), true);

            if (json_last_error() === JSON_ERROR_NONE) {
                return $result;
            }

            return [
                'success' => false,
                'error' => 'Python script returned invalid JSON'
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => 'Error testing Python script: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Test Python script connection
     */
    public function testConnection()
    {
        try {
            // Check if Python script exists
            if (!file_exists($this->pythonScriptPath)) {
                return [
                    'success' => false,
                    'message' => 'Python script not found'
                ];
            }

            // Try different Python executables
            $python_executables = ['python', 'python3', 'py'];
            $working_python = null;

            foreach ($python_executables as $python_exe) {
                $test_command = "{$python_exe} --version 2>&1";
                $version_output = shell_exec($test_command);

                if ($version_output && strpos($version_output, 'Python') !== false) {
                    $working_python = $python_exe;
                    break;
                }
            }

            if (!$working_python) {
                return [
                    'success' => false,
                    'message' => 'No working Python executable found'
                ];
            }

            // Test Python script
            $command = sprintf(
                'cd "%s" && %s app.py test 2>&1',
                dirname($this->pythonScriptPath),
                $working_python
            );

            $output = shell_exec($command);

            if ($output === null) {
                return [
                    'success' => false,
                    'message' => 'Python script execution failed'
                ];
            }

            // Look for JSON in output
            $lines = explode("\n", $output);
            $json_line = '';

            foreach ($lines as $line) {
                $line = trim($line);
                if (!empty($line) && substr($line, 0, 1) === '{') {
                    $json_line = $line;
                    break;
                }
            }

            if (empty($json_line)) {
                return [
                    'success' => false,
                    'message' => 'No valid JSON response from Python script'
                ];
            }

            $result = json_decode($json_line, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                return [
                    'success' => false,
                    'message' => 'Invalid JSON response from Python script'
                ];
            }

            // Check if test was successful
            if (isset($result['success']) && $result['success']) {
                return [
                    'success' => true,
                    'message' => 'Python recommendation service is working correctly',
                    'python_response' => $result
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Python script test failed: ' . ($result['message'] ?? 'Unknown error')
                ];
            }
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Connection test error: ' . $e->getMessage()
            ];
        }
    }
}
