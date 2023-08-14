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
    $email = $_POST['email'];

    if ($conn->select_db($dbName) === false) {
        die("Database selection failed: " . $conn->error);
    }

    // Prepare and execute a query to check if username and email match
    $query = "SELECT MemberID FROM members WHERE Username = ? AND Email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $stmt->bind_result($memberID);
    $stmt->fetch();
    $stmt->close();

    if ($memberID) {
        // Username and email match, allow password reset
        // Display a form for the user to enter a new password
        ?>
<!DOCTYPE html>
<html>

    <head>
        <title>Reset Password - Library System</title>
        <link rel="shortcut icon" href="/assert/img/icosmall.png">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="assert/css/main.css">
    </head>

    <body>
        <div class="form">
            <h2>Reset Password</h2>
            <form action="update_password.php" method="POST">
                <div class="input">
                    <div class="inputBox">
                        <label for="new_password">New Password</label>
                        <input type="password" name="new_password" id="new_password" required>
                    </div>
                    <div class="inputBox">
                        <label for="confirm_password">Confirm Password</label>
                        <input type="password" name="confirm_password" id="confirm_password" required>
                    </div>
                    <div class="inputBox">
                        <input type="hidden" name="member_id" value="<?php echo $memberID; ?>">
                        <input type="submit" name="submit" value="Reset Password">
                    </div>
                </div>
            </form>
        </div>
    </body>

</html>
<?php
    } else {
        // Invalid username or email, display an error message
        $errorMessage = "Username and email do not match.";
        header("Location: forgot_password.html");
        exit();
    }
}

$conn->close();
?>