<?php
session_start();

require_once 'vendor/autoload.php';

$id_token = filter_input(INPUT_POST, 'id_token');
define('CLIENT_ID', '375099930470-tebhlghcqj0g78541lm6ge3gre656esr.apps.googleusercontent.com');

$client = new Google_Client(['client_id' => CLIENT_ID]);
$payload = $client->verifyIdToken($id_token);
if ($payload) {
    $userid = $payload['sub'];
}
