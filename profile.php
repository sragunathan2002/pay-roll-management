<?php
session_start();
include 'db.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Get user ID from session
$user_id = $_SESSION['user_id'];

// Fetch user's personal details from the user_details table
$user_details_query = "SELECT * FROM user_details WHERE user_id = '$user_id'";
$user_details_result = $conn->query($user_details_query);
$user_details = $user_details_result->fetch_assoc();

// Fetch user's bank details from the bank_details table
$bank_details_query = "SELECT * FROM bank_details WHERE user_id = '$user_id'";
$bank_details_result = $conn->query($bank_details_query);
$bank_details = $bank_details_result->fetch_assoc();

// Fetch user's transactions
$transactions_query = "SELECT * FROM transactions WHERE user_id = '$user_id'";
$transactions_result = $conn->query($transactions_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile - Payroll System</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* General reset and body styling */
        body, html {
            margin: 0;
            padding: 0;
            font-family: 'Helvetica Neue', sans-serif;
            background-color: #f4f4f9;
            color: #333;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        /* Header styling */
        header {
            background-color: rgba(0, 0, 0, 0.3); /* Semi-transparent black */
            color: white;
            text-align: center;
            padding: 20px;
            backdrop-filter: blur(10px); /* Glass effect */
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        header h1 {
            margin: 0;
            font-size: 2rem;
        }

        /* Profile Container */
        .profile-container {
            max-width: 1100px;
            margin: 40px auto;
            padding: 20px;
            background: rgba(255, 255, 255, 0.85); /* Translucent background */
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(15px); /* Glass effect */
        }

        .profile-container h2 {
            text-align: center;
            font-size: 2rem;
            margin-bottom: 30px;
            color: #005b96;
        }

        .section {
            margin-bottom: 30px;
        }

        .section h3 {
            font-size: 1.5rem;
            color: #005b96;
            border-bottom: 2px solid #005b96;
            padding-bottom: 5px;
            margin-bottom: 15px;
        }

        .section p {
            font-size: 1rem;
            line-height: 1.6;
        }

        .btn {
            display: block;
            width: 150px;
            padding: 10px;
            background-color: #007BFF;
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 8px;
            margin: 20px auto;
            font-size: 1.1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f8f8f8;
        }

        td {
            background-color: #fff;
        }

        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 15px;
            margin-top: auto;
            position: relative;
            z-index: 100;
        }

        /* Mobile responsiveness */
        @media (max-width: 768px) {
            header h1 {
                font-size: 1.5rem;
            }

            .profile-container {
                padding: 15px;
            }

            .profile-container h2 {
                font-size: 1.5rem;
            }

            .section h3 {
                font-size: 1.25rem;
            }

            .btn {
                width: 100%;
            }

.logo {
            font-weight: bold;
            font-size: 1.5rem;
        }

        }
    </style>
</head>
<body>

<header>
   <div class="logo">PayPro Solutions</div>
    <h1>Cloud-based Intelligent Payroll Management</h1>
</header>

<a href="logout.php" class="btn">Logout</a>

<main>
    <div class="profile-container">
        <h2>Your Profile</h2>

        <!-- User Personal Details -->
        <div class="section">
            <h3>Personal Information</h3>
            <p><strong>Name:</strong> <?php echo htmlspecialchars($user_details['name']); ?></p>
            <p><strong>Mobile No:</strong> <?php echo htmlspecialchars($user_details['mobile_no']); ?></p>
            <p><strong>Age:</strong> <?php echo htmlspecialchars($user_details['age']); ?></p>
            <p><strong>Address:</strong> <?php echo nl2br(htmlspecialchars($user_details['address'])); ?></p>
        </div>

        <!-- User Bank Details -->
        <div class="section">
            <h3>Bank Information</h3>
            <?php if ($bank_details): ?>
                <p><strong>Account No:</strong> <?php echo htmlspecialchars($bank_details['account_no']); ?></p>
                <p><strong>IFSC Code:</strong> <?php echo htmlspecialchars($bank_details['ifsc_code']); ?></p>
                <p><strong>Branch:</strong> <?php echo htmlspecialchars($bank_details['branch']); ?></p>
                <p><strong>PAN No:</strong> <?php echo htmlspecialchars($bank_details['pan_no']); ?></p>
                <p><strong>Account Type:</strong> <?php echo htmlspecialchars($bank_details['account_type']); ?></p>
            <?php else: ?>
                <p>No bank details found. Please provide your bank information.</p>
            <?php endif; ?>
        </div>

        <!-- User Transactions -->
        <div class="section">
            <h3>Your Transactions</h3>
            <?php if ($transactions_result->num_rows > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Transaction Date</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($transaction = $transactions_result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $transaction['transaction_date']; ?></td>
                                <td>₹<?php echo $transaction['amount']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No salary transactions available yet.</p>
            <?php endif; ?>
        </div>
    </div>
</main>

<footer>
    <p>&copy; 2024 Smart Payroll Solutions. All rights reserved.</p>
</footer>

</body>
</html>
