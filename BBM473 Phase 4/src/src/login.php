<?php

include("DB.php");
ob_start();
session_start();

$username = $_POST['username'];
$password = $_POST['password'];

$db = new DB();

$hash_password = sha1($password);
echo $db->login($username, $hash_password);

ob_end_flush();
