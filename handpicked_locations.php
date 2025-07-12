<?php
// handpicked_locations.php
session_start();
require_once 'db.php'; // make sure your db.php connects to your database

// Fetch tours from the database
$query = "SELECT * FROM tours";
$result = mysqli_query($conn, $query);

// Check if query failed
if (!$result) {
    die("Database query failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Handpicked Locations</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #1c1c1c;
            color: #f4dc34;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .location-section {
            background-color: #3c3c3c;
            border-left: 8px solid #b4842a;
            padding: 30px;
            margin-bottom: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.5);
            transition: background-color 0.3s;
        }
        .location-section:hover {
            background-color: #2c2c2c;
        }
        .location-title {
            color: #fccb04;
            font-size: 2rem;
            font-weight: bold;
        }
        .location-description {
            color: #f4dc34;
            font-size: 1.1rem;
            margin-top: 10px;
        }
        .btn-custom {
            background-color: #b4842a;
            color: #1c1c1c;
            font-weight: bold;
            margin-top: 20px;
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
        }
        .btn-custom:hover {
            background-color: #fccb04;
            color: #1c1c1c;
            transition: 0.3s;
        }
        .page-title {
            color: #fccb04;
            text-align: center;
            margin-top: 50px;
            margin-bottom: 50px;
            font-weight: bold;
            font-size: 3rem;
        }
    </style>
</head>
<body>

<div class="container">
    <h1 class="page-title">🌟 Handpicked Locations</h1>

    <?php while ($tour = mysqli_fetch_assoc($result)) : ?>
        <div class="location-section">
            <h2 class="location-title"><?= htmlspecialchars($tour['TourName']) ?> - <?= htmlspecialchars($tour['Location']) ?></h2>
            <p class="location-description">
                <?= nl2br(htmlspecialchars($tour['Description'])) ?>
            </p>
            <a href="tours.php" class="btn btn-custom">View Tours</a>
        </div>
    <?php endwhile; ?>

    <div class="text-center my-5">
        <a href="home.php" class="btn btn-custom btn-lg">🏠 Back to Home</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
