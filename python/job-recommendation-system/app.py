"""
SIKAP Job Recommendation API
Flask application that provides REST endpoints for job recommendations
"""
import os
import sys

# Handle Windows encoding issues at the very start
if os.name == 'nt':  # Windows
    import codecs
    sys.stdout = codecs.getwriter('utf-8')(sys.stdout.detach())
    sys.stderr = codecs.getwriter('utf-8')(sys.stderr.detach())

import json 
from flask import Flask, request, jsonify
from flask_cors import CORS
from datetime import datetime
import logging

# Add the current directory to Python path
sys.path.append(os.path.dirname(os.path.abspath(__file__)))

# Import your recommendation module
from recommend import JobRecommendationSystem

app = Flask(__name__)

# UPDATED: Allow your Hostinger domain and localhost
CORS(app, origins=[
    'https://your-domain.com',      # Replace with your Hostinger domain
    'http://your-domain.com',       
    'https://www.your-domain.com',  
    'http://localhost',
    'http://127.0.0.1',
    'http://localhost:3000',
    'http://localhost:8000'
])

# Configure logging
logging.basicConfig(level=logging.INFO)
logger = logging.getLogger(__name__)

# Initialize recommendation system
try:
    recommendation_system = JobRecommendationSystem()
    logger.info("Recommendation system initialized successfully")
except Exception as e:
    logger.error(f"Failed to initialize recommendation system: {e}")
    recommendation_system = None

@app.route("/")
def home():
    """API home page with available endpoints"""
    return """
    <div style="font-family: Arial, sans-serif; margin: 40px;">
        <h1>SIKAP Job Recommendation API</h1>
        
        
        <h3>Available Endpoints:</h3>
        <ul>
            <li><strong>GET /health</strong> - Check API and database status</li>
            <li><strong>GET /recommendations</strong> - Get job recommendations for a jobseeker</li>
        </ul>
        
      
    </div>
    """

@app.route('/health', methods=['GET'])
def health_check():
    """Health check endpoint"""
    return jsonify({
        'status': 'healthy',
        'service': 'SIKAP ML Recommendation Service',
        'timestamp': datetime.now().isoformat(),
        'version': '1.0.0',
        'recommendation_system_status': 'initialized' if recommendation_system else 'failed'
    })

@app.route("/health")
def health():
    """Health check endpoint"""
    try:
        # Test database connection
        db_status = test_database_connection()
        
        if db_status:
            return jsonify({
                "ok": True,
                "status": "healthy",
                "database": "connected",
                "message": "SIKAP Job Recommendation API is running"
            })
        else:
            return jsonify({
                "ok": False,
                "status": "unhealthy", 
                "database": "disconnected",
                "message": "Database connection failed"
            }), 503
            
    except Exception as e:
        return jsonify({
            "ok": False,
            "status": "error",
            "error": str(e)
        }), 500

@app.route("/recommendations")
def get_recommendations():
    """Get job recommendations for a jobseeker"""
    try:
        # Check if recommendation system is available
        if not recommendation_system:
            return jsonify({
                'success': False,
                'error': 'Recommendation system not available'
            }), 503

        # Validate request
        if not request.is_json:
            return jsonify({
                'success': False,
                'error': 'Content-Type must be application/json'
            }), 400

        data = request.get_json()
        
        # Validate required parameters
        if 'jobseeker_id' not in data:
            return jsonify({
                'success': False,
                'error': 'jobseeker_id is required'
            }), 400

        jobseeker_id = int(data['jobseeker_id'])
        top_k = int(data.get('top_k', 10))

        # Validate parameters
        if jobseeker_id <= 0:
            return jsonify({
                'success': False,
                'error': 'Invalid jobseeker_id'
            }), 400

        if top_k <= 0 or top_k > 100:
            return jsonify({
                'success': False,
                'error': 'top_k must be between 1 and 100'
            }), 400

        logger.info(f"Getting recommendations for jobseeker {jobseeker_id}, top_k={top_k}")

        # Get recommendations
        recommendations = recommendation_system.get_recommendations(jobseeker_id, top_k)
        
        if recommendations:
            logger.info(f"Successfully generated {len(recommendations.get('recommendations', []))} recommendations")
            return jsonify(recommendations)
        else:
            return jsonify({
                'success': False,
                'error': 'No recommendations found'
            }), 404

    except ValueError as e:
        logger.error(f"Value error in recommendations: {e}")
        return jsonify({
            'success': False,
            'error': f'Invalid parameter: {str(e)}'
        }), 400
    except Exception as e:
        logger.error(f"Error generating recommendations: {e}")
        return jsonify({
            'success': False,
            'error': 'Internal server error'
        }), 500

@app.route('/jobseeker/<int:jobseeker_id>/profile', methods=['GET'])
def get_jobseeker_profile(jobseeker_id):
    """Get jobseeker profile data for recommendations"""
    try:
        if not recommendation_system:
            return jsonify({
                'success': False,
                'error': 'Recommendation system not available'
            }), 503

        profile_data = recommendation_system.get_jobseeker_profile(jobseeker_id)
        
        if profile_data:
            return jsonify({
                'success': True,
                'data': profile_data
            })
        else:
            return jsonify({
                'success': False,
                'error': 'Jobseeker not found'
            }), 404

    except Exception as e:
        logger.error(f"Error getting jobseeker profile: {e}")
        return jsonify({
            'success': False,
            'error': 'Internal server error'
        }), 500

@app.route('/test', methods=['GET', 'POST'])
def test_endpoint():
    """Test endpoint for debugging"""
    return jsonify({
        'success': True,
        'message': 'Python microservice is working!',
        'method': request.method,
        'timestamp': datetime.now().isoformat(),
        'headers': dict(request.headers),
        'data': request.get_json() if request.is_json else None
    })

@app.errorhandler(404)
def not_found(error):
    return jsonify({
        'success': False,
        'error': 'Endpoint not found'
    }), 404

@app.errorhandler(500)
def internal_error(error):
    return jsonify({
        'success': False,
        'error': 'Internal server error'
    }), 500

def handle_command_line():
    """Handle command line arguments for PHP integration"""
    import sys
    
    if len(sys.argv) < 2:
        print(json.dumps({"error": "Missing command argument"}))
        return
    
    command = sys.argv[1]
    
    if command == "recommendations":
        if len(sys.argv) < 4:
            print(json.dumps({"error": "Missing jobseeker_id and top_k arguments"}))
            return
        
        try:
            jobseeker_id = int(sys.argv[2])
            top_k = int(sys.argv[3])
            
            result = recommendation_engine.generate_recommendations(jobseeker_id, top_k)
            
            # Ensure we return valid JSON
            if "error" not in result:
                result["success"] = True
                result["total_found"] = len(result.get("recommendations", []))
            else:
                result["success"] = False
            
            # Print ONLY the JSON result to stdout
            print(json.dumps(result, indent=None, separators=(',', ':')))
            
        except ValueError as e:
            print(json.dumps({"success": False, "error": f"Invalid arguments: {e}"}))
        except Exception as e:
            print(json.dumps({"success": False, "error": f"Recommendation error: {str(e)}"}), file=sys.stderr)
            print(json.dumps({"success": False, "error": "Internal server error"}))
    
    elif command == "test":
        # Test database connection
        try:
            if test_database_connection():
                print(json.dumps({"success": True, "status": "success", "message": "Database connection successful"}))
            else:
                print(json.dumps({"success": False, "status": "error", "message": "Database connection failed"}))
        except Exception as e:
            print(json.dumps({"success": False, "status": "error", "message": f"Test error: {str(e)}"}))
    
    else:
        print(json.dumps({"success": False, "error": f"Unknown command: {command}"}))

if __name__ == "__main__":
    # Check if running from command line (for PHP integration)
    if len(sys.argv) > 1:
        handle_command_line()
    else:
        # Run Flask server
        port = int(os.environ.get('PORT', 5000))
        debug = os.environ.get('FLASK_ENV') == 'development'
        
        logger.info(f"Starting SIKAP ML service on port {port}")
        app.run(host='0.0.0.0', port=port, debug=debug)