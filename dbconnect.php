<?php
//データベースの接続と選択
require_once('./core/config.php');
$mysqli = new mysqli($host, $username, $password, $dbname);
if ($mysqli->connect_error) {
	error_log($mysqli->connect_error);
	exit;
}
