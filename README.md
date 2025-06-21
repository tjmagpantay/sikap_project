# Sikap

A modular PHP web application with a Python ML microservice. This project is structured using the MVC (Model-View-Controller) pattern for maintainability and scalability.

## Project Structure

```
/sikap/                     <-- Root folder of your project
│
├── /app/                   <-- Application core (MVC)
│   ├── /controllers/       <-- Controllers: handle user requests and routing logic
│   ├── /models/            <-- Models: database interaction and data models
│   └── /views/             <-- Views: page templates and UI (PHP)
│       ├── /components/    <-- Reusable PHP components (header, footer, nav, etc.)
│       ├── /pages/         <-- Page-specific views (landing-page.php, etc.)
└── /config/              <-- Configuration file (DB creds, API URLs), kept outside 
│    └── sikap_db.php       <-- db connection 
│     
├── /public/                <-- Public web root accessible to users
│   ├── /assets/            <-- Static assets
│   │   ├── /css/           <-- Tailwind compiled CSS files (e.g., output.css)
│   │   ├── /js/            <-- JavaScript files
│   │   └── /images/        <-- Images and icons
│   ├── index.php           <-- Main entry point (front controller)
│   └── .htaccess           <-- Apache config for routing/security
│
├── /tailwind/              <-- Tailwind CSS source and config files
│   ├── input.css           <-- Tailwind directives and custom CSS
│   └── tailwind.config.js  <-- Tailwind configuration file
│
├── /ml_service/            <-- Python Flask ML microservice files
│   ├── app.py
│   ├── model.pkl
│   └── requirements.txt
│
├── /tests/                 <-- Automated test files (PHPUnit, etc.)
│
├── .gitignore
├── composer.json           <-- PHP dependency manager config (if used)
├── README.md               <-- Project documentation
```

## Setup

- Install PHP dependencies with Composer (if used).
- Set up your database and configure `config.php`.
- Install Tailwind CSS in `/tailwind/` and build your CSS:
  ```
  npx tailwindcss -c tailwind/tailwind.config.js -i tailwind/input.css -o public/assets/css/output.css --watch
  ```
- The ML microservice is in `/ml_service/` and can be developed/run separately.

---

**Note:**  
This structure follows the MVC pattern for clear separation of concerns and easy future expansion.