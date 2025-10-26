# build.sh
#!/bin/bash

# Install PHP dependencies if you have composer.json
# composer install --no-dev --optimize-autoloader

# Set permissions for uploads directory
mkdir -p uploads
chmod 755 uploads

# Any other build steps
echo "Build completed successfully"