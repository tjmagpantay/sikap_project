"""
Configuration management for SIKAP Job Recommendation System
Reads from PHP config file for consistency
"""
import os
from dotenv import load_dotenv

# Load environment variables
load_dotenv()

DB_CONFIG = {
    "host": os.getenv("DB_HOST", "localhost"),
    "user": os.getenv("DB_USER", "root"),
    "password": os.getenv("DB_PASS", ""),
    "database": os.getenv("DB_NAME", "sikap_db")
}

FLASK_CONFIG = {
    "port": int(os.getenv("FLASK_PORT", 5001)),
    "debug": os.getenv("FLASK_DEBUG", "True").lower() == "true"
}