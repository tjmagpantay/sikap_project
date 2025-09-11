<?php
// filepath: c:\xampp\htdocs\sikap\app\services\JobRecommendationService.php

require_once __DIR__ . '/../models/Jobseeker.php';

class JobRecommendationService
{
    private $jobseekerModel;

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
            error_log("🔍 JobRecommendationService: Getting recommendations for jobseeker {$jobseeker_id}");

            $python_script = __DIR__ . '/../../python/job-recommendation-system/app.py';
            $python_dir = dirname($python_script);

            // Check if Python script exists
            if (!file_exists($python_script)) {
                error_log("❌ Python script not found at: {$python_script}");
                return [
                    'success' => false,
                    'error' => 'Python script not found at: ' . $python_script
                ];
            }

            // FIXED: Try different Python executables with proper path
            $python_executables = ['python', 'python3', 'py'];
            $working_python = null;

            foreach ($python_executables as $python_exe) {
                $test_command = "{$python_exe} --version 2>&1";
                $version_output = shell_exec($test_command);

                if ($version_output && strpos($version_output, 'Python') !== false) {
                    $working_python = $python_exe;
                    error_log("✅ Found working Python: {$python_exe}");
                    break;
                }
            }

            if (!$working_python) {
                error_log("❌ No working Python executable found");
                return [
                    'success' => false,
                    'error' => 'No working Python executable found. Tried: ' . implode(', ', $python_executables)
                ];
            }

            // FIXED: Build command with proper directory change and error redirection
            $command = sprintf(
                'cd /d "%s" && %s app.py recommendations %d %d',
                $python_dir,
                $working_python,
                intval($jobseeker_id),
                intval($top_k)
            );

            error_log("🐍 Executing command: {$command}");

            // FIXED: Use different execution method to capture both stdout and stderr
            $descriptorspec = [
                0 => ['pipe', 'r'],  // stdin
                1 => ['pipe', 'w'],  // stdout
                2 => ['pipe', 'w']   // stderr
            ];

            $process = proc_open($command, $descriptorspec, $pipes);

            if (is_resource($process)) {
                // Close stdin
                fclose($pipes[0]);

                // Read stdout and stderr
                $stdout = stream_get_contents($pipes[1]);
                $stderr = stream_get_contents($pipes[2]);

                fclose($pipes[1]);
                fclose($pipes[2]);

                $return_value = proc_close($process);

                error_log("📤 Python stdout: " . $stdout);
                error_log("📤 Python stderr: " . $stderr);
                error_log("📤 Return value: " . $return_value);

                if ($return_value !== 0) {
                    error_log("❌ Python process failed with return code: {$return_value}");
                    return [
                        'success' => false,
                        'error' => 'Python process failed',
                        'return_code' => $return_value,
                        'stderr' => $stderr,
                        'stdout' => $stdout
                    ];
                }

                $output = $stdout;
            } else {
                error_log("❌ Failed to start Python process");
                return [
                    'success' => false,
                    'error' => 'Failed to start Python process'
                ];
            }

            if (empty(trim($output))) {
                error_log("❌ Python script returned empty output");
                return [
                    'success' => false,
                    'error' => 'Python script returned empty output',
                    'stderr' => $stderr ?? 'No stderr'
                ];
            }

            // Look for JSON in the output (should be the last line)
            $lines = explode("\n", trim($output));
            $json_line = '';

            // Get the last non-empty line (which should be the JSON)
            for ($i = count($lines) - 1; $i >= 0; $i--) {
                $line = trim($lines[$i]);
                if (!empty($line) && (substr($line, 0, 1) === '{' || substr($line, 0, 1) === '[')) {
                    $json_line = $line;
                    break;
                }
            }

            if (empty($json_line)) {
                error_log("❌ No JSON found in output");
                return [
                    'success' => false,
                    'error' => 'No valid JSON found in Python output',
                    'raw_output' => $output,
                    'all_lines' => $lines
                ];
            }

            // Decode JSON
            $result = json_decode($json_line, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                error_log("❌ JSON decode error: " . json_last_error_msg());
                return [
                    'success' => false,
                    'error' => 'Invalid JSON response: ' . json_last_error_msg(),
                    'json_line' => $json_line
                ];
            }

            // Handle Python errors
            if (isset($result['error'])) {
                return [
                    'success' => false,
                    'error' => $result['error']
                ];
            }

            // Ensure success flag
            $result['success'] = true;
            if (!isset($result['total_found'])) {
                $result['total_found'] = count($result['recommendations'] ?? []);
            }

            error_log("✅ Successfully processed Python response with {$result['total_found']} recommendations");
            return $result;
        } catch (Exception $e) {
            error_log("❌ JobRecommendationService Exception: " . $e->getMessage());
            return [
                'success' => false,
                'error' => 'Service error: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Test Flask API connection (alternative approach - not used currently)
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
            $python_script = __DIR__ . '/../../python/job-recommendation-system/app.py';
            $command = "python \"{$python_script}\" test 2>&1";

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
                'error' => 'Python script returned invalid JSON',
                'output' => $output
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
            error_log("🔍 Testing Python script connection...");

            $python_script = __DIR__ . '/../../python/job-recommendation-system/app.py';

            // Check if Python script exists
            if (!file_exists($python_script)) {
                return [
                    'success' => false,
                    'message' => 'Python script not found at: ' . $python_script
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
                    'message' => 'No working Python executable found. Tried: ' . implode(', ', $python_executables)
                ];
            }

            // Test Python script
            $command = sprintf(
                'cd "%s" && %s app.py test 2>&1',
                dirname($python_script),
                $working_python
            );

            error_log("🐍 Testing with command: {$command}");
            $output = shell_exec($command);

            if ($output === null) {
                return [
                    'success' => false,
                    'message' => 'Python script execution failed - shell_exec returned null'
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
                    'message' => 'No valid JSON response from Python script',
                    'raw_output' => $output
                ];
            }

            $result = json_decode($json_line, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                return [
                    'success' => false,
                    'message' => 'Invalid JSON response from Python script',
                    'json_error' => json_last_error_msg()
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
                    'message' => 'Python script test failed: ' . ($result['message'] ?? 'Unknown error'),
                    'python_response' => $result
                ];
            }
        } catch (Exception $e) {
            error_log("❌ TestConnection Exception: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Connection test error: ' . $e->getMessage()
            ];
        }
    }
}
