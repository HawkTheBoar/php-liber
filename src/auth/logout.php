<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/utils/helpers.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/types/auth/user.php";
$routes = loadJson($_SERVER['DOCUMENT_ROOT'] . "/routes.json");

start_session_if_not_started();
User::Logout();
header("Location: ". $routes["auth"]["login"]);