<?php
require_once 'db.php';

// Establish a database connection
$conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form was submitted
if (isset($_POST['submit'])) {
    $loanID = $_POST['loan_id'];
    $approved = isset($_POST['approved']) ? 1 : 0;

    // Update the "approved" attribute in the loantransaction table
    $updateSql = "UPDATE loantransaction SET Approved = ? WHERE LoanID = ?";
    $stmt = $conn->prepare($updateSql);
    $stmt->bind_param("ii", $approved, $loanID);

    if ($stmt->execute()) {
        $successMessage = "Loan approval updated successfully.";
    } else {
        $errorMessage = "Error: Unable to update loan approval. Please try again.";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html>

    <head>
        <title>Approve Loan - Engineering Library</title>
        <link rel="shortcut icon" href="/assert/img/icosmall.png">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="assert/css/main.css">
    </head>

    <body>
        <div class="form">
            <h2>Approve Loan</h2>
            <?php if (isset($successMessage)) { ?>
            <p class="success"><?php echo $successMessage; ?></p>
            <?php } elseif (isset($errorMessage)) { ?>
            <p class="error"><?php echo $errorMessage; ?></p>
            <?php } ?>
            <form method="POST">
                <div class="inputBox">
                    <label for="loan_id">Loan ID</label>
                    <input type="number" name="loan_id" id="loan_id" required>
                </div>
                <div class="inputBox">
                    <label for="approved">Approved</label>
                    <input type="checkbox" name="approved" id="approved">
                </div>
                <div class="inputBox">
                    <input type="submit" name="submit" value="Approve">
                </div>
            </form>
        </div>
    </body>

</html>