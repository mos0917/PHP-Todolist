<?php
session_start();

include_once 'dbconnect.php';
include_once 'token_verify.php';


// gsignupがPOSTされたときに下記を実行(googleでログインボタンを押下してログインしたとき専用)
if (isset($_POST['gsignup'])) {
    $username = $mysqli->real_escape_string($_POST['username']);
    $email = $mysqli->real_escape_string($_POST['email']);
    $password = $mysqli->real_escape_string($_POST['password']);
    $password = password_hash($password, PASSWORD_BCRYPT);
    // POSTされた情報をDBに格納する
    $query = "INSERT INTO users(username,email,password,google_flg) VALUES('$username','$email','$password',1)";
    if ($mysqli->query($query)) {
        header('location: index.php');
        $_SESSION['user'] = 'true';
        exit();
    } else {
        ?>
    <script>
        alert("登録したメールアドレスは既に登録されています。再度登録をお願い致します。");
        exit();
    </script>
<?php
    }
}
?>

<!DOCTYPE HTML>
<html lang="ja">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=width=device-width, initial-scale=1.0">
<title>Todo List Member registration</title>

<!-- Bootstrap読み込み（スタイリングのため） -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
<link href="googleregister_style.css" rel="stylesheet">
<link rel="shortcut icon" href="../../core/img/fukurouimg_white.svg">
</head>
<body>
<div class="container">


<form method="post" class="form-Gsignup">
    <div class="text-left mb-4">
        <h1>会員登録(Googleユーザー)</h1>
    </div>
    <div class="form-group">
            <input type="text" class="form-control" name="username" placeholder="ユーザー名" value="'.$userid.'" required />
            <label for="inputEmail">ユーザー名</label>
    </div>
    <div class="form-group">
        <input type="email"  class="form-control" name="email" placeholder="メールアドレス" value="'.$email.'" required />
        <label for="inputEmail">メールアドレス</label>
    </div>
    <div class="form-group">
        <input type="password" pattern="^([a-zA-Z0-9]{8,})$" class="form-control" name="password" placeholder="パスワード" required />
        <label for="inputEmail">パスワード</label>
        <small id="passwordHelpBlock" class="form-text text-muted">
            8-20文字で入力してください。大文字、小文字、数字を組み合わせて入力してください。
        </small>
    </div>
    <br>

    <button type="submit" class="btn btn-lg btn-success btn-block" name="gsignup">登録する</button>
    <br>

</form>

</div>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js" integrity="sha384-1CmrxMRARb6aLqgBO7yyAxTOQE2AKb9GfXnEo760AUcUmFx3ibVJJAzGytlQcNXd" crossorigin="anonymous"></script>

<script src="todoscript.js"></script>
</body>
</html>
