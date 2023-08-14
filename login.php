<?php
    $pageTitle = "Add Transaction- Engineering Library";
    include 'header.php';
?>

<div class="overview">

    <h1>Log-In</h1>
    <hr>
    <form action="auth.php" method="POST" class="return add-book">
        <div class="loan">
            <input type="text" name="username" id="username" placeholder="User Name" required>
        </div>
        <div class="loan">
            <input type="password" name="password" id="password" placeholder="Password" required>
        </div>
        <div class="loan-btn">
            <input type="submit" name="submit" value="Login">
        </div>
        <div class="formtext">
            <p>Not register:<a href="register.php">register</a></p>
        </div>
    </form>
</div>

<?php
    include 'footer.php';
?>