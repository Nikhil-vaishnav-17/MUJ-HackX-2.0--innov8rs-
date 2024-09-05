<?php
$host = 'localhost';
$db = 'disaster_reports';
$user = 'root';  // XAMPP default user is 'root'
$pass = '';      // No password by default in XAMPP

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
