<?php
    $pageTitle = "Return Books - Engineering Library";
    include 'header.php';
?>

<div class="overview">
    <h1>Return Books</h1>
    <hr>
    <form action="return_book.php" method="post" class="return">
        <div class="loan">
            <label for="user_id">User ID:</label>
            <input type="text" name="user_id" id="user_id" placeholder="Enter User ID" required>
        </div>
        <div class="loan">
            <label for="book_id">Book ID:</label>
            <input type="text" name="book_id" id="book_id" placeholder="Enter Book ID" required>
        </div>
        <div class="loan">
            <label for="return_date">Return Date:</label>
            <input type="date" name="return_date" id="return_date" required>
        </div>
        <div class="loan-btn">
            <input type="submit" name="return" value="Return">
        </div>
    </form>
</div>

<?php
    include 'footer.php';
?>