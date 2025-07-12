<?php
session_start();

// Database connection
$host = "localhost";
$user = "root";
$pass = "Nilu@2804";
$dbname = "travelbooking";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the selected TourID
$tour_id = isset($_GET['tour_id']) ? intval($_GET['tour_id']) : 0;

if ($tour_id <= 0) {
    die("Invalid Tour ID.");
}

// Fetch tour details
$sql_select = "SELECT * FROM Tours WHERE TourID = ?";
$stmt_select = $conn->prepare($sql_select);
$stmt_select->bind_param("i", $tour_id);
$stmt_select->execute();
$result = $stmt_select->get_result();

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $_SESSION['tour_details'] = $row;
} else {
    die("Tour not found.");
}

// Handle booking form submission
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['booking'])) {
    if (!isset($_SESSION['user_id'])) {
        die("You must be logged in to book a tour.");
    }

    $fullname = $_POST['fullname'];
    $phone = $_POST['phone'];
    $date = $_POST['date'];
    $guests = intval($_POST['guests']);

    $cost_per_person = floatval($row['CostPerPerson']);
    $total_price = $guests * $cost_per_person;

    $sql_insert = "INSERT INTO tour_bookings (UserID, TourID, FullName, Phone, Date, Guests, TotalPrice) 
                   VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param(
        "iisssii",
        $_SESSION['user_id'],
        $tour_id,
        $fullname,
        $phone,
        $date,
        $guests,
        $total_price
    );

    if ($stmt_insert->execute()) {
        $booking_id = $stmt_insert->insert_id;

        $_SESSION['booking_details'] = [
            'booking_id' => $booking_id,
            'fullname' => $fullname,
            'phone' => $phone,
            'date' => $date,
            'guests' => $guests,
            'total_price' => $total_price,
            'tour_name' => $row['TourName'],
            'tour_id' => $tour_id
        ];

        header("Location: tour_booking_success.php");
        exit();
    } else {
        echo "Error: " . $stmt_insert->error;
    }

    $stmt_insert->close();
}

// Fetch reviews for this tour
$sql_reviews = "SELECT * FROM reviews WHERE TourID = ? ORDER BY ReviewDate DESC";
$stmt_reviews = $conn->prepare($sql_reviews);
$stmt_reviews->bind_param("i", $tour_id);
$stmt_reviews->execute();
$reviews_result = $stmt_reviews->get_result();

// Handle review form submission
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['review'])) {
    $user_name = $_POST['user_name'];
    $rating = intval($_POST['rating']);
    $comment = $_POST['comment'];

    $sql_insert_review = "INSERT INTO reviews (TourID, UserName, Rating, Comment) VALUES (?, ?, ?, ?)";
    $stmt_insert_review = $conn->prepare($sql_insert_review);
    $stmt_insert_review->bind_param("isis", $tour_id, $user_name, $rating, $comment);

    if ($stmt_insert_review->execute()) {
        header("Location: tour_booking.php?tour_id=" . $tour_id);
        exit();
    } else {
        echo "<p>Error submitting review: " . $stmt_insert_review->error . "</p>";
    }

    $stmt_insert_review->close();
}

$stmt_reviews->close();
$stmt_select->close();
$conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book <?= htmlspecialchars($row['TourName']) ?> Now</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
    /* Your CSS goes here */
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
    .container {
        background-color: #2c2c2c;
        padding: 40px;
        border-radius: 8px;
    }
    h3, h4 {
        color: #fccb04;
    }
    .text-muted {
        color: #b4842a;
    }
    .card {
        background-color: #333;
        border: 1px solid #444;
    }
    .form-label {
        color: #f4dc34;
    }
    .form-control {
        background-color: #3c3c3c;
        color: #f4dc34;
        border: 1px solid #b4842a;
    }
    .btn-outline-light {
        color: #fccb04;
        border-color: #fccb04;
    }
    .btn-success {
        background-color: #b4842a;
        border-color: #b4842a;
    }
    .review-section {
        margin-top: 40px;
    }
    .star-rating {
        color: #fccb04;
    }
	
	    .reviews {
        width: 100%;
        max-width: 600px;
        margin: auto;
        padding: 1rem;
        background: #f9f9f9;
        border-radius: 10px;
    }
        .review {
        margin-bottom: 1rem;
    }
    .review-header {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .stars {
        color: gold;
    }
    .review-comment {
        margin-top: 5px;
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
                <a href="logout.php" class="btn btn-warning">Logout</a>
            </div>
        </div>
    </div>
</nav>

<!-- Main Content -->
<div class="container my-5">
    <div class="row g-5">
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <img src="<?= htmlspecialchars($row['TourImage']) ?>" class="card-img-top" alt="<?= htmlspecialchars($row['TourName']) ?>">
                <div class="card-body">
                    <h3 class="card-title"><?= htmlspecialchars($row['TourName']) ?></h3>
                    <p class="text-muted"><?= htmlspecialchars($row['Location']) ?> 🏞️</p>
                    <p class="card-text"><?= nl2br(htmlspecialchars($row['Description'])) ?></p>
                    <ul class="list-group list-group-flush mt-3">
                        <li class="list-group-item"><strong>Price:</strong> ₹<?= htmlspecialchars($row['CostPerPerson']) ?> per person</li>
                        <li class="list-group-item"><strong>Available Seats:</strong> <?= htmlspecialchars($row['NumberOfSeats']) ?></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow-sm p-4">
                <h4 class="mb-4">Book Your Trip</h4>
                <form method="POST" action="">
                    <input type="hidden" name="booking" value="1">
                    <div class="mb-3">
                        <label for="fullname" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="fullname" name="fullname" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" id="phone" name="phone" required>
                    </div>
                    <div class="mb-3">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" class="form-control" id="date" name="date" required>
                    </div>
                    <div class="mb-3">
                        <label for="guests" class="form-label">Guests</label>
                        <input type="number" class="form-control" id="guests" name="guests" min="1" required>
                    </div>
                    <button type="submit" class="btn btn-success">Book Now</button>
                </form>
            </div>

            <div class="review-section mt-5">
                <h4>Write a Review</h4>
                <form method="POST" action="">
                    <input type="hidden" name="review" value="1">
                    <div class="mb-3">
                        <label for="user_name" class="form-label">Your Name</label>
                        <input type="text" class="form-control" id="user_name" name="user_name" required>
                    </div>
					
			<div class="mb-3">
				<label for="rating" class="form-label">Rating</label>
					<div id="star-rating" class="star-rating">
						<i class="fa-regular fa-star" data-value="1"></i>
						<i class="fa-regular fa-star" data-value="2"></i>
						<i class="fa-regular fa-star" data-value="3"></i>
						<i class="fa-regular fa-star" data-value="4"></i>
						<i class="fa-regular fa-star" data-value="5"></i>
					</div>
					<input type="hidden" id="rating" name="rating" required>
			</div>
					
                    <div class="mb-3">
                        <label for="comment" class="form-label">Comment</label>
                        <textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-outline-light">Submit Review</button>
                </form>
            </div>
			
			<h4 class="mt-4">Reviews</h4>
			<div id="reviews-list">
				<?php
					while ($review = $reviews_result->fetch_assoc()) {
						$ratingStars = str_repeat("★", $review['Rating']) . str_repeat("☆", 5 - $review['Rating']);
						$reviewDate = new DateTime($review['ReviewDate']);
						$formattedDate = $reviewDate->format('M d, Y');

					echo "
				<div class='review'>
					<div class='review-header'>
						<strong>" . htmlspecialchars($review['UserName']) . "</strong> 
						<span class='stars'>$ratingStars</span>
						<small>$formattedDate</small>
					</div>
				<div class='review-comment'>
                " . nl2br(htmlspecialchars($review['Comment'])) . "
				</div>
            <hr>
        </div>
        ";
    }
    ?>
			</div>

			
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


<script>
    const stars = document.querySelectorAll('#star-rating i');
    const ratingInput = document.getElementById('rating');

    stars.forEach(star => {
        star.addEventListener('click', () => {
            const ratingValue = star.getAttribute('data-value');
            ratingInput.value = ratingValue;

            stars.forEach(s => {
                s.classList.remove('fa-solid');
                s.classList.add('fa-regular');
            });

            for (let i = 0; i < ratingValue; i++) {
                stars[i].classList.remove('fa-regular');
                stars[i].classList.add('fa-solid');
            }
        });
    });
</script>

<script>
    async function loadReviews() 
    {
        const response = await fetch('/get-reviews'); // your API endpoint
        const reviews = await response.json();

        const reviewsList = document.getElementById('reviews-list');
        reviewsList.innerHTML = '';

        reviews.forEach(review => 
	{
            const reviewDiv = document.createElement('div');
            reviewDiv.classList.add('review');

            const stars = '★'.repeat(review.rating) + '☆'.repeat(5 - review.rating);

            reviewDiv.innerHTML = `
                <div class="review-header">
                    <strong>${review.username}</strong> 
                    <span class="stars">${stars}</span>
                    <small>${new Date(review.date).toLocaleDateString()}</small>
                </div>
                <div class="review-comment">
                    ${review.comment}
                </div>
                <hr>
            `;

            reviewsList.appendChild(reviewDiv);
        });
    }

    loadReviews();
</script>


</body>
</html>
