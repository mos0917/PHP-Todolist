<?php
    $dbh = db_connect();

    $sql = 'SELECT id, name, memo, deadline_date FROM tasks WHERE done = 1 and delete_flg = 0 and email = "'.$email.'" ORDER BY id DESC';
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $dbh = null;
