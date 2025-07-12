<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Connect to the database
    include 'db.php';

    // Prepare the SQL query to insert a new user
    $stmt = $conn->prepare("INSERT INTO users (username, email, phone_number, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $email, $phone, $password);

    // Execute the query and check for success
    if ($stmt->execute()) {
        header("Location: login.php");
        exit();
    } else {
        $error_message = "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - Travel Booking</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #1c1c1c;
            color: #f4dc34;
        }

        .container {
            margin-top: 100px; /* Adjusted to move the box a little higher */
        }

        .card {
            background-color: #3c3c3c;
            border-radius: 10px;
            border: none;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            width: 350px; /* Slightly wider registration box */
        }

        .card-body {
            padding: 30px;
        }

        h2 {
            color: #fccb04;
            font-weight: bold;
            font-size: 24px;
        }

        .form-label {
            color: #f4dc34;
        }

        .form-control {
            background-color: #2c2c2c;
            color: #f4dc34;
            border: 1px solid #b4842a;
        }

        .form-control:focus {
            border-color: #fccb04;
            box-shadow: 0 0 0 0.25rem rgba(252, 203, 4, 0.25);
        }

        .btn-primary {
            background-color: #b4842a;
            border-color: #b4842a;
            color: #fff;
        }

        .btn-primary:hover {
            background-color: #fccb04;
            border-color: #fccb04;
            color: #1c1c1c;
        }

        .alert-danger {
            background-color: #b84a2a;
            color: #fff;
            border-radius: 8px;
            padding: 10px;
        }

        .text-center a {
            color: #fccb04;
            text-decoration: none;
        }

        .text-center a:hover {
            text-decoration: underline;
        }

        .footer {
            position: fixed;
            bottom: 10px;
            width: 100%;
            text-align: center;
            color: #fccb04;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 d-flex justify-content-center">
            <div class="card shadow-lg">
                <div class="card-body">
                    <h2 class="text-center mb-4">Register</h2>

                    <?php if (isset($error_message)): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($error_message) ?></div>
                    <?php endif; ?>

                    <form action="register.php" method="POST">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" name="username" id="username" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="text" name="phone" id="phone" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Register</button>
                    </form>

                    <p class="mt-3 text-center">
                        Already have an account? <a href="login.php">Login here</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="footer">
    <?php include 'footer.php'; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
