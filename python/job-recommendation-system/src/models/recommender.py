from typing import List, Dict, Tuple
import logging
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.metrics.pairwise import cosine_similarity
import numpy as np
from utils.skill_matcher import SkillMatcher
from config.settings import TOP_RECOMMENDATIONS, SIMILARITY_THRESHOLD

logger = logging.getLogger(__name__)

class JobRecommender:
    def __init__(self):
        self.vectorizer = TfidfVectorizer()
        self.skill_matcher = SkillMatcher()

    def compute_similarity(self, jobseeker_skills, job_requirements):
        all_skills = jobseeker_skills + job_requirements
        tfidf_matrix = self.vectorizer.fit_transform(all_skills)
        similarity_matrix = cosine_similarity(tfidf_matrix)

        return similarity_matrix

    def recommend_jobs(self, jobseeker_skills, job_postings):
        job_requirements = [job['requirements'] for job in job_postings]
        similarity_matrix = self.compute_similarity(jobseeker_skills, job_requirements)

        recommendations = []
        for i, job in enumerate(job_postings):
            recommendations.append({
                'job_title': job['title'],
                'similarity_score': similarity_matrix[0][i]
            })

        recommendations.sort(key=lambda x: x['similarity_score'], reverse=True)
        return recommendations[:5]  # Return top 5 job recommendations
    
    def get_recommendations(self, jobseeker_skills: List[str], available_jobs: List[Dict]) -> List[Dict]:
        """Get job recommendations for a jobseeker based on skills"""
        try:
            if not jobseeker_skills or not available_jobs:
                return []
            
            recommendations = []
            
            for job in available_jobs:
                # Extract job requirements
                job_requirements = self._extract_job_requirements(job)
                
                if not job_requirements:
                    continue
                
                # Calculate similarity
                similarity_score = self.skill_matcher.calculate_similarity(
                    jobseeker_skills, job_requirements
                )
                
                # Only include jobs above threshold
                if similarity_score >= SIMILARITY_THRESHOLD:
                    # Get matched and missing skills
                    matched_skills = self.skill_matcher.get_matched_skills(
                        jobseeker_skills, job_requirements
                    )
                    missing_skills = self.skill_matcher.get_missing_skills(
                        jobseeker_skills, job_requirements
                    )
                    
                    recommendation = {
                        'job_id': job.get('job_id'),
                        'job_title': job.get('job_title', 'Unknown Title'),
                        'company_name': job.get('company_name', 'Unknown Company'),
                        'location': job.get('location', 'Not specified'),
                        'salary_range': job.get('salary_range'),
                        'job_type': job.get('job_type', 'Full-time'),
                        'match_percentage': round(similarity_score * 100, 2),
                        'matched_skills': matched_skills,
                        'missing_skills': missing_skills[:5],  # Limit to top 5
                        'total_requirements': len(job_requirements),
                        'match_category': self._categorize_match(similarity_score),
                        'recommendation_reason': self._generate_recommendation_reason(
                            similarity_score, matched_skills, missing_skills
                        )
                    }
                    
                    recommendations.append(recommendation)
            
            # Sort by similarity score (highest first)
            recommendations.sort(key=lambda x: x['match_percentage'], reverse=True)
            
            # Limit to top recommendations
            return recommendations[:TOP_RECOMMENDATIONS]
            
        except Exception as e:
            logger.error(f"Error generating recommendations: {str(e)}")
            return []
    
    def _extract_job_requirements(self, job: Dict) -> List[str]:
        """Extract skill requirements from job posting"""
        requirements = []
        
        # Check various fields that might contain skills
        fields_to_check = [
            'required_skills',
            'preferred_skills', 
            'job_description',
            'requirements',
            'qualifications'
        ]
        
        for field in fields_to_check:
            if field in job and job[field]:
                field_value = job[field]
                
                if isinstance(field_value, str):
                    # If it's a comma-separated string
                    if ',' in field_value:
                        requirements.extend([skill.strip() for skill in field_value.split(',')])
                    else:
                        # Extract skills from text description
                        requirements.extend(self._extract_skills_from_text(field_value))
                elif isinstance(field_value, list):
                    requirements.extend(field_value)
        
        return list(set(requirements))  # Remove duplicates
    
    def _extract_skills_from_text(self, text: str) -> List[str]:
        """Extract skills from job description text"""
        # Use the skill matcher's common skills list to find mentions
        found_skills = []
        text_lower = text.lower()
        
        for skill in self.skill_matcher.common_skills:
            if skill.lower() in text_lower:
                found_skills.append(skill)
        
        return found_skills
    
    def _categorize_match(self, similarity_score: float) -> str:
        """Categorize the match quality"""
        if similarity_score >= 0.8:
            return 'excellent'
        elif similarity_score >= 0.6:
            return 'good'
        elif similarity_score >= 0.4:
            return 'fair'
        else:
            return 'poor'
    
    def _generate_recommendation_reason(self, similarity_score: float, 
                                      matched_skills: List[Dict], 
                                      missing_skills: List[str]) -> str:
        """Generate a human-readable recommendation reason"""
        match_count = len(matched_skills)
        missing_count = len(missing_skills)
        
        if similarity_score >= 0.8:
            if missing_count == 0:
                return f"Perfect match! You have all required skills including {', '.join([s['skill'] for s in matched_skills[:3]])}."
            else:
                return f"Excellent match! You have {match_count} matching skills. Consider learning {missing_skills[0]} to become an even stronger candidate."
        
        elif similarity_score >= 0.6:
            return f"Good match! You have {match_count} relevant skills. You might want to develop {', '.join(missing_skills[:2])} to strengthen your application."
        
        elif similarity_score >= 0.4:
            return f"Fair match with {match_count} matching skills. This could be a growth opportunity to learn {', '.join(missing_skills[:2])}."
        
        else:
            return f"This role could help you expand your skillset by learning {', '.join(missing_skills[:3])}."
    
    def get_skill_gap_analysis(self, jobseeker_skills: List[str], 
                             target_jobs: List[Dict]) -> Dict:
        """Analyze skill gaps across multiple target jobs"""
        try:
            all_missing_skills = []
            skill_frequency = {}
            
            for job in target_jobs:
                job_requirements = self._extract_job_requirements(job)
                missing_skills = self.skill_matcher.get_missing_skills(
                    jobseeker_skills, job_requirements
                )
                all_missing_skills.extend(missing_skills)
                
                # Count frequency of each missing skill
                for skill in missing_skills:
                    skill_frequency[skill] = skill_frequency.get(skill, 0) + 1
            
            # Sort skills by frequency (most requested first)
            sorted_skills = sorted(skill_frequency.items(), 
                                 key=lambda x: x[1], reverse=True)
            
            return {
                'most_requested_skills': sorted_skills[:10],
                'total_unique_skills_missing': len(skill_frequency),
                'learning_priority': [skill[0] for skill in sorted_skills[:5]],
                'skill_recommendations': self.skill_matcher.get_skill_recommendations(
                    [skill[0] for skill in sorted_skills[:5]]
                )
            }
            
        except Exception as e:
            logger.error(f"Error in skill gap analysis: {str(e)}")
            return {}