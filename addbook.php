<?php
$pageTitle = "Add Book - Engineering Library";
include 'header.php';

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

// Check if the add book form was submitted
if (isset($_POST['submit'])) {
    // Retrieve form data and sanitize/validate if necessary
    $book_title = $_POST['book_title'];
    $book_isbn = $_POST['book_isbn'];
    $book_author = $_POST['book_author'];
    $book_publisher = $_POST['book_publisher'];
    $book_publicationyear = $_POST['book_publicationyear'];
    $book_language = $_POST['book_language'];

    // Check if the author exists in the Author table
    $author_id = null;
    $author_query = "SELECT AuthorID FROM author WHERE CONCAT(FirstName, ' ', LastName) = ?";
    $author_stmt = $conn->prepare($author_query);
    $author_stmt->bind_param("s", $book_author);
    $author_stmt->execute();
    $author_result = $author_stmt->get_result();

    if ($author_result->num_rows > 0) {
        $author_row = $author_result->fetch_assoc();
        $author_id = $author_row['AuthorID'];
    } else {
        // Author does not exist
        $errorMessage = "Author does not exist in the database.";
    }

    $author_stmt->close();

    // If author exists, proceed to insert book information
    if ($author_id !== null && empty($errorMessage)) {
        // Prepare the SQL statement to insert book information
        $insert_book_query = "INSERT INTO `book`(`Title`, `ImgURL`, `Discription`, `ISBN`, `Publisher`, `PublicationYear`, `Language`, `Genre`, `Availability`, `Author`) VALUES (?, NULL, NULL, ?, ?, ?, ?, 1, ?, ?)";
        $insert_book_stmt = $conn->prepare($insert_book_query);
        $insert_book_stmt->bind_param("sisisi", $book_title, $book_isbn, $book_publisher, $book_publicationyear, $book_language, $author_id);

        // Execute the SQL statement to insert book information
        if ($insert_book_stmt->execute()) {
            $successMessage = "Book added successfully.";
        } else {
            $errorMessage = "Error: Unable to add book. Please try again.";
        }

        $insert_book_stmt->close();
    }
}

$conn->close();
header("Location: add_book.php");
exit();
?>