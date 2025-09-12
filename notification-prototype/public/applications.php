<?php
require_once "../app/controllers/ApplicationController.php";

// Get current user info
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
$stmt->execute([":id" => $_SESSION['user_id']]);
$currentUser = $stmt->fetch(PDO::FETCH_ASSOC);

$appController = new ApplicationController($pdo);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($currentUser['role'] !== 'employer' && $currentUser['role'] !== 'admin') {
        echo "<script>alert('Only employers and admins can update applications!'); window.location='?route=dashboard';</script>";
        exit;
    }

    $appId = $_POST['app_id'];
    $status = $_POST['status'];
    $result = $appController->updateStatus($appId, $status);

    if ($result) {
        echo "<script>alert('Application updated successfully!'); window.location.reload();</script>";
    } else {
        echo "<script>alert('Failed to update application!');</script>";
    }
}

// Display applications
$applications = $appController->listApplications();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Manage Applications</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
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

        select,
        button {
            padding: 5px;
        }

        button {
            background: #007cba;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background: #005a87;
        }

        .back-link {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

    <div class="back-link">
        <a href="?route=dashboard">← Back to Dashboard</a>
    </div>

    <h1>Applications Management</h1>
    <p>Current User: <strong><?= htmlspecialchars($currentUser['name']) ?> (<?= ucfirst($currentUser['role']) ?>)</strong></p>

    <?php if ($currentUser['role'] !== 'employer' && $currentUser['role'] !== 'admin'): ?>
        <p>Only employers and admins can manage applications.</p>
    <?php else: ?>
        <?php if (empty($applications)): ?>
            <p>No applications found. <a href="?route=jobs">Post some jobs first</a> to receive applications.</p>

            <!-- Add some sample applications for testing -->
            <div style="margin-top: 20px; padding: 15px; background: #f0f8ff; border-radius: 5px;">
                <h3>For Testing: Create Sample Applications</h3>
                <form method="POST" action="">
                    <input type="hidden" name="action" value="create_sample_apps">
                    <button type="submit">Create Sample Applications</button>
                </form>
            </div>
        <?php else: ?>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Job</th>
                    <th>Jobseeker</th>
                    <th>Status</th>
                    <th>Updated</th>
                    <th>Action</th>
                </tr>
                <?php foreach ($applications as $a): ?>
                    <tr>
                        <td><?= $a['id'] ?></td>
                        <td><?= htmlspecialchars($a['job_title']) ?></td>
                        <td><?= htmlspecialchars($a['jobseeker_name']) ?></td>
                        <td><?= $a['status'] ?></td>
                        <td><?= $a['updated_at'] ?></td>
                        <td>
                            <form method="POST" style="display:inline">
                                <input type="hidden" name="app_id" value="<?= $a['id'] ?>">
                                <select name="status">
                                    <option value="pending" <?= $a['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                                    <option value="reviewed" <?= $a['status'] == 'reviewed' ? 'selected' : '' ?>>Reviewed</option>
                                    <option value="accepted" <?= $a['status'] == 'accepted' ? 'selected' : '' ?>>Accepted</option>
                                    <option value="rejected" <?= $a['status'] == 'rejected' ? 'selected' : '' ?>>Rejected</option>
                                </select>
                                <button type="submit">Update</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    <?php endif; ?>

    <?php
    // Handle creating sample applications for testing
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == 'create_sample_apps') {
        // Get a job and create applications
        $stmt = $pdo->query("SELECT * FROM jobs ORDER BY created_at DESC LIMIT 1");
        $job = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($job) {
            $appModel = new Application($pdo);
            // Create application from jobseeker (user_id = 3) to the latest job
            $appId = $appModel->create($job['id'], 3);
            echo "<script>alert('Sample application created!'); window.location.reload();</script>";
        } else {
            echo "<script>alert('Please create a job first!');</script>";
        }
    }
    ?>

</body>

</html>