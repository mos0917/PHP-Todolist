<?php

require_once 'functions.php';
include_once 'dbconnect.php';

$dbh = db_connect();

$compsql = 'SELECT id, name, memo, deadline_date FROM tasks WHERE done = 1 and delete_flg = 0 ORDER BY id DESC';
$stmt = $dbh->prepare($compsql);
$stmt->execute();
$comptask = $stmt->fetch(PDO::FETCH_ASSOC);


$getvalue = $comptask;
$comptask = ["get"=>$getvalue];
$compjsontask = json_encode($comptask, JSON_PRETTY_PRINT);
