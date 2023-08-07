<?php
    $pageTitle = "Add Transaction- Engineering Library";
    include 'header.php';
?>

<div class="overview">

    <h1>Record Loan Transaction</h1>
    <hr>
    <form action="loan.php" method="POST" class="return">
        <div class="loan">
            <input type="text" name="book_id" placeholder="Book ID" required>
        </div>
        <div class="loan">
            <input type="text" name="borrower_id" placeholder="User ID" required>
        </div>
        <div class="loan">
            <label for="loan_date">Loan Date:</label>
            <input type="date" name="loan_date" required>
        </div>
        <div class="loan">
            <label for="due_date">Due Date:</label>
            <input type="date" name="due_date" required>
        </div>
        <div class="loan-btn">
            <input type="submit" name="submit" value="Record Loan">
        </div>
    </form>
</div>

<?php
    include 'footer.php';
?>