<?php
// filepath: c:\xampp\htdocs\sikap\config\sikap_db.template.php
// Copy this to sikap_db.php and configure for your environment

return [
    // Database Configuration - Use environment variables in production
    'db_host' => $_ENV['MYSQLHOST'] ?? getenv('MYSQLHOST') ?? 'localhost',
    'db_name' => $_ENV['MYSQLDATABASE'] ?? getenv('MYSQLDATABASE') ?? 'sikap_db',
    'db_user' => $_ENV['MYSQLUSER'] ?? getenv('MYSQLUSER') ?? 'root',
    'db_pass' => $_ENV['MYSQLPASSWORD'] ?? getenv('MYSQLPASSWORD') ?? '',
    'db_port' => $_ENV['MYSQLPORT'] ?? getenv('MYSQLPORT') ?? '3306',

    // API Configuration
    'api_url' => $_ENV['PYTHON_ML_URL'] ?? getenv('PYTHON_ML_URL') ?? 'http://localhost:5000',
];