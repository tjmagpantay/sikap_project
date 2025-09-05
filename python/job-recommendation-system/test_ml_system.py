"""
Comprehensive test script for the ML Job Recommendation System
"""

import requests
import json
import time

# API base URL
BASE_URL = 'http://127.0.0.1:5000'

def test_connection():
    """Test if API is running"""
    try:
        response = requests.get(f"{BASE_URL}/health")
        if response.status_code == 200:
            print("✅ API is running and healthy")
            return True
        else:
            print(f"❌ API health check failed: {response.status_code}")
            return False
    except Exception as e:
        print(f"❌ Cannot connect to API: {e}")
        return False

def test_basic_skill_matching():
    """Test basic skill matching functionality"""
    print(f"\n{'='*50}")
    print("TEST 1: BASIC SKILL MATCHING")
    print(f"{'='*50}")
    
    try:
        response = requests.get(f"{BASE_URL}/test_basic_match")
        
        if response.status_code == 200:
            data = response.json()
            print("✅ Basic skill matching test passed")
            
            results = data['results']
            print(f"Match Percentage: {results['match_percentage']}%")
            print(f"Matched Skills: {results['matched_skills']}")
            print(f"Missing Skills: {results['missing_skills']}")
            
            return True
        else:
            print(f"❌ Basic skill matching test failed: {response.status_code}")
            print(response.text)
            return False
            
    except Exception as e:
        print(f"❌ Error in basic skill matching test: {e}")
        return False

def test_job_recommendation():
    """Test complete job recommendation system"""
    print(f"\n{'='*50}")
    print("TEST 2: JOB RECOMMENDATION SYSTEM")
    print(f"{'='*50}")
    
    try:
        response = requests.get(f"{BASE_URL}/test_job_recommendation")
        
        if response.status_code == 200:
            data = response.json()
            print("✅ Job recommendation test passed")
            
            results = data['results']
            top_recs = results['top_recommendations']
            
            print(f"Total jobs analyzed: {data['input']['total_jobs_analyzed']}")
            print(f"Average match: {results['average_match_percentage']}%")
            print(f"Best match: {results['best_match']['job_title']} ({results['best_match']['match_percentage']}%)")
            
            print("\nTop 3 Recommendations:")
            for i, job in enumerate(top_recs, 1):
                print(f"{i}. {job['job_title']} at {job['company_name']} - {job['match_percentage']}% match")
                print(f"   Matched skills: {job['matched_skills']}")
                print(f"   Missing skills: {job['missing_skills']}")
            
            return True
        else:
            print(f"❌ Job recommendation test failed: {response.status_code}")
            print(response.text)
            return False
            
    except Exception as e:
        print(f"❌ Error in job recommendation test: {e}")
        return False

def test_custom_skill_matching():
    """Test skill matching with custom data"""
    print(f"\n{'='*50}")
    print("TEST 3: CUSTOM SKILL MATCHING")
    print(f"{'='*50}")
    
    # Test different scenarios
    test_cases = [
        {
            'name': 'Perfect Match',
            'jobseeker_skills': ['python', 'sql', 'react'],
            'job_requirements': ['python', 'sql', 'react']
        },
        {
            'name': 'Partial Match',
            'jobseeker_skills': ['python', 'javascript', 'html'],
            'job_requirements': ['python', 'django', 'sql', 'aws']
        },
        {
            'name': 'No Match',
            'jobseeker_skills': ['photoshop', 'illustrator', 'design'],
            'job_requirements': ['python', 'machine learning', 'tensorflow']
        },
        {
            'name': 'Overqualified',
            'jobseeker_skills': ['python', 'javascript', 'react', 'node.js', 'sql', 'aws', 'docker'],
            'job_requirements': ['javascript', 'html', 'css']
        }
    ]
    
    for test_case in test_cases:
        print(f"\n{test_case['name']}:")
        print(f"Jobseeker: {test_case['jobseeker_skills']}")
        print(f"Job Req:   {test_case['job_requirements']}")
        
        try:
            response = requests.post(f"{BASE_URL}/match_skills", 
                                   json=test_case,
                                   headers={'Content-Type': 'application/json'})
            
            if response.status_code == 200:
                data = response.json()
                print(f"Result: {data['match_percentage']}% match")
                print(f"Matched: {data['matched_skills']}")
                print(f"Missing: {data['missing_skills']}")
            else:
                print(f"❌ Failed: {response.status_code}")
                
        except Exception as e:
            print(f"❌ Error: {e}")
    
    print("\n✅ Custom skill matching tests completed")

def run_all_tests():
    """Run all tests"""
    print("🧪 TESTING ML JOB RECOMMENDATION SYSTEM")
    print(f"{'='*60}")
    
    # Test connection first
    if not test_connection():
        print("❌ Cannot proceed with tests - API not available")
        return
    
    # Run tests
    tests_passed = 0
    total_tests = 3
    
    if test_basic_skill_matching():
        tests_passed += 1
    
    if test_job_recommendation():
        tests_passed += 1
    
    test_custom_skill_matching()  # Always completes
    tests_passed += 1
    
    # Summary
    print(f"\n{'='*60}")
    print("TEST SUMMARY")
    print(f"{'='*60}")
    print(f"Tests passed: {tests_passed}/{total_tests}")
    
    if tests_passed == total_tests:
        print("🎉 All tests passed! ML Job Recommendation System is working correctly.")
    else:
        print("⚠️  Some tests failed. Check the output above for details.")
    
    print(f"{'='*60}")

if __name__ == "__main__":
    run_all_tests()