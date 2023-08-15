<?php
    $pageTitle = "Add Book - Engineering Library";
    include 'header.php';
?>

<div class="overview">
    <h1>Add a Book</h1>
    <hr>
    <form action="addbook.php" method="POST" class="return add-book">
        <div class="loan">
            <input type="text" name="book_title" placeholder="Title" required>
        </div>
        <div class="loan">
            <input type="text" name="book_isbn" placeholder="ISBN" required>
        </div>
        <div class="loan">
            <input type="text" name="book_author" placeholder="Author" required>
        </div>
        <div class="loan">
            <input type="text" name="book_publisher" placeholder="Publisher" required>
        </div>
        <div class="loan">
            <input type="text" name="book_publicationyear" placeholder="Publication Year" required>
        </div>
        <div class="loan">
            <input type="text" name="book_language" placeholder="Language" required>
        </div>
        <div class="loan-btn">
            <input type="submit" name="submit" value="Add Book">
        </div>

    </form>
</div>

<?php
    include 'footer.php';
?>