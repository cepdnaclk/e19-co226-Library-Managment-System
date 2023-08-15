<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $pageTitle; ?></title>

        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="shortcut icon" href="/assert/img/icosmall.png"> 
        <link rel="stylesheet" href="assert/css/style.css">
    </head>

    <body>
        <!--Ion icons js link -->
        <script src="https://unpkg.com/ionicons@latest/dist/ionicons.js"></script>

        <header class="header">      
            <a href="home.php" class="logo">
                <img src="assert/img/icosmall.png">
            </a>

            <nav class="navbar">          
                <a href="home.php">Home</a>
                <a href="search.php">Books</a>
                <a href="about.php">Contact</a>

                <?php
                // Start the session to work with session data
                session_start();

                if (isset($_SESSION['user_id'])) {
                    // Display these links if the user is not logged in
                    echo '<a href="view_account.php">Account Settings</a>';
                    echo '<a href="logout.php">Log-out</a>';
                } else {
                    // Display this link if the user is logged in
                    echo '<a href="login.php">Log-in</a>';
                }
                ?>
            </nav>

        </header>