<?php
/*session_start();
// logout.php?logoutにアクセスしたユーザーをログアウトする
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['user']);
    header("Location: login.php");
} else {
    header("Location: login.php");
}*/
?>
<script type="text/javascript">
    firebase.auth().signout().then(function(){
        window.location.href = './login.php';
    }).catch(function(error){

    });
</script>
