import mysql.connector
from typing import Dict, List, Optional
import logging
from config.settings import DATABASE_CONFIG

logger = logging.getLogger(__name__)

class User:
    def __init__(self):
        self.db_config = DATABASE_CONFIG
    
    def get_connection(self):
        """Get database connection"""
        try:
            connection = mysql.connector.connect(**self.db_config)
            return connection
        except mysql.connector.Error as e:
            logger.error(f"Database connection error: {e}")
            return None
    
    def get_jobseeker_skills(self, jobseeker_id: int) -> List[str]:
        """Get jobseeker skills from database"""
        try:
            conn = self.get_connection()
            if not conn:
                return []
            
            cursor = conn.cursor(dictionary=True)
            
            # Get skills from jobseeker_skills table
            query = """
                SELECT skill_name 
                FROM jobseeker_skills 
                WHERE jobseeker_id = %s
            """
            cursor.execute(query, (jobseeker_id,))
            skills = cursor.fetchall()
            
            skill_list = [skill['skill_name'] for skill in skills]
            
            cursor.close()
            conn.close()
            
            return skill_list
            
        except Exception as e:
            logger.error(f"Error fetching jobseeker skills: {e}")
            return []
    
    def get_jobseeker_profile(self, jobseeker_id: int) -> Optional[Dict]:
        """Get complete jobseeker profile"""
        try:
            conn = self.get_connection()
            if not conn:
                return None
            
            cursor = conn.cursor(dictionary=True)
            
            # Get jobseeker basic info
            query = """
                SELECT js.*, u.email, u.full_name
                FROM jobseekers js
                JOIN users u ON js.user_id = u.user_id
                WHERE js.jobseeker_id = %s
            """
            cursor.execute(query, (jobseeker_id,))
            profile = cursor.fetchone()
            
            if profile:
                # Get skills
                profile['skills'] = self.get_jobseeker_skills(jobseeker_id)
                
                # Get resume info if exists
                resume_query = """
                    SELECT resume_path, resume_filename
                    FROM jobseeker_documents
                    WHERE jobseeker_id = %s AND document_type = 'resume'
                    ORDER BY uploaded_at DESC
                    LIMIT 1
                """
                cursor.execute(resume_query, (jobseeker_id,))
                resume = cursor.fetchone()
                if resume:
                    profile['resume_path'] = resume['resume_path']
                    profile['resume_filename'] = resume['resume_filename']
            
            cursor.close()
            conn.close()
            
            return profile
            
        except Exception as e:
            logger.error(f"Error fetching jobseeker profile: {e}")
            return None
    
    def get_available_jobs(self, limit: int = 50) -> List[Dict]:
        """Get available job postings"""
        try:
            conn = self.get_connection()
            if not conn:
                return []
            
            cursor = conn.cursor(dictionary=True)
            
            query = """
                SELECT 
                    jp.job_id,
                    jp.job_title,
                    jp.job_description,
                    jp.required_skills,
                    jp.preferred_skills,
                    jp.salary_min,
                    jp.salary_max,
                    jp.job_type,
                    jp.location,
                    jp.posted_date,
                    c.company_name
                FROM job_posts jp
                JOIN companies c ON jp.company_id = c.company_id
                WHERE jp.job_status = 'open'
                ORDER BY jp.posted_date DESC
                LIMIT %s
            """
            cursor.execute(query, (limit,))
            jobs = cursor.fetchall()
            
            # Format salary range
            for job in jobs:
                if job['salary_min'] and job['salary_max']:
                    job['salary_range'] = f"${job['salary_min']:,} - ${job['salary_max']:,}"
                elif job['salary_min']:
                    job['salary_range'] = f"${job['salary_min']:,}+"
                else:
                    job['salary_range'] = "Salary not specified"
            
            cursor.close()
            conn.close()
            
            return jobs
            
        except Exception as e:
            logger.error(f"Error fetching available jobs: {e}")
            return []
    
    def save_recommendation_log(self, jobseeker_id: int, job_id: int, 
                               match_percentage: float, matched_skills: List[str]) -> bool:
        """Save recommendation to database for analytics"""
        try:
            conn = self.get_connection()
            if not conn:
                return False
            
            cursor = conn.cursor()
            
            query = """
                INSERT INTO job_recommendations 
                (jobseeker_id, job_id, match_percentage, matched_skills, created_at)
                VALUES (%s, %s, %s, %s, NOW())
            """
            
            matched_skills_str = ','.join(matched_skills) if matched_skills else ''
            cursor.execute(query, (jobseeker_id, job_id, match_percentage, matched_skills_str))
            
            conn.commit()
            cursor.close()
            conn.close()
            
            return True
            
        except Exception as e:
            logger.error(f"Error saving recommendation log: {e}")
            return False

    def __init__(self, user_id, name, email, skills=None):
        self.user_id = user_id
        self.name = name
        self.email = email
        self.skills = skills if skills is not None else []

    def add_skill(self, skill):
        if skill not in self.skills:
            self.skills.append(skill)

    def remove_skill(self, skill):
        if skill in self.skills:
            self.skills.remove(skill)

    def get_profile(self):
        return {
            'user_id': self.user_id,
            'name': self.name,
            'email': self.email,
            'skills': self.skills
        }