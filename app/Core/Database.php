<?php
namespace App\Core;

use mysqli;
use RuntimeException;

class Database {

    /**
     * @var mysqli|null
     */
    private static ?mysqli $connection = null;

    /**
     * @return mysqli
     */
    public static function getConnection(): mysqli {
        if(self::$connection !== null){
            return self::$connection;
        }
         //env 
        $host = $_ENV['DB_HOST'] ?? 'localhost';
        $user = $_ENV['DB_USER'] ?? 'root';
        $pass = $_ENV['DB_PASS'] ?? '';
        $name = $_ENV['DB_NAME'] ?? '';
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        try {
            $conn = new mysqli($host, $user, $pass, $name);
            $conn->set_charset('utf8mb4');
        } catch (\mysqli_sql_exception $e) {
            throw new RuntimeException('Database connection failed: ' . $e->getMessage());
        }

        self::$connection = $conn;
        return self::$connection;
    }
}