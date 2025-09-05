import re
import nltk
from nltk.corpus import stopwords
from nltk.tokenize import word_tokenize, sent_tokenize
from nltk.stem import PorterStemmer
import string
from typing import List, Set
import logging
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.preprocessing import normalize

logger = logging.getLogger(__name__)

class TextProcessor:
    def __init__(self):
        self.download_nltk_data()
        self.stop_words = set(stopwords.words('english'))
        self.stemmer = PorterStemmer()
        
        # Add custom stop words for resume parsing
        self.custom_stop_words = {
            'experience', 'work', 'job', 'role', 'position', 'company',
            'responsibilities', 'duties', 'tasks', 'projects', 'team',
            'years', 'months', 'time', 'period', 'during', 'worked'
        }
        self.stop_words.update(self.custom_stop_words)
    
    def download_nltk_data(self):
        """Download required NLTK data"""
        try:
            nltk.data.find('tokenizers/punkt')
        except LookupError:
            nltk.download('punkt')
        
        try:
            nltk.data.find('corpora/stopwords')
        except LookupError:
            nltk.download('stopwords')
    
    def clean_text(self, text: str) -> str:
        """Clean and normalize text"""
        if not text:
            return ""
        
        # Convert to lowercase
        text = text.lower()
        
        # Remove extra whitespace and line breaks
        text = re.sub(r'\s+', ' ', text)
        
        # Remove special characters but keep alphanumeric and spaces
        text = re.sub(r'[^\w\s\-\.\+]', ' ', text)
        
        # Remove multiple spaces
        text = re.sub(r'\s+', ' ', text)
        
        return text.strip()
    
    def extract_keywords(self, text: str, min_length: int = 2, max_length: int = 30) -> List[str]:
        """Extract keywords from text"""
        if not text:
            return []
        
        # Clean text
        cleaned_text = self.clean_text(text)
        
        # Tokenize
        tokens = word_tokenize(cleaned_text)
        
        # Filter tokens
        keywords = []
        for token in tokens:
            # Skip if too short or too long
            if len(token) < min_length or len(token) > max_length:
                continue
            
            # Skip if it's a stop word
            if token in self.stop_words:
                continue
            
            # Skip if it's all punctuation
            if token in string.punctuation:
                continue
            
            # Skip if it's all digits
            if token.isdigit():
                continue
            
            keywords.append(token)
        
        return keywords
    
    def extract_noun_phrases(self, text: str) -> List[str]:
        """Extract noun phrases that might be skills"""
        if not text:
            return []
        
        # Simple noun phrase extraction using patterns
        # Look for patterns like "machine learning", "data analysis", etc.
        noun_phrase_patterns = [
            r'\b[a-z]+\s+[a-z]+ing\b',  # "machine learning", "data processing"
            r'\b[a-z]+\s+[a-z]+ment\b',  # "project management"
            r'\b[a-z]+\s+[a-z]+tion\b',  # "data visualization"
            r'\b[a-z]+\s+[a-z]+sis\b',   # "data analysis"
            r'\b[a-z]+\s+[a-z]+ence\b',  # "artificial intelligence"
        ]
        
        phrases = []
        cleaned_text = self.clean_text(text)
        
        for pattern in noun_phrase_patterns:
            matches = re.findall(pattern, cleaned_text)
            phrases.extend(matches)
        
        return list(set(phrases))  # Remove duplicates
    
    def extract_technical_terms(self, text: str) -> List[str]:
        """Extract technical terms and acronyms"""
        if not text:
            return []
        
        technical_terms = []
        
        # Pattern for acronyms (2-6 capital letters)
        acronym_pattern = r'\b[A-Z]{2,6}\b'
        acronyms = re.findall(acronym_pattern, text)
        technical_terms.extend(acronyms)
        
        # Pattern for version numbers (e.g., "Python 3.8", "React 16")
        version_pattern = r'\b[a-zA-Z]+\s+\d+(?:\.\d+)*\b'
        versions = re.findall(version_pattern, text, re.IGNORECASE)
        technical_terms.extend(versions)
        
        # Pattern for file extensions and tech terms with dots
        tech_pattern = r'\b[a-zA-Z]+\.[a-zA-Z]+\b'
        tech_terms = re.findall(tech_pattern, text)
        technical_terms.extend(tech_terms)
        
        return list(set(technical_terms))  # Remove duplicates
    
    def preprocess_for_similarity(self, text: str) -> str:
        """Preprocess text for similarity calculation"""
        if not text:
            return ""
        
        # Clean text
        cleaned = self.clean_text(text)
        
        # Tokenize
        tokens = word_tokenize(cleaned)
        
        # Remove stop words and stem
        processed_tokens = []
        for token in tokens:
            if token not in self.stop_words and len(token) > 2:
                # Don't stem technical terms and proper nouns
                if token.isupper() or any(char.isdigit() for char in token):
                    processed_tokens.append(token)
                else:
                    processed_tokens.append(self.stemmer.stem(token))
        
        return ' '.join(processed_tokens)
    
    def extract_contact_patterns(self, text: str) -> dict:
        """Extract contact information patterns"""
        patterns = {
            'email': r'\b[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Z|a-z]{2,}\b',
            'phone': r'(\+?1?\s*\(?[0-9]{3}\)?[\s\-\.]?[0-9]{3}[\s\-\.]?[0-9]{4})',
            'linkedin': r'linkedin\.com/in/[\w\-]+',
            'github': r'github\.com/[\w\-]+',
            'website': r'https?://(?:[-\w.])+(?:\.[a-zA-Z]{2,4})+(?:[\w/_.])*(?:\?\S+)?'
        }
        
        extracted = {}
        for pattern_name, pattern in patterns.items():
            matches = re.findall(pattern, text, re.IGNORECASE)
            extracted[pattern_name] = list(set(matches)) if matches else []
        
        return extracted
    
    def segment_resume_sections(self, text: str) -> dict:
        """Segment resume into different sections"""
        sections = {
            'summary': '',
            'experience': '',
            'education': '',
            'skills': '',
            'projects': '',
            'certifications': ''
        }
        
        # Define section headers patterns
        section_patterns = {
            'summary': r'(?:summary|profile|objective|about)',
            'experience': r'(?:experience|employment|work\s+history|professional\s+experience)',
            'education': r'(?:education|academic|qualification)',
            'skills': r'(?:skills|technical\s+skills|competencies|technologies)',
            'projects': r'(?:projects|portfolio|achievements)',
            'certifications': r'(?:certifications?|certificates?|licenses?)'
        }
        
        # Split text into lines
        lines = text.split('\n')
        current_section = None
        
        for line in lines:
            line = line.strip()
            if not line:
                continue
            
            # Check if line is a section header
            line_lower = line.lower()
            for section, pattern in section_patterns.items():
                if re.search(pattern, line_lower):
                    current_section = section
                    break
            
            # Add content to current section
            if current_section and current_section in sections:
                sections[current_section] += line + ' '
        
        # Clean up sections
        for section in sections:
            sections[section] = sections[section].strip()
        
        return sections
    
    def vectorize_texts(texts):
        vectorizer = TfidfVectorizer(stop_words='english')
        tfidf_matrix = vectorizer.fit_transform(texts)
        return normalize(tfidf_matrix)  # Normalize the vectors for better comparison