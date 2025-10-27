#!/bin/bash

# Install PHP dependencies
if [ -f "composer.json" ]; then
    composer install --no-dev --optimize-autoloader --no-interaction
fi

# Create required directories
mkdir -p uploads/applications
mkdir -p uploads/documents
mkdir -p uploads/job_attachments
mkdir -p uploads/profile_photos
mkdir -p uploads/profile_pictures
mkdir -p uploads/banners
mkdir -p uploads/events

# Set permissions for uploads directory
chmod -R 755 uploads/

# Create config files from templates if they don't exist
if [ ! -f "config/sikap_db.php" ] && [ -f "config/sikap_db.template.php" ]; then
    cp config/sikap_db.template.php config/sikap_db.php
fi

if [ ! -f "config/google_oauth.php" ] && [ -f "config/google_oauth.template.php" ]; then
    cp config/google_oauth.template.php config/google_oauth.php
fi

if [ ! -f "config/mailer.php" ] && [ -f "config/mailer.template.php" ]; then
    cp config/mailer.template.php config/mailer.php
fi

echo "PHP build completed successfully"