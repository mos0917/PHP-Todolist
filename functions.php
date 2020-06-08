<?php

function db_connect() {
    
    $dsn = 'mysql:dbname=heroku_9e11dccd84aee89;host=us-cdbr-east-05.cleardb.net;charset=utf8';
    $user = 'b258db074787a9';
    $password = 'e25dfa8f';

    $dbh = new PDO($dsn, $user, $password);

    $dbh->query('SET NAMES utf8');
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    
    return $dbh;
    
}
