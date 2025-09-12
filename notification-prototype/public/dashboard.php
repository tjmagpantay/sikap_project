<?php
// Handle user switching
if (isset($_GET['switch_user'])) {
    $_SESSION['user_id'] = (int)$_GET['switch_user'];
    header("Location: ?route=dashboard");
    exit;
}

// Handle job application
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == 'apply') {
    $appModel = new Application($pdo);
    $appModel->create($_POST['job_id'], $_SESSION['user_id']);
    echo "<script>alert('Application submitted!'); window.location.reload();</script>";
    exit;
}

// Get current user info
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
$stmt->execute([":id" => $_SESSION['user_id']]);
$currentUser = $stmt->fetch(PDO::FETCH_ASSOC);

// Get user's notifications
$notifController = new NotificationController($pdo);
$notifications = $notifController->index($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .user-switcher {
            display: flex;
            gap: 10px;
        }

        .user-switcher a {
            padding: 5px 10px;
            background: #007cba;
            color: white;
            text-decoration: none;
            border-radius: 3px;
        }

        .user-switcher a.active {
            background: #005a87;
        }

        .notification-bell {
            position: relative;
            cursor: pointer;
            font-size: 20px;
        }

        .notification-count {
            position: absolute;
            top: -5px;
            right: -5px;
            background: red;
            color: white;
            border-radius: 50%;
            width: 16px;
            height: 16px;
            font-size: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .notification-dropdown {
            position: absolute;
            top: 30px;
            right: 0;
            background: white;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 300px;
            max-height: 300px;
            overflow-y: auto;
            display: none;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .notification-item {
            padding: 10px;
            border-bottom: 1px solid #eee;
        }

        .notification-item:last-child {
            border-bottom: none;
        }

        .notification-item.unread {
            background: #f0f8ff;
        }

        .content {
            margin-top: 20px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>

    <div class="header">
        <h1>Dashboard - Welcome <?= htmlspecialchars($currentUser['name']) ?> (<?= ucfirst($currentUser['role']) ?>)</h1>

        <div style="display: flex; align-items: center; gap: 20px;">
            <!-- User Switcher -->
            <div class="user-switcher">
                <a href="?route=dashboard&switch_user=1" <?= $_SESSION['user_id'] == 1 ? 'class="active"' : '' ?>>Admin</a>
                <a href="?route=dashboard&switch_user=2" <?= $_SESSION['user_id'] == 2 ? 'class="active"' : '' ?>>Employer</a>
                <a href="?route=dashboard&switch_user=3" <?= $_SESSION['user_id'] == 3 ? 'class="active"' : '' ?>>Jobseeker</a>
            </div>

            <!-- Notification Bell -->
            <div class="notification-bell" onclick="toggleNotifications()">
                🔔
                <span class="notification-count" id="notif-count"><?= count(array_filter($notifications, fn($n) => $n['status'] == 'unread')) ?></span>
                <div class="notification-dropdown" id="notif-dropdown">
                    <div id="notif-list">
                        <?php foreach ($notifications as $notif): ?>
                            <div class="notification-item <?= $notif['status'] == 'unread' ? 'unread' : '' ?>" onclick="markAsRead(<?= $notif['id'] ?>)">
                                <div><strong><?= ucfirst(str_replace('_', ' ', $notif['type'])) ?></strong></div>
                                <div><?= htmlspecialchars($notif['message']) ?></div>
                                <div style="font-size: 12px; color: #666;"><?= $notif['created_at'] ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <?php if ($currentUser['role'] == 'employer'): ?>
            <h2>Employer Dashboard</h2>
            <p><a href="?route=jobs">Post New Job</a> | <a href="?route=applications">Manage Applications</a></p>

            <h3>My Recent Jobs</h3>
            <?php
            $stmt = $pdo->prepare("SELECT * FROM jobs WHERE employer_id = :id ORDER BY created_at DESC LIMIT 5");
            $stmt->execute([":id" => $_SESSION['user_id']]);
            $jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Posted</th>
                </tr>
                <?php foreach ($jobs as $job): ?>
                    <tr>
                        <td><?= $job['id'] ?></td>
                        <td><?= htmlspecialchars($job['title']) ?></td>
                        <td><?= $job['created_at'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>

        <?php elseif ($currentUser['role'] == 'jobseeker'): ?>
            <h2>Jobseeker Dashboard</h2>

            <h3>Available Jobs</h3>
            <?php
            $stmt = $pdo->query("SELECT j.*, u.name as employer_name FROM jobs j JOIN users u ON j.employer_id = u.id ORDER BY j.created_at DESC");
            $jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Employer</th>
                    <th>Posted</th>
                    <th>Action</th>
                </tr>
                <?php foreach ($jobs as $job): ?>
                    <tr>
                        <td><?= $job['id'] ?></td>
                        <td><?= htmlspecialchars($job['title']) ?></td>
                        <td><?= htmlspecialchars($job['employer_name']) ?></td>
                        <td><?= $job['created_at'] ?></td>
                        <td>
                            <form method="POST" action="" style="display: inline;">
                                <input type="hidden" name="action" value="apply">
                                <input type="hidden" name="job_id" value="<?= $job['id'] ?>">
                                <button type="submit">Apply</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>

            <h3>My Applications</h3>
            <?php
            $appModel = new Application($pdo);
            $myApps = $appModel->getByJobseeker($_SESSION['user_id']);
            ?>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Job Title</th>
                    <th>Status</th>
                    <th>Updated</th>
                </tr>
                <?php foreach ($myApps as $app): ?>
                    <tr>
                        <td><?= $app['id'] ?></td>
                        <td><?= htmlspecialchars($app['job_title']) ?></td>
                        <td><?= $app['status'] ?></td>
                        <td><?= $app['updated_at'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>

        <?php else: // admin 
        ?>
            <h2>Admin Dashboard</h2>
            <p><a href="?route=jobs">View All Jobs</a> | <a href="?route=applications">View All Applications</a></p>

            <h3>System Overview</h3>
            <?php
            $totalJobs = $pdo->query("SELECT COUNT(*) FROM jobs")->fetchColumn();
            $totalApps = $pdo->query("SELECT COUNT(*) FROM applications")->fetchColumn();
            $totalNotifs = $pdo->query("SELECT COUNT(*) FROM notifications WHERE status='unread'")->fetchColumn();
            ?>
            <ul>
                <li>Total Jobs: <?= $totalJobs ?></li>
                <li>Total Applications: <?= $totalApps ?></li>
                <li>Unread Notifications: <?= $totalNotifs ?></li>
            </ul>
        <?php endif; ?>
    </div>

    <!-- ...existing code... -->

    <script>
        let lastCheck = null;

        function toggleNotifications() {
            const dropdown = document.getElementById('notif-dropdown');
            dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
        }

        async function fetchNotifications() {
            try {
                const url = "api/notifications.php" + (lastCheck ? "?since=" + encodeURIComponent(lastCheck) : "");
                const res = await fetch(url);
                if (!res.ok) return;

                const data = await res.json();
                if (data.length > 0) {
                    lastCheck = data[0].created_at;
                    updateNotificationDisplay(data);
                }
            } catch (err) {
                console.error("Notification fetch error", err);
            }
        }

        function updateNotificationDisplay(newNotifications) {
            const list = document.getElementById("notif-list");
            const countElement = document.getElementById("notif-count");

            // Add new notifications to the top
            newNotifications.forEach(notif => {
                const div = document.createElement("div");
                div.className = `notification-item ${notif.status == 'unread' ? 'unread' : ''}`;
                div.onclick = () => markAsRead(notif.id);
                div.innerHTML = `
            <div><strong>${notif.type.replace('_', ' ').toUpperCase()}</strong></div>
            <div>${notif.message}</div>
            <div style="font-size: 12px; color: #666;">${notif.created_at}</div>
        `;
                list.insertBefore(div, list.firstChild);
            });

            // Update notification count
            const unreadCount = document.querySelectorAll('.notification-item.unread').length;
            countElement.textContent = unreadCount;
            countElement.style.display = unreadCount > 0 ? 'flex' : 'none';
        }

        async function markAsRead(notifId) {
            try {
                const res = await fetch('api/read_notification.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        notification_id: notifId
                    })
                });

                if (res.ok) {
                    // Update UI to mark as read
                    const notifElement = document.querySelector(`[onclick="markAsRead(${notifId})"]`);
                    if (notifElement) {
                        notifElement.classList.remove('unread');
                        // Update count
                        const unreadCount = document.querySelectorAll('.notification-item.unread').length;
                        document.getElementById('notif-count').textContent = unreadCount;
                        document.getElementById('notif-count').style.display = unreadCount > 0 ? 'flex' : 'none';
                    }
                }
            } catch (err) {
                console.error("Mark as read error", err);
            }
        }

        // Close notification dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const bell = document.querySelector('.notification-bell');
            const dropdown = document.getElementById('notif-dropdown');

            if (!bell.contains(event.target)) {
                dropdown.style.display = 'none';
            }
        });

        // Poll every 10 seconds for new notifications
        setInterval(fetchNotifications, 10000);

        // Initial fetch
        fetchNotifications();
    </script>
</body>

</html>