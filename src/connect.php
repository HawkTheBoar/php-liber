<?php
// Database configuration
class pdoconnect{
    private static ?PDO $pdo = null;
    
    private static function connect(){
        $host = 'mysql-db';  // Or use 'localhost'
        $db   = 'dev_db';     // Name of your database
        $user = 'dev_user';   // Database username
        $pass = 'dev_password'; // Database password
        $charset = 'utf8mb4'; // Character set
        $dsn = "mysql:host=$host;port:3306;dbname=$db;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Enable exceptions for errors
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Fetch as associative array
            PDO::ATTR_EMULATE_PREPARES   => false,                  // Use native prepared statements
            PDO::ATTR_DRIVER_NAME        => 'mysql',                // Name of the driver
        ];
        try {
            // Create a new PDO instance
            self::$pdo = new PDO($dsn, $user, $pass, $options);
            // Explicitly select the database
            self::$pdo->exec("USE `$db`");
        } catch (PDOException $e) {
            // Handle connection error
            echo "Database connection failed: " . $e->getMessage();
        }

    }
    public static function getInstance(): PDO{
        if(self::$pdo === null)
            pdoconnect::connect();
        return pdoconnect::$pdo;
    }
}
?>
