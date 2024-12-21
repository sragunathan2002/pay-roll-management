<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $hashed_password = password_hash($password, PASSWORD_BCRYPT); // Hash password for security

    // Check if the username already exists
    $check_query = "SELECT * FROM users WHERE username = '$username'";
    $check_result = $conn->query($check_query);

    if ($check_result->num_rows > 0) {
        echo "<script>alert('Username already exists!');</script>";
    } else {
        // Insert the new user into the database
        $insert_query = "INSERT INTO users (username, password) VALUES ('$username', '$hashed_password')";
        if ($conn->query($insert_query) === TRUE) {
            header("Location: login.php"); // Redirect to login page after successful registration
        } else {
            echo "<script>alert('Error: " . $conn->error . "');</script>";
        }
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Payroll System</title>
    <style>
        /* Include the previous theme styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
            color: #333;
            padding-bottom: 60px; /* Prevent overlap with footer */
        }

        header {
            background-color: #005b96;
            color: white;
            padding: 20px;
            text-align: center;
        }

        header h1 {
            margin: 0;
            font-size: 2.5rem;
        }

        .logo {
            font-weight: bold;
            font-size: 1.5rem;
        }

        main {
            padding: 30px;
            text-align: center;
        }

        .register-container {
            background-color: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: 0 auto;
        }

        .register-container h2 {
            font-size: 1.75rem;
            color: #005b96;
        }

        .register-container label {
            font-size: 1.125rem;
            margin: 10px 0;
            display: block;
        }

        .register-container input {
            padding: 10px;
            width: 100%;
            margin: 10px 0 20px;
            border-radius: 8px;
            border: 1px solid #ddd;
            font-size: 1rem;
        }

        .register-container button {
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            background-color: #007BFF;
            color: white;
            cursor: pointer;
            font-size: 1.125rem;
            transition: background-color 0.2s ease, transform 0.2s ease;
        }

        .register-container button:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 15px;
            position: relative;
            width: 100%;
            bottom: 0;
            z-index: 0;
        }

        footer a {
            color: white;
            text-decoration: none;
        }

        /* Styling for 'Login here' link */
        .register-container a {
            color: green;
            text-decoration: none; /* Optionally, remove underline */
        }

        .register-container a:hover {
            text-decoration: underline; /* Optional: underline on hover */
        }

        @media (max-width: 768px) {
            header h1 {
                font-size: 2rem;
            }

            .register-container {
                padding: 20px;
            }

            .register-container h2 {
                font-size: 1.5rem;
            }

            .register-container input, .register-container button {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>

<header>
    <div class="logo">PayPro Solutions</div>
    <h1>Cloud-based Intelligent Payroll Management</h1>
</header>

<main>
    <div class="register-container">
        <h2>Register</h2>
        <form method="POST" action="register.php">
            <label for="username">Username *</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password *</label>
            <input type="password" id="password" name="password" required>

            <button type="submit" class="btn">Register</button>
        </form>

        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>
</main>

<footer>
    <p>&copy; 2024 PayPro Solutions. All Rights Reserved.</p>
</footer>

</body>
</html>
