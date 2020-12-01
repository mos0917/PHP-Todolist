<?php
session_start();

// DBとの接続
include_once 'dbconnect.php';

?>
<!DOCTYPE HTML>
<html lang="ja">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=width=device-width, initial-scale=1.0">
    <title>Todo List Member registration</title>
    <link rel="stylesheet" href="style.css">

    <!-- Bootstrap読み込み（スタイリングのため） -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link href="register_style.css" rel="stylesheet">
    <link rel="shortcut icon" href="../../core/img/fukurouimg_white.svg">
</head>
<body>
<div class="container">
    <form method="post" class="form-inquiry">
        <div class="text-left mb-4">
            <h1>問い合わせ</h1>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="username" placeholder="ログインユーザー名" required />
            <label for="inputEmail">ログインユーザー名</label>
        </div>
        <div class="form-group">
            <input type="email"  class="form-control" name="email" placeholder="ログインメールアドレス" required />
            <label for="inputEmail">ログインメールアドレス</label>
        </div>
        <div class="form-group">
            <textarea class="form-control"></textarea>
            <label for="value">問い合わせ内容</label>
        </div>
        <br>

        <button type="submit" class="btn btn-lg btn-success btn-block" name="signup">登録する</button>
        <a href="login.php">ログイン画面に戻る</a>
    </form>

        <div class="form-group">
            <label class="col-sm-3"></label>
            <div class="col-sm-9">
                <button class="btn btn-default">リセット</button>
                <button class="btn btn-default">送信する</button>
            </div>
        </div>
    </form>

</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js" integrity="sha384-1CmrxMRARb6aLqgBO7yyAxTOQE2AKb9GfXnEo760AUcUmFx3ibVJJAzGytlQcNXd" crossorigin="anonymous"></script>
</body>
</html>
