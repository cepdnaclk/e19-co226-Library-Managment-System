<?php
    $pageTitle = "Home - Engineering Library";
    include 'header.php';
?>

<div class="container">
    <div class="box" style="--clr:#30b93e">
        <div class="content">
            <div class="icon">
                <ion-icon name="book-sharp"></ion-icon>
            </div>
            <div class="text">
                <h3>All Books</h3>
                <p>Continue your journey...</p>
                <a href="search.php">Read More</a>
            </div>
        </div>
    </div>

    <div class="box" style="--clr:#96178d">
        <div class="content">
            <div class="icon">
                <ion-icon name="earth"></ion-icon>
            </div>
            <div class="text">
                <h3>Want to Read</h3>
                <p>Explore more Books...</p>
                <a href="#">Read More</a>
            </div>
        </div>
    </div>

    <div class="box" style="--clr:#e53c3c">
        <div class="content">
            <div class="icon">
                <ion-icon name="walk-sharp"></ion-icon>
            </div>
            <div class="text">
                <h3>Borrowed Books</h3>
                <p>Taken Home...</p>
                <a href="borrowedbooks.php">Read More</a>
            </div>
        </div>
    </div>

    <div class="box" style="--clr:#2b56da">
        <div class="content">
            <div class="icon">
                <ion-icon name="chatbubble-ellipses"></ion-icon>
            </div>
            <div class="text">
                <h3>Reviewed Books</h3>
                <p>Your Feedbacks & Reviews...</p>
                <a href="#">Read More</a>
            </div>
        </div>
    </div>

</div>

<?php
    include 'footer.php';
?>