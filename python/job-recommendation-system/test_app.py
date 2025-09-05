"""
Test the Flask app imports and basic functionality
"""

import sys
import os

# Add the src directory to Python path
sys.path.append(os.path.join(os.path.dirname(__file__), 'src'))

print("Testing imports...")

try:
    from flask import Flask
    print("✅ Flask imported successfully")
except ImportError as e:
    print(f"❌ Flask import error: {e}")

try:
    from config.settings import API_HOST, API_PORT, DEBUG, UPLOAD_FOLDER
    print("✅ Settings imported successfully")
    print(f"   API will run on: {API_HOST}:{API_PORT}")
    print(f"   Upload folder: {UPLOAD_FOLDER}")
except ImportError as e:
    print(f"❌ Settings import error: {e}")

try:
    from models.recommender import JobRecommender
    print("✅ JobRecommender imported successfully")
except ImportError as e:
    print(f"❌ JobRecommender import error: {e}")

try:
    from parsers.resume_parser import ResumeParser
    print("✅ ResumeParser imported successfully")
except ImportError as e:
    print(f"❌ ResumeParser import error: {e}")

try:
    from utils.skill_matcher import SkillMatcher
    print("✅ SkillMatcher imported successfully")
except ImportError as e:
    print(f"❌ SkillMatcher import error: {e}")

print("\n" + "="*50)
print("Import test completed!")