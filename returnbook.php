<?php
    $pageTitle = "Return Books - Engineering Library";
    include 'header.php';
?>

<div class="overview">

    <h1>Return Books</h1>
    <hr>
    <!-- <?php
    if (isset($successMessage)) {
        echo "<p>$successMessage</p>";
    }
    ?> -->
    <form action="return_book.php" method="post" class="search-bar">
        <input type="text" name="loan_id" placeholder="User ID" required>
        <input type="submit" name="return" value="Return">
    </form>
</div>

<?php
    include 'footer.php';
?>