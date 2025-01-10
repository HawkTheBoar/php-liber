<?php
// Database configuration
class pdoconnect{
    private string $host = 'mysql-db';  // Or use 'localhost'
    private string $db   = 'dev_db';     // Name of your database
    private string $user = 'dev_user';   // Database username
    private string $pass = 'dev_password'; // Database password
    private string $charset = 'utf8mb4'; // Character set
    private static PDO $pdo;
    
    function __construct(){
        
    }
    private function connect(){
        $dsn = "mysql:host=$this->host;port:3306;dbname=$this->db;charset=$this->charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Enable exceptions for errors
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Fetch as associative array
            PDO::ATTR_EMULATE_PREPARES   => false,                  // Use native prepared statements
            PDO::ATTR_DRIVER_NAME        => 'mysql',                // Name of the driver
        ];
        try {
            // Create a new PDO instance
            $this->pdo = new PDO($dsn, $this->user, $this->pass, $options);
            echo "Connection successful!";
        } catch (PDOException $e) {
            // Handle connection error
            echo "Database connection failed: " . $e->getMessage();
        }

    }
    public function getInstance(): PDO{
        if(!$this->pdo)
            $this->connect();
        return $this->pdo;
    }
}

$pdoConnect = new pdoconnect();
?>
