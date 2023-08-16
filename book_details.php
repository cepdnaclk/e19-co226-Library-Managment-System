<?php
$pageTitle = "Book Details - Engineering Library";
include 'header.php';
?>

<div class="overview">
    <h1>Book Details</h1>
    <hr>

    <?php
    require_once 'db.php';

    // Establish a database connection
    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

    // Check if the connection was successful
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (isset($_GET['BookID'])) {
        $bookID = $_GET['BookID'];

        $bookDetailsSql = "SELECT b.*, a.FirstName, a.LastName FROM `book` AS b
                           INNER JOIN `author` AS a ON b.Author = a.AuthorID
                           WHERE b.BookID = ?";
        $bookDetailsStmt = $conn->prepare($bookDetailsSql);
        $bookDetailsStmt->bind_param("i", $bookID);
        $bookDetailsStmt->execute();
        $bookDetailsResult = $bookDetailsStmt->get_result();

        if ($bookDetailsResult->num_rows > 0) {
            $row = $bookDetailsResult->fetch_assoc();
            echo '<div class="book-details">
                    <img src="' . $row['ImgURL'] . '" alt="' . $row['Title'] . '">
                    <h2 class="book-title">' . $row['Title'] . '</h2>
                    <p><strong>Book ID:</strong> ' . $row['BookID'] . '</p>
                    <p class="book-description">' . $row['Discription'] . '</p>
                    <p><strong>ISBN:</strong> ' . $row['ISBN'] . '</p>
                    <p><strong>Publisher:</strong> ' . $row['Publisher'] . '</p>
                    <p><strong>Publication Year:</strong> ' . $row['PublicationYear'] . '</p>
                    <p><strong>Language:</strong> ' . $row['Language'] . '</p>
                    <p><strong>Genre:</strong> ' . $row['Genre'] . '</p>
                    <p><strong>Author:</strong> ' . $row['FirstName'] . ' ' . $row['LastName'] . '</p>
                    <!-- Display other book details here -->
                </div>';
        } else {
            echo "<p>No book details found.</p>";
        }

        $bookDetailsStmt->close();
    } else {
        echo "<p>Invalid book ID.</p>";
    }

    $conn->close();
    ?>

</div>

<?php
include 'footer.php';
?>