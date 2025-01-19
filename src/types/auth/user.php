<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/connect.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/utils/helpers.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/utils/auth/gen_hash.php");
$config = loadJson($_SERVER['DOCUMENT_ROOT'] . "/admin/config.json");
class User{
    private static $pdo;
    private static $config;
    private string $username;
    private string $email;
    private string $role;
    private bool $isAuthenticated;
    
    function __construct($email){
        if(self::$pdo === null){
            self::$pdo = pdoconnect::getInstance();
        }
        
        $this->isAuthenticated = false;
        $this->username = 'unknown';
        $this->email = $email;
        $this->role = 'unauthenticated';
    }
    static function setConfig($config){
        self::$config = $config;
    }
    static function GetUserFromSession(): User | null{
        if(isset($_SESSION['user'])){
            return $_SESSION['user'];
        }
        return null;
    }
    static function Logout(){
        unset($_SESSION['user']);
    }
    
    function Login(){
        $_SESSION['user'] = $this;
    }
    function Authenticate(string $password): bool{
        if(self::$pdo === null){
            self::$pdo = pdoconnect::getInstance();
        }

        preg_match('/[a-zA-Z0-9_]+@[a-zA-Z0-9_]+\.[a-zA-Z0-9_]+/', $this->email, $matches);
        if(count($matches) === 0){
            throw new InvalidArgumentException('Invalid email format');
        }

        $usersTable = self::$config['users']['name'];
        $stmt = self::$pdo->prepare("SELECT * FROM $usersTable WHERE email = ?");
        $stmt->bindParam(1, $this->email);
        $stmt->execute();
        $res = $stmt->fetch();
        if($res === false){
            return false;
        }

        $result = password_verify($password, $res['password']);
        if($result){
            $this->isAuthenticated = true;
            $this->role = $res['role'];
            $this->username = $res['username'];
            return true;
        }
        return false;
    }
    public function getRole(): string{
        return $this->role;
    }
    public function getUsername(): string{
        return $this->username;
    }
    public function getEmail(): string{
        return $this->email;
    }
}
class UserFactory{
    private static $pdo;
    private static $config;
    public static function setConfig($config){
        self::$config = $config;
    }
    public static function CreateUser(string $username, string $email, string $password, $role = 'user'): User{
        $usersTable = self::$config['users']['name'];
        if(self::$pdo === null){
            self::$pdo = pdoconnect::getInstance();
        }
        $fields = self::$config['users']['fields'];
        $stmt = self::$pdo->prepare("INSERT INTO $usersTable (username, email, password, role) VALUES (?, ?, ?, ?)");
        $hash = gen_hash($password);
        $stmt->bindParam(1, $username);
        $stmt->bindParam(2, $email);
        $stmt->bindParam(3, $hash);
        $stmt->bindParam(4, $role);
        $stmt->execute();
        return new User($email);
    }
    public static function CreateAdmin(string $username, string $email, string $password): User{
        return self::CreateUser($username, $email, $password, 'admin');
    }
}

User::setConfig($config);
UserFactory::setConfig($config);