import unittest
from src.models.recommender import compute_similarity, get_recommendations

class TestRecommender(unittest.TestCase):

    def setUp(self):
        self.jobseeker_skills = ['Python', 'Machine Learning', 'Data Analysis']
        self.job_requirements = [
            {'title': 'Data Scientist', 'skills': ['Python', 'Machine Learning', 'Statistics']},
            {'title': 'Software Engineer', 'skills': ['Java', 'Spring', 'Data Structures']},
            {'title': 'Data Analyst', 'skills': ['Python', 'Data Analysis', 'Excel']}
        ]

    def test_compute_similarity(self):
        similarity_score = compute_similarity(self.jobseeker_skills, self.job_requirements[0]['skills'])
        self.assertGreaterEqual(similarity_score, 0)
        self.assertLessEqual(similarity_score, 1)

    def test_get_recommendations(self):
        recommendations = get_recommendations(self.jobseeker_skills, self.job_requirements)
        self.assertIsInstance(recommendations, list)
        self.assertGreater(len(recommendations), 0)
        self.assertIn('Data Scientist', [job['title'] for job in recommendations])
        self.assertIn('Data Analyst', [job['title'] for job in recommendations])

if __name__ == '__main__':
    unittest.main()