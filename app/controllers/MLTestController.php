<?php
require_once __DIR__ . '/../services/JobRecommendationService.php';
require_once __DIR__ . '/../models/Jobseeker.php';
require_once __DIR__ . '/../models/JobPost.php';

class MLTestController
{
    private $recommendationService;

    public function __construct()
    {
        $this->recommendationService = new JobRecommendationService();
    }

    public function testMLIntegration()
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            echo "<h1>Please login as a jobseeker to test ML integration</h1>";
            return;
        }

        // Get jobseeker ID
        $jobseekerModel = new Jobseeker();
        $jobseeker = $jobseekerModel->findByUserId($_SESSION['user_id']);

        if (!$jobseeker) {
            echo "<h1>Jobseeker profile not found</h1>";
            return;
        }

        $jobseeker_id = $jobseeker['jobseeker_id'];

        echo "<h1>ML Job Recommendation Test</h1>";
        echo "<hr>";

        // Test 1: Check API connection
        echo "<h2>Test 1: API Connection</h2>";
        if ($this->recommendationService->testConnection()) {
            echo "<p style='color: green;'>✅ Python API is connected and running</p>";
        } else {
            echo "<p style='color: red;'>❌ Python API is not available</p>";
            echo "<p>Make sure your Python server is running: <code>python app.py</code></p>";
            return;
        }

        // Test 2: Get jobseeker skills
        echo "<h2>Test 2: Jobseeker Skills</h2>";
        $jobseekerSkills = $jobseekerModel->getSkillsArray($jobseeker_id);
        echo "<p><strong>Jobseeker:</strong> {$jobseeker['first_name']} {$jobseeker['last_name']} (ID: {$jobseeker_id})</p>";
        echo "<p><strong>Skills:</strong> " . (empty($jobseekerSkills) ? "No skills found" : implode(', ', $jobseekerSkills)) . "</p>";

        if (empty($jobseekerSkills)) {
            echo "<p style='color: orange;'>⚠️ No skills found. Add some skills to your profile first.</p>";
            return;
        }

        // Test 3: Get job recommendations
        echo "<h2>Test 3: Job Recommendations</h2>";
        $recommendations = $this->recommendationService->getJobRecommendationsForJobseeker($jobseeker_id, 5);

        if ($recommendations['success']) {
            echo "<p style='color: green;'>✅ Recommendations generated successfully!</p>";
            echo "<p><strong>Total jobs analyzed:</strong> {$recommendations['total_jobs_analyzed']}</p>";
            echo "<p><strong>Average match:</strong> {$recommendations['average_match']}%</p>";

            if (!empty($recommendations['recommendations'])) {
                echo "<h3>Top Recommendations:</h3>";
                echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
                echo "<tr><th>Rank</th><th>Job Title</th><th>Company</th><th>Match %</th><th>Matched Skills</th><th>Missing Skills</th></tr>";

                foreach ($recommendations['recommendations'] as $index => $job) {
                    $rank = $index + 1;
                    $matchedSkills = [];
                    $missingSkills = $job['missing_skills'] ?? [];

                    // Extract skill names from matched skills
                    foreach ($job['matched_skills'] as $skill) {
                        if (is_array($skill) && isset($skill['skill'])) {
                            $matchedSkills[] = $skill['skill'];
                        } else {
                            $matchedSkills[] = $skill;
                        }
                    }

                    $matchedSkillsStr = implode(', ', array_slice($matchedSkills, 0, 3));
                    $missingSkillsStr = implode(', ', array_slice($missingSkills, 0, 3));

                    if (count($matchedSkills) > 3) $matchedSkillsStr .= "...";
                    if (count($missingSkills) > 3) $missingSkillsStr .= "...";

                    echo "<tr>";
                    echo "<td>{$rank}</td>";
                    echo "<td>{$job['job_title']}</td>";
                    echo "<td>{$job['company_name']}</td>";
                    echo "<td>{$job['match_percentage']}%</td>";
                    echo "<td>{$matchedSkillsStr}</td>";
                    echo "<td>{$missingSkillsStr}</td>";
                    echo "</tr>";
                }

                echo "</table>";
            } else {
                echo "<p>No job recommendations found.</p>";
            }
        } else {
            echo "<p style='color: red;'>❌ Error: {$recommendations['message']}</p>";
        }

        // Test 4: Skill analysis
        echo "<h2>Test 4: Skill Market Analysis</h2>";
        $skillAnalysis = $this->recommendationService->getJobseekerSkillAnalysis($jobseeker_id);

        if ($skillAnalysis['success']) {
            echo "<p style='color: green;'>✅ Skill analysis completed!</p>";
            echo "<p><strong>Total skills analyzed:</strong> {$skillAnalysis['total_skills']}</p>";

            if (!empty($skillAnalysis['skill_analysis'])) {
                echo "<h3>Your Skills Market Demand:</h3>";
                echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
                echo "<tr><th>Skill</th><th>Jobs Requiring This Skill</th><th>Demand Level</th></tr>";

                foreach ($skillAnalysis['top_skills'] as $skill) {
                    $demandColor = match ($skill['demand_level']) {
                        'High' => 'green',
                        'Medium' => 'orange',
                        'Low' => 'red',
                        default => 'gray'
                    };

                    echo "<tr>";
                    echo "<td>{$skill['skill']}</td>";
                    echo "<td>{$skill['market_demand']}</td>";
                    echo "<td style='color: {$demandColor};'><strong>{$skill['demand_level']}</strong></td>";
                    echo "</tr>";
                }

                echo "</table>";
            }
        } else {
            echo "<p style='color: red;'>❌ Skill analysis error: {$skillAnalysis['message']}</p>";
        }

        echo "<hr>";
        echo "<h2>✅ ML Integration Test Complete!</h2>";
        echo "<p><a href='?page=dashboard-jobseeker'>Back to Dashboard</a></p>";
    }
}
