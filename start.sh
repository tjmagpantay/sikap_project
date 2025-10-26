# start.sh
#!/bin/bash

# Start PHP built-in server
cd public
php -S 0.0.0.0:$PORT index.php