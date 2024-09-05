<?php
include 'db_connect.php';

$user_lat = $_POST['latitude'];
$user_lng = $_POST['longitude'];

// SQL query to fetch disaster reports within a 50km radius
$sql = "SELECT disaster_type, latitude, longitude, description, 
        (6371 * acos(cos(radians($user_lat)) * cos(radians(latitude)) * cos(radians(longitude) - radians($user_lng)) + sin(radians($user_lat)) * sin(radians(latitude)))) AS distance 
        FROM reports 
        HAVING distance < 50 
        ORDER BY distance ASC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nearby Disaster Reports</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
</head>
<body>
    <div class="container">
        <h1>Nearby Disaster Reports</h1>
        <div id="map"></div>

        <script>
            var map = L.map('map').setView([<?php echo $user_lat; ?>, <?php echo $user_lng; ?>], 10);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $lat = $row['latitude'];
                    $lng = $row['longitude'];
                    $description = htmlspecialchars($row['description']);
                    $type = htmlspecialchars($row['disaster_type']);
                    echo "
                    L.circle([$lat, $lng], {
                        color: 'red',
                        fillColor: '#f03',
                        fillOpacity: 0.5,
                        radius: 100
                    }).addTo(map).bindPopup('<b>$type</b><br>$description');
                    ";
                }
            } else {
                echo "alert('No reports found within 50km radius.');";
            }
            $conn->close();
            ?>
        </script>
    </div>
</body>
</html>
