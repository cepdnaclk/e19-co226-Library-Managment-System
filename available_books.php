<?php
    $pageTitle = "Available Book- Engineering Library";
    include 'header.php';
?>

<div class="overview">

    <h1>Find a Book</h1>
    <hr>
    <form action="search_books.php" method="GET" class="search-bar">
        <!-- <label for="search_query">Search by Title or Author:</label> -->
        <input type="text" name="search_query" id="search_query" placeholder="Search by Title or Author" required>
        <input type="submit" name="submit" value="Search">
    </form>

    <section class="containercards">
        <h2>Available Books</h2>
        <?php
    require_once 'db.php';

    // Establish a database connection
    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

    // Check if the connection was successful
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $availableBooksSql = "SELECT ImgURL, Title, Discription FROM `book` WHERE Availability = 1 LIMIT 10;";
    $availableBooksStmt = $conn->prepare($availableBooksSql);
    $availableBooksStmt->execute();
    $availableBooksResult = $availableBooksStmt->get_result();

    if ($availableBooksResult->num_rows > 0) {
        while ($row = $availableBooksResult->fetch_assoc()) {
            echo '<div class="card"> 
                    <div class="card-image"><img src="' . $row['ImgURL'] .'"></div>
                    <h2 class="movietitle">'.$row['Title'].'</h2>
                    <p class="moviepara">'.$row['Discription'].'</p>
                    <a href = "" class="linke">READ MORE</a>  
                </div>';
        }
    } else {
        echo "<p>No available books found.</p>";
    }

    $availableBooksStmt->close();
    
    $conn->close();
    ?>

    </section>
</div>

<?php
    include 'footer.php';
?>