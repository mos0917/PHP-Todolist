<?php

session_start();
require_once 'vendor/autoload.php';
require_once 'functions.php';
include_once 'dbconnect.php';

//Todo: DBでレスポンス値のemailがあるかチェックをしてなければgoogleinforegister.phpに
//Todo: データがあればindex.phpに遷移を指せる
$id_token = filter_input(INPUT_POST, 'idtoken');
define('CLIENT_ID', '375099930470-tebhlghcqj0g78541lm6ge3gre656esr.apps.googleusercontent.com');
$client = new Google_Client(['client_id' => CLIENT_ID]);

$payload = $client->verifyIdToken($id_token);


$dbh = db_connect();

$sql = 'SELECT email from users WHERE email = "'.$payload[email].'"';
$stmt = $dbh->prepare($sql);
$stmt->execute();
$emailreresult = $stmt->fetch(PDO::FETCH_COLUMN);


if($payload['email'] == $emailreresult){
    $loginflg = true;
    $_SESSION['users'] = $emailreresult;
}else{
    $loginflg = false;
}

echo json_encode($loginflg,JSON_PRETTY_PRINT);
exit;
?>

<script type="text/javascript">var loginflg = JSON.parse('<?php $loginflg ?>');</script>
<script type="text/javascript" src="todoscript.js"></script>
