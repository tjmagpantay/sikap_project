<?php
require_once __DIR__ . '/../models/JobPost.php';
require_once __DIR__ . '/../models/Jobseeker.php';
require_once __DIR__ . '/../services/JobRecommendationService.php';

class NLPController
{
    private $jobPostModel;
    private $jobseekerModel;
    private $recommendationService;

    public function __construct()
    {
        $this->jobPostModel = new JobPost();
        $this->jobseekerModel = new Jobseeker();
        $this->recommendationService = new JobRecommendationService();
    }

    public function collectTrainingData()
    {
        // Check if user is logged in as admin
        if (!isset($_SESSION['user_id'])) {
            echo "<h1>Please login to access training system</h1>";
            echo "<p><a href='?page=login-jobseeker'>Login</a></p>";
            return;
        }

        echo "<!DOCTYPE html>";
        echo "<html><head>";
        echo "<title>NLP</title>";
        echo "<style>";
        echo "body { font-family: Arial, sans-serif; margin: 20px; }";
        echo ".success { background: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 10px; border-radius: 5px; margin: 10px 0; }";
        echo ".error { background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 10px; border-radius: 5px; margin: 10px 0; }";
        echo ".info { background: #d1ecf1; border: 1px solid #b8daff; color: #0c5460; padding: 10px; border-radius: 5px; margin: 10px 0; }";
        echo ".button { background: #007cba; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; text-decoration: none; display: inline-block; }";
        echo ".button:hover { background: #005a87; }";
        echo "table { border-collapse: collapse; width: 100%; margin: 10px 0; }";
        echo "th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }";
        echo "th { background-color: #f2f2f2; }";
        echo "</style>";
        echo "</head><body>";

        echo "<h1>🤖 ML Training System - TF-IDF Vocabulary Builder</h1>";
        echo "<hr>";

        // Step 1: Collect all job data
        echo "<h2>Step 1: Collecting Job Data</h2>";
        $allJobs = $this->getAllJobsWithSkills();
        
        $trainingJobs = [];
        $skillFrequency = [];
        $jobSkillMatrix = [];

        foreach ($allJobs as $job) {
            $jobSkills = $this->jobPostModel->getJobSkillsArray($job['job_id']);
            
            if (!empty($jobSkills)) {
                $cleanedJob = [
                    'job_id' => (int)$job['job_id'],
                    'job_title' => $job['job_title'],
                    'company_name' => $job['company_name'] ?? 'Unknown',
                    'job_type' => $job['job_type'] ?? '',
                    'location' => $job['location'] ?? '',
                    'skills' => $jobSkills,
                    'job_summary' => $job['job_summary'] ?? '',
                    'posted_date' => $job['created_at'] ?? null
                ];
                
                $trainingJobs[] = $cleanedJob;
                
                // Count skill frequency
                foreach ($jobSkills as $skill) {
                    $skillFrequency[$skill] = ($skillFrequency[$skill] ?? 0) + 1;
                }
                
                // Build skill co-occurrence matrix
                for ($i = 0; $i < count($jobSkills); $i++) {
                    for ($j = $i + 1; $j < count($jobSkills); $j++) {
                        $skill1 = $jobSkills[$i];
                        $skill2 = $jobSkills[$j];
                        
                        $key = $skill1 < $skill2 ? "$skill1|$skill2" : "$skill2|$skill1";
                        $jobSkillMatrix[$key] = ($jobSkillMatrix[$key] ?? 0) + 1;
                    }
                }
            }
        }

        echo "<div class='success'>";
        echo "<p>Jobs collected: " . count($trainingJobs) . "</p>";
        echo "<p>Unique skills found: " . count($skillFrequency) . "</p>";
        echo "<p>Skill relationships discovered: " . count($jobSkillMatrix) . "</p>";
        echo "</div>";

        // Step 2: Collect jobseeker data
        echo "<h2>👥 Step 2: Collecting Jobseeker Data</h2>";
        $allJobseekers = $this->getAllJobseekerData();
        echo "<div class='success'>";
        echo "<p>Jobseekers with skills: " . count($allJobseekers) . "</p>";
        echo "</div>";

        // Step 3: Show skill analysis
        echo "<h2>📈 Step 3: Skill Analysis</h2>";
        echo "<div class='info'>";
        echo "<h3>Top 10 Most Demanded Skills:</h3>";
        arsort($skillFrequency);
        $topSkills = array_slice($skillFrequency, 0, 10, true);
        echo "<table>";
        echo "<tr><th>Skill</th><th>Jobs Requiring This Skill</th><th>Demand Level</th></tr>";
        foreach ($topSkills as $skill => $count) {
            $demandLevel = $count >= 10 ? 'High' : ($count >= 5 ? 'Medium' : 'Low');
            $color = $count >= 10 ? '#28a745' : ($count >= 5 ? '#ffc107' : '#dc3545');
            echo "<tr><td>{$skill}</td><td>{$count}</td><td style='color: {$color}; font-weight: bold;'>{$demandLevel}</td></tr>";
        }
        echo "</table>";
        echo "</div>";

        // Step 4: Create training dataset
        echo "<h2>Step 4: Creating Training Dataset</h2>";
        $trainingData = [
            'jobs' => $trainingJobs,
            'jobseekers' => $allJobseekers,
            'skill_frequency' => $skillFrequency,
            'skill_cooccurrence' => $jobSkillMatrix,
            'training_metadata' => [
                'total_jobs' => count($trainingJobs),
                'total_jobseekers' => count($allJobseekers),
                'total_skills' => count($skillFrequency),
                'collection_date' => date('Y-m-d H:i:s'),
                'data_version' => '1.0'
            ]
        ];

        echo "<div class='success'>";
        echo "<p>Training dataset created successfully</p>";
        echo "</div>";

        // Step 5: Train the model
        echo "<h2>Step 5: Training TF-IDF Model</h2>";
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['train_model'])) {
            echo "<div class='info'>";
            echo "<p>Training in progress... Please wait.</p>";
            echo "</div>";
            
            $result = $this->trainMLModel($trainingData);
            
            if ($result['success']) {
                echo "<div class='success'>";
                echo "<h3>Model training completed successfully!</h3>";
                echo "<h4>Training Results:</h4>";
                echo "<ul>";
                echo "<li><strong>Training Time:</strong> {$result['training_time']}s</li>";
                echo "<li><strong>Skills Processed:</strong> {$result['total_skills']}</li>";
                echo "<li><strong>Relationships Found:</strong> {$result['relationships_discovered']}</li>";
                echo "<li><strong>Estimated Accuracy:</strong> {$result['accuracy']}%</li>";
                echo "<li><strong>Model Type:</strong> TF-IDF + Enhanced Synonyms</li>";
                echo "</ul>";
                echo "</div>";
                
                echo "<div class='info'>";
                echo "<h3>Next Steps:</h3>";
                echo "<p>Your model has been trained! Now you can test it:</p>";
                echo "<a href='?page=test-ml' class='button'>🧪 Test Trained Model</a>";
                echo "<a href='?page=test-comparison' class='button'>Compare Before/After</a>";
                echo "</div>";
                
            } else {
                echo "<div class='error'>";
                echo "<h3>Training failed</h3>";
                echo "<p>{$result['message']}</p>";
                echo "<p><strong>Troubleshooting:</strong></p>";
                echo "<ul>";
                echo "<li>Make sure your Python API is running: <code>python app.py</code></li>";
                echo "<li>Check if the Python server is accessible at: http://127.0.0.1:5000</li>";
                echo "<li>Verify all Python dependencies are installed</li>";
                echo "</ul>";
                echo "</div>";
            }
        } else {
            // Show training form
            echo "<div class='info'>";
            echo "<h3>Ready to Train Model</h3>";
            echo "<p>This will train a TF-IDF model using your job and jobseeker data to improve skill matching accuracy.</p>";
            echo "<table>";
            echo "<tr><th>Data Type</th><th>Count</th><th>Description</th></tr>";
            echo "<tr><td>Jobs</td><td>" . count($trainingJobs) . "</td><td>Job postings with skills</td></tr>";
            echo "<tr><td>Jobseekers</td><td>" . count($allJobseekers) . "</td><td>Jobseekers with skill profiles</td></tr>";
            echo "<tr><td>Unique Skills</td><td>" . count($skillFrequency) . "</td><td>Distinct skills in your system</td></tr>";
            echo "<tr><td>Skill Relationships</td><td>" . count($jobSkillMatrix) . "</td><td>Co-occurring skill pairs</td></tr>";
            echo "</table>";
            
            echo "<form method='POST'>";
            echo "<button type='submit' name='train_model' class='button' style='font-size: 18px; padding: 15px 30px;'>Start TF-IDF Training</button>";
            echo "</form>";
            echo "</div>";
        }

        echo "<hr>";
        echo "<p><a href='?page=test-ml'>← Back to ML Test</a></p>";
        echo "</body></html>";
    }

    private function getAllJobsWithSkills()
    {
        try {
            // Get all active jobs
            $sql = "SELECT j.job_id, j.job_title, j.company_name, j.job_type, j.location, j.job_summary, j.created_at 
                    FROM job_posts j 
                    WHERE j.status = 'active'
                    ORDER BY j.created_at DESC";
            
            $stmt = $this->jobPostModel->getPdo()->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (Exception $e) {
            error_log('Error getting jobs: ' . $e->getMessage());
            return [];
        }
    }

    private function getAllJobseekerData()
    {
        try {
            // Get all jobseekers with skills
            $sql = "SELECT DISTINCT j.jobseeker_id, j.first_name, j.last_name 
                    FROM jobseekers j 
                    INNER JOIN jobseeker_skills js ON j.jobseeker_id = js.jobseeker_id
                    WHERE j.first_name IS NOT NULL AND j.last_name IS NOT NULL";
            
            $stmt = $this->jobseekerModel->getPdo()->prepare($sql);
            $stmt->execute();
            $jobseekers = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            $jobseekerData = [];
            foreach ($jobseekers as $jobseeker) {
                $skills = $this->jobseekerModel->getSkillsArray($jobseeker['jobseeker_id']);
                
                if (!empty($skills)) {
                    $jobseekerData[] = [
                        'jobseeker_id' => (int)$jobseeker['jobseeker_id'],
                        'name' => trim($jobseeker['first_name'] . ' ' . $jobseeker['last_name']),
                        'skills' => $skills
                    ];
                }
            }
            
            return $jobseekerData;
            
        } catch (Exception $e) {
            error_log('Error getting jobseeker data: ' . $e->getMessage());
            return [];
        }
    }

    private function trainMLModel($trainingData)
    {
        try {
            $response = $this->makeRequest('POST', '/train_model', $trainingData);
            
            if ($response && isset($response['success']) && $response['success']) {
                return [
                    'success' => true,
                    'training_time' => $response['stats']['training_time'] ?? 'N/A',
                    'total_skills' => $response['stats']['total_skills'] ?? 0,
                    'relationships_discovered' => $response['stats']['relationships_discovered'] ?? 0,
                    'accuracy' => $response['stats']['estimated_accuracy'] ?? 'N/A',
                    'model_path' => $response['stats']['model_path'] ?? ''
                ];
            } else {
                return [
                    'success' => false,
                    'message' => $response['error'] ?? 'Unknown training error'
                ];
            }
            
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Training request failed: ' . $e->getMessage()
            ];
        }
    }

    private function makeRequest($method, $endpoint, $data = null)
    {
        $url = 'http://127.0.0.1:5000' . $endpoint;
        
        $ch = curl_init();
        
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 120, // Longer timeout for training
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
        
        return json_decode($response, true);
    }
}
