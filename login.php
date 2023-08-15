<?php
    $pageTitle = "Login- Engineering Library";
    include 'header.php';
?>

<?php
// session_start();

require_once 'db.php';

$errorMessage = '';

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

    $query = "SELECT Username, Password, Role FROM members WHERE Username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($userId, $hashedPassword, $role);
    $stmt->fetch();
    $stmt->close();

    if (password_verify($password, $hashedPassword)) {
        $_SESSION['user_id'] = $username;
        // Redirect users based on their role
        if ($role == "staff") {
            header("Location: libraryhome.html");
        } else {
            header("Location: home.php");
        }
        exit();
    } else {
        // Invalid username or password, display an error message or redirect back to the login page
        $errorMessage = "Incorrect username or password.";
        // header("Location: login.php");
    }
}
?>

<div class="overview">
    <h1>Log-In</h1>
    <hr>
    <form method="POST" class="return add-book">
        <div class="loan">
            <input type="text" name="username" id="username" placeholder="User Name" required>
        </div>
        <div class="loan">
            <input type="password" name="password" id="password" placeholder="Password" required>
        </div>
        <div class="loan-btn">
            <input type="submit" name="submit" value="Login">
        </div>
        <?php
            if ($errorMessage) {
                echo "<p style='color: red;' class='formtext'>$errorMessage</p>";   
            }
            
        ?>
        <div class="formtext">
            <p>Not Registered? <a href="register.php">Register</a></p>
        </div>
    </form>
</div>

<?php
    include 'footer.php';
?>