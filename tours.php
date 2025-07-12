<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$mysqli = new mysqli('localhost', 'root', 'Nilu@2804', 'travelbooking');

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Fetch tours from database
$tourQuery = "SELECT * FROM Tours";
$tourResult = $mysqli->query($tourQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tours | Travel Crown</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #1c1c1c;
            color: #f4dc34;
        }
        .navbar {
            background-color: #b4842a;
        }
        .navbar-brand {
            font-weight: bold;
            font-size: 1.8rem;
            color: #ffffff !important;
        }
        .navbar .nav-link {
            color: #f4dc34 !important;
        }
        .navbar .nav-link.active {
            color: #fccb04 !important;
            font-weight: bold;
        }
        .navbar .btn-outline-light {
            border-color: #f4dc34;
            color: #f4dc34;
        }
        .navbar .btn-outline-light:hover {
            background-color: #fccb04;
            color: #1c1c1c;
        }
        h2 {
            color: #fccb04;
        }
        .card {
            background-color: #2b2b2b;
            border: none;
            border-radius: 12px;
            transition: transform 0.3s;
        }
        .card:hover {
            transform: translateY(-5px);
            background-color: #3c3c3c;
        }
        .card-title {
            color: #f4dc34;
        }
        .card-text {
            color: #ccc;
        }
        .btn-primary {
            background-color: #b4842a;
            border: none;
        }
        .btn-primary:hover {
            background-color: #fccb04;
            color: #1c1c1c;
        }
        .alert-info {
            background-color: #3c3c3c;
            color: #f4dc34;
            border: 1px solid #b4842a;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <!-- Replace the text-based logo with the image logo -->
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
                <a href="logout.php" class="btn btn-warning">Logout</a>
            </div>
        </div>
    </div>
</nav>

<!-- Main Content -->
<div class="container mt-5">
    <h2 class="text-center mb-4">Available Tours</h2>

    <div class="row g-4">
        <?php if ($tourResult && $tourResult->num_rows > 0): ?>
            <?php while($tour = $tourResult->fetch_assoc()): ?>
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm">
                        <img src="<?= htmlspecialchars($tour['TourImage']); ?>" class="card-img-top" alt="<?= htmlspecialchars($tour['TourName']); ?>" style="height: 250px; object-fit: cover; border-top-left-radius: 12px; border-top-right-radius: 12px;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?= htmlspecialchars($tour['TourName']); ?></h5>
                            <p class="card-text"><?= htmlspecialchars(substr($tour['Description'], 0, 120)) . '...'; ?></p>
                            <a href="tour_booking.php?tour_id=<?= $tour['TourID']; ?>" class="btn btn-primary btn-sm mt-auto">Book Now</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-info text-center" role="alert">
                    No tours available at the moment.
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
