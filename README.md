# Sikap

A modular PHP web application with a Python ML microservice. This project is structured for maintainability and scalability.

## Project Structure

```
/sikap/                  <-- Root folder of your project
│
├── /app/                <-- Backend logic (PHP)
│   ├── /Controllers/    <-- Handle user requests and routing logic
│   ├── /Models/         <-- Database interaction and data models
│   └── /Services/       <-- Business logic & external services (e.g., ML API client)
│
├── /public/             <-- Public web root accessible to users
│   ├── /assets/         <-- Static assets
│   │   ├── /css/        <-- Tailwind compiled CSS files (e.g., output.css)
│   │   ├── /js/         <-- JavaScript files (vanilla or libs)
│   │   └── /images/     <-- Images and icons
│   ├── index.php        <-- Main entry point (front controller)
│   └── .htaccess        <-- Apache config for routing/security
│
├── /resources/          <-- Views & reusable UI components
│   ├── /components/     <-- Reusable PHP components (header.php, footer.php, buttons, forms)
│   ├── /layouts/        <-- Layout wrappers (e.g., main layout file)
│   ├── /admin/          <-- Admin-specific views
│   ├── /jobseekers/     <-- Job seekers views
│   └── /employers/      <-- Employer views
│
├── /tailwind/           <-- Tailwind CSS source and config files
│   ├── input.css        <-- Tailwind directives and custom CSS imports
│   ├── tailwind.config.js <-- Tailwind configuration file
│
├── /ml_service/         <-- Python Flask ML microservice files
│   ├── app.py
│   ├── model.pkl
│   └── requirements.txt
│
├── /tests/              <-- Automated test files (PHPUnit, etc.)
│
├── .gitignore
├── composer.json        <-- PHP dependency manager config (if used)
├── README.md            <-- Project documentation
└── config.php           <-- Configuration file (DB creds, API URLs), kept outside public
```

## Setup
- Install PHP dependencies with Composer (if used).
- Set up your database and configure `config.php`.
- Install Tailwind CSS manually in `/tailwind/` as you prefer.
- The ML microservice will be developed last in `/ml_service/`.

---

**Note:** This structure is designed for separation of concerns and easy future expansion.

-- npx tailwindcss -c tailwind/tailwind.config.js -i tailwind/input.css -o public/assets/css/output.css --watch