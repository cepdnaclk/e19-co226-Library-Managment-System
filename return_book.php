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
    $days_late = max(0, floor($time_difference / (60 * 60 * 24)));
    $fine = $days_late * 2; // Charge Rs.2 for each day late

    // Prepare the SQL statement to update return date and fine
    $update_loan_query = "UPDATE loantransaction SET ReturnDate = ?, Fine = ? WHERE BorrowerID = ? AND BookID = ?";
    $update_loan_stmt = $conn->prepare($update_loan_query);
    $update_loan_stmt->bind_param("siii", $return_date, $fine, $user_id, $book_id);

    // Execute the SQL statement to update return date and fine
    if ($update_loan_stmt->execute()) {
        // Update availability of the book
        $update_availability_query = "UPDATE book SET Availability = 1 WHERE BookID = ?";
        $update_availability_stmt = $conn->prepare($update_availability_query);
        $update_availability_stmt->bind_param("i", $book_id);
        $update_availability_stmt->execute();
        $update_availability_stmt->close();

        // Close the database connection
        $conn->close();

        // Display popup for successful return with fine
        if ($fine > 0) {
            echo '<script>
                alert("Return recorded successfully. Fine: Rs. ' . $fine . '");
                window.location.href = "returnbook.php";
            </script>';
            exit();
        } else {
            header("Location: returnbook.php");
            exit();
        }
    } else {
        $errorMessage = "Error: Unable to record return. Please try again.";
    }

    $update_loan_stmt->close();
}
?>