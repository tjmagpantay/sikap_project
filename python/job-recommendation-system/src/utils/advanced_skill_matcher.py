import numpy as np
import pandas as pd
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.metrics.pairwise import cosine_similarity
from sklearn.decomposition import TruncatedSVD
from sklearn.preprocessing import normalize
import pickle
import os
import logging
from typing import List, Dict, Tuple
import warnings
warnings.filterwarnings('ignore')

# For production, we can use sentence-transformers for better embeddings
try:
    from sentence_transformers import SentenceTransformer
    SENTENCE_TRANSFORMERS_AVAILABLE = True
except ImportError:
    SENTENCE_TRANSFORMERS_AVAILABLE = False
    print("sentence-transformers not available, using TF-IDF fallback")

class AdvancedSkillMatcher:
    def __init__(self, model_path='../data/models/'):
        self.model_path = model_path
        self.skill_embeddings = {}
        self.skill_index = {}
        self.vectorizer = None
        self.similarity_matrix = None
        self.skill_list = []
        
        # For production: Use pre-trained sentence transformer
        if SENTENCE_TRANSFORMERS_AVAILABLE:
            self.sentence_model = SentenceTransformer('all-MiniLM-L6-v2')  # Fast and good
        else:
            self.sentence_model = None
            
        # Initialize with TF-IDF as fallback
        self.tfidf_vectorizer = TfidfVectorizer(
            lowercase=True,
            stop_words='english',
            ngram_range=(1, 3),  # Include trigrams for better context
            max_features=5000,
            min_df=2,  # Ignore skills that appear in less than 2 documents
            max_df=0.95  # Ignore skills that appear in more than 95% of documents
        )
        
        self.logger = logging.getLogger(__name__)
        
    def train_on_job_data(self, job_data: List[Dict]) -> None:
        """
        Train the matcher on actual job posting data
        This replaces hardcoded synonyms with data-driven learning
        """
        print("🤖 Training skill matcher on job data...")
        
        # Extract all skills from job postings
        all_skills = []
        skill_contexts = []  # Skills with their job context for better understanding
        
        for job in job_data:
            job_skills = job.get('skills', [])
            job_title = job.get('job_title', '')
            job_description = job.get('job_summary', '')
            
            for skill in job_skills:
                if skill and len(skill.strip()) > 1:
                    clean_skill = self._clean_skill(skill)
                    all_skills.append(clean_skill)
                    
                    # Create context for better embeddings
                    context = f"{clean_skill} {job_title} {job_description}"
                    skill_contexts.append(context)
        
        # Remove duplicates while preserving order
        unique_skills = list(dict.fromkeys(all_skills))
        self.skill_list = unique_skills
        
        print(f"📊 Found {len(unique_skills)} unique skills from {len(job_data)} jobs")
        
        # Create skill embeddings
        self._create_skill_embeddings(unique_skills, skill_contexts)
        
        # Build similarity matrix for fast lookups
        self._build_similarity_matrix()
        
        # Save the trained model
        self._save_model()
        
        print("✅ Skill matcher training complete!")
    
    def _clean_skill(self, skill: str) -> str:
        """Clean and normalize skill names"""
        import re
        skill = str(skill).lower().strip()
        
        # Remove special characters but keep spaces and hyphens
        skill = re.sub(r'[^\w\s-]', '', skill)
        
        # Remove extra whitespace
        skill = re.sub(r'\s+', ' ', skill)
        
        # Remove common noise words
        noise_words = ['skills', 'experience', 'knowledge', 'proficiency']
        for noise in noise_words:
            skill = skill.replace(noise, '').strip()
        
        return skill
    
    def _create_skill_embeddings(self, skills: List[str], contexts: List[str]) -> None:
        """Create embeddings for skills using the best available method"""
        
        if self.sentence_model and len(skills) < 10000:  # Use sentence transformers for smaller datasets
            print("🧠 Creating embeddings using Sentence Transformers...")
            embeddings = self.sentence_model.encode(skills, show_progress_bar=True)
            
        else:  # Use TF-IDF for larger datasets or when sentence transformers unavailable
            print("📝 Creating embeddings using TF-IDF...")
            
            # Use skill contexts for better representations
            if contexts and len(contexts) == len(skills):
                tfidf_matrix = self.tfidf_vectorizer.fit_transform(contexts)
            else:
                tfidf_matrix = self.tfidf_vectorizer.fit_transform(skills)
            
            # Apply dimensionality reduction for efficiency
            if tfidf_matrix.shape[1] > 500:
                svd = TruncatedSVD(n_components=300)
                embeddings = svd.fit_transform(tfidf_matrix)
            else:
                embeddings = tfidf_matrix.toarray()
        
        # Normalize embeddings for cosine similarity
        embeddings = normalize(embeddings, norm='l2')
        
        # Store embeddings
        for i, skill in enumerate(skills):
            self.skill_embeddings[skill] = embeddings[i]
            self.skill_index[skill] = i
        
        self.embeddings_matrix = embeddings
    
    def _build_similarity_matrix(self) -> None:
        """Pre-compute similarity matrix for fast skill matching"""
        print("⚡ Building similarity matrix for fast lookups...")
        
        if len(self.skill_list) > 0:
            self.similarity_matrix = cosine_similarity(self.embeddings_matrix)
        
    def find_similar_skills(self, skill: str, top_k: int = 10, threshold: float = 0.3) -> List[Tuple[str, float]]:
        """Find similar skills using pre-computed embeddings"""
        clean_skill = self._clean_skill(skill)
        
        if clean_skill not in self.skill_index:
            # If skill not in our vocabulary, try fuzzy matching
            return self._fuzzy_skill_match(clean_skill, top_k, threshold)
        
        skill_idx = self.skill_index[clean_skill]
        similarities = self.similarity_matrix[skill_idx]
        
        # Get top-k similar skills
        top_indices = np.argsort(similarities)[::-1][:top_k + 1]  # +1 to exclude self
        
        similar_skills = []
        for idx in top_indices:
            if idx != skill_idx and similarities[idx] > threshold:
                similar_skills.append((self.skill_list[idx], float(similarities[idx])))
        
        return similar_skills
    
    def _fuzzy_skill_match(self, skill: str, top_k: int, threshold: float) -> List[Tuple[str, float]]:
        """Fallback fuzzy matching for unknown skills"""
        import difflib
        
        matches = difflib.get_close_matches(skill, self.skill_list, n=top_k, cutoff=threshold)
        return [(match, difflib.SequenceMatcher(None, skill, match).ratio()) for match in matches]
    
    def calculate_job_match(self, jobseeker_skills: List[str], job_requirements: List[str]) -> Dict:
        """Calculate match between jobseeker and job using learned embeddings"""
        
        if not jobseeker_skills or not job_requirements:
            return {
                'similarity_score': 0.0,
                'matched_skills': [],
                'missing_skills': job_requirements,
                'match_details': []
            }
        
        # Clean skills
        js_skills = [self._clean_skill(s) for s in jobseeker_skills]
        job_skills = [self._clean_skill(s) for s in job_requirements]
        
        matched_skills = []
        missing_skills = []
        match_details = []
        
        total_match_score = 0.0
        
        for job_skill in job_skills:
            best_match = None
            best_score = 0.0
            
            # Direct match first
            if job_skill in js_skills:
                best_match = job_skill
                best_score = 1.0
            else:
                # Find similar skills
                similar_skills = self.find_similar_skills(job_skill, top_k=5, threshold=0.4)
                
                for js_skill in js_skills:
                    for similar_skill, similarity in similar_skills:
                        if js_skill == similar_skill and similarity > best_score:
                            best_match = js_skill
                            best_score = similarity
            
            if best_match and best_score > 0.4:  # Configurable threshold
                matched_skills.append({
                    'required_skill': job_skill,
                    'matched_skill': best_match,
                    'confidence': round(best_score, 3),
                    'match_type': self._get_match_type(best_score)
                })
                total_match_score += best_score
                match_details.append({
                    'job_skill': job_skill,
                    'matched_with': best_match,
                    'score': best_score
                })
            else:
                missing_skills.append(job_skill)
        
        # Calculate overall similarity
        max_possible_score = len(job_skills)
        similarity_score = total_match_score / max_possible_score if max_possible_score > 0 else 0.0
        
        return {
            'similarity_score': min(similarity_score, 1.0),
            'matched_skills': matched_skills,
            'missing_skills': missing_skills,
            'match_details': match_details,
            'total_required': len(job_skills),
            'total_matched': len(matched_skills)
        }
    
    def _get_match_type(self, score: float) -> str:
        """Determine match type based on score"""
        if score >= 0.95:
            return 'exact'
        elif score >= 0.8:
            return 'very_similar'
        elif score >= 0.6:
            return 'similar'
        else:
            return 'related'
    
    def batch_calculate_recommendations(self, jobseeker_skills: List[str], jobs: List[Dict]) -> List[Dict]:
        """Efficiently calculate recommendations for multiple jobs"""
        recommendations = []
        
        for job in jobs:
            job_skills = job.get('skills', [])
            match_result = self.calculate_job_match(jobseeker_skills, job_skills)
            
            recommendation = {
                'job_id': job.get('job_id'),
                'job_title': job.get('job_title'),
                'company_name': job.get('company_name'),
                'match_percentage': round(match_result['similarity_score'] * 100, 2),
                'matched_skills': match_result['matched_skills'],
                'missing_skills': match_result['missing_skills'],
                'total_required': match_result['total_required'],
                'total_matched': match_result['total_matched']
            }
            recommendations.append(recommendation)
        
        # Sort by match percentage
        recommendations.sort(key=lambda x: x['match_percentage'], reverse=True)
        
        return recommendations
    
    def _save_model(self) -> None:
        """Save trained model for later use"""
        os.makedirs(self.model_path, exist_ok=True)
        
        model_data = {
            'skill_embeddings': self.skill_embeddings,
            'skill_index': self.skill_index,
            'skill_list': self.skill_list,
            'similarity_matrix': self.similarity_matrix,
            'embeddings_matrix': self.embeddings_matrix
        }
        
        with open(os.path.join(self.model_path, 'skill_matcher_model.pkl'), 'wb') as f:
            pickle.dump(model_data, f)
        
        # Save vectorizer separately
        if self.tfidf_vectorizer:
            with open(os.path.join(self.model_path, 'tfidf_vectorizer.pkl'), 'wb') as f:
                pickle.dump(self.tfidf_vectorizer, f)
        
        print(f"💾 Model saved to {self.model_path}")
    
    def load_model(self) -> bool:
        """Load pre-trained model"""
        model_file = os.path.join(self.model_path, 'skill_matcher_model.pkl')
        vectorizer_file = os.path.join(self.model_path, 'tfidf_vectorizer.pkl')
        
        if not os.path.exists(model_file):
            return False
        
        try:
            with open(model_file, 'rb') as f:
                model_data = pickle.load(f)
            
            self.skill_embeddings = model_data['skill_embeddings']
            self.skill_index = model_data['skill_index']
            self.skill_list = model_data['skill_list']
            self.similarity_matrix = model_data['similarity_matrix']
            self.embeddings_matrix = model_data['embeddings_matrix']
            
            if os.path.exists(vectorizer_file):
                with open(vectorizer_file, 'rb') as f:
                    self.tfidf_vectorizer = pickle.load(f)
            
            print(f"📁 Model loaded from {self.model_path}")
            return True
            
        except Exception as e:
            self.logger.error(f"Error loading model: {e}")
            return False
    
    def update_model_with_new_data(self, new_jobs: List[Dict]) -> None:
        """Incrementally update model with new job data"""
        print("🔄 Updating model with new job data...")
        
        # Extract new skills
        new_skills = []
        for job in new_jobs:
            for skill in job.get('skills', []):
                clean_skill = self._clean_skill(skill)
                if clean_skill not in self.skill_index:
                    new_skills.append(clean_skill)
        
        if new_skills:
            print(f"📈 Adding {len(new_skills)} new skills to model")
            
            # Re-train with combined data (in production, use incremental learning)
            all_jobs = new_jobs  # In practice, combine with existing training data
            self.train_on_job_data(all_jobs)
        else:
            print("✅ No new skills found, model up to date")