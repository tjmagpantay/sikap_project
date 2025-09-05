import unittest
from src.utils.skill_matcher import match_skills

class TestSkillMatcher(unittest.TestCase):

    def setUp(self):
        self.jobseeker_skills = ['Python', 'Machine Learning', 'Data Analysis']
        self.job_posting_skills = ['Python', 'Deep Learning', 'Data Science']

    def test_match_skills_exact(self):
        matched_skills = match_skills(self.jobseeker_skills, self.job_posting_skills)
        expected_skills = ['Python']
        self.assertEqual(matched_skills, expected_skills)

    def test_match_skills_partial(self):
        self.jobseeker_skills.append('Deep Learning')
        matched_skills = match_skills(self.jobseeker_skills, self.job_posting_skills)
        expected_skills = ['Python', 'Deep Learning']
        self.assertEqual(matched_skills, expected_skills)

    def test_match_skills_none(self):
        self.jobseeker_skills = ['Java', 'C++']
        matched_skills = match_skills(self.jobseeker_skills, self.job_posting_skills)
        expected_skills = []
        self.assertEqual(matched_skills, expected_skills)

if __name__ == '__main__':
    unittest.main()