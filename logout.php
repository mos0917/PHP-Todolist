<?php
session_start();
// logout.php?logoutにアクセスしたユーザーをログアウトする
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['user']);
    header("Location: login.php");
    ?>
<script>
    function signOut() {
        var auth2 = gapi.auth2.getAuthInstance();
        auth2.signOut().then(function () {
            console.log('User signed out.');
        });
    }
</script>
    <?php
} else {
    header("Location: login.php");
}
