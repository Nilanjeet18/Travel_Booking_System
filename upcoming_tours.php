<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$host = "localhost";
$user = "root";
$pass = "Nilu@2804";
$dbname = "travelbooking";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];
$today = date('Y-m-d');

$sql = "SELECT tb.*, t.TourName, t.Location, t.CostPerPerson 
        FROM tour_bookings tb
        JOIN tours t ON tb.TourID = t.TourID
        WHERE tb.UserID = ? AND tb.Date >= ?
        ORDER BY tb.Date ASC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $user_id, $today);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upcoming Tours</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #1c1c1c;
            color: #f4dc34;
        }
        .container {
            margin-top: 50px;
            background: #2c2c2c;
            padding: 30px;
            border-radius: 10px;
        }
        h2 {
            color: #fccb04;
        }
        .table {
            background-color: #3c3c3c;
            color: #fff;
        }
        .table th, .table td {
            color: #f4dc34;
            vertical-align: middle;
        }
        .btn-back {
            background-color: #b4842a;
            color: white;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center mb-4">Your Upcoming Tours</h2>

    <?php if ($result->num_rows > 0): ?>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Tour Name</th>
                    <th>Location</th>
                    <th>Date</th>
                    <th>Guests</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['TourName']) ?></td>
                        <td><?= htmlspecialchars($row['Location']) ?></td>
                        <td><?= htmlspecialchars($row['Date']) ?></td>
                        <td><?= htmlspecialchars($row['Guests']) ?></td>
                        <td>₹<?= htmlspecialchars($row['TotalPrice']) ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="text-center">You have no upcoming tours booked.</p>
    <?php endif; ?>

    <div class="text-center mt-4">
        <a href="home.php" class="btn btn-back">🏠 Back to Home</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
