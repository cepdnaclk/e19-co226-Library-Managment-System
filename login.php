<?php
// Check if the form was submitted
if (isset($_POST['submit'])) {
    // Retrieve the input values
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Database connection credentials
    $host = 'localhost';
    $dbUsername = 'root';
    $dbPassword = '';
    $dbName = 'library_management_system';

    // Establish a database connection
    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

    // Check if the connection was successful
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare the SQL statement
    $sql = "SELECT * FROM users WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Login successful, redirect the user to a dashboard or homepage
        header("Location: dashboard.php");
        exit();
    } else {
        // Invalid credentials, display an error message or redirect back to the login page
        $errorMessage = "Invalid username or password";
    }

    $stmt->close();
    $conn->close();
}
?>
