<?php
// Temporary dashboard view for layout fixing
// include_once __DIR__ . '/components/admin_auth_check.php'; // <-- Disable auth check for now
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Temp</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>

<body class="bg-gray-50">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <?php include __DIR__ . '/components/sidebar.php'; ?>

        <!-- Main Content Area -->
        <div class="flex flex-col flex-1 overflow-hidden">
            <!-- Top Navigation -->
            <?php include __DIR__ . '/components/topbar.php'; ?>

            <!-- Main Dashboard Content -->
            <main class="flex-1 overflow-y-auto bg-gray-50 p-6">
                <?php
                // Simple router for main content
                $page = $_GET['page'] ?? 'dashboard';
                switch ($page) {
                    case 'dashboard':
                    default:
                        include __DIR__ . '/main-board.php';
                        break;
                        // You can add more cases for other pages if needed
                }
                ?>
            </main>
        </div>
    </div>

    <!-- Mobile Menu Overlay -->
    <div id="mobile-menu-overlay" class="fixed inset-0 z-40 hidden bg-black bg-opacity-50 lg:hidden"></div>

    <script>
        // Mobile menu toggle functions
        function toggleMobileSidebar() {
            const sidebarMobile = document.getElementById('sidebar-mobile');
            const overlay = document.getElementById('sidebar-overlay');

            if (sidebarMobile && overlay) {
                sidebarMobile.classList.toggle('-translate-x-full');
                overlay.classList.toggle('hidden');
            }
        }

        // Close sidebar when clicking overlay
        document.addEventListener('click', function(event) {
            if (event.target.id === 'sidebar-overlay') {
                toggleMobileSidebar();
            }
        });
    </script>
</body>

</html>