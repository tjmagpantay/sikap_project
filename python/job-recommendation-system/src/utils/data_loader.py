import json
import csv
import pandas as pd
from pathlib import Path
from typing import List, Dict, Optional
import logging

# Add proper path handling
import sys
import os
sys.path.append(os.path.dirname(os.path.dirname(os.path.abspath(__file__))))

from config.settings import BASE_DIR

logger = logging.getLogger(__name__)

class DataLoader:
    def __init__(self):
        self.data_dir = BASE_DIR / 'data'
        self.raw_dir = self.data_dir / 'raw'
        self.processed_dir = self.data_dir / 'processed'
        
        # Ensure directories exist
        self.raw_dir.mkdir(parents=True, exist_ok=True)
        self.processed_dir.mkdir(parents=True, exist_ok=True)
    
    def load_skills_database(self) -> List[str]:
        """Load skills database from JSON file"""
        try:
            skills_file = self.processed_dir / 'skills_database.json'
            
            if skills_file.exists():
                with open(skills_file, 'r') as f:
                    data = json.load(f)
                return data.get('skills', [])
            else:
                # Create default skills database
                return self.create_default_skills_database()
                
        except Exception as e:
            logger.error(f"Error loading skills database: {e}")
            return []
    
    def create_default_skills_database(self) -> List[str]:
        """Create and save default skills database"""
        default_skills = [
            # Programming Languages
            'python', 'java', 'javascript', 'typescript', 'c++', 'c#', 'php', 'ruby',
            'go', 'rust', 'swift', 'kotlin', 'scala', 'r', 'matlab', 'sql',
            
            # Web Technologies
            'html', 'css', 'react', 'angular', 'vue', 'node.js', 'express',
            'django', 'flask', 'laravel', 'spring boot', 'asp.net',
            
            # Databases
            'mysql', 'postgresql', 'mongodb', 'redis', 'elasticsearch',
            'sqlite', 'oracle', 'sql server', 'cassandra', 'dynamodb',
            
            # Cloud & DevOps
            'aws', 'azure', 'google cloud', 'docker', 'kubernetes',
            'jenkins', 'gitlab ci', 'github actions', 'terraform', 'ansible',
            
            # Data Science & ML
            'machine learning', 'deep learning', 'data science', 'data analysis',
            'tensorflow', 'pytorch', 'scikit-learn', 'pandas', 'numpy',
            'matplotlib', 'seaborn', 'jupyter', 'r studio',
            
            # Mobile Development
            'android', 'ios', 'react native', 'flutter', 'xamarin',
            'swift', 'kotlin', 'objective-c',
            
            # Soft Skills
            'project management', 'team leadership', 'communication',
            'problem solving', 'analytical thinking', 'creativity',
            'time management', 'collaboration', 'agile', 'scrum',
            
            # Tools & Technologies
            'git', 'linux', 'windows', 'macos', 'visual studio code',
            'intellij', 'eclipse', 'postman', 'jira', 'slack'
        ]
        
        # Save to file
        skills_data = {'skills': default_skills, 'version': '1.0'}
        skills_file = self.processed_dir / 'skills_database.json'
        
        try:
            with open(skills_file, 'w') as f:
                json.dump(skills_data, f, indent=2)
            logger.info(f"Created default skills database with {len(default_skills)} skills")
        except Exception as e:
            logger.error(f"Error saving skills database: {e}")
        
        return default_skills
    
    def load_job_titles_mapping(self) -> Dict[str, List[str]]:
        """Load job titles and their associated skills"""
        try:
            mapping_file = self.processed_dir / 'job_titles_mapping.json'
            
            if mapping_file.exists():
                with open(mapping_file, 'r') as f:
                    return json.load(f)
            else:
                return self.create_default_job_titles_mapping()
                
        except Exception as e:
            logger.error(f"Error loading job titles mapping: {e}")
            return {}
    
    def create_default_job_titles_mapping(self) -> Dict[str, List[str]]:
        """Create default job titles to skills mapping"""
        mapping = {
            'software developer': ['python', 'java', 'javascript', 'git', 'sql'],
            'data scientist': ['python', 'machine learning', 'pandas', 'sql', 'statistics'],
            'web developer': ['html', 'css', 'javascript', 'react', 'node.js'],
            'mobile developer': ['java', 'swift', 'kotlin', 'react native', 'flutter'],
            'devops engineer': ['docker', 'kubernetes', 'aws', 'linux', 'jenkins'],
            'product manager': ['project management', 'agile', 'scrum', 'communication'],
            'ui/ux designer': ['figma', 'sketch', 'adobe xd', 'photoshop', 'user research'],
            'database administrator': ['sql', 'mysql', 'postgresql', 'database design'],
            'system administrator': ['linux', 'windows server', 'networking', 'security'],
            'business analyst': ['sql', 'excel', 'data analysis', 'requirements gathering']
        }
        
        # Save to file
        mapping_file = self.processed_dir / 'job_titles_mapping.json'
        try:
            with open(mapping_file, 'w') as f:
                json.dump(mapping, f, indent=2)
            logger.info("Created default job titles mapping")
        except Exception as e:
            logger.error(f"Error saving job titles mapping: {e}")
        
        return mapping
    
    def save_processed_data(self, data: Dict, filename: str) -> bool:
        """Save processed data to JSON file"""
        try:
            file_path = self.processed_dir / f"{filename}.json"
            with open(file_path, 'w') as f:
                json.dump(data, f, indent=2)
            return True
        except Exception as e:
            logger.error(f"Error saving processed data: {e}")
            return False
    
    def load_processed_data(self, filename: str) -> Optional[Dict]:
        """Load processed data from JSON file"""
        try:
            file_path = self.processed_dir / f"{filename}.json"
            if file_path.exists():
                with open(file_path, 'r') as f:
                    return json.load(f)
            return None
        except Exception as e:
            logger.error(f"Error loading processed data: {e}")
            return None
    
    def export_recommendations_to_csv(self, recommendations: List[Dict], filename: str) -> bool:
        """Export recommendations to CSV file"""
        try:
            file_path = self.processed_dir / f"{filename}.csv"
            
            if not recommendations:
                return False
            
            df = pd.DataFrame(recommendations)
            df.to_csv(file_path, index=False)
            return True
            
        except Exception as e:
            logger.error(f"Error exporting to CSV: {e}")
            return False
    
    def load_industry_skills(self) -> Dict[str, List[str]]:
        """Load industry-specific skills mapping"""
        industries = {
            'technology': ['python', 'java', 'javascript', 'cloud computing', 'agile'],
            'finance': ['excel', 'financial modeling', 'risk management', 'sql'],
            'healthcare': ['hipaa compliance', 'medical terminology', 'patient care'],
            'marketing': ['digital marketing', 'seo', 'social media', 'analytics'],
            'education': ['curriculum development', 'teaching', 'assessment', 'learning management systems']
        }
        return industries