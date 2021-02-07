<?php
session_start();
// logout.php?logoutにアクセスしたユーザーをログアウトする
    header("Location: login.php");

?>
<script type="text/javascript">
    firebase.auth().signout().then(function(){
        window.location.href = './login.php';
    }).catch(function(error){

    });
</script>
