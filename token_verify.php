<?php
session_start();
require_once 'vendor/autoload.php';

// Get $id_token via HTTPS POST.

//$id_token = filter_input(INPUT_POST, 'id_token'); //Todo:これがnullになっている
$id_token = filter_input(INPUT_POST, 'id_token');
define('CLIENT_ID', '375099930470-tebhlghcqj0g78541lm6ge3gre656esr.apps.googleusercontent.com');

$client = new Google_Client(['client_id' => CLIENT_ID]);
$payload = $client->verifyIdToken($id_token);
if ($payload) {
    $userid = $payload['sub'];
    // If request specified a G Suite domain:
    //$domain = $payload['hd'];
} else {
    // Invalid ID token
}
//echo json_encode($payload, JSON_PRETTY_PRINT);
