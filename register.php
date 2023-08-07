<?php
    $pageTitle = "Add Transaction- Engineering Library";
    include 'header.php';
?>

<div class="overview">

    <h1>Register as New Borrower</h1>
    <hr>
    <form action="registration.php" method="POST" class="return add-book">
        <div class="loan">
            <input type="text" name="username" id="username" placeholder="User Name" required>
        </div>
        <div class="loan">
            <input type="text" name="first_name" id="first_name" placeholder="First Name" required>
        </div>
        <div class="loan">
            <input type="text" name="last_name" id="last_name" placeholder="Last Name" required>
        </div>
        <div class="loan">
            <input type="email" name="email" id="email" placeholder="Email" required>
        </div>
        <div class="loan">
            <input type="password" name="password" id="password" placeholder="Password" required>
        </div>
        <div class="loan">
            <input type="password" name="repassword" id="repassword" placeholder="Retype Password" required>
        </div>
        <div class="loan">
            <input type="text" name="address" id="address" placeholder="Address" required>
        </div>
        <div class="loan">
            <input type="text" name="phone_number" id="phone_number" placeholder="Phone Number" required>
        </div>
        <div class="loan-btn">
            <input type="submit" name="submit" value="Register">
        </div>
        <div class="formtext">
            <p>Already register:<a href="login.php">login</a></p>
        </div>
    </form>
</div>

<?php
    include 'footer.php';
?>