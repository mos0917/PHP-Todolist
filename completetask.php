<?php
date_default_timezone_set('Asia/Tokyo');

require_once 'functions.php';
include_once 'dbconnect.php';
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
    echo'<div class="container">
            <div class="row">
                <div class="col-xs-12 col-lg-3">
                    ■タスク名:'.$comptask['name'].'
                </div>
                <br>
                <div class="col-xs-12 col-lg-3">
                    ■内容:'.$comptask['memo'].'
                </div>
                <br>
                <div class="col-xs-12 col-lg-3">
                    ■期限日:'.$comptask['deadline_date'].'
                </div>
            </div>
        </div>
        <HR>
    ';
}
?>


</body>
</html>