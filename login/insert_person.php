<?php
include "../includes/database.php";

$db=new Database();

$nickname=$_POST['nickname'];
$email=$_POST['email'];
$password=md5($_POST['password']);

$db->insert("personas","INSERT INTO personas(nickname_persona, email_persona,contrasena_persona) VALUES('$nickname', '$email', '$password')");

header("location: /login");

?>