<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/utils/helpers.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/types/auth/user.php";

start_session_if_not_started();
$user = User::GetUserFromSession();
if($user === null){
    header("Location: /admin/login.php");
    exit();
}
if($user->getRole() !== 'admin'){
    header("Location: /admin/login.php");
    exit();
}