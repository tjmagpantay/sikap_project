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
from recommend import JobRecommendationEngine, test_database_connection, get_sample_jobseeker_ids

app = Flask(__name__)

# Initialize the recommendation engine
try:
    recommendation_engine = JobRecommendationEngine()
except Exception as e:
    print(f"Warning: Could not initialize recommendation engine: {e}", file=sys.stderr)
    recommendation_engine = None

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
        # Validate parameters
        jobseeker_id = request.args.get("jobseeker_id", type=int)
        top_k = request.args.get("top_k", default=10, type=int)
        
        if not jobseeker_id:
            return jsonify({
                "error": "jobseeker_id parameter is required",
                "usage": "/recommendations?jobseeker_id=1&top_k=5"
            }), 400
        
        if top_k <= 0 or top_k > 50:
            return jsonify({
                "error": "top_k must be between 1 and 50"
            }), 400
        
        # Generate recommendations
        result = recommendation_engine.generate_recommendations(jobseeker_id, top_k)
        
        if "error" in result:
            return jsonify(result), 404
        
        # Add metadata
        result["api_info"] = {
            "version": "1.0",
            "timestamp": "2024-12-19",
            "algorithm": "TF-IDF + Skill Matching + ESCO + Role Matching"
        }
        
        return jsonify(result)
        
    except ValueError as e:
        return jsonify({
            "error": f"Invalid parameter: {str(e)}"
        }), 400
        
    except Exception as e:
        return jsonify({
            "error": "Internal server error",
            "message": "An unexpected error occurred while generating recommendations"
        }), 500

@app.route("/jobseeker/<int:jobseeker_id>/profile")
def get_jobseeker_profile(jobseeker_id):
    """Get jobseeker profile data (for debugging)"""
    try:
        profile = recommendation_engine.fetch_jobseeker_profile(jobseeker_id)
        
        if profile is None:
            return jsonify({"error": "Jobseeker not found"}), 404
        
        # Convert pandas Series to dict
        profile_dict = profile.to_dict()
        
        return jsonify({
            "jobseeker_id": jobseeker_id,
            "profile": profile_dict
        })
        
    except Exception as e:
        return jsonify({
            "error": "Internal server error"
        }), 500

@app.errorhandler(404)
def not_found(error):
    """Handle 404 errors"""
    return jsonify({
        "error": "Endpoint not found",
        "message": "Check the API documentation at the root endpoint"
    }), 404

@app.errorhandler(500)
def internal_error(error):
    """Handle 500 errors"""
    return jsonify({
        "error": "Internal server error",
        "message": "An unexpected error occurred"
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
        print("Starting SIKAP Job Recommendation API...")
        print("Server: http://127.0.0.1:5001")
        
        # Run the app
        app.run(debug=True, host='127.0.0.1', port=5001)