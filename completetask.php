<?php
date_default_timezone_set('Asia/Tokyo');

require_once 'functions.php';
include_once 'dbconnect.php';


    $dbh = db_connect();

    $compsql = 'SELECT id, name, memo, deadline_date FROM tasks WHERE done = 1 and delete_flg = 0 and email = "'.$email.'" ORDER BY id DESC';
    $stmt = $dbh->prepare($compsql);
    $stmt->execute();
    $dbh = null;
