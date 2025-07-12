<?php
session_start();

// Check if travel booking details exist
if (!isset($_SESSION['booking_details']) || !isset($_SESSION['travel_details'])) {
    header("Location: index.php");
    exit();
}

$travel = $_SESSION['travel_details'];
$booking = $_SESSION['booking_details'];

// Set image URL based on transport type
switch ($travel['type']) {
    case 'Bus':
        $image_url = 'https://cdn-icons-png.flaticon.com/512/3448/3448337.png'; // Example bus image
        break;
    case 'Train':
        $image_url = 'https://cdn-icons-png.flaticon.com/512/2210/2210153.png'; // Example train image
        break;
    case 'Flight':
        $image_url = 'https://cdn-icons-png.flaticon.com/512/681/681392.png'; // Example plane image
        break;
    default:
        $image_url = 'https://cdn-icons-png.flaticon.com/512/942/942748.png'; // Default image
        break;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Travel Booking Successful - <?= htmlspecialchars($travel['type']) ?></title>
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
        .transport-image {
            max-width: 150px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="container my-5">
    <div class="card shadow-lg p-4">
        <div class="card-body text-center">
            <img src="<?= htmlspecialchars($image_url) ?>" alt="<?= htmlspecialchars($travel['type']) ?> Image" class="transport-image">

            <h1 class="card-title mb-3">🎉 Travel Booking Confirmed!</h1>

            <p class="lead">Thank you, <strong><?= htmlspecialchars($booking['fullname']) ?></strong>, for booking your travel with us!</p>
            <p class="summary-text mb-4">Here's your booking summary:</p>

            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="mb-4">
                        <h3 class="section-heading mb-3">Travel Details</h3>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>Transport Type:</strong> <?= htmlspecialchars($travel['type']) ?></li>
                            <li class="list-group-item"><strong>From:</strong> <?= htmlspecialchars($travel['from_location']) ?></li>
                            <li class="list-group-item"><strong>To:</strong> <?= htmlspecialchars($travel['to_location']) ?></li>
                            <li class="list-group-item"><strong>Departure Date:</strong> <?= htmlspecialchars($travel['departure_date']) ?></li>
                        </ul>
                    </div>

                    <div class="mb-4">
                        <h3 class="section-heading mb-3">Passenger Details</h3>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>Name:</strong> <?= htmlspecialchars($booking['fullname']) ?></li>
                            <li class="list-group-item"><strong>Phone Number:</strong> <?= htmlspecialchars($booking['phone']) ?></li>
                            <li class="list-group-item"><strong>Number of Guests:</strong> <?= htmlspecialchars($booking['guests']) ?></li>
                            <li class="list-group-item"><strong>Total Price:</strong> ₹<?= htmlspecialchars(number_format($booking['total_price'], 2)) ?></li>
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
