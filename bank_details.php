<?php 
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect if not logged in
    exit();
}

$user_id = $_SESSION['user_id'];

// Check if bank details already exist for the user
$query = "SELECT * FROM bank_details WHERE user_id = '$user_id'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    // If bank details exist, redirect to the profile page
    header("Location: profile.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user bank inputs and convert to uppercase
    $account_no = strtoupper(mysqli_real_escape_string($conn, $_POST['account_no']));
    $ifsc_code = strtoupper(mysqli_real_escape_string($conn, $_POST['ifsc_code']));
    $branch = strtoupper(mysqli_real_escape_string($conn, $_POST['branch']));
    $pan_no = strtoupper(mysqli_real_escape_string($conn, $_POST['pan_no']));
    $account_type = strtoupper(mysqli_real_escape_string($conn, $_POST['account_type']));
    
    // Validate account number (must be 11 digits)
    if (strlen($account_no) != 11 || !is_numeric($account_no)) {
        echo "<script>alert('Account number must be 11 digits and contain only numbers.');</script>";
    } else {
        // Insert data into bank_details table
        $sql = "INSERT INTO bank_details (user_id, account_no, ifsc_code, branch, pan_no, account_type) 
                VALUES ('$user_id', '$account_no', '$ifsc_code', '$branch', '$pan_no', '$account_type')";

        if ($conn->query($sql) === TRUE) {
            header("Location: profile.php"); // Redirect to profile page after successful submission
        } else {
            echo "Error: " . $conn->error;
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
    <title>Bank Details - Payroll System</title>
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
            padding: 10px 20px; /* Reduced padding to bring content closer */
            text-align: center;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .logo {
            font-weight: bold;
            font-size: 1.5rem;
        }

        header h1 {
            margin: 0;
            font-size: 1.75rem;
        }

        .logout-btn {
            background-color: #ff4d4d;
            border: none;
            color: white;
            padding: 10px 20px;
            font-size: 1rem;
            cursor: pointer;
            border-radius: 5px;
            text-decoration: none;
            position: absolute;
            top: 20px; /* Place the logout button within the header */
            right: 20px;
        }

        /* Styling for the back button */
        .back-btn {
            background-color: #007BFF;
            border: none;
            color: white;
            padding: 10px 20px;
            font-size: 1rem;
            cursor: pointer;
            border-radius: 5px;
            text-decoration: none;
            display: block;
            margin: 10px auto;
            width: 200px;
            text-align: center;
        }

        .bank-container {
            margin-top: 120px; /* Adjusted space between header and content */
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .bank-container h2 {
            font-size: 2rem;
            text-align: center;
            color: #005b96;
        }

        .bank-container form label {
            display: block;
            margin-top: 10px;
            font-size: 1.125rem;
        }

        .bank-container input,
        .bank-container select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            font-size: 1.125rem;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .bank-container button {
            width: 100%;
            padding: 12px;
            background-color: #007BFF;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 1.125rem;
            margin-top: 20px;
            cursor: pointer;
        }

        .bank-container button:hover {
            background-color: #0056b3;
        }

        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 15px;
            position: relative;
            width: 100%;
            bottom: 0;
        }

        /* Mobile Styles */
        @media (max-width: 768px) {
            header {
                padding: 10px 0;
            }

            header h1 {
                font-size: 1.75rem;
                margin: 0;
            }

            .logo {
                font-size: 1.25rem;
                padding-top: 10px; /* Padding for better spacing */
            }

            .logout-btn {
                display: none; /* Hide the desktop logout button on mobile */
            }

            .logout-btn-mobile {
                background-color: #ff4d4d;
                border: none;
                color: white;
                padding: 10px 20px;
                font-size: 1rem;
                cursor: pointer;
                border-radius: 5px;
                text-decoration: none;
                position: fixed;
                top: 80px; /* Placing the logout button below the header */
                right: 20px; /* Align it to the right side */
                z-index: 150;
            }

            .bank-container {
                margin-top: 180px; /* Adjust space between header and form */
                padding: 15px;
            }

            .bank-container h2 {
                font-size: 1.5rem;
            }

            .bank-container input,
            .bank-container select {
                font-size: 1rem;
            }
        }

        @media (min-width: 1200px) {
            .bank-container {
                max-width: 800px;
            }
        }

    </style>
</head>
<body>

    <!-- Logout Button for Mobile -->
    <a href="logout.php" class="logout-btn-mobile">Logout</a>

    <header>
        <div class="logo">PayPro Solutions</div>
        <h1>Cloud-based Intelligent Payroll</h1>
        <!-- Desktop Logout Button -->
        <a href="logout.php" class="logout-btn">Logout</a>
    </header>

    <main>
        <div class="bank-container">
            <h2>Enter Bank Details</h2>
            <form method="POST" action="bank_details.php">
                <label for="account_no">Account No *</label>
                <input type="text" id="account_no" name="account_no" required pattern="\d{11}" maxlength="11" placeholder="Enter 11-digit Account Number" oninput="this.value = this.value.replace(/[^0-9]/g, '').toUpperCase();">

                <label for="ifsc_code">IFSC Code *</label>
                <input type="text" id="ifsc_code" name="ifsc_code" required placeholder="Example: ABCD0123456" oninput="this.value = this.value.toUpperCase();">

                <label for="branch">Branch *</label>
                <input type="text" id="branch" name="branch" required placeholder="Enter Branch Name" oninput="this.value = this.value.toUpperCase();">

                <label for="pan_no">PAN No *</label>
                <input type="text" id="pan_no" name="pan_no" required pattern="[A-Z]{5}[0-9]{4}[A-Z]{1}" maxlength="10" placeholder="Enter PAN No (Example: ABCD1234E)" oninput="this.value = this.value.toUpperCase();">
                <small style="color: #bbb; font-size: 0.9rem;">Example: ABCD1234E</small>

                <label for="account_type">Account Type *</label>
                <select id="account_type" name="account_type" required>
                    <option value="Savings">Savings A/C</option>
                    <option value="Current">Current A/C</option>
                    <option value="Salary">Salary A/C</option>
                    <option value="Other">Other</option>
                </select>

                <button type="submit" class="btn">Submit</button>
            </form>

            <a href="login.php" class="back-btn">Back to Login</a>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 PayPro Solutions. All Rights Reserved.</p>
    </footer>

</body>
</html>
