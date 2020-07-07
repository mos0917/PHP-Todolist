<?php

require_once 'vendor/autoload.php';

$id_token = filter_input(INPUT_POST, 'id_token');
define('CLIENT_ID', 'XXXXXX.apps.googleusercontent.com');

$client = new Google_Client(['client_id' => CLIENT_ID]);
$payload = $client->verifyIdToken($id_token);
if ($payload) {
    $userid = $payload['sub'];
}
echo json_encode($$payload, JSON_PRETTY_PRINT);
