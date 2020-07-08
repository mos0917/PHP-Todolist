<?php
session_start();
require_once 'vendor/autoload.php';

$client = new Google_Client(['client_id' => $CLIENT_ID]);  // Specify the CLIENT_ID of the app that accesses the backend
$payload = $client->verifyIdToken($id_token);
if ($payload) {
    $userid = $payload['sub'];
    // If request specified a G Suite domain:
    //$domain = $payload['hd'];
} else {
    // Invalid ID token
}

echo json_encode('client:', $client);
echo json_encode('token:', $id_token);
echo json_encode('userid:', $userid);
