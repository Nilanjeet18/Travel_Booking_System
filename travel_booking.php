<?php
session_start();
include 'db.php'; // Your database connection

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$success = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    $userID = $_SESSION['user_id'];
    $transportType = $_POST['transport_type'];
    $fromLocation = trim($_POST['from_location']);
    $toLocation = trim($_POST['to_location']);
    $departureDate = $_POST['departure_date'];
    $guests = (int)$_POST['guests'];

    $costPerGuest = 0;
    if ($transportType == 'Bus') {
        $costPerGuest = 500;
    } elseif ($transportType == 'Train') {
        $costPerGuest = 800;
    } elseif ($transportType == 'Flight') {
        $costPerGuest = 3000;
    }

    $totalPrice = $guests * $costPerGuest;

    // Assuming you have the following variables: $transportType, $departureDate, $fromLocation, $toLocation, $guests, $totalPrice

// Validate transport type
$valid_transport_types = ['Bus', 'Train', 'Flight'];
if (!in_array($transportType, $valid_transport_types)) {
    die("Invalid transport type selected.");
}

// Prepare the SQL query
$sql = "INSERT INTO travel_bookings (UserID, TransportType, FromLocation, ToLocation, DepartureDate, Guests, TotalPrice) 
        VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("issssii", $_SESSION['user_id'], $transportType, $fromLocation, $toLocation, $departureDate, $guests, $totalPrice);

if ($stmt->execute()) {
    $_SESSION['booking_details'] = [
        'fullname' => $_SESSION['fullname'],
        'phone' => $_SESSION['phone'],
        'guests' => $guests,
        'date' => $departureDate,
        'total_price' => $totalPrice,
    ];

    $_SESSION['travel_details'] = [
        'type' => $transportType,
        'departure_date' => $departureDate,
        'from_location' => $fromLocation,
        'to_location' => $toLocation,
        'total_price' => $totalPrice,
    ];

    header('Location: travel_booking_success.php');
    exit();
} else {
    $error = "Failed to book travel. Please try again.";
}

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Travel Booking | Travel Crown</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #1c1c1c;
            color: #f4dc34;
        }
        .navbar {
            background-color: #b4842a;
        }
        .navbar a {
            color: #f4dc34;
            margin-right: 15px;
            text-decoration: none;
        }
        .navbar a:hover {
            color: #fccb04;
            text-decoration: underline;
        }
        .transport-card {
            cursor: pointer;
            border: 2px solid transparent;
            transition: all 0.3s ease;
            background-color: #3c3c3c;
            color: #f4dc34;
        }
        .transport-card:hover {
            background-color: #b4842a;
            color: #1c1c1c;
        }
        .transport-card.selected {
            border: 2px solid #fccb04;
            box-shadow: 0 0 10px rgba(252, 203, 4, 0.7);
        }
        .transport-card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }
        .card {
            background-color: #3c3c3c;
            color: #f4dc34;
            border: none;
        }
        .btn-primary {
            background-color: #b4842a;
            border-color: #b4842a;
        }
        .btn-primary:hover {
            background-color: #fccb04;
            border-color: #fccb04;
            color: #1c1c1c;
        }
        .form-control {
            background-color: #1c1c1c;
            color: #f4dc34;
            border: 1px solid #b4842a;
        }
        .form-control::placeholder {
            color: #b4842a;
        }
        .alert-danger {
            background-color: #b4842a;
            border: none;
            color: #1c1c1c;
        }
    </style>
</head>
<body>

<!-- Navbar -->
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

<!-- Booking Form -->
<div class="container my-5">
    <div class="card shadow p-4">
        <h1 class="mb-4 text-center" style="color: #fccb04;">Book Your Travel</h1>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <input type="hidden" name="transport_type" id="transport_type" required>

            <div class="mb-4">
                <label class="form-label" style="color: #fccb04;">Choose Transport Type</label>
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="card transport-card" onclick="selectTransport('Bus')">
                            <img src="https://ik.imagekit.io/usmoswa6r/Logo/bus.jpg?updatedAt=1745697317567" alt="Bus" class="card-img-top">
                            <div class="card-body text-center">
                                <h5 class="card-title">Bus</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card transport-card" onclick="selectTransport('Train')">
                            <img src="https://ik.imagekit.io/usmoswa6r/Logo/train.jpg?updatedAt=1745697246868" alt="Train" class="card-img-top">
                            <div class="card-body text-center">
                                <h5 class="card-title">Train</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card transport-card" onclick="selectTransport('Flight')">
                            <img src="https://ik.imagekit.io/usmoswa6r/Logo/plane.jpg?updatedAt=1745697340537" alt="Flight" class="card-img-top">
                            <div class="card-body text-center">
                                <h5 class="card-title">Flight</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="from_location" class="form-label">From Location</label>
                <input type="text" name="from_location" id="from_location" class="form-control" placeholder="Enter starting location" required>
            </div>

            <div class="mb-3">
                <label for="to_location" class="form-label">To Location</label>
                <input type="text" name="to_location" id="to_location" class="form-control" placeholder="Enter destination" required>
            </div>

            <div class="mb-3">
                <label for="departure_date" class="form-label">Departure Date</label>
                <input type="date" name="departure_date" id="departure_date" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="guests" class="form-label">Number of Guests</label>
                <input type="number" name="guests" id="guests" class="form-control" min="1" value="1" required>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-lg">Confirm Booking</button>
            </div>
        </form>
    </div>
</div>

<script>
    function selectTransport(type) {
        document.getElementById('transport_type').value = type;
        const cards = document.querySelectorAll('.transport-card');
        cards.forEach(card => card.classList.remove('selected'));
        const selectedCard = [...cards].find(card => card.innerText.trim() === type);
        if (selectedCard) {
            selectedCard.classList.add('selected');
        }
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
