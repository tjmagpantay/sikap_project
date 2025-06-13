<?php
// filepath: c:\xampp\htdocs\sikap\app\views\employers\post-job-main.php

echo "<h1 style='color: red; background: yellow; padding: 20px;'>POST JOB MAIN PAGE IS WORKING!</h1>";
echo "<p>Current time: " . date('Y-m-d H:i:s') . "</p>";
echo "<p>File path: " . __FILE__ . "</p>";
echo "<p>Session data:</p>";
echo "<pre>" . print_r($_SESSION ?? [], true) . "</pre>";
echo "<p>GET data:</p>";
echo "<pre>" . print_r($_GET ?? [], true) . "</pre>";

// Stop here for now - don't include any other files
exit("DEBUG: File loaded successfully!");
?>