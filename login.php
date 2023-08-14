<?php
session_start();

require_once 'db.php';

// Establish a database connection
$conn = new mysqli($host, $dbUsername, $dbPassword);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize the error message
$errorMessage = "";

// Check if the form was submitted
if (isset($_POST['submit'])) {
    // Retrieve the input values
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($conn->select_db($dbName) === false) {
        die("Database selection failed: " . $conn->error);
    }

    $query = "SELECT MemberID, Username, Password, Role FROM members WHERE Username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($memberID, $username, $hashedPassword, $role);
    $stmt->fetch();
    $stmt->close();

    if (password_verify($password, $hashedPassword)) {
        $_SESSION['user_id'] = $memberID; // Store the MemberID in the session
        // Login successful, redirect to appropriate page
        echo "User ID: " . $_SESSION['user_id'] . "<br>";
    echo "Role: " . $role . "<br>";
        if ($role == "staff") {
            header("Location: libraryhome.html");
        } else {
            header("Location: home.html");
        }
        exit();
    } else {
        // Invalid username or password, set the error message
        $errorMessage = "Incorrect username or password.";
    }
}
?>