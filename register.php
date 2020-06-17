<?php
session_start();
if (isset($_SESSION['user']) != '') {
    // ログイン済みの場合はリダイレクト
    header('Location: login.php');
}
// DBとの接続
include_once 'dbconnect.php';
?>
<!DOCTYPE HTML>
<html lang="ja">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Todo List Member registration</title>
<link rel="stylesheet" href="style.css">

<!-- Bootstrap読み込み（スタイリングのため） -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
</head>
<body>
<div class="col-xs-6 col-xs-offset-3">



<form action="login.php" method="post">
	<h1>会員登録</h1>
	<div class="row">
		<div class="col-md-12">
			<input type="text" class="form-control" name="username" placeholder="ユーザー名" required />
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-md-12">
			<input type="email"  class="form-control" name="email" placeholder="メールアドレス" required />
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-md-12">
			<input type="password" class="form-control" name="password" placeholder="パスワード" required />
			<small id="passwordHelpBlock" class="form-text text-muted">
  				8-20文字で入力してください。大文字、小文字、数字を組み合わせて入力してください。
			</small>
		</div>
	</div>
	<br>
	
	<button type="submit" class="btn btn-success" name="signup">会員登録する</button>
	<a href="login.php">ログイン画面に戻る</a>
</form>

</div>
</body>
</html>
