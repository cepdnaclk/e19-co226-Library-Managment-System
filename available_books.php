<?php
    $pageTitle = "Wating List - Engineering Library";
    include 'header.php';
?>

<div class="overview">

    <h1>Your Wating List</h1>
    <hr>
    <section class="containercards">
        <h2>Wating List</h2>
        <?php


    require_once 'db.php';

    // Establish a database connection
    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

    // Check if the connection was successful
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get the logged-in user's username
    $loggedInUsername = $_SESSION['user_id'];
    
    // Fetch the BorrowerID associated with the logged-in username
    $query = "SELECT BorrowerID FROM borrower WHERE UserName = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $loggedInUsername);
    $stmt->execute();
    $stmt->bind_result($loggedInBorrowerID);
    $stmt->fetch();
    $stmt->close();

    if (!$loggedInBorrowerID) {
        echo "<p>Error: Unable to retrieve user information.</p>";
    } else {
        // Retrieve returned books for the user
        $query = "SELECT book.ImgURL, book.Title, book.Discription, book.BookID
                  FROM loantransaction
                  INNER JOIN book ON loantransaction.BookID = book.BookID
                  WHERE loantransaction.BorrowerID = ? AND Approved = 0";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $loggedInBorrowerID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $bookID = $row['BookID'];
                echo '<div class="card"> 
                        <div class="card-image"><img src="' . $row['ImgURL'] .'"></div>
                        <h2 class="movietitle">'.$row['Title'].'</h2>
                        <p class="moviepara">'.$row['Discription'].'</p>
                        <a href="book_detailsrm.php?BookID=' . $bookID . '" class="linke">READ MORE</a>

</div>';
}
} else {
echo "<p>No returned books found.</p>";
}

$stmt->close();
}

$conn->close();
?>

    </section>
</div>

<?php
    include 'footer.php';
?>