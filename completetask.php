<?php
date_default_timezone_set('Asia/Tokyo');

require_once 'functions.php';
include_once 'dbconnect.php';

$compquery = 'SELECT * FROM users WHERE user_id='.$_SESSION['user'].'';
$compresult = $mysqli->query($compquery);


// ユーザー情報の取り出し
while ($comprow = $compresult->fetch_assoc()) {
    $compemail = $comprow['email']; //ユーザーidの取り出し
}

$dbh = db_connect();

$compsql = 'SELECT id, name, memo, deadline_date FROM tasks WHERE done = 1 and delete_flg = 0 and email = "'.$email.'" ORDER BY id DESC';
$stmt = $dbh->prepare($compsql);
$stmt->execute();
$dbh = null;

while ($comptask = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo'■タスク名:'.$comptask['name'].'
         ■内容:'.$comptask['memo'].'
         ■期限日:'.$comptask['deadline_date'].'
        <HR>
    ';
}
?>


</body>
</html>