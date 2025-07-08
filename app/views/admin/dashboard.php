<?php
// Debug session
error_log("Dashboard.php - Current session: " . print_r($_SESSION, true));

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    error_log("Access denied in dashboard.php");
    header('Location: ?page=admin-login');
    exit;
}
?>
<body class="bg-gray-50">
    <div class="flex h-screen">
        <!-- Sidebar - Fixed Left -->
        <?php include __DIR__ . '/components/sidebar.php'; ?>
        
        <!-- Main Content Area - Right Side -->
        <div class="flex flex-col flex-1 overflow-hidden">
            <!-- Top Navigation -->
            <?php include __DIR__ . '/components/topbar.php'; ?>
            
            <!-- Main Dashboard Content -->
            <main class="flex-1 overflow-y-auto bg-gray-50">
                <?php include __DIR__ . '/components/main-board.php'; ?>
            </main>
        </div>
    </div>

    <!-- Mobile Menu Overlay -->
    <div id="mobile-menu-overlay" class="fixed inset-0 z-40 hidden bg-black bg-opacity-50 lg:hidden"></div>

    <script>
        // Mobile menu toggle
        function toggleSidebar() {
            const sidebarMobile = document.getElementById('sidebar-mobile');
            const overlay = document.getElementById('mobile-menu-overlay');
            
            if (sidebarMobile) {
                sidebarMobile.classList.toggle('-translate-x-full');
                overlay.classList.toggle('hidden');
            }
        }

        // Close sidebar when clicking overlay
        document.getElementById('mobile-menu-overlay').addEventListener('click', toggleSidebar);
    </script>
</body>
</html>