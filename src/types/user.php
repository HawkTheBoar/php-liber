<?php
include_once "../connect.php";
$pdo = $pdoConnect->pdo();
class User{
    static function GetUserFromSession(): User | null{
        if(isset($_SESSION['user'])){
            return $_SESSION['user'];
        }
        return null;
    }
    static function Login(string $username, string $password): User | null{
        $pdo // cannot be accessed here
        return null;
        
    }
}