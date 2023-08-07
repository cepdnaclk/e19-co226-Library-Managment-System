<?php
session_start();

if (isset($_SESSION['user_id'])) {
    if ($_SESSION['roleid'] == 'staff') {
        header("Location: libraryhome.html");
    } else {
        header("Location: login.html");
    }
    exit();
}

header("Location: home.php");
exit();
?>
