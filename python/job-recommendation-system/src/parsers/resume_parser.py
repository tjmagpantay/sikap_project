import pdfplumber
import PyPDF2
import re
import io
from typing import List, Dict, Optional
import logging

# Add proper path handling
import sys
import os
sys.path.append(os.path.dirname(os.path.dirname(os.path.abspath(__file__))))

from config.settings import COMMON_SKILLS

logger = logging.getLogger(__name__)

class ResumeParser:
    def __init__(self):
        self.skill_keywords = COMMON_SKILLS
        self.extended_skills = self._load_extended_skills()
    
    def _load_extended_skills(self) -> List[str]:
        """Load extended skill list including technical terms"""
        extended = self.skill_keywords.copy()
        
        # Add more technical skills
        tech_skills = [
            'react native', 'flutter', 'swift', 'kotlin', 'xamarin',
            'tensorflow', 'pytorch', 'scikit-learn', 'pandas', 'numpy',
            'django', 'flask', 'spring boot', 'laravel', 'codeigniter',
            'redis', 'elasticsearch', 'mongodb', 'cassandra',
            'jenkins', 'gitlab ci', 'github actions', 'travis ci',
            'webpack', 'babel', 'typescript', 'sass', 'less',
            'agile', 'scrum', 'kanban', 'devops', 'ci/cd'
        ]
        
        extended.extend(tech_skills)
        return extended
    
    def extract_text(self, file) -> str:
        """Extract text from uploaded PDF file"""
        try:
            filename = file.filename.lower()
            
            if filename.endswith('.pdf'):
                return self._extract_from_pdf(file)
            else:
                raise ValueError(f"Unsupported file format: {filename}. Only PDF files are supported.")
                
        except Exception as e:
            logger.error(f"Error extracting text from file: {str(e)}")
            raise
    
    def _extract_from_pdf(self, file) -> str:
        """Extract text from PDF file"""
        text = ""
        
        try:
            # Try with pdfplumber first (better for complex layouts)
            with pdfplumber.open(file) as pdf:
                for page in pdf.pages:
                    page_text = page.extract_text()
                    if page_text:
                        text += page_text + "\n"
        except Exception as e:
            logger.warning(f"pdfplumber failed: {e}, trying PyPDF2")
            
            try:
                # Fallback to PyPDF2
                file.seek(0)  # Reset file pointer
                pdf_reader = PyPDF2.PdfReader(file)
                for page_num in range(len(pdf_reader.pages)):
                    page = pdf_reader.pages[page_num]
                    text += page.extract_text() + "\n"
            except Exception as e2:
                logger.error(f"Both PDF extraction methods failed: {e2}")
                raise
        
        return text.strip()
    
    def extract_skills(self, text: str) -> List[str]:
        """Extract skills from resume text"""
        if not text:
            return []
        
        # Convert to lowercase for matching
        text_lower = text.lower()
        
        # Find skills in text
        found_skills = []
        
        for skill in self.extended_skills:
            skill_lower = skill.lower()
            
            # Look for exact matches and word boundaries
            pattern = r'\b' + re.escape(skill_lower) + r'\b'
            if re.search(pattern, text_lower):
                found_skills.append(skill)
        
        # Also look for skills in common patterns
        found_skills.extend(self._extract_skills_by_patterns(text))
        
        # Remove duplicates and return
        return list(set(found_skills))
    
    def _extract_skills_by_patterns(self, text: str) -> List[str]:
        """Extract skills using common resume patterns"""
        skills = []
        
        # Common patterns for skills sections
        patterns = [
            r'skills?\s*:?\s*(.+?)(?:\n\n|\n[A-Z]|\n\s*$)',
            r'technical\s+skills?\s*:?\s*(.+?)(?:\n\n|\n[A-Z]|\n\s*$)',
            r'technologies?\s*:?\s*(.+?)(?:\n\n|\n[A-Z]|\n\s*$)',
            r'programming\s+languages?\s*:?\s*(.+?)(?:\n\n|\n[A-Z]|\n\s*$)',
        ]
        
        for pattern in patterns:
            matches = re.finditer(pattern, text, re.IGNORECASE | re.MULTILINE)
            for match in matches:
                skill_text = match.group(1)
                # Split by common delimiters
                potential_skills = re.split(r'[,;•\-\n\t]+', skill_text)
                
                for skill in potential_skills:
                    skill = skill.strip()
                    if skill and len(skill) > 1:
                        # Check if it's a known skill
                        skill_lower = skill.lower()
                        for known_skill in self.extended_skills:
                            if known_skill.lower() in skill_lower:
                                skills.append(known_skill)
        
        return skills
    
    def extract_contact_info(self, text: str) -> Dict[str, Optional[str]]:
        """Extract contact information from resume"""
        contact_info = {
            'email': None,
            'phone': None,
            'linkedin': None,
            'github': None
        }
        
        # Email pattern
        email_pattern = r'\b[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Z|a-z]{2,}\b'
        email_match = re.search(email_pattern, text)
        if email_match:
            contact_info['email'] = email_match.group()
        
        # Phone pattern (various formats)
        phone_pattern = r'(\+?1?\s*\(?[0-9]{3}\)?[\s\-\.]?[0-9]{3}[\s\-\.]?[0-9]{4})'
        phone_match = re.search(phone_pattern, text)
        if phone_match:
            contact_info['phone'] = phone_match.group()
        
        # LinkedIn pattern
        linkedin_pattern = r'linkedin\.com/in/[\w\-]+'
        linkedin_match = re.search(linkedin_pattern, text, re.IGNORECASE)
        if linkedin_match:
            contact_info['linkedin'] = linkedin_match.group()
        
        # GitHub pattern
        github_pattern = r'github\.com/[\w\-]+'
        github_match = re.search(github_pattern, re.IGNORECASE)
        if github_match:
            contact_info['github'] = github_match.group()
        
        return contact_info
    
    def extract_experience_years(self, text: str) -> Optional[int]:
        """Extract years of experience from resume text"""
        # Look for patterns like "5 years of experience", "3+ years", etc.
        patterns = [
            r'(\d+)\+?\s*years?\s+(?:of\s+)?experience',
            r'(\d+)\+?\s*years?\s+in',
            r'experience\s*:?\s*(\d+)\+?\s*years?'
        ]
        
        for pattern in patterns:
            match = re.search(pattern, text, re.IGNORECASE)
            if match:
                return int(match.group(1))
        
        return None