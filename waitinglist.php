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
    $bookID = $_POST['book_id'];
    $borrowerID = $_POST['borrower_id'];
    

    // Update the "approved" attribute in the loantransaction table
    $updateSql = "INSERT INTO loantransaction (BookID, BorrowerID, LoanDate, DueDate, Approved) 
            VALUES (?, ?, NULL, NULL, 0)";
    $stmt = $conn->prepare($updateSql);
    $stmt->bind_param("ii", $bookID, $borrowerID);

    if ($stmt->execute()) {
        $successMessage = "Loan approval updated successfully.";
    } else {
        $errorMessage = "Error: Unable to update loan approval. Please try again.";
    }

    $stmt->close();
}

$conn->close();
?>

<?php
    $pageTitle = "Add Wating List - Engineering Library";
    include 'header.php';
?>

<div class="overview">

    <h1>Record Wating List</h1>
    <hr>
    <form method="POST" class="return">
        <div class="loan">
            <input type="text" name="book_id" placeholder="Book ID" required>
        </div>
        <div class="loan">
            <input type="text" name="borrower_id" placeholder="User ID" required>
        </div>
        <div class="loan-btn">
            <input type="submit" name="submit" value="Record Loan">
        </div>
    </form>
</div>

<?php
    include 'footer.php';
?>