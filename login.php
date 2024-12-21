<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Query to check if the user exists
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        // Verify the password
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            header("Location: user_info.php"); // Redirect to user info page
        } else {
            echo "<script>alert('Incorrect password!');</script>";
        }
    } else {
        echo "<script>alert('User not found!');</script>";
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Payroll System</title>
    <style>
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
            font-size: 36px; /* Ensure this is the same size as the homepage */
        }

        .login-container {
            background-color: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: 0 auto;
        }

        .login-container h2 {
            font-size: 1.75rem;
            color: #005b96;
        }

        .login-container label {
            font-size: 1.125rem;
            margin: 10px 0;
            display: block;
        }

        .login-container input {
            padding: 10px;
            width: 100%;
            margin: 10px 0 20px;
            border-radius: 8px;
            border: 1px solid #ddd;
            font-size: 1rem;
        }

        .login-container button {
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            background-color: #007BFF;
            color: white;
            cursor: pointer;
            font-size: 1.125rem;
            transition: background-color 0.2s ease, transform 0.2s ease;
        }

        .login-container button:hover {
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

        footer p {
            margin: 0;
        }

        /* Styling for 'Register here' link */
        .login-container a {
            color: green;
            text-decoration: none; /* Optional: Remove underline */
        }

        .login-container a:hover {
            text-decoration: underline; /* Optional: Underline on hover */
        }

        @media (max-width: 768px) {
            header h1 {
                font-size: 2rem; /* Ensure it adjusts properly on small screens */
            }

            .login-container {
                padding: 20px;
            }

            .login-container h2 {
                font-size: 1.5rem;
            }

            .login-container input, .login-container button {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>

<header>
   <h1> <div class="logo">PayPro Solutions</div></h1>
    <h1>Cloud-based Intelligent Payroll Management</h1>
</header>

<main>
    <div class="login-container">
        <h2>Login</h2>
        <form method="POST" action="login.php">
            <label for="username">Username *</label>
            <input type="text" id="username" name="username" required>
            <br><br>
            <label for="password">Password *</label>
            <input type="password" id="password" name="password" required>
            <br><br>
            <button type="submit" class="btn">Login</button>
        </form>
        <p>Don't have an account? <a href="register.php">Register here</a></p>
    </div>
</main>

<footer>
    <p>&copy; 2024 PayPro Solutions. All Rights Reserved.</p>
</footer>

</body>
</html>
