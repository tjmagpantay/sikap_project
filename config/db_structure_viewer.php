<?php
// Simple DB connection (custom — not using config/sikap_db.php)
$host = "localhost";
$username = "root";
$password = ""; // Leave blank if using default XAMPP
$database = "sikap_db";

$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

// Get all tables in the database
$tables = [];
$result = $conn->query("SHOW TABLES");

if ($result) {
    while ($row = $result->fetch_array()) {
        $tables[] = $row[0];
    }
} else {
    die("⚠️ Failed to retrieve tables: " . $conn->error);
}

// Display structure and sample data of each table
foreach ($tables as $table) {
    echo "<h2> Table: $table</h2>";

    // Show table structure
    $columns = $conn->query("SHOW COLUMNS FROM `$table`");

    if ($columns) {
        echo "<table border='1' cellpadding='5'><tr>";
        echo "<th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";

        while ($col = $columns->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$col['Field']}</td>";
            echo "<td>{$col['Type']}</td>";
            echo "<td>{$col['Null']}</td>";
            echo "<td>{$col['Key']}</td>";
            echo "<td>{$col['Default']}</td>";
            echo "<td>{$col['Extra']}</td>";
            echo "</tr>";
        }

        echo "</table><br><br>";
    } else {
        echo "❗ Could not fetch columns for table $table.<br>";
    }

    // Show sample data
    $data = $conn->query("SELECT * FROM `$table` LIMIT 5");

    if ($data && $data->num_rows > 0) {
        echo "<h4>📄 Data:</h4><table border='1'><tr>";

        // Header
        while ($field = $data->fetch_field()) {
            echo "<th>{$field->name}</th>";
        }
        echo "</tr>";

        // Rows
        while ($row = $data->fetch_assoc()) {
            echo "<tr>";
            foreach ($row as $val) {
                echo "<td>$val</td>";
            }
            echo "</tr>";
        }

        echo "</table><br>";
    }
}

$conn->close();
?>
