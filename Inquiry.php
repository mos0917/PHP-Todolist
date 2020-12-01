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
    <form action="" method="" class="inquiryform">
        <div class="form-group">
            <label class="col-sm-3 control-label" for="name1">ログイン名</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label" for="email">ログインメールアドレス</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label" for="ask1">問い合わせ内容</label>
            <div class="col-sm-6">
                <textarea rows="7" name="" class="form-control"></textarea>
            </div>
        </div>

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
