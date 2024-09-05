<?php
include 'db_connect.php';

$sql = "SELECT disaster_type, location, description, timestamp FROM reports ORDER BY timestamp DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Disaster Reports</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Disaster Reports</h1>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='report'>";
                echo "<h3>" . htmlspecialchars($row['disaster_type']) . "</h3>";
                echo "<p><strong>Location:</strong> " . htmlspecialchars($row['location']) . "</p>";
                echo "<p><strong>Description:</strong> " . htmlspecialchars($row['description']) . "</p>";
                echo "<p><strong>Reported At:</strong> " . htmlspecialchars($row['timestamp']) . "</p>";
                echo "</div>";
            }
        } else {
            echo "<p>No reports found.</p>";
        }
        $conn->close();
        ?>
    </div>
</body>
</html>
