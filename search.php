<?php
    $pageTitle = "Search Book- Engineering Library";
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
</div>

<?php
    include 'footer.php';
?>