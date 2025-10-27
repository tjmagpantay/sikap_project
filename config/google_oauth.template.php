<?php
// filepath: c:\xampp\htdocs\sikap\config\google_oauth.template.php
// Copy this to google_oauth.php and add your credentials

return [
    'client_id' => $_ENV['GOOGLE_CLIENT_ID'] ?? getenv('GOOGLE_CLIENT_ID') ?? 'your-client-id',
    'client_secret' => $_ENV['GOOGLE_CLIENT_SECRET'] ?? getenv('GOOGLE_CLIENT_SECRET') ?? 'your-client-secret',
    'redirect_uri' => $_ENV['GOOGLE_REDIRECT_URI'] ?? getenv('GOOGLE_REDIRECT_URI') ?? 'http://localhost/sikap/public/?page=google-callback'
];