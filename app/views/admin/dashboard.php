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
    <!-- Force reload CSS -->
    <link href="/sikap/public/assets/css/style.css?v=<?php echo time(); ?>" rel="stylesheet">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-gray-50 admin-body">
    <!-- Topbar (Fixed) -->
    <div class="admin-topbar">
        <?php include __DIR__ . '/components/topbar.php'; ?>
    </div>

    <!-- Sidebar (Fixed) -->
    <div id="admin-sidebar" class="admin-sidebar">
        <?php include __DIR__ . '/components/sidebar.php'; ?>
    </div>

    <!-- Mobile Overlay -->
    <div id="mobile-overlay" class="mobile-overlay" onclick="toggleMobileSidebar()"></div>

    <!-- Main Content Area (Properly positioned) -->
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
                case 'admin-view-job':
                    include __DIR__ . '/view-job.php';
                    break;
                case 'admin-job-categories':
                    include __DIR__ . '/job-categories.php';
                    break;
                case 'admin-accreditations':
                    include __DIR__ . '/accreditations.php';
                    break;
                case 'admin-review-accreditation':
                    include __DIR__ . '/review-accreditation.php';
                    break;
                case 'admin-reports':
                    include __DIR__ . '/all-reports.php';
                    break;
                case 'admin-applications':
                    include __DIR__ . '/application.php';
                    break;
                case 'admin-chatbot':
                    include __DIR__ . '/chatbot.php';
                    break;
                case 'admin-events':
                    include __DIR__ . '/events/event.php';
                    break;
                case 'admin-event-create':
                    include __DIR__ . '/events/create.php';
                    break;
                case 'admin-event-edit':
                    include __DIR__ . '/events/edit.php';
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

        // Add active state management for navigation
        document.addEventListener('DOMContentLoaded', function() {
            const currentPage = new URLSearchParams(window.location.search).get('page') || 'admin-dashboard';

            // Remove existing active classes
            document.querySelectorAll('#admin-sidebar a').forEach(link => {
                link.classList.remove('bg-primary', 'text-white');
                link.classList.add('text-gray-600');
            });

            // Add active class to current page
            const activeLink = document.querySelector(`#admin-sidebar a[href*="${currentPage}"]`);
            if (activeLink) {
                activeLink.classList.remove('text-gray-600', 'hover:bg-primary', 'hover:text-white');
                activeLink.classList.add('bg-primary', 'text-white');

                // If it's in a dropdown, open the dropdown
                const parentDropdown = activeLink.closest('ul[id*="Dropdown"]');
                if (parentDropdown) {
                    parentDropdown.classList.remove('hidden');
                    const arrow = document.querySelector(`#${parentDropdown.id.replace('Dropdown', 'DropdownArrow')}`);
                    if (arrow) {
                        arrow.classList.add('rotate-180');
                    }
                }
            }
        });
    </script>
</body>

</html>