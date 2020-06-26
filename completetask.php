<?php
date_default_timezone_set('Asia/Tokyo');



$compsql = 'SELECT id, name, memo, deadline_date FROM tasks WHERE done = 1 and delete_flg = 0 and email = "'.$compemail.'" ORDER BY id DESC';
$stmt = $dbh->prepare($compsql);
$stmt->execute();

    ■タスク名:$comptask['name'];
    ■内容:$comptask['memo'];
    ■期限日:$comptask['deadline_date'];
