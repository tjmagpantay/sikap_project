"""
SIKAP Job Recommendation API
Flask application that provides REST endpoints for job recommendations
"""
import os
import sys

# Ensure we're in the right directory
current_dir = os.path.dirname(os.path.abspath(__file__))
os.chdir(current_dir)
sys.path.insert(0, current_dir)

print(f"Working directory: {os.getcwd()}")
print(f" Python path: {sys.path[:3]}")

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
import traceback
from werkzeug.exceptions import RequestTimeout

# Add the current directory to Python path
sys.path.append(os.path.dirname(os.path.abspath(__file__)))

# Import your recommendation module
from recommend import JobRecommendationEngine

app = Flask(__name__)

# CORS configuration
CORS(app, origins=[
    'https://sikap.site/',
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
    recommendation_system = JobRecommendationEngine()
    logger.info("Recommendation system initialized successfully")
except Exception as e:
    logger.error(f"Failed to initialize recommendation system: {e}")
    recommendation_system = None

@app.route("/")
def home():
    """API home page with available endpoints"""
    return """
    <h1>SIKAP Job Recommendation API</h1>
    <h3>Available Endpoints:</h3>
    <ul>
        <li><strong>GET /health</strong> - Check API status</li>
        <li><strong>GET /recommendations?jobseeker_id=X&top_k=5</strong> - Get recommendations</li>
        <li><strong>POST /recommendations</strong> - Get recommendations (JSON)</li>
        <li><strong>GET /test</strong> - Simple test</li>
    </ul>
    <p>Status: """ + ("System Ready" if recommendation_system else "System Error") + """</p>
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

@app.route("/recommendations", methods=['GET', 'POST'])
def get_recommendations():
    """Support both GET and POST requests for recommendations"""
    try:
        import time
        start_time = time.time()
        
        # Handle GET request parameters
        if request.method == 'GET':
            jobseeker_id = request.args.get('jobseeker_id')
            top_k = int(request.args.get('top_k', 10))
            debug = request.args.get('debug', 'false').lower() == 'true'
            
        # Handle POST request JSON
        else:  # POST
            data = request.get_json()
            if not data:
                return jsonify({'success': False, 'error': 'No JSON data provided'}), 400
            jobseeker_id = data.get('jobseeker_id')
            top_k = data.get('top_k', 10)
            debug = data.get('debug', False)
        
        # Validate parameters
        if not jobseeker_id:
            return jsonify({'success': False, 'error': 'jobseeker_id is required'}), 400
        
        try:
            jobseeker_id = int(jobseeker_id)
            top_k = min(int(top_k), 50)  # Limit to 50
        except (ValueError, TypeError):
            return jsonify({'success': False, 'error': 'Invalid parameters'}), 400
        
        # Check if recommendation system is available
        if not recommendation_system:
            return jsonify({'success': False, 'error': 'Recommendation system not initialized'}), 503
        
        # Add timeout protection
        try:
            result = recommendation_system.generate_enhanced_recommendations_v2_optimized(
                jobseeker_id, top_k, debug
            )
        except Exception as rec_error:
            logger.error(f"Recommendation generation failed: {rec_error}")
            logger.error(traceback.format_exc())
            return jsonify({
                'success': False, 
                'error': 'Recommendation service temporarily unavailable',
                'debug_info': str(rec_error) if debug else None
            }), 503
        
        processing_time = round(time.time() - start_time, 2)
        result['processing_time_seconds'] = processing_time
        result['request_method'] = request.method
        
        print(f"{request.method} recommendation request completed in {processing_time}s")
        
        return jsonify(result)
        
    except RequestTimeout:
        return jsonify({'success': False, 'error': 'Request timeout'}), 408
    except Exception as e:
        logger.error(f"Unexpected error in recommendations: {e}")
        logger.error(traceback.format_exc())
        return jsonify({'success': False, 'error': 'Internal server error'}), 500

@app.route("/test", methods=['GET'])
def test_endpoint():
    """Test endpoint"""
    return jsonify({
        'message': 'Python service is working!',
        'timestamp': datetime.now().isoformat(),
        'recommendation_system': 'initialized' if recommendation_system else 'failed',
        'available_endpoints': ['/health', '/recommendations', '/test']
    })

# Add request timeout handling
@app.before_request
def before_request():
    """Set request timeout"""
    request.timeout = 30  # 30 seconds

if __name__ == "__main__":
    port = int(os.environ.get('PORT', 5000))
    debug = os.environ.get('FLASK_ENV') == 'development'
    
    print(f"Starting SIKAP ML service on http://127.0.0.1:{port}")
    print(f"Debug mode: {debug}")
    print(f"Recommendation system: {' Ready' if recommendation_system else 'Failed'}")
    
    app.run(host='0.0.0.0', port=port, debug=debug)