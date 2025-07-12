<?php
session_start();

if (!isset($_SESSION['user_id']) || !isset($_GET['booking_id'])) {
    header("Location: home.php");
    exit();
}

$booking_id = intval($_GET['booking_id']);

$host = "localhost";
$user = "root";
$pass = "Nilu@2804";
$dbname = "travelbooking";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure booking belongs to the logged-in user
$stmt = $conn->prepare("DELETE FROM tour_bookings WHERE BookingID = ? AND UserID = ?");
$stmt->bind_param("ii", $booking_id, $_SESSION['user_id']);

if ($stmt->execute()) {
    header("Location: home.php");
    exit();
} else {
    echo "Error cancelling booking: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
