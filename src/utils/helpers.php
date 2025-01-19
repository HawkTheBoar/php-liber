<?php
/**
 * @param string $why - The reason why the authentication failed
 * Redirects to the login page with the error message
 */
function auth_failed($why){
    $routes = loadJson($_SERVER['DOCUMENT_ROOT'] . "/routes.json");
    str_replace(" ", "+", $why);
    header("Location: " . $routes['auth']['login'] ."?error=$why");
    exit();
}
function redirectWithMessage(string $path, string $message){
    $path = $path . "?message=" . str_replace(" ", "+", $message);
    header("Location: $path");
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