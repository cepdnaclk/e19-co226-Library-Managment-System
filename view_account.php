<?php
$pageTitle = "Account Details - Engineering Library";
include 'header.php';
?>

<?php
require_once 'db.php';

// Establish a database connection
$conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get user ID from the session
$loggedInUserID = $_SESSION['user_id'];

// Retrieve user details for displaying in the form
$query = "SELECT BorrowerID, FirstName, LastName, Address, PhoneNumber, Email FROM borrower WHERE UserName = ?";
$stmt = $conn->prepare($query);
if (!$stmt) {
    die("Error in preparing statement: " . $conn->error);
}
$stmt->bind_param("s", $loggedInUserID);
if (!$stmt->execute()) {
    die("Error executing query: " . $stmt->error);
}
$stmt->bind_result($loggedInBorrowerID, $loggedInFirstName, $loggedInLastName, $loggedInAddress, $loggedInPhoneNumber, $loggedInEmail);

// Fetch and display user details
$stmt->fetch();
echo '<div class="overview">
        <h2>Account Details</h2>
        <hr>
        <div class="account-details">
            <p><strong>Borrower ID  : </strong>'. $loggedInBorrowerID . '</p>
            <p><strong>User Name    : </strong>'. $loggedInUserID . '</p>
            <p><strong>First Name   : </strong>'. $loggedInFirstName. '</p>
            <p><strong>Last Name    : </strong>'. $loggedInLastName . '</p>
            <p><strong>Address      : </strong>'. $loggedInAddress . '</p>
            <p><strong>Phone Number : </strong>'. $loggedInPhoneNumber . '</p>
            <p><strong>Email        : </strong>' . $loggedInEmail . '</p>
        </div>
    </div>';
$stmt->close();

$conn->close();
?>

<?php
include 'footer.php';
?>