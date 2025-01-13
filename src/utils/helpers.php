<?php
function getFromPostOrThrowError(string $name){
    if(!isset($_POST[$name]))
        throw new Error("$name is not provided in post");
    $postval = $_POST[$name];
    return $postval;
}