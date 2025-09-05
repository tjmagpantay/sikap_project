import numpy as np
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.metrics.pairwise import cosine_similarity
from sklearn.cluster import KMeans
import difflib
import re

class EnhancedSkillMatcher:
    def __init__(self):
        self.skill_synonyms = self._load_skill_synonyms()
        self.skill_clusters = self._create_skill_clusters()
        self.vectorizer = TfidfVectorizer(
            lowercase=True,
            stop_words='english',
            ngram_range=(1, 2),  # Include bigrams
            max_features=1000
        )
        
    def _load_skill_synonyms(self):
        """Define skill synonyms and related terms"""
        return {
            # Programming & Development
            'programming': ['coding', 'development', 'software development', 'programming', 'dev'],
            'coding': ['programming', 'development', 'software development', 'coding', 'dev'],
            'python': ['python programming', 'python development', 'python coding'],
            'javascript': ['js', 'javascript', 'ecmascript', 'node.js', 'nodejs'],
            'java': ['java programming', 'java development', 'jvm'],
            'php': ['php development', 'php programming', 'web development'],
            'html': ['html5', 'markup', 'web markup', 'hypertext'],
            'css': ['css3', 'styling', 'web styling', 'cascading style sheets'],
            'react': ['reactjs', 'react.js', 'react framework'],
            'angular': ['angularjs', 'angular framework'],
            'vue': ['vuejs', 'vue.js', 'vue framework'],
            
            # Technical Skills
            'technical skills': ['coding', 'programming', 'software skills', 'it skills', 'tech skills'],
            'software development': ['programming', 'coding', 'development', 'software engineering'],
            'web development': ['frontend', 'backend', 'fullstack', 'web programming'],
            'frontend': ['front-end', 'ui development', 'client-side'],
            'backend': ['back-end', 'server-side', 'api development'],
            'fullstack': ['full-stack', 'full stack', 'frontend and backend'],
            
            # Databases
            'sql': ['mysql', 'postgresql', 'database', 'queries', 'rdbms'],
            'mysql': ['sql', 'database', 'relational database'],
            'postgresql': ['postgres', 'sql', 'database'],
            'mongodb': ['mongo', 'nosql', 'document database'],
            'database': ['sql', 'mysql', 'postgresql', 'data management'],
            
            # Cloud & DevOps
            'aws': ['amazon web services', 'cloud computing', 'cloud'],
            'azure': ['microsoft azure', 'cloud computing', 'cloud'],
            'gcp': ['google cloud', 'cloud computing', 'cloud'],
            'docker': ['containerization', 'containers', 'devops'],
            'kubernetes': ['k8s', 'container orchestration', 'devops'],
            'devops': ['deployment', 'ci/cd', 'automation'],
            
            # Frameworks & Tools
            'laravel': ['php framework', 'mvc framework'],
            'django': ['python framework', 'web framework'],
            'spring': ['java framework', 'spring boot'],
            'git': ['version control', 'source control', 'github', 'gitlab'],
            'github': ['git', 'version control', 'source control'],
            
            # Soft Skills
            'communication': ['communication skills', 'verbal communication', 'written communication'],
            'teamwork': ['collaboration', 'team collaboration', 'team player'],
            'leadership': ['team leadership', 'management', 'leading teams'],
            'problem solving': ['analytical thinking', 'troubleshooting', 'critical thinking'],
            
            # Design & UI/UX
            'ui design': ['user interface', 'interface design', 'ui/ux'],
            'ux design': ['user experience', 'ux/ui', 'user research'],
            'design': ['graphic design', 'web design', 'visual design'],
            'figma': ['design tool', 'prototyping', 'ui design'],
            'photoshop': ['image editing', 'graphic design', 'adobe'],
            
            # Data & Analytics
            'data analysis': ['analytics', 'data science', 'data analytics'],
            'machine learning': ['ml', 'ai', 'artificial intelligence', 'data science'],
            'artificial intelligence': ['ai', 'machine learning', 'ml'],
            'statistics': ['statistical analysis', 'data analysis', 'analytics'],
            'excel': ['spreadsheet', 'data analysis', 'microsoft excel'],
            
            # Project Management
            'project management': ['pm', 'project coordination', 'agile', 'scrum'],
            'agile': ['scrum', 'project management', 'agile methodology'],
            'scrum': ['agile', 'project management', 'scrum master'],
        }
    
    def _create_skill_clusters(self):
        """Create skill clusters for better matching"""
        return {
            'programming_languages': [
                'python', 'javascript', 'java', 'php', 'c++', 'c#', 'ruby', 'go', 'rust', 'swift'
            ],
            'web_technologies': [
                'html', 'css', 'javascript', 'react', 'angular', 'vue', 'jquery', 'bootstrap'
            ],
            'backend_frameworks': [
                'django', 'flask', 'laravel', 'spring', 'express', 'rails', 'asp.net'
            ],
            'databases': [
                'mysql', 'postgresql', 'mongodb', 'redis', 'sqlite', 'oracle', 'sql server'
            ],
            'cloud_platforms': [
                'aws', 'azure', 'gcp', 'heroku', 'digitalocean', 'linode'
            ],
            'devops_tools': [
                'docker', 'kubernetes', 'jenkins', 'git', 'gitlab', 'github', 'ci/cd'
            ],
            'design_tools': [
                'figma', 'sketch', 'photoshop', 'illustrator', 'adobe xd', 'canva'
            ],
            'data_science': [
                'python', 'r', 'sql', 'machine learning', 'statistics', 'pandas', 'numpy'
            ]
        }
    
    def normalize_skill(self, skill):
        """Normalize skill name"""
        if not skill:
            return ""
        
        skill = str(skill).lower().strip()
        # Remove special characters and extra spaces
        skill = re.sub(r'[^\w\s-]', '', skill)
        skill = re.sub(r'\s+', ' ', skill)
        return skill
    
    def expand_skill(self, skill):
        """Expand skill with synonyms"""
        normalized_skill = self.normalize_skill(skill)
        expanded = [normalized_skill]
        
        # Add direct synonyms
        if normalized_skill in self.skill_synonyms:
            expanded.extend(self.skill_synonyms[normalized_skill])
        
        # Check if skill is mentioned in other synonym groups
        for main_skill, synonyms in self.skill_synonyms.items():
            if normalized_skill in synonyms and main_skill not in expanded:
                expanded.append(main_skill)
                expanded.extend(synonyms)
        
        return list(set(expanded))  # Remove duplicates
    
    def get_skill_cluster(self, skill):
        """Get the cluster a skill belongs to"""
        normalized_skill = self.normalize_skill(skill)
        
        for cluster_name, skills in self.skill_clusters.items():
            if normalized_skill in [self.normalize_skill(s) for s in skills]:
                return cluster_name
        
        return None
    
    def calculate_semantic_similarity(self, skill1, skill2):
        """Calculate semantic similarity between two skills"""
        skill1_norm = self.normalize_skill(skill1)
        skill2_norm = self.normalize_skill(skill2)
        
        # Exact match
        if skill1_norm == skill2_norm:
            return 1.0
        
        # Check synonyms
        skill1_expanded = self.expand_skill(skill1_norm)
        skill2_expanded = self.expand_skill(skill2_norm)
        
        # Check if skills share synonyms
        if set(skill1_expanded) & set(skill2_expanded):
            return 0.9
        
        # Check if skills are in same cluster
        cluster1 = self.get_skill_cluster(skill1_norm)
        cluster2 = self.get_skill_cluster(skill2_norm)
        
        if cluster1 and cluster2 and cluster1 == cluster2:
            return 0.7
        
        # Use fuzzy string matching
        fuzzy_score = difflib.SequenceMatcher(None, skill1_norm, skill2_norm).ratio()
        if fuzzy_score > 0.8:
            return fuzzy_score * 0.6
        
        # Use TF-IDF similarity for partial matches
        try:
            docs = [skill1_norm, skill2_norm]
            tfidf_matrix = self.vectorizer.fit_transform(docs)
            similarity = cosine_similarity(tfidf_matrix[0:1], tfidf_matrix[1:2])[0][0]
            
            if similarity > 0.3:
                return similarity * 0.5
        except:
            pass
        
        return 0.0
    
    def calculate_enhanced_similarity(self, jobseeker_skills, job_requirements):
        """Calculate enhanced similarity using semantic matching"""
        if not jobseeker_skills or not job_requirements:
            return 0.0, []
        
        # Normalize skills
        js_skills = [self.normalize_skill(skill) for skill in jobseeker_skills]
        job_skills = [self.normalize_skill(skill) for skill in job_requirements]
        
        total_matches = 0.0
        match_details = []
        
        for job_skill in job_skills:
            best_match_score = 0.0
            best_match_skill = None
            
            for js_skill in js_skills:
                similarity = self.calculate_semantic_similarity(js_skill, job_skill)
                
                if similarity > best_match_score:
                    best_match_score = similarity
                    best_match_skill = js_skill
            
            if best_match_score > 0.3:  # Threshold for considering a match
                total_matches += best_match_score
                match_details.append({
                    'job_skill': job_skill,
                    'matched_skill': best_match_skill,
                    'similarity': best_match_score,
                    'match_type': self._get_match_type(best_match_score)
                })
        
        # Calculate overall similarity
        max_possible_score = len(job_skills)
        similarity_score = total_matches / max_possible_score if max_possible_score > 0 else 0.0
        
        return min(similarity_score, 1.0), match_details
    
    def _get_match_type(self, score):
        """Determine match type based on score"""
        if score >= 0.9:
            return 'exact'
        elif score >= 0.7:
            return 'synonym'
        elif score >= 0.5:
            return 'related'
        else:
            return 'partial'
    
    def get_enhanced_matched_skills(self, jobseeker_skills, job_requirements):
        """Get detailed matched skills with confidence scores"""
        similarity_score, match_details = self.calculate_enhanced_similarity(jobseeker_skills, job_requirements)
        
        matched_skills = []
        for match in match_details:
            matched_skills.append({
                'skill': match['job_skill'],
                'matched_with': match['matched_skill'],
                'confidence': round(match['similarity'], 2),
                'match_type': match['match_type']
            })
        
        return matched_skills
    
    def get_enhanced_missing_skills(self, jobseeker_skills, job_requirements):
        """Get missing skills that couldn't be matched"""
        similarity_score, match_details = self.calculate_enhanced_similarity(jobseeker_skills, job_requirements)
        
        matched_job_skills = [match['job_skill'] for match in match_details]
        missing_skills = []
        
        for job_skill in job_requirements:
            normalized_job_skill = self.normalize_skill(job_skill)
            if normalized_job_skill not in matched_job_skills:
                missing_skills.append(job_skill)
        
        return missing_skills
    
    def cluster_skills(self, skills, n_clusters=None):
        """Cluster skills using K-means"""
        if len(skills) < 2:
            return {0: skills}
        
        # Expand skills for better clustering
        expanded_skills = []
        for skill in skills:
            expanded = self.expand_skill(skill)
            expanded_skills.append(' '.join(expanded))
        
        try:
            # Create TF-IDF matrix
            tfidf_matrix = self.vectorizer.fit_transform(expanded_skills)
            
            # Determine optimal number of clusters
            if n_clusters is None:
                n_clusters = min(5, len(skills) // 2 + 1)
            
            # Perform clustering
            kmeans = KMeans(n_clusters=n_clusters, random_state=42, n_init=10)
            cluster_labels = kmeans.fit_predict(tfidf_matrix)
            
            # Group skills by cluster
            clusters = {}
            for i, label in enumerate(cluster_labels):
                if label not in clusters:
                    clusters[label] = []
                clusters[label].append(skills[i])
            
            return clusters
            
        except Exception as e:
            print(f"Clustering error: {e}")
            return {0: skills}