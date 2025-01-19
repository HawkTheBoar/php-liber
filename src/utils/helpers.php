<?php
function auth_failed($why){
    str_replace(" ", "+", $why);
    header("Location: /admin/login.php?error=$why");
    exit();
}
function getFromPostOrThrowError(string $name){
    if(!isset($_POST[$name]))
        throw new Error("$name is not provided in post");
    $postval = $_POST[$name];
    return $postval;
}
function loadJson(string $path){
    $config = file_get_contents($path);
    $config = json_decode($config, true);
    return $config;
}
function start_session_if_not_started(){
    if(session_status() === PHP_SESSION_NONE){
        session_start();
    }
}