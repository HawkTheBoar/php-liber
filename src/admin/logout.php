<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/utils/helpers.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/types/auth/user.php";
start_session_if_not_started();
User::Logout();
header("Location: /admin/login.php");