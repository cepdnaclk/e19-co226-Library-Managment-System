<?php
require_once 'db.php';

// Establish a database connection
$conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the loan form was submitted
if (isset($_POST['submit'])) {
    // Retrieve form data and sanitize/validate if necessary
    $bookID = $_POST['book_id'];
    $borrowerID = $_POST['borrower_id'];
    $loanDate = $_POST['loan_date'];
    $dueDate = $_POST['due_date'];

    // Prepare the SQL statement to insert loan transaction
    $sql = "UPDATE loantransaction 
            SET LoanDate = ?, DueDate = ?, Approved = 1 
            WHERE BookID = ? AND BorrowerID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssii", $loanDate, $dueDate, $bookID, $borrowerID);

    // Execute the SQL statement to insert loan transaction
    if ($stmt->execute()) {
        // Update the book's availability to 0 (unavailable)
        $updateSql = "UPDATE book SET Availability = 0 WHERE BookID = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("i", $bookID);
        $updateStmt->execute();

        $successMessage = "Loan transaction recorded successfully.";
    } else {
        $errorMessage = "Error: Unable to record loan transaction. Please try again.";
    }

    $stmt->close();
    $updateStmt->close();
}

$conn->close();

// Redirect to loanbook.php
header("Location: loanbook.php");
exit();
?>