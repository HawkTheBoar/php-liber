<?php
function getFromPostOrThrowError($name){
    if(!$_POST[$name])
        throw new Error("$name is not provided in post");
    $postval = $_POST[$name];
    return $postval;
}