<?php
    $pageTitle = "Account Details - Engineering Library";
    include 'header.php';
?><?php


require_once 'db.php';

// Establish a database connection
$conn = new mysqli($host, $dbUsername, $dbPassword, $dbName); // Include $dbName here

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get user ID from the session
$loggedInUserID = $_SESSION['user_id'];

// Retrieve user details for displaying in the form
$query = "SELECT FirstName, LastName, Address, PhoneNumber, Email FROM borrower WHERE UserName = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $loggedInUserID);
$stmt->execute();
$stmt->bind_result($loggedInFirstName, $loggedInLastName, $loggedInAddress, $loggedInPhoneNumber, $loggedInEmail);
$stmt->fetch();
$stmt->close();

$conn->close();
?>

<!-- Display the account details -->
<!DOCTYPE html>
<html>

    <head>
        <title>View Account - Library System</title>
        <link rel="shortcut icon" href="/assert/img/icosmall.png">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="assert/css/main.css">
        <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }

        .form {
            background-color: #ffffff;
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .form h2 {
            margin-bottom: 20px;
            text-align: center;
            color: #333;
        }

        .account-details {
            font-size: 16px;
            color: #666;
        }

        .account-details p {
            margin-bottom: 10px;
        }
        </style>
    </head>

    <body>
        <div class="form">
            <h2>Account Details</h2>
            <div class="account-details">
                <p><strong>First Name:</strong> <?php echo $loggedInFirstName; ?></p>
                <p><strong>Last Name:</strong> <?php echo $loggedInLastName; ?></p>
                <p><strong>Address:</strong> <?php echo $loggedInAddress; ?></p>
                <p><strong>Phone Number:</strong> <?php echo $loggedInPhoneNumber; ?></p>
                <p><strong>Email:</strong> <?php echo $loggedInEmail; ?></p>
            </div>
        </div>
    </body>

</html>