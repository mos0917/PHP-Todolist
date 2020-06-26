<?php
date_default_timezone_set('Asia/Tokyo');

require_once 'functions.php';
include_once 'dbconnect.php';

$query = 'SELECT * FROM users WHERE user_id='.$_SESSION['user'].'';
$result = $mysqli->query($query);

// ユーザー情報の取り出し
while ($row = $result->fetch_assoc()) {
    $username = $row['username'];
    $email = $row['email']; //ユーザーidの取り出し
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
<?php

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