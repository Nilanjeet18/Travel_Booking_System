<?php
session_start();

// DB Connection
$host = "localhost";
$user = "root";
$pass = "Nilu@2804";
$dbname = "travelbooking";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$upcomingBookings = [];

include 'footer.php';

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $today = date('Y-m-d');

    $sql = "SELECT tb.BookingID, tb.Date, tb.Guests, tb.TotalPrice, t.TourID, t.TourName, t.Location
            FROM tour_bookings tb
            JOIN tours t ON tb.TourID = t.TourID
            WHERE tb.UserID = ? AND tb.Date >= ?
            ORDER BY tb.Date ASC";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $user_id, $today);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $upcomingBookings[] = $row;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>TravelCrown - Home</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            background-color: #1c1c1c;
            color: #f4dc34;
        }
        .navbar {
            background-color: #3c3c3c;
        }
        .navbar a {
            color: #fccb04;
            margin-right: 15px;
            text-decoration: none;
        }
        .navbar a:hover {
            text-decoration: underline;
        }
        .hero-section {
            padding: 80px 20px;
            text-align: center;
        }
        .hero-title {
            font-size: 48px;
            margin-bottom: 20px;
            color: #fccb04;
        }
        .hero-subtitle {
            font-size: 20px;
            color: #b4842a;
        }
        .table th, .table td {
            vertical-align: middle;
        }
    </style>
</head>

<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="home.php">
            <img src="Images/logo.png" alt="TravelCrown Logo" style="width: 150px;">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <div class="d-flex align-items-center gap-3">
                <a href="home.php" class="btn btn-outline-light">Home</a>
                <a href="tours.php" class="btn btn-outline-light">Tours</a>
                <a href="travel_booking.php" class="btn btn-outline-light">Booking</a>
                <a href="about.php" class="btn btn-outline-light">About</a>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="upcoming_tours.php" class="btn btn-outline-warning">Upcoming Tour</a>
                <?php endif; ?>
                <a href="logout.php" class="btn btn-warning">Logout</a>
            </div>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<div class="hero-section">
    <h1 class="hero-title">Welcome to TravelCrown</h1>
    <p class="hero-subtitle">Explore the world with our trusted tours and packages</p>
</div>

<!-- Upcoming Bookings -->
<?php if (!empty($upcomingBookings)): ?>
<div class="container mt-5 p-4 bg-dark text-light rounded">
    <h3 class="text-warning text-center mb-4">🚀 Your Upcoming Travel Bookings</h3>
    <div class="table-responsive">
        <table class="table table-bordered table-hover text-light">
            <thead class="table-dark">
                <tr>
                    <th>Tour</th>
                    <th>Location</th>
                    <th>Date</th>
                    <th>Guests</th>
                    <th>Total Price</th>
                    <th>Details</th>
                    <th>Cancel</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($upcomingBookings as $booking): ?>
                    <tr>
                        <td><?= htmlspecialchars($booking['TourName']) ?></td>
                        <td><?= htmlspecialchars($booking['Location']) ?></td>
                        <td><?= htmlspecialchars($booking['Date']) ?></td>
                        <td><?= $booking['Guests'] ?></td>
                        <td>₹<?= $booking['TotalPrice'] ?></td>
                        <td>
                            <a href="tour_booking.php?tour_id=<?= $booking['TourID'] ?>" class="btn btn-sm btn-info">View</a>
                        </td>
                        <td>
                            <a href="cancel_booking.php?booking_id=<?= $booking['BookingID'] ?>" class="btn btn-sm btn-danger"
                               onclick="return confirm('Are you sure you want to cancel this booking?');">Cancel</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>



<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
