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
//$_SESSION['login'] = true;
//exit;

$dbh = db_connect();

$sql = 'SELECT email from users';
$stmt = $dbh->prepare($sql);
$stmt->execute();
$dbh = null;
$emailreresult = $stmt->fetch(PDO::FETCH_ASSOC);


if ($emailreresult === $payload['email']) {
    $_SESSION['user'] = true;
    header('location: index.php');
} else {
    $_SESSION['login'] =true;
    header('location: googleinforegister.php');
}

var_dump($_SESSION);
exit;
