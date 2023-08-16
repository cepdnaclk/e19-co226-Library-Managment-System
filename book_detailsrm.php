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

    // Check if the form was submitted
    if (isset($_POST['add_to_waiting_list'])) {
        $bookID = $_POST['BookID'];
        $username = $_SESSION['user_id'];

        // Retrieve BorrowerID based on username
        $borrowerIDQuery = "SELECT BorrowerID FROM borrower WHERE UserName = ?";
        $borrowerIDStmt = $conn->prepare($borrowerIDQuery);
        $borrowerIDStmt->bind_param("s", $username);
        $borrowerIDStmt->execute();
        $borrowerIDStmt->bind_result($borrowerID);
        $borrowerIDStmt->fetch();
        $borrowerIDStmt->close();

        if ($borrowerID) {
            // Insert the book into the waiting list
            $insertWaitingListSql = "DELETE FROM loantransaction WHERE BookID = ? AND BorrowerID = ?";
            $insertWaitingListStmt = $conn->prepare($insertWaitingListSql);
            $insertWaitingListStmt->bind_param("ii", $bookID, $borrowerID);

            if ($insertWaitingListStmt->execute()) {
                $successMessage = "Book added to waiting list successfully.";
                echo '<script>
                        alert("Book added to waiting list successfully.");
                        window.location.href = "book_details.php";
                    </script>';
                header("Location: available_books.php");
                exit();
            } else {
                $errorMessage = "Error: Unable to add book to waiting list. Please try again.";
            }

            $insertWaitingListStmt->close();
        } else {
            $errorMessage = "Error: Borrower not found for the provided username.";
        }
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
                    <p><strong>Discription :</strong>' . $row['Discription'] . '</p>
                    <p><strong>Book ID :</strong> ' . $row['BookID'] . '</p>
                    <p><strong>ISBN :</strong> ' . $row['ISBN'] . '</p>
                    <p><strong>Publisher :</strong> ' . $row['Publisher'] . '</p>
                    <p><strong>Publication Year :</strong> ' . $row['PublicationYear'] . '</p>
                    <p><strong>Language :</strong> ' . $row['Language'] . '</p>
                    <p><strong>Genre :</strong> ' . $row['Genre'] . '</p>
                    <p><strong>Author :</strong> ' . $row['FirstName'] . ' ' . $row['LastName'] . '</p>
                    <form method="post">
                        <input type="hidden" name="BookID" value="' . $row['BookID'] . '">
                        <button type="submit" name="add_to_waiting_list" style="background-color: red;">Remove from Waiting List</button>
                    </form>
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