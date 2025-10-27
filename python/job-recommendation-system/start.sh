#!/bin/bash

# Start Python Flask app with Gunicorn
gunicorn --bind 0.0.0.0:$PORT --workers 2 app:app
