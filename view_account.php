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


<div class="overview">
    <h2>Account Details</h2>
    <div class="account-details">
        <p><strong>First Name:</strong> <?php echo $loggedInFirstName; ?></p>
        <p><strong>Last Name:</strong> <?php echo $loggedInLastName; ?></p>
        <p><strong>Address:</strong> <?php echo $loggedInAddress; ?></p>
        <p><strong>Phone Number:</strong> <?php echo $loggedInPhoneNumber; ?></p>
        <p><strong>Email:</strong> <?php echo $loggedInEmail; ?></p>
    </div>
</div>

<?php
include 'footer.php';
?>