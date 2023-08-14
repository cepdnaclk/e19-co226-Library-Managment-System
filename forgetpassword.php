<?php
    $pageTitle = "Rest Password Engineering Library";
    include 'header.php';
?>

<div class="overview">

    <h1>Forgot Password</h1>
    <hr>
    <form action="reset_password.php" method="POST" class="return add-book">
        <div class="loan">
            <input type="text" name="username" id="username" placeholder="User Name" required>
        </div>
        <div class="loan">
            <input type="email" name="email" id="email" placeholder="Email" required>
        </div>
        <div class="loan">
            <input type="password" name="new_password" id="new_password" placeholder="New Password" required>
        </div>
        <div class="loan">
            <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" required>
        </div>
        <div class="loan-btn">
            <input type="submit" name="submit" value="Reset Password">
        </div>
        <div class="formtext">
            <p>Login:<a href="login.php">Login</a></p>
        </div>
    </form>
</div>

<?php
    include 'footer.php';
?>