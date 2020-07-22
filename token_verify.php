<?php

session_start();
require_once 'vendor/autoload.php';
require_once 'functions.php';
include_once 'dbconnect.php';


$id_token = filter_input(INPUT_POST, 'idtoken');
define('CLIENT_ID', '375099930470-tebhlghcqj0g78541lm6ge3gre656esr.apps.googleusercontent.com');
$client = new Google_Client(['client_id' => CLIENT_ID]);

$payload = $client->verifyIdToken($id_token);
if ($payload) {
    $userid = $payload['sub'];
    var_dump($payload);
}
//Todo: DBでレスポンス値のemailがあるかチェックをしてなければgoogleinforegister.phpに
//Todo: データがあればindex.phpに遷移を指せる
$dbh = db_connect();

$sql = 'SELECT user_id,email from users WHERE email = "'.$payload[email].'"';
$stmt = $dbh->prepare($sql);
$stmt->execute();
$emailreresult = $stmt->fetchAll(PDO::FETCH_ASSOC|PDO::FETCH_UNIQUE);
$emailarr = array_values($emailreresult);


$emailvalue = ["get"=>$emailarr];
echo json_encode($emailvalue,JSON_PRETTY_PRINT);



/*
if ($emailreresult === $payload['email']) {
    $_SESSION['user'] = true;
} else {
    $_SESSION['login'] =true;
}
*/
exit;
