import re
import numpy as np
import logging
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.metrics.pairwise import cosine_similarity
from sklearn.cluster import KMeans
import difflib
from .enhanced_skill_matcher import EnhancedSkillMatcher

# Configure logger
logger = logging.getLogger(__name__)

class SkillMatcher:
    def __init__(self):
        self.enhanced_matcher = EnhancedSkillMatcher()
        # Keep the old simple matcher for fallback
        self.vectorizer = TfidfVectorizer(
            lowercase=True,
            stop_words='english',
            ngram_range=(1, 2)
        )
        # Set similarity threshold
        self.similarity_threshold = 0.3
    
    def calculate_similarity(self, jobseeker_skills, job_requirements):
        """Calculate similarity using enhanced semantic matching"""
        try:
            # Use enhanced semantic matching
            similarity_score, _ = self.enhanced_matcher.calculate_enhanced_similarity(
                jobseeker_skills, job_requirements
            )
            return similarity_score
        except Exception as e:
            logger.warning(f"Enhanced matching failed, using fallback: {e}")
            return self._fallback_similarity(jobseeker_skills, job_requirements)
    
    def _fallback_similarity(self, jobseeker_skills, job_requirements):
        """Fallback to simple TF-IDF matching"""
        try:
            if not jobseeker_skills or not job_requirements:
                return 0.0
            
            # Create documents
            jobseeker_doc = ' '.join(jobseeker_skills)
            job_doc = ' '.join(job_requirements)
            
            # Calculate TF-IDF similarity
            docs = [jobseeker_doc, job_doc]
            tfidf_matrix = self.vectorizer.fit_transform(docs)
            similarity = cosine_similarity(tfidf_matrix[0:1], tfidf_matrix[1:2])[0][0]
            
            return float(similarity)
        except Exception as e:
            logger.error(f"Fallback matching failed: {e}")
            return 0.0
    
    def get_matched_skills(self, jobseeker_skills, job_requirements):
        """Get matched skills with enhanced semantic matching"""
        try:
            return self.enhanced_matcher.get_enhanced_matched_skills(
                jobseeker_skills, job_requirements
            )
        except Exception as e:
            logger.warning(f"Enhanced skill matching failed: {e}")
            return self._fallback_matched_skills(jobseeker_skills, job_requirements)
    
    def _fallback_matched_skills(self, jobseeker_skills, job_requirements):
        """Fallback method for getting matched skills"""
        matched = []
        js_skills_lower = [skill.lower().strip() for skill in jobseeker_skills]
        
        for req_skill in job_requirements:
            req_skill_lower = req_skill.lower().strip()
            if req_skill_lower in js_skills_lower:
                matched.append({
                    'skill': req_skill,
                    'confidence': 1.0,
                    'match_type': 'exact'
                })
        
        return matched
    
    def get_missing_skills(self, jobseeker_skills, job_requirements):
        """Get missing skills using enhanced matching"""
        try:
            return self.enhanced_matcher.get_enhanced_missing_skills(
                jobseeker_skills, job_requirements
            )
        except Exception as e:
            logger.warning(f"Enhanced missing skills failed: {e}")
            return self._fallback_missing_skills(jobseeker_skills, job_requirements)
    
    def _fallback_missing_skills(self, jobseeker_skills, job_requirements):
        """Fallback method for getting missing skills"""
        js_skills_lower = [skill.lower().strip() for skill in jobseeker_skills]
        missing = []
        
        for req_skill in job_requirements:
            if req_skill.lower().strip() not in js_skills_lower:
                missing.append(req_skill)
        
        return missing
    
    def cluster_jobseeker_skills(self, jobseeker_skills):
        """Cluster jobseeker skills"""
        try:
            return self.enhanced_matcher.cluster_skills(jobseeker_skills)
        except Exception as e:
            logger.warning(f"Skill clustering failed: {e}")
            return {0: jobseeker_skills}
    
    def get_skill_insights(self, jobseeker_skills, all_job_requirements):
        """Get insights about skill market demand and clusters"""
        try:
            insights = {
                'skill_clusters': self.cluster_jobseeker_skills(jobseeker_skills),
                'market_analysis': {}
            }
            
            # Analyze each skill against market demand
            for skill in jobseeker_skills:
                demand_count = 0
                related_jobs = []
                
                for job_reqs in all_job_requirements:
                    similarity_score, _ = self.enhanced_matcher.calculate_enhanced_similarity(
                        [skill], job_reqs
                    )
                    if similarity_score > self.similarity_threshold:
                        demand_count += 1
                        related_jobs.append(job_reqs)
                
                insights['market_analysis'][skill] = {
                    'demand_count': demand_count,
                    'demand_level': self._get_demand_level(demand_count),
                    'related_skills': self.enhanced_matcher.expand_skill(skill)[:5]
                }
            
            return insights
        except Exception as e:
            logger.error(f"Skill insights failed: {e}")
            return {'skill_clusters': {0: jobseeker_skills}, 'market_analysis': {}}
    
    def _get_demand_level(self, count):
        """Determine demand level based on count"""
        if count >= 10:
            return 'High'
        elif count >= 5:
            return 'Medium'
        elif count >= 1:
            return 'Low'
        else:
            return 'None'