<?php
// Create this as session_test.php in your public folder
session_start();

echo "<h2>Session Debug Information</h2>";
echo "<p><strong>Session ID:</strong> " . session_id() . "</p>";
echo "<p><strong>Session Status:</strong> " . session_status() . "</p>";
echo "<p><strong>Session Save Path:</strong> " . session_save_path() . "</p>";
echo "<p><strong>Session Cookie Params:</strong></p>";
print_r(session_get_cookie_params());

echo "<h3>Current Session Data:</h3>";
echo "<pre>";
print_r($_SESSION);
echo "</pre>";

echo "<h3>Session Settings:</h3>";
echo "<p>session.cookie_lifetime: " . ini_get('session.cookie_lifetime') . "</p>";
echo "<p>session.gc_maxlifetime: " . ini_get('session.gc_maxlifetime') . "</p>";
echo "<p>session.cookie_secure: " . ini_get('session.cookie_secure') . "</p>";
echo "<p>session.cookie_httponly: " . ini_get('session.cookie_httponly') . "</p>";

// Test setting a session variable
if (!isset($_SESSION['test_time'])) {
    $_SESSION['test_time'] = time();
    echo "<p>Set test_time to: " . $_SESSION['test_time'] . "</p>";
} else {
    echo "<p>Existing test_time: " . $_SESSION['test_time'] . " (set " . (time() - $_SESSION['test_time']) . " seconds ago)</p>";
}

echo "<p><a href='?refresh=1'>Refresh Page</a></p>";
?>