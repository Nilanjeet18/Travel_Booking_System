<?php
$host = "localhost";
$db = "travelbooking"; // ✅ correct database name
$user = "root";
$pass = "Nilu@2804"; // your mysql password

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
