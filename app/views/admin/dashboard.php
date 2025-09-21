<?php
include_once __DIR__ . '/components/admin_auth_check.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>SIKAP Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <!-- Use your local Tailwind CSS and custom styles -->
    <link href="/sikap/public/assets/css/style.css" rel="stylesheet">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-gray-50">
    <!-- Topbar (Fixed) -->
    <div class="admin-topbar">
        <?php include __DIR__ . '/components/topbar.php'; ?>
    </div>

    <!-- Sidebar (Fixed) -->
    <div id="admin-sidebar" class="bg-white admin-sidebar">
        <?php include __DIR__ . '/components/sidebar.php'; ?>
    </div>

    <!-- Mobile Overlay -->
    <div id="mobile-overlay" class="mobile-overlay" onclick="toggleMobileSidebar()"></div>

    <!-- Main Content Area -->
    <div class="admin-main">
        <div class="admin-content">
            <?php
            // Get the current page parameter
            $page = $_GET['page'] ?? 'admin-dashboard';

            // Route to appropriate CONTENT-ONLY files
            switch ($page) {
                case 'admin-dashboard':
                    include __DIR__ . '/main-board.php';
                    break;
                case 'admin-jobseekers':
                    include __DIR__ . '/jobseeker-management.php';
                    break;
                case 'admin-employers':
                    include __DIR__ . '/employer-management.php';
                    break;
                case 'admin-jobpost-management':
                    include __DIR__ . '/jobpost-management.php';
                    break;
                case 'admin-job-categories':
                    include __DIR__ . '/job-categories.php';
                    break;
                case 'admin-accreditations':
                    include __DIR__ . '/accreditations.php';
                    break;
                case 'admin-reports':
                    include __DIR__ . '/all-reports.php'; // Content-only version
                    break;
                case 'admin-applications':
                    include __DIR__ . '/application.php'; // Create content-only version
                    break;
                case 'admin-chatbot':
                    include __DIR__ . '/chatbot.php';
                    break;
                case 'admin-events':
                    include __DIR__ . '/events/event.php'; // Your content-only file
                    break;
                case 'admin-event-create':
                    include __DIR__ . '/events/create.php'; // Your content-only file
                    break;
                case 'admin-event-edit':
                    include __DIR__ . '/events/edit.php'; // Your content-only file
                    break;
                case 'admin-settings':
                    include __DIR__ . '/settings.php';
                    break;
                default:
                    include __DIR__ . '/main-board.php';
                    break;
            }
            ?>
        </div>
    </div>

    <script>
        // Mobile sidebar toggle functionality
        function toggleMobileSidebar() {
            const sidebar = document.getElementById('admin-sidebar');
            const overlay = document.getElementById('mobile-overlay');

            if (sidebar && overlay) {
                sidebar.classList.toggle('show');
                overlay.classList.toggle('show');
            }
        }

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('admin-sidebar');
            const overlay = document.getElementById('mobile-overlay');
            const mobileMenuButton = document.querySelector('[data-mobile-menu]');

            if (window.innerWidth < 1024 &&
                sidebar && overlay &&
                !sidebar.contains(event.target) &&
                !mobileMenuButton?.contains(event.target)) {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
            }
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            const sidebar = document.getElementById('admin-sidebar');
            const overlay = document.getElementById('mobile-overlay');

            if (window.innerWidth >= 1024) {
                if (sidebar && overlay) {
                    sidebar.classList.remove('show');
                    overlay.classList.remove('show');
                }
            }
        });
    </script>
</body>

</html>