<?php
date_default_timezone_set('Asia/Tokyo');

session_start();
require_once 'functions.php';
include_once 'dbconnect.php';

$nowdate = date('Y-m-d H:i:s'); //現在日付の取得

/*if (!isset($_SESSION['user'])) {
    header('Location: login.php');
}*/

// ユーザーIDからユーザー名を取り出す
$query = "SELECT * FROM users WHERE user_id={$_SESSION['user']}";
$result = $mysqli->query($query);

// ユーザー情報の取り出し
while ($row = $result->fetch_assoc()) {
    $username = $row['username'];
    $email = $row['email']; //ユーザーidの取り出し
}

// データベースの切断
$result->close();

if (isset($_POST['submit'])) { //登録ボタン押下時の処理
    $errors = array();
    $name = $_POST['name'];
    $memo = $_POST['memo'];
    $deaddate = $_POST['deadline_date'];

    if ($_POST['deadline_date'] === '') { //期限日がnullの場合NULLを入れる(0000-00-00回避)
        $deaddate = null;
    } else {
        $deaddate = $_POST['deadline_date'];
    }

    $name = htmlspecialchars($name, ENT_QUOTES);
    $memo = htmlspecialchars($memo, ENT_QUOTES);

    if ($name === '') {
        $errors['name'] = 1;
    }

    if ($memo === '') {
        $errors['memo'] = 1;
    }

    if (count($errors) === 0) {
        $dbh = db_connect();

        $sql = 'INSERT INTO tasks (email,name, memo, create_date, deadline_date, done) VALUES (? ,?, ?, ?, ?, 0)';
        $stmt = $dbh->prepare($sql);

        $stmt->bindvalue(1, $email, PDO::PARAM_STR);
        $stmt->bindValue(2, $name, PDO::PARAM_STR);
        $stmt->bindValue(3, $memo, PDO::PARAM_STR);
        $stmt->bindValue(4, $nowdate, PDO::PARAM_STR);
        $stmt->bindValue(5, $deaddate, PDO::PARAM_STR);

        $stmt->execute();

        $dbh = null;

        unset($name, $memo);
    }
}

if (isset($_POST['method']) && ($_POST['method'] === 'put')) { //完了ボタン押下時の処理
    $id = $_POST['id'];
    $id = htmlspecialchars($id, ENT_QUOTES);
    $id = (int) $id;

    $dbh = db_connect();

    $sql = 'UPDATE tasks SET done = 1  WHERE id = ?';
    $stmt = $dbh->prepare($sql);

    $stmt->bindValue(1, $id, PDO::PARAM_INT);
    $stmt->execute();

    $dbh = null;
}

if (isset($_POST['modify'])) { //更新ボタン押下時の処理
    $updateerrors = array();
    $editid = $_POST['editdelid'];
    $editname = $_POST['editname'];
    $editmemo = $_POST['editmemo'];
    $editdeaddate = $_POST['editdeadline_date'];

    if ($_POST['editdeadline_date'] === '') { //期限日がnullの場合NULLを入れる(0000-00-00回避)
        $editdeaddate = null;
    } else {
        $editdeaddate = $_POST['editdeadline_date'];
    }

    $editname = htmlspecialchars($editname, ENT_QUOTES);
    $editmemo = htmlspecialchars($editmemo, ENT_QUOTES);

    if ($editname === '') {
        $updateerrors['editname'] = 1;
    }

    if ($editmemo === '') {
        $updateerrors['editmemo'] = 1;
    }

    if (count($updateerrors) === 0) {
        $dbh = db_connect();

        $sql = 'UPDATE tasks SET name = ?, memo = ?, deadline_date = ?, update_date = ? WHERE id = ?';
        $stmt = $dbh->prepare($sql);

        $stmt->bindValue('1', $editname, PDO::PARAM_STR);
        $stmt->bindValue('2', $editmemo, PDO::PARAM_STR);
        $stmt->bindValue('3', $editdeaddate, PDO::PARAM_STR);
        $stmt->bindValue('4', $nowdate, PDO::PARAM_STR);
        $stmt->bindValue('5', $editid, PDO::PARAM_INT);

        $stmt->execute();

        $dbh = null;

        unset($editname, $editmemo);
    }
}

if (isset($_POST['delete'])) { //削除ボタン押下時の処理追加
    $delid = $_POST['editdelid'];

    $dbh = db_connect();

    $sql = 'UPDATE tasks SET delete_flg = 1 WHERE id = ?';
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(1, $delid, PDO::PARAM_INT);
    $stmt->execute();

    $dbh = null;
}

?>
<!doctype html>
<html>
<head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<meta charset="utf-8">
<meta name="viewport" content="width=width=device-width, initial-scale=1">
<meta name = "google-signin-client_id" content = "375099930470-tebhlghcqj0g78541lm6ge3gre656esr.apps.googleusercontent.com">
<link href="index_style.css" rel="stylesheet">
<link rel="shortcut icon" href="../../core/img/fukurouimg_white.svg">
<title>Todo List</title>
</head>

<body class="d-flex flex-column h-100">
    <script src="https://www.gstatic.com/firebasejs/5.8.1/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/5.8.1/firebase-auth.js"></script>
    <script src="config.js"></script>

    <header>
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
                        <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">カレンダー</a>
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
                    <input class="btn btn-link logout" type="button" name="logout" onclick="signOut(),location.href='./logout.php?logout'"  value="ログアウト" style="color: #ffffff;">

                    <script>
                        function signOut() {
                            var auth2 = gapi.auth2.getAuthInstance();
                            auth2.signOut().then(function () {
                                console.log('User signed out.');
                            });
                        }

                        function onLoad() {
                            gapi.load('auth2', function() {
                                gapi.auth2.init();
                            });
                        }
                    </script>
                </div>
            </div>
        </nav>
    </header>

    <main role="main" class="flex-shrink-0">
        <div class="container">
            <div class="row">
                <div class="col-xs-10 col-lg-10">
                    <span>■ログイン中のユーザー:<?php echo $username; ?> さん</span>
                </div>

                <div class="col-xs-5 col-lg-5">
                    <span>今日は<?php echo date('Y年m月d日'); ?>です</span>
                </div>
                <br>
            </div>

            <form action="index.php" method="post" onsubmit="return errChk();">
                <div class="row">
                    <div class="col-xs-12 col-lg-3">
                        <ul>
                            <li>
                                <span>タスク名</span>
                                <input type="text" maxlength="25" class="form-control" id="taskname" name="name" value="<?php if (isset($name)) {
                                    echo $name;
                                                                                                         } ?>">
                            </li>
                        </ul>
                    </div>
                    <div class="col-xs-12 col-lg-3">
                        <ul>
                            <li>
                                <span>内容    </span>
                                <textarea class="form-control" id="taskvalue" rows="1" name="memo"><?php if (isset($memo)) {
                                    echo $memo;
                                                                                                   } ?> </textarea>
                            </li>
                        </ul>
                    </div>
                    <div class="col-xs-12 col-lg-3">
                        <ul>
                            <li>
                                <span>期限</span>
                                <br>
                                <input type="date" name="deadline_date">
                            </li>
                        </ul>
                    </div>
                    <div class="col align-self-center">
                        <input class="btn btn-success" type="submit" name="submit" value="登録">
                    </div>
                </div>
            </form>
        </div>
        <BR>
        <HR>

        <div class="modal fade" id="completedtask" tabindex="-1" role="dialog" aria-labelledby="completedtask" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">完了済みタスク</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="modalbody">
                            <div class="row">
                                <?php
                                for ($count = 0; $count < 20; $count++) {
                                    echo '<div class="col-lg-12">
                                              <input type="hidden" name="undotaskid" id="comptaskid'.$count.'" class="completetaskid">
                                              <ul>
                                                  <li>
                                                      <span>タスク名:</span>
                                                      <span id="comptaskname'.$count.'" class="completetaskname">
                                                      </span>
                                                  </li>
                                              </ul>
                                          </div>
                                          <div class="col-lg-12">
                                              <ul>
                                                  <li>
                                                      <span>内容:</span>
                                                      <span id="comptaskvalue'.$count.'" class="completetaskvalue">
                                                      </span>
                                                  </li>
                                              </ul>
                                          </div>
                                          <div class="col-lg-12">
                                              <ul>
                                                  <li>
                                                      <span>期限:</span>
                                                      <span id="compdeadline_date'.$count.'" class="completetaskdeadline_date">
                                                      </span>
                                                  </li> 
                                              </ul>
                                          </div>
                                            <div class="col-lg-12 border-bottom"></div>
                                    ';
                                }?>
                            </div>
                        </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
                    </div>
                </div>
            </div>
        </div>

        <?php
        //登録下タスクの表示
        $dbh = db_connect();

        $sql = 'SELECT id, name, memo, deadline_date FROM tasks WHERE done = 0 and delete_flg = 0 and email = "'.$email.'" ORDER BY id DESC';
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
        $dbh = null;

        while ($task = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo'<div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-lg-3 displaytaskname">
                            ■タスク名:'.$task['name'].'
                        </div>
                        <br>
                        <div class="col-xs-12 col-lg-3 displaytaskvalue">
                            ■内容:'.$task['memo'].'
                        </div>
                        <br>
                        <div class="col-xs-12 col-lg-3 displaytaskdeadlinedate">
                            ■期限日:'.$task['deadline_date'].'
                        </div>
                        <dd>
                        <div class="modal fade" id="edittask'.$task['id'].'" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="label1">Todo編集画面</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="index.php" method="post" name="edittaskform">
                                            <input type="hidden" name="editdelid" value="'.$task['id'].'">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <ul>
                                                        <li>
                                                            <span>タスク名</span>
                                                            <input type="text" class="form-control" id="edittaskname" name="editname" maxlength="25" value="'.$task['name'].'">
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="col-lg-12">
                                                <ul>
                                                        <li>
                                                            <span>内容</span>
                                                            <textarea class="form-control" id="edittaskvalue" rows="1" name="editmemo">'.$task['memo'].'</textarea>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="col-lg-12 border-bottom">
                                                    <ul>
                                                        <li>
                                                            <span>期限</span>
                                                            <br>
                                                            <input type="date" name="editdeadline_date" value="'.$task['deadline_date'].'">
                                                        </li> 
                                                    </ul>
                                                </div>
                                                <div class="col-lg-8 align-self-center text-right">
                                                    <button type="submit" class="btn btn-outline-danger" name="delete" value="delete" >削除</button>
                                                </div>
                                                <div class="col-lg-2 align-self-center text-right">
                                                    <button type="button" class="btn btn-outline-secondary" id="resettaskmodal" data-dismiss="modal">閉じる</button>
                                                </div>
                                                <div class="col-lg-2 align-self-center text-right">
                                                    <button type="submit" class="btn btn-info" name="modify" value="modify">更新</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
    
                            <form action="index.php" method="post">
                                <input type="hidden" name="method" value="put">
                                <input type="hidden" name="id" value="'.$task['id'].'">
                                <button type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#edittask'.$task['id'].'">編集</button>
                                <button type="show" class="btn btn-outline-info" >完了</button>
                            </form>
                        </dd>
                    </div>
                </div>
                <HR>
            ';
        }

        ?>
    </main>

    <footer class="footer mt-auto py-3 bg-center">
        <div class="container px-3">
            <span class="text-muted">Copyright &copy; 2019-2020 Mos9 at fukurou All Rights Reserved.</span>
        </div>
    </footer>

    <script src="https://apis.google.com/js/platform.js?onload=onLoad" async defer></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js" integrity="sha384-1CmrxMRARb6aLqgBO7yyAxTOQE2AKb9GfXnEo760AUcUmFx3ibVJJAzGytlQcNXd" crossorigin="anonymous"></script>

    <script src="todoscript.js"></script>
</body>
</html>
