<?php

require_once("functions.php");

$errors = array();

if(isset($_POST['submit'])){
    
    $name = $_POST['name'];
    $memo = $_POST['memo'];
 
    $name = htmlspecialchars($name, ENT_QUOTES);
    $memo = htmlspecialchars($memo, ENT_QUOTES);

    if($name === ''){
        $errors['name'] = 'タスク名が入力されていません。';
    }

    if($memo === ''){
        $errors['memo'] = 'メモが入力されていません。';
    }
    
    if(count($errors) === 0){
        
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


if(isset($_POST['method']) && ($_POST['method'] === 'put')){
    
    
    $id = $_POST["id"];
    $id = htmlspecialchars($id, ENT_QUOTES);
    $id = (int)$id;

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
<title>Todoリスト</title>
</head>
<body>
<h1>Todoリスト</h1>
<h3>下の「タスク名」、「タスク内容」を入力してください。</h3>

<?php

    session_start();
    include_once 'dbconnect.php';
    if(!isset($_SESSION['user'])) {
        header("Location: login.php");
    }

    // ユーザーIDからユーザー名を取り出す
    $query = "SELECT * FROM users WHERE user_id=".$_SESSION['user']."";
    $result = $mysqli->query($query);

    // ユーザー情報の取り出し
    while ($row = $result->fetch_assoc()) {
            $username = $row['username'];
    }

    // データベースの切断
    $result->close();
?>

<ul>
  <li>ログイン中のユーザー：<?php echo $username; ?> さん</li>
</ul>



<?php
if(isset($errors)){
    print("<ul>");
    foreach($errors as $value){
        print("<li>");
        print($value);
        print("</li>");
    }
    print("</ul>");
}
?>
<form action="index.php" method="post" onsubmit="return submitChk()">
<ul>
    <li><span>タスク名</span><input type="text" name="name" value="<?php if(isset($name)){print($name);} ?>"></li>
    <li><span>メモ　　</span><textarea name="memo"><?php if(isset($memo)){print($memo);} ?></textarea></li>
    
</ul>
</form>

<li><input class="btn btn-primary" type="submit" name="submit" value="登録"></li>

<input class="btn btn-primary" type="button" name="logout" onclick="location.href='./logout.php?logout'" value="ログアウト">

<script>
    /**
     * 確認ダイアログの返り値によりフォーム送信
    */
    function submitChk () {
        /* 確認ダイアログ表示 */
        var flag = confirm ( "送信してもよろしいですか？\n取り消す場合は[キャンセル]ボタンを押して下さい");
        /* send_flg が TRUEなら送信、FALSEなら送信しない */
        return flag;
    }

    function logoutChk(){
        /*ログアウトボタン押下時ダイアログを表示*/
        var logoutflg = confirm("ログアウトしてもよろしいですか？\n取り消す場合は[キャンセル]ボタンを押してください");
        return logoutflg;
        }
</script>


<?php
$dbh = db_connect();

$sql = 'SELECT id, name, memo FROM tasks WHERE done = 0 ORDER BY id DESC';
$stmt = $dbh->prepare($sql);
$stmt->execute();
$dbh = null;

print('<dl>');

while($task = $stmt->fetch(PDO::FETCH_ASSOC)){
    
    print '<dt>';
    print $task["name"];
    print '</dt>';

    print '<dd>';
    print $task["memo"];
    print '</dd>';

    print '<dd>';
    print '
            <form action="index.php" method="post">
            <input type="hidden" name="method" value="put">
            <input type="hidden" name="id" value="' . $task['id'] . '">
            <button type="submit">完了</button>
            </form>
          ' ;
    print '</dd>';

}

print('</dl>');

?>


<?PHP include(dirname(__FILE__).'/footer.php'); ?>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>

</body>
</html>

