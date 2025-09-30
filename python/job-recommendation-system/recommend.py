"""
Core Job Recommendation Engine for SIKAP
Handles all ML logic, data processing, and recommendation algorithms
"""
import os
import sys

if os.name == 'nt':  # Windows
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

# Import configuration
from config import DB_CONFIG

class JobRecommendationEngine:
    """Main recommendation engine class"""
    
    def __init__(self):
        """Initialize with database-driven skill normalization"""
        self.vectorizer = None
        self.esco_skills = {}
        self.esco_aliases = {}
        self.skill_aliases = {}  # Will be loaded from database
        self.esco_skill_map = {}  # For ESCO-enhanced matching
        
        # FIXED: Safe print for Windows
        try:
            print(f"🔧 Using database: {DB_CONFIG['host']}/{DB_CONFIG['database']}")
        except UnicodeEncodeError:
            print(f"Using database: {DB_CONFIG['host']}/{DB_CONFIG['database']}")
        
        # Load normalization data from database
        self.load_skill_normalization_data()
        self._load_esco_data()
    
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
                print(f"⚠️ ESCO skills table issue: {e}")
                self.esco_skills = {}
                
            # Load ESCO aliases
            try:
                cur.execute("SELECT alias, skill_id FROM esco_skill_aliases LIMIT 1000")
                self.esco_aliases = {
                    row["alias"].lower(): row["skill_id"] 
                    for row in cur.fetchall()
                }
            except Exception as e:
                print(f"⚠️ ESCO aliases table issue: {e}")
                self.esco_aliases = {}
                
            conn.close()
            print(f"📊 Loaded {len(self.esco_skills)} ESCO skills, {len(self.esco_aliases)} aliases")
            
        except Exception as e:
            print(f"⚠️ Could not load ESCO data: {e}")
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
                print(f"⚠️ Skills dictionary empty or error: {e}")
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
                print(f"⚠️ ESCO aliases empty or error: {e}")
            
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
                print(f"⚠️ Manual to ESCO mapping empty or error: {e}")
            
            print(f"✅ Loaded {len(self.skill_aliases)} skill aliases from database")
            
            # Fallback to critical mappings if database is empty
            if len(self.skill_aliases) == 0:
                print("⚠️ Using fallback skill mappings")
                self.skill_aliases = {
                    'js': 'javascript',
                    'javascript programming': 'javascript',
                    'python programming': 'python',
                    'sql database': 'sql',
                    'data analysis': 'data analytics',
                    'html5': 'html',
                    'css3': 'css',
                    'react.js': 'react',
                    'node.js': 'nodejs',
                    'vue.js': 'vue'
                }
            
        except Exception as e:
            print(f"⚠️ Error loading skill normalization data: {e}")
            # Fallback to minimal hardcoded list for critical operations
            self.skill_aliases = {
                'js': 'javascript',
                'sql database': 'sql',
                'data analysis': 'data analytics'
            }
        finally:
            conn.close()
    
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
            print(f"📋 Fetched {len(df)} job posts")
            for i, job in df.head(3).iterrows():
                print(f"   Job {job['id']}: {job['title']} - Skills: {job['skills_text']}")
            
            return df
            
        except Exception as e:
            print(f"❌ Error fetching job posts: {e}")
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
    
    # FIXED: Add missing method
    def extract_skill_tokens(self, skill_text: str) -> set:
        """Extract skill tokens - calls database version"""
        return self.extract_skill_tokens_db(skill_text)
    
    # FIXED: Move inside class
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
        
        print(f"🔍 Jobseeker normalized skills (DB): {sorted(js_skill_tokens)}")
        
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
                print("   ⚠️ No skills found in database!", file=sys.stderr)
            
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
            
            print(f"👤 Jobseeker {jobseeker_id}: {profile['full_name']}")
            print(f"   Raw skills: {profile['raw_skills_text']}")
            print(f"   Normalized: {profile['skills_text']}")
            
            return pd.Series(profile)
            
        except Exception as e:
            print(f"❌ Error fetching jobseeker {jobseeker_id}: {e}")
            return None
        finally:
            conn.close()
    
    def compute_esco_overlap(self, jobs_df: pd.DataFrame, jobseeker_skills: str) -> Tuple[pd.Series, pd.Series]:
        """Compute ESCO skill overlap"""
        js_esco_uris = self.normalize_to_esco(jobseeker_skills)
        
        def calculate_esco_overlap(job_skills):
            job_esco_uris = self.normalize_to_esco(job_skills)
            overlap = job_esco_uris & js_esco_uris
            ratio = len(overlap) / max(len(js_esco_uris), 1) if js_esco_uris else 0
            return overlap, ratio
        
        overlaps, ratios = zip(*jobs_df["skills_text"].apply(calculate_esco_overlap))
        
        return pd.Series(list(overlaps)), pd.Series(list(ratios))
    
    def compute_role_match(self, jobs_df: pd.DataFrame, jobseeker_profile: pd.Series) -> pd.Series:
        """Compute role/title matching based on work experience job titles"""
        experience_text = jobseeker_profile.get("experience_text", "")
        
        if not experience_text:
            return pd.Series([0] * len(jobs_df))
        
        # Extract job titles from experience
        experience_titles = []
        import re
        # Pattern to extract job titles (assumes format: "Job Title at Company")
        title_pattern = r'([^\.]+?)\s+at\s+[^\.]+\.'
        matches = re.findall(title_pattern, experience_text)
        experience_titles = [title.strip().lower() for title in matches]
        
        def calculate_title_match(job_title):
            if not job_title or not experience_titles:
                return 0
            
            job_title_normalized = str(job_title).lower()
            
            # Check for exact matches or similar titles
            for exp_title in experience_titles:
                if exp_title in job_title_normalized or job_title_normalized in exp_title:
                    return 1
            return 0
        
        role_matches = jobs_df["title"].apply(calculate_title_match)
        return role_matches
    
    def generate_recommendations(self, jobseeker_id: int, top_k: int = 10) -> Dict[str, Any]:
        """Generate recommendations using database-driven skill matching"""
        print(f"🎯 Generating ENHANCED recommendations for jobseeker {jobseeker_id}")
        
        # FIXED: Safer DataFrame operations
        try:
            # Fetch data
            jobs_df = self.fetch_job_posts()
            jobseeker_profile = self.fetch_jobseeker_profile(jobseeker_id)
            
            if jobseeker_profile is None:
                return {"error": "Jobseeker not found"}
            
            if jobs_df.empty:
                return {
                    "jobseeker": self._format_jobseeker_info(jobseeker_profile),
                    "recommendations": [],
                    "message": "No job posts available"
                }
            
            # Build jobseeker query
            query_parts = [
                str(jobseeker_profile.get("location", "") or ""),
                str(jobseeker_profile.get("skills_text", "") or ""),
                str(jobseeker_profile.get("experience_text", "") or ""),
                str(jobseeker_profile.get("education_text", "") or "")
            ]
            jobseeker_query = " ".join(query_parts)
            
            # Compute all similarity metrics
            print("📊 Computing ENHANCED similarity metrics...")
            
            # 1. TF-IDF Similarity
            tfidf_similarities = self.compute_tfidf_similarity(jobs_df, jobseeker_query)
            
            # 2. ENHANCED Skill Overlap
            skill_overlaps, skill_ratios = self.compute_enhanced_skill_overlap_db(
                jobs_df, jobseeker_profile.get("skills_text", "")
            )
            
            # 3. ESCO Overlap (if available)
            esco_overlaps, esco_ratios = self.compute_esco_overlap(
                jobs_df, jobseeker_profile.get("skills_text", "")
            )
            
            # 4. Experience-based Role Match
            role_matches = self.compute_role_match(jobs_df, jobseeker_profile)
            
            # Add computed metrics
            jobs_df["tfidf_sim"] = tfidf_similarities
            jobs_df["skill_overlap"] = skill_overlaps
            jobs_df["skill_overlap_ratio"] = skill_ratios
            jobs_df["esco_overlap"] = esco_overlaps
            jobs_df["esco_overlap_ratio"] = esco_ratios
            jobs_df["role_match"] = role_matches
            
            # ENHANCED SCORING - Skills are much more important
            jobs_df["final_score"] = (
                0.2 * jobs_df["tfidf_sim"] +           # TF-IDF (reduced weight)
                0.5 * jobs_df["skill_overlap_ratio"] + # Skills (MUCH higher weight)
                0.2 * jobs_df["esco_overlap_ratio"] +  # ESCO skills
                0.1 * jobs_df["role_match"]            # Experience-based role match
            )
            
            # Lower minimum threshold since we improved matching
            MIN_SCORE = 0.01
            filtered_jobs = jobs_df[jobs_df["final_score"] >= MIN_SCORE]
            
            if filtered_jobs.empty:
                filtered_jobs = jobs_df.nlargest(min(top_k, len(jobs_df)), "final_score")
            else:
                filtered_jobs = filtered_jobs.sort_values("final_score", ascending=False).head(top_k)
            
            # Format results
            recommendations = self._format_recommendations(filtered_jobs)
            
            result = {
                "jobseeker": self._format_jobseeker_info(jobseeker_profile),
                "recommendations": recommendations,
                "total_jobs_analyzed": len(jobs_df),
                "total_recommendations": len(recommendations),
                "debug_info": {
                    "avg_tfidf": float(jobs_df["tfidf_sim"].mean()),
                    "avg_skill_ratio": float(jobs_df["skill_overlap_ratio"].mean()),
                    "best_skill_match": float(jobs_df["skill_overlap_ratio"].max()),
                    "jobseeker_skills_count": len(self.extract_skill_tokens(jobseeker_profile.get("skills_text", ""))),
                }
            }
            
            print(f"✅ Generated {len(recommendations)} ENHANCED recommendations")
            print(f"   Best skill match: {result['debug_info']['best_skill_match']:.3f}")
            print(f"   Avg skill match: {result['debug_info']['avg_skill_ratio']:.3f}")
            
            return result
        except Exception as e:
            print(f"❌ Error generating recommendations: {e}")
            return {"error": str(e)}
    
    def _format_jobseeker_info(self, profile: pd.Series) -> Dict[str, Any]:
        """Format jobseeker information for response"""
        return {
            "id": int(profile["id"]),
            "name": profile["full_name"],
            "skills_text": profile.get("skills_text", ""),
            "raw_skills_text": profile.get("raw_skills_text", ""),  # FIXED: Add this
            "location": profile.get("location", ""),
        }
    
    def _format_recommendations(self, jobs_df: pd.DataFrame) -> List[Dict[str, Any]]:
        """Format job recommendations for response"""
        recommendations = []
        
        for _, job in jobs_df.iterrows():
            # Convert ESCO URIs back to skill names for display
            matched_esco_names = []
            if self.esco_skills and hasattr(job, 'esco_overlap') and job["esco_overlap"]:
                for uri in job["esco_overlap"]:
                    for skill_data in self.esco_skills.values():
                        if skill_data["uri"] == uri:
                            matched_esco_names.append(skill_data["name"])
                            break
            
            recommendation = {
                "job_id": int(job["id"]),
                "title": job["title"],
                "description": (job["description"][:200] + "...") if len(str(job["description"])) > 200 else job["description"],
                "location": job["location"],
                "tfidf_sim": round(float(job["tfidf_sim"]), 4),
                "skill_overlap_ratio": round(float(job["skill_overlap_ratio"]), 3),
                "esco_overlap_ratio": round(float(job["esco_overlap_ratio"]), 3),
                "role_match": bool(job["role_match"]),
                "final_score": round(float(job["final_score"]), 4),
                "match_percentage": round(float(job["final_score"]) * 100, 2),
                "matched_skills": sorted(list(job["skill_overlap"])) if job["skill_overlap"] else [],
                "matched_esco": sorted(matched_esco_names)
            }
            recommendations.append(recommendation)
        
        return recommendations

# FIXED: Add missing functions outside class
def test_database_connection() -> bool:
    """Test database connection"""
    try:
        conn = mysql.connect(**DB_CONFIG)
        cursor = conn.cursor()
        cursor.execute("SELECT 1")
        cursor.fetchone()
        conn.close()
        print("✅ Database connection successful")
        return True
    except Exception as e:
        print(f"❌ Database connection failed: {e}")
        return False

def get_sample_jobseeker_ids(limit: int = 5) -> List[int]:
    """Get sample jobseeker IDs for testing"""
    try:
        conn = mysql.connect(**DB_CONFIG)
        df = pd.read_sql(f"""
            SELECT j.jobseeker_id, j.first_name, j.last_name, 
                   COUNT(js.skill_name) as skill_count
            FROM jobseeker j
            LEFT JOIN jobseeker_skills js ON j.jobseeker_id = js.jobseeker_id
            GROUP BY j.jobseeker_id, j.first_name, j.last_name
            HAVING skill_count > 0
            ORDER BY skill_count DESC
            LIMIT {limit}
        """, conn)
        
        conn.close()
        
        if not df.empty:
            print("📝 Sample jobseekers with skills:")
            for _, row in df.iterrows():
                print(f"   ID: {row['jobseeker_id']} - {row['first_name']} {row['last_name']} ({row['skill_count']} skills)")
            
            return df['jobseeker_id'].tolist()
        return []
        
    except Exception as e:
        print(f"❌ Error getting sample jobseekers: {e}")
        return []

# FIXED: Add main execution block
if __name__ == "__main__":
    print("🔍 Testing ENHANCED SIKAP Job Recommendation Engine...")
    
    # Test database
    if not test_database_connection():
        exit(1)
    
    # Get sample data
    sample_ids = get_sample_jobseeker_ids(3)
    
    if sample_ids:
        engine = JobRecommendationEngine()
        for jobseeker_id in sample_ids[:1]:
            print(f"\n🧪 Testing ENHANCED recommendations for jobseeker {jobseeker_id}")
            result = engine.generate_recommendations(jobseeker_id, top_k=5)
            
            if "error" in result:
                print(f"❌ Error: {result['error']}")
            else:
                print(f"✅ Generated {len(result['recommendations'])} recommendations")
                if result['recommendations']:
                    top_rec = result['recommendations'][0]
                    print(f"   Top: {top_rec['title']} ({top_rec['match_percentage']}% match)")
                    if 'debug_info' in result:
                        print(f"   Debug: {result['debug_info']}")
    else:
        print("❌ No jobseekers found with skills for testing")