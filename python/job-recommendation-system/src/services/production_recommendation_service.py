from utils.advanced_skill_matcher import AdvancedSkillMatcher
import logging
from typing import List, Dict
import time

class ProductionRecommendationService:
    def __init__(self):
        self.skill_matcher = AdvancedSkillMatcher()
        self.logger = logging.getLogger(__name__)
        self.is_trained = False
        
        # Try to load pre-trained model
        if self.skill_matcher.load_model():
            self.is_trained = True
            print("✅ Using pre-trained skill matching model")
        else:
            print("⚠️ No pre-trained model found. Need to train first.")
    
    def initialize_with_job_data(self, job_data: List[Dict]) -> None:
        """Initialize the service with job data for training"""
        if not self.is_trained:
            print("🚀 Training recommendation service...")
            start_time = time.time()
            
            self.skill_matcher.train_on_job_data(job_data)
            self.is_trained = True
            
            training_time = time.time() - start_time
            print(f"⏱️ Training completed in {training_time:.2f} seconds")
    
    def get_job_recommendations(self, jobseeker_skills: List[str], jobs: List[Dict], limit: int = 50) -> Dict:
        """Get job recommendations using production-ready matching"""
        
        if not self.is_trained:
            return {
                'success': False,
                'message': 'Service not trained yet',
                'recommendations': []
            }
        
        start_time = time.time()
        
        # Batch calculate recommendations for efficiency
        recommendations = self.skill_matcher.batch_calculate_recommendations(
            jobseeker_skills, jobs[:limit * 2]  # Process more to get better top results
        )
        
        # Limit final results
        top_recommendations = recommendations[:limit]
        
        processing_time = time.time() - start_time
        
        return {
            'success': True,
            'processing_time': round(processing_time, 3),
            'total_jobs_analyzed': len(jobs),
            'recommendations': top_recommendations,
            'top_3_recommendations': top_recommendations[:3],
            'best_match': top_recommendations[0] if top_recommendations else None,
            'average_match': round(
                sum(job['match_percentage'] for job in top_recommendations) / len(top_recommendations), 2
            ) if top_recommendations else 0
        }
    
    def calculate_single_match(self, jobseeker_skills: List[str], job_skills: List[str]) -> Dict:
        """Calculate match for a single job"""
        if not self.is_trained:
            return {'success': False, 'message': 'Service not trained'}
        
        result = self.skill_matcher.calculate_job_match(jobseeker_skills, job_skills)
        
        return {
            'success': True,
            'match_percentage': round(result['similarity_score'] * 100, 2),
            'matched_skills': result['matched_skills'],
            'missing_skills': result['missing_skills'],
            'similarity_score': result['similarity_score']
        }
    
    def get_skill_suggestions(self, skill: str, limit: int = 10) -> List[Dict]:
        """Get skill suggestions for auto-complete or skill discovery"""
        if not self.is_trained:
            return []
        
        similar_skills = self.skill_matcher.find_similar_skills(skill, top_k=limit)
        
        return [
            {
                'skill': skill_name,
                'similarity': round(similarity, 3),
                'confidence': 'high' if similarity > 0.8 else 'medium' if similarity > 0.6 else 'low'
            }
            for skill_name, similarity in similar_skills
        ]
    
    def update_with_new_jobs(self, new_jobs: List[Dict]) -> None:
        """Update the model with new job postings"""
        if self.is_trained:
            self.skill_matcher.update_model_with_new_data(new_jobs)
    
    def get_model_stats(self) -> Dict:
        """Get statistics about the trained model"""
        if not self.is_trained:
            return {'trained': False}
        
        return {
            'trained': True,
            'total_skills': len(self.skill_matcher.skill_list),
            'model_path': self.skill_matcher.model_path,
            'embeddings_shape': self.skill_matcher.embeddings_matrix.shape if hasattr(self.skill_matcher, 'embeddings_matrix') else None
        }