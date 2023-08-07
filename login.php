<?php
session_start();

require_once 'db.php';

// Establish a database connection
$conn = new mysqli($host, $dbUsername, $dbPassword);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form was submitted
if (isset($_POST['submit'])) {
    // Retrieve the input values
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($conn->select_db($dbName) === false) {
        die("Database selection failed: " . $conn->error);
    }

    $query = "SELECT Username, Password FROM members WHERE Username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($userId, $hashedPassword);
    $stmt->fetch();
    $stmt->close();

    if (password_verify($password, $hashedPassword)) {
        $_SESSION['user_id'] = $username;
        // Login successful, redirect to welcome.php
        header("Location: home.html");
        exit();
    } else {
        // Invalid username or password, display an error message or redirect back to the login page
        $errorMessage = "Incorrect username or password.";
        header("Location: login.html");
    }
}
?>