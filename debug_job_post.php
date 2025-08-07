<?php
// Debug script for job posting issues
session_start();

echo "<h2>Job Post Debug Information</h2>";

// Check if user is logged in
echo "<h3>Session Information:</h3>";
echo "User ID: " . ($_SESSION['user_id'] ?? 'Not set') . "<br>";
echo "Role: " . ($_SESSION['role'] ?? 'Not set') . "<br>";

// Check POST data if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<h3>POST Data Received:</h3>";
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";

    echo "<h3>FILES Data:</h3>";
    echo "<pre>";
    print_r($_FILES);
    echo "</pre>";

    // Check for save_draft parameter
    echo "<h3>Draft Check:</h3>";
    echo "save_draft isset: " . (isset($_POST['save_draft']) ? 'YES' : 'NO') . "<br>";
    echo "save_draft value: " . ($_POST['save_draft'] ?? 'not set') . "<br>";

    // Check job_status
    echo "job_status: " . ($_POST['job_status'] ?? 'not set (will default to draft)') . "<br>";
}

// Check GET parameters
echo "<h3>GET Parameters:</h3>";
echo "page: " . ($_GET['page'] ?? 'not set') . "<br>";
echo "step: " . ($_GET['step'] ?? 'not set') . "<br>";
echo "job_id: " . ($_GET['job_id'] ?? 'not set') . "<br>";

// Check browser information
echo "<h3>Browser Information:</h3>";
echo "User Agent: " . $_SERVER['HTTP_USER_AGENT'] . "<br>";
echo "Request Method: " . $_SERVER['REQUEST_METHOD'] . "<br>";
echo "Content Type: " . ($_SERVER['CONTENT_TYPE'] ?? 'not set') . "<br>";

// Test form
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
?>
    <h3>Test Form:</h3>
    <form method="POST" action="">
        <input type="text" name="job_title" placeholder="Job Title" required><br><br>
        <select name="job_category_id" required>
            <option value="">Select Category</option>
            <option value="1">IT</option>
            <option value="2">Marketing</option>
        </select><br><br>
        <select name="job_type" required>
            <option value="">Select Type</option>
            <option value="full-time">Full-time</option>
            <option value="part-time">Part-time</option>
        </select><br><br>
        <input type="text" name="location" placeholder="Location" required><br><br>
        <textarea name="job_summary" placeholder="Job Summary" required></textarea><br><br>

        <button type="submit">Test Submit (should go to step 2)</button>
        <button type="submit" name="save_draft" value="1">Test Save Draft</button>
    </form>

    <script>
        // Check for JavaScript errors
        window.addEventListener('error', function(e) {
            console.error('JavaScript Error:', e.error);
            alert('JavaScript Error: ' + e.error.message);
        });

        // Check form submission
        document.querySelector('form').addEventListener('submit', function(e) {
            console.log('Form submitted');
            console.log('Form data:', new FormData(e.target));
        });
    </script>
<?php
}
?>