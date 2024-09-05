<?php
// Connect to the database (replace with your credentials)
$servername = "localhost";
$username = "root"; // Default for XAMPP
$password = ""; // Default for XAMPP
$dbname = "disaster_reports"; // The name of your database

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $disaster_type = $_POST['disaster_type'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $description = $_POST['description'];

    // Sanitize inputs to prevent SQL Injection
    $disaster_type = $conn->real_escape_string($disaster_type);
    $latitude = $conn->real_escape_string($latitude);
    $longitude = $conn->real_escape_string($longitude);
    $description = $conn->real_escape_string($description);

    // SQL query to insert data into the reports table
    $sql = "INSERT INTO reports (disaster_type, latitude, longitude, description) 
            VALUES ('$disaster_type', '$latitude', '$longitude', '$description')";

    // Execute query and check for success
    if ($conn->query($sql) === TRUE) {
        echo "New disaster report submitted successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close connection
    $conn->close();
}
?>
