<?php
class Database
{
    private static $host;
    private static $db_name;
    private static $username;
    private static $password;
    private static $charset  = 'utf8mb4';
    private static $conn     = null;

    // Singleton pattern - only one connection is created and reused
    public static function getConnection()
    {
        if (self::$conn === null) {
            // Credentials live in config/db_credentials.php (not committed to Git)
            $cred = require __DIR__ . '/db_credentials.php';
            self::$host     = $cred['host'];
            self::$db_name  = $cred['db_name'];
            self::$username = $cred['username'];
            self::$password = $cred['password'];

            try {
                $dsn = "mysql:host=" . self::$host .
                       ";dbname=" . self::$db_name .
                       ";charset=" . self::$charset;

                $options = [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false, // real prepared statements
                ];

                self::$conn = new PDO($dsn, self::$username, self::$password, $options);
            } catch (PDOException $e) {
                die("Database Connection Failed: " . $e->getMessage());
            }
        }
        return self::$conn;
    }
}
