from flask import Flask, request, jsonify
from flask_cors import CORS
import json
import os
import logging
from pathlib import Path
import sys

# Add current directory to Python path
sys.path.append(os.path.dirname(os.path.abspath(__file__)))

from config.settings import API_HOST, API_PORT, DEBUG, UPLOAD_FOLDER
from models.recommender import JobRecommender
from parsers.resume_parser import ResumeParser
from utils.skill_matcher import SkillMatcher
from services.production_recommendation_service import ProductionRecommendationService

# Configure logging - reduce verbosity
logging.basicConfig(level=logging.WARNING)
logger = logging.getLogger(__name__)

app = Flask(__name__)
CORS(app)  # Enable CORS for PHP integration

# Initialize components
recommender = JobRecommender()
resume_parser = ResumeParser()
skill_matcher = SkillMatcher()
production_service = ProductionRecommendationService()

# Ensure upload directory exists
os.makedirs(UPLOAD_FOLDER, exist_ok=True)

@app.route('/', methods=['GET'])
def home():
    """Home endpoint with API information"""
    return jsonify({
        'message': 'Job Recommendation System API',
        'status': 'running',
        'version': '0.2.0',  # Updated version
        'available_tests': {
            'GET /test_basic_match': 'Test basic skill matching',
            'GET /test_enhanced_matching': 'Test enhanced semantic skill matching (NEW!)',
            'POST /test_job_recommendation': 'Test job recommendations with sample data',
            'GET /health': 'Health check'
        },
        'improvements': [
            'Semantic skill matching (coding = programming = technical skills)',
            'Skill clustering and synonyms',
            'Fuzzy string matching for similar terms',
            'Confidence scoring for matches',
            'Enhanced accuracy for real-world skill variations'
        ]
    })

@app.route('/health', methods=['GET'])
def health_check():
    """Health check endpoint"""
    return jsonify({
        'status': 'healthy',
        'service': 'job-recommendation-system',
        'components': {
            'recommender': 'active',
            'resume_parser': 'active', 
            'skill_matcher': 'active'
        }
    })

@app.route('/test_basic_match', methods=['GET'])
def test_basic_match():
    """Test basic skill matching functionality"""
    try:
        # Sample jobseeker skills
        jobseeker_skills = ['python', 'javascript', 'react', 'sql', 'git', 'html', 'css']
        
        # Sample job requirements  
        job_requirements = ['python', 'django', 'sql', 'aws', 'docker', 'postgresql']
        
        print(f"\n{'='*50}")
        print("TESTING SKILL MATCHING")
        print(f"{'='*50}")
        print(f"Jobseeker Skills: {jobseeker_skills}")
        print(f"Job Requirements: {job_requirements}")
        
        # Calculate similarity
        similarity_score = skill_matcher.calculate_similarity(jobseeker_skills, job_requirements)
        
        # Get matched skills
        matched_skills = skill_matcher.get_matched_skills(jobseeker_skills, job_requirements)
        
        # Get missing skills
        missing_skills = skill_matcher.get_missing_skills(jobseeker_skills, job_requirements)
        
        match_percentage = round(similarity_score * 100, 2)
        
        print(f"\nRESULTS:")
        print(f"Similarity Score: {similarity_score:.4f}")
        print(f"Match Percentage: {match_percentage}%")
        print(f"Matched Skills: {matched_skills}")
        print(f"Missing Skills: {missing_skills}")
        print(f"{'='*50}\n")
        
        return jsonify({
            'success': True,
            'test_type': 'basic_skill_matching',
            'input': {
                'jobseeker_skills': jobseeker_skills,
                'job_requirements': job_requirements
            },
            'results': {
                'similarity_score': similarity_score,
                'match_percentage': match_percentage,
                'matched_skills': matched_skills,
                'missing_skills': missing_skills,
                'total_jobseeker_skills': len(jobseeker_skills),
                'total_job_requirements': len(job_requirements),
                'matched_count': len(matched_skills)
            }
        })
        
    except Exception as e:
        print(f"Error in basic match test: {str(e)}")
        return jsonify({'error': str(e)}), 500

@app.route('/test_job_recommendation', methods=['POST', 'GET'])
def test_job_recommendation():
    """Test complete job recommendation system"""
    try:
        # Sample jobseeker skills
        jobseeker_skills = ['python', 'javascript', 'react', 'sql', 'git']
        
        # Sample job postings with different skill requirements
        sample_jobs = [
            {
                'job_id': 1,
                'job_title': 'Full Stack Developer',
                'company_name': 'TechCorp',
                'requirements': ['python', 'javascript', 'react', 'node.js', 'sql'],
                'description': 'Looking for a full stack developer with Python and React experience'
            },
            {
                'job_id': 2,
                'job_title': 'Data Scientist',
                'company_name': 'DataInc',
                'requirements': ['python', 'machine learning', 'pandas', 'sql', 'statistics'],
                'description': 'Data scientist role requiring Python and ML expertise'
            },
            {
                'job_id': 3,
                'job_title': 'Backend Developer',
                'company_name': 'ServerSoft',
                'requirements': ['java', 'spring boot', 'sql', 'aws', 'docker'],
                'description': 'Backend developer position with Java and cloud experience'
            },
            {
                'job_id': 4,
                'job_title': 'Frontend Developer',
                'company_name': 'WebDesign',
                'requirements': ['javascript', 'react', 'html', 'css', 'typescript'],
                'description': 'Frontend developer role focused on React development'
            },
            {
                'job_id': 5,
                'job_title': 'DevOps Engineer',
                'company_name': 'CloudOps',
                'requirements': ['docker', 'kubernetes', 'aws', 'linux', 'jenkins'],
                'description': 'DevOps position requiring cloud and automation skills'
            }
        ]
        
        print(f"\n{'='*60}")
        print("TESTING JOB RECOMMENDATION SYSTEM")
        print(f"{'='*60}")
        print(f"Jobseeker Skills: {jobseeker_skills}")
        print(f"Available Jobs: {len(sample_jobs)}")
        
        # Calculate match for each job
        job_matches = []
        for job in sample_jobs:
            similarity_score = skill_matcher.calculate_similarity(
                jobseeker_skills, 
                job['requirements']
            )
            
            matched_skills = skill_matcher.get_matched_skills(
                jobseeker_skills, 
                job['requirements']
            )
            
            missing_skills = skill_matcher.get_missing_skills(
                jobseeker_skills,
                job['requirements']
            )
            
            match_percentage = round(similarity_score * 100, 2)
            
            job_match = {
                'job_id': job['job_id'],
                'job_title': job['job_title'],
                'company_name': job['company_name'],
                'description': job['description'],
                'requirements': job['requirements'],
                'similarity_score': similarity_score,
                'match_percentage': match_percentage,
                'matched_skills': matched_skills,
                'missing_skills': missing_skills,
                'matched_count': len(matched_skills)
            }
            
            job_matches.append(job_match)
            
            print(f"\n{job['job_title']} at {job['company_name']}:")
            print(f"  Requirements: {job['requirements']}")
            print(f"  Match: {match_percentage}% ({len(matched_skills)}/{len(job['requirements'])} skills)")
            print(f"  Matched: {matched_skills}")
            print(f"  Missing: {missing_skills}")
        
        # Sort by match percentage (highest first)
        job_matches.sort(key=lambda x: x['match_percentage'], reverse=True)
        
        print(f"\nRANKED RECOMMENDATIONS:")
        for i, job in enumerate(job_matches[:3], 1):
            print(f"{i}. {job['job_title']} - {job['match_percentage']}% match")
        
        print(f"{'='*60}\n")
        
        return jsonify({
            'success': True,
            'test_type': 'job_recommendation',
            'input': {
                'jobseeker_skills': jobseeker_skills,
                'total_jobs_analyzed': len(sample_jobs)
            },
            'results': {
                'all_job_matches': job_matches,
                'top_recommendations': job_matches[:3],
                'best_match': job_matches[0] if job_matches else None,
                'average_match_percentage': round(sum(job['match_percentage'] for job in job_matches) / len(job_matches), 2) if job_matches else 0
            }
        })
        
    except Exception as e:
        print(f"Error in job recommendation test: {str(e)}")
        return jsonify({'error': str(e)}), 500

@app.route('/match_skills', methods=['POST'])
def match_skills():
    """Calculate skill match between jobseeker and job"""
    try:
        data = request.get_json()
        
        if not data:
            return jsonify({'error': 'No JSON data provided'}), 400
        
        jobseeker_skills = data.get('jobseeker_skills', [])
        job_requirements = data.get('job_requirements', [])
        
        if not jobseeker_skills or not job_requirements:
            return jsonify({'error': 'Missing skills or requirements'}), 400
        
        # Calculate similarity
        similarity_score = skill_matcher.calculate_similarity(
            jobseeker_skills, 
            job_requirements
        )
        
        match_percentage = round(similarity_score * 100, 2)
        
        # Get detailed match analysis
        matched_skills = skill_matcher.get_matched_skills(
            jobseeker_skills, 
            job_requirements
        )
        
        missing_skills = skill_matcher.get_missing_skills(
            jobseeker_skills,
            job_requirements
        )
        
        return jsonify({
            'success': True,
            'match_percentage': match_percentage,
            'matched_skills': matched_skills,
            'missing_skills': missing_skills[:5],  # Limit to top 5
            'total_jobseeker_skills': len(jobseeker_skills),
            'total_job_requirements': len(job_requirements),
            'matched_count': len(matched_skills),
            'similarity_score': similarity_score
        })
        
    except Exception as e:
        logger.error(f"Error matching skills: {str(e)}")
        return jsonify({'error': str(e)}), 500

@app.route('/recommend_jobs', methods=['POST'])
def recommend_jobs():
    """Get job recommendations for a jobseeker"""
    try:
        data = request.get_json()
        
        jobseeker_id = data.get('jobseeker_id')
        jobseeker_skills = data.get('jobseeker_skills', [])
        available_jobs = data.get('available_jobs', [])
        
        if not jobseeker_skills or not available_jobs:
            return jsonify({'error': 'Missing skills or job data'}), 400
        
        # Get recommendations
        recommendations = recommender.get_recommendations(
            jobseeker_skills,
            available_jobs
        )
        
        return jsonify({
            'success': True,
            'jobseeker_id': jobseeker_id,
            'recommendations': recommendations,
            'total_jobs_analyzed': len(available_jobs),
            'recommendations_count': len(recommendations)
        })
        
    except Exception as e:
        logger.error(f"Error getting recommendations: {str(e)}")
        return jsonify({'error': str(e)}), 500

@app.route('/train_model', methods=['POST'])
def train_model():
    """Train the model with job data from database"""
    try:
        data = request.get_json()
        
        if not data or 'jobs' not in data:
            return jsonify({'error': 'No job data provided'}), 400
        
        jobs = data['jobs']
        print(f"🎯 Training model with {len(jobs)} jobs...")
        
        production_service.initialize_with_job_data(jobs)
        
        stats = production_service.get_model_stats()
        
        return jsonify({
            'success': True,
            'message': 'Model trained successfully',
            'stats': stats
        })
        
    except Exception as e:
        return jsonify({'error': str(e)}), 500

@app.route('/test_with_real_data', methods=['POST', 'GET'])
def test_with_real_data():
    """Test with realistic jobseeker and job data structure using production service"""
    try:
        # Handle both GET and POST requests
        if request.method == 'GET':
            data = None  # Will use sample data
        else:
            data = request.get_json()
        
        # Expected format from PHP:
        # {
        #   "jobseeker": {
        #     "id": 1,
        #     "skills": ["python", "javascript", "sql"]
        #   },
        #   "jobs": [
        #     {
        #       "job_id": 1,
        #       "job_title": "Developer",
        #       "company_name": "TechCorp", 
        #       "skills": ["python", "react", "sql"]
        #     }
        #   ]
        # }
        
        if not data:
            # Use sample data if no data provided (for GET requests)
            data = {
                "jobseeker": {
                    "id": 1,
                    "name": "John Doe",
                    "skills": ["php", "mysql", "javascript", "html", "css", "laravel"]
                },
                "jobs": [
                    {
                        "job_id": 101,
                        "job_title": "PHP Developer",
                        "company_name": "WebCorp",
                        "location": "Manila",
                        "skills": ["php", "mysql", "laravel", "vue.js", "git"]
                    },
                    {
                        "job_id": 102,
                        "job_title": "Full Stack Developer", 
                        "company_name": "TechStartup",
                        "location": "Cebu",
                        "skills": ["javascript", "react", "node.js", "mongodb", "aws"]
                    },
                    {
                        "job_id": 103,
                        "job_title": "Frontend Developer",
                        "company_name": "DesignCo",
                        "location": "Davao", 
                        "skills": ["html", "css", "javascript", "react", "figma"]
                    }
                ]
            }
        
        jobseeker = data.get('jobseeker', {})
        jobs = data.get('jobs', [])
        
        jobseeker_skills = jobseeker.get('skills', [])
        
        if not jobseeker_skills or not jobs:
            return jsonify({'error': 'Missing jobseeker skills or jobs data'}), 400
        
        print(f"\n{'='*60}")
        print("TESTING WITH REAL DATA STRUCTURE")
        print(f"{'='*60}")
        print(f"Jobseeker: {jobseeker.get('name', 'Unknown')} (ID: {jobseeker.get('id', 'N/A')})")
        print(f"Skills: {jobseeker_skills}")
        print(f"Jobs to analyze: {len(jobs)}")
        
        # Calculate matches for each job
        job_recommendations = []
        
        for job in jobs:
            job_skills = job.get('skills', [])
            
            if not job_skills:
                continue
            
            # Calculate match
            similarity_score = skill_matcher.calculate_similarity(jobseeker_skills, job_skills)
            matched_skills = skill_matcher.get_matched_skills(jobseeker_skills, job_skills)
            missing_skills = skill_matcher.get_missing_skills(jobseeker_skills, job_skills)
            
            match_percentage = round(similarity_score * 100, 2)
            
            recommendation = {
                'job_id': job.get('job_id'),
                'job_title': job.get('job_title'),
                'company_name': job.get('company_name'),
                'location': job.get('location', ''),
                'required_skills': job_skills,
                'match_percentage': match_percentage,
                'matched_skills': matched_skills,
                'missing_skills': missing_skills,
                'matched_count': len(matched_skills),
                'total_requirements': len(job_skills),
                'similarity_score': similarity_score
            }
            
            job_recommendations.append(recommendation)
            
            print(f"\n{job['job_title']} at {job['company_name']}:")
            print(f"  Required: {job_skills}")
            print(f"  Match: {match_percentage}% ({len(matched_skills)}/{len(job_skills)} skills)")
            print(f"  Matched: {[skill['skill'] if isinstance(skill, dict) else skill for skill in matched_skills]}")
            print(f"  Missing: {missing_skills}")
        
        # Sort by match percentage
        job_recommendations.sort(key=lambda x: x['match_percentage'], reverse=True)
        
        print(f"\nRANKED RECOMMENDATIONS:")
        for i, job in enumerate(job_recommendations[:3], 1):
            print(f"{i}. {job['job_title']} - {job['match_percentage']}% match")
        
        print(f"{'='*60}\n")
        
        return jsonify({
            'success': True,
            'jobseeker': jobseeker,
            'total_jobs_analyzed': len(jobs),
            'recommendations': job_recommendations,
            'top_3_recommendations': job_recommendations[:3],
            'best_match': job_recommendations[0] if job_recommendations else None,
            'average_match': round(sum(job['match_percentage'] for job in job_recommendations) / len(job_recommendations), 2) if job_recommendations else 0
        })
        
    except Exception as e:
        print(f"Error in real data test: {str(e)}")
        return jsonify({'error': str(e)}), 500

@app.route('/test_enhanced_matching', methods=['GET'])
def test_enhanced_matching():
    """Test enhanced semantic skill matching"""
    try:
        print(f"\n{'='*60}")
        print("TESTING ENHANCED SEMANTIC SKILL MATCHING")
        print(f"{'='*60}")
        
        # Test cases to show improvement
        test_cases = [
            {
                'name': 'Technical Skills Matching',
                'jobseeker_skills': ['coding', 'programming', 'web development'],
                'job_requirements': ['technical skills', 'software development', 'frontend development']
            },
            {
                'name': 'Framework Synonyms',
                'jobseeker_skills': ['react', 'javascript', 'html'],
                'job_requirements': ['reactjs', 'js', 'html5', 'frontend framework']
            },
            {
                'name': 'Database Skills',
                'jobseeker_skills': ['mysql', 'database management'],
                'job_requirements': ['sql', 'relational database', 'data management']
            },
            {
                'name': 'Cloud Technologies',
                'jobseeker_skills': ['aws', 'cloud computing'],
                'job_requirements': ['amazon web services', 'cloud platforms', 'devops']
            }
        ]
        
        results = []
        
        for test_case in test_cases:
            print(f"\n{test_case['name']}:")
            print(f"Jobseeker Skills: {test_case['jobseeker_skills']}")
            print(f"Job Requirements: {test_case['job_requirements']}")
            
            # Enhanced matching
            enhanced_similarity, match_details = skill_matcher.enhanced_matcher.calculate_enhanced_similarity(
                test_case['jobseeker_skills'], 
                test_case['job_requirements']
            )
            
            # Get matched skills with details
            matched_skills = skill_matcher.get_matched_skills(
                test_case['jobseeker_skills'], 
                test_case['job_requirements']
            )
            
            enhanced_percentage = round(enhanced_similarity * 100, 2)
            
            print(f"Enhanced Match: {enhanced_percentage}%")
            print(f"Matched Skills: {len(matched_skills)} matches")
            
            results.append({
                'test_case': test_case['name'],
                'jobseeker_skills': test_case['jobseeker_skills'],
                'job_requirements': test_case['job_requirements'],
                'enhanced_match_percentage': enhanced_percentage,
                'matched_skills': matched_skills,
                'match_count': len(matched_skills)
            })
        
        print(f"\n{'='*60}")
        print("ENHANCEMENT SUMMARY:")
        avg_match = sum(result['enhanced_match_percentage'] for result in results) / len(results)
        print(f"Average Match Percentage: {avg_match:.2f}%")
        print(f"{'='*60}\n")
        
        return jsonify({
            'success': True,
            'test_type': 'enhanced_semantic_matching',
            'results': results,
            'summary': {
                'total_test_cases': len(results),
                'average_match_percentage': round(avg_match, 2),
                'total_matches': sum(result['match_count'] for result in results)
            }
        })
        
    except Exception as e:
        print(f"Error in enhanced matching test: {str(e)}")
        return jsonify({'error': str(e)}), 500

@app.errorhandler(404)
def not_found(error):
    return jsonify({
        'error': 'Endpoint not found',
        'available_endpoints': [
            'GET /',
            'GET /health', 
            'GET /test_basic_match',
            'POST /test_job_recommendation',
            'POST /match_skills',
            'POST /recommend_jobs'
        ]
    }), 404

@app.errorhandler(500)
def internal_error(error):
    return jsonify({'error': 'Internal server error'}), 500

if __name__ == '__main__':
    print(f"🚀 Job Recommendation API Server running on {API_HOST}:{API_PORT}")
    app.run(host=API_HOST, port=API_PORT, debug=DEBUG)