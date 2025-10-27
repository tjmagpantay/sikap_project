#!/bin/bash

# Install PHP dependencies
if [ -f "composer.json" ]; then
    composer install --no-dev --optimize-autoloader --no-interaction
else
    echo "No composer.json found - skipping composer install"
fi

# Create required directories
# PRIVATE uploads (outside web root in production)
mkdir -p uploads/applications
mkdir -p uploads/documents
mkdir -p uploads/job_attachments

# PUBLIC uploads (web accessible)
mkdir -p public/uploads/applications
mkdir -p public/uploads/banners
mkdir -p public/uploads/events
mkdir -p public/uploads/profile_photos
mkdir -p public/uploads/profile_pictures

# Create .htaccess to protect private uploads
cat > uploads/.htaccess << 'EOF'
# Deny all web access to sensitive uploads
Order Deny,Allow
Deny from all
EOF

# Create .gitkeep files to preserve directory structure
touch uploads/.gitkeep
touch uploads/applications/.gitkeep
touch uploads/documents/.gitkeep
touch uploads/job_attachments/.gitkeep
touch public/uploads/.gitkeep
touch public/uploads/applications/.gitkeep
touch public/uploads/banners/.gitkeep
touch public/uploads/events/.gitkeep
touch public/uploads/profile_photos/.gitkeep
touch public/uploads/profile_pictures/.gitkeep

# Set permissions
chmod -R 755 uploads/ 2>/dev/null || echo "Could not set permissions for uploads/"
chmod -R 755 public/uploads/ 2>/dev/null || echo "Could not set permissions for public/uploads/"

# Create config files from templates
if [ ! -f "config/sikap_db.php" ] && [ -f "config/sikap_db.template.php" ]; then
    cp config/sikap_db.template.php config/sikap_db.php
    echo "Created config/sikap_db.php from template"
fi

if [ ! -f "config/google_oauth.php" ] && [ -f "config/google_oauth.template.php" ]; then
    cp config/google_oauth.template.php config/google_oauth.php
    echo "Created config/google_oauth.php from template"
fi

if [ ! -f "config/mailer.php" ] && [ -f "config/mailer.template.php" ]; then
    cp config/mailer.template.php config/mailer.php
    echo "Created config/mailer.php from template"
fi

echo "PHP build completed successfully"