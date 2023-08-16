<?php
    $pageTitle = "Home (Staff) - Engineering Library";
    include 'header.php';
?>

<div class="container">

    <div class="box" style="--clr:#30b93e" >
        <div class="content">
            <div class="icon"><ion-icon name="book-sharp"></ion-icon></div>
                <div class="text">
                <h3>Add Books</h3>
                <p>Add a Book to Library...</p>
                <a href="add_book.php">Add + </a>
                </div>
        </div>   
    </div>

    <div class="box" style="--clr:#96178d">
        <div class="content">
            <div class="icon"><ion-icon name="earth"></ion-icon></div>
                <div class="text">
                <h3>Wating List</h3>
                <p>Wating list of Books...</p>
                <a href="waitinglist.php">View > </a>
                </div>
        </div>   
    </div>

    <div class="box" style="--clr:#e53c3c">
        <div class="content">
            <div class="icon"><ion-icon name="walk-sharp"></ion-icon></div>
                <div class="text">
                <h3>Issue</h3>
                <p>Record Loan Transaction...</p>
                <a href="loanbook.php">Lend + </a>
                </div>
        </div>   
    </div>

    <div class="box" style="--clr:#2b56da">
        <div class="content">
            <div class="icon"><ion-icon name="chatbubble-ellipses"></ion-icon></div>
                <div class="text">
                <h3>Returned</h3>
                <p>Get Back a book...</p>
                <a href="returnbook.php">Get + </a>
                </div>
        </div>   
    </div>

</div>

<?php
    include 'footer.php';
?>