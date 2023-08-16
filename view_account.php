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
$query = "SELECT FirstName, LastName, Address, PhoneNumber, Email FROM borrower WHERE UserName = 'dasuntheekshana'";
$stmt = $conn->prepare($query);
if (!$stmt) {
    die("Error in preparing statement: " . $conn->error);
}
// $stmt->bind_param("s", $loggedInUserID);
if (!$stmt->execute()) {
    die("Error executing query: " . $stmt->error);
}
$stmt->bind_result($loggedInFirstName, $loggedInLastName, $loggedInAddress, $loggedInPhoneNumber, $loggedInEmail);
echo '<div class="overview">
        <h2>Account Details</h2>
        <div class="account-details">
            <p><strong>User Name    : </strong>'. $loggedInUserID . '</p>
            <p><strong>First Name   : </strong>'. $loggedInFirstName. '</p>
            <p><strong>Last Name    : </strong>'. $loggedInLastName . '</p>
            <p><strong>Address      : </strong>'. $loggedInAddress . '</p>
            <p><strong>Phone Number : </strong>'. $loggedInPhoneNumber . '</p>
            <p><strong>Email        : </strong>' . $loggedInEmail . '</p>
        </div>
    </div>';
$stmt->fetch();
$stmt->close();

$conn->close();
?>

<?php
include 'footer.php';
?>