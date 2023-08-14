<?php
    $pageTitle = "Registration - Engineering Library";
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

// Initialize error and success messages
$errorMessage = '';
$successMessage = '';

// Check if the registration form was submitted
if (isset($_POST['submit'])) {
    // Retrieve form data and sanitize/validate if necessary
    $username = $_POST['username'];
    $password = $_POST['password'];
    $repassword = $_POST['repassword'];
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $address = $_POST['address'];
    $phoneNumber = $_POST['phone_number'];
    $email = $_POST['email'];
    $role = 'borrower'; // Set the role as "borrower"

    if ($password != $repassword){
        $errorMessage = "Password must match";
        // header("Location: register.php");
        exit(); // Exit immediately after redirection
    }

    // Hash the password before storing in the database
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Prepare the SQL statement to insert username, password, and role into the members table
    $sql = "INSERT INTO members (username, password, role) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $username, $hashedPassword, $role);

    // Execute the SQL statement to insert username, password, and role into the members table
    if ($stmt->execute()) {
        // Registration successful for the members table, now insert the borrower profile data
        $memberID = $stmt->insert_id;
        $stmt->close();

        // Prepare the SQL statement to insert borrower profile data into the borrowers table
        $sql = "INSERT INTO borrower (BorrowerID, UserName, FirstName, LastName, Address, PhoneNumber, Email) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Error in preparing statement: " . $conn->error);
        }
            
        $stmt->bind_param("issssss", $memberID, $username, $firstName, $lastName, $address, $phoneNumber, $email);

        // Execute the SQL statement to insert borrower profile data into the borrowers table
        if ($stmt->execute()) {
            // Registration successful for both tables
            $successMessage = "Registration successful. BorrowerID: " . $memberID;
            header("Location: login.php");
        } else {
            // Registration failed for borrowers table
            $errorMessage = "Error: Unable to register. Please try again.";
        }
    } else {
        // Registration failed for members table
        $errorMessage = "Error: Unable to register. Please try again.";
    }

    $stmt->close();
    // header("Location: login.php");
    exit(); // Exit immediately after redirection
}

$conn->close();
?>

<div class="overview">

    <h1>Register as New Borrower</h1>
    <hr>
    <form action="registration.php" method="POST" class="return add-book">
        <div class="loan">
            <input type="text" name="username" id="username" placeholder="User Name" required>
        </div>
        <div class="loan">
            <input type="text" name="first_name" id="first_name" placeholder="First Name" required>
        </div>
        <div class="loan">
            <input type="text" name="last_name" id="last_name" placeholder="Last Name" required>
        </div>
        <div class="loan">
            <input type="email" name="email" id="email" placeholder="Email" required>
        </div>
        <div class="loan">
            <input type="password" name="password" id="password" placeholder="Password" required>
        </div>
        <div class="loan">
            <input type="password" name="repassword" id="repassword" placeholder="Retype Password" required>
        </div>
        <div class="loan">
            <input type="text" name="address" id="address" placeholder="Address" required>
        </div>
        <div class="loan">
            <input type="text" name="phone_number" id="phone_number" placeholder="Phone Number" required>
        </div>
        <div class="loan-btn">
            <input type="submit" name="submit" value="Register">
        </div>
        <?php
            if ($errorMessage) {
                echo "<p style='color: red;' class='formtext'>$errorMessage</p>";
            }
        ?>
        <div class="formtext">
            <p>Already register:<a href="login.php">login</a></p>
        </div>
    </form>
</div>

<?php
    include 'footer.php';
?>