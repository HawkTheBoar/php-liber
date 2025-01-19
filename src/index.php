<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'] . "/types/auth/user.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/components/navbar.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/components/head.php";

$user = User::GetUserFromSession();
Navbar::render_public();
?>
