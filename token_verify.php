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

$sql = 'SELECT user_id,email from users WHERE email = "'.$payload[email].'"';
$sqlresult = $mysqli->query($sql);

while ($row = $sqlresult->fetch_assoc()) {
    $userid = $row['user_id'];
    $email = $row['email'];
}

if($payload['email'] == $email){
    $loginflg = true;
    $_SESSION['user'] = $userid;
}else{
    $loginflg = false;
}

echo json_encode($loginflg,JSON_PRETTY_PRINT);
exit;
?>

<script type="text/javascript">var loginflg = JSON.parse('<?php $loginflg ?>');</script>
<script type="text/javascript" src="todoscript.js"></script>
