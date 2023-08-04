<?php
session_start();

// Check if the form was submitted
if (isset($_POST['submit'])) {
    // Retrieve the input values
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Default MySQL credentials
    $defaultUsername = 'root';
    $defaultPassword = '';

    if ($username === $defaultUsername && $password === $defaultPassword) {
        $_SESSION['user_id'] = $username;
        // Login successful, redirect to welcome.php
        header("Location: home.html");
        exit();
    } else {
        // Invalid username or password, display an error message or redirect back to the login page
        $errorMessage = "Invalid username or password";
    }
}
?>