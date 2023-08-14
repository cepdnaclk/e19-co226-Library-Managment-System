<?php
session_start();

require_once 'db.php';

// Establish a database connection
$conn = new mysqli($host, $dbUsername, $dbPassword);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize error and success messages
$errorMessage = '';
$successMessage = '';

// Check if the form was submitted
if (isset($_POST['submit'])) {
    // Retrieve the input values
    $username = $_POST['username'];
    $email = $_POST['email'];
    $newPassword = $_POST['new_password'];

    if ($conn->select_db($dbName) === false) {
        die("Database selection failed: " . $conn->error);
    }

    // Prepare and execute a query to check if username and email match
    $query = "SELECT members.MemberID, borrower.Email FROM members
              JOIN borrower ON members.MemberID = borrower.BorrowerID
              WHERE members.Username = ? AND borrower.Email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $stmt->bind_result($memberID, $borrowerEmail);
    $stmt->fetch();
    $stmt->close();

    if ($memberID) {
        // Username and email match, update the password
        // Hash the new password before updating in the database
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

        // Prepare and execute a query to update the password
        $updateQuery = "UPDATE members SET Password = ? WHERE MemberID = ?";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bind_param("si", $hashedPassword, $memberID);

        if ($updateStmt->execute()) {
            // Password update successful, display success message
            $successMessage = "Password updated successfully.";
        } else {
            // Password update failed, display error message
            $errorMessage = "Error updating password. Please try again.";
        }

        $updateStmt->close();
    } else {
        // Invalid username or email, display an error message
        $errorMessage = "Username and email do not match.";
    }
}

$conn->close();
header("Location: login.html");
        exit();
?>