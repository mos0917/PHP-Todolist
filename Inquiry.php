<?php
session_start();



if($_POST['inquirysubmit']){
    mb_language("japanese");
    mb_internal_encoding("UTF-8");
    $to = "taskmanage706@gmail.com";
    $subject = $_POST['inputsummary'];
    $message = $_POST['inputvalue'];
    if(mb_send_mail($to,$subject,$message)) {
        echo "問い合わせの送信に成功しました";
    }else{
        echo "問い合わせの送信に失敗しました";
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
    <!-- 固定ナビゲーションバー -->
    <nav class="navbar navbar-expand-md navbar-light fixed-top">
        <a class="py-2" href="index.php">
            <img src="../../core/img/fukurouimg_white.svg" width="24" height="24"></img>
        </a>
        <a class="navbar-brand text-light">TodoList</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-header" aria-controls="navbar-header" aria-expanded="false" aria-label="ナビゲーションの切替">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbar-header">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php" style="color: #ffffff;">ホーム <span class="sr-only"(現位置)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="calendar.php" tabindex="-1" style="color: #ffffff;">カレンダー</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle disabled" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">ドロップダウン</a>
                    <div class="dropdown-menu" aria-labelledby="dropdown01">
                        <a class="dropdown-item" href="#">リンク1</a>
                        <a class="dropdown-item" href="#">リンク2</a>
                        <a class="dropdown-item" href="#">リンク3</a>
                    </div>
                </li>
            </ul>
            <div>
                <a href="Inquiry.php" target="newtab" data-toggle="tooltip" title="問い合わせはこちらから"><!--問い合わせ画面へのリンク-->
                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-question-circle" stroke="white" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                        <path d="M5.255 5.786a.237.237 0 0 0 .241.247h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286zm1.557 5.763c0 .533.425.927 1.01.927.609 0 1.028-.394 1.028-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94z"/>
                    </svg>
                </a>
                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="以下に「タスク名」、「内容」、「期限日」を入力し、「登録」ボタンを押下してください。">
                            <button class="btn btn-link exbutton" style="pointer-events: none; color: #ffffff;" type="button" disabled>使用方法</button>
                        </span>
                <input type="submit" class="btn btn-link comptask" data-toggle="modal" data-target="#completedtask" name="completedtask" value="完了済みタスク" onclick="comptask()" style="color: #ffffff;">
                <input class="btn btn-link logout" type="button" name="logout" onclick="location.href='./login.php'"  value="ログアウト" style="color: #ffffff;">
            </div>
        </div>
    </nav>


    <!-- Bootstrap読み込み（スタイリングのため） -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link href="inquiry_style.css" rel="stylesheet">
</head>
<body>

    <div class="container">
        <form action="./Inquiry.php" method="post" class="form-inquiry">
            <div class="text-left mb-4">
                <h1>問い合わせ</h1>
            </div>
                <label for="inputUser">ログインユーザー名</label>
                <input type="text" id="inputUser" name="loginuser" class="form-control" required="" autofocus="" kl_vkbd_parsed="true">
                <br>

                <label for="inputEmail">ログインメールアドレス</label>
                <input type="email" id="inputEmail" name="loginmailadd" class="form-control" required="" autofocus="" kl_vkbd_parsed="true">
                <br>

                <label for="inputsummary">問い合わせ概要</label>
                <input type="text" id="inputsummary" name="inquirysummary" class="form-control" required="" autofocus="" kl_vkbd_parsed="true">
                <br>

                <label for="inputvalue">問い合わせ内容</label>
                <textarea class="form-control" id="inputvalue" name="inputvalue" rows="3" required="" autofocus="" kl_vkbd_parsed="true"></textarea>
                <!--<input type="textarea" id="inputvalue" class="form-control" required="" autofocus="" kl_vkbd_parsed="true">-->
                <br>

            <div class="form-group">
                <label class="col-sm-3"></label>
                <div class="col-sm-9">
                    <button  type="reset" class="btn btn-outline-secondary">リセット</button>
                    <button type="submit" class="btn btn-outline-success" name="inquirysubmit">送信する</button>

                </div>
            </div>
        </form>

    </div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js" integrity="sha384-1CmrxMRARb6aLqgBO7yyAxTOQE2AKb9GfXnEo760AUcUmFx3ibVJJAzGytlQcNXd" crossorigin="anonymous"></script>
</body>
</html>
