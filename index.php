<?php
date_default_timezone_set('Asia/Tokyo');

require_once 'functions.php';

$date = date('Y-m-d H:i:s'); //現在日付の取得

$errors = array();
$updateerrors = array();

session_start();
include_once 'dbconnect.php';
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
}

// ユーザーIDからユーザー名を取り出す
$query = 'SELECT * FROM users WHERE user_id='.$_SESSION['user'].'';
$result = $mysqli->query($query);

// ユーザー情報の取り出し
while ($row = $result->fetch_assoc()) {
    $username = $row['username'];
    $email = $row['email']; //ユーザーidの取り出し
}

// データベースの切断
$result->close();

if (isset($_POST['submit'])) { //登録ボタン押下時の処理
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
        $stmt->bindValue(4, $date, PDO::PARAM_STR);
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
        $stmt->bindValue('4', $date, PDO::PARAM_STR);
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
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<meta charset="utf-8">
<meta name="viewport" content="width=width=device-width, initial-scale=1">
<title>Todo List</title>
</head>
<body>


<div class="container">
    <div class="row">
        <div class="col-xs-7 col-lg-10">
            <h2>Todo List</h2>
        </div>
        <div class="col-xs-1 col-lg-1 col align-self-center">
            <form action="index.php" method="post" onsubmit="return logoutChk()">
                <input class="btn btn-outline-primary" type="button" name="logout" onclick="location.href='./logout.php?logout'"  value="ログアウト">
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-lg-12">
            <p><input class="form-control" type="text" placeholder="以下に「タスク名」、「内容」を入力し、「登録」ボタンを押下してください。" readonly></p>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-10 col-lg-10">
            <span>■ログイン中のユーザー:<?php echo $username; ?> さん</span>
        </div>
        <div class="col-xs-2 col-lg-2 col align-self-center">
            <input type="submit" class="btn btn-info" data-toggle="modal" data-target="#completedtask" name="completedtask" value="完了済みタスク" onclick="comptask()">
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
                        <input type="text" class="form-control" id="taskname" name="name" value="<?php if (isset($name)) {
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
                <input class="btn btn-outline-success" type="submit" name="submit" value="登録">
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
                <div class="col-lg-12">
                    <ul>
                        <li>
                            <span>タスク名:</span>
                            <span id="comptaskname">
                            </span>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-12">
                    <ul>
                        <li>
                            <span>内容:</span>
                            <span id="comptaskvalue">
                            </span>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-12">
                    <ul>
                        <li>
                            <span>期限:</span>
                            <span id="compdeadline_date">
                            </span>
                        </li> 
                    </ul>
                </div>
            </div>      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
        <button type="button" class="btn btn-primary">完了</button>
      </div>
    </div>
  </div>
</div>


<?php
$dbh = db_connect();

$sql = 'SELECT id, name, memo, deadline_date FROM tasks WHERE done = 0 and delete_flg = 0 and email = "'.$email.'" ORDER BY id DESC';
$stmt = $dbh->prepare($sql);
$stmt->execute();
$dbh = null;

echo '<dl>';

while ($task = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo'<div class="container">
            <div class="row">
                <div class="col-xs-12 col-lg-3">
                    ■タスク名:'.$task['name'].'
                </div>
                <br>
                <div class="col-xs-12 col-lg-3">
                    ■内容:'.$task['memo'].'
                </div>
                <br>
                <div class="col-xs-12 col-lg-3">
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
                                                        <input type="text" class="form-control" id="edittaskname" name="editname" value="'.$task['name'].'">
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
                                            <div class="col-lg-12">
                                                <ul>
                                                    <li>
                                                        <span>期限</span>
                                                        <br>
                                                        <input type="date" name="editdeadline_date" value="'.$task['deadline_date'].'">
                                                    </li> 
                                                </ul>
                                            </div>
                                            <HR>
                                            <div class="col-lg-8 text-right">
                                            <button class="btn btn-btn btn-secondary" type="button" id="resettaskmodal">閉じる</button>
                                            </div>
                                            <div class="col-lg-2 text-right">
                                                <button type="submit" class="btn btn-danger" name="delete" value="delete" >削除</button>
                                            </div>
                                            <div class="col-lg-2 text-right">

                                                <button type="submit" class="btn btn-primary" name="modify" value="modify">更新</button>
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
                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edittask'.$task['id'].'">編集</button>
                        <button type="show" class="btn btn-danger" >完了</button>
                    </form>
                </dd>
            </div>
        </div>
        <HR>
    ';
}

?>


<?php include dirname(__FILE__).'/footer.php'; ?>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>

<script src="todoscript.js"></script>
</body>
</html>
