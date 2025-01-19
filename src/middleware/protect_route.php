<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/utils/helpers.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/types/auth/user.php";

start_session_if_not_started();
$user = User::GetUserFromSession();

if($user === null){
    auth_failed('You must be logged in to access this page.');
}
if($user->getRole() !== 'admin'){
    auth_failed('Unauthorized access.');
}