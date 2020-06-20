<?php
date_default_timezone_set('Asia/Tokyo');

require_once 'functions.php';

$date = date('Y-m-d H:i:s'); //現在日付の取得

$errors = array();

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

if (isset($_POST['method']) && ($_POST['method'] === 'put')) { //「完了」ボタン押下時に以下の処理を実行
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
<script src="todoscript.js"></script>

<div class="container">
    <div class="row">
        <div class="col-xs-6 col-lg-9">
            <h1>Todo List</h1>
        </div>
        <div class="col-xs-6 col-lg-3">
            <form action="index.php" method="post" onsubmit="return logoutChk()">
                    <input class="btn btn-outline-primary" type="button" name="logout" onclick="location.href='./logout.php?logout'"  value="ログアウト">
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <input class="form-control" type="text" placeholder="以下に「タスク名」、「内容」を入力し、「登録」ボタンを押下してください。" readonly>
        </div>
    </div>
    <span>■ログイン中のユーザー：<?php echo $username; ?> さん</span>


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
                        <span>内容　　</span>
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



<?php
$dbh = db_connect();

$sql = 'SELECT id, name, memo, deadline_date FROM tasks WHERE done = 0 and email = "'.$email.'" ORDER BY id DESC';
$stmt = $dbh->prepare($sql);
$stmt->execute();
$dbh = null;

echo '<dl>';

while ($task = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo '<HR>'; //罫線

    echo '<dt>';
    echo $task['name'];
    echo '</dt>';

    echo '<dd>';
    echo $task['memo'];
    echo '</dd>';

    echo $task['deadline_date'];
    //以下、編集モーダルを表示させる処理AND完了ボタン処理
    echo '<dd>';
    echo '
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
                            <div class="row">
                                <div class="col-xs-12 col-lg-6">
                                    <ul>
                                        <li>
                                            <span>タスク名</span>
                                            <input type="text" class="form-control" id="edittaskname" name="editname" value="'.$task['name'].'">
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-xs-12 col-lg-6">
                                    <ul>
                                        <li>
                                            <span>内容</span>
                                            <textarea class="form-control" id="edittaskvalue" rows="1" name="editmemo">'.$task['memo'].'</textarea>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
                            <button type="button" class="btn btn-primary">更新</button>
                        </div>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edittask'.$task['id'].'">編集</button>

            <form action="index.php" method="post">
            <input type="hidden" name="method" value="put">
            <input type="hidden" name="task_id" value="'.$task['id'].'">
            <button type="show" class="btn btn-danger" >完了</button>
            </form>
          ';
    echo '</dd>';
    echo '<HR>';
}

echo '</dl>';

?>


<?php include dirname(__FILE__).'/footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

</body>
</html>