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
    <script defer src="/__/firebase/5.3.1/firebase-app.js"></script>
    <script defer src="/__/firebase/5.3.1/firebase-auth.js"></script>
    <script src="https://www.gstatic.com/firebasejs/ui/4.6.1/firebase-ui-auth.js"></script>
    <link type="text/css" rel="stylesheet" href="https://cdn.firebase.com/libs/firebaseui/3.1.1/firebaseui.css" />
    <script defer src="/__/firebase/init.js"></script>
    <!--<script src="https://apis.google.com/js/platform.js" async defer></script>
    <meta name = "google-signin-client_id" content = "375099930470-tebhlghcqj0g78541lm6ge3gre656esr.apps.googleusercontent.com"> -->
    <!-- <meta name="viewport" content="width=width=device-width, initial-scale=1"> -->
    <title>Todo List Login</title>
    <!-- Bootstrap読み込み（スタイリングのため） -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link href="login_style.css" rel="stylesheet">
    <link rel="shortcut icon" href="../../core/img/fukurouimg_white.svg">
</head>

<body>
    <script src="https://www.gstatic.com/firebasejs/5.8.1/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/5.8.1/firebase-auth.js"></script>
    <script src="https://www.gstatic.com/firebasejs/ui/3.5.2/firebase-ui-auth__ja.js"></script>

    <div class="container">

        <form method="post" class="form-signin">
            <div class="text-center">
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
            <BR>
            <a href="register.php" class="m-4">会員登録はこちら</a>
            <BR>

            <div id="firebaseui-auth-container"></div>
            <div id="loader">Loading...</div>
            <script>
                // Initialize Firebase
                var firebaseConfig = {
                    apiKey: "AIzaSyCfr-SRsboT6mNPc8RBVZpTnDp64EbQzSA",
                    authDomain: "todo-list-e74b4.firebaseapp.com",
                    projectId: "todo-list-e74b4",
                    storageBucket: "todo-list-e74b4.appspot.com",
                    messagingSenderId: "102176473496",
                    appId: "1:102176473496:web:50a47c0b1e5397b93f6bed",
                    measurementId: "G-YZ31FBSYVB"
                };
                // Initialize Firebase
                firebase.initializeApp(firebaseConfig);
            </script>

            <script type="text/javascript">
                var ui = new firebaseui.auth.AuthUI(firebase.auth());

                var uiConfig = {
                    callbacks: {
                        signInSuccessWithAuthResult: function(authResult, redirectUrl) {
                            return true;
                        },
                        uiShown: function() {
                            document.getElementById('loader').style.display = 'none';
                        }
                    },
                    signInFlow: 'popup',
                    signInSuccessUrl: './index.php',
                    signInOptions: [
                        firebase.auth.GoogleAuthProvider.PROVIDER_ID,
                        firebase.auth.EmailAuthProvider.PROVIDER_ID,
                    ],
                };
                ui.start('#firebaseui-auth-container', uiConfig);
            </script>

        </form>

    </div>


<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>

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

    <script src="todoscript.js"></script>
</body>

</html>