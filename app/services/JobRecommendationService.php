<?php

class JobRecommendationService 
{
    private $pythonApiUrl;
    
    public function __construct() 
    {
        // Make sure your Python API is running on this URL
        $this->pythonApiUrl = 'http://127.0.0.1:5000';
    }
    
    /**
     * Test if Python API is available
     */
    public function testConnection() 
    {
        try {
            $response = $this->makeRequest('GET', '/health');
            return $response !== false && isset($response['status']) && $response['status'] === 'healthy';
        } catch (Exception $e) {
            error_log('Python API connection test failed: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Get job recommendations for a jobseeker using real database data
     */
    public function getJobRecommendationsForJobseeker($jobseeker_id, $limit = 10) 
    {
        try {
            // Get jobseeker skills from database
            require_once __DIR__ . '/../models/Jobseeker.php';
            $jobseekerModel = new Jobseeker();
            $jobseekerData = $jobseekerModel->findById($jobseeker_id);
            $jobseekerSkills = $jobseekerModel->getSkillsArray($jobseeker_id);
            
            if (empty($jobseekerSkills)) {
                return [
                    'success' => false,
                    'message' => 'No skills found for jobseeker',
                    'recommendations' => []
                ];
            }
            
            // Get active jobs with their skills from database
            require_once __DIR__ . '/../models/JobPost.php';
            $jobPostModel = new JobPost();
            $activeJobs = $jobPostModel->getAllActiveJobs();
            
            if (empty($activeJobs)) {
                return [
                    'success' => false,
                    'message' => 'No active jobs found',
                    'recommendations' => []
                ];
            }
            
            // Format jobs for ML API
            $formattedJobs = [];
            foreach ($activeJobs as $job) {
                $jobSkills = $jobPostModel->getJobSkillsArray($job['job_id']);
                
                if (!empty($jobSkills)) {
                    $formattedJobs[] = [
                        'job_id' => (int)$job['job_id'],
                        'job_title' => $job['job_title'],
                        'company_name' => $job['company_name'] ?? $job['business_name'] ?? 'Unknown Company',
                        'location' => $job['location'] ?? '',
                        'job_type' => $job['job_type'] ?? '',
                        'salary' => $job['salary'] ?? null,
                        'show_pay' => $job['show_pay'] ?? false,
                        'job_summary' => $job['job_summary'] ?? '',
                        'skills' => $jobSkills,
                        'posted_date' => $job['posted_date'] ?? null
                    ];
                }
            }
            
            if (empty($formattedJobs)) {
                return [
                    'success' => false,
                    'message' => 'No jobs with skills found',
                    'recommendations' => []
                ];
            }
            
            // Prepare data for ML API
            $requestData = [
                'jobseeker' => [
                    'id' => (int)$jobseeker_id,
                    'name' => ($jobseekerData['first_name'] ?? '') . ' ' . ($jobseekerData['last_name'] ?? ''),
                    'skills' => $jobseekerSkills
                ],
                'jobs' => $formattedJobs
            ];
            
            // Send to ML API
            $response = $this->makeRequest('POST', '/test_with_real_data', $requestData);
            
            if ($response && isset($response['success']) && $response['success']) {
                // Limit recommendations if specified
                $recommendations = $response['recommendations'] ?? [];
                if ($limit > 0) {
                    $recommendations = array_slice($recommendations, 0, $limit);
                }
                
                return [
                    'success' => true,
                    'jobseeker_id' => $jobseeker_id,
                    'jobseeker_skills' => $jobseekerSkills,
                    'total_jobs_analyzed' => $response['total_jobs_analyzed'] ?? 0,
                    'recommendations' => $recommendations,
                    'top_3_recommendations' => $response['top_3_recommendations'] ?? [],
                    'best_match' => $response['best_match'] ?? null,
                    'average_match' => $response['average_match'] ?? 0
                ];
            } else {
                return [
                    'success' => false,
                    'message' => $response['error'] ?? 'ML API returned error',
                    'recommendations' => []
                ];
            }
            
        } catch (Exception $e) {
            error_log('Error getting job recommendations: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Service error: ' . $e->getMessage(),
                'recommendations' => []
            ];
        }
    }
    
    /**
     * Calculate skill match between specific jobseeker and job
     */
    public function calculateJobseekerJobMatch($jobseeker_id, $job_id) 
    {
        try {
            // Get jobseeker skills
            require_once __DIR__ . '/../models/Jobseeker.php';
            $jobseekerModel = new Jobseeker();
            $jobseekerSkills = $jobseekerModel->getSkillsArray($jobseeker_id);
            
            // Get job skills
            require_once __DIR__ . '/../models/JobPost.php';
            $jobPostModel = new JobPost();
            $jobSkills = $jobPostModel->getJobSkillsArray($job_id);
            
            if (empty($jobseekerSkills) || empty($jobSkills)) {
                return [
                    'success' => false,
                    'message' => 'Missing skills data',
                    'match_percentage' => 0
                ];
            }
            
            // Send to ML API
            $requestData = [
                'jobseeker_skills' => $jobseekerSkills,
                'job_requirements' => $jobSkills
            ];
            
            $response = $this->makeRequest('POST', '/match_skills', $requestData);
            
            if ($response && isset($response['success']) && $response['success']) {
                return [
                    'success' => true,
                    'jobseeker_id' => $jobseeker_id,
                    'job_id' => $job_id,
                    'jobseeker_skills' => $jobseekerSkills,
                    'job_requirements' => $jobSkills,
                    'match_percentage' => $response['match_percentage'] ?? 0,
                    'matched_skills' => $response['matched_skills'] ?? [],
                    'missing_skills' => $response['missing_skills'] ?? [],
                    'similarity_score' => $response['similarity_score'] ?? 0
                ];
            } else {
                return [
                    'success' => false,
                    'message' => $response['error'] ?? 'ML API error',
                    'match_percentage' => 0
                ];
            }
            
        } catch (Exception $e) {
            error_log('Error calculating job match: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Service error: ' . $e->getMessage(),
                'match_percentage' => 0
            ];
        }
    }
    
    /**
     * Get skill analysis for a jobseeker
     */
    public function getJobseekerSkillAnalysis($jobseeker_id) 
    {
        try {
            require_once __DIR__ . '/../models/Jobseeker.php';
            $jobseekerModel = new Jobseeker();
            $jobseekerSkills = $jobseekerModel->getSkillsArray($jobseeker_id);
            
            if (empty($jobseekerSkills)) {
                return [
                    'success' => false,
                    'message' => 'No skills found',
                    'analysis' => []
                ];
            }
            
            // Get all job skills to find market demand
            require_once __DIR__ . '/../models/JobPost.php';
            $jobPostModel = new JobPost();
            $allJobSkills = $jobPostModel->getAllJobSkills(); // You'll need to implement this
            
            // Count skill demand
            $skillDemand = [];
            foreach ($allJobSkills as $skill) {
                $skillName = strtolower(trim($skill['skill_name']));
                $skillDemand[$skillName] = ($skillDemand[$skillName] ?? 0) + 1;
            }
            
            // Analyze jobseeker skills
            $skillAnalysis = [];
            foreach ($jobseekerSkills as $skill) {
                $skillAnalysis[] = [
                    'skill' => $skill,
                    'market_demand' => $skillDemand[$skill] ?? 0,
                    'demand_level' => $this->getSkillDemandLevel($skillDemand[$skill] ?? 0)
                ];
            }
            
            // Sort by market demand
            usort($skillAnalysis, function($a, $b) {
                return $b['market_demand'] - $a['market_demand'];
            });
            
            return [
                'success' => true,
                'jobseeker_id' => $jobseeker_id,
                'total_skills' => count($jobseekerSkills),
                'skill_analysis' => $skillAnalysis,
                'top_skills' => array_slice($skillAnalysis, 0, 5)
            ];
            
        } catch (Exception $e) {
            error_log('Error in skill analysis: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Analysis error: ' . $e->getMessage(),
                'analysis' => []
            ];
        }
    }
    
    /**
     * Determine skill demand level
     */
    private function getSkillDemandLevel($count) 
    {
        if ($count >= 10) return 'High';
        if ($count >= 5) return 'Medium'; 
        if ($count >= 1) return 'Low';
        return 'None';
    }
    
    /**
     * Make HTTP request to Python API
     */
    private function makeRequest($method, $endpoint, $data = null) 
    {
        $url = $this->pythonApiUrl . $endpoint;
        
        $ch = curl_init();
        
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Accept: application/json'
            ]
        ]);
        
        if ($method === 'POST' && $data !== null) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        
        curl_close($ch);
        
        if ($error) {
            throw new Exception('cURL error: ' . $error);
        }
        
        if ($httpCode !== 200) {
            throw new Exception('HTTP error: ' . $httpCode . ' - ' . $response);
        }
        
        $decoded = json_decode($response, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('JSON decode error: ' . json_last_error_msg());
        }
        
        return $decoded;
    }
}