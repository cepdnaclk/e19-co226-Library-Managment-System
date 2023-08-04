<?php
// Database connection credentials
$host = 'sql.freedb.tech';
$dbUsername = 'freedb_rootdasun';
$dbPassword = '9VXyBFw@%atPRHn';
$dbName = 'freedb_co226123';

// Establish a database connection
$conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if a book is being returned
if (isset($_POST['return'])) {
    $loanID = $_POST['loan_id'];

    // Update the loantransaction table to set ReturnDate
    $updateSql = "UPDATE loantransaction SET ReturnDate = NOW() WHERE LoanID = ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("i", $loanID);
    $updateStmt->execute();

    // Retrieve details of the returned book
    $selectSql = "SELECT BookID, BorrowerID FROM loantransaction WHERE LoanID = ?";
    $selectStmt = $conn->prepare($selectSql);
    $selectStmt->bind_param("i", $loanID);
    $selectStmt->execute();
    $result = $selectStmt->get_result();
    $row = $result->fetch_assoc();
    $bookID = $row['BookID'];
    $borrowerID = $row['BorrowerID'];

    // Insert the returned book into the returned_books table
    $insertSql = "INSERT INTO returned_books (LoanID, BookID, BorrowerID) VALUES (?, ?, ?)";
    $insertStmt = $conn->prepare($insertSql);
    $insertStmt->bind_param("iii", $loanID, $bookID, $borrowerID);
    $insertStmt->execute();

    $successMessage = "Book returned successfully.";
}

$conn->close();
?>