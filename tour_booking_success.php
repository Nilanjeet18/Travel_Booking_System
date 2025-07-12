<?php
session_start();

// Check if booking details exist
if (!isset($_SESSION['booking_details']) || !isset($_SESSION['tour_details'])) {
    header("Location: index.php");
    exit();
}

$tour = $_SESSION['tour_details'];
$booking = $_SESSION['booking_details'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Booking Successful - <?= htmlspecialchars($tour['TourName']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #1c1c1c;
            color: #fccb04;
        }
        .card {
            background-color: #3c3c3c;
            border: 2px solid #b4842a;
            border-radius: 20px;
        }
        .card-title, 
        .section-heading, 
        .lead, 
        .summary-text {
            color: #f4dc34;
            font-weight: bold;
        }
        .list-group-item {
            background-color: #1c1c1c;
            color: #f4dc34;
            border: none;
            border-bottom: 1px solid #b4842a;
        }
        .btn-custom {
            background-color: #b4842a;
            color: #1c1c1c;
            border: none;
            font-weight: bold;
        }
        .btn-custom:hover {
            background-color: #fccb04;
            color: #1c1c1c;
            transition: 0.3s;
        }
        .tour-image {
            height: 300px;
            object-fit: cover;
            border-top-left-radius: 18px;
            border-top-right-radius: 18px;
        }
    </style>
</head>
<body>

<div class="container my-5">
    <div class="card shadow-lg p-4">
        <img src="<?= htmlspecialchars($tour['TourImage']) ?>" alt="<?= htmlspecialchars($tour['TourName']) ?>" class="tour-image">

        <div class="card-body text-center">
            <h1 class="card-title mb-3">🎉 Booking Confirmed!</h1>

            <p class="lead">Thank you, <strong><?= htmlspecialchars($booking['fullname']) ?></strong>, for booking your trip with us!</p>
            <p class="summary-text mb-4">Here's your booking summary:</p>

            <div class="row justify-content-center">
                <div class="col-md-10">

                    <div class="mb-4">
                        <h3 class="section-heading mb-3">Tour Details</h3>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>Tour Name:</strong> <?= htmlspecialchars($tour['TourName']) ?></li>
                            <li class="list-group-item"><strong>Location:</strong> <?= htmlspecialchars($tour['Location']) ?></li>
                            <li class="list-group-item"><strong>Description:</strong> <?= nl2br(htmlspecialchars($tour['Description'])) ?></li>
                            <li class="list-group-item"><strong>Cost Per Person:</strong> ₹<?= htmlspecialchars($tour['CostPerPerson']) ?></li>
                        </ul>
                    </div>

                    <div class="mb-4">
                        <h3 class="section-heading mb-3">Your Booking</h3>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>Your Name:</strong> <?= htmlspecialchars($booking['fullname']) ?></li>
                            <li class="list-group-item"><strong>Phone Number:</strong> <?= htmlspecialchars($booking['phone']) ?></li>
                            <li class="list-group-item"><strong>Number of Guests:</strong> <?= htmlspecialchars($booking['guests']) ?></li>
                            <li class="list-group-item"><strong>Departure Date:</strong> <?= htmlspecialchars($booking['date']) ?></li>
                            <li class="list-group-item"><strong>Total Price:</strong> ₹<?= htmlspecialchars(number_format($booking['total_price'], 2)) ?></li>
                        </ul>
                    </div>

                    <div class="mb-4">
                        <h3 class="section-heading mb-3">Booking Confirmation</h3>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>Booking ID:</strong> <?= htmlspecialchars($booking['booking_id']) ?></li>
                            <li class="list-group-item"><strong>Status:</strong> Confirmed</li>
                            <li class="list-group-item"><strong>Booking Date:</strong> <?= date('Y-m-d') ?></li>
                        </ul>
                    </div>

                    <a href="home.php" class="btn btn-custom btn-lg">🏠 Back to Home</a>

                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
