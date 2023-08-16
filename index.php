<?php
session_start();

if (isset($_SESSION['user_id'])) {
    if ($_SESSION['roleid'] == 'staff') {
        header("Location: libraryhome.php");
    } else {
        header("Location: home.php");
    }
    exit();
}

header("Location: home.php");
exit();
?>
