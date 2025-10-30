<?php
// filepath: c:\xampp\htdocs\sikap\config\ml_config.php
return [
    'python_api' => [
        'base_url' => 'https://sikap-ml.onrender.com',
        'timeout' => 30,
        'api_key' => $_ENV['PYTHON_API_KEY'] ?? 'your-secret-key',
        'retry_attempts' => 3,
        'retry_delay' => 1 // seconds
    ],
    'recommendations' => [
        'default_top_k' => 10,
        'max_top_k' => 50,
        'cache_duration' => 3600 // 1 hour in seconds
    ]
];