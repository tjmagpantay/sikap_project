import unittest
from src.parsers.resume_parser import parse_resume

class TestResumeParser(unittest.TestCase):

    def test_parse_valid_resume(self):
        resume_path = 'path/to/valid_resume.pdf'
        expected_output = {
            'name': 'John Doe',
            'email': 'john.doe@example.com',
            'skills': ['Python', 'Machine Learning', 'Data Analysis'],
            'experience': [
                {'job_title': 'Data Scientist', 'company': 'Tech Corp', 'duration': '2 years'},
                {'job_title': 'Software Engineer', 'company': 'Web Solutions', 'duration': '1 year'}
            ]
        }
        result = parse_resume(resume_path)
        self.assertEqual(result, expected_output)

    def test_parse_invalid_resume(self):
        resume_path = 'path/to/invalid_resume.pdf'
        result = parse_resume(resume_path)
        self.assertIsNone(result)

    def test_parse_empty_resume(self):
        resume_path = 'path/to/empty_resume.pdf'
        result = parse_resume(resume_path)
        self.assertIsNone(result)

if __name__ == '__main__':
    unittest.main()