<?php
// happy_customers.php
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Happy Customers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #1c1c1c;
            color: #f4dc34;
        }

        .happy-customers-section {
            padding: 60px 0;
        }

        .happy-customers-section h1 {
            text-align: center;
            margin-bottom: 40px;
            font-weight: bold;
            color: #fccb04;
        }

        .testimonial {
            background-color: #3c3c3c;
            padding: 30px;
            border-radius: 12px;
            margin-bottom: 30px;
            text-align: center;
            transition: 0.3s;
        }

        .testimonial img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 20px;
        }

        .testimonial:hover {
            background-color: #b4842a;
            color: #1c1c1c;
        }

        .testimonial p {
            font-size: 1.2rem;
            margin-bottom: 15px;
        }

        .testimonial h5 {
            font-weight: bold;
            font-size: 1.5rem;
            color: #fccb04;
        }
    </style>
</head>
<body>

<div class="container happy-customers-section">
    <h1>Our Happy Customers</h1>
    
    <div class="row">
        <!-- Testimonial 1 -->
        <div class="col-md-4">
            <div class="testimonial">
                <img src="https://via.placeholder.com/120" alt="Customer 1">
                <p>"I had an amazing experience with this travel service. The tours were well-organized, and the guides were fantastic!"</p>
                <h5>John Doe</h5>
            </div>
        </div>

        <!-- Testimonial 2 -->
        <div class="col-md-4">
            <div class="testimonial">
                <img src="https://via.placeholder.com/120" alt="Customer 2">
                <p>"A once-in-a-lifetime adventure! I felt like a VIP the entire time. Highly recommend this service to all my friends!"</p>
                <h5>Jane Smith</h5>
            </div>
        </div>

        <!-- Testimonial 3 -->
        <div class="col-md-4">
            <div class="testimonial">
                <img src="https://via.placeholder.com/120" alt="Customer 3">
                <p>"Truly an unforgettable trip. The views were stunning, and the entire process was seamless from start to finish!"</p>
                <h5>Sarah Lee</h5>
            </div>
        </div>
    </div>
    
    <div class="row">
        <!-- Testimonial 4 -->
        <div class="col-md-4">
            <div class="testimonial">
                <img src="https://via.placeholder.com/120" alt="Customer 4">
                <p>"Fantastic customer service and attention to detail. The trip was perfectly tailored to my needs!"</p>
                <h5>Michael Brown</h5>
            </div>
        </div>

        <!-- Testimonial 5 -->
        <div class="col-md-4">
            <div class="testimonial">
                <img src="https://via.placeholder.com/120" alt="Customer 5">
                <p>"An extraordinary experience! This company goes above and beyond to make your trip amazing!"</p>
                <h5>Emily White</h5>
            </div>
        </div>

        <!-- Testimonial 6 -->
        <div class="col-md-4">
            <div class="testimonial">
                <img src="https://via.placeholder.com/120" alt="Customer 6">
                <p>"The best vacation I've ever had! Everything was perfect — from the planning to the execution!"</p>
                <h5>David Wilson</h5>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
