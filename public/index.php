<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-2vWTFzTx5TkQ0CKg5sG3rMd8W2jcJGkX+9L5wz1tCwLmfIu5FgDf0uB/hgsWmPB0wDCaY6FUVuLuqm+ne+0hMA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="./assets/css/output.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

</head>
<body class="font-inter">
    <?php
    session_start();

    $page = $_GET['page'] ?? 'landing';

    switch ($page) {
        case 'landing':
            include __DIR__ . '/../app/views/pages/landing-page.php';
            break;
        case 'login':
            require_once __DIR__ . '/../app/controllers/UserController.php';
            $controller = new UserController();
            $controller->login();
            break;
        case 'signup':
            require_once __DIR__ . '/../app/controllers/UserController.php';
            $controller = new UserController();
            $controller->signup();
            break;
        case 'employer-complete-profile':
            require_once __DIR__ . '/../app/controllers/EmployerController.php';
            $controller = new EmployerController();
            $controller->completeProfile();
            break;
        default:
            include_once __DIR__ . '/../app/views/pages/landing-page.php';
            break;
    }
    ?>
    
</body>
</html>

