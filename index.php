<?php

require_once("functions.php");

$errors = array();

if(isset($_POST['submit'])){
    
    $name = $_POST['name'];
    $memo = $_POST['memo'];

    $name = htmlspecialchars($name, ENT_QUOTES);
    $memo = htmlspecialchars($memo, ENT_QUOTES);

    if($name === ''){
        $errors['name'] = 'お名前が入力されていません。';
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
<meta charset="utf-8">
<title>Todoリスト</title>
</head>
<body>

<!-- 共通部分(ヘッダー) -->
<?php include(dirname(__FILE__).'/header.php'); ?>
<!--共通部分おわり-->



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
    <li><span>メモ</span><textarea name="memo"><?php if(isset($memo)){print($memo);} ?></textarea></li>
    <li><input type="submit" name="submit"></li>
</ul>
</form>

<script>
    /**
     * 確認ダイアログの返り値によりフォーム送信
    */
    function submitChk () {
        /* 確認ダイアログ表示 */
        var flag = confirm ( "送信してもよろしいですか？\n送信したくない場合は[キャンセル]ボタンを押して下さい");
        /* send_flg が TRUEなら送信、FALSEなら送信しない */
        return flag;
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
</body>
</html>