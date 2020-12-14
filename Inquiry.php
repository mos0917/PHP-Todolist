<?php
session_start();

// DBとの接続
include_once 'dbconnect.php';

if($_POST['post']){
    mb_language('japanese');
    mb_internal_encoding('UTF-8');
    $user = $_POST['loginuser'];
    $mailadd = $_POST['loginmailadd'];
    $inqueryvalue = $_POST['inqueryvalue'];
    $header = "From: shonan.fireball@gmail.com\nReply-To: shonan.fireball@gmail.com\n";
    if(mb_send_mail($user,$mailadd,$inqueryvalue,$header)) {
        echo "問い合わせを送信しました。";
    }else{
        echo "問い合わせの送信に失敗しました。";
    }
}
?>
<!DOCTYPE HTML>
<html lang="ja">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=width=device-width, initial-scale=1.0">
    <title>Todo List Inquiry</title>
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="../../core/img/fukurouimg_white.svg">

    <!-- Bootstrap読み込み（スタイリングのため） -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link href="register_style.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <form method="post" class="form-inquiry">
        <div class="text-left mb-4">
            <h1>問い合わせ</h1>
        </div>
            <label for="inputUser">ログインユーザー名</label>
            <input type="text" id="inputUser" name="loginuser" class="form-control" required="" autofocus="" kl_vkbd_parsed="true">
            <br>

            <label for="inputEmail">ログインメールアドレス</label>
            <input type="email" id="inputEmail" name="loginmailadd" class="form-control" required="" autofocus="" kl_vkbd_parsed="true">
            <br>

            <label for="inputvalue">問い合わせ内容</label>
            <textarea class="form-control" id="inoutvalue" name="inqueryvalue" rows="3" required="" autofocus="" kl_vkbd_parsed="true"></textarea>
            <!--<input type="textarea" id="inputvalue" class="form-control" required="" autofocus="" kl_vkbd_parsed="true">-->
            <br>

        <div class="form-group">
            <label class="col-sm-3"></label>
            <div class="col-sm-9">
                <button  type="reset" class="btn btn-outline-secondary">リセット</button>
                <button class="btn btn-outline-success">送信する</button>

            </div>
        </div>
    </form>

</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js" integrity="sha384-1CmrxMRARb6aLqgBO7yyAxTOQE2AKb9GfXnEo760AUcUmFx3ibVJJAzGytlQcNXd" crossorigin="anonymous"></script>
</body>
</html>
