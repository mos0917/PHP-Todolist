<?php
session_start();

require_once 'functions.php';
include_once 'dbconnect.php';

$dbh = db_connect();

$query = 'SELECT * FROM users WHERE user_id='.$_SESSION['user'].'';
$result = $mysqli->query($query);
// ユーザー情報の取り出し
while ($row = $result->fetch_assoc()) {
    $username = $row['username'];
    $email = $row['email']; //ユーザーidの取り出し
}


$compsql = 'SELECT id, name, memo, deadline_date FROM tasks WHERE done = 1 and delete_flg = 0 and email = "'.$email.'" ORDER BY id DESC';
$stmt = $dbh->prepare($compsql);
$stmt->execute();
$comptask = $stmt->fetchAll(PDO::FETCH_ASSOC);


$getvalue = $comptask;
$comptask = ["get"=>$getvalue];
//echo json_encode($comptask, JSON_PRETTY_PRINT);
echo json_encode($comptask, JSON_PRETTY_PRINT);
