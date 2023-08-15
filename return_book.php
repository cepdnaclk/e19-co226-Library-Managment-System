<?php
require_once 'db.php';

// Establish a database connection
$conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the return form was submitted
if (isset($_POST['return'])) {
    // Retrieve form data and sanitize/validate if necessary
    $user_id = $_POST['user_id'];
    $book_id = $_POST['book_id'];
    $return_date = $_POST['return_date'];

    // Get the due date for the loan
    $due_date_query = "SELECT DueDate FROM loantransaction WHERE BorrowerID = ? AND BookID = ?";
    $due_date_stmt = $conn->prepare($due_date_query);
    $due_date_stmt->bind_param("ii", $user_id, $book_id);
    $due_date_stmt->execute();
    $due_date_stmt->bind_result($due_date);
    $due_date_stmt->fetch();
    $due_date_stmt->close();

    // Calculate fine for late return
    $due_date_timestamp = strtotime($due_date);
    $return_date_timestamp = strtotime($return_date);
    $time_difference = $return_date_timestamp - $due_date_timestamp;
    $days_late = floor($time_difference / (60 * 60 * 24));
    $fine = max(0, $days_late * 2); // Charge Rs.2 for each day late

    // Prepare the SQL statement to update return date and fine
    $sql = "UPDATE loantransaction SET ReturnDate = ?, Fine = ? WHERE BorrowerID = ? AND BookID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siii", $return_date, $fine, $user_id, $book_id);

    // Execute the SQL statement to update return date and fine
    if ($stmt->execute()) {
        $successMessage = "Return recorded successfully. Fine: Rs. " . $fine;
    } else {
        $errorMessage = "Error: Unable to record return. Please try again.";
    }

    $stmt->close();
}

$conn->close();

header("Location: returnbook.php");
exit();
?>