<?php
// Get current user info
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
$stmt->execute([":id" => $_SESSION['user_id']]);
$currentUser = $stmt->fetch(PDO::FETCH_ASSOC);

// Handle job posting
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($currentUser['role'] !== 'employer') {
        echo "<script>alert('Only employers can post jobs!'); window.location='?route=dashboard';</script>";
        exit;
    }

    $title = $_POST['title'];
    $controller = new JobController($pdo);
    $jobId = $controller->postJob($_SESSION['user_id'], $title);
    echo "<script>alert('Job posted successfully!'); window.location='?route=dashboard';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Post Job</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .container {
            max-width: 500px;
            margin: 0 auto;
        }

        input,
        textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
        }

        button {
            padding: 10px 20px;
            background: #007cba;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background: #005a87;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>Post a New Job</h1>

        <?php if ($currentUser['role'] !== 'employer'): ?>
            <p>Only employers can post jobs. <a href="?route=dashboard">Back to Dashboard</a></p>
        <?php else: ?>
            <form method="POST">
                <input type="text" name="title" placeholder="Job Title" required>
                <button type="submit">Post Job</button>
            </form>

            <p><a href="?route=dashboard">Back to Dashboard</a></p>

            <h2>All Jobs</h2>
            <?php
            $stmt = $pdo->query("SELECT j.*, u.name as employer_name FROM jobs j JOIN users u ON j.employer_id = u.id ORDER BY j.created_at DESC");
            $jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <table border="1" cellpadding="5" style="width: 100%;">
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Employer</th>
                    <th>Posted</th>
                </tr>
                <?php foreach ($jobs as $job): ?>
                    <tr>
                        <td><?= $job['id'] ?></td>
                        <td><?= htmlspecialchars($job['title']) ?></td>
                        <td><?= htmlspecialchars($job['employer_name']) ?></td>
                        <td><?= $job['created_at'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </div>

</body>

</html>