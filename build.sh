#!/bin/bash
# filepath: c:\xampp\htdocs\sikap\build.sh

# Install PHP dependencies
if [ -f "composer.json" ]; then
    composer install --no-dev --optimize-autoloader --no-interaction
    echo "Composer dependencies installed"
else
    echo "No composer.json found - skipping composer install"
fi

# Create required directories
mkdir -p uploads/applications uploads/documents uploads/job_attachments
mkdir -p public/uploads/applications public/uploads/banners public/uploads/events
mkdir -p public/uploads/profile_photos public/uploads/profile_pictures

# Create .htaccess to protect private uploads
cat > uploads/.htaccess << 'EOF'
# Deny all web access to sensitive uploads
<Files "*">
    Order Deny,Allow
    Deny from all
</Files>
EOF

# Create .gitkeep files to preserve directory structure
touch uploads/.gitkeep uploads/applications/.gitkeep uploads/documents/.gitkeep uploads/job_attachments/.gitkeep
touch public/uploads/.gitkeep public/uploads/applications/.gitkeep public/uploads/banners/.gitkeep
touch public/uploads/events/.gitkeep public/uploads/profile_photos/.gitkeep public/uploads/profile_pictures/.gitkeep

# Set permissions for shared hosting
chmod -R 755 uploads/ public/uploads/ 2>/dev/null || echo "Permission setting may be restricted on shared hosting"

# Create config files from templates (for local development)
for template in config/*.template.php; do
    if [ -f "$template" ]; then
        config_file="${template%.template.php}.php"
        if [ ! -f "$config_file" ]; then
            cp "$template" "$config_file"
            echo "Created $(basename "$config_file") from template"
        fi
    fi
done

echo "PHP build completed successfully for Hostinger deployment"