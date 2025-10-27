"""
Configuration management for SIKAP Job Recommendation System
Reads from PHP config file for consistency
"""
import os
from dotenv import load_dotenv

# Load environment variables
load_dotenv()

# Railway Production Database Configuration
DB_CONFIG = {
    "host": os.getenv("MYSQLHOST", "shinkansen.proxy.rlwy.net"),
    "user": os.getenv("MYSQLUSER", "root"),
    "password": os.getenv("MYSQLPASSWORD", "kzqXGYUlxcfMLoNeoNYkwTOukstYjzRp"),
    "database": os.getenv("MYSQLDATABASE", "railway"),
    "port": int(os.getenv("MYSQLPORT", "23642"))
}

FLASK_CONFIG = {
    "port": int(os.getenv("FLASK_PORT", 5000)),
    "debug": os.getenv("FLASK_DEBUG", "False").lower() == "true",
    "host": os.getenv("FLASK_HOST", "0.0.0.0")  # Important for Render deployment
}

# XAMPP Local Development Configuration (COMMENTED OUT)
# DB_CONFIG = {
#     "host": os.getenv("DB_HOST", "localhost"),
#     "user": os.getenv("DB_USER", "root"),
#     "password": os.getenv("DB_PASS", ""),
#     "database": os.getenv("DB_NAME", "sikap_db")
# }

# FLASK_CONFIG = {
#     "port": int(os.getenv("FLASK_PORT", 5001)),
#     "debug": os.getenv("FLASK_DEBUG", "True").lower() == "true"
# }