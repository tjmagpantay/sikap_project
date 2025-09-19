<?php
include_once __DIR__ . '/components/admin_auth_check.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>SIKAP Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#092C4C',
                        secondary: '#F3AF0E'
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Ensure proper height and overflow for layout */
        html,
        body {
            height: 100%;
            overflow: hidden;
        }

        .main-content {
            height: calc(100vh - 4rem);
            /* Subtract topbar height */
            overflow-y: auto;
        }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Topbar (Sticky) -->
    <?php include __DIR__ . '/components/topbar.php'; ?>

    <div class="flex h-screen">
        <!-- Sidebar (Fixed/Sticky) -->
        <?php include __DIR__ . '/components/sidebar.php'; ?>

        <!-- Main Content Area (Scrollable) -->
        <div class="flex-1 ml-80 main-content">
            <?php
            // Get the current page parameter
            $page = $_GET['page'] ?? 'admin-dashboard';

            // Route to appropriate content
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
                    include __DIR__ . '/reports.php';
                    break;
                case 'admin-applications':
                    include __DIR__ . '/applications.php';
                    break;
                case 'admin-chatbot':
                    include __DIR__ . '/chatbot.php';
                    break;
                case 'admin-events':
                    include __DIR__ . '/events.php';
                    break;
                case 'admin-event-create':
                    include __DIR__ . '/event-create.php';
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

    <!-- Mobile Menu Overlay -->
    <div id="mobile-menu-overlay" class="fixed inset-0 z-40 hidden bg-black bg-opacity-50 lg:hidden"></div>
</body>

</html>