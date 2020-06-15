<?php

require_once 'functions.php';

$errors = array();

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $memo = $_POST['memo'];

    $name = htmlspecialchars($name, ENT_QUOTES);
    $memo = htmlspecialchars($memo, ENT_QUOTES);

    if ($name === '') {
        $errors['name'] = 1;
    }

    if ($memo === '') {
        $errors['memo'] = 1;
    }

    /*    if ($errors['name'] == 1) {
            ?>
            <div class="alert alert-danger" role="alert" id="taskerr">タスク名を入力してください。</div>
    <?php
        }

        if ($errors['memo'] == 1) {
            ?>
            <div class="alert alert-danger" role="alert" id="valerr">内容を入力してください。</div>
    <?php
        }
    */
    if (count($errors) === 0) {
        $dbh = db_connect();

        $sql = 'INSERT INTO tasks (name, memo, done) VALUES (?, ?, 0)';
        $stmt = $dbh->prepare($sql);

        $stmt->bindValue(1, $name, PDO::PARAM_STR);
        $stmt->bindValue(2, $memo, PDO::PARAM_STR);
        $stmt->execute();

        $dbh = null;

        unset($name, $memo);
    }
}

if (isset($_POST['method']) && ($_POST['method'] === 'put')) {
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
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Todo List</title>
</head>
<body>
<div class="container">
<h1>Todo List</h1>
<input class="form-control" type="text" placeholder="以下にに「タスク名」、「内容」を入力し、「登録」ボタンを押下してください。" readonly>


<?php

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
    }

    // データベースの切断
    $result->close();
?>

  <span>■ログイン中のユーザー：<?php echo $username; ?> さん</span>


<form action="index.php" method="post" onsubmit="return errChk(errflg)">
    <div class="row">
        <div class="col-md-4">
            <ul>
                <li>
                    <span>タスク名</span>
                    <input type="text" class="form-control" id="taskname" name="name" value="<?php if (isset($name)) {
    echo $name;
} ?>">
                </li>
            </ul>
        </div>
        <div class="col-md-4">
            <ul>
                <li>
                    <span>内容　　</span>
                    <textarea class="form-control" id="taskvalue" rows="1" name="memo"><?php if (isset($memo)) {
    echo $memo;
} ?></textarea>
                </li>
            </ul>
        </div>
        <div>
            <input class="btn btn-outline-success" type="submit" name="submit" value="登録">
        </div>
    </div>
</form>

<form action="index.php" method="post" onsubmit="return logoutChk()">
    <input class="btn btn-outline-primary" type="button" name="logout" onclick="location.href='./logout.php?logout'"  value="ログアウト">
</form>
</div>



<script>
    /**
     * 確認ダイアログの返り値によりフォーム送信
    */
/**     function submitChk () {
/*        /* 確認ダイアログ表示 */
/*        var flag = confirm ( "登録してもよろしいですか？\n取り消す場合は[キャンセル]ボタンを押して下さい");
/*        /* send_flg が TRUEなら送信、FALSEなら送信しない */
/*        return flag;
/*    }
/*
/*    function logoutChk(){
/*       /*ログアウトボタン押下時ダイアログを表示*/
/*       var logoutflg = confirm("ログアウトしてもよろしいですか？\n取り消す場合は[キャンセル]ボタンを押してください");
/*        return logoutflg;
/*    } 
*/    

    function errChk(){ //タスク登録時のエラーチェック
        if(document.getElementById('taskname') === '' || document.getElementById('taskvalue') === ''){
            var errflg = alert("タスク名、またはまたは内容に不備があります。");
            return errflg;
        }
    }
</script>


<?php
$dbh = db_connect();

$sql = 'SELECT id, name, memo FROM tasks WHERE done = 0 ORDER BY id DESC';
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

    echo '<dd>';
    echo '
            <form action="index.php" method="post">
            <input type="hidden" name="method" value="put">
            <input type="hidden" name="id" value="'.$task['id'].'">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>

</body>
</html>

