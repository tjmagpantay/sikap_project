<?php
// filepath: c:\xampp\htdocs\sikap\config\mailer.template.php
// Copy this to mailer.php and add your email credentials

return [
    'host' => $_ENV['MAIL_HOST'] ?? getenv('MAIL_HOST') ?? 'smtp.gmail.com',
    'username' => $_ENV['MAIL_USERNAME'] ?? getenv('MAIL_USERNAME') ?? 'your-email@gmail.com',
    'password' => $_ENV['MAIL_PASSWORD'] ?? getenv('MAIL_PASSWORD') ?? 'your-app-password',
    'port' => $_ENV['MAIL_PORT'] ?? getenv('MAIL_PORT') ?? 587,
    'from_email' => $_ENV['MAIL_FROM_EMAIL'] ?? getenv('MAIL_FROM_EMAIL') ?? 'your-email@gmail.com',
    'from_name' => $_ENV['MAIL_FROM_NAME'] ?? getenv('MAIL_FROM_NAME') ?? 'PESO SIKAP'
];