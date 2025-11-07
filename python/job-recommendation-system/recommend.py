"""
Core Job Recommendation Engine for SIKAP
Handles all ML/NLP logic, data processing, and recommendation algorithms
"""
import os
import sys

if os.name == 'nt':  
    import codecs
    sys.stdout = codecs.getwriter('utf-8')(sys.stdout.detach())
    sys.stderr = codecs.getwriter('utf-8')(sys.stderr.detach())

import mysql.connector as mysql
import pandas as pd
import numpy as np
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.metrics.pairwise import cosine_similarity
import re
from typing import Dict, List, Optional, Tuple, Any
from functools import lru_cache

# Import configuration
from config import DB_CONFIG

class JobRecommendationEngine:
    """Main recommendation engine class"""
    
    def __init__(self):
        """Initialize with database-driven skill normalization and caching"""
        self.vectorizer = None
        self.esco_skills = {}
        self.esco_aliases = {}
        self.skill_aliases = {}
        self.esco_skill_map = {}
        self.skill_categories = {}
        self.esco_occupation_skills = {}
        self.esco_skill_frequencies = {}
        
        # ADD THESE MISSING CACHE VARIABLES:
        import time
        self._jobs_cache = None
        self._jobs_cache_time = 0
        self._cache_duration = 300  # 5 minutes
        
        # FIXED: Safe print for Windows
        try:
            print(f"🔧 Using database: {DB_CONFIG['host']}/{DB_CONFIG['database']}")
        except UnicodeEncodeError:
            print(f"Using database: {DB_CONFIG['host']}/{DB_CONFIG['database']}")
        
        # Load normalization data from database
        self.load_skill_normalization_data()
        self._load_esco_data()
        self.load_skill_categories_from_db()
    
    def _get_db_connection(self):
        """Get database connection using shared config"""
        return mysql.connect(**DB_CONFIG)
    
    def _load_esco_data(self):
        """Load ESCO skills and aliases for skill normalization"""
        try:
            conn = self._get_db_connection()
            cur = conn.cursor(dictionary=True)
            
            # Load ESCO skills
            try:
                cur.execute("SELECT id, skill_name, concept_uri FROM esco_skills LIMIT 1000")
                self.esco_skills = {
                    row["id"]: {"name": row["skill_name"], "uri": row["concept_uri"]} 
                    for row in cur.fetchall()
                }
            except Exception as e:
                print(f"ESCO skills table issue: {e}")
                self.esco_skills = {}
                
            # Load ESCO aliases
            try:
                cur.execute("SELECT alias, skill_id FROM esco_skill_aliases LIMIT 1000")
                self.esco_aliases = {
                    row["alias"].lower(): row["skill_id"] 
                    for row in cur.fetchall()
                }
            except Exception as e:
                print(f"ESCO aliases table issue: {e}")
                self.esco_aliases = {}
                
            conn.close()
            print(f"Loaded {len(self.esco_skills)} ESCO skills, {len(self.esco_aliases)} aliases")
            
        except Exception as e:
            print(f"Could not load ESCO data: {e}")
            self.esco_skills = {}
            self.esco_aliases = {}
    
    def load_skill_normalization_data(self):
        """Load skill normalization data from database"""
        conn = self._get_db_connection()
        try:
            # Load skill aliases from skills_dictionary and skill_aliases
            try:
                alias_query = """
                    SELECT sa.alias, sd.skill_name as standard_name
                    FROM skill_aliases sa
                    JOIN skills_dictionary sd ON sa.skill_id = sd.id
                    LIMIT 500
                """
                alias_df = pd.read_sql(alias_query, conn)
                
                # Create alias mapping
                self.skill_aliases = {}
                for _, row in alias_df.iterrows():
                    self.skill_aliases[row['alias'].lower().strip()] = row['standard_name'].lower().strip()
            except Exception as e:
                print(f"Skills dictionary empty or error: {e}")
                self.skill_aliases = {}
            
            # Load ESCO skill aliases
            try:
                esco_alias_query = """
                    SELECT esa.alias, es.skill_name as standard_name
                    FROM esco_skill_aliases esa
                    JOIN esco_skills es ON esa.skill_id = es.id
                    LIMIT 500
                """
                esco_alias_df = pd.read_sql(esco_alias_query, conn)
                
                # Add ESCO aliases to mapping
                for _, row in esco_alias_df.iterrows():
                    self.skill_aliases[row['alias'].lower().strip()] = row['standard_name'].lower().strip()
            except Exception as e:
                print(f"ESCO aliases empty or error: {e}")
            
            # Load manual to ESCO mapping
            try:
                manual_esco_query = """
                    SELECT sd.skill_name as manual_skill, es.skill_name as esco_skill, 
                           mte.confidence_level
                    FROM manual_to_esco mte
                    JOIN skills_dictionary sd ON mte.manual_skill_id = sd.id
                    JOIN esco_skills es ON mte.esco_skill_id = es.id
                    WHERE mte.confidence_level >= 0.8
                    LIMIT 200
                """
                manual_esco_df = pd.read_sql(manual_esco_query, conn)
                
                # Add manual to ESCO mapping
                for _, row in manual_esco_df.iterrows():
                    self.skill_aliases[row['manual_skill'].lower().strip()] = row['esco_skill'].lower().strip()
            except Exception as e:
                print(f"Manual to ESCO mapping empty or error: {e}")
            
            print(f"Loaded {len(self.skill_aliases)} skill aliases from database")
            
            # Fallback to critical mappings if database is empty
            if len(self.skill_aliases) == 0:
                print("Using fallback skill mappings (sector-neutral)")
                self.skill_aliases = {
                    # TECHNOLOGY (balanced representation)
                    'js': 'javascript',
                    'javascript programming': 'javascript',
                    'python programming': 'python',
                    'sql database': 'sql',
                    'html5': 'html',
                    'css3': 'css',
                    
                    # HEALTHCARE
                    'patient care': 'patient care',
                    'medical care': 'patient care',
                    'nursing care': 'nursing',
                    'clinical skills': 'clinical assessment',
                    'medical coding': 'medical coding',
                    'healthcare administration': 'healthcare management',
                    
                    # FINANCE & BUSINESS
                    'financial analysis': 'financial analysis',
                    'accounting skills': 'accounting',
                    'book keeping': 'bookkeeping',
                    'customer service': 'customer service',
                    'client relations': 'customer service',
                    'sales skills': 'sales',
                    'business development': 'business development',
                    
                    # EDUCATION & TRAINING
                    'teaching skills': 'teaching',
                    'classroom management': 'classroom management',
                    'curriculum development': 'curriculum planning',
                    'student assessment': 'assessment',
                    'educational planning': 'lesson planning',
                    
                    # ENGINEERING & TECHNICAL (Non-IT)
                    'project management': 'project management',
                    'quality control': 'quality assurance',
                    'safety protocols': 'safety management',
                    'technical documentation': 'documentation',
                    'equipment maintenance': 'maintenance',
                    
                    # HOSPITALITY & SERVICE
                    'food service': 'food service',
                    'hospitality management': 'hospitality',
                    'event planning': 'event management',
                    'guest services': 'customer service',
                    
                    # GENERAL PROFESSIONAL SKILLS
                    'communication skills': 'communication',
                    'team work': 'teamwork',
                    'leadership skills': 'leadership',
                    'time management': 'time management',
                    'problem solving': 'problem solving',
                    'data analysis': 'data analytics',
                    'report writing': 'reporting',
                    'microsoft office': 'office software'
                }
            
        except Exception as e:
            print(f"Error loading skill normalization data: {e}")
            # FIXED: Minimal fallback that's SECTOR NEUTRAL
            self.skill_aliases = {
                # Essential cross-sector skills only
                'communication skills': 'communication',
                'customer service': 'customer service',
                'team work': 'teamwork',
                'data analysis': 'data analytics',
                'project management': 'project management',
                'problem solving': 'problem solving',
                'microsoft office': 'office software',
                'time management': 'time management'
            }
        finally:
            conn.close()
    
    def load_skill_categories_from_db(self):
        """Load skill categories from database for enhanced matching"""
        conn = self._get_db_connection()
        try:
            # Load skill categories
            category_query = """
                SELECT DISTINCT category 
                FROM skills_dictionary 
                WHERE category IS NOT NULL
            """
            categories_df = pd.read_sql(category_query, conn)
            
            # Load skills by category
            skills_by_category_query = """
                SELECT sd.skill_name, sd.category,
                       GROUP_CONCAT(DISTINCT sa.alias SEPARATOR '|') as aliases
                FROM skills_dictionary sd
                LEFT JOIN skill_aliases sa ON sd.id = sa.skill_id
                WHERE sd.category IS NOT NULL
                GROUP BY sd.id, sd.skill_name, sd.category
            """
            skills_df = pd.read_sql(skills_by_category_query, conn)
            
            # Build category mapping
            self.skill_categories = {}
            for _, row in skills_df.iterrows():
                category = row['category'].lower().replace(' & ', '_').replace(' ', '_')
                skill = row['skill_name'].lower()
                
                if category not in self.skill_categories:
                    self.skill_categories[category] = set()
                
                self.skill_categories[category].add(skill)
                
                # Add aliases
                if row['aliases']:
                    aliases = row['aliases'].split('|')
                    for alias in aliases:
                        self.skill_categories[category].add(alias.lower().strip())
            
            print(f"Loaded {len(self.skill_categories)} skill categories from database")
            for cat, skills in self.skill_categories.items():
                print(f"   {cat}: {len(skills)} skills")
                
        except Exception as e:
            print(f"Could not load categories from database: {e}")
            self.skill_categories = {}
        finally:
            conn.close()

    def load_esco_occupation_skills(self):
        """Load ESCO occupation-skill relationships for job title matching"""
        conn = self._get_db_connection()
        try:
            esco_query = """
                SELECT 
                    eo.occupation_name,
                    es.skill_name,
                    eos.relation_type
                FROM esco_occupations eo
                JOIN esco_occupation_skills eos ON eo.id = eos.occupation_id
                JOIN esco_skills es ON eos.skill_id = es.id
                WHERE eos.relation_type = 'essential'
                LIMIT 5000
            """
            
            esco_df = pd.read_sql(esco_query, conn)
            
            # Build occupation to skills mapping
            self.esco_occupation_skills = {}
            for _, row in esco_df.iterrows():
                occupation = row['occupation_name'].lower()
                skill = row['skill_name'].lower()
                
                if occupation not in self.esco_occupation_skills:
                    self.esco_occupation_skills[occupation] = set()
                
                self.esco_occupation_skills[occupation].add(skill)
            
            print(f"Loaded {len(self.esco_occupation_skills)} ESCO occupations with skills")
            
        except Exception as e:
            print(f"Could not load ESCO occupation skills: {e}")
            self.esco_occupation_skills = {}
        finally:
            conn.close()

    def categorize_skills_from_db(self, skills_text: str) -> Dict[str, int]:
        """Categorize skills based on database categories"""
        if not skills_text or not self.skill_categories:
            return {}
        
        skills_lower = skills_text.lower()
        skill_tokens = self.extract_skill_tokens_db(skills_text)
        
        categories_found = {}
        
        # Check each category for skill matches
        for category, category_skills in self.skill_categories.items():
            matches = 0
            
            # Direct skill matches
            for skill_token in skill_tokens:
                if skill_token in category_skills:
                    matches += 1
            
            # Partial matches in text
            for category_skill in category_skills:
                if category_skill in skills_lower:
                    matches += 1
            
            if matches > 0:
                categories_found[category] = matches
        
        return categories_found

    def fetch_job_posts(self) -> pd.DataFrame:
        """Fetch all available job posts with BETTER skill extraction"""
        conn = self._get_db_connection()
        try:
            query = """
                SELECT 
                    jp.job_id as id,
                    jp.job_title as title,
                    jp.full_description as description,
                    jp.location,
                    GROUP_CONCAT(DISTINCT jps.skill_name SEPARATOR ', ') as skills_text
                FROM job_post jp 
                LEFT JOIN job_post_skills jps ON jp.job_id = jps.job_id
                WHERE jp.job_status = 'open'
                GROUP BY jp.job_id, jp.job_title, jp.full_description, jp.location
                ORDER BY jp.job_id
            """
            df = pd.read_sql(query, conn)
            
            # Debug job skills
            print(f"Fetched {len(df)} job posts")
            for i, job in df.head(3).iterrows():
                print(f"   Job {job['id']}: {job['title']} - Skills: {job['skills_text']}")
            
            return df
            
        except Exception as e:
            print(f"Error fetching job posts: {e}")
            return pd.DataFrame(columns=['id', 'title', 'description', 'location', 'skills_text'])
        finally:
            conn.close()
    
    def normalize_text(self, text: str) -> str:
        """Normalize text for TF-IDF processing"""
        if text is None:
            return ""
        text = str(text).lower()
        text = re.sub(r"[,/|]", " ", text)
        text = re.sub(r"[^a-z0-9+\.# ]+", " ", text)
        text = re.sub(r"\s+", " ", text).strip()
        return text
    
    def normalize_skill_name_db(self, skill_text: str) -> str:
        """Database-driven skill normalization"""
        if not skill_text:
            return ""
        
        # Convert to lowercase and clean
        skill = str(skill_text).lower().strip()
        
        # Remove proficiency levels - KEY FIX
        proficiency_levels = ['beginner', 'intermediate', 'advanced', 'expert', 'basic', 'senior', 'junior']
        for level in proficiency_levels:
            skill = skill.replace(f" ({level})", "").replace(f"({level})", "").replace(level, "").strip()
        
        # Remove extra parentheses and spaces
        skill = re.sub(r'\s+', ' ', skill.replace("()", "")).strip()
        
        # Check database aliases first
        if skill in self.skill_aliases:
            return self.skill_aliases[skill]
        
        # Check partial matches in database
        for alias, standard in self.skill_aliases.items():
            if alias in skill or skill in alias:
                # Only if they're reasonably similar in length
                if abs(len(alias) - len(skill)) <= 3:
                    return standard
        
        return skill.strip()
    
    def extract_skill_tokens_db(self, skill_text: str) -> set:
        """Extract and normalize skill tokens using database"""
        if not skill_text:
            return set()
        
        # Split by common delimiters
        tokens = re.split(r"[,/|;]+", str(skill_text))
        normalized_skills = set()
        
        for token in tokens:
            # Use database-driven normalization
            normalized = self.normalize_skill_name_db(token)
            if normalized and len(normalized) > 1:
                normalized_skills.add(normalized)
                
                # Also add partial matches for compound skills
                if ' ' in normalized:
                    words = normalized.split()
                    for word in words:
                        if len(word) > 2:
                            normalized_skills.add(word)
        
        return normalized_skills
    
    def extract_skill_tokens(self, skill_text: str) -> set:
        """Extract skill tokens - calls database version"""
        return self.extract_skill_tokens_db(skill_text)
    
    def normalize_to_esco(self, skill_text: str) -> set:
        """Convert skills to ESCO URIs for standardized matching"""
        if not skill_text:
            return set()
        
        esco_uris = set()
        skills = str(skill_text).split(',')
        
        for skill in skills:
            skill_clean = skill.strip().lower()
            
            # Check if skill exists in ESCO aliases
            if skill_clean in self.esco_aliases:
                skill_id = self.esco_aliases[skill_clean]
                if skill_id in self.esco_skills:
                    esco_uris.add(self.esco_skills[skill_id]["uri"])
            
            # Also check direct ESCO skills
            for skill_id, skill_data in self.esco_skills.items():
                if skill_clean in skill_data["name"].lower():
                    esco_uris.add(skill_data["uri"])
        
        return esco_uris

    def get_esco_skills_for_text(self, text: str) -> set:
        """Extract ESCO skills from text"""
        if not text or not hasattr(self, 'esco_skills'):
            return set()
        
        text_lower = text.lower()
        found_esco_skills = set()
        
        # Check direct ESCO skill matches
        for skill_id, skill_data in self.esco_skills.items():
            skill_name = skill_data["name"].lower()
            if skill_name in text_lower:
                found_esco_skills.add(skill_name)
        
        # Check ESCO aliases
        for alias, skill_id in self.esco_aliases.items():
            if alias in text_lower and skill_id in self.esco_skills:
                found_esco_skills.add(self.esco_skills[skill_id]["name"].lower())
        
        return found_esco_skills

    def compute_semantic_skill_similarity(self, js_skills: set, job_skills: set) -> float:
        """Compute semantic similarity between skills using database relationships"""
        if not js_skills or not job_skills:
            return 0.0
        
        semantic_matches = 0
        
        for js_skill in js_skills:
            for job_skill in job_skills:
                # Check if skills are semantically related through aliases
                js_normalized = self.normalize_skill_name_db(js_skill)
                job_normalized = self.normalize_skill_name_db(job_skill)
                
                if js_normalized == job_normalized:
                    semantic_matches += 1
                    break
                elif self.are_skills_related(js_skill, job_skill):
                    semantic_matches += 0.7
                    break
        
        return semantic_matches / len(js_skills)

    def are_skills_related(self, skill1: str, skill2: str) -> bool:
        """Check if two skills are related through database mappings"""
        # Check if they share common aliases or normalizations
        skill1_variants = {skill1.lower(), self.normalize_skill_name_db(skill1)}
        skill2_variants = {skill2.lower(), self.normalize_skill_name_db(skill2)}
        
        # Add aliases from database
        for alias, standard in self.skill_aliases.items():
            if standard == skill1.lower():
                skill1_variants.add(alias)
            if standard == skill2.lower():
                skill2_variants.add(alias)
        
        # Check for overlap
        return bool(skill1_variants & skill2_variants)

    def compute_skill_level_compatibility(self, jobseeker_skills: str, job_skills: str) -> float:
        """Compute compatibility based on skill levels (if specified)"""
        # This is a simplified version - you can enhance based on your skill level data
        js_has_advanced = any(level in jobseeker_skills.lower() for level in ['advanced', 'expert', 'senior'])
        js_has_beginner = any(level in jobseeker_skills.lower() for level in ['beginner', 'basic', 'junior'])
        
        job_requires_advanced = any(level in job_skills.lower() for level in ['advanced', 'expert', 'senior'])
        job_accepts_beginner = any(level in job_skills.lower() for level in ['beginner', 'basic', 'entry'])
        
        if job_requires_advanced and js_has_advanced:
            return 1.0
        elif not job_requires_advanced and not js_has_beginner:
            return 0.8
        elif job_accepts_beginner:
            return 0.9
        else:
            return 0.5

    def infer_categories_from_education(self, education_text: str) -> Dict[str, float]:
        """Enhanced education to category mapping with more specificity"""
        education_to_category = {
            # Technical fields
            'computer science': {'it_programming': 3.0, 'data_analytics_research': 2.0},
            'information technology': {'it_programming': 3.0, 'engineering': 1.0},
            'data science': {'data_analytics_research': 3.0, 'it_programming': 2.0},
            'software engineering': {'it_programming': 3.0, 'engineering': 2.0},
            'computer engineering': {'it_programming': 2.0, 'engineering': 3.0},
            
            # Healthcare (should NOT match with IT)
            'nursing': {'healthcare_medical': 3.0},
            'medicine': {'healthcare_medical': 3.0, 'science_laboratory': 1.0},
            'medical': {'healthcare_medical': 3.0},
            
            # Business fields
            'business': {'business_management': 3.0, 'soft_skills': 1.0},
            'management': {'business_management': 3.0, 'soft_skills': 1.0},
            'accounting': {'finance_banking': 3.0, 'business_management': 1.0},
            'finance': {'finance_banking': 3.0, 'business_management': 1.0},
            'marketing': {'media_communications': 2.0, 'business_management': 1.0},
            
            # Engineering (separate from IT)
            'mechanical engineering': {'engineering': 3.0},
            'civil engineering': {'engineering': 3.0},
            'electrical engineering': {'engineering': 3.0, 'it_programming': 0.5},
            
            # Education and others
            'education': {'education_training': 3.0, 'soft_skills': 1.0},
            'psychology': {'soft_skills': 2.0, 'healthcare_medical': 0.5},
            'design': {'design_creative': 3.0}
        }
        
        education_lower = education_text.lower()
        inferred_categories = {}
        
        for edu_field, categories in education_to_category.items():
            if edu_field in education_lower:
                for category, weight in categories.items():
                    inferred_categories[category] = inferred_categories.get(category, 0) + weight
        
        return inferred_categories
    
    def compute_tfidf_similarity(self, jobs_df: pd.DataFrame, jobseeker_query: str) -> np.ndarray:
        """Compute TF-IDF similarity between jobseeker and jobs"""
        # Build job documents
        jobs_df["doc"] = (
            jobs_df["title"].fillna("") + " " +
            jobs_df["description"].fillna("") + " " +
            jobs_df["location"].fillna("") + " " +
            jobs_df["skills_text"].fillna("")
        ).apply(self.normalize_text)
        
        # Normalize jobseeker query
        normalized_query = self.normalize_text(jobseeker_query)
        
        # TF-IDF
        self.vectorizer = TfidfVectorizer(ngram_range=(1,2), min_df=1, max_features=5000)
        job_vectors = self.vectorizer.fit_transform(jobs_df["doc"].values)
        query_vector = self.vectorizer.transform([normalized_query])
        
        # Compute similarities
        similarities = cosine_similarity(query_vector, job_vectors).flatten()
        
        print(f"🔍 TF-IDF computed for {len(jobs_df)} jobs")
        return similarities
    
    def compute_skill_overlap(self, jobs_df: pd.DataFrame, jobseeker_skills: str) -> Tuple[pd.Series, pd.Series]:
        """Compute skill overlap between jobseeker and jobs"""
        js_skill_tokens = self.extract_skill_tokens(jobseeker_skills)
        
        def calculate_overlap(job_skills):
            job_tokens = self.extract_skill_tokens(job_skills)
            overlap = job_tokens & js_skill_tokens
            ratio = len(overlap) / max(len(js_skill_tokens), 1) if js_skill_tokens else 0
            return overlap, ratio
        
        overlaps, ratios = zip(*jobs_df["skills_text"].apply(calculate_overlap))
        
        return pd.Series(list(overlaps)), pd.Series(list(ratios))
    
    def compute_enhanced_skill_overlap_db(self, jobs_df: pd.DataFrame, jobseeker_skills: str) -> Tuple[pd.Series, pd.Series]:
        """Enhanced skill overlap using database normalization"""
        js_skill_tokens = self.extract_skill_tokens_db(jobseeker_skills)
        
        print(f"Jobseeker normalized skills (DB): {sorted(js_skill_tokens)}")
        
        def calculate_enhanced_overlap(job_skills):
            job_tokens = self.extract_skill_tokens_db(job_skills)
            
            # Direct matches
            direct_overlap = job_tokens & js_skill_tokens
            
            # Enhanced fuzzy matching using database relationships
            fuzzy_matches = set()
            for js_skill in js_skill_tokens:
                for job_skill in job_tokens:
                    # Check if skills are related through database mappings
                    js_normalized = self.normalize_skill_name_db(js_skill)
                    job_normalized = self.normalize_skill_name_db(job_skill)
                    
                    if js_normalized == job_normalized:
                        fuzzy_matches.add(f"{js_skill}~{job_skill}")
                    elif (js_skill in job_skill or job_skill in js_skill) and abs(len(js_skill) - len(job_skill)) <= 3:
                        fuzzy_matches.add(f"{js_skill}~{job_skill}")
            
            # Combine matches
            total_matches = direct_overlap | fuzzy_matches
            
            # Calculate ratio
            js_match_count = len(direct_overlap) + (len(fuzzy_matches) * 0.8)
            ratio = js_match_count / max(len(js_skill_tokens), 1) if js_skill_tokens else 0
            
            return total_matches, min(ratio, 1.0)
        
        overlaps, ratios = zip(*jobs_df["skills_text"].apply(calculate_enhanced_overlap))
        
        return pd.Series(list(overlaps)), pd.Series(list(ratios))
    
    def fetch_jobseeker_profile(self, jobseeker_id: int) -> Optional[pd.Series]:
        """Fetch jobseeker profile with FIXED skill processing"""
        conn = self._get_db_connection()
        try:
            # Basic info
            jobseeker_query = """
                SELECT 
                    j.jobseeker_id as id,
                    CONCAT(j.first_name, ' ', j.last_name) as full_name,
                    COALESCE(j.address, '') as location
                FROM jobseeker j
                WHERE j.jobseeker_id = %s
                LIMIT 1
            """
            
            df = pd.read_sql(jobseeker_query, conn, params=(int(jobseeker_id),))
            if df.empty:
                return None
                
            profile = df.iloc[0].to_dict()
            
            # FIXED: Better skills query with debugging
            skills_query = """
                SELECT skill_name, proficiency_level 
                FROM jobseeker_skills 
                WHERE jobseeker_id = %s
            """
            skills_df = pd.read_sql(skills_query, conn, params=(int(jobseeker_id),))
            
            print(f"🔍 Raw skills query result: {len(skills_df)} skills found", file=sys.stderr)
            
            if not skills_df.empty:
                # Extract skill names and normalize them
                raw_skills = []
                normalized_skills = []
                
                for _, skill_row in skills_df.iterrows():
                    skill_name = skill_row['skill_name']
                    raw_skills.append(f"{skill_name} ({skill_row['proficiency_level']})")
                    
                    # Normalize skill (remove proficiency)
                    normalized = self.normalize_skill_name_db(skill_name)
                    if normalized:
                        normalized_skills.append(normalized)
                
                profile['raw_skills_text'] = ', '.join(raw_skills)
                profile['skills_text'] = ', '.join(normalized_skills)
                
                print(f"   Raw skills: {profile['raw_skills_text']}", file=sys.stderr)
                print(f"   Normalized: {profile['skills_text']}", file=sys.stderr)
            else:
                profile['raw_skills_text'] = ''
                profile['skills_text'] = ''
                print("No skills found in database!", file=sys.stderr)
            
            # Experience
            exp_query = """
                SELECT GROUP_CONCAT(
                    CONCAT(job_title, ' at ', company_name, '. ', COALESCE(responsibilities, ''))
                    SEPARATOR '. '
                ) as experience_text
                FROM jobseeker_work_experience 
                WHERE jobseeker_id = %s
            """
            exp_df = pd.read_sql(exp_query, conn, params=(int(jobseeker_id),))
            profile['experience_text'] = exp_df.iloc[0]['experience_text'] if not exp_df.empty and exp_df.iloc[0]['experience_text'] else ''
            
            # Education
            edu_query = """
                SELECT GROUP_CONCAT(
                    CONCAT(education_level, ' in ', COALESCE(field_of_study, ''), ' from ', school_name)
                    SEPARATOR '. '
                ) as education_text
                FROM jobseeker_education 
                WHERE jobseeker_id = %s
            """
            edu_df = pd.read_sql(edu_query, conn, params=(int(jobseeker_id),))
            profile['education_text'] = edu_df.iloc[0]['education_text'] if not edu_df.empty and edu_df.iloc[0]['education_text'] else ''
            
            print(f"Jobseeker {jobseeker_id}: {profile['full_name']}")
            print(f"   Raw skills: {profile['raw_skills_text']}")
            print(f"   Normalized: {profile['skills_text']}")
            
            return pd.Series(profile)
            
        except Exception as e:
            print(f"Error fetching jobseeker {jobseeker_id}: {e}")
            return None
        finally:
            conn.close()
    
    def fetch_jobseeker_profile_optimized(self, jobseeker_id: int) -> Optional[pd.Series]:
        """OPTIMIZED: Single query instead of 4 separate queries"""
        conn = self._get_db_connection()
        try:
            # Single comprehensive query - MAJOR PERFORMANCE BOOST
            query = """
            SELECT 
                j.jobseeker_id as id,
                CONCAT(j.first_name, ' ', j.last_name) as full_name,
                COALESCE(j.address, '') as location,
                
                -- Skills in one go
                GROUP_CONCAT(DISTINCT 
                    CASE WHEN js.skill_name IS NOT NULL 
                    THEN CONCAT(js.skill_name, ':', COALESCE(js.proficiency_level, 'basic'))
                    END SEPARATOR '|'
                ) as skills_data,
                
                -- Experience in one go  
                GROUP_CONCAT(DISTINCT 
                    CASE WHEN jwe.job_title IS NOT NULL
                    THEN CONCAT(jwe.job_title, ' at ', jwe.company_name)
                    END SEPARATOR '|'
                ) as experience_data,
                
                -- Education in one go
                GROUP_CONCAT(DISTINCT 
                    CASE WHEN je.education_level IS NOT NULL
                    THEN CONCAT(je.education_level, ' in ', COALESCE(je.field_of_study, 'General'), ' from ', je.school_name)
                    END SEPARATOR '|'
                ) as education_data
                
            FROM jobseeker j
            LEFT JOIN jobseeker_skills js ON j.jobseeker_id = js.jobseeker_id
            LEFT JOIN jobseeker_work_experience jwe ON j.jobseeker_id = jwe.jobseeker_id  
            LEFT JOIN jobseeker_education je ON j.jobseeker_id = je.jobseeker_id
            WHERE j.jobseeker_id = %s
            GROUP BY j.jobseeker_id, j.first_name, j.last_name, j.address
            """
            
            df = pd.read_sql(query, conn, params=(int(jobseeker_id),))
            if df.empty:
                return None
                
            profile = df.iloc[0].to_dict()
            
            # Process skills efficiently
            if profile.get('skills_data'):
                skills_list = []
                for skill_data in profile['skills_data'].split('|'):
                    if ':' in skill_data:
                        skill_name = skill_data.split(':')[0]
                        normalized = self.normalize_skill_name_db(skill_name)
                        if normalized:
                            skills_list.append(normalized)
                profile['skills_text'] = ', '.join(skills_list)
            else:
                profile['skills_text'] = ''
                
            # Process other fields
            profile['experience_text'] = profile.get('experience_data', '').replace('|', '. ') if profile.get('experience_data') else ''
            profile['education_text'] = profile.get('education_data', '').replace('|', '. ') if profile.get('education_data') else ''
            
            return pd.Series(profile)
            
        finally:
            conn.close()

    def fetch_job_posts_optimized(self) -> pd.DataFrame:
        """OPTIMIZED: Limit data and add performance hints"""
        conn = self._get_db_connection()
        try:
            query = """
            SELECT 
                jp.job_id as id,
                jp.job_title as title,
                LEFT(jp.full_description, 300) as description,  -- Limit description length
                jp.location,
                jp.created_at,
                GROUP_CONCAT(DISTINCT jps.skill_name ORDER BY jps.skill_name SEPARATOR ', ') as skills_text,
                COUNT(DISTINCT jps.skill_name) as skill_count
            FROM job_post jp 
            LEFT JOIN job_post_skills jps ON jp.job_id = jps.job_id
            WHERE jp.job_status = 'open' 
              AND jp.created_at >= DATE_SUB(NOW(), INTERVAL 6 MONTH)  -- Only recent jobs
            GROUP BY jp.job_id, jp.job_title, jp.full_description, jp.location, jp.created_at
            HAVING skill_count > 0  -- Only jobs with skills
            ORDER BY jp.created_at DESC
            LIMIT 100  -- Reasonable limit for testing
            """
            
            df = pd.read_sql(query, conn)
            print(f"✅ Fetched {len(df)} optimized job posts")
            return df
            
        finally:
            conn.close()
    
    def normalize_text(self, text: str) -> str:
        """Normalize text for TF-IDF processing"""
        if text is None:
            return ""
        text = str(text).lower()
        text = re.sub(r"[,/|]", " ", text)
        text = re.sub(r"[^a-z0-9+\.# ]+", " ", text)
        text = re.sub(r"\s+", " ", text).strip()
        return text
    
    def normalize_skill_name_db(self, skill_text: str) -> str:
        """Database-driven skill normalization"""
        if not skill_text:
            return ""
        
        # Convert to lowercase and clean
        skill = str(skill_text).lower().strip()
        
        # Remove proficiency levels - KEY FIX
        proficiency_levels = ['beginner', 'intermediate', 'advanced', 'expert', 'basic', 'senior', 'junior']
        for level in proficiency_levels:
            skill = skill.replace(f" ({level})", "").replace(f"({level})", "").replace(level, "").strip()
        
        # Remove extra parentheses and spaces
        skill = re.sub(r'\s+', ' ', skill.replace("()", "")).strip()
        
        # Check database aliases first
        if skill in self.skill_aliases:
            return self.skill_aliases[skill]
        
        # Check partial matches in database
        for alias, standard in self.skill_aliases.items():
            if alias in skill or skill in alias:
                # Only if they're reasonably similar in length
                if abs(len(alias) - len(skill)) <= 3:
                    return standard
        
        return skill.strip()
    
    def extract_skill_tokens_db(self, skill_text: str) -> set:
        """Extract and normalize skill tokens using database"""
        if not skill_text:
            return set()
        
        # Split by common delimiters
        tokens = re.split(r"[,/|;]+", str(skill_text))
        normalized_skills = set()
        
        for token in tokens:
            # Use database-driven normalization
            normalized = self.normalize_skill_name_db(token)
            if normalized and len(normalized) > 1:
                normalized_skills.add(normalized)
                
                # Also add partial matches for compound skills
                if ' ' in normalized:
                    words = normalized.split()
                    for word in words:
                        if len(word) > 2:
                            normalized_skills.add(word)
        
        return normalized_skills
    
    def extract_skill_tokens(self, skill_text: str) -> set:
        """Extract skill tokens - calls database version"""
        return self.extract_skill_tokens_db(skill_text)
    
    def normalize_to_esco(self, skill_text: str) -> set:
        """Convert skills to ESCO URIs for standardized matching"""
        if not skill_text:
            return set()
        
        esco_uris = set()
        skills = str(skill_text).split(',')
        
        for skill in skills:
            skill_clean = skill.strip().lower()
            
            # Check if skill exists in ESCO aliases
            if skill_clean in self.esco_aliases:
                skill_id = self.esco_aliases[skill_clean]
                if skill_id in self.esco_skills:
                    esco_uris.add(self.esco_skills[skill_id]["uri"])
            
            # Also check direct ESCO skills
            for skill_id, skill_data in self.esco_skills.items():
                if skill_clean in skill_data["name"].lower():
                    esco_uris.add(skill_data["uri"])
        
        return esco_uris

    def get_esco_skills_for_text(self, text: str) -> set:
        """Extract ESCO skills from text"""
        if not text or not hasattr(self, 'esco_skills'):
            return set()
        
        text_lower = text.lower()
        found_esco_skills = set()
        
        # Check direct ESCO skill matches
        for skill_id, skill_data in self.esco_skills.items():
            skill_name = skill_data["name"].lower()
            if skill_name in text_lower:
                found_esco_skills.add(skill_name)
        
        # Check ESCO aliases
        for alias, skill_id in self.esco_aliases.items():
            if alias in text_lower and skill_id in self.esco_skills:
                found_esco_skills.add(self.esco_skills[skill_id]["name"].lower())
        
        return found_esco_skills

    def compute_semantic_skill_similarity(self, js_skills: set, job_skills: set) -> float:
        """Compute semantic similarity between skills using database relationships"""
        if not js_skills or not job_skills:
            return 0.0
        
        semantic_matches = 0
        
        for js_skill in js_skills:
            for job_skill in job_skills:
                # Check if skills are semantically related through aliases
                js_normalized = self.normalize_skill_name_db(js_skill)
                job_normalized = self.normalize_skill_name_db(job_skill)
                
                if js_normalized == job_normalized:
                    semantic_matches += 1
                    break
                elif self.are_skills_related(js_skill, job_skill):
                    semantic_matches += 0.7
                    break
        
        return semantic_matches / len(js_skills)

    def are_skills_related(self, skill1: str, skill2: str) -> bool:
        """Check if two skills are related through database mappings"""
        # Check if they share common aliases or normalizations
        skill1_variants = {skill1.lower(), self.normalize_skill_name_db(skill1)}
        skill2_variants = {skill2.lower(), self.normalize_skill_name_db(skill2)}
        
        # Add aliases from database
        for alias, standard in self.skill_aliases.items():
            if standard == skill1.lower():
                skill1_variants.add(alias)
            if standard == skill2.lower():
                skill2_variants.add(alias)
        
        # Check for overlap
        return bool(skill1_variants & skill2_variants)

    def compute_skill_level_compatibility(self, jobseeker_skills: str, job_skills: str) -> float:
        """Compute compatibility based on skill levels (if specified)"""
        # This is a simplified version - you can enhance based on your skill level data
        js_has_advanced = any(level in jobseeker_skills.lower() for level in ['advanced', 'expert', 'senior'])
        js_has_beginner = any(level in jobseeker_skills.lower() for level in ['beginner', 'basic', 'junior'])
        
        job_requires_advanced = any(level in job_skills.lower() for level in ['advanced', 'expert', 'senior'])
        job_accepts_beginner = any(level in job_skills.lower() for level in ['beginner', 'basic', 'entry'])
        
        if job_requires_advanced and js_has_advanced:
            return 1.0
        elif not job_requires_advanced and not js_has_beginner:
            return 0.8
        elif job_accepts_beginner:
            return 0.9
        else:
            return 0.5

    def infer_categories_from_education(self, education_text: str) -> Dict[str, float]:
        """Enhanced education to category mapping with more specificity"""
        education_to_category = {
            # Technical fields
            'computer science': {'it_programming': 3.0, 'data_analytics_research': 2.0},
            'information technology': {'it_programming': 3.0, 'engineering': 1.0},
            'data science': {'data_analytics_research': 3.0, 'it_programming': 2.0},
            'software engineering': {'it_programming': 3.0, 'engineering': 2.0},
            'computer engineering': {'it_programming': 2.0, 'engineering': 3.0},
            
            # Healthcare (should NOT match with IT)
            'nursing': {'healthcare_medical': 3.0},
            'medicine': {'healthcare_medical': 3.0, 'science_laboratory': 1.0},
            'medical': {'healthcare_medical': 3.0},
            
            # Business fields
            'business': {'business_management': 3.0, 'soft_skills': 1.0},
            'management': {'business_management': 3.0, 'soft_skills': 1.0},
            'accounting': {'finance_banking': 3.0, 'business_management': 1.0},
            'finance': {'finance_banking': 3.0, 'business_management': 1.0},
            'marketing': {'media_communications': 2.0, 'business_management': 1.0},
            
            # Engineering (separate from IT)
            'mechanical engineering': {'engineering': 3.0},
            'civil engineering': {'engineering': 3.0},
            'electrical engineering': {'engineering': 3.0, 'it_programming': 0.5},
            
            # Education and others
            'education': {'education_training': 3.0, 'soft_skills': 1.0},
            'psychology': {'soft_skills': 2.0, 'healthcare_medical': 0.5},
            'design': {'design_creative': 3.0}
        }
        
        education_lower = education_text.lower()
        inferred_categories = {}
        
        for edu_field, categories in education_to_category.items():
            if edu_field in education_lower:
                for category, weight in categories.items():
                    inferred_categories[category] = inferred_categories.get(category, 0) + weight
        
        return inferred_categories
    
    def compute_tfidf_similarity(self, jobs_df: pd.DataFrame, jobseeker_query: str) -> np.ndarray:
        """Compute TF-IDF similarity between jobseeker and jobs"""
        # Build job documents
        jobs_df["doc"] = (
            jobs_df["title"].fillna("") + " " +
            jobs_df["description"].fillna("") + " " +
            jobs_df["location"].fillna("") + " " +
            jobs_df["skills_text"].fillna("")
        ).apply(self.normalize_text)
        
        # Normalize jobseeker query
        normalized_query = self.normalize_text(jobseeker_query)
        
        # TF-IDF
        self.vectorizer = TfidfVectorizer(ngram_range=(1,2), min_df=1, max_features=5000)
        job_vectors = self.vectorizer.fit_transform(jobs_df["doc"].values)
        query_vector = self.vectorizer.transform([normalized_query])
        
        # Compute similarities
        similarities = cosine_similarity(query_vector, job_vectors).flatten()
        
        print(f"🔍 TF-IDF computed for {len(jobs_df)} jobs")
        return similarities
    
    def compute_skill_overlap(self, jobs_df: pd.DataFrame, jobseeker_skills: str) -> Tuple[pd.Series, pd.Series]:
        """Compute skill overlap between jobseeker and jobs"""
        js_skill_tokens = self.extract_skill_tokens(jobseeker_skills)
        
        def calculate_overlap(job_skills):
            job_tokens = self.extract_skill_tokens(job_skills)
            overlap = job_tokens & js_skill_tokens
            ratio = len(overlap) / max(len(js_skill_tokens), 1) if js_skill_tokens else 0
            return overlap, ratio
        
        overlaps, ratios = zip(*jobs_df["skills_text"].apply(calculate_overlap))
        
        return pd.Series(list(overlaps)), pd.Series(list(ratios))
    
    def compute_enhanced_skill_overlap_db(self, jobs_df: pd.DataFrame, jobseeker_skills: str) -> Tuple[pd.Series, pd.Series]:
        """Enhanced skill overlap using database normalization"""
        js_skill_tokens = self.extract_skill_tokens_db(jobseeker_skills)
        
        print(f"Jobseeker normalized skills (DB): {sorted(js_skill_tokens)}")
        
        def calculate_enhanced_overlap(job_skills):
            job_tokens = self.extract_skill_tokens_db(job_skills)
            
            # Direct matches
            direct_overlap = job_tokens & js_skill_tokens
            
            # Enhanced fuzzy matching using database relationships
            fuzzy_matches = set()
            for js_skill in js_skill_tokens:
                for job_skill in job_tokens:
                    # Check if skills are related through database mappings
                    js_normalized = self.normalize_skill_name_db(js_skill)
                    job_normalized = self.normalize_skill_name_db(job_skill)
                    
                    if js_normalized == job_normalized:
                        fuzzy_matches.add(f"{js_skill}~{job_skill}")
                    elif (js_skill in job_skill or job_skill in js_skill) and abs(len(js_skill) - len(job_skill)) <= 3:
                        fuzzy_matches.add(f"{js_skill}~{job_skill}")
            
            # Combine matches
            total_matches = direct_overlap | fuzzy_matches
            
            # Calculate ratio
            js_match_count = len(direct_overlap) + (len(fuzzy_matches) * 0.8)
            ratio = js_match_count / max(len(js_skill_tokens), 1) if js_skill_tokens else 0
            
            return total_matches, min(ratio, 1.0)
        
        overlaps, ratios = zip(*jobs_df["skills_text"].apply(calculate_enhanced_overlap))
        
        return pd.Series(list(overlaps)), pd.Series(list(ratios))
    
    def fetch_jobseeker_profile(self, jobseeker_id: int) -> Optional[pd.Series]:
        """Fetch jobseeker profile with FIXED skill processing"""
        conn = self._get_db_connection()
        try:
            # Basic info
            jobseeker_query = """
                SELECT 
                    j.jobseeker_id as id,
                    CONCAT(j.first_name, ' ', j.last_name) as full_name,
                    COALESCE(j.address, '') as location
                FROM jobseeker j
                WHERE j.jobseeker_id = %s
                LIMIT 1
            """
            
            df = pd.read_sql(jobseeker_query, conn, params=(int(jobseeker_id),))
            if df.empty:
                return None
                
            profile = df.iloc[0].to_dict()
            
            # FIXED: Better skills query with debugging
            skills_query = """
                SELECT skill_name, proficiency_level 
                FROM jobseeker_skills 
                WHERE jobseeker_id = %s
            """
            skills_df = pd.read_sql(skills_query, conn, params=(int(jobseeker_id),))
            
            print(f"🔍 Raw skills query result: {len(skills_df)} skills found", file=sys.stderr)
            
            if not skills_df.empty:
                # Extract skill names and normalize them
                raw_skills = []
                normalized_skills = []
                
                for _, skill_row in skills_df.iterrows():
                    skill_name = skill_row['skill_name']
                    raw_skills.append(f"{skill_name} ({skill_row['proficiency_level']})")
                    
                    # Normalize skill (remove proficiency)
                    normalized = self.normalize_skill_name_db(skill_name)
                    if normalized:
                        normalized_skills.append(normalized)
                
                profile['raw_skills_text'] = ', '.join(raw_skills)
                profile['skills_text'] = ', '.join(normalized_skills)
                
                print(f"   Raw skills: {profile['raw_skills_text']}", file=sys.stderr)
                print(f"   Normalized: {profile['skills_text']}", file=sys.stderr)
            else:
                profile['raw_skills_text'] = ''
                profile['skills_text'] = ''
                print("No skills found in database!", file=sys.stderr)
            
            # Experience
            exp_query = """
                SELECT GROUP_CONCAT(
                    CONCAT(job_title, ' at ', company_name, '. ', COALESCE(responsibilities, ''))
                    SEPARATOR '. '
                ) as experience_text
                FROM jobseeker_work_experience 
                WHERE jobseeker_id = %s
            """
            exp_df = pd.read_sql(exp_query, conn, params=(int(jobseeker_id),))
            profile['experience_text'] = exp_df.iloc[0]['experience_text'] if not exp_df.empty and exp_df.iloc[0]['experience_text'] else ''
            
            # Education
            edu_query = """
                SELECT GROUP_CONCAT(
                    CONCAT(education_level, ' in ', COALESCE(field_of_study, ''), ' from ', school_name)
                    SEPARATOR '. '
                ) as education_text
                FROM jobseeker_education 
                WHERE jobseeker_id = %s
            """
            edu_df = pd.read_sql(edu_query, conn, params=(int(jobseeker_id),))
            profile['education_text'] = edu_df.iloc[0]['education_text'] if not edu_df.empty and edu_df.iloc[0]['education_text'] else ''
            
            print(f"Jobseeker {jobseeker_id}: {profile['full_name']}")
            print(f"   Raw skills: {profile['raw_skills_text']}")
            print(f"   Normalized: {profile['skills_text']}")
            
            return pd.Series(profile)
            
        except Exception as e:
            print(f"Error fetching jobseeker {jobseeker_id}: {e}")
            return None
        finally:
            conn.close()
    
    def fetch_jobseeker_profile_optimized(self, jobseeker_id: int) -> Optional[pd.Series]:
        """OPTIMIZED: Single query instead of 4 separate queries"""
        conn = self._get_db_connection()
        try:
            # Single comprehensive query - MAJOR PERFORMANCE BOOST
            query = """
            SELECT 
                j.jobseeker_id as id,
                CONCAT(j.first_name, ' ', j.last_name) as full_name,
                COALESCE(j.address, '') as location,
                
                -- Skills in one go
                GROUP_CONCAT(DISTINCT 
                    CASE WHEN js.skill_name IS NOT NULL 
                    THEN CONCAT(js.skill_name, ':', COALESCE(js.proficiency_level, 'basic'))
                    END SEPARATOR '|'
                ) as skills_data,
                
                -- Experience in one go  
                GROUP_CONCAT(DISTINCT 
                    CASE WHEN jwe.job_title IS NOT NULL
                    THEN CONCAT(jwe.job_title, ' at ', jwe.company_name)
                    END SEPARATOR '|'
                ) as experience_data,
                
                -- Education in one go
                GROUP_CONCAT(DISTINCT 
                    CASE WHEN je.education_level IS NOT NULL
                    THEN CONCAT(je.education_level, ' in ', COALESCE(je.field_of_study, 'General'), ' from ', je.school_name)
                    END SEPARATOR '|'
                ) as education_data
                
            FROM jobseeker j
            LEFT JOIN jobseeker_skills js ON j.jobseeker_id = js.jobseeker_id
            LEFT JOIN jobseeker_work_experience jwe ON j.jobseeker_id = jwe.jobseeker_id  
            LEFT JOIN jobseeker_education je ON j.jobseeker_id = je.jobseeker_id
            WHERE j.jobseeker_id = %s
            GROUP BY j.jobseeker_id, j.first_name, j.last_name, j.address
            """
            
            df = pd.read_sql(query, conn, params=(int(jobseeker_id),))
            if df.empty:
                return None
                
            profile = df.iloc[0].to_dict()
            
            # Process skills efficiently
            if profile.get('skills_data'):
                skills_list = []
                for skill_data in profile['skills_data'].split('|'):
                    if ':' in skill_data:
                        skill_name = skill_data.split(':')[0]
                        normalized = self.normalize_skill_name_db(skill_name)
                        if normalized:
                            skills_list.append(normalized)
                profile['skills_text'] = ', '.join(skills_list)
            else:
                profile['skills_text'] = ''
                
            # Process other fields
            profile['experience_text'] = profile.get('experience_data', '').replace('|', '. ') if profile.get('experience_data') else ''
            profile['education_text'] = profile.get('education_data', '').replace('|', '. ') if profile.get('education_data') else ''
            
            return pd.Series(profile)
            
        finally:
            conn.close()

    def fetch_job_posts_optimized(self) -> pd.DataFrame:
        """OPTIMIZED: Limit data and add performance hints"""
        conn = self._get_db_connection()
        try:
            query = """
            SELECT 
                jp.job_id as id,
                jp.job_title as title,
                LEFT(jp.full_description, 300) as description,  -- Limit description length
                jp.location,
                jp.created_at,
                GROUP_CONCAT(DISTINCT jps.skill_name ORDER BY jps.skill_name SEPARATOR ', ') as skills_text,
                COUNT(DISTINCT jps.skill_name) as skill_count
            FROM job_post jp 
            LEFT JOIN job_post_skills jps ON jp.job_id = jps.job_id
            WHERE jp.job_status = 'open' 
              AND jp.created_at >= DATE_SUB(NOW(), INTERVAL 6 MONTH)  -- Only recent jobs
            GROUP BY jp.job_id, jp.job_title, jp.full_description, jp.location, jp.created_at
            HAVING skill_count > 0  -- Only jobs with skills
            ORDER BY jp.created_at DESC
            LIMIT 100  -- Reasonable limit for testing
            """
            
            df = pd.read_sql(query, conn)
            print(f"✅ Fetched {len(df)} optimized job posts")
            return df
            
        finally:
            conn.close()
    
    def normalize_text(self, text: str) -> str:
        """Normalize text for TF-IDF processing"""
        if text is None:
            return ""
        text = str(text).lower()
        text = re.sub(r"[,/|]", " ", text)
        text = re.sub(r"[^a-z0-9+\.# ]+", " ", text)
        text = re.sub(r"\s+", " ", text).strip()
        return text
    
    def normalize_skill_name_db(self, skill_text: str) -> str:
        """Database-driven skill normalization"""
        if not skill_text:
            return ""
        
        # Convert to lowercase and clean
        skill = str(skill_text).lower().strip()
        
        # Remove proficiency levels - KEY FIX
        proficiency_levels = ['beginner', 'intermediate', 'advanced', 'expert', 'basic', 'senior', 'junior']
        for level in proficiency_levels:
            skill = skill.replace(f" ({level})", "").replace(f"({level})", "").replace(level, "").strip()
        
        # Remove extra parentheses and spaces
        skill = re.sub(r'\s+', ' ', skill.replace("()", "")).strip()
        
        # Check database aliases first
        if skill in self.skill_aliases:
            return self.skill_aliases[skill]
        
        # Check partial matches in database
        for alias, standard in self.skill_aliases.items():
            if alias in skill or skill in alias:
                # Only if they're reasonably similar in length
                if abs(len(alias) - len(skill)) <= 3:
                    return standard
        
        return skill.strip()
    
    def extract_skill_tokens_db(self, skill_text: str) -> set:
        """Extract and normalize skill tokens using database"""
        if not skill_text:
            return set()
        
        # Split by common delimiters
        tokens = re.split(r"[,/|;]+", str(skill_text))
        normalized_skills = set()
        
        for token in tokens:
            # Use database-driven normalization
            normalized = self.normalize_skill_name_db(token)
            if normalized and len(normalized) > 1:
                normalized_skills.add(normalized)
                
                # Also add partial matches for compound skills
                if ' ' in normalized:
                    words = normalized.split()
                    for word in words:
                        if len(word) > 2:
                            normalized_skills.add(word)
        
        return normalized_skills
    
    def extract_skill_tokens(self, skill_text: str) -> set:
        """Extract skill tokens - calls database version"""
        return self.extract_skill_tokens_db(skill_text)
    
    def normalize_to_esco(self, skill_text: str) -> set:
        """Convert skills to ESCO URIs for standardized matching"""
        if not skill_text:
            return set()
        
        esco_uris = set()
        skills = str(skill_text).split(',')
        
        for skill in skills:
            skill_clean = skill.strip().lower()
            
            # Check if skill exists in ESCO aliases
            if skill_clean in self.esco_aliases:
                skill_id = self.esco_aliases[skill_clean]
                if skill_id in self.esco_skills:
                    esco_uris.add(self.esco_skills[skill_id]["uri"])
            
            # Also check direct ESCO skills
            for skill_id, skill_data in self.esco_skills.items():
                if skill_clean in skill_data["name"].lower():
                    esco_uris.add(skill_data["uri"])
        
        return esco_uris

    def get_esco_skills_for_text(self, text: str) -> set:
        """Extract ESCO skills from text"""
        if not text or not hasattr(self, 'esco_skills'):
            return set()
        
        text_lower = text.lower()
        found_esco_skills = set()
        
        # Check direct ESCO skill matches
        for skill_id, skill_data in self.esco_skills.items():
            skill_name = skill_data["name"].lower()
            if skill_name in text_lower:
                found_esco_skills.add(skill_name)
        
        # Check ESCO aliases
        for alias, skill_id in self.esco_aliases.items():
            if alias in text_lower and skill_id in self.esco_skills:
                found_esco_skills.add(self.esco_skills[skill_id]["name"].lower())
        
        return found_esco_skills

    def compute_semantic_skill_similarity(self, js_skills: set, job_skills: set) -> float:
        """Compute semantic similarity between skills using database relationships"""
        if not js_skills or not job_skills:
            return 0.0
        
        semantic_matches = 0
        
        for js_skill in js_skills:
            for job_skill in job_skills:
                # Check if skills are semantically related through aliases
                js_normalized = self.normalize_skill_name_db(js_skill)
                job_normalized = self.normalize_skill_name_db(job_skill)
                
                if js_normalized == job_normalized:
                    semantic_matches += 1
                    break
                elif self.are_skills_related(js_skill, job_skill):
                    semantic_matches += 0.7
                    break
        
        return semantic_matches / len(js_skills)

    def are_skills_related(self, skill1: str, skill2: str) -> bool:
        """Check if two skills are related through database mappings"""
        # Check if they share common aliases or normalizations
        skill1_variants = {skill1.lower(), self.normalize_skill_name_db(skill1)}
        skill2_variants = {skill2.lower(), self.normalize_skill_name_db(skill2)}
        
        # Add aliases from database
        for alias, standard in self.skill_aliases.items():
            if standard == skill1.lower():
                skill1_variants.add(alias)
            if standard == skill2.lower():
                skill2_variants.add(alias)
        
        # Check for overlap
        return bool(skill1_variants & skill2_variants)

    def compute_skill_level_compatibility(self, jobseeker_skills: str, job_skills: str) -> float:
        """Compute compatibility based on skill levels (if specified)"""
        # This is a simplified version - you can enhance based on your skill level data
        js_has_advanced = any(level in jobseeker_skills.lower() for level in ['advanced', 'expert', 'senior'])
        js_has_beginner = any(level in jobseeker_skills.lower() for level in ['beginner', 'basic', 'junior'])
        
        job_requires_advanced = any(level in job_skills.lower() for level in ['advanced', 'expert', 'senior'])
        job_accepts_beginner = any(level in job_skills.lower() for level in ['beginner', 'basic', 'entry'])
        
        if job_requires_advanced and js_has_advanced:
            return 1.0
        elif not job_requires_advanced and not js_has_beginner:
            return 0.8
        elif job_accepts_beginner:
            return 0.9
        else:
            return 0.5

    def infer_categories_from_education(self, education_text: str) -> Dict[str, float]:
        """Enhanced education to category mapping with more specificity"""
        education_to_category = {
            # Technical fields
            'computer science': {'it_programming': 3.0, 'data_analytics_research': 2.0},
            'information technology': {'it_programming': 3.0, 'engineering': 1.0},
            'data science': {'data_analytics_research': 3.0, 'it_programming': 2.0},
            'software engineering': {'it_programming': 3.0, 'engineering': 2.0},
            'computer engineering': {'it_programming': 2.0, 'engineering': 3.0},
            
            # Healthcare (should NOT match with IT)
            'nursing': {'healthcare_medical': 3.0},
            'medicine': {'healthcare_medical': 3.0, 'science_laboratory': 1.0},
            'medical': {'healthcare_medical': 3.0},
            
            # Business fields
            'business': {'business_management': 3.0, 'soft_skills': 1.0},
            'management': {'business_management': 3.0, 'soft_skills': 1.0},
            'accounting': {'finance_banking': 3.0, 'business_management': 1.0},
            'finance': {'finance_banking': 3.0, 'business_management': 1.0},
            'marketing': {'media_communications': 2.0, 'business_management': 1.0},
            
            # Engineering (separate from IT)
            'mechanical engineering': {'engineering': 3.0},
            'civil engineering': {'engineering': 3.0},
            'electrical engineering': {'engineering': 3.0, 'it_programming': 0.5},
            
            # Education and others
            'education': {'education_training': 3.0, 'soft_skills': 1.0},
            'psychology': {'soft_skills': 2.0, 'healthcare_medical': 0.5},
            'design': {'design_creative': 3.0}
        }
        
        education_lower = education_text.lower()
        inferred_categories = {}
        
        for edu_field, categories in education_to_category.items():
            if edu_field in education_lower:
                for category, weight in categories.items():
                    inferred_categories[category] = inferred_categories.get(category, 0) + weight
        
        return inferred_categories
    
    def compute_tfidf_similarity(self, jobs_df: pd.DataFrame, jobseeker_query: str) -> np.ndarray:
        """Compute TF-IDF similarity between jobseeker and jobs"""
        # Build job documents
        jobs_df["doc"] = (
            jobs_df["title"].fillna("") + " " +
            jobs_df["description"].fillna("") + " " +
            jobs_df["location"].fillna("") + " " +
            jobs_df["skills_text"].fillna("")
        ).apply(self.normalize_text)
        
        # Normalize jobseeker query
        normalized_query = self.normalize_text(jobseeker_query)
        
        # TF-IDF
        self.vectorizer = TfidfVectorizer(ngram_range=(1,2), min_df=1, max_features=5000)
        job_vectors = self.vectorizer.fit_transform(jobs_df["doc"].values)
        query_vector = self.vectorizer.transform([normalized_query])
        
        # Compute similarities
        similarities = cosine_similarity(query_vector, job_vectors).flatten()
        
        print(f"🔍 TF-IDF computed for {len(jobs_df)} jobs")
        return similarities
    
    def compute_skill_overlap(self, jobs_df: pd.DataFrame, jobseeker_skills: str) -> Tuple[pd.Series, pd.Series]:
        """Compute skill overlap between jobseeker and jobs"""
        js_skill_tokens = self.extract_skill_tokens(jobseeker_skills)
        
        def calculate_overlap(job_skills):
            job_tokens = self.extract_skill_tokens(job_skills)
            overlap = job_tokens & js_skill_tokens
            ratio = len(overlap) / max(len(js_skill_tokens), 1) if js_skill_tokens else 0
            return overlap, ratio
        
        overlaps, ratios = zip(*jobs_df["skills_text"].apply(calculate_overlap))
        
        return pd.Series(list(overlaps)), pd.Series(list(ratios))
    
    def compute_enhanced_skill_overlap_db(self, jobs_df: pd.DataFrame, jobseeker_skills: str) -> Tuple[pd.Series, pd.Series]:
        """Enhanced skill overlap using database normalization"""
        js_skill_tokens = self.extract_skill_tokens_db(jobseeker_skills)
        
        print(f"Jobseeker normalized skills (DB): {sorted(js_skill_tokens)}")
        
        def calculate_enhanced_overlap(job_skills):
            job_tokens = self.extract_skill_tokens_db(job_skills)
            
            # Direct matches
            direct_overlap = job_tokens & js_skill_tokens
            
            # Enhanced fuzzy matching using database relationships
            fuzzy_matches = set()
            for js_skill in js_skill_tokens:
                for job_skill in job_tokens:
                    # Check if skills are related through database mappings
                    js_normalized = self.normalize_skill_name_db(js_skill)
                    job_normalized = self.normalize_skill_name_db(job_skill)
                    
                    if js_normalized == job_normalized:
                        fuzzy_matches.add(f"{js_skill}~{job_skill}")
                    elif (js_skill in job_skill or job_skill in js_skill) and abs(len(js_skill) - len(job_skill)) <= 3:
                        fuzzy_matches.add(f"{js_skill}~{job_skill}")
            
            # Combine matches
            total_matches = direct_overlap | fuzzy_matches
            
            # Calculate ratio
            js_match_count = len(direct_overlap) + (len(fuzzy_matches) * 0.8)
            ratio = js_match_count / max(len(js_skill_tokens), 1) if js_skill_tokens else 0
            
            return total_matches, min(ratio, 1.0)
        
        overlaps, ratios = zip(*jobs_df["skills_text"].apply(calculate_enhanced_overlap))
        
        return pd.Series(list(overlaps)), pd.Series(list(ratios))
    
    def fetch_jobseeker_profile(self, jobseeker_id: int) -> Optional[pd.Series]:
        """Fetch jobseeker profile with FIXED skill processing"""
        conn = self._get_db_connection()
        try:
            # Basic info
            jobseeker_query = """
                SELECT 
                    j.jobseeker_id as id,
                    CONCAT(j.first_name, ' ', j.last_name) as full_name,
                    COALESCE(j.address, '') as location
                FROM jobseeker j
                WHERE j.jobseeker_id = %s
                LIMIT 1
            """
            
            df = pd.read_sql(jobseeker_query, conn, params=(int(jobseeker_id),))
            if df.empty:
                return None
                
            profile = df.iloc[0].to_dict()
            
            # FIXED: Better skills query with debugging
            skills_query = """
                SELECT skill_name, proficiency_level 
                FROM jobseeker_skills 
                WHERE jobseeker_id = %s
            """
            skills_df = pd.read_sql(skills_query, conn, params=(int(jobseeker_id),))
            
            print(f"🔍 Raw skills query result: {len(skills_df)} skills found", file=sys.stderr)
            
            if not skills_df.empty:
                # Extract skill names and normalize them
                raw_skills = []
                normalized_skills = []
                
                for _, skill_row in skills_df.iterrows():
                    skill_name = skill_row['skill_name']
                    raw_skills.append(f"{skill_name} ({skill_row['proficiency_level']})")
                    
                    # Normalize skill (remove proficiency)
                    normalized = self.normalize_skill_name_db(skill_name)
                    if normalized:
                        normalized_skills.append(normalized)
                
                profile['raw_skills_text'] = ', '.join(raw_skills)
                profile['skills_text'] = ', '.join(normalized_skills)
                
                print(f"   Raw skills: {profile['raw_skills_text']}", file=sys.stderr)
                print(f"   Normalized: {profile['skills_text']}", file=sys.stderr)
            else:
                profile['raw_skills_text'] = ''
                profile['skills_text'] = ''
                print("No skills found in database!", file=sys.stderr)
            
            # Experience
            exp_query = """
                SELECT GROUP_CONCAT(
                    CONCAT(job_title, ' at ', company_name, '. ', COALESCE(responsibilities, ''))
                    SEPARATOR '. '
                ) as experience_text
                FROM jobseeker_work_experience 
                WHERE jobseeker_id = %s
            """
            exp_df = pd.read_sql(exp_query, conn, params=(int(jobseeker_id),))
            profile['experience_text'] = exp_df.iloc[0]['experience_text'] if not exp_df.empty and exp_df.iloc[0]['experience_text'] else ''
            
            # Education
            edu_query = """
                SELECT GROUP_CONCAT(
                    CONCAT(education_level, ' in ', COALESCE(field_of_study, ''), ' from ', school_name)
                    SEPARATOR '. '
                ) as education_text
                FROM jobseeker_education 
                WHERE jobseeker_id = %s
            """
            edu_df = pd.read_sql(edu_query, conn, params=(int(jobseeker_id),))
            profile['education_text'] = edu_df.iloc[0]['education_text'] if not edu_df.empty and edu_df.iloc[0]['education_text'] else ''
            
            print(f"Jobseeker {jobseeker_id}: {profile['full_name']}")
            print(f"   Raw skills: {profile['raw_skills_text']}")
            print(f"   Normalized: {profile['skills_text']}")
            
            return pd.Series(profile)
            
        except Exception as e:
            print(f"Error fetching jobseeker {jobseeker_id}: {e}")
            return None
        finally:
            conn.close()
    
    def fetch_job_posts_cached(self) -> pd.DataFrame:
        """CACHED: Jobs with 5-minute cache"""
        import time
        current_time = time.time()
        
        # Check cache first
        if (self._jobs_cache is not None and 
            current_time - self._jobs_cache_time < self._cache_duration):
            print(f"📋 Using cached jobs: {len(self._jobs_cache)} posts")
            return self._jobs_cache.copy()
        
        # Fetch fresh data
        print("🔄 Fetching fresh jobs...")
        self._jobs_cache = self.fetch_job_posts_optimized()
        self._jobs_cache_time = current_time
        
        return self._jobs_cache.copy()

    @lru_cache(maxsize=500)
    def normalize_skill_name_db_cached(self, skill_text: str) -> str:
        """CACHED: Skill normalization with memory cache"""
        return self.normalize_skill_name_db(skill_text)

    def extract_skill_tokens_db_cached(self, skill_text: str) -> set:
        """CACHED: Skill token extraction"""
        if not skill_text:
            return set()
        
        # Use cached normalization
        tokens = re.split(r"[,/|;]+", str(skill_text))
        normalized_skills = set()
        
        for token in tokens:
            normalized = self.normalize_skill_name_db_cached(token)
            if normalized and len(normalized) > 1:
                normalized_skills.add(normalized)
        
        return normalized_skills

    def compute_all_metrics_vectorized(self, jobs_df: pd.DataFrame, jobseeker_profile: pd.Series) -> pd.DataFrame:
        """OPTIMIZED: Compute all metrics in vectorized operations"""
        js_skills = jobseeker_profile.get("skills_text", "")
        js_skill_tokens = self.extract_skill_tokens_db_cached(js_skills)
        
        print("📊 Computing metrics (vectorized)...")
        
        # Vectorized skill processing
        job_skills_series = jobs_df["skills_text"].fillna("")
        job_tokens_series = job_skills_series.apply(lambda x: self.extract_skill_tokens_db_cached(x))
        
        # Vectorized overlap calculation
        skill_overlaps = job_tokens_series.apply(lambda job_tokens: job_tokens & js_skill_tokens)
        skill_ratios = skill_overlaps.apply(lambda overlap: len(overlap) / max(len(js_skill_tokens), 1))
        
        # Vectorized location matching
        js_location = jobseeker_profile.get("location", "").lower()
        location_matches = jobs_df["location"].fillna("").str.lower().apply(
            lambda x: 1.0 if js_location and (js_location in x or x in js_location) else 0.2
        )
        
        # Add all metrics to dataframe
        result_df = jobs_df.copy()
        result_df.loc[:, "skill_overlap"] = skill_overlaps
        result_df.loc[:, "skill_overlap_ratio"] = skill_ratios
        result_df.loc[:, "location_match"] = location_matches
        
        return result_df

    def generate_enhanced_recommendations_v2_optimized(self, jobseeker_id: int, top_k: int = 10, debug_mode: bool = False) -> Dict[str, Any]:
        """FIXED: Use base score directly without quality modifier"""
        print(f"🎯 Generating FIXED v2 recommendations for jobseeker {jobseeker_id}")
        
        try:
            # Use optimized data fetching
            jobs_df = self.fetch_job_posts_cached()
            jobseeker_profile = self.fetch_jobseeker_profile_optimized(jobseeker_id)
            
            if jobseeker_profile is None:
                return {"success": False, "error": "Jobseeker not found"}
            
            if jobs_df.empty:
                return {
                    "success": True,
                    "jobseeker": self._format_jobseeker_info(jobseeker_profile),
                    "recommendations": [],
                    "message": "No job posts available"
                }
            
            # Get jobseeker skills
            js_skills = jobseeker_profile.get("skills_text", "")
            js_skill_tokens = self.extract_skill_tokens_db_cached(js_skills)
            
            print(f"🔍 Jobseeker skills ({len(js_skill_tokens)}): {sorted(js_skill_tokens)}")
            
            recommendations = []
            
            # Process each job individually with FIXED scoring
            for _, job in jobs_df.iterrows():
                job_skills = job.get("skills_text", "")
                job_skill_tokens = self.extract_skill_tokens_db_cached(job_skills)
                
                # FIXED: Correct skill similarity calculation
                if js_skill_tokens and job_skill_tokens:
                    skill_overlap = js_skill_tokens & job_skill_tokens
                    
                    # CRITICAL: Divide by jobseeker skills (not job skills)
                    skill_overlap_ratio = len(skill_overlap) / len(js_skill_tokens)
                    
                    print(f"   Job {job['id']} ({job['title']}): {len(skill_overlap)}/{len(js_skill_tokens)} = {skill_overlap_ratio:.3f}")
                    print(f"      Overlapping skills: {sorted(skill_overlap)}")
                else:
                    skill_overlap_ratio = 0.0
                    skill_overlap = set()
                
                # Specificity Score (20%): Reward specialized/rare skills
                specificity_score = 0.0
                if skill_overlap:
                    # Technical skills get higher specificity
                    tech_skills = {'python', 'java', 'docker', 'aws', 'machine learning', 'data analysis', 'sql', 'javascript', 'php', 'css', 'html', 'mysql', 'flask', 'git', 'github'}
                    specialized_matches = skill_overlap & tech_skills
                    specificity_score = len(specialized_matches) / max(len(skill_overlap), 1)
                
                # Category Score (30%): Domain alignment  
                js_categories = self.categorize_skills_from_db(js_skills)
                job_categories = self.categorize_skills_from_db(job_skills)
                
                if js_categories and job_categories:
                    shared_categories = set(js_categories.keys()) & set(job_categories.keys())
                    if shared_categories:
                        # Strong domain match
                        category_score = 1.0
                    else:
                        # Cross-domain penalty
                        category_score = 0.1
                else:
                    # FIXED: Better fallback for missing category data
                    # Check if job and jobseeker are both in tech field
                    js_tech_keywords = {'programming', 'developer', 'engineer', 'technology', 'software', 'web', 'data', 'computer'}
                    job_tech_keywords = {'developer', 'engineer', 'programming', 'software', 'web', 'technical', 'data', 'cloud'}
                    
                    js_text = f"{js_skills} {jobseeker_profile.get('education_text', '')} {jobseeker_profile.get('experience_text', '')}".lower()
                    job_text = f"{job_skills} {job.get('title', '')} {job.get('description', '')}".lower()
                    
                    js_is_tech = any(keyword in js_text for keyword in js_tech_keywords)
                    job_is_tech = any(keyword in job_text for keyword in job_tech_keywords)
                    
                    if js_is_tech and job_is_tech:
                        category_score = 0.8  # Both tech-related
                    elif js_is_tech and not job_is_tech:
                        category_score = 0.2  # Tech person, non-tech job
                    elif not js_is_tech and job_is_tech:
                        category_score = 0.3  # Non-tech person, tech job
                    else:
                        category_score = 0.5  # Neither clearly tech
                
                # Advanced Skill Score (10%): Enhanced semantic matching
                advanced_skill_score = 0.0
                if js_skill_tokens and job_skill_tokens:
                    # Check for semantic relationships
                    semantic_matches = 0
                    for js_skill in js_skill_tokens:
                        for job_skill in job_skill_tokens:
                            if self.are_skills_related(js_skill, job_skill):
                                semantic_matches += 1
                    advanced_skill_score = min(semantic_matches / len(js_skill_tokens), 1.0)
                
                # TF-IDF Similarity (5%): Content matching
                tfidf_sim = 0.0
                try:
                    if hasattr(self, 'vectorizer') and self.vectorizer:
                        js_text = f"{js_skills} {jobseeker_profile.get('experience_text', '')} {jobseeker_profile.get('education_text', '')}"
                        job_text = f"{job_skills} {job.get('title', '')} {job.get('description', '')}"
                        
                        tfidf_matrix = self.vectorizer.fit_transform([js_text, job_text])
                        tfidf_sim = cosine_similarity(tfidf_matrix[0:1], tfidf_matrix[1:2])[0][0]
                except Exception:
                    tfidf_sim = 0.0
                
                # Role Match (5%): Experience alignment
                role_match = 0.0
                js_experience = jobseeker_profile.get('experience_text', '').lower()
                job_title = job.get('title', '').lower()
                if js_experience and job_title:
                    # Simple role matching
                    if any(word in js_experience for word in job_title.split()):
                        role_match = 0.8
                    elif 'developer' in js_experience and 'developer' in job_title:
                        role_match = 0.9
                    elif 'engineer' in js_experience and 'engineer' in job_title:
                        role_match = 0.9
                
                # FIXED: Use base score directly (no quality modifier)
                base_score = (
                    0.30 * skill_overlap_ratio +      # 30% - Primary skill matching
                    0.20 * specificity_score +        # 20% - Skill rarity/specialization  
                    0.30 * category_score +           # 30% - Domain alignment
                    0.10 * advanced_skill_score +     # 10% - Enhanced semantic matching
                    0.05 * tfidf_sim +                # 5%  - Content-based matching
                    0.05 * role_match                 # 5%  - Experience-based matching
                )
                
                # FIXED: Use base score as final score (remove quality modifier)
                final_score = base_score
                
                # Location bonus (small boost for local jobs)
                js_location = jobseeker_profile.get("location", "").lower()
                job_location = job.get("location", "").lower()
                if js_location and (js_location in job_location or job_location in js_location):
                    final_score *= 1.1  # 10% bonus for local jobs
                
                # FIXED: Remove harsh caps - only apply to truly poor matches
                if skill_overlap_ratio < 0.05 and category_score < 0.3:
                    # Only cap extremely poor matches (no skills + wrong domain)
                    final_score = min(final_score, 0.10)  # Cap at 10%
                
                # Add small random variation for tie-breaking (seeded for consistency)
                np.random.seed(int(jobseeker_id) * int(job['id']))
                random_factor = np.random.uniform(0.98, 1.02)
                final_score *= random_factor
                
                print(f"      Scores: skill={skill_overlap_ratio:.3f}, spec={specificity_score:.3f}, "
                    f"cat={category_score:.3f}, adv={advanced_skill_score:.3f}, "
                    f"tfidf={tfidf_sim:.3f}, role={role_match:.3f} → {final_score:.3f}")
                
                recommendations.append({
                    "job_id": int(job["id"]),
                    "title": job["title"],
                    "location": job["location"],
                    "final_score": round(final_score, 4),
                    "match_percentage": round(final_score * 100, 2),
                    "match_quality": self._determine_match_quality(final_score),
                    "skills_text": job["skills_text"],
                    "debug_info": {
                        "skill_overlap_ratio": round(skill_overlap_ratio, 3),
                        "specificity_score": round(specificity_score, 3),
                        "category_score": round(category_score, 3),
                        "advanced_skill_score": round(advanced_skill_score, 3),
                        "tfidf_sim": round(tfidf_sim, 3),
                        "role_match": round(role_match, 3),
                        "skill_overlap_count": len(skill_overlap),
                        "overlapping_skills": sorted(skill_overlap)
                    } if debug_mode else None
                })
            
            # Sort by final score
            recommendations.sort(key=lambda x: x["final_score"], reverse=True)
            
            return {
                "success": True,
                "jobseeker": self._format_jobseeker_info(jobseeker_profile),
                "recommendations": recommendations[:top_k],
                "total_jobs_analyzed": len(jobs_df),
                "algorithm_version": "fixed_base_score_v2",
                "scoring_formula": "Direct: 30% skill + 20% specificity + 30% category + 10% advanced + 5% tfidf + 5% role"
            }
            
        except Exception as e:
            print(f"❌ Error in fixed recommendations: {e}")
            return {"success": False, "error": str(e)}

    def _format_jobseeker_info(self, jobseeker_profile: pd.Series) -> Dict[str, Any]:
        """Format jobseeker info for response"""
        return {
            "jobseeker_id": int(jobseeker_profile.get("id", 0)),
            "name": jobseeker_profile.get("full_name", "Unknown"),
            "location": jobseeker_profile.get("location", "Unknown"),
            "skills": jobseeker_profile.get("skills_text", ""),
            "education": jobseeker_profile.get("education_text", ""),
            "experience": jobseeker_profile.get("experience_text", "")
        }
        
    def _determine_match_quality(self, score: float) -> str:
        """FIXED: More realistic match quality thresholds"""
        if score >= 0.60:
            return "Excellent"      # 60%+ for very strong matches
        elif score >= 0.40:
            return "Good"           # 40-60% for good matches
        elif score >= 0.25:
            return "Fair"           # 25-40% for acceptable matches
        elif score >= 0.15:
            return "Poor"           # 15-25% for weak matches
        else:
            return "Very Poor"      # <15% for very poor matches