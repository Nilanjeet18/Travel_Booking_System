<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Travel Booking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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

        .navbar .navbar-brand {
            color: #fccb04;
        }

        .navbar .navbar-toggler-icon {
            background-color: #fccb04;
        }

        .container {
            background-color: #2c2c2c;
            padding: 40px;
            border-radius: 8px;
        }

        h2 {
            color: #fccb04;
        }

        h4 {
            color: #fccb04;
        }

        p {
            color: #f4dc34;
        }

        .lead {
            color: #f4dc34;
        }

        .text-center {
            color: #f4dc34;
        }

        .btn-outline-light {
            color: #fccb04;
            border-color: #fccb04;
        }

        .btn-outline-light:hover {
            background-color: #fccb04;
            color: #1c1c1c;
        }

        .btn-warning {
            background-color: #b4842a;
            border-color: #b4842a;
            color: white;
        }

        .btn-warning:hover {
            background-color: #fccb04;
            color: #1c1c1c;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark">
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
<div class="container my-5">
    <h2 class="mb-4 text-center">About Us</h2>
    <p class="lead text-center">
        Welcome to TravelBooking! We specialize in creating memorable travel experiences.
        Our goal is to provide you with top destinations, easy booking, and unforgettable adventures.
    </p>

    <div class="row text-center mt-5">
        <div class="col-md-4">
            <h4>✈️ Easy Booking</h4>
            <p>Book your dream tours with just a few clicks. Fast, safe, and secure.</p>
        </div>
        <div class="col-md-4">
            <h4>🌍 Best Destinations</h4>
            <p>We offer hand-picked tours to the most beautiful locations around the world.</p>
        </div>
        <div class="col-md-4">
            <h4>❤️ Customer Satisfaction</h4>
            <p>We prioritize your happiness and ensure you have a smooth journey from start to finish.</p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
