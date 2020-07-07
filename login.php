<?php
ob_start();
// ここから、register.phpと同様
session_start();
if (isset($_SESSION['user']) != '') {
    header('Location: index.php');
}
include_once 'dbconnect.php';
// ここまで、register.phpと同様
?>

<?php
if (isset($_POST['login'])) {
    $email = $mysqli->real_escape_string($_POST['email']);
    $password = $mysqli->real_escape_string($_POST['password']);
    // クエリの実行
    $query = "SELECT * FROM users WHERE email='$email'";
    $result = $mysqli->query($query);
    if (!$result) {
        echo 'クエリーが失敗しました。' . $mysqli->error;
        $mysqli->close();
        exit();
    }
    // パスワード(暗号化済み）とユーザーIDの取り出し
    while ($row = $result->fetch_assoc()) {
        $db_hashed_pwd = $row['password'];
        $user_id = $row['user_id'];
    }
    // データベースの切断
    $result->close();
    // ハッシュ化されたパスワードがマッチするかどうかを確認
    if (password_verify($password, $db_hashed_pwd)) {
        $_SESSION['user'] = $user_id;
        header('Location: index.php');
        exit;
    } else {
        ?>
        <script>
            alert("メールアドレスとパスワードが一致しません。");
        </script>
        <?php
    }
}
?>

<!DOCTYPE HTML>
<html lang="ja">

<head>
    <meta charset="utf-8" />
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <meta name = "google-signin-client_id" content = "375099930470-tebhlghcqj0g78541lm6ge3gre656esr.apps.googleusercontent.com">
   <!-- <meta name="viewport" content="width=width=device-width, initial-scale=1"> -->
    <title>Todo List Login</title>
    <link rel="stylesheet" href="style.css">
    <!-- Bootstrap読み込み（スタイリングのため） -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link href="login_style.css" rel="stylesheet">


</head>

<body>
    <div class="container">
    <div class="alert alert-primary" role="alert">googleログインボタンは未実装のため押下しないようにお願い致します。</div>
        <?php
        // signupがPOSTされたときに下記を実行
        if (isset($_POST['signup'])) {
            $username = $mysqli->real_escape_string($_POST['username']);
            $email = $mysqli->real_escape_string($_POST['email']);
            $password = $mysqli->real_escape_string($_POST['password']);
            $password = password_hash($password, PASSWORD_BCRYPT);
            // POSTされた情報をDBに格納する
            $query = "INSERT INTO users(username,email,password) VALUES('$username','$email','$password')";
            if ($mysqli->query($query)) {
                ?>
                <script>
                    alert("登録しました");
                </script>

                <?php
            } else {
                ?>
                <script>
                    alert("エラーが発生しました。");
                </script>
                <?php
            }
        } ?>

        <form method="post" class="form-signin">
            <div class="text-center mb-4">
                <img class="mb-4" src="../../core/img/fukurouimg.svg" alt="" width="72" height="72">
                <h1 class="h3 mb-3 font-weight-normal">Todo List ログイン</h1>
            </div>
            <div class="form-group">
                <input type="email" class="form-control" id="exampleInputEmail1" name="email" placeholder="メールアドレス" required autofocus />
                <label for="inputEmail">メールアドレス</label>
            </div>
            <div class="form-group">
                <input type="password" pattern="^([a-zA-Z0-9]{8,})$" class="form-control" id="exampleInputPassword1" name="password" placeholder="パスワード" required />
                <label for="inputEmail">パスワード</label>
            </div>
            <BR>
            <button type="submit" class="btn btn-lg btn-primary btn-block" name="login">ログインする</button>
            <div class="g-signin2" data-onsuccess="onSignIn"></div>
            <a href="#" onclick="signOut();">Sign out</a>
            <br>
            <a href="register.php">会員登録はこちら</a>
        </form>
    </div>
    <script>
        function onSignIn(googleUser) {
            var id_token = googleUser.getAuthResponse().id_token;
            
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'https://blooming-ocean-46381.herokuapp.com/token_verify.php');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                console.log('Signed in as: ' + xhr.responseText);
            };
            xhr.send('idtoken=' + id_token);
        }

        function signOut() {
            var auth2 = gapi.auth2.getAuthInstance();
            auth2.signOut().then(function () {
                console.log('User signed out.');
            });
        }
    </script>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script>
        window.jQuery || document.write('<script src="/docs/4.3/assets/js/vendor/jquery-slim.min.js"><\/script>')
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    <script src="/docs/4.3/assets/js/vendor/anchor.min.js"></script>
    <script src="/docs/4.3/assets/js/vendor/clipboard.min.js"></script>
    <script src="/docs/4.3/assets/js/vendor/bs-custom-file-input.min.js"></script>
    <script src="/docs/4.3/assets/js/src/application.js"></script>
    <script src="/docs/4.3/assets/js/src/search.js"></script>
    <script src="/docs/4.3/assets/js/src/ie-emulation-modes-warning.js"></script>
</body>

</html>