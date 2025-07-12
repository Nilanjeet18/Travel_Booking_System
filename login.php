<?php
session_start();

// Check if the user is already logged in, redirect to home page
if (isset($_SESSION['user_id'])) 
{
    header("Location: home.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
    {
    // Collect form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Connect to the database
    include 'db.php';

    // Prepare the SQL query to check if the user exists
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    // If the user exists
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $username, $stored_password);
        $stmt->fetch();

        // Verify the password
        if (password_verify($password, $stored_password)) {
            // Set session variables and redirect to home
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $username;
            header("Location: home.php");
            exit();
        } else {
            $error_message = "Invalid email or password.";
        }
    } else {
        $error_message = "Invalid email or password.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Travel Booking</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #1c1c1c;
            color: #f4dc34;
        }

        .container {
            margin-top: 150px; /* Adjusted for better vertical alignment */
        }

        .card {
            background-color: #3c3c3c;
            border-radius: 10px;
            border: none;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            width: 350px; /* Slightly wider login box */
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
                    <h2 class="text-center mb-4">Login</h2>

                    <?php if (isset($error_message)): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($error_message) ?></div>
                    <?php endif; ?>

                    <form action="login.php" method="POST">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </form>

                    <p class="mt-3 text-center">
                        Don't have an account? <a href="register.php">Register here</a>
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
