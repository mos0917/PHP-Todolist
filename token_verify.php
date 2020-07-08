<?php

use GuzzleHttp\Psr7\Response;

session_start();
require_once 'vendor/autoload.php';

$id_token = filter_input(INPUT_POST, 'id_token');

var_dump($id_token);//id_tokenが表示されるか確認

define('CLIENT_ID', '375099930470-tebhlghcqj0g78541lm6ge3gre656esr.apps.googleusercontent.com');

$client = new Google_Client(['client_id' => CLIENT_ID]);
var_dump($client);

$payload = $client->verifyIdToken($id_token);
var_dump($payload);
if ($payload) {
    $userid = $payload['sub'];
}
