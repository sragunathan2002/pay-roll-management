<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect if not logged in
    exit();
}

$user_id = $_SESSION['user_id'];

// Check if user details already exist
$query = "SELECT * FROM user_details WHERE user_id = '$user_id'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    // If data exists, redirect to the next page (bank details page)
    $row = $result->fetch_assoc();
    if (!empty($row['name']) && !empty($row['mobile_no']) && !empty($row['dob']) && !empty($row['age']) && !empty($row['address'])) {
        // Data is complete, redirect to the bank details page
        header("Location: bank_details.php");
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user inputs and validate them
    $name = strtoupper(mysqli_real_escape_string($conn, $_POST['name'])); // Convert to uppercase
    $mobile_no = mysqli_real_escape_string($conn, $_POST['mobile_no']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']); // Date of Birth
    $age = mysqli_real_escape_string($conn, $_POST['age']);
    $address = strtoupper(mysqli_real_escape_string($conn, $_POST['address'])); // Convert to uppercase

    // Validate mobile number to ensure it's 10 digits
    if (strlen($mobile_no) != 10 || !is_numeric($mobile_no)) {
        echo "<script>alert('Please enter a valid 10-digit mobile number');</script>";
    } else {
        // Insert data into user_details table
        $sql = "INSERT INTO user_details (user_id, name, mobile_no, dob, age, address) 
                VALUES ('$user_id', '$name', '$mobile_no', '$dob', '$age', '$address')";

        if ($conn->query($sql) === TRUE) {
            header("Location: bank_details.php"); // Redirect to bank details page
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cloud-based Intelligent Payroll Management</title>
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
            position: relative;
        }

        header h1 {
            margin: 0;
            font-size: 2.5rem; /* Adjust for responsiveness */
        }

        .logo {
            font-weight: bold;
            font-size: 1.5rem; /* Adjust for responsiveness */
        }

        .info-container {
            margin: 30px;
            text-align: center;
        }

        .info-container h2 {
            font-size: 1.75rem;
            color: #005b96;
        }

        .info-container form {
            max-width: 600px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .info-container label {
            font-size: 18px;
            display: block;
            margin: 10px 0;
        }

        .info-container input, .info-container textarea {
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 16px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        .info-container button {
            padding: 15px 30px;
            border: none;
            border-radius: 8px;
            background-color: #007BFF;
            color: white;
            cursor: pointer;
            font-size: 1.125rem; /* Adjust for responsiveness */
            transition: transform 0.2s ease, background-color 0.2s ease;
            width: 100%; /* Full width on mobile */
        }

        .info-container button:hover {
            background-color: #0056b3;
            transform: scale(1.1);
        }




/* Logout Button */
.logout-btn {
    position: absolute;
    top: 20px; /* Adjusted for better mobile screen positioning */
    right: 20px;
    padding: 8px 16px;
    background-color: #ff4d4d;
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 14px;
    cursor: pointer;
    transition: background-color 0.2s;
    z-index: 10; /* Ensure it appears above other elements */
}

.logout-btn:hover {
    background-color: #e60000;
}

/* Very small devices (phones in portrait mode) */
@media (max-width: 480px) {
    .logout-btn {
        top: 10px; /* Move closer to the top */
        right: 10px; /* Ensure it stays on the right */
    }
}


        .back-btn {
            padding: 8px 16px;
            background-color: #9E2A2F; /* Mernune color (deep reddish purple) */
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.2s;
            text-decoration: none;
            display: inline-block;
            width: auto; /* Adjust width to content */
            margin-top: 10px;
        }

        .back-btn:hover {
            background-color: #7b1c1f;
        }

        .profile-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #005b96;
            color: white;
            text-decoration: none;
            font-size: 16px;
            border-radius: 5px;
            margin-top: 20px;
            transition: background-color 0.2s;
            width: 100%; /* Full width on mobile */
        }

        .profile-btn:hover {
            background-color: #004080;
        }

        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 15px;
            position: relative;
            bottom: 0;
            width: 100%;
        }

        footer p {
            margin: 0;
        }

        /* Mobile Optimization */
        @media (max-width: 768px) {
            header h1 {
                font-size: 2rem;
            }

            .info-container {
                margin: 15px;
            }

            .info-container form {
                width: 100%;
                padding: 15px;
            }

            .info-container label, .info-container input, .info-container textarea {
                font-size: 16px;
            }

            .info-container button {
                padding: 15px;
            }

            .back-btn, .logout-btn, .profile-btn {
                width: auto;
                font-size: 14px;
                padding: 8px 16px;
            }

            footer {
                padding: 10px;
                font-size: 14px;
            }
        }

        /* Very small devices (phones in portrait mode) */
        @media (max-width: 480px) {
            header h1 {
                font-size: 24px;
            }

            .info-container h2 {
                font-size: 24px;
            }

            .info-container form {
                padding: 10px;
            }

            .info-container input, .info-container textarea {
                font-size: 14px;
                padding: 8px;
            }

            .info-container button {
                font-size: 16px;
                padding: 12px;
            }

            .back-btn, .logout-btn {
                padding: 8px 12px;
                font-size: 12px;
            }

            .profile-btn {
                padding: 12px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

<header>
    <div class="logo">PayPro Solutions</div>
    <h1>Cloud-based Intelligent Payroll Management</h1>
</header>

<!-- Logout Button below header for mobile screens -->
<a href="logout.php" class="logout-btn">Logout</a>

<!-- Back Button -->
<a href="login.php" class="back-btn">Back</a>

<main>
    <div class="info-container">
        <h2>Enter Personal Information</h2>
        <form method="POST" action="user_info.php">
            <label for="name">Name *</label>
            <input type="text" id="name" name="name" required>
            <br><br>

            <label for="mobile_no">Mobile No *</label>
            <input type="text" id="mobile_no" name="mobile_no" required maxlength="10" pattern="\d{10}">
            <br><br>

            <label for="dob">Date of Birth *</label>
            <input type="date" id="dob" name="dob" required>
            <br><br>

            <label for="age">Age *</label>
            <input type="number" id="age" name="age" required>
            <br><br>

            <label for="address">Address *</label>
            <textarea id="address" name="address" required></textarea>
            <br><br>

            <button type="submit" class="btn">Submit</button>
        </form>
    </div>
</main>

<!-- Profile Button -->
<a href="profile.php" class="profile-btn">Click to Open Profile</a>

<footer>
    <p>&copy; 2024 PayPro Solutions. All Rights Reserved.</p>
</footer>

</body>
</html>
