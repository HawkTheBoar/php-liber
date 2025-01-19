<?php
function gen_hash($password){
    return password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]);
}