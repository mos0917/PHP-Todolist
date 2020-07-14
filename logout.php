<?php
session_start();
// logout.php?logoutにアクセスしたユーザーをログアウトする
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['user']);
    header("Location: login.php");
    ?>

    <?php
} else {
    header("Location: login.php");
}
